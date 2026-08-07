<?php
/**
 * Page statique « Conseils » (/conseils/) — gabarit dédié (CLAUDE.md §3), index de la catégorie
 * « Conseils » (type post natif).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$articles = get_posts(
	array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'category_name'  => 'conseils',
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

tfp_seo(
	array(
		'title'       => 'Conseils d\'entretien de locaux professionnels | ' . $site['brand_name'],
		'description' => 'Guides pratiques sur la fréquence de nettoyage, les budgets et le choix d\'un prestataire d\'entretien de locaux professionnels.',
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
	<h1>Conseils d'entretien de locaux professionnels</h1>
	<p style="max-width:640px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Fréquence, budget, cahier des charges : des repères concrets pour cadrer une prestation d'entretien.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-grid tfp-grid--autofit-md">
		<?php foreach ( $articles as $article ) : ?>
			<a href="<?php echo esc_url( get_permalink( $article ) ); ?>" class="tfp-card" style="display:block;text-decoration:none;color:inherit">
				<h2 style="font-size:19px;margin-bottom:8px"><?php echo esc_html( get_the_title( $article ) ); ?></h2>
				<p style="color:var(--color-text-secondary)"><?php echo esc_html( get_the_excerpt( $article ) ); ?></p>
				<span class="tfp-link-arrow" style="margin-top:12px;display:inline-block">Lire l'article →</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un besoin précis à cadrer ?</h2>
		<p>Gratuit · Sans engagement · Réponse sous 24 h</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
