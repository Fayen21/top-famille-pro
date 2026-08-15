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

/* Contenu repris de la maquette Claude Design (bin/seed-fidelite-zones.php, généré par
   tools/generate-zones.mjs). Les trois niveaux partagent la même structure : un récit, un bloc
   tarifaire, un bloc méthode, et des groupes de liens dont la position varie — d'où
   `locaux_avant_tarif`, qui dit combien de groupes précèdent le bloc tarifaire. */
$hero_lede       = tfp_get_field( 'hero_lede', $post_id );
$hero_alt        = tfp_get_field( 'hero_alt', $post_id );
$cta_phone_label = tfp_get_field( 'cta_phone_label', $post_id ) ?: '☎ Appeler ' . $site['manager'];
$band_items      = tfp_get_lines( tfp_get_field( 'band_items', $post_id ) );
$recit           = tfp_get_zone_blocks( 'recit', $post_id, 6 );
$methode         = tfp_get_zone_blocks( 'methode', $post_id, 4 );
$groupes_liens   = tfp_get_zone_blocks( 'locaux', $post_id, 8 );
$avant_tarif     = (int) tfp_get_field( 'locaux_avant_tarif', $post_id );
$tarif_titre     = tfp_get_field( 'tarif_titre', $post_id );
$tarif_texte     = tfp_get_lines( tfp_get_field( 'tarif_texte', $post_id ) );
$exemple_label   = tfp_get_field( 'exemple_label', $post_id );
$temoignage      = array(
	'texte'  => tfp_get_field( 'temoignage_texte', $post_id ),
	'auteur' => tfp_get_field( 'temoignage_auteur', $post_id ),
	'role'   => tfp_get_field( 'temoignage_role', $post_id ),
);
$faq_titre       = tfp_get_field( 'faq_titre', $post_id ) ?: 'Questions fréquentes — ' . get_the_title( $post_id );
$contact_titre   = tfp_get_field( 'contact_titre', $post_id );
$contact_texte   = tfp_get_field( 'contact_texte', $post_id );
$cta_titre       = tfp_get_field( 'cta_titre', $post_id ) ?: $cta_label;
$cta_texte       = tfp_get_field( 'cta_texte', $post_id );
/*
 * Le montant est calculé d'après les heures annoncées par le **libellé de cette zone**, et non
 * d'après un exemple fixe : chaque zone porte son propre volume (« 8 h/mois », « 16 h/mois »…) et
 * afficher partout le total d'un exemple à 12 heures contredisait le libellé voisin.
 */
$budget          = tfp_budget_example( tfp_hours_from_label( $exemple_label ) );

/* Cibles réelles des groupes de liens, reconstruites depuis le contenu WordPress : la maquette
   pointe vers des routes `#/`, jamais reprises telles quelles. */
