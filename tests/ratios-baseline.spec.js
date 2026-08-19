// @ts-check
import { test, expect } from '@playwright/test';
import { readFileSync } from 'node:fs';
import path from 'node:path';

/**
 * Relevé de base — 300 contrôles sur 318 dans la plage de fidélité (G27 §4).
 *
 * ## Pourquoi ce fichier existe
 *
 * Deux chiffres ont été cités côte à côte dans un rapport — « 318 − 298 » et « 19 » — sans dire
 * qu'ils venaient de **deux instruments différents**. Le relevé de base mesure une hauteur par
 * route et par largeur : 53 × 6 = 318. La comparaison des routes mesure hauteur ET nombre de mots,
 * à deux largeurs : 53 × 2 × 2 = 212. Les additionner n'a pas de sens, et ne pas le dire en a
 * encore moins.
 *
 * Ce contrôle porte sur le **relevé de base** et sur lui seul, et il vérifie d'abord son propre
 * total : un fichier tronqué ferait passer n'importe quel seuil.
 *
 * ## Ce que la plage autorise
 *
 * Les trois pages légales — mentions, confidentialité, cookies — portent un contenu réglementaire
 * réel, plus long que le résumé de la maquette. Elles sont hors tolérance par construction, aux six
 * largeurs : 18 contrôles. **Toutes les autres routes doivent tenir dans 95-105 %.**
 */

const RACINE = path.resolve( path.dirname( new URL( import.meta.url ).pathname ), '..' );
const LARGEURS = [ '320', '375', '768', '1024', '1440', '1920' ];
const BANDE = [ 95, 105 ];

/** Les seules routes autorisées hors tolérance, et la raison. */
const LEGALES = {
	'#/mentions-legales': 'mentions légales réelles (CLAUDE.md §5.7)',
	'#/politique-de-confidentialite': 'politique de confidentialité réelle (RGPD)',
	'#/gestion-des-cookies': 'gestion des cookies réelle',
};

const baseline = JSON.parse( readFileSync( path.join( RACINE, 'docs/baseline.json' ), 'utf8' ) );

test.describe( 'Relevé de base — plage de fidélité', () => {
	test( 'le relevé porte bien 318 contrôles', () => {
		let n = 0;
		for ( const parLargeur of Object.values( baseline ) ) {
			for ( const w of LARGEURS ) if ( parLargeur[ w ] ) n++;
		}
		expect(
			n,
			'53 routes × 6 largeurs : un total différent veut dire que le relevé est incomplet, ' +
				'et tout seuil appliqué dessus ne mesure plus rien'
		).toBe( 318 );
	} );

	test( 'seules les trois pages légales sortent de 95-105 %', () => {
		const hors = [];
		for ( const [ route, parLargeur ] of Object.entries( baseline ) ) {
			for ( const w of LARGEURS ) {
				const e = parLargeur[ w ];
				if ( ! e ) continue;
				if ( e.ratio >= BANDE[ 0 ] && e.ratio <= BANDE[ 1 ] ) continue;
				if ( LEGALES[ route ] ) continue;
				hors.push( `${ route } à ${ w } px : ${ e.ratio } %` );
			}
		}
		expect( hors, 'routes non légales hors de la plage de fidélité' ).toEqual( [] );
	} );

	test( 'au moins 300 des 318 contrôles sont dans la plage', () => {
		let dans = 0;
		let total = 0;
		for ( const parLargeur of Object.values( baseline ) ) {
			for ( const w of LARGEURS ) {
				const e = parLargeur[ w ];
				if ( ! e ) continue;
				total++;
				if ( e.ratio >= BANDE[ 0 ] && e.ratio <= BANDE[ 1 ] ) dans++;
			}
		}
		expect( dans + ( total - dans ), 'arithmétique du relevé' ).toBe( total );
		expect( dans, `${ dans } / ${ total } contrôles dans 95-105 %` ).toBeGreaterThanOrEqual( 300 );
	} );

	test( 'aucun débordement horizontal, aucune erreur console', () => {
		const fautes = [];
		for ( const [ route, parLargeur ] of Object.entries( baseline ) ) {
			for ( const w of LARGEURS ) {
				const e = parLargeur[ w ];
				if ( ! e ) continue;
				if ( e.debordement ) {
					fautes.push( `${ route } à ${ w } px : débordement horizontal de ${ e.debordement } px` );
				}
				for ( const cle of [ 'erreursConsole', 'erreursReseau' ] ) {
					if ( Array.isArray( e[ cle ] ) && e[ cle ].length ) {
						fautes.push( `${ route } à ${ w } px : ${ e[ cle ].length } ${ cle } — ${ e[ cle ][ 0 ] }` );
					}
				}
			}
		}
		expect( fautes ).toEqual( [] );
	} );
} );
