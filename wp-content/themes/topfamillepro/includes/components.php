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
