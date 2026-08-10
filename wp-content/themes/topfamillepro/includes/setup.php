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

/**
 * S'assure que la catégorie « Conseils » existe (CLAUDE.md §3 : type `post` natif, catégorie
 * « Conseils », pour les 3 articles). Idempotent — wp_insert_term() ne recrée rien si le terme
 * existe déjà.
 */
function tfp_ensure_conseils_category() {
	if ( ! term_exists( 'conseils', 'category' ) ) {
		wp_insert_term( 'Conseils', 'category', array( 'slug' => 'conseils' ) );
	}
}
add_action( 'init', 'tfp_ensure_conseils_category', 20 );

/**
 * Classe de type de page sur `<body>`, pour l'échelle typographique.
 *
 * La maquette Claude Design module la taille des titres selon la densité de la page : 58 px de H1
 * sur l'accueil, 48 à 54 sur les pages internes ; 42 px de H2 sur l'accueil, 34 à 36 sur les pages
 * denses, 29 sur les zones, 27 dans les articles. Une taille unique écrase cette hiérarchie et
 * allonge les pages sans rien apporter. Plutôt que de coder une taille par titre — infidèle au
 * premier ajout de section — le type de page porte l'échelle, et le CSS en déduit les tailles.
 *
 * @param string[] $classes
 * @return string[]
 */
function tfp_body_class( $classes ) {
	$type = 'institutionnelle';

	if ( is_front_page() ) {
		$type = 'accueil';
	} elseif ( is_singular( 'prestation' ) ) {
		$type = 'prestation';
	} elseif ( is_singular( 'zone' ) ) {
		$type = 'zone';
	} elseif ( is_singular( 'post' ) ) {
		$type = 'article';
	} elseif ( is_page( 'tarifs' ) ) {
		$type = 'tarifs';
	} elseif ( is_page( 'nettoyage-professionnel' ) ) {
		$type = 'pilier';
	} elseif ( is_page( array( 'mentions-legales', 'politique-de-confidentialite', 'gestion-des-cookies', 'plan-du-site' ) ) ) {
		$type = 'legale';
	} elseif ( is_page( array( 'zones-intervention', 'bourgogne-franche-comte' ) ) ) {
		$type = 'zone';
	}

	$classes[] = 'tfp-type-' . $type;
	return $classes;
}
add_filter( 'body_class', 'tfp_body_class' );
