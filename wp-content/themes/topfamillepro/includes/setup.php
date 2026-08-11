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

	/*
	 * Largeur du hero, relevée sur la maquette route par route (tools/compare-styles.mjs).
	 *
	 * Le prototype n'a pas une seule largeur de hero : il en a deux familles. Les pages dont le
	 * hero est sur deux colonnes (accueil, prestation, ville, page pilier, à-propos, devis) posent
	 * leur texte dans une colonne d'environ 610 px, gérée par la mise en page de ces gabarits. Les
	 * autres centrent un bloc étroit — 900 px pour la plupart, 820 px pour l'index des prestations
	 * et les pages légales, 1260 px pour le plan du site. Le thème les rendait toutes à 1260 px :
	 * les lignes de texte étaient trop longues et les pages, mécaniquement, trop courtes.
	 *
	 * Une classe par largeur relevée, plutôt qu'une règle par gabarit : la valeur vient de la
	 * mesure, elle ne se déduit ni du type de contenu ni d'une intuition de mise en page.
	 */
	$hero = '';
	if ( is_page( array( 'tarifs', 'zones-intervention', 'conseils', 'pourquoi-nous', 'notre-fonctionnement', 'avis-clients', 'contact' ) ) || is_home() ) {
		$hero = '900';
	} elseif ( is_singular( 'post' ) ) {
		$hero = '900';
	} elseif ( is_page( array( 'prestations', 'mentions-legales', 'politique-de-confidentialite', 'gestion-des-cookies' ) ) ) {
		$hero = '820';
	} elseif ( is_page( 'plan-du-site' ) ) {
		$hero = '1260';
	} elseif ( is_singular( 'zone' ) && 'departement' === tfp_get_field( 'niveau' ) ) {
		$hero = '900';
	}
	if ( $hero ) {
		$classes[] = 'tfp-hero-w-' . $hero;
	}

	return $classes;
}
add_filter( 'body_class', 'tfp_body_class' );

/**
 * Neutralise le remplacement des émojis par des images distantes.
 *
 * WordPress convertit chaque émoji du contenu en `<img src="https://s.w.org/…">`. Trois
 * conséquences, toutes indésirables ici : une requête vers un domaine tiers par émoji — que la
 * politique de confidentialité du site ne mentionne pas —, une image de plus à charger sur le
 * chemin critique, et un visuel cassé dès que ce domaine est injoignable. Les cartes de
 * coordonnées de la page Contact en portent quatre.
 *
 * Les émojis restent affichés : ce sont des caractères, et toutes les plateformes visées les
 * rendent nativement.
 */
function tfp_disable_emoji_images() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', static function ( $plugins ) {
		return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
	} );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'tfp_disable_emoji_images' );

/**
 * Déclare la langue du document en français.
 *
 * `WPLANG` est posé à `fr_FR` par l'installateur, mais WordPress ne renvoie cette locale que si le
 * **pack de langue** correspondant est présent : sur une installation où il manque, `get_locale()`
 * retombe sur `en_US` et les 53 pages déclarent `<html lang="en-US">` alors que tout leur contenu
 * est rédigé en français. Un lecteur d'écran prononce alors le texte avec la phonétique anglaise,
 * ce qui le rend inintelligible — c'est une violation du critère WCAG 3.1.1 « Langue de la page ».
 *
 * Ce thème est monolingue français par construction : il l'affirme donc, indépendamment de la
 * présence du pack. Le filtre reste sans effet en administration, où la langue de l'interface
 * relève du choix de chaque utilisateur.
 */
function tfp_force_locale_fr( $locale ) {
	return is_admin() ? $locale : 'fr_FR';
}
add_filter( 'locale', 'tfp_force_locale_fr' );

/**
 * Retire les liens de découverte oEmbed.
 *
 * WordPress publie sur chaque page deux `<link rel="alternate" type="application/json+oembed">`
 * pointant vers `/wp-json/oembed/1.0/embed?url=…`, l'URL de la page étant encodée en paramètre.
 * Aucun contenu de ce site n'est destiné à être intégré ailleurs : ces liens n'apportent rien, et
 * ils dupliquent l'URL absolue du site dans le HTML — d'où 104 occurrences de l'hôte du bac
 * d'essai dans l'export d'audit. Les retirer supprime la fuite à sa source plutôt qu'au moment de
 * l'export.
 */
function tfp_disable_oembed_discovery() {
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

	/*
	 * Flux de commentaires : les commentaires sont désactivés sur l'ensemble du site. WordPress
	 * publiait pourtant sur chaque page un lien de découverte vers un flux de commentaires vide,
	 * global et par article. Ce sont des URL qui n'ont pas de contenu à servir.
	 *
	 * Le flux principal du site, lui, est conservé : trois articles y sont publiés, et un flux est
	 * la façon normale de les suivre.
	 */
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// `feed_links()` publie aussi le flux global des commentaires : ce filtre est le seul point qui
	// le supprime sans retirer le flux du site.
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
}
add_action( 'init', 'tfp_disable_oembed_discovery' );
