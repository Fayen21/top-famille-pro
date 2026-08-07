<?php
/**
 * Phase 3, lot 5a — les 2 articles restants (coût du nettoyage de bureaux, cahier des charges).
 * Fréquence de nettoyage des bureaux a été créée en phase 2.
 *
 * Contenu repris du prototype, corrigé selon CLAUDE.md §9 :
 * - tarif fictif « 27 € HT/h » retiré partout ;
 * - le tableau de budgets de « cout-nettoyage-bureaux » recalculé sur le tarif réel « autres
 *   locaux » (26,00 € HT/h, PROJECT_INPUTS.md §5 — les bureaux ne relèvent pas du tarif
 *   « locations » à 24,30 €) : 8 h/mois → 217 € HT (267 € le 1er mois), 12 h/mois → 321 € HT
 *   (371 € le 1er mois, valeur déjà utilisée sur l'accueil via tfp_home_budget_example()),
 *   20 h/mois → 529 € HT (579 € le 1er mois).
 *
 * Usage : wp eval-file bin/seed-phase3-batch5-articles.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-phase3-batch5-articles.php\n" );
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

if ( ! term_exists( 'conseils', 'category' ) ) {
	wp_insert_term( 'Conseils', 'category', array( 'slug' => 'conseils' ) );
}
$conseils_cat = get_category_by_slug( 'conseils' );

echo "=== Seed phase 3, lot 5a : 2 articles restants ===\n";

/* ------------------------------------------------------------------ */
/* 1. Combien coûte le nettoyage de bureaux ?                          */
/* ------------------------------------------------------------------ */

$cout_content = "<p>Le budget final résulte de deux éléments : un tarif horaire fixe et un volume d'heures mensuel variable. Chez Top-Famille Pro, le tarif horaire est de 26,00 € HT/h pour des bureaux (tarif « autres locaux » de la grille, voir la page Tarifs pour le détail complet), identique pour les prestations régulières et ponctuelles hors majoration. S'y ajoutent, selon les cas, des frais de gestion de 9 € HT par mois et, au démarrage, des frais de mise en place de 50 € HT.</p>

<h2>Le tarif horaire, un repère plus fiable que le prix au m²</h2>
<p>Un prix affiché au m² masque souvent le volume d'heures réellement effectué, ce qui rend la comparaison entre prestataires difficile. Le tarif horaire, lui, est directement lisible : vous savez ce que vaut chaque heure de travail, et pouvez vérifier que le volume proposé correspond à vos besoins réels.</p>

<h2>Ce qui fait varier le volume d'heures</h2>
<p>Le nombre d'heures nécessaires dépend de la surface, du type de locaux, de la fréquence retenue et du niveau d'exigence (standard ou renforcé, notamment pour les espaces recevant du public). Deux bureaux de même surface peuvent ainsi nécessiter des volumes différents selon leur usage.</p>

<h2>Exemples de budgets réels</h2>
<p>À titre indicatif, calculé à 26,00 € HT/h (tarif « autres locaux ») + 9 € HT de gestion :</p>
<ul>
<li>Petit bureau ou cabinet, 8 h/mois : 217 € HT/mois (267 € HT le premier mois, frais de mise en place compris)</li>
<li>Bureaux réguliers, 12 h/mois : 321 € HT/mois (371 € HT le premier mois)</li>
<li>Besoin plus important, 20 h/mois : 529 € HT/mois (579 € HT le premier mois)</li>
</ul>

<h2>Ce qui est inclus, ce qui ne l'est pas</h2>
<p>Le tarif couvre la main-d'œuvre de l'intervenant sélectionné, l'organisation du planning, le suivi par une interlocutrice dédiée et le cahier de liaison. Les produits et le matériel sont fournis par le client. Les indemnités kilométriques (0,35 € HT/km) et la majoration de 10 % (dimanche, jours fériés, nuit) ne s'appliquent que dans certains cas, toujours précisés au devis.</p>

<h2>Comment obtenir un devis fiable</h2>
<p>Un devis fiable repose sur un échange précis sur vos locaux : surface, effectif, fréquence souhaitée, contraintes d'horaires. C'est pourquoi nous ne proposons pas de simulateur automatique : chaque devis est étudié personnellement par Audrey et transmis gratuitement sous 24 heures, sans engagement.</p>

