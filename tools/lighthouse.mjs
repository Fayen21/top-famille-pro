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
import { mkdirSync, mkdtempSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
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
// Rapports complets conservés (JSON + HTML par audit), hors Git : export/lighthouse/.
const RAPPORTS = 'export/lighthouse';
mkdirSync(RAPPORTS, { recursive: true });

/** Une passe Lighthouse — JSON + HTML conservés, cache froid (chaque passe lance son Chromium). */
function mesurer(url, mobile, etiquette) {
	const base = join(dossier, 'rapport');
	execFileSync(
		'node_modules/.bin/lighthouse',
		[
			url,
			'--output=json',
			'--output=html',
			`--output-path=${base}`,
			'--quiet',
			'--chrome-flags=--headless=new --no-sandbox --disable-dev-shm-usage',
			...(mobile ? [] : ['--preset=desktop']),
		],
		{ stdio: ['ignore', 'ignore', 'pipe'], env: { ...process.env, CHROME_PATH: '/opt/pw-browsers/chromium' } }
	);
	const r = JSON.parse(readFileSync(base + '.report.json', 'utf8'));
	writeFileSync(join(RAPPORTS, etiquette + '.report.json'), readFileSync(base + '.report.json'));
	writeFileSync(join(RAPPORTS, etiquette + '.report.html'), readFileSync(base + '.report.html'));
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

const sousCible = (m) => m.perf < 90 || m.a11y < 100 || m.bp < 100 || m.seo < 100;
const mediane = (v) => v.slice().sort((a, b) => a - b)[Math.floor(v.length / 2)];

const lignes = [];
for (const p of pages) {
	for (const mobile of [true, false]) {
		const profil = mobile ? 'mobile' : 'bureau';
		const etiquette = (p.url === '/' ? 'accueil' : p.url.replace(/^\/|\/$/g, '').replace(/\//g, '-')) + '-' + profil;
		/*
		 * Un score sous la cible ne se juge pas sur un passage : deux passages supplémentaires dans
		 * les mêmes conditions, et la MÉDIANE des trois est publiée — jamais le meilleur des trois.
		 */
		let runs = [mesurer(BASE + p.url, mobile, etiquette)];
		if (sousCible(runs[0])) {
			runs.push(mesurer(BASE + p.url, mobile, etiquette + '-r2'));
			runs.push(mesurer(BASE + p.url, mobile, etiquette + '-r3'));
		}
		const m = Object.fromEntries(['perf', 'a11y', 'bp', 'seo', 'lcp', 'cls', 'tbt'].map((k) => [k, mediane(runs.map((x) => x[k]))]));
		lignes.push({ ...p, profil, passages: runs.length, ...m });
		console.log(
			`${profil.padEnd(7)} ${p.nom.padEnd(20)} ` +
				`perf ${String(m.perf).padStart(3)} · a11y ${m.a11y} · bp ${m.bp} · seo ${m.seo} · ` +
				`LCP ${(m.lcp / 1000).toFixed(2)} s · CLS ${m.cls.toFixed(3)} · TBT ${Math.round(m.tbt)} ms` +
				(runs.length > 1 ? ` · médiane de ${runs.length}` : '')
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
