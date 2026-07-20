<?php
/**
 * Traitement serveur du formulaire de devis. Fonctionne sans JavaScript
 * (validation HTML5 côté client en complément, jamais en remplacement).
 *
 * Antispam RGPD-compatible, sans service tiers : nonce WordPress +
 * honeypot masqué aux technologies d'assistance + piège temporel.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_devis_options_locaux() {
	return array(
		'bureaux'     => __( 'Bureaux', 'top-famille-pro' ),
		'commerce'    => __( 'Commerce', 'top-famille-pro' ),
		'cabinet'     => __( 'Cabinet / profession libérale', 'top-famille-pro' ),
		'copropriete' => __( 'Copropriété / parties communes', 'top-famille-pro' ),
		'meuble'      => __( 'Location meublée', 'top-famille-pro' ),
		'autre'       => __( 'Autre', 'top-famille-pro' ),
	);
}

function tfp_devis_options_taches() {
	return array(
		'sols'       => __( 'Dépoussiérage et sols', 'top-famille-pro' ),
		'sanitaires' => __( 'Sanitaires', 'top-famille-pro' ),
		'vitres'     => __( 'Vitres et surfaces vitrées', 'top-famille-pro' ),
		'cuisine'    => __( 'Cuisine / espace pause', 'top-famille-pro' ),
		'corbeilles' => __( 'Vidage des corbeilles', 'top-famille-pro' ),
		'autre'      => __( 'Autre', 'top-famille-pro' ),
	);
}

/**
 * Traité tôt (avant le rendu du template) pour pouvoir rediriger après un
 * envoi réussi (Post/Redirect/Get) et éviter une resoumission au rechargement.
 * En cas d'erreur, on ne redirige pas : on réaffiche la page avec les
 * valeurs saisies et les messages d'erreur.
 */
