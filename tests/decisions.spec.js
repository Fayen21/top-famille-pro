// @ts-check
import { test, expect } from '@playwright/test';
import { readFileSync } from 'node:fs';
import path from 'node:path';
import { ROUTES } from './data/routes.js';

/**
 * Cohérence entre le checkpoint structuré et le HTML réellement servi.
 *
 * ## Pourquoi ce fichier existe
 *
 * Trois décisions humaines ont été renversées d'une passe à l'autre — la note Google affichée puis
 * masquée, les huit communes désindexées puis indexées, l'entrée de menu conservée puis supprimée.
 * À chaque renversement, des phrases périmées survivaient dans `CLAUDE.md`, `STATUS.md` ou les
 * rapports, et une session suivante pouvait de bonne foi « corriger » le site en les appliquant.
 * C'est déjà arrivé.
 *
 * `docs/DECISIONS.json` est la forme vérifiable de ces décisions ; ce fichier la confronte au HTML
 * servi. Conséquence pratique : une consigne périmée réintroduite dans un document ne suffit plus
 * à changer le site — elle ferait échouer la suite, en nommant la décision qu'elle contredit.
 *
 * Et le contrôle porte sur le HTML servi, jamais sur les sources : c'est le seul état qu'un
 * visiteur voit, et le seul qu'un seed, un réglage ou un gabarit ne peuvent pas contourner
 * ensemble.
 */

const RACINE = path.resolve( path.dirname( new URL( import.meta.url ).pathname ), '..' );

/** @type {{version:number, decisions:Array<any>}} */
const CHECKPOINT = JSON.parse( readFileSync( path.join( RACINE, 'docs/DECISIONS.json' ), 'utf8' ) );

/** Retourne la décision par identifiant, en échouant si elle a disparu du checkpoint. */
function decision( id ) {
	const d = CHECKPOINT.decisions.find( ( x ) => x.id === id );
	if ( ! d ) {
		throw new Error(
			`décision « ${ id } » absente de docs/DECISIONS.json — le contrôle ne vérifie plus rien. ` +
				'La retirer du checkpoint exige une décision humaine, pas une suppression de test.'
		);
	}
	return d;
}

const TOUTES_ROUTES = ROUTES.map( ( r ) => r.path || r.url || r );

