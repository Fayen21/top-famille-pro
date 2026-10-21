#!/usr/bin/env node
/**
 * Audit du critère WCAG 2.2 « 2.5.8 Target Size (Minimum) », niveau AA.
 *
 * axe-core signale ce critère, mais il n'en implémente qu'une lecture partielle : il ne distingue
 * pas toujours l'exception « inline », et il ne dit pas laquelle des trois conditions est
 * satisfaite. Or c'est précisément ce qu'il faut savoir pour arbitrer entre fidélité visuelle et
 * conformité. Cet audit vérifie la règle telle qu'elle est écrite.
 *
 * Le critère est satisfait si **l'une** de ces conditions est vraie pour chaque cible de pointeur :
 *
 *  1. **Taille** — la cible fait au moins 24 × 24 px CSS.
 *  2. **Espacement** — un cercle de 24 px de diamètre centré sur la cible ne croise le cercle
 *     d'aucune autre cible. (Une cible plus petite reste conforme si elle est isolée.)
 *  3. **Inline** — la cible est dans une phrase, ou sa taille est contrainte par l'interligne du
 *     texte non-cible qui l'entoure.
 *  4. **Équivalent** — une autre commande de la même page fait la même chose et, elle, est conforme.
 *  5. **Indispensable** — la présentation est imposée juridiquement ou essentielle à l'information.
 *
 * ⚠️ 44 × 44 px, c'est le critère **2.5.5**, de niveau **AAA** — pas l'objectif de ce projet.
 * L'avoir confondu avec 2.5.8 a fait gonfler inutilement la hauteur des pages de zone.
 *
 * Usage :
 *   node tools/audit-target-size.mjs                  → 53 routes, 1440 px et 375 px
 *   node tools/audit-target-size.mjs '#/ville/dijon'
 *   node tools/audit-target-size.mjs --widths=375
 */
import { chromium } from '@playwright/test';
import { pathToFileURL } from 'node:url';
import { ROUTE_MAP } from './route-map.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const MIN = 24;

const only = process.argv.slice(2).find((a) => !a.startsWith('--'));
const widths = ((process.argv.find((a) => a.startsWith('--widths=')) || '').split('=')[1] || '1440,375')
	.split(',')
	.map(Number);

const routes = Object.keys(ROUTE_MAP).filter((r) => !only || r === only);

