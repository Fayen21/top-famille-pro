#!/usr/bin/env node
/**
 * Contrôle visuel et structurel des 53 routes : maquette Claude Design ↔ rendu WordPress.
 *
 * Contrairement à `compare-fidelite.mjs` (une page représentative par famille), cet outil parcourt
 * **toutes** les routes. Pour chacune il mesure les deux rendus, puis produit un triptyque
 * « référence | WordPress | différence » : la superposition en mode `difference` fait ressortir
 * immédiatement une section manquante, décalée ou d'une autre couleur, ce qu'une comparaison de
 * hauteurs seule ne montre pas.
 *
 * Les captures sont prises après chargement des polices, chargement réel des images (défilement
 * complet — sans cela le lazy-loading photographie des rectangles vides), neutralisation des
 * animations et stabilisation de la mise en page.
 *
 * Usage :
 *   node tools/compare-routes.mjs                    → 53 routes à 1440 px, mesures + triptyques
 *   node tools/compare-routes.mjs --widths=1440,375
 *   node tools/compare-routes.mjs --only=#/ville/dijon
 *   node tools/compare-routes.mjs --no-shots         → mesures seules (rapide)
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync, readFileSync } from 'node:fs';
import sharp from 'sharp';
import { ROUTE_MAP } from './route-map.mjs';
import { panneauDifference } from './lib/diff-visuel.mjs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const SHOT_DIR = 'docs/captures/comparaison';
const REPORT = 'docs/COMPARAISON-53-ROUTES.md';
/** Largeur d'un panneau du triptyque : assez lisible pour repérer un bloc absent, assez léger
 *  pour être versionné 53 fois sans alourdir le dépôt. */
const PANEL = 320;

const FREEZE_CSS = `*,*::before,*::after{animation:none!important;transition:none!important;
scroll-behavior:auto!important}`;

async function settle(page) {
	await page.addStyleTag({ content: FREEZE_CSS }).catch(() => {});
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
	await page.waitForTimeout(250);
}

/** Blocs de premier niveau du flux principal, avec hauteur, titre et contenu compté. */
async function measure(page) {
	return page.evaluate(() => {
		const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
		// Conteneur du flux de page : le plus proche ancêtre du H1 portant plusieurs `<section>`.
		// Prendre « l'élément qui a le plus d'enfants » comparerait, sur une page courte, la
		// coquille de l'application d'un côté (barre haute, contenu, pré-pied, pied) aux vraies
		// sections de l'autre — deux choses différentes, et un écart de comptage sans signification.
		let root = document.body;
		for (let el = document.querySelector('h1'); el; el = el.parentElement) {
			if (el.querySelectorAll(':scope > section').length >= 2) {
				root = el;
				break;
			}
		}
		return {
			total: document.documentElement.scrollHeight,
			overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
			images: document.images.length,
			broken: [...document.images].filter((i) => i.naturalWidth === 0).length,
			words: (document.body.innerText || '').split(/\s+/).filter(Boolean).length,
			headings: document.querySelectorAll('h2,h3').length,
			listItems: document.querySelectorAll('li').length,
			blocks: [...root.children]
				.filter((c) => c.getBoundingClientRect().height >= 20)
				.map((c) => {
					const h = c.querySelector('h1,h2,h3');
					return {
						h: Math.round(c.getBoundingClientRect().height),
						head: h ? txt(h).slice(0, 46) : '(' + txt(c).slice(0, 38) + ')',
					};
				}),
		};
	});
}

async function boot(browser, width) {
	const page = await browser.newPage({ viewport: { width, height: 900 } });
	await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await page.waitForTimeout(5500);
	return page;
}

