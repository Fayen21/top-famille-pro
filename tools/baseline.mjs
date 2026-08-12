#!/usr/bin/env node
/**
 * Baseline exhaustive : 53 routes × N largeurs, maquette Claude Design ↔ WordPress.
 *
 * Les outils existants répondent chacun à une question — hauteurs (`compare-routes`), cartes
 * (`inventaire-cartes`), cibles de pointage (`audit-target-size`). Aucun ne produit, en un seul
 * relevé comparable d'une passe à l'autre, l'état complet d'une route à une largeur donnée. Sans
 * cela, on ne peut pas dire d'une correction si elle a amélioré ce qu'elle visait **sans dégrader
 * autre chose** : c'est précisément ce que cette baseline permet.
 *
 * Sortie : `docs/baseline.json`, un objet `{ "<route>": { "<largeur>": { … } } }`, plus un résumé
 * lisible. Le JSON est la référence ; le Markdown n'en est qu'une vue.
 *
 * Usage :
 *   node tools/baseline.mjs                                  → 6 largeurs, écrit docs/baseline.json
 *   node tools/baseline.mjs --widths=768                     → une largeur
 *   node tools/baseline.mjs --only='#/contact'               → une route
 *   node tools/baseline.mjs --sortie=docs/baseline-apres.json
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const LARGEURS = arg('widths', '320,375,768,1024,1440,1920').split(',').map(Number);
const SORTIE = arg('sortie', 'docs/baseline.json');
const seules = arg('only', '') ? arg('only', '').split(',').map((s) => s.trim()) : null;

/**
 * Relevé d'une page rendue. Écrit pour tourner des deux côtés sans dépendre du balisage : la
 * maquette n'a ni classes stables ni sémantique, seul le **rendu** est comparable.
 */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	// Conteneur du flux de page : en-tête, pré-pied et pied sont identiques sur les 53 routes.
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = [...flux.querySelectorAll(':scope > section')].filter((s) => s.getBoundingClientRect().height > 20);

	/** Une carte : un bloc qui se distingue visuellement de son fond (fond, filet, rayon, ombre). */
	const estCarte = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		if (r.width < 60 || r.height < 30) return false;
		const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
		const filet = parseFloat(s.borderTopWidth) > 0 || parseFloat(s.borderLeftWidth) > 0;
		const rayon = parseFloat(s.borderTopLeftRadius) >= 6;
		const ombre = s.boxShadow && s.boxShadow !== 'none';
		return (fond || filet || ombre) && (rayon || fond || ombre);
	};

	const cartes = [...flux.querySelectorAll('*')].filter(estCarte);
	// Une micro-carte est une carte compacte : c'est le vocabulaire que la maquette emploie pour
	// éclater une énumération en tuiles, et sa perte ne se voit sur aucune mesure de hauteur.
	const micro = cartes.filter((c) => {
		const r = c.getBoundingClientRect();
		return r.height <= 140 && r.width <= 420;
	});

	/** Nombre de colonnes d'une grille : distinct des colonnes réellement occupées. */
	const grilles = [...flux.querySelectorAll('*')]
		.filter((el) => {
			const s = getComputedStyle(el);
			return s.display === 'grid' && el.children.length >= 2 && el.getBoundingClientRect().width > 120;
		})
		.map((el) => (getComputedStyle(el).gridTemplateColumns || '').split(' ').filter(Boolean).length);

	/** Ordre des composants, en lecture : ce qui distingue « même contenu » de « même page ». */
	const ordre = bandes.map((b) => {
		const t = b.querySelector('h1,h2,h3');
		return (txt(t) || txt(b).slice(0, 28)).slice(0, 40);
	});

	const images = [...flux.querySelectorAll('img')];

	return {
		hauteur: Math.round(document.documentElement.scrollHeight),
		sections: bandes.length,
		bandes: bandes.map((b) => Math.round(b.getBoundingClientRect().height)),
		cartes: cartes.length,
		microCartes: micro.length,
		grilles,
		ordre,
		images: images.length,
		imagesCassees: images.filter((i) => i.complete && i.naturalWidth === 0).length,
		tableaux: flux.querySelectorAll('table').length,
		formulaires: flux.querySelectorAll('form').length,
		faq: flux.querySelectorAll('details, [itemtype*="FAQPage"], .tfp-faq__item').length,
		cta: [...flux.querySelectorAll('a,button')].filter((a) => /devis|appeler|contact/i.test(txt(a))).length,
		mots: txt(flux).split(/\s+/).filter(Boolean).length,
		titres: flux.querySelectorAll('h2,h3,h4').length,
		debordement: Math.max(0, document.documentElement.scrollWidth - document.documentElement.clientWidth),
		// Un CTA hors de l'écran ou un texte coupé ne se voient sur aucune mesure de hauteur.
		horsEcran: [...flux.querySelectorAll('a,button')].filter((e) => {
			const r = e.getBoundingClientRect();
			return r.width > 0 && (r.left < -1 || r.right > document.documentElement.clientWidth + 1);
		}).length,
	};
};

