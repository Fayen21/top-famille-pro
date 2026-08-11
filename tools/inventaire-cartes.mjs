#!/usr/bin/env node
/**
 * Inventaire des cartes des 53 routes — maquette Claude Design ↔ WordPress.
 *
 * Les outils précédents comparaient des hauteurs, des textes et des styles. Aucun ne répondait à la
 * question qui reste : **la maquette découpe-t-elle son contenu en autant de cartes que le thème ?**
 * Une page peut contenir toutes les phrases du prototype, faire la même hauteur, et présenter huit
 * contraintes dans deux gros pavés là où la maquette en fait huit micro-cartes. Le contenu est là,
 * l'écran est faux.
 *
 * Cet outil relève donc, des deux côtés, **chaque carte** : son archétype, sa section, son titre,
 * son texte, ses médias, sa géométrie, sa place dans la grille, et son comportement aux deux
 * largeurs. Il en déduit quatre familles d'anomalies, nommées :
 *
 *  - **carte absente** — la maquette en a une que WordPress n'a pas ;
 *  - **cartes fusionnées** — plusieurs cartes de la maquette rendues dans un seul conteneur ;
 *  - **carte supplémentaire** — WordPress en a une que la maquette n'a pas ;
 *  - **mauvais type / mauvais nombre de colonnes** — la carte existe mais pas sous la bonne forme.
 *
 * Une carte n'est jamais comptée pour son conteneur : un bloc qui contient visuellement plusieurs
 * micro-cartes compte pour ses enfants, pas pour lui-même (voir `retirerConteneurs`).
 *
 * Usage :
 *   node tools/inventaire-cartes.mjs
 *   node tools/inventaire-cartes.mjs --only='#/service/cabinets,#/nettoyage-professionnel'
 *   node tools/inventaire-cartes.mjs --widths=1440
 *   node tools/inventaire-cartes.mjs --detail='#/service/cabinets'   → liste carte par carte
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const RAPPORT = 'docs/INVENTAIRE-CARTES-53-ROUTES.md';

const arg = (n) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1];
const seules = arg('only') ? arg('only').split(',').map((s) => s.trim()).filter(Boolean) : null;
const detail = arg('detail');
const widths = (arg('widths') || '1440,375').split(',').map(Number);

/**
 * Relevé de toutes les cartes d'une page.
 *
 * Écrit pour tourner dans le navigateur, des deux côtés, sans dépendre du balisage : la maquette
 * n'a ni classes stables ni sémantique, on ne peut donc reconnaître une carte qu'à son rendu.
 */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	// Conteneur du flux de page : le plus proche ancêtre du H1 portant plusieurs `<section>`.
	// En-tête, pré-pied et pied de page sont hors sujet : ils sont identiques sur les 53 routes.
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}

	const sections = [...flux.children].filter((c) => c.getBoundingClientRect().height >= 20);
	/** Index de la bande qui contient un élément — sert à situer chaque carte. */
	const bandeDe = (el) => {
		for (let i = 0; i < sections.length; i++) if (sections[i].contains(el)) return i + 1;
		return 0;
	};

	/**
	 * Une carte est un bloc **visuellement détaché** : arrondi, et distingué du fond par une
	 * couleur de fond propre, un filet ou une ombre. Le seuil de 6 px de rayon écarte les
	 * arrondis de confort (champs de formulaire, boutons) sans écarter les micro-cartes, dont le
	 * rayon descend à 8 px dans la maquette.
	 */
	const estCarte = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		if (r.width < 60 || r.height < 24) return false;
		if (s.display === 'none' || s.visibility === 'hidden') return false;
		const rayon = parseFloat(s.borderTopLeftRadius) || 0;
		const filet = parseFloat(s.borderTopWidth) || 0;
		const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
		const ombre = s.boxShadow && s.boxShadow !== 'none';
		return rayon >= 6 && (fond || filet > 0 || ombre);
	};

	// Les boutons et les liens d'action ne sont pas des cartes : ils sont arrondis et colorés, mais
	// ils appartiennent au vocabulaire des commandes, pas à celui des blocs de contenu.
	const estCommande = (el) => {
		const t = el.tagName.toLowerCase();
		if (t === 'button' || t === 'input' || t === 'select' || t === 'textarea') return true;
		if (t === 'a') {
			const r = el.getBoundingClientRect();
			// Un lien peut être une vraie carte cliquable (tuile de prestation) : on ne l'écarte que
			// s'il est petit et sur une seule ligne, c'est-à-dire s'il se comporte comme un bouton.
			return r.height <= 64 && el.children.length <= 2 && txt(el).length <= 40;
		}
		return false;
	};

	let candidats = [...flux.querySelectorAll('*')].filter((el) => estCarte(el) && !estCommande(el));

	/*
	 * Retire les conteneurs : si une carte contient elle-même d'autres cartes qui occupent
	 * l'essentiel de sa surface, c'est une bande décorée, pas une carte. Sans cette règle, une
	 * grille de huit micro-cartes posée sur un fond arrondi compterait pour neuf.
	 *
	 * Le critère est surfacique et non structurel : une carte peut légitimement en contenir une
	 * autre (une carte de scénario avec un encadré à l'intérieur), tant que l'enfant ne remplit pas
	 * le parent.
	 */
	const aire = (el) => {
		const r = el.getBoundingClientRect();
		return r.width * r.height;
	};
	const retirerConteneurs = (liste) =>
		liste.filter((el) => {
			const enfants = liste.filter((x) => x !== el && el.contains(x));
			if (!enfants.length) return true;
			// Ne garder que les enfants directs au sens de la liste (pas les petits-enfants).
			const directs = enfants.filter((x) => !enfants.some((y) => y !== x && y.contains(x)));
			if (directs.length < 2) return true;
			const occupe = directs.reduce((n, x) => n + aire(x), 0) / Math.max(1, aire(el));
			return occupe < 0.72;
		});
	candidats = retirerConteneurs(candidats);

	/**
	 * Archétype d'une carte, déduit de ce qu'elle contient et de son apparence.
	 *
	 * La nomenclature n'est pas inventée : chaque nom correspond à une composition réellement
	 * employée par la maquette, et le classement se fait sur le rendu mesuré.
	 */
	const archetype = (el) => {
		const s = getComputedStyle(el);
		const t = txt(el);
		const img = el.querySelector('img,picture,svg');
		/*
		 * **Faux positif corrigé.** Le classement se faisait sur les balises (`h2,h3,h4,strong,b`),
		 * alors que le contrat de cet outil est de classer sur le **rendu**. La maquette compose ses
		 * intitulés de carte en `div` nu ; le thème emploie `strong` ou `h3` selon ce que fait le
		 * prototype, ce qui est plus juste sémantiquement. Résultat : à écran identique, la référence
		 * était classée `micro-carte` et le thème `carte-titre`, sur 115 cartes.
		 *
		 * Un intitulé est donc reconnu à ce qui le distingue visuellement du corps de la carte :
		 * une graisse d'au moins 600, ou une taille supérieure à celle du texte courant de la carte.
		 */
		const tailleCorps = parseFloat(getComputedStyle(el).fontSize) || 16;
		const titre = [...el.querySelectorAll('*')].find((x) => {
			if (!(x.textContent || '').trim()) return false;
			const xs = getComputedStyle(x);
			return (parseInt(xs.fontWeight, 10) || 400) >= 600 || parseFloat(xs.fontSize) > tailleCorps + 0.5;
		});
		const numero = [...el.children].some((c) => /^\d{1,2}$/.test(txt(c)) && parseFloat(getComputedStyle(c).fontSize) >= 18);
		const etoiles = /★{3,}/.test(t);
		const citation = !!el.querySelector('blockquote') || /^[«"]/.test(t);
		const details = el.tagName.toLowerCase() === 'details' || !!el.querySelector('summary');
		const prix = /\d+[\s ]*€/.test(t);
		const fond = s.backgroundColor;
		const sombre = /rgb\((\d+), (\d+), (\d+)\)/.test(fond) && (() => {
			const [r, g, b] = fond.match(/\d+/g).map(Number);
			return 0.299 * r + 0.587 * g + 0.114 * b < 128;
		})();
		const barre = parseFloat(s.borderLeftWidth) >= 3 && parseFloat(s.borderTopWidth) < 3;
		const pastille = parseFloat(s.borderTopLeftRadius) >= 40 || /^\d+(\.\d+)?px$/.test(s.borderRadius) === false;
		const r = el.getBoundingClientRect();

		if (details) return 'faq';
		if (barre) return 'encadre-barre';
		if (etoiles && citation) return 'temoignage';
		if (numero) return 'etape';
		if (prix && (titre || sombre)) return 'tarif';
		if (img && r.height > 160) return 'carte-image';
		if (sombre) return 'carte-sombre';
		if (parseFloat(s.borderTopLeftRadius) >= 999 || (r.height <= 44 && t.length <= 42)) return 'chip';
		if (img) return 'carte-icone';
		if (titre && t.length > 90) return 'carte-titre-texte';
		if (titre) return 'carte-titre';
		return 'micro-carte';
	};

	/**
	 * Nombre de colonnes du rang où se trouve la carte, mesuré sur ses sœurs de même ordonnée.
	 *
	 * On remonte d'abord les **wrappers techniques** : un élément qui n'a qu'un seul enfant et
	 * n'apporte ni fond, ni filet, ni rayon n'est pas un niveau de mise en page. C'est le cas d'un
	 * `<li>` autour d'une tuile — balisage juste pour une liste de liens, mais qui ferait mesurer
	 * « une colonne » à une grille qui en a six. Le wrapper n'est jamais compté comme une carte ;
	 * il n'est pas non plus pris pour le conteneur de grille.
	 */
	const colonnesDuRang = (el) => {
		let cible = el;
		for (let i = 0; i < 3; i++) {
			const p = cible.parentElement;
			if (!p || p.children.length !== 1) break;
			const s = getComputedStyle(p);
			const nu =
				parseFloat(s.borderTopLeftRadius) < 6 &&
				parseFloat(s.borderTopWidth) === 0 &&
				(s.backgroundColor === 'rgba(0, 0, 0, 0)' || s.backgroundColor === 'transparent');
			if (!nu) break;
			cible = p;
		}
		const parent = cible.parentElement;
		if (!parent) return 1;
		el = cible;
		const y = Math.round(el.getBoundingClientRect().top);
		const soeurs = [...parent.children].filter(
			(c) => Math.abs(Math.round(c.getBoundingClientRect().top) - y) <= 8 && c.getBoundingClientRect().height > 20
		);
		return Math.max(1, soeurs.length);
	};

	return {
		sections: sections.length,
		cartes: candidats
			.map((el) => {
				const s = getComputedStyle(el);
				const r = el.getBoundingClientRect();
				const titre = el.querySelector('h2,h3,h4,strong,b');
				const parent = el.parentElement ? getComputedStyle(el.parentElement) : null;
				return {
					type: archetype(el),
					bande: bandeDe(el),
					titre: txt(titre).slice(0, 60),
					texte: txt(el).slice(0, 90),
					image: !!el.querySelector('img,picture'),
					icone: !!el.querySelector('svg') || /^[\p{Emoji_Presentation}\p{Extended_Pictographic}☎★✓✕]/u.test(txt(el)),
					fond: s.backgroundColor,
					filet: s.borderTopWidth + ' ' + s.borderTopStyle,
					rayon: s.borderTopLeftRadius,
					ombre: (s.boxShadow || 'none').slice(0, 30),
					padding: s.padding,
					w: Math.round(r.width),
					h: Math.round(r.height),
					colonnes: colonnesDuRang(el),
					grille: parent ? (parent.gridTemplateColumns || 'none').split(' ').length : 0,
					span: s.gridColumn && s.gridColumn !== 'auto' ? s.gridColumn : '',
					align: s.textAlign,
					gap: parent ? parent.gap || 'normal' : 'normal',
					y: Math.round(r.top + window.scrollY),
				};
			})
			// Ordre de lecture : c'est celui qui compte pour dire « même ordre ».
			.sort((a, b) => a.y - b.y),
	};
};

