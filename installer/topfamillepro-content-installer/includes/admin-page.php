<?php
/**
 * Page d'administration : Outils > Installation Top-Famille Pro.
 * Sécurité : capacité manage_options (déjà vérifiée par add_management_page + le hook), nonce sur
 * chaque action, échappement systématique en sortie, aucune exécution publique (fichier chargé
 * uniquement depuis l'admin, jamais accessible en front).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function tfp_installer_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Accès réservé aux administrateurs.', 'tfp-installer' ) );
	}

	$result = null;
	$action = '';

	if ( isset( $_POST['tfp_installer_action'] ) && check_admin_referer( 'tfp_installer_run', 'tfp_installer_nonce' ) ) {
		$action = sanitize_key( wp_unslash( $_POST['tfp_installer_action'] ) );
		if ( 'install' === $action && ! empty( $_POST['tfp_installer_confirm_backup'] ) ) {
			$result = tfp_installer_run();
		}
	}

	$precheck = tfp_installer_precheck();
	$legacy   = tfp_installer_scan_legacy_content();

	echo '<div class="wrap"><h1>Installation Top-Famille Pro</h1>';

	echo '<div class="notice notice-warning"><p><strong>Avant de continuer :</strong> faites une sauvegarde complète du site (fichiers et base de données) depuis hPanel Hostinger ou votre outil habituel. Cette installation crée et met à jour les pages, prestations, zones et articles réels de Top-Famille Pro — relancer l\'installation resynchronise le contenu qu\'elle gère (textes, tarifs affichés, FAQ) avec la version de référence du thème : toute modification faite manuellement dans l\'administration WordPress sur ces mêmes contenus sera alors écrasée. Le contenu que vous créez vous-même en dehors de ces 53 pages (articles de blog additionnels, autres pages) n\'est jamais touché.</p></div>';

	if ( ! empty( $legacy ) ) {
		echo '<h2>0. Contenu existant à examiner (jamais supprimé automatiquement)</h2>';
		echo '<p>' . esc_html( count( $legacy ) ) . ' page(s)/article(s) publié(s) sur ce site n\'appartiennent à aucune des 53 routes attendues — probablement du contenu d\'un thème ou d\'une installation précédente (ex. <code>V1top-famille-pro</code>). L\'installateur ne les modifie ni ne les supprime jamais : décidez au cas par cas (conserver, rediriger en 301 vers l\'équivalent réel, ou mettre à la corbeille manuellement).</p>';
		echo '<table class="widefat striped" style="max-width:900px"><thead><tr><th>Type</th><th>Titre</th><th>Slug</th><th>Statut</th><th>Modifier</th></tr></thead><tbody>';
		foreach ( $legacy as $item ) {
			echo '<tr>';
			echo '<td>' . esc_html( $item['post_type'] ) . '</td>';
			echo '<td>' . esc_html( $item['title'] ) . '</td>';
			echo '<td><code>' . esc_html( $item['slug'] ) . '</code></td>';
			echo '<td>' . esc_html( $item['status'] ) . '</td>';
			echo '<td>' . ( $item['edit_link'] ? '<a href="' . esc_url( $item['edit_link'] ) . '">Ouvrir</a>' : '—' ) . '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

	echo '<h2>1. Contrôle préalable</h2>';
	echo '<p>État actuel de la base de données, sans aucune modification. 52 contenus attendus ci-dessous, pour 53 pages publiques au total : la page d\'accueil (<code>/</code>) est affichée automatiquement par le thème (<code>front-page.php</code>) et ne correspond à aucune page WordPress à créer.</p>';
	tfp_installer_render_precheck_table( $precheck );

	if ( $precheck['defaults']['hello_world_present'] || $precheck['defaults']['sample_page_present'] ) {
		echo '<p>⚠️ Contenu WordPress par défaut encore présent (« Hello world! » et/ou « Sample Page ») — sera mis à la corbeille lors de l\'installation.</p>';
	}

	echo '<h2>2. Mode simulation</h2>';
	echo '<p>Le tableau ci-dessus <strong>est</strong> la simulation : il indique exactement ce qui sera créé (lignes « manquant ») avant toute action. Aucun bouton séparé n\'est nécessaire pour un mode simulation qui écrirait en base — actualisez cette page à tout moment pour revoir cet état sans rien modifier.</p>';

	echo '<h2>3. Installer ou mettre à jour le contenu</h2>';
	echo '<form method="post">';
	wp_nonce_field( 'tfp_installer_run', 'tfp_installer_nonce' );
	echo '<input type="hidden" name="tfp_installer_action" value="install">';
	echo '<label><input type="checkbox" name="tfp_installer_confirm_backup" value="1" required> J\'ai sauvegardé le site avant de continuer.</label><br><br>';
	submit_button( 'Installer ou mettre à jour le contenu', 'primary', 'submit', false );
	echo '</form>';

	if ( null !== $result ) {
		tfp_installer_render_result( $result );
	}

	echo '</div>';
}

function tfp_installer_render_precheck_table( $precheck ) {
	$labels = array(
		'statique'    => 'Pages statiques',
		'prestation'  => 'Prestations',
		'departement' => 'Zones — départements',
		'ville'       => 'Zones — villes',
		'commune'     => 'Zones — communes secondaires',
		'article'     => 'Articles',
	);

	echo '<table class="widefat striped" style="max-width:800px"><thead><tr><th>Famille</th><th>Attendu</th><th>Présent</th><th>Manquant</th></tr></thead><tbody>';
	$total_expected = 0;
	$total_present  = 0;
	foreach ( $labels as $key => $label ) {
		$row = $precheck[ $key ];
		$total_expected += $row['expected'];
		$total_present  += $row['present'];
		echo '<tr>';
		echo '<td>' . esc_html( $label ) . '</td>';
		echo '<td>' . esc_html( $row['expected'] ) . '</td>';
		echo '<td>' . esc_html( $row['present'] ) . '</td>';
		echo '<td>';
		if ( empty( $row['missing'] ) ) {
			echo '—';
		} else {
			echo esc_html( implode( ', ', $row['missing'] ) );
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr><td><strong>Total</strong></td><td><strong>' . esc_html( $total_expected ) . '</strong></td><td><strong>' . esc_html( $total_present ) . '</strong></td><td></td></tr>';
	echo '</tbody></table>';
}

function tfp_installer_render_result( $result ) {
	echo '<h2>Rapport d\'exécution</h2>';

	echo '<table class="widefat striped" style="max-width:900px"><thead><tr><th>Étape</th><th>Résultat</th></tr></thead><tbody>';
	$errors = 0;
	foreach ( $result['steps'] as $step ) {
		$icon = 'ok' === $step['status'] ? '✅' : '⛔';
		if ( 'error' === $step['status'] ) {
			$errors++;
		}
		echo '<tr><td>' . esc_html( $step['label'] ) . '</td><td>' . esc_html( $icon . ' ' . ( 'ok' === $step['status'] ? 'Terminé' : 'Erreur' ) ) . '</td></tr>';
		if ( ! empty( $step['output'] ) ) {
			echo '<tr><td colspan="2"><pre style="white-space:pre-wrap;background:#f6f7f7;padding:8px;font-size:12px">' . esc_html( $step['output'] ) . '</pre></td></tr>';
		}
	}
	echo '</tbody></table>';

	echo '<h3>Contenus publiés, avant / après</h3>';
	echo '<table class="widefat striped" style="max-width:600px"><thead><tr><th>Type</th><th>Avant</th><th>Après</th><th>Delta</th></tr></thead><tbody>';
	foreach ( $result['before'] as $type => $before ) {
		$after = $result['after'][ $type ];
		echo '<tr><td>' . esc_html( $type ) . '</td><td>' . esc_html( $before ) . '</td><td>' . esc_html( $after ) . '</td><td>' . esc_html( ( $after - $before >= 0 ? '+' : '' ) . ( $after - $before ) ) . '</td></tr>';
	}
	echo '</tbody></table>';

	if ( 0 === $errors ) {
		echo '<div class="notice notice-success" style="margin-top:16px"><p><strong>Installation terminée sans erreur.</strong> Vérifiez les 53 pages (menu Pages, Prestations, Zones, Articles), enregistrez les permaliens (Réglages → Permaliens → Enregistrer les modifications) si les URL des prestations/zones ne fonctionnent pas immédiatement, puis <strong>désactivez et supprimez ce plugin</strong> — son rôle est terminé, il ne doit pas rester actif en production.</p></div>';
	} else {
		echo '<div class="notice notice-error" style="margin-top:16px"><p><strong>' . esc_html( $errors ) . ' étape(s) en erreur.</strong> Consultez le détail ci-dessus avant de relancer. Ne supprimez pas le plugin tant que l\'installation n\'est pas complète.</p></div>';
	}
}
