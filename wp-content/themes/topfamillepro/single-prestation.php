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

// Même règle que sur les pages de zone : les heures viennent du libellé affiché.
$budget    = tfp_budget_example( tfp_hours_from_label( tfp_get_field( 'exemple_label', $post_id ) ) );
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

/*
 * Visuel d'illustration : UN slug par prestation (G26 §3).
 *
 * Seuls « bureaux » et « commerces » avaient le leur ; les quatre autres partageaient un visuel
 * générique, quand la maquette pose six photos distinctes. L'audit par empreinte l'a montré, et
 * les six fichiers sont ceux du standalone, appariés sur leurs octets
 * (`node tools/mapper-photos-maquette.mjs`). Les `alt` restent honnêtes : ils décrivent la scène
 * et disent « photo d'illustration », jamais un local réel de l'entreprise (CLAUDE.md §5.6).
 */
$image_slug = tfp_get_field( 'image_slug', $post_id );
if ( ! $image_slug ) {
	$post_name  = get_post_field( 'post_name', $post_id );
	$candidat   = 'service-' . $post_name;
	// Le manifeste tranche : une prestation ajoutée sans photo garde le visuel générique plutôt
	// qu'une image cassée.
	$image_slug = tfp_image_exists( $candidat ) ? $candidat : 'service-generic';
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
		<div class="tfp-action-row" style="margin-top:24px">
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
<?php
/*
 * La bande « Réponse directe » du gabarit prestation vit dans un conteneur de LECTURE de 820 px
 * (relevé G23 sur la règle déclarée de la maquette), pas dans le conteneur générique de 1260 :
 * 80 px de large en plus font tenir le même texte sur une ligne de moins, et la page perdait
 * cette hauteur à 1024 px et au-delà — l'une des causes mesurées de la chute de /meubles/ à 94 %.
 */
?>
<section class="tfp-container tfp-section--tight tfp-presta-reponse" style="--container-max:820px">
	<?php
	/*
	 * La réponse directe n'est **pas** une carte dans la maquette : c'est du texte courant, précédé
	 * d'une étiquette. La carte encadrée que l'on trouve sur cette page est celle qui clôt la
	 * colonne des tâches, pas celle-ci — deux blocs voisins, deux traitements différents.
	 */
	?>
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
	<?php
	/*
	 * Bases de colonnes et bases de listes RELEVÉES sur la maquette (piste .tfp-list-plain, G22) :
	 * la colonne « Pour qui » déclare `flex: 1 1 260px; min-width: min(100%, 260px)`, la colonne
	 * des tâches `flex: 1 1 440px; min-width: min(100%, 320px)` — 474 et 654 px à 1440, jamais
	 * deux moitiés égales. La liste « Pour qui » est une COLONNE (une seule file à toutes les
	 * largeurs) ; la liste des tâches déclare une base de 230 px — pas les 320 de la règle
	 * commune — et tient ainsi deux colonnes dès 1024 px, comme la maquette. Vérifié aux six
	 * largeurs des deux côtés.
	 */
	?>
	<div class="tfp-container tfp-two-col">
		<div style="flex:1 1 260px;min-width:min(100%, 260px)">
			<h2><?php echo esc_html( $pour_qui_titre ); ?></h2>
			<ul class="tfp-list-plain tfp-list-plain--colonne">
				<?php foreach ( $pour_qui as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php tfp_price_card(); ?>
		</div>
		<div style="flex:1 1 440px;min-width:min(100%, 320px)">
			<h2><?php echo esc_html( $taches_titre ); ?></h2>
			<ul class="tfp-list-marked" style="--tfp-liste-colonne:230px">
				<?php foreach ( $taches as $tache ) : ?>
					<li><?php echo esc_html( $tache ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php
			// La maquette clôt la colonne des tâches par une carte encadrée. Le texte est relevé du
			// prototype (`note_taches`) ; `hors_prestation` sert de repli pour les contenus produits
			// avant l'ajout de ce champ.
			$hors = tfp_get_field( 'note_taches', $post_id ) ?: $hors;
			if ( $hors ) {
				?>
				<?php
				// La maquette met l'amorce de cette note en gras (« Hors prestation courante : »).
				// L'amorce n'existe pas sur toutes les prestations : on ne la fabrique pas, on la
				// détache seulement quand elle est là.
				$morceaux = preg_split( '/\s:\s/u', $hors, 2 );
				?>
				<div class="tfp-answer-card" style="margin-top:16px">
					<p class="tfp-answer-card__text" style="margin-top:0">
						<?php if ( count( $morceaux ) === 2 ) : ?>
							<strong><?php echo esc_html( $morceaux[0] ); ?> :</strong> <?php echo esc_html( $morceaux[1] ); ?>
						<?php else : ?>
							<?php echo esc_html( $hors ); ?>
						<?php endif; ?>
					</p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $exclusions_titre && ! empty( $exclusions_items ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container">
		<?php
		// Panneau sombre de la maquette : c'est la section qui dit ce que l'entreprise ne fait pas,
		// et le prototype lui donne délibérément le poids visuel le plus fort de la page. Le thème
		// la rendait en bande claire avec des puces blanches — même contenu, lu en diagonale.
		tfp_panel_exclusions( $exclusions_titre, $exclusions_intro, $exclusions_items );
		?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $situations ) || $exemple ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2><?php echo esc_html( $situations_titre ?: 'Les situations concrètes que nous traitons' ); ?></h2>
		<div class="tfp-situation-grid">
			<?php foreach ( $situations as $item ) : ?>
				<div><p><?php echo esc_html( $item ); ?></p></div>
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
		<?php // max-width 620 : déclaré par la maquette sur le H2 de cette bande — il replie le titre sur deux lignes dès 1024 px (relevé G23). ?>
		<h2 style="max-width:620px"><?php echo esc_html( $detail_titre ); ?></h2>
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
		<?php // max-width 560 : déclaré par la maquette sur le H2 de cette bande (relevé G23). ?>
		<h2 style="max-width:560px"><?php echo esc_html( $orga_titre ); ?></h2>
		<?php
		/*
		 * La bande mêle deux traitements, relevés sur la maquette : cinq blocs rangés sur une grille
		 * de quatre colonnes sans ornement, et « Absence et remplacement » en carte blanche pleine
		 * largeur. Les rendre tous pareil revenait à effacer une hiérarchie voulue.
		 */
		$orga_grille = array_values( array_filter( $orga, static function ( $b ) { return empty( $b['carte'] ); } ) );
		$orga_cartes = array_values( array_filter( $orga, static function ( $b ) { return ! empty( $b['carte'] ); } ) );
		?>
		<?php if ( $orga_grille ) : ?>
			<div class="tfp-detail-grid tfp-detail-grid--orga">
				<?php foreach ( $orga_grille as $bloc ) : ?>
					<div class="tfp-detail-item">
						<h3><?php echo esc_html( $bloc['titre'] ); ?></h3>
						<p><?php echo esc_html( $bloc['texte'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php foreach ( $orga_cartes as $bloc ) : ?>
			<div class="tfp-detail-item tfp-detail-item--carte">
				<h3><?php echo esc_html( $bloc['titre'] ); ?></h3>
				<p><?php echo esc_html( $bloc['texte'] ); ?></p>
			</div>
		<?php endforeach; ?>
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
				<?php tfp_note_card( $limites ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php
/*
 * Bande « Exemple tarifaire + avis », relevée sur la maquette (G23) : rangée flex align-items:
 * center à l'écart clamp(28px, 4vw, 48px), carte Exemple en ENFANT DIRECT (flex 1 1 300,
 * rembourrage 28, rayon 18, montant 38 px en bleu principal), témoignage nu en enfant direct
 * (flex 1 1 360). Le composant générique .tfp-two-col, avec ses conteneurs intermédiaires de
 * hauteurs voisines, faisait partager leur ordonnée aux deux boîtes : deux colonnes comptées là
 * où la maquette, centrant deux boîtes de hauteurs franchement différentes, n'en compte qu'une.
 */
?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-presta-tarif">
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
		<?php if ( $temoignage['texte'] ) : ?>
			<div class="tfp-testimonial--plain">
				<?php
				// Sur une page prestation, la maquette pose le témoignage à plat — étoiles, citation,
				// attribution — sans fond ni filet. Le composant en carte est employé ailleurs
				// (accueil, page de devis), là où la maquette l'encadre effectivement.
				tfp_testimonial_card( $temoignage );
				?>
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
				<?php
				tfp_chip_list(
					array_map(
						static function ( $ville ) {
							return array( 'texte' => get_the_title( $ville ), 'url' => get_permalink( $ville ) );
						},
						$villes
					)
				);
				?>
				<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>">Toute la <?php echo esc_html( $site['address_region'] ); ?> →</a>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $related_articles ) ) : ?>
			<div>
				<h2>À lire aussi</h2>
				<?php
				tfp_link_cards(
					array_map(
						static function ( $article ) {
							return array( 'texte' => get_the_title( $article ), 'url' => get_permalink( $article ) );
						},
						$related_articles
					)
				);
				?>
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
				<details class="tfp-card tfp-faq-item">
					<summary><?php echo esc_html( $item['question'] ); ?></summary>
					<p><?php echo esc_html( $item['reponse'] ); ?></p>
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
