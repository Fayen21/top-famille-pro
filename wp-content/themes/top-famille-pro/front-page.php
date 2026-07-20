<?php
/**
 * Page d'accueil. S'applique à la page statique définie dans
 * Réglages > Lecture comme page d'accueil du site (l'image mise en avant
 * de cette page sert de photo de hero).
 */
get_header();

$temoignages = tfp_get_temoignages_publies( 3 );
?>

<section class="tfp-hero">
	<div class="container tfp-hero__grille">
		<div>
			<h1><?php esc_html_e( 'Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté', 'top-famille-pro' ); ?></h1>
			<p><?php esc_html_e( 'Top-Famille Pro entretient vos bureaux, commerces, cabinets et parties communes avec des intervenants sélectionnés et un interlocuteur unique pour le suivi de votre contrat.', 'top-famille-pro' ); ?></p>
			<p class="tfp-hero__tarif">
				<?php
				printf(
					/* translators: %s: tarif horaire */
					esc_html__( 'À partir de %s € HT/h', 'top-famille-pro' ),
					esc_html( tfp_get_donnee( 'tarif_horaire' ) )
				);
				?>
				— <?php printf( esc_html__( 'devis sous %s h', 'top-famille-pro' ), esc_html( tfp_get_donnee( 'delai_devis_heures' ) ) ); ?>
			</p>
			<div class="tfp-hero__actions">
				<?php tfp_bouton_devis(); ?>
				<?php tfp_bouton_appeler(); ?>
			</div>
		</div>
		<div>
			<?php tfp_image_hero( get_post_thumbnail_id(), __( 'Intervention de nettoyage professionnel dans des bureaux', 'top-famille-pro' ), 'tfp-image-placeholder--hero' ); ?>
		</div>
	</div>
</section>

<section class="tfp-section container">
	<?php get_template_part( 'template-parts/content/bandeau-preuves' ); ?>
</section>

