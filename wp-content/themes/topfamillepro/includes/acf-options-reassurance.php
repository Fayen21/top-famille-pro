<?php
/**
 * Page d'options ACF « Réassurance & avis » — seule source des avis, de la note et du lien
 * Google affichés sur le site. Vide par défaut : tant qu'Audrey/Emmanuel n'ont pas fourni les
 * vraies valeurs (PROJECT_INPUTS.md, questions ouvertes #6/#7), tous les champs restent vides
 * et les gabarits doivent masquer proprement les blocs correspondants plutôt que d'inventer une
 * valeur (docs/DONNEES-FICTIVES.md — c'est le mécanisme qui empêche techniquement une régression
 * vers les 40 avis de démonstration du prototype).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_acf_options_reassurance() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => 'Réassurance & avis',
			'menu_title' => 'Réassurance & avis',
			'menu_slug'  => 'tfp-reassurance',
			'capability' => 'edit_posts',
			'icon_url'   => 'dashicons-star-filled',
			'position'   => 60,
		)
	);

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_tfp_reassurance',
			'title'  => 'Réassurance & avis',
			'fields' => array(
				array(
					'key'   => 'field_tfp_google_tab',
					'label' => 'Fiche Google',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_tfp_google_url',
					'label'        => 'URL de la fiche Google Business',
					'name'         => 'google_url',
					'type'         => 'url',
					'instructions' => 'Laisser vide tant que non fournie. Aucun lien "Voir les avis" ne doit être affiché sans cette URL réelle.',
				),
				array(
					'key'          => 'field_tfp_google_note',
					'label'        => 'Note réelle (sur 5)',
					'name'         => 'note',
					'type'         => 'number',
					'min'          => 0,
					'max'          => 5,
					'step'         => 0.1,
					'instructions' => 'Laisser vide tant que non confirmée. Ne jamais utiliser 5,0 par défaut.',
				),
				array(
					'key'   => 'field_tfp_google_nombre_avis',
					'label' => "Nombre d'avis réel",
					'name'  => 'nombre_avis',
					'type'  => 'number',
					'min'   => 0,
					'instructions' => 'Laisser vide tant que non confirmé. Ne jamais utiliser 47 par défaut.',
				),
				array(
					'key'   => 'field_tfp_avis_tab',
					'label' => 'Avis authentiques',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_tfp_avis',
					'label'        => 'Avis clients authentiques',
					'name'         => 'avis',
					'type'         => 'repeater',
					'instructions' => 'Uniquement les six témoignages authentiques déjà publiés sur le site actuel (CLAUDE.md §5.5) — Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie — ou de nouveaux avis Google réellement reçus. Jamais un avis inventé, jamais un avis B2C Top-Famille présenté comme un avis B2B Top-Famille Pro.',
					'layout'       => 'block',
					'button_label' => 'Ajouter un avis authentique',
					'sub_fields'   => array(
						array(
							'key'   => 'field_tfp_avis_nom',
							'label' => 'Nom (tel que publié)',
							'name'  => 'nom',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_tfp_avis_texte',
							'label' => 'Texte de l\'avis',
							'name'  => 'texte',
							'type'  => 'textarea',
							'rows'  => 3,
						),
						array(
							'key'   => 'field_tfp_avis_note',
							'label' => 'Note (sur 5)',
							'name'  => 'note',
							'type'  => 'number',
							'min'   => 1,
							'max'   => 5,
						),
						array(
							'key'   => 'field_tfp_avis_contexte',
							'label' => 'Contexte (rôle · type de local)',
							'name'  => 'contexte',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_tfp_avis_source',
							'label' => 'Source',
							'name'  => 'source',
							'type'  => 'text',
							'placeholder' => 'Ex. Google, site historique topentreprise.fr…',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'tfp-reassurance',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'tfp_register_acf_options_reassurance' );

/**
 * Retourne les données de réassurance réelles, ou des valeurs vides — jamais une valeur
 * fictive de repli. À utiliser partout où le prototype affichait la note/les avis démo.
 *
 * @return array{google_url: string, note: float|null, nombre_avis: int|null, avis: array}
 */
function tfp_reassurance_data() {
	if ( ! function_exists( 'get_field' ) ) {
		return array(
			'google_url'  => '',
			'note'        => null,
			'nombre_avis' => null,
			'avis'        => array(),
		);
	}

	return array(
		'google_url'  => (string) get_field( 'google_url', 'option' ),
		'note'        => get_field( 'note', 'option' ) ?: null,
		'nombre_avis' => get_field( 'nombre_avis', 'option' ) ?: null,
		'avis'        => (array) get_field( 'avis', 'option' ),
	);
}
