// @ts-check
import { test, expect } from '@playwright/test';
import { execFileSync } from 'node:child_process';
import { mkdtempSync, rmSync, symlinkSync, unlinkSync, writeFileSync, readFileSync, cpSync } from 'node:fs';
import { tmpdir } from 'node:os';
import path from 'node:path';
import { verifierParite } from '../tools/verifier-parite-installeur.mjs';

/**
 * Parité entre le dépôt et ce qui sera livré — contrôle bloquant.
 *
 * ## Pourquoi ce fichier existe
 *
 * Le paquet d'installation avait dérivé du dépôt de plus de 1 800 lignes, et un seed portant une
 * décision n'y figurait pas du tout. Rien ne le signalait : les deux arborescences sont valides
 * prises séparément, et personne ne les compare spontanément. Le plugin aurait déployé un site
 * plus ancien que le dépôt.
 *
 * Ce contrôle est joué par la suite complète et avant chaque construction de paquet
 * (`tools/build-paquets.mjs`). Il échoue si un fichier manque, si une copie diffère, et il nomme
 * les chemins divergents.
 *
 * ## La fixture
 *
 * Un contrôle de parité qui passe ne prouve rien tant qu'on n'a pas vu ce qui le fait échouer :
 * une comparaison mal écrite — mauvais chemin, liste vide, exception avalée — passe tout aussi
 * silencieusement qu'une parité réelle. Les deux tests de fixture cassent donc délibérément la
 * parité, sur une copie jetable du dépôt, et exigent que le contrôle s'en aperçoive.
 */

const RACINE = path.resolve( path.dirname( new URL( import.meta.url ).pathname ), '..' );

/** Lance le contrôle dans une copie du dépôt, après y avoir appliqué une avarie. */
function pariteApresAvarie( avarie ) {
	const bac = mkdtempSync( path.join( tmpdir(), 'tfp-parite-fixture-' ) );
	try {
		// Une copie minimale : le contrôle ne lit que ces quatre arborescences plus `build/`.
		for ( const rel of [ 'bin', 'installer', 'tools', 'build', 'package.json' ] ) {
			cpSync( path.join( RACINE, rel ), path.join( bac, rel ), { recursive: true } );
		}
		cpSync(
			path.join( RACINE, 'wp-content/themes/topfamillepro' ),
			path.join( bac, 'wp-content/themes/topfamillepro' ),
			{ recursive: true }
		);
		// esbuild est nécessaire à la reconstruction CSS/JS : on le prête plutôt que de le copier.
		symlinkSync( path.join( RACINE, 'node_modules' ), path.join( bac, 'node_modules' ), 'dir' );

		avarie( bac );

		const sortie = execFileSync(
			'node',
			[ path.join( bac, 'tools/verifier-parite-installeur.mjs' ), '--json' ],
			{ encoding: 'utf8', cwd: bac, stdio: [ 'ignore', 'pipe', 'pipe' ] }
		);
		return { code: 0, rapport: JSON.parse( sortie ) };
	} catch ( e ) {
		// Sortie 1 attendue : le rapport JSON reste sur stdout. S'il est vide, c'est que le
		// contrôle a planté au lieu de constater — un cas à distinguer, pas à confondre.
		const brut = String( e.stdout || '' ).trim();
		if ( ! brut ) {
			throw new Error(
				`le contrôle de parité n'a rien produit (code ${ e.status }) :\n${ String( e.stderr || '' ) }`
			);
		}
		return { code: e.status ?? 1, rapport: JSON.parse( brut ) };
	} finally {
		rmSync( bac, { recursive: true, force: true } );
	}
}

test.describe( 'Parité dépôt ↔ livraison', () => {
	test( 'le dépôt et le paquet d’installation concordent', () => {
		const r = verifierParite();

		expect(
			r.manquants,
			'des fichiers attendus manquent à la livraison :\n' + r.manquants.join('\n')
		).toEqual( [] );
		expect(
			r.divergents,
			'des copies diffèrent de leur original :\n' + r.divergents.join('\n')
		).toEqual( [] );

		// Un contrôle qui ne compare rien passe aussi. Ces bornes le disent.
		expect( r.seeds, 'le plugin doit déclarer ses seeds' ).toBeGreaterThanOrEqual( 16 );
		expect( r.compares, 'trop peu de fichiers comparés : la lecture est cassée' ).toBeGreaterThan( 600 );
	} );

	test( 'fixture — un seed absent du paquet fait échouer le contrôle', () => {
		const { code, rapport } = pariteApresAvarie( ( bac ) => {
			unlinkSync( path.join( bac, 'installer/topfamillepro-content-installer/seed/seed-fidelite-zones.php' ) );
		} );

		expect( code, 'le contrôle doit sortir en erreur' ).toBe( 1 );
		expect(
			rapport.manquants.some( ( m ) => m.includes( 'seed-fidelite-zones.php' ) ),
			`le seed absent n'est pas signalé : ${ JSON.stringify( rapport.manquants ) }`
		).toBe( true );
	} );

	test( 'fixture — une copie modifiée fait échouer le contrôle', () => {
		const { code, rapport } = pariteApresAvarie( ( bac ) => {
			const cible = path.join(
				bac,
				'installer/topfamillepro-content-installer/seed/seed-phase4-maillage.php'
			);
			writeFileSync( cible, readFileSync( cible, 'utf8' ) + "\n// dérive introduite par la fixture\n" );
		} );

		expect( code, 'le contrôle doit sortir en erreur' ).toBe( 1 );
		expect(
			rapport.divergents.some( ( d ) => d.includes( 'seed-phase4-maillage.php' ) ),
			`la copie modifiée n'est pas signalée : ${ JSON.stringify( rapport.divergents ) }`
		).toBe( true );
	} );

	test( 'fixture — un CSS distribué en retard sur ses sources fait échouer le contrôle', () => {
		const { code, rapport } = pariteApresAvarie( ( bac ) => {
			const dist = path.join( bac, 'wp-content/themes/topfamillepro/assets/dist/css/main.css' );
			writeFileSync( dist, readFileSync( dist, 'utf8' ) + '\n/* feuille périmée */\n' );
		} );

		expect( code, 'le contrôle doit sortir en erreur' ).toBe( 1 );
		expect(
			rapport.divergents.some( ( d ) => d.includes( 'assets/dist/css/main.css' ) ),
			`la feuille périmée n'est pas signalée : ${ JSON.stringify( rapport.divergents ) }`
		).toBe( true );
	} );
} );
