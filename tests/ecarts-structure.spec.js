// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Écarts de STRUCTURE validés par Emmanuel le 17 août 2026 — verrou de non-régression.
 *
 * ## Pourquoi ce fichier existe
 *
 * G26 a relevé deux endroits où le site s'écarte du prototype sans qu'aucune décision ne figure
 * au dépôt : la navigation principale porte une entrée de plus, et cinq pages institutionnelles
 * portent une rangée de commandes dans leur hero. Un écart sans trace de décision est
 * indiscernable d'un défaut — c'est exactement ce qui fait qu'une passe suivante le « corrige »
 * de bonne foi, et qu'une passe encore suivante le rétablit.
 *
 * Les deux ont été présentés avec leur coût mesuré, et Emmanuel a décidé de les **conserver** :
 *
 *  - les commandes de hero restent sur les cinq pages institutionnelles, au titre de CLAUDE.md §4
 *    (modification de structure autorisée si elle améliore objectivement la conversion, à
 *    condition d'être signalée).
 *
 * **L'entrée de menu n'est plus ici.** Elle y a été, au titre de la même décision du 17 août ; la
 * décision définitive du 19 août 2026 l'a renversée : l'entrée autonome « Nettoyage professionnel »
 * est supprimée, et le lien vers la page pilier vit désormais dans l'entrée « Prestations ». C'est
 * `tests/navigation.spec.js` qui tient ce contrôle — y compris la garantie que le lien SEO n'a pas
 * été perdu au passage.
 *
 * Ces tests sont donc l'inverse des autres : ils échouent si quelqu'un rend le site PLUS fidèle à
 * la maquette sur ces deux points précis. Une passe ultérieure qui les fait tomber doit revenir à
 * `docs/ECARTS-MAQUETTE-AUTORISES.md` §7 et §8, pas trancher à nouveau seule.
 *
 * Le badge région n'est PAS ici : il relevait du même constat sur sept routes et a été retiré en
 * G26 §9 — élément décoratif, lien déjà présent au menu et au pied, aucun effet de conversion à
 * préserver.
 */

/** Les cinq pages institutionnelles qui gardent leurs commandes de hero (écart n° 8). */
const PAGES_AVEC_COMMANDES = [
	'/a-propos/',
	'/pourquoi-nous/',
	'/notre-fonctionnement/',
	'/avis-clients/',
	'/prestations/',
];

test.describe( 'Écarts de structure validés le 17 août 2026', () => {
	for ( const route of PAGES_AVEC_COMMANDES ) {
		test( `${ route } garde ses deux commandes de hero`, async ( { page } ) => {
			await page.goto( route );
			/*
			 * La rangée du HERO, quel que soit le gabarit. `/a-propos/` compose son hero avec
			 * `.tfp-hero__content` ; les quatre autres emploient une simple bande de conteneur, sans
			 * cette classe. Le repère commun est la première rangée de commandes de la page, hors
			 * de celles que le composant de bandes statiques pose plus bas et qui portent, elles,
			 * `--statique`.
			 */
			const rangee = page.locator( '.tfp-action-row:not(.tfp-action-row--statique)' ).first();
			await expect( rangee, 'écart n° 8 validé : la rangée de commandes reste' ).toBeVisible();

			const commandes = rangee.locator( 'a.tfp-btn' );
			await expect( commandes ).toHaveCount( 2 );
			await expect( commandes.nth( 0 ) ).toHaveAttribute( 'href', /\/demande-de-devis\/$/ );
			await expect( commandes.nth( 1 ) ).toHaveAttribute( 'href', /^tel:/ );
		} );
	}

	test( 'le badge région reste absent des heros institutionnels (G26 §9, non renversé)', async ( { page } ) => {
		// Le pendant du test précédent : la décision porte sur les COMMANDES, pas sur le badge.
		// Sans ce contrôle, on pourrait croire que « garder les CTA » remet aussi le badge.
		for ( const route of [ ...PAGES_AVEC_COMMANDES, '/recrutement/', '/zones-intervention/' ] ) {
			await page.goto( route );
			await expect(
				page.locator( '.tfp-hero__eyebrow .tfp-region-badge' ),
				`${ route } : le badge région n’a pas sa place dans ce hero`
			).toHaveCount( 0 );
		}
	} );

	test( 'le badge région reste présent là où la maquette le pose', async ( { page } ) => {
		// Et l'inverse encore : le retrait de G26 §9 visait sept routes précises, pas toutes.
		for ( const route of [ '/tarifs/', '/prestations/bureaux/', '/zones-intervention/cote-dor/dijon/' ] ) {
			await page.goto( route );
			await expect(
				page.locator( '.tfp-hero__eyebrow .tfp-region-badge, .tfp-region-badge' ).first(),
				`${ route } : la maquette pose bien un badge région ici`
			).toBeVisible();
		}
	} );
} );
