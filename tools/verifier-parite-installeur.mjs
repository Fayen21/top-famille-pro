#!/usr/bin/env node
/**
 * Contrôle de parité entre le dépôt et ce qui sera livré.
 *
 * ## Pourquoi cet outil existe
 *
 * Le 18 août 2026, le paquet d'installation avait dérivé du dépôt sans que rien ne le signale :
 * 1216 lignes d'écart sur les pages, 401 sur les zones, 133 sur les communes, 72 sur le maillage,
 * et `seed-reassurance.php` — qui porte une décision — absent du paquet. Le plugin aurait déployé
 * un site plus ancien que le dépôt, et personne n'avait de raison de s'en apercevoir : les deux
 * arborescences sont valides prises séparément.
 *
 * Une dérive de ce type ne se voit qu'en comparant, et ne se compare que si quelqu'un y pense.
 * D'où ce contrôle, joué par la suite de tests **et** avant chaque construction de paquet.
 *
 * ## Ce qu'il compare
 *
 *  1. **Seeds** — chaque fichier que `includes/installer.php` déclare doit exister dans le paquet
 *     et être identique à son original de `bin/`.
 *  2. **Fichiers indispensables** — le plugin lui-même, ses `includes`, et le nettoyage des
 *     contenus par défaut de WordPress : présence exigée, nommément.
 *  3. **Gabarits** — les gabarits PHP du thème, dont `single-zone.php` et `page-tarifs.php`.
 *  4. **CSS et JS construits** — reconstruits dans un répertoire jetable et comparés octet par
 *     octet à ceux du dépôt : un `assets/dist` en retard sur `src/` livre l'ancienne feuille.
 *  5. **Manifeste d'images** — présence et cohérence avec les fichiers réellement présents.
 *  6. **Archives**, quand elles existent — chaque entrée du ZIP est comparée au fichier du dépôt.
 *     C'est ce qui interdit de livrer une archive construite avant les dernières corrections.
 *
 * Usage : node tools/verifier-parite-installeur.mjs [--json]
 * Sortie : 0 si tout concorde, 1 sinon, avec la liste des chemins divergents.
 */
import { createHash } from 'node:crypto';
import { execFileSync } from 'node:child_process';
import { mkdtempSync, readFileSync, existsSync, readdirSync, rmSync, statSync } from 'node:fs';
import { tmpdir } from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const RACINE = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const PAQUET = path.join(RACINE, 'installer', 'topfamillepro-content-installer');
const THEME = path.join(RACINE, 'wp-content', 'themes', 'topfamillepro');

const sha = (p) => createHash('sha256').update(readFileSync(p)).digest('hex');
const abs = (rel) => path.join(RACINE, rel);

/**
 * Fichiers du paquet dont la présence est exigée nommément, indépendamment de tout parcours de
 * répertoire : un fichier oublié ne se voit pas dans une liste qu'on a construite en lisant le
 * répertoire lui-même.
 */
const FICHIERS_PAQUET_EXIGES = [
	'topfamillepro-content-installer.php',
	'includes/installer.php',
	'includes/admin-page.php',
	'includes/route-manifest.php',
	'seed/cleanup-wp-defaults.php',
];

/** Gabarits et ressources du thème dont l'absence casserait la livraison. */
const FICHIERS_THEME_EXIGES = [
	'style.css',
	'functions.php',
	'single-zone.php',
	'single-prestation.php',
	'page-tarifs.php',
	'header.php',
	'footer.php',
	'404.php',
	'includes/components.php',
	'includes/acf-fields-zone.php',
	'includes/reassurance-settings.php',
	'template-parts/home/pricing.php',
	'assets/dist/css/main.css',
	'assets/dist/js/main.js',
	'assets/dist/images/manifest.json',
];

/** Archives à contrôler quand elles existent, avec le préfixe qu'elles ajoutent et sa racine. */
const ARCHIVES = [
	{
		zip: 'export/topfamillepro-theme.zip',
		prefixe: 'topfamillepro/',
		racine: 'wp-content/themes/topfamillepro',
	},
	{
		zip: 'export/topfamillepro-content-installer.zip',
		prefixe: 'topfamillepro-content-installer/',
		racine: 'installer/topfamillepro-content-installer',
	},
];

/** Les seeds déclarés par le plugin, dans son ordre d'exécution. */
function seedsDeclares() {
	const php = readFileSync(path.join(PAQUET, 'includes', 'installer.php'), 'utf8');
	const noms = [...php.matchAll(/\$dir \. '([a-z0-9-]+\.php)'/g)].map((m) => m[1]);
	if (!noms.length) {
		throw new Error(
			"aucun seed déclaré dans includes/installer.php — la liste a changé de forme, et ce " +
				'contrôle ne compare plus rien. Corriger la lecture plutôt que la laisser passer.'
		);
	}
	return noms;
}

