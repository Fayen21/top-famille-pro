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

<?php
/*
 * Rembourrage de l'en-tête relevé sur la maquette. `.tfp-section--tight` posait
 * clamp(30px, 4vw, 52px) des deux côtés — 104 px à 1440 px contre 88 relevés.
 */
?>
<section class="tfp-container tfp-section--tight" style="--tfp-bande-haut:clamp(26px, 4vw, 48px);--tfp-bande-bas:clamp(20px, 3vw, 32px)">
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

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'avis-clients' ) ); ?>

<?php get_footer(); ?>
