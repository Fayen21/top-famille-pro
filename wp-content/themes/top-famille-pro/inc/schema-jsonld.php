<?php
/**
 * Données structurées (JSON-LD). Chaque template appelle explicitement les
 * fonctions tfp_schema_* dont il a besoin ; rien n'est ajouté globalement
 * sauf Organization/WebSite (utiles sur toutes les pages).
 *
 * Aucune adresse locale fictive n'est créée pour les pages de villes :
 * l'adresse utilisée est toujours celle, réelle, du siège (données
 * commerciales centralisées), avec areaServed pour la couverture locale.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_ajouter_schema( array $bloc ) {
	$GLOBALS['tfp_schema_stack'][] = $bloc;
}

function tfp_schema_organization() {
	$d = tfp_get_donnees_commerciales();

	$org = array(
		'@context' => 'https://schema.org',
		'@type'    => 'ProfessionalService',
		'@id'      => home_url( '/#organisation' ),
		'name'     => 'Top-Famille Pro',
		'url'      => home_url( '/' ),
	);

	if ( $d['telephone'] ) {
		$org['telephone'] = $d['telephone'];
	}
	if ( $d['email'] ) {
		$org['email'] = $d['email'];
	}
	if ( $d['siege_adresse'] && $d['siege_ville'] ) {
		$org['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $d['siege_adresse'],
			'postalCode'      => $d['siege_code_postal'],
			'addressLocality' => $d['siege_ville'],
			'addressCountry'  => 'FR',
		);
	}

	$zones = tfp_zones_prioritaires_liste();
	if ( ! empty( $zones ) ) {
		$org['areaServed'] = array_map(
			static fn( $ville ) => array(
				'@type' => 'City',
				'name'  => $ville,
			),
			$zones
		);
	}

	return $org;
}

function tfp_schema_website() {
	return array(
		'@context' => 'https://schema.org',
		'@type'    => 'WebSite',
		'@id'      => home_url( '/#site' ),
		'name'     => 'Top-Famille Pro',
		'url'      => home_url( '/' ),
	);
}

function tfp_schema_webpage( $titre, $description = '' ) {
	$page = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'WebPage',
		'url'       => get_permalink() ?: home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ),
		'name'      => $titre,
		'isPartOf'  => array( '@id' => home_url( '/#site' ) ),
		'dateModified' => get_the_modified_date( DATE_W3C ),
	);
	if ( $description ) {
		$page['description'] = $description;
	}
	return $page;
}

/**
 * @param array $items Liste ordonnée ['name' => ..., 'url' => ...].
 */
function tfp_schema_breadcrumb( array $items ) {
	$liste = array();
	foreach ( $items as $i => $item ) {
		$liste[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item['name'],
			'item'     => $item['url'],
		);
	}
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $liste,
	);
}

function tfp_schema_service( $nom, $description, $url ) {
	return array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'serviceType' => $nom,
		'name'        => $nom,
		'description' => $description,
		'url'         => $url,
		'provider'    => array( '@id' => home_url( '/#organisation' ) ),
		'areaServed'  => array_map(
			static fn( $ville ) => array(
				'@type' => 'City',
				'name'  => $ville,
			),
			tfp_zones_prioritaires_liste()
		),
	);
}

/**
 * À n'appeler que si la FAQ correspondante est réellement visible dans la
 * page (jamais de FAQPage caché ou dupliqué).
 */
function tfp_schema_faqpage( array $faq_items ) {
	if ( empty( $faq_items ) ) {
		return null;
	}
	return array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			static fn( $item ) => array(
				'@type'          => 'Question',
				'name'           => $item['question'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $item['reponse'] ),
				),
			),
			$faq_items
		),
	);
}

function tfp_output_schema() {
	tfp_ajouter_schema( tfp_schema_organization() );
	tfp_ajouter_schema( tfp_schema_website() );

	if ( empty( $GLOBALS['tfp_schema_stack'] ) ) {
		return;
	}
	foreach ( $GLOBALS['tfp_schema_stack'] as $bloc ) {
		if ( empty( $bloc ) ) {
			continue;
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $bloc, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}
add_action( 'wp_footer', 'tfp_output_schema', 5 );
