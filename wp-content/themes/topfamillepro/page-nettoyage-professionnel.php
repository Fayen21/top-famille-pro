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

<section class="tfp-container tfp-section--tight">
	<div class="tfp-hero__eyebrow">
		<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
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
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'nettoyage-professionnel' ) ); ?>

<?php get_footer(); ?>
