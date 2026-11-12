// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Navigation principale — décision définitive du 19 août 2026.
 *
 * ## Ce qui a changé, et pourquoi ce fichier existe
 *
 * La barre portait **sept** entrées contre six dans la maquette : une entrée autonome
 * « Nettoyage professionnel » s'ajoutait aux six. Elle faisait replier la barre sur deux lignes à
 * 1440 px et ajoutait 22 px d'en-tête sur les 53 pages — un décalage qui se propageait à tous les
 * rapports de hauteur du relevé de base.
 *
 * L'entrée autonome est supprimée. Le lien vers la page pilier ne l'est pas : c'est la porte
 * d'entrée du site sur sa requête principale, et le perdre aurait été un arbitrage de
 * référencement déguisé en correction de fidélité. **L'entrée « Prestations » est ce lien.**
 *
 * Elle se compose donc de deux commandes, et c'est délibéré : un `<a>` qui navigue vers le pilier,
 * un `<button aria-expanded>` qui déplie les six prestations. Un seul élément ne peut pas exposer
 * honnêtement deux actions à un lecteur d'écran — soit il ment sur l'une, soit il en condamne une.
 *
 * Ces tests verrouillent les deux moitiés : la fidélité de la barre (six entrées, ordre, hauteur)
 * et l'accessibilité de l'entrée composite (clavier, tactile, `aria-expanded`, Échap).
 */

/** Ordre relevé sur la maquette Claude Design ; libellé « Zones d'intervention » par décision du
 *  14 octobre 2026 (la maquette abrégeait en « Zones »). */
const ENTREES = [ 'Prestations', 'Tarifs', "Zones d'intervention", 'Pourquoi nous', 'Avis', 'Conseils' ];

/** Les six prestations du sous-menu, dans l'ordre de la maquette. */
const PRESTATIONS = [
	'/prestations/bureaux/',
	'/prestations/commerces/',
	'/prestations/cabinets/',
	'/prestations/coproprietes/',
	'/prestations/meubles/',
	'/prestations/ponctuel/',
];

/** Hauteur d'en-tête relevée sur la maquette à 1440 px, topbar comprise. */
const HAUTEUR_MAQUETTE = 119;

