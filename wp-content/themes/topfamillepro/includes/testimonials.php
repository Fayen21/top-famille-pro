<?php
/**
 * Témoignages — composant unique, au comportement dépendant de l'environnement.
 *
 * Résout un conflit réel entre deux exigences : reproduire fidèlement la carte témoignage du
 * prototype Claude Design (pour pouvoir comparer et valider le design) sans jamais publier de
 * faux avis en production (CLAUDE.md §5.5 : « Les ~40 avis du prototype, la note 5,0/5 et le
 * compteur de 47 avis sont fictifs : suppression totale »).
 *
 * Règle appliquée :
 * - Production (`wp_get_environment_type() === 'production'`, valeur par DÉFAUT de WordPress) :
 *   jamais de contenu de démonstration. Soit les témoignages réels saisis dans les réglages
 *   « Réassurance & avis », soit un état neutre. Jamais de note Google, jamais de schéma
 *   Review/AggregateRating.
 * - Local / développement / staging : la carte de démonstration du prototype est rendue, avec une
 *   mention explicite et visible dans le DOM (`tfp-demo-notice`), pour permettre les captures
 *   comparatives et la validation visuelle du composant.
 *
 * Le sens de la condition est volontairement « sûr par défaut » : WordPress renvoie 'production'
 * quand `WP_ENVIRONMENT_TYPE` n'est pas défini, donc une installation réelle qui n'a rien
 * configuré n'affiche jamais de démonstration. Il faut une action explicite (définir
 * l'environnement comme local/development/staging) pour la faire apparaître.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Badge de note Google — reproduit celui de la maquette (★★★★★ + « X,X/5 sur Google »), présent
 * à deux endroits du prototype : au-dessus du H1 du hero, et superposé au portrait d'Audrey.
 *
 * Ne s'affiche QUE si une note réelle a été saisie dans Réglages → Réassurance & avis. Tant que
 * le champ est vide, rien n'est rendu : la note 5,0/5 du prototype n'a jamais été confirmée
 * (PROJECT_INPUTS.md, question ouverte #6) et publier une note non vérifiée serait une allégation
 * commerciale fausse — interdite par CLAUDE.md §5.1/§5.5, et par l'article L121-2 du code de la
 * consommation. Le composant est prêt : dès que la vraie note est saisie, les deux badges
 * apparaissent, sans retoucher une ligne de gabarit.
 *
 * @param string $variant 'inline' (hero) ou 'floating' (superposé au portrait).
 */
function tfp_google_rating_badge( $variant = 'inline' ) {
	$data = tfp_reassurance_data();

	if ( empty( $data['note'] ) ) {
		return;
	}

	$note    = number_format( (float) $data['note'], 1, ',', '' );
	$count   = ! empty( $data['nombre_avis'] ) ? (int) $data['nombre_avis'] : 0;
	$url     = ! empty( $data['google_url'] ) ? $data['google_url'] : '';
	$stars   = (int) round( (float) $data['note'] );
	$label   = sprintf(
		/* translators: 1: note sur 5, 2: nombre d'avis */
		$count ? '%1$s/5 sur Google, %2$d avis' : '%1$s/5 sur Google',
		$note,
		$count
	);

	printf( '<div class="tfp-google-badge tfp-google-badge--%s">', esc_attr( $variant ) );
	printf(
		'<span class="tfp-google-badge__stars" role="img" aria-label="%s">%s</span>',
		esc_attr( $label ),
		esc_html( str_repeat( '★', $stars ) . str_repeat( '☆', max( 0, 5 - $stars ) ) )
	);
	echo '<span class="tfp-google-badge__text">';
	printf( '<strong>%s/5</strong> sur Google', esc_html( $note ) );
	if ( $count ) {
		printf( ' <span class="tfp-google-badge__count">(%d avis)</span>', (int) $count );
	}
	echo '</span>';
	if ( $url ) {
		printf(
			'<a class="tfp-google-badge__link" href="%s" rel="noopener nofollow" target="_blank">Voir les avis</a>',
			esc_url( $url )
		);
	}
	echo '</div>';
}

/**
 * Le contexte autorise-t-il l'affichage de contenu de démonstration ?
 *
 * @return bool
 */
function tfp_demo_content_allowed() {
	$env = function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production';
	return 'production' !== $env;
}

/**
 * Témoignage mis en avant.
 *
 * Retourne d'abord un témoignage réel s'il en existe un (réglages « Réassurance & avis »), sinon
 * le témoignage de démonstration du prototype — mais uniquement hors production.
 *
 * @return array|null { texte, nom, contexte, demo }
 */
function tfp_featured_testimonial() {
	$reassurance = tfp_reassurance_data();

	if ( ! empty( $reassurance['avis'][0]['texte'] ) ) {
		$avis = $reassurance['avis'][0];
		return array(
			'texte'    => $avis['texte'],
			'nom'      => $avis['nom'],
			'contexte' => $avis['contexte'] ?? '',
			'demo'     => false,
		);
	}

	if ( ! tfp_demo_content_allowed() ) {
		return null;
	}

	// Contenu de démonstration repris du prototype — jamais rendu en production (voir docblock).
	return array(
		'texte'    => "Même intervenante chaque semaine, un cahier de liaison sérieux et Audrey qui répond dans l'heure. On a enfin arrêté de gérer ça en interne.",
		'nom'      => 'Camille R.',
		'contexte' => 'Dirigeante de PME · Bureaux, Dijon',
		'demo'     => true,
	);
}

/**
 * Affiche la carte témoignage (colonne droite du bloc « Pourquoi Top-Famille Pro » du prototype).
 *
 * Aucune note en étoiles n'est rendue pour un témoignage de démonstration : les étoiles du
 * prototype matérialisaient une note Google fictive. Un témoignage réel n'affiche sa note que si
 * elle a été saisie.
 */
function tfp_testimonial_card() {
	$item = tfp_featured_testimonial();

	if ( ! $item ) {
		// État neutre : la mise en page générale est conservée, aucun contenu fictif.
		echo '<div class="tfp-testimonial tfp-testimonial--empty">';
		echo '<p class="tfp-testimonial__empty">Témoignages authentiques à venir.</p>';
		echo '<p class="tfp-testimonial__empty-note">Les témoignages réels se saisissent dans Réglages → Réassurance &amp; avis.</p>';
		echo '</div>';
		return;
	}

	// `data-tfp-demo-block` marque tout le bloc comme non publiable : la suite de tests s'en sert
	// pour exclure ce contenu du contrôle « aucune donnée fictive » hors production, tout en le
	// gardant strictement interdit en production (tests/fidelite.spec.js).
	printf( '<figure class="tfp-testimonial"%s>', ! empty( $item['demo'] ) ? ' data-tfp-demo-block="1"' : '' );

	if ( ! empty( $item['demo'] ) ) {
		printf(
			'<p class="tfp-demo-notice" data-tfp-demo="1">%s</p>',
			esc_html__( 'Exemple de présentation — contenu de démonstration non publié', 'topfamillepro' )
		);
	}

	printf( '<blockquote class="tfp-testimonial__quote">« %s »</blockquote>', esc_html( $item['texte'] ) );

	echo '<figcaption class="tfp-testimonial__author">';
	printf( '<span class="tfp-testimonial__name">%s</span>', esc_html( $item['nom'] ) );
	if ( ! empty( $item['contexte'] ) ) {
		printf( '<span class="tfp-testimonial__context">%s</span>', esc_html( $item['contexte'] ) );
	}
	echo '</figcaption>';

	echo '</figure>';
}
