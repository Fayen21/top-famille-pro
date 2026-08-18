#!/usr/bin/env node
/**
 * Génère le contenu des 26 zones (8 départements, 10 villes, 8 communes) depuis la maquette.
 *
 * Même principe que tools/generate-prestations.mjs : le contenu est **relevé** dans le DOM rendu
 * des routes `#/departement/*` et `#/ville/*`, jamais réécrit. C'est ce qui permet de reproduire
 * ~1 300 à 1 900 mots par zone, tous différents, sans en inventer une ligne.
 *
 * Les sections ne sont pas repérées par leur position — elle varie d'un niveau à l'autre — mais
 * par des ancres stables : le bloc « Réponse directe », les liens vers `#/service/`, un titre
 * commençant par « Tarif », un titre « Questions fréquentes ». Les deux grands blocs narratifs
 * (récit et méthode) sont découpés en groupes h2 + paragraphes, numérotés dans l'ordre : c'est ce
 * qui permet à un seul gabarit de servir les trois niveaux sans branche par niveau.
 *
 * Usage : node tools/generate-zones.mjs   → écrit bin/seed-fidelite-zones.php
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';

/*
 * CORRECTIONS ÉDITORIALES appliquées au contenu relevé — table explicite, et seul endroit où le
 * texte de la maquette est modifié.
 *
 * Le générateur reproduit le prototype ; il ne le corrige pas de sa propre initiative. Quand une
 * correction est décidée par Emmanuel, elle vient ici plutôt que dans le fichier généré, sinon la
 * régénération suivante l'écrase — c'est ce que dit l'en-tête de `bin/seed-fidelite-zones.php`.
 *
 * Chaque entrée est appliquée par REMPLACEMENT EXACT d'un fragment. Si le fragment n'est plus
 * trouvé — parce que la maquette a changé — la génération échoue bruyamment au lieu de produire
 * silencieusement un texte non corrigé.
 */
const CORRECTIONS_EDITORIALES = [
	{
		zone: 'quetigny',
		champ: 'reponse',
		// Décision d'Emmanuel du 17 août 2026 : les 8 communes secondaires sont desservies, et leur
		// texte passe à l'affirmatif. Sept des huit affirment déjà l'intervention dans leur réponse
		// directe ; celle de Quetigny décrit la commune et le tarif sans jamais dire que nous y
		// intervenons. C'est précisément l'endroit où le visiteur cherche la réponse.
		avant: "Quetigny est une commune de Côte-d'Or située à l'est de Dijon, limitrophe de Saint-Apollinaire où Top-Famille Pro est implantée.",
		apres:
			"Top-Famille Pro entretient vos locaux à Quetigny, commune de Côte-d'Or située à l'est de Dijon, " +
			"limitrophe de Saint-Apollinaire où l'entreprise est implantée.",
	},
];

/**
 * Corrections grammaticales imposées par `CLAUDE.md` §9, appliquées à TOUT texte relevé.
 *
 * La maquette écrit « sont possible lorsque prévu … et chiffré dans le devis » : trois accords
 * fautifs dans la même incise, répétés sur les 26 zones parce que le prototype la recopie d'une
 * page à l'autre. `CLAUDE.md` §9 nomme explicitement « sont possible » et « lorsque prévu » avec
 * sujet pluriel parmi les corrections à faire.
 *
 * L'accord dépend du sujet, qui change d'une occurrence à l'autre — « la sortie des bacs »
 * (féminin singulier), « la sortie et la rentrée » (féminin pluriel), « le changement de linge, la
 * vérification … et le signalement » (masculin pluriel). Une règle unique produirait donc une
 * faute là où elle en corrige une autre : chaque sujet a la sienne, la plus longue d'abord.
 *
 * Le contrôle final est le garde-fou : si un « lorsque prévu » survit à toutes les règles, c'est
 * qu'un sujet non prévu est apparu dans la maquette, et la génération échoue plutôt que de
 * publier la faute.
 */
