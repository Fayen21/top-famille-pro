<?php
/**
 * Barre mobile fixe Appeler / Devis. Masquée sur ordinateur en CSS
 * (voir .tfp-cta-mobile dans components.css).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tfp-cta-mobile">
	<a class="tfp-cta-mobile__lien" href="<?php echo esc_url( tfp_telephone_href() ); ?>">
		<svg class="tfp-icone" aria-hidden="true" viewBox="0 0 24 24" width="18" height="18"><path d="M6 3h3l2 5-2.5 1.5a11 11 0 0 0 5 5L15 12l5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5a2 2 0 0 1 2-2z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
		<?php esc_html_e( 'Appeler', 'top-famille-pro' ); ?>
	</a>
	<a class="tfp-cta-mobile__lien tfp-cta-mobile__lien--accent" href="<?php echo esc_url( tfp_devis_page_url() ); ?>">
		<svg class="tfp-icone" aria-hidden="true" viewBox="0 0 24 24" width="18" height="18"><path d="M4 4h16v12H7l-3 3z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
		<?php esc_html_e( 'Devis', 'top-famille-pro' ); ?>
	</a>
</div>
