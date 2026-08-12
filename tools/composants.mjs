#!/usr/bin/env node
/**
 * Comparateur géométrique de composants — maquette Claude Design ↔ WordPress.
 *
 * Les outils précédents comparaient des pages (hauteurs, cartes, colonnes). Aucun ne disait
 * **quelle propriété de quel composant** produit l'écart, ni combien de pixels elle coûte. D'où le
 * constat stérile de la passe précédente — « l'écart est diffus » — qui n'est vrai que tant qu'on
 * ne décompose pas.
 *
 * Cet outil apparie les composants des deux côtés, relève une quarantaine de propriétés calculées
 * sur chacun, **décompose** la différence de hauteur en contributions élémentaires, puis regroupe
 * les écarts qui partagent la même cause. Un écart présent sur 40 cartes n'est pas 40 problèmes :
 * c'est une règle CSS.
 *
 * Sorties :
 *   docs/composants.json    — un enregistrement par composant apparié, exploitable par machine
 *   docs/GROUPES-ECARTS.md  — les groupes de cause, classés par impact
 *
 * Usage :
 *   node tools/composants.mjs                          → familles représentatives, 3 largeurs
 *   node tools/composants.mjs --widths=375
 *   node tools/composants.mjs --routes='#/service/bureaux'
 *   node tools/composants.mjs --toutes                 → les 53 routes
 *   node tools/composants.mjs --routes='#/x' --surcharge=diag.css   → simule une correction
 *
 * Deux garde-fous ajoutés lors de la reprise du chantier :
 *
 *  - **Un relevé partiel n'écrase jamais le relevé complet.** Un passage `--routes=` ou
 *    `--widths=` restreint écrit vers `docs/composants.partiel.json` et
 *    `docs/GROUPES-ECARTS.partiel.md`. Sans cela, une vérification d'un groupe sur une route
 *    remplaçait les 5 163 écarts des 18 familles par les 180 de cette route — et le classement
 *    par impact, lu au passage suivant, ne portait plus que sur une page.
 *  - **La simulation avant correction.** `--surcharge=fichier.css` injecte une feuille de style
 *    dans la seule page WordPress, après chargement. Elle sert à vérifier qu'une propriété est
 *    réellement causale — effet mesuré sur le composant, ses enfants, sa bande et la page —
 *    avant de l'écrire dans le thème. Ce n'est jamais la correction finale.
 */
