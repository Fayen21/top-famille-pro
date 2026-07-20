<?php
/**
 * Encart d'exemple tarifaire réutilisable. $args : 'heures_semaine'
 * (float), 'contexte' (texte décrivant le local), 'note' (texte facultatif).
 * Toujours purement illustratif : la règle des frais de mise en place
 * n'est pas encore confirmée, donc jamais intégrée à ce calcul.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heures   = (float) ( $args['heures_semaine'] ?? 3 );
$contexte = $args['contexte'] ?? '';
$note     = $args['note'] ?? '';
$e        = tfp_calcul_estimation( $heures );
?>
<div class="tfp-carte tfp-exemple-tarifaire">
	<h3>
		<?php
		if ( $contexte ) {
			echo esc_html( $contexte );
		} else {
			esc_html_e( 'Exemple de budget', 'top-famille-pro' );
		}
		?>
	</h3>
	<p>
		<?php
		printf(
			/* translators: 1: heures/semaine, 2: tarif horaire, 3: coût semaine HT, 4: coût mois HT */
			esc_html__( '%1$s h/semaine à %2$s € HT/h ≈ %3$s € HT/semaine, soit environ %4$s € HT/mois.', 'top-famille-pro' ),
			esc_html( $e['heures_semaine'] ),
			esc_html( number_format_i18n( $e['tarif'], 2 ) ),
			esc_html( number_format_i18n( $e['cout_semaine'], 2 ) ),
			esc_html( number_format_i18n( $e['cout_mois'], 2 ) )
		);
		?>
	</p>
	<?php if ( $note ) : ?><p><?php echo esc_html( $note ); ?></p><?php endif; ?>
	<p><em><?php esc_html_e( 'Exemple illustratif et non contractuel : frais éventuels de mise en place, de gestion ou majorations non inclus, précisés dans votre devis.', 'top-famille-pro' ); ?></em></p>
</div>
