<?php
/**
 * 4. Problèmes résolus — objections concrètes traitées avant qu'elles ne soient posées.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$problems = array(
	array( 'title' => 'Un intervenant absent', 'desc' => 'Nous recherchons une solution de remplacement pour maintenir la continuité et vous tenons informé.' ),
	array( 'title' => 'Des consignes mal transmises', 'desc' => 'Un cahier de liaison reste sur place et trace chaque passage, chaque consigne et chaque remarque.' ),
	// Texte repris mot pour mot de la maquette (décision du 10 août 2026 : reproduire d'abord, les
	// formulations seront revues ensuite). La correction « interlocutrice » de CLAUDE.md §9 est
	// levée ici : elle ne corrigeait ni un tarif, ni une donnée légale, ni une décision
	// commerciale — les trois seuls motifs de s'écarter du prototype.
	array( 'title' => 'Aucun suivi réel', 'desc' => 'Un interlocuteur identifié suit votre dossier, ajuste la prestation et vous répond directement.' ),
	array( 'title' => 'Difficile de recruter', 'desc' => "Nous sélectionnons et gérons les intervenants ; vous n'avez pas à gérer l'embauche ni l'administratif." ),
	array( 'title' => "L'organisation des clés", 'desc' => "Les modalités d'accès (clés, badge, code) sont définies avec vous et consignées." ),
	array( 'title' => "Nettoyer hors ouverture", 'desc' => "Nous intervenons tôt, tard ou en dehors des horaires d'ouverture sur demande." ),
);
?>
<section class="tfp-section tfp-section--navy">
	<div class="tfp-container">
		<h2 style="max-width:620px">Les difficultés que nous prenons en charge</h2>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:32px">
			<?php foreach ( $problems as $problem ) : ?>
				<div class="tfp-problem">
					<div class="tfp-problem__title"><?php echo esc_html( $problem['title'] ); ?></div>
					<p class="tfp-problem__desc"><?php echo esc_html( $problem['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
