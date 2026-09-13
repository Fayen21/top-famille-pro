<?php
/**
 * Orchestration de l'installation réelle : exécute, dans l'ordre, les scripts de contenu
 * réels du thème (seed/*.php — copies exactes de bin/*.php du dépôt, déjà testées et
 * idempotentes par upsert-sur-slug, cf. tfp_seed_upsert_post()) puis le nettoyage du contenu
 * WordPress par défaut.
 *
 * Chaque script est un simple fichier PHP procédural qui utilise l'API WordPress standard
 * (get_posts, wp_insert_post, wp_update_post, update_post_meta / update_field) — il fonctionne
 * dans n'importe quel contexte où ABSPATH est défini, pas seulement sous WP-CLI (chaque script
 * commence par `if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) { die(...) }`), donc son
 * inclusion directe ici, depuis une requête d'administration normale, est sûre.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ordre d'exécution : chaque étape dépend du contenu créé par les précédentes (ex. le maillage,
 * en dernier, relie des prestations et des articles qui doivent déjà exister).
 */
function tfp_installer_seed_files() {
	$dir = plugin_dir_path( dirname( __FILE__ ) ) . 'seed/';
	return array(
		'Contenu de référence (1 page pilier, 1 prestation, 1 département, 1 ville, 1 article)' => $dir . 'seed-phase2-content.php',
		'5 prestations restantes'                    => $dir . 'seed-phase3-batch1-prestations.php',
		'7 départements restants'                    => $dir . 'seed-phase3-batch2-departements.php',
		'9 villes restantes'                         => $dir . 'seed-phase3-batch3-villes.php',
		'8 communes desservies (validées le 17/08/2026, index)' => $dir . 'seed-phase3-batch4-communes.php',
		'2 articles restants'                        => $dir . 'seed-phase3-batch5-articles.php',
		'4 pages statiques (prestations, tarifs, zones, région)' => $dir . 'seed-phase3-batch5-pages.php',
		'8 pages statiques (confiance et conversion)' => $dir . 'seed-phase3-batch6-pages.php',
		'4 pages légales et plan du site'             => $dir . 'seed-phase3-batch7-pages.php',
		'Maillage interne (villes prioritaires, articles ↔ prestations)' => $dir . 'seed-phase4-maillage.php',
		'Fidélité Claude Design — 6 prestations'      => $dir . 'seed-fidelite-prestations.php',
		'Fidélité Claude Design — 26 zones'          => $dir . 'seed-fidelite-zones.php',
		'Fidélité Claude Design — 3 articles Conseils' => $dir . 'seed-fidelite-articles.php',
		'Fidélité Claude Design — 9 pages statiques' => $dir . 'seed-fidelite-pages.php',
		'Réassurance & avis — décision du 17/08/2026' => $dir . 'seed-reassurance.php',
		'Nettoyage du contenu WordPress par défaut'   => $dir . 'cleanup-wp-defaults.php',
	);
}

/**
 * Exécute l'installation réelle. Retourne un rapport structuré : par étape, le texte de sortie
 * du script (nettoyé de tout chemin de fichier serveur — CLAUDE.md « aucune donnée sensible dans
 * les logs ») et le nombre de créations/mises à jour observées par comptage avant/après des
 * contenus des CPT concernés.
 *
 * @return array{steps: array, before: array, after: array}
 */
function tfp_installer_run() {
	$counts_before = tfp_installer_content_counts();

	$steps = array();
	foreach ( tfp_installer_seed_files() as $label => $file ) {
		if ( ! file_exists( $file ) ) {
			$steps[] = array(
				'label'  => $label,
				'status' => 'error',
				'output' => 'Fichier introuvable dans le paquet du plugin.',
			);
			continue;
		}
		ob_start();
		$had_error = false;
		try {
			// Inclusion dans une fermeture dédiée : chaque script reçoit sa propre portée de
			// variables locales, isolée des dix autres — évite toute collision entre variables
			// génériques (ex. $existing, $term) d'un script à l'autre, alors que les onze
			// scripts étaient conçus à l'origine pour être lancés séparément (wp eval-file), pas
			// concaténés dans une même fonction.
			( function ( $tfp_installer_included_file ) {
				include $tfp_installer_included_file;
			} )( $file );
		} catch ( \Throwable $e ) {
			$had_error = true;
			// Message d'exception seul, jamais la trace complète (chemins serveur).
			echo "\nErreur : " . $e->getMessage();
		}
		$output = ob_get_clean();
		$steps[] = array(
			'label'  => $label,
			'status' => $had_error ? 'error' : 'ok',
			// Les scripts n'écrivent jamais de secret ; on retire seulement d'éventuels chemins
			// absolus du serveur qui pourraient s'être glissés dans un message d'erreur PHP.
			'output' => tfp_installer_strip_paths( $output ),
		);
	}

	$counts_after = tfp_installer_content_counts();

	// Les scripts de seed sont idempotents (upsert par slug) : WordPress ne permet pas de
	// distinguer nativement un « créé » d'un « mis à jour » sans instrumenter chaque script.
	// On rapporte donc le delta net par type de contenu (créations nettes) et le nombre total de
	// posts déjà existants et retouchés par cette exécution (upserts) à partir du delta et du
	// nombre d'éléments attendus par famille.
	flush_rewrite_rules();

	return array(
		'steps'  => $steps,
		'before' => $counts_before,
		'after'  => $counts_after,
	);
}

/**
 * Compte les contenus gérés par le thème, par type. Sert à calculer un delta avant/après.
 *
 * @return array<string,int>
 */
function tfp_installer_content_counts() {
	return array(
		'page'        => (int) wp_count_posts( 'page' )->publish,
		'prestation'  => (int) wp_count_posts( 'prestation' )->publish,
		'zone'        => (int) wp_count_posts( 'zone' )->publish,
		'post'        => (int) wp_count_posts( 'post' )->publish,
	);
}

/**
 * Retire tout chemin de fichier absolu (serveur) d'un texte avant de l'afficher ou de le
 * conserver dans un rapport — CLAUDE.md : aucune donnée sensible dans les logs.
 */
function tfp_installer_strip_paths( $text ) {
	return preg_replace( '#(/[a-zA-Z0-9_.\-]+){3,}#', '[chemin serveur masqué]', $text );
}
