<?php
/**
 * Réglages « Réassurance & avis » — valeurs décidées, versionnées.
 *
 * Ces réglages vivent normalement en administration (Réglages → Réassurance & avis) et partent
 * vides : une installation neuve n'affiche ni note, ni compteur, ni avis tant que rien n'est saisi.
 * Ce fichier existe pour que les valeurs **décidées** soient reproductibles d'un banc à l'autre et
 * traçables dans l'historique, plutôt que saisies à la main et perdues au prochain montage.
 *
 * ## La note Google
 *
 * Note de 5,0/5, **confirmée réelle par Emmanuel le 9 août 2026**. Elle avait été retirée en
 * G26 §7 : la validation humaine du 17 août 2026 a été refusée notamment parce qu'elle était
 * affirmée sans lien vers la fiche qui la porte, donc invérifiable par le visiteur.
 *
 * Le 17 août 2026, la conséquence lui ayant été exposée, **Emmanuel a demandé de la réafficher en
 * attendant l'URL**. C'est ce que fait `note_sans_source`. Ce n'est pas un retrait de la garde :
 * la garde reste en place et redevient la règle dès que la case est décochée, ce qu'il faudra
 * faire le jour où l'URL sera connue — elle est alors inutile.
 *
 * ## Ce que cette décision ne change PAS
 *
 * Trois points ne dépendent d'aucun réglage et restent vrais quoi qu'il arrive :
 *
 *  1. **aucune donnée structurée `Review` ni `AggregateRating`** — baliser comme note du site une
 *     note de plateforme tierce contrevient aux règles de Google sur les résultats enrichis, et il
 *     manque de toute façon un nombre d'avis (CLAUDE.md §5.5) ;
 *  2. **aucun compteur d'avis** tant que le nombre réel n'est pas saisi — « 47 avis » est un
 *     chiffre du prototype, vérifiable et faux ;
 *  3. **aucun `href="#"`** à la place de l'URL de la fiche : sans URL, le badge s'affiche sans
 *     lien plutôt qu'avec un lien mort.
 *
 * Usage : wp eval-file bin/seed-reassurance.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-reassurance.php\n" );
}

$actuel = get_option( TFP_REASSURANCE_OPTION, array() );
$actuel = is_array( $actuel ) ? $actuel : array();

$valeurs = array_merge(
	tfp_reassurance_defaults(),
	$actuel,
	array(
		'note'             => '5.0',
		// Dérogation explicite — voir l'en-tête. À retirer avec l'arrivée de l'URL de la fiche.
		'note_sans_source' => true,
		// Volontairement laissés vides : ils ne sont pas connus, et rien ne s'invente ici.
		'google_url'       => $actuel['google_url'] ?? '',
		'nombre_avis'      => $actuel['nombre_avis'] ?? '',
	)
);

update_option( TFP_REASSURANCE_OPTION, $valeurs );

echo "=== Réassurance & avis ===\n";
echo '  note              : ' . ( '' !== $valeurs['note'] ? $valeurs['note'] . '/5' : '(vide)' ) . "\n";
echo '  affichée sans URL : ' . ( ! empty( $valeurs['note_sans_source'] ) ? 'OUI (dérogation du 17/08/2026)' : 'non' ) . "\n";
echo '  URL de la fiche   : ' . ( '' !== $valeurs['google_url'] ? $valeurs['google_url'] : '(à fournir — décocher la dérogation ce jour-là)' ) . "\n";
echo '  nombre d’avis     : ' . ( '' !== (string) $valeurs['nombre_avis'] ? $valeurs['nombre_avis'] : '(à fournir — compteur masqué)' ) . "\n";
