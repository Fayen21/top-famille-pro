<?php
/**
 * SEO technique : title, meta description, canonical, Open Graph, Twitter Card, JSON-LD.
 *
 * Un gabarit appelle tfp_seo( [...] ) avant que wp_head() ne s'exécute (au tout début du
 * template, avant get_header()) pour déclarer les valeurs de LA page courante. Ce fichier se
 * charge de les rendre au bon endroit du <head>. Rien de tout cela ne doit dépendre du
 * JavaScript client (CLAUDE.md §2) : tout est émis dans le HTML initial, côté serveur.
 *
 * Le JSON-LD Organization/ProfessionalService n'utilise que des données réelles
 * (includes/site-options.php ← PROJECT_INPUTS.md). Aucune note, aucun avis agrégé, aucune
 * zone non confirmée, aucune coordonnée géographique inventée (cf. docs/DONNEES-FICTIVES.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Accesseur get/set des données SEO de la page courante.
 *
 * @param array|null $data Si fourni, définit les données. Sinon, les retourne.
 * @return array
 */
function tfp_seo( $data = null ) {
	static $seo = array();

	if ( is_array( $data ) ) {
		$seo = wp_parse_args(
			$data,
			array(
				'title'       => get_bloginfo( 'name' ),
				'description' => '',
				'type'        => 'website', // 'website' | 'article'
				'robots'      => 'index,follow',
				'breadcrumb'  => array(), // items pour tfp_breadcrumb_jsonld(), vide = pas de BreadcrumbList
				'schema'      => array(), // nœuds JSON-LD additionnels (Service, Article, FAQPage…)
			)
		);
	}

	return $seo;
}

/**
 * Filtre le <title> natif de WordPress (add_theme_support('title-tag')) pour renvoyer
 * exactement le titre déclaré par tfp_seo(), sans suffixe automatique ajouté deux fois.
 */
function tfp_filter_document_title( $title ) {
	$seo = tfp_seo();
	return ! empty( $seo['title'] ) ? $seo['title'] : $title;
}
add_filter( 'pre_get_document_title', 'tfp_filter_document_title', 20 );

/**
 * URL canonique absolue et auto-référente de la page courante.
 *
 * @return string
 */
function tfp_canonical_url() {
	global $wp;
	$site = tfp_site_data();
	return trailingslashit( untrailingslashit( $site['origin'] ) . '/' . $wp->request );
}

function tfp_render_head_meta() {
	$seo       = tfp_seo();
	$site      = tfp_site_data();
	$canonical = is_front_page() ? trailingslashit( $site['origin'] ) : tfp_canonical_url();

	if ( ! empty( $seo['description'] ) ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	}

	printf( '<meta name="robots" content="%s">' . "\n", esc_attr( $seo['robots'] ) );
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );

	// Open Graph.
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $seo['type'] ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $site['brand_name'] ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $seo['title'] ) );
	if ( ! empty( $seo['description'] ) ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	printf( '<meta property="og:locale" content="fr_FR">' . "\n" );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( trailingslashit( $site['origin'] ) . ltrim( $site['logo_path'], '/' ) ) );

	// Twitter Card.
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $seo['title'] ) );
	if ( ! empty( $seo['description'] ) ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	}
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( trailingslashit( $site['origin'] ) . ltrim( $site['logo_path'], '/' ) ) );

	tfp_render_jsonld( $seo, $canonical );
}
add_action( 'wp_head', 'tfp_render_head_meta', 5 );

/**
 * Construit et affiche le graphe JSON-LD : Organization/ProfessionalService + WebSite
 * toujours présents, WebPage de la page courante, BreadcrumbList si déclaré, et tout schéma
 * additionnel passé par le gabarit (Service, Article, FAQPage…).
 */