/* ------------------------------------------------------------------ */
/* Appariement et diagnostic                                           */
/* ------------------------------------------------------------------ */

/**
 * Empreinte de contenu, pour apparier une carte de la maquette à sa contrepartie WordPress.
 *
 * Volontairement brutale : on retire **tout** ce qui n'est ni lettre ni chiffre. Le prototype
 * concatène ses nœuds sans espace (« À partir de27 € HT/h ») là où le thème en met un, accole le
 * « + » des accordéons à la question, et emploie des apostrophes typographiques. Comparer des
 * chaînes « normalisées à l'espace près » produisait des dizaines de fausses cartes absentes.
 */
const norm = (s) =>
	(s || '')
		.normalize('NFD')
		.replace(/[\u0300-\u036f]/g, '')
		.toLowerCase()
		.replace(/[^a-z0-9]/g, '');

/**
 * Apparie les cartes des deux côtés, dans l'ordre, sur leur contenu.
 *
 * L'appariement se fait sur le texte, seul élément commun fiable : ni les classes ni la structure
 * ne survivent au passage de la maquette au thème. Une carte de la maquette dont le texte se
 * retrouve **à l'intérieur** d'une carte WordPress plus grosse est une **fusion** — c'est le cas
 * que l'on cherche à débusquer, et il ne se voit sur aucune autre mesure.
 */
