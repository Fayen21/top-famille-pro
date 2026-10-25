<?php
/**
 * CPT `zone` — 26 entrées (8 départements + 10 villes + 8 communes secondaires), un seul type
 * de contenu pour les trois niveaux, distingués par le champ ACF `niveau`
 * (includes/acf-fields-zone.php) et une relation hiérarchique vers la taxonomie `departement`.
 * Décision d'architecture : CLAUDE.md §3 / STATUS.md §7 (phase 0).
 *
 * URL réelles (phase 2, docs/INVENTAIRE-ROUTES.md) :
 * - département : /zones-intervention/{departement}/
 * - ville ou commune : /zones-intervention/{departement}/{ville}/
 *
 * WordPress ne sait pas générer nativement cette imbrication à deux niveaux pour un seul CPT à
 * partir d'un simple `rewrite.slug` : les règles de réécriture et la génération du permalien
 * sont donc entièrement personnalisées ci-dessous (`tfp_zone_rewrite_rules`,
 * `tfp_zone_permalink`), avec un canonique 301 si l'URL demandée ne correspond pas au vrai
 * département de la zone (jamais deux URL valides pour la même page).
 *
 * Le hub (/zones-intervention/) et la page région (/zones-intervention/bourgogne-franche-comte/)
 * sont des Pages WordPress classiques, pas des entrées de ce CPT.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_register_cpt_zone() {
	register_post_type(
		'zone',
		array(
			'labels'          => array(
				'name'          => __( 'Zones', 'topfamillepro' ),
				'singular_name' => __( 'Zone', 'topfamillepro' ),
				'add_new_item'  => __( 'Ajouter une zone', 'topfamillepro' ),
				'edit_item'     => __( 'Modifier la zone', 'topfamillepro' ),
				'all_items'     => __( 'Toutes les zones', 'topfamillepro' ),
				'menu_name'     => __( 'Zones', 'topfamillepro' ),
			),
			'public'          => true,
			'has_archive'     => false, // Le hub /zones-intervention/ est une Page classique, pas l'archive du CPT.
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-location-alt',
			'menu_position'   => 22,
			'rewrite'         => false, // Réécriture entièrement personnalisée ci-dessous (imbrication à 2 niveaux).
			'query_var'       => 'zone',
			'supports'        => array( 'title', 'revisions' ),
			'hierarchical'    => false,
			'capability_type' => 'page',
			'map_meta_cap'    => true,
		)
	);

	register_taxonomy(
		'departement',
		'zone',
		array(
			'labels'            => array(
				'name'          => __( 'Départements', 'topfamillepro' ),
				'singular_name' => __( 'Département', 'topfamillepro' ),
			),
			'public'            => false, // Pas d'archive de taxonomie publique : la page département réelle est l'entrée `zone` de niveau "departement".
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'tfp_register_cpt_zone' );

/**
 * Règles de réécriture personnalisées : imbrication à 2 niveaux pour les zones.
 */
function tfp_zone_rewrite_rules() {
	add_rewrite_rule(
		'^zones-intervention/([^/]+)/([^/]+)/?$',
		'index.php?zone=$matches[2]',
		'top'
	);
	/*
	 * Exclusion explicite de « bourgogne-franche-comte » : c'est une Page WordPress classique
	 * (le hub régional, includes/cpt-zone.php ligne 18), pas une entrée de ce CPT. Sans cette
	 * exclusion, ce premier segment matche comme n'importe quel slug de département et la requête
	 * est réécrite en `zone=bourgogne-franche-comte`, qui ne correspond à aucun post → 404 au lieu
	 * de laisser WordPress router normalement vers la Page (bug trouvé en créant la page réelle,
	 * phase 3).
	 */
	add_rewrite_rule(
		'^zones-intervention/(?!bourgogne-franche-comte/?$)([^/]+)/?$',
		'index.php?zone=$matches[1]',
		'top'
	);
}
add_action( 'init', 'tfp_zone_rewrite_rules' );

/**
 * Génère le permalien réel d'une zone : /zones-intervention/{departement}/ pour un département,
 * /zones-intervention/{departement}/{postname}/ pour une ville ou une commune.
 */
function tfp_zone_permalink( $post_link, $post ) {
	if ( 'zone' !== $post->post_type ) {
		return $post_link;
	}

	$terms = get_the_terms( $post, 'departement' );
	$dept_slug = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->slug : $post->post_name;
	$niveau    = function_exists( 'get_field' ) ? get_field( 'niveau', $post->ID ) : get_post_meta( $post->ID, 'niveau', true );

	if ( 'departement' === $niveau ) {
		return home_url( '/zones-intervention/' . $dept_slug . '/' );
	}

	return home_url( '/zones-intervention/' . $dept_slug . '/' . $post->post_name . '/' );
}
add_filter( 'post_type_link', 'tfp_zone_permalink', 10, 2 );

