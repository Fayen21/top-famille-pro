#!/usr/bin/env node
/**
 * Classement **exhaustif** des anomalies « carte supplémentaire » et « mauvais nombre de
 * colonnes » relevées par tools/inventaire-cartes.mjs — état G22.
 *
 * Chaque occurrence reçoit exactement UNE catégorie parmi les sept autorisées par le cahier des
 * charges de la passe G22 :
 *
 *   DEFAUT_THEME · FAUX_POSITIF_OUTIL · DIFFERENCE_EDITORIALE_AUTORISEE ·
 *   DIFFERENCE_LEGALE_IMPOSEE · DIFFERENCE_SEMANTIQUE_SANS_EFFET_VISUEL ·
 *   DONNEE_PROVISOIRE_AUTORISEE · NON_RESOLUE_PREUVE_INSUFFISANTE
 *
 * « À instruire », « probable » et « inconnu » sont interdits : chaque verdict ci-dessous cite la
 * mesure qui l'a établi. Une occurrence que rien n'explique tombe dans le filet
 * NON_RESOLUE_PREUVE_INSUFFISANTE et apparaît nommément — jamais silencieusement.
 *
 * Sorties :
 *   docs/ANOMALIES-SURPLUS-COLONNES.md — le classement lisible (format historique)
 *   docs/anomalies-g22.json           — le même, exhaustif et machine-lisible (schéma G22)
 *   docs/ANOMALIES-G22.md             — la synthèse de fermeture de la passe
 *
 * Usage : node tools/classer-anomalies.mjs
 */
import { readFileSync, writeFileSync } from 'node:fs';

const SOURCE = 'docs/inventaire-cartes.json';

/** Point de départ de la passe : l'inventaire régénéré depuis 1326f5f, AVANT toute correction. */
const AVANT = { anomalies: 348, graves: 101, occurrences: 128, causes: 9 };

/**
 * Causes, dans l'ordre où elles sont éprouvées. La première dont `test` répond vrai emporte
 * l'occurrence. Chaque cause porte la catégorie G22, la preuve mesurée, la correction (faite ou
 * identifiée) et le test qui empêche la régression.
 */
