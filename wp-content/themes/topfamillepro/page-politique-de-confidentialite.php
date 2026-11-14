<?php
/**
 * Page statique « Politique de confidentialité » (/politique-de-confidentialite/) — gabarit dédié
 * (CLAUDE.md §3). Réécrite, pas recopiée de l'ancien site (§5.7 — la page « données personnelles »
 * de topentreprise.fr n'a pas été relevée, PROJECT_INPUTS.md §11).
 *
 * Décrit ce que les formulaires de devis (includes/quote-form.php) et de contact
 * (includes/contact-form.php) collectent réellement, chacun séparément (revue du 25 octobre 2026) —
 * pas une politique générique : pour le devis, nom et téléphone OU e-mail ; pour le contact, nom,
 * e-mail et objet ; message, contexte
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

<section class="tfp-container tfp-section--tight tfp-legal-tete">
	<h1>Politique de confidentialité</h1>
	<p class="tfp-section__lede">Comment les données transmises via ce site sont collectées, utilisées et conservées.</p>
</section>

<section class="tfp-section tfp-legal-corps">
	<div class="tfp-container tfp-legal-body" style="display:flex;flex-direction:column;gap:32px">

		<div>
			<h2>Responsable du traitement</h2>
			<p class="tfp-legal-p"><?php echo esc_html( $site['legal_name'] ); ?>, exploitant la marque <?php echo esc_html( $site['brand_name'] ); ?>, <?php echo esc_html( $site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] ); ?> — <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a>.</p>
		</div>

		<div>
			<h2>Données collectées</h2>
			<p class="tfp-legal-p">Le site comporte deux formulaires, qui ne collectent pas les mêmes données. Aucune donnée sensible n'est demandée.</p>

			<h3 class="tfp-legal-h3">Demande de devis</h3>
			<ul style="margin-top:10px;padding-left:20px;color:var(--color-text-secondary);line-height:1.8">
				<li>Votre nom, et <strong>au moins un moyen de vous recontacter</strong> : téléphone ou adresse e-mail, au choix (les deux peuvent être fournis)</li>
				<li>Le nom de votre structure (facultatif)</li>
				<li>La description du besoin : type de locaux, régime régulier ou ponctuel, ville ou code postal, surface, fréquence et créneau souhaités (facultatifs sauf type de locaux et régime), et votre message</li>
				<li>Le contexte technique de la demande : page depuis laquelle vous avez accédé au formulaire, site référent, prestation et ville préremplies, paramètres de campagne (UTM) le cas échéant</li>
			</ul>

			<h3 class="tfp-legal-h3">Formulaire de contact</h3>
			<ul style="margin-top:10px;padding-left:20px;color:var(--color-text-secondary);line-height:1.8">
				<li>Votre nom, votre adresse e-mail et l'objet de votre message (obligatoires)</li>
				<li>Le nom de votre structure et votre téléphone (facultatifs)</li>
				<li>Votre message</li>
			</ul>

			<p class="tfp-legal-p">Pour les deux formulaires, votre adresse IP est utilisée de façon temporaire pour limiter le nombre de soumissions (lutte contre les envois automatisés).</p>
		</div>

		<div>
			<h2>Finalité et base légale</h2>
			<p class="tfp-legal-p">Les données de la demande de devis servent à étudier votre besoin et à vous adresser un devis : base légale, les mesures précontractuelles prises à votre demande. Les données du formulaire de contact servent à répondre à votre question : base légale, votre consentement, recueilli par la case à cocher du formulaire. Elles ne sont ni revendues, ni utilisées à des fins publicitaires.</p>

			<h2>Destinataire</h2>
			<p class="tfp-legal-p">Les demandes envoyées depuis ces deux formulaires sont transmises par e-mail à <?php echo esc_html( $site['manager'] ); ?>, qui les traite personnellement. Elles ne sont ni vendues, ni cédées.</p>
		</div>

		<div>
			<h2>Durée de conservation</h2>
			<p class="tfp-legal-p">Les durées varient selon la nature de la donnée : une demande restée sans suite n'est pas conservée aussi longtemps qu'un dossier client, et les pièces comptables obéissent à des obligations légales propres. Chaque donnée est supprimée dès qu'elle n'est plus nécessaire à la finalité pour laquelle elle a été collectée, ou à l'expiration du délai légal applicable.</p>
		</div>

		<div>
			<h2>Sous-traitants</h2>
			<p class="tfp-legal-p">Hébergement du site : Hostinger International Ltd. Aucun autre sous-traitant n'intervient à ce jour : aucun outil de mesure d'audience n'est installé sur ce site (voir notre page Gestion des cookies), et les demandes envoyées depuis les formulaires sont transmises par courrier électronique.</p>
		</div>

		<div>
			<h2>Vos droits</h2>
			<p class="tfp-legal-p">Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation, d'opposition et de portabilité. Pour l'exercer, écrivez à <a class="tfp-underline" href="mailto:<?php echo esc_attr( $site['email'] ); ?>"><?php echo esc_html( $site['email'] ); ?></a> ou appelez le <?php echo esc_html( $site['phone'] ); ?>. Vous pouvez également saisir la CNIL.</p>
			<p class="tfp-legal-p">Aucun délégué à la protection des données n'a été désigné : la demande se fait directement auprès de l'éditeur, à l'adresse indiquée ci-dessus.</p>
		</div>

		<div>
			<h2>Candidatures</h2>
			<p class="tfp-legal-p">Ce site ne collecte aucune candidature ni CV. Les candidatures se font sur notre site carrière externe, <a class="tfp-underline" href="<?php echo esc_url( tfp_url_carrieres() ); ?>">careers.werecruit.io</a>, édité par un prestataire distinct : les données que vous y saisissez sont traitées selon les conditions de ce prestataire, indiquées sur son site. La page <a class="tfp-underline" href="<?php echo esc_url( home_url( '/recrutement/' ) ); ?>">Recrutement</a> présente les postes et y renvoie.</p>
		</div>

	</div>
</section>

<?php get_footer(); ?>
