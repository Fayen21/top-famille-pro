#!/usr/bin/env node
/**
 * Arbre d'une bande — décomposition ADDITIVE de son écart de hauteur, maquette ↔ WordPress.
 *
 * ## Pourquoi cet outil
 *
 * `tools/composants.mjs` compare des composants appariés par empreinte, et `tools/sonde-bande.mjs`
 * donne la hauteur et le résidu de chaque bande. Ni l'un ni l'autre ne répond à la question qui
 * ferme un écart : *où passent les 360 px, exactement, et la somme des contributions fait-elle bien
 * 360 ?* Sans cette somme, on corrige une propriété plausible et l'on découvre après coup qu'elle
 * n'explique qu'un tiers de l'écart.
 *
 * La bande du formulaire de contact a mis le défaut en évidence : la sonde y range les grilles par
 * nombre d'enfants, si bien que la grille 1 de la maquette se trouvait en face d'une autre du
 * thème. Comparer par RANG, quand les deux côtés n'ont pas le même nombre d'enfants, apparie des
 * composants différents — et toute conclusion tirée de là est fausse. Cet outil n'apparie jamais
 * par rang seul.
 *
 * ## La décomposition
 *
 * Pour un nœud apparié, sa **contribution propre** est
 *
 *     contribution = ΔH(nœud) − Σ ΔH(enfants appariés)
 *
 * c'est-à-dire ce que le nœud ajoute de son propre fait : rembourrage, bordures, marges entre
 * enfants, hauteur minimale, interligne de son texte direct. Par construction, la somme des
 * contributions propres de tout l'arbre plus les hauteurs des nœuds NON appariés vaut exactement
 * l'écart de la bande. Il n'y a donc pas de reste inexpliqué : soit la somme boucle, soit
 * l'appariement est incomplet et l'outil le dit.
 *
 * ## L'appariement
 *
 * Descendant par descendant, à l'intérieur d'un couple de parents déjà appariés, dans cet ordre :
 *
 *  1. **empreinte textuelle** identique (la seule vraiment sûre : un libellé de formulaire, un
 *     intitulé, un montant) ;
 *  2. **rôle visuel + rang parmi les nœuds encore libres** de même rôle ;
 *  3. sinon : non apparié, et déclaré comme tel.
 *
 * Le rang seul n'apparie jamais. Un nœud non apparié n'est pas caché : il figure au rapport avec sa
 * hauteur entière, du côté où il existe.
 *
 * ## Usage
 *
 *   node tools/arbre-bande.mjs '#/contact' --bande=2
 *   node tools/arbre-bande.mjs '#/contact' --bande=2 --width=768 --profondeur=4
 *   node tools/arbre-bande.mjs '#/contact' --bande=2 --surcharge=/tmp/diag.css
 *   node tools/arbre-bande.mjs '#/nos-tarifs'            → la bande la plus divergente
 */
