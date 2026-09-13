// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Les six vignettes 56 px de la page pilier — verrou de géométrie (G27 §8).
 *
 * Les valeurs sont celles relevées sur la maquette Claude Design, largeur par largeur
 * (`docs/MESURES-VIGNETTES-PILIER.md`). Elles ne sont pas des préférences : chacune a été lue sur
 * le rendu du prototype.
 *
 * Le contrôle porte sur ce qu'un œil voit — dimensions, filet, fond, rayon, rembourrage,
 * typographie — et pas sur le « haut » des boîtes de texte : la maquette compose ses titres en
 * ligne et le site en bloc, ce qui décale les rectangles de 3 px sans rien déplacer à l'écran.
 * Une comparaison de rectangles aurait donc figé un faux écart, et fait échouer la suite à la
 * première correction honnête.
 */

const ATTENDU = {
	image: { largeur: 56, hauteur: 56, rayon: '10px' },
	carte: {
		filet: '1px',
		filetCouleur: 'rgb(30, 92, 158)',
		fond: 'rgb(23, 74, 129)',
		rayon: '14px',
		padding: '16px',
	},
	titre: { taille: 16.5, interligne: 26.7, graisse: '700' },
	description: { taille: 13, interligne: 21.1 },
	/** Largeur de carte relevée par largeur de fenêtre, et nombre de colonnes. */
	parLargeur: {
		375: { carte: 339, colonnes: 1 },
		768: { carte: 346.3, colonnes: 2 },
		1440: { carte: 284.5, colonnes: 4 },
	},
};

/** Relève les six cartes dont la miniature fait exactement 56 px. */
async function releverVignettes( page ) {
	return page.evaluate( () => {
		const px = ( v ) => Math.round( parseFloat( v ) * 10 ) / 10;
		return [ ...document.querySelectorAll( '.tfp-card-tile--thumb' ) ].map( ( c ) => {
			const im = c.querySelector( 'img' );
			const t = c.querySelector( '.tfp-card-tile__title' );
			const d = c.querySelector( '.tfp-card-tile__desc' );
			const sc = getComputedStyle( c );
			const si = getComputedStyle( im );
			const st = getComputedStyle( t );
			const sd = d ? getComputedStyle( d ) : null;
			const r = c.getBoundingClientRect();
			const ri = im.getBoundingClientRect();
			return {
				libelle: ( t.textContent || '' ).trim(),
				imgL: px( ri.width ), imgH: px( ri.height ), imgRayon: si.borderTopLeftRadius,
				carteL: px( r.width ),
				carteTop: Math.round( r.top + window.scrollY ), carteLeft: Math.round( r.left ),
				filet: sc.borderTopWidth, filetCouleur: sc.borderTopColor, fond: sc.backgroundColor,
				rayon: sc.borderTopLeftRadius, padding: sc.paddingTop,
				titreFS: px( st.fontSize ), titreLH: px( st.lineHeight ), titreFW: st.fontWeight,
				descFS: sd ? px( sd.fontSize ) : null, descLH: sd ? px( sd.lineHeight ) : null,
			};
		} );
	} );
}

