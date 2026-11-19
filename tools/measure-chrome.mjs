#!/usr/bin/env node
/**
 * Mesure la « coquille » de page — en-tête, pré-pied et pied — des deux côtés.
 *
 * La colonne « hauteur » de tools/compare-routes.mjs mesure `scrollHeight`, c'est-à-dire la page
 * entière, coquille comprise. Un pied de page plus haut d'un côté décale donc *toutes* les routes,
 * et il les décale d'autant plus qu'elles sont courtes : +400 px sur une page de 1 900 px font
 * +21 %, sur une page de 8 000 px ils font +5 %. Avant de retoucher le contenu d'une page courte,
 * il faut savoir ce qui, dans son écart, vient de la coquille et ce qui vient de la page.
 *
 * Usage : node tools/measure-chrome.mjs [--widths=1440,375]
 */
import { chromium } from '@playwright/test';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const widths = ((process.argv.find((a) => a.startsWith('--widths=')) || '').split('=')[1] || '1440,375')
	.split(',')
	.map(Number);
const route = process.argv.slice(2).find((a) => !a.startsWith('--')) || '#/contact';

/**
 * Hauteur cumulée de ce qui précède le premier `<section>` du flux et de ce qui le suit.
 * On raisonne sur le rendu, pas sur les balises : la maquette n'a ni `<header>` ni `<footer>`.
 */
const CHROME = () => {
	const h1 = document.querySelector('h1');
	let root = document.body;
	for (let el = h1; el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			root = el;
			break;
		}
	}
	const rect = root.getBoundingClientRect();
	const haut = rect.top + window.scrollY;
	const total = document.documentElement.scrollHeight;
	const bas = total - (haut + rect.height);
	return { total, haut: Math.round(haut), flux: Math.round(rect.height), bas: Math.round(bas) };
};

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const width of widths) {
	const ref = await browser.newPage({ viewport: { width, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	await ref.evaluate((h) => (location.hash = h.replace(/^#/, '')), route);
	await ref.waitForTimeout(1400);
	const a = await ref.evaluate(CHROME);
	await ref.close();

	const wp = await browser.newPage({ viewport: { width, height: 900 } });
	await wp.goto(WP + ROUTE_MAP[route].wp, { waitUntil: 'networkidle', timeout: 60000 });
	await wp.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 40));
		}
		window.scrollTo(0, 0);
	});
	await wp.waitForTimeout(300);
	const b = await wp.evaluate(CHROME);
	await wp.close();

	console.log(`\n━━━ ${route} à ${width} px ━━━`);
	console.log(`             maquette   WordPress   écart`);
	for (const k of ['haut', 'flux', 'bas', 'total']) {
		const d = b[k] - a[k];
		console.log(
			`${k.padEnd(8)} ${String(a[k]).padStart(9)} ${String(b[k]).padStart(11)} ${(d > 0 ? '+' : '') + d}`.padEnd(50) +
				(k === 'flux' ? `  (${Math.round((b.flux / a.flux) * 100)} % du flux seul)` : '')
		);
	}
}
await browser.close();