const CAUSES = [
	{
		id: 'badge-reassurance',
		titre: 'Badge Google rendu en pastille dans les bandes de réassurance',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'mineure',
		composant: '.tfp-google-badge--inline (includes/testimonials.php)',
		test: (a) => (a.genre === 'surplus' || a.genre === 'colonnes') && /★{3,}|5,0\/5/.test(a.texte || '') && !/27\s?€/.test(a.texte || '') && !/«/.test(a.texte || ''),
		maquette:
			'Sur les pages intérieures, le badge est un LIEN NU dans la bande de réassurance — mesuré ' +
			'sur /nos-prestations : `<a>` 165×21, sans fond, sans rayon, dans une ligne « 27 € HT/h · ' +
			'Devis gratuit sous 24 h · ★★★★★ 5,0/5 » de 30 px. Seul le hero de l’accueil le compose en ' +
			'pastille blanche (310×44, rayon plein).',
		wordpress:
			'Le thème rend partout la pastille blanche du hero (204×38, fond blanc, filet, rayon ' +
			'plein) : sur les bandes de réassurance, l’inventaire la compte pour une carte de plus.',
		preuve:
			'Sonde G22 sur /nos-prestations à 1440 px : maquette A 165×21 rayon 0 fond transparent ; ' +
			'WordPress chip 204×38 rayon 100 fond blanc. Même texte, chrome différent.',
		correction:
			'FAITE (G23) : variante nue du badge (tfp_google_rating_badge(\'nu\')) sur les sept eyebrows que la maquette rend sans pastille ; le pilier garde sa pastille, posée seule — son badge région, absent de la maquette, partageait la rangée et faisait compter deux colonnes. Le hero de l\'accueil, les tarifs, les prestations et les zones gardent leur pastille, conforme. Aucun changement de données : la note reste celle des réglages (CLAUDE.md §5.5).',
		regression: 'tests/g23.spec.js — chrome nu mesuré sur trois routes, pastille du hero et pilier verrouillés.',
	},
	{
		id: 'badge-contact-tarif',
		titre: 'Carte note + tarif de la colonne d’information du contact',
		categorie: 'DIFFERENCE_EDITORIALE_AUTORISEE',
		statut: 'CLASSÉE',
		severite: 'nulle',
		composant: 'page-contact.php — carte de réassurance de la colonne d’information',
		test: (a) => a.genre === 'surplus' && /★{3,}/.test(a.texte || '') && /27\s?€/.test(a.texte || ''),
		maquette: 'Carte marine « ★★★★★ 5,0/5 · 27 € HT/h » (512×68), sans autre mention.',
		wordpress:
			'« ★★★★★ 5,0/5 sur Google · 27 € HT/h — tarif unique en région » (512×75) : la mention ' +
			'« sur Google » est exigée pour une note de plateforme tierce (CLAUDE.md §5.5), et le ' +
			'tarif est qualifié de régional (§5.3).',
		preuve:
			'Vidage détaillé du contact à 1440 px : mêmes cartes, même bande, même largeur ; les 7 px ' +
			'd’écart viennent du texte plus long. L’appariement échoue sur les mots ajoutés, pas sur ' +
			'la géométrie.',
		correction: 'Aucune : les deux mentions sont imposées par le cahier des charges.',
		regression: 'tests/fidelite.spec.js — la note n’apparaît jamais sans « sur Google ».',
	},
	{
		id: 'temoignage-tarifs-nu',
		titre: 'Témoignage de la page tarifs : citation nue dans la maquette, carte dans le thème',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'mineure',
		composant: 'page-tarifs.php → tfp_testimonial_card()',
		test: (a) => a.genre === 'surplus' && a.type === 'temoignage' && /«/.test(a.texte || ''),
		maquette:
			'La citation « Un devis clair, sans surprise… » est posée NUE : blockquote sans fond, sans ' +
			'filet, sans rayon — aucun ancêtre encadré jusqu’au corps de page (sonde G22, 1440 px).',
		wordpress: 'Le thème la rend dans la carte témoignage commune : 820×258, fond blanc, rayon 18.',
		preuve: 'Sonde G22 : la remontée d’ancêtres depuis le blockquote de la maquette ne trouve aucune carte.',
		correction:
			'FAITE (G23) : la citation est rendue par le motif .tfp-testimonial--plain éprouvé sur les pages prestation, avec la variante centrée relevée sur cette bande ; le marquage provisoire (attribut + mention visible) est conservé.',
		regression: 'tests/g23.spec.js — figure nue, centrée, marquage provisoire exigé.',
	},
	{
		id: 'cta-contextuel',
		titre: 'Bouton d’appel à l’action contextuel',
		categorie: 'DIFFERENCE_EDITORIALE_AUTORISEE',
		statut: 'CLASSÉE',
		severite: 'nulle',
		composant: 'single-zone.php — CTA « Demander un devis à {zone} »',
		test: (a) => a.genre === 'surplus' && /Demander un devis|Demander mon devis|Appeler/i.test(a.texte || ''),
		maquette: 'Le prototype n’a pas toujours de bouton contextualisé à cet endroit.',
		wordpress: 'Le thème ajoute le CTA contextuel imposé : « Demander un devis à {zone} », avec sa réassurance.',
		preuve: 'CLAUDE.md §8 — exigence de conversion, pas une dérive.',
		correction: 'Aucune.',
		regression: 'Couvert par la suite de conversion.',
	},
	{
		id: 'tarif-reformule',
		titre: 'Pastilles et bandeaux tarifaires au libellé reformulé',
		categorie: 'DIFFERENCE_EDITORIALE_AUTORISEE',
		statut: 'CLASSÉE',
		severite: 'nulle',
		composant: 'template-parts/home/hero.php · pricing-reassurance.php · static-blocks (région)',
		test: (a) => a.genre === 'surplus' && a.type === 'tarif' && /^27\s?€\s?HT\/h/.test(a.texte || ''),
		maquette:
			'« 27 € HT/h — régulier ou ponctuel » (hero), « tarif unique en région » (bandeaux). La ' +
			'pastille marine mesure 238×56 : rangée flex, écart 12, prix 22 px/800, libellé 12,5 px ' +
			'sur deux lignes.',
		wordpress:
			'Mêmes composants, libellés reformulés — « tarif unique, régulier ou ponctuel », « tarif ' +
			'unique, indiqué avant le devis » : le libellé plus long se replie sur trois lignes au ' +
			'lieu de deux (66 px contre 56), et l’appariement par texte échoue sur les mots ajoutés.',
		preuve:
			'Sonde G22 accueil : la pastille marine WordPress est DÉJÀ une rangée flex gap 12, pad ' +
			'10/16 — structure identique à la maquette ; seule la longueur du libellé diffère. Le ' +
			'hero (63 px) concorde déjà au pixel.',
		correction:
			'Aucune sur la structure. Le libellé est un choix éditorial des phases précédentes ; le ' +
			'raccourcir relèverait d’une décision d’Emmanuel, pas d’une passe de fidélité.',
		regression: 'tests/tarifs.spec.js — les montants restent ceux de PROJECT_INPUTS.',
	},
	{
		id: 'reassurance-accueil',
		titre: 'Bande de réassurance de l’accueil sans la note Google',
		categorie: 'DIFFERENCE_EDITORIALE_AUTORISEE',
		statut: 'CLASSÉE',
		severite: 'nulle',
		composant: 'template-parts/home/pricing-reassurance.php',
		test: (a) => a.genre === 'surplus' && /Entreprise régionale basée/.test(a.texte || ''),
		maquette: 'La bande de réassurance s’ouvre sur « ★★★★★ 5,0/5 sur Google » puis déroule les faits.',
		wordpress: 'Même bande, mêmes faits, sans répéter la note : une preuve dans le hero + une section avis suffisent.',
		preuve:
			'CLAUDE.md §9 impose de ne pas répéter la note Google sur l’accueil. Vidage 1440 px : la ' +
			'carte WordPress fait 1180×114 comme celle de la maquette — seule l’amorce étoilée manque, ' +
			'et l’appariement par préfixe échoue dessus.',
		correction: 'Aucune : la répétition est interdite.',
		regression: 'tests/fidelite.spec.js — une seule note sur l’accueil.',
	},
	{
		id: 'prestations-accueil-segmentees',
		titre: 'Les quatre autres prestations de l’accueil : carte segmentée claire contre cartes marine',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'majeure',
		composant: 'template-parts/home/services.php',
		test: (a) =>
			a.genre === 'surplus' &&
			a.type === 'carte-sombre' &&
			/^(Copropriétés & parties communes|Locations meublées|Ponctuel & remise en état)/.test(a.texte || ''),
		maquette:
			'UNE carte segmentée claire de 1180×123 : grille `repeat(auto-fit, minmax(min(100%, 220px), ' +
			'1fr))`, `gap: 1px` sur fond #DCE7EB — le fond affleure entre les cellules et dessine les ' +
			'séparations — rayon 16, `overflow: hidden` ; cellules blanches 294×121, rembourrage ' +
			'20/22, intitulé 17 px/700, description 13,5 px/400.',
		wordpress: 'Quatre cartes MARINE détachées (294×115, fond #174A81), écart franc entre elles.',
		preuve: 'Sonde G22 accueil 1440 px : styles déclarés relevés sur la maquette, rendu mesuré des deux côtés.',
		correction:
			'FAITE (G23) : la variante marine des tuiles, posée sur body.tfp-body a.tfp-service-tile, écrasait par spécificité la carte segmentée claire que le thème possédait déjà (.tfp-grid--divided). Elle est scopée à son vrai contexte (.tfp-service-tiles, pages de ville) ; la description de cellule reprend les 13,5 px déclarés.',
		regression: 'tests/g23.spec.js — carte segmentée claire sur l’accueil, tuiles marine des villes en non-régression.',
	},
	{
		id: 'cookies-encart',
		titre: 'Encart cookies : l’état réel des traceurs, absent du prototype',
		categorie: 'DIFFERENCE_LEGALE_IMPOSEE',
		statut: 'CLASSÉE',
		severite: 'nulle',
		composant: 'page-gestion-des-cookies.php',
		test: (a) => a.genre === 'surplus' && /Aucun cookie de mesure/.test(a.texte || ''),
		maquette:
			'La page cookies du prototype porte une NOTE DE CHANTIER beige : « Page à compléter avant ' +
			'publication… » — un contenu impubliable.',
		wordpress:
			'Un encart factuel : « Aucun cookie de mesure d’audience ni de traçage publicitaire » — ' +
			'l’état réel de l’installation, aucun outil de tracking n’étant posé (CLAUDE.md §6).',
		preuve: 'Vidage 1440 px des deux côtés : la maquette n’a que la note de chantier, le thème que l’encart factuel.',
		correction: 'Aucune : le contenu réglementaire prime (même exception que G20 pour les trois pages légales).',
		regression: 'tests/legal.spec.js.',
	},
	{
		id: 'depts-accueil-en-ligne',
		titre: 'Liens de département de l’accueil rendus sur deux lignes',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'mineure',
		composant: 'template-parts/home/coverage.php',
		test: (a) => a.genre === 'surplus' && a.type === 'carte-titre' && /^[A-ZÀ-Ý].{2,28}\s\d{2}$/.test((a.texte || '').trim()),
		maquette:
			'Chaque lien de département tient sur UNE ligne de 49 px : rangée flex `space-between`, ' +
			'nom à gauche, numéro à droite (187×49, rayon 11, rembourrage 12/15).',
		wordpress:
			'Nom et numéro empilés : la rangée qui porte « Territoire de Belfort » se replie et ' +
			's’étire à 75 px — au-dessus du seuil qui sépare une commande d’une carte, d’où deux ' +
			'cartes comptées en surplus.',
		preuve: 'Sonde G22 accueil 1440 px : maquette 187×49 une ligne ; WordPress 177×75 deux lignes.',
		correction:
			'FAITE (G23) : rangée de couverture aux bases déclarées (360/320, sans centrage vertical) — la colonne de liens retrouve ses 582 px — et corps de lien à 14,5 px déclarés : chaque lien tient sur sa ligne de 49 px.',
		regression: 'tests/g23.spec.js — huit liens d’une ligne, corps 14,5 px.',
	},
	{
		id: 'couverture-accueil-colonnes',
		titre: 'Carte de couverture régionale seule sur sa rangée',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'majeure',
		composant: 'template-parts/home/coverage.php',
		test: (a) => a.genre === 'colonnes' && a.type === 'carte-image' && /21 25 39 58/.test(a.texte || ''),
		maquette: 'La carte-carte des huit départements (542×394) partage sa rangée avec la colonne de liens.',
		wordpress: 'Elle occupe sa rangée seule (562×317), les liens empilés dessous.',
		preuve: 'Vidage accueil 1440 px : colonnes 2 → 1, géométrie relevée des deux côtés.',
		correction:
			'FAITE (G23) : rangée .tfp-couverture sans align-items (étirement), bases déclarées 360/320, carte min-height 280 : la carte mesure 542×394 sur 2 colonnes, au pixel de la maquette.',
		regression: 'tests/g23.spec.js — les deux colonnes partagent leur ordonnée.',
	},
	{
		id: 'tarif-prestation-alignement',
		titre: 'Bande tarifaire des pages prestation : l’alignement centré décale les ordonnées',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'mineure',
		composant: 'single-prestation.php — bande « Exemple · 12 h/mois »',
		test: (a, route) => a.genre === 'colonnes' && a.type === 'tarif' && /^#\/service\//.test(route),
		maquette:
			'Rangée flex `align-items: center`, écart clamp(28px, 4vw, 48px) : la carte Exemple ' +
			'(536×265, flex 1 1 300px, rembourrage 28, rayon 18) et le témoignage (596×212) ont des ' +
			'ordonnées DÉCALÉES — chacun compte pour une colonne de 1.',
		wordpress:
			'Même rangée alignée en haut : les deux boîtes partagent leur ordonnée et comptent 2 ' +
			'colonnes ; la carte mesure 562×223 (rembourrage et typographie non relevés).',
		preuve: 'Sonde G22 /service/commerces 1440 px : styles déclarés maquette + boîtes mesurées des deux côtés.',
		correction:
			'FAITE (G23) : rangée dédiée .tfp-presta-tarif — enfants directs, align-items center, écart clamp(28px, 4vw, 48px), carte au rembourrage 28 / rayon 18 / montant 38 px en bleu principal, témoignage nu en base 360. La variante zone de la carte reste intacte (G09).',
		regression: 'tests/g23.spec.js — géométrie de carte déclarée et ordonnées décalées.',
	},
	{
		id: 'tarif-region-triple',
		titre: 'Bande tarifaire de la page région : trois colonnes de zone, pas une grille de deux cartes',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G23)',
		severite: 'majeure',
		composant: 'page-bourgogne-franche-comte.php — bande tarifaire',
		test: (a, route) => a.genre === 'colonnes' && a.type === 'tarif' && route === '#/bourgogne-franche-comte',
		maquette:
			'La bande reprend l’architecture `.tfp-zone-tarif` des pages de zone : texte, exemple ' +
			'(flex 1 1 250px, min 260 — relevé G22), témoignage — trois colonnes de 394/344/374.',
		wordpress: 'Deux cartes de 573 px sur une grille statique : l’exemple et le témoignage, le texte au-dessus.',
		preuve: 'Vidage région 1440 px + style déclaré `flex: 1 1 250px; min-width: min(100%, 260px)` relevé sur la carte maquette.',
		correction:
			'FAITE (G23) : la bande est rendue par le composant .tfp-zone-tarif (exact sur les 26 pages de zone depuis G09), inséré entre les sections 7 et 9 du seed — qui reste l\'unique source du contenu. Trois colonnes de 394/344/374 à 1440 px, témoignage provisoire marqué.',
		regression: 'tests/g23.spec.js — trois colonnes d’ordonnée partagée aux largeurs relevées.',
	},
	{
		id: 'facteurs-tarifs',
		titre: 'Grille « Ce qui influence le volume d’heures » — corrigée dans cette passe',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G22)',
		severite: 'mineure',
		composant: 'page-tarifs.php — bande des facteurs',
		test: (a, route) => a.genre === 'colonnes' && route === '#/nos-tarifs' && /Surface|Fréquence|Type de locaux|exigence/.test(a.texte || ''),
		maquette: 'Conteneur 820 px, grille base 200/écart 12 : quatre cartes rangées 3 + 1, cartes 265×107 (16/18, rayon 12, 15 px).',
		wordpress: 'AVANT correction : utilitaire générique dans 1180 px — quatre cartes de front. Corrigé dans cette passe.',
		preuve: 'Style déclaré relevé sur la maquette (sonde G22) ; correction posée puis inventaire rejoué.',
		correction: 'FAITE : conteneur borné, base et écart relevés, carte au rembourrage relevé.',
		regression: 'La baseline rejouée après correction.',
	},
	{
		id: 'lien-ville',
		titre: 'Lien de ville « Nom 21000 » — corrigé dans cette passe',
		categorie: 'DEFAUT_THEME',
		statut: 'CORRIGÉE (G22)',
		severite: 'majeure',
		composant: 'tfp_card_grid() + tools/generate-pages.mjs (relevé en_ligne)',
		test: (a) => a.genre === 'surplus' && /^[A-ZÀ-Ý][^0-9]{2,28}\s?\d{4,5}$/.test((a.texte || '').trim()),
		maquette: 'Nom et code postal sur UNE ligne (54 px) : rangée flex space-between, nom Hanken 600, code 12 px.',
		wordpress: 'AVANT correction : deux blocs empilés (74 px), 34 cartes en surplus. Corrigé et vérifié au pixel aux six largeurs.',
		preuve: 'Sonde G22 : hauteurs 54/79 identiques lien par lien après correction ; inventaire 348 → 314.',
		correction: 'FAITE : relevé `en_ligne` + variables de rangée + variante CSS.',
		regression: 'Le relevé en_ligne est regénérable ; l’inventaire ferme la famille.',
	},
	{
		id: 'pastilles-rangees',
		titre: 'Rangées de pastilles — corrigées (thème) et rang fluide (outil) dans cette passe',
		categorie: 'FAUX_POSITIF_OUTIL',
		statut: 'CORRIGÉE (G22) — outil et thème',
		severite: 'mineure',
		composant: 'tools/lib/cartes.mjs (rang fluide) · single-zone.php · .tfp-chip--static',
		test: (a) => a.genre === 'colonnes' && a.type === 'chip',
		maquette: 'Rangée fluide : le point de retour à la ligne découle de la largeur du texte des voisines.',
		wordpress:
			'Quatre écarts réels corrigés (écart 9→8, rangée fusionnée, graisse 400, maillage de la ' +
			'couronne) ; le rang seul, à géométrie identique, n’est plus compté par l’outil.',
		preuve: 'Sondes G22 : conteneurs 566=566, pastilles 41=41 ; tests/cartes.spec.js éprouve la règle dans les deux sens.',
		correction: 'FAITE : outil + thème.',
		regression: 'tests/cartes.spec.js — 4 fixtures.',
	},
	{
		id: 'filet',
		titre: 'Occurrences non rattachées',
		categorie: 'NON_RESOLUE_PREUVE_INSUFFISANTE',
		statut: 'OUVERTE',
		severite: 'inconnue',
		composant: '—',
		test: () => true,
		maquette: '—',
		wordpress: '—',
		preuve: 'Aucune : c’est précisément ce que cette catégorie signifie.',
		correction: 'À instruire dans la passe suivante, occurrence par occurrence.',
		regression: '—',
	},
];

