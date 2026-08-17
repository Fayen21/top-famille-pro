#!/usr/bin/env node
/**
 * Audit des images PAR RÔLE — G26.
 *
 * Le contrôle G24/G25 comparait le NOMBRE d'images d'une page : une page pouvait afficher dix
 * visuels et être déclarée conforme alors que trois d'entre eux n'étaient pas ceux de la maquette,
 * ou n'étaient pas au bon endroit. C'est l'un des motifs du refus de validation du 17 août 2026.
 *
 * Cet outil apparie les images une par une, sur leur RÔLE dans la page — position dans le flux,
 * bande, taille rendue, texte voisin — puis compare les OCTETS : l'empreinte SHA-256 du fichier
 * réellement servi de chaque côté. Côté maquette les visuels sont des blobs : l'empreinte est
 * calculée sur les octets récupérés dans la page, ce qui les rend comparables aux fichiers du
 * thème (dont les variantes sont redimensionnées : l'empreinte diffère alors légitimement, et la
 * comparaison se fait sur la SOURCE du slot, relevée dans le manifeste).
 *
 * Sortie : docs/AUDIT-IMAGES-ROLE.md + docs/audit-images-role.json
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/audit-images-role.mjs [--routes=#/a,#/b]
 */
import { chromium } from '@playwright/test';
import { createHash } from 'node:crypto';
import { readFileSync, writeFileSync, existsSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const DIST = 'wp-content/themes/topfamillepro/assets/dist/images';
const arg = (n) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1];
const routes = arg('routes') ? arg('routes').split(',') : Object.keys(ROUTE_MAP);

const manifeste = JSON.parse(readFileSync(`${DIST}/manifest.json`, 'utf8'));
/** Empreinte de la SOURCE d'un slot : le fichier d'origine, avant redimensionnement. */
const SOURCES = JSON.parse(readFileSync('tools/sources-images.json', 'utf8'));

const sha = (buf) => createHash('sha256').update(buf).digest('hex');

/** Relevé des images d'une page, avec leur rôle déduit de la position et du voisinage. */
const RELEVE = () => {
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) { flux = el; break; }
	}
	const sections = [...flux.children].filter((c) => c.getBoundingClientRect().height >= 20);
	const bandeDe = (el) => { for (let i = 0; i < sections.length; i++) if (sections[i].contains(el)) return i + 1; return 0; };
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	return [...document.images]
		// Une image non rendue (menu mobile replié, élément masqué) n'est pas comparable : elle
		// n'est pas à l'écran d'un côté et le serait de l'autre selon l'état du menu.
		.filter((im) => { const r = im.getBoundingClientRect(); return r.width > 0 && r.height > 0; })
		.map((im, i) => {
		const r = im.getBoundingClientRect();
		/*
		 * En-tête DE PAGE, et non n'importe quel `<header>` (G26 §3).
		 *
		 * Un article a son propre `<header>` autour de son titre et de son visuel : `closest('header')`
		 * y voyait un logo d'en-tête, si bien que le visuel des trois articles était compté « en trop
		 * dans l'en-tête » et « manquant en hero » — alors que les deux côtés servent exactement les
		 * mêmes octets. Le repère est l'appartenance au contenu principal : un en-tête situé dans
		 * `<main>` ou dans un `<article>` n'est pas l'en-tête du site.
		 */
		const enTete = im.closest('header');
		const dansEntete = !!enTete && !enTete.closest('main, article');
		const dansPied = !!im.closest('footer');
		const bande = bandeDe(im);
		const bloc = im.closest('section, figure, article, li, div');
		/*
		 * Rôle déduit des SEULS critères communs aux deux rendus — balise ancêtre et géométrie —
		 * jamais d'une classe du thème : une classification qui diverge d'un côté décale tout
		 * l'appariement et fabrique de faux écarts.
		 */
		let role;
		if (dansEntete) role = 'logo-entete';
		else if (dansPied) role = 'logo-pied';
		else if (r.width <= 80) role = 'vignette';
		else if (bande <= 2 && r.width >= 300) role = 'hero';
		else role = 'editoriale';
		return {
			ordre: i, role, bande,
			rendu: Math.round(r.width) + '×' + Math.round(r.height),
			natif: im.naturalWidth + '×' + im.naturalHeight,
			src: im.currentSrc || im.src || '',
			alt: im.getAttribute('alt'),
			voisin: txt(bloc).slice(0, 60),
		};
	});
};

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const ref = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
await ref.waitForTimeout(5500);
const wp = await browser.newPage({ viewport: { width: 1440, height: 900 } });

const defiler = async (p) => {
	await p.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += 700) { window.scrollTo(0, y); await new Promise((r) => setTimeout(r, 40)); }
		window.scrollTo(0, 0);
	});
	await p.waitForFunction(() => [...document.images].every((i) => i.complete), null, { timeout: 15000 }).catch(() => {});
};

