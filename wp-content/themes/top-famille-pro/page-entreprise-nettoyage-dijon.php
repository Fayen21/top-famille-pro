<?php
/**
 * Page « Entreprise de nettoyage à Dijon » (URL /entreprise-nettoyage-dijon/).
 * Titre de page WordPress attendu (H1) : « Entreprise de nettoyage à Dijon ».
 *
 * Aucune agence physique n'est inventée à Dijon : le siège réel est à
 * Saint-Apollinaire, les données structurées utilisent cette adresse et
 * areaServed pour la couverture locale (voir inc/schema-jsonld.php).
 */
get_header();

tfp_ajouter_schema( tfp_schema_webpage( get_the_title(), get_the_excerpt() ) );
tfp_ajouter_schema(
	tfp_schema_service(
		__( 'Nettoyage professionnel à Dijon', 'top-famille-pro' ),
		__( 'Nettoyage de bureaux, commerces, cabinets et copropriétés à Dijon et dans l\'agglomération.', 'top-famille-pro' ),
		home_url( '/entreprise-nettoyage-dijon/' )
	)
);

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

<div class="container">
	<?php tfp_breadcrumb( array(
		array( 'name' => __( 'Accueil', 'top-famille-pro' ), 'url' => home_url( '/' ) ),
		array( 'name' => __( 'Zones d\'intervention', 'top-famille-pro' ), 'url' => home_url( '/zones-intervention/' ) ),
	) ); ?>
</div>

<?php
get_template_part( 'template-parts/content/hero-page', null, array(
	'intro'     => __( 'Nettoyage professionnel de bureaux, commerces, cabinets et copropriétés à Dijon et dans les communes voisines.', 'top-famille-pro' ),
	'image_alt' => __( 'Nettoyage professionnel à Dijon', 'top-famille-pro' ),
) );
?>

