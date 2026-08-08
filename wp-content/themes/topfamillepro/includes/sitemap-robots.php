<?php
/**
 * Sitemap XML et robots.txt (phase 6, PROMPT-PHASES.md).
 *
 * Le sitemap XML natif de WordPress (depuis 5.5, `/wp-sitemap.xml`) suffit : il découpe déjà par
 * type de contenu (« sitemaps par famille »), sans plugin SEO supplémentaire à justifier
 * (CLAUDE.md §3). Deux exclusions nécessaires :
 * - les sitemaps `users` (auteurs) et `taxonomies` (catégorie native : aucune page publique du
 *   site n'en dépend, l'index des conseils est une page classique dédiée, /conseils/) — hors
 *   périmètre des 53 routes publiques ;
 * - les communes secondaires non validées (CLAUDE.md §5.4, `noindex,follow`) : un sitemap ne doit
 *   lister que du contenu réellement indexable.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Empêche l'enregistrement des providers `users` et `taxonomies` — seul point d'extension stable
 * de `WP_Sitemaps_Registry::add_provider()` (pas de méthode `remove_provider()` côté core).
 */
function tfp_filter_sitemap_providers( $provider, $name ) {
	if ( in_array( $name, array( 'users', 'taxonomies' ), true ) ) {
		return false;
	}
	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'tfp_filter_sitemap_providers', 10, 2 );

/**
 * Exclut du sitemap `zone` les communes secondaires non encore validées par Audrey (même logique
 * que le `noindex,follow` calculé dans single-zone.php) — au niveau de la requête, pas de la liste
 * finale : `WP_Sitemaps_Posts::get_url_list()` ajoute chaque entrée à `$url_list` juste après avoir
 * appliqué `wp_sitemaps_posts_entry` (filtre par entrée), sans jamais tenir compte d'un retour
 * `null`/`false` pour l'exclure — la seule vraie extension possible est `wp_sitemaps_posts_query_args`,
 * exécuté avant la requête.
 */
function tfp_filter_sitemap_zone_query_args( $args, $post_type ) {
	if ( 'zone' !== $post_type ) {
		return $args;
	}
	$args['meta_query'] = array(
		'relation' => 'OR',
		array( 'key' => 'niveau', 'value' => 'commune', 'compare' => '!=' ),
		array(
			'relation' => 'AND',
			array( 'key' => 'niveau', 'value' => 'commune', 'compare' => '=' ),
			array( 'key' => 'statut_validation', 'value' => '1', 'compare' => '=' ),
		),
	);
	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'tfp_filter_sitemap_zone_query_args', 10, 2 );

/**
 * robots.txt : WordPress core ajoute déjà lui-même la ligne `Sitemap:` (et désindexe /wp-admin/,
 * autorise admin-ajax.php) via `WP_Sitemaps::add_robots()`, sur le hook `robots_txt` — rien à
 * ajouter ici, un second ajout produirait une ligne dupliquée.
 */
