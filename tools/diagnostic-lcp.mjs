#!/usr/bin/env node
/**
 * Diagnostic LCP route par route, à partir des rapports Lighthouse conservés (G27 §11).
 *
 * ## Pourquoi cet outil existe
 *
 * « Quatre mesures au-dessus de 2,5 s » ne dit pas quoi corriger. Un LCP se décompose en quatre
 * temps, et chacun a une cause différente :
 *
 *  - **TTFB** — le serveur met du temps à répondre. Rien à gagner côté page.
 *  - **Délai de découverte** (`load delay`) — le navigateur a mis du temps à SAVOIR qu'il fallait
 *    charger cette ressource : elle est arrivée par une feuille de style, un script, ou un
 *    `srcset` qu'il fallait résoudre. C'est ce que corrigent `fetchpriority`, `preload`, et le fait
 *    de ne pas cacher l'image derrière du CSS.
 *  - **Durée de transfert** (`load time`) — la ressource est trop lourde pour le lien.
 *  - **Délai de rendu** (`render delay`) — tout était là, et la page n'a pas pu peindre : polices
 *    bloquantes, CSS non critique en tête, script synchrone.
 *
 * Confondre les quatre conduit à optimiser au hasard : compresser une image dont le problème est
 * qu'elle est découverte 900 ms trop tard ne gagne rien.
 *
 * Cet outil lit les rapports JSON déjà produits par `tools/lighthouse.mjs` et écrit, pour chaque
 * route et chaque profil : l'élément LCP, les quatre temps, la taille et la priorité réseau de la
 * ressource, et ce que coûtent les polices et la CSS.
 *
 * Usage : node tools/diagnostic-lcp.mjs [--dossier=export/lighthouse]
 */
import { readdirSync, readFileSync, writeFileSync } from 'node:fs';
import { join } from 'node:path';

const DOSSIER = (process.argv.find( ( a ) => a.startsWith( '--dossier=' ) ) || '' ).split( '=' )[ 1 ] || 'export/lighthouse';
const CIBLE_MS = 2500;

/** Les quatre temps du LCP, dans l'ordre où le navigateur les traverse. */
const SUBPARTS = [
	[ 'timeToFirstByte', 'TTFB' ],
	[ 'resourceLoadDelay', 'découverte' ],
	[ 'resourceLoadDuration', 'transfert' ],
	[ 'elementRenderDelay', 'rendu' ],
];

function lire( fichier ) {
	const r = JSON.parse( readFileSync( join( DOSSIER, fichier ), 'utf8' ) );
	const audits = r.audits || {};

	const lcp = audits[ 'largest-contentful-paint' ]?.numericValue ?? null;

	/* Décomposition et nœud LCP. */
	const bd = audits[ 'lcp-breakdown-insight' ]?.details?.items || [];
	const table = bd.find( ( i ) => i.type === 'table' );
	const noeud = bd.find( ( i ) => i.type === 'node' );
	const temps = {};
	for ( const it of table?.items || [] ) temps[ it.subpart ] = Math.round( it.duration );

	/* La ressource LCP dans le journal réseau, quand l'élément en est une. */
	const reqs = audits[ 'network-requests' ]?.details?.items || [];
	const estImage = /IMG|image|picture/i.test( noeud?.snippet || '' );
	let ressource = null;
	if ( estImage ) {
		const images = reqs.filter( ( q ) => /image/i.test( q.mimeType || q.resourceType || '' ) );
		ressource = images.sort( ( a, b ) => ( a.networkEndTime || 0 ) - ( b.networkEndTime || 0 ) )[ 0 ] || null;
	}

	/* Ce que coûtent polices et CSS : poids total et fin de chargement du dernier. */
	const parType = ( re ) => {
		const l = reqs.filter( ( q ) => re.test( q.mimeType || '' ) || re.test( q.resourceType || '' ) );
		return {
			n: l.length,
			poids: l.reduce( ( s, q ) => s + ( q.transferSize || 0 ), 0 ),
			fin: l.length ? Math.round( Math.max( ...l.map( ( q ) => q.networkEndTime || 0 ) ) ) : 0,
		};
	};

	return {
		fichier,
		lcp,
		element: noeud?.selector || '(non identifié)',
		snippet: ( noeud?.snippet || '' ).slice( 0, 60 ),
		temps,
		ressource: ressource
			? {
					url: ( ressource.url || '' ).split( '/' ).pop(),
					taille: ressource.transferSize || 0,
					priorite: ressource.priority || '—',
				}
			: null,
		polices: parType( /font/i ),
		css: parType( /stylesheet|text\/css/i ),
	};
}

const fichiers = readdirSync( DOSSIER ).filter( ( f ) => f.endsWith( '.report.json' ) );
if ( ! fichiers.length ) {
	console.error( `Aucun rapport dans ${ DOSSIER } — lancer d'abord node tools/lighthouse.mjs` );
	process.exit( 1 );
}

/* Une route peut avoir plusieurs passes (r2, r3) : on garde la MÉDIANE, comme le rapport. */
const parCle = new Map();
for ( const f of fichiers ) {
	const cle = f.replace( /(-r\d+)?\.report\.json$/, '' );
	if ( ! parCle.has( cle ) ) parCle.set( cle, [] );
	parCle.get( cle ).push( lire( f ) );
}

