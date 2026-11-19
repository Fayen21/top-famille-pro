// @ts-check
import { test, expect } from '@playwright/test';
import { pathToFileURL } from 'node:url';
import { resolve } from 'node:path';
import { SEL_BANDE, SRC_BANDES } from '../tools/lib/bandes.mjs';

/**
 * Compteur de bandes — la règle de tools/lib/bandes.mjs, éprouvée sur des fixtures.
 *
 * Le compteur de bandes répond à la question la plus grave du chantier de fidélité : *le rendu
 * WordPress a-t-il perdu une bande de la maquette ?* Il s'est trompé dans les deux sens possibles,
 * et ces tests ferment les deux portes :
 *
 *  - **faux positif** — il annonçait « bandes 8 → 6 » sur les trois articles alors que tout le
 *    contenu est là, parce qu'il ne comptait que les `<section>` et que le thème écrit l'en-tête en
 *    `<header>` et le corps éditorial en `<article>` ;
 *  - **faux négatif** — le risque de la correction : une règle assez large pour rattraper le corps
 *    continu pourrait cesser de voir une bande réellement absente. C'est arrivé pour de vrai (la
 *    FAQ manquait aux six pages de prestation), et cela doit rester détecté.
 *
 * Les fixtures sont autonomes : ces tests ne dépendent ni du banc WordPress ni de la maquette, et
 * restent verts sur une machine nue.
 */

const fixture = (nom) => pathToFileURL(resolve('tests/fixtures/' + nom)).href;

/** Compte les bandes exactement comme les outils de comparaison : même source, pas une copie. */
async function bandes(page, nom) {
	await page.addInitScript(SRC_BANDES);
	await page.goto(fixture(nom));
	return page.evaluate(() => {
		let flux = document.body;
		for (let el = document.querySelector('h1'); el; el = el.parentElement) {
			if (el.querySelectorAll(':scope > section').length >= 2) {
				flux = el;
				break;
			}
		}
		return window.__tfpBandes(flux).map((b) => b.tagName.toLowerCase());
	});
}

test.describe('Compteur de bandes', () => {
	test('la maquette pose huit bandes, toutes en <section>', async ({ page }) => {
		const t = await bandes(page, 'bandes-maquette.html');
		// Huit, et non neuf enfants de premier niveau : le fil d'Ariane n'est pas une bande.
		expect(t).toHaveLength(8);
		expect(new Set(t)).toEqual(new Set(['section']));
	});

	test('le corps éditorial continu ne fait perdre aucune bande', async ({ page }) => {
		const maquette = await bandes(page, 'bandes-maquette.html');
		const theme = await bandes(page, 'bandes-corps-continu.html');

		// Le cœur du faux positif : même compte, alors que deux balises diffèrent.
		expect(theme).toHaveLength(maquette.length);
		expect(theme).toContain('header');
		expect(theme).toContain('article');
	});

	test('une bande réellement absente reste détectée', async ({ page }) => {
		const maquette = await bandes(page, 'bandes-maquette.html');
		const amputee = await bandes(page, 'bandes-amputee.html');

		expect(amputee).toHaveLength(maquette.length - 1);
	});

	test('le fil d’Ariane n’est une bande d’aucun des deux côtés', async ({ page }) => {
		// `<nav>` côté maquette, `<div>` côté thème : exclus symétriquement.
		expect(SEL_BANDE).not.toMatch(/\bnav\b|\bdiv\b/);
		const theme = await bandes(page, 'bandes-corps-continu.html');
		expect(theme).not.toContain('div');
		expect(theme).not.toContain('nav');
	});
});
