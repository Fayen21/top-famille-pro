<?php
get_header();
?>

<div class="container tfp-section">
	<h1><?php esc_html_e( 'Page introuvable', 'top-famille-pro' ); ?></h1>
	<p><?php esc_html_e( 'La page que vous cherchez n\'existe pas ou a été déplacée.', 'top-famille-pro' ); ?></p>
	<div class="tfp-hero__actions">
		<a class="tfp-btn tfp-btn--primaire" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Retour à l\'accueil', 'top-famille-pro' ); ?></a>
		<a class="tfp-btn tfp-btn--secondaire" href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Voir nos prestations', 'top-famille-pro' ); ?></a>
	</div>
</div>

<?php get_footer(); ?>