import { chromium } from '@playwright/test';
import { readFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { SRC_BANDES } from './lib/bandes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
/*
 * Une route commence par `#/`. Sans ce filtre, un `import` depuis un test capte les arguments du
 * lanceur — un chemin de fichier de test — et les prend pour une route inconnue.
 */
const hash = process.argv.slice(2).find((a) => a.startsWith('#/'));
/*
 * Importé par un test, ce module n'a pas de route à traiter : les fonctions d'appariement et de
 * décomposition sont alors les seules choses qu'on lui demande. Sans cette sortie, un `import`
 * déclencherait un relevé complet.
 */
const EN_TEST = !hash;
if (hash && !ROUTE_MAP[hash]) {
	console.error("Route inconnue. Exemple : node tools/arbre-bande.mjs '#/contact' --bande=2");
	process.exit(2);
}
const LARGEUR = Number(arg('width', '768'));
const BANDE = arg('bande', '') !== '' ? Number(arg('bande', '')) : null;
const PROFONDEUR = Number(arg('profondeur', '5'));
const SURCHARGE = arg('surcharge', '') ? readFileSync(arg('surcharge', ''), 'utf8') : '';
const SEUIL = Number(arg('seuil', '6'));
/** Sortie machine-readable, cumulée route par route : le tableau exigé pour classer les écarts. */
const JSON_SORTIE = arg('json', '');

/**
 * Relevé de l'arbre d'une bande, exécuté dans la page.
 *
 * Écrit pour tourner des deux côtés sans dépendre du balisage : la maquette n'a ni classes stables
 * ni sémantique, seul le rendu est comparable.
 */
const RELEVE = (indexBande) => {
	const brut = (el) => (el.textContent || '').replace(/\s+/g, ' ').trim();
	const empreinte = (s) =>
		(s || '')
			.normalize('NFD')
			.replace(/[̀-ͯ]/g, '')
			.toLowerCase()
			.replace(/[^a-z0-9]/g, '');

	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = window.__tfpBandes(flux);

	/** Rôle visuel : ce qu'un œil voit, indépendamment des balises et des classes. */
	const role = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
		const filet = parseFloat(s.borderTopWidth) > 0 || parseFloat(s.borderLeftWidth) > 0;
		const encadre = fond || filet || (s.boxShadow && s.boxShadow !== 'none');
		if (/^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName)) return 'champ';
		if (el.tagName === 'LABEL') return 'etiquette';
		if (el.tagName === 'BUTTON' || (el.tagName === 'A' && encadre && r.height >= 36)) return 'bouton';
		if (el.tagName === 'IMG' || el.querySelector(':scope > img, :scope > picture')) return 'media';
		if (/^H[1-6]$/.test(el.tagName)) return 'titre';
		if (el.tagName === 'FORM') return 'formulaire';
		if (el.tagName === 'TABLE') return 'tableau';
		if (parseFloat(s.borderTopLeftRadius) >= 40 && encadre && r.height <= 60) return 'pastille';
		if (encadre && r.height <= 150 && r.width <= 430) return 'micro-carte';
		if (encadre) return 'carte';
		if (s.display === 'grid' || s.display === 'flex') return 'grille';
		return 'texte';
	};

	/** Nombre réel de lignes : une ordonnée distincte, une ligne. Restreint aux feuilles de texte. */
	const lignes = (el) => {
		if (el.children.length) return 0;
		const r = [...el.getClientRects()];
		if (!r.length) return 0;
		const ys = [];
		for (const b of r) if (!ys.some((y) => Math.abs(y - b.top) < 4)) ys.push(b.top);
		return ys.length;
	};

	const nb = (v) => Math.round(parseFloat(v) * 100) / 100 || 0;

	/**
	 * Un nœud UTILE : il pèse dans la hauteur. Les enveloppes transparentes d'un seul enfant ne sont
	 * pas des nœuds — les retenir doublerait chaque niveau de l'arbre sans rien expliquer.
	 */
	const utile = (el) => {
		const r = el.getBoundingClientRect();
		if (r.height < 4 || r.width < 4) return false;
		const s = getComputedStyle(el);
		if (s.display === 'none' || s.visibility === 'hidden') return false;
		return true;
	};

	/** Enfants utiles, en sautant les enveloppes d'un seul enfant de même hauteur. */
	const enfantsDe = (el) => {
		const sortie = [];
		for (const c of el.children) {
			if (!utile(c)) continue;
			let n = c;
			// Une enveloppe qui n'ajoute rien à la hauteur n'est pas un niveau de l'arbre.
			while (
				n.children.length === 1 &&
				Math.abs(n.getBoundingClientRect().height - n.firstElementChild.getBoundingClientRect().height) < 1
			) {
				n = n.firstElementChild;
			}
			sortie.push(n);
		}
		return sortie;
	};

	const decrire = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		const enf = enfantsDe(el);
		const pistes = (s.gridTemplateColumns || '').split(' ').filter(Boolean).length;
		const rects = enf.map((c) => c.getBoundingClientRect());
		// Colonnes réellement occupées : deux enfants de même ordonnée sont sur le même rang.
		let colonnes = 0;
		if (rects.length) {
			const parY = new Map();
			for (const b of rects) {
				const y = Math.round(b.top);
				let k = [...parY.keys()].find((x) => Math.abs(x - y) < 6);
				if (k === undefined) k = y;
				parY.set(k, (parY.get(k) || 0) + 1);
			}
			colonnes = Math.max(...parY.values());
		}
		const texte = brut(el).slice(0, 46);
		return {
			role: role(el),
			balise: el.tagName.toLowerCase(),
			classes: (el.className || '').toString().trim().slice(0, 34) || null,
			texte,
			empreinte: empreinte(texte).slice(0, 34),
			h: Math.round(r.height * 100) / 100,
			w: Math.round(r.width),
			display: s.display,
			nbEnfants: enf.length,
			colonnes,
			pistes,
			gap: s.gap === 'normal' ? null : s.gap,
			padH: nb(s.paddingTop),
			padB: nb(s.paddingBottom),
			mTop: nb(s.marginTop),
			mBas: nb(s.marginBottom),
			bordH: nb(s.borderTopWidth),
			bordB: nb(s.borderBottomWidth),
			taille: nb(s.fontSize),
			interligne: nb(s.lineHeight),
			lignes: lignes(el),
			hMin: s.minHeight === 'auto' || s.minHeight === '0px' ? null : s.minHeight,
			enfants: [],
		};
	};

	const construire = (el, profondeur) => {
		const n = decrire(el);
		if (profondeur > 0) for (const c of enfantsDe(el)) n.enfants.push(construire(c, profondeur - 1));
		return n;
	};

	return {
		nbBandes: bandes.length,
		bandes: bandes.map((b, i) => ({
			i,
			h: Math.round(b.getBoundingClientRect().height),
			titre: brut(b.querySelector('h1,h2,h3') || b).slice(0, 40),
		})),
		arbre: bandes[indexBande] ? construire(bandes[indexBande], 8) : null,
	};
};

