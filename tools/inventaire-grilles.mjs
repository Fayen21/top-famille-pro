#!/usr/bin/env node
/**
 * Inventaire des grilles — maquette Claude Design ↔ WordPress, aux six largeurs de contrôle.
 *
 * ## Pourquoi cet outil
 *
 * À 768 px, 5 routes sur 53 seulement tiennent dans la tolérance de hauteur, contre 38 à 41 aux
 * autres largeurs. La cause a été établie en G07 : la maquette ne replie pas ses colonnes sur des
 * seuils de FENÊTRE, elle les replie sur la place DISPONIBLE — `flex: 1 1 340px`,
 * `repeat(auto-fit, minmax(min(100%, 280px), 1fr))`, `clamp(22px, 3vw, 32px)`. Un seuil de fenêtre
 * reconstruit est faux des deux côtés du point de bascule, et 768 px tombe précisément dans la
 * zone où les seuils du thème (599 / 819 / 1099 px) et le repli réel de la maquette divergent le
 * plus.
 *
 * G07 a posé le repli intrinsèque sur les PAGES STATIQUES. Les gabarits — accueil, prestation,
 * zone, département — construisent encore certaines de leurs grilles eux-mêmes. Cet outil dit
 * lesquelles, et rien d'autre : c'est un relevé, pas une correction.
 *
 * ## Ce qu'il relève
 *
 * Une **grille** est ici tout conteneur qui range ses enfants sur plusieurs pistes : `display:grid`
 * ou `display:flex` avec `flex-wrap: wrap`, au moins deux enfants, et une largeur utile. Pour
 * chacune, des deux côtés :
 *
 *  - la règle DÉCLARÉE par le prototype (`element.style`) — la seule valeur juste à toutes les
 *    largeurs, et celle qu'il faut reprendre ;
 *  - la règle appliquée par le thème, avec la **requête média dont elle vient** : c'est ainsi
 *    qu'un seuil de fenêtre se distingue d'un repli intrinsèque ;
 *  - le nombre de colonnes RÉEL à chacune des six largeurs, la largeur utile, la largeur minimale
 *    d'une carte, l'écart entre pistes, la base de colonne (`flex-basis` / `minmax()`), le mode de
 *    remplissage (`auto-fit` / `auto-fill`), l'ordre des enfants et leur `span`.
 *
 * ## Appariement
 *
 * Par (rang de bande, rang de grille dans la bande). L'appariement des bandes est vérifié 1 pour 1
 * sur les 53 routes (tools/lib/bandes.mjs), il constitue donc un repère sûr — bien plus sûr qu'une
 * empreinte de texte, qui apparie mal deux grilles de même contenu et de structure différente.
 *
 * ## Sorties
 *
 *   docs/inventaire-grilles.brut.json — le relevé brut, reprenable, une entrée par route et largeur
 *   docs/inventaire-grilles.json      — l’inventaire agrégé par grille, exploitable par machine (§7)
 *   docs/INVENTAIRE-GRILLES.md    — la vue de lecture, classée par impact
 *
 * ## Usage
 *
 *   node tools/inventaire-grilles.mjs                       → les 53 routes, six largeurs
 *   node tools/inventaire-grilles.mjs --widths=768
 *   node tools/inventaire-grilles.mjs --routes='#/ville/dijon,#/'
 *   node tools/inventaire-grilles.mjs --resume               → reprend un relevé interrompu
 *
 * Comme la baseline, le relevé s'écrit après CHAQUE route : le conteneur de travail redémarre à
 * intervalles irréguliers, et un relevé non reprenable perd tout à chaque fois.
 */
import { chromium } from '@playwright/test';
import { writeFileSync, readFileSync, existsSync, readdirSync } from 'node:fs';
import { join } from 'node:path';
import { ROUTE_MAP } from './route-map.mjs';
import { SRC_BANDES } from './lib/bandes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const LARGEURS = arg('widths', '320,375,768,1024,1440,1920').split(',').map(Number);
/*
 * Deux fichiers, et non un : le relevé BRUT (reprenable) et l'AGRÉGAT (la vue par grille). Les
 * écrire au même chemin ferait écraser le relevé par l'agrégat en fin de passe, et `--resume`
 * repartirait alors d'un fichier qui n'a pas la forme attendue — le relevé recommencerait de zéro
 * à chaque interruption, exactement le défaut que la baseline a mis trois passes à corriger.
 */
const SORTIE = arg('sortie', 'docs/inventaire-grilles.brut.json');
const AGREGAT = arg('agregat', 'docs/inventaire-grilles.json');
const REPRENDRE = process.argv.includes('--resume');
const seules = arg('routes', '') ? arg('routes', '').split(',').map((s) => s.trim()) : null;

