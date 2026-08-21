#!/usr/bin/env node
/**
 * Dossier de validation humaine — G28.
 *
 * ## Ce que cet outil produit, et pourquoi il repart de zéro
 *
 * Les dossiers G25 et G26 sont périmés : ils montrent un site qui a changé depuis. Toutes les
 * captures présentées ici sont donc REFAITES depuis l'état servi du banc, jamais recopiées d'une
 * passe antérieure. Un dossier de validation qui mélangerait deux états ferait valider des pages
 * qui n'existent plus.
 *
 * Trois volumes, chacun autonome et navigable hors ligne :
 *   1. prioritaire — les quatorze cibles demandées, plus le rapport, la fiche de décision et le
 *      mode d'emploi ;
 *   2. pages — prestations, index, institutionnelles, articles et pages légales restantes ;
 *   3. zones — départements, villes et communes.
 *
 * ## Contraintes d'un dossier hors ligne, tenues par construction
 *
 * Aucune ressource externe : pas de police distante, pas de script, pas de feuille de style liée.
 * Aucun chemin absolu : toutes les références sont relatives au volume. Aucune URL de banc : les
 * routes sont affichées comme du texte, jamais comme des liens cliquables — un lien vers
 * `localhost` dans un dossier envoyé par courriel est un lien mort qui donne l'air d'un défaut.
 *
 * ## Ce que cet outil ne fait pas
 *
 * Il ne valide rien. Le statut de chaque page est « À VALIDER », sans exception et sans valeur par
 * défaut modifiable. Les écarts connus sont écrits à côté de la capture pour être jugés, pas pour
 * excuser d'avance.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/dossier-g28.mjs [--only=prioritaire]
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync, readFileSync, rmSync, existsSync } from 'node:fs';
import path from 'node:path';
import sharp from 'sharp';
import { panneauDifference } from './lib/diff-visuel.mjs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const RACINE = 'docs/dossier-g28';
const LARGEURS = [ 375, 1440 ];
const COMMIT = 'f917741';

/* ------------------------------------------------------------------ cibles */

/**
 * Les quatorze cibles prioritaires, dans l'ordre du parcours de relecture.
 *
 * `zoom` désigne une BANDE et non une page : la bande des six vignettes du pilier est illisible
 * sur un triptyque pleine page — à 520 px de panneau, une vignette de 56 px en fait sept.
 */
const PRIORITAIRES = [
	{ id: 'accueil', libelle: 'Accueil', ref: '#/', wp: '/', note: '' },
	{ id: 'prestation-bureaux', libelle: 'Prestation — nettoyage de bureaux', ref: '#/service/bureaux', wp: '/prestations/bureaux/', note: '' },
	{ id: 'ville-dijon', libelle: 'Ville — Dijon', ref: '#/ville/dijon', wp: '/zones-intervention/cote-dor/dijon/', note: '' },
	{ id: 'tarifs', libelle: 'Tarifs', ref: '#/nos-tarifs', wp: '/tarifs/', note: 'La note Google reste masquée : aucune fiche officielle vérifiée n’a été fournie.' },
	{ id: 'formulaire-etape-1', libelle: 'Formulaire de devis — étape 1', ref: '#/demande-de-devis', wp: '/demande-de-devis/', note: 'Les différences de champs restantes sont listées dans le rapport ; ce dossier n’affirme pas « mêmes champs ».' },
	{ id: 'formulaire-etape-2', libelle: 'Formulaire de devis — étape 2', ref: '#/demande-de-devis', wp: '/demande-de-devis/', etape: 2, note: 'Étape 2 atteinte des deux côtés avant capture, avec les mêmes valeurs saisies. Le champ « prestation concernée » est un ajout obligatoire, absent de la maquette.' },
	{ id: 'article-frequence-bureaux', libelle: 'Article — fréquence de nettoyage', ref: '#/article/frequence-bureaux', wp: '/conseils/frequence-bureaux/', note: '' },
	{ id: 'mentions-legales', libelle: 'Mentions légales', ref: '#/mentions-legales', wp: '/mentions-legales/', note: 'Hors plage de hauteur, assumé : les mentions ont dû être réécrites et non recopiées, le contenu réglementaire est plus long que celui de la maquette.' },
	{ id: 'pilier', libelle: 'Page pilier — nettoyage professionnel', ref: '#/nettoyage-professionnel', wp: '/nettoyage-professionnel/', note: '' },
	{ id: 'pilier-bande-vignettes', libelle: 'Zoom — bande des six vignettes du pilier', ref: '#/nettoyage-professionnel', wp: '/nettoyage-professionnel/', zoom: 'bandeVignettes', note: 'Comparaison rapprochée : sur un triptyque pleine page, ces vignettes de 56 px seraient réduites à sept pixels.' },
	{ id: 'region', libelle: 'Page région — Bourgogne-Franche-Comté', ref: '#/bourgogne-franche-comte', wp: '/zones-intervention/bourgogne-franche-comte/', note: '' },
	{ id: 'a-propos', libelle: 'À propos', ref: '#/a-propos', wp: '/a-propos/', note: 'Le portrait est une illustration provisoire, signalée comme telle sur la page. La citation attribuée à Audrey reste à valider par l’intéressée.' },
	{ id: 'recrutement', libelle: 'Recrutement', ref: '#/recrutement', wp: '/recrutement/', note: 'La candidature renvoie au site carrière existant : aucun formulaire de candidature ni collecte de CV sur le site.' },
	{ id: 'avis-clients', libelle: 'Avis clients', ref: '#/avis-clients', wp: '/avis-clients/', note: 'Témoignages repris de la maquette, marqués provisoires et exclus de toute donnée structurée d’avis. Hors plage de hauteur à 1 440 px, décomposé dans le rapport.' },
];

