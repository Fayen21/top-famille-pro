<?php
/**
 * Seed des 5 pages de référence de la phase 2 (une par famille de gabarit).
 *
 * Contenu repris du prototype (reference/Top-Famille-Pro-HANDOFF-READY.html), corrigé selon
 * CLAUDE.md §9 : tarif unique fictif « 27 € HT/h » remplacé par la vraie grille à trois montants
 * (PROJECT_INPUTS.md §5), tous les avis de démonstration retirés (docs/DONNEES-FICTIVES.md),
 * accords grammaticaux corrigés. Le contenu vit ici en PHP versionné plutôt que directement en
 * base : c'est ce qui permet de le relire et de le revoir dans une PR, conformément à
 * CLAUDE.md §3 (le dépôt ne versionne que le thème, jamais la base — ce script est le code
 * source du contenu, la base n'en est que le résultat).
 *
 * Usage : wp eval-file bin/seed-phase2-content.php
 * Idempotent : peut être relancé sans dupliquer (recherche par post_name avant création).
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase2-content.php\n" );
}

/**
 * Crée ou met à jour un post par son slug (idempotent).
 */
function tfp_seed_upsert_post( array $args ) {
	$existing = get_posts(
		array(
			'post_type'   => $args['post_type'],
			'name'        => $args['post_name'],
			'numberposts' => 1,
			'post_status' => 'any',
		)
	);

	if ( ! empty( $existing ) ) {
		$args['ID'] = $existing[0]->ID;
		wp_update_post( $args );
		return $args['ID'];
	}

	return wp_insert_post( $args );
}

function tfp_seed_set_field( $selector, $value, $post_id ) {
	if ( function_exists( 'update_field' ) ) {
		update_field( $selector, $value, $post_id );
	} else {
		update_post_meta( $post_id, $selector, $value );
	}
}

function tfp_seed_faq( $prefix, array $faqs, $post_id ) {
	foreach ( $faqs as $i => $item ) {
		tfp_seed_set_field( $prefix . '_' . ( $i + 1 ), array( 'question' => $item['q'], 'reponse' => $item['a'] ), $post_id );
	}
}

echo "=== Seed phase 2 : contenu de référence ===\n";

/* ------------------------------------------------------------------ */
/* 1. Prestation — Nettoyage de bureaux                                */
/* ------------------------------------------------------------------ */

$bureaux_id = tfp_seed_upsert_post(
	array(
		'post_type'   => 'prestation',
		'post_title'  => 'Nettoyage de bureaux',
		'post_name'   => 'bureaux',
		'post_status' => 'publish',
	)
);