<h2>Erreurs à éviter</h2>
<ul>
<li>Comparer des prix au m² entre prestataires sans vérifier le volume horaire réellement inclus.</li>
<li>Choisir uniquement sur le prix affiché, sans vérifier ce qui est inclus (suivi, remplacement, gestion administrative).</li>
<li>Ignorer les frais de mise en place et découvrir un premier mois plus élevé que prévu.</li>
</ul>";

$cout_id = tfp_seed_upsert_post(
	array(
		'post_type'     => 'post',
		'post_title'    => 'Combien coûte le nettoyage de bureaux ?',
		'post_name'     => 'cout-nettoyage-bureaux',
		'post_status'   => 'publish',
		'post_content'  => $cout_content,
		'post_excerpt'  => "Tarif horaire, volume d'heures, frais de gestion : comprendre ce qui compose un budget de nettoyage de bureaux.",
		'post_category' => $conseils_cat ? array( $conseils_cat->term_id ) : array(),
	)
);

update_post_meta(
	$cout_id,
	'_tfp_direct_answer',
	"Le nettoyage de bureaux est facturé au tarif horaire, 26,00 € HT/h chez Top-Famille Pro pour des bureaux (tarif « autres locaux »), identique en régulier et en ponctuel hors majoration. Pour un petit bureau (8 h/mois), comptez environ 217 € HT/mois, frais de gestion compris ; pour un plateau plus large (20 h/mois), environ 529 € HT/mois. Le premier mois inclut, le cas échéant, 50 € HT de frais de mise en place."
);

$cout_faqs = array(
	array( 'q' => 'Le prix est-il différent pour un contrat régulier ou une intervention ponctuelle ?', 'a' => "Le tarif ponctuel (30,00 € HT/h) est légèrement supérieur au tarif régulier « autres locaux » (26,00 € HT/h) — voir la page Tarifs pour le détail. Les frais de gestion mensuels ne s'appliquent qu'aux contrats réguliers." ),
	array( 'q' => 'Peut-on avoir un budget précis avant de s\'engager ?', 'a' => 'Oui, le devis détaille le volume d\'heures estimé et le budget mensuel correspondant, avant toute décision de votre part.' ),
	array( 'q' => 'Le budget peut-il changer en cours de contrat ?', 'a' => "Oui, si votre besoin évolue (surface, fréquence, effectif), le volume d'heures et donc le budget sont ajustés avec votre interlocutrice." ),
);
foreach ( $cout_faqs as $i => $item ) {
	update_post_meta( $cout_id, '_tfp_faq_' . ( $i + 1 ) . '_q', $item['q'] );
	update_post_meta( $cout_id, '_tfp_faq_' . ( $i + 1 ) . '_a', $item['a'] );
}

echo "  Article cout-nettoyage-bureaux : #$cout_id\n";

/* ------------------------------------------------------------------ */
/* 2. Comment rédiger un cahier des charges de nettoyage ?              */
/* ------------------------------------------------------------------ */

$cahier_content = "<p>Un cahier des charges précis évite les malentendus les plus fréquents : tâches oubliées, attentes mal comprises, zones sensibles négligées. Il sert de référence commune entre vous, l'intervenant et votre interlocutrice, et permet un contrôle objectif du travail réalisé.</p>

<h2>Les espaces à lister</h2>
<p>La première étape consiste à lister précisément chaque espace concerné, plutôt que de parler globalement des « bureaux » :</p>
<ul>
<li>Postes de travail et open-spaces</li>
<li>Salles de réunion</li>
<li>Accueil et zones de circulation</li>
<li>Sanitaires (nombre et emplacement)</li>
<li>Cuisine ou salle de pause</li>
<li>Zones sensibles à exclure (salle serveur, archives, coffre)</li>
</ul>

