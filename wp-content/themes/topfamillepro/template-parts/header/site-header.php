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

/*
 * Navigation principale — décision définitive du 19 août 2026.
 *
 * L'entrée autonome « Nettoyage professionnel » est SUPPRIMÉE : elle faisait passer la barre à
 * sept entrées, la faisait replier à 1440 px et ajoutait 22 px d'en-tête sur les 53 pages.
 *
 * Le lien vers la page pilier n'est pas perdu pour autant — c'est la porte d'entrée du site sur
 * « nettoyage professionnel », et le supprimer aurait été un arbitrage de référencement déguisé en
 * correction de fidélité. L'entrée « Prestations » **est** ce lien : un `<a>` vers
 * `/nettoyage-professionnel/`, doublé d'un bouton de dépliage qui ouvre le menu des six
 * prestations. Deux commandes distinctes parce qu'elles font deux choses distinctes — naviguer et
 * déplier — ce qu'un seul élément ne peut pas exposer honnêtement à un lecteur d'écran.
 *
 * Ordre et libellés relevés sur la maquette : Prestations ▾, Tarifs, Zones ▾, Pourquoi nous,
 * Avis, Conseils. Six entrées, une seule ligne, en-tête de 119 px à 1440 px.
 */
$main_nav = array(
	array( 'type' => 'submenu', 'key' => 'prestations', 'label' => 'Prestations', 'url' => home_url( '/nettoyage-professionnel/' ), 'items' => $prestations_nav, 'classe' => 'tfp-submenu--wide', 'aide' => 'des prestations' ),
	array( 'type' => 'link', 'label' => 'Tarifs', 'url' => home_url( '/tarifs/' ) ),
	array( 'type' => 'submenu', 'key' => 'zones', 'label' => 'Zones', 'url' => home_url( '/zones-intervention/' ), 'items' => $zones_nav, 'classe' => 'tfp-submenu--zones', 'aide' => 'des zones d’intervention' ),
	array( 'type' => 'link', 'label' => 'Pourquoi nous', 'url' => home_url( '/pourquoi-nous/' ) ),
	array( 'type' => 'link', 'label' => 'Avis', 'url' => home_url( '/avis-clients/' ) ),
	array( 'type' => 'link', 'label' => 'Conseils', 'url' => home_url( '/conseils/' ) ),
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
			<?php foreach ( $main_nav as $item ) : ?>
				<?php if ( 'submenu' === $item['type'] ) : ?>
					<?php $tfp_menu_id = 'tfp-menu-' . $item['key']; ?>
					<div class="tfp-nav__group" data-tfp-nav-item>
						<a class="tfp-nav__link tfp-nav__link--parent" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						<button type="button" class="tfp-nav__caret-btn" id="tfp-btn-<?php echo esc_attr( $item['key'] ); ?>" aria-controls="<?php echo esc_attr( $tfp_menu_id ); ?>" aria-expanded="false" data-tfp-submenu-toggle>
							<span class="tfp-nav__caret" aria-hidden="true">▾</span>
							<span class="visually-hidden">Ouvrir le menu <?php echo esc_html( $item['aide'] ); ?></span>
						</button>
						<div class="tfp-submenu <?php echo esc_attr( $item['classe'] ); ?>" id="<?php echo esc_attr( $tfp_menu_id ); ?>" role="menu" aria-labelledby="tfp-btn-<?php echo esc_attr( $item['key'] ); ?>" hidden>
							<?php foreach ( $item['items'] as $sub ) : ?>
								<a class="tfp-submenu__item" role="menuitem" href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a>
							<?php endforeach; ?>
							<?php if ( 'prestations' === $item['key'] ) : ?>
								<a class="tfp-submenu__item tfp-submenu__item--all" role="menuitem" href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>">Toutes les prestations →</a>
							<?php endif; ?>
						</div>
					</div>
				<?php else : ?>
					<a class="tfp-nav__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endif; ?>
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
