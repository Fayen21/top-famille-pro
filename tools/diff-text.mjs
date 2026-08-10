#!/usr/bin/env node
/**
 * Diff de contenu textuel entre une route de la maquette et son équivalent WordPress.
 *
 * Répond à la seule question qui compte pour la fidélité éditoriale : **quelles phrases de la
 * maquette n'existent pas dans WordPress ?** Une comparaison de hauteurs ou un compte de mots dit
 * qu'il manque quelque chose ; celle-ci dit quoi, à la phrase près.
 *
 * La comparaison porte sur les titres, paragraphes et éléments de liste, normalisés (espaces,
 * apostrophes, tirets, ponctuation d'accordéon) pour ne pas signaler comme absente une phrase que
 * seul le rendu distingue.
 *
 * Usage :
 *   node tools/diff-text.mjs '#/service/bureaux'
 *   node tools/diff-text.mjs --all            → résumé pour les 53 routes
 *   node tools/diff-text.mjs --type=ville     → toutes les routes d'un type
 */
import { chromium } from '@playwright/test';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';

/**
 * Normalisation : la maquette et WordPress n'écrivent pas les mêmes caractères invisibles
 * (apostrophes typographiques, insécables, « + » de l'accordéon FAQ). Sans cela, la moitié des
 * phrases identiques ressortiraient comme manquantes.
 */
function norm(s) {
	return String(s)
		.replace(/ | /g, ' ')
		.replace(/[’‘]/g, "'")
		.replace(/[“”«»]/g, '"')
		.replace(/[–—]/g, '-')
		.replace(/\s+/g, ' ')
		.replace(/^[▪✕✓•\-+\s]+/, '')
		.replace(/[+\s]+$/, '')
		.trim()
		.toLowerCase();
}

const HARVEST = () => {
	const txt = (el) => (el.textContent || '').replace(/\s+/g, ' ').trim();
	const out = [];
	for (const el of document.querySelectorAll('h1,h2,h3,h4,p,li,summary,blockquote')) {
		// On ignore les conteneurs : seul le nœud le plus profond porte la phrase, sinon chaque
		// texte serait compté plusieurs fois avec ses ancêtres.
		if (el.querySelector('h1,h2,h3,h4,p,li,summary,blockquote')) continue;
		const t = txt(el);
		if (t.length > 3) out.push(t);
	}
	return out;
};

async function settle(page) {
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 40));
		}
		window.scrollTo(0, 0);
	});
	await page.waitForTimeout(150);
}

const arg = process.argv.slice(2).find((a) => !a.startsWith('--'));
const all = process.argv.includes('--all');
const type = (process.argv.find((a) => a.startsWith('--type=')) || '').split('=')[1];
const verbose = !all && !type;

let routes = Object.keys(ROUTE_MAP);
if (arg) routes = [arg];
else if (type) routes = routes.filter((r) => ROUTE_MAP[r].type === type);

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const refPage = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await refPage.goto(REF, { waitUntil: 'load', timeout: 90000 });
await refPage.waitForTimeout(5500);
const wpPage = await browser.newPage({ viewport: { width: 1440, height: 900 } });

let totalMissing = 0;
for (const hash of routes) {
	const map = ROUTE_MAP[hash];
	await refPage.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, hash);
	await refPage.waitForTimeout(1100);
	await settle(refPage);
	const ref = await refPage.evaluate(HARVEST);

	await wpPage.goto(WP + map.wp, { waitUntil: 'networkidle', timeout: 60000 });
	await settle(wpPage);
	const wp = await wpPage.evaluate(HARVEST);

	const wpSet = new Set(wp.map(norm));
	const wpJoined = wp.map(norm).join('  ');
	// Une phrase peut avoir été fusionnée avec sa voisine dans WordPress (ou l'inverse) : on la
	// considère présente si elle apparaît telle quelle dans le texte concaténé.
	const missing = ref.filter((t) => {
		const n = norm(t);
		return !wpSet.has(n) && !wpJoined.includes(n);
	});

	totalMissing += missing.length;
	console.log(
		`${hash.padEnd(42)} ${String(ref.length).padStart(3)} blocs de texte · ` +
			`${String(missing.length).padStart(3)} absents côté WordPress`
	);
	if (verbose || (missing.length && type)) {
		for (const m of missing) console.log('    ✕ ' + m.slice(0, 150));
	}
}
console.log(`\nTotal manquant : ${totalMissing}`);
await browser.close();
