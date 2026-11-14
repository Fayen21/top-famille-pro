<?php
/**
 * Phase 3, lot 4 — les 8 communes secondaires du prototype (Saint-Apollinaire, Chenôve, Quetigny,
 * Talant, Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune).
 *
 * CLAUDE.md §5.4 posait la règle : « Les 8 communes secondaires du prototype n'existent sur aucune
 * source. […] Elles restent en noindex,follow tant qu'Audrey ne les a pas validées une par une. »
 *
 * **VALIDÉES LE 17 AOÛT 2026.** Emmanuel confirme qu'Audrey intervient sur ces huit communes. La
 * condition posée par CLAUDE.md §5.4 est donc remplie : `statut_validation` passe à `true`, et
 * `single-zone.php` calcule de lui-même `index,follow` — le mécanisme n'a pas à être touché, c'est
 * exactement le cas pour lequel il a été écrit. Les huit pages rejoignent du même coup le sitemap
 * (`includes/sitemap-robots.php`, même condition).
 *
 * Saint-Apollinaire n'aurait jamais dû figurer dans cette liste : c'est le SIÈGE de l'entreprise
 * (PROJECT_INPUTS.md §1). Elle s'y trouvait parce que le classement venait du prototype, qui la
 * rangeait avec les autres, et non d'un doute sur la desserte.
 *
 * **TEXTE PASSÉ À L'AFFIRMATIF le 17 août 2026**, à la demande d'Emmanuel. Il était écrit au
 * conditionnel — « la demande peut être étudiée », « pour vérifier si votre adresse peut être
 * desservie » — parce que la desserte n'était pas confirmée. Elle l'est : garder cette prudence
 * reviendrait à faire douter le visiteur d'une couverture réelle, ce qui coûte autant qu'une
 * promesse fausse.
 *
 * Le registre est celui des villes déjà validées (bin/seed-phase3-batch3-villes.php) : « Top-Famille
 * Pro intervient à X pour l'entretien de… », suivi du rappel qu'il n'y a pas d'agence locale. Il
 * n'est pas inventé pour l'occasion, et les huit pages ne se distinguent donc pas des dix villes
 * par leur ton.
 *
 * **Ce qui N'A PAS été ajouté, et ne devait pas l'être** (CLAUDE.md §5.1) : aucune distance, aucun
 * temps de trajet, aucun quartier, aucun délai opérationnel, aucune fréquence locale, aucun
 * effectif. Aucune adresse ni ligne téléphonique locale non plus (§5.2) : ces pages restent des
 * pages de zone desservie, pas des agences, et chacune redit l'implantation unique de
 * Saint-Apollinaire. Le tarif reste celui de la région, identique partout (§5.3). Les types de
 * locaux cités par commune sont tirés du tissu économique déjà décrit dans `secteur_economique`,
 * écrit en phase 3 — ils ne sont pas déduits d'une carte.
 *
 * Saint-Apollinaire est traitée à part : c'est le SIÈGE (PROJECT_INPUTS.md §1), pas une commune
 * desservie de plus, et sa page le dit.
 *
 * Une fois créées, ces communes sont liées depuis la page Dijon (`communes_proches`).
 *
 * Usage : wp eval-file bin/seed-phase3-batch4-communes.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch4-communes.php\n" );
}

if ( ! function_exists( 'tfp_seed_upsert_post' ) ) {
	function tfp_seed_upsert_post( array $args ) {
		$existing = get_posts( array( 'post_type' => $args['post_type'], 'name' => $args['post_name'], 'numberposts' => 1, 'post_status' => 'any' ) );
		if ( ! empty( $existing ) ) {
			$args['ID'] = $existing[0]->ID;
			wp_update_post( $args );
			return $args['ID'];
		}
		return wp_insert_post( $args );
	}
}
if ( ! function_exists( 'tfp_seed_set_field' ) ) {
	function tfp_seed_set_field( $selector, $value, $post_id ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( $selector, $value, $post_id );
		} else {
			update_post_meta( $post_id, $selector, $value );
		}
	}
}
if ( ! function_exists( 'tfp_seed_faq' ) ) {
	function tfp_seed_faq( $prefix, array $faqs, $post_id ) {
		foreach ( $faqs as $i => $item ) {
			tfp_seed_set_field( $prefix . '_' . ( $i + 1 ), array( 'question' => $item['q'], 'reponse' => $item['a'] ), $post_id );
		}
	}
}

$cote_dor_term = term_exists( 'cote-dor', 'departement' );
$cote_dor_term_id = is_array( $cote_dor_term ) ? (int) $cote_dor_term['term_id'] : (int) $cote_dor_term;
$bureaux = get_page_by_path( 'bureaux', OBJECT, 'prestation' );
$bureaux_id = $bureaux ? $bureaux->ID : 0;

// prestations_liees ci-dessous n'est qu'une valeur initiale (seule « bureaux » existe à ce
// stade de l'installation) : bin/seed-phase4-maillage.php la complète avec les 6 prestations
// une fois qu'elles existent toutes (bug réel corrigé au hotfix du 9 août 2026).

$commune_ids = array();

/**
 * Crée une commune desservie.
 *
 * `$locaux` énumère les types de locaux réellement concernés, tirés du tissu économique décrit
 * dans `$economie` : c'est la seule différenciation entre les huit pages, et elle est fondée sur
 * du contenu existant, pas sur une caractérisation nouvelle de la commune. La FAQ reste commune —
 * les trois questions posées (desserte, tarif, devis) appellent la même réponse partout, et en
 * fabriquer huit variantes créerait une spécificité opérationnelle qui n'existe pas.
 *
 * `$est_siege` distingue Saint-Apollinaire : sa page n'annonce pas une commune desservie de plus,
 * elle annonce l'adresse de l'entreprise.
 */