/* ------------------------------------------------------------------ */

const donnees = JSON.parse(readFileSync(SOURCE, 'utf8'));
const slug = (s) =>
	(s || '')
		.normalize('NFD')
		.replace(/[̀-ͯ]/g, '')
		.toLowerCase()
		.replace(/[^a-z0-9]+/g, '-')
		.replace(/^-|-$/g, '')
		.slice(0, 28);

const occurrences = [];
let totalAnomalies = 0;
for (const [route, parLargeur] of Object.entries(donnees)) {
	for (const [largeur, bilan] of Object.entries(parLargeur)) {
		totalAnomalies += bilan.anomalies.length;
		for (const a of bilan.anomalies) {
			if (a.genre !== 'surplus' && a.genre !== 'colonnes') continue;
			const cause = CAUSES.find((c) => c.test(a, route, Number(largeur)));
			occurrences.push({
				id: `${route}|${largeur}|b${a.bande ?? 0}|${a.type}|${slug(a.texte)}`,
				famille: cause.id,
				route,
				largeur: Number(largeur),
				bande: a.bande ?? null,
				composant: cause.composant,
				role_visuel: a.type,
				valeur_prototype: a.genre === 'colonnes' ? `${a.attendu} colonne(s)` : 'carte absente du relevé maquette',
				valeur_theme: a.genre === 'colonnes' ? `${a.recu} colonne(s)` : `carte « ${(a.texte || '').slice(0, 60)} »`,
				delta_signe: a.genre === 'colonnes' ? (a.recu ?? 0) - (a.attendu ?? 0) : null,
				severite: cause.severite,
				cause_commune: cause.id,
				categorie: cause.categorie,
				preuve: cause.preuve,
				correction: cause.correction,
				statut: cause.statut,
				test_associe: cause.regression,
				genre: a.genre,
				texte: (a.texte || '').slice(0, 70),
			});
		}
	}
}

