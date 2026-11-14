#!/usr/bin/env node
/**
 * Relevé des points de bascule **réels** de la maquette, famille de composants par famille.
 *
 * Le thème empile certaines compositions dès 819 px là où la maquette les tient jusque vers 707 px
 * utiles : à 768 px, sept routes sur 53 seulement tenaient dans la tolérance de hauteur. Corriger
 * cela suppose de connaître le seuil de chaque famille, pas d'en imposer un partout — rien ne dit
 * que la maquette emploie le même pour un hero, une grille de tâches et une bande tarifaire.
 *
 * La méthode : pour chaque conteneur multi-colonnes d'une route donnée, on balaie les largeurs et
 * on note **celle où il passe à une colonne**. La bascule est repérée sur le rendu (les enfants
 * partagent-ils encore une ligne ?), jamais lue dans une feuille de style : la maquette n'a pas de
 * CSS lisible, et le thème peut basculer par `flex-wrap` sans media query.
 *
 * Usage :
 *   node tools/breakpoints.mjs '#/service/bureaux' /prestations/bureaux/
 *   node tools/breakpoints.mjs --toutes        → les huit familles de gabarits
 */
import { chromium } from '@playwright/test';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

/** Largeurs de diagnostic : resserrées autour des seuils que le thème et la maquette emploient. */
const BALAYAGE = [1440, 1200, 1100, 1024, 900, 860, 820, 819, 800, 768, 767, 740, 720, 707, 700, 640, 600, 480, 375];

/** Une famille de gabarits = une route représentative des deux côtés. */
const FAMILLES = [
	['accueil', '#/', '/'],
	['prestation', '#/service/bureaux', '/prestations/bureaux/'],
	['pilier', '#/nettoyage-professionnel', '/nettoyage-professionnel/'],
	['tarifs', '#/nos-tarifs', '/tarifs/'],
	['departement', '#/departement/cote-dor', '/zones-intervention/cote-dor/'],
	['ville', '#/ville/dijon', '/zones-intervention/cote-dor/dijon/'],
	['article', '#/article/cout-nettoyage-bureaux', '/conseils/cout-nettoyage-bureaux/'],
	['contact', '#/contact', '/contact/'],
];

/**
 * Conteneurs multi-colonnes d'une page, avec le nombre de colonnes réellement occupées.
 *
 * « Réellement occupées » : on compte les enfants qui partagent une ordonnée, pas les pistes
 * déclarées. Une grille de quatre pistes dont trois sont vides est rendue sur une colonne.
 */
const RELEVE = () => {
	const res = [];
	for (const el of document.querySelectorAll('*')) {
		const s = getComputedStyle(el);
		if (s.display !== 'grid' && s.display !== 'flex') continue;
		const r = el.getBoundingClientRect();
		if (r.width < 200 || r.height < 40) continue;
		const enfants = [...el.children].filter((c) => c.getBoundingClientRect().height > 16);
		if (enfants.length < 2) continue;
		const rangs = new Set(enfants.map((c) => Math.round(c.getBoundingClientRect().top / 8)));
		const colonnes = Math.round(enfants.length / rangs.size);
		// Signature stable d'un conteneur d'une largeur à l'autre : ses premiers mots.
		const signature = (el.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 44);
		if (!signature) continue;
		res.push({ signature, colonnes, enfants: enfants.length, largeur: Math.round(r.width) });
	}
	return res;
};

const STABILISER = async () => {
	await new Promise((r) => (document.fonts ? document.fonts.ready.then(r) : r()));
	await new Promise((r) => setTimeout(r, 150));
};

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

/** Pour chaque signature, la largeur de fenêtre à laquelle le conteneur passe sous 2 colonnes. */
async function bascules(page, prepare) {
	const suivi = new Map();
	for (const largeur of BALAYAGE) {
		await page.setViewportSize({ width: largeur, height: 900 });
		await prepare();
		await page.evaluate(STABILISER);
		for (const c of await page.evaluate(RELEVE)) {
			if (!suivi.has(c.signature)) suivi.set(c.signature, []);
			suivi.get(c.signature).push({ fenetre: largeur, ...c });
		}
	}
	const out = new Map();
	for (const [sig, mesures] of suivi) {
		// Le balayage descend : la bascule est la première largeur où le conteneur tombe à 1 colonne
		// alors qu'il en avait plusieurs juste au-dessus.
		let precedent = null;
		for (const m of mesures) {
			if (precedent && precedent.colonnes >= 2 && m.colonnes < 2) {
				out.set(sig, { bascule: m.fenetre, avant: precedent.fenetre, colonnes: precedent.colonnes, utile: precedent.largeur });
				break;
			}
			precedent = m;
		}
		if (!out.has(sig) && precedent && precedent.colonnes >= 2) {
			out.set(sig, { bascule: null, avant: precedent.fenetre, colonnes: precedent.colonnes, utile: precedent.largeur });
		}
	}
	return out;
}

const cibles = process.argv[2] && !process.argv[2].startsWith('--')
	? [['ad hoc', process.argv[2], process.argv[3]]]
	: FAMILLES;

for (const [nom, hash, chemin] of cibles) {
	const ref = await navigateur.newPage({ viewport: { width: 1440, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const mRef = await bascules(ref, async () => {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(700);
	});
	await ref.close();

	const wp = await navigateur.newPage({ viewport: { width: 1440, height: 900 } });
	const mWp = await bascules(wp, async () => {
		await wp.goto(WP + chemin, { waitUntil: 'domcontentloaded', timeout: 60000 });
	});
	await wp.close();

	console.log(`\n=== ${nom}  (${hash})`);
	console.log('  bascule maquette → bascule WordPress · conteneur');
	const vus = new Set();
	for (const [sig, r] of mRef) {
		// Appariement par préfixe de texte : c'est le seul repère commun aux deux rendus.
		const cle = sig.replace(/[^a-zA-Z0-9]/g, '').slice(0, 24).toLowerCase();
		let w = null;
		for (const [s2, r2] of mWp) {
			if (s2.replace(/[^a-zA-Z0-9]/g, '').slice(0, 24).toLowerCase() === cle) {
				w = r2;
				break;
			}
		}
		if (!w || vus.has(cle)) continue;
		vus.add(cle);
		const ecart = (r.bascule ?? 0) - (w.bascule ?? 0);
		if (Math.abs(ecart) < 40) continue; // même seuil des deux côtés : rien à corriger.
		console.log(
			`  ${String(r.bascule ?? 'jamais').padStart(7)} → ${String(w.bascule ?? 'jamais').padStart(7)} ` +
				`(${r.colonnes} col sur ${r.utile} px utiles) · ${sig}`
		);
	}
}

await navigateur.close();
