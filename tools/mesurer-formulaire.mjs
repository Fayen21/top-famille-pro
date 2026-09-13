#!/usr/bin/env node
/**
 * Relevé comparé du formulaire de devis — maquette contre site (G27 §10).
 *
 * ## Ce qui est mesuré, et ce qui ne l'est pas
 *
 * Ce relevé porte sur la **géométrie** : empilement, largeurs, alignements, espacements, position
 * et ordre des commandes. Il ne porte PAS sur les champs eux-mêmes — les différences
 * fonctionnelles obligatoires (jeton, piège à robots, contexte visiteur, contrôles) sont
 * documentées une par une dans `docs/FORMULAIRE-DIFFERENCES.md`, et elles ne sont pas négociables.
 *
 * La distinction compte : un champ que la maquette n'a pas est un écart **voulu**, un champ de la
 * même largeur rendu 40 px plus haut est un **défaut**. Les confondre conduit soit à retirer un
 * contrôle de sécurité pour gagner une mesure, soit à laisser passer un défaut en le déclarant
 * fonctionnel.
 *
 * Usage : node tools/mesurer-formulaire.mjs [--largeurs=375,1440] [--json]
 */
import { chromium } from '@playwright/test';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = ( process.env.TFP_BASE_URL || 'http://localhost:8901' ) + '/demande-de-devis/';
const LARGEURS = ( ( process.argv.find( ( a ) => a.startsWith( '--largeurs=' ) ) || '' ).split( '=' )[ 1 ] || '375,1440' )
	.split( ',' )
	.map( Number );

/**
 * Relève la géométrie du formulaire visible.
 *
 * Les champs sont désignés par leur LIBELLÉ normalisé, jamais par leur `name` : les deux côtés ne
 * nomment pas toujours pareil (`societe` contre `entreprise`), alors que le libellé affiché est ce
 * que le visiteur lit et ce que la maquette pose.
 */
const RELEVE = () => {
	const px = ( v ) => Math.round( parseFloat( v ) * 10 ) / 10;
	const norm = ( t ) =>
		( t || '' )
			.toLowerCase()
			.normalize( 'NFD' )
			.replace( /[̀-ͯ]/g, '' )
			.replace( /[^a-z0-9 ]/g, ' ' )
			.replace( /\s+/g, ' ' )
			.trim();

	const form = document.querySelector( 'form' ) || document.body;
	const rf = form.getBoundingClientRect();

	/** Libellé associé à un contrôle : `<label for>`, ancêtre `<label>`, ou aria-label. */
	const libelleDe = ( el ) => {
		if ( el.id ) {
			const l = document.querySelector( `label[for="${ CSS.escape( el.id ) }"]` );
			if ( l ) return norm( l.textContent );
		}
		const p = el.closest( 'label' );
		if ( p ) return norm( p.textContent );
		return norm( el.getAttribute( 'aria-label' ) || el.getAttribute( 'placeholder' ) || el.name || '' );
	};

	const champs = [ ...form.querySelectorAll( 'input, select, textarea' ) ]
		.filter( ( el ) => {
			const r = el.getBoundingClientRect();
			return r.width > 0 && r.height > 0 && el.type !== 'hidden';
		} )
		.map( ( el ) => {
			const r = el.getBoundingClientRect();
			const s = getComputedStyle( el );
			return {
				libelle: libelleDe( el ).slice( 0, 40 ),
				balise: el.tagName.toLowerCase(),
				type: el.type || '',
				largeur: px( r.width ),
				hauteur: px( r.height ),
				/* Position relative au formulaire : comparable d'un rendu à l'autre. */
				x: px( r.left - rf.left ),
				y: px( r.top - rf.top ),
				/* Part de la largeur du formulaire : c'est elle qui dit « pleine largeur » ou « moitié ». */
				part: Math.round( ( r.width / rf.width ) * 100 ),
				police: px( s.fontSize ),
				rembourrage: s.padding,
				rayon: s.borderTopLeftRadius,
			};
		} );

	/* Commandes du formulaire, dans l'ordre du document. */
	const commandes = [ ...form.querySelectorAll( 'button, a[href], input[type=submit]' ) ]
		.filter( ( el ) => {
			const r = el.getBoundingClientRect();
			return r.width > 40 && r.height > 24;
		} )
		.map( ( el ) => {
			const r = el.getBoundingClientRect();
			return {
				texte: ( el.textContent || el.value || '' ).replace( /\s+/g, ' ' ).trim().slice( 0, 34 ),
				largeur: px( r.width ),
				hauteur: px( r.height ),
				x: px( r.left - rf.left ),
				y: px( r.top - rf.top ),
			};
		} );

	/* Rangées : des champs de même ordonnée (à 4 px près) sont sur la même ligne. */
	const rangees = [];
	for ( const c of champs ) {
		const r = rangees.find( ( x ) => Math.abs( x.y - c.y ) <= 4 );
		if ( r ) r.champs.push( c.libelle );
		else rangees.push( { y: c.y, champs: [ c.libelle ] } );
	}

	/*
	 * Corps du formulaire : du HAUT DU PREMIER CHAMP au BAS DE LA DERNIÈRE COMMANDE.
	 *
	 * C'est la seule hauteur comparable des deux côtés. La boîte `<form>` ne l'est pas : la
	 * maquette place l'indicateur d'étape et le chapô AVANT sa balise `<form>`, le thème les met
	 * DANS le `<fieldset>` parce qu'ils portent le nom accessible du groupe de champs. Comparer
	 * les deux `<form>` donnait un écart de 73 px qui ne correspondait à rien de visible.
	 */
	/* Le piège à robots est hors du flux (x très négatif) : il ne participe à aucune hauteur
	   visible, et l'inclure abaissait le haut du corps de 46 px sans que rien ne se voie. */
	const dansLeFlux = [ ...champs, ...commandes ].filter( ( c ) => c.x > -1000 );
	const hauts = dansLeFlux.map( ( c ) => c.y );
	const bas = dansLeFlux.map( ( c ) => c.y + c.hauteur );
	const corps = hauts.length ? px( Math.max( ...bas ) - Math.min( ...hauts ) ) : 0;

	return {
		formulaire: { largeur: px( rf.width ), hauteur: px( rf.height ) },
		corps,
		champs,
		commandes,
		rangees: rangees.map( ( r ) => r.champs ),
	};
};

