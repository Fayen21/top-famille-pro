<?php
/**
 * Formulaire de contact — composant distinct du formulaire de devis.
 *
 * La maquette Claude Design distingue deux parcours, et c'est une distinction commerciale, pas
 * cosmétique : « J'ai une question » ouvre un formulaire court dont la réponse tient en un
 * message, « J'ai un besoin de nettoyage » mène au formulaire de devis en deux étapes, qui
 * qualifie une demande. Renvoyer la première intention vers le second parcours faisait abandonner
 * les visiteurs qui n'ont qu'une question à poser.
 *
 * Le formulaire de devis (`quote-form.php`) n'est pas touché : les deux coexistent, avec leur
 * propre action, leur propre nonce et leur propre limitation de débit.
 *
 * Champs relevés sur la route `#/contact` : nom, entreprise (facultatif), e-mail, téléphone
 * (facultatif), objet parmi cinq valeurs, message, consentement.
 *
 * @package topfamillepro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Objets proposés, relevés sur la maquette. La clé sert au traitement, la valeur à l'affichage. */
function tfp_contact_subjects() {
	return array(
		'prestation' => 'Question sur une prestation',
		'tarifs'     => 'Question sur les tarifs',
		'zone'       => 'Question sur une zone d’intervention',
		'recrutement' => 'Recrutement',
		'autre'      => 'Autre',
	);
}

/**
 * Limitation de débit par adresse IP, identique dans son principe à celle du devis mais sur son
 * propre compteur : saturer l'un ne doit pas fermer l'autre.
 */
function tfp_contact_rate_limit_ok( $ip ) {
	$cle    = 'tfp_contact_rl_' . md5( (string) $ip );
	$compte = (int) get_transient( $cle );
	/*
	 * Cinq envois par heure et par adresse en production. Sur un poste de développement, la suite
	 * automatisée soumet le formulaire plusieurs fois depuis 127.0.0.1 : le plafond y est relevé,
	 * sans quoi la deuxième exécution d'affilée testerait la limitation au lieu de la validation.
	 * Le comportement public n'est pas touché — `wp_get_environment_type()` vaut `production`
	 * partout ailleurs.
	 */
	$plafond = in_array( wp_get_environment_type(), array( 'local', 'development' ), true ) ? 50 : 5;
	if ( $compte >= $plafond ) {
		return false;
	}
	set_transient( $cle, $compte + 1, HOUR_IN_SECONDS );
	return true;
}

/**
 * L'envoi d'e-mail est-il neutralisé sur cette installation ?
 *
 * Vrai en local et en développement. Sert de garde-fou explicite : la suite automatisée le vérifie
 * **avant** de soumettre quoi que ce soit, et refuse de soumettre si l'installation testée est une
 * installation de production. Aucun test ne doit faire partir un e-mail réel.
 */
function tfp_contact_mail_disabled() {
	return in_array( wp_get_environment_type(), array( 'local', 'development' ), true );
}

/**
 * Traitement de la soumission.
 *
 * Validation **serveur** complète : la validation client est un confort, elle ne protège de rien.
 * En cas d'erreur, les valeurs saisies sont conservées et renvoyées à la page — perdre un message
 * rédigé parce qu'une adresse est mal formée fait perdre le contact.
 */
