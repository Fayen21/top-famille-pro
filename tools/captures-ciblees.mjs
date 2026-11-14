#!/usr/bin/env node
/**
 * Captures CIBLÉES maquette ↔ WordPress — G27 §13.
 *
 * ## Pourquoi des captures ciblées AVANT de reconstruire les volumes
 *
 * Les quatre volumes de comparaison couvrent 53 routes à quatre largeurs. Ils prouvent qu'aucune
 * page n'a régressé ; ils ne montrent PAS ce qui vient d'être corrigé, parce qu'une page entière
 * rendue à 320 px de large réduit une vignette de 56 px à sept pixels. Une correction du
 * formulaire ou de six vignettes y est invisible.
 *
 * Cet outil produit donc, pour chaque point corrigé, un quadriptyque à taille utile :
 *   maquette | WordPress | différence amplifiée et MESURÉE | ordre des bandes des deux côtés.
 *
 * Le taux affiché est la proportion de pixels dont l'écart de luminance dépasse le seuil de
 * perception (`tools/lib/diff-visuel.mjs`). Un panneau uniforme ne peut donc pas être pris pour
 * une validation : soit le taux est nul et les deux rendus se superposent, soit il ne l'est pas et
 * la zone est coloriée.
 *
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/captures-ciblees.mjs [--only=formulaire]
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import sharp from 'sharp';
import { panneauDifference } from './lib/diff-visuel.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const DIR = 'docs/captures/ciblees';
const DOC = 'docs/CAPTURES-CIBLEES.md';

const FREEZE = `*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}`;
/* L'en-tête collant est rendu statique PENDANT une découpe de bande : une capture pleine page
   photographierait sinon l'en-tête à sa position de défilement, par-dessus la bande — un artefact
   de la méthode de capture, pas une différence de page. Jamais appliqué quand la cible EST
   l'en-tête. */
const FREEZE_HEADER = `header,.tfp-header,[data-tfp-header],[style*="position:sticky"],[style*="position: sticky"]{position:static!important}`;

/* ------------------------------------------------------------------ cibles */

/** Sélecteur exécuté DANS la page : renvoie l'élément à découper, ou null pour la page entière. */
const CIBLES = {
	entete: () => document.querySelector('header') || document.body,
	bandeVignettes: () => {
		const h = [...document.querySelectorAll('h2')].find((x) => /Nos six prestations/.test(x.textContent || ''));
		return h ? h.closest('section') : null;
	},
	/*
	 * Formulaire : PAS la balise `<form>`.
	 *
	 * La maquette place l'indicateur d'étape et le chapô AVANT sa balise `<form>` ; le thème les
	 * met DANS le `<fieldset>`, parce qu'ils portent le nom accessible du groupe de champs.
	 * Découper les deux `<form>` décalait verticalement les deux panneaux de 101 px et coloriait
	 * la planche entière — un artefact de découpe, pas une différence de rendu.
	 *
	 * La zone comparable va donc du HAUT DE L'INDICATEUR D'ÉTAPE au BAS DU FORMULAIRE, des deux
	 * côtés. Ce repère est le même partout : le texte « Étape n sur 2 ».
	 */
	formulaire: () => {
		const form = document.querySelector('form');
		if (!form) return null;
		// Premier repère VISIBLE : l'étape masquée existe aussi dans le DOM du thème, et sa boîte
		// vaut zéro — la retenir plaçait le haut de la découpe en tête de document.
		const etape = [...document.querySelectorAll('span, div, legend')]
			.filter((el) => /^Étape \d sur 2$/.test((el.textContent || '').trim()))
			.find((el) => {
				const r = el.getBoundingClientRect();
				return r.width > 0 && r.height > 0;
			});
		if (!etape) return form;
		const a = etape.getBoundingClientRect();
		const b = form.getBoundingClientRect();
		return {
			__boite: true,
			x: Math.max(0, Math.min(a.left, b.left)),
			y: Math.min(a.top, b.top) + window.scrollY,
			width: Math.max(a.right, b.right) - Math.max(0, Math.min(a.left, b.left)),
			height: Math.max(a.bottom, b.bottom) - Math.min(a.top, b.top),
		};
	},
};

