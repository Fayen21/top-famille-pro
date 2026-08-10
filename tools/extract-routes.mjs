#!/usr/bin/env node
/**
 * Extraction exhaustive de la maquette Claude Design, route par route.
 *
 * Le fichier de référence est un bundle auto-décompressant en JavaScript, doublé d'une navigation
 * SPA à routes `#/`. Il n'est jamais lu depuis sa source minifiée : il est exécuté dans Chromium,
 * puis chaque route est ouverte et mesurée dans le DOM réellement rendu.
 *
 * La découverte des routes est automatique : on part de `#/`, on relève tous les liens internes
 * rencontrés, et on parcourt en largeur jusqu'à épuisement. Aucune route n'est donc « oubliée »
 * parce qu'elle n'aurait pas été listée à la main.
 *
 * Produit deux fichiers versionnés :
 *   tools/reference-routes.json                 → extraction brute, réutilisable par d'autres outils
 *   docs/MATRICE-ROUTES-CLAUDE-WORDPRESS.md     → matrice lisible route Claude ↔ route WordPress
 *
 * Usage :
 *   node tools/extract-routes.mjs               → extraction complète (desktop 1440 + mobile 375)
 *   node tools/extract-routes.mjs --only=#/ville/dijon
 *   node tools/extract-routes.mjs --discover    → liste seulement les routes trouvées
 */
import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname } from 'node:path';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const JSON_OUT = 'tools/reference-routes.json';
const MD_OUT = 'docs/MATRICE-ROUTES-CLAUDE-WORDPRESS.md';

const FREEZE_CSS = `*,*::before,*::after{animation:none!important;transition:none!important;
scroll-behavior:auto!important}`;

/**
 * Correspondance route maquette → route WordPress. Les URL WordPress sont hiérarchiques
 * (docs/INVENTAIRE-ROUTES.md), la maquette est à plat : la table ci-dessous est la seule
 * traduction, et sert aussi de contrôle d'exhaustivité (toute route découverte sans entrée
 * ici est signalée).
 */
