<?php
/**
 * Composants globaux réutilisables (rendu PHP) : bouton, badge de réassurance.
 * Les composants purement structurels (carte, conteneur, section) sont des classes CSS
 * (.tfp-card, .tfp-container, .tfp-section — src/css/03-layout.css et 04-components.css) :
 * pas besoin d'une fonction PHP pour un <div class="…">.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiche un bouton/lien.
 *
 * @param array $args {
 *   @type string $label   Texte visible (obligatoire).
 *   @type string $href    URL (obligatoire).
 *   @type string $variant 'primary' | 'secondary' | 'copper' | 'on-primary' | 'on-dark'. Défaut 'primary'.
 *   @type string $size    '' | 'sm'. Défaut ''.
 *   @type bool   $block   Pleine largeur. Défaut false.
 *   @type string $icon    HTML brut optionnel affiché avant le label (ex. picto téléphone).
 * }
 */
function tfp_button( $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'label'   => '',
			'href'    => '#',
			'variant' => 'primary',
			'size'    => '',
			'block'   => false,
			'icon'    => '',
		)
	);

	$classes = array( 'tfp-btn', 'tfp-btn--' . $args['variant'] );
	if ( $args['size'] ) {
		$classes[] = 'tfp-btn--' . $args['size'];
	}
	if ( $args['block'] ) {
		$classes[] = 'tfp-btn--block';
	}

	printf(
		'<a class="%1$s" href="%2$s">%3$s%4$s</a>',
		esc_attr( implode( ' ', $classes ) ),
		esc_url( $args['href'] ),
		$args['icon'], // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML de picto contrôlé en interne, jamais de donnée utilisateur.
		esc_html( $args['label'] )
	);
}

/**
 * Affiche un élément de réassurance à coche (bandeau tarifaire).
 *
 * @param string $label
 */
function tfp_check_item( $label ) {
	printf(
		'<span class="tfp-badge--check"><span class="tfp-check-icon" aria-hidden="true">✓</span>%s</span>',
		esc_html( $label )
	);
}

/**
 * Suite de sous-blocs « intitulé + texte » stockés en champs numérotés.
 *
 * Structure répétée de la maquette Claude Design : « Le détail, espace par espace » (jusqu'à 9
 * points), « Une organisation carrée, du planning au suivi » (6 points). ACF gratuit n'ayant pas
 * de champ Repeater, ces sous-blocs sont des champs numérotés ; un intitulé vide interrompt la
 * série, ce qui rend la structure impossible à trouer ou à réordonner depuis l'administration.
 *
 * @param string $prefix  Préfixe des champs (`detail`, `organisation`…).
 * @param int    $post_id
 * @param int    $max     Nombre maximum de sous-blocs lus.
 * @return array<int,array{titre:string,texte:string}>
 */
function tfp_get_titled_blocks( $prefix, $post_id, $max ) {
	$blocks = array();
	for ( $i = 1; $i <= $max; $i++ ) {
		$titre = tfp_get_field( $prefix . '_' . $i . '_titre', $post_id );
		if ( ! $titre ) {
			continue;
		}
		$blocks[] = array(
			'titre' => $titre,
			'texte' => (string) tfp_get_field( $prefix . '_' . $i . '_texte', $post_id ),
			// Certaines bandes de la maquette mêlent une grille et des cartes pleine largeur : le
			// champ dit lequel des deux traitements s'applique à ce bloc. Il est relevé sur le rendu
			// du prototype, pas deviné (tools/generate-prestations.mjs).
			'carte' => (bool) tfp_get_field( $prefix . '_' . $i . '_carte', $post_id ),
		);
	}
	return $blocks;
}

/**
 * Pose les liens internes d'une phrase de maillage, à partir d'une table expression → URL.
 *
 * La maquette rend ces phrases avec des liens en ligne (page pilier, tarifs, villes, article).
 * Stocker le HTML dans le champ ACF exposerait un éditeur à casser le balisage ; on stocke donc le
 * texte nu et on pose les liens ici. Le texte est échappé avant insertion des ancres : aucune
 * balise saisie en administration n'est interprétée.
 *
 * @param string               $text Texte nu.
 * @param array<string,string> $map  Expression exacte => URL.
 * @return string HTML prêt à l'affichage.
 */
