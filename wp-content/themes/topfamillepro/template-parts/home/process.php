<?php
/**
 * 5. Fonctionnement — cinq étapes, du premier contact au suivi.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$steps = array(
	array( 'num' => '01', 'title' => 'Prise de contact', 'desc' => 'Vous décrivez vos locaux et vos contraintes.' ),
	array( 'num' => '02', 'title' => 'Analyse', 'desc' => 'Nous étudions le cahier des charges et le volume.' ),
	array( 'num' => '03', 'title' => 'Devis sous 24 h', 'desc' => 'Une proposition claire à ' . tfp_format_price( $site['price_unique'] ) . ' HT/h, sans engagement.' ),
	array( 'num' => '04', 'title' => 'Sélection & mise en place', 'desc' => 'Intervenant attitré, planning et accès organisés.' ),
	array( 'num' => '05', 'title' => 'Suivi', 'desc' => 'Cahier de liaison, ajustements et remplacement si besoin.' ),
);
?>
<section class="tfp-section tfp-section--alt">
	<div class="tfp-container">
		<div class="tfp-flex tfp-flex--between" style="margin-bottom:32px">
			<h2 style="max-width:520px">Notre fonctionnement, en cinq temps</h2>
			<a href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>" class="tfp-link-arrow">En détail →</a>
		</div>
		<div aria-hidden="true" style="height:3px;background:linear-gradient(90deg,var(--color-turquoise),var(--color-primary));border-radius:2px;margin-bottom:18px"></div>
		<div class="tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,190px),1fr))">
			<?php foreach ( $steps as $step ) : ?>
				<div class="tfp-step">
					<div class="tfp-step__num"><?php echo esc_html( $step['num'] ); ?></div>
					<div class="tfp-step__title"><?php echo esc_html( $step['title'] ); ?></div>
					<p class="tfp-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
