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

	$direct = get_post_meta( $post->ID, '_tfp_direct_answer', true );
	?>
	<p>
		<label for="tfp-direct-answer"><strong>Réponse directe</strong> (paragraphe d'ouverture, avant le sommaire)</label><br>
		<textarea id="tfp-direct-answer" name="tfp_direct_answer" rows="3" style="width:100%"><?php echo esc_textarea( $direct ); ?></textarea>
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
