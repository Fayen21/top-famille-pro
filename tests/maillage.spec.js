// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTE_MAP } from '../tools/route-map.mjs';

/**
 * Maillage géographique — revue des trois ZIP du 25 octobre 2026, §2.
 *
 * Contrôle SÉMANTIQUE sur le HTML WordPress rendu, pas sur le seed : pour chaque lien de zone, on
 * lit le département dans l'URL de destination et on le compare à celui de la page. Un intitulé
 * qui annonce « Dans le même département » et pointe vers le Jura depuis Besançon échoue ici, quel
 * que soit le chemin par lequel la liste a été construite.
 */

const CODES = {
	'cote-dor': '21', doubs: '25', jura: '39', nievre: '58',
	'haute-saone': '70', 'saone-et-loire': '71', yonne: '89', 'territoire-de-belfort': '90',
};
// Départements qui n'ont qu'une page ville : leur bloc « même département » se réduit à la rangée
// du département. C'est là que l'ancien gabarit affichait les sept autres départements.
const VILLE_UNIQUE = [ 'doubs', 'nievre', 'haute-saone', 'yonne', 'territoire-de-belfort' ];

const LOCALES = Object.values( ROUTE_MAP ).filter( ( r ) => r.type === 'ville' || r.type === 'commune' ).map( ( r ) => r.wp );
const DEPTS = Object.values( ROUTE_MAP ).filter( ( r ) => r.type === 'departement' ).map( ( r ) => r.wp );

const deptDe = ( chemin ) => ( chemin.match( /\/zones-intervention\/([^/]+)\// ) || [] )[ 1 ];

/** Relève, par groupe de liens, la rangée département et les puces liées (chemins relatifs). */
async function relever( page ) {
	return page.locator( 'main .tfp-zone-links' ).evaluateAll( ( els ) =>
		els.map( ( el ) => {
			const chemin = ( a ) => new URL( a.href ).pathname;
			return {
				titre: ( el.querySelector( 'h2, h3' )?.textContent || '' ).trim(),
				rangees: [ ...el.querySelectorAll( 'a.tfp-dept-row' ) ].map( chemin ),
				puces: [ ...el.querySelectorAll( 'a.tfp-chip' ) ].map( ( a ) => ( { texte: a.textContent.trim(), chemin: chemin( a ) } ) ),
				villes: [ ...el.querySelectorAll( 'a.tfp-ville-row' ) ].map( chemin ),
			};
		} )
	);
}

test.describe( 'Maillage des 18 pages ville et commune (§2)', () => {
	expect( LOCALES ).toHaveLength( 18 );

	for ( const route of LOCALES ) {
		test( route, async ( { page } ) => {
			await page.goto( route );
			const dept = deptDe( route );
			const groupes = await relever( page );
			const groupe = ( titre ) => groupes.find( ( g ) => g.titre === titre );

			const meme = groupe( 'Dans le même département' );
			const autres = groupe( 'Autres secteurs couverts en région' );
			const proches = groupe( 'Communes proches desservies' );
			expect( meme, 'groupe « Dans le même département » présent' ).toBeTruthy();

			// La rangée du groupe pointe vers le département de la page, et lui seul.
			expect( meme.rangees ).toEqual( [ `/zones-intervention/${ dept }/` ] );
			// Aucune puce du groupe ne sort du département.
			for ( const p of meme.puces ) expect( deptDe( p.chemin ), `${ p.texte } sous « même département »` ).toBe( dept );
			if ( VILLE_UNIQUE.includes( dept ) ) expect( meme.puces, 'département à ville unique' ).toEqual( [] );

			if ( proches ) for ( const p of proches.puces ) expect( deptDe( p.chemin ), `${ p.texte } sous « communes proches »` ).toBe( dept );

			if ( autres ) {
				expect( autres.puces.length ).toBeGreaterThan( 0 );
				for ( const p of autres.puces ) {
					const d = deptDe( p.chemin );
					expect( d, `${ p.texte } sous « autres secteurs »` ).not.toBe( dept );
					// Le numéro affiché est celui du département de destination.
					expect( p.texte, p.chemin ).toMatch( new RegExp( `\\(${ CODES[ d ] }\\)$` ) );
				}
			}

			// Ni auto-lien ni doublon dans l'ensemble des groupes géographiques.
			const cibles = [ proches, meme, autres ].filter( Boolean ).flatMap( ( g ) => g.puces.map( ( p ) => p.chemin ) );
			expect( cibles, 'auto-lien' ).not.toContain( route );
			expect( new Set( cibles ).size, `doublon : ${ cibles.join( ', ' ) }` ).toBe( cibles.length );

			// Toute destination est une zone réelle de la table des routes.
			const connues = new Set( [ ...LOCALES, ...DEPTS ] );
			for ( const c of cibles ) expect( connues.has( c ), c ).toBe( true );

			expect( await page.locator( 'main' ).innerText() ).not.toMatch( /Départements limitrophes/i );
		} );
	}
} );

test.describe( 'Maillage des huit pages département (§2)', () => {
	expect( DEPTS ).toHaveLength( 8 );

	for ( const route of DEPTS ) {
		test( route, async ( { page } ) => {
			await page.goto( route );
			const dept = deptDe( route );
			const groupes = await relever( page );

			const villes = groupes.find( ( g ) => g.titre === 'Nos villes d\'intervention dans le département' );
			expect( villes.villes.length ).toBeGreaterThan( 0 );
			for ( const v of villes.villes ) expect( deptDe( v ), v ).toBe( dept );
			if ( VILLE_UNIQUE.includes( dept ) ) expect( villes.villes ).toHaveLength( 1 );

			const autres = groupes.find( ( g ) => g.titre === 'Nos autres secteurs en Bourgogne-Franche-Comté' );
			expect( autres, 'nouvel intitulé' ).toBeTruthy();
			const cibles = autres.puces.map( ( p ) => p.chemin );
			expect( cibles ).toHaveLength( 7 );
			expect( cibles ).not.toContain( route );
			expect( new Set( cibles ).size ).toBe( 7 );
			for ( const c of cibles ) expect( DEPTS ).toContain( c );

			expect( await page.locator( 'main' ).innerText() ).not.toMatch( /Départements limitrophes/i );
		} );
	}
} );
