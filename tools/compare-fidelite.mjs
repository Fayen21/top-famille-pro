#!/usr/bin/env node
/**
 * Comparaison mesurée maquette Claude Design ↔ rendu WordPress, famille de pages par famille.
 *
 * Le fichier de référence est un bundle auto-décompressant en JavaScript, doublé d'une navigation
 * à routes `#/` : il est donc réellement exécuté dans Chromium, navigué route par route, puis
 * mesuré — jamais interprété depuis son code minifié.
 *
 * Usage :
 *   node tools/compare-fidelite.mjs                 → matrice de toutes les familles
 *   node tools/compare-fidelite.mjs --shots         → + captures dans docs/captures/fidelite-finale/
 *   node tools/compare-fidelite.mjs --only=prestation
 */
import { chromium } from '@playwright/test';
import { mkdirSync } from 'node:fs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const DIR = 'docs/captures/fidelite-finale';

/** Familles de pages : une page représentative par famille, des deux côtés. */
export const FAMILIES = [
	{ key: 'accueil', ref: '#/', wp: '/' },
	{ key: 'prestation', ref: '#/service/bureaux', wp: '/prestations/bureaux/' },
	{ key: 'tarifs', ref: '#/nos-tarifs', wp: '/tarifs/' },
	{ key: 'departement', ref: '#/departement/cote-dor', wp: '/zones-intervention/cote-dor/' },
	{ key: 'ville', ref: '#/ville/dijon', wp: '/zones-intervention/cote-dor/dijon/' },
	{ key: 'commune', ref: '#/ville/beaune', wp: '/zones-intervention/cote-dor/beaune/' },
	{ key: 'article', ref: '#/conseils', wp: '/conseils/' },
	{ key: 'institutionnelle', ref: '#/pourquoi-top-famille-pro', wp: '/pourquoi-nous/' },
	{ key: 'formulaire', ref: '#/demande-de-devis', wp: '/demande-de-devis/' },
	{ key: 'mentions-legales', ref: '#/mentions-legales', wp: '/mentions-legales/' },
	{ key: '404', ref: null, wp: '/cette-page-n-existe-pas/' },
];

/** Neutralise les animations pour que deux captures du même état soient comparables. */
const FREEZE_CSS = `*,*::before,*::after{animation:none!important;transition:none!important;
scroll-behavior:auto!important}`;

async function settle(page) {
	await page.addStyleTag({ content: FREEZE_CSS }).catch(() => {});
	// Défilement complet : sans cela, les images en lazy-loading ne sont pas chargées et une
	// capture pleine page les montre comme des rectangles vides.
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 90));
		}
		window.scrollTo(0, 0);
	});
	await page
		.waitForFunction(() => Array.from(document.images).every((i) => i.complete), null, { timeout: 15000 })
		.catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(350);
}

/** Blocs de premier niveau du flux principal, avec leur hauteur mesurée. */
async function blocks(page) {
	return page.evaluate(() => {
		let best = document.body;
		let count = 0;
		for (const el of document.querySelectorAll('body *')) {
			const n = el.querySelectorAll(':scope > section, :scope > header, :scope > footer, :scope > div').length;
			if (n > count && el.getBoundingClientRect().height > 1200) {
				count = n;
				best = el;
			}
		}
		return {
			total: document.documentElement.scrollHeight,
			overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
			images: document.images.length,
			broken: Array.from(document.images).filter((i) => i.naturalWidth === 0).length,
			list: Array.from(best.children)
				.filter((c) => c.getBoundingClientRect().height >= 20)
				.map((c) => {
					const r = c.getBoundingClientRect();
					const h = c.querySelector('h1,h2,h3');
					return {
						h: Math.round(r.height),
						img: c.querySelectorAll('img').length,
						head: h
							? h.textContent.trim().replace(/\s+/g, ' ').slice(0, 44)
							: '(' + (c.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 36) + ')',
					};
				}),
		};
	});
}

async function openRef(browser, hash, width) {
	const page = await browser.newPage({ viewport: { width, height: 900 } });
	await page.goto(REF, { waitUntil: 'load', timeout: 60000 });
	await page.waitForTimeout(5500);
	if (hash && hash !== '#/') {
		await page.evaluate((h) => {
			location.hash = h.replace(/^#/, '');
		}, hash);
		await page.waitForTimeout(1200);
	}
	await settle(page);
	return page;
}

async function openWp(browser, path, width) {
	const page = await browser.newPage({ viewport: { width, height: 900 } });
	await page.goto(WP + path, { waitUntil: 'networkidle', timeout: 60000 });
	await settle(page);
	return page;
}

async function main() {
	const shots = process.argv.includes('--shots');
	const only = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1];
	const widths = shots ? [375, 1440] : [1440];
	if (shots) mkdirSync(DIR, { recursive: true });

	const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
	const families = FAMILIES.filter((f) => !only || f.key === only);

	for (const fam of families) {
		for (const width of widths) {
			let ref = null;
			if (fam.ref) {
				const p = await openRef(browser, fam.ref, width);
				ref = await blocks(p);
				if (shots) await p.screenshot({ path: `${DIR}/ref-${fam.key}-${width}.png`, fullPage: true });
				await p.close();
			}
			const p2 = await openWp(browser, fam.wp, width);
			const wp = await blocks(p2);
			if (shots) await p2.screenshot({ path: `${DIR}/wp-${fam.key}-${width}.png`, fullPage: true });
			await p2.close();

			if (width !== 1440) continue;
			console.log(`\n=== ${fam.key.toUpperCase()} — ref ${fam.ref || '(sans équivalent)'} | wp ${fam.wp}`);
			console.log(
				`    ref ${ref ? ref.list.length + ' blocs / ' + ref.total + 'px' : '-'} | ` +
					`wp ${wp.list.length} blocs / ${wp.total}px | débordement ${wp.overflow > 0 ? 'OUI +' + wp.overflow : 'non'} | ` +
					`images ${wp.images} (cassées ${wp.broken})`
			);
			const n = Math.max(ref ? ref.list.length : 0, wp.list.length);
			for (let i = 0; i < n; i++) {
				const a = ref && ref.list[i];
				const c = wp.list[i];
				const d = a && c ? c.h - a.h : null;
				const flag = d === null ? (a ? 'MANQUANT côté WP' : 'en plus côté WP') : Math.abs(d) <= 8 ? 'identique' : Math.abs(d) <= 40 ? 'proche' : 'écart';
				console.log(
					`  ${String(i + 1).padStart(2)} | ${String(a ? a.head : '—').padEnd(44).slice(0, 44)} | ${String(c ? c.head : '—').padEnd(44).slice(0, 44)} | ` +
						`${String(a ? a.h : '-').padStart(4)}→${String(c ? c.h : '-').padStart(4)} ${flag}`
				);
			}
		}
	}
	await browser.close();
}

main().catch((e) => {
	console.error(e);
	process.exit(1);
});
