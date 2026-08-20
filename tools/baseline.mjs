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
import { writeFileSync, readFileSync, existsSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { SRC_BANDES } from './lib/bandes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const LARGEURS = arg('widths', '320,375,768,1024,1440,1920').split(',').map(Number);
const SORTIE = arg('sortie', 'docs/baseline.json');
/** Détail des phases sur chaque ligne : sert au diagnostic, pas au relevé courant. */
const CHRONO = process.argv.includes('--chrono');
const seules = arg('only', '') ? arg('only', '').split(',').map((s) => s.trim()) : null;

/*
 * Reprise et lots — la seule façon d'obtenir les 318 contrôles sur ce banc.
 *
 * Le relevé complet dure environ un quart d'heure de calcul, ce qui n'est rien ; mais le conteneur
 * de travail redémarre à intervalles irréguliers, et emporte avec lui tout processus long. Le
 * relevé n'a jamais été lent — il n'était pas REPRENABLE, et perdait la totalité de son travail à
 * chaque redémarrage. Trois passes s'y sont usées à chercher une lenteur qui n'existait pas.
 *
 * Le résultat est donc écrit après CHAQUE contrôle, et `--resume` repart d'un fichier existant en
 * sautant ce qui s'y trouve déjà. Relancer la même commande jusqu'à ce qu'elle annonce 318 sur 318
 * suffit, quel que soit le nombre de redémarrages subis.
 *
 * `--lot=N` ferme et rouvre le navigateur toutes les N routes : un seul Chromium vivant à la fois,
 * et aucune accumulation possible d'un lot sur l'autre.
 */
const REPRENDRE = process.argv.includes('--resume');
const LOT = Number(arg('lot', '0')) || 0;
/** Fichier de routes, une par ligne — les commentaires et les lignes vides sont ignorés. */
const FICHIER_ROUTES = arg('routes-file', '');

/**
 * Relevé d'une page rendue. Écrit pour tourner des deux côtés sans dépendre du balisage : la
 * maquette n'a ni classes stables ni sémantique, seul le **rendu** est comparable.
 */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	// Conteneur du flux de page : en-tête, pré-pied et pied sont identiques sur les 53 routes.
	// La détection du flux, elle, reste sur `section` seul : c'est le repère qui distingue le
	// conteneur de page de ses ancêtres, et il est vérifié symétrique sur les 53 routes. Le
	// découpage EN bandes, lui, est plus large — voir tools/lib/bandes.mjs.
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = window.__tfpBandes(flux);

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

const listeFichier = FICHIER_ROUTES
	? readFileSync(FICHIER_ROUTES, 'utf8')
		.split('\n')
		.map((l) => l.trim())
		.filter((l) => l.startsWith('#/'))
	: null;

const routes = Object.keys(ROUTE_MAP).filter(
	(r) => (!seules || seules.includes(r)) && (!listeFichier || listeFichier.includes(r))
);

/* Reprise : ce qui est déjà dans le fichier de sortie n'est pas remesuré. */
const resultat = REPRENDRE && existsSync(SORTIE) ? JSON.parse(readFileSync(SORTIE, 'utf8')) : {};
const dejaFait = (hash, largeur) => Boolean(resultat[hash] && resultat[hash][largeur]);
const restants = [];
for (const largeur of LARGEURS) for (const hash of routes) if (!dejaFait(hash, largeur)) restants.push([largeur, hash]);
console.log(
	`${routes.length} routes × ${LARGEURS.length} largeurs = ${routes.length * LARGEURS.length} contrôles · ` +
		`${restants.length} à faire${REPRENDRE ? ` (${routes.length * LARGEURS.length - restants.length} déjà relevés)` : ''}`
);

/** Écriture après chaque contrôle : un redémarrage ne coûte alors qu'un contrôle, pas la passe. */
const enregistrer = () => writeFileSync(SORTIE, JSON.stringify(resultat, null, 1) + '\n');

let navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const largeur of LARGEURS) {
	const aFaire = routes.filter((h) => !dejaFait(h, largeur));
	if (!aFaire.length) continue;

	/** Ouvre le couple de pages : maquette chargée une fois, page WordPress prête à naviguer. */
	const ouvrir = async () => {
		const r = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		await r.addInitScript(SRC_BANDES);
		await r.goto(REF, { waitUntil: 'load', timeout: 90000 });
		await r.waitForTimeout(5500);
		return r;
	};
	let ref = await ouvrir();
	let faitsDansLeLot = 0;

	// Erreurs console et réseau : une page qui « a la bonne hauteur » mais jette une erreur
	// JavaScript n'est pas conforme (CLAUDE.md §10).
	let erreursConsole = [];
	let erreursReseau = [];

	/**
	 * Page WordPress, avec son observateur de décalage et ses écouteurs d'erreurs.
	 *
	 * L'observateur est enregistré **une fois par page**, et non à chaque route : `addInitScript`
	 * ajoute un script, il ne le remplace pas, si bien qu'un appel par route faisait injecter
	 * cinquante-trois copies du script à la cinquante-troisième. Le script s'exécute de toute
	 * façon à chaque navigation, donc `window.__cls` repart bien de zéro à chaque route.
	 */
	const creerWp = async () => {
		const w = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		await w.addInitScript(SRC_BANDES);
		await w.addInitScript(() => {
			window.__cls = 0;
			new PerformanceObserver((l) => {
				for (const e of l.getEntries()) if (!e.hadRecentInput) window.__cls += e.value;
			}).observe({ type: 'layout-shift', buffered: true });
		});
		w.on('console', (m) => m.type() === 'error' && erreursConsole.push(m.text().slice(0, 120)));
		w.on('requestfailed', (r) => erreursReseau.push(r.url().slice(-60)));
		return w;
	};
	let wp = await creerWp();

	for (const hash of aFaire) {
		/*
		 * Lot terminé : on ferme tout et on repart d'un navigateur neuf. Un seul Chromium vit à la
		 * fois, et rien ne peut s'accumuler d'un lot sur l'autre.
		 */
		if (LOT && faitsDansLeLot >= LOT) {
			await ref.close();
			await wp.close();
			await navigateur.close();
			navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
			ref = await ouvrir();
			wp = await creerWp();
			faitsDansLeLot = 0;
		}

		/*
		 * Chronométrage **interne** de chaque contrôle, et de chacune de ses phases.
		 *
		 * La cadence de ce relevé a été jugée catastrophique lors d'une passe précédente — trois à
		 * cinq minutes par contrôle — sur la foi de comptages faits depuis l'extérieur du
		 * processus. Or l'horloge de ce bac à sable s'est révélée fausse : `date +%s` y rendait
		 * vingt-trois secondes là où plusieurs minutes s'étaient écoulées. Un chronomètre posé
		 * dans le processus lui-même ne dépend d'aucune de ces horloges, et dit ce qu'il en est.
		 */
		const t0 = Date.now();
		let tPhase = t0;
		const phases = {};
		const top = (nom) => {
			phases[nom] = Date.now() - tPhase;
			tPhase = Date.now();
		};

		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		top('bascule');
		await ref.evaluate(STABILISER);
		top('stabRef');
		const a = await ref.evaluate(RELEVE);
		top('releveRef');

		erreursConsole = [];
		erreursReseau = [];
		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		top('chargementWp');
		await wp.evaluate(STABILISER);
		top('stabWp');
		const b = await wp.evaluate(RELEVE);
		top('releveWp');
		/*
		 * CLS **indicatif seulement**, et il faut le dire : le relevé fait défiler toute la page
		 * pour déclencher le chargement différé, et chaque image qui arrive sous les yeux compte
		 * alors comme un déplacement. La valeur obtenue est donc structurellement supérieure au CLS
		 * qu'un visiteur subit. Le chiffre qui fait foi est celui de Lighthouse
		 * (tools/lighthouse.mjs), mesuré sans défilement forcé. Ici, il ne sert qu'à repérer une
		 * route qui se déplacerait beaucoup plus que ses voisines.
		 */
		const cls = await wp.evaluate(() => Number(window.__cls || 0));
		top('cls');

		const ratio = a.hauteur ? Math.round((b.hauteur / a.hauteur) * 100) : 0;
		(resultat[hash] ||= {})[largeur] = {
			ratio,
			ref: a,
			wp: b,
			cls: Number(cls.toFixed(4)),
			erreursConsole: [...new Set(erreursConsole)],
			erreursReseau: [...new Set(erreursReseau)],
			ms: Date.now() - t0,
			phases,
		};
		enregistrer();
		faitsDansLeLot++;

		const etat = ratio >= 95 && ratio <= 105 && !b.debordement ? '✅' : ratio >= 90 && ratio <= 110 ? '⚠️ ' : '❌';
		console.log(
			`${etat.padEnd(3)} ${String(largeur).padStart(4)}px ${hash.padEnd(40)} ` +
				`${String(ratio).padStart(3)} % · bandes ${a.sections}→${b.sections} · cartes ${String(a.cartes).padStart(2)}→${String(b.cartes).padStart(2)} · ` +
				`débord ${b.debordement} · CLS ${cls.toFixed(3)} · ${Date.now() - t0} ms` +
				(CHRONO ? ' · ' + Object.entries(phases).map(([k, v]) => `${k} ${v}`).join(' ') : '')
		);
	}
	await ref.close();
	await wp.close();
}
await navigateur.close();

