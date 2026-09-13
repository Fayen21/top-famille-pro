<?php
/**
 * Page pilier « Nettoyage professionnel » (/nettoyage-professionnel/) — gabarit dédié à cette
 * page statique unique (CLAUDE.md §3 : structure propre à chaque page statique, sans CPT).
 * Sélectionné automatiquement par WordPress via la hiérarchie de gabarits (page-{slug}.php) pour
 * la Page du même slug — voir bin/seed-phase2-content.php pour sa création.
 *
 * Contenu repris du prototype (section « nettoyage professionnel » / pilier), corrigé selon
 * CLAUDE.md §9 : tarif réécrit avec la vraie grille (plus de « 27 € HT/h » unique), avis de
 * démonstration retiré (remplacé par le même mécanisme conditionnel que l'accueil), aucune
 * fausse note Google.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();

$services_nav = array(
	array( 'label' => 'Nettoyage de bureaux', 'tease' => 'Open-spaces, salles de réunion, accueil', 'url' => home_url( '/prestations/bureaux/' ) ),
	array( 'label' => 'Nettoyage de commerces', 'tease' => 'Surfaces de vente, vitrines, sanitaires clients', 'url' => home_url( '/prestations/commerces/' ) ),
	array( 'label' => 'Cabinets & professions libérales', 'tease' => 'Santé, droit, conseil, salles d\'attente', 'url' => home_url( '/prestations/cabinets/' ) ),
	array( 'label' => 'Copropriétés & parties communes', 'tease' => 'Halls, cages d\'escalier, locaux communs', 'url' => home_url( '/prestations/coproprietes/' ) ),
	array( 'label' => 'Locations meublées & hébergements', 'tease' => 'Remise en état entre deux occupants', 'url' => home_url( '/prestations/meubles/' ) ),
	array( 'label' => 'Nettoyage ponctuel & remise en état', 'tease' => 'Après travaux, grand nettoyage, fin de bail', 'url' => home_url( '/prestations/ponctuel/' ) ),
);

$articles_nav = array(
	array( 'label' => 'À quelle fréquence faire nettoyer ses bureaux ?', 'url' => home_url( '/conseils/frequence-bureaux/' ) ),
	array( 'label' => 'Combien coûte le nettoyage de bureaux ?', 'url' => home_url( '/conseils/cout-nettoyage-bureaux/' ) ),
	array( 'label' => 'Comment rédiger un cahier des charges de nettoyage ?', 'url' => home_url( '/conseils/cahier-des-charges-nettoyage/' ) ),
);

$faqs = array(
	array( 'q' => 'Intervenez-vous dans toute la Bourgogne-Franche-Comté ?', 'a' => "Oui, depuis Saint-Apollinaire sur les huit départements de la région. Selon la distance, des indemnités kilométriques de 0,35 € HT/km peuvent s'appliquer et sont indiquées au devis." ),
	array( 'q' => 'Faut-il fournir les produits et le matériel ?', 'a' => 'Les produits et le matériel sont fournis par le client. Les modalités sont précisées au devis et dans le cahier des charges.' ),
	array( 'q' => 'Le devis est-il payant ou engageant ?', 'a' => 'Le devis est gratuit, transmis sous 24 heures, et sans engagement de votre part.' ),
	array( 'q' => "Que se passe-t-il si l'intervenant est absent ?", 'a' => 'Nous recherchons activement une solution de remplacement pour maintenir la continuité et vous tenons informé de l\'organisation retenue.' ),
	array( 'q' => 'Comment est rédigé le cahier des charges ?', 'a' => 'Il est établi avec vous avant la première intervention : espaces concernés, tâches attendues, fréquence, horaires et points de vigilance propres à vos locaux. Il peut être ajusté à tout moment.' ),
	array( 'q' => 'Le même intervenant vient-il à chaque passage ?', 'a' => "C'est l'organisation que nous recherchons : un intervenant habituel qui connaît vos locaux et vos consignes. Cette continuité est privilégiée autant que possible, sans constituer une garantie absolue en cas d'absence ou de changement de disponibilité." ),
	array( 'q' => 'Vaut-il mieux passer par un prestataire ou embaucher un agent d\'entretien ?', 'a' => "Le recrutement direct peut se justifier à partir d'un volume horaire important et d'un besoin de présence continue. En dessous, le coût réel d'une embauche — recrutement, paie, congés, remplacement, matériel, encadrement — dépasse souvent l'écart de tarif horaire. Si votre besoin est une présence permanente, nous vous le dirons plutôt que de forcer un devis." ),
	array( 'q' => 'Comment modifier la prestation en cours de contrat ?', 'a' => "Par un simple échange avec {$site['manager']}. Un ajustement de périmètre à volume d'heures constant se met en place rapidement ; un changement de volume horaire donne lieu à un devis actualisé, soumis à votre accord avant application. Il n'y a pas d'engagement de durée." ),
	array( 'q' => 'Quelle fréquence faut-il prévoir pour des bureaux ?', 'a' => "Elle dépend surtout de l'effectif réellement présent, du nombre de sanitaires et de la présence d'une cuisine. Deux à trois passages par semaine constituent le rythme le plus courant entre dix et trente postes ; au-delà, les sanitaires et la cuisine justifient généralement un passage quotidien." ),
	array( 'q' => 'Pouvez-vous intervenir le dimanche ou la nuit ?', 'a' => "Oui, sur demande, lorsque votre activité l'exige. Ces créneaux font l'objet d'une majoration de 10 % du tarif horaire, indiquée à l'avance sur le devis et jamais découverte après coup." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/nettoyage-professionnel/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array(
					'@type'          => 'Question',
					'name'           => $item['q'],
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ),
				);
			},
			$faqs
		),
	);
}

tfp_seo(
	array(
		'title'       => 'Nettoyage professionnel de bureaux et de locaux | ' . $site['brand_name'],
		'description' => "Le nettoyage professionnel expliqué : périmètre, organisation, tarif, engagements et limites. Devis gratuit sous 24 h en {$site['address_region']}.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Nettoyage professionnel', 'url' => null ),
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
$page = tfp_static_page_data( 'nettoyage-professionnel' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-hero">
	<div class="tfp-hero__content">
		<?php
		/*
		 * La maquette du pilier pose la pastille de note SEULE au-dessus du H1 — sans badge région,
		 * contrairement aux pages tarifs, prestation et zone. Le badge région ajouté ici partageait
		 * la rangée avec la pastille (35 px de haut) et faisait compter deux colonnes là où le
		 * prototype n'en a qu'une (relevé G23).
		 */
		?>
		<div class="tfp-hero__eyebrow">
			<?php tfp_google_rating_badge( 'inline' ); ?>
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
			tfp_picture( 'hero-pilier', array( 'sizes' => '(max-width: 819px) 92vw, 560px', 'lcp' => true ) );
			?>
		</div>
	</div>
