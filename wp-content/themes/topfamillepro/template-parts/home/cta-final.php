<?php
/**
 * 10. CTA final — contextualisé à l'accueil (pas de fausse urgence, pas de faux compteur).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();
?>
<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Demandez votre devis gratuit et sans engagement</h2>
		<p>Décrivez vos locaux : <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond sous 24 heures avec une proposition claire.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'on-primary',
				)
			);
			tfp_button(
				array(
					'label'   => '☎ ' . $site['phone'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'on-dark',
				)
			);
			?>
		</div>
	</div>
</section>
