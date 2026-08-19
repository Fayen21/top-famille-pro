#!/usr/bin/env node
/**
 * Extraction du CSS critique — les règles nécessaires au PREMIER ÉCRAN, et elles seules.
 *
 * ## Pourquoi cet outil existe
 *
 * Le LCP mobile reste au-dessus de 2,5 s sur quatre routes. Le diagnostic
 * (`docs/DIAGNOSTIC-LCP.md`) a montré que la cause n'est ni une ressource trop lourde ni un rendu
 * lent : sur trois des quatre, l'élément LCP est du **texte**, et la décomposition observée tient
 * en 200 ms. Ce qui coûte, c'est la **chaîne critique** — le navigateur doit lire le HTML, y
 * découvrir la feuille de style, aller la chercher, puis seulement peindre. Un aller-retour réseau
 * de plus avant le premier pixel.
 *
 * `CLAUDE.md` §8 demande explicitement du « CSS critique ». Le principe : mettre dans le `<head>`,
 * en ligne, juste ce qu'il faut pour peindre le premier écran, et charger la feuille complète sans
 * bloquer. Le premier rendu ne dépend alors plus que du HTML.
 *
 * ## Comment les règles sont choisies
 *
 * Pas par heuristique de nom de fichier — « 02-base.css est sûrement critique » — mais par
 * **mesure** : on charge chaque route, on relève les éléments réellement présents dans le premier
 * écran, et on garde les règles qui les visent. Un sélecteur qui ne matche rien au-dessus de la
 * ligne de flottaison n'entre pas.
 *
 * Trois catégories sont gardées inconditionnellement, parce que les omettre casse le rendu sans
 * qu'aucun sélecteur ne le signale :
 *
 *  - **`@font-face`** — sinon la première peinture se fait en police système puis bascule, ce qui
 *    est précisément le décalage que les préchargements de G24 avaient éliminé (CLS 0,25) ;
 *  - **les variables de `:root`** — tout le design system en dépend, y compris des règles gardées ;
 *  - **les remises à zéro universelles** (`*`, `html`, `body`) — un `box-sizing` manquant déplace
 *    toutes les boîtes.
 *
 * L'extraction porte sur **toutes les routes** et sur **deux largeurs**, mobile et bureau : le
 * premier écran n'a pas le même contenu à 375 px et à 1440 px, et une règle absente d'un des deux
 * produirait un affichage brut sur l'autre.
 *
 * Usage : node tools/extraire-css-critique.mjs [--largeurs=375,1440]
 * Sortie : wp-content/themes/topfamillepro/assets/dist/css/critical.css
 */