tfp_seed_set_field( 'h1', 'Nettoyage de bureaux en Bourgogne-Franche-Comté', $bureaux_id );
tfp_seed_set_field( 'tease', 'Open-spaces, salles de réunion, accueil', $bureaux_id );
tfp_seed_set_field(
	'reponse_directe',
	"Un entretien régulier et discret de vos espaces de travail, confié autant que possible à un intervenant habituel, pour des bureaux toujours prêts à recevoir vos équipes et vos visiteurs.",
	$bureaux_id
);
tfp_seed_set_field(
	'pour_qui',
	"PME et sièges sociaux, espaces de coworking, agences et plateaux tertiaires : nous intervenons tôt le matin, en fin de journée ou pendant les heures creuses, selon votre organisation, afin de ne jamais perturber votre activité.",
	$bureaux_id
);
tfp_seed_set_field(
	'taches',
	implode(
		"\n",
		array(
			'Dépoussiérage du mobilier de bureau',
			'Écrans et claviers : dépoussiérage prudent selon les consignes et le matériel autorisé',
			'Vidage des corbeilles et tri des points de collecte',
			'Aspiration et lavage des sols',
			'Entretien des points de contact courants',
			'Entretien et réapprovisionnement des sanitaires',
			'Nettoyage de la cuisine ou salle de pause',
			'Salles de réunion remises en ordre',
			'Accueil et vitres intérieures',
		)
	),
	$bureaux_id
);
tfp_seed_set_field(
	'problemes',
	implode(
		"\n",
		array(
			"Une salle de réunion utilisée toute la journée doit être remise en état avant chaque nouvelle réunion, sans que cela repose sur vos équipes.",
			"Les postes de travail partagés (flex-office, open-space) demandent un passage plus régulier sur les surfaces de contact, dès lors qu'ils sont libérés de tout effet personnel.",
		)
	),
	$bureaux_id
);
tfp_seed_set_field(
	'organisation',
	"Les produits d'entretien courants et le matériel sont généralement fournis par vos soins, ce qui garantit l'usage de références déjà validées pour vos revêtements et votre mobilier. L'accès (jeu de clés, badge, code d'alarme) est organisé selon votre configuration et consigné par écrit avant le premier passage, avec un protocole clair en cas de déclenchement accidentel. Nous recherchons un intervenant habituel qui connaît vos locaux, vos horaires et vos consignes de confidentialité — un critère important dans des open-spaces où circulent des documents et des écrans allumés. Un cahier de liaison reste sur place pour tracer chaque passage ; en cas d'absence imprévue, nous recherchons activement une solution de remplacement et vous informons de l'organisation retenue.",
	$bureaux_id
);
tfp_seed_set_field(
	'exclusions',
	"Hors prestation courante : maintenance informatique, déplacement de mobilier lourd, shampouinage de moquette en profondeur et nettoyage de vitres en hauteur nécessitant un équipement spécialisé — ces interventions font l'objet d'un devis distinct.",
	$bureaux_id
);
tfp_seed_set_field( 'materiel_rappel', true, $bureaux_id );
tfp_seed_faq(
	'faq',
	array(
		array( 'q' => 'Intervenez-vous pendant que nos équipes sont présentes ?', 'a' => "Nous privilégions les horaires avant l'arrivée ou après le départ de vos salariés, pour ne pas perturber votre activité. Une intervention en journée reste possible sur demande." ),
		array( 'q' => 'Le nettoyage des écrans et claviers est-il inclus ?', 'a' => "Il s'agit d'un dépoussiérage prudent selon les consignes et le matériel autorisé. Nous n'appliquons aucun produit sur les écrans, claviers ou unités centrales sans instruction écrite de votre part." ),
		array( 'q' => 'Combien d\'heures faut-il prévoir pour nos bureaux ?', 'a' => "Le volume dépend de l'effectif réellement présent, du nombre de sanitaires et de la fréquence retenue, davantage que de la seule surface. L'estimation précise est établie après échange sur vos locaux, jamais par un simulateur automatique." ),
		array( 'q' => 'Le même intervenant vient-il à chaque passage ?', 'a' => "C'est l'organisation que nous recherchons : un intervenant habituel qui connaît vos locaux, vos horaires et vos consignes de confidentialité. Cette continuité est privilégiée autant que possible, sans constituer une garantie absolue en cas d'absence ou de changement de disponibilité." ),
		array( 'q' => 'Comment sont gérées les clés et l\'alarme ?', 'a' => "Les modalités d'accès sont définies avec vous et consignées par écrit avant le premier passage, avec une consigne claire en cas de déclenchement accidentel. Elles ne sont transmises qu'aux intervenants concernés par votre site." ),
		array( 'q' => 'Pouvons-nous modifier la fréquence en cours d\'année ?', 'a' => "Oui. Un déménagement, une embauche ou une baisse d'activité justifient souvent un ajustement, par un échange avec Audrey puis un devis actualisé si le volume d'heures change." ),
		array( 'q' => 'Que se passe-t-il si une tâche prévue n\'a pas été réalisée ?', 'a' => "Elle est signalée dans le cahier de liaison avec sa raison et reportée au passage suivant. Si le cas se répète, c'est généralement le signe que le volume d'heures doit être revu." ),
	),
	$bureaux_id
);
tfp_seed_set_field( 'seo_title', "Nettoyage de bureaux en Bourgogne-Franche-Comté | Top-Famille Pro", $bureaux_id );
tfp_seed_set_field( 'seo_description', "Nettoyage de bureaux régulier ou ponctuel : sols, sanitaires, cuisine, salles de réunion. Intervenant habituel recherché, devis gratuit sous 24 h.", $bureaux_id );

echo "  Prestation bureaux : #$bureaux_id\n";

/* ------------------------------------------------------------------ */
/* 2. Zone — département Côte-d'Or                                     */
/* ------------------------------------------------------------------ */

