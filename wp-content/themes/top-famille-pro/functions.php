<?php
/**
 * Amorce du thème Top-Famille Pro.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TFP_THEME_VERSION', '1.0.0' );
define( 'TFP_THEME_DIR', get_template_directory() );
define( 'TFP_THEME_URI', get_template_directory_uri() );

require TFP_THEME_DIR . '/inc/theme-setup.php';
require TFP_THEME_DIR . '/inc/enqueue.php';
require TFP_THEME_DIR . '/inc/donnees-commerciales.php';
require TFP_THEME_DIR . '/inc/photos-globales.php';
require TFP_THEME_DIR . '/inc/cpt-temoignages.php';
require TFP_THEME_DIR . '/inc/cpt-faq.php';
require TFP_THEME_DIR . '/inc/contenu-initial.php';
require TFP_THEME_DIR . '/inc/schema-jsonld.php';
require TFP_THEME_DIR . '/inc/form-handler.php';
require TFP_THEME_DIR . '/inc/seo-meta.php';
require TFP_THEME_DIR . '/inc/template-helpers.php';
