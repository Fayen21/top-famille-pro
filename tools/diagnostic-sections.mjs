#!/usr/bin/env node
/**
 * Diagnostic bande par bande d'une route — maquette Claude Design ↔ WordPress.
 *
 * Un ratio de hauteur global ne dit pas *où* manquent les pixels. Corriger un déficit de 12 % en
 * augmentant un rembourrage global reviendrait à répartir l'erreur partout plutôt qu'à la corriger
 * là où elle est. Cet outil aligne les bandes des deux côtés, mesure chacune, et donne le **delta
 * en pixels** de chaque bande, avec les propriétés qui l'expliquent.
 *
 * La somme des deltas doit rendre compte de l'essentiel de l'écart total : si ce n'est pas le cas,
 * c'est que l'appariement des bandes est faux, et le diagnostic est à revoir avant toute correction.
 *
 * Usage :
 *   node tools/diagnostic-sections.mjs '#/zones-intervention'
 *   node tools/diagnostic-sections.mjs '#/contact' --widths=375
 */
import { chromium } from '@playwright/test';
import { appendFileSync, writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';

const arg = (n) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1];
const route = process.argv.slice(2).find((a) => !a.startsWith('--')) || '#/zones-intervention';
const widths = (arg('widths') || '1440').split(',').map(Number);
const sortie = arg('out') || '';

/** Relevé de chaque bande : géométrie, contenu, et styles calculés qui décident de sa hauteur. */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}

	return [...flux.children]
		.filter((c) => c.getBoundingClientRect().height >= 20)
		.map((sec, i) => {
			const cs = getComputedStyle(sec);
			const r = sec.getBoundingClientRect();
			const titre = sec.querySelector('h1,h2,h3');

			// Conteneur de contenu : le plus large descendant qui borne réellement le texte.
			const conteneur =
				[...sec.querySelectorAll('div')].find((d) => {
					const dr = d.getBoundingClientRect();
					return dr.width > 200 && dr.width < r.width && d.children.length >= 1;
				}) || sec;

			// Cartes de la bande, au sens du rendu : arrondies et détachées du fond.
			const cartes = [...sec.querySelectorAll('*')].filter((el) => {
				const s = getComputedStyle(el);
				const b = el.getBoundingClientRect();
				if (b.width < 60 || b.height < 24) return false;
				const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
				return parseFloat(s.borderTopLeftRadius) >= 6 && (fond || parseFloat(s.borderTopWidth) > 0);
			});

			// Grille dominante de la bande : celle qui range le plus d'enfants.
			const grille = [...sec.querySelectorAll('div,ul,ol')]
				.filter((g) => getComputedStyle(g).display === 'grid' && g.children.length >= 2)
				.sort((a, b) => b.children.length - a.children.length)[0];
			const gs = grille ? getComputedStyle(grille) : null;

			// Rangs distincts : deux cartes de même ordonnée sont sur le même rang.
			const ordonnees = new Set(cartes.map((c) => Math.round(c.getBoundingClientRect().top / 8)));

			const corps = sec.querySelector('p') || titre;
			const ccs = corps ? getComputedStyle(corps) : cs;

			return {
				i: i + 1,
				titre: txt(titre).slice(0, 44) || '(sans titre)',
				y: Math.round(r.top + window.scrollY),
				h: Math.round(r.height),
				padHaut: cs.paddingTop,
				padBas: cs.paddingBottom,
				fond: cs.backgroundColor,
				largeur: Math.round(conteneur.getBoundingClientRect().width),
				cartes: cartes.length,
				rangs: ordonnees.size,
				colonnes: gs ? gs.gridTemplateColumns.split(' ').filter((x) => parseFloat(x) > 1).length : 0,
				gap: gs ? gs.gap : '—',
				flow: gs ? gs.gridAutoFlow : '—',
				align: gs ? gs.alignItems : '—',
				police: ccs.fontSize,
				interligne: ccs.lineHeight,
				mots: txt(sec).split(/\s+/).filter(Boolean).length,
			};
		});
};

/**
 * Apparie les bandes des deux côtés.
 *
 * Sur le titre quand il existe — c'est le repère le plus stable —, sinon sur le rang. Un
 * appariement par index seul se décale dès qu'une bande manque d'un côté, et tous les deltas
 * suivants deviennent faux sans qu'on le voie.
 */
