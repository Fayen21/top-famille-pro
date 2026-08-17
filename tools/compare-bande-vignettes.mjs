#!/usr/bin/env node
/**
 * Comparaison RAPPROCHÉE de la bande « Nos six prestations » du pilier — G25 phase D.
 *
 * Les triptyques pleine page rendent cette bande à ~320 px de large : trop petit pour juger les
 * six vignettes ajoutées en G25. Cet outil capture LA BANDE SEULE des deux côtés (élément
 * englobant, même largeur de fenêtre) et produit le triptyque
 * docs/captures/comparaison/pilier-bande-vignettes-<largeur>.jpg au même format que les autres
 * (référence | WordPress | différence), panneau élargi à 480 px pour la lisibilité.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/compare-bande-vignettes.mjs
 */
import { chromium } from '@playwright/test';
import { mkdirSync } from 'node:fs';
import sharp from 'sharp';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const SHOT_DIR = 'docs/captures/comparaison';
const PANEL = 480;
/* En plus du gel des animations : l'en-tête collant est rendu statique pendant la capture — une
   découpe en pleine page photographie sinon l'en-tête à sa position de défilement, par-dessus la
   bande, des deux côtés. C'est un artefact de la méthode de capture, pas une différence de page. */
const FREEZE = `*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
header,.tfp-header,[data-tfp-header],[style*="position:sticky"],[style*="position: sticky"]{position:static!important}`;

mkdirSync(SHOT_DIR, { recursive: true });

/** La bande : la section qui contient le H2 « Nos six prestations ». */
const CIBLE = () => {
	const h = [...document.querySelectorAll('h2')].find((x) => /Nos six prestations/.test(x.textContent || ''));
	return h ? h.closest('section') : null;
};

async function capturerBande(page) {
	await page.addStyleTag({ content: FREEZE }).catch(() => {});
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += 700) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 60));
		}
	});
	await page.waitForFunction(() => [...document.images].every((i) => i.complete), null, { timeout: 15000 }).catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(300);
	const boite = await page.evaluate((fn) => {
		const el = eval(fn)();
		if (!el) return null;
		el.scrollIntoView();
		const r = el.getBoundingClientRect();
		return { x: Math.max(0, r.x), y: r.y + window.scrollY, width: r.width, height: r.height };
	}, `(${CIBLE.toString()})`);
	if (!boite) throw new Error('bande introuvable');
	return page.screenshot({ clip: { x: boite.x, y: boite.y, width: boite.width, height: boite.height }, fullPage: true });
}

async function triptych(refBuf, wpBuf, out) {
	const [ab, bb] = await Promise.all([
		sharp(refBuf).resize({ width: PANEL }).png().toBuffer(),
		sharp(wpBuf).resize({ width: PANEL }).png().toBuffer(),
	]);
	const [am, bm] = await Promise.all([sharp(ab).metadata(), sharp(bb).metadata()]);
	const H = Math.max(am.height, bm.height);
	const pad = (buf) =>
		sharp({ create: { width: PANEL, height: H, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [ap, bp] = await Promise.all([pad(ab), pad(bb)]);
	const diff = await sharp(ap).composite([{ input: bp, blend: 'difference' }]).negate().png().toBuffer();
	await sharp({ create: { width: PANEL * 3 + 16, height: H, channels: 3, background: '#d0d0d0' } })
		.composite([
			{ input: ap, top: 0, left: 0 },
			{ input: bp, top: 0, left: PANEL + 8 },
			{ input: diff, top: 0, left: (PANEL + 8) * 2 },
		])
		.jpeg({ quality: 78, mozjpeg: true })
		.toFile(out);
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
for (const width of [375, 1440]) {
	const ref = await browser.newPage({ viewport: { width, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	await ref.evaluate(() => { location.hash = '/nettoyage-professionnel'; });
	await ref.waitForTimeout(1100);
	const refShot = await capturerBande(ref);
	await ref.close();

	const wp = await browser.newPage({ viewport: { width, height: 900 } });
	await wp.goto(WP + '/nettoyage-professionnel/', { waitUntil: 'networkidle', timeout: 60000 });
	const wpShot = await capturerBande(wp);
	await wp.close();

	const out = `${SHOT_DIR}/pilier-bande-vignettes-${width}.jpg`;
	await triptych(refShot, wpShot, out);
	console.log(`écrit : ${out}`);
}
await browser.close();
