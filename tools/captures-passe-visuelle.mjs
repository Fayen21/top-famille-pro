#!/usr/bin/env node
/**
 * Captures ciblées de la passe visuelle du 14 octobre 2026 — avant et après correction.
 *
 * Six composants nommés par le brief, aux largeurs où leurs défauts se voient, plus l'accueil
 * complet à 375 et 1440 px. Chaque capture est un ÉLÉMENT (pas un recadrage de page) : si le
 * sélecteur ne trouve rien, le script le dit au lieu de produire une image vide.
 *
 * Les six captures du 14 octobre ne sont pas dans le dépôt : ce script produit leurs
 * équivalents sur l'état courant, et c'est sur eux que les corrections sont jugées.
 *
 * Usage :
 *   TFP_BASE_URL=http://localhost:8901 node tools/captures-passe-visuelle.mjs avant
 *   TFP_BASE_URL=http://localhost:8901 node tools/captures-passe-visuelle.mjs apres
 *   → docs/captures-passe-visuelle/<etiquette>/*.png
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const ETIQUETTE = (process.argv[2] || 'avant').replace(/^--.*/, '') || 'avant';
/** `--only=a,b` : ne produire que ces captures (reprise après interruption). */
const ONLY = ((process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1] || '')
	.split(',')
	.filter(Boolean);
const SORTIE = join('docs', 'captures-passe-visuelle', ETIQUETTE);
mkdirSync(SORTIE, { recursive: true });

/** Chaque entrée : nom de fichier, route, largeur, sélecteur, et une préparation facultative. */
const CAPTURES = [
	// §3 — header
	{ nom: 'header-ferme-1440', route: '/', largeur: 1440, sel: '.tfp-header' },
	{
		nom: 'header-zones-ouvert-1440', route: '/', largeur: 1440, sel: 'body',
		zone: { x: 0, y: 0, w: 1440, h: 560 },
		prepare: async (page) => {
			await page.click('#tfp-btn-zones');
			await page.waitForSelector('#tfp-menu-zones:not([hidden])');
		},
	},
	{ nom: 'header-ferme-375', route: '/', largeur: 375, sel: '.tfp-header' },
	{
		nom: 'header-zones-ouvert-375', route: '/', largeur: 375, sel: '.tfp-mobile-nav',
		prepare: async (page) => {
			await page.click('[data-tfp-mobile-open]');
			await page.waitForSelector('#tfp-mobile-nav:not([hidden])');
			await page.click('#tfp-mobile-btn-zones');
			await page.waitForSelector('#tfp-mobile-sub-zones:not([hidden])');
		},
	},
	// Limites de largeur du header
	{ nom: 'header-819', route: '/', largeur: 819, sel: '.tfp-header' },
	{ nom: 'header-820', route: '/', largeur: 820, sel: '.tfp-header' },
	{ nom: 'header-1099', route: '/', largeur: 1099, sel: '.tfp-header' },
	{ nom: 'header-1100', route: '/', largeur: 1100, sel: '.tfp-header' },
	{ nom: 'header-1219', route: '/', largeur: 1219, sel: '.tfp-header' },
	{ nom: 'header-1220', route: '/', largeur: 1220, sel: '.tfp-header' },
	// §4 — villes et codes postaux (noms courts et longs)
	// Sur le hub, les grilles de liens sont, dans l'ordre : départements, dix villes, huit communes.
	// On vise la grille dont la première description est un code postal — pas un rang, qui
	// changerait avec le contenu.
	{ nom: 'villes-1440', route: '/zones-intervention/', largeur: 1440, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 1 },
	{ nom: 'villes-375', route: '/zones-intervention/', largeur: 375, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 1 },
	{ nom: 'villes-768', route: '/zones-intervention/', largeur: 768, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 1 },
	{ nom: 'communes-1440', route: '/zones-intervention/', largeur: 1440, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 2 },
	{ nom: 'communes-375', route: '/zones-intervention/', largeur: 375, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 2 },
	{ nom: 'villes-region-1440', route: '/zones-intervention/bourgogne-franche-comte/', largeur: 1440, sel: '.tfp-card-grid:has(.tfp-card-tile--lien)', index: 1 },
	// §5 — bandeau tarifaire et CTA
	{ nom: 'bandeau-tarif-1440', route: '/', largeur: 1440, sel: '.tfp-price-band-section' },
	{ nom: 'bandeau-tarif-375', route: '/', largeur: 375, sel: '.tfp-price-band-section' },
	{ nom: 'bandeau-zone-1440', route: '/zones-intervention/cote-dor/dijon/', largeur: 1440, sel: '.tfp-zone-band' },
	{ nom: 'bandeau-zone-375', route: '/zones-intervention/cote-dor/dijon/', largeur: 375, sel: '.tfp-zone-band' },
	// §6 — cinq étapes
	{ nom: 'etapes-1440', route: '/', largeur: 1440, sel: 'section:has(.tfp-step), section:has(.tfp-etape)' },
	{ nom: 'etapes-768', route: '/', largeur: 768, sel: 'section:has(.tfp-step), section:has(.tfp-etape)' },
	{ nom: 'etapes-375', route: '/', largeur: 375, sel: 'section:has(.tfp-step), section:has(.tfp-etape)' },
	// §7 — carte régionale
	{ nom: 'carte-1440', route: '/', largeur: 1440, sel: '.tfp-couverture' },
	{ nom: 'carte-375', route: '/', largeur: 375, sel: '.tfp-couverture' },
	// §8 — bloc de la gérante
	{ nom: 'gerante-1440', route: '/', largeur: 1440, sel: 'section:has(.tfp-audrey-portrait)' },
	{ nom: 'gerante-375', route: '/', largeur: 375, sel: 'section:has(.tfp-audrey-portrait)' },
	// Accueil complet
	{ nom: 'accueil-1440', route: '/', largeur: 1440, page: true },
	{ nom: 'accueil-375', route: '/', largeur: 375, page: true },
];

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const mesures = {};
let manquantes = 0;

