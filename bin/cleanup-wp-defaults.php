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

/*
 * ------------------------------------------------------------------
 * Réglages d'identité du site
 * ------------------------------------------------------------------
 *
 * Trois réglages WordPress se retrouvaient dans le HTML public de chacune des 53 pages et
 * appartiennent à l'installation, pas au thème — ils doivent donc être posés ici, pour que toute
 * installation neuve parte juste.
 *
 *  - **Langue.** `wp core install` laisse `en_US`, et les 53 documents déclaraient
 *    `<html lang="en-US">` sur un site intégralement rédigé en français. C'est une erreur
 *    d'accessibilité (WCAG 3.1.1) autant que de référencement : un lecteur d'écran prononce le
 *    texte avec la phonétique anglaise.
 *  - **Nom du site.** Il alimente le titre des flux, l'Open Graph et le nom du `WebSite` en
 *    JSON-LD. Le nom du bac d'essai fuitait dans le HTML des 53 pages.
 *  - **Fuseau horaire et formats.** Les dates visibles et les dates structurées des articles
 *    doivent être cohérentes, en heure française.
 */
echo "\n=== Identité du site ===\n";

$identite = array(
	'blogname'        => 'Top-Famille Pro',
	'blogdescription' => 'Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté',
	'timezone_string' => 'Europe/Paris',
	'date_format'     => 'j F Y',
	'time_format'     => 'H:i',
	'start_of_week'   => 1,
);
foreach ( $identite as $cle => $valeur ) {
	if ( get_option( $cle ) !== $valeur ) {
		update_option( $cle, $valeur );
		echo "  {$cle} → {$valeur}\n";
	} else {
		echo "  {$cle} déjà correct.\n";
	}
}

// La locale se pose via `WPLANG`. Le pack de langue peut ne pas être installé : `lang` en dépend
// pour la valeur `fr-FR`, et `get_bloginfo('language')` la dérive de cette option.
if ( get_option( 'WPLANG' ) !== 'fr_FR' ) {
	update_option( 'WPLANG', 'fr_FR' );
	echo "  WPLANG → fr_FR\n";
} else {
	echo "  WPLANG déjà en fr_FR.\n";
}
