<?php
/**
 * URL réelle des articles : /conseils/{slug}/ (CLAUDE.md §3, docs/INVENTAIRE-ROUTES.md).
 *
 * Ne pas s'appuyer sur le réglage global "Permaliens" de WordPress (Réglages → Permaliens →
 * structure personnalisée /%category%/%postname%/) : un changement de ce réglage en admin
 * casserait silencieusement toutes les URL d'article sans qu'aucune erreur ne le signale. La
 * structure est donc forcée par le thème, comme pour les zones (includes/cpt-zone.php).
 *
 * Ne s'applique qu'aux articles de la catégorie « Conseils » : les autres usages du type `post`
 * natif, s'il y en a un jour, gardent le comportement WordPress par défaut.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_article_rewrite_rules() {
	add_rewrite_rule( '^conseils/([^/]+)/?$', 'index.php?name=$matches[1]', 'top' );
}
add_action( 'init', 'tfp_article_rewrite_rules' );

function tfp_article_permalink( $post_link, $post ) {
	if ( 'post' !== $post->post_type ) {
		return $post_link;
	}

	if ( in_category( 'conseils', $post ) ) {
		return home_url( '/conseils/' . $post->post_name . '/' );
	}

	return $post_link;
}
add_filter( 'post_link', 'tfp_article_permalink', 10, 2 );

/**
 * Flush des règles de réécriture à l'activation du thème (voir includes/cpt-zone.php pour le
 * même mécanisme sur les zones — les deux flush sont regroupés ici pour n'en garder qu'un seul).
 */
function tfp_flush_article_rewrite_rules_on_activation() {
	tfp_article_rewrite_rules();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tfp_flush_article_rewrite_rules_on_activation' );
