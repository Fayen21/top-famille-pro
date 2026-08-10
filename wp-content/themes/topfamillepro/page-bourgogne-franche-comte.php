<?php
/**
 * Page statique « région » (/zones-intervention/bourgogne-franche-comte/) — gabarit dédié
 * (CLAUDE.md §3), page enfant de « Zones d'intervention » dans la hiérarchie WordPress.
 *
 * Contenu repris du prototype (REGION_PAGE), corrigé : tarif fictif « 27 € HT/h » retiré partout,
 * exemple de budget recalculé sur le tarif réel via tfp_home_budget_example() (même valeur que
 * l'accueil : 321 € HT/mois, pas les 333 € du prototype calculés sur le tarif fictif), avis de
 * démonstration (« Sophie M. ») retiré. Title raccourci à 58 caractères (68c dans le prototype,
 * docs/INVENTAIRE-ROUTES.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$budget = tfp_home_budget_example();
$departements = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'departement', 'orderby' => 'title', 'order' => 'ASC' ) );

$faqs = array(
	array( 'q' => 'Intervenez-vous dans les huit départements de la région ?', 'a' => "Oui : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne et Territoire de Belfort. En revanche, nous n'intervenons pas en dehors de la {$site['address_region']}." ),
	array( 'q' => 'Où est réellement située l\'entreprise ?', 'a' => "À {$site['address_city']} ({$site['address_cp']}), commune limitrophe de Dijon, en Côte-d'Or. C'est notre unique implantation : nous n'avons pas d'agences dans les autres villes de la région." ),
	array( 'q' => 'Le tarif est-il le même dans tous les départements ?', 'a' => "Oui, la grille tarifaire est identique partout — voir la page Tarifs — en régulier comme en ponctuel. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Aurai-je toujours le même intervenant ?', 'a' => "C'est ce que nous recherchons pour chaque site, car la régularité fait la qualité. Nous ne le garantissons pas : en cas d'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement." ),
	array( 'q' => 'Faites-vous du nettoyage industriel ou hospitalier ?', 'a' => "Non. Nous intervenons sur les bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants. Le nettoyage industriel lourd, l'agroalimentaire spécialisé, le bio-nettoyage hospitalier et le désamiantage ne font pas partie de notre offre." ),
	array( 'q' => 'Faut-il signer un engagement de durée ?', 'a' => "Le devis est gratuit et sans engagement. Pour la prestation, le volume d'heures et la fréquence peuvent être ajustés, et les conditions d'arrêt figurent au devis avant signature." ),
	array( 'q' => 'Qui contacter pour un site situé loin de Dijon ?', 'a' => "La même personne : {$site['manager']}, au {$site['phone']}. Nous n'utilisons pas de numéro local différent selon la ville, et votre dossier n'est pas transféré à un autre interlocuteur." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ) . '#faq',
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
		'title'       => 'Nettoyage pro en Bourgogne-Franche-Comté | ' . $site['brand_name'],
		'description' => "Entretien régulier ou ponctuel de locaux professionnels dans toute la {$site['address_region']}, au même tarif partout.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => "Zones d'intervention", 'url' => home_url( '/zones-intervention/' ) ),
			array( 'label' => $site['address_region'], 'url' => null ),
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
$page = tfp_static_page_data( 'bourgogne-franche-comte' );
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
	<div class="tfp-flex" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'bourgogne-franche-comte' ) ); ?>

<?php get_footer(); ?>