function tfp_seed_commune_secondaire( $id, $name, $cp, $economie, $bureaux_id, $cote_dor_term_id, $locaux = '', $est_siege = false ) {
	$post_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => $name, 'post_name' => $id, 'post_status' => 'publish' ) );
	wp_set_object_terms( $post_id, array( $cote_dor_term_id ), 'departement' );

	tfp_seed_set_field( 'niveau', 'commune', $post_id );
	tfp_seed_set_field( 'code_postal', $cp, $post_id );
	// Validées par Emmanuel le 17 août 2026 — Audrey intervient sur ces huit communes.
	tfp_seed_set_field( 'statut_validation', true, $post_id );
	tfp_seed_set_field( 'h1', "Entreprise de nettoyage à $name", $post_id );
	tfp_seed_set_field( 'cta_label', "Demander un devis à $name", $post_id );
	/*
	 * Réponse directe — affirmative depuis le 17 août 2026. Le siège a sa propre formulation : sa
	 * page n'annonce pas une commune desservie de plus, elle annonce l'adresse de l'entreprise.
	 */
	$reponse = $est_siege
		? "Top-Famille Pro est implantée à Saint-Apollinaire (21850), en Côte-d'Or : c'est ici que se trouve l'entreprise, au 650D route de Gray. Nous y intervenons pour l'entretien de $locaux, en contrat régulier ou en intervention ponctuelle. Votre interlocutrice est Audrey, au 06 36 17 63 39."
		: "Top-Famille Pro intervient à $name pour l'entretien de $locaux, en contrat régulier ou en intervention ponctuelle. Nous n'avons pas d'agence à $name : l'entreprise est implantée à Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39.";
	tfp_seed_set_field( 'reponse_directe', $reponse, $post_id );
	tfp_seed_set_field( 'secteur_economique', $economie, $post_id );
	tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi avec Audrey, à distance ou lors d'une visite selon la situation, et le devis suit sous 24 heures. Il fixe les locaux concernés, le volume d'heures et la fréquence des passages, réguliers ou ponctuels. Les produits et le matériel sont fournis par le client, et le devis précise ce qui est inclus comme ce qui ne l'est pas.", $post_id );
	tfp_seed_set_field( 'exclusions_rappel', true, $post_id );
	tfp_seed_set_field( 'materiel_rappel', true, $post_id );
	if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $post_id ); }
	tfp_seed_faq(
		'faq',
		array(
			array(
				'q' => "Intervenez-vous vraiment à $name ?",
				'a' => $est_siege
					? "Oui. Saint-Apollinaire est la commune où l'entreprise est implantée, au 650D route de Gray. Nous y intervenons comme partout ailleurs en Bourgogne-Franche-Comté, aux mêmes conditions."
					: "Oui, $name fait partie de nos zones d'intervention. Nous n'y avons pas d'agence : notre unique implantation est à Saint-Apollinaire (21850), et c'est de là que les interventions sont organisées.",
			),
			array( 'q' => 'Le tarif est-il différent ici ?', 'a' => "Non. La grille tarifaire est la même partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse exacte et sont précisées dans le devis." ),
			array( 'q' => 'Comment obtenir un devis ?', 'a' => "Par le formulaire de demande de devis ou directement auprès d'Audrey au 06 36 17 63 39. Le devis est gratuit, sans engagement, et une réponse est donnée sous 24 heures." ),
		),
		$post_id
	);
	tfp_seed_set_field( 'seo_title', "Nettoyage professionnel à $name | Top-Famille Pro", $post_id );
	tfp_seed_set_field(
		'seo_description',
		$est_siege
			? "Top-Famille Pro est implantée à Saint-Apollinaire (21850) : nettoyage de bureaux, commerces et locaux professionnels, en régulier ou en ponctuel. Devis gratuit sous 24 h."
			: "Nettoyage professionnel à $name : bureaux, commerces et locaux professionnels, en contrat régulier ou en intervention ponctuelle. Devis gratuit sous 24 h.",
		$post_id
	);

	echo "  Zone $name (commune, validée le 17/08/2026, index) : #$post_id\n";
	return $post_id;
}