function tfp_render_jsonld( $seo, $canonical ) {
	$site    = tfp_site_data();
	$org_id  = trailingslashit( $site['origin'] ) . '#organisation';
	$site_id = trailingslashit( $site['origin'] ) . '#website';

	$area_served = array_map(
		function ( $name ) {
			return array(
				'@type' => 'AdministrativeArea',
				'name'  => $name,
			);
		},
		$site['departements']
	);

	$organization = array(
		'@type'       => array( 'Organization', 'ProfessionalService' ),
		'@id'         => $org_id,
		'name'        => $site['brand_name'],
		'legalName'   => $site['legal_name'],
		'url'         => trailingslashit( $site['origin'] ),
		'telephone'   => $site['phone_href'],
		'email'       => $site['email'],
		'image'       => trailingslashit( $site['origin'] ) . ltrim( $site['logo_path'], '/' ),
		'logo'        => trailingslashit( $site['origin'] ) . ltrim( $site['logo_path'], '/' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $site['address_street'],
			'postalCode'      => $site['address_cp'],
			'addressLocality' => $site['address_city'],
			'addressRegion'   => $site['address_region'],
			'addressCountry'  => $site['address_country'],
		),
		'areaServed'  => $area_served,
		'priceRange'  => 'À partir de ' . $site['price_entry_display'] . ' HT/heure',
		'openingHoursSpecification' => array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $site['opening_hours']['days'],
			'opens'     => $site['opening_hours']['opens'],
			'closes'    => $site['opening_hours']['closes'],
		),
	);

	if ( ! empty( $site['same_as'] ) ) {
		$organization['sameAs'] = array_values( $site['same_as'] );
	}

	$website = array(
		'@type'     => 'WebSite',
		'@id'       => $site_id,
		'url'       => trailingslashit( $site['origin'] ),
		'name'      => $site['brand_name'],
		'inLanguage' => 'fr-FR',
		'publisher' => array( '@id' => $org_id ),
	);

	$webpage = array(
		'@type'       => 'WebPage',
		'@id'         => $canonical . '#webpage',
		'url'         => $canonical,
		'name'        => $seo['title'],
		'description' => $seo['description'],
		'isPartOf'    => array( '@id' => $site_id ),
		'about'       => array( '@id' => $org_id ),
		'inLanguage'  => 'fr-FR',
	);

	$graph = array( $organization, $website, $webpage );

	if ( ! empty( $seo['breadcrumb'] ) ) {
		$breadcrumb                = tfp_breadcrumb_jsonld( $seo['breadcrumb'], $canonical );
		$webpage['breadcrumb']     = array( '@id' => $breadcrumb['@id'] );
		$graph[2]                  = $webpage; // Remplace la webpage sans breadcrumb par la version à jour.
		$graph[]                  = $breadcrumb;
	}

	if ( ! empty( $seo['schema'] ) ) {
		$graph = array_merge( $graph, $seo['schema'] );
	}

	$jsonld = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( tfp_jsonld_decode_entities( $jsonld ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Décode les entités HTML dans toutes les valeurs texte d'un graphe JSON-LD, en profondeur.
 *
 * Les titres, extraits et libellés de fil d'Ariane passent par des filtres WordPress
 * (wptexturize via get_the_title()/get_the_excerpt()) qui remplacent par exemple une apostrophe
 * droite par l'entité HTML &#8217; — correct dans un contexte HTML, mais faux tel quel dans du
 * JSON : ce n'est pas du HTML, donc les moteurs ne décodent pas cette entité et affichent le
 * texte de l'entité au lieu du caractère. On décode donc systématiquement avant l'encodage JSON.
 *
 * @param mixed $data
 * @return mixed
 */
function tfp_jsonld_decode_entities( $data ) {
	if ( is_array( $data ) ) {
		return array_map( 'tfp_jsonld_decode_entities', $data );
	}
	if ( is_string( $data ) ) {
		return html_entity_decode( $data, ENT_QUOTES, 'UTF-8' );
	}
	return $data;
}