const IDS_PRIORITAIRES = new Set([ '#/', '#/service/bureaux', '#/ville/dijon', '#/nos-tarifs', '#/demande-de-devis', '#/article/frequence-bureaux', '#/mentions-legales', '#/nettoyage-professionnel', '#/bourgogne-franche-comte', '#/a-propos', '#/recrutement', '#/avis-clients' ]);

/** Les volumes complémentaires : tout le reste des 53 routes, réparti par famille. */
const FAMILLES_ZONES = new Set([ 'departement', 'ville', 'commune', 'hub-zones' ]);

function complementaires() {
	const pages = [];
	const zones = [];
	for (const [ ref, o ] of Object.entries(ROUTE_MAP)) {
		if (IDS_PRIORITAIRES.has(ref)) continue;
		const cible = { id: ref.replace(/^#\//, '').replace(/\//g, '-') || 'accueil', libelle: `${o.type} — ${o.wp}`, ref, wp: o.wp, note: '' };
		(FAMILLES_ZONES.has(o.type) ? zones : pages).push(cible);
	}
	return { pages, zones };
}

/* ------------------------------------------------------------- instruments */

const FREEZE = `*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
header,.tfp-header,[data-tfp-header],[style*="position:sticky"],[style*="position: sticky"]{position:static!important}`;

const ZOOMS = {
	bandeVignettes: () => {
		const h = [ ...document.querySelectorAll('h2') ].find((x) => /Nos six prestations/.test(x.textContent || ''));
		return h ? h.closest('section') : null;
	},
};

async function stabiliser(page) {
	await page.addStyleTag({ content: FREEZE }).catch(() => {});
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += 700) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 55));
		}
		window.scrollTo(0, 0);
	});
	await page.waitForFunction(() => [ ...document.images ].every((i) => i.complete), null, { timeout: 20000 }).catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(280);
}

/** Remplit et franchit l'étape 1 des DEUX côtés — la maquette contrôle en `aria-required`. */
async function passerEtape2(page) {
	await page.evaluate(() => {
		const f = document.querySelector('form');
		if (!f) return;
		const valeurs = { ville: 'Dijon', code_postal: '21000', nom: 'Test', telephone: '06 00 00 00 00', email: 'test@example.fr' };
		f.querySelectorAll('input, select, textarea').forEach((el) => {
			const r = el.getBoundingClientRect();
			if (el.type === 'hidden' || r.left < -1000 || r.width === 0) return;
			if (el.name === 'tfp_site_web') return;
			if (el.tagName === 'SELECT') {
				const o = [ ...el.options ].find((x) => x.value !== '' && x.textContent.trim() !== 'Choisir…');
				if (o && el.value === '') el.value = o.value;
			} else if (el.type === 'checkbox') {
				el.checked = true;
			} else if (!el.value) {
				el.value = valeurs[el.name] || 'Test';
			}
			el.dispatchEvent(new Event('input', { bubbles: true }));
			el.dispatchEvent(new Event('change', { bubbles: true }));
		});
		const next = f.querySelector('[data-step-next]') || [ ...f.querySelectorAll('button') ].find((b) => /continuer/i.test(b.textContent || ''));
		if (next) next.click();
	});
	await page.waitForTimeout(900);
}

