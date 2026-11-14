<?php
/**
 * Phase 3, lot 1 — les 5 prestations restantes (commerces, cabinets, copropriétés, locations
 * meublées, ponctuel). Bureaux a été créée en phase 2 (bin/seed-phase2-content.php).
 *
 * Contenu repris du prototype (reference/Top-Famille-Pro-HANDOFF-READY.html), corrigé selon
 * CLAUDE.md §9 : tous les avis de démonstration retirés, tarif réel appliqué (27,00 € HT/h, tarif
 * unique en régulier comme en ponctuel — mis à jour le 9 août 2026, hotfix fidélité Claude Design ;
 * remplace l'ancienne grille à trois montants 24,30/26,00/30,00 € qui avait initialement corrigé le
 * tarif fictif du prototype, PROJECT_INPUTS.md §5), aucune donnée de délai/distance inventée.
 * Titles vérifiés ≤ 65 caractères (docs/INVENTAIRE-ROUTES.md signalait cabinets/copropriétés/
 * meublés en dépassement).
 *
 * Usage : wp eval-file bin/seed-phase3-batch1-prestations.php
 * Idempotent (mêmes fonctions utilitaires que bin/seed-phase2-content.php).
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch1-prestations.php\n" );
}

if ( ! function_exists( 'tfp_seed_upsert_post' ) ) {
	function tfp_seed_upsert_post( array $args ) {
		$existing = get_posts( array( 'post_type' => $args['post_type'], 'name' => $args['post_name'], 'numberposts' => 1, 'post_status' => 'any' ) );
		if ( ! empty( $existing ) ) {
			$args['ID'] = $existing[0]->ID;
			wp_update_post( $args );
			return $args['ID'];
		}
		return wp_insert_post( $args );
	}
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
if ( ! function_exists( 'tfp_seed_faq' ) ) {
	function tfp_seed_faq( $prefix, array $faqs, $post_id ) {
		foreach ( $faqs as $i => $item ) {
			tfp_seed_set_field( $prefix . '_' . ( $i + 1 ), array( 'question' => $item['q'], 'reponse' => $item['a'] ), $post_id );
		}
	}
}

echo "=== Seed phase 3, lot 1 : 5 prestations restantes ===\n";

/* ------------------------------------------------------------------ */
/* 1. Commerces                                                        */
/* ------------------------------------------------------------------ */

$commerces_id = tfp_seed_upsert_post( array( 'post_type' => 'prestation', 'post_title' => 'Nettoyage de commerces', 'post_name' => 'commerces', 'post_status' => 'publish' ) );

