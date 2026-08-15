<?php
/**
 * Page statique « Plan du site » (/plan-du-site/) — gabarit dédié (CLAUDE.md §3).
 *
 * Généré dynamiquement à partir du contenu réel (pas une liste statique à maintenir à la main).
 * Les 8 communes secondaires non validées (niveau=commune, statut_validation non coché) sont
 * volontairement exclues de ce plan destiné aux visiteurs : les présenter comme des destinations
 * normales de navigation contredirait leur statut « en attente de validation » (CLAUDE.md §5.4).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$static_pages = array(
	array( 'title' => 'Accueil', 'url' => home_url( '/' ) ),
	array( 'title' => 'Nettoyage professionnel', 'url' => home_url( '/nettoyage-professionnel/' ) ),
	array( 'title' => 'Nos prestations', 'url' => home_url( '/prestations/' ) ),
	array( 'title' => 'Nos tarifs', 'url' => home_url( '/tarifs/' ) ),
	array( 'title' => "Zones d'intervention", 'url' => home_url( '/zones-intervention/' ) ),
	array( 'title' => 'Bourgogne-Franche-Comté', 'url' => home_url( '/zones-intervention/bourgogne-franche-comte/' ) ),
	array( 'title' => 'Pourquoi nous', 'url' => home_url( '/pourquoi-nous/' ) ),
	array( 'title' => 'Notre fonctionnement', 'url' => home_url( '/notre-fonctionnement/' ) ),
	array( 'title' => 'Avis clients', 'url' => home_url( '/avis-clients/' ) ),
	array( 'title' => 'À propos', 'url' => home_url( '/a-propos/' ) ),
	array( 'title' => 'Demande de devis', 'url' => home_url( '/demande-de-devis/' ) ),
	array( 'title' => 'Contact', 'url' => home_url( '/contact/' ) ),
	array( 'title' => 'Recrutement', 'url' => home_url( '/recrutement/' ) ),
	array( 'title' => 'Conseils', 'url' => home_url( '/conseils/' ) ),
);

$legal_pages = array(
	array( 'title' => 'Mentions légales', 'url' => home_url( '/mentions-legales/' ) ),
	array( 'title' => 'Politique de confidentialité', 'url' => home_url( '/politique-de-confidentialite/' ) ),
	array( 'title' => 'Gestion des cookies', 'url' => home_url( '/gestion-des-cookies/' ) ),
);

$prestations = get_posts( array( 'post_type' => 'prestation', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );

$departements = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'departement', 'orderby' => 'title', 'order' => 'ASC' ) );
$villes       = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'ville', 'orderby' => 'title', 'order' => 'ASC' ) );
// Les communes secondaires figurent au plan du site comme dans la maquette : elles sont
// `noindex,follow` (CLAUDE.md §5.4), ce qui n'empêche ni de les lister ni de les suivre — c'est
// même le seul chemin interne qui y mène tant qu'elles ne sont pas validées.
$communes     = get_posts( array( 'post_type' => 'zone', 'numberposts' => -1, 'meta_key' => 'niveau', 'meta_value' => 'commune', 'orderby' => 'title', 'order' => 'ASC' ) );

$articles = get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1, 'category_name' => 'conseils', 'orderby' => 'title', 'order' => 'ASC' ) );

tfp_seo(
	array(
		'title'       => 'Plan du site | ' . $site['brand_name'],
		'description' => 'Toutes les pages de ' . $site['brand_name'] . ' : prestations, zones d\'intervention, tarifs, conseils et informations légales.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Plan du site', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<?php
/*
 * La maquette ne coupe pas cette page en deux bandes : le titre et la grille des colonnes
 * appartiennent à la MÊME bande, dont le rembourrage déclaré vaut clamp(26px, 4vw, 48px) en haut
 * et clamp(52px, 7vw, 88px) en bas. Le thème posait deux bandes successives (30,72 + 30,72 puis
 * 48 + 48), soit 157 px de rembourrage contre 84 — pour un écart qui n'était dans aucun composant.
 */
?>
<section class="tfp-container tfp-section--tight" style="--tfp-bande-haut:clamp(26px, 4vw, 48px);--tfp-bande-bas:clamp(52px, 7vw, 88px)">
	<h1>Plan du site</h1>

	<div class="tfp-grid tfp-sitemap-grid">

		<div>
			<h2>Pages principales</h2>
			<ul>
				<?php foreach ( $static_pages as $p ) : ?>
					<li><a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Prestations</h2>
			<ul>
				<?php foreach ( $prestations as $p ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Zones — départements</h2>
			<ul>
				<?php foreach ( $departements as $d ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $d ) ); ?>"><?php echo esc_html( get_the_title( $d ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Zones — villes</h2>
			<ul>
				<?php foreach ( $villes as $v ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $v ) ); ?>"><?php echo esc_html( get_the_title( $v ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Communes secondaires</h2>
			<ul>
				<?php foreach ( $communes as $c ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Conseils</h2>
			<ul>
				<?php foreach ( $articles as $a ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $a ) ); ?>"><?php echo esc_html( get_the_title( $a ) ); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( home_url( '/conseils/' ) ); ?>">Tous les conseils</a></li>
			</ul>
		</div>

	</div>
</section>

<?php
/*
 * Bande légale : rangée de pastilles pleine largeur, rembourrage haut nul et bas
 * clamp(52px, 7vw, 88px) — les valeurs déclarées sur la maquette. « Plan du site » n'y figure pas :
 * la maquette n'y renvoie pas la page vers elle-même, et un lien auto-référent n'apporte rien.
 */
?>
<section class="tfp-container tfp-section--tight tfp-sitemap-legal" style="--tfp-bande-haut:0px;--tfp-bande-bas:clamp(52px, 7vw, 88px)">
	<h2>Pages légales et utilitaires</h2>
	<ul class="tfp-chip-list tfp-chip-list--plan">
		<?php foreach ( $legal_pages as $p ) : ?>
			<li><a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></li>
		<?php endforeach; ?>
		<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
	</ul>
</section>

<?php get_footer(); ?>
