#!/usr/bin/env node
/**
 * Génère le contenu des pages statiques narratives depuis la maquette Claude Design.
 *
 * Ces pages n'ont pas de champs ACF (ce sont des pages WordPress classiques, CLAUDE.md §3) : leur
 * contenu est stocké dans une option par page, et rendu par un composant commun
 * (template-parts/static-blocks.php). Cela évite d'écrire à la main 250 paragraphes dans dix
 * gabarits PHP, et garde le contenu modifiable sans toucher au code.
 *
 * Les pages qui portent un vrai composant fonctionnel (formulaire de devis, coordonnées, mentions
 * légales) ne passent pas par ici : leur gabarit reste dédié.
 *
 * Usage : node tools/generate-pages.mjs   → écrit bin/seed-fidelite-pages.php
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const OUT = 'bin/seed-fidelite-pages.php';

/** Route maquette → clé d'option WordPress. */
const PAGES = [
	{ hash: '#/nettoyage-professionnel', key: 'nettoyage-professionnel' },
	{ hash: '#/nos-prestations', key: 'prestations' },
	{ hash: '#/zones-intervention', key: 'zones-intervention' },
	{ hash: '#/bourgogne-franche-comte', key: 'bourgogne-franche-comte' },
	{ hash: '#/pourquoi-top-famille-pro', key: 'pourquoi-nous' },
	{ hash: '#/notre-fonctionnement', key: 'notre-fonctionnement' },
	{ hash: '#/avis-clients', key: 'avis-clients' },
	{ hash: '#/a-propos', key: 'a-propos' },
	{ hash: '#/recrutement', key: 'recrutement' },
];

function php(v, indent = '\t') {
	if (Array.isArray(v)) {
		if (!v.length) return 'array()';
		return (
			'array(\n' + v.map((x) => indent + '\t' + php(x, indent + '\t') + ',').join('\n') + '\n' + indent + ')'
		);
	}
	if (v && typeof v === 'object') {
		const keys = Object.keys(v);
		if (!keys.length) return 'array()';
		return (
			'array(\n' +
			keys.map((k) => indent + '\t' + php(k) + ' => ' + php(v[k], indent + '\t') + ',').join('\n') +
			'\n' +
			indent +
			')'
		);
	}
	if (typeof v === 'number') return String(v);
	return "'" + String(v ?? '').replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);

