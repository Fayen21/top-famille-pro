<?php
/**
 * 8. Audrey et avis — fusionne les deux blocs « Pourquoi Top-Famille Pro » et « Avis + Audrey »
 * du prototype (brief phase 1 §6 : redondant de garder deux blocs de réassurance/confiance
 * séparés). Pas de portrait de stock présenté COMME Audrey (CLAUDE.md §5.6) : un visuel
 * d'illustration temporaire (assets/dist/images, slug 'audrey-placeholder') tient lieu de photo
 * tant que la vraie n'est pas fournie, avec un alt honnête et une mention visible « Photo
 * d'illustration » — cf. tfp_audrey_photo_is_real(), includes/customizer.php. Remplaçable en un
 * geste depuis Apparence → Personnaliser → Équipe dès que la vraie photo est disponible.
 * Aucune citation inventée en son nom (brief §7 : « n'invente aucune information biographique
 * sur Audrey ») — le texte reste descriptif, à la troisième personne.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();
$first_name  = explode( ' ', $site['manager'] )[0];

$why_items = array(
	array( 'num' => '01', 'title' => 'Directement joignable', 'desc' => $first_name . ', une interlocutrice identifiée qui connaît votre dossier — pas un standard anonyme.' ),
	array( 'num' => '02', 'title' => 'Intervenants sélectionnés & attitrés', 'desc' => 'La même personne autant que possible, qui connaît vos locaux et vos consignes.' ),
	array( 'num' => '03', 'title' => 'Gestion prise en charge', 'desc' => 'Planning, administratif et suivi gérés par nos soins. Vous gardez un seul contact.' ),
	array( 'num' => '04', 'title' => 'Tarif transparent', 'desc' => 'Tarif annoncé avant le devis, frais indiqués à l\'avance. Aucune offre opaque.' ),
);

$featured_review = ! empty( $reassurance['avis'] ) ? $reassurance['avis'][0] : null;
$audrey_photo    = tfp_get_audrey_photo_url();
?>
<section class="tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div class="tfp-audrey-portrait">
			<?php if ( $audrey_photo ) : ?>
				<img
					src="<?php echo esc_url( $audrey_photo ); ?>"
					alt="<?php echo esc_attr( tfp_audrey_photo_is_real() ? ( $site['manager'] . ', gérante de ' . $site['brand_name'] ) : 'Photo d’illustration temporaire — portrait définitif à venir' ); ?>"
					style="width:100%;aspect-ratio:4/5;object-fit:cover;border-radius:var(--radius-xl);background:var(--color-border)"
					loading="lazy"
				>
				<?php if ( ! tfp_audrey_photo_is_real() ) : ?>
					<p style="margin-top:10px;font-size:12.5px;color:var(--color-text-tertiary);text-align:center">Photo d’illustration</p>
				<?php endif; ?>
			<?php else : ?>
				<div style="width:100%;aspect-ratio:4/5;border-radius:var(--radius-xl);background:linear-gradient(160deg,var(--color-primary),var(--color-navy));display:flex;align-items:center;justify-content:center">
					<span style="font-family:var(--font-heading);font-weight:800;font-size:96px;color:var(--color-turquoise-pale)" aria-hidden="true"><?php echo esc_html( mb_substr( $first_name, 0, 1 ) ); ?></span>
				</div>
				<p style="margin-top:10px;font-size:12.5px;color:var(--color-text-tertiary);text-align:center">Photo à venir</p>
			<?php endif; ?>
		</div>

		<div>
			<h2 style="font-size:clamp(26px,3.4vw,40px)"><?php echo esc_html( $first_name ); ?>, votre interlocutrice</h2>
			<p style="margin-top:16px;font-size:19px;color:var(--color-text-secondary);line-height:1.6">
				<?php echo esc_html( $first_name ); ?> suit votre dossier du premier échange jusqu'au suivi de la prestation : un seul contact, joignable directement, qui connaît vos locaux et vos consignes.
			</p>

			<div class="tfp-why-list">
				<?php foreach ( $why_items as $item ) : ?>
					<div class="tfp-why-item">
						<span class="tfp-why-item__num" aria-hidden="true"><?php echo esc_html( $item['num'] ); ?></span>
						<div>
							<div class="tfp-why-item__title"><?php echo esc_html( $item['title'] ); ?></div>
							<p class="tfp-why-item__desc"><?php echo esc_html( $item['desc'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<a href="<?php echo esc_url( home_url( '/pourquoi-nous/' ) ); ?>" class="tfp-eyebrow-link">Toutes nos preuves →</a>

			<?php if ( $featured_review && ! empty( $featured_review['texte'] ) ) : ?>
				<div class="tfp-card" style="margin-top:28px">
					<blockquote style="font-size:17px;line-height:1.55;color:var(--color-text)">« <?php echo esc_html( $featured_review['texte'] ); ?> »</blockquote>
					<div style="margin-top:14px;font-weight:600">
						<?php echo esc_html( $featured_review['nom'] ); ?>
						<?php if ( ! empty( $featured_review['contexte'] ) ) : ?>
							<span style="font-weight:400;color:var(--color-text-tertiary)"> · <?php echo esc_html( $featured_review['contexte'] ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="tfp-todo-block" style="margin-top:28px">
					<strong>Avis clients à venir.</strong> Les six témoignages authentiques déjà publiés seront intégrés ici (page Réassurance &amp; avis de l'administration).
				</div>
			<?php endif; ?>

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
