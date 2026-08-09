#!/usr/bin/env node
/**
 * Génère les variantes responsives (AVIF, WebP, JPEG) des images utilisées sur l'accueil,
 * à partir des photos provisoires de assets/photos/ (racine du dépôt).
 *
 * Écrit dans wp-content/themes/topfamillepro/assets/dist/images/ et produit
 * assets/dist/images/manifest.json, consommé par includes/images.php (tfp_picture()).
 *
 * Aucune de ces photos n'est réelle : ce sont des visuels de stock provisoires
 * (docs/DONNEES-FICTIVES.md). Elles seront remplacées sans changer les gabarits
 * (même slug, même manifeste).
 *
 * Usage : npm run images
 */
import sharp from 'sharp';
import { mkdir, writeFile, stat } from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.join(__dirname, '..');
const SRC_DIR = path.join(ROOT, 'assets', 'photos');
const OUT_DIR = path.join(ROOT, 'wp-content', 'themes', 'topfamillepro', 'assets', 'dist', 'images');

/**
 * Un slot = un usage sur l'accueil. `widths` doit couvrir le plus grand affichage réel
 * (pas plus : générer des tailles jamais utilisées gonfle le dépôt sans bénéfice).
 */
const SLOTS = [
  {
    slug: 'hero-main',
    src: 'hero-bureaux.jpg',
    widths: [480, 760, 1040, 1200],
    alt: 'Espace de bureaux professionnels, lumineux et rangé (photo d’illustration)',
    lcp: true,
  },
  {
    slug: 'hero-secondary',
    src: 'hero-nettoyage-vitres.jpg',
    widths: [220, 340, 460],
    alt: 'Nettoyage de vitres avec équipement de protection (photo d’illustration)',
  },
  {
    slug: 'service-bureaux',
    src: 'prestation-bureaux.jpg',
    widths: [320, 480, 640],
    alt: 'Nettoyage de bureaux et open-spaces (photo d’illustration)',
  },
  {
    slug: 'service-commerces',
    src: 'prestation-commerces.jpg',
    widths: [320, 480, 640],
    alt: 'Nettoyage de commerces et de surfaces de vente (photo d’illustration)',
  },
  {
    slug: 'article-1',
    src: 'unsplash-1497366216548-37526070297c-900.jpg',
    widths: [320, 480, 640],
    alt: 'Couloir de bureaux et kitchenette (photo d’illustration)',
  },
  {
    slug: 'article-2',
    src: 'unsplash-1497215842964-222b430dc094-900.jpg',
    widths: [320, 480, 640],
    alt: 'Poste de travail avec ordinateur (photo d’illustration)',
  },
  {
    slug: 'article-3',
    src: 'locaux-professionnels-region.jpg',
    widths: [320, 480, 640],
    alt: 'Bureau avec documents et ordinateur (photo d’illustration)',
  },
  {
    slug: 'service-generic',
    src: 'intervenante-stock-materiel.jpg',
    widths: [480, 760, 960],
    alt: 'Intervention de nettoyage professionnel avec équipement de protection (photo d’illustration)',
  },
];

async function ensureDir(dir) {
  await mkdir(dir, { recursive: true });
}

async function processSlot(slot) {
  const srcPath = path.join(SRC_DIR, slot.src);
  try {
    await stat(srcPath);
  } catch {
    throw new Error(`Image source introuvable : ${srcPath}`);
  }

  const image = sharp(srcPath);
  const meta = await image.metadata();
  const variants = { avif: [], webp: [], jpg: [] };

  for (const width of slot.widths) {
    const w = Math.min(width, meta.width || width);

    const avifName = `${slot.slug}-${width}.avif`;
    await sharp(srcPath).resize({ width: w }).avif({ quality: 55 }).toFile(path.join(OUT_DIR, avifName));
    variants.avif.push({ width, file: avifName });

    const webpName = `${slot.slug}-${width}.webp`;
    await sharp(srcPath).resize({ width: w }).webp({ quality: 72 }).toFile(path.join(OUT_DIR, webpName));
    variants.webp.push({ width, file: webpName });

    const jpgName = `${slot.slug}-${width}.jpg`;
    await sharp(srcPath).resize({ width: w }).jpeg({ quality: 78, mozjpeg: true }).toFile(path.join(OUT_DIR, jpgName));
    variants.jpg.push({ width, file: jpgName });
  }

  const maxWidth = Math.max(...slot.widths);
  const naturalHeight = meta.width ? Math.round((meta.height / meta.width) * maxWidth) : null;

  console.log(`  ${slot.slug} ← ${slot.src} (${slot.widths.length} largeurs × 3 formats)`);

  return {
    slug: slot.slug,
    alt: slot.alt,
    lcp: !!slot.lcp,
    width: maxWidth,
    height: naturalHeight,
    variants,
  };
}

