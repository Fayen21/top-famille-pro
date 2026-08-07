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

	$nom       = isset( $_POST['nom'] ) ? sanitize_text_field( wp_unslash( $_POST['nom'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telephone = isset( $_POST['telephone'] ) ? sanitize_text_field( wp_unslash( $_POST['telephone'] ) ) : '';
	$structure = isset( $_POST['structure'] ) ? sanitize_text_field( wp_unslash( $_POST['structure'] ) ) : '';
	$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	$prestation  = isset( $_POST['prestation'] ) ? sanitize_text_field( wp_unslash( $_POST['prestation'] ) ) : '';
	$ville       = isset( $_POST['ville'] ) ? sanitize_text_field( wp_unslash( $_POST['ville'] ) ) : '';
	$departement = isset( $_POST['departement'] ) ? sanitize_text_field( wp_unslash( $_POST['departement'] ) ) : '';
	$page_origine = isset( $_POST['page_origine'] ) ? esc_url_raw( wp_unslash( $_POST['page_origine'] ) ) : '';
	$referent    = isset( $_POST['referent'] ) ? sanitize_text_field( wp_unslash( $_POST['referent'] ) ) : '';
	$utm_source   = isset( $_POST['utm_source'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_source'] ) ) : '';
	$utm_medium   = isset( $_POST['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_medium'] ) ) : '';
	$utm_campaign = isset( $_POST['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ) ) : '';

	// Validation des champs avant la limitation de fréquence : une requête mal formée ne doit pas
	// pouvoir consommer le quota d'un visiteur légitime partageant la même adresse IP.
	if ( empty( $nom ) || ! is_email( $email ) || empty( $message ) ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'champs', $redirect_base ) );
		exit;
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( ! tfp_quote_rate_limit_ok( $ip ) ) {
		wp_safe_redirect( add_query_arg( 'erreur', 'limite', $redirect_base ) );
		exit;
	}

	$site = tfp_site_data();

	$lines   = array();
	$lines[] = 'Nom : ' . $nom;
	$lines[] = 'E-mail : ' . $email;
	if ( $telephone ) { $lines[] = 'Téléphone : ' . $telephone; }
	if ( $structure ) { $lines[] = 'Structure : ' . $structure; }
	if ( $prestation ) { $lines[] = 'Prestation concernée : ' . $prestation; }
	if ( $ville ) { $lines[] = 'Ville : ' . $ville; }
	if ( $departement ) { $lines[] = 'Département : ' . $departement; }
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
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $nom . ' <' . $email . '>' );

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
