<?php
/**
 * Champs ACF structurés du CPT `prestation`.
 * Mêmes principes que includes/acf-fields-zone.php — voir ce fichier pour le contexte général.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_acf_fields_prestation() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_tfp_prestation',
			'title'    => 'Prestation — contenu structuré',
			'fields'   => array(
				array(
					'key'   => 'field_tfp_prestation_h1',
					'label' => 'H1',
					'name'  => 'h1',
					'type'  => 'text',
					'required' => 1,
				),
				array(
					'key'   => 'field_tfp_prestation_tease',
					'label' => 'Accroche courte (cartes, listing)',
					'name'  => 'tease',
					'type'  => 'text',
					'maxlength' => 90,
				),
				array(
					'key'   => 'field_tfp_prestation_reponse_directe',
					'label' => 'Réponse directe',
					'name'  => 'reponse_directe',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_tfp_prestation_pour_qui',
					'label' => 'Pour qui',
					'name'  => 'pour_qui',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'          => 'field_tfp_prestation_taches',
					'label'        => 'Tâches incluses',
					'name'         => 'taches',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Ajouter une tâche',
					'sub_fields'   => array(
						array(
							'key'  => 'field_tfp_prestation_tache_libelle',
							'label' => 'Tâche',
							'name' => 'libelle',
							'type' => 'text',
						),
					),
				),
				array(
					'key'          => 'field_tfp_prestation_exclusions',
					'label'        => 'Exclusions réelles',
					'name'         => 'exclusions',
					'type'         => 'textarea',
					'instructions' => "Obligatoire : locaux industriels, alimentaires et médicaux nécessitant une asepsie complète (PROJECT_INPUTS.md §4). Qualifie les demandes en amont — CLAUDE.md interdit de la masquer.",
					'rows'         => 3,
					'default_value' => 'Hors locaux industriels, alimentaires, et locaux médicaux nécessitant une asepsie complète.',
				),
				array(
					'key'          => 'field_tfp_prestation_materiel_rappel',
					'label'        => 'Rappel matériel fourni par le client',
					'name'         => 'materiel_rappel',
					'type'         => 'true_false',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'          => 'field_tfp_prestation_faq',
					'label'        => 'FAQ',
					'name'         => 'faq',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => 'Ajouter une question',
					'sub_fields'   => array(
						array(
							'key'  => 'field_tfp_prestation_faq_q',
							'label' => 'Question',
							'name' => 'question',
							'type' => 'text',
						),
						array(
							'key'  => 'field_tfp_prestation_faq_a',
							'label' => 'Réponse',
							'name' => 'reponse',
							'type' => 'textarea',
							'rows' => 3,
						),
					),
				),
				array(
					'key'          => 'field_tfp_prestation_villes_prioritaires',
					'label'        => 'Villes mises en avant (maillage)',
					'name'         => 'villes_prioritaires',
					'type'         => 'relationship',
					'post_type'    => array( 'zone' ),
					'filters'      => array( 'search' ),
				),
				array(
					'key'   => 'field_tfp_prestation_seo_tab',
					'label' => 'SEO',
					'type'  => 'tab',
				),
				array(
					'key'       => 'field_tfp_prestation_seo_title',
					'label'     => 'Title (balise <title>)',
					'name'      => 'seo_title',
					'type'      => 'text',
					'maxlength' => 70,
				),
				array(
					'key'       => 'field_tfp_prestation_seo_description',
					'label'     => 'Meta description',
					'name'      => 'seo_description',
					'type'      => 'textarea',
					'rows'      => 2,
					'maxlength' => 158,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'prestation',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'tfp_register_acf_fields_prestation' );
