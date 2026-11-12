/**
 * Contenus provisoires, sur les 53 routes.
 *
 * Décision d'Emmanuel du 13 novembre 2026 : le site n'affiche plus AUCUNE mention du type « exemple
 * de présentation », « en cours d'intégration » ou « photo provisoire ». Ce fichier vérifiait
 * l'inverse — une mention visible à côté de chaque contenu provisoire ; il vérifie désormais :
 *  - qu'aucune de ces mentions n'est restée, ni dans le texte ni dans le DOM ;
 *  - qu'aucun témoignage n'alimente de donnée structurée `Review` ou `AggregateRating` (CLAUDE.md §5.5).
 * Le marquage `data-tfp-provisional` des témoignages repris de la maquette est contrôlé par
 * tests/g26.spec.js : toute rangée d'étoiles hors note Google doit se trouver dans un bloc marqué.
 */
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

test.describe('Contenus provisoires — aucune mention visible, marquage conservé', () => {
	for (const route of ROUTES) {
		test(`${route.url} : aucune mention visible, aucun avis en donnée structurée`, async ({ page }) => {
			await page.goto(route.url, { waitUntil: 'domcontentloaded' });

			const resultat = await page.evaluate(() => ({
				mentions: document.querySelectorAll('[data-tfp-provisional-notice], .tfp-provisional-notice').length,
				texte: (document.body.textContent || '').match(/exemples? de présentation|en cours d[’']intégration|photo d[’']illustration provisoire|portrait d[’']Audrey à venir|en attente de validation|contenu de démonstration/gi) || [],
				// Aucun contenu provisoire ne doit alimenter de donnée structurée d'avis.
				schemasAvis: [...document.querySelectorAll('script[type="application/ld+json"]')]
					.map((s) => s.textContent || '')
					.filter((t) => /"@type"\s*:\s*"(Review|AggregateRating)"/.test(t)).length,
			}));

			expect(resultat.mentions, `${route.url} : une mention de contenu provisoire est encore rendue`).toBe(0);
			expect(resultat.texte, `${route.url} : formulation interdite encore présente`).toEqual([]);

			expect(
				resultat.schemasAvis,
				`${route.url} publie une donnée structurée d'avis alors que les témoignages sont provisoires`
			).toBe(0);
		});
	}

	test('/avis-clients/ n’affirme pas publier uniquement des avis vérifiés', async ({ page }) => {
		await page.goto('/avis-clients/', { waitUntil: 'domcontentloaded' });
		const texte = await page.evaluate(() => document.body.innerText);
		const provisoire = await page.locator('[data-tfp-provisional]').count();

		if (provisoire > 0) {
			// La phrase est exacte comme intention, fausse comme description de ce qui est affiché.
			expect(
				texte,
				'la page affirme ne publier que des avis authentiques alors qu’elle montre des exemples'
			).not.toContain('Nous ne publions que des avis authentiques et autorisés.');
		}
	});
});
