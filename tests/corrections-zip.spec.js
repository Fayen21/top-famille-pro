// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Revue des trois ZIP du 25 octobre 2026 — contrôles des défauts corrigés (§3, §4, §5, §6).
 *
 * Le maillage géographique (§2) a son propre fichier : tests/maillage.spec.js.
 */

const texteMain = async ( page ) => ( await page.locator( 'main' ).innerText() ).replace( /\s+/g, ' ' );

test.describe( 'Tarifs et exemples (§3)', () => {
	test( 'carte tarifaire : « Tarif unique », plus de « À partir de »', async ( { page } ) => {
		for ( const route of [ '/prestations/bureaux/', '/prestations/ponctuel/', '/tarifs/' ] ) {
			await page.goto( route );
			const texte = await texteMain( page );
			expect( texte, route ).not.toMatch( /À partir de 2[47]/i );
		}
		await page.goto( '/prestations/bureaux/' );
		const carte = page.locator( '.tfp-price-card' ).first();
		await expect( carte ).toContainText( 'Tarif unique' );
		await expect( carte ).toContainText( 'En régulier comme en ponctuel' );
	} );

	test( 'ponctuel : une intervention unique, sans mensualité ni premier mois', async ( { page } ) => {
		await page.goto( '/prestations/ponctuel/' );
		const texte = await texteMain( page );
		expect( texte ).toContain( 'intervention unique de 7 h' );
		expect( texte ).toContain( '189 € HT de main-d’œuvre' );
		expect( texte ).not.toMatch( /\/mois|premier mois|Semaine type/ );
		expect( texte ).toContain( 'Déroulé d\'une intervention type' );
	} );

	test( 'Saint-Apollinaire : plus de « sans frais de déplacement »', async ( { page } ) => {
		await page.goto( '/zones-intervention/cote-dor/saint-apollinaire/' );
		expect( await texteMain( page ) ).not.toMatch( /sans frais de déplacement/i );
	} );

	test( 'titres de prestation en français complet', async ( { page } ) => {
		await page.goto( '/prestations/bureaux/' );
		const texte = await texteMain( page );
		expect( texte ).toContain( 'Un devis pour le nettoyage de vos bureaux ?' );
		expect( texte ).not.toMatch( /Un devis pour Bureaux|question sur Bureaux/ );
	} );
} );

test.describe( 'CTA par parcours (§4)', () => {
	test.use( { viewport: { width: 375, height: 812 } } );

	test( 'devis : pas de barre mobile, le CTA du header vise le formulaire déjà ouvert', async ( { page } ) => {
		await page.goto( '/demande-de-devis/' );
		await expect( page.locator( '.tfp-mobile-cta-bar' ) ).toHaveCount( 0 );
		await expect( page.locator( '.tfp-prefooter' ) ).toHaveCount( 0 );
		await expect( page.locator( '.tfp-header a.tfp-btn--copper' ) ).toHaveAttribute( 'href', '#tfp-formulaire-devis' );
		await expect( page.locator( '#tfp-formulaire-devis' ) ).toHaveCount( 1 );
	} );

	test( 'recrutement : la candidature est l’action principale', async ( { page } ) => {
		await page.goto( '/recrutement/' );
		const barre = page.locator( '.tfp-mobile-cta-bar' );
		await expect( barre.locator( '.tfp-btn--primary' ) ).toHaveText( 'Envoyer ma candidature' );
		await expect( barre.locator( '.tfp-btn--primary' ) ).toHaveAttribute( 'href', 'https://careers.werecruit.io/fr/top-famille' );
		await expect( page.locator( 'main a[href*="demande-de-devis"]' ) ).toHaveCount( 0 );
	} );

	test( 'contact et pages utilitaires : pas de bande commerciale dominante', async ( { page } ) => {
		await page.goto( '/contact/' );
		await expect( page.locator( '.tfp-mobile-cta-bar a[href*="demande-de-devis"]' ) ).toHaveCount( 0 );
		for ( const route of [ '/mentions-legales/', '/politique-de-confidentialite/', '/gestion-des-cookies/', '/plan-du-site/' ] ) {
			await page.goto( route );
			await expect( page.locator( '.tfp-mobile-cta-bar' ), route ).toHaveCount( 0 );
			await expect( page.locator( '.tfp-prefooter' ), route ).toHaveCount( 0 );
		}
	} );

	for ( const largeur of [ 320, 375 ] ) {
		test( `bouton d’appel à ${ largeur } px : libellé unique, numéro insécable, pas de débordement`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 800 } );
			for ( const route of [ '/', '/prestations/bureaux/', '/zones-intervention/cote-dor/dijon/', '/recrutement/', '/tarifs/' ] ) {
				await page.goto( route );
				const releve = await page.locator( 'main a.tfp-btn--appel' ).evaluateAll( ( els ) => els.filter( ( el ) => el.offsetParent ).map( ( el ) => {
					const r = el.getBoundingClientRect();
					const num = el.querySelector( '.tfp-btn__numero' );
					return {
						libelle: el.querySelector( '.tfp-btn__libelle' )?.textContent.trim(),
						nowrapBouton: getComputedStyle( el ).whiteSpace === 'nowrap',
						nowrapNumero: num ? getComputedStyle( num ).whiteSpace === 'nowrap' : true,
						deborde: r.right > document.documentElement.clientWidth + 0.5 || el.scrollWidth > el.clientWidth + 1,
					};
				} ) );
				expect( releve.length, route ).toBeGreaterThan( 0 );
				for ( const b of releve ) {
					expect( b.libelle, route ).toBe( 'Appeler Top-Famille Pro' );
					expect( b.nowrapBouton, route ).toBe( false );
					expect( b.nowrapNumero, route ).toBe( true );
					expect( b.deborde, route ).toBe( false );
				}
				expect( await page.locator( 'body' ).innerText(), route ).not.toMatch( /Appeler Audrey/ );
			}
		} );
	}
} );

