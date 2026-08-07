<?php
/**
 * Page statique « Mentions légales » (/mentions-legales/) — gabarit dédié (CLAUDE.md §3).
 *
 * Réécrite entièrement, PAS recopiée de l'ancien site (CLAUDE.md §5.7) : les mentions légales de
 * topentreprise.fr présentaient le SIREN comme un identifiant fiscal (faux), omettaient SIRET,
 * capital et APE, et comportaient une clause visant « Top-Famille » au lieu de l'entité éditrice
 * réelle.
 *
 * BLOQUEUR DE MISE EN LIGNE (CLAUDE.md §5.7, STATUS.md §6) : une incohérence non levée existe sur
 * l'identifiant de la société — le SIREN relevé sur les mentions légales actuelles (938 472 242)
 * diffère des 9 premiers chiffres d'un SIRET trouvé par ailleurs pour la même entité
 * (938 472 420). Aucune donnée d'immatriculation n'est donc publiée ici tant que le Kbis ne les a
 * pas confirmées — y compris le SIREN/RCS, malgré sa source apparente, puisque cette source
 * elle-même est en cause. CLAUDE.md §5.1 : une valeur manquante s'écrit [À COMPLÉTER] en clair,
 * jamais une valeur plausible.
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
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:760px;display:flex;flex-direction:column;gap:32px">

		<div>
			<h2>Éditeur du site</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">
				<?php echo esc_html( $site['legal_name'] ); ?>, exploitant la marque commerciale <?php echo esc_html( $site['brand_name'] ); ?>, société à responsabilité limitée (SARL).<br>
				Siège social : <?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?>.<br>
				RCS / SIREN / SIRET : [À COMPLÉTER] — donnée en attente de confirmation par extrait Kbis avant publication (incohérence relevée entre deux sources, non résolue à ce jour).<br>
				Capital social : [À COMPLÉTER].<br>
				Numéro de TVA intracommunautaire : [À COMPLÉTER].<br>
				Code APE/NAF : [À COMPLÉTER].<br>
				Gérante : <?php echo esc_html( $site['manager'] ); ?>.<br>
				Directrice de la publication : [À COMPLÉTER].<br>
				Contact : <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a> — <?php echo esc_html( $site['phone'] ); ?>.
			</p>
		</div>

		<div>
			<h2>Assurance professionnelle</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Assureur et numéro de police : [À COMPLÉTER].</p>
		</div>

		<div>
			<h2>Hébergement</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">
				Ce site est hébergé par Hostinger International Ltd.<br>
				Adresse et coordonnées complètes de l'hébergeur : [À COMPLÉTER].
			</p>
		</div>

		<div>
			<h2>Établissement unique</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $site['brand_name'] ); ?> dispose d'un seul établissement, à l'adresse indiquée ci-dessus. Les pages de zones d'intervention de ce site présentent des secteurs géographiques desservis, pas des agences ou des implantations locales.</p>
		</div>

		<div>
			<h2>Propriété intellectuelle</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">L'ensemble des contenus de ce site (textes, structure, mise en page) est la propriété de <?php echo esc_html( $site['legal_name'] ); ?>, sauf mention contraire. Toute reproduction non autorisée est interdite.</p>
		</div>

		<div>
			<h2>Données personnelles</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Le traitement des données personnelles collectées via ce site (notamment le formulaire de demande de devis) est détaillé dans notre <a class="tfp-underline" href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">politique de confidentialité</a>.</p>
		</div>

		<div>
			<h2>Droit applicable</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Le présent site est soumis au droit français. En cas de litige, et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