const CAS = [
	{ nom: 'entete', titre: 'En-tête et navigation', ref: '#/', wp: '/', cible: 'entete', largeurs: [375, 1440] },
	{ nom: 'pilier', titre: 'Page pilier, page entière', ref: '#/nettoyage-professionnel', wp: '/nettoyage-professionnel/', cible: null, largeurs: [375, 1440] },
	{ nom: 'pilier-vignettes', titre: 'Pilier — bande des six vignettes de 56 px', ref: '#/nettoyage-professionnel', wp: '/nettoyage-professionnel/', cible: 'bandeVignettes', largeurs: [375, 768, 1440] },
	{ nom: 'formulaire-etape1', titre: 'Formulaire de devis — étape 1', ref: '#/demande-de-devis', wp: '/demande-de-devis/', cible: 'formulaire', largeurs: [375, 1440] },
	{ nom: 'formulaire-etape2', titre: 'Formulaire de devis — étape 2', ref: '#/demande-de-devis', wp: '/demande-de-devis/', cible: 'formulaire', largeurs: [375, 1440], etape: 2 },
	{ nom: 'pourquoi', titre: 'Pourquoi Top-Famille Pro', ref: '#/pourquoi-top-famille-pro', wp: '/pourquoi-nous/', cible: null, largeurs: [375] },
	{ nom: 'avis', titre: 'Avis clients', ref: '#/avis-clients', wp: '/avis-clients/', cible: null, largeurs: [320] },
	{ nom: 'region', titre: 'Page région Bourgogne-Franche-Comté', ref: '#/bourgogne-franche-comte', wp: '/bourgogne-franche-comte/', cible: null, largeurs: [1440] },
];

/* ------------------------------------------------------------- instruments */

/** Titres de bandes dans l'ordre du flux — ce qui permet de dire si une bande a changé de rang. */
const ORDRE_BANDES = () => {
	const racine = document.querySelector('main') || document.body;
	const vus = [];
	for (const t of racine.querySelectorAll('h1, h2')) {
		const r = t.getBoundingClientRect();
		// Un titre réservé aux lecteurs d'écran mesure 1 px : il structure le document mais ne
		// compose aucune bande. Le compter faisait déclarer « ordre différent » sur des pages
		// strictement identiques à l'œil.
		if (r.width <= 2 || r.height <= 2) continue;
		const txt = (t.textContent || '').replace(/\s+/g, ' ').trim();
		if (txt) vus.push(txt.slice(0, 60));
	}
	return vus;
};

async function stabiliser(page, figerEntete) {
	await page.addStyleTag({ content: FREEZE + (figerEntete ? FREEZE_HEADER : '') }).catch(() => {});
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += 700) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 60));
		}
		window.scrollTo(0, 0);
	});
	await page.waitForFunction(() => [...document.images].every((i) => i.complete), null, { timeout: 15000 }).catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(300);
}

/**
 * Passe le formulaire à l'étape 2 des deux côtés, en remplissant ce que la validation exige.
 *
 * Rien n'est soumis : côté thème le bouton d'étape est un `type="button"`, côté maquette le
 * formulaire est intercepté par son propre gestionnaire. Les valeurs saisies sont neutres et ne
 * servent qu'à franchir la validation.
 */
