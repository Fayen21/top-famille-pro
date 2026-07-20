<?php
/**
 * Gabarit de secours (obligatoire pour tout thème WordPress classique).
 * Les pages du site utilisent toutes un template dédié ; celui-ci ne sert
 * qu'aux cas non couverts (résultats de recherche, contenu imprévu).
 */
get_header();
?>

<div class="container tfp-section">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<div><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<h1><?php esc_html_e( 'Aucun contenu trouvé', 'top-famille-pro' ); ?></h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Retour à l\'accueil', 'top-famille-pro' ); ?></a></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
