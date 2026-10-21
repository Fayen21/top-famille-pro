<?php
/**
 * Page statique « Recrutement » (/recrutement/) — gabarit dédié (CLAUDE.md §3).
 *
 * CLAUDE.md §8 est explicite : cette page renvoie vers le site carrière existant
 * (careers.werecruit.io/fr/top-famille, PROJECT_INPUTS.md §1), sans dupliquer de formulaire de
 * candidature ni collecter de CV sur ce site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$careers_url = 'https://careers.werecruit.io/fr/top-famille';

tfp_seo(
	array(
		'title'       => "Recrutement — agents d'entretien | " . $site['brand_name'],
		'description' => "Nous recrutons des agents d'entretien en {$site['address_region']}. Postes, conditions et candidature sur notre site carrière.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Recrutement', 'url' => null ),
		),
	)
);

get_header();

/*
 * Corps de page rendu par le composant commun : le contenu vient de la maquette Claude Design,
 * relevé par tools/generate-pages.mjs et stocké en option (CLAUDE.md §3 — page WordPress
 * classique, sans champs ACF). L'ordre des sections et leur fond sont ceux du prototype.
 */
$page = tfp_static_page_data( 'recrutement' );
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-hero">
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
			/*
			 * PARCOURS DE CANDIDATURE, et non appels commerciaux — corrigé en G26 §5.
			 *
			 * Le hero affichait « Demander mon devis » et « Appeler Audrey » : les deux commandes
			 * de conversion commerciale du site, sur la seule page qui ne s'adresse pas à un
			 * client. Un candidat n'y trouvait aucun moyen de candidater avant le bas de page.
			 * La maquette y pose « Envoyer ma candidature » et le numéro en clair ; ce sont ces
			 * deux commandes, avec leur géométrie relevée.
			 *
			 * SEULE la destination du premier bouton s'écarte de la maquette, qui pointe vers un
			 * `mailto:`. CLAUDE.md §8 est explicite : la page renvoie vers le site carrière
			 * existant, sans dupliquer de formulaire de candidature ni collecter de CV ici. Une
			 * règle du projet l'emporte sur le prototype (CLAUDE.md §2), et aucun second
			 * formulaire n'est créé — c'est un lien, pas un formulaire.
			 */
			tfp_button(
				array(
					'label'   => 'Envoyer ma candidature',
					'href'    => $careers_url,
					'variant' => 'primary',
					'mesures' => array( 'pad_v' => '15px', 'pad_h' => '24px', 'taille' => '17px', 'graisse' => 700, 'hauteur' => '60px' ),
				)
			);
			tfp_button(
				array(
					'label'   => '☎ ' . $site['phone'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'secondary',
					'mesures' => array( 'pad_v' => '15px', 'pad_h' => '22px', 'taille' => '17px', 'graisse' => 600, 'hauteur' => '60px' ),
				)
			);
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
			tfp_picture( 'service-generic', array( 'sizes' => '(max-width: 819px) 92vw, 560px', 'lcp' => true ) );
			?>
		</div>
	</div>
</section>

<?php
/*
 * La commande « Envoyer ma candidature » de la bande finale pointe, dans le prototype, vers un
 * `mailto:`. CLAUDE.md §8 impose le site carrière : la substitution est déclarée ici, en clair,
 * plutôt que devinée par le composant d'après un libellé.
 */
get_template_part(
	'template-parts/components/static-blocks',
	null,
	array(
		'key'   => 'recrutement',
		'liens' => array( 'mailto:' . $site['email'] => $careers_url ),
	)
);
?>

<?php get_footer(); ?>