const routes = Object.keys(ROUTE_MAP).filter((r) => !seules || seules.includes(r));

/* ------------------------------------------------------------------ */
/* Relevé, exécuté dans la page                                        */
/* ------------------------------------------------------------------ */

const RELEVE = () => {
	const nb = (v) => Math.round(parseFloat(v) * 100) / 100 || 0;
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = window.__tfpBandes(flux);

	/**
	 * Règles CSS qui visent l'élément, avec la requête média dont elles viennent.
	 *
	 * C'est la seule façon de distinguer un seuil de FENÊTRE d'un repli intrinsèque : les deux
	 * produisent le même nombre de colonnes à une largeur donnée, et diffèrent partout ailleurs.
	 * Le style en ligne est relevé à part — c'est là que le prototype écrit ses valeurs, et donc
	 * la seule source de la règle de référence.
	 */
	const reglesDe = (el) => {
		const out = [];
		for (const feuille of document.styleSheets) {
			let regles;
			try {
				regles = feuille.cssRules;
			} catch (e) {
				continue; // feuille d'une autre origine
			}
			const visiter = (liste, media) => {
				for (const r of liste) {
					if (r.cssRules && r.conditionText !== undefined) {
						visiter(r.cssRules, media ? media + ' et ' + r.conditionText : r.conditionText);
						continue;
					}
					if (!r.selectorText) continue;
					let vise = false;
					try {
						vise = el.matches(r.selectorText);
					} catch (e) {
						continue;
					}
					if (!vise) continue;
					const interessant = [
						'display',
						'grid-template-columns',
						'gap',
						'column-gap',
						'row-gap',
						'flex',
						'flex-basis',
						'flex-wrap',
						'min-width',
						'max-width',
						'padding',
					]
						.map((p) => {
							const v = r.style.getPropertyValue(p);
							return v ? p + ': ' + v : '';
						})
						.filter(Boolean);
					if (interessant.length) out.push({ media: media || null, selecteur: r.selectorText, declare: interessant.join('; ') });
				}
			};
			visiter(regles, null);
		}
		return out;
	};

	/** Une grille : un conteneur qui range ses enfants sur plusieurs pistes. */
	const estGrille = (el) => {
		const s = getComputedStyle(el);
		if (el.children.length < 2) return false;
		if (el.getBoundingClientRect().width < 120) return false;
		if (s.display === 'grid' || s.display === 'inline-grid') return true;
		return (s.display === 'flex' || s.display === 'inline-flex') && s.flexWrap === 'wrap';
	};

	/** Rangs distincts occupés : deux enfants de même ordonnée sont sur le même rang. */
	const colonnesReelles = (el) => {
		const enfants = [...el.children].filter((c) => c.getBoundingClientRect().height > 0);
		if (!enfants.length) return 0;
		const parY = new Map();
		for (const c of enfants) {
			const y = Math.round(c.getBoundingClientRect().top);
			let cle = [...parY.keys()].find((k) => Math.abs(k - y) < 6);
			if (cle === undefined) cle = y;
			parY.set(cle, (parY.get(cle) || 0) + 1);
		}
		// Le nombre de colonnes est le plus grand rang occupé : un dernier rang incomplet ne
		// définit pas la grille.
		return Math.max(...parY.values());
	};

	const decrire = (el, iBande, iGrille) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		const enfants = [...el.children];
		const rectsEnfants = enfants.map((c) => c.getBoundingClientRect()).filter((b) => b.height > 0);
		const pistes = (s.gridTemplateColumns || '').split(' ').filter(Boolean);

		// Base de colonne déclarée côté enfants : `flex: 1 1 340px` s'écrit sur l'ENFANT, pas sur le
		// conteneur, et c'est la valeur qui décide du repli.
		const baseEnfant = enfants
			.slice(0, 3)
			.map((c) => {
				const cs = getComputedStyle(c);
				return {
					flexBasis: cs.flexBasis,
					flexGrow: cs.flexGrow,
					flexShrink: cs.flexShrink,
					minWidth: cs.minWidth,
					enLigne: (c.getAttribute('style') || '').slice(0, 220) || null,
					gridColumn: cs.gridColumn && cs.gridColumn !== 'auto' ? cs.gridColumn : null,
				};
			});

		const enLigne = el.getAttribute('style') || '';
		const gtc = s.gridTemplateColumns || '';

		return {
			bande: iBande,
			rang: iGrille,
			balise: el.tagName.toLowerCase(),
			classes: (el.className || '').toString().trim().slice(0, 120) || null,
			intitule: txt(el.closest('section, article, header')?.querySelector('h1,h2,h3')).slice(0, 60) || null,

			// Comportement observé
			display: s.display,
			colonnes: colonnesReelles(el),
			pistes: pistes.length,
			largeurUtile: nb(r.width) - nb(s.paddingLeft) - nb(s.paddingRight),
			largeurCarte: rectsEnfants.length ? Math.round(Math.min(...rectsEnfants.map((b) => b.width))) : 0,
			largeurCarteMax: rectsEnfants.length ? Math.round(Math.max(...rectsEnfants.map((b) => b.width))) : 0,
			gap: s.gap || null,
			columnGap: nb(s.columnGap),
			rowGap: nb(s.rowGap),
			enfantsRendus: rectsEnfants.length,

			// Règle de référence — le prototype écrit tout en style en ligne
			styleEnLigne: enLigne.slice(0, 320) || null,
			autoFit: /auto-fit/.test(gtc) || /auto-fit/.test(enLigne),
			autoFill: /auto-fill/.test(gtc) || /auto-fill/.test(enLigne),
			minmax: (enLigne.match(/minmax\([^)]*\)/) || gtc.match(/minmax\([^)]*\)/) || [null])[0],
			baseEnfant,

			// Provenance de la règle appliquée : c'est là que se lisent les seuils fixes
			regles: reglesDe(el),
		};
	};

	const grilles = [];
	bandes.forEach((bande, iBande) => {
		const dansLaBande = [...bande.querySelectorAll('*')].filter(estGrille);
		dansLaBande.forEach((el, iGrille) => grilles.push(decrire(el, iBande, iGrille)));
	});
	return { bandes: bandes.length, grilles };
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

