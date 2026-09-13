#!/usr/bin/env node
/**
 * Génère le contenu des 3 articles « Conseils » depuis la maquette Claude Design.
 *
 * Le corps d'un article vit dans `post_content` (type `post` natif, CLAUDE.md §3) : ce générateur
 * reconstruit donc du HTML éditable — titres, paragraphes, listes — plutôt que des champs. La
 * réponse directe, la FAQ, la phrase de maillage et le bloc de conversion restent des champs
 * structurés, parce qu'ils alimentent le JSON-LD ou des composants dédiés.
 *
 * Le sommaire n'est pas stocké : le gabarit le déduit des H2 du corps, donc il ne peut pas se
 * désynchroniser du contenu.
 *
 * Usage : node tools/generate-articles.mjs   → écrit bin/seed-fidelite-articles.php
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const OUT = 'bin/seed-fidelite-articles.php';

const ARTICLES = [
	{ hash: '#/article/frequence-bureaux', slug: 'frequence-bureaux' },
	{ hash: '#/article/cout-nettoyage-bureaux', slug: 'cout-nettoyage-bureaux' },
	{ hash: '#/article/cahier-des-charges-nettoyage', slug: 'cahier-des-charges-nettoyage' },
];

/**
 * Corrections orthographiques imposées par `CLAUDE.md` §9, appliquées à tout texte relevé.
 *
 * Le générateur reproduit le prototype ; la faute est dans le prototype, donc la correction vient
 * ici — la corriger dans le fichier généré serait écrasé à la régénération suivante.
 */
const ORTHOGRAPHE = [ [ 'lister precisément', 'lister précisément' ] ];

/** Nombre de corrections appliquées, pour le compte rendu de fin de génération. */
let fautesCorrigees = 0;

function orthographe(texte) {
	let sortie = String(texte ?? '');
	for (const [ avant, apres ] of ORTHOGRAPHE) {
		while (sortie.includes(avant)) {
			sortie = sortie.replace(avant, apres);
			fautesCorrigees++;
		}
	}
	return sortie;
}

function php(str) {
	return "'" + orthographe(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

/** Échappement HTML pour le corps reconstruit — le contenu vient du DOM, pas d'une saisie. */
function esc(s) {
	return orthographe(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);

const all = [];
for (const art of ARTICLES) {
	await page.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, art.hash);
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
		let root = document.body;
		let count = 0;
		for (const el of document.querySelectorAll('body *')) {
			const n = el.querySelectorAll(':scope > section, :scope > header, :scope > footer, :scope > main, :scope > div').length;
			if (n > count && el.getBoundingClientRect().height > 1000) {
				count = n;
				root = el;
			}
		}
		const sections = [...root.children].filter((c) => c.getBoundingClientRect().height >= 20);
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
					else if (!n.children.length && txt(n)) out.push({ t: 'span', v: txt(n) });
					else walk(n);
				}
			};
			walk(sec);
			return out;
		};
		const secs = sections.map(flatten);
		const iOf = (pred) => secs.findIndex((s) => s.some(pred));

		const hero = secs.find((s) => s.some((n) => n.t === 'h1')) || [];
		const heroSpans = hero.filter((n) => n.t === 'span').map((n) => n.v);
		// Le hero enchaîne : catégorie, auteur, date de publication, date de mise à jour.
		const dates = heroSpans.filter((v) => /\d{4}$/.test(v));

		// Sommaire : la section qui porte le libellé. On ne la conserve pas, le gabarit le refait
		// depuis les H2, mais son index sert à trouver le début du corps.
		const iSommaire = iOf((n) => n.v === 'Sommaire');

		// Corps : les sections entre le sommaire et la FAQ, sauf le bloc « Erreurs à éviter » qui
		// garde son propre rendu (liste barrée).
		const iFaq = iOf((n) => n.t === 'h2' && n.v.startsWith('Questions fréquentes'));
		const iErreurs = iOf((n) => n.t === 'h2' && n.v.startsWith('Erreurs à éviter'));

		const corps = [];
		for (let i = iSommaire + 1; i < iFaq; i++) {
			if (i === iErreurs) continue;
			for (const n of secs[i]) {
				if (n.t === 'h2') corps.push({ t: 'h2', v: n.v });
				else if (n.t === 'p') corps.push({ t: 'p', v: n.v });
				else if (n.t === 'li') corps.push({ t: 'li', v: n.v.replace(/^[▪✕]\s*/, '') });
			}
		}

		const erreurs = (secs[iErreurs] || []).filter((n) => n.t === 'li').map((n) => n.v.replace(/^[▪✕]\s*/, ''));
		const erreursTitre = ((secs[iErreurs] || []).find((n) => n.t === 'h2') || {}).v || '';

		const faqSec = secs[iFaq] || [];
		const faq = [];
		for (let i = 0; i < faqSec.length; i++) {
			if (faqSec[i].t === 'span' && faqSec[i].v.endsWith('?')) {
				const p = faqSec.slice(i + 1).find((n) => n.t === 'p');
				if (p) faq.push({ q: faqSec[i].v, a: p.v });
			}
		}

		// Bloc de maillage : la section entre la FAQ et le bloc de conversion.
		const maillageSec = secs[iFaq + 1] || [];
		const ctaSec = secs[secs.length - 1] || [];

		return {
			categorie: heroSpans[0] || 'Conseils',
			h1: (hero.find((n) => n.t === 'h1') || {}).v || '',
			auteur: heroSpans.find((v) => v === 'Audrey') || 'Audrey',
			datePublication: dates[0] || '',
			dateMaj: dates[1] || '',
			imageAlt: (hero.find((n) => n.t === 'img') || {}).v || '',
			reponse: ((secs[iSommaire - 1] || []).find((n) => n.t === 'p') || {}).v || '',
			corps,
			erreursTitre,
			erreurs,
			faq,
			maillage: (maillageSec.find((n) => n.t === 'p') || {}).v || '',
			ctaTitre: (ctaSec.find((n) => n.t === 'h2') || {}).v || '',
			ctaTexte: (ctaSec.find((n) => n.t === 'p') || {}).v || '',
		};
	});

	// Les dates de la maquette sont en toutes lettres : on les convertit en date ISO, seule forme
	// que WordPress accepte, sans dépendre de la locale du serveur.
	const MOIS = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
	const toIso = (fr) => {
		const m = /^(\d{1,2}) (\S+) (\d{4})$/.exec(fr || '');
		if (!m) return '';
		const mois = MOIS.indexOf(m[2].toLowerCase());
		if (mois < 0) return '';
		return `${m[3]}-${String(mois + 1).padStart(2, '0')}-${m[1].padStart(2, '0')} 09:00:00`;
	};
	all.push({ ...art, ...data, dateIso: toIso(data.datePublication), majIso: toIso(data.dateMaj) });
	console.error(
		`  ${art.slug.padEnd(30)} corps ${data.corps.length} nœuds · erreurs ${data.erreurs.length} · ` +
			`FAQ ${data.faq.length} · ${data.datePublication} → ${data.dateMaj}`
	);
}

