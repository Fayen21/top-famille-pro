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
<?php
/*
 * Passe commerciale du 10 novembre 2026 : le bandeau tarifaire de l'accueil est retiré. Le prix,
 * la promesse « gratuit, sous 24 h, sans engagement » et les deux commandes sont désormais groupés
 * dans le hero ; le bandeau les répétait à 100 px d'écart. Les conditions qu'il portait en propre
 * (intervention régulière ou ponctuelle, conditions écrites au devis) passent dans la grille
 * ci-dessous, qui ne répète plus ni le délai ni le tarif. Le composant tfp_bande_tarif() reste
 * utilisé par les autres pages.
 */
?>
<section class="tfp-container tfp-section--tight">
	<div class="tfp-reassurance tfp-reassurance--4">
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
			<div class="tfp-reassurance__desc">Entretien régulier ou intervention ponctuelle</div>
		</div>
		<div class="tfp-reassurance__item">
			<div class="tfp-reassurance__title">Conditions écrites</div>
			<div class="tfp-reassurance__desc">Frais et conditions d'arrêt précisés au devis</div>
		</div>
	</div>
</section>
