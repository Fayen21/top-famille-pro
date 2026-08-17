// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

/**
 * G26 — corrections après le refus de validation du 17 août 2026.
 *
 * Bloc 1 : aucune note Google non vérifiée sur le site public.
 *
 * La note 5,0/5 était affichée sur la foi d'une confirmation orale. La validation humaine l'a
 * refusée tant qu'aucune vérification officielle n'est fournie : une note de plateforme tierce
 * affirmée sans lien vers sa source n'est pas contrôlable par le visiteur. La garde est posée
 * dans `tfp_reassurance_data()` — la note n'est exposée que si l'URL de la fiche Google est
 * saisie avec elle — si bien qu'AUCUN gabarit ne peut la faire réapparaître seul.
 *
 * Ce qui reste autorisé, et que ces tests ne doivent pas casser : les étoiles décoratives des
 * cartes de témoignage provisoires, qui portent `data-tfp-provisional` ET leur mention visible.
 */

test.describe( 'G26 · aucune note Google non vérifiée sur les 53 routes', () => {
	// ROUTES porte des objets { url, family, robots } — on ne teste que l'URL.
	for ( const { url: route } of ROUTES ) {
		test( `${ route } : ni note, ni étoiles hors témoignage provisoire`, async ( { page } ) => {
			const reponse = await page.goto( route );
			expect( reponse?.status(), `${ route } ne répond pas 200` ).toBe( 200 );

			const html = await page.content();
			// Aucune formulation de note de plateforme, sous aucune de ses formes.
			expect( html, 'note « X,X/5 sur Google » présente' ).not.toMatch( /\d[,.]\d\s*\/\s*5\s*(sur\s+)?Google/i );
			expect( html, 'mention « sur Google » présente' ).not.toMatch( /sur\s+Google/i );
			// Aucun badge de note, sous aucune variante.
			await expect( page.locator( '.tfp-google-badge' ) ).toHaveCount( 0 );
			await expect( page.locator( '.tfp-topbar__rating' ) ).toHaveCount( 0 );

			// Les seules étoiles tolérées sont celles d'un contenu provisoire marqué ET annoncé.
			// La mention peut couvrir un GROUPE de témoignages (elle est alors posée sur le bloc qui
			// les contient, et non répétée sur chaque carte) : on la cherche donc sur toute la
			// remontée d'ancêtres, ce qui correspond à ce que le visiteur voit à l'écran.
			const etoiles = page.locator( ':text("★★★★★")' );
			const n = await etoiles.count();
			for ( let i = 0; i < n; i++ ) {
				const ok = await etoiles.nth( i ).evaluate( ( el ) => {
					for ( let a = el; a; a = a.parentElement ) {
						if ( a.querySelector && a.querySelector( '[data-tfp-provisional-notice]' ) ) {
							return !! a.closest( '[data-tfp-provisional]' ) || !! a.querySelector( '[data-tfp-provisional]' );
						}
					}
					return false;
				} );
				expect( ok, `étoiles sans marquage ni mention provisoire visible sur ${ route }` ).toBe( true );
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