const STABILISER = async () => {
	await new Promise((r) => (document.fonts ? document.fonts.ready.then(r) : r()));
	for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
		window.scrollTo(0, y);
		await new Promise((r) => setTimeout(r, 25));
	}
	window.scrollTo(0, 0);
	await new Promise((r) => setTimeout(r, 100));
};

/* ------------------------------------------------------------------ */
/* Appariement — jamais par rang seul                                  */
/* ------------------------------------------------------------------ */

/**
 * Apparie les enfants de deux nœuds déjà appariés.
 *
 * L'empreinte textuelle d'abord : c'est le seul critère qui ne se trompe pas quand les deux côtés
 * n'ont ni le même nombre d'enfants ni le même ordre. Le rôle et le rang ne servent qu'ensuite, et
 * seulement entre nœuds de même rôle encore libres — ce qui interdit d'apparier une liste de
 * pastilles à une grille de colonnes parce qu'elles occupent le même rang.
 */
export const apparierEnfants = (a, b) => {
	const paires = [];
	const librA = a.map((_, i) => i);
	const librB = b.map((_, i) => i);

	const prendre = (i, j, critere) => {
		paires.push({ ref: a[i], wp: b[j], critere });
		librA.splice(librA.indexOf(i), 1);
		librB.splice(librB.indexOf(j), 1);
	};

	// 1. empreinte textuelle identique et non vide
	for (const i of [...librA]) {
		const e = a[i].empreinte;
		if (!e || e.length < 4) continue;
		const j = librB.find((k) => b[k].empreinte === e);
		if (j !== undefined) prendre(i, j, 'texte');
	}
	// 2. empreinte préfixe, à volume comparable — le thème corrige parfois une formulation
	for (const i of [...librA]) {
		const e = a[i].empreinte;
		if (!e || e.length < 8) continue;
		const j = librB.find((k) => {
			const f = b[k].empreinte;
			if (!f || f.length < 8) return false;
			return (e.startsWith(f) || f.startsWith(e)) && Math.max(e.length, f.length) / Math.min(e.length, f.length) < 2;
		});
		if (j !== undefined) prendre(i, j, 'préfixe');
	}
	// 3. même rôle, rang parmi les nœuds ENCORE LIBRES de ce rôle
	for (const role of [...new Set(a.map((x) => x.role))]) {
		const ia = librA.filter((i) => a[i].role === role);
		const ib = librB.filter((j) => b[j].role === role);
		for (let k = 0; k < Math.min(ia.length, ib.length); k++) prendre(ia[k], ib[k], 'rôle+rang');
	}
	/*
	 * 4. **à travers une enveloppe ajoutée d'un seul côté.**
	 *
	 * Un côté peut envelopper un composant dans un conteneur qui porte AUSSI d'autre contenu :
	 * le thème range le formulaire de contact dans une colonne qui contient en plus deux intitulés,
	 * deux paragraphes, un bouton et une mention légale, quand la maquette met le formulaire seul.
	 * Les deux nœuds ne s'apparient alors ni par texte ni par rôle, et l'outil attribuait les 399 px
	 * de la colonne à la colonne elle-même — c'est-à-dire à rien d'identifiable.
	 *
	 * On cherche donc, parmi les DESCENDANTS d'un nœud libre, celui qui correspond au nœud libre de
	 * l'autre côté. La paire est alors formée sur le composant réel, et l'enveloppe est signalée
	 * comme telle avec le contenu qu'elle ajoute : c'est la différence entre « la colonne est trop
	 * haute » et « la colonne porte 272 px de contenu que la maquette n'a pas ».
	 */
	const descendants = (n, d = 3) => {
		if (d === 0) return [];
		const out = [];
		for (const c of n.enfants) {
			out.push(c);
			out.push(...descendants(c, d - 1));
		}
		return out;
	};
	const enveloppes = [];
	/*
	 * Rôles STRUCTURELS : un formulaire reste un formulaire même si ses libellés diffèrent des deux
	 * côtés — le thème y ajoute un piège à robots et une astérisque d'obligation. Exiger l'empreinte
	 * ici empêcherait tout appariement, et c'est ce qui laissait 399 px attribués à une enveloppe.
	 * Pour les rôles non structurels, l'empreinte reste exigée : sans elle, deux textes quelconques
	 * s'apparieraient.
	 */
	const STRUCTUREL = new Set(['formulaire', 'tableau', 'media', 'grille', 'carte']);
	for (const i of [...librA]) {
		for (const j of [...librB]) {
			if (!librB.includes(j) || !librA.includes(i)) continue;
			const candidats = descendants(b[j]).filter((x) => x.role === a[i].role);
			const cible = STRUCTUREL.has(a[i].role)
				? // le descendant de hauteur la plus proche : deux formulaires imbriqués n'existent pas,
					// mais deux grilles si, et c'est la plus comparable qu'on veut
					candidats.sort((x, y) => Math.abs(x.h - a[i].h) - Math.abs(y.h - a[i].h))[0]
				: candidats.find((x) => x.empreinte && x.empreinte === a[i].empreinte);
			if (!cible) continue;
			paires.push({ ref: a[i], wp: cible, critere: 'à travers enveloppe' });
			enveloppes.push({ cote: 'wp', enveloppe: b[j], interne: cible, ref: a[i] });
			librA.splice(librA.indexOf(i), 1);
			librB.splice(librB.indexOf(j), 1);
			break;
		}
	}
	return {
		paires,
		enveloppes,
		seulRef: librA.map((i) => a[i]),
		seulWp: librB.map((j) => b[j]),
	};
};

