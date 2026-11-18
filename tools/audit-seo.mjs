#!/usr/bin/env node
// Audit SEO / GEO des pages indexables : lit le sitemap du site, ouvre chaque page dans Chromium
// et contrôle balises, titres, données structurées, images et maillage interne.
// Usage : node tools/audit-seo.mjs [base=http://localhost:8901] [--json=fichier]
import { chromium } from 'playwright';
import { writeFileSync } from 'node:fs';

const BASE = (process.argv.find((a) => /^https?:/.test(a)) || 'http://localhost:8901').replace(/\/$/, '');
const JSON_OUT = (process.argv.find((a) => a.startsWith('--json=')) || '').slice(7);

async function texte(url) {
	const r = await fetch(url);
	return { status: r.status, body: await r.text(), headers: r.headers };
}

const index = await texte(`${BASE}/wp-sitemap.xml`);
const sitemaps = [...index.body.matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => m[1]);
const urls = [];
for (const s of sitemaps) {
	const { body } = await texte(s);
	for (const m of body.matchAll(/<loc>([^<]+)<\/loc>/g)) urls.push(m[1]);
}

const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await navigateur.newPage();
const pages = [];
for (const url of urls) {
	const rep = await page.goto(url, { waitUntil: 'domcontentloaded' });
	const d = await page.evaluate(() => {
		const meta = (sel) => document.querySelector(sel)?.getAttribute('content') ?? null;
		const jsonld = [...document.querySelectorAll('script[type="application/ld+json"]')].map((s) => {
			try { return JSON.parse(s.textContent); } catch { return { __invalide: true }; }
		});
		const noeuds = [];
		const parcourir = (n) => {
			if (Array.isArray(n)) return n.forEach(parcourir);
			if (!n || typeof n !== 'object') return;
			if (n['@type']) noeuds.push(n);
			Object.values(n).forEach(parcourir);
		};
		jsonld.forEach(parcourir);
		const titres = [...document.querySelectorAll('main h1, main h2, main h3, main h4, main h5, main h6, h1')]
			.filter((h, i, a) => a.indexOf(h) === i)
			.map((h) => ({ n: +h.tagName[1], t: h.textContent.trim().replace(/\s+/g, ' ') }));
		const imgs = [...document.querySelectorAll('img')].map((i) => ({
			src: i.currentSrc || i.getAttribute('src'),
			alt: i.getAttribute('alt'),
			deco: i.getAttribute('role') === 'presentation' || i.getAttribute('aria-hidden') === 'true' || !!i.closest('[aria-hidden="true"]'),
			w: i.getAttribute('width'), h: i.getAttribute('height'),
		}));
		const liens = [...document.querySelectorAll('a[href]')].map((a) => ({
			href: a.href,
			main: !!a.closest('main'),
			texte: (a.textContent || a.getAttribute('aria-label') || '').trim().replace(/\s+/g, ' '),
		}));
		// FAQ visibles : <details>/<summary> ou listes de questions dans une section FAQ
		const faqVisibles = [...document.querySelectorAll('main details summary, main .tfp-faq-question, main [class*="faq"] summary')]
			.map((s) => s.textContent.trim().replace(/\s+/g, ' '));
		return {
			lang: document.documentElement.lang,
			title: document.title,
			description: meta('meta[name="description"]'),
			robots: meta('meta[name="robots"]'),
			canonical: document.querySelector('link[rel="canonical"]')?.href ?? null,
			og: {
				title: meta('meta[property="og:title"]'), description: meta('meta[property="og:description"]'),
				url: meta('meta[property="og:url"]'), image: meta('meta[property="og:image"]'),
				type: meta('meta[property="og:type"]'), locale: meta('meta[property="og:locale"]'),
				site: meta('meta[property="og:site_name"]'),
			},
			twitter: meta('meta[name="twitter:card"]'),
			fil: !!document.querySelector('nav[aria-label*="riane" i], .tfp-breadcrumb'),
			jsonldInvalide: jsonld.some((j) => j.__invalide),
			types: noeuds.map((n) => n['@type']).flat(),
			faqSchema: noeuds.filter((n) => n['@type'] === 'FAQPage').flatMap((n) => (n.mainEntity || []).map((q) => q.name)),
			faqVisibles,
			titres, imgs, liens,
			mots: (document.querySelector('main')?.innerText || '').split(/\s+/).filter(Boolean).length,
		};
	});
	pages.push({ url, status: rep.status(), ...d });
}
await navigateur.close();

