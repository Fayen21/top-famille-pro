<?php
/**
 * CTA final réutilisable. $args : 'titre', 'texte' (facultatifs).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titre = $args['titre'] ?? __( 'Une question ? Un devis à demander ?', 'top-famille-pro' );
$texte = $args['texte'] ?? sprintf(
	/* translators: %s: délai de réponse en heures */
	__( 'Réponse sous %s h, sans engagement.', 'top-famille-pro' ),
	tfp_get_donnee( 'delai_devis_heures' )
);
?>
<section class="tfp-cta-final">
	<h2><?php echo esc_html( $titre ); ?></h2>
	<p><?php echo esc_html( $texte ); ?></p>
	<div class="tfp-cta-final__actions">
		<?php tfp_bouton_devis(); ?>
		<?php tfp_bouton_appeler( '', 'secondaire' ); ?>
	</div>
</section>