function tfp_link_phrases( $text, array $map ) {
	$html = esc_html( $text );
	foreach ( $map as $phrase => $url ) {
		if ( ! $url || '' === $phrase ) {
			continue;
		}
		$needle = esc_html( $phrase );
		$pos    = strpos( $html, $needle );
		if ( false === $pos ) {
			continue;
		}
		$anchor = '<a href="' . esc_url( $url ) . '">' . $needle . '</a>';
		$html   = substr_replace( $html, $anchor, $pos, strlen( $needle ) );
	}
	return $html;
}

/**
 * Groupes « titre + paragraphes + liste + noms » d'une zone, stockés en champs numérotés.
 *
 * Les pages de zone de la maquette enchaînent des blocs de même forme mais en nombre variable
 * (3 à 5 selon le niveau et la ville). Les numéroter plutôt que les nommer permet à un seul
 * gabarit de servir départements, villes et communes sans branche par niveau, tout en gardant un
 * ordre non modifiable depuis l'administration.
 *
 * @param string $prefix  `recit`, `methode` ou `locaux`.
 * @param int    $post_id
 * @param int    $max
 * @return array<int,array{titre:string,textes:string[],liste:string[],noms:string[],type:string}>
 */
function tfp_get_zone_blocks( $prefix, $post_id, $max ) {
	$blocks = array();
	for ( $i = 1; $i <= $max; $i++ ) {
		$titre = tfp_get_field( $prefix . '_' . $i . '_titre', $post_id );
		if ( ! $titre ) {
			continue;
		}
		$blocks[] = array(
			'titre'  => $titre,
			'textes' => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_texte', $post_id ) ),
			'liste'  => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_liste', $post_id ) ),
			'noms'   => tfp_get_lines( tfp_get_field( $prefix . '_' . $i . '_noms', $post_id ) ),
			'type'   => tfp_get_field( $prefix . '_' . $i . '_type', $post_id ) ?: 'noms',
			// « cartes » (tuile avec description) ou « liens » (rangée simple) : la maquette emploie
			// les deux pour le même groupe de prestations, selon le niveau de la page.
			'variante' => tfp_get_field( $prefix . '_' . $i . '_variante', $post_id ) ?: 'liens',
			// Numéro de la section d'origine dans la maquette : deux groupes qui la partagent
			// restent dans la même bande de fond.
			'section' => (int) tfp_get_field( $prefix . '_' . $i . '_section', $post_id ),
			// Niveau du titre relevé sur la maquette. Un groupe de niveau 3 est un **sous-groupe**
			// du précédent : il reste dans sa colonne au lieu d'en ouvrir une nouvelle. Défaut 2,
			// pour un contenu saisi avant l'introduction du champ.
			'niveau'  => (int) ( tfp_get_field( $prefix . '_' . $i . '_niveau', $post_id ) ?: 2 ),
		);
	}
	return $blocks;
}

/**
 * Contenu d'une page statique narrative, relevé dans la maquette Claude Design.
 *
 * Stocké en option plutôt qu'en champs : ces pages sont des pages WordPress classiques
 * (CLAUDE.md §3), et un contenu de 40 blocs n'a pas à être ressaisi dans dix gabarits PHP.
 * Le contenu est produit par tools/generate-pages.mjs → bin/seed-fidelite-pages.php.
 *
 * @param string $key
 * @return array{h1:string,lede:string[],hero_alt:string,sections:array}
 */