import { chromium } from '@playwright/test';
import { writeFileSync, readFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const LARGEURS = arg('widths', '375,768,1440').split(',').map(Number);

/** Feuille de style de diagnostic, injectée côté WordPress seulement. Jamais une correction. */
const SURCHARGE = arg('surcharge', '') ? readFileSync(arg('surcharge', ''), 'utf8') : '';

/** Une route représentative par famille de gabarit — suffisant pour trouver les causes partagées. */
const REPRESENTATIVES = [
	['accueil', '#/'],
	['pilier', '#/nettoyage-professionnel'],
	['index-prestations', '#/nos-prestations'],
	['prestation', '#/service/bureaux'],
	['tarifs', '#/nos-tarifs'],
	['hub-zones', '#/zones-intervention'],
	['region', '#/bourgogne-franche-comte'],
	['departement', '#/departement/cote-dor'],
	['ville', '#/ville/dijon'],
	['commune', '#/ville/beaune'],
	['index-conseils', '#/conseils'],
	['article', '#/article/cout-nettoyage-bureaux'],
	['institutionnelle', '#/pourquoi-top-famille-pro'],
	['fonctionnement', '#/notre-fonctionnement'],
	['avis', '#/avis-clients'],
	['contact', '#/contact'],
	['devis', '#/demande-de-devis'],
	['legale', '#/mentions-legales'],
];

const routes = process.argv.includes('--toutes')
	? Object.keys(ROUTE_MAP).map((h) => [ROUTE_MAP[h].type || 'route', h])
	: arg('routes', '')
		? arg('routes', '').split(',').map((h) => ['ad hoc', h.trim()])
		: REPRESENTATIVES;

/* ------------------------------------------------------------------ */
/* Relevé, exécuté dans la page                                        */
/* ------------------------------------------------------------------ */

const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	/**
	 * Empreinte textuelle normalisée.
	 *
	 * Tolère ce qui diffère sans changer le composant : le prototype colle ses nœuds sans espace
	 * (« 5,0/5sur Google »), emploie des apostrophes typographiques, et le thème corrige des
	 * formulations (« 5,0/5 Google » → « 5,0/5 sur Google »). Ne tolère pas plus : deux composants
	 * réellement différents gardent des empreintes différentes, puisque seule la ponctuation et la
	 * casse disparaissent.
	 */
	const empreinte = (s) =>
		(s || '')
			.normalize('NFD')
			.replace(/[̀-ͯ]/g, '')
			.toLowerCase()
			.replace(/[^a-z0-9]/g, '');

	/** Flux de page : en-tête, pré-pied et pied sont identiques sur les 53 routes. */
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = [...flux.querySelectorAll(':scope > section')].filter((s) => s.getBoundingClientRect().height > 20);

	/** Rôle visuel : ce qu'un œil voit, indépendamment des balises et des classes. */
	const role = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
		const filet = parseFloat(s.borderTopWidth) > 0 || parseFloat(s.borderLeftWidth) > 0;
		const rayon = parseFloat(s.borderTopLeftRadius);
		const encadre = fond || filet || (s.boxShadow && s.boxShadow !== 'none');
		if (el.tagName === 'IMG' || el.querySelector(':scope > img, :scope > picture')) return 'media';
		if (rayon >= 40 && encadre && r.height <= 60) return 'pastille';
		if (encadre && r.height <= 150 && r.width <= 430) return 'micro-carte';
		if (encadre) return 'carte';
		if (/^H[1-6]$/.test(el.tagName)) return 'titre';
		if (el.tagName === 'TABLE') return 'tableau';
		if (el.tagName === 'FORM') return 'formulaire';
		if (s.display === 'grid' || s.display === 'flex') return 'grille';
		return 'texte';
	};

	/**
	 * Nombre réel de lignes d'un bloc de texte, relevé et non déduit.
	 *
	 * Sans lui, une correction de typographie ne se valide pas : un composant peut avoir la bonne
	 * taille de police et la bonne hauteur de ligne et rester trop haut de 24 px, simplement parce
	 * que sa largeur utile lui fait replier une ligne de plus. Le rapport hauteur/interligne ne
	 * suffit pas — il arrondit et masque exactement ce cas. Les rectangles du domaine, eux, le
	 * disent : une ordonnée distincte, une ligne.
	 */
	const lignes = (el) => {
		/*
		 * Mesuré sur les **feuilles** de texte seulement.
		 *
		 * Sur un conteneur, les rectangles du domaine ne décrivent plus des lignes : un intitulé
		 * de 17 px et une description de 13 px posent des rectangles à des ordonnées voisines mais
		 * distinctes, et la carte « Besançon » — une ligne à l'écran, 47 px de haut — était comptée
		 * pour quatre. Le repli comptait alors 77 différences de repli qui n'existaient pas.
		 */
		if (el.children.length) return 0;
		try {
			const r = document.createRange();
			r.selectNodeContents(el);
			const tops = [];
			for (const rect of r.getClientRects()) {
				if (rect.height <= 2 || rect.width <= 0) continue;
				// Deux rectangles à moins de 4 px l'un de l'autre appartiennent à la même ligne :
				// une exposante, une puce ou un fragment plus petit décalent la boîte sans en créer.
				if (!tops.some((t) => Math.abs(t - rect.top) < 4)) tops.push(rect.top);
			}
			return tops.length;
		} catch {
			return 0;
		}
	};

	/**
	 * Largeur utile : ce dans quoi le texte se replie réellement, rembourrages déduits.
	 *
	 * `clientWidth` vaut zéro sur un élément en ligne — il n'a pas de boîte de contenu au sens du
	 * modèle de boîte. Le relevé affichait alors « util 0 → 273 » sur des intitulés parfaitement
	 * normaux, ce qui se lit comme une anomalie et n'en est pas une. On retombe dans ce cas sur la
	 * largeur du rectangle englobant, qui est bien ce dans quoi le texte se replie.
	 */
	const utile = (el) => {
		const s = getComputedStyle(el);
		if (!el.clientWidth) return Math.round(el.getBoundingClientRect().width);
		return Math.round(el.clientWidth - (parseFloat(s.paddingLeft) || 0) - (parseFloat(s.paddingRight) || 0));
	};

	/** Nombre de colonnes réellement occupées : les enfants qui partagent une ordonnée. */
	const colonnes = (el) => {
		const enfants = [...el.children].filter((c) => c.getBoundingClientRect().height > 12);
		if (enfants.length < 2) return 1;
		const rangs = new Set(enfants.map((c) => Math.round(c.getBoundingClientRect().top / 8)));
		return Math.max(1, Math.round(enfants.length / rangs.size));
	};

	/**
	 * Décomposition verticale d'un composant : ce qui, en pixels, compose sa hauteur.
	 *
	 * C'est la mesure qui manquait. Sans elle, une carte plus haute de 31 px reste « diffuse » ;
	 * avec elle, on sait que ce sont 4 px de rembourrage haut, 6 de marge de titre, 9 d'interligne
	 * de description, 8 d'écart de liste et 4 de rembourrage bas.
	 */
	const composition = (el) => {
		const s = getComputedStyle(el);
		const parts = {
			padHaut: parseFloat(s.paddingTop) || 0,
			padBas: parseFloat(s.paddingBottom) || 0,
			bordHaut: parseFloat(s.borderTopWidth) || 0,
			bordBas: parseFloat(s.borderBottomWidth) || 0,
		};
		let contenu = 0;
		let ecarts = 0;
		const gap = parseFloat(s.rowGap) || 0;
		const enfants = [...el.children].filter((c) => c.getBoundingClientRect().height > 0);
		enfants.forEach((c, i) => {
			const cs = getComputedStyle(c);
			const h = c.getBoundingClientRect().height;
			const mt = parseFloat(cs.marginTop) || 0;
			const mb = parseFloat(cs.marginBottom) || 0;
			contenu += h;
			ecarts += mt + mb + (i > 0 ? gap : 0);
			parts['enfant' + i] = Math.round(h);
			if (mt || mb) parts['margeEnfant' + i] = Math.round(mt + mb);
		});
		parts.contenu = Math.round(contenu);
		parts.ecarts = Math.round(ecarts);
		return parts;
	};

	const out = [];
	bandes.forEach((bande, iBande) => {
		// Candidats : tout ce qui a un rôle visuel identifiable et une taille utile.
		const candidats = [...bande.querySelectorAll('*')].filter((el) => {
			const r = el.getBoundingClientRect();
			return r.width >= 40 && r.height >= 16 && txt(el).length + (el.querySelector('img') ? 10 : 0) > 0;
		});
		candidats.forEach((el, ordre) => {
			const s = getComputedStyle(el);
			const r = el.getBoundingClientRect();
			const img = el.tagName === 'IMG' ? el : el.querySelector('img');
			const t = txt(el);
			out.push({
				bande: iBande,
				ordre,
				role: role(el),
				empreinte: empreinte(t).slice(0, 60),
				// Longueur **entière** du texte : l'empreinte est tronquée à 60 caractères, si bien
				// qu'une étiquette et le conteneur de bande qui commence par elle ont la même
				// empreinte et la même longueur apparente. Sans cette mesure, l'appariement ne peut
				// pas les distinguer.
				longueur: t.length,
				texte: t.slice(0, 60),
				balise: el.tagName,
				classe: (el.className || '').toString().slice(0, 40),
				enfants: el.children.length,
				media: img ? 'img' : el.querySelector('svg') ? 'svg' : '',
				x: Math.round(r.left),
				y: Math.round(r.top + window.scrollY),
				w: Math.round(r.width),
				h: Math.round(r.height),
				wUtile: utile(el),
				lignes: lignes(el),
				colonnes: colonnes(el),
				rangs: Math.max(1, Math.round([...el.children].filter((c) => c.getBoundingClientRect().height > 12).length / Math.max(1, colonnes(el)))),
				display: s.display,
				gridCols: (s.gridTemplateColumns || 'none').slice(0, 60),
				flexDir: s.flexDirection,
				alignItems: s.alignItems,
				justify: s.justifyContent,
				gap: s.gap,
				rowGap: s.rowGap,
				colGap: s.columnGap,
				padTop: s.paddingTop,
				padRight: s.paddingRight,
				padBottom: s.paddingBottom,
				padLeft: s.paddingLeft,
				mTop: s.marginTop,
				mRight: s.marginRight,
				mBottom: s.marginBottom,
				mLeft: s.marginLeft,
				width: s.width,
				maxWidth: s.maxWidth,
				minWidth: s.minWidth,
				height: s.height,
				minHeight: s.minHeight,
				aspectRatio: s.aspectRatio,
				police: (s.fontFamily || '').split(',')[0].replace(/"/g, ''),
				taille: s.fontSize,
				graisse: s.fontWeight,
				interligne: s.lineHeight,
				lettres: s.letterSpacing,
				bordure: s.borderTopWidth + ' ' + s.borderTopStyle,
				rayon: s.borderTopLeftRadius,
				ombre: (s.boxShadow || 'none').slice(0, 40),
				fond: s.backgroundColor,
				couleur: s.color,
				imgW: img ? img.naturalWidth : 0,
				imgH: img ? img.naturalHeight : 0,
				objectFit: img ? getComputedStyle(img).objectFit : '',
				objectPosition: img ? getComputedStyle(img).objectPosition : '',
				composition: composition(el),
			});
		});
	});
	return out;
};

