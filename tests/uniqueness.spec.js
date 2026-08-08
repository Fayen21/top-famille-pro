// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

/**
 * Unicité de title/canonical sur les 53 routes, vérifiée par requête HTTP brute plutôt qu'un
 * navigateur : plus rapide sur 53 pages, et l'unicité ne dépend d'aucun rendu client.
 */
test('title et canonical uniques sur les 53 routes publiques', async ({ request }) => {
	const titles = new Map();
	const canonicals = new Map();

	for (const route of ROUTES) {
		const response = await request.get(route.url);
		expect(response.status(), `${route.url} doit répondre 200`).toBe(200);
		const html = await response.text();

		const titleMatch = html.match(/<title>([^<]*)<\/title>/i);
		const title = titleMatch ? titleMatch[1].trim() : '';
		expect(title.length, `${route.url} doit avoir un <title>`).toBeGreaterThan(0);
		if (titles.has(title)) {
			throw new Error(`Title dupliqué « ${title} » : ${titles.get(title)} et ${route.url}`);
		}
		titles.set(title, route.url);

		const canonicalMatch = html.match(/<link rel="canonical" href="([^"]*)"/i);
		const canonical = canonicalMatch ? canonicalMatch[1] : '';
		expect(canonical.length, `${route.url} doit avoir une canonical`).toBeGreaterThan(0);
		if (canonicals.has(canonical)) {
			throw new Error(`Canonical dupliquée « ${canonical} » : ${canonicals.get(canonical)} et ${route.url}`);
		}
		canonicals.set(canonical, route.url);
	}
});
