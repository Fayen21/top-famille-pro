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
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Nos zones d'intervention en <?php echo esc_html( $site['address_region'] ); ?></h1>
	<p style="max-width:680px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Top-Famille Pro entretient bureaux, commerces, cabinets, parties communes et locations meublées dans les huit départements de la région, depuis son implantation de Saint-Apollinaire, près de Dijon.</p>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container" style="max-width:820px">
		<p style="font-size:16px;color:var(--color-text-secondary);line-height:1.6">Nous intervenons uniquement en <?php echo esc_html( $site['address_region'] ); ?> : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne et Territoire de Belfort. Le tarif est le même partout, en entretien régulier comme en intervention ponctuelle, avec un devis gratuit transmis sous 24 heures. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis.</p>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<h2>Les 8 départements couverts</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:24px">
			<?php foreach ( $departements as $dept ) : ?>
				<a href="<?php echo esc_url( get_permalink( $dept ) ); ?>" class="tfp-card" style="display:block;text-decoration:none;color:inherit">
					<h3 style="margin-bottom:6px"><?php echo esc_html( get_the_title( $dept ) ); ?></h3>
					<span class="tfp-link-arrow">Voir la page →</span>
				</a>
			<?php endforeach; ?>
		</div>
		<p style="margin-top:20px">
			<a href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>" class="tfp-eyebrow-link">Page régionale complète →</a>
		</p>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2>Une couverture régionale organisée depuis Saint-Apollinaire</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Top-Famille Pro est implantée à Saint-Apollinaire, commune de la périphérie est de Dijon, en Côte-d'Or. C'est de cette adresse que partent les plannings, que sont préparés les devis et que sont cherchées les solutions de remplacement. Nous n'avons pas d'agence à Besançon, à Chalon-sur-Saône ni ailleurs dans la région : une seule adresse, une seule interlocutrice, un seul numéro de téléphone pour tous nos clients.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Cette organisation a une conséquence concrète : les conditions d'intervention dépendent de la distance réelle entre vos locaux et Saint-Apollinaire, et non d'un tarif différent affiché ville par ville. Le taux horaire reste identique dans toute la région ; les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis.</p>
		</div>
		<div>
			<h2>Départements, villes et communes : comment lire ces pages</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Chaque département dispose de sa page : villes couvertes, tissu professionnel local, types de locaux les plus fréquents et questions fréquentes. Chaque ville principale a également la sienne, plus détaillée.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Nous distinguons volontairement les communes voisines et les autres villes du même département : Besançon, Nevers ou Vesoul sont des secteurs régionaux couverts, pas des communes voisines de Dijon. Nous préférons l'écrire clairement plutôt que de gonfler artificiellement une liste de liens.</p>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Votre commune n'apparaît pas encore ?</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Les pages publiées correspondent à nos secteurs prioritaires. Elles ne délimitent pas notre périmètre : le plus simple reste de nous donner votre adresse et votre besoin. Nous vous confirmons sous 24 heures si nous pouvons intervenir, à quel rythme et à quelles conditions. Si nous ne sommes pas en mesure de tenir un planning fiable chez vous, nous vous le disons plutôt que de nous engager à moitié.</p>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Questions fréquentes</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faqs as $item ) : ?>
				<details class="tfp-card" style="margin-bottom:10px">
					<summary style="font-weight:600;cursor:pointer"><?php echo esc_html( $item['q'] ); ?></summary>
					<p style="margin-top:10px;color:var(--color-text-secondary)"><?php echo esc_html( $item['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Vérifier notre intervention dans ma commune</h2>
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
