// @ts-check
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

/**
 * « Le cas échéant » — une réserve par bloc, pas quatre (consigne du 18 août 2026).
 *
 * ## Pourquoi ce fichier existe
 *
 * La bande « Trois exemples de budgets » de `/tarifs/` portait la même réserve quatre fois : dans
 * son chapeau, puis dans les trois intitulés « Premier mois, mise en place le cas échéant ». Une
 * réserve répétée à ce point ne se lit plus — elle devient décorative, ce qui est le contraire de
 * ce qu'une condition contractuelle doit être. L'accueil, la page pilier et la page région la
 * posaient deux fois dans une seule phrase.
 *
 * **Aucune condition n'a été retirée** : c'est la réserve qui est mutualisée. Le contrôle porte
 * donc sur les deux faces du problème — pas de répétition dans un bloc, et pas de disparition des
 * conditions elles-mêmes.
 *
 * Voir `docs/CONDITIONS-TARIFAIRES.md` pour les 30 occurrences restantes et leur justification.
 */

/** Le texte servi d'une page, sans les blocs de données structurées. */
async function texteVisible( page ) {
	return ( await page.locator( 'body' ).innerText() ).replace( /\s+/g, ' ' );
}

test.describe( 'Conditions tarifaires — une réserve par bloc', () => {
	for ( const route of ROUTES ) {
		const chemin = route.path || route.url || route;
		test( `${ chemin } : aucune section ne répète « le cas échéant »`, async ( { page } ) => {
			await page.goto( chemin );
			const sections = await page.locator( 'main section, main .tfp-container' ).allInnerTexts();
			for ( const s of sections ) {
				const n = ( s.match( /le cas échéant/g ) || [] ).length;
				expect(
					n,
					`${ chemin } : « le cas échéant » ${ n } fois dans un même bloc — ` +
						`« ${ s.replace( /\s+/g, ' ' ).slice( 0, 120 ) }… »`
				).toBeLessThanOrEqual( 1 );
			}
		} );
	}

	test( '/tarifs/ : la note unique est visible, et rattachée au tableau', async ( { page } ) => {
		await page.goto( '/tarifs/' );

		const note = page.locator( '#tfp-tarifs-conditions' );
		await expect( note, 'la note doit être VISIBLE, pas réservée aux lecteurs d’écran' ).toBeVisible();
		await expect( note ).toHaveText(
			"Ces frais et majorations s'appliquent uniquement lorsqu'ils sont prévus et indiqués au devis."
		);

		// Rattachée au tableau : sinon elle est lue en fin de page, détachée de ce qu'elle qualifie.
		const grille = page.locator( '[aria-describedby="tfp-tarifs-conditions"]' );
		await expect( grille ).toHaveCount( 1 );

		// Les trois intitulés ne portent plus la réserve…
		const intitules = page.locator( '.tfp-budget-card__detail li' );
		const textes = await intitules.allInnerTexts();
		expect( textes.filter( ( t ) => t.includes( 'le cas échéant' ) ) ).toEqual( [] );
		// … mais nomment toujours ce qu'ils facturent.
		expect( textes.filter( ( t ) => /mise en place/i.test( t ) ).length ).toBe( 3 );
	} );

	test( 'aucune condition contractuelle n’a disparu', async ( { page } ) => {
		/*
		 * Le pendant du test précédent. Alléger une formulation est facile ; le risque est
		 * d'emporter la condition avec la réserve. Ces trois-là sont contractuelles et doivent
		 * rester énoncées là où la maquette les pose.
		 */
		await page.goto( '/nettoyage-professionnel/' );
		const pilier = await texteVisible( page );
		expect( pilier, 'majoration dimanche / jours fériés / nuit' ).toMatch(
			/majoration de 10 %[^.]*dimanche[^.]*jours fériés[^.]*nuit/i
		);
		expect( pilier, 'indemnités kilométriques' ).toContain( '0,35 € HT/km' );
		expect( pilier, 'frais de mise en place' ).toMatch( /50 € HT de frais de mise en place/ );
		expect( pilier, 'renvoi au devis' ).toMatch( /au devis/ );

		await page.goto( '/zones-intervention/bourgogne-franche-comte/' );
		const region = await texteVisible( page );
		expect( region, 'indemnités kilométriques sur la page région' ).toContain( '0,35 € HT/km' );
		expect( region, 'frais de mise en place sur la page région' ).toMatch(
			/50 € HT de frais de mise en place/
		);

		await page.goto( '/' );
		const accueil = await texteVisible( page );
		expect( accueil, 'frais de gestion sur l’accueil' ).toMatch( /9 € HT\/mois de gestion/ );
		expect( accueil, 'frais de mise en place sur l’accueil' ).toMatch(
			/50 € HT de frais de mise en place/
		);
		expect( accueil, 'la réserve reste énoncée, une fois' ).toMatch(
			/lorsqu['’]ils s['’]appliquent|si prévu et indiqué au devis/
		);
	} );
} );
