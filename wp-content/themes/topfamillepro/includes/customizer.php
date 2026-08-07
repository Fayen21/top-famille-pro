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
 * URL de la photo d'Audrey si elle a été renseignée dans le Customizer, sinon chaîne vide.
 *
 * @return string
 */
function tfp_get_audrey_photo_url() {
	return (string) get_theme_mod( 'tfp_audrey_photo', '' );
}
