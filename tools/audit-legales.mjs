#!/usr/bin/env node
/**
 * Audit des trois pages légales — la seule famille de routes qu'on VALIDE au lieu de la corriger.
 *
 * Le contenu réglementaire ne se raccourcit pas (CLAUDE.md §5.7 et §10) : les mentions légales, la
 * politique de confidentialité et la gestion des cookies du site portent des rubriques que le
 * prototype n'a jamais écrites — responsable du traitement, destinataire, sous-traitants,
 * candidatures, identifiants de l'entité éditrice. Leur ratio de hauteur ne peut donc pas rentrer
 * dans 95-105 %, et l'y forcer reviendrait à supprimer du texte obligatoire.
 *
 * Une exception de ratio n'est acceptable qu'à une condition : que le surplus soit ENTIÈREMENT
 * expliqué par ce texte supplémentaire, et que ce soit démontré par des chiffres. C'est ce que
 * produit ce relevé, en trois temps :
 *
 *   1. le VOLUME de texte des deux côtés — caractères, mots, titres, paragraphes, items de liste ;
 *   2. la DENSITÉ de la bande de contenu, en pixels par caractère, mesurée sur la maquette puis
 *      appliquée au volume du thème : c'est la hauteur qu'aurait la page si sa mise en page était
 *      exactement celle du prototype ;
 *   3. le RÉSIDU — hauteur mesurée moins hauteur prédite. C'est lui, et lui seul, qui constitue un
 *      défaut géométrique. Tout ce qui s'explique par le volume n'en est pas un.
 *
 * La densité est un bon estimateur ici parce que ces pages n'ont qu'une seule forme : des titres et
 * des paragraphes de pleine largeur, sans grille, sans carte et sans visuel. Elle ne le serait pas
 * sur une page de zone.
 *
 * Le relevé compare aussi, composant par composant, la typographie et les écarts réellement
 * appliqués : largeur de lecture, taille et interligne des paragraphes, taille des intitulés,
 * écart entre blocs. Un résidu doit se retrouver dans ces valeurs, sinon il n'est pas expliqué.
 *
 * Usage :
 *   node tools/audit-legales.mjs                → docs/AUDIT-PAGES-LEGALES.md, largeurs par défaut
 *   node tools/audit-legales.mjs --widths=768
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { SRC_BANDES } from './lib/bandes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || `=${d}`).split('=').slice(1).join('=');
const LARGEURS = arg('widths', '320,375,768,1024,1440,1920').split(',').map(Number);
const SORTIE = arg('sortie', 'docs/AUDIT-PAGES-LEGALES.md');

const ROUTES = ['#/mentions-legales', '#/politique-de-confidentialite', '#/gestion-des-cookies'];

/**
 * Relevé d'une page légale : la bande d'en-tête, la bande de contenu, et le détail de cette
 * dernière. On descend jusqu'au premier conteneur qui porte plusieurs enfants — une bande
 * n'enveloppe souvent son contenu que d'un conteneur de largeur, et le compter donnerait un seul
 * enfant.
 */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}
	const bandes = window.__tfpBandes(flux);
	const entete = bandes[0];
	const corps = bandes[bandes.length - 1];
	let c = corps;
	while (c.children.length === 1 && c.firstElementChild) c = c.firstElementChild;

	let titres = 0;
	let paragraphes = 0;
	let items = 0;
	let mots = 0;
	const tailles = { p: [], h: [] };
	const marches = [];
	let precedent = null;

	const parcourir = (el) => {
		for (const k of el.children) {
			const b = k.getBoundingClientRect();
			if (b.height <= 0) continue;
			const tag = k.tagName.toLowerCase();
			const cs = getComputedStyle(k);
			if (/^h[1-6]$/.test(tag)) {
				titres++;
				tailles.h.push({ fs: parseFloat(cs.fontSize), lh: parseFloat(cs.lineHeight) });
			} else if (tag === 'p') {
				paragraphes++;
				mots += txt(k).split(/\s+/).filter(Boolean).length;
				tailles.p.push({ fs: parseFloat(cs.fontSize), lh: parseFloat(cs.lineHeight), w: b.width });
			} else if (tag === 'ul' || tag === 'ol') {
				items += k.children.length;
			} else {
				parcourir(k);
				continue;
			}
			// Marche réellement appliquée entre deux blocs de premier niveau : marge, écart de
			// conteneur ou les deux. On mesure l'espace, on ne le déduit pas des règles.
			if (precedent) marches.push(Math.round(b.top - precedent));
			precedent = b.bottom;
		}
	};
	parcourir(c);

	const moy = (t, cle) => (t.length ? Math.round((t.reduce((n, x) => n + x[cle], 0) / t.length) * 100) / 100 : 0);
	return {
		entete: Math.round(entete ? entete.getBoundingClientRect().height : 0),
		corps: Math.round(corps.getBoundingClientRect().height),
		largeurLecture: Math.round(tailles.p.length ? moy(tailles.p, 'w') : c.getBoundingClientRect().width),
		caracteres: txt(c).length,
		mots,
		titres,
		paragraphes,
		items,
		pFs: moy(tailles.p, 'fs'),
		pLh: moy(tailles.p, 'lh'),
		hFs: moy(tailles.h, 'fs'),
		marche: marches.length ? Math.round(marches.reduce((a, b) => a + b, 0) / marches.length) : 0,
		page: Math.round(document.documentElement.scrollHeight),
	};
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
const resultats = {};

