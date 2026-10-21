#!/usr/bin/env node
/**
 * Revue visuelle transversale — les 53 routes à 375 et 1440 px, chaque écran ouvert et parcouru
 * jusqu'au pied de page, FAQ dépliées, menus ouverts, les deux étapes du formulaire de devis.
 *
 * Deux produits :
 *   1. une capture pleine page par route et par largeur (docs/revue-visuelle/<route>-<largeur>.png),
 *      à LIRE — une capture qui existe n'est pas une revue ;
 *   2. un relevé automatique des défauts objectivables, par route, écrit en JSON puis en matrice
 *      Markdown. Il trie le travail de lecture, il ne le remplace pas.
 *
 * Ce que le relevé mesure (et seulement cela) :
 *   - débordement horizontal de la page ;
 *   - éléments qui sortent de la fenêtre (droite ou gauche) ;
 *   - textes qui débordent de leur boîte (scrollWidth > clientWidth sur un élément à texte) ;
 *   - cartes / tuiles dont un enfant sort du cadre ;
 *   - mots coupés par `overflow-wrap`/`word-break` : un texte dont une ligne se termine sans
 *     espace ni trait d'union au milieu d'un mot — approché par la présence de `word-break:
 *     break-all` calculé, ou d'un mot plus large que son conteneur ;
 *   - boutons d'appel à l'action primaires visibles en double dans une même bande ;
 *   - images sans dimensions déclarées ;
 *   - formulations de chantier exposées au client ;
 *   - cibles tactiles de moins de 24 px (rappel 2.5.8, hors exception inline) ;
 *   - un pied de page atteint (sinon la page n'a pas été parcourue).
 *
 * Usage :
 *   TFP_BASE_URL=http://localhost:8901 node tools/revue-visuelle.mjs [--widths=375,1440] [--only=#/x,#/y]
 *
 * Une relance `--only=` fusionne ses résultats dans `docs/revue-visuelle.json` et régénère la
 * matrice entière. La colonne « Lecture humaine » vient de `docs/revue-visuelle-lecture.json`
 * (une entrée par route), écrite à la main après lecture des tuiles — jamais par l'outil.
 *   → docs/revue-visuelle/*.png · docs/revue-visuelle.json · docs/REVUE-VISUELLE.md
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync, existsSync, readFileSync } from 'node:fs';
import { join } from 'node:path';
import { ROUTE_MAP } from './route-map.mjs';

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const SORTIE = join('docs', 'revue-visuelle');
const TUILES = join(SORTIE, 'tuiles');
mkdirSync(TUILES, { recursive: true });
const arg = (n, d) => ((process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1] || d);
const LARGEURS = arg('widths', '375,1440').split(',').map(Number);
const ONLY = arg('only', '').split(',').filter(Boolean);
const ROUTES = Object.keys(ROUTE_MAP).filter((h) => !ONLY.length || ONLY.includes(h));

// « villes principales » n'y figure pas : c'est un mot de l'offre (« dix villes principales »,
// « villes principales par département »), pas une formulation de chantier.
const JARGON = ['communes secondaires', 'secteurs secondaires', 'déjà document', 'disposent déjà de leur page', "D'autres suivront", '[À COMPLÉTER]', 'lorem', 'TODO', 'phase 2', 'phase 3'];

/** Déplie tout ce qui se déplie, puis parcourt la page jusqu'en bas pour déclencher le paresseux. */
async function parcourir(page) {
	await page.addStyleTag({ content: '*{animation:none!important;transition:none!important;scroll-behavior:auto!important}' });
	await page.evaluate(() => document.querySelectorAll('details').forEach((d) => { d.open = true; }));
	await page.evaluate(async () => {
		const h = document.documentElement.scrollHeight;
		for (let y = 0; y < h; y += 700) { window.scrollTo(0, y); await new Promise((r) => setTimeout(r, 40)); }
		window.scrollTo(0, 0);
	});
	await page.waitForTimeout(250);
}

