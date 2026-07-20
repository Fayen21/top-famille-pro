<?php
/**
 * Page « Fonctionnement » (URL /fonctionnement/).
 * Titre de page WordPress attendu (H1) : « Comment fonctionne une
 * prestation Top-Famille Pro ».
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
?>

<div class="container tfp-section">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
	<h1><?php the_title(); ?></h1>
	<p><?php esc_html_e( 'De la première demande au suivi dans la durée, voici comment se déroule une prestation avec Top-Famille Pro.', 'top-famille-pro' ); ?></p>
</div>

<section class="tfp-section container">
	<div class="tfp-grille tfp-grille--2">
		<article class="tfp-carte">
			<h2><?php esc_html_e( '1. Votre demande', 'top-famille-pro' ); ?></h2>
			<p><?php printf( esc_html__( 'Vous décrivez vos locaux via le formulaire de devis ou par téléphone. Nous revenons vers vous sous %s h.', 'top-famille-pro' ), esc_html( tfp_get_donnee( 'delai_devis_heures' ) ) ); ?></p>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( '2. Cahier des charges', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Nous définissons ensemble les tâches, la fréquence, les horaires et les conditions d\'accès à vos locaux.', 'top-famille-pro' ); ?></p>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( '3. Sélection de l\'intervenant', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Un intervenant est sélectionné et affecté à votre site, avec pour objectif la stabilité dans la durée.', 'top-famille-pro' ); ?></p>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( '4. Démarrage de la prestation', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'L\'intervention démarre selon le planning défini, avec les produits et le matériel nécessaires.', 'top-famille-pro' ); ?></p>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( '5. Suivi et ajustements', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Un cahier de liaison et des points réguliers permettent d\'ajuster la prestation si vos besoins évoluent.', 'top-famille-pro' ); ?></p>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( '6. Continuité de service', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'En cas d\'absence de l\'intervenant habituel, une solution de remplacement est recherchée.', 'top-famille-pro' ); ?></p>
		</article>
	</div>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
</div>

<?php get_footer(); ?>
