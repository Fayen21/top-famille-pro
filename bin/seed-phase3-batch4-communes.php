<?php
/**
 * Phase 3, lot 4 — les 8 communes secondaires du prototype (Saint-Apollinaire, Chenôve, Quetigny,
 * Talant, Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune).
 *
 * CLAUDE.md §5.4 est explicite : « Les 8 communes secondaires du prototype n'existent sur aucune
 * source. […] Elles restent en noindex,follow tant qu'Audrey ne les a pas validées une par une. »
 * PROJECT_INPUTS.md §12 question ouverte #8 confirme que cette validation n'a pas encore eu lieu.
 *
 * Ces 8 pages sont donc créées avec `statut_validation` non coché → `single-zone.php` calcule déjà
 * `noindex,follow` automatiquement pour tout niveau=commune non validé (mécanisme posé et testé en
 * phase 2). Elles sont conservées (pas supprimées) conformément à la consigne de la phase 3 : une
 * zone qui ne peut pas être confirmée comme desservie garde sa page, mais passe en noindex.
 *
 * **Contenu très largement réécrit, pas simplement neutralisé.** Le prototype affirme
 * positivement, sur les 8 communes, une couverture confirmée (« Oui, nous intervenons… », FAQ
 * répondant « Oui » à « intervenez-vous vraiment ici ? ») avec des exemples de besoin fictifs
 * (`scenarioDemo: true`) et un tarif fictif « 27 € HT/h ». Rien de tout cela n'est repris : le
 * texte adopte une formulation honnête (« la demande peut être étudiée », jamais « nous
 * intervenons ») cohérente avec le fait que ces communes ne sont pas confirmées. Saint-Apollinaire
 * est un cas particulier : c'est la commune du siège social réel (PROJECT_INPUTS.md §1), ce fait
 * est donc affirmé tel quel — mais la page reste noindex comme les 7 autres, par cohérence de
 * traitement en attendant la validation explicite d'Audrey sur l'ensemble des 8.
 *
 * Une fois créées, ces communes sont liées depuis la page Dijon (`communes_proches`) : Dijon est
 * validée, le maillage vers des pages noindex,follow depuis une page indexée est normal (noindex
 * empêche l'indexation de la page cible, pas le suivi du lien).
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

$commune_ids = array();

/**
 * Crée une commune secondaire non validée avec un contenu commun honnête (FAQ générique
 * identique sur les 8, la seule variable étant le nom réel de la commune et son adresse) plutôt
 * que de réécrire une FAQ « au cas par cas » unique pour chacune : sur 8 pages noindex qui
 * n'affirment volontairement aucune spécificité opérationnelle, une FAQ générique honnête est
 * plus sûre qu'une FAQ artificiellement différenciée qui recréerait l'illusion d'une couverture
 * confirmée propre à chaque commune.
 */
function tfp_seed_commune_secondaire( $id, $name, $cp, $economie, $bureaux_id, $cote_dor_term_id ) {
	$post_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => $name, 'post_name' => $id, 'post_status' => 'publish' ) );
	wp_set_object_terms( $post_id, array( $cote_dor_term_id ), 'departement' );

	tfp_seed_set_field( 'niveau', 'commune', $post_id );
	tfp_seed_set_field( 'code_postal', $cp, $post_id );
	tfp_seed_set_field( 'statut_validation', false, $post_id );
	tfp_seed_set_field( 'h1', "Entreprise de nettoyage à $name", $post_id );
	tfp_seed_set_field( 'cta_label', "Demander un devis à $name", $post_id );
	tfp_seed_set_field(
		'reponse_directe',
		"Top-Famille Pro est une entreprise de nettoyage professionnel basée à Saint-Apollinaire (21850), en Côte-d'Or. $name fait partie des communes pour lesquelles une demande peut être étudiée : contactez Audrey au 06 36 17 63 39 pour vérifier si votre adresse peut être desservie et selon quelles conditions.",
		$post_id
	);
	tfp_seed_set_field( 'secteur_economique', $economie, $post_id );
	tfp_seed_set_field( 'fonctionnement', "Toute demande fait l'objet d'un échange préalable avec Audrey pour vérifier l'adresse, le volume d'heures envisagé et la faisabilité d'un passage régulier ou ponctuel, avant l'établissement d'un devis gratuit sous 24 heures.", $post_id );
	tfp_seed_set_field( 'exclusions_rappel', true, $post_id );
	tfp_seed_set_field( 'materiel_rappel', true, $post_id );
	if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $post_id ); }
	tfp_seed_faq(
		'faq',
		array(
			array( 'q' => "Intervenez-vous vraiment à $name ?", 'a' => "Notre unique implantation est à Saint-Apollinaire (21850). Une demande depuis $name peut être étudiée au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning : contactez-nous pour vérifier votre situation." ),
			array( 'q' => 'Le tarif est-il différent ici ?', 'a' => "Non. La grille tarifaire est la même partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse exacte et sont précisées dans le devis." ),
			array( 'q' => 'Comment obtenir un devis ?', 'a' => "Par le formulaire de demande de devis ou directement auprès d'Audrey au 06 36 17 63 39. Le devis est gratuit, sans engagement, et une réponse est donnée sous 24 heures." ),
		),
		$post_id
	);
	tfp_seed_set_field( 'seo_title', "Nettoyage professionnel à $name | Top-Famille Pro", $post_id );
	tfp_seed_set_field( 'seo_description', "$name : demande de nettoyage professionnel étudiée au cas par cas depuis notre siège de Saint-Apollinaire. Devis gratuit sous 24 h.", $post_id );

	echo "  Zone $name (commune, non validée, noindex) : #$post_id\n";
	return $post_id;
}

