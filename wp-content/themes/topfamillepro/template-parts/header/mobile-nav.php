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
			 * Même ordre et même principe qu'en bureau. Depuis le 13 novembre 2026, toucher le
			 * libellé d'une entrée à sous-menu OUVRE ses choix (src/js/nav.js) ; sans JavaScript il
			 * reste un lien vers sa page. La page parente est la première ou la dernière entrée du
			 * volet (« notre méthode », « Voir toutes les villes »).
			 */
			?>
			<div class="tfp-mobile-nav__list">
				<?php foreach ( $main_nav as $item ) : ?>
					<?php if ( 'submenu' === $item['type'] ) : ?>
						<?php $tfp_msub = 'tfp-mobile-sub-' . $item['key']; ?>
						<div class="tfp-mobile-nav__row">
							<a class="tfp-mobile-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
							<button type="button" class="tfp-mobile-nav__button" id="tfp-mobile-btn-<?php echo esc_attr( $item['key'] ); ?>" aria-controls="<?php echo esc_attr( $tfp_msub ); ?>" aria-expanded="false" data-tfp-mobile-submenu-toggle>
								<?php echo tfp_icone( 'chevron', 'tfp-mobile-nav__chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<span class="visually-hidden">Ouvrir le menu <?php echo esc_html( $item['aide'] ); ?></span>
							</button>
						</div>
						<div class="tfp-mobile-submenu" id="<?php echo esc_attr( $tfp_msub ); ?>" hidden>
							<?php if ( ! empty( $item['tete'] ) ) : ?>
								<a href="<?php echo esc_url( $item['tete']['url'] ); ?>"><?php echo esc_html( $item['tete']['label'] ); ?></a>
							<?php endif; ?>
							<?php foreach ( $item['items'] as $sub ) : ?>
								<a href="<?php echo esc_url( $sub['url'] ); ?>">
									<?php echo esc_html( $sub['label'] ); ?>
									<?php if ( ! empty( $sub['num'] ) ) : ?>
										<span class="tfp-submenu__num" aria-hidden="true"><?php echo esc_html( $sub['num'] ); ?></span>
										<span class="visually-hidden">(<?php echo esc_html( $sub['num'] ); ?>)</span>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
							<?php if ( ! empty( $item['tout'] ) ) : ?>
								<a class="tfp-mobile-submenu__all" href="<?php echo esc_url( $item['tout']['url'] ); ?>"><?php echo esc_html( $item['tout']['label'] ); ?> →</a>
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
					'href'    => 'devis' === tfp_parcours() ? '#tfp-formulaire-devis' : home_url( '/demande-de-devis/' ),
					'variant' => 'primary',
					'block'   => true,
				)
			);
			tfp_bouton_appel( array( 'variant' => 'secondary', 'numero' => true, 'classe' => 'tfp-btn--block' ) );
			?>
		</div>
	</div>
</div>
