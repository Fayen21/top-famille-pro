// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Passe commerciale du 10 novembre 2026 — premier écran, header, prestations, pages locales,
 * exemple de suivi, périmètre du tarif, ton factuel. Le formulaire de devis a ses tests dans
 * tests/functional/quote-form.spec.js.
 */

const LARGEURS = [ 320, 375, 768, 1024, 1440, 1920 ];

test.describe( 'Premier écran de l’accueil (§2)', () => {
	test( 'hiérarchie : H1, bénéfice, publics, tarif, devis, appel, réassurance', async ( { page } ) => {
		await page.goto( '/' );
		const hero = page.locator( '.tfp-hero' );
		await expect( hero.locator( 'h1' ) ).toHaveText( 'Nettoyage professionnel en Bourgogne-Franche-Comté' );
		await expect( hero.locator( '.tfp-hero__lede' ) ).toHaveText( 'Des locaux propres, des passages organisés selon vos horaires et un contact direct pour le suivi.' );
		await expect( hero.locator( '.tfp-hero__publics' ) ).toContainText( 'Bureaux · commerces · cabinets · copropriétés · locations meublées' );
		const offre = hero.locator( '.tfp-hero__offre' );
		await expect( offre.locator( '.tfp-hero__prix' ) ).toContainText( '27 € HT/h' );
		const ordre = await offre.evaluate( ( el ) => [ ...el.querySelectorAll( '.tfp-hero__prix, a.tfp-btn, .tfp-hero__microcopy' ) ].map( ( n ) => n.textContent.replace( /\s+/g, ' ' ).trim() ) );
		expect( ordre[ 1 ] ).toBe( 'Demander mon devis' );
		expect( ordre[ 2 ] ).toMatch( /^Appeler Top-Famille Pro/ );
		expect( ordre[ 3 ] ).toBe( 'Devis gratuit · Réponse sous 24 h · Sans engagement' );
		// Plus de pastille de prix posée sur la photo, plus de bandeau tarifaire juste dessous.
		await expect( page.locator( '.tfp-hero__price-tag' ) ).toHaveCount( 0 );
		await expect( page.locator( 'main .tfp-price-band' ) ).toHaveCount( 0 );
	} );

	test( 'à 375 × 812 : tarif et deux commandes visibles dans le premier écran', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		await page.goto( '/' );
		const barre = await page.locator( '.tfp-mobile-cta-bar' ).boundingBox();
		for ( const sel of [ '.tfp-hero__prix', '.tfp-hero__offre a.tfp-btn--primary', '.tfp-hero__offre a.tfp-btn--appel' ] ) {
			const b = await page.locator( sel ).first().boundingBox();
			expect( b.y + b.height, sel ).toBeLessThanOrEqual( barre.y );
		}
		// Les polices ne sont pas réduites pour tout faire tenir.
		expect( parseFloat( await page.locator( '.tfp-hero__lede' ).evaluate( ( el ) => getComputedStyle( el ).fontSize ) ) ).toBeGreaterThanOrEqual( 17 );
	} );

	test( 'image principale : locaux professionnels, chargée en priorité, sans lazy-loading', async ( { page } ) => {
		await page.goto( '/' );
		const img = page.locator( '.tfp-hero__media-main img' );
		await expect( img ).toHaveAttribute( 'fetchpriority', 'high' );
		expect( await img.getAttribute( 'loading' ) ).not.toBe( 'lazy' );
		// 13 novembre 2026 : photo d'accueil changée ; l'alt décrit la photo réelle.
		await expect( img ).toHaveAttribute( 'alt', /bureaux/i );
		await expect( img ).toHaveAttribute( 'alt', /photo d’illustration/ );
	} );
} );

