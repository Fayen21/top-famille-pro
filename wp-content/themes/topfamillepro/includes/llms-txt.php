<?php
/**
 * /llms.txt — résumé du site destiné aux assistants conversationnels et moteurs génératifs (GEO).
 *
 * Format proposé sur llmstxt.org : un titre, un résumé en citation, puis des listes de liens
 * commentés. Le fichier est **construit à chaque requête depuis les mêmes données que les pages**
 * (tfp_site_data(), champs SEO des prestations et des zones, articles publiés) : il ne peut pas
 * diverger du site, et il n'affirme rien que le site n'affirme pas.
 *
 * Exclus volontairement : note Google, nombre d'avis, témoignages (CLAUDE.md §5.5), horaires non
 * confirmés, et toute zone non validée (statut_validation décoché → absente, comme du sitemap).
 *
 * Servi sans règle de réécriture (aucun « Enregistrer les permaliens » nécessaire) : la requête
 * est interceptée au moment où WordPress l'analyse.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Intercepte /llms.txt.
 *
 * @param WP $wp Requête en cours.
 */
function tfp_llms_txt_intercept( $wp ) {
	if ( 'llms.txt' !== $wp->request ) {
		return;
	}
	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: noindex' );
	echo tfp_llms_txt(); // phpcs:ignore WordPress.Security.EscapeOutput -- texte brut, construit depuis des données internes.
	exit;
}
add_action( 'parse_request', 'tfp_llms_txt_intercept', 1 );

/**
 * Description SEO d'un contenu, ou à défaut son extrait.
 *
 * @param int $post_id Identifiant.
 * @return string
 */
function tfp_llms_description( $post_id ) {
	$d = function_exists( 'tfp_get_field' ) ? (string) tfp_get_field( 'seo_description', $post_id ) : '';
	if ( '' === $d ) {
		$d = wp_strip_all_tags( get_the_excerpt( $post_id ) );
	}
	return trim( html_entity_decode( $d, ENT_QUOTES, 'UTF-8' ) );
}

/**
 * Ligne de liste Markdown « - [Titre](url) : description ».
 */
function tfp_llms_ligne( $titre, $url, $desc = '' ) {
	$titre = html_entity_decode( wp_strip_all_tags( $titre ), ENT_QUOTES, 'UTF-8' );
	return '- [' . $titre . '](' . esc_url_raw( $url ) . ')' . ( $desc ? ' : ' . $desc : '' ) . "\n";
}

/**
 * Contenu complet du fichier.
 *
 * @return string
 */