tfp_seed_set_field( 'h1', 'Nettoyage de commerces et de surfaces de vente', $commerces_id );
tfp_seed_set_field( 'tease', 'Boutiques, showrooms, surfaces de vente', $commerces_id );
tfp_seed_set_field( 'reponse_directe', "Une surface de vente impeccable à l'ouverture : sols, vitrines et sanitaires clients entretenus avant l'arrivée de vos premiers visiteurs. Nous adaptons nos horaires à vos jours et heures d'ouverture, y compris tôt le matin.", $commerces_id );
tfp_seed_set_field( 'pour_qui', "Boutiques et prêt-à-porter, showrooms, salons et instituts, points de vente en centre-ville comme en zone commerciale : la propreté d'un commerce influence directement l'image perçue par vos clients.", $commerces_id );
tfp_seed_set_field( 'taches', implode( "\n", array(
	'Nettoyage et lustrage des sols',
	'Vitrines : incluses uniquement lorsqu\'elles sont accessibles sans équipement spécialisé et prévues au devis',
	'Cabines et mobilier de vente',
	'Sanitaires clients et personnel',
	'Dépoussiérage des rayonnages',
	'Espace caisse et accueil',
) ), $commerces_id );
tfp_seed_set_field( 'problemes', implode( "\n", array(
	"Une vitrine ternie ou des sols marqués dès l'ouverture donnent une image négative avant même l'arrivée du premier client.",
	"Les jours de forte affluence (soldes, marché, week-end) demandent parfois un passage supplémentaire pour tenir la surface de vente propre toute la journée.",
) ), $commerces_id );
tfp_seed_set_field( 'organisation', "Les produits adaptés aux sols de la boutique (parquet, carrelage, résine) et aux vitrines sont généralement fournis par vos soins, pour respecter les préconisations de votre agencement ; tout consommable à renouveler est signalé via le cahier de liaison. L'accès est organisé selon votre rythme (remise de clés pour une intervention avant ouverture, ou passage en votre présence), code d'alarme et consignes de fermeture consignés par écrit. Nous sélectionnons un intervenant habitué aux contraintes du commerce, avec un soin particulier apporté aux surfaces visibles par la clientèle, et privilégions autant que possible sa continuité d'une semaine sur l'autre sans pouvoir la garantir de façon absolue. Le cahier de liaison trace les passages et permet de signaler toute anomalie ; Audrey reste votre interlocutrice pour ajuster la fréquence selon la saison. En cas d'absence de l'intervenant habituel, une solution de remplacement est recherchée en priorité, sans garantie de remplacement immédiat dans tous les cas.", $commerces_id );
tfp_seed_set_field( 'config_1_titre', "Boutique de moins de 100 m²", $commerces_id );
tfp_seed_set_field( 'config_1_texte', "Un passage quotidien court avant ouverture suffit généralement : sol de la surface de vente, seuil d'entrée, vitrine côté intérieur et sanitaire. Le volume mensuel reste modeste mais la régularité prime, car la première impression se joue à l'ouverture.", $commerces_id );
tfp_seed_set_field( 'config_2_titre', "Surface de 100 à 400 m²", $commerces_id );
tfp_seed_set_field( 'config_2_texte', "Au-delà de cent mètres carrés, la cabine d'essayage, la réserve et les zones de caisse demandent un traitement distinct du reste de la surface. Un passage quotidien avant ouverture, complété d'un passage plus long en début de semaine, correspond souvent au besoin réel.", $commerces_id );
tfp_seed_set_field( 'config_3_titre', "Plusieurs surfaces ou galerie", $commerces_id );
tfp_seed_set_field( 'config_3_texte', "Pour plusieurs points de vente ou un emplacement en galerie, le planning est calé sur les horaires du centre et les livraisons. Les tâches sont réparties par zone et le cahier des charges précise ce qui relève de la surface privative et des parties communes.", $commerces_id );
tfp_seed_set_field( 'semaine_type', "Pour une boutique de 200 m² ouverte du mardi au samedi, avec passage quotidien entre 7 h et 8 h 30 : chaque matin, sol de la surface de vente, seuil, traces sur la vitrine côté intérieur, sanitaire et corbeilles ; le mardi s'ajoutent les cabines d'essayage en profondeur ; le samedi, un passage renforcé sur les zones de caisse et la réserve avant le week-end. Découpage indicatif, arrêté avec vous au cahier des charges.", $commerces_id );
tfp_seed_set_field( 'exclusions', "Hors prestation courante : nettoyage de vitrines en hauteur nécessitant une nacelle, manipulation ou rangement de la marchandise, entretien de stocks en réserve durablement encombrée, désinfection réglementée en environnement agroalimentaire.", $commerces_id );
tfp_seed_set_field( 'materiel_rappel', true, $commerces_id );
tfp_seed_faq( 'faq', array(
	array( 'q' => "Pouvez-vous intervenir avant l'ouverture, très tôt le matin ?", 'a' => "Oui, c'est le cas le plus fréquent pour les commerces : nous nous calons sur votre heure d'ouverture réelle." ),
	array( 'q' => 'Un passage supplémentaire est-il possible un jour de forte affluence ?', 'a' => "Oui, sur devis complémentaire, par exemple avant un week-end de soldes ou un marché." ),
	array( 'q' => 'Les vitrines extérieures sont-elles comprises ?', 'a' => "Les vitrines sont incluses uniquement lorsqu'elles sont accessibles sans équipement spécialisé et prévues au devis. Les vitrines en hauteur, les enseignes et les surfaces nécessitant une nacelle ou une perche télescopique en sont exclues." ),
	array( 'q' => 'Comment adaptez-vous la prestation aux sols fragiles ?', 'a' => "Parquet huilé, béton ciré, résine, marbre ou pierre naturelle ne supportent pas les mêmes produits ni les mêmes quantités d'eau. Nous relevons la nature exacte de vos revêtements au moment du cahier des charges et appliquons les préconisations de votre agenceur, avec les produits que vous mettez à disposition." ),
	array( 'q' => 'Que faites-vous des réserves et de l\'arrière-boutique ?', 'a' => "Les réserves sont traitées lorsqu'elles sont dégagées et accessibles : sol, poubelles et surfaces libres. Nous ne déplaçons pas les stocks ni le mobilier de rangement ; une zone durablement encombrée est signalée dans le cahier de liaison." ),
	array( 'q' => 'Les cabines d\'essayage sont-elles comprises ?', 'a' => "Oui : sol, miroir, banquette ou tabouret, patères et rideau ou porte. Les articles oubliés par la clientèle sont rassemblés à un endroit convenu avec vous plutôt que remis en rayon." ),
	array( 'q' => 'Adaptez-vous la fréquence selon la saison ?', 'a' => "Oui, c'est fréquent dans le commerce : soldes, fêtes de fin d'année, période estivale ou marché hebdomadaire modifient la fréquentation. Un renfort temporaire peut être prévu par avenant au devis, puis retiré lorsque la période s'achève." ),
), $commerces_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage de commerces et surfaces de vente | Top-Famille Pro', $commerces_id );
tfp_seed_set_field( 'seo_description', "Nettoyage de commerces et boutiques avant ouverture : sols, vitrines, cabines, sanitaires. Intervenant habituel recherché, devis gratuit sous 24 h.", $commerces_id );

echo "  Prestation commerces : #$commerces_id\n";

/* ------------------------------------------------------------------ */
/* 2. Cabinets & professions libérales                                 */
/* ------------------------------------------------------------------ */

$cabinets_id = tfp_seed_upsert_post( array( 'post_type' => 'prestation', 'post_title' => 'Nettoyage de cabinets', 'post_name' => 'cabinets', 'post_status' => 'publish' ) );

tfp_seed_set_field( 'h1', 'Nettoyage de cabinets et de professions libérales', $cabinets_id );
tfp_seed_set_field( 'config_1_titre', "Cabinet individuel", $cabinets_id );
tfp_seed_set_field( 'config_1_texte', "Un praticien seul se traite le plus souvent en deux passages hebdomadaires en dehors des consultations : salle d'attente, sanitaire, sol du cabinet et points de contact. Le volume mensuel reste contenu, mais la discrétion et la ponctualité conditionnent tout.", $cabinets_id );
tfp_seed_set_field( 'config_2_titre', "Cabinet de groupe", $cabinets_id );
tfp_seed_set_field( 'config_2_texte', "À plusieurs praticiens, la salle d'attente et les sanitaires deviennent le point de charge principal : ils sont utilisés en continu toute la journée. Trois passages hebdomadaires, dont un plus long, correspondent généralement au besoin.", $cabinets_id );
tfp_seed_set_field( 'config_3_titre', "Maison de santé ou plateau pluridisciplinaire", $cabinets_id );
tfp_seed_set_field( 'config_3_texte', "Sur un plateau regroupant plusieurs spécialités, le passage devient quotidien pour les circulations et les sanitaires. Le cahier des charges distingue clairement les espaces accessibles au public de ceux qui ne le sont pas, et rappelle les locaux exclus de la prestation.", $cabinets_id );
tfp_seed_set_field( 'semaine_type', "Pour un cabinet de trois praticiens avec passage le lundi, le mercredi et le vendredi après 19 h : à chaque passage, salle d'attente, sanitaires, sols des circulations, poignées et interrupteurs ; le mercredi s'ajoute le dépoussiérage des bureaux et des assises ; le vendredi, les vitres intérieures et une remise en ordre complète avant le week-end. Aucun document laissé sur un bureau n'est déplacé. Découpage indicatif, arrêté au cahier des charges.", $cabinets_id );
tfp_seed_set_field( 'tease', 'Cabinets médicaux, paramédicaux, juridiques et de conseil', $cabinets_id );
tfp_seed_set_field( 'reponse_directe', "L'entretien courant des cabinets médicaux, paramédicaux, juridiques et de conseil : accueil, salle d'attente, bureaux, sanitaires et sols, en dehors des heures de consultation et dans le respect de la confidentialité. C'est un entretien courant de locaux recevant du public — aucun protocole médical n'en fait partie.", $cabinets_id );
tfp_seed_set_field( 'pour_qui', "Cabinets médicaux et paramédicaux, cabinets dentaires, avocats, notaires, experts-comptables, conseil et architecture : une salle d'attente très fréquentée se dégrade vite et se remarque immédiatement.", $cabinets_id );
tfp_seed_set_field( 'taches', implode( "\n", array(
	"Accueil, banque d'accueil et circulations",
	'Salle d\'attente : sièges, tables, surfaces de contact courantes',
	'Bureaux de consultation : entretien courant du mobilier',
	"Sanitaires et points d'eau",
	"Sols de l'ensemble des locaux",
	'Mobilier courant et vitrages intérieurs accessibles',
	'Corbeilles et points de collecte courants',
) ), $cabinets_id );
tfp_seed_set_field( 'problemes', implode( "\n", array(
	"Une salle d'attente très fréquentée concentre les surfaces de contact courantes — poignées, accoudoirs, comptoir d'accueil — et se dégrade visiblement en une seule journée de forte affluence.",
	"La confidentialité des dossiers et des échanges impose un cadre d'intervention strict : passage en dehors des heures de consultation, aucune manipulation de document, zones d'accès délimitées au cahier des charges.",
) ), $cabinets_id );
tfp_seed_set_field( 'organisation', "Les produits d'entretien courants et le matériel sont généralement fournis par le cabinet, ce qui garantit l'usage de références déjà validées ; aucun produit à visée médicale n'est introduit et rien n'est appliqué sur une surface liée au soin. L'accès est organisé en dehors des heures de consultation (clés, code d'alarme ou badge), avec un protocole strict de fermeture transmis uniquement aux intervenants concernés. L'intervenant est sélectionné avec une attention particulière portée à la discrétion et à la confidentialité des dossiers, en plus de sa fiabilité générale. Un cahier de liaison reste sur place pour tracer les passages et signaler toute anomalie ; Audrey suit la prestation dans la durée. En cas d'absence de l'intervenant habituel, une solution de remplacement est recherchée activement, sans garantie de remplacement immédiat dans tous les cas.", $cabinets_id );
tfp_seed_set_field( 'exclusions', "Cette prestation est un entretien courant de locaux professionnels. Elle ne comprend ni bio-nettoyage hospitalier, ni stérilisation d'instruments ou de matériel, ni gestion, manipulation ou évacuation des déchets d'activité de soins à risques infectieux (DASRI), ni entretien du matériel médical et des surfaces de soin, ni intervention en bloc opératoire ou salle de soins critiques.", $cabinets_id );
tfp_seed_set_field( 'materiel_rappel', true, $cabinets_id );
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Intervenez-vous entre deux patients ?', 'a' => "Non. Notre passage a lieu en dehors des heures de consultation, en début ou en fin de journée. Ce qui se fait entre deux patients relève entièrement du protocole du praticien." ),
	array( 'q' => 'Traitez-vous les déchets médicaux ?', 'a' => "Non. Les déchets d'activité de soins à risques infectieux (DASRI) ne sont ni manipulés ni évacués par nos intervenants. Nous gérons uniquement les corbeilles et points de collecte courants." ),
	array( 'q' => "L'intervenant est-il informé des règles de confidentialité ?", 'a' => "Oui. Les consignes figurent au cahier des charges : aucun document n'est déplacé, ouvert ou trié, et les zones d'accès réservé sont identifiées par écrit avant le premier passage." ),
	array( 'q' => 'Faites-vous du bio-nettoyage ou de la désinfection médicale ?', 'a' => "Non. Le bio-nettoyage hospitalier, la stérilisation, la désinfection réglementée de salle d'intervention et tout protocole médical spécialisé sortent de notre périmètre et relèvent de prestataires spécialisés." ),
	array( 'q' => 'Nettoyez-vous le matériel de soin et les fauteuils d\'examen ?', 'a' => "Non. Le matériel médical et les surfaces directement liées au soin restent sous la responsabilité du praticien. Nous intervenons sur le mobilier courant, les sols, les sanitaires et les surfaces de contact courantes." ),
	array( 'q' => 'À quelle fréquence faut-il faire nettoyer un cabinet ?', 'a' => "Cela dépend du nombre de praticiens et de patients reçus par jour. Un cabinet individuel se satisfait souvent de deux à trois passages par semaine ; un cabinet de groupe recevant du public en continu justifie généralement un passage quotidien." ),
	array( 'q' => "Comment se passe l'accès en dehors des heures d'ouverture ?", 'a' => "Les modalités sont définies avec vous et consignées par écrit : remise de clés, badge ou code, protocole de fermeture et de réactivation de l'alarme, transmis uniquement aux intervenants concernés par votre cabinet." ),
	array( 'q' => 'Le même intervenant vient-il à chaque passage ?', 'a' => "C'est l'organisation que nous recherchons. Cette continuité est privilégiée autant que possible, sans constituer une garantie absolue : en cas d'absence, nous recherchons activement une solution et vous informons de l'organisation retenue." ),
), $cabinets_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage de cabinets et professions libérales | Top-Famille Pro', $cabinets_id );
tfp_seed_set_field( 'seo_description', "Entretien courant de cabinets médicaux, paramédicaux et libéraux : accueil, salle d'attente, sanitaires, sols. Confidentialité respectée, devis gratuit sous 24 h.", $cabinets_id );

