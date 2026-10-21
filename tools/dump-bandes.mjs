#!/usr/bin/env node
/**
 * Dump des BANDES d'une route, maquette et WordPress côte à côte — G26.
 *
 * `tools/sonde-composition.mjs` compare les bandes de premier niveau ; quand une route tient dans
 * une seule section, il ne dit plus rien de l'intérieur. Cet outil descend d'un cran : il liste,
 * dans l'ordre du flux, chaque bloc de contenu (titre, ou groupe visuel), avec sa géométrie et sa
 * première ligne de texte. C'est ce qu'il faut pour reproduire un ORDRE de bandes.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/dump-bandes.mjs /a-propos/ '#/a-propos' 1440
 */
import { chromium } from '@playwright/test';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const routeWp = process.argv[ 2 ];
const routeRef = process.argv[ 3 ];
const largeur = Number( process.argv[ 4 ] || 1440 );
if ( ! routeWp || ! routeRef ) {
	console.error( "Usage : node tools/dump-bandes.mjs /a-propos/ '#/a-propos' 1440" );
	process.exit( 1 );
}

const RELEVE = () => {
	const txt = ( el ) => ( el ? ( el.textContent || '' ).replace( /\s+/g, ' ' ).trim() : '' );
	const W = window.innerWidth;
	const zone = ( r ) => {
		const c = ( r.left + r.right ) / 2;
		return c < W * 0.42 ? 'G' : c > W * 0.58 ? 'D' : 'C';
	};

	/* Tous les titres de la page, dans l'ordre visuel, avec ce qui les entoure. */
	const lignes = [];
	const vus = new Set();

	// Repères : titres, images significatives, citations, boutons.
	const noeuds = [ ...document.querySelectorAll( 'h1, h2, h3, img, blockquote, a[href], button' ) ].filter( ( e ) => {
		const r = e.getBoundingClientRect();
		if ( r.width < 2 || r.height < 2 ) return false;
		if ( e.tagName === 'IMG' && ( r.width < 60 || r.height < 60 ) ) return false;
		if ( ( e.tagName === 'A' || e.tagName === 'BUTTON' ) && r.height < 30 ) return false;
		return true;
	} );

	for ( const e of noeuds ) {
		const r = e.getBoundingClientRect();
		const y = Math.round( r.top + window.scrollY );
		const t = txt( e ).slice( 0, 80 );
		const cle = `${ e.tagName }|${ y }|${ t }`;
		if ( vus.has( cle ) ) continue;
		vus.add( cle );
		const dansEntete = !! e.closest( 'header' );
		const dansPied = !! e.closest( 'footer' );
		lignes.push( {
			y,
			tag: e.tagName,
			zone: zone( r ),
			l: Math.round( r.width ),
			h: Math.round( r.height ),
			texte: e.tagName === 'IMG' ? ( e.getAttribute( 'alt' ) || '(sans alt)' ) : t,
			ou: dansEntete ? 'entête' : dansPied ? 'pied' : '',
		} );
	}
	lignes.sort( ( a, b ) => a.y - b.y );
	return lignes.filter( ( l ) => ! l.ou );
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
await browser.close();

const fmt = ( l ) => `y=${ String( l.y ).padStart( 5 ) } ${ l.zone } ${ l.tag.padEnd( 10 ) } ${ String( l.l ).padStart( 4 ) }×${ String( l.h ).padStart( 4 ) }  ${ l.texte }`;
console.log( `\n════ MAQUETTE ${ routeRef } @ ${ largeur } px (${ a.length } repères) ════` );
a.forEach( ( l ) => console.log( fmt( l ) ) );
console.log( `\n════ WORDPRESS ${ routeWp } @ ${ largeur } px (${ b.length } repères) ════` );
b.forEach( ( l ) => console.log( fmt( l ) ) );
