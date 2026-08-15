<?php
/**
 * En-tête du site : logo, navigation desktop (avec sous-menus Prestations / Zones),
 * téléphone, CTA devis, déclencheur du menu mobile.
 *
 * Les URL des pages non encore construites (phase 2+) sont déjà les URL définitives du site
 * (docs/INVENTAIRE-ROUTES.md) — elles renvoient un vrai 404 tant que la page n'existe pas,
 * ce qui est honnête et attendu à ce stade (brief phase 1 §8).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$prestations_nav = array(
	array( 'label' => 'Nettoyage de bureaux', 'url' => home_url( '/prestations/bureaux/' ) ),
	array( 'label' => 'Nettoyage de commerces', 'url' => home_url( '/prestations/commerces/' ) ),
	array( 'label' => 'Cabinets & professions libérales', 'url' => home_url( '/prestations/cabinets/' ) ),
	array( 'label' => 'Copropriétés & parties communes', 'url' => home_url( '/prestations/coproprietes/' ) ),
	array( 'label' => 'Locations meublées & hébergements', 'url' => home_url( '/prestations/meubles/' ) ),
	array( 'label' => 'Nettoyage ponctuel & remise en état', 'url' => home_url( '/prestations/ponctuel/' ) ),
);

$zones_nav = array(
	array( 'label' => 'Toutes les zones', 'url' => home_url( '/zones-intervention/' ) ),
	array( 'label' => 'Bourgogne-Franche-Comté', 'url' => home_url( '/zones-intervention/bourgogne-franche-comte/' ) ),
);

$main_nav = array(
	array( 'label' => 'Nettoyage professionnel', 'url' => home_url( '/nettoyage-professionnel/' ) ),
	array( 'label' => 'Nos tarifs', 'url' => home_url( '/tarifs/' ) ),
	array( 'label' => 'Pourquoi nous', 'url' => home_url( '/pourquoi-nous/' ) ),
	array( 'label' => 'Avis clients', 'url' => home_url( '/avis-clients/' ) ),
	array( 'label' => 'Conseils', 'url' => home_url( '/conseils/' ) ),
);
?>
<header class="tfp-header" data-tfp-header>
	<?php
	// Bandeau supérieur turquoise de la maquette (30px, #DDF4F3, texte 13px) : tarif, promesse de
	// délai, note Google et téléphone. La note n'est rendue que si elle est réellement configurée
	// (includes/testimonials.php) ; le compteur d'avis du prototype (« 47 avis ») reste interdit.
	$tfp_reassurance_bar = tfp_reassurance_data();
	?>
	<div class="tfp-topbar">
		<div class="tfp-topbar__inner">
			<span class="tfp-topbar__offer">
				<strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong> · Devis gratuit sous 24 h
			</span>
			<?php if ( ! empty( $tfp_reassurance_bar['note'] ) ) : ?>
				<span class="tfp-topbar__rating">
					<span class="tfp-topbar__stars" aria-hidden="true">★★★★★</span>
					<strong><?php echo esc_html( number_format( (float) $tfp_reassurance_bar['note'], 1, ',', '' ) ); ?>/5</strong>
					<span>sur Google</span>
				</span>
			<?php endif; ?>
			<a class="tfp-topbar__phone" href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>"><?php echo esc_html( $site['phone'] ); ?></a>
		</div>
	</div>

	<div class="tfp-header__inner">
		<a class="tfp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $site['brand_name'] ); ?> — Accueil">
			<img src="<?php echo esc_url( TFP_THEME_URI . '/assets/dist/images/logo-horizontal.png' ); ?>" alt="<?php echo esc_attr( $site['brand_name'] ); ?>" width="155" height="82">
		</a>

		<nav class="tfp-nav" aria-label="Navigation principale">
			<div data-tfp-nav-item style="position:relative">
				<button type="button" class="tfp-nav__button" id="tfp-btn-prestations" aria-controls="tfp-menu-prestations" aria-expanded="false" data-tfp-submenu-toggle>
					Prestations <span class="tfp-nav__caret" aria-hidden="true">▾</span>
				</button>
				<div class="tfp-submenu tfp-submenu--wide" id="tfp-menu-prestations" role="menu" aria-labelledby="tfp-btn-prestations" hidden>
					<?php foreach ( $prestations_nav as $item ) : ?>
						<a class="tfp-submenu__item" role="menuitem" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endforeach; ?>
					<a class="tfp-submenu__item" role="menuitem" href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>" style="font-weight:600;color:var(--color-primary)">Toutes les prestations →</a>
				</div>
			</div>

			<div data-tfp-nav-item style="position:relative">
				<button type="button" class="tfp-nav__button" id="tfp-btn-zones" aria-controls="tfp-menu-zones" aria-expanded="false" data-tfp-submenu-toggle>
					Zones <span class="tfp-nav__caret" aria-hidden="true">▾</span>
				</button>
				<div class="tfp-submenu tfp-submenu--zones" id="tfp-menu-zones" role="menu" aria-labelledby="tfp-btn-zones" hidden>
					<?php foreach ( $zones_nav as $item ) : ?>
						<a class="tfp-submenu__item" role="menuitem" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<?php foreach ( $main_nav as $item ) : ?>
				<a class="tfp-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="tfp-header__actions">
			<a class="tfp-header__phone" href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>">
				<span aria-hidden="true">☎</span>
				<span class="tfp-header__phone-label"><?php echo esc_html( $site['phone'] ); ?></span>
				<span class="visually-hidden">Appeler <?php echo esc_html( $site['manager'] ); ?></span>
			</a>
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					// Cuivre, comme dans la maquette (fond #D9A062, texte bleu nuit) — mesuré sur le
					// rendu réel du prototype, pas déduit du code.
					'variant' => 'copper',
					'size'    => 'sm',
				)
			);
			?>
			<button type="button" class="tfp-menu-toggle" data-tfp-mobile-open aria-expanded="false" aria-controls="tfp-mobile-nav" aria-label="Ouvrir le menu">
				<span aria-hidden="true">☰</span>
			</button>
		</div>
	</div>
</header>

<?php get_template_part( 'template-parts/header/mobile-nav', null, array(
	'main_nav'         => $main_nav,
	'prestations_nav'  => $prestations_nav,
	'zones_nav'        => $zones_nav,
	'site'             => $site,
) ); ?>
