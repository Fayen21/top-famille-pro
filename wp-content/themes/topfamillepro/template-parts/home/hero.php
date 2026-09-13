<?php
/**
 * 1. Hero — proposition de valeur, CTA principal + secondaire, réassurance immédiate.
 * Image principale = LCP de la page (tfp_picture gère fetchpriority="high" + pas de lazy-loading).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();
?>
<section class="tfp-hero">
	<div class="tfp-hero__content">
		<?php
		// Badge de note Google, à sa place dans la maquette (au-dessus du H1). Rendu uniquement
		// si une note réelle a été saisie dans Réglages → Réassurance & avis — voir
		// includes/testimonials.php.
		tfp_google_rating_badge( 'inline' );
		?>

		<h1 class="tfp-hero__title">Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté</h1>
		<p class="tfp-hero__lede">La rigueur d'un prestataire structuré, avec la proximité d'une entreprise régionale directement joignable. Top-Famille Pro organise l'entretien régulier ou ponctuel de vos bureaux, commerces, cabinets, parties communes et locations meublées.</p>

		<div class="tfp-hero__actions">
			<?php
			tfp_button(
				array(
					'label'   => 'Demander mon devis',
					'href'    => home_url( '/demande-de-devis/' ),
					'variant' => 'primary',
				)
			);
			tfp_button(
				array(
					'label'   => '☎ Appeler ' . $site['manager'],
					'href'    => 'tel:' . $site['phone_href'],
					'variant' => 'secondary',
				)
			);
			?>
		</div>
		<div class="tfp-hero__microcopy">Réponse sous 24 h · Gratuit · Sans engagement · Devis étudié personnellement par <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?></div>
	</div>

	<div class="tfp-hero__media tfp-hero__media--accueil">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( 'hero-main', array( 'sizes' => '(max-width: 819px) 92vw, 600px' ) ); ?>
		</div>
		<div class="tfp-hero__media-secondary">
			<?php tfp_picture( 'hero-secondary', array( 'sizes' => '220px' ) ); ?>
		</div>
		<div class="tfp-hero__price-tag">
			<div class="tfp-hero__price-tag-value"><?php echo esc_html( $site['price_unique_display'] ); ?><span class="tfp-hero__price-tag-unit"> HT/h</span></div>
			<?php
			/*
			 * « régulier ou ponctuel » : le libellé de la maquette, réaligné en G25. L'ajout de
			 * « tarif unique, » (choix d'une phase précédente) faisait replier la pastille sur
			 * trois lignes au lieu de deux (66 px contre 56, relevé G22) sans nécessité : l'unicité
			 * du tarif est déjà affirmée sur l'accueil par le bandeau (« tarif unique en région »),
			 * la bande tarifaire et la barre haute.
			 */
			?>
			<div class="tfp-hero__price-tag-note">régulier ou ponctuel</div>
		</div>
	</div>
</section>
