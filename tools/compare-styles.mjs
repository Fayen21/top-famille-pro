#!/usr/bin/env node
/**
 * Vérification visuelle réelle des 53 routes : styles calculés, maquette ↔ WordPress.
 *
 * tools/compare-routes.mjs compare des hauteurs, des blocs et des mots. C'est nécessaire mais ce
 * n'est pas une vérification visuelle : deux pages peuvent faire exactement la même hauteur avec
 * des couleurs, des polices, des rayons et des largeurs de conteneur différents. Cet outil relève
 * donc, des deux côtés, ce qui décide de l'aspect :
 *
 *  - **couleurs** : fond de page, fond des bandes, couleur du texte courant, couleur des liens ;
 *  - **typographie** : familles réellement résolues (pas celles demandées), taille et graisse du
 *    H1, du premier H2, du texte courant ;
 *  - **gabarit** : largeur du conteneur principal, marges latérales, largeur du contenu du hero ;
 *  - **composants** : rayon, filet, ombre et padding des cartes ; taille et rayon du bouton
 *    principal ; nombre de colonnes des grilles de cartes ;
 *  - **images** : ratio d'affichage et cadrage (`object-fit`) du visuel principal ;
 *  - **pied de page et en-tête** : hauteur, fond.
 *
 * Chaque relevé est comparé avec une tolérance explicite, et le rapport nomme l'écart plutôt que
 * de le résumer par un pourcentage. Produit docs/VERIFICATION-VISUELLE-53-ROUTES.md.
 *
 * Usage :
 *   node tools/compare-styles.mjs
 *   node tools/compare-styles.mjs --only='#/ville/dijon,#/conseils'
 *   node tools/compare-styles.mjs --widths=1440,375
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const RAPPORT = 'docs/VERIFICATION-VISUELLE-53-ROUTES.md';

const only = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1];
const seules = only ? only.split(',').map((s) => s.trim()).filter(Boolean) : null;
const widths = ((process.argv.find((a) => a.startsWith('--widths=')) || '').split('=')[1] || '1440,375')
	.split(',')
	.map(Number);

/**
 * Relevé des styles calculés d'une page.
 *
 * Volontairement indépendant du balisage : la maquette n'a ni classes ni `<header>`, on repère donc
 * chaque élément par son rôle visuel (le H1, la première carte, le bouton le plus proéminent…).
 */
