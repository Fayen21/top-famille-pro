<?php
/**
 * 3. Prestations — fusionne le bloc « Professionnels accompagnés » du prototype (chips) en
 * tête de section plutôt que de lui consacrer une section séparée : il n'apportait qu'un titre
 * et une liste de puces, alourdissant la page pour peu d'information (brief phase 1 §6).
 * Rappelle aussi, dès l'accueil, les exclusions réelles et la fourniture du matériel par le
 * client — deux points qui qualifient les demandes en amont (PROJECT_INPUTS.md §4).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$secondary_services = array(
	array( 'title' => 'Cabinets & professions libérales', 'desc' => "Santé, droit, conseil, salles d'attente", 'url' => home_url( '/prestations/cabinets/' ) ),
	array( 'title' => 'Copropriétés & parties communes', 'desc' => "Halls, cages d'escalier, locaux communs", 'url' => home_url( '/prestations/coproprietes/' ) ),
	array( 'title' => 'Locations meublées & hébergements', 'desc' => 'Remise en état entre deux occupants', 'url' => home_url( '/prestations/meubles/' ) ),
	array( 'title' => 'Ponctuel & remise en état', 'desc' => 'Après travaux, grand nettoyage, fin de bail', 'url' => home_url( '/prestations/ponctuel/' ) ),
);
?>
<section class="tfp-container tfp-section">
	<div class="tfp-chip-row" style="margin-bottom:20px">
		<span class="tfp-chip">TPE &amp; PME</span>
		<span class="tfp-chip">Commerces</span>
		<span class="tfp-chip">Cabinets &amp; professions libérales</span>
		<span class="tfp-chip">Syndics &amp; gestionnaires</span>
		<span class="tfp-chip">Propriétaires de meublés</span>
	</div>

	<div class="tfp-flex tfp-flex--between" style="margin-bottom:24px">
		<h2 style="max-width:520px">Nos prestations de nettoyage</h2>
		<a href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>" class="tfp-link-arrow">Toutes les prestations →</a>
	</div>

	<p class="tfp-lede-rule">
		Toutes reposent sur la même méthode : celle décrite dans notre page
		<a class="tfp-underline" href="<?php echo esc_url( home_url( '/nettoyage-professionnel/' ) ); ?>">nettoyage professionnel</a> —
		périmètre écrit, intervenant habituel recherché,
		<a class="tfp-underline" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">tarif indiqué avant le devis</a>.
		Hors locaux industriels, alimentaires et locaux médicaux nécessitant une asepsie complète ; matériel et produits fournis par vos soins.
	</p>

	<div class="tfp-grid tfp-grid--autofit-lg" style="margin-bottom:16px">
		<a class="tfp-service-card" href="<?php echo esc_url( home_url( '/prestations/bureaux/' ) ); ?>">
			<?php tfp_picture( 'service-bureaux', array( 'sizes' => '(max-width: 819px) 92vw, 45vw', 'class' => 'tfp-service-card__img' ) ); ?>
			<span class="tfp-service-card__scrim" aria-hidden="true"></span>
			<span class="tfp-service-card__body">
				<span class="tfp-service-card__title">Nettoyage de bureaux</span>
				<span class="tfp-service-card__desc">Open-spaces, salles de réunion et accueil entretenus sans perturber vos équipes.</span>
				<span class="tfp-service-card__more">Découvrir →</span>
			</span>
		</a>
		<a class="tfp-service-card" href="<?php echo esc_url( home_url( '/prestations/commerces/' ) ); ?>">
			<?php tfp_picture( 'service-commerces', array( 'sizes' => '(max-width: 819px) 92vw, 45vw', 'class' => 'tfp-service-card__img' ) ); ?>
			<span class="tfp-service-card__scrim" aria-hidden="true"></span>
			<span class="tfp-service-card__body">
				<span class="tfp-service-card__title">Nettoyage de commerces</span>
				<span class="tfp-service-card__desc">Une surface de vente impeccable dès l'ouverture, avant vos premiers clients.</span>
				<span class="tfp-service-card__more">Découvrir →</span>
			</span>
		</a>
	</div>

	<div class="tfp-grid--divided tfp-grid tfp-grid--autofit-md">
		<?php foreach ( $secondary_services as $service ) : ?>
			<a class="tfp-service-tile" href="<?php echo esc_url( $service['url'] ); ?>">
				<span class="tfp-service-tile__title"><?php echo esc_html( $service['title'] ); ?></span>
				<span class="tfp-service-tile__desc"><?php echo esc_html( $service['desc'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
