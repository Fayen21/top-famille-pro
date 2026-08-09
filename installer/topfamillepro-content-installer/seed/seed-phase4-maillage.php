<?php
/**
 * Phase 4 — maillage interne : renseigne deux relations laissées vides en phases 2/3.
 *
 * 1. `villes_prioritaires` sur les 6 prestations : jamais renseigné jusqu'ici (le champ existe et
 *    le gabarit le rendait déjà en chips « Disponible dans ces villes », mais aucune valeur n'y
 *    était écrite). Les 10 villes réelles et validées (PROJECT_INPUTS.md §6) sont utilisées telles
 *    quelles — pas de « priorité » inventée entre elles, aucune source ne permet de hiérarchiser.
 * 2. `_tfp_related_prestation` sur les 3 articles (includes/articles-meta.php) : relie chaque
 *    article aux prestations concernées. « frequence-bureaux » et « cout-nettoyage-bureaux » sont
 *    spécifiquement sur les bureaux ; « cahier-des-charges-nettoyage » est générique et lié aux 6
 *    prestations.
 *
 * Usage : wp eval-file bin/seed-phase4-maillage.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase4-maillage.php\n" );
}

function tfp_seed4_set_field( $selector, $value, $post_id ) {
	if ( function_exists( 'update_field' ) ) {
		update_field( $selector, $value, $post_id );
	} else {
		update_post_meta( $post_id, $selector, $value );
	}
}

echo "=== Seed phase 4 : maillage interne ===\n";

/* ------------------------------------------------------------------ */
/* 1. villes_prioritaires sur les 6 prestations                        */
/* ------------------------------------------------------------------ */

$villes = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'ville', 'orderby' => 'title', 'order' => 'ASC' ) );
$ville_ids = wp_list_pluck( $villes, 'ID' );

if ( empty( $ville_ids ) ) {
	echo "  ATTENTION : aucune zone de niveau ville trouvée — le script phase 3 a-t-il été exécuté ?\n";
} else {
	$prestations = get_posts( array( 'post_type' => 'prestation', 'numberposts' => -1 ) );
	foreach ( $prestations as $prestation ) {
		tfp_seed4_set_field( 'villes_prioritaires', $ville_ids, $prestation->ID );
		echo "  villes_prioritaires -> " . get_the_title( $prestation ) . " (" . count( $ville_ids ) . " villes)\n";
	}
}

/* ------------------------------------------------------------------ */
/* 2. _tfp_related_prestation sur les 3 articles                       */
/* ------------------------------------------------------------------ */

$bureaux = get_page_by_path( 'bureaux', OBJECT, 'prestation' );
$all_prestations = get_posts( array( 'post_type' => 'prestation', 'numberposts' => -1 ) );
$all_prestation_ids = wp_list_pluck( $all_prestations, 'ID' );

function tfp_seed4_link_article_prestations( $article_slug, array $prestation_ids ) {
	$article = get_page_by_path( $article_slug, OBJECT, 'post' );
	if ( ! $article ) {
		echo "  ATTENTION : article '$article_slug' introuvable.\n";
		return;
	}
	delete_post_meta( $article->ID, '_tfp_related_prestation' );
	foreach ( $prestation_ids as $id ) {
		add_post_meta( $article->ID, '_tfp_related_prestation', (int) $id );
	}
	echo "  _tfp_related_prestation -> $article_slug (" . count( $prestation_ids ) . " prestation(s))\n";
}

if ( $bureaux ) {
	tfp_seed4_link_article_prestations( 'frequence-bureaux', array( $bureaux->ID ) );
	tfp_seed4_link_article_prestations( 'cout-nettoyage-bureaux', array( $bureaux->ID ) );
}
tfp_seed4_link_article_prestations( 'cahier-des-charges-nettoyage', $all_prestation_ids );

echo "=== Terminé ===\n";