function diagnostiquer(ref, wp) {
	const restants = wp.cartes.map((c, i) => ({ ...c, i, pris: false }));
	const anomalies = [];
	const apparies = [];

	for (const a of ref.cartes) {
		const cle = norm(a.texte).slice(0, 48);
		if (!cle) continue;

		// 1. Correspondance exacte : une carte WordPress dont le texte commence pareil.
		let b = restants.find((x) => !x.pris && norm(x.texte).slice(0, 48) === cle);

		// 2. Sinon, une carte WordPress qui contient ce texte : c'est une fusion.
		let fusion = null;
		if (!b) {
			fusion = restants.find((x) => !x.pris && norm(x.texte).includes(cle.slice(0, 32)) && cle.length > 12);
			if (!fusion) {
				// 3. Ou bien la carte n'existe pas du tout côté WordPress.
				anomalies.push({ genre: 'absente', type: a.type, bande: a.bande, texte: a.texte.slice(0, 70) });
				continue;
			}
		}

		if (fusion) {
			anomalies.push({
				genre: 'fusionnee',
				type: a.type,
				bande: a.bande,
				texte: a.texte.slice(0, 70),
				dans: fusion.texte.slice(0, 50),
			});
			continue;
		}

		b.pris = true;
		apparies.push([a, b]);
		if (a.type !== b.type) {
			anomalies.push({ genre: 'type', type: a.type, recu: b.type, bande: a.bande, texte: a.texte.slice(0, 60) });
		} else if (a.colonnes !== b.colonnes) {
			anomalies.push({
				genre: 'colonnes',
				type: a.type,
				bande: a.bande,
				texte: a.texte.slice(0, 60),
				attendu: a.colonnes,
				recu: b.colonnes,
			});
		}
	}

	for (const x of restants) {
		if (!x.pris) anomalies.push({ genre: 'surplus', type: x.type, bande: x.bande, texte: x.texte.slice(0, 70) });
	}

	return { anomalies, apparies };
}

