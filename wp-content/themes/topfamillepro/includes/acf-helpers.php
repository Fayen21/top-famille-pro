<?php
/**
 * Aide partagée pour les déclarations de champs ACF (zone, prestation).
 *
 * ACF gratuit n'inclut pas le champ Repeater (Pro uniquement — confirmé sur
 * advancedcustomfields.com/pro/ : Repeater, Flexible Content, Gallery, Clone et les pages
 * d'options sont les cinq fonctionnalités réservées à ACF PRO). Une FAQ « à nombre variable »
 * est donc modélisée par un nombre fixe de champs Group (type disponible en gratuit) plutôt
 * que par un repeater — compromis documenté dans STATUS.md.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Génère $count champs ACF de type "group" (question + réponse), pour simuler une FAQ à
 * nombre variable sans le champ Repeater (Pro). Chaque groupe est facultatif ; un gabarit ne
 * doit afficher que ceux dont la question n'est pas vide.
 *
 * @param string $key_prefix Préfixe unique de clé ACF (ex. 'field_tfp_zone_faq').
 * @param string $name_prefix Préfixe du nom de champ (ex. 'faq') → génère faq_1, faq_2, …
 * @param int    $count Nombre de blocs à générer.
 * @return array Tableau de définitions de champs ACF, à fusionner dans 'fields'.
 */
function tfp_acf_faq_group_fields( $key_prefix, $name_prefix, $count = 8 ) {
	$fields = array();

	for ( $i = 1; $i <= $count; $i++ ) {
		$fields[] = array(
			'key'        => $key_prefix . '_' . $i,
			'label'      => 'Question ' . $i,
			'name'       => $name_prefix . '_' . $i,
			'type'       => 'group',
			'instructions' => 1 === $i ? "Jusqu'à {$count} questions. Un bloc reste ignoré tant que sa question est vide — inutile de tous les remplir." : '',
			'sub_fields' => array(
				array(
					'key'   => $key_prefix . '_' . $i . '_q',
					'label' => 'Question',
					'name'  => 'question',
					'type'  => 'text',
				),
				array(
					'key'   => $key_prefix . '_' . $i . '_a',
					'label' => 'Réponse',
					'name'  => 'reponse',
					'type'  => 'textarea',
					'rows'  => 3,
				),
			),
		);
	}

	return $fields;
}

/**
 * Lit une "FAQ" enregistrée via tfp_acf_faq_group_fields() et ne retourne que les blocs dont
 * la question est renseignée — c'est cette liste filtrée qu'un gabarit doit utiliser pour
 * décider d'afficher la FAQ visuelle et le FAQPage JSON-LD associé (CLAUDE.md §8 : FAQPage
 * uniquement si la FAQ est réellement visible).
 *
 * @param string $name_prefix Même préfixe que celui passé à tfp_acf_faq_group_fields().
 * @param int    $post_id
 * @param int    $count
 * @return array Liste de ['question' => string, 'reponse' => string].
 */
function tfp_get_faq_items( $name_prefix, $post_id, $count = 8 ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$items = array();
	for ( $i = 1; $i <= $count; $i++ ) {
		$group = get_field( $name_prefix . '_' . $i, $post_id );
		if ( ! empty( $group['question'] ) ) {
			$items[] = array(
				'question' => $group['question'],
				'reponse'  => $group['reponse'] ?? '',
			);
		}
	}

	return $items;
}

/**
 * Découpe un champ texte "une valeur par ligne" (ex. field_tfp_prestation_taches) en tableau
 * propre : lignes vides retirées, espaces superflus retirés. Remplace un Repeater à une seule
 * sous-valeur (ACF gratuit ne fournit pas ce champ) par un textarea simple.
 *
 * @param string|null $raw
 * @return string[]
 */
function tfp_get_lines( $raw ) {
	if ( empty( $raw ) ) {
		return array();
	}

	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	$lines = array_map( 'trim', $lines );

	return array_values( array_filter( $lines ) );
}