// ---------- analyse ----------
const problemes = [];
const P = (url, type, detail) => problemes.push({ url: url.replace(BASE, '') || '/', type, detail });
const compte = (arr) => arr.reduce((m, v) => m.set(v, (m.get(v) || 0) + 1), new Map());
const titresDup = compte(pages.map((p) => p.title));
const descDup = compte(pages.map((p) => p.description));
const h1Dup = compte(pages.map((p) => p.titres.filter((t) => t.n === 1).map((t) => t.t).join('|')));
const entrants = new Map(urls.map((u) => [u, new Set()]));
const norm = (h) => { try { const u = new URL(h); u.hash = ''; u.search = ''; return u.toString(); } catch { return null; } };

for (const p of pages) {
	if (p.status !== 200) P(p.url, 'statut', p.status);
	if (!/^fr/.test(p.lang)) P(p.url, 'lang', p.lang);
	if (!p.title || p.title.length < 30 || p.title.length > 65) P(p.url, 'title-longueur', `${p.title?.length} c : ${p.title}`);
	if (titresDup.get(p.title) > 1) P(p.url, 'title-doublon', p.title);
	if (!p.description) P(p.url, 'description-absente', '');
	else {
		if (p.description.length < 110 || p.description.length > 165) P(p.url, 'description-longueur', `${p.description.length} c`);
		if (descDup.get(p.description) > 1) P(p.url, 'description-doublon', p.description.slice(0, 60));
	}
	if (p.canonical !== p.url) P(p.url, 'canonical', p.canonical);
	if (!/index/.test(p.robots || 'index') || /noindex/.test(p.robots || '')) P(p.url, 'robots', p.robots);
	for (const k of ['title', 'description', 'url', 'image', 'type', 'locale', 'site']) if (!p.og[k]) P(p.url, 'og-manquant', k);
	if (p.og.url && p.og.url !== p.url) P(p.url, 'og-url', p.og.url);
	if (!p.twitter) P(p.url, 'twitter-card', '');
	if (!p.fil && p.url !== `${BASE}/`) P(p.url, 'fil-ariane-visible', '');
	if (p.jsonldInvalide) P(p.url, 'jsonld-invalide', '');
	const t = new Set(p.types);
	for (const req of ['WebPage', 'WebSite', 'ProfessionalService']) if (![...t].some((x) => x === req || (req === 'WebPage' && /Page$/.test(x)))) P(p.url, 'schema-manquant', req);
	if (p.url !== `${BASE}/` && !t.has('BreadcrumbList')) P(p.url, 'schema-manquant', 'BreadcrumbList');
	if (/\/prestations\/[^/]+\/$/.test(p.url) && !t.has('Service')) P(p.url, 'schema-manquant', 'Service');
	if (/\/conseils\/[^/]+\/$/.test(p.url) && !t.has('Article') && !t.has('BlogPosting')) P(p.url, 'schema-manquant', 'Article');
	if (t.has('Review') || t.has('AggregateRating')) P(p.url, 'schema-interdit', 'Review/AggregateRating');
	// FAQ : balisage seulement si visible, et réciproquement
	if (p.faqSchema.length && !p.faqVisibles.length) P(p.url, 'faq-schema-sans-faq-visible', p.faqSchema.length);
	if (p.faqSchema.length) {
		const vis = new Set(p.faqVisibles);
		const absentes = p.faqSchema.filter((q) => !vis.has(q));
		if (absentes.length) P(p.url, 'faq-schema-question-non-visible', absentes.slice(0, 2).join(' / '));
	}
	if (!p.faqSchema.length && p.faqVisibles.length >= 3) P(p.url, 'faq-visible-sans-schema', p.faqVisibles.length);
	// titres
	const h1 = p.titres.filter((x) => x.n === 1);
	if (h1.length !== 1) P(p.url, 'h1-nombre', h1.length);
	if (h1Dup.get(h1.map((x) => x.t).join('|')) > 1) P(p.url, 'h1-doublon', h1[0]?.t);
	let prec = 1;
	for (const x of p.titres.slice(1)) { if (x.n > prec + 1) { P(p.url, 'titres-saut', `h${prec} → h${x.n} « ${x.t.slice(0, 50)} »`); } prec = x.n; }
	if (!p.titres.some((x) => x.n === 2)) P(p.url, 'h2-absent', '');
	// images
	for (const i of p.imgs) {
		if (i.alt === null) P(p.url, 'img-alt-absent', i.src);
		else if (!i.alt.trim() && !i.deco && +i.w >= 200) P(p.url, 'img-alt-vide-grande-image', i.src); // alt="" = décoratif assumé pour logos, avatars et miniatures
		if (!i.w || !i.h) P(p.url, 'img-dimensions', i.src);
		if (/audrey/i.test(i.alt || '')) P(p.url, 'img-alt-personne', i.alt);
	}
	// liens
	for (const l of p.liens) {
		const n = norm(l.href);
		if (n && n.startsWith(BASE) && entrants.has(n) && n !== p.url && l.main) entrants.get(n).add(p.url);
		if (l.main && /^(cliquez ici|ici|en savoir plus|lire la suite)$/i.test(l.texte)) P(p.url, 'ancre-generique', l.texte);
	}
	const internesMain = new Set(p.liens.filter((l) => l.main && norm(l.href)?.startsWith(BASE)).map((l) => norm(l.href)));
	if (internesMain.size < 3) P(p.url, 'maillage-sortant-faible', internesMain.size);
	if (p.mots < 300) P(p.url, 'contenu-court', `${p.mots} mots`);
}
for (const [u, s] of entrants) if (s.size === 0) P(u, 'orpheline-contenu', 'aucun lien depuis le contenu principal d’une autre page');
for (const [u, s] of entrants) if (s.size > 0 && s.size < 2) P(u, 'maillage-entrant-faible', `${s.size} page`);

