<?php
/**
 * Page « Demande de devis » (URL /demande-de-devis/).
 * Titre de page WordPress attendu (H1) : « Demande de devis ».
 * Cible du formulaire de devis, où qu'il soit affiché sur le site.
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
?>

<div class="container tfp-section">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
	<h1><?php the_title(); ?></h1>
	<p>
		<?php
		printf(
			/* translators: %s: délai de réponse en heures */
			esc_html__( 'Décrivez votre local : nous vous recontactons sous %s h, sans engagement.', 'top-famille-pro' ),
			esc_html( tfp_get_donnee( 'delai_devis_heures' ) )
		);
		?>
	</p>
</div>

<section class="tfp-section container tfp-contenu-prestation">
	<?php get_template_part( 'template-parts/form/devis-form' ); ?>
</section>

<div class="container">
	<p><?php esc_html_e( 'Vous préférez nous appeler directement ?', 'top-famille-pro' ); ?> <a href="<?php echo esc_url( tfp_telephone_href() ); ?>"><?php echo esc_html( tfp_telephone_affichage() ); ?></a></p>
</div>

<?php get_footer(); ?>