/**
 * Décompose l'écart de hauteur d'un couple de nœuds appariés.
 *
 * Renvoie la liste des lignes de décomposition. La somme des `contribution` de toutes les lignes,
 * plus les hauteurs des nœuds non appariés, vaut exactement l'écart du nœud racine.
 */
export const decomposer = (ref, wp, chemin, profondeur, lignes) => {
	const { paires, enveloppes, seulRef, seulWp } = apparierEnfants(ref.enfants, wp.enfants);
	const deltaEnfantsApparies = paires.reduce((n, p) => n + (p.wp.h - p.ref.h), 0);
	const hSeulRef = seulRef.reduce((n, x) => n + x.h, 0);
	const hSeulWp = seulWp.reduce((n, x) => n + x.h, 0);
	// Contribution PROPRE : ce que le nœud ajoute de son fait, hors ses enfants appariés.
	const propre = wp.h - ref.h - deltaEnfantsApparies;

	lignes.push({
		chemin,
		role: wp.role,
		classes: wp.classes,
		texte: wp.texte,
		hRef: ref.h,
		hWp: wp.h,
		delta: Math.round((wp.h - ref.h) * 10) / 10,
		propre: Math.round(propre * 10) / 10,
		// Ce qui explique la contribution propre, quand il y a de quoi l'expliquer.
		causes: [
			ref.padH !== wp.padH ? `rembourrage haut ${ref.padH}→${wp.padH}` : null,
			ref.padB !== wp.padB ? `rembourrage bas ${ref.padB}→${wp.padB}` : null,
			ref.mTop !== wp.mTop ? `marge haute ${ref.mTop}→${wp.mTop}` : null,
			ref.mBas !== wp.mBas ? `marge basse ${ref.mBas}→${wp.mBas}` : null,
			ref.bordH !== wp.bordH || ref.bordB !== wp.bordB ? `filet ${ref.bordH}/${ref.bordB}→${wp.bordH}/${wp.bordB}` : null,
			ref.gap !== wp.gap ? `écart ${ref.gap}→${wp.gap}` : null,
			ref.colonnes !== wp.colonnes ? `colonnes ${ref.colonnes}→${wp.colonnes}` : null,
			ref.taille !== wp.taille ? `police ${ref.taille}→${wp.taille}` : null,
			ref.interligne !== wp.interligne ? `interligne ${ref.interligne}→${wp.interligne}` : null,
			ref.lignes !== wp.lignes && (ref.lignes || wp.lignes) ? `lignes ${ref.lignes}→${wp.lignes}` : null,
			ref.hMin !== wp.hMin ? `hauteur minimale ${ref.hMin}→${wp.hMin}` : null,
			ref.w !== wp.w ? `largeur ${ref.w}→${wp.w}` : null,
		].filter(Boolean),
		seulRef: seulRef.map((x) => ({ role: x.role, texte: x.texte, h: x.h })),
		seulWp: seulWp.map((x) => ({ role: x.role, texte: x.texte, h: x.h, classes: x.classes })),
		hSeulRef,
		hSeulWp,
		// Une enveloppe ajoutée d'un seul côté : ce qu'elle contient EN PLUS du composant apparié.
		enveloppes: (enveloppes || []).map((e) => ({
			enveloppe: e.enveloppe.classes || e.enveloppe.balise,
			h: e.enveloppe.h,
			interne: e.interne.role + ' ' + e.interne.h + 'px',
			supplement: Math.round((e.enveloppe.h - e.interne.h) * 10) / 10,
			contenu: e.enveloppe.enfants
				.filter((x) => x !== e.interne)
				.map((x) => `${x.role} ${Math.round(x.h)}px « ${x.texte.slice(0, 34)} »`),
		})),
	});

	/*
	 * Chaque enfant apparié DOIT donner une ligne, qu'on descende dedans ou non.
	 *
	 * L'identité de bouclage est `Δ(nœud) = propre(nœud) + Σ Δ(enfants appariés)`. En s'arrêtant sans
	 * rien reporter, le Δ de l'enfant est retiré du propre du parent et n'est jamais réintroduit : la
	 * somme est alors courte de ce Δ, et l'outil annonce un reste inexpliqué qui n'existe pas.
	 * Un enfant dans lequel on ne descend pas est traité en FEUILLE — son propre vaut son Δ entier.
	 */
	for (const p of [...paires].sort((x, y) => Math.abs(y.wp.h - y.ref.h) - Math.abs(x.wp.h - x.ref.h))) {
		const cheminEnfant = chemin + ' › ' + (p.wp.classes || p.wp.balise);
		const descendable = profondeur > 0 && (p.ref.enfants.length || p.wp.enfants.length);
		if (descendable) {
			decomposer(p.ref, p.wp, cheminEnfant, profondeur - 1, lignes);
		} else {
			feuille(p.ref, p.wp, cheminEnfant, lignes);
		}
	}
	return lignes;
};