<article class="tfp-section container tfp-contenu-prestation">

	<h2><?php esc_html_e( 'Notre implantation à Saint-Apollinaire', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Top-Famille Pro a son siège à Saint-Apollinaire, aux portes de Dijon. Cette implantation locale nous permet d\'organiser rapidement une visite sur place avant devis lorsque c\'est utile, de répondre aux demandes urgentes dans de bons délais, et d\'assurer un suivi de proximité tout au long du contrat. Nous ne disposons pas d\'une agence ouverte au public en centre-ville de Dijon : nos équipes interviennent directement chez vous, sur rendez-vous ou selon le planning défini ensemble, ce qui nous permet de concentrer nos moyens sur la qualité de la prestation plutôt que sur des frais de vitrine.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Nos interventions à Dijon', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Chaque semaine, nos équipes interviennent dans des bureaux, des commerces, des cabinets et des copropriétés à Dijon même, ainsi que dans les communes limitrophes. Que votre local se trouve en centre-ville, dans une zone d\'activité ou en périphérie, nous établissons avec vous un cahier des charges adapté à la configuration des lieux, à vos horaires d\'ouverture et à vos contraintes d\'accès, avant toute intervention.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Qui fait appel à nous à Dijon', 'top-famille-pro' ); ?></h2>

	<h3><?php esc_html_e( 'Bureaux', 'top-famille-pro' ); ?></h3>
	<p><?php esc_html_e( 'Sièges sociaux, PME, espaces de coworking : nous entretenons les bureaux dijonnais selon un planning hebdomadaire ou plus fréquent. Le cahier des charges précise les tâches attendues dans chaque zone — open space, bureaux individuels, salles de réunion, accueil et sanitaires — ainsi que la fréquence retenue avec vous.', 'top-famille-pro' ); ?></p>

	<h3><?php esc_html_e( 'Commerces', 'top-famille-pro' ); ?></h3>
	<p><?php esc_html_e( 'Boutiques, agences et points de vente dijonnais nous confient l\'entretien de leurs locaux. Nous adaptons nos interventions aux contraintes d\'ouverture, avec un passage avant l\'ouverture, après la fermeture, ou à des horaires décalés, pour ne jamais gêner votre activité commerciale ni la présence de vos clients.', 'top-famille-pro' ); ?></p>

	<h3><?php esc_html_e( 'Cabinets et professions libérales', 'top-famille-pro' ); ?></h3>
	<p><?php esc_html_e( 'Cabinets médicaux, paramédicaux, juridiques ou comptables installés à Dijon : la discrétion et la régularité sont essentielles pour ce type de locaux. Nous intervenons sur des créneaux fixes, avec une attention particulière portée aux sanitaires, aux salles d\'attente et aux surfaces à désinfecter.', 'top-famille-pro' ); ?></p>

	<h3><?php esc_html_e( 'Copropriétés', 'top-famille-pro' ); ?></h3>
	<p><?php esc_html_e( 'Pour les copropriétés dijonnaises, nous entretenons les parties communes — halls d\'entrée, cages d\'escalier, locaux à vélos ou à poubelles, ascenseurs — en lien avec le syndic ou le conseil syndical, sur la fréquence définie en assemblée générale ou avec le gestionnaire.', 'top-famille-pro' ); ?></p>

	<h3><?php esc_html_e( 'Locations meublées', 'top-famille-pro' ); ?></h3>
	<p><?php esc_html_e( 'Propriétaires et gestionnaires de locations meublées à Dijon font appel à nous pour le nettoyage entre deux locations, ou pour un entretien régulier des parties communes d\'un immeuble comportant plusieurs biens mis en location.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Nettoyage régulier ou ponctuel', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'À Dijon comme sur le reste de notre zone d\'intervention, nous proposons deux formats. Le nettoyage régulier s\'appuie sur un contrat et un planning récurrent : quotidien, plusieurs fois par semaine, hebdomadaire ou mensuel selon vos besoins. Le nettoyage ponctuel répond à un besoin isolé : remise en état avant l\'ouverture d\'un local, grand nettoyage après travaux, ou intervention avant un événement. Les deux formats peuvent se combiner, avec un contrat régulier complété par des interventions ponctuelles lorsque la situation l\'exige.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Tâches selon les espaces', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Dans les bureaux : dépoussiérage, sols, corbeilles, sanitaires, vitres intérieures et points de contact (poignées, interrupteurs). Dans les commerces : sols, vitrines intérieures, espace d\'accueil et de caisse. Dans les cabinets : sanitaires, salles d\'attente et surfaces à désinfecter. Dans les copropriétés : halls, escaliers, rampes et locaux communs. Dans tous les cas, le détail exact des tâches est fixé avec vous dans le cahier des charges, avant le démarrage de la prestation.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Horaires d\'intervention', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Les interventions à Dijon peuvent avoir lieu avant l\'ouverture, après la fermeture, en horaires décalés en soirée ou tôt le matin, ou en journée lorsque vos locaux le permettent. L\'objectif est de ne jamais perturber votre activité, ni celle de vos occupants ou de vos clients.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Clés et accès', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Selon votre organisation, l\'accès à votre local dijonnais se fait par remise de clés, badge, code d\'accès, ou passage aux horaires d\'ouverture avec un accueil sur place. Toute remise de clés est tracée et fait l\'objet d\'un suivi rigoureux.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Produits et matériel', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Nous fournissons les produits et le matériel adaptés à chaque type de surface, sauf si vous souhaitez imposer vos propres produits pour des raisons spécifiques à votre activité — un point que nous réglons ensemble dans le cahier des charges.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Sélection des intervenants', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Les intervenants affectés aux sites dijonnais sont sélectionnés avant leur prise de poste, avec un objectif de stabilité : conserver la même personne, ou la même petite équipe, sur la durée du contrat, pour une prestation cohérente et un intervenant qui connaît bien votre site.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Absence et remplacement', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'En cas d\'absence imprévue (congés, arrêt maladie), une solution de remplacement est recherchée pour que votre planning à Dijon ne soit pas interrompu et que la continuité du service soit assurée.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Suivi de la prestation', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Un cahier de liaison accompagne chaque site : vous pouvez y noter vos remarques, et nous nous en servons pour ajuster la prestation dans la durée. Des points réguliers sont proposés pour évaluer ensemble le déroulement du contrat et l\'adapter si vos besoins évoluent.', 'top-famille-pro' ); ?></p>

	<h2><?php esc_html_e( 'Comment ça fonctionne', 'top-famille-pro' ); ?></h2>
	<p>
		<?php
		printf(
			/* translators: %s: délai de réponse en heures */
			esc_html__( 'Vous décrivez votre local à Dijon via le formulaire ou par téléphone. Nous revenons vers vous sous %s h avec une première proposition. Un cahier des charges est ensuite établi, précisant les tâches, la fréquence et les horaires. L\'intervention démarre alors, avec un suivi régulier et un cahier de liaison tout au long du contrat.', 'top-famille-pro' ),
			esc_html( tfp_get_donnee( 'delai_devis_heures' ) )
		);
		?>
	</p>

	<h2><?php esc_html_e( 'Tarif à Dijon', 'top-famille-pro' ); ?></h2>
	<p>
		<?php
		printf(
			/* translators: %s: tarif horaire */
			esc_html__( 'Le tarif horaire appliqué à Dijon est le même que sur l\'ensemble de notre zone d\'intervention : %s € HT/h. Le nombre d\'heures nécessaires dépend de la surface, de la fréquence retenue et des conditions d\'accès de votre local. Le détail des frais éventuels (mise en place, gestion, majoration) est présenté sur notre page Tarifs.', 'top-famille-pro' ),
			esc_html( tfp_get_donnee( 'tarif_horaire' ) )
		);
		?>
	</p>
