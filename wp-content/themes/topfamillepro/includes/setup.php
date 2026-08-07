<?php
/**
 * Support du thème, menus, tailles d'image.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_theme_setup() {
	// Balise <title> gérée par WordPress (filtrée dans includes/seo.php) — jamais codée en dur dans un template.
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);

	add_theme_support( 'custom-logo' );
	add_theme_support( 'automatic-feed-links' );

	// Réglage strict : WordPress ne doit générer aucune taille dérivée superflue.
	// Les visuels de contenu passent par le pipeline responsive (includes/images.php),
	// pas par les tailles de médiathèque WordPress.
	set_post_thumbnail_size( 1200, 900, true );
	add_image_size( 'tfp-card', 640, 400, true );

	register_nav_menus(
		array(
			'primary' => __( 'Navigation principale', 'topfamillepro' ),
			'footer'  => __( 'Pied de page', 'topfamillepro' ),
		)
	);
}
add_action( 'after_setup_theme', 'tfp_theme_setup' );

/**
 * Retire les tailles d'image par défaut de WordPress qui ne servent à rien ici
 * (le pipeline AVIF/WebP/JPEG du thème gère les largeurs réellement utilisées).
 */
function tfp_disable_default_image_sizes( $sizes ) {
	unset( $sizes['medium_large'] );
	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'tfp_disable_default_image_sizes' );