/**
 * Le logo n'entre pas dans le pipeline <picture> (utilisé tel quel dans <img> simple, header/
 * footer) : simple recompression PNG, pas de variantes responsives pour un élément aussi petit.
 * Pas de SVG disponible pour l'instant (gap identifié en phase 0, STATUS.md §5) — PNG provisoire.
 */
async function processLogo() {
  const srcPath = path.join(ROOT, 'assets', 'logo', 'logo-horizontal.png');
  try {
    await stat(srcPath);
  } catch {
    console.warn('  (logo ignoré : assets/logo/logo-horizontal.png introuvable)');
    return;
  }
  // Affiché à hauteur fixe 36px (.tfp-logo img, src/css/04-components.css), quel que soit le
  // breakpoint : avec le ratio réel du fichier source (759×402, pas 5:1 comme le laissaient croire
  // d'anciens attributs width/height erronés), ça correspond à ~68px de large. 140px = 2x pour les
  // écrans à forte densité, avec une marge — pas 360px, mesurément inutile (Lighthouse,
  // image-delivery-insight, ~10 Ko gaspillés).
  await sharp(srcPath)
    .resize({ width: 140 })
    .png({ quality: 90, compressionLevel: 9 })
    .toFile(path.join(OUT_DIR, 'logo-horizontal.png'));
  console.log('  logo-horizontal.png (recompressé, 140px)');
}

/**
 * Favicon et icône Open Graph dédiée, à partir du logo carré (assets/logo/logo-square.jpg).
 * Absent jusqu'ici (aucune balise <link rel="icon"> n'était émise) — gap réel identifié lors du
 * hotfix de fidélité production, indépendant du problème de déploiement.
 */
async function processFavicon() {
  const srcPath = path.join(ROOT, 'assets', 'logo', 'logo-square.jpg');
  try {
    await stat(srcPath);
  } catch {
    console.warn('  (favicon ignoré : assets/logo/logo-square.jpg introuvable)');
    return;
  }
  const sizes = [32, 180, 512];
  for (const size of sizes) {
    await sharp(srcPath).resize({ width: size, height: size }).png({ quality: 90 }).toFile(path.join(OUT_DIR, `favicon-${size}.png`));
  }
  // og-image : format 1200×630 recommandé pour un aperçu de partage correct (le logo seul, à
  // 140px, était utilisé jusqu'ici comme image Open Graph — proportions non adaptées).
  await sharp(srcPath)
    .resize({ width: 1200, height: 630, fit: 'cover', position: 'centre' })
    .jpeg({ quality: 82, mozjpeg: true })
    .toFile(path.join(OUT_DIR, 'og-image.jpg'));
  console.log('  favicon-32.png, favicon-180.png, favicon-512.png, og-image.jpg (depuis logo-square.jpg)');
}

async function main() {
  await ensureDir(OUT_DIR);
  const manifest = {};
  for (const slot of SLOTS) {
    manifest[slot.slug] = await processSlot(slot);
  }
  await processLogo();
  await processFavicon();
  const manifestPath = path.join(OUT_DIR, 'manifest.json');
  await writeFile(manifestPath, JSON.stringify(manifest, null, 2));
  console.log(`\nManifeste écrit : ${manifestPath}`);
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
