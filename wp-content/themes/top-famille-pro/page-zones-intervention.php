<?php
/**
 * Page « Zones d'intervention » (URL /zones-intervention/).
 * Titre de page WordPress attendu (H1) : « Zones d'intervention en
 * Bourgogne-Franche-Comté ».
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );

$communes_dijon = array(
	__( 'Chenôve', 'top-famille-pro' ),
	__( 'Talant', 'top-famille-pro' ),
	__( 'Fontaine-lès-Dijon', 'top-famille-pro' ),
	__( 'Saint-Apollinaire', 'top-famille-pro' ),
	__( 'Quetigny', 'top-famille-pro' ),
	__( 'Longvic', 'top-famille-pro' ),
	__( 'Marsannay-la-Côte', 'top-famille-pro' ),
	__( 'Daix', 'top-famille-pro' ),
	__( 'Ahuy', 'top-famille-pro' ),
	__( 'Plombières-lès-Dijon', 'top-famille-pro' ),
);
?>

<div class="container tfp-section">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
	<h1><?php the_title(); ?></h1>
	<p><?php esc_html_e( 'Top-Famille Pro intervient en Bourgogne-Franche-Comté, avec une présence prioritaire à Dijon et dans l\'agglomération dijonnaise, depuis notre siège de Saint-Apollinaire.', 'top-famille-pro' ); ?></p>
</div>

<section class="tfp-section container">
	<h2><?php esc_html_e( 'Dijon et son agglomération', 'top-famille-pro' ); ?></h2>
	<p><a href="<?php echo esc_url( home_url( '/entreprise-nettoyage-dijon/' ) ); ?>"><?php esc_html_e( 'Voir notre page dédiée à Dijon', 'top-famille-pro' ); ?></a></p>
	<?php get_template_part( 'template-parts/content/villes-liste', null, array( 'communes' => $communes_dijon ) ); ?>
</section>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Reste de la Côte-d\'Or et de la Bourgogne-Franche-Comté', 'top-famille-pro' ); ?></h2>
		<p><?php esc_html_e( 'Au-delà de nos zones prioritaires, nous étudions toute demande sur le reste de la Côte-d\'Or et de la région Bourgogne-Franche-Comté. Contactez-nous pour vérifier la faisabilité selon la localisation exacte de votre local.', 'top-famille-pro' ); ?></p>
	</div>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
</div>

<?php get_footer(); ?>
