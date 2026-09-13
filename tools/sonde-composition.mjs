#!/usr/bin/env node
/**
 * Sonde de COMPOSITION d'une route — G26.
 *
 * Les sondes existantes comparent des hauteurs de bandes ou des empreintes de composants ; aucune
 * ne répond à la question posée par le refus du 17 août 2026 sur /a-propos/ et /recrutement/ :
 * *dans quel ordre les bandes se suivent-elles, et à l'intérieur d'une bande, qu'est-ce qui est à
 * gauche et qu'est-ce qui est à droite ?* Un écart de composition — image à droite au lieu de la
 * gauche, image après le texte en mobile, citation dans une colonne au lieu d'une bande pleine
 * largeur — ne change ni la hauteur totale ni le texte : il est invisible à toutes les autres
 * sondes.
 *
 * Cet outil relève, pour chaque bande de premier niveau, dans l'ordre du flux : son titre, ses
 * médias avec leur position horizontale relative (gauche / centre / droite) et leur rang vertical,
 * la largeur du bloc de texte rapportée à celle de la fenêtre, et l'ordre visuel réel des enfants
 * (par position à l'écran, pas par ordre du DOM — `order` et `flex-direction` peuvent les
 * dissocier, et c'est précisément ce qu'il faut voir en mobile).
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/sonde-composition.mjs /a-propos/ '#/a-propos'
 */
import { chromium } from '@playwright/test';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const LARGEURS = [ 375, 1440 ];

const routeWp = process.argv[ 2 ];
const routeRef = process.argv[ 3 ];
if ( ! routeWp || ! routeRef ) {
	console.error( "Usage : node tools/sonde-composition.mjs /a-propos/ '#/a-propos'" );
	process.exit( 1 );
}

