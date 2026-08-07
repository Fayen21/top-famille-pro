<?php
/**
 * Phase 3, lot 2 — les 7 zones département restantes (Doubs, Jura, Nièvre, Haute-Saône,
 * Saône-et-Loire, Yonne, Territoire de Belfort). Côte-d'Or a été créée en phase 2.
 *
 * Contenu repris du prototype, corrigé selon CLAUDE.md §9 et §5.1 :
 * - tarif fictif « 27 € HT/h » retiré de toutes les réponses directes/FAQ (la grille réelle à
 *   trois montants est déjà affichée par la section tarifs du gabarit, PROJECT_INPUTS.md §5) ;
 * - aucune commune satellite non validée listée comme desservie (le prototype propose une liste
 *   de « communesPlain » différente par département — aucune n'est confirmée par Audrey, donc
 *   `zones_desservies` reste vide partout, comme pour Côte-d'Or/Dijon en phase 2) ;
 * - aucune distance ni temps de trajet chiffré repris (le prototype affirmait par exemple
 *   « Besançon est à environ une heure de route » sans source — non repris) ;
 * - le bloc « fonctionnement » ne reprend pas la formulation de proximité utilisée pour
 *   Côte-d'Or (« l'avantage de la proximité avec Saint-Apollinaire ») : elle serait fausse pour
 *   des départements plus éloignés du siège.
 * - Les blocs « tissu professionnel » et « locaux desservis » sont des caractérisations
 *   générales et déjà publiques des villes concernées (économie tertiaire, universitaire,
 *   industrielle…), pas des données opérationnelles inventées : conservés en les distillant dans
 *   `secteur_economique`/`locaux_types`.
 *
 * Usage : wp eval-file bin/seed-phase3-batch2-departements.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch2-departements.php\n" );
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

// La prestation « bureaux » existe depuis la phase 2 : on la lie comme prestation phare.
$bureaux = get_page_by_path( 'bureaux', OBJECT, 'prestation' );
$bureaux_id = $bureaux ? $bureaux->ID : 0;

echo "=== Seed phase 3, lot 2 : 7 zones département restantes ===\n";

/* ------------------------------------------------------------------ */
/* 1. Doubs — Besançon                                                 */
/* ------------------------------------------------------------------ */

