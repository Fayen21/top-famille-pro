#!/usr/bin/env node
/**
 * Génère le contenu des 6 prestations à partir de la maquette Claude Design.
 *
 * Le contenu n'est pas rédigé ici : il est **relevé** dans le DOM rendu de chaque route
 * `#/service/*`, puis écrit tel quel dans un script de seed WordPress. C'est la seule façon de
 * reproduire fidèlement ~2 000 mots par prestation sans les réécrire — et la seule qui garantisse
 * qu'une reprise ultérieure de la maquette redonne exactement le même résultat.
 *
 * Seules exceptions au copiage littéral (CLAUDE.md, consigne du 10 août 2026) : les montants et
 * les données juridiques réelles. Ici la maquette porte déjà le tarif réel (27 € HT/h, 9 € de
 * gestion) — le gabarit les recalcule depuis includes/site-options.php plutôt que de figer une
 * chaîne, pour qu'un changement de tarif n'ait qu'un seul point d'entrée.
 *
 * Usage : node tools/generate-prestations.mjs   → écrit bin/seed-fidelite-prestations.php
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const OUT = 'bin/seed-fidelite-prestations.php';

/** Route maquette → slug du CPT `prestation` déjà en place dans WordPress. */
const SERVICES = [
	{ hash: '#/service/bureaux', slug: 'bureaux' },
	{ hash: '#/service/commerces', slug: 'commerces' },
	{ hash: '#/service/cabinets', slug: 'cabinets' },
	{ hash: '#/service/coproprietes', slug: 'coproprietes' },
	{ hash: '#/service/meubles', slug: 'meubles' },
	{ hash: '#/service/ponctuel', slug: 'ponctuel' },
];

