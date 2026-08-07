<?php
/**
 * Page statique « Contact » (/contact/) — gabarit dédié (CLAUDE.md §3).
 *
 * Coordonnées réelles uniquement (PROJECT_INPUTS.md §1) : Audrey (gérante) et Manon (assistante).
 * L'adresse de Saint-Apollinaire est présentée comme siège social, jamais comme une agence ou un
 * point d'accueil visitable (CLAUDE.md §5.2 : un seul établissement, aucune agence locale).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Contacter Top-Famille Pro | Nettoyage professionnel',
		'description' => 'Téléphone, e-mail ou formulaire : Audrey répond sous 24 heures aux questions sur les prestations, les tarifs et les zones couvertes.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Contact', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Contacter Top-Famille Pro</h1>
	<p style="max-width:640px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Une question sur les prestations, les tarifs ou une zone couverte ? <?php echo esc_html( $site['manager'] ); ?> répond sous 24 heures.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-grid tfp-grid--autofit-md">
		<div class="tfp-card">
			<h2 style="font-size:19px;margin-bottom:10px"><?php echo esc_html( $site['manager'] ); ?></h2>
			<p style="color:var(--color-text-tertiary);margin-bottom:10px">Gérante — votre interlocutrice pour les devis et le suivi</p>
			<p><a href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>" class="tfp-link-arrow">☎ <?php echo esc_html( $site['phone'] ); ?></a></p>
			<p style="margin-top:6px"><a href="mailto:<?php echo esc_attr( $site['email'] ); ?>" class="tfp-link-arrow">✉ <?php echo esc_html( $site['email'] ); ?></a></p>
		</div>
		<div class="tfp-card">
			<h2 style="font-size:19px;margin-bottom:10px">Siège social</h2>
			<p style="color:var(--color-text-secondary)"><?php echo esc_html( $site['brand_name'] ); ?><br><?php echo esc_html( $site['address_street'] ); ?><br><?php echo esc_html( $site['address_cp'] . ' ' . $site['address_city'] ); ?></p>
			<p style="margin-top:10px;font-size:13px;color:var(--color-text-tertiary)">Adresse administrative — intervention sur site chez vous, pas d'accueil du public à cette adresse.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:640px">
		<h2>Une demande précise ?</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary)">Pour un devis, décrivez directement vos locaux et votre besoin via le formulaire dédié : la réponse est plus rapide et plus précise qu'un échange initial par téléphone.</p>
		<p style="margin-top:16px">
			<?php tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) ); ?>
		</p>
	</div>
</section>

<?php get_footer(); ?>
