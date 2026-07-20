<?php
/**
 * Page « Prestations » (URL /prestations/) — page de liste, contenu
 * volontairement synthétique : le détail complet vit sur les pages de
 * prestation dédiées (dont /nettoyage-de-bureaux/ pour l'instant).
 * Titre de page WordPress attendu (H1) : « Nos prestations de nettoyage
 * professionnel ».
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
?>

<div class="container tfp-section">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
	<h1><?php the_title(); ?></h1>
	<p><?php esc_html_e( 'Top-Famille Pro intervient auprès des entreprises, commerces, cabinets et copropriétés de Bourgogne-Franche-Comté, avec un tarif horaire unique et un cahier des charges adapté à chaque local.', 'top-famille-pro' ); ?></p>
</div>

<section class="tfp-section container">
	<div class="tfp-grille tfp-grille--2">
		<article class="tfp-carte">
			<h2><a href="<?php echo esc_url( home_url( '/nettoyage-de-bureaux/' ) ); ?>"><?php esc_html_e( 'Nettoyage de bureaux', 'top-famille-pro' ); ?></a></h2>
			<p><?php esc_html_e( 'Open space, bureaux individuels, salles de réunion, accueil et sanitaires, sur un planning défini avec vous.', 'top-famille-pro' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/nettoyage-de-bureaux/' ) ); ?>"><?php esc_html_e( 'En savoir plus', 'top-famille-pro' ); ?></a>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( 'Commerces et locaux professionnels', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Entretien régulier ou ponctuel, avant l\'ouverture, après la fermeture ou en horaires décalés.', 'top-famille-pro' ); ?></p>
			<?php tfp_bouton_devis( __( 'Demander un devis', 'top-famille-pro' ), 'secondaire' ); ?>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( 'Cabinets et professions libérales', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Discrétion et régularité pour les cabinets médicaux, paramédicaux et professions libérales.', 'top-famille-pro' ); ?></p>
			<?php tfp_bouton_devis( __( 'Demander un devis', 'top-famille-pro' ), 'secondaire' ); ?>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( 'Copropriétés et parties communes', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Halls, escaliers, ascenseurs et locaux communs entretenus selon la fréquence définie avec le syndic.', 'top-famille-pro' ); ?></p>
			<?php tfp_bouton_devis( __( 'Demander un devis', 'top-famille-pro' ), 'secondaire' ); ?>
		</article>
		<article class="tfp-carte">
			<h2><?php esc_html_e( 'Locations meublées', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Nettoyage entre deux locations ou entretien régulier des parties communes.', 'top-famille-pro' ); ?></p>
			<?php tfp_bouton_devis( __( 'Demander un devis', 'top-famille-pro' ), 'secondaire' ); ?>
		</article>
	</div>
	<p class="tfp-mention-champs-requis"><?php esc_html_e( 'D\'autres pages de prestation détaillées seront publiées prochainement. En attendant, chaque type de local peut faire l\'objet d\'un devis personnalisé.', 'top-famille-pro' ); ?></p>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
</div>

<?php get_footer(); ?>