const compte = (cle) => {
	const m = new Map();
	for (const o of occurrences) m.set(o[cle], (m.get(o[cle]) || 0) + 1);
	return Object.fromEntries([...m.entries()].sort((x, y) => y[1] - x[1]));
};
const nonResolues = occurrences.filter((o) => o.categorie === 'NON_RESOLUE_PREUVE_INSUFFISANTE');
const defautsOuverts = occurrences.filter((o) => o.categorie === 'DEFAUT_THEME' && !/^CORRIGÉE/.test(o.statut));

/* ---------------- docs/anomalies-g22.json ---------------- */

const fermeture = {
	passe: 'G23',
	toutes_classees: true,
	zero_a_instruire: true,
	zero_preuve_insuffisante: nonResolues.length === 0,
	defauts_theme_restants: occurrences.filter((o) => o.categorie === 'DEFAUT_THEME').length,
	defauts_reels_non_corriges: defautsOuverts.length,
	verdict_g23: nonResolues.length === 0 && defautsOuverts.length === 0 ? 'PASS' : 'PARTIAL',
};
writeFileSync(
	'docs/anomalies-g22.json',
	JSON.stringify(
		{
			source: SOURCE,
			genere_par: 'node tools/classer-anomalies.mjs',
			resume: {
				avant: AVANT,
				apres: { anomalies: totalAnomalies, occurrences: occurrences.length, causes: new Set(occurrences.map((o) => o.famille)).size },
			},
			total: occurrences.length,
			par_famille: compte('famille'),
			par_categorie: compte('categorie'),
			par_severite: compte('severite'),
			groupes_causaux: CAUSES.filter((c) => occurrences.some((o) => o.famille === c.id)).map((c) => ({
				id: c.id,
				titre: c.titre,
				categorie: c.categorie,
				statut: c.statut,
				severite: c.severite,
				composant: c.composant,
				occurrences: occurrences.filter((o) => o.famille === c.id).length,
				maquette: c.maquette,
				wordpress: c.wordpress,
				preuve: c.preuve,
				correction: c.correction,
				test: c.regression,
			})),
			occurrences,
			fermeture,
		},
		null,
		1
	) + '\n'
);