async function goRoute(page, hash) {
	await page.evaluate((h) => {
		window.scrollTo(0, 0);
		location.hash = h.replace(/^#/, '');
	}, hash);
	await page.waitForTimeout(1100);
	await settle(page);
}

/** Triptyque référence | WordPress | différence, à panneaux de même largeur et même hauteur. */
async function triptych(refBuf, wpBuf, out) {
	// Les deux captures sont réduites à la MÊME largeur de panneau avant toute comparaison : un
	// écart de largeur fabriquerait un décalage horizontal qui noierait les vrais écarts.
	const [ab, bb] = await Promise.all([
		sharp(refBuf).resize({ width: PANEL }).png().toBuffer(),
		sharp(wpBuf).resize({ width: PANEL }).png().toBuffer(),
	]);
	/*
	 * Panneau de différence AMPLIFIÉ et MESURÉ (tools/lib/diff-visuel.mjs, G26). L'ancienne
	 * composition `difference` + `negate()` rendait un panneau blanc uniforme sur deux rendus
	 * proches : une image manquante ou un bloc déplacé y étaient invisibles, ce qui a motivé le
	 * refus de validation du 17 août 2026.
	 */
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
			{ input: diff, top: 0, left: PANEL * 2 + 16 },
		])
		.jpeg({ quality: 70 })
		.toFile(out);
	return pourcentage;
}

function pct(refV, wpV) {
	if (!refV) return '—';
	return Math.round((wpV / refV) * 100) + ' %';
}

