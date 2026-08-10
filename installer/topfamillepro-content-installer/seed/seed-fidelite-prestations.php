<?php
/**
 * Contenu intégral des 6 prestations, relevé dans la maquette Claude Design.
 *
 * Fichier **généré** par `node tools/generate-prestations.mjs` — ne pas éditer à la main :
 * toute correction se fait dans le générateur, sinon la prochaine régénération l'écrase.
 *
 * Le contenu est reproduit tel quel (consigne du 10 août 2026 : reproduire la maquette à
 * 100 %, ne pas la réécrire ni la raccourcir). Les montants ne sont pas figés ici : le
 * gabarit les recalcule depuis includes/site-options.php, seul point d'entrée du tarif.
 *
 * Usage : wp eval-file bin/seed-fidelite-prestations.php
 * Idempotent : upsert par slug, une deuxième exécution ne crée aucun doublon.
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-prestations.php\n" );
}

if ( ! function_exists( 'tfp_seed_set_field' ) ) {
	function tfp_seed_set_field( $selector, $value, $post_id ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( $selector, $value, $post_id );
		} else {
			update_post_meta( $post_id, $selector, $value );
		}
	}
}

echo "=== Fidélité Claude Design : contenu intégral des 6 prestations ===\n";

/* ---------------- bureaux ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'bureaux', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation bureaux absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Nettoyage de bureaux', $id );
	tfp_seed_set_field( 'label_court', 'Bureaux', $id );
	tfp_seed_set_field( 'h1', 'Nettoyage de bureaux en Bourgogne-Franche-Comté', $id );
	tfp_seed_set_field( 'tease', 'Un entretien régulier et discret de vos espaces de travail, confié autant que possible à un intervenant habituel, pour des bureaux toujours prêts à recevoir vos équipes et vos visiteurs.', $id );
	tfp_seed_set_field( 'hero_alt', 'Nettoyage de bureaux en Bourgogne-Franche-Comté', $id );
	tfp_seed_set_field( 'reponse_directe', 'Le nettoyage de bureaux demande de la régularité et de la discrétion. Nous intervenons tôt le matin, en fin de journée ou pendant les heures creuses, selon l\'organisation de votre entreprise, afin de ne jamais perturber votre activité.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'PME et sièges sociaux',
		'Espaces de coworking',
		'Agences',
		'Plateaux tertiaires',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Dépoussiérage du mobilier de bureau',
		'Écrans et claviers : dépoussiérage prudent selon les consignes et le matériel autorisé',
		'Vidage des corbeilles et tri des points de collecte',
		'Aspiration et lavage des sols',
		'Entretien des points de contact courants',
		'Entretien et réapprovisionnement des sanitaires',
		'Nettoyage de la cuisine ou salle de pause',
		'Salles de réunion remises en ordre',
		'Accueil et vitres intérieures',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', 'Hors prestation courante : maintenance informatique, déplacement de mobilier lourd, nettoyage de moquette en profondeur (shampouinage), qui font l\'objet d\'un devis distinct.', $id );
	tfp_seed_set_field( 'exclusions_titre', '', $id );
	tfp_seed_set_field( 'exclusions_intro', '', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(

	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Une salle de réunion utilisée toute la journée doit être remise en état avant chaque nouvelle réunion, sans que cela repose sur vos équipes.',
		'Les postes de travail partagés (flex-office, open-space) demandent un passage plus régulier sur les surfaces de contact, dès lors qu\'ils sont libérés de tout effet personnel.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple de planning pour un plateau de 15 postes : passage 3 matins par semaine avant 8 h — sols, sanitaires, cuisine, corbeilles ; vitres intérieures et accueil une fois par semaine.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Moins de 10 postes', $id );
	tfp_seed_set_field( 'config_1_texte', 'Un plateau de moins de dix postes se traite le plus souvent en un à deux passages hebdomadaires de deux à trois heures : sols, sanitaires, coin cuisine et corbeilles à chaque passage, dépoussiérage du mobilier en alternance selon les zones. À cette taille, le volume mensuel se situe fréquemment entre 8 et 16 heures.', $id );
	tfp_seed_set_field( 'config_2_titre', 'De 10 à 30 postes', $id );
	tfp_seed_set_field( 'config_2_texte', 'Au-delà de dix postes, la charge se concentre sur les sanitaires, la salle de pause et les sols de circulation, qui se salissent bien plus vite que les bureaux eux-mêmes. Trois passages par semaine constituent souvent le bon équilibre, avec un passage plus long en fin de semaine pour l\'accueil et les vitres intérieures.', $id );
	tfp_seed_set_field( 'config_3_titre', 'Plus de 30 postes ou plusieurs plateaux', $id );
	tfp_seed_set_field( 'config_3_texte', 'À partir d\'une trentaine de postes, un passage quotidien devient généralement nécessaire pour les sanitaires et la cuisine. Le cahier des charges distingue alors clairement les tâches quotidiennes, hebdomadaires et mensuelles, et le travail est réparti par étage ou par zone plutôt qu\'appliqué uniformément partout.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Fréquence selon les effectifs', $id );
	tfp_seed_set_field( 'detail_1_texte', 'La fréquence dépend moins de la surface que du nombre de personnes réellement présentes chaque jour. Un plateau de 200 m² occupé par six personnes ne représente pas la même charge que le même plateau occupé par vingt. Nous partons donc de l\'effectif présent, du nombre de sanitaires, de l\'existence d\'une cuisine et du niveau de passage extérieur pour proposer un rythme, puis nous l\'ajustons après les premières semaines si la réalité du terrain le demande.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'Confidentialité des espaces de travail', $id );
	tfp_seed_set_field( 'detail_2_texte', 'Des dossiers ouverts, des écrans allumés, un tableau non effacé : un bureau contient en permanence des informations qui ne doivent pas circuler. Le cahier des charges précise les zones où l\'intervenant n\'entre pas sans accompagnement, les documents qui ne sont jamais déplacés et le traitement des corbeilles contenant des papiers. La discrétion figure parmi nos critères de sélection, au même titre que la fiabilité.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Flex-office et postes partagés', $id );
	tfp_seed_set_field( 'detail_3_texte', 'En flex-office, aucun poste n\'appartient durablement à quelqu\'un : les surfaces sont utilisées par plusieurs personnes dans la même semaine et les affaires personnelles ne restent pas sur les plans de travail. Cela simplifie le nettoyage des surfaces mais impose un passage plus régulier sur les plateaux et les accoudoirs. Nous convenons avec vous de ce qui est considéré comme libéré, donc traitable, et de ce qui est contourné.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Postes informatiques et matériel autorisé', $id );
	tfp_seed_set_field( 'detail_4_texte', 'Écrans, claviers, souris, téléphones et unités centrales font l\'objet d\'un dépoussiérage prudent selon les consignes et le matériel autorisé. Aucun produit n\'est appliqué sur du matériel informatique sans instruction écrite de votre part, et aucun équipement n\'est débranché ni déplacé. Toute intervention plus poussée sur du matériel sensible reste du ressort de votre prestataire informatique.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Salles de réunion', $id );
	tfp_seed_set_field( 'detail_5_texte', 'Une salle utilisée toute la journée demande une remise en ordre plutôt qu\'un simple nettoyage : sièges repositionnés, table essuyée, tableau effacé si la consigne le prévoit, verres et bouteilles retirés, corbeille vidée. Nous convenons d\'un créneau réaliste, en début ou en fin de journée, et les salles qui n\'ont pas pu être traitées parce qu\'elles étaient occupées sont notées dans le cahier de liaison.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Cuisine et salle de pause', $id );
	tfp_seed_set_field( 'detail_6_texte', 'La salle de pause est souvent la pièce la plus sollicitée et la première source de remarques internes. Le cahier des charges y prévoit le plan de travail, l\'évier, l\'extérieur des appareils (micro-ondes, réfrigérateur, machine à café), les tables et le sol. Le nettoyage intérieur du réfrigérateur et son dégivrage sont possibles, mais planifiés séparément car ils supposent que la cuisine soit vidée au préalable.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Sanitaires', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Les sanitaires conditionnent la perception générale de la propreté des locaux. Ils sont nettoyés et désinfectés à chaque passage prévu, avec réapprovisionnement du papier, du savon et des sacs lorsque vous fournissez ces consommables. L\'intervenant signale dans le cahier de liaison tout stock bas ou tout dysfonctionnement (chasse d\'eau, sèche-mains) afin que vous puissiez agir avant que la gêne devienne visible.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Organisation des horaires', $id );
	tfp_seed_set_field( 'detail_8_texte', 'Trois organisations sont possibles : avant l\'arrivée des équipes (généralement entre 6 h et 8 h 30), après leur départ (à partir de 18 h), ou en journée sur un créneau creux identifié avec vous. Le choix dépend de vos horaires réels, de la gestion de l\'alarme et de la présence éventuelle d\'un référent. Les créneaux de nuit, du dimanche et des jours fériés sont possibles et font l\'objet d\'une majoration annoncée au devis.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour un plateau de 15 postes, le cahier des charges type précise : dépoussiérage quotidien des bureaux, dépoussiérage prudent des écrans selon les consignes et le matériel autorisé, aspiration des sols trois fois par semaine et lavage hebdomadaire, sanitaires désinfectés à chaque passage avec réapprovisionnement du papier et du savon, cuisine remise en ordre après chaque passage, salle de réunion vérifiée et remise en état après chaque usage recensé dans le planning partagé.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits d\'entretien courants (sols, sanitaires, vitres) et le matériel (aspirateur, chariot, chiffons microfibres) sont généralement fournis par vos soins, ce qui garantit l\'usage de références déjà validées pour vos revêtements et votre mobilier. Nous signalons via le cahier de liaison tout consommable à réapprovisionner (papier, savon, sacs poubelle) pour éviter toute rupture.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès aux bureaux est organisé selon votre configuration : remise d\'un jeu de clés, badge d\'accès, code d\'alarme à désactiver/réactiver, ou présence d\'un référent aux heures convenues. Ces modalités sont consignées par écrit et transmises uniquement aux intervenants concernés par votre site, avec un protocole clair en cas de déclenchement accidentel d\'alarme.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'L\'intervenant qui entretient vos bureaux est choisi avec soin, notamment pour sa fiabilité et sa discrétion — un critère important dans des open-spaces où circulent des documents et des écrans allumés. Nous recherchons un intervenant habituel qui connaît vos locaux, vos horaires de présence et vos consignes de confidentialité, et privilégions cette continuité autant que possible.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Un cahier de liaison reste sur place pour tracer chaque passage : tâches réalisées, remarques de l\'intervenant, demandes ponctuelles de vos équipes. Audrey consulte ce suivi régulièrement et reste votre interlocutrice directe pour tout ajustement du cahier des charges ou de la fréquence.', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'En cas d\'absence imprévue de l\'intervenant habituel (congé, maladie), nous recherchons activement une solution de remplacement pour maintenir le passage prévu et vous informons de l\'organisation retenue. L\'objectif est d\'éviter qu\'un bureau reste sans entretien plusieurs jours d\'affilée, sans que nous puissions promettre un remplacement immédiat dans tous les cas.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Semaine type pour un plateau de 15 postes, avec passage le lundi, le mercredi et le vendredi entre 6 h 30 et 8 h : le lundi, sanitaires, cuisine, corbeilles et aspiration des circulations et de l\'open-space ; le mercredi, les mêmes tâches auxquelles s\'ajoutent le dépoussiérage des bureaux et le lavage des sols ; le vendredi, les mêmes tâches plus l\'accueil, les vitres intérieures et la remise en ordre des salles de réunion. Ce découpage est indicatif : il est arrêté avec vous au moment du cahier des charges et peut être réorganisé.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Nous ne prenons pas en charge la maintenance informatique, le déplacement de mobilier lourd, le shampouinage de moquette ni le nettoyage de vitres en hauteur nécessitant un équipement spécialisé : ces interventions sont chiffrées séparément ou confiées à un spécialiste. Les documents et effets personnels laissés sur les postes ne sont pas rangés : ils sont contournés, jamais déplacés.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nos bureaux sont faits avant 8 h et plus personne dans l\'équipe n\'a à s\'en occuper. Ce qui nous a décidés, c\'est la discrétion sur les dossiers laissés sur les postes.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Camille R.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Dirigeante de PME', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Dijon', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Bureaux', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous pendant que nos équipes sont présentes ?', 'reponse' => 'Nous privilégions les horaires avant l\'arrivée ou après le départ de vos salariés, pour ne pas perturber votre activité. Une intervention en journée reste possible sur demande.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le nettoyage des écrans et claviers est-il inclus ?', 'reponse' => 'Il s\'agit d\'un dépoussiérage prudent selon les consignes et le matériel autorisé. Nous n\'appliquons aucun produit sur les écrans, claviers ou unités centrales sans instruction écrite de votre part, et nous ne débranchons ni ne déplaçons aucun équipement.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Que faites-vous en cas de salle de réunion occupée en continu ?', 'reponse' => 'Nous adaptons le passage à un créneau libre identifié avec vous, ou reportons ce point précis au passage suivant en le notant dans le cahier de liaison.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Combien d\'heures faut-il prévoir pour nos bureaux ?', 'reponse' => 'Le volume dépend de l\'effectif réellement présent, du nombre de sanitaires et de la fréquence retenue, davantage que de la seule surface. À titre indicatif, un plateau d\'une dizaine de postes se situe souvent entre 8 et 16 heures par mois. L\'estimation précise est établie après échange sur vos locaux, jamais par un simulateur automatique.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Le même intervenant vient-il à chaque passage ?', 'reponse' => 'C\'est l\'organisation que nous recherchons : un intervenant habituel qui connaît vos locaux, vos horaires et vos consignes de confidentialité. Cette continuité est privilégiée autant que possible, sans constituer une garantie absolue en cas d\'absence ou de changement de disponibilité.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Comment sont gérées les clés et l\'alarme ?', 'reponse' => 'Les modalités d\'accès (jeu de clés, badge, code) sont définies avec vous et consignées par écrit avant le premier passage, avec une consigne claire en cas de déclenchement accidentel. Elles ne sont transmises qu\'aux intervenants concernés par votre site.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Pouvons-nous modifier la fréquence en cours d\'année ?', 'reponse' => 'Oui. Un déménagement, une embauche ou une baisse d\'activité justifient souvent un ajustement. La modification passe par un échange avec Audrey, puis par un devis actualisé si le volume d\'heures change.' ), $id );
	tfp_seed_set_field( 'faq_8', array( 'question' => 'Que se passe-t-il si une tâche prévue n\'a pas été réalisée ?', 'reponse' => 'Elle est signalée dans le cahier de liaison avec sa raison (pièce occupée, accès impossible, temps insuffisant) et reportée au passage suivant. Si le cas se répète, c\'est généralement le signe que le volume d\'heures ou le découpage des tâches doit être revu.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Bureaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ bureaux\n";
}

/* ---------------- commerces ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'commerces', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation commerces absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Nettoyage de commerces', $id );
	tfp_seed_set_field( 'label_court', 'Commerces', $id );
	tfp_seed_set_field( 'h1', 'Nettoyage de commerces et de surfaces de vente', $id );
	tfp_seed_set_field( 'tease', 'Une surface de vente impeccable à l\'ouverture : sols, vitrines et sanitaires clients entretenus avant l\'arrivée de vos premiers visiteurs.', $id );
	tfp_seed_set_field( 'hero_alt', 'Nettoyage de commerces et de surfaces de vente', $id );
	tfp_seed_set_field( 'reponse_directe', 'La propreté d\'un commerce influence directement l\'image perçue par vos clients. Nous adaptons nos horaires à vos jours et heures d\'ouverture, y compris tôt le matin.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'Boutiques et prêt-à-porter',
		'Showrooms',
		'Salons et instituts',
		'Points de vente centre-ville et zone commerciale',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Nettoyage et lustrage des sols',
		'Vitrines : incluses uniquement lorsqu\'elles sont accessibles sans équipement spécialisé et prévues au devis',
		'Cabines et mobilier de vente',
		'Sanitaires clients et personnel',
		'Dépoussiérage des rayonnages',
		'Espace caisse et accueil',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', 'Hors prestation courante : nettoyage de vitrines en hauteur nécessitant une nacelle, entretien de stocks en réserve non accessibles, désinfection réglementée (agroalimentaire).', $id );
	tfp_seed_set_field( 'exclusions_titre', '', $id );
	tfp_seed_set_field( 'exclusions_intro', '', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(

	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Une vitrine ternie ou des sols marqués dès l\'ouverture donnent une image négative avant même l\'arrivée du premier client.',
		'Les jours de forte affluence (soldes, marché, week-end) demandent parfois un passage supplémentaire pour tenir la surface de vente propre toute la journée.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple pour une boutique ouverte du mardi au samedi : passage quotidien avant ouverture (sols, vitrines, caisse, sanitaires) ; cabines et rayonnages en fin de semaine.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Passage avant ouverture', $id );
	tfp_seed_set_field( 'config_1_texte', 'C\'est l\'organisation la plus fréquente : l\'intervenant entre avant votre arrivée ou avec vous, et la surface de vente est prête avant le premier client. Le créneau est calé sur votre heure d\'ouverture réelle, avec une marge de sécurité. Cela suppose que l\'accès et l\'alarme soient organisés à l\'avance et consignés par écrit.', $id );
	tfp_seed_set_field( 'config_2_titre', 'Passage après fermeture', $id );
	tfp_seed_set_field( 'config_2_texte', 'Lorsque l\'ouverture est trop matinale ou que la boutique est difficile d\'accès le matin, l\'intervention a lieu après la fermeture. L\'avantage : plus de temps disponible et aucune gêne pour la clientèle. Le point de vigilance : les sols lavés le soir peuvent marquer à nouveau si un réassort a lieu très tôt le lendemain.', $id );
	tfp_seed_set_field( 'config_3_titre', 'Renfort sur les jours de forte fréquentation', $id );
	tfp_seed_set_field( 'config_3_texte', 'Samedi, jour de marché, soldes, fêtes de fin d\'année : certains jours concentrent l\'essentiel du passage et salissent les sols et les cabines en quelques heures. Un passage supplémentaire, ou un second passage court en milieu de journée, peut être prévu par avenant au devis pour ces périodes précises, puis retiré ensuite.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Contraintes avant ouverture', $id );
	tfp_seed_set_field( 'detail_1_texte', 'Un passage avant ouverture se joue sur un créneau court et non extensible : tout ce qui n\'est pas fait avant l\'arrivée du premier client ne peut pas être rattrapé dans la journée. Nous priorisons donc explicitement dans le cahier des charges — sols, vitrine, caisse et sanitaires clients d\'abord — et plaçons en second rang ce qui peut attendre le passage suivant : rayonnages hauts, réserves, plinthes.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'Sols fragiles et revêtements d\'agencement', $id );
	tfp_seed_set_field( 'detail_2_texte', 'Les commerces concentrent des revêtements sensibles : parquet huilé, béton ciré, résine coulée, marbre, pierre naturelle, sol vinyle imprimé. Chacun demande un produit et un dosage d\'eau adaptés, sous peine de traces durables ou de perte de brillance. Nous relevons la nature exacte des sols au moment du cahier des charges et appliquons les préconisations de votre agenceur, avec les produits que vous fournissez.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Vitrines et surfaces vitrées', $id );
	tfp_seed_set_field( 'detail_3_texte', 'Les vitrines sont incluses uniquement lorsqu\'elles sont accessibles sans équipement spécialisé et prévues au devis : vitrage de plain-pied, porte d\'entrée, vitrophanie, séparations intérieures. Tout ce qui exige une nacelle, une perche télescopique, un échafaudage ou un travail en hauteur est exclu de la prestation courante et relève d\'un prestataire équipé pour cela.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Espaces de vente et rayonnages', $id );
	tfp_seed_set_field( 'detail_4_texte', 'La surface de vente se traite par zones : sols et circulations à chaque passage, mobilier de présentation et têtes de gondole en dépoussiérage régulier, rayonnages hauts et éclairages selon une fréquence plus espacée. Nous ne déplaçons pas la marchandise et ne remettons pas les articles en place : le facing reste votre travail, le nettoyage le nôtre.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Zone de caisse', $id );
	tfp_seed_set_field( 'detail_5_texte', 'La caisse est le point le plus touché de la boutique et le plus visible au moment du paiement : comptoir, terminal, écran, poignées de tiroir, tapis de sol, corbeille. Elle est traitée à chaque passage. Les espèces, les documents et les objets clients ne sont jamais manipulés ni déplacés, et rien n\'est rangé dans les tiroirs.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Réserves et arrière-boutique', $id );
	tfp_seed_set_field( 'detail_6_texte', 'Les réserves sont traitées lorsqu\'elles sont dégagées : sol, poubelles, surfaces libres, coin repos ou vestiaire du personnel. Les stocks, cartons et racks ne sont pas déplacés. Une réserve durablement encombrée est signalée dans le cahier de liaison, afin que la question soit tranchée avec vous plutôt que contournée en silence à chaque passage.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Cabines d\'essayage', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Pour un commerce d\'habillement, les cabines concentrent l\'essentiel de l\'impression de propreté : sol, miroir, banquette ou tabouret, patères, rideau ou porte, plinthes. Les articles et cintres oubliés par la clientèle sont rassemblés à un endroit convenu avec vous plutôt que remis en rayon, pour éviter toute confusion avec le stock.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Adaptation saisonnière', $id );
	tfp_seed_set_field( 'detail_8_texte', 'La charge d\'un commerce n\'est pas linéaire sur l\'année. Nous prévoyons dès le devis les périodes susceptibles de demander un renfort — soldes, fêtes, saison touristique, rentrée — et la façon de l\'activer : passage supplémentaire ponctuel, allongement temporaire de la durée de passage, ou intervention ponctuelle de remise à niveau avant une réouverture ou un changement d\'agencement.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour une boutique de centre-ville ouverte du mardi au samedi, le cahier des charges type prévoit : sols lavés chaque matin avant ouverture, vitrine et porte d\'entrée nettoyées quotidiennement, cabines d\'essayage et miroirs vérifiés, sanitaires clients désinfectés, rayonnages dépoussiérés une fois par semaine, avec un renfort le samedi si l\'affluence le justifie.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits adaptés aux sols de la boutique (parquet, carrelage, résine) et aux vitrines sont généralement fournis par vos soins, pour respecter les préconisations de votre agencement. Nous signalons tout consommable à renouveler (produits vitres, sacs, papier sanitaire) via le cahier de liaison.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès au commerce est organisé selon votre rythme : remise de clés pour une intervention avant l\'ouverture, ou passage en votre présence si vous préférez. Le code d\'alarme et les consignes de fermeture sont consignés et transmis uniquement aux intervenants concernés par votre point de vente.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'Nous sélectionnons un intervenant habitué aux contraintes du commerce : rapidité d\'exécution avant l\'ouverture, soin apporté aux surfaces visibles par la clientèle (vitrine, sol, caisse). Nous privilégions autant que possible un intervenant habituel, qui finit par connaître l\'agencement de votre boutique et vos temps forts, sans que cette continuité puisse être garantie de façon absolue.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Un cahier de liaison reste sur place pour signaler toute anomalie constatée (vitrine fissurée, produit manquant) et tracer les passages. Audrey reste votre interlocutrice pour ajuster la fréquence selon la saison ou les temps forts commerciaux (soldes, fêtes).', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'En cas d\'absence de l\'intervenant habituel, nous recherchons une solution de remplacement en priorité pour les commerces, où une vitrine ou un sol négligé se remarque immédiatement. Vous êtes informé de l\'organisation retenue ; aucun remplacement immédiat n\'est pour autant garanti dans tous les cas de figure.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Semaine type pour une boutique ouverte du mardi au samedi, passage quotidien de 7 h 30 à 8 h 45 : chaque matin, sols de la surface de vente, vitrine et porte d\'entrée, zone de caisse, sanitaires clients et corbeilles. Le mercredi s\'ajoutent les cabines d\'essayage et les miroirs en détail ; le vendredi, le dépoussiérage des rayonnages et du mobilier de présentation ; le samedi, un passage resserré sur les sols et la vitrine avant une journée de forte affluence.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Sont exclues de la prestation courante : les vitrines et enseignes en hauteur nécessitant un équipement spécialisé, la manipulation ou le rangement de la marchandise, le facing, la désinfection réglementée en environnement agroalimentaire, et l\'entretien des réserves durablement encombrées. Ces points peuvent être chiffrés séparément ou confiés à un prestataire spécialisé.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'La boutique est prête avant l\'ouverture, y compris les jours de marché où nous ouvrons plus tôt. Les vitrines prévues au devis sont faites, et ce qui ne l\'est pas nous a été dit clairement dès le départ.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Sarah B.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Commerçante', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Dole', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Commerces', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Pouvez-vous intervenir avant l\'ouverture, très tôt le matin ?', 'reponse' => 'Oui, c\'est le cas le plus fréquent pour les commerces : nous nous calons sur votre heure d\'ouverture réelle.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Un passage supplémentaire est-il possible un jour de forte affluence ?', 'reponse' => 'Oui, sur devis complémentaire, par exemple avant un week-end de soldes ou un marché.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Les vitrines extérieures sont-elles comprises ?', 'reponse' => 'Les vitrines sont incluses uniquement lorsqu\'elles sont accessibles sans équipement spécialisé et prévues au devis. Les vitrines en hauteur, les enseignes et les surfaces nécessitant une nacelle ou une perche télescopique sont exclues de la prestation courante.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Comment adaptez-vous la prestation aux sols fragiles ?', 'reponse' => 'Parquet huilé, béton ciré, résine, marbre ou pierre naturelle ne supportent pas les mêmes produits ni les mêmes quantités d\'eau. Nous relevons la nature exacte de vos revêtements au moment du cahier des charges et appliquons les préconisations de votre agenceur ou de votre fournisseur, avec les produits que vous mettez à disposition.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Que faites-vous des réserves et de l\'arrière-boutique ?', 'reponse' => 'Les réserves sont traitées lorsqu\'elles sont dégagées et accessibles : sol, poubelles et surfaces libres. Nous ne déplaçons pas les stocks, les cartons ni le mobilier de rangement, et les zones encombrées sont signalées dans le cahier de liaison plutôt que contournées silencieusement.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Les cabines d\'essayage sont-elles comprises ?', 'reponse' => 'Oui : sol, miroir, banquette ou tabouret, patères et rideau ou porte. Le linge, les cintres et les articles oubliés par la clientèle ne sont pas rangés mais rassemblés à un endroit convenu avec vous, afin que rien ne disparaisse.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Adaptez-vous la fréquence selon la saison ?', 'reponse' => 'Oui, c\'est fréquent dans le commerce : soldes, fêtes de fin d\'année, période estivale ou marché hebdomadaire modifient nettement la fréquentation. Un renfort temporaire ou un passage supplémentaire peut être prévu par avenant au devis, puis retiré lorsque la période s\'achève.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Commerces', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ commerces\n";
}

/* ---------------- cabinets ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'cabinets', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation cabinets absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Cabinets & professions libérales', $id );
	tfp_seed_set_field( 'label_court', 'Cabinets', $id );
	tfp_seed_set_field( 'h1', 'Nettoyage de cabinets et de professions libérales', $id );
	tfp_seed_set_field( 'tease', 'L\'entretien courant des cabinets médicaux, paramédicaux, juridiques et de conseil : accueil, salle d\'attente, bureaux, sanitaires et sols, en dehors des heures de consultation et dans le respect de la confidentialité.', $id );
	tfp_seed_set_field( 'hero_alt', 'Nettoyage de cabinets et de professions libérales', $id );
	tfp_seed_set_field( 'reponse_directe', 'Un cabinet reçoit du public toute la journée : la salle d\'attente, les sanitaires et les sols se salissent vite et se remarquent immédiatement. Notre prestation est un entretien courant de locaux professionnels recevant du public, organisé en dehors des heures de consultation. Elle ne comprend aucun protocole médical : le bio-nettoyage hospitalier, la stérilisation, la gestion des DASRI et l\'entretien du matériel de soin relèvent de prestataires spécialisés et de vos propres protocoles.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'Cabinets médicaux et paramédicaux',
		'Cabinets dentaires',
		'Avocats, notaires, experts-comptables',
		'Conseil et architecture',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Accueil, banque d\'accueil et circulations',
		'Salle d\'attente : sièges, tables, surfaces de contact courantes',
		'Bureaux de consultation : entretien courant du mobilier',
		'Sanitaires et points d\'eau',
		'Sols de l\'ensemble des locaux',
		'Mobilier courant et vitrages intérieurs accessibles',
		'Corbeilles et points de collecte courants',
		'Confidentialité : consignes strictes de non-manipulation des documents',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', '', $id );
	tfp_seed_set_field( 'exclusions_titre', 'Ce que Top-Famille Pro ne réalise pas', $id );
	tfp_seed_set_field( 'exclusions_intro', 'Pour éviter toute ambiguïté, voici ce qui ne fait pas partie de cette prestation. Ces points relèvent de prestataires spécialisés ou de vos propres protocoles, et ne peuvent pas être ajoutés au devis.', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(
		'Bio-nettoyage hospitalier',
		'Stérilisation d\'instruments ou de matériel',
		'Gestion, manipulation ou évacuation des DASRI',
		'Blocs opératoires et salles d\'intervention',
		'Protocoles médicaux spécialisés et désinfection réglementée',
		'Entretien du matériel médical et des surfaces de soin',
	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Une salle d\'attente très fréquentée concentre les surfaces de contact courantes — poignées, accoudoirs, comptoir d\'accueil — et se dégrade visiblement en une seule journée de forte affluence.',
		'La confidentialité des dossiers et des échanges impose un cadre d\'intervention strict : passage en dehors des heures de consultation, aucune manipulation de document, zones d\'accès délimitées au cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple pour un cabinet de groupe : passage quotidien en fin de journée, après le départ du dernier patient — salle d\'attente, sanitaires, sols, bureaux de consultation en entretien courant, comptoir d\'accueil et poignées.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Cabinet individuel', $id );
	tfp_seed_set_field( 'config_1_texte', 'Un praticien seul, une salle d\'attente et un sanitaire : deux à trois passages par semaine suffisent généralement, en fin de journée. La charge se concentre sur les sols, le sanitaire et la salle d\'attente. Le volume mensuel se situe souvent entre 6 et 12 heures selon la surface et le nombre de patients reçus.', $id );
	tfp_seed_set_field( 'config_2_titre', 'Cabinet de groupe', $id );
	tfp_seed_set_field( 'config_2_texte', 'Plusieurs praticiens partagent l\'accueil, la salle d\'attente et les sanitaires : ces espaces communs concentrent l\'essentiel du passage et justifient le plus souvent un passage quotidien en fin de journée, avec un découpage clair entre ce qui est repris chaque jour et ce qui l\'est une fois par semaine.', $id );
	tfp_seed_set_field( 'config_3_titre', 'Cabinet juridique ou de conseil', $id );
	tfp_seed_set_field( 'config_3_texte', 'Chez un avocat, un notaire ou un expert-comptable, la contrainte dominante n\'est pas la fréquentation mais la confidentialité : dossiers empilés, salles de réunion, archives. Le cahier des charges y délimite précisément les zones accessibles et rappelle qu\'aucun document n\'est déplacé, même pour nettoyer la surface qui le supporte.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Accueil et banque d\'accueil', $id );
	tfp_seed_set_field( 'detail_1_texte', 'L\'accueil est la première image du cabinet et l\'un des points les plus touchés : comptoir, façade de banque d\'accueil, terminal de paiement, poignées, interrupteurs, corbeille. Il est traité à chaque passage. Les documents, agendas, dossiers et objets présents sur le comptoir ne sont jamais déplacés : la surface est reprise autour d\'eux.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'Salle d\'attente', $id );
	tfp_seed_set_field( 'detail_2_texte', 'La salle d\'attente concentre les sièges, les tables basses, les accoudoirs, les portes et parfois un distributeur d\'eau ou un porte-manteau. À chaque passage : sols, surfaces de contact courantes, corbeille, remise en ordre du mobilier. Les revues et documents sont rassemblés proprement, jamais triés ni jetés sans consigne écrite de votre part.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Bureaux et salles de consultation', $id );
	tfp_seed_set_field( 'detail_3_texte', 'Les bureaux de consultation font l\'objet d\'un entretien courant : sol, bureau, mobilier, poignées, corbeille, vitrage intérieur accessible. Tout ce qui touche au soin lui-même — fauteuil d\'examen, paillasse technique, instruments, matériel médical — est exclu du périmètre et reste traité par le praticien selon ses propres protocoles.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Sanitaires et points d\'eau', $id );
	tfp_seed_set_field( 'detail_4_texte', 'Les sanitaires d\'un cabinet recevant du public sont sollicités toute la journée et sont le premier motif de remarque des patients. Ils sont nettoyés à chaque passage, avec réapprovisionnement du savon, du papier et des sacs lorsque vous fournissez ces consommables, et signalement de tout dysfonctionnement dans le cahier de liaison.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Sols et mobilier courant', $id );
	tfp_seed_set_field( 'detail_5_texte', 'Les sols représentent souvent la moitié du temps d\'intervention : circulations, salle d\'attente, bureaux, sanitaires, avec des revêtements parfois différents d\'une pièce à l\'autre. Le mobilier courant — chaises, tables, étagères ouvertes, plinthes, portes — suit une rotation définie au cahier des charges plutôt qu\'un traitement intégral à chaque passage.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Surfaces de contact courantes', $id );
	tfp_seed_set_field( 'detail_6_texte', 'Poignées de porte, interrupteurs, rampes, boutons d\'ascenseur, dossiers de siège, comptoir : ce sont les surfaces les plus touchées et les plus rapides à traiter. Elles sont reprises à chaque passage avec les produits d\'entretien courants mis à disposition, sans que cela constitue une désinfection médicale ni un protocole sanitaire réglementé.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Confidentialité', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Un cabinet contient des informations protégées : dossiers patients, correspondances, échanges enregistrés, écrans. La règle transmise à l\'intervenant est simple et sans exception : aucun document n\'est ouvert, déplacé ni trié ; les corbeilles contenant des papiers sont traitées selon la consigne que vous fixez ; les zones dont l\'accès est réservé sont identifiées par écrit avant le premier passage.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Horaires hors consultation', $id );
	tfp_seed_set_field( 'detail_8_texte', 'L\'intervention a lieu avant l\'ouverture ou après le départ du dernier patient, jamais entre deux consultations. Cela suppose de connaître vos horaires réels — y compris les jours à consultation tardive — et d\'organiser l\'accès et l\'alarme en conséquence. Lorsque plusieurs praticiens ont des horaires différents, le créneau est calé sur le plus tardif d\'entre eux.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour un cabinet de groupe, le cahier des charges type prévoit : salle d\'attente reprise à chaque passage (sièges, tables, revues rassemblées sans être triées, surfaces de contact courantes), comptoir d\'accueil essuyé, sanitaires nettoyés et réapprovisionnés à chaque passage, sols lavés selon la fréquentation, bureaux de consultation en entretien courant après le départ du dernier patient, et vitrages intérieurs accessibles traités une fois par semaine. Les zones réservées et les surfaces liées au soin sont explicitement exclues du périmètre.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits d\'entretien courants et le matériel sont généralement fournis par le cabinet, ce qui garantit l\'usage de références que vous avez vous-même validées. Nous n\'introduisons aucun produit à visée médicale et n\'appliquons rien sur des surfaces liées au soin. Les consommables courants à renouveler (savon, papier, sacs) sont signalés dans le cahier de liaison ; les consommables médicaux ne relèvent pas de notre périmètre.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès au cabinet est organisé en dehors des heures de consultation : remise de clés, code d\'alarme ou badge, avec un protocole strict de fermeture et de réactivation de l\'alarme, transmis uniquement aux intervenants concernés par votre cabinet.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'L\'intervenant qui entretient un cabinet médical ou libéral est sélectionné avec une attention particulière portée à la discrétion et au respect de la confidentialité des dossiers et des échanges, en plus de sa fiabilité générale.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Un cahier de liaison reste sur place pour tracer les passages et signaler toute anomalie constatée : stock de savon ou de papier bas, sanitaire défectueux, siège de salle d\'attente abîmé, zone non traitée parce qu\'occupée. Audrey suit la prestation dans la durée et reste votre interlocutrice pour ajuster la fréquence ou le périmètre.', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'En cas d\'absence de l\'intervenant habituel, nous recherchons activement une solution de remplacement, l\'entretien d\'un espace recevant du public se voyant très vite. Vous êtes informé de l\'organisation retenue et de son délai ; aucun remplacement immédiat ne peut être garanti dans tous les cas.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Semaine type pour un cabinet de groupe recevant du public du lundi au vendredi, passage quotidien à partir de 19 h 30 : chaque soir, salle d\'attente, accueil, sanitaires, surfaces de contact courantes, corbeilles et sols des circulations. Le mardi s\'ajoutent les bureaux de consultation en entretien courant ; le jeudi, les vitrages intérieurs accessibles et le mobilier de la salle d\'attente en détail ; le vendredi, un lavage complet des sols de l\'ensemble des locaux avant le week-end.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Notre périmètre est celui de l\'entretien courant des locaux. Nous n\'intervenons pas sur le matériel de soin, ne manipulons aucun déchet d\'activité de soins, n\'appliquons aucun protocole médical et ne remplaçons pas les gestes d\'hygiène propres à votre pratique. Nous ne déplaçons ni ne trions aucun document, et nous n\'entrons pas dans les zones dont l\'accès est réservé sans accompagnement.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Ce qui nous a rassurés, c\'est que le périmètre a été dit clairement : l\'entretien des locaux, pas nos protocoles de soin. Le passage se fait après le dernier patient et aucun dossier n\'est jamais bougé.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Thomas L.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Responsable de cabinet', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Besançon', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Cabinets', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous entre deux patients ?', 'reponse' => 'Non. Notre passage a lieu en dehors des heures de consultation, en début ou en fin de journée. Ce qui se fait entre deux patients relève entièrement du protocole du praticien et de son équipe, avec ses propres produits et ses propres règles.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Traitez-vous les déchets médicaux ?', 'reponse' => 'Non. Les déchets d\'activité de soins à risques infectieux (DASRI) ne sont ni manipulés ni évacués par nos intervenants. Nous gérons uniquement les corbeilles et points de collecte courants, à l\'exclusion de tout contenant dédié aux déchets de soins.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'L\'intervenant est-il informé des règles de confidentialité ?', 'reponse' => 'Oui. Les consignes de confidentialité figurent au cahier des charges : aucun document n\'est déplacé, ouvert ou trié, les dossiers laissés sur un bureau sont contournés, et les zones dont l\'accès est réservé sont identifiées par écrit avant le premier passage.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Faites-vous du bio-nettoyage ou de la désinfection médicale ?', 'reponse' => 'Non. Notre prestation est un entretien courant de locaux. Le bio-nettoyage hospitalier, la stérilisation, la désinfection réglementée de salle d\'intervention et tout protocole médical spécialisé sortent de notre périmètre et relèvent de prestataires spécialisés.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Nettoyez-vous le matériel de soin et les fauteuils d\'examen ?', 'reponse' => 'Non. Le matériel médical, les instruments et les surfaces directement liées au soin restent sous la responsabilité du praticien et de ses protocoles. Nous intervenons sur le mobilier courant, les sols, les sanitaires et les surfaces de contact courantes.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'À quelle fréquence faut-il faire nettoyer un cabinet ?', 'reponse' => 'Cela dépend du nombre de praticiens, du nombre de patients reçus par jour et de la présence d\'une salle d\'attente commune. Un cabinet individuel se satisfait souvent de deux à trois passages par semaine ; un cabinet de groupe recevant du public en continu justifie généralement un passage quotidien en fin de journée.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Comment se passe l\'accès en dehors des heures d\'ouverture ?', 'reponse' => 'Les modalités sont définies avec vous et consignées par écrit : remise de clés, badge ou code, protocole de fermeture et de réactivation de l\'alarme. Elles ne sont transmises qu\'aux intervenants concernés par votre cabinet.' ), $id );
	tfp_seed_set_field( 'faq_8', array( 'question' => 'Le même intervenant vient-il à chaque passage ?', 'reponse' => 'C\'est l\'organisation que nous recherchons, parce qu\'un cabinet impose des repères précis. Cette continuité est privilégiée autant que possible, mais ne constitue pas une garantie absolue : en cas d\'absence, nous recherchons activement une solution et vous informons de l\'organisation retenue.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Cabinets', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ cabinets\n";
}

/* ---------------- coproprietes ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'coproprietes', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation coproprietes absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Copropriétés & parties communes', $id );
	tfp_seed_set_field( 'label_court', 'Copropriétés', $id );
	tfp_seed_set_field( 'h1', 'Entretien de copropriétés et de parties communes', $id );
	tfp_seed_set_field( 'tease', 'L\'entretien régulier des halls, cages d\'escalier, ascenseurs et locaux communs, pour des résidences et immeubles tertiaires soignés au quotidien.', $id );
	tfp_seed_set_field( 'hero_alt', 'Entretien de copropriétés et de parties communes', $id );
	tfp_seed_set_field( 'reponse_directe', 'Nous travaillons avec les syndics, gestionnaires et propriétaires pour l\'entretien des parties communes, planifié selon une fréquence définie et suivi via un cahier de liaison.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'Syndics de copropriété',
		'Gestionnaires d\'immeubles',
		'Bailleurs et propriétaires',
		'Résidences tertiaires',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Halls et entrées',
		'Cages d\'escalier, rampes et paliers',
		'Ascenseurs : cabine, portes, miroir',
		'Local poubelles et sortie des conteneurs : possibles lorsqu\'ils sont prévus et chiffrés dans le devis',
		'Vitrages des parties communes accessibles sans équipement spécialisé',
		'Local vélos et parkings couverts',
		'Boîtes aux lettres et surfaces de contact courantes',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', '', $id );
	tfp_seed_set_field( 'exclusions_titre', '', $id );
	tfp_seed_set_field( 'exclusions_intro', '', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(

	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Des halls et cages d\'escalier négligés sont souvent la première source de réclamation en copropriété.',
		'La sortie et la rentrée des conteneurs aux jours de collecte demandent une organisation précise avec le syndic : elles sont possibles lorsqu\'elles sont prévues et chiffrées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple pour une résidence de 40 lots : passage hebdomadaire — hall, escaliers, ascenseur, boîtes aux lettres et surfaces de contact ; sortie et rentrée des conteneurs les jours de collecte lorsqu\'elles sont prévues et chiffrées dans le devis.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Petite copropriété (moins de 15 lots)', $id );
	tfp_seed_set_field( 'config_1_texte', 'Un hall, une cage d\'escalier, parfois un local poubelles : un passage hebdomadaire d\'une à deux heures couvre généralement le besoin, voire un passage tous les quinze jours pour un immeuble peu fréquenté. Le budget étant serré, le cahier des charges y est volontairement resserré sur l\'essentiel : sols, hall, boîtes aux lettres.', $id );
	tfp_seed_set_field( 'config_2_titre', 'Résidence de taille moyenne (15 à 60 lots)', $id );
	tfp_seed_set_field( 'config_2_texte', 'Plusieurs cages, un ascenseur, un local poubelles et souvent un parking couvert. Un passage hebdomadaire est le rythme le plus courant, avec une rotation des tâches : sols et hall à chaque fois, vitrages accessibles et paliers hauts selon un cycle défini. C\'est le format où la sortie des conteneurs est le plus souvent demandée.', $id );
	tfp_seed_set_field( 'config_3_titre', 'Immeuble de standing ou résidence tertiaire', $id );
	tfp_seed_set_field( 'config_3_texte', 'Hall traversant, sols en pierre ou marbre, vitrages importants, forte circulation : deux passages par semaine sont fréquents, avec une attention particulière portée aux surfaces visibles depuis l\'entrée. Le cahier des charges y détaille davantage les revêtements et les produits autorisés, sur préconisation du syndic.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Relation avec le syndic', $id );
	tfp_seed_set_field( 'detail_1_texte', 'Notre interlocuteur est le syndic ou le conseil syndical, pas les résidents individuellement. C\'est lui qui arbitre le périmètre, la fréquence et le budget, valide le cahier des charges et tranche les demandes d\'évolution. Cette clarté évite la situation classique où chaque copropriétaire ajoute sa demande à l\'intervenant, jusqu\'à ce que le temps prévu ne corresponde plus au travail attendu.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'Validation du cahier des charges', $id );
	tfp_seed_set_field( 'detail_2_texte', 'Le cahier des charges est écrit avant le premier passage et validé par le syndic : liste des espaces, tâches par espace, fréquence, jour et créneau de passage, accès, et traitement explicite des points sensibles (conteneurs, local poubelles, vitrages). Toute évolution passe par un devis actualisé, soumis au même circuit de validation, plutôt que par un accord verbal sur place.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Halls et entrées', $id );
	tfp_seed_set_field( 'detail_3_texte', 'Le hall est la carte de visite de l\'immeuble : sol, tapis de propreté, boîtes aux lettres, interphone, poignées, vitrage de la porte d\'entrée, éclairage accessible. Il est traité à chaque passage. Les prospectus et courriers non distribués sont rassemblés à l\'endroit convenu avec le syndic, jamais jetés sans consigne écrite.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Escaliers et paliers', $id );
	tfp_seed_set_field( 'detail_4_texte', 'Les escaliers sont la tâche la plus chronophage d\'une copropriété. Selon la fréquence retenue, tous les niveaux sont traités à chaque passage, ou bien les niveaux bas — les plus fréquentés — le sont chaque semaine et les niveaux hauts en alternance. Rampes, mains courantes, plinthes et paliers font partie du périmètre, ainsi que les portes palières côté commun.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Ascenseurs', $id );
	tfp_seed_set_field( 'detail_5_texte', 'La cabine d\'ascenseur est un espace clos très touché : sol, parois, miroir, boutons d\'appel et de cabine, seuils de porte à chaque niveau. Elle est reprise à chaque passage. Nous n\'intervenons ni sur la machinerie ni dans la gaine technique, et tout dysfonctionnement constaté est signalé au syndic via le cahier de liaison.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Vitres accessibles', $id );
	tfp_seed_set_field( 'detail_6_texte', 'Les vitrages des parties communes sont traités lorsqu\'ils sont accessibles sans équipement spécialisé : porte d\'entrée, hublots de palier, vitrage de hall de plain-pied, imposte atteignable depuis le sol. Verrières, cages vitrées en hauteur et façades vitrées sont exclues et relèvent d\'un prestataire équipé pour le travail en hauteur.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Local poubelles et conteneurs', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Le nettoyage du local poubelles et la sortie ou la rentrée des conteneurs sont possibles lorsqu\'ils sont prévus et chiffrés dans le devis. Ce ne sont pas des tâches incluses par défaut : elles imposent des passages à jour et heure fixes, calés sur le calendrier de collecte de la commune, et donc un temps d\'intervention supplémentaire qui doit être budgété.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Remarques des résidents', $id );
	tfp_seed_set_field( 'detail_8_texte', 'Un résident croise nécessairement l\'intervenant et lui adresse parfois une demande. La règle est claire : la remarque est écoutée et notée dans le cahier de liaison, mais l\'intervenant ne s\'engage sur rien et ne modifie pas son périmètre de sa propre initiative. Audrey relaie ensuite au syndic, qui décide s\'il y a lieu d\'ajuster le cahier des charges.', $id );
	tfp_seed_set_field( 'detail_9_titre', 'Organisation des passages et gestion des clés', $id );
	tfp_seed_set_field( 'detail_9_texte', 'Le jour et le créneau de passage sont fixés avec le syndic, ce qui permet aux résidents de savoir quand l\'entretien a lieu — un point qui réduit sensiblement les réclamations. Les accès (clés, badge, code, local technique) sont listés par écrit dans le cahier des charges, remis contre décharge et transmis uniquement aux intervenants concernés par la résidence.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour une résidence de 40 lots, le cahier des charges type prévoit : hall et boîtes aux lettres dépoussiérés à chaque passage, cage d\'escalier et rampes lavées une fois par semaine, ascenseur nettoyé et vitré, sortie et rentrée des conteneurs les jours de collecte lorsqu\'elles sont prévues et chiffrées dans le devis, vitrages accessibles des parties communes traités une fois par mois.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits et le matériel d\'entretien des parties communes sont généralement fournis ou budgétés par la copropriété, selon les modalités validées en assemblée générale. Nous signalons au syndic tout consommable ou équipement à renouveler via le cahier de liaison.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès aux parties communes se fait via un jeu de clés ou un badge confié par le syndic, avec accès au local technique et au local poubelles si nécessaire. Ces modalités sont consignées par écrit et transmises uniquement aux intervenants concernés par la résidence.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'Nous sélectionnons un intervenant habitué à travailler en copropriété, capable d\'échanger ponctuellement avec des résidents et de respecter les horaires de passage validés par le conseil syndical, en particulier lorsque la sortie des conteneurs est prévue et chiffrée dans le devis.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Le cahier de liaison, consultable par les résidents et le syndic, trace chaque passage et permet de signaler une remarque (poignée cassée, ampoule grillée) qu\'Audrey relaie si besoin. C\'est un outil de transparence apprécié lors des conseils syndicaux.', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'En cas d\'absence de l\'intervenant habituel, nous recherchons activement une solution de remplacement et informons le syndic de l\'organisation retenue. La priorité porte sur le hall et, lorsqu\'elle est prévue au devis, sur la sortie des conteneurs, dont le report se voit immédiatement. Aucun remplacement immédiat ne peut toutefois être garanti dans tous les cas.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Semaine type pour une résidence de 40 lots avec deux cages et un ascenseur, passage le mercredi de 8 h à 11 h : hall, tapis de propreté, boîtes aux lettres et interphone ; cabine d\'ascenseur et seuils de porte ; escaliers et paliers des deux cages, rampes comprises ; local vélos et accès parking couvert. Le premier mercredi du mois s\'ajoutent les vitrages accessibles et les portes palières. Lorsque la sortie des conteneurs est prévue au devis, elle fait l\'objet de deux passages courts supplémentaires, la veille au soir et le matin de la collecte.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Sont exclus de la prestation : la désinsectisation, la dératisation, l\'entretien des espaces verts, le déneigement, les vitrages en hauteur nécessitant un équipement spécialisé, la machinerie d\'ascenseur et les gaines techniques. Le local poubelles et la sortie des conteneurs sont possibles lorsqu\'ils sont prévus et chiffrés dans le devis. Nous n\'effectuons aucune petite réparation ni changement d\'ampoule sauf mention expresse au cahier des charges.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le cahier des charges a été validé en conseil syndical, et le cahier de liaison dans le hall a fait baisser les réclamations. Les conteneurs sont sortis parce que nous l\'avons prévu au devis, c\'était clair dès le départ.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Nadia M.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Gestionnaire de copropriété', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Copropriétés', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Travaillez-vous directement avec le syndic ou avec les copropriétaires ?', 'reponse' => 'Le plus souvent avec le syndic ou le conseil syndical, qui valide le cahier des charges et reste notre interlocuteur pour le suivi.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'La sortie des conteneurs est-elle comprise ?', 'reponse' => 'Elle est possible lorsqu\'elle est prévue et chiffrée dans le devis, selon les jours de collecte de la commune. Ce n\'est pas une tâche incluse par défaut : elle impose un passage supplémentaire à jour et heure fixes, qui doit donc être budgété explicitement.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Un cahier de liaison est-il laissé dans les parties communes ?', 'reponse' => 'Oui. Il est placé à un endroit convenu avec le syndic — souvent le hall ou le local technique — et permet de suivre les passages, de noter ce qui n\'a pas pu être fait et de recueillir une remarque de résident sans passer par un échange téléphonique.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Comment le cahier des charges est-il validé ?', 'reponse' => 'Il est établi avec le syndic ou le conseil syndical, qui arbitre le périmètre et la fréquence en fonction du budget voté. Toute modification ultérieure — ajout d\'un passage, prise en charge des conteneurs, traitement du local vélos — passe par un devis actualisé soumis au même circuit de validation.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Les vitres des parties communes sont-elles comprises ?', 'reponse' => 'Les vitrages accessibles sans équipement spécialisé sont inclus : portes d\'entrée, hublots de palier, vitrage de hall de plain-pied. Les verrières, cages vitrées en hauteur et façades nécessitant une nacelle ou un échafaudage sont exclues et relèvent d\'un prestataire équipé.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Que se passe-t-il si un résident fait une remarque à l\'intervenant ?', 'reponse' => 'L\'intervenant l\'écoute, la note dans le cahier de liaison et ne s\'engage sur rien : le périmètre de la prestation est fixé par le syndic, pas par les demandes individuelles. Audrey relaie ensuite la remarque au gestionnaire, qui décide de la suite.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'À quelle fréquence faut-il entretenir des parties communes ?', 'reponse' => 'Un passage hebdomadaire est le rythme le plus courant pour une résidence de taille moyenne. Un immeuble de standing, une résidence avec ascenseur très utilisé ou un hall donnant directement sur la rue justifient souvent deux passages ; une petite copropriété de quelques lots peut se satisfaire d\'un passage tous les quinze jours.' ), $id );
	tfp_seed_set_field( 'faq_8', array( 'question' => 'Comment sont gérées les clés de l\'immeuble ?', 'reponse' => 'Un jeu de clés ou un badge est confié par le syndic, avec la liste précise des accès concernés (hall, local technique, local poubelles, parking). Ces éléments sont consignés par écrit et ne sont transmis qu\'aux intervenants concernés par la résidence.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Copropriétés', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ coproprietes\n";
}

/* ---------------- meubles ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'meubles', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation meubles absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Locations meublées & hébergements', $id );
	tfp_seed_set_field( 'label_court', 'Locations meublées', $id );
	tfp_seed_set_field( 'h1', 'Nettoyage de locations meublées et d\'hébergements', $id );
	tfp_seed_set_field( 'tease', 'La remise en état de vos meublés et hébergements professionnels entre deux occupants, avec un contrôle visuel et un signalement des anomalies selon l\'organisation définie avec le client.', $id );
	tfp_seed_set_field( 'hero_alt', 'Nettoyage de locations meublées et d\'hébergements', $id );
	tfp_seed_set_field( 'reponse_directe', 'Pour les locations meublées et les hébergements, tout se joue sur le créneau disponible entre un départ et une arrivée. Nous organisons l\'intervention sur ce créneau, avec un contrôle visuel et un signalement des anomalies selon l\'organisation définie avec le client. Nous ne sommes pas une conciergerie : nous n\'accueillons pas les voyageurs, ne gérons pas les réservations et ne lavons pas le linge.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'Propriétaires de meublés',
		'Gestionnaires courte durée',
		'Résidences et hébergements pro',
		'Conciergeries',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Remise en état complète entre deux occupants',
		'Change du linge propre fourni par le client (sans lavage)',
		'Cuisine et extérieur de l\'électroménager',
		'Salle de bain et sanitaires',
		'Sols et surfaces',
		'Literie refaite et poubelles évacuées',
		'Contrôle visuel et signalement des anomalies selon l\'organisation définie avec le client',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', 'Hors prestation : lavage du linge (nous changeons le linge propre fourni par le client, nous ne le lavons pas), petites réparations, accueil et remise de clés aux voyageurs, gestion des réservations, réapprovisionnement acheté par nos soins.', $id );
	tfp_seed_set_field( 'exclusions_titre', '', $id );
	tfp_seed_set_field( 'exclusions_intro', '', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(

	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Entre deux réservations, le délai est parfois très court : l\'organisation des clés et la réactivité de l\'intervenant sont déterminantes.',
		'Une anomalie non repérée — casse, équipement en panne, consommable épuisé — se retourne contre vous à l\'arrivée du voyageur suivant : c\'est pourquoi les modalités de contrôle et de signalement sont définies à l\'avance avec vous.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple pour un meublé avec rotation hebdomadaire : intervention le jour du départ, entre 11 h et 15 h, avec contrôle visuel en fin de passage et signalement des anomalies selon l\'organisation définie avec vous.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Rotation courte, départ et arrivée le même jour', $id );
	tfp_seed_set_field( 'config_1_texte', 'C\'est le cas le plus tendu : le voyageur part à 10 h ou 11 h, le suivant arrive à 15 h ou 16 h. Le créneau réel est de trois à quatre heures, sans marge. Nous calons l\'intervention dès l\'ouverture du créneau et convenons à l\'avance de ce qui serait sacrifié en cas d\'imprévu, plutôt que de le découvrir sur place.', $id );
	tfp_seed_set_field( 'config_2_titre', 'Rotation hebdomadaire', $id );
	tfp_seed_set_field( 'config_2_texte', 'Avec une arrivée et un départ à jour fixe, l\'organisation est nettement plus confortable : le passage est programmé à l\'avance, la même personne peut être positionnée d\'une semaine à l\'autre, et un entretien plus poussé peut être intégré par rotation (intérieur du four, détartrage, plinthes, vitres accessibles).', $id );
	tfp_seed_set_field( 'config_3_titre', 'Logement entre deux périodes de location', $id );
	tfp_seed_set_field( 'config_3_texte', 'Avant une réouverture saisonnière ou après une longue vacance, la remise en état est plus lourde qu\'un simple change entre deux occupants : poussière déposée, textiles à aérer, réfrigérateur à reprendre, sanitaires à détartrer. Cette intervention relève alors d\'un nettoyage ponctuel chiffré sur devis, distinct du forfait de rotation.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Organisation entre deux occupants', $id );
	tfp_seed_set_field( 'detail_1_texte', 'Tout part du calendrier : heure de départ, heure d\'arrivée, temps de trajet, et donc créneau réellement exploitable. Nous convenons avec vous d\'un ordre de priorité — salle de bain, cuisine, literie, sols, puis finitions — de sorte qu\'un imprévu réduise le périmètre de la fin plutôt que de compromettre l\'essentiel. Les changements de dernière minute sont fréquents dans ce métier : ils passent par Audrey, qui vous dit franchement ce qui reste tenable.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'Délai disponible', $id );
	tfp_seed_set_field( 'detail_2_texte', 'Un studio ou un T2 demande généralement deux à trois heures ; un logement familial ou un gîte, trois à cinq heures ; un grand hébergement avec plusieurs chambres et salles d\'eau, davantage. Un créneau plus court est parfois possible, mais il réduit mécaniquement le périmètre traité. Nous préférons l\'annoncer avant l\'intervention plutôt que livrer un logement partiellement remis en état.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Clés et accès', $id );
	tfp_seed_set_field( 'detail_3_texte', 'L\'accès se fait le plus souvent par boîte à clés sécurisée, serrure connectée, conciergerie ou remise en main propre. Le mode d\'accès, le code et sa mise à jour éventuelle sont consignés par écrit, et transmis uniquement aux intervenants concernés par le logement. Nous signalons toute boîte à clés bloquée, tout code erroné ou toute serrure dure selon les modalités convenues avec vous : ce sont les premières causes de retard sur une rotation.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Linge', $id );
	tfp_seed_set_field( 'detail_4_texte', 'Nous changeons le linge propre que vous fournissez : draps, housses, taies, serviettes, tapis de bain, torchons. Le linge utilisé est rassemblé à l\'endroit convenu (sac, panier, local). Nous ne lavons pas le linge et n\'assurons pas de rotation de blanchisserie. Un stock de linge propre suffisant sur place est la condition pour qu\'une rotation se passe bien : lorsqu\'il est bas, nous le signalons.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Cuisine', $id );
	tfp_seed_set_field( 'detail_5_texte', 'La cuisine est le point le plus souvent commenté par les voyageurs : plan de travail, évier, robinetterie, extérieur des appareils, plaque de cuisson, micro-ondes, réfrigérateur vidé et repris, vaisselle rangée propre, poubelle évacuée et nettoyée. L\'intérieur du four, la hotte en profondeur et le détartrage complet sont possibles mais planifiés à part, car ils demandent un temps que le créneau de rotation n\'absorbe pas.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Salle de bain', $id );
	tfp_seed_set_field( 'detail_6_texte', 'Douche ou baignoire, parois, robinetterie, joints, lavabo, miroir, WC, sol et surfaces de contact : la salle de bain conditionne l\'impression d\'ensemble et concentre les remarques les plus sévères. Le détartrage courant fait partie du passage ; un détartrage lourd sur des parois durablement entartrées relève d\'une intervention ponctuelle chiffrée séparément.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Contrôle visuel et anomalies', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Un contrôle visuel est réalisé en fin d\'intervention, sur la base d\'une liste de points convenue avec vous. Les anomalies constatées — casse, équipement en panne, tache tenace, consommable épuisé — sont signalées selon les modalités convenues. Un passage de vérification supplémentaire juste avant l\'arrivée du voyageur, ou un compte-rendu écrit après chaque passage, sont possibles lorsqu\'ils sont prévus et chiffrés au devis.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Différence avec une conciergerie', $id );
	tfp_seed_set_field( 'detail_8_texte', 'Une conciergerie gère la relation voyageur : diffusion de l\'annonce, réservations, tarification, accueil, remise de clés, assistance pendant le séjour, litiges. Notre périmètre est uniquement la remise en état du logement entre deux occupants. Nous intervenons d\'ailleurs fréquemment pour le compte d\'une conciergerie, qui reste dans ce cas votre interlocuteur commercial et notre donneur d\'ordre.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour un meublé avec rotation hebdomadaire, le cahier des charges type prévoit : changement complet du linge de lit et de toilette, cuisine et électroménager dégraissés, salle de bain désinfectée, sols lavés, poubelles vidées et literie refaite, avec un contrôle visuel en fin de passage et signalement des anomalies selon l\'organisation définie avec vous.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits d\'entretien et le linge propre (draps, serviettes) sont fournis par vos soins ; nous changeons le linge utilisé contre le linge propre fourni, sans en assurer le lavage. Le matériel de nettoyage courant est généralement également fourni par le propriétaire.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès se fait le plus souvent via une boîte à clés sécurisée, une conciergerie ou une remise en main propre, selon votre organisation. Le créneau d\'intervention est calé sur l\'heure de départ du voyageur et l\'heure d\'arrivée du suivant.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'Nous sélectionnons un intervenant réactif et rigoureux, capable de travailler sur un créneau court entre deux réservations et de suivre une liste de points de contrôle sans en oublier. Nous privilégions autant que possible la même personne d\'une rotation à l\'autre : elle connaît alors l\'emplacement du linge, les particularités de l\'électroménager et les points sur lesquels les voyageurs font le plus de remarques.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Les modalités de suivi sont fixées au devis : signalement des anomalies constatées, canal utilisé (cahier de liaison, message, appel pour ce qui bloque un séjour) et délai. Un compte-rendu écrit après chaque passage est possible lorsqu\'il est prévu au devis, selon l\'organisation définie avec le client. Audrey reste votre interlocutrice pour organiser les plannings de rotation et absorber les changements de dernière minute.', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'En cas d\'absence de l\'intervenant habituel entre deux réservations, nous recherchons activement une solution et vous prévenons sans attendre, afin que vous puissiez décider en connaissance de cause. Nous ne garantissons pas un remplacement dans tous les cas : sur un créneau de quelques heures, mieux vaut une information immédiate qu\'une promesse non tenue.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Rotation type pour un T2 en location courte durée, départ à 10 h et arrivée à 16 h, intervention de 11 h à 14 h : ouverture et aération, retrait du linge utilisé et évacuation des poubelles ; salle de bain complète ; cuisine, extérieur de l\'électroménager, réfrigérateur vidé et repris, vaisselle vérifiée ; literie refaite avec le linge propre fourni ; sols aspirés et lavés ; surfaces de contact et miroirs ; contrôle visuel final sur la liste de points convenue, puis signalement des anomalies selon l\'organisation définie avec vous.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Nous ne lavons pas le linge, n\'achetons pas de consommables pour votre compte, n\'accueillons pas les voyageurs et n\'effectuons aucune réparation. Nous ne garantissons ni un contrôle avant chaque arrivée ni un compte-rendu après chaque passage : ces prestations existent, mais uniquement lorsqu\'elles sont prévues et chiffrées au devis, selon l\'organisation définie avec le client. Le temps prévu correspond à un logement rendu dans un état d\'usage normal.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Les rotations sont tenues même sur des créneaux courts, et surtout on nous dit franchement quand ce n\'est pas jouable. Le signalement des anomalies fonctionne comme on l\'avait défini au départ, sans promesse en trop.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Julien P.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Gestionnaire de meublés', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Auxerre', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Locations meublées', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Comment récupérez-vous les clés entre deux passages ?', 'reponse' => 'Boîte à clés sécurisée, conciergerie ou remise en main propre : la solution est définie avec vous selon votre organisation.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Lavez-vous le linge de lit et les serviettes ?', 'reponse' => 'Nous changeons le linge fourni propre par le client ; le lavage du linge sale n\'est pas inclus dans la prestation courante.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Que se passe-t-il si un dysfonctionnement est constaté ?', 'reponse' => 'Il est signalé selon les modalités convenues avec vous : mot dans le cahier de liaison, message à votre interlocutrice, ou appel direct pour ce qui empêcherait un séjour (fuite, chauffage en panne, serrure défectueuse). Le canal et le délai sont fixés au devis, plutôt que laissés à l\'appréciation du moment.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Faites-vous un contrôle avant chaque arrivée ?', 'reponse' => 'Un contrôle visuel est réalisé en fin d\'intervention. Un passage de vérification supplémentaire juste avant l\'arrivée du voyageur est possible, mais il constitue une prestation distincte : il n\'est réalisé que s\'il est prévu et chiffré au devis, selon l\'organisation définie avec le client.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Recevons-nous un compte-rendu après chaque intervention ?', 'reponse' => 'Cela dépend de l\'organisation définie avec vous. Un signalement est fait dès qu\'une anomalie est constatée. Un compte-rendu écrit après chaque passage, avec ou sans photos, est possible lorsqu\'il est prévu au devis : ce n\'est pas un envoi automatique inclus par défaut.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel délai vous faut-il entre un départ et une arrivée ?', 'reponse' => 'Pour un studio ou un T2, deux à trois heures suffisent généralement. Pour un logement familial ou un gîte, comptez trois à cinq heures. Un créneau plus court est parfois possible mais réduit le périmètre : nous préférons vous le dire avant plutôt que de livrer un logement partiellement traité.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'En quoi vous différenciez-vous d\'une conciergerie ?', 'reponse' => 'Une conciergerie gère la relation voyageur : annonces, réservations, tarifs, accueil, remise de clés, assistance pendant le séjour. Nous faisons uniquement la remise en état du logement. Nous travaillons d\'ailleurs souvent en complément d\'une conciergerie, qui reste alors votre interlocuteur commercial.' ), $id );
	tfp_seed_set_field( 'faq_8', array( 'question' => 'Que se passe-t-il si le logement est laissé dans un état anormal ?', 'reponse' => 'L\'intervenant vous alerte sans attendre et nous convenons de la suite : temps supplémentaire chiffré, intervention ponctuelle de remise en état, ou passage limité au strict nécessaire si le créneau ne permet rien d\'autre. Le temps prévu au devis correspond à un état d\'usage normal.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Locations meublées', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ meubles\n";
}

/* ---------------- ponctuel ---------------- */
$posts = get_posts( array( 'post_type' => 'prestation', 'name' => 'ponctuel', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! prestation ponctuel absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'nav_label', 'Nettoyage ponctuel & remise en état', $id );
	tfp_seed_set_field( 'label_court', 'Ponctuel', $id );
	tfp_seed_set_field( 'h1', 'Nettoyage ponctuel et remise en état', $id );
	tfp_seed_set_field( 'tease', 'Une intervention ponctuelle pour une remise en état après travaux, un grand nettoyage saisonnier ou une fin de bail, au même tarif horaire que nos prestations régulières.', $id );
	tfp_seed_set_field( 'hero_alt', 'Nettoyage ponctuel et remise en état', $id );
	tfp_seed_set_field( 'reponse_directe', 'Certaines situations demandent une intervention unique et approfondie : fin de chantier, grand nettoyage, réouverture ou départ des lieux. Nous établissons un devis précis selon le volume et l\'état constaté.', $id );
	tfp_seed_set_field( 'maillage_texte', 'Cette prestation suit la méthode décrite dans notre page nettoyage professionnel et le tarif de 27 € HT/h. Nous l\'assurons notamment à Dijon, Besançon, Chalon-sur-Saône et partout en Bourgogne-Franche-Comté. Pour cadrer votre besoin en amont : à quelle fréquence faire nettoyer ses locaux.', $id );
	tfp_seed_set_field( 'pour_qui_titre', 'Pour qui ?', $id );
	tfp_seed_set_field( 'pour_qui_items', implode( "\n", array(
		'Fins de travaux et de chantier',
		'Grands nettoyages saisonniers',
		'Remises en état avant emménagement',
		'Fins de bail commercial',
	) ), $id );
	tfp_seed_set_field( 'taches_titre', 'Les espaces et tâches pris en charge', $id );
	tfp_seed_set_field( 'taches', implode( "\n", array(
		'Dépose des poussières de chantier',
		'Traces de peinture et résidus',
		'Nettoyage approfondi des sols',
		'Vitres, encadrements et rebords',
		'Sanitaires et cuisines',
		'Finitions et contrôle',
	) ), $id );
	tfp_seed_set_field( 'hors_prestation', 'Hors prestation : évacuation de gravats et déchets de chantier, dépose de matériaux, traitement de surfaces dangereuses (amiante, plomb, moisissures étendues), manipulation de produits classés dangereux, intervention en hauteur avec équipement spécialisé. Ces situations relèvent d\'entreprises spécialisées.', $id );
	tfp_seed_set_field( 'exclusions_titre', '', $id );
	tfp_seed_set_field( 'exclusions_intro', '', $id );
	tfp_seed_set_field( 'exclusions_items', implode( "\n", array(

	) ), $id );
	tfp_seed_set_field( 'situations_titre', 'Les situations concrètes que nous traitons', $id );
	tfp_seed_set_field( 'situations_items', implode( "\n", array(
		'Une fin de chantier laisse une poussière fine difficile à éliminer sans méthode adaptée, sur tous les types de surfaces.',
		'Une fin de bail commercial impose souvent un délai serré avant l\'état des lieux ou l\'arrivée du nouvel occupant.',
	) ), $id );
	tfp_seed_set_field( 'situations_exemple_label', 'Exemple de planning', $id );
	tfp_seed_set_field( 'situations_exemple', 'Exemple pour une remise en état après travaux (bureau de 80 m²) : une intervention de 6 à 8 heures — dépoussiérage complet, sols, vitres, sanitaires, contrôle final avant remise des clés.', $id );
	tfp_seed_set_field( 'configs_titre', 'Trois configurations, trois organisations', $id );
	tfp_seed_set_field( 'configs_intro', 'Le volume d\'heures et la fréquence ne se déduisent pas d\'une surface. Voici les cas de figure que nous rencontrons le plus souvent, et le rythme qui leur correspond généralement.', $id );
	tfp_seed_set_field( 'config_1_titre', 'Fin de chantier', $id );
	tfp_seed_set_field( 'config_1_texte', 'Une poussière fine de plâtre et de découpe s\'est déposée partout, y compris sur les surfaces verticales et dans les rainures de menuiserie. Le travail est méthodique et descendant : hauts de meubles et huisseries, vitres et encadrements, plinthes, sols en dernier. Compter en général une journée d\'intervention pour 80 à 100 m², selon l\'intensité des travaux.', $id );
	tfp_seed_set_field( 'config_2_titre', 'Fin de bail', $id );
	tfp_seed_set_field( 'config_2_texte', 'Le local doit être rendu propre avant l\'état des lieux, souvent dans un délai serré et une fois le mobilier sorti. L\'intervention couvre l\'ensemble des surfaces : sols, sanitaires, cuisine ou coin repas, vitres accessibles, placards vidés. Nous nous engageons sur un périmètre et un temps, pas sur la décision du bailleur.', $id );
	tfp_seed_set_field( 'config_3_titre', 'Remise en état avant ouverture', $id );
	tfp_seed_set_field( 'config_3_texte', 'Avant une ouverture, une réouverture saisonnière ou un changement d\'agencement, les locaux ont souvent été inoccupés plusieurs semaines : poussière déposée, sanitaires à détartrer, vitrines à reprendre. L\'intervention est planifiée juste avant la date d\'ouverture, une fois les livraisons et l\'agencement terminés.', $id );
	tfp_seed_set_field( 'detail_titre', 'Le détail, espace par espace et contrainte par contrainte', $id );
	tfp_seed_set_field( 'detail_1_titre', 'Analyse préalable', $id );
	tfp_seed_set_field( 'detail_1_texte', 'Un nettoyage ponctuel ne s\'estime pas au téléphone en deux minutes. Nous demandons la surface, le nombre de pièces et de sanitaires, la nature des travaux réalisés, l\'état constaté et la date impérative éventuelle, avec des photos ou une visite quand c\'est possible. Cette analyse détermine le volume d\'heures, le matériel à prévoir et le nombre d\'intervenants à positionner.', $id );
	tfp_seed_set_field( 'detail_2_titre', 'État des locaux', $id );
	tfp_seed_set_field( 'detail_2_texte', 'Deux fins de chantier de même surface peuvent demander des temps très différents : un simple rafraîchissement de peinture n\'a rien à voir avec une dépose de cloisons et un ponçage. Nous distinguons la poussière déposée, les projections adhérentes (peinture, enduit, colle, silicone), les traces d\'adhésif et les résidus incrustés, chacun demandant une méthode et un temps propres.', $id );
	tfp_seed_set_field( 'detail_3_titre', 'Estimation du nombre d\'heures', $id );
	tfp_seed_set_field( 'detail_3_texte', 'Le devis est exprimé en fourchette d\'heures au tarif de 27 € HT/h, plutôt qu\'en forfait dont personne ne connaît le contenu. Si l\'état constaté sur place dépasse nettement ce qui avait été décrit, l\'intervenant s\'arrête et nous vous appelons avant de poursuivre : vous décidez alors d\'allonger l\'intervention ou de resserrer le périmètre. Aucune heure supplémentaire n\'est engagée sans votre accord.', $id );
	tfp_seed_set_field( 'detail_4_titre', 'Poussières de chantier', $id );
	tfp_seed_set_field( 'detail_4_texte', 'La poussière de chantier est fine, volatile et électrostatique : elle ne s\'élimine pas à l\'eau seule et se redépose si l\'on travaille dans le mauvais ordre. Nous procédons du haut vers le bas, en aspirant avant de laver, en changeant fréquemment les eaux et les microfibres, et en traitant les rainures de menuiserie, les grilles de ventilation et les hauts de plinthe où elle se loge durablement.', $id );
	tfp_seed_set_field( 'detail_5_titre', 'Matériaux fragiles', $id );
	tfp_seed_set_field( 'detail_5_texte', 'Parquet huilé, béton ciré, pierre naturelle, résine, inox brossé, verre laqué, plan de travail stratifié ou plaqué : chaque matériau a ses interdits, et une erreur de produit laisse une marque définitive. Nous relevons la nature des surfaces avant d\'intervenir, appliquons les préconisations disponibles, et testons sur une zone discrète en cas de doute plutôt que d\'improviser.', $id );
	tfp_seed_set_field( 'detail_6_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'detail_6_texte', 'Selon la situation, les produits sont fournis par le donneur d\'ordre ou apportés par l\'intervenant après échange préalable — c\'est plus fréquent en ponctuel qu\'en régulier, un local vide n\'ayant généralement rien sur place. Les produits utilisés sont adaptés au type de résidu et de revêtement ; aucun décapant agressif n\'est employé sans validation explicite de votre part.', $id );
	tfp_seed_set_field( 'detail_7_titre', 'Déchets et matières exclues', $id );
	tfp_seed_set_field( 'detail_7_texte', 'Nous traitons la poussière et les résidus de surface. Sont exclus : gravats, chutes de matériaux, cartons et emballages de chantier, mobilier à évacuer, encombrants. Leur évacuation suppose un véhicule adapté et un accès en déchetterie professionnelle : elle reste à la charge du chantier ou d\'un prestataire dédié, et doit être terminée avant notre passage.', $id );
	tfp_seed_set_field( 'detail_8_titre', 'Risques et produits dangereux exclus', $id );
	tfp_seed_set_field( 'detail_8_texte', 'Amiante, peinture au plomb, moisissures étendues, résidus chimiques, produits classés dangereux, locaux insalubres ou après sinistre lourd : ces situations sortent de notre périmètre. Elles exigent des habilitations, des équipements de protection et des protocoles d\'élimination spécifiques. Nous le disons dès la demande de devis plutôt que d\'accepter une intervention que nous ne devrions pas réaliser.', $id );
	tfp_seed_set_field( 'detail_9_titre', 'Possibilité d\'un second passage', $id );
	tfp_seed_set_field( 'detail_9_texte', 'Après travaux, la poussière fine encore en suspension se redépose durant les 24 à 48 heures qui suivent le premier nettoyage : un second passage plus court permet alors de reprendre les surfaces horizontales et les vitres. Il peut être prévu au devis dès le départ, ou décidé après le premier passage au vu du résultat.', $id );
	tfp_seed_set_field( 'organisation_titre', 'Une organisation carrée, du planning au suivi', $id );
	tfp_seed_set_field( 'organisation_1_titre', 'Exemple de cahier des charges', $id );
	tfp_seed_set_field( 'organisation_1_texte', 'Pour une remise en état après travaux (bureau de 80 m²), le cahier des charges type prévoit : dépoussiérage complet du sol au plafond, nettoyage des vitres et encadrements, traces de peinture retirées des sols et plinthes, sanitaires et cuisine dégraissés, contrôle final avant remise des clés au client ou remise en service des locaux.', $id );
	tfp_seed_set_field( 'organisation_2_titre', 'Produits et matériel', $id );
	tfp_seed_set_field( 'organisation_2_texte', 'Les produits utilisés dépendent de la nature des résidus constatés (poussière fine, traces de peinture, colle) et sont adaptés au type de revêtement. Selon la situation, ils peuvent être fournis par le client ou proposés par l\'intervenant après échange préalable.', $id );
	tfp_seed_set_field( 'organisation_3_titre', 'Accès et clés', $id );
	tfp_seed_set_field( 'organisation_3_texte', 'L\'accès est généralement organisé directement avec le donneur d\'ordre (entreprise, agence, propriétaire) le jour convenu, souvent juste après le départ des corps de métier, avec remise de clés ou présence d\'un référent sur place.', $id );
	tfp_seed_set_field( 'organisation_4_titre', 'Sélection de l\'intervenant', $id );
	tfp_seed_set_field( 'organisation_4_texte', 'Nous mobilisons un intervenant habitué aux chantiers de remise en état, capable d\'évaluer rapidement le volume d\'heures nécessaire selon l\'état constaté sur place, au-delà de l\'estimation initiale du devis.', $id );
	tfp_seed_set_field( 'organisation_5_titre', 'Suivi', $id );
	tfp_seed_set_field( 'organisation_5_texte', 'Un contrôle final est réalisé avant la remise des clés, avec un point sur les éventuelles zones nécessitant une seconde passe. Audrey reste votre interlocutrice pour toute intervention complémentaire.', $id );
	tfp_seed_set_field( 'organisation_6_titre', 'Absence et remplacement', $id );
	tfp_seed_set_field( 'organisation_6_texte', 'S\'agissant d\'une intervention unique, la question de l\'absence se pose différemment qu\'en régulier : en cas d\'imprévu, nous vous prévenons immédiatement et reprogrammons le créneau avec vous. Lorsque la date est contrainte par un état des lieux ou une réouverture, dites-le nous dès la demande de devis : cela conditionne notre capacité à nous engager.', $id );
	tfp_seed_set_field( 'semaine_titre', 'Une semaine type', $id );
	tfp_seed_set_field( 'semaine_type', 'Déroulé type pour une remise en état après travaux d\'un bureau de 80 m², une intervention de 7 heures : dépoussiérage descendant des hauts de meubles, huisseries, luminaires et grilles de ventilation ; vitres, encadrements et rebords ; retrait des projections de peinture et résidus d\'adhésif sur menuiseries et plinthes ; sanitaires et coin cuisine dégraissés et détartrés ; placards intérieurs ; aspiration puis lavage complet des sols ; contrôle final pièce par pièce et point sur les zones qui justifieraient un second passage.', $id );
	tfp_seed_set_field( 'limites_titre', 'Les limites de la prestation', $id );
	tfp_seed_set_field( 'limites', 'Nous ne réalisons pas l\'évacuation des gravats et déchets de chantier, la dépose de matériaux, les petites réparations, le traitement de l\'amiante, du plomb ou des moisissures étendues, la manipulation de produits classés dangereux, ni les interventions en hauteur nécessitant un équipement spécialisé. Nous ne nous engageons pas sur le résultat d\'un état des lieux, qui dépend du bailleur et de l\'usure normale : notre engagement porte sur un périmètre de nettoyage et un temps consacré.', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le devis était donné en fourchette d\'heures, avec ce qui était exclu écrit noir sur blanc. L\'état constaté était pire que prévu : on nous a appelés avant de continuer plutôt que de nous présenter la facture après.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Olivier D.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Gérant', $id );
	tfp_seed_set_field( 'temoignage_ville', 'Besançon', $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Ponctuel', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous juste après la fin des travaux ?', 'reponse' => 'Oui, une fois les corps de métier partis. Nous recommandons un délai court pour éviter que la poussière ne se redépose sur les surfaces déjà traitées.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le nettoyage après travaux est-il plus cher qu\'un entretien courant ?', 'reponse' => 'Le tarif horaire reste le même (27 € HT/h) ; c\'est le volume d\'heures qui est généralement plus important, selon l\'ampleur du chantier.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Prenez-vous en charge l\'évacuation des déchets de chantier ?', 'reponse' => 'Non. L\'évacuation de gravats, de chutes de matériaux et de déchets volumineux ne fait pas partie de la prestation : elle suppose un véhicule adapté et un accès en déchetterie professionnelle. Nous traitons la poussière et les résidus de surface, une fois les déchets évacués par le chantier.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Comment estimez-vous le nombre d\'heures nécessaires ?', 'reponse' => 'À partir de la surface, du nombre de pièces, de la nature des résidus (poussière fine de plâtre, projections de peinture, colle, silicone) et de l\'état constaté. Nous demandons des photos, ou une visite lorsque c\'est possible. L\'estimation est donnée sous forme de fourchette d\'heures, et nous vous prévenons avant de la dépasser.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous pour une fin de bail ou un état des lieux ?', 'reponse' => 'Oui, c\'est un cas fréquent, en local commercial comme en bureau. Nous ne nous engageons pas sur le résultat d\'un état des lieux, qui dépend du bailleur et de l\'usure normale des lieux : nous nous engageons sur un périmètre de nettoyage défini et sur le temps consacré.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Que faites-vous face à des matériaux fragiles ?', 'reponse' => 'Parquet huilé, béton ciré, pierre naturelle, inox brossé, plan de travail stratifié ou verre laqué ne supportent pas les mêmes produits ni les mêmes gestes. Nous les identifions avant l\'intervention et adaptons le produit et la méthode. En cas de doute sur une surface, nous testons sur une zone discrète ou nous vous interrogeons avant d\'agir.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Un second passage est-il possible ?', 'reponse' => 'Oui, et c\'est parfois recommandé après travaux : la poussière fine en suspension se redépose pendant les 24 à 48 heures suivant le premier nettoyage. Un second passage plus court peut être prévu au devis dès le départ, ou décidé après le premier passage.' ), $id );
	tfp_seed_set_field( 'faq_8', array( 'question' => 'Traitez-vous les produits ou substances dangereuses ?', 'reponse' => 'Non. Amiante, plomb, moisissures étendues, résidus chimiques, produits classés dangereux et locaux insalubres sont exclus de notre périmètre : ils relèvent d\'entreprises spécialisées disposant des habilitations et des équipements de protection requis.' ), $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour Ponctuel', $id );
	tfp_seed_set_field( 'cta_texte', 'Réponse claire et chiffrée sous 24 h, sans engagement.', $id );
	echo "  ✓ ponctuel\n";
}

echo "Terminé.\n";
