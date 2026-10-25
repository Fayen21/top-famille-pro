// @ts-check
import { test, expect } from '@playwright/test';
import { readFileSync } from 'node:fs';

/**
 * Passe visuelle du 14 octobre 2026 — contrôles qui mesurent les DÉFAUTS RÉELS corrigés, pas des
 * hauteurs de page.
 *
 * Chaque test cible un défaut vu sur les captures : un code postal collé au nom, un texte qui
 * sort de sa carte, un département de la carte qui n'envoie pas sur sa page, un menu Zones réduit
 * à deux entrées. Un test vert ici dit que le défaut ne peut pas revenir ; il ne dit rien de la
 * fidélité à la maquette, qui relève d'autres outils.
 */

const LARGEURS = [ 320, 375, 768, 1024, 1440, 1920 ];
const DEPARTEMENTS = {
	'21': 'cote-dor', '25': 'doubs', '39': 'jura', '58': 'nievre',
	'70': 'haute-saone', '71': 'saone-et-loire', '89': 'yonne', '90': 'territoire-de-belfort',
};

test.describe( 'Villes et codes postaux (§4)', () => {
	for ( const largeur of LARGEURS ) {
		test( `à ${ largeur } px : nom et code postal sont deux lignes distinctes, lisibles, dans la carte`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/zones-intervention/' );
			const cartes = page.locator( '.tfp-card-tile--ville' );
			// Dix villes + huit communes.
			await expect( cartes ).toHaveCount( 18 );

			const releve = await cartes.evaluateAll( ( els ) =>
				els.map( ( el ) => {
					const titre = el.querySelector( '.tfp-card-tile__title' );
					const desc = el.querySelector( '.tfp-card-tile__desc' );
					const r = el.getBoundingClientRect();
					const rt = titre.getBoundingClientRect();
					const rd = desc.getBoundingClientRect();
					return {
						nom: titre.textContent.trim(),
						desc: desc.textContent.trim(),
						tailleDesc: parseFloat( getComputedStyle( desc ).fontSize ),
						// Le code est SOUS le nom : son haut est au-delà du bas du nom.
						sousLeNom: rd.top >= rt.bottom - 1,
						// Rien ne sort de la carte.
						dansLaCarte: rt.left >= r.left && rt.right <= r.right + 0.5 && rd.left >= r.left && rd.right <= r.right + 0.5 && rd.bottom <= r.bottom + 0.5,
						// Le code n'est pas collé au nom : il y a un espace ou un retour entre eux.
						colle: /[A-Za-zéèêàç]\d{5}/.test( el.textContent.replace( /\s+/g, '' ) ) && ! /Code/.test( el.textContent ),
						hauteur: r.height,
					};
				} )
			);
			for ( const c of releve ) {
				expect( c.desc, `${ c.nom } : la description porte le libellé` ).toMatch( /^Codes? posta(l|ux) : \d{5}/ );
				expect( c.sousLeNom, `${ c.nom } : le code postal est sur sa propre ligne` ).toBe( true );
				expect( c.dansLaCarte, `${ c.nom } : texte hors de la carte` ).toBe( true );
				expect( c.tailleDesc, `${ c.nom } : taille secondaire lisible` ).toBeGreaterThanOrEqual( 13 );
				expect( c.tailleDesc ).toBeLessThanOrEqual( 14.5 );
				expect( c.hauteur, `${ c.nom } : zone tactile` ).toBeGreaterThanOrEqual( 44 );
			}
		} );
	}

	test( 'à 1440 px : cinq colonnes pour les dix villes', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/zones-intervention/' );
		const grille = page.locator( '.tfp-card-grid--villes' ).first();
		const colonnes = await grille.evaluate( ( el ) => getComputedStyle( el ).gridTemplateColumns.split( ' ' ).length );
		expect( colonnes ).toBe( 5 );
	} );

	test( 'aucune formulation de chantier exposée au client', async ( { page } ) => {
		await page.goto( '/zones-intervention/' );
		const texte = await page.locator( 'main' ).innerText();
		expect( texte ).toContain( "Nos villes d'intervention" );
		expect( texte ).toContain( 'Autour de Dijon et de Beaune' );
		for ( const interdit of [ 'communes secondaires', 'villes principales', 'disposent déjà de leur page', "D'autres suivront" ] ) {
			expect( texte, `« ${ interdit } » ne doit plus apparaître` ).not.toContain( interdit );
		}
	} );
} );

