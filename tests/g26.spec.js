// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

/**
 * G26 — corrections après le refus de validation du 17 août 2026.
 *
 * Bloc 1 : la note Google n'apparaît QUE si elle est autorisée, et jamais balisée.
 *
 * Histoire de ce bloc, parce qu'elle explique sa forme. La note 5,0/5 était affichée sur la foi
 * d'une confirmation orale ; la validation du 17 août 2026 l'a refusée, faute de lien vers la
 * fiche qui la porte. Le même jour, la conséquence lui ayant été exposée, Emmanuel a demandé de
 * la réafficher en attendant l'URL — décision assumée, portée par la case « Afficher sans la
 * fiche » de Réglages → Réassurance & avis (`note_sans_source`).
 *
 * Ces tests ne prennent donc PAS parti sur l'affichage : ils lisent l'état réel du réglage et
 * éprouvent la cohérence. Note autorisée ⇒ elle peut s'afficher. Note non autorisée ⇒ elle ne
 * doit apparaître nulle part, sur aucune des 53 routes. Écrire l'un ou l'autre en dur obligerait
 * à réécrire cinquante-trois tests à chaque changement d'avis, et l'un des deux sens finirait par
 * ne plus être éprouvé du tout.
 *
 * Ce qui NE dépend d'aucun réglage, et reste éprouvé sans condition :
 *  - aucune donnée structurée `Review` ni `AggregateRating` ;
 *  - aucun compteur d'avis tant que le nombre réel n'est pas saisi ;
 *  - aucun `href="#"` à la place de l'URL de la fiche ;
 *  - les étoiles décoratives ne sont tolérées que sur un témoignage provisoire portant
 *    `data-tfp-provisional` ET sa mention visible.
 */

/**
 * La note est-elle autorisée à l'affichage ? Lu sur la page servie, pas sur la base : c'est
 * l'état que le visiteur rencontre qui fait foi.
 */
async function noteAutorisee( page ) {
	await page.goto( '/' );
	return ( await page.locator( '.tfp-google-badge, .tfp-topbar__rating' ).count() ) > 0;
}

