#!/usr/bin/env node
/**
 * Lint syntaxique PHP (`php -l`) sur tous les fichiers .php du thème.
 * Ne remplace pas PHP_CodeSniffer / WPCS (à ajouter si un environnement PHP + Composer est
 * disponible côté CI) — vérifie au minimum qu'aucun fichier ne contient d'erreur fatale.
 *
 * Usage : npm run lint:php
 */
import { execFile } from 'node:child_process';
import { readdir } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { promisify } from 'node:util';

const execFileAsync = promisify(execFile);
const __dirname = path.dirname(fileURLToPath(import.meta.url));
const THEME_DIR = path.join(__dirname, '..', 'wp-content', 'themes', 'topfamillepro');

async function findPhpFiles(dir) {
  const entries = await readdir(dir, { withFileTypes: true });
  const files = [];
  for (const entry of entries) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) {
      files.push(...(await findPhpFiles(full)));
    } else if (entry.name.endsWith('.php')) {
      files.push(full);
    }
  }
  return files;
}

async function main() {
  const files = await findPhpFiles(THEME_DIR);
  let hasError = false;

  for (const file of files) {
    try {
      await execFileAsync('php', ['-l', file]);
      console.log(`  OK  ${path.relative(THEME_DIR, file)}`);
    } catch (err) {
      hasError = true;
      console.error(`FAIL  ${path.relative(THEME_DIR, file)}`);
      console.error(err.stdout || err.message);
    }
  }

  console.log(`\n${files.length} fichiers PHP vérifiés.`);
  if (hasError) {
    process.exit(1);
  }
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
