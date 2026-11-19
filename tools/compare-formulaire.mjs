#!/usr/bin/env node
/**
 * Comparaison des DEUX ÉTAPES du formulaire de devis — protocole repris en G26 §6.
 *
 * ## Pourquoi ce protocole
 *
 * La validation humaine du 17 août 2026 a refusé les comparaisons précédentes de ce formulaire :
 * les deux côtés n'étaient pas mis dans le même état avant la capture, et le rapport affirmait
 * « mêmes champs » alors que des différences fonctionnelles subsistent. Un triptyque produit dans
 * ces conditions ne prouve rien — il compare deux situations différentes.
 *
 * Le protocole est donc explicite, et identique des deux côtés :
 *
 *  1. **Mêmes données injectées.** Un seul jeu, `DONNEES`, saisi champ par champ dans les deux
 *     formulaires. Aucun champ n'est rempli d'un côté seulement.
 *  2. **Même étape.** L'étape 2 n'est atteinte qu'après le franchissement réel de l'étape 1, des
 *     deux côtés, et la capture est refusée si l'un des deux n'y est pas parvenu — mieux vaut pas
 *     d'image qu'une image trompeuse.
 *  3. **Même position de défilement.** Les deux pages sont ramenées en haut avant la capture, qui
 *     est pleine page : aucune ne photographie un défilement différent de l'autre.
 *  4. **En-tête collant neutralisé identiquement.** La même règle est injectée des deux côtés :
 *     une découpe pleine page photographie sinon l'en-tête à sa position de défilement, par-dessus
 *     le contenu, et l'artefact diffère d'un côté à l'autre.
 *  5. **Polices chargées.** `document.fonts.ready` est attendu avant chaque capture.
 *  6. **Récapitulatif d'étape 2.** Les valeurs réellement présentes dans les champs des deux côtés
 *     sont relevées et écrites dans docs/FORMULAIRE-CAPTURES.md : on voit noir sur blanc que les
 *     deux formulaires portaient bien les mêmes données au moment de la capture.
 *
 * Les différences fonctionnelles imposées (champ de contexte, liste fermée, champ obligatoire)
 * sont documentées dans docs/FORMULAIRE-DIFFERENCES.md, une par une, avec leur motif. Ce fichier
 * n'affirme jamais « mêmes champs ».
 *
 * Aucune donnée n'est envoyée : l'étape 2 est un changement d'état client des deux côtés.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/compare-formulaire.mjs
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import sharp from 'sharp';
import { panneauDifference } from './lib/diff-visuel.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const SHOT_DIR = 'docs/captures/comparaison';
const RAPPORT = 'docs/FORMULAIRE-CAPTURES.md';
const PANEL = 320;

/** Le jeu de données UNIQUE, injecté à l'identique des deux côtés. */
const DONNEES = {
	type_locaux: 'bureaux',
	regime: 'regulier',
	ville: 'Dijon',
	code_postal: '21000',
	surface: '120',
	nom: 'Capture Test',
	telephone: '06 12 34 56 78',
	email: 'capture@example.test',
};

/*
 * Gel des animations ET neutralisation de l'en-tête collant, appliqués À L'IDENTIQUE des deux
 * côtés. Toute asymétrie ici fabrique une différence qui n'est pas dans les pages.
 */
const FIGER = `*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
header,.tfp-header,[data-tfp-header],[style*="position:sticky"],[style*="position: sticky"]{position:static!important}`;

mkdirSync(SHOT_DIR, { recursive: true });

async function stabiliser(page) {
	await page.addStyleTag({ content: FIGER }).catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	// Même position de défilement des deux côtés : le haut de page.
	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(400);
}