async function capturer(page, zoom) {
	if (!zoom) return page.screenshot({ fullPage: true });
	const boite = await page.evaluate((fn) => {
		// eslint-disable-next-line no-eval
		const el = eval(fn)();
		if (!el) return null;
		el.scrollIntoView();
		const r = el.getBoundingClientRect();
		return { x: Math.max(0, r.x), y: r.y + window.scrollY, width: r.width, height: r.height };
	}, `(${ ZOOMS[zoom].toString() })`);
	if (!boite || boite.width < 2) return null;
	return page.screenshot({ clip: boite, fullPage: true });
}

/**
 * Triptyque autoportant : un bandeau GRAVÉ nomme la route, la largeur et les trois panneaux.
 *
 * Gravé, et non écrit dans la page HTML voisine : une capture sortie du dossier — glissée dans un
 * courriel, imprimée — doit rester interprétable seule. Un triptyque anonyme est un piège.
 */
async function triptyque(refBuf, wpBuf, sortie, { route, largeur, panneau }) {
	const [ ab, bb ] = await Promise.all([
		sharp(refBuf).resize({ width: panneau }).png().toBuffer(),
		sharp(wpBuf).resize({ width: panneau }).png().toBuffer(),
	]);
	const { png: diff, hauteur: H, pourcentage, amplification } = await panneauDifference(ab, bb);

	const ecart = 8;
	const L = panneau * 3 + ecart * 2;
	const BANDEAU = 54;

	const pad = (buf) =>
		sharp({ create: { width: panneau, height: H, channels: 3, background: '#ffffff' } })
			.composite([ { input: buf, top: 0, left: 0 } ])
			.png()
			.toBuffer();
	const [ ap, bp ] = await Promise.all([ pad(ab), pad(bb) ]);

	const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	/*
	 * Deux lignes SÉPARÉES, et non deux textes sur la même : la route et les métadonnées se
	 * chevauchaient dès qu'un libellé dépassait la moitié d'une colonne, et l'étiquette de la
	 * première colonne finissait par-dessus le taux. Ligne 1 : ce qui est comparé et comment.
	 * Ligne 2 : le nom de chaque colonne, calé sur le bord gauche de la colonne qu'il désigne.
	 */
	const bandeau = Buffer.from(
		`<svg width="${L}" height="${BANDEAU}" xmlns="http://www.w3.org/2000/svg">
			<rect width="${L}" height="${BANDEAU}" fill="#16202B"/>
			<text x="10" y="20" font-family="sans-serif" font-size="13" font-weight="bold" fill="#ffffff">${esc(route)}</text>
			<text x="${L - 10}" y="20" text-anchor="end" font-family="sans-serif" font-size="12" fill="#9FB0B8">largeur ${largeur} px · amplification ×${amplification} · ${pourcentage.toFixed(2)} % des pixels s'écartent</text>
			<rect x="0" y="30" width="${L}" height="1" fill="#2C3B48"/>
			<text x="10" y="47" font-family="sans-serif" font-size="11.5" letter-spacing="1" fill="#7F9096">MAQUETTE CLAUDE DESIGN</text>
			<text x="${panneau + ecart + 10}" y="47" font-family="sans-serif" font-size="11.5" letter-spacing="1" fill="#7F9096">RENDU WORDPRESS</text>
			<text x="${(panneau + ecart) * 2 + 10}" y="47" font-family="sans-serif" font-size="11.5" letter-spacing="1" fill="#7F9096">DIFFÉRENCE AMPLIFIÉE</text>
		</svg>`
	);

	await sharp({ create: { width: L, height: H + BANDEAU, channels: 3, background: '#d0d0d0' } })
		.composite([
			{ input: bandeau, top: 0, left: 0 },
			{ input: ap, top: BANDEAU, left: 0 },
			{ input: bp, top: BANDEAU, left: panneau + ecart },
			{ input: diff, top: BANDEAU, left: (panneau + ecart) * 2 },
		])
		.jpeg({ quality: 76, mozjpeg: true })
		.toFile(sortie);

	return { pourcentage, amplification };
}

/* ------------------------------------------------------- pages du dossier */

/* Feuille de style du dossier : ÉCRITE DANS CHAQUE PAGE, jamais liée.
   Un dossier hors ligne ne peut dépendre d'aucun fichier voisin qu'un extracteur pourrait
   oublier, ni d'aucune police distante. Familles système uniquement. */
