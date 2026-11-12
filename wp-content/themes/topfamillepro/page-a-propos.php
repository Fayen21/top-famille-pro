<?php
/**
 * Page statique « À propos » (/a-propos/) — gabarit dédié (CLAUDE.md §3).
 *
 * Identité réelle uniquement (PROJECT_INPUTS.md §1) : aucune donnée d'immatriculation (SIRET,
 * capital, APE, TVA) tant que le Kbis ne les a pas confirmées (STATUS.md §6, bloqueur de mise en
 * ligne) — ce n'est pas l'objet de cette page de toute façon, réservé aux mentions légales une
 * fois les données confirmées. Même mécanisme de portrait que l'accueil
 * (tfp_get_audrey_photo_url() / tfp_audrey_photo_is_real(), includes/customizer.php) : visuel
 * d'illustration temporaire avec alt honnête tant que la vraie photo n'est pas fournie, jamais
 * présenté comme Audrey, aucune biographie inventée.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site         = tfp_site_data();
$first_name   = explode( ' ', $site['manager'] )[0];
$audrey_photo = tfp_get_audrey_photo_url();

tfp_seo(
	array(
		'title'       => 'À propos de Top-Famille Pro | ' . $first_name . ', votre interlocutrice',
		'description' => 'Une entreprise de nettoyage implantée à Saint-Apollinaire, en périphérie de Dijon, avec une interlocutrice unique du devis au suivi.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'À propos', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'a-propos' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<?php
/*
 * ORDRE DES COLONNES DU HERO — corrigé en G26 §4.
 *
 * La maquette pose le portrait À GAUCHE et le texte à droite sur ordinateur, et le portrait AVANT
 * le texte sur mobile ; le thème faisait l'inverse dans les deux cas. La correction est un ordre
 * de DOM, pas une propriété `order` : le hero est une rangée flex qui se replie, et l'ordre du
 * document donne du même coup la colonne de gauche sur grand écran et le premier bloc en mobile.
 * Une règle `order` aurait dissocié l'ordre visuel de l'ordre de lecture au clavier et aux
 * technologies d'assistance, pour le même rendu.
 */
?>
<section class="tfp-hero">
	<?php
	// Décision du 13 novembre 2026 : plus de portrait de banque d'images ni de mention « photo
	// provisoire ». La gérante est présentée par une carte : monogramme (ou vraie photo, le jour où
	// elle est saisie), nom, fonction, siège.
	?>
	<div class="tfp-hero__media tfp-hero__media--carte-gerante">
		<div class="tfp-carte-gerante">
			<?php tfp_gerante_visuel( 'tfp-monogramme--xl' ); ?>
			<strong class="tfp-carte-gerante__nom"><?php echo esc_html( $site['manager'] ); ?></strong>
			<span class="tfp-carte-gerante__fonction">Gérante de <?php echo esc_html( $site['brand_name'] ); ?></span>
			<span class="tfp-carte-gerante__lieu"><?php echo esc_html( $site['address_city'] ); ?> · Bourgogne-Franche-Comté</span>
		</div>
	</div>
	<div class="tfp-hero__content">
		<div class="tfp-hero__eyebrow">
			<?php
			/*
			 * PAS de badge région dans ce hero — relevé sur la maquette (G26 §8/§9).
			 *
			 * Le prototype ne pose ce badge que sur les pages qui parlent d'un territoire : la page
			 * région, les huit départements, les dix-huit villes, les six prestations et la page
			 * tarifs. Les pages institutionnelles — à propos, pourquoi nous, notre fonctionnement,
			 * avis, index des prestations, index des zones, recrutement — n'en portent pas. Le thème
			 * l'ajoutait sur les sept, soit un composant de 35 px et une rangée de plus au-dessus de
			 * chaque H1, ce qui décalait tout le hero. Trois de ces routes en sortaient de la plage de
			 * fidélité au relevé de base.
			 */
			?>
			<?php tfp_google_rating_badge( 'nu' ); ?>
		</div>
		<h1><?php echo esc_html( $page['h1'] ); ?></h1>
		<?php foreach ( $page['lede'] as $lede ) : ?>
			<p class="tfp-section__lede"><?php echo esc_html( $lede ); ?></p>
		<?php endforeach; ?>
		<div class="tfp-action-row" style="margin-top:24px">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
			tfp_bouton_appel( array( 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/components/static-blocks', null, array( 'key' => 'a-propos' ) ); ?>

<?php get_footer(); ?>