const STABILISER = async () => {
	await new Promise((r) => (document.fonts ? document.fonts.ready.then(r) : r()));
	for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
		window.scrollTo(0, y);
		await new Promise((r) => setTimeout(r, 25));
	}
	window.scrollTo(0, 0);
	await new Promise((r) => setTimeout(r, 120));
};

/* ------------------------------------------------------------------ */
/* Appariement                                                         */
/* ------------------------------------------------------------------ */

/**
 * Apparie les composants des deux côtés.
 *
 * Aucun critère isolé ne suffit : ni la balise (le prototype n'en a pas de stable), ni la classe
 * (elle est propre au thème), ni la hauteur (c'est précisément ce qu'on mesure), ni le texte exact
 * (le site en corrige volontairement). On combine donc empreinte, rôle, bande, ordre et nombre
 * d'enfants, et on n'accepte un appariement que si l'ensemble concorde.
 */
function apparier(refs, wps) {
	const libres = wps.map((w, i) => ({ ...w, i, pris: false }));
	const paires = [];

	const score = (a, b) => {
		if (a.role !== b.role) return 0;
		let s = 0;
		// Deux textes dont les 60 premiers caractères coïncident mais dont le volume total diffère
		// d'un ordre de grandeur ne sont pas le même composant : c'est l'étiquette contre la bande
		// qui la contient.
		if (Math.min(a.longueur, b.longueur) < 0.5 * Math.max(a.longueur, b.longueur)) return 0;
		if (a.empreinte && a.empreinte === b.empreinte) s += 60;
		/*
		 * Correspondance par préfixe : elle ne vaut qu'entre empreintes de **longueur comparable**.
		 *
		 * Sans cette condition, une étiquette courte est le préfixe de tout conteneur qui commence
		 * par elle. « Notre implantation réelle : Saint-Apollinaire… », 74 px de haut dans la
		 * maquette, était ainsi appariée au conteneur de bande WordPress tout entier — 3 619 px —
		 * et l'outil rapportait un écart de hauteur de 3 545 px, en tête du classement par impact,
		 * pour un composant qui n'a rien d'anormal. Une empreinte tronquée à 60 caractères est déjà
		 * un préfixe ; exiger que la plus courte fasse au moins 60 % de la plus longue écarte le
		 * conteneur sans écarter la reformulation.
		 */
		else if (
			a.empreinte &&
			b.empreinte &&
			Math.min(a.longueur, b.longueur) >= 0.6 * Math.max(a.longueur, b.longueur) &&
			(a.empreinte.startsWith(b.empreinte.slice(0, 24)) || b.empreinte.startsWith(a.empreinte.slice(0, 24)))
		)
			s += 40;
		else {
			// Similarité de mots : tolère une reformulation, refuse deux composants différents.
			const mots = (x) => new Set((x.texte || '').toLowerCase().split(/[^a-zà-ÿ0-9]+/).filter((m) => m.length > 3));
			const A = mots(a);
			const B = mots(b);
			if (!A.size || !B.size) return 0;
			let c = 0;
			for (const m of A) if (B.has(m)) c++;
			const dice = (2 * c) / (A.size + B.size);
			if (dice < 0.5) return 0;
			s += Math.round(30 * dice);
		}
		if (Math.abs(a.bande - b.bande) <= 1) s += 12;
		if (a.enfants === b.enfants) s += 8;
		if (a.media === b.media) s += 5;
		if (Math.abs(a.w - b.w) <= 12) s += 5;
		return s;
	};

	for (const a of refs) {
		if (!a.empreinte && !a.media) continue;
		let meilleur = null;
		let meilleurScore = 0;
		for (const b of libres) {
			if (b.pris) continue;
			const s = score(a, b);
			if (s > meilleurScore) {
				meilleurScore = s;
				meilleur = b;
			}
		}
		if (meilleur && meilleurScore >= 45) {
			meilleur.pris = true;
			paires.push([a, meilleur]);
		}
	}
	return paires;
}

