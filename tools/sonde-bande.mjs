#!/usr/bin/env node
/**
 * Sonde de bande — la boucle de validation d'un archétype, en une commande.
 *
 * La méthode imposée pour corriger une famille de composants est toujours la même : mesurer la
 * maquette, mesurer WordPress, **injecter temporairement** la règle de référence, vérifier son
 * effet, et seulement ensuite l'écrire dans le thème. Sans outil, cette boucle demande un script
 * jetable par archétype ; avec, elle demande une commande.
 *
 * Ce que la sonde affiche, bande par bande et largeur par largeur : la hauteur des deux côtés,
 * l'écart, le nombre de colonnes de la grille dominante de la bande, et la largeur des cartes.
 * Une correction n'est retenue que si elle rapproche la STRUCTURE — colonnes, largeur de carte,
 * retours à la ligne — et pas seulement la hauteur.
 *
 * Usage :
 *   node tools/sonde-bande.mjs '#/ville/dijon'
 *   node tools/sonde-bande.mjs '#/ville/dijon' --widths=700,720,768,800,820,1024
 *   node tools/sonde-bande.mjs '#/ville/dijon' --surcharge=/tmp/diag.css
 *   node tools/sonde-bande.mjs '#/ville/dijon' --bande=5        → une seule bande, en détail
 *
 * `--surcharge` injecte la feuille dans la seule page WordPress, après chargement. Ce n'est jamais
 * la correction finale : c'est l'hypothèse mise à l'épreuve.
 */
import { chromium } from '@playwright/test';
import { readFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { SRC_BANDES } from './lib/bandes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const hash = process.argv.slice(2).find((a) => !a.startsWith('--'));
if (!hash || !ROUTE_MAP[hash]) {
	console.error('Route inconnue. Exemple : node tools/sonde-bande.mjs \'#/ville/dijon\'');
	process.exit(2);
}
const LARGEURS = arg('widths', '320,375,700,720,768,800,820,1024,1440,1920').split(',').map(Number);
const SURCHARGE = arg('surcharge', '') ? readFileSync(arg('surcharge', ''), 'utf8') : '';
const BANDE = arg('bande', '') !== '' ? Number(arg('bande', '')) : null;

const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	/** Colonnes réellement occupées : le plus grand rang, un dernier rang incomplet ne compte pas. */
	const colonnes = (el) => {
		const r = [...el.children].map((c) => c.getBoundingClientRect()).filter((b) => b.height > 0);
		if (!r.length) return 0;
		const parY = new Map();
		for (const b of r) {
			const y = Math.round(b.top);
			let k = [...parY.keys()].find((x) => Math.abs(x - y) < 6);
			if (k === undefined) k = y;
			parY.set(k, (parY.get(k) || 0) + 1);
		}
		return Math.max(...parY.values());
	};
	const decrire = (g) => {
		const cartes = [...g.children].map((c) => Math.round(c.getBoundingClientRect().width)).filter(Boolean);
		return {
			classes: (g.className || '').toString().trim().slice(0, 44) || '<' + g.tagName.toLowerCase() + '>',
			enfants: g.children.length,
			col: colonnes(g),
			carte: cartes.length ? Math.min(...cartes) + '–' + Math.max(...cartes) : '—',
			gap: getComputedStyle(g).gap,
			largeur: Math.round(g.getBoundingClientRect().width),
		};
	};

	return window.__tfpBandes(flux).map((b, i) => {
		const grilles = [...b.querySelectorAll('*')]
			.filter((el) => {
				const s = getComputedStyle(el);
				if (el.children.length < 2 || el.getBoundingClientRect().width < 120) return false;
				return s.display === 'grid' || ((s.display === 'flex' || s.display === 'inline-flex') && s.flexWrap === 'wrap');
			})
			.sort((x, y) => y.children.length - x.children.length);
		// Grille dominante : celle qui range le plus d'enfants — c'est elle qui décide de la hauteur
		// de la bande. Le détail des AUTRES grilles est conservé : sur une bande qui superpose une
		// grille de colonnes et des listes de pastilles, la dominante est la liste, et ce n'est pas
		// elle qu'on corrige.
		const g = grilles[0];
		return {
			i,
			titre: txt(b.querySelector('h1,h2,h3')).slice(0, 34) || txt(b).slice(0, 34),
			h: Math.round(b.getBoundingClientRect().height),
			col: g ? colonnes(g) : 0,
			carte: g ? decrire(g).carte : '—',
			gap: g ? getComputedStyle(g).gap : '—',
			toutes: grilles.map(decrire),
		};
	});
};

