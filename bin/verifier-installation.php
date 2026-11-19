<?php
/**
 * Contrôle post-installation — ce que le site publie **en plus** des 53 routes attendues.
 *
 * Motif : trois URL — `/page-perso-de-ladministrateur/`, `/nettoyage-ecologique-ancienne-offre/`
 * et `/devis-rapide/` — ont été trouvées publiées et référencées au sitemap sur un banc, alors
 * qu'aucun script de contenu ne les crée. C'étaient des résidus d'un essai antérieur sur cette
 * installation. Le cas se reproduira sur l'installation réelle : elle n'est pas vierge, elle
 * succède à un site Wix migré et à des essais.
 *
 * Une page oubliée n'est pas un détail cosmétique. Publiée, elle est indexable ; référencée au
 * sitemap, elle est proposée à l'indexation ; et son contenu est celui d'un brouillon ou d'une
 * ancienne offre. Le site promet alors une prestation qui n'existe plus, sous une URL que
 * personne ne surveille.
 *
 * Ce script ne supprime rien : il **liste**. La suppression est une décision humaine — une des
 * URL inattendues peut être une page légitime ajoutée par Audrey après la livraison.
 *
 * Usage : wp eval-file bin/verifier-installation.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Slugs des 53 routes livrées, dans l'ordre du manifeste. */
function tfp_slugs_attendus() {
	return array(
		/*
		 * 17 pages statiques. La dix-huitième route statique est l'accueil : il est rendu par
		 * `front-page.php`, sans page WordPress correspondante, et n'a donc pas de slug à vérifier
		 * ici. 52 contenus attendus pour 53 routes.
		 */
		'nettoyage-professionnel', 'prestations', 'tarifs', 'zones-intervention',
		'pourquoi-nous', 'notre-fonctionnement', 'avis-clients', 'a-propos', 'demande-de-devis',
		'contact', 'recrutement', 'conseils', 'plan-du-site', 'mentions-legales',
		'politique-de-confidentialite', 'gestion-des-cookies',
		// 6 prestations.
		'bureaux', 'commerces', 'cabinets', 'coproprietes', 'meubles', 'ponctuel',
		// 26 zones : 1 région + 8 départements + 10 villes + 8 communes.
		'bourgogne-franche-comte',
		'cote-dor', 'doubs', 'jura', 'nievre', 'haute-saone', 'saone-et-loire', 'yonne',
		'territoire-de-belfort',
		'dijon', 'besancon', 'dole', 'lons-le-saunier', 'nevers', 'vesoul', 'chalon-sur-saone',
		'macon', 'auxerre', 'belfort',
		'saint-apollinaire', 'chenove', 'quetigny', 'talant', 'longvic', 'fontaine-les-dijon',
		'marsannay-la-cote', 'beaune',
		// 3 articles.
		'frequence-bureaux', 'cout-nettoyage-bureaux', 'cahier-des-charges-nettoyage',
	);
}

$attendus  = tfp_slugs_attendus();
$inattendu = array();
$publies   = 0;

foreach ( array( 'page', 'post', 'prestation', 'zone' ) as $type ) {
	$entrees = get_posts(
		array(
			'post_type'   => $type,
			'post_status' => array( 'publish', 'future', 'private' ),
			'numberposts' => -1,
		)
	);
	foreach ( $entrees as $p ) {
		$publies++;
		if ( in_array( $p->post_name, $attendus, true ) ) {
			continue;
		}
		$inattendu[] = array(
			'type'   => $type,
			'slug'   => $p->post_name,
			'titre'  => $p->post_title,
			'statut' => $p->post_status,
			'url'    => get_permalink( $p ),
			// Une page peut être publiée sans figurer au sitemap si elle est en `noindex`.
			'sitemap' => 'publish' === $p->post_status && 'noindex' !== get_post_meta( $p->ID, '_tfp_robots', true ),
		);
	}
}

echo "Contrôle post-installation — Top-Famille Pro\n";
echo str_repeat( '=', 60 ) . "\n";
printf( "Contenus publiés : %d · attendus : %d (l’accueil est rendu par front-page.php, sans page)\n\n", $publies, count( $attendus ) );

