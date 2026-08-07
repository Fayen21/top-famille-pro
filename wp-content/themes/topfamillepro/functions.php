<?php
/**
 * Bootstrap du thème enfant Top-Famille Pro.
 *
 * Chaque responsabilité vit dans son propre fichier sous includes/ — voir le sommaire
 * ci-dessous. Ce fichier ne fait que les charger dans le bon ordre.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Accès direct interdit.
}

define( 'TFP_THEME_DIR', get_stylesheet_directory() );
define( 'TFP_THEME_URI', get_stylesheet_directory_uri() );
define( 'TFP_THEME_VERSION', '0.1.0' );

$tfp_includes = array(
	'includes/setup.php',        // Support du thème, menus, tailles d'image.
	'includes/customizer.php',   // Réglages Customizer natifs (ex. photo d'Audrey) — aucune dépendance ACF.
	'includes/site-options.php', // Constantes du site (coordonnées réelles) — PROJECT_INPUTS.md, jamais de valeur inventée.
	'includes/enqueue.php',      // Chargement CSS/JS avec cache-busting par date de modification.
	'includes/images.php',       // Helper d'image responsive (AVIF/WebP/JPEG + srcset) à partir du manifeste de build.
	'includes/components.php',   // Composants globaux réutilisables (bouton, badge…).
	'includes/breadcrumbs.php',  // Fil d'Ariane + BreadcrumbList JSON-LD.
	'includes/seo.php',          // title, meta description, canonical, OG, Twitter, JSON-LD Organization/WebSite.
	'includes/security.php',     // Durcissement standard (masquage de version, désactivation de l'éditeur de fichiers, etc.).
	'includes/cpt-zone.php',     // CPT `zone` (26 entrées, 3 niveaux via champ ACF `niveau`) + taxonomie `departement`. Enregistré indépendamment d'ACF (fonctionne même sans le plugin).
	'includes/cpt-prestation.php', // CPT `prestation` (6 entrées). Idem.
	'includes/acf-helpers.php',           // tfp_acf_faq_group_fields() : FAQ à nombre variable sans le champ Repeater (Pro), via des champs Group (gratuit).
	'includes/acf-fields-zone.php',       // Champs ACF structurés du CPT zone — tous compatibles ACF gratuit.
	'includes/acf-fields-prestation.php', // Champs ACF structurés du CPT prestation — tous compatibles ACF gratuit.
	'includes/reassurance-settings.php', // Réglages « Réassurance & avis » (avis/note/lien Google réels) — API Settings native WordPress, aucune dépendance ACF.
	'includes/articles-meta.php', // Réponse directe + FAQ des articles (type post natif) — boîte de méta native, aucune dépendance ACF.
	'includes/articles-routing.php', // URL réelle /conseils/{slug}/ des articles, indépendante du réglage Permaliens global.
	'includes/quote-form.php',   // Traitement serveur du formulaire de demande de devis (admin-post.php, wp_mail()).
);

foreach ( $tfp_includes as $tfp_include ) {
	$tfp_path = TFP_THEME_DIR . '/' . $tfp_include;
	if ( file_exists( $tfp_path ) ) {
		require_once $tfp_path;
	}
}
unset( $tfp_includes, $tfp_include, $tfp_path );
