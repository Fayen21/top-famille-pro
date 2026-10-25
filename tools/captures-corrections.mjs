#!/usr/bin/env node
/**
 * Captures avant/après de la passe de corrections du 25 octobre 2026 (revue des trois ZIP).
 *
 * Trois modes, documentés dans le rapport :
 *  - `composant` : capture PROPRE d'un composant, en-tête collant remis dans le flux et barre
 *    d'action mobile masquée (`figerCouches`) — pour lire le contenu ;
 *  - `fenetre`   : capture de la FENÊTRE réelle à une position de défilement, couches fixes
 *    comprises — pour juger leur comportement en navigation ;
 *  - `page`      : pleine page, après défilement complet et décodage de toutes les images.
 *
 * Usage :
 *   TFP_BASE_URL=http://localhost:8901 node tools/captures-corrections.mjs avant|apres [--only=a,b]
 *   → docs/captures-corrections/<etiquette>/*.png + bilan.json
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';
import { preparer, figerCouches } from './lib/capture-fiable.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const ETIQUETTE = (process.argv[2] || 'apres').replace(/^--.*/, '') || 'apres';
const ONLY = ((process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1] || '').split(',').filter(Boolean);
const SORTIE = join('docs', 'captures-corrections', ETIQUETTE);
mkdirSync(SORTIE, { recursive: true });

const groupe = (texte) => (page) => page.locator('section').filter({ has: page.locator('h2', { hasText: texte }) }).last();
const VILLES = {
	besancon: 'doubs', auxerre: 'yonne', belfort: 'territoire-de-belfort', nevers: 'nievre', vesoul: 'haute-saone',
	'chalon-sur-saone': 'saone-et-loire', macon: 'saone-et-loire', dole: 'jura', 'lons-le-saunier': 'jura', beaune: 'cote-dor',
};
const DEPTS = ['cote-dor', 'doubs', 'jura', 'nievre', 'haute-saone', 'saone-et-loire', 'yonne', 'territoire-de-belfort'];