import * as esbuild from 'esbuild';
import { chromium } from '@playwright/test';
import { writeFileSync, readFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const BASE = process.env.TFP_BASE_URL || 'http://localhost:8901';
const SORTIE = 'wp-content/themes/topfamillepro/assets/dist/css/critical.css';
const LARGEURS = ( ( process.argv.find( ( a ) => a.startsWith( '--largeurs=' ) ) || '' ).split( '=' )[ 1 ] || '375,1440' )
	.split( ',' )
	.map( Number );

/**
 * Relève, dans la page courante, les règles CSS du thème qui visent un élément du premier écran.
 * Retourne les textes de règle, dans l'ordre de la feuille — l'ordre porte la cascade.
 */
const RELEVER = ( hauteurEcran ) => {
	const feuille = [ ...document.styleSheets ].find(
		( f ) => ( f.href || '' ).includes( '/topfamillepro/assets/dist/css/main.css' )
	);
	if ( ! feuille ) return { erreur: 'feuille du thème introuvable' };

	/* Éléments réellement visibles dans le premier écran. */
	const auDessus = [ ...document.querySelectorAll( '*' ) ].filter( ( el ) => {
		const r = el.getBoundingClientRect();
		return r.top < hauteurEcran && r.bottom > 0 && r.width > 0 && r.height > 0;
	} );

	/* Une règle est gardée si l'un de ces éléments — ou l'un de leurs ancêtres — la matche. */
	const matche = ( selecteur ) => {
		let s = selecteur;
		try {
			/* Les pseudo-éléments et pseudo-classes d'état ne se testent pas avec `matches`. */
			s = s
				.replace( /::?(before|after|first-line|first-letter|placeholder|selection|marker|backdrop)\b/g, '' )
				.replace( /:(hover|focus|focus-visible|focus-within|active|visited|target|checked|disabled|invalid|user-invalid|open)\b/g, '' )
				.trim();
			if ( ! s || s === '' ) return true;
			return auDessus.some( ( el ) => el.matches( s ) );
		} catch {
			/* Sélecteur non testable : on le garde plutôt que de risquer un manque. */
			return true;
		}
	};

	const TOUJOURS = /^(\*|html|body|:root|::selection|\[hidden\])/;

	const parcourir = ( regles, dansMedia ) => {
		const gardees = [];
		for ( const r of regles ) {
			if ( r.type === CSSRule.FONT_FACE_RULE ) {
				gardees.push( { texte: r.cssText, media: dansMedia, raison: 'font-face' } );
				continue;
			}
			if ( r.type === CSSRule.MEDIA_RULE ) {
				const dedans = parcourir( r.cssRules, r.conditionText || r.media.mediaText );
				gardees.push( ...dedans );
				continue;
			}
			if ( r.type === CSSRule.SUPPORTS_RULE ) {
				gardees.push( ...parcourir( r.cssRules, dansMedia ) );
				continue;
			}
			if ( r.type !== CSSRule.STYLE_RULE ) continue;

			const sels = ( r.selectorText || '' ).split( ',' ).map( ( x ) => x.trim() ).filter( Boolean );
			const gardes = sels.filter( ( s ) => TOUJOURS.test( s ) || matche( s ) );
			if ( ! gardes.length ) continue;
			/* On ne réécrit pas la règle : on garde son texte, avec les seuls sélecteurs retenus. */
			const texte =
				gardes.length === sels.length
					? r.cssText
					: gardes.join( ', ' ) + ' { ' + r.style.cssText + ' }';
			gardees.push( { texte, media: dansMedia, raison: TOUJOURS.test( sels[ 0 ] ) ? 'socle' : 'premier écran' } );
		}
		return gardees;
	};

	let regles;
	try {
		regles = feuille.cssRules;
	} catch {
		return { erreur: 'feuille inaccessible (CORS)' };
	}
	return { regles: parcourir( regles, '' ), total: regles.length, elements: auDessus.length };
};

const navigateur = await chromium.launch( { executablePath: '/opt/pw-browsers/chromium' } );
const routes = Object.values( ROUTE_MAP ).map( ( m ) => m.wp ).filter( Boolean );

/* Map « media condition » → Set de textes de règle, l'ordre d'insertion portant la cascade. */
const parMedia = new Map();
let totalRegles = 0;
let vues = 0;

for ( const largeur of LARGEURS ) {
	const page = await navigateur.newPage( { viewport: { width: largeur, height: 900 } } );
	for ( const route of routes ) {
		await page.goto( BASE + route, { waitUntil: 'networkidle', timeout: 60000 } );
		const r = await page.evaluate( RELEVER, 900 );
		if ( r.erreur ) throw new Error( `${ route } à ${ largeur } px : ${ r.erreur }` );
		totalRegles = r.total;
		vues++;
		for ( const { texte, media } of r.regles ) {
			if ( ! parMedia.has( media ) ) parMedia.set( media, new Set() );
			parMedia.get( media ).add( texte );
		}
	}
	await page.close();
	console.error( `${ largeur } px : ${ routes.length } routes relevées` );
}
await navigateur.close();

const morceaux = [];
/* Hors media d'abord — la cascade veut les règles inconditionnelles avant leurs surcharges. */
for ( const [ media, regles ] of parMedia ) {
	if ( media ) continue;
	morceaux.push( [ ...regles ].join( '\n' ) );
}
for ( const [ media, regles ] of parMedia ) {
	if ( ! media ) continue;
	morceaux.push( `@media ${ media } {\n${ [ ...regles ].join( '\n' ) }\n}` );
}

/*
 * Minification par esbuild — déjà utilisé pour la feuille complète, aucune dépendance nouvelle.
 * Le CSS critique est écrit dans CHAQUE réponse HTML : chaque octet y est payé autant de fois
 * qu'il y a de pages vues, alors qu'un octet de la feuille complète est payé une fois puis mis en
 * cache. C'est le seul endroit du thème où la minification change vraiment quelque chose.
 */
const brut = morceaux.join( '\n' );
const { code: css } = await esbuild.transform( brut, { loader: 'css', minify: true } );
writeFileSync( SORTIE, css );

const complet = readFileSync( 'wp-content/themes/topfamillepro/assets/dist/css/main.css', 'utf8' );
const gardees = [ ...parMedia.values() ].reduce( ( n, s ) => n + s.size, 0 );
console.error(
	`\n${ gardees } règles gardées sur ${ totalRegles } · ${ vues } vues relevées\n` +
		`${ SORTIE } — ${ ( brut.length / 1024 ).toFixed( 1 ) } ko brut, ` +
		`${ ( css.length / 1024 ).toFixed( 1 ) } ko minifié, sur ${ ( complet.length / 1024 ).toFixed( 1 ) } ko ` +
		`(${ Math.round( ( css.length / complet.length ) * 100 ) } % de la feuille complète)`
);
