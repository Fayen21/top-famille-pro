<?php
/**
 * Phase 4 — maillage interne : renseigne des relations laissées incomplètes en phases 2/3.
 *
 * 1. `villes_prioritaires` sur les 6 prestations : jamais renseigné jusqu'ici (le champ existe et
 *    le gabarit le rendait déjà en chips « Disponible dans ces villes », mais aucune valeur n'y
 *    était écrite). Les 10 villes réelles et validées (PROJECT_INPUTS.md §6) sont utilisées telles
 *    quelles — pas de « priorité » inventée entre elles, aucune source ne permet de hiérarchiser.
 * 2. `_tfp_related_prestation` sur les 3 articles (includes/articles-meta.php) : relie chaque
 *    article aux prestations concernées. « frequence-bureaux » et « cout-nettoyage-bureaux » sont
 *    spécifiquement sur les bureaux ; « cahier-des-charges-nettoyage » est générique et lié aux 6
 *    prestations.
 * 3. `prestations_liees` sur les 26 zones (8 départements + 10 villes + 8 communes) : les scripts
 *    de phase 2/3 ne pouvaient lier chaque zone qu'à « bureaux » (seule prestation existant au
 *    moment où phase 2 s'exécute dans l'ordre d'installation) — bug réel trouvé lors du hotfix de
 *    fidélité Claude Design du 9 août 2026 (les pages de zone ne maillaient qu'une seule
 *    prestation sur six). Ce script s'exécute en dernier, quand les 6 prestations existent déjà :
 *    il réécrit `prestations_liees` sur les 26 zones avec les 6 prestations, dans l'ordre.
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

/*
 * La maquette pose les MÊMES trois renvois sous les trois articles : « Nettoyage de bureaux »,
 * « Nos tarifs » et « Nettoyage à Dijon ». « Cahier des charges » recevait ici les six prestations,
 * soit sept pastilles au lieu de trois : à 375 px, sept lignes de pastilles contre deux, et
 * 212 px de trop sur la bande — le dernier écart de cette route.
 *
 * Ce n'est pas un appauvrissement du maillage : les six prestations restent atteignables depuis
 * l'index des prestations, lui-même lié dans le corps de l'article, et sept renvois indifférenciés
 * en bas de page ne guident personne.
 */
if ( $bureaux ) {
	tfp_seed4_link_article_prestations( 'frequence-bureaux', array( $bureaux->ID ) );
	tfp_seed4_link_article_prestations( 'cout-nettoyage-bureaux', array( $bureaux->ID ) );
	tfp_seed4_link_article_prestations( 'cahier-des-charges-nettoyage', array( $bureaux->ID ) );
}
unset( $all_prestation_ids );

/*
 * Troisième pastille de la maquette : le renvoi vers une ville. Il est stocké en méta plutôt
 * qu'écrit dans le gabarit — une ville nommée en dur dans un fichier PHP ne se corrige pas depuis
 * l'administration, et le jour où la ville de référence change, elle se corrige ici.
 */
$dijon = get_page_by_path( 'dijon', OBJECT, 'zone' );
if ( $dijon ) {
	foreach ( array( 'frequence-bureaux', 'cout-nettoyage-bureaux', 'cahier-des-charges-nettoyage' ) as $slug ) {
		$article = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $article ) {
			update_post_meta( $article->ID, '_tfp_related_ville', (int) $dijon->ID );
			echo "  _tfp_related_ville -> $slug (" . get_the_title( $dijon ) . ")\n";
		}
	}
} else {
	echo "  ATTENTION : zone 'dijon' introuvable — pastille de ville non posée.\n";
}

/* ------------------------------------------------------------------ */
/* 3. prestations_liees sur les 26 zones — corrige le lien unique à     */
/*    « bureaux » hérité de l'ordre d'exécution des scripts phase 2/3   */
/* ------------------------------------------------------------------ */

if ( empty( $all_prestation_ids ) ) {
	echo "  ATTENTION : aucune prestation trouvée — les scripts phase 2/3 ont-ils été exécutés ?\n";
} else {
	$zones = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1 ) );
	foreach ( $zones as $zone ) {
		tfp_seed4_set_field( 'prestations_liees', $all_prestation_ids, $zone->ID );
	}
	echo '  prestations_liees -> ' . count( $zones ) . ' zone(s) (' . count( $all_prestation_ids ) . " prestations chacune)\n";
}

/* ------------------------------------------------------------------ */
/* 4. communes_proches sur les 8 pages de la couronne dijonnaise —      */
/*    la rangée de communes RELEVÉE sur la maquette (G22)               */
/* ------------------------------------------------------------------ */

/*
 * La maquette compose la rangée « Communes proches » de chaque page de zone en mêlant, dans une
 * seule rangée, des LIENS vers les zones documentées voisines et des noms sans page (rendus en
 * pastilles inertes). Le lot 3-4 ne renseignait `communes_proches` que sur Dijon — avec les huit
 * communes, Beaune comprise — si bien que les sept pages de la couronne perdaient leurs liens
 * vers Dijon et leurs voisines, et que Dijon liait Beaune, que la maquette ne met pas dans sa
 * couronne (40 km). Relevé fait page par page sur le prototype à 1440 px (G22) :
 * chaque entrée liste les slugs des zones réellement liées par la maquette, dans son ordre.
 */
$couronne = array(
	'dijon'              => array( 'saint-apollinaire', 'chenove', 'quetigny', 'talant', 'longvic', 'fontaine-les-dijon', 'marsannay-la-cote' ),
	'saint-apollinaire'  => array( 'dijon', 'quetigny' ),
	'chenove'            => array( 'dijon', 'longvic', 'marsannay-la-cote' ),
	'quetigny'           => array( 'saint-apollinaire', 'dijon' ),
	'talant'             => array( 'dijon', 'fontaine-les-dijon' ),
	'longvic'            => array( 'dijon', 'chenove' ),
	'fontaine-les-dijon' => array( 'dijon', 'talant' ),
	'marsannay-la-cote'  => array( 'chenove', 'dijon' ),
);
foreach ( $couronne as $slug => $voisins ) {
	$zone = get_page_by_path( $slug, OBJECT, 'zone' );
	if ( ! $zone ) {
		echo "  ATTENTION : zone '$slug' introuvable — communes_proches non posé.\n";
		continue;
	}
	$ids = array();
	foreach ( $voisins as $v ) {
		$cible = get_page_by_path( $v, OBJECT, 'zone' );
		if ( $cible ) {
			$ids[] = $cible->ID;
		}
	}
	tfp_seed4_set_field( 'communes_proches', $ids, $zone->ID );
}
echo '  communes_proches -> ' . count( $couronne ) . " pages de la couronne dijonnaise (rangées relevées sur la maquette)\n";

echo "=== Terminé ===\n";
