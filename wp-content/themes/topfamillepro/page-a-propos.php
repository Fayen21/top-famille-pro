<?php
/**
 * Page statique « À propos » (/a-propos/) — gabarit dédié (CLAUDE.md §3).
 *
 * Identité réelle uniquement (PROJECT_INPUTS.md §1) : aucune donnée d'immatriculation (SIRET,
 * capital, APE, TVA) tant que le Kbis ne les a pas confirmées (STATUS.md §6, bloqueur de mise en
 * ligne) — ce n'est pas l'objet de cette page de toute façon, réservé aux mentions légales une
 * fois les données confirmées. Même mécanisme de portrait que l'accueil
 * (tfp_get_audrey_photo_url() / tfp_audrey_photo_is_real(), includes/customizer.php) : visuel
 * d'illustration temporaire avec alt honnête tant que la vraie photo n'est pas fournie, jamais
 * présenté comme Audrey, aucune biographie inventée.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site         = tfp_site_data();
$first_name   = explode( ' ', $site['manager'] )[0];
$audrey_photo = tfp_get_audrey_photo_url();

tfp_seo(
	array(
		'title'       => 'À propos de Top-Famille Pro | ' . $first_name . ', votre interlocutrice',
		'description' => 'Une entreprise de nettoyage implantée à Saint-Apollinaire, en périphérie de Dijon, avec une interlocutrice unique du devis au suivi.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'À propos', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'a-propos' );
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

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'a-propos' ) ); ?>

<?php get_footer(); ?>