/* ------------------------------------------------------------------ */
/* Écarts et regroupement                                              */
/* ------------------------------------------------------------------ */

const px = (v) => (parseFloat(v) || 0);

/** Propriétés dont un écart est significatif, avec le seuil au-delà duquel on le retient. */
const PROPRIETES = [
	['rowGap', 2, 'écart vertical de grille'],
	['colGap', 2, 'écart horizontal de grille'],
	['padTop', 2, 'rembourrage haut'],
	['padBottom', 2, 'rembourrage bas'],
	// Rembourrages horizontaux : voir le filtre ci-dessous, ils ne sont retenus que là où ils se
	// voient. Le seuil et le libellé restent définis ici.
	['padLeft', 3, 'rembourrage gauche'],
	['padRight', 3, 'rembourrage droit'],
	['mTop', 3, 'marge haute'],
	['mBottom', 3, 'marge basse'],
	['taille', 0.6, 'taille de police'],
	['interligne', 1.5, 'interligne'],
	['rayon', 2, 'rayon'],
	['bordure', 0.6, 'bordure'],
	['minHeight', 8, 'hauteur minimale'],
];

function ecarts(paires, route, famille, largeur) {
	const out = [];
	for (const [a, b] of paires) {
		const dh = b.h - a.h;
		const props = [];
		/*
		 * Un rembourrage horizontal ne se voit que de deux façons : par la largeur qu'il laisse au
		 * texte, ou par la distance entre un fond et son contenu. Quand la largeur utile est la
		 * même des deux côtés et que le composant n'a ni fond ni filet, la différence de
		 * rembourrage dit seulement que la maquette et le thème la posent à des niveaux différents
		 * d'une chaîne de conteneurs équivalente. C'était le premier groupe du classement — 18
		 * occurrences sur la page pilier — pour un écart que rien ne rend visible.
		 */
		const cadre = /carte|pastille|media/.test(a.role) || /carte|pastille|media/.test(b.role);
		const memeLargeurUtile = Math.abs(b.wUtile - a.wUtile) <= 8;
		/*
		 * Un écart entre pistes ne se voit qu'entre deux enfants. Le thème pose `gap: 12px` sur la
		 * tuile pour séparer l'icône du corps ; sur une tuile sans icône, elle n'a qu'un enfant et
		 * la valeur ne produit rien. Comparée quand même, elle formait le premier groupe de
		 * micro-cartes du classement — 46 occurrences pour un écart inexistant.
		 */
		const unSeulEnfant = a.enfants < 2 && b.enfants < 2;
		for (const [cle, seuil, libelle] of PROPRIETES) {
			if ((cle === 'rowGap' || cle === 'colGap') && unSeulEnfant) continue;
			if ((cle === 'padLeft' || cle === 'padRight') && memeLargeurUtile && !cadre) continue;
			const va = px(a[cle]);
			const vb = px(b[cle]);
			if (Math.abs(vb - va) > seuil) props.push({ propriete: cle, libelle, ref: a[cle], wp: b[cle], delta: Math.round((vb - va) * 10) / 10 });
		}
		/*
		 * Largeur de lecture : la **mesurée**, pas la déclarée.
		 *
		 * Comparer les `max-width` calculées faisait ressortir 705 écarts sur neuf pages, dont la
		 * plupart n'en sont pas : une contrainte de 754 px posée sur une colonne qui n'en fait que
		 * 339 ne change rien à l'écran, et la maquette qui n'en déclare aucune obtient la même
		 * largeur par son conteneur. Ce qui décide du repli du texte — donc de la hauteur — est la
		 * largeur utile réelle. C'est elle qu'on compare ; la valeur déclarée reste lisible dans le
		 * relevé pour instruire un écart, mais elle n'en constitue plus un à elle seule.
		 */
		if (Math.abs(b.wUtile - a.wUtile) > 8)
			props.push({ propriete: 'largeurUtile', libelle: 'largeur utile', ref: a.wUtile + 'px', wp: b.wUtile + 'px', delta: b.wUtile - a.wUtile });
		if (a.colonnes !== b.colonnes) props.push({ propriete: 'colonnes', libelle: 'nombre de colonnes', ref: a.colonnes, wp: b.colonnes, delta: b.colonnes - a.colonnes });
		/*
		 * Un repli différent est une cause à part entière, et souvent la vraie. Deux blocs peuvent
		 * partager taille, interligne et marges et différer de 24 px parce que l'un tient sur six
		 * lignes et l'autre sur sept. Corriger la typographie sans voir ce repli fait dépasser la
		 * cible au lieu de l'atteindre.
		 */
		if (a.lignes && b.lignes && a.lignes !== b.lignes && a.lignes <= 40 && b.lignes <= 40)
			props.push({ propriete: 'lignes', libelle: 'nombre de lignes', ref: a.lignes, wp: b.lignes, delta: b.lignes - a.lignes });
		if (!props.length && Math.abs(dh) < 3) continue;
		out.push({
			id: `${route}|${largeur}|${a.bande}|${a.empreinte.slice(0, 20)}|${a.role}`,
			route,
			famille,
			largeur,
			bande: a.bande,
			role: a.role,
			classe: b.classe,
			texte: a.texte,
			hRef: a.h,
			hWp: b.h,
			deltaH: dh,
			wRef: a.w,
			wWp: b.w,
			utileRef: a.wUtile,
			utileWp: b.wUtile,
			lignesRef: a.lignes,
			lignesWp: b.lignes,
			proprietes: props,
			compositionRef: a.composition,
			compositionWp: b.composition,
		});
	}
	return out;
}