enregistrer();

/* ------------------------------------------------------------------ */
/* Résumé                                                              */
/* ------------------------------------------------------------------ */

const attendus = routes.length * LARGEURS.length;
let total = 0;
let dans = 0;
let deborde = 0;
let erreurs = 0;
for (const parLargeur of Object.values(resultat)) {
	for (const v of Object.values(parLargeur)) {
		total++;
		if (v.ratio >= 95 && v.ratio <= 105) dans++;
		if (v.wp.debordement) deborde++;
		if (v.erreursConsole.length || v.erreursReseau.length) erreurs++;
	}
}
console.log(
	`\n${SORTIE} — ${total}/${attendus} contrôles · ${dans} dans 95-105 % · ${deborde} avec débordement · ${erreurs} avec erreur console ou réseau` +
	/*
	 * `docs/baseline.json` est la RÉFÉRENCE que `tests/ratios-baseline.spec.js` contrôle. Un relevé
	 * écrit ailleurs avec `--sortie=` ne la remplace pas : la suite continue alors de valider un
	 * état périmé, et passe au vert sur un site qui a changé. C'est arrivé le 20 août 2026 — le
	 * verrou validait le relevé d'un commit vieux de trois passes. L'avertissement ci-dessous
	 * existe pour que cela ne se reproduise pas en silence.
	 */
	(SORTIE !== 'docs/baseline.json'
		? `\n\n⚠  Ce relevé N'EST PAS la référence de la suite de tests.\n` +
			`   tests/ratios-baseline.spec.js lit docs/baseline.json, qui n'a pas été touché.\n` +
			`   Pour en faire la référence : cp ${SORTIE} docs/baseline.json`
		: '') +
		(total < attendus ? `\n⚠️  RELEVÉ INCOMPLET : relancer la même commande avec --resume jusqu'à ${attendus}/${attendus}.` : '')
);
for (const largeur of LARGEURS) {
	const v = routes.map((r) => resultat[r] && resultat[r][largeur]).filter(Boolean);
	console.log(
		`  ${String(largeur).padStart(4)} px : ${v.filter((x) => x.ratio >= 95 && x.ratio <= 105).length}/${v.length} dans 95-105 % · ` +
			`${v.filter((x) => x.ratio >= 98 && x.ratio <= 102).length} dans 98-102 %`
	);
}