<section class="tfp-section container">
	<h2><?php esc_html_e( 'Nos prestations principales', 'top-famille-pro' ); ?></h2>
	<div class="tfp-grille tfp-grille--2">
		<article class="tfp-carte">
			<h3><a href="<?php echo esc_url( home_url( '/nettoyage-de-bureaux/' ) ); ?>"><?php esc_html_e( 'Nettoyage de bureaux', 'top-famille-pro' ); ?></a></h3>
			<p><?php esc_html_e( 'Espaces de travail, sanitaires, parties communes et salles de réunion, sur un planning adapté à votre activité.', 'top-famille-pro' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/nettoyage-de-bureaux/' ) ); ?>"><?php esc_html_e( 'En savoir plus', 'top-famille-pro' ); ?></a>
		</article>
		<article class="tfp-carte">
			<h3><a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Commerces et locaux professionnels', 'top-famille-pro' ); ?></a></h3>
			<p><?php esc_html_e( 'Entretien régulier ou ponctuel adapté aux contraintes d\'ouverture de votre commerce.', 'top-famille-pro' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Voir toutes les prestations', 'top-famille-pro' ); ?></a>
		</article>
		<article class="tfp-carte">
			<h3><a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Cabinets et professions libérales', 'top-famille-pro' ); ?></a></h3>
			<p><?php esc_html_e( 'Discrétion et régularité pour les cabinets médicaux, paramédicaux et professions libérales.', 'top-famille-pro' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Voir toutes les prestations', 'top-famille-pro' ); ?></a>
		</article>
		<article class="tfp-carte">
			<h3><a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Copropriétés et parties communes', 'top-famille-pro' ); ?></a></h3>
			<p><?php esc_html_e( 'Halls, escaliers, ascenseurs et locaux communs entretenus sur un rythme défini avec le syndic.', 'top-famille-pro' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>"><?php esc_html_e( 'Voir toutes les prestations', 'top-famille-pro' ); ?></a>
		</article>
	</div>
</section>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Pourquoi choisir Top-Famille Pro', 'top-famille-pro' ); ?></h2>
		<div class="tfp-grille tfp-grille--3">
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Tarif clair', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Un taux horaire unique, sans grille complexe, détaillé sur notre page tarifs.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Interlocuteur unique', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Un seul contact pour la mise en place, le suivi et toute demande particulière.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Intervenants sélectionnés', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Recrutement soigné et remplacement organisé en cas d\'absence, pour un service continu.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Matériel professionnel', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Produits et équipements adaptés à chaque type de surface et de local.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Sans engagement long', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Un contrat lisible, ajustable selon l\'évolution de vos besoins.', 'top-famille-pro' ); ?></p>
			</div>
			<div class="tfp-carte">
				<h3><?php esc_html_e( 'Suivi régulier', 'top-famille-pro' ); ?></h3>
				<p><?php esc_html_e( 'Cahier de liaison et points de suivi pour ajuster la prestation dans la durée.', 'top-famille-pro' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="tfp-section container">
	<h2><?php esc_html_e( 'Comment ça se passe', 'top-famille-pro' ); ?></h2>
	<div class="tfp-grille tfp-grille--3">
		<div class="tfp-carte">
			<h3><?php esc_html_e( '1. Votre demande', 'top-famille-pro' ); ?></h3>
			<p><?php printf( esc_html__( 'Vous décrivez vos locaux et vos besoins ; nous revenons vers vous sous %s h.', 'top-famille-pro' ), esc_html( tfp_get_donnee( 'delai_devis_heures' ) ) ); ?></p>
		</div>
		<div class="tfp-carte">
			<h3><?php esc_html_e( '2. Cahier des charges', 'top-famille-pro' ); ?></h3>
			<p><?php esc_html_e( 'Nous définissons ensemble les tâches, la fréquence et les horaires d\'intervention.', 'top-famille-pro' ); ?></p>
		</div>
		<div class="tfp-carte">
			<h3><?php esc_html_e( '3. Intervention et suivi', 'top-famille-pro' ); ?></h3>
			<p><?php esc_html_e( 'L\'intervenant assigné démarre la prestation, avec un suivi régulier et un contact dédié.', 'top-famille-pro' ); ?></p>
		</div>
	</div>
	<p><a href="<?php echo esc_url( home_url( '/fonctionnement/' ) ); ?>"><?php esc_html_e( 'Voir le détail du fonctionnement', 'top-famille-pro' ); ?></a></p>
</section>

<section class="tfp-section tfp-section--turquoise">
	<div class="container">
		<h2><?php esc_html_e( 'Sélection et suivi des intervenants', 'top-famille-pro' ); ?></h2>
		<p><?php esc_html_e( 'Chaque intervenant est sélectionné avec soin avant d\'être affecté à votre site. En cas d\'absence, une solution de remplacement est recherchée pour assurer la continuité du service. Un cahier de liaison permet de garder une trace des échanges et des ajustements demandés.', 'top-famille-pro' ); ?></p>
	</div>
</section>

<section class="tfp-section container">
	<h2><?php esc_html_e( 'Une couverture régionale', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Top-Famille Pro intervient en Bourgogne-Franche-Comté, avec une présence prioritaire autour de Dijon et de la Côte-d\'Or :', 'top-famille-pro' ); ?></p>
	<p><?php echo esc_html( implode( ', ', tfp_zones_prioritaires_liste() ) ); ?>…</p>
	<p><a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>"><?php esc_html_e( 'Voir toutes les zones d\'intervention', 'top-famille-pro' ); ?></a></p>
</section>

<?php if ( ! empty( $temoignages ) ) : ?>
<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Ce que disent nos clients', 'top-famille-pro' ); ?></h2>
		<div class="tfp-grille tfp-grille--3">
			<?php foreach ( $temoignages as $avis ) : ?>
				<blockquote class="tfp-carte">
					<p>« <?php echo esc_html( wp_strip_all_tags( $avis->post_content ) ); ?> »</p>
					<footer>
						<strong><?php echo esc_html( get_the_title( $avis ) ); ?></strong>
						<?php $ville = get_post_meta( $avis->ID, '_tfp_ville', true ); ?>
						<?php if ( $ville ) : ?> — <?php echo esc_html( $ville ); ?><?php endif; ?>
					</footer>
				</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section container">
	<div class="tfp-hero__grille">
		<div>
			<?php tfp_afficher_photo( 'portrait_audrey', __( 'Portrait d\'Audrey', 'top-famille-pro' ) ); ?>
		</div>
		<div>
			<h2><?php esc_html_e( 'Audrey, votre interlocutrice', 'top-famille-pro' ); ?></h2>
			<p><?php esc_html_e( 'Audrey suit vos demandes de devis, la mise en place de votre contrat et le suivi de la prestation au quotidien. Un seul contact, pour éviter les échanges dispersés et gagner en réactivité.', 'top-famille-pro' ); ?></p>
			<?php tfp_bouton_devis( __( 'Contacter Audrey', 'top-famille-pro' ) ); ?>
		</div>
	</div>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
</div>

<?php get_footer(); ?>
