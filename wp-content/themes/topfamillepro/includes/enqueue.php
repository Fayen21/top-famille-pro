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
 * Les feuilles de style du thème sont chargées normalement, en `<link rel="stylesheet">` bloquant
 * le rendu.
 *
 * Elles étaient jusqu'au 9 août 2026 chargées en `preload` + bascule `stylesheet` au chargement,
 * pour approcher l'effet d'un CSS critique sans extraction par gabarit. Mesure Lighthouse à
 * l'appui, c'était un mauvais compromis : la page peignait sans aucun style puis se remettait
 * entièrement en page, avec un **CLS de 1,002** — dix fois la limite acceptable de 0,1, et de très
 * loin le premier facteur de dégradation du score de performance. Lighthouse confirmait d'ailleurs
 * « aucune ressource bloquante », symptôme exact du problème.
 *
 * Le CSS complet du site pèse ~37 Ko (une seule feuille, tous gabarits confondus) : le charger
 * normalement coûte quelques dizaines de millisecondes de premier rendu et supprime la totalité du
 * décalage de mise en page. Sur l'hébergement réel, LiteSpeed le sert compressé et mis en cache.
 */

/**
 * Précharge les deux polices réellement présentes au-dessus de la ligne de flottaison.
 *
 * Poids 800 pour le titre, et non 700 : la maquette rend tous ses H1 en 800 (relevé sur les
 * 53 routes). Précharger le 700 laissait le H1 attendre un fichier non préchargé, ou pire,
 * s'afficher en gras synthétique — plus large que la vraie graisse 800, donc avec un décalage
 * au remplacement.
 *
 * **Le corps de texte compte autant que le titre.** Le H1 seul était préchargé, et le hero
 * mesurait 76 px de moins avec Hanken Grotesk qu'avec la police système de repli : accroche,
 * boutons et pastilles se replaçaient tous au remplacement. Comme le hero est centré
 * verticalement, ces 76 px déplaçaient aussi le visuel — d'où un CLS de 0,255 sur une page de
 * ville en profil bureau, très au-dessus de la cible de 0,010. Un préchargement inutile retarde
 * ce qui en a besoin ; celui-ci sert le premier écran de chacune des 53 routes.
 */
function tfp_preload_fonts() {
	/*
	 * DEUX fichiers, et toutes les graisses.
	 *
	 * Les deux familles sont des polices variables : un seul fichier par famille porte 400 à 800.
	 * Il en était téléchargé jusqu'à SEPT — le même fichier variable, servi sous sept noms — parce
	 * que Google, interrogé graisse par graisse, renvoie quinze déclarations pointant toutes vers
	 * le même woff2. Cela pesait 264 Ko sur les 341 Ko de l'accueil, soit 78 % du poids de la page
	 * pour deux polices, et c'était le premier facteur du LCP mobile.
	 *
	 * Le préchargement reste indispensable, et pour la raison mesurée en G24 : sans lui, l'en-tête
	 * passe de 48 à 73 px au remplacement de police et toute la page remonte de 25 px — un CLS de
	 * 0,25. Deux fichiers suffisent désormais à couvrir ce que quatre couvraient, et ils couvrent
	 * même davantage : toutes les graisses du premier écran arrivent ensemble.
	 *
	 * Seul le sous-ensemble `latin` est préchargé. `latin-ext` ne sert qu'aux caractères qui en
	 * relèvent, que le premier écran ne contient pas ; le navigateur ne le charge d'ailleurs que
	 * s'il en rencontre un.
	 */
	$polices = array(
		'bricolage-grotesque-variable-latin.woff2',
		'hanken-grotesk-variable-latin.woff2',
	);
	foreach ( $polices as $fichier ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin="anonymous">' . "\n",
			esc_url( TFP_THEME_URI . '/assets/dist/fonts/' . $fichier )
		);
	}
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