const CSS = `
:root{--papier:#F2F4F3;--papier2:#E7EBE9;--encre:#16202B;--encre2:#43545E;--encre3:#6B7C84;
--accent:#0F6E5C;--accent-pale:#DCE9E5;--alerte:#A8452B;--alerte-pale:#F2E2DC;--filet:#D3D9D7}
*{box-sizing:border-box}
body{margin:0;background:var(--papier);color:var(--encre);
font-family:system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
font-size:16px;line-height:1.6}
.env{max-width:1180px;margin-inline:auto;padding:28px 22px 72px}
a{color:var(--accent)}
h1{font-size:clamp(1.6rem,4vw,2.3rem);line-height:1.15;margin:0 0 10px;letter-spacing:-.01em}
h2{font-size:1.15rem;margin:34px 0 12px;padding-top:12px;border-top:1px solid var(--filet)}
p{margin:0 0 12px;max-width:74ch}
.sur{font-size:12px;letter-spacing:.13em;text-transform:uppercase;color:var(--encre3);margin:0 0 12px}
.statut{display:inline-block;border:1px solid var(--alerte);background:var(--alerte-pale);
color:var(--alerte);font-size:12px;letter-spacing:.1em;text-transform:uppercase;padding:5px 11px;
font-weight:600}
.nav{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin:20px 0;
padding:12px 0;border-top:1px solid var(--filet);border-bottom:1px solid var(--filet)}
.nav a,.nav span{font-size:14px;padding:7px 13px;border:1px solid var(--filet);
text-decoration:none;color:var(--encre);background:#fff;min-height:34px;display:inline-flex;
align-items:center}
.nav a:hover{border-color:var(--accent);color:var(--accent)}
.nav .off{color:var(--encre3);background:var(--papier2)}
.nav .pos{border:0;background:none;color:var(--encre3);margin-left:auto;font-variant-numeric:tabular-nums}
.shot{display:block;width:100%;height:auto;border:1px solid var(--filet);background:#fff;margin:16px 0}
.meta{border:1px solid var(--filet);background:#fff;margin:16px 0}
.meta table{border-collapse:collapse;width:100%;font-size:14px}
.meta td,.meta th{padding:9px 13px;border-bottom:1px solid var(--filet);text-align:left;vertical-align:top}
.meta tr:last-child td,.meta tr:last-child th{border-bottom:0}
.meta th{width:230px;font-weight:600;color:var(--encre2);background:var(--papier2)}
.note{border-left:2px solid var(--accent);padding-left:16px;margin:16px 0;color:var(--encre2);font-size:15px}
.liste{list-style:none;padding:0;margin:16px 0;border:1px solid var(--filet)}
.liste li{border-bottom:1px solid var(--filet);background:#fff}
.liste li:last-child{border-bottom:0}
.liste a{display:flex;gap:14px;align-items:baseline;padding:12px 15px;text-decoration:none;color:var(--encre)}
.liste a:hover{background:var(--accent-pale)}
.liste .r{font-size:13px;color:var(--encre3);margin-left:auto;font-variant-numeric:tabular-nums;text-align:right}
.liste .i{font-size:12px;color:var(--encre3);font-variant-numeric:tabular-nums;min-width:2.2em}
code{font-family:ui-monospace,Menlo,Consolas,monospace;font-size:.88em;background:var(--papier2);padding:.1em .35em}
.grille{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1px;background:var(--filet);
border:1px solid var(--filet);margin:22px 0}
.grille div{background:#fff;padding:14px}
.grille b{display:block;font-size:1.5rem;font-variant-numeric:tabular-nums;line-height:1}
.grille span{display:block;margin-top:6px;font-size:12.5px;color:var(--encre3)}
.pied{margin-top:48px;padding-top:16px;border-top:1px solid var(--filet);font-size:12.5px;color:var(--encre3)}
`;

const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

const page = (titre, corps) =>
	`<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>${esc(titre)}</title>
<style>${CSS}</style>
</head>
<body>
<div class="env">
${corps}
<p class="pied">Dossier de validation G28 · état du commit ${COMMIT} · toutes les captures régénérées depuis cet état · aucune ressource externe</p>
</div>
</body>
</html>
`;

