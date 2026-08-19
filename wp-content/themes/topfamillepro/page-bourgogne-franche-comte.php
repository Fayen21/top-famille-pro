<?php
/**
 * Page statique « région » (/zones-intervention/bourgogne-franche-comte/) — gabarit dédié
 * (CLAUDE.md §3), page enfant de « Zones d'intervention » dans la hiérarchie WordPress.
 *
 * Contenu repris du prototype (REGION_PAGE), corrigé : tarif fictif « 27 € HT/h » retiré partout,
 * exemple de budget recalculé sur le tarif réel via tfp_home_budget_example() (même valeur que
 * l'accueil : 321 € HT/mois, pas les 333 € du prototype calculés sur le tarif fictif), avis de
 * démonstration (« Sophie M. ») retiré. Title raccourci à 58 caractères (68c dans le prototype,
 * docs/INVENTAIRE-ROUTES.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$budget = tfp_home_budget_example();
$departements = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'departement', 'orderby' => 'title', 'order' => 'ASC' ) );

$faqs = array(
	array( 'q' => 'Intervenez-vous dans les huit départements de la région ?', 'a' => "Oui : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne et Territoire de Belfort. En revanche, nous n'intervenons pas en dehors de la {$site['address_region']}." ),
	array( 'q' => 'Où est réellement située l\'entreprise ?', 'a' => "À {$site['address_city']} ({$site['address_cp']}), commune limitrophe de Dijon, en Côte-d'Or. C'est notre unique implantation : nous n'avons pas d'agences dans les autres villes de la région." ),
	array( 'q' => 'Le tarif est-il le même dans tous les départements ?', 'a' => "Oui, la grille tarifaire est identique partout — voir la page Tarifs — en régulier comme en ponctuel. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Aurai-je toujours le même intervenant ?', 'a' => "C'est ce que nous recherchons pour chaque site, car la régularité fait la qualité. Nous ne le garantissons pas : en cas d'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement." ),
	array( 'q' => 'Faites-vous du nettoyage industriel ou hospitalier ?', 'a' => "Non. Nous intervenons sur les bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants. Le nettoyage industriel lourd, l'agroalimentaire spécialisé, le bio-nettoyage hospitalier et le désamiantage ne font pas partie de notre offre." ),
	array( 'q' => 'Faut-il signer un engagement de durée ?', 'a' => "Le devis est gratuit et sans engagement. Pour la prestation, le volume d'heures et la fréquence peuvent être ajustés, et les conditions d'arrêt figurent au devis avant signature." ),
	array( 'q' => 'Qui contacter pour un site situé loin de Dijon ?', 'a' => "La même personne : {$site['manager']}, au {$site['phone']}. Nous n'utilisons pas de numéro local différent selon la ville, et votre dossier n'est pas transféré à un autre interlocuteur." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ) . '#faq',
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
		'title'       => 'Nettoyage pro en Bourgogne-Franche-Comté | ' . $site['brand_name'],
		'description' => "Entretien régulier ou ponctuel de locaux professionnels dans toute la {$site['address_region']}, au même tarif partout.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => "Zones d'intervention", 'url' => home_url( '/zones-intervention/' ) ),
			array( 'label' => $site['address_region'], 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'bourgogne-franche-comte' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-hero">
	<div class="tfp-hero__content">
		<div class="tfp-hero__eyebrow">
			<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
			<?php tfp_google_rating_badge( 'nu' ); ?>
		</div>
		<h1><?php echo esc_html( $page['h1'] ); ?></h1>
		<?php foreach ( $page['lede'] as $lede ) : ?>
			<p class="tfp-section__lede"><?php echo esc_html( $lede ); ?></p>
		<?php endforeach; ?>
		<div class="tfp-action-row" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php
			/*
			 * Visuel de hero. La maquette en pose un sur cette route ; le thème n'en rendait
			 * aucun, et le rembourrage de bande en trop masquait le manque jusqu'à G13.
			 *
			 * L'`alt` vient du manifeste et n'est PAS celui de la maquette : celui-ci présente
			 * une photo de stock comme une personne réelle de l'entreprise, ce que
			 * CLAUDE.md §5.6 interdit. Le manifeste dit « photo d'illustration », ce qui est vrai.
			 */
			tfp_picture( 'hero-region', array( 'sizes' => '(max-width: 819px) 92vw, 560px', 'lcp' => true ) );
			?>
		</div>
	</div>
