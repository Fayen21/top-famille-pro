<?php
/**
 * Champs structurés des articles (type `post` natif, catégorie « Conseils » — CLAUDE.md §3).
 *
 * Choix volontaire de ne PAS utiliser ACF ici non plus (cohérent avec includes/reassurance-settings.php
 * et includes/customizer.php) : un article doit rester éditable même sans ACF. Boîte de méta
 * native (`add_meta_box`) : réponse directe + jusqu'à 8 questions de FAQ, chacune facultative.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const TFP_ARTICLE_FAQ_MAX = 8;

function tfp_register_article_meta_box() {
	add_meta_box(
		'tfp_article_structure',
		'Structure de l\'article (réponse directe + FAQ)',
		'tfp_render_article_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tfp_register_article_meta_box' );

function tfp_render_article_meta_box( $post ) {
	wp_nonce_field( 'tfp_article_meta_save', 'tfp_article_meta_nonce' );

	$direct       = get_post_meta( $post->ID, '_tfp_direct_answer', true );
	$seo_title    = get_post_meta( $post->ID, '_tfp_seo_title', true );
	$related_ids  = array_map( 'intval', get_post_meta( $post->ID, '_tfp_related_prestation' ) );
	$prestations  = get_posts( array( 'post_type' => 'prestation', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
	?>
	<p>
		<label for="tfp-direct-answer"><strong>Réponse directe</strong> (paragraphe d'ouverture, avant le sommaire)</label><br>
		<textarea id="tfp-direct-answer" name="tfp_direct_answer" rows="3" style="width:100%"><?php echo esc_textarea( $direct ); ?></textarea>
	</p>
	<p>
		<label for="tfp-seo-title"><strong>Title SEO</strong> (facultatif — laisser vide pour utiliser le titre de l'article + « | <?php echo esc_html( tfp_site_data()['brand_name'] ); ?> ». À renseigner uniquement si cette valeur par défaut dépasse ~65 caractères.)</label><br>
		<input type="text" id="tfp-seo-title" name="tfp_seo_title" value="<?php echo esc_attr( $seo_title ); ?>" style="width:100%">
	</p>
	<p>
		<strong>Prestations liées</strong> (maillage — affichées en bas d'article et depuis la page de chaque prestation cochée)<br>
		<?php foreach ( $prestations as $prestation ) : ?>
			<label style="display:inline-block;margin:4px 12px 4px 0">
				<input type="checkbox" name="tfp_related_prestations[]" value="<?php echo (int) $prestation->ID; ?>" <?php checked( in_array( (int) $prestation->ID, $related_ids, true ) ); ?>>
				<?php echo esc_html( get_the_title( $prestation ) ); ?>
			</label>
		<?php endforeach; ?>
	</p>
	<hr>
	<p><strong>FAQ</strong> — jusqu'à <?php echo (int) TFP_ARTICLE_FAQ_MAX; ?> questions. Un bloc dont la question est vide n'est ni affiché ni inclus dans le FAQPage JSON-LD (CLAUDE.md §8).</p>
	<?php for ( $i = 1; $i <= TFP_ARTICLE_FAQ_MAX; $i++ ) : ?>
		<?php
		$q = get_post_meta( $post->ID, '_tfp_faq_' . $i . '_q', true );
		$a = get_post_meta( $post->ID, '_tfp_faq_' . $i . '_a', true );
		?>
		<p>
			<label for="tfp-faq-<?php echo $i; ?>-q">Question <?php echo $i; ?></label><br>
			<input type="text" id="tfp-faq-<?php echo $i; ?>-q" name="tfp_faq_<?php echo $i; ?>_q" value="<?php echo esc_attr( $q ); ?>" style="width:100%">
			<textarea name="tfp_faq_<?php echo $i; ?>_a" rows="2" style="width:100%;margin-top:4px" placeholder="Réponse"><?php echo esc_textarea( $a ); ?></textarea>
		</p>
	<?php endfor; ?>
	<?php
}

function tfp_save_article_meta( $post_id ) {
	if ( ! isset( $_POST['tfp_article_meta_nonce'] ) || ! wp_verify_nonce( $_POST['tfp_article_meta_nonce'], 'tfp_article_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['tfp_direct_answer'] ) ) {
		update_post_meta( $post_id, '_tfp_direct_answer', sanitize_textarea_field( wp_unslash( $_POST['tfp_direct_answer'] ) ) );
	}

	if ( isset( $_POST['tfp_seo_title'] ) ) {
		update_post_meta( $post_id, '_tfp_seo_title', sanitize_text_field( wp_unslash( $_POST['tfp_seo_title'] ) ) );
	}

	delete_post_meta( $post_id, '_tfp_related_prestation' );
	if ( isset( $_POST['tfp_related_prestations'] ) && is_array( $_POST['tfp_related_prestations'] ) ) {
		foreach ( $_POST['tfp_related_prestations'] as $prestation_id ) {
			$prestation_id = (int) $prestation_id;
			if ( $prestation_id > 0 && 'prestation' === get_post_type( $prestation_id ) ) {
				add_post_meta( $post_id, '_tfp_related_prestation', $prestation_id );
			}
		}
	}

	for ( $i = 1; $i <= TFP_ARTICLE_FAQ_MAX; $i++ ) {
		if ( isset( $_POST[ 'tfp_faq_' . $i . '_q' ] ) ) {
			update_post_meta( $post_id, '_tfp_faq_' . $i . '_q', sanitize_text_field( wp_unslash( $_POST[ 'tfp_faq_' . $i . '_q' ] ) ) );
		}
		if ( isset( $_POST[ 'tfp_faq_' . $i . '_a' ] ) ) {
			update_post_meta( $post_id, '_tfp_faq_' . $i . '_a', sanitize_textarea_field( wp_unslash( $_POST[ 'tfp_faq_' . $i . '_a' ] ) ) );
		}
	}
}
add_action( 'save_post_post', 'tfp_save_article_meta' );

/**
 * Retourne les blocs de FAQ non vides d'un article.
 *
 * @param int $post_id
 * @return array Liste de ['question' => string, 'reponse' => string].
 */