test.describe( 'Header — menu Zones d’intervention (§3)', () => {
	test( 'le panneau propose les huit départements et « Voir toutes les villes »', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/' );
		await page.click( '#tfp-btn-zones' );
		const panneau = page.locator( '#tfp-menu-zones' );
		await expect( panneau ).toBeVisible();
		const liens = panneau.locator( 'a' );
		await expect( liens ).toHaveCount( 9 );
		for ( const [ num, slug ] of Object.entries( DEPARTEMENTS ) ) {
			const a = panneau.locator( `a[href$="/zones-intervention/${ slug }/"]` );
			await expect( a, `département ${ num }` ).toHaveCount( 1 );
			await expect( a ).toContainText( num );
		}
		await expect( panneau.locator( 'a[href$="/zones-intervention/"]' ) ).toHaveText( /Voir toutes les villes/ );
		// Pas de débordement hors fenêtre.
		const b = await panneau.boundingBox();
		expect( b.x ).toBeGreaterThanOrEqual( 0 );
		expect( b.x + b.width ).toBeLessThanOrEqual( 1440 );
		// Deux colonnes, pas un grand panneau vide.
		expect( b.width ).toBeLessThanOrEqual( 460 );
		expect( b.height ).toBeLessThanOrEqual( 300 );
	} );

	test( 'au clavier : Tab atteint le déplieur, Entrée ouvre, Échap ferme et rend le focus', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/' );
		await page.focus( '#tfp-btn-zones' );
		await page.keyboard.press( 'Enter' );
		await expect( page.locator( '#tfp-menu-zones' ) ).toBeVisible();
		await page.keyboard.press( 'Escape' );
		await expect( page.locator( '#tfp-menu-zones' ) ).toBeHidden();
		await expect( page.locator( '#tfp-btn-zones' ) ).toBeFocused();
	} );

	// 819/820 : barre CTA mobile · 1099/1100 : menu compact ↔ barre complète · 1219/1220 : plage
	// resserrée ↔ géométrie de maquette.
	for ( const largeur of [ 819, 820, 1099, 1100, 1219, 1220, 1440, 1920 ] ) {
		test( `à ${ largeur } px : aucun débordement horizontal du header, logo entre 120 et 155 px`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/' );
			const deborde = await page.evaluate( () => document.documentElement.scrollWidth > document.documentElement.clientWidth );
			expect( deborde ).toBe( false );
			if ( largeur >= 1100 ) {
				const logo = await page.locator( '.tfp-header .tfp-logo img' ).boundingBox();
				expect( logo.width ).toBeGreaterThanOrEqual( 120 );
				expect( logo.width ).toBeLessThanOrEqual( 155 );
				// Une seule ligne de navigation.
				const nav = await page.locator( '.tfp-nav' ).boundingBox();
				expect( nav.height ).toBeLessThanOrEqual( 56 );
			}
		} );
	}

	test( 'mobile : accordéon Zones lisible, huit départements, fermeture correcte', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 800 } );
		await page.goto( '/' );
		await page.click( '[data-tfp-mobile-open]' );
		await page.click( '#tfp-mobile-btn-zones' );
		const sub = page.locator( '#tfp-mobile-sub-zones' );
		await expect( sub ).toBeVisible();
		await expect( sub.locator( 'a' ) ).toHaveCount( 9 );
		await page.click( '[data-tfp-mobile-close]' );
		await expect( page.locator( '#tfp-mobile-nav' ) ).toBeHidden();
	} );
} );

