#!/usr/bin/env node
/**
 * Comparaison visuelle des DEUX ÉTAPES du formulaire de devis — G24 phase D.
 *
 * `tools/compare-routes.mjs` compare les 53 routes à l'état de chargement : pour
 * /demande-de-devis/ cela ne montre que l'étape 1. Cet outil pilote les deux versions du
 * formulaire de la même façon — mêmes valeurs, même enchaînement — et produit les triptyques
 * « référence | WordPress | différence » de l'étape 1 et de l'étape 2, aux mêmes largeurs que le
 * reste des comparaisons (375 et 1440).
 *
 * Aucune donnée n'est envoyée : l'étape 2 de la maquette comme du thème est un changement d'état
 * client, et rien n'est soumis au serveur.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/compare-formulaire.mjs
 */
import { chromium } from '@playwright/test';
import { mkdirSync } from 'node:fs';
import sharp from 'sharp';
import { panneauDifference } from './lib/diff-visuel.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const SHOT_DIR = 'docs/captures/comparaison';
const PANEL = 320;
const FREEZE = `*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}`;

mkdirSync(SHOT_DIR, { recursive: true });

async function settle(page) {
	await page.addStyleTag({ content: FREEZE }).catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(350);
}

async function triptych(refBuf, wpBuf, out) {
	const [ab, bb] = await Promise.all([
		sharp(refBuf).resize({ width: PANEL }).png().toBuffer(),
		sharp(wpBuf).resize({ width: PANEL }).png().toBuffer(),
	]);
	// Panneau de différence amplifié et mesuré (tools/lib/diff-visuel.mjs, G26).
	const { png: diff, hauteur: H } = await panneauDifference(ab, bb);
	const pad = (buf) =>
		sharp({ create: { width: PANEL, height: H, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [ap, bp] = await Promise.all([pad(ab), pad(bb)]);
	await sharp({ create: { width: PANEL * 3 + 16, height: H, channels: 3, background: '#d0d0d0' } })
		.composite([
			{ input: ap, top: 0, left: 0 },
			{ input: bp, top: 0, left: PANEL + 8 },
			{ input: diff, top: 0, left: (PANEL + 8) * 2 },
		])
		.jpeg({ quality: 78, mozjpeg: true })
		.toFile(out);
}

/** Remplit l'étape 1 de la MAQUETTE et passe à l'étape 2 (soumission client, rien n'est envoyé). */
async function maquetteEtape2(page) {
	await page.selectOption('#devis-type', { index: 1 });
	await page.fill('#devis-ville', 'Dijon');
	await page.fill('#devis-nom', 'Capture Test');
	await page.fill('#devis-tel', '0600000000');
	await page.click('button[type="submit"]');
	await page.waitForTimeout(700);
}

/** Remplit l'étape 1 du THÈME et passe à l'étape 2 — les mêmes gestes que la suite de captures. */
async function wpEtape2(page) {
	await page.selectOption('#tfp-type-locaux', 'bureaux');
	await page.check('input[name="regime"][value="regulier"]');
	await page.fill('#tfp-nom', 'Capture Test');
	await page.fill('#tfp-telephone', '0600000000');
	await page.click('[data-step-next]');
	await page.waitForTimeout(700);
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
for (const width of [375, 1440]) {
	for (const etape of [1, 2]) {
		const ref = await browser.newPage({ viewport: { width, height: 900 } });
		await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
		await ref.waitForTimeout(5500);
		await ref.evaluate(() => { location.hash = '/demande-de-devis'; });
		await ref.waitForTimeout(1100);
		if (etape === 2) await maquetteEtape2(ref);
		await settle(ref);
		const refShot = await ref.screenshot({ fullPage: true });
		await ref.close();

		const wp = await browser.newPage({ viewport: { width, height: 900 } });
		await wp.goto(WP + '/demande-de-devis/', { waitUntil: 'networkidle', timeout: 60000 });
		if (etape === 2) await wpEtape2(wp);
		await settle(wp);
		const wpShot = await wp.screenshot({ fullPage: true });
		await wp.close();

		const out = `${SHOT_DIR}/formulaire-etape-${etape}-${width}.jpg`;
		await triptych(refShot, wpShot, out);
		console.log(`écrit : ${out}`);
	}
}
await browser.close();
