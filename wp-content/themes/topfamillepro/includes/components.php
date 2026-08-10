<?php
/**
 * Composants globaux réutilisables (rendu PHP) : bouton, badge de réassurance.
 * Les composants purement structurels (carte, conteneur, section) sont des classes CSS
 * (.tfp-card, .tfp-container, .tfp-section — src/css/03-layout.css et 04-components.css) :
 * pas besoin d'une fonction PHP pour un <div class="…">.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiche un bouton/lien.
 *
 * @param array $args {
 *   @type string $label   Texte visible (obligatoire).
 *   @type string $href    URL (obligatoire).
 *   @type string $variant 'primary' | 'secondary' | 'copper' | 'on-primary' | 'on-dark'. Défaut 'primary'.
 *   @type string $size    '' | 'sm'. Défaut ''.
 *   @type bool   $block   Pleine largeur. Défaut false.
 *   @type string $icon    HTML brut optionnel affiché avant le label (ex. picto téléphone).
 * }
 */
function tfp_button( $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'label'   => '',
			'href'    => '#',
			'variant' => 'primary',
			'size'    => '',
			'block'   => false,
			'icon'    => '',
		)
	);

	$classes = array( 'tfp-btn', 'tfp-btn--' . $args['variant'] );
	if ( $args['size'] ) {
		$classes[] = 'tfp-btn--' . $args['size'];
	}
	if ( $args['block'] ) {
		$classes[] = 'tfp-btn--block';
	}

	printf(
		'<a class="%1$s" href="%2$s">%3$s%4$s</a>',
		esc_attr( implode( ' ', $classes ) ),
		esc_url( $args['href'] ),
		$args['icon'], // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML de picto contrôlé en interne, jamais de donnée utilisateur.
		esc_html( $args['label'] )
	);
}

/**
 * Affiche un élément de réassurance à coche (bandeau tarifaire).
 *
 * @param string $label
 */
function tfp_check_item( $label ) {
	printf(
		'<span class="tfp-badge--check"><span class="tfp-check-icon" aria-hidden="true">✓</span>%s</span>',
		esc_html( $label )
	);
}

/**
 * Suite de sous-blocs « intitulé + texte » stockés en champs numérotés.
 *
 * Structure répétée de la maquette Claude Design : « Le détail, espace par espace » (jusqu'à 9
 * points), « Une organisation carrée, du planning au suivi » (6 points). ACF gratuit n'ayant pas
 * de champ Repeater, ces sous-blocs sont des champs numérotés ; un intitulé vide interrompt la
 * série, ce qui rend la structure impossible à trouer ou à réordonner depuis l'administration.
 *
 * @param string $prefix  Préfixe des champs (`detail`, `organisation`…).
 * @param int    $post_id
 * @param int    $max     Nombre maximum de sous-blocs lus.
 * @return array<int,array{titre:string,texte:string}>
 */
function tfp_get_titled_blocks( $prefix, $post_id, $max ) {
	$blocks = array();
	for ( $i = 1; $i <= $max; $i++ ) {
		$titre = tfp_get_field( $prefix . '_' . $i . '_titre', $post_id );
		if ( ! $titre ) {
			continue;
		}
		$blocks[] = array(
			'titre' => $titre,
			'texte' => (string) tfp_get_field( $prefix . '_' . $i . '_texte', $post_id ),
		);
	}
	return $blocks;
}

/**
 * Pose les liens internes d'une phrase de maillage, à partir d'une table expression → URL.
 *
 * La maquette rend ces phrases avec des liens en ligne (page pilier, tarifs, villes, article).
 * Stocker le HTML dans le champ ACF exposerait un éditeur à casser le balisage ; on stocke donc le
 * texte nu et on pose les liens ici. Le texte est échappé avant insertion des ancres : aucune
 * balise saisie en administration n'est interprétée.
 *
 * @param string               $text Texte nu.
 * @param array<string,string> $map  Expression exacte => URL.
 * @return string HTML prêt à l'affichage.
 */
function tfp_link_phrases( $text, array $map ) {
	$html = esc_html( $text );
	foreach ( $map as $phrase => $url ) {
		if ( ! $url || '' === $phrase ) {
			continue;
		}
		$needle = esc_html( $phrase );
		$pos    = strpos( $html, $needle );
		if ( false === $pos ) {
			continue;
		}
		$anchor = '<a href="' . esc_url( $url ) . '">' . $needle . '</a>';
		$html   = substr_replace( $html, $anchor, $pos, strlen( $needle ) );
	}
	return $html;
}

/**
 * Groupes « titre + paragraphes + liste + noms » d'une zone, stockés en champs numérotés.
 *
 * Les pages de zone de la maquette enchaînent des blocs de même forme mais en nombre variable
 * (3 à 5 selon le niveau et la ville). Les numéroter plutôt que les nommer permet à un seul
 * gabarit de servir départements, villes et communes sans branche par niveau, tout en gardant un
 * ordre non modifiable depuis l'administration.
 *
 * @param string $prefix  `recit`, `methode` ou `locaux`.
 * @param int    $post_id
 * @param int    $max
 * @return array<int,array{titre:string,textes:string[],liste:string[],noms:string[],type:string}>
 */
