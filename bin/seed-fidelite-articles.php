<?php
/**
 * Contenu intégral des 3 articles « Conseils » et de leur index, relevé dans la maquette.
 *
 * Fichier **généré** par `node tools/generate-articles.mjs` — ne pas éditer à la main.
 *
 * Le corps de chaque article est du HTML dans `post_content` : il reste éditable dans
 * l'éditeur WordPress, ce qui est l'intérêt du type `post` natif. La réponse directe, la FAQ,
 * la phrase de maillage et le bloc de conversion restent des champs structurés.
 *
 * Usage : wp eval-file bin/seed-fidelite-articles.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-fidelite-articles.php\n" );
}

global $wpdb;
echo "=== Fidélité Claude Design : 3 articles Conseils ===\n";

/* ---------------- frequence-bureaux ---------------- */
$posts = get_posts( array( 'post_type' => 'post', 'name' => 'frequence-bureaux', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! article frequence-bureaux absent — lancer d'abord les seeds de phase 3\n";
} else {
	$id = $posts[0]->ID;
	wp_update_post( array(
		'ID'            => $id,
		'post_title'    => 'À quelle fréquence faire nettoyer ses bureaux ?',
		'post_content'  => '<h2>Ce qui détermine la bonne fréquence</h2>
<p>Quatre critères permettent de fixer une fréquence réaliste : le nombre de personnes présentes chaque jour, la surface à couvrir, le type d\'activité (bureaux, accueil de public, professions médicales) et la présence ou non de visiteurs externes. Un plateau de 30 postes utilisé toute la semaine ne se traite pas comme un cabinet de trois personnes ouvert trois jours.</p>
<h2>Quotidien, plusieurs fois par semaine ou hebdomadaire</h2>
<p>En pratique, voici les repères que nous utilisons pour orienter une première estimation, avant d\'affiner ensemble selon votre cahier des charges :</p>
<ul>
<li>Plus de 15 postes ou forte fréquentation : passage quotidien recommandé</li>
<li>5 à 15 postes, activité courante : 2 à 3 passages par semaine</li>
<li>Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadaire souvent suffisant</li>
<li>Salle de réunion utilisée en continu : remise en état après chaque usage, en complément de la fréquence de base</li>
</ul>
<h2>Le cas des espaces recevant du public</h2>
<p>Un commerce, une salle d\'attente ou un accueil très fréquenté demande une vigilance accrue sur les sanitaires et les points de contact, quel que soit l\'effectif interne. Ces espaces sont souvent traités quotidiennement, y compris lorsque le reste des locaux passe par une fréquence plus légère.</p>
<h2>Une fréquence unique, ou différenciée par espace ?</h2>
<p>La fréquence n\'a pas à être identique partout. Il est courant de prévoir un entretien quotidien des sanitaires et de la cuisine, un passage hebdomadaire pour les bureaux individuels peu utilisés, et un passage à la demande pour les salles de réunion. C\'est l\'objet du cahier des charges que nous établissons avec vous.</p>
<h2>Ajuster la fréquence dans le temps</h2>
<p>Un effectif qui grandit, un déménagement, une saisonnalité d\'activité : la fréquence retenue au départ n\'est pas figée. Nous vous recommandons de la revoir avec votre interlocutrice dès que votre organisation évolue sensiblement, pour garder un budget ajusté à la réalité.</p>',
		'post_date'     => '2026-01-12 09:00:00',
		'post_date_gmt' => '2026-01-12 09:00:00',
	) );
	$wpdb->update(
		$wpdb->posts,
		array( 'post_modified' => '2026-03-18 09:00:00', 'post_modified_gmt' => '2026-03-18 09:00:00' ),
		array( 'ID' => $id )
	);
	clean_post_cache( $id );
	update_post_meta( $id, '_tfp_direct_answer', 'La fréquence adaptée dépend surtout de l\'effectif présent et du type d\'activité : un passage quotidien convient aux bureaux de plus de 15 postes ou aux espaces très fréquentés, 2 à 3 passages par semaine suffisent pour une équipe de 5 à 15 personnes, et un passage hebdomadaire couvre souvent les besoins d\'un petit cabinet de moins de 5 personnes.' );
	update_post_meta( $id, '_tfp_categorie_label', 'Bureaux' );
	update_post_meta( $id, '_tfp_image_alt', 'À quelle fréquence faire nettoyer ses bureaux ?' );
	update_post_meta( $id, '_tfp_erreurs_titre', 'Erreurs à éviter' );
	update_post_meta( $id, '_tfp_erreurs', 'Sous-estimer la fréquence nécessaire pour des sanitaires très fréquentés, au motif que le reste des bureaux est calme.
Demander un passage quotidien par habitude, sans effectif réel qui le justifie, ce qui alourdit inutilement le budget.
Ne jamais réévaluer la fréquence après un changement d\'effectif ou d\'organisation des locaux.' );
	update_post_meta( $id, '_tfp_maillage', 'Pour situer ces repères dans une prestation complète, voyez notre page nettoyage professionnel et le détail de nos tarifs.' );
	update_post_meta( $id, '_tfp_cta_titre', 'Un devis pour vos locaux ?' );
	update_post_meta( $id, '_tfp_cta_texte', 'Gratuit, sous 24 h, sans engagement.' );
	update_post_meta( $id, '_tfp_faq_1_q', 'Peut-on changer de fréquence en cours de contrat ?' );
	update_post_meta( $id, '_tfp_faq_1_a', 'Oui, la fréquence peut être ajustée à tout moment avec votre interlocutrice, à la hausse comme à la baisse, selon l\'évolution de vos besoins.' );
	update_post_meta( $id, '_tfp_faq_2_q', 'Une fréquence hebdomadaire suffit-elle pour un cabinet médical ?' );
	update_post_meta( $id, '_tfp_faq_2_a', 'Cela dépend du flux de patients. Pour les salles d\'attente et sanitaires très fréquentés, un passage plus rapproché est généralement recommandé ; le bureau de consultation peut suivre une fréquence plus légère.' );
	update_post_meta( $id, '_tfp_faq_3_q', 'Le tarif horaire change-t-il selon la fréquence choisie ?' );
	update_post_meta( $id, '_tfp_faq_3_a', 'Non, le tarif de 27 € HT/h reste identique quelle que soit la fréquence retenue ; seul le volume d\'heures mensuel varie.' );
	echo "  ✓ frequence-bureaux\n";
}

/* ---------------- cout-nettoyage-bureaux ---------------- */
$posts = get_posts( array( 'post_type' => 'post', 'name' => 'cout-nettoyage-bureaux', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! article cout-nettoyage-bureaux absent — lancer d'abord les seeds de phase 3\n";
} else {
	$id = $posts[0]->ID;
	wp_update_post( array(
		'ID'            => $id,
		'post_title'    => 'Combien coûte le nettoyage de bureaux ?',
		'post_content'  => '<h2>Comment se calcule le prix du nettoyage de bureaux</h2>
<p>Le budget final résulte de deux éléments : un tarif horaire fixe et un volume d\'heures mensuel variable. Chez Top-Famille Pro, le tarif horaire est de 27 € HT/h, identique pour les prestations régulières et ponctuelles. S\'y ajoutent, selon les cas, des frais de gestion de 9 € HT par mois et, au démarrage, des frais de mise en place de 50 € HT.</p>
<h2>Le tarif horaire, un repère plus fiable que le prix au m²</h2>
<p>Un prix affiché au m² masque souvent le volume d\'heures réellement effectué, ce qui rend la comparaison entre prestataires difficile. Le tarif horaire, lui, est directement lisible : vous savez ce que vaut chaque heure de travail, et pouvez vérifier que le volume proposé correspond à vos besoins réels.</p>
<h2>Ce qui fait varier le volume d\'heures</h2>
<p>Le nombre d\'heures nécessaires dépend de la surface, du type de locaux, de la fréquence retenue et du niveau d\'exigence (standard ou renforcé, notamment pour les espaces recevant du public). Deux bureaux de même surface peuvent ainsi nécessiter des volumes différents selon leur usage.</p>
<h2>Exemples de budgets réels</h2>
<p>À titre indicatif, calculé à 27 € HT/h + 9 € HT de gestion :</p>
[tfp_budget_table]
<h2>Ce qui est inclus, ce qui ne l\'est pas</h2>
<p>Le tarif couvre la main-d\'œuvre de l\'intervenant sélectionné, l\'organisation du planning, le suivi par une interlocutrice dédiée et le cahier de liaison. Les produits et le matériel sont généralement fournis par le client. Les indemnités kilométriques (0,35 € HT/km) et la majoration de 10 % (dimanche, jours fériés, nuit) ne s\'appliquent que dans certains cas, toujours précisés au devis.</p>
<h2>Comment obtenir un devis fiable</h2>
<p>Un devis fiable repose sur un échange précis sur vos locaux : surface, effectif, fréquence souhaitée, contraintes d\'horaires. C\'est pourquoi nous ne proposons pas de simulateur automatique : chaque devis est établi après un échange direct, transmis gratuitement sous 24 heures, sans engagement.</p>',
		'post_date'     => '2026-01-15 09:00:00',
		'post_date_gmt' => '2026-01-15 09:00:00',
	) );
	$wpdb->update(
		$wpdb->posts,
		array( 'post_modified' => '2026-03-18 09:00:00', 'post_modified_gmt' => '2026-03-18 09:00:00' ),
		array( 'ID' => $id )
	);
	clean_post_cache( $id );
	update_post_meta( $id, '_tfp_direct_answer', 'Le nettoyage de bureaux est facturé au tarif horaire, 27 € HT/h chez Top-Famille Pro, identique en régulier et en ponctuel. Pour un petit bureau (8 h/mois), comptez environ 225 € HT/mois, frais de gestion compris ; pour un plateau plus large (20 h/mois), environ 549 € HT/mois. Le premier mois inclut, le cas échéant, 50 € HT de frais de mise en place.' );
	update_post_meta( $id, '_tfp_categorie_label', 'Tarifs' );
	update_post_meta( $id, '_tfp_image_alt', 'Combien coûte le nettoyage de bureaux ?' );
	update_post_meta( $id, '_tfp_erreurs_titre', 'Erreurs à éviter' );
	update_post_meta( $id, '_tfp_erreurs', 'Comparer des prix au m² entre prestataires sans vérifier le volume horaire réellement inclus.
Choisir uniquement sur le prix affiché, sans vérifier ce qui est inclus (suivi, remplacement, gestion administrative).
Ignorer les frais de mise en place et découvrir un premier mois plus élevé que prévu.' );
	update_post_meta( $id, '_tfp_maillage', 'Pour situer ces repères dans une prestation complète, voyez notre page nettoyage professionnel et le détail de nos tarifs.' );
	update_post_meta( $id, '_tfp_cta_titre', 'Un devis pour vos locaux ?' );
	update_post_meta( $id, '_tfp_cta_texte', 'Gratuit, sous 24 h, sans engagement.' );
	update_post_meta( $id, '_tfp_faq_1_q', 'Le prix est-il différent pour un contrat régulier ou une intervention ponctuelle ?' );
	update_post_meta( $id, '_tfp_faq_1_a', 'Non, le tarif horaire de 27 € HT/h est identique dans les deux cas. Les frais de gestion mensuels ne s\'appliquent qu\'aux contrats réguliers.' );
	update_post_meta( $id, '_tfp_faq_2_q', 'Peut-on avoir un budget précis avant de s\'engager ?' );
	update_post_meta( $id, '_tfp_faq_2_a', 'Oui, le devis détaille le volume d\'heures estimé et le budget mensuel correspondant, avant toute décision de votre part.' );
	update_post_meta( $id, '_tfp_faq_3_q', 'Le budget peut-il changer en cours de contrat ?' );
	update_post_meta( $id, '_tfp_faq_3_a', 'Oui, si votre besoin évolue (surface, fréquence, effectif), le volume d\'heures et donc le budget sont ajustés avec votre interlocutrice.' );
	echo "  ✓ cout-nettoyage-bureaux\n";
}

/* ---------------- cahier-des-charges-nettoyage ---------------- */
$posts = get_posts( array( 'post_type' => 'post', 'name' => 'cahier-des-charges-nettoyage', 'numberposts' => 1, 'post_status' => 'any' ) );
if ( empty( $posts ) ) {
	echo "  ! article cahier-des-charges-nettoyage absent — lancer d'abord les seeds de phase 3\n";
} else {
	$id = $posts[0]->ID;
	wp_update_post( array(
		'ID'            => $id,
		'post_title'    => 'Comment rédiger un cahier des charges de nettoyage ?',
		'post_content'  => '<h2>Pourquoi un cahier des charges change tout</h2>
<p>Un cahier des charges précis évite les malentendus les plus fréquents : tâches oubliées, attentes mal comprises, zones sensibles négligées. Il sert de référence commune entre vous, l\'intervenant et votre interlocutrice, et permet un contrôle objectif du travail réalisé.</p>
<h2>Les espaces à lister</h2>
<p>La première étape consiste à lister precisément chaque espace concerné, plutôt que de parler globalement des « bureaux » :</p>
<ul>
<li>Postes de travail et open-spaces</li>
<li>Salles de réunion</li>
<li>Accueil et zones de circulation</li>
<li>Sanitaires (nombre et emplacement)</li>
<li>Cuisine ou salle de pause</li>
<li>Zones sensibles à exclure (salle serveur, archives, coffre)</li>
</ul>
<h2>Les tâches à préciser par espace</h2>
<p>Pour chaque espace, précisez les tâches attendues et leur niveau d\'exigence : dépoussiérage des surfaces, aspiration et lavage des sols, vidage des corbeilles, entretien des points de contact courants, réapprovisionnement des consommables. Plus la description est concrète, plus le résultat sera conforme à vos attentes dès le premier passage.</p>
<h2>Fréquence et horaires</h2>
<p>Le cahier des charges précise aussi la fréquence retenue par espace (voir notre article sur la fréquence de nettoyage des bureaux) et les horaires possibles : avant l\'arrivée des équipes, après leur départ, ou en dehors des heures d\'ouverture pour les commerces.</p>
<h2>Accès, clés et consignes de sécurité</h2>
<p>Les modalités d\'accès (clés, badge, code, ou présence obligatoire) doivent être formalisées, ainsi que les consignes de sécurité et de confidentialité propres à vos locaux : zones à ne pas ouvrir, documents à ne pas déplacer, protocole en cas d\'alarme.</p>
<h2>Un document vivant, pas figé</h2>
<p>Le cahier des charges n\'est pas gravé dans le marbre : il évolue avec votre organisation. Un changement d\'effectif, un déménagement interne ou une nouvelle salle à intégrer sont autant de raisons de le mettre à jour avec votre interlocutrice.</p>',
		'post_date'     => '2026-01-20 09:00:00',
		'post_date_gmt' => '2026-01-20 09:00:00',
	) );
	$wpdb->update(
		$wpdb->posts,
		array( 'post_modified' => '2026-03-18 09:00:00', 'post_modified_gmt' => '2026-03-18 09:00:00' ),
		array( 'ID' => $id )
	);
	clean_post_cache( $id );
	update_post_meta( $id, '_tfp_direct_answer', 'Un cahier des charges de nettoyage professionnel liste les espaces à entretenir, les tâches attendues dans chacun, la fréquence de passage, les horaires possibles et les points de vigilance (accès, matériel fragile, confidentialité). Chez Top-Famille Pro, il est rédigé avec vous avant la première intervention et sert de référence à l\'intervenant tout au long de la prestation.' );
	update_post_meta( $id, '_tfp_categorie_label', 'Organisation' );
	update_post_meta( $id, '_tfp_image_alt', 'Comment rédiger un cahier des charges de nettoyage ?' );
	update_post_meta( $id, '_tfp_erreurs_titre', 'Erreurs à éviter' );
	update_post_meta( $id, '_tfp_erreurs', 'Rester trop vague (« nettoyer les bureaux ») sans détailler les tâches attendues dans chaque espace.
Oublier de mentionner les zones sensibles à exclure (salle serveur, archives, coffre).
Ne jamais mettre à jour le document après un changement d\'organisation ou d\'effectif.' );
	update_post_meta( $id, '_tfp_maillage', 'Pour situer ces repères dans une prestation complète, voyez notre page nettoyage professionnel et le détail de nos tarifs.' );
	update_post_meta( $id, '_tfp_cta_titre', 'Un devis pour vos locaux ?' );
	update_post_meta( $id, '_tfp_cta_texte', 'Gratuit, sous 24 h, sans engagement.' );
	update_post_meta( $id, '_tfp_faq_1_q', 'Qui rédige le cahier des charges ?' );
	update_post_meta( $id, '_tfp_faq_1_a', 'Il est rédigé conjointement, à partir de votre description des locaux et de vos attentes, formalisé par votre interlocutrice avant la première intervention.' );
	update_post_meta( $id, '_tfp_faq_2_q', 'Peut-on le modifier après le début de la prestation ?' );
	update_post_meta( $id, '_tfp_faq_2_a', 'Oui, à tout moment, en lien avec votre interlocutrice, notamment si vos locaux ou votre organisation évoluent.' );
	update_post_meta( $id, '_tfp_faq_3_q', 'Le cahier des charges a-t-il un impact sur le tarif ?' );
	update_post_meta( $id, '_tfp_faq_3_a', 'Il permet surtout d\'estimer précisément le volume d\'heures nécessaire ; le tarif horaire de 27 € HT/h reste, lui, inchangé.' );
	echo "  ✓ cahier-des-charges-nettoyage\n";
}

/* ---------------- index Conseils ---------------- */
update_option( 'tfp_conseils_index', array(
	'h1'    => 'Conseils & repères',
	'lede'  => 'Des repères concrets et vérifiables sur le nettoyage professionnel de bureaux et de locaux, écrits par Audrey à partir de nos échanges quotidiens avec des dirigeants, commerçants et gestionnaires de Bourgogne-Franche-Comté.
Vous y trouverez de quoi cadrer une fréquence de passage, estimer un budget réaliste ou rédiger un cahier des charges — sans jargon commercial, avec des exemples chiffrés et des repères que nous appliquons nous-mêmes au quotidien.',
	'h2s'   => 'Les autres articles
Passer du conseil à votre situation
Un besoin d\'entretien pour vos locaux ?',
) );
echo "  ✓ index conseils\n";

echo "Terminé.\n";
