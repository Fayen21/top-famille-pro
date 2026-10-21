#!/usr/bin/env node
/**
 * Audit des données structurées des 53 routes.
 *
 * Vérifie trois choses qu'un validateur de syntaxe ne vérifie pas :
 *
 *  1. **`FAQPage` sans FAQ visible.** CLAUDE.md §8 et les règles de Google sur les résultats
 *     enrichis l'interdisent : le balisage doit décrire un contenu que le visiteur voit. Chaque
 *     question déclarée est donc cherchée dans le texte réellement rendu.
 *  2. **`Review` ou `AggregateRating`.** Interdits sans réserve (CLAUDE.md §5.5) : les témoignages
 *     du site sont provisoires et la note Google est une note de plateforme tierce.
 *  3. **JSON invalide ou graphe vide**, qui passerait inaperçu à l'œil nu.
 *
 * Usage : node tools/audit-jsonld.mjs
 */
import { chromium } from '@playwright/test';
import { ROUTE_MAP } from './route-map.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });

/** Normalise pour comparer un libellé de balisage à du texte rendu (apostrophes, espaces). */
const norm = (s) =>
	s
		.replace(/[’ʼ]/g, "'")
		.replace(/\s+/g, ' ')
		.trim()
		.toLowerCase();

let problemes = 0;

for (const [hash, map] of Object.entries(ROUTE_MAP)) {
	await page.goto(WP + map.wp, { waitUntil: 'domcontentloaded', timeout: 60000 });
	const r = await page.evaluate(() => {
		const blocs = [...document.querySelectorAll('script[type="application/ld+json"]')].map((s) => s.textContent);
		return { blocs, texte: document.body.innerText };
	});

	const ecarts = [];
	const texte = norm(r.texte);

	for (const brut of r.blocs) {
		let data;
		try {
			data = JSON.parse(brut);
		} catch (e) {
			ecarts.push(`JSON-LD illisible : ${e.message}`);
			continue;
		}
		const noeuds = data['@graph'] || (Array.isArray(data) ? data : [data]);
		if (!noeuds.length) ecarts.push('graphe vide');

		for (const n of noeuds) {
			const types = [].concat(n['@type'] || []);
			if (types.includes('Review') || types.includes('AggregateRating')) {
				ecarts.push(`type interdit « ${types.join('/')} » (CLAUDE.md §5.5)`);
			}
			if (types.includes('FAQPage')) {
				for (const q of n.mainEntity || []) {
					if (!texte.includes(norm(q.name || ''))) {
						ecarts.push(`FAQPage : question non visible sur la page — « ${(q.name || '').slice(0, 60)} »`);
					}
				}
			}
		}
	}

	problemes += ecarts.length;
	console.log(`${(ecarts.length ? '❌' : '✅').padEnd(3)} ${hash.padEnd(42)} ${r.blocs.length} bloc(s)`);
	for (const e of ecarts) console.log(`      ${e}`);
}

await browser.close();
console.log(`\nDonnées structurées : ` + (problemes ? `❌ ${problemes} problème(s)` : '✅ conformes'));
process.exit(problemes ? 1 : 0);