test.describe( 'G26 · la note Google n’apparaît que si elle est autorisée', () => {
	// ROUTES porte des objets { url, family, robots } — on ne teste que l'URL.
	for ( const { url: route } of ROUTES ) {
		test( `${ route } : note cohérente avec le réglage, étoiles marquées`, async ( { page } ) => {
			const autorisee = await noteAutorisee( page );
			const reponse = await page.goto( route );
			expect( reponse?.status(), `${ route } ne répond pas 200` ).toBe( 200 );

			const html = await page.content();

			/*
			 * Le compteur d'avis reste interdit dans TOUS les cas tant que le nombre réel n'est pas
			 * saisi : « 47 avis » est un chiffre du prototype, vérifiable et faux. Il ne relève pas
			 * de la même décision que la note.
			 */
			expect( html, 'compteur d’avis présent' ).not.toMatch( /\b\d+\s*avis\b/i );
			// Et jamais de lien mort à la place de la fiche.
			expect( html, 'href="#" publié' ).not.toMatch( /href="#"/ );

			if ( ! autorisee ) {
				// Note non autorisée : elle ne doit apparaître sous aucune forme, nulle part.
				expect( html, 'note « X,X/5 sur Google » présente' ).not.toMatch( /\d[,.]\d\s*\/\s*5\s*(sur\s+)?Google/i );
				expect( html, 'mention « sur Google » présente' ).not.toMatch( /sur\s+Google/i );
				await expect( page.locator( '.tfp-google-badge' ) ).toHaveCount( 0 );
				await expect( page.locator( '.tfp-topbar__rating' ) ).toHaveCount( 0 );
			}

			/*
			 * Étoiles. Deux origines seulement sont légitimes :
			 *
			 *  1. le badge de note Google, quand la note est autorisée ;
			 *  2. une carte de témoignage PROVISOIRE, qui porte `data-tfp-provisional` et dont la
			 *     mention visible est dans le même bloc.
			 *
			 * La première rédaction remontait les ancêtres jusqu'à trouver une mention provisoire
			 * « quelque part » : arrivée à `<body>`, elle en trouvait toujours une dès que la page
			 * en portait une seule, et le contrôle ne prouvait plus rien. On exige désormais que le
			 * marquage et la mention soient sur le MÊME ancêtre — le bloc du témoignage.
			 */
			const etoiles = page.locator( ':text("★★★★★")' );
			const n = await etoiles.count();
			for ( let i = 0; i < n; i++ ) {
				const origine = await etoiles.nth( i ).evaluate( ( el ) => {
					/*
					 * Des étoiles appartiennent à la NOTE si le bloc qui les contient énonce aussi
					 * la note. Le repère est le texte, pas une liste de classes : le thème présente
					 * la même note sous trois formes — la pastille de la barre haute, le badge en
					 * ligne, et une carte de réassurance sur /contact/. Énumérer les classes aurait
					 * laissé passer la troisième, et laissera passer la quatrième.
					 */
					for ( let a = el; a && a.tagName !== 'BODY'; a = a.parentElement ) {
						if ( /\d[,.]\d\s*\/\s*5\s*(sur\s+)?Google/i.test( a.textContent || '' ) ) return 'note';
					}
					const marque = el.closest( '[data-tfp-provisional]' );
					if ( ! marque ) return 'orpheline';
					/*
					 * La mention couvre légitimement un GROUPE : le composant de grille la pose une
					 * fois au-dessus de la liste, pas dans chaque carte. On la cherche donc au-delà
					 * du bloc marqué — mais de façon BORNÉE, sur trois niveaux au plus. Sans borne,
					 * la recherche atteint `<body>` et une seule mention sur la page suffisait à
					 * valider n'importe quelles étoiles : le contrôle ne prouvait plus rien.
					 */
					let portee = marque;
					for ( let n = 0; n < 3 && portee.parentElement; n++ ) {
						if ( portee.querySelector( '[data-tfp-provisional-notice]' ) ) return 'provisoire';
						portee = portee.parentElement;
					}
					return portee.querySelector( '[data-tfp-provisional-notice]' ) ? 'provisoire' : 'provisoire-sans-mention';
				} );
				if ( 'note' === origine ) {
					expect( autorisee, `${ route } : étoiles de note alors que la note n’est pas autorisée` ).toBe( true );
					continue;
				}
				expect( origine, `${ route } : étoiles sans marquage ni mention provisoire dans le même bloc` ).toBe( 'provisoire' );
			}
		} );
	}

	test( 'aucune donnée structurée Review ni AggregateRating', async ( { page } ) => {
		// Balisage interdit quoi qu'il arrive (CLAUDE.md §5.5) : une note de plateforme tierce
		// n'est pas une note du site, et un témoignage provisoire n'est pas un avis.
		for ( const route of [ '/', '/tarifs/', '/avis-clients/', '/prestations/bureaux/', '/zones-intervention/cote-dor/dijon/' ] ) {
			await page.goto( route );
			const blocs = await page.locator( 'script[type="application/ld+json"]' ).allTextContents();
			for ( const b of blocs ) {
				expect( b, `Review dans le JSON-LD de ${ route }` ).not.toContain( '"Review"' );
				expect( b, `AggregateRating dans le JSON-LD de ${ route }` ).not.toContain( 'AggregateRating' );
				expect( b, `ratingValue dans le JSON-LD de ${ route }` ).not.toContain( 'ratingValue' );
			}
		}
	} );

	test( 'la note revient si — et seulement si — elle est vérifiable', async () => {
		// Contrat de la garde, éprouvé sans passer par le navigateur : la note seule ne sort pas,
		// la note accompagnée de l'URL de sa fiche sort. C'est ce qui rend la suppression
		// réversible le jour où la vérification officielle est fournie.
		const { execFileSync } = await import( 'node:child_process' );
		const php = `
			define('ABSPATH', __DIR__ . '/');
			define('TFP_REASSURANCE_OPTION', 'tfp_reassurance');
			define('TFP_REASSURANCE_AVIS_MAX', 3);
			function get_option($k, $d = array()) { return $GLOBALS['opt']; }
			function wp_parse_args($a, $d) { return array_merge($d, is_array($a) ? $a : array()); }
			function esc_attr($s) { return $s; } function esc_html($s) { return $s; }
			function esc_url($s) { return $s; } function esc_textarea($s) { return $s; }
			function add_action() {} function add_filter() {} function sanitize_text_field($s) { return $s; }
			require_once 'wp-content/themes/topfamillepro/includes/reassurance-settings.php';
			$GLOBALS['opt'] = array('note' => '5.0', 'google_url' => '');
			$sans = tfp_reassurance_data()['note'];
			$GLOBALS['opt'] = array('note' => '5.0', 'google_url' => 'https://maps.google.com/?cid=1');
			$avec = tfp_reassurance_data()['note'];
			echo json_encode(array('sans_url' => $sans, 'avec_url' => $avec));
		`;
		const sortie = execFileSync( 'php', [ '-r', php ], { encoding: 'utf8' } );
		const r = JSON.parse( sortie.trim().split( '\n' ).pop() );
		expect( r.sans_url, 'la note sort alors que la fiche Google est absente' ).toBeNull();
		expect( r.avec_url, 'la note ne revient pas quand la fiche Google est fournie' ).toBe( 5 );
	} );
} );