export const ROUTE_MAP = {
	'#/': { wp: '/', type: 'accueil' },
	'#/nettoyage-professionnel': { wp: '/nettoyage-professionnel/', type: 'pilier' },
	'#/nos-prestations': { wp: '/prestations/', type: 'index-prestations' },
	'#/service/bureaux': { wp: '/prestations/bureaux/', type: 'prestation' },
	'#/service/commerces': { wp: '/prestations/commerces/', type: 'prestation' },
	'#/service/cabinets': { wp: '/prestations/cabinets/', type: 'prestation' },
	'#/service/coproprietes': { wp: '/prestations/coproprietes/', type: 'prestation' },
	'#/service/meubles': { wp: '/prestations/meubles/', type: 'prestation' },
	'#/service/ponctuel': { wp: '/prestations/ponctuel/', type: 'prestation' },
	'#/nos-tarifs': { wp: '/tarifs/', type: 'tarifs' },
	'#/zones-intervention': { wp: '/zones-intervention/', type: 'hub-zones' },
	'#/bourgogne-franche-comte': { wp: '/zones-intervention/bourgogne-franche-comte/', type: 'region' },
	'#/departement/cote-dor': { wp: '/zones-intervention/cote-dor/', type: 'departement' },
	'#/departement/doubs': { wp: '/zones-intervention/doubs/', type: 'departement' },
	'#/departement/jura': { wp: '/zones-intervention/jura/', type: 'departement' },
	'#/departement/nievre': { wp: '/zones-intervention/nievre/', type: 'departement' },
	'#/departement/haute-saone': { wp: '/zones-intervention/haute-saone/', type: 'departement' },
	'#/departement/saone-et-loire': { wp: '/zones-intervention/saone-et-loire/', type: 'departement' },
	'#/departement/yonne': { wp: '/zones-intervention/yonne/', type: 'departement' },
	'#/departement/territoire-de-belfort': { wp: '/zones-intervention/territoire-de-belfort/', type: 'departement' },
	'#/ville/dijon': { wp: '/zones-intervention/cote-dor/dijon/', type: 'ville' },
	'#/ville/besancon': { wp: '/zones-intervention/doubs/besancon/', type: 'ville' },
	'#/ville/dole': { wp: '/zones-intervention/jura/dole/', type: 'ville' },
	'#/ville/lons-le-saunier': { wp: '/zones-intervention/jura/lons-le-saunier/', type: 'ville' },
	'#/ville/nevers': { wp: '/zones-intervention/nievre/nevers/', type: 'ville' },
	'#/ville/vesoul': { wp: '/zones-intervention/haute-saone/vesoul/', type: 'ville' },
	'#/ville/chalon-sur-saone': { wp: '/zones-intervention/saone-et-loire/chalon-sur-saone/', type: 'ville' },
	'#/ville/macon': { wp: '/zones-intervention/saone-et-loire/macon/', type: 'ville' },
	'#/ville/auxerre': { wp: '/zones-intervention/yonne/auxerre/', type: 'ville' },
	'#/ville/belfort': { wp: '/zones-intervention/territoire-de-belfort/belfort/', type: 'ville' },
	'#/ville/saint-apollinaire': { wp: '/zones-intervention/cote-dor/saint-apollinaire/', type: 'commune' },
	'#/ville/chenove': { wp: '/zones-intervention/cote-dor/chenove/', type: 'commune' },
	'#/ville/quetigny': { wp: '/zones-intervention/cote-dor/quetigny/', type: 'commune' },
	'#/ville/talant': { wp: '/zones-intervention/cote-dor/talant/', type: 'commune' },
	'#/ville/longvic': { wp: '/zones-intervention/cote-dor/longvic/', type: 'commune' },
	'#/ville/fontaine-les-dijon': { wp: '/zones-intervention/cote-dor/fontaine-les-dijon/', type: 'commune' },
	'#/ville/marsannay-la-cote': { wp: '/zones-intervention/cote-dor/marsannay-la-cote/', type: 'commune' },
	'#/ville/beaune': { wp: '/zones-intervention/cote-dor/beaune/', type: 'commune' },
	'#/conseils': { wp: '/conseils/', type: 'index-conseils' },
	'#/article/frequence-bureaux': { wp: '/conseils/frequence-bureaux/', type: 'article' },
	'#/article/cout-nettoyage-bureaux': { wp: '/conseils/cout-nettoyage-bureaux/', type: 'article' },
	'#/article/cahier-des-charges-nettoyage': { wp: '/conseils/cahier-des-charges-nettoyage/', type: 'article' },
	'#/pourquoi-top-famille-pro': { wp: '/pourquoi-nous/', type: 'institutionnelle' },
	'#/notre-fonctionnement': { wp: '/notre-fonctionnement/', type: 'institutionnelle' },
	'#/avis-clients': { wp: '/avis-clients/', type: 'institutionnelle' },
	'#/a-propos': { wp: '/a-propos/', type: 'institutionnelle' },
	'#/recrutement': { wp: '/recrutement/', type: 'institutionnelle' },
	'#/demande-de-devis': { wp: '/demande-de-devis/', type: 'formulaire' },
	'#/contact': { wp: '/contact/', type: 'contact' },
	'#/plan-du-site': { wp: '/plan-du-site/', type: 'plan-du-site' },
	'#/mentions-legales': { wp: '/mentions-legales/', type: 'legale' },
	'#/politique-de-confidentialite': { wp: '/politique-de-confidentialite/', type: 'legale' },
	'#/gestion-des-cookies': { wp: '/gestion-des-cookies/', type: 'legale' },
};

/** Normalise un href SPA en clé de route (`#/xxx`), ou null si ce n'est pas une route interne. */
function normalizeHash(href) {
	if (!href) return null;
	const i = href.indexOf('#');
	if (i < 0) return null;
	let h = href.slice(i);
	h = h.replace(/[?].*$/, '').replace(/\/+$/, '');
	if (h === '#' || h === '') return null;
	if (!h.startsWith('#/')) return null;
	return h === '#' ? '#/' : h || '#/';
}

