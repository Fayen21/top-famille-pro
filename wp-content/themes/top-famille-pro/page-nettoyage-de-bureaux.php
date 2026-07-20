<?php
/**
 * Page « Nettoyage de bureaux » (URL /nettoyage-de-bureaux/).
 * Titre de page WordPress attendu (H1) : « Nettoyage professionnel de
 * bureaux en Bourgogne-Franche-Comté ».
 *
 * Les blocs partagés (hero, exemple tarifaire, FAQ, CTA, fil d'Ariane)
 * sont les composants réutilisables pour les futures pages de prestations ;
 * seul le contenu narratif ci-dessous est spécifique à cette prestation.
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
tfp_ajouter_schema(
	tfp_schema_service(
		__( 'Nettoyage de bureaux', 'top-famille-pro' ),
		__( 'Nettoyage professionnel régulier ou ponctuel de bureaux, en Bourgogne-Franche-Comté.', 'top-famille-pro' ),
		home_url( '/nettoyage-de-bureaux/' )
	)
);
?>

<div class="container">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
		array( 'name' => __( 'Prestations', 'top-famille-pro' ), 'url' => home_url( '/prestations/' ) ),
	) ); ?>
</div>

<?php
get_template_part( 'template-parts/content/hero-page', null, array(
	'intro'     => __( 'Un nettoyage professionnel adapté à vos bureaux, avec un interlocuteur unique pour la mise en place et le suivi.', 'top-famille-pro' ),
	'image_alt' => __( 'Nettoyage professionnel de bureaux', 'top-famille-pro' ),
) );
?>

<article class="tfp-section container tfp-contenu-prestation">

	<h2><?php esc_html_e( 'Réponse directe', 'top-famille-pro' ); ?></h2>
	<p>
		<?php
		printf(
			/* translators: 1: tarif horaire, 2: délai devis */
			esc_html__( 'Top-Famille Pro assure le nettoyage professionnel de vos bureaux en Bourgogne-Franche-Comté, à un tarif horaire unique de %1$s € HT/h. Nous intervenons selon un planning défini avec vous, avant, après ou pendant vos horaires d\'ouverture, avec des intervenants sélectionnés et suivis dans la durée. Le nombre d\'heures nécessaires dépend de la surface, de la fréquence et de l\'état de vos locaux : chaque devis est établi sur mesure, sous %2$s h.', 'top-famille-pro' ),
			esc_html( tfp_get_donnee( 'tarif_horaire' ) ),
			esc_html( tfp_get_donnee( 'delai_devis_heures' ) )
		);
		?>
	</p>

	<h2><?php esc_html_e( 'Entreprises concernées', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Cette prestation s\'adresse aux PME, sièges sociaux, espaces de coworking, professions libérales installées en bureaux, associations et administrations qui souhaitent un nettoyage régulier ou ponctuel de leurs locaux, sans avoir à gérer une équipe de ménage en interne.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Espaces entretenus', 'top-famille-pro' ); ?></h2>
	<ul class="tfp-liste-puces">
		<li><?php esc_html_e( 'Open space et bureaux individuels', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Salles de réunion', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Accueil et espaces de circulation', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Sanitaires', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Cuisine et espace pause', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Parties communes (cages d\'escalier, circulations) le cas échéant', 'top-famille-pro' ); ?></li>
	</ul>

	<h2><?php esc_html_e( 'Tâches réalisées', 'top-famille-pro' ); ?></h2>
	<ul class="tfp-liste-puces">
		<li><?php esc_html_e( 'Dépoussiérage des surfaces et du mobilier', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Aspiration et lavage des sols', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Vidage des corbeilles', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Nettoyage et désinfection des sanitaires', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Nettoyage des points de contact (poignées, interrupteurs, rampes)', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Nettoyage des vitres intérieures et surfaces vitrées accessibles', 'top-famille-pro' ); ?></li>
		<li><?php esc_html_e( 'Entretien de la cuisine et de l\'espace pause', 'top-famille-pro' ); ?></li>
	</ul>

	<h2><?php esc_html_e( 'Cahier des charges', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Avant le démarrage, nous établissons avec vous un cahier des charges qui précise les tâches à réaliser, leur fréquence, les zones concernées et les éventuelles consignes particulières (produits à éviter, zones sensibles, ordre de passage). Ce document sert de référence commune et peut être ajusté à tout moment.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Planning hebdomadaire indicatif', 'top-famille-pro' ); ?></h2>
	<div class="tfp-table-scroll">
		<table class="tfp-tableau">
			<caption class="screen-reader-text"><?php esc_html_e( 'Exemple de planning hebdomadaire de nettoyage de bureaux', 'top-famille-pro' ); ?></caption>
			<thead>
				<tr><th scope="col"><?php esc_html_e( 'Jour', 'top-famille-pro' ); ?></th><th scope="col"><?php esc_html_e( 'Tâches indicatives', 'top-famille-pro' ); ?></th></tr>
			</thead>
			<tbody>
				<tr><th scope="row"><?php esc_html_e( 'Lundi', 'top-famille-pro' ); ?></th><td><?php esc_html_e( 'Sols et corbeilles — tous espaces', 'top-famille-pro' ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Mercredi', 'top-famille-pro' ); ?></th><td><?php esc_html_e( 'Sanitaires, vitres intérieures et sols', 'top-famille-pro' ); ?></td></tr>
				<tr><th scope="row"><?php esc_html_e( 'Vendredi', 'top-famille-pro' ); ?></th><td><?php esc_html_e( 'Passage complet : sols, sanitaires, corbeilles, points de contact', 'top-famille-pro' ); ?></td></tr>
			</tbody>
		</table>
	</div>
	<p><em><?php esc_html_e( 'Planning donné à titre d\'exemple : le vôtre est défini selon vos besoins et votre cahier des charges.', 'top-famille-pro' ); ?></em></p>

	<h2><?php esc_html_e( 'Fréquences possibles', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Quotidienne, plusieurs fois par semaine, hebdomadaire ou mensuelle, selon la fréquentation de vos locaux et vos objectifs de propreté.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Horaires d\'intervention', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Avant l\'ouverture, après la fermeture, en horaires décalés, ou en journée si vos locaux le permettent — à définir ensemble selon votre organisation.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Clés et accès', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'La question de l\'accès est réglée avant le démarrage : remise de clés, badge, code d\'accès, ou passage aux horaires d\'ouverture avec un accueil sur place. Toute remise de clés fait l\'objet d\'un suivi.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Produits et matériel', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Nous fournissons les produits et le matériel nécessaires à la prestation, sauf si vous préférez utiliser vos propres produits pour des raisons spécifiques — ce point se règle dans le cahier des charges.', 'top-famille-pro' ); ?></p>
	<div class="tfp-grille tfp-grille--3">
		<div><?php tfp_afficher_photo( 'materiel', __( 'Matériel professionnel utilisé par Top-Famille Pro', 'top-famille-pro' ) ); ?></div>
		<div><?php tfp_afficher_photo( 'bureaux', __( 'Bureaux entretenus par Top-Famille Pro', 'top-famille-pro' ) ); ?></div>
		<div><?php tfp_afficher_photo( 'sanitaires', __( 'Sanitaires entretenus par Top-Famille Pro', 'top-famille-pro' ) ); ?></div>
	</div>

	<h2><?php esc_html_e( 'Sélection des intervenants', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Chaque intervenant est sélectionné avant d\'être affecté à votre site. Nous veillons à la stabilité de l\'équipe qui intervient chez vous, pour une prestation cohérente dans la durée.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Recherche de remplacement', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'En cas d\'absence (congés, maladie), une solution de remplacement est recherchée pour que votre planning ne soit pas interrompu.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Suivi de la prestation', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Un cahier de liaison permet de transmettre vos remarques et de suivre les ajustements. Des points réguliers sont proposés pour évaluer la prestation et l\'adapter si besoin.', 'top-famille-pro' ); ?></p>
	<div class="tfp-grille tfp-grille--2">
		<div><?php tfp_afficher_photo( 'cahier_de_liaison', __( 'Cahier de liaison utilisé pour le suivi', 'top-famille-pro' ) ); ?></div>
		<div><?php tfp_afficher_photo( 'partie_commune', __( 'Partie commune entretenue', 'top-famille-pro' ) ); ?></div>
	</div>
</article>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final', null, array(
		'titre' => __( 'Un projet de nettoyage de bureaux ?', 'top-famille-pro' ),
	) ); ?>
</div>

<section class="tfp-section container">
	<?php get_template_part( 'template-parts/content/exemple-tarifaire', null, array(
		'heures_semaine' => 3,
		'contexte'       => __( 'Exemple : bureaux de taille moyenne, 3 passages par semaine', 'top-famille-pro' ),
	) ); ?>
</section>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Zones d\'intervention', 'top-famille-pro' ); ?></h2>
		<p><?php echo esc_html( implode( ', ', tfp_zones_prioritaires_liste() ) ); ?>, <?php esc_html_e( 'et plus largement en Bourgogne-Franche-Comté.', 'top-famille-pro' ); ?></p>
		<p><a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>"><?php esc_html_e( 'Voir toutes les zones d\'intervention', 'top-famille-pro' ); ?></a></p>
	</div>
</section>

<section class="tfp-section container">
	<?php tfp_faq_bloc( tfp_get_faq_pour_page( 'nettoyage-de-bureaux' ), __( 'Questions fréquentes sur le nettoyage de bureaux', 'top-famille-pro' ) ); ?>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final' ); ?>
	<?php tfp_afficher_date_maj(); ?>
</div>

<?php get_footer(); ?>
