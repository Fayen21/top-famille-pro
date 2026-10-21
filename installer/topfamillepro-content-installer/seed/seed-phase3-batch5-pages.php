<?php
/**
 * Phase 3, lot 5b — les 4 pages statiques réservées (contenu réel dans les gabarits dédiés
 * page-{slug}.php, même principe que page-nettoyage-professionnel.php en phase 2) :
 * /prestations/, /tarifs/, /zones-intervention/, /zones-intervention/bourgogne-franche-comte/.
 *
 * La page région est un enfant de la page hub (hiérarchie WordPress native → URL imbriquée
 * /zones-intervention/bourgogne-franche-comte/ sans règle de réécriture dédiée, contrairement au
 * CPT zone qui, lui, en a besoin — includes/cpt-zone.php).
 *
 * Usage : wp eval-file bin/seed-phase3-batch5-pages.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch5-pages.php\n" );
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

echo "=== Seed phase 3, lot 5b : 4 pages statiques ===\n";

$prestations_id = tfp_seed_upsert_post( array( 'post_type' => 'page', 'post_title' => 'Nos prestations', 'post_name' => 'prestations', 'post_status' => 'publish' ) );
echo "  Page /prestations/ : #$prestations_id\n";

$tarifs_id = tfp_seed_upsert_post( array( 'post_type' => 'page', 'post_title' => 'Tarifs', 'post_name' => 'tarifs', 'post_status' => 'publish' ) );
echo "  Page /tarifs/ : #$tarifs_id\n";

$hub_id = tfp_seed_upsert_post( array( 'post_type' => 'page', 'post_title' => "Zones d'intervention", 'post_name' => 'zones-intervention', 'post_status' => 'publish' ) );
echo "  Page /zones-intervention/ : #$hub_id\n";

$region_id = tfp_seed_upsert_post(
	array(
		'post_type'   => 'page',
		'post_title'  => 'Bourgogne-Franche-Comté',
		'post_name'   => 'bourgogne-franche-comte',
		'post_parent' => $hub_id,
		'post_status' => 'publish',
	)
);
echo "  Page /zones-intervention/bourgogne-franche-comte/ : #$region_id\n";

echo "=== Lot 5b terminé ===\n";
