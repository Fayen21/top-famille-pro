#!/usr/bin/env node
/**
 * Épreuve HORS LIGNE d'un dossier de validation — G28.
 *
 * ## Pourquoi extraire avant de vérifier
 *
 * Vérifier le répertoire de travail ne prouve rien : il contient des fichiers que l'archive
 * n'emporte pas forcément, et le navigateur y trouve par accident ce qui manquerait ailleurs. Ce
 * contrôle EXTRAIT donc chaque archive dans un répertoire neuf, puis ouvre les pages en `file://`
 * avec le réseau COUPÉ au niveau du navigateur — toute requête sortante est refusée et comptée.
 *
 * Sept exigences, chacune vérifiée séparément :
 *   1. aucune image cassée (dimensions naturelles nulles) ;
 *   2. aucune ressource externe demandée (le blocage réseau les rend visibles) ;
 *   3. aucune URL `localhost`, GitHub ou `http(s)://` dans le balisage ;
 *   4. toutes les ancres internes pointent sur un fichier existant ;
 *   5. la navigation précédent/suivant relie réellement toutes les captures ;
 *   6. aucun chemin absolu (`/…`, `file://`, `C:\…`) dans les attributs ;
 *   7. aucune feuille de style ni script liés.
 *
 * Usage : node tools/verifier-dossier-hors-ligne.mjs release/dossier-g28-*.zip
 */
import { chromium } from '@playwright/test';
import { execFileSync } from 'node:child_process';
import { mkdtempSync, readdirSync, readFileSync, rmSync, statSync } from 'node:fs';
import os from 'node:os';
import path from 'node:path';

const archives = process.argv.slice(2).filter((a) => a.endsWith('.zip'));
if (!archives.length) {
	console.error('Usage : node tools/verifier-dossier-hors-ligne.mjs <archive.zip> [...]');
	process.exit(2);
}

/** Fichiers HTML d'un répertoire, en profondeur. */
function pagesDe(racine) {
	const out = [];
	const walk = (d) => {
		for (const e of readdirSync(d)) {
			const p = path.join(d, e);
			if (statSync(p).isDirectory()) walk(p);
			else if (e.endsWith('.html')) out.push(p);
		}
	};
	walk(racine);
	return out.sort();
}

