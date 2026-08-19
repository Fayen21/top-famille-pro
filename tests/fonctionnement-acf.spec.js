// @ts-check
import { test, expect } from '@playwright/test';
import { execFileSync } from 'node:child_process';
import { existsSync } from 'node:fs';

/**
 * Le champ ACF `fonctionnement` alimente réellement une section servie.
 *
 * ## Pourquoi ce fichier existe
 *
 * `fonctionnement` était enregistré en ACF, éditable en administration, alimenté sur les 26 zones
 * par les seeds — et affiché nulle part : `single-zone.php` le lisait sans jamais l'écrire. Un
 * éditeur pouvait y corriger un texte en croyant publier. C'est le pire des trois états possibles :
 * un champ absent se voit, un champ affiché se relit, un champ muet se croit publié.
 *
 * Il pilote désormais le chapitre de méthode que la maquette consacre au fonctionnement sur chaque
 * zone — « Sélection, intervenant habituel et suivi » sur Dijon, « Fonctionnement, sélection et
 * suivi » sur Chenôve, « Déplacements et organisation des tournées » en Côte-d'Or. Aucune bande
 * nouvelle, aucun changement d'ordre : c'est le texte du chapitre existant qui vient du champ.
 *
 * ## Ce que le test prouve, et comment
 *
 * Un contrôle qui se contenterait de lire la page prouverait seulement que du texte s'affiche, pas
 * qu'il vient du champ. On écrit donc un **marqueur** dans le champ, on relit la page servie, puis
 * on rétablit la valeur d'origine dans un `finally` — un échec en cours de route ne laisse jamais
 * de donnée de test derrière lui.
 */

const RIG = process.env.TFP_RIG || '/tmp/tfp-rig';
const WP_CLI = `${ RIG }/wp-cli.phar`;
const WP_CORE = `${ RIG }/wp-core`;

/** Le banc local, seul environnement où l'on puisse écrire puis relire. */
const rigDisponible = existsSync( WP_CLI ) && existsSync( WP_CORE );

/** Exécute du PHP dans le contexte WordPress du banc et retourne sa sortie. */
function wpEval( php ) {
	return execFileSync(
		'php',
		[ WP_CLI, `--path=${ WP_CORE }`, '--allow-root', 'eval', php ],
		{ encoding: 'utf8' }
	).trim();
}

/** Identifiant du post `zone` portant ce slug. */
function idZone( slug ) {
	const out = wpEval(
		`$p = get_posts( array( 'post_type' => 'zone', 'name' => '${ slug }', 'numberposts' => 1, ` +
			`'post_status' => 'any' ) ); echo $p ? $p[0]->ID : 0;`
	);
	return parseInt( out.split( '\n' ).pop() || '0', 10 );
}

function lireChamp( id, champ ) {
	return wpEval(
		`echo function_exists('get_field') ? (string) get_field('${ champ }', ${ id }) ` +
			`: (string) get_post_meta( ${ id }, '${ champ }', true );`
	);
}

function ecrireChamp( id, champ, valeur ) {
	const b64 = Buffer.from( valeur, 'utf8' ).toString( 'base64' );
	wpEval(
		`$v = base64_decode('${ b64 }'); if ( function_exists('update_field') ) ` +
			`{ update_field('${ champ }', $v, ${ id }); } else { update_post_meta( ${ id }, '${ champ }', $v ); } ` +
			`clean_post_cache( ${ id } );`
	);
}

/**
 * Trois zones aux profils différents : une ville dont le chapitre est le quatrième, une commune
 * dont il est le deuxième, un département sans chapitre « Sélection… » où c'est celui de
 * l'organisation des tournées qui est désigné. Si la mécanique tenait à un rang particulier, l'une
 * des trois le montrerait.
 */
const CAS = [
	{ slug: 'dijon', route: '/zones-intervention/cote-dor/dijon/', chapitre: 'Sélection, intervenant habituel et suivi' },
	{ slug: 'quetigny', route: '/zones-intervention/cote-dor/quetigny/', chapitre: 'Fonctionnement, sélection et suivi' },
	{ slug: 'cote-dor', route: '/zones-intervention/cote-dor/', chapitre: 'Déplacements et organisation des tournées' },
];

