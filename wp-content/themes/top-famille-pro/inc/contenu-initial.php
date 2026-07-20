<?php
/**
 * Contenu de départ pour la FAQ (idempotent : ne s'exécute qu'une fois,
 * n'écrase jamais une modification faite ensuite dans l'admin). Utile car
 * aucune base de données n'existe encore pour saisir ce contenu à la main
 * au moment de la construction du thème.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_faq_initiale() {
	$delai = tfp_get_donnee( 'delai_devis_heures' );
	$tarif = tfp_get_donnee( 'tarif_horaire' );

	return array(
		'accueil' => array(
			array( __( 'Quelles zones desservez-vous ?', 'top-famille-pro' ), __( 'Nous intervenons en Bourgogne-Franche-Comté, avec une priorité sur Dijon et la Côte-d\'Or. Voir la liste complète sur la page Zones d\'intervention.', 'top-famille-pro' ) ),
			array( __( 'Combien coûte une prestation de nettoyage ?', 'top-famille-pro' ), sprintf( __( 'Nous appliquons un tarif horaire unique de %s € HT/h. Le nombre d\'heures dépend de votre local : voir des exemples sur la page Tarifs.', 'top-famille-pro' ), $tarif ) ),
			array( __( 'Sous combien de temps recevrai-je une réponse à ma demande de devis ?', 'top-famille-pro' ), sprintf( __( 'Nous revenons vers vous sous %s h après réception de votre demande.', 'top-famille-pro' ), $delai ) ),
			array( __( 'Proposez-vous un nettoyage ponctuel ou seulement régulier ?', 'top-famille-pro' ), __( 'Les deux : interventions régulières sur planning défini, ou interventions ponctuelles selon vos besoins.', 'top-famille-pro' ) ),
			array( __( 'Comment sont sélectionnés les intervenants ?', 'top-famille-pro' ), __( 'Chaque intervenant est sélectionné avant d\'être affecté à un site, et suivi dans la durée via un point régulier et un cahier de liaison.', 'top-famille-pro' ) ),
		),
		'nettoyage-de-bureaux' => array(
			array( __( 'Le nettoyage peut-il avoir lieu en dehors des horaires d\'ouverture ?', 'top-famille-pro' ), __( 'Oui, les interventions peuvent être planifiées avant l\'ouverture, après la fermeture, ou à des horaires décalés selon l\'activité de vos bureaux.', 'top-famille-pro' ) ),
			array( __( 'Fournissez-vous les produits et le matériel ?', 'top-famille-pro' ), __( 'Oui, sauf accord contraire précisé dans le cahier des charges établi avec vous.', 'top-famille-pro' ) ),
			array( __( 'Que se passe-t-il si l\'intervenant habituel est absent ?', 'top-famille-pro' ), __( 'Une solution de remplacement est recherchée pour assurer la continuité de la prestation.', 'top-famille-pro' ) ),
			array( __( 'Comment gérez-vous les clés ou badges d\'accès ?', 'top-famille-pro' ), __( 'Une procédure d\'accès est définie ensemble avant le démarrage (clés, badge, code, ou accueil sur place).', 'top-famille-pro' ) ),
			array( __( 'Le tarif horaire inclut-il des frais supplémentaires ?', 'top-famille-pro' ), __( 'Le taux horaire est unique ; des frais éventuels (mise en place, gestion) peuvent s\'appliquer selon votre situation et vous sont indiqués clairement dans le devis. Voir le détail sur la page Tarifs.', 'top-famille-pro' ) ),
		),
		'tarifs' => array(
			array( __( 'Le tarif horaire est-il le même pour tous les types de locaux ?', 'top-famille-pro' ), __( 'Oui, le taux horaire est unique. Ce qui varie d\'un local à l\'autre, c\'est le nombre d\'heures nécessaires.', 'top-famille-pro' ) ),
			array( __( 'Qu\'est-ce qui est inclus dans le tarif horaire ?', 'top-famille-pro' ), __( 'La main d\'œuvre et l\'encadrement de la prestation. Les produits et le matériel sont fournis par Top-Famille Pro, sauf mention contraire dans le devis.', 'top-famille-pro' ) ),
			array( __( 'Des frais supplémentaires peuvent-ils s\'appliquer ?', 'top-famille-pro' ), __( 'Selon votre situation, des frais de mise en place, de gestion, ou une majoration (dimanche, jour férié, nuit) peuvent s\'appliquer. Ils sont toujours précisés clairement dans votre devis avant tout engagement.', 'top-famille-pro' ) ),
			array( __( 'Comment est calculé le nombre d\'heures nécessaires ?', 'top-famille-pro' ), __( 'Il dépend de la surface, de la fréquence souhaitée, de l\'état des lieux et des conditions d\'accès. C\'est justement l\'objet du devis.', 'top-famille-pro' ) ),
			array( __( 'Le devis est-il gratuit et sans engagement ?', 'top-famille-pro' ), sprintf( __( 'Oui. Nous vous répondons sous %s h, sans engagement de votre part.', 'top-famille-pro' ), $delai ) ),
		),
		'entreprise-nettoyage-dijon' => array(
			array( __( 'Intervenez-vous uniquement à Dijon ou aussi dans les communes autour ?', 'top-famille-pro' ), __( 'Nous intervenons à Dijon et dans les communes voisines (Chenôve, Talant, Fontaine-lès-Dijon, Saint-Apollinaire, Quetigny, Longvic, Marsannay-la-Côte, Daix, Ahuy, Plombières-lès-Dijon), ainsi que dans le reste de la Côte-d\'Or.', 'top-famille-pro' ) ),
			array( __( 'Avez-vous une agence à Dijon ?', 'top-famille-pro' ), __( 'Notre siège est basé à Saint-Apollinaire, à proximité immédiate de Dijon. Nos équipes interviennent directement sur vos sites, sans agence physique en centre-ville.', 'top-famille-pro' ) ),
			array( __( 'Travaillez-vous avec les copropriétés et syndics à Dijon ?', 'top-famille-pro' ), __( 'Oui, nous entretenons les parties communes (halls, escaliers, locaux) en lien avec le syndic ou le conseil syndical.', 'top-famille-pro' ) ),
			array( __( 'Proposez-vous un nettoyage ponctuel avant ou après un événement à Dijon ?', 'top-famille-pro' ), __( 'Oui, en complément d\'un contrat régulier ou de façon totalement ponctuelle.', 'top-famille-pro' ) ),
			array( __( 'Comment obtenir un devis pour un local à Dijon ?', 'top-famille-pro' ), sprintf( __( 'Via le formulaire de demande de devis ou par téléphone : réponse sous %s h.', 'top-famille-pro' ), $delai ) ),
		),
	);
}

function tfp_seeder_contenu_initial() {
	if ( get_option( 'tfp_faq_initiale_semee' ) ) {
		return;
	}

	foreach ( tfp_faq_initiale() as $slug_page => $questions ) {
		foreach ( $questions as $i => $qr ) {
			list( $question, $reponse ) = $qr;
			$id = wp_insert_post(
				array(
					'post_type'    => 'tfp_faq',
					'post_status'  => 'publish',
					'post_title'   => $question,
					'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $reponse ) . '</p><!-- /wp:paragraph -->',
					'menu_order'   => $i,
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				wp_set_object_terms( $id, $slug_page, 'faq_page' );
			}
		}
	}

	update_option( 'tfp_faq_initiale_semee', 1 );
}
add_action( 'init', 'tfp_seeder_contenu_initial', 30 );