test.describe( 'Header et tiroir mobile (§5)', () => {
	test( 'tiroir : clavier, chevron selon aria-expanded, Échap, retour du focus', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		await page.goto( '/' );
		const ouvrir = page.locator( '[data-tfp-mobile-open]' );
		await ouvrir.focus();
		await page.keyboard.press( 'Enter' );
		const panneau = page.locator( '#tfp-mobile-nav' );
		await expect( panneau ).toBeVisible();
		const zones = page.locator( '#tfp-mobile-btn-zones' );
		await expect( zones ).toHaveAttribute( 'aria-expanded', 'false' );
		// Plus de « ＋ » textuel : un chevron SVG dont l'orientation suit aria-expanded.
		await expect( zones ).not.toContainText( '＋' );
		await expect( zones.locator( 'svg.tfp-mobile-nav__chevron' ) ).toHaveCount( 1 );
		await zones.click();
		await expect( zones ).toHaveAttribute( 'aria-expanded', 'true' );
		const rotation = await zones.locator( 'svg' ).evaluate( ( el ) => getComputedStyle( el ).transform );
		expect( rotation ).not.toBe( 'none' );
		await expect( page.locator( '#' + await zones.getAttribute( 'aria-controls' ) ) ).toBeVisible();
		// Le piège de focus garde Tab dans le panneau.
		for ( let i = 0; i < 40; i++ ) await page.keyboard.press( 'Tab' );
		expect( await page.evaluate( () => !! document.activeElement.closest( '#tfp-mobile-nav' ) ) ).toBe( true );
		await page.keyboard.press( 'Escape' );
		await expect( panneau ).toBeHidden();
		await expect( ouvrir ).toBeFocused();
	} );

	test( 'tiroir : défile sur petite hauteur, se ferme après navigation', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 560 } );
		await page.goto( '/' );
		await page.locator( '[data-tfp-mobile-open]' ).click();
		const panneau = page.locator( '#tfp-mobile-nav' );
		const dims = await panneau.evaluate( ( el ) => ( { sh: el.scrollHeight, ch: el.clientHeight, oy: getComputedStyle( el ).overflowY } ) );
		expect( dims.oy ).toBe( 'auto' );
		expect( dims.sh ).toBeGreaterThan( dims.ch );
		// Le dernier élément du panneau est atteignable en défilant.
		const dernier = panneau.locator( 'a, button' ).last();
		await dernier.scrollIntoViewIfNeeded();
		await expect( dernier ).toBeInViewport();
		// Paysage.
		await page.setViewportSize( { width: 812, height: 375 } );
		await dernier.scrollIntoViewIfNeeded();
		await expect( dernier ).toBeInViewport();
		await page.setViewportSize( { width: 375, height: 560 } );
		const lienTarifs = panneau.locator( 'a[href$="/tarifs/"]' ).first();
		await lienTarifs.scrollIntoViewIfNeeded();
		await lienTarifs.click();
		await page.waitForURL( /\/tarifs\/$/ );
		await expect( page.locator( '#tfp-mobile-nav' ) ).toBeHidden();
	} );

	// Seuils du header : 819/820 (CTA du header et barre mobile), 1099/1100 (navigation complète),
	// 1219/1220 (marges réduites). De chaque côté : aucun débordement, une seule commande de menu.
	for ( const largeur of [ 819, 820, 1099, 1100, 1219, 1220 ] ) {
		test( `seuil ${ largeur } px : header sans débordement, navigation cohérente`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 800 } );
			await page.goto( '/zones-intervention/' );
			const etat = await page.evaluate( () => {
				const vis = ( s ) => { const el = document.querySelector( s ); return !! el && el.offsetParent !== null && getComputedStyle( el ).display !== 'none'; };
				const header = document.querySelector( '.tfp-header__inner' );
				const enfants = [ ...header.querySelectorAll( '*' ) ].filter( ( el ) => el.offsetParent !== null );
				return {
					nav: vis( '.tfp-nav' ),
					burger: vis( '[data-tfp-mobile-open]' ),
					debordePage: document.documentElement.scrollWidth > document.documentElement.clientWidth,
					debordeHeader: enfants.some( ( el ) => el.getBoundingClientRect().right > document.documentElement.clientWidth + 0.5 ),
					// Une seule rangée : la hauteur du bandeau principal reste celle de la maquette (89 px).
					hauteur: header.getBoundingClientRect().height,
				};
			} );
			expect( etat.debordePage ).toBe( false );
			expect( etat.debordeHeader ).toBe( false );
			expect( etat.nav ).toBe( largeur >= 1100 );
			expect( etat.burger ).toBe( largeur < 1100 );
			expect( etat.hauteur ).toBeLessThanOrEqual( 90 );
		} );
	}
} );

