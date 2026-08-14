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
	// Un booléen sérialisé en chaîne devient `'false'`, qui est **vrai** en PHP. Bug silencieux et
	// exactement inversé : la disposition en cartes s'appliquait partout au lieu de nulle part.
	if (typeof v === 'boolean') return v ? 'true' : 'false';
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

		/**
		 * Nombre de colonnes sur lesquelles la maquette répartit les blocs d'une section.
		 *
		 * Relevé sur le rendu, pas déduit du contenu : le thème devinait jusqu'ici la disposition
		 * (« plusieurs blocs courts ⇒ colonnes »), et cette heuristique se trompait. Sur la section
		 * « Qui nous sommes » de /a-propos/, neuf paires titre + paragraphe étaient rangées en
		 * colonnes alors que la maquette les empile sur toute la largeur : 2 083 px de maquette
		 * rendus en 1 338 px.
		 *
		 * Le signal est direct : deux intertitres qui partagent la même ordonnée sont côte à côte.
		 */
		const colonnesOf = (sec) => {
			const tops = [...sec.querySelectorAll('h2,h3')].map((h) => Math.round(h.getBoundingClientRect().top));
			if (tops.length < 2) return 1;
			const paliers = new Map();
			for (const t of tops) {
				const cle = [...paliers.keys()].find((k) => Math.abs(k - t) <= 8);
				paliers.set(cle ?? t, (paliers.get(cle ?? t) || 0) + 1);
			}
			return Math.max(...paliers.values());
		};

		/**
		 * La maquette pose-t-elle les blocs de cette bande dans des cartes ?
		 *
		 * Même principe que pour les colonnes : c'est relevé, pas deviné. Un intertitre est « en
		 * carte » si l'un de ses ancêtres, sous la bande, est arrondi et porte un fond ou un filet.
		 * On tranche à la majorité — une bande mélange rarement les deux traitements, et une
		 * exception isolée ne doit pas décider pour toute la bande.
		 *
		 * Sans ce relevé, /nettoyage-professionnel/ rendait 40 cartes de la maquette en texte nu,
		 * /zones-intervention/ 18, la page région 31 : à hauteur voisine, l'écran n'avait rien à voir.
		 */
		const cartesOf = (sec, grilles = []) => {
			/*
			 * Les intitulés qui appartiennent à une **tuile de grille** ne votent pas.
			 *
			 * Ils trouvent forcément un ancêtre arrondi et encadré — leur propre tuile — et la
			 * majorité bascule alors sur « bande en cartes ». La bande recevait ainsi un second
			 * encadrement, autour de cartes qui en portaient déjà un : une carte dans une carte,
			 * absente de la référence. Le coût n'était pas décoratif. Ce cadre ajoutait 18 px de
			 * rembourrage et un filet de chaque côté, soit **38 px de largeur utile en moins** :
			 * à 375 px, la description d'une tuile se repliait sur une ligne de plus que la
			 * maquette, et l'écart de hauteur qui en résultait était ensuite compensé par une
			 * typographie plus petite. Deux erreurs qui s'annulaient à peu près, et qu'aucune
			 * mesure de hauteur seule ne pouvait distinguer.
			 *
			 * Les grilles sont relevées avant, par grillesDeCartes() : leurs tuiles sont donc
			 * connues ici, et le composant de grille les rend déjà en cartes.
			 */
			const tuiles = new Set();
			for (const g of grilles) for (const c of g.enfants || []) tuiles.add(c);
			const dansTuile = (el) => {
				for (let n = el; n && n !== sec; n = n.parentElement) if (tuiles.has(n)) return true;
				return false;
			};

			const titres = [...sec.querySelectorAll('h2,h3')].filter((t) => !dansTuile(t));
			if (!titres.length) return null;
			const trouvees = [];
			/*
			 * L'encadrement se relève **bloc par bloc**, et non pour la bande entière.
			 *
			 * La règle de majorité ne sait pas exprimer ce que la maquette fait couramment : une
			 * bande où un seul bloc est encadré — un encart turquoise au milieu de texte suivi.
			 * Avec un encadré sur deux blocs, la majorité tranchait « bande plate » et l'encart
			 * disparaissait ; avec deux sur trois, elle encadrait aussi le bloc qui ne l'est pas.
			 * Chaque bloc porte donc sa propre réponse, et la valeur de bande ne subsiste que comme
			 * repli pour les contenus produits avant ce relevé.
			 */
			const parTitre = {};
			for (const t of titres) {
				for (let el = t.parentElement; el && el !== sec; el = el.parentElement) {
					if (tuiles.has(el)) break;
					const s = getComputedStyle(el);
					if (
						parseFloat(s.borderRadius) >= 8 &&
						(parseFloat(s.borderTopWidth) > 0 || s.backgroundColor !== 'rgba(0, 0, 0, 0)')
					) {
						trouvees.push(s);
						/*
						 * Rembourrage **déclaré**, pas calculé.
						 *
						 * Le prototype écrit `clamp(22px, 3vw, 32px)` : la carte respire moins sur
						 * un petit écran, et le relevé, fait à 1440 px, n'en gardait que la borne
						 * haute. À 768 px, le thème posait 32 px là où la maquette en pose 23,04 —
						 * 9 px de trop de chaque côté, sur quinze blocs de la seule page des zones.
						 * Le thème compensait par un seuil fixe à 599 px, qui écrasait la valeur
						 * relevée au lieu de la suivre, et se trompait des deux côtés du seuil.
						 */
						const declare = (el.style && el.style.padding) || '';
						parTitre[(t.textContent || '').replace(/\s+/g, ' ').trim()] = {
							padding: declare || s.padding,
							rayon: (el.style && el.style.borderRadius) || s.borderRadius,
							fond: s.backgroundColor,
							marge_bas: (el.style && el.style.marginBottom) || s.marginBottom,
						};
						break;
					}
				}
			}
			if (!trouvees.length) return null;
			// La géométrie est relevée sur la carte réelle, pas supposée : le rembourrage varie de
			// 16 à 32 px selon la bande, et poser 32 partout allongeait /nettoyage-professionnel/
			// de 15 %. Le mode le plus fréquent l'emporte.
			const mode = (cle) => {
				const m = new Map();
				for (const s of trouvees) m.set(s[cle], (m.get(s[cle]) || 0) + 1);
				return [...m.entries()].sort((a, b) => b[1] - a[1])[0][0];
			};
			return {
				padding: mode('padding'),
				rayon: mode('borderRadius'),
				fond: mode('backgroundColor'),
				// Majoritaire : conservé pour les consommateurs qui lisent encore la valeur de bande.
				majoritaire: trouvees.length > titres.length / 2,
				parTitre,
			};
		};

		/**
		 * Géométrie de **rangée** d'une bande : ce qui décide du moment où elle passe à une colonne.
		 *
		 * Le relevé était fait à 1440 px et le nombre de colonnes figé dans une classe, le thème
		 * basculant ensuite sur des seuils fixes — deux colonnes sous 900 px, une seule sous 600.
		 * La maquette ne procède pas ainsi : elle laisse ses rangées se replier **d'elles-mêmes**,
		 * chaque colonne portant `flex: 1 1 340px`. Le seuil dépend donc de la largeur disponible,
		 * et non de celle de la fenêtre — c'est pourquoi il varie de 600 à 900 px d'une bande à
		 * l'autre, et pourquoi aucun seuil global ne peut les reproduire toutes.
		 *
		 * À 768 px, la conséquence était nette : la maquette donnait 707 px de large à ses bandes
		 * de texte, le thème 333, et cinq bandes de la page pilier s'en trouvaient allongées de
		 * 200 px chacune. Sept routes sur 53 tenaient dans la tolérance à cette largeur.
		 *
		 * Le prototype écrit ces valeurs en style en ligne : on les lit, on ne les devine pas.
		 */
		const rangeesOf = (sec) => {
			const parTitre = {};
			for (const t of sec.querySelectorAll('h2,h3')) {
				for (let el = t; el && el.parentElement && el !== sec; el = el.parentElement) {
					const parent = el.parentElement;
					const ps = getComputedStyle(parent);
					if (!/grid|flex/.test(ps.display) || parent.children.length < 2) continue;
					const cs = getComputedStyle(el);
					/*
					 * Base de colonne : la valeur **déclarée**, jamais la largeur mesurée — celle-ci
					 * ne vaut que pour la largeur du relevé. Le prototype emploie deux écritures :
					 * une rangée en `flex-wrap` dont chaque colonne porte `flex: 1 1 340px`, et une
					 * grille en `repeat(auto-fit, minmax(min(100%, 280px), 1fr))`. Dans les deux
					 * cas, c'est ce nombre qui décide du repli, et le repli dépend de la largeur
					 * disponible — pas de celle de la fenêtre.
					 */
					const declareGrille = (parent.style && parent.style.gridTemplateColumns) || '';
					const m = declareGrille.match(/minmax\(\s*(?:min\([^,]+,\s*)?([\d.]+px)/);
					const base = m ? m[1] : /^[\d.]+px$/.test(cs.flexBasis) ? cs.flexBasis : '';
					const mini = /^[\d.]+px$/.test(cs.minWidth) ? cs.minWidth : '';
					/*
					 * L'écart DÉCLARÉ, pas l'écart calculé. Le prototype écrit
					 * `gap: clamp(30px, 4vw, 52px)` ; `ps.gap` n'en rend que la valeur à la largeur du
					 * relevé, soit 52 px à 1440. Posée telle quelle, cette borne haute empêchait deux
					 * colonnes de tenir à 768 px — 2 × 340 + 52 = 732 pour 707 disponibles — là où la
					 * maquette les y met bien côte à côte avec 30,72 px d'écart. C'est le motif déjà
					 * corrigé sur le rembourrage de bande, sur une autre propriété.
					 */
					const gapDeclare = (parent.style && parent.style.gap) || '';
					parTitre[(t.textContent || '').replace(/\s+/g, ' ').trim()] = {
						colonne_min: base || mini || '',
						gap: gapDeclare || (ps.gap && ps.gap !== 'normal' ? ps.gap : ''),
					};
					break;
				}
			}
			return parTitre;
		};

		/**
		 * Sur combien de colonnes la maquette range-t-elle les listes d'une bande ?
		 *
		 * Les listes du prototype ne sont pas toutes des listes à puces : beaucoup sont des tuiles
		 * rangées sur deux ou trois colonnes. Rendues sur une seule, elles doublaient la hauteur des
		 * bandes concernées — 700 px de maquette rendus en 1 420 px sur « Comment choisir la bonne
		 * fréquence » de la page pilier. Mesuré sur le premier rang de la plus grande liste.
		 */
		const listeColonnesOf = (sec) => {
			const listes = [...sec.querySelectorAll('ul,ol')].filter((l) => l.children.length >= 3);
			if (!listes.length) return { colonnes: 1, tuile: false };
			const plus = listes.sort((a, b) => b.children.length - a.children.length)[0];
			const y0 = Math.round(plus.children[0].getBoundingClientRect().top);
			const rang0 = [...plus.children].filter((c) => Math.abs(Math.round(c.getBoundingClientRect().top) - y0) <= 8);
			// Une tuile porte un fond ou un filet ; une puce n'en a pas. La distinction évite de
			// transformer une vraie liste à puces en grille au seul motif qu'elle tient sur un rang.
			const s = getComputedStyle(plus.children[0]);
			const tuile = parseFloat(s.borderRadius) >= 6 || s.backgroundColor !== 'rgba(0, 0, 0, 0)';
			return { colonnes: Math.min(4, Math.max(1, rang0.length)), tuile };
		};

		/*
		 * ------------------------------------------------------------------
		 * Grilles de micro-cartes
		 * ------------------------------------------------------------------
		 *
		 * **La cause structurelle des écarts de cartes était ici.** L'aplatissement ci-dessous ne
		 * connaît que des titres, des paragraphes, des puces et des `span`. Or la maquette range une
		 * grande partie de son contenu en **micro-cartes** composées d'un intitulé *et* d'une
		 * description — parfois d'une icône, d'une image, d'un lien et de son libellé. Aplaties,
		 * elles perdaient leur description : le titre finissait en pastille (`noms`) et le texte
		 * partait ailleurs, ou disparaissait. La carte devenait alors **impossible à reconstituer à
		 * l'affichage**, quel que soit le gabarit ou le CSS — la donnée n'existait plus.
		 *
		 * On relève donc chaque grille de cartes **avant** l'aplatissement, avec sa géométrie et le
		 * détail de chacune de ses cartes, puis on retire ses nœuds du flux aplati en laissant un
		 * repère à leur place, pour que l'ordre de lecture soit conservé.
		 *
		 * Ce qui est une carte, et ce qui n'en est pas — mêmes critères que tools/inventaire-cartes.mjs,
		 * afin que l'extraction et la vérification ne puissent pas diverger :
		 *  - **carte** : bloc arrondi (rayon ≥ 6 px) distingué du fond par une couleur, un filet ou
		 *    une ombre, d'au moins 60 × 24 px ;
		 *  - **commande** (bouton, champ, lien court) : exclue — un bouton est arrondi et coloré,
		 *    mais il appartient au vocabulaire des commandes, pas à celui des blocs de contenu ;
		 *  - **conteneur de grille** : le parent n'est jamais compté, seules ses cartes le sont ;
		 *  - **wrapper technique** : un élément sans fond, sans filet et sans rayon n'est pas une
		 *    carte, quel que soit son rôle dans la mise en page ;
		 *  - **élément décoratif** : une image seule, sans texte, n'ouvre pas une carte.
		 */
		const estCommande = (el) => {
			const tag = el.tagName.toLowerCase();
			if (['button', 'input', 'select', 'textarea'].includes(tag)) return true;
			if (tag === 'a') {
				const r = el.getBoundingClientRect();
				return r.height <= 64 && el.children.length <= 2 && txt(el).length <= 40;
			}
			return false;
		};

		/** Luminance perçue : sert à dire si une carte est claire ou sombre. */
		const estSombre = (couleur) => {
			const m = (couleur || '').match(/\d+/g);
			if (!m || m.length < 3) return false;
			const [r, v, b] = m.map(Number);
			return 0.299 * r + 0.587 * v + 0.114 * b < 128;
		};

		/**
		 * Détail d'une carte : intitulé, description, surtitre, icône, image, lien, libellé du lien.
		 *
		 * Rien n'est fabriqué ici. Chaque champ est **lu** dans la carte du prototype ; s'il n'y est
		 * pas, il reste vide. En particulier, une description n'est jamais déduite d'un titre.
		 */
		const detailCarte = (el, rangIndex) => {
			const lien = el.matches('a[href]') ? el : el.querySelector('a[href]');
			const img = el.querySelector('img');
			const cs = getComputedStyle(el);

			// Nœuds textuels porteurs, dans l'ordre, en ignorant les conteneurs sans texte propre.
			/*
			 * Les fragments sont collectés **par bloc rendu**, et non par nœud texte direct.
			 *
			 * Prendre le texte propre de chaque élément découpait une phrase répartie sur plusieurs
			 * balises en ligne : la citation « … » d'un témoignage se scindait en un morceau
			 * « «  » » et un morceau sans ses guillemets, et la carte ne correspondait plus à celle
			 * de la maquette. Un lecteur voit des lignes ; on relève donc des lignes — un élément
			 * dont le rendu n'est pas `inline` prend tout son texte, et l'on ne descend pas dedans.
			 */
			const morceaux = [];
			const collecter = (n) => {
				for (const c of n.children) {
					const t = c.tagName.toLowerCase();
					if (t === 'img' || t === 'svg' || t === 'picture') continue;
					const s = getComputedStyle(c);
					const enLigne = /^inline/.test(s.display);
					const contenu = txt(c);
					if (!contenu) continue;
					/*
					 * Une liste dans une carte reste une liste.
					 *
					 * Elle était relevée comme un bloc de texte parmi d'autres, donc rendue en un
					 * seul paragraphe où les items se touchaient : « Postes de travail & mobilierSols
					 * : aspiration et lavageSanitaires & réapprovisionnement ». Ce n'est pas
					 * seulement une différence de géométrie — le texte devient illisible, et la
					 * carte tient sur quatre lignes là où la maquette en pose une par item.
					 */
					if ((t === 'ul' || t === 'ol') && c.querySelectorAll(':scope > li').length >= 2) {
						const items = [...c.querySelectorAll(':scope > li')].map((li) => txt(li)).filter(Boolean);
						if (items.length >= 2) {
							morceaux.push({
								texte: items.join(' · '),
								items,
								tag: t,
								taille: parseFloat(s.fontSize) || 0,
								interligne: s.lineHeight,
								marge: s.marginTop,
								graisse: parseInt(s.fontWeight, 10) || 400,
								majuscules: false,
							});
							continue;
						}
					}
					if (!enLigne) {
						morceaux.push({
							texte: contenu,
							tag: t,
							taille: parseFloat(s.fontSize) || 0,
							interligne: s.lineHeight,
							marge: s.marginTop,
							graisse: parseInt(s.fontWeight, 10) || 400,
							majuscules: s.textTransform === 'uppercase',
						});
						continue;
					}
					// Élément en ligne : son texte appartient à la ligne de son parent. On ne le
					// relève séparément que s'il constitue à lui seul tout un rang de la carte.
					const propre = [...c.childNodes]
						.filter((x) => x.nodeType === 3)
						.map((x) => x.textContent.replace(/\s+/g, ' ').trim())
						.filter(Boolean)
						.join(' ');
					if (propre && !c.children.length) {
						morceaux.push({
							texte: propre,
							tag: t,
							taille: parseFloat(s.fontSize) || 0,
							interligne: s.lineHeight,
							marge: s.marginTop,
							graisse: parseInt(s.fontWeight, 10) || 400,
							majuscules: s.textTransform === 'uppercase',
						});
					} else {
						collecter(c);
					}
				}
			};
			collecter(el);
			if (!morceaux.length) {
				const propre = txt(el);
				if (propre) morceaux.push({ texte: propre, tag: 'span', taille: 16, graisse: 400, majuscules: false });
			}

			// Icône : un premier morceau très court, fait de symboles ou d'un pictogramme.
			let icone = '';
			if (morceaux.length && morceaux[0].texte.length <= 3 && !/[a-zA-Z0-9]/.test(morceaux[0].texte)) {
				icone = morceaux.shift().texte;
			}

			// Libellé de lien : un dernier morceau terminé par une flèche.
			let libelleLien = '';
			if (morceaux.length > 1 && /→\s*$/.test(morceaux[morceaux.length - 1].texte)) {
				libelleLien = morceaux.pop().texte.replace(/\s*→\s*$/, '').trim();
			}

			// Surtitre : un premier morceau court, en petites capitales ou nettement plus petit que
			// le suivant. C'est l'étiquette que la maquette pose au-dessus de certains intitulés.
			let surtitre = '';
			if (
				morceaux.length > 2 &&
				(morceaux[0].majuscules || (morceaux[1] && morceaux[0].taille < morceaux[1].taille - 1)) &&
				morceaux[0].texte.length <= 40
			) {
				surtitre = morceaux.shift().texte;
			}

			// Une liste ne fait pas un intitulé : la carte qui commence par une liste n'a pas de titre.
			const premier = morceaux.length && !morceaux[0].items ? morceaux.shift() : null;
			const titre = premier ? premier.texte : '';
			// Balise d'origine de l'intitulé : la maquette emploie un vrai intertitre sur certaines
			// cartes et un simple libellé sur d'autres. Le reproduire garde la structure de titres du
			// document — et rend l'intitulé repérable comme bloc de contenu, ce qu'un `strong` n'est
			// pas.
			const titreTag = premier && /^h[2-4]$/.test(premier.tag) ? 'h3' : '';

			// Pastille : un fragment très court et purement numérique juste après l'intitulé — c'est
			// le numéro de département que la maquette pose à côté du nom. Laissé dans la
			// description, il produisait « 21 Préfecture : Dijon », qui ne veut rien dire.
			let badge = '';
			if (morceaux.length > 1 && /^\d{1,3}$/.test(morceaux[0].texte)) {
				badge = morceaux.shift().texte;
			}

			/*
			 * La description est le **premier** fragment restant, et les suivants sont conservés
			 * séparément. Les joindre en une seule chaîne effaçait les frontières de blocs : sur une
			 * carte témoignage, citation, auteur, rôle et ville formaient un seul paragraphe, que ni
			 * un lecteur d'écran ni la comparaison de textes ne pouvaient plus rapprocher de la
			 * maquette. Ce sont des lignes distinctes dans le prototype ; elles le restent ici.
			 */
			const mDesc = morceaux.length && !morceaux[0].items ? morceaux.shift() : null;
			const description = mDesc ? mDesc.texte : '';
			const mListe = morceaux.length && morceaux[0].items ? morceaux.shift() : null;
			const liste = mListe ? mListe.items : [];
			const lignes = morceaux.filter((m) => !m.items).map((m) => m.texte);

			/*
			 * Témoignage repris de la maquette : il est provisoire et doit rester repérable en une
			 * requête, comme les cartes témoignage des autres gabarits (CLAUDE.md §5.5). Le repère
			 * est le rendu — étoiles ou citation entre guillemets — et non un nom d'auteur, qu'on ne
			 * saurait pas reconnaître de façon fiable.
			 */
			const provisoire = /★{3,}/.test(txt(el)) || !!el.querySelector('blockquote') || /[«"]/.test(description);

			return {
				titre,
				titre_tag: titreTag,
				description,
				liste,
				lignes,
				/*
				 * Géométrie relevée **sur cette carte**, et non sur la première de la grille.
				 *
				 * Une grille du prototype mêle couramment des archétypes : sur la page région, un
				 * exemple tarifaire dont le montant est écrit en 32 px voisine avec un témoignage
				 * dont la citation fait 15,5. Relever la première carte et imposer sa géométrie aux
				 * suivantes posait 32 px sur la citation — 726 px de carte pour 50 attendus. Les
				 * valeurs de grille restent écrites, comme repli.
				 */
				titre_taille: premier ? premier.taille + 'px' : '',
				titre_interligne: premier ? premier.interligne || '' : '',
				desc_taille: mDesc || mListe ? (mDesc || mListe).taille + 'px' : '',
				desc_interligne: mDesc || mListe ? (mDesc || mListe).interligne || '' : '',
				desc_marge: mDesc || mListe ? (mDesc || mListe).marge || '' : '',
				badge,
				provisoire,
				surtitre,
				icone,
				image: img ? img.getAttribute('alt') || '' : '',
				route: lien ? lien.getAttribute('href') || '' : '',
				libelle_lien: libelleLien,
				aria: el.getAttribute('aria-label') || (lien ? lien.getAttribute('aria-label') || '' : ''),
				ordre: rangIndex,
				span: cs.gridColumn && cs.gridColumn !== 'auto' ? cs.gridColumn : '',
			};
		};

		/**
		 * Grilles de cartes d'une bande, avec leur géométrie relevée et le détail de leurs cartes.
		 * Renvoie aussi l'ensemble des nœuds concernés, pour que l'aplatissement les ignore.
		 */
		const grillesDeCartes = (sec) => {
			const grilles = [];
			const pris = new Set();

			for (const g of sec.querySelectorAll('div,ul,ol')) {
				if (pris.has(g)) continue;
				const gs = getComputedStyle(g);
				if (!/grid|flex/.test(gs.display) || g.children.length < 2) continue;

				const enfants = [...g.children].filter((c) => {
					const r = c.getBoundingClientRect();
					const s = getComputedStyle(c);
					return (
						r.width >= 60 &&
						r.height >= 24 &&
						parseFloat(s.borderTopLeftRadius) >= 6 &&
						(s.backgroundColor !== 'rgba(0, 0, 0, 0)' || parseFloat(s.borderTopWidth) > 0 || (s.boxShadow && s.boxShadow !== 'none'))
					);
				});
				/*
				 * Deux cartes suffisent. La contrainte « presque tous les enfants sont des cartes »
				 * existait pour éviter d'engloutir une bande mixte avec son conteneur ; ce risque a
				 * disparu depuis que le repère est posé sur la première carte et non sur le
				 * conteneur. La garder revenait à ignorer les grilles d'une bande mixte — la carte
				 * tarifaire de la bande « 27 € HT/h » notamment, absente sur trois routes.
				 */
				if (enfants.length < 2) continue;
				if (enfants.every(estCommande)) continue;
				// Une carte qui contient elle-même la grille entière est un conteneur : on ne prend
				// que la grille la plus profonde.
				if (enfants.some((c) => c.querySelector('div,ul,ol') && [...c.querySelectorAll('div,ul,ol')].some((x) => grilles.some((gr) => gr.el === x)))) continue;

				const k = enfants[0];
				const ks = getComputedStyle(k);
				const y0 = Math.round(k.getBoundingClientRect().top);
				const colonnes = enfants.filter((c) => Math.abs(Math.round(c.getBoundingClientRect().top) - y0) <= 8).length;

				/*
				 * Typographie interne des tuiles, relevée sur les cartes réelles.
				 *
				 * Le prototype ne compose pas toutes ses cartes de la même façon : l'intitulé va de
				 * 13 à 32 px selon la grille et même à l'intérieur d'une grille, la description de
				 * 11,5 à 17, et l'espace qui les sépare de 0 à 12 px. Poser une valeur unique rendait
				 * les pages plus courtes que la référence — 86 % sur la page pilier — sans qu'aucun
				 * contenu ne manque.
				 *
				 * Le titre et la description sont désignés par la **décomposition sémantique** de la
				 * carte, pas par leur rang parmi ses blocs : beaucoup de cartes s'ouvrent sur une
				 * pastille numérotée, un surtitre ou une icône, et le rang se décalait alors d'un
				 * cran — la géométrie de la pastille finissait sur l'intitulé, et celle de
				 * l'intitulé sur la description.
				 */
				const details = enfants.map((c, i) => detailCarte(c, i + 1));
				/*
				 * La géométrie de grille est celle de sa **première carte**, telle que la carte
				 * elle-même la relève. Elle ne sert plus que de repli : chaque carte porte
				 * désormais la sienne, ce qui est la seule façon de rendre fidèlement une grille
				 * qui mêle des archétypes. Passer par la décomposition de detailCarte() évite de
				 * désigner le titre et la description par leur rang parmi les blocs — beaucoup de
				 * cartes s'ouvrent sur une pastille, un surtitre ou une icône, et le rang se
                 * décalait alors d'un cran.
				 */
				const g0 = details[0] || {};

				grilles.push({
					el: g,
					// Première carte de la grille : c'est **elle** qui porte le repère de position, et
					// non le conteneur. Une bande mixte — une colonne de texte à côté de deux cartes —
					// verrait sinon sa colonne de texte engloutie avec le conteneur. C'est ce qui
					// faisait disparaître « Un tarif régional unique » et son paragraphe de la page
					// région : le seul contenu manquant des 53 routes.
					premier: enfants[0],
					enfants,
					colonnes: Math.min(6, Math.max(1, colonnes)),
					/*
					 * Base de colonne déclarée de la grille. Le prototype écrit
					 * `repeat(auto-fit, minmax(min(100%, 280px), 1fr))` : la grille se replie
					 * d'elle-même selon la place disponible, et la valeur change d'une grille à
					 * l'autre — 220 px pour les tâches par espace, 250 pour les fréquences, 280
					 * pour les blocs de responsabilité. Un nombre de colonnes figé, replié sur des
					 * seuils de fenêtre communs à toutes les grilles, ne peut pas reproduire cela.
					 */
					colonne_min: (() => {
						const d = (g.style && g.style.gridTemplateColumns) || '';
						const m = d.match(/minmax\(\s*(?:min\([^,]+,\s*)?([\d.]+px)/);
						if (m) return m[1];
						const e0 = enfants[0];
						const es = e0 ? getComputedStyle(e0) : null;
						return es && /^[\d.]+px$/.test(es.flexBasis) ? es.flexBasis : '';
					})(),
					gap: gs.gap,
					fond: ks.backgroundColor,
					rayon: ks.borderTopLeftRadius,
					filet: ks.borderTopWidth,
					padding: ks.padding,
					theme: estSombre(ks.backgroundColor) ? 'sombre' : 'clair',
					titre_taille: g0.titre_taille || '',
					titre_interligne: g0.titre_interligne || '',
					desc_taille: g0.desc_taille || '',
					desc_interligne: g0.desc_interligne || '',
					desc_marge: g0.desc_marge || '',
					// Variante : ce que la carte porte, et non ce à quoi elle ressemble.
					variante: k.querySelector('img')
						? 'image'
						: k.matches('a[href]') || k.querySelector('a[href]')
							? 'lien'
							: 'texte',
					cartes: details,
				});
				for (const c of enfants) {
					pris.add(c);
					for (const d of c.querySelectorAll('*')) pris.add(d);
				}
			}
			return grilles;
		};

		const flatten = (sec, grilles = []) => {
			const out = [];
			// Nœuds appartenant à une grille de cartes : ils sont déjà relevés en structure et ne
			// doivent pas repasser dans le flux aplati — sinon chaque carte ressortirait une seconde
			// fois, son intitulé en pastille et sa description en paragraphe détaché.
			const dansGrille = new Set();
			for (const g of grilles) {
				// Seules les **cartes** sont retirées du flux, pas leur conteneur : une bande mixte
				// garde ainsi ses paragraphes, ses notes et ses liens, qui ne sont pas des cartes.
				for (const c of g.enfants) {
					dansGrille.add(c);
					for (const d of c.querySelectorAll('*')) dansGrille.add(d);
				}
			}
			const walk = (el) => {
				for (const n of el.children) {
					const tag = n.tagName.toLowerCase();
					// Repère de position : la grille reprend sa place exacte dans l'ordre de lecture.
					// Le repère est posé à l'emplacement de la première carte : la grille reprend donc
					// sa place exacte parmi les paragraphes et les notes de la bande.
					const rang = grilles.findIndex((g) => g.premier === n);
					if (rang >= 0) {
						out.push({ t: 'grille', i: rang });
						continue;
					}
					if (dansGrille.has(n)) continue;
					if (/^h[1-6]$/.test(tag)) {
						/*
						 * L'ordonnée sert à savoir, plus bas, si le titre est seul sur son rang (bloc
						 * pleine largeur) ou côte à côte avec d'autres (rangée de colonnes).
						 *
						 * C'est celle de sa COLONNE, pas la sienne. Deux colonnes d'une même rangée
						 * peuvent porter des intitulés de tailles très différentes — 34 px pour une
						 * colonne de texte, 19 px pour la carte voisine — et leurs boîtes commencent
						 * alors à 30 px d'écart alors qu'elles sont bien côte à côte. La tolérance de
						 * 8 px les séparait, la rangée n'était pas détectée, et les deux blocs
						 * finissaient empilés en `.tfp-static-run` là où la maquette les met côte à
						 * côte : 275 px de hauteur en trop sur la bande.
						 *
						 * La colonne, c'est l'ancêtre qui est enfant direct du premier conteneur
						 * flex ou grille à plusieurs enfants — exactement ce que `rangeesOf()`
						 * remonte pour lire la base de colonne déclarée.
						 */
						let colonne = n;
						for (let el = n; el && el.parentElement && el !== sec; el = el.parentElement) {
							const ps = getComputedStyle(el.parentElement);
							if (/grid|flex/.test(ps.display) && el.parentElement.children.length >= 2) {
								colonne = el;
								break;
							}
						}
						const r = colonne.getBoundingClientRect();
						out.push({ t: tag, v: txt(n), top: Math.round(r.top + window.scrollY) });
					}
					else if (tag === 'p') out.push({ t: 'p', v: txt(n) });
					else if (tag === 'li') out.push({ t: 'li', v: txt(n) });
					else if (tag === 'img') out.push({ t: 'img', v: n.getAttribute('alt') || '' });
					else if (tag === 'a' && !n.querySelector('h1,h2,h3,h4,p,li,img')) out.push({ t: 'a', v: txt(n), href: n.getAttribute('href') || '' });
					else if (tag === 'blockquote') out.push({ t: 'quote', v: txt(n) });
					else if (!n.children.length && txt(n)) {
						/*
						 * On relève si ce fragment est **rendu en pastille** par la maquette — fond ou
						 * filet, et rayon d'au moins 40 px. Sans cette mesure, tout `span` finissait en
						 * pastille par défaut : des phrases de transition, des notes et des conclusions
						 * se retrouvaient enfermées dans des chips qui n'existent pas dans le prototype.
						 * Un élément n'est une pastille que si la maquette le présente comme telle.
						 */
						const sp = getComputedStyle(n);
						const fond = sp.backgroundColor !== 'rgba(0, 0, 0, 0)' && sp.backgroundColor !== 'transparent';
						out.push({
							t: 'span',
							v: txt(n),
							pastille: parseFloat(sp.borderTopLeftRadius) >= 40 && (fond || parseFloat(sp.borderTopWidth) > 0),
						});
					}
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
			// Les grilles de cartes sont relevées **avant** l'aplatissement : leurs nœuds sont
			// ensuite retirés du flux, un repère prenant leur place pour conserver l'ordre.
			const grilles = grillesDeCartes(sec);
			const cadres = cartesOf(sec, grilles);
			const rangees = rangeesOf(sec);
			let nodes = flatten(sec, grilles);
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
						(cur.titre ||
						cur.textes.length ||
						cur.liste.length ||
						cur.liens.length ||
						cur.noms.length ||
						cur.citations.length ||
						cur.faq.length ||
						cur.etapes.length ||
						cur.cartes.length ||
						cur.sequence.length)
				) {
					blocs.push(cur);
				}
			};
			/*
			 * ------------------------------------------------------------------
			 * Séquence hétérogène ordonnée
			 * ------------------------------------------------------------------
			 *
			 * Une bande de la maquette n'est **ni** une grille de cartes **ni** un empilement de
			 * paragraphes : c'est couramment les deux, dans un ordre précis — surtitre, titre,
			 * introduction, grille, note, citation, liste, lien, appel à l'action, second groupe de
			 * cartes, conclusion. Le modèle précédent rangeait chaque type dans son propre tiroir
			 * (`textes`, `liste`, `noms`, `cartes`…), ce qui effaçait l'ordre et les frontières :
			 * une note écrite entre deux grilles ressortait après elles, et tout `span` non classé
			 * finissait en pastille.
			 *
			 * `sequence` porte donc les enfants d'une bande **dans leur ordre de lecture**, chacun
			 * avec son type explicite. Les tiroirs restent alimentés pour les consommateurs
			 * existants, mais le rendu s'appuie sur la séquence.
			 */
			const vide = () => ({
				titre: '',
				niveau: 'h2',
				carte: '',
				colonne_min: '',
				rangee_gap: '',
				grille: false,
				colonnes: 1,
				sequence: [],
				cartes: [],
				textes: [],
				liste: [],
				liens: [],
				noms: [],
				citations: [],
				faq: [],
				etapes: [],
			});
			/** Ajoute un enfant typé à la séquence du bloc courant. */
			const seq = (type, charge) => cur.sequence.push({ type, ...charge });
			/** Les puces consécutives forment une seule liste : c'est ainsi que la maquette les rend. */
			const seqListe = (item) => {
				const dernier = cur.sequence[cur.sequence.length - 1];
				if (dernier && dernier.type === 'list') dernier.items.push(item);
				else seq('list', { items: [item] });
			};
			// Ordonnées de tous les titres de la bande : sert à décider, titre par titre, s'il est
			// pleine largeur ou en rangée.
			const rangs = nodes.filter((n) => n.t === 'h2' || n.t === 'h3').map((n) => n.top);
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
					// Encadrement propre à ce bloc, relevé sur la maquette. Vide = bloc plat.
					cur.carte = ( cadres && cadres.parTitre && cadres.parTitre[n.v] ) || '';
					// Repli intrinsèque de la rangée : relevé sur le prototype, pas déduit d'un seuil.
					const rangee = rangees[n.v] || null;
					cur.colonne_min = rangee ? rangee.colonne_min : '';
					cur.rangee_gap = rangee ? rangee.gap : '';
					/*
					 * Une bande de la maquette mélange souvent un bloc d'introduction sur toute la
					 * largeur et une rangée de cartes. Une grille uniforme ne sait pas exprimer cela :
					 * elle rangeait l'introduction dans la première colonne, à côté des cartes. Le
					 * repère est direct — un titre seul sur son ordonnée est pleine largeur, un titre
					 * qui partage son ordonnée avec d'autres appartient à une rangée.
					 */
					// Nombre de titres qui partagent l'ordonnée de celui-ci : c'est le nombre de colonnes
					// de **sa** rangée. Le maximum de la bande ne convient pas — une bande peut porter
					// une rangée de quatre cartes puis une rangée de trois, et prendre le maximum
					// rangeait la seconde sur quatre colonnes dont une vide.
					cur.colonnes = rangs.filter((y) => Math.abs(y - n.top) <= 8).length;
					cur.grille = cur.colonnes > 1;
					question = null;
				} else {
					if (!cur) cur = vide();
					/*
					 * Repère de grille : rattaché au bloc courant, à sa place dans l'ordre de lecture.
					 * Traité avant toute lecture de texte — un repère n'en porte pas.
					 */
					if (n.t === 'grille') {
						const g = grilles[n.i];
						if (g) {
							// Toute la géométrie relevée est transmise : la filtrer clé par clé, c'était
							// exactement le genre de perte que cette passe corrige.
							const { el: _el, cartes: _cartes, ...geometrie } = g;
							const grille = { ...geometrie, items: g.cartes };
							cur.cartes.push(grille);
							seq('grid', grille);
						}
						continue;
					}
					const propre = n.v.replace(/\s*\+$/, '').trim();
					// Le repère fiable d'un accordéon est le « + » qui suit son intitulé — la
					// maquette y met aussi bien des questions que des objections entre guillemets,
					// donc terminer par « ? » ne suffit pas.
					const suivant = nodes[k + 1];
					const estQuestion =
						n.t === 'span' &&
						propre.length > 8 &&
						((suivant && suivant.t === 'span' && suivant.v.trim() === '+') || /\?\s*\+?$/.test(n.v));
					// Étape numérotée : la maquette la rend en carte — pastille « 01 » à gauche, titre
					// et paragraphe à droite. Aplatie, elle devenait une file de pastilles suivie de
					// paragraphes détachés : le lien entre un numéro, son titre et son texte était
					// perdu, et la section perdait la moitié de sa hauteur.
					const etape =
						n.t === 'span' &&
						/^\d{2}$/.test(propre) &&
						suivant &&
						suivant.t === 'span' &&
						nodes[k + 2] &&
						nodes[k + 2].t === 'p';
					if (etape) {
						const e = { numero: propre, titre: suivant.v.trim(), texte: nodes[k + 2].v };
						cur.etapes.push(e);
						seq('step', e);
						k += 2;
					} else if (estQuestion) question = propre;
					else if (n.t === 'p' && question) {
						const f = { question, reponse: n.v };
						cur.faq.push(f);
						seq('faq', f);
						question = null;
					} else if (n.t === 'p') {
						cur.textes.push(n.v);
						seq('paragraph', { texte: n.v });
					} else if (n.t === 'li') {
						const item = n.v.replace(/^[▪✕✓]\s*/, '');
						cur.liste.push(item);
						seqListe(item);
					} else if (n.t === 'quote') {
						cur.citations.push(n.v);
						seq('quote', { texte: n.v });
					} else if (n.t === 'a' && n.href.startsWith('#/')) {
						cur.liens.push({ texte: n.v, route: n.href });
						seq('link', { texte: n.v, route: n.href });
					} else if (n.t === 'span' && n.v.length > 1 && !/^[✓✕·+]$/.test(n.v)) {
						/*
						 * **Plus de repli destructeur.** Un fragment n'est rendu en pastille que si la
						 * maquette le rend en pastille — mesuré au moment de l'extraction. Sinon c'est
						 * une note : une phrase de transition, une précision, une conclusion. Les
						 * enfermer dans des chips inventait des cartes que le prototype n'a pas, et
						 * privait ces phrases de leur forme réelle.
						 */
						if (n.pastille) {
							cur.noms.push(n.v);
							seq('chip', { texte: n.v });
						} else {
							seq('note', { texte: n.v });
						}
					}
				}
			}
			push();
			if (blocs.length) {
				// Rembourrage vertical relevé sur la bande : le prototype respire beaucoup plus que le
				// thème (84 px en haut comme en bas sur la plupart des bandes, 72 ou 48 sur d'autres,
				// contre 52 partout côté thème). Sur la page pilier, cet écart seul représentait
				// 64 px × 17 bandes, soit l'essentiel des 1 486 px manquants.
				const cs = getComputedStyle(sec);

				/**
				 * Rembourrage vertical **DÉCLARÉ** par la bande, et non mesuré.
				 *
				 * Le relevé prenait `cs.paddingTop` — la valeur calculée à la largeur du relevé. Or
				 * le prototype écrit ses rembourrages de bande en fonction : `clamp(44px, 6vw, 80px)`,
				 * `clamp(40px, 5vw, 72px)`, `clamp(20px, 3vw, 32px)`… Ne garder que la valeur calculée
				 * revient à figer l'une des bornes, et c'est le motif corrigé en G07 puis en G11 :
				 * juste à la largeur du relevé, faux partout ailleurs. À 768 px, une bande relevée à
				 * 80 px en rend 46,08 dans la maquette — 34 px d'écart par bande.
				 *
				 * On lit donc le raccourci `padding` du style en ligne et on en extrait les
				 * composantes haute et basse selon les règles du raccourci CSS. La valeur calculée ne
				 * sert plus que de repli, pour les bandes qui ne déclarent rien.
				 */
				const composantesPadding = (declare) => {
					if (!declare) return null;
					// Découpage au premier niveau : une virgule ou une espace DANS clamp() ne sépare rien.
					const morceaux = [];
					let profondeur = 0;
					let courant = '';
					for (const c of declare.trim()) {
						if (c === '(') profondeur++;
						if (c === ')') profondeur--;
						if (/\s/.test(c) && profondeur === 0) {
							if (courant) morceaux.push(courant);
							courant = '';
						} else {
							courant += c;
						}
					}
					if (courant) morceaux.push(courant);
					if (!morceaux.length) return null;
					// Raccourci CSS : 1 valeur → tout ; 2 → vertical/horizontal ; 3 → haut/horizontal/bas ;
					// 4 → haut/droite/bas/gauche.
					if (morceaux.length === 1) return { haut: morceaux[0], bas: morceaux[0] };
					if (morceaux.length === 2) return { haut: morceaux[0], bas: morceaux[0] };
					return { haut: morceaux[0], bas: morceaux[2] };
				};
				const declarePadding = composantesPadding(
					(sec.getAttribute('style') || '').match(/(?:^|;)\s*padding:\s*([^;]+)/)?.[1] || ''
				);
				/*
				 * Largeur de la colonne de lecture de la bande.
				 *
				 * Le prototype borne son texte narratif à 740-780 px là où le thème le laissait
				 * occuper les 1 114 px du conteneur. Une ligne plus large tient plus de mots, donc
				 * moins de lignes : chaque paragraphe passait de 134 px de haut à 84. Sur
				 * /zones-intervention/, les deux bandes narratives perdaient à elles seules 562 px,
				 * soit les deux tiers de l'écart de la page. Ce n'est pas un confort typographique
				 * facultatif — c'est la mesure du prototype, et elle décide de la hauteur.
				 *
				 * Relevée sur les paragraphes réels, pas sur un conteneur : seuls eux portent la
				 * colonne de lecture. Les grilles de cartes gardent toute la largeur.
				 */
				const paragraphes = [...sec.querySelectorAll('p')].filter((x) => txt(x).length > 60);
				const largeurTexte = paragraphes.length
					? Math.round(Math.max(...paragraphes.map((x) => x.getBoundingClientRect().width)))
					: 0;
				out.push({
					index: i,
					fond: fondOf(sec),
					padding_haut: (declarePadding && declarePadding.haut) || cs.paddingTop,
					padding_bas: (declarePadding && declarePadding.bas) || cs.paddingBottom,
					largeur_texte: largeurTexte,
					colonnes: colonnesOf(sec),
					cartes: cadres && cadres.majoritaire ? cadres : null,
					liste_grille: listeColonnesOf(sec),
					blocs,
				});
			}
		});

		// Accroche du hero : les paragraphes qui précèdent le premier H2 de la section du H1.
		const heroNodes = heroSec ? flatten(heroSec, grillesDeCartes(heroSec)) : [];
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