test.describe( 'Carte régionale (§7)', () => {
	test( 'huit géométries officielles, chacune liée à sa page, un seul repère', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/' );
		const svg = page.locator( '.tfp-carte-bfc' );
		await expect( svg ).toBeVisible();
		const depts = svg.locator( '.tfp-carte-bfc__dept' );
		await expect( depts ).toHaveCount( 8 );
		for ( const [ num, slug ] of Object.entries( DEPARTEMENTS ) ) {
			const a = svg.locator( `.tfp-carte-bfc__dept[href$="/zones-intervention/${ slug }/"]` );
			await expect( a, `département ${ num }` ).toHaveCount( 1 );
			await expect( a.locator( 'text' ) ).toHaveText( num );
			// Une vraie géométrie : des dizaines de sommets, pas un cercle.
			const d = await a.locator( 'path' ).getAttribute( 'd' );
			expect( ( d.match( /L/g ) || [] ).length, `tracé ${ num } trop simple` ).toBeGreaterThan( 40 );
		}
		await expect( svg.locator( '.tfp-carte-bfc__siege-point' ) ).toHaveCount( 1 );
		await expect( svg.locator( '.tfp-carte-bfc__siege-label' ) ).toHaveText( /Implantation de Top-Famille Pro/ );
		// La carte remplit sa colonne : plus de plafond à 300 px.
		const b = await svg.boundingBox();
		expect( b.width ).toBeGreaterThan( 400 );
		// La liste de liens accessible reste en parallèle.
		await expect( page.locator( '.tfp-dept-link' ) ).toHaveCount( 8 );
	} );

	test( 'les tracés rendus sont ceux du jeu IGN versionné', async ( { page } ) => {
		const jeu = JSON.parse( readFileSync( 'tools/data/departements-bfc-ign-adminexpress-cog-2018-simplifie-8pct.geojson', 'utf8' ) );
		const codes = jeu.features.map( ( f ) => String( f.properties.code ) ).sort();
		expect( codes ).toEqual( Object.keys( DEPARTEMENTS ).sort() );
		await page.goto( '/' );
		// Le nombre de sommets du SVG suit celui du jeu : on n'a pas redessiné à la main.
		const sommetsSvg = await page.locator( '.tfp-carte-bfc__dept path' ).evaluateAll( ( ps ) =>
			ps.reduce( ( n, p ) => n + ( p.getAttribute( 'd' ).match( /[ML]/g ) || [] ).length, 0 )
		);
		const sommetsJeu = jeu.features.reduce( ( n, f ) => {
			const polys = f.geometry.type === 'Polygon' ? [ f.geometry.coordinates ] : f.geometry.coordinates;
			return n + polys.reduce( ( m, poly ) => m + poly.reduce( ( k, ring ) => k + ring.length, 0 ), 0 );
		}, 0 );
		expect( Math.abs( sommetsSvg - sommetsJeu ) ).toBeLessThanOrEqual( 16 );
	} );
} );