const STABILISER = async () => {
	await new Promise((r) => (document.fonts ? document.fonts.ready.then(r) : r()));
	for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
		window.scrollTo(0, y);
		await new Promise((r) => setTimeout(r, 25));
	}
	window.scrollTo(0, 0);
	await new Promise((r) => setTimeout(r, 100));
};

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
console.log(`${hash}  →  ${ROUTE_MAP[hash].wp}${SURCHARGE ? '   [surcharge injectée]' : ''}\n`);

const cumul = [];
for (const largeur of LARGEURS) {
	const ref = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.addInitScript(SRC_BANDES);
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(3500);
	await ref.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, hash);
	await ref.waitForTimeout(1000);
	await ref.evaluate(STABILISER);
	const a = await ref.evaluate(RELEVE);
	const hRef = await ref.evaluate(() => Math.round(document.documentElement.scrollHeight));
	await ref.close();

	const wp = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await wp.addInitScript(SRC_BANDES);
	await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
	if (SURCHARGE) await wp.addStyleTag({ content: SURCHARGE });
	await wp.evaluate(STABILISER);
	const b = await wp.evaluate(RELEVE);
	const hWp = await wp.evaluate(() => Math.round(document.documentElement.scrollHeight));
	await wp.close();

	const ratio = hRef ? Math.round((hWp / hRef) * 1000) / 10 : 0;
	cumul.push([largeur, ratio]);
	console.log(
		`━━━ ${largeur} px — page ${hRef} → ${hWp} px · ${ratio} %${ratio >= 95 && ratio <= 105 ? ' ✅' : ''}`
	);
	console.log('    bande  hauteur réf→wp      Δ   colonnes   cartes réf → wp                gap réf → wp');
	const n = Math.max(a.length, b.length);
	for (let i = 0; i < n; i++) {
		if (BANDE !== null && i !== BANDE) continue;
		const x = a[i];
		const y = b[i];
		if (!x || !y) {
			console.log(`    ${String(i).padStart(5)}  ${x ? x.h + ' → —' : '— → ' + y.h}   BANDE NON APPARIÉE`);
			continue;
		}
		const d = y.h - x.h;
		const alerte = x.col !== y.col ? ' ⚠️' : '';
		console.log(
			`    ${String(i).padStart(5)}  ${String(x.h).padStart(5)} → ${String(y.h).padStart(5)}  ${String(d).padStart(5)}   ${String(x.col)} → ${String(y.col)}${alerte.padEnd(4)}  ${x.carte.padEnd(12)} → ${y.carte.padEnd(12)}  ${x.gap} → ${y.gap}   ${x.titre}`
		);
		// Une bande ne se corrige pas sur sa grille dominante : le détail dit laquelle diverge.
		if (BANDE !== null) {
			const n = Math.max(x.toutes.length, y.toutes.length);
			for (let k = 0; k < n; k++) {
				const p = x.toutes[k];
				const q = y.toutes[k];
				console.log(
					`             grille ${k}  réf ${p ? `${p.enfants} enf · ${p.col} col · ${p.carte} · ${p.largeur}px · ${p.gap}` : '—'}`.padEnd(74) +
						`wp ${q ? `${q.enfants} enf · ${q.col} col · ${q.carte} · ${q.largeur}px · ${q.gap} · ${q.classes}` : '—'}`
				);
			}
		}
	}
	console.log('');
}
await navigateur.close();

console.log('Ratios : ' + cumul.map(([w, r]) => `${w}px ${r}%`).join(' · '));
const dans = cumul.filter(([, r]) => r >= 95 && r <= 105).length;
console.log(`${dans}/${cumul.length} largeurs dans 95–105 %`);