/** Échappement pour une chaîne PHP entre apostrophes simples. */
function php(str) {
	return "'" + String(str ?? '').replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

function phpList(items) {
	return 'array(\n' + items.map((i) => '\t\t' + php(i) + ',').join('\n') + '\n\t)';
}

/*
 * Résumés courts des six prestations, tels qu'ils apparaissent dans la bande sombre « Nos
 * prestations sur place » des pages de zone : « Open-spaces, salles de réunion, accueil », et non
 * l'accroche complète de la page prestation, qui fait trois lignes. Ils sont relevés une fois sur
 * une page de ville — la maquette les répète à l'identique sur les dix-neuf routes concernées.
 */
async function resumesCourts(page) {
	await page.evaluate(() => {
		location.hash = '/ville/dole';
	});
	await page.waitForTimeout(1400);
	return page.evaluate(() => {
		const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');
		const grille = [...document.querySelectorAll('div')].find(
			(x) => getComputedStyle(x).display === 'grid' && /^Nettoyage de bureaux/.test(txt(x)) && x.children.length === 6
		);
		if (!grille) return [];
		return [...grille.children].map((k) => ({
			titre: txt(k.children[0]),
			resume: txt(k.children[1]),
		}));
	});
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);

const resumes = await resumesCourts(page);
console.error(`  résumés courts relevés : ${resumes.length}`);

const all = [];
for (const svc of SERVICES) {
	await page.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, svc.hash);
	await page.waitForTimeout(1300);
	await page.evaluate(async () => {
		for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 50));
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

		/**
		 * Suite ordonnée des nœuds porteurs de sens d'une section. Le découpage par index de section
		 * seul serait fragile d'une prestation à l'autre : on repère ensuite par le texte des titres.
		 */
		const flatten = (sec) => {
			const out = [];
			const walk = (el) => {
				for (const n of el.children) {
					const tag = n.tagName.toLowerCase();
					if (/^h[1-6]$/.test(tag)) out.push({ t: tag, v: txt(n) });
					else if (tag === 'p') out.push({ t: 'p', v: txt(n) });
					else if (tag === 'li') out.push({ t: 'li', v: txt(n) });
					else if (tag === 'img') out.push({ t: 'img', v: n.getAttribute('alt') || '' });
					else if (tag === 'a' && !n.querySelector('h1,h2,h3,h4,p,li,img')) out.push({ t: 'a', v: txt(n), href: n.getAttribute('href') });
					else if (!n.children.length && txt(n)) out.push({ t: 'span', v: txt(n) });
					else walk(n);
				}
			};
			walk(sec);
			return out;
		};

		const secs = sections.map(flatten);
		const find = (pred) => secs.find((s) => s.some(pred));
		/** Paires titre/texte (h3 suivi de son paragraphe) d'une section repérée par son h2. */
		const pairs = (h2text) => {
			const s = find((n) => n.t === 'h2' && n.v.startsWith(h2text));
			if (!s) return [];
			const out = [];
			for (let i = 0; i < s.length; i++) {
				if (s[i].t === 'h3') {
					const p = s.slice(i + 1).find((n) => n.t === 'p');
					if (p) out.push({ titre: s[i].v, texte: p.v });
				}
			}
			// Une bande mêle couramment une grille et des cartes pleine largeur : sur « Une
			// organisation carrée », « Exemple de cahier des charges » et « Absence et remplacement »
			// sont des cartes blanches de 1180 px, tandis que les quatre autres items sont rangés sur
			// une grille de quatre colonnes sans ornement. Rendre les six pareil se voit.
			const h2 = [...document.querySelectorAll('h2')].find((h) => txt(h).startsWith(h2text));
			const bande = h2 ? h2.closest('section') || h2.parentElement : null;
			if (bande) {
				for (const item of out) {
					const h3 = [...bande.querySelectorAll('h3')].find((h) => txt(h) === item.titre);
					item.carte = false;
					// On remonte de deux niveaux : selon les prestations, la carte est le parent direct
					// du titre ou son grand-parent, la maquette n'étant pas régulière là-dessus.
					for (let el = h3 ? h3.parentElement : null, n = 0; el && el !== bande && n < 2; el = el.parentElement, n++) {
						const cs = getComputedStyle(el);
						if (
							parseFloat(cs.borderTopLeftRadius) >= 8 &&
							(cs.backgroundColor !== 'rgba(0, 0, 0, 0)' || parseFloat(cs.borderTopWidth) > 0)
						) {
							item.carte = true;
							break;
						}
					}
				}
			}
			return out;
		};
		/**
		 * Géométrie réelle de la grille qui suit un intertitre : nombre de colonnes, écart, et
		 * traitement visuel de ses éléments.
		 *
		 * Relevé sur le rendu, pas supposé. Les trois grilles d'une page prestation ne se
		 * ressemblent pas : « le détail » est sur trois colonnes avec un filet supérieur de 2 px et
		 * aucun fond, « l'organisation » sur quatre colonnes sans aucun ornement, « les situations »
		 * sur deux colonnes avec un filet à gauche. Les rendre toutes pareil — en cartes ou en
		 * texte nu — se voit immédiatement.
		 */
		const grilleApres = (h2text) => {
			const h2 = [...document.querySelectorAll('h2')].find((h) => txt(h).startsWith(h2text));
			if (!h2) return null;
			const bande = h2.closest('section') || h2.parentElement;
			const grille = [...bande.querySelectorAll('div,ul,ol')].find(
				(g) => getComputedStyle(g).display === 'grid' && g.children.length >= 2
			);
			if (!grille) return null;
			const gs = getComputedStyle(grille);
			const k = grille.children[0];
			const ks = getComputedStyle(k);
			return {
				colonnes: gs.gridTemplateColumns.split(' ').filter((x) => parseFloat(x) > 1).length || 1,
				gap: gs.gap,
				fond: ks.backgroundColor,
				rayon: ks.borderTopLeftRadius,
				filetHaut: ks.borderTopWidth,
				filetGauche: ks.borderLeftWidth,
				padding: ks.padding,
			};
		};

		const after = (h2text, kind = 'p', n = 1) => {
			const s = find((x) => x.t === 'h2' && x.v.startsWith(h2text));
			if (!s) return [];
			const i = s.findIndex((x) => x.t === 'h2' && x.v.startsWith(h2text));
			const out = [];
			for (let j = i + 1; j < s.length && out.length < n; j++) {
				if (s[j].t === 'h2') break;
				if (s[j].t === kind) out.push(s[j].v);
			}
			return out;
		};

		// Libellés de navigation : la colonne « Prestations » du pied de page emploie des intitulés
		// plus explicites que les H1 (« Cabinets & professions libérales »). Ils sont relevés là,
		// puis répartis par ordre sur les six prestations.
		const navLabels = [...document.querySelectorAll('footer li a')]
			.map((a) => ({ href: a.getAttribute('href') || '', v: txt(a) }))
			.filter((x) => x.href.startsWith('#/service/'))
			.map((x) => x.v);

		// Libellé court de la prestation (« Bureaux », pas « Nettoyage de bureaux ») : la maquette
		// l'emploie dans le fil d'Ariane, le titre de FAQ et les relances. Il est relevé sur le
		// dernier segment du fil d'Ariane plutôt que déduit du titre, qui ne s'y réduit pas.
		const bc = secs[0] || [];
		const labelCourt = [...bc].reverse().find((n) => n.t === 'span' && n.v !== '/');

		// Hero : la section qui contient le h1.
		const hero = secs.find((s) => s.some((n) => n.t === 'h1')) || [];
		const h1 = (hero.find((n) => n.t === 'h1') || {}).v || '';
		const tease = (hero.find((n) => n.t === 'p') || {}).v || '';
		const heroAlt = (hero.find((n) => n.t === 'img') || {}).v || '';
		const microcopy = (hero.find((n) => n.t === 'span' && n.v.includes('€')) ||
			hero.find((n) => n.v.includes('HT/h')) || {}).v || '';

		// Réponse directe : la section qui porte le libellé, puis le paragraphe de maillage qui suit.
		const rdSec = secs.find((s) => s.some((n) => n.v === 'Réponse directe')) || [];
		const rdParas = rdSec.filter((n) => n.t === 'p').map((n) => n.v);

		// « Pour qui ? » et « Les espaces et tâches pris en charge » partagent une section :
		// on coupe la liste des <li> au second h2.
		const pqSec = find((n) => n.t === 'h2' && n.v.startsWith('Pour qui')) || [];
		const cut = pqSec.findIndex((n) => n.t === 'h2' && !n.v.startsWith('Pour qui'));
		const pourQui = pqSec.slice(0, cut < 0 ? undefined : cut).filter((n) => n.t === 'li').map((n) => n.v);
		const taches = (cut < 0 ? [] : pqSec.slice(cut))
			.filter((n) => n.t === 'li')
			.map((n) => n.v.replace(/^▪\s*/, ''));
		const horsPrestation =
			(pqSec.slice(cut < 0 ? 0 : cut).find((n) => n.t === 'span' && n.v.startsWith('Hors prestation')) || {}).v || '';

		// Bloc d'exclusions explicites : présent uniquement sur les prestations où l'ambiguïté est
		// coûteuse (cabinets et professions libérales — bio-nettoyage, DASRI, stérilisation). Absent
		// des autres routes, il est simplement vide et la section reste masquée.
		const excSec = find((n) => n.t === 'h2' && n.v.startsWith('Ce que Top-Famille Pro ne réalise pas')) || [];
		const exclusionsTitre = (excSec.find((n) => n.t === 'h2') || {}).v || '';
		const exclusionsIntro = (excSec.find((n) => n.t === 'p') || {}).v || '';
		const exclusionsItems = excSec.filter((n) => n.t === 'li').map((n) => n.v.replace(/^✕\s*/, ''));

		// Situations concrètes : deux constats, puis un exemple de planning mis en avant.
		const sitSec = find((n) => n.t === 'h2' && n.v.startsWith('Les situations concrètes')) || [];
		const sitParas = sitSec.filter((n) => n.t === 'p').map((n) => n.v);
		const sitTitre = (sitSec.find((n) => n.t === 'h2') || {}).v || '';
		const exempleLabel = (sitSec.find((n) => n.t === 'span' && !n.v.includes('.')) || {}).v || 'Exemple de planning';

		// Témoignage de la maquette, reproduit à l'identique (consigne du 10 août 2026) : il est
		// stocké en champs dédiés pour être remplaçable sans toucher au gabarit.
		// Le hero porte lui aussi cinq étoiles (badge « 5,0/5 sur Google ») : on exige donc en plus
		// un texte long, seul le bloc témoignage en contient un.
		const tSec =
			secs.find(
				(s) =>
					s.some((n) => n.t === 'span' && n.v.startsWith('★★★★★')) &&
					s.some((n) => n.t === 'span' && n.v.length > 60)
			) || [];
		const tSpans = tSec.filter((n) => n.t === 'span').map((n) => n.v);
		const tTexte = tSpans.find((v) => v.length > 60) || '';
		const ti = tSpans.indexOf(tTexte);
		const temoignage = tTexte
			? { texte: tTexte, auteur: tSpans[ti + 1] || '', role: tSpans[ti + 2] || '', ville: tSpans[ti + 3] || '' }
			: null;

		// FAQ : question portée par un <span>, réponse par le <p> qui suit.
		const faqSec = find((n) => n.t === 'h2' && n.v.startsWith('Questions fréquentes')) || [];
		const faq = [];
		for (let i = 0; i < faqSec.length; i++) {
			if (faqSec[i].t === 'span' && faqSec[i].v.endsWith('?')) {
				const p = faqSec.slice(i + 1).find((n) => n.t === 'p');
				if (p) faq.push({ q: faqSec[i].v, a: p.v });
			}
		}
		const faqTitre = (faqSec.find((n) => n.t === 'h2') || {}).v || '';

		// Bloc final de conversion.
		const ctaSec = secs[secs.length - 1] || [];
		const ctaTitre = (ctaSec.find((n) => n.t === 'h2') || {}).v || '';
		const ctaTexte = (ctaSec.find((n) => n.t === 'p') || {}).v || '';

		const villesSec = find((n) => n.t === 'h2' && n.v.startsWith('Cette prestation près')) || [];
		const villes = villesSec.filter((n) => n.t === 'a' && n.href && n.href.includes('/ville/')).map((n) => n.v);

		return {
			labelCourt: labelCourt ? labelCourt.v : '',
			navLabels,
			h1,
			tease,
			heroAlt,
			microcopy,
			reponse: rdParas[0] || '',
			maillage: rdParas[1] || '',
			exclusionsTitre,
			exclusionsIntro,
			exclusionsItems,
			pourQuiTitre: (pqSec.find((n) => n.t === 'h2') || {}).v || 'Pour qui ?',
			pourQui,
			tachesTitre: (pqSec.filter((n) => n.t === 'h2')[1] || {}).v || '',
			taches,
			horsPrestation,
			sitTitre,
			sitParas,
			exempleLabel,
			configsTitre: (find((n) => n.t === 'h2' && n.v.startsWith('Trois configurations')) || []).length
				? 'Trois configurations, trois organisations'
				: '',
			configsIntro: after('Trois configurations', 'p', 1)[0] || '',
			configs: pairs('Trois configurations'),
			detailTitre: ((find((n) => n.t === 'h2' && n.v.startsWith('Le détail')) || []).find((n) => n.t === 'h2') || {}).v || '',
			// Note qui clôt la colonne des tâches : la maquette la rend en carte encadrée. C'est un
			// `span`, pas un paragraphe, et elle était donc perdue à l'extraction sur cinq des six
			// prestations.
			noteTaches:
				(() => {
					const h2 = [...document.querySelectorAll('h2')].find((h) => /espaces et tâches|tâches pris en charge/i.test(txt(h)));
					if (!h2) return '';
					const bande = h2.closest('section') || h2.parentElement;
					const cand = [...bande.querySelectorAll('span,div')]
						.filter((e) => !e.children.length && txt(e).length > 80)
						.pop();
					return cand ? txt(cand) : '';
				})(),
			details: pairs('Le détail'),
			// Géométrie relevée des trois grilles. Identique sur les six prestations (vérifié à chaque
			// régénération), donc encodée en CSS plutôt que stockée par prestation : la dupliquer six
			// fois en base inviterait à ce qu'une seule dérive un jour sans qu'on le voie.
			detailsGrille: grilleApres('Le détail'),
			orgTitre: ((find((n) => n.t === 'h2' && n.v.startsWith('Une organisation')) || []).find((n) => n.t === 'h2') || {}).v || '',
			organisation: pairs('Une organisation'),
			organisationGrille: grilleApres('Une organisation'),
			situationsGrille: grilleApres('Les situations'),
			semaineTitre: 'Une semaine type',
			semaine: after('Une semaine type', 'p', 1)[0] || '',
			limitesTitre: 'Les limites de la prestation',
			limites: after('Les limites', 'p', 1)[0] || '',
			villes,
			temoignage,
			faqTitre,
			faq,
			ctaTitre,
			ctaTexte,
		};
	});

	// Les libellés du pied de page sont dans l'ordre des six prestations : on prend celui du rang
	// courant plutôt que de rechercher par titre, que la maquette n'emploie pas là.
	const rang = SERVICES.findIndex((x) => x.slug === svc.slug);
	const navLabel = data.navLabels[rang] || '';
	const resumeCourt = (resumes[rang] || {}).resume || '';
	all.push({ ...svc, ...data, navLabel, resumeCourt });
	console.error(
		`  ${svc.slug.padEnd(14)} pour-qui ${data.pourQui.length} · tâches ${data.taches.length} · ` +
			`configs ${data.configs.length} · détails ${data.details.length} · organisation ${data.organisation.length} · ` +
			`FAQ ${data.faq.length} · témoignage ${data.temoignage ? 'oui' : 'non'}`
	);
}
await browser.close();

