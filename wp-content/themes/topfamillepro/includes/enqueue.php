<?php
/**
 * Chargement des styles et scripts.
 *
 * Un seul CSS et un seul JS pour tout le site (pas de chargement conditionnel par page à ce
 * stade — la phase 1 ne construit que l'accueil ; à revoir si le poids du CSS augmente
 * significativement une fois toutes les familles de gabarits en place, phase 2+).
 * Cache-busting par date de modification du fichier (filemtime), pas de version figée à la main :
 * un oubli de bump de version ne peut pas servir un CSS/JS périmé depuis le cache navigateur.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_enqueue_assets() {
	// Thème parent GeneratePress — squelette minimal (conteneur, grille), rien de visuel
	// qui ne soit déjà repris par le design system du thème enfant.
	wp_enqueue_style( 'generatepress-parent', get_template_directory_uri() . '/style.css', array(), TFP_THEME_VERSION );

	$css_path = TFP_THEME_DIR . '/assets/dist/css/main.css';
	$js_path  = TFP_THEME_DIR . '/assets/dist/js/main.js';

	$css_version = file_exists( $css_path ) ? filemtime( $css_path ) : TFP_THEME_VERSION;
	$js_version  = file_exists( $js_path ) ? filemtime( $js_path ) : TFP_THEME_VERSION;

	wp_enqueue_style(
		'topfamillepro',
		TFP_THEME_URI . '/assets/dist/css/main.css',
		array( 'generatepress-parent' ),
		$css_version
	);

	wp_enqueue_script(
		'topfamillepro',
		TFP_THEME_URI . '/assets/dist/js/main.js',
		array(),
		$js_version,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tfp_enqueue_assets' );

/**
 * Précharge la police de titre (poids 700, le plus utilisé au-dessus de la ligne de
 * flottaison : H1 du hero) pour réduire le décalage visuel au chargement.
 */
function tfp_preload_fonts() {
	$font = TFP_THEME_URI . '/assets/dist/fonts/bricolage-grotesque-700-latin.woff2';
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin="anonymous">' . "\n",
		esc_url( $font )
	);
}
add_action( 'wp_head', 'tfp_preload_fonts', 1 );

/**
 * Retire les fichiers CSS/JS génériques de WordPress core non utilisés par le site
 * (styles des blocs Gutenberg globaux, jamais utilisés — le thème n'utilise pas l'éditeur
 * de blocs pour le contenu structuré ACF).
 */
function tfp_dequeue_unused_core_assets() {
	if ( ! is_admin() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'tfp_dequeue_unused_core_assets', 20 );
