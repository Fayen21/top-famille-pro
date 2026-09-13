#!/usr/bin/env node
/**
 * Planche de validation finale : douze routes représentatives, à 1440 et 375 px.
 *
 * Produit, pour chaque route et chaque largeur, trois images dans
 * `docs/captures/validation-finale/` — la maquette, le rendu WordPress, et leur différence
 * pixel à pixel — ainsi que le document `docs/VALIDATION-VISUELLE.md` qui les rassemble avec les
 * chiffres de la mesure et les écarts encore ouverts.
 *
 * Les captures sont prises page entière, après défilement complet : sans cela, les images en
 * chargement différé se photographient en rectangles vides et la planche donne une fausse alerte.
 *
 * Usage : node tools/validation-finale.mjs
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync, readFileSync, existsSync } from 'node:fs';
import sharp from 'sharp';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const DIR = 'docs/captures/validation-finale';
const DOC = 'docs/VALIDATION-VISUELLE.md';
const WIDTHS = [1440, 375];

/** Les douze routes demandées à la validation, dans l'ordre du parcours visiteur. */
const PLANCHE = [
	['#/', 'Accueil'],
	['#/nettoyage-professionnel', 'Page pilier'],
	['#/service/bureaux', 'Nettoyage de bureaux'],
	['#/service/cabinets', 'Nettoyage de cabinets'],
	['#/nos-tarifs', 'Tarifs'],
	['#/ville/dijon', 'Dijon (ville)'],
	['#/ville/beaune', 'Beaune (ville)'],
	['#/pourquoi-top-famille-pro', 'Pourquoi nous'],
	['#/conseils', 'Index Conseils'],
	['#/article/frequence-bureaux', 'Article — fréquence de nettoyage'],
	['#/demande-de-devis', 'Formulaire de devis'],
	['#/mentions-legales', 'Mentions légales'],
];

mkdirSync(DIR, { recursive: true });

/** Défilement complet puis retour en haut : les images différées doivent être réellement chargées. */
async function poser(page) {
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 60));
		}
		window.scrollTo(0, 0);
	});
	await page
		.waitForFunction(() => Array.from(document.images).every((i) => i.complete), null, { timeout: 15000 })
		.catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(300);
}

