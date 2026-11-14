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
// Objet en toutes lettres (« le nettoyage de vos bureaux ») : plus de « Un devis pour Bureaux ».
$objet            = tfp_get_field( 'objet_editorial', $post_id ) ?: mb_strtolower( $titre );
$cta_titre        = tfp_get_field( 'cta_titre', $post_id ) ?: 'Un devis pour ' . $objet . ' ?';
$cta_texte        = tfp_get_field( 'cta_texte', $post_id );

// Même règle que sur les pages de zone : les heures viennent du libellé affiché.
$exemple_mode   = tfp_get_field( 'exemple_mode', $post_id ) ?: 'mensuel';
$exemple_heures = (int) tfp_get_field( 'exemple_heures', $post_id );
$budget         = tfp_budget_example( $exemple_heures ?: tfp_hours_from_label( tfp_get_field( 'exemple_label', $post_id ) ) );
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
			tfp_bouton_appel( array( 'variant' => 'secondary' ) );
			?>
		</div>
		<p class="tfp-hero__microcopy"><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h · régulier ou ponctuel · réponse sous 24 h</p>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php
			// Passe commerciale du 10 novembre 2026 : le texte alternatif décrit la PHOTO (manifeste
			// d'images, « … (photo d'illustration) »), pas la prestation — une photo de couloir ne
			// doit pas être annoncée comme « parties communes de copropriété ».
			tfp_picture( $image_slug, array( 'sizes' => '(max-width: 819px) 92vw, 600px', 'lcp' => true ) );
			?>
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

<?php
/*
 * Corps de page — passe commerciale du 10 novembre 2026 (§4, §5, §7).
 *
 * Avant : treize bandes, dont quatre décrivaient le même plateau type (« exemple de planning »,
 * « configurations », « exemple de cahier des charges », « semaine type ») et trois revenaient sur
 * les clés, l'intervenant habituel et le cahier de liaison déjà traités par la FAQ ; 13 000 px à
 * 375 px. Après : l'essentiel d'abord, dans l'ordre où un client le cherche — ce qui est fait,
 * comment les passages s'organisent, ce que cela coûte et ce que couvre le prix, comment le suivi
 * fonctionne, ce qui est exclu — puis le détail dans des volets <details> : tout le contenu reste
 * dans le HTML, lisible sans JavaScript et au clavier, et n'encombre plus la lecture.
 *
 * Retiré de l'affichage : le bloc d'organisation intitulé « Suivi » (l'exemple de suivi le montre)
 * et la carte tarifaire de la colonne « Pour qui » (le tarif a sa section, avec son périmètre).
 */
$orga_affiches = array_values(
	array_filter(
		$orga,
		static function ( $b ) {
			return 0 !== stripos( trim( $b['titre'] ), 'Suivi' );
		}
	)
);
$suivi_lignes = tfp_get_lines( tfp_get_field( 'suivi_exemple', $post_id ) );
$sommaire     = array_filter(
	array(
		'essentiel'    => ( ! empty( $pour_qui ) || ! empty( $taches ) ) ? 'L’essentiel' : '',
		'organisation' => $semaine ? 'Organisation des passages' : '',
		'tarif'        => 'Tarif',
		'suivi'        => $suivi_lignes ? 'Suivi' : '',
		'limites'      => ( $limites || $exclusions_items ) ? 'Limites' : '',
		'details'      => 'Dans le détail',
		'questions'    => ! empty( $faq ) ? 'Questions' : '',
	)
);
?>
<nav class="tfp-container tfp-sur-page" aria-label="Sur cette page">
	<p class="tfp-sur-page__titre">Sur cette page</p>
	<ul>
		<?php foreach ( $sommaire as $ancre => $libelle ) : ?>
			<li><a href="#<?php echo esc_attr( $ancre ); ?>"><?php echo esc_html( $libelle ); ?></a></li>
		<?php endforeach; ?>
		<li><a href="<?php echo esc_url( $devis_url ); ?>">Devis</a></li>
	</ul>
</nav>

