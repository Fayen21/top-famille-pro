// @ts-check
import { test, expect } from '@playwright/test';

/**
 * G24 — phase A : images exactes des quatre héros.
 *
 * Les fichiers sources du dépôt sont octet pour octet les assets embarqués du standalone Claude
 * Design (empreintes SHA-256 relevées en G24, docs/CHECKPOINT-FIDELITE.json §g24) :
 *   pilier      assets/photos/intervenante-stock-bureaux.jpg  = asset 3727bc9c… (sha256 dbc3d616…)
 *   région      assets/photos/locaux-professionnels-region.jpg = asset 2b5b290d… (sha256 64547308…)
 *   à-propos    assets/photos/portrait-stock-a-propos.jpg      = asset 63dd6687… (sha256 c6c51783…)
 *   recrutement assets/photos/intervenante-stock-materiel.jpg  = asset d02c99e5… (sha256 600a388c…)
 * Ces tests verrouillent le slot servi par chaque route, le cadrage déclaré, et le statut
 * provisoire du portrait (CLAUDE.md §5.6 : jamais présenté comme Audrey).
 */

const HEROS = [
	{ route: '/nettoyage-professionnel/', slot: 'hero-pilier', ratio: '4 / 3' },
	{ route: '/zones-intervention/bourgogne-franche-comte/', slot: 'hero-region', ratio: '4 / 3' },
	{ route: '/recrutement/', slot: 'service-generic', ratio: '4 / 3' },
];

test.describe( 'G24 · images exactes des héros', () => {
	for ( const { route, slot, ratio } of HEROS ) {
		test( `${ route } sert le slot ${ slot } en ${ ratio } sans déformation`, async ( { page } ) => {
			await page.goto( route );
			const img = page.locator( '.tfp-hero__media-main img' ).first();
			await expect( img ).toBeVisible();
			const d = await img.evaluate( ( el ) => {
				const c = getComputedStyle( el );
				const b = el.getBoundingClientRect();
				return {
					src: ( el.currentSrc || el.src || '' ).split( '/' ).pop(),
					fit: c.objectFit,
					ar: c.aspectRatio,
					ratio: b.width / b.height,
					casse: el.naturalWidth === 0,
				};
			} );
			expect( d.src ).toContain( slot );
			expect( d.casse ).toBe( false );
			expect( d.fit ).toBe( 'cover' );
			expect( d.ar ).toBe( ratio );
			expect( Math.abs( d.ratio - 4 / 3 ) ).toBeLessThan( 0.01 );
			// Aucune image en base64 dans le HTML : le pipeline sert des fichiers.
			expect( d.src ).not.toContain( 'base64' );
		} );
	}

	test( 'à-propos : aucun portrait ni monogramme, la gérante est présentée par du texte', async ( { page } ) => {
		// 13 novembre 2026 : plus de visage d'emprunt à côté du nom d'Audrey, plus de mention
		// « photo provisoire » (CLAUDE.md §5.6). La gérante est présentée par du texte.
		await page.goto( '/a-propos/' );
		const carte = page.locator( '.tfp-hero__media--carte-gerante' );
		await expect( carte.locator( 'img' ) ).toHaveCount( 0 );
		await expect( carte.locator( '.tfp-monogramme' ) ).toHaveCount( 0 );
		await expect( carte.locator( '.tfp-carte-gerante__faits li' ) ).toHaveCount( 3 );
		await expect( carte ).toContainText( 'Audrey Brançon' );
		await expect( carte ).toContainText( 'Gérante de Top-Famille Pro' );
		await expect( page.locator( '[data-tfp-provisional-notice]' ) ).toHaveCount( 0 );
	} );

	test( 'chaque héros expose AVIF, WebP et un JPG de secours avec dimensions explicites', async ( { page } ) => {
		for ( const { route } of HEROS ) {
			await page.goto( route );
			const picture = page.locator( '.tfp-hero__media-main picture' ).first();
			await expect( picture.locator( 'source[type="image/avif"]' ) ).toHaveCount( 1 );
			await expect( picture.locator( 'source[type="image/webp"]' ) ).toHaveCount( 1 );
			const img = picture.locator( 'img' );
			await expect( img ).toHaveAttribute( 'width', /\d+/ );
			await expect( img ).toHaveAttribute( 'height', /\d+/ );
			await expect( img ).toHaveAttribute( 'srcset', /w,/ );
			await expect( img ).toHaveAttribute( 'sizes', /vw/ );
		}
	} );
} );