</article>

<section class="tfp-section tfp-section--alt">
	<div class="container">
		<h2><?php esc_html_e( 'Exemple de budget à Dijon', 'top-famille-pro' ); ?></h2>
		<?php get_template_part( 'template-parts/content/exemple-tarifaire', null, array(
			'heures_semaine' => 3,
			'contexte'       => __( 'Bureaux à Dijon', 'top-famille-pro' ),
			'note'           => __( 'Bureaux de taille moyenne en centre-ville, 3 passages par semaine.', 'top-famille-pro' ),
		) ); ?>
	</div>
</section>

<section class="tfp-section container">
	<h2><?php esc_html_e( 'Communes desservies autour de Dijon', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'En complément de Dijon, nous intervenons régulièrement dans les communes suivantes :', 'top-famille-pro' ); ?></p>
	<?php get_template_part( 'template-parts/content/villes-liste', null, array( 'communes' => $communes_dijon ) ); ?>

	<h2><?php esc_html_e( 'Le reste de la Côte-d\'Or', 'top-famille-pro' ); ?></h2>
	<p><?php esc_html_e( 'Au-delà de l\'agglomération dijonnaise, nous intervenons plus largement en Côte-d\'Or et dans le reste de la Bourgogne-Franche-Comté. Contactez-nous pour vérifier la faisabilité selon la localisation exacte de votre local.', 'top-famille-pro' ); ?></p>
</section>

<section class="tfp-section tfp-section--turquoise">
	<div class="container">
		<h2><?php esc_html_e( 'Pour aller plus loin', 'top-famille-pro' ); ?></h2>
		<ul class="tfp-liste-puces">
			<li><a href="<?php echo esc_url( home_url( '/nettoyage-de-bureaux/' ) ); ?>"><?php esc_html_e( 'Nettoyage professionnel de bureaux', 'top-famille-pro' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>"><?php esc_html_e( 'Nos tarifs', 'top-famille-pro' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>"><?php esc_html_e( 'Toutes nos zones d\'intervention', 'top-famille-pro' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/demande-de-devis/' ) ); ?>"><?php esc_html_e( 'Demander un devis', 'top-famille-pro' ); ?></a></li>
		</ul>
	</div>
</section>

<section class="tfp-section container">
	<?php tfp_faq_bloc( tfp_get_faq_pour_page( 'entreprise-nettoyage-dijon' ), __( 'Questions fréquentes sur le nettoyage à Dijon', 'top-famille-pro' ) ); ?>
</section>

<div class="container">
	<?php get_template_part( 'template-parts/content/cta-final', null, array(
		'titre' => __( 'Un local à entretenir à Dijon ?', 'top-famille-pro' ),
	) ); ?>
	<?php tfp_afficher_date_maj(); ?>
</div>

<?php get_footer(); ?>
