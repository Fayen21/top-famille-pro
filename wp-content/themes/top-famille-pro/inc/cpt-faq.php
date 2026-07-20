<?php
/**
 * CPT "FAQ" natif : le titre est la question, le contenu (éditeur de blocs)
 * est la réponse. Une taxonomie associe chaque question à une ou plusieurs
 * pages, pour réutiliser une même question sur plusieurs pages sans la
 * dupliquer. Aucune dépendance à ACF.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_cpt_faq() {
	register_post_type(
		'tfp_faq',
		array(
			'labels'       => array(
				'name'          => __( 'FAQ', 'top-famille-pro' ),
				'singular_name' => __( 'Question', 'top-famille-pro' ),
				'add_new_item'  => __( 'Ajouter une question', 'top-famille-pro' ),
				'edit_item'     => __( 'Modifier la question', 'top-famille-pro' ),
				'all_items'     => __( 'FAQ', 'top-famille-pro' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-editor-help',
			'supports'     => array( 'title', 'editor', 'page-attributes' ),
			'menu_position'=> 61,
		)
	);

	register_taxonomy(
		'faq_page',
		'tfp_faq',
		array(
			'labels'            => array(
				'name'          => __( 'Pages associées', 'top-famille-pro' ),
				'singular_name' => __( 'Page associée', 'top-famille-pro' ),
			),
			'hierarchical'      => false,
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_faq' );

/**
 * Crée les termes de page une seule fois (idempotent), pour que
 * l'administrateur les trouve prêts à cocher dans l'écran d'édition FAQ.
 */
function tfp_seed_faq_page_terms() {
	if ( get_option( 'tfp_faq_terms_seeded' ) ) {
		return;
	}
	$termes = array(
		'accueil'               => 'Accueil',
		'nettoyage-de-bureaux'  => 'Nettoyage de bureaux',
		'tarifs'                => 'Tarifs',
		'entreprise-nettoyage-dijon' => 'Entreprise de nettoyage à Dijon',
	);
	foreach ( $termes as $slug => $nom ) {
		if ( ! term_exists( $slug, 'faq_page' ) ) {
			wp_insert_term( $nom, 'faq_page', array( 'slug' => $slug ) );
		}
	}
	update_option( 'tfp_faq_terms_seeded', 1 );
}
add_action( 'init', 'tfp_seed_faq_page_terms', 20 );

/**
 * Retourne les questions/réponses associées à une page, dans l'ordre
 * défini par l'administrateur (attribut "ordre" natif de WordPress).
 */
function tfp_get_faq_pour_page( $slug_page ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'tfp_faq',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'faq_page',
					'field'    => 'slug',
					'terms'    => $slug_page,
				),
			),
		)
	);

	$faq = array();
	foreach ( $query->posts as $post ) {
		$faq[] = array(
			'question' => get_the_title( $post ),
			'reponse'  => apply_filters( 'the_content', $post->post_content ),
		);
	}
	return $faq;
}