$doubs_term = tfp_seed_get_dept_term( 'doubs', 'Doubs' );
$doubs_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Doubs', 'post_name' => 'doubs', 'post_status' => 'publish' ) );
wp_set_object_terms( $doubs_id, array( $doubs_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $doubs_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Doubs', $doubs_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis dans le Doubs', $doubs_id );
tfp_seed_set_field( 'reponse_directe', "Dans le Doubs, notre secteur prioritaire est Besançon et son agglomération. Nous y entretenons bureaux, cabinets médicaux et paramédicaux courants, commerces et parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. Nous n'avons pas d'agence bisontine : l'organisation vient de Saint-Apollinaire, et votre interlocutrice est Audrey, au 06 36 17 63 39.", $doubs_id );
tfp_seed_set_field( 'secteur_economique', "Besançon est une ville tertiaire et universitaire : administrations, sièges régionaux, professions libérales nombreuses, secteur de la santé présent avec le CHU et les cabinets qui l'entourent. Le centre historique concentre un commerce de détail dense et de nombreux cabinets installés dans des immeubles anciens, avec leurs contraintes propres (escaliers, parquets, accès limité aux véhicules).", $doubs_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux tertiaires et sièges régionaux', 'Cabinets médicaux et paramédicaux courants', 'Commerces du centre historique', "Parties communes d'immeubles anciens et de résidences", 'Locations meublées et logements étudiants' ) ), $doubs_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, à partir des besoins exprimés, des surfaces et des contraintes d'accès et d'horaires. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence ou de départ, nous recherchons une solution de remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir. Sur ce secteur, nous recommandons un volume d'au moins deux heures par passage, ou un regroupement hebdomadaire, pour que l'organisation reste tenable dans la durée.", $doubs_id );
tfp_seed_set_field( 'exclusions_rappel', true, $doubs_id );
tfp_seed_set_field( 'materiel_rappel', true, $doubs_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $doubs_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Avez-vous une agence à Besançon ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Nous intervenons à Besançon avec des tournées organisées, et votre interlocutrice reste Audrey au 06 36 17 63 39." ),
	array( 'q' => 'Le déplacement est-il facturé pour Besançon ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles figurent en ligne distincte du devis, avant toute signature." ),
	array( 'q' => 'Intervenez-vous dans le Pays de Montbéliard ou à Pontarlier ?', 'a' => "Ce ne sont pas nos secteurs prioritaires. Nous étudions les demandes au cas par cas, en fonction de la fréquence et du volume d'heures, mais nous ne garantissons pas la même réactivité qu'à Besançon." ),
	array( 'q' => 'Faites-vous du bio-nettoyage hospitalier ?', 'a' => "Non. Nous assurons l'entretien courant des locaux. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé." ),
	array( 'q' => 'Pouvez-vous intervenir après la fermeture du cabinet ?', 'a' => "Oui, c'est le cas le plus fréquent : passage après le dernier patient, avec une clé ou un code confiés sous décharge écrite. Les interventions de nuit et les dimanches sont majorées de 10 %." ),
	array( 'q' => 'Un petit volume horaire est-il possible à Besançon ?', 'a' => "Nous conseillons au moins deux heures par passage sur ce secteur, ou un regroupement hebdomadaire : en dessous, l'organisation est difficile à tenir dans la durée." ),
), $doubs_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel en Doubs | Top-Famille Pro', $doubs_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Besançon et dans le Doubs : bureaux, cabinets, commerces, parties communes. Devis gratuit sous 24 h.", $doubs_id );

echo "  Zone Doubs (département) : #$doubs_id\n";

/* ------------------------------------------------------------------ */
/* 2. Jura — Dole, Lons-le-Saunier                                     */
/* ------------------------------------------------------------------ */

$jura_term = tfp_seed_get_dept_term( 'jura', 'Jura' );
$jura_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Jura', 'post_name' => 'jura', 'post_status' => 'publish' ) );
wp_set_object_terms( $jura_id, array( $jura_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $jura_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Jura', $jura_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis dans le Jura', $jura_id );
tfp_seed_set_field( 'reponse_directe', "Dans le Jura, nous intervenons principalement à Dole et à Lons-le-Saunier. Bureaux, surfaces de vente, cabinets courants, parties communes et locations meublées sont entretenus en contrat régulier ou en intervention ponctuelle, avec un devis gratuit sous 24 heures au 06 36 17 63 39.", $jura_id );
tfp_seed_set_field( 'secteur_economique', "Dole associe un centre historique commerçant, un tissu de professions libérales et des activités industrielles à proximité. Lons-le-Saunier est une ville d'administrations, de sièges de coopératives agroalimentaires et de commerces, avec un centre-ville dense en cabinets. Ce mélange se retrouve dans nos prestations : commerces, cabinets, bureaux de PME, locaux administratifs rattachés à des sites industriels et parties communes de résidences.", $jura_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Commerces de centre-ville, à Dole comme à Lons-le-Saunier', 'Bureaux de PME et locaux administratifs', 'Cabinets comptables, juridiques, paramédicaux courants', 'Parties communes de résidences et petites copropriétés', 'Locations meublées et gîtes urbains' ) ), $jura_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation, la fréquence étant définie au cas par cas selon la fréquentation des locaux. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence ou de départ, nous recherchons une solution de remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir.", $jura_id );
tfp_seed_set_field( 'exclusions_rappel', true, $jura_id );
tfp_seed_set_field( 'materiel_rappel', true, $jura_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $jura_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Intervenez-vous à Dole et à Lons-le-Saunier ?', 'a' => "Oui, ce sont nos deux villes d'intervention dans le Jura. Chaque ville dispose de sa page détaillée." ),
	array( 'q' => 'Couvrez-vous le Haut-Jura, vers Saint-Claude ou Morez ?', 'a' => "Ce ne sont pas nos secteurs prioritaires. Nous étudions les demandes au cas par cas, mais nous préférons annoncer clairement nos limites plutôt qu'une couverture départementale complète." ),
	array( 'q' => 'Le tarif est-il différent à Lons-le-Saunier ?', 'a' => "Non, la grille est identique dans les deux villes — voir la page Tarifs pour le détail. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis." ),
	array( 'q' => 'Faites-vous du nettoyage agroalimentaire ?', 'a' => "Non. Sur les sites agroalimentaires, nous intervenons uniquement dans les bureaux, accueils, salles de réunion et vestiaires de bureau. Les zones de production relèvent d'entreprises spécialisées." ),
	array( 'q' => 'Pouvez-vous entretenir une location meublée dans le Jura ?', 'a' => "Oui, entre deux séjours ou en fin de bail : ménage complet, changement de linge fourni, vérification des consommables, chacun possible lorsque prévu au cahier des charges et chiffré dans le devis." ),
	array( 'q' => 'Quel délai pour une intervention ponctuelle ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $jura_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel en Jura | Top-Famille Pro', $jura_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Dole et Lons-le-Saunier (Jura) : bureaux, commerces, cabinets, parties communes. Devis gratuit sous 24 h.", $jura_id );

echo "  Zone Jura (département) : #$jura_id\n";

/* ------------------------------------------------------------------ */
/* 3. Nièvre — Nevers                                                  */
/* ------------------------------------------------------------------ */

$nievre_term = tfp_seed_get_dept_term( 'nievre', 'Nièvre' );
$nievre_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Nièvre', 'post_name' => 'nievre', 'post_status' => 'publish' ) );
wp_set_object_terms( $nievre_id, array( $nievre_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $nievre_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans la Nièvre', $nievre_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis dans la Nièvre', $nievre_id );
tfp_seed_set_field( 'reponse_directe', "Dans la Nièvre, notre secteur d'intervention est Nevers et son agglomération. Nous y entretenons bureaux, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle. Devis gratuit sous 24 heures, une seule interlocutrice, Audrey, au 06 36 17 63 39.", $nievre_id );
tfp_seed_set_field( 'secteur_economique', "Nevers est une ville de services et d'administrations : préfecture, collectivités, organismes publics, professions libérales et un centre-ville commerçant, complétée par des activités industrielles et logistiques dans les zones d'activité de l'agglomération. Le parc immobilier comporte une forte proportion de résidences collectives, ce qui explique la part importante des parties communes dans nos interventions locales.", $nievre_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Parties communes de copropriétés et résidences', 'Bureaux administratifs et locaux de collectivités', 'Commerces de centre-ville', 'Cabinets et professions libérales', "Bureaux rattachés aux zones d'activité" ) ), $nievre_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence ou de départ, nous recherchons une solution de remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir. Sur ce secteur, notre réactivité pour une intervention en urgence reste plus limitée qu'en Côte-d'Or : nous répondons honnêtement selon nos disponibilités plutôt que de nous engager sur un délai que nous ne pourrions pas tenir.", $nievre_id );
tfp_seed_set_field( 'exclusions_rappel', true, $nievre_id );
tfp_seed_set_field( 'materiel_rappel', true, $nievre_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $nievre_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => "Intervenez-vous ailleurs qu'à Nevers dans la Nièvre ?", 'a' => "Notre secteur prioritaire couvre Nevers et son agglomération proche. Pour une commune plus éloignée, contactez-nous : nous vous dirons honnêtement si nous pouvons tenir un planning fiable." ),
	array( 'q' => 'Le tarif est-il majoré à cause de la distance ?', 'a' => "Le taux horaire est identique à celui pratiqué partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis." ),
	array( 'q' => 'Travaillez-vous avec les syndics de copropriété ?', 'a' => "Oui, c'est une part importante de notre activité à Nevers : halls, escaliers, ascenseurs, locaux à conteneurs et gestion des bacs selon le calendrier de collecte, lorsque prévu et chiffré au devis." ),
	array( 'q' => 'Un passage hebdomadaire suffit-il pour un immeuble ?', 'a' => "Pour un immeuble de taille moyenne, oui dans la plupart des cas. Nous adaptons la fréquence à la fréquentation, au nombre d'étages et à la présence d'un ascenseur." ),
	array( 'q' => 'Pouvez-vous intervenir rapidement en urgence ?', 'a' => "Sur ce secteur, notre réactivité est plus limitée qu'en Côte-d'Or. Nous répondons clairement selon nos disponibilités plutôt que de nous engager sur un délai que nous ne pourrions pas tenir." ),
	array( 'q' => "Faut-il un engagement de durée ?", 'a' => "Le devis est toujours gratuit et sans engagement. Le volume et la fréquence peuvent être ajustés en cours de route ; les conditions d'arrêt (préavis écrit) sont précisées au devis avant signature." ),
), $nievre_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel en Nièvre | Top-Famille Pro', $nievre_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Nevers et dans la Nièvre : bureaux, commerces, cabinets, copropriétés. Devis gratuit sous 24 h.", $nievre_id );

echo "  Zone Nièvre (département) : #$nievre_id\n";

/* ------------------------------------------------------------------ */
/* 4. Haute-Saône — Vesoul                                             */
/* ------------------------------------------------------------------ */

$hs_term = tfp_seed_get_dept_term( 'haute-saone', 'Haute-Saône' );
$hs_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Haute-Saône', 'post_name' => 'haute-saone', 'post_status' => 'publish' ) );
wp_set_object_terms( $hs_id, array( $hs_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $hs_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage en Haute-Saône', $hs_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis en Haute-Saône', $hs_id );
tfp_seed_set_field( 'reponse_directe', "En Haute-Saône, notre secteur d'intervention est Vesoul et les communes qui l'entourent. Nous y entretenons bureaux, locaux administratifs, commerces, cabinets courants et parties communes d'immeubles, en régulier ou en ponctuel, avec un devis gratuit sous 24 heures. Une seule interlocutrice pour tout le département : Audrey, au 06 36 17 63 39.", $hs_id );
tfp_seed_set_field( 'secteur_economique', "Vesoul est une préfecture de taille modeste, structurée autour des administrations, des services et d'un centre-ville commerçant, complétée par des zones d'activité industrielles et logistiques à l'échelle du département. Ce mélange explique la nature de nos interventions : bureaux administratifs (y compris rattachés à des sites industriels ou logistiques), commerces de centre-ville, cabinets et quelques copropriétés.", $hs_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux administratifs et locaux tertiaires', 'Bureaux rattachés aux zones logistiques et industrielles', 'Commerces de centre-ville', 'Cabinets et professions libérales', 'Parties communes de résidences' ) ), $hs_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation. Le devis suit sous 24 heures. Les demandes portent souvent sur des créneaux en dehors des heures d'activité, avec un accès organisé par badge ou par clé, remis contre décharge écrite. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, nous recherchons une solution de remplacement, sans garantie de continuité absolue. Nous recommandons un volume d'au moins deux heures par passage, ou un regroupement hebdomadaire.", $hs_id );
tfp_seed_set_field( 'exclusions_rappel', true, $hs_id );
tfp_seed_set_field( 'materiel_rappel', true, $hs_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $hs_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => "Intervenez-vous ailleurs qu'à Vesoul en Haute-Saône ?", 'a' => "Notre secteur prioritaire couvre Vesoul et sa couronne immédiate. Gray, Lure, Luxeuil-les-Bains ou Héricourt ne sont pas des secteurs prioritaires : contactez-nous, nous vous répondrons honnêtement." ),
	array( 'q' => 'Le déplacement est-il facturé ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles figurent en ligne distincte sur le devis, jamais après coup." ),
	array( 'q' => 'Entretenez-vous les entrepôts logistiques ?', 'a' => "Non. Nous intervenons dans les bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires de ces sites, pas dans les zones d'exploitation ni sur les machines." ),
	array( 'q' => 'Pouvez-vous intervenir avec un badge en dehors des horaires ?', 'a' => "Oui. La remise du badge ou de la clé se fait contre décharge écrite, avec le code d'alarme et la procédure de fermeture consignés dans le cahier des charges." ),
	array( 'q' => 'Le tarif est-il plus élevé qu\'en Côte-d\'Or ?', 'a' => "Non, le taux horaire est identique partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis." ),
	array( 'q' => 'Quel volume minimum conseillez-vous ?', 'a' => "Sur ce secteur, nous recommandons au moins deux heures par passage, ou un regroupement hebdomadaire, afin que l'organisation reste tenable pour vous comme pour nous." ),
), $hs_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel en Haute-Saône | Top-Famille Pro', $hs_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Vesoul et en Haute-Saône : bureaux, commerces, cabinets, parties communes. Devis gratuit sous 24 h.", $hs_id );

echo "  Zone Haute-Saône (département) : #$hs_id\n";

/* ------------------------------------------------------------------ */
/* 5. Saône-et-Loire — Chalon-sur-Saône, Mâcon                         */
/* ------------------------------------------------------------------ */

$sl_term = tfp_seed_get_dept_term( 'saone-et-loire', 'Saône-et-Loire' );
$sl_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Saône-et-Loire', 'post_name' => 'saone-et-loire', 'post_status' => 'publish' ) );
wp_set_object_terms( $sl_id, array( $sl_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $sl_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage en Saône-et-Loire', $sl_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis en Saône-et-Loire', $sl_id );
tfp_seed_set_field( 'reponse_directe', "En Saône-et-Loire, nos deux villes d'intervention sont Chalon-sur-Saône et Mâcon. Nous y entretenons bureaux, surfaces de vente, cabinets courants, parties communes et locations meublées, en contrat régulier ou en intervention ponctuelle, avec un devis gratuit sous 24 heures au 06 36 17 63 39.", $sl_id );
tfp_seed_set_field( 'secteur_economique', "Chalon-sur-Saône est une ville industrielle et tertiaire : bureaux d'études, sièges d'entreprises, zones d'activité et centre-ville commerçant. Mâcon, préfecture, vit du commerce, des services et de la filière viticole du Mâconnais. Les besoins viennent surtout de PME, de commerces indépendants, de cabinets et de syndics, avec des passages majoritairement tôt le matin ou en fin de journée.", $sl_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( "Bureaux de PME et bureaux d'études", 'Commerces de centre-ville et de zones commerciales', 'Cabinets comptables, juridiques et paramédicaux courants', 'Parties communes de copropriétés urbaines', 'Locations meublées et logements de courte durée' ) ), $sl_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, nous recherchons une solution de remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir. Un passage supplémentaire ponctuel reste possible sur devis complémentaire, par exemple pour un commerce en période de forte affluence.", $sl_id );
tfp_seed_set_field( 'exclusions_rappel', true, $sl_id );
tfp_seed_set_field( 'materiel_rappel', true, $sl_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $sl_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Intervenez-vous à Chalon-sur-Saône et à Mâcon ?', 'a' => "Oui, ce sont nos deux villes d'intervention en Saône-et-Loire. Chaque ville a sa page détaillée sur le site." ),
	array( 'q' => 'Couvrez-vous Le Creusot, Montceau-les-Mines ou le Charolais ?', 'a' => "Ce ne sont pas nos secteurs prioritaires. Nous étudions les demandes au cas par cas selon la fréquence et le volume, sans promettre la même réactivité que sur l'axe Saône." ),
	array( 'q' => 'Des indemnités kilométriques peuvent-elles s\'ajouter en Saône-et-Loire ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse exacte, du planning et des conditions d'intervention. Elles sont calculées et précisées dans le devis avant toute validation." ),
	array( 'q' => 'Intervenez-vous dans les caves et chais viticoles ?', 'a' => "Non. Nous entretenons les bureaux, accueils, salles de dégustation et de réception, sanitaires et salles de réunion, pas les espaces d'élaboration ni de conditionnement." ),
	array( 'q' => 'Un passage supplémentaire est-il possible les jours de forte affluence ?', 'a' => "Oui, pour les commerces notamment. Il est chiffré séparément au même tarif horaire, sans modifier le contrat régulier en place." ),
	array( 'q' => 'Travaillez-vous avec les syndics du Grand Chalon ?', 'a' => "Oui : halls, cages d'escalier, ascenseurs, locaux à conteneurs, avec un cahier de liaison consultable par le conseil syndical et un point de suivi." ),
), $sl_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel en Saône-et-Loire | Top-Famille Pro', $sl_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Chalon-sur-Saône et Mâcon : bureaux, commerces, cabinets, copropriétés. Devis gratuit sous 24 h.", $sl_id );

echo "  Zone Saône-et-Loire (département) : #$sl_id\n";

/* ------------------------------------------------------------------ */
/* 6. Yonne — Auxerre                                                  */
/* ------------------------------------------------------------------ */

$yonne_term = tfp_seed_get_dept_term( 'yonne', 'Yonne' );
$yonne_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Yonne', 'post_name' => 'yonne', 'post_status' => 'publish' ) );
wp_set_object_terms( $yonne_id, array( $yonne_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $yonne_id );
tfp_seed_set_field( 'h1', "Entreprise de nettoyage dans l'Yonne", $yonne_id );
tfp_seed_set_field( 'cta_label', "Demander un devis dans l'Yonne", $yonne_id );
tfp_seed_set_field( 'reponse_directe', "Dans l'Yonne, notre secteur d'intervention est Auxerre et les communes proches. Nous y entretenons bureaux de PME, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d'immeubles, en contrat régulier ou en intervention ponctuelle, avec un devis gratuit sous 24 heures au 06 36 17 63 39.", $yonne_id );
tfp_seed_set_field( 'secteur_economique', "Auxerre est une préfecture de services : administrations, sièges de PME, professions libérales, centre-ville commerçant, avec un patrimoine bâti ancien dans le cœur historique. L'axe A6 a favorisé l'implantation d'activités logistiques et agroalimentaires en périphérie ; à proximité, la filière viticole du Chablisien génère des besoins d'entretien sur les espaces d'accueil et de dégustation.", $yonne_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( 'Bureaux de PME et sièges locaux', 'Bureaux administratifs rattachés aux zones logistiques', 'Commerces de centre-ville', 'Cabinets et professions libérales', "Espaces d'accueil et de dégustation" ) ), $yonne_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation. Le devis suit sous 24 heures. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, nous recherchons une solution de remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir. L'accès (clé ou badge) est le plus souvent remis contre décharge écrite, pour une intervention sans présence du client.", $yonne_id );
tfp_seed_set_field( 'exclusions_rappel', true, $yonne_id );
tfp_seed_set_field( 'materiel_rappel', true, $yonne_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $yonne_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Intervenez-vous à Sens, Joigny ou Avallon ?', 'a' => "Non, pas de façon régulière : ces villes sont trop éloignées de nos tournées actuelles pour que nous garantissions un planning stable. Notre secteur icaunais s'arrête à Auxerre et sa couronne." ),
	array( 'q' => "L'éloignement change-t-il le tarif horaire ?", 'a' => "Non, la grille tarifaire est identique partout dans la région — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis." ),
	array( 'q' => "Entretenez-vous les entrepôts de l'axe A6 ?", 'a' => "Uniquement leurs bureaux administratifs, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les zones d'exploitation ne font pas partie de notre offre." ),
	array( 'q' => 'Pouvez-vous entretenir un caveau de dégustation ?', 'a' => "Oui, en tant qu'espace recevant du public : sols, comptoir, vitrages intérieurs, sanitaires. Les espaces d'élaboration et de conditionnement, non." ),
	array( 'q' => 'Est-il possible d\'intervenir sans que nous soyons présents ?', 'a' => "Oui, c'est le cas le plus fréquent. La clé ou le badge est remis contre décharge écrite, avec le code d'alarme et la procédure de fermeture consignés." ),
	array( 'q' => 'Quel délai pour démarrer un contrat régulier ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $yonne_id );
tfp_seed_set_field( 'seo_title', "Nettoyage professionnel en Yonne | Top-Famille Pro", $yonne_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Auxerre et dans l'Yonne : bureaux, commerces, cabinets, parties communes. Devis gratuit sous 24 h.", $yonne_id );

echo "  Zone Yonne (département) : #$yonne_id\n";

/* ------------------------------------------------------------------ */
/* 7. Territoire de Belfort — Belfort                                  */
/* ------------------------------------------------------------------ */

$belfort_dept_term = tfp_seed_get_dept_term( 'territoire-de-belfort', 'Territoire de Belfort' );
$belfort_dept_id = tfp_seed_upsert_post( array( 'post_type' => 'zone', 'post_title' => 'Territoire de Belfort', 'post_name' => 'territoire-de-belfort', 'post_status' => 'publish' ) );
wp_set_object_terms( $belfort_dept_id, array( $belfort_dept_term ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $belfort_dept_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Territoire de Belfort', $belfort_dept_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Belfort', $belfort_dept_id );
tfp_seed_set_field( 'reponse_directe', "Dans le Territoire de Belfort, notre secteur d'intervention est Belfort et son agglomération. Nous y entretenons bureaux, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d'immeubles, en régulier ou en ponctuel, avec un devis gratuit sous 24 heures. Votre interlocutrice est Audrey, au 06 36 17 63 39.", $belfort_dept_id );
tfp_seed_set_field( 'secteur_economique', "Belfort est une ville industrielle et universitaire : activités industrielles, entreprises et laboratoires privés, ainsi qu'un pôle universitaire qui génère un tissu de services et de bureaux. Le centre-ville concentre commerces et cabinets. Les besoins viennent principalement de bureaux d'études et d'ingénierie, de PME de services, de cabinets libéraux, de commerces indépendants et de copropriétés.", $belfort_dept_id );
tfp_seed_set_field( 'locaux_types', implode( "\n", array( "Bureaux d'études et d'ingénierie", 'Bureaux administratifs de sites industriels', 'Locaux tertiaires et administratifs universitaires', 'Commerces de centre-ville', 'Cabinets et professions libérales' ) ), $belfort_dept_id );
tfp_seed_set_field( 'fonctionnement', "Le cahier des charges est établi à distance ou lors d'une visite selon la situation. Le devis suit sous 24 heures. Les demandes portent souvent sur des interventions en soirée, après le départ des équipes, avec des consignes de sécurité propres au site consignées au cahier des charges. Nous cherchons à confier votre site au même intervenant d'un passage sur l'autre ; en cas d'absence, nous recherchons une solution de remplacement, sans garantie de continuité absolue.", $belfort_dept_id );
tfp_seed_set_field( 'exclusions_rappel', true, $belfort_dept_id );
tfp_seed_set_field( 'materiel_rappel', true, $belfort_dept_id );
if ( $bureaux_id ) { tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $belfort_dept_id ); }
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Le Territoire de Belfort est-il vraiment couvert ?', 'a' => "Oui, avec Belfort et son agglomération comme secteur prioritaire. La grille tarifaire est identique à celle du reste de la région — voir la page Tarifs." ),
	array( 'q' => 'Avez-vous une agence à Belfort ?', 'a' => "Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon, et le numéro affiché est le même partout : 06 36 17 63 39." ),
	array( 'q' => 'Intervenez-vous sur les sites industriels belfortains ?', 'a' => "Uniquement dans leurs espaces tertiaires : bureaux, salles de réunion, accueil, sanitaires, vestiaires de bureau. Les ateliers et zones de production ne font pas partie de notre offre." ),
	array( 'q' => 'Pouvez-vous intervenir après le départ des équipes ?', 'a' => "Oui, c'est le cas le plus fréquent. L'accès est formalisé par écrit et les consignes de sécurité du site sont annexées au cahier des charges." ),
	array( 'q' => 'Couvrez-vous Delle, Beaucourt ou Giromagny ?', 'a' => "Ces communes sont examinées au cas par cas, selon la fréquence et le volume. Notre secteur prioritaire est Belfort et sa couronne immédiate." ),
	array( 'q' => 'Quel est le délai de mise en place ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse, du volume horaire et de l'organisation nécessaire. Il est confirmé lors de l'établissement du devis." ),
), $belfort_dept_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage professionnel à Belfort (90) | Top-Famille Pro', $belfort_dept_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Belfort et dans le Territoire de Belfort : bureaux, commerces, cabinets. Devis gratuit sous 24 h.", $belfort_dept_id );

echo "  Zone Territoire de Belfort (département) : #$belfort_dept_id\n";

echo "=== Lot 2 terminé ===\n";