async function passerEtape2(page) {
	await page.evaluate(() => {
		const f = document.querySelector('form');
		if (!f) return;
		/*
		 * Tous les champs VISIBLES sont renseignés, pas seulement ceux qui portent `required` : la
		 * maquette marque ses champs obligatoires en `aria-required` et les contrôle dans son
		 * propre gestionnaire. Ne remplir que `[required]` laissait le prototype à l'étape 1,
		 * panneau d'erreur affiché, et la planche comparait une étape 1 à une étape 2.
		 *
		 * Le piège à robots est exclu explicitement : le remplir ferait rejeter la demande.
		 */
		const valeurs = { ville: 'Dijon', code_postal: '21000', nom: 'Test', telephone: '06 00 00 00 00', email: 'test@example.fr' };
		f.querySelectorAll('input, select, textarea').forEach((el) => {
			const r = el.getBoundingClientRect();
			if (el.type === 'hidden' || r.left < -1000 || r.width === 0) return;
			if (el.name === 'tfp_site_web') return;
			if (el.tagName === 'SELECT') {
				const o = [...el.options].find((x) => x.value !== '' && x.textContent.trim() !== 'Choisir…');
				if (o && el.value === '') el.value = o.value;
			} else if (el.type === 'checkbox') {
				el.checked = true;
			} else if (!el.value) {
				el.value = valeurs[el.name] || 'Test';
			}
			el.dispatchEvent(new Event('input', { bubbles: true }));
			el.dispatchEvent(new Event('change', { bubbles: true }));
		});
		const next = f.querySelector('[data-step-next]')
			|| [...f.querySelectorAll('button')].find((b) => /continuer/i.test(b.textContent || ''));
		if (next) next.click();
	});
	await page.waitForTimeout(900);
}

async function capturer(page, cibleNom) {
	if (!cibleNom) return page.screenshot({ fullPage: true });
	const boite = await page.evaluate((fn) => {
		// eslint-disable-next-line no-eval
		const el = eval(fn)();
		if (!el) return null;
		// Une cible peut renvoyer directement une boîte calculée (union de deux éléments).
		if (el.__boite) return el;
		el.scrollIntoView();
		const r = el.getBoundingClientRect();
		return { x: Math.max(0, r.x), y: r.y + window.scrollY, width: r.width, height: r.height };
	}, `(${CIBLES[cibleNom].toString()})`);
	if (!boite || boite.width < 2 || boite.height < 2) return null;
	return page.screenshot({ clip: boite, fullPage: true });
}