if ( ! $inattendu ) {
	echo "✅ Aucun contenu inattendu. L'installation ne publie que les 53 routes livrées.\n";
} else {
	printf( "⚠️  %d contenu(s) inattendu(s) — à examiner un par un avant mise en ligne :\n\n", count( $inattendu ) );
	foreach ( $inattendu as $x ) {
		printf(
			"  [%s] %s\n      %s\n      slug « %s » · statut %s%s\n",
			$x['type'],
			$x['titre'] ?: '(sans titre)',
			$x['url'],
			$x['slug'],
			$x['statut'],
			$x['sitemap'] ? " · **référencé au sitemap**" : ''
		);
	}
	echo "\nCe script ne supprime rien : une de ces pages peut avoir été ajoutée volontairement.\n";
	echo "Pour chacune, trancher entre : conserver · dépublier · supprimer avec une redirection 301.\n";
}

// --- Manquants : une route attendue absente est un lien mort dans le maillage.
$presents = array();
foreach ( array( 'page', 'post', 'prestation', 'zone' ) as $type ) {
	foreach ( get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'numberposts' => -1 ) ) as $p ) {
		$presents[] = $p->post_name;
	}
}
$manquants = array_values( array_diff( $attendus, $presents ) );
if ( $manquants ) {
	printf( "\n❌ %d route(s) attendue(s) absente(s) : %s\n", count( $manquants ), implode( ', ', $manquants ) );
} else {
	echo "\n✅ Les 53 routes attendues sont présentes.\n";
}

/*
 * Les trois URL relevées sur un banc de recette, nommément.
 *
 * Elles ne sont pas créées par l'installation : ce sont des résidus d'essais antérieurs. Mais
 * l'installation réelle succède à une migration Wix et à des essais, et une ancienne offre restée
 * publiée promet une prestation qui n'existe plus, sous une URL que personne ne surveille. On les
 * vérifie donc nommément, en plus du contrôle général, et **le script échoue** si l'une d'elles
 * est encore publiée ou référencée au sitemap.
 */
$parasites  = array( 'page-perso-de-ladministrateur', 'nettoyage-ecologique-ancienne-offre', 'devis-rapide' );
$sitemap    = '';
$url_map    = home_url( '/wp-sitemap.xml' );
$reponse    = wp_remote_get( $url_map, array( 'timeout' => 10 ) );
if ( ! is_wp_error( $reponse ) ) {
	$sitemap = wp_remote_retrieve_body( $reponse );
	// Le sitemap racine n'est qu'un index : on suit ses sous-sitemaps.
	if ( preg_match_all( '#<loc>([^<]+\.xml)</loc>#', $sitemap, $m ) ) {
		foreach ( $m[1] as $sous ) {
			$r = wp_remote_get( $sous, array( 'timeout' => 10 ) );
			if ( ! is_wp_error( $r ) ) {
				$sitemap .= wp_remote_retrieve_body( $r );
			}
		}
	}
}

$echecs = array();
foreach ( $parasites as $slug ) {
	$page = get_page_by_path( $slug, OBJECT, array( 'page', 'post', 'prestation', 'zone' ) );
	if ( $page && 'publish' === $page->post_status ) {
		$echecs[] = sprintf( '« %s » est publiée (%s)', $slug, get_permalink( $page ) );
	}
	if ( $sitemap && false !== strpos( $sitemap, '/' . $slug . '/' ) ) {
		$echecs[] = sprintf( '« %s » figure au sitemap', $slug );
	}
}

echo "\n" . str_repeat( '-', 60 ) . "\n";
printf( "URL héritées vérifiées nommément : %s\n", implode( ', ', $parasites ) );
foreach ( $echecs as $e ) {
	echo "  ❌ $e\n";
}

/*
 * Verdict explicite. Un script qui se contente de « retrouver » les URL ne prouve rien : c'est le
 * code de sortie qui permet de l'enchaîner dans une recette et de bloquer une mise en ligne.
 */
$ok = empty( $echecs ) && empty( $manquants );
echo "\n" . ( $ok
	? "PASS — aucune URL héritée publiée ou référencée, et les 53 routes sont présentes.\n"
	: "FAIL — l'installation ne doit pas être ouverte à l'indexation en l'état.\n" );

// Les contenus inattendus sans être des parasites connus n'échouent pas : ils demandent un arbitrage.
if ( $inattendu && $ok ) {
	echo "Note : " . count( $inattendu ) . " contenu(s) inattendu(s) ci-dessus demandent un arbitrage humain.\n";
}

/*
 * Code de sortie non nul en cas d'échec : c'est ce qui permet d'enchaîner ce contrôle dans une
 * recette et de bloquer une mise en ligne. `WP_CLI::halt()` court-circuite la fin de commande de
 * WP-CLI, qui remettrait 0.
 */
if ( ! $ok ) {
	if ( class_exists( 'WP_CLI' ) ) {
		WP_CLI::halt( 1 );
	}
	exit( 1 );
}
