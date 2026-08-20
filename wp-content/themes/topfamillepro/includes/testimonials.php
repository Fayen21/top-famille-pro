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
 * Variantes : 'inline' (pastille blanche encadrée — hero de l'accueil, pilier, tarifs, pages
 * prestation et zone, là où la maquette la compose ainsi), 'floating' (superposée au portrait
 * d'Audrey), 'nu' (étoiles + note à plat, sans fond ni filet ni rayon — les eyebrows des pages
 * intérieures dont la maquette ne rend PAS la pastille : la seule occurrence de la note y est le
 * lien nu de la barre haute, et une pastille de plus y comptait une carte absente du prototype —
 * relevé G23).
 *
 * @param string $variant 'inline', 'floating' ou 'nu'.
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

	// Témoignage repris de la maquette Claude Design, provisoire jusqu'à saisie d'un avis réel
	// (décision du 10 août 2026 : la maquette est reproduite telle quelle dans cette version de
	// travail, y compris en production).
	return array(
		'texte'    => "Même intervenante chaque semaine, un cahier de liaison sérieux et Audrey qui répond dans l'heure. On a enfin arrêté de gérer ça en interne.",
		'nom'      => 'Camille R.',
		'contexte' => 'Dirigeante de PME · Bureaux, Dijon',
		'demo'     => true,
	);
}

/**
 * Affiche une carte témoignage, reproduite à l'identique de la maquette Claude Design.
 *
 * Décision du 10 août 2026 (Emmanuel) : dans cette version de travail, les témoignages de la
 * maquette sont reproduits tels quels — auteurs, textes, étoiles, cartes — et ne sont PAS masqués
 * en production. Ils sont provisoires et destinés à être remplacés par de vrais avis ; ils sont
 * donc stockés en champs ACF (par prestation) ou dans les réglages « Réassurance & avis », jamais
 * en dur dans un gabarit, et marqués `data-tfp-provisional` pour rester repérables en une requête.
 *
 * Ce qui reste interdit, et n'a pas changé : aucune donnée structurée `Review` ou
 * `AggregateRating` n'est émise à partir de ces témoignages, et ils ne sont jamais mélangés à la
 * note Google réelle dans le balisage (CLAUDE.md §5.5). Les étoiles rendues ici sont un élément
 * graphique de la carte, pas une note revendiquée par le site.
 *
 * @param array|null $item Témoignage explicite { texte, auteur, role, ville } — typiquement les
 *                         champs ACF d'une prestation. À défaut, le témoignage mis en avant des
 *                         réglages, sinon celui de la maquette.
 */
