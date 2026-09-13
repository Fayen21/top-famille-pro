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
			<img src="<?php echo esc_url( TFP_THEME_URI . '/assets/dist/images/logo-horizontal.png' ); ?>" alt="<?php echo esc_attr( $site['brand_name'] ); ?>" width="155" height="82">
		</a>
		<button type="button" class="tfp-menu-toggle" data-tfp-mobile-close aria-label="Fermer le menu">
			<span aria-hidden="true">✕</span>
		</button>
	</div>

	<div class="tfp-mobile-nav__body">
		<nav aria-label="Navigation principale">
			<?php
			/*
			 * Même ordre et même principe qu'en bureau : le libellé d'une entrée à sous-menu est un
			 * LIEN vers sa page (pilier pour « Prestations », hub pour « Zones »), le « + » est un
			 * BOUTON qui déplie. Sur un panneau mobile, confondre les deux condamne l'accès à la
			 * page parente : le doigt tombe forcément sur l'un ou sur l'autre.
			 */
			?>
			<div class="tfp-mobile-nav__list">
				<?php foreach ( $main_nav as $item ) : ?>
					<?php if ( 'submenu' === $item['type'] ) : ?>
						<?php $tfp_msub = 'tfp-mobile-sub-' . $item['key']; ?>
						<div class="tfp-mobile-nav__row">
							<a class="tfp-mobile-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
							<button type="button" class="tfp-mobile-nav__button" id="tfp-mobile-btn-<?php echo esc_attr( $item['key'] ); ?>" aria-controls="<?php echo esc_attr( $tfp_msub ); ?>" aria-expanded="false" data-tfp-mobile-submenu-toggle>
								<span aria-hidden="true">＋</span>
								<span class="visually-hidden">Ouvrir le menu <?php echo esc_html( $item['aide'] ); ?></span>
							</button>
						</div>
						<div class="tfp-mobile-submenu" id="<?php echo esc_attr( $tfp_msub ); ?>" hidden>
							<?php foreach ( $item['items'] as $sub ) : ?>
								<a href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a>
							<?php endforeach; ?>
							<?php if ( 'prestations' === $item['key'] ) : ?>
								<a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>">Toutes les prestations →</a>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<a class="tfp-mobile-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endif; ?>
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