</section>

<?php
/*
 * La bande « Cahier des charges, intervenants et suivi » (section 12) est une RANGÉE À DEUX
 * COLONNES dans la maquette : un visuel carré à gauche (flex 1 1 300px, rayon 20, aspect 1/1,
 * object-fit cover) et le contenu à droite (flex 1 1 420px). Le relevé du générateur n'ouvre un
 * bloc que sur du texte : la colonne image, muette, n'était donc pas enregistrée — et la page
 * rendait neuf images au lieu de dix. C'est l'un des motifs du refus de validation du 17 août
 * 2026, et l'audit par rôle (tools/audit-images-role.mjs) l'a nommé « éditoriale #1 manquante ».
 *
 * La bande est rendue ici, comme la bande tarifaire de la page région (G23) : le SEED reste
 * l'unique source du texte, seul le visuel manquant est ajouté à sa place.
 */
/*
 * La bande 12 est rendue À SA PLACE dans le flux, entre la bande 11 et la bande 13.
 *
 * Elle était rendue en fin de page : le composant de bandes statiques la sautait, puis le gabarit
 * l'ajoutait après tout le reste. Le fichier image était le bon, son contenu aussi — mais la bande
 * arrivait 18ᵉ au lieu de 11ᵉ, entre « Questions fréquentes » et le pied de page au lieu d'être
 * entre « Comment se construit un cahier des charges » et « Trois situations concrètes ». Un
 * visuel correct à la mauvaise place reste un défaut de fidélité, et il ne se voit sur aucun
 * contrôle d'empreinte.
 *
 * D'où les deux appels encadrant la bande : le composant sait désormais rendre une plage.
 */
