<?php
/**
 * Page statique « Pourquoi nous » (/pourquoi-nous/) — gabarit dédié (CLAUDE.md §3).
 *
 * Contenu construit à partir des arguments réels de PROJECT_INPUTS.md §8 (gestion administrative,
 * assurance professionnelle, gestion des clés, remplacement, contrôle qualité, cahier de liaison,
 * tarif sans frais cachés, recrutement rigoureux) — pas de reprise du prototype, qui mêlait ces
 * arguments réels à des avis et à une note fictifs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$arguments = array(
	array( 'titre' => 'Une interlocutrice unique', 'texte' => "Du premier échange au suivi mensuel, vous parlez toujours à {$site['manager']}. Pas de centre d'appels, pas de changement d'interlocuteur au fil des mois." ),
	array( 'titre' => 'Un intervenant habituel recherché', 'texte' => "Nous cherchons à confier votre site au même intervenant d'une semaine sur l'autre. En cas d'absence ou de départ, une solution de remplacement est recherchée activement, sans garantie de continuité automatique que personne ne peut promettre." ),
	array( 'titre' => 'Un cahier des charges écrit, pas une promesse orale', 'texte' => 'Espaces, tâches, fréquence, horaires et points de vigilance sont formalisés avant la première intervention et servent de référence tout au long de la prestation.' ),
	array( 'titre' => 'Un cahier de liaison sur chaque site', 'texte' => 'Chaque passage est tracé : ce qui a été fait, ce qui a été signalé, ce qui reste à traiter. Vous n\'avez pas besoin d\'être présent pour savoir ce qui s\'est passé.' ),
	array( 'titre' => 'Gestion administrative prise en charge', 'texte' => 'Facturation, arrêts de travail, remplacement de personnel, litiges : cette gestion reste de notre côté, pas du vôtre.' ),
	array( 'titre' => 'Recrutement rigoureux', 'texte' => 'Vérification du CV et du casier judiciaire, puis validation par le client lors d\'une prestation d\'essai avant tout engagement durable.' ),
	array( 'titre' => 'Gestion sécurisée des clés et des accès', 'texte' => 'Les modalités d\'accès sont formalisées par écrit et transmises uniquement aux intervenants concernés par votre site.' ),
	array( 'titre' => 'Un tarif indiqué avant le devis, sans frais cachés', 'texte' => 'Grille tarifaire identique dans toute la région, indemnités kilométriques et frais de mise en place toujours précisés au devis, jamais découverts après coup.' ),
);

tfp_seo(
	array(
		'title'       => 'Pourquoi choisir Top-Famille Pro | Nettoyage professionnel',
		'description' => 'Interlocutrice unique, intervenant habituel recherché, cahier de liaison et périmètre écrit : ce qui distingue notre organisation.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Pourquoi nous', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'pourquoi-nous' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<?php
/*
 * Rembourrage de l'en-tête relevé sur la maquette. `.tfp-section--tight` posait
 * clamp(30px, 4vw, 52px) des deux côtés — 104 px à 1440 px contre 88 relevés.
 */
?>
<section class="tfp-container tfp-section--tight" style="--tfp-bande-haut:clamp(26px, 4vw, 48px);--tfp-bande-bas:clamp(28px, 3vw, 40px)">
	<div class="tfp-hero__eyebrow">
		<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
		<?php tfp_google_rating_badge( 'nu' ); ?>
	</div>
	<h1><?php echo esc_html( $page['h1'] ); ?></h1>
	<?php
	/*
	 * Le prototype ne pose qu'UN lède par en-tête : les paragraphes d'introduction suivants y sont
	 * écrits en 16 px / 1,6, un cran sous le premier. Répéter la classe du lède donnait deux
	 * paragraphes de même poids — la hiérarchie voulue disparaissait, et l'en-tête gagnait
	 * une cinquantaine de pixels à 1440 px.
	 */
	foreach ( $page['lede'] as $rang => $lede ) :
		?>
		<p class="<?php echo 0 === $rang ? 'tfp-section__lede' : 'tfp-section__sublede'; ?>"><?php echo esc_html( $lede ); ?></p>
		<?php
	endforeach;
	?>
	<div class="tfp-action-row" style="margin-top:24px">
		<?php
		tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
		tfp_button( array( 'label' => '☎ Appeler ' . explode( ' ', $site['manager'] )[0], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'pourquoi-nous' ) ); ?>

<?php get_footer(); ?>