echo "  Prestation cabinets : #$cabinets_id\n";

/* ------------------------------------------------------------------ */
/* 3. Copropriétés & parties communes                                  */
/* ------------------------------------------------------------------ */

$copro_id = tfp_seed_upsert_post( array( 'post_type' => 'prestation', 'post_title' => 'Entretien de copropriétés', 'post_name' => 'coproprietes', 'post_status' => 'publish' ) );

tfp_seed_set_field( 'h1', 'Entretien de copropriétés et de parties communes', $copro_id );
tfp_seed_set_field( 'config_1_titre', "Petit immeuble, jusqu'à 10 lots", $copro_id );
tfp_seed_set_field( 'config_1_texte', "Un à deux passages hebdomadaires suffisent généralement : hall, boîtes aux lettres, escalier principal et local poubelles. La sortie et la rentrée des conteneurs suivent le calendrier de collecte de la commune.", $copro_id );
tfp_seed_set_field( 'config_2_titre', "Immeuble de 10 à 40 lots", $copro_id );
tfp_seed_set_field( 'config_2_texte', "Au-delà d'une dizaine de lots, l'escalier et l'ascenseur se salissent nettement plus vite. Deux à trois passages hebdomadaires sont courants, avec un traitement des paliers en alternance par étage plutôt qu'un passage uniforme partout.", $copro_id );
tfp_seed_set_field( 'config_3_titre', "Résidence ou plusieurs bâtiments", $copro_id );
tfp_seed_set_field( 'config_3_texte', "Sur une résidence de plusieurs cages, le planning est réparti par bâtiment et par jour, avec un passage quotidien sur les zones d'entrée. Les prestations extérieures éventuelles sont chiffrées séparément et précisées au devis.", $copro_id );
tfp_seed_set_field( 'semaine_type', "Pour un immeuble de 24 lots sur quatre étages, avec passage le mardi et le vendredi matin : le mardi, hall, boîtes aux lettres, ascenseur, escalier du rez-de-chaussée au deuxième étage et local poubelles ; le vendredi, hall et ascenseur à nouveau, escalier du deuxième au quatrième étage, plus la sortie et la rentrée des conteneurs selon le calendrier de collecte. Découpage indicatif, arrêté avec le syndic ou le conseil syndical.", $copro_id );
tfp_seed_set_field( 'tease', 'Halls, cages d\'escalier, ascenseurs, parties communes', $copro_id );
tfp_seed_set_field( 'reponse_directe', "L'entretien régulier des halls, cages d'escalier, ascenseurs et locaux communs, pour des résidences et immeubles tertiaires soignés au quotidien. Nous travaillons avec les syndics, gestionnaires et propriétaires, selon une fréquence définie et suivie via un cahier de liaison.", $copro_id );
tfp_seed_set_field( 'pour_qui', "Syndics de copropriété, gestionnaires d'immeubles, bailleurs et propriétaires, résidences tertiaires : des halls et cages d'escalier négligés sont souvent la première source de réclamation en copropriété.", $copro_id );
tfp_seed_set_field( 'taches', implode( "\n", array(
	'Halls et entrées',
	"Cages d'escalier, rampes et paliers",
	'Ascenseurs : cabine, portes, miroir',
	"Local poubelles et sortie des conteneurs : possibles lorsqu'ils sont prévus et chiffrés dans le devis",
	'Vitrages des parties communes accessibles sans équipement spécialisé',
	'Local vélos et parkings couverts',
	'Boîtes aux lettres et surfaces de contact courantes',
) ), $copro_id );
tfp_seed_set_field( 'problemes', implode( "\n", array(
	"Des halls et cages d'escalier négligés sont souvent la première source de réclamation en copropriété.",
	"La sortie et la rentrée des conteneurs aux jours de collecte demandent une organisation précise avec le syndic : elles sont possibles lorsqu'elles sont prévues et chiffrées dans le devis.",
) ), $copro_id );
tfp_seed_set_field( 'organisation', "Les produits et le matériel sont généralement fournis ou budgétés par la copropriété, selon les modalités validées en assemblée générale. L'accès aux parties communes se fait via un jeu de clés ou un badge confié par le syndic, consigné par écrit. Nous sélectionnons un intervenant habitué à travailler en copropriété, capable d'échanger ponctuellement avec des résidents et de respecter les horaires validés par le conseil syndical. Le cahier de liaison, consultable par les résidents et le syndic, trace chaque passage et permet de signaler une remarque qu'Audrey relaie si besoin. En cas d'absence de l'intervenant habituel, une solution de remplacement est recherchée activement et le syndic informé de l'organisation retenue, sans garantie de remplacement immédiat dans tous les cas.", $copro_id );
tfp_seed_set_field( 'exclusions', "Le nettoyage du local poubelles et la sortie des conteneurs sont possibles lorsqu'ils sont prévus et chiffrés dans le devis. Hors prestation : désinsectisation, dératisation, entretien des espaces verts, déneigement, vitrages en hauteur nécessitant un équipement spécialisé.", $copro_id );
tfp_seed_set_field( 'materiel_rappel', true, $copro_id );
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Travaillez-vous directement avec le syndic ou avec les copropriétaires ?', 'a' => "Le plus souvent avec le syndic ou le conseil syndical, qui valide le cahier des charges et reste notre interlocuteur pour le suivi." ),
	array( 'q' => 'La sortie des conteneurs est-elle comprise ?', 'a' => "Elle est possible lorsqu'elle est prévue et chiffrée dans le devis, selon les jours de collecte de la commune. Ce n'est pas une tâche incluse par défaut." ),
	array( 'q' => 'Un cahier de liaison est-il laissé dans les parties communes ?', 'a' => "Oui. Il est placé à un endroit convenu avec le syndic et permet de suivre les passages, de noter ce qui n'a pas pu être fait et de recueillir une remarque de résident." ),
	array( 'q' => 'Comment le cahier des charges est-il validé ?', 'a' => "Il est établi avec le syndic ou le conseil syndical, qui arbitre le périmètre et la fréquence selon le budget voté. Toute modification passe par un devis actualisé soumis au même circuit de validation." ),
	array( 'q' => 'Les vitres des parties communes sont-elles comprises ?', 'a' => "Les vitrages accessibles sans équipement spécialisé sont inclus : portes d'entrée, hublots de palier, vitrage de hall de plain-pied. Les verrières et façades nécessitant une nacelle en sont exclues." ),
	array( 'q' => 'Que se passe-t-il si un résident fait une remarque à l\'intervenant ?', 'a' => "L'intervenant l'écoute, la note dans le cahier de liaison et ne s'engage sur rien : le périmètre est fixé par le syndic. Audrey relaie ensuite la remarque au gestionnaire, qui décide de la suite." ),
	array( 'q' => 'À quelle fréquence faut-il entretenir des parties communes ?', 'a' => "Un passage hebdomadaire est le rythme le plus courant pour une résidence de taille moyenne. Un immeuble de standing ou un hall très fréquenté justifient souvent deux passages ; une petite copropriété peut se satisfaire d'un passage tous les quinze jours." ),
	array( 'q' => 'Comment sont gérées les clés de l\'immeuble ?', 'a' => "Un jeu de clés ou un badge est confié par le syndic, avec la liste précise des accès concernés. Ces éléments sont consignés par écrit et ne sont transmis qu'aux intervenants concernés par la résidence." ),
), $copro_id );
tfp_seed_set_field( 'seo_title', 'Entretien de copropriétés | Top-Famille Pro', $copro_id );
tfp_seed_set_field( 'seo_description', "Entretien de parties communes : halls, cages d'escalier, ascenseurs. Travail avec syndics et gestionnaires, cahier de liaison, devis gratuit sous 24 h.", $copro_id );