async function settle(page) {
	await page.addStyleTag({ content: FREEZE_CSS }).catch(() => {});
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 60));
		}
		window.scrollTo(0, 0);
	});
	await page
		.waitForFunction(() => Array.from(document.images).every((i) => i.complete), null, { timeout: 15000 })
		.catch(() => {});
	await page.evaluate(() => document.fonts && document.fonts.ready).catch(() => {});
	await page.waitForTimeout(250);
}

async function boot(browser, width) {
	const page = await browser.newPage({ viewport: { width, height: 900 } });
	await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await page.waitForTimeout(5500);
	return page;
}

/** Navigue vers une route dans la page déjà bootée (le bundle n'est pas rechargé). */
async function goRoute(page, hash) {
	await page.evaluate((h) => {
		window.scrollTo(0, 0);
		location.hash = h.replace(/^#/, '');
	}, hash);
	await page.waitForTimeout(1100);
	await settle(page);
}

/**
 * Extraction complète d'une route rendue. Tout est relevé depuis le DOM et les styles calculés :
 * titres, paragraphes, listes, boutons, FAQ, liens, ordre et composition des sections, images,
 * couleurs, polices, dimensions et espacements.
 */
async function extract(page) {
	return page.evaluate(() => {
		const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
		const px = (v) => Math.round(parseFloat(v) || 0);

		// Le conteneur de flux principal est celui qui porte le plus d'enfants de premier niveau.
		let root = document.body;
		let count = 0;
		for (const el of document.querySelectorAll('body *')) {
			const n = el.querySelectorAll(
				':scope > section, :scope > header, :scope > footer, :scope > main, :scope > div'
			).length;
			if (n > count && el.getBoundingClientRect().height > 1000) {
				count = n;
				root = el;
			}
		}

		const headings = [...document.querySelectorAll('h1,h2,h3,h4,h5,h6')].map((h) => ({
			level: Number(h.tagName[1]),
			text: txt(h),
		}));

		const paragraphs = [...document.querySelectorAll('p')].map(txt).filter((t) => t.length > 1);

		const lists = [...document.querySelectorAll('ul,ol')].map((l) => ({
			tag: l.tagName.toLowerCase(),
			items: [...l.children].map(txt).filter(Boolean),
		}));

		const buttons = [...document.querySelectorAll('button, a[class*="btn"], a[class*="Btn"], [role="button"]')]
			.map((b) => txt(b))
			.filter(Boolean);

		// FAQ : un bloc dont le conteneur porte « question » / « faq » / « accordion », ou un
		// <summary>/<details>. On relève le couple question → réponse.
		const faq = [];
		for (const d of document.querySelectorAll('details')) {
			const q = d.querySelector('summary');
			faq.push({ q: txt(q), a: txt(d).replace(txt(q), '').trim() });
		}
		if (!faq.length) {
			for (const el of document.querySelectorAll('[class*="faq"],[class*="Faq"],[class*="FAQ"]')) {
				const q = el.querySelector('h3,h4,button,summary,[class*="question"]');
				const a = el.querySelector('p,[class*="answer"],[class*="reponse"]');
				if (q && a && txt(q) && txt(a)) faq.push({ q: txt(q), a: txt(a) });
			}
		}

		const links = [...document.querySelectorAll('a[href]')].map((a) => ({
			href: a.getAttribute('href'),
			text: txt(a).slice(0, 90),
		}));

		const images = [...document.images].map((i) => {
			const r = i.getBoundingClientRect();
			// Rôle déduit de la position dans le document : en-tête, hero, corps, pied de page.
			let role = 'corps';
			if (i.closest('header')) role = 'en-tete';
			else if (i.closest('footer')) role = 'pied-de-page';
			else if (i.getBoundingClientRect().top + window.scrollY < 900) role = 'hero';
			return {
				alt: i.getAttribute('alt') || '',
				role,
				w: Math.round(r.width),
				h: Math.round(r.height),
				natural: i.naturalWidth + 'x' + i.naturalHeight,
				src: (i.currentSrc || i.src || '').slice(0, 60),
				loading: i.getAttribute('loading') || '',
			};
		});

		const sections = [...root.children]
			.filter((c) => c.getBoundingClientRect().height >= 20)
			.map((c, idx) => {
				const r = c.getBoundingClientRect();
				const cs = getComputedStyle(c);
				const h = c.querySelector('h1,h2,h3');
				return {
					index: idx + 1,
					tag: c.tagName.toLowerCase(),
					classes: (c.className || '').toString().split(/\s+/).filter(Boolean).slice(0, 6),
					role: c.getAttribute('role') || '',
					heading: h ? txt(h) : '',
					headingTag: h ? h.tagName.toLowerCase() : '',
					height: Math.round(r.height),
					background: cs.backgroundColor,
					color: cs.color,
					paddingTop: px(cs.paddingTop),
					paddingBottom: px(cs.paddingBottom),
					images: c.querySelectorAll('img').length,
					headings: c.querySelectorAll('h2,h3,h4').length,
					paragraphs: c.querySelectorAll('p').length,
					listItems: c.querySelectorAll('li').length,
					buttons: c.querySelectorAll('button,a[class*="btn"]').length,
					firstText: txt(c).slice(0, 120),
				};
			});

		// Polices et couleurs calculées, relevées sur des éléments représentatifs.
		const sample = (sel) => {
			const el = document.querySelector(sel);
			if (!el) return null;
			const cs = getComputedStyle(el);
			return {
				fontFamily: cs.fontFamily,
				fontSize: cs.fontSize,
				fontWeight: cs.fontWeight,
				lineHeight: cs.lineHeight,
				color: cs.color,
			};
		};

		const palette = {};
		for (const el of document.querySelectorAll('body *')) {
			const cs = getComputedStyle(el);
			for (const key of ['backgroundColor', 'color']) {
				const v = cs[key];
				if (!v || v === 'rgba(0, 0, 0, 0)' || v === 'transparent') continue;
				palette[v] = (palette[v] || 0) + 1;
			}
		}
		const colors = Object.entries(palette)
			.sort((a, b) => b[1] - a[1])
			.slice(0, 14)
			.map(([c, n]) => ({ color: c, count: n }));

		return {
			title: document.title,
			h1: txt(document.querySelector('h1')),
			totalHeight: document.documentElement.scrollHeight,
			overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
			counts: {
				sections: sections.length,
				headings: headings.length,
				paragraphs: paragraphs.length,
				lists: lists.length,
				listItems: document.querySelectorAll('li').length,
				buttons: buttons.length,
				links: links.length,
				images: images.length,
				faq: faq.length,
				words: (document.body.innerText || '').split(/\s+/).filter(Boolean).length,
			},
			typography: {
				body: sample('body'),
				h1: sample('h1'),
				h2: sample('h2'),
				h3: sample('h3'),
				p: sample('p'),
			},
			colors,
			headings,
			paragraphs,
			lists,
			buttons: [...new Set(buttons)],
			faq,
			links,
			images,
			sections,
		};
	});
}

/** Parcours en largeur : découvre toutes les routes atteignables depuis `#/`. */
async function discover(page) {
	const seen = new Set(['#/']);
	const queue = ['#/'];
	const order = [];
	while (queue.length) {
		const hash = queue.shift();
		order.push(hash);
		await goRoute(page, hash);
		const hrefs = await page.evaluate(() =>
			[...document.querySelectorAll('a[href]')].map((a) => a.getAttribute('href'))
		);
		for (const href of hrefs) {
			const h = normalizeHash(href);
			if (h && !seen.has(h)) {
				seen.add(h);
				queue.push(h);
			}
		}
	}
	return order;
}

function write(path, content) {
	mkdirSync(dirname(path), { recursive: true });
	writeFileSync(path, content);
}

function markdown(data, routes, unknown) {
	const L = [];
	L.push('# Matrice des routes — maquette Claude Design ↔ WordPress');
	L.push('');
	L.push('> Fichier **généré** par `node tools/extract-routes.mjs`. Ne pas éditer à la main.');
	L.push('>');
	L.push(
		'> La maquette `reference/Top-Famille-Pro-HANDOFF-READY.html` est un bundle auto-décompressant'
	);
	L.push(
		'> doublé d\'une navigation SPA `#/`. Elle est **exécutée** dans Chromium, jamais lue depuis sa'
	);
	L.push('> source minifiée. Chaque route ci-dessous a été ouverte, rendue, puis mesurée dans le DOM.');
	L.push('');
	L.push(`Routes découvertes automatiquement : **${routes.length}**.`);
	if (unknown.length) {
		L.push('');
		L.push('⚠️ Routes sans correspondance WordPress déclarée : ' + unknown.map((r) => '`' + r + '`').join(', '));
	}
	L.push('');
	L.push('## 1. Table de correspondance');
	L.push('');
	L.push('| # | Route Claude Design | Route WordPress | Type | H1 | Sections | Hauteur 1440 | Hauteur 375 | Mots | Images | FAQ |');
	L.push('|---|---|---|---|---|---|---|---|---|---|---|');
	routes.forEach((hash, i) => {
		const d = data[hash];
		const m = ROUTE_MAP[hash] || {};
		const dk = d.desktop;
		const mb = d.mobile;
		L.push(
			`| ${i + 1} | \`${hash}\` | \`${m.wp || '—'}\` | ${m.type || '—'} | ${(dk.h1 || '—').slice(0, 46)} | ` +
				`${dk.counts.sections} | ${dk.totalHeight} px | ${mb ? mb.totalHeight + ' px' : '—'} | ` +
				`${dk.counts.words} | ${dk.counts.images} | ${dk.counts.faq} |`
		);
	});
	L.push('');
	L.push('## 2. Typographies et couleurs calculées (identiques sur toutes les routes)');
	L.push('');
	const t = data['#/'].desktop.typography;
	L.push('| Élément | Police calculée | Taille | Graisse | Interligne | Couleur |');
	L.push('|---|---|---|---|---|---|');
	for (const [k, v] of Object.entries(t)) {
		if (!v) continue;
		L.push(`| ${k} | ${v.fontFamily} | ${v.fontSize} | ${v.fontWeight} | ${v.lineHeight} | ${v.color} |`);
	}
	L.push('');
	L.push('Couleurs les plus employées sur l\'accueil :');
	L.push('');
	L.push('| Couleur calculée | Occurrences |');
	L.push('|---|---|');
	for (const c of data['#/'].desktop.colors) L.push(`| \`${c.color}\` | ${c.count} |`);
	L.push('');
	L.push('## 3. Détail route par route');
	L.push('');
	for (const hash of routes) {
		const d = data[hash];
		const m = ROUTE_MAP[hash] || {};
		const dk = d.desktop;
		L.push(`### \`${hash}\` → \`${m.wp || '(non mappée)'}\``);
		L.push('');
		L.push(`**Type** : ${m.type || '—'} · **H1** : ${dk.h1 || '—'} · **Hauteur** : ${dk.totalHeight} px (desktop) / ${d.mobile ? d.mobile.totalHeight : '—'} px (mobile) · **Mots** : ${dk.counts.words}`);
		L.push('');
		L.push('**Ordre et composition des sections**');
		L.push('');
		L.push('| # | Balise | Classes | Titre | Hauteur | Fond | Padding H/B | Img | Titres | § | Puces | Boutons |');
		L.push('|---|---|---|---|---|---|---|---|---|---|---|---|');
		for (const s of dk.sections) {
			L.push(
				`| ${s.index} | \`${s.tag}\` | ${s.classes.length ? '`' + s.classes.join(' ') + '`' : '—'} | ` +
					`${(s.heading || s.firstText.slice(0, 40) || '—').replace(/\|/g, '/').slice(0, 52)} | ${s.height} px | ` +
					`\`${s.background}\` | ${s.paddingTop}/${s.paddingBottom} | ${s.images} | ${s.headings} | ` +
					`${s.paragraphs} | ${s.listItems} | ${s.buttons} |`
			);
		}
		L.push('');
		L.push('**Titres**');
		L.push('');
		for (const h of dk.headings) L.push(`- ${'#'.repeat(h.level)} ${h.text}`);
		L.push('');
		if (dk.faq.length) {
			L.push('**FAQ**');
			L.push('');
			for (const f of dk.faq) {
				L.push(`- **${f.q}**`);
				L.push(`  ${f.a}`);
			}
			L.push('');
		}
		if (dk.buttons.length) {
			L.push('**Libellés de boutons** : ' + dk.buttons.map((b) => '`' + b + '`').join(' · '));
			L.push('');
		}
		if (dk.images.length) {
			L.push('**Images**');
			L.push('');
			L.push('| Rôle | alt | Affichée | Native | Chargement |');
			L.push('|---|---|---|---|---|');
			for (const im of dk.images) {
				L.push(`| ${im.role} | ${im.alt || '_(vide)_'} | ${im.w}×${im.h} | ${im.natural} | ${im.loading || '—'} |`);
			}
			L.push('');
		}
		L.push('**Paragraphes**');
		L.push('');
		for (const p of dk.paragraphs) L.push(`> ${p}`);
		L.push('');
		if (dk.lists.length) {
			L.push('**Listes**');
			L.push('');
			dk.lists.forEach((l, i) => {
				L.push(`Liste ${i + 1} (\`${l.tag}\`) :`);
				for (const it of l.items) L.push(`- ${it}`);
				L.push('');
			});
		}
		L.push('---');
		L.push('');
	}
	return L.join('\n') + '\n';
}

async function main() {
	const only = (process.argv.find((a) => a.startsWith('--only=')) || '').split('=')[1];
	const discoverOnly = process.argv.includes('--discover');

	const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
	const desktop = await boot(browser, 1440);

	console.error('Découverte des routes…');
	let routes = await discover(desktop);
	console.error(`${routes.length} routes découvertes.`);
	if (discoverOnly) {
		for (const r of routes) console.log(r + (ROUTE_MAP[r] ? '' : '   ← SANS CORRESPONDANCE WP'));
		await browser.close();
		return;
	}
	if (only) routes = routes.filter((r) => r === only);

	const data = {};
	for (const hash of routes) {
		await goRoute(desktop, hash);
		data[hash] = { desktop: await extract(desktop) };
		console.error(`  1440px ${hash} — ${data[hash].desktop.counts.sections} sections, ${data[hash].desktop.totalHeight} px`);
	}
	await desktop.close();

	const mobile = await boot(browser, 375);
	for (const hash of routes) {
		await goRoute(mobile, hash);
		const m = await extract(mobile);
		// En mobile on ne conserve que ce qui change : dimensions, débordement, comptages.
		data[hash].mobile = {
			totalHeight: m.totalHeight,
			overflow: m.overflow,
			counts: m.counts,
			sections: m.sections.map((s) => ({ index: s.index, heading: s.heading, height: s.height })),
		};
		console.error(`   375px ${hash} — ${m.totalHeight} px, débordement ${m.overflow}`);
	}
	await mobile.close();
	await browser.close();

	const unknown = routes.filter((r) => !ROUTE_MAP[r]);
	write(JSON_OUT, JSON.stringify({ routes, map: ROUTE_MAP, data }, null, '\t') + '\n');
	write(MD_OUT, markdown(data, routes, unknown));
	console.error(`\nÉcrit : ${JSON_OUT} et ${MD_OUT}`);
	if (unknown.length) console.error('Routes sans correspondance WP : ' + unknown.join(', '));
}

main().catch((e) => {
	console.error(e);
	process.exit(1);
});
