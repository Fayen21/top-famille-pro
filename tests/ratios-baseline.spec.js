// @ts-check
import { test, expect } from '@playwright/test';
import { readFileSync } from 'node:fs';
import path from 'node:path';

/**
 * Relevé de base — 298 contrôles sur 318 dans la plage de fidélité.
 *
 * Le seuil était de 300 jusqu'au 20 août 2026. Il a été abaissé à 298 sur validation d'Emmanuel,
 * en CORRIGEANT `/avis-clients/` et non en la dégradant : voir `LEGALES` et `docs/DECISIONS.json`.
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
 * largeurs : 18 contrôles. S'y ajoute `/avis-clients/` à 1 440 et 1 920 px depuis le 20 août 2026,
 * pour cause de contenu obligatoire — 20 contrôles au total. **Toutes les autres routes doivent
 * tenir dans 95-105 %.**
 */

const RACINE = path.resolve( path.dirname( new URL( import.meta.url ).pathname ), '..' );
const LARGEURS = [ '320', '375', '768', '1024', '1440', '1920' ];
const BANDE = [ 95, 105 ];

/**
 * Les seules routes autorisées hors tolérance, et la raison.
 *
 * Chaque entrée est une décision humaine, pas une commodité de mesure : la liste ne s'allonge que
 * sur validation explicite d'Emmanuel, et `docs/DECISIONS.json` en porte la trace datée.
 */
const LEGALES = {
	'#/mentions-legales': 'mentions légales réelles (CLAUDE.md §5.7)',
	'#/politique-de-confidentialite': 'politique de confidentialité réelle (RGPD)',
	'#/gestion-des-cookies': 'gestion des cookies réelle',
	/*
	 * Ajoutée le 20 août 2026, sur validation d'Emmanuel — décision `avis-clients-hors-plage`.
	 *
	 * À 1 440 et 1 920 px, la page mesure 106 %. Les 185 px d'excédent se décomposent : 84 px de
	 * rangée de commandes de hero (décision du 17 août, verrouillée par `ecarts-structure.spec.js`)
	 * et 60 px de mentions « Exemples de présentation » (CLAUDE.md §5.5, verrouillées par
	 * `provisoire.spec.js`). Sans ces deux exigences, la page serait à 101 %.
	 *
	 * Elle tenait la plage AVANT le 20 août grâce à deux erreurs qui se compensaient : une carte
	 * d'avis blanche et trop courte absorbait la hauteur des mentions. La rendre fidèle au
	 * prototype n'a pas créé l'écart, il l'a rendu visible.
	 */
	'#/avis-clients': 'contenu obligatoire : commandes de hero + mentions provisoires (décision du 2026-08-20)',
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

	test( 'seules les routes explicitement autorisées sortent de 95-105 %', () => {
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

	test( 'au moins 298 des 318 contrôles sont dans la plage', () => {
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
		/*
		 * Seuil abaissé de 300 à 298 le 20 août 2026, sur validation d'Emmanuel.
		 *
		 * Les deux contrôles perdus sont `/avis-clients/` à 1 440 et 1 920 px, et ils l'ont été en
		 * CORRIGEANT la page, pas en la dégradant : voir la note sur `LEGALES` ci-dessus. Le seuil
		 * suit la décision, il ne la précède pas.
		 */
		expect( dans, `${ dans } / ${ total } contrôles dans 95-105 %` ).toBeGreaterThanOrEqual( 298 );
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

/**
 * Poids des polices — le premier facteur du LCP mobile (G27 §11).
 *
 * ## Pourquoi ce contrôle existe
 *
 * L'accueil pesait 341 Ko, **dont 264 Ko de polices** : sept fichiers pour deux familles, tous de
 * tailles rigoureusement identiques d'une graisse à l'autre. Ce n'étaient pas sept polices — c'était
 * le même fichier variable téléchargé sept fois, parce que Google, interrogé graisse par graisse,
 * renvoie quinze déclarations pointant vers trois URL, et que le téléchargeur en faisait quinze
 * fichiers de noms différents.
 *
 * Une seule ligne de `build/fetch-fonts.mjs` peut ramener ce défaut — repasser d'une plage
 * (`wght@400..800`) à une liste (`wght@400;500;…`) — et rien ne le signalerait : le site
 * s'afficherait exactement pareil, en quatre fois plus lourd. D'où ce contrôle sur le rendu servi.
 */
test.describe( 'Polices — un fichier par famille, pas un par graisse', () => {
	test( 'le premier écran ne charge que deux fichiers de police', async ( { page } ) => {
		const polices = [];
		page.on( 'request', ( r ) => {
			if ( /\.woff2?(\?|$)/.test( r.url() ) ) polices.push( r.url().split( '/' ).pop() );
		} );

		await page.goto( '/', { waitUntil: 'networkidle' } );

		expect(
			polices.length,
			`fichiers de police chargés : ${ polices.join( ', ' ) } — la famille doit être servie en ` +
				'variable, un fichier par sous-ensemble'
		).toBeLessThanOrEqual( 2 );

		// Et ce sont bien les fichiers variables, pas deux graisses parmi d'autres.
		for ( const f of polices ) {
			expect( f, `${ f } : nom de fichier par graisse, la police n’est plus variable` ).toContain(
				'variable'
			);
		}
	} );

	test( 'chaque @font-face déclare une PLAGE de graisses', async ( { page } ) => {
		await page.goto( '/' );
		const faces = await page.evaluate( () => {
			const out = [];
			for ( const f of document.styleSheets ) {
				let regles;
				try {
					regles = f.cssRules;
				} catch {
					continue;
				}
				for ( const r of regles ) {
					if ( r.constructor.name === 'CSSFontFaceRule' ) {
						out.push( { famille: r.style.fontFamily, poids: r.style.fontWeight } );
					}
				}
			}
			return out;
		} );

		expect( faces.length, 'aucune déclaration @font-face relevée : le contrôle ne mesure rien' ).toBeGreaterThan( 0 );
		for ( const f of faces ) {
			expect(
				f.poids,
				`${ f.famille } déclare une graisse fixe (${ f.poids }) : un fichier par graisse revient, ` +
					'et avec lui 264 Ko de doublons'
			).toMatch( /\d+\s+\d+/ );
		}
	} );
} );