/**
 * Regroupe les écarts qui partagent une cause : même rôle, même classe côté thème, même propriété
 * divergente, même couple de valeurs. Un écart présent sur quarante cartes est une règle, pas
 * quarante problèmes — et c'est la règle qu'il faut corriger.
 */
function grouper(tous) {
	const groupes = new Map();
	for (const e of tous) {
		for (const p of e.proprietes) {
			const cle = `${e.role}|${e.classe}|${p.propriete}|${p.ref}→${p.wp}`;
			if (!groupes.has(cle)) {
				groupes.set(cle, {
					cle,
					role: e.role,
					classe: e.classe,
					propriete: p.propriete,
					libelle: p.libelle,
					ref: p.ref,
					wp: p.wp,
					delta: p.delta,
					occurrences: [],
					routes: new Set(),
					familles: new Set(),
					largeurs: new Set(),
					deltaVertical: 0,
				});
			}
			const g = groupes.get(cle);
			g.occurrences.push(e.id);
			g.routes.add(e.route);
			g.familles.add(e.famille);
			g.largeurs.add(e.largeur);
			g.deltaVertical += Math.abs(e.deltaH);
		}
	}

	/*
	 * Impact = occurrences × delta vertical moyen, pondéré. Un écart qui touche plusieurs familles
	 * ou plusieurs largeurs pèse davantage : c'est une règle partagée, donc une correction qui
	 * rapporte sur beaucoup de routes à la fois.
	 */
	return [...groupes.values()]
		.map((g) => {
			const moyen = g.deltaVertical / g.occurrences.length;
			const poids = 1 + 0.3 * (g.familles.size - 1) + 0.2 * (g.largeurs.size - 1);
			return {
				...g,
				routes: [...g.routes],
				familles: [...g.familles],
				largeurs: [...g.largeurs],
				deltaMoyen: Math.round(moyen * 10) / 10,
				impact: Math.round(g.occurrences.length * moyen * poids),
			};
		})
		.sort((a, b) => b.impact - a.impact);
}