/** Page d'une capture, avec navigation précédent / suivant dans le volume. */
function pageCapture(item, rang, total, volume) {
	const prec = rang > 0 ? volume.items[rang - 1] : null;
	const suiv = rang < total - 1 ? volume.items[rang + 1] : null;
	const nav = `<nav class="nav">
	<a href="index.html">↑ Sommaire du volume</a>
	${ prec ? `<a href="${esc(prec.fichierHtml)}">← ${esc(prec.libelle)} · ${prec.largeur} px</a>` : '<span class="off">← début du volume</span>' }
	${ suiv ? `<a href="${esc(suiv.fichierHtml)}">${esc(suiv.libelle)} · ${suiv.largeur} px →</a>` : '<span class="off">fin du volume →</span>' }
	<span class="pos">${rang + 1} / ${total}</span>
</nav>`;

	return page(
		`${item.libelle} — ${item.largeur} px`,
		`<p class="sur">Volume ${esc(volume.titre)}</p>
<h1>${esc(item.libelle)}</h1>
<p><span class="statut">Statut : à valider</span></p>
${nav}
<img class="shot" src="captures/${esc(item.fichierImg)}" alt="Comparaison ${esc(item.libelle)} à ${item.largeur} px : maquette Claude Design, rendu WordPress, et panneau de différence amplifié.">
<div class="meta">
<table>
<tr><th>Route maquette</th><td><code>${esc(item.ref)}</code></td></tr>
<tr><th>Route WordPress</th><td><code>${esc(item.wp)}</code></td></tr>
<tr><th>Largeur de rendu</th><td>${item.largeur} px</td></tr>
<tr><th>Panneau de gauche</th><td>Maquette Claude Design</td></tr>
<tr><th>Panneau du milieu</th><td>Rendu WordPress</td></tr>
<tr><th>Panneau de droite</th><td>Différence amplifiée</td></tr>
<tr><th>Facteur d’amplification</th><td>×${item.amplification}</td></tr>
<tr><th>Taux de pixels différents</th><td>${item.pourcentage.toFixed(2)} %</td></tr>
<tr><th>Statut</th><td><strong>À VALIDER</strong></td></tr>
</table>
</div>
${ item.note ? `<div class="note"><p>${esc(item.note)}</p></div>` : '' }
<div class="note"><p><strong>Comment lire le taux.</strong> C’est la proportion de pixels dont l’écart de luminance dépasse le seuil de perception — pas un score de fidélité. Une page plus longue d’un côté colorie toute la zone manquante, et un décalage vertical colorie tout ce qui suit. Il sert à repérer où regarder.</p></div>
${nav}`
	);
}

/** Sommaire d'un volume. */
function pageIndex(volume, volumes) {
	const lignes = volume.items
		.map(
			(it, i) =>
				`<li><a href="${esc(it.fichierHtml)}"><span class="i">${String(i + 1).padStart(2, '0')}</span><span>${esc(it.libelle)}</span><span class="r">${it.largeur} px · ${it.pourcentage.toFixed(2)} %</span></a></li>`
		)
		.join('\n');

	const autres = volumes
		.filter((v) => v.id !== volume.id)
		.map((v) => `<li><a href="../${esc(v.dossier)}/index.html"><span class="i">▸</span><span>Volume ${esc(v.titre)}</span><span class="r">${v.items.length} comparaisons</span></a></li>`)
		.join('\n');

	const docs = volume.id === 'prioritaire'
		? `<h2>Documents joints</h2>
<ul class="liste">
<li><a href="fiche-de-decision.html"><span class="i">◆</span><span>Fiche de décision — toutes les pages à valider</span><span class="r">à remplir</span></a></li>
<li><a href="rapport-g27.html"><span class="i">◆</span><span>Rapport de clôture G27</span><span class="r">mesures</span></a></li>
<li><a href="LISEZ-MOI.txt"><span class="i">◆</span><span>LISEZ-MOI.txt</span><span class="r">mode d’emploi</span></a></li>
</ul>`
		: '';

	return page(
		`Volume ${volume.titre} — validation G28`,
		`<p class="sur">Dossier de validation humaine · G28 · commit ${COMMIT}</p>
<h1>Volume ${esc(volume.titre)}</h1>
<p>${esc(volume.chapo)}</p>
<div class="grille">
<div><b>${volume.items.length}</b><span>comparaisons dans ce volume</span></div>
<div><b>${new Set(volume.items.map((i) => i.id)).size}</b><span>pages ou bandes</span></div>
<div><b>375 · 1440</b><span>largeurs de rendu</span></div>
<div><b>À VALIDER</b><span>statut de chaque page</span></div>
</div>
${docs}
<h2>Comparaisons</h2>
<ul class="liste">
${lignes}
</ul>
<h2>Autres volumes</h2>
<p>Les volumes sont indépendants. S’ils sont extraits côte à côte dans le même répertoire, les liens ci-dessous fonctionnent ; sinon, ouvrez le fichier <code>index.html</code> du volume voulu.</p>
<ul class="liste">
${autres}
</ul>`
	);
}