/* ------------------------------------------------------------------ */

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const routes = Object.keys(ROUTE_MAP).filter((r) => !seules || seules.includes(r));
const resultats = {};

for (const largeur of widths) {
	const ref = await browser.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const wp = await browser.newPage({ viewport: { width: largeur, height: 900 } });

	for (const hash of routes) {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		const a = await ref.evaluate(RELEVE);

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		const b = await wp.evaluate(RELEVE);

		const d = diagnostiquer(a, b);
		(resultats[hash] ||= {})[largeur] = { ref: a, wp: b, ...d };

		const graves = d.anomalies.filter((x) => x.genre === 'absente' || x.genre === 'fusionnee').length;
		console.log(
			`${(graves ? '❌' : d.anomalies.length ? '⚠️ ' : '✅').padEnd(3)} ${String(largeur).padStart(4)}px ${hash.padEnd(42)} ` +
				`cartes ${String(a.cartes.length).padStart(3)} → ${String(b.cartes.length).padStart(3)} · ` +
				`${d.anomalies.length} anomalie(s)` +
				(graves ? ` dont ${graves} grave(s)` : '')
		);

		if (detail === hash && largeur === widths[0]) {
			console.log('\n  ── Maquette ──');
			for (const c of a.cartes) console.log(`   b${c.bande} ${c.type.padEnd(18)} ${c.colonnes}col ${c.w}×${c.h} ${c.rayon} ${c.fond} · ${c.texte.slice(0, 60)}`);
			console.log('  ── WordPress ──');
			for (const c of b.cartes) console.log(`   b${c.bande} ${c.type.padEnd(18)} ${c.colonnes}col ${c.w}×${c.h} ${c.rayon} ${c.fond} · ${c.texte.slice(0, 60)}`);
			console.log('  ── Anomalies ──');
			for (const x of d.anomalies) console.log(`   ${x.genre.padEnd(11)} ${(x.type || '').padEnd(18)} ${x.texte || ''}${x.dans ? ' → dans « ' + x.dans + ' »' : ''}${x.attendu ? ` (${x.attendu} → ${x.recu} col)` : ''}${x.recu && !x.attendu ? ' → ' + x.recu : ''}`);
			console.log('');
		}
	}
	await ref.close();
	await wp.close();
}
await browser.close();