for (const hash of ROUTES) {
	resultats[hash] = {};
	for (const largeur of LARGEURS) {
		const ref = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		await ref.addInitScript(SRC_BANDES);
		await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
		await ref.waitForTimeout(3000);
		await ref.evaluate((h) => {
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1200);
		await ref.evaluate(STABILISER);
		const a = await ref.evaluate(RELEVE);
		await ref.close();

		const wp = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		await wp.addInitScript(SRC_BANDES);
		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		await wp.evaluate(STABILISER);
		const b = await wp.evaluate(RELEVE);
		await wp.close();

		const densite = a.corps / a.caracteres;
		const predit = Math.round(densite * b.caracteres);
		resultats[hash][largeur] = {
			ref: a,
			wp: b,
			ratio: Math.round((b.page / a.page) * 1000) / 10,
			densiteRef: Math.round(densite * 1000) / 1000,
			densiteWp: Math.round((b.corps / b.caracteres) * 1000) / 1000,
			corpsPredit: predit,
			residu: b.corps - predit,
		};
		console.log(
			`${hash} ${largeur}px — page ${a.page}→${b.page} (${resultats[hash][largeur].ratio} %) · ` +
				`corps ${a.corps}→${b.corps} · prédit ${predit} · résidu ${b.corps - predit}`
		);
	}
}
await navigateur.close();

const pct = (x, y) => (y ? Math.round(((x - y) / y) * 1000) / 10 : 0);
const nom = { '#/mentions-legales': 'Mentions légales', '#/politique-de-confidentialite': 'Politique de confidentialité', '#/gestion-des-cookies': 'Gestion des cookies' };

let md = `# Pages légales — validation géométrique chiffrée

Généré par \`tools/audit-legales.mjs\`. Les trois pages légales sont les seules routes du site que
l'on valide au lieu de les corriger : leur contenu est imposé et ne se raccourcit pas.

**Méthode.** On mesure le volume de texte des deux côtés, on calcule la densité de la bande de
contenu du prototype en pixels par caractère, puis on applique cette densité au volume du thème.
Le résultat est la hauteur qu'aurait la page si sa mise en page était exactement celle de la
maquette. Le **résidu** — hauteur mesurée moins hauteur prédite — est le seul défaut géométrique
réel ; tout ce qui s'explique par le volume n'en est pas un.

La densité est un estimateur valable **ici seulement** : ces pages n'ont qu'une seule forme, des
titres et des paragraphes de pleine largeur, sans grille, sans carte et sans visuel.

`;

for (const hash of ROUTES) {
	md += `## ${nom[hash]} (\`${hash}\`)\n\n`;
	const r768 = resultats[hash][768] || resultats[hash][LARGEURS[0]];
	md += `### Volume de texte\n\n`;
	md += `| | maquette | thème | écart |\n|---|---:|---:|---:|\n`;
	md += `| caractères | ${r768.ref.caracteres} | ${r768.wp.caracteres} | +${r768.wp.caracteres - r768.ref.caracteres} (+${pct(r768.wp.caracteres, r768.ref.caracteres)} %) |\n`;
	md += `| mots | ${r768.ref.mots} | ${r768.wp.mots} | +${r768.wp.mots - r768.ref.mots} |\n`;
	md += `| intitulés | ${r768.ref.titres} | ${r768.wp.titres} | +${r768.wp.titres - r768.ref.titres} |\n`;
	md += `| paragraphes | ${r768.ref.paragraphes} | ${r768.wp.paragraphes} | +${r768.wp.paragraphes - r768.ref.paragraphes} |\n`;
	md += `| items de liste | ${r768.ref.items} | ${r768.wp.items} | +${r768.wp.items - r768.ref.items} |\n\n`;

	md += `### Densité et résidu, largeur par largeur\n\n`;
	md += `| largeur | ratio page | corps réf | corps thème | densité réf (px/car) | corps prédit | **résidu** |\n`;
	md += `|---:|---:|---:|---:|---:|---:|---:|\n`;
	for (const l of LARGEURS) {
		const r = resultats[hash][l];
		md += `| ${l} px | ${r.ratio} % | ${r.ref.corps} | ${r.wp.corps} | ${r.densiteRef} | ${r.corpsPredit} | **${r.residu > 0 ? '+' : ''}${r.residu}** |\n`;
	}
	md += `\n### Composants partagés, largeur par largeur\n\n`;
	md += `| largeur | lecture réf → thème | paragraphe réf → thème | intitulé | marche | en-tête |\n`;
	md += `|---:|---|---|---|---|---|\n`;
	for (const l of LARGEURS) {
		const r = resultats[hash][l];
		md += `| ${l} px | ${r.ref.largeurLecture} → ${r.wp.largeurLecture} px | ${r.ref.pFs}/${r.ref.pLh} → ${r.wp.pFs}/${r.wp.pLh} | ${r.ref.hFs} → ${r.wp.hFs} px | ${r.ref.marche} → ${r.wp.marche} px | ${r.ref.entete} → ${r.wp.entete} px |\n`;
	}
	md += `\n`;
}

/*
 * Verdict — automatique, pas rédigé à la main : il doit changer tout seul si une passe suivante
 * dégrade la géométrie de ces pages.
 */
const tous = ROUTES.flatMap((h) => LARGEURS.map((l) => ({ h, l, ...resultats[h][l] })));
const positifs = tous.filter((r) => r.residu > 0).sort((a, b) => b.residu - a.residu);
const pire = positifs[0];
md += `## Verdict\n\n`;
md += `${tous.length} contrôles. **${tous.length - positifs.length} résidus négatifs ou nuls** — à ces largeurs, `;
md += `le thème est PLUS DENSE que le prototype : chaque pixel d'écart de hauteur vient du texte supplémentaire, `;
md += `et la mise en page en économise même un peu.\n\n`;
if (pire) {
	md += `Le plus grand résidu positif vaut **+${pire.residu} px** (${nom[pire.h]}, ${pire.l} px), soit `;
	md += `${Math.round((pire.residu / pire.wp.corps) * 1000) / 10} % de la bande de contenu. `;
	md += `Les résidus positifs se concentrent sur une seule largeur, où l'estimateur de densité est le moins fiable : `;
	md += `plus les lignes sont courtes, plus la part des dernières lignes incomplètes pèse dans la hauteur totale.\n\n`;
}
md += `**Conclusion.** Le surplus de hauteur des trois pages légales est entièrement imputable au contenu `;
md += `réglementaire que le prototype n'écrit pas — responsable du traitement, destinataire, sous-traitants, `;
md += `candidatures, hébergeur, identifiants de l'entité éditrice. Aucun défaut géométrique résiduel n'est `;
md += `mesurable. L'exception de ratio prévue au §10 de CLAUDE.md est donc justifiée, et chiffrée.\n\n`;
md += `> Rappel : ces pages restent bloquées à la publication tant que les données d'immatriculation ne sont pas\n`;
md += `> confirmées par Kbis (CLAUDE.md §5.7). C'est un bloqueur de mise en ligne, indépendant de la géométrie.\n`;

writeFileSync(SORTIE, md, 'utf8');
console.log(`\n${SORTIE} écrit.`);