$tfp_bande_methode = null;
foreach ( ( $page['sections'] ?? array() ) as $tfp_section ) {
	if ( 12 === (int) ( $tfp_section['index'] ?? -1 ) ) {
		$tfp_bande_methode = $tfp_section;
		break;
	}
}

get_template_part(
	'template-parts/components/static-blocks',
	null,
	array( 'key' => 'nettoyage-professionnel', 'skip' => array( 12 ), 'a' => 11 )
);

if ( $tfp_bande_methode ) :
	$tfp_bloc = $tfp_bande_methode['blocs'][0] ?? array();
	?>
<section class="tfp-section--tight tfp-section--blanc" style="--tfp-bande-haut:clamp(44px, 6vw, 84px);--tfp-bande-bas:clamp(44px, 6vw, 84px)">
	<div class="tfp-container tfp-methode-rangee">
		<div class="tfp-methode-rangee__media">
			<?php
			// Visuel d'illustration — jamais présenté comme Audrey (CLAUDE.md §5.6) : l'alt de la
			// maquette (« Audrey, interlocutrice dédiée ») présente une photo de stock comme une
			// personne réelle, celui du manifeste dit ce qu'il en est.
			tfp_picture( 'audrey-portrait', array( 'sizes' => '(max-width: 819px) 92vw, 500px', 'class' => 'tfp-methode-rangee__img' ) );
			?>
			<p class="tfp-provisional-notice" data-tfp-provisional-notice="1">Photo d’illustration provisoire — portrait d’Audrey à venir.</p>
		</div>
		<div class="tfp-methode-rangee__corps">
			<?php
			// Géométrie d'intertitre relevée sur la maquette (36 px à 1440 px) : rendue à la main,
			// cette bande retombait sur l'échelle du thème et sortait à 34 px.
			tfp_bloc_titre( $tfp_bloc, 'Cahier des charges, intervenants et suivi' );
			?>
			<?php
			foreach ( ( $tfp_bloc['sequence'] ?? array() ) as $tfp_enfant ) {
				$type = $tfp_enfant['type'] ?? '';
				if ( 'paragraph' === $type || 'note' === $type ) {
					printf( '<p class="tfp-prose">%s</p>', esc_html( $tfp_enfant['texte'] ) );
				} elseif ( 'grid' === $type ) {
					tfp_card_grid( $tfp_enfant );
				} elseif ( 'list' === $type ) {
					echo '<ul class="tfp-list-plain">';
					foreach ( (array) ( $tfp_enfant['items'] ?? array() ) as $item ) {
						printf( '<li>%s</li>', esc_html( $item ) );
					}
					echo '</ul>';
				} elseif ( 'link' === $type ) {
					$url = tfp_route_to_url( $tfp_enfant['route'] ?? '' );
					if ( $url ) {
						printf( '<a class="tfp-eyebrow-link" href="%s">%s</a>', esc_url( $url ), esc_html( rtrim( $tfp_enfant['texte'], '→ ' ) ) . ' →' );
					}
				}
			}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
// … puis la suite du flux, à partir de la bande 13.
get_template_part(
	'template-parts/components/static-blocks',
	null,
	array( 'key' => 'nettoyage-professionnel', 'skip' => array( 12 ), 'de' => 13 )
);
?>

<?php get_footer(); ?>