/* Fiches de l'index Conseils : accroche de chaque article, relevée sur la route `#/conseils`. */
await page.evaluate(() => {
	location.hash = '/conseils';
});
await page.waitForTimeout(1300);
const index = await page.evaluate(() => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
	const paras = [...document.querySelectorAll('p')].map(txt).filter((t) => t.length > 40);
	const h1 = txt(document.querySelector('h1'));
	const h2s = [...document.querySelectorAll('h2')].map(txt);
	// Les accroches des cartes sont les <span> longs qui ne sont ni un titre ni une date.
	const titres = [...document.querySelectorAll('h1,h2,h3')].map(txt);
	const spans = [...document.querySelectorAll('span')]
		.filter((s) => !s.children.length)
		.map(txt)
		.filter((v) => v.length > 60 && !titres.includes(v));
	return { h1, lede: paras.slice(0, 2), h2s, accroches: [...new Set(spans)] };
});
await browser.close();
console.error(`  index conseils : ${index.accroches.length} accroches, ${index.h2s.length} titres`);

/* ------------------------------------------------------------------ */

const L = [];
L.push('<?php');
L.push('/**');
L.push(" * Contenu intégral des 3 articles « Conseils » et de leur index, relevé dans la maquette.");
L.push(' *');
L.push(' * Fichier **généré** par `node tools/generate-articles.mjs` — ne pas éditer à la main.');
L.push(' *');

/*
 * Le tableau des budgets de l'article sur le coût.
 *
 * La maquette le compose en grille de `span`, que l'aplatissement en titres, paragraphes et
 * listes ne savait pas rendre : il disparaissait, ne laissant que son intertitre et sa phrase
 * d'introduction. On pose à sa place le code court `[tfp_budget_table]`, que le thème rend en
 * `<table>` sémantique **alimenté par la source tarifaire centralisée** — recopier les montants
 * en dur dans le HTML de l'article les aurait figés au prochain changement de tarif.
 */