echo "=== Seed phase 3, lot 4 : 8 communes desservies (validées le 17/08/2026) ===\n";

$commune_ids['saint-apollinaire'] = tfp_seed_commune_secondaire(
	'saint-apollinaire', 'Saint-Apollinaire', '21850',
	"Saint-Apollinaire, commune limitrophe de Dijon, est le lieu d'implantation réel de Top-Famille Pro (650D route de Gray). La commune accueille des zones d'activité, des commerces et des PME aux portes de la métropole dijonnaise.",
	$bureaux_id, $cote_dor_term_id,
	"bureaux, de locaux de PME, de commerces et de parties communes d'immeubles", true
);

$commune_ids['chenove'] = tfp_seed_commune_secondaire(
	'chenove', 'Chenôve', '21300',
	"Chenôve, commune de l'agglomération dijonnaise au sud de Dijon, associe un tissu résidentiel important, des commerces et des zones d'activité.",
	$bureaux_id, $cote_dor_term_id,
	"parties communes d'immeubles, de commerces et de bureaux"
);

$commune_ids['quetigny'] = tfp_seed_commune_secondaire(
	'quetigny', 'Quetigny', '21800',
	"Quetigny, à l'est de Dijon, est structurée autour d'un pôle commercial et de zones d'activité.",
	$bureaux_id, $cote_dor_term_id,
	"commerces, de bureaux et de locaux d'activité tertiaires"
);

$commune_ids['talant'] = tfp_seed_commune_secondaire(
	'talant', 'Talant', '21240',
	"Talant, commune résidentielle du nord-ouest dijonnais, compte de nombreuses copropriétés et résidences ainsi que des commerces de proximité.",
	$bureaux_id, $cote_dor_term_id,
	"parties communes d'immeubles et de résidences, et de commerces de proximité"
);

$commune_ids['longvic'] = tfp_seed_commune_secondaire(
	'longvic', 'Longvic', '21600',
	"Longvic, au sud de Dijon, accueille des zones d'activité et des entreprises tertiaires et industrielles. Nos interventions concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, sanitaires courants, salles de pause et parties communes — jamais les lignes de production, ateliers ou zones industrielles.",
	$bureaux_id, $cote_dor_term_id,
	"bureaux, d'accueils, d'espaces administratifs et de parties communes"
);

$commune_ids['fontaine-les-dijon'] = tfp_seed_commune_secondaire(
	'fontaine-les-dijon', 'Fontaine-lès-Dijon', '21121',
	"Fontaine-lès-Dijon, commune du nord dijonnais, associe zones résidentielles, commerces et cabinets.",
	$bureaux_id, $cote_dor_term_id,
	"parties communes d'immeubles, de commerces et de cabinets"
);

$commune_ids['marsannay-la-cote'] = tfp_seed_commune_secondaire(
	'marsannay-la-cote', 'Marsannay-la-Côte', '21160',
	"Marsannay-la-Côte, commune viticole au sud de Dijon sur la route des Grands Crus, compte des domaines, des commerces et des cabinets.",
	$bureaux_id, $cote_dor_term_id,
	"commerces, de cabinets et de bureaux de domaines"
);

$commune_ids['beaune'] = tfp_seed_commune_secondaire(
	'beaune', 'Beaune', '21200',
	"Beaune associe un tourisme d'affaires (hôtellerie, hébergements), un centre historique commerçant, des domaines viticoles et des cabinets.",
	$bureaux_id, $cote_dor_term_id,
	"locations meublées et hébergements, de commerces, de cabinets et de bureaux de domaines"
);

/* Maillage : la page Dijon (validée) lie ces 8 communes proches, avec les libellés déjà en place. */
$dijon = get_page_by_path( 'dijon', OBJECT, 'zone' );
if ( $dijon ) {
	tfp_seed_set_field( 'communes_proches', array_values( $commune_ids ), $dijon->ID );
	echo "  Liées depuis la page Dijon (#$dijon->ID) : communes_proches\n";
}

echo "=== Lot 4 terminé ===\n";
