<?php
/**
 * Durcissement standard, scopé à ce que le thème peut légitimement faire.
 *
 * Les réglages qui relèvent de wp-config.php ou de l'hébergement (DISALLOW_FILE_EDIT,
 * limitation des tentatives de connexion, pare-feu applicatif) ne sont pas ici : ce dépôt ne
 * versionne que le thème enfant (CLAUDE.md §3), pas le cœur WordPress. Voir STATUS.md pour la
 * liste des réglages à appliquer côté hébergement/plugin en phase 1+.
 *
 * Règle transversale déjà appliquée dans tous les templates et includes de ce thème plutôt
 * que centralisée ici : toute sortie passe par esc_html()/esc_attr()/esc_url()/wp_kses_post(),
 * et toute entrée future (formulaire de devis, phase 4) devra passer par sanitize_*() côté
 * serveur en plus de la validation client, avec un nonce WordPress dédié.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Masque la version de WordPress (méta générateur, flux RSS) — réduit la surface de ciblage automatisé. */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/** Retire l'en-tête et le lien de pingback : le site n'utilise pas XML-RPC. */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter(
	'wp_headers',
	function ( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
);

/** N'expose pas l'énumération des identifiants utilisateur via ?author=N. */
add_action(
	'template_redirect',
	function () {
		if ( is_author() && ! is_admin() && isset( $_GET['author'] ) && ! is_user_logged_in() ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}
);
