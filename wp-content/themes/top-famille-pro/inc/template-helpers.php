<?php
/**
 * Aides de gabarit communes : navigation accessible, fil d'Ariane, boutons,
 * téléphone, FAQ. Centralisées ici pour éviter toute duplication de
 * balisage entre les pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Walker de menu accessible : le lien du parent reste un <a> qui navigue
 * normalement, un <button> séparé (aria-expanded/aria-controls) ouvre le
 * sous-menu. Un contexte ('desktop'|'mobile') évite les doublons d'ID
 * quand le même menu est rendu deux fois sur la page.
 */
class TFP_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $contexte;
	private $parent_id_courant = 0;

	public function __construct( $contexte = 'desktop' ) {
		$this->contexte = $contexte;
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$a_des_enfants = in_array( 'menu-item-has-children', $classes, true );
		$est_courant  = in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true );

		$this->parent_id_courant = $item->ID;

		$li_classes = 'tfp-nav__item';
		if ( $a_des_enfants ) {
			$li_classes .= ' tfp-nav__item--sous-menu';
		}
		if ( $est_courant ) {
			$li_classes .= ' is-courant';
		}

		$output .= '<li class="' . esc_attr( $li_classes ) . '">';
		$output .= '<a class="tfp-nav__lien" href="' . esc_url( $item->url ) . '"' . ( $est_courant ? ' aria-current="page"' : '' ) . '>' . esc_html( $item->title ) . '</a>';

		if ( $a_des_enfants ) {
			$submenu_id = 'tfp-submenu-' . $this->contexte . '-' . $item->ID;
			$output    .= sprintf(
				'<button type="button" class="tfp-submenu-toggle" aria-expanded="false" aria-controls="%1$s"><span class="screen-reader-text">%2$s</span><svg class="tfp-chevron" aria-hidden="true" viewBox="0 0 16 16" width="16" height="16"><path d="M4 6l4 4 4-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
				esc_attr( $submenu_id ),
				esc_html(
					sprintf(
						/* translators: %s: nom de l'élément de menu */
						__( 'Ouvrir le sous-menu %s', 'top-famille-pro' ),
						$item->title
					)
				)
			);
		}
	}

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$submenu_id = 'tfp-submenu-' . $this->contexte . '-' . $this->parent_id_courant;
		$output    .= '<ul class="tfp-submenu" id="' . esc_attr( $submenu_id ) . '" hidden>';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

function tfp_menu( $contexte = 'desktop', $classe_liste = '' ) {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '<ul class="tfp-nav__liste ' . esc_attr( $classe_liste ) . '">%3$s</ul>',
			'walker'         => new TFP_Walker_Nav_Menu( $contexte ),
			'fallback_cb'    => false,
		)
	);
}

function tfp_telephone_href() {
	$tel = tfp_get_donnee( 'telephone' );
	return $tel ? 'tel:' . $tel : '';
}

function tfp_telephone_affichage() {
	$affichage = tfp_get_donnee( 'telephone_affichage' );
	return $affichage ?: tfp_get_donnee( 'telephone' );
}

/**
 * Toujours un <a> (même stylé comme un bouton) : ce sont des liens de
 * navigation (page, tel:, mailto:), jamais des actions JavaScript.
 */
function tfp_bouton( $texte, $url, $variante = 'primaire', $classe_extra = '' ) {
	if ( ! $url ) {
		return '';
	}
	return sprintf(
		'<a class="tfp-btn tfp-btn--%1$s %2$s" href="%3$s">%4$s</a>',
		esc_attr( $variante ),
		esc_attr( $classe_extra ),
		esc_url( $url ),
		esc_html( $texte )
	);
}

function tfp_bouton_devis( $texte = '', $variante = 'primaire', $classe_extra = '' ) {
	$texte = $texte ?: __( 'Demander un devis', 'top-famille-pro' );
	echo tfp_bouton( $texte, tfp_devis_page_url(), $variante, $classe_extra ); // phpcs:ignore
}

