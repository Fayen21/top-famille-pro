<?php
/**
 * 15. Bloc Audrey — bloc 11 du prototype Claude Design.
 *
 * Ne contient plus les quatre points « Pourquoi Top-Famille Pro » ni la carte témoignage : ils
 * ont retrouvé leur section propre (template-parts/home/why.php) le 9 août 2026, comme dans la
 * maquette. Ce bloc redevient ce qu'il est dans le prototype : portrait à gauche, présentation de
 * l'interlocutrice et double CTA à droite.
 *
 * Deux écarts assumés avec la maquette, imposés par l'honnêteté des données :
 * - la pastille « ★★★★★ 5,0/5 Google » superposée au portrait n'est pas reproduite : cette note
 *   est fictive (CLAUDE.md §5.5), et aucune note réelle n'a été fournie ;
 * - la citation attribuée à Audrey dans la maquette est inventée (CLAUDE.md §5.1 : aucune
 *   information biographique inventée) — remplacée par un texte descriptif à la troisième
 *   personne, qui ne lui fait pas dire ce qu'elle n'a pas dit.
 *
 * Portrait : visuel d'illustration temporaire (slug 'audrey-placeholder', même photo que le
 * prototype) tant que la vraie photo n'est pas fournie, avec un alt honnête et une mention
 * visible — cf. tfp_audrey_photo_is_real(), includes/customizer.php. Remplaçable depuis
 * Apparence → Personnaliser → Équipe.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site         = tfp_site_data();
$first_name   = explode( ' ', $site['manager'] )[0];
$audrey_photo = tfp_get_audrey_photo_url();
$is_real      = tfp_audrey_photo_is_real();
?>
<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:center">
		<div class="tfp-audrey-portrait">
			<?php if ( $audrey_photo ) : ?>
				<img
					src="<?php echo esc_url( $audrey_photo ); ?>"
					alt="<?php echo esc_attr( $is_real ? ( $site['manager'] . ', gérante de ' . $site['brand_name'] ) : 'Photo d’illustration temporaire — portrait définitif à venir' ); ?>"
					width="420" height="525"
					class="tfp-audrey-portrait__img"
					loading="lazy"
				>
				<?php
				// Pastille de note superposée au portrait, comme dans la maquette — rendue
				// seulement si une note réelle est configurée (includes/testimonials.php).
				tfp_google_rating_badge( 'floating' );
				?>
				<?php if ( ! $is_real ) : ?>
					<p class="tfp-audrey-portrait__note">Photo d’illustration</p>
				<?php endif; ?>
			<?php else : ?>
				<div class="tfp-audrey-portrait__fallback">
					<span aria-hidden="true"><?php echo esc_html( mb_substr( $first_name, 0, 1 ) ); ?></span>
				</div>
				<p class="tfp-audrey-portrait__note">Photo à venir</p>
			<?php endif; ?>
		</div>

		<div>
			<h2 style="font-size:clamp(26px,3.4vw,40px)"><?php echo esc_html( $first_name ); ?>, votre interlocutrice</h2>
			<p style="margin-top:16px;font-size:19px;color:var(--color-text-secondary);line-height:1.6">
				<?php echo esc_html( $first_name ); ?> suit votre dossier du premier échange jusqu'au suivi de la prestation : un seul contact, joignable directement, qui connaît vos locaux et vos consignes.
			</p>
			<p style="margin-top:14px;font-weight:600"><?php echo esc_html( $site['manager'] ); ?><span style="font-weight:400;color:var(--color-text-tertiary)"> · <?php echo esc_html( $site['brand_name'] . ', ' . $site['address_city'] ); ?></span></p>

			<div class="tfp-flex" style="margin-top:24px">
				<?php
				tfp_button(
					array(
						'label'   => 'Échanger sur mes locaux',
						'href'    => home_url( '/contact/' ),
						'variant' => 'primary',
					)
				);
				tfp_button(
					array(
						'label'   => 'Lire les avis',
						'href'    => home_url( '/avis-clients/' ),
						'variant' => 'secondary',
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