function tfp_static_page_data( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$data = get_option( 'tfp_page_' . $key, array() );

	/*
	 * Une phrase de la maquette devient fausse tant que les témoignages affichés sont provisoires.
	 *
	 * `/avis-clients/` annonce « Nous ne publions que des avis authentiques et autorisés » — c'est
	 * l'intention, et ce sera vrai. Mais les témoignages actuellement à l'écran viennent du
	 * prototype : afficher cette phrase au-dessus d'eux revient à présenter des exemples de
	 * présentation comme des avis vérifiés. La phrase est donc neutralisée **tant que** du
	 * provisoire est affiché, et elle revient d'elle-même le jour où de vrais avis sont saisis
	 * dans Réglages → Réassurance & avis. Rien n'est perdu, rien n'est promis à tort.
	 */
	if ( function_exists( 'tfp_has_provisional_testimonials' ) && tfp_has_provisional_testimonials() ) {
		$data = tfp_neutralise_authenticity_claim( $data );
	}

	$cache[ $key ] = wp_parse_args(
		is_array( $data ) ? $data : array(),
		array( 'h1' => '', 'lede' => array(), 'hero_alt' => '', 'sections' => array() )
	);
	return $cache[ $key ];
}

/* ------------------------------------------------------------------
 * Vocabulaire de cartes de Claude Design.
 *
 * Un composant par archétype réellement employé par le prototype, et non un composant générique
 * unique : le prototype emploie plusieurs compositions distinctes, et les fondre ferait perdre à
 * l'écran ce qui les sépare. Les valeurs de rendu sont dans src/css/04-components.css, relevées sur
 * la maquette ; ces fonctions ne portent que le balisage.
 * ------------------------------------------------------------------ */

/**
 * Panneau sombre d'exclusions : titre, introduction, puis grille de micro-cartes sombres.
 *
 * C'est la section qui dit ce que l'entreprise **ne** fait **pas** (CLAUDE.md §9 : les exclusions
 * réelles qualifient les demandes en amont). La maquette lui donne le poids visuel le plus fort de
 * la page — fond sombre, texte clair — précisément pour qu'elle ne se lise pas en diagonale.
 *
 * @param string   $titre Intitulé du panneau.
 * @param string   $intro Paragraphe d'introduction, facultatif.
 * @param string[] $items Exclusions, une par micro-carte.
 */
function tfp_panel_exclusions( $titre, $intro, array $items ) {
	if ( ! $titre || ! $items ) {
		return;
	}
	?>
	<div class="tfp-panel--dark">
		<h2><?php echo esc_html( $titre ); ?></h2>
		<?php if ( $intro ) : ?>
			<p class="tfp-panel__intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
		<ul class="tfp-tile-grid--dark">
			<?php foreach ( $items as $item ) : ?>
				<li><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}

/**
 * Carte tarifaire marine : « À partir de … HT/h » et son renvoi vers la page tarifs.
 *
 * Le montant n'est jamais écrit ici : il vient de includes/site-options.php, source unique du
 * tarif (CLAUDE.md §5.3 — grille régionale identique partout).
 */
function tfp_price_card() {
	$site = tfp_site_data();
	?>
	<div class="tfp-price-card">
		<span class="tfp-price-card__label">À partir de</span>
		<span class="tfp-price-card__value"><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h</span>
		<a class="tfp-price-card__link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Détail des tarifs →</a>
	</div>
	<?php
}

/**
 * Carte de réponse directe : le paragraphe qui répond à la question de la page, en tête de contenu.
 *
 * @param string $texte     Réponse directe.
 * @param string $maillage  Phrase de maillage interne déjà transformée en HTML, facultative.
 */
function tfp_answer_card( $texte, $maillage_html = '' ) {
	if ( ! $texte ) {
		return;
	}
	?>
	<div class="tfp-answer-card">
		<span class="tfp-answer-card__label">Réponse directe</span>
		<p class="tfp-answer-card__text"><?php echo esc_html( $texte ); ?></p>
	</div>
	<?php if ( $maillage_html ) : ?>
		<p class="tfp-maillage"><?php echo wp_kses_post( $maillage_html ); ?></p>
	<?php endif; ?>
	<?php
}

/**
 * Carte de note : encadré clair de fin de section (limites de périmètre, précision).
 *
 * @param string $texte Contenu de la note.
 * @param string $titre Intertitre facultatif.
 */
