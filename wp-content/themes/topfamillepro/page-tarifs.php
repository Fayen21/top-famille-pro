<?php
/**
 * Page statique « Tarifs » (/tarifs/) — gabarit dédié (CLAUDE.md §3).
 *
 * Tarif réel unique (PROJECT_INPUTS.md §5), identique dans toute la région (CLAUDE.md §5.3) et
 * quel que soit le régime (régulier ou ponctuel) ou le type de local — 27 € HT/h depuis le
 * 9 août 2026 (hotfix fidélité Claude Design), qui remplace l'ancienne grille à trois montants.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$prestations = get_posts( array( 'post_type' => 'prestation', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );

$faqs = array(
	array( 'q' => 'Le tarif est-il le même partout dans la région ?', 'a' => "Oui. Le tarif unique de {$site['price_unique_display']} HT/h est identique dans les huit départements couverts, en régulier comme en ponctuel, quel que soit le type de local. Seules les éventuelles indemnités kilométriques varient selon l'adresse des locaux, le planning et les conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Le tarif change-t-il selon le type de local ?', 'a' => "Non. {$site['price_unique_display']} HT/h s'applique de la même façon aux bureaux, commerces, cabinets, copropriétés, locations meublées et interventions ponctuelles — un tarif unique, sans grille différenciée." ),
	array( 'q' => 'Le tarif ponctuel est-il plus élevé que le régulier ?', 'a' => "Non. Le tarif est identique en entretien régulier et en intervention ponctuelle : {$site['price_unique_display']} HT/h dans les deux cas." ),
	array( 'q' => 'Les frais de gestion et de mise en place sont-ils systématiques ?', 'a' => "Les frais de gestion (9,00 € HT/mois) s'appliquent aux contrats réguliers. Les frais de mise en place (50,00 € HT, une seule fois) s'appliquent au démarrage, le cas échéant, selon les conditions précisées au devis." ),
	array( 'q' => 'Que couvrent les indemnités kilométriques ?', 'a' => "Elles couvrent le déplacement de l'intervenant avec son véhicule personnel ({$site['price_km_display']} HT/km), lorsqu'elles s'appliquent. Elles dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont toujours précisées dans le devis avant signature." ),
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
		'description' => "Tarif réel du nettoyage professionnel : {$site['price_unique_display']} HT/h, tarif unique en régulier comme en ponctuel, identique dans toute la {$site['address_region']}. Frais de gestion, mise en place et exemples de budgets.",
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
	<div class="tfp-container">
		<div class="tfp-card" style="max-width:420px;margin-inline:auto;text-align:center">
			<h2>Tarif unique</h2>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h</strong></p>
			<p style="color:var(--color-text-secondary)">En entretien régulier comme en intervention ponctuelle, quel que soit le type de local — bureaux, commerces, cabinets, copropriétés, locations meublées — dans toute la <?php echo esc_html( $site['address_region'] ); ?>.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2>Ce qui s'ajoute, selon les cas</h2>
			<div style="display:flex;flex-direction:column;gap:12px;margin-top:16px">
				<?php tfp_check_item( 'Majoration dimanche, jours fériés, nuit (22 h–7 h) : +' . $site['price_majoration_pct'] . ' %' ); ?>
				<?php tfp_check_item( "Indemnités kilométriques (véhicule personnel de l'intervenant) : " . $site['price_km_display'] . ' HT/km, précisées au devis' ); ?>
				<?php tfp_check_item( 'Frais de mise en place, une seule fois : ' . tfp_format_price( $site['price_setup'] ) . ' HT' ); ?>
				<?php tfp_check_item( 'Frais de gestion mensuels (contrats réguliers) : ' . tfp_format_price( $site['price_gestion'] ) . ' HT/mois' ); ?>
			</div>
			<p style="margin-top:16px;color:var(--color-text-secondary)">Aucun de ces éléments n'apparaît après coup : tout figure au devis, transmis gratuitement sous 24 heures et sans engagement.</p>
		</div>
		<div class="tfp-card">
			<h2>Exemples de budget mensuel</h2>
			<div style="margin-top:12px;display:flex;flex-direction:column;gap:14px">
				<?php foreach ( tfp_budget_examples_table() as $row ) : ?>
					<div style="display:flex;justify-content:space-between;gap:12px;align-items:baseline;border-bottom:1px solid var(--color-border);padding-bottom:10px">
						<span style="color:var(--color-text-secondary)"><?php echo (int) $row['hours']; ?> h/mois</span>
						<span><strong><?php echo esc_html( tfp_format_price( $row['monthly'] ) ); ?> HT/mois</strong> · 1er mois <?php echo esc_html( tfp_format_price( $row['first_month'] ) ); ?> HT</span>
					</div>
				<?php endforeach; ?>
			</div>
			<p style="margin-top:12px;color:var(--color-text-secondary);font-size:14px">Calcul : heures × <?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT + <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT de gestion. Premier mois : + <?php echo esc_html( tfp_format_price( $site['price_setup'] ) ); ?> HT de mise en place. Exemples non contractuels.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<h2>Cette grille s'applique à toutes nos prestations</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:20px">
			<?php foreach ( $prestations as $prestation ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prestation ) ); ?>" class="tfp-card" style="display:block;text-decoration:none;color:inherit">
					<h3 style="font-size:17px"><?php echo esc_html( get_the_title( $prestation ) ); ?></h3>
					<span class="tfp-link-arrow" style="margin-top:8px;display:inline-block">Voir la prestation →</span>
				</a>
			<?php endforeach; ?>
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
