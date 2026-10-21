#!/usr/bin/env node
/**
 * Dump lisible d'une route de la maquette, section par section, depuis l'extraction déjà faite.
 *
 * Sert de cahier des charges pour reproduire la route dans WordPress : on veut voir, dans l'ordre,
 * quels titres et quels textes appartiennent à quelle section — ce que la matrice globale
 * (docs/MATRICE-ROUTES-CLAUDE-WORDPRESS.md) ne montre pas puisqu'elle liste titres et paragraphes
 * séparément.
 *
 * Usage : node tools/dump-route.mjs '#/service/bureaux'
 */
import { chromium } from '@playwright/test';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const hash = process.argv[2];
if (!hash) {
	console.error("Usage : node tools/dump-route.mjs '#/service/bureaux'");
	process.exit(1);
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);
await page.evaluate((h) => {
	location.hash = h.replace(/^#/, '');
}, hash);
await page.waitForTimeout(1400);
await page.evaluate(async () => {
	for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
		window.scrollTo(0, y);
		await new Promise((r) => setTimeout(r, 60));
	}
	window.scrollTo(0, 0);
});

const out = await page.evaluate(() => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
	let root = document.body;
	let count = 0;
	for (const el of document.querySelectorAll('body *')) {
		const n = el.querySelectorAll(':scope > section, :scope > header, :scope > footer, :scope > main, :scope > div').length;
		if (n > count && el.getBoundingClientRect().height > 1000) {
			count = n;
			root = el;
		}
	}
	const lines = [];
	[...root.children].forEach((c, i) => {
		const r = c.getBoundingClientRect();
		if (r.height < 20) return;
		lines.push(`\n━━━ SECTION ${i + 1} — <${c.tagName.toLowerCase()}> ${Math.round(r.height)} px — fond ${getComputedStyle(c).backgroundColor}`);
		// Parcours en profondeur : on n'imprime que les nœuds porteurs de texte ou d'image, dans
		// l'ordre du document, pour restituer l'enchaînement réel de la section.
		const walk = (el, depth) => {
			for (const n of el.children) {
				const tag = n.tagName.toLowerCase();
				if (/^h[1-6]$/.test(tag)) lines.push(`${'  '.repeat(depth)}[${tag}] ${txt(n)}`);
				else if (tag === 'p') lines.push(`${'  '.repeat(depth)}[p] ${txt(n)}`);
				else if (tag === 'li') lines.push(`${'  '.repeat(depth)}[li] ${txt(n)}`);
				else if (tag === 'img') lines.push(`${'  '.repeat(depth)}[img] alt="${n.getAttribute('alt') || ''}" ${Math.round(n.getBoundingClientRect().width)}×${Math.round(n.getBoundingClientRect().height)}`);
				else if (tag === 'a' && !n.querySelector('h1,h2,h3,h4,p,li,img')) lines.push(`${'  '.repeat(depth)}[a→${n.getAttribute('href')}] ${txt(n)}`);
				else if (tag === 'button') lines.push(`${'  '.repeat(depth)}[button] ${txt(n)}`);
				else if (!n.children.length && txt(n)) lines.push(`${'  '.repeat(depth)}[${tag}] ${txt(n)}`);
				else walk(n, depth + 1);
			}
		};
		walk(c, 1);
	});
	return lines.join('\n');
});

console.log(out);
await browser.close();