function tfp_handle_devis_submission() {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['tfp_devis_submit'] ) ) {
		return;
	}

	global $tfp_devis_errors, $tfp_devis_valeurs;
	$tfp_devis_errors  = array();
	$tfp_devis_valeurs = wp_unslash( $_POST );

	if ( ! isset( $_POST['tfp_devis_nonce'] ) || ! wp_verify_nonce( $_POST['tfp_devis_nonce'], 'tfp_devis_form' ) ) {
		$tfp_devis_errors['_global'] = __( 'Votre session a expiré. Merci de renvoyer le formulaire.', 'top-famille-pro' );
		return;
	}

	// Honeypot : champ masqué aux technologies d'assistance (aria-hidden +
	// hors tabulation). Un humain ne peut normalement pas le remplir.
	if ( ! empty( $_POST['tfp_champ_verification'] ) ) {
		wp_safe_redirect( add_query_arg( 'devis', 'ok', tfp_devis_page_url() ) . '#confirmation-devis' );
		exit;
	}

	// Piège temporel : un envoi en moins de 3 secondes après l'affichage
	// du formulaire est très probablement automatisé.
	$horodatage = isset( $_POST['tfp_form_horodatage'] ) ? (int) $_POST['tfp_form_horodatage'] : 0;
	if ( $horodatage <= 0 || ( time() - $horodatage ) < 3 ) {
		$tfp_devis_errors['_global'] = __( 'Votre demande n\'a pas pu être envoyée. Merci de réessayer.', 'top-famille-pro' );
		return;
	}

	$nom = sanitize_text_field( $_POST['tfp_nom'] ?? '' );
	if ( '' === trim( $nom ) ) {
		$tfp_devis_errors['tfp_nom'] = __( 'Merci d\'indiquer votre nom.', 'top-famille-pro' );
	}

	$email = sanitize_email( $_POST['tfp_email'] ?? '' );
	if ( '' === $email || ! is_email( $email ) ) {
		$tfp_devis_errors['tfp_email'] = __( 'Merci d\'indiquer une adresse e-mail valide.', 'top-famille-pro' );
	}

	$telephone = preg_replace( '/[^0-9+\s.]/', '', $_POST['tfp_telephone'] ?? '' );
	if ( '' === trim( $telephone ) ) {
		$tfp_devis_errors['tfp_telephone'] = __( 'Merci d\'indiquer un numéro de téléphone.', 'top-famille-pro' );
	}

	$locaux_choisis = array_intersect(
		(array) ( $_POST['tfp_locaux'] ?? array() ),
		array_keys( tfp_devis_options_locaux() )
	);
	if ( empty( $locaux_choisis ) ) {
		$tfp_devis_errors['tfp_locaux'] = __( 'Merci de sélectionner au moins un type de locaux.', 'top-famille-pro' );
	}

	$frequence = sanitize_text_field( $_POST['tfp_frequence'] ?? '' );
	if ( ! in_array( $frequence, array( 'regulier', 'ponctuel' ), true ) ) {
		$tfp_devis_errors['tfp_frequence'] = __( 'Merci de préciser si l\'intervention est régulière ou ponctuelle.', 'top-famille-pro' );
	}

	if ( empty( $_POST['tfp_consentement'] ) ) {
		$tfp_devis_errors['tfp_consentement'] = __( 'Merci d\'accepter l\'utilisation de vos données pour être recontacté(e).', 'top-famille-pro' );
	}

	if ( ! empty( $tfp_devis_errors ) ) {
		return;
	}

	$taches_choisies = array_intersect(
		(array) ( $_POST['tfp_taches'] ?? array() ),
		array_keys( tfp_devis_options_taches() )
	);
	$entreprise = sanitize_text_field( $_POST['tfp_entreprise'] ?? '' );
	$ville      = sanitize_text_field( $_POST['tfp_ville'] ?? '' );
	$message    = sanitize_textarea_field( $_POST['tfp_message'] ?? '' );

	$options_locaux = tfp_devis_options_locaux();
	$options_taches = tfp_devis_options_taches();

	$corps  = __( 'Nouvelle demande de devis reçue depuis le site.', 'top-famille-pro' ) . "\n\n";
	$corps .= __( 'Nom :', 'top-famille-pro' ) . ' ' . $nom . "\n";
	$corps .= __( 'E-mail :', 'top-famille-pro' ) . ' ' . $email . "\n";
	$corps .= __( 'Téléphone :', 'top-famille-pro' ) . ' ' . $telephone . "\n";
	if ( $entreprise ) {
		$corps .= __( 'Entreprise :', 'top-famille-pro' ) . ' ' . $entreprise . "\n";
	}
	if ( $ville ) {
		$corps .= __( 'Ville :', 'top-famille-pro' ) . ' ' . $ville . "\n";
	}
	$corps .= __( 'Type de locaux :', 'top-famille-pro' ) . ' ' . implode( ', ', array_map( fn( $k ) => $options_locaux[ $k ] ?? $k, $locaux_choisis ) ) . "\n";
	$corps .= __( 'Fréquence :', 'top-famille-pro' ) . ' ' . ( 'regulier' === $frequence ? __( 'Régulier', 'top-famille-pro' ) : __( 'Ponctuel', 'top-famille-pro' ) ) . "\n";
	if ( ! empty( $taches_choisies ) ) {
		$corps .= __( 'Tâches souhaitées :', 'top-famille-pro' ) . ' ' . implode( ', ', array_map( fn( $k ) => $options_taches[ $k ] ?? $k, $taches_choisies ) ) . "\n";
	}
	if ( $message ) {
		$corps .= "\n" . __( 'Message :', 'top-famille-pro' ) . "\n" . $message . "\n";
	}

	$destinataire = tfp_get_donnee( 'email' );
	if ( $destinataire ) {
		wp_mail(
			$destinataire,
			sprintf( __( 'Nouvelle demande de devis — %s', 'top-famille-pro' ), $nom ),
			$corps,
			array( 'Reply-To: ' . $nom . ' <' . $email . '>' )
		);
	}

	wp_safe_redirect( add_query_arg( 'devis', 'ok', tfp_devis_page_url() ) . '#confirmation-devis' );
	exit;
}
add_action( 'template_redirect', 'tfp_handle_devis_submission', 5 );

function tfp_devis_page_url() {
	$page = get_page_by_path( 'demande-de-devis' );
	return $page ? get_permalink( $page ) : home_url( '/demande-de-devis/' );
}
