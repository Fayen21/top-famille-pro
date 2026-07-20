<?php
/**
 * Réglages de base du thème : support des fonctionnalités WordPress natives,
 * menus, tailles d'image. Aucun constructeur de page, aucun plugin requis.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'top-famille-pro' ),
			'footer'  => __( 'Pied de page', 'top-famille-pro' ),
		)
	);

	add_image_size( 'tfp-hero', 1920, 1080, true );
	add_image_size( 'tfp-card', 800, 600, true );
	add_image_size( 'tfp-portrait', 640, 800, true );
	add_image_size( 'tfp-square', 480, 480, true );
}
add_action( 'after_setup_theme', 'tfp_theme_setup' );

/**
 * Largeur de contenu utilisée par WordPress pour le redimensionnement
 * automatique des images insérées dans l'éditeur.
 */
function tfp_content_width() {
	$GLOBALS['content_width'] = 1180;
}
add_action( 'after_setup_theme', 'tfp_content_width', 0 );

/**
 * Nettoyage du <head> : on retire ce qui n'a pas d'utilité pour ce site
 * (émoji inline, générateur, liens RSD/wlwmanifest) sans toucher au
 * nécessaire (canonical, feeds si besoin plus tard).
 */
function tfp_cleanup_head() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'tfp_cleanup_head' );
