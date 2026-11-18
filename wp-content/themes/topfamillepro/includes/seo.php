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

	// Favicon (absent jusqu'au hotfix de fidélité production — généré depuis le logo carré,
	// build/optimize-images.mjs → assets/dist/images/favicon-*.png).
	$icons_base = trailingslashit( $site['origin'] ) . 'wp-content/themes/topfamillepro/assets/dist/images/';
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( $icons_base . 'favicon-32.png' ) );
	printf( '<link rel="icon" type="image/png" sizes="512x512" href="%s">' . "\n", esc_url( $icons_base . 'favicon-512.png' ) );
	printf( '<link rel="apple-touch-icon" sizes="180x180" href="%s">' . "\n", esc_url( $icons_base . 'favicon-180.png' ) );

	// Open Graph. Image dédiée 1200×630 (og-image.jpg) — le logo seul (140px) était utilisé
	// jusqu'ici, avec des proportions inadaptées à un aperçu de partage.
	$og_image = trailingslashit( $site['origin'] ) . 'wp-content/themes/topfamillepro/assets/dist/images/og-image.jpg';
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $seo['type'] ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( $site['brand_name'] ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $seo['title'] ) );
	if ( ! empty( $seo['description'] ) ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	printf( '<meta property="og:locale" content="fr_FR">' . "\n" );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $og_image ) );
	printf( '<meta property="og:image:width" content="1200">' . "\n" );
	printf( '<meta property="og:image:height" content="630">' . "\n" );

	// Twitter Card.
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $seo['title'] ) );
	if ( ! empty( $seo['description'] ) ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	}
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $og_image ) );

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
		// Identifiants d'immatriculation : uniquement les propriétés schema.org réellement
		// appropriées (taxID/vatID/foundingDate) — pas de code APE, qui n'a pas d'équivalent
		// schema.org propre (NAICS est un référentiel américain, pas transposable).
		'taxID'       => $site['legal_siret'],
		'vatID'       => $site['legal_tva_compact'],
		'foundingDate' => $site['legal_immatriculation_date_iso'],
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
		'priceRange'  => $site['price_unique_display'] . ' HT/heure (tarif unique)',
		// Point de contact unique : le seul numéro et la seule adresse e-mail de l'entreprise.
		'contactPoint' => array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer service',
			'telephone'         => $site['phone_href'],
			'email'             => $site['email'],
			'areaServed'        => 'FR',
			'availableLanguage' => 'fr',
		),
		// Métiers réellement exercés (les six prestations) : aide les moteurs et les assistants
		// conversationnels à rattacher l'entreprise aux bonnes requêtes.
		'knowsAbout'  => tfp_schema_metiers(),
		'makesOffer'  => array( tfp_schema_offre_horaire() ),
	);

	/*
	 * Horaires d'ouverture : du lundi au vendredi, 8 h – 18 h, confirmés par Emmanuel le
	 * 18 novembre 2026 (l'ancienne amplitude 6 h – 22 h n'avait jamais été confirmée et n'était
	 * pas déclarée). Ce sont les heures où l'entreprise est joignable ; les interventions peuvent
	 * avoir lieu en dehors, ce que dit le contenu visible.
	 */
	if ( ! empty( $site['opening_hours']['days'] ) ) {
		$horaires = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $site['opening_hours']['days'],
			'opens'     => $site['opening_hours']['opens'],
			'closes'    => $site['opening_hours']['closes'],
		);
		$organization['openingHoursSpecification'] = array( $horaires );
		$organization['contactPoint']['hoursAvailable'] = $horaires;
	}

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
		'@type'       => tfp_schema_type_page(),
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

	/*
	 * FAQ des pages statiques : une page dont le corps (relevé de la maquette) affiche des
	 * questions-réponses reçoit le FAQPage correspondant, construit à partir des MÊMES blocs que
	 * ceux rendus à l'écran (CLAUDE.md §8 : FAQPage uniquement si la FAQ est visible). Une page
	 * qui déclare déjà son FAQPage n'en reçoit pas un second.
	 */
	$a_deja_faq = (bool) array_filter(
		$graph,
		function ( $n ) {
			return isset( $n['@type'] ) && 'FAQPage' === $n['@type'];
		}
	);
	if ( ! $a_deja_faq && is_page() ) {
		$faq = tfp_static_faq_items( get_post_field( 'post_name', get_queried_object_id() ) );
		if ( $faq ) {
			$graph[] = array(
				'@type'      => 'FAQPage',
				'@id'        => $canonical . '#faq',
				'mainEntity' => array_map(
					function ( $item ) {
						return array(
							'@type'          => 'Question',
							'name'           => $item['q'],
							'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ),
						);
					},
					$faq
				),
			);
		}
	}

	$jsonld = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( tfp_jsonld_decode_entities( $jsonld ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/**
 * Type schema.org de la page courante : sous-type de WebPage quand il existe un type exact.
 *
 * @return string
 */
function tfp_schema_type_page() {
	if ( ! is_page() ) {
		return 'WebPage';
	}
	$types = array(
		'contact'            => 'ContactPage',
		'a-propos'           => 'AboutPage',
		'prestations'        => 'CollectionPage',
		'zones-intervention' => 'CollectionPage',
		'conseils'           => 'CollectionPage',
		'plan-du-site'       => 'CollectionPage',
	);
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	return $types[ $slug ] ?? 'WebPage';
}

/**
 * Les six métiers exercés, tels qu'intitulés sur le site.
 *
 * @return string[]
 */
function tfp_schema_metiers() {
	return array(
		'Nettoyage de bureaux',
		'Nettoyage de commerces',
		'Nettoyage de cabinets et de professions libérales',
		'Entretien de copropriétés et de parties communes',
		'Nettoyage de locations meublées',
		'Nettoyage ponctuel et remise en état',
		'Nettoyage professionnel',
	);
}

/**
 * Offre au tarif horaire unique (PROJECT_INPUTS.md §5) : le seul prix public de l'entreprise,
 * identique partout. Jamais de prix local (CLAUDE.md §5.3).
 *
 * @param string $nom Intitulé de l'offre.
 * @return array
 */
function tfp_schema_offre_horaire( $nom = '' ) {
	$site = tfp_site_data();
	return array(
		'@type'              => 'Offer',
		'name'               => $nom ? $nom : 'Nettoyage professionnel au tarif horaire unique',
		'priceCurrency'      => 'EUR',
		'price'              => number_format( (float) $site['price_unique'], 2, '.', '' ),
		'priceSpecification' => array(
			'@type'                 => 'UnitPriceSpecification',
			'price'                 => number_format( (float) $site['price_unique'], 2, '.', '' ),
			'priceCurrency'         => 'EUR',
			'unitCode'              => 'HUR',
			'unitText'              => 'heure',
			'valueAddedTaxIncluded' => false,
		),
		'seller'             => array( '@id' => trailingslashit( $site['origin'] ) . '#organisation' ),
	);
}

/**
 * Questions-réponses affichées par le corps d'une page statique (blocs `faq` du relevé).
 *
 * @param string $cle Identifiant de la page (son slug).
 * @return array Liste de { q, a } en texte brut.
 */
function tfp_static_faq_items( $cle ) {
	if ( ! $cle || ! function_exists( 'tfp_static_page_data' ) ) {
		return array();
	}
	$items   = array();
	$visiter = function ( $noeud ) use ( &$visiter, &$items ) {
		if ( ! is_array( $noeud ) ) {
			return;
		}
		if ( isset( $noeud['type'], $noeud['question'], $noeud['reponse'] ) && 'faq' === $noeud['type'] ) {
			$q = trim( wp_strip_all_tags( (string) $noeud['question'] ) );
			$r = trim( wp_strip_all_tags( (string) $noeud['reponse'] ) );
			if ( '' !== $q && '' !== $r ) {
				$items[] = array( 'q' => $q, 'a' => $r );
			}
			return;
		}
		foreach ( $noeud as $enfant ) {
			$visiter( $enfant );
		}
	};
	$visiter( tfp_static_page_data( $cle ) );
	return $items;
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