test.describe( 'Navigation principale', () => {
	test( 'six entrées, dans l’ordre de la maquette', async ( { page } ) => {
		await page.goto( '/' );
		const entrees = page.locator( '.tfp-nav > *' );
		await expect( entrees ).toHaveCount( 6 );

		const libelles = await entrees.evaluateAll( ( els ) =>
			els.map( ( e ) =>
				( e.textContent || '' ).replace( /Ouvrir le menu[\s\S]*/, '' ).replace( /[▾＋]/g, '' ).replace( /\s+/g, ' ' ).trim()
			)
		);
		expect( libelles ).toEqual( ENTREES );
	} );

	test( 'l’entrée autonome « Nettoyage professionnel » a disparu', async ( { page } ) => {
		await page.goto( '/' );
		const autonome = page.locator( '.tfp-nav > a[href$="/nettoyage-professionnel/"]' );
		await expect(
			autonome,
			'l’entrée autonome est supprimée : le lien vit désormais dans « Prestations »'
		).toHaveCount( 0 );
	} );

	/*
	 * Décision du 13 novembre 2026 : cliquer sur « Prestations » ou « Zones d'intervention » OUVRE
	 * les choix, sans quitter la page. Le libellé garde son `href` (navigation sans JavaScript,
	 * lien lisible par les moteurs) et la page pilier devient la première entrée du panneau.
	 */
	test( '« Prestations » ouvre ses choix au clic ; la page pilier est la première entrée', async ( { page } ) => {
		await page.goto( '/' );
		const lien = page.locator( '.tfp-nav__link--parent' ).first();
		await expect( lien ).toHaveText( 'Prestations' );
		await expect( lien ).toHaveAttribute( 'href', /\/nettoyage-professionnel\/$/ );
		await expect( lien ).toHaveAttribute( 'role', 'button' );

		const url = page.url();
		await lien.click();
		expect( page.url(), 'le clic ne doit plus quitter la page' ).toBe( url );
		const menu = page.locator( '#tfp-menu-prestations' );
		await expect( menu ).toBeVisible();
		await expect( lien ).toHaveAttribute( 'aria-expanded', 'true' );

		// La page pilier reste accessible, et le lien fonctionne réellement.
		await menu.locator( 'a' ).first().click();
		await expect( page ).toHaveURL( /\/nettoyage-professionnel\/$/ );
		await expect( page.locator( 'h1' ) ).toBeVisible();
	} );

	test( '« Zones d’intervention » ouvre ses choix au clic, un second clic referme', async ( { page } ) => {
		await page.goto( '/' );
		const lien = page.locator( '.tfp-nav__link--parent' ).nth( 1 );
		const url = page.url();
		await lien.click();
		expect( page.url() ).toBe( url );
		await expect( page.locator( '#tfp-menu-zones' ) ).toBeVisible();
		await expect( page.locator( '#tfp-menu-prestations' ) ).toBeHidden();
		await lien.click();
		await expect( page.locator( '#tfp-menu-zones' ) ).toBeHidden();
	} );

	test( 'sans JavaScript, « Prestations » reste un lien vers la page pilier', async ( { browser } ) => {
		const contexte = await browser.newContext( { javaScriptEnabled: false } );
		const page = await contexte.newPage();
		await page.goto( '/' );
		await page.locator( '.tfp-nav__link--parent' ).first().click();
		await expect( page ).toHaveURL( /\/nettoyage-professionnel\/$/ );
		await contexte.close();
	} );

	test( 'le libellé déplie les six prestations, au clavier', async ( { page } ) => {
		await page.goto( '/' );
		const libelle = page.locator( '.tfp-nav__link--parent' ).first();
		const menu = page.locator( '#tfp-menu-prestations' );

		await expect( libelle ).toHaveAttribute( 'aria-expanded', 'false' );
		await expect( menu ).toBeHidden();

		await libelle.focus();
		await page.keyboard.press( 'Enter' );
		await expect( libelle ).toHaveAttribute( 'aria-expanded', 'true' );
		await expect( menu ).toBeVisible();

		const liens = menu.locator( 'a' );
		// La page pilier, les six prestations, puis le renvoi vers l'index.
		await expect( liens ).toHaveCount( PRESTATIONS.length + 2 );
		const hrefs = await liens.evaluateAll( ( els ) => els.map( ( a ) => new URL( a.href ).pathname ) );
		expect( hrefs[ 0 ] ).toBe( '/nettoyage-professionnel/' );
		expect( hrefs.slice( 1, 7 ) ).toEqual( PRESTATIONS );
		expect( hrefs[ 7 ] ).toBe( '/prestations/' );

		// Échap referme et rend le focus au libellé : sans cela, le clavier reste dans le vide.
		await page.keyboard.press( 'Escape' );
		await expect( libelle ).toHaveAttribute( 'aria-expanded', 'false' );
		await expect( menu ).toBeHidden();
		await expect( libelle ).toBeFocused();
	} );

	test( 'une seule commande par menu : le chevron sort de l’ordre de tabulation', async ( { page } ) => {
		await page.goto( '/' );
		for ( const id of [ '#tfp-btn-prestations', '#tfp-btn-zones' ] ) {
			await expect( page.locator( id ) ).toHaveAttribute( 'tabindex', '-1' );
			await expect( page.locator( id ) ).toHaveAttribute( 'aria-hidden', 'true' );
		}
		await page.locator( '.tfp-nav__link--parent' ).first().focus();
		await page.keyboard.press( 'Tab' );
		await expect( page.locator( '#tfp-btn-prestations' ) ).not.toBeFocused();
	} );

	test( 'les cibles tactiles de l’entrée composite tiennent la main', async ( { page } ) => {
		await page.goto( '/' );
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const sel of [ '.tfp-nav__link--parent', '#tfp-btn-prestations', '#tfp-btn-zones' ] ) {
			const box = await page.locator( sel ).first().boundingBox();
			expect( box, `${ sel } introuvable` ).not.toBeNull();
			expect( box.height, `${ sel } : hauteur de cible` ).toBeGreaterThanOrEqual( 24 );
			expect( box.width, `${ sel } : largeur de cible` ).toBeGreaterThanOrEqual( 24 );
		}
	} );

	test( 'l’en-tête retrouve la hauteur de la maquette, à toutes les largeurs', async ( { page } ) => {
		/*
		 * La barre ne doit plus replier, et l'en-tête ne doit plus dépasser la maquette. Le
		 * contrôle est joué avec et sans défilement : l'en-tête est collant et change de classe au
		 * défilement, ce qui est exactement le moment où une hauteur se met à varier sans qu'on la
		 * mesure.
		 */
		for ( const largeur of [ 320, 375, 768, 1024, 1440, 1920 ] ) {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/' );

			for ( const y of [ 0, 600 ] ) {
				await page.evaluate( ( py ) => window.scrollTo( 0, py ), y );
				await page.waitForTimeout( 120 );

				const m = await page.evaluate( () => {
					const h = document.querySelector( '.tfp-header' );
					const nav = document.querySelector( '.tfp-nav' );
					const enfants = nav ? [ ...nav.children ] : [];
					const lignes = new Set( enfants.map( ( e ) => Math.round( e.getBoundingClientRect().top ) ) );
					return {
						header: h.getBoundingClientRect().height,
						lignes: enfants.length ? lignes.size : 1,
					};
				} );

				expect(
					m.lignes,
					`${ largeur } px (défilement ${ y }) : la barre se replie sur ${ m.lignes } lignes`
				).toBe( 1 );
				expect(
					m.header,
					`${ largeur } px (défilement ${ y }) : en-tête de ${ Math.round( m.header ) } px`
				).toBeLessThanOrEqual( HAUTEUR_MAQUETTE + 2 );
			}
		}
	} );

	test( 'le panneau mobile garde le lien parent ET le déplieur', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		await page.goto( '/' );
		await page.locator( '[data-tfp-mobile-open]' ).click();

		const rangee = page.locator( '.tfp-mobile-nav__row' ).first();
		await expect( rangee.locator( 'a' ) ).toHaveAttribute( 'href', /\/nettoyage-professionnel\/$/ );

		const bouton = rangee.locator( 'button' );
		await expect( bouton ).toHaveAttribute( 'aria-expanded', 'false' );
		await bouton.click();
		await expect( bouton ).toHaveAttribute( 'aria-expanded', 'true' );
		await expect( page.locator( '#tfp-mobile-sub-prestations' ) ).toBeVisible();

		// Le panneau mobile reprend les six entrées, dans le même ordre.
		const libelles = await page
			.locator( '.tfp-mobile-nav__list > .tfp-mobile-nav__row > a, .tfp-mobile-nav__list > a' )
			.allInnerTexts();
		expect( libelles.map( ( t ) => t.trim() ) ).toEqual( ENTREES );
	} );
} );
