<?php
/**
 * Page statique « Recrutement » (/recrutement/) — gabarit dédié (CLAUDE.md §3).
 *
 * CLAUDE.md §8 est explicite : cette page renvoie vers le site carrière existant
 * (careers.werecruit.io/fr/top-famille, PROJECT_INPUTS.md §1), sans dupliquer de formulaire de
 * candidature ni collecter de CV sur ce site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$careers_url = 'https://careers.werecruit.io/fr/top-famille';

tfp_seo(
	array(
		'title'       => "Recrutement — agents d'entretien | " . $site['brand_name'],
		'description' => "Nous recrutons des agents d'entretien en {$site['address_region']}. Postes, conditions et candidature sur notre site carrière.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Recrutement', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'recrutement' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-hero">
	<div class="tfp-hero__content">
		<div class="tfp-hero__eyebrow">
			<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
			<?php tfp_google_rating_badge( 'nu' ); ?>
		</div>
		<h1><?php echo esc_html( $page['h1'] ); ?></h1>
		<?php foreach ( $page['lede'] as $lede ) : ?>
			<p class="tfp-section__lede"><?php echo esc_html( $lede ); ?></p>
		<?php endforeach; ?>
		<div class="tfp-action-row" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php
			/*
			 * Visuel de hero. La maquette en pose un sur cette route ; le thème n'en rendait
			 * aucun, et le rembourrage de bande en trop masquait le manque jusqu'à G13.
			 *
			 * L'`alt` vient du manifeste et n'est PAS celui de la maquette : celui-ci présente
			 * une photo de stock comme une personne réelle de l'entreprise, ce que
			 * CLAUDE.md §5.6 interdit. Le manifeste dit « photo d'illustration », ce qui est vrai.
			 */
			tfp_picture( 'service-generic', array( 'sizes' => '(max-width: 819px) 92vw, 560px', 'lcp' => true ) );
			?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'recrutement' ) ); ?>

<?php get_footer(); ?>
