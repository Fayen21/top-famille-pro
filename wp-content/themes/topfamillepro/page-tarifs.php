<?php
/**
 * Page statique « Tarifs » (/tarifs/) — gabarit dédié (CLAUDE.md §3).
 *
 * Grille tarifaire réelle à trois montants (PROJECT_INPUTS.md §5), identique dans toute la
 * région (CLAUDE.md §5.3) : le prototype affichait un tarif fictif unique « 27 € HT/h » — corrigé
 * ici comme sur toutes les autres pages de la phase 2/3.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$budget = tfp_home_budget_example();

$faqs = array(
	array( 'q' => 'Le tarif est-il le même partout dans la région ?', 'a' => "Oui. La grille tarifaire est identique dans les huit départements couverts, en régulier comme en ponctuel. Seules les éventuelles indemnités kilométriques varient selon l'adresse des locaux, le planning et les conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Quelle est la différence entre le tarif « locations » et « autres locaux » ?', 'a' => "Le tarif locations (24,30 € HT/h) s'applique aux locations meublées et hébergements. Le tarif autres locaux (26,00 € HT/h) s'applique aux bureaux, commerces, cabinets, copropriétés et à la plupart des autres types de locaux professionnels." ),
	array( 'q' => 'Pourquoi le tarif ponctuel est-il plus élevé ?', 'a' => "Une intervention ponctuelle (30,00 € HT/h) mobilise l'organisation pour une seule intervention, sans les économies d'échelle d'un contrat régulier. Au-delà de 5 interventions, le tarif régulier applicable au type de local s'applique." ),
	array( 'q' => 'Les frais de gestion et de mise en place sont-ils systématiques ?', 'a' => "Les frais de gestion (9,00 € HT/mois) s'appliquent aux contrats réguliers. Les frais de mise en place (50,00 € HT, une seule fois) s'appliquent au démarrage, le cas échéant, selon les conditions précisées au devis." ),
	array( 'q' => 'Que couvrent les indemnités kilométriques ?', 'a' => "Elles couvrent le déplacement de l'intervenant avec son véhicule personnel (0,35 € HT/km), lorsqu'elles s'appliquent. Elles dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont toujours précisées dans le devis avant signature." ),
	array( 'q' => 'Le devis engage-t-il à quelque chose ?', 'a' => "Non. Le devis est gratuit, étudié personnellement par Audrey, transmis sous 24 heures et sans engagement de votre part." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/tarifs/' ) ) . '#faq',
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
		'title'       => 'Tarifs de nettoyage professionnel | ' . $site['brand_name'],
		'description' => "Grille tarifaire réelle du nettoyage professionnel : {$site['price_entry_display']} HT/h, identique dans toute la {$site['address_region']}. Frais de gestion, mise en place et exemples de budgets.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Tarifs', 'url' => null ),
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
	<h1>Tarifs de nettoyage professionnel</h1>
	<p style="max-width:680px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Une grille tarifaire identique dans toute la <?php echo esc_html( $site['address_region'] ); ?>, quelle que soit la ville : nous ne pratiquons pas de tarif différencié par commune.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-grid tfp-grid--autofit-md">
		<div class="tfp-card">
			<h2>Ménage régulier — locations</h2>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $site['price_entry'] ) ); ?> HT/h</strong></p>
			<p style="color:var(--color-text-secondary)">Locations meublées et hébergements, en contrat régulier.</p>
		</div>
		<div class="tfp-card">
			<h2>Ménage régulier — autres locaux</h2>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $site['price_autres_locaux'] ) ); ?> HT/h</strong></p>
			<p style="color:var(--color-text-secondary)">Bureaux, commerces, cabinets, copropriétés et autres locaux professionnels, en contrat régulier.</p>
		</div>
		<div class="tfp-card">
			<h2>Ménage ponctuel</h2>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $site['price_ponctuel'] ) ); ?> HT/h</strong></p>
			<p style="color:var(--color-text-secondary)">Jusqu'à 5 interventions. Au-delà, le tarif régulier applicable au type de local s'applique.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2>Ce qui s'ajoute, selon les cas</h2>
			<div style="display:flex;flex-direction:column;gap:12px;margin-top:16px">
				<?php tfp_check_item( 'Majoration dimanche, jours fériés, nuit (22 h–7 h) : +10 %' ); ?>
				<?php tfp_check_item( "Indemnités kilométriques (véhicule personnel de l'intervenant) : " . tfp_format_price( 0.35 ) . ' HT/km, précisées au devis' ); ?>
				<?php tfp_check_item( 'Frais de mise en place, une seule fois : ' . tfp_format_price( $site['price_setup'] ) . ' HT' ); ?>
				<?php tfp_check_item( 'Frais de gestion mensuels (contrats réguliers) : ' . tfp_format_price( $site['price_gestion'] ) . ' HT/mois' ); ?>
			</div>
			<p style="margin-top:16px;color:var(--color-text-secondary)">Aucun de ces éléments n'apparaît après coup : tout figure au devis, transmis gratuitement sous 24 heures et sans engagement.</p>
		</div>
		<div class="tfp-card">
			<h2>Exemple · bureaux réguliers, <?php echo (int) $budget['hours']; ?> h/mois</h2>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> HT/mois</strong></p>
			<p style="color:var(--color-text-secondary)"><?php echo (int) $budget['hours']; ?> h × <?php echo esc_html( tfp_format_price( $site['price_autres_locaux'] ) ); ?> HT + <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT de gestion = <?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> HT/mois. Premier mois : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT si les frais de mise en place s'appliquent. Exemple non contractuel.</p>
		</div>
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
		<h2>Un devis étudié personnellement par Audrey</h2>
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
