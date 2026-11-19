#!/usr/bin/env node
/**
 * Cartes orphelines (15 novembre 2026) : sur les 53 routes, à 1440 px, toute grille de cartes dont
 * la dernière rangée ne contient qu'UNE carte alors que les rangées précédentes en comptent trois
 * ou plus. Usage : node tools/scan-orphelines.mjs [base]
 */
import { chromium } from 'playwright';
import { ROUTES } from '../tests/data/routes.js';

const BASE = process.argv[2] || process.env.TFP_BASE_URL || 'http://localhost:8901';
const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await navigateur.newPage({ viewport: { width: 1440, height: 900 } });
let total = 0;
for (const r of ROUTES) {
	await page.goto(BASE + r.url, { waitUntil: 'domcontentloaded' });
	const trouvees = await page.evaluate(() => {
		document.querySelectorAll('details').forEach((d) => (d.open = true));
		const sortie = [];
		for (const g of document.querySelectorAll('main *, body > section *')) {
			if (getComputedStyle(g).display !== 'grid' || g.closest('footer, header, nav')) continue;
			const enfants = [...g.children].filter((c) => c.getBoundingClientRect().height > 40 && getComputedStyle(c).display !== 'none');
			if (enfants.length < 4) continue;
			// Une carte : un enfant encadré ou à fond propre, pas une ligne de liste ni une question.
			if (enfants.some((c) => c.matches('details, summary, li.tfp-step, p'))) continue;
			const rangees = new Map();
			for (const c of enfants) { const y = Math.round(c.getBoundingClientRect().top); rangees.set(y, (rangees.get(y) || 0) + 1); }
			const comptes = [...rangees.entries()].sort((a, b) => a[0] - b[0]).map((e) => e[1]);
			if (comptes.length >= 2 && comptes[comptes.length - 1] === 1 && Math.max(...comptes) >= 3) {
				sortie.push(`${g.className.toString().slice(0, 50) || g.tagName} : rangées ${comptes.join(' + ')} — « ${(enfants[0].textContent || '').trim().replace(/\s+/g, ' ').slice(0, 40)} »`);
			}
		}
		return sortie;
	});
	if (trouvees.length) { total += trouvees.length; console.log(r.url); trouvees.forEach((t) => console.log('  · ' + t)); }
}
await navigateur.close();
console.log(`\n${ROUTES.length} routes · ${total} grille(s) avec une carte seule sur sa dernière rangée.`);
process.exit(total ? 1 : 0);
