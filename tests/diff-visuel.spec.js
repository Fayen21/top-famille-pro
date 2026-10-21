// @ts-check
import { test, expect } from '@playwright/test';
import sharp from 'sharp';
import {
	panneauDifference,
	panneauDifferenceHerite,
	contrastePanneau,
	verifierComparabilite,
	SEUIL,
} from '../tools/lib/diff-visuel.mjs';

/**
 * G26 — le panneau de différence doit RÉVÉLER l'écart.
 *
 * La validation humaine du 17 août 2026 a été refusée notamment parce que le troisième panneau
 * des triptyques était « pratiquement uniforme malgré des différences majeures ». Ces tests
 * l'éprouvent sur une fixture volontairement différente, construite ici : deux images identiques
 * à un carré près. Ils échouent avec le générateur G25 — c'est démontré, pas affirmé : le témoin
 * `panneauDifferenceHerite` est passé aux mêmes assertions et ne les satisfait pas.
 */

const L = 240;
const H = 180;

/** Fond uniforme clair, comme une bande de page réelle. */
const fond = async (couleur = '#f4f7f8') =>
	sharp({ create: { width: L, height: H, channels: 3, background: couleur } }).png().toBuffer();

/** Le même fond, avec un carré d'une autre teinte : la « zone modifiée » à révéler. */
const fondAvecCarre = async ( { x = 40, y = 40, cote = 60, couleur = '#e8eef0' } = {} ) => {
	const carre = await sharp({ create: { width: cote, height: cote, channels: 3, background: couleur } }).png().toBuffer();
	return sharp({ create: { width: L, height: H, channels: 3, background: '#f4f7f8' } })
		.composite([ { input: carre, top: y, left: x } ])
		.png()
		.toBuffer();
};

/** Luminance moyenne d'une zone rectangulaire du panneau. */
async function luminanceZone( png, x, y, w, h ) {
	const { data, info } = await sharp( png ).extract( { left: x, top: y, width: w, height: h } ).removeAlpha().raw().toBuffer( { resolveWithObject: true } );
	let somme = 0;
	const n = info.width * info.height;
	for ( let i = 0; i < n; i++ ) {
		const o = i * info.channels;
		somme += 0.299 * data[ o ] + 0.587 * data[ o + 1 ] + 0.114 * data[ o + 2 ];
	}
	return somme / n;
}

test.describe( 'G26 · le panneau de différence révèle la zone modifiée', () => {
	test( 'une différence faible mais réelle est visible et mesurée', async () => {
		// Écart de 15 niveaux environ : invisible à l'œil nu sur un diff brut, parfaitement réel.
		const a = await fond();
		const b = await fondAvecCarre();
		const { png, pourcentage, amplification } = await panneauDifference( a, b );

		// 1. La zone modifiée est nettement plus sombre que le reste du panneau.
		const dansLaZone = await luminanceZone( png, 45, 45, 50, 50 );
		const horsZone = await luminanceZone( png, 160, 120, 50, 50 );
		expect( horsZone - dansLaZone, 'la zone modifiée ne ressort pas du fond' ).toBeGreaterThan( 25 );

		// 2. Le taux mesuré correspond à la surface réellement modifiée (60×60 sur 240×180 = 8,3 %).
		expect( pourcentage ).toBeGreaterThan( 7 );
		expect( pourcentage ).toBeLessThan( 10 );

		// 3. L'amplification est annoncée, jamais silencieuse.
		expect( amplification ).toBeGreaterThan( 1 );

		// 4. Le panneau n'est pas une surface uniforme.
		// Contraste mesuré SOUS l'étiquette : le bandeau d'honnêteté contraste toujours, par
		// construction, et le compter reviendrait à valider n'importe quel panneau.
		const corps = await sharp( png ).extract( { left: 0, top: 30, width: L, height: H - 30 } ).png().toBuffer();
		expect( await contrastePanneau( corps ), 'panneau uniforme' ).toBeGreaterThan( 40 );
	} );

	test( 'le générateur G25 échoue sur la même fixture — la preuve du défaut', async () => {
		const a = await fond();
		const b = await fondAvecCarre();
		const herite = await panneauDifferenceHerite( a, b );

		// L'ancienne méthode rend un panneau quasi uniforme : c'est exactement ce qui a été refusé.
		const dansLaZone = await luminanceZone( herite, 45, 45, 50, 50 );
		const horsZone = await luminanceZone( herite, 160, 120, 50, 50 );
		expect( Math.abs( horsZone - dansLaZone ), 'le générateur G25 révélait déjà la zone : la fixture ne prouve rien' ).toBeLessThan( 25 );
		expect( await contrastePanneau( herite ) ).toBeLessThan( 40 );
	} );

	test( 'deux rendus identiques donnent 0 % et aucune coloration', async () => {
		// Le pendant du test précédent : le panneau ne doit pas inventer d'écart là où il n'y en a pas.
		const a = await fond();
		const { png, pourcentage } = await panneauDifference( a, await fond() );
		expect( pourcentage ).toBe( 0 );
		const corps = await sharp( png ).extract( { left: 0, top: 30, width: L, height: H - 30 } ).png().toBuffer();
		expect( await contrastePanneau( corps ), 'un écart est coloré alors que les rendus sont identiques' ).toBeLessThan( 5 );
	} );

	test( 'une page plus courte d’un côté ressort comme un écart franc', async () => {
		// Une bande manquante en fin de page est le défaut le plus grave et le moins visible :
		// la zone absente doit être coloriée sur toute sa hauteur, pas recadrée hors du champ.
		const a = await sharp( { create: { width: L, height: H * 2, channels: 3, background: '#174a81' } } ).png().toBuffer();
		const b = await sharp( { create: { width: L, height: H, channels: 3, background: '#174a81' } } ).png().toBuffer();
		const { pourcentage, hauteur } = await panneauDifference( a, b );
		expect( hauteur ).toBe( H * 2 );
		expect( pourcentage, 'la moitié manquante ne ressort pas' ).toBeGreaterThan( 45 );
	} );

	test( 'deux captures de largeurs différentes sont refusées, pas maquillées', async () => {
		const a = await fond();
		const b = await sharp( { create: { width: L + 40, height: H, channels: 3, background: '#f4f7f8' } } ).png().toBuffer();
		await expect( panneauDifference( a, b ) ).rejects.toThrow( /non comparables/ );
		expect( () => verifierComparabilite( { width: 100 }, { width: 100 } ) ).not.toThrow();
	} );

	test( 'le seuil de perception ne compte pas le bruit d’encodage', async () => {
		// Un écart d'un niveau (bruit JPEG) ne doit pas gonfler le taux : sinon toute page
		// afficherait « 100 % de pixels différents » et le panneau ne dirait plus rien.
		const a = await sharp( { create: { width: L, height: H, channels: 3, background: { r: 200, g: 200, b: 200 } } } ).png().toBuffer();
		const b = await sharp( { create: { width: L, height: H, channels: 3, background: { r: 201, g: 201, b: 201 } } } ).png().toBuffer();
		const { pourcentage } = await panneauDifference( a, b );
		expect( pourcentage ).toBe( 0 );
		expect( SEUIL ).toBeGreaterThan( 1 );
	} );
} );