/** Une feuille : tout son écart de hauteur lui est propre, faute d'enfant apparié en dessous. */
const feuille = (ref, wp, chemin, lignes) => {
	lignes.push({
		chemin,
		role: wp.role,
		classes: wp.classes,
		texte: wp.texte,
		hRef: ref.h,
		hWp: wp.h,
		delta: Math.round((wp.h - ref.h) * 10) / 10,
		propre: Math.round((wp.h - ref.h) * 10) / 10,
		causes: [
			ref.padH !== wp.padH ? `rembourrage haut ${ref.padH}→${wp.padH}` : null,
			ref.padB !== wp.padB ? `rembourrage bas ${ref.padB}→${wp.padB}` : null,
			ref.mTop !== wp.mTop ? `marge haute ${ref.mTop}→${wp.mTop}` : null,
			ref.mBas !== wp.mBas ? `marge basse ${ref.mBas}→${wp.mBas}` : null,
			ref.taille !== wp.taille ? `police ${ref.taille}→${wp.taille}` : null,
			ref.interligne !== wp.interligne ? `interligne ${ref.interligne}→${wp.interligne}` : null,
			ref.lignes !== wp.lignes && (ref.lignes || wp.lignes) ? `lignes ${ref.lignes}→${wp.lignes}` : null,
			ref.hMin !== wp.hMin ? `hauteur minimale ${ref.hMin}→${wp.hMin}` : null,
			ref.bordH !== wp.bordH || ref.bordB !== wp.bordB ? `filet ${ref.bordH}/${ref.bordB}→${wp.bordH}/${wp.bordB}` : null,
		].filter(Boolean),
		seulRef: [],
		seulWp: [],
		enveloppes: [],
		hSeulRef: 0,
		hSeulWp: 0,
	});
};

