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
					'type'         => 'textarea',
					'instructions' => "Une tâche par ligne. Champ texte simple plutôt qu'un Repeater : ACF gratuit ne fournit pas ce type de champ (cf. STATUS.md). À découper avec tfp_get_lines( get_field('taches') ).",
					'rows'         => 8,
				),
				array(
					'key'          => 'field_tfp_prestation_problemes',
					'label'        => 'Situations concrètes traitées',
					'name'         => 'problemes',
					'type'         => 'textarea',
					'instructions' => 'Une situation par ligne (ex. « Une salle de réunion utilisée toute la journée… »).',
					'rows'         => 4,
				),
				array(
					'key'          => 'field_tfp_prestation_organisation',
					'label'        => 'Organisation (matériel, accès, intervenant, suivi)',
					'name'         => 'organisation',
					'type'         => 'textarea',
					'instructions' => "Paragraphe libre couvrant produits/matériel, accès et clés, sélection de l'intervenant, suivi et gestion des absences — condensé plutôt qu'un champ par sous-thème, pour garder le formulaire gérable (cf. STATUS.md, phase 2).",
					'rows'         => 6,
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
					'key'          => 'field_tfp_prestation_villes_prioritaires',
					'label'        => 'Villes mises en avant (maillage)',
					'name'         => 'villes_prioritaires',
					'type'         => 'relationship',
					'post_type'    => array( 'zone' ),
					'filters'      => array( 'search' ),
				),
				array(
					'key'   => 'field_tfp_prestation_faq_tab',
					'label' => 'FAQ',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_tfp_prestation_faq_intro',
					'label'   => 'FAQ',
					'name'    => 'faq_intro',
					'type'    => 'message',
					'message' => "Jusqu'à 8 questions ci-dessous (champs Group plutôt qu'un Repeater — ACF gratuit ne fournit pas le champ Repeater, cf. STATUS.md). N'affiche la FAQ, et n'émet le FAQPage JSON-LD, que pour les blocs dont la question est renseignée.",
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

	acf_add_local_field_group(
		array(
			'key'      => 'group_tfp_prestation_faq',
			'title'    => 'Prestation — FAQ',
			'fields'   => tfp_acf_faq_group_fields( 'field_tfp_prestation_faq', 'faq', 8 ),
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