function tfp_get_zone_blocks( $prefix, $post_id, $max ) {
	$blocks = array();
	for ( $i = 1; $i <= $max; $i++ ) {
		$titre = tfp_get_field( $prefix . '_' . $i . '_titre', $post_id );
		if ( ! $titre ) {
			continue;
		}
		$blocks[] = array(
			'titre'  => $titre,
			'textes' => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_texte', $post_id ) ),
			'liste'  => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_liste', $post_id ) ),
			'noms'   => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_noms', $post_id ) ),
			'type'   => tfp_get_field( $prefix . '_' . $i . '_type', $post_id ) ?: 'noms',
			// « cartes » (tuile avec description) ou « liens » (rangée simple) : la maquette emploie
			// les deux pour le même groupe de prestations, selon le niveau de la page.
			'variante' => tfp_get_field( $prefix . '_' . $i . '_variante', $post_id ) ?: 'liens',
			// Numéro de la section d'origine dans la maquette : deux groupes qui la partagent
			// restent dans la même bande de fond.
			'section' => (int) tfp_get_field( $prefix . '_' . $i . '_section', $post_id ),
		);
	}
	return $blocks;
}

/**
 * Contenu d'une page statique narrative, relevé dans la maquette Claude Design.
 *
 * Stocké en option plutôt qu'en champs : ces pages sont des pages WordPress classiques
 * (CLAUDE.md §3), et un contenu de 40 blocs n'a pas à être ressaisi dans dix gabarits PHP.
 * Le contenu est produit par tools/generate-pages.mjs → bin/seed-fidelite-pages.php.
 *
 * @param string $key
 * @return array{h1:string,lede:string[],hero_alt:string,sections:array}
 */
function tfp_static_page_data( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$data = get_option( 'tfp_page_' . $key, array() );
	$cache[ $key ] = wp_parse_args(
		is_array( $data ) ? $data : array(),
		array( 'h1' => '', 'lede' => array(), 'hero_alt' => '', 'sections' => array() )
	);
	return $cache[ $key ];
}

/**
 * Traduit une route interne de la maquette (`#/nos-tarifs`) en URL réelle du site.
 *
 * Le prototype est une application à routes `#/` : aucune de ces adresses n'existe côté serveur.
 * Les recopier produirait des liens morts, ce que CLAUDE.md §8 proscrit. Une route sans équivalent
 * connu renvoie une chaîne vide, et l'appelant rend alors son libellé en texte simple.
 *
 * @param string $route
 * @return string URL absolue, ou '' si la route n'a pas d'équivalent.
 */
function tfp_route_to_url( $route ) {
	$route = preg_replace( '#[?].*$#', '', (string) $route );
	$route = rtrim( $route, '/' );

	static $fixes = array(
		'#/'                             => '/',
		'#/nettoyage-professionnel'      => '/nettoyage-professionnel/',
		'#/nos-prestations'              => '/prestations/',
		'#/nos-tarifs'                   => '/tarifs/',
		'#/zones-intervention'           => '/zones-intervention/',
		'#/bourgogne-franche-comte'      => '/zones-intervention/bourgogne-franche-comte/',
		'#/pourquoi-top-famille-pro'     => '/pourquoi-nous/',
		'#/notre-fonctionnement'         => '/notre-fonctionnement/',
		'#/avis-clients'                 => '/avis-clients/',
		'#/a-propos'                     => '/a-propos/',
		'#/recrutement'                  => '/recrutement/',
		'#/conseils'                     => '/conseils/',
		'#/demande-de-devis'             => '/demande-de-devis/',
		'#/contact'                      => '/contact/',
		'#/plan-du-site'                 => '/plan-du-site/',
		'#/mentions-legales'             => '/mentions-legales/',
		'#/politique-de-confidentialite' => '/politique-de-confidentialite/',
		'#/gestion-des-cookies'          => '/gestion-des-cookies/',
	);

	if ( isset( $fixes[ $route ] ) ) {
		return home_url( $fixes[ $route ] );
	}

	// Routes de contenu : le permalien réel est demandé à WordPress, pas reconstruit à la main —
	// une zone déplacée dans la hiérarchie garde ainsi un lien juste.
	if ( preg_match( '#^\#/service/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'prestation', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( preg_match( '#^\#/(?:ville|departement)/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'zone', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( preg_match( '#^\#/article/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'post', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( 0 === strpos( $route, 'tel:' ) || 0 === strpos( $route, 'mailto:' ) || 0 === strpos( $route, 'http' ) ) {
		return $route;
	}
	return '';
}
