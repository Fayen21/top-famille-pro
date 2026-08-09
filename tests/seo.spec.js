// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES, NOT_FOUND_URL } from './data/routes.js';
import { FICTITIOUS_MARKERS } from './data/fictitious-names.js';

for (const route of ROUTES) {
	test.describe(`SEO générique — ${route.url} (${route.family})`, () => {
		test('statut HTTP 200', async ({ page }) => {
			const response = await page.goto(route.url);
			expect(response?.status()).toBe(200);
		});

		test('h1 unique', async ({ page }) => {
			await page.goto(route.url);
			await expect(page.locator('h1')).toHaveCount(1);
		});

		test('title présent, non vide, raisonnablement court', async ({ page }) => {
			await page.goto(route.url);
			const title = await page.title();
			expect(title.trim().length).toBeGreaterThan(0);
			// CLAUDE.md demande un raccourcissement des title >~65c ; on tolère une petite marge
			// plutôt qu'un seuil dur, l'objectif réel étant l'affichage SERP, pas un compte exact.
			expect(title.length).toBeLessThanOrEqual(70);
		});

		test('meta description présente', async ({ page }) => {
			await page.goto(route.url);
			const desc = await page.locator('meta[name="description"]').getAttribute('content');
			expect(desc?.trim().length).toBeGreaterThan(0);
		});

		test('canonical absolue et auto-référente', async ({ page, baseURL }) => {
			await page.goto(route.url);
			const canonical = await page.locator('link[rel="canonical"]').getAttribute('href');
			expect(canonical).toBeTruthy();
			expect(canonical).toMatch(/^https?:\/\//);
			const expected = new URL(route.url, baseURL).toString();
			expect(canonical).toBe(expected);
		});

		test(`robots = ${route.robots}`, async ({ page }) => {
			await page.goto(route.url);
			const robots = await page.locator('meta[name="robots"]').getAttribute('content');
			expect(robots).toBe(route.robots);
		});

		test('JSON-LD valide (si présent)', async ({ page }) => {
			await page.goto(route.url);
			const scripts = await page.locator('script[type="application/ld+json"]').allTextContents();
			for (const raw of scripts) {
				expect(() => JSON.parse(raw)).not.toThrow();
				const parsed = JSON.parse(raw);
				expect(parsed['@context'] || parsed['@graph']?.every((n) => n['@type'])).toBeTruthy();
			}
		});

		test('aucun href="#" public', async ({ page }) => {
			await page.goto(route.url);
			await expect(page.locator('a[href="#"]')).toHaveCount(0);
		});

		test('aucun fragment #/ ', async ({ page }) => {
			await page.goto(route.url);
			const hrefs = await page.locator('a[href]').evaluateAll((els) => els.map((el) => el.getAttribute('href')));
			const badFragments = hrefs.filter((h) => h && h.startsWith('#/'));
			expect(badFragments).toEqual([]);
		});

		test('aucune donnée fictive résiduelle (avis démo, Top-Entreprise, compteur 47 avis)', async ({ page }) => {
			await page.goto(route.url);
			// Le contenu explicitement marqué comme démonstration (`data-tfp-demo-block`) est retiré
			// avant contrôle : il n'est rendu que hors production, porte une mention visible, et son
			// absence en production est vérifiée séparément et strictement (tests/fidelite.spec.js,
			// « aucun contenu de démonstration en production »).
			const text = await page.evaluate(() => {
				const clone = document.body.cloneNode(true);
				clone.querySelectorAll('[data-tfp-demo-block]').forEach((el) => el.remove());
				return clone.innerText;
			});
			// Les avis/compteur démo sont vérifiés tels quels. « Top-Entreprise » est vérifié sans
			// tenir compte de la casse (pour attraper toute variante), après avoir retiré la seule
			// occurrence légitime : la raison sociale réelle « SARL TOP-ENTREPRISE » du pied de page
			// (CLAUDE.md §1 — c'est l'entité juridique, pas l'ancienne marque à supprimer, cf. §9).
			const textWithoutLegalName = text.replace(/sarl\s+top-entreprise/gi, '');
			for (const marker of FICTITIOUS_MARKERS) {
				if (/^top-entreprise$/i.test(marker)) {
					expect(textWithoutLegalName.toLowerCase(), `« ${marker} » (ancienne marque) ne doit apparaître sur aucune page`).not.toContain(
						marker.toLowerCase()
					);
				} else {
					expect(text, `« ${marker} » ne doit apparaître sur aucune page`).not.toContain(marker);
				}
			}
		});

		test('aucun alt mensonger (portrait Audrey non fourni, CLAUDE.md §5.6)', async ({ page }) => {
			await page.goto(route.url);
			const alts = await page.locator('img').evaluateAll((els) => els.map((el) => el.getAttribute('alt') || ''));
			const lying = alts.filter((a) => /audrey/i.test(a));
			expect(lying, 'aucune photo authentique fournie : aucun alt ne doit affirmer représenter Audrey').toEqual([]);
		});

		test('aucune erreur JavaScript au chargement', async ({ page }) => {
			const errors = [];
			page.on('pageerror', (e) => errors.push(e.message));
			await page.goto(route.url, { waitUntil: 'networkidle' });
			expect(errors).toEqual([]);
		});

		test('aucun débordement horizontal (375px)', async ({ page }) => {
			await page.setViewportSize({ width: 375, height: 800 });
			await page.goto(route.url);
			const overflow = await page.evaluate(
				() => document.documentElement.scrollWidth > document.documentElement.clientWidth + 1
			);
			expect(overflow).toBe(false);
		});
	});
}

test.describe('404 réelle', () => {
	test('URL inconnue renvoie un vrai statut HTTP 404', async ({ page }) => {
		const response = await page.goto(NOT_FOUND_URL);
		expect(response?.status()).toBe(404);
	});

	test('page 404 a un title, un h1, robots noindex,follow, aucune erreur JS', async ({ page }) => {
		const errors = [];
		page.on('pageerror', (e) => errors.push(e.message));
		await page.goto(NOT_FOUND_URL, { waitUntil: 'networkidle' });
		expect((await page.title()).trim().length).toBeGreaterThan(0);
		await expect(page.locator('h1')).toHaveCount(1);
		const robots = await page.locator('meta[name="robots"]').getAttribute('content');
		expect(robots).toBe('noindex,follow');
		expect(errors).toEqual([]);
	});
});