/* ------------------------------------------------------------------ */
/* Relevé                                                              */
/* ------------------------------------------------------------------ */

const resultat = REPRENDRE && existsSync(SORTIE) ? JSON.parse(readFileSync(SORTIE, 'utf8')) : {};
const enregistrer = () => writeFileSync(SORTIE, JSON.stringify(resultat, null, 1) + '\n');

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });

for (const largeur of LARGEURS) {
	const aFaire = routes.filter((h) => !(resultat[h] && resultat[h][largeur]));
	if (!aFaire.length) continue;

	const ref = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.addInitScript(SRC_BANDES);
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5000);
	const wp = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
	await wp.addInitScript(SRC_BANDES);

	for (const hash of aFaire) {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1000);
		await ref.evaluate(STABILISER);
		const a = await ref.evaluate(RELEVE);

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await wp.evaluate(STABILISER);
		const b = await wp.evaluate(RELEVE);

		(resultat[hash] ||= {})[largeur] = { ref: a, wp: b };
		enregistrer();
		console.log(
			`${String(largeur).padStart(4)}px ${hash.padEnd(40)} grilles ${String(a.grilles.length).padStart(3)}→${String(b.grilles.length).padStart(3)}`
		);
	}
	await ref.close();
	await wp.close();
}
await navigateur.close();
enregistrer();

/* ------------------------------------------------------------------ */
/* Résolution du fichier source, par recherche dans le thème           */
/* ------------------------------------------------------------------ */

/**
 * Le DOM ne dit pas de quel fichier vient une classe. On la cherche donc dans les sources du
 * thème : la feuille de style pour la règle, les gabarits PHP pour l'endroit qui la pose.
 */
const THEME = 'wp-content/themes/topfamillepro';
const sources = [];
const arpenter = (dossier) => {
	for (const e of readdirSync(dossier, { withFileTypes: true })) {
		const p = join(dossier, e.name);
		if (e.isDirectory()) {
			if (!['assets', 'node_modules', '.git'].includes(e.name)) arpenter(p);
		} else if (/\.(css|php)$/.test(e.name)) {
			sources.push([p, readFileSync(p, 'utf8')]);
		}
	}
};
arpenter(THEME);

const fichiersDe = (classe) => {
	const css = [];
	const php = [];
	for (const [p, contenu] of sources) {
		if (!contenu.includes(classe)) continue;
		(p.endsWith('.css') ? css : php).push(p.replace(THEME + '/', ''));
	}
	return { css, php };
};

/* ------------------------------------------------------------------ */
/* Agrégation : une entrée par grille, pas une par occurrence          */
/* ------------------------------------------------------------------ */

/** Clé d'une grille : ce qui la rend identifiable d'une route à l'autre. */
const cle = (g) => (g.classes || g.balise) + ' | bande ' + g.bande + ' | rang ' + g.rang;

const inventaire = new Map();