const QUEUE = 'lorsque prévu dans le cahier des charges et chiffré dans le devis';
const GRAMMAIRE = [
	// Féminin pluriel : « la sortie et la rentrée des bacs ».
	[
		`La sortie et la rentrée des bacs sont possible ${ QUEUE }`,
		"La sortie et la rentrée des bacs sont possibles lorsqu'elles sont prévues au cahier des charges et chiffrées au devis",
	],
	[
		`sortie et rentrée des bacs possible ${ QUEUE }`,
		"sortie et rentrée des bacs possibles lorsqu'elles sont prévues au cahier des charges et chiffrées au devis",
	],
	// Féminin singulier : « la sortie des bacs », « la gestion des bacs ».
	[
		`sortie des bacs possible ${ QUEUE }`,
		"sortie des bacs possible lorsqu'elle est prévue au cahier des charges et chiffrée au devis",
	],
	[
		`la gestion des bacs étant possible ${ QUEUE }`,
		"la gestion des bacs étant possible lorsqu'elle est prévue au cahier des charges et chiffrée au devis",
	],
	// Masculin pluriel : énumération « le changement de linge, la vérification …, le signalement ».
	[
		`des dégradations sont possible ${ QUEUE }`,
		"des dégradations sont possibles lorsqu'ils sont prévus au cahier des charges et chiffrés au devis",
	],
	[
		`des dégradations étant possible ${ QUEUE }`,
		"des dégradations étant possibles lorsqu'ils sont prévus au cahier des charges et chiffrés au devis",
	],
	[
		`chacun possible ${ QUEUE }`,
		"chacun possible lorsqu'il est prévu au cahier des charges et chiffré au devis",
	],
	// Tournure impersonnelle : le sujet est le fait lui-même.
	[
		`C'est possible ${ QUEUE }`,
		"C'est possible lorsque c'est prévu au cahier des charges et chiffré au devis",
	],
];

/** Nombre de corrections grammaticales appliquées, pour le compte rendu de fin de génération. */
let accordsCorriges = 0;

/** Applique les règles d'accord ; échoue si une tournure fautive non couverte subsiste. */
function grammaire(texte) {
	let sortie = String(texte ?? '');
	for (const [avant, apres] of GRAMMAIRE) {
		while (sortie.includes(avant)) {
			sortie = sortie.replace(avant, apres);
			accordsCorriges++;
		}
	}
	if (sortie.includes('lorsque prévu') || /\bsont possible\b(?!s)/.test(sortie)) {
		throw new Error(
			'accord fautif non couvert par GRAMMAIRE — la maquette a introduit un sujet nouveau : ' +
				`« …${ sortie.slice(Math.max(0, sortie.indexOf('lorsque prévu') - 90), sortie.indexOf('lorsque prévu') + 20) }… ». ` +
				'Ajouter sa règle plutôt que publier la faute (CLAUDE.md §9).'
		);
	}
	return sortie;
}

/** Applique les corrections éditoriales d'une zone, en échouant si un fragment a disparu. */
function corriger(slugZone, champ, texte) {
	let sortie = texte;
	for (const c of CORRECTIONS_EDITORIALES) {
		if (c.zone !== slugZone || c.champ !== champ) continue;
		if (!sortie.includes(c.avant)) {
			throw new Error(
				`correction éditoriale caduque — zone « ${slugZone} », champ « ${champ} » : le fragment ` +
					`« ${c.avant.slice(0, 60)}… » n'existe plus dans la maquette. Revoir CORRECTIONS_EDITORIALES ` +
					'plutôt que de laisser passer un texte non corrigé.'
			);
		}
		sortie = sortie.replace(c.avant, c.apres);
	}
	return sortie;
}

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const OUT = 'bin/seed-fidelite-zones.php';

/** Slug WordPress du CPT `zone` : dernier segment de la route de la maquette. */
const ZONES = Object.entries(ROUTE_MAP)
	.filter(([, m]) => ['departement', 'ville', 'commune'].includes(m.type))
	.map(([hash, m]) => ({ hash, slug: hash.split('/').pop(), niveau: m.type }));