$toutes_prestations = get_posts( array( 'post_type' => 'prestation', 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );

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

// Contexte transmis au formulaire de devis (préremplissage, src/js/quote-form.js).
$devis_args = $is_dept
	? array( 'departement' => get_the_title( $post_id ) )
	: array(
		'ville'       => get_the_title( $post_id ),
		'departement' => $dept_term ? $dept_term->name : '',
	);
$devis_url = add_query_arg( array_map( 'rawurlencode', array_filter( $devis_args ) ), home_url( '/demande-de-devis/' ) );

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

<section class="tfp-hero<?php echo $hero_alt ? '' : ' tfp-hero--text'; ?>">
	<div class="tfp-hero__content">
		<div class="tfp-hero__eyebrow">
			<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
			<?php tfp_google_rating_badge( 'inline' ); ?>
		</div>
		<h1><?php echo esc_html( $h1 ); ?></h1>
		<?php if ( $hero_lede ) : ?>
			<p class="tfp-hero__lede"><?php echo esc_html( $hero_lede ); ?></p>
		<?php endif; ?>
		<div class="tfp-action-row" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => $cta_label, 'href' => $devis_url, 'variant' => 'primary' ) );
			tfp_button( array( 'label' => $cta_phone_label, 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<?php if ( $hero_alt ) : ?>
		<div class="tfp-hero__media">
			<div class="tfp-hero__media-main">
				<?php tfp_picture( 'article-3', array( 'sizes' => '(max-width: 819px) 92vw, 560px', 'lcp' => true, 'alt' => $hero_alt ) ); ?>
			</div>
		</div>
	<?php endif; ?>
</section>

<section class="tfp-container tfp-section--tight">
	<?php
	/*
	 * Bandeau tarifaire. Deux lignes dans la maquette : la pastille de prix et les trois garanties
	 * sur la première, le renvoi vers les tarifs seul et aligné à droite sur la seconde. La
	 * rangée est explicite ici plutôt que laissée au retour à la ligne d'un `flex-wrap` : ce
	 * dernier faisait dépendre la mise en page de la largeur du plus long libellé.
	 */
	?>
	<div class="tfp-zone-band">
		<div class="tfp-zone-band__row">
			<div class="tfp-zone-band__price">
				<strong><?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/h</strong>
				<span>tarif unique en région</span>
			</div>
			<div class="tfp-zone-band__items">
				<?php foreach ( $band_items as $item ) : ?>
					<?php tfp_check_item( $item ); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Voir les tarifs →</a>
	</div>
</section>

<?php if ( $reponse ) : ?>
<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<div class="tfp-direct-answer">
			<p class="tfp-direct-answer__label">Réponse directe</p>
			<p class="tfp-direct-answer__text"><?php echo esc_html( $reponse ); ?></p>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $recit ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<?php foreach ( $recit as $bloc ) : ?>
			<div class="tfp-zone-chapter">
				<h2><?php echo esc_html( $bloc['titre'] ); ?></h2>
				<?php foreach ( $bloc['textes'] as $texte ) : ?>
					<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $bloc['liste'] ) ) : ?>
					<ul class="tfp-list-plain">
						<?php foreach ( $bloc['liste'] as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php
/**
 * Rend un groupe de liens de la maquette. Les cibles ne sont jamais celles du prototype
 * (routes `#/`) : elles sont reconstruites depuis le contenu WordPress réel. Un nom sans page
 * dédiée reste du texte — jamais un lien mort (CLAUDE.md §8).
 */
$render_group = function ( array $bloc ) use ( $toutes_prestations, $cities_in_dept, $communes_proches, $dept_post, $is_dept ) {
	?>
	<div class="tfp-zone-links<?php echo 3 === (int) ( $bloc['niveau'] ?? 2 ) ? ' tfp-zone-links--sous' : ''; ?>">
		<?php
		/*
		 * Le titre garde le niveau relevé sur la maquette : « Communes secondaires documentées » y
		 * est un `h3` sous « Nos villes d'intervention dans le département », pas un `h2` de plus.
		 * Le promouvoir cassait la hiérarchie des titres et, par ricochet, la mise en colonnes.
		 */
		$balise_groupe = 3 === (int) ( $bloc['niveau'] ?? 2 ) ? 'h3' : 'h2';
		printf( '<%1$s>%2$s</%1$s>', $balise_groupe, esc_html( $bloc['titre'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput
		?>
		<?php foreach ( $bloc['textes'] as $texte ) : ?>
			<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
		<?php endforeach; ?>
		<?php if ( 'prestations' === $bloc['type'] && 'cartes' === $bloc['variante'] ) : ?>
			<?php
			/*
			 * Bande sombre « Nos prestations sur place » : la maquette la pose sur fond marine avec
			 * six tuiles bleues (285×147, fond #174A81, rayon 14, filet #1E5C9E, rembourrage 20,
			 * quatre colonnes, écart 13). Le thème la rendait en bande claire avec des cartes
			 * blanches — même contenu, tout autre poids visuel, et une section de maillage qui se
			 * confondait avec le corps de page.
			 *
			 * Le texte de la tuile est le **résumé court** relevé sur la maquette (« Open-spaces,
			 * salles de réunion, accueil »), pas l'accroche complète de la page prestation, qui fait
			 * trois lignes et déformerait la grille.
			 */
			?>
			<div class="tfp-service-tiles">
				<?php foreach ( $toutes_prestations as $prestation ) : ?>
					<a class="tfp-service-tile" href="<?php echo esc_url( get_permalink( $prestation ) ); ?>">
						<strong><?php echo esc_html( tfp_get_field( 'nav_label', $prestation->ID ) ?: get_the_title( $prestation ) ); ?></strong>
						<span><?php echo esc_html( tfp_get_field( 'resume_court', $prestation->ID ) ?: tfp_get_field( 'tease', $prestation->ID ) ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php elseif ( 'prestations' === $bloc['type'] ) : ?>
			<?php
			/*
			 * Panneau de maillage vers les six prestations.
			 *
			 * Ce n'est pas une simple pile de liens : la maquette pose un panneau de 566×338, fond
			 * #DCE7EB, rayon 14, dont les six rangées sont blanches (564×55, rembourrage 15/18) et
			 * séparées par un filet d'un pixel obtenu par l'écart de la colonne. Rendu en liens nus,
			 * le bloc perdait son poids visuel et se confondait avec le corps de page — c'est
			 * pourtant le seul composant de maillage de la bande.
			 */
			?>
			<div class="tfp-link-panel">
				<?php foreach ( $toutes_prestations as $prestation ) : ?>
					<a class="tfp-link-row tfp-link-row--panel" href="<?php echo esc_url( get_permalink( $prestation ) ); ?>">
						<?php echo esc_html( tfp_get_field( 'nav_label', $prestation->ID ) ?: get_the_title( $prestation ) ); ?><span aria-hidden="true">→</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php elseif ( 'villes' === $bloc['type'] ) : ?>
			<?php
			/*
			 * Écart déclaré par le prototype : 8 px, vérifié sur la rangée de communes des 18 pages
			 * ville et commune à 1440 px (gap déclaré « 8px » partout, jamais 9). Le « 9 px communes
			 * proches » du relevé G09 appartient à une autre rangée — les villes voisines d'un autre
			 * département — et la classe `--9` posée ici coupait la rangée un cran plus tôt que la
			 * maquette sur les noms longs.
			 *
			 * Sur une page de ville, la maquette pose les communes SANS page dédiée dans la MÊME
			 * rangée que les liens (13 membres d'un tenant sur Dijon), en 400 là où les liens sont
			 * en 600. Le thème les rendait dans une seconde rangée : chaque pastille changeait de
			 * rang, et l'inventaire comptait 32 écarts de colonnes. Les noms rejoignent donc la
			 * rangée des liens — l'ordre de la maquette — et restent des pastilles inertes
			 * (`--static`), jamais des liens morts (CLAUDE.md §8). Les pages de département gardent
			 * leur rangée séparée : c'est la structure que la maquette y déclare (sous-groupe h3).
			 */
			?>
			<div class="tfp-chip-row" style="margin-top:16px">
				<?php
				$cibles = ! empty( $cities_in_dept ) ? $cities_in_dept : (array) $communes_proches;
				foreach ( $cibles as $cible ) :
					?>
					<a class="tfp-chip" href="<?php echo esc_url( get_permalink( $cible ) ); ?>"><?php echo esc_html( get_the_title( $cible ) ); ?></a>
				<?php endforeach; ?>
				<?php if ( ! $is_dept && ! empty( $bloc['noms'] ) ) : ?>
					<?php foreach ( (array) $bloc['noms'] as $nom ) : ?>
						<span class="tfp-chip tfp-chip--static"><?php echo esc_html( $nom ); ?></span>
					<?php endforeach; ?>
					<?php $bloc['noms'] = array(); ?>
				<?php endif; ?>
			</div>
		<?php elseif ( 'departements' === $bloc['type'] ) : ?>
			<div class="tfp-chip-row tfp-chip-row--10" style="margin-top:16px">
				<?php foreach ( tfp_footer_zones_tree() as $entry ) : ?>
					<?php if ( ! $dept_post || $entry['post']->ID !== $dept_post->ID ) : ?>
						<a class="tfp-chip" href="<?php echo esc_url( get_permalink( $entry['post'] ) ); ?>"><?php echo esc_html( get_the_title( $entry['post'] ) ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php elseif ( 'liens' === $bloc['type'] ) : ?>
			<div class="tfp-stack" style="margin-top:16px">
				<a class="tfp-link-row" href="<?php echo esc_url( home_url( '/prestations/' ) ); ?>">Découvrir nos prestations<span aria-hidden="true">→</span></a>
				<a class="tfp-link-row" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Voir les tarifs<span aria-hidden="true">→</span></a>
				<a class="tfp-link-row" href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>">Notre fonctionnement<span aria-hidden="true">→</span></a>
				<a class="tfp-link-row" href="<?php echo esc_url( home_url( '/demande-de-devis/' ) ); ?>">Demander mon devis<span aria-hidden="true">→</span></a>
				<a class="tfp-link-row" href="<?php echo esc_url( home_url( '/conseils/' ) ); ?>">Nos guides d'entretien<span aria-hidden="true">→</span></a>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $bloc['noms'] ) ) : ?>
			<div class="tfp-chip-row" style="margin-top:16px">
				<?php foreach ( $bloc['noms'] as $nom ) : ?>
					<span class="tfp-chip tfp-chip--static"><?php echo esc_html( $nom ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
};

$groupes_avant = array_slice( $groupes_liens, 0, $avant_tarif );
$groupes_apres = array_slice( $groupes_liens, $avant_tarif );
?>

<?php
/**
 * Rend une suite de groupes en respectant le découpage en sections de la maquette : deux groupes
 * qui y partagent une même bande de fond restent dans la même `<section>`.
 */
$render_sections = function ( array $groupes, $classe ) use ( $render_group, $is_dept ) {
	$courante = null;
	$ouverte  = false;
	$colonne  = false;
	foreach ( $groupes as $bloc ) {
		if ( $bloc['section'] !== $courante ) {
			if ( $ouverte ) {
				if ( $colonne ) {
					echo '</div>';
					$colonne = false;
				}
				echo '</div></div></section>';
			}
			/*
			 * Nombre de colonnes de la bande : **un par groupe de premier rang**, pas un par groupe.
			 *
			 * Sur une page de département, la maquette pose deux colonnes de 566 px — « Nos villes
			 * d'intervention » à gauche, avec ses deux sous-groupes h3 empilés dessous, et « Nos
			 * prestations » à droite. Compter les sous-groupes donnait quatre colonnes de 265 px :
			 * les pastilles de communes tombaient à une ou deux par ligne au lieu de quatre, et la
			 * bande ne ressemblait plus à la maquette malgré une hauteur voisine.
			 */
			$nb = count( array_filter( $groupes, function ( $g ) use ( $bloc ) {
				return $g['section'] === $bloc['section'] && 3 !== (int) ( $g['niveau'] ?? 2 );
			} ) );
			/*
			 * La bande qui porte les six prestations en tuiles est posée sur fond marine dans la
			 * maquette, pas sur le fond de page : c'est une bande de maillage, et le prototype la
			 * détache franchement du corps de texte. Les autres bandes gardent leur fond.
			 */
			$fond = $classe;
			if ( 'prestations' === $bloc['type'] && 'cartes' === $bloc['variante'] ) {
				$fond = trim( str_replace( array( 'tfp-section--alt', 'tfp-section--turquoise' ), '', $classe ) . ' tfp-section--navy' );
			}
			/*
			 * Variante de base de colonne : le prototype en déclare une par bande, pas une pour
			 * toutes (voir `.tfp-zone-links-grid` dans 04-components.css). Les trois variantes se
			 * distinguent par le niveau de la zone et le nombre de colonnes, correspondance vérifiée
			 * régulière sur les 26 pages de zone.
			 */
			$grille = 'tfp-zone-links-grid';
			if ( $is_dept ) {
				$grille .= ' tfp-zone-links-grid--dept';
			} elseif ( 3 === $nb ) {
				$grille .= ' tfp-zone-links-grid--trois';
			}
			printf(
				'<section class="%s"><div class="tfp-container"><div class="%s">',
				esc_attr( $fond ),
				esc_attr( $nb > 1 ? $grille : '' )
			);
			$courante = $bloc['section'];
			$ouverte  = true;
		}
		// Un groupe de premier rang ouvre une colonne ; les sous-groupes s'empilent dans la sienne.
		if ( 3 !== (int) ( $bloc['niveau'] ?? 2 ) ) {
			if ( $colonne ) {
				echo '</div>';
			}
			echo '<div class="tfp-zone-col">';
			$colonne = true;
		}
		$render_group( $bloc );
	}
	if ( $ouverte ) {
		if ( $colonne ) {
			echo '</div>';
		}
		echo '</div></div></section>';
	}
};
?>

<?php if ( ! empty( $groupes_avant ) ) : ?>
	<?php $render_sections( $groupes_avant, 'tfp-section--tight' ); ?>
<?php endif; ?>

<?php if ( $tarif_titre ) : ?>
<section class="tfp-section--turquoise tfp-section--tight">
	<?php
	/*
	 * Bande tarifaire d'une page de zone : **trois colonnes**, pas deux.
	 *
	 * Relevé à 1440 px sur la maquette : texte 394 px, carte d'exemple 344 px (blanche, rayon 16),
	 * témoignage 374 px (blanc, rayon 16), écart 34. Le gabarit empilait l'exemple et le témoignage
	 * dans une seule colonne de droite : même contenu, mais une bande deux fois plus haute et deux
	 * cartes deux fois plus étroites que dans le prototype.
	 */
	?>
	<div class="tfp-container tfp-zone-tarif">
		<div>
			<h2><?php echo esc_html( $tarif_titre ); ?></h2>
			<?php foreach ( $tarif_texte as $texte ) : ?>
				<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
			<?php endforeach; ?>
			<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Voir les tarifs →</a>
		</div>
		<?php if ( $exemple_label ) : ?>
			<div class="tfp-price-example">
				<div class="tfp-price-example__label"><?php echo esc_html( $exemple_label ); ?></div>
				<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
				<?php
				// Phrase qui explique d'où sort le montant (« Trois passages de 1 h par semaine… ») :
				// elle appartient à la carte dans la maquette, où elle justifie le chiffre affiché
				// juste au-dessus. Le gabarit la rendait dans la colonne de texte, loin du montant.
				$exemple_texte = tfp_get_field( 'exemple_texte', $post_id );
				if ( $exemple_texte ) :
					?>
					<p class="tfp-price-example__why"><?php echo esc_html( $exemple_texte ); ?></p>
				<?php endif; ?>
				<div class="tfp-price-example__disclaimer">Exemple non contractuel.</div>
			</div>
		<?php endif; ?>
		<?php if ( $temoignage['texte'] ) : ?>
			<?php tfp_testimonial_card( $temoignage ); ?>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $methode ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<?php foreach ( $methode as $bloc ) : ?>
			<div class="tfp-zone-chapter">
				<h2><?php echo esc_html( $bloc['titre'] ); ?></h2>
				<?php foreach ( $bloc['textes'] as $texte ) : ?>
					<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $bloc['liste'] ) ) : ?>
					<ul class="tfp-list-plain">
						<?php foreach ( $bloc['liste'] as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $groupes_apres ) ) : ?>
	<?php $render_sections( $groupes_apres, 'tfp-section--alt tfp-section--tight' ); ?>
<?php endif; ?>

<?php if ( ! empty( $faq ) ) : ?>
<section class="tfp-section--turquoise tfp-section--tight">
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

<?php if ( $contact_titre ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<h2><?php echo esc_html( $contact_titre ); ?></h2>
		<p class="tfp-prose"><?php echo esc_html( $contact_texte ); ?></p>
	</div>
</section>
<?php endif; ?>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2><?php echo esc_html( $cta_titre ); ?></h2>
		<p><?php echo esc_html( $cta_texte ?: 'Gratuit, sous 24 h, sans engagement.' ); ?></p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => $cta_label, 'href' => $devis_url, 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => $cta_phone_label . ' · ' . $site['phone'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>
<?php
get_footer();
