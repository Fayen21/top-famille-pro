<?php
/**
 * Source unique pour les données commerciales (tarifs, frais, coordonnées,
 * zones prioritaires). Rien de tout cela ne doit être recopié en dur dans
 * les templates : ils appellent tfp_get_donnee( 'cle' ).
 *
 * ACF Pro n'est pas installé : page d'options native (Settings API),
 * sans dépendance à un plugin payant.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TFP_OPTION_NAME', 'tfp_donnees_commerciales' );

function tfp_donnees_commerciales_defaults() {
	return array(
		'tarif_horaire'               => '26',
		'frais_mise_en_place'         => '50',
		'regle_frais_mise_en_place'   => 'À confirmer avant publication : préciser ici dans quels cas les 50 € HT de frais de mise en place s\'appliquent (ex. premher contrat uniquement, en dessous d\'un certain volume d\'heures, etc.). Tant que cette règle n\'est pas validée, aucun calcul automatique n\'est proposé sur le site.',
		'frais_gestion_mensuel'       => '9',
		'majoration_pourcentage'      => '10',
		'indemnite_kilometrique'      => '0.35',
		'delai_devis_heures'          => '24',
		'telephone'                   => '',
		'telephone_affichage'         => '',
		'email'                       => '',
		'siege_adresse'                => '',
		'siege_ville'                 => 'Saint-Apollinaire',
		'siege_code_postal'           => '',
		'zones_prioritaires'          => "Dijon\nSaint-Apollinaire\nQuetigny\nChenôve\nTalant\nFontaine-lès-Dijon\nLongvic\nMarsannay-la-Côte\nDaix\nAhuy\nPlombières-lès-Dijon",
	);
}

function tfp_get_donnees_commerciales() {
	$stored = get_option( TFP_OPTION_NAME, array() );
	return wp_parse_args( $stored, tfp_donnees_commerciales_defaults() );
}

function tfp_get_donnee( $cle ) {
	$donnees = tfp_get_donnees_commerciales();
	return isset( $donnees[ $cle ] ) ? $donnees[ $cle ] : '';
}

/**
 * Simple projection hebdomadaire -> mensuelle à partir du tarif horaire
 * centralisé. Volontairement minimaliste : n'intègre ni frais de mise en
 * place, ni frais de gestion, ni majoration, tant que la règle des 50 €
 * n'est pas confirmée (voir 'regle_frais_mise_en_place'). Toujours
 * présenté comme un exemple illustratif et non contractuel.
 */
function tfp_calcul_estimation( $heures_semaine ) {
	$tarif   = (float) tfp_get_donnee( 'tarif_horaire' );
	$semaine = $heures_semaine * $tarif;
	$mois    = $semaine * 52 / 12;
	return array(
		'heures_semaine' => $heures_semaine,
		'tarif'          => $tarif,
		'cout_semaine'   => round( $semaine, 2 ),
		'cout_mois'      => round( $mois, 2 ),
	);
}

function tfp_zones_prioritaires_liste() {
	$brut = tfp_get_donnee( 'zones_prioritaires' );
	$lignes = array_filter( array_map( 'trim', explode( "\n", $brut ) ) );
	return array_values( $lignes );
}

function tfp_register_donnees_commerciales_settings() {
	register_setting(
		'tfp_donnees_commerciales_group',
		TFP_OPTION_NAME,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'tfp_sanitize_donnees_commerciales',
			'default'           => tfp_donnees_commerciales_defaults(),
		)
	);
}
add_action( 'admin_init', 'tfp_register_donnees_commerciales_settings' );

function tfp_sanitize_donnees_commerciales( $input ) {
	$defaults = tfp_donnees_commerciales_defaults();
	$out      = array();

	$out['tarif_horaire']             = number_format( (float) str_replace( ',', '.', $input['tarif_horaire'] ?? $defaults['tarif_horaire'] ), 2, '.', '' );
	$out['frais_mise_en_place']       = number_format( (float) str_replace( ',', '.', $input['frais_mise_en_place'] ?? $defaults['frais_mise_en_place'] ), 2, '.', '' );
	$out['regle_frais_mise_en_place'] = sanitize_textarea_field( $input['regle_frais_mise_en_place'] ?? $defaults['regle_frais_mise_en_place'] );
	$out['frais_gestion_mensuel']     = number_format( (float) str_replace( ',', '.', $input['frais_gestion_mensuel'] ?? $defaults['frais_gestion_mensuel'] ), 2, '.', '' );
	$out['majoration_pourcentage']    = number_format( (float) str_replace( ',', '.', $input['majoration_pourcentage'] ?? $defaults['majoration_pourcentage'] ), 2, '.', '' );
	$out['indemnite_kilometrique']    = number_format( (float) str_replace( ',', '.', $input['indemnite_kilometrique'] ?? $defaults['indemnite_kilometrique'] ), 2, '.', '' );
	$out['delai_devis_heures']        = absint( $input['delai_devis_heures'] ?? $defaults['delai_devis_heures'] );
	$out['telephone']                 = preg_replace( '/[^0-9+]/', '', $input['telephone'] ?? '' );
	$out['telephone_affichage']       = sanitize_text_field( $input['telephone_affichage'] ?? '' );
	$out['email']                     = sanitize_email( $input['email'] ?? '' );
	$out['siege_adresse']             = sanitize_text_field( $input['siege_adresse'] ?? '' );
	$out['siege_ville']               = sanitize_text_field( $input['siege_ville'] ?? $defaults['siege_ville'] );
	$out['siege_code_postal']         = sanitize_text_field( $input['siege_code_postal'] ?? '' );
	$out['zones_prioritaires']        = sanitize_textarea_field( $input['zones_prioritaires'] ?? $defaults['zones_prioritaires'] );

	return $out;
}

