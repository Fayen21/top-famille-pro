/**
 * Transparence des contenus provisoires, sur les 53 routes.
 *
 * Les témoignages repris de la maquette servent à reproduire le design, mais ce ne sont pas de
 * vrais avis. L'attribut `data-tfp-provisional` les rend repérables **pour l'équipe** ; il ne dit
 * rien au visiteur, qui ne lit pas le code source. Trente-huit routes affichaient des avis
 * d'apparence authentique sans que rien ne signale leur statut.
 *
 * Ce test exige donc une mention **réellement visible** — visibilité calculée, pas simple présence
 * dans le DOM — dans le même composant ou la même section que le contenu provisoire.
 */
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

test.describe('Contenus provisoires — mention visible obligatoire', () => {
	for (const route of ROUTES) {
		test(`${route.url} : chaque contenu provisoire porte sa mention visible`, async ({ page }) => {
			await page.goto(route.url, { waitUntil: 'domcontentloaded' });

			const resultat = await page.evaluate(() => {
				/** Visible au sens du rendu : dimensions non nulles, non masqué, opacité non nulle. */
				const estVisible = (el) => {
					if (!el) return false;
					const r = el.getBoundingClientRect();
					const s = getComputedStyle(el);
					return (
						r.width > 0 &&
						r.height > 0 &&
						s.display !== 'none' &&
						s.visibility !== 'hidden' &&
						parseFloat(s.opacity) > 0.05
					);
				};

				const provisoires = [...document.querySelectorAll('[data-tfp-provisional]')];
				const orphelins = [];

				for (const p of provisoires) {
					// La mention peut être dans le bloc lui-même, ou dans un ancêtre proche — une
					// grille annonce ses cartes une seule fois, au-dessus d'elles.
					let couvert = [...p.querySelectorAll('[data-tfp-provisional-notice]')].some(estVisible);
					for (let a = p; a && !couvert; a = a.parentElement) {
						couvert = [...a.querySelectorAll(':scope > [data-tfp-provisional-notice]')].some(estVisible);
						if (a.tagName === 'SECTION' || a.tagName === 'BODY') break;
					}
					if (!couvert) {
						orphelins.push((p.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 90));
					}
				}

				return {
					provisoires: provisoires.length,
					orphelins,
					// Aucun contenu provisoire ne doit alimenter de donnée structurée d'avis.
					schemasAvis: [...document.querySelectorAll('script[type="application/ld+json"]')]
						.map((s) => s.textContent || '')
						.filter((t) => /"@type"\s*:\s*"(Review|AggregateRating)"/.test(t)).length,
				};
			});

			expect(
				resultat.orphelins,
				`${route.url} : ${resultat.orphelins.length} contenu(s) provisoire(s) sans mention visible.\n` +
					resultat.orphelins.map((t) => `  — « ${t} »`).join('\n')
			).toEqual([]);

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