const navigateur = await chromium.launch( { executablePath: '/opt/pw-browsers/chromium' } );
const sortie = {};

for ( const largeur of LARGEURS ) {
	const cote = {};
	for ( const [ nom, url, hash ] of [
		[ 'maquette', REF, '/demande-de-devis' ],
		[ 'site', WP, null ],
	] ) {
		const page = await navigateur.newPage( { viewport: { width: largeur, height: 900 } } );
		await page.goto( url, { waitUntil: hash ? 'load' : 'networkidle' } );
		if ( hash ) {
			await page.waitForTimeout( 4500 );
			await page.evaluate( ( h ) => { location.hash = h; }, hash );
			await page.waitForTimeout( 1600 );
		}
		cote[ nom ] = await page.evaluate( RELEVE );
		await page.close();
	}
	sortie[ largeur ] = cote;
}
await navigateur.close();

if ( process.argv.includes( '--json' ) ) {
	console.log( JSON.stringify( sortie, null, 1 ) );
	process.exit( 0 );
}

for ( const [ largeur, cote ] of Object.entries( sortie ) ) {
	console.log( `\n======== ${ largeur } px` );
	console.log(
		`  corps (1er champ → bas des commandes) : maquette ${ cote.maquette.corps } · site ${ cote.site.corps } ` +
			`(${ Math.round( ( cote.site.corps / cote.maquette.corps ) * 100 ) } %)\n` +
		`  formulaire : maquette ${ cote.maquette.formulaire.largeur } × ${ cote.maquette.formulaire.hauteur } ` +
			`· site ${ cote.site.formulaire.largeur } × ${ cote.site.formulaire.hauteur }`
	);
	console.log( `  rangées maquette : ${ JSON.stringify( cote.maquette.rangees ) }` );
	console.log( `  rangées site     : ${ JSON.stringify( cote.site.rangees ) }` );
	console.log( '\n  -- champs appariés par libellé --' );
	/*
	 * Appariement par PRÉFIXE de libellé, pas par égalité.
	 *
	 * La maquette enferme l'aide de saisie et les options du menu dans le `<label>` : son libellé
	 * relevé est « ville commune ou se trouvent les locaux » là où le site lit « ville ». Exiger
	 * l'égalité déclarait tous les champs absents des deux côtés à la fois — un relevé qui ne
	 * compare rien tout en ayant l'air de tout comparer.
	 */
	const apparie = ( a, b ) => a.startsWith( b ) || b.startsWith( a );
	const m = Object.fromEntries( cote.maquette.champs.map( ( c ) => [ c.libelle, c ] ) );
	const restants = [ ...cote.site.champs ];
	const s = {};
	for ( const lib of Object.keys( m ) ) {
		const i = restants.findIndex( ( c ) => apparie( lib, c.libelle ) );
		if ( i >= 0 ) s[ lib ] = restants.splice( i, 1 )[ 0 ];
	}
	for ( const [ lib, cm ] of Object.entries( m ) ) {
		const cs = s[ lib ];
		if ( ! cs ) {
			console.log( `     ${ lib.padEnd( 34 ) } ABSENT côté site` );
			continue;
		}
		const d = [];
		if ( Math.abs( cm.part - cs.part ) > 3 ) d.push( `part ${ cm.part }% → ${ cs.part }%` );
		if ( Math.abs( cm.hauteur - cs.hauteur ) > 2 ) d.push( `hauteur ${ cm.hauteur } → ${ cs.hauteur }` );
		if ( Math.abs( cm.police - cs.police ) > 0.6 ) d.push( `police ${ cm.police } → ${ cs.police }` );
		if ( cm.rayon !== cs.rayon ) d.push( `rayon ${ cm.rayon } → ${ cs.rayon }` );
		if ( cm.rembourrage !== cs.rembourrage ) d.push( `rembourrage ${ cm.rembourrage } → ${ cs.rembourrage }` );
		console.log( `     ${ lib.padEnd( 34 ) } ${ d.length ? '❌ ' + d.join( ' · ' ) : '✅' }` );
	}
	for ( const c of restants ) {
		console.log( `     ${ c.libelle.padEnd( 34 ) } en plus côté site (${ c.largeur }×${ c.hauteur } @${ c.x },${ c.y })` );
	}
	console.log( '\n  -- commandes --' );
	for ( const nom of [ 'maquette', 'site' ] ) {
		console.log(
			`     ${ nom.padEnd( 9 ) } ` +
				cote[ nom ].commandes.map( ( c ) => `« ${ c.texte } » ${ c.largeur }×${ c.hauteur } @y${ c.y }` ).join( ' | ' )
		);
	}
}
