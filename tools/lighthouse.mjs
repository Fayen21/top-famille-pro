#!/usr/bin/env node
/**
 * Mesure Lighthouse des sept pages de recette, mobile et bureau, sur le banc « proche de la
 * production » (tools/banc-production.mjs : compression et cache, comme LiteSpeed).
 *
 * Mesurer sur le rig `php -S` nu n'a pas de sens : sans compression, la feuille de style pèse
 * six fois son poids réel, et sur le lien mobile bridé de Lighthouse cela décale le premier rendu
 * de plus d'une seconde. Ce qui serait mesuré n'existe sur aucun hébergement.
 *
 * Usage :
 *   node tools/banc-production.mjs &          (le banc doit tourner)
 *   node tools/lighthouse.mjs                 → docs/LIGHTHOUSE.md
 *   node tools/lighthouse.mjs --only=/contact/
 */
import { execFileSync } from 'node:child_process';
import { mkdtempSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';

const BASE = process.env.TFP_BENCH_URL || 'http://localhost:8902';
const SORTIE = 'docs/LIGHTHOUSE.md';

/** Les sept pages de la recette : une par famille de gabarit, plus les deux parcours. */
const PAGES = [
	{ nom: 'Accueil', url: '/' },
	{ nom: 'Prestation', url: '/prestations/bureaux/' },
	{ nom: 'Ville', url: '/zones-intervention/cote-dor/dijon/' },
	{ nom: 'Tarifs', url: '/tarifs/' },
	{ nom: 'Article', url: '/conseils/cout-nettoyage-bureaux/' },
	{ nom: 'Contact', url: '/contact/' },
	{ nom: 'Formulaire de devis', url: '/demande-de-devis/' },
];

const seule = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1];
const pages = seule ? PAGES.filter((p) => p.url === seule) : PAGES;

const dossier = mkdtempSync(join(tmpdir(), 'tfp-lh-'));

/** Une passe Lighthouse, en JSON, sur le Chromium déjà installé. */
function mesurer(url, mobile) {
	const fichier = join(dossier, 'rapport.json');
	execFileSync(
		'node_modules/.bin/lighthouse',
		[
			url,
			'--output=json',
			`--output-path=${fichier}`,
			'--quiet',
			'--chrome-flags=--headless=new --no-sandbox --disable-dev-shm-usage',
			...(mobile ? [] : ['--preset=desktop']),
		],
		{ stdio: ['ignore', 'ignore', 'pipe'], env: { ...process.env, CHROME_PATH: '/opt/pw-browsers/chromium' } }
	);
	const r = JSON.parse(readFileSync(fichier, 'utf8'));
	const note = (c) => Math.round((r.categories[c]?.score ?? 0) * 100);
	const audit = (a) => r.audits[a]?.numericValue ?? null;
	return {
		perf: note('performance'),
		a11y: note('accessibility'),
		bp: note('best-practices'),
		seo: note('seo'),
		lcp: audit('largest-contentful-paint'),
		cls: r.audits['cumulative-layout-shift']?.numericValue ?? null,
		tbt: audit('total-blocking-time'),
	};
}

const lignes = [];
for (const p of pages) {
	for (const mobile of [true, false]) {
		const m = mesurer(BASE + p.url, mobile);
		lignes.push({ ...p, profil: mobile ? 'mobile' : 'bureau', ...m });
		console.log(
			`${(mobile ? 'mobile' : 'bureau').padEnd(7)} ${p.nom.padEnd(20)} ` +
				`perf ${String(m.perf).padStart(3)} · a11y ${m.a11y} · bp ${m.bp} · seo ${m.seo} · ` +
				`LCP ${(m.lcp / 1000).toFixed(2)} s · CLS ${m.cls.toFixed(3)} · TBT ${Math.round(m.tbt)} ms`
		);
	}
}
rmSync(dossier, { recursive: true, force: true });

const L = [];
L.push('# Lighthouse — sept pages de recette');
L.push('');
L.push('> Fichier **généré** par `node tools/lighthouse.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Mesuré sur le banc `tools/banc-production.mjs`, qui place devant le rig la compression et');
L.push('> les en-têtes de cache d’un LiteSpeed Hostinger. Mesurer sur le serveur PHP nu donnerait des');
L.push('> chiffres qui n’existent sur aucun hébergement.');
L.push('');
L.push('Cibles : Performance ≥ 90 · Accessibilité, Bonnes pratiques, SEO = 100 · CLS ≤ 0,010.');
L.push('');
L.push('| Page | Profil | Perf. | A11y | BP | SEO | LCP | CLS | TBT |');
L.push('|---|---|---:|---:|---:|---:|---:|---:|---:|');
for (const l of lignes) {
	L.push(
		`| ${l.nom} | ${l.profil} | ${l.perf} | ${l.a11y} | ${l.bp} | ${l.seo} | ` +
			`${(l.lcp / 1000).toFixed(2)} s | ${l.cls.toFixed(3)} | ${Math.round(l.tbt)} ms |`
	);
}
L.push('');

const echecs = lignes.filter((l) => l.perf < 90 || l.a11y < 100 || l.bp < 100 || l.seo < 100 || l.cls > 0.01);
L.push(
	echecs.length
		? `**${echecs.length} mesure(s) sous la cible** : ` +
				echecs.map((l) => `${l.nom} (${l.profil})`).join(', ') +
				'.'
		: '**Toutes les mesures atteignent leur cible.**'
);
L.push('');

writeFileSync(SORTIE, L.join('\n') + '\n');
console.log(`\nÉcrit : ${SORTIE} — ${echecs.length} mesure(s) sous la cible sur ${lignes.length}`);
process.exit(echecs.length ? 1 : 0);
