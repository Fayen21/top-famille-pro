<?php
/**
 * Phase 3, lot 3 — les 9 zones ville restantes (Besançon, Dole, Lons-le-Saunier, Nevers, Vesoul,
 * Chalon-sur-Saône, Mâcon, Auxerre, Belfort). Dijon a été créée en phase 2.
 *
 * Contenu repris du prototype, corrigé selon CLAUDE.md §5.1/§9 :
 * - tarif fictif « 27 € HT/h » retiré (grille réelle affichée par la section tarifs du gabarit) ;
 * - aucun exemple de budget chiffré sur le tarif fictif (même précédent que Côte-d'Or/Dijon en
 *   phase 2 : pas de « 279 € HT/mois » recalculé, pour éviter un contenu quasi dupliqué) ;
 * - **régression trouvée dans le prototype** : chaque ville y affirme positivement desservir des
 *   communes satellites non validées (« Intervenez-vous à [commune] ? Oui, ces communes sont
 *   proches… »). C'est plus grave que la simple mention en zones_desservies déjà corrigée en
 *   phase 2 : c'est une réponse affirmative à une question directe. Corrigé sur les 9 villes par
 *   une réponse honnête au cas par cas, sans nommer ni confirmer de commune précise
 *   (CLAUDE.md §5.4 — aucune des communes satellites n'est validée par Audrey).
 * - titres de Lons-le-Saunier et Chalon-sur-Saône raccourcis à ≤65 caractères (docs/INVENTAIRE-ROUTES.md
 *   les signalait à 67c et 68c dans le prototype).
 * - `secteur_economique` reprend le texte « economy » du prototype tel quel : c'est une
 *   caractérisation générale et déjà publique de l'économie de chaque ville (préfecture,
 *   administrations, filière viticole…), pas une donnée opérationnelle inventée, et il inclut
 *   déjà l'avertissement honnête sur les exclusions (jamais les lignes de production, zones
 *   chimiques, ateliers à risque, zones hospitalières, machines, déchets dangereux).
 *
 * Usage : wp eval-file bin/seed-phase3-batch3-villes.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch3-villes.php\n" );
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
if ( ! function_exists( 'tfp_seed_get_dept_term' ) ) {
	function tfp_seed_get_dept_term( $slug, $name ) {
		$term = term_exists( $slug, 'departement' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'departement', array( 'slug' => $slug ) );
		}
		return is_array( $term ) ? (int) $term['term_id'] : (int) $term;
	}
}

$bureaux = get_page_by_path( 'bureaux', OBJECT, 'prestation' );
$bureaux_id = $bureaux ? $bureaux->ID : 0;

echo "=== Seed phase 3, lot 3 : 9 zones ville restantes ===\n";

/* ------------------------------------------------------------------ */
/* 1. Besançon (Doubs)                                                 */
/* ------------------------------------------------------------------ */

