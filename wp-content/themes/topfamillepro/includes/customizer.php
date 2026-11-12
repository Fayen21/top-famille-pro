<?php
/**
 * Réglages du Customizer natif WordPress — actuellement : la photo d'Audrey.
 *
 * Choix volontaire de ne PAS dépendre d'ACF ici : remplacer une photo de démonstration par la
 * vraie doit rester possible même si ACF n'est pas installé/actif. Le Customizer
 * (Apparence → Personnaliser) est du cœur WordPress, disponible dans tous les cas.
 *
 * Tant que ce réglage est vide, le gabarit affiche un visuel neutre (pastille avec l'initiale)
 * plutôt qu'une photo de stock présentée comme Audrey (docs/DONNEES-FICTIVES.md, brief phase 1 §2).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'tfp_equipe',
		array(
			'title'    => 'Équipe',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'tfp_audrey_photo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'tfp_audrey_photo',
			array(
				'label'       => "Photo d'Audrey",
				'description' => "Remplace le visuel neutre (pastille) affiché sur l'accueil tant qu'aucune photo réelle n'est fournie. Ne jamais mettre une photo de stock ici : ce champ doit rester vide jusqu'à réception de la vraie photo (PROJECT_INPUTS.md, question ouverte #7).",
				'section'     => 'tfp_equipe',
				'settings'    => 'tfp_audrey_photo',
			)
		)
	);
}
add_action( 'customize_register', 'tfp_customize_register' );

/**
 * URL de la photo d'Audrey : celle renseignée dans le Customizer si elle existe, sinon un visuel
 * d'illustration temporaire (assets/dist/images, slug 'audrey-placeholder') — jamais présenté
 * comme Audrey dans les gabarits, qui doivent utiliser tfp_audrey_photo_is_real() pour afficher
 * l'alt et la mention honnêtes appropriés (CLAUDE.md §5.6). Un seul point de bascule : une fois
 * la vraie photo renseignée dans le Customizer, elle remplace automatiquement le placeholder
 * partout où cette fonction est appelée.
 *
 * @return string
 */
/**
 * @param string $slug Slot de repli. La maquette n'emploie PAS le même visuel d'illustration
 *                     partout : `audrey-portrait` (800×1007) sur l'accueil et dans la bande
 *                     « Cahier des charges » du pilier, `audrey-placeholder` (800×1198) sur
 *                     /a-propos/. Le contrôle par nombre d'images ne voyait pas la différence ;
 *                     l'audit par rôle de G26 l'a relevée sur les octets.
 */
function tfp_get_audrey_photo_url( $slug = 'audrey-placeholder' ) {
	$real = (string) get_theme_mod( 'tfp_audrey_photo', '' );
	if ( $real ) {
		return $real;
	}
	$manifest = tfp_image_manifest();
	if ( empty( $manifest[ $slug ] ) ) {
		return '';
	}
	$entry    = $manifest[ $slug ];
	$fallback = end( $entry['variants']['jpg'] );
	return TFP_THEME_URI . '/assets/dist/images/' . $fallback['file'];
}

/**
 * True si une vraie photo d'Audrey a été renseignée dans le Customizer (pas le placeholder).
 *
 * @return bool
 */
function tfp_audrey_photo_is_real() {
	return (bool) get_theme_mod( 'tfp_audrey_photo', '' );
}

/**
 * Visuel de la gérante : sa vraie photo si elle a été fournie, sinon son monogramme.
 *
 * Décision du 13 novembre 2026 : plus aucun portrait de banque d'images à côté du nom d'Audrey, et
 * plus aucune mention « photo provisoire ». Tant que la photo authentique n'est pas saisie dans le
 * Customizer, la gérante est représentée par ses initiales — un signe, pas un visage d'emprunt
 * (CLAUDE.md §5.6). Le jour où la photo est saisie, elle prend la place du monogramme partout.
 *
 * @param string $classe Classe(s) de taille : `tfp-monogramme--sm`, `--lg`, `--xl`.
 */
function tfp_gerante_visuel( $classe = '' ) {
	$site = tfp_site_data();
	if ( tfp_audrey_photo_is_real() ) {
		printf(
			'<img class="tfp-monogramme tfp-monogramme--photo %s" src="%s" alt="%s" width="160" height="160" loading="lazy" decoding="async">',
			esc_attr( $classe ),
			esc_url( get_theme_mod( 'tfp_audrey_photo', '' ) ),
			esc_attr( $site['manager'] . ', gérante de ' . $site['brand_name'] )
		);
		return;
	}
	$initiales = '';
	foreach ( preg_split( '/\s+/', trim( $site['manager'] ) ) as $mot ) {
		$initiales .= mb_substr( $mot, 0, 1 );
	}
	printf( '<span class="tfp-monogramme %s" aria-hidden="true">%s</span>', esc_attr( $classe ), esc_html( mb_strtoupper( $initiales ) ) );
}