test.describe( 'Densité, footer, étapes, carte (§5)', () => {
	test( 'footer mobile : volets repliés, dépliables au clavier, liens légaux et téléphone hors volet', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		await page.goto( '/tarifs/' );
		const volets = page.locator( '.tfp-footer [data-tfp-volet]' );
		await expect( volets ).toHaveCount( 3 );
		for ( let i = 0; i < 3; i++ ) expect( await volets.nth( i ).evaluate( ( d ) => d.open ) ).toBe( false );
		await expect( page.locator( '.tfp-footer__col--brand a[href^="tel:"]' ) ).toBeVisible();
		for ( const lien of [ 'Mentions légales', 'Confidentialité', 'Cookies', 'Plan du site' ] ) {
			await expect( page.locator( '.tfp-footer__bottom nav a', { hasText: lien } ) ).toBeVisible();
		}
		const resume = volets.nth( 1 ).locator( 'summary' );
		await resume.focus();
		await page.keyboard.press( 'Enter' );
		expect( await volets.nth( 1 ).evaluate( ( d ) => d.open ) ).toBe( true );
		await expect( volets.nth( 1 ).locator( 'a', { hasText: 'Besançon' } ) ).toBeVisible();
	} );

	test( 'footer desktop et sans JavaScript : tout est déplié', async ( { browser } ) => {
		for ( const [ largeur, js ] of [ [ 1440, true ], [ 375, false ] ] ) {
			const ctx = await browser.newContext( { viewport: { width: largeur, height: 900 }, javaScriptEnabled: js } );
			const page = await ctx.newPage();
			await page.goto( '/tarifs/' );
			const ouverts = await page.locator( '.tfp-footer [data-tfp-volet]' ).evaluateAll( ( ds ) => ds.map( ( d ) => d.open ) );
			expect( ouverts, `${ largeur } px, JS ${ js }` ).toEqual( [ true, true, true ] );
			await ctx.close();
		}
	} );

	test( 'index des prestations : les six cartes juste sous le hero', async ( { page } ) => {
		for ( const [ largeur, max ] of [ [ 375, 1100 ], [ 1440, 800 ] ] ) {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/prestations/' );
			const cartes = page.locator( 'main a.tfp-card-tile[href*="/prestations/"]' );
			await expect( cartes ).toHaveCount( 6 );
			const y = await cartes.first().evaluate( ( el ) => el.getBoundingClientRect().top + scrollY );
			expect( y, `${ largeur } px` ).toBeLessThan( max );
		}
	} );

	test( 'étapes : rangées pleines sur tablette, pastille en ligne sur mobile', async ( { page } ) => {
		await page.setViewportSize( { width: 768, height: 900 } );
		await page.goto( '/' );
		const largeurs = await page.locator( '.tfp-etape' ).evaluateAll( ( els ) => els.map( ( e ) => Math.round( e.getBoundingClientRect().right ) ) );
		// Les deux rangées finissent au même bord droit.
		expect( Math.abs( largeurs[ 2 ] - largeurs[ 4 ] ) ).toBeLessThanOrEqual( 1 );
		await page.setViewportSize( { width: 375, height: 900 } );
		const [ num, titre ] = await Promise.all( [ '.tfp-etape__num', '.tfp-etape__titre' ].map( ( s ) => page.locator( s ).first().boundingBox() ) );
		expect( Math.abs( ( num.y + num.height / 2 ) - ( titre.y + titre.height / 2 ) ) ).toBeLessThan( 6 );
		expect( await page.locator( '.tfp-etape__titre' ).first().evaluate( ( e ) => getComputedStyle( e ).fontSize ) ).toBe( '18px' );
	} );

	test( 'carte : titre autorisé, légende sur deux lignes, couverture explicitée', async ( { page } ) => {
		await page.goto( '/' );
		await expect( page.locator( '#tfp-couverture-titre' ) ).toHaveText( 'Une entreprise régionale basée à Saint-Apollinaire' );
		await expect( page.locator( '.tfp-couverture__lede' ) ).toContainText( 'même tarif horaire' );
		await expect( page.locator( '.tfp-carte-bfc__legende p' ) ).toHaveCount( 2 );
		await expect( page.locator( '.tfp-carte-bfc__legende-repere' ) ).toContainText( 'Saint-Apollinaire' );
	} );

	test( 'photos de villes : aucun lieu affirmé dans le texte alternatif', async ( { page } ) => {
		for ( const route of [ '/zones-intervention/cote-dor/dijon/', '/zones-intervention/doubs/besancon/', '/zones-intervention/bourgogne-franche-comte/' ] ) {
			await page.goto( route );
			const alts = await page.locator( 'main img' ).evaluateAll( ( els ) => els.map( ( e ) => e.alt ) );
			for ( const alt of alts ) expect( alt, route ).not.toMatch( /^Locaux professionnels (à|en) / );
		}
	} );
} );

