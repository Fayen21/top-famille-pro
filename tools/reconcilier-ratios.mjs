#!/usr/bin/env node
/**
 * Réconcilie les décomptes de ratios des deux instruments de mesure (G27 §3).
 *
 * ## Pourquoi cet outil existe
 *
 * Un rapport a annoncé « 318 contrôles · 298 dans 95-105 % » et « 19 ratios hors bande » dans le
 * même paragraphe. Or 318 − 298 = 20. Les deux chiffres étaient exacts et ne parlaient pas de la
 * même chose : ils viennent de **deux instruments différents**, et rien ne le disait.
 *
 * | | Relevé de base | Comparaison des routes |
 * |---|---|---|
 * | Fichier | `docs/baseline.json` | `docs/COMPARAISON-53-ROUTES.md` |
 * | Largeurs | 320, 375, 768, 1024, 1440, 1920 | 375 et 1440 |
 * | Mesure | hauteur de page, **une par largeur** | hauteur **et** nombre de mots |
 * | Total | 53 × 6 = **318** | 53 × 2 × 2 = **212** |
 *
 * Le « 20 » appartient au relevé de base, le « 19 » à la comparaison. Les additionner, les
 * soustraire ou les citer côte à côte sans le dire n'a aucun sens — et c'est ce qui a été fait.
 *
 * Cet outil recalcule les deux, vérifie leur arithmétique interne, et écrit un tableau exhaustif
 * des contrôles hors bande avec route, largeur, ratio, type de page, motif et statut.
 *
 * Usage : node tools/reconcilier-ratios.mjs
 */
import { readFileSync, writeFileSync } from 'node:fs';

const LARGEURS = [ '320', '375', '768', '1024', '1440', '1920' ];
const BANDE = [ 95, 105 ];

/** Type de page et motif d'un écart, par route. Ce qui n'est pas listé est un défaut. */
const CLASSEMENT = {
	'#/mentions-legales': {
		type: 'légale',
		motif: 'Mentions légales réelles : identité, immatriculation, hébergeur, assurance, propriété intellectuelle. La maquette n\'en pose qu\'un résumé.',
		statut: 'contenu légal imposé',
	},
	'#/politique-de-confidentialite': {
		type: 'légale',
		motif: 'Politique de confidentialité réelle : finalités, bases légales, durées, sous-traitants, droits RGPD. La maquette n\'en pose qu\'un résumé.',
		statut: 'contenu légal imposé',
	},
	'#/gestion-des-cookies': {
		type: 'légale',
		motif: 'Gestion des cookies réelle : catégories, finalités, durées, retrait du consentement. La maquette n\'en pose qu\'un résumé.',
		statut: 'contenu légal imposé',
	},
	'#/demande-de-devis': {
		type: 'formulaire',
		motif: 'Formulaire réel : libellés, aides de saisie, messages d\'erreur, mentions de consentement. La maquette dessine des champs, elle n\'en fait pas fonctionner.',
		statut: 'différence fonctionnelle obligatoire',
	},
	'#/contact': {
		type: 'formulaire',
		motif: 'Idem : le formulaire de contact est réel, avec ses libellés et ses messages.',
		statut: 'différence fonctionnelle obligatoire',
	},
};

const baseline = JSON.parse( readFileSync( 'docs/baseline.json', 'utf8' ) );

const controles = [];
for ( const [ route, parLargeur ] of Object.entries( baseline ) ) {
	for ( const w of LARGEURS ) {
		const e = parLargeur[ w ];
		if ( ! e ) continue;
		controles.push( { route, largeur: Number( w ), ratio: e.ratio } );
	}
}
const dans = controles.filter( ( c ) => c.ratio >= BANDE[ 0 ] && c.ratio <= BANDE[ 1 ] );
const hors = controles.filter( ( c ) => ! ( c.ratio >= BANDE[ 0 ] && c.ratio <= BANDE[ 1 ] ) );

if ( dans.length + hors.length !== controles.length ) {
	throw new Error( 'décompte incohérent : un contrôle n\'est ni dans la bande ni hors bande.' );
}