// GEO / fichiers racine
const robots = await texte(`${BASE}/robots.txt`);
const llms = await texte(`${BASE}/llms.txt`);
const racine = {
	robots_sitemap: /^Sitemap:/mi.test(robots.body),
	robots_bloque_ia: /User-agent:\s*(GPTBot|ClaudeBot|PerplexityBot|Google-Extended)[\s\S]*?Disallow:\s*\/\s*$/mi.test(robots.body),
	llms_txt: llms.status === 200 && !/<html/i.test(llms.body),
};

const parType = [...compte(problemes.map((p) => p.type))].sort((a, b) => b[1] - a[1]);
console.log(`Pages auditées : ${pages.length} (sitemap)`);
console.log(`Racine : ${JSON.stringify(racine)}`);
console.log(`Problèmes : ${problemes.length}`);
for (const [t, n] of parType) {
	console.log(`  ${String(n).padStart(4)}  ${t}`);
	for (const p of problemes.filter((x) => x.type === t).slice(0, 4)) console.log(`          ${p.url}  ${String(p.detail).slice(0, 110)}`);
}
if (JSON_OUT) writeFileSync(JSON_OUT, JSON.stringify({ racine, problemes, pages: pages.map(({ liens, imgs, ...r }) => r) }, null, 2));
process.exitCode = problemes.length ? 1 : 0;