<?php if ( ! empty( $pour_qui ) || ! empty( $taches ) ) : ?>
<section class="tfp-section--tight" id="essentiel">
	<div class="tfp-container tfp-two-col">
		<div style="flex:1 1 260px;min-width:min(100%, 260px)">
			<h2><?php echo esc_html( $pour_qui_titre ); ?></h2>
			<ul class="tfp-list-plain tfp-list-plain--colonne">
				<?php foreach ( $pour_qui as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div style="flex:1 1 440px;min-width:min(100%, 320px)">
			<h2><?php echo esc_html( $taches_titre ); ?></h2>
			<ul class="tfp-list-marked" style="--tfp-liste-colonne:230px">
				<?php foreach ( $taches as $tache ) : ?>
					<li><?php echo esc_html( $tache ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php
			$hors = tfp_get_field( 'note_taches', $post_id ) ?: $hors;
			if ( $hors ) {
				// L'amorce (« Hors prestation courante : ») est mise en gras quand elle existe.
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

<?php if ( $semaine ) : ?>
<section class="tfp-section--alt tfp-section--tight" id="organisation">
	<div class="tfp-container">
		<h2><?php echo esc_html( $semaine_titre ); ?></h2>
		<p class="tfp-prose" style="max-width:820px"><?php echo esc_html( $semaine ); ?></p>
		<?php if ( ! empty( $configs ) ) : ?>
			<h3 class="tfp-row-heading" style="margin-top:28px"><?php echo esc_html( $configs_titre ?: 'Trois configurations, trois organisations' ); ?></h3>
			<div class="tfp-grid tfp-grid--autofit-lg">
				<?php foreach ( $configs as $config ) : ?>
					<div class="tfp-card">
						<h4 class="tfp-card__titre"><?php echo esc_html( $config['titre'] ); ?></h4>
						<p><?php echo esc_html( $config['texte'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--tight" id="tarif">
	<div class="tfp-container">
		<h2>Tarif et exemple</h2>
		<?php tfp_perimetre_prix( '', true, 'intervention' === $exemple_mode ); ?>
	</div>
	<div class="tfp-container tfp-presta-tarif" style="margin-top:24px">
		<div class="tfp-price-example">
			<?php if ( 'intervention' === $exemple_mode ) : ?>
				<?php
				/*
				 * Intervention UNIQUE — revue du 25 octobre 2026. La carte réutilisait le modèle du
				 * contrat régulier : « 12 h/mois, 333 € HT/mois, 9 € de gestion, premier mois 383 € »
				 * sur un nettoyage ponctuel. Ici, seule la main-d'œuvre est chiffrée (heures × tarif
				 * unique, tfp_intervention_example()) ; les autres frais ne sont ni inventés ni
				 * appliqués d'office : ils sont nommés et renvoyés au devis.
				 */
				$intervention = tfp_intervention_example( $budget['hours'] );
				?>
				<div class="tfp-price-example__label">Exemple · intervention unique de <?php echo (int) $intervention['hours']; ?> h</div>
				<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $intervention['labour'] ) ); ?> <span>HT de main-d’œuvre</span></div>
				<div class="tfp-price-example__note">
					<?php echo (int) $intervention['hours']; ?> h × <?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h. Aucun frais de gestion mensuel : ils concernent les contrats réguliers.
					Frais de mise en place, indemnités kilométriques (<?php echo esc_html( $site['price_km_display'] ); ?> HT/km) ou majoration de <?php echo (int) $site['price_majoration_pct']; ?> % (dimanche, jour férié, nuit) : indiqués au devis s’ils s’appliquent.
				</div>
			<?php else : ?>
			<div class="tfp-price-example__label">Exemple · <?php echo (int) $budget['hours']; ?> h/mois</div>
			<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
			<div class="tfp-price-example__note">
				<?php echo (int) $budget['hours']; ?> h × <?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> + <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> de gestion.
				Le cas échéant, avec les frais de mise en place : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT
			</div>
			<?php endif; ?>
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

<?php
if ( $suivi_lignes ) {
	tfp_exemple_suivi( $suivi_lignes );
}
?>

<?php if ( $limites || ( $exclusions_titre && ! empty( $exclusions_items ) ) ) : ?>
<section class="tfp-section--tight" id="limites">
	<div class="tfp-container">
		<?php if ( $exclusions_titre && ! empty( $exclusions_items ) ) : ?>
			<?php tfp_panel_exclusions( $exclusions_titre, $exclusions_intro, $exclusions_items ); ?>
		<?php endif; ?>
		<?php if ( $limites ) : ?>
			<h2 style="margin-top:32px"><?php echo esc_html( $limites_titre ); ?></h2>
			<?php tfp_note_card( $limites ); ?>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--alt tfp-section--tight" id="details">
	<div class="tfp-container">
		<h2>Dans le détail</h2>
		<p class="tfp-section__lede">Situations, espaces et organisation : ouvrez le point qui vous concerne.</p>
		<div class="tfp-volets">
			<?php if ( ! empty( $situations ) || $exemple ) : ?>
				<details class="tfp-volet">
					<summary><h3><?php echo esc_html( $situations_titre ?: 'Les situations concrètes que nous traitons' ); ?></h3></summary>
					<div class="tfp-volet__corps">
						<?php foreach ( $situations as $item ) : ?>
							<p><?php echo esc_html( $item ); ?></p>
						<?php endforeach; ?>
						<?php if ( $exemple ) : ?>
							<p><strong><?php echo esc_html( $exemple_label ); ?> :</strong> <?php echo esc_html( preg_replace( '/^' . preg_quote( $exemple_label, '/' ) . '\s*:?\s*/u', '', $exemple ) ); ?></p>
						<?php endif; ?>
					</div>
				</details>
			<?php endif; ?>
			<?php foreach ( $details as $bloc ) : ?>
				<details class="tfp-volet">
					<summary><h3><?php echo esc_html( $bloc['titre'] ); ?></h3></summary>
					<div class="tfp-volet__corps"><p><?php echo esc_html( $bloc['texte'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
			<?php foreach ( $orga_affiches as $bloc ) : ?>
				<details class="tfp-volet">
					<summary><h3><?php echo esc_html( $bloc['titre'] ); ?></h3></summary>
					<div class="tfp-volet__corps"><p><?php echo esc_html( $bloc['texte'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
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
							return array( 'texte' => tfp_espaces_insecables( get_the_title( $article ) ), 'url' => get_permalink( $article ) );
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
<section class="tfp-section" id="questions">
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
		<p>Encore une question sur <?php echo esc_html( $objet ); ?> ? <?php echo esc_html( $prenom ); ?> vous répond directement.</p>
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
			tfp_bouton_appel( array( 'variant' => 'on-dark', 'numero' => true ) );
			?>
		</div>
	</div>
</section>
<?php
get_footer();