test.describe( 'Champ ACF « fonctionnement » — destination réelle', () => {
	test( 'chaque page de zone porte exactement un chapitre piloté par le champ', async ( { page, request } ) => {
		const { ROUTES } = await import( './data/routes.js' );
		const zones = ROUTES
			.map( ( r ) => r.path || r.url || r )
			.filter( ( p ) => /^\/zones-intervention\/[^/]+\/([^/]+\/)?$/.test( p ) )
			// La page région est une page WordPress classique, pas une entrée du CPT `zone`.
			.filter( ( p ) => p !== '/zones-intervention/bourgogne-franche-comte/' );

		expect( zones.length, 'les 26 zones doivent être couvertes' ).toBe( 26 );

		for ( const route of zones ) {
			await page.goto( route );
			await expect(
				page.locator( '[data-tfp-champ="fonctionnement"]' ),
				`${ route } : le champ doit piloter un chapitre, et un seul`
			).toHaveCount( 1 );
		}
	} );

	for ( const cas of CAS ) {
		test( `${ cas.slug } : le chapitre piloté est bien « ${ cas.chapitre } »`, async ( { page } ) => {
			await page.goto( cas.route );
			const titre = page.locator( '[data-tfp-champ="fonctionnement"] h2' );
			await expect( titre ).toHaveText( cas.chapitre );
		} );

		test( `${ cas.slug } : une modification en administration apparaît sur la page servie`, async ( {
			page,
		} ) => {
			test.skip( ! rigDisponible, `banc local absent (${ RIG }) : écriture impossible` );

			const id = idZone( cas.slug );
			expect( id, `zone ${ cas.slug } introuvable dans le banc` ).toBeGreaterThan( 0 );

			const origine = lireChamp( id, 'fonctionnement' );
			expect( origine, `${ cas.slug } : le champ doit être alimenté par le seed` ).not.toBe( '' );

			// Un marqueur qu'aucun contenu réel ne peut porter, et qui nomme sa propre origine :
			// s'il fuitait malgré le `finally`, on saurait immédiatement d'où il vient.
			const marqueur = `TFP-MARQUEUR-TEST-FONCTIONNEMENT-${ cas.slug.toUpperCase() }`;
			const premierParagraphe = origine.split( '\n' )[ 0 ];

			try {
				ecrireChamp( id, 'fonctionnement', marqueur );
				await page.goto( cas.route, { waitUntil: 'domcontentloaded' } );

				const corps = await page.locator( 'body' ).innerText();
				const occurrences = corps.split( marqueur ).length - 1;
				expect( occurrences, `${ cas.route } : le marqueur doit apparaître une seule fois` ).toBe( 1 );

				// … et à l'endroit désigné, pas ailleurs dans la page.
				const chapitre = page.locator( '[data-tfp-champ="fonctionnement"]' );
				await expect( chapitre ).toContainText( marqueur );
				await expect( chapitre.locator( 'h2' ) ).toHaveText( cas.chapitre );

				// Jamais les deux : le texte d'origine du chapitre ne doit plus être servi.
				expect(
					corps,
					`${ cas.route } : contenu historique ET champ ACF affichés en même temps`
				).not.toContain( premierParagraphe );

				// Et nulle part ailleurs : aucune autre section ne reprend le marqueur.
				const ailleurs = await page
					.locator( `section:not(:has([data-tfp-champ="fonctionnement"]))` )
					.allInnerTexts();
				expect(
					ailleurs.filter( ( t ) => t.includes( marqueur ) ),
					`${ cas.route } : le marqueur déborde sur une autre section`
				).toEqual( [] );
			} finally {
				ecrireChamp( id, 'fonctionnement', origine );
			}

			// Aucune donnée de test persistante : la page rendue est redevenue celle du seed.
			await page.goto( cas.route, { waitUntil: 'domcontentloaded' } );
			const apres = await page.locator( 'body' ).innerText();
			expect( apres, 'marqueur de test resté en base' ).not.toContain( marqueur );
			expect( apres ).toContain( premierParagraphe );
			expect( lireChamp( id, 'fonctionnement' ) ).toBe( origine );
		} );
	}

	test( 'le repli ne sert que si le champ est vide, et jamais en même temps', async ( { page } ) => {
		test.skip( ! rigDisponible, `banc local absent (${ RIG }) : écriture impossible` );

		const id = idZone( 'quetigny' );
		const origine = lireChamp( id, 'fonctionnement' );
		const route = '/zones-intervention/cote-dor/quetigny/';

		try {
			ecrireChamp( id, 'fonctionnement', '' );
			await page.goto( route, { waitUntil: 'domcontentloaded' } );

			// Champ vide : le chapitre existe toujours, avec son texte d'origine, et n'est plus
			// marqué comme piloté — la page ne perd jamais son contenu parce qu'un champ est vidé.
			await expect( page.locator( '[data-tfp-champ="fonctionnement"]' ) ).toHaveCount( 0 );
			const corps = await page.locator( 'body' ).innerText();
			expect( corps, 'le repli doit prendre le relais' ).toContain( origine.split( '\n' )[ 0 ] );
		} finally {
			ecrireChamp( id, 'fonctionnement', origine );
		}
	} );
} );