/* ------------------------------------------------------------------ */
/* Écriture du script de seed                                          */
/* ------------------------------------------------------------------ */

const L = [];
L.push('<?php');
L.push('/**');
L.push(' * Contenu intégral des 6 prestations, relevé dans la maquette Claude Design.');
L.push(' *');
L.push(' * Fichier **généré** par `node tools/generate-prestations.mjs` — ne pas éditer à la main :');
L.push(' * toute correction se fait dans le générateur, sinon la prochaine régénération l\'écrase.');
L.push(' *');
L.push(' * Le contenu est reproduit tel quel (consigne du 10 août 2026 : reproduire la maquette à');
L.push(' * 100 %, ne pas la réécrire ni la raccourcir). Les montants ne sont pas figés ici : le');
L.push(' * gabarit les recalcule depuis includes/site-options.php, seul point d\'entrée du tarif.');
L.push(' *');
L.push(' * Usage : wp eval-file bin/seed-fidelite-prestations.php');
L.push(' * Idempotent : upsert par slug, une deuxième exécution ne crée aucun doublon.');
L.push(' */');
L.push('');
L.push("if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {");
L.push('\tdie( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-prestations.php\\n" );');
L.push('}');
L.push('');
L.push("if ( ! function_exists( 'tfp_seed_set_field' ) ) {");
L.push('\tfunction tfp_seed_set_field( $selector, $value, $post_id ) {');
L.push("\t\tif ( function_exists( 'update_field' ) ) {");
L.push('\t\t\tupdate_field( $selector, $value, $post_id );');
L.push('\t\t} else {');
L.push('\t\t\tupdate_post_meta( $post_id, $selector, $value );');
L.push('\t\t}');
L.push('\t}');
L.push('}');
L.push('');
L.push("echo \"=== Fidélité Claude Design : contenu intégral des 6 prestations ===\\n\";");
L.push('');

