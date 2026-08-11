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
