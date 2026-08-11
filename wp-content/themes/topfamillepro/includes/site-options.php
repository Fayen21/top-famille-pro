<?php
/**
 * Données réelles de l'entreprise — source unique : PROJECT_INPUTS.md.
 *
 * RÈGLE ABSOLUE (CLAUDE.md §5.1) : aucune valeur ici ne doit être inventée. Une donnée
 * manquante reste absente (jamais une valeur plausible) ; les gabarits doivent gérer son
 * absence proprement (masquer le bloc, ou remplacer par [À COMPLÉTER] pour les mentions
 * légales — hors périmètre de la phase 1, aucune page légale n'est construite ici).
 *
 * Données d'immatriculation (phase 7) : confirmées par extrait Pappers fourni par le client,
 * qui lève l'incohérence relevée en phase 0 entre deux sources sur le SIREN (l'ancien site
 * annonçait 938 472 242 ; la valeur confirmée est 938 472 420). SIRET, code APE et TVA
 * intracommunautaire confirmés dans un second temps par le client, cohérence formelle
 * recontrôlée indépendamment (clé Luhn du SIRET, clé de contrôle TVA à partir du SIREN) avant
 * intégration. Date de naissance de la gérante et toute autre donnée personnelle non
 * nécessaire à la mention légale : jamais recueillies ni publiées (CLAUDE.md §5.1).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retourne les données réelles du site. Tableau unique, mis en cache statiquement.
 *
 * @return array
 */