/** Image de différence, sur deux captures ramenées à la même géométrie. */
async function difference(a, b, sortie, largeur) {
	const [am, bm] = await Promise.all([sharp(a).metadata(), sharp(b).metadata()]);
	const H = Math.max(am.height, bm.height);
	const caler = (buf) =>
		sharp({ create: { width: largeur, height: H, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [ap, bp] = await Promise.all([caler(a), caler(b)]);
	await sharp(ap)
		.composite([{ input: bp, blend: 'difference' }])
		.negate()
		.jpeg({ quality: 78 })
		.toFile(sortie);
	return { hauteurMaquette: am.height, hauteurWordPress: bm.height };
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const mesures = {};

for (const largeur of WIDTHS) {
	const ref = await browser.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const wp = await browser.newPage({ viewport: { width: largeur, height: 900 } });

	for (const [hash, titre] of PLANCHE) {
		const slug = hash.replace(/^#\//, '').replace(/\//g, '-') || 'accueil';
		const base = `${DIR}/${slug}-${largeur}`;

		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1200);
		await poser(ref);
		const a = await ref.screenshot({ fullPage: true });

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await poser(wp);
		const b = await wp.screenshot({ fullPage: true });

		await sharp(a).jpeg({ quality: 78 }).toFile(`${base}-maquette.jpg`);
		await sharp(b).jpeg({ quality: 78 }).toFile(`${base}-wordpress.jpg`);
		const { hauteurMaquette, hauteurWordPress } = await difference(a, b, `${base}-difference.jpg`, largeur);

		(mesures[hash] ||= { titre })[largeur] = {
			maquette: hauteurMaquette,
			wordpress: hauteurWordPress,
			ratio: Math.round((hauteurWordPress / hauteurMaquette) * 100),
		};
		console.log(`${String(largeur).padStart(4)}px ${hash.padEnd(34)} ${hauteurMaquette} → ${hauteurWordPress}`);
	}
	await ref.close();
	await wp.close();
}
await browser.close();

/* ------------------------------------------------------------------ */
/* Document de validation                                              */
/* ------------------------------------------------------------------ */

/** Écarts encore ouverts, relus depuis le rapport de styles s'il existe. */
let ecartsStyles = new Map();
if (existsSync('docs/VERIFICATION-VISUELLE-53-ROUTES.md')) {
	const txt = readFileSync('docs/VERIFICATION-VISUELLE-53-ROUTES.md', 'utf8');
	for (const ligne of txt.split('\n')) {
		const m = ligne.match(/^- `(#\/[^ ]*) @(\d+)px — (.+)`$/);
		if (m) {
			if (!ecartsStyles.has(m[1])) ecartsStyles.set(m[1], []);
			ecartsStyles.get(m[1]).push(`${m[2]} px — ${m[3]}`);
		}
	}
}

const L = [];
L.push('# Validation visuelle — douze routes représentatives');
L.push('');
L.push('> Fichier **généré** par `node tools/validation-finale.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Chaque route est capturée page entière, à 1440 px et à 375 px, après défilement complet —');
L.push('> sans ce défilement, les images en chargement différé se photographient en rectangles vides.');
L.push('> Trois fichiers par route et par largeur : la maquette Claude Design, le rendu WordPress, et');
L.push('> leur différence pixel à pixel. Sur l’image de différence, **les zones sombres sont les');
L.push('> écarts** ; une image entièrement claire signifie que les deux rendus se superposent.');
L.push('');
L.push('## Tableau de validation');
L.push('');
L.push('| Route | Écran | Hauteur maquette | Hauteur WordPress | Rapport | Maquette | WordPress | Différence |');
L.push('|---|---|---|---|---|---|---|---|');
for (const [hash, titre] of PLANCHE) {
	const slug = hash.replace(/^#\//, '').replace(/\//g, '-') || 'accueil';
	for (const largeur of WIDTHS) {
		const m = mesures[hash][largeur];
		const b = `captures/validation-finale/${slug}-${largeur}`;
		L.push(
			`| ${largeur === WIDTHS[0] ? titre : '↳'} | ${largeur} px | ${m.maquette} px | ${m.wordpress} px | ${m.ratio} % | ` +
				`[voir](${b}-maquette.jpg) | [voir](${b}-wordpress.jpg) | [voir](${b}-difference.jpg) |`
		);
	}
}
L.push('');

L.push('## Planches');
L.push('');
for (const [hash, titre] of PLANCHE) {
	const slug = hash.replace(/^#\//, '').replace(/\//g, '-') || 'accueil';
	L.push(`### ${titre} — \`${hash}\` → \`${ROUTE_MAP[hash].wp}\``);
	L.push('');
	for (const largeur of WIDTHS) {
		const m = mesures[hash][largeur];
		const b = `captures/validation-finale/${slug}-${largeur}`;
		L.push(`**${largeur} px** — maquette ${m.maquette} px, WordPress ${m.wordpress} px (${m.ratio} %)`);
		L.push('');
		L.push(`| Maquette Claude Design | WordPress | Différence |`);
		L.push('|---|---|---|');
		L.push(
			`| <img src="${b}-maquette.jpg" width="260" alt="Rendu de la maquette"> | ` +
				`<img src="${b}-wordpress.jpg" width="260" alt="Rendu WordPress"> | ` +
				`<img src="${b}-difference.jpg" width="260" alt="Différence pixel à pixel"> |`
		);
		L.push('');
	}
	const ec = ecartsStyles.get(hash) || [];
	L.push(ec.length ? '**Écarts de style encore ouverts sur cette route :**' : '**Aucun écart de style ouvert sur cette route.**');
	if (ec.length) {
		L.push('');
		for (const e of ec) L.push(`- ${e}`);
	}
	L.push('');
}

L.push('## Comment lire une image de différence');
L.push('');
L.push('L’image de différence superpose les deux captures et inverse le résultat : là où les deux');
L.push('rendus coïncident, elle est blanche ; là où ils diffèrent, elle s’assombrit. Un décalage');
L.push('vertical de quelques pixels en haut de page décale tout ce qui suit et noircit l’image');
L.push('entière — c’est pourquoi cette planche se lit **avec** les deux captures d’origine et avec');
L.push('le relevé de styles calculés, jamais seule.');
L.push('');
L.push('Deux rendus ne peuvent pas se superposer exactement, et ce n’est pas l’objectif :');
L.push('');
L.push('- la maquette est une application à une seule page, sans navigation réelle, dont les visuels');
L.push('  sont encodés dans le fichier ; le site sert de vraies URL et de vraies images ;');
L.push('- le pied de page du site porte la ligne légale réelle (raison sociale, capital, SIRET), que');
L.push('  la maquette n’a pas ;');
L.push('- le compteur de 47 avis de la maquette est retiré, la note seule est conservée ;');
L.push('- les pages légales portent le contenu juridique réel, plus long que celui du prototype.');
L.push('');
L.push('Ces écarts sont documentés et voulus. Tout le reste est un défaut de fidélité.');

writeFileSync(DOC, L.join('\n') + '\n');
console.error(`\nÉcrit : ${DOC} et ${DIR}/ (${PLANCHE.length * WIDTHS.length * 3} images)`);