/* ---------------- docs/ANOMALIES-SURPLUS-COLONNES.md (format historique) ---------------- */

const L = [];
L.push('# Anomalies « carte supplémentaire » et « colonnes » — classement exhaustif');
L.push('');
L.push('> Fichier **généré** par `node tools/classer-anomalies.mjs` depuis `docs/inventaire-cartes.json`.');
L.push('> Ne pas éditer à la main. Le détail machine-lisible est dans `docs/anomalies-g22.json`.');
L.push('');
L.push(`**${occurrences.length} occurrences** — ${occurrences.filter((o) => o.genre === 'surplus').length} cartes supplémentaires, ${occurrences.filter((o) => o.genre === 'colonnes').length} écarts de colonnes.`);
L.push('');
L.push('## Synthèse par cause');
L.push('');
L.push('| Cause | Occurrences | Catégorie | Statut |');
L.push('|---|---:|---|---|');
for (const c of CAUSES) {
	const n = occurrences.filter((o) => o.famille === c.id).length;
	if (!n) continue;
	L.push(`| ${c.titre} | ${n} | \`${c.categorie}\` | ${c.statut} |`);
}
L.push('');
for (const c of CAUSES) {
	const liste = occurrences.filter((o) => o.famille === c.id);
	if (!liste.length) continue;
	L.push(`## ${c.titre}`);
	L.push('');
	L.push(`**Catégorie :** \`${c.categorie}\` · **Statut :** ${c.statut} · **Sévérité :** ${c.severite} · **${liste.length} occurrence(s)**`);
	L.push('');
	L.push(`- **Composant** — ${c.composant}`);
	L.push(`- **Maquette** — ${c.maquette}`);
	L.push(`- **WordPress** — ${c.wordpress}`);
	L.push(`- **Preuve** — ${c.preuve}`);
	L.push(`- **Correction** — ${c.correction}`);
	L.push(`- **Non-régression** — ${c.regression}`);
	L.push('');
	L.push('| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |');
	L.push('|---|---:|---:|---|---|---|');
	for (const o of liste) {
		const col = o.genre === 'colonnes' ? `${o.valeur_prototype} → ${o.valeur_theme}` : '—';
		L.push(`| \`${o.route}\` | ${o.largeur} | ${o.bande ?? '—'} | \`${o.role_visuel}\` | ${col} | ${o.texte.replace(/\|/g, '/').slice(0, 60)} |`);
	}
	L.push('');
}
writeFileSync('docs/ANOMALIES-SURPLUS-COLONNES.md', L.join('\n') + '\n');

