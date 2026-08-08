<?php
/**
 * Traitement serveur du formulaire de demande de devis (/demande-de-devis/, CLAUDE.md §8).
 *
 * Volontairement sans dépendance ACF ni plugin de formulaire : `admin-post.php`, le mécanisme
 * natif de WordPress pour traiter un POST public sans REST API ni JavaScript côté serveur.
 * Fonctionne sans configuration SMTP dédiée (wp_mail() utilise le transport mail() de PHP par
 * défaut) — un vrai envoi, pas une simulation, même si l'adresse d'expédition/relais définitive
 * (PROJECT_INPUTS.md, question ouverte #4) reste à confirmer côté hébergement en phase 4.
 *
 * Validation client (src/js/quote-form.js) ET serveur (ici) — CLAUDE.md §8 : le client peut être
 * contourné, seule la validation serveur est une garantie.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Limite de soumissions : 5 par heure et par IP, via un transitoire (pas de table dédiée).
 *
 * @param string $ip
 * @return bool true si la soumission est autorisée.
 */
function tfp_quote_rate_limit_ok( $ip ) {
	$key   = 'tfp_devis_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		return false;
	}
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	return true;
}

function tfp_handle_quote_submission() {
	$redirect_base = home_url( '/demande-de-devis/' );

	if ( ! isset( $_POST['tfp_quote_nonce'] ) || ! wp_verify_nonce( $_POST['tfp_quote_nonce'], 'tfp_quote_submit' ) ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'session', $redirect_base ) );
		exit;
	}

	// Honeypot : champ caché aux visiteurs humains, souvent rempli par les robots. Rejet
	// silencieux (pas d'indice donné au robot que le champ a été détecté).
	if ( ! empty( $_POST['tfp_site_web'] ) ) {
		wp_safe_redirect( $redirect_base );
		exit;
	}

	$nom        = isset( $_POST['nom'] ) ? sanitize_text_field( wp_unslash( $_POST['nom'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telephone  = isset( $_POST['telephone'] ) ? sanitize_text_field( wp_unslash( $_POST['telephone'] ) ) : '';
	$entreprise = isset( $_POST['entreprise'] ) ? sanitize_text_field( wp_unslash( $_POST['entreprise'] ) ) : '';
	$message    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$consentement = ! empty( $_POST['consentement'] );

	$type_locaux = isset( $_POST['type_locaux'] ) ? sanitize_text_field( wp_unslash( $_POST['type_locaux'] ) ) : '';
	$regime      = isset( $_POST['regime'] ) ? sanitize_text_field( wp_unslash( $_POST['regime'] ) ) : '';
	$code_postal = isset( $_POST['code_postal'] ) ? sanitize_text_field( wp_unslash( $_POST['code_postal'] ) ) : '';
	$surface     = isset( $_POST['surface'] ) ? sanitize_text_field( wp_unslash( $_POST['surface'] ) ) : '';
	$frequence   = isset( $_POST['frequence'] ) ? sanitize_text_field( wp_unslash( $_POST['frequence'] ) ) : '';
	$creneau     = isset( $_POST['creneau'] ) ? sanitize_text_field( wp_unslash( $_POST['creneau'] ) ) : '';

	$prestation  = isset( $_POST['prestation'] ) ? sanitize_text_field( wp_unslash( $_POST['prestation'] ) ) : '';
	$ville       = isset( $_POST['ville'] ) ? sanitize_text_field( wp_unslash( $_POST['ville'] ) ) : '';
	$departement = isset( $_POST['departement'] ) ? sanitize_text_field( wp_unslash( $_POST['departement'] ) ) : '';
	$page_origine = isset( $_POST['page_origine'] ) ? esc_url_raw( wp_unslash( $_POST['page_origine'] ) ) : '';
	$referent    = isset( $_POST['referent'] ) ? sanitize_text_field( wp_unslash( $_POST['referent'] ) ) : '';
	$utm_source   = isset( $_POST['utm_source'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_source'] ) ) : '';
	$utm_medium   = isset( $_POST['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_medium'] ) ) : '';
	$utm_campaign = isset( $_POST['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ) ) : '';

	// Un moyen de recontacter est requis (téléphone OU e-mail, pas nécessairement les deux), mais si
	// un e-mail est fourni il doit être valide. Validation des champs avant la limitation de
	// fréquence : une requête mal formée ne doit pas pouvoir consommer le quota d'un visiteur
	// légitime partageant la même adresse IP.
	$email_fourni_invalide = ( '' !== $email ) && ! is_email( $email );
	$aucun_contact         = empty( $telephone ) && empty( $email );
	if ( empty( $nom ) || $aucun_contact || $email_fourni_invalide || empty( $message ) || ! $consentement ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'champs', $redirect_base ) );
		exit;
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( ! tfp_quote_rate_limit_ok( $ip ) ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'limite', $redirect_base ) );
		exit;
	}

	$site = tfp_site_data();

	$type_locaux_labels = array( 'bureaux' => 'Bureaux', 'commerces' => 'Commerces', 'cabinets' => 'Cabinets & professions libérales', 'coproprietes' => 'Copropriété / parties communes', 'meubles' => 'Location meublée / hébergement', 'ponctuel' => 'Remise en état ponctuelle', 'autre' => 'Autre' );
	$regime_labels      = array( 'regulier' => 'Régulier', 'ponctuel' => 'Ponctuel' );
	$frequence_labels   = array( 'quotidien' => 'Quotidien', 'plusieurs-semaine' => 'Plusieurs fois par semaine', 'hebdomadaire' => 'Hebdomadaire', 'bimensuel' => 'Toutes les deux semaines', 'mensuel' => 'Mensuel', 'ponctuel' => 'Une seule fois' );
	$creneau_labels     = array( 'matin' => "Tôt le matin, avant l'arrivée des équipes", 'soir' => 'En soirée, après le départ des équipes', 'journee' => 'En journée', 'weekend' => 'Le week-end' );

	$lines   = array();
	$lines[] = 'Nom : ' . $nom;
	if ( $email ) { $lines[] = 'E-mail : ' . $email; }
	if ( $telephone ) { $lines[] = 'Téléphone : ' . $telephone; }
	if ( $entreprise ) { $lines[] = 'Entreprise : ' . $entreprise; }
	if ( $type_locaux ) { $lines[] = 'Type de locaux : ' . ( isset( $type_locaux_labels[ $type_locaux ] ) ? $type_locaux_labels[ $type_locaux ] : $type_locaux ); }
	if ( $regime ) { $lines[] = 'Régime : ' . ( isset( $regime_labels[ $regime ] ) ? $regime_labels[ $regime ] : $regime ); }
	if ( $ville ) { $lines[] = 'Ville : ' . $ville; }
	if ( $code_postal ) { $lines[] = 'Code postal : ' . $code_postal; }
	if ( $surface ) { $lines[] = 'Surface approximative : ' . $surface; }
	if ( $departement ) { $lines[] = 'Département : ' . $departement; }
	if ( $prestation ) { $lines[] = 'Prestation concernée : ' . $prestation; }
	if ( $frequence ) { $lines[] = 'Fréquence souhaitée : ' . ( isset( $frequence_labels[ $frequence ] ) ? $frequence_labels[ $frequence ] : $frequence ); }
	if ( $creneau ) { $lines[] = 'Créneau souhaité : ' . ( isset( $creneau_labels[ $creneau ] ) ? $creneau_labels[ $creneau ] : $creneau ); }
	$lines[] = '';
	$lines[] = 'Message :';
	$lines[] = $message;
	$lines[] = '';
	$lines[] = '--- Contexte de la demande ---';
	if ( $page_origine ) { $lines[] = 'Page d\'origine : ' . $page_origine; }
	if ( $referent ) { $lines[] = 'Référent : ' . $referent; }
	if ( $utm_source || $utm_medium || $utm_campaign ) {
		$lines[] = sprintf( 'UTM : source=%s medium=%s campaign=%s', $utm_source, $utm_medium, $utm_campaign );
	}
	$lines[] = 'IP : ' . $ip;

	$body    = implode( "\n", $lines );
	$subject = sprintf( '[Demande de devis] %s', $nom );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $nom . ' <' . $email . '>';
	}

	$sent = wp_mail( $site['email'], $subject, $body, $headers );

	if ( ! $sent ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'envoi', $redirect_base ) );
		exit;
	}

	wp_safe_redirect( add_query_arg( 'merci', '1', $redirect_base ) );
	exit;
}
add_action( 'admin_post_nopriv_tfp_submit_devis', 'tfp_handle_quote_submission' );
add_action( 'admin_post_tfp_submit_devis', 'tfp_handle_quote_submission' );
