<?php
/**
 * Gabarit unique du CPT `prestation` (CLAUDE.md §3) — s'applique aux 6 prestations.
 *
 * Reproduit l'enchaînement des 14 sections de la route `#/service/*` de la maquette Claude Design,
 * dans le même ordre et avec la même composition. Le contenu vient des champs ACF, alimentés par
 * bin/seed-fidelite-prestations.php — lui-même généré par tools/generate-prestations.mjs, qui
 * relève le texte dans le DOM rendu du prototype plutôt que de le réécrire.
 *
 * Les montants ne sont jamais figés dans le contenu : ils sont recalculés depuis
 * includes/site-options.php, seul point d'entrée du tarif.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_queried_object_id();
$site    = tfp_site_data();
$titre   = get_the_title( $post_id );
// Libellé court employé par la maquette dans le fil d'Ariane, le titre de FAQ et la relance
// (« Bureaux », pas « Nettoyage de bureaux »). Repli sur le titre complet s'il n'est pas saisi.
$court   = tfp_get_field( 'label_court', $post_id ) ?: $titre;
$prenom  = explode( ' ', $site['manager'] )[0];

$h1       = tfp_get_field( 'h1', $post_id ) ?: $titre;
$tease    = tfp_get_field( 'tease', $post_id );
$reponse  = tfp_get_field( 'reponse_directe', $post_id );
$maillage = tfp_get_field( 'maillage_texte', $post_id );

$pour_qui_titre = tfp_get_field( 'pour_qui_titre', $post_id ) ?: 'Pour qui ?';
$pour_qui       = tfp_get_lines( tfp_get_field( 'pour_qui_items', $post_id ) );
$taches_titre   = tfp_get_field( 'taches_titre', $post_id ) ?: 'Les espaces et tâches pris en charge';
$taches         = tfp_get_lines( tfp_get_field( 'taches', $post_id ) );
$hors           = tfp_get_field( 'hors_prestation', $post_id );

$exclusions_titre = tfp_get_field( 'exclusions_titre', $post_id );
$exclusions_intro = tfp_get_field( 'exclusions_intro', $post_id );
$exclusions_items = tfp_get_lines( tfp_get_field( 'exclusions_items', $post_id ) );

$situations_titre = tfp_get_field( 'situations_titre', $post_id );
$situations       = tfp_get_lines( tfp_get_field( 'situations_items', $post_id ) );
$exemple_label    = tfp_get_field( 'situations_exemple_label', $post_id ) ?: 'Exemple de planning';
$exemple          = tfp_get_field( 'situations_exemple', $post_id );

$configs_titre = tfp_get_field( 'configs_titre', $post_id );
$configs_intro = tfp_get_field( 'configs_intro', $post_id );
$configs       = tfp_get_titled_blocks( 'config', $post_id, 3 );

$detail_titre = tfp_get_field( 'detail_titre', $post_id );
$details      = tfp_get_titled_blocks( 'detail', $post_id, 9 );

$orga_titre = tfp_get_field( 'organisation_titre', $post_id );
$orga       = tfp_get_titled_blocks( 'organisation', $post_id, 6 );

$semaine_titre = tfp_get_field( 'semaine_titre', $post_id ) ?: 'Une semaine type';
$semaine       = tfp_get_field( 'semaine_type', $post_id );
$limites_titre = tfp_get_field( 'limites_titre', $post_id ) ?: 'Les limites de la prestation';
$limites       = tfp_get_field( 'limites', $post_id );

$temoignage = array(
	'texte'  => tfp_get_field( 'temoignage_texte', $post_id ),
	'auteur' => tfp_get_field( 'temoignage_auteur', $post_id ),
	'role'   => tfp_get_field( 'temoignage_role', $post_id ),
	'ville'  => tfp_get_field( 'temoignage_ville', $post_id ),
);

$villes           = tfp_get_field( 'villes_prioritaires', $post_id );
$related_articles = tfp_get_prestation_related_articles( $post_id );
$faq              = tfp_get_faq_items( 'faq', $post_id, 8 );
$faq_titre        = tfp_get_field( 'faq_titre', $post_id ) ?: 'Questions fréquentes — ' . $court;
$cta_titre        = tfp_get_field( 'cta_titre', $post_id ) ?: 'Un devis pour ' . $court;
$cta_texte        = tfp_get_field( 'cta_texte', $post_id );

$budget    = tfp_home_budget_example();
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
		'service_label' => rawurlencode( $titre ),
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

// Table de maillage de la phrase d'introduction : les expressions exactes employées par la
// maquette, associées à leur destination. Une expression absente du texte est simplement ignorée.
$ville_urls = array();
if ( ! empty( $villes ) ) {
	foreach ( $villes as $ville ) {
		$ville_urls[ get_the_title( $ville ) ] = get_permalink( $ville );
	}
}
$maillage_map = array_merge(
	array(
		'nettoyage professionnel' => home_url( '/nettoyage-professionnel/' ),
		'tarif de ' . tfp_format_price( $site['price_unique'] ) . ' HT/h' => home_url( '/tarifs/' ),
	),
	$ville_urls,
	array( $site['address_region'] => home_url( '/zones-intervention/bourgogne-franche-comte/' ) )
);
if ( ! empty( $related_articles ) ) {
	$maillage_map['à quelle fréquence faire nettoyer ses locaux'] = get_permalink( $related_articles[0] );
}

$schema = array(
	array(
		'@type'       => 'Service',
		'@id'         => trailingslashit( $site['origin'] ) . ltrim( $canonical_path, '/' ) . '#service',
		'name'        => $h1,
		'description' => $seo_desc ?: wp_trim_words( $reponse, 40 ),
		'serviceType' => $titre,
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
			array( 'label' => $court, 'url' => null ),
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
		<div class="tfp-hero__eyebrow">
			<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
			<?php tfp_google_rating_badge( 'inline' ); ?>
		</div>
		<h1><?php echo esc_html( $h1 ); ?></h1>
		<?php if ( $tease ) : ?>
			<p class="tfp-hero__lede"><?php echo esc_html( $tease ); ?></p>
		<?php endif; ?>
		<div class="tfp-flex" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => $devis_url, 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $prenom, 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
		<p class="tfp-hero__microcopy"><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h · régulier ou ponctuel · réponse sous 24 h</p>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( $image_slug, array( 'sizes' => '(max-width: 819px) 92vw, 600px', 'lcp' => true, 'alt' => tfp_get_field( 'hero_alt', $post_id ) ?: null ) ); ?>
		</div>
	</div>
</section>

<?php if ( $reponse ) : ?>
<section class="tfp-container tfp-section--tight">
	<div class="tfp-direct-answer">
		<p class="tfp-direct-answer__label">Réponse directe</p>
		<p class="tfp-direct-answer__text"><?php echo esc_html( $reponse ); ?></p>
	</div>
	<?php if ( $maillage ) : ?>
		<p class="tfp-maillage"><?php echo wp_kses_post( tfp_link_phrases( $maillage, $maillage_map ) ); ?></p>
	<?php endif; ?>
</section>
<?php endif; ?>

<?php if ( ! empty( $pour_qui ) || ! empty( $taches ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-two-col">
		<div>
			<h2><?php echo esc_html( $pour_qui_titre ); ?></h2>
			<ul class="tfp-list-plain">
				<?php foreach ( $pour_qui as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
			<div class="tfp-price-aside">
				<span class="tfp-price-aside__label">À partir de</span>
				<span class="tfp-price-aside__value"><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h</span>
				<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Détail des tarifs →</a>
			</div>
		</div>
		<div>
			<h2><?php echo esc_html( $taches_titre ); ?></h2>
			<ul class="tfp-list-marked">
				<?php foreach ( $taches as $tache ) : ?>
					<li><?php echo esc_html( $tache ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $hors ) : ?>
				<p class="tfp-note-inline"><?php echo esc_html( $hors ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $exclusions_titre && ! empty( $exclusions_items ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $exclusions_titre ); ?></h2>
		<?php if ( $exclusions_intro ) : ?>
			<p class="tfp-section__lede"><?php echo esc_html( $exclusions_intro ); ?></p>
		<?php endif; ?>
		<ul class="tfp-list-excluded">
			<?php foreach ( $exclusions_items as $item ) : ?>
				<li><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $situations ) || $exemple ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $situations_titre ?: 'Les situations concrètes que nous traitons' ); ?></h2>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:20px">
			<?php foreach ( $situations as $item ) : ?>
				<div class="tfp-card--flat"><p><?php echo esc_html( $item ); ?></p></div>
			<?php endforeach; ?>
		</div>
		<?php if ( $exemple ) : ?>
			<div class="tfp-callout">
				<strong><?php echo esc_html( $exemple_label ); ?></strong>
				<p><?php echo esc_html( $exemple ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $configs ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $configs_titre ?: 'Trois configurations, trois organisations' ); ?></h2>
		<?php if ( $configs_intro ) : ?>
			<p class="tfp-section__lede"><?php echo esc_html( $configs_intro ); ?></p>
		<?php endif; ?>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:24px">
			<?php foreach ( $configs as $config ) : ?>
				<div class="tfp-card">
					<h3><?php echo esc_html( $config['titre'] ); ?></h3>
					<p><?php echo esc_html( $config['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $detail_titre && ! empty( $details ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $detail_titre ); ?></h2>
		<div class="tfp-detail-grid">
			<?php foreach ( $details as $bloc ) : ?>
				<div class="tfp-detail-item">
					<h3><?php echo esc_html( $bloc['titre'] ); ?></h3>
					<p><?php echo esc_html( $bloc['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $orga_titre && ! empty( $orga ) ) : ?>
<section class="tfp-section--turquoise tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $orga_titre ); ?></h2>
		<div class="tfp-detail-grid">
			<?php foreach ( $orga as $bloc ) : ?>
				<div class="tfp-detail-item">
					<h3><?php echo esc_html( $bloc['titre'] ); ?></h3>
					<p><?php echo esc_html( $bloc['texte'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $semaine || $limites ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-two-col">
		<?php if ( $semaine ) : ?>
			<div>
				<h2><?php echo esc_html( $semaine_titre ); ?></h2>
				<p class="tfp-prose"><?php echo esc_html( $semaine ); ?></p>
			</div>
		<?php endif; ?>
		<?php if ( $limites ) : ?>
			<div>
				<h2><?php echo esc_html( $limites_titre ); ?></h2>
				<p class="tfp-prose"><?php echo esc_html( $limites ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--tight">
	<div class="tfp-container tfp-two-col">
		<div>
			<div class="tfp-price-example">
				<div class="tfp-price-example__label">Exemple · <?php echo (int) $budget['hours']; ?> h/mois</div>
				<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
				<div class="tfp-price-example__note">
					<?php echo (int) $budget['hours']; ?> h × <?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> + <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> de gestion.
					Le cas échéant, avec les frais de mise en place : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT
				</div>
				<div class="tfp-price-example__disclaimer">Exemple non contractuel.</div>
				<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Tous les tarifs →</a>
			</div>
		</div>
		<?php if ( $temoignage['texte'] ) : ?>
			<div>
				<?php tfp_testimonial_card( $temoignage ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $villes ) || ! empty( $related_articles ) ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-two-col">
		<?php if ( ! empty( $villes ) ) : ?>
			<div>
				<h2>Cette prestation près de chez vous</h2>
				<div class="tfp-flex" style="margin-top:16px">
					<?php foreach ( $villes as $ville ) : ?>
						<a href="<?php echo esc_url( get_permalink( $ville ) ); ?>" class="tfp-chip"><?php echo esc_html( get_the_title( $ville ) ); ?></a>
					<?php endforeach; ?>
				</div>
				<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>">Toute la <?php echo esc_html( $site['address_region'] ); ?> →</a>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $related_articles ) ) : ?>
			<div>
				<h2>À lire aussi</h2>
				<div class="tfp-stack" style="margin-top:16px">
					<?php foreach ( $related_articles as $article ) : ?>
						<a href="<?php echo esc_url( get_permalink( $article ) ); ?>" class="tfp-link-row">
							<?php echo esc_html( get_the_title( $article ) ); ?><span aria-hidden="true">→</span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $faq ) ) : ?>
<section class="tfp-section">
	<div class="tfp-container tfp-container--narrow">
		<h2><?php echo esc_html( $faq_titre ); ?></h2>
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
		<p>Encore une question sur <?php echo esc_html( $court ); ?> ? <?php echo esc_html( $prenom ); ?> vous répond directement.</p>
		<?php tfp_button( array( 'label' => 'Nous contacter', 'href' => home_url( '/contact/' ), 'variant' => 'secondary', 'size' => 'sm' ) ); ?>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2><?php echo esc_html( $cta_titre ); ?></h2>
		<p><?php echo esc_html( $cta_texte ?: ( $prenom . ' étudie votre demande et vous transmet un devis clair sous 24 heures.' ) ); ?></p>
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
