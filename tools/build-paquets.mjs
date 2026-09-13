#!/usr/bin/env node
/**
 * Construit les deux archives livrables **depuis l'arbre de travail courant**.
 *
 * ## Pourquoi cet outil existe
 *
 * Les archives d'`export/` étaient assemblées à la main, passe après passe. Deux conséquences
 * mesurées le 18 août 2026 : `topfamillepro-theme.zip` embarquait 78 fichiers plus anciens que le
 * dépôt, et il lui manquait **240 des 378 images** que son propre manifeste réclame — un site
 * déployé depuis cette archive aurait servi des `srcset` vers des fichiers absents.
 *
 * L'archive est donc reconstruite, jamais retouchée, et toujours à partir des fichiers **suivis
 * par git** : ce qui n'est pas versionné n'est pas livrable, et ce qui est versionné l'est en
 * entier. Le contrôle de parité tourne avant la construction — inutile d'empaqueter un dépôt qui
 * ne concorde pas avec lui-même — puis après, sur les archives produites.
 *
 * Usage : node tools/build-paquets.mjs [--sans-controle-prealable]
 */
import { execFileSync } from 'node:child_process';
import { copyFileSync, existsSync, mkdirSync, rmSync, statSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { exigerParite, verifierParite } from './verifier-parite-installeur.mjs';

const RACINE = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const EXPORT = path.join(RACINE, 'export');

/** Les deux paquets : source dans le dépôt, racine à l'intérieur de l'archive, nom du fichier. */
const PAQUETS = [
	{
		source: 'wp-content/themes/topfamillepro',
		racineZip: 'topfamillepro',
		zip: 'topfamillepro-theme.zip',
	},
	{
		source: 'installer/topfamillepro-content-installer',
		racineZip: 'topfamillepro-content-installer',
		zip: 'topfamillepro-content-installer.zip',
	},
];

/** Fichiers suivis par git sous un chemin, chemins relatifs à ce chemin. */
function fichiersSuivis(source) {
	const out = execFileSync('git', ['ls-files', '-z', source], { cwd: RACINE, encoding: 'utf8' });
	return out
		.split('\0')
		.filter(Boolean)
		.map((p) => path.relative(source, p));
}

function construire(p) {
	const fichiers = fichiersSuivis(p.source);
	if (!fichiers.length) {
		throw new Error(`aucun fichier suivi sous ${p.source} — rien à empaqueter, et ce n'est pas normal.`);
	}

	// L'archive doit porter `racineZip/` en tête : WordPress installe un ZIP à partir de son
	// répertoire racine, et un ZIP « à plat » se décompresse dans wp-content/themes/ lui-même.
	const travail = path.join(EXPORT, '.build');
	const dest = path.join(travail, p.racineZip);
	rmSync(travail, { recursive: true, force: true });
	mkdirSync(dest, { recursive: true });

	/*
	 * La LISTE vient de git — ni fichier ignoré, ni fichier oublié — mais le CONTENU vient de
	 * l'arbre de travail. `git archive HEAD` livrerait l'état du dernier commit : construire un
	 * paquet avant de committer produirait alors une archive silencieusement en retard, ce qui
	 * est exactement la dérive que ce dispositif doit rendre impossible. Le contrôle de parité
	 * compare lui aussi à l'arbre de travail : les deux mesurent la même chose.
	 */
	for (const rel of fichiers) {
		const origine = path.join(RACINE, p.source, rel);
		if (!existsSync(origine)) {
			/*
			 * Le fichier est SUIVI par git mais absent du disque : une suppression non indexée.
			 * L'erreur brute d'ENOENT ne dirait pas quoi faire ; celle-ci si. C'est arrivé en
			 * remplaçant dix-huit fichiers de police par quatre.
			 */
			throw new Error(
				`${p.source}/${rel} est suivi par git mais absent du disque. ` +
					'Indexer la suppression (`git add -A`) avant de construire les paquets, ' +
					"sinon l'archive serait construite sur une liste qui ne décrit plus le dépôt."
			);
		}
		const cibleFichier = path.join(dest, rel);
		mkdirSync(path.dirname(cibleFichier), { recursive: true });
		copyFileSync(origine, cibleFichier);
	}

	const cible = path.join(EXPORT, p.zip);
	rmSync(cible, { force: true });
	// `-X` : pas d'attributs étendus, pour que deux constructions du même arbre soient comparables.
	execFileSync('zip', ['-r', '-q', '-X', cible, p.racineZip], { cwd: travail });
	rmSync(travail, { recursive: true, force: true });

	const taille = statSync(cible).size;
	console.log(
		`${p.zip.padEnd(38)} ${String(fichiers.length).padStart(4)} fichiers · ` +
			`${(taille / 1024 / 1024).toFixed(2)} Mo`
	);
	return fichiers.length;
}

const sansPrealable = process.argv.includes('--sans-controle-prealable');

if (!sansPrealable) {
	// Contrôle AVANT construction, archives exclues : elles sont précisément ce qu'on va refaire.
	const avant = verifierParite();
	const bloquants = [
		...avant.manquants,
		...avant.divergents.filter((d) => !d.startsWith('export/')),
	];
	if (bloquants.length) {
		console.error('PARITÉ DÉPÔT : ÉCHEC — construction annulée\n' + bloquants.map((b) => `  ${b}`).join('\n'));
		process.exit(1);
	}
	console.log(`Parité du dépôt vérifiée (${avant.compares} fichiers comparés).\n`);
}

mkdirSync(EXPORT, { recursive: true });
for (const p of PAQUETS) construire(p);

// Contrôle APRÈS construction, archives comprises : l'archive doit refléter l'arbre, sinon le
// paquet ment sur ce qu'il contient et personne ne s'en apercevra avant le déploiement.
const apres = exigerParite();
console.log(`\n✓ archives conformes au dépôt (${apres.compares} fichiers comparés par empreinte).`);
