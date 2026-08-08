<?php
/**
 * Panneau de navigation mobile (plein écran), avec sous-menus en accordéon.
 * Accessibilité : piège de focus + touche Échap gérés par src/js/nav.js (initMobileMenu).
 *
 * @var array $args { main_nav, prestations_nav, zones_nav, site }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$main_nav        = $args['main_nav'];
$prestations_nav = $args['prestations_nav'];
$zones_nav       = $args['zones_nav'];
$site            = $args['site'];
?>
<div class="tfp-mobile-nav" id="tfp-mobile-nav" data-tfp-mobile-panel role="dialog" aria-modal="true" aria-label="Menu" hidden>
	<div class="tfp-mobile-nav__header">
		<a class="tfp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $site['brand_name'] ); ?> — Accueil">
			<img src="<?php echo esc_url( TFP_THEME_URI . '/assets/dist/images/logo-horizontal.png' ); ?>" alt="<?php echo esc_attr( $site['brand_name'] ); ?>" width="68" height="36">
		</a>
		<button type="button" class="tfp-menu-toggle" data-tfp-mobile-close aria-label="Fermer le menu">
			<span aria-hidden="true">✕</span>
		</button>
	</div>

	<div class="tfp-mobile-nav__body">
		<nav aria-label="Navigation principale">
			<div class="tfp-mobile-nav__list">
				<button type="button" class="tfp-mobile-nav__button" id="tfp-mobile-btn-prestations" aria-controls="tfp-mobile-sub-prestations" aria-expanded="false" data-tfp-mobile-submenu-toggle>
					Prestations <span aria-hidden="true">＋</span>
				</button>
				<div class="tfp-mobile-submenu" id="tfp-mobile-sub-prestations" hidden>
					<?php foreach ( $prestations_nav as $item ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endforeach; ?>
				</div>

				<button type="button" class="tfp-mobile-nav__button" id="tfp-mobile-btn-zones" aria-controls="tfp-mobile-sub-zones" aria-expanded="false" data-tfp-mobile-submenu-toggle>
					Zones d'intervention <span aria-hidden="true">＋</span>
				</button>
				<div class="tfp-mobile-submenu" id="tfp-mobile-sub-zones" hidden>
					<?php foreach ( $zones_nav as $item ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endforeach; ?>
				</div>

				<?php foreach ( $main_nav as $item ) : ?>
					<a class="tfp-mobile-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</nav>

		<div style="margin-top:24px;display:flex;flex-direction:column;gap:12px">
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'primary',
					'block'   => true,
				)
			);
			tfp_button(
				array(
					'label'   => '☎ ' . $site['phone'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'secondary',
					'block'   => true,
				)
			);
			?>
		</div>
	</div>
</div>
