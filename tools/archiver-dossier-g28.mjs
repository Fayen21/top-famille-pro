#!/usr/bin/env node
/**
 * Archives du dossier de validation G28 — une par volume.
 *
 * Chaque archive est AUTONOME : elle contient son `index.html`, ses captures et, pour le volume
 * prioritaire, le rapport, la fiche de décision et le mode d'emploi. Extraite seule, elle
 * s'ouvre et se parcourt ; extraite à côté des autres, les liens entre volumes fonctionnent
 * aussi. C'est la raison pour laquelle les renvois entre volumes passent par `../` : le seul
 * chemin relatif qui marche dans les deux cas.
 *
 * Les archives sont construites depuis le RÉPERTOIRE DE TRAVAIL, pas depuis l'index git : le
 * dossier vient d'être régénéré et n'a pas à être commité pour être vérifiable.
 *
 * Usage : node tools/archiver-dossier-g28.mjs
 */
import { execFileSync } from 'node:child_process';
import { existsSync, mkdirSync, readdirSync, rmSync, statSync } from 'node:fs';
import path from 'node:path';

const RACINE = 'docs/dossier-g28';
const SORTIE = 'release';

if (!existsSync(RACINE)) {
	console.error(`${RACINE} est absent — lancer d'abord node tools/dossier-g28.mjs`);
	process.exit(2);
}
mkdirSync(SORTIE, { recursive: true });

const volumes = readdirSync(RACINE).filter((d) => statSync(path.join(RACINE, d)).isDirectory()).sort();
if (!volumes.length) {
	console.error(`${RACINE} ne contient aucun volume`);
	process.exit(2);
}

let total = 0;
for (const v of volumes) {
	const archive = path.resolve(SORTIE, `dossier-g28-${v}.zip`);
	rmSync(archive, { force: true });
	// `-r` depuis le parent : l'archive porte le nom du volume à sa racine, si bien qu'une
	// extraction ne déverse jamais des fichiers en vrac dans le répertoire courant.
	execFileSync('zip', [ '-q', '-r', archive, v ], { cwd: RACINE });
	const octets = statSync(archive).size;
	total += octets;
	const n = readdirSync(path.join(RACINE, v, 'captures')).length;
	console.log(`${path.basename(archive).padEnd(42)} ${n.toString().padStart(3)} captures · ${(octets / 1048576).toFixed(1)} Mo`);
}
console.log(`\n${volumes.length} archive(s) · ${(total / 1048576).toFixed(1)} Mo au total · dans ${SORTIE}/`);
