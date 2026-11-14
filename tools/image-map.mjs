#!/usr/bin/env node
/**
 * Table de correspondance des images : maquette Claude Design ↔ WordPress.
 *
 * Croise trois sources, sans en supposer aucune :
 *  - l'extraction de la maquette (tools/reference-routes.json) : où chaque visuel apparaît, avec
 *    quel `alt` et à quelles dimensions ;
 *  - le manifeste du pipeline d'images du thème (assets/dist/images/manifest.json) : quelles
 *    variantes AVIF / WebP / JPEG existent, à quelles largeurs ;
 *  - le rendu WordPress réel, interrogé page par page : quel fichier est effectivement servi.
 *
 * Produit docs/IMAGES-MAQUETTE-WORDPRESS.md.
 *
 * Usage : node tools/image-map.mjs
 */
import { chromium } from '@playwright/test';
import { readFileSync, writeFileSync, statSync, existsSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const OUT = 'docs/IMAGES-MAQUETTE-WORDPRESS.md';
const DIST = 'wp-content/themes/topfamillepro/assets/dist/images';

const ref = JSON.parse(readFileSync('tools/reference-routes.json', 'utf8'));
const manifest = JSON.parse(readFileSync(`${DIST}/manifest.json`, 'utf8'));

/** Visuels distincts de la maquette, avec les routes où ils apparaissent. */
const refImages = new Map();
for (const [hash, data] of Object.entries(ref.data)) {
	for (const im of data.desktop.images) {
		const key = im.alt + '|' + im.natural;
		if (!refImages.has(key)) {
			refImages.set(key, { alt: im.alt, natural: im.natural, role: im.role, affiche: `${im.w}×${im.h}`, routes: [] });
		}
		refImages.get(key).routes.push(hash);
	}
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });

/** Images réellement servies par WordPress, par route. */
const wpImages = new Map();
for (const [hash, map] of Object.entries(ROUTE_MAP)) {
	await page.goto(WP + map.wp, { waitUntil: 'networkidle', timeout: 60000 });
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 30));
		}
	});
	const imgs = await page.evaluate(() =>
		[...document.images].map((i) => ({
			alt: i.getAttribute('alt') || '',
			src: (i.currentSrc || i.src || '').split('/').pop(),
			w: Math.round(i.getBoundingClientRect().width),
			h: Math.round(i.getBoundingClientRect().height),
			natural: i.naturalWidth + 'x' + i.naturalHeight,
			casse: i.naturalWidth === 0,
			loading: i.getAttribute('loading') || 'eager',
			priority: i.getAttribute('fetchpriority') || '',
		}))
	);
	for (const im of imgs) {
		const key = im.src;
		if (!wpImages.has(key)) wpImages.set(key, { ...im, routes: [] });
		wpImages.get(key).routes.push(hash);
	}
}
await browser.close();

const poids = (f) => {
	const p = `${DIST}/${f}`;
	return existsSync(p) ? Math.round(statSync(p).size / 1024) + ' Ko' : '—';
};

const L = [];
L.push('# Images — maquette Claude Design ↔ WordPress');
L.push('');
L.push('> Fichier **généré** par `node tools/image-map.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Croise trois sources : l’extraction de la maquette, le manifeste du pipeline d’images du');
L.push('> thème, et les fichiers réellement servis par WordPress page par page.');
L.push('');
L.push('## 1. Visuels de la maquette et leur équivalent WordPress');
L.push('');
L.push('| Rôle | `alt` de la maquette | Dimensions natives | Affiché | Routes | Slot WordPress |');
L.push('|---|---|---|---|---|---|');
for (const im of refImages.values()) {
	// Rapprochement par `alt` : c'est le seul lien stable entre les deux versions, la maquette
	// n'ayant pas de noms de fichiers (ses visuels sont encodés en base64 dans le bundle).
	const slot =
		Object.keys(manifest).find((s) => {
			const a = (manifest[s].alt || '').toLowerCase();
			return a && im.alt && (a.includes(im.alt.toLowerCase().slice(0, 20)) || im.alt.toLowerCase().includes(a.slice(0, 20)));
		}) || '';
	L.push(
		`| ${im.role} | ${im.alt || '_(vide — visuel décoratif)_'} | ${im.natural} | ${im.affiche} | ` +
			`${im.routes.length} | ${slot ? '`' + slot + '`' : '—'} |`
	);
}
L.push('');
L.push('## 2. Slots du pipeline d’images du thème');
L.push('');
L.push('| Slot | Dimensions natives | Largeurs générées | Formats | AVIF (max) | WebP (max) | JPEG (max) | `alt` par défaut |');
L.push('|---|---|---|---|---|---|---|---|');
for (const [slot, entry] of Object.entries(manifest)) {
	const v = entry.variants || {};
	const largeurs = (v.avif || []).map((x) => x.width).join(' / ');
	// Poids relevés sur la plus grande variante : c'est celle qui décide du coût réel sur desktop.
	const grande = (l) => (l && l.length ? l[l.length - 1].file : '');
	L.push(
		`| \`${slot}\` | ${entry.width}×${entry.height} | ${largeurs} | AVIF, WebP, JPEG | ` +
			`${poids(grande(v.avif))} | ${poids(grande(v.webp))} | ${poids(grande(v.jpg))} | ` +
			`${entry.alt || '—'} |`
	);
}
L.push('');
L.push('## 3. Fichiers réellement servis par WordPress');
L.push('');
L.push('| Fichier servi | Natif | Affiché | Chargement | Priorité | Routes | Cassée |');
L.push('|---|---|---|---|---|---|---|');
for (const im of [...wpImages.values()].sort((a, b) => b.routes.length - a.routes.length)) {
	L.push(
		`| \`${im.src}\` | ${im.natural} | ${im.w}×${im.h} | ${im.loading} | ${im.priority || '—'} | ` +
			`${im.routes.length} | ${im.casse ? '⚠️ OUI' : 'non'} |`
	);
}
L.push('');
L.push('## 4. Contrôles');
L.push('');
const cassees = [...wpImages.values()].filter((i) => i.casse);
L.push(`- Images cassées côté WordPress : **${cassees.length}**` + (cassees.length ? ' — ' + cassees.map((i) => i.src).join(', ') : ''));
const sansAlt = [...wpImages.values()].filter((i) => !i.alt);
L.push(
	`- Images sans \`alt\` : **${sansAlt.length}** (${sansAlt.map((i) => '`' + i.src + '`').join(', ') || 'aucune'}) — ` +
		"un `alt` vide est correct pour un visuel purement décoratif dont le sens est déjà porté par le texte voisin ; il est fautif partout ailleurs."
);
const lcp = [...wpImages.values()].filter((i) => i.priority === 'high');
L.push(`- Images en \`fetchpriority="high"\` : **${lcp.length}** — une seule par page, celle du LCP (CLAUDE.md §8).`);
L.push('');
L.push('## 5. Ce que ces visuels ne prétendent pas être');
L.push('');
L.push('Aucun visuel du site ne représente une personne, un client ou un local réels. Ce sont des');
L.push('images d’illustration, reprises de la maquette, et leurs `alt` le disent. Le portrait');
L.push('associé à Audrey est explicitement provisoire et remplaçable depuis');
L.push('Apparence → Personnaliser → Équipe (CLAUDE.md §5.6).');

writeFileSync(OUT, L.join('\n') + '\n');
console.error(`Écrit : ${OUT} — ${refImages.size} visuels de maquette, ${wpImages.size} fichiers servis`);
