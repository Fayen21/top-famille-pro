<?php
/**
 * 6. Tarifs — tarif réel (PROJECT_INPUTS.md §5), identique partout, jamais différencié par
 * ville (CLAUDE.md §5.3). Tarif unique 27 € HT/h depuis le 9 août 2026 (hotfix fidélité Claude
 * Design), qui remplace l'ancienne grille à trois montants.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$budget = tfp_home_budget_example();
?>
<section class="tfp-section">
	<div class="tfp-container tfp-two-col">
		<div>
			<h2>Un tarif clair, affiché avant le devis</h2>
			<p style="margin-top:14px;font-size:17px;color:var(--color-text-secondary)">
				<?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h en régulier comme en ponctuel. Nous y ajoutons
				<?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT/mois de gestion et <?php echo esc_html( tfp_format_price( $site['price_setup'] ) ); ?> HT de frais de mise en place,
				lorsqu'ils s'appliquent, selon les conditions précisées au devis et toujours indiqués à l'avance.
			</p>

			<div class="tfp-price-example">
				<div class="tfp-price-example__label">Exemple · bureaux réguliers, <?php echo (int) $budget['hours']; ?> h/mois</div>
				<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
				<div class="tfp-price-example__note">Avec les frais de mise en place : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT le premier mois · exemple non contractuel</div>
			</div>

			<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-eyebrow-link">Voir la page Tarifs complète →</a>
		</div>

		<div class="tfp-price-panel">
			<div class="tfp-price-panel__label">Tarif unique</div>
			<div class="tfp-price-panel__value"><?php echo esc_html( $site['price_unique_display'] ); ?><span> HT/h</span></div>
			<div class="tfp-price-panel__sub">Régulier ou ponctuel · devis gratuit sous 24 h.</div>
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'on-primary',
					'block'   => true,
				)
			);
			?>
		</div>
	</div>
</section>