test.describe( 'Header : descriptif métier (§8)', () => {
	for ( const largeur of LARGEURS ) {
		test( `à ${ largeur } px : lisible, sans débordement ni commande poussée hors champ`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 800 } );
			await page.goto( '/' );
			const etat = await page.evaluate( () => {
				const cw = document.documentElement.clientWidth;
				const vis = ( el ) => !! el && el.offsetParent !== null;
				const hi = document.querySelector( '.tfp-header__inner' );
				return {
					deborde: document.documentElement.scrollWidth > cw || [ ...hi.querySelectorAll( '*' ) ].some( ( e ) => vis( e ) && e.getBoundingClientRect().right > cw + 0.5 ),
					logo: vis( document.querySelector( '.tfp-logo__metier' ) ),
					barre: vis( document.querySelector( '.tfp-topbar__metier' ) ),
					taille: parseFloat( getComputedStyle( document.querySelector( '.tfp-logo__metier' ) ).fontSize ),
				};
			} );
			expect( etat.deborde ).toBe( false );
			// Un seul emplacement à la fois ; aucun sous 370 px.
			expect( etat.logo && etat.barre ).toBe( false );
			if ( largeur >= 1100 ) expect( etat.barre ).toBe( true );
			else if ( largeur >= 370 ) expect( etat.logo ).toBe( true );
			else expect( etat.logo || etat.barre ).toBe( false );
			expect( etat.taille ).toBeGreaterThanOrEqual( 11.5 );
		} );
	}
} );

test.describe( 'Prestations (§4, §5, §7)', () => {
	test( 'six prestations : sommaire, sections dans l’ordre utile, exemple de suivi, périmètre du tarif', async ( { page } ) => {
		for ( const slug of [ 'bureaux', 'commerces', 'cabinets', 'coproprietes', 'meubles', 'ponctuel' ] ) {
			await page.goto( `/prestations/${ slug }/` );
			const ancres = await page.locator( 'nav.tfp-sur-page a' ).evaluateAll( ( as ) => as.map( ( a ) => a.getAttribute( 'href' ) ) );
			for ( const a of ancres.filter( ( h ) => h.startsWith( '#' ) ) ) {
				await expect( page.locator( a ), `${ slug } ${ a }` ).toHaveCount( 1 );
			}
			const ids = await page.locator( 'main section[id]' ).evaluateAll( ( s ) => s.map( ( e ) => e.id ) );
			const rang = ( id ) => ids.indexOf( id );
			expect( rang( 'essentiel' ), slug ).toBeLessThan( rang( 'tarif' ) );
			expect( rang( 'tarif' ), slug ).toBeLessThan( rang( 'suivi' ) );
			expect( rang( 'suivi' ), slug ).toBeLessThan( rang( 'details' ) );
			const suivi = page.locator( '#suivi' );
			await expect( suivi.locator( '.tfp-eyebrow' ) ).toHaveText( 'Exemple de suivi' );
			await expect( suivi.locator( 'tbody tr' ) ).toHaveCount( 4 );
			// Jamais présenté comme le dossier d'un client : c'est un tableau type, et il le dit.
			await expect( suivi ).toContainText( 'Tableau type' );
			await expect( suivi ).not.toContainText( /exemple de présentation/i );
			await expect( page.locator( '#tarif .tfp-perimetre' ) ).toContainText( 'Fournis par le client' );
			// Le cahier de liaison n'est plus expliqué une seconde fois par un bloc « Suivi ».
			await expect( page.locator( '#details summary', { hasText: /^Suivi$/ } ) ).toHaveCount( 0 );
		}
	} );

	test( 'volets « Dans le détail » : contenu dans le HTML, ouverture au clavier, sans JavaScript', async ( { page, browser } ) => {
		await page.goto( '/prestations/bureaux/' );
		const volet = page.locator( '#details details.tfp-volet' ).first();
		await expect( volet ).not.toHaveAttribute( 'open', /.*/ );
		expect( ( await volet.locator( '.tfp-volet__corps' ).textContent() ).length ).toBeGreaterThan( 40 );
		await volet.locator( 'summary' ).focus();
		await page.keyboard.press( 'Enter' );
		await expect( volet ).toHaveAttribute( 'open', '' );
		await expect( volet.locator( '.tfp-volet__corps' ) ).toBeVisible();

		const ctx = await browser.newContext( { javaScriptEnabled: false } );
		const sansJs = await ctx.newPage();
		await sansJs.goto( '/prestations/bureaux/' );
		await sansJs.locator( '#details summary' ).first().click();
		await expect( sansJs.locator( '#details .tfp-volet__corps' ).first() ).toBeVisible();
		await ctx.close();
	} );

	test( 'ponctuel : périmètre sans frais de gestion mensuels', async ( { page } ) => {
		await page.goto( '/prestations/ponctuel/' );
		await expect( page.locator( '#tarif .tfp-perimetre' ) ).not.toContainText( '/mois' );
		await expect( page.locator( '#tarif' ) ).toContainText( '189 € HT de main-d’œuvre' );
	} );

	for ( const largeur of [ 375, 1440 ] ) {
		test( `exemple de suivi à ${ largeur } px : lisible, sans débordement`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/prestations/coproprietes/' );
			const deborde = await page.evaluate( () => {
				const t = document.querySelector( '#suivi table' );
				return t.getBoundingClientRect().right > document.documentElement.clientWidth + 0.5 || document.documentElement.scrollWidth > document.documentElement.clientWidth;
			} );
			expect( deborde ).toBe( false );
			if ( largeur < 640 ) {
				// Fiches : chaque cellule porte son libellé.
				const avant = await page.locator( '#suivi tbody td' ).first().evaluate( ( el ) => getComputedStyle( el, '::before' ).content );
				expect( avant ).toContain( 'Fréquence' );
			}
		} );
	}
} );

