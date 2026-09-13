#!/usr/bin/env node
/**
 * Qualification LCP — G24 phase B.
 *
 * Pour chaque route et chaque largeur : TROIS navigations à cache froid (un contexte neuf par
 * navigation), et la MÉDIANE des trois. Relève pour chacune :
 *  - l'élément LCP réel (dernière entrée `largest-contentful-paint`) : sélecteur, balise, taille ;
 *  - la ressource associée (URL), ses dimensions intrinsèques et rendues ;
 *  - `loading`, `fetchpriority`, présence d'un preload la ciblant ;
 *  - l'heure de découverte et la priorité réseau (CDP Network.requestWillBeSent) ;
 *  - les téléchargements doubles d'un même slot d'image (variante mobile ET desktop).
 *
 * Les durées sont des mesures de banc local : elles qualifient l'ÉLÉMENT et la mécanique de
 * chargement, pas la performance en production.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/sonde-lcp.mjs [--routes=/a/,/b/] [--widths=375,1440]
 */
import { chromium } from '@playwright/test';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const arg = (n) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1];
const ROUTES = (arg('routes') || '/nettoyage-professionnel/,/zones-intervention/bourgogne-franche-comte/,/a-propos/,/recrutement/,/').split(',').filter(Boolean);
const WIDTHS = (arg('widths') || '375,1440').split(',').map(Number);
const RUNS = 3;

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

/** Une navigation à cache froid ; retourne le relevé complet. */
async function mesurer(route, width) {
	const ctx = await browser.newContext({ viewport: { width, height: 900 } });
	const page = await ctx.newPage();
	const cdp = await ctx.newCDPSession(page);
	await cdp.send('Network.enable');
	const requetes = new Map(); // url -> { priorite, t }
	let t0 = null;
	cdp.on('Network.requestWillBeSent', (e) => {
		if (t0 === null) t0 = e.timestamp;
		if (!requetes.has(e.request.url)) {
			requetes.set(e.request.url, { priorite: e.request.initialPriority, t: Math.round((e.timestamp - t0) * 1000) });
		}
	});

	await page.addInitScript(() => {
		window.__lcp = [];
		new PerformanceObserver((l) => {
			for (const e of l.getEntries()) {
				let sel = '';
				let attrs = {};
				if (e.element) {
					const el = e.element;
					sel = el.tagName.toLowerCase() + (el.id ? '#' + el.id : '') + (el.className && typeof el.className === 'string' ? '.' + el.className.trim().split(/\s+/).slice(0, 2).join('.') : '');
					const r = el.getBoundingClientRect();
					attrs = {
						rendu: Math.round(r.width) + '×' + Math.round(r.height),
						visible: r.top < window.innerHeight && r.bottom > 0,
						loading: el.getAttribute && (el.getAttribute('loading') || ''),
						fetchpriority: el.getAttribute && (el.getAttribute('fetchpriority') || ''),
						natural: el.naturalWidth ? el.naturalWidth + '×' + el.naturalHeight : '',
					};
				}
				window.__lcp.push({ t: Math.round(e.startTime), taille: e.size, url: e.url || '', sel, ...attrs });
			}
		}).observe({ type: 'largest-contentful-paint', buffered: true });
	});

	await page.goto(WP + route, { waitUntil: 'networkidle', timeout: 60000 });
	await page.waitForTimeout(800);
	const lcp = await page.evaluate(() => (window.__lcp && window.__lcp.length ? window.__lcp[window.__lcp.length - 1] : null));
	const preloads = await page.evaluate(() =>
		[...document.querySelectorAll('link[rel="preload"][as="image"]')].map((l) => l.getAttribute('href') || l.getAttribute('imagesrcset') || '')
	);
	// Téléchargements doubles : deux variantes d'un même slot demandées pendant la même navigation.
	const parSlot = new Map();
	for (const url of requetes.keys()) {
		const m = url.match(/\/([a-z-]+)-(\d+)\.(avif|webp|jpg)$/);
		if (m) (parSlot.get(m[1]) || parSlot.set(m[1], []).get(m[1])).push(m[2] + '.' + m[3]);
	}
	const doubles = [...parSlot.entries()].filter(([, v]) => v.length > 1);
	const res = lcp && lcp.url ? requetes.get(lcp.url) : null;
	await ctx.close();
	return { lcp, preloads, doubles, decouverte: res ? res.t : null, priorite: res ? res.priorite : null };
}

const mediane = (arr) => arr.slice().sort((a, b) => a - b)[Math.floor(arr.length / 2)];

for (const width of WIDTHS) {
	for (const route of ROUTES) {
		const runs = [];
		for (let i = 0; i < RUNS; i++) runs.push(await mesurer(route, width));
		const times = runs.map((r) => (r.lcp ? r.lcp.t : -1));
		const medIdx = times.indexOf(mediane(times));
		const m = runs[medIdx];
		const l = m.lcp || {};
		console.log(`\n━━ ${route} @ ${width}px — LCP médian ${l.t ?? '?'} ms (runs: ${times.join(' / ')})`);
		console.log(`   élément  ${l.sel || '?'} · taille ${l.taille ?? '?'} · rendu ${l.rendu || '—'} · visible au premier écran : ${l.visible === undefined ? '—' : l.visible}`);
		console.log(`   ressource ${l.url ? l.url.split('/').pop() : '(texte — aucune ressource)'}${l.natural ? ' · natif ' + l.natural : ''}`);
		if (l.url) console.log(`   loading=${l.loading || 'eager'} · fetchpriority=${l.fetchpriority || '—'} · découverte à ${m.decouverte} ms · priorité réseau ${m.priorite}`);
		console.log(`   preloads image : ${m.preloads.length ? m.preloads.join(', ') : 'aucun'} · doubles téléchargements : ${m.doubles.length ? JSON.stringify(m.doubles) : 'aucun'}`);
	}
}
await browser.close();
