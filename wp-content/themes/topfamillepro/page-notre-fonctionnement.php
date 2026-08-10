<?php
/**
 * Page statique « Notre fonctionnement » (/notre-fonctionnement/) — gabarit dédié (CLAUDE.md §3).
 *
 * Développe les 4 temps réels de PROJECT_INPUTS.md §8, sans invention de délai ou de fréquence
 * opérationnelle non confirmée (CLAUDE.md §5.1).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

/*
 * Pas de `FAQPage` sur cette page : la maquette n'y met aucune FAQ visible, et le corps de page
 * est rendu depuis le contenu relevé du prototype. Le gabarit portait jusqu'ici quatre questions
 * déclarées en données structurées mais absentes de l'écran — contraire à CLAUDE.md §8 et aux
 * règles de Google sur les résultats enrichis, qui exigent que le balisage décrive un contenu que
 * le visiteur voit. Vérifié en continu par tools/audit-jsonld.mjs.
 *
 * Les quatre étapes et les quatre questions qui vivaient ici en dur sont devenues du contenu
 * relevé (bin/seed-fidelite-pages.php) : les garder aurait produit deux sources pour un même écran.
 */
$schema = array();

tfp_seo(
	array(
		'title'       => 'Notre fonctionnement, du devis au suivi | ' . $site['brand_name'],
		'description' => 'Premier échange, devis, sélection de l\'intervenant et suivi : les étapes d\'une prestation d\'entretien chez Top-Famille Pro.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Notre fonctionnement', 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'notre-fonctionnement' );
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

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'notre-fonctionnement' ) ); ?>

<?php get_footer(); ?>