/**
 * Fiche de décision — un statut par page, tous « À VALIDER ».
 *
 * Aucune case n'est pré-cochée et aucun statut n'est proposé : une fiche qui suggérerait
 * « conforme » ferait valider par défaut ce qu'elle prétend soumettre au jugement.
 */
function pageFiche(volumes) {
	const parPage = new Map();
	for (const v of volumes) {
		for (const it of v.items) {
			if (!parPage.has(it.id)) parPage.set(it.id, { libelle: it.libelle, wp: it.wp, volume: v, largeurs: [] });
			parPage.get(it.id).largeurs.push(it);
		}
	}
	const lignes = [ ...parPage.entries() ]
		.map(([ id, p ]) => {
			const liens = p.largeurs
				.map((it) => `<a href="${ p.volume.id === 'prioritaire' ? '' : `../${p.volume.dossier}/` }${esc(it.fichierHtml)}">${it.largeur} px</a>`)
				.join(' · ');
			return `<tr><td><strong>${esc(p.libelle)}</strong><br><code>${esc(p.wp)}</code></td><td>${liens}</td><td><strong>À VALIDER</strong></td><td></td></tr>`;
		})
		.join('\n');

	return page(
		'Fiche de décision — validation G28',
		`<p class="sur">Dossier de validation humaine · G28 · commit ${COMMIT}</p>
<h1>Fiche de décision</h1>
<p>Chaque page du site est présentée au statut <strong>À VALIDER</strong>. Aucune n’est validée d’avance, et aucun statut n’est proposé : ce dossier soumet des captures au jugement, il ne le devance pas.</p>

<h2>Réponse attendue</h2>
<p>La réponse doit prendre exactement l’une de ces deux formes :</p>
<div class="meta"><table>
<tr><th>Tout est conforme</th><td><code>Validé</code></td></tr>
<tr><th>Un défaut est constaté</th><td><code>Refusé : page — défaut constaté</code></td></tr>
</table></div>
<p>Un refus peut porter sur plusieurs pages : une ligne par page refusée. Ce qui n’est pas nommé est considéré comme non encore jugé, jamais comme accepté.</p>

<h2>Ce qui n’est pas soumis à cette validation</h2>
<div class="note">
<p>Trois éléments ont été retirés des bloqueurs sur décision du 20 août et ne doivent pas être jugés ici : la citation attribuée à Audrey, sa photo provisoire, et l’URL, la note et le nombre d’avis Google. La note Google reste masquée, conformément à l’état actuel.</p>
</div>

<h2>Pages soumises</h2>
<div class="meta"><table>
<tr><th style="width:auto">Page</th><th style="width:150px;background:var(--papier2)">Comparaisons</th><th style="width:130px;background:var(--papier2)">Statut</th><th style="width:210px;background:var(--papier2)">Défaut constaté</th></tr>
${lignes}
</table></div>

<h2>Verdict global</h2>
<div class="meta"><table>
<tr><th>À la livraison de ce dossier</th><td><code>G28 = PRET_POUR_VALIDATION_HUMAINE</code><br><code>PARTIEL — ÉCARTS RESTANTS</code></td></tr>
<tr><th>Après validation humaine explicite</th><td><code>FIDÉLITÉ CLAUDE DESIGN VALIDÉE</code></td></tr>
</table></div>
<p>Rien n’est fusionné dans <code>main</code>, rien n’est déployé et aucun DNS n’est modifié avant cette validation.</p>

<p><a href="index.html">↑ Retour au sommaire du volume prioritaire</a></p>`
	);
}