$cote_dor_term = term_exists( 'cote-dor', 'departement' );
if ( ! $cote_dor_term ) {
	$cote_dor_term = wp_insert_term( "Côte-d'Or", 'departement', array( 'slug' => 'cote-dor' ) );
}
$cote_dor_term_id = is_array( $cote_dor_term ) ? $cote_dor_term['term_id'] : $cote_dor_term;

$cote_dor_id = tfp_seed_upsert_post(
	array(
		'post_type'   => 'zone',
		'post_title'  => "Côte-d'Or",
		'post_name'   => 'cote-dor',
		'post_status' => 'publish',
	)
);
wp_set_object_terms( $cote_dor_id, array( (int) $cote_dor_term_id ), 'departement' );

tfp_seed_set_field( 'niveau', 'departement', $cote_dor_id );
tfp_seed_set_field( 'h1', "Entreprise de nettoyage en Côte-d'Or", $cote_dor_id );
tfp_seed_set_field( 'cta_label', "Demander un devis en Côte-d'Or", $cote_dor_id );
tfp_seed_set_field(
	'reponse_directe',
	"Top-Famille Pro entretient bureaux, commerces, cabinets et parties communes en Côte-d'Or, depuis son implantation de Saint-Apollinaire.",
	$cote_dor_id
);
tfp_seed_set_field(
	'secteur_economique',
	"La Côte-d'Or concentre autour de Dijon un tissu dense de sièges sociaux, d'administrations, de professions libérales et de commerces, complété par les zones d'activité de l'agglomération.",
	$cote_dor_id
);
tfp_seed_set_field(
	'locaux_types',
	implode( "\n", array( 'Sièges sociaux et bureaux', 'Commerces de centre-ville et zones commerciales', 'Cabinets médicaux et juridiques', 'Copropriétés de la métropole dijonnaise' ) ),
	$cote_dor_id
);
tfp_seed_set_field(
	'fonctionnement',
	"Tout commence par une visite sur place : c'est l'avantage de la proximité avec notre implantation de Saint-Apollinaire. Nous mesurons, regardons les revêtements, notons les contraintes d'accès et d'horaires, puis rédigeons un cahier des charges pièce par pièce. Le devis suit sous 24 heures. Nous cherchons ensuite à confier votre site au même intervenant chaque semaine ; en cas d'absence ou de départ, nous recherchons un remplacement et transmettons les consignes écrites, sans promettre une continuité automatique que personne ne peut garantir.",
	$cote_dor_id
);
/*
 * zones_desservies volontairement vide au niveau département : les 8 « communes secondaires »
 * du prototype (Beaune, Chevigny-Saint-Sauveur, Ahuy, Daix, Plombières-lès-Dijon,
 * Sennecey-lès-Dijon, Nuits-Saint-Georges, Ruffey-lès-Echirey) n'existent sur aucune source réelle
 * (CLAUDE.md §5.4, PROJECT_INPUTS.md §6) : seule Dijon est une ville validée en Côte-d'Or. Les
 * nommer ici, même en texte simple non lié, affirmerait une couverture non confirmée sur une page
 * indexée. La ville validée (Dijon) apparaît déjà dynamiquement via la requête des zones filles.
 */
