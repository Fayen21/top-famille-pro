<?php
/**
 * Page statique « Mentions légales » (/mentions-legales/) — gabarit dédié (CLAUDE.md §3).
 *
 * Réécrite entièrement, PAS recopiée de l'ancien site (CLAUDE.md §5.7) : les mentions légales de
 * topentreprise.fr présentaient le SIREN comme un identifiant fiscal (faux), omettaient SIRET,
 * capital et APE, et comportaient une clause visant « Top-Famille » au lieu de l'entité éditrice
 * réelle.
 *
 * Données d'immatriculation confirmées en phase 7 par extrait Pappers puis complément client
 * (SIRET, APE, TVA) — l'incohérence relevée en phase 0 sur le SIREN (l'ancien site annonçait
 * 938 472 242, valeur confirmée : 938 472 420) est levée. Toutes les valeurs proviennent de
 * `tfp_site_data()` (includes/site-options.php), jamais recopiées ni recalculées ici.
 *
 * 9 août 2026 (hotfix fidélité Claude Design) : directrice de la publication et coordonnées
 * complètes de l'hébergeur confirmées, plus aucun [À COMPLÉTER] sur cette page. La section
 * « Assurance professionnelle » est retirée (sur instruction explicite) plutôt que laissée en
 * placeholder — l'assureur et le numéro de police restent à transmettre, PROJECT_INPUTS.md §12.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Mentions légales | ' . $site['brand_name'],
		'description' => 'Mentions légales de ' . $site['brand_name'] . ' — éditeur, hébergeur, propriété intellectuelle et données personnelles.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Mentions légales', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Mentions légales</h1>
	<p class="tfp-section__lede">Informations légales relatives au site top-famille-pro.fr et à son éditeur.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:760px;display:flex;flex-direction:column;gap:32px">

		<div>
			<h2>Éditeur du site</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">
				<?php echo esc_html( $site['legal_name'] ); ?>, exploitant la marque commerciale <?php echo esc_html( $site['brand_name'] ); ?>, <?php echo esc_html( $site['legal_form'] ); ?> au capital social de <?php echo esc_html( $site['legal_capital_display'] ); ?>.<br>
				Siège social : <?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?>.<br>
				Immatriculée au RCS (registre du commerce et des sociétés) de <?php echo esc_html( $site['legal_rcs_city'] ); ?> sous le numéro <?php echo esc_html( $site['legal_siren'] ); ?>, le <?php echo esc_html( $site['legal_immatriculation_date'] ); ?>.<br>
				SIREN : <?php echo esc_html( $site['legal_siren'] ); ?> — SIRET (siège) : <?php echo esc_html( $site['legal_siret'] ); ?>.<br>
				Code APE/NAF : <?php echo esc_html( $site['legal_ape_code'] ); ?> (<?php echo esc_html( $site['legal_ape_label'] ); ?>).<br>
				Numéro de TVA intracommunautaire : <?php echo esc_html( $site['legal_tva'] ); ?>.<br>
				Activité : <?php echo esc_html( lcfirst( $site['legal_activity'] ) ); ?>, débutée le <?php echo esc_html( $site['legal_activity_start_date'] ); ?>.<br>
				Gérante : <?php echo esc_html( $site['manager'] ); ?>.<br>
				Directrice de la publication : <?php echo esc_html( $site['legal_publication_director'] ); ?>.<br>
				Contact : <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a> — <?php echo esc_html( $site['phone'] ); ?>.
			</p>
		</div>

		<div>
			<h2>Hébergement</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">
				Le site est hébergé par :<br>
				<?php echo esc_html( $site['host_name'] ); ?><br>
				<?php echo esc_html( $site['host_address'] ); ?><br>
				E-mail : <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['host_email'] ); ?>"><?php echo esc_html( $site['host_email'] ); ?></a><br>
				Site : <a class="tfp-underline" href="<?php echo esc_url( $site['host_website'] ); ?>" rel="noopener"><?php echo esc_html( $site['host_website'] ); ?></a>
			</p>
		</div>

		<div>
			<h2>Établissement unique</h2>
			<?php
			/*
			 * Phrase reprise de la maquette, à une exception près, la seule autorisée : elle y
			 * annonce « forme juridique, capital, SIREN/SIRET, RCS et TVA : à compléter ». Ces
			 * données sont désormais confirmées par le Kbis, donc écrites en clair — publier
			 * « à compléter » sur des mentions légales serait une non-conformité, pas une fidélité.
			 */
			?>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $site['brand_name'] ); ?> — activité dédiée aux professionnels de Top-Famille. Implantation : <?php echo esc_html( $site['address_city'] ); ?> (<?php echo esc_html( $site['address_cp'] ); ?>), Côte-d'Or, <?php echo esc_html( $site['address_region'] ); ?>. Responsable de la publication : <?php echo esc_html( $site['legal_publication_director'] ); ?>. Téléphone : <?php echo esc_html( $site['phone'] ); ?>. E-mail : <?php echo esc_html( $site['email'] ); ?>.</p>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $site['brand_name'] ); ?> dispose d'un seul établissement, à l'adresse indiquée ci-dessus. Les pages de zones d'intervention de ce site présentent des secteurs géographiques desservis, pas des agences ou des implantations locales.</p>
		</div>

		<div>
			<h2>Propriété intellectuelle</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Les textes, la charte graphique et les logos <?php echo esc_html( $site['brand_name'] ); ?> sont la propriété de leur éditeur. Les photographies actuellement affichées sont des visuels sous licence, utilisés à titre provisoire ; leur auteur et leur licence seront précisés lors de la mise en ligne. Elles ne représentent ni les locaux de nos clients, ni nos intervenants, ni la gérante.</p>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">L'ensemble des contenus de ce site (textes, structure, mise en page) est la propriété de <?php echo esc_html( $site['legal_name'] ); ?>, sauf mention contraire. Toute reproduction non autorisée est interdite.</p>
		</div>

		<div>
			<h2>Données personnelles</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Le traitement des données personnelles collectées via ce site (notamment le formulaire de demande de devis) est détaillé dans notre <a class="tfp-underline" href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">politique de confidentialité</a>.</p>
		</div>

		<div>
			<h2>Droit applicable</h2>
			<h2 style="font-size:20px;margin-top:28px">Médiation de la consommation</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Dispositif applicable et coordonnées du médiateur : à confirmer selon la nature des clients concernés. <strong>[À COMPLÉTER]</strong> avant mise en ligne.</p>

			<h2 style="font-size:20px;margin-top:28px">Droit applicable</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Le présent site est soumis au droit français. En cas de litige, et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
