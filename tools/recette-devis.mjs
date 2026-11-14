#!/usr/bin/env node
/**
 * Recette du devis — 12 novembre 2026.
 *
 * Fait parcourir au formulaire de devis le VRAI chemin serveur d'une installation `production`
 * (admin-post.php → validation → limitation → wp_mail()), sur le banc local, et lit l'e-mail
 * produit. Rien ne part : un mu-plugin temporaire, posé dans le banc seulement (jamais dans le
 * dépôt du thème), répond à `pre_wp_mail` en consignant le message dans un fichier. Il est retiré
 * en fin de recette, même en cas d'échec.
 *
 * Ce n'est PAS l'envoi contrôlé demandé en préproduction : il prouve le contenu de l'e-mail que
 * WordPress remet à wp_mail(), pas sa remise par le transport d'Hostinger.
 *
 * Contrôle aussi, à 375 × 812 px, le premier écran de l'accueil (tarif, Devis, Appeler, barre
 * mobile) et capture les étapes du devis.
 *
 * Prérequis : banc en `production` sur http://localhost:8901 (restart-banc / banc-local.sh).
 * Usage : node tools/recette-devis.mjs → docs/captures-recette-devis/ + bilan.json
 */
import { chromium } from 'playwright';
import { execFileSync } from 'node:child_process';
import { existsSync, mkdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import path from 'node:path';
import { purgerLimiteDevis } from '../tests/functional/limite-banc.js';

const BASE = process.env.TFP_BASE_URL || 'http://localhost:8901';
const RIG = process.env.TFP_RIG || '/tmp/tfp-rig';
const MU = path.join(RIG, 'wp-core/wp-content/mu-plugins');
const PLUGIN = path.join(MU, 'tfp-recette-capture-mail.php');
const JOURNAL = path.join(RIG, 'recette-mails.jsonl');
const SORTIE = 'docs/captures-recette-devis';

const env = execFileSync('php', [ path.join(RIG, 'wp-cli.phar'), `--path=${path.join(RIG, 'wp-core')}`, '--allow-root', 'eval', 'echo wp_get_environment_type();' ], { env: { ...process.env, WP_ENVIRONMENT_TYPE: '' } }).toString().trim();

mkdirSync(MU, { recursive: true });
mkdirSync(SORTIE, { recursive: true });
rmSync(JOURNAL, { force: true });
writeFileSync(PLUGIN, `<?php
// Recette locale uniquement (tools/recette-devis.mjs) : consigne l'e-mail au lieu de l'expédier.
add_filter( 'pre_wp_mail', function ( $retour, $atts ) {
	file_put_contents( ${JSON.stringify(JOURNAL)}, wp_json_encode( $atts ) . "\\n", FILE_APPEND );
	return true;
}, 10, 2 );
`);

const mails = () => (existsSync(JOURNAL) ? readFileSync(JOURNAL, 'utf8').trim().split('\n').filter(Boolean).map((l) => JSON.parse(l)) : []);
const bilan = { date: new Date().toISOString(), base: BASE, scenarios: {}, accueil: {} };
let echecs = 0;
const verifier = (scenario, nom, ok, detail = '') => {
	bilan.scenarios[scenario] ??= [];
	bilan.scenarios[scenario].push({ nom, ok, detail });
	if (!ok) echecs++;
	console.log(`${ok ? '✓' : '✕'} [${scenario}] ${nom}${detail ? ' — ' + detail : ''}`);
};

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
try {
	const page = await navigateur.newPage({ viewport: { width: 375, height: 812 } });
	const html = await (await fetch(BASE + '/demande-de-devis/')).text();
	verifier('banc', 'formulaire en mode envoi réel (pas de data-tfp-mail-disabled)', !html.includes('data-tfp-mail-disabled'), `environnement ${env || 'production (variable du serveur)'}`);

	/* ---------- Accueil, premier écran 375 × 812 ---------- */
	await page.goto(BASE + '/', { waitUntil: 'load' });
	await page.evaluate(() => document.fonts.ready);
	await page.waitForTimeout(400);
	await page.screenshot({ path: `${SORTIE}/accueil-premier-ecran-375x812.png` });
	const mesure = await page.evaluate(() => {
		const box = (el) => { if (!el) return null; const r = el.getBoundingClientRect(); return { top: Math.round(r.top), bottom: Math.round(r.bottom), left: Math.round(r.left), right: Math.round(r.right), h: Math.round(r.height), w: Math.round(r.width) }; };
		const offre = document.querySelector('.tfp-hero__offre');
		const liens = offre ? [...offre.querySelectorAll('a')] : [];
		const devis = liens.find((a) => /devis/i.test(a.textContent));
		const appel = liens.find((a) => /^tel:/.test(a.getAttribute('href') || ''));
		const barre = document.querySelector('.tfp-mobile-cta-bar');
		const barreLiens = barre ? [...barre.querySelectorAll('a')].map((a) => ({ texte: a.textContent.trim().replace(/\s+/g, ' '), ...box(a) })) : [];
		const style = (el) => el && getComputedStyle(el);
		return {
			vh: window.innerHeight,
			largeurDoc: document.documentElement.scrollWidth,
			prix: { texte: document.querySelector('.tfp-hero__prix')?.textContent.trim().replace(/\s+/g, ' '), ...box(document.querySelector('.tfp-hero__prix')), police: style(document.querySelector('.tfp-hero__prix'))?.fontSize },
			devis: devis && { texte: devis.textContent.trim(), ...box(devis) },
			appel: appel && { texte: appel.textContent.trim(), href: appel.getAttribute('href'), ...box(appel) },
			barre: barre && { ...box(barre), visible: style(barre).display !== 'none' && style(barre).visibility !== 'hidden', liens: barreLiens },
		};
	});
	bilan.accueil = mesure;
	const haut = mesure.barre?.visible ? mesure.barre.top : mesure.vh;
	verifier('accueil 375', 'tarif visible au-dessus de la barre mobile', !!mesure.prix && mesure.prix.bottom <= haut && /27/.test(mesure.prix.texte || ''), `${mesure.prix?.texte} · bas ${mesure.prix?.bottom} px / barre ${haut} px`);
	verifier('accueil 375', '« Demander mon devis » entièrement visible, ≥ 44 px', !!mesure.devis && mesure.devis.bottom <= haut && mesure.devis.h >= 44, `bas ${mesure.devis?.bottom} px · ${mesure.devis?.h} px de haut`);
	verifier('accueil 375', '« Appeler » entièrement visible, ≥ 44 px, lien tel:', !!mesure.appel && mesure.appel.bottom <= haut && mesure.appel.h >= 44, `${mesure.appel?.texte} · bas ${mesure.appel?.bottom} px · ${mesure.appel?.h} px`);
	verifier('accueil 375', 'barre mobile affichée, commandes ≥ 44 px', !!mesure.barre?.visible && mesure.barre.liens.length > 0 && mesure.barre.liens.every((l) => l.h >= 44), (mesure.barre?.liens || []).map((l) => `${l.texte} ${l.h} px`).join(' · '));
	verifier('accueil 375', 'aucun débordement horizontal', mesure.largeurDoc <= 375, `${mesure.largeurDoc} px`);
	// Utilisable : chaque commande reçoit bien le clic (rien ne la recouvre).
	for (const [nom, sel] of [ [ 'Devis', '.tfp-hero__offre a[href*="demande-de-devis"]' ], [ 'Appeler', '.tfp-hero__offre a[href^="tel:"]' ] ]) {
		const recoit = await page.locator(sel).first().evaluate((a) => { const r = a.getBoundingClientRect(); const el = document.elementFromPoint(r.left + r.width / 2, r.top + r.height / 2); return a === el || a.contains(el); });
		verifier('accueil 375', `« ${nom} » reçoit le clic en son centre`, recoit);
	}

	const envoyer = async (p) => {
		await p.fill('#tfp-message', 'Recette du 12 novembre 2026 — demande de test, ne pas traiter.');
		await p.check('input[name="consentement"]');
		await Promise.all([ p.waitForURL(/demande-de-devis\/\?(merci|erreur)/), p.click('[data-step-submit]') ]);
		return new URL(p.url()).searchParams;
	};

	/* ---------- A. Accès direct, téléphone seul, surface et CP vides ---------- */
	purgerLimiteDevis();
	await page.goto(BASE + '/demande-de-devis/', { waitUntil: 'load' });
	await page.selectOption('#tfp-type-locaux', 'commerces');
	await page.selectOption('#tfp-regime', 'ponctuel');
	await page.fill('#tfp-nom', 'Recette A');
	await page.fill('#tfp-telephone', '06 00 00 00 01');
	await page.screenshot({ path: `${SORTIE}/devis-acces-direct-etape-1-375.png`, fullPage: true });
	await page.click('[data-step-next]');
	await page.screenshot({ path: `${SORTIE}/devis-acces-direct-etape-2-375.png`, fullPage: true });
	let n = mails().length;
	let retour = await envoyer(page);
	verifier('A accès direct', 'téléphone seul + surface et CP vides : envoi accepté', retour.get('merci') === '1', `?${retour}`);
	await page.screenshot({ path: `${SORTIE}/devis-confirmation-375.png`, fullPage: false });
	let m = mails()[n];
	verifier('A accès direct', 'un e-mail remis à wp_mail()', !!m);
	if (m) {
		bilan.scenarios['A accès direct'].push({ email: m });
		verifier('A accès direct', 'prestation demandée = Commerces ponctuel', m.message.includes('Prestation demandée : Nettoyage de commerces (intervention ponctuelle)'));
		verifier('A accès direct', 'type et régime reçus', m.message.includes('Type de locaux : Commerces') && m.message.includes('Régime : Ponctuel'));
		verifier('A accès direct', 'pas de prestation d’origine (accès direct)', !m.message.includes('Prestation de la page d'));
		verifier('A accès direct', 'téléphone présent, aucun e-mail, CP et surface absents', m.message.includes('Téléphone : 06 00 00 00 01') && !/^E-mail :/m.test(m.message) && !m.message.includes('Code postal') && !m.message.includes('Surface'));
	}

	/* ---------- B. Bureaux → Demander un devis → Commerce, e-mail seul, retour à l'étape 1 ---------- */
	purgerLimiteDevis();
	await page.goto(BASE + '/prestations/bureaux/', { waitUntil: 'load' });
	await Promise.all([ page.waitForURL(/demande-de-devis/), page.locator('a[href*="demande-de-devis/?service=bureaux"]').first().click() ]);
	await page.selectOption('#tfp-type-locaux', 'commerces');
	await page.selectOption('#tfp-regime', 'regulier');
	await page.fill('#tfp-nom', 'Recette B');
	await page.fill('#tfp-email', 'recette@example.com');
	await page.screenshot({ path: `${SORTIE}/devis-depuis-bureaux-commerce-etape-1-375.png`, fullPage: true });
	await page.click('[data-step-next]');
	verifier('B Bureaux → Commerce', 'récapitulatif = Commerces', (await page.locator('[data-quote-recap-text]').innerText()).includes('Commerces'));
	verifier('B Bureaux → Commerce', 'champ caché prestation = Commerces', (await page.inputValue('#tfp-prestation-visible')) === 'Nettoyage de commerces (entretien régulier)');
	await page.screenshot({ path: `${SORTIE}/devis-depuis-bureaux-commerce-etape-2-375.png`, fullPage: true });
	// Retour à l'étape 1 : passage en ponctuel.
	await page.click('[data-quote-recap] [data-step-prev]');
	await page.selectOption('#tfp-regime', 'ponctuel');
	await page.click('[data-step-next]');
	n = mails().length;
	retour = await envoyer(page);
	verifier('B Bureaux → Commerce', 'e-mail seul : envoi accepté', retour.get('merci') === '1', `?${retour}`);
	m = mails()[n];
	if (m) {
		bilan.scenarios['B Bureaux → Commerce'].push({ email: m });
		verifier('B Bureaux → Commerce', 'prestation demandée = dernier choix (Commerces, ponctuel)', m.message.includes('Prestation demandée : Nettoyage de commerces (intervention ponctuelle)'));
		verifier('B Bureaux → Commerce', 'aucune mention « Nettoyage de bureaux » comme prestation demandée', !/Prestation demandée : Nettoyage de bureaux/.test(m.message));
		verifier('B Bureaux → Commerce', 'origine conservée à part', m.message.includes('Prestation de la page d\'origine : Nettoyage de bureaux') && /Page d'origine : .*\/prestations\/bureaux\//.test(m.message));
		verifier('B Bureaux → Commerce', 'Reply-To vers l’e-mail du prospect', JSON.stringify(m.headers).includes('recette@example.com'));
	} else verifier('B Bureaux → Commerce', 'un e-mail remis à wp_mail()', false);

	/* ---------- C. Serveur seul juge : champ caché périmé forcé dans le POST ---------- */
	purgerLimiteDevis();
	await page.route('**/wp-admin/admin-post.php', async (route) => {
		const corps = new URLSearchParams(route.request().postData() || '');
		corps.set('prestation', 'Nettoyage de bureaux');
		await route.continue({ postData: corps.toString() });
	});
	await page.goto(BASE + '/demande-de-devis/?service=bureaux&service_label=Nettoyage%20de%20bureaux', { waitUntil: 'load' });
	await page.selectOption('#tfp-type-locaux', 'commerces');
	await page.selectOption('#tfp-regime', 'regulier');
	await page.fill('#tfp-nom', 'Recette C');
	await page.fill('#tfp-telephone', '0600000003');
	await page.click('[data-step-next]');
	n = mails().length;
	retour = await envoyer(page);
	m = mails()[n];
	verifier('C serveur', 'POST avec prestation périmée : le serveur recalcule depuis type et régime', !!m && m.message.includes('Prestation demandée : Nettoyage de commerces (entretien régulier)'), m ? '' : `aucun e-mail (?${retour})`);
	await page.unrouteAll();

	/* ---------- D. Aucun moyen de contact : refus client et serveur ---------- */
	await page.goto(BASE + '/demande-de-devis/', { waitUntil: 'load' });
	await page.selectOption('#tfp-type-locaux', 'bureaux');
	await page.selectOption('#tfp-regime', 'regulier');
	await page.fill('#tfp-nom', 'Recette D');
	await page.click('[data-step-next]');
	verifier('D sans contact', 'refus client annoncé, étape 1 conservée', (await page.locator('[data-form-errors]').innerText()).includes('Téléphone ou e-mail') && (await page.locator('[data-step="0"]').isVisible()));
} finally {
	await navigateur.close();
	rmSync(PLUGIN, { force: true });
	purgerLimiteDevis();
}

bilan.mailsConsignes = mails().length;
bilan.echecs = echecs;
writeFileSync(`${SORTIE}/bilan.json`, JSON.stringify(bilan, null, 2) + '\n');
console.log(`\n${echecs === 0 ? '✅' : '❌'} Recette du devis : ${echecs} échec(s). Mu-plugin de capture retiré : ${!existsSync(PLUGIN)}.`);
process.exit(echecs ? 1 : 0);
