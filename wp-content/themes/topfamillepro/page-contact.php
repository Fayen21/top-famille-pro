<?php
/**
 * Page statique « Contact » (/contact/) — gabarit dédié (CLAUDE.md §3).
 *
 * Coordonnées réelles uniquement (PROJECT_INPUTS.md §1) : Audrey (gérante) et Manon (assistante).
 * L'adresse de Saint-Apollinaire est présentée comme siège social, jamais comme une agence ou un
 * point d'accueil visitable (CLAUDE.md §5.2 : un seul établissement, aucune agence locale).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Contacter Top-Famille Pro | Nettoyage professionnel',
		'description' => 'Téléphone, e-mail ou formulaire : Audrey répond sous 24 heures aux questions sur les prestations, les tarifs et les zones couvertes.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Contact', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Contacter Top-Famille Pro</h1>
	<p class="tfp-section__lede">Une question, un projet d'entretien ? <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond directement, sous 24 heures.</p>
</section>

<?php
/*
 * Micro-cartes de la page Contact.
 *
 * Cette page a son propre gabarit, mais **pas sa propre architecture** : ses cartes passent par
 * `tfp_card_grid()` et `tfp_chip_list()`, les mêmes composants que les bandes statiques, avec le
 * même schéma structuré. Une seconde implémentation aurait divergé à la première correction.
 *
 * Les coordonnées viennent toutes de `tfp_site_data()` : aucun numéro, aucune adresse et aucune
 * adresse électronique n'est recopiée ici.
 *
 * Géométrie relevée sur la maquette à 1440 px :
 *  - deux cartes d'orientation : 403×104, fond #EFEFEF, rayon 16, filet 1 px, rembourrage 22,
 *    deux colonnes, écart 14 ;
 *  - quatre cartes de coordonnées : 512×86, fond blanc, rayon 12, filet 1 px, rembourrage 16/18,
 *    une colonne, écart 12 ;
 *  - trois pastilles de renvoi : 118×43, fond #F4F7F8, rayon 100, filet 1 px, écart 10.
 */
$prenom = explode( ' ', $site['manager'] )[0];

$orientation = array(
	'colonnes' => 2,
	'theme'    => 'clair',
	'variante' => 'lien',
	'gap'      => '14px',
	'fond'     => 'rgb(239, 239, 239)',
	'rayon'    => '16px',
	'filet'    => '1px',
	'padding'  => '22px',
	'items'    => array(
		array(
			'titre'       => 'J’ai une question',
			'description' => 'Formulaire court, réponse par e-mail ou téléphone.',
			'route'       => '',
		),
		array(
			'titre'        => 'J’ai un besoin de nettoyage',
			'description'  => 'Direction le formulaire de devis détaillé',
			'route'        => '#/demande-de-devis',
			'libelle_lien' => 'Demander mon devis',
		),
	),
);

$coordonnees = array(
	'colonnes' => 1,
	'theme'    => 'clair',
	'variante' => 'lien',
	'gap'      => '12px',
	'fond'     => 'rgb(255, 255, 255)',
	'rayon'    => '12px',
	'filet'    => '1px',
	'padding'  => '16px 18px',
	'items'    => array(
		array(
			'icone'       => '☎',
			'titre'       => 'Téléphone',
			'description' => $site['phone'],
			'route'       => 'tel:' . $site['phone_href'],
			'aria'        => 'Appeler ' . $prenom . ' au ' . $site['phone'],
		),
		array(
			'icone'       => '✉',
			'titre'       => 'E-mail',
			'description' => $site['email'],
			'route'       => 'mailto:' . $site['email'],
			'aria'        => 'Écrire à ' . $site['email'],
		),
		array(
			'icone'       => '📍',
			'titre'       => 'Implantation',
			'description' => $site['address_city'] . ' (' . substr( $site['address_cp'], 0, 2 ) . ') · ' . $site['address_region'],
		),
		array(
			'icone'       => '🕑',
			'titre'       => 'Horaires de contact',
			// La maquette écrit « Du lundi au vendredi · à confirmer · réponse sous 24 h ». La
			// mention « à confirmer » est retirée : c'est un marqueur d'information non arrêtée, et
			// aucun ne doit rester visible en production. Écart documenté au rapport.
			'description' => 'Du lundi au vendredi · réponse sous 24 h',
		),
	),
);
?>

<section class="tfp-section--tight">
	<div class="tfp-container">
		<?php tfp_card_grid( $orientation ); ?>
	</div>
</section>

<section class="tfp-section--tight">
	<div class="tfp-container tfp-contact-cols">
		<div>
			<div class="tfp-contact-person">
				<?php tfp_picture( 'audrey-placeholder', array( 'sizes' => '64px', 'alt' => '', 'class' => 'tfp-contact-person__photo' ) ); ?>
				<div>
					<strong><?php echo esc_html( $prenom ); ?></strong>
					<span>Votre interlocutrice, du devis au suivi</span>
				</div>
			</div>
			<?php
			tfp_card_grid( $coordonnees );
			tfp_chip_list(
				array(
					array( 'texte' => 'Voir les tarifs', 'url' => home_url( '/tarifs/' ) ),
					array( 'texte' => 'Zones d’intervention', 'url' => home_url( '/zones-intervention/' ) ),
					array( 'texte' => 'Fonctionnement', 'url' => home_url( '/notre-fonctionnement/' ) ),
				)
			);
			?>
		</div>
		<div>
			<h2>Une demande précise ?</h2>
			<p class="tfp-prose">Pour un devis, décrivez directement vos locaux et votre besoin via le formulaire dédié : la réponse est plus rapide et plus précise qu'un échange initial par téléphone.</p>
			<p style="margin-top:16px">
				<?php tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) ); ?>
			</p>
			<p class="tfp-static-note">
				<?php echo esc_html( $site['brand_name'] ); ?> — <?php echo esc_html( $site['address_street'] ); ?>,
				<?php echo esc_html( $site['address_cp'] . ' ' . $site['address_city'] ); ?>.
				Adresse administrative : l'intervention a lieu dans vos locaux, il n'y a pas d'accueil du public à cette adresse.
			</p>
		</div>
	</div>
</section>

<?php get_footer(); ?>
