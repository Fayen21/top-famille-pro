<?php
/**
 * Champs ACF structurés du CPT `prestation`.
 * Mêmes principes que includes/acf-fields-zone.php — voir ce fichier pour le contexte général.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Suite de champs « intitulé + texte » numérotés (bloc_1_titre / bloc_1_texte, …).
 *
 * ACF gratuit ne fournit pas le champ Repeater : les sous-blocs répétés de la maquette (huit
 * points de détail, six points d'organisation) sont donc des champs numérotés, comme les FAQ.
 * Un intitulé vide masque proprement son sous-bloc, et un intitulé de section vide masque la
 * section entière — la structure reste impossible à réordonner depuis l'administration.
 */
function tfp_acf_titled_text_fields( $key_prefix, $name_prefix, $count, $label ) {
	$fields = array();
	for ( $i = 1; $i <= $count; $i++ ) {
		$fields[] = array(
			'key'   => $key_prefix . '_' . $i . '_titre',
			'label' => $label . ' ' . $i . ' — intitulé',
			'name'  => $name_prefix . '_' . $i . '_titre',
			'type'  => 'text',
		);
		$fields[] = array(
			'key'   => $key_prefix . '_' . $i . '_texte',
			'label' => $label . ' ' . $i . ' — texte',
			'name'  => $name_prefix . '_' . $i . '_texte',
			'type'  => 'textarea',
			'rows'  => 4,
		);
	}
	return $fields;
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
					'key'          => 'field_tfp_prestation_config_1_titre',
					'label'        => 'Configuration 1 — intitulé',
					'name'         => 'config_1_titre',
					'type'         => 'text',
					'instructions' => "Bloc « Trois configurations, trois organisations » de la maquette : trois cas de figure types et le rythme correspondant. Laisser vide masque proprement toute la section.",
				),
				array(
					'key'   => 'field_tfp_prestation_config_1_texte',
					'label' => 'Configuration 1 — description',
					'name'  => 'config_1_texte',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_tfp_prestation_config_2_titre',
					'label' => 'Configuration 2 — intitulé',
					'name'  => 'config_2_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_config_2_texte',
					'label' => 'Configuration 2 — description',
					'name'  => 'config_2_texte',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_tfp_prestation_config_3_titre',
					'label' => 'Configuration 3 — intitulé',
					'name'  => 'config_3_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_config_3_texte',
					'label' => 'Configuration 3 — description',
					'name'  => 'config_3_texte',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'          => 'field_tfp_prestation_semaine_type',
					'label'        => 'Semaine type',
					'name'         => 'semaine_type',
					'type'         => 'textarea',
					'instructions' => "Exemple concret de répartition sur une semaine, explicitement indicatif. Laisser vide masque la section.",
					'rows'         => 5,
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

				/* ----------------------------------------------------------------
				 * Blocs repris intégralement de la maquette Claude Design.
				 * Le contenu est produit par tools/generate-prestations.mjs, qui le
				 * relève dans le DOM rendu du prototype : ces champs en sont le point
				 * d'entrée côté WordPress, et restent modifiables par un éditeur.
				 * ---------------------------------------------------------------- */
				array(
					'key'          => 'field_tfp_prestation_label_court',
					'label'        => 'Libellé court',
					'name'         => 'label_court',
					'type'         => 'text',
					'instructions' => 'Employé dans le fil d’Ariane, le titre de FAQ et la relance de contact — « Bureaux » plutôt que « Nettoyage de bureaux ». Vide = titre complet.',
				),
				array(
					'key'          => 'field_tfp_prestation_nav_label',
					'label'        => 'Libellé de navigation',
					'name'         => 'nav_label',
					'type'         => 'text',
					'instructions' => 'Employé dans les menus et le pied de page — « Cabinets & professions libérales » plutôt que « Nettoyage de cabinets ». Vide = titre complet.',
				),
				array(
					'key'   => 'field_tfp_prestation_hero_alt',
					'label' => 'Visuel du hero — texte alternatif',
					'name'  => 'hero_alt',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_tfp_prestation_maillage_texte',
					'label'        => 'Phrase de maillage (sous la réponse directe)',
					'name'         => 'maillage_texte',
					'type'         => 'textarea',
					'instructions' => 'Renvoie vers la page pilier, la page tarifs, quelques villes et un article. Les liens sont posés automatiquement par le gabarit à partir des expressions reconnues.',
					'rows'         => 3,
				),
				array(
					'key'           => 'field_tfp_prestation_pour_qui_titre',
					'label'         => '« Pour qui ? » — titre',
					'name'          => 'pour_qui_titre',
					'type'          => 'text',
					'default_value' => 'Pour qui ?',
				),
				array(
					'key'          => 'field_tfp_prestation_pour_qui_items',
					'label'        => '« Pour qui ? » — liste',
					'name'         => 'pour_qui_items',
					'type'         => 'textarea',
					'instructions' => 'Un profil par ligne.',
					'rows'         => 5,
				),
				array(
					'key'   => 'field_tfp_prestation_taches_titre',
					'label' => 'Espaces et tâches — titre',
					'name'  => 'taches_titre',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_tfp_prestation_hors_prestation',
					'label'        => 'Hors prestation courante',
					'name'         => 'hors_prestation',
					'type'         => 'textarea',
					'instructions' => 'Encadré sous la liste des tâches. Distinct des exclusions générales : il vise ce qui fait l’objet d’un devis distinct, pas ce que nous ne faisons pas du tout.',
					'rows'         => 3,
				),
				array(
					'key'          => 'field_tfp_prestation_exclusions_titre',
					'label'        => 'Bloc « ce que nous ne réalisons pas » — titre',
					'name'         => 'exclusions_titre',
					'type'         => 'text',
					'instructions' => 'Section propre, distincte de la note « hors prestation courante ». La maquette ne la porte que sur les cabinets et professions libérales, là où l’ambiguïté coûte cher (bio-nettoyage, DASRI, stérilisation). Vide = section masquée.',
				),
				array(
					'key'   => 'field_tfp_prestation_exclusions_intro',
					'label' => 'Bloc « ce que nous ne réalisons pas » — introduction',
					'name'  => 'exclusions_intro',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'          => 'field_tfp_prestation_exclusions_items',
					'label'        => 'Bloc « ce que nous ne réalisons pas » — liste',
					'name'         => 'exclusions_items',
					'type'         => 'textarea',
					'instructions' => 'Un élément par ligne.',
					'rows'         => 6,
				),
				array(
					'key'   => 'field_tfp_prestation_situations_titre',
					'label' => 'Situations concrètes — titre',
					'name'  => 'situations_titre',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_tfp_prestation_situations_items',
					'label'        => 'Situations concrètes — constats',
					'name'         => 'situations_items',
					'type'         => 'textarea',
					'instructions' => 'Un constat par ligne.',
					'rows'         => 4,
				),
				array(
					'key'           => 'field_tfp_prestation_situations_exemple_label',
					'label'         => 'Situations concrètes — libellé de l’encadré',
					'name'          => 'situations_exemple_label',
					'type'          => 'text',
					'default_value' => 'Exemple de planning',
				),
				array(
					'key'   => 'field_tfp_prestation_situations_exemple',
					'label' => 'Situations concrètes — exemple mis en avant',
					'name'  => 'situations_exemple',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_tfp_prestation_configs_titre',
					'label' => 'Configurations — titre de section',
					'name'  => 'configs_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_configs_intro',
					'label' => 'Configurations — introduction',
					'name'  => 'configs_intro',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'          => 'field_tfp_prestation_detail_titre',
					'label'        => 'Détail espace par espace — titre de section',
					'name'         => 'detail_titre',
					'type'         => 'text',
					'instructions' => 'Vide = section entièrement masquée.',
				),
				array(
					'key'   => 'field_tfp_prestation_organisation_titre',
					'label' => 'Organisation — titre de section',
					'name'  => 'organisation_titre',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_tfp_prestation_semaine_titre',
					'label'         => 'Semaine type — titre',
					'name'          => 'semaine_titre',
					'type'          => 'text',
					'default_value' => 'Une semaine type',
				),
				array(
					'key'           => 'field_tfp_prestation_limites_titre',
					'label'         => 'Limites de la prestation — titre',
					'name'          => 'limites_titre',
					'type'          => 'text',
					'default_value' => 'Les limites de la prestation',
				),
				array(
					'key'          => 'field_tfp_prestation_limites',
					'label'        => 'Limites de la prestation — texte',
					'name'         => 'limites',
					'type'         => 'textarea',
					'rows'         => 4,
				),
				array(
					'key'   => 'field_tfp_prestation_cta_titre',
					'label' => 'Bloc de conversion final — titre',
					'name'  => 'cta_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_cta_texte',
					'label' => 'Bloc de conversion final — texte',
					'name'  => 'cta_texte',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_tfp_prestation_temoignage_tab',
					'label' => 'Témoignage',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_tfp_prestation_temoignage_intro',
					'label'   => 'Témoignage',
					'name'    => 'temoignage_intro',
					'type'    => 'message',
					'message' => "Témoignage affiché à côté de l'exemple de budget, repris de la maquette Claude Design. Il est centralisé ici pour être remplacé par un avis client réel sans toucher au gabarit. Vider le texte masque la carte. Ce témoignage n'alimente aucune donnée structurée Review ou AggregateRating (CLAUDE.md §5.5).",
				),
				array(
					'key'   => 'field_tfp_prestation_temoignage_texte',
					'label' => 'Témoignage — texte',
					'name'  => 'temoignage_texte',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_tfp_prestation_temoignage_auteur',
					'label' => 'Témoignage — auteur',
					'name'  => 'temoignage_auteur',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_temoignage_role',
					'label' => 'Témoignage — fonction',
					'name'  => 'temoignage_role',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_prestation_temoignage_ville',
					'label' => 'Témoignage — ville',
					'name'  => 'temoignage_ville',
					'type'  => 'text',
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
					'key'           => 'field_tfp_prestation_faq_titre',
					'label'         => 'FAQ — titre de section',
					'name'          => 'faq_titre',
					'type'          => 'text',
					'default_value' => 'Questions fréquentes',
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
			'key'      => 'group_tfp_prestation_detail',
			'title'    => 'Prestation — le détail, espace par espace',
			'fields'   => tfp_acf_titled_text_fields( 'field_tfp_prestation_detail', 'detail', 9, 'Point' ),
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
			'key'      => 'group_tfp_prestation_organisation',
			'title'    => 'Prestation — organisation, du planning au suivi',
			'fields'   => tfp_acf_titled_text_fields( 'field_tfp_prestation_organisation', 'organisation', 6, 'Point' ),
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
