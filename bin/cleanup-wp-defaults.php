<?php
/**
 * Phase 6 — met à la corbeille le contenu par défaut que `wp core install` crée sur toute
 * installation WordPress neuve (l'article « Hello world! » et la page « Sample Page »), trouvé en
 * mettant en place le sitemap : les deux étaient publiés et donc indexables, alors qu'ils ne font
 * pas partie des 53 pages réelles du site.
 *
 * Idempotent : sans effet si déjà exécuté (les posts n'existent alors plus, `get_page_by_path`
 * renvoie `null`). À exécuter une fois après l'installation WordPress initiale sur l'hébergement
 * réel, comme sur ce rig de test.
 *
 * Usage : wp eval-file bin/cleanup-wp-defaults.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/cleanup-wp-defaults.php\n" );
}

echo "=== Nettoyage du contenu par défaut WordPress ===\n";

$hello_world = get_page_by_path( 'hello-world', OBJECT, 'post' );
if ( $hello_world ) {
	wp_trash_post( $hello_world->ID );
	echo "  Article « Hello world! » (#{$hello_world->ID}) mis à la corbeille.\n";
} else {
	echo "  Article « Hello world! » déjà absent.\n";
}

$sample_page = get_page_by_path( 'sample-page', OBJECT, 'page' );
if ( $sample_page ) {
	wp_trash_post( $sample_page->ID );
	echo "  Page « Sample Page » (#{$sample_page->ID}) mise à la corbeille.\n";
} else {
	echo "  Page « Sample Page » déjà absente.\n";
}

echo "=== Terminé ===\n";
