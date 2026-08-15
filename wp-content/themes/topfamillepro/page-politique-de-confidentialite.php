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
 * Plus aucun [À COMPLÉTER] visible : les durées de conservation reprennent la formulation de la
 * maquette, qui annonce qu'elles seront précisées, et les deux autres rubriques énoncent des faits
 * vérifiables — aucun sous-traitant en dehors de l'hébergeur, aucun délégué désigné.
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
	<p class="tfp-section__lede">Comment les données transmises via ce site sont collectées, utilisées et conservées.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-legal-body" style="display:flex;flex-direction:column;gap:32px">

		<div>
			<h2>Responsable du traitement</h2>
			<p class="tfp-legal-p"><?php echo esc_html( $site['legal_name'] ); ?>, exploitant la marque <?php echo esc_html( $site['brand_name'] ); ?>, <?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?> — <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a>.</p>
		</div>

		<div>
			<h2>Données collectées</h2>
			<p class="tfp-legal-p">Les formulaires de devis et de contact collectent : société, nom, téléphone, e-mail, ville ou code postal, type de local, nature du besoin, volume estimé et message libre. Aucune donnée sensible n'est demandée. Aucun champ n'est obligatoire au-delà de ce qui est nécessaire pour vous répondre.</p>
			<p class="tfp-legal-p">Le détail des champs collectés :</p>
			<ul style="margin-top:10px;padding-left:20px;color:var(--color-text-secondary);line-height:1.8">
				<li>Nom et adresse e-mail (obligatoires)</li>
				<li>Téléphone et nom de votre structure (facultatifs)</li>
				<li>Le message décrivant votre besoin</li>
				<li>Le contexte technique de la demande : page depuis laquelle vous avez accédé au formulaire, site référent, paramètres de campagne (UTM) le cas échéant</li>
				<li>Votre adresse IP, à des fins de limitation du nombre de soumissions (lutte contre les envois automatisés)</li>
			</ul>
		</div>

		<div>
			<h2>Finalité et base légale</h2>
			<p class="tfp-legal-p">Ces données servent uniquement à établir un devis, répondre à une question ou traiter une candidature. Base légale : mesures précontractuelles prises à votre demande, ou consentement pour les échanges qui n'aboutissent pas à un devis. Elles ne sont ni revendues, ni utilisées à des fins publicitaires.</p>

			<h2>Destinataire</h2>
			<p class="tfp-legal-p">Ces données sont utilisées exclusivement pour répondre à votre demande de devis. Elles sont transmises par e-mail à <?php echo esc_html( $site['manager'] ); ?>, qui les traite personnellement. Elles ne sont ni vendues, ni cédées, ni utilisées à des fins commerciales autres que le traitement de votre demande.</p>
		</div>

		<div>
			<h2>Durée de conservation</h2>
			<p class="tfp-legal-p">Les durées varient selon la nature de la donnée : une demande restée sans suite n'est pas conservée aussi longtemps qu'un dossier client, et les pièces comptables obéissent à des obligations légales propres. Chaque donnée est supprimée dès qu'elle n'est plus nécessaire à la finalité pour laquelle elle a été collectée, ou à l'expiration du délai légal applicable.</p>
		</div>

		<div>
			<h2>Sous-traitants</h2>
			<p class="tfp-legal-p">Hébergement du site : Hostinger International Ltd. Aucun autre sous-traitant n'intervient à ce jour : aucun outil de mesure d'audience n'est installé sur ce site (voir notre page Gestion des cookies), et les demandes de devis sont transmises par courrier électronique.</p>
		</div>

		<div>
			<h2>Vos droits</h2>
			<p class="tfp-legal-p">Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation, d'opposition et de portabilité. Pour l'exercer, écrivez à <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a> ou appelez le <?php echo esc_html( $site['phone'] ); ?>. Vous pouvez également saisir la CNIL.</p>
			<p class="tfp-legal-p">Aucun délégué à la protection des données n'a été désigné : la demande se fait directement auprès de l'éditeur, à l'adresse indiquée ci-dessus.</p>
		</div>

		<div>
			<h2>Candidatures</h2>
			<p class="tfp-legal-p">Ce site ne collecte aucune candidature ni CV : le recrutement est géré sur notre <a class="tfp-underline" href="<?php echo esc_url( home_url( '/recrutement/' ) ); ?>">site carrière dédié</a>.</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