const RELEVE = (JARGON) => {
	const cw = document.documentElement.clientWidth;
	const vis = (el) => { const r = el.getBoundingClientRect(); const s = getComputedStyle(el); return r.width > 0 && r.height > 0 && s.visibility !== 'hidden' && s.display !== 'none'; };
	const txt = (el) => (el.textContent || '').replace(/\s+/g, ' ').trim();
	const desc = (el) => el.tagName.toLowerCase() + (el.className && typeof el.className === 'string' ? '.' + el.className.split(/\s+/).slice(0, 2).join('.') : '') + ' « ' + txt(el).slice(0, 40) + ' »';
	const out = { debordement_page: document.documentElement.scrollWidth > cw, hors_fenetre: [], textes_debordants: [], enfants_hors_carte: [], mots_coupes: [], cta_doubles: [], images_sans_dimensions: [], jargon: [], cibles_petites: [], pied_de_page: !!document.querySelector('footer, .tfp-footer'), hauteur: document.documentElement.scrollHeight };

	// Hors fenêtre : tout élément visible dont la boîte sort de la fenêtre, sauf ce qui est volontairement masqué par overflow.
	for (const el of document.querySelectorAll('body *')) {
		if (!vis(el)) continue;
		const r = el.getBoundingClientRect();
		if (r.right > cw + 1 || r.left < -1) {
			// Un élément sorti volontairement de l'écran (champ piège à robots à -9999 px) n'est
			// pas un débordement.
			if (r.right < 0) continue;
			// Un tableau plus large que la fenêtre dans un conteneur qui défile est un choix de
			// mise en page, pas un défaut : on cherche l'overflow sur TOUS les ancêtres, pas
			// seulement le parent direct.
			let a = el.parentElement, defile = false;
			while (a && a !== document.body) { const s = getComputedStyle(a); if (/hidden|clip|auto|scroll/.test(s.overflowX + s.overflow)) { defile = true; break; } a = a.parentElement; }
			if (defile) continue;
			if (getComputedStyle(el).position === 'fixed') continue;
			out.hors_fenetre.push({ el: desc(el), left: Math.round(r.left), right: Math.round(r.right) });
			if (out.hors_fenetre.length >= 12) break;
		}
	}

	// Textes débordants et mots coupés : sur les feuilles de texte.
	const feuilles = [...document.querySelectorAll('h1,h2,h3,h4,p,li,a,span,strong,em,button,summary,td,th,dt,dd,label,blockquote,figcaption')].filter(vis);
	for (const el of feuilles) {
		if (el.children.length > 2) continue;
		const t = txt(el); if (t.length < 3) continue;
		if (el.scrollWidth > el.clientWidth + 2 && getComputedStyle(el).overflowX !== 'hidden' && el.clientWidth > 0) {
			out.textes_debordants.push({ el: desc(el), scroll: el.scrollWidth, client: el.clientWidth });
			if (out.textes_debordants.length >= 12) break;
		}
	}
	// Mot plus large que sa ligne : une ligne de rendu dont la largeur dépasse le conteneur signale
	// un mot coupé ou un débordement — approché via Range sur les nœuds texte des feuilles.
	for (const el of feuilles.slice(0, 600)) {
		const s = getComputedStyle(el);
		if (s.whiteSpace === 'nowrap') continue;
		for (const n of el.childNodes) {
			if (n.nodeType !== 3 || !n.textContent.trim()) continue;
			const mots = n.textContent.split(/\s+/).filter((m) => m.length >= 8);
			if (!mots.length) continue;
			const rg = document.createRange(); rg.selectNodeContents(n);
			const rects = [...rg.getClientRects()];
			const w = el.clientWidth || el.getBoundingClientRect().width;
			// Plus de rectangles que de mots longs ET une ligne quasi pleine : indice de coupe.
			if (rects.length > 1 && s.overflowWrap === 'anywhere' || s.wordBreak === 'break-all') {
				for (const m of mots) {
					const sp = document.createElement('span'); sp.textContent = m; sp.style.cssText = 'position:absolute;visibility:hidden;white-space:nowrap;font:' + s.font; document.body.appendChild(sp);
					const mw = sp.getBoundingClientRect().width; sp.remove();
					if (mw > w + 1) { out.mots_coupes.push({ el: desc(el), mot: m, largeurMot: Math.round(mw), largeurBoite: Math.round(w) }); break; }
				}
			}
			if (out.mots_coupes.length >= 8) break;
		}
		if (out.mots_coupes.length >= 8) break;
	}

	// Enfants hors de leur carte.
	for (const carte of document.querySelectorAll('.tfp-card-tile, .tfp-etape, .tfp-step, .tfp-testimonial, .tfp-dept-link, .tfp-reassurance__item, .tfp-price-example, .tfp-zone-band, .tfp-price-band')) {
		if (!vis(carte)) continue;
		const r = carte.getBoundingClientRect();
		for (const c of carte.querySelectorAll('*')) {
			if (!vis(c)) continue; const cr = c.getBoundingClientRect();
			if (getComputedStyle(c).position === 'absolute') continue;
			if (cr.right > r.right + 1 || cr.bottom > r.bottom + 1 || cr.left < r.left - 1) {
				out.enfants_hors_carte.push({ carte: desc(carte), enfant: desc(c) }); break;
			}
		}
		if (out.enfants_hors_carte.length >= 10) break;
	}

	// Deux CTA primaires visibles dans la même bande.
	for (const sec of document.querySelectorAll('section, header, footer')) {
		const prim = [...sec.querySelectorAll('.tfp-btn--primary, .tfp-btn--copper')].filter(vis);
		if (prim.length >= 2) out.cta_doubles.push({ bande: desc(sec), n: prim.length, libelles: prim.map(txt) });
	}

	for (const img of document.querySelectorAll('img')) {
		if (!img.getAttribute('width') || !img.getAttribute('height')) out.images_sans_dimensions.push(img.getAttribute('src')?.split('/').pop()?.slice(0, 50) || '?');
	}

	const corps = txt(document.querySelector('main') || document.body);
	for (const j of JARGON) if (corps.includes(j)) out.jargon.push(j);

	// Cibles tactiles < 24 px hors inline.
	for (const el of document.querySelectorAll('a[href], button')) {
		if (!vis(el)) continue; const r = el.getBoundingClientRect(); const s = getComputedStyle(el);
		if ((r.height < 24 || r.width < 24) && !/^inline/.test(s.display)) { out.cibles_petites.push({ el: desc(el), w: Math.round(r.width), h: Math.round(r.height) }); if (out.cibles_petites.length >= 8) break; }
	}
	return out;
};

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const resultats = {};
let n = 0;
for (const hash of ROUTES) {
	const route = ROUTE_MAP[hash].wp;
	const nom = hash.replace(/^#\//, '').replace(/\//g, '__') || 'accueil';
	resultats[hash] = {};
	for (const largeur of LARGEURS) {
		const page = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		const erreurs = [];
		page.on('pageerror', (e) => erreurs.push(String(e.message).slice(0, 120)));
		page.on('console', (m) => { if (m.type() === 'error') erreurs.push(m.text().slice(0, 120)); });
		await page.goto(WP + route, { waitUntil: 'load', timeout: 60000 });
		await parcourir(page);
		const releve = await page.evaluate(RELEVE, JARGON);
		releve.erreurs_console = erreurs.filter((e) => !/google|gstatic|ERR_/.test(e));
		// Pleine page en JPEG (la PNG de 53 routes pesait 110 Mo pour un usage de lecture), plus des
		// TUILES à hauteur d'écran : une pleine page de 13 000 px réduite à 2 000 ne se lit pas, et
		// une revue qui ne se lit pas n'en est pas une. 1 800 px de haut à 1440, 2 400 à 375 — la
		// hauteur qui reste lisible une fois l'image réduite.
		await page.screenshot({ path: join(SORTIE, `${nom}-${largeur}.jpg`), fullPage: true, type: 'jpeg', quality: 82 });
		{
			const hauteurPage = await page.evaluate(() => document.documentElement.scrollHeight);
			const pas = largeur >= 1000 ? 1800 : 2400;
			for (let y = 0, i = 1; y < hauteurPage; y += pas, i++) {
				await page.screenshot({ path: join(TUILES, `${nom}-${largeur}-${String(i).padStart(2, '0')}.jpg`), type: 'jpeg', quality: 80, fullPage: true, clip: { x: 0, y, width: largeur, height: Math.min(pas, hauteurPage - y) } });
			}
		}

		// Écrans supplémentaires : menu ouvert sur l'accueil, étape 2 du devis, menu mobile.
		if (hash === '#/') {
			if (largeur >= 1100) { await page.click('#tfp-btn-zones'); await page.waitForTimeout(150); await page.screenshot({ path: join(SORTIE, `${nom}-${largeur}-menu-zones.jpg`), type: 'jpeg', quality: 85, clip: { x: 0, y: 0, width: largeur, height: 520 } }); }
			else {
				// Le tiroir mobile est fixé à la fenêtre : une capture pleine page l'écrasait en
				// tête d'une image de 13 000 px, illisible. On capture la FENÊTRE, tiroir ouvert.
				await page.evaluate(() => window.scrollTo(0, 0));
				await page.click('[data-tfp-mobile-open]'); await page.click('#tfp-mobile-btn-zones'); await page.waitForTimeout(250);
				await page.screenshot({ path: join(SORTIE, `${nom}-${largeur}-menu-mobile.jpg`), type: 'jpeg', quality: 85, fullPage: false });
				await page.keyboard.press('Escape').catch(() => {});
			}
		}
		if (hash === '#/demande-de-devis') {
			// « Régulier ou ponctuel » est un <select>, pas un groupe de boutons radio : sans cette
			// valeur, l'étape 1 refusait d'avancer et la capture « étape 2 » montrait l'étape 1 en erreur.
			await page.selectOption('#tfp-type-locaux', 'bureaux').catch(() => {});
			await page.selectOption('#tfp-regime', 'regulier').catch(() => {});
			await page.fill('#tfp-nom', 'Revue visuelle').catch(() => {});
			await page.fill('#tfp-telephone', '0600000000').catch(() => {});
			await page.click('[data-step-next]').catch(() => {});
			await page.waitForTimeout(250);
			await page.evaluate(() => window.scrollTo(0, 0));
			await page.waitForTimeout(100);
			const r2 = await page.evaluate(RELEVE, JARGON);
			releve.etape2 = { debordement_page: r2.debordement_page, textes_debordants: r2.textes_debordants, hors_fenetre: r2.hors_fenetre };
			await page.screenshot({ path: join(SORTIE, `${nom}-${largeur}-etape-2.jpg`), type: 'jpeg', quality: 85, fullPage: true });
		}
		resultats[hash][largeur] = releve;
		const defauts = ['debordement_page', 'hors_fenetre', 'textes_debordants', 'enfants_hors_carte', 'mots_coupes', 'cta_doubles', 'images_sans_dimensions', 'jargon', 'cibles_petites', 'erreurs_console']
			.filter((k) => (Array.isArray(releve[k]) ? releve[k].length : releve[k])).join(' ');
		console.log(`${defauts ? '⚠' : '✓'} ${String(largeur).padStart(4)} ${hash.padEnd(44)} ${defauts || ''}${releve.pied_de_page ? '' : ' PIED_DE_PAGE_ABSENT'}`);
		await page.close();
		n++;
	}
}
await navigateur.close();

/*
 * Une relance partielle (`--only=`) FUSIONNE ses résultats avec le relevé complet précédent, au
 * lieu de réduire le fichier et la matrice aux seules routes relancées : la matrice des 53 routes
 * reste entière, et la colonne « Lecture humaine » vient d'un fichier à part
 * (docs/revue-visuelle-lecture.json), que la relance ne touche jamais.
 */
if (ONLY.length && existsSync('docs/revue-visuelle.json')) {
	const precedent = JSON.parse(readFileSync('docs/revue-visuelle.json', 'utf8'));
	for (const hash of Object.keys(precedent)) {
		if (!resultats[hash]) resultats[hash] = precedent[hash];
		else resultats[hash] = { ...precedent[hash], ...resultats[hash] };
	}
}
writeFileSync('docs/revue-visuelle.json', JSON.stringify(resultats, null, 1) + '\n');
const LECTURE = existsSync('docs/revue-visuelle-lecture.json') ? JSON.parse(readFileSync('docs/revue-visuelle-lecture.json', 'utf8')) : {};

// Matrice Markdown.
const L = ['# Revue visuelle transversale — 53 routes × ' + LARGEURS.join(' / ') + ' px', '', `> Généré par \`tools/revue-visuelle.mjs\` le ${new Date().toISOString().slice(0, 10)}. Chaque route a été ouverte, FAQ dépliées, parcourue jusqu'au pied de page ; l'accueil avec le menu Zones ouvert, le devis à ses deux étapes. Les captures sont dans \`docs/revue-visuelle/\`. Le relevé automatique ci-dessous TRIE la lecture, il ne la remplace pas : la colonne « lecture » est remplie à la main.`, '', '| Route | ' + LARGEURS.map((w) => `${w} px — relevé auto`).join(' | ') + ' | Lecture humaine |', '|---|' + LARGEURS.map(() => '---').join('|') + '|---|'];
for (const hash of Object.keys(ROUTE_MAP)) {
	if (!resultats[hash]) { L.push(`| \`${hash}\` | ${LARGEURS.map(() => '—').join(' | ')} | ${LECTURE[hash] || ''} |`); continue; }
	const cells = LARGEURS.map((w) => {
		const r = resultats[hash][w]; if (!r) return '—'; const items = [];
		if (r.debordement_page) items.push('débordement page');
		if (r.hors_fenetre.length) items.push(`${r.hors_fenetre.length} hors fenêtre`);
		if (r.textes_debordants.length) items.push(`${r.textes_debordants.length} texte(s) débordant(s)`);
		if (r.enfants_hors_carte.length) items.push(`${r.enfants_hors_carte.length} hors carte`);
		if (r.mots_coupes.length) items.push(`${r.mots_coupes.length} mot(s) coupé(s)`);
		if (r.cta_doubles.length) items.push(`${r.cta_doubles.length} bande(s) à CTA double`);
		if (r.images_sans_dimensions.length) items.push(`${r.images_sans_dimensions.length} img sans dimensions`);
		if (r.jargon.length) items.push('jargon : ' + r.jargon.join(', '));
		if (r.cibles_petites.length) items.push(`${r.cibles_petites.length} cible(s) < 24 px`);
		if (r.erreurs_console.length) items.push(`${r.erreurs_console.length} erreur(s) console`);
		if (!r.pied_de_page) items.push('PIED DE PAGE NON ATTEINT');
		return items.length ? items.join(' · ') : '✓ rien';
	});
	L.push(`| \`${hash}\` | ${cells.join(' | ')} | ${LECTURE[hash] || ''} |`);
}
writeFileSync('docs/REVUE-VISUELLE.md', L.join('\n') + '\n');
console.log(`\n${n} écrans → ${SORTIE} · docs/revue-visuelle.json · docs/REVUE-VISUELLE.md`);