/* ------------------------------------------------------------------ */
/* Rapport                                                             */
/* ------------------------------------------------------------------ */

const L = [];
L.push('# Inventaire des cartes — maquette Claude Design ↔ WordPress');
L.push('');
L.push('> Fichier **généré** par `node tools/inventaire-cartes.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Une page peut contenir toutes les phrases du prototype, faire la même hauteur, et présenter');
L.push('> huit contraintes dans deux gros pavés là où la maquette en fait huit micro-cartes. Cet');
L.push('> inventaire relève **chaque carte** des deux côtés — archétype, bande, titre, texte, médias,');
L.push('> géométrie, colonnes — et nomme quatre familles d’anomalies : carte **absente**, cartes');
L.push('> **fusionnées**, carte **supplémentaire**, mauvais **type** ou mauvais nombre de **colonnes**.');
L.push('>');
L.push('> Un conteneur qui contient visuellement plusieurs micro-cartes n’est jamais compté pour une');
L.push('> carte : il compte pour ses enfants.');
L.push('');

const grave = (r) => r.anomalies.filter((x) => x.genre === 'absente' || x.genre === 'fusionnee').length;
const totalGraves = Object.values(resultats).reduce((n, p) => n + Object.values(p).reduce((m, r) => m + grave(r), 0), 0);
const totalAnos = Object.values(resultats).reduce((n, p) => n + Object.values(p).reduce((m, r) => m + r.anomalies.length, 0), 0);

L.push(`**${routes.length} routes × ${widths.length} largeurs · ${totalAnos} anomalie(s), dont ${totalGraves} grave(s)** (carte absente ou fusionnée).`);
L.push('');