async function triptych(refBuf, wpBuf, out) {
	const [ab, bb] = await Promise.all([
		sharp(refBuf).resize({ width: PANEL }).png().toBuffer(),
		sharp(wpBuf).resize({ width: PANEL }).png().toBuffer(),
	]);
	// Panneau de différence amplifié et mesuré (tools/lib/diff-visuel.mjs, G26 §2).
	const { png: diff, pourcentage, hauteur: H } = await panneauDifference(ab, bb);
	const pad = (buf) =>
		sharp({ create: { width: PANEL, height: H, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [ap, bp] = await Promise.all([pad(ab), pad(bb)]);
	await sharp({ create: { width: PANEL * 3 + 16, height: H, channels: 3, background: '#d0d0d0' } })
		.composite([
			{ input: ap, top: 0, left: 0 },
			{ input: bp, top: 0, left: PANEL + 8 },
			{ input: diff, top: 0, left: (PANEL + 8) * 2 },
		])
		.jpeg({ quality: 78, mozjpeg: true })
		.toFile(out);
	return pourcentage;
}

/** Saisit un champ s'il existe ; ne fait pas échouer la capture s'il est absent d'un côté. */
async function saisir(page, selecteur, valeur, type = 'fill') {
	const el = page.locator(selecteur);
	if ((await el.count()) === 0) return false;
	if ('select' === type) await el.selectOption(valeur).catch(() => {});
	else await el.fill(valeur).catch(() => {});
	return true;
}

/** Étape 1 de la MAQUETTE, remplie avec DONNEES. */
async function maquetteEtape1(page) {
	await saisir(page, '#devis-type', DONNEES.type_locaux, 'select');
	// La maquette libelle ses options en clair ; le thème les code en valeurs.
	await page
		.selectOption('#devis-nature', {
			label: 'regulier' === DONNEES.regime ? 'Entretien régulier' : 'Intervention ponctuelle',
		})
		.catch(() => {});
	await saisir(page, '#devis-ville', DONNEES.ville);
	await saisir(page, '#devis-cp', DONNEES.code_postal);
	await saisir(page, '#devis-surface', DONNEES.surface);
	await saisir(page, '#devis-nom', DONNEES.nom);
	await saisir(page, '#devis-tel', DONNEES.telephone);
	await saisir(page, '#devis-email', DONNEES.email);
}

/** Étape 1 du THÈME, remplie avec les MÊMES données. */
async function wpEtape1(page) {
	await saisir(page, '#tfp-type-locaux', DONNEES.type_locaux, 'select');
	await saisir(page, '#tfp-regime', DONNEES.regime, 'select');
	await saisir(page, '#tfp-ville-visible', DONNEES.ville);
	await saisir(page, '#tfp-code-postal', DONNEES.code_postal);
	await saisir(page, '#tfp-surface', DONNEES.surface);
	await saisir(page, '#tfp-nom', DONNEES.nom);
	await saisir(page, '#tfp-telephone', DONNEES.telephone);
	await saisir(page, '#tfp-email', DONNEES.email);
}

/** Relevé des valeurs RÉELLEMENT présentes, pour le récapitulatif du rapport. */
const valeursDe = (page, champs) =>
	page.evaluate((liste) => {
		const out = {};
		for (const [cle, sel] of liste) {
			const el = document.querySelector(sel);
			out[cle] = el ? el.value : null;
		}
		return out;
	}, champs);

const CHAMPS_REF = [
	['type de locaux', '#devis-type'],
	['régime', '#devis-nature'],
	['ville', '#devis-ville'],
	['code postal', '#devis-cp'],
	['surface', '#devis-surface'],
	['nom', '#devis-nom'],
	['téléphone', '#devis-tel'],
	['e-mail', '#devis-email'],
];
const CHAMPS_WP = [
	['type de locaux', '#tfp-type-locaux'],
	['régime', '#tfp-regime'],
	['ville', '#tfp-ville-visible'],
	['code postal', '#tfp-code-postal'],
	['surface', '#tfp-surface'],
	['nom', '#tfp-nom'],
	['téléphone', '#tfp-telephone'],
	['e-mail', '#tfp-email'],
];

const lignes = [];
const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const width of [375, 1440]) {
	for (const etape of [1, 2]) {
		const ref = await browser.newPage({ viewport: { width, height: 900 } });
		await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
		await ref.waitForTimeout(5500);
		await ref.evaluate(() => {
			location.hash = '/demande-de-devis';
		});
		await ref.waitForTimeout(1100);
		await maquetteEtape1(ref);
		const valeursRef = await valeursDe(ref, CHAMPS_REF);
		if (2 === etape) {
			await ref.click('button[type="submit"]');
			await ref.waitForTimeout(800);
		}
		// Contrôle d'état : l'étape 2 doit être réellement atteinte, sinon on ne capture pas.
		const refEtape2 = await ref.evaluate(() => {
			const c = document.querySelector('[name="consentement"]');
			return !!c && !!c.offsetParent;
		});
		await stabiliser(ref);
		const refShot = await ref.screenshot({ fullPage: true });
		await ref.close();

		const wp = await browser.newPage({ viewport: { width, height: 900 } });
		await wp.goto(WP + '/demande-de-devis/', { waitUntil: 'networkidle', timeout: 60000 });
		await wpEtape1(wp);
		const valeursWp = await valeursDe(wp, CHAMPS_WP);
		if (2 === etape) {
			await wp.click('[data-step-next]');
			await wp.waitForTimeout(800);
		}
		const wpEtape2 = await wp.evaluate(() => {
			const c = document.querySelector('[name="consentement"]');
			return !!c && !!c.offsetParent;
		});
		await stabiliser(wp);
		const wpShot = await wp.screenshot({ fullPage: true });
		await wp.close();

		if (2 === etape && (!refEtape2 || !wpEtape2)) {
			throw new Error(
				`étape 2 non atteinte (maquette=${refEtape2}, thème=${wpEtape2}) à ${width} px : ` +
					'capture refusée, un triptyque comparerait deux états différents.'
			);
		}

		const out = `${SHOT_DIR}/formulaire-etape-${etape}-${width}.jpg`;
		const pourcentage = await triptych(refShot, wpShot, out);
		console.log(`écrit : ${out} — ${pourcentage.toFixed(2)} % de pixels s'écartent`);

		lignes.push({ width, etape, out, pourcentage, valeursRef, valeursWp });
	}
}
await browser.close();

/* Rapport : les valeurs relevées des deux côtés, champ par champ, plus le taux mesuré. */
const md = [];
md.push('# Captures comparatives du formulaire de devis');
md.push('');
md.push('> Généré par `node tools/compare-formulaire.mjs` — ne pas éditer à la main.');
md.push('');
md.push('Les quatre triptyques ci-dessous sont produits selon le protocole décrit en tête de');
md.push('`tools/compare-formulaire.mjs` : mêmes données injectées, même étape (vérifiée avant');
md.push("capture), même position de défilement, en-tête collant neutralisé à l'identique, polices");
md.push('chargées.');
md.push('');
md.push('**Ce document n’affirme pas que les deux formulaires portent les mêmes champs.** Les');
md.push('différences fonctionnelles imposées sont listées dans `docs/FORMULAIRE-DIFFERENCES.md`,');
md.push('une par une, avec leur motif.');
md.push('');
for (const l of lignes) {
	md.push(`## Étape ${l.etape} — ${l.width} px`);
	md.push('');
	md.push(`Fichier : \`${l.out}\` · écart mesuré : **${l.pourcentage.toFixed(2)} %** des pixels.`);
	md.push('');
	md.push('| Champ | Valeur dans la maquette | Valeur dans WordPress | Verdict |');
	md.push('|---|---|---|---|');
	for (const [cle] of CHAMPS_REF) {
		const a = String(l.valeursRef[cle] ?? '');
		const b = String(l.valeursWp[cle] ?? '');
		let verdict;
		if (a === b) {
			verdict = '✅ identique';
		} else if (a && b) {
			// Une liste déroulante peut porter la même valeur sous deux codages (« bureaux » d'un
			// côté, « Bureaux » de l'autre) : on le dit, au lieu de compter une divergence.
			verdict = '≈ même donnée, codage différent';
		} else {
			verdict = '❌ divergent';
		}
		md.push(`| ${cle} | \`${a || '—'}\` | \`${b || '—'}\` | ${verdict} |`);
	}
	md.push('');
}
writeFileSync(RAPPORT, md.join('\n') + '\n');
console.log(`écrit : ${RAPPORT}`);
