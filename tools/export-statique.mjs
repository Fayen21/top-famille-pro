#!/usr/bin/env node
/**
 * Export statique du site, en deux paquets, avec vérification.
 *
 * L'export précédent s'appuyait sur `wget --page-requisites`, qui ne suit ni les candidats d'un
 * `srcset` ni les `<source>` d'un `<picture>` : 32 fichiers image rapatriés sur 112, d'où
 * 28 AVIF et 28 WebP absents, 488 références mortes et des images cassées sur 31 routes.
 * L'exporteur ne devine donc plus les ressources — il copie le dossier `assets/dist` du thème,
 * qui est la source de vérité, puis il **vérifie** que chaque référence locale se résout.
 *
 * Produit :
 *   export/html-brut/       les 53 pages telles que le serveur les renvoie, hôte réécrit sur le
 *                           domaine de production — pour un audit SEO et structurel ;
 *   export/site-navigable/  le même site avec ses ressources et des liens relatifs — ouvrable
 *                           hors ligne, pour un contrôle visuel.
 *
 * Usage :
 *   node tools/export-statique.mjs
 *   node tools/export-statique.mjs --verifier      → n'exporte pas, contrôle l'export existant
 */
import { chromium } from '@playwright/test';
import { cpSync, existsSync, mkdirSync, readFileSync, readdirSync, rmSync, statSync, writeFileSync } from 'node:fs';
import { dirname, join, relative } from 'node:path';
import { ROUTE_MAP } from './route-map.mjs';
import { exigerParite } from './verifier-parite-installeur.mjs';

/*
 * Contrôle de parité AVANT tout export. Un export part de ce que le dépôt contient : si le paquet
 * d'installation ou les fichiers distribués ne concordent déjà pas avec lui, l'export propage la
 * dérive au lieu de la révéler. Il échoue ici, bruyamment, plutôt que trois écrans plus loin.
 */
{
	const parite = exigerParite();
	console.log(`Parité dépôt ↔ livraison vérifiée : ${parite.compares} fichiers comparés.`);
}

const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
const DOMAINE = 'https://top-famille-pro.fr';
const RACINE = 'export';
const BRUT = join(RACINE, 'html-brut');
const NAV = join(RACINE, 'site-navigable');
const THEME = 'wp-content/themes/topfamillepro';

const verifierSeulement = process.argv.includes('--verifier');