function tfp_testimonial_card( $item = null, $args = array() ) {
	/*
	 * La vignette d'auteur n'est PAS un attribut du composant : c'est un choix de la maquette,
	 * bande par bande. Elle n'apparaît que sur le témoignage mis en avant de l'accueil ; les
	 * trente-deux autres cartes du site n'en portent pas. Un défaut à `true` la posait partout et
	 * fabriquait trente-deux visuels que le prototype n'a pas.
	 */
	$avec_avatar = ! empty( $args['avatar'] );
	if ( is_array( $item ) && ! empty( $item['texte'] ) ) {
		$contexte = implode(
			' · ',
			array_filter( array( $item['role'] ?? '', $item['ville'] ?? '' ) )
		);
		$item = array(
			'texte'    => $item['texte'],
			'nom'      => $item['auteur'] ?? '',
			'contexte' => $contexte,
			'demo'     => true,
		);
	} else {
		$item = tfp_featured_testimonial();
	}

	if ( ! $item ) {
		// État neutre : la mise en page générale est conservée, aucun contenu fictif.
		echo '<div class="tfp-testimonial tfp-testimonial--empty">';
		echo '<p class="tfp-testimonial__empty">Témoignages authentiques à venir.</p>';
		echo '<p class="tfp-testimonial__empty-note">Les témoignages réels se saisissent dans Réglages → Réassurance &amp; avis.</p>';
		echo '</div>';
		return;
	}

	// `data-tfp-provisional` marque un témoignage repris de la maquette et non encore remplacé par
	// un avis réel : la suite de tests s'en sert pour l'exclure du contrôle « aucune donnée
	// fictive », et il suffit d'une recherche sur cet attribut pour tous les retrouver.
	/*
	 * Géométrie de la carte relevée sur la maquette — rembourrage, rayon, écart entre ses blocs.
	 * Sans relevé, les jetons du thème s'appliquent : c'est le comportement d'avant.
	 */
	$carte      = isset( $args['carte'] ) && is_array( $args['carte'] ) ? $args['carte'] : array();
	$vars_carte = array();
	foreach ( array( 'padding' => '--tfp-avis-padding', 'rayon' => '--tfp-avis-rayon', 'gap' => '--tfp-avis-gap' ) as $cle => $var ) {
		$v = trim( (string) ( $carte[ $cle ] ?? '' ) );
		if ( '' !== $v && preg_match( '/^[0-9.px ]+$/', $v ) ) {
			$vars_carte[] = $var . ':' . $v;
		}
	}
	/*
	 * Variantes de carte relevées sur la maquette. La liste est fermée : un appelant ne peut pas
	 * injecter une classe arbitraire, et une variante inconnue retombe silencieusement sur la
	 * carte de base plutôt que de produire un rendu sans style.
	 *
	 * `compacte` — colonne latérale du formulaire de devis : fond glacier, pas d'ombre, 22 px de
	 * rembourrage, étoiles et légende réduites, auteur et contexte sur une seule ligne.
	 */
	$variantes = array( 'compacte' );
	$variante  = in_array( (string) ( $args['variante'] ?? '' ), $variantes, true ) ? (string) $args['variante'] : '';

	printf(
		'<figure class="tfp-testimonial%s"%s%s>',
		$variante ? ' tfp-testimonial--' . $variante : '',
		! empty( $item['demo'] ) ? ' data-tfp-provisional="1"' : '',
		$vars_carte ? ' style="' . esc_attr( implode( ';', $vars_carte ) ) . '"' : ''
	);

	/*
	 * Rangée d'en-tête relevée sur la maquette : les étoiles, puis la source de l'avis quand elle
	 * est connue. La source n'est PAS une note du site — c'est le nom de la plateforme où l'avis a
	 * été laissé, écrit à côté des étoiles, sans chiffre. Aucune donnée structurée n'en découle
	 * (CLAUDE.md §5.5).
	 */
	$etoiles = ! empty( $args['etoiles'] ) ? (string) $args['etoiles'] : str_repeat( '★', 5 );
	$source  = isset( $args['source'] ) ? trim( (string) $args['source'] ) : '';
	echo '<span class="tfp-testimonial__head">';
	printf( '<span class="tfp-testimonial__stars" aria-hidden="true">%s</span>', esc_html( $etoiles ) );
	if ( '' !== $source ) {
		printf( '<span class="tfp-testimonial__source">%s</span>', esc_html( $source ) );
	}
	echo '</span>';
	/*
	 * Géométrie relevée sur la maquette, niveau par niveau. La carte porte trois tailles — citation,
	 * nom, métadonnées — là où une tuile générique n'en porte que deux. Sans relevé, l'échelle du
	 * thème s'applique, comme avant.
	 */
	$geo  = isset( $args['geo'] ) && is_array( $args['geo'] ) ? $args['geo'] : array();
	$vars = static function ( $niveau ) use ( $geo ) {
		$g = $geo[ $niveau ] ?? array();
		$out = array();
		/*
		 * La taille passe par le filtre de longueur commun, et non par un `\d+px` : la maquette
		 * écrit la citation de l'avis mis en avant `clamp(19px, 2.2vw, 25px)`, et un motif qui
		 * n'accepte que des pixels rejetait silencieusement le relevé — la citation retombait sur
		 * l'échelle du thème à toutes les largeurs.
		 */
		$taille = function_exists( 'tfp_longueur_css' ) ? tfp_longueur_css( $g['taille'] ?? '' ) : '';
		if ( '' !== $taille ) {
			$out[] = '--tfp-avis-' . $niveau . ':' . $taille;
		}
		/*
		 * L'interligne est accepté en pixels OU en ratio sans unité. Le ratio est ce qu'il faut
		 * quand la taille est une fonction : 1,5 suit le `clamp`, 37,5 px ne le suit pas.
		 */
		$lh = trim( (string) ( $g['interligne'] ?? '' ) );
		if ( preg_match( '/^[0-9.]+(px)?$/', $lh ) && (float) $lh > 0 ) {
			$out[] = '--tfp-avis-' . $niveau . '-lh:' . $lh;
		}
		return $out ? ' style="' . esc_attr( implode( ';', $out ) ) . '"' : '';
	};

	printf(
		'<blockquote class="tfp-testimonial__quote"%s>« %s »</blockquote>',
		$vars( 'citation' ), // phpcs:ignore WordPress.Security.EscapeOutput
		esc_html( $item['texte'] )
	);

	echo '<figcaption class="tfp-testimonial__author">';
	/*
	 * Vignette d'auteur — 44 px, ronde, relevée sur la maquette (G26 §3).
	 *
	 * Elle manquait, et l'audit d'images par rôle la comptait absente sur l'accueil. Elle n'est
	 * rendue QUE pour un témoignage provisoire, et son `alt` est vide : la carte porte déjà
	 * `data-tfp-provisional` et sa mention visible, le nom est écrit juste à côté, et le visuel ne
	 * prétend donc représenter personne (CLAUDE.md §5.6). Un vrai avis saisi en administration
	 * n'en reçoit pas : rien n'irait alors illustrer un client réel par une photo de stock.
	 */
	if ( $avec_avatar && ! empty( $item['demo'] ) && function_exists( 'tfp_image_exists' ) && tfp_image_exists( 'avatar-temoignage' ) ) {
		echo '<span class="tfp-testimonial__avatar">';
		tfp_picture( 'avatar-temoignage', array( 'sizes' => '44px', 'alt' => '' ) );
		echo '</span>';
	}
	printf(
		'<span class="tfp-testimonial__name"%s>%s</span>',
		$vars( 'auteur' ), // phpcs:ignore WordPress.Security.EscapeOutput
		esc_html( $item['nom'] )
	);
	if ( ! empty( $item['contexte'] ) ) {
		/*
		 * En variante compacte, la maquette écrit « Sarah B. · Commerçante · Dole » sur une seule
		 * ligne. Le point médian est un VRAI caractère dans un élément dédié, pas un `::before` :
		 * un contenu généré par la CSS est restitué par la plupart des lecteurs d'écran, et
		 * « point médian » entre le nom et le métier n'apporte rien. Marqué `aria-hidden`, il se
		 * voit et ne s'entend pas.
		 */
		if ( 'compacte' === $variante ) {
			echo '<span class="tfp-testimonial__sep" aria-hidden="true"> · </span>';
		}
		printf(
			'<span class="tfp-testimonial__context"%s>%s</span>',
			$vars( 'meta' ), // phpcs:ignore WordPress.Security.EscapeOutput
			esc_html( $item['contexte'] )
		);
	}
	echo '</figcaption>';

	/*
	 * La mention accompagne la carte elle-même : elle ne peut donc pas être oubliée sur une route.
	 *
	 * Sauf quand la GRILLE l'a déjà posée au-dessus de ses cartes — c'est le cas des six avis de
	 * `/avis-clients/`, dont `tfp_card_grid()` annonce le caractère provisoire une fois pour
	 * toutes. La répéter dans chaque carte ne dit rien de plus au visiteur et ajoute ici trois
	 * lignes par carte : 58 px × 6, soit une page de 9 % plus longue que la maquette pour une
	 * information déjà donnée juste au-dessus.
	 */
	if ( ! empty( $item['demo'] ) && false !== ( $args['mention'] ?? true ) ) {
		echo '<figcaption class="tfp-provisional-notice" data-tfp-provisional-notice="1">'
			. 'Exemple de présentation — témoignages authentiques en cours d’intégration.'
			. '</figcaption>';
	}

	echo '</figure>';
}

