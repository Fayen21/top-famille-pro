<?php
/**
 * 2. Bandeau tarifaire + réassurance.
 * Aucune fausse note Google ici (docs/DONNEES-FICTIVES.md) : la grille de réassurance
 * n'affiche que des faits confirmés (PROJECT_INPUTS.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();
?>
<section class="tfp-container tfp-section--tight">
	<div class="tfp-price-band">
		<span class="tfp-price-band__value">
			<strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong>
			<span>tarif unique, indiqué avant le devis</span>
		</span>
		<?php tfp_check_item( 'Devis gratuit sous 24 h' ); ?>
		<?php tfp_check_item( 'Intervention régulière ou ponctuelle' ); ?>
		<?php tfp_check_item( "Conditions d'arrêt précisées au devis" ); ?>
		<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-btn tfp-btn--secondary tfp-btn--sm" style="margin-left:auto">Voir les tarifs →</a>
	</div>
</section>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-reassurance">
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title"><?php echo esc_html( $site['address_city'] ); ?></div>
			<div class="tfp-reassurance__desc">Entreprise régionale basée en BFC</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Interlocutrice identifiée</div>
			<div class="tfp-reassurance__desc"><?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?>, du devis au suivi</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Intervenants sélectionnés</div>
			<div class="tfp-reassurance__desc">Régulier ou ponctuel</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Tarif transparent</div>
			<div class="tfp-reassurance__desc">Annoncé avant le devis</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Réponse sous 24 h</div>
			<div class="tfp-reassurance__desc">Devis gratuit, sans engagement</div>
		</div>
	</div>
</section>
