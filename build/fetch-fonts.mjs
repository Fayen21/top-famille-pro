#!/usr/bin/env node
/**
 * Télécharge et auto-héberge Bricolage Grotesque + Hanken Grotesk depuis l'API officielle
 * Google Fonts (CSS2), sous-ensembles latin + latin-ext uniquement, et régénère
 * src/css/01-fonts.css avec les @font-face correspondants.
 *
 * Usage : npm run fonts
 */
import { mkdir, writeFile } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const THEME_DIR = path.join(__dirname, '..', 'wp-content', 'themes', 'topfamillepro');
const FONT_DIR = path.join(THEME_DIR, 'assets', 'dist', 'fonts');
const CSS_OUT = path.join(THEME_DIR, 'src', 'css', '01-fonts.css');

const FAMILIES = [
  { name: 'Bricolage Grotesque', param: 'Bricolage+Grotesque:wght@400;500;600;700;800', slug: 'bricolage-grotesque' },
  { name: 'Hanken Grotesk', param: 'Hanken+Grotesk:wght@400;500;600;700', slug: 'hanken-grotesk' },
];
const KEEP_SUBSETS = new Set(['latin', 'latin-ext']);
const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36';

async function fetchCss(param) {
  const url = `https://fonts.googleapis.com/css2?family=${param}&display=swap`;
  const res = await fetch(url, { headers: { 'User-Agent': UA } });
  if (!res.ok) throw new Error(`Google Fonts CSS ${res.status} pour ${param}`);
  return res.text();
}

function parseBlocks(css, familyName) {
  const blocks = css.split(/(?=\/\* )/).map((b) => b.trim()).filter(Boolean);
  const parsed = [];
  for (const b of blocks) {
    const subsetMatch = b.match(/\/\* ([\w-]+) \*\//);
    if (!subsetMatch || !KEEP_SUBSETS.has(subsetMatch[1])) continue;
    const weight = b.match(/font-weight: (\d+)/)?.[1];
    const url = b.match(/url\((https:\/\/[^)]+)\)/)?.[1];
    const unicodeRange = b.match(/unicode-range: ([^;]+);/)?.[1];
    if (!weight || !url || !unicodeRange) continue;
    parsed.push({ family: familyName, subset: subsetMatch[1], weight, url, unicodeRange });
  }
  return parsed;
}

async function main() {
  await mkdir(FONT_DIR, { recursive: true });
  const allEntries = [];

  for (const fam of FAMILIES) {
    const css = await fetchCss(fam.param);
    const entries = parseBlocks(css, fam.name);
    for (const entry of entries) {
      const fname = `${fam.slug}-${entry.weight}-${entry.subset}.woff2`;
      const res = await fetch(entry.url);
      if (!res.ok) throw new Error(`Téléchargement échoué : ${entry.url}`);
      const buf = Buffer.from(await res.arrayBuffer());
      await writeFile(path.join(FONT_DIR, fname), buf);
      allEntries.push({ ...entry, fname });
      console.log(`  ${fname} (${buf.length} octets)`);
    }
  }

  const lines = [
    '/**',
    ' * Polices auto-hébergées — Bricolage Grotesque (titres) et Hanken Grotesk (texte).',
    ' * Licence SIL Open Font License 1.1 (Google Fonts). Sous-ensembles latin + latin-ext',
    ' * (vietnamese et cyrillic-ext retirés : hors périmètre du site, allège le poids).',
    ' * Fichiers : assets/dist/fonts/. Re-générer via `npm run fonts`.',
    ' */',
    '',
  ];
  for (const e of allEntries) {
    lines.push('@font-face {');
    lines.push(`  font-family: '${e.family}';`);
    lines.push('  font-style: normal;');
    lines.push(`  font-weight: ${e.weight};`);
    lines.push('  font-display: swap;');
    lines.push(`  src: url('../fonts/${e.fname}') format('woff2');`);
    lines.push(`  unicode-range: ${e.unicodeRange};`);
    lines.push('}');
  }
  lines.push('');
  await writeFile(CSS_OUT, lines.join('\n'));
  console.log(`\n${allEntries.length} fichiers de police écrits dans ${FONT_DIR}`);
  console.log(`CSS régénéré : ${CSS_OUT}`);
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