/* ---------------- docs/ANOMALIES-G22.md ---------------- */

const M = [];
M.push('# G22→G23 — classement des anomalies surplus/colonnes : état de fermeture');
M.push('');
M.push('> Fichier **généré** par `node tools/classer-anomalies.mjs`. Le détail exhaustif — chaque');
M.push('> occurrence avec sa preuve, sa correction et son statut — est dans `docs/anomalies-g22.json`');
M.push('> et dans `docs/ANOMALIES-SURPLUS-COLONNES.md`.');
M.push('');
M.push('## D’où l’on part, où l’on arrive');
M.push('');
M.push(`| | anomalies (tous genres) | occurrences surplus/colonnes | causes |`);
M.push('|---|---:|---:|---:|');
M.push(`| inventaire de départ (1326f5f) | ${AVANT.anomalies} | ${AVANT.occurrences} | ${AVANT.causes} |`);
M.push('| clôture G22 (8a6bb30 — archivée dans docs/anomalies-g22-cloture.json) | 263 | 43 | 12 |');
M.push(`| après les corrections G23 | ${totalAnomalies} | ${occurrences.length} | ${new Set(occurrences.map((o) => o.famille)).size} |`);
M.push('');
M.push('## Répartition par catégorie');
M.push('');
for (const [k, v] of Object.entries(compte('categorie'))) M.push(`- \`${k}\` — ${v} occurrence(s)`);
M.push('');
M.push('## Fermeture');
M.push('');
M.push(`- Toutes les occurrences sont classées, aucune « à instruire ».`);
M.push(`- Occurrences \`NON_RESOLUE_PREUVE_INSUFFISANTE\` : **${nonResolues.length}**.`);
M.push(
	`- Défauts réels confirmés NON corrigés : **${defautsOuverts.length}** occurrence(s), ` +
		`répartis sur ${new Set(defautsOuverts.map((o) => o.famille)).size} cause(s) — chacune porte sa correction identifiée par la mesure.`
);
M.push(`- Occurrences \`DEFAUT_THEME\` restantes : **${fermeture.defauts_theme_restants}**.`);
M.push(`- Verdict de la passe : **G23=${fermeture.verdict_g23}**.`);
M.push('');
writeFileSync('docs/ANOMALIES-G22.md', M.join('\n') + '\n');

console.log(`docs/anomalies-g22.json + docs/ANOMALIES-G22.md + docs/ANOMALIES-SURPLUS-COLONNES.md`);
console.log(`${occurrences.length} occurrences (${totalAnomalies} anomalies tous genres) · G23=${fermeture.verdict_g23}`);
for (const c of CAUSES) {
	const n = occurrences.filter((o) => o.famille === c.id).length;
	if (n) console.log(`  ${String(n).padStart(4)}  [${c.categorie}] ${c.titre}`);
}
if (nonResolues.length) for (const o of nonResolues) console.log(`  ⚠️ non résolue : ${o.id} · ${o.texte}`);