const all = [];
for (const p of PAGES) {
	await page.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, p.hash);
	await page.waitForTimeout(1300);
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 40));
		}
		window.scrollTo(0, 0);
	});

	const data = await page.evaluate(() => {
		const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
		// Conteneur du flux de page : le plus proche ancêtre du H1 qui porte plusieurs `<section>`
		// directes. Compter les enfants d'un conteneur quelconque ne suffit pas — sur une page
		// courte, la coquille de l'application en a autant que le flux de page, et on mesurerait
		// alors le pré-pied de page et le pied de page à la place du contenu.
		let root = document.body;
		const h1 = document.querySelector('h1');
		for (let el = h1; el; el = el.parentElement) {
			if (el.querySelectorAll(':scope > section').length >= 2) {
				root = el;
				break;
			}
		}
		const sections = [...root.children].filter((c) => c.getBoundingClientRect().height >= 20);

		/** Fond de section, traduit en variante de bande du thème. */
		const fondOf = (el) => {
			const bg = getComputedStyle(el).backgroundColor;
			if (bg === 'rgb(221, 244, 243)') return 'turquoise';
			if (bg === 'rgb(23, 74, 129)') return 'primary';
			if (bg === 'rgb(16, 38, 59)') return 'navy';
			if (bg === 'rgb(255, 255, 255)') return 'blanc';
			if (bg === 'rgb(244, 247, 248)') return 'alt';
			return '';
		};

		const flatten = (sec) => {
			const out = [];
			const walk = (el) => {
				for (const n of el.children) {
					const tag = n.tagName.toLowerCase();
					if (/^h[1-6]$/.test(tag)) out.push({ t: tag, v: txt(n) });
					else if (tag === 'p') out.push({ t: 'p', v: txt(n) });
					else if (tag === 'li') out.push({ t: 'li', v: txt(n) });
					else if (tag === 'img') out.push({ t: 'img', v: n.getAttribute('alt') || '' });
					else if (tag === 'a' && !n.querySelector('h1,h2,h3,h4,p,li,img')) out.push({ t: 'a', v: txt(n), href: n.getAttribute('href') || '' });
					else if (tag === 'blockquote') out.push({ t: 'quote', v: txt(n) });
					else if (!n.children.length && txt(n)) out.push({ t: 'span', v: txt(n) });
					else {
						// Un élément peut porter à la fois du texte direct et des enfants : c'est le cas
						// des intitulés d'accordéon de la maquette, dont la question est un nœud texte
						// et le « + » un enfant. Ne parcourir que les enfants perdrait la question.
						const direct = [...n.childNodes]
							.filter((c) => c.nodeType === 3)
							.map((c) => c.textContent.replace(/\s+/g, ' ').trim())
							.filter(Boolean)
							.join(' ');
						if (direct) out.push({ t: 'span', v: direct });
						walk(n);
					}
				}
			};
			walk(sec);
			return out;
		};

		// Sur les pages courtes, la maquette met le H1 et tout le contenu dans une seule `<section>`.
		// On ne peut donc pas écarter en bloc la section qui porte le H1 : on écarte seulement les
		// nœuds qui précèdent le premier H2, c'est-à-dire le hero.
		const heroSec = sections.find((s) => s.querySelector('h1'));
		const heroSeul = heroSec ? !heroSec.querySelector('h2') : true;

		const heroIndex = sections.indexOf(heroSec);
		const prefooterIndex = sections.findIndex(
			// L'apostrophe de la maquette est typographique : on accepte les deux formes plutôt que
			// de faire dépendre le découpage d'un caractère invisible.
			(sec) => sec !== heroSec && /Un besoin d.entretien pour vos locaux/.test(txt(sec))
		);

		const out = [];
		sections.forEach((sec, i) => {
			let nodes = flatten(sec);
			if (!nodes.length) return;
			// Le fil d'Ariane est rendu par le gabarit, pas par le composant générique.
			if (sec.tagName.toLowerCase() === 'nav') return;
			// Sur les pages courtes, le conteneur retenu est la coquille de l'application : elle
			// contient aussi la barre haute, le pré-pied de page et le pied de page, tous rendus par
			// le thème. Les reprendre ici les dupliquerait sur chaque page.
			if (sec.closest('footer')) return;
			if (i < heroIndex) return;
			if (prefooterIndex >= 0 && i >= prefooterIndex) return;
			if (nodes.some((n) => n.t === 'h1')) {
				if (heroSeul) return;
				const premier = nodes.findIndex((n) => n.t === 'h2');
				nodes = premier < 0 ? [] : nodes.slice(premier);
				if (!nodes.length) return;
			}

			const blocs = [];
			let cur = null;
			const push = () => {
				if (
					cur &&
					(cur.titre || cur.textes.length || cur.liste.length || cur.liens.length || cur.noms.length || cur.citations.length || cur.faq.length)
				) {
					blocs.push(cur);
				}
			};
			const vide = () => ({ titre: '', niveau: 'h2', textes: [], liste: [], liens: [], noms: [], citations: [], faq: [] });
			// Une question de FAQ est un `<span>` terminé par « ? » (la maquette y accole le « + » de
			// l'accordéon) ; sa réponse est le paragraphe qui suit. Sans ce cas particulier, les
			// questions finiraient en pastilles et les réponses en paragraphes détachés.
			let question = null;
			for (let k = 0; k < nodes.length; k++) {
				const n = nodes[k];
				if (n.t === 'h2' || n.t === 'h3') {
					push();
					cur = vide();
					cur.titre = n.v;
					cur.niveau = n.t;
					question = null;
				} else {
					if (!cur) cur = vide();
					const propre = n.v.replace(/\s*\+$/, '').trim();
					// Le repère fiable d'un accordéon est le « + » qui suit son intitulé — la
					// maquette y met aussi bien des questions que des objections entre guillemets,
					// donc terminer par « ? » ne suffit pas.
					const suivant = nodes[k + 1];
					const estQuestion =
						n.t === 'span' &&
						propre.length > 8 &&
						((suivant && suivant.t === 'span' && suivant.v.trim() === '+') || /\?\s*\+?$/.test(n.v));
					if (estQuestion) question = propre;
					else if (n.t === 'p' && question) {
						cur.faq.push({ question, reponse: n.v });
						question = null;
					} else if (n.t === 'p') cur.textes.push(n.v);
					else if (n.t === 'li') cur.liste.push(n.v.replace(/^[▪✕✓]\s*/, ''));
					else if (n.t === 'quote') cur.citations.push(n.v);
					else if (n.t === 'a' && n.href.startsWith('#/')) cur.liens.push({ texte: n.v, route: n.href });
					else if (n.t === 'span' && n.v.length > 1 && !/^[✓✕·+]$/.test(n.v)) cur.noms.push(n.v);
				}
			}
			push();
			if (blocs.length) out.push({ index: i, fond: fondOf(sec), blocs });
		});

		// Accroche du hero : les paragraphes qui précèdent le premier H2 de la section du H1.
		const heroNodes = heroSec ? flatten(heroSec) : [];
		const finHero = heroNodes.findIndex((n) => n.t === 'h2');
		const heroSeulement = finHero < 0 ? heroNodes : heroNodes.slice(0, finHero);
		return {
			h1: txt(heroSec && heroSec.querySelector('h1')),
			lede: heroSeulement.filter((n) => n.t === 'p').map((n) => n.v),
			heroAlt: (heroSeulement.find((n) => n.t === 'img') || {}).v || '',
			heroCtas: heroSeulement.filter((n) => n.t === 'a').map((n) => ({ texte: n.v, route: n.href })),
			sections: out,
		};
	});

	all.push({ ...p, ...data });
	console.error(
		`  ${p.key.padEnd(26)} ${String(data.sections.length).padStart(2)} sections · ` +
			`${data.sections.reduce((n, s) => n + s.blocs.length, 0)} blocs · h1 « ${data.h1.slice(0, 40)} »`
	);
}
await browser.close();