/** Empreinte des octets réellement affichés — côté maquette, les blobs sont relus dans la page. */
const empreintesMaquette = async (page) =>
	page.evaluate(async () => {
		const out = {};
		for (const im of document.images) {
			const u = im.currentSrc || im.src;
			if (!u || out[u]) continue;
			try {
				const b = await (await fetch(u)).arrayBuffer();
				let bin = '';
				const v = new Uint8Array(b);
				for (let i = 0; i < v.length; i++) bin += String.fromCharCode(v[i]);
				out[u] = btoa(bin);
			} catch { out[u] = null; }
		}
		return out;
	});

const lignes = [];
for (const hash of routes) {
	await ref.evaluate((h) => { window.scrollTo(0, 0); location.hash = h.replace(/^#/, ''); }, hash);
	await ref.waitForTimeout(1100);
	await defiler(ref);
	const a = await ref.evaluate(RELEVE);
	const octets = await empreintesMaquette(ref);
	for (const im of a) im.sha = octets[im.src] ? sha(Buffer.from(octets[im.src], 'base64')) : null;

	await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
	await defiler(wp);
	const b = await wp.evaluate(RELEVE);
	for (const im of b) {
		const fichier = (im.src || '').split('/').pop();
		const slot = Object.entries(manifeste).find(([, e]) =>
			['avif', 'webp', 'jpg'].some((f) => (e.variants?.[f] || []).some((v) => v.file === fichier))
		);
		im.slot = slot ? slot[0] : (fichier || '').replace(/\.[a-z]+$/, '');
		// Empreinte de la SOURCE du slot : c'est elle qui doit égaler celle de la maquette.
		const src = SOURCES[im.slot];
        im.sha = src && existsSync(src) ? sha(readFileSync(src)) : null;
		im.fichier = fichier;
	}

	/*
	 * Appariement dans l'ORDRE DU FLUX, rôle par rôle : deux pages fidèles présentent les mêmes
	 * rôles dans le même ordre. Un rôle présent d'un seul côté ressort alors comme manquant ou en
	 * trop à sa place exacte, au lieu de décaler tout le reste.
	 */
	const parRole = (liste) => liste.reduce((m, x) => ((m[x.role] ||= []).push(x), m), {});
	const ra = parRole(a), rb = parRole(b);
	const ordreRoles = ['logo-entete', 'hero', 'editoriale', 'vignette', 'logo-pied'];
	for (const role of ordreRoles.filter((r) => ra[r] || rb[r])) {
		const la = ra[role] || [], lb = rb[role] || [];
		for (let i = 0; i < Math.max(la.length, lb.length); i++) {
			const x = la[i], y = lb[i];
			let verdict;
			if (!x) verdict = 'EN TROP côté thème';
			else if (!y) verdict = 'MANQUANTE côté thème';
			else if (x.sha && y.sha && x.sha === y.sha) verdict = 'IDENTIQUE';
			else if (x.sha && y.sha) verdict = 'IMAGE DIFFÉRENTE';
			else verdict = 'empreinte indisponible';
			lignes.push({
				route: hash, role, rang: i + 1,
				maquette: x ? { rendu: x.rendu, natif: x.natif, sha: x.sha, voisin: x.voisin, alt: x.alt } : null,
				wordpress: y ? { rendu: y.rendu, natif: y.natif, sha: y.sha, slot: y.slot, fichier: y.fichier, alt: y.alt } : null,
				verdict,
			});
		}
	}
	const ko = lignes.filter((l) => l.route === hash && l.verdict !== 'IDENTIQUE').length;
	console.log(`${ko ? '⚠️ ' : '✅'} ${hash.padEnd(42)} ${lignes.filter((l) => l.route === hash).length} image(s) · ${ko} écart(s)`);
}
await browser.close();

const ecarts = lignes.filter((l) => l.verdict !== 'IDENTIQUE');
const L = ['# Audit des images par rôle — maquette ↔ WordPress', '',
	'> Fichier **généré** par `node tools/audit-images-role.mjs`. Ne pas éditer à la main.', '>',
	'> Les images sont appariées sur leur **rôle** dans la page (logo, hero, éditoriale, vignette),',
	'> pas comptées en bloc, puis comparées sur les **octets de leur source** (SHA-256).', '',
	`**${lignes.length} images auditées sur ${routes.length} routes · ${ecarts.length} écart(s).**`, '',
	'| Route | Rôle | # | SHA-256 maquette | SHA-256 WordPress | Slot | Résultat |', '|---|---|---:|---|---|---|---|'];
for (const l of lignes) {
	L.push(`| \`${l.route}\` | ${l.role} | ${l.rang} | ${l.maquette?.sha?.slice(0, 16) || '—'} | ${l.wordpress?.sha?.slice(0, 16) || '—'} | ${l.wordpress?.slot || '—'} | ${l.verdict === 'IDENTIQUE' ? '✅ identique' : '⚠️ ' + l.verdict} |`);
}
writeFileSync('docs/AUDIT-IMAGES-ROLE.md', L.join('\n') + '\n');
writeFileSync('docs/audit-images-role.json', JSON.stringify({ total: lignes.length, ecarts: ecarts.length, lignes }, null, 1) + '\n');
console.log(`\nÉcrit : docs/AUDIT-IMAGES-ROLE.md — ${lignes.length} images, ${ecarts.length} écart(s)`);