for (const s of all) {
	L.push(`/* ---------------- ${s.slug} ---------------- */`);
	L.push(`$posts = get_posts( array( 'post_type' => 'prestation', 'name' => ${php(s.slug)}, 'numberposts' => 1, 'post_status' => 'any' ) );`);
	L.push('if ( empty( $posts ) ) {');
	L.push(`\techo "  ! prestation ${s.slug} absente — lancer d'abord les seeds de phase 2/3\\n";`);
	L.push('} else {');
	L.push('\t$id = $posts[0]->ID;');
	// L'ordre des six prestations est celui de la maquette (bureaux, commerces, cabinets,
	// copropriétés, meublés, ponctuel) — pas l'ordre alphabétique des titres. Sans `menu_order`,
	// le pied de page et les index les listaient dans un ordre différent de la maquette.
	L.push(`\twp_update_post( array( 'ID' => $id, 'menu_order' => ${SERVICES.findIndex((x) => x.slug === s.slug) + 1} ) );`);
	const set = (k, v) => L.push(`\ttfp_seed_set_field( ${php(k)}, ${v}, $id );`);
	set('nav_label', php(s.navLabel));
	set('label_court', php(s.labelCourt));
	// Résumé d'une ligne, employé par la bande sombre des pages de zone.
	set('resume_court', php(s.resumeCourt));
	set('h1', php(s.h1));
	set('tease', php(s.tease));
	set('hero_alt', php(s.heroAlt));
	set('reponse_directe', php(s.reponse));
	set('maillage_texte', php(s.maillage));
	set('pour_qui_titre', php(s.pourQuiTitre));
	set('pour_qui_items', `implode( "\\n", ${phpList(s.pourQui)} )`);
	set('taches_titre', php(s.tachesTitre));
	set('taches', `implode( "\\n", ${phpList(s.taches)} )`);
	set('hors_prestation', php(s.horsPrestation));
	set('exclusions_titre', php(s.exclusionsTitre));
	set('exclusions_intro', php(s.exclusionsIntro));
	set('exclusions_items', `implode( "\\n", ${phpList(s.exclusionsItems)} )`);
	set('situations_titre', php(s.sitTitre));
	set('situations_items', `implode( "\\n", ${phpList(s.sitParas.slice(0, -1))} )`);
	set('situations_exemple_label', php(s.exempleLabel));
	set('situations_exemple', php(s.sitParas[s.sitParas.length - 1] || ''));
	set('configs_titre', php(s.configsTitre));
	set('configs_intro', php(s.configsIntro));
	s.configs.forEach((c, i) => {
		set(`config_${i + 1}_titre`, php(c.titre));
		set(`config_${i + 1}_texte`, php(c.texte));
	});
	set('detail_titre', php(s.detailTitre));
	s.details.forEach((c, i) => {
		set(`detail_${i + 1}_titre`, php(c.titre));
		set(`detail_${i + 1}_texte`, php(c.texte));
	});
	set('organisation_titre', php(s.orgTitre));
	s.organisation.forEach((c, i) => {
		set(`organisation_${i + 1}_titre`, php(c.titre));
		set(`organisation_${i + 1}_texte`, php(c.texte));
		// `carte` dit si la maquette rend cet item en carte pleine largeur ou dans la grille.
		set(`organisation_${i + 1}_carte`, c.carte ? "'1'" : "''");
	});
	set('note_taches', php(s.noteTaches));
	set('semaine_titre', php(s.semaineTitre));
	set('semaine_type', php(s.semaine));
	set('limites_titre', php(s.limitesTitre));
	set('limites', php(s.limites));
	if (s.temoignage) {
		set('temoignage_texte', php(s.temoignage.texte));
		set('temoignage_auteur', php(s.temoignage.auteur));
		set('temoignage_role', php(s.temoignage.role));
		set('temoignage_ville', php(s.temoignage.ville));
	}
	set('faq_titre', php(s.faqTitre));
	s.faq.forEach((f, i) => {
		L.push(`\ttfp_seed_set_field( 'faq_${i + 1}', array( 'question' => ${php(f.q)}, 'reponse' => ${php(f.a)} ), $id );`);
	});
	set('cta_titre', php(s.ctaTitre));
	set('cta_texte', php(s.ctaTexte));
	L.push(`\techo "  ✓ ${s.slug}\\n";`);
	L.push('}');
	L.push('');
}
L.push("echo \"Terminé.\\n\";");

writeFileSync(OUT, L.join('\n') + '\n');
console.error(`\nÉcrit : ${OUT}`);