/**
 * Canonicalise l'URL réellement demandée par rapport au vrai département de la zone affichée :
 * une zone n'a jamais deux URL valides. Si le premier segment ne correspond pas, redirection 301
 * vers l'URL canonique plutôt qu'un contenu dupliqué accessible sous plusieurs chemins.
 */
function tfp_zone_canonical_redirect() {
	if ( ! is_singular( 'zone' ) ) {
		return;
	}

	global $wp;
	$post      = get_queried_object();
	$canonical = tfp_zone_permalink( '', $post );
	$requested = home_url( add_query_arg( array(), $wp->request ) ) . '/';

	if ( untrailingslashit( $requested ) !== untrailingslashit( $canonical ) ) {
		wp_safe_redirect( $canonical, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'tfp_zone_canonical_redirect', 5 );

/**
 * Zone (tout niveau) par son slug — pour résoudre les cibles relevées sur la maquette.
 *
 * @param string $slug Slug WordPress de la zone.
 * @return WP_Post|null
 */
function tfp_get_zone_by_slug( $slug ) {
	static $cache = array();
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return null;
	}
	if ( ! array_key_exists( $slug, $cache ) ) {
		$posts          = get_posts( array( 'post_type' => 'zone', 'name' => $slug, 'numberposts' => 1 ) );
		$cache[ $slug ] = ! empty( $posts ) ? $posts[0] : null;
	}
	return $cache[ $slug ];
}

/**
 * Numéro du département d'une zone (« 21 »), ou chaîne vide.
 *
 * Le numéro vient de la table de `tfp_departements_nav()`, jamais d'un champ saisi : il est
 * apparié par le slug du terme `departement` de la zone.
 *
 * @param WP_Post|int $zone Zone ou identifiant.
 * @return string
 */
function tfp_zone_departement_num( $zone ) {
	$terms = get_the_terms( $zone, 'departement' );
	if ( empty( $terms ) || is_wp_error( $terms ) || ! function_exists( 'tfp_departements_nav' ) ) {
		return '';
	}
	foreach ( tfp_departements_nav() as $entree ) {
		if ( $entree['slug'] === $terms[0]->slug ) {
			return (string) $entree['num'];
		}
	}
	return '';
}

/**
 * Slug du terme `departement` d'une zone (« cote-dor »), ou chaîne vide.
 *
 * @param WP_Post|int $zone Zone ou identifiant.
 * @return string
 */
function tfp_zone_departement_slug( $zone ) {
	$terms = get_the_terms( $zone, 'departement' );
	return ( empty( $terms ) || is_wp_error( $terms ) ) ? '' : (string) $terms[0]->slug;
}

/**
 * Maillage géographique d'une page ville ou commune — calculé par RELATIONS, pas par libellés.
 *
 * Revue des captures du 21 octobre 2026 : sur Besançon, Nevers, Vesoul, Auxerre et Belfort, le
 * groupe « Dans le même département » listait les sept AUTRES départements (la maquette n'y liait
 * que la page du département ; le gabarit rendait pour ce type la liste régionale), et les
 * « Autres secteurs couverts en région » répétaient des villes du même département (Chalon ↔
 * Mâcon, Dole ↔ Lons-le-Saunier, Beaune → Dijon).
 *
 * Chaque groupe de liens reçoit un RÔLE déduit de ses cibles relevées :
 *  - `meme_departement` : le groupe lie la page du département courant (ou il a été relevé comme
 *    lien départemental). Il rend ce lien, puis les autres zones publiées du MÊME département ;
 *  - `proches` : toutes ses cibles sont du même département (communes proches) ;
 *  - `autres` : il vise d'autres départements ; les zones du département courant en sont retirées.
 * Les groupes sont traités dans l'ordre de la page : la page courante et toute destination déjà
 * liée par un groupe précédent sont exclues des suivants. Rien n'est ajouté pour remplir : un
 * département qui n'a qu'une page ville ne propose que son lien départemental.
 *
 * @param int   $post_id Zone courante (ville ou commune).
 * @param array $groupes Groupes de `tfp_get_zone_blocks( 'locaux', … )`.
 * @return array<int,array{role:string,departement:?WP_Post,zones:WP_Post[]}> Indexé par rang ACF.
 */
function tfp_zone_maillage( $post_id, array $groupes ) {
	$dept_slug = tfp_zone_departement_slug( $post_id );
	$dept_post = '' !== $dept_slug ? tfp_get_zone_by_department_slug( $dept_slug ) : null;
	$meme_dept = array();
	if ( '' !== $dept_slug ) {
		$meme_dept = get_posts(
			array(
				'post_type'   => 'zone',
				'numberposts' => -1,
				'orderby'     => 'menu_order title',
				'order'       => 'ASC',
				'tax_query'   => array( array( 'taxonomy' => 'departement', 'field' => 'slug', 'terms' => $dept_slug ) ),
				'meta_query'  => array( array( 'key' => 'niveau', 'value' => array( 'ville', 'commune' ), 'compare' => 'IN' ) ),
			)
		);
		// Les villes principales avant les communes, comme dans le reste du site.
		usort( $meme_dept, static fn( $a, $b ) => ( 'commune' === tfp_get_field( 'niveau', $a->ID ) ) <=> ( 'commune' === tfp_get_field( 'niveau', $b->ID ) ) );
	}

	$deja   = array( (int) $post_id => true );
	$sortie = array();
	foreach ( $groupes as $g ) {
		if ( ! in_array( $g['type'] ?? '', array( 'villes', 'departements' ), true ) || empty( $g['cibles'] ) ) {
			continue;
		}
		$resolues = array();
		$lie_dept = 'departements' === $g['type'];
		foreach ( (array) $g['cibles'] as $slug ) {
			$z = tfp_get_zone_by_slug( $slug );
			if ( ! $z ) {
				continue;
			}
			if ( 'departement' === tfp_get_field( 'niveau', $z->ID ) ) {
				$lie_dept = $lie_dept || ( $dept_post && (int) $z->ID === (int) $dept_post->ID );
				continue;
			}
			$resolues[] = $z;
		}
		$du_dept = static fn( $z ) => tfp_zone_departement_slug( $z ) === $dept_slug;

		if ( $lie_dept ) {
			$role  = 'meme_departement';
			$zones = array_merge( array_filter( $resolues, $du_dept ), $meme_dept );
		} elseif ( $resolues && count( array_filter( $resolues, $du_dept ) ) === count( $resolues ) ) {
			$role  = 'proches';
			$zones = $resolues;
		} else {
			$role  = 'autres';
			$zones = array_filter( $resolues, static fn( $z ) => ! $du_dept( $z ) );
		}

		$retenues = array();
		foreach ( $zones as $z ) {
			if ( isset( $deja[ (int) $z->ID ] ) ) {
				continue;
			}
			$deja[ (int) $z->ID ] = true;
			$retenues[]           = $z;
		}
		$sortie[ (int) $g['rang'] ] = array(
			'role'        => $role,
			'departement' => 'meme_departement' === $role ? $dept_post : null,
			'zones'       => $retenues,
		);
	}
	return $sortie;
}

/**
 * Retrouve l'entrée `zone` de niveau "departement" portant le slug de département donné
 * (le terme de taxonomie `departement` porte le même slug que le post département).
 *
 * @param string $dept_slug
 * @return WP_Post|null
 */
function tfp_get_zone_by_department_slug( $dept_slug ) {
	$posts = get_posts(
		array(
			'post_type'   => 'zone',
			'name'        => $dept_slug,
			'numberposts' => 1,
			'meta_key'    => 'niveau',
			'meta_value'  => 'departement',
		)
	);
	return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Flush des règles de réécriture à l'activation du thème (les add_rewrite_rule() ci-dessus ne
 * prennent effet dans .htaccess/la table d'options qu'après un flush).
 */
function tfp_flush_rewrite_rules_on_activation() {
	tfp_register_cpt_zone();
	tfp_zone_rewrite_rules();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tfp_flush_rewrite_rules_on_activation' );

/**
 * Arborescence « département → villes principales » du pied de page.
 *
 * Reprend la colonne « Zones d'intervention » de la maquette Claude Design, qui liste chaque
 * département suivi de ses villes. La liste est construite depuis le contenu réel (CPT `zone`),
 * pas codée en dur : ajouter une ville en administration la fait apparaître au pied de page sans
 * toucher au gabarit. Seules les zones de niveau « ville » sont listées — les communes secondaires
 * ne sont pas validées (CLAUDE.md §5.4) et n'ont donc pas à être poussées sur les 53 pages.
 *
 * @return array<int,array{post:WP_Post,villes:WP_Post[]}>
 */
function tfp_footer_zones_tree() {
	static $tree = null;
	if ( null !== $tree ) {
		return $tree;
	}

	$departements = get_posts(
		array(
			'post_type'   => 'zone',
			'numberposts' => -1,
			'meta_key'    => 'niveau',
			'meta_value'  => 'departement',
			'orderby'     => 'menu_order title',
			'order'       => 'ASC',
		)
	);

	$tree = array();
	foreach ( $departements as $dept ) {
		$villes = get_posts(
			array(
				'post_type'   => 'zone',
				'numberposts' => -1,
				'meta_key'    => 'niveau',
				'meta_value'  => 'ville',
				'orderby'     => 'title',
				'order'       => 'ASC',
				'tax_query'   => array(
					array(
						'taxonomy' => 'departement',
						'field'    => 'slug',
						'terms'    => $dept->post_name,
					),
				),
			)
		);
		$tree[] = array( 'post' => $dept, 'villes' => $villes );
	}
	return $tree;
}