test.describe( 'Checkpoint structuré ↔ HTML servi', () => {
	test( 'le checkpoint est lisible et nomme les décisions attendues', () => {
		expect( CHECKPOINT.version ).toBeGreaterThanOrEqual( 1 );
		for ( const id of [
			'note-google-masquee',
			'communes-secondaires-indexees',
			'navigation-six-entrees',
			'cta-heros-institutionnels',
			'elements-provisoires',
		] ) {
			expect( decision( id ).regle, `décision ${ id } sans règle exploitable` ).toBeTruthy();
		}
	} );

	test( 'note Google — aucun des motifs interdits sur les 53 routes', async ( { request } ) => {
		const d = decision( 'note-google-masquee' );
		const motifs = d.regle.interdit_dans_le_html_servi.map( ( m ) => ( {
			nom: m.nom,
			re: new RegExp( m.motif ),
		} ) );

		const fautes = [];
		for ( const route of TOUTES_ROUTES ) {
			const html = await ( await request.get( route ) ).text();
			for ( const m of motifs ) {
				if ( m.re.test( html ) ) {
					const i = html.search( m.re );
					fautes.push( `${ route } → ${ m.nom } :: …${ html.slice( Math.max( 0, i - 50 ), i + 40 ).replace( /\s+/g, ' ' ) }…` );
				}
			}
		}
		expect(
			fautes,
			`décision « ${ d.titre } » (${ d.decide_le }) contredite par le HTML servi`
		).toEqual( [] );

		// Le contrôle ne serait pas éprouvant s'il ne balayait rien.
		expect( TOUTES_ROUTES.length ).toBeGreaterThanOrEqual( 53 );
		expect( motifs.length ).toBeGreaterThanOrEqual( 7 );
	} );

	test( 'communes secondaires — robots et sitemap conformes au checkpoint', async ( { request, page } ) => {
		const d = decision( 'communes-secondaires-indexees' );
		expect( d.regle.routes ).toHaveLength( 8 );

		const sitemap = await ( await request.get( '/wp-sitemap-posts-zone-1.xml' ) ).text();

		for ( const route of d.regle.routes ) {
			await page.goto( route );
			await expect(
				page.locator( 'meta[name="robots"]' ),
				`${ route } : robots contredit la décision du ${ d.decide_le }`
			).toHaveAttribute( 'content', d.regle.robots_attendu );

			if ( d.regle.present_au_sitemap ) {
				expect( sitemap, `${ route } absente du sitemap` ).toContain( route );
			}
		}

		// Et la cohérence avec l'autre source de vérité des tests : si `routes.js` repassait ces
		// huit routes en `noindex`, deux fichiers se contrediraient sans que rien ne le dise.
		for ( const route of d.regle.routes ) {
			const entree = ROUTES.find( ( r ) => ( r.path || r.url || r ) === route );
			if ( entree && entree.robots ) {
				expect(
					entree.robots,
					`tests/data/routes.js contredit docs/DECISIONS.json sur ${ route }`
				).toBe( d.regle.robots_attendu );
			}
		}
	} );

	test( 'navigation — entrées, lien pilier et hauteur conformes au checkpoint', async ( { page } ) => {
		const d = decision( 'navigation-six-entrees' );
		await page.goto( '/' );

		const entrees = page.locator( '.tfp-nav > *' );
		await expect( entrees ).toHaveCount( d.regle.entrees.length );

		const libelles = await entrees.evaluateAll( ( els ) =>
			els.map( ( e ) =>
				( e.textContent || '' ).replace( /Ouvrir le menu[\s\S]*/, '' ).replace( /[▾＋]/g, '' ).replace( /\s+/g, ' ' ).trim()
			)
		);
		expect( libelles ).toEqual( d.regle.entrees );

		if ( d.regle.entree_autonome_pilier_interdite ) {
			await expect(
				page.locator( `.tfp-nav > a[href$="${ d.regle.url_pilier }"]` ),
				'l’entrée autonome vers le pilier est interdite par la décision du 19 août 2026'
			).toHaveCount( 0 );
		}

		const parent = page.locator( '.tfp-nav__link--parent' ).first();
		await expect( parent ).toHaveText( d.regle.lien_pilier_porte_par );
		await expect( parent ).toHaveAttribute( 'href', new RegExp( `${ d.regle.url_pilier }$` ) );

		const hauteur = await page.evaluate(
			() => document.querySelector( '.tfp-header' ).getBoundingClientRect().height
		);
		expect( hauteur ).toBeLessThanOrEqual( d.regle.hauteur_entete_max_px );
	} );

	test( 'commandes de hero — conformes au checkpoint sur les cinq pages', async ( { page } ) => {
		const d = decision( 'cta-heros-institutionnels' );
		for ( const route of d.regle.routes ) {
			await page.goto( route );
			const rangee = page.locator( '.tfp-action-row:not(.tfp-action-row--statique)' ).first();
			await expect( rangee, `${ route } : rangée de commandes absente` ).toBeVisible();
			await expect( rangee.locator( 'a.tfp-btn' ) ).toHaveCount( d.regle.commandes_attendues );
		}
	} );

	test( 'les documents normatifs ne portent plus de consigne périmée', () => {
		/*
		 * Le dernier maillon, et le seul qui protège vraiment : un document qui redit l'ancienne
		 * règle finit par être appliqué. Ce contrôle ne relit donc pas les rapports datés — ils
		 * racontent ce qui était vrai, et portent une bannière — mais les fichiers de RÈGLES, ceux
		 * qu'une session ouvre pour savoir quoi faire.
		 */
		const NORMATIFS = [
			'CLAUDE.md',
			'PROJECT_INPUTS.md',
			'docs/INVENTAIRE-ROUTES.md',
			'docs/ECARTS-MAQUETTE-AUTORISES.md',
			'release/INFORMATIONS-MANQUANTES.md',
		];

		/**
		 * Formulations qui ordonnent l'ancien comportement. Une phrase n'est tolérée que si elle
		 * marque explicitement la consigne comme dépassée : citer une règle morte pour la nommer
		 * morte est utile, la citer sans le dire est ce qui la ressuscite. La liste des marqueurs
		 * est courte et fermée exprès — c'est la porte de sortie, pas une échappatoire.
		 */
		const PERIMEES = [
			{
				re: /(communes?|\b8 pages|huit pages)[^.\n]{0,120}restent?[^.\n]{0,40}`?noindex/i,
				quoi: 'communes secondaires en noindex',
				decision: 'communes-secondaires-indexees',
				temoin: 'Ces 8 pages restent noindex,follow tant qu’Audrey ne les a pas validées.',
			},
			{
				re: /note[^.\n]{0,60}(peut être affichée|est affichée|désormais affichée)/i,
				quoi: 'note Google présentée comme affichable',
				decision: 'note-google-masquee',
					temoin: 'La note Google 5,0/5 est confirmée et peut être affichée dans le hero.',
			},
			{
				re: /`?note_sans_source`?|Afficher sans la fiche/i,
				quoi: 'dérogation « Afficher sans la fiche », supprimée du code',
				decision: 'note-google-masquee',
					temoin: 'Cocher « Afficher sans la fiche » dans Réglages → Réassurance & avis.',
			},
			{
				re: /entrée[^.\n]{0,60}«?\s*Nettoyage professionnel\s*»?[^.\n]{0,40}(reste|conservée)/i,
				quoi: 'entrée de menu autonome présentée comme conservée',
				decision: 'navigation-six-entrees',
					temoin: 'L’entrée « Nettoyage professionnel » reste au menu principal.',
			},
		];

		/** Marqueurs qui rendent une citation d'ancienne règle inoffensive. */
		const MARQUEURS_DEPASSE = /périmée?|supprimée? du code|n['’]existe plus|a été supprimée|OBTENUE le|~~/i;

		const fautes = [];
		for ( const fichier of NORMATIFS ) {
			const texte = readFileSync( path.join( RACINE, fichier ), 'utf8' );
			for ( const ligne of texte.split( '\n' ) ) {
				if ( MARQUEURS_DEPASSE.test( ligne ) ) continue;
				for ( const p of PERIMEES ) {
					if ( p.re.test( ligne ) ) {
						fautes.push(
							`${ fichier } — ${ p.quoi } (contredit « ${ p.decision } ») :: ${ ligne.trim().slice( 0, 130 ) }`
						);
					}
				}
			}
		}
		expect( fautes, 'consignes périmées encore écrites comme des règles' ).toEqual( [] );

		/*
		 * Contrôle du contrôle. Un balayage qui ne trouve rien a deux causes possibles — le dépôt
		 * est propre, ou le motif ne mord plus — et rien ne les distingue de l'extérieur. Chaque
		 * motif porte donc sa propre phrase témoin, qu'il DOIT reconnaître.
		 */
		for ( const p of PERIMEES ) {
			expect(
				p.re.test( p.temoin ),
				`le motif « ${ p.quoi } » ne reconnaît plus sa propre phrase témoin : il ne protège plus`
			).toBe( true );
			expect(
				MARQUEURS_DEPASSE.test( p.temoin ),
				`la phrase témoin de « ${ p.quoi } » porte un marqueur de dépassement : elle ne teste rien`
			).toBe( false );
		}
	} );

	test( 'éléments provisoires — la photo reste une illustration, la citation reste marquée', async ( { page } ) => {
		const d = decision( 'elements-provisoires' );
		expect( d.regle.citation_audrey_validee_par_l_interessee ).toBe( false );

		await page.goto( '/a-propos/' );
		const provisoires = page.locator( '[data-tfp-provisional]' );
		await expect(
			provisoires,
			'les contenus provisoires doivent rester repérables d’une seule requête'
		).not.toHaveCount( 0 );

		if ( d.regle.photo_audrey_marquee_illustration ) {
			const mention = page.getByText( /illustration|provisoire/i ).first();
			await expect( mention, 'le portrait doit rester annoncé comme illustration' ).toBeVisible();
		}
	} );
} );