function tfp_get_article_faq( $post_id ) {
	$items = array();
	for ( $i = 1; $i <= TFP_ARTICLE_FAQ_MAX; $i++ ) {
		$q = get_post_meta( $post_id, '_tfp_faq_' . $i . '_q', true );
		if ( ! empty( $q ) ) {
			$items[] = array(
				'question' => $q,
				'reponse'  => get_post_meta( $post_id, '_tfp_faq_' . $i . '_a', true ),
			);
		}
	}
	return $items;
}

/**
 * Un article est considéré "réellement construit" (donc indexable) s'il a au moins une réponse
 * directe renseignée — un post créé par erreur ou laissé vide reste discrètement en noindex.
 *
 * @param int $post_id
 * @return bool
 */
function tfp_article_is_complete( $post_id ) {
	return (bool) get_post_meta( $post_id, '_tfp_direct_answer', true );
}

/**
 * Prestations liées à un article (maillage CLAUDE.md/phase 4 « articles ↔ prestations »).
 *
 * @param int $article_id
 * @return WP_Post[]
 */
function tfp_get_article_related_prestations( $article_id ) {
	$ids = array_map( 'intval', get_post_meta( $article_id, '_tfp_related_prestation' ) );
	if ( empty( $ids ) ) {
		return array();
	}
	return get_posts( array( 'post_type' => 'prestation', 'post__in' => $ids, 'orderby' => 'post__in', 'numberposts' => -1 ) );
}

/**
 * Articles liés à une prestation — sens inverse de tfp_get_article_related_prestations().
 * `_tfp_related_prestation` est stocké en plusieurs lignes de postmeta non uniques (une par
 * prestation cochée), ce qui rend cette requête directe sans jointure manuelle.
 *
 * @param int $prestation_id
 * @return WP_Post[]
 */
function tfp_get_prestation_related_articles( $prestation_id ) {
	return get_posts(
		array(
			'post_type'      => 'post',
			'category_name'  => 'conseils',
			'numberposts'    => -1,
			'meta_key'       => '_tfp_related_prestation',
			'meta_value'     => (int) $prestation_id,
		)
	);
}

/**
 * Visuel d'illustration d'un article, par ordre de préférence : image mise en avant WordPress,
 * puis le visuel du pipeline correspondant à son rang de publication (article-1/2/3, mêmes
 * fichiers que la maquette). Aucun visuel ne prétend montrer un lieu ou une personne réels.
 *
 * @param int $post_id
 * @return string Slug du manifeste d'images.
 */
function tfp_article_image_slug( $post_id ) {
	$map = array(
		'frequence-bureaux'            => 'article-1',
		'cout-nettoyage-bureaux'       => 'article-2',
		'cahier-des-charges-nettoyage' => 'article-3',
	);
	$slug = get_post_field( 'post_name', $post_id );
	return $map[ $slug ] ?? 'article-1';
}