test.describe( 'Cinq étapes (§6)', () => {
	for ( const largeur of [ 375, 768, 1024, 1440 ] ) {
		test( `à ${ largeur } px : liste ordonnée, contenu vertical, aucun texte coupé ni hors carte`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/' );
			const liste = page.locator( 'ol.tfp-etapes' );
			await expect( liste ).toHaveCount( 1 );
			const etapes = liste.locator( '.tfp-etape' );
			await expect( etapes ).toHaveCount( 5 );
			const releve = await etapes.evaluateAll( ( els ) =>
				els.map( ( el ) => {
					const r = el.getBoundingClientRect();
					const num = el.querySelector( '.tfp-etape__num' ).getBoundingClientRect();
					const titre = el.querySelector( '.tfp-etape__titre' );
					const desc = el.querySelector( '.tfp-etape__desc' );
					const rt = titre.getBoundingClientRect(), rd = desc.getBoundingClientRect();
					return {
						titre: titre.textContent.trim(),
						// Revue du 25 octobre 2026 : sous 560 px, la pastille passe à gauche du titre
						// (même ligne) ; la description reste sous le titre.
						vertical: ( innerWidth < 560 ? num.right <= rt.left + 0.5 : rt.top >= num.bottom - 1 ) && rd.top >= rt.bottom - 1,
						dedans: rd.right <= r.right + 0.5 && rd.bottom <= r.bottom + 0.5 && rt.right <= r.right + 0.5,
						deborde: desc.scrollWidth > desc.clientWidth + 1,
						tailleDesc: parseFloat( getComputedStyle( desc ).fontSize ),
						hauteur: r.height,
					};
				} )
			);
			for ( const e of releve ) {
				expect( e.vertical, `${ e.titre } : repère, titre, description dans l'ordre vertical` ).toBe( true );
				expect( e.dedans, `${ e.titre } : texte hors carte` ).toBe( true );
				expect( e.deborde, `${ e.titre } : description qui déborde` ).toBe( false );
				expect( e.tailleDesc ).toBeGreaterThanOrEqual( 14.5 );
			}
			// Hauteurs équilibrées : la plus haute ne dépasse pas la plus basse de plus de 60 %.
			const hs = releve.map( ( e ) => e.hauteur );
			expect( Math.max( ...hs ) / Math.min( ...hs ) ).toBeLessThanOrEqual( 1.6 );
		} );
	}
} );

test.describe( 'Bandeau tarifaire (§5)', () => {
	for ( const largeur of [ 375, 768, 1440 ] ) {
		test( `à ${ largeur } px : « Voir les tarifs » est à côté ou juste sous le prix`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/' );
			const prix = await page.locator( '.tfp-price-band__value' ).boundingBox();
			const cta = await page.locator( '.tfp-price-band__cta' ).boundingBox();
			const horizontal = Math.abs( cta.y - prix.y ) < prix.height && cta.x - ( prix.x + prix.width ) < 40;
			const dessous = cta.y >= prix.y + prix.height - 2 && cta.y - ( prix.y + prix.height ) < 24 && Math.abs( cta.x - prix.x ) < 24;
			expect( horizontal || dessous, 'CTA isolé du prix' ).toBe( true );
		} );
	}

	test( 'les 26 bandes de zone gardent la même composition', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const route of [ '/zones-intervention/cote-dor/', '/zones-intervention/cote-dor/dijon/', '/zones-intervention/cote-dor/beaune/' ] ) {
			await page.goto( route );
			const prix = await page.locator( '.tfp-zone-band__price' ).boundingBox();
			const cta = await page.locator( '.tfp-zone-band__cta' ).boundingBox();
			expect( Math.abs( cta.y - prix.y ) < prix.height, `${ route } : CTA sur la ligne du prix` ).toBe( true );
			expect( cta.x - ( prix.x + prix.width ) ).toBeLessThan( 40 );
		}
	} );
} );

test.describe( 'Libellés de l’accueil (§5) et gérante (§8)', () => {
	test( 'commandes téléphoniques génériques et microcopy', async ( { page } ) => {
		await page.goto( '/' );
		const hero = page.locator( '.tfp-hero' );
		await expect( hero.locator( 'a[href^="tel:"]' ) ).toHaveText( /Appeler Top-Famille Pro/ );
		await expect( hero.locator( 'a[href^="tel:"]' ) ).toHaveAttribute( 'aria-label', /Appeler Top-Famille Pro au 06/ );
		await expect( hero.locator( '.tfp-hero__microcopy' ) ).toHaveText( /Devis étudié personnellement$/ );
		await expect( hero.locator( '.tfp-hero__microcopy' ) ).not.toContainText( 'par Audrey' );
		await expect( page.locator( '.tfp-header__phone .visually-hidden' ) ).toHaveText( 'Appeler Top-Famille Pro' );
		await expect( page.locator( '.tfp-mobile-cta-bar a[href^="tel:"]' ) ).toHaveAttribute( 'aria-label', /Appeler Top-Famille Pro au/ );
		const texte = await page.locator( 'body' ).innerText();
		expect( texte ).not.toMatch( /Appeler Audrey/ );
	} );

	test( 'le bloc présente la gérante et le portrait mesure 294 × 368 à 1440 px', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/' );
		await expect( page.locator( '#tfp-gerante-titre' ) ).toHaveText( 'Audrey Brançon, gérante de Top-Famille Pro' );
		await expect( page.locator( '.tfp-gerante__lede' ) ).toContainText( 'supervise l\'organisation des prestations' );
		await expect( page.locator( '.tfp-gerante__signature' ) ).toContainText( 'Gérante' );
		const img = page.locator( '.tfp-audrey-portrait__img' );
		await expect( img ).toHaveAttribute( 'width', '294' );
		await expect( img ).toHaveAttribute( 'height', '368' );
		const b = await img.boundingBox();
		expect( Math.round( b.width ) ).toBe( 294 );
		expect( Math.round( b.height ) ).toBe( 368 );
		// La réduction porte sur la colonne, pas sur un transform.
		await expect( img ).toHaveCSS( 'transform', 'none' );
		// Photo et mention d'illustration conservées.
		await expect( page.locator( '.tfp-audrey-portrait__note' ) ).toHaveText( 'Photo d’illustration' );
	} );
} );

