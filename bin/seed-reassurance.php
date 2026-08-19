<?php
/**
 * Réglages « Réassurance & avis » — valeurs décidées, versionnées.
 *
 * Ces réglages vivent normalement en administration (Réglages → Réassurance & avis) et partent
 * vides : une installation neuve n'affiche ni note, ni compteur, ni avis tant que rien n'est saisi.
 * Ce fichier existe pour que les valeurs **décidées** soient reproductibles d'un banc à l'autre et
 * traçables dans l'historique, plutôt que saisies à la main et perdues au prochain montage.
 *
 * ## La note Google — masquée
 *
 * La note de 5,0/5 a été confirmée réelle par Emmanuel le 9 août 2026, puis brièvement réaffichée
 * le 17 août via une dérogation. **Cette dérogation est supprimée** : la consigne du 18 août 2026
 * interdit d'afficher une note Google comme authentique tant qu'une fiche officielle vérifiable de
 * Top-Famille Pro n'est pas fournie.
 *
 * La note reste donc **enregistrée** ici — c'est une donnée réelle, il n'y a pas de raison de la
 * perdre — et reste **invisible**, parce que la garde de `tfp_reassurance_data()` exige désormais
 * TROIS conditions simultanées : une note saisie, une URL de fiche non vide, et une URL qui a la
 * forme d'une fiche Google. Aucun réglage ne permet plus de contourner la deuxième et la troisième.
 *
 * **Ce fichier ne peut pas réactiver la note** : il n'écrit jamais `google_url`, et le seul réglage
 * qui permettait de l'afficher sans elle n'existe plus. Le jour où l'URL sera connue, elle se
 * saisit en administration et la note revient d'elle-même, partout, sans toucher au code.
 *
 * ## Ce qui ne dépend d'aucun réglage
 *
 *  1. **aucune donnée structurée `Review` ni `AggregateRating`** — baliser comme note du site une
 *     note de plateforme tierce contrevient aux règles de Google sur les résultats enrichis, et il
 *     manque de toute façon un nombre d'avis (CLAUDE.md §5.5) ;
 *  2. **aucun compteur d'avis** tant que le nombre réel n'est pas saisi — « 47 avis » est un
 *     chiffre du prototype, vérifiable et faux ;
 *  3. **aucun `href="#"`** à la place de l'URL de la fiche.
 *
 * Usage : wp eval-file bin/seed-reassurance.php
 */

if ( ! defined( 'WP_CLI' ) && ! defined( 'ABSPATH' ) ) {
	die( "À lancer via WP-CLI : wp eval-file bin/seed-reassurance.php\n" );
}

$actuel = get_option( TFP_REASSURANCE_OPTION, array() );
$actuel = is_array( $actuel ) ? $actuel : array();

// Purge de l'ancienne dérogation : une base montée avant le 18 août 2026 la porte encore, et la
// laisser en place serait sans effet aujourd'hui mais trompeuse à la relecture de l'option.
unset( $actuel['note_sans_source'] );

$valeurs = array_merge(
	tfp_reassurance_defaults(),
	$actuel,
	array(
		// Enregistrée, et masquée tant que la fiche n'est pas fournie : c'est la garde qui décide.
		'note'        => '5.0',
		// Jamais écrits ici : ils ne sont pas connus, et rien ne s'invente. `google_url` en
		// particulier est le seul interrupteur de la note — le seed ne doit pas pouvoir l'actionner.
		'google_url'  => $actuel['google_url'] ?? '',
		'nombre_avis' => $actuel['nombre_avis'] ?? '',
	)
);

update_option( TFP_REASSURANCE_OPTION, $valeurs );

$visible = '' !== $valeurs['note'] && tfp_reassurance_url_fiche_valide( $valeurs['google_url'] );

echo "=== Réassurance & avis ===\n";
echo '  note enregistrée : ' . ( '' !== $valeurs['note'] ? $valeurs['note'] . '/5' : '(vide)' ) . "\n";
echo '  URL de la fiche  : ' . ( '' !== $valeurs['google_url'] ? $valeurs['google_url'] : '(à fournir)' ) . "\n";
echo '  note AFFICHÉE    : ' . ( $visible ? 'oui' : 'NON — fiche vérifiable absente (consigne du 18/08/2026)' ) . "\n";
echo '  nombre d’avis    : ' . ( '' !== (string) $valeurs['nombre_avis'] ? $valeurs['nombre_avis'] : '(à fournir — compteur masqué)' ) . "\n";
