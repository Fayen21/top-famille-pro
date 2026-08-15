// @ts-check
import { test, expect } from '@playwright/test';

/**
 * G23 — tests ciblés des sept causes DEFAUT_THEME fermées dans cette passe.
 *
 * Chaque bloc verrouille l'état CORRIGÉ : rejoué sur le thème d'avant G23, chacun échoue sur la
 * propriété précise que la mesure avait mise en cause (docs/anomalies-g22.json, groupes_causaux).
 * Les valeurs attendues sont les règles DÉCLARÉES par la maquette, pas des hauteurs de confort.
 */

test.describe('G23 · badge-reassurance — la note des eyebrows intérieurs est nue', () => {
	// Sur ces pages, la maquette ne compose PAS la note en pastille au-dessus du H1 : sa seule
	// occurrence encadrée est celle de la barre haute. La pastille blanche du thème y comptait une
	// carte de plus (15 occurrences G22).
	const routesNues = [ '/prestations/', '/pourquoi-nous/', '/recrutement/' ];

	for ( const route of routesNues ) {
		test( `${ route } : badge sans fond, sans filet, sans rayon`, async ( { page } ) => {
			await page.goto( route );
			const badge = page.locator( '.tfp-google-badge--nu' ).first();
			await expect( badge ).toBeVisible();
			const s = await badge.evaluate( ( el ) => {
				const c = getComputedStyle( el );
				return { fond: c.backgroundColor, filet: parseFloat( c.borderTopWidth ) || 0, rayon: parseFloat( c.borderTopLeftRadius ) || 0 };
			} );
			expect( s.fond ).toBe( 'rgba(0, 0, 0, 0)' );
			expect( s.filet ).toBe( 0 );
			expect( s.rayon ).toBe( 0 );
			// Et aucune pastille encadrée résiduelle dans l'eyebrow de ces pages.
			await expect( page.locator( '.tfp-hero__eyebrow .tfp-google-badge--inline' ) ).toHaveCount( 0 );
		} );
	}

	test( 'accueil : le hero garde sa pastille blanche encadrée (non-régression)', async ( { page } ) => {
		await page.goto( '/' );
		const badge = page.locator( '.tfp-hero .tfp-google-badge--inline' ).first();
		await expect( badge ).toBeVisible();
		const s = await badge.evaluate( ( el ) => {
			const c = getComputedStyle( el );
			return { fond: c.backgroundColor, rayon: parseFloat( c.borderTopLeftRadius ) || 0 };
		} );
		expect( s.fond ).toBe( 'rgb(255, 255, 255)' );
		expect( s.rayon ).toBeGreaterThanOrEqual( 40 );
	} );

	test( 'tarifs : le témoignage est nu, centré, et garde son marquage provisoire', async ( { page } ) => {
		// La maquette pose la citation « Un devis clair… » NUE : aucun ancêtre encadré jusqu'au
		// corps de page. La carte commune (fond blanc, rayon 18) comptait une carte de plus.
		await page.goto( '/tarifs/' );
		const figure = page.locator( '.tfp-testimonial--plain.tfp-testimonial--centre .tfp-testimonial' ).first();
		await expect( figure ).toBeVisible();
		const s = await figure.evaluate( ( el ) => {
			const c = getComputedStyle( el );
			return { fond: c.backgroundColor, filet: parseFloat( c.borderTopWidth ) || 0, rayon: parseFloat( c.borderTopLeftRadius ) || 0, centre: c.textAlign };
		} );
		expect( s.fond ).toBe( 'rgba(0, 0, 0, 0)' );
		expect( s.filet ).toBe( 0 );
		expect( s.rayon ).toBe( 0 );
		expect( s.centre ).toBe( 'center' );
		// Le marquage provisoire survit au changement de forme (CLAUDE.md §5.5).
		await expect( figure ).toHaveAttribute( 'data-tfp-provisional', '1' );
		await expect( figure.locator( '[data-tfp-provisional-notice]' ) ).toBeVisible();
	} );

	test( 'pilier : la pastille est seule dans l’eyebrow, sans badge région', async ( { page } ) => {
		// La maquette du pilier pose la pastille SEULE au-dessus du H1. Le badge région du thème
		// partageait sa rangée (35 px) et faisait compter 2 colonnes contre 1 (relevé G23).
		await page.goto( '/nettoyage-professionnel/' );
		const eyebrow = page.locator( '.tfp-hero__eyebrow' ).first();
		await expect( eyebrow.locator( '.tfp-google-badge--inline' ) ).toHaveCount( 1 );
		await expect( eyebrow.locator( '.tfp-region-badge' ) ).toHaveCount( 0 );
	} );
} );