/** Rapport G27 converti depuis le Markdown, sans dépendance ni ressource externe. */
function pageRapport() {
	const md = readFileSync('docs/RAPPORT-G27.md', 'utf8');
	const enLigne = (t) =>
		esc(t)
			.replace(/`([^`]+)`/g, '<code>$1</code>')
			.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
			.replace(/(^|[^*])\*([^*]+)\*/g, '$1<em>$2</em>');

	const out = [];
	let dansTable = false;
	let dansCitation = false;
	const fermerTable = () => { if (dansTable) { out.push('</table></div>'); dansTable = false; } };
	const fermerCitation = () => { if (dansCitation) { out.push('</div>'); dansCitation = false; } };

	for (const brute of md.split('\n')) {
		const l = brute.trimEnd();
		if (/^\|[\s:-]+\|$/.test(l.replace(/[^|\s:-]/g, ''))) continue; // ligne de séparation
		if (l.startsWith('|')) {
			const cells = l.split('|').slice(1, -1).map((c) => c.trim());
			if (!dansTable) { fermerCitation(); out.push('<div class="meta"><table>'); dansTable = true; out.push('<tr>' + cells.map((c) => `<th>${enLigne(c)}</th>`).join('') + '</tr>'); continue; }
			out.push('<tr>' + cells.map((c) => `<td>${enLigne(c)}</td>`).join('') + '</tr>');
			continue;
		}
		fermerTable();
		if (l.startsWith('> ')) { if (!dansCitation) { out.push('<div class="note">'); dansCitation = true; } out.push(`<p>${enLigne(l.slice(2))}</p>`); continue; }
		fermerCitation();
		if (l === '' || l === '---') continue;
		if (l.startsWith('### ')) { out.push(`<h3>${enLigne(l.slice(4))}</h3>`); continue; }
		if (l.startsWith('## ')) { out.push(`<h2>${enLigne(l.slice(3))}</h2>`); continue; }
		if (l.startsWith('# ')) continue; // le titre est celui de la page
		if (/^\d+\.\s/.test(l)) { out.push(`<p style="margin-left:1.2em">${enLigne(l)}</p>`); continue; }
		if (l.startsWith('- ')) { out.push(`<p style="margin-left:1.2em">— ${enLigne(l.slice(2))}</p>`); continue; }
		out.push(`<p>${enLigne(l)}</p>`);
	}
	fermerTable();
	fermerCitation();

	return page(
		'Rapport de clôture G27',
		`<p class="sur">Dossier de validation humaine · G28 · commit ${COMMIT}</p>
<h1>Rapport de clôture G27</h1>
${out.join('\n')}
<p><a href="index.html">↑ Retour au sommaire du volume prioritaire</a></p>`
	);
}

const LISEZ_MOI = (volumes) => `DOSSIER DE VALIDATION HUMAINE — G28
Top-Famille Pro · état du commit ${COMMIT}
=====================================================================

CE QUE CONTIENT CE DOSSIER

Des comparaisons entre la maquette Claude Design et le site WordPress, page
par page, à deux largeurs de rendu : 375 px (téléphone) et 1440 px (ordinateur).

Chaque comparaison est une image en trois panneaux :

  gauche  : la maquette Claude Design
  milieu  : le rendu WordPress
  droite  : la différence entre les deux, amplifiée

Le bandeau sombre en haut de chaque image nomme la route, la largeur, le
facteur d'amplification et le taux de pixels qui s'écartent.

---------------------------------------------------------------------
COMMENT L'OUVRIR

Ce dossier fonctionne SANS INTERNET. Décompressez l'archive, puis
ouvrez le fichier « index.html » dans n'importe quel navigateur.
Aucune connexion n'est nécessaire, aucune donnée n'est envoyée.

Dans chaque volume, les boutons « précédent » et « suivant » font
défiler les comparaisons dans l'ordre.

---------------------------------------------------------------------
COMMENT LIRE LE TAUX DE PIXELS

Ce n'est PAS une note de fidélité. C'est la proportion de pixels dont la
luminosité s'écarte assez pour être perçue.

Une page plus longue d'un côté colorie toute la zone manquante. Un titre
décalé de quelques pixels colorie tout ce qui le suit. Un taux élevé
signale donc où regarder — il ne dit pas qu'il y a un défaut.

C'est l'oeil qui juge, pas le pourcentage.

---------------------------------------------------------------------
LES VOLUMES

${volumes.map((v) => `  ${v.titre}\n    ${v.chapo}\n    ${v.items.length} comparaisons`).join('\n\n')}

Les volumes sont indépendants. Extraits côte à côte dans un même
répertoire, les liens entre eux fonctionnent.

---------------------------------------------------------------------
CE QUI EST ATTENDU DE VOUS

Toutes les pages sont au statut « À VALIDER ». Aucune n'est validée
d'avance.

Après relecture, répondez exactement par l'une de ces deux formes :

  Validé

ou, pour chaque page en défaut :

  Refusé : page — défaut constaté

Ce qui n'est pas nommé est considéré comme non encore jugé, jamais
comme accepté.

---------------------------------------------------------------------
CE QUI N'EST PAS À JUGER ICI

Trois éléments ont été retirés des bloqueurs le 20 août :

  - la citation attribuée à Audrey ;
  - sa photo provisoire ;
  - l'URL, la note et le nombre d'avis Google.