export function verifierParite() {
	const manquants = [];
	const divergents = [];
	const notes = [];
	let compares = 0;

	// 1. Seeds déclarés : présents dans le paquet ET identiques à ceux du dépôt.
	const seeds = seedsDeclares();
	for (const nom of seeds) {
		const dansPaquet = path.join(PAQUET, 'seed', nom);
		const dansDepot = abs(path.join('bin', nom));
		if (!existsSync(dansPaquet)) {
			manquants.push(`installer/topfamillepro-content-installer/seed/${nom} (déclaré par installer.php)`);
			continue;
		}
		if (!existsSync(dansDepot)) {
			notes.push(`seed ${nom} : présent au paquet, sans original dans bin/ — non comparable`);
			continue;
		}
		compares++;
		if (sha(dansPaquet) !== sha(dansDepot)) {
			divergents.push(`bin/${nom} ≠ installer/topfamillepro-content-installer/seed/${nom}`);
		}
	}

	// 1 bis. Le sens inverse : un seed présent au paquet mais que le plugin ne joue pas ne sera
	// jamais exécuté. C'est ce qui est arrivé à `seed-reassurance.php`, mais à l'envers.
	for (const nom of readdirSync(path.join(PAQUET, 'seed'))) {
		if (!nom.endsWith('.php')) continue;
		if (nom === 'cleanup-wp-defaults.php') continue;
		if (!seeds.includes(nom)) {
			divergents.push(`seed/${nom} présent au paquet mais absent de la liste d'installer.php — jamais joué`);
		}
	}

	// 1 ter. Et le troisième sens : un seed du dépôt que le paquet ignore. Tous les fichiers de
	// `bin/` ne sont pas des seeds — les outils de vérification n'ont rien à y faire.
	const OUTILS_BIN = new Set(['verifier-installation.php']);
	for (const nom of readdirSync(abs('bin'))) {
		if (!nom.endsWith('.php') || OUTILS_BIN.has(nom)) continue;
		if (!seeds.includes(nom)) {
			manquants.push(`bin/${nom} n'est joué par aucune étape d'installer.php`);
		}
	}

	// 2. Fichiers exigés nommément.
	for (const rel of FICHIERS_PAQUET_EXIGES) {
		if (!existsSync(path.join(PAQUET, rel))) {
			manquants.push(`installer/topfamillepro-content-installer/${rel}`);
		}
	}
	for (const rel of FICHIERS_THEME_EXIGES) {
		if (!existsSync(path.join(THEME, rel))) {
			manquants.push(`wp-content/themes/topfamillepro/${rel}`);
		}
	}

	// 3. CSS et JS construits : reconstruits à part, comparés octet par octet.
	const tmp = mkdtempSync(path.join(tmpdir(), 'tfp-parite-'));
	try {
		execFileSync('node', [abs('build/build.mjs'), `--out-dir=${tmp}`], { cwd: RACINE, stdio: 'pipe' });
		for (const rel of ['css/main.css', 'js/main.js']) {
			const frais = path.join(tmp, rel);
			const livre = path.join(THEME, 'assets/dist', rel);
			if (!existsSync(frais) || !existsSync(livre)) {
				manquants.push(`assets/dist/${rel} (reconstruction impossible à comparer)`);
				continue;
			}
			compares++;
			if (sha(frais) !== sha(livre)) {
				divergents.push(
					`wp-content/themes/topfamillepro/assets/dist/${rel} est en retard sur src/ — ` +
						'relancer `npm run build:css`'
				);
			}
		}
	} finally {
		rmSync(tmp, { recursive: true, force: true });
	}

	// 4. Manifeste d'images : chaque fichier qu'il annonce doit exister.
	const manifeste = path.join(THEME, 'assets/dist/images/manifest.json');
	if (existsSync(manifeste)) {
		const data = JSON.parse(readFileSync(manifeste, 'utf8'));
		const fichiers = new Set(readdirSync(path.join(THEME, 'assets/dist/images')));
		for (const [slot, entree] of Object.entries(data)) {
			const noms = JSON.stringify(entree).match(/[\w.-]+\.(avif|webp|jpe?g|png)/g) || [];
			for (const n of noms) {
				compares++;
				if (!fichiers.has(n)) {
					manquants.push(`assets/dist/images/${n} — annoncé par le manifeste (slot « ${slot} »)`);
				}
			}
		}
	} else {
		manquants.push('wp-content/themes/topfamillepro/assets/dist/images/manifest.json');
	}

	// 5. Archives déjà construites : chaque entrée comparée au dépôt.
	for (const a of ARCHIVES) {
		const zip = abs(a.zip);
		if (!existsSync(zip)) {
			notes.push(`${a.zip} : archive absente — rien à comparer (elle sera construite au prochain export)`);
			continue;
		}
		let liste;
		try {
			liste = execFileSync('unzip', ['-Z1', zip], { encoding: 'utf8' }).trim().split('\n');
		} catch {
			notes.push(`${a.zip} : \`unzip\` indisponible, archive non contrôlée`);
			continue;
		}
		for (const entree of liste) {
			if (!entree || entree.endsWith('/')) continue;
			if (!entree.startsWith(a.prefixe)) {
				divergents.push(`${a.zip} : entrée hors racine attendue — ${entree}`);
				continue;
			}
			const rel = path.join(a.racine, entree.slice(a.prefixe.length));
			const surDisque = abs(rel);
			if (!existsSync(surDisque)) {
				divergents.push(`${a.zip} embarque ${entree}, absent du dépôt`);
				continue;
			}
			compares++;
			const contenu = execFileSync('unzip', ['-p', zip, entree], { maxBuffer: 64 * 1024 * 1024 });
			if (createHash('sha256').update(contenu).digest('hex') !== sha(surDisque)) {
				divergents.push(`${a.zip} : ${entree} diffère de ${rel} — archive construite avant les dernières corrections`);
			}
		}
	}

	/*
	 * 6. L'archive du thème doit porter TOUTES les images que son manifeste réclame.
	 *
	 * Contrôle ajouté après constat : `topfamillepro-theme.zip` en embarquait 143 pour 378
	 * annoncées. Un `srcset` qui pointe vers un fichier absent ne casse pas la page — le
	 * navigateur retombe sur une autre source, ou sur rien — donc rien ne le signale avant qu'un
	 * visiteur ne charge la mauvaise largeur. Comparer les listes est le seul moyen de le voir.
	 */
	const zipTheme = abs('export/topfamillepro-theme.zip');
	if (existsSync(manifeste) && existsSync(zipTheme)) {
		try {
			const dansZip = new Set(
				execFileSync('unzip', ['-Z1', zipTheme], { encoding: 'utf8' })
					.trim()
					.split('\n')
					.filter((e) => e.includes('/assets/dist/images/'))
					.map((e) => e.split('/').pop())
			);
			const annoncees = new Set(
				JSON.stringify(JSON.parse(readFileSync(manifeste, 'utf8'))).match(
					/[\w.-]+\.(avif|webp|jpe?g|png)/g
				) || []
			);
			const absentes = [...annoncees].filter((n) => !dansZip.has(n));
			if (absentes.length) {
				divergents.push(
					`export/topfamillepro-theme.zip : ${absentes.length} image(s) du manifeste absente(s) de ` +
						`l'archive — ex. ${absentes.slice(0, 3).join(', ')}`
				);
			}
			compares += annoncees.size;
		} catch {
			notes.push('export/topfamillepro-theme.zip : `unzip` indisponible, images non contrôlées');
		}
	}

	return { manquants, divergents, notes, compares, seeds: seeds.length };
}

