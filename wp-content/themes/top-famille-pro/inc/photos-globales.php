<?php
/**
 * Champs administrables pour les photographies réutilisées à travers le
 * site (hors "hero" de page, qui utilise l'image mise en avant native de
 * chaque page). Stockage natif (option WordPress + médiathèque), sans ACF.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TFP_PHOTOS_OPTION', 'tfp_photos_globales' );

function tfp_photos_champs() {
	return array(
		'bureaux'          => array( __( 'Bureaux', 'top-famille-pro' ), 'tfp-card' ),
		'commerce'         => array( __( 'Commerce', 'top-famille-pro' ), 'tfp-card' ),
		'sanitaires'       => array( __( 'Sanitaires', 'top-famille-pro' ), 'tfp-card' ),
		'partie_commune'   => array( __( 'Partie commune', 'top-famille-pro' ), 'tfp-card' ),
		'materiel'         => array( __( 'Matériel', 'top-famille-pro' ), 'tfp-card' ),
		'cahier_de_liaison'=> array( __( 'Cahier de liaison', 'top-famille-pro' ), 'tfp-card' ),
		'portrait_audrey'  => array( __( 'Portrait d\'Audrey', 'top-famille-pro' ), 'tfp-portrait' ),
		'audrey_echange'   => array( __( 'Audrey en échange avec un client', 'top-famille-pro' ), 'tfp-card' ),
		'presence_tarifs'  => array( __( 'Présence humaine (page Tarifs)', 'top-famille-pro' ), 'tfp-card' ),
	);
}

function tfp_get_photo_id( $slot ) {
	$photos = get_option( TFP_PHOTOS_OPTION, array() );
	return isset( $photos[ $slot ] ) ? (int) $photos[ $slot ] : 0;
}

function tfp_afficher_photo( $slot, $alt, $classe = '' ) {
	$id = tfp_get_photo_id( $slot );
	list( , $taille ) = tfp_photos_champs()[ $slot ] ?? array( '', 'tfp-card' );
	if ( $id && wp_attachment_is_image( $id ) ) {
		echo wp_get_attachment_image( $id, $taille, false, array( 'alt' => esc_attr( $alt ), 'class' => esc_attr( $classe ), 'loading' => 'lazy' ) ); // phpcs:ignore
		return;
	}
	$classe_placeholder = ( 'tfp-portrait' === $taille ) ? 'tfp-image-placeholder--portrait' : '';
	printf(
		'<div class="tfp-image-placeholder %1$s %2$s" role="img" aria-label="%3$s"><span>%4$s</span></div>',
		esc_attr( $classe_placeholder ),
		esc_attr( $classe ),
		esc_attr( $alt ),
		esc_html__( 'Photo à venir', 'top-famille-pro' )
	);
}

function tfp_register_photos_setting() {
	register_setting(
		'tfp_photos_group',
		TFP_PHOTOS_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'tfp_sanitize_photos',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'tfp_register_photos_setting' );

function tfp_sanitize_photos( $input ) {
	$out = array();
	foreach ( array_keys( tfp_photos_champs() ) as $slot ) {
		$out[ $slot ] = isset( $input[ $slot ] ) ? absint( $input[ $slot ] ) : 0;
	}
	return $out;
}

function tfp_register_photos_page() {
	add_submenu_page(
		'tfp-donnees-commerciales',
		__( 'Photographies', 'top-famille-pro' ),
		__( 'Photographies', 'top-famille-pro' ),
		'manage_options',
		'tfp-photos',
		'tfp_render_photos_page'
	);
}
add_action( 'admin_menu', 'tfp_register_photos_page' );

function tfp_enqueue_media_admin( $hook ) {
	if ( 'donnees-commerciales_page_tfp-photos' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'tfp-admin-media', TFP_THEME_URI . '/assets/js/admin-media.js', array( 'jquery' ), TFP_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'tfp_enqueue_media_admin' );

function tfp_render_photos_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$photos = get_option( TFP_PHOTOS_OPTION, array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Photographies — Top-Famille Pro', 'top-famille-pro' ); ?></h1>
		<p><?php esc_html_e( 'Ces photos sont réutilisées automatiquement sur les pages concernées. Les photos "hero" de chaque page se gèrent séparément via l\'image mise en avant de la page.', 'top-famille-pro' ); ?></p>
		<p><strong><?php esc_html_e( 'Utilisez uniquement des photos réelles de Top-Famille Pro. Ne jamais présenter une photo de banque d\'images comme une intervention réelle.', 'top-famille-pro' ); ?></strong></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'tfp_photos_group' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( tfp_photos_champs() as $slot => list( $label, $taille ) ) : ?>
					<?php $id_actuel = isset( $photos[ $slot ] ) ? (int) $photos[ $slot ] : 0; ?>
					<tr>
						<th scope="row"><?php echo esc_html( $label ); ?></th>
						<td>
							<div class="tfp-champ-photo" data-champ="<?php echo esc_attr( $slot ); ?>">
								<div class="tfp-champ-photo__apercu">
									<?php if ( $id_actuel ) : ?>
										<?php echo wp_get_attachment_image( $id_actuel, 'thumbnail' ); ?>
									<?php endif; ?>
								</div>
								<input type="hidden" name="<?php echo esc_attr( TFP_PHOTOS_OPTION ); ?>[<?php echo esc_attr( $slot ); ?>]" value="<?php echo esc_attr( $id_actuel ); ?>" class="tfp-champ-photo__id">
								<button type="button" class="button tfp-champ-photo__choisir"><?php esc_html_e( 'Choisir une image', 'top-famille-pro' ); ?></button>
								<button type="button" class="button tfp-champ-photo__retirer"><?php esc_html_e( 'Retirer', 'top-famille-pro' ); ?></button>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