echo "=== Seed phase 3, lot 4 : 8 communes secondaires (noindex,follow) ===\n";

$commune_ids['saint-apollinaire'] = tfp_seed_commune_secondaire(
	'saint-apollinaire', 'Saint-Apollinaire', '21850',
	"Saint-Apollinaire, commune limitrophe de Dijon, est le lieu d'implantation réel de Top-Famille Pro (650D route de Gray). La commune accueille des zones d'activité, des commerces et des PME aux portes de la métropole dijonnaise.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['chenove'] = tfp_seed_commune_secondaire(
	'chenove', 'Chenôve', '21300',
	"Chenôve, commune de l'agglomération dijonnaise au sud de Dijon, associe un tissu résidentiel important, des commerces et des zones d'activité.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['quetigny'] = tfp_seed_commune_secondaire(
	'quetigny', 'Quetigny', '21800',
	"Quetigny, à l'est de Dijon, est structurée autour d'un pôle commercial et de zones d'activité.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['talant'] = tfp_seed_commune_secondaire(
	'talant', 'Talant', '21240',
	"Talant, commune résidentielle du nord-ouest dijonnais, compte de nombreuses copropriétés et résidences ainsi que des commerces de proximité.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['longvic'] = tfp_seed_commune_secondaire(
	'longvic', 'Longvic', '21600',
	"Longvic, au sud de Dijon, accueille des zones d'activité et des entreprises tertiaires et industrielles. Nos interventions concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, sanitaires courants, salles de pause et parties communes — jamais les lignes de production, ateliers ou zones industrielles.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['fontaine-les-dijon'] = tfp_seed_commune_secondaire(
	'fontaine-les-dijon', 'Fontaine-lès-Dijon', '21121',
	"Fontaine-lès-Dijon, commune du nord dijonnais, associe zones résidentielles, commerces et cabinets.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['marsannay-la-cote'] = tfp_seed_commune_secondaire(
	'marsannay-la-cote', 'Marsannay-la-Côte', '21160',
	"Marsannay-la-Côte, commune viticole au sud de Dijon sur la route des Grands Crus, compte des domaines, des commerces et des cabinets.",
	$bureaux_id, $cote_dor_term_id
);

$commune_ids['beaune'] = tfp_seed_commune_secondaire(
	'beaune', 'Beaune', '21200',
	"Beaune associe un tourisme d'affaires (hôtellerie, hébergements), un centre historique commerçant, des domaines viticoles et des cabinets.",
	$bureaux_id, $cote_dor_term_id
);

/* Maillage : la page Dijon (validée) lie ces 8 communes proches, avec les libellés déjà en place. */
$dijon = get_page_by_path( 'dijon', OBJECT, 'zone' );
if ( $dijon ) {
	tfp_seed_set_field( 'communes_proches', array_values( $commune_ids ), $dijon->ID );
	echo "  Liées depuis la page Dijon (#$dijon->ID) : communes_proches\n";
}

echo "=== Lot 4 terminé ===\n";
