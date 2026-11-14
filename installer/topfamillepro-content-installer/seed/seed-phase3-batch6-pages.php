<?php
/**
 * Phase 3, lot 6 — les 8 pages statiques restantes (contenu réel dans les gabarits dédiés
 * page-{slug}.php, même principe que les lots précédents) : /pourquoi-nous/,
 * /notre-fonctionnement/, /avis-clients/, /a-propos/, /demande-de-devis/, /contact/,
 * /recrutement/, /conseils/.
 *
 * Usage : wp eval-file bin/seed-phase3-batch6-pages.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch6-pages.php\n" );
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

echo "=== Seed phase 3, lot 6 : 8 pages statiques ===\n";

$pages = array(
	array( 'title' => 'Pourquoi nous', 'slug' => 'pourquoi-nous' ),
	array( 'title' => 'Notre fonctionnement', 'slug' => 'notre-fonctionnement' ),
	array( 'title' => 'Avis clients', 'slug' => 'avis-clients' ),
	array( 'title' => 'À propos', 'slug' => 'a-propos' ),
	array( 'title' => 'Demande de devis', 'slug' => 'demande-de-devis' ),
	array( 'title' => 'Contact', 'slug' => 'contact' ),
	array( 'title' => 'Recrutement', 'slug' => 'recrutement' ),
	array( 'title' => 'Conseils', 'slug' => 'conseils' ),
);

foreach ( $pages as $page ) {
	$id = tfp_seed_upsert_post( array( 'post_type' => 'page', 'post_title' => $page['title'], 'post_name' => $page['slug'], 'post_status' => 'publish' ) );
	echo "  Page /{$page['slug']}/ : #$id\n";
}

echo "=== Lot 6 terminé ===\n";
