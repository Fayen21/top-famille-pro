<?php
/**
 * Page statique « Nos prestations » (/prestations/) — gabarit dédié (CLAUDE.md §3), sélectionné
 * automatiquement par WordPress via page-{slug}.php pour la Page du même slug.
 *
 * Simple index des 6 prestations réelles (CPT `prestation`), sans contenu éditorial propre à
 * dupliquer : chaque prestation a déjà sa page dédiée avec sa réponse directe et sa FAQ.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$prestations = get_posts(
	array(
		'post_type'      => 'prestation',
		'posts_per_page'  => -1,
		'orderby'         => 'menu_order title',
		'order'           => 'ASC',
	)
);

tfp_seo(
	array(
		'title'       => 'Nos prestations de nettoyage professionnel | ' . $site['brand_name'],
		'description' => "Six prestations d'entretien professionnel : bureaux, commerces, cabinets, copropriétés, locations meublées et nettoyage ponctuel, dans toute la {$site['address_region']}.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Nos prestations', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Nos prestations de nettoyage professionnel</h1>
	<p style="max-width:640px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Six prestations d'entretien, une même organisation et une même grille tarifaire régionale. Chaque prestation a sa page détaillée : pour qui, tâches couvertes, exclusions réelles et FAQ.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-grid tfp-grid--autofit-lg">
		<?php foreach ( $prestations as $prestation ) :
			$tease = tfp_get_field( 'tease', $prestation->ID );
			$h1    = tfp_get_field( 'h1', $prestation->ID ) ?: get_the_title( $prestation->ID );
			?>
			<a href="<?php echo esc_url( get_permalink( $prestation ) ); ?>" class="tfp-card" style="display:block;text-decoration:none;color:inherit">
				<h2 style="margin-bottom:8px"><?php echo esc_html( get_the_title( $prestation ) ); ?></h2>
				<?php if ( $tease ) : ?><p style="color:var(--color-text-secondary)"><?php echo esc_html( $tease ); ?></p><?php endif; ?>
				<span class="tfp-link-arrow" style="margin-top:12px;display:inline-block">Voir la prestation →</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-price-band">
		<span class="tfp-price-band__value">
			<strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong>
			<span>tarif unique, indiqué avant le devis</span>
		</span>
		<?php tfp_check_item( 'Devis gratuit sous 24 h' ); ?>
		<?php tfp_check_item( 'Matériel et produits fournis par le client' ); ?>
		<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-btn tfp-btn--secondary tfp-btn--sm" style="margin-left:auto">Voir les tarifs →</a>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un besoin qui ne correspond pas exactement à une prestation ?</h2>
		<p>Décrivez-nous vos locaux : nous vous dirons si votre demande peut être étudiée et à quelles conditions.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