function tfp_site_data() {
	static $data = null;

	if ( null === $data ) {
		$data = array(
			'brand_name'      => 'Top-Famille Pro',
			'legal_name'      => 'SARL TOP-ENTREPRISE',
			'manager'         => 'Audrey Brançon',
			'phone'           => '06 36 17 63 39',
			'phone_href'      => '+33636176339',
			'email'           => 'audrey.b@top-famille.fr',
			'address_street'  => '650D route de Gray',
			'address_cp'      => '21850',
			'address_city'    => 'Saint-Apollinaire',
			'address_region'  => 'Bourgogne-Franche-Comté',
			'address_country' => 'FR',
			// Données d'immatriculation — confirmées par Kbis/Pappers (phase 7), voir docblock ci-dessus.
			'legal_form'                  => 'société à responsabilité limitée (SARL)',
			'legal_capital'               => 600.00,
			'legal_capital_display'       => '600,00 €',
			'legal_rcs_city'              => 'Dijon',
			'legal_siren'                 => '938 472 420',
			'legal_siret'                 => '938 472 420 00018',
			'legal_rcs_number'            => '938 472 420 R.C.S. Dijon',
			'legal_immatriculation_date'  => '16/12/2024',
			'legal_immatriculation_date_iso' => '2024-12-16',
			'legal_ape_code'              => '81.21Z',
			'legal_ape_label'             => 'Nettoyage courant des bâtiments',
			'legal_tva'                   => 'FR32 938 472 420',
			'legal_tva_compact'           => 'FR32938472420',
			'legal_activity'              => 'Nettoyage de locaux professionnels et nettoyage courant des bâtiments',
			'legal_activity_start_date'   => '01/01/2025',
			// Formulation complète exacte fournie par le client — à utiliser telle quelle.
			'legal_full_statement'        => 'TOP-ENTREPRISE, SARL au capital de 600 €, immatriculée au RCS de Dijon sous le numéro 938 472 420, SIRET 938 472 420 00018, code APE 81.21Z, TVA intracommunautaire FR32938472420, siège social : RTE de Gray 650D, 21850 Saint-Apollinaire.',
			// Directrice de la publication : confirmée le 9 août 2026 (même personne que la gérante).
			'legal_publication_director'  => 'Audrey Brançon',
			// Hébergeur — confirmé le 9 août 2026, coordonnées publiques Hostinger.
			'host_name'      => 'HOSTINGER INTERNATIONAL LIMITED',
			'host_address'   => '61 Lordou Vironos Street, 6023 Larnaca, Chypre',
			'host_email'     => 'compliance@hostinger.com',
			'host_website'   => 'https://www.hostinger.fr/',
			// Domaine cible (PROJECT_INPUTS.md §1). Filtrable pour les environnements de test/preprod.
			'origin'          => apply_filters( 'tfp_site_origin', home_url( '/' ) ),
			'logo_path'       => '/wp-content/themes/topfamillepro/assets/dist/images/logo-horizontal.png',
			'same_as'         => array(
				'https://www.instagram.com/topfamille/',
				'https://www.facebook.com/topfamillebourgogne/',
				// Fiche Google Business : URL réelle non fournie (PROJECT_INPUTS.md, question ouverte #6).
				// Ne pas ajouter de lien Google tant qu'elle n'est pas communiquée.
			),
			'opening_hours'   => array(
				'days'  => array( 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa' ),
				'opens' => '06:00',
				'closes' => '22:00',
			),
			// Tarif réel (PROJECT_INPUTS.md §5) — identique partout, jamais différenciée par ville
			// (CLAUDE.md §5.3). Tarif unique depuis le 9 août 2026 (hotfix fidélité Claude Design) :
			// remplace l'ancienne grille à trois montants (24,30 € / 26,00 € / 30,00 €) — même
			// montant en entretien régulier et en intervention ponctuelle, quel que soit le local.
			'price_unique'         => 27.00,
			'price_unique_display' => '27 €',
			'price_gestion'        => 9.00,
			'price_setup'          => 50.00,
			'price_km'             => 0.35,
			'price_km_display'     => '0,35 €',
			'price_majoration_pct' => 10,
			'price_currency'       => 'EUR',
			'price_unit'           => 'heure',
			// Départements réellement couverts (PROJECT_INPUTS.md §6) — jamais au-delà.
			'departements'          => array(
				"Côte-d'Or",
				'Doubs',
				'Jura',
				'Nièvre',
				'Haute-Saône',
				'Saône-et-Loire',
				'Yonne',
				'Territoire de Belfort',
			),
		);
	}

	return $data;
}

/**
 * Exemple de budget mensuel pour un nombre d'heures donné — **source unique de vérité**.
 *
 * Tout exemple tarifaire du site passe par ici. Aucun total n'est stocké ni saisi : le seul
 * paramètre est le nombre d'heures, et le montant s'en déduit.
 *
 *     mensuel      = heures × tarif horaire + frais de gestion
 *     premier mois = mensuel + frais de mise en place
 *
 * Le défaut que cette fonction supprime était structurel, et il n'était visible d'aucune
 * recherche de texte : le libellé de l'exemple portait les heures propres à chaque zone
 * (« 8 h/mois », « 16 h/mois »…) tandis que le montant venait d'un exemple **fixe** à 12 heures.
 * Vingt exemples sur trente-trois affichaient donc 333 € HT/mois pour des volumes qui ne
 * donnaient pas ce total. Les montants employaient bien le tarif officiel de 27 € : chercher les
 * anciens tarifs ne pouvait pas les trouver, seul un contrôle par le calcul le pouvait.
 *
 * @param int $hours Nombre d'heures mensuelles.
 * @return array{hours: int, monthly: float, first_month: float}
 */
function tfp_budget_example( $hours ) {
	$site    = tfp_site_data();
	$hours   = max( 1, (int) $hours );
	$monthly = ( $hours * $site['price_unique'] ) + $site['price_gestion'];

	return array(
		'hours'       => $hours,
		'monthly'     => $monthly,
		'first_month' => $monthly + $site['price_setup'],
	);
}

/**
 * Nombre d'heures lu dans un libellé d'exemple (« Exemple · bureaux de PME, 8 h/mois »).
 *
 * Le libellé est la donnée éditoriale relevée sur la maquette ; les heures qu'il annonce sont donc
 * la seule intention fiable. Les extraire du libellé garantit que le montant affiché à côté ne
 * peut pas le contredire — c'est exactement la contradiction qui produisait les vingt exemples
 * faux.
 *
 * @param string $label
 * @param int    $defaut Heures à retenir si le libellé n'en annonce aucune.
 * @return int
 */
function tfp_hours_from_label( $label, $defaut = 12 ) {
	if ( preg_match( '/(\d+)\s*(?:h|heures?)\s*\/\s*mois/ui', (string) $label, $m ) ) {
		return max( 1, (int) $m[1] );
	}
	return $defaut;
}

/**
 * Exemple de budget mensuel affiché sur l'accueil (bureaux réguliers, 12 h/mois).
 * Tarif unique (27,00 € HT/h) — cf. PROJECT_INPUTS.md §5. Exemple non contractuel, calculé
 * (jamais une valeur inventée).
 *
 * @return array{hours: int, monthly: float, first_month: float}
 */
function tfp_home_budget_example() {
	return tfp_budget_example( 12 );
}

/**
 * Table de plusieurs exemples de budget mensuel (page Tarifs, PROJECT_INPUTS.md §5), calculés à
 * partir du tarif unique — jamais des valeurs codées en dur, pour ne jamais désynchroniser d'un
 * changement de tarif.
 *
 * @return array<int, array{hours: int, monthly: float, first_month: float}>
 */
function tfp_budget_examples_table() {
	$rows = array();
	foreach ( array( 8, 12, 20 ) as $hours ) {
		$rows[] = tfp_budget_example( $hours );
	}
	return $rows;
}

/**
 * Formate un montant en euros à la française, sans décimales inutiles.
 *
 * @param float $amount
 * @return string
 */
function tfp_format_price( $amount ) {
	$formatted = number_format( $amount, 2, ',', ' ' );
	// Retire les ",00" superflus (27,50 reste tel quel, 321,00 devient 321).
	$formatted = preg_replace( '/,00$/', '', $formatted );
	return $formatted . ' €';
}

/**
 * Formate une date en français (« 9 août 2026 »), sans dépendre du réglage Réglages → Général →
 * Format de date du site (souvent laissé à l'anglais « F j, Y » par défaut) ni de la locale
 * WordPress active (WPLANG) : un site sans locale fr_FR configurée afficherait sinon les mois en
 * anglais malgré un site entièrement rédigé en français. Bug réel trouvé lors du hotfix de
 * fidélité Claude Design du 9 août 2026 (dates d'articles affichées « Publié le août 9, 2026 »,
 * mélange de format anglais et de mois traduit).
 *
 * @param int|string $post_id_or_timestamp ID de post, ou timestamp Unix.
 * @param bool       $is_post_id           True (défaut) si le premier argument est un ID de post.
 * @return string
 */
function tfp_format_date_fr( $post_id_or_timestamp, $is_post_id = true ) {
	$mois = array(
		1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin',
		7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
	);

	$timestamp = $is_post_id
		? (int) get_post_time( 'U', false, $post_id_or_timestamp )
		: (int) $post_id_or_timestamp;

	$jour       = (int) gmdate( 'j', $timestamp );
	$mois_index = (int) gmdate( 'n', $timestamp );
	$annee      = gmdate( 'Y', $timestamp );

	return $jour . ' ' . $mois[ $mois_index ] . ' ' . $annee;
}