function tfp_llms_txt() {
	$site  = tfp_site_data();
	$prix  = $site['price_unique_display'];
	$depts = implode( ', ', $site['departements'] );

	$o  = '# ' . $site['brand_name'] . "\n\n";
	$o .= '> Entreprise de nettoyage de locaux professionnels basée à ' . $site['address_city'] . ' (' . $site['address_cp'] . '), près de Dijon. '
		. 'Entretien régulier ou ponctuel de bureaux, commerces, cabinets, copropriétés et locations meublées dans toute la '
		. $site['address_region'] . ' (' . $depts . '). Tarif unique de ' . $prix . ' HT de l\'heure, identique partout. '
		. "Devis gratuit, sans engagement, réponse sous 24 heures.\n\n";

	$o .= "## L'essentiel\n\n";
	$o .= '- Raison sociale : ' . $site['legal_name'] . ', marque ' . $site['brand_name'] . ".\n";
	$o .= '- Un seul établissement : ' . $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] . ". Pas d'agence locale : les autres villes sont des zones desservies.\n";
	$o .= '- Interlocutrice : ' . $site['manager'] . ", gérante, du devis au suivi.\n";
	$o .= '- Contact : ' . $site['phone'] . ' · ' . $site['email'] . "\n";
	$o .= '- Tarif : ' . $prix . ' HT/h, tarif unique en régulier comme en ponctuel. Frais de gestion '
		. number_format( (float) $site['price_gestion'], 0, ',', ' ' ) . ' € HT/mois en contrat régulier, mise en place '
		. number_format( (float) $site['price_setup'], 0, ',', ' ' ) . ' € HT, indemnités kilométriques ' . $site['price_km_display']
		. ' HT/km selon la distance, majoration de ' . (int) $site['price_majoration_pct'] . " % le dimanche, les jours fériés et la nuit (22 h – 7 h).\n";
	$o .= "- Le matériel et les produits sont fournis par le client.\n";
	$o .= "- Hors périmètre : locaux industriels, alimentaires et médicaux nécessitant une asepsie.\n\n";

	$o .= "## Prestations\n\n";
	foreach ( get_posts( array( 'post_type' => 'prestation', 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) ) as $p ) {
		$o .= tfp_llms_ligne( get_the_title( $p ), get_permalink( $p ), tfp_llms_description( $p->ID ) );
	}

	$o .= "\n## Zones d'intervention\n\n";
	$o .= tfp_llms_ligne( "Toutes les zones d'intervention", home_url( '/zones-intervention/' ), 'les huit départements desservis' );
	$niveaux = array( 'departement' => 'Départements', 'ville' => 'Villes', 'commune' => 'Communes autour de Dijon et de Beaune' );
	foreach ( $niveaux as $niveau => $libelle ) {
		$zones = get_posts(
			array(
				'post_type'   => 'zone',
				'numberposts' => -1,
				'orderby'     => 'title',
				'order'       => 'ASC',
				'meta_query'  => array( array( 'key' => 'niveau', 'value' => $niveau ) ),
			)
		);
		$lignes = '';
		foreach ( $zones as $z ) {
			$valide = function_exists( 'tfp_get_field' ) ? tfp_get_field( 'statut_validation', $z->ID ) : true;
			if ( ! $valide && 'commune' === $niveau ) {
				continue;
			}
			$lignes .= tfp_llms_ligne( get_the_title( $z ), get_permalink( $z ) );
		}
		if ( $lignes ) {
			$o .= "\n### " . $libelle . "\n\n" . $lignes;
		}
	}

	$o .= "\n## Pages utiles\n\n";
	$pages = array(
		'nettoyage-professionnel' => 'le nettoyage professionnel expliqué : périmètre, organisation, tarif, limites',
		'tarifs'                  => 'grille tarifaire complète et exemples de budgets mensuels',
		'notre-fonctionnement'    => 'les étapes, du premier échange au suivi des passages',
		'pourquoi-nous'           => 'ce qui distingue l\'organisation, réponses aux objections courantes',
		'a-propos'                => 'l\'entreprise et sa gérante',
		'demande-de-devis'        => 'formulaire de devis en deux étapes',
		'contact'                 => 'téléphone, e-mail et formulaire de contact',
	);
	foreach ( $pages as $slug => $desc ) {
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === $page->post_status ) {
			$o .= tfp_llms_ligne( get_the_title( $page ), get_permalink( $page ), $desc );
		}
	}

	$articles = get_posts( array( 'post_type' => 'post', 'numberposts' => -1 ) );
	if ( $articles ) {
		$o .= "\n## Conseils\n\n";
		foreach ( $articles as $a ) {
			$o .= tfp_llms_ligne( get_the_title( $a ), get_permalink( $a ), tfp_llms_description( $a->ID ) );
		}
	}

	$o .= "\n## Optional\n\n";
	$o .= tfp_llms_ligne( 'Plan du site', home_url( '/plan-du-site/' ) );
	$o .= tfp_llms_ligne( 'Mentions légales', home_url( '/mentions-legales/' ) );
	$o .= tfp_llms_ligne( 'Recrutement', home_url( '/recrutement/' ), 'candidatures sur le site carrière du groupe' );

	return $o;
}
