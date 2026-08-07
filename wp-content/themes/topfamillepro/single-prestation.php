<?php
/**
 * Gabarit unique du CPT `prestation` (CLAUDE.md §3) — s'applique aux 6 prestations.
 * Phase 2 : une seule entrée réelle (bureaux) sert de référence ; les 5 autres seront créées en
 * phase 3 avec le même gabarit.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id  = get_queried_object_id();
$site     = tfp_site_data();

$h1          = tfp_get_field( 'h1', $post_id ) ?: get_the_title( $post_id );
$reponse     = tfp_get_field( 'reponse_directe', $post_id );
$pour_qui    = tfp_get_field( 'pour_qui', $post_id );
$taches      = tfp_get_lines( tfp_get_field( 'taches', $post_id ) );
$problemes   = tfp_get_lines( tfp_get_field( 'problemes', $post_id ) );
$organisation = tfp_get_field( 'organisation', $post_id );
$exclusions  = tfp_get_field( 'exclusions', $post_id );
$materiel    = tfp_get_field( 'materiel_rappel', $post_id );
$villes      = tfp_get_field( 'villes_prioritaires', $post_id );
$faq         = tfp_get_faq_items( 'faq', $post_id, 8 );

$seo_title = tfp_get_field( 'seo_title', $post_id );
$seo_desc  = tfp_get_field( 'seo_description', $post_id );

$canonical_path = wp_parse_url( get_permalink( $post_id ), PHP_URL_PATH );

$schema = array(
	array(
		'@type'       => 'Service',
		'@id'         => trailingslashit( $site['origin'] ) . ltrim( $canonical_path, '/' ) . '#service',
		'name'        => $h1,
		'description' => $seo_desc ?: wp_trim_words( $reponse, 40 ),
		'serviceType' => get_the_title( $post_id ),
		'provider'    => array( '@id' => trailingslashit( $site['origin'] ) . '#organisation' ),
		'areaServed'  => array_map(
			function ( $name ) {
				return array( '@type' => 'AdministrativeArea', 'name' => $name );
			},
			$site['departements']
		),
	),
);

if ( ! empty( $faq ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( get_permalink( $post_id ) ) . '#faq',
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
		'title'       => $seo_title ?: ( $h1 . ' en ' . $site['address_region'] . ' | ' . $site['brand_name'] ),
		'description' => $seo_desc ?: wp_trim_words( $reponse, 30 ),
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Prestations', 'url' => home_url( '/prestations/' ) ),
			array( 'label' => get_the_title( $post_id ), 'url' => null ),
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
	<h1><?php echo esc_html( $h1 ); ?></h1>
	<?php if ( $reponse ) : ?>
		<p style="margin-top:16px;font-size:19px;color:var(--color-text-secondary);max-width:820px;line-height:1.6"><?php echo esc_html( $reponse ); ?></p>
	<?php endif; ?>
	<div class="tfp-flex" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php if ( $pour_qui ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Pour qui</h2>
		<p style="margin-top:12px;font-size:17px;color:var(--color-text-secondary);max-width:820px"><?php echo esc_html( $pour_qui ); ?></p>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $taches ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Ce que couvre la prestation</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:20px">
			<?php foreach ( $taches as $tache ) : ?>
				<div class="tfp-card--flat"><?php echo esc_html( $tache ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr))">
		<?php if ( $exclusions ) : ?>
			<div class="tfp-card">
				<h2 style="font-size:22px">Ce qui n'est pas inclus</h2>
				<p style="margin-top:10px;color:var(--color-text-secondary)"><?php echo esc_html( $exclusions ); ?></p>
			</div>
		<?php endif; ?>
		<?php if ( $materiel ) : ?>
			<div class="tfp-card">
				<h2 style="font-size:22px">Matériel et produits</h2>
				<p style="margin-top:10px;color:var(--color-text-secondary)">Le matériel et les produits d'entretien sont fournis par vos soins — une différence à connaître avant le devis, précisée dans le cahier des charges.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $problemes ) ) : ?>
<section class="tfp-section tfp-section--navy">
	<div class="tfp-container">
		<h2>Des situations que nous prenons en charge</h2>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:24px">
			<?php foreach ( $problemes as $probleme ) : ?>
				<div class="tfp-problem" style="border-top:1px solid #2C5E8C;padding-top:14px">
					<p class="tfp-problem__desc"><?php echo esc_html( $probleme ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $organisation ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Organisation de la prestation</h2>
		<p style="margin-top:14px;font-size:16px;color:var(--color-text-secondary);max-width:820px;line-height:1.7;white-space:pre-line"><?php echo esc_html( $organisation ); ?></p>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Le tarif, en toute transparence</h2>
		<p style="margin-top:12px;font-size:16px;color:var(--color-text-secondary);max-width:760px">
			<?php echo esc_html( tfp_format_price( $site['price_entry'] ) ); ?> HT/heure pour les locations meublées,
			<?php echo esc_html( tfp_format_price( $site['price_autres_locaux'] ) ); ?> HT/heure pour les autres locaux, en entretien régulier.
			En intervention ponctuelle : <?php echo esc_html( tfp_format_price( $site['price_ponctuel'] ) ); ?> HT/heure.
			Frais de gestion <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT/mois et frais de mise en place
			<?php echo esc_html( tfp_format_price( $site['price_setup'] ) ); ?> HT, précisés au devis.
		</p>
		<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-eyebrow-link">Voir la page Tarifs complète →</a>
	</div>
</section>

<?php if ( ! empty( $villes ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Disponible dans ces villes</h2>
		<div class="tfp-flex" style="margin-top:16px">
			<?php foreach ( $villes as $ville ) : ?>
				<a href="<?php echo esc_url( get_permalink( $ville ) ); ?>" class="tfp-chip"><?php echo esc_html( get_the_title( $ville ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

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

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un projet de <?php echo esc_html( mb_strtolower( get_the_title( $post_id ) ) ); ?> ?</h2>
		<p>Décrivez vos locaux : <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond sous 24 heures avec une proposition claire.</p>
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