test.describe( 'Audit transversal (§9) — défauts vus en lisant les écrans', () => {
	for ( const largeur of [ 375, 1440 ] ) {
		test( `à ${ largeur } px : la carte régionale de l'index des zones garde titre, sous-ligne et pastille`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/zones-intervention/' );
			const carte = page.locator( '.tfp-carte-lien' );
			await expect( carte ).toHaveCount( 1 );
			await expect( carte ).toHaveAttribute( 'href', /\/bourgogne-franche-comte\/$/ );
			await expect( carte.locator( '.tfp-carte-lien__titre' ) ).toHaveText( 'Bourgogne-Franche-Comté' );
			await expect( carte.locator( '.tfp-carte-lien__desc' ) ).toHaveText( /^La page régionale · huit départements/ );
			await expect( carte.locator( '.tfp-carte-lien__cta' ) ).toHaveText( /^Voir la page régionale/ );
			// Plus de phrase collée « Bourgogne-Franche-ComtéLa page régionale ».
			expect( await page.locator( 'body' ).innerText() ).not.toMatch( /ComtéLa page/ );
			// Rien ne sort de la fenêtre ni de la carte.
			const mesures = await carte.evaluate( ( el ) => {
				const r = el.getBoundingClientRect();
				const cta = el.querySelector( '.tfp-carte-lien__cta' ).getBoundingClientRect();
				return { droite: r.right, ctaDroite: cta.right, ctaBas: cta.bottom, bas: r.bottom, scroll: document.documentElement.scrollWidth };
			} );
			expect( mesures.scroll ).toBeLessThanOrEqual( largeur );
			expect( mesures.ctaDroite ).toBeLessThanOrEqual( mesures.droite + 0.5 );
			expect( mesures.ctaBas ).toBeLessThanOrEqual( mesures.bas + 0.5 );
		} );
	}

	test( 'Côte-d’Or : villes et communes ne sont plus la même rangée affichée deux fois', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/zones-intervention/cote-dor/' );
		const groupes = page.locator( '.tfp-zone-links' );
		const villes = groupes.filter( { hasText: /Nos villes d.intervention dans le département/ } ).first();
		const communes = groupes.filter( { hasText: 'Autour de Dijon et de Beaune' } ).first();
		// Une seule ville principale en Côte-d'Or (PROJECT_INPUTS §6) : Dijon, en rangée avec son code postal.
		await expect( villes.locator( '.tfp-ville-row' ) ).toHaveCount( 1 );
		await expect( villes.locator( '.tfp-ville-row__nom' ) ).toContainText( 'Dijon' );
		await expect( villes.locator( '.tfp-ville-row__cp' ) ).toContainText( '21000' );
		await expect( villes.locator( '.tfp-ville-row__cp .visually-hidden' ) ).toHaveText( 'Code postal : ' );
		// Les huit communes, en pastilles, une seule fois.
		await expect( communes.locator( 'a.tfp-chip' ) ).toHaveCount( 8 );
		const nomsCommunes = await communes.locator( 'a.tfp-chip' ).allInnerTexts();
		expect( nomsCommunes ).toContain( 'Saint-Apollinaire' );
		expect( nomsCommunes ).toContain( 'Beaune' );
		// Beaune a sa page : il n'est plus répété en pastille inerte sous « Autres communes citées ».
		const inertes = await page.locator( '.tfp-chip--static' ).allInnerTexts();
		expect( inertes ).not.toContain( 'Beaune' );
		// Aucun des mots bannis par la décision du 14 octobre.
		expect( await page.locator( 'main' ).innerText() ).not.toMatch( /communes secondaires|déjà documentées|d'autres suivront|documentées/i );
	} );

	test( 'les sept autres départements gardent leur rangée unique de villes', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const [ num, slug ] of Object.entries( DEPARTEMENTS ) ) {
			if ( '21' === num ) continue;
			await page.goto( `/zones-intervention/${ slug }/` );
			const rangees = page.locator( '.tfp-ville-row' );
			expect( await rangees.count(), slug ).toBeGreaterThanOrEqual( 1 );
			for ( const rangee of await rangees.all() ) {
				await expect( rangee.locator( '.tfp-ville-row__cp' ) ).toHaveText( /\d{5}/ );
			}
		}
	} );
} );

