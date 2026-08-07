<?php
/**
 * Gabarit de secours pour les pages WordPress classiques (les 17 pages statiques hors
 * accueil — CLAUDE.md §3). Les gabarits définitifs par page seront construits en phase 2 ;
 * celui-ci reste en noindex tant que le contenu réel n'est pas en place, pour ne jamais
 * indexer une page à moitié construite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

tfp_seo(
	array(
		'title'       => wp_strip_all_tags( get_the_title() ) . ' | ' . get_bloginfo( 'name' ),
		'description' => wp_strip_all_tags( get_the_excerpt() ),
		'robots'      => 'noindex,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => wp_strip_all_tags( get_the_title() ), 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>
<div class="tfp-container tfp-section">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_title( '<h1>', '</h1>' );
			the_content();
		}
	}
	?>
</div>
<?php
get_footer();
