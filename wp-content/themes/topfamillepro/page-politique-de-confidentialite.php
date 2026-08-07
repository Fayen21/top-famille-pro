<?php
/**
 * Page statique « Politique de confidentialité » (/politique-de-confidentialite/) — gabarit dédié
 * (CLAUDE.md §3). Réécrite, pas recopiée de l'ancien site (§5.7 — la page « données personnelles »
 * de topentreprise.fr n'a pas été relevée, PROJECT_INPUTS.md §11).
 *
 * Décrit ce que le formulaire de demande de devis (includes/quote-form.php) collecte réellement —
 * pas une politique générique : nom, e-mail, téléphone et structure facultatifs, message, contexte
 * technique de la demande (page d'origine, référent, paramètres UTM) et adresse IP à des fins
 * de lutte anti-spam (limitation de fréquence). Sous-traitants, durée de conservation et contact
 * RGPD restent [À COMPLÉTER] : PROJECT_INPUTS.md §11 les liste comme manquants.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Politique de confidentialité | ' . $site['brand_name'],
		'description' => 'Comment ' . $site['brand_name'] . ' traite les données transmises via le formulaire de demande de devis.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Politique de confidentialité', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Politique de confidentialité</h1>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:760px;display:flex;flex-direction:column;gap:32px">

		<div>
			<h2>Responsable du traitement</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7"><?php echo esc_html( $site['legal_name'] ); ?>, exploitant la marque <?php echo esc_html( $site['brand_name'] ); ?>, <?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?> — <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a>.</p>
		</div>

		<div>
			<h2>Données collectées</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Le seul formulaire de ce site est la demande de devis. Il collecte :</p>
			<ul style="margin-top:10px;padding-left:20px;color:var(--color-text-secondary);line-height:1.8">
				<li>Nom et adresse e-mail (obligatoires)</li>
				<li>Téléphone et nom de votre structure (facultatifs)</li>
				<li>Le message décrivant votre besoin</li>
				<li>Le contexte technique de la demande : page depuis laquelle vous avez accédé au formulaire, site référent, paramètres de campagne (UTM) le cas échéant</li>
				<li>Votre adresse IP, à des fins de limitation du nombre de soumissions (lutte contre les envois automatisés)</li>
			</ul>
		</div>

		<div>
			<h2>Finalité et destinataire</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Ces données sont utilisées exclusivement pour répondre à votre demande de devis. Elles sont transmises par e-mail à <?php echo esc_html( $site['manager'] ); ?>, qui les traite personnellement. Elles ne sont ni vendues, ni cédées, ni utilisées à des fins commerciales autres que le traitement de votre demande.</p>
		</div>

		<div>
			<h2>Durée de conservation</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">[À COMPLÉTER] — durée à définir avec le client avant mise en ligne (PROJECT_INPUTS.md, question ouverte).</p>
		</div>

		<div>
			<h2>Sous-traitants</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Hébergement du site : Hostinger International Ltd. Autres sous-traitants éventuels (envoi d'e-mails, mesure d'audience) : [À COMPLÉTER] — aucun outil de mesure d'audience n'est installé sur ce site à ce jour (voir notre page Gestion des cookies).</p>
		</div>

		<div>
			<h2>Vos droits</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification, d'effacement et de limitation du traitement de vos données. Pour exercer ces droits, contactez-nous à <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a>.</p>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Contact référent RGPD : [À COMPLÉTER].</p>
		</div>

		<div>
			<h2>Candidatures</h2>
			<p style="margin-top:10px;color:var(--color-text-secondary);line-height:1.7">Ce site ne collecte aucune candidature ni CV : le recrutement est géré sur notre <a class="tfp-underline" href="<?php echo esc_url( home_url( '/recrutement/' ) ); ?>">site carrière dédié</a>.</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
