// @ts-check
import { test, expect } from '@playwright/test';

/**
 * G25 — les six vignettes 56 px de la bande de maillage du pilier.
 *
 * La maquette pose, dans la bande « Nos six prestations de nettoyage professionnel »
 * (fond #10263B), la photo de CHAQUE prestation en miniature : THUMB_56 — 56×56, rayon 10,
 * object-fit cover, flex-shrink 0, alt vide (décorative — la maquette le déclare elle-même :
 * imgEl(s.photo, '')). Le thème les omettait : 10 images côté maquette, 4 côté thème.
 * Les sources sont les fichiers EXACTS du standalone, dédupliqués par SHA-256
 * (assets/photos/unsplash-*-800.jpg, slots thumb-* du manifeste).
 */

const ORDRE = [ 'bureaux', 'commerces', 'cabinets', 'coproprietes', 'meubles', 'ponctuel' ];

test.describe( 'G25 · vignettes de la bande de maillage du pilier', () => {
	test( 'six miniatures, dans l’ordre de la maquette, aux bonnes sources', async ( { page } ) => {
		await page.goto( '/nettoyage-professionnel/' );
		const thumbs = page.locator( '.tfp-card-tile--thumb .tfp-card-tile__thumb img' );
		await expect( thumbs ).toHaveCount( 6 );
		for ( let i = 0; i < 6; i++ ) {
			const src = await thumbs.nth( i ).evaluate( ( el ) => el.currentSrc || el.src );
			expect( src, `vignette ${ i + 1 } hors ordre` ).toContain( 'thumb-' + ORDRE[ i ] );
			await expect( thumbs.nth( i ) ).toHaveAttribute( 'alt', '' );
			await expect( thumbs.nth( i ) ).toHaveAttribute( 'loading', 'lazy' );
		}
		// La page porte les DIX images de la maquette : logo, hero, six vignettes, portrait, pied.
		const total = await page.evaluate( () => document.images.length );
		expect( total ).toBe( 10 );
	} );

	test.describe( 'géométrie déclarée aux largeurs où la bande est visible', () => {
		for ( const width of [ 375, 768, 1440 ] ) {
			test( `${ width } px : 56×56, rayon 10, cover, tuile centrée à l’écart 14`, async ( { page } ) => {
				await page.setViewportSize( { width, height: 900 } );
				await page.goto( '/nettoyage-professionnel/' );
				const tuile = page.locator( '.tfp-card-tile--thumb' ).first();
				await tuile.scrollIntoViewIfNeeded();
				const d = await tuile.evaluate( ( el ) => {
					const img = el.querySelector( '.tfp-card-tile__thumb img' );
					const r = img.getBoundingClientRect();
					const ci = getComputedStyle( img );
					const ct = getComputedStyle( el );
					return {
						w: Math.round( r.width ),
						h: Math.round( r.height ),
						rayon: ci.borderRadius,
						fit: ci.objectFit,
						gap: ct.gap,
						align: ct.alignItems,
						cassee: img.naturalWidth === 0,
					};
				} );
				expect( d.w ).toBe( 56 );
				expect( d.h ).toBe( 56 );
				expect( d.rayon ).toBe( '10px' );
				expect( d.fit ).toBe( 'cover' );
				expect( d.gap ).toBe( '14px' );
				expect( d.align ).toBe( 'center' );
				expect( d.cassee ).toBe( false );
			} );
		}
	} );

	test( 'le zoom hors pilier reste sans miniature (non-régression du composant)', async ( { page } ) => {
		// Les autres grilles de cartes (facteurs des tarifs, articles…) ne portent pas ce marqueur
		// dans le seed : aucune miniature ne doit apparaître ailleurs par effet de bord.
		for ( const route of [ '/tarifs/', '/pourquoi-nous/' ] ) {
			await page.goto( route );
			await expect( page.locator( '.tfp-card-tile--thumb' ) ).toHaveCount( 0 );
		}
	} );
} );
