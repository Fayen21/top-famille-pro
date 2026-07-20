<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tfp-mobile-nav" class="tfp-mobile-nav" hidden>
	<div class="tfp-mobile-nav__entete">
		<span class="tfp-mobile-nav__titre"><?php esc_html_e( 'Menu', 'top-famille-pro' ); ?></span>
		<button type="button" class="tfp-mobile-nav__fermer" aria-label="<?php esc_attr_e( 'Fermer le menu', 'top-famille-pro' ); ?>">
			<svg aria-hidden="true" viewBox="0 0 24 24" width="20" height="20"><path d="M5 5l14 14M19 5L5 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
		</button>
	</div>
	<nav aria-label="<?php esc_attr_e( 'Menu principal (mobile)', 'top-famille-pro' ); ?>">
		<?php tfp_menu( 'mobile', 'tfp-nav__liste--mobile' ); ?>
	</nav>
	<div class="tfp-mobile-nav__actions">
		<?php tfp_bouton_appeler(); ?>
		<?php tfp_bouton_devis(); ?>
	</div>
</div>
