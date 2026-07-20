<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav class="tfp-nav tfp-nav--desktop" aria-label="<?php esc_attr_e( 'Menu principal', 'top-famille-pro' ); ?>">
	<?php tfp_menu( 'desktop', 'tfp-nav__liste--desktop' ); ?>
</nav>
