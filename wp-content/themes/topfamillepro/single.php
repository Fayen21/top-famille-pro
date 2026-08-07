<?php
/**
 * Gabarit de secours pour les articles (type natif `post`, catégorie « Conseils » —
 * CLAUDE.md §3). Le gabarit définitif (réponse directe, sommaire, FAQ, Article JSON-LD) sera
 * construit en phase 2 ; celui-ci reste en noindex tant que le contenu réel n'est pas en place.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

tfp_seo(
	array(
		'title'       => wp_strip_all_tags( get_the_title() ) . ' | ' . get_bloginfo( 'name' ),
		'description' => wp_strip_all_tags( get_the_excerpt() ),
		'type'        => 'article',
		'robots'      => 'noindex,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Conseils', 'url' => home_url( '/conseils/' ) ),
			array( 'label' => wp_strip_all_tags( get_the_title() ), 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container tfp-container--narrow">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>
<article class="tfp-container tfp-container--narrow tfp-section">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_title( '<h1>', '</h1>' );
			the_content();
		}
	}
	?>
</article>
<?php
get_footer();