echo "  Prestation copropriétés : #$copro_id\n";

/* ------------------------------------------------------------------ */
/* 4. Locations meublées & hébergements                                */
/* ------------------------------------------------------------------ */

$meubles_id = tfp_seed_upsert_post( array( 'post_type' => 'prestation', 'post_title' => 'Nettoyage de locations meublées', 'post_name' => 'meubles', 'post_status' => 'publish' ) );

tfp_seed_set_field( 'h1', "Nettoyage de locations meublées et d'hébergements", $meubles_id );
tfp_seed_set_field( 'config_1_titre', "Studio ou T2", $meubles_id );
tfp_seed_set_field( 'config_1_texte', "Une rotation se traite généralement en deux à trois heures : sanitaire et cuisine en priorité, sols, changement du linge fourni et remise en état de présentation. Le créneau est calé entre l'heure de départ et l'heure d'arrivée annoncées.", $meubles_id );
tfp_seed_set_field( 'config_2_titre', "T3 ou logement familial", $meubles_id );
tfp_seed_set_field( 'config_2_texte', "Au-delà de deux pièces, le temps augmente surtout à cause des couchages multiples et de la salle de bains. Trois à quatre heures sont courantes, et un contrôle final de présentation est systématique avant l'arrivée suivante.", $meubles_id );
tfp_seed_set_field( 'config_3_titre', "Plusieurs logements à gérer", $meubles_id );
tfp_seed_set_field( 'config_3_texte', "Pour un propriétaire ou une conciergerie gérant plusieurs biens, les rotations sont planifiées ensemble sur la journée. Les modalités de remise de clés et de signalement des dégradations sont fixées une fois pour toutes au devis.", $meubles_id );
tfp_seed_set_field( 'semaine_type', "Pour un T2 en rotation entre deux séjours, sur un créneau de 11 h à 14 h : sanitaire et cuisine traités en premier, vaisselle éventuelle, changement du linge utilisé contre le linge propre que vous fournissez, aspiration et lavage des sols, aération, puis remise en état de présentation et contrôle final. Toute dégradation constatée vous est signalée avec photo avant l'arrivée suivante. Découpage indicatif, arrêté au devis.", $meubles_id );
tfp_seed_set_field( 'tease', 'Remise en état entre deux occupants', $meubles_id );
tfp_seed_set_field( 'reponse_directe', "La remise en état de vos meublés et hébergements professionnels entre deux occupants, avec un contrôle visuel et un signalement des anomalies selon l'organisation définie avec vous. Nous ne sommes pas une conciergerie : nous n'accueillons pas les voyageurs, ne gérons pas les réservations et ne lavons pas le linge.", $meubles_id );
tfp_seed_set_field( 'pour_qui', "Propriétaires de meublés, gestionnaires courte durée, résidences et hébergements pro, conciergeries : entre deux réservations, le délai est parfois très court, et l'organisation des clés comme la réactivité de l'intervenant sont déterminantes.", $meubles_id );
tfp_seed_set_field( 'taches', implode( "\n", array(
	'Remise en état complète entre deux occupants',
	'Change du linge propre fourni par le client (sans lavage)',
	"Cuisine et extérieur de l'électroménager",
	'Salle de bain et sanitaires',
	'Sols et surfaces',
	'Literie refaite et poubelles évacuées',
	"Contrôle visuel et signalement des anomalies selon l'organisation définie avec le client",
) ), $meubles_id );
tfp_seed_set_field( 'problemes', implode( "\n", array(
	"Entre deux réservations, le délai est parfois très court : l'organisation des clés et la réactivité de l'intervenant sont déterminantes.",
	"Une anomalie non repérée — casse, équipement en panne, consommable épuisé — se retourne contre vous à l'arrivée du voyageur suivant : c'est pourquoi les modalités de contrôle et de signalement sont définies à l'avance avec vous.",
) ), $meubles_id );
tfp_seed_set_field( 'organisation', "Les produits d'entretien et le linge propre sont fournis par vos soins ; nous changeons le linge utilisé contre le linge propre fourni, sans en assurer le lavage. L'accès se fait le plus souvent via une boîte à clés sécurisée, une conciergerie ou une remise en main propre, sur un créneau calé entre le départ et l'arrivée. Nous sélectionnons un intervenant réactif et rigoureux, et privilégions autant que possible la continuité d'une rotation à l'autre. Les modalités de suivi (canal, délai) sont fixées au devis ; Audrey reste votre interlocutrice pour organiser les plannings de rotation. En cas d'absence de l'intervenant habituel entre deux réservations, une solution est recherchée activement et vous êtes prévenu sans attendre, sans garantie de remplacement dans tous les cas.", $meubles_id );
tfp_seed_set_field( 'exclusions', "Hors prestation : lavage du linge (nous changeons le linge propre fourni par le client, nous ne le lavons pas), petites réparations, accueil et remise de clés aux voyageurs, gestion des réservations, réapprovisionnement acheté par nos soins.", $meubles_id );
tfp_seed_set_field( 'materiel_rappel', true, $meubles_id );
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Comment récupérez-vous les clés entre deux passages ?', 'a' => "Boîte à clés sécurisée, conciergerie ou remise en main propre : la solution est définie avec vous selon votre organisation." ),
	array( 'q' => 'Lavez-vous le linge de lit et les serviettes ?', 'a' => "Nous changeons le linge fourni propre par le client ; le lavage du linge sale n'est pas inclus dans la prestation courante." ),
	array( 'q' => "Que se passe-t-il si un dysfonctionnement est constaté ?", 'a' => "Il est signalé selon les modalités convenues avec vous : cahier de liaison, message, ou appel direct pour ce qui empêcherait un séjour. Le canal et le délai sont fixés au devis." ),
	array( 'q' => 'Faites-vous un contrôle avant chaque arrivée ?', 'a' => "Un contrôle visuel est réalisé en fin d'intervention. Un passage de vérification supplémentaire juste avant l'arrivée est une prestation distincte, réalisée seulement si elle est prévue et chiffrée au devis." ),
	array( 'q' => 'Recevons-nous un compte-rendu après chaque intervention ?', 'a' => "Cela dépend de l'organisation définie avec vous. Un signalement est fait dès qu'une anomalie est constatée ; un compte-rendu écrit systématique est possible lorsqu'il est prévu au devis." ),
	array( 'q' => 'Quel délai vous faut-il entre un départ et une arrivée ?', 'a' => "Pour un studio ou un T2, deux à trois heures suffisent généralement. Pour un logement familial, comptez trois à cinq heures. Un créneau plus court réduit le périmètre : nous préférons vous le dire avant." ),
	array( 'q' => 'En quoi vous différenciez-vous d\'une conciergerie ?', 'a' => "Une conciergerie gère la relation voyageur (annonces, réservations, accueil). Nous faisons uniquement la remise en état du logement, souvent en complément d'une conciergerie." ),
	array( 'q' => 'Que se passe-t-il si le logement est laissé dans un état anormal ?', 'a' => "L'intervenant vous alerte sans attendre et nous convenons de la suite : temps supplémentaire chiffré ou intervention ponctuelle de remise en état. Le temps prévu au devis correspond à un état d'usage normal." ),
), $meubles_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage de locations meublées | Top-Famille Pro', $meubles_id );
tfp_seed_set_field( 'seo_description', "Remise en état de meublés et hébergements entre deux occupants : ménage complet, change du linge fourni. Réactif, devis gratuit sous 24 h.", $meubles_id );