function php(str) {
	return "'" + grammaire(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

function phpLines(items) {
	if (!items || !items.length) return "''";
	return 'implode( "\\n", array(\n' + items.map((i) => '\t\t' + php(i) + ',').join('\n') + '\n\t) )';
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);

const all = [];
for (const zone of ZONES) {
	await page.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, zone.hash);
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
					else {
						/*
						 * Cas « icône + libellé » : `<span><span>✓</span>Devis gratuit sous 24 h</span>`.
						 *
						 * La descente ne relevait que les feuilles, et le libellé — un simple nœud
						 * texte à côté de l'icône — était perdu. Les trois garanties du bandeau
						 * tarifaire des 26 pages de zone disparaissaient ainsi silencieusement : le
						 * bandeau se rendait avec un conteneur vide de 0 px de haut.
						 *
						 * Le relevé du texte propre est volontairement limité aux éléments dont tous
						 * les enfants sont des icônes ou des puces (deux caractères au plus) : partout
						 * ailleurs, il ferait double emploi avec la descente.
						 */
						const enfantsDecoratifs = [...n.children].every((c) => txt(c).length <= 2);
						const propre = [...n.childNodes]
							.filter((x) => x.nodeType === 3)
							.map((x) => x.textContent)
							.join(' ')
							.replace(/\s+/g, ' ')
							.trim();
						walk(n);
						if (enfantsDecoratifs && propre.length > 2) out.push({ t: 'span', v: propre });
					}
				}
			};
			walk(sec);
			return out;
		};

		const secs = sections.map(flatten);
		const idxOf = (pred) => secs.findIndex((s) => s.some(pred));

		/**
		 * Découpe une section en groupes « titre h2/h3 + paragraphes + liste + noms simples ».
		 * C'est la brique commune des deux grands blocs narratifs : leur nombre de groupes varie
		 * (4 pour un département, 5 pour une ville), leur forme non.
		 */
		const groups = (sec) => {
			if (!sec) return [];
			const out = [];
			let cur = null;
			for (const n of sec) {
				if (n.t === 'h2' || n.t === 'h3') {
					/*
					 * Le **niveau** du titre est conservé, et ce n'est pas un détail de sémantique.
					 *
					 * Dans la maquette, la bande « Nos villes d'intervention » d'une page de
					 * département est **un seul groupe** en h2, dont « Communes secondaires
					 * documentées » et « Autres communes citées » sont deux sous-titres h3. Le
					 * niveau perdu, le gabarit en faisait trois groupes de premier rang : la bande
					 * passait de deux colonnes de 566 px à quatre de 265 px, les pastilles de
					 * communes se retrouvaient à une ou deux par ligne au lieu de quatre, et la
					 * hiérarchie des titres devenait fausse pour les lecteurs d'écran.
					 */
					cur = { titre: n.v, niveau: n.t === 'h3' ? 3 : 2, textes: [], liste: [], chips: [], liens: [] };
					out.push(cur);
				} else if (cur) {
					if (n.t === 'p') cur.textes.push(n.v);
					else if (n.t === 'li') cur.liste.push(n.v);
					else if (n.t === 'a') cur.liens.push({ v: n.v, href: n.href });
					else if (n.t === 'span' && n.v.length > 1 && !/^[✓✕·+]$/.test(n.v)) cur.chips.push(n.v);
				}
			}
			// Nature du groupe, déduite de ses liens : le gabarit reconstruit les liens vers les
			// prestations et les zones depuis le contenu WordPress réel, et n'affiche en texte
			// simple que les noms de communes ou de quartiers sans page dédiée.
			for (const g of out) {
				// Le même groupe « prestations » se rend en cartes sur une page de ville (le libellé
				// porte une description : « Nettoyage de bureaux — Open-spaces, salles de réunion »)
				// et en simples liens sur une page de département (« Nettoyage de bureaux → »).
				// Rendre des cartes dans les deux cas triplait la hauteur de la section.
				g.variante = g.liens.some((l) => l.v.length > 40) ? 'cartes' : 'liens';
				if (g.liens.some((l) => l.href.startsWith('#/service/'))) g.kind = 'prestations';
				else if (g.liens.some((l) => l.href.startsWith('#/ville/'))) g.kind = 'villes';
				else if (g.liens.some((l) => l.href.startsWith('#/departement/'))) g.kind = 'departements';
				else if (g.liens.length) g.kind = 'liens';
				else g.kind = 'noms';
			}
			return out;
		};

		const hero = secs.find((s) => s.some((n) => n.t === 'h1')) || [];
		const iReponse = idxOf((n) => n.v === 'Réponse directe');
		const reponseSec = secs[iReponse] || [];

		// Bandeau tarifaire : trois libellés cochés, dont le rendu place le texte à côté du « ✓ ».
		const bandSec = secs.find((s) => s.some((n) => n.v === '✓')) || [];
		const bandItems = bandSec
			.filter((n) => n.t === 'span' && n.v !== '✓' && !n.v.includes('€') && n.v.length > 3)
			.map((n) => n.v)
			.filter((v) => v !== 'tarif unique en région');

		// Récit : la section qui suit immédiatement la réponse directe.
		const recit = groups(secs[iReponse + 1]);

		// Tarif et exemple local, puis témoignage de la maquette.
		const iTarif = idxOf((n) => n.t === 'h2' && /^Tarif/.test(n.v));
		const tarifSec = secs[iTarif] || [];
		const tarifTitre = (tarifSec.find((n) => n.t === 'h2') || {}).v || '';
		/*
		 * La bande tarifaire porte **deux** paragraphes, dans deux colonnes différentes : celui de
		 * la colonne de gauche (« 27 € HT/h, comme dans le reste de la région… ») et celui de la
		 * carte d'exemple (« Trois passages de 1 h par semaine… »), qui explique d'où sort le
		 * montant. Les prendre tous les deux pour la colonne de gauche vidait la carte d'exemple de
		 * sa justification et allongeait la colonne de texte d'autant.
		 *
		 * Ils se distinguent à leur position : la carte d'exemple s'ouvre sur son libellé
		 * « Exemple · … », et tout paragraphe qui le suit lui appartient.
		 */
		const iExemple = tarifSec.findIndex((n) => n.t === 'span' && n.v.startsWith('Exemple ·'));
		const tarifTextes = tarifSec.filter((n, i) => n.t === 'p' && (iExemple < 0 || i < iExemple)).map((n) => n.v);
		const exempleTexte = iExemple < 0 ? '' : (tarifSec.find((n, i) => i > iExemple && n.t === 'p') || {}).v || '';
		const exempleLabel = iExemple < 0 ? '' : tarifSec[iExemple].v;
		const tSpans = tarifSec.filter((n) => n.t === 'span').map((n) => n.v);
		const tTexte = tSpans.find((v) => v.length > 80) || '';
		const ti = tSpans.indexOf(tTexte);
		const temoignage = tTexte ? { texte: tTexte, auteur: tSpans[ti + 1] || '', role: tSpans[ti + 2] || '' } : null;

		// Méthode : la section suivant le bloc tarifaire.
		const methode = groups(secs[iTarif + 1]);

		// Sections de liens : villes du département, prestations, quartiers, communes proches,
		// départements limitrophes, renvois. Leur position varie selon le niveau — un département
		// place ses villes avant le bloc tarifaire, une ville les place après — on prend donc, dans
		// l'ordre du document, tout ce qui se trouve entre le récit et la FAQ sans être le bloc
		// tarifaire ni le bloc méthode.
		const iFaq = idxOf((n) => n.t === 'h2' && n.v.startsWith('Questions fréquentes'));
		const locaux = [];
		let locauxAvantTarif = 0;
		for (let i = iReponse + 2; i < iFaq; i++) {
			if (i === iTarif || i === iTarif + 1) continue;
			const g = groups(secs[i]);
			// L'appartenance à une section d'origine est conservée : la maquette regroupe parfois
			// plusieurs groupes dans une même bande de fond, et les séparer changerait le nombre de
			// sections rendues.
			for (const x of g) x.section = i;
			locaux.push(...g);
			if (i < iTarif) locauxAvantTarif += g.length;
		}

		const faqSec = secs[iFaq] || [];
		const faqTitre = (faqSec.find((n) => n.t === 'h2') || {}).v || '';
		const faq = [];
		for (let i = 0; i < faqSec.length; i++) {
			if (faqSec[i].t === 'span' && faqSec[i].v.endsWith('?')) {
				const p = faqSec.slice(i + 1).find((n) => n.t === 'p');
				if (p) faq.push({ q: faqSec[i].v, a: p.v });
			}
		}

		const contactSec = secs.find((s) => s.some((n) => n.t === 'h2' && n.v === 'Nous contacter')) || [];
		const ctaSec = secs[secs.length - 1] || [];

		return {
			h1: (hero.find((n) => n.t === 'h1') || {}).v || '',
			heroLede: (hero.find((n) => n.t === 'p') || {}).v || '',
			heroAlt: (hero.find((n) => n.t === 'img') || {}).v || '',
			ctaLabel: (hero.find((n) => n.t === 'a' && n.href === '#/demande-de-devis') || {}).v || '',
			ctaPhoneLabel: (hero.find((n) => n.t === 'a' && n.href.startsWith('tel:')) || {}).v || '',
			bandItems,
			reponse: (reponseSec.find((n) => n.t === 'p') || {}).v || '',
			recit,
			tarifTitre,
			tarifTextes,
			exempleLabel,
			exempleTexte,
			temoignage,
			methode,
			locaux,
			locauxAvantTarif,
			faqTitre,
			faq,
			contactTitre: (contactSec.find((n) => n.t === 'h2') || {}).v || '',
			contactTexte: (contactSec.find((n) => n.t === 'p') || {}).v || '',
			ctaTitre: (ctaSec.find((n) => n.t === 'h2') || {}).v || '',
			ctaTexte: (ctaSec.find((n) => n.t === 'p') || {}).v || '',
		};
	});

	all.push({ ...zone, ...data });
	console.error(
		`  ${zone.slug.padEnd(22)} ${zone.niveau.padEnd(12)} récit ${data.recit.length} · ` +
			`méthode ${data.methode.length} · liens ${data.locaux.map((g) => g.kind).join('/')} · FAQ ${data.faq.length} · ` +
			`témoignage ${data.temoignage ? 'oui' : 'non'}`
	);
}
await browser.close();