<h2>Les tâches à préciser par espace</h2>
<p>Pour chaque espace, précisez les tâches attendues et leur niveau d'exigence : dépoussiérage des surfaces, aspiration et lavage des sols, vidage des corbeilles, entretien des points de contact courants, réapprovisionnement des consommables. Plus la description est concrète, plus le résultat sera conforme à vos attentes dès le premier passage.</p>

<h2>Fréquence et horaires</h2>
<p>Le cahier des charges précise aussi la fréquence retenue par espace (voir notre article sur la fréquence de nettoyage des bureaux) et les horaires possibles : avant l'arrivée des équipes, après leur départ, ou en dehors des heures d'ouverture pour les commerces.</p>

<h2>Accès, clés et consignes de sécurité</h2>
<p>Les modalités d'accès (clés, badge, code, ou présence obligatoire) doivent être formalisées, ainsi que les consignes de sécurité et de confidentialité propres à vos locaux : zones à ne pas ouvrir, documents à ne pas déplacer, protocole en cas d'alarme.</p>

<h2>Un document vivant, pas figé</h2>
<p>Le cahier des charges n'est pas gravé dans le marbre : il évolue avec votre organisation. Un changement d'effectif, un déménagement interne ou une nouvelle salle à intégrer sont autant de raisons de le mettre à jour avec votre interlocutrice.</p>

<h2>Erreurs à éviter</h2>
<ul>
<li>Rester trop vague (« nettoyer les bureaux ») sans détailler les tâches attendues dans chaque espace.</li>
<li>Oublier de mentionner les zones sensibles à exclure (salle serveur, archives, coffre).</li>
<li>Ne jamais mettre à jour le document après un changement d'organisation ou d'effectif.</li>
</ul>";

$cahier_id = tfp_seed_upsert_post(
	array(
		'post_type'     => 'post',
		'post_title'    => 'Comment rédiger un cahier des charges de nettoyage ?',
		'post_name'     => 'cahier-des-charges-nettoyage',
		'post_status'   => 'publish',
		'post_content'  => $cahier_content,
		'post_excerpt'  => 'Espaces, tâches, fréquences, accès : la méthode pour cadrer une prestation de nettoyage professionnel dès le départ.',
		'post_category' => $conseils_cat ? array( $conseils_cat->term_id ) : array(),
	)
);

update_post_meta(
	$cahier_id,
	'_tfp_direct_answer',
	"Un cahier des charges de nettoyage professionnel liste les espaces à entretenir, les tâches attendues dans chacun, la fréquence de passage, les horaires possibles et les points de vigilance (accès, matériel fragile, confidentialité). Chez Top-Famille Pro, il est rédigé avec vous avant la première intervention et sert de référence à l'intervenant tout au long de la prestation."
);
// Le titre par défaut (titre de l'article + suffixe de marque) dépasse 65 caractères — voir
// includes/articles-meta.php pour le mécanisme de surcharge.
update_post_meta( $cahier_id, '_tfp_seo_title', 'Rédiger un cahier des charges de nettoyage | Top-Famille Pro' );

$cahier_faqs = array(
	array( 'q' => 'Qui rédige le cahier des charges ?', 'a' => 'Il est rédigé conjointement, à partir de votre description des locaux et de vos attentes, formalisé par votre interlocutrice avant la première intervention.' ),
	array( 'q' => 'Peut-on le modifier après le début de la prestation ?', 'a' => 'Oui, à tout moment, en lien avec votre interlocutrice, notamment si vos locaux ou votre organisation évoluent.' ),
	array( 'q' => 'Le cahier des charges a-t-il un impact sur le tarif ?', 'a' => "Il permet surtout d'estimer précisément le volume d'heures nécessaire ; le tarif horaire (24,30 à 30,00 € HT/h selon le type de local et le régime, voir la page Tarifs) reste, lui, inchangé." ),
);
foreach ( $cahier_faqs as $i => $item ) {
	update_post_meta( $cahier_id, '_tfp_faq_' . ( $i + 1 ) . '_q', $item['q'] );
	update_post_meta( $cahier_id, '_tfp_faq_' . ( $i + 1 ) . '_a', $item['a'] );
}

echo "  Article cahier-des-charges-nettoyage : #$cahier_id\n";

echo "=== Lot 5a terminé ===\n";
