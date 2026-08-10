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
	/*
	 * Nombre de colonnes : relevé sur le rendu de la maquette par tools/generate-pages.mjs, et non
	 * deviné d'après la longueur des blocs. L'heuristique précédente (« plusieurs blocs courts ⇒
	 * colonnes ») se trompait notamment sur « Qui nous sommes » de /a-propos/, que la maquette
	 * empile sur toute la largeur.
	 *
	 * Le `?:` couvre les contenus produits avant l'ajout du champ : sans valeur relevée, on empile,
	 * ce qui reste lisible — l'inverse ne l'est pas.
	 */
	$colonnes = max( 1, min( 4, (int) ( $section['colonnes'] ?? 1 ) ) );
	$grille   = $colonnes > 1 && count( $section['blocs'] ) > 1;
	?>
	<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="tfp-container<?php echo $grille ? ' tfp-static-grid tfp-static-grid--' . (int) $colonnes : ''; ?>">
			<?php
			foreach ( $section['blocs'] as $bloc ) :
				// Les clés absentes d'un bloc généré avant l'ajout d'un type de contenu ne doivent pas
				// faire tomber le rendu : on complète systématiquement.
				$bloc = wp_parse_args(
					$bloc,
					array( 'titre' => '', 'niveau' => 'h2', 'textes' => array(), 'liste' => array(), 'liens' => array(), 'noms' => array(), 'citations' => array(), 'faq' => array(), 'etapes' => array() )
				);
				// Un bloc qui porte des citations est un bloc de témoignages repris de la maquette : il
				// est marqué provisoire, comme les cartes témoignage, pour rester repérable en une
				// requête et pour être exclu du contrôle « aucune donnée fictive » — il est destiné à
				// être remplacé par de vrais avis (CLAUDE.md §5.5).
				$provisoire = ! empty( $bloc['citations'] );
				?>
				<div class="tfp-static-block"<?php echo $provisoire ? ' data-tfp-provisional="1"' : ''; ?>>
					<?php if ( $bloc['titre'] ) : ?>
						<?php printf( '<%1$s>%2$s</%1$s>', esc_attr( $bloc['niveau'] ), esc_html( $bloc['titre'] ) ); ?>
					<?php endif; ?>

					<?php foreach ( $bloc['textes'] as $texte ) : ?>
						<p class="tfp-prose"><?php echo esc_html( $texte ); ?></p>
					<?php endforeach; ?>

					<?php if ( ! empty( $bloc['etapes'] ) ) : ?>
						<?php
						/*
						 * Étapes numérotées de la maquette : pastille à gauche, intitulé et texte à
						 * droite, dans une carte. Une liste ordonnée est le balisage juste — l'ordre
						 * porte du sens ici — et le numéro visible est donc `aria-hidden`, sinon un
						 * lecteur d'écran annonce deux fois le rang de chaque étape.
						 */
						?>
						<ol class="tfp-steps">
							<?php foreach ( $bloc['etapes'] as $etape ) : ?>
								<li class="tfp-step">
									<span class="tfp-step__num" aria-hidden="true"><?php echo esc_html( $etape['numero'] ); ?></span>
									<div class="tfp-step__body">
										<strong class="tfp-step__titre"><?php echo esc_html( $etape['titre'] ); ?></strong>
										<p class="tfp-prose"><?php echo esc_html( $etape['texte'] ); ?></p>
									</div>
								</li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>

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