/**
 * Mention de transparence des contenus provisoires.
 *
 * Les témoignages repris de la maquette servent à reproduire le design, mais ce ne sont pas de
 * vrais avis. L'attribut `data-tfp-provisional` les rend repérables **pour l'équipe** ; il ne dit
 * rien au visiteur, qui ne lit pas le code source. Trente-huit routes affichaient donc des avis
 * d'apparence authentique sans que rien ne signale leur statut — c'est ce que cette mention
 * corrige. Elle est discrète mais lisible, et dans le flux normal : ni masquée, ni réservée aux
 * lecteurs d'écran.
 */
function tfp_provisional_notice( $texte = '' ) {
	echo '<p class="tfp-provisional-notice" data-tfp-provisional-notice="1">'
		. esc_html( '' !== $texte ? $texte : 'Exemples de présentation — témoignages authentiques en cours d’intégration.' )
		. '</p>';
}

/**
 * Y a-t-il encore des témoignages provisoires à l'écran ?
 *
 * Vrai tant qu'aucun avis réel n'a été saisi dans Réglages → Réassurance & avis : les cartes
 * affichent alors les exemples repris de la maquette.
 */
function tfp_has_provisional_testimonials() {
	$reels = function_exists( 'tfp_real_testimonials' ) ? tfp_real_testimonials() : array();
	return empty( $reels );
}

/**
 * Neutralise, dans le contenu d'une page, l'affirmation d'authenticité des avis.
 *
 * Voir `tfp_static_page_data()` : la phrase est exacte comme intention, fausse comme description
 * de ce qui est actuellement affiché. On la remplace par une formulation qui dit la même chose au
 * futur, sans rien affirmer sur les contenus visibles aujourd'hui.
 *
 * @param mixed $data Contenu de page, tel que stocké.
 * @return mixed
 */
function tfp_neutralise_authenticity_claim( $data ) {
	$avant = 'Nous ne publions que des avis authentiques et autorisés.';
	$apres = 'Seuls des avis authentiques et autorisés y seront publiés.';

	$parcourir = static function ( $valeur ) use ( &$parcourir, $avant, $apres ) {
		if ( is_string( $valeur ) ) {
			return str_replace( $avant, $apres, $valeur );
		}
		if ( is_array( $valeur ) ) {
			return array_map( $parcourir, $valeur );
		}
		return $valeur;
	};

	return $parcourir( $data );
}