/** Quadriptyque : maquette | WordPress | différence amplifiée, plus le taux mesuré retourné. */
async function planche(refBuf, wpBuf, sortie, panneau) {
	const [ab, bb] = await Promise.all([
		sharp(refBuf).resize({ width: panneau }).png().toBuffer(),
		sharp(wpBuf).resize({ width: panneau }).png().toBuffer(),
	]);
	const { png: diff, hauteur: H, pourcentage, amplification } = await panneauDifference(ab, bb);
	const pad = (buf) =>
		sharp({ create: { width: panneau, height: H, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [ap, bp] = await Promise.all([pad(ab), pad(bb)]);
	await sharp({ create: { width: panneau * 3 + 16, height: H, channels: 3, background: '#d0d0d0' } })
		.composite([
			{ input: ap, top: 0, left: 0 },
			{ input: bp, top: 0, left: panneau + 8 },
			{ input: diff, top: 0, left: (panneau + 8) * 2 },
		])
		.jpeg({ quality: 78, mozjpeg: true })
		.toFile(sortie);
	return { pourcentage, amplification, hauteur: H };
}

/* ------------------------------------------------------------------- passe */

const seul = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1] || '';
mkdirSync(DIR, { recursive: true });

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const lignes = [];

for (const cas of CAS) {
	if (seul && cas.nom !== seul) continue;
	for (const largeur of cas.largeurs) {
		const figerEntete = cas.cible !== 'entete';
		const cotes = {};
		for (const [nom, url, hash] of [
			['maquette', REF, cas.ref],
			['site', WP + cas.wp, null],
		]) {
			const page = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
			await page.goto(url, { waitUntil: hash ? 'load' : 'networkidle', timeout: 90000 });
			if (hash) {
				await page.waitForTimeout(5000);
				await page.evaluate((h) => { location.hash = h; }, hash);
				await page.waitForTimeout(1200);
			}
			await stabiliser(page, figerEntete);
			if (cas.etape === 2) await passerEtape2(page);
			cotes[nom] = {
				shot: await capturer(page, cas.cible),
				bandes: await page.evaluate(ORDRE_BANDES),
			};
			await page.close();
		}

		const fichier = `${DIR}/${cas.nom}-${largeur}.jpg`;
		if (!cotes.maquette.shot || !cotes.site.shot) {
			lignes.push({ cas, largeur, fichier: null, erreur: 'cible introuvable d’un côté' });
			console.log(`⚠ ${cas.nom} ${largeur} : cible introuvable`);
			continue;
		}
		const panneau = Math.min(520, Math.max(320, largeur));
		const m = await planche(cotes.maquette.shot, cotes.site.shot, fichier, panneau);
		lignes.push({ cas, largeur, fichier, mesure: m, bandes: { maquette: cotes.maquette.bandes, site: cotes.site.bandes } });
		console.log(`écrit : ${fichier} — écart ${m.pourcentage} % (amplification ×${m.amplification})`);
	}
}
await navigateur.close();

/* ------------------------------------------------------------- restitution */

const ordreIdentique = (a, b) => a.length === b.length && a.every((x, i) => x === b[i]);

let md = `# Captures ciblées — G27 §13\n\n`;
md += `> Produites par \`tools/captures-ciblees.mjs\` sur le banc local, **avant** la reconstruction\n`;
md += `> des quatre volumes de comparaison. Chaque planche porte trois panneaux — maquette, WordPress,\n`;
md += `> différence amplifiée — et chaque ligne porte le taux mesuré et l'ordre des bandes des deux côtés.\n\n`;
md += `> Le taux est la proportion de pixels dont l'écart de luminance dépasse le seuil de perception.\n`;
md += `> Il n'est pas un score de fidélité : une page plus longue d'un côté colorie toute la zone\n`;
md += `> manquante, et une différence voulue — une mention obligatoire, un champ de contexte — compte\n`;
md += `> comme une différence. Il sert à repérer *où* regarder, pas à conclure.\n\n`;
md += `| Cible | Largeur | Écart mesuré | Ordre des bandes | Planche |\n|---|---|---|---|---|\n`;
for (const l of lignes) {
	if (!l.fichier) {
		md += `| ${l.cas.titre} | ${l.largeur} px | — | — | ⚠ ${l.erreur} |\n`;
		continue;
	}
	const n = l.bandes.site.length;
	const ordre = ordreIdentique(l.bandes.maquette, l.bandes.site)
		? `identique (${n} bande${n > 1 ? 's' : ''})`
		: `**différent** — ${l.bandes.maquette.length} contre ${n}`;
	md += `| ${l.cas.titre} | ${l.largeur} px | ${l.mesure.pourcentage} % (×${l.mesure.amplification}) | ${ordre} | \`${l.fichier}\` |\n`;
}

md += `\n---\n\n## Ordre des bandes, côté par côté\n\n`;
for (const l of lignes) {
	if (!l.fichier) continue;
	md += `### ${l.cas.titre} — ${l.largeur} px\n\n`;
	md += `| # | Maquette | WordPress |\n|---|---|---|\n`;
	const rangs = Math.max(l.bandes.maquette.length, l.bandes.site.length);
	for (let i = 0; i < rangs; i += 1) {
		const a = l.bandes.maquette[i] || '—';
		const b = l.bandes.site[i] || '—';
		md += `| ${i + 1} | ${a === b ? a : `*${a}*`} | ${a === b ? b : `**${b}**`} |\n`;
	}
	md += `\n`;
}
/*
 * Une passe partielle n'écrase PAS le document complet : `--only` sert au réglage d'une seule
 * planche, et réécrire le tableau avec une seule ligne effacerait les treize autres.
 */
const doc = seul ? DOC.replace(/\.md$/, `-${seul}.md`) : DOC;
writeFileSync(doc, md);
console.log(`écrit : ${doc}`);
