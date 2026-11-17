#!/usr/bin/env node
/**
 * Alignements — 17 novembre 2026, après les captures d'Emmanuel.
 *
 * Sur les 53 routes, à une largeur donnée (1440 par défaut), deux défauts sont recherchés :
 *
 *  1. BORD GAUCHE — dans chaque section du corps de page, l'élément de contenu le plus à gauche
 *     (titre, paragraphe, grille, carte, FAQ) doit partir du bord du conteneur de la page, celui du
 *     logo. Une section volontairement centrée (bandeau d'appel, `text-align:center`) est ignorée.
 *  2. TITRES VOISINS — deux titres (h2/h3) côte à côte (colonnes qui ne se recouvrent pas,
 *     écart vertical < 90 px) doivent partir de la même hauteur.
 *
 * Usage : node tools/scan-alignements.mjs [largeur] [base]  → code de sortie 1 s'il reste un défaut.
 */
import { chromium } from 'playwright';
import { ROUTES } from '../tests/data/routes.js';

const LARGEUR = Number(process.argv[2] || 1440);
const BASE = process.argv[3] || process.env.TFP_BASE_URL || 'http://localhost:8901';
const TOLERANCE = 3;

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await navigateur.newPage({ viewport: { width: LARGEUR, height: 900 } });
let total = 0;
for (const r of ROUTES) {
	await page.goto(BASE + r.url, { waitUntil: 'domcontentloaded' });
	const defauts = await page.evaluate((tol) => {
		document.querySelectorAll('details').forEach((d) => (d.open = true));
		const logo = document.querySelector('.tfp-header__inner .tfp-logo');
		const bord = Math.round(logo.getBoundingClientRect().left);
		const sortie = [];
		const visible = (el) => { const b = el.getBoundingClientRect(); const s = getComputedStyle(el); return b.width > 0 && b.height > 0 && s.visibility !== 'hidden' && s.display !== 'none'; };
		const nom = (el) => (el.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 48);
		const sections = [...document.querySelectorAll('body > section, main section, .site-main section, body > div > section, .tfp-hero, nav.tfp-breadcrumb, .tfp-sur-page')]
			.filter((s) => !s.closest('header, footer') && !s.parentElement.closest('section'));
		for (const s of sections) {
			const cs = getComputedStyle(s);
			if (cs.textAlign === 'center' || s.matches('.tfp-section--centre, .tfp-cta-block, .tfp-section--primary')) continue;
			// Contenus « porteurs » : texte, titres, grilles, cartes. On ignore les fonds pleine largeur.
			const porteurs = [...s.querySelectorAll('h1, h2, h3, p, ul, ol, table, details, .tfp-card, .tfp-card-tile, figure, picture, .tfp-btn, a.tfp-link-row')].concat(s.matches('ol, ul, nav') ? [...s.querySelectorAll(':scope ol, :scope > ul')] : [])
				.filter((el) => visible(el) && getComputedStyle(el).textAlign !== 'center' && !el.closest('[style*="text-align:center"], .tfp-section--centre'));
			if (!porteurs.length) continue;
			// Bord VISUEL d'un contenu : celui de son cadre le plus extérieur dans la section (carte, encadré,
			// bandeau à fond ou bordure) — le texte d'une carte est en retrait de son rembourrage, c'est normal.
			const bordVisuel = (el) => {
				// Une liste se mesure à son premier élément (son retrait par défaut décale le texte), un
				// paragraphe ou un titre à son premier caractère.
				const premier = el.matches('ul, ol') && el.firstElementChild ? el.firstElementChild : el;
				let g = premier.getBoundingClientRect().left;
				const texte = [...premier.childNodes].find((n) => n.nodeType === 3 && n.textContent.trim());
				if (texte) { const r = document.createRange(); r.selectNodeContents(texte); const b = r.getClientRects()[0]; if (b) g = Math.min(g, b.left); }
				for (let a = el.parentElement; a && a !== s; a = a.parentElement) {
					const c = getComputedStyle(a);
					const cadre = c.backgroundColor !== 'rgba(0, 0, 0, 0)' || parseFloat(c.borderLeftWidth) > 0 || c.backgroundImage !== 'none';
					if (cadre && a.getBoundingClientRect().width < s.getBoundingClientRect().width - 2) g = a.getBoundingClientRect().left;
				}
				return Math.round(g);
			};
			const gauche = Math.min(...porteurs.map(bordVisuel));
			if (Math.abs(gauche - bord) > tol) {
				const el = porteurs.find((x) => bordVisuel(x) === gauche);
				const titre = s.querySelector('h1, h2, h3');
				sortie.push(`bord gauche ${gauche} px au lieu de ${bord} — section « ${nom(titre || el)} »`);
			}
		}
		// Titres voisins.
		const titres = [...document.querySelectorAll('main h2, main h3, body > section h2, body > section h3')]
			.filter((h) => visible(h) && !h.closest('header, footer, summary, .tfp-card-tile, .tfp-card, li, .tfp-submenu'));
		for (let i = 0; i < titres.length; i++) {
			for (let j = i + 1; j < titres.length; j++) {
				const a = titres[i].getBoundingClientRect(), b = titres[j].getBoundingClientRect();
				const cote = a.right <= b.left + 1 || b.right <= a.left + 1;
				const dy = Math.abs(a.top - b.top);
				if (cote && dy > tol && dy < 90 && titres[i].tagName === titres[j].tagName) {
					sortie.push(`titres côte à côte décalés de ${Math.round(dy)} px — « ${nom(titres[i])} » / « ${nom(titres[j])} »`);
				}
			}
		}
		return sortie;
	}, TOLERANCE);
	if (defauts.length) { total += defauts.length; console.log(r.url); [...new Set(defauts)].forEach((d) => console.log('  · ' + d)); }
}
await navigateur.close();
console.log(`\n${ROUTES.length} routes à ${LARGEUR} px · ${total} défaut(s) d'alignement.`);
process.exit(total ? 1 : 0);
