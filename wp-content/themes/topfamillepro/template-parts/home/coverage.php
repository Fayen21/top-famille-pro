<?php
/**
 * 7. Couverture régionale — colonne de liens + VRAIE carte des huit départements.
 *
 * Décision du 14 octobre 2026 : le polygone stylisé et ses huit pastilles approximatives sont
 * remplacés par un SVG construit à partir de géométries administratives réelles — IGN ADMIN
 * EXPRESS COG 2018, projection et échelle communes, topologie intacte (tools/carte-bfc.mjs,
 * docs/CARTE-BFC-SOURCE.md). Les huit surfaces portent la même couleur : le zonage représente la
 * couverture déclarée, pas des niveaux de service. Un seul repère, Saint-Apollinaire, légendé
 * « Implantation de Top-Famille Pro » — aucun repère sur une autre ville, qui laisserait croire à
 * des agences (CLAUDE.md §5.2).
 *
 * Chaque département de la carte est un lien vers sa page, avec un état de focus visible. La
 * colonne de gauche garde sa liste de liens : c'est la version accessible et lisible sans carte.
 *
 * Titre : « Une entreprise régionale basée à Saint-Apollinaire » depuis la revue du 25 octobre
 * 2026 (CLAUDE.md §9). Légende sur deux lignes : le repère, puis la couverture.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site  = tfp_site_data();
$depts = tfp_departements_nav();
$carte = include __DIR__ . '/carte-bfc.php';
$par_code = array();
foreach ( $carte['departements'] as $d ) {
	$par_code[ $d['code'] ] = $d;
}
?>
<section class="tfp-section tfp-section--turquoise" aria-labelledby="tfp-couverture-titre">
	<div class="tfp-container tfp-couverture">
		<div class="tfp-couverture__col">
			<?php
			/*
			 * Intitulé imposé par CLAUDE.md §9, différé le 10 août 2026 pour reproduire d'abord la
			 * maquette, puis explicitement autorisé par la revue des trois ZIP du 25 octobre 2026
			 * (§5) — docs/ECARTS-MAQUETTE-AUTORISES.md. Le chapeau dit ce que couvre la carte : huit
			 * départements, un même tarif horaire, une organisation fixée au devis.
			 */
			?>
			<h2 id="tfp-couverture-titre">Une entreprise régionale basée à <?php echo esc_html( $site['address_city'] ); ?></h2>
			<p class="tfp-couverture__lede">
				Depuis <?php echo esc_html( $site['address_city'] ); ?>, près de Dijon, nous intervenons sur les huit départements de la <?php echo esc_html( $site['address_region'] ); ?>, au même tarif horaire partout. Fréquence, créneaux et éventuels frais de déplacement sont précisés dans votre devis.
			</p>
			<ul class="tfp-dept-list" aria-label="Les huit départements couverts">
				<?php foreach ( $depts as $dept ) : ?>
					<li>
						<a class="tfp-dept-link" href="<?php echo esc_url( $dept['url'] ); ?>">
							<span><?php echo esc_html( $dept['label'] ); ?></span>
							<span class="tfp-dept-link__num"><?php echo esc_html( $dept['num'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>" class="tfp-eyebrow-link">Toutes les villes →</a>
		</div>

		<div class="tfp-couverture__carte">
			<?php
			/*
			 * `role="group"`, pas `role="img"` : un rôle d'image rend ses descendants
			 * présentationnels, et les huit liens de département deviennent des contrôles imbriqués
			 * dans une image (axe « nested-interactive », WCAG 4.1.2). La carte est un groupe de
			 * liens nommé par son titre et sa description.
			 */
			?>
			<svg class="tfp-carte-bfc" viewBox="<?php echo esc_attr( $carte['viewbox'] ); ?>" role="group" aria-labelledby="tfp-carte-titre tfp-carte-desc" preserveAspectRatio="xMidYMid meet">
				<title id="tfp-carte-titre">Carte des huit départements de Bourgogne-Franche-Comté couverts par <?php echo esc_html( $site['brand_name'] ); ?></title>
				<desc id="tfp-carte-desc">Tracés IGN ADMIN EXPRESS COG. Les huit départements sont couverts à conditions identiques ; l'unique implantation de l'entreprise est à <?php echo esc_html( $site['address_city'] ); ?>.</desc>
				<g class="tfp-carte-bfc__departements">
					<?php foreach ( $depts as $dept ) : ?>
						<?php $g = $par_code[ $dept['num'] ] ?? null; if ( ! $g ) { continue; } ?>
						<a class="tfp-carte-bfc__dept" href="<?php echo esc_url( $dept['url'] ); ?>" aria-label="<?php echo esc_attr( $dept['label'] . ' (' . $dept['num'] . ') — voir la page' ); ?>">
							<path d="<?php echo esc_attr( $g['d'] ); ?>"></path>
							<?php if ( ! empty( $g['renvoi'] ) ) : ?>
								<line class="tfp-carte-bfc__renvoi" x1="<?php echo esc_attr( $g['etiquette']['x'] ); ?>" y1="<?php echo esc_attr( $g['etiquette']['y'] ); ?>" x2="<?php echo esc_attr( $g['renvoi']['x'] - 10 ); ?>" y2="<?php echo esc_attr( $g['renvoi']['y'] + 4 ); ?>"></line>
								<text class="tfp-carte-bfc__code tfp-carte-bfc__code--renvoi" x="<?php echo esc_attr( $g['renvoi']['x'] ); ?>" y="<?php echo esc_attr( $g['renvoi']['y'] + 8 ); ?>"><?php echo esc_html( $dept['num'] ); ?></text>
							<?php else : ?>
								<text class="tfp-carte-bfc__code" x="<?php echo esc_attr( $g['etiquette']['x'] ); ?>" y="<?php echo esc_attr( $g['etiquette']['y'] + 6 ); ?>"><?php echo esc_html( $dept['num'] ); ?></text>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</g>
				<g class="tfp-carte-bfc__siege" aria-hidden="true">
					<circle class="tfp-carte-bfc__siege-halo" cx="<?php echo esc_attr( $carte['siege']['x'] ); ?>" cy="<?php echo esc_attr( $carte['siege']['y'] ); ?>" r="13"></circle>
					<circle class="tfp-carte-bfc__siege-point" cx="<?php echo esc_attr( $carte['siege']['x'] ); ?>" cy="<?php echo esc_attr( $carte['siege']['y'] ); ?>" r="6"></circle>
					<text class="tfp-carte-bfc__siege-label" x="<?php echo esc_attr( $carte['siege']['x'] + 17 ); ?>" y="<?php echo esc_attr( $carte['siege']['y'] + 5 ); ?>">Implantation de <?php echo esc_html( $site['brand_name'] ); ?></text>
				</g>
				<text class="tfp-carte-bfc__source" x="<?php echo esc_attr( (int) explode( ' ', $carte['viewbox'] )[2] - 6 ); ?>" y="<?php echo esc_attr( (int) explode( ' ', $carte['viewbox'] )[3] - 6 ); ?>" aria-hidden="true">Tracés : <?php echo esc_html( $carte['source'] ); ?></text>
			</svg>
			<div class="tfp-carte-bfc__legende">
				<p class="tfp-carte-bfc__legende-repere">
					<span class="tfp-carte-bfc__legende-point" aria-hidden="true"></span>
					<span><strong><?php echo esc_html( $site['address_city'] ); ?></strong> — siège et unique implantation de <?php echo esc_html( $site['brand_name'] ); ?></span>
				</p>
				<p class="tfp-carte-bfc__legende-zone">
					<span class="tfp-carte-bfc__legende-aplat" aria-hidden="true"></span>
					<span>Départements couverts, aux mêmes conditions</span>
				</p>
			</div>
		</div>
	</div>
</section>
