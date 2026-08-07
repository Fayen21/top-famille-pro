<?php
/**
 * Barre CTA mobile fixe (< 820px). Toujours visible, ne masque jamais le contenu grâce à
 * .tfp-mobile-cta-spacer (réservation d'espace en fin de page, voir footer.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();
?>
<div class="tfp-mobile-cta-bar">
	<a class="tfp-btn tfp-btn--secondary" href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>" aria-label="Appeler <?php echo esc_attr( $site['manager'] ); ?>">
		☎ Appeler
	</a>
	<a class="tfp-btn tfp-btn--primary" href="<?php echo esc_url( home_url( '/demande-de-devis/' ) ); ?>">
		Demander mon devis
	</a>
</div>
<div class="tfp-mobile-cta-spacer" aria-hidden="true"></div>