La note Google reste masquée, conformément à l'état actuel.

---------------------------------------------------------------------
ÉTAT ET SUITES

  À la livraison de ce dossier :
      G28 = PRET_POUR_VALIDATION_HUMAINE
      verdict global : PARTIEL — ÉCARTS RESTANTS

  Après validation humaine explicite :
      FIDÉLITÉ CLAUDE DESIGN VALIDÉE

Rien n'est fusionné dans « main », rien n'est déployé et aucun DNS n'est
modifié avant cette validation.
`;

/* -------------------------------------------------------------- exécution */

const seul = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1] || '';
const comp = complementaires();

const VOLUMES = [
	{
		id: 'prioritaire',
		titre: '1 — Prioritaire',
		dossier: 'volume-1-prioritaire',
		chapo: 'Les quatorze cibles à relire en premier : une page par famille, les deux étapes du formulaire, la page pilier et le zoom sur sa bande de six vignettes. Le rapport de clôture et la fiche de décision sont joints à ce volume.',
		cibles: PRIORITAIRES,
		panneau: 520,
	},
	{
		id: 'pages',
		titre: '2 — Prestations et pages',
		dossier: 'volume-2-pages',
		chapo: 'Les prestations restantes, les index, les pages institutionnelles, les articles et les pages légales que le volume prioritaire ne couvre pas.',
		cibles: comp.pages,
		panneau: 420,
	},
	{
		id: 'zones',
		titre: '3 — Zones',
		dossier: 'volume-3-zones',
		chapo: 'Les huit départements, les villes et les huit communes secondaires, ainsi que le hub des zones.',
		cibles: comp.zones,
		panneau: 420,
	},
];

const actifs = VOLUMES.filter((v) => !seul || v.id === seul);

rmSync(RACINE, { recursive: true, force: true });

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const volume of actifs) {
	const base = path.join(RACINE, volume.dossier);
	mkdirSync(path.join(base, 'captures'), { recursive: true });
	volume.items = [];

	for (const cible of volume.cibles) {
		for (const largeur of LARGEURS) {
			const cotes = {};
			for (const [ nom, url, hash ] of [
				[ 'maquette', REF, cible.ref ],
				[ 'site', WP + cible.wp, null ],
			]) {
				const p = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
				await p.goto(url, { waitUntil: hash ? 'load' : 'networkidle', timeout: 90000 });
				if (hash) {
					await p.waitForTimeout(5000);
					await p.evaluate((h) => { location.hash = h; }, hash);
					await p.waitForTimeout(1200);
				}
				await stabiliser(p);
				if (cible.etape === 2) await passerEtape2(p);
				cotes[nom] = await capturer(p, cible.zoom);
				await p.close();
			}

			if (!cotes.maquette || !cotes.site) {
				console.log(`⚠ ${cible.id} ${largeur} : cible introuvable d'un côté — comparaison omise`);
				continue;
			}

			const fichierImg = `${cible.id}-${largeur}.jpg`;
			const fichierHtml = `${cible.id}-${largeur}.html`;
			const m = await triptyque(cotes.maquette, cotes.site, path.join(base, 'captures', fichierImg), {
				route: `${cible.libelle}  —  ${cible.wp}`,
				largeur,
				panneau: volume.panneau,
			});

			volume.items.push({ ...cible, largeur, fichierImg, fichierHtml, ...m });
			console.log(`${volume.dossier} · ${fichierImg} — ${m.pourcentage.toFixed(2)} %`);
		}
	}
}
await navigateur.close();

/* Pages HTML : écrites APRÈS toutes les captures, pour que la navigation connaisse ses voisins. */
for (const volume of actifs) {
	const base = path.join(RACINE, volume.dossier);
	volume.items.forEach((it, i) => {
		writeFileSync(path.join(base, it.fichierHtml), pageCapture(it, i, volume.items.length, volume));
	});
	writeFileSync(path.join(base, 'index.html'), pageIndex(volume, actifs));
	if (volume.id === 'prioritaire') {
		writeFileSync(path.join(base, 'fiche-de-decision.html'), pageFiche(actifs));
		writeFileSync(path.join(base, 'rapport-g27.html'), pageRapport());
		writeFileSync(path.join(base, 'LISEZ-MOI.txt'), LISEZ_MOI(actifs));
	}
}

const total = actifs.reduce((n, v) => n + v.items.length, 0);
console.log(`\n${actifs.length} volume(s) · ${total} comparaisons · écrit dans ${RACINE}/`);