L.push('## Synthèse');
L.push('');
L.push('| Route | ' + widths.map((w) => `Cartes ${w} px`).join(' | ') + ' | ' + widths.map((w) => `Anomalies ${w} px`).join(' | ') + ' |');
L.push('|---|' + widths.map(() => '---').join('|') + '|' + widths.map(() => '---').join('|') + '|');
for (const hash of routes) {
	const cartes = widths.map((w) => {
		const r = resultats[hash][w];
		const d = r.wp.cartes.length - r.ref.cartes.length;
		return `${r.ref.cartes.length} → ${r.wp.cartes.length}${d ? ` (${d > 0 ? '+' : ''}${d})` : ''}`;
	});
	const anos = widths.map((w) => {
		const r = resultats[hash][w];
		const g = grave(r);
		return g ? `❌ ${r.anomalies.length} (${g})` : r.anomalies.length ? `⚠️ ${r.anomalies.length}` : '✅';
	});
	L.push(`| \`${hash}\` | ${cartes.join(' | ')} | ${anos.join(' | ')} |`);
}
L.push('');

L.push('## Routes à corriger en priorité');
L.push('');
const prioritaires = routes
	.map((h) => ({ h, g: grave(resultats[h][widths[0]]), a: resultats[h][widths[0]].anomalies.length }))
	.filter((x) => x.g > 0)
	.sort((x, y) => y.g - x.g);
if (!prioritaires.length) {
	L.push('Aucune : aucune carte absente ni fusionnée à ' + widths[0] + ' px.');
} else {
	L.push('| Route | Cartes absentes ou fusionnées | Anomalies totales |');
	L.push('|---|---|---|');
	for (const x of prioritaires) L.push(`| \`${x.h}\` | ${x.g} | ${x.a} |`);
}
L.push('');

L.push('## Archétypes employés par la maquette');
L.push('');
const parType = new Map();
for (const h of routes) {
	for (const c of resultats[h][widths[0]].ref.cartes) parType.set(c.type, (parType.get(c.type) || 0) + 1);
}
L.push('| Archétype | Occurrences dans la maquette |');
L.push('|---|---|');
for (const [t, n] of [...parType.entries()].sort((a, b) => b[1] - a[1])) L.push(`| \`${t}\` | ${n} |`);
L.push('');

L.push('## Détail par route');
L.push('');
for (const hash of routes) {
	const r0 = resultats[hash][widths[0]];
	L.push(`### \`${hash}\` → \`${ROUTE_MAP[hash].wp}\``);
	L.push('');
	for (const w of widths) {
		const r = resultats[hash][w];
		L.push(
			`**${w} px** — bandes ${r.ref.sections} → ${r.wp.sections} · cartes ${r.ref.cartes.length} → ${r.wp.cartes.length} · ` +
				`${r.anomalies.length} anomalie(s)`
		);
		L.push('');
		if (r.anomalies.length) {
			L.push('| Anomalie | Archétype | Bande | Détail |');
			L.push('|---|---|---|---|');
			for (const x of r.anomalies.slice(0, 30)) {
				const det =
					x.genre === 'fusionnee'
						? `« ${x.texte} » rendue dans « ${x.dans} »`
						: x.genre === 'colonnes'
							? `« ${x.texte} » — ${x.attendu} colonnes attendues, ${x.recu} rendues`
							: x.genre === 'type'
								? `« ${x.texte} » — rendue en \`${x.recu}\``
								: `« ${x.texte} »`;
				L.push(`| ${x.genre} | \`${x.type}\` | ${x.bande} | ${det.replace(/\|/g, '/')} |`);
			}
			if (r.anomalies.length > 30) L.push(`| … | | | ${r.anomalies.length - 30} autres |`);
			L.push('');
		}
	}
	L.push('');
}

writeFileSync(RAPPORT + (seules ? '.partiel' : ''), L.join('\n') + '\n');
console.error(`\nÉcrit : ${RAPPORT}${seules ? '.partiel' : ''} — ${totalAnos} anomalie(s), ${totalGraves} grave(s)`);