const ouvrirMenuMobile = async (page) => {
	await page.click('[data-tfp-mobile-open]');
	await page.waitForTimeout(200);
	await page.click('#tfp-mobile-btn-zones');
	await page.waitForTimeout(200);
};
const CAPTURES = [
	...Object.entries(VILLES).map(([v, d]) => ({ nom: `maillage-${v}-375`, route: `/zones-intervention/${d}/${v}/`, largeur: 375, mode: 'composant', loc: groupe('Dans le même département') })),
	...DEPTS.map((d) => ({ nom: `departement-${d}-375`, route: `/zones-intervention/${d}/`, largeur: 375, mode: 'composant', loc: (p) => p.locator('.tfp-zone-links').filter({ has: p.locator('.tfp-chip-row--10') }).last() })),
	{ nom: 'tarif-prestation-bureaux-375', route: '/prestations/bureaux/', largeur: 375, mode: 'composant', loc: (p) => p.locator('.tfp-price-card').first() },
	{ nom: 'tarif-prestation-bureaux-1440', route: '/prestations/bureaux/', largeur: 1440, mode: 'composant', loc: (p) => p.locator('.tfp-price-card').first() },
	{ nom: 'ponctuel-375', route: '/prestations/ponctuel/', largeur: 375, mode: 'page' },
	{ nom: 'ponctuel-1440', route: '/prestations/ponctuel/', largeur: 1440, mode: 'page' },
	{ nom: 'exemple-saint-apollinaire-375', route: '/zones-intervention/cote-dor/saint-apollinaire/', largeur: 375, mode: 'composant', loc: groupe(/^Tarif/) },
	{ nom: 'exemple-dijon-1440', route: '/zones-intervention/cote-dor/dijon/', largeur: 1440, mode: 'composant', loc: groupe(/^Tarif/) },
	{ nom: 'devis-etape1-haut-375', route: '/demande-de-devis/', largeur: 375, mode: 'fenetre', position: 'haut' },
	{ nom: 'devis-etape1-bas-375', route: '/demande-de-devis/', largeur: 375, mode: 'fenetre', position: 'bas' },
	{ nom: 'devis-etape2-375', route: '/demande-de-devis/', largeur: 375, mode: 'fenetre', position: 'haut', action: async (p) => {
		await p.selectOption('#tfp-type-locaux', 'bureaux'); await p.selectOption('#tfp-regime', 'regulier');
		await p.fill('#tfp-nom', 'Revue visuelle'); await p.fill('#tfp-telephone', '0600000000');
		await p.click('[data-step-next]'); await p.waitForTimeout(300);
	} },
	{ nom: 'recrutement-bas-375', route: '/recrutement/', largeur: 375, mode: 'fenetre', position: 'bas' },
	{ nom: 'contact-bas-375', route: '/contact/', largeur: 375, mode: 'fenetre', position: 'bas' },
	{ nom: 'mentions-bas-375', route: '/mentions-legales/', largeur: 375, mode: 'fenetre', position: 'bas' },
	{ nom: 'dijon-fin-375', route: '/zones-intervention/cote-dor/dijon/', largeur: 375, mode: 'fenetre', position: 'avant-pied' },
	{ nom: 'accueil-fin-1440', route: '/', largeur: 1440, mode: 'fenetre', position: 'avant-pied' },
	{ nom: 'menu-mobile-375x812', route: '/', largeur: 375, hauteur: 812, mode: 'fenetre', position: 'haut', action: ouvrirMenuMobile },
	{ nom: 'menu-mobile-bas-375x560', route: '/', largeur: 375, hauteur: 560, mode: 'fenetre', position: 'haut', action: async (p) => {
		await ouvrirMenuMobile(p);
		await p.evaluate(() => { const n = document.querySelector('.tfp-mobile-nav__panel, .tfp-mobile-nav'); const s = [...document.querySelectorAll('.tfp-mobile-nav *')].find((e) => e.scrollHeight > e.clientHeight + 4 && /auto|scroll/.test(getComputedStyle(e).overflowY)) || n; s.scrollTop = s.scrollHeight; });
		await p.waitForTimeout(200);
	} },
	{ nom: 'footer-375', route: '/', largeur: 375, mode: 'composant', loc: (p) => p.locator('footer.tfp-footer') },
	{ nom: 'etapes-375', route: '/', largeur: 375, mode: 'composant', loc: (p) => p.locator('section:has(.tfp-etape)') },
	{ nom: 'etapes-768', route: '/', largeur: 768, mode: 'composant', loc: (p) => p.locator('section:has(.tfp-etape)') },
	{ nom: 'carte-375', route: '/', largeur: 375, mode: 'composant', loc: (p) => p.locator('.tfp-couverture') },
	{ nom: 'carte-1440', route: '/', largeur: 1440, mode: 'composant', loc: (p) => p.locator('.tfp-couverture') },
	{ nom: 'gerante-375', route: '/', largeur: 375, mode: 'composant', loc: (p) => p.locator('section:has(.tfp-audrey-portrait)') },
	{ nom: 'prestations-index-1440', route: '/prestations/', largeur: 1440, mode: 'page' },
	{ nom: 'prestations-index-375', route: '/prestations/', largeur: 375, mode: 'page' },
	{ nom: 'accueil-1440', route: '/', largeur: 1440, mode: 'page' },
	{ nom: 'accueil-375', route: '/', largeur: 375, mode: 'page' },
];

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const bilan = {};
let echecs = 0;
for (const c of CAPTURES) {
	if (ONLY.length && !ONLY.includes(c.nom)) continue;
	const page = await navigateur.newPage({ viewport: { width: c.largeur, height: c.hauteur || (c.largeur < 768 ? 812 : 900) } });
	const chemin = join(SORTIE, c.nom + '.png');
	try {
		await page.goto(WP + c.route, { waitUntil: 'load', timeout: 60000 });
		const prep = await preparer(page);
		if (c.action) await c.action(page);
		if (c.mode === 'page') {
			await page.screenshot({ path: chemin, fullPage: true });
		} else if (c.mode === 'fenetre') {
			if (c.position === 'bas') await page.evaluate(() => window.scrollTo(0, document.documentElement.scrollHeight));
			if (c.position === 'avant-pied') await page.evaluate(() => { const f = document.querySelector('footer.tfp-footer'); window.scrollTo(0, f.getBoundingClientRect().top + window.scrollY - window.innerHeight * 0.8); });
			await page.waitForTimeout(250);
			await page.screenshot({ path: chemin });
		} else {
			await figerCouches(page);
			const el = c.loc(page);
			if (!(await el.count())) throw new Error('composant absent');
			await el.scrollIntoViewIfNeeded();
			await el.screenshot({ path: chemin });
		}
		bilan[c.nom] = { route: c.route, largeur: c.largeur, mode: c.mode, images: prep };
		console.log(`✓ ${c.nom}${prep.rendues_non_chargees.length ? ' ⚠ images non chargées : ' + prep.rendues_non_chargees.join(', ') : ''}`);
	} catch (e) {
		echecs++;
		bilan[c.nom] = { route: c.route, erreur: String(e.message).split('\n')[0] };
		console.log(`✗ ${c.nom} — ${bilan[c.nom].erreur}`);
	}
	await page.close();
}
await navigateur.close();
writeFileSync(join(SORTIE, 'bilan.json'), JSON.stringify(bilan, null, 1) + '\n');
console.log(`\n${Object.keys(bilan).length} captures → ${SORTIE} · ${echecs} échec(s)`);
