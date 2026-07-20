<?php
/**
 * Hero réutilisable pour les pages de prestation et de ville. Le H1 est
 * toujours le titre de la page WordPress (à définir exactement lors de la
 * création de la page). $args : 'intro' (texte), 'image_alt' (texte).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$intro     = $args['intro'] ?? '';
$image_alt = $args['image_alt'] ?? get_the_title();
?>
<section class="tfp-hero">
	<div class="container tfp-hero__grille">
		<div>
			<h1><?php the_title(); ?></h1>
			<?php if ( $intro ) : ?>
				<p><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<p class="tfp-hero__tarif">
				<?php
				printf(
					/* translators: %s: tarif horaire */
					esc_html__( 'À partir de %s € HT/h', 'top-famille-pro' ),
					esc_html( tfp_get_donnee( 'tarif_horaire' ) )
				);
				?>
				— <?php printf( esc_html__( 'devis sous %s h', 'top-famille-pro' ), esc_html( tfp_get_donnee( 'delai_devis_heures' ) ) ); ?>
			</p>
			<div class="tfp-hero__actions">
				<?php tfp_bouton_devis(); ?>
				<?php tfp_bouton_appeler(); ?>
			</div>
		</div>
		<div>
			<?php tfp_image_hero( get_post_thumbnail_id(), esc_attr( $image_alt ), 'tfp-image-placeholder--hero' ); ?>
		</div>
	</div>
</section>