for (const [hash, parLargeur] of Object.entries(resultat)) {
	const gabarit = ROUTE_MAP[hash]?.type || 'route';
	for (const [largeur, { ref, wp }] of Object.entries(parLargeur)) {
		// Appariement par (bande, rang) : l'appariement des bandes est vérifié 1 pour 1.
		const parCle = new Map();
		for (const g of ref.grilles) parCle.set(g.bande + '/' + g.rang, { ref: g });
		for (const g of wp.grilles) {
			const k = g.bande + '/' + g.rang;
			parCle.set(k, { ...(parCle.get(k) || {}), wp: g });
		}

		for (const [, paire] of parCle) {
			if (!paire.wp) continue; // grille de la maquette sans équivalent : relevé par composants.mjs
			const k = cle(paire.wp);
			let e = inventaire.get(k);
			if (!e) {
				const cl = (paire.wp.classes || '').split(/\s+/).filter((c) => c.startsWith('tfp-'))[0] || '';
				e = {
					selecteur: paire.wp.classes ? '.' + paire.wp.classes.split(/\s+/).join('.') : paire.wp.balise,
					classePrincipale: cl || null,
					balise: paire.wp.balise,
					intitule: paire.wp.intitule,
					fichiers: cl ? fichiersDe(cl) : { css: [], php: [] },
					gabarits: new Set(),
					routes: new Set(),
					colonnes: {},
					largeurUtile: {},
					largeurCarte: {},
					gap: {},
					regleMaquette: null,
					minmaxMaquette: null,
					baseMaquette: null,
					regleWp: null,
					minmaxWp: null,
					baseWp: null,
					autoFit: paire.wp.autoFit,
					autoFill: paire.wp.autoFill,
					seuilsFixes: new Set(),
					spanEnfants: new Set(),
					ordreInverse: false,
					divergences: {},
				};
				inventaire.set(k, e);
			}
			e.gabarits.add(gabarit);
			e.routes.add(hash);

			if (paire.ref) {
				e.colonnes[largeur] ||= { ref: paire.ref.colonnes, wp: paire.wp.colonnes };
				e.largeurUtile[largeur] ||= { ref: Math.round(paire.ref.largeurUtile), wp: Math.round(paire.wp.largeurUtile) };
				e.largeurCarte[largeur] ||= { ref: paire.ref.largeurCarte, wp: paire.wp.largeurCarte };
				e.gap[largeur] ||= { ref: paire.ref.gap, wp: paire.wp.gap };
				e.regleMaquette ||= paire.ref.styleEnLigne;
				e.minmaxMaquette ||= paire.ref.minmax;
				e.baseMaquette ||= paire.ref.baseEnfant?.[0]?.enLigne || paire.ref.baseEnfant?.[0]?.flexBasis || null;
				if (paire.ref.colonnes !== paire.wp.colonnes) {
					e.divergences[largeur] = {
						colonnes: paire.ref.colonnes + '→' + paire.wp.colonnes,
						largeurCarte: paire.ref.largeurCarte + '→' + paire.wp.largeurCarte,
					};
				}
			}
			e.regleWp ||= paire.wp.regles.map((r) => (r.media ? '@media ' + r.media + ' { ' : '') + r.selecteur + ' { ' + r.declare + ' }' + (r.media ? ' }' : '')).join(' · ') || null;
			e.minmaxWp ||= paire.wp.minmax;
			e.baseWp ||= paire.wp.baseEnfant?.[0]?.flexBasis || null;
			for (const r of paire.wp.regles) if (r.media) e.seuilsFixes.add(r.media);
			for (const b of paire.wp.baseEnfant) if (b.gridColumn) e.spanEnfants.add(b.gridColumn);
		}
	}
}

const liste = [...inventaire.values()].map((e) => ({
	...e,
	gabarits: [...e.gabarits].sort(),
	routes: [...e.routes].sort(),
	nbRoutes: e.routes.size,
	seuilsFixes: [...e.seuilsFixes].sort(),
	spanEnfants: [...e.spanEnfants].sort(),
	intrinseque: e.autoFit || e.autoFill || /flex-basis|flex:/.test(e.regleWp || '') || /px/.test(e.baseWp || ''),
	largeursDivergentes: Object.keys(e.divergences).map(Number).sort((a, b) => a - b),
}));

// Classement par impact : une grille divergente sur 26 routes coûte plus qu'une sur une seule.
liste.sort(
	(a, b) =>
		b.largeursDivergentes.length * b.nbRoutes - a.largeursDivergentes.length * a.nbRoutes ||
		b.nbRoutes - a.nbRoutes
);