function tfp_note_card( $texte, $titre = '' ) {
	if ( ! $texte ) {
		return;
	}
	?>
	<div class="tfp-note-card">
		<?php if ( $titre ) : ?>
			<h3><?php echo esc_html( $titre ); ?></h3>
		<?php endif; ?>
		<?php // Le texte est un paragraphe, pas un nœud texte nu : un nœud nu n'est ni un bloc de
			// contenu pour un lecteur d'écran, ni un bloc relevé par les outils de comparaison. ?>
		<p><?php echo esc_html( $texte ); ?></p>
	</div>
	<?php
}

/**
 * Cartes de renvoi : une pile de liens encadrés, avec leur flèche.
 *
 * Une entrée sans URL réelle n'est pas rendue en lien mort : son libellé reste du texte, dans la
 * même carte (CLAUDE.md §8).
 *
 * @param array $liens Liste de `array( 'texte' => …, 'url' => … )`.
 */
function tfp_link_cards( array $liens ) {
	$liens = array_filter( $liens, static function ( $l ) {
		return ! empty( $l['texte'] );
	} );
	if ( ! $liens ) {
		return;
	}
	?>
	<div class="tfp-link-cards">
		<?php
		foreach ( $liens as $lien ) :
			$libelle = rtrim( $lien['texte'], '→ ' );
			if ( empty( $lien['url'] ) ) :
				?>
				<span class="tfp-link-card"><?php echo esc_html( $libelle ); ?></span>
				<?php
			else :
				?>
				<a class="tfp-link-card" href="<?php echo esc_url( $lien['url'] ); ?>">
					<?php echo esc_html( $libelle ); ?><span class="tfp-link-card__arrow" aria-hidden="true">→</span>
				</a>
				<?php
			endif;
		endforeach;
		?>
	</div>
	<?php
}

/**
 * Liste de chips : communes, secteurs, types de locaux.
 *
 * Rendue en `<ul>` parce que c'est une liste : l'énumération a du sens pour qui n'en voit pas la
 * mise en forme. Une entrée sans URL reste du texte.
 *
 * @param array $items Liste de `array( 'texte' => …, 'url' => … )` ou de chaînes.
 */