echo "  Prestation locations meublées : #$meubles_id\n";

/* ------------------------------------------------------------------ */
/* 5. Ponctuel & remise en état                                        */
/* ------------------------------------------------------------------ */

$ponctuel_id = tfp_seed_upsert_post( array( 'post_type' => 'prestation', 'post_title' => 'Nettoyage ponctuel', 'post_name' => 'ponctuel', 'post_status' => 'publish' ) );

tfp_seed_set_field( 'h1', 'Nettoyage ponctuel et remise en état', $ponctuel_id );
tfp_seed_set_field( 'config_1_titre', "Remise en état après travaux", $ponctuel_id );
tfp_seed_set_field( 'config_1_texte', "Le volume dépend surtout des résidus constatés : poussière de plâtre, traces de peinture, adhésifs. Une évaluation sur place ou sur photos précède le chiffrage, car deux chantiers de même surface peuvent demander du simple au double.", $ponctuel_id );
tfp_seed_set_field( 'config_2_titre', "Grand nettoyage saisonnier", $ponctuel_id );
tfp_seed_set_field( 'config_2_texte', "Un nettoyage de fond ponctuel porte sur ce que l'entretien courant ne traite pas : vitrages intérieurs, plinthes, dessus d'armoires, dégivrage. Il se planifie à l'avance sur une ou deux journées complètes.", $ponctuel_id );
tfp_seed_set_field( 'config_3_titre', "Fin de bail ou changement d'occupant", $ponctuel_id );
tfp_seed_set_field( 'config_3_texte', "Une remise en état avant restitution suit la logique de l'état des lieux : chaque pièce est reprise intégralement. Le créneau est calé juste avant la visite de sortie, et un contrôle final est fait avant la remise des clés.", $ponctuel_id );
tfp_seed_set_field( 'semaine_type', "Pour une remise en état après travaux sur un plateau de 120 m², sur une journée : dépoussiérage haut en premier (plafonds techniques, luminaires, dessus de cloisons), puis menuiseries, plinthes et vitrages intérieurs, retrait des adhésifs et traces de peinture, et enfin lavage des sols en dernier une fois toute la poussière descendue. Un contrôle final est réalisé avec vous avant la remise des clés. Volume indicatif : l'estimation définitive dépend de l'état constaté sur place.", $ponctuel_id );
tfp_seed_set_field( 'tease', 'Fin de travaux, grand nettoyage, fin de bail', $ponctuel_id );
tfp_seed_set_field( 'reponse_directe', "Une intervention ponctuelle pour une remise en état après travaux, un grand nettoyage saisonnier ou une fin de bail, au tarif ponctuel de la grille en vigueur. Nous établissons un devis précis selon le volume et l'état constaté.", $ponctuel_id );
tfp_seed_set_field( 'pour_qui', "Fins de travaux et de chantier, grands nettoyages saisonniers, remises en état avant emménagement, fins de bail commercial : ces situations demandent une intervention unique et approfondie.", $ponctuel_id );
tfp_seed_set_field( 'taches', implode( "\n", array(
	'Dépose des poussières de chantier',
	'Traces de peinture et résidus',
	'Nettoyage approfondi des sols',
	'Vitres, encadrements et rebords',
	'Sanitaires et cuisines',
	'Finitions et contrôle',
) ), $ponctuel_id );
tfp_seed_set_field( 'problemes', implode( "\n", array(
	"Une fin de chantier laisse une poussière fine difficile à éliminer sans méthode adaptée, sur tous les types de surfaces.",
	"Une fin de bail commercial impose souvent un délai serré avant l'état des lieux ou l'arrivée du nouvel occupant.",
) ), $ponctuel_id );
tfp_seed_set_field( 'organisation', "Les produits utilisés dépendent de la nature des résidus constatés et sont adaptés au type de revêtement ; selon la situation, ils peuvent être fournis par le client ou proposés par l'intervenant après échange préalable. L'accès est généralement organisé directement avec le donneur d'ordre le jour convenu, souvent juste après le départ des corps de métier. Nous mobilisons un intervenant habitué aux chantiers de remise en état, capable d'évaluer rapidement le volume d'heures nécessaire selon l'état constaté sur place. Un contrôle final est réalisé avant la remise des clés. S'agissant d'une intervention unique, tout imprévu vous est signalé immédiatement et le créneau reprogrammé avec vous.", $ponctuel_id );
tfp_seed_set_field( 'exclusions', "Hors prestation : évacuation de gravats et déchets de chantier, dépose de matériaux, traitement de surfaces dangereuses (amiante, plomb, moisissures étendues), manipulation de produits classés dangereux, intervention en hauteur avec équipement spécialisé. Ces situations relèvent d'entreprises spécialisées.", $ponctuel_id );
tfp_seed_set_field( 'materiel_rappel', true, $ponctuel_id );
tfp_seed_faq( 'faq', array(
	array( 'q' => 'Intervenez-vous juste après la fin des travaux ?', 'a' => "Oui, une fois les corps de métier partis. Nous recommandons un délai court pour éviter que la poussière ne se redépose sur les surfaces déjà traitées." ),
	array( 'q' => 'Le nettoyage après travaux est-il plus cher qu\'un entretien courant ?', 'a' => "Le taux horaire est le même (27,00 € HT/h, tarif unique en régulier comme en ponctuel) — c'est en général le volume d'heures qui est plus important, selon l'ampleur du chantier, pas le tarif horaire. Voir la page Tarifs pour le détail complet." ),
	array( 'q' => "Prenez-vous en charge l'évacuation des déchets de chantier ?", 'a' => "Non. L'évacuation de gravats et de déchets volumineux ne fait pas partie de la prestation. Nous traitons la poussière et les résidus de surface, une fois les déchets évacués par le chantier." ),
	array( 'q' => "Comment estimez-vous le nombre d'heures nécessaires ?", 'a' => "À partir de la surface, du nombre de pièces, de la nature des résidus et de l'état constaté. Nous demandons des photos, ou une visite lorsque c'est possible. L'estimation est donnée sous forme de fourchette d'heures." ),
	array( 'q' => 'Intervenez-vous pour une fin de bail ou un état des lieux ?', 'a' => "Oui, c'est un cas fréquent. Nous ne nous engageons pas sur le résultat d'un état des lieux, qui dépend du bailleur : nous nous engageons sur un périmètre de nettoyage défini et sur le temps consacré." ),
	array( 'q' => 'Que faites-vous face à des matériaux fragiles ?', 'a' => "Parquet huilé, béton ciré, pierre naturelle, inox brossé ou verre laqué ne supportent pas les mêmes produits. Nous les identifions avant l'intervention et adaptons le produit et la méthode." ),
	array( 'q' => 'Un second passage est-il possible ?', 'a' => "Oui, et c'est parfois recommandé après travaux : la poussière fine en suspension se redépose dans les 24 à 48 heures suivant le premier nettoyage. Un second passage peut être prévu au devis ou décidé après le premier." ),
	array( 'q' => 'Traitez-vous les produits ou substances dangereuses ?', 'a' => "Non. Amiante, plomb, moisissures étendues, résidus chimiques et locaux insalubres sont exclus de notre périmètre : ils relèvent d'entreprises spécialisées disposant des habilitations requises." ),
), $ponctuel_id );
tfp_seed_set_field( 'seo_title', 'Nettoyage ponctuel et remise en état | Top-Famille Pro', $ponctuel_id );
tfp_seed_set_field( 'seo_description', "Remise en état après travaux, grand nettoyage ou fin de bail : devis précis selon le volume constaté, intervention rapide.", $ponctuel_id );

echo "  Prestation ponctuel : #$ponctuel_id\n";

echo "=== Lot 1 terminé ===\n";