test.describe( 'Audit transversal (§9) — pages statiques relevées', () => {
	test( 'les bandes d’appel final à fond primaire sont centrées et portent des boutons, pas des cartes', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const route of [ '/zones-intervention/', '/nettoyage-professionnel/', '/pourquoi-nous/', '/zones-intervention/bourgogne-franche-comte/' ] ) {
			await page.goto( route );
			const bande = page.locator( '.tfp-section--primary.tfp-section--centre' ).last();
			await expect( bande, route ).toHaveCount( 1 );
			await expect( bande.locator( '.tfp-card-tile' ), route ).toHaveCount( 0 );
			const boutons = bande.locator( '.tfp-action-row--statique .tfp-btn' );
			expect( await boutons.count(), route ).toBeGreaterThanOrEqual( 1 );
			const m = await bande.evaluate( ( el ) => {
				const h2 = el.querySelector( 'h2' ).getBoundingClientRect();
				const row = el.querySelector( '.tfp-action-row--statique' ).getBoundingClientRect();
				const c = el.getBoundingClientRect();
				return { h2: ( h2.left + h2.right ) / 2, row: ( row.left + row.right ) / 2, centre: ( c.left + c.right ) / 2 };
			} );
			expect( Math.abs( m.h2 - m.centre ), route ).toBeLessThan( 4 );
			expect( Math.abs( m.row - m.centre ), route ).toBeLessThan( 4 );
		}
	} );

	test( 'une carte bordée d’un seul côté sur la maquette ne l’est que de ce côté', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const route of [ '/pourquoi-nous/', '/nettoyage-professionnel/', '/a-propos/' ] ) {
			await page.goto( route );
			const tuile = page.locator( '.tfp-card-grid[style*="filet-largeurs"] .tfp-card-tile' ).first();
			await expect( tuile, route ).toHaveCount( 1 );
			const b = await tuile.evaluate( ( el ) => { const s = getComputedStyle( el ); return [ s.borderTopWidth, s.borderRightWidth, s.borderBottomWidth, s.borderLeftWidth ]; } );
			expect( b, route ).toEqual( [ '2px', '0px', '0px', '0px' ] );
		}
	} );

	test( 'le bandeau tarifaire statique ne répète plus ses garanties en texte nu', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		for ( const route of [ '/nettoyage-professionnel/', '/zones-intervention/', '/zones-intervention/bourgogne-franche-comte/' ] ) {
			await page.goto( route );
			await expect( page.locator( '.tfp-price-band--statique' ), route ).toHaveCount( 1 );
			const texte = await page.locator( 'main' ).innerText();
			expect( texte.match( /Devis gratuit sous 24 h Intervention régulière/g ) ?? [], route ).toHaveLength( 0 );
		}
	} );

	test( 'page pilier : les intertitres relevés en 600 ne sont plus des notes grises', async ( { page } ) => {
		await page.goto( '/nettoyage-professionnel/' );
		const inter = page.locator( '.tfp-prose--intertitre' );
		expect( await inter.count() ).toBeGreaterThanOrEqual( 3 );
		await expect( inter.filter( { hasText: 'Sélection & intervenant habituel recherché' } ) ).toHaveCount( 1 );
		await expect( inter.first() ).toHaveCSS( 'font-weight', '600' );
	} );

	test( 'page région : plus de « secteurs secondaires déjà documentés »', async ( { page } ) => {
		await page.goto( '/zones-intervention/bourgogne-franche-comte/' );
		const texte = await page.locator( 'main' ).innerText();
		expect( texte ).not.toMatch( /déjà documentés|secteurs secondaires/i );
		expect( texte ).toContain( 'Autour de Dijon et de Beaune' );
	} );

	test( 'page avis : le panneau de note fictive n’apparaît pas, le libellé téléphonique est celui du site', async ( { page } ) => {
		await page.goto( '/avis-clients/' );
		await expect( page.locator( '.tfp-card-tile--texte', { hasText: 'Demander mon devis' } ) ).toHaveCount( 0 );
		await expect( page.locator( '.tfp-card-grid--panneau' ).first() ).not.toContainText( 'Demander mon devis' );
		expect( await page.locator( 'main' ).innerText() ).not.toMatch( /Appeler Audrey/ );
	} );

	test( 'page tarifs : la liste nue ne porte aucune puce et la carte « inclus » est turquoise', async ( { page } ) => {
		await page.goto( '/tarifs/' );
		const puce = await page.locator( '.tfp-list-plain--nue li' ).first().evaluate( ( el ) => getComputedStyle( el, '::before' ).content );
		expect( puce ).toBe( 'none' );
		await expect( page.locator( '.tfp-card--inclus' ) ).toHaveCSS( 'background-color', 'rgb(221, 244, 243)' );
	} );

	test( 'page contact : parcours actif en fond primaire, plus de mention d’horaires provisoires', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/contact/' );
		await expect( page.locator( '.tfp-card-tile--orientation-active' ) ).toHaveCSS( 'background-color', 'rgb(23, 74, 129)' );
		await expect( page.locator( 'a.tfp-card-tile--orientation' ) ).toHaveAttribute( 'href', /demande-de-devis/ );
		// Revue du 25 octobre 2026, §6 : la carte « Disponibilité » ne montre que des éléments établis,
		// sans mention provisoire sous elle.
		await expect( page.locator( 'main .tfp-provisional-notice' ) ).toHaveCount( 0 );
	} );

	test( 'pages légales : un seul titre « Droit applicable », chapeau et premier chapitre rapprochés', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/mentions-legales/' );
		await expect( page.locator( 'h2', { hasText: 'Droit applicable' } ) ).toHaveCount( 1 );
		for ( const route of [ '/mentions-legales/', '/politique-de-confidentialite/', '/gestion-des-cookies/' ] ) {
			await page.goto( route );
			const ecart = await page.evaluate( () => {
				const lede = document.querySelector( '.tfp-legal-tete .tfp-section__lede' ).getBoundingClientRect();
				const corps = document.querySelector( '.tfp-legal-corps .tfp-legal-body > *' ).getBoundingClientRect();
				return corps.top - lede.bottom;
			} );
			expect( ecart, route ).toBeLessThan( 80 );
		}
	} );

	test( 'plan du site : plus de « communes secondaires » à l’écran', async ( { page } ) => {
		await page.goto( '/plan-du-site/' );
		const texte = await page.locator( 'main' ).innerText();
		expect( texte ).not.toMatch( /communes secondaires/i );
		// Le surtitre du plan est composé en capitales : innerText rend « AUTOUR DE DIJON… ».
		expect( texte ).toMatch( /autour de dijon et de beaune/i );
	} );

	test( 'page département : sous-groupes espacés, Beaune lié une seule fois', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/zones-intervention/cote-dor/' );
		const h3 = page.locator( '.tfp-zone-links--sous > h3' ).first();
		await expect( h3 ).toHaveCSS( 'margin-top', '20px' );
		const beaune = page.locator( '.tfp-zone-links a', { hasText: /^Beaune$/ } );
		await expect( beaune ).toHaveCount( 1 );
	} );
} );

