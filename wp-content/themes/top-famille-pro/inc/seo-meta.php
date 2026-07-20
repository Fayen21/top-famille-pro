<?php
/**
 * SEO natif, sans plugin : titre et méta-description administrables par
 * page, canonical automatique, Open Graph (image sociale = image mise en
 * avant de la page), sitemap natif de WordPress (wp-sitemap.xml, actif par
 * défaut depuis la 5.5, aucun code supplémentaire nécessaire).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tfp_add_seo_meta_box() {
	add_meta_box( 'tfp_seo', __( 'Référencement (SEO)', 'top-famille-pro' ), 'tfp_render_seo_meta_box', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'tfp_add_seo_meta_box' );

function tfp_render_seo_meta_box( $post ) {
	wp_nonce_field( 'tfp_save_seo', 'tfp_seo_nonce' );
	$titre       = get_post_meta( $post->ID, '_tfp_meta_title', true );
	$description = get_post_meta( $post->ID, '_tfp_meta_description', true );
	?>
	<p>
		<label for="tfp_meta_title"><strong><?php esc_html_e( 'Title (balise <title>)', 'top-famille-pro' ); ?></strong></label><br>
		<input type="text" id="tfp_meta_title" name="tfp_meta_title" value="<?php echo esc_attr( $titre ); ?>" class="large-text" maxlength="70">
		<span class="description"><?php esc_html_e( 'Laisser vide pour utiliser le titre de la page. Environ 60-70 caractères.', 'top-famille-pro' ); ?></span>
	</p>
	<p>
		<label for="tfp_meta_description"><strong><?php esc_html_e( 'Méta-description', 'top-famille-pro' ); ?></strong></label><br>
		<textarea id="tfp_meta_description" name="tfp_meta_description" class="large-text" rows="3" maxlength="160"><?php echo esc_textarea( $description ); ?></textarea>
		<span class="description"><?php esc_html_e( 'Environ 150-160 caractères. Affichée dans les résultats de recherche.', 'top-famille-pro' ); ?></span>
	</p>
	<p class="description">
		<?php esc_html_e( 'Le canonical est généré automatiquement. L\'image sociale (Open Graph) utilise l\'image mise en avant de la page.', 'top-famille-pro' ); ?>
	</p>
	<?php
}

function tfp_save_seo_meta( $post_id ) {
	if ( ! isset( $_POST['tfp_seo_nonce'] ) || ! wp_verify_nonce( $_POST['tfp_seo_nonce'], 'tfp_save_seo' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['tfp_meta_title'] ) ) {
		update_post_meta( $post_id, '_tfp_meta_title', sanitize_text_field( wp_unslash( $_POST['tfp_meta_title'] ) ) );
	}
	if ( isset( $_POST['tfp_meta_description'] ) ) {
		update_post_meta( $post_id, '_tfp_meta_description', sanitize_textarea_field( wp_unslash( $_POST['tfp_meta_description'] ) ) );
	}
}
add_action( 'save_post_page', 'tfp_save_seo_meta' );

function tfp_meta_title_actuel() {
	if ( is_singular() ) {
		$titre = get_post_meta( get_the_ID(), '_tfp_meta_title', true );
		if ( $titre ) {
			return $titre;
		}
	}
	return null;
}

function tfp_filtrer_titre_document( $parts ) {
	$titre = tfp_meta_title_actuel();
	if ( $titre ) {
		$parts['title'] = $titre;
	}
	return $parts;
}
add_filter( 'document_title_parts', 'tfp_filtrer_titre_document' );

function tfp_meta_description_actuelle() {
	if ( is_singular() ) {
		$description = get_post_meta( get_the_ID(), '_tfp_meta_description', true );
		if ( $description ) {
			return $description;
		}
		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			return wp_strip_all_tags( $excerpt );
		}
	}
	return '';
}

function tfp_sortie_seo_head() {
	$description = tfp_meta_description_actuelle();
	$canonical   = is_front_page() ? home_url( '/' ) : get_permalink();
	$titre_og    = tfp_meta_title_actuel() ?: wp_get_document_title();

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $canonical ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}

	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( 'Top-Famille Pro' ) );
	printf( '<meta property="og:type" content="%s">' . "\n", 'website' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $titre_og ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $canonical ) {
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	}
	if ( is_singular() && has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'tfp-card' );
		if ( $image ) {
			printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image[0] ) );
		}
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( DATE_W3C ) ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'tfp_sortie_seo_head', 1 );

function tfp_afficher_date_maj() {
	if ( ! is_singular() ) {
		return;
	}
	printf(
		'<p class="tfp-date-maj">%s <time datetime="%s">%s</time></p>',
		esc_html__( 'Dernière mise à jour :', 'top-famille-pro' ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);
}
