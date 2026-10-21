<?php
/**
 * 15. Bloc de la gérante — bloc 11 du prototype Claude Design.
 *
 * Décision du 14 octobre 2026 : le bloc présente Audrey Brançon comme GÉRANTE de Top-Famille Pro —
 * titre, texte et signature — et le portrait est réduit de 30 % en dimensions linéaires par rapport
 * au rendu précédent (420 × 525 → 294 × 368 à 1440 px). La réduction porte sur la colonne réelle et
 * les attributs de l'image, pas sur un `transform: scale()` qui aurait conservé l'ancien espace. Le
 * rôle d'interlocutrice reste évoqué comme une qualité de service, sans se substituer au rôle de
 * direction.
 *
 * Ne contient plus les quatre points « Pourquoi Top-Famille Pro » ni la carte témoignage : ils
 * ont retrouvé leur section propre (template-parts/home/why.php) le 9 août 2026, comme dans la
 * maquette.
 *
 * La pastille « ★★★★★ 5,0/5 Google » superposée au portrait n'est rendue que si une note est
 * configurée ET son URL de fiche vérifiée (CLAUDE.md §5.5, consigne du 18 août 2026) ; elle
 * n'alimente aucune donnée structurée.
 *
 * La citation attribuée à Audrey est reprise telle quelle de la maquette (consigne du 10 août
 * 2026). Elle est marquée `data-tfp-provisional` et reste à faire valider par l'intéressée : c'est
 * la seule phrase du site qui fasse parler une personne réelle. Pas de chantier d'authentification
 * dans cette passe (brief du 14 octobre §8).
 *
 * Portrait : visuel d'illustration temporaire (même photo que le prototype) tant que la vraie photo
 * n'est pas fournie, avec un alt honnête et une mention visible — cf. tfp_audrey_photo_is_real(),
 * includes/customizer.php. La photo existante et sa mention sont conservées ; ce n'est pas un
 * nouveau bloqueur de validation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site         = tfp_site_data();
$first_name   = explode( ' ', $site['manager'] )[0];
// `audrey-portrait` : le visuel que la maquette pose sur l'accueil — distinct de celui de /a-propos/.
$audrey_photo = tfp_get_audrey_photo_url( 'audrey-portrait' );
$is_real      = tfp_audrey_photo_is_real();
?>
<section class="tfp-section--alt tfp-section" aria-labelledby="tfp-gerante-titre">
	<div class="tfp-container tfp-gerante">
		<div class="tfp-audrey-portrait tfp-gerante__portrait">
			<?php if ( $audrey_photo ) : ?>
				<img
					src="<?php echo esc_url( $audrey_photo ); ?>"
					alt="<?php echo esc_attr( $is_real ? ( $site['manager'] . ', gérante de ' . $site['brand_name'] ) : 'Photo d’illustration temporaire — portrait définitif à venir' ); ?>"
					width="294" height="368"
					class="tfp-audrey-portrait__img"
					loading="lazy"
				>
				<?php tfp_google_rating_badge( 'floating' ); ?>
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

		<div class="tfp-gerante__texte">
			<h2 id="tfp-gerante-titre" class="tfp-gerante__titre"><?php echo esc_html( $site['manager'] ); ?>, gérante de <?php echo esc_html( $site['brand_name'] ); ?></h2>
			<p class="tfp-gerante__lede">
				Gérante de <?php echo esc_html( $site['brand_name'] ); ?>, <?php echo esc_html( $first_name ); ?> supervise l'organisation des prestations et le suivi des clients. Elle reste directement joignable pour échanger sur vos locaux et vos besoins.
			</p>
			<blockquote class="tfp-quote" data-tfp-provisional="1">&laquo;&nbsp;Mon rôle, c'est de rester joignable et de tenir mes engagements. Chaque client sait à qui parler, et sait ce qui a été fait dans ses locaux.&nbsp;&raquo;</blockquote>
			<p class="tfp-provisional-notice" data-tfp-provisional-notice="1">Citation en attente de validation par l’intéressée.</p>
			<p class="tfp-gerante__signature">
				<strong><?php echo esc_html( $site['manager'] ); ?></strong>
				<span class="tfp-gerante__fonction"> · Gérante, <?php echo esc_html( $site['brand_name'] . ' — ' . $site['address_city'] ); ?></span>
			</p>

			<div class="tfp-action-row tfp-gerante__actions">
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
