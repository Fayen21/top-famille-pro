<?php
/**
 * Chargement des CSS/JS. Aucune dépendance externe : polices et scripts
 * sont hébergés localement dans le thème.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_enqueue_assets() {
	wp_enqueue_style( 'tfp-base', TFP_THEME_URI . '/assets/css/base.css', array(), TFP_THEME_VERSION );
	wp_enqueue_style( 'tfp-components', TFP_THEME_URI . '/assets/css/components.css', array( 'tfp-base' ), TFP_THEME_VERSION );

	wp_enqueue_script(
		'tfp-nav',
		TFP_THEME_URI . '/assets/js/nav.js',
		array(),
		TFP_THEME_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tfp_enqueue_assets' );

/**
 * theme.json déclare les polices locales (fontFace) : WordPress génère et
 * enqueue automatiquement la feuille de styles globale correspondante,
 * aucun appel supplémentaire n'est nécessaire ici.
 */
