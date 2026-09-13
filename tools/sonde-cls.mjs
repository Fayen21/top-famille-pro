#!/usr/bin/env node
/**
 * Mesure CLS conforme Web Vitals — G24 phase B.
 *
 * Ce que la baseline mesure sous le nom « cls » est un compteur BRUT : somme de tous les
 * déplacements pendant une navigation qui fait ensuite défiler toute la page pour relever les
 * bandes. Utile pour repérer une route aberrante, faux comme métrique. Cet outil mesure le CLS
 * réel :
 *  - observateur installé par `addInitScript` AVANT la navigation (rien n'échappe au relevé) ;
 *  - un CONTEXTE NEUF par contrôle — aucune accumulation possible entre deux routes ;
 *  - `hadRecentInput` ignoré (aucune interaction n'est simulée de toute façon) ;
 *  - fenêtres de session Web Vitals : une fenêtre se ferme après 1 s sans entrée ou 5 s de durée,
 *    le CLS de la page est la PLUS GRANDE fenêtre — jamais la somme totale ;
 *  - les sources de chaque déplacement sont conservées (nœud, boîte avant/après) et rapportées
 *    pour la fenêtre maximale.
 *
 * Aucun défilement, aucun délai artificiel : navigation, stabilisation réseau, relevé.
 *
 * Usage :
 *   TFP_BASE_URL=http://localhost:8901 node tools/sonde-cls.mjs \
 *     [--widths=320,375,768,1024,1440,1920] [--routes=#/x,#/y] [--sortie=fichier.json] [--resume]
 */
import { chromium } from '@playwright/test';
import { readFileSync, writeFileSync, existsSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const arg = (n, d) => ((process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1] || d);
const WIDTHS = arg('widths', '320,375,768,1024,1440,1920').split(',').map(Number);
const SEULES = arg('routes', '') ? arg('routes', '').split(',') : null;
const SORTIE = arg('sortie', '');
const REPRENDRE = process.argv.includes('--resume');

const routes = Object.keys(ROUTE_MAP).filter((r) => !SEULES || SEULES.includes(r));
const resultat = REPRENDRE && SORTIE && existsSync(SORTIE) ? JSON.parse(readFileSync(SORTIE, 'utf8')) : {};

const OBSERVATEUR = () => {
	window.__shifts = [];
	const chemin = (el) => {
		if (!el || !el.tagName) return '?';
		const parts = [];
		for (let n = el; n && n.tagName && parts.length < 4; n = n.parentElement) {
			parts.unshift(n.tagName.toLowerCase() + (n.className && typeof n.className === 'string' && n.className.trim() ? '.' + n.className.trim().split(/\s+/)[0] : ''));
		}
		return parts.join(' > ');
	};
	new PerformanceObserver((l) => {
		for (const e of l.getEntries()) {
			if (e.hadRecentInput) continue;
			window.__shifts.push({
				t: e.startTime,
				v: e.value,
				sources: (e.sources || []).slice(0, 3).map((s) => ({
					noeud: chemin(s.node),
					avant: s.previousRect ? `${s.previousRect.width}×${s.previousRect.height}@${s.previousRect.x},${s.previousRect.y}` : '',
					apres: s.currentRect ? `${s.currentRect.width}×${s.currentRect.height}@${s.currentRect.x},${s.currentRect.y}` : '',
				})),
			});
		}
	}).observe({ type: 'layout-shift', buffered: true });
};

/** Fenêtres de session Web Vitals : écart max 1 s entre entrées, durée max 5 s. */
const fenetreMax = (shifts) => {
	let max = { valeur: 0, sources: [] };
	let cour = null;
	for (const s of shifts) {
		if (!cour || s.t - cour.fin > 1000 || s.t - cour.debut > 5000) {
			cour = { debut: s.t, fin: s.t, valeur: 0, sources: [] };
		}
		cour.fin = s.t;
		cour.valeur += s.v;
		cour.sources.push(...s.sources.map((x) => ({ ...x, contribution: s.v })));
		if (cour.valeur > max.valeur) max = cour;
	}
	return max;
};

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
let faits = 0;
for (const largeur of WIDTHS) {
	for (const hash of routes) {
		if (resultat[hash]?.[largeur] !== undefined) continue;
		const ctx = await browser.newContext({ viewport: { width: largeur, height: 900 } });
		const page = await ctx.newPage();
		await page.addInitScript(OBSERVATEUR);
		await page.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await page.waitForTimeout(1200);
		const shifts = await page.evaluate(() => window.__shifts || []);
		await ctx.close();
		const fen = fenetreMax(shifts);
		const cls = Number(fen.valeur.toFixed(4));
		(resultat[hash] ||= {})[largeur] = {
			cls,
			entrees: shifts.length,
			sources: cls > 0 ? fen.sources.sort((a, b) => b.contribution - a.contribution).slice(0, 4) : [],
		};
		faits++;
		console.log(`${cls > 0.01 ? '⚠️ ' : '✅'} ${String(largeur).padStart(4)}px ${hash.padEnd(42)} CLS ${cls.toFixed(4)} (${shifts.length} entrée(s))`);
		if (SORTIE) writeFileSync(SORTIE, JSON.stringify(resultat, null, 1) + '\n');
	}
}
await browser.close();

const tous = [];
for (const [h, par] of Object.entries(resultat)) for (const [w, r] of Object.entries(par)) tous.push({ h, w, ...r });
const au_dessus = tous.filter((x) => x.cls > 0.01);
console.log(`\n${tous.length} contrôle(s) · ${au_dessus.length} au-dessus de 0,010 · max ${Math.max(0, ...tous.map((x) => x.cls)).toFixed(4)}`);
for (const x of au_dessus.sort((a, b) => b.cls - a.cls).slice(0, 20)) {
	console.log(`  ${x.w}px ${x.h} → ${x.cls.toFixed(4)} · ${x.sources.map((s) => s.noeud).join(' · ').slice(0, 90)}`);
}
