<?php
/**
 * Plugin Name: Top-Famille Pro — Installation du contenu
 * Description: Installe et met à jour le contenu réel du thème Top-Famille Pro (53 pages : 18 pages statiques, 6 prestations, 26 zones, 3 articles) depuis l'administration WordPress, sans terminal. Plugin temporaire : à désactiver et supprimer une fois l'installation terminée.
 * Version: 1.11.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: Top-Famille Pro
 * Text Domain: tfp-installer
 *
 * Sécurité : page d'administration réservée à manage_options, protégée par nonce, aucune action
 * publique, aucune sortie non échappée, aucune donnée sensible journalisée. Idempotent : les
 * scripts de contenu qu'il exécute (seed/*.php) upsertent par slug, une deuxième exécution ne
 * crée aucun doublon.
 *
 * 1.1.0 (correctif fidélité production) : ajoute un scan en lecture seule du contenu page/post
 * qui n'appartient à aucune des 53 routes attendues (ex. contenu resté d'un thème précédent) —
 * affiché à l'administrateur, jamais supprimé automatiquement.
 * 1.2.0 : tarif unique 27,00 € HT/h dans les contenus seedés (remplace l'ancienne grille à trois
 * montants), maillage des 26 zones vers les 6 prestations corrigé (bin/seed-phase4-maillage.php).
 * 1.5.0 (fidélité Claude Design intégrale, 10 août 2026) : ajoute les quatre scripts de contenu
 * relevé dans la maquette — 6 prestations, 26 zones, 3 articles et leur index, 9 pages statiques
 * narratives. Ces scripts sont générés par tools/generate-*.mjs depuis le prototype rendu, jamais
 * rédigés à la main : les rejouer redonne exactement le même contenu.
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
