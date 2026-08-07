<?php
/**
 * Phase 3, lot 7 (dernier lot) — les 4 pages légales / plan du site restantes :
 * /mentions-legales/, /politique-de-confidentialite/, /gestion-des-cookies/, /plan-du-site/.
 *
 * Usage : wp eval-file bin/seed-phase3-batch7-pages.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch7-pages.php\n" );
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

echo "=== Seed phase 3, lot 7 : 4 pages légales / plan du site ===\n";

$pages = array(
	array( 'title' => 'Mentions légales', 'slug' => 'mentions-legales' ),
	array( 'title' => 'Politique de confidentialité', 'slug' => 'politique-de-confidentialite' ),
	array( 'title' => 'Gestion des cookies', 'slug' => 'gestion-des-cookies' ),
	array( 'title' => 'Plan du site', 'slug' => 'plan-du-site' ),
);

foreach ( $pages as $page ) {
	$id = tfp_seed_upsert_post( array( 'post_type' => 'page', 'post_title' => $page['title'], 'post_name' => $page['slug'], 'post_status' => 'publish' ) );
	echo "  Page /{$page['slug']}/ : #$id\n";
}

echo "=== Lot 7 terminé — 53 pages migrées ===\n";