test.describe( 'Pages locales (§4, §7)', () => {
	test( 'Dijon : particularités ouvertes, chapitres génériques repliés, ton factuel', async ( { page } ) => {
		await page.goto( '/zones-intervention/cote-dor/dijon/' );
		const texte = await page.locator( 'main' ).evaluate( ( el ) => el.textContent.replace( /\s+/g, ' ' ) );
		expect( texte ).toContain( 'Basée à Saint-Apollinaire, notre entreprise organise les interventions à Dijon et dans son agglomération.' );
		expect( texte ).not.toMatch( /ne le prétendons pas|vitrine sans utilité|honnêtement/ );
		await expect( page.locator( 'main .tfp-zone-chapter h2', { hasText: 'Une entreprise implantée à Saint-Apollinaire' } ) ).toBeVisible();
		const replies = page.locator( 'main details.tfp-volet--chapitre' );
		expect( await replies.count() ).toBeGreaterThanOrEqual( 3 );
		await expect( page.locator( 'main details.tfp-volet--chapitre summary', { hasText: 'Clés, accès et présence sur site' } ) ).toHaveCount( 1 );
	} );

	test( 'aucune tournure défensive sur les 26 zones, les prestations et les pages', async ( { request } ) => {
		const routes = [ '/', '/nettoyage-professionnel/', '/zones-intervention/', '/zones-intervention/bourgogne-franche-comte/', '/pourquoi-nous/', '/a-propos/', '/notre-fonctionnement/' ];
		for ( const d of [ 'cote-dor', 'doubs', 'jura', 'nievre', 'haute-saone', 'saone-et-loire', 'yonne', 'territoire-de-belfort' ] ) routes.push( `/zones-intervention/${ d }/` );
		for ( const v of [ 'cote-dor/dijon', 'cote-dor/chenove', 'doubs/besancon', 'nievre/nevers', 'haute-saone/vesoul', 'yonne/auxerre' ] ) routes.push( `/zones-intervention/${ v }/` );
		for ( const p of [ 'bureaux', 'meubles', 'ponctuel' ] ) routes.push( `/prestations/${ p }/` );
		for ( const r of routes ) {
			const html = await ( await request.get( r ) ).text();
			expect( html, r ).not.toMatch( /nous ne (le )?prétendons pas|honnêtement|vitrine sans utilité|Nous ne garantissons pas/i );
		}
	} );
} );

test.describe( 'Pilier (§4)', () => {
	test( 'sommaire vers des ancres existantes, sections de méthode repliées', async ( { page } ) => {
		await page.goto( '/nettoyage-professionnel/' );
		const ancres = await page.locator( 'nav.tfp-sur-page a' ).evaluateAll( ( as ) => as.map( ( a ) => a.getAttribute( 'href' ) ) );
		expect( ancres.length ).toBeGreaterThanOrEqual( 8 );
		for ( const a of ancres ) await expect( page.locator( a ), a ).toHaveCount( 1 );
		await expect( page.locator( 'details.tfp-volet--section' ) ).toHaveCount( 3 );
		// Un titre par section repliée : celui du résumé, pas un second dans le corps.
		for ( const id of [ '#s-9', '#s-10', '#s-11' ] ) {
			const titre = await page.locator( `${ id } summary h2` ).innerText();
			await expect( page.locator( `${ id } .tfp-volet__corps h2`, { hasText: titre } ) ).toHaveCount( 0 );
		}
	} );
} );
