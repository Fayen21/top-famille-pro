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
