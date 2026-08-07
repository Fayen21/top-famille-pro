<?php
/**
 * 1. Hero — proposition de valeur, CTA principal + secondaire, réassurance immédiate.
 * Image principale = LCP de la page (tfp_picture gère fetchpriority="high" + pas de lazy-loading).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();
?>
<section class="tfp-hero">
	<div class="tfp-hero__content">
		<?php if ( $reassurance['note'] && $reassurance['nombre_avis'] ) : ?>
			<div class="tfp-badge">
				<span style="color:var(--color-star);letter-spacing:1px;font-size:13px" aria-hidden="true"><?php echo str_repeat( '★', 5 ); ?></span>
				<span style="font-weight:700;font-size:14px;font-family:var(--font-heading)"><?php echo esc_html( number_format_i18n( $reassurance['note'], 1 ) ); ?>/5</span>
				<span style="font-size:13px;color:var(--color-text-tertiary)">sur <?php echo (int) $reassurance['nombre_avis']; ?> avis Google</span>
				<?php if ( $reassurance['google_url'] ) : ?>
					<a href="<?php echo esc_url( $reassurance['google_url'] ); ?>" style="font-size:12.5px;font-weight:600;color:var(--color-primary);background:var(--color-turquoise-pale);padding:5px 10px;border-radius:100px">Voir les avis</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h1 class="tfp-hero__title">Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté</h1>
		<p class="tfp-hero__lede">La rigueur d'un prestataire structuré, avec la proximité d'une entreprise régionale directement joignable. Top-Famille Pro organise l'entretien régulier ou ponctuel de vos bureaux, commerces, cabinets, parties communes et locations meublées.</p>

		<div class="tfp-hero__actions">
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'primary',
				)
			);
			tfp_button(
				array(
					'label'   => '☎ Appeler ' . $site['manager'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'secondary',
				)
			);
			?>
		</div>
		<div class="tfp-hero__microcopy">Réponse sous 24 h · Gratuit · Sans engagement · Devis étudié personnellement par <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?></div>
	</div>

	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( 'hero-main', array( 'sizes' => '(max-width: 819px) 92vw, 600px' ) ); ?>
		</div>
		<div class="tfp-hero__media-secondary">
			<?php tfp_picture( 'hero-secondary', array( 'sizes' => '220px' ) ); ?>
		</div>
		<div class="tfp-hero__price-tag">
			<div class="tfp-hero__price-tag-value">à partir de <?php echo esc_html( $site['price_entry_display'] ); ?><span class="tfp-hero__price-tag-unit"> HT/h</span></div>
			<div class="tfp-hero__price-tag-note">régulier ou ponctuel, selon le type de local</div>
		</div>
	</div>
</section>
