<?php
/**
 * Page statique « À propos » (/a-propos/) — gabarit dédié (CLAUDE.md §3).
 *
 * Identité réelle uniquement (PROJECT_INPUTS.md §1) : aucune donnée d'immatriculation (SIRET,
 * capital, APE, TVA) tant que le Kbis ne les a pas confirmées (STATUS.md §6, bloqueur de mise en
 * ligne) — ce n'est pas l'objet de cette page de toute façon, réservé aux mentions légales une
 * fois les données confirmées. Même mécanisme de portrait que l'accueil
 * (tfp_get_audrey_photo_url() / tfp_audrey_photo_is_real(), includes/customizer.php) : visuel
 * d'illustration temporaire avec alt honnête tant que la vraie photo n'est pas fournie, jamais
 * présenté comme Audrey, aucune biographie inventée.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site         = tfp_site_data();
$first_name   = explode( ' ', $site['manager'] )[0];
$audrey_photo = tfp_get_audrey_photo_url();

tfp_seo(
	array(
		'title'       => 'À propos de Top-Famille Pro | ' . $first_name . ', votre interlocutrice',
		'description' => 'Une entreprise de nettoyage implantée à Saint-Apollinaire, en périphérie de Dijon, avec une interlocutrice unique du devis au suivi.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'À propos', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>À propos de <?php echo esc_html( $site['brand_name'] ); ?></h1>
</section>

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
			<h2 style="font-size:clamp(26px,3.4vw,34px)"><?php echo esc_html( $site['manager'] ); ?>, gérante</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $site['brand_name'] ); ?> est la branche professionnelle du groupe Top-Famille : nettoyage de locaux professionnels en <?php echo esc_html( $site['address_region'] ); ?>. L'entreprise a un seul établissement, à <?php echo esc_html( $site['address_city'] ); ?> (<?php echo esc_html( $site['address_cp'] ); ?>) — pas d'agences locales, pas de franchise.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.7">Du premier échange au suivi mensuel, <?php echo esc_html( $first_name ); ?> reste votre interlocutrice unique : devis, sélection de l'intervenant, cahier des charges, suivi de la prestation.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.7">L'activité est exercée en prestataire : les intervenants sont salariés de l'entreprise, sélectionnés et suivis directement, pas mis à disposition par un tiers.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Notre marque sœur</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.7">Top-Famille Pro est la branche professionnelle de <strong>Top-Famille</strong>, spécialisée dans les services à la personne pour les particuliers. Les deux marques partagent la même exigence de sélection et de suivi des intervenants, sur des publics différents : professionnels d'un côté, particuliers de l'autre.</p>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Échanger avec <?php echo esc_html( $first_name ); ?></h2>
		<p>Gratuit · Sans engagement · Réponse sous 24 h</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