function apparier(a, b) {
	const cle = (s) => s.titre.toLowerCase().replace(/[^a-z0-9]/g, '').slice(0, 26);
	const restants = b.map((s, i) => ({ ...s, i2: i, pris: false }));
	const paires = [];
	for (const x of a) {
		let y = null;
		if (x.titre !== '(sans titre)') y = restants.find((z) => !z.pris && cle(z) === cle(x));
		if (!y) y = restants.find((z) => !z.pris && z.i === x.i);
		if (y) y.pris = true;
		paires.push([x, y]);
	}
	for (const z of restants) if (!z.pris) paires.push([null, z]);
	return paires;
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const lignes = [];

for (const largeur of widths) {
	const ref = await browser.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	await ref.evaluate((h) => {
		window.scrollTo(0, 0);
		location.hash = h.replace(/^#/, '');
	}, route);
	await ref.waitForTimeout(1400);
	const a = await ref.evaluate(RELEVE);
	const totalA = await ref.evaluate(() => document.documentElement.scrollHeight);
	await ref.close();

	const wp = await browser.newPage({ viewport: { width: largeur, height: 900 } });
	await wp.goto(WP + ROUTE_MAP[route].wp, { waitUntil: 'networkidle', timeout: 60000 });
	await wp.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 40));
		}
		window.scrollTo(0, 0);
	});
	await wp.waitForTimeout(300);
	const b = await wp.evaluate(RELEVE);
	const totalB = await wp.evaluate(() => document.documentElement.scrollHeight);
	await wp.close();

	const paires = apparier(a, b);
	const L = [];
	L.push(`\n━━━━━━ ${route} à ${largeur} px — total ${totalA} → ${totalB} (${Math.round((totalB / totalA) * 100)} %), écart ${totalB - totalA} px`);
	L.push('');
	L.push('| # | Bande | Y réf | Y WP | H réf | H WP | Δ px | Ratio | Cartes | Rangs | Col. | Pad réf | Pad WP | Gap réf | Gap WP | Police | Largeur |');
	L.push('|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|');

	let somme = 0;
	for (const [x, y] of paires) {
		if (!x) {
			L.push(`| ${y.i} | ${y.titre} | — | ${y.y} | — | ${y.h} | **+${y.h}** | bande en trop | — | — | — | — | ${y.padHaut}/${y.padBas} | — | ${y.gap} | — | — |`);
			somme += y.h;
			continue;
		}
		if (!y) {
			L.push(`| ${x.i} | ${x.titre} | ${x.y} | — | ${x.h} | — | **−${x.h}** | bande absente | ${x.cartes} | ${x.rangs} | ${x.colonnes} | ${x.padHaut}/${x.padBas} | — | ${x.gap} | — | ${x.police} | ${x.largeur} |`);
			somme -= x.h;
			continue;
		}
		const d = y.h - x.h;
		somme += d;
		const marque = Math.abs(d) >= 60 ? '**' : '';
		L.push(
			`| ${x.i} | ${x.titre} | ${x.y} | ${y.y} | ${x.h} | ${y.h} | ${marque}${d > 0 ? '+' : ''}${d}${marque} | ${Math.round((y.h / x.h) * 100)} % | ` +
				`${x.cartes} → ${y.cartes} | ${x.rangs} → ${y.rangs} | ${x.colonnes} → ${y.colonnes} | ${x.padHaut}/${x.padBas} | ${y.padHaut}/${y.padBas} | ` +
				`${x.gap} | ${y.gap} | ${x.police} → ${y.police} | ${x.largeur} → ${y.largeur} |`
		);
	}
	L.push('');
	L.push(
		`**Somme des deltas de bande : ${somme > 0 ? '+' : ''}${somme} px** — écart total mesuré ${totalB - totalA} px. ` +
			`Reste inexpliqué par les bandes : ${totalB - totalA - somme} px (en-tête, pré-pied et pied de page).`
	);
	console.log(L.join('\n'));
	lignes.push(...L);
}
await browser.close();

if (sortie) {
	writeFileSync(sortie, lignes.join('\n') + '\n');
	console.error(`\nÉcrit : ${sortie}`);
}