function tfp_bouton_appeler( $texte = '', $variante = 'secondaire', $classe_extra = '' ) {
	$texte = $texte ?: sprintf( __( 'Appeler le %s', 'top-famille-pro' ), tfp_telephone_affichage() );
	echo tfp_bouton( $texte, tfp_telephone_href(), $variante, $classe_extra ); // phpcs:ignore
}

/**
 * Fil d'Ariane visible + données structurées associées (BreadcrumbList).
 * @param array $items ['name' => ..., 'url' => ...], sans l'élément final
 *                      s'il correspond à la page courante (ajouté automatiquement).
 */
function tfp_breadcrumb( array $items ) {
	$items[] = array(
		'name' => wp_strip_all_tags( get_the_title() ?: wp_get_document_title() ),
		'url'  => get_permalink() ?: home_url( '/' ),
	);

	tfp_ajouter_schema( tfp_schema_breadcrumb( $items ) );

	echo '<nav class="tfp-breadcrumb" aria-label="' . esc_attr__( 'Fil d\'Ariane', 'top-famille-pro' ) . '"><ol>';
	$dernier = count( $items ) - 1;
	foreach ( $items as $i => $item ) {
		if ( $i === $dernier ) {
			echo '<li aria-current="page">' . esc_html( $item['name'] ) . '</li>';
		} else {
			echo '<li><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['name'] ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * Bloc FAQ accessible (accordéon) + FAQPage uniquement si des questions
 * sont réellement affichées.
 */
function tfp_faq_bloc( array $faq_items, $titre = '' ) {
	if ( empty( $faq_items ) ) {
		return;
	}
	$titre = $titre ?: __( 'Questions fréquentes', 'top-famille-pro' );

	$schema = tfp_schema_faqpage( $faq_items );
	if ( $schema ) {
		tfp_ajouter_schema( $schema );
	}

	echo '<section class="tfp-faq" aria-labelledby="tfp-faq-titre">';
	echo '<h2 id="tfp-faq-titre">' . esc_html( $titre ) . '</h2>';
	foreach ( $faq_items as $i => $item ) {
		$panel_id  = 'tfp-faq-panel-' . $i . '-' . sanitize_title( $titre );
		$bouton_id = 'tfp-faq-question-' . $i . '-' . sanitize_title( $titre );
		echo '<div class="tfp-faq__item">';
		echo '<h3 class="tfp-faq__entete"><button type="button" class="tfp-faq__question" id="' . esc_attr( $bouton_id ) . '" aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '">';
		echo '<span>' . esc_html( $item['question'] ) . '</span>';
		echo '<svg class="tfp-chevron" aria-hidden="true" viewBox="0 0 16 16" width="16" height="16"><path d="M4 6l4 4 4-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		echo '</button></h3>';
		echo '<div class="tfp-faq__reponse" id="' . esc_attr( $panel_id ) . '" role="region" aria-labelledby="' . esc_attr( $bouton_id ) . '" hidden>' . wp_kses_post( $item['reponse'] ) . '</div>';
		echo '</div>';
	}
	echo '</section>';
}

function tfp_image_hero( $champ_id, $alt, $classe = '' ) {
	if ( $champ_id && wp_attachment_is_image( $champ_id ) ) {
		echo wp_get_attachment_image( $champ_id, 'tfp-hero', false, array( 'alt' => esc_attr( $alt ), 'class' => esc_attr( $classe ), 'loading' => 'eager', 'fetchpriority' => 'high' ) ); // phpcs:ignore
		return;
	}
	printf(
		'<div class="tfp-image-placeholder %1$s" role="img" aria-label="%2$s"><span>%3$s</span></div>',
		esc_attr( $classe ),
		esc_attr( $alt ),
		esc_html__( 'Photo à venir', 'top-famille-pro' )
	);
}
