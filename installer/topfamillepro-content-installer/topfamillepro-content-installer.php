<?php
/**
 * Plugin Name: Top-Famille Pro — Installation du contenu
 * Description: Installe et met à jour le contenu réel du thème Top-Famille Pro (53 pages : 18 pages statiques, 6 prestations, 26 zones, 3 articles) depuis l'administration WordPress, sans terminal. Plugin temporaire : à désactiver et supprimer une fois l'installation terminée.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: Top-Famille Pro
 * Text Domain: tfp-installer
 *
 * Sécurité : page d'administration réservée à manage_options, protégée par nonce, aucune action
 * publique, aucune sortie non échappée, aucune donnée sensible journalisée. Idempotent : les
 * scripts de contenu qu'il exécute (seed/*.php) upsertent par slug, une deuxième exécution ne
 * crée aucun doublon.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TFP_INSTALLER_DIR', plugin_dir_path( __FILE__ ) );

require_once TFP_INSTALLER_DIR . 'includes/route-manifest.php';
require_once TFP_INSTALLER_DIR . 'includes/installer.php';
require_once TFP_INSTALLER_DIR . 'includes/admin-page.php';

add_action(
	'admin_menu',
	function () {
		add_management_page(
			'Installation Top-Famille Pro',
			'Installation Top-Famille Pro',
			'manage_options',
			'tfp-installer',
			'tfp_installer_render_admin_page'
		);
	}
);
