<?php
/**
 * Composant commun de rendu des pages statiques narratives.
 *
 * Ces pages sont des pages WordPress classiques (CLAUDE.md §3), sans champs ACF : leur contenu vit
 * dans une option par page, produite par tools/generate-pages.mjs depuis la maquette Claude
 * Design. Un seul composant les rend toutes, ce qui évite dix gabarits qui divergeraient à la
 * première correction, et garde l'ordre des sections figé.
 *
 * Les routes internes de la maquette (`#/…`) ne sont jamais servies telles quelles : elles sont
 * traduites en URL WordPress réelles à l'affichage. Une route sans équivalent n'est pas rendue en
 * lien mort — son libellé reste du texte (CLAUDE.md §8).
 *
 * @var array $args {
 *     @type string $key   Clé de page (`pourquoi-nous`, `a-propos`…).
 *     @type array  $skip  Index de sections à ne pas rendre (déjà couvertes par le gabarit).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$data = tfp_static_page_data( $args['key'] ?? '' );
if ( empty( $data['sections'] ) ) {
	return;
}
$skip = $args['skip'] ?? array();

foreach ( $data['sections'] as $section ) {
	if ( in_array( $section['index'], $skip, true ) ) {
		continue;
	}
	$classes = array( 'tfp-section--tight' );
	if ( 'turquoise' === $section['fond'] ) {
		$classes[] = 'tfp-section--turquoise';
	} elseif ( 'navy' === $section['fond'] ) {
		$classes[] = 'tfp-section--navy';
	} elseif ( 'primary' === $section['fond'] ) {
		$classes[] = 'tfp-section--primary';
	} elseif ( 'alt' === $section['fond'] ) {
		$classes[] = 'tfp-section--alt';
	}
	// Plusieurs blocs courts dans une même bande se répartissent en colonnes, comme dans la
	// maquette. Un bloc long (plusieurs paragraphes, une FAQ) garde toute la largeur : le mettre
	// en colonne étroite rendrait la lecture pénible pour gagner quelques pixels.
	$courts = 0;
	foreach ( $section['blocs'] as $b ) {
		if ( count( $b['textes'] ?? array() ) <= 1 && empty( $b['faq'] ) ) {
			$courts++;
		}
	}
	$grille = count( $section['blocs'] ) > 1 && $courts === count( $section['blocs'] );
	?>
	<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="tfp-container<?php echo $grille ? ' tfp-zone-links-grid' : ''; ?>">
			<?php foreach ( $section['blocs'] as $bloc ) : ?>
				<div class="tfp-static-block">
					<?php if ( $bloc['titre'] ) : ?>
						<?php printf( '<%1$s>%2$s</%1$s>', esc_attr( $bloc['niveau'] ), esc_html( $bloc['titre'] ) ); ?>
					<?php endif; ?>

					<?php foreach ( $bloc['textes'] as $texte ) : ?>
						<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
					<?php endforeach; ?>

					<?php foreach ( $bloc['citations'] as $citation ) : ?>
						<blockquote class="tfp-quote"><?php echo esc_html( $citation ); ?></blockquote>
					<?php endforeach; ?>

					<?php if ( ! empty( $bloc['faq'] ) ) : ?>
						<div style="margin-top:20px">
							<?php foreach ( $bloc['faq'] as $item ) : ?>
								<details class="tfp-card" style="margin-bottom:10px">
									<summary style="font-weight:600;font-size:17px;cursor:pointer"><?php echo esc_html( $item['question'] ); ?></summary>
									<p style="margin-top:12px;color:var(--color-text-secondary)"><?php echo esc_html( $item['reponse'] ); ?></p>
								</details>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $bloc['liste'] ) ) : ?>
						<ul class="tfp-list-plain">
							<?php foreach ( $bloc['liste'] as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( ! empty( $bloc['liens'] ) ) : ?>
						<div class="tfp-stack" style="margin-top:16px">
							<?php
							foreach ( $bloc['liens'] as $lien ) :
								$url = tfp_route_to_url( $lien['route'] );
								if ( ! $url ) :
									?>
									<span class="tfp-link-row tfp-link-row--static"><?php echo esc_html( $lien['texte'] ); ?></span>
									<?php
								else :
									?>
									<a class="tfp-link-row" href="<?php echo esc_url( $url ); ?>">
										<?php echo esc_html( rtrim( $lien['texte'], '→ ' ) ); ?><span aria-hidden="true">→</span>
									</a>
									<?php
								endif;
							endforeach;
							?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $bloc['noms'] ) ) : ?>
						<div class="tfp-flex" style="margin-top:14px">
							<?php foreach ( $bloc['noms'] as $nom ) : ?>
								<span class="tfp-chip tfp-chip--static"><?php echo esc_html( $nom ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}
