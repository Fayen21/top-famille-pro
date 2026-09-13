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

/*
 * Une PLAGE de graisses, pas une liste — et c'est tout le sujet.
 *
 * Les deux familles sont des polices VARIABLES. Demandées poids par poids
 * (`wght@400;500;600;700;800`), Google renvoie quinze déclarations `@font-face` qui pointent
 * toutes vers le **même fichier variable** : trois URL distinctes pour quinze blocs. Le
 * téléchargeur en faisait quinze fichiers de noms différents, et le navigateur en chargeait
 * jusqu'à **sept copies** — 264 Ko sur les 341 Ko de l'accueil, soit 78 % du poids de la page,
 * pour deux polices.
 *
 * Demandées en plage (`wght@400..800`), les mêmes octets arrivent en **un fichier par famille et
 * par sous-ensemble**, avec `font-weight: 400 800`. Le rendu est rigoureusement identique — ce
 * sont les mêmes glyphes, issus du même fichier — mais la page en télécharge deux au lieu de sept.
 */
const FAMILIES = [
  { name: 'Bricolage Grotesque', param: 'Bricolage+Grotesque:wght@400..800', slug: 'bricolage-grotesque', plage: '400 800' },
  { name: 'Hanken Grotesk', param: 'Hanken+Grotesk:wght@400..700', slug: 'hanken-grotesk', plage: '400 700' },
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
    // `font-weight` est ici une PLAGE (« 400 800 ») et non un nombre : c'est la signature d'une
    // police variable, et c'est exactement ce qu'on veut voir arriver.
    const weight = b.match(/font-weight: ([\d ]+);/)?.[1]?.trim();
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
    /*
     * Un fichier par SOUS-ENSEMBLE, pas par graisse. Si Google renvoyait deux URL différentes pour
     * un même sous-ensemble, la famille ne serait pas variable comme attendu : on s'arrête plutôt
     * que de servir silencieusement une police tronquée.
     */
    const parSousEnsemble = new Map();
    for (const entry of entries) {
      if (!parSousEnsemble.has(entry.subset)) parSousEnsemble.set(entry.subset, entry);
      else if (parSousEnsemble.get(entry.subset).url !== entry.url) {
        throw new Error(
          `${fam.name} / ${entry.subset} : deux fichiers distincts pour un même sous-ensemble. ` +
            "La famille n'est pas servie en variable ; revoir le paramètre `param`."
        );
      }
    }
    for (const [subset, entry] of parSousEnsemble) {
      if (entry.weight.indexOf(' ') === -1) {
        throw new Error(
          `${fam.name} / ${subset} : Google a renvoyé une graisse fixe (${entry.weight}) au lieu ` +
            "d'une plage. Le gain de poids serait perdu sans que rien ne le signale."
        );
      }
      const fname = `${fam.slug}-variable-${subset}.woff2`;
      const res = await fetch(entry.url);
      if (!res.ok) throw new Error(`Téléchargement échoué : ${entry.url}`);
      const buf = Buffer.from(await res.arrayBuffer());
      await writeFile(path.join(FONT_DIR, fname), buf);
      allEntries.push({ ...entry, fname });
      console.log(`  ${fname} (${buf.length} octets, graisses ${entry.weight})`);
    }
  }

  const lines = [
    '/**',
    ' * Polices auto-hébergées — Bricolage Grotesque (titres) et Hanken Grotesk (texte).',
    ' * Licence SIL Open Font License 1.1 (Google Fonts). Sous-ensembles latin + latin-ext',
    ' * (vietnamese et cyrillic-ext retirés : hors périmètre du site, allège le poids).',
    ' *',
    " * Un SEUL fichier par famille et par sous-ensemble : ce sont des polices VARIABLES, et toutes",
    ' * les graisses en sortent. Demandées poids par poids, elles produisaient quinze déclarations',
    ' * pointant vers le même fichier, et le navigateur en téléchargeait jusqu\'à sept copies —',
    ' * 264 Ko sur les 341 Ko de l\'accueil. Le rendu est identique, le poids ne l\'est pas.',
    ' *',
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
