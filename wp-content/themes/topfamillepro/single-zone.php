<?php
/**
 * Gabarit unique du CPT `zone` (CLAUDE.md §3) — un seul fichier pour les trois niveaux
 * (département / ville / commune), conditionnel sur le champ ACF `niveau`.
 *
 * Structure obligatoire des pages locales (brief phase 2) : réponse directe en tête de page,
 * types de locaux concernés, services disponibles, fonctionnement réel, tarif, interlocutrice,
 * zones réellement desservies, FAQ locale, CTA contextualisé, liens vers la page départementale,
 * les villes proches, les prestations et la page pilier.
 *
 * Communes secondaires non validées : noindex,follow tant que `statut_validation` n'est pas coché
 * (CLAUDE.md §5.4) — c'est la seule zone de contenu où le robots n'est pas index,follow par défaut.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_queried_object_id();
$site    = tfp_site_data();

$niveau      = tfp_get_field( 'niveau', $post_id ) ?: 'ville';
$is_dept     = 'departement' === $niveau;
$is_commune  = 'commune' === $niveau;
$validated   = $is_commune ? (bool) tfp_get_field( 'statut_validation', $post_id ) : true;

$terms     = get_the_terms( $post_id, 'departement' );
$dept_term = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0] : null;
$dept_post = $dept_term ? tfp_get_zone_by_department_slug( $dept_term->slug ) : null;

$h1                 = tfp_get_field( 'h1', $post_id ) ?: get_the_title( $post_id );
$reponse            = tfp_get_field( 'reponse_directe', $post_id );
$secteur            = tfp_get_field( 'secteur_economique', $post_id );
$locaux_types       = tfp_get_lines( tfp_get_field( 'locaux_types', $post_id ) );
$fonctionnement     = tfp_get_field( 'fonctionnement', $post_id );
$zones_desservies   = tfp_get_lines( tfp_get_field( 'zones_desservies', $post_id ) );
$cta_label          = tfp_get_field( 'cta_label', $post_id ) ?: 'Demander un devis à ' . get_the_title( $post_id );
$exclusions_rappel  = tfp_get_field( 'exclusions_rappel', $post_id );
$materiel_rappel    = tfp_get_field( 'materiel_rappel', $post_id );
$communes_proches   = tfp_get_field( 'communes_proches', $post_id );
$prestations_liees  = tfp_get_field( 'prestations_liees', $post_id );
$faq                = tfp_get_faq_items( 'faq', $post_id, 8 );

// Villes du département, pour la vue "département".
$cities_in_dept = array();
if ( $is_dept && $dept_term ) {
	$cities_in_dept = get_posts(
		array(
			'post_type'  => 'zone',
			'numberposts' => -1,
			'tax_query'  => array( array( 'taxonomy' => 'departement', 'terms' => $dept_term->term_id ) ),
			'meta_query' => array( array( 'key' => 'niveau', 'value' => array( 'ville', 'commune' ), 'compare' => 'IN' ) ),
		)
	);
}

$seo_title = tfp_get_field( 'seo_title', $post_id );
$seo_desc  = tfp_get_field( 'seo_description', $post_id );
$robots    = $validated ? 'index,follow' : 'noindex,follow';

$canonical = get_permalink( $post_id );

$breadcrumb = array( array( 'label' => 'Accueil', 'url' => home_url( '/' ) ) );
if ( $is_dept ) {
	$breadcrumb[] = array( 'label' => 'Zones d\'intervention', 'url' => home_url( '/zones-intervention/' ) );
	$breadcrumb[] = array( 'label' => get_the_title( $post_id ), 'url' => null );
} else {
	$breadcrumb[] = array( 'label' => 'Zones d\'intervention', 'url' => home_url( '/zones-intervention/' ) );
	if ( $dept_post ) {
		$breadcrumb[] = array( 'label' => get_the_title( $dept_post ), 'url' => get_permalink( $dept_post ) );
	}
	$breadcrumb[] = array( 'label' => get_the_title( $post_id ), 'url' => null );
}

$schema = array();
if ( ! empty( $faq ) && $validated ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( $canonical ) . '#faq',
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
		'title'       => $seo_title ?: ( $h1 . ' | ' . $site['brand_name'] ),
		'description' => $seo_desc ?: wp_trim_words( $reponse, 30 ),
		'type'        => 'website',
		'robots'      => $robots,
		'breadcrumb'  => $breadcrumb,
		'schema'      => $schema,
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( $breadcrumb ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1><?php echo esc_html( $h1 ); ?></h1>
	<?php if ( $reponse ) : ?>
		<p style="margin-top:16px;font-size:19px;color:var(--color-text-secondary);max-width:820px;line-height:1.6"><?php echo esc_html( $reponse ); ?></p>
	<?php endif; ?>
	<div class="tfp-flex" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => $cta_label, 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php if ( $secteur || ! empty( $locaux_types ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-two-col">
		<?php if ( $secteur ) : ?>
			<div>
				<h2>Le tissu économique du secteur</h2>
				<p style="margin-top:12px;font-size:16px;color:var(--color-text-secondary)"><?php echo esc_html( $secteur ); ?></p>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $locaux_types ) ) : ?>
			<div>
				<h2>Types de locaux concernés</h2>
				<div class="tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,160px),1fr));margin-top:14px">
					<?php foreach ( $locaux_types as $type ) : ?>
						<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:11px;padding:13px 15px;font-weight:600;font-size:15px"><?php echo esc_html( $type ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $prestations_liees ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Services disponibles ici</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:18px">
			<?php foreach ( $prestations_liees as $prestation ) : ?>
				<a class="tfp-service-tile" style="border:1px solid var(--color-border);border-radius:var(--radius-lg)" href="<?php echo esc_url( get_permalink( $prestation ) ); ?>">
					<span class="tfp-service-tile__title"><?php echo esc_html( get_the_title( $prestation ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $fonctionnement ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Comment nous travaillons ici</h2>
		<p style="margin-top:14px;font-size:16px;color:var(--color-text-secondary);max-width:820px;line-height:1.7;white-space:pre-line"><?php echo esc_html( $fonctionnement ); ?></p>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Le tarif, en toute transparence</h2>
		<p style="margin-top:12px;font-size:16px;color:var(--color-text-secondary);max-width:760px">
			<?php echo esc_html( tfp_format_price( $site['price_entry'] ) ); ?> HT/heure pour les locations meublées,
			<?php echo esc_html( tfp_format_price( $site['price_autres_locaux'] ) ); ?> HT/heure pour les autres locaux, en entretien régulier.
			En intervention ponctuelle : <?php echo esc_html( tfp_format_price( $site['price_ponctuel'] ) ); ?> HT/heure — identique à toute la région
			(<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-underline">grille tarifaire complète</a>). Les éventuelles indemnités
			kilométriques dépendent de l'adresse des locaux et sont précisées dans le devis.
		</p>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Votre interlocutrice</h2>
		<p style="margin-top:12px;font-size:16px;color:var(--color-text-secondary);max-width:760px">
			<?php echo esc_html( $site['manager'] ); ?> reste votre interlocutrice unique, du devis au suivi de la prestation — un seul contact, joignable directement au <?php echo esc_html( $site['phone'] ); ?>.
		</p>
	</div>
</section>

<?php if ( $is_dept && ! empty( $cities_in_dept ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Nos villes dans le département</h2>
		<div class="tfp-flex" style="margin-top:16px">
			<?php foreach ( $cities_in_dept as $city ) : ?>
				<a href="<?php echo esc_url( get_permalink( $city ) ); ?>" class="tfp-chip"><?php echo esc_html( get_the_title( $city ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! $is_dept && ! empty( $communes_proches ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Villes et communes proches</h2>
		<div class="tfp-flex" style="margin-top:16px">
			<?php foreach ( $communes_proches as $commune ) : ?>
				<a href="<?php echo esc_url( get_permalink( $commune ) ); ?>" class="tfp-chip"><?php echo esc_html( get_the_title( $commune ) ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $zones_desservies ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Zones réellement desservies</h2>
		<p style="margin-top:12px;font-size:14px;color:var(--color-text-tertiary)">Sans page dédiée pour l'instant — l'intervention y est étudiée au cas par cas.</p>
		<div class="tfp-flex" style="margin-top:12px">
			<?php foreach ( $zones_desservies as $zone_name ) : ?>
				<span class="tfp-chip" style="cursor:default"><?php echo esc_html( $zone_name ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! $is_dept && $dept_post ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<a href="<?php echo esc_url( get_permalink( $dept_post ) ); ?>" class="tfp-eyebrow-link">← Voir tout le département <?php echo esc_html( get_the_title( $dept_post ) ); ?></a>
	</div>
</section>
<?php endif; ?>

<?php if ( $exclusions_rappel || $materiel_rappel ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr))">
		<?php if ( $exclusions_rappel ) : ?>
			<div class="tfp-card">
				<h2 style="font-size:20px">Ce qui n'est pas couvert</h2>
				<p style="margin-top:10px;color:var(--color-text-secondary)">Locaux industriels, alimentaires, et locaux médicaux nécessitant une asepsie complète.</p>
			</div>
		<?php endif; ?>
		<?php if ( $materiel_rappel ) : ?>
			<div class="tfp-card">
				<h2 style="font-size:20px">Matériel et produits</h2>
				<p style="margin-top:10px;color:var(--color-text-secondary)">Fournis par vos soins — précisé dans le cahier des charges.</p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $faq ) ) : ?>
<section class="tfp-section">
	<div class="tfp-container tfp-container--narrow">
		<h2>FAQ locale</h2>
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

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<a href="<?php echo esc_url( home_url( '/nettoyage-professionnel/' ) ); ?>" class="tfp-eyebrow-link">En savoir plus sur le nettoyage professionnel →</a>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2><?php echo esc_html( $cta_label ); ?></h2>
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
