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

/* ------------------------------------------------------------------ */
/* Diagnostic pur — les trois pièges d'appariement relevés en G22      */
/* ------------------------------------------------------------------ */

/** Enregistrement de carte minimal, tel que le relevé le produit. */
const carte = (o) => ({
	type: 'carte-titre',
	bande: 1,
	titre: '',
	texte: '',
	image: false,
	icone: false,
	fond: 'rgb(255, 255, 255)',
	filet: '1px solid',
	rayon: '12px',
	ombre: 'none',
	padding: '16px',
	w: 400,
	h: 100,
	colonnes: 1,
	grille: 0,
	span: '',
	align: 'left',
	gap: 'normal',
	parentW: 1180,
	parentWrap: false,
	y: 0,
	...o,
});
const page = (cartes) => ({ sections: 3, cartes });

test.describe('Diagnostic des cartes — pièges d’appariement', () => {
	test('une fusion ne traverse pas la page : neuf bandes d’écart ne fusionnent plus', ({}) => {
		// La pastille tarifaire du hero (bande 1) contre la carte tarifaire de la bande 9, dont le
		// texte la contient par coïncidence.
		const ref = page([carte({ bande: 1, type: 'tarif', texte: '27 € HT/h régulier ou ponctuel' })]);
		const wp = page([carte({ bande: 9, type: 'tarif', h: 270, texte: 'Tarif unique 27 € HT/h régulier ou ponctuel devis gratuit sous 24 h' })]);
		const d = diagnostiquer(ref, wp);
		expect(d.anomalies.filter((x) => x.genre === 'fusionnee')).toEqual([]);
		// Et une vraie fusion, dans la même bande, reste détectée.
		const wpMemeBande = page([carte({ bande: 1, type: 'tarif', h: 270, texte: 'Tarif unique 27 € HT/h régulier ou ponctuel devis gratuit sous 24 h' })]);
		expect(diagnostiquer(ref, wpMemeBande).anomalies.filter((x) => x.genre === 'fusionnee')).toHaveLength(1);
	});

	test('la carte qui absorbe une fusion n’est plus comptée en carte supplémentaire', ({}) => {
		// Deux cartes de la maquette rendues dans un seul conteneur WordPress : deux fusions,
		// et AUCUN surplus — le conteneur explique déjà tout son contenu.
		const ref = page([
			carte({ texte: 'Horaires de contact du lundi au vendredi réponse sous 24 heures garanties' }),
			carte({ texte: 'Téléphone appelez Audrey du lundi au vendredi aux heures ouvrées habituelles' }),
		]);
		// Le conteneur s'ouvre sur son propre intitulé : aucune des deux cartes n'en est le préfixe
		// exact, c'est bien la branche fusion qui est éprouvée.
		const wp = page([
			carte({ h: 220, texte: 'Nous contacter Horaires de contact du lundi au vendredi réponse sous 24 heures garanties Téléphone appelez Audrey du lundi au vendredi aux heures ouvrées habituelles' }),
		]);
		const d = diagnostiquer(ref, wp);
		expect(d.anomalies.filter((x) => x.genre === 'fusionnee')).toHaveLength(2);
		expect(d.anomalies.filter((x) => x.genre === 'surplus')).toEqual([]);
	});

	test('une carte-média muette s’apparie à sa jumelle muette au lieu de compter en surplus', ({}) => {
		const ref = page([carte({ texte: '', image: true, w: 225, h: 225, rayon: '16px' })]);
		const wp = page([carte({ texte: '', image: true, w: 225, h: 225, rayon: '16px' })]);
		expect(diagnostiquer(ref, wp).anomalies).toEqual([]);
		// Une muette de géométrie franchement différente reste un surplus : rien ne prouve que
		// c'est la même image.
		const wpAutre = page([carte({ texte: '', image: true, w: 700, h: 320 })]);
		expect(diagnostiquer(ref, wpAutre).anomalies.filter((x) => x.genre === 'surplus')).toHaveLength(1);
	});
});

test.describe('Relevé des cartes — bouton porteur de contenu', () => {
	test('une carte composée en <button> est relevée ; une vraie commande reste exclue', async ({ page }) => {
		const r = await relever(page, 'carte-bouton.html');
		const textes = r.cartes.map((c) => c.texte.slice(0, 20));
		expect(textes).toContain("J'ai une question Fo");
		expect(textes).not.toContain('Envoyer');
	});
});
