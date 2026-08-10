<?php
/**
 * Contenu intégral des 26 zones, relevé dans la maquette Claude Design.
 *
 * Fichier **généré** par `node tools/generate-zones.mjs` — ne pas éditer à la main : toute
 * correction se fait dans le générateur, sinon la prochaine régénération l'écrase.
 *
 * Chaque zone a son propre contenu dans la maquette (tissu économique, types de locaux,
 * quartiers, FAQ) : il est repris tel quel, jamais dupliqué en changeant un nom de commune.
 * Les montants ne sont pas figés ici, le gabarit les recalcule depuis site-options.php.
 *
 * Usage : wp eval-file bin/seed-fidelite-zones.php
 * Idempotent : upsert par slug, une deuxième exécution ne crée aucun doublon.
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-zones.php\n" );
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

echo "=== Fidélité Claude Design : contenu intégral des 26 zones ===\n";

/* ---------------- cote-dor (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'cote-dor', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone cote-dor absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage en Côte-d\'Or', $id );
	tfp_seed_set_field( 'hero_lede', 'De Dijon à Beaune, Top-Famille Pro entretient bureaux, commerces, cabinets et parties communes en Côte-d\'Or, depuis son implantation de Saint-Apollinaire.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis en Côte-d\'Or', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'La Côte-d\'Or est notre département d\'origine : notre adresse se trouve à Saint-Apollinaire (21850), en périphérie est de Dijon. Nous y entretenons bureaux, surfaces de vente, cabinets, parties communes d\'immeubles et locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h, avec un devis gratuit sous 24 heures et une interlocutrice unique, Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre couverture en Côte-d\'Or', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'C\'est le département d\'implantation de Top-Famille Pro. L\'agglomération dijonnaise constitue le cœur de notre activité : Dijon, Saint-Apollinaire, Quetigny, Chenôve, Talant, Longvic, Fontaine-lès-Dijon et Marsannay-la-Côte disposent chacune de leur page dédiée. Nous intervenons également sur l\'axe de la Côte, jusqu\'à Beaune et Nuits-Saint-Georges.',
		'Pour les communes plus éloignées — le Châtillonnais, le Montbardois, l\'Auxois — l\'intervention se décide au cas par cas : elle est possible dès lors que la fréquence permet un planning stable. Nous préférons le dire franchement plutôt que d\'afficher une couverture départementale complète que nous ne tiendrions pas partout.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les pôles professionnels du département', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Dijon concentre l\'essentiel des besoins tertiaires : sièges d\'entreprises et administrations dans les secteurs tertiaires de la ville, commerces et cabinets dans le centre-ville et dans les zones commerciales, professions libérales réparties dans les quartiers résidentiels. La première couronne complète ce tableau avec ses propres zones d\'activité.',
		'Le sud du département vit largement de la viticulture et du tourisme, avec des besoins différents : domaines et maisons de négoce à Beaune et Nuits-Saint-Georges, hôtellerie, locations meublées de courte durée, cabinets et commerces de centre-ville. Nous intervenons sur les espaces d\'accueil, de bureau et de réception, pas sur les zones de production ou de vinification.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Sur ce département, la répartition de nos prestations est assez stable d\'une année sur l\'autre :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Plateaux de bureaux et open-spaces',
		'Commerces de centre-ville et de zones commerciales',
		'Cabinets médicaux, dentaires, comptables et juridiques',
		'Parties communes de copropriétés de l\'agglomération',
		'Locations meublées et logements de courte durée',
		'Locaux associatifs, agences et espaces de coworking',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Comment nous travaillons en Côte-d\'Or', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Tout commence par une visite sur place : c\'est le grand avantage de la proximité. Nous mesurons, nous regardons les revêtements, nous notons les contraintes d\'accès et d\'horaires, puis nous rédigeons un cahier des charges pièce par pièce. Le devis suit sous 24 heures, avec le volume d\'heures que nous estimons réellement nécessaire.',
		'Nous cherchons ensuite à confier votre site au même intervenant chaque semaine, car c\'est ce qui fait la qualité dans la durée. En cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement — sans promettre une continuité automatique que personne ne peut garantir.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, comme dans le reste de la région, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles peuvent apparaître pour les communes les plus éloignées du département, et sont alors chiffrées au devis.',
		'Trois passages de 1 h par semaine dans un plateau de 180 m² : sols, sanitaires, cuisine et salle de réunion. 333 € HT/mois ; 383 € HT le premier mois si les frais de mise en place s\'appliquent.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux à Dijon, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous cherchions un prestataire capable de passer avant 8 h sans qu\'on ait à rappeler chaque semaine. C\'est le cas depuis un an, et les consignes de la salle de réunion sont bien suivies.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Julien R.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Agence de communication · Dijon', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Entretien régulier ou intervention ponctuelle', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'L\'entretien régulier est la formule principale que nous proposons sur l\'agglomération : un à cinq passages par semaine, souvent avant 8 h ou après 18 h, avec un volume d\'heures mensuel fixe et un tarif prévisible. Les commerces privilégient le passage matinal avant ouverture, les bureaux le début de matinée ou la soirée, les copropriétés un créneau hebdomadaire fixe.',
		'L\'intervention ponctuelle répond à une date : remise en état après travaux dans un local commercial, fin de bail, préparation avant ouverture, grand nettoyage de printemps dans une copropriété. Même tarif horaire, volume estimé au devis, date confirmée selon nos disponibilités.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Déplacements et organisation des tournées', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Depuis Saint-Apollinaire, l\'agglomération dijonnaise fait partie de nos secteurs prioritaires. L\'organisation de plusieurs sites sur une même matinée y est étudiée selon le planning ; la faisabilité d\'une prestation courte est étudiée au cas par cas, selon l\'adresse et le planning.',
		'Sur les secteurs plus éloignés du département, le regroupement des interventions sur une même journée est étudié selon le planning, avec des créneaux plus longs. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Ce que nous ne prenons pas en charge', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'La Côte-d\'Or compte des sites industriels, agroalimentaires et hospitaliers importants, notamment autour de Dijon et de Longvic. Sur ce type de site, nous intervenons uniquement dans les espaces compatibles avec notre offre : bureaux administratifs, accueil, salles de réunion, sanitaires et vestiaires de bureau.',
		'Nous ne réalisons ni nettoyage industriel lourd, ni nettoyage de chaînes de production, ni nettoyage agroalimentaire spécialisé, ni bio-nettoyage hospitalier, ni traitement chimique, ni désamiantage, ni intervention en locaux à risque. Ces prestations exigent des protocoles et des habilitations spécifiques que nous n\'avons pas.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Communes secondaires documentées', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', '', $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_3_texte', '', $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Beaune',
		'Chevigny-Saint-Sauveur',
		'Ahuy',
		'Daix',
		'Plombières-lès-Dijon',
		'Sennecey-lès-Dijon',
		'Nuits-Saint-Georges',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_4_section', 5, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_5_section', 8, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 4, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Côte-d\'Or', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Êtes-vous vraiment installés en Côte-d\'Or ?', 'reponse' => 'Oui, à Saint-Apollinaire (21850), commune limitrophe de Dijon. C\'est notre unique implantation : nous n\'avons pas d\'agence à Dijon même, ni ailleurs dans la région.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Intervenez-vous dans toute la Côte-d\'Or ?', 'reponse' => 'L\'agglomération dijonnaise et l\'axe jusqu\'à Beaune sont nos secteurs prioritaires. Pour le Châtillonnais, le Montbardois ou l\'Auxois, l\'intervention dépend de la fréquence envisagée : demandez-nous de vérifier votre commune.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Des indemnités kilométriques peuvent-elles s\'ajouter en Côte-d\'Or ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse exacte, du planning et des conditions d\'intervention. Elles sont calculées et précisées dans le devis avant toute validation.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous venir visiter nos locaux avant le devis ?', 'reponse' => 'Oui, et c\'est ce que nous recommandons sur ce département. La visite permet d\'estimer un volume d\'heures réaliste plutôt qu\'une fourchette approximative.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Travaillez-vous avec les copropriétés de la métropole ?', 'reponse' => 'Oui : halls, cages d\'escalier, ascenseurs, locaux à conteneurs, sortie et rentrée des bacs. Nous travaillons avec des syndics professionnels comme avec des conseils syndicaux bénévoles.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Proposez-vous des passages avant 8 h ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé pour les bureaux comme pour les commerces de l\'agglomération. Les interventions de nuit, le dimanche et les jours fériés sont possibles avec une majoration de 10 %.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ cote-dor\n";
}

/* ---------------- doubs (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'doubs', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone doubs absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Doubs', $id );
	tfp_seed_set_field( 'hero_lede', 'À Besançon et dans son agglomération, Top-Famille Pro entretient bureaux, cabinets, commerces et parties communes, avec la même organisation et le même tarif que dans le reste de la région.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis dans le Doubs', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Dans le Doubs, notre secteur prioritaire est Besançon et son agglomération. Nous y entretenons bureaux, cabinets médicaux et paramédicaux courants, commerces et parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, à 27 € HT/h. Nous n\'avons pas d\'agence bisontine : l\'organisation vient de Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre couverture dans le Doubs', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Notre secteur d\'intervention prioritaire couvre Besançon et sa première couronne : École-Valentin, Chalezeule, Thise, Saône, Pirey, Serre-les-Sapins, Beure. Ces communes appartiennent au même bassin géographique. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.',
		'Le nord du département, autour de Montbéliard et du Pays de Montbéliard, ainsi que le Haut-Doubs vers Pontarlier, ne font pas partie de nos secteurs prioritaires. Nous étudions les demandes au cas par cas, mais nous ne prétendons pas couvrir tout le département avec la même réactivité qu\'à Besançon.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel bisontin', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Besançon est une ville tertiaire et universitaire : administrations, sièges régionaux, professions libérales nombreuses, secteur de la santé très présent avec le CHU et les cabinets qui l\'entourent. Les secteurs tertiaires de l\'agglomération accueillent des entreprises dont les locaux comportent une part importante de bureaux et de salles de réunion.',
		'Le centre historique, classé au patrimoine mondial, concentre un commerce de détail dense et de nombreux cabinets installés dans des immeubles anciens. Ces locaux ont leurs contraintes propres : escaliers, parquets, accès limité aux véhicules, horaires à caler sur la fréquentation piétonne.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Sur Besançon, nos prestations se répartissent principalement entre :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Bureaux tertiaires et sièges régionaux',
		'Cabinets médicaux et paramédicaux courants',
		'Commerces du centre historique',
		'Parties communes d\'immeubles anciens et de résidences',
		'Locaux administratifs d\'entreprises et de laboratoires privés',
		'Locations meublées et logements étudiants',
	) ), $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. C\'est aussi pourquoi nous privilégions ici les créneaux réguliers et les volumes d\'heures groupés.',
		'Deux passages de 1 h 15 par semaine dans un cabinet de professions libérales : accueil, salle d\'attente, bureaux, sanitaires et sols. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · cabinet à Besançon, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'La salle d\'attente et les sanitaires sont repris selon le cahier des charges convenu. Le passage se fait après le dernier patient, ce qui était notre principale contrainte.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Claire D.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Cabinet paramédical · Besançon', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Les cabinets de santé : ce que nous faisons, ce que nous ne faisons pas', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Les cabinets médicaux, dentaires et paramédicaux représentent une part importante de notre activité bisontine. Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges.',
		'Il s\'agit d\'un entretien courant de locaux professionnels. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Nous n\'intervenons pas en bloc opératoire, en salle de soins critiques, en laboratoire d\'analyses ni dans un environnement soumis à un protocole hospitalier. Si votre besoin relève de ce niveau, il faut une entreprise spécialisée — nous le disons dès le premier échange.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Organisation des déplacements depuis Saint-Apollinaire', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Besançon est à environ une heure de route de notre adresse. Cela change la façon d\'organiser le travail : nous ne pouvons pas proposer un passage de trente minutes, et nous évitons les interventions isolées non planifiées. En revanche, un créneau régulier, fixé à l\'avance, avec un volume d\'heures suffisant, fonctionne très bien.',
		'Concrètement, le regroupement des passages sur un même secteur est étudié selon le planning, l\'intervenant pouvant enchaîner plusieurs prestations sur le secteur. Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Entretien régulier ou intervention ponctuelle', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'En régulier, les formules pouvant être étudiées vont d\'un à trois passages par semaine, avec un cahier de liaison sur site et un point de suivi. Nous cherchons à maintenir le même intervenant d\'une semaine sur l\'autre, ce qui est particulièrement important pour les cabinets où la confidentialité et la discrétion comptent autant que la propreté.',
		'En ponctuel, nous intervenons pour des remises en état après travaux, des fins de bail, des ouvertures de local ou un grand nettoyage saisonnier. Sur Besançon, ces interventions demandent un peu plus de délai de programmation qu\'en Côte-d\'Or : nous confirmons la date au devis.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'École-Valentin',
		'Chalezeule',
		'Thise',
		'Saône',
		'Pirey',
		'Serre-les-Sapins',
		'Beure',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Doubs', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence à Besançon ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Nous intervenons à Besançon avec des tournées organisées, et votre interlocutrice reste Audrey au 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le déplacement est-il facturé pour Besançon ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles figurent en ligne distincte, avant toute signature.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Intervenez-vous dans le Pays de Montbéliard ou à Pontarlier ?', 'reponse' => 'Ce ne sont pas nos secteurs prioritaires. Nous étudions les demandes au cas par cas, en fonction de la fréquence et du volume d\'heures, mais nous ne garantissons pas la même réactivité qu\'à Besançon.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Faites-vous du bio-nettoyage hospitalier ?', 'reponse' => 'Non. Nous assurons l\'entretien courant des locaux : accueil, salle d\'attente, bureaux, sanitaires, sols et surfaces courantes. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Les blocs, salles de soins et laboratoires relèvent d\'entreprises spécialisées.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Pouvez-vous intervenir après la fermeture du cabinet ?', 'reponse' => 'Oui, c\'est le cas le plus fréquent : passage après le dernier patient, avec une clé ou un code confiés sous décharge écrite. Les interventions de nuit et les dimanches sont majorées de 10 %.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Un petit volume horaire est-il possible à Besançon ?', 'reponse' => 'En pratique, nous conseillons au moins deux heures par passage sur ce secteur, ou un regroupement hebdomadaire. Sous ce volume, le trajet rend l\'organisation difficile à tenir dans la durée.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ doubs\n";
}

/* ---------------- jura (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'jura', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone jura absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Jura', $id );
	tfp_seed_set_field( 'hero_lede', 'Dole et Lons-le-Saunier sont nos deux villes d\'intervention dans le Jura : bureaux, commerces, cabinets et parties communes, en régulier comme en ponctuel.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis dans le Jura', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Dans le Jura, nous intervenons principalement à Dole, à Lons-le-Saunier et dans les communes proches de ces deux villes. Bureaux, surfaces de vente, cabinets courants, parties communes et locations meublées sont entretenus à 27 € HT/h, en contrat régulier ou en intervention datée, avec un devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Deux bassins distincts : Dole et Lons-le-Saunier', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Le Jura n\'a pas un centre unique mais plusieurs bassins. Dole, au nord-ouest du département, fait partie de nos secteurs prioritaires dans le Jura. Lons-le-Saunier, préfecture située plus au sud, demande davantage de planification.',
		'Nous intervenons aussi dans les communes immédiatement voisines de ces deux villes : Choisey, Tavaux, Damparis, Foucherans et Authume autour de Dole ; Montmorot, Perrigny et Macornay autour de Lons-le-Saunier. Le Haut-Jura, autour de Saint-Claude et Morez, ne fait pas partie de nos secteurs prioritaires.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel jurassien', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Dole associe un centre historique commerçant, un tissu de professions libérales et des activités industrielles à proximité. Lons-le-Saunier est une ville d\'administrations, de sièges de coopératives agroalimentaires et de commerces, avec une activité thermale et un centre-ville dense en cabinets.',
		'Ce mélange se retrouve dans nos prestations : beaucoup de commerces et de cabinets, des bureaux de PME, des locaux administratifs rattachés à des sites industriels, et des parties communes de résidences. La fréquence est définie au cas par cas avec chaque client, selon la fréquentation des locaux.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Dans le Jura, nos interventions portent principalement sur :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Commerces de centre-ville, à Dole comme à Lons-le-Saunier',
		'Bureaux de PME et locaux administratifs',
		'Cabinets comptables, juridiques, paramédicaux courants',
		'Parties communes de résidences et petites copropriétés',
		'Locations meublées et gîtes urbains',
		'Locaux associatifs et espaces de réunion',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Sites industriels et agroalimentaires : notre périmètre', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Le département compte des activités industrielles et une filière agroalimentaire structurée. Sur ce type d\'établissement, nous intervenons exclusivement dans les bureaux administratifs, les accueils, les salles de réunion, les vestiaires de bureau et les sanitaires.',
		'Nous ne réalisons pas de nettoyage de chaînes de production, de nettoyage agroalimentaire spécialisé, de traitement chimique ni d\'intervention en zone réglementée. Cela relève d\'entreprises disposant des protocoles, du matériel et des habilitations correspondants.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h partout dans le département, avec 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Un passage d\'une heure avant ouverture, du mardi au samedi : surface de vente, sanitaires clients, réserve une fois par semaine. 441 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · commerce à Dole, 16 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage se fait avant l\'ouverture, tous les matins, et la boutique est prête quand j\'arrive. Le point de suivi permet d\'ajuster ce qui doit l\'être sans avoir à téléphoner.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Nathalie P.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Commerce de centre-ville · Dole', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fonctionnement et suivi', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Sur Dole, une visite préalable est généralement organisée. Sur Lons-le-Saunier, nous procédons souvent par échange détaillé complété de photos, puis nous ajustons après les premiers passages : c\'est plus honnête que d\'annoncer un volume d\'heures approximatif au téléphone.',
		'Chaque site dispose d\'un cahier de liaison où l\'intervenant note ce qui a été fait et ce qui mérite votre attention. Nous cherchons à maintenir le même intervenant d\'une semaine sur l\'autre et vous prévenons en cas de changement, avec transmission écrite des consignes au remplaçant.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Régulier, ponctuel et saisonnier', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'En entretien régulier, les formules jurassiennes tournent souvent autour d\'un à cinq passages par semaine pour les commerces, et d\'un à deux passages pour les bureaux et cabinets. Le volume d\'heures mensuel est fixé au devis et reste stable, ce qui facilite la gestion budgétaire.',
		'En ponctuel, nous traitons les remises en état après travaux, les fins de bail, les préparations de local avant ouverture et les grands nettoyages saisonniers. Le tourisme jurassien génère également des demandes sur les locations meublées entre deux séjours, avec un délai de programmation à convenir à l\'avance.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Mise en place et premiers passages', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Une prestation jurassienne ne se juge pas au premier passage. Les premiers passages permettent de vérifier l\'adéquation entre le cahier des charges, le temps prévu et les contraintes des locaux. Si un écart significatif est constaté, Top-Famille Pro échange avec le client et peut proposer une adaptation de l\'organisation ou du volume horaire.',
		'Les consignes s\'affinent au fil des premiers passages : ordre de passage, points sensibles, éléments à ne pas déplacer, matériel laissé sur site. Nous faisons ensuite un point avec vous, par téléphone ou sur place. Toute adaptation du volume horaire ou de l\'organisation est discutée avec vous avant d\'être appliquée, et fait l\'objet d\'un devis actualisé.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Choisey',
		'Tavaux',
		'Damparis',
		'Foucherans',
		'Authume',
		'Montmorot',
		'Perrigny',
		'Macornay',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Jura', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous à Dole et à Lons-le-Saunier ?', 'reponse' => 'Oui, ce sont nos deux villes d\'intervention dans le Jura, avec les communes immédiatement voisines de chacune. Chaque ville dispose de sa page détaillée.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Couvrez-vous le Haut-Jura, vers Saint-Claude ou Morez ?', 'reponse' => 'Ce ne sont pas nos secteurs prioritaires, en raison de la distance. Nous étudions les demandes au cas par cas, mais nous préférons annoncer clairement nos limites plutôt qu\'une couverture départementale complète.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Le tarif est-il différent à Lons-le-Saunier ?', 'reponse' => 'Non, 27 € HT/h dans les deux villes. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Faites-vous du nettoyage agroalimentaire ?', 'reponse' => 'Non. Sur les sites agroalimentaires, nous intervenons uniquement dans les bureaux, accueils, salles de réunion et vestiaires de bureau. Les zones de production relèvent d\'entreprises spécialisées.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Pouvez-vous entretenir une location meublée dans le Jura ?', 'reponse' => 'Oui, entre deux séjours ou en fin de bail : ménage complet, changement de linge, vérification des consommables et signalement photographique des dégradations, chacun possible lorsque prévu dans le cahier des charges et chiffré dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel délai pour une intervention ponctuelle ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ jura\n";
}

/* ---------------- nievre (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'nievre', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone nievre absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans la Nièvre', $id );
	tfp_seed_set_field( 'hero_lede', 'À Nevers et dans son agglomération, Top-Famille Pro entretient bureaux, commerces, cabinets et parties communes, au même tarif que dans le reste de la région.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis dans la Nièvre', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Dans la Nièvre, notre secteur d\'intervention est Nevers et son agglomération. Nous y entretenons bureaux, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, à 27 € HT/h. Devis gratuit sous 24 heures, une seule interlocutrice, Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre couverture dans la Nièvre', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Nevers et les communes qui l\'entourent — Varennes-Vauzelles, Fourchambault, Marzy, Coulanges-lès-Nevers, Challuy — constituent notre secteur nivernais. Ces communes forment un ensemble compact, ce qui est pris en compte lorsque le regroupement de plusieurs interventions sur une même journée est étudié.',
		'Le reste du département, très étendu et peu dense, n\'est pas couvert de façon régulière. Nous ne prétendons pas intervenir partout dans la Nièvre : au-delà de l\'agglomération, chaque demande est examinée en fonction de la fréquence, du volume d\'heures et du trajet.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel nivernais', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Nevers est une ville de services et d\'administrations : préfecture, collectivités, organismes publics, professions libérales et un centre-ville commerçant. S\'y ajoutent des activités industrielles et logistiques réparties dans les zones d\'activité de l\'agglomération, réparties autour de la ville.',
		'Le parc immobilier comporte une forte proportion de résidences collectives, ce qui explique la part importante des parties communes dans nos interventions locales : halls, cages d\'escalier, ascenseurs, locaux à conteneurs. Ce sont des prestations régulières, à créneau convenu, dont l\'organisation s\'étudie selon le planning.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Sur l\'agglomération de Nevers, nos prestations concernent surtout :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Parties communes de copropriétés et résidences',
		'Bureaux administratifs et locaux de collectivités',
		'Commerces de centre-ville',
		'Cabinets et professions libérales',
		'Locaux associatifs et de formation',
		'Bureaux rattachés aux zones d\'activité',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Copropriétés : le détail de la prestation', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un immeuble, le cahier des charges précise le circuit exact : hall d\'entrée, boîtes aux lettres, sol et vitrages de la porte, cage d\'escalier étage par étage, rampes, ascenseur, paliers, local à conteneurs et abords immédiats. Nous indiquons ce qui est fait à chaque passage et ce qui est fait périodiquement.',
		'La sortie et la rentrée des bacs sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis ; les jours retenus y sont inscrits. Le syndic ou le conseil syndical reçoit un point de suivi, et le cahier de liaison sert de trace : consommables à recommander, ampoule grillée, dégradation constatée, encombrant déposé dans le local.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Le taux horaire, lui, ne change pas.',
		'Deux heures par semaine : hall, cage d\'escalier, ascenseur, local à conteneurs et sortie des bacs. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · copropriété à Nevers, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le hall et les escaliers sont repris chaque semaine et les bacs sortent aux bons jours. Le cahier de liaison nous sert de compte rendu pour les réunions du conseil.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Bernard L.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Conseil syndical · Nevers', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Organisation des déplacements', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Nevers fait partie de nos secteurs éloignés. Cela impose une discipline : créneaux réguliers, volumes d\'heures regroupés, plannings convenus à l\'avance. En contrepartie, la prestation est stable et l\'intervenant connaît le site, ce qui compte beaucoup pour un immeuble ou un cabinet.',
		'Nous ne proposons pas ici de passages courts et improvisés : ce serait une promesse intenable. Si votre besoin est ponctuel et urgent, dites-le franchement au téléphone — nous vous répondrons aussi franchement sur notre capacité à le tenir.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Régulier ou ponctuel', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'L\'entretien régulier concerne l\'essentiel de nos interventions nivernaises : un passage hebdomadaire ou bihebdomadaire, avec un volume mensuel fixe et un tarif prévisible. C\'est le format qui fonctionne le mieux compte tenu de la distance, et celui qui donne les meilleurs résultats dans la durée.',
		'En ponctuel, nous intervenons pour les remises en état après travaux, les fins de bail et les grands nettoyages annuels de parties communes. La date est confirmée au devis, en fonction de nos disponibilités sur le secteur, avec une estimation du nombre d\'heures nécessaires.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Ce que nous vérifions avant de nous engager', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Sur un secteur éloigné, accepter un contrat que l\'on ne pourra pas tenir est le pire service à rendre. Avant de vous répondre, nous regardons donc trois choses : le créneau demandé et sa compatibilité avec l\'organisation du planning, le volume d\'heures par passage, et la distance réelle depuis Saint-Apollinaire.',
		'Si l\'un des trois ne passe pas, nous vous le disons et nous proposons une alternative : autre créneau, fréquence différente, regroupement de passages. Et si aucune solution n\'est tenable, nous préférons refuser plutôt que d\'installer une prestation qui se dégradera au bout de deux mois. C\'est aussi pour cela que nos plannings nivernais tiennent dans le temps.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Varennes-Vauzelles',
		'Fourchambault',
		'Marzy',
		'Coulanges-lès-Nevers',
		'Challuy',
		'Garchizy',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Nièvre', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous ailleurs qu\'à Nevers dans la Nièvre ?', 'reponse' => 'Notre secteur prioritaire couvre Nevers et son agglomération proche. Pour une commune plus éloignée, contactez-nous : nous vous dirons honnêtement si nous pouvons tenir un planning fiable.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le tarif est-il majoré à cause de la distance ?', 'reponse' => 'Le taux horaire reste 27 € HT/h. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Travaillez-vous avec les syndics de copropriété ?', 'reponse' => 'Oui, c\'est une part importante de notre activité à Nevers : halls, escaliers, ascenseurs, locaux à conteneurs et gestion des bacs selon le calendrier de collecte.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Un passage hebdomadaire suffit-il pour un immeuble ?', 'reponse' => 'Pour un immeuble de taille moyenne, oui, dans la plupart des cas. Nous adaptons la fréquence à la fréquentation, au nombre d\'étages et à la présence d\'un ascenseur.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Pouvez-vous intervenir rapidement en urgence ?', 'reponse' => 'Sur ce secteur, notre réactivité est plus limitée qu\'en Côte-d\'Or. Nous vous répondrons clairement selon nos disponibilités plutôt que de nous engager sur un délai que nous ne pourrions pas tenir.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Faut-il un engagement de durée ?', 'reponse' => 'Le devis, lui, est toujours gratuit et sans engagement. Pour la prestation elle-même, le volume et la fréquence peuvent être ajustés en cours de route, et les conditions d\'arrêt (préavis écrit) sont précisées au devis avant signature.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ nievre\n";
}

/* ---------------- haute-saone (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'haute-saone', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone haute-saone absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage en Haute-Saône', $id );
	tfp_seed_set_field( 'hero_lede', 'Vesoul et son agglomération : bureaux, commerces, cabinets et parties communes entretenus en contrat régulier ou en intervention ponctuelle, à 27 € HT/h.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis en Haute-Saône', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'En Haute-Saône, notre secteur d\'intervention est Vesoul et les communes qui l\'entourent. Nous y entretenons bureaux, locaux administratifs, commerces, cabinets courants et parties communes d\'immeubles, en régulier ou en ponctuel, à 27 € HT/h, avec un devis gratuit sous 24 heures. Une seule interlocutrice pour tout le département : Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre couverture en Haute-Saône', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Vesoul et sa couronne immédiate — Navenne, Vaivre-et-Montoille, Pusey, Noidans-lès-Vesoul, Échenoz-la-Méline, Frotey-lès-Vesoul — forment notre secteur haut-saônois. L\'agglomération est compacte, ce qui permet d\'enchaîner plusieurs sites sur une même journée et de rendre le déplacement soutenable.',
		'Le département est vaste et rural : Gray, Lure, Luxeuil-les-Bains ou Héricourt ne font pas partie de nos secteurs prioritaires. Nous examinons les demandes au cas par cas, en fonction du volume d\'heures et de la fréquence, sans annoncer une couverture départementale que nous ne pourrions pas tenir.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel autour de Vesoul', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Vesoul est une préfecture de taille modeste, structurée autour des administrations, des services et d\'un centre-ville commerçant. L\'agglomération accueille par ailleurs des zones d\'activité industrielles et logistiques significatives à l\'échelle du département, réparties autour de la ville.',
		'Ce mélange explique la nature de nos interventions : beaucoup de bureaux administratifs, y compris ceux rattachés à des sites industriels ou logistiques, des commerces de centre-ville, des cabinets et quelques copropriétés. Les demandes portent souvent sur des créneaux en dehors des heures d\'activité, avec un accès par badge ou par clé.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Nos prestations en Haute-Saône concernent principalement :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Bureaux administratifs et locaux tertiaires',
		'Bureaux rattachés aux zones logistiques et industrielles',
		'Commerces de centre-ville',
		'Cabinets et professions libérales',
		'Parties communes de résidences',
		'Locaux associatifs et de formation',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Sites industriels et logistiques : notre périmètre exact', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Sur un site industriel ou logistique, notre intervention s\'arrête à la porte des zones d\'exploitation. Nous entretenons les bureaux, l\'accueil, les salles de réunion, les vestiaires de bureau, les sanitaires et les circulations administratives. C\'est un périmètre clair, écrit dans le cahier des charges, plan à l\'appui quand c\'est nécessaire.',
		'Nous ne réalisons pas de nettoyage industriel lourd, ni d\'entretien d\'entrepôt d\'exploitation, ni de nettoyage de machines ou de lignes de production, ni de traitement chimique. Cette limite est annoncée dès le premier échange : mieux vaut un périmètre restreint et tenu qu\'une promesse large et approximative.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Nous privilégions ici des créneaux réguliers et des volumes d\'heures suffisants pour que la prestation tienne dans le temps.',
		'Deux passages de 1 h 15 par semaine : espaces de travail, sanitaires, coin cuisine et accueil. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux à Vesoul, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous avions besoin d\'un passage en dehors des horaires d\'ouverture, avec un badge d\'accès. L\'organisation a été mise en place proprement et le planning est respecté.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Fabrice T.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau administratif · Vesoul', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Accès, clés et interventions hors horaires', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'La majorité de nos prestations haut-saônoises se déroule en dehors des heures d\'ouverture. Cela suppose une organisation d\'accès formalisée : remise de clé ou de badge contre décharge écrite, code d\'alarme consigné, procédure de fermeture rappelée dans le cahier des charges. Nous ne conservons aucun accès sans document signé.',
		'En cas de changement d\'intervenant, la remise des accès est refaite dans les mêmes conditions et vous en êtes informé. Les interventions de nuit, le dimanche et les jours fériés font l\'objet d\'une majoration de 10 %, indiquée au devis dès qu\'elle s\'applique.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Régulier ou ponctuel', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'L\'entretien régulier est la formule dominante ici : un à trois passages par semaine, volume mensuel fixe, planning connu à l\'avance. C\'est ce qui permet d\'absorber la distance et de rechercher un intervenant habituel pour le site, avec les gains de qualité que cela implique.',
		'En ponctuel, nous intervenons pour des remises en état après travaux, des fins de bail, des ouvertures de local ou des grands nettoyages annuels. La date est confirmée au devis en fonction de nos tournées sur le secteur, avec le nombre d\'heures estimé.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Matériel, produits et consommables', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les produits et le matériel sont généralement fournis par le client ; toute organisation différente est précisée dans le devis et le cahier des charges — certains sites imposent leurs références, ce qui ne pose aucun problème dès lors que c\'est écrit au cahier des charges. Nous travaillons avec un matériel distinct par type d\'espace lorsque le cahier des charges le prévoit, code couleur pour les sanitaires distinct de celui des espaces de travail.',
		'Les consommables — papier, savon, sacs — peuvent être gérés par vous ou par nous. Dans le second cas, ils sont refacturés au prix d\'achat, sans marge, et le cahier de liaison signale les niveaux bas avant la rupture. C\'est un détail qui évite les appels du lundi matin.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Navenne',
		'Vaivre-et-Montoille',
		'Pusey',
		'Noidans-lès-Vesoul',
		'Échenoz-la-Méline',
		'Frotey-lès-Vesoul',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Haute-Saône', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous ailleurs qu\'à Vesoul en Haute-Saône ?', 'reponse' => 'Notre secteur prioritaire couvre Vesoul et sa couronne immédiate. Gray, Lure, Luxeuil-les-Bains ou Héricourt ne sont pas des secteurs prioritaires : contactez-nous, nous vous répondrons honnêtement.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le déplacement est-il facturé ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles figurent en ligne distincte sur le devis, jamais après coup.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Entretenez-vous les entrepôts logistiques ?', 'reponse' => 'Non. Nous intervenons dans les bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires de ces sites, pas dans les zones d\'exploitation ni sur les machines.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous intervenir avec un badge en dehors des horaires ?', 'reponse' => 'Oui. La remise du badge ou de la clé se fait contre décharge écrite, avec le code d\'alarme et la procédure de fermeture consignés dans le cahier des charges.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Le tarif est-il plus élevé qu\'en Côte-d\'Or ?', 'reponse' => 'Le taux horaire est identique, 27 € HT/h. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel volume minimum conseillez-vous ?', 'reponse' => 'Sur ce secteur, nous recommandons au moins deux heures par passage, ou un regroupement hebdomadaire, afin que l\'organisation reste tenable pour vous comme pour nous.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ haute-saone\n";
}

/* ---------------- saone-et-loire (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'saone-et-loire', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone saone-et-loire absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage en Saône-et-Loire', $id );
	tfp_seed_set_field( 'hero_lede', 'De Chalon-sur-Saône à Mâcon, le long de l\'axe Saône : bureaux, commerces, cabinets, copropriétés et locations meublées entretenus à 27 € HT/h.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis en Saône-et-Loire', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'En Saône-et-Loire, nos deux villes d\'intervention sont Chalon-sur-Saône et Mâcon, ainsi que les communes proches de chacune. Nous y entretenons bureaux, surfaces de vente, cabinets courants, parties communes et locations meublées, en contrat régulier ou en intervention ponctuelle, à 27 € HT/h, avec un devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Deux bassins le long de l\'axe Saône', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'La Saône-et-Loire s\'organise du nord au sud le long de la Saône et de l\'A6. Nous intervenons sur deux bassins : le Grand Chalon au nord, avec Chalon-sur-Saône, Saint-Rémy, Champforgeuil, Saint-Marcel et Châtenoy-le-Royal ; l\'agglomération mâconnaise au sud, avec Mâcon, Sancé, Charnay-lès-Mâcon et Crêches-sur-Saône.',
		'Ces deux bassins sont distincts : ils appartiennent à deux bassins distincts et n\'ont pas le même profil d\'activité. En revanche, ils partagent une bonne accessibilité routière, ce qui rend l\'organisation plus simple que dans les zones rurales du département. Le Creusot, Montceau-les-Mines et le Charolais ne sont pas des secteurs prioritaires.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel du département', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Chalon-sur-Saône est une ville industrielle et tertiaire : bureaux d\'études, sièges d\'entreprises, un port fluvial actif, des zones d\'activité et un centre-ville commerçant. Mâcon, préfecture, vit du commerce, des services, de la logistique liée à l\'A6 et de la filière viticole du Mâconnais.',
		'Les besoins susceptibles de nous être confiés viennent surtout de PME, de commerces indépendants, de cabinets et de syndics. Les demandes portent en majorité sur des passages tôt le matin ou en fin de journée, avec une fréquence de deux à cinq fois par semaine pour les commerces et d\'une à trois fois pour les bureaux.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Sur les deux bassins, nos prestations concernent principalement :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Bureaux de PME et bureaux d\'études',
		'Commerces de centre-ville et de zones commerciales',
		'Cabinets comptables, juridiques et paramédicaux courants',
		'Parties communes de copropriétés urbaines',
		'Locations meublées et logements de courte durée',
		'Locaux administratifs rattachés à des sites de production',
	) ), $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h dans les deux bassins, plus 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles sont calculées au devis, avant signature.',
		'Trois passages d\'une heure par semaine : open-space, bureaux individuels, sanitaires et espace café. 333 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux à Chalon, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous avons trois passages par semaine tôt le matin. Les bureaux sont prêts avant l\'arrivée des équipes et le suivi mensuel évite les allers-retours par mail.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Émilie V.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau d\'études · Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Industrie, agroalimentaire et viticulture : ce que nous traitons', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Le département compte de l\'industrie, de l\'agroalimentaire et une filière viticole importante. Sur ces sites, notre intervention se limite aux espaces compatibles avec notre offre : bureaux, accueils, salles de dégustation et de réception nettoyées comme des espaces recevant du public, salles de réunion, sanitaires et vestiaires de bureau.',
		'Nous n\'intervenons pas dans les zones de production, les caves d\'élaboration, les ateliers, les chaînes de conditionnement ni les locaux soumis à un protocole sanitaire spécifique. Le nettoyage agroalimentaire spécialisé et le nettoyage industriel lourd ne font pas partie de nos prestations.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Une visite est organisée sur les deux bassins dès que la configuration le justifie : nous relevons les surfaces, les revêtements, les contraintes d\'accès et d\'horaires, puis nous rédigeons un cahier des charges détaillé, espace par espace. Le devis suit sous 24 heures avec un volume d\'heures argumenté.',
		'Les intervenants sont recrutés et suivis par Audrey. Nous cherchons à confier chaque site au même intervenant sur la durée ; en cas d\'absence ou de départ, nous cherchons un remplaçant, lui transmettons les consignes écrites et vous prévenons du changement. Un point de suivi permet d\'ajuster ce qui doit l\'être.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Régulier, ponctuel et pics saisonniers', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'L\'entretien régulier structure l\'essentiel de nos contrats : fréquence définie, volume d\'heures mensuel fixe, planning connu à l\'avance. Les commerces demandent souvent un renfort les jours de forte affluence, ce qui se traite par un passage supplémentaire chiffré séparément plutôt qu\'en gonflant le contrat de base.',
		'En ponctuel, nous intervenons pour des remises en état après travaux, des fins de bail, des ouvertures de local et des grands nettoyages saisonniers. Le tourisme viticole génère aussi des demandes sur les locations meublées entre deux séjours, à programmer à l\'avance en haute saison.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Saint-Rémy',
		'Champforgeuil',
		'Saint-Marcel',
		'Châtenoy-le-Royal',
		'Sancé',
		'Charnay-lès-Mâcon',
		'Crêches-sur-Saône',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Saône-et-Loire', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous à Chalon-sur-Saône et à Mâcon ?', 'reponse' => 'Oui, ce sont nos deux villes d\'intervention en Saône-et-Loire, chacune avec ses communes proches. Chaque ville a sa page détaillée sur le site.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Couvrez-vous Le Creusot, Montceau-les-Mines ou le Charolais ?', 'reponse' => 'Ce ne sont pas nos secteurs prioritaires. Nous étudions les demandes au cas par cas selon la fréquence et le volume, sans promettre la même réactivité que sur l\'axe Saône.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Des indemnités kilométriques peuvent-elles s\'ajouter en Saône-et-Loire ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse exacte, du planning et des conditions d\'intervention. Elles sont calculées et précisées dans le devis avant toute validation. Le taux horaire, lui, reste de 27 € HT/h.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Intervenez-vous dans les caves et chais viticoles ?', 'reponse' => 'Non. Nous entretenons les bureaux, accueils, salles de dégustation et de réception, sanitaires et salles de réunion, pas les espaces d\'élaboration ni de conditionnement.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Un passage supplémentaire est-il possible les jours de forte affluence ?', 'reponse' => 'Oui, pour les commerces notamment. Il est chiffré séparément au même tarif horaire, sans modifier le contrat régulier en place.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Travaillez-vous avec les syndics du Grand Chalon ?', 'reponse' => 'Oui : halls, cages d\'escalier, ascenseurs, locaux à conteneurs, avec un cahier de liaison consultable par le conseil syndical et un point de suivi.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ saone-et-loire\n";
}

/* ---------------- yonne (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'yonne', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone yonne absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans l\'Yonne', $id );
	tfp_seed_set_field( 'hero_lede', 'Auxerre et son agglomération : entretien de bureaux, commerces, cabinets et parties communes, en régulier ou en ponctuel, à 27 € HT/h.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis dans l\'Yonne', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Dans l\'Yonne, notre secteur d\'intervention est Auxerre et les communes proches. Nous y entretenons bureaux de PME, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, à 27 € HT/h, avec un devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre couverture dans l\'Yonne', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Auxerre et sa couronne — Monéteau, Appoigny, Perrigny, Saint-Georges-sur-Baulche, Venoy, Chevannes — constituent notre secteur icaunais. L\'agglomération est bien desservie par l\'A6, ce qui facilite l\'organisation des tournées malgré l\'éloignement de notre point d\'attache.',
		'Le nord du département, autour de Sens et de Joigny, ainsi que l\'Avallonnais, ne font pas partie de nos secteurs prioritaires. Nous n\'annonçons pas de couverture départementale complète : selon la fréquence et le volume d\'heures demandés, nous vous dirons simplement si nous pouvons tenir un planning fiable ou non.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel autour d\'Auxerre', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Auxerre est une préfecture de services : administrations, sièges de PME, professions libérales, centre-ville commerçant, avec un patrimoine bâti ancien dans le cœur historique. L\'axe A6 a favorisé l\'implantation d\'activités logistiques et agroalimentaires dans les zones d\'activité périphériques.',
		'À proximité, la filière viticole du Chablisien génère des besoins d\'entretien sur les espaces d\'accueil, les caveaux de dégustation et les bureaux des domaines et maisons de négoce. Là encore, nous intervenons sur les espaces recevant du public et les bureaux, pas sur les zones d\'élaboration.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Dans l\'Yonne, nos prestations portent principalement sur :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Bureaux de PME et sièges locaux',
		'Bureaux administratifs rattachés aux zones logistiques',
		'Commerces de centre-ville',
		'Cabinets et professions libérales',
		'Espaces d\'accueil et de dégustation',
		'Parties communes de résidences',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Logistique et agroalimentaire : notre limite', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Les zones d\'activité de l\'axe A6 accueillent des entrepôts et des sites de transformation. Notre intervention y porte exclusivement sur les bureaux administratifs, l\'accueil, les salles de réunion, les vestiaires de bureau et les sanitaires — un périmètre écrit dans le cahier des charges et, si besoin, tracé sur un plan.',
		'Nous ne réalisons pas d\'entretien d\'entrepôt d\'exploitation, de nettoyage de lignes de conditionnement, de nettoyage agroalimentaire spécialisé ni de traitement chimique. Si votre besoin porte sur ces zones, une entreprise spécialisée sera plus pertinente et nous vous le dirons d\'emblée.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h comme partout en région, avec 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles sont chiffrées au devis, et nous privilégions des créneaux réguliers et regroupés.',
		'Deux passages d\'une heure par semaine : bureaux administratifs, sanitaires, salle de pause. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux à Auxerre, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nos bureaux administratifs sont entretenus deux fois par semaine en dehors des heures d\'activité. Ce qui nous a convaincus, c\'est d\'avoir la même personne à joindre à chaque question.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Karim B.', $id );
	tfp_seed_set_field( 'temoignage_role', 'PME · Auxerre', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fonctionnement et suivi à distance', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Sur ce département, la mise en place commence souvent par un échange détaillé complété de photos ou d\'un plan, puis par une visite lorsque le volume le justifie. Le cahier des charges liste les espaces, les tâches par passage et les tâches périodiques : c\'est le document de référence pour vous comme pour l\'intervenant.',
		'Le suivi s\'appuie sur un cahier de liaison sur site et un point de suivi avec Audrey. Vous n\'avez pas besoin d\'être présent pendant l\'intervention pour savoir ce qui a été fait : ce qui a été traité et ce qui mérite votre attention y sont notés à chaque passage.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Régulier ou ponctuel', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'L\'entretien régulier est la formule adaptée à ce secteur : un à trois passages hebdomadaires, volume mensuel fixe, planning établi à l\'avance. Cela nous permet de rechercher un intervenant habituel pour le site et d\'absorber la distance sans dégrader la qualité.',
		'En ponctuel, nous traitons les remises en état après travaux, les fins de bail, les préparations avant ouverture et les grands nettoyages saisonniers. La date dépend de nos tournées sur le secteur : elle est confirmée au devis, avec le volume d\'heures estimé.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Ce qui figure au devis, ligne par ligne', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Un devis Top-Famille Pro tient sur une page et se lit sans décodeur. Y figurent : les espaces couverts, les tâches faites à chaque passage, les tâches périodiques et leur fréquence, le nombre d\'heures par passage, la fréquence hebdomadaire, le volume mensuel, le taux horaire de 27 € HT/h, la gestion mensuelle de 9 € HT et la mise en place de 50 € HT.',
		'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Rien n\'apparaît après signature : s\'il faut ajouter une prestation, elle fait l\'objet d\'un devis complémentaire que vous validez avant intervention.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Monéteau',
		'Appoigny',
		'Perrigny',
		'Saint-Georges-sur-Baulche',
		'Venoy',
		'Chevannes',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Yonne', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous à Sens, Joigny ou Avallon ?', 'reponse' => 'Non, pas de façon régulière : ces villes sont trop éloignées de nos tournées actuelles pour que nous garantissions un planning stable. Notre secteur icaunais s\'arrête à Auxerre et sa couronne.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'L\'éloignement change-t-il le tarif horaire ?', 'reponse' => 'Non, il reste de 27 € HT/h. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Entretenez-vous les entrepôts de l\'axe A6 ?', 'reponse' => 'Uniquement leurs bureaux administratifs, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les zones d\'exploitation ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous entretenir un caveau de dégustation ?', 'reponse' => 'Oui, en tant qu\'espace recevant du public : sols, comptoir, vitrages intérieurs, sanitaires. Les espaces d\'élaboration et de conditionnement, non.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Est-il possible d\'intervenir sans que nous soyons présents ?', 'reponse' => 'Oui, c\'est le cas le plus fréquent. La clé ou le badge est remis contre décharge écrite, avec le code d\'alarme et la procédure de fermeture consignés.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel délai pour démarrer un contrat régulier ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ yonne\n";
}

/* ---------------- territoire-de-belfort (departement) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'territoire-de-belfort', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone territoire-de-belfort absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage dans le Territoire de Belfort', $id );
	tfp_seed_set_field( 'hero_lede', 'Belfort et son agglomération : bureaux, commerces, cabinets et parties communes entretenus en contrat régulier ou en intervention ponctuelle, à 27 € HT/h.', $id );
	tfp_seed_set_field( 'hero_alt', '', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Belfort', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Dans le Territoire de Belfort, notre secteur d\'intervention est Belfort et son agglomération. Nous y entretenons bureaux, locaux administratifs, commerces de centre-ville, cabinets courants et parties communes d\'immeubles, en régulier ou en ponctuel, à 27 € HT/h, avec un devis gratuit sous 24 heures. Votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Un département compact, entièrement autour de Belfort', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Le Territoire de Belfort est le plus petit département de la région. Cette compacité est un avantage : Belfort et les communes de sa couronne — Valdoie, Offemont, Bavilliers, Danjoutin, Cravanche, Essert — sont proches les unes des autres, ce qui est pris en compte lorsque le regroupement de plusieurs interventions est étudié.',
		'En revanche, le département est éloigné de notre implantation. Nous y intervenons donc sur la base de créneaux réguliers planifiés, plutôt que de passages courts à la demande. C\'est la contrepartie assumée d\'un tarif horaire identique à celui pratiqué à Dijon.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Le tissu professionnel belfortain', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Belfort est une ville industrielle et universitaire. L\'agglomération accueille des activités industrielles, des entreprises et des laboratoires privés, ainsi qu\'un pôle universitaire qui génère un tissu de services et de bureaux. Le centre-ville, autour de la vieille ville et du secteur de la gare, concentre commerces et cabinets.',
		'Les besoins susceptibles de nous être confiés viennent principalement de bureaux d\'études et d\'ingénierie, de PME de services, de cabinets libéraux, de commerces indépendants et de copropriétés. Les demandes portent souvent sur des interventions en soirée, après le départ des équipes, avec des consignes de sécurité propres au site.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', '', $id );
	tfp_seed_set_field( 'recit_3_titre', 'Les locaux que nous entretenons ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Dans le Territoire de Belfort, nos prestations concernent surtout :',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', implode( "\n", array(
		'Bureaux d\'études et d\'ingénierie',
		'Bureaux administratifs de sites industriels',
		'Locaux tertiaires et administratifs universitaires',
		'Commerces de centre-ville',
		'Cabinets et professions libérales',
		'Parties communes de résidences',
	) ), $id );
	tfp_seed_set_field( 'recit_4_titre', 'Sites industriels : un périmètre strictement tertiaire', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'L\'industrie belfortaine est un environnement exigeant en matière de sécurité. Sur ce type de site, notre périmètre est strictement tertiaire : bureaux, open-spaces, salles de réunion, accueil, sanitaires, vestiaires de bureau et circulations administratives. Les zones d\'atelier et de production restent en dehors de notre intervention.',
		'Nous ne réalisons ni nettoyage industriel lourd, ni nettoyage de machines ou de lignes de production, ni traitement chimique, ni intervention en locaux à risque. Les intervenants respectent les consignes d\'accès et de circulation du site, qui sont annexées au cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et déplacements', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Nous y privilégions des créneaux réguliers et des volumes d\'heures regroupés.',
		'Deux passages de 1 h 15 par semaine : open-space, salles de réunion, sanitaires et espace café. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux à Belfort, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage se fait en soirée, après le départ des équipes techniques. Les salles de réunion sont remises en ordre et les consignes de sécurité du site sont respectées.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Sylvain M.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau d\'ingénierie · Belfort', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Interventions en soirée : comment cela s\'organise', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'La majorité des sites belfortains demandent une intervention après la fermeture. Nous formalisons donc l\'accès : remise de clé ou de badge contre décharge écrite, code d\'alarme consigné, procédure de fermeture rappelée par écrit, et interlocuteur à joindre en cas d\'anomalie constatée sur place.',
		'Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %, ce qui est indiqué au devis dès que le créneau le justifie.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Régulier ou ponctuel', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Le contrat régulier est la formule adaptée à ce département : un à trois passages hebdomadaires, volume mensuel fixe, planning convenu à l\'avance. Nous cherchons à maintenir le même intervenant sur le site, ce qui est d\'autant plus important quand des consignes de sécurité s\'appliquent.',
		'En ponctuel, nous intervenons pour les remises en état après travaux, les fins de bail, les ouvertures de local et les grands nettoyages annuels. La date est confirmée au devis en fonction de nos tournées, avec le volume d\'heures estimé.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Démarrage : ce qui se passe après votre accord', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Une fois le devis accepté, l\'organisation du planning est l\'étape qui demande le plus de préparation sur un département éloigné. Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis. Nous vous confirmons alors la date du premier passage et le nom de l\'intervenant recherché pour le site.',
		'Le premier passage se fait en présence d\'Audrey ou avec un point téléphonique dans la journée, pour valider le circuit, les accès et les consignes de sécurité du site. Les premiers passages permettent de vérifier l\'adéquation entre le cahier des charges, le temps prévu et les contraintes des locaux. Si un écart significatif est constaté, Top-Famille Pro échange avec le client et peut proposer une adaptation de l\'organisation ou du volume horaire.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos villes d\'intervention dans le département', $id );
	tfp_seed_set_field( 'locaux_1_texte', '', $id );
	tfp_seed_set_field( 'locaux_1_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Autres communes citées dans ce département', $id );
	tfp_seed_set_field( 'locaux_2_texte', '', $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 5, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Valdoie',
		'Offemont',
		'Bavilliers',
		'Danjoutin',
		'Cravanche',
		'Essert',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Nos prestations dans le département', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Le périmètre de chaque prestation est détaillé dans notre page nettoyage professionnel.',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_3_section', 5, $id );
	tfp_seed_set_field( 'locaux_3_noms', '', $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Départements limitrophes couverts', $id );
	tfp_seed_set_field( 'locaux_4_texte', implode( "\n", array(
		'Départements voisins, également couverts par Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 8, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 3, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Territoire de Belfort', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Le Territoire de Belfort est-il vraiment couvert ?', 'reponse' => 'Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Avez-vous une agence à Belfort ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon, et le numéro affiché est le même partout : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Intervenez-vous sur les sites industriels belfortains ?', 'reponse' => 'Uniquement dans leurs espaces tertiaires : bureaux, salles de réunion, accueil, sanitaires, vestiaires de bureau. Les ateliers et zones de production ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous intervenir après le départ des équipes ?', 'reponse' => 'Oui, c\'est le cas le plus fréquent. L\'accès est formalisé par écrit et les consignes de sécurité du site sont annexées au cahier des charges.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Couvrez-vous Delle, Beaucourt ou Giromagny ?', 'reponse' => 'Ces communes sont examinées au cas par cas, selon la fréquence et le volume. Notre secteur prioritaire est Belfort et sa couronne immédiate.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel est le délai de mise en place ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', '', $id );
	tfp_seed_set_field( 'contact_texte', '', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux dans le département', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement.', $id );
	echo "  ✓ territoire-de-belfort\n";
}

/* ---------------- dijon (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'dijon', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone dijon absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Dijon', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, commerces, cabinets, copropriétés et locations meublées : Top-Famille Pro entretient vos locaux dijonnais depuis son implantation de Saint-Apollinaire, commune limitrophe de Dijon.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Dijon', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Dijon', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro est une entreprise de nettoyage implantée à Saint-Apollinaire, commune limitrophe de Dijon. Nous entretenons bureaux, surfaces de vente, cabinets, parties communes d\'immeubles et locations meublées à Dijon et dans sa première couronne, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Le devis est gratuit et transmis sous 24 heures ; votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Une entreprise implantée à Saint-Apollinaire, aux portes de Dijon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Notre adresse est à Saint-Apollinaire, en périphérie est de Dijon. Nous n\'avons pas de bureau au centre-ville, et nous ne le prétendons pas : ce serait une vitrine sans utilité. Ce qui compte pour vous, c\'est que Dijon fait partie de nos secteurs prioritaires : visite, ajustement de planning ou passage supplémentaire y sont étudiés selon les disponibilités du planning.',
		'Cette proximité fait de Dijon l\'un de nos secteurs prioritaires. Les prestations courtes y sont étudiées au cas par cas, et plusieurs sites peuvent être organisés sur une même matinée.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons à Dijon', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Parmi les professionnels susceptibles de faire appel à Top-Famille Pro à Dijon, on trouve surtout des structures qui n\'ont pas de personnel d\'entretien interne et qui cherchent un prestataire joignable directement, sans centre d\'appels ni intermédiaire :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'PME et sièges d\'entreprise des secteurs tertiaires',
		'Commerces indépendants du centre-ville et des zones commerciales',
		'Cabinets médicaux, dentaires, comptables et juridiques',
		'Syndics et conseils syndicaux de la métropole',
		'Propriétaires bailleurs et gestionnaires de meublés',
		'Associations, agences, coworkings et organismes de formation',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux : le cœur de notre activité dijonnaise', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Un plateau de bureaux se traite dans un ordre précis : vidage des corbeilles, dépoussiérage des surfaces libres, entretien des surfaces de contact courantes, nettoyage des sanitaires, entretien de la cuisine ou du coin café, aspiration puis lavage des sols selon le revêtement. La salle de réunion est remise en ordre : chaises alignées, table nettoyée, tableau effacé si la consigne le prévoit.',
		'Sur les secteurs tertiaires de l\'agglomération, une organisation souvent demandée est un passage avant l\'arrivée des équipes, à une fréquence définie avec vous au cahier des charges. Les moquettes, très présentes dans ces immeubles, font l\'objet d\'un shampooinage périodique chiffré séparément, une à deux fois par an selon la fréquentation.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Commerces, cabinets et copropriétés', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un commerce du centre-ville, le passage se fait avant l\'ouverture : surface de vente, cabines ou zone d\'essayage, sanitaires clients, vitrages intérieurs et abords de la vitrine. Les rues piétonnes imposent des contraintes d\'accès véhicule que nous intégrons au planning plutôt que de les découvrir le premier jour.',
		'Pour les cabinets médicaux et dentaires, le cahier des charges prévoit l\'entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols et des surfaces courantes. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Pour les copropriétés, nous traitons hall, cages d\'escalier, ascenseur, paliers, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Locations meublées et interventions ponctuelles', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Dijon compte de nombreux meublés de courte durée, notamment dans le secteur sauvegardé et autour de la gare. Entre deux séjours, nous assurons le ménage complet, puis, lorsque ces prestations sont prévues au cahier des charges et chiffrées dans le devis, le changement de linge si vous le fournissez, la vérification des consommables et le signalement photographique des dégradations constatées. Le créneau est calé sur vos horaires de départ et d\'arrivée.',
		'En ponctuel, nous intervenons après travaux, en fin de bail, avant l\'ouverture d\'un local, ou pour un grand nettoyage saisonnier. Le tarif horaire reste de 27 € HT/h, avec une estimation du volume d\'heures au devis. Le délai de programmation dépend du planning en cours et vous est indiqué lors de l\'échange.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h à Dijon, comme partout ailleurs en Bourgogne-Franche-Comté, plus 9 € HT/mois de gestion pour un contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %.',
		'Trois passages d\'une heure par semaine dans un plateau de 180 m² : sols, sanitaires, cuisine partagée, salle de réunion remise en ordre. 333 € HT/mois ; 383 € HT le premier mois si les frais de mise en place s\'appliquent.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux en secteur tertiaire dijonnais, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous ouvrons à 9 h et le passage est fait avant : bureaux, vitrine intérieure et espace d\'accueil. En un an, nous n\'avons eu à signaler que deux ajustements, réglés dès la semaine suivante.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Marc D.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Agence immobilière · Dijon centre', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Espaces, tâches et fréquences', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'La fréquence se décide en fonction de la fréquentation, du type de sol et de la nature de l\'activité. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Commerce : 5 à 6 passages par semaine, avant ouverture',
		'Bureaux de 10 à 30 personnes : 3 passages par semaine',
		'Petit bureau ou cabinet : 1 à 2 passages par semaine',
		'Copropriété : 1 passage hebdomadaire, bacs selon collecte',
		'Meublé : à chaque changement de locataire',
		'Vitrages intérieurs et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Horaires, produits et matériel', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Les créneaux pouvant être envisagés à Dijon sont le tôt matin (6 h – 8 h) et la fin de journée (18 h – 20 h). Nous intervenons également en journée pour les copropriétés et les meublés. Les interventions de nuit, le dimanche et les jours fériés sont possibles, avec une majoration de 10 % annoncée au devis.',
		'Les produits et le matériel sont généralement fournis par le client ; toute organisation différente est précisée dans le devis et le cahier des charges. Le matériel est organisé selon le cahier des charges — un code couleur distinct pour les sanitaires et pour les espaces de travail — avec des produits adaptés à chaque revêtement.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Clés, accès et présence sur site', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'La plupart des interventions ont lieu hors présence des occupants. La remise de clé, de badge ou de code se fait donc contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture rappelée dans le cahier des charges. Nous ne conservons aucun accès sans document signé, et la restitution est formalisée de la même manière.',
		'En cas de changement d\'intervenant, la remise des accès est refaite dans les mêmes conditions et vous en êtes informé. Pour les immeubles, les accès aux locaux techniques et à conteneurs sont listés au cahier des charges, avec l\'interlocuteur à joindre en cas d\'anomalie.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références et une période d\'observation sur site. Nous cherchons à confier votre site au même intervenant d\'une semaine sur l\'autre : c\'est la régularité, plus que la longueur de la liste de tâches, qui fait la qualité perçue.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites au remplaçant et vous informons du changement. Nous ne garantissons pas une continuité automatique — personne ne peut le faire honnêtement. Chaque site dispose d\'un cahier de liaison, et un point de suivi permet d\'ajuster ce qui doit l\'être.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Dijon, dans le même bassin géographique. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Chevigny-Saint-Sauveur',
		'Ahuy',
		'Daix',
		'Plombières-lès-Dijon',
		'Sennecey-lès-Dijon',
		'Ruffey-lès-Echirey',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Dijon', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Où êtes-vous exactement installés ?', 'reponse' => 'À Saint-Apollinaire (21850), commune limitrophe de Dijon. Nous n\'avons pas de bureau dans le centre-ville dijonnais : c\'est notre unique implantation pour toute la région.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Intervenez-vous dans le centre historique et les rues piétonnes ?', 'reponse' => 'Oui, y compris pour les commerces et les cabinets installés en zone piétonne. Les contraintes d\'accès véhicule sont intégrées au planning dès la mise en place.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Pouvez-vous passer avant 8 h ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé à Dijon, pour les bureaux comme pour les commerces. Le tôt matin et la fin de journée sont les deux plages généralement retenues.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Y a-t-il des frais de déplacement sur Dijon ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Aurai-je toujours le même intervenant ?', 'reponse' => 'C\'est ce que nous recherchons pour chaque site dijonnais. Ce n\'est pas une garantie : en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous prévenons.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Entretenez-vous les copropriétés de la métropole ?', 'reponse' => 'Oui : halls, cages d\'escalier, ascenseurs, paliers, locaux à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse. Nous travaillons avec des syndics comme avec des conseils syndicaux.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Quel est le délai pour démarrer ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis. Pour une intervention ponctuelle, la date est indiquée lors de l\'échange puis confirmée au devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ dijon\n";
}

/* ---------------- besancon (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'besancon', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone besancon absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Besançon', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, cabinets, commerces du centre historique et parties communes : Top-Famille Pro entretient vos locaux bisontins avec des créneaux réguliers planifiés.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Besançon', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Besançon', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Besançon et dans son agglomération pour l\'entretien de bureaux, de cabinets médicaux et paramédicaux courants, de commerces et de parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Nous n\'avons pas d\'agence bisontine : l\'entreprise est implantée à Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Besançon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Nous intervenons à Besançon depuis notre implantation de Saint-Apollinaire, à environ une heure de route. Nous n\'avons pas d\'agence bisontine, pas de responsable local et pas de numéro de téléphone dédié à la ville : le 06 36 17 63 39 est le même pour tous nos clients, et c\'est Audrey qui répond.',
		'Cette organisation impose une discipline que nous assumons : le regroupement des passages est étudié selon le planning, avec des créneaux convenus à l\'avance. En contrepartie, la prestation est stable, le planning est tenu et l\'intervenant connaît vos locaux. Ce que nous ne proposons pas ici, ce sont les passages courts improvisés — nous préférons le dire avant la signature.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons à Besançon', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Les besoins susceptibles de nous être confiés à Besançon reflètent le profil de la ville : tertiaire, universitaire et libéral. Ce sont surtout des locaux recevant du public ou occupés en journée par des équipes nombreuses, pour lesquels l\'entretien se fait avant l\'arrivée ou après le départ des occupants.',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Cabinets médicaux, dentaires et paramédicaux courants',
		'Bureaux tertiaires et sièges régionaux',
		'Entreprises et laboratoires privés (espaces de bureau uniquement)',
		'Commerces du centre historique',
		'Syndics et copropriétés de l\'agglomération',
		'Propriétaires bailleurs et meublés étudiants',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Cabinets et professions libérales : périmètre et limites', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Les cabinets représentent une part importante de notre activité bisontine. Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges.',
		'Le cahier des charges est écrit espace par espace, avec la fréquence retenue pour chacun et les tâches périodiques distinguées des tâches de chaque passage. Le passage a lieu en dehors des heures de consultation, en début ou en fin de journée, selon l\'organisation que vous préférez. Les consignes de confidentialité y figurent également : aucun dossier n\'est déplacé, ouvert ni trié, et les documents laissés sur un bureau restent exactement là où ils étaient. Les réapprovisionnements, la gestion des consommables et tout contrôle formalisé sont possibles lorsqu\'ils sont prévus dans le cahier des charges et chiffrés dans le devis.',
		'Il s\'agit d\'un entretien de cabinet courant. Nous n\'intervenons pas en bloc opératoire, en salle de soins critiques, en laboratoire d\'analyses, ni dans un environnement soumis à un protocole de bio-nettoyage hospitalier. Si votre besoin relève de ce niveau, une entreprise spécialisée est nécessaire, et nous vous le disons dès le premier échange.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Bureaux et locaux tertiaires', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un plateau de bureaux bisontin, la prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et de l\'espace café, puis l\'aspiration et le lavage des sols. Les salles de réunion sont remises en état après usage.',
		'Dans les locaux d\'une entreprise ou d\'un laboratoire privé, quel que soit le secteur d\'activité concerné, notre périmètre s\'arrête aux espaces de bureau, aux salles de réunion, aux circulations administratives, aux salles de pause et aux sanitaires courants. Les zones techniques, les salles blanches et les espaces sous protocole restent en dehors de notre offre, ce qui est écrit noir sur blanc dans le cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h à Besançon, identique au reste de la région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % la nuit, le dimanche et les jours fériés.',
		'Deux passages de 1 h 15 par semaine : salle d\'attente, deux bureaux de consultation, sanitaires et surfaces courantes. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · cabinet paramédical, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage se fait après le dernier patient et la salle d\'attente est impeccable le matin. Ce qui compte pour nous : la discrétion sur les dossiers et le respect strict de l\'horaire de fermeture.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Hélène F.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Cabinet de kinésithérapie · Besançon', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Commerces du centre historique et immeubles anciens', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Le centre de Besançon, classé au patrimoine mondial, est un environnement bâti ancien : parquets, escaliers en pierre, accès véhicule limité, cours intérieures. Ces contraintes changent la façon de travailler — produits adaptés aux revêtements anciens, matériel transportable à pied, créneau compatible avec la circulation piétonne.',
		'Pour les commerces, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, vitrages intérieurs, abords immédiats de la vitrine. Pour les parties communes d\'immeubles anciens, nous traitons hall, escaliers étage par étage, rampes, paliers et local à conteneurs, avec la sortie des bacs selon le calendrier de collecte local.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fréquences et horaires sur Besançon', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Compte tenu de la distance, nous conseillons ici au moins deux heures par passage, ou un regroupement hebdomadaire. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', implode( "\n", array(
		'Cabinet : 2 à 5 passages par semaine, après le dernier patient',
		'Bureaux : 1 à 3 passages par semaine, matin ou soir',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Meublé : à chaque changement de locataire',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'methode_3_titre', 'Accès aux locaux et confidentialité', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les interventions se font presque toujours en dehors de votre présence. La remise de clé, de badge ou de code s\'effectue contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture précisée par écrit. Aucun accès n\'est conservé sans document signé, et la restitution suit la même formalité.',
		'Dans les cabinets, la confidentialité fait partie de la consigne : les dossiers, écrans et documents ne sont ni déplacés ni manipulés, les bureaux ne sont pas dépoussiérés sous les papiers laissés en place. Ces points figurent dans le cahier des charges et sont rappelés à tout intervenant remplaçant.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Sélection des intervenants, remplacement et suivi', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Les intervenants sont recrutés et suivis par Audrey, avec vérification des références et observation sur site lors des premiers passages. Sur Besançon comme ailleurs, nous cherchons à confier votre site au même intervenant sur la durée : c\'est ce qui permet de repérer ce qu\'une liste de tâches ne dit pas.',
		'En cas d\'absence, de congés ou de départ, nous cherchons un remplacement, lui transmettons les consignes écrites et vous informons du changement. Nous ne promettons pas de continuité garantie. Le cahier de liaison sur site et le point de suivi avec Audrey permettent de suivre la prestation sans avoir à être présent.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de la couronne bisontine. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'École-Valentin',
		'Chalezeule',
		'Thise',
		'Saône',
		'Pirey',
		'Serre-les-Sapins',
		'Beure',
		'Montfaucon',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Besançon', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence ou un responsable à Besançon ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n\'y a ni agence bisontine, ni responsable local, ni numéro de téléphone spécifique à la ville.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Les frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Faites-vous du bio-nettoyage hospitalier ?', 'reponse' => 'Non. Nous assurons l\'entretien courant des locaux : accueil, salle d\'attente, bureaux, sanitaires, sols et surfaces courantes. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Les blocs, salles de soins et laboratoires d\'analyses relèvent d\'entreprises spécialisées.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous intervenir dans un immeuble ancien du centre ?', 'reponse' => 'Oui. Nous adaptons les produits aux revêtements anciens et le matériel à l\'absence d\'accès véhicule, ce qui est pris en compte dès l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Quel volume minimum conseillez-vous à Besançon ?', 'reponse' => 'Au moins deux heures par passage, ou un regroupement hebdomadaire. En dessous, le trajet rend l\'organisation difficile à tenir dans la durée, et nous préférons le dire d\'emblée.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Intervenez-vous à École-Valentin, Chalezeule ou Thise ?', 'reponse' => 'Oui, ces communes de la couronne bisontine sont proches de la ville. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Quel délai pour mettre en place un contrat ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis. La remise des accès est organisée avant le premier passage.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ besancon\n";
}

/* ---------------- dole (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'dole', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone dole absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Dole', $id );
	tfp_seed_set_field( 'hero_lede', 'Commerces du centre historique, bureaux, cabinets et parties communes : Top-Famille Pro entretient vos locaux dolois en régulier ou en ponctuel.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Dole', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Dole', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Dole et dans les communes voisines pour l\'entretien de commerces, de bureaux, de cabinets courants, de parties communes d\'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Dole fait partie de nos secteurs prioritaires dans le Jura. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre position sur le bassin dolois', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Dole fait partie de nos secteurs prioritaires dans le Jura. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Nous n\'avons pas d\'agence à Dole, ni de responsable local. L\'ensemble de l\'organisation — visite, cahier des charges, planning, remplacement, suivi — passe par Audrey, au 06 36 17 63 39. C\'est le même numéro pour tous nos clients, quel que soit leur département.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons à Dole', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Le tissu dolois combine un centre historique commerçant, des professions libérales et une activité industrielle importante à proximité. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Commerces indépendants du centre historique',
		'Bureaux de PME et locaux administratifs',
		'Cabinets comptables, juridiques et paramédicaux courants',
		'Bureaux rattachés aux zones d\'activité de Choisey et Damparis',
		'Syndics et petites copropriétés',
		'Locations meublées et gîtes urbains',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Commerces : le passage avant ouverture', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'C\'est un cas de figure fréquent pour les commerces. Le passage se fait entre 6 h et 8 h 30 : surface de vente aspirée puis lavée, sanitaires clients, comptoir et caisse dépoussiérés, vitrages intérieurs et abords de la vitrine, sortie des cartons et des déchets. La réserve est traitée une fois par semaine, souvent en fin de semaine.',
		'Les commerces du centre historique demandent une attention particulière aux revêtements — parquets, carrelages anciens, pierre — et aux contraintes d\'accès des rues étroites. Ces éléments sont relevés lors de la visite et intégrés au cahier des charges, avec le choix des produits adaptés à chaque sol.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Bureaux, cabinets et locaux administratifs', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour les bureaux dolois, la prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, les sanitaires, l\'espace café ou la cuisine, puis l\'aspiration et le lavage des sols. Les salles de réunion sont remises en ordre après usage.',
		'Pour les cabinets — comptables, juridiques, paramédicaux courants — le cahier des charges prévoit l\'entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires et des sols, avec une consigne de confidentialité stricte : les dossiers et documents laissés sur les bureaux ne sont ni déplacés ni manipulés.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Copropriétés, meublés et interventions ponctuelles', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Pour un immeuble, le circuit est écrit dans le cahier des charges : hall, boîtes aux lettres, sol et vitrage de la porte d\'entrée, cage d\'escalier étage par étage, rampes, paliers, local à conteneurs, sortie et rentrée des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis. Le conseil syndical reçoit un point de suivi.',
		'Pour les meublés, nous intervenons entre deux séjours : ménage complet ; le changement de linge, la vérification des consommables et le signalement photographique des dégradations sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis. En ponctuel, nous traitons les remises en état après travaux, les fins de bail et les préparations de local avant ouverture.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, comme dans le reste de la région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Dole fait partie de nos secteurs prioritaires dans le Jura. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % pour les interventions de nuit, le dimanche et les jours fériés.',
		'Un passage d\'une heure avant ouverture, du mardi au samedi : surface de vente, sanitaires clients, réserve une fois par semaine. 441 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · commerce en centre-ville, 16 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'J\'ouvre à 9 h 30 et tout est fait avant mon arrivée, y compris la vitrine côté intérieur. Le samedi, le passage est un peu plus long, comme convenu au départ.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Isabelle G.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Boutique de prêt-à-porter · Dole', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences, horaires et matériel', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges , après visite et selon la fréquentation et les revêtements :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Commerce : 5 à 6 passages par semaine, avant ouverture',
		'Bureaux : 1 à 3 passages par semaine',
		'Cabinet : 1 à 3 passages par semaine, en fin de journée',
		'Copropriété : 1 passage hebdomadaire, bacs selon collecte',
		'Meublé : à chaque changement de locataire',
		'Vitrages intérieurs et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Clés, accès et sites industriels voisins', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'La plupart des interventions se déroulent hors de votre présence : la clé, le badge ou le code est remis contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture rappelée par écrit. Aucun accès n\'est conservé sans document signé, et tout changement d\'intervenant donne lieu à une nouvelle remise formalisée.',
		'Le bassin dolois compte des activités industrielles. Sur ce type de site, notre périmètre est strictement tertiaire : bureaux administratifs, accueil, salles de réunion, vestiaires de bureau et sanitaires. Nous ne réalisons ni nettoyage industriel lourd, ni traitement chimique, ni intervention en zone réglementée.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, avec vérification des références et une période d\'observation sur site. Sur Dole, nous cherchons à confier chaque site au même intervenant d\'une semaine sur l\'autre : pour un commerce ouvert six jours sur sept, la régularité de la personne compte autant que la liste des tâches.',
		'En cas d\'absence, de congés ou de départ, nous cherchons un remplacement, transmettons les consignes écrites au remplaçant et vous informons du changement. Aucune continuité automatique n\'est promise. Le cahier de liaison sur site et le point de suivi permettent d\'ajuster la prestation au fil des semaines.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Mise en place d\'une prestation doloise', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Le premier passage a lieu avec le circuit défini lors de l\'échange préalable, et nous mesurons le temps réel par espace. Les consignes s\'affinent ensuite au fil des passages — ordre de passage, points sensibles, éléments à ne pas déplacer, emplacement du matériel laissé sur site. Un point téléphonique ou sur place avec Audrey est organisé selon les modalités de suivi définies avec le client.',
		'Les premiers passages permettent de vérifier l\'adéquation entre le cahier des charges, le temps prévu et les contraintes des locaux. Si un écart significatif est constaté, Top-Famille Pro échange avec le client et peut proposer une adaptation de l\'organisation ou du volume horaire. Si nous avons sous-estimé le temps nécessaire, nous vous le disons et nous corrigeons le devis : c\'est plus honnête que de réduire discrètement la liste des tâches pour tenir le budget annoncé.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteur de la gare',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes du bassin dolois. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Choisey',
		'Tavaux',
		'Damparis',
		'Foucherans',
		'Authume',
		'Rochefort-sur-Nenon',
		'Crissey',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Dole', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Pouvez-vous passer avant l\'ouverture de ma boutique ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé : passage entre 6 h et 8 h 30, du mardi au samedi selon vos jours d\'ouverture, avec un renfort possible les jours de forte affluence.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Avez-vous une agence à Dole ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Le numéro affiché est le même partout : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Les frais de déplacement sont-ils importants pour Dole ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Intervenez-vous à Choisey, Tavaux ou Damparis ?', 'reponse' => 'Oui, ces communes appartiennent au bassin dolois. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Entretenez-vous les sites industriels du secteur ?', 'reponse' => 'Uniquement leurs espaces tertiaires : bureaux, accueil, salles de réunion, vestiaires de bureau et sanitaires. Le nettoyage industriel lourd et le traitement chimique ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Faut-il un engagement de durée ?', 'reponse' => 'Le devis est gratuit et sans engagement. Pour la prestation, le volume d\'heures et la fréquence peuvent être ajustés en cours de route, et les conditions d\'arrêt sont précisées au devis avant signature — préavis écrit.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ dole\n";
}

/* ---------------- lons-le-saunier (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'lons-le-saunier', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone lons-le-saunier absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Lons-le-Saunier', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, cabinets, commerces et parties communes : Top-Famille Pro entretient vos locaux à Lons-le-Saunier avec des créneaux réguliers planifiés à l\'avance.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Lons-le-Saunier', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Lons-le-Saunier', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Lons-le-Saunier et dans les communes proches pour l\'entretien de bureaux, de cabinets courants, de commerces de centre-ville, de parties communes d\'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon ; votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Lons-le-Saunier', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Lons-le-Saunier est la préfecture du Jura et l\'un de nos secteurs éloignés. Nous y intervenons sur la base de créneaux réguliers planifiés à l\'avance, dont le regroupement est étudié selon le planning. C\'est ce qui rend la prestation viable au tarif régional de 27 € HT/h, sans surcoût horaire lié à la distance.',
		'Nous n\'avons ni agence, ni responsable local, ni numéro spécifique à la ville. La visite, le cahier des charges, le planning, la recherche de remplacement et le suivi mensuel passent par Audrey. Sur ce secteur, nous ne proposons pas de passage improvisé de trente minutes : ce serait une promesse intenable, autant le dire avant.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Lons-le-Saunier est une ville d\'administrations, de sièges de coopératives et de commerces, avec un centre-ville dense en professions libérales. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Cabinets comptables, juridiques et de conseil',
		'Bureaux de PME et locaux administratifs',
		'Commerces indépendants du centre-ville',
		'Cabinets paramédicaux courants',
		'Syndics et petites copropriétés',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et cabinets : la prestation détaillée', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'La prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes — poignées, interrupteurs, rampes —, l\'entretien complet des sanitaires et de l\'espace café, puis l\'aspiration et le lavage des sols selon leur nature. La salle d\'accueil est remise en ordre à chaque passage.',
		'Dans les cabinets, la confidentialité est une consigne écrite : les dossiers, écrans et documents ne sont ni déplacés ni manipulés, et les surfaces encombrées de papiers ne sont pas dépoussiérées sous ceux-ci. Ces points figurent au cahier des charges et sont rappelés à tout intervenant remplaçant avant son premier passage.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Commerces, copropriétés et meublés', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un commerce du centre-ville, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine, sortie des déchets. La réserve est traitée périodiquement, généralement une fois par semaine, selon un rythme convenu au devis.',
		'Pour un immeuble, le circuit est écrit : hall, boîtes aux lettres, cage d\'escalier étage par étage, rampes, paliers, local à conteneurs, sortie et rentrée des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis. Pour les meublés, nous intervenons entre deux séjours, avec ménage complet, le signalement photographique des dégradations étant possible lorsque prévu dans le cahier des charges et chiffré dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Fréquences et horaires adaptés à la distance', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Sur ce secteur, nous conseillons au moins deux heures par passage ou un regroupement hebdomadaire. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', implode( "\n", array(
		'Cabinet ou bureau : 1 à 2 passages par semaine',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Locaux administratifs : 1 à 3 passages par semaine',
		'Meublé : à chaque changement de locataire',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h comme partout en région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Nous y privilégions des créneaux réguliers et des volumes d\'heures regroupés.',
		'Deux heures par semaine, le vendredi en fin de journée : bureaux, salle d\'accueil, sanitaires, espace café. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · cabinet comptable, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage du vendredi soir nous permet de retrouver des bureaux nets le lundi matin. Les dossiers ne sont jamais déplacés, ce qui était notre condition principale.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Pascal R.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Cabinet d\'expertise comptable · Lons-le-Saunier', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Agroalimentaire et thermalisme : notre périmètre', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Le bassin lédonien accueille des sièges et des sites de la filière agroalimentaire, notamment fromagère, ainsi qu\'une activité thermale. Sur ces établissements, notre intervention porte exclusivement sur les espaces compatibles avec notre offre : bureaux administratifs, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives.',
		'Nous ne réalisons pas de nettoyage agroalimentaire spécialisé, de nettoyage de lignes de transformation, de traitement chimique ni d\'intervention en zone soumise à un protocole sanitaire particulier. Ce périmètre est écrit dans le cahier des charges, avec un plan si nécessaire, pour éviter tout malentendu à la première intervention.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Clés, accès et interventions hors présence', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'La quasi-totalité de nos interventions à Lons-le-Saunier se déroule en dehors de vos heures de présence. L\'accès est donc formalisé : remise de clé, de badge ou de code contre décharge écrite, code d\'alarme consigné, procédure de fermeture rappelée par écrit et interlocuteur à joindre en cas d\'anomalie constatée sur place.',
		'Aucun accès n\'est conservé sans document signé, et la restitution est formalisée de la même manière. En cas de changement d\'intervenant, la remise des accès est refaite dans les mêmes conditions et vous en êtes informé avant le passage concerné.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références et observation sur site lors des premiers passages. Nous cherchons à confier chaque site au même intervenant sur la durée : sur un secteur éloigné, la stabilité de la personne est ce qui évite les allers-retours et les rappels de consignes.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites et vous informons du changement — sans promettre une continuité garantie. Le cahier de liaison sur site et le point de suivi avec Audrey servent de fil conducteur, sans que vous ayez à être présent.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Matériel, produits et consommables', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Les produits et le matériel sont généralement fournis par le client ; toute organisation différente est précisée dans le devis et le cahier des charges. Vous pouvez imposer vos propres références — c\'est fréquent dans les cabinets et cela ne pose aucun problème dès lors que c\'est noté au cahier des charges. Le matériel est dédié par zone, avec un code couleur distinct pour les sanitaires, afin d\'éviter tout transfert entre espaces.',
		'Les consommables — papier, savon, sacs — sont gérés par vous ou par nous, au choix. Dans le second cas, ils sont refacturés au prix d\'achat, sans marge, et le cahier de liaison signale les niveaux bas avant la rupture plutôt qu\'après. Sur un secteur où nous ne passons qu\'une ou deux fois par semaine, cette anticipation compte.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteur de la gare',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes voisines de Lons-le-Saunier. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Montmorot',
		'Perrigny',
		'Macornay',
		'Courlaoux',
		'Villeneuve-sous-Pymont',
		'Conliège',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Lons-le-Saunier', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence à Lons-le-Saunier ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n\'y a ni agence, ni responsable local, ni numéro spécifique à la ville : c\'est le 06 36 17 63 39 partout.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Les frais de déplacement sont-ils élevés ici ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles sont calculées et affichées au devis avant signature.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Un seul passage hebdomadaire est-il suffisant ?', 'reponse' => 'Pour un cabinet ou un petit bureau, souvent oui. Nous définissons la fréquence après échange sur la fréquentation, le type de sols et la nature de l\'activité, plutôt qu\'à partir d\'un forfait standard.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Intervenez-vous à Montmorot ou Perrigny ?', 'reponse' => 'Oui, ces communes voisines sont proches de Lons-le-Saunier. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Entretenez-vous les sites agroalimentaires du secteur ?', 'reponse' => 'Uniquement leurs bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Le nettoyage agroalimentaire spécialisé et les zones de transformation ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel délai pour démarrer un contrat régulier ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ lons-le-saunier\n";
}

/* ---------------- nevers (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'nevers', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone nevers absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Nevers', $id );
	tfp_seed_set_field( 'hero_lede', 'Parties communes, bureaux administratifs, commerces et cabinets : Top-Famille Pro entretient vos locaux nivernais avec des créneaux hebdomadaires fixes.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Nevers', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Nevers', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Nevers et dans son agglomération pour l\'entretien de parties communes d\'immeubles, de bureaux administratifs, de commerces de centre-ville, de cabinets courants et de locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Nevers', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Nevers fait partie de nos secteurs éloignés depuis notre implantation de Saint-Apollinaire. Nous y intervenons donc selon un principe simple : des créneaux réguliers, convenus à l\'avance, avec des volumes d\'heures suffisants pour justifier le déplacement. C\'est ce qui permet de tenir le tarif régional de 27 € HT/h sans dégrader la régularité.',
		'Nous n\'avons pas d\'agence à Nevers, pas de responsable local et pas de numéro nivernais. Tout passe par Audrey, au 06 36 17 63 39. Nous ne promettons pas d\'intervention en urgence sur ce secteur : si votre besoin est immédiat, nous vous répondrons franchement selon nos disponibilités réelles.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels et structures que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Nevers est une ville de services et d\'administrations, avec une forte proportion d\'habitat collectif. Nos interventions se répartissent entre :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Syndics de copropriété et conseils syndicaux',
		'Bureaux administratifs et locaux de collectivités',
		'Commerces indépendants du centre-ville',
		'Cabinets et professions libérales',
		'Locaux associatifs et organismes de formation',
		'Bureaux rattachés aux zones d\'activité de l\'agglomération',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Parties communes : le circuit détaillé', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'C\'est une prestation fréquemment étudiée pour les copropriétés. Le cahier des charges décrit le circuit exact : hall d\'entrée, sol et vitrage de la porte, boîtes aux lettres, cage d\'escalier étage par étage, rampes et plinthes, paliers, cabine et miroir d\'ascenseur, local à conteneurs et abords immédiats de l\'immeuble.',
		'La sortie et la rentrée des bacs sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis ; les jours retenus y sont inscrits. Nous distinguons les tâches faites à chaque passage de celles réalisées périodiquement — vitrages de cage d\'escalier, plinthes, local à vélos — pour éviter les malentendus entre le syndic, le conseil syndical et les résidents.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Bureaux, commerces et cabinets', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour les bureaux administratifs, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, les sanitaires, l\'espace café, puis l\'aspiration et le lavage des sols. Les salles de réunion et les espaces d\'accueil du public sont remis en ordre à chaque passage.',
		'Pour les commerces du centre-ville, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs. Pour les cabinets, le cahier des charges prévoit l\'entretien courant de la salle d\'attente, de l\'accueil, des bureaux et des sanitaires, avec une consigne écrite de confidentialité sur les dossiers laissés en place.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Fréquences et organisation du planning', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Compte tenu de la distance, l\'organisation nivernaise privilégie la régularité sur la souplesse. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', implode( "\n", array(
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Bureaux administratifs : 1 à 2 passages par semaine',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Cabinet : 1 à 2 passages par semaine',
		'Grand nettoyage annuel de parties communes : sur devis',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, identique au reste de la région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Nous y privilégions des créneaux réguliers pouvant être envisagés selon le planning, avec des volumes d\'heures regroupés.',
		'Deux heures par semaine : hall, cage d\'escalier, ascenseur, local à conteneurs et sortie des bacs. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · copropriété, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous avions des retards de passage avec notre ancien prestataire. Depuis, le créneau du mardi est tenu et le cahier de liaison nous sert de compte rendu au conseil syndical.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Michèle A.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Résidence de centre-ville · Nevers', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Accès aux immeubles et aux locaux', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Pour les copropriétés, les accès nécessaires sont listés au cahier des charges : porte d\'entrée, local à conteneurs, local technique éventuel, ascenseur. Les clés ou badges sont remis contre décharge écrite par le syndic ou le conseil syndical, et restitués selon la même formalité en fin de contrat.',
		'Pour les bureaux et commerces, la remise de clé, de badge ou de code s\'accompagne du code d\'alarme et de la procédure de fermeture, consignés par écrit. Aucun accès n\'est conservé sans document signé, et tout changement d\'intervenant donne lieu à une nouvelle remise formalisée dont vous êtes informé.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Sélection des intervenants, remplacement et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation lors des premiers passages. Sur un immeuble, la stabilité de l\'intervenant compte particulièrement : c\'est en revenant chaque semaine que l\'on remarque une ampoule grillée, un encombrant déposé dans le local ou une porte qui ferme mal.',
		'En cas d\'absence, de congés ou de départ, nous cherchons un remplacement, lui transmettons les consignes écrites et vous informons du changement. Aucune continuité automatique n\'est garantie. Le cahier de liaison, laissé sur site, sert de trace pour le syndic comme pour le conseil syndical.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Régulier ou ponctuel : ce que nous pouvons tenir', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'L\'entretien régulier constitue l\'essentiel de notre activité nivernaise : un à deux passages hebdomadaires, volume mensuel fixe, planning connu à l\'avance et tarif prévisible. C\'est le format qui fonctionne sur ce secteur, et celui pour lequel nous nous engageons sans réserve.',
		'En ponctuel, nous intervenons pour les remises en état après travaux, les fins de bail et les grands nettoyages annuels de parties communes. La date est confirmée au devis en fonction de nos tournées : nous ne nous engageons pas sur un délai serré, mais la date annoncée est tenue.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Ce qui figure au devis', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Pour une copropriété, s\'ajoute le détail du circuit étage par étage et le calendrier de sortie des bacs. Rien n\'apparaît après signature : toute prestation supplémentaire fait l\'objet d\'un devis complémentaire que vous validez avant intervention. Aucun engagement de durée n\'est demandé, et l\'arrêt se fait avec un simple préavis écrit.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteur de la gare',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de l\'agglomération de Nevers. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Varennes-Vauzelles',
		'Fourchambault',
		'Marzy',
		'Coulanges-lès-Nevers',
		'Challuy',
		'Garchizy',
		'Sermoise-sur-Loire',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Nevers', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous vraiment à Nevers depuis la Côte-d\'Or ?', 'reponse' => 'Oui, sur la base de créneaux réguliers planifiés à l\'avance. C\'est un secteur éloigné : nous y travaillons en régularité, pas en urgence, et nous le disons clairement avant tout engagement.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Le tarif est-il majoré à Nevers ?', 'reponse' => 'Le taux horaire reste de 27 € HT/h. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Travaillez-vous avec les syndics de copropriété ?', 'reponse' => 'Oui, c\'est une prestation fréquemment étudiée ici : halls, cages d\'escalier, ascenseurs, locaux à conteneurs et gestion des bacs selon le calendrier de collecte.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous intervenir en urgence ?', 'reponse' => 'Rarement sur ce secteur, et nous préférons le dire plutôt que de promettre. Pour une intervention ponctuelle, nous confirmons une date réaliste au devis, en fonction de nos tournées.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous à Varennes-Vauzelles ou Fourchambault ?', 'reponse' => 'Oui, ces communes de l\'agglomération sont proches de Nevers. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Comment savoir ce qui a été fait pendant le passage ?', 'reponse' => 'Chaque site dispose d\'un cahier de liaison où l\'intervenant note le travail réalisé et les points à signaler. Un point de suivi avec Audrey complète ce suivi.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ nevers\n";
}

/* ---------------- vesoul (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'vesoul', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone vesoul absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Vesoul', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux administratifs, commerces, cabinets et parties communes : Top-Famille Pro entretient vos locaux vésuliens, y compris en dehors des heures d\'ouverture.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Vesoul', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Vesoul', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Vesoul et dans son agglomération pour l\'entretien de bureaux administratifs, de commerces, de cabinets courants et de parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon, et votre interlocutrice est Audrey, au 06 36 17 63 39. Devis gratuit sous 24 heures.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Vesoul', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Vesoul fait partie de nos secteurs éloignés : nous y intervenons sur créneaux réguliers planifiés, dont le regroupement est étudié selon le planning, avec des volumes d\'heures suffisants pour rendre le déplacement soutenable. Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Nous n\'avons ni agence vésulienne, ni responsable local, ni numéro dédié à la Haute-Saône. Visite ou échange détaillé, cahier des charges, planning, remplacement et suivi mensuel passent par Audrey. C\'est le même interlocuteur pour un client de Vesoul que pour un client de Dijon.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Vesoul associe des administrations, un centre-ville commerçant et des zones d\'activité industrielles et logistiques importantes à l\'échelle du département. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Bureaux administratifs et locaux tertiaires',
		'Bureaux rattachés aux sites logistiques et industriels',
		'Commerces indépendants du centre-ville',
		'Cabinets et professions libérales',
		'Parties communes de résidences',
		'Locaux associatifs et de formation',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et locaux tertiaires', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'La prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et du coin cuisine, puis l\'aspiration et le lavage des sols selon leur nature. L\'accueil et les salles de réunion sont remis en ordre à chaque passage.',
		'Une part importante de nos interventions vésuliennes concerne des bureaux rattachés à des sites d\'exploitation. Le cahier des charges délimite précisément le périmètre : bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives — avec un plan quand la configuration le justifie.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Sites logistiques et industriels : ce que nous ne faisons pas', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Notre intervention s\'arrête à la porte des zones d\'exploitation. Nous ne réalisons pas d\'entretien d\'entrepôt en activité, de nettoyage de machines ou de lignes de production, de nettoyage industriel lourd, de traitement chimique ni d\'intervention en locaux à risque. Cette limite est annoncée dès le premier échange, avant toute visite.',
		'Ce n\'est pas une réserve de principe mais une question de compétence et d\'équipement : ces prestations exigent des protocoles, du matériel et des habilitations spécifiques que nous n\'avons pas. Mieux vaut un périmètre restreint et tenu qu\'une promesse large qui se solde par une prestation approximative.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Commerces, cabinets et parties communes', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Pour un commerce du centre-ville, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine. La réserve est traitée périodiquement selon un rythme fixé au devis, généralement une fois par semaine.',
		'Pour les cabinets, le cahier des charges prévoit l\'entretien courant de la salle d\'attente, de l\'accueil, des bureaux et des sanitaires, avec consigne écrite de confidentialité. Pour les immeubles, nous traitons hall, cage d\'escalier, rampes, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, comme partout en région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % pour les interventions de nuit, le dimanche et les jours fériés.',
		'Deux passages de 1 h 15 par semaine, après 18 h, accès par badge : espaces de travail, accueil, sanitaires, coin cuisine. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux administratifs, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'L\'intervention se fait en soirée avec un badge, sans que personne soit présent. La procédure de fermeture est respectée et nous n\'avons jamais eu d\'alarme déclenchée par erreur.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Laurent C.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau administratif · Vesoul', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences et créneaux hors horaires', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'La majorité de nos prestations vésuliennes se déroule en dehors des heures d\'ouverture. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Bureaux : 1 à 3 passages par semaine, après 18 h',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Cabinet : 1 à 2 passages par semaine, en fin de journée',
		'Parties communes : 1 passage hebdomadaire à créneau régulier',
		'Grand nettoyage périodique : sur devis séparé',
		'Vitrages et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Badges, alarmes et procédure de fermeture', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Intervenir hors présence suppose une organisation d\'accès rigoureuse. La clé ou le badge est remis contre décharge écrite ; le code d\'alarme est consigné, la procédure d\'armement et de fermeture est rappelée dans le cahier des charges, et un interlocuteur est identifié en cas d\'anomalie constatée sur place.',
		'Aucun accès n\'est conservé sans document signé, et la restitution suit la même formalité. En cas de changement d\'intervenant, la remise est refaite dans les mêmes conditions et vous en êtes informé avant le passage concerné : c\'est le point sur lequel les incidents sont les plus fréquents dans ce métier, donc celui que nous formalisons le plus.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références et observation sur site lors des premiers passages. Sur un site accessible par badge, en soirée, la stabilité de l\'intervenant est encore plus importante qu\'ailleurs : elle évite de reprendre à zéro les consignes d\'accès et de fermeture.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites et vous informons du changement, sans promettre une continuité automatique. Le cahier de liaison et le point de suivi avec Audrey permettent de suivre la prestation à distance.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Consommables et fournitures', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Sur un site où nous intervenons en soirée, en dehors de votre présence, la gestion des consommables devient un vrai sujet : personne ne veut découvrir un distributeur vide un lundi matin. Papier, savon et sacs peuvent donc être gérés par vous ou par nous, selon ce qui vous arrange.',
		'Si nous nous en chargeons, ils sont refacturés au prix d\'achat, sans marge, et le cahier de liaison signale les niveaux bas avant la rupture. Le matériel, lui, est fourni par nos soins et dédié par zone — code couleur distinct pour les sanitaires — sauf si votre site impose ses propres références, ce qui est alors inscrit au cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de la couronne vésulienne. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Navenne',
		'Vaivre-et-Montoille',
		'Pusey',
		'Noidans-lès-Vesoul',
		'Échenoz-la-Méline',
		'Frotey-lès-Vesoul',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Vesoul', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Pouvez-vous intervenir en dehors des horaires d\'ouverture ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé : passage en soirée ou tôt le matin, avec badge ou clé remis contre décharge écrite et procédure de fermeture consignée.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Avez-vous une agence en Haute-Saône ?', 'reponse' => 'Non. L\'entreprise est domiciliée à Saint-Apollinaire, en Côte-d\'Or : c\'est sa seule adresse, et le 06 36 17 63 39 est le seul numéro, quel que soit votre département.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Entretenez-vous les entrepôts logistiques ?', 'reponse' => 'Non. Nous intervenons dans leurs bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les zones d\'exploitation et les machines ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Des indemnités kilométriques peuvent-elles s\'ajouter en Haute-Saône ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse exacte, du planning et des conditions d\'intervention. Elles sont calculées et précisées dans le devis avant toute validation.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous à Navenne ou Vaivre-et-Montoille ?', 'reponse' => 'Oui, ces communes de la couronne vésulienne sont proches de Vesoul. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Les interventions de nuit sont-elles majorées ?', 'reponse' => 'Oui, de 10 %, comme le dimanche et les jours fériés.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ vesoul\n";
}

/* ---------------- chalon-sur-saone (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'chalon-sur-saone', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone chalon-sur-saone absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, bureaux d\'études, commerces, cabinets et copropriétés : Top-Famille Pro entretient vos locaux du Grand Chalon, en régulier ou en ponctuel.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Chalon-sur-Saône et dans les communes du Grand Chalon pour l\'entretien de bureaux, de commerces, de cabinets courants, de parties communes d\'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement sur le Grand Chalon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Chalon-sur-Saône se situe sur l\'axe autoroutier depuis notre implantation de Saint-Apollinaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Nous n\'avons pas d\'agence à Chalon, pas de responsable local et pas de numéro dédié. La visite, le cahier des charges, le planning, la recherche de remplacement et le point de suivi passent par Audrey, au 06 36 17 63 39, comme pour tous nos clients de la région.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Le tissu chalonnais est industriel et tertiaire, avec un centre-ville commerçant dense. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Bureaux d\'études et PME industrielles (espaces tertiaires)',
		'Sièges d\'entreprise et bureaux de services',
		'Commerces indépendants du centre-ville',
		'Cabinets comptables, juridiques et paramédicaux courants',
		'Syndics et copropriétés urbaines',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et espaces tertiaires industriels', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Pour un plateau chalonnais, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et de l\'espace café, puis l\'aspiration et le lavage des sols. La remise en ordre des salles de réunion est prévue lorsque le cahier des charges le précise.',
		'Une part des demandes concerne des bureaux d\'études ou des sièges rattachés à des sites de production. Le cahier des charges délimite alors clairement le périmètre tertiaire — bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires — en excluant les ateliers et les zones d\'exploitation, qui relèvent d\'entreprises spécialisées.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Commerces du centre-ville et pics d\'affluence', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un commerce chalonnais, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine, sortie des cartons. La réserve est traitée périodiquement, selon un rythme convenu au devis plutôt qu\'au coup par coup.',
		'Le centre-ville connaît des pics d\'affluence réguliers, notamment les jours de marché et lors des animations commerçantes. Un passage supplémentaire peut être ajouté ces jours-là : il est chiffré séparément au même tarif horaire, sans modifier le contrat régulier en place. C\'est plus lisible qu\'un forfait gonflé toute l\'année.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Cabinets, copropriétés et meublés', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sur les dossiers laissés en place sont annexées au cahier des charges.',
		'Pour les copropriétés, le circuit est décrit au cahier des charges : hall, cage d\'escalier étage par étage, rampes, paliers, ascenseur, local à conteneurs, sortie et rentrée des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis. Pour les meublés, nous intervenons entre deux séjours, le signalement photographique des dégradations étant possible lorsque prévu dans le cahier des charges et chiffré dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, comme dans le reste de la région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Trois passages d\'une heure par semaine : open-space, bureaux individuels, sanitaires, espace café et salle de réunion. 333 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Trois passages par semaine tôt le matin, avant l\'arrivée des équipes. La salle de réunion est toujours remise en ordre, ce qui nous évite de le faire nous-mêmes avant les rendez-vous.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Damien P.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau d\'études · Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences et horaires', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges , après visite et selon la fréquentation et les revêtements :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Bureaux de 10 à 30 personnes : 3 passages par semaine',
		'Petit bureau ou cabinet : 1 à 2 passages par semaine',
		'Commerce : 4 à 6 passages par semaine, avant ouverture',
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Meublé : à chaque changement de locataire',
		'Vitrages intérieurs et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Clés, accès et sécurité des locaux', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Nos interventions se déroulent le plus souvent hors de votre présence. La remise de clé, de badge ou de code se fait contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture rappelée dans le cahier des charges. Aucun accès n\'est conservé sans document signé.',
		'Sur les sites industriels, les consignes de circulation et de sécurité propres à l\'établissement sont annexées au cahier des charges et rappelées à chaque intervenant, y compris aux remplaçants. En cas de changement d\'intervenant, la remise des accès est refaite et vous en êtes informé au préalable.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, avec vérification des références et une période d\'observation sur site. Nous cherchons à confier chaque site chalonnais au même intervenant d\'une semaine sur l\'autre : pour un commerce ouvert six jours sur sept comme pour un bureau d\'études, c\'est la régularité qui fait la qualité perçue.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites au remplaçant et vous informons du changement. Nous ne promettons pas de continuité garantie. Le cahier de liaison sur site et le point de suivi permettent d\'ajuster la prestation dans le temps.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Mise en place et premiers passages', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Le démarrage suit une trame simple, sans calendrier imposé. Les premiers passages permettent de vérifier l\'adéquation entre le cahier des charges, le temps prévu et les contraintes des locaux. Si un écart significatif est constaté, Top-Famille Pro échange avec le client et peut proposer une adaptation de l\'organisation ou du volume horaire. Les consignes s\'affinent en parallèle : ordre de passage, points sensibles, éléments à ne pas déplacer, emplacement du matériel laissé sur site.',
		'Un point est ensuite organisé avec Audrey, par téléphone ou sur place, selon les modalités de suivi définies avec le client. Si le volume d\'heures est mal calibré, nous corrigeons le devis dans un sens ou dans l\'autre plutôt que de laisser la prestation se dégrader. Toute évolution de l\'organisation ou du volume horaire est discutée avec vous avant d\'être appliquée et fait l\'objet d\'un devis actualisé.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes du Grand Chalon. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Saint-Rémy',
		'Champforgeuil',
		'Saint-Marcel',
		'Châtenoy-le-Royal',
		'Fragnes-La Loyère',
		'Lux',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Chalon-sur-Saône', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence à Chalon-sur-Saône ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Le numéro est le même pour tous nos clients : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Intervenez-vous dans les zones d\'activité au nord de la ville ?', 'reponse' => 'Oui, pour les espaces tertiaires : bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les ateliers et zones d\'exploitation ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Un passage supplémentaire les jours de marché est-il possible ?', 'reponse' => 'Oui, pour les commerces. Il est chiffré séparément au même tarif de 27 € HT/h, sans modifier le contrat régulier en place.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Les frais de déplacement sont-ils élevés ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous à Saint-Rémy ou Champforgeuil ?', 'reponse' => 'Oui, ces communes du Grand Chalon sont proches de la ville. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel délai pour démarrer ?', 'reponse' => 'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ chalon-sur-saone\n";
}

/* ---------------- macon (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'macon', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone macon absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Mâcon', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, cabinets, commerces et locations meublées : Top-Famille Pro entretient vos locaux mâconnais avec un planning régulier et un tarif unique.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Mâcon', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Mâcon', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Mâcon et dans son agglomération pour l\'entretien de bureaux, de cabinets courants, de commerces, de parties communes d\'immeubles et de locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon ; votre interlocutrice est Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Mâcon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Mâcon est le secteur le plus au sud de notre zone d\'intervention en Saône-et-Loire. Nous y travaillons sur des créneaux réguliers convenus à l\'avance, dont le regroupement est étudié selon le planning, ce qui rend le déplacement soutenable et permet de maintenir le tarif régional de 27 € HT/h.',
		'Nous n\'avons ni agence mâconnaise, ni responsable local, ni numéro spécifique. Tout passe par Audrey : la visite ou l\'échange détaillé préalable, le cahier des charges, le planning, la recherche de remplacement et le point de suivi. C\'est le même fonctionnement pour un client mâconnais que pour un client dijonnais.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Mâcon est une préfecture de commerce et de services, marquée par la logistique liée à l\'axe autoroutier et par la filière viticole du Mâconnais. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Cabinets de conseil, juridiques et comptables',
		'Bureaux de PME et sièges locaux',
		'Commerces indépendants du centre-ville',
		'Bureaux rattachés aux zones logistiques',
		'Espaces d\'accueil et de dégustation de domaines et maisons de négoce',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et cabinets : la prestation détaillée', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'La prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et de l\'espace café, puis l\'aspiration et le lavage des sols selon leur nature. Les salles de réunion et de réception clients sont remises en ordre à chaque passage.',
		'Dans les cabinets, la confidentialité est une consigne écrite : dossiers, écrans et documents ne sont ni déplacés ni manipulés. Pour les cabinets recevant du public, la salle d\'attente, l\'accueil et les surfaces courantes font l\'objet d\'un entretien courant selon le cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Commerces, meublés et tourisme', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un commerce mâconnais, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords immédiats de la vitrine. La réserve est traitée périodiquement, selon un rythme fixé au devis.',
		'L\'activité touristique du Mâconnais génère une demande soutenue sur les locations meublées, surtout en haute saison. Nous intervenons entre deux séjours : ménage complet ; le changement de linge, la vérification des consommables et le signalement photographique des dégradations sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis. En période chargée, les créneaux se réservent à l\'avance.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Viticulture et logistique : notre périmètre', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Les domaines et maisons de négoce du Mâconnais reçoivent du public : nous entretenons leurs espaces d\'accueil, de dégustation et de réception comme des espaces ouverts au public, ainsi que leurs bureaux, salles de réunion et sanitaires. Nous n\'intervenons pas dans les caves d\'élaboration, les chais ni les zones de conditionnement.',
		'Sur les sites logistiques de l\'agglomération, notre périmètre est strictement tertiaire : bureaux administratifs, accueil, salles de réunion, vestiaires de bureau, sanitaires. Nous ne réalisons ni entretien d\'entrepôt d\'exploitation, ni nettoyage industriel lourd, ni nettoyage agroalimentaire spécialisé.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h comme partout en région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Deux heures par semaine, le vendredi en fin de journée : bureaux, salle de réception clients, sanitaires. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · cabinet de conseil, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous recevons des clients le lundi matin : la salle de réception doit être irréprochable. Le passage du vendredi soir répond exactement à ce besoin depuis deux ans.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Anne-Sophie L.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Cabinet de conseil · Mâcon', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences et horaires', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Compte tenu de la distance, nous conseillons ici au moins deux heures par passage ou un regroupement hebdomadaire. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Cabinet ou bureau : 1 à 3 passages par semaine',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Espaces d\'accueil et de dégustation : selon saison',
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Meublé : à chaque changement de locataire',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Clés, accès et interventions hors présence', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'La plupart de nos interventions mâconnaises se font en dehors de votre présence. L\'accès est formalisé : remise de clé, de badge ou de code contre décharge écrite, code d\'alarme consigné, procédure de fermeture rappelée par écrit, interlocuteur identifié en cas d\'anomalie constatée sur place.',
		'Aucun accès n\'est conservé sans document signé, et la restitution suit la même formalité. En cas de changement d\'intervenant, la remise est refaite dans les mêmes conditions et vous en êtes informé avant le passage concerné.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références et observation sur site lors des premiers passages. Nous cherchons à confier chaque site au même intervenant sur la durée : pour un cabinet qui reçoit des clients, la discrétion et la connaissance des lieux comptent autant que la propreté.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites et vous informons du changement, sans promettre une continuité automatique. Le cahier de liaison sur site et le point de suivi avec Audrey assurent le suivi sans que vous ayez à être présent.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Ce que nous vérifions avant de nous engager', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Si l\'un des trois ne passe pas, nous proposons une alternative — autre créneau, fréquence différente, regroupement de passages — et si rien n\'est tenable, nous préférons le dire. Un prestataire qui accepte tout finit par décaler, annuler et changer d\'intervenant tous les mois : c\'est la principale raison pour laquelle une entreprise change de prestataire.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteur de la gare',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de l\'agglomération mâconnaise. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Sancé',
		'Charnay-lès-Mâcon',
		'Crêches-sur-Saône',
		'Vinzelles',
		'Chaintré',
		'Saint-Laurent-sur-Saône',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Mâcon', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence à Mâcon ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n\'y a ni agence mâconnaise, ni responsable local, ni numéro spécifique à la ville.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Les frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles figurent au devis, en ligne distincte du tarif horaire.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Entretenez-vous les caveaux et espaces de dégustation ?', 'reponse' => 'Oui, en tant qu\'espaces recevant du public : sols, comptoir, vitrages intérieurs, sanitaires. Les caves d\'élaboration et les zones de conditionnement, non.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous entretenir une location meublée entre deux séjours ?', 'reponse' => 'Oui : ménage complet ; le changement de linge, la vérification des consommables et le signalement photographique des dégradations sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis. En haute saison, réservez les créneaux à l\'avance.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous à Charnay-lès-Mâcon ou Sancé ?', 'reponse' => 'Oui, ces communes de l\'agglomération sont proches de Mâcon. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Quel volume minimum conseillez-vous ?', 'reponse' => 'Au moins deux heures par passage, ou un regroupement hebdomadaire. En dessous, la distance rend l\'organisation difficile à tenir durablement.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ macon\n";
}

/* ---------------- auxerre (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'auxerre', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone auxerre absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Auxerre', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux de PME, commerces, cabinets et parties communes : Top-Famille Pro entretient vos locaux auxerrois en régulier ou en ponctuel, à 27 € HT/h.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Auxerre', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Auxerre', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Auxerre et dans les communes proches pour l\'entretien de bureaux de PME, de locaux administratifs, de commerces de centre-ville, de cabinets courants et de parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Auxerre', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Auxerre est notre secteur icaunais, situé au nord-ouest de la région et bien desservi par l\'axe autoroutier. Nous y intervenons sur des créneaux réguliers planifiés, dont le regroupement est étudié selon le planning, ce qui rend le déplacement soutenable et permet de maintenir le tarif régional de 27 € HT/h sans surcoût horaire.',
		'Nous n\'avons pas d\'agence auxerroise, pas de responsable local et pas de numéro dédié à l\'Yonne. L\'ensemble de l\'organisation passe par Audrey, au 06 36 17 63 39 : échange préalable, cahier des charges, planning, remplacement et point de suivi. Nous ne prétendons pas être implantés sur place.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Auxerre est une préfecture de services avec un tissu de PME et un centre historique commerçant. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Bureaux de PME et sièges locaux',
		'Bureaux administratifs rattachés aux zones logistiques',
		'Commerces indépendants du centre historique',
		'Cabinets et professions libérales',
		'Espaces d\'accueil et de dégustation du Chablisien',
		'Parties communes de résidences et petites copropriétés',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et locaux administratifs', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'La prestation type comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et de la salle de pause, puis l\'aspiration et le lavage des sols. Les salles de réunion et les espaces recevant du public sont remis en ordre à chaque passage.',
		'Une part de nos interventions concerne des bureaux rattachés à des sites logistiques ou de transformation. Le cahier des charges délimite alors précisément le périmètre : bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives, avec un plan quand la configuration l\'exige.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Commerces du centre historique', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Le cœur d\'Auxerre est un environnement bâti ancien, avec des rues étroites, des accès véhicule limités et des revêtements variés — parquets, carrelages anciens, pierre. Ces contraintes sont relevées lors de l\'échange préalable et intégrées au cahier des charges, y compris le choix des produits adaptés à chaque sol.',
		'Le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine, sortie des cartons et des déchets. La réserve est traitée périodiquement, selon un rythme convenu au devis plutôt qu\'improvisé d\'une semaine sur l\'autre.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Logistique, agroalimentaire et viticulture : nos limites', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Les zones d\'activité de l\'axe autoroutier accueillent des entrepôts et des sites de transformation. Notre intervention y porte exclusivement sur les espaces tertiaires. Nous ne réalisons pas d\'entretien d\'entrepôt d\'exploitation, de nettoyage de lignes de conditionnement, de nettoyage agroalimentaire spécialisé ni de traitement chimique.',
		'Pour les domaines et maisons de négoce du Chablisien, nous entretenons les espaces d\'accueil et de dégustation en tant qu\'espaces recevant du public, ainsi que les bureaux et sanitaires. Les caves d\'élaboration et les zones de conditionnement restent en dehors de notre offre.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, identique au reste de la région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Deux passages d\'une heure par semaine, après 18 h : bureaux administratifs, sanitaires, salle de pause. 225 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux de PME, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Deux passages par semaine après la fermeture, sans que nous ayons à être présents. Le cahier de liaison nous signale ce qui doit l\'être, y compris les consommables à recommander.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Sébastien H.', $id );
	tfp_seed_set_field( 'temoignage_role', 'PME de services · Auxerre', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences et horaires', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'L\'éloignement d\'Auxerre nous conduit à écarter les passages très courts : deux heures minimum, ou un regroupement de plusieurs sites étudié selon le planning. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Bureaux : 1 à 3 passages par semaine, après 18 h',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Cabinet : 1 à 2 passages par semaine',
		'Parties communes : 1 passage hebdomadaire à créneau régulier',
		'Espaces d\'accueil et de dégustation : selon saison',
		'Vitrages et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Clés, accès et suivi à distance', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'La quasi-totalité de nos interventions auxerroises se déroule hors de votre présence. La remise de clé, de badge ou de code se fait contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture rappelée par écrit. Aucun accès n\'est conservé sans document signé.',
		'Le suivi s\'appuie sur un cahier de liaison laissé sur site, où l\'intervenant note ce qui a été fait et ce qui mérite votre attention — consommable à recommander, dégât constaté, accès défectueux —, complété par un point de suivi avec Audrey. Vous savez ce qui s\'est passé sans avoir été présent.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et remplacement', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation sur site lors des premiers passages. Sur un secteur éloigné comme celui-ci, nous cherchons particulièrement à stabiliser l\'affectation : un intervenant qui connaît le site, les accès et les consignes fait gagner du temps à tout le monde.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, lui transmettons les consignes écrites et vous informons du changement. Nous ne promettons pas de continuité garantie : nous nous engageons à informer et à transmettre, ce qui est tenable.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Matériel et produits utilisés', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Les produits et le matériel sont généralement fournis par le client ; toute organisation différente est précisée dans le devis et le cahier des charges. Le matériel est distinct par type d\'espace lorsque le cahier des charges le prévoit — code couleur distinct pour les sanitaires et pour les espaces de travail — et des produits choisis selon les revêtements relevés lors de l\'échange préalable : parquet, carrelage ancien, pierre, moquette, sol souple.',
		'Dans les cabinets et les espaces recevant du public, les surfaces de contact courantes font l\'objet d\'un entretien courant selon le cahier des charges. Si votre structure impose ses propres références de produits, nous les utilisons et cela figure au cahier des charges. Les consommables peuvent être gérés par vous ou par nous, refacturés au prix d\'achat, avec signalement des niveaux bas au cahier de liaison.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de la couronne auxerroise. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Monéteau',
		'Appoigny',
		'Perrigny',
		'Saint-Georges-sur-Baulche',
		'Venoy',
		'Chevannes',
		'Augy',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Auxerre', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Avez-vous une agence à Auxerre ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, près de Dijon. Il n\'y a ni agence auxerroise, ni responsable local, ni numéro spécifique au département.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Intervenez-vous à Sens, Joigny ou Avallon ?', 'reponse' => 'Non, pas régulièrement. Ces villes sortent de nos tournées : nous ne pourrions pas y tenir un créneau fixe semaine après semaine, et nous préférons le dire plutôt que de le découvrir en cours de contrat.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Les frais de déplacement sont-ils appliqués ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Entretenez-vous les entrepôts de l\'axe autoroutier ?', 'reponse' => 'Nous n\'entrons pas dans les zones de stockage et de préparation. Notre intervention se limite au bloc administratif : bureaux, accueil, salle de réunion, vestiaires de bureau et sanitaires.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Pouvez-vous intervenir sans que nous soyons présents ?', 'reponse' => 'Oui, c\'est le cas le plus fréquent. La clé ou le badge est remis contre décharge écrite, avec le code d\'alarme et la procédure de fermeture consignés par écrit.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Intervenez-vous à Monéteau ou Appoigny ?', 'reponse' => 'Oui, ces communes de la couronne auxerroise sont proches de la ville. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ auxerre\n";
}

/* ---------------- belfort (ville) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'belfort', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone belfort absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Belfort', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux d\'ingénierie, locaux tertiaires, commerces et parties communes : Top-Famille Pro entretient vos locaux belfortains, y compris en soirée.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Belfort', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Belfort', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro intervient à Belfort et dans son agglomération pour l\'entretien de bureaux d\'études et d\'ingénierie, de locaux tertiaires, de commerces de centre-ville, de cabinets courants et de parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. L\'entreprise est implantée à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre positionnement à Belfort', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Belfort est l\'un de nos secteurs éloignés. Nous y intervenons sur des créneaux réguliers convenus à l\'avance, dont le regroupement est étudié selon le planning. La compacité du département est prise en compte dans l\'organisation : les communes de la couronne belfortaine sont proches les unes des autres.',
		'Nous n\'avons pas d\'agence belfortaine, pas de responsable local et pas de numéro spécifique. Tout passe par Audrey, au 06 36 17 63 39. Sur ce secteur, nous ne proposons pas d\'intervention improvisée : ce que nous nous engageons à tenir, c\'est un créneau régulier, respecté, avec un intervenant stable.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Belfort est une ville industrielle et universitaire. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Bureaux d\'études et d\'ingénierie',
		'Bureaux administratifs de sites industriels',
		'PME de services et sièges locaux',
		'Commerces indépendants du centre-ville',
		'Cabinets et professions libérales',
		'Parties communes de résidences',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Bureaux et locaux tertiaires', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Pour un plateau belfortain, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien complet des sanitaires et de l\'espace café, puis l\'aspiration et le lavage des sols. Les salles de réunion sont remises en ordre après usage, ce qui est très demandé dans les bureaux d\'études.',
		'Les open-spaces d\'ingénierie ont leurs spécificités : postes encombrés de documents techniques, écrans multiples, matériel de mesure. La consigne est claire — on ne déplace rien, on ne dépoussière pas sous les documents laissés en place, on nettoie ce qui est accessible. Ces points figurent au cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Sites industriels : un périmètre strictement tertiaire', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Une partie des locaux concernés sont des bureaux administratifs situés à l\'intérieur ou en bordure d\'un site de production. La première chose que nous écrivons dans le cahier des charges est donc la frontière : quelles portes nous franchissons, lesquelles nous ne franchissons pas, et par quel cheminement l\'intervenant accède à sa zone.',
		'Notre périmètre s\'arrête aux espaces de travail administratifs et à leurs annexes. Les ateliers, halls de montage, zones d\'essai et locaux techniques ne sont jamais inclus, même partiellement : nous n\'avons ni les habilitations, ni les protocoles, ni le matériel que ces environnements exigent. Les consignes d\'accès et de port d\'équipement du site sont annexées au cahier des charges.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'recit_5_titre', 'Commerces, cabinets et parties communes', $id );
	tfp_seed_set_field( 'recit_5_texte', implode( "\n", array(
		'Pour un commerce du centre-ville, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine. La réserve est traitée périodiquement, selon un rythme fixé au devis.',
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sont annexées au cahier des charges. Pour les immeubles, nous traitons hall, cage d\'escalier, rampes, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'recit_5_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h comme partout en région, avec 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % pour les interventions de nuit, le dimanche et les jours fériés.',
		'Deux passages de 1 h 15 par semaine, en soirée : open-space, salles de réunion, sanitaires et espace café. 279 € HT/mois. Hors éventuelles indemnités kilométriques précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux d\'ingénierie, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage a lieu après le départ des équipes techniques, avec les consignes d\'accès du site respectées. En deux ans, nous n\'avons eu aucun incident de fermeture à signaler.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Thierry N.', $id );
	tfp_seed_set_field( 'temoignage_role', 'Bureau d\'ingénierie · Belfort', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fréquences et créneaux en soirée', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Une intervention après la fermeture est le cas de figure le plus souvent étudié sur ce secteur. Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', implode( "\n", array(
		'Bureaux d\'études : 1 à 3 passages par semaine, en soirée',
		'Bureaux administratifs de site : 1 à 2 passages par semaine',
		'Commerce : 3 à 6 passages par semaine, avant ouverture',
		'Cabinet : 1 à 2 passages par semaine',
		'Parties communes : 1 passage hebdomadaire à créneau régulier',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'methode_2_titre', 'Badges, alarmes et procédure de fermeture', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Intervenir en soirée sur un site industriel suppose une organisation formalisée : remise de badge ou de clé contre décharge écrite, code d\'alarme consigné, procédure d\'armement et de fermeture rappelée par écrit, interlocuteur identifié en cas d\'anomalie constatée sur place.',
		'Aucun accès n\'est conservé sans document signé, et la restitution suit la même formalité. En cas de changement d\'intervenant, la remise est refaite dans les mêmes conditions et vous en êtes informé avant le passage concerné. Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Sélection, intervenant habituel et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références et une période d\'observation sur site. Sur un site soumis à des consignes de sécurité, la stabilité de l\'intervenant est déterminante : elle évite de reprendre les procédures à chaque passage.',
		'En cas d\'absence, de congés ou de départ, nous cherchons une solution de remplacement, transmettons les consignes écrites — y compris les consignes de sécurité du site — et vous informons du changement. Aucune continuité automatique n\'est promise. Le cahier de liaison et le point de suivi complètent le suivi.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'methode_4_titre', 'Le devis, ligne par ligne', $id );
	tfp_seed_set_field( 'methode_4_texte', implode( "\n", array(
		'Le devis tient sur une page et se lit sans interprétation : espaces couverts, tâches faites à chaque passage, tâches périodiques et leur fréquence, nombre d\'heures par passage, fréquence hebdomadaire, volume mensuel, taux horaire de 27 € HT/h, gestion mensuelle de 9 € HT, mise en place de 50 € HT.',
		'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Les consignes de sécurité du site sont annexées. Rien n\'apparaît après signature : toute prestation supplémentaire passe par un devis complémentaire que vous validez avant intervention.',
	) ), $id );
	tfp_seed_set_field( 'methode_4_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteur de la gare',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes de la couronne belfortaine. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Valdoie',
		'Offemont',
		'Bavilliers',
		'Danjoutin',
		'Cravanche',
		'Essert',
		'Pérouse',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'departements', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Belfort', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Belfort est loin de Dijon : intervenez-vous vraiment ici ?', 'reponse' => 'Oui, sur la base de créneaux réguliers planifiés à l\'avance, dont le regroupement est étudié selon le planning. C\'est un secteur éloigné : nous y travaillons en régularité, pas en urgence.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Avez-vous une agence à Belfort ?', 'reponse' => 'Non, aucune. L\'entreprise est domiciliée à Saint-Apollinaire (21850) et n\'a ni bureau, ni dépôt, ni représentant dans le Territoire de Belfort.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Intervenez-vous à l\'intérieur d\'un site de production ?', 'reponse' => 'Seulement dans ses locaux administratifs, dont l\'accès et le cheminement sont décrits au cahier des charges. Ateliers, halls de montage, zones d\'essai et locaux techniques sont exclus.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous passer après le départ des équipes ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé : badge remis contre décharge écrite, code d\'alarme consigné, procédure de fermeture rappelée par écrit et interlocuteur identifié en cas d\'anomalie.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Les frais de déplacement sont-ils élevés ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles sont chiffrées au devis, en ligne distincte.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Intervenez-vous à Valdoie ou Bavilliers ?', 'reponse' => 'Oui, ces communes de la couronne belfortaine sont proches de Belfort. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ belfort\n";
}

/* ---------------- saint-apollinaire (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'saint-apollinaire', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone saint-apollinaire absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Saint-Apollinaire', $id );
	tfp_seed_set_field( 'hero_lede', 'Saint-Apollinaire est l\'implantation réelle de Top-Famille Pro : c\'est de cette commune que partent tous nos plannings, en Côte-d\'Or comme dans le reste de la région.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Saint-Apollinaire', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Saint-Apollinaire', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Top-Famille Pro est implantée à Saint-Apollinaire (21850), en Côte-d\'Or, commune limitrophe de Dijon à l\'est. C\'est notre unique adresse, et c\'est de là que sont organisés les devis, les plannings et le suivi de tous nos clients régionaux. Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Audrey : 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Notre implantation réelle, et rien d\'autre', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Saint-Apollinaire n\'est pas une commune d\'intervention parmi d\'autres : c\'est l\'adresse de l\'entreprise. Top-Famille Pro y est domiciliée, et c\'est de là que sont préparés les devis, établis les plannings, organisés les remplacements et suivis les dossiers de l\'ensemble de nos clients, du Territoire de Belfort à la Nièvre.',
		'Nous insistons sur ce point parce que beaucoup de sites du secteur affichent une « agence » dans chaque ville. Nous n\'en avons aucune : ni à Dijon, ni à Besançon, ni ailleurs. Une seule adresse, une seule interlocutrice, un seul numéro — le 06 36 17 63 39 — quelle que soit la commune où se trouvent vos locaux.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Commune de la première couronne dijonnaise, Saint-Apollinaire accueille des zones d\'activité, des commerces et un tissu résidentiel. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'PME et bureaux des zones d\'activité de la commune',
		'Commerces et services de proximité',
		'Cabinets et professions libérales',
		'Copropriétés et résidences',
		'Locations meublées et logements de courte durée',
		'Associations et locaux de formation',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Ce que nous faisons sur la commune', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Nos six prestations sont disponibles ici comme ailleurs : nettoyage de bureaux, de commerces, de cabinets, de parties communes de copropriétés, de locations meublées et interventions ponctuelles. La différence, sur Saint-Apollinaire, tient à la souplesse : une prestation courte d\'une heure est possible, ce qui n\'est pas le cas sur les secteurs éloignés.',
		'Concrètement, un bureau de la zone d\'activité peut être entretenu trois matins par semaine avant 8 h, un commerce avant l\'ouverture, une copropriété une fois par semaine à créneau convenu, un meublé à chaque changement de locataire. Le cahier des charges est établi après visite, espace par espace.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. C\'est le secteur où notre implantation est la plus proche : ajustement de créneau, passage supplémentaire ou visite complémentaire sont étudiés selon les disponibilités du planning.',
		'Trois passages d\'une heure par semaine avant 8 h : bureaux, sanitaires, coin cuisine et salle de réunion. 333 € HT/mois, sans frais de déplacement.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux en zone d\'activité, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous sommes suivis depuis deux ans, avec le même créneau chaque semaine. Quand nous avons eu besoin d\'un passage supplémentaire avant une réunion, il a été organisé dans la semaine.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Une visite est proposée sur la commune : nous relevons les surfaces, les revêtements, les contraintes d\'accès et d\'horaires, puis nous rédigeons un cahier des charges détaillé. Le devis suit sous 24 heures, avec un volume d\'heures argumenté plutôt qu\'une fourchette approximative.',
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation sur site. Nous cherchons à confier chaque site au même intervenant sur la durée ; en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement. Un cahier de liaison reste sur place.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Réactivité : ce que la proximité change vraiment', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Être implanté dans la commune a des effets concrets et mesurables :',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', implode( "\n", array(
		'Visite de devis proposée selon les disponibilités du planning',
		'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'Prestations courtes possibles (1 h ou 2 h)',
		'Ajustement de créneau plus simple qu\'ailleurs',
		'Passage supplémentaire étudié selon les disponibilités du planning',
		'Visite de contrôle facile à intercaler dans une tournée',
	) ), $id );
	tfp_seed_set_field( 'methode_3_titre', 'Nos limites, ici comme partout', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les zones d\'activité de la commune accueillent des entreprises de production et de logistique. Sur ces sites, notre intervention se limite aux espaces compatibles avec notre offre : bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives.',
		'Nous ne réalisons ni nettoyage industriel lourd, ni nettoyage de lignes de production, ni nettoyage agroalimentaire spécialisé, ni bio-nettoyage hospitalier, ni traitement chimique, ni désamiantage. La proximité ne change rien à ces limites : elle change seulement notre réactivité sur ce que nous savons faire.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Saint-Apollinaire, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Ruffey-lès-Echirey',
		'Bressey-sur-Tille',
		'Varois-et-Chaignot',
		'Norges-la-Ville',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Saint-Apollinaire', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Votre entreprise est-elle vraiment domiciliée à Saint-Apollinaire ?', 'reponse' => 'Oui, c\'est notre unique implantation : 21850 Saint-Apollinaire, en Côte-d\'Or. Tous nos plannings régionaux sont organisés depuis cette adresse.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Y a-t-il des frais de déplacement sur la commune ?', 'reponse' => 'Non. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Peut-on vous confier une prestation courte, d\'une heure ?', 'reponse' => 'Oui, c\'est possible sur cette commune et dans l\'agglomération dijonnaise. Sur les secteurs éloignés, nous conseillons au moins deux heures par passage.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Quel délai pour une visite de devis ?', 'reponse' => 'Le délai de visite dépend du planning en cours et vous est indiqué lors de l\'échange. Le devis est ensuite transmis sous 24 heures après la visite, gratuitement et sans engagement.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous dans les zones d\'activité de la commune ?', 'reponse' => 'Oui, pour les bureaux, accueils, salles de réunion, vestiaires de bureau et sanitaires. Les ateliers et zones de production ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Faut-il passer par un bureau local pour vous joindre ?', 'reponse' => 'Non, il n\'existe qu\'un seul contact : Audrey, au 06 36 17 63 39, pour tous les clients de la région.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ saint-apollinaire\n";
}

/* ---------------- chenove (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'chenove', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone chenove absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Chenôve', $id );
	tfp_seed_set_field( 'hero_lede', 'Parties communes, commerces et bureaux : Top-Famille Pro entretient vos locaux à Chenôve, commune limitrophe de Dijon au sud de l\'agglomération.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Chenôve', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Chenôve', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Chenôve est une commune de Côte-d\'Or limitrophe de Dijon, au sud de l\'agglomération. Top-Famille Pro y entretient parties communes d\'immeubles, commerces, bureaux, cabinets courants et locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation se trouve à Saint-Apollinaire, à l\'autre extrémité de l\'agglomération. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Chenôve dans l\'agglomération dijonnaise', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Chenôve est limitrophe de Dijon, au sud de l\'agglomération. C\'est une commune de l\'agglomération dijonnaise, avec un parc résidentiel collectif important, des commerces de proximité et des zones d\'activité. Notre implantation de Saint-Apollinaire se situe dans la même agglomération : la commune fait partie de nos secteurs prioritaires.',
		'Nous n\'avons pas de bureau à Chenôve et nous ne prétendons pas en avoir. Ce qui compte, c\'est que la commune fait partie de nos secteurs prioritaires. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels et structures que nous accompagnons', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Compte tenu du profil de la commune, les besoins susceptibles de nous être confiés se répartissent surtout entre :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Syndics de copropriété et conseils syndicaux',
		'Commerces et services de proximité',
		'Bureaux de PME et locaux administratifs',
		'Cabinets et professions libérales',
		'Locaux associatifs et de formation',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Parties communes : une prestation fréquemment étudiée ici', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Pour un immeuble chenevelier, le cahier des charges décrit le circuit exact : hall d\'entrée, sol et vitrage de la porte, boîtes aux lettres, cage d\'escalier étage par étage, rampes et plinthes, paliers, cabine et miroir d\'ascenseur, local à conteneurs et abords immédiats.',
		'La sortie et la rentrée des bacs sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis ; les jours retenus y sont inscrits. Nous distinguons ce qui est fait à chaque passage de ce qui est fait périodiquement — vitrages de cage d\'escalier, plinthes, local à vélos — afin que syndic, conseil syndical et résidents lisent la même chose.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % pour les interventions de nuit, le dimanche et les jours fériés.',
		'Deux heures par semaine : trois cages d\'escalier, hall, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse. 225 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · copropriété, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'L\'entretien de nos parties communes est régulier et le local à conteneurs est enfin propre. Le cahier de liaison nous signale ce qu\'il faut réparer, ce que nous n\'avions pas avant.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Commerces, bureaux et cabinets', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Pour un commerce, le passage se fait avant l\'ouverture : surface de vente, sanitaires clients, comptoir, vitrages intérieurs et abords de la vitrine, sortie des cartons. Pour un bureau, la prestation comprend corbeilles, dépoussiérage des surfaces libres, entretien des surfaces de contact courantes, sanitaires, espace café, aspiration et lavage des sols.',
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sur les dossiers laissés en place sont annexées au cahier des charges. Il s\'agit d\'un entretien courant de locaux professionnels. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Une visite est proposée avant tout devis : relevé des surfaces, des revêtements, des accès et des contraintes d\'horaires, puis rédaction d\'un cahier des charges détaillé et devis sous 24 heures. Pour une copropriété, le document est transmis au syndic et peut être présenté au conseil syndical.',
		'Les intervenants sont recrutés par Audrey, avec vérification des références. Nous cherchons à maintenir le même intervenant sur le site ; en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons. Un cahier de liaison reste sur place et les modalités de suivi sont définies avec le client.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Fréquences et créneaux', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', implode( "\n", array(
		'Copropriété : 1 passage hebdomadaire à créneau régulier',
		'Commerce : 4 à 6 passages par semaine, avant ouverture',
		'Bureaux : 1 à 3 passages par semaine',
		'Cabinet : 1 à 2 passages par semaine, en fin de journée',
		'Meublé : à chaque changement de locataire',
		'Grand nettoyage annuel de parties communes : sur devis',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Chenôve, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Perrigny-lès-Dijon',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Chenôve', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Chenôve fait-elle partie de votre secteur prioritaire ?', 'reponse' => 'Oui, c\'est une commune limitrophe de Dijon et l\'un de nos secteurs prioritaires, notamment pour les parties communes de copropriétés.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Des frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Travaillez-vous avec les syndics et les conseils syndicaux ?', 'reponse' => 'Oui, avec les deux. Le cahier des charges détaille le circuit, la fréquence et les tâches périodiques, et le cahier de liaison sert de compte rendu.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Gérez-vous la sortie des bacs ?', 'reponse' => 'C\'est possible lorsque prévu dans le cahier des charges et chiffré dans le devis : les jours concernés sont alors inscrits au cahier des charges, selon le calendrier de collecte applicable à l\'adresse.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous aussi pour les commerces ?', 'reponse' => 'Oui, au même tarif de 27 € HT/h, avec un passage avant ouverture adapté à vos jours d\'activité.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Chenôve ?', 'reponse' => 'Non. Notre unique adresse est à Saint-Apollinaire, et le numéro est le même pour tous nos clients : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ chenove\n";
}

/* ---------------- quetigny (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'quetigny', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone quetigny absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Quetigny', $id );
	tfp_seed_set_field( 'hero_lede', 'Commerces, bureaux et cabinets : Quetigny est voisine de notre implantation de Saint-Apollinaire, ce qui en fait l\'un de nos secteurs prioritaires.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Quetigny', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Quetigny', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Quetigny est une commune de Côte-d\'Or située à l\'est de Dijon, limitrophe de Saint-Apollinaire où Top-Famille Pro est implantée. Le taux horaire reste de 27 € HT/h dans toute la région. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Devis gratuit sous 24 heures auprès d\'Audrey, au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Quetigny, commune voisine de notre implantation', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Quetigny est limitrophe de Saint-Apollinaire, où Top-Famille Pro est domiciliée. C\'est donc, avec notre propre commune, le secteur le plus proche de notre implantation : visite de devis et passage supplémentaire sont proposés selon les disponibilités du planning.',
		'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention, et sont précisées dans le devis. Les prestations courtes sont étudiées au cas par cas. Le tarif horaire reste celui de toute la région, 27 € HT/h.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Quetigny est structurée autour d\'un pôle commercial important et de zones d\'activité. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Commerces et enseignes indépendantes du pôle commercial',
		'Bureaux de PME et locaux administratifs',
		'Cabinets médicaux, paramédicaux et libéraux',
		'Copropriétés et résidences',
		'Locaux associatifs et de formation',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Commerces : passage avant ouverture et jours de forte affluence', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'C\'est une prestation fréquemment étudiée sur la commune. Le passage se fait avant l\'ouverture : surface de vente aspirée puis lavée, sanitaires clients, comptoir et caisse, vitrages intérieurs, abords de la vitrine, sortie des cartons et des déchets. La réserve est traitée une fois par semaine, en général en début ou en fin de semaine.',
		'Les jours de forte affluence — samedi notamment — peuvent justifier un créneau plus long ou un second passage. Il est chiffré séparément au même tarif horaire, sans modifier le contrat régulier : cela reste plus lisible qu\'un forfait gonflé toute l\'année pour couvrir deux journées.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Les prestations courtes sont étudiées au cas par cas. Majoration de 10 % la nuit, le dimanche et les jours fériés.',
		'Un passage d\'une heure avant ouverture six jours par semaine, avec un créneau renforcé le samedi : surface de vente, sanitaires clients, réserve hebdomadaire. 549 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · commerce, 20 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage a lieu avant l\'ouverture, tous les jours travaillés, et la boutique est prête quand j\'arrive. Les échanges avec Audrey sont directs, sans intermédiaire.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Bureaux, cabinets et parties communes', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Pour un bureau, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, les sanitaires, l\'espace café, puis l\'aspiration et le lavage des sols. La salle de réunion est remise en ordre à chaque passage.',
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sont annexées au cahier des charges. Pour les immeubles, nous traitons hall, cage d\'escalier, rampes, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'La mise en place commence par une visite : relevé des surfaces, des revêtements, des accès et des horaires souhaités, puis cahier des charges détaillé et devis sous 24 heures. Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis.',
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation sur site. Nous cherchons à confier chaque site au même intervenant sur la durée ; en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous prévenons du changement.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Ce que nous ne faisons pas', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Les zones d\'activité de la commune accueillent des entreprises de production, de distribution et de services techniques. Sur ces sites, notre périmètre reste tertiaire : bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives.',
		'Nous ne réalisons ni nettoyage industriel lourd, ni nettoyage de lignes de production, ni nettoyage agroalimentaire spécialisé, ni bio-nettoyage hospitalier, ni traitement chimique, ni désamiantage. Ces prestations demandent des protocoles et des habilitations que nous n\'avons pas, et nous le disons avant toute visite.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Pôle commercial',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Quetigny, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Chevigny-Saint-Sauveur',
		'Sennecey-lès-Dijon',
		'Bretenière',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Quetigny', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Quetigny fait-elle partie de vos secteurs prioritaires ?', 'reponse' => 'Oui : la commune est limitrophe de Saint-Apollinaire, où nous sommes implantés. La visite de devis et un éventuel passage supplémentaire sont proposés selon les disponibilités du planning.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Des frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Non. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Une prestation d\'une heure est-elle possible ?', 'reponse' => 'Oui, sur cette commune et dans l\'agglomération dijonnaise. Sur les secteurs éloignés de la région, nous conseillons au moins deux heures par passage.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Intervenez-vous dans le pôle commercial ?', 'reponse' => 'Oui, c\'est l\'un de nos secteurs prioritaires pour les commerces, avec un passage avant ouverture et un renfort possible les jours de forte affluence.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Un second passage le samedi est-il facturé à part ?', 'reponse' => 'Oui, au même tarif de 27 € HT/h, chiffré séparément, sans modifier le contrat régulier en place.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Quetigny ?', 'reponse' => 'Non. Notre unique implantation est la commune voisine de Saint-Apollinaire, et le numéro est le même pour tous : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ quetigny\n";
}

/* ---------------- talant (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'talant', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone talant absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Talant', $id );
	tfp_seed_set_field( 'hero_lede', 'Parties communes, cabinets et commerces de proximité : Top-Famille Pro entretient vos locaux à Talant, commune limitrophe de Dijon au nord-ouest.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Talant', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Talant', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Talant est une commune de Côte-d\'Or limitrophe de Dijon, au nord-ouest de l\'agglomération. Top-Famille Pro y entretient parties communes de résidences, cabinets, commerces de proximité, bureaux et locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation est à Saint-Apollinaire, à l\'est de l\'agglomération. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Talant, commune limitrophe de Dijon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Talant est limitrophe de Dijon, au nord-ouest de l\'agglomération, sur un plateau qui domine la vallée de l\'Ouche. C\'est une commune à dominante résidentielle, avec un parc collectif important, des commerces de proximité et des cabinets installés en pied d\'immeuble ou dans des locaux de centre.',
		'Notre implantation de Saint-Apollinaire se situe dans la même agglomération. Talant fait partie de notre secteur prioritaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les structures que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Compte tenu du profil résidentiel de la commune, les besoins susceptibles de nous être confiés concernent surtout :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Syndics de copropriété et conseils syndicaux',
		'Résidences et petits immeubles collectifs',
		'Cabinets et professions libérales',
		'Commerces de proximité',
		'Bureaux de petites structures',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Parties communes : le détail du circuit', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Pour une résidence talantaise, le cahier des charges décrit le circuit précis : hall d\'entrée, sol et vitrage de la porte, boîtes aux lettres, cage d\'escalier étage par étage, rampes et plinthes, paliers, cabine et miroir d\'ascenseur, local à conteneurs et abords immédiats de l\'immeuble.',
		'Les tâches faites à chaque passage sont distinguées des tâches périodiques — vitrages de cage d\'escalier, plinthes, local à vélos, grille de ventilation. La sortie et la rentrée des bacs sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis ; les jours retenus y sont inscrits noir sur blanc.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %.',
		'Un passage de 1 h 30 par semaine : hall, ascenseur, paliers, vitrage de la porte d\'entrée et local à conteneurs. 171 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · résidence, 6 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le hall et l\'ascenseur sont repris chaque semaine, à jour fixe. Le conseil syndical dispose du cahier de liaison pour préparer ses réunions.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Cabinets, commerces et petits bureaux', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sur les dossiers laissés en place sont annexées au cahier des charges.',
		'Pour un commerce de proximité, le passage se fait avant l\'ouverture : surface de vente, sanitaires, comptoir, vitrages intérieurs. Pour un petit bureau, la prestation comprend corbeilles, dépoussiérage des surfaces libres, entretien des surfaces de contact courantes, sanitaires, coin cuisine, aspiration et lavage des sols.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fonctionnement, accès et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Une visite précède le devis : relevé des surfaces, des revêtements, du nombre d\'étages, des accès et du calendrier de collecte, puis cahier des charges détaillé et devis sous 24 heures. Pour une copropriété, le document est transmis au syndic et peut être présenté en conseil syndical.',
		'Les clés ou badges nécessaires — porte d\'entrée, local à conteneurs, local technique — sont remis contre décharge écrite et restitués selon la même formalité. En cas de changement d\'intervenant, la remise est refaite et vous en êtes informé. Un cahier de liaison reste sur site et les modalités de suivi sont définies avec le client.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Exemples de fréquences', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges , après visite :',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', implode( "\n", array(
		'Résidence : 1 passage hebdomadaire à créneau régulier',
		'Petite copropriété : 1 passage bimensuel possible',
		'Cabinet : 1 à 2 passages par semaine, en fin de journée',
		'Commerce de proximité : 3 à 6 passages par semaine',
		'Petit bureau : 1 passage par semaine',
		'Grand nettoyage annuel de parties communes : sur devis',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Talant, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Plombières-lès-Dijon',
		'Daix',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Talant', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Talant fait-elle partie de votre secteur prioritaire ?', 'reponse' => 'Oui, la commune est limitrophe de Dijon et fait partie de notre zone prioritaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Intervenez-vous auprès des résidences et copropriétés ?', 'reponse' => 'Oui, c\'est une prestation fréquemment étudiée ici : hall, cage d\'escalier, ascenseur, paliers, local à conteneurs, la gestion des bacs étant possible lorsque prévu dans le cahier des charges et chiffré dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Un passage bimensuel est-il possible ?', 'reponse' => 'Oui pour une petite copropriété peu fréquentée. Nous ajustons la fréquence à la taille de l\'immeuble et au nombre d\'occupants plutôt qu\'à un forfait standard.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Comment sont gérées les clés de l\'immeuble ?', 'reponse' => 'Elles sont remises contre décharge écrite par le syndic ou le conseil syndical, et restituées selon la même formalité en fin de contrat.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Proposez-vous vos services aux cabinets de la commune ?', 'reponse' => 'Oui, pour l\'entretien courant de leurs locaux : accueil, salle d\'attente, bureaux, sanitaires et sols, avec consigne écrite de confidentialité. Il s\'agit d\'un entretien de cabinet courant.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Talant ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, à l\'est de l\'agglomération, et le numéro est le même partout : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ talant\n";
}

/* ---------------- longvic (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'longvic', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone longvic absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Longvic', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, espaces tertiaires de zones d\'activité et commerces : Top-Famille Pro entretient vos locaux à Longvic, commune limitrophe de Dijon au sud.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Longvic', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Longvic', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Longvic est une commune de Côte-d\'Or limitrophe de Dijon, au sud de l\'agglomération. Top-Famille Pro y entretient bureaux, espaces tertiaires des zones d\'activité, commerces, cabinets courants et parties communes, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation est à Saint-Apollinaire, dans la même agglomération. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Longvic, commune d\'activité au sud de Dijon', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Longvic est limitrophe de Dijon, au sud de l\'agglomération. La commune accueille des zones d\'activité importantes, des entreprises de production et de services, ainsi qu\'un tissu résidentiel et des commerces de proximité. C\'est l\'un des secteurs où les bureaux rattachés à des sites d\'exploitation sont les plus nombreux, avec le périmètre strictement tertiaire que cela implique de notre côté.',
		'Notre implantation de Saint-Apollinaire se situe dans la même agglomération. Longvic fait partie de notre secteur prioritaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Bureaux administratifs de sites d\'activité',
		'Bureaux de PME et sièges locaux',
		'Commerces et services de proximité',
		'Cabinets et professions libérales',
		'Copropriétés et résidences',
		'Locaux associatifs et de formation',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Espaces tertiaires : un périmètre écrit et délimité', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Sur un site d\'activité, la question la plus importante n\'est pas la fréquence mais le périmètre. Nous entretenons les bureaux, l\'accueil, les salles de réunion, les vestiaires de bureau, les sanitaires et les circulations administratives. Ce périmètre est décrit au cahier des charges, et tracé sur un plan lorsque la configuration s\'y prête.',
		'Nous ne réalisons ni nettoyage industriel lourd, ni nettoyage de machines ou de lignes de production, ni entretien d\'atelier en activité, ni traitement chimique, ni intervention en locaux à risque. Ce n\'est pas une réserve de principe : ces prestations demandent des protocoles et des habilitations spécifiques que nous n\'avons pas.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Les interventions de nuit, le dimanche et les jours fériés sont majorées de 10 %, ce qui est indiqué au devis dès que le créneau le justifie.',
		'Trois passages d\'une heure par semaine avant 8 h : bureaux, accueil, sanitaires, vestiaires de bureau et coin cuisine. 333 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · bureaux de zone d\'activité, 12 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nos bureaux sont entretenus trois matins par semaine avant l\'arrivée des équipes. Le périmètre a été écrit dès le départ, ce qui a évité toute discussion sur ce qui était inclus ou non.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Bureaux, commerces, cabinets et parties communes', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Pour un plateau de bureaux, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien des sanitaires et du coin cuisine, puis l\'aspiration et le lavage des sols. Les salles de réunion sont remises en ordre après usage.',
		'Pour un commerce, le passage se fait avant l\'ouverture. Pour un cabinet, le cahier des charges prévoit l\'entretien courant de la salle d\'attente, de l\'accueil, des bureaux, des sanitaires et des sols, avec consigne de confidentialité. Pour un immeuble, nous traitons hall, cage d\'escalier, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Fonctionnement, accès et suivi', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Une visite précède le devis : relevé des surfaces, des revêtements, des accès, des horaires possibles et des consignes de sécurité éventuelles du site. Le cahier des charges est ensuite rédigé espace par espace, et le devis transmis sous 24 heures, avec un volume d\'heures argumenté.',
		'La plupart des interventions se déroulent hors présence : la clé ou le badge est remis contre décharge écrite, avec le code d\'alarme consigné et la procédure de fermeture rappelée par écrit. Les consignes de sécurité propres au site sont annexées au cahier des charges et rappelées aux remplaçants.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Fréquences et créneaux', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', implode( "\n", array(
		'Bureaux de site d\'activité : 2 à 3 passages par semaine',
		'Bureaux de PME : 1 à 3 passages par semaine',
		'Commerce de proximité : 4 à 6 passages par semaine',
		'Cabinet : 1 à 2 passages par semaine',
		'Parties communes : 1 passage hebdomadaire',
		'Vitrages intérieurs et moquettes : périodique, chiffré à part',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Longvic, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Ouges',
		'Fénay',
		'Perrigny-lès-Dijon',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Longvic', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Entretenez-vous les ateliers de production ?', 'reponse' => 'Non. Notre intervention porte sur les espaces tertiaires : bureaux, accueil, salles de réunion, vestiaires de bureau, sanitaires et circulations administratives.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Des frais de déplacement s\'appliquent-ils à Longvic ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Pouvez-vous respecter les consignes de sécurité de notre site ?', 'reponse' => 'Oui. Elles sont annexées au cahier des charges et rappelées à chaque intervenant, y compris aux remplaçants, avant leur premier passage.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Un passage avant 8 h est-il possible ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé sur les zones d\'activité de la commune, pour que les locaux soient prêts à l\'arrivée des équipes.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Comment le périmètre d\'intervention est-il défini ?', 'reponse' => 'Il est écrit au cahier des charges, espace par espace, et tracé sur un plan lorsque la configuration du site le justifie.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Longvic ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, dans la même agglomération, et le numéro est le même partout : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ longvic\n";
}

/* ---------------- fontaine-les-dijon (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'fontaine-les-dijon', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone fontaine-les-dijon absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Fontaine-lès-Dijon', $id );
	tfp_seed_set_field( 'hero_lede', 'Cabinets, bureaux et parties communes : Top-Famille Pro entretient vos locaux à Fontaine-lès-Dijon, commune limitrophe de Dijon au nord.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Fontaine-lès-Dijon', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Fontaine-lès-Dijon', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Fontaine-lès-Dijon est une commune de Côte-d\'Or limitrophe de Dijon, au nord de l\'agglomération. Top-Famille Pro y entretient cabinets courants, bureaux, parties communes de résidences, commerces de proximité et locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation est à Saint-Apollinaire, dans la même agglomération. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Fontaine-lès-Dijon dans l\'agglomération', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Fontaine-lès-Dijon est limitrophe de Dijon, au nord de l\'agglomération. La commune associe un centre ancien perché, des secteurs résidentiels étendus et une proximité immédiate avec les zones commerciales du nord dijonnais. On y trouve de nombreux cabinets libéraux, des bureaux de petites structures et un parc collectif significatif.',
		'Notre adresse se situe à Saint-Apollinaire, à l\'est de l\'agglomération. La commune fait partie de notre secteur prioritaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Le profil de la commune orientent nos interventions vers :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Cabinets médicaux, dentaires et paramédicaux courants',
		'Bureaux de petites structures et professions libérales',
		'Syndics de copropriété et conseils syndicaux',
		'Commerces et services de proximité',
		'Locaux associatifs',
		'Locations meublées et logements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Cabinets : cahier des charges écrit et confidentialité', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges.',
		'La confidentialité fait partie de la consigne : dossiers, écrans et documents ne sont ni déplacés ni manipulés, et les surfaces encombrées ne sont pas dépoussiérées sous les papiers laissés en place. Il s\'agit d\'un entretien courant de locaux professionnels. Top-Famille Pro ne réalise pas de bio-nettoyage hospitalier, de stérilisation, de traitement des DASRI ni de protocole médical spécialisé. Cette limite est annoncée dès le premier échange.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'recit_4_titre', 'Bureaux, commerces et parties communes', $id );
	tfp_seed_set_field( 'recit_4_texte', implode( "\n", array(
		'Pour un bureau, la prestation comprend le vidage des corbeilles, le dépoussiérage des surfaces libres, l\'entretien des surfaces de contact courantes, l\'entretien des sanitaires et du coin cuisine, puis l\'aspiration et le lavage des sols selon leur nature.',
		'Pour une résidence, le circuit est décrit au cahier des charges : hall, boîtes aux lettres, cage d\'escalier étage par étage, rampes, paliers, ascenseur, local à conteneurs, sortie et rentrée des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis. Pour un commerce de proximité, le passage se fait avant l\'ouverture.',
	) ), $id );
	tfp_seed_set_field( 'recit_4_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % pour les interventions de nuit, le dimanche et les jours fériés.',
		'Deux passages d\'une heure par semaine en fin de journée : salle d\'attente, deux cabinets, sanitaires et surfaces courantes. 225 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · cabinet paramédical, 8 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Le passage se fait après la fermeture, deux fois par semaine, et la salle d\'attente est nette chaque matin. Nous apprécions de traiter directement avec la même personne.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Une visite précède le devis : relevé des surfaces, des revêtements, des accès et des horaires souhaités, puis rédaction d\'un cahier des charges espace par espace et devis sous 24 heures, sans engagement de durée.',
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation sur site lors des premiers passages. Nous cherchons à confier chaque site au même intervenant ; en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Exemples de fréquences', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Exemples de fréquences pouvant être étudiées — la fréquence finale dépend de la surface, de l\'usage des locaux, du niveau d\'entretien attendu et du cahier des charges :',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', implode( "\n", array(
		'Cabinet : 2 à 5 passages par semaine, après le dernier patient',
		'Petit bureau : 1 à 2 passages par semaine',
		'Résidence : 1 passage hebdomadaire à créneau régulier',
		'Commerce de proximité : 3 à 6 passages par semaine',
		'Meublé : à chaque changement de locataire',
		'Vitrages et moquettes : périodique, chiffré séparément',
	) ), $id );
	tfp_seed_set_field( 'methode_3_titre', 'Mise en place et délais', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Le délai de démarrage dépend des disponibilités, de l\'adresse, du volume horaire et de l\'organisation nécessaire. Il est confirmé lors de l\'établissement du devis. La commune se situe dans la même agglomération que notre implantation de Saint-Apollinaire, ce qui est pris en compte dans l\'étude du planning.',
		'Les premiers passages permettent de vérifier l\'adéquation entre le cahier des charges, le temps prévu et les contraintes des locaux. Si un écart significatif est constaté, Top-Famille Pro échange avec le client et peut proposer une adaptation de l\'organisation ou du volume horaire. Nous corrigeons alors le devis plutôt que de réduire silencieusement la liste des tâches, et toute évolution vous est proposée avant d\'être appliquée.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Fontaine-lès-Dijon, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Ahuy',
		'Daix',
		'Hauteville-lès-Dijon',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Fontaine-lès-Dijon', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Intervenez-vous auprès des cabinets de la commune ?', 'reponse' => 'Oui, pour l\'entretien courant de leurs locaux : accueil, salle d\'attente, bureaux, sanitaires et sols, avec consigne écrite de confidentialité.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Faites-vous du bio-nettoyage hospitalier ?', 'reponse' => 'Non. Nous entretenons les cabinets médicaux et paramédicaux courants. Les blocs, salles de soins critiques et laboratoires relèvent d\'entreprises spécialisées.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Des frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Pouvez-vous passer après la fermeture du cabinet ?', 'reponse' => 'Oui, c\'est un créneau pouvant être envisagé. La clé ou le code est remis contre décharge écrite, avec la procédure de fermeture consignée.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Entretenez-vous les parties communes des résidences ?', 'reponse' => 'Oui : hall, cage d\'escalier, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Fontaine-lès-Dijon ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, et le numéro est le même pour tous nos clients : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ fontaine-les-dijon\n";
}

/* ---------------- marsannay-la-cote (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'marsannay-la-cote', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone marsannay-la-cote absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Marsannay-la-Côte', $id );
	tfp_seed_set_field( 'hero_lede', 'Bureaux, espaces d\'accueil et de dégustation, commerces et parties communes : Top-Famille Pro entretient vos locaux à Marsannay-la-Côte, au sud de l\'agglomération dijonnaise.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Marsannay-la-Côte', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Marsannay-la-Côte', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Marsannay-la-Côte est une commune de Côte-d\'Or située au sud de l\'agglomération dijonnaise, sur la Côte viticole. Top-Famille Pro y entretient bureaux, espaces d\'accueil et de dégustation, commerces, cabinets courants, parties communes et locations meublées, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation est à Saint-Apollinaire. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Marsannay-la-Côte, entre agglomération et Côte viticole', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Marsannay-la-Côte se situe au sud de l\'agglomération dijonnaise, à l\'entrée de la Côte viticole. La commune associe un tissu résidentiel, des commerces et services de proximité, et une activité viticole avec des domaines qui reçoivent du public une bonne partie de l\'année.',
		'Notre implantation de Saint-Apollinaire se trouve dans la même agglomération. La commune fait partie de notre secteur prioritaire. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Les besoins susceptibles de nous être confiés se répartissent principalement entre :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Domaines et caveaux : espaces d\'accueil et de dégustation',
		'Bureaux de petites structures',
		'Commerces et services de proximité',
		'Cabinets et professions libérales',
		'Copropriétés et résidences',
		'Locations meublées et hébergements de courte durée',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Espaces d\'accueil et de dégustation : notre périmètre exact', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Pour un domaine ou une maison de négoce, nous entretenons les espaces qui reçoivent du public : espace d\'accueil, salle et comptoir de dégustation, vitrages intérieurs, sanitaires visiteurs, bureaux et salle de réunion. Le sol, souvent en pierre ou en carrelage ancien, est traité avec des produits adaptés au revêtement.',
		'Nous n\'intervenons pas dans les caves d\'élaboration, les chais, les zones de conditionnement ni les espaces soumis à un protocole sanitaire particulier. Cette limite est annoncée dès le premier échange et écrite au cahier des charges : elle évite tout malentendu lors du premier passage.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % la nuit, le dimanche et les jours fériés.',
		'Deux passages de 1 h 15 par semaine : espace d\'accueil, salle de dégustation, bureaux et sanitaires visiteurs. 279 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · espace d\'accueil et bureaux, 10 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'Nous recevons des visiteurs plusieurs jours par semaine : l\'espace d\'accueil et les sanitaires sont repris avant chaque période de forte fréquentation, comme convenu au devis.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Événements et périodes de forte fréquentation', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'Les domaines et les commerces de la commune connaissent des pics d\'activité : journées portes ouvertes, salons, périodes touristiques, fêtes locales. Un passage supplémentaire peut être organisé avant ou après ces temps forts, chiffré séparément au même tarif horaire, sans modifier le contrat régulier en place.',
		'Nous demandons simplement d\'être prévenus le plus tôt possible : le délai réalisable dépend du planning en cours. Une remise en état après événement peut également être traitée en intervention ponctuelle, avec un volume d\'heures estimé au devis.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Bureaux, commerces, cabinets et parties communes', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Pour un bureau, la prestation comprend corbeilles, dépoussiérage des surfaces libres, entretien des surfaces de contact courantes, sanitaires, coin cuisine, aspiration et lavage des sols. Pour un commerce, le passage se fait avant l\'ouverture, avec sanitaires clients et vitrages intérieurs.',
		'Entretien courant de l\'accueil, de la salle d\'attente, des bureaux, des sanitaires, des sols, du mobilier et des surfaces courantes, selon le cahier des charges. Les consignes de confidentialité sont annexées au cahier des charges. Pour une résidence, nous traitons hall, cage d\'escalier, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Fonctionnement, sélection et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Une visite précède le devis : relevé des surfaces, des revêtements — pierre, carrelage ancien, parquet —, des accès et des horaires d\'ouverture au public, puis cahier des charges espace par espace et devis sous 24 heures, sans engagement de durée.',
		'Les intervenants sont recrutés par Audrey, avec vérification des références et observation sur site. Nous cherchons à maintenir le même intervenant sur la durée ; en cas d\'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement. Un cahier de liaison reste sur place.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la commune, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Commerces de proximité',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Marsannay-la-Côte, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Couchey',
		'Perrigny-lès-Dijon',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Marsannay-la-Côte', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Entretenez-vous les caves et les chais ?', 'reponse' => 'Non. Nous intervenons sur les espaces d\'accueil, de dégustation et de bureau, ainsi que sur les sanitaires visiteurs. Les caves d\'élaboration et zones de conditionnement ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Un passage supplémentaire avant une journée portes ouvertes est-il possible ?', 'reponse' => 'Oui, chiffré séparément au même tarif de 27 € HT/h. Prévenez-nous le plus tôt possible : le délai réalisable dépend du planning en cours.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Des frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Comment traitez-vous les sols en pierre ancienne ?', 'reponse' => 'Avec des produits adaptés au revêtement, relevés lors de la visite et notés au cahier des charges. Nous n\'appliquons pas de protocole standard sur un sol ancien.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Intervenez-vous aussi pour les commerces et cabinets ?', 'reponse' => 'Oui, au même tarif, avec un passage avant ouverture pour les commerces et un créneau de fin de journée pour les cabinets.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Avez-vous un bureau à Marsannay-la-Côte ?', 'reponse' => 'Non. Notre unique implantation est à Saint-Apollinaire, et le numéro est identique pour tous nos clients : 06 36 17 63 39.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ marsannay-la-cote\n";
}

/* ---------------- beaune (commune) ---------------- */
$posts = get_posts( array( 'post_type' => 'zone', 'name' => 'beaune', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! zone beaune absente — lancer d'abord les seeds de phase 2/3\n";
} else {
	$id = $posts[0]->ID;
	tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Beaune', $id );
	tfp_seed_set_field( 'hero_lede', 'Commerces, cabinets, bureaux, hébergements et parties communes : Top-Famille Pro entretient vos locaux à Beaune, au cœur de la Côte viticole.', $id );
	tfp_seed_set_field( 'hero_alt', 'Locaux professionnels à Beaune', $id );
	tfp_seed_set_field( 'cta_label', 'Demander un devis à Beaune', $id );
	tfp_seed_set_field( 'cta_phone_label', '☎ Échanger avec Audrey', $id );
	tfp_seed_set_field( 'band_items', '', $id );
	tfp_seed_set_field( 'reponse_directe', 'Beaune est une commune de Côte-d\'Or située au sud du département, sur la Côte viticole. Top-Famille Pro y entretient commerces, cabinets courants, bureaux, espaces d\'accueil et de dégustation, locations meublées et parties communes d\'immeubles, en contrat régulier ou en intervention ponctuelle, au tarif de 27 € HT/h. Notre implantation est à Saint-Apollinaire, près de Dijon. Devis gratuit sous 24 heures au 06 36 17 63 39.', $id );
	tfp_seed_set_field( 'recit_1_titre', 'Beaune, second pôle de notre présence en Côte-d\'Or', $id );
	tfp_seed_set_field( 'recit_1_texte', implode( "\n", array(
		'Beaune est notre second secteur départemental après l\'agglomération dijonnaise. La ville est desservie par l\'axe autoroutier, ce qui est pris en compte dans l\'organisation du planning.',
		'Ce n\'est pas une commune de la périphérie dijonnaise : Beaune a son propre bassin, avec les communes viticoles qui l\'entourent — Chorey-les-Beaune, Savigny-lès-Beaune, Montagny-lès-Beaune, Levernois, Pommard. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning. Nous n\'avons ni agence ni bureau sur place.',
	) ), $id );
	tfp_seed_set_field( 'recit_1_liste', '', $id );
	tfp_seed_set_field( 'recit_2_titre', 'Les professionnels que nous accompagnons ici', $id );
	tfp_seed_set_field( 'recit_2_texte', implode( "\n", array(
		'Beaune vit du vin, du tourisme et du commerce, avec un centre historique très fréquenté. Parmi les professionnels susceptibles de faire appel à Top-Famille Pro :',
	) ), $id );
	tfp_seed_set_field( 'recit_2_liste', implode( "\n", array(
		'Commerces indépendants du centre historique',
		'Domaines et maisons de négoce : accueil et dégustation',
		'Hébergements et locations meublées de courte durée',
		'Cabinets et professions libérales',
		'Bureaux de PME et sièges locaux',
		'Copropriétés et résidences',
	) ), $id );
	tfp_seed_set_field( 'recit_3_titre', 'Commerces du centre historique', $id );
	tfp_seed_set_field( 'recit_3_texte', implode( "\n", array(
		'Le centre intra-muros est un environnement bâti ancien : rues étroites, accès véhicule limité, revêtements variés — pierre, carrelage ancien, parquet. Ces contraintes sont relevées lors de la visite et intégrées au cahier des charges, y compris le choix des produits et le matériel transportable à pied.',
		'Le passage se fait avant l\'ouverture : surface de vente aspirée puis lavée, sanitaires clients, comptoir, vitrages intérieurs, abords de la vitrine, sortie des cartons. En haute saison touristique, la fréquence est souvent portée à six passages par semaine, avec un créneau plus long les jours d\'affluence.',
	) ), $id );
	tfp_seed_set_field( 'recit_3_liste', '', $id );
	tfp_seed_set_field( 'tarif_titre', 'Tarif et exemple local', $id );
	tfp_seed_set_field( 'tarif_texte', implode( "\n", array(
		'27 € HT/h, plus 9 € HT/mois de gestion en contrat régulier et 50 € HT de frais de mise en place, le cas échéant, selon les conditions précisées au devis. Beaune se trouve au sud du département, sur un bassin distinct de l\'agglomération dijonnaise. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Majoration de 10 % la nuit, le dimanche et les jours fériés.',
		'Un passage d\'une heure avant ouverture, du mardi au samedi : surface de vente, sanitaires clients, vitrages intérieurs, réserve hebdomadaire. 441 € HT/mois.',
	) ), $id );
	tfp_seed_set_field( 'exemple_label', 'Exemple · commerce intra-muros, 16 h/mois', $id );
	tfp_seed_set_field( 'temoignage_texte', 'En haute saison, le passage avant ouverture fait une vraie différence sur la tenue du magasin. Les créneaux sont convenus à l\'avance, ce qui nous évite les mauvaises surprises.', $id );
	tfp_seed_set_field( 'temoignage_auteur', 'Client Top-Famille Pro', $id );
	tfp_seed_set_field( 'temoignage_role', 'Avis général · Côte-d\'Or', $id );
	tfp_seed_set_field( 'methode_1_titre', 'Hébergements et locations meublées', $id );
	tfp_seed_set_field( 'methode_1_texte', implode( "\n", array(
		'L\'activité touristique génère une demande importante sur les meublés de courte durée. Nous intervenons entre deux séjours : ménage complet ; le changement de linge, la vérification des consommables, le contrôle de l\'état du logement et le signalement photographique des dégradations sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis.',
		'Le créneau est calé sur vos horaires de départ et d\'arrivée, ce qui suppose une organisation anticipée en haute saison : les plages entre 10 h et 15 h sont très demandées. Nous conseillons de réserver les créneaux à l\'avance sur juillet, août et les périodes de grands événements viticoles.',
	) ), $id );
	tfp_seed_set_field( 'methode_1_liste', '', $id );
	tfp_seed_set_field( 'methode_2_titre', 'Domaines, bureaux, cabinets et copropriétés', $id );
	tfp_seed_set_field( 'methode_2_texte', implode( "\n", array(
		'Pour un domaine ou une maison de négoce, nous entretenons les espaces recevant du public — accueil, salle et comptoir de dégustation, sanitaires visiteurs — ainsi que les bureaux et salles de réunion. Nous n\'intervenons pas dans les caves d\'élaboration, les chais ni les zones de conditionnement.',
		'Pour les bureaux, la prestation comprend corbeilles, dépoussiérage, entretien des surfaces de contact courantes, sanitaires, coin cuisine et sols. Pour les cabinets, le cahier des charges prévoit l\'entretien courant des espaces recevant du public et des bureaux, avec consigne de confidentialité. Pour les immeubles, nous traitons hall, cage d\'escalier, paliers, ascenseur, local à conteneurs et sortie des bacs possible lorsque prévu dans le cahier des charges et chiffré dans le devis, selon le calendrier de collecte applicable à l\'adresse.',
	) ), $id );
	tfp_seed_set_field( 'methode_2_liste', '', $id );
	tfp_seed_set_field( 'methode_3_titre', 'Fonctionnement, saisonnalité et suivi', $id );
	tfp_seed_set_field( 'methode_3_texte', implode( "\n", array(
		'Une visite précède le devis : surfaces, revêtements, accès, horaires d\'ouverture et contraintes de circulation dans le centre. Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis.',
		'La saisonnalité beaunoise est forte : nous en tenons compte dans le contrat, en prévoyant la possibilité d\'ajuster la fréquence entre haute et basse saison plutôt que de facturer douze mois au rythme de juillet. Un cahier de liaison reste sur site et les modalités de suivi sont définies avec le client.',
	) ), $id );
	tfp_seed_set_field( 'methode_3_liste', '', $id );
	tfp_seed_set_field( 'locaux_1_titre', 'Nos prestations sur place', $id );
	tfp_seed_set_field( 'locaux_1_texte', implode( "\n", array(
		'Même méthode que partout ailleurs : celle de notre page nettoyage professionnel, avec le tarif de 27 € HT/h.',
		'Six prestations, un seul interlocuteur. Nous intervenons sur les espaces compatibles avec notre offre : bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants.',
	) ), $id );
	tfp_seed_set_field( 'locaux_1_type', 'prestations', $id );
	tfp_seed_set_field( 'locaux_1_section', 5, $id );
	tfp_seed_set_field( 'locaux_1_noms', '', $id );
	tfp_seed_set_field( 'locaux_2_titre', 'Quartiers et zones d\'activité', $id );
	tfp_seed_set_field( 'locaux_2_texte', implode( "\n", array(
		'Nous intervenons dans l\'ensemble de la ville, sans secteur réservé :',
	) ), $id );
	tfp_seed_set_field( 'locaux_2_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_2_section', 8, $id );
	tfp_seed_set_field( 'locaux_2_noms', implode( "\n", array(
		'Centre-ville',
		'Quartiers résidentiels',
		'Zones d\'activité',
		'Secteurs commerçants',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_titre', 'Communes proches desservies', $id );
	tfp_seed_set_field( 'locaux_3_texte', implode( "\n", array(
		'Communes proches de Beaune, dans le même bassin géographique :',
	) ), $id );
	tfp_seed_set_field( 'locaux_3_type', 'noms', $id );
	tfp_seed_set_field( 'locaux_3_section', 8, $id );
	tfp_seed_set_field( 'locaux_3_noms', implode( "\n", array(
		'Chorey-les-Beaune',
		'Savigny-lès-Beaune',
		'Montagny-lès-Beaune',
		'Levernois',
		'Bligny-lès-Beaune',
		'Pommard',
	) ), $id );
	tfp_seed_set_field( 'locaux_4_titre', 'Dans le même département', $id );
	tfp_seed_set_field( 'locaux_4_texte', '', $id );
	tfp_seed_set_field( 'locaux_4_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_4_section', 9, $id );
	tfp_seed_set_field( 'locaux_4_noms', '', $id );
	tfp_seed_set_field( 'locaux_5_titre', 'Autres secteurs couverts en région', $id );
	tfp_seed_set_field( 'locaux_5_texte', implode( "\n", array(
		'Villes éloignées, couvertes depuis Saint-Apollinaire — ce ne sont pas des communes voisines.',
	) ), $id );
	tfp_seed_set_field( 'locaux_5_type', 'villes', $id );
	tfp_seed_set_field( 'locaux_5_section', 9, $id );
	tfp_seed_set_field( 'locaux_5_noms', '', $id );
	tfp_seed_set_field( 'locaux_6_titre', 'Aller plus loin', $id );
	tfp_seed_set_field( 'locaux_6_texte', implode( "\n", array(
		'Des guides locaux (fréquences, budget, cahier des charges) viendront compléter cette page.',
	) ), $id );
	tfp_seed_set_field( 'locaux_6_type', 'liens', $id );
	tfp_seed_set_field( 'locaux_6_section', 9, $id );
	tfp_seed_set_field( 'locaux_6_noms', '', $id );
	tfp_seed_set_field( 'locaux_avant_tarif', 1, $id );
	tfp_seed_set_field( 'faq_titre', 'Questions fréquentes — Beaune', $id );
	tfp_seed_set_field( 'faq_1', array( 'question' => 'Beaune est-elle une commune voisine de Dijon ?', 'reponse' => 'Non. Beaune est située au sud de la Côte-d\'Or, sur un bassin distinct de l\'agglomération dijonnaise, avec ses propres communes voisines.' ), $id );
	tfp_seed_set_field( 'faq_2', array( 'question' => 'Des frais de déplacement s\'appliquent-ils ?', 'reponse' => 'Les éventuelles indemnités kilométriques dépendent de l\'adresse des locaux, du planning et des conditions d\'intervention. Elles sont précisées dans le devis. Elles restent modérées compte tenu de la distance et sont chiffrées au devis avant signature.' ), $id );
	tfp_seed_set_field( 'faq_3', array( 'question' => 'Pouvez-vous ajuster la fréquence entre haute et basse saison ?', 'reponse' => 'Oui, c\'est prévu dans le contrat : la fréquence et le volume d\'heures peuvent être modulés selon la saison, par devis actualisé et sans engagement de durée.' ), $id );
	tfp_seed_set_field( 'faq_4', array( 'question' => 'Intervenez-vous dans les caves et les chais ?', 'reponse' => 'Non. Nous entretenons les espaces d\'accueil, de dégustation, les bureaux et les sanitaires visiteurs. Les caves d\'élaboration et zones de conditionnement ne font pas partie de notre offre.' ), $id );
	tfp_seed_set_field( 'faq_5', array( 'question' => 'Entretenez-vous les locations meublées entre deux séjours ?', 'reponse' => 'Oui : ménage complet ; le changement de linge, la vérification des consommables et le signalement photographique des dégradations sont possible lorsque prévu dans le cahier des charges et chiffré dans le devis. Réservez les créneaux à l\'avance en haute saison.' ), $id );
	tfp_seed_set_field( 'faq_6', array( 'question' => 'Intervenez-vous à Savigny-lès-Beaune ou Pommard ?', 'reponse' => 'Oui, ces communes voisines sont proches de Beaune. Les demandes situées dans ces communes peuvent être étudiées selon l\'adresse exacte, le volume horaire et les possibilités d\'organisation du planning.' ), $id );
	tfp_seed_set_field( 'faq_7', array( 'question' => 'Avez-vous un bureau à Beaune ?', 'reponse' => 'Non, et nous n\'en avons jamais eu. L\'entreprise est domiciliée à Saint-Apollinaire ; les interventions beaunoises sont organisées depuis cette adresse, avec le même numéro qu\'ailleurs.' ), $id );
	tfp_seed_set_field( 'contact_titre', 'Nous contacter', $id );
	tfp_seed_set_field( 'contact_texte', 'Audrey est votre interlocutrice unique, de la première visite au suivi mensuel. Un seul numéro pour toute la région : 06 36 17 63 39 — ou par e-mail à audrey.b@top-famille.fr. Nous n\'utilisons pas de numéro local différent selon la commune.', $id );
	tfp_seed_set_field( 'cta_titre', 'Un devis pour vos locaux', $id );
	tfp_seed_set_field( 'cta_texte', 'Gratuit, sous 24 h, sans engagement, au tarif de 27 € HT/h.', $id );
	echo "  ✓ beaune\n";
}

echo "Terminé.\n";