const L = [];
L.push('<?php');
L.push('/**');
L.push(' * Contenu des pages statiques narratives, relevé dans la maquette Claude Design.');
L.push(' *');
L.push(' * Fichier **généré** par `node tools/generate-pages.mjs` — ne pas éditer à la main.');
L.push(' *');
L.push(" * Ces pages sont des pages WordPress classiques (CLAUDE.md §3) : elles n'ont pas de champs");
L.push(' * ACF. Leur contenu est donc stocké en option, une par page, et rendu par le composant');
L.push(' * commun template-parts/static-blocks.php. Les routes internes de la maquette (`#/…`) sont');
L.push(' * conservées telles quelles ici et traduites en URL réelles à l’affichage : rien ne dépend');
L.push(' * du prototype après installation.');
L.push(' *');
L.push(' * Usage : wp eval-file bin/seed-fidelite-pages.php');
L.push(' */');
L.push('');
L.push("if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {");
L.push('\tdie( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-pages.php\\n" );');
L.push('}');
L.push('');
L.push('echo "=== Fidélité Claude Design : pages statiques ===\\n";');
L.push('');
for (const p of all) {
	L.push(`update_option( 'tfp_page_${p.key}', ${php({ h1: p.h1, lede: p.lede, hero_alt: p.heroAlt, sections: p.sections })} );`);
	L.push(`echo "  ✓ ${p.key} (${p.sections.length} sections)\\n";`);
	L.push('');
}
L.push('echo "Terminé.\\n";');

writeFileSync(OUT, L.join('\n') + '\n');
console.error(`\nÉcrit : ${OUT}`);