/* ------------------------------------------------------------------ */

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const tousEcarts = [];
const detail = {};

for (const largeur of LARGEURS) {
	const ref = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const wp = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });

	for (const [famille, hash] of routes) {
		if (!ROUTE_MAP[hash]) continue;
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		await ref.evaluate(STABILISER);
		const a = await ref.evaluate(RELEVE);

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		if (SURCHARGE) await wp.addStyleTag({ content: SURCHARGE });
		await wp.evaluate(STABILISER);
		const b = await wp.evaluate(RELEVE);

		const paires = apparier(a, b);
		const e = ecarts(paires, hash, famille, largeur);
		tousEcarts.push(...e);
		(detail[hash] ||= {})[largeur] = { composantsRef: a.length, composantsWp: b.length, apparies: paires.length, ecarts: e.length };
		console.log(
			`${String(largeur).padStart(4)}px ${hash.padEnd(38)} ${String(a.length).padStart(4)}→${String(b.length).padStart(4)} composants · ` +
				`${String(paires.length).padStart(4)} appariés · ${String(e.length).padStart(3)} avec écart`
		);
	}
	await ref.close();
	await wp.close();
}
await navigateur.close();

const groupes = grouper(tousEcarts);

/*
 * Un relevé partiel n'écrase pas le relevé complet — même garde-fou que `extract-routes.mjs`.
 * Est partiel tout passage qui ne couvre pas au moins les 18 familles représentatives aux trois
 * largeurs de référence : vérifier un groupe sur une route ne doit pas remplacer le classement
 * par impact dont dépend la passe suivante.
 */