const mediane = ( xs ) => {
	const t = xs.filter( ( x ) => typeof x === 'number' ).sort( ( a, b ) => a - b );
	return t.length ? t[ Math.floor( t.length / 2 ) ] : null;
};

const lignes = [];
for ( const [ cle, passes ] of [ ...parCle.entries() ].sort() ) {
	const ref = passes[ 0 ];
	const lcpMed = mediane( passes.map( ( p ) => p.lcp ) );
	const t = {};
	for ( const [ k ] of SUBPARTS ) t[ k ] = mediane( passes.map( ( p ) => p.temps[ k ] ?? 0 ) ) || 0;
	lignes.push( { cle, passes: passes.length, lcp: lcpMed, temps: t, ...ref } );
}

const ko = lignes.filter( ( l ) => l.lcp !== null && l.lcp > CIBLE_MS );

const L = [];
L.push( '# Diagnostic LCP — route par route', '' );
L.push( '> Fichier **généré** par `node tools/diagnostic-lcp.mjs`, depuis les rapports Lighthouse', '' );
L.push( `> conservés dans \`${ DOSSIER }\`. Ne pas éditer à la main.`, '' );
L.push( 'Un LCP se décompose en quatre temps, et chacun appelle une correction différente :' );
L.push( '**TTFB** (le serveur répond), **découverte** (le navigateur apprend qu\'il faut charger la' );
L.push( 'ressource), **transfert** (elle arrive), **rendu** (la page peut enfin peindre). Compresser' );
L.push( 'une image découverte 900 ms trop tard ne gagne rien : c\'est pourquoi les quatre sont' );
L.push( 'relevés séparément.', '' );
L.push( '> **Les quatre temps ne s\'additionnent pas jusqu\'au LCP, et c\'est normal.** La colonne' );
L.push( '> « LCP » est la valeur **simulée** par Lighthouse — le lien mobile bridé qu\'il modélise —' );
L.push( '> tandis que la décomposition est **observée** sur la machine de mesure, qui est rapide. Les' );
L.push( '> quatre temps disent donc où le navigateur passe son temps, pas combien il en passera sur un' );
L.push( '> téléphone. Les additionner et conclure que le compte n\'y est pas serait lire le tableau à' );
L.push( '> l\'envers.', '' );
L.push( 'Quand la décomposition observée est quasi nulle et que le LCP simulé reste haut, la cause' );
L.push( 'n\'est ni la ressource ni le rendu : c\'est la **chaîne critique** — le nombre d\'allers-retours' );
L.push( 'réseau à franchir avant le premier rendu.', '' );
L.push( `**${ lignes.length } mesures · ${ ko.length } au-dessus de ${ CIBLE_MS / 1000 } s.**`, '' );
L.push( '| Mesure | LCP | Élément LCP | TTFB | Découverte | Transfert | Rendu | Ressource | Taille | Priorité | Polices | CSS |' );
L.push( '|---|---:|---|---:|---:|---:|---:|---|---:|---|---|---|' );
for ( const l of lignes ) {
	const ms = ( v ) => ( v ? Math.round( v ) + ' ms' : '—' );
	const ko2 = l.lcp > CIBLE_MS ? '**' : '';
	L.push(
		`| \`${ l.cle }\` | ${ ko2 }${ l.lcp === null ? '—' : ( l.lcp / 1000 ).toFixed( 2 ) + ' s' }${ ko2 } | ` +
			`\`${ l.element.slice( 0, 46 ) }\` | ${ ms( l.temps.timeToFirstByte ) } | ${ ms( l.temps.resourceLoadDelay ) } | ` +
			`${ ms( l.temps.resourceLoadDuration ) } | ${ ms( l.temps.elementRenderDelay ) } | ` +
			`${ l.ressource ? l.ressource.url : '— (texte)' } | ${ l.ressource ? Math.round( l.ressource.taille / 1024 ) + ' ko' : '—' } | ` +
			`${ l.ressource ? l.ressource.priorite : '—' } | ${ l.polices.n } · ${ Math.round( l.polices.poids / 1024 ) } ko · fin ${ l.polices.fin } ms | ` +
			`${ l.css.n } · ${ Math.round( l.css.poids / 1024 ) } ko · fin ${ l.css.fin } ms |`
	);
}
L.push( '' );
if ( ko.length ) {
	L.push( '## Mesures au-dessus de la cible', '' );
	for ( const l of ko ) {
		const pire = SUBPARTS.map( ( [ k, nom ] ) => [ nom, l.temps[ k ] || 0 ] ).sort( ( a, b ) => b[ 1 ] - a[ 1 ] )[ 0 ];
		L.push( `- \`${ l.cle }\` — ${ ( l.lcp / 1000 ).toFixed( 2 ) } s, dominé par **${ pire[ 0 ] }** (${ pire[ 1 ] } ms).` );
	}
	L.push( '' );
}

writeFileSync( 'docs/DIAGNOSTIC-LCP.md', L.join( '\n' ) + '\n' );
console.log( `${ lignes.length } mesures · ${ ko.length } au-dessus de ${ CIBLE_MS } ms` );
for ( const l of ko ) console.log( `   ${ l.cle } : ${ ( l.lcp / 1000 ).toFixed( 2 ) } s — ${ l.element.slice( 0, 50 ) }` );
console.log( '\nÉcrit : docs/DIAGNOSTIC-LCP.md' );
