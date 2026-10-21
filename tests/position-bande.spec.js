// @ts-check
import { test, expect } from '@playwright/test';
import { comparerPosition, normaliserTitre } from '../tools/lib/position-bande.mjs';

/**
 * Un fichier correct servi dans la mauvaise bande doit faire échouer l'audit (G27 §7).
 *
 * ## Pourquoi ce fichier existe
 *
 * L'audit des images comparait les octets, et rien d'autre. La bande « Cahier des charges,
 * intervenants et suivi » de la page pilier portait le bon visuel, aux bons octets, à la 18ᵉ
 * position au lieu de la 11ᵉ : l'audit la déclarait identique et il avait raison sur ce qu'il
 * mesurait. C'est le motif exact d'un refus de validation.
 *
 * La comparaison de position est donc devenue une fonction à part, pour qu'on puisse l'éprouver
 * sur des cas construits plutôt que sur l'état du jour — un audit vert peut vouloir dire « rien à
 * signaler » ou « le contrôle ne mord plus », et rien ne les distingue de l'extérieur.
 */

/** Le cas réel, tel que les deux rendus l'exposaient avant la correction. */
const AVANT_CORRECTION = {
	maquette: {
		bande: 'Cahier des charges, intervenants et suivi',
		avant: 'Comment se construit un cahier des charges',
		apres: 'Trois situations concrètes',
	},
	site: {
		bande: 'Cahier des charges, intervenants et suivi',
		avant: 'Questions fréquentes',
		apres: 'Un projet d’entretien pour vos locaux ?',
	},
};

test.describe( 'Position d’une image dans le flux', () => {
	test( 'la bande déplacée du pilier est détectée', () => {
		const r = comparerPosition( AVANT_CORRECTION.maquette, AVANT_CORRECTION.site );
		expect(
			r.verdict,
			'le titre de la bande se déplace AVEC elle : seuls les voisins trahissent le déplacement'
		).toBe( 'deplacee' );

		// Et c'est bien le voisinage qui a parlé, pas le titre de la bande.
		const parNom = Object.fromEntries( r.creneaux.map( ( c ) => [ c.nom, c ] ) );
		expect( parNom.bande.egal ).toBe( true );
		expect( parNom.avant.egal ).toBe( false );
		expect( parNom.apres.egal ).toBe( false );
	} );

	test( 'la bande remise à sa place est acceptée', () => {
		const r = comparerPosition( AVANT_CORRECTION.maquette, AVANT_CORRECTION.maquette );
		expect( r.verdict ).toBe( 'meme-place' );
	} );

	test( 'casse, accents et ponctuation ne sont pas des déplacements', () => {
		const r = comparerPosition(
			{ bande: 'Trois situations concrètes', avant: 'Le tarif, en toute transparence', apres: 'Nos villes' },
			{ bande: 'TROIS SITUATIONS CONCRETES', avant: 'Le tarif — en toute transparence', apres: 'Nos villes' }
		);
		expect( r.verdict ).toBe( 'meme-place' );
		expect( normaliserTitre( 'Côte-d’Or : Dijon' ) ).toBe( 'cote d or dijon' );
	} );

	test( 'un créneau vide d’un seul côté ne fabrique pas d’écart', () => {
		/*
		 * Les deux rendus ne découpent pas leurs bandes au même niveau du DOM : l'index des
		 * conseils expose un titre côté site là où la maquette n'en expose aucun. Compter cela
		 * comme un déplacement produisait quatre faux écarts, et un audit qu'on apprend à ignorer
		 * ne protège plus de rien.
		 */
		const r = comparerPosition(
			{ bande: '', avant: '', apres: 'Les autres articles' },
			{ bande: 'À quelle fréquence faire nettoyer ses bureaux ?', avant: '', apres: 'Les autres articles' }
		);
		expect( r.verdict ).toBe( 'meme-place' );
	} );

	test( 'sans aucun créneau comparable, le verdict le dit au lieu de trancher', () => {
		const r = comparerPosition( { bande: '', avant: '', apres: '' }, { bande: 'Une bande', avant: '', apres: '' } );
		expect( r.verdict ).toBe( 'non-comparable' );
	} );

	test( 'l’audit du jour ne porte aucun écart', async () => {
		const { readFileSync } = await import( 'node:fs' );
		const rapport = JSON.parse( readFileSync( 'docs/audit-images-role.json', 'utf8' ) );
		const deplacees = rapport.lignes.filter( ( l ) => l.verdict === 'BONNE IMAGE, MAUVAISE BANDE' );
		expect( deplacees.map( ( l ) => `${ l.route } ${ l.role } #${ l.rang }` ) ).toEqual( [] );
		expect( rapport.ecarts, 'écarts d’images relevés' ).toBe( 0 );
		expect( rapport.total, 'trop peu d’images auditées : la lecture est cassée' ).toBeGreaterThanOrEqual( 160 );

		// Le relevé de position doit être présent, sinon l'audit est revenu à l'empreinte seule.
		const avecPosition = rapport.lignes.filter( ( l ) => l.maquette && l.maquette.bande !== undefined );
		expect( avecPosition.length ).toBeGreaterThan( 100 );
	} );
} );
