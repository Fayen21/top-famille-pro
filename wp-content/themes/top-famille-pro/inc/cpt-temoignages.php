<?php
/**
 * CPT "Avis clients". Aucun avis n'est pré-rempli : ce fichier ne fait que
 * déclarer la structure. Seuls des avis authentiques, avec autorisation de
 * publication cochée, doivent être ajoutés par l'administrateur.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_cpt_temoignage() {
	register_post_type(
		'temoignage',
		array(
			'labels'       => array(
				'name'          => __( 'Avis clients', 'top-famille-pro' ),
				'singular_name' => __( 'Avis client', 'top-famille-pro' ),
				'add_new_item'  => __( 'Ajouter un avis', 'top-famille-pro' ),
				'edit_item'     => __( 'Modifier l\'avis', 'top-famille-pro' ),
				'all_items'     => __( 'Avis clients', 'top-famille-pro' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-star-filled',
			'supports'     => array( 'title', 'editor', 'page-attributes' ),
			'menu_position'=> 60,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_temoignage' );

function tfp_temoignage_meta_fields() {
	return array(
		'type_client'  => __( 'Type de client (ex. gérant de bureau, syndic...)', 'top-famille-pro' ),
		'type_local'   => __( 'Type de local (bureaux, commerce, copropriété...)', 'top-famille-pro' ),
		'ville'        => __( 'Ville', 'top-famille-pro' ),
		'date_avis'    => __( 'Date de l\'avis', 'top-famille-pro' ),
		'source'       => __( 'Source (Google, e-mail, questionnaire...)', 'top-famille-pro' ),
	);
}

function tfp_add_temoignage_meta_box() {
	add_meta_box(
		'tfp_temoignage_details',
		__( 'Détails de l\'avis', 'top-famille-pro' ),
		'tfp_render_temoignage_meta_box',
		'temoignage',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tfp_add_temoignage_meta_box' );

function tfp_render_temoignage_meta_box( $post ) {
	wp_nonce_field( 'tfp_save_temoignage', 'tfp_temoignage_nonce' );
	$champs = tfp_temoignage_meta_fields();
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $champs as $key => $label ) {
		$value = get_post_meta( $post->ID, '_tfp_' . $key, true );
		$type  = ( 'date_avis' === $key ) ? 'date' : 'text';
		printf(
			'<tr><th scope="row"><label for="tfp_%1$s">%2$s</label></th><td><input type="%3$s" id="tfp_%1$s" name="tfp_%1$s" value="%4$s" class="regular-text"></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $type ),
			esc_attr( $value )
		);
	}
	$autorisation = get_post_meta( $post->ID, '_tfp_autorisation_publication', true );
	printf(
		'<tr><th scope="row">%1$s</th><td><label><input type="checkbox" id="tfp_autorisation_publication" name="tfp_autorisation_publication" value="1" %2$s> %3$s</label></td></tr>',
		esc_html__( 'Autorisation de publication', 'top-famille-pro' ),
		checked( $autorisation, '1', false ),
		esc_html__( 'Le client a autorisé la publication de cet avis sur le site.', 'top-famille-pro' )
	);
	echo '</tbody></table>';
	echo '<p class="description">' . esc_html__( 'Le contenu de l\'avis se saisit dans le champ principal ci-dessus (éditeur). Le titre est le prénom ou l\'identité autorisée par le client.', 'top-famille-pro' ) . '</p>';
}

function tfp_save_temoignage_meta( $post_id ) {
	if ( ! isset( $_POST['tfp_temoignage_nonce'] ) || ! wp_verify_nonce( $_POST['tfp_temoignage_nonce'], 'tfp_save_temoignage' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( tfp_temoignage_meta_fields() ) as $key ) {
		if ( isset( $_POST[ 'tfp_' . $key ] ) ) {
			update_post_meta( $post_id, '_tfp_' . $key, sanitize_text_field( wp_unslash( $_POST[ 'tfp_' . $key ] ) ) );
		}
	}
	update_post_meta( $post_id, '_tfp_autorisation_publication', isset( $_POST['tfp_autorisation_publication'] ) ? '1' : '0' );
}
add_action( 'save_post_temoignage', 'tfp_save_temoignage_meta' );

/**
 * Retourne uniquement les avis authentiques ET explicitement autorisés à
 * la publication — jamais de contenu du prototype migré automatiquement.
 */
function tfp_get_temoignages_publies( $limite = -1 ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'temoignage',
			'posts_per_page' => $limite,
			'meta_key'       => '_tfp_autorisation_publication',
			'meta_value'     => '1',
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
		)
	);
	return $query->posts;
}
