<?php
/**
 * CPT `prestation` — 6 entrées (bureaux, commerces, cabinets, copropriétés, meublés, ponctuel).
 * Décision d'architecture : CLAUDE.md §3 / STATUS.md §7 (phase 0).
 *
 * L'index « Nos prestations » (/prestations/) est une page WordPress classique (pas l'archive
 * du CPT) : has_archive à false, la Page se charge à cette URL, seules les fiches individuelles
 * (/prestations/{slug}/) sont servies par ce CPT. Le contenu réel (6 entrées + template unique)
 * est construit en phase 2 — cette déclaration pose seulement la fondation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_cpt_prestation() {
	register_post_type(
		'prestation',
		array(
			'labels'              => array(
				'name'                  => __( 'Prestations', 'topfamillepro' ),
				'singular_name'         => __( 'Prestation', 'topfamillepro' ),
				'add_new_item'          => __( 'Ajouter une prestation', 'topfamillepro' ),
				'edit_item'             => __( 'Modifier la prestation', 'topfamillepro' ),
				'all_items'             => __( 'Toutes les prestations', 'topfamillepro' ),
				'menu_name'             => __( 'Prestations', 'topfamillepro' ),
			),
			'public'              => true,
			'has_archive'         => false, // L'index /prestations/ est une Page classique, pas l'archive du CPT.
			'show_in_rest'        => true, // Nécessaire pour ACF et l'édition moderne — pas de blocs Gutenberg utilisés côté contenu (champs ACF uniquement).
			'menu_icon'           => 'dashicons-admin-tools',
			'menu_position'       => 21,
			'rewrite'             => array(
				'slug'       => 'prestations',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'thumbnail', 'revisions' ),
			'hierarchical'        => false,
			'capability_type'     => 'page',
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_prestation' );