export const AUDIT = (MIN) => {
	/**
	 * Couche de positionnement d'une cible : l'élément fixe ou collant le plus proche au-dessus
	 * d'elle, ou `null` quand elle est dans le flux. Deux cibles de couches différentes ne se
	 * comparent PAS pour l'espacement — voir le commentaire de la condition d'espacement.
	 */
	const couche = (el) => {
		for (let n = el; n && n !== document.documentElement; n = n.parentElement) {
			const pos = getComputedStyle(n).position;
			if (pos === 'fixed' || pos === 'sticky') return n;
		}
		return null;
	};
	const cibles = [...document.querySelectorAll('a[href], button, input, select, textarea, [role="button"], summary, details > summary')]
		.filter((el) => {
			const r = el.getBoundingClientRect();
			const cs = getComputedStyle(el);
			// Une cible masquée, de taille nulle ou hors flux n'est pas une cible de pointeur.
			return r.width > 0 && r.height > 0 && cs.visibility !== 'hidden' && cs.display !== 'none';
		})
		.map((el) => {
			const r = el.getBoundingClientRect();
			return {
				el,
				couche: couche(el),
				x: r.left + window.scrollX,
				y: r.top + window.scrollY,
				w: r.width,
				h: r.height,
				cx: r.left + window.scrollX + r.width / 2,
				cy: r.top + window.scrollY + r.height / 2,
				display: getComputedStyle(el).display,
				tag: el.tagName.toLowerCase(),
				texte: (el.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 44),
				classe: (el.className || '').toString().split(/\s+/)[0] || '',
			};
		});

	/**
	 * Exception « inline » : la cible est rendue en ligne dans un flux de texte qui contient aussi
	 * du texte non-cible. On l'évalue sur le rendu, pas sur le balisage : un `<a>` passé en
	 * `display:block` par le CSS n'est plus inline, quoi qu'en dise le HTML.
	 */
	const estInline = (c) => {
		if (!/^inline/.test(c.display)) return false;
		const parent = c.el.parentElement;
		if (!parent) return false;
		const texteParent = (parent.textContent || '').replace(/\s+/g, ' ').trim();
		const texteCibles = [...parent.querySelectorAll('a[href], button')]
			.map((x) => (x.textContent || '').replace(/\s+/g, ' ').trim())
			.join(' ');
		// Du texte non-cible entoure la cible : la taille est bien contrainte par l'interligne.
		return texteParent.length > texteCibles.length + 10;
	};

	const violations = [];
	for (const c of cibles) {
		if (c.w >= MIN && c.h >= MIN) continue;
		if (estInline(c)) continue;

		// Condition d'espacement : deux cercles de 24 px de diamètre, centrés sur chaque cible,
		// ne doivent pas se croiser. Distance entre centres ≥ 24 px suffit donc.
		let voisineTropProche = null;
		for (const autre of cibles) {
			if (autre === c) continue;
			// Une cible FIXE n'a pas de position dans le document : `top + scrollY` lui en fabrique
			// une, qui glisse à travers la page au fil du défilement. Comparer une barre d'action
			// fixe au contenu qu'elle survole invente une adjacence dépendante du défilement ET de
			// la hauteur de fenêtre. C'est ce qui a fait signaler un lien du plan du site : la barre
			// d'appel mobile, `position: fixed; bottom: 0`, tombait dessus à 900 px de haut et pas à
			// 800. Un recouvrement de ce genre est une OCCULTATION (2.4.11), pas un défaut
			// d'espacement — chaque couche ne se compare donc qu'à elle-même.
			if (autre.couche !== c.couche) continue;
			const d = Math.hypot(autre.cx - c.cx, autre.cy - c.cy);
			if (d < MIN) {
				voisineTropProche = { texte: autre.texte, distance: Math.round(d) };
				break;
			}
		}
		if (!voisineTropProche) continue;

		violations.push({
			tag: c.tag,
			classe: c.classe,
			texte: c.texte,
			taille: `${Math.round(c.w)}×${Math.round(c.h)}`,
			display: c.display,
			voisine: voisineTropProche.texte,
			distance: voisineTropProche.distance,
		});
	}
	return { total: cibles.length, violations };
};

/*
 * Le module s'importe pour ses fixtures (tests/target-size.spec.js réutilise AUDIT tel quel sur des
 * pages de fixture) : le balayage des 53 routes ne se déclenche donc qu'en exécution directe.
 */
if (import.meta.url !== pathToFileURL(process.argv[1] || '').href) {
	// Importé comme module : rien à balayer.
} else {

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
let totalViolations = 0;

for (const width of widths) {
	const page = await browser.newPage({ viewport: { width, height: 900 } });
	console.log(`\n━━━ ${width} px ━━━`);
	for (const hash of routes) {
		await page.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		const r = await page.evaluate(AUDIT, MIN);
		totalViolations += r.violations.length;
		const etat = r.violations.length ? `❌ ${r.violations.length}` : '✅';
		console.log(`${etat.padEnd(5)} ${hash.padEnd(42)} ${String(r.total).padStart(3)} cibles`);
		for (const v of r.violations.slice(0, 6)) {
			console.log(
				`        <${v.tag}${v.classe ? '.' + v.classe : ''}> « ${v.texte} » ${v.taille} px, ` +
					`display ${v.display}, voisine « ${v.voisine} » à ${v.distance} px`
			);
		}
	}
	await page.close();
}
await browser.close();

console.log(
	`\nCritère 2.5.8 (AA, 24 × 24 px ou espacement ou inline) : ` +
		(totalViolations ? `❌ ${totalViolations} violation(s)` : '✅ aucune violation')
);
process.exit(totalViolations ? 1 : 0);

}
