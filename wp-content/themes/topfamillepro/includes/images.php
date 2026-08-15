<?php
/**
 * Pipeline d'images responsive — AVIF/WebP/JPEG avec fallback, srcset, dimensions explicites.
 *
 * Les fichiers sont générés par `npm run images` (build/optimize-images.mjs) à partir des
 * photos provisoires de assets/photos/ (racine du dépôt) et décrits dans
 * assets/dist/images/manifest.json : { slug: { alt, lcp, width, height, variants: { avif, webp, jpg } } }.
 *
 * Un template ne référence jamais un chemin de fichier en dur : il appelle tfp_picture( 'slug', […] ),
 * ce qui permet de remplacer une photo provisoire par la photo réelle (même slug, nouveau
 * fichier source) sans toucher à un seul gabarit — cf. brief phase 1 §5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Charge et met en cache le manifeste d'images généré par le build.
 *
 * @return array
 */
function tfp_image_manifest() {
	static $manifest = null;

	if ( null === $manifest ) {
		$path = TFP_THEME_DIR . '/assets/dist/images/manifest.json';
		if ( file_exists( $path ) ) {
			$json     = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			$manifest = json_decode( $json, true );
		}
		if ( ! is_array( $manifest ) ) {
			$manifest = array();
		}
	}

	return $manifest;
}

/**
 * Construit une chaîne srcset à partir d'une liste de variantes {width, file}.
 *
 * @param array  $variants
 * @param string $base_url
 * @return string
 */
function tfp_build_srcset( $variants, $base_url ) {
	$parts = array();
	foreach ( $variants as $variant ) {
		$parts[] = esc_url( $base_url . $variant['file'] ) . ' ' . (int) $variant['width'] . 'w';
	}
	return implode( ', ', $parts );
}

/**
 * Affiche une image responsive <picture> (AVIF > WebP > JPEG) pour le slug donné.
 *
 * @param string $slug Identifiant déclaré dans build/optimize-images.mjs.
 * @param array  $args {
 *     @type string $sizes         Attribut sizes du <img>. Défaut : "100vw".
 *     @type string $alt           Remplace l'alt du manifeste si fourni.
 *     @type bool   $lazy          Force le lazy-loading même si le manifeste dit lcp=true.
 *     @type string $class         Classe(s) CSS additionnelle(s) sur <img>.
 *     @type string $img_style     Attribut style additionnel sur <img>.
 * }
 */
function tfp_picture( $slug, $args = array() ) {
	$manifest = tfp_image_manifest();

	if ( empty( $manifest[ $slug ] ) ) {
		if ( WP_DEBUG ) {
			echo '<!-- tfp_picture: slug "' . esc_html( $slug ) . '" absent du manifeste. Lancer `npm run images`. -->';
		}
		return;
	}

	$defaults = array(
		'sizes'     => '100vw',
		'alt'       => null,
		'lazy'      => null,
		'lcp'       => null, // Surcharge entry['lcp'] : un même slug peut être la vignette d'une page et le visuel LCP d'une autre (ex. service-bureaux : carte accueil vs hero de la page prestation).
		'class'     => '',
		'img_style' => '',
	);
	$args = wp_parse_args( $args, $defaults );

	$entry    = $manifest[ $slug ];
	$base_url = TFP_THEME_URI . '/assets/dist/images/';
	$alt      = null !== $args['alt'] ? $args['alt'] : $entry['alt'];
	$is_lcp   = null !== $args['lcp'] ? $args['lcp'] : ! empty( $entry['lcp'] );
	$is_lcp   = $is_lcp && null === $args['lazy'];
	$lazy     = null !== $args['lazy'] ? $args['lazy'] : ! $is_lcp;

	$fallback = end( $entry['variants']['jpg'] );

	echo '<picture>';

	printf(
		'<source type="image/avif" srcset="%s" sizes="%s">',
		tfp_build_srcset( $entry['variants']['avif'], $base_url ),
		esc_attr( $args['sizes'] )
	);
	printf(
		'<source type="image/webp" srcset="%s" sizes="%s">',
		tfp_build_srcset( $entry['variants']['webp'], $base_url ),
		esc_attr( $args['sizes'] )
	);

	printf(
		'<img src="%1$s" srcset="%2$s" sizes="%3$s" width="%4$d" height="%5$d" alt="%6$s" loading="%7$s"%8$s%9$s%10$s>',
		esc_url( $base_url . $fallback['file'] ),
		tfp_build_srcset( $entry['variants']['jpg'], $base_url ),
		esc_attr( $args['sizes'] ),
		(int) $entry['width'],
		(int) $entry['height'],
		esc_attr( $alt ),
		$lazy ? 'lazy' : 'eager',
		$is_lcp ? ' fetchpriority="high"' : '',
		$args['class'] ? ' class="' . esc_attr( $args['class'] ) . '"' : '',
		$args['img_style'] ? ' style="' . esc_attr( $args['img_style'] ) . '"' : ''
	);

	echo '</picture>';
}
