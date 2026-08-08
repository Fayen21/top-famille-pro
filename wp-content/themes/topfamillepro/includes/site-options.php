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
			// Grille tarifaire réelle (PROJECT_INPUTS.md §5) — identique partout, jamais différenciée par ville (CLAUDE.md §5.3).
			'price_entry'          => 24.30,
			'price_entry_display'  => '24,30 €',
			'price_autres_locaux'  => 26.00,
			'price_ponctuel'       => 30.00,
			'price_gestion'        => 9.00,
			'price_setup'          => 50.00,
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
 * Exemple de budget mensuel affiché sur l'accueil (« bureaux réguliers », 12 h/mois).
 * Bureaux = tarif « autres locaux » (26,00 € HT/h), pas le tarif « locations » (24,30 €),
 * qui ne s'applique qu'aux locations meublées — cf. PROJECT_INPUTS.md §5.
 * Exemple non contractuel, calculé (jamais une valeur inventée).
 *
 * @return array{hours: int, monthly: float, first_month: float}
 */
function tfp_home_budget_example() {
	$site    = tfp_site_data();
	$hours   = 12;
	$monthly = ( $hours * $site['price_autres_locaux'] ) + $site['price_gestion'];
	$first   = $monthly + $site['price_setup'];

	return array(
		'hours'       => $hours,
		'monthly'     => $monthly,
		'first_month' => $first,
	);
}

/**
 * Formate un montant en euros à la française, sans décimales inutiles.
 *
 * @param float $amount
 * @return string
 */
function tfp_format_price( $amount ) {
	$formatted = number_format( $amount, 2, ',', ' ' );
	// Retire les ",00" superflus (24,30 reste tel quel, 321,00 devient 321).
	$formatted = preg_replace( '/,00$/', '', $formatted );
	return $formatted . ' €';
}