function tfp_register_options_page() {
	add_menu_page(
		__( 'Données Top-Famille Pro', 'top-famille-pro' ),
		__( 'Données commerciales', 'top-famille-pro' ),
		'manage_options',
		'tfp-donnees-commerciales',
		'tfp_render_options_page',
		'dashicons-money-alt',
		59
	);
}
add_action( 'admin_menu', 'tfp_register_options_page' );

function tfp_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$d = tfp_get_donnees_commerciales();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Données commerciales — Top-Famille Pro', 'top-famille-pro' ); ?></h1>
		<p><?php esc_html_e( 'Ces valeurs alimentent automatiquement toutes les pages du site (Accueil, Tarifs, pages de prestations, pages de villes). Ne rien dupliquer ailleurs : modifier uniquement ici.', 'top-famille-pro' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'tfp_donnees_commerciales_group' ); ?>

			<h2><?php esc_html_e( 'Tarification', 'top-famille-pro' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tfp_tarif_horaire"><?php esc_html_e( 'Tarif horaire (€ HT/h)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="0.01" min="0" id="tfp_tarif_horaire" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[tarif_horaire]" value="<?php echo esc_attr( $d['tarif_horaire'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_frais_mise_en_place"><?php esc_html_e( 'Frais de mise en place (€ HT)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="0.01" min="0" id="tfp_frais_mise_en_place" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[frais_mise_en_place]" value="<?php echo esc_attr( $d['frais_mise_en_place'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_regle_frais_mise_en_place"><?php esc_html_e( 'Règle d\'application des frais de mise en place', 'top-famille-pro' ); ?></label></th>
					<td>
						<textarea id="tfp_regle_frais_mise_en_place" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[regle_frais_mise_en_place]" rows="4" class="large-text"><?php echo esc_textarea( $d['regle_frais_mise_en_place'] ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Affiché tel quel sur la page Tarifs. Tant que la règle n\'est pas confirmée, le site n\'affiche aucun calcul automatique intégrant ces frais.', 'top-famille-pro' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_frais_gestion_mensuel"><?php esc_html_e( 'Frais de gestion (€ HT/mois)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="0.01" min="0" id="tfp_frais_gestion_mensuel" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[frais_gestion_mensuel]" value="<?php echo esc_attr( $d['frais_gestion_mensuel'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_majoration_pourcentage"><?php esc_html_e( 'Majoration dimanche / jour férié / nuit (%)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="0.1" min="0" id="tfp_majoration_pourcentage" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[majoration_pourcentage]" value="<?php echo esc_attr( $d['majoration_pourcentage'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_indemnite_kilometrique"><?php esc_html_e( 'Indemnité kilométrique (€ HT/km)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="0.01" min="0" id="tfp_indemnite_kilometrique" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[indemnite_kilometrique]" value="<?php echo esc_attr( $d['indemnite_kilometrique'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_delai_devis_heures"><?php esc_html_e( 'Délai de devis (heures)', 'top-famille-pro' ); ?></label></th>
					<td><input type="number" step="1" min="1" id="tfp_delai_devis_heures" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[delai_devis_heures]" value="<?php echo esc_attr( $d['delai_devis_heures'] ); ?>" class="regular-text"></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Coordonnées', 'top-famille-pro' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tfp_telephone"><?php esc_html_e( 'Téléphone (pour les liens tel:)', 'top-famille-pro' ); ?></label></th>
					<td><input type="text" id="tfp_telephone" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[telephone]" value="<?php echo esc_attr( $d['telephone'] ); ?>" class="regular-text" placeholder="+33380000000"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_telephone_affichage"><?php esc_html_e( 'Téléphone (affichage)', 'top-famille-pro' ); ?></label></th>
					<td><input type="text" id="tfp_telephone_affichage" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[telephone_affichage]" value="<?php echo esc_attr( $d['telephone_affichage'] ); ?>" class="regular-text" placeholder="03 80 00 00 00"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_email"><?php esc_html_e( 'E-mail', 'top-famille-pro' ); ?></label></th>
					<td><input type="email" id="tfp_email" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[email]" value="<?php echo esc_attr( $d['email'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_siege_adresse"><?php esc_html_e( 'Adresse du siège (rue et numéro)', 'top-famille-pro' ); ?></label></th>
					<td><input type="text" id="tfp_siege_adresse" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[siege_adresse]" value="<?php echo esc_attr( $d['siege_adresse'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_siege_code_postal"><?php esc_html_e( 'Code postal du siège', 'top-famille-pro' ); ?></label></th>
					<td><input type="text" id="tfp_siege_code_postal" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[siege_code_postal]" value="<?php echo esc_attr( $d['siege_code_postal'] ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp_siege_ville"><?php esc_html_e( 'Ville du siège', 'top-famille-pro' ); ?></label></th>
					<td><input type="text" id="tfp_siege_ville" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[siege_ville]" value="<?php echo esc_attr( $d['siege_ville'] ); ?>" class="regular-text"></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Zones prioritaires', 'top-famille-pro' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tfp_zones_prioritaires"><?php esc_html_e( 'Une commune par ligne', 'top-famille-pro' ); ?></label></th>
					<td><textarea id="tfp_zones_prioritaires" name="<?php echo esc_attr( TFP_OPTION_NAME ); ?>[zones_prioritaires]" rows="8" class="large-text"><?php echo esc_textarea( $d['zones_prioritaires'] ); ?></textarea></td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
