<?php
/**
 * Page statique « Avis clients » (/avis-clients/) — gabarit dédié (CLAUDE.md §3).
 *
 * Utilise le même mécanisme que l'accueil (includes/reassurance-settings.php,
 * tfp_reassurance_data()) : aucun avis fictif, uniquement les avis réels saisis par Audrey/Emmanuel
 * dans Réglages → Réassurance & avis. PROJECT_INPUTS.md §7 confirme l'existence de 6 témoignages
 * authentiques sur l'ancien site (Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie),
 * réutilisables — mais leur texte exact n'a pas été fourni dans ce dépôt : tant qu'il ne l'est pas,
 * la page reste honnête plutôt que d'inventer un contenu plausible pour des personnes réelles
 * (CLAUDE.md §5.1/§5.5).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();

tfp_seo(
	array(
		'title'       => 'Avis clients | ' . $site['brand_name'],
		'description' => 'Retours de clients sur nos prestations d\'entretien de bureaux, commerces, cabinets et copropriétés en ' . $site['address_region'] . '.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Avis clients', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'avis-clients' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-hero__eyebrow">
		<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
		<?php tfp_google_rating_badge( 'inline' ); ?>
	</div>
	<h1><?php echo esc_html( $page['h1'] ); ?></h1>
	<?php foreach ( $page['lede'] as $lede ) : ?>
		<p class="tfp-section__lede"><?php echo esc_html( $lede ); ?></p>
	<?php endforeach; ?>
	<div class="tfp-flex" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'avis-clients' ) ); ?>

<?php get_footer(); ?>