const fautes = [];
const faute = (archive, categorie, detail) => fautes.push({ archive, categorie, detail });

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const archive of archives) {
	const nom = path.basename(archive);
	const tmp = mkdtempSync(path.join(os.tmpdir(), 'g28-epreuve-'));
	execFileSync('unzip', [ '-q', archive, '-d', tmp ]);

	const pages = pagesDe(tmp);
	if (!pages.length) {
		faute(nom, 'archive', 'aucune page HTML extraite');
		rmSync(tmp, { recursive: true, force: true });
		continue;
	}

	/* 3, 6, 7 — contrôles sur le BALISAGE, indépendants du rendu. */
	for (const p of pages) {
		const html = readFileSync(p, 'utf8');
		const rel = path.relative(tmp, p);

		for (const m of html.matchAll(/\b(?:href|src)\s*=\s*"([^"]*)"/g)) {
			const v = m[1];
			if (/^https?:\/\//i.test(v)) faute(nom, 'ressource externe', `${rel} → ${v}`);
			if (/localhost|127\.0\.0\.1|github\.com/i.test(v)) faute(nom, 'URL interdite', `${rel} → ${v}`);
			if (/^\//.test(v) || /^file:\/\//i.test(v) || /^[A-Za-z]:\\/.test(v)) faute(nom, 'chemin absolu', `${rel} → ${v}`);
		}
		if (/<link\b[^>]*rel\s*=\s*"stylesheet"/i.test(html)) faute(nom, 'feuille liée', rel);
		if (/<script\b[^>]*\bsrc\s*=/i.test(html)) faute(nom, 'script lié', rel);
		/* Le corps du texte ne doit pas non plus citer une URL de banc. */
		if (/localhost:\d+/.test(html.replace(/<[^>]+>/g, ''))) faute(nom, 'URL de banc dans le texte', rel);
	}

	/* 1, 2, 4, 5 — contrôles sur le RENDU, réseau coupé. */
	const contexte = await navigateur.newContext();
	await contexte.route('**', (r) => {
		const u = r.request().url();
		if (u.startsWith('file://') || u.startsWith('data:') || u.startsWith('about:')) return r.continue();
		faute(nom, 'requête sortante', u);
		return r.abort();
	});

	for (const p of pages) {
		const rel = path.relative(tmp, p);
		const page = await contexte.newPage();
		const erreurs = [];
		page.on('pageerror', (e) => erreurs.push(String(e)));
		await page.goto('file://' + p, { waitUntil: 'load', timeout: 30000 });

		const bilan = await page.evaluate(() => ({
			cassees: [ ...document.images ].filter((i) => !i.complete || i.naturalWidth === 0).map((i) => i.getAttribute('src')),
			images: document.images.length,
			ancres: [ ...document.querySelectorAll('a[href]') ].map((a) => a.getAttribute('href')),
		}));

		for (const src of bilan.cassees) faute(nom, 'image cassée', `${rel} → ${src}`);
		for (const e of erreurs) faute(nom, 'erreur JavaScript', `${rel} → ${e}`);

		for (const href of bilan.ancres) {
			if (/^(https?:|mailto:|tel:|#|data:)/i.test(href)) continue;
			const cible = path.resolve(path.dirname(p), href.split('#')[0]);
			try { statSync(cible); } catch { faute(nom, 'ancre morte', `${rel} → ${href}`); }
		}
		await page.close();
	}
	await contexte.close();

	/* 5 — la navigation relie-t-elle réellement toutes les captures ? */
	for (const dossier of readdirSync(tmp)) {
		const base = path.join(tmp, dossier);
		if (!statSync(base).isDirectory()) continue;
		const captures = readdirSync(base).filter((f) => f.endsWith('.html') && ![ 'index.html', 'fiche-de-decision.html', 'rapport-g27.html' ].includes(f));
		if (!captures.length) continue;
		const atteintes = new Set();
		let courante = null;
		const index = readFileSync(path.join(base, 'index.html'), 'utf8');
		const premier = [ ...index.matchAll(/href="([^"]+\.html)"/g) ].map((m) => m[1]).find((f) => captures.includes(f));
		courante = premier;
		let garde = 0;
		while (courante && !atteintes.has(courante) && garde++ < 500) {
			atteintes.add(courante);
			const html = readFileSync(path.join(base, courante), 'utf8');
			const suivant = [ ...html.matchAll(/href="([^"]+\.html)"[^>]*>[^<]*→/g) ].map((m) => m[1]).find((f) => captures.includes(f));
			courante = suivant;
		}
		const manquantes = captures.filter((f) => !atteintes.has(f));
		if (manquantes.length) {
			faute(nom, 'navigation incomplète', `${dossier} : ${manquantes.length} capture(s) hors de la chaîne suivant — ${manquantes.slice(0, 3).join(', ')}`);
		}
	}

	const nbImages = readdirSync(path.join(tmp, readdirSync(tmp)[0], 'captures')).length;
	console.log(`${nom} — ${pages.length} pages, ${nbImages} captures extraites`);
	rmSync(tmp, { recursive: true, force: true });
}
await navigateur.close();

if (!fautes.length) {
	console.log('\n✓ dossier hors ligne conforme : aucune image cassée, aucune ressource externe, aucune URL interdite, aucune ancre morte, aucun chemin absolu, navigation complète.');
	process.exit(0);
}

console.log(`\n✗ ${fautes.length} faute(s) :`);
const parCategorie = {};
for (const f of fautes) (parCategorie[f.categorie] ||= []).push(f);
for (const [ c, liste ] of Object.entries(parCategorie)) {
	console.log(`\n  ${c} — ${liste.length}`);
	for (const f of liste.slice(0, 8)) console.log(`    ${f.archive} · ${f.detail}`);
	if (liste.length > 8) console.log(`    … et ${liste.length - 8} autres`);
}
process.exit(1);