test.describe( 'Vignettes 56 px de la page pilier', () => {
	for ( const largeur of [ 375, 768, 1440 ] ) {
		test( `${ largeur } px : géométrie relevée sur la maquette`, async ( { page } ) => {
			await page.setViewportSize( { width: largeur, height: 900 } );
			await page.goto( '/nettoyage-professionnel/' );
			await page.evaluate( async () => {
				for ( let y = 0; y < document.body.scrollHeight; y += 600 ) {
					window.scrollTo( 0, y );
					await new Promise( ( r ) => setTimeout( r, 30 ) );
				}
				window.scrollTo( 0, 0 );
			} );

			const cartes = await releverVignettes( page );
			expect( cartes, 'les six vignettes doivent être servies' ).toHaveLength( 6 );

			const attenduLargeur = ATTENDU.parLargeur[ largeur ];
			for ( const c of cartes ) {
				const ou = `${ largeur } px · « ${ c.libelle.slice( 0, 26 ) } »`;
				expect( c.imgL, `${ ou } : largeur d’image` ).toBe( ATTENDU.image.largeur );
				expect( c.imgH, `${ ou } : hauteur d’image` ).toBe( ATTENDU.image.hauteur );
				expect( c.imgRayon, `${ ou } : rayon d’image` ).toBe( ATTENDU.image.rayon );

				expect( c.filet, `${ ou } : épaisseur du filet` ).toBe( ATTENDU.carte.filet );
				expect(
					c.filetCouleur,
					`${ ou } : couleur du filet — la maquette pose un bleu, pas le filet pâle des cartes blanches`
				).toBe( ATTENDU.carte.filetCouleur );
				expect( c.fond, `${ ou } : fond` ).toBe( ATTENDU.carte.fond );
				expect( c.rayon, `${ ou } : rayon de carte` ).toBe( ATTENDU.carte.rayon );
				expect( c.padding, `${ ou } : rembourrage` ).toBe( ATTENDU.carte.padding );

				expect( c.titreFS, `${ ou } : taille du titre` ).toBeCloseTo( ATTENDU.titre.taille, 1 );
				expect( c.titreLH, `${ ou } : interligne du titre` ).toBeCloseTo( ATTENDU.titre.interligne, 1 );
				expect( c.titreFW, `${ ou } : graisse du titre` ).toBe( ATTENDU.titre.graisse );
				expect( c.descFS, `${ ou } : taille de la description` ).toBeCloseTo( ATTENDU.description.taille, 1 );
				expect( c.descLH, `${ ou } : interligne de la description` ).toBeCloseTo( ATTENDU.description.interligne, 1 );

				expect( c.carteL, `${ ou } : largeur de carte` ).toBeCloseTo( attenduLargeur.carte, 0 );
			}

			// Repli : une colonne à 375, deux à 768, quatre à 1440 — comme la maquette.
			const colonnes = new Set( cartes.map( ( c ) => c.carteLeft ) ).size;
			expect( colonnes, `${ largeur } px : nombre de colonnes` ).toBe( attenduLargeur.colonnes );

			// Écarts entre cartes voisines : 13 à 15 px dans la maquette, aux trois largeurs.
			const parRangee = new Map();
			for ( const c of cartes ) {
				if ( ! parRangee.has( c.carteTop ) ) parRangee.set( c.carteTop, [] );
				parRangee.get( c.carteTop ).push( c );
			}
			for ( const rangee of parRangee.values() ) {
				rangee.sort( ( a, b ) => a.carteLeft - b.carteLeft );
				for ( let i = 1; i < rangee.length; i++ ) {
					const ecart = rangee[ i ].carteLeft - ( rangee[ i - 1 ].carteLeft + rangee[ i - 1 ].carteL );
					expect( ecart, `${ largeur } px : écart horizontal entre deux cartes` ).toBeGreaterThanOrEqual( 12 );
					expect( ecart ).toBeLessThanOrEqual( 16 );
				}
			}
		} );
	}

	test( '375 px : la barre CTA mobile ne recouvre aucune vignette', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		await page.goto( '/nettoyage-professionnel/' );

		const barre = page.locator( '[data-tfp-mobile-cta], .tfp-mobile-cta-bar' ).first();
		if ( ( await barre.count() ) === 0 ) test.skip( true, 'pas de barre CTA mobile sur cette page' );

		// On se place sur la dernière vignette, là où le recouvrement se produirait.
		await page.locator( '.tfp-card-tile--thumb' ).last().scrollIntoViewIfNeeded();
		await page.waitForTimeout( 200 );

		const conflit = await page.evaluate( () => {
			const b = document.querySelector( '[data-tfp-mobile-cta], .tfp-mobile-cta-bar' );
			if ( ! b ) return null;
			const rb = b.getBoundingClientRect();
			if ( rb.height === 0 ) return null;
			return [ ...document.querySelectorAll( '.tfp-card-tile--thumb' ) ]
				.map( ( c ) => c.getBoundingClientRect() )
				.filter( ( r ) => r.bottom > rb.top && r.top < rb.bottom && r.height > 0 )
				.map( ( r ) => Math.round( r.bottom - rb.top ) );
		} );

		expect( conflit || [], 'la barre CTA recouvre une vignette' ).toEqual( [] );
	} );
} );
