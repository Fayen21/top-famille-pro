#!/usr/bin/env node
/**
 * Captures avant/après de la passe commerciale du 10 novembre 2026 (premier écran, images,
 * pages prestations et locales, exemple de suivi, formulaire de devis, header).
 *
 * Même moteur et mêmes modes que tools/captures-corrections.mjs :
 *  - `fenetre` : la fenêtre réelle (couches fixes comprises), en haut de page ou après défilement ;
 *  - `page`    : pleine page, couches fixes figées ;
 *  - `composant` : un composant seul, couches fixes figées.
 * Chaque vue existe à 375 et 1440 px.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/captures-passe-commerciale.mjs avant|apres [--only=a,b]
 *   → docs/captures-passe-commerciale/<etiquette>/*.png + bilan.json
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';
import { preparer, figerCouches } from './lib/capture-fiable.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const ETIQUETTE = (process.argv[2] || 'apres').replace(/^--.*/, '') || 'apres';
const ONLY = ((process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1] || '').split(',').filter(Boolean);
const SORTIE = join('docs', 'captures-passe-commerciale', ETIQUETTE);
mkdirSync(SORTIE, { recursive: true });

const etape2 = async (p) => {
	await p.selectOption('#tfp-type-locaux', 'bureaux');
	await p.selectOption('#tfp-regime', 'regulier');
	await p.fill('#tfp-ville-visible', 'Dijon');
	await p.fill('#tfp-nom', 'Revue visuelle');
	await p.fill('#tfp-telephone', '0600000000');
	await p.click('[data-step-next]');
	await p.waitForTimeout(300);
	await p.evaluate(() => document.querySelector('#tfp-formulaire-devis').scrollIntoView());
	await p.waitForTimeout(200);
};

const VUES = [
	{ nom: 'accueil-ecran', route: '/', mode: 'fenetre' },
	{ nom: 'accueil-page', route: '/', mode: 'page' },
	{ nom: 'header', route: '/tarifs/', mode: 'composant', loc: (p) => p.locator('header.tfp-header') },
	{ nom: 'bureaux-ecran', route: '/prestations/bureaux/', mode: 'fenetre' },
	{ nom: 'bureaux-page', route: '/prestations/bureaux/', mode: 'page' },
	{ nom: 'coproprietes-ecran', route: '/prestations/coproprietes/', mode: 'fenetre' },
	{ nom: 'cabinets-ecran', route: '/prestations/cabinets/', mode: 'fenetre' },
	{ nom: 'commerces-ecran', route: '/prestations/commerces/', mode: 'fenetre' },
	{ nom: 'meubles-ecran', route: '/prestations/meubles/', mode: 'fenetre' },
	{ nom: 'ponctuel-ecran', route: '/prestations/ponctuel/', mode: 'fenetre' },
	{ nom: 'prestations-index', route: '/prestations/', mode: 'page' },
	{ nom: 'dijon-page', route: '/zones-intervention/cote-dor/dijon/', mode: 'page' },
	{ nom: 'pilier-page', route: '/nettoyage-professionnel/', mode: 'page' },
	{ nom: 'tarifs-page', route: '/tarifs/', mode: 'page' },
	{ nom: 'devis-etape1', route: '/demande-de-devis/', mode: 'composant', loc: (p) => p.locator('#tfp-formulaire-devis') },
	{ nom: 'devis-etape2', route: '/demande-de-devis/', mode: 'composant', loc: (p) => p.locator('#tfp-formulaire-devis'), action: etape2 },
];
const CAPTURES = VUES.flatMap((v) => [ 375, 1440 ].map((largeur) => ({ ...v, nom: `${v.nom}-${largeur}`, largeur })));

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const bilan = {};
let echecs = 0;
for (const c of CAPTURES) {
	if (ONLY.length && !ONLY.some((o) => c.nom.startsWith(o))) continue;
	const page = await navigateur.newPage({ viewport: { width: c.largeur, height: c.largeur < 768 ? 812 : 900 } });
	const chemin = join(SORTIE, c.nom + '.png');
	try {
		await page.goto(WP + c.route, { waitUntil: 'load', timeout: 60000 });
		const prep = await preparer(page);
		if (c.action) await c.action(page);
		if (c.mode === 'page') {
			await figerCouches(page);
			await page.screenshot({ path: chemin, fullPage: true });
		} else if (c.mode === 'fenetre') {
			await page.waitForTimeout(250);
			await page.screenshot({ path: chemin });
		} else {
			await figerCouches(page);
			const el = c.loc(page);
			if (!(await el.count())) throw new Error('composant absent');
			await el.first().screenshot({ path: chemin });
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
