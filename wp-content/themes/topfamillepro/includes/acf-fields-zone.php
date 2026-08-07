<?php
/**
 * Champs ACF structurés du CPT `zone`.
 *
 * Enregistrés en PHP (acf_add_local_field_group), pas via l'export JSON/UI d'ACF : la source
 * de vérité vit dans le dépôt Git, pas dans la base de données WordPress — cohérent avec
 * CLAUDE.md §3 (ACF plutôt que blocs natifs, pour une structure impossible à casser).
 *
 * La structure ci-dessous couvre les trois niveaux (département / ville / commune) avec des
 * champs conditionnels sur `niveau`. Le contenu réel des 26 zones est saisi en phase 2 ; cette
 * déclaration pose uniquement les champs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_acf_fields_zone() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return; // Plugin ACF non actif — pas d'erreur fatale, juste pas de champs déclarés.
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_tfp_zone',
			'title'    => 'Zone — contenu structuré',
			'fields'   => array(
				array(
					'key'           => 'field_tfp_zone_niveau',
					'label'         => 'Niveau',
					'name'          => 'niveau',
					'type'          => 'select',
					'instructions'  => 'Détermine le gabarit et les champs affichés ci-dessous.',
					'required'      => 1,
					'choices'       => array(
						'departement' => 'Département',
						'ville'       => 'Ville principale',
						'commune'     => 'Commune secondaire (non validée par défaut)',
					),
					'default_value' => 'ville',
				),
				array(
					'key'               => 'field_tfp_zone_statut_validation',
					'label'             => 'Zone validée par Audrey',
					'name'              => 'statut_validation',
					'type'              => 'true_false',
					'instructions'      => "Communes secondaires uniquement (CLAUDE.md §5.4) : décoché = noindex,follow tant qu'Audrey n'a pas confirmé que la commune est réellement desservie. Départements et villes principales sont toujours considérés comme validés.",
					'default_value'     => 0,
					'ui'                => 1,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_tfp_zone_niveau',
								'operator' => '==',
								'value'    => 'commune',
							),
						),
					),
				),
				array(
					'key'          => 'field_tfp_zone_code_postal',
					'label'        => 'Code postal',
					'name'         => 'code_postal',
					'type'         => 'text',
					'instructions' => 'Ville ou commune uniquement. Jamais inventé — laisser vide si non confirmé.',
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_tfp_zone_niveau',
								'operator' => '!=',
								'value'    => 'departement',
							),
						),
					),
				),
				array(
					'key'          => 'field_tfp_zone_reponse_directe',
					'label'        => 'Réponse directe',
					'name'         => 'reponse_directe',
					'type'         => 'textarea',
					'instructions' => "Paragraphe d'ouverture répondant immédiatement à l'intention de recherche (« entreprise de nettoyage à {ville} »). Jamais de distance, délai ou fréquence non confirmés (CLAUDE.md §5.1).",
					'rows'         => 3,
				),
				array(
					'key'          => 'field_tfp_zone_secteur_economique',
					'label'        => 'Tissu économique du secteur',
					'name'         => 'secteur_economique',
					'type'         => 'textarea',
					'instructions' => "Ce qui différencie réellement cette page des autres pages du même niveau (types de locaux dominants du secteur, contexte local) — jamais un prix différent (CLAUDE.md §5.3).",
					'rows'         => 3,
				),
				array(
					'key'          => 'field_tfp_zone_exclusions_rappel',
					'label'        => 'Rappel des exclusions',
					'name'         => 'exclusions_rappel',
					'type'         => 'true_false',
					'instructions' => 'Affiche le rappel standard : locaux industriels, alimentaires et médicaux nécessitant une asepsie complète ne sont pas couverts (PROJECT_INPUTS.md §4).',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'          => 'field_tfp_zone_materiel_rappel',
					'label'        => 'Rappel matériel fourni par le client',
					'name'         => 'materiel_rappel',
					'type'         => 'true_false',
					'instructions' => 'Affiche le rappel standard : le matériel et les produits sont fournis par le client (PROJECT_INPUTS.md §4).',
					'default_value' => 1,
					'ui'            => 1,
				),
				array(
					'key'          => 'field_tfp_zone_communes_proches',
					'label'        => 'Villes / communes proches (maillage)',
					'name'         => 'communes_proches',
					'type'         => 'relationship',
					'instructions' => 'Zones vers lesquelles lier depuis cette page (maillage interne, CLAUDE.md §8).',
					'post_type'    => array( 'zone' ),
					'filters'      => array( 'search' ),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_tfp_zone_niveau',
								'operator' => '!=',
								'value'    => 'departement',
							),
						),
					),
				),
				array(
					'key'          => 'field_tfp_zone_prestations_liees',
					'label'        => 'Prestations mises en avant',
					'name'         => 'prestations_liees',
					'type'         => 'relationship',
					'instructions' => 'Prestations vers lesquelles lier depuis cette page (maillage interne).',
					'post_type'    => array( 'prestation' ),
				),
				array(
					'key'          => 'field_tfp_zone_faq',
					'label'        => 'FAQ locale',
					'name'         => 'faq',
					'type'         => 'repeater',
					'instructions' => "Affichée uniquement si au moins une question est renseignée — sinon, pas de FAQPage en JSON-LD (CLAUDE.md §8).",
					'layout'       => 'block',
					'button_label' => 'Ajouter une question',
					'sub_fields'   => array(
						array(
							'key'  => 'field_tfp_zone_faq_q',
							'label' => 'Question',
							'name' => 'question',
							'type' => 'text',
						),
						array(
							'key'  => 'field_tfp_zone_faq_a',
							'label' => 'Réponse',
							'name' => 'reponse',
							'type' => 'textarea',
							'rows' => 3,
						),
					),
				),
				array(
					'key'   => 'field_tfp_zone_seo_tab',
					'label' => 'SEO',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_tfp_zone_seo_title',
					'label'        => 'Title (balise <title>)',
					'name'         => 'seo_title',
					'type'         => 'text',
					'instructions' => 'Laisser vide pour générer automatiquement à partir du titre de la zone. ~65 caractères max recommandé.',
					'maxlength'    => 70,
				),
				array(
					'key'          => 'field_tfp_zone_seo_description',
					'label'        => 'Meta description',
					'name'         => 'seo_description',
					'type'         => 'textarea',
					'rows'         => 2,
					'maxlength'    => 158,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'zone',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'tfp_register_acf_fields_zone' );
