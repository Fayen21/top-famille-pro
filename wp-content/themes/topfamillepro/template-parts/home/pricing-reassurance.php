<?php
/**
 * 2. Bandeau tarifaire + réassurance.
 *
 * Décision du 14 octobre 2026 : le bouton « Voir les tarifs » appartient au MÊME groupe visuel que le
 * prix — juste à côté de la pastille marine, jamais isolé sur une seconde ligne à l'extrémité droite
 * d'un bandeau vide. Le bandeau est le composant PARTAGÉ tfp_bande_tarif() : l'accueil et les
 * pages statiques relevées sur la maquette composent le même.
 *
 * Aucune fausse note Google ici (docs/DONNEES-FICTIVES.md) : la grille de réassurance n'affiche
 * que des faits confirmés (PROJECT_INPUTS.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();
?>
<section class="tfp-container tfp-price-band-section">
	<?php tfp_bande_tarif(); ?>
</section>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-reassurance">
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title"><?php echo esc_html( $site['address_city'] ); ?></div>
			<div class="tfp-reassurance__desc">Entreprise régionale basée en BFC</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Interlocutrice identifiée</div>
			<div class="tfp-reassurance__desc"><?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?>, du devis au suivi</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Intervenants sélectionnés</div>
			<div class="tfp-reassurance__desc">Régulier ou ponctuel</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Tarif transparent</div>
			<div class="tfp-reassurance__desc">Annoncé avant le devis</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Réponse sous 24 h</div>
			<div class="tfp-reassurance__desc">Devis gratuit, sans engagement</div>
		</div>
	</div>
</section>
