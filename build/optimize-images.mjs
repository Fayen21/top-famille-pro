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
    // Relevé G26 sur ARTICLES[1].photo : le thème servait une autre photo.
    src: 'unsplash-1454165804606-c3d57bc86b40-900.jpg',
    widths: [320, 480, 640],
    alt: 'Poste de travail avec ordinateur (photo d’illustration)',
  },
  {
    slug: 'article-3',
    // Relevé G26 sur ARTICLES[2].photo : le thème servait la photo de la page région.
    src: 'unsplash-1581578731548-c64695cc6952-900.jpg',
    widths: [320, 480, 640],
    alt: 'Bureau avec documents et ordinateur (photo d’illustration)',
  },
  {
    slug: 'service-generic',
    src: 'intervenante-stock-materiel.jpg',
    widths: [480, 760, 960],
    alt: 'Intervention de nettoyage professionnel avec équipement de protection (photo d’illustration)',
  },
  /*
   * G26 — images relevées PAR RÔLE, après le refus de validation du 17 août 2026.
   *
   * Le contrôle précédent comparait le NOMBRE d'images d'une page : trois visuels pouvaient être
   * faux sans que rien ne le signale. L'audit par rôle (tools/audit-images-role.mjs) compare
   * désormais les octets, et ces slots corrigent ce qu'il a trouvé. Tous les fichiers sont ceux
   * du standalone, déjà présents dans le dépôt — rien n'est généré ni approché.
   */
  {
    // Portrait du bloc « Audrey » de l'accueil ET de la bande « Cahier des charges » du pilier :
    // la maquette y pose portrait-stock-01 (800×1007, sha 18af9088…), pas le portrait de
    // /a-propos/ (800×1198). Visuel d'illustration : jamais présenté comme Audrey (CLAUDE.md §5.6).
    slug: 'audrey-portrait',
    src: 'portrait-stock-01.jpg',
    widths: [320, 480, 640],
    alt: 'Photo d’illustration temporaire — portrait définitif à venir',
  },
  {
    // Avatar de la carte de témoignage de l'accueil (44×44 dans la maquette), absent du thème.
    slug: 'avatar-temoignage',
    src: 'avatar-avis-demo.jpg',
    widths: [88, 132],
    alt: '',
  },
  /*
   * Vignettes 56×56 de la bande de maillage du pilier (« Nos six prestations »), relevé G25 :
   * la maquette y pose la photo de CHAQUE prestation en miniature (THUMB_56 — 56 px, rayon 10,
   * cover, alt vide : décoratives, le sens est porté par l'intitulé voisin). Les sources sont
   * les fichiers EXACTS du standalone (SERVICES[].photo, empreintes SHA-256 identiques aux
   * assets du manifeste __bundler). Largeurs 112/168 : un rendu de 56 px jusqu'à 3× de densité —
   * générer plus large serait du poids mort.
   */
  { slug: 'thumb-bureaux', src: 'unsplash-1531973576160-7125cd663d86-800.jpg', widths: [112, 168], alt: '' },
  { slug: 'thumb-commerces', src: 'unsplash-1441986300917-64674bd600d8-800.jpg', widths: [112, 168], alt: '' },
  { slug: 'thumb-cabinets', src: 'unsplash-1497366811353-6870744d04b2-800.jpg', widths: [112, 168], alt: '' },
  { slug: 'thumb-coproprietes', src: 'unsplash-1524758631624-e2822e304c36-800.jpg', widths: [112, 168], alt: '' },
  { slug: 'thumb-meubles', src: 'unsplash-1600585152220-90363fe7e115-800.jpg', widths: [112, 168], alt: '' },
  { slug: 'thumb-ponctuel', src: 'unsplash-1581578731548-c64695cc6952-800.jpg', widths: [112, 168], alt: '' },
  /*
   * Hero des 18 pages de zone : la maquette déclare UNE photo par ville (CITIES[].photo /
   * SECONDARY[].photo). Le thème servait « article-3 » — la même image partout, et pas celle de
   * la maquette. Relevé G26 ville par ville ; les fichiers sont ceux du standalone. Deux d'entre
   * eux n'existent au dépôt qu'en largeur 800 (et non 900) : c'est la MÊME photo, et le pipeline
   * ne suragrandit jamais — la variante la plus large vaut alors 800 px.
   */
  { slug: 'ville-dijon', src: 'unsplash-1497366754035-f200968a6e72-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-besancon', src: 'unsplash-1524758631624-e2822e304c36-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-dole', src: 'unsplash-1497366216548-37526070297c-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-lons-le-saunier', src: 'unsplash-1497215842964-222b430dc094-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-nevers', src: 'unsplash-1541746972996-4e0b0f43e02a-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-vesoul', src: 'unsplash-1556761175-b413da4baf72-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-chalon-sur-saone', src: 'unsplash-1600880292203-757bb62b4baf-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-macon', src: 'unsplash-1497366811353-6870744d04b2-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-auxerre', src: 'unsplash-1531973576160-7125cd663d86-800.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-belfort', src: 'unsplash-1441986300917-64674bd600d8-800.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-saint-apollinaire', src: 'unsplash-1497366811353-6870744d04b2-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-chenove', src: 'unsplash-1524758631624-e2822e304c36-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-quetigny', src: 'unsplash-1441986300917-64674bd600d8-800.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-talant', src: 'unsplash-1497215842964-222b430dc094-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-longvic', src: 'unsplash-1531973576160-7125cd663d86-800.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-fontaine-les-dijon', src: 'unsplash-1600585152220-90363fe7e115-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-marsannay-la-cote', src: 'unsplash-1600880292203-757bb62b4baf-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  { slug: 'ville-beaune', src: 'unsplash-1454165804606-c3d57bc86b40-900.jpg', widths: [480, 760, 960], alt: 'Locaux professionnels (photo d’illustration)' },
  {
    // Hero du pilier /nettoyage-professionnel/ — l'image EXACTE de la maquette (G24) :
    // assets/photos/intervenante-stock-bureaux.jpg est octet pour octet l'asset embarqué du
    // standalone Claude Design (sha256 dbc3d616…, 1000×667). L'alt de la maquette présentait la
    // photo comme un intervenant réel de l'entreprise : interdit (CLAUDE.md §5.6), l'alt honnête
    // dit « photo d'illustration ».
    slug: 'hero-pilier',
    src: 'intervenante-stock-bureaux.jpg',
    widths: [480, 760, 960],
    alt: 'Nettoyage de bureaux professionnels (photo d’illustration)',
  },
  {
    // Hero de la page région — l'image EXACTE de la maquette (G24) :
    // assets/photos/locaux-professionnels-region.jpg, octet pour octet l'asset du standalone
    // (sha256 64547308…, 1000×667). Ce fichier alimente aussi article-3, aux largeurs d'article.
    slug: 'hero-region',
    src: 'locaux-professionnels-region.jpg',
    widths: [480, 760, 960],
    alt: 'Locaux professionnels en Bourgogne-Franche-Comté (photo d’illustration)',
  },
  {
    // Visuel temporaire (accueil + À propos) tant que le portrait authentique d'Audrey n'est pas
    // fourni — jamais présenté comme Audrey (alt honnête défini dans les gabarits, pas ici),
    // CLAUDE.md §5.6. Centralisé sur ce seul slug : remplacer le fichier source suffit.
    slug: 'audrey-placeholder',
    src: 'portrait-stock-a-propos.jpg',
    widths: [320, 480, 640],
    alt: 'Photo d’illustration temporaire — portrait définitif à venir',
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
  // Affiché en clamp(120px, 32vw, 155px) de large (.tfp-logo img, src/css/04-components.css),
  // conformément à la maquette. 320px = 2x la taille d'affichage maximale, pour les écrans à forte
  // densité. Il était auparavant généré à 140px, ce qui correspondait à l'ancien affichage à ~68px
  // de large : après l'agrandissement du logo, Lighthouse signalait à juste titre une image servie
  // en trop basse résolution (« Serves images with low resolution »).
  /*
   * 465 px = TROIS fois la taille d'affichage maximale (G26 §8). 320 px couvrait les écrans à
   * densité 2 mais pas ceux à densité 3, courants sur mobile : le logo — présent sur les 53 pages,
   * et la seule marque visible en haut de chaque écran — y était rendu à partir d'une source deux
   * fois trop petite. La source en fournit 759 ; le fichier reste sous 25 ko.
   */
  await sharp(srcPath)
    .resize({ width: 465 })
    .png({ quality: 90, compressionLevel: 9 })
    .toFile(path.join(OUT_DIR, 'logo-horizontal.png'));
  console.log('  logo-horizontal.png (recompressé, 465px)');

  /*
   * Logo CARRÉ du pied de page (G26). La maquette pose deux logos distincts : l'horizontal dans
   * l'en-tête (155×82) et le carré dans le pied (60×60, rayon 12, object-fit cover). Le thème
   * servait l'horizontal aux deux endroits — relevé par l'audit d'images par rôle, sur les
   * octets. 180 px = trois fois la taille d'affichage, comme le logo de l'en-tête.
   */
  const carre = path.join(ROOT, 'assets', 'logo', 'logo-square.jpg');
  try {
    await stat(carre);
    await sharp(carre).resize({ width: 180, height: 180 }).png({ quality: 90, compressionLevel: 9 }).toFile(path.join(OUT_DIR, 'logo-carre.png'));
    console.log('  logo-carre.png (pied de page, 180px)');
  } catch {
    console.warn('  (logo carré ignoré : assets/logo/logo-square.jpg introuvable)');
  }
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
