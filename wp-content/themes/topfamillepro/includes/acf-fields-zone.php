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
					'key'          => 'field_tfp_zone_locaux_types',
					'label'        => 'Types de locaux concernés',
					'name'         => 'locaux_types',
					'type'         => 'textarea',
					'instructions' => 'Un type de local par ligne (ex. « Plateaux de bureaux et open-spaces »).',
					'rows'         => 4,
				),
				array(
					'key'          => 'field_tfp_zone_fonctionnement',
					'label'        => 'Fonctionnement réel sur cette zone',
					'name'         => 'fonctionnement',
					'type'         => 'textarea',
					'instructions' => "Comment se déroule concrètement une prestation ici (visite, cahier des charges, intervenant habituel, déplacements) — jamais un délai précis non confirmé.\n\nCe texte est le contenu **affiché** du chapitre de méthode désigné ci-dessous (« Sélection, intervenant habituel et suivi » ou son équivalent sur cette zone) : le modifier ici change la page. Laissé vide, le chapitre retombe sur son texte d'origine — les deux ne s'affichent jamais ensemble. Un paragraphe par ligne.",
					'rows'         => 5,
				),
				array(
					'key'          => 'field_tfp_zone_fonctionnement_bloc',
					'label'        => 'Chapitre de méthode piloté par « Fonctionnement »',
					'name'         => 'fonctionnement_bloc',
					'type'         => 'number',
					'instructions' => "Rang du chapitre de méthode (1 à 4) dont le texte vient du champ ci-dessus. Renseigné par le seed de fidélité, à partir du chapitre que la maquette consacre au fonctionnement sur cette zone. À 0, le champ « Fonctionnement » n'est affiché nulle part — c'est l'ancien comportement, à ne pas laisser en place.",
					'min'          => 0,
					'max'          => 4,
					'default_value' => 0,
				),
				array(
					'key'          => 'field_tfp_zone_zones_desservies',
					'label'        => 'Zones réellement desservies (texte libre)',
					'name'         => 'zones_desservies',
					'type'         => 'textarea',
					'instructions' => "Un lieu par ligne. Pour un département : les villes couvertes. Pour une ville : les communes proches sans page dédiée (en plus de « Villes / communes proches » ci-dessous, qui elles ont une page).",
					'rows'         => 4,
				),
				array(
					'key'          => 'field_tfp_zone_cta_label',
					'label'        => 'Libellé du CTA contextualisé',
					'name'         => 'cta_label',
					'type'         => 'text',
					'instructions' => 'Ex. « Demander un devis en Côte-d\'Or » / « Demander un devis à Dijon ».',
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
					'key'   => 'field_tfp_zone_faq_tab',
					'label' => 'FAQ locale',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_tfp_zone_faq_intro',
					'label'        => 'FAQ locale',
					'name'         => 'faq_intro',
					'type'         => 'message',
					'message'      => "Jusqu'à 8 questions ci-dessous (champs Group plutôt qu'un Repeater — ACF gratuit ne fournit pas le champ Repeater, cf. STATUS.md). La FAQ ne s'affiche, et le FAQPage JSON-LD n'est émis, que pour les blocs dont la question est renseignée (CLAUDE.md §8).",
				),

				/* ----------------------------------------------------------------
				 * Blocs repris intégralement de la maquette Claude Design.
				 * Contenu produit par tools/generate-zones.mjs → bin/seed-fidelite-zones.php.
				 * Les trois niveaux partagent ces champs : un intitulé vide masque
				 * proprement son bloc, ce qui évite une branche par niveau.
				 * ---------------------------------------------------------------- */
				array(
					'key'   => 'field_tfp_zone_hero_lede',
					'label' => 'Hero — accroche',
					'name'  => 'hero_lede',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'          => 'field_tfp_zone_hero_alt',
					'label'        => 'Hero — texte alternatif du visuel',
					'name'         => 'hero_alt',
					'type'         => 'text',
					'instructions' => 'Vide = pas de visuel dans le hero (cas des pages département dans la maquette).',
				),
				array(
					'key'   => 'field_tfp_zone_cta_phone_label',
					'label' => 'Libellé du bouton téléphone',
					'name'  => 'cta_phone_label',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_tfp_zone_band_items',
					'label'        => 'Bandeau tarifaire — mentions cochées',
					'name'         => 'band_items',
					'type'         => 'textarea',
					'instructions' => 'Une mention par ligne. Le montant lui-même vient de includes/site-options.php.',
					'rows'         => 4,
				),
				array(
					'key'   => 'field_tfp_zone_tarif_titre',
					'label' => 'Bloc tarif — titre',
					'name'  => 'tarif_titre',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_tfp_zone_tarif_texte',
					'label'        => 'Bloc tarif — texte',
					'name'         => 'tarif_texte',
					'type'         => 'textarea',
					'instructions' => 'Un paragraphe par ligne.',
					'rows'         => 6,
				),
				array(
					'key'   => 'field_tfp_zone_exemple_label',
					'label' => 'Exemple local — intitulé',
					'name'  => 'exemple_label',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_tfp_zone_locaux_avant_tarif',
					'label'         => 'Groupes de liens précédant le bloc tarif',
					'name'          => 'locaux_avant_tarif',
					'type'          => 'number',
					'instructions'  => "Un département place ses villes avant le bloc tarifaire, une ville les place après. Ce nombre dit où couper la série de groupes de liens.",
					'default_value' => 1,
				),
				array(
					'key'   => 'field_tfp_zone_faq_titre',
					'label' => 'FAQ — titre de section',
					'name'  => 'faq_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_zone_contact_titre',
					'label' => 'Bloc contact — titre',
					'name'  => 'contact_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_zone_contact_texte',
					'label' => 'Bloc contact — texte',
					'name'  => 'contact_texte',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_tfp_zone_cta_titre',
					'label' => 'Bloc de conversion — titre',
					'name'  => 'cta_titre',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_zone_cta_texte',
					'label' => 'Bloc de conversion — texte',
					'name'  => 'cta_texte',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_zone_temoignage_tab',
					'label' => 'Témoignage',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_tfp_zone_temoignage_intro',
					'label'   => 'Témoignage',
					'name'    => 'temoignage_intro',
					'type'    => 'message',
					'message' => "Témoignage local repris de la maquette Claude Design, affiché à côté de l'exemple de budget. Provisoire : à remplacer par un avis client réel. Vider le texte masque la carte. N'alimente aucune donnée structurée Review ou AggregateRating (CLAUDE.md §5.5).",
				),
				array(
					'key'   => 'field_tfp_zone_temoignage_texte',
					'label' => 'Témoignage — texte',
					'name'  => 'temoignage_texte',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_tfp_zone_temoignage_auteur',
					'label' => 'Témoignage — auteur',
					'name'  => 'temoignage_auteur',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_tfp_zone_temoignage_role',
					'label' => 'Témoignage — fonction et ville',
					'name'  => 'temoignage_role',
					'type'  => 'text',
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

	$zone_location = array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'zone',
			),
		),
	);

	/* Blocs narratifs et groupes de liens de la maquette : champs numérotés, ordre figé. */
	foreach ( array(
		array( 'recit', 6, 'Récit', 'Chapitre' ),
		array( 'methode', 4, 'Méthode', 'Chapitre' ),
		array( 'locaux', 8, 'Groupes de liens', 'Groupe' ),
	) as $serie ) {
		list( $name, $count, $titre, $label ) = $serie;
		$fields = array();
		for ( $i = 1; $i <= $count; $i++ ) {
			$fields[] = array(
				'key'   => 'field_tfp_zone_' . $name . '_' . $i . '_titre',
				'label' => $label . ' ' . $i . ' — intitulé',
				'name'  => $name . '_' . $i . '_titre',
				'type'  => 'text',
			);
			$fields[] = array(
				'key'          => 'field_tfp_zone_' . $name . '_' . $i . '_texte',
				'label'        => $label . ' ' . $i . ' — texte',
				'name'         => $name . '_' . $i . '_texte',
				'type'         => 'textarea',
				'instructions' => 'Un paragraphe par ligne.',
				'rows'         => 5,
			);
			if ( in_array( $name, array( 'recit', 'methode' ), true ) ) {
				$fields[] = array(
					'key'          => 'field_tfp_zone_' . $name . '_' . $i . '_liste',
					'label'        => $label . ' ' . $i . ' — liste',
					'name'         => $name . '_' . $i . '_liste',
					'type'         => 'textarea',
					'instructions' => 'Un élément par ligne. Vide = pas de liste.',
					'rows'         => 5,
				);
			}
			if ( 'locaux' === $name ) {
				$fields[] = array(
					'key'           => 'field_tfp_zone_' . $name . '_' . $i . '_type',
					'label'         => $label . ' ' . $i . ' — nature',
					'name'          => $name . '_' . $i . '_type',
					'type'          => 'select',
					'choices'       => array(
						'noms'         => 'Noms simples (sans page dédiée)',
						'villes'       => 'Villes du département ou communes proches',
						'departements' => 'Départements',
						'prestations'  => 'Les six prestations',
						'liens'        => 'Renvois génériques',
					),
					'default_value' => 'noms',
				);
				$fields[] = array(
					'key'           => 'field_tfp_zone_' . $name . '_' . $i . '_section',
					'label'         => $label . ' ' . $i . ' — section d’origine',
					'name'          => $name . '_' . $i . '_section',
					'type'          => 'number',
					'instructions'  => 'Deux groupes portant le même numéro restent dans la même bande de fond, comme dans la maquette.',
					'default_value' => 0,
				);
				$fields[] = array(
					'key'          => 'field_tfp_zone_' . $name . '_' . $i . '_noms',
					'label'        => $label . ' ' . $i . ' — noms cités',
					'name'         => $name . '_' . $i . '_noms',
					'type'         => 'textarea',
					'instructions' => "Un nom par ligne. Communes ou quartiers sans page dédiée : affichés en texte, jamais en lien mort.",
					'rows'         => 6,
				);
			}
		}
		acf_add_local_field_group(
			array(
				'key'      => 'group_tfp_zone_' . $name,
				'title'    => 'Zone — ' . $titre,
				'fields'   => $fields,
				'location' => $zone_location,
			)
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_tfp_zone_faq',
			'title'    => 'Zone — FAQ locale',
			'fields'   => tfp_acf_faq_group_fields( 'field_tfp_zone_faq', 'faq', 8 ),
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

	acf_add_local_field_group(
		array(
			'key'      => 'group_tfp_zone_seo',
			'title'    => 'Zone — SEO',
			'fields'   => array(
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
