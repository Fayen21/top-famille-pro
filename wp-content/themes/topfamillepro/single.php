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
// La maquette étiquette chaque article par son thème (« Bureaux », « Tarifs », « Organisation »),
// plus précis que la catégorie WordPress unique « Conseils ». Repli sur la catégorie réelle.
$cat_name = get_post_meta( $post_id, '_tfp_categorie_label', true )
	?: ( ! empty( $categories ) ? $categories[0]->name : 'Conseils' );

$image_alt     = get_post_meta( $post_id, '_tfp_image_alt', true );
$erreurs_titre = get_post_meta( $post_id, '_tfp_erreurs_titre', true );
$erreurs       = tfp_get_lines( get_post_meta( $post_id, '_tfp_erreurs', true ) );
$maillage      = get_post_meta( $post_id, '_tfp_maillage', true );
$cta_titre     = get_post_meta( $post_id, '_tfp_cta_titre', true ) ?: "Un projet d'entretien pour vos locaux ?";
$cta_texte     = get_post_meta( $post_id, '_tfp_cta_texte', true ) ?: 'Devis gratuit sous 24 h, sans engagement.';

// Sommaire déduit des H2 du corps : il ne peut donc pas se désynchroniser du contenu, alors qu'un
// sommaire stocké à part se périme au premier ajout de section.
$sommaire = array();
if ( preg_match_all( '#<h2[^>]*>(.*?)</h2>#is', get_post_field( 'post_content', $post_id ), $m ) ) {
	$sommaire = array_map( 'wp_strip_all_tags', $m[1] );
}
if ( $erreurs_titre ) {
	$sommaire[] = $erreurs_titre;
}
if ( ! empty( $faq ) ) {
	$sommaire[] = 'Questions fréquentes';
}

$schema = array(
	array(
		'@type'         => 'Article',
		'@id'           => get_permalink( $post_id ) . '#article',
		'headline'      => wp_strip_all_tags( get_the_title( $post_id ) ),
		'description'   => get_the_excerpt( $post_id ),
		/*
		 * Image de l'article, jamais le logo du site.
		 *
		 * Sans image mise en avant, le schéma retombait sur le logo : les trois articles déclaraient
		 * donc à Google un visuel qui n'illustre pas leur contenu, ce que les recommandations sur les
		 * résultats enrichis proscrivent — l'image d'un `Article` doit représenter l'article. Le
		 * visuel réellement affiché en tête vient du pipeline d'images du thème ; c'est lui qu'on
		 * déclare, dans sa plus grande variante.
		 */
		'image'         => has_post_thumbnail( $post_id )
			? get_the_post_thumbnail_url( $post_id, 'full' )
			: tfp_article_schema_image( $post_id ),
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

<?php
/*
 * Les blocs de l'article sont des sections de premier niveau, comme dans la maquette, et non
 * imbriquées dans un `<article>` unique : c'est l'élément `<article>` du corps de texte qui porte
 * la sémantique, l'en-tête, le sommaire et l'encadré d'erreurs étant du mobilier de page.
 */
?>
<header class="tfp-container tfp-container--narrow tfp-section--tight">
		<span class="tfp-article__category"><?php echo esc_html( $cat_name ); ?></span>
		<h1 style="margin-top:8px"><?php the_title(); ?></h1>
		<p class="tfp-article__meta">
			<span><?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?></span>
			<span aria-hidden="true">·</span>
			<span>Publié le <?php echo esc_html( tfp_format_date_fr( $post_id ) ); ?></span>
			<?php if ( get_the_modified_date( 'Ymd', $post_id ) !== get_the_date( 'Ymd', $post_id ) ) : ?>
				<span aria-hidden="true">·</span>
				<span>Mis à jour le <?php echo esc_html( tfp_format_date_fr( (int) get_post_modified_time( 'U', false, $post_id ), false ) ); ?></span>
			<?php endif; ?>
		</p>
	<div class="tfp-article__cover">
		<?php tfp_picture( tfp_article_image_slug( $post_id ), array( 'sizes' => '(max-width: 900px) 92vw, 820px', 'lcp' => true, 'alt' => $image_alt ?: null ) ); ?>
	</div>
</header>

<?php if ( $direct ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<div class="tfp-direct-answer">
			<p class="tfp-direct-answer__text"><?php echo esc_html( $direct ); ?></p>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $sommaire ) ) : ?>
<section class="tfp-container tfp-container--narrow tfp-section--tight">
	<nav class="tfp-toc" aria-label="Sommaire de l'article">
		<strong>Sommaire</strong>
		<ul>
			<?php foreach ( $sommaire as $entree ) : ?>
				<li><?php echo esc_html( $entree ); ?></li>
			<?php endforeach; ?>
		</ul>
	</nav>
</section>
<?php endif; ?>

<article class="tfp-container tfp-container--narrow tfp-section--tight tfp-article-body">
	<?php the_content(); ?>
</article>

<?php if ( ! empty( $erreurs ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<h2><?php echo esc_html( $erreurs_titre ); ?></h2>
		<ul class="tfp-list-excluded">
			<?php foreach ( $erreurs as $erreur ) : ?>
				<li><?php echo esc_html( $erreur ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $faq ) ) : ?>
<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-container--narrow">
		<h2>Questions fréquentes</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faq as $item ) : ?>
				<details class="tfp-card tfp-faq-item">
					<summary><?php echo esc_html( $item['question'] ); ?></summary>
					<p><?php echo esc_html( $item['reponse'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $maillage || ! empty( $related_prestations ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<?php if ( $maillage ) : ?>
			<p class="tfp-maillage">
				<?php
				echo wp_kses_post(
					tfp_link_phrases(
						$maillage,
						array(
							'nettoyage professionnel' => home_url( '/nettoyage-professionnel/' ),
							'nos tarifs'              => home_url( '/tarifs/' ),
						)
					)
				);
				?>
			</p>
		<?php endif; ?>
		<?php if ( ! empty( $related_prestations ) ) : ?>
			<div class="tfp-chip-row tfp-chip-row--10" style="margin-top:14px">
				<?php foreach ( $related_prestations as $prestation ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prestation ) ); ?>" class="tfp-chip"><?php echo esc_html( tfp_get_field( 'nav_label', $prestation->ID ) ?: get_the_title( $prestation ) ); ?></a>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-chip">Nos tarifs</a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2><?php echo esc_html( $cta_titre ); ?></h2>
		<p><?php echo esc_html( $cta_texte ); ?></p>
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