function tfp_chip_list( array $items ) {
	if ( ! $items ) {
		return;
	}
	?>
	<ul class="tfp-chip-list">
		<?php
		foreach ( $items as $item ) :
			$texte = is_array( $item ) ? ( $item['texte'] ?? '' ) : (string) $item;
			$url   = is_array( $item ) ? ( $item['url'] ?? '' ) : '';
			if ( ! $texte ) {
				continue;
			}
			?>
			<li>
				<?php if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $texte ); ?></a>
				<?php else : ?>
					<span><?php echo esc_html( $texte ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Slug de visuel correspondant à une carte, d'après le manifeste d'images du thème.
 *
 * La maquette encode ses visuels en base64 et ne porte aucun nom de fichier : la
 * correspondance se fait donc sur la route de la carte, puis sur son intitulé. Une carte sans
 * équivalent au manifeste renvoie une chaîne vide et se rend sans image — jamais avec un
 * fichier deviné, qui donnerait une image cassée en production.
 *
 * @param string $titre Intitulé de la carte.
 * @param string $route Route interne visée par la carte (`#/service/bureaux`…).
 * @return string Slug du manifeste, ou chaîne vide.
 */
function tfp_card_image_slug( $titre, $route ) {
	$manifeste = function_exists( 'tfp_image_manifest' ) ? tfp_image_manifest() : array();
	if ( ! $manifeste ) {
		return '';
	}
	$route = (string) $route;
	if ( preg_match( '~#/service/([a-z-]+)~', $route, $m ) ) {
		foreach ( array( 'service-' . $m[1], 'service-generic' ) as $slug ) {
			if ( isset( $manifeste[ $slug ] ) ) {
				return $slug;
			}
		}
	}
	if ( preg_match( '~#/article/~', $route ) ) {
		foreach ( array( 'article-1', 'article-2', 'article-3' ) as $slug ) {
			if ( isset( $manifeste[ $slug ] ) ) {
				return $slug;
			}
		}
	}
	unset( $titre );
	return '';
}

/**
 * Grille de micro-cartes relevée sur la maquette.
 *
 * C'est le composant qui manquait, et son absence était **structurelle** : le générateur réduisait
 * ces cartes à un simple libellé, la description était perdue à l'extraction, et la carte devenait
 * impossible à reconstituer à l'affichage quel que soit le gabarit. Chaque carte porte désormais
 * son intitulé, sa description, son surtitre, sa pastille, son icône, son image, son lien et le
 * libellé de ce lien.
 *
 * Rien n'est fabriqué au rendu : un champ vide reste vide. Une carte sans URL réelle n'est pas
 * rendue en lien mort — elle reste un bloc de texte (CLAUDE.md §8).
 *
 * @param array $grille {
 *     @type int    $colonnes  Nombre de colonnes relevé sur le prototype (1 à 6).
 *     @type string $theme     `clair` ou `sombre`.
 *     @type string $variante  `texte`, `lien` ou `image`.
 *     @type array  $items     Cartes, dans l'ordre de la maquette.
 * }
 */
function tfp_card_grid( array $grille ) {
	$items = $grille['items'] ?? array();
	if ( ! $items ) {
		return;
	}
	$colonnes = max( 1, min( 6, (int) ( $grille['colonnes'] ?? 1 ) ) );
	$theme    = 'sombre' === ( $grille['theme'] ?? 'clair' ) ? ' tfp-card-grid--dark' : '';
	$variante = preg_replace( '/[^a-z]/', '', (string) ( $grille['variante'] ?? 'texte' ) );

	/*
	 * Géométrie relevée sur le prototype, passée en **variables CSS** plutôt qu'en styles en dur.
	 *
	 * Le rembourrage d'une carte va de 14 à 26 px selon la bande, l'écart de 8 à 16, le rayon de 10
	 * à 18 : poser une valeur moyenne partout rendait les pages plus compactes que la maquette, et
	 * en poser une par page aurait produit du style en ligne page par page, impossible à
	 * administrer. Les variables gardent le composant unique et sa géométrie fidèle.
	 *
	 * Les valeurs sont filtrées : seuls chiffres, unités et espaces passent, jamais une chaîne
	 * arbitraire venue de la base.
	 */
	$px       = static function ( $v ) {
		$v = preg_replace( '/[^0-9a-z%. ]/i', '', (string) $v );
		return trim( $v );
	};
	$vars     = array();
	$mesures = array(
		'padding'         => '--tfp-tuile-padding',
		'gap'             => '--tfp-tuile-gap',
		'rayon'           => '--tfp-tuile-rayon',
		'filet'           => '--tfp-tuile-filet',
		'titre_taille'    => '--tfp-tuile-titre',
		'titre_interligne' => '--tfp-tuile-titre-lh',
		'desc_taille'     => '--tfp-tuile-desc',
		'desc_interligne' => '--tfp-tuile-desc-lh',
		'desc_marge'      => '--tfp-tuile-desc-mt',
	);
	foreach ( $mesures as $cle => $var ) {
		$valeur = $px( $grille[ $cle ] ?? '' );
		if ( '' !== $valeur ) {
			$vars[] = $var . ':' . $valeur;
		}
	}
	// Fond relevé sur la carte du prototype. Il ne se déduit pas du thème : deux grilles claires
	// d'une même page peuvent être l'une blanche et l'autre sur #F4F7F8, et la nuance se voit.
	if ( preg_match( '/^rgba?\([0-9, .]+\)$/', (string) ( $grille['fond'] ?? '' ) ) ) {
		$vars[] = '--tfp-tuile-fond:' . $grille['fond'];
	}
	$style = $vars ? ' style="' . esc_attr( implode( ';', $vars ) ) . '"' : '';
	?>
	<?php
	/*
	 * Une grille qui contient au moins une carte provisoire l'annonce, une fois, au-dessus d'elle.
	 *
	 * Sauf si la carte porte sa propre mention (`note`) : une grille de coordonnées dont seule la
	 * ligne « horaires » est provisoire ne doit pas préfixer le téléphone et l'adresse d'un
	 * avertissement qui ne les concerne pas. La mention est alors rendue dans la carte elle-même.
	 */
	$provisoires = array_filter( $items, static function ( $i ) {
		return ! empty( $i['provisoire'] ) && empty( $i['note'] );
	} );
	if ( $provisoires && function_exists( 'tfp_provisional_notice' ) ) {
		tfp_provisional_notice();
	}
	?>
	<ul class="tfp-card-grid tfp-card-grid--<?php echo (int) $colonnes; ?><?php echo esc_attr( $theme ); ?>"<?php echo $style; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
		<?php
		foreach ( $items as $item ) :
			$item = wp_parse_args(
				$item,
				array(
					'titre'        => '',
					'titre_tag'    => '',
					'description'  => '',
					'lignes'       => array(),
					'badge'        => '',
					'surtitre'     => '',
					'icone'        => '',
					'image'        => '',
					'route'        => '',
					'libelle_lien' => '',
					'aria'         => '',
					'span'         => '',
					'provisoire'   => false,
					'note'         => '',
				)
			);
			if ( '' === $item['titre'] && '' === $item['description'] ) {
				continue;
			}
			$url      = $item['route'] ? tfp_route_to_url( $item['route'] ) : '';
			$balise   = $url ? 'a' : 'div';
			$attributs = $url ? ' href="' . esc_url( $url ) . '"' : '';
			if ( $item['aria'] ) {
				$attributs .= ' aria-label="' . esc_attr( $item['aria'] ) . '"';
			}
			?>
			<li<?php echo ! empty( $item['provisoire'] ) ? ' data-tfp-provisional="1"' : ''; ?>>
				<<?php echo $balise; ?> class="tfp-card-tile tfp-card-tile--<?php echo esc_attr( $variante ); ?>"<?php echo $attributs; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php
					/*
					 * Visuel de la carte. Le slug vient du manifeste d'images du thème, jamais d'un
					 * nom de fichier deviné : la maquette encode ses visuels en base64 et n'a pas de
					 * noms. Une carte dont le visuel n'a pas d'équivalent au manifeste se rend sans
					 * image plutôt qu'avec une image cassée.
					 */
					$slug_image = $item['image'] ? tfp_card_image_slug( $item['titre'], $item['route'] ) : '';
					if ( $slug_image ) {
						echo '<span class="tfp-card-tile__media">';
						tfp_picture( $slug_image, array( 'sizes' => '(max-width: 819px) 100vw, 383px', 'alt' => '' ) );
						echo '</span>';
					}
					?>
					<?php if ( $item['icone'] ) : ?>
						<span class="tfp-card-tile__icon" aria-hidden="true"><?php echo esc_html( $item['icone'] ); ?></span>
					<?php endif; ?>
					<?php
					/*
					 * Contenu de flux, et non une suite de `span` : la description est un paragraphe.
					 * Un `span` n'est ni un bloc de contenu pour un lecteur d'écran, ni un bloc relevé
					 * par les outils de comparaison — huit citations de /avis-clients/ étaient
					 * présentes à l'écran et comptées manquantes. `<a>` peut contenir du flux en
					 * HTML5 ; `<span>` ne le peut pas, d'où le `<div>` intermédiaire.
					 */
					?>
					<div class="tfp-card-tile__body">
						<?php if ( $item['surtitre'] ) : ?>
							<span class="tfp-card-tile__eyebrow"><?php echo esc_html( $item['surtitre'] ); ?></span>
						<?php endif; ?>
						<?php
						// Intertitre ou simple libellé : la balise est celle relevée sur la maquette.
						$balise_titre = 'h3' === $item['titre_tag'] ? 'h3' : 'strong';
						if ( $item['titre'] ) :
							?>
							<<?php echo $balise_titre; ?> class="tfp-card-tile__title">
								<?php echo esc_html( $item['titre'] ); ?>
								<?php if ( $item['badge'] ) : ?>
									<span class="tfp-card-tile__badge"><?php echo esc_html( $item['badge'] ); ?></span>
								<?php endif; ?>
							</<?php echo $balise_titre; ?>>
						<?php endif; ?>
						<?php if ( $item['description'] ) : ?>
							<p class="tfp-card-tile__desc"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>
						<?php foreach ( (array) $item['lignes'] as $ligne ) : ?>
							<p class="tfp-card-tile__line"><?php echo esc_html( $ligne ); ?></p>
						<?php endforeach; ?>
						<?php if ( $item['libelle_lien'] && $url ) : ?>
							<span class="tfp-card-tile__more"><?php echo esc_html( $item['libelle_lien'] ); ?><span aria-hidden="true"> →</span></span>
						<?php endif; ?>
					</div>
				</<?php echo $balise; ?>>
				<?php
				// Mention propre à cette carte — placée dans la carte, hors du lien éventuel.
				if ( $item['note'] && function_exists( 'tfp_provisional_notice' ) ) {
					tfp_provisional_notice( $item['note'] );
				}
				?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Regroupe les blocs consécutifs d'une bande qui appartiennent à une même rangée.
 *
 * Une bande de la maquette mêle couramment un bloc d'introduction sur toute la largeur et une
 * rangée de cartes. Appliquer la grille à la bande entière rangeait l'introduction dans la
 * première colonne, à côté des cartes — sur la page pilier, cela déformait cinq bandes sur dix-sept.
 *
 * Chaque bloc porte un indicateur `grille`, relevé sur le rendu du prototype par
 * tools/generate-pages.mjs : vrai si son titre partage son ordonnée avec un autre titre. Cette
 * fonction ne fait que découper la suite de blocs en séquences homogènes.
 *
 * @param array $blocs Blocs de la bande, dans l'ordre.
 * @return array Liste de séquences, chacune étant une liste de blocs.
 */
function tfp_static_runs( array $blocs ) {
	$sequences = array();
	$courante  = array();
	$etat      = null;

	foreach ( $blocs as $bloc ) {
		$en_rangee = ! empty( $bloc['grille'] );
		if ( null !== $etat && $en_rangee !== $etat ) {
			$sequences[] = $courante;
			$courante    = array();
		}
		$etat       = $en_rangee;
		$courante[] = $bloc;
	}
	if ( $courante ) {
		$sequences[] = $courante;
	}
	return $sequences;
}

/**
 * Traduit une route interne de la maquette (`#/nos-tarifs`) en URL réelle du site.
 *
 * Le prototype est une application à routes `#/` : aucune de ces adresses n'existe côté serveur.
 * Les recopier produirait des liens morts, ce que CLAUDE.md §8 proscrit. Une route sans équivalent
 * connu renvoie une chaîne vide, et l'appelant rend alors son libellé en texte simple.
 *
 * @param string $route
 * @return string URL absolue, ou '' si la route n'a pas d'équivalent.
 */
function tfp_route_to_url( $route ) {
	$route = preg_replace( '#[?].*$#', '', (string) $route );
	$route = rtrim( $route, '/' );

	static $fixes = array(
		'#/'                             => '/',
		'#/nettoyage-professionnel'      => '/nettoyage-professionnel/',
		'#/nos-prestations'              => '/prestations/',
		'#/nos-tarifs'                   => '/tarifs/',
		'#/zones-intervention'           => '/zones-intervention/',
		'#/bourgogne-franche-comte'      => '/zones-intervention/bourgogne-franche-comte/',
		'#/pourquoi-top-famille-pro'     => '/pourquoi-nous/',
		'#/notre-fonctionnement'         => '/notre-fonctionnement/',
		'#/avis-clients'                 => '/avis-clients/',
		'#/a-propos'                     => '/a-propos/',
		'#/recrutement'                  => '/recrutement/',
		'#/conseils'                     => '/conseils/',
		'#/demande-de-devis'             => '/demande-de-devis/',
		'#/contact'                      => '/contact/',
		'#/plan-du-site'                 => '/plan-du-site/',
		'#/mentions-legales'             => '/mentions-legales/',
		'#/politique-de-confidentialite' => '/politique-de-confidentialite/',
		'#/gestion-des-cookies'          => '/gestion-des-cookies/',
	);

	if ( isset( $fixes[ $route ] ) ) {
		return home_url( $fixes[ $route ] );
	}

	// Routes de contenu : le permalien réel est demandé à WordPress, pas reconstruit à la main —
	// une zone déplacée dans la hiérarchie garde ainsi un lien juste.
	if ( preg_match( '#^\#/service/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'prestation', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( preg_match( '#^\#/(?:ville|departement)/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'zone', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( preg_match( '#^\#/article/(.+)$#', $route, $m ) ) {
		$posts = get_posts( array( 'post_type' => 'post', 'name' => $m[1], 'numberposts' => 1 ) );
		return ! empty( $posts ) ? get_permalink( $posts[0] ) : '';
	}
	if ( 0 === strpos( $route, 'tel:' ) || 0 === strpos( $route, 'mailto:' ) || 0 === strpos( $route, 'http' ) ) {
		return $route;
	}
	return '';
}

/**
 * Tableau des exemples de budget, tel que la maquette le compose dans l'article sur le coût.
 *
 * Rendu par le code court `[tfp_budget_table]` placé dans le corps de l'article : le contenu
 * reste éditable en administration, et les montants ne peuvent pas s'y désynchroniser du tarif —
 * ils viennent de `tfp_budget_examples_table()`, la même source que la page Tarifs.
 *
 * Le générateur d'articles aplatissait le corps en titres, paragraphes et listes : le tableau de
 * la maquette disparaissait purement et simplement, ne laissant que son intertitre et sa phrase
 * d'introduction. Trois lignes de budget manquaient sur la page qui traite précisément du budget.
 *
 * Balisage sémantique : `<table>` avec `<caption>`, `<thead>` et en-têtes `scope="col"`. Une
 * suite de paragraphes aurait la même apparence mais perdrait la relation ligne ↔ colonne, que
 * les lecteurs d'écran restituent.
 */
function tfp_budget_table_shortcode() {
	$lignes = tfp_budget_examples_table();
	if ( ! $lignes ) {
		return '';
	}

	// Intitulé du besoin, relevé sur la maquette, associé au volume horaire correspondant.
	$besoins = array(
		8  => 'Petit bureau ou cabinet',
		12 => 'Bureaux réguliers',
		20 => 'Besoin plus important',
	);

	$html  = '<div class="tfp-table-wrap"><table class="tfp-budget-table">';
	$html .= '<caption class="tfp-budget-table__caption">Exemples de budget mensuel, calculés à '
		. esc_html( tfp_format_price( tfp_site_data()['price_unique'] ) ) . ' HT/h plus '
		. esc_html( tfp_format_price( tfp_site_data()['price_gestion'] ) ) . ' HT de gestion.</caption>';
	$html .= '<thead><tr>'
		. '<th scope="col">Besoin</th>'
		. '<th scope="col">Volume</th>'
		. '<th scope="col">Budget mensuel</th>'
		. '<th scope="col">1<sup>er</sup> mois (+ ' . esc_html( tfp_format_price( tfp_site_data()['price_setup'] ) ) . ' HT)</th>'
		. '</tr></thead><tbody>';

	foreach ( $lignes as $ligne ) {
		$html .= sprintf(
			'<tr><th scope="row">%s</th><td>%d h / mois</td><td>%s HT</td><td>%s HT</td></tr>',
			esc_html( $besoins[ $ligne['hours'] ] ?? 'Volume sur mesure' ),
			(int) $ligne['hours'],
			esc_html( tfp_format_price( $ligne['monthly'] ) ),
			esc_html( tfp_format_price( $ligne['first_month'] ) )
		);
	}

	$html .= '</tbody></table></div>';
	return $html;
}
add_shortcode( 'tfp_budget_table', 'tfp_budget_table_shortcode' );
