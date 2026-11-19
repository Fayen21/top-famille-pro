<?php
/**
 * 1. Hero — besoin du client, publics, tarif unique, CTA principal + secondaire, réassurance courte.
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

		<?php
		/*
		 * Passe commerciale du 10 novembre 2026 : le premier écran dit d'abord le besoin du client,
		 * puis l'offre, dans cet ordre — activité et bénéfice, publics (une ligne), tarif unique,
		 * devis, appel, réassurance courte. Le prix et les deux commandes forment UN bloc
		 * (`.tfp-hero__offre`) : le tarif n'est plus dans une pastille posée sur la photo, ni répété
		 * par un bandeau juste en dessous (voir pricing-reassurance.php).
		 */
		?>
		<h1 class="tfp-hero__title">Nettoyage professionnel en Bourgogne-Franche-Comté</h1>
		<p class="tfp-hero__lede">Des locaux propres, des passages organisés selon vos horaires et un contact direct pour le suivi.</p>
		<p class="tfp-hero__publics"><span class="visually-hidden">Pour : </span>Bureaux · commerces · cabinets · copropriétés · locations meublées</p>

		<div class="tfp-hero__offre">
			<p class="tfp-hero__prix">
				<strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong>
				<span>tarif unique, en régulier comme en ponctuel</span>
			</p>
			<div class="tfp-hero__actions">
				<?php
				tfp_button(
					array(
						'label'   => 'Demander mon devis',
						'href'    => home_url( '/demande-de-devis/' ),
						'variant' => 'primary',
					)
				);
				// Décision du 14 octobre 2026 : la commande générique nomme l'entreprise.
				tfp_bouton_appel( array( 'variant' => 'secondary' ) );
				?>
			</div>
			<p class="tfp-hero__microcopy">Devis gratuit · Réponse sous 24 h · Sans engagement</p>
		</div>
	</div>

	<div class="tfp-hero__media tfp-hero__media--accueil">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( 'hero-main', array( 'sizes' => '(max-width: 819px) 92vw, 600px' ) ); ?>
		</div>
		<div class="tfp-hero__media-secondary">
			<?php tfp_picture( 'hero-secondary', array( 'sizes' => '220px' ) ); ?>
		</div>
	</div>
</section>
