<?php
/**
 * Pied de page complet : coordonnées réelles, colonnes de liens, mentions légales.
 * Ligne légale volontairement concise (raison sociale, forme juridique, capital, SIRET, lien
 * vers les mentions légales) — la version complète (RCS, APE, TVA, activité) est réservée à la
 * page /mentions-legales/, pas répétée sur les 53 pages du site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();
$year = gmdate( 'Y' );
?>
<footer class="tfp-footer">
	<div class="tfp-footer__inner">
		<div class="tfp-footer__col">
			<h3><?php echo esc_html( $site['brand_name'] ); ?></h3>
			<p style="font-size:14px;line-height:1.6;max-width:320px">
				Entreprise de nettoyage professionnel basée à <?php echo esc_html( $site['address_city'] ); ?>, intervenant dans toute la <?php echo esc_html( $site['address_region'] ); ?>.
			</p>
			<ul style="margin-top:16px">
				<li><a href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>">☎ <?php echo esc_html( $site['phone'] ); ?></a></li>
				<li><a href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a></li>
				<li><?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?></li>
			</ul>
		</div>

		<div class="tfp-footer__col">
			<h3>Prestations</h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/prestations/bureaux/' ) ); ?>">Bureaux</a></li>
				<li><a href="<?php echo esc_url( home_url( '/prestations/commerces/' ) ); ?>">Commerces</a></li>
				<li><a href="<?php echo esc_url( home_url( '/prestations/cabinets/' ) ); ?>">Cabinets</a></li>
				<li><a href="<?php echo esc_url( home_url( '/prestations/coproprietes/' ) ); ?>">Copropriétés</a></li>
				<li><a href="<?php echo esc_url( home_url( '/prestations/meubles/' ) ); ?>">Locations meublées</a></li>
				<li><a href="<?php echo esc_url( home_url( '/prestations/ponctuel/' ) ); ?>">Ponctuel</a></li>
			</ul>
		</div>

		<div class="tfp-footer__col">
			<h3>Zones d'intervention</h3>
			<ul>
				<?php
				foreach ( $site['departements'] as $dept_name ) :
					$slug = sanitize_title( remove_accents( $dept_name ) );
					?>
					<li><a href="<?php echo esc_url( home_url( '/zones-intervention/' . $slug . '/' ) ); ?>"><?php echo esc_html( $dept_name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="tfp-footer__col">
			<h3>Entreprise</h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/pourquoi-nous/' ) ); ?>">Pourquoi nous</a></li>
				<li><a href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>">Notre fonctionnement</a></li>
				<li><a href="<?php echo esc_url( home_url( '/avis-clients/' ) ); ?>">Avis clients</a></li>
				<li><a href="<?php echo esc_url( home_url( '/a-propos/' ) ); ?>">À propos</a></li>
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
