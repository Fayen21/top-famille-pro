<?php
/**
 * Gabarit de secours générique (WordPress l'exige). Les familles de contenu réelles
 * (pages statiques, prestations, zones, articles) auront leur propre gabarit dédié à partir
 * de la phase 2 (docs/INVENTAIRE-ROUTES.md). Celui-ci ne doit jamais s'afficher en usage
 * normal une fois la phase 2 terminée — il évite seulement une page blanche ou une erreur
 * fatale d'ici là.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

tfp_seo(
	array(
		'title'       => wp_strip_all_tags( get_the_title() ) . ' | ' . get_bloginfo( 'name' ),
		'description' => wp_strip_all_tags( get_the_excerpt() ),
		'robots'      => 'noindex,follow', // Gabarit non finalisé : ne pas indexer avant la phase 2.
	)
);

get_header();
?>
<div class="tfp-container tfp-section">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_title( '<h1>', '</h1>' );
			the_content();
		}
	} else {
		echo '<p>Aucun contenu.</p>';
	}
	?>
</div>
<?php
get_footer();
