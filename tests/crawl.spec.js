// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

const EXPECTED_PATHS = new Set(ROUTES.map((r) => r.url));

/**
 * Crawl interne depuis l'accueil : suit tous les liens internes trouvés (header, footer, contenu),
 * vérifie qu'aucun ne renvoie une erreur et que les 53 routes publiques sont toutes atteignables
 * (aucune page orpheline). Volontairement indépendant du sitemap : le crawl part de ce que WordPress
 * rend réellement, pas d'une liste qu'on se contenterait de revérifier elle-même.
 */
test('crawl interne : aucun lien mort, aucune page orpheline', async ({ page, baseURL }) => {
	const origin = new URL(baseURL).origin;
	const visited = new Set();
	const toVisit = ['/'];
	const deadLinks = [];

	while (toVisit.length) {
		const path = toVisit.shift();
		if (visited.has(path)) continue;
		visited.add(path);

		const response = await page.goto(path, { waitUntil: 'domcontentloaded' });
		const status = response?.status() ?? 0;
		if (status < 200 || status >= 400) {
			deadLinks.push({ path, status });
			continue;
		}

		const hrefs = await page.locator('a[href]').evaluateAll((els) => els.map((el) => el.getAttribute('href')));
		for (const href of hrefs) {
			if (!href) continue;
			if (href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('#')) continue;
			let url;
			try {
				url = new URL(href, origin + path);
			} catch {
				continue;
			}
			if (url.origin !== origin) continue; // lien externe, hors périmètre du crawl interne
			const normalizedPath = url.pathname.endsWith('/') || url.pathname.includes('.') ? url.pathname : url.pathname + '/';
			if (!visited.has(normalizedPath) && !toVisit.includes(normalizedPath)) {
				toVisit.push(normalizedPath);
			}
		}
	}

	expect(deadLinks, `Liens morts trouvés pendant le crawl : ${JSON.stringify(deadLinks)}`).toEqual([]);

	const visitedPublic = [...visited].filter((p) => EXPECTED_PATHS.has(p));
	const orphans = ROUTES.map((r) => r.url).filter((url) => !visitedPublic.includes(url));
	expect(orphans, `Pages orphelines (non atteintes par le crawl depuis l'accueil) : ${JSON.stringify(orphans)}`).toEqual([]);
});
