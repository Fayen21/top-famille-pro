<?php
/**
 * CPT `zone` — 26 entrées (8 départements + 10 villes + 8 communes secondaires), un seul type
 * de contenu pour les trois niveaux, distingués par le champ ACF `niveau`
 * (includes/acf-fields-zone.php) et une relation hiérarchique vers la taxonomie `departement`.
 * Décision d'architecture : CLAUDE.md §3 / STATUS.md §7 (phase 0).
 *
 * Le hub (/zones-intervention/) et la page région (/zones-intervention/bourgogne-franche-comte/)
 * sont des Pages WordPress classiques, pas des entrées de ce CPT. L'URL imbriquée réelle
 * (/zones-intervention/{departement}/ pour un département, /zones-intervention/{departement}/{ville}/
 * pour une ville ou une commune — cf. docs/INVENTAIRE-ROUTES.md) dépend du contenu réel des 26
 * zones et sera câblée en phase 2 via des règles de réécriture dédiées, en même temps que le
 * gabarit. Cette déclaration pose la fondation : CPT, has_archive désactivé (le hub est une
 * Page), et la taxonomie `departement` qui portera la hiérarchie.
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
			'rewrite'         => array(
				'slug'       => 'zones-intervention',
				'with_front' => false,
			),
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
			'public'            => true,
			'hierarchical'      => true, // Permet une relation parent/enfant si besoin (ex. région > départements).
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'zones-intervention', 'with_front' => false ),
			// Pas d'archive de taxonomie affichée : la page département réelle est l'entrée `zone`
			// de niveau "departement", pas un gabarit d'archive de taxonomie générique.
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_zone' );
