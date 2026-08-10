<?php
/**
 * 15. Bloc Audrey — bloc 11 du prototype Claude Design.
 *
 * Ne contient plus les quatre points « Pourquoi Top-Famille Pro » ni la carte témoignage : ils
 * ont retrouvé leur section propre (template-parts/home/why.php) le 9 août 2026, comme dans la
 * maquette. Ce bloc redevient ce qu'il est dans le prototype : portrait à gauche, présentation de
 * l'interlocutrice et double CTA à droite.
 *
 * La pastille « ★★★★★ 5,0/5 Google » superposée au portrait est rendue : la note est réelle,
 * confirmée par Emmanuel le 9 août 2026 (CLAUDE.md §5.5). Elle ne s'affiche que si une note est
 * saisie dans Réglages → Réassurance & avis, et n'alimente aucune donnée structurée.
 *
 * La citation attribuée à Audrey est reprise telle quelle de la maquette (consigne du 10 août
 * 2026 : reproduire le prototype à 100 %). Elle est marquée `data-tfp-provisional` et reste
 * à faire valider par l'intéressée avant mise en ligne : c'est la seule phrase du site qui fasse
 * parler une personne réelle, ce qui n'est pas du même ordre qu'un visuel d'illustration.
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
			<blockquote class="tfp-quote" data-tfp-provisional="1">&laquo;&nbsp;Mon rôle, c'est de rester joignable et de tenir mes engagements. Chaque client sait à qui parler, et sait ce qui a été fait dans ses locaux.&nbsp;&raquo;</blockquote>
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
