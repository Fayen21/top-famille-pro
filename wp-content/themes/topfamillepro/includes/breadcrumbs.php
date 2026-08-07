<?php
/**
 * Fil d'Ariane — composant visuel + BreadcrumbList JSON-LD associé.
 *
 * Non affiché sur l'accueil : l'accueil EST la racine du fil d'Ariane que les autres pages
 * afficheront (« Accueil / Page »), l'y répéter seul n'apporte rien à l'utilisateur ni au SEO.
 * Sera utilisé par tous les gabarits de la phase 2 (pages statiques, prestations, zones, articles).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiche le fil d'Ariane visuel.
 *
 * @param array $items Liste ordonnée ['label' => string, 'url' => string|null].
 *                      Le dernier élément (page courante) doit avoir url = null.
 */
function tfp_breadcrumb( $items ) {
	if ( empty( $items ) ) {
		return;
	}

	echo '<nav class="tfp-breadcrumb" aria-label="Fil d\'Ariane"><ol style="display:flex;flex-wrap:wrap;list-style:none;row-gap:4px;column-gap:0;padding:0;margin:0">';

	$count = count( $items );
	foreach ( $items as $index => $item ) {
		echo '<li style="display:flex;align-items:center">';
		if ( ! empty( $item['url'] ) ) {
			printf( '<a href="%s">%s</a>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
		} else {
			printf( '<span class="tfp-breadcrumb__current" aria-current="page">%s</span>', esc_html( $item['label'] ) );
		}
		if ( $index < $count - 1 ) {
			echo '<span class="tfp-breadcrumb__sep" aria-hidden="true">/</span>';
		}
		echo '</li>';
	}

	echo '</ol></nav>';
}

/**
 * Construit le graphe JSON-LD BreadcrumbList correspondant à $items (mêmes données que
 * tfp_breadcrumb(), pour rester synchronisé avec l'affichage). Émis par includes/seo.php.
 *
 * @param array  $items
 * @param string $canonical URL canonique de la page courante (@id du breadcrumb).
 * @return array
 */
function tfp_breadcrumb_jsonld( $items, $canonical ) {
	$list_items = array();
	foreach ( $items as $index => $item ) {
		$list_items[] = array(
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => $item['label'],
			'item'     => ! empty( $item['url'] ) ? $item['url'] : $canonical,
		);
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => $canonical . '#breadcrumb',
		'itemListElement' => $list_items,
	);
}