/* --- Comparaison des routes, second instrument --- */
const md = readFileSync( 'docs/COMPARAISON-53-ROUTES.md', 'utf8' );
let largeurCourante = null;
const ratiosComparaison = [];
for ( const ligne of md.split( '\n' ) ) {
	const t = ligne.match( /^## Synthèse à (\d+) px/ );
	if ( t ) { largeurCourante = Number( t[ 1 ] ); continue; }
	if ( ! ligne.startsWith( '| `#/' ) ) continue;
	const cellules = ligne.split( '|' ).map( ( x ) => x.trim() );
	const route = cellules[ 1 ].replace( /`/g, '' );
	for ( const [ i, mesure ] of [ [ 4, 'hauteur' ], [ 5, 'mots' ] ] ) {
		const m = cellules[ i ] && cellules[ i ].match( /\((\d+) %\)/ );
		if ( m ) ratiosComparaison.push( { route, largeur: largeurCourante, mesure, ratio: Number( m[ 1 ] ) } );
	}
}
const horsComparaison = ratiosComparaison.filter( ( r ) => r.ratio < BANDE[ 0 ] || r.ratio > BANDE[ 1 ] );

/* --- Rapport --- */
const defauts = hors.filter( ( c ) => ! CLASSEMENT[ c.route ] );
const L = [];
L.push( '# Réconciliation des décomptes de ratios', '' );
L.push( '> Fichier **généré** par `node tools/reconcilier-ratios.mjs`. Ne pas éditer à la main.', '' );
L.push( '## Deux instruments, deux totaux — et la confusion qu\'ils ont produite', '' );
L.push( 'Un rapport a annoncé « 318 contrôles · 298 dans 95-105 % » et « 19 ratios hors bande » dans' );
L.push( 'le même paragraphe. 318 − 298 = **20**, pas 19. Les deux chiffres étaient exacts, et ne' );
L.push( 'parlaient pas de la même chose. Rien ne le disait : c\'est le défaut, pas les chiffres.', '' );
L.push( '| | Relevé de base | Comparaison des routes |' );
L.push( '|---|---|---|' );
L.push( '| Fichier | `docs/baseline.json` | `docs/COMPARAISON-53-ROUTES.md` |' );
L.push( '| Largeurs | 320, 375, 768, 1024, 1440, 1920 | 375 et 1440 |' );
L.push( '| Mesure par route et par largeur | hauteur de page, **une seule** | hauteur **et** nombre de mots |' );
L.push( `| Total de contrôles | 53 × 6 = **${ controles.length }** | 53 × 2 × 2 = **${ ratiosComparaison.length }** |` );
L.push( `| Dans 95-105 % | **${ dans.length }** | **${ ratiosComparaison.length - horsComparaison.length }** |` );
L.push( `| Hors bande | **${ hors.length }** | **${ horsComparaison.length }** |` );
L.push( `| Vérification | ${ dans.length } + ${ hors.length } = ${ controles.length } ✅ | ${ ratiosComparaison.length - horsComparaison.length } + ${ horsComparaison.length } = ${ ratiosComparaison.length } ✅ |`, '' );
L.push( 'Le « 20 » appartient au relevé de base, le « 19 » à la comparaison. Ils ne s\'additionnent pas,' );
L.push( 'ne se soustraient pas, et ne se citent pas côte à côte sans nommer leur instrument.', '' );

L.push( `## Relevé de base — les ${ hors.length } contrôles hors bande`, '' );
L.push( '| Route | Largeur | Ratio | Type de page | Motif | Statut |' );
L.push( '|---|---:|---:|---|---|---|' );
for ( const c of hors.sort( ( a, b ) => a.route.localeCompare( b.route ) || a.largeur - b.largeur ) ) {
	const k = CLASSEMENT[ c.route ] || {
		type: 'courante',
		motif: '**Non classé** : aucun motif documenté ne couvre cette route.',
		statut: '**défaut**',
	};
	L.push( `| \`${ c.route }\` | ${ c.largeur } px | ${ c.ratio } % | ${ k.type } | ${ k.motif } | ${ k.statut } |` );
}
L.push( '' );

L.push( `## Comparaison des routes — les ${ horsComparaison.length } ratios hors bande`, '' );
L.push( '| Route | Largeur | Mesure | Ratio | Statut |' );
L.push( '|---|---:|---|---:|---|' );
for ( const r of horsComparaison ) {
	const k = CLASSEMENT[ r.route ];
	L.push( `| \`${ r.route }\` | ${ r.largeur } px | ${ r.mesure } | ${ r.ratio } % | ${ k ? k.statut : '**défaut**' } |` );
}
L.push( '' );

L.push( '## Objectif', '' );
L.push( 'Les trois pages légales font 18 contrôles (3 routes × 6 largeurs) : elles sont autorisées hors' );
L.push( 'tolérance. L\'objectif est donc **300 / 318**, soit les 50 routes non légales dans la bande aux' );
L.push( 'six largeurs.', '' );
L.push( `**État : ${ dans.length } / ${ controles.length }** — ${ defauts.length } défaut(s) restant(s).`, '' );
if ( defauts.length ) {
	for ( const d of defauts ) L.push( `- \`${ d.route }\` à ${ d.largeur } px : ${ d.ratio } %` );
	L.push( '' );
}

writeFileSync( 'docs/RECONCILIATION-RATIOS.md', L.join( '\n' ) + '\n' );
console.log( `Relevé de base   : ${ controles.length } contrôles · ${ dans.length } dans la bande · ${ hors.length } hors` );
console.log( `Comparaison      : ${ ratiosComparaison.length } ratios · ${ horsComparaison.length } hors bande` );
console.log( `Défauts restants : ${ defauts.length }` );
for ( const d of defauts ) console.log( `   ${ d.route } @ ${ d.largeur }px = ${ d.ratio } %` );
console.log( '\nÉcrit : docs/RECONCILIATION-RATIOS.md' );
