<?php
/**
 * Page statique « Conseils » (/conseils/) — gabarit dédié (CLAUDE.md §3), index de la catégorie
 * « Conseils » (type post natif).
 *
 * Reproduit les 7 blocs de la route `#/conseils` de la maquette : hero, filtres par thème, article
 * mis en avant, les autres articles, « Passer du conseil à votre situation », relance.
 *
 * Les filtres par thème sont rendus tels quels mais sans comportement : la maquette les présente
 * comme des repères visuels, et une catégorie ne portant qu'un article ne justifie pas une page
 * d'archive supplémentaire. Ils ne sont donc pas des liens — jamais un `href="#"` (CLAUDE.md §8).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
// La maquette signe les articles du prénom seul (« Audrey »), pas de la raison sociale ni du nom
// complet de la gérante.
$prenom = explode( ' ', $site['manager'] )[0];

$articles = get_posts(
	array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'category_name'  => 'conseils',
		'orderby'        => 'date',
		'order'          => 'ASC',
	)
);

$une    = ! empty( $articles ) ? array_shift( $articles ) : null;
$themes = array();
foreach ( array_merge( $une ? array( $une ) : array(), $articles ) as $article ) {
	$label = get_post_meta( $article->ID, '_tfp_categorie_label', true );
	if ( $label && ! in_array( $label, $themes, true ) ) {
		$themes[] = $label;
	}
}

/** Rend une carte d'article : visuel, thème, titre, accroche, signature. */
$carte = function ( $article, $mise_en_avant = false ) use ( $prenom ) {
	$label = get_post_meta( $article->ID, '_tfp_categorie_label', true ) ?: 'Conseils';
	$alt   = get_post_meta( $article->ID, '_tfp_image_alt', true );
	?>
	<a class="tfp-article-card<?php echo $mise_en_avant ? ' tfp-article-card--feature' : ''; ?>" href="<?php echo esc_url( get_permalink( $article ) ); ?>">
		<div class="tfp-article-card__media">
			<?php
			tfp_picture(
				tfp_article_image_slug( $article->ID ),
				array(
					'sizes' => $mise_en_avant ? '(max-width: 900px) 92vw, 590px' : '(max-width: 900px) 92vw, 380px',
					'alt'   => $alt ?: null,
					'lcp'   => $mise_en_avant,
				)
			);
			?>
		</div>
		<div class="tfp-article-card__body">
			<span class="tfp-article__category"><?php echo esc_html( $label ); ?></span>
			<h3><?php echo esc_html( get_the_title( $article ) ); ?></h3>
			<p><?php echo esc_html( get_the_excerpt( $article ) ); ?></p>
			<span class="tfp-article-card__meta">
				<?php echo esc_html( $prenom ); ?> · <?php echo esc_html( tfp_format_date_fr( $article->ID ) ); ?>
			</span>
			<span class="tfp-link-arrow">Lire l'article →</span>
		</div>
	</a>
	<?php
};

$passerelles = array(
	array( home_url( '/prestations/bureaux/' ), 'Nettoyage de bureaux', 'Fréquences, confidentialité, horaires décalés.' ),
	array( home_url( '/tarifs/' ), 'Nos tarifs', tfp_format_price( $site['price_unique'] ) . ' HT/h et exemples de budgets mensuels.' ),
	array( home_url( '/notre-fonctionnement/' ), 'Notre fonctionnement', 'Du premier appel au suivi dans la durée.' ),
	array( home_url( '/zones-intervention/bourgogne-franche-comte/' ), 'Votre secteur', 'Huit départements, dix villes principales.' ),
);

tfp_seo(
	array(
		'title'       => 'Conseils & repères sur le nettoyage professionnel | ' . $site['brand_name'],
		'description' => "Repères concrets sur le nettoyage professionnel de bureaux et de locaux : fréquence de passage, budget réaliste, cahier des charges. Écrits par {$prenom}.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Conseils', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Conseils &amp; repères</h1>
	<p class="tfp-section__lede">Des repères concrets et vérifiables sur le nettoyage professionnel de bureaux et de locaux, écrits par <?php echo esc_html( $prenom ); ?> à partir de nos échanges quotidiens avec des dirigeants, commerçants et gestionnaires de <?php echo esc_html( $site['address_region'] ); ?>.</p>
	<p class="tfp-section__lede">Vous y trouverez de quoi cadrer une fréquence de passage, estimer un budget réaliste ou rédiger un cahier des charges — sans jargon commercial, avec des exemples chiffrés et des repères que nous appliquons nous-mêmes au quotidien.</p>
</section>

<?php if ( ! empty( $themes ) ) : ?>
<section class="tfp-container tfp-section--tight">
	<ul class="tfp-theme-list">
		<li class="tfp-theme-list__item is-current">Toutes les catégories</li>
		<?php foreach ( $themes as $theme ) : ?>
			<li class="tfp-theme-list__item"><?php echo esc_html( $theme ); ?></li>
		<?php endforeach; ?>
	</ul>
</section>
<?php endif; ?>

<?php if ( $une ) : ?>
<section class="tfp-container tfp-section--tight">
	<?php $carte( $une, true ); ?>
</section>
<?php endif; ?>

<?php if ( ! empty( $articles ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Les autres articles</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:24px">
			<?php foreach ( $articles as $article ) : ?>
				<?php $carte( $article ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Passer du conseil à votre situation</h2>
		<p class="tfp-section__lede">Ces repères valent pour la plupart des locaux. Pour les appliquer aux vôtres, partez de la prestation ou du secteur qui vous concerne.</p>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:24px">
			<?php foreach ( $passerelles as $lien ) : ?>
				<a class="tfp-card tfp-card--link" href="<?php echo esc_url( $lien[0] ); ?>">
					<h3><?php echo esc_html( $lien[1] ); ?></h3>
					<p><?php echo esc_html( $lien[2] ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section--turquoise tfp-section--tight">
	<div class="tfp-container tfp-prefooter__inner">
		<p class="tfp-prefooter__text">
			<strong>Un besoin précis pour vos locaux ?</strong>
			Nos conseils donnent des repères ; votre devis reste toujours personnalisé.
		</p>
		<?php tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) ); ?>
	</div>
</section>

<?php get_footer(); ?>
