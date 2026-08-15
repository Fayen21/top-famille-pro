<?php
/**
 * Page statique « Gestion des cookies » (/gestion-des-cookies/) — gabarit dédié (CLAUDE.md §3).
 *
 * Contenu vérifié plutôt que générique : recherche dans tout le thème (aucune occurrence de
 * setcookie/gtag/analytics/dataLayer) confirmant qu'aucun outil de mesure d'audience ni de
 * traçage publicitaire n'est installé — conforme à l'interdit opérationnel CLAUDE.md §6
 * (« aucun outil de tracking installé tant que son identifiant et les règles de consentement ne
 * sont pas fournis »). Cette page devra être mise à jour, avec un vrai bandeau de consentement, le
 * jour où un tel outil sera ajouté.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Gestion des cookies | ' . $site['brand_name'],
		'description' => 'Ce site n\'utilise actuellement aucun cookie de mesure d\'audience ni de traçage publicitaire.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Gestion des cookies', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Gestion des cookies</h1>
	<p class="tfp-section__lede">Ce que le site dépose sur votre navigateur, et comment le refuser.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-legal-body" style="display:flex;flex-direction:column;gap:24px">
		<div class="tfp-card">
			<h2 style="font-size:19px">Aucun cookie de mesure d'audience ni de traçage publicitaire</h2>
			<p class="tfp-legal-p">À ce jour, ce site n'installe aucun outil de mesure d'audience (type Google Analytics) ni aucun outil de traçage publicitaire. Aucun bandeau de consentement n'est donc nécessaire pour l'instant : il n'y a rien à consentir.</p>
		</div>

		<div>
			<h2>Cookies strictement nécessaires</h2>
			<p class="tfp-legal-p">Ils assurent le fonctionnement du site : sécurité, session, envoi des formulaires. Ils ne nécessitent pas votre consentement et ne servent à aucun suivi publicitaire.</p>

			<h2>Cookies techniques</h2>
			<p class="tfp-legal-p">WordPress, le système qui fait fonctionner ce site, peut déposer des cookies strictement techniques dans certains cas (par exemple lors de l'utilisation d'un formulaire, pour la sécurité des échanges). Ces cookies sont indispensables au fonctionnement du site et ne nécessitent pas de consentement, conformément à la réglementation.</p>
		</div>

		<div>
			<h2>Mesure d'audience</h2>
			<p class="tfp-legal-p">Si une mesure d'audience est mise en place, elle sera configurée pour être exemptée de consentement lorsque c'est possible, ou soumise à votre accord préalable dans le cas contraire. Outil retenu : à confirmer. Aucun outil de ce type n'est installé à ce jour.</p>

			<h2>Refuser ou supprimer les cookies</h2>
			<p class="tfp-legal-p">Vous pouvez configurer votre navigateur pour refuser ou supprimer les cookies à tout moment. Le refus des cookies non essentiels n'empêche ni la consultation du site, ni l'envoi d'une demande de devis.</p>

			<h2>Si cela évolue</h2>
			<p class="tfp-legal-p">Si un outil de mesure d'audience ou de suivi publicitaire est installé à l'avenir, cette page sera mise à jour avec le détail des cookies utilisés, leur finalité, leur durée de conservation, et un bandeau de consentement sera mis en place avant tout dépôt de cookie non essentiel.</p>
		</div>
	</div>
</section>

<?php get_footer(); ?>
