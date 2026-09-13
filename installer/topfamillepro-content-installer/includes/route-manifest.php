<?php
/**
 * Manifeste des 53 pages publiques attendues — portage PHP de tests/data/routes.js (source de
 * vérité partagée avec la suite de tests du thème, docs/INVENTAIRE-ROUTES.md). Utilisé pour le
 * contrôle préalable (lecture seule) : compare ce qui existe déjà en base à ce que l'installateur
 * va créer ou mettre à jour, sans jamais rien écrire.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function tfp_installer_route_manifest() {
	$statique = array(
		array( 'slug' => 'nettoyage-professionnel', 'title' => 'Nettoyage professionnel', 'post_type' => 'page' ),
		array( 'slug' => 'prestations', 'title' => 'Nos prestations', 'post_type' => 'page' ),
		array( 'slug' => 'tarifs', 'title' => 'Tarifs', 'post_type' => 'page' ),
		array( 'slug' => 'zones-intervention', 'title' => "Zones d'intervention", 'post_type' => 'page' ),
		array( 'slug' => 'bourgogne-franche-comte', 'title' => 'Bourgogne-Franche-Comté', 'post_type' => 'page' ),
		array( 'slug' => 'pourquoi-nous', 'title' => 'Pourquoi nous', 'post_type' => 'page' ),
		array( 'slug' => 'notre-fonctionnement', 'title' => 'Notre fonctionnement', 'post_type' => 'page' ),
		array( 'slug' => 'avis-clients', 'title' => 'Avis clients', 'post_type' => 'page' ),
		array( 'slug' => 'a-propos', 'title' => 'À propos', 'post_type' => 'page' ),
		array( 'slug' => 'demande-de-devis', 'title' => 'Demande de devis', 'post_type' => 'page' ),
		array( 'slug' => 'contact', 'title' => 'Contact', 'post_type' => 'page' ),
		array( 'slug' => 'recrutement', 'title' => 'Recrutement', 'post_type' => 'page' ),
		array( 'slug' => 'conseils', 'title' => 'Conseils', 'post_type' => 'page' ),
		array( 'slug' => 'mentions-legales', 'title' => 'Mentions légales', 'post_type' => 'page' ),
		array( 'slug' => 'politique-de-confidentialite', 'title' => 'Politique de confidentialité', 'post_type' => 'page' ),
		array( 'slug' => 'gestion-des-cookies', 'title' => 'Gestion des cookies', 'post_type' => 'page' ),
		array( 'slug' => 'plan-du-site', 'title' => 'Plan du site', 'post_type' => 'page' ),
	);

	$prestations = array(
		array( 'slug' => 'bureaux', 'title' => 'Nettoyage de bureaux' ),
		array( 'slug' => 'commerces', 'title' => 'Nettoyage de commerces' ),
		array( 'slug' => 'cabinets', 'title' => 'Nettoyage de cabinets' ),
		array( 'slug' => 'coproprietes', 'title' => 'Entretien de copropriétés' ),
		array( 'slug' => 'meubles', 'title' => 'Nettoyage de locations meublées' ),
		array( 'slug' => 'ponctuel', 'title' => 'Nettoyage ponctuel' ),
	);

	$departements = array(
		array( 'slug' => 'cote-dor', 'title' => "Côte-d'Or" ),
		array( 'slug' => 'doubs', 'title' => 'Doubs' ),
		array( 'slug' => 'jura', 'title' => 'Jura' ),
		array( 'slug' => 'nievre', 'title' => 'Nièvre' ),
		array( 'slug' => 'haute-saone', 'title' => 'Haute-Saône' ),
		array( 'slug' => 'saone-et-loire', 'title' => 'Saône-et-Loire' ),
		array( 'slug' => 'yonne', 'title' => 'Yonne' ),
		array( 'slug' => 'territoire-de-belfort', 'title' => 'Territoire de Belfort' ),
	);

	$villes = array(
		array( 'slug' => 'dijon', 'title' => 'Dijon' ),
		array( 'slug' => 'besancon', 'title' => 'Besançon' ),
		array( 'slug' => 'dole', 'title' => 'Dole' ),
		array( 'slug' => 'lons-le-saunier', 'title' => 'Lons-le-Saunier' ),
		array( 'slug' => 'nevers', 'title' => 'Nevers' ),
		array( 'slug' => 'vesoul', 'title' => 'Vesoul' ),
		array( 'slug' => 'chalon-sur-saone', 'title' => 'Chalon-sur-Saône' ),
		array( 'slug' => 'macon', 'title' => 'Mâcon' ),
		array( 'slug' => 'auxerre', 'title' => 'Auxerre' ),
		array( 'slug' => 'belfort', 'title' => 'Belfort' ),
	);

	// noindex,follow tant que non validées une par une (CLAUDE.md §5.4) — état cible, pas un défaut.
	$communes = array(
		array( 'slug' => 'saint-apollinaire', 'title' => 'Saint-Apollinaire' ),
		array( 'slug' => 'chenove', 'title' => 'Chenôve' ),
		array( 'slug' => 'quetigny', 'title' => 'Quetigny' ),
		array( 'slug' => 'talant', 'title' => 'Talant' ),
		array( 'slug' => 'longvic', 'title' => 'Longvic' ),
		array( 'slug' => 'fontaine-les-dijon', 'title' => 'Fontaine-lès-Dijon' ),
		array( 'slug' => 'marsannay-la-cote', 'title' => 'Marsannay-la-Côte' ),
		array( 'slug' => 'beaune', 'title' => 'Beaune' ),
	);

	$articles = array(
		array( 'slug' => 'frequence-bureaux', 'title' => 'À quelle fréquence faire nettoyer ses bureaux ?' ),
		array( 'slug' => 'cout-nettoyage-bureaux', 'title' => 'Combien coûte le nettoyage de bureaux ?' ),
		array( 'slug' => 'cahier-des-charges-nettoyage', 'title' => 'Comment rédiger un cahier des charges de nettoyage ?' ),
	);

	foreach ( $prestations as &$p ) { $p['post_type'] = 'prestation'; }
	foreach ( $departements as &$d ) { $d['post_type'] = 'zone'; $d['niveau'] = 'departement'; }
	foreach ( $villes as &$v ) { $v['post_type'] = 'zone'; $v['niveau'] = 'ville'; }
	foreach ( $communes as &$c ) { $c['post_type'] = 'zone'; $c['niveau'] = 'commune'; }
	foreach ( $articles as &$a ) { $a['post_type'] = 'post'; }
	unset( $p, $d, $v, $c, $a );

	return array(
		'statique'     => $statique,
		'prestation'   => $prestations,
		'departement'  => $departements,
		'ville'        => $villes,
		'commune'      => $communes,
		'article'      => $articles,
	);
}

/**
 * Contrôle préalable : compare le manifeste ci-dessus à l'état réel de la base, sans rien écrire.
 * Retourne, par famille, le nombre attendu, présent, et manquant.
 *
 * @return array
 */