$doubs_term = tfp_seed_get_dept_term( 'doubs', 'Doubs' );
$besancon_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Besançon', 'post_name' => 'besancon', 'post_status' => 'publish' ) );
wp_set_object_terms( $besancon_id, array( $doubs_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $besancon_id );
tfp_seed_set_field( 'code_postal', '25000', $besancon_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Besançon', $besancon_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Besançon', $besancon_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Besançon et dans son agglomération pour l'entretien de bureaux, de cabinets médicaux et paramédicaux courants, de commerces et de parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. Nous n'avons pas d'agence bisontine : l'entreprise est implantée à Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39.", $besancon_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture du Doubs, Besançon s'appuie sur l'industrie, la santé et l'enseignement supérieur. Les secteurs tertiaires et les cabinets du centre génèrent des besoins variés. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $besancon_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux et cabinets médicaux ou paramédicaux courants', 'Commerces du centre historique et immeubles anciens', "Parties communes d'immeubles et de résidences", 'Locations meublées et logements étudiants' ) ), $besancon_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. Nous adaptons les produits aux revêtements des immeubles anciens du centre et le matériel à l'absence d'accès véhicule lorsque c'est le cas. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, une solution de remplacement est recherchée, sans garantie de continuité absolue. Nous recommandons un volume d'au moins deux heures par passage, ou un regroupement hebdomadaire.", $besancon_id );
tfp_seed_set_field( 'exclusions_rappel', true, $besancon_id );
tfp_seed_set_field( 'materiel_rappel', true, $besancon_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $besancon_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence ou un responsable à Besançon ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n'y a ni agence bisontine, ni responsable local, ni numéro de téléphone spécifique à la ville." ),
	array( 'q' => 'Les frais de déplacement s\'appliquent-ils ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont précisées dans le devis." ),
	array( 'q' => 'Faites-vous du bio-nettoyage hospitalier ?', 'a' => "Non. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Les blocs, salles de soins et laboratoires relèvent d'entreprises spécialisées." ),
	array( 'q' => 'Pouvez-vous intervenir dans un immeuble ancien du centre ?', 'a' => "Oui. Nous adaptons les produits aux revêtements anciens et le matériel à l'absence d'accès véhicule, ce qui est pris en compte dès l'établissement du devis." ),
	array( 'q' => 'Quel volume minimum conseillez-vous à Besançon ?', 'a' => "Au moins deux heures par passage, ou un regroupement hebdomadaire, pour que l'organisation reste tenable dans la durée." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Besançon ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Quel délai pour mettre en place un contrat ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $besancon_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Besançon (25000) | Top-Famille Pro', $besancon_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Besançon : bureaux, cabinets, commerces, parties communes. Devis gratuit sous 24 h, intervenant habituel recherché.", $besancon_id );

echo "  Zone Besançon (ville) : #$besancon_id\n";

/* ------------------------------------------------------------------ */
/* 2. Dole (Jura)                                                      */
/* ------------------------------------------------------------------ */

$jura_term = tfp_seed_get_dept_term( 'jura', 'Jura' );
$dole_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Dole', 'post_name' => 'dole', 'post_status' => 'publish' ) );
wp_set_object_terms( $dole_id, array( $jura_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $dole_id );
tfp_seed_set_field( 'code_postal', '39100', $dole_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Dole', $dole_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Dole', $dole_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Dole pour l'entretien de commerces, de bureaux, de cabinets courants, de parties communes d'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle. Dole fait partie de nos secteurs prioritaires dans le Jura. Devis gratuit sous 24 heures au 06 36 17 63 39.", $dole_id );
tfp_seed_set_field( 'secteur_economique', "Dole associe un centre historique commerçant, un tissu de professions libérales et des activités industrielles à proximité. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $dole_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Commerces du centre historique', 'Bureaux de PME et cabinets courants', "Parties communes d'immeubles et de résidences", 'Locations meublées' ) ), $dole_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. Pour les commerces, un passage entre 6 h et 8 h 30 avant l'ouverture peut être envisagé, avec un renfort possible les jours de forte affluence. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, une solution de remplacement est recherchée, sans garantie de continuité absolue.", $dole_id );
tfp_seed_set_field( 'exclusions_rappel', true, $dole_id );
tfp_seed_set_field( 'materiel_rappel', true, $dole_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $dole_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => "Pouvez-vous passer avant l'ouverture de ma boutique ?", 'a' => "Oui, c'est un créneau pouvant être envisagé : passage entre 6 h et 8 h 30, du mardi au samedi selon vos jours d'ouverture, avec un renfort possible les jours de forte affluence." ),
	array( 'q' => 'Avez-vous une agence à Dole ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Le numéro affiché est le même partout : 06 36 17 63 39." ),
	array( 'q' => 'Les frais de déplacement sont-ils importants pour Dole ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont précisées dans le devis." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Dole ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Entretenez-vous les sites industriels du secteur ?', 'a' => "Uniquement leurs espaces tertiaires : bureaux, accueil, salles de réunion, vestiaires de bureau et sanitaires. Le nettoyage industriel lourd n'en fait pas partie." ),
	array( 'q' => 'Faut-il un engagement de durée ?', 'a' => "Le devis est gratuit et sans engagement. Le volume d'heures et la fréquence peuvent être ajustés en cours de route, et les conditions d'arrêt (préavis écrit) sont précisées au devis avant signature." ),
), $dole_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Dole (39100) | Top-Famille Pro', $dole_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Dole : commerces, bureaux, cabinets, parties communes, locations meublées. Devis gratuit sous 24 h.", $dole_id );

echo "  Zone Dole (ville) : #$dole_id\n";

/* ------------------------------------------------------------------ */
/* 3. Lons-le-Saunier (Jura)                                           */
/* ------------------------------------------------------------------ */

$lons_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Lons-le-Saunier', 'post_name' => 'lons-le-saunier', 'post_status' => 'publish' ) );
wp_set_object_terms( $lons_id, array( $jura_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $lons_id );
tfp_seed_set_field( 'code_postal', '39000', $lons_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Lons-le-Saunier', $lons_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Lons-le-Saunier', $lons_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Lons-le-Saunier pour l'entretien de bureaux, de cabinets courants, de commerces de centre-ville, de parties communes d'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon ; votre interlocutrice est Audrey, au 06 36 17 63 39.", $lons_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture du Jura, Lons-le-Saunier concentre administrations, agroalimentaire et thermalisme, avec un centre-ville commerçant et de nombreux cabinets. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $lons_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux administratifs et cabinets courants', 'Commerces de centre-ville', "Parties communes d'immeubles", 'Locations meublées' ) ), $lons_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, la fréquence étant définie après échange sur la fréquentation, le type de sols et la nature de l'activité. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, une solution de remplacement est recherchée, sans garantie de continuité absolue.", $lons_id );
tfp_seed_set_field( 'exclusions_rappel', true, $lons_id );
tfp_seed_set_field( 'materiel_rappel', true, $lons_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $lons_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence à Lons-le-Saunier ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n'y a ni agence, ni responsable local, ni numéro spécifique à la ville : c'est le 06 36 17 63 39 partout." ),
	array( 'q' => 'Les frais de déplacement sont-ils élevés ici ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont calculées et affichées au devis avant signature." ),
	array( 'q' => 'Un seul passage hebdomadaire est-il suffisant ?', 'a' => "Pour un cabinet ou un petit bureau, souvent oui. Nous définissons la fréquence après échange sur la fréquentation, le type de sols et la nature de l'activité." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Lons-le-Saunier ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Entretenez-vous les sites agroalimentaires du secteur ?', 'a' => "Uniquement leurs bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Le nettoyage agroalimentaire spécialisé n'en fait pas partie." ),
	array( 'q' => 'Quel délai pour démarrer un contrat régulier ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $lons_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage à Lons-le-Saunier (39000) | Top-Famille Pro', $lons_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Lons-le-Saunier : bureaux, cabinets, commerces, copropriétés. Devis gratuit sous 24 h.", $lons_id );

echo "  Zone Lons-le-Saunier (ville) : #$lons_id\n";

/* ------------------------------------------------------------------ */
/* 4. Nevers (Nièvre)                                                  */
/* ------------------------------------------------------------------ */

$nievre_term = tfp_seed_get_dept_term( 'nievre', 'Nièvre' );
$nevers_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Nevers', 'post_name' => 'nevers', 'post_status' => 'publish' ) );
wp_set_object_terms( $nevers_id, array( $nievre_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $nevers_id );
tfp_seed_set_field( 'code_postal', '58000', $nevers_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Nevers', $nevers_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Nevers', $nevers_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Nevers pour l'entretien de parties communes d'immeubles, de bureaux administratifs, de commerces de centre-ville, de cabinets courants et de locations meublées, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.", $nevers_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture de la Nièvre, Nevers réunit administrations, commerces de centre-ville et petites industries. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $nevers_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( "Parties communes d'immeubles et de résidences", 'Bureaux administratifs', 'Commerces de centre-ville', 'Cabinets courants et locations meublées' ) ), $nevers_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. C'est un secteur éloigné de notre implantation : nous y travaillons sur la base de créneaux réguliers planifiés à l'avance, plutôt qu'en urgence, et nous le disons clairement avant tout engagement. Chaque site dispose d'un cahier de liaison où l'intervenant note le travail réalisé, complété par un point de suivi avec Audrey.", $nevers_id );
tfp_seed_set_field( 'exclusions_rappel', true, $nevers_id );
tfp_seed_set_field( 'materiel_rappel', true, $nevers_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $nevers_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => "Intervenez-vous vraiment à Nevers depuis la Côte-d'Or ?", 'a' => "Oui, sur la base de créneaux réguliers planifiés à l'avance. C'est un secteur éloigné : nous y travaillons en régularité, pas en urgence, et nous le disons clairement avant tout engagement." ),
	array( 'q' => 'Le tarif est-il majoré à Nevers ?', 'a' => "Non, la grille tarifaire est identique partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis." ),
	array( 'q' => 'Travaillez-vous avec les syndics de copropriété ?', 'a' => "Oui, c'est une prestation fréquemment étudiée ici : halls, cages d'escalier, ascenseurs, locaux à conteneurs et gestion des bacs selon le calendrier de collecte." ),
	array( 'q' => 'Pouvez-vous intervenir en urgence ?', 'a' => "Rarement sur ce secteur, et nous préférons le dire plutôt que de promettre. Pour une intervention ponctuelle, nous confirmons une date réaliste au devis, en fonction de nos tournées." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Nevers ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Comment savoir ce qui a été fait pendant le passage ?', 'a' => "Chaque site dispose d'un cahier de liaison où l'intervenant note le travail réalisé et les points à signaler. Un point de suivi avec Audrey complète ce suivi." ),
), $nevers_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Nevers (58000) | Top-Famille Pro', $nevers_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Nevers : parties communes, bureaux, commerces, cabinets. Devis gratuit sous 24 h.", $nevers_id );

echo "  Zone Nevers (ville) : #$nevers_id\n";

/* ------------------------------------------------------------------ */
/* 5. Vesoul (Haute-Saône)                                             */
/* ------------------------------------------------------------------ */

$hs_term = tfp_seed_get_dept_term( 'haute-saone', 'Haute-Saône' );
$vesoul_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Vesoul', 'post_name' => 'vesoul', 'post_status' => 'publish' ) );
wp_set_object_terms( $vesoul_id, array( $hs_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $vesoul_id );
tfp_seed_set_field( 'code_postal', '70000', $vesoul_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Vesoul', $vesoul_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Vesoul', $vesoul_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Vesoul pour l'entretien de bureaux administratifs, de commerces, de cabinets courants et de parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39. Devis gratuit sous 24 heures.", $vesoul_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture de la Haute-Saône, Vesoul s'appuie sur un important pôle logistique et industriel, complété par les administrations et commerces du centre-ville. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $vesoul_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux administratifs', 'Bureaux rattachés aux zones logistiques', 'Commerces de centre-ville', "Parties communes d'immeubles" ) ), $vesoul_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. Un passage en soirée ou tôt le matin peut être envisagé, avec badge ou clé remis contre décharge écrite et procédure de fermeture consignée. Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %.", $vesoul_id );
tfp_seed_set_field( 'exclusions_rappel', true, $vesoul_id );
tfp_seed_set_field( 'materiel_rappel', true, $vesoul_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $vesoul_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => "Pouvez-vous intervenir en dehors des horaires d'ouverture ?", 'a' => "Oui, c'est un créneau pouvant être envisagé : passage en soirée ou tôt le matin, avec badge ou clé remis contre décharge écrite et procédure de fermeture consignée." ),
	array( 'q' => 'Avez-vous une agence en Haute-Saône ?', 'a' => "Non. L'entreprise est domiciliée à Saint-Apollinaire, en Côte-d'Or : c'est sa seule adresse, et le 06 36 17 63 39 est le seul numéro, quel que soit votre département." ),
	array( 'q' => 'Entretenez-vous les entrepôts logistiques ?', 'a' => "Non. Nous intervenons dans leurs bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les zones d'exploitation et les machines n'en font pas partie." ),
	array( 'q' => 'Des indemnités kilométriques peuvent-elles s\'ajouter en Haute-Saône ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse exacte, du planning et des conditions d'intervention. Elles sont calculées et précisées dans le devis avant toute validation." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Vesoul ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Les interventions de nuit sont-elles majorées ?', 'a' => "Oui, de 10 %, comme le dimanche et les jours fériés." ),
), $vesoul_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Vesoul (70000) | Top-Famille Pro', $vesoul_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Vesoul : bureaux administratifs, commerces, cabinets, parties communes. Devis gratuit sous 24 h.", $vesoul_id );

echo "  Zone Vesoul (ville) : #$vesoul_id\n";

/* ------------------------------------------------------------------ */
/* 6. Chalon-sur-Saône (Saône-et-Loire)                                */
/* ------------------------------------------------------------------ */

$sl_term = tfp_seed_get_dept_term( 'saone-et-loire', 'Saône-et-Loire' );
$chalon_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Chalon-sur-Saône', 'post_name' => 'chalon-sur-saone', 'post_status' => 'publish' ) );
wp_set_object_terms( $chalon_id, array( $sl_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $chalon_id );
tfp_seed_set_field( 'code_postal', '71100', $chalon_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Chalon-sur-Saône', $chalon_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Chalon-sur-Saône', $chalon_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Chalon-sur-Saône pour l'entretien de bureaux, de commerces, de cabinets courants, de parties communes d'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.", $chalon_id );
tfp_seed_set_field( 'secteur_economique', "Chalon-sur-Saône associe un centre-ville commerçant, un port fluvial actif et un tissu industriel et agroalimentaire réparti dans les zones d'activité de l'agglomération. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $chalon_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux et locaux tertiaires', 'Commerces de centre-ville', 'Cabinets courants', "Parties communes et locations meublées" ) ), $chalon_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. Un passage supplémentaire les jours de marché reste possible pour les commerces, chiffré séparément sans modifier le contrat régulier en place. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, une solution de remplacement est recherchée.", $chalon_id );
tfp_seed_set_field( 'exclusions_rappel', true, $chalon_id );
tfp_seed_set_field( 'materiel_rappel', true, $chalon_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $chalon_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence à Chalon-sur-Saône ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Le numéro est le même pour tous nos clients : 06 36 17 63 39." ),
	array( 'q' => "Intervenez-vous dans les zones d'activité au nord de la ville ?", 'a' => "Oui, pour les espaces tertiaires : bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les ateliers et zones d'exploitation n'en font pas partie." ),
	array( 'q' => 'Un passage supplémentaire les jours de marché est-il possible ?', 'a' => "Oui, pour les commerces. Il est chiffré séparément au tarif horaire en vigueur, sans modifier le contrat régulier en place." ),
	array( 'q' => 'Les frais de déplacement sont-ils élevés ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont précisées dans le devis." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Chalon-sur-Saône ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Quel délai pour démarrer ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $chalon_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage à Chalon-sur-Saône (71100) | Top-Famille Pro', $chalon_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Chalon-sur-Saône : bureaux, commerces, cabinets, copropriétés. Devis gratuit sous 24 h.", $chalon_id );

echo "  Zone Chalon-sur-Saône (ville) : #$chalon_id\n";

/* ------------------------------------------------------------------ */
/* 7. Mâcon (Saône-et-Loire)                                           */
/* ------------------------------------------------------------------ */

$macon_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Mâcon', 'post_name' => 'macon', 'post_status' => 'publish' ) );
wp_set_object_terms( $macon_id, array( $sl_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $macon_id );
tfp_seed_set_field( 'code_postal', '71000', $macon_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Mâcon', $macon_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Mâcon', $macon_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Mâcon pour l'entretien de bureaux, de cabinets courants, de commerces, de parties communes d'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon ; votre interlocutrice est Audrey, au 06 36 17 63 39.", $macon_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture de Saône-et-Loire, Mâcon bénéficie de sa position sur l'A6 et de la renommée des vins du Mâconnais, avec un tissu de commerces, de logistique et de professions libérales. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $macon_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux et cabinets courants', 'Commerces de centre-ville', "Espaces d'accueil et de dégustation viticole", 'Locations meublées de courte durée' ) ), $macon_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. Les espaces de dégustation et d'accueil des domaines viticoles sont traités comme des espaces recevant du public (sols, comptoir, vitrages, sanitaires), jamais les zones d'élaboration ou de conditionnement. Nous recommandons un volume d'au moins deux heures par passage, ou un regroupement hebdomadaire.", $macon_id );
tfp_seed_set_field( 'exclusions_rappel', true, $macon_id );
tfp_seed_set_field( 'materiel_rappel', true, $macon_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $macon_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence à Mâcon ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n'y a ni agence mâconnaise, ni responsable local, ni numéro spécifique à la ville." ),
	array( 'q' => 'Les frais de déplacement s\'appliquent-ils ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles figurent au devis, en ligne distincte." ),
	array( 'q' => 'Entretenez-vous les caveaux et espaces de dégustation ?', 'a' => "Oui, en tant qu'espaces recevant du public : sols, comptoir, vitrages intérieurs, sanitaires. Les caves d'élaboration et les zones de conditionnement, non." ),
	array( 'q' => 'Pouvez-vous entretenir une location meublée entre deux séjours ?', 'a' => "Oui : ménage complet ; le changement de linge fourni, la vérification des consommables et le signalement des anomalies sont possibles lorsque prévus au cahier des charges et chiffrés dans le devis." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Mâcon ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
	array( 'q' => 'Quel volume minimum conseillez-vous ?', 'a' => "Au moins deux heures par passage, ou un regroupement hebdomadaire, pour que l'organisation reste tenable dans la durée." ),
), $macon_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Mâcon (71000) | Top-Famille Pro', $macon_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Mâcon : bureaux, commerces, cabinets, locations meublées. Devis gratuit sous 24 h.", $macon_id );

echo "  Zone Mâcon (ville) : #$macon_id\n";

/* ------------------------------------------------------------------ */
/* 8. Auxerre (Yonne)                                                  */
/* ------------------------------------------------------------------ */

$yonne_term = tfp_seed_get_dept_term( 'yonne', 'Yonne' );
$auxerre_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Auxerre', 'post_name' => 'auxerre', 'post_status' => 'publish' ) );
wp_set_object_terms( $auxerre_id, array( $yonne_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $auxerre_id );
tfp_seed_set_field( 'code_postal', '89000', $auxerre_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Auxerre', $auxerre_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Auxerre', $auxerre_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Auxerre pour l'entretien de bureaux de PME, de locaux administratifs, de commerces de centre-ville, de cabinets courants et de parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.", $auxerre_id );
tfp_seed_set_field( 'secteur_economique', "Préfecture de l'Yonne, Auxerre profite de l'axe A6 et de la proximité du vignoble de Chablis, avec un tissu de PME, de logistique, d'agroalimentaire et de commerces. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $auxerre_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux de PME et locaux administratifs', 'Commerces de centre-ville', 'Cabinets courants', "Parties communes d'immeubles" ) ), $auxerre_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. L'accès (clé ou badge) est le plus souvent remis contre décharge écrite, pour une intervention sans présence du client. Sens, Joigny et Avallon sortent de nos tournées actuelles : nous préférons le dire plutôt que de le découvrir en cours de contrat.", $auxerre_id );
tfp_seed_set_field( 'exclusions_rappel', true, $auxerre_id );
tfp_seed_set_field( 'materiel_rappel', true, $auxerre_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $auxerre_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence à Auxerre ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n'y a ni agence auxerroise, ni responsable local, ni numéro spécifique au département." ),
	array( 'q' => 'Intervenez-vous à Sens, Joigny ou Avallon ?', 'a' => "Non, pas régulièrement. Ces villes sortent de nos tournées : nous ne pourrions pas y tenir un créneau fixe semaine après semaine, et nous préférons le dire plutôt que de le découvrir en cours de contrat." ),
	array( 'q' => 'Les frais de déplacement sont-ils appliqués ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont précisées dans le devis." ),
	array( 'q' => "Entretenez-vous les entrepôts de l'axe autoroutier ?", 'a' => "Nous n'entrons pas dans les zones de stockage et de préparation. Notre intervention se limite au bloc administratif : bureaux, accueil, salle de réunion, vestiaires de bureau et sanitaires." ),
	array( 'q' => 'Pouvez-vous intervenir sans que nous soyons présents ?', 'a' => "Oui, c'est le cas le plus fréquent. La clé ou le badge est remis contre décharge écrite, avec le code d'alarme et la procédure de fermeture consignés par écrit." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines d\'Auxerre ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
), $auxerre_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Auxerre (89000) | Top-Famille Pro', $auxerre_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Auxerre : bureaux de PME, commerces, cabinets, parties communes. Devis gratuit sous 24 h.", $auxerre_id );

echo "  Zone Auxerre (ville) : #$auxerre_id\n";

/* ------------------------------------------------------------------ */
/* 9. Belfort (Territoire de Belfort)                                  */
/* ------------------------------------------------------------------ */

$belfort_dept_term = tfp_seed_get_dept_term( 'territoire-de-belfort', 'Territoire de Belfort' );
$belfort_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Belfort', 'post_name' => 'belfort', 'post_status' => 'publish' ) );
wp_set_object_terms( $belfort_id, array( $belfort_dept_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $belfort_id );
tfp_seed_set_field( 'code_postal', '90000', $belfort_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Belfort', $belfort_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Belfort', $belfort_id );
tfp_seed_set_field( 'reponse_directe', "Top-Famille Pro intervient à Belfort pour l'entretien de bureaux d'études et d'ingénierie, de locaux tertiaires, de commerces de centre-ville, de cabinets courants et de parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. L'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.", $belfort_id );
tfp_seed_set_field( 'secteur_economique', "Chef-lieu du Territoire de Belfort, Belfort s'appuie sur une industrie de pointe, un pôle industriel et un pôle universitaire, avec des besoins tertiaires et industriels soutenus. Nos interventions y concernent uniquement les espaces compatibles avec notre offre — bureaux, accueils, espaces administratifs, commerces, sanitaires courants, salles de pause et parties communes — et jamais les lignes de production, les zones chimiques, les ateliers à risque, les zones hospitalières, les machines ou les déchets dangereux.", $belfort_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( "Bureaux d'études et d'ingénierie", 'Locaux tertiaires et administratifs', 'Commerces de centre-ville', 'Cabinets courants et parties communes' ) ), $belfort_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, avec un devis sous 24 heures. C'est un secteur éloigné de notre implantation : nous y travaillons sur la base de créneaux réguliers planifiés à l'avance, dont le regroupement est étudié selon le planning, plutôt qu'en urgence. Un passage après le départ des équipes peut être envisagé, avec badge remis contre décharge écrite et procédure de fermeture rappelée par écrit.", $belfort_id );
tfp_seed_set_field( 'exclusions_rappel', true, $belfort_id );
tfp_seed_set_field( 'materiel_rappel', true, $belfort_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $belfort_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Belfort est loin de Dijon : intervenez-vous vraiment ici ?', 'a' => "Oui, sur la base de créneaux réguliers planifiés à l'avance, dont le regroupement est étudié selon le planning. C'est un secteur éloigné : nous y travaillons en régularité, pas en urgence." ),
	array( 'q' => 'Avez-vous une agence à Belfort ?', 'a' => "Non, aucune. L'entreprise est domiciliée à Saint-Apollinaire (21850) et n'a ni bureau, ni dépôt, ni représentant dans le Territoire de Belfort." ),
	array( 'q' => 'Intervenez-vous à l\'intérieur d\'un site de production ?', 'a' => "Seulement dans ses locaux administratifs, dont l'accès et le cheminement sont décrits au cahier des charges. Ateliers, halls de montage, zones d'essai et locaux techniques sont exclus." ),
	array( 'q' => 'Pouvez-vous passer après le départ des équipes ?', 'a' => "Oui, c'est un créneau pouvant être envisagé : badge remis contre décharge écrite, code d'alarme consigné, procédure de fermeture rappelée par écrit et interlocuteur identifié en cas d'anomalie." ),
	array( 'q' => 'Les frais de déplacement sont-ils élevés ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont chiffrées au devis, en ligne distincte." ),
	array( 'q' => 'Intervenez-vous dans les communes voisines de Belfort ?', 'a' => "Les demandes situées dans une commune proche peuvent être étudiées au cas par cas, selon l'adresse exacte, le volume horaire et les possibilités d'organisation du planning." ),
), $belfort_id );
tfp_seed_set_field( 'seo_title', 'Entreprise de nettoyage à Belfort (90000) | Top-Famille Pro', $belfort_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Belfort : bureaux d'études, locaux tertiaires, commerces, cabinets. Devis gratuit sous 24 h.", $belfort_id );

echo "  Zone Belfort (ville) : #$belfort_id\n";

echo "=== Lot 3 terminé ===\n";
