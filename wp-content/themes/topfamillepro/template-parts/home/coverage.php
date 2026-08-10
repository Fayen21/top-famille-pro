<?php
/**
 * 7. Couverture régionale.
 * Titre corrigé selon CLAUDE.md §9 : « Une couverture régionale, pas des agences fictives »
 * Titre repris mot pour mot de la maquette (décision du 10 août 2026). Il ne contredit d'ailleurs
 * pas CLAUDE.md §5.2 : il affirme précisément qu'il n'y a pas d'agences. Un seul établissement :
 * les liens ci-dessous pointent vers des pages de zone desservie, jamais une adresse locale.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$dept_nums = array(
	"Côte-d'Or"              => '21',
	'Doubs'                  => '25',
	'Jura'                   => '39',
	'Nièvre'                 => '58',
	'Haute-Saône'            => '70',
	'Saône-et-Loire'         => '71',
	'Yonne'                  => '89',
	'Territoire de Belfort'  => '90',
);
?>
<section class="tfp-section tfp-section--turquoise">
	<div class="tfp-container tfp-two-col">
		<div>
			<h2>Une couverture régionale, pas des agences fictives</h2>
			<p style="margin-top:14px;font-size:17px;color:var(--color-text-secondary)">
				Nous intervenons depuis <?php echo esc_html( $site['address_city'] ); ?> sur les huit départements de la <?php echo esc_html( $site['address_region'] ); ?>, avec la même organisation partout.
			</p>
			<div class="tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,150px),1fr));margin-top:22px">
				<?php foreach ( $site['departements'] as $dept_name ) : ?>
					<?php $slug = sanitize_title( remove_accents( $dept_name ) ); ?>
					<a class="tfp-dept-link" href="<?php echo esc_url( home_url( '/zones-intervention/' . $slug . '/' ) ); ?>">
						<span><?php echo esc_html( $dept_name ); ?></span>
						<span class="tfp-dept-link__num"><?php echo esc_html( $dept_nums[ $dept_name ] ?? '' ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>" class="tfp-eyebrow-link">Toutes les villes →</a>
		</div>

		<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:26px;display:flex;align-items:center;justify-content:center;min-height:260px">
			<svg viewBox="0 0 320 280" style="width:100%;max-width:300px" role="img" aria-label="Carte stylisée des huit départements de Bourgogne-Franche-Comté">
				<path d="M60,40 L150,18 L232,44 L272,92 L282,152 L248,212 L188,252 L108,256 L52,210 L28,138 L34,78 Z" fill="var(--color-turquoise-pale-2)" stroke="var(--color-turquoise)" stroke-width="2.5" stroke-linejoin="round"></path>
				<g font-family="'Bricolage Grotesque'" font-size="12" font-weight="700" fill="#fff" text-anchor="middle">
					<circle cx="118" cy="82" r="16" fill="var(--color-primary)"></circle><text x="118" y="86.5">21</text>
					<circle cx="205" cy="102" r="16" fill="var(--color-primary)"></circle><text x="205" y="106.5">25</text>
					<circle cx="238" cy="160" r="16" fill="var(--color-primary)"></circle><text x="238" y="164.5">39</text>
					<circle cx="72" cy="152" r="16" fill="var(--color-primary)"></circle><text x="72" y="156.5">58</text>
					<circle cx="222" cy="68" r="16" fill="var(--color-primary)"></circle><text x="222" y="72.5">70</text>
					<circle cx="145" cy="196" r="16" fill="var(--color-primary)"></circle><text x="145" y="200.5">71</text>
					<circle cx="92" cy="70" r="16" fill="var(--color-primary)"></circle><text x="92" y="74.5">89</text>
					<circle cx="262" cy="112" r="16" fill="var(--color-copper)"></circle><text x="262" y="116.5" fill="var(--color-navy)">90</text>
				</g>
			</svg>
		</div>
	</div>
</section>
