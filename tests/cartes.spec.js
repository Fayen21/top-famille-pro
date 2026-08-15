// @ts-check
import { test, expect } from '@playwright/test';
import { pathToFileURL } from 'node:url';
import { resolve } from 'node:path';
import { RELEVE, diagnostiquer } from '../tools/lib/cartes.mjs';

/**
 * Relevé et diagnostic des cartes — la règle du **rang fluide** des pastilles, éprouvée sur des
 * fixtures autonomes.
 *
 * L'inventaire comptait 32 « écarts de colonnes » sur les rangées de communes des pages de zone.
 * Or dans une rangée `flex-wrap: wrap`, le point de retour à la ligne n'est pas une propriété de
 * mise en page : il découle de la largeur du texte des pastilles voisines, et une pastille insérée
 * ou retirée en amont décale toutes les suivantes sans qu'aucune règle CSS ne diffère.
 *
 * La correction vit dans tools/lib/cartes.mjs, partagée par l'outil et par ces tests : le rang
 * d'une pastille n'est comparé que si une vraie propriété diverge — largeur du conteneur,
 * géométrie de la pastille, écart de la rangée. Ces tests ferment les deux portes :
 *
 *  - **faux positif** — un décalage de rang à géométrie identique ne produit plus d'anomalie ;
 *  - **faux négatif** — le risque de la correction : un conteneur réellement plus étroit, ou des
 *    pastilles réellement plus grandes, doivent TOUJOURS être détectés.
 *
 * Les fixtures sont autonomes : ni banc WordPress ni maquette, vertes sur une machine nue.
 */

const fixture = (nom) => pathToFileURL(resolve('tests/fixtures/' + nom)).href;

/** Relève une fixture exactement comme l'outil : même fonction, pas une copie. */
async function relever(page, nom) {
	await page.setViewportSize({ width: 800, height: 600 });
	await page.goto(fixture(nom));
	return page.evaluate(RELEVE);
}

const chips = (r) => r.cartes.filter((c) => c.type === 'chip');
const colonnes = (d) => d.anomalies.filter((x) => x.genre === 'colonnes');

test.describe('Rangée de pastilles — rang fluide', () => {
	test('la fixture de référence relève bien des pastilles, jamais les liens', async ({ page }) => {
		const a = await relever(page, 'pastilles-maquette.html');
		// Les cinq noms sans page sont des cartes « chip » ; les liens sont des commandes, exclues.
		expect(chips(a).map((c) => c.texte)).toEqual([
			'Chevigny-Saint-Sauveur',
			'Ruffey-lès-Echirey',
			'Bressey-sur-Tille',
			'Varois-et-Chaignot',
			'Norges-la-Ville',
		]);
		for (const c of chips(a)) {
			expect(c.parentWrap, 'le parent doit être relevé comme rangée fluide').toBe(true);
			expect(c.parentW).toBe(560);
		}
	});

	test('un rang décalé par une pastille insérée en amont ne produit plus d’anomalie', async ({ page }) => {
		const a = await relever(page, 'pastilles-maquette.html');
		const b = await relever(page, 'pastilles-rang-decale.html');

		// Le décalage est réel : sans lui, ce test ne prouverait rien. Le lien inséré pousse au
		// moins une pastille sur un autre rang.
		const rangs = (r) => chips(r).map((c) => c.colonnes).join('+');
		expect(rangs(a)).not.toBe(rangs(b));

		// C'est le cœur du faux positif : géométrie identique, aucun écart de colonnes signalé.
		expect(colonnes(diagnostiquer(a, b))).toEqual([]);
	});

	test('un conteneur réellement plus étroit reste détecté', async ({ page }) => {
		const a = await relever(page, 'pastilles-maquette.html');
		const b = await relever(page, 'pastilles-conteneur-etroit.html');

		expect(chips(b)[0].parentW).toBe(330);
		expect(colonnes(diagnostiquer(a, b)).length).toBeGreaterThan(0);
	});

	test('des pastilles réellement plus larges restent détectées', async ({ page }) => {
		const a = await relever(page, 'pastilles-maquette.html');
		const b = await relever(page, 'pastilles-geometrie.html');

		// Le rembourrage horizontal passe de 15 à 26 px : chaque pastille gagne 22 px de large,
		// la hauteur ne bouge pas — c'est le défaut de géométrie le plus discret possible, et il
		// doit suffire à réactiver la comparaison de rangs. (Une pastille plus HAUTE change
		// d'archétype — `chip` devient `micro-carte` — et ressort en anomalie de `type` : l'autre
		// porte reste fermée par construction.)
		expect(chips(b)[0].w - chips(a)[0].w).toBeGreaterThanOrEqual(16);
		expect(chips(b)[0].h).toBe(chips(a)[0].h);
		expect(colonnes(diagnostiquer(a, b)).length).toBeGreaterThan(0);
	});
});