function poserTableauBudget(html) {
	const apres = '<p>À titre indicatif, calculé à 27 € HT/h + 9 € HT de gestion :</p>';
	if (!html.includes(apres) || html.includes('[tfp_budget_table]')) return html;
	return html.replace(apres, apres + '\n[tfp_budget_table]');
}
L.push(' * Le corps de chaque article est du HTML dans `post_content` : il reste éditable dans');
L.push(" * l'éditeur WordPress, ce qui est l'intérêt du type `post` natif. La réponse directe, la FAQ,");
L.push(' * la phrase de maillage et le bloc de conversion restent des champs structurés.');
L.push(' *');
L.push(' * Usage : wp eval-file bin/seed-fidelite-articles.php');
L.push(' */');
L.push('');
L.push("if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {");
L.push('\tdie( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-articles.php\\n" );');
L.push('}');
L.push('');
L.push('global $wpdb;');
L.push('echo "=== Fidélité Claude Design : 3 articles Conseils ===\\n";');
L.push('');

for (const a of all) {
	// Reconstruction du corps : les <li> consécutifs sont regroupés dans une même liste.
	const html = [];
	let inList = false;
	for (const n of a.corps) {
		if (n.t === 'li') {
			if (!inList) {
				html.push('<ul>');
				inList = true;
			}
			html.push(`<li>${esc(n.v)}</li>`);
		} else {
			if (inList) {
				html.push('</ul>');
				inList = false;
			}
			html.push(n.t === 'h2' ? `<h2>${esc(n.v)}</h2>` : `<p>${esc(n.v)}</p>`);
		}
	}
	if (inList) html.push('</ul>');

	L.push(`/* ---------------- ${a.slug} ---------------- */`);
	L.push(`$posts = get_posts( array( 'post_type' => 'post', 'name' => ${php(a.slug)}, 'numberposts' => 1, 'post_status' => 'any' ) );`);
	L.push('if ( empty( $posts ) ) {');
	L.push(`\techo "  ! article ${a.slug} absent — lancer d'abord les seeds de phase 3\\n";`);
	L.push('} else {');
	L.push('\t$id = $posts[0]->ID;');
	// Dates de la maquette. WordPress recalcule `post_modified` à chaque `wp_update_post` :
	// on la repositionne donc après coup, sinon elle vaudrait la date d'exécution du seed.
	L.push('\twp_update_post( array(');
	L.push('\t\t\'ID\'            => $id,');
	L.push(`\t\t'post_title'    => ${php(a.h1)},`);
	L.push(`\t\t'post_content'  => ${php(poserTableauBudget(html.join('\n')))},`);
	L.push(`\t\t'post_date'     => ${php(a.dateIso)},`);
	L.push(`\t\t'post_date_gmt' => ${php(a.dateIso)},`);
	L.push('\t) );');
	L.push('\t$wpdb->update(');
	L.push('\t\t$wpdb->posts,');
	L.push(`\t\tarray( 'post_modified' => ${php(a.majIso)}, 'post_modified_gmt' => ${php(a.majIso)} ),`);
	L.push("\t\tarray( 'ID' => $id )");
	L.push('\t);');
	L.push('\tclean_post_cache( $id );');
	L.push(`\tupdate_post_meta( $id, '_tfp_direct_answer', ${php(a.reponse)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_categorie_label', ${php(a.categorie)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_image_alt', ${php(a.imageAlt)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_erreurs_titre', ${php(a.erreursTitre)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_erreurs', ${php(a.erreurs.join('\n'))} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_maillage', ${php(a.maillage)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_cta_titre', ${php(a.ctaTitre)} );`);
	L.push(`\tupdate_post_meta( $id, '_tfp_cta_texte', ${php(a.ctaTexte)} );`);
	a.faq.forEach((f, i) => {
		L.push(`\tupdate_post_meta( $id, '_tfp_faq_${i + 1}_q', ${php(f.q)} );`);
		L.push(`\tupdate_post_meta( $id, '_tfp_faq_${i + 1}_a', ${php(f.a)} );`);
	});
	L.push(`\techo "  ✓ ${a.slug}\\n";`);
	L.push('}');
	L.push('');
}

L.push('/* ---------------- index Conseils ---------------- */');
L.push(`update_option( 'tfp_conseils_index', array(`);
L.push(`\t'h1'    => ${php(index.h1)},`);
L.push(`\t'lede'  => ${php(index.lede.join('\n'))},`);
L.push(`\t'h2s'   => ${php(index.h2s.join('\n'))},`);
L.push(`) );`);
L.push('echo "  ✓ index conseils\\n";');
L.push('');
L.push('echo "Terminé.\\n";');

writeFileSync(OUT, L.join('\n') + '\n');
console.error(`\nÉcrit : ${OUT}`);
if (fautesCorrigees !== ORTHOGRAPHE.length) {
	throw new Error(
		`corrections orthographiques : ${ fautesCorrigees } appliquée(s) pour ${ ORTHOGRAPHE.length } règle(s) — ` +
			'une faute a disparu de la maquette ou a changé de forme. Revoir ORTHOGRAPHE (CLAUDE.md §9).'
	);
}
console.error(`Fautes corrigées (CLAUDE.md §9) : ${ fautesCorrigees }`);
