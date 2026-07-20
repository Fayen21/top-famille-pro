<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tfp-preuves">
	<div class="tfp-preuves__item">
		<span class="tfp-preuves__valeur"><?php echo esc_html( tfp_get_donnee( 'tarif_horaire' ) ); ?> € HT/h</span>
		<span class="tfp-preuves__label"><?php esc_html_e( 'Tarif clair et transparent', 'top-famille-pro' ); ?></span>
	</div>
	<div class="tfp-preuves__item">
		<span class="tfp-preuves__valeur"><?php echo esc_html( tfp_get_donnee( 'delai_devis_heures' ) ); ?> h</span>
		<span class="tfp-preuves__label"><?php esc_html_e( 'Délai de réponse pour un devis', 'top-famille-pro' ); ?></span>
	</div>
	<div class="tfp-preuves__item">
		<span class="tfp-preuves__valeur"><?php esc_html_e( 'Sélection & suivi', 'top-famille-pro' ); ?></span>
		<span class="tfp-preuves__label"><?php esc_html_e( 'Intervenants suivis dans la durée', 'top-famille-pro' ); ?></span>
	</div>
	<div class="tfp-preuves__item">
		<span class="tfp-preuves__valeur"><?php esc_html_e( 'Bourgogne-Franche-Comté', 'top-famille-pro' ); ?></span>
		<span class="tfp-preuves__label"><?php esc_html_e( 'Zone d\'intervention régionale', 'top-famille-pro' ); ?></span>
	</div>
</div>