/* ------------------------------------------------------------------ */

const L = [];
L.push('<?php');
L.push('/**');
L.push(' * Contenu intégral des 26 zones, relevé dans la maquette Claude Design.');
L.push(' *');
L.push(' * Fichier **généré** par `node tools/generate-zones.mjs` — ne pas éditer à la main : toute');
L.push(" * correction se fait dans le générateur, sinon la prochaine régénération l'écrase.");
L.push(' *');
L.push(' * Chaque zone a son propre contenu dans la maquette (tissu économique, types de locaux,');
L.push(' * quartiers, FAQ) : il est repris tel quel, jamais dupliqué en changeant un nom de commune.');
L.push(' * Les montants ne sont pas figés ici, le gabarit les recalcule depuis site-options.php.');
L.push(' *');
L.push(' * Usage : wp eval-file bin/seed-fidelite-zones.php');
L.push(' * Idempotent : upsert par slug, une deuxième exécution ne crée aucun doublon.');
L.push(' */');
L.push('');
L.push("if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {");
L.push('\tdie( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-zones.php\\n" );');
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
L.push('echo "=== Fidélité Claude Design : contenu intégral des 26 zones ===\\n";');
L.push('');

for (const z of all) {
	L.push(`/* ---------------- ${z.slug} (${z.niveau}) ---------------- */`);
	L.push(`$posts = get_posts( array( 'post_type' => 'zone', 'name' => ${php(z.slug)}, 'numberposts' => 1, 'post_status' => 'any' ) );`);
	L.push('if ( empty( $posts ) ) {');
	L.push(`\techo "  ! zone ${z.slug} absente — lancer d'abord les seeds de phase 2/3\\n";`);
	L.push('} else {');
	L.push('\t$id = $posts[0]->ID;');
	const set = (k, v) => L.push(`\ttfp_seed_set_field( ${php(k)}, ${v}, $id );`);
	set('h1', php(z.h1));
	set('hero_lede', php(z.heroLede));
	set('hero_alt', php(z.heroAlt));
	set('cta_label', php(z.ctaLabel));
	set('cta_phone_label', php(z.ctaPhoneLabel));
	set('band_items', phpLines(z.bandItems));
	set('reponse_directe', php(corriger(z.slug, 'reponse', z.reponse)));

	z.recit.slice(0, 6).forEach((g, i) => {
		set(`recit_${i + 1}_titre`, php(g.titre));
		set(`recit_${i + 1}_texte`, phpLines(g.textes));
		set(`recit_${i + 1}_liste`, phpLines(g.liste));
	});

	set('tarif_titre', php(z.tarifTitre));
	set('tarif_texte', phpLines(z.tarifTextes));
	set('exemple_label', php(z.exempleLabel));
	// Phrase qui justifie le montant, dans la carte d'exemple de la maquette — pas dans la colonne
	// de texte, où elle allongeait la bande sans expliquer le chiffre affiché juste à côté.
	set('exemple_texte', php(z.exempleTexte));
	if (z.temoignage) {
		set('temoignage_texte', php(z.temoignage.texte));
		set('temoignage_auteur', php(z.temoignage.auteur));
		set('temoignage_role', php(z.temoignage.role));
	}

	z.methode.slice(0, 4).forEach((g, i) => {
		set(`methode_${i + 1}_titre`, php(g.titre));
		set(`methode_${i + 1}_texte`, phpLines(g.textes));
		set(`methode_${i + 1}_liste`, phpLines(g.liste));
	});

	z.locaux.slice(0, 8).forEach((g, i) => {
		set(`locaux_${i + 1}_titre`, php(g.titre));
		set(`locaux_${i + 1}_texte`, phpLines(g.textes));
		set(`locaux_${i + 1}_type`, php(g.kind));
		set(`locaux_${i + 1}_variante`, php(g.variante || 'liens'));
		set(`locaux_${i + 1}_section`, g.section);
		// Niveau du titre relevé sur la maquette : un groupe de niveau 3 est un sous-groupe du
		// précédent — il reste dans sa colonne et son titre est un `h3`.
		set(`locaux_${i + 1}_niveau`, g.niveau || 2);
		// Les noms sans lien sont des communes ou quartiers cités, sans page dédiée : ils restent
		// du texte, jamais un lien mort.
		set(`locaux_${i + 1}_noms`, phpLines(g.chips));
	});

	set('locaux_avant_tarif', z.locauxAvantTarif);
	set('faq_titre', php(z.faqTitre));
	z.faq.slice(0, 8).forEach((f, i) => {
		L.push(`\ttfp_seed_set_field( 'faq_${i + 1}', array( 'question' => ${php(f.q)}, 'reponse' => ${php(f.a)} ), $id );`);
	});

	set('contact_titre', php(z.contactTitre));
	set('contact_texte', php(z.contactTexte));
	set('cta_titre', php(z.ctaTitre));
	set('cta_texte', php(z.ctaTexte));
	L.push(`\techo "  ✓ ${z.slug}\\n";`);
	L.push('}');
	L.push('');
}
L.push('echo "Terminé.\\n";');

writeFileSync(OUT, L.join('\n') + '\n');
console.error(`\nÉcrit : ${OUT}`);
console.error(`Accords corrigés (CLAUDE.md §9) : ${accordsCorriges}`);
