<?php
/**
 * Page statique « Zones d'intervention » (/zones-intervention/) — gabarit dédié (CLAUDE.md §3).
 *
 * Hub listant les 8 départements réellement couverts (CPT `zone`, niveau département) + contenu
 * repris du prototype (HUB_PAGE), corrigé : tarif fictif « 27 € HT/h » retiré partout. Le
 * paragraphe « comment lire ces pages » du prototype est conservé presque tel quel : il explicite
 * déjà honnêtement que Besançon/Nevers/Vesoul sont des secteurs régionaux, pas des communes
 * voisines de Dijon — exactement la distinction que CLAUDE.md demande de ne pas brouiller.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$departements = get_posts(
	array(
		'post_type'    => 'zone',
		'numberposts'  => -1,
		'meta_key'     => 'niveau',
		'meta_value'   => 'departement',
		'orderby'      => 'title',
		'order'        => 'ASC',
	)
);

$faqs = array(
	array( 'q' => 'Intervenez-vous dans toute la France ?', 'a' => "Non. Top-Famille Pro intervient exclusivement en {$site['address_region']}, sur ses huit départements. Nous préférons couvrir correctement une région que d'annoncer une présence nationale que nous ne pourrions pas tenir." ),
	array( 'q' => 'Avez-vous des agences locales dans la région ?', 'a' => "Non. Nous avons une seule implantation, à Saint-Apollinaire près de Dijon, et une seule interlocutrice, {$site['manager']}, joignable au {$site['phone']} depuis n'importe quelle commune de la région." ),
	array( 'q' => 'Le tarif change-t-il selon la ville ?', 'a' => "Non, la grille tarifaire est la même partout — voir la page Tarifs. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Ma commune n\'est pas listée sur le site, est-ce un problème ?', 'a' => "Pas nécessairement. Les pages en ligne couvrent nos secteurs prioritaires, pas la totalité de notre périmètre. Donnez-nous votre adresse : nous confirmons sous 24 heures si nous pouvons intervenir et à quelles conditions." ),
	array( 'q' => 'Puis-je faire appel à vous pour une intervention unique ?', 'a' => "Oui. Nous réalisons des interventions ponctuelles : remise en état après travaux, fin de bail, avant ouverture, grand nettoyage saisonnier. La date est confirmée au devis, selon nos disponibilités sur votre secteur." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/zones-intervention/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array( '@type' => 'Question', 'name' => $item['q'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ) );
			},
			$faqs
		),
	);
}

tfp_seo(
	array(
		'title'       => "Zones d'intervention en {$site['address_region']} | " . $site['brand_name'],
		'description' => "Huit départements couverts depuis Saint-Apollinaire : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne, Territoire de Belfort.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => "Zones d'intervention", 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'zones-intervention' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-hero__eyebrow">
		<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
		<?php tfp_google_rating_badge( 'inline' ); ?>
	</div>
	<h1><?php echo esc_html( $page['h1'] ); ?></h1>
	<?php foreach ( $page['lede'] as $lede ) : ?>
		<p class="tfp-section__lede"><?php echo esc_html( $lede ); ?></p>
	<?php endforeach; ?>
	<div class="tfp-action-row" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'zones-intervention' ) ); ?>

<?php get_footer(); ?>