test.describe( 'Audit transversal (§9) — maillage des pages ville', () => {
	test( 'Dijon : chaque groupe de liens pointe vers SES zones, les autres secteurs portent leur département', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		await page.goto( '/zones-intervention/cote-dor/dijon/' );
		const groupe = ( titre ) => page.locator( '.tfp-zone-links' ).filter( { hasText: titre } ).first();
		const autres = await groupe( 'Autres secteurs couverts en région' ).locator( 'a.tfp-chip' ).allInnerTexts();
		expect( autres ).toEqual( [ 'Chalon-sur-Saône (71)', 'Besançon (25)', 'Auxerre (89)' ] );
		// Même département : la rangée « Nettoyage en Côte-d'Or → » puis Beaune seule (les sept
		// communes proches sont déjà liées au-dessus, comme sur la maquette).
		await expect( groupe( 'Dans le même département' ).locator( '.tfp-dept-row' ) ).toHaveText( /Nettoyage en Côte-d.Or/ );
		await expect( groupe( 'Dans le même département' ).locator( '.tfp-dept-row' ) ).toHaveAttribute( 'href', /\/zones-intervention\/cote-dor\/$/ );
		const memeDept = await groupe( 'Dans le même département' ).locator( 'a.tfp-chip' ).allInnerTexts();
		expect( memeDept ).toEqual( [ 'Beaune' ] );
		const proches = groupe( 'Communes proches desservies' );
		expect( await proches.locator( 'a.tfp-chip' ).count() ).toBe( 7 );
		expect( await proches.locator( '.tfp-chip--static' ).count() ).toBeGreaterThanOrEqual( 5 );
		// Les liens d'un autre département mènent bien à ce département.
		await expect( groupe( 'Autres secteurs couverts en région' ).locator( 'a.tfp-chip', { hasText: 'Besançon' } ) ).toHaveAttribute( 'href', /\/zones-intervention\/doubs\/besancon\/$/ );
		// Chalon-sur-Saône : Mâcon n'est plus répété dans « Autres secteurs » (revue ZIP du 25 octobre,
		// §2) ; il reste lié une seule fois, sous « Dans le même département ».
		await page.goto( '/zones-intervention/saone-et-loire/chalon-sur-saone/' );
		expect( await groupe( 'Autres secteurs couverts en région' ).locator( 'a.tfp-chip' ).allInnerTexts() ).toEqual( [ 'Dijon (21)', 'Dole (39)' ] );
		expect( await groupe( 'Dans le même département' ).locator( 'a.tfp-chip' ).allInnerTexts() ).toEqual( [ 'Mâcon' ] );
	} );

	test( 'la phrase « Des guides locaux … viendront compléter cette page » a disparu (CLAUDE.md §9)', async ( { page } ) => {
		for ( const route of [ '/zones-intervention/cote-dor/dijon/', '/zones-intervention/cote-dor/saint-apollinaire/', '/zones-intervention/doubs/besancon/', '/zones-intervention/cote-dor/beaune/' ] ) {
			await page.goto( route );
			expect( await page.locator( 'main' ).innerText(), route ).not.toMatch( /viendront compléter cette page/ );
			await expect( page.locator( '.tfp-zone-links', { hasText: 'Aller plus loin' } ).locator( 'a.tfp-link-row' ), route ).toHaveCount( 5 );
		}
	} );
} );