/* ------------------------------------------------------------------ */
/* Relevé                                                             */
/* ------------------------------------------------------------------ */

if (EN_TEST) {
	// rien à relever : le module est importé pour ses fonctions
} else {
const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

const cote = async (url, hashRoute, indexBande) => {
	const p = await navigateur.newPage({ viewport: { width: LARGEUR, height: 900 } });
	await p.addInitScript(SRC_BANDES);
	await p.goto(url, { waitUntil: hashRoute ? 'load' : 'networkidle', timeout: 90000 });
	if (hashRoute) {
		await p.waitForTimeout(3500);
		await p.evaluate((h) => {
			location.hash = h.replace(/^#/, '');
		}, hashRoute);
		await p.waitForTimeout(1100);
	}
	if (!hashRoute && SURCHARGE) await p.addStyleTag({ content: SURCHARGE });
	await p.evaluate(STABILISER);
	const r = await p.evaluate(RELEVE, indexBande);
	await p.close();
	return r;
};

/* Sans --bande, on prend la bande la plus divergente : c'est celle qu'on veut voir. */
let index = BANDE;
if (index === null) {
	const a = await cote(REF, hash, 0);
	const b = await cote(WP + ROUTE_MAP[hash].wp, null, 0);
	let pire = 0;
	let max = -1;
	for (let i = 0; i < Math.min(a.bandes.length, b.bandes.length); i++) {
		const d = Math.abs(b.bandes[i].h - a.bandes[i].h);
		if (d > max) {
			max = d;
			pire = i;
		}
	}
	index = pire;
	console.log(`bande la plus divergente : ${index} (écart ${max} px)\n`);
}

const A = await cote(REF, hash, index);
const B = await cote(WP + ROUTE_MAP[hash].wp, null, index);
await navigateur.close();

if (!A.arbre || !B.arbre) {
	console.error(`Bande ${index} absente d'un des deux côtés (réf ${A.nbBandes} bandes, wp ${B.nbBandes}).`);
	process.exit(1);
}

console.log(`${hash} → ${ROUTE_MAP[hash].wp}  ·  ${LARGEUR} px  ·  bande ${index}${SURCHARGE ? '  [surcharge injectée]' : ''}`);
console.log(`écart de la bande : ${A.arbre.h} → ${B.arbre.h} px  =  ${Math.round((B.arbre.h - A.arbre.h) * 10) / 10} px\n`);

const lignes = decomposer(A.arbre, B.arbre, 'bande', PROFONDEUR, []);

/* ------------------------------------------------------------------ */
/* Rapport                                                            */
/* ------------------------------------------------------------------ */

const marquantes = lignes.filter((l) => Math.abs(l.propre) >= SEUIL || l.seulRef.length || l.seulWp.length);
console.log('Contributions PROPRES, du plus lourd au plus léger — hors enfants appariés :');
console.log('  contrib.   h réf → h wp   nœud');
for (const l of [...marquantes].sort((x, y) => Math.abs(y.propre) - Math.abs(x.propre))) {
	console.log(
		`  ${(l.propre > 0 ? '+' : '') + l.propre}`.padEnd(11) +
			`${l.hRef} → ${l.hWp}`.padEnd(16) +
			`${l.role} ${l.classes || l.chemin.split(' › ').pop()}`
	);
	if (l.causes.length) console.log('             ' + l.causes.join(' · '));
	if (l.texte) console.log('             « ' + l.texte + ' »');
	for (const x of l.seulRef) console.log(`             NON APPARIÉ côté maquette : ${x.role} ${x.h}px « ${x.texte} »`);
	for (const x of l.seulWp) console.log(`             NON APPARIÉ côté thème    : ${x.role} ${x.h}px ${x.classes || ''} « ${x.texte} »`);
	for (const e of l.enveloppes || []) {
		console.log(`             ENVELOPPE du thème « ${e.enveloppe} » ${e.h}px autour de ${e.interne} → +${e.supplement}px de contenu en plus :`);
		for (const c of e.contenu) console.log(`               · ${c}`);
	}
}

const sommePropre = lignes.reduce((n, l) => n + l.propre, 0);
const sommeSeulWp = lignes.reduce((n, l) => n + l.hSeulWp, 0);
const sommeSeulRef = lignes.reduce((n, l) => n + l.hSeulRef, 0);
const attendu = B.arbre.h - A.arbre.h;
/*
 * Contrôle de bouclage. La somme des contributions propres vaut l'écart de la bande dès que
 * l'appariement est complet ; les nœuds non appariés y entrent par leur hauteur entière, déjà
 * comptée dans la contribution propre de leur parent. Un reste non nul signale un appariement
 * incomplet, et il faut le dire plutôt que de conclure.
 */
console.log(
	`\nBouclage : Σ contributions propres = ${Math.round(sommePropre * 10) / 10} px · écart de bande = ${Math.round(attendu * 10) / 10} px · ` +
		`reste ${Math.round((sommePropre - attendu) * 10) / 10} px`
);
console.log(
	`Nœuds non appariés : ${Math.round(sommeSeulRef)} px côté maquette, ${Math.round(sommeSeulWp)} px côté thème ` +
		`(déjà compris dans la contribution propre de leur parent)`
);
if (Math.abs(sommePropre - attendu) > 1) {
	console.log('⚠️  Le bouclage ne se fait pas : la décomposition est incomplète, ne pas conclure.');
}

/*
 * Cumul machine-readable. Le fichier est relu puis réécrit à chaque route : un seul producteur à la
 * fois, jamais deux passes concurrentes vers la même sortie.
 */
if (JSON_SORTIE) {
	const { readFileSync: lire, writeFileSync: ecrire, existsSync: existe } = await import('node:fs');
	const tout = existe(JSON_SORTIE) ? JSON.parse(lire(JSON_SORTIE, 'utf8')) : {};
	const top = [...lignes].sort((x, y) => Math.abs(y.propre) - Math.abs(x.propre)).slice(0, 3);
	tout[hash] = {
		largeur: LARGEUR,
		bande: index,
		hauteurBandeRef: A.arbre.h,
		hauteurBandeWp: B.arbre.h,
		deltaBande: Math.round(attendu * 10) / 10,
		bouclage: Math.round((sommePropre - attendu) * 10) / 10,
		troisPlusFortesContributions: top.map((l) => ({
			contribution: l.propre,
			role: l.role,
			selecteur: l.classes || l.chemin.split(' › ').pop(),
			hRef: l.hRef,
			hWp: l.hWp,
			causes: l.causes,
			contenuEnPlusDuTheme: (l.enveloppes || []).flatMap((e) => e.contenu),
			supplementEnveloppe: (l.enveloppes || []).reduce((n, e) => n + e.supplement, 0) || null,
		})),
	};
	ecrire(JSON_SORTIE, JSON.stringify(tout, null, 1) + '\n');
	console.log(`\n${JSON_SORTIE} — ${Object.keys(tout).length} routes cumulées`);
}
}
