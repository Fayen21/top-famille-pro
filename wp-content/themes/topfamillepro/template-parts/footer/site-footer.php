<?php
/**
 * Pied de page complet, reproduisant celui de la maquette Claude Design : bloc marque avec
 * coordonnées et note Google, colonne « Prestations », colonne « Zones d'intervention » détaillée
 * par département, colonne « Informations », puis la barre légale.
 *
 * Deux écarts assumés par rapport à la maquette, tous deux imposés par une règle qui prime sur la
 * fidélité visuelle (CLAUDE.md §5.5 et §8) :
 *  - la maquette affiche « 5,0/5 · 47 avis » : la note est réelle et confirmée, le compteur de 47
 *    avis ne l'est pas. Seule la note est rendue, le compteur n'apparaît que si le nombre réel est
 *    saisi dans Réglages → Réassurance & avis ;
 *  - la maquette pointe ce badge vers `href="#"`. Aucun lien mort n'est publié : le badge n'est
 *    cliquable que lorsque l'URL réelle de la fiche Google est renseignée.
 *
 * Ligne légale volontairement concise (raison sociale, forme juridique, capital, SIRET, lien vers
 * les mentions légales) — la version complète (RCS, APE, TVA, activité) est réservée à la page
 * /mentions-legales/, pas répétée sur les 53 pages du site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$year   = gmdate( 'Y' );
$prenom = explode( ' ', $site['manager'] )[0];

$prestations = get_posts(
	array(
		'post_type'   => 'prestation',
		'numberposts' => -1,
		'orderby'     => 'menu_order title',
		'order'       => 'ASC',
	)
);
$zones = tfp_footer_zones_tree();
?>
<footer class="tfp-footer">
	<section class="tfp-prefooter">
		<div class="tfp-prefooter__inner">
			<p class="tfp-prefooter__text">
				<strong>Un besoin d'entretien pour vos locaux ?</strong>
				<?php echo esc_html( $prenom ); ?> étudie votre demande et vous transmet un devis clair sous 24 heures.
			</p>
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'primary',
				)
			);
			tfp_button(
				array(
					'label'   => '☎ ' . $site['phone'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'secondary',
				)
			);
			?>
		</div>
	</section>
	<div class="tfp-footer__inner">
		<div class="tfp-footer__col tfp-footer__col--brand">
			<div class="tfp-footer__brand">
				<img class="tfp-footer__logo" src="<?php echo esc_url( TFP_THEME_URI . '/assets/dist/images/logo-horizontal.png' ); ?>" alt="" width="110" height="58" loading="lazy" decoding="async">
				<span class="tfp-footer__brand-name"><?php echo esc_html( $site['brand_name'] ); ?></span>
			</div>
			<p class="tfp-footer__tagline">Nettoyage professionnel régulier ou ponctuel en <?php echo esc_html( $site['address_region'] ); ?>.</p>
			<ul class="tfp-footer__contact">
				<li><a href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>">☎ <?php echo esc_html( $site['phone'] ); ?></a></li>
				<li><a href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a></li>
				<li><?php echo esc_html( $site['address_city'] . ' (' . $site['address_cp'] . ')' ); ?></li>
			</ul>
			<?php tfp_google_rating_badge( 'footer' ); ?>
		</div>

		<div class="tfp-footer__col">
			<h3>Prestations</h3>
			<ul>
				<?php foreach ( $prestations as $prestation ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $prestation ) ); ?>"><?php echo esc_html( tfp_get_field( 'nav_label', $prestation->ID ) ?: get_the_title( $prestation ) ); ?></a></li>
				<?php endforeach; ?>
				<li><a class="tfp-footer__more" href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>">Toutes les prestations →</a></li>
			</ul>
		</div>

		<div class="tfp-footer__col tfp-footer__col--zones">
			<h3>Zones d'intervention</h3>
			<a class="tfp-footer__more" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>">Toute la <?php echo esc_html( $site['address_region'] ); ?> →</a>
			<p class="tfp-footer__zones-label">Villes principales par département</p>
			<ul class="tfp-footer__zones">
				<?php foreach ( $zones as $entry ) : ?>
					<li>
						<a class="tfp-footer__dept" href="<?php echo esc_url( get_permalink( $entry['post'] ) ); ?>"><?php echo esc_html( get_the_title( $entry['post'] ) ); ?></a>
						<?php if ( ! empty( $entry['villes'] ) ) : ?>
							<span class="tfp-footer__villes">
								<?php foreach ( $entry['villes'] as $i => $ville ) : ?>
									<?php if ( $i ) : ?><span aria-hidden="true"> · </span><?php endif; ?>
									<a href="<?php echo esc_url( get_permalink( $ville ) ); ?>"><?php echo esc_html( get_the_title( $ville ) ); ?></a>
								<?php endforeach; ?>
							</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="tfp-footer__zones-links">
				<a class="tfp-footer__more" href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>">Voir les <?php echo count( $zones ); ?> départements →</a>
				<a class="tfp-footer__more" href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>">Toutes les villes →</a>
			</div>
		</div>

		<div class="tfp-footer__col">
			<h3>Informations</h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Tarifs</a></li>
				<li><a href="<?php echo esc_url( home_url( '/pourquoi-nous/' ) ); ?>">Pourquoi nous</a></li>
				<li><a href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>">Fonctionnement</a></li>
				<li><a href="<?php echo esc_url( home_url( '/avis-clients/' ) ); ?>">Avis</a></li>
				<li><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">À propos</a></li>
				<li><a href="<?php echo esc_url( home_url( '/conseils/' ) ); ?>">Conseils</a></li>
				<li><a href="<?php echo esc_url( home_url( '/recrutement/' ) ); ?>">Recrutement</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
			</ul>
		</div>
	</div>

	<div class="tfp-footer__bottom">
		<span>© <?php echo esc_html( $year ); ?> <?php echo esc_html( $site['legal_name'] ); ?> au capital de <?php echo esc_html( $site['legal_capital_display'] ); ?>, SIRET <?php echo esc_html( $site['legal_siret'] ); ?> — <?php echo esc_html( $site['brand_name'] ); ?></span>
		<nav aria-label="Liens légaux" style="display:flex;flex-wrap:wrap;gap:16px">
			<a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
			<a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">Confidentialité</a>
			<a href="<?php echo esc_url( home_url( '/gestion-des-cookies/' ) ); ?>">Cookies</a>
			<a href="<?php echo esc_url( home_url( '/plan-du-site/' ) ); ?>">Plan du site</a>
		</nav>
	</div>
</footer>