const RELEVE = () => {
	const cs = (el, p) => (el ? getComputedStyle(el)[p] : null);
	const rect = (el) => {
		if (!el) return null;
		const r = el.getBoundingClientRect();
		return { w: Math.round(r.width), h: Math.round(r.height), x: Math.round(r.left) };
	};
	/** Première famille effectivement résolue, en minuscules, sans guillemets. */
	const famille = (el) =>
		el
			? (getComputedStyle(el).fontFamily || '')
					.split(',')[0]
					.replace(/["']/g, '')
					.trim()
					.toLowerCase()
			: null;

	const h1 = document.querySelector('h1');

	// Conteneur du flux : le plus proche ancêtre du H1 portant plusieurs `<section>`.
	let flux = document.body;
	for (let el = h1; el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}

	// Conteneur de lecture : le bloc qui porte réellement la largeur du texte, mesuré sur le
	// parent du H1 — c'est lui qui fixe la gouttière perçue.
	const conteneur = h1 ? h1.parentElement : null;

	const sections = [...flux.children].filter((c) => c.getBoundingClientRect().height >= 20);

	/*
	 * Cartes : on ne compare pas « la première carte », qui n'est jamais le même élément des deux
	 * côtés et produisait des écarts qui n'en étaient pas. On compare le **vocabulaire de cartes**
	 * de la page : l'ensemble des rayons employés et l'ensemble des fonds employés, avec le nombre
	 * de cartes concernées. C'est ce que l'œil retient, et c'est stable au balisage.
	 */
	const cartes = [...flux.querySelectorAll('div,article,li,details,section,aside,blockquote,figure')].filter((el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		return (
			parseFloat(s.borderRadius) >= 8 &&
			r.width > 160 &&
			r.height > 60 &&
			(parseFloat(s.borderTopWidth) > 0 || s.backgroundColor !== 'rgba(0, 0, 0, 0)')
		);
	});
	const compter = (liste) => {
		const m = new Map();
		for (const v of liste) m.set(v, (m.get(v) || 0) + 1);
		return [...m.entries()]
			.sort((a, b) => b[1] - a[1])
			.slice(0, 4)
			.map(([v, n]) => `${v}×${n}`)
			.join(' ');
	};

	/*
	 * Bouton principal : ancré sur le libellé du CTA, seul repère stable entre les deux versions
	 * — « le lien au fond le plus contrasté » attrapait une carte cliquable d'un côté et un vrai
	 * bouton de l'autre.
	 */
	const bouton = [...flux.querySelectorAll('a,button')].find((el) => {
		const t = (el.textContent || '').replace(/\s+/g, ' ').trim().toLowerCase();
		const r = el.getBoundingClientRect();
		return /^(demander|demandez)\b.*devis/.test(t) && r.height >= 30 && r.height <= 80;
	});

	/*
	 * Grilles de cartes : nombre de colonnes réellement rendu, mesuré sur le premier rang — la
	 * propriété `grid-template-columns` ne dit rien quand la grille est un flex qui enroule.
	 * Restreint aux grilles dont les enfants sont des cartes : les rangées de pastilles et les
	 * barres de boutons enroulent au gré du texte et n'ont pas de « nombre de colonnes ».
	 */
	const grilles = [...flux.querySelectorAll('div,ul,ol')]
		.filter((el) => {
			const s = getComputedStyle(el);
			if (!/grid|flex/.test(s.display) || el.children.length < 3) return false;
			if (el.getBoundingClientRect().width < 400) return false;
			const enfantsCartes = [...el.children].filter((c) => parseFloat(getComputedStyle(c).borderRadius) >= 8).length;
			return enfantsCartes >= el.children.length - 1 && enfantsCartes >= 3;
		})
		.map((el) => {
			const y0 = Math.round(el.children[0].getBoundingClientRect().top);
			const rang0 = [...el.children].filter((c) => Math.abs(Math.round(c.getBoundingClientRect().top) - y0) <= 8);
			return { n: el.children.length, colonnes: rang0.length };
		})
		.filter((g) => g.colonnes >= 2)
		.slice(0, 6);

	const img = [...document.images].filter((i) => i.getBoundingClientRect().width > 120)[0];
	const h2 = flux.querySelector('h2');
	const p = flux.querySelector('p');
	const lien = [...flux.querySelectorAll('p a')][0];

	// Pied de page : dernier bloc de la page au fond sombre.
	const pied = document.querySelector('footer') || [...document.body.children].pop();

	return {
		fondPage: cs(document.body, 'backgroundColor'),
		texteCouleur: cs(p, 'color'),
		lienCouleur: cs(lien, 'color'),
		lienDecoration: cs(lien, 'textDecorationLine'),

		policeTitre: famille(h1),
		policeTexte: famille(p),
		h1Taille: h1 ? Math.round(parseFloat(cs(h1, 'fontSize'))) : null,
		h1Graisse: cs(h1, 'fontWeight'),
		h1Interligne: h1 ? Math.round(parseFloat(cs(h1, 'lineHeight'))) : null,
		h2Taille: h2 ? Math.round(parseFloat(cs(h2, 'fontSize'))) : null,
		h2Graisse: cs(h2, 'fontWeight'),
		texteTaille: p ? Math.round(parseFloat(cs(p, 'fontSize'))) : null,
		texteInterligne: p ? Math.round(parseFloat(cs(p, 'lineHeight'))) : null,

		conteneurLargeur: rect(conteneur) ? rect(conteneur).w : null,
		conteneurGauche: rect(conteneur) ? rect(conteneur).x : null,
		sections: sections.length,
		fondsSections: sections.map((s) => getComputedStyle(s).backgroundColor).join(' | '),

		cartesNombre: cartes.length,
		cartesRayons: compter(cartes.map((c) => getComputedStyle(c).borderRadius)),
		cartesFonds: compter(cartes.map((c) => getComputedStyle(c).backgroundColor)),
		cartesFilets: compter(cartes.map((c) => getComputedStyle(c).borderTopWidth)),

		boutonTexte: bouton ? (bouton.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 28) : null,
		boutonTaille: rect(bouton) ? `${rect(bouton).w}×${rect(bouton).h}` : null,
		boutonRayon: cs(bouton, 'borderRadius'),
		boutonFond: cs(bouton, 'backgroundColor'),

		grilles: grilles.map((g) => `${g.colonnes} col × ${g.n}`).join(' / '),

		imageRatio: img ? (img.getBoundingClientRect().width / Math.max(1, img.getBoundingClientRect().height)).toFixed(2) : null,
		imageCadrage: cs(img, 'objectFit'),

		piedHauteur: rect(pied) ? rect(pied).h : null,
		piedFond: cs(pied, 'backgroundColor'),
	};
};

/** Champs comparés, avec leur libellé et leur tolérance. */
const CHAMPS = [
	['policeTitre', 'Police des titres', 'exact'],
	['policeTexte', 'Police du texte', 'exact'],
	['fondPage', 'Fond de page', 'exact'],
	['texteCouleur', 'Couleur du texte', 'exact'],
	['lienCouleur', 'Couleur des liens', 'exact'],
	['h1Taille', 'Taille du H1', 3],
	['h1Graisse', 'Graisse du H1', 'exact'],
	['h1Interligne', 'Interligne du H1', 5],
	['h2Taille', 'Taille du premier H2', 3],
	['texteTaille', 'Taille du texte', 1],
	['texteInterligne', 'Interligne du texte', 3],
	['conteneurLargeur', 'Largeur du conteneur', 24],
	['conteneurGauche', 'Marge gauche du conteneur', 12],
	['sections', 'Nombre de bandes', 0],
	['cartesNombre', 'Nombre de cartes', 3],
	['cartesRayons', 'Rayons de cartes employés', 'exact'],
	['cartesFonds', 'Fonds de cartes employés', 'exact'],
	['cartesFilets', 'Filets de cartes employés', 'exact'],
	['boutonTaille', 'Taille du bouton principal', 'taille'],
	['boutonRayon', 'Rayon du bouton', 'exact'],
	['boutonFond', 'Fond du bouton', 'exact'],
	['grilles', 'Colonnes des grilles', 'exact'],
	['imageCadrage', 'Cadrage de l’image', 'exact'],
	['piedFond', 'Fond du pied de page', 'exact'],
];

const nombre = (v) => (typeof v === 'number' ? v : parseFloat(v));

/** Compare une valeur, renvoie null si conforme, sinon la description de l'écart. */
function ecart(cle, tol, a, b) {
	if (a === null && b === null) return null;
	if (a === null || b === null) return `absent d'un côté (maquette ${a} · WordPress ${b})`;
	if (tol === 'exact') return String(a) === String(b) ? null : `maquette ${a} · WordPress ${b}`;
	if (tol === 'taille') {
		const [aw, ah] = String(a).split('×').map(Number);
		const [bw, bh] = String(b).split('×').map(Number);
		return Math.abs(aw - bw) <= 24 && Math.abs(ah - bh) <= 6 ? null : `maquette ${a} · WordPress ${b}`;
	}
	const d = Math.abs(nombre(a) - nombre(b));
	return d <= tol ? null : `maquette ${a} · WordPress ${b} (écart ${Math.round(d)})`;
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const routes = Object.keys(ROUTE_MAP).filter((r) => !seules || seules.includes(r));
const resultats = {};

for (const width of widths) {
	const ref = await browser.newPage({ viewport: { width, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const wp = await browser.newPage({ viewport: { width, height: 900 } });

	for (const hash of routes) {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		await ref.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
		const a = await ref.evaluate(RELEVE);

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await wp.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
		const b = await wp.evaluate(RELEVE);

		const ecarts = [];
		for (const [cle, libelle, tol] of CHAMPS) {
			const e = ecart(cle, tol, a[cle], b[cle]);
			if (e) ecarts.push({ libelle, detail: e });
		}
		(resultats[hash] ||= {})[width] = { a, b, ecarts };
		console.log(`${(ecarts.length ? '⚠️ ' + ecarts.length : '✅').padEnd(6)} ${String(width).padStart(4)}px ${hash}`);
	}
	await ref.close();
	await wp.close();
}
await browser.close();

/* ------------------------------------------------------------------ */
/* Rapport                                                             */
/* ------------------------------------------------------------------ */

const L = [];
L.push('# Vérification visuelle des 53 routes — styles calculés');
L.push('');
L.push('> Fichier **généré** par `node tools/compare-styles.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Une hauteur identique ne prouve pas une page identique. Ce relevé compare, des deux côtés');
L.push('> et sur le rendu réel, ce qui décide de l’aspect : polices résolues, couleurs, tailles et');
L.push('> interlignes, largeur et marge du conteneur, nombre de bandes, rayon / filet / fond des');
L.push('> cartes, taille et rayon du bouton principal, nombre de colonnes des grilles, cadrage des');
L.push('> images, fond du pied de page.');
L.push('');

const total = Object.values(resultats).reduce(
	(n, parLargeur) => n + Object.values(parLargeur).reduce((m, r) => m + r.ecarts.length, 0),
	0
);
L.push(`**${routes.length} routes × ${widths.length} largeurs · ${total} écart(s) relevé(s).**`);
L.push('');

L.push('## Synthèse');
L.push('');
L.push('| Route | ' + widths.map((w) => `${w} px`).join(' | ') + ' |');
L.push('|---|' + widths.map(() => '---').join('|') + '|');
for (const hash of routes) {
	const cases = widths.map((w) => {
		const r = resultats[hash][w];
		return r.ecarts.length ? `⚠️ ${r.ecarts.length}` : '✅';
	});
	L.push(`| \`${hash}\` | ${cases.join(' | ')} |`);
}
L.push('');

L.push('## Écarts par nature');
L.push('');
const parNature = new Map();
for (const [hash, parLargeur] of Object.entries(resultats)) {
	for (const [w, r] of Object.entries(parLargeur)) {
		for (const e of r.ecarts) {
			if (!parNature.has(e.libelle)) parNature.set(e.libelle, []);
			parNature.get(e.libelle).push(`${hash} @${w}px — ${e.detail}`);
		}
	}
}
if (!parNature.size) {
	L.push('Aucun écart : sur les points relevés, le rendu WordPress est celui de la maquette.');
} else {
	for (const [libelle, cas] of [...parNature.entries()].sort((x, y) => y[1].length - x[1].length)) {
		L.push(`### ${libelle} — ${cas.length} cas`);
		L.push('');
		for (const c of cas.slice(0, 20)) L.push(`- \`${c}\``);
		if (cas.length > 20) L.push(`- … et ${cas.length - 20} autres`);
		L.push('');
	}
}

L.push('## Relevé complet, route par route');
L.push('');
for (const hash of routes) {
	L.push(`### \`${hash}\` → \`${ROUTE_MAP[hash].wp}\``);
	L.push('');
	for (const w of widths) {
		const { a, b, ecarts } = resultats[hash][w];
		L.push(`**${w} px** — ${ecarts.length ? `⚠️ ${ecarts.length} écart(s)` : '✅ conforme'}`);
		L.push('');
		L.push('| Relevé | Maquette | WordPress | État |');
		L.push('|---|---|---|---|');
		for (const [cle, libelle, tol] of CHAMPS) {
			const e = ecart(cle, tol, a[cle], b[cle]);
			L.push(`| ${libelle} | ${a[cle] ?? '—'} | ${b[cle] ?? '—'} | ${e ? '⚠️' : '✅'} |`);
		}
		L.push('');
	}
}

writeFileSync(RAPPORT + (seules ? '.partiel' : ''), L.join('\n') + '\n');
console.error(`\nÉcrit : ${RAPPORT}${seules ? '.partiel' : ''} — ${total} écart(s)`);