/** Nom de fichier plat pour l'export brut : `/prestations/bureaux/` → `prestations__bureaux.html`. */
const nomPlat = (wp) => (wp === '/' ? 'accueil' : wp.replace(/^\//, '').replace(/\/$/, '').replaceAll('/', '__')) + '.html';

/** Chemin de fichier navigable : `/prestations/bureaux/` → `prestations/bureaux/index.html`. */
const cheminNav = (wp) => (wp === '/' ? 'index.html' : join(wp.replace(/^\//, '').replace(/\/$/, ''), 'index.html'));

/* ------------------------------------------------------------------ */
/* Export                                                              */
/* ------------------------------------------------------------------ */

/*
 * Mode DÉMONSTRATION des formulaires du paquet navigable — passe commerciale du 10 novembre 2026
 * (§9).
 *
 * Le paquet hors ligne réécrivait l'action `…/wp-admin/admin-post.php` en
 * `../wp-admin/admin-post/index.html.php`, un fichier qui n'existe pas : un envoi menait à une page
 * d'erreur. Le gabarit WordPress n'est PAS modifié (son point d'envoi reste celui de production).
 * Ici seulement, chaque formulaire qui visait admin-post :
 *  - vise `demonstration-formulaire.html`, page locale qui existe, en GET (aucun POST possible) ;
 *  - perd `data-tfp-analytics` : aucun événement de conversion n'est poussé ;
 *  - porte `data-tfp-demo` et une mention visible « Mode démonstration » ;
 *  - charge `demonstration-formulaire.js`, qui laisse jouer les étapes et la validation du thème,
 *    puis, si l'envoi est valide, l'intercepte et affiche une confirmation annoncée comme simulée.
 */
function demonstrationFormulaires(html, versRacine) {
	let trouve = false;
	const sortie = html.replace(/<form\b[^>]*action="[^"]*\/wp-admin\/admin-post\.php"[^>]*>/g, (balise) => {
		trouve = true;
		const nouvelle = balise
			.replace(/\saction="[^"]*"/, ` action="${versRacine}/demonstration-formulaire.html"`)
			.replace(/\smethod="[^"]*"/, ' method="get"')
			.replace(/\sdata-tfp-analytics="[^"]*"/, '')
			.replace(/\sdata-tfp-mail-disabled(="[^"]*")?/, '')
			.replace(/>$/, ' data-tfp-demo>');
		return nouvelle + '<p class="tfp-form-notice tfp-form-notice--demo" role="note"><strong>Mode démonstration</strong> : ce formulaire n’envoie rien. Les étapes et les contrôles fonctionnent ; la confirmation affichée sera simulée.</p>';
	});
	if (!trouve) return html;
	return sortie.replace('</body>', `<script src="${versRacine}/demonstration-formulaire.js" defer></script></body>`);
}

const SCRIPT_DEMO = `/* Mode démonstration du paquet navigable : aucun envoi, aucun e-mail, aucun événement de conversion. */
document.addEventListener('submit', function (e) {
	var form = e.target;
	if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-tfp-demo')) return;
	// Envoi déjà refusé par la validation du thème (src/js/quote-form.js) : rien à simuler.
	var refuse = e.defaultPrevented;
	e.preventDefault();
	if (refuse) return;
	// Formulaire sans validation scriptée (contact) : contrôles natifs du navigateur.
	if (!form.checkValidity()) { form.reportValidity(); return; }
	var bouton = form.querySelector('[data-tfp-once]');
	if (bouton) {
		bouton.disabled = false;
		bouton.removeAttribute('aria-busy');
		if (bouton.dataset.libelle) bouton.textContent = bouton.dataset.libelle;
	}
	var ancien = form.querySelector('[data-tfp-demo-confirmation]');
	if (ancien) ancien.remove();
	var message = document.createElement('div');
	message.className = 'tfp-form-notice tfp-form-notice--demo';
	message.setAttribute('role', 'status');
	message.setAttribute('tabindex', '-1');
	message.setAttribute('data-tfp-demo-confirmation', '');
	message.innerHTML = '<strong>Confirmation simulée (démonstration)</strong> — sur le site réel, votre demande serait transmise à Top-Famille Pro. Ici, aucune donnée n’a été envoyée et aucun e-mail n’est parti.';
	form.insertBefore(message, form.firstChild);
	message.focus();
}, false);
`;

const PAGE_DEMO = `<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Démonstration — formulaire</title><style>body{font:16px/1.6 system-ui,sans-serif;max-width:640px;margin:48px auto;padding:0 16px;color:#10233a}</style></head><body><h1>Mode démonstration</h1><p>Cette copie hors ligne du site ne transmet aucun formulaire : aucune donnée n’a été envoyée et aucun e-mail n’est parti. Sur le site réel, la demande serait reçue par Top-Famille Pro.</p><p><a href="index.html">Revenir à l’accueil</a></p></body></html>
`;

async function exporter() {
	rmSync(RACINE, { recursive: true, force: true });
	mkdirSync(BRUT, { recursive: true });
	mkdirSync(NAV, { recursive: true });

	/*
	 * Ressources : on copie l'arborescence du thème telle qu'elle est livrée, plutôt que de
	 * rapatrier les fichiers un par un depuis le rendu. C'est la seule façon d'être exhaustif :
	 * un `srcset` référence jusqu'à cinq largeurs par visuel et par format, et un exporteur qui
	 * suit les références en rate toujours.
	 */
	const dest = join(NAV, THEME);
	mkdirSync(dirname(dest), { recursive: true });
	cpSync(THEME + '/assets', join(dest, 'assets'), { recursive: true });

	writeFileSync(join(NAV, 'demonstration-formulaire.js'), SCRIPT_DEMO);
	writeFileSync(join(NAV, 'demonstration-formulaire.html'), PAGE_DEMO);

	const index = [];
	for (const [hash, m] of Object.entries(ROUTE_MAP)) {
		const reponse = await fetch(WP + m.wp);
		const html = await reponse.text();

		// --- Paquet brut : hôte réel, rien d'autre n'est touché.
		writeFileSync(join(BRUT, nomPlat(m.wp)), html.replaceAll(WP, DOMAINE));

		// --- Paquet navigable : chemins relatifs vers la racine de l'export.
		const cible = join(NAV, cheminNav(m.wp));
		mkdirSync(dirname(cible), { recursive: true });
		const profondeur = relative(dirname(cible), NAV) || '.';
		const versRacine = profondeur === '' ? '.' : profondeur;
		let navHtml = demonstrationFormulaires(html, versRacine)
			// Ressources : `http://hôte/wp-content/…` → `../../wp-content/…`
			.replaceAll(WP + '/wp-content', versRacine + '/wp-content')
			// Liens internes : `http://hôte/prestations/bureaux/` → `../../prestations/bureaux/index.html`
			.replace(new RegExp(WP.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '(/[a-z0-9/-]*)', 'g'), (_, chemin) => {
				const propre = chemin.endsWith('/') ? chemin : chemin + '/';
				return versRacine + (propre === '/' ? '/index.html' : propre + 'index.html');
			})
			.replaceAll(WP, versRacine + '/index.html');
		writeFileSync(cible, navHtml);

		index.push({ route: hash, url: DOMAINE + m.wp, brut: nomPlat(m.wp), navigable: cheminNav(m.wp), statut: reponse.status });
	}

	/*
	 * Flux RSS : le HTML les référence en découverte, l'export doit donc les contenir — sinon la
	 * vérification signale une référence morte, à juste titre.
	 */
	for (const chemin of ['/feed/', '/comments/feed/', ...Object.values(ROUTE_MAP).filter((m) => m.wp.startsWith('/conseils/')).map((m) => m.wp + 'feed/')]) {
		const r = await fetch(WP + chemin);
		if (!r.ok) continue;
		const cible = join(NAV, chemin.replace(/^\//, ''), 'index.html');
		mkdirSync(dirname(cible), { recursive: true });
		writeFileSync(cible, (await r.text()).replaceAll(WP, DOMAINE));
	}

	for (const f of ['robots.txt', 'wp-sitemap.xml', 'wp-sitemap-posts-page-1.xml', 'wp-sitemap-posts-post-1.xml', 'wp-sitemap-posts-prestation-1.xml', 'wp-sitemap-posts-zone-1.xml']) {
		const r = await fetch(WP + '/' + f);
		if (r.ok) writeFileSync(join(BRUT, f), (await r.text()).replaceAll(WP, DOMAINE));
	}

	writeFileSync(join(BRUT, 'INDEX.json'), JSON.stringify(index, null, 2) + '\n');
	console.log(`Export : ${index.length} routes · ${index.filter((x) => x.statut !== 200).length} statut(s) non-200`);
	return index;
}

/* ------------------------------------------------------------------ */
/* Vérification                                                        */
/* ------------------------------------------------------------------ */

/** Toutes les références locales d'un fichier HTML ou CSS. */
function referencesLocales(contenu, type) {
	const refs = new Set();
	const ajouter = (v) => {
		if (!v) return;
		const propre = v.trim().replace(/^["']|["']$/g, '').split('#')[0].split('?')[0];
		if (!propre || /^(https?:|data:|mailto:|tel:|javascript:|\/\/)/i.test(propre)) return;
		refs.add(propre);
	};
	if (type === 'html') {
		for (const m of contenu.matchAll(/\s(?:src|href)="([^"]+)"/g)) ajouter(m[1]);
		// Chaque candidat d'un `srcset` compte : c'est précisément ce que l'ancien export ratait.
		for (const m of contenu.matchAll(/\ssrcset="([^"]+)"/g)) {
			for (const c of m[1].split(',')) ajouter(c.trim().split(/\s+/)[0]);
		}
	} else {
		for (const m of contenu.matchAll(/url\(\s*([^)]+?)\s*\)/g)) ajouter(m[1]);
	}
	return [...refs];
}

async function verifier() {
	const manquantes = new Map();
	const fuites = [];

	const parcourir = (dir) => {
		for (const e of readdirSync(dir, { withFileTypes: true })) {
			const p = join(dir, e.name);
			if (e.isDirectory()) {
				parcourir(p);
				continue;
			}
			if (!/\.(html|css)$/.test(e.name)) continue;
			const contenu = readFileSync(p, 'utf8');
			if (/localhost/i.test(contenu)) fuites.push(p);
			for (const ref of referencesLocales(contenu, e.name.endsWith('.html') ? 'html' : 'css')) {
				const resolu = ref.startsWith('/') ? join(NAV, ref) : join(dirname(p), ref);
				if (!existsSync(resolu) || statSync(resolu).isDirectory()) {
					if (!manquantes.has(ref)) manquantes.set(ref, []);
					manquantes.get(ref).push(relative(NAV, p));
				}
			}
		}
	};
	parcourir(NAV);

	console.log(`\nRessources locales manquantes : ${manquantes.size}`);
	for (const [ref, ou] of [...manquantes].slice(0, 10)) console.log(`  ✕ ${ref} (${ou.length} référence(s))`);
	console.log(`Fichiers contenant « localhost » : ${fuites.length}`);

	// --- Ouverture réelle des 53 routes, aux deux largeurs bornes.
	const navigateur = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
	let cassees = 0;
	let externes = 0;
	let routesOk = 0;

	for (const largeur of [375, 1440]) {
		const page = await navigateur.newPage({ viewport: { width: largeur, height: 900 } });
		page.on('request', (r) => {
			const u = r.url();
			if (/^https?:\/\//i.test(u) && !/^file:/.test(u)) externes++;
		});
		for (const m of Object.values(ROUTE_MAP)) {
			const fichier = 'file://' + join(process.cwd(), NAV, cheminNav(m.wp));
			await page.goto(fichier, { waitUntil: 'load', timeout: 30000 }).catch(() => {});
			await page.evaluate(async () => {
				for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
					window.scrollTo(0, y);
					await new Promise((r) => setTimeout(r, 20));
				}
			});
			const n = await page.evaluate(() => [...document.images].filter((i) => i.naturalWidth === 0 || i.naturalHeight === 0).length);
			cassees += n;
			if (largeur === 1440 && n === 0) routesOk++;
		}
		await page.close();
	}
	await navigateur.close();

	// --- Démonstration du formulaire de devis : étapes, validation, confirmation simulée, aucun POST.
	const demo = await (async () => {
		const page = await navigateur.newPage({ viewport: { width: 375, height: 900 } });
		const posts = [];
		page.on('request', (r) => { if (r.method() === 'POST') posts.push(r.url()); });
		await page.goto('file://' + join(process.cwd(), NAV, cheminNav('/demande-de-devis/')), { waitUntil: 'load' });
		const verdict = { notice: await page.locator('[data-tfp-demo] .tfp-form-notice--demo').count() };
		await page.click('[data-step-next]');
		verdict.validationEtape1 = (await page.locator('[data-form-errors]').innerText()).length > 0;
		await page.selectOption('#tfp-type-locaux', 'bureaux');
		await page.selectOption('#tfp-regime', 'regulier');
		await page.fill('#tfp-nom', 'Démonstration');
		await page.fill('#tfp-telephone', '0600000000');
		await page.click('[data-step-next]');
		verdict.etape2 = await page.locator('[data-step="1"]').isVisible();
		await page.fill('#tfp-message', 'Message de démonstration.');
		await page.check('input[name="consentement"]');
		const url = page.url();
		await page.click('[data-step-submit]');
		await page.waitForTimeout(300);
		verdict.confirmation = await page.locator('[data-tfp-demo-confirmation]').isVisible();
		verdict.memePage = page.url() === url;
		verdict.posts = posts.length;
		verdict.dataLayer = await page.evaluate(() => (window.dataLayer || []).filter((e) => /quote_(submit|complete|lead)/.test(e.event || '')).length);
		await page.close();
		return verdict;
	})();
	const demoOk = demo.notice === 1 && demo.validationEtape1 && demo.etape2 && demo.confirmation && demo.memePage && demo.posts === 0 && demo.dataLayer === 0;
	console.log(`Démonstration du devis : ${demoOk ? 'OK' : 'ÉCHEC'} ${JSON.stringify(demo)}`);
	const restesAdminPost = [];
	const chercher = (dir) => { for (const e of readdirSync(dir, { withFileTypes: true })) { const p = join(dir, e.name); if (e.isDirectory()) chercher(p); else if (e.name.endsWith('.html') && readFileSync(p, 'utf8').includes('admin-post')) restesAdminPost.push(relative(NAV, p)); } };
	chercher(NAV);
	console.log(`Pages navigables visant encore admin-post : ${restesAdminPost.length}`);

	console.log(`Images cassées (53 routes × 2 largeurs) : ${cassees}`);
	console.log(`Requêtes vers un domaine externe : ${externes}`);
	console.log(`Routes ouvrables hors ligne sans image cassée : ${routesOk} / ${Object.keys(ROUTE_MAP).length}`);

	const ok = manquantes.size === 0 && fuites.length === 0 && cassees === 0 && externes === 0 && demoOk && restesAdminPost.length === 0;
	console.log(ok ? '\n✅ Export navigable autonome et complet.' : '\n❌ Export incomplet.');
	return ok;
}

if (!verifierSeulement) await exporter();
const ok = await verifier();
process.exit(ok ? 0 : 1);
