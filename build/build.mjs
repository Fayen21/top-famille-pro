#!/usr/bin/env node
/**
 * Build CSS + JS du thème enfant topfamillepro avec esbuild.
 * Usage : node build/build.mjs [--watch] [--dev]
 */
import * as esbuild from 'esbuild';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const THEME_DIR = path.join(__dirname, '..', 'wp-content', 'themes', 'topfamillepro');

const isWatch = process.argv.includes('--watch');
const isDev = process.argv.includes('--dev') || isWatch;

const cssBuild = {
  entryPoints: [path.join(THEME_DIR, 'src/css/main.css')],
  bundle: true,
  minify: !isDev,
  sourcemap: isDev,
  outfile: path.join(THEME_DIR, 'assets/dist/css/main.css'),
  /* Les .woff2 vivent déjà à leur emplacement final (assets/dist/fonts/) : on laisse
     les url() telles quelles plutôt que de les faire résoudre/copier par esbuild. */
  external: ['*.woff2'],
};

const jsBuild = {
  entryPoints: [path.join(THEME_DIR, 'src/js/main.js')],
  bundle: true,
  minify: !isDev,
  sourcemap: isDev,
  target: ['es2018'],
  outfile: path.join(THEME_DIR, 'assets/dist/js/main.js'),
};

async function run() {
  if (isWatch) {
    const cssCtx = await esbuild.context(cssBuild);
    const jsCtx = await esbuild.context(jsBuild);
    await cssCtx.watch();
    await jsCtx.watch();
    console.log('Watching src/css and src/js for changes…');
  } else {
    await esbuild.build(cssBuild);
    await esbuild.build(jsBuild);
    console.log(`Build ${isDev ? 'dev' : 'production'} terminé : assets/dist/css/main.css, assets/dist/js/main.js`);
  }
}

run().catch((err) => {
  console.error(err);
  process.exit(1);
});