/** Défile la page pour déclencher le chargement différé, puis remonte. */
const STABILISER = async () => {
	await new Promise((r) => (document.fonts ? document.fonts.ready.then(r) : r()));
	for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
		window.scrollTo(0, y);
		await new Promise((r) => setTimeout(r, 30));
	}
	window.scrollTo(0, 0);
	await new Promise((r) => setTimeout(r, 120));
};

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const routes = Object.keys(ROUTE_MAP).filter((r) => !seules || seules.includes(r));
const resultat = {};

for (const largeur of LARGEURS) {
	const ref = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);

	const wp = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });

	/*
	 * Observateur de décalage cumulé, enregistré **une fois par page** — et non à chaque route.
	 *
	 * `addInitScript` s'ajoute, il ne remplace pas : appelé dans la boucle, il faisait injecter à
	 * la cinquante-troisième route cinquante-trois copies du script, donc cinquante-trois
	 * observateurs, sur chaque chargement. Le relevé partait à dix secondes par contrôle et
	 * tombait à trois ou quatre minutes ; les 318 contrôles demandaient plus de vingt heures au
	 * lieu d'une demi-heure, et la lenteur se lisait comme une faiblesse du banc.
	 *
	 * Enregistré ici, le script s'exécute toujours à chaque navigation — c'est ce que fait
	 * `addInitScript` — et `window.__cls` repart donc bien de zéro à chaque route.
	 */
	await wp.addInitScript(() => {
		window.__cls = 0;
		new PerformanceObserver((l) => {
			for (const e of l.getEntries()) if (!e.hadRecentInput) window.__cls += e.value;
		}).observe({ type: 'layout-shift', buffered: true });
	});

	// Erreurs console et réseau : une page qui « a la bonne hauteur » mais jette une erreur
	// JavaScript n'est pas conforme (CLAUDE.md §10).
	let erreursConsole = [];
	let erreursReseau = [];
	wp.on('console', (m) => m.type() === 'error' && erreursConsole.push(m.text().slice(0, 120)));
	wp.on('requestfailed', (r) => erreursReseau.push(r.url().slice(-60)));

	for (const hash of routes) {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		await ref.evaluate(STABILISER);
		const a = await ref.evaluate(RELEVE);

		erreursConsole = [];
		erreursReseau = [];
		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await wp.evaluate(STABILISER);
		const b = await wp.evaluate(RELEVE);
		/*
		 * CLS **indicatif seulement**, et il faut le dire : le relevé fait défiler toute la page
		 * pour déclencher le chargement différé, et chaque image qui arrive sous les yeux compte
		 * alors comme un déplacement. La valeur obtenue est donc structurellement supérieure au CLS
		 * qu'un visiteur subit. Le chiffre qui fait foi est celui de Lighthouse
		 * (tools/lighthouse.mjs), mesuré sans défilement forcé. Ici, il ne sert qu'à repérer une
		 * route qui se déplacerait beaucoup plus que ses voisines.
		 */
		const cls = await wp.evaluate(() => Number(window.__cls || 0));

		const ratio = a.hauteur ? Math.round((b.hauteur / a.hauteur) * 100) : 0;
		(resultat[hash] ||= {})[largeur] = {
			ratio,
			ref: a,
			wp: b,
			cls: Number(cls.toFixed(4)),
			erreursConsole: [...new Set(erreursConsole)],
			erreursReseau: [...new Set(erreursReseau)],
		};

		const etat = ratio >= 95 && ratio <= 105 && !b.debordement ? '✅' : ratio >= 90 && ratio <= 110 ? '⚠️ ' : '❌';
		console.log(
			`${etat.padEnd(3)} ${String(largeur).padStart(4)}px ${hash.padEnd(40)} ` +
				`${String(ratio).padStart(3)} % · bandes ${a.sections}→${b.sections} · cartes ${String(a.cartes).padStart(2)}→${String(b.cartes).padStart(2)} · ` +
				`débord ${b.debordement} · CLS ${cls.toFixed(3)}`
		);
	}
	await ref.close();
	await wp.close();
}
await navigateur.close();

writeFileSync(SORTIE, JSON.stringify(resultat, null, 1) + '\n');

/* ------------------------------------------------------------------ */
/* Résumé                                                              */
/* ------------------------------------------------------------------ */

const total = routes.length * LARGEURS.length;
let dans = 0;
let deborde = 0;
let erreurs = 0;
for (const parLargeur of Object.values(resultat)) {
	for (const v of Object.values(parLargeur)) {
		if (v.ratio >= 95 && v.ratio <= 105) dans++;
		if (v.wp.debordement) deborde++;
		if (v.erreursConsole.length || v.erreursReseau.length) erreurs++;
	}
}
console.log(
	`\n${SORTIE} — ${total} contrôles · ${dans} dans 95-105 % · ${deborde} avec débordement · ${erreurs} avec erreur console ou réseau`
);
for (const largeur of LARGEURS) {
	const v = routes.map((r) => resultat[r][largeur]).filter(Boolean);
	console.log(
		`  ${String(largeur).padStart(4)} px : ${v.filter((x) => x.ratio >= 95 && x.ratio <= 105).length}/${v.length} dans 95-105 % · ` +
			`${v.filter((x) => x.ratio >= 98 && x.ratio <= 102).length} dans 98-102 %`
	);
}
