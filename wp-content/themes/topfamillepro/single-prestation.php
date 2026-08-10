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
$tease       = tfp_get_field( 'tease', $post_id );
$pour_qui    = tfp_get_field( 'pour_qui', $post_id );
$taches      = tfp_get_lines( tfp_get_field( 'taches', $post_id ) );
$problemes   = tfp_get_lines( tfp_get_field( 'problemes', $post_id ) );
$organisation = tfp_get_field( 'organisation', $post_id );
$exclusions  = tfp_get_field( 'exclusions', $post_id );
$materiel    = tfp_get_field( 'materiel_rappel', $post_id );
$villes      = tfp_get_field( 'villes_prioritaires', $post_id );
$faq         = tfp_get_faq_items( 'faq', $post_id, 8 );
$semaine     = tfp_get_field( 'semaine_type', $post_id );
$configs     = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$titre = tfp_get_field( 'config_' . $i . '_titre', $post_id );
	if ( $titre ) {
		$configs[] = array( 'titre' => $titre, 'texte' => tfp_get_field( 'config_' . $i . '_texte', $post_id ) );
	}
}
$budget      = tfp_home_budget_example();
$related_articles = tfp_get_prestation_related_articles( $post_id );

$seo_title = tfp_get_field( 'seo_title', $post_id );
$seo_desc  = tfp_get_field( 'seo_description', $post_id );

// Contexte transmis au formulaire de devis (préremplissage, src/js/quote-form.js). Le paramètre
// n'est volontairement pas nommé « prestation » : ce nom est le query_var natif du CPT `prestation`
// (register_post_type() l'enregistre par défaut) et un `?prestation=bureaux` sur toute URL du site
// détournerait la requête principale de WordPress vers l'article single « bureaux », quelle que
// soit la page réellement demandée.
$devis_url = add_query_arg(
	array(
		'service'       => get_post_field( 'post_name', $post_id ),
		'service_label' => rawurlencode( get_the_title( $post_id ) ),
	),
	home_url( '/demande-de-devis/' )
);

$canonical_path = wp_parse_url( get_permalink( $post_id ), PHP_URL_PATH );

// Visuel d'illustration : un slug dédié pour bureaux/commerces (photos correspondant au
// prototype Claude Design), un visuel générique honnête pour les 4 autres prestations — pas de
// photo prétendant montrer un type de local précis qu'elle ne montre pas réellement.
$image_slug = tfp_get_field( 'image_slug', $post_id );
if ( ! $image_slug ) {
	$slug_map   = array(
		'bureaux'   => 'service-bureaux',
		'commerces' => 'service-commerces',
	);
	$post_name  = get_post_field( 'post_name', $post_id );
	$image_slug = $slug_map[ $post_name ] ?? 'service-generic';
}

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

<section class="tfp-hero">
	<div class="tfp-hero__content">
		<p class="tfp-region-badge"><?php echo esc_html( $site['address_region'] ); ?></p>
		<h1><?php echo esc_html( $h1 ); ?></h1>
		<?php if ( $tease ) : ?>
			<p class="tfp-hero__lede"><?php echo esc_html( $tease ); ?></p>
		<?php endif; ?>
		<p class="tfp-hero__microcopy"><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h · tarif unique · devis gratuit sous 24 h</p>
		<div class="tfp-flex" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => $devis_url, 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( $image_slug, array( 'sizes' => '(max-width: 819px) 92vw, 600px', 'lcp' => true ) ); ?>
		</div>
	</div>
</section>

<?php if ( $reponse ) : ?>
<section class="tfp-container tfp-section--tight">
	<div class="tfp-direct-answer">
		<p class="tfp-direct-answer__label">Réponse directe</p>
		<p class="tfp-direct-answer__text"><?php echo esc_html( $reponse ); ?></p>
	</div>
</section>
<?php endif; ?>

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

<?php if ( ! empty( $configs ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Trois configurations, trois organisations</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary);max-width:760px">Le volume d'heures et la fréquence ne se déduisent pas d'une surface. Voici les cas de figure les plus courants et le rythme qui leur correspond généralement.</p>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:24px">
			<?php foreach ( $configs as $config ) : ?>
				<div class="tfp-card">
					<h3 style="font-size:19px"><?php echo esc_html( $config['titre'] ); ?></h3>
					<p style="margin-top:10px;color:var(--color-text-secondary);font-size:15px;line-height:1.6"><?php echo esc_html( $config['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $semaine ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container" style="max-width:860px">
		<h2>Une semaine type</h2>
		<p style="margin-top:14px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $semaine ); ?></p>
	</div>
</section>
<?php endif; ?>

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
			<?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/heure — tarif unique en entretien régulier comme en intervention ponctuelle, quel que soit le type de local.
			Frais de gestion <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT/mois et frais de mise en place
			<?php echo esc_html( tfp_format_price( $site['price_setup'] ) ); ?> HT, précisés au devis.
		</p>
		<div class="tfp-price-example" style="max-width:420px">
			<div class="tfp-price-example__label">Exemple · <?php echo (int) $budget['hours']; ?> h/mois</div>
			<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
			<div class="tfp-price-example__note"><?php echo (int) $budget['hours']; ?> h × <?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> + <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> de gestion. Avec les frais de mise en place : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT le premier mois. Exemple non contractuel.</div>
		</div>
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

<?php if ( ! empty( $related_articles ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Nos conseils sur ce sujet</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:16px">
			<?php foreach ( $related_articles as $article ) : ?>
				<a href="<?php echo esc_url( get_permalink( $article ) ); ?>" class="tfp-card" style="display:block;text-decoration:none;color:inherit">
					<h3 style="font-size:17px"><?php echo esc_html( get_the_title( $article ) ); ?></h3>
					<span class="tfp-link-arrow" style="margin-top:8px;display:inline-block">Lire l'article →</span>
				</a>
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

<section class="tfp-container tfp-section--tight">
	<div class="tfp-contact-nudge">
		<p>Encore une question sur <?php echo esc_html( mb_strtolower( get_the_title( $post_id ) ) ); ?> ? <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond directement.</p>
		<?php tfp_button( array( 'label' => 'Nous contacter', 'href' => home_url( '/contact/' ), 'variant' => 'secondary', 'size' => 'sm' ) ); ?>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un projet de <?php echo esc_html( mb_strtolower( get_the_title( $post_id ) ) ); ?> ?</h2>
		<p>Décrivez vos locaux : <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond sous 24 heures avec une proposition claire.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => $devis_url, 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ ' . $site['phone'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>
<?php
get_footer();
