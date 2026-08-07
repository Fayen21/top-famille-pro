<?php
/**
 * CPT `zone` — 26 entrées (8 départements + 10 villes + 8 communes secondaires), un seul type
 * de contenu pour les trois niveaux, distingués par le champ ACF `niveau`
 * (includes/acf-fields-zone.php) et une relation hiérarchique vers la taxonomie `departement`.
 * Décision d'architecture : CLAUDE.md §3 / STATUS.md §7 (phase 0).
 *
 * URL réelles (phase 2, docs/INVENTAIRE-ROUTES.md) :
 * - département : /zones-intervention/{departement}/
 * - ville ou commune : /zones-intervention/{departement}/{ville}/
 *
 * WordPress ne sait pas générer nativement cette imbrication à deux niveaux pour un seul CPT à
 * partir d'un simple `rewrite.slug` : les règles de réécriture et la génération du permalien
 * sont donc entièrement personnalisées ci-dessous (`tfp_zone_rewrite_rules`,
 * `tfp_zone_permalink`), avec un canonique 301 si l'URL demandée ne correspond pas au vrai
 * département de la zone (jamais deux URL valides pour la même page).
 *
 * Le hub (/zones-intervention/) et la page région (/zones-intervention/bourgogne-franche-comte/)
 * sont des Pages WordPress classiques, pas des entrées de ce CPT.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_cpt_zone() {
	register_post_type(
		'zone',
		array(
			'labels'          => array(
				'name'          => __( 'Zones', 'topfamillepro' ),
				'singular_name' => __( 'Zone', 'topfamillepro' ),
				'add_new_item'  => __( 'Ajouter une zone', 'topfamillepro' ),
				'edit_item'     => __( 'Modifier la zone', 'topfamillepro' ),
				'all_items'     => __( 'Toutes les zones', 'topfamillepro' ),
				'menu_name'     => __( 'Zones', 'topfamillepro' ),
			),
			'public'          => true,
			'has_archive'     => false, // Le hub /zones-intervention/ est une Page classique, pas l'archive du CPT.
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-location-alt',
			'menu_position'   => 22,
			'rewrite'         => false, // Réécriture entièrement personnalisée ci-dessous (imbrication à 2 niveaux).
			'query_var'       => 'zone',
			'supports'        => array( 'title', 'revisions' ),
			'hierarchical'    => false,
			'capability_type' => 'page',
			'map_meta_cap'    => true,
		)
	);

	register_taxonomy(
		'departement',
		'zone',
		array(
			'labels'            => array(
				'name'          => __( 'Départements', 'topfamillepro' ),
				'singular_name' => __( 'Département', 'topfamillepro' ),
			),
			'public'            => false, // Pas d'archive de taxonomie publique : la page département réelle est l'entrée `zone` de niveau "departement".
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_zone' );

/**
 * Règles de réécriture personnalisées : imbrication à 2 niveaux pour les zones.
 */
function tfp_zone_rewrite_rules() {
	add_rewrite_rule(
		'^zones-intervention/([^/]+)/([^/]+)/?$',
		'index.php?zone=$matches[2]',
		'top'
	);
	add_rewrite_rule(
		'^zones-intervention/([^/]+)/?$',
		'index.php?zone=$matches[1]',
		'top'
	);
}
add_action( 'init', 'tfp_zone_rewrite_rules' );

/**
 * Génère le permalien réel d'une zone : /zones-intervention/{departement}/ pour un département,
 * /zones-intervention/{departement}/{postname}/ pour une ville ou une commune.
 */
function tfp_zone_permalink( $post_link, $post ) {
	if ( 'zone' !== $post->post_type ) {
		return $post_link;
	}

	$terms = get_the_terms( $post, 'departement' );
	$dept_slug = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->slug : $post->post_name;
	$niveau    = function_exists( 'get_field' ) ? get_field( 'niveau', $post->ID ) : get_post_meta( $post->ID, 'niveau', true );

	if ( 'departement' === $niveau ) {
		return home_url( '/zones-intervention/' . $dept_slug . '/' );
	}

	return home_url( '/zones-intervention/' . $dept_slug . '/' . $post->post_name . '/' );
}
add_filter( 'post_type_link', 'tfp_zone_permalink', 10, 2 );

/**
 * Canonicalise l'URL réellement demandée par rapport au vrai département de la zone affichée :
 * une zone n'a jamais deux URL valides. Si le premier segment ne correspond pas, redirection 301
 * vers l'URL canonique plutôt qu'un contenu dupliqué accessible sous plusieurs chemins.
 */
function tfp_zone_canonical_redirect() {
	if ( ! is_singular( 'zone' ) ) {
		return;
	}

	global $wp;
	$post      = get_queried_object();
	$canonical = tfp_zone_permalink( '', $post );
	$requested = home_url( add_query_arg( array(), $wp->request ) ) . '/';

	if ( untrailingslashit( $requested ) !== untrailingslashit( $canonical ) ) {
		wp_safe_redirect( $canonical, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'tfp_zone_canonical_redirect', 5 );

/**
 * Retrouve l'entrée `zone` de niveau "departement" portant le slug de département donné
 * (le terme de taxonomie `departement` porte le même slug que le post département).
 *
 * @param string $dept_slug
 * @return WP_Post|null
 */
function tfp_get_zone_by_department_slug( $dept_slug ) {
	$posts = get_posts(
		array(
			'post_type'   => 'zone',
			'name'        => $dept_slug,
			'numberposts' => 1,
			'meta_key'    => 'niveau',
			'meta_value'  => 'departement',
		)
	);
	return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Flush des règles de réécriture à l'activation du thème (les add_rewrite_rule() ci-dessus ne
 * prennent effet dans .htaccess/la table d'options qu'après un flush).
 */
function tfp_flush_rewrite_rules_on_activation() {
	tfp_register_cpt_zone();
	tfp_zone_rewrite_rules();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tfp_flush_rewrite_rules_on_activation' );
