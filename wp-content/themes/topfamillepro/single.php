<?php
/**
 * Gabarit des articles (type `post` natif, catégorie « Conseils » — CLAUDE.md §3).
 *
 * Le corps de l'article (sections, listes) reste dans post_content, édité normalement dans
 * l'éditeur WordPress — c'est justement l'intérêt du type natif plutôt qu'un CPT dédié. Seuls la
 * réponse directe et la FAQ passent par les champs structurés natifs (includes/articles-meta.php,
 * FAQPage nécessitant des paires question/réponse propres, pas du texte libre).
 *
 * Robots dynamique : un article reste en noindex,follow tant qu'aucune réponse directe n'est
 * renseignée (tfp_article_is_complete()) — évite d'indexer un post créé par erreur ou vide.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_queried_object_id();
$site    = tfp_site_data();

$direct       = get_post_meta( $post_id, '_tfp_direct_answer', true );
$faq          = tfp_get_article_faq( $post_id );
$robots       = tfp_article_is_complete( $post_id ) ? 'index,follow' : 'noindex,follow';
$seo_title    = get_post_meta( $post_id, '_tfp_seo_title', true );
$related_prestations = tfp_get_article_related_prestations( $post_id );

$categories = get_the_category( $post_id );
$cat_name   = ! empty( $categories ) ? $categories[0]->name : 'Conseils';

$schema = array(
	array(
		'@type'         => 'Article',
		'@id'           => get_permalink( $post_id ) . '#article',
		'headline'      => wp_strip_all_tags( get_the_title( $post_id ) ),
		'description'   => get_the_excerpt( $post_id ),
		'image'         => has_post_thumbnail( $post_id ) ? get_the_post_thumbnail_url( $post_id, 'full' ) : trailingslashit( $site['origin'] ) . ltrim( $site['logo_path'], '/' ),
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified'  => get_the_modified_date( 'c', $post_id ),
		'author'        => array( '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ?: $site['manager'] ),
		'publisher'     => array( '@id' => trailingslashit( $site['origin'] ) . '#organisation' ),
		'mainEntityOfPage' => array( '@id' => get_permalink( $post_id ) . '#webpage' ),
	),
);

if ( ! empty( $faq ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => get_permalink( $post_id ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array(
					'@type'          => 'Question',
					'name'           => $item['question'],
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['reponse'] ),
				);
			},
			$faq
		),
	);
}

tfp_seo(
	array(
		'title'       => $seo_title ?: ( wp_strip_all_tags( get_the_title( $post_id ) ) . ' | ' . $site['brand_name'] ),
		'description' => get_the_excerpt( $post_id ),
		'type'        => 'article',
		'robots'      => $robots,
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Conseils', 'url' => home_url( '/conseils/' ) ),
			array( 'label' => wp_strip_all_tags( get_the_title( $post_id ) ), 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();
?>
<div class="tfp-container tfp-container--narrow">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<article class="tfp-container tfp-container--narrow tfp-section--tight">
	<span style="font-size:13px;font-weight:600;color:var(--color-primary)"><?php echo esc_html( $cat_name ); ?></span>
	<h1 style="margin-top:8px"><?php the_title(); ?></h1>
	<p style="margin-top:8px;font-size:13.5px;color:var(--color-text-tertiary)">
		Publié le <?php echo esc_html( tfp_format_date_fr( $post_id ) ); ?>
		<?php if ( get_the_modified_date( 'Ymd', $post_id ) !== get_the_date( 'Ymd', $post_id ) ) : ?>
			· mis à jour le <?php echo esc_html( tfp_format_date_fr( (int) get_post_modified_time( 'U', false, $post_id ), false ) ); ?>
		<?php endif; ?>
	</p>

	<?php if ( $direct ) : ?>
		<div style="margin-top:22px;display:flex;gap:16px;align-items:flex-start">
			<span aria-hidden="true" style="flex-shrink:0;width:4px;align-self:stretch;background:var(--color-primary);border-radius:3px"></span>
			<p style="font-size:19px;color:var(--color-text);line-height:1.6"><?php echo esc_html( $direct ); ?></p>
		</div>
	<?php endif; ?>

	<div style="margin-top:32px;font-size:16.5px;color:var(--color-text-secondary);line-height:1.75" class="tfp-article-body">
		<?php the_content(); ?>
	</div>
</article>

<?php if ( ! empty( $faq ) ) : ?>
<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-container--narrow">
		<h2>Questions fréquentes</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faq as $item ) : ?>
				<details class="tfp-card" style="margin-bottom:10px">
					<summary style="font-weight:600;font-size:17px;cursor:pointer"><?php echo esc_html( $item['question'] ); ?></summary>
					<p style="margin-top:12px;color:var(--color-text-secondary)"><?php echo esc_html( $item['reponse'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $related_prestations ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<h2 style="font-size:19px">Prestations liées</h2>
		<div class="tfp-flex" style="margin-top:14px">
			<?php foreach ( $related_prestations as $prestation ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prestation ) ); ?>" class="tfp-chip"><?php echo esc_html( get_the_title( $prestation ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un projet d'entretien pour vos locaux ?</h2>
		<p>Devis gratuit sous 24 h, sans engagement.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ ' . $site['phone'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>
<?php
get_footer();
