<?php
/**
 * Page statique « Nos prestations » (/prestations/) — gabarit dédié (CLAUDE.md §3), sélectionné
 * automatiquement par WordPress via page-{slug}.php pour la Page du même slug.
 *
 * Simple index des 6 prestations réelles (CPT `prestation`), sans contenu éditorial propre à
 * dupliquer : chaque prestation a déjà sa page dédiée avec sa réponse directe et sa FAQ.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$prestations = get_posts(
	array(
		'post_type'      => 'prestation',
		'posts_per_page'  => -1,
		'orderby'         => 'menu_order title',
		'order'           => 'ASC',
	)
);

tfp_seo(
	array(
		'title'       => 'Nos prestations de nettoyage professionnel | ' . $site['brand_name'],
		'description' => "Six prestations d'entretien professionnel : bureaux, commerces, cabinets, copropriétés, locations meublées et nettoyage ponctuel, dans toute la {$site['address_region']}.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Nos prestations', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'prestations' );
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
	<?php
	/*
	 * Le prototype ne pose qu'UN lède par en-tête : les paragraphes d'introduction suivants y sont
	 * écrits en 16 px / 1,6, un cran sous le premier. Répéter la classe du lède donnait deux
	 * paragraphes de même poids — la hiérarchie voulue disparaissait, et l'en-tête gagnait
	 * une cinquantaine de pixels à 1440 px.
	 */
	foreach ( $page['lede'] as $rang => $lede ) :
		?>
		<p class="<?php echo 0 === $rang ? 'tfp-section__lede' : 'tfp-section__sublede'; ?>"><?php echo esc_html( $lede ); ?></p>
		<?php
	endforeach;
	?>
	<div class="tfp-action-row" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'prestations' ) ); ?>

<?php get_footer(); ?>
