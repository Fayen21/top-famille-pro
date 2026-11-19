<?php
/**
 * 3. « Pensé pour les professionnels de la région » — bloc 4 du prototype Claude Design.
 *
 * Absent du thème jusqu'au 9 août 2026 (hotfix de fidélité) : la section existait dans la maquette
 * mais n'avait jamais été construite, ce qui raccourcissait l'accueil d'un bloc et supprimait la
 * transition entre la réassurance et les prestations.
 *
 * Contenu entièrement factuel (types de clientèle réellement adressés, PROJECT_INPUTS.md §4) :
 * aucune donnée chiffrée, aucun effectif, aucune référence client — rien qui nécessite une
 * validation préalable.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$audiences = array(
	'TPE & PME',
	'Commerces',
	'Cabinets & professions libérales',
	'Syndics & gestionnaires',
	'Propriétaires de meublés',
);
?>
<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<div class="tfp-audiences__intro">
			<h2>Pensé pour les professionnels de la région</h2>
			<p class="tfp-audiences__lede">Du cabinet de trois personnes au plateau tertiaire, nous adaptons l'organisation à la réalité de vos locaux et de votre activité.</p>
		</div>
		<ul class="tfp-audiences__list">
			<?php foreach ( $audiences as $audience ) : ?>
				<li class="tfp-audiences__chip"><?php echo esc_html( $audience ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
