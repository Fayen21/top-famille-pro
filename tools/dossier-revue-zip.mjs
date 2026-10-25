#!/usr/bin/env node
/**
 * Dossier de revue HORS LIGNE — corrections après revue des trois ZIP (25 octobre 2026, §10).
 *
 * Deux volumes, chacun une archive autonome (aucune ressource externe, aucun script, aucun chemin
 * absolu) que tools/verifier-dossier-hors-ligne.mjs extrait dans un répertoire neuf et éprouve
 * réseau coupé :
 *   1. avant / après — les 44 vues de tools/captures-corrections.mjs, côte à côte ;
 *   2. revue des 53 routes — les 110 pleines pages de tools/revue-visuelle.mjs (375 et 1440 px,
 *      plus le menu ouvert et l'étape 2 du devis).
 *
 * Chaque vue a sa page, reliée à la suivante (« suivant → ») depuis l'index. Les captures sont
 * COPIÉES, jamais régénérées ici : le dossier montre exactement ce que les outils ont produit.
 *
 * Usage : node tools/dossier-revue-zip.mjs [--date=2026-10-25]
 *   → release/dossier-revue-zip-<date>-volume-{1,2}-*.zip + SHA256SUMS-dossier-revue-zip.txt
 */
import { copyFileSync, existsSync, mkdirSync, mkdtempSync, readdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { execFileSync } from 'node:child_process';
import { createHash } from 'node:crypto';
import os from 'node:os';
import path from 'node:path';

const DATE = (process.argv.find((a) => a.startsWith('--date=')) || '--date=2026-10-25').split('=')[1];
const HEAD = execFileSync('git', [ 'rev-parse', '--short', 'HEAD' ]).toString().trim();
const RELEASE = path.resolve('release');

const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
const STYLE = `body{font:15px/1.5 system-ui,sans-serif;margin:0;color:#10233a;background:#f4f7f9}
header,main,nav{max-width:1500px;margin:0 auto;padding:16px}
h1{font-size:22px;margin:0 0 4px}h2{font-size:18px;margin:24px 0 8px}
.meta{color:#4a5d70;font-size:13px}
.grille{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px}
.grille a{display:block;background:#fff;border:1px solid #d5e0e8;border-radius:8px;padding:8px;color:#174a81;text-decoration:none}
.grille img{width:100%;height:160px;object-fit:cover;object-position:top;border-radius:4px;background:#e8eef2}
.paire{display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start}
.paire figure{margin:0;background:#fff;border:1px solid #d5e0e8;border-radius:8px;padding:8px}
.paire img,.seule img{max-width:100%;height:auto;display:block;margin:0 auto}
figcaption{font-weight:700;margin-bottom:6px}
nav{display:flex;justify-content:space-between;gap:12px}nav a{color:#174a81}`;

function page(titre, corps, nav = '') {
	return `<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>${esc(titre)}</title><style>${STYLE}</style></head><body>${nav}${corps}${nav}</body></html>\n`;
}

/** Construit un volume : `vues` = [{ slug, titre, sousTitre, images: [{ src, legende }] }]. */
function volume(nom, titre, intro, vues) {
	const tmp = mkdtempSync(path.join(os.tmpdir(), 'dossier-revue-'));
	const racine = path.join(tmp, nom);
	mkdirSync(path.join(racine, 'captures'), { recursive: true });
	const fichier = (i) => `${String(i + 1).padStart(3, '0')}-${vues[i].slug}.html`;

	vues.forEach((v, i) => {
		const imgs = v.images.map((im, k) => {
			// Avant et après portent le même nom de fichier : l'indice les distingue.
			const cible = `${v.slug}--${k}-${path.basename(im.src)}`;
			copyFileSync(im.src, path.join(racine, 'captures', cible));
			return { ...im, cible };
		});
		v.vignette = imgs[imgs.length - 1].cible;
		const prec = i > 0 ? `<a href="${fichier(i - 1)}">← précédent</a>` : '<span></span>';
		const suiv = i < vues.length - 1 ? `<a href="${fichier(i + 1)}">suivant →</a>` : '<span></span>';
		const nav = `<nav>${prec}<a href="index.html">index</a>${suiv}</nav>`;
		const figures = imgs.map((im) => `<figure><figcaption>${esc(im.legende)}</figcaption><img src="captures/${esc(im.cible)}" alt="${esc(`${v.titre} — ${im.legende}`)}"></figure>`).join('');
		writeFileSync(path.join(racine, fichier(i)), page(v.titre, `<main><h1>${esc(v.titre)}</h1><p class="meta">${esc(v.sousTitre)}</p><div class="${imgs.length > 1 ? 'paire' : 'seule'}">${figures}</div></main>`, nav));
	});

	const tuiles = vues.map((v, i) => `<a href="${fichier(i)}"><img src="captures/${esc(v.vignette)}" alt="">${esc(v.titre)}<br><span class="meta">${esc(v.sousTitre)}</span></a>`).join('');
	writeFileSync(path.join(racine, 'index.html'), page(titre, `<header><h1>${esc(titre)}</h1><p class="meta">Commit ${esc(HEAD)} · ${esc(DATE)} · ${vues.length} vues · ouvrir une vue puis « suivant → »</p>${intro}</header><main><div class="grille">${tuiles}</div></main>`));

	const zip = path.join(RELEASE, `${nom}.zip`);
	rmSync(zip, { force: true });
	execFileSync('zip', [ '-q', '-r', '-X', zip, nom ], { cwd: tmp });
	rmSync(tmp, { recursive: true, force: true });
	return zip;
}

/* Volume 1 — avant / après. */
const AVANT = 'docs/captures-corrections/avant';
const APRES = 'docs/captures-corrections/apres';
const bilan = JSON.parse(readFileSync(path.join(APRES, 'bilan.json'), 'utf8'));
const pairs = readdirSync(APRES).filter((f) => f.endsWith('.png')).sort().map((f) => {
	const cle = f.replace(/\.png$/, '');
	const b = bilan[cle] || {};
	const images = [];
	if (existsSync(path.join(AVANT, f))) images.push({ src: path.join(AVANT, f), legende: 'Avant — 7955f64' });
	images.push({ src: path.join(APRES, f), legende: `Après — ${HEAD}` });
	return { slug: cle, titre: cle, sousTitre: `${b.route || ''} · ${b.largeur || ''} px · capture ${b.mode || ''}`, images };
});
const intro1 = '<p>Captures « composant » : en-tête collant remis dans le flux et barre d’action mobile masquée, pour que rien ne traverse l’image. Captures « fenêtre » : comportement réel des couches fixes. Images toutes chargées et décodées avant capture (tools/lib/capture-fiable.mjs).</p>';

/* Volume 2 — revue des 53 routes. */
const REVUE = 'docs/revue-visuelle';
const routes = readdirSync(REVUE).filter((f) => f.endsWith('.jpg')).sort().map((f) => {
	const cle = f.replace(/\.jpg$/, '');
	return { slug: cle.replace(/__/g, '-'), titre: cle.replace(/__/g, '/'), sousTitre: 'pleine page, FAQ et volets dépliés', images: [ { src: path.join(REVUE, f), legende: cle } ] };
});
const intro2 = '<p>Les 53 routes à 375 et 1440 px, plus le menu ouvert de l’accueil et l’étape 2 du devis. Relevé automatique : docs/REVUE-VISUELLE.md.</p>';

const zips = [
	volume(`dossier-revue-zip-${DATE}-volume-1-avant-apres`, 'Revue des trois ZIP — avant / après', intro1, pairs),
	volume(`dossier-revue-zip-${DATE}-volume-2-53-routes`, 'Revue des trois ZIP — 53 routes à 375 et 1440 px', intro2, routes),
];

const sommes = zips.map((z) => `${createHash('sha256').update(readFileSync(z)).digest('hex')}  ${path.basename(z)}`).join('\n') + '\n';
writeFileSync(path.join(RELEASE, 'SHA256SUMS-dossier-revue-zip.txt'), sommes);
process.stdout.write(sommes);
