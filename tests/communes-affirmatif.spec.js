// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

/**
 * Les huit communes desservies, et les corrections grammaticales de `CLAUDE.md` §9.
 *
 * ## Pourquoi ce fichier existe
 *
 * Le texte des huit communes secondaires a été écrit quand leur desserte n'était pas confirmée :
 * il est passé à l'affirmatif le 17 août 2026, Emmanuel ayant confirmé qu'Audrey y intervient.
 * Ce texte vient de `bin/seed-fidelite-zones.php`, **fichier généré** par `tools/generate-zones.mjs`
 * à partir de la maquette : une régénération sans la table `CORRECTIONS_EDITORIALES` le ramènerait
 * silencieusement à sa forme d'origine. Le contrôle porte donc sur la page servie, pas sur le seed.
 *
 * Il en va de même des accords : la maquette écrit « sont possible lorsque prévu … et chiffré dans
 * le devis », trois fautes dans la même incise, répétées 28 fois sur les 26 zones. `CLAUDE.md` §9
 * les nomme explicitement. Elles sont corrigées dans le générateur, donc reproductibles — et
 * vérifiées ici sur le HTML rendu, seul endroit où la faute serait visible d'un lecteur.
 */

/** Les huit communes validées le 17 août 2026, avec leur route servie. */
const COMMUNES = [
	{ slug: 'saint-apollinaire', nom: 'Saint-Apollinaire' },
	{ slug: 'chenove', nom: 'Chenôve' },
	{ slug: 'quetigny', nom: 'Quetigny' },
	{ slug: 'talant', nom: 'Talant' },
	{ slug: 'longvic', nom: 'Longvic' },
	{ slug: 'fontaine-les-dijon', nom: 'Fontaine-lès-Dijon' },
	{ slug: 'marsannay-la-cote', nom: 'Marsannay-la-Côte' },
	{ slug: 'beaune', nom: 'Beaune' },
];

/**
 * Une affirmation de desserte : l'entreprise est sujet, le verbe est au présent d'action.
 * « Top-Famille Pro y entretient … », « Top-Famille Pro est implantée à … » pour le siège.
 */
const AFFIRMATION =
	/Top-Famille Pro (?:y )?(?:intervient|entretient|assure|nettoie|est implantée)|nous (?:intervenons|entretenons)/i;

/**
 * Tournures qui laissent entendre que la desserte n'est pas acquise. Elles restent légitimes
 * ailleurs — Beaune répond « peuvent être étudiées » au sujet de Savigny-lès-Beaune et Pommard,
 * qui ne font pas partie des huit — d'où la restriction aux phrases qui nomment la commune de la
 * page elle-même.
 */
const CONDITIONNEL = [
	/peut être étudiée/i,
	/peuvent être étudiées/i,
	/nous consulter/i,
	/à confirmer/i,
	/n['’]est pas (?:encore )?confirmée?/i,
	/sous réserve/i,
	/peut être envisagé/i,
	/peuvent être envisagé/i,
];

test.describe( 'Les huit communes affirment la desserte', () => {
	for ( const { slug, nom } of COMMUNES ) {
		test( `${ nom } : la réponse directe affirme l’intervention`, async ( { page } ) => {
			await page.goto( `/zones-intervention/cote-dor/${ slug }/` );

			const reponse = page.locator( '.tfp-direct-answer__text' );
			await expect( reponse, 'la réponse directe est l’endroit où le visiteur cherche' ).toBeVisible();
			const texte = ( await reponse.textContent() ) || '';
			expect(
				texte,
				`${ nom } : la réponse directe décrit la commune sans dire que nous y intervenons`
			).toMatch( AFFIRMATION );
		} );

		test( `${ nom } : aucune tournure conditionnelle à son sujet`, async ( { page } ) => {
			await page.goto( `/zones-intervention/cote-dor/${ slug }/` );

			const blocs = [
				( await page.locator( '.tfp-direct-answer__text' ).textContent() ) || '',
				...( await page.locator( '.tfp-faq-item' ).allTextContents() ),
			];
			expect( blocs.length, 'réponse directe et FAQ doivent être relevées' ).toBeGreaterThan( 1 );

			const fautives = blocs
				.flatMap( ( b ) => b.replace( /\s+/g, ' ' ).split( /(?<=[.!?])\s+/ ) )
				.filter( ( p ) => p.includes( nom ) && CONDITIONNEL.some( ( r ) => r.test( p ) ) );

			expect( fautives, `${ nom } : desserte présentée comme hypothétique` ).toEqual( [] );
		} );

		test( `${ nom } : indexable et description affirmative`, async ( { page } ) => {
			await page.goto( `/zones-intervention/cote-dor/${ slug }/` );
			await expect( page.locator( 'meta[name="robots"]' ) ).toHaveAttribute(
				'content',
				'index,follow'
			);
			const desc =
				( await page.locator( 'meta[name="description"]' ).getAttribute( 'content' ) ) || '';
			expect( desc, `${ nom } : la meta description doit nommer la commune` ).toContain( nom );
			expect( desc ).not.toMatch( /peut être étudiée|sous réserve/i );
		} );
	}
} );

test.describe( 'Corrections grammaticales imposées (CLAUDE.md §9)', () => {
	/**
	 * Les fautes nommées par §9 qui étaient encore servies. Deux autres corrections de §9 —
	 * « aucun simulateur » et « agences fictives » — sont au contraire **différées** par la décision
	 * du 10 août 2026 (voir `docs/ECARTS-MAQUETTE-AUTORISES.md`) : elles ne sont pas contrôlées ici,
	 * et les rétablir ne doit pas faire échouer la suite.
	 */
	const FAUTES = [
		{ motif: /lorsque prévu/, nom: '« lorsque prévu » (participe non accordé)' },
		{ motif: /\bsont possible\b/, nom: '« sont possible » (accord du pluriel)' },
		{ motif: /precisément/, nom: '« precisément » (accent manquant)' },
		{ motif: /Top-Entreprise/, nom: '« Top-Entreprise » (ancienne marque, CLAUDE.md §9)' },
	];

	for ( const route of ROUTES ) {
		const chemin = route.path || route.url || route;
		test( `${ chemin } — aucune faute nommée par §9`, async ( { page } ) => {
			await page.goto( chemin );
			const texte = ( await page.locator( 'body' ).innerText() ).replace( /\s+/g, ' ' );
			for ( const { motif, nom } of FAUTES ) {
				expect( texte, `${ chemin } : ${ nom }` ).not.toMatch( motif );
			}
		} );
	}
} );
