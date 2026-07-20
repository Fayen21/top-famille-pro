<?php
/**
 * Page « Tarifs » (URL /tarifs/).
 * Titre de page WordPress attendu (H1) : « Nos tarifs de nettoyage
 * professionnel ».
 *
 * Tous les montants proviennent des données commerciales centralisées
 * (inc/donnees-commerciales.php). Aucun calcul lié aux frais de mise en
 * place n'est présenté comme définitif tant que la règle n'est pas validée.
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
?>

<div class="container">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
	) ); ?>
</div>

<?php
get_template_part( 'template-parts/content/hero-page', null, array(
	'intro'     => __( 'Un tarif horaire unique, sans grille complexe : ce qui varie d\'un local à l\'autre, c\'est le nombre d\'heures.', 'top-famille-pro' ),
	'image_alt' => __( 'Intervention de nettoyage professionnel', 'top-famille-pro' ),
) );
?>

<article class="tfp-section container tfp-contenu-prestation">

	<h2><?php esc_html_e( 'Tableau des frais', 'top-famille-pro' ); ?></h2>
	<div class="tfp-table-scroll">
		<table class="tfp-tableau">
			<caption class="screen-reader-text"><?php esc_html_e( 'Tableau des tarifs et frais Top-Famille Pro', 'top-famille-pro' ); ?></caption>
			<thead>
				<tr><th scope="col"><?php esc_html_e( 'Poste', 'top-famille-pro' ); ?></th><th scope="col"><?php esc_html_e( 'Montant', 'top-famille-pro' ); ?></th></tr>
			</thead>
			<tbody>
				<tr><th scope="row"><?php esc_html_e( 'Tarif horaire', 'top-famille-pro' ); ?></th><td><?php echo esc_html( tfp_get_donnee( 'tarif_horaire' ) ); ?> € HT/h</td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Frais de mise en place', 'top-famille-pro' ); ?></th><td><?php echo esc_html( tfp_get_donnee( 'frais_mise_en_place' ) ); ?> € HT</td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Frais de gestion', 'top-famille-pro' ); ?></th><td><?php echo esc_html( tfp_get_donnee( 'frais_gestion_mensuel' ) ); ?> € HT/mois</td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Majoration dimanche, jour férié ou nuit', 'top-famille-pro' ); ?></th><td>+<?php echo esc_html( tfp_get_donnee( 'majoration_pourcentage' ) ); ?> %</td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Indemnité kilométrique', 'top-famille-pro' ); ?></th><td><?php echo esc_html( tfp_get_donnee( 'indemnite_kilometrique' ) ); ?> € HT/km</td></tr>
			</tbody>
		</table>
	</div>
	<p><em><?php echo esc_html( tfp_get_donnee( 'regle_frais_mise_en_place' ) ); ?></em></p>

	<div class="tfp-grille tfp-grille--2">
		<div class="tfp-carte">
			<h3><?php esc_html_e( 'Ce qui est compris', 'top-famille-pro' ); ?></h3>
			<ul class="tfp-liste-puces">
				<li><?php esc_html_e( 'La main d\'œuvre et l\'encadrement de la prestation', 'top-famille-pro' ); ?></li>
				<li><?php esc_html_e( 'Les produits et le matériel, sauf mention contraire dans le devis', 'top-famille-pro' ); ?></li>
				<li><?php esc_html_e( 'La sélection et le suivi de l\'intervenant', 'top-famille-pro' ); ?></li>
				<li><?php esc_html_e( 'La recherche de remplacement en cas d\'absence', 'top-famille-pro' ); ?></li>
			</ul>
		</div>
		<div class="tfp-carte">
			<h3><?php esc_html_e( 'Ce qui est fourni par le client', 'top-famille-pro' ); ?></h3>
			<ul class="tfp-liste-puces">
				<li><?php esc_html_e( 'L\'accès aux locaux (clés, badge ou accueil sur place)', 'top-famille-pro' ); ?></li>
				<li><?php esc_html_e( 'Un point d\'eau et une prise électrique', 'top-famille-pro' ); ?></li>
				<li><?php esc_html_e( 'Le cas échéant, des produits spécifiques si vous en imposez l\'usage', 'top-famille-pro' ); ?></li>
			</ul>
		</div>
	</div>

	<h2><?php esc_html_e( 'Facteurs qui influencent le nombre d\'heures', 'top-famille-pro' ); ?></h2>
	<ul class="tfp-liste-puces">
		<li><?php esc_html_e( 'La surface et la configuration des locaux', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'La fréquence souhaitée', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'L\'état des lieux au démarrage', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Le nombre de sanitaires et de postes de travail', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Les conditions d\'accès et les horaires possibles', 'top-famille-pro' ); ?></li>
	</ul>
</article>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Exemples de budget', 'top-famille-pro' ); ?></h2>
		<div class="tfp-grille tfp-grille--3">
			<?php get_template_part( 'template-parts/content/exemple-tarifaire', null, array(
				'heures_semaine' => 3,
				'contexte'       => __( 'Bureaux', 'top-famille-pro' ),
				'note'           => __( 'Bureaux de taille moyenne, 3 passages par semaine.', 'top-famille-pro' ),
			) ); ?>
			<?php get_template_part( 'template-parts/content/exemple-tarifaire', null, array(
				'heures_semaine' => 5,
				'contexte'       => __( 'Commerce', 'top-famille-pro' ),
				'note'           => __( 'Commerce ouvert au public, entretien quotidien léger.', 'top-famille-pro' ),
			) ); ?>
			<?php get_template_part( 'template-parts/content/exemple-tarifaire', null, array(
				'heures_semaine' => 2,
				'contexte'       => __( 'Intervention ponctuelle', 'top-famille-pro' ),
				'note'           => __( 'Nettoyage de fond ponctuel, hors contrat régulier.', 'top-famille-pro' ),
			) ); ?>
		</div>
	</div>
</section>

<div class="container">
	<?php $photo = tfp_get_photo_id( 'presence_tarifs' ); ?>
	<?php if ( $photo ) : ?>
		<div class="tfp-section"><?php tfp_afficher_photo( 'presence_tarifs', __( 'Intervenant Top-Famille Pro sur site', 'top-famille-pro' ) ); ?></div>
	<?php endif; ?>
</div>

<section class="tfp-section container">
	<?php tfp_faq_bloc( tfp_get_faq_pour_page( 'tarifs' ), __( 'Questions fréquentes sur les tarifs', 'top-famille-pro' ) ); ?>
</section>

<section class="tfp-section tfp-section--turquoise">
	<div class="container tfp-contenu-prestation">
		<h2><?php esc_html_e( 'Obtenir une estimation personnalisée', 'top-famille-pro' ); ?></h2>
		<p><?php esc_html_e( 'Décrivez vos locaux : nous vous recontactons avec une proposition adaptée.', 'top-famille-pro' ); ?></p>
		<?php get_template_part( 'template-parts/form/devis-form' ); ?>
	</div>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
	<?php tfp_afficher_date_maj(); ?>
</div>

<?php get_footer(); ?>
