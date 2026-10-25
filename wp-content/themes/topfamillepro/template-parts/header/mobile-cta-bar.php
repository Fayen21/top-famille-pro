<?php
/**
 * Barre CTA mobile fixe (< 820px). Ne masque jamais le contenu grâce à .tfp-mobile-cta-spacer
 * (réservation d'espace en fin de page, voir footer.php).
 *
 * Adaptée au parcours depuis la revue du 25 octobre 2026 (tfp_parcours()) :
 *  - devis : AUCUNE barre — elle renvoyait au formulaire déjà ouvert ; l'aide téléphonique reste
 *    dans la colonne du formulaire ;
 *  - recrutement : la candidature (site carrière) est l'action principale ;
 *  - contact : seulement l'appel, pour ne pas détourner un message en cours de rédaction ;
 *  - pages utilitaires (mentions, confidentialité, cookies, plan du site) : AUCUNE barre — une
 *    bande commerciale collante y dominait un contenu de consultation ; le CTA du header suffit ;
 *  - ailleurs : appel + devis, comme avant.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site     = tfp_site_data();
$parcours = tfp_parcours();
if ( in_array( $parcours, array( 'devis', 'utilitaire' ), true ) ) {
	return;
}
?>
<div class="tfp-mobile-cta-bar tfp-mobile-cta-bar--<?php echo esc_attr( $parcours ); ?>">
	<a class="tfp-btn tfp-btn--secondary" href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>" aria-label="<?php echo esc_attr( tfp_phone_cta_label( false ) . ' au ' . $site['phone'] ); ?>">
		<?php echo tfp_icone( 'telephone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?> Appeler
	</a>
	<?php if ( 'recrutement' === $parcours ) : ?>
		<a class="tfp-btn tfp-btn--primary" href="<?php echo esc_url( tfp_url_carrieres() ); ?>">
			Envoyer ma candidature
		</a>
	<?php elseif ( 'contact' !== $parcours ) : ?>
		<a class="tfp-btn tfp-btn--primary" href="<?php echo esc_url( home_url( '/demande-de-devis/' ) ); ?>">
			Demander mon devis
		</a>
	<?php endif; ?>
</div>
<div class="tfp-mobile-cta-spacer" aria-hidden="true"></div>