test.describe( 'Éditorial (§6)', () => {
	test( 'confidentialité : devis et contact décrits séparément, candidatures sur le site carrière', async ( { page } ) => {
		await page.goto( '/politique-de-confidentialite/' );
		await expect( page.locator( 'main h3', { hasText: 'Demande de devis' } ) ).toHaveCount( 1 );
		await expect( page.locator( 'main h3', { hasText: 'Formulaire de contact' } ) ).toHaveCount( 1 );
		expect( await texteMain( page ) ).toMatch( /téléphone ou adresse e-mail, au choix/ );
		await expect( page.locator( 'main a[href="https://careers.werecruit.io/fr/top-famille"]' ) ).toHaveCount( 1 );
	} );

	test( 'pilier : intitulé corrigé et passage dédoublé retiré', async ( { page } ) => {
		await page.goto( '/nettoyage-professionnel/' );
		const texte = await texteMain( page );
		expect( texte ).toContain( 'Ce sur quoi vous gardez la main' );
		expect( texte ).not.toContain( 'Un intervenant habituel est recherché. En cas d\'absence' );
	} );

	test( 'article coût : « Exemples de budgets »', async ( { page } ) => {
		await page.goto( '/conseils/cout-nettoyage-bureaux/' );
		await expect( page.locator( 'main h2', { hasText: /^Exemples de budgets$/ } ) ).toHaveCount( 1 );
	} );
} );