async function main() {
	const shots = !process.argv.includes('--no-shots');
	const only = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1];
	const widths = ((process.argv.find((a) => a.startsWith('--widths=')) || '').split('=')[1] || '1440')
		.split(',')
		.map(Number);

	const refData = JSON.parse(readFileSync('tools/reference-routes.json', 'utf8'));
	// `--only` accepte une liste séparée par des virgules : mesurer une famille de pages après une
	// correction ciblée est le geste courant, et relancer les 53 routes pour trois pages coûte
	// vingt minutes.
	const seules = only ? only.split(',').map((s) => s.trim()).filter(Boolean) : null;
	let routes = refData.routes.filter((r) => !seules || seules.includes(r));
	if (seules && routes.length !== seules.length) {
		const absentes = seules.filter((s) => !routes.includes(s));
		console.error(`⚠️  routes inconnues, ignorées : ${absentes.join(', ')}`);
	}
	if (shots) mkdirSync(SHOT_DIR, { recursive: true });

	const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
	const results = {};

	for (const width of widths) {
		const refPage = await boot(browser, width);
		const wpPage = await browser.newPage({ viewport: { width, height: 900 } });

		for (const hash of routes) {
			const map = ROUTE_MAP[hash];
			if (!map) continue;
			const slug = hash.replace(/^#\//, '').replace(/\//g, '-') || 'accueil';

			await goRoute(refPage, hash);
			const ref = await measure(refPage);
			const refShot = shots ? await refPage.screenshot({ fullPage: true }) : null;

			await wpPage.goto(WP + map.wp, { waitUntil: 'networkidle', timeout: 60000 });
			await settle(wpPage);
			const wp = await measure(wpPage);
			const wpShot = shots ? await wpPage.screenshot({ fullPage: true }) : null;

			if (shots) await triptych(refShot, wpShot, `${SHOT_DIR}/${slug}-${width}.jpg`);

			(results[width] ||= {})[hash] = { ref, wp, map, slug };
			console.error(
				`  ${String(width).padStart(4)}px ${hash.padEnd(40)} ` +
					`blocs ${String(ref.blocks.length).padStart(2)}→${String(wp.blocks.length).padStart(2)} · ` +
					`hauteur ${String(ref.total).padStart(5)}→${String(wp.total).padStart(5)} (${pct(ref.total, wp.total).padStart(6)}) · ` +
					`mots ${String(ref.words).padStart(4)}→${String(wp.words).padStart(4)} (${pct(ref.words, wp.words).padStart(6)})` +
					(wp.overflow > 0 ? ` · DÉBORDEMENT +${wp.overflow}` : '') +
					(wp.broken ? ` · ${wp.broken} IMAGE(S) CASSÉE(S)` : '')
			);
		}
		await refPage.close();
		await wpPage.close();
	}
	await browser.close();

	// Rapport
	const L = [];
	L.push('# Comparaison des 53 routes — maquette Claude Design ↔ WordPress');
	L.push('');
	L.push('> Fichier **généré** par `node tools/compare-routes.mjs`. Ne pas éditer à la main.');
	L.push('>');
	L.push('> Les deux versions sont ouvertes dans le même navigateur, animations neutralisées, images');
	L.push('> réellement chargées (défilement complet préalable), polices chargées. Le triptyque');
	L.push('> `docs/captures/comparaison/<route>-<largeur>.jpg` montre, de gauche à droite : la maquette,');
	L.push('> le rendu WordPress, et leur différence pixel à pixel (les zones sombres sont les écarts).');
	L.push('>');
	L.push('> La proximité de hauteur ne prouve rien à elle seule : les colonnes « mots », « titres »');
	L.push('> et « puces » comptent le contenu réellement présent, et le détail bloc par bloc ci-dessous');
	L.push('> nomme chaque section manquante.');
	L.push('');
	for (const width of widths) {
		L.push(`## Synthèse à ${width} px`);
		L.push('');
		L.push('| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |');
		L.push('|---|---|---|---|---|---|---|---|---|---|');
		for (const hash of routes) {
			const r = results[width][hash];
			if (!r) continue;
			const { ref, wp, slug } = r;
			L.push(
				`| \`${hash}\` | \`${r.map.wp}\` | ${ref.blocks.length} → ${wp.blocks.length} | ` +
					`${ref.total} → ${wp.total} (${pct(ref.total, wp.total)}) | ` +
					`${ref.words} → ${wp.words} (${pct(ref.words, wp.words)}) | ` +
					`${ref.headings} → ${wp.headings} | ${ref.listItems} → ${wp.listItems} | ` +
					`${ref.images} → ${wp.images}${wp.broken ? ' ⚠️' + wp.broken + ' cassées' : ''} | ` +
					`${wp.overflow > 0 ? '⚠️ +' + wp.overflow : 'non'} | ` +
					(shots ? `[voir](captures/comparaison/${slug}-${width}.jpg)` : '—') +
					' |'
			);
		}
		L.push('');
	}
	const W = widths[0];
	L.push(`## Détail bloc par bloc à ${W} px`);
	L.push('');
	for (const hash of routes) {
		const r = results[W][hash];
		if (!r) continue;
		L.push(`### \`${hash}\` → \`${r.map.wp}\``);
		L.push('');
		L.push('| # | Bloc maquette | Bloc WordPress | Hauteur | État |');
		L.push('|---|---|---|---|---|');
		const n = Math.max(r.ref.blocks.length, r.wp.blocks.length);
		for (let i = 0; i < n; i++) {
			const a = r.ref.blocks[i];
			const c = r.wp.blocks[i];
			const d = a && c ? c.h - a.h : null;
			const state =
				d === null
					? a
						? '❌ absent côté WordPress'
						: '➕ en plus côté WordPress'
					: Math.abs(d) <= 8
						? '✅ identique'
						: Math.abs(d) <= 60
							? '≈ proche'
							: `⚠️ écart ${d > 0 ? '+' : ''}${d} px`;
			L.push(
				`| ${i + 1} | ${(a ? a.head : '—').replace(/\|/g, '/')} | ${(c ? c.head : '—').replace(/\|/g, '/')} | ` +
					`${a ? a.h : '—'} → ${c ? c.h : '—'} | ${state} |`
			);
		}
		L.push('');
	}
	// Une mesure partielle (`--only`) ne doit jamais écraser le rapport des 53 routes : un rapport
	// amputé se lit exactement comme un rapport complet, et il a déjà fallu le restaurer une fois.
	const sortie = seules ? REPORT.replace(/\.md$/, '.partiel.md') : REPORT;
	writeFileSync(sortie, L.join('\n') + '\n');
	console.error(`\nÉcrit : ${sortie}` + (shots ? ` et ${SHOT_DIR}/` : ''));
}

main().catch((e) => {
	console.error(e);
	process.exit(1);
});