writeFileSync(
	AGREGAT,
	JSON.stringify({ genere: 'node tools/inventaire-grilles.mjs', largeurs: LARGEURS, grilles: liste }, null, 1) + '\n'
);

/* ------------------------------------------------------------------ */
/* Vue de lecture                                                      */
/* ------------------------------------------------------------------ */

const L = LARGEURS;
const md = [];
md.push('# Inventaire des grilles — maquette ↔ WordPress');
md.push('');
md.push('> Généré par `node tools/inventaire-grilles.mjs`. Le JSON (`docs/inventaire-grilles.json`) est la référence ; ce fichier n’en est qu’une vue. Le relevé brut, reprenable, est dans `docs/inventaire-grilles.brut.json`.');
md.push('');
md.push(`Relevé sur ${routes.length} routes, aux largeurs ${L.join(' / ')} px. ${liste.length} grilles distinctes.`);
md.push('');
const divergentes = liste.filter((g) => g.largeursDivergentes.length);
md.push(`**${divergentes.length} grilles divergent** sur au moins une largeur. ${divergentes.filter((g) => g.largeursDivergentes.includes(768)).length} divergent à 768 px.`);
md.push('');
md.push('| # | Sélecteur | Gabarits | Routes | Colonnes (' + L.join('/') + ') | Largeurs divergentes | Seuil fixe | Intrinsèque |');
md.push('| - | --------- | -------- | -----: | ------------------------- | -------------------- | ---------- | ----------- |');
liste.forEach((g, i) => {
	const col = L.map((w) => {
		const c = g.colonnes[w];
		return c ? (c.ref === c.wp ? String(c.wp) : `**${c.ref}→${c.wp}**`) : '·';
	}).join('/');
	md.push(
		`| ${i + 1} | \`${g.selecteur.slice(0, 54)}\` | ${g.gabarits.join(', ').slice(0, 40)} | ${g.nbRoutes} | ${col} | ${g.largeursDivergentes.join(', ') || '—'} | ${g.seuilsFixes.join(' ; ').slice(0, 40) || '—'} | ${g.intrinseque ? 'oui' : '**non**'} |`
	);
});
md.push('');
md.push('## Détail des grilles divergentes');
md.push('');
for (const g of divergentes) {
	md.push(`### \`${g.selecteur}\``);
	md.push('');
	md.push(`- **intitulé de bande** : ${g.intitule || '—'}`);
	md.push(`- **gabarits** : ${g.gabarits.join(', ')} — ${g.nbRoutes} routes`);
	md.push(`- **fichiers** : CSS ${g.fichiers.css.join(', ') || '—'} · PHP ${g.fichiers.php.join(', ') || '—'}`);
	md.push(`- **règle déclarée par la maquette** : \`${g.regleMaquette || '—'}\``);
	md.push(`- **base de colonne maquette** : \`${g.baseMaquette || '—'}\` · minmax \`${g.minmaxMaquette || '—'}\``);
	md.push(`- **règle WordPress** : ${g.regleWp ? '`' + g.regleWp.slice(0, 400) + '`' : '—'}`);
	md.push(`- **base de colonne WordPress** : \`${g.baseWp || '—'}\` · minmax \`${g.minmaxWp || '—'}\``);
	md.push(`- **auto-fit** : ${g.autoFit ? 'oui' : 'non'} · **auto-fill** : ${g.autoFill ? 'oui' : 'non'} · **seuils fixes** : ${g.seuilsFixes.join(' ; ') || '—'}`);
	md.push(`- **span des enfants** : ${g.spanEnfants.join(' ; ') || '—'}`);
	md.push('');
	md.push('| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |');
	md.push('| ------: | ----------------- | ------------- | ------------- | --- |');
	for (const w of L) {
		if (!g.colonnes[w]) continue;
		const c = g.colonnes[w];
		const u = g.largeurUtile[w];
		const ca = g.largeurCarte[w];
		const ga = g.gap[w];
		md.push(
			`| ${w} | ${c.ref} → ${c.wp}${c.ref !== c.wp ? ' ⚠️' : ''} | ${u.ref} → ${u.wp} | ${ca.ref} → ${ca.wp} | ${ga.ref} → ${ga.wp} |`
		);
	}
	md.push('');
}
writeFileSync('docs/INVENTAIRE-GRILLES.md', md.join('\n') + '\n');

console.log(
	`\n${AGREGAT} · docs/INVENTAIRE-GRILLES.md — ${liste.length} grilles, ` +
		`${divergentes.length} divergentes dont ${divergentes.filter((g) => g.largeursDivergentes.includes(768)).length} à 768 px`
);