/** Relevé exécuté dans la page — identique des deux côtés, aucune classe de thème n'y intervient. */
const RELEVE = () => {
	const txt = ( el ) => ( el ? ( el.textContent || '' ).replace( /\s+/g, ' ' ).trim() : '' );

	/* Racine de contenu : le plus profond ancêtre commun des <section>/bandes de premier niveau. */
	let racine = document.body;
	for ( let i = 0; i < 12; i++ ) {
		const enfants = [ ...racine.children ].filter( ( e ) => e.getBoundingClientRect().height > 40 );
		if ( enfants.length === 1 ) {
			racine = enfants[ 0 ];
			continue;
		}
		break;
	}

	const bandes = [ ...racine.children ].filter( ( e ) => {
		const r = e.getBoundingClientRect();
		return r.height > 60 && r.width > 100;
	} );

	const W = window.innerWidth;
	const zone = ( r ) => {
		const centre = ( r.left + r.right ) / 2;
		if ( centre < W * 0.42 ) return 'gauche';
		if ( centre > W * 0.58 ) return 'droite';
		return 'centre';
	};

	return bandes.map( ( bande, index ) => {
		const rb = bande.getBoundingClientRect();
		const titre = bande.querySelector( 'h1, h2, h3' );

		const medias = [ ...bande.querySelectorAll( 'img, picture, svg' ) ]
			.filter( ( m ) => {
				const r = m.getBoundingClientRect();
				return r.width > 60 && r.height > 60;
			} )
			.map( ( m ) => {
				const r = m.getBoundingClientRect();
				return {
					zone: zone( r ),
					largeur: Math.round( r.width ),
					hauteur: Math.round( r.height ),
					// Position verticale DANS la bande : dit si l'image précède ou suit le texte.
					dessus: Math.round( r.top - rb.top ),
					alt: m.getAttribute( 'alt' ) ?? m.closest( 'picture' )?.querySelector( 'img' )?.getAttribute( 'alt' ) ?? null,
				};
			} );

		// Premier bloc de texte réel de la bande : sert de repère « le texte est à droite/gauche ».
		const paras = [ ...bande.querySelectorAll( 'p' ) ].filter( ( p ) => txt( p ).length > 40 );
		const p0 = paras[ 0 ];
		const texte = p0
			? ( () => {
					const r = p0.getBoundingClientRect();
					return { zone: zone( r ), largeur: Math.round( r.width ), dessus: Math.round( r.top - rb.top ) };
			  } )()
			: null;

		// Une citation : <blockquote>, ou un paragraphe qui commence par un guillemet français.
		const cit = bande.querySelector( 'blockquote' ) || paras.find( ( p ) => /^[«"]/.test( txt( p ) ) );
		const citation = cit
			? ( () => {
					const r = cit.getBoundingClientRect();
					return {
						largeur: Math.round( r.width ),
						partWindow: Math.round( ( r.width / W ) * 100 ),
						// Bande pleine largeur : le CONTENEUR de la citation couvre la fenêtre.
						conteneurPleineLargeur: Math.round( ( rb.width / W ) * 100 ) >= 99,
						extrait: txt( cit ).slice( 0, 60 ),
					};
			  } )()
			: null;

		// Grilles : nombre de colonnes réellement rendues, mesuré sur les positions des enfants.
		const grilles = [ ...bande.querySelectorAll( '*' ) ]
			.filter( ( e ) => {
				const s = getComputedStyle( e );
				return ( s.display === 'grid' || s.display === 'flex' ) && e.children.length >= 2;
			} )
			.map( ( g ) => {
				const enf = [ ...g.children ].filter( ( c ) => c.getBoundingClientRect().height > 20 );
				if ( enf.length < 2 ) return null;
				const tops = new Set( enf.map( ( c ) => Math.round( c.getBoundingClientRect().top / 8 ) ) );
				return {
					enfants: enf.length,
					rangees: tops.size,
					colonnes: Math.round( enf.length / tops.size ),
					premier: txt( enf[ 0 ] ).slice( 0, 40 ),
				};
			} )
			.filter( ( g ) => g && g.enfants >= 2 && g.colonnes >= 1 );

		return {
			index,
			titre: txt( titre ).slice( 0, 70 ),
			hauteur: Math.round( rb.height ),
			pleineLargeur: Math.round( ( rb.width / W ) * 100 ) >= 99,
			fond: getComputedStyle( bande ).backgroundColor,
			medias,
			texte,
			citation,
			// Grilles dédupliquées : plusieurs conteneurs imbriqués donnent la même géométrie.
			grilles: [ ...new Map( grilles.map( ( g ) => [ `${ g.enfants }/${ g.rangees }/${ g.premier }`, g ] ) ).values() ].slice( 0, 4 ),
		};
	} );
};

async function stabiliser( page ) {
	await page.addStyleTag( { content: '*,*::before,*::after{animation:none!important;transition:none!important}' } ).catch( () => {} );
	await page.evaluate( async () => {
		for ( let y = 0; y < document.body.scrollHeight; y += 600 ) {
			window.scrollTo( 0, y );
			await new Promise( ( r ) => setTimeout( r, 50 ) );
		}
		window.scrollTo( 0, 0 );
	} );
	await page.evaluate( () => document.fonts && document.fonts.ready ).catch( () => {} );
	await page.waitForTimeout( 300 );
}

const browser = await chromium.launch( { executablePath: '/opt/pw-browsers/chromium' } );
for ( const largeur of LARGEURS ) {
	const ref = await browser.newPage( { viewport: { width: largeur, height: 900 } } );
	await ref.goto( REF, { waitUntil: 'load', timeout: 90000 } );
	await ref.waitForTimeout( 5500 );
	await ref.evaluate( ( h ) => { location.hash = h.replace( /^#/, '' ); }, routeRef );
	await ref.waitForTimeout( 1400 );
	await stabiliser( ref );
	const a = await ref.evaluate( `(${ RELEVE.toString() })()` );
	await ref.close();

	const wp = await browser.newPage( { viewport: { width: largeur, height: 900 } } );
	await wp.goto( WP + routeWp, { waitUntil: 'networkidle', timeout: 60000 } );
	await stabiliser( wp );
	const b = await wp.evaluate( `(${ RELEVE.toString() })()` );
	await wp.close();

	console.log( `\n════════ ${ largeur } px ════════` );
	const n = Math.max( a.length, b.length );
	for ( let i = 0; i < n; i++ ) {
		const decrire = ( s ) => {
			if ( ! s ) return '        — (bande absente)';
			const m = s.medias.map( ( x ) => `${ x.zone }@${ x.dessus }px ${ x.largeur }×${ x.hauteur }` ).join( ' | ' ) || '—';
			const t = s.texte ? `${ s.texte.zone }@${ s.texte.dessus }px l=${ s.texte.largeur }` : '—';
			const c = s.citation ? `citation ${ s.citation.partWindow }% ${ s.citation.conteneurPleineLargeur ? 'BANDE-PLEINE' : 'colonne' } « ${ s.citation.extrait } »` : '';
			const g = s.grilles.map( ( x ) => `${ x.colonnes }col×${ x.rangees }rang (${ x.enfants })` ).join( ' ; ' );
			return `        H=${ s.hauteur } fond=${ s.fond }\n        média : ${ m }\n        texte : ${ t }${ c ? `\n        ${ c }` : '' }${ g ? `\n        grilles : ${ g }` : '' }`;
		};
		console.log( `\n[${ i }] MAQUETTE « ${ a[ i ]?.titre ?? '' } »` );
		console.log( decrire( a[ i ] ) );
		console.log( `    WORDPRESS « ${ b[ i ]?.titre ?? '' } »` );
		console.log( decrire( b[ i ] ) );
	}
}
await browser.close();