</section>

<?php
/*
 * La bande tarifaire (section 8 du relevé) reprend dans la maquette l'architecture
 * `.tfp-zone-tarif` des pages de zone : trois colonnes — texte, carte d'exemple
 * (flex 1 1 250px, min 260 relevés G22), témoignage — d'ordonnée partagée à 1440 px.
 * Le composant générique la rendait en grille statique de deux cartes de 573 px, texte
 * au-dessus : la carte d'exemple comptait 2 colonnes là où le prototype en a 3. On rend
 * donc cette bande avec le composant de zone, exact sur les 26 pages de zone depuis G09,
 * en gardant la section 8 du seed comme unique source du contenu (rien en dur ici).
 */
get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'bourgogne-franche-comte', 'skip' => array( 8, 9, 10, 11 ) ) );

$tfp_bande_tarif = null;
foreach ( ( $page['sections'] ?? array() ) as $tfp_section ) {
	if ( 8 === (int) ( $tfp_section['index'] ?? -1 ) ) {
		$tfp_bande_tarif = $tfp_section;
		break;
	}
}
if ( $tfp_bande_tarif ) :
	$tfp_bloc      = $tfp_bande_tarif['blocs'][0] ?? array();
	$tfp_paras     = array();
	$tfp_grille    = null;
	foreach ( ( $tfp_bloc['sequence'] ?? array() ) as $tfp_enfant ) {
		if ( 'paragraph' === ( $tfp_enfant['type'] ?? '' ) ) {
			$tfp_paras[] = $tfp_enfant['texte'];
		} elseif ( 'grid' === ( $tfp_enfant['type'] ?? '' ) ) {
			$tfp_grille = $tfp_enfant;
		}
	}
	$tfp_exemple = $tfp_grille['items'][0] ?? array();
	$tfp_avis    = $tfp_grille['items'][1] ?? array();
	// « Sophie M. · Cabinet comptable · Côte-d'Or » → auteur, rôle, ville — sans rien inventer.
	$tfp_avis_parts = array_map( 'trim', explode( '·', (string) ( $tfp_avis['description'] ?? '' ) ) );
	?>
<section class="tfp-section--turquoise tfp-section--tight" style="--tfp-bande-haut:clamp(38px, 5vw, 68px);--tfp-bande-bas:clamp(38px, 5vw, 68px)">
	<div class="tfp-container tfp-zone-tarif">
		<div>
			<?php
			// Géométrie d'intertitre relevée sur la maquette (31 px à 1440 px) : rendue à la main,
			// cette bande retombait sur l'échelle du thème et sortait à 29 px.
			tfp_bloc_titre( $tfp_bloc, 'Un tarif régional unique' );
			?>
			<?php foreach ( $tfp_paras as $tfp_texte ) : ?>
				<p class="tfp-prose"><?php echo esc_html( $tfp_texte ); ?></p>
			<?php endforeach; ?>
			<a class="tfp-eyebrow-link" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Voir les tarifs →</a>
		</div>
		<div class="tfp-price-example">
			<div class="tfp-price-example__label"><?php echo esc_html( $tfp_exemple['surtitre'] ?? '' ); ?></div>
			<div class="tfp-price-example__value"><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> <span>HT/mois</span></div>
			<?php if ( ! empty( $tfp_exemple['description'] ) ) : ?>
				<p class="tfp-price-example__why"><?php echo esc_html( $tfp_exemple['description'] ); ?></p>
			<?php endif; ?>
			<div class="tfp-price-example__disclaimer"><?php echo esc_html( $tfp_exemple['lignes'][0] ?? 'Exemple non contractuel.' ); ?></div>
		</div>
		<?php
		if ( ! empty( $tfp_avis['titre'] ) ) {
			tfp_testimonial_card(
				array(
					'texte'  => trim( (string) $tfp_avis['titre'], "« »\u{a0} " ),
					'auteur' => $tfp_avis_parts[0] ?? '',
					'role'   => $tfp_avis_parts[1] ?? '',
					'ville'  => $tfp_avis_parts[2] ?? '',
				)
			);
		}
		?>
	</div>
</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'bourgogne-franche-comte', 'skip' => array( 2, 3, 4, 5, 6, 7, 8 ) ) ); ?>

<?php get_footer(); ?>