function tfp_handle_contact_submission() {
	$retour = wp_get_referer() ?: home_url( '/contact/' );

	// --- Nonce : la requête doit venir de notre formulaire.
	if ( ! isset( $_POST['tfp_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['tfp_contact_nonce'] ), 'tfp_contact_submit' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'erreur-securite', $retour ) );
		exit;
	}

	/*
	 * Honeypot : un champ qu'aucune personne ne remplit, parce qu'il n'est ni visible ni
	 * atteignable au clavier. S'il est rempli, c'est un automate — on répond comme si tout s'était
	 * bien passé, pour ne pas lui apprendre qu'il a été repéré.
	 */
	if ( ! empty( $_POST['tfp_contact_site'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'envoye', $retour ) );
		exit;
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( ! tfp_contact_rate_limit_ok( $ip ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'trop-de-demandes', $retour ) );
		exit;
	}

	$champs = array(
		'nom'         => sanitize_text_field( wp_unslash( $_POST['tfp_contact_nom'] ?? '' ) ),
		'entreprise'  => sanitize_text_field( wp_unslash( $_POST['tfp_contact_entreprise'] ?? '' ) ),
		'email'       => sanitize_email( wp_unslash( $_POST['tfp_contact_email'] ?? '' ) ),
		'telephone'   => sanitize_text_field( wp_unslash( $_POST['tfp_contact_telephone'] ?? '' ) ),
		'objet'       => sanitize_key( wp_unslash( $_POST['tfp_contact_objet'] ?? '' ) ),
		'message'     => sanitize_textarea_field( wp_unslash( $_POST['tfp_contact_message'] ?? '' ) ),
		'consentement' => ! empty( $_POST['tfp_contact_consentement'] ),
	);

	$erreurs = array();
	if ( '' === $champs['nom'] ) {
		$erreurs['nom'] = 'Merci d’indiquer votre nom.';
	}
	if ( ! is_email( $champs['email'] ) ) {
		$erreurs['email'] = 'Merci d’indiquer une adresse e-mail valide, pour que nous puissions vous répondre.';
	}
	if ( mb_strlen( $champs['message'] ) < 10 ) {
		$erreurs['message'] = 'Merci de préciser votre question en quelques mots.';
	}
	if ( ! array_key_exists( $champs['objet'], tfp_contact_subjects() ) ) {
		$erreurs['objet'] = 'Merci de choisir un objet.';
	}
	// Le consentement conditionne le traitement : sans lui, il n'y a pas de base légale.
	if ( ! $champs['consentement'] ) {
		$erreurs['consentement'] = 'Merci d’accepter que vos informations soient utilisées pour vous répondre.';
	}

	if ( $erreurs ) {
		/*
		 * La saisie conservée est rattachée à un **jeton propre à cet envoi**, pas à l'adresse IP.
		 *
		 * Rattachée à l'IP, elle se mélangeait dès que deux envois se croisaient depuis la même
		 * adresse — deux collègues derrière la même sortie internet, ou simplement deux onglets. Le
		 * second envoi écrasait la saisie du premier, qui retrouvait au retour les valeurs de
		 * quelqu'un d'autre. Le jeton fait le tour par l'URL de retour : chaque tentative retrouve
		 * exactement la sienne.
		 */
		$jeton = sanitize_key( wp_unslash( $_POST['tfp_contact_ticket'] ?? '' ) ) ?: wp_generate_password( 12, false, false );
		set_transient( 'tfp_contact_err_' . $jeton, array( 'erreurs' => $erreurs, 'valeurs' => $champs ), 5 * MINUTE_IN_SECONDS );
		wp_safe_redirect( add_query_arg( array( 'contact' => 'erreur', 'tfpt' => $jeton ), $retour ) . '#formulaire-contact' );
		exit;
	}

	$site   = tfp_site_data();
	$objets = tfp_contact_subjects();
	$corps  = sprintf(
		"Nouveau message depuis le formulaire de contact.\n\nNom : %s\nEntreprise : %s\nE-mail : %s\nTéléphone : %s\nObjet : %s\n\nMessage :\n%s\n",
		$champs['nom'],
		$champs['entreprise'] ?: '—',
		$champs['email'],
		$champs['telephone'] ?: '—',
		$objets[ $champs['objet'] ],
		$champs['message']
	);

	/*
	 * Aucun envoi pendant les tests : `WP_ENVIRONMENT_TYPE` vaut alors `local` ou `development`.
	 * La suite automatisée soumet le formulaire pour vérifier la validation et la confirmation ;
	 * elle ne doit pas remplir la boîte d'Audrey.
	 */
	if ( ! tfp_contact_mail_disabled() ) {
		wp_mail(
			$site['email'],
			'[Contact] ' . $objets[ $champs['objet'] ] . ' — ' . $champs['nom'],
			$corps,
			array( 'Reply-To: ' . $champs['email'] )
		);
	}

	wp_safe_redirect( add_query_arg( 'contact', 'envoye', $retour ) . '#formulaire-contact' );
	exit;
}
add_action( 'admin_post_nopriv_tfp_submit_contact', 'tfp_handle_contact_submission' );
add_action( 'admin_post_tfp_submit_contact', 'tfp_handle_contact_submission' );

/**
 * Erreurs et valeurs conservées de la tentative précédente, s'il y en a une.
 *
 * @return array{erreurs: array<string,string>, valeurs: array<string,mixed>}
 */
function tfp_contact_previous_attempt() {
	$jeton = isset( $_GET['tfpt'] ) ? sanitize_key( wp_unslash( $_GET['tfpt'] ) ) : '';
	if ( '' === $jeton ) {
		return array( 'erreurs' => array(), 'valeurs' => array() );
	}
	$cle = 'tfp_contact_err_' . $jeton;
	$don = get_transient( $cle );
	if ( ! is_array( $don ) ) {
		return array( 'erreurs' => array(), 'valeurs' => array() );
	}
	delete_transient( $cle );
	return wp_parse_args( $don, array( 'erreurs' => array(), 'valeurs' => array() ) );
}
