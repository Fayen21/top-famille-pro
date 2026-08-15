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

test.describe( 'G23 · prestations-accueil-segmentees — carte segmentée claire, pas quatre cartes marine', () => {
	test( 'accueil : les quatre tuiles secondaires forment une carte segmentée claire', async ( { page } ) => {
		// Maquette : UNE carte 1180×123 — grille auto-fit base 220, gap 1px sur fond #DCE7EB qui
		// dessine les séparations, rayon 16, overflow hidden ; cellules blanches 20/22, intitulé
		// 17 px/700, description 13,5 px. Le thème rendait quatre cartes marine détachées.
		await page.goto( '/' );
		const grille = page.locator( '.tfp-grid--divided' ).first();
		await expect( grille ).toBeVisible();
		const g = await grille.evaluate( ( el ) => {
			const c = getComputedStyle( el );
			return { gap: c.gap, rayon: parseFloat( c.borderTopLeftRadius ), debord: c.overflow };
		} );
		expect( g.gap ).toBe( '1px' );
		expect( g.rayon ).toBe( 16 );
		expect( g.debord ).toBe( 'hidden' );

		const tuile = grille.locator( '.tfp-service-tile' ).first();
		const t = await tuile.evaluate( ( el ) => {
			const c = getComputedStyle( el );
			const titre = getComputedStyle( el.querySelector( '.tfp-service-tile__title' ) );
			const desc = getComputedStyle( el.querySelector( '.tfp-service-tile__desc' ) );
			return {
				fond: c.backgroundColor,
				rayon: parseFloat( c.borderTopLeftRadius ) || 0,
				pad: c.padding,
				titreTaille: titre.fontSize,
				titreGraisse: titre.fontWeight,
				descTaille: desc.fontSize,
			};
		} );
		expect( t.fond ).toBe( 'rgb(255, 255, 255)' );
		expect( t.rayon ).toBe( 0 );
		expect( t.pad ).toBe( '20px 22px' );
		expect( t.titreTaille ).toBe( '17px' );
		expect( t.titreGraisse ).toBe( '700' );
		expect( t.descTaille ).toBe( '13.5px' );
	} );

	test( 'zone : les tuiles de prestation restent des cartes marine (non-régression)', async ( { page } ) => {
		await page.goto( '/zones-intervention/cote-dor/dijon/' );
		const tuile = page.locator( '.tfp-service-tiles .tfp-service-tile' ).first();
		await expect( tuile ).toBeVisible();
		const t = await tuile.evaluate( ( el ) => {
			const c = getComputedStyle( el );
			return { fond: c.backgroundColor, rayon: parseFloat( c.borderTopLeftRadius ) || 0 };
		} );
		expect( t.rayon ).toBe( 14 );
		expect( t.fond ).not.toBe( 'rgb(255, 255, 255)' );
	} );
} );
