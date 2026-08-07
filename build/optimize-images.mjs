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
  await sharp(srcPath)
    .resize({ width: 360 }) // 2x la taille d'affichage max (180px) pour les écrans à forte densité.
    .png({ quality: 90, compressionLevel: 9 })
    .toFile(path.join(OUT_DIR, 'logo-horizontal.png'));
  console.log('  logo-horizontal.png (recompressé, 360px)');
}

async function main() {
  await ensureDir(OUT_DIR);
  const manifest = {};
  for (const slot of SLOTS) {
    manifest[slot.slug] = await processSlot(slot);
  }
  await processLogo();
  const manifestPath = path.join(OUT_DIR, 'manifest.json');
  await writeFile(manifestPath, JSON.stringify(manifest, null, 2));
  console.log(`\nManifeste écrit : ${manifestPath}`);
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