function tfp_installer_precheck() {
	$manifest = tfp_installer_route_manifest();
	$report   = array();

	foreach ( $manifest as $family => $items ) {
		$present = 0;
		$missing = array();
		foreach ( $items as $item ) {
			$existing = get_posts(
				array(
					'post_type'   => $item['post_type'],
					'name'        => $item['slug'],
					'numberposts' => 1,
					'post_status' => 'any',
				)
			);
			if ( ! empty( $existing ) ) {
				$present++;
			} else {
				$missing[] = $item['title'] . ' (' . $item['slug'] . ')';
			}
		}
		$report[ $family ] = array(
			'expected' => count( $items ),
			'present'  => $present,
			'missing'  => $missing,
		);
	}

	// Contenu par défaut WordPress encore présent ?
	$hello  = get_page_by_title( 'Hello world!', OBJECT, 'post' );
	$sample = get_page_by_title( 'Sample Page', OBJECT, 'page' );
	$report['defaults'] = array(
		'hello_world_present' => $hello && 'trash' !== $hello->post_status,
		'sample_page_present' => $sample && 'trash' !== $sample->post_status,
	);

	return $report;
}

/**
 * Contenu `page`/`post` publié qui n'appartient à aucune des 53 routes attendues — typiquement
 * les pages d'un ancien thème (ex. V1top-famille-pro) resté actif avant le correctif, ou tout
 * contenu créé manuellement en dehors de ce que gère l'installateur.
 *
 * Lecture seule : signale, ne supprime jamais rien automatiquement (CLAUDE.md §6 : aucune
 * suppression sans justification explicite — ici, aucune justification automatisable, c'est une
 * décision humaine par page).
 *
 * @return array Liste de { post_id, post_type, title, slug, edit_link, status }.
 */
function tfp_installer_scan_legacy_content() {
	$manifest       = tfp_installer_route_manifest();
	$expected_slugs = array( 'page' => array(), 'post' => array() );

	foreach ( $manifest['statique'] as $item ) {
		$expected_slugs['page'][] = $item['slug'];
	}
	foreach ( $manifest['article'] as $item ) {
		$expected_slugs['post'][] = $item['slug'];
	}

	$legacy = array();
	foreach ( array( 'page', 'post' ) as $post_type ) {
		$all = get_posts(
			array(
				'post_type'      => $post_type,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'numberposts'    => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $all as $post_id ) {
			$slug = get_post_field( 'post_name', $post_id );
			if ( in_array( $slug, $expected_slugs[ $post_type ], true ) ) {
				continue;
			}
			$legacy[] = array(
				'post_id'   => $post_id,
				'post_type' => $post_type,
				'title'     => get_the_title( $post_id ),
				'slug'      => $slug,
				'status'    => get_post_status( $post_id ),
				'edit_link' => get_edit_post_link( $post_id, 'raw' ),
			);
		}
	}

	return $legacy;
}