tfp_seed_set_field( 'exclusions_rappel', true, $cote_dor_id );
tfp_seed_set_field( 'materiel_rappel', true, $cote_dor_id );
tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $cote_dor_id );
tfp_seed_faq(
	'faq',
	array(
		array( 'q' => "Êtes-vous vraiment installés en Côte-d'Or ?", 'a' => "Oui, à Saint-Apollinaire (21850), commune limitrophe de Dijon. C'est notre unique implantation : nous n'avons pas d'agence à Dijon même, ni ailleurs dans la région." ),
		array( 'q' => "Intervenez-vous dans toute la Côte-d'Or ?", 'a' => "L'agglomération dijonnaise est notre secteur prioritaire. Pour les secteurs plus éloignés, l'intervention dépend de la fréquence envisagée : demandez-nous de vérifier votre commune." ),
		array( 'q' => "Des indemnités kilométriques peuvent-elles s'ajouter en Côte-d'Or ?", 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse exacte, du planning et des conditions d'intervention. Elles sont calculées et précisées dans le devis avant toute validation." ),
		array( 'q' => 'Pouvez-vous venir visiter nos locaux avant le devis ?', 'a' => "Oui, et c'est ce que nous recommandons sur ce département : la visite permet d'estimer un volume d'heures réaliste plutôt qu'une fourchette approximative." ),
		array( 'q' => 'Travaillez-vous avec les copropriétés de la métropole ?', 'a' => "Oui : halls, cages d'escalier, ascenseurs, locaux à conteneurs, avec sortie et rentrée des bacs possibles lorsqu'elles sont prévues dans le cahier des charges et chiffrées dans le devis." ),
		array( 'q' => 'Proposez-vous des passages avant 8 h ?', 'a' => "Oui, c'est un créneau pouvant être envisagé pour les bureaux comme pour les commerces de l'agglomération. Les interventions de nuit, le dimanche et les jours fériés sont possibles avec une majoration de 10 %." ),
	),
	$cote_dor_id
);
tfp_seed_set_field( 'seo_title', "Nettoyage professionnel en Côte-d'Or | Top-Famille Pro", $cote_dor_id );
tfp_seed_set_field( 'seo_description', "Top-Famille Pro entretient bureaux, commerces, cabinets et parties communes en Côte-d'Or, depuis Saint-Apollinaire.", $cote_dor_id );

echo "  Zone Côte-d'Or (département) : #$cote_dor_id\n";

/* ------------------------------------------------------------------ */
/* 3. Zone — ville de Dijon                                            */
/* ------------------------------------------------------------------ */

$dijon_id = tfp_seed_upsert_post(
	array(
		'post_type'   => 'zone',
		'post_title'  => 'Dijon',
		'post_name'   => 'dijon',
		'post_status' => 'publish',
	)
);
wp_set_object_terms( $dijon_id, array( (int) $cote_dor_term_id ), 'departement' );

tfp_seed_set_field( 'niveau', 'ville', $dijon_id );
tfp_seed_set_field( 'code_postal', '21000', $dijon_id );
tfp_seed_set_field( 'h1', 'Entreprise de nettoyage à Dijon', $dijon_id );
tfp_seed_set_field( 'cta_label', 'Demander un devis à Dijon', $dijon_id );
tfp_seed_set_field(
	'reponse_directe',
	"Top-Famille Pro est une entreprise de nettoyage implantée à Saint-Apollinaire, commune limitrophe de Dijon. Nous entretenons bureaux, surfaces de vente, cabinets, parties communes d'immeubles et locations meublées à Dijon, en contrat régulier ou en intervention ponctuelle. Le devis est gratuit et transmis sous 24 heures ; votre interlocutrice est Audrey, au 06 36 17 63 39.",
	$dijon_id
);
tfp_seed_set_field(
	'secteur_economique',
	"Capitale régionale, Dijon concentre sièges sociaux, administrations, professions libérales et un centre-ville commerçant dense. Les pôles tertiaires et les zones commerciales de l'agglomération génèrent des besoins d'entretien réguliers.",
	$dijon_id
);
tfp_seed_set_field(
	'locaux_types',
	implode( "\n", array( 'PME et sièges d\'entreprise tertiaires', 'Commerces indépendants du centre-ville et des zones commerciales', 'Cabinets médicaux, dentaires, comptables et juridiques', 'Syndics et conseils syndicaux de la métropole', 'Propriétaires bailleurs et gestionnaires de meublés' ) ),
	$dijon_id
);
tfp_seed_set_field(
	'fonctionnement',
	"Notre adresse est à Saint-Apollinaire, en périphérie est de Dijon — nous n'avons pas de bureau au centre-ville, et nous ne le prétendons pas. Cette proximité fait de Dijon l'un de nos secteurs prioritaires : visite, ajustement de planning ou passage supplémentaire y sont étudiés selon les disponibilités. Les intervenants sont recrutés par Audrey, en entretien individuel, avec vérification des références. Nous cherchons à confier votre site au même intervenant d'une semaine sur l'autre ; en cas d'absence ou de départ, nous recherchons une solution de remplacement, transmettons les consignes écrites et vous en informons.",
	$dijon_id
);
/*
 * zones_desservies volontairement vide : « Chevigny-Saint-Sauveur, Ahuy, Daix,
 * Plombières-lès-Dijon, Sennecey-lès-Dijon, Ruffey-lès-Echirey » sont les communes secondaires
 * fictives du prototype (CLAUDE.md §5.4) — aucune n'est validée par Audrey. Les nommer sur cette
 * page indexée affirmerait une couverture non confirmée.
 */
tfp_seed_set_field( 'exclusions_rappel', true, $dijon_id );
tfp_seed_set_field( 'materiel_rappel', true, $dijon_id );
tfp_seed_set_field( 'prestations_liees', array( $bureaux_id ), $dijon_id );
tfp_seed_faq(
	'faq',
	array(
		array( 'q' => 'Où êtes-vous exactement installés ?', 'a' => "À Saint-Apollinaire (21850), commune limitrophe de Dijon. Nous n'avons pas de bureau dans le centre-ville dijonnais : c'est notre unique implantation pour toute la région." ),
		array( 'q' => 'Intervenez-vous dans le centre historique et les rues piétonnes ?', 'a' => "Oui, y compris pour les commerces et les cabinets installés en zone piétonne. Les contraintes d'accès véhicule sont intégrées au planning dès la mise en place." ),
		array( 'q' => 'Pouvez-vous passer avant 8 h ?', 'a' => "Oui, c'est un créneau pouvant être envisagé à Dijon, pour les bureaux comme pour les commerces. Le tôt matin et la fin de journée sont les deux plages généralement retenues." ),
		array( 'q' => 'Y a-t-il des frais de déplacement sur Dijon ?', 'a' => "Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention. Elles sont précisées dans le devis." ),
		array( 'q' => 'Aurai-je toujours le même intervenant ?', 'a' => "C'est ce que nous recherchons pour chaque site dijonnais. Ce n'est pas une garantie : en cas d'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous prévenons." ),
		array( 'q' => 'Entretenez-vous les copropriétés de la métropole ?', 'a' => "Oui : halls, cages d'escalier, ascenseurs, paliers, locaux à conteneurs, avec sortie des bacs possible lorsqu'elle est prévue dans le cahier des charges et chiffrée dans le devis, selon le calendrier de collecte applicable à l'adresse." ),
		array( 'q' => 'Quel est le délai pour démarrer ?', 'a' => "Le délai de démarrage dépend des disponibilités, de l'adresse et du volume horaire. Il est confirmé lors de l'établissement du devis." ),
	),
	$dijon_id
);
tfp_seed_set_field( 'seo_title', "Entreprise de nettoyage à Dijon (21000) | Top-Famille Pro", $dijon_id );
tfp_seed_set_field( 'seo_description', "Entreprise de nettoyage à Dijon : entretien régulier ou ponctuel de bureaux, commerces, cabinets et copropriétés, par des intervenants sélectionnés.", $dijon_id );

echo "  Zone Dijon (ville) : #$dijon_id\n";

/* ------------------------------------------------------------------ */
/* 4. Article — Fréquence de nettoyage des bureaux                     */
/* ------------------------------------------------------------------ */

if ( ! term_exists( 'conseils', 'category' ) ) {
	wp_insert_term( 'Conseils', 'category', array( 'slug' => 'conseils' ) );
}
$conseils_cat = get_category_by_slug( 'conseils' );

$article_content = "<p>Quatre critères permettent de fixer une fréquence réaliste : le nombre de personnes présentes chaque jour, la surface à couvrir, le type d'activité et la présence ou non de visiteurs externes. Un plateau de 30 postes utilisé toute la semaine ne se traite pas comme un cabinet de trois personnes ouvert trois jours.</p>

<h2>Quotidien, plusieurs fois par semaine ou hebdomadaire</h2>
<p>En pratique, voici les repères que nous utilisons pour orienter une première estimation, avant d'affiner ensemble selon votre cahier des charges :</p>
<ul>
<li>Plus de 15 postes ou forte fréquentation : passage quotidien recommandé</li>
<li>5 à 15 postes, activité courante : 2 à 3 passages par semaine</li>
<li>Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadaire souvent suffisant</li>
<li>Salle de réunion utilisée en continu : remise en état après chaque usage, en complément de la fréquence de base</li>
</ul>

<h2>Le cas des espaces recevant du public</h2>
<p>Un commerce, une salle d'attente ou un accueil très fréquenté demande une vigilance accrue sur les sanitaires et les points de contact, quel que soit l'effectif interne. Ces espaces sont souvent traités quotidiennement, y compris lorsque le reste des locaux passe par une fréquence plus légère.</p>

<h2>Une fréquence unique, ou différenciée par espace ?</h2>
<p>La fréquence n'a pas à être identique partout. Il est courant de prévoir un entretien quotidien des sanitaires et de la cuisine, un passage hebdomadaire pour les bureaux individuels peu utilisés, et un passage à la demande pour les salles de réunion. C'est l'objet du cahier des charges que nous établissons avec vous.</p>

<h2>Ajuster la fréquence dans le temps</h2>
<p>Un effectif qui grandit, un déménagement, une saisonnalité d'activité : la fréquence retenue au départ n'est pas figée. Nous recommandons de la revoir avec votre interlocutrice dès que votre organisation évolue sensiblement, pour garder un budget ajusté à la réalité.</p>

<h2>Erreurs à éviter</h2>
<ul>
<li>Sous-estimer la fréquence nécessaire pour des sanitaires très fréquentés, au motif que le reste des bureaux est calme.</li>
<li>Demander un passage quotidien par habitude, sans effectif réel qui le justifie, ce qui alourdit inutilement le budget.</li>
<li>Ne jamais réévaluer la fréquence après un changement d'effectif ou d'organisation des locaux.</li>
</ul>";

$article_id = tfp_seed_upsert_post(
	array(
		'post_type'    => 'post',
		'post_title'   => 'À quelle fréquence faire nettoyer ses bureaux ?',
		'post_name'    => 'frequence-bureaux',
		'post_status'  => 'publish',
		'post_content' => $article_content,
		'post_excerpt' => 'Quotidien, plusieurs fois par semaine ou hebdomadaire : comment choisir selon vos effectifs et votre activité.',
		'post_category' => $conseils_cat ? array( $conseils_cat->term_id ) : array(),
	)
);

update_post_meta(
	$article_id,
	'_tfp_direct_answer',
	"La fréquence adaptée dépend surtout de l'effectif présent et du type d'activité : un passage quotidien convient aux bureaux de plus de 15 postes ou aux espaces très fréquentés, 2 à 3 passages par semaine suffisent pour une équipe de 5 à 15 personnes, et un passage hebdomadaire couvre souvent les besoins d'un petit cabinet de moins de 5 personnes."
);

$article_faqs = array(
	array( 'q' => 'Peut-on changer de fréquence en cours de contrat ?', 'a' => 'Oui, la fréquence peut être ajustée à tout moment avec votre interlocutrice, à la hausse comme à la baisse, selon l\'évolution de vos besoins.' ),
	array( 'q' => 'Une fréquence hebdomadaire suffit-elle pour un cabinet médical ?', 'a' => "Cela dépend du flux de patients. Pour les salles d'attente et sanitaires très fréquentés, un passage plus rapproché est généralement recommandé ; le bureau de consultation peut suivre une fréquence plus légère." ),
	array( 'q' => 'Le tarif horaire change-t-il selon la fréquence choisie ?', 'a' => "Non, le tarif horaire reste identique quelle que soit la fréquence retenue (24,30 € à 30,00 € HT/h selon le type de local et le régime, voir la page Tarifs) ; seul le volume d'heures mensuel varie." ),
);
foreach ( $article_faqs as $i => $item ) {
	update_post_meta( $article_id, '_tfp_faq_' . ( $i + 1 ) . '_q', $item['q'] );
	update_post_meta( $article_id, '_tfp_faq_' . ( $i + 1 ) . '_a', $item['a'] );
}

echo "  Article frequence-bureaux : #$article_id\n";

/* ------------------------------------------------------------------ */
/* 5. Page statique — Nettoyage professionnel (pilier)                 */
/* ------------------------------------------------------------------ */

$pillar_id = tfp_seed_upsert_post(
	array(
		'post_type'   => 'page',
		'post_title'  => 'Nettoyage professionnel',
		'post_name'   => 'nettoyage-professionnel',
		'post_status' => 'publish',
		// Contenu réel géré par page-nettoyage-professionnel.php (gabarit dédié, CLAUDE.md §3) :
		// la Page WordPress ne sert qu'à réserver le slug/l'URL et le statut de publication.
	)
);

echo "  Page nettoyage-professionnel : #$pillar_id\n";

echo "\n=== Seed terminé ===\n";
