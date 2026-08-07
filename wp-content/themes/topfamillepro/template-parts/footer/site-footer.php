<?php
/**
 * Pied de page complet : coordonnées réelles, colonnes de liens, mentions légales.
 * Aucune donnée d'immatriculation (SIRET, TVA, APE) : bloquée tant que le Kbis ne l'a pas
 * confirmée (STATUS.md §6) — ne pas en ajouter ici avant cette confirmation.
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
		<span>© <?php echo esc_html( $year ); ?> <?php echo esc_html( $site['legal_name'] ); ?> — <?php echo esc_html( $site['brand_name'] ); ?></span>
		<nav aria-label="Liens légaux" style="display:flex;flex-wrap:wrap;gap:16px">
			<a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
			<a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">Confidentialité</a>
			<a href="<?php echo esc_url( home_url( '/gestion-des-cookies/' ) ); ?>">Cookies</a>
			<a href="<?php echo esc_url( home_url( '/plan-du-site/' ) ); ?>">Plan du site</a>
		</nav>
	</div>
</footer>
