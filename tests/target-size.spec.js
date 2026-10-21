// @ts-check
import { test, expect } from '@playwright/test';
import { pathToFileURL } from 'node:url';
import { AUDIT } from '../tools/audit-target-size.mjs';

/**
 * Garde-fou de l'audit WCAG 2.2 AA « 2.5.8 Target Size (Minimum) ».
 *
 * L'outil a signalé une violation sur `#/plan-du-site` qui n'en était pas une : un lien de
 * 153 × 21 px, « voisine « ☎ Appeler » à 5 px ». La voisine réelle du lien, mesurée, est à 33 px —
 * au-dessus du seuil. Le « 5 px » venait de la barre d'action mobile, `position: fixed; bottom: 0`,
 * dont l'outil calculait la position documentaire par `top + scrollY`. Pour un élément fixe ce
 * calcul n'a pas de sens : il fait glisser la barre à travers la page au fil du défilement, et la
 * fait tomber sur un contenu différent selon la hauteur de la fenêtre — le lien était signalé à
 * 900 px de haut, pas à 800.
 *
 * Un recouvrement entre une barre fixe et le contenu qu'elle survole relève de l'occultation
 * (2.4.11), pas de l'espacement : chaque couche de positionnement ne se compare donc qu'à
 * elle-même. Ces deux fixtures tiennent les deux bouts de cette correction — le faux positif
 * disparaît, et une vraie violation dans une seule et même couche continue d'être signalée.
 *
 * Elles n'ont besoin ni du banc WordPress ni de la maquette : ce sont des pages locales.
 */

const MIN = 24;
const fixture = (nom) => pathToFileURL(new URL(`./fixtures/${nom}`, import.meta.url).pathname).href;

test.describe('audit 2.5.8', () => {
	test('une barre fixe ne fabrique pas de voisine au contenu qu’elle survole', async ({ page }) => {
		await page.setViewportSize({ width: 375, height: 900 });
		await page.goto(fixture('cibles-barre-fixe.html'));

		const r = await page.evaluate(AUDIT, MIN);

		// La géométrie du faux positif est bien reproduite : sans la séparation des couches, la
		// barre retombe sur le lien. On le vérifie explicitement, sinon la fixture pourrait passer
		// au vert pour la mauvaise raison — parce qu'elle ne reproduit plus rien.
		const recouvre = await page.evaluate(() => {
			const barre = document.querySelector('.barre a');
			const lien = [...document.querySelectorAll('ul a')].find(
				(a) => (a.textContent || '').trim() === 'Nettoyage de bureaux'
			);
			if (!barre || !lien) return -1;
			const b = barre.getBoundingClientRect();
			const l = lien.getBoundingClientRect();
			return Math.hypot(
				b.left + window.scrollX + b.width / 2 - (l.left + window.scrollX + l.width / 2),
				b.top + window.scrollY + b.height / 2 - (l.top + window.scrollY + l.height / 2)
			);
		});
		expect(recouvre).toBeGreaterThanOrEqual(0);
		expect(recouvre).toBeLessThan(MIN);

		expect(r.violations, JSON.stringify(r.violations)).toEqual([]);
	});

	test('deux commandes serrées de la même couche restent signalées', async ({ page }) => {
		await page.setViewportSize({ width: 375, height: 900 });
		await page.goto(fixture('cibles-trop-serrees.html'));

		const r = await page.evaluate(AUDIT, MIN);

		expect(r.violations).toHaveLength(2);
		expect(r.violations[0].taille).toBe('16×16');
		expect(r.violations[0].distance).toBeLessThan(MIN);
	});
});