/** Lance le contrôle et écrit un compte rendu lisible ; jette si quelque chose diverge. */
export function exigerParite() {
	const r = verifierParite();
	if (r.manquants.length || r.divergents.length) {
		const lignes = [
			'PARITÉ DÉPÔT ↔ LIVRAISON : ÉCHEC',
			...r.manquants.map((m) => `  MANQUANT   ${m}`),
			...r.divergents.map((d) => `  DIVERGENT  ${d}`),
		];
		throw new Error(lignes.join('\n'));
	}
	return r;
}

if (import.meta.url === `file://${process.argv[1]}`) {
	const r = verifierParite();
	if (process.argv.includes('--json')) {
		console.log(JSON.stringify(r, null, 2));
	} else {
		console.log(`Seeds déclarés par le plugin : ${r.seeds}`);
		console.log(`Fichiers comparés par empreinte : ${r.compares}`);
		for (const n of r.notes) console.log(`  note       ${n}`);
		for (const m of r.manquants) console.log(`  MANQUANT   ${m}`);
		for (const d of r.divergents) console.log(`  DIVERGENT  ${d}`);
		console.log(
			r.manquants.length || r.divergents.length
				? `\n✗ ${r.manquants.length} manquant(s), ${r.divergents.length} divergent(s)`
				: '\n✓ dépôt et livraison concordent'
		);
	}
	process.exit(r.manquants.length || r.divergents.length ? 1 : 0);
}
