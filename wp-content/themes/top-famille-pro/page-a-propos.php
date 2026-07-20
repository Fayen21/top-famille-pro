<?php
/**
 * Page « À propos » (URL /a-propos/).
 * Titre de page WordPress attendu (H1) : « À propos de Top-Famille Pro ».
 *
 * Contenu volontairement sobre : aucun fait non vérifié (date de création,
 * effectif, certifications) n'est inventé. À enrichir avec des informations
 * réelles fournies par Top-Famille Pro avant publication définitive.
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
?>

<div class="container tfp-section">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
	<h1><?php the_title(); ?></h1>
	<p><?php esc_html_e( 'Top-Famille Pro accompagne les entreprises, commerces, cabinets et copropriétés de Bourgogne-Franche-Comté dans l\'entretien de leurs locaux, avec un fonctionnement simple : un tarif clair, un interlocuteur unique et des intervenants sélectionnés et suivis dans la durée.', 'top-famille-pro' ); ?></p>
</div>

<section class="tfp-section container">
	<div class="tfp-hero__grille">
		<div>
			<?php tfp_afficher_photo( 'portrait_audrey', __( 'Portrait d\'Audrey', 'top-famille-pro' ) ); ?>
		</div>
		<div>
			<h2><?php esc_html_e( 'Audrey, votre interlocutrice', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Audrey suit vos demandes de devis, la mise en place de votre contrat et le suivi de la prestation au quotidien, pour un contact unique plutôt que des échanges dispersés.', 'top-famille-pro' ); ?></p>
		</div>
	</div>
</section>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Notre approche', 'top-famille-pro' ); ?></h2>
		<div class="tfp-grille tfp-grille--3">
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Un tarif clair', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Un taux horaire unique, détaillé sur notre page tarifs, sans grille complexe.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Des intervenants suivis', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Sélection avant affectation, remplacement organisé en cas d\'absence, suivi régulier.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Une couverture régionale', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Un siège à Saint-Apollinaire, une intervention en Bourgogne-Franche-Comté.', 'top-famille-pro' ); ?></p>
			</div>
		</div>
	</div>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
</div>

<?php get_footer(); ?>
