<?php
/**
 * 8. « Pourquoi Top-Famille Pro » — bloc 7 du prototype Claude Design.
 *
 * Rendu à sa place d'origine depuis le 9 août 2026 (hotfix de fidélité). Il avait été fusionné
 * dans le bloc « Audrey » en phase 1 au motif que deux blocs de réassurance se suivaient : la
 * comparaison du rendu réel avec la maquette montre que cette fusion supprimait une section
 * entière et modifiait le rythme vertical de l'accueil (deux blocs de 592 px et 698 px réduits à
 * un seul). Les deux blocs sont donc de nouveau distincts, comme dans la maquette.
 *
 * Colonne droite : carte témoignage (includes/testimonials.php) — témoignage réel s'il en existe
 * un, contenu de démonstration hors production seulement, état neutre sinon. Jamais de note
 * Google ni de schéma Review/AggregateRating (CLAUDE.md §5.5).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site       = tfp_site_data();
$first_name = explode( ' ', $site['manager'] )[0];

$why_items = array(
	array( 'num' => '01', 'title' => 'Directement joignable', 'desc' => $first_name . ', une interlocutrice identifiée qui connaît votre dossier — pas un standard anonyme.' ),
	array( 'num' => '02', 'title' => 'Intervenants sélectionnés & attitrés', 'desc' => 'La même personne autant que possible, qui connaît vos locaux et vos consignes.' ),
	array( 'num' => '03', 'title' => 'Gestion prise en charge', 'desc' => 'Planning, administratif et suivi gérés par nos soins. Vous gardez un seul contact.' ),
	array( 'num' => '04', 'title' => 'Tarif transparent', 'desc' => tfp_format_price( $site['price_unique'] ) . ' HT/h affiché, frais annoncés, exemples chiffrés. Aucune offre opaque.' ),
);
?>
<section class="tfp-section">
	<div class="tfp-container tfp-why">
		<div class="tfp-why__main">
			<h2>Pourquoi <?php echo esc_html( $site['brand_name'] ); ?></h2>

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
		</div>

		<div class="tfp-why__aside">
			<?php tfp_testimonial_card( null, array( 'avatar' => true ) ); ?>
		</div>
	</div>
</section>