for (const c of CAPTURES) {
	if (ONLY.length && !ONLY.includes(c.nom)) continue;
	const page = await navigateur.newPage({ viewport: { width: c.largeur, height: 900 } });
	// `load` plutôt que `networkidle` : Chromium tente en permanence de joindre Google, ce que le
	// proxy refuse, et `networkidle` ne se déclenche alors qu'au délai. Les polices sont locales.
	await page.goto(WP + c.route, { waitUntil: 'load', timeout: 60000 });
	await page.waitForTimeout(600);
	await page.addStyleTag({ content: '*{animation:none!important;transition:none!important}' });
	if (c.prepare) await c.prepare(page);
	const chemin = join(SORTIE, c.nom + '.png');
	try {
		if (c.page) {
			await page.screenshot({ path: chemin, fullPage: true });
			mesures[c.nom] = { largeur: c.largeur, hauteur: await page.evaluate(() => document.documentElement.scrollHeight) };
		} else if (c.zone) {
			await page.screenshot({ path: chemin, clip: { x: c.zone.x, y: c.zone.y, width: c.zone.w, height: c.zone.h } });
			mesures[c.nom] = { largeur: c.largeur, zone: c.zone };
		} else {
			const el = page.locator(c.sel).nth(c.index || 0);
			await el.waitFor({ state: 'visible', timeout: 10000 });
			await el.scrollIntoViewIfNeeded();
			const b = await el.boundingBox();
			await el.screenshot({ path: chemin });
			// Pour le portrait : dimensions réelles de l'image (le brief demande l'avant/après).
			// `count()` d'abord : un `boundingBox()` sur un sélecteur absent attend 30 s avant
			// d'échouer — c'est ce qui portait chaque capture à 31 s au lieu d'une seconde.
			const portrait = el.locator('.tfp-audrey-portrait__img').first();
			const img = (await portrait.count()) ? await portrait.boundingBox() : null;
			mesures[c.nom] = { largeur: c.largeur, boite: b && { w: Math.round(b.width), h: Math.round(b.height) }, portrait: img && { w: Math.round(img.width), h: Math.round(img.height) } };
		}
		console.log(`✓ ${c.nom}`, JSON.stringify(mesures[c.nom]));
	} catch (e) {
		manquantes++;
		console.log(`✗ ${c.nom} — ${String(e.message).split('\n')[0]}`);
	}
	await page.close();
}
await navigateur.close();
writeFileSync(join(SORTIE, 'mesures.json'), JSON.stringify(mesures, null, 1) + '\n');
console.log(`\n${CAPTURES.length - manquantes}/${CAPTURES.length} captures → ${SORTIE}`);
process.exit(manquantes ? 1 : 0);
