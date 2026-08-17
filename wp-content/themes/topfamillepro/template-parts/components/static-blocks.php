<?php
/**
 * Composant commun de rendu des pages statiques narratives.
 *
 * Ces pages sont des pages WordPress classiques (CLAUDE.md §3), sans champs ACF : leur contenu vit
 * dans une option par page, produite par tools/generate-pages.mjs depuis la maquette Claude
 * Design. Un seul composant les rend toutes, ce qui évite dix gabarits qui divergeraient à la
 * première correction, et garde l'ordre des sections figé.
 *
 * Les routes internes de la maquette (`#/…`) ne sont jamais servies telles quelles : elles sont
 * traduites en URL WordPress réelles à l'affichage. Une route sans équivalent n'est pas rendue en
 * lien mort — son libellé reste du texte (CLAUDE.md §8).
 *
 * @var array $args {
 *     @type string $key   Clé de page (`pourquoi-nous`, `a-propos`…).
 *     @type array  $skip  Index de sections à ne pas rendre (déjà couvertes par le gabarit).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$data = tfp_static_page_data( $args['key'] ?? '' );
if ( empty( $data['sections'] ) ) {
	return;
}
$skip = $args['skip'] ?? array();

foreach ( $data['sections'] as $section ) {
	if ( in_array( $section['index'], $skip, true ) ) {
		continue;
	}
	$classes = array( 'tfp-section--tight' );
	if ( 'turquoise' === $section['fond'] ) {
		$classes[] = 'tfp-section--turquoise';
	} elseif ( 'navy' === $section['fond'] ) {
		$classes[] = 'tfp-section--navy';
	} elseif ( 'primary' === $section['fond'] ) {
		$classes[] = 'tfp-section--primary';
	} elseif ( 'alt' === $section['fond'] ) {
		$classes[] = 'tfp-section--alt';
	} elseif ( 'glacier' === $section['fond'] ) {
		$classes[] = 'tfp-section--glacier';
	} elseif ( 'blanc' === $section['fond'] ) {
		// La maquette alterne bandes blanches et bandes sur le fond de page. Le fond blanc était
		// relevé mais jamais rendu : l'alternance disparaissait, et avec elle la lecture par bandes.
		$classes[] = 'tfp-section--blanc';
	}

	/*
	 * Rembourrage vertical relevé sur la bande du prototype. Le thème en posait 52 px partout ; la
	 * maquette en pose 84 sur la plupart de ses bandes, 72 ou 48 sur d'autres. Ce n'est pas un
	 * rembourrage de compensation destiné à atteindre un ratio : c'est la valeur mesurée, passée en
	 * variable pour rester administrable et ne pas produire de style en ligne page par page.
	 */
	/*
	 * Le filtre employé ici effaçait les parenthèses et les virgules : `clamp(44px, 6vw, 80px)`
	 * devenait « clamp44px 6vw 80px », valeur invalide que le navigateur jette. Le relevé pouvait
	 * donc être juste sans jamais atteindre la page. `tfp_longueur_css()` — le filtre strict posé en
	 * G07 — admet les fonctions de longueur et refuse la valeur entière au moindre caractère hors
	 * jeu, ce qui est la bonne garantie sans être destructif.
	 */
	$pad = array();
	foreach ( array( 'padding_haut' => '--tfp-bande-haut', 'padding_bas' => '--tfp-bande-bas' ) as $cle => $var ) {
		$valeur = tfp_longueur_css( $section[ $cle ] ?? '' );
		if ( '' !== $valeur ) {
			$pad[] = $var . ':' . $valeur;
		}
	}
	/*
	 * Largeur de la colonne de lecture, relevée sur les paragraphes de la bande du prototype.
	 * Le thème laissait le texte occuper toute la largeur du conteneur : une ligne plus large tient
	 * plus de mots, donc moins de lignes, et chaque paragraphe perdait un tiers de sa hauteur. Les
	 * grilles de cartes ne sont pas concernées — elles gardent toute la largeur.
	 */
	$largeur = (int) ( $section['largeur_texte'] ?? 0 );
	if ( $largeur >= 400 && $largeur <= 1400 ) {
		$pad[] = '--tfp-bande-texte:' . $largeur . 'px';
	}
	/*
	 * Largeur du CONTENEUR de la bande, distincte de la colonne de lecture ci-dessus.
	 *
	 * Le prototype resserre certaines bandes à 900 ou 1040 px quand le thème applique partout son
	 * conteneur de 1260. La colonne de lecture ne peut pas y suppléer : elle borne le texte, pas les
	 * grilles. À 1440 px, une rangée de trois cartes de 264 px dans 900 px devient une rangée de
	 * quatre cartes de 285 px dans 1260, et la bande perd 345 px de haut.
	 *
	 * `--container-max` est la variable que `.tfp-container` lit déjà : la poser sur la bande suffit,
	 * sans règle nouvelle et sans sélecteur par URL.
	 */
	$largeur_conteneur = (int) ( $section['largeur_conteneur'] ?? 0 );
	if ( $largeur_conteneur >= 600 && $largeur_conteneur <= 1400 ) {
		$pad[] = '--container-max:' . $largeur_conteneur . 'px';
	}
	$pad_style = $pad ? ' style="' . esc_attr( implode( ';', $pad ) ) . '"' : '';
	/*
	 * Nombre de colonnes : relevé sur le rendu de la maquette par tools/generate-pages.mjs, et non
	 * deviné d'après la longueur des blocs. L'heuristique précédente (« plusieurs blocs courts ⇒
	 * colonnes ») se trompait notamment sur « Qui nous sommes » de /a-propos/, que la maquette
	 * empile sur toute la largeur.
	 *
	 * Le `?:` couvre les contenus produits avant l'ajout du champ : sans valeur relevée, on empile,
	 * ce qui reste lisible — l'inverse ne l'est pas.
	 */
	$colonnes = max( 1, min( 4, (int) ( $section['colonnes'] ?? 1 ) ) );

	/*
	 * Traitement en cartes : relevé lui aussi sur le rendu de la maquette, bande par bande. Le
	 * composant rendait tout en texte nu ; le prototype pose une partie de ces bandes dans des
	 * cartes blanches encadrées. À hauteur voisine, l'écran n'avait pas le même aspect.
	 */
	$carte = is_array( $section['cartes'] ?? null ) ? $section['cartes'] : null;

	/**
	 * Style d'un encadrement relevé : rembourrage et rayon viennent de la carte réelle.
	 *
	 * Ils vont de 20 à 32 px et de 12 à 18 px selon la bande ; en poser 32 partout allongeait
	 * /nettoyage-professionnel/ de 15 %.
	 */
	$carte_style_de = static function ( $c ) {
		if ( ! is_array( $c ) ) {
			return '';
		}
		$parts = array();
		foreach ( array( 'padding' => '--tfp-carte-padding', 'rayon' => '--tfp-carte-rayon', 'marge_bas' => '--tfp-carte-marge-bas' ) as $cle => $var ) {
			$valeur = tfp_longueur_css( $c[ $cle ] ?? '' );
			if ( '' !== $valeur ) {
				$parts[] = $var . ':' . $valeur;
			}
		}
		return implode( ';', $parts );
	};

	/*
	 * La grille s'applique par rangée, pas à toute la bande : le prototype mêle couramment un bloc
	 * d'introduction sur toute la largeur et une rangée de cartes. Posée sur la bande entière, la
	 * grille rangeait l'introduction dans la première colonne, à côté des cartes.
	 */
	$sequences = tfp_static_runs( $section['blocs'] );
	?>
	<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo $pad_style; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
		<div class="tfp-container">
		<?php
		foreach ( $sequences as $sequence ) :
			/*
			 * Le nombre de colonnes est celui de **cette rangée**, relevé sur le rendu, et non le
			 * maximum de la bande : une bande porte couramment une rangée de quatre cartes puis une
			 * rangée de trois, et prendre le maximum rangeait la seconde sur quatre colonnes dont une
			 * restait vide. `$colonnes` sert de repli pour les contenus produits avant ce relevé.
			 */
			$colonnes_rangee = max( 1, min( 4, (int) ( $sequence[0]['colonnes'] ?? $colonnes ) ) );
			$en_grille       = $colonnes_rangee > 1 && count( $sequence ) > 1 && ! empty( $sequence[0]['grille'] );

			/*
			 * Repli **intrinsèque** de la rangée, relevé sur le prototype.
			 *
			 * La maquette ne replie pas ses rangées sur des seuils de fenêtre : chaque colonne
			 * porte `flex: 1 1 340px` et la rangée se replie quand la place manque. Le seuil réel
			 * varie donc de 600 à 900 px d'une bande à l'autre, et aucune valeur globale ne les
			 * reproduit toutes. À 768 px, la maquette donnait 707 px de large à ses bandes de
			 * texte quand le thème en donnait 333.
			 */
			/*
			 * Base de colonne : la MOYENNE des bases déclarées par les colonnes de la rangée, et non
			 * celle de la première.
			 *
			 * Le prototype compose ses rangées en flex : chaque colonne porte sa propre base, et la
			 * rangée se replie quand la SOMME des bases plus les écarts dépasse la place disponible.
			 * Le thème la rend en grille `auto-fit`, qui se replie quand N × base plus les écarts la
			 * dépasse. Les deux points de bascule coïncident exactement quand la base de la grille
			 * vaut la moyenne des bases du flex — et seulement alors.
			 *
			 * Sur la bande « Ce que nous attendons » de /recrutement/, les deux colonnes déclarent
			 * 340 et 320 px. Prendre 340 faisait replier la rangée à 768 px (2 × 340 + 30,72 = 710,7
			 * pour 707 disponibles) là où la maquette la tient côte à côte ; la moyenne, 330, la tient
			 * (2 × 330 + 30,72 = 690,7). La largeur des colonnes reste égalisée par la grille — 338
			 * contre 348 et 328 dans la maquette — ce que seule une rangée flex à bases distinctes
			 * reproduirait au pixel.
			 */
			$bases = array();
			foreach ( $sequence as $bloc_rangee ) {
				$base = tfp_longueur_css( $bloc_rangee['colonne_min'] ?? '' );
				if ( '' !== $base && preg_match( '/^([\d.]+)px$/', $base, $m ) ) {
					$bases[] = (float) $m[1];
				}
			}
			$rangee_vars = array();
			if ( $bases ) {
				$rangee_vars[] = '--tfp-rangee-colonne:' . round( array_sum( $bases ) / count( $bases ), 2 ) . 'px';
			} elseif ( '' !== tfp_longueur_css( $sequence[0]['colonne_min'] ?? '' ) ) {
				$rangee_vars[] = '--tfp-rangee-colonne:' . tfp_longueur_css( $sequence[0]['colonne_min'] );
			}
			if ( '' !== tfp_longueur_css( $sequence[0]['rangee_gap'] ?? '' ) ) {
				$rangee_vars[] = '--tfp-rangee-gap:' . tfp_longueur_css( $sequence[0]['rangee_gap'] );
			}
			$rangee_style = $en_grille && $rangee_vars ? ' style="' . esc_attr( implode( ';', $rangee_vars ) ) . '"' : '';
			?>
			<div class="<?php echo $en_grille ? esc_attr( 'tfp-static-grid tfp-static-grid--' . (int) $colonnes_rangee ) : 'tfp-static-run'; ?>"<?php echo $rangee_style; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<?php
			foreach ( $sequence as $bloc ) :
				// Les clés absentes d'un bloc généré avant l'ajout d'un type de contenu ne doivent pas
				// faire tomber le rendu : on complète systématiquement.
				$bloc = wp_parse_args(
					$bloc,
					array( 'titre' => '', 'niveau' => 'h2', 'textes' => array(), 'liste' => array(), 'liens' => array(), 'noms' => array(), 'citations' => array(), 'faq' => array(), 'etapes' => array() )
				);
				// Un bloc qui porte des citations est un bloc de témoignages repris de la maquette : il
				// est marqué provisoire, comme les cartes témoignage, pour rester repérable en une
				// requête et pour être exclu du contrôle « aucune donnée fictive » — il est destiné à
				// être remplacé par de vrais avis (CLAUDE.md §5.5).
				$provisoire = ! empty( $bloc['citations'] );
				?>
					<?php
					/*
					 * L'encadrement se lit **sur le bloc**, pas sur la bande.
					 *
					 * La maquette encadre couramment un seul bloc au milieu d'une bande de texte
					 * suivi. Une décision prise à la majorité pour toute la bande ne sait pas
					 * l'exprimer : elle encadrait tout, ou rien. Elle encadrait notamment des
					 * bandes dont le contenu est déjà une grille de cartes — une carte dans une
					 * carte, absente de la référence, qui retirait 38 px de largeur utile et
					 * faisait replier chaque description sur une ligne de plus.
					 *
					 * La valeur de bande ne sert plus que de repli, pour un contenu produit avant
					 * l'introduction du relevé par bloc.
					 */
					$carte_bloc  = array_key_exists( 'carte', $bloc ) ? ( is_array( $bloc['carte'] ) ? $bloc['carte'] : null ) : $carte;
					$carte_style = $carte_style_de( $carte_bloc );
					?>
					<div class="tfp-static-block<?php echo $carte_bloc ? ' tfp-static-block--carte' : ''; ?>"<?php echo $carte_style ? ' style="' . esc_attr( $carte_style ) . '"' : ''; ?><?php echo $provisoire ? ' data-tfp-provisional="1"' : ''; ?>>
						<?php
						// Le visiteur ne lit pas le code source : un attribut ne l'informe de rien. La
						// mention est donc visible, dans le flux, au plus près du contenu concerné.
						if ( $provisoire ) {
							tfp_provisional_notice();
						}
						?>
						<?php if ( $bloc['titre'] ) : ?>
							<?php printf( '<%1$s>%2$s</%1$s>', esc_attr( $bloc['niveau'] ), esc_html( $bloc['titre'] ) ); ?>
						<?php endif; ?>

						<?php
						/*
						 * Rendu de la **séquence hétérogène ordonnée** de la bande.
						 *
						 * Le composant rendait auparavant un tiroir après l'autre — tous les paragraphes,
						 * puis toutes les listes, puis toutes les pastilles — ce qui effaçait l'ordre
						 * voulu par la maquette : une note écrite entre deux grilles ressortait après
						 * elles. La séquence porte chaque enfant avec son type, dans son ordre de
						 * lecture, et chacun garde l'archétype que le prototype lui donne.
						 *
						 * Il n'y a **plus de repli** vers la pastille : un fragment n'est rendu en chip
						 * que si la maquette le rend en chip, ce qui est relevé à l'extraction.
						 */
						$sequence_bloc = is_array( $bloc['sequence'] ?? null ) ? $bloc['sequence'] : array();
						if ( ! $sequence_bloc ) {
							// Repli de compatibilité pour un contenu produit avant l'introduction de la
							// séquence : on reconstitue l'ordre le plus probable, sans jamais inventer de
							// pastille.
							foreach ( $bloc['textes'] as $t ) {
								$sequence_bloc[] = array( 'type' => 'paragraph', 'texte' => $t );
							}
							foreach ( $bloc['cartes'] as $g ) {
								$sequence_bloc[] = array_merge( array( 'type' => 'grid' ), $g );
							}
							if ( ! empty( $bloc['liste'] ) ) {
								$sequence_bloc[] = array( 'type' => 'list', 'items' => $bloc['liste'] );
							}
						}

						$chips_en_attente = array();
						/*
						 * RANGÉES DE COMMANDES — G26 §4 et §5.
						 *
						 * La maquette pose ses appels à l'action en rangées de boutons côte à côte ; le
						 * composant les rendait en lignes de texte pleine largeur empilées. Sur
						 * /a-propos/ cela transformait six commandes en une liste, sur /recrutement/
						 * cela remplaçait le parcours de candidature par des liens génériques.
						 *
						 * Les liens consécutifs qui partagent la rangée relevée sont donc regroupés et
						 * rendus avec l'archétype mesuré sur le prototype. Un lien sans rangée ni
						 * archétype relevé garde sa ligne de texte : rien n'est promu bouton sans relevé.
						 */
						/*
						 * Sur une bande sombre, la hiérarchie s'inverse — le principal passe en blanc
						 * plein, le secondaire en filet blanc translucide. Le design system porte déjà
						 * ces deux variantes (`--on-primary`, `--on-dark`) ; on les choisit ici plutôt
						 * que d'écrire une règle contextuelle qui les dupliquerait. Sans cela, un
						 * bouton bleu sur bande marine devient illisible : c'est un défaut de
						 * contraste avant d'être un défaut de fidélité (CLAUDE.md §8).
						 */
						$bande_sombre     = in_array( $section['fond'] ?? '', array( 'primary', 'navy' ), true );
						$liens_en_attente = array();
						$vider_liens      = static function () use ( &$liens_en_attente, $bande_sombre ) {
							if ( ! $liens_en_attente ) {
								return;
							}
							$liens            = $liens_en_attente;
							$liens_en_attente = array();
							echo '<div class="tfp-action-row tfp-action-row--statique">';
							foreach ( $liens as $l ) {
								$principal = 'primaire' === $l['archetype'];
								if ( $bande_sombre ) {
									$variante = $principal ? 'on-primary' : 'on-dark';
								} else {
									$variante = $principal ? 'primary' : 'secondary';
								}
								tfp_button(
									array(
										'label'   => $l['label'],
										'href'    => $l['href'],
										'variant' => $variante,
										'mesures' => $l['mesures'],
									)
								);
							}
							echo '</div>';
						};
						/** Vide la file de pastilles consécutives en une seule rangée, comme la maquette. */
						$vider_chips = static function () use ( &$chips_en_attente ) {
							if ( ! $chips_en_attente ) {
								return;
							}
							tfp_chip_list(
								array_map(
									static function ( $t ) {
										return array( 'texte' => $t );
									},
									$chips_en_attente
								)
							);
							$chips_en_attente = array();
						};

						$rangee_courante = null;
						foreach ( $sequence_bloc as $enfant ) {
							$type = $enfant['type'] ?? '';
							if ( 'chip' !== $type ) {
								$vider_chips();
							}
							// La rangée se referme dès qu'un contenu d'un autre type s'intercale, ou dès
							// qu'un lien appartient à une autre rangée relevée.
							if ( 'link' !== $type || ( $enfant['rangee'] ?? '' ) !== $rangee_courante ) {
								$vider_liens();
								$rangee_courante = 'link' === $type ? ( $enfant['rangee'] ?? '' ) : null;
							}
							switch ( $type ) {
								case 'paragraph':
									printf( '<p class="tfp-prose">%s</p>', esc_html( $enfant['texte'] ) );
									break;

								case 'note':
									// Phrase de transition, précision, conclusion : du texte courant, et
									// non une pastille. C'est exactement ce que produisait le repli
									// supprimé, et cela inventait des cartes absentes du prototype.
									printf( '<p class="tfp-static-note">%s</p>', esc_html( $enfant['texte'] ) );
									break;

								case 'grid':
									tfp_card_grid( $enfant );
									break;

								case 'list':
									echo '<ul class="tfp-list-plain">';
									foreach ( (array) ( $enfant['items'] ?? array() ) as $item ) {
										printf( '<li>%s</li>', esc_html( $item ) );
									}
									echo '</ul>';
									break;

								case 'quote':
									printf( '<blockquote class="tfp-quote">%s</blockquote>', esc_html( $enfant['texte'] ) );
									break;

								case 'link':
									$route = (string) ( $enfant['route'] ?? '' );
									/*
									 * Un `tel:` ou un `mailto:` relevé sur la maquette est réécrit avec
									 * les coordonnées RÉELLES du site (PROJECT_INPUTS.md §1), jamais
									 * avec celles figées dans le prototype : le numéro y est certes le
									 * bon aujourd'hui, mais le jour où il change, une valeur recopiée
									 * dans une option de contenu ne suivrait pas.
									 */
									$contact = function_exists( 'tfp_site_data' ) ? tfp_site_data() : array();
									if ( 0 === strpos( $route, 'tel:' ) ) {
										$url = 'tel:' . ( $contact['phone_href'] ?? '' );
									} elseif ( 0 === strpos( $route, 'mailto:' ) ) {
										$url = 'mailto:' . ( $contact['email'] ?? '' );
									} else {
										$url = tfp_route_to_url( $route );
									}

									$archetype = (string) ( $enfant['archetype'] ?? 'ligne' );
									if ( $url && 'ligne' !== $archetype ) {
										// Bouton relevé : il rejoint sa rangée, vidée par le tour suivant.
										$liens_en_attente[] = array(
											// Libellé conservé tel quel, flèche comprise : la maquette écrit
										// « Pourquoi nous choisir → » dans la pastille, et « Page
										// contact » sans flèche. La distinction est la sienne.
										'label'     => $enfant['texte'],
											'href'      => $url,
											'archetype' => $archetype,
											'mesures'   => array(
												'pad_v'   => $enfant['pad_v'] ?? '',
												'pad_h'   => $enfant['pad_h'] ?? '',
												'taille'  => $enfant['taille'] ?? '',
												'graisse' => $enfant['graisse'] ?? 0,
												'hauteur' => $enfant['hauteur'] ?? '',
											),
										);
										break;
									}

									if ( $url ) {
										printf(
											'<a class="tfp-link-row" href="%s">%s<span aria-hidden="true">→</span></a>',
											esc_url( $url ),
											esc_html( rtrim( $enfant['texte'], '→ ' ) )
										);
									} else {
										// Aucun lien mort publié : le libellé reste du texte (CLAUDE.md §8).
										printf( '<span class="tfp-link-row tfp-link-row--static">%s</span>', esc_html( $enfant['texte'] ) );
									}
									break;

								case 'chip':
									$chips_en_attente[] = $enfant['texte'];
									break;

								case 'step':
									printf(
										'<ol class="tfp-steps"><li class="tfp-step"><span class="tfp-step__num" aria-hidden="true">%s</span>'
											. '<div class="tfp-step__body"><strong class="tfp-step__titre">%s</strong><p class="tfp-prose">%s</p></div></li></ol>',
										esc_html( $enfant['numero'] ),
										esc_html( $enfant['titre'] ),
										esc_html( $enfant['texte'] )
									);
									break;

								case 'faq':
									printf(
										'<details class="tfp-card tfp-faq-item"><summary>%s</summary><p>%s</p></details>',
										esc_html( $enfant['question'] ),
										esc_html( $enfant['reponse'] )
									);
									break;
							}
						}
						$vider_chips();
						$vider_liens();
						?>
					</div>
			<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</section>
	<?php
}