const COMPLET = routes.length >= REPRESENTATIVES.length && LARGEURS.length >= 3 && !SURCHARGE;
const suffixe = COMPLET ? '' : '.partiel';
const F_JSON = `docs/composants${suffixe}.json`;
const F_MD = suffixe ? 'docs/GROUPES-ECARTS.partiel.md' : 'docs/GROUPES-ECARTS.md';

writeFileSync(F_JSON, JSON.stringify({ partiel: !COMPLET, surcharge: SURCHARGE ? arg('surcharge', '') : null, detail, ecarts: tousEcarts, groupes }, null, 1) + '\n');

const L = [];
L.push('# Groupes d’écarts géométriques — classés par impact' + (COMPLET ? '' : ' (relevé partiel)'));
L.push('');
L.push('> Fichier **généré** par `node tools/composants.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Un écart présent sur quarante cartes n’est pas quarante problèmes : c’est une règle CSS.');
L.push('> Les écarts sont donc regroupés par cause — même rôle visuel, même classe, même propriété,');
L.push('> mêmes valeurs — et classés par `occurrences × delta vertical moyen`, pondéré par le nombre');
L.push('> de familles de pages et de largeurs touchées.');
L.push('');
L.push(`**${tousEcarts.length} écarts** répartis en **${groupes.length} groupes de cause**.`);
L.push('');
L.push('| # | Impact | Occ. | Rôle | Classe | Propriété | Maquette → thème | Δ moyen | Familles | Largeurs |');
L.push('|---:|---:|---:|---|---|---|---|---:|---:|---|');
groupes.slice(0, 60).forEach((g, i) => {
	L.push(
		`| ${i + 1} | ${g.impact} | ${g.occurrences.length} | ${g.role} | \`${g.classe || '—'}\` | ${g.libelle} | ` +
			`${g.ref} → ${g.wp} | ${g.deltaMoyen} | ${g.familles.length} | ${g.largeurs.join(', ')} |`
	);
});
L.push('');
writeFileSync(F_MD, L.join('\n') + '\n');

console.log(`\n${F_JSON} + ${F_MD} — ${tousEcarts.length} écarts, ${groupes.length} groupes${COMPLET ? '' : ' (relevé PARTIEL)'}`);
console.log('\nDix premiers groupes par impact :');
for (const g of groupes.slice(0, 10)) {
	console.log(
		`  ${String(g.impact).padStart(6)} · ${String(g.occurrences.length).padStart(3)} occ · ${g.role.padEnd(12)} ` +
			`${(g.classe || '—').slice(0, 30).padEnd(30)} ${g.libelle} ${g.ref} → ${g.wp}`
	);
}
