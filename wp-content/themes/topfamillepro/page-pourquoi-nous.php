<?php
/**
 * Page statique « Pourquoi nous » (/pourquoi-nous/) — gabarit dédié (CLAUDE.md §3).
 *
 * Contenu construit à partir des arguments réels de PROJECT_INPUTS.md §8 (gestion administrative,
 * assurance professionnelle, gestion des clés, remplacement, contrôle qualité, cahier de liaison,
 * tarif sans frais cachés, recrutement rigoureux) — pas de reprise du prototype, qui mêlait ces
 * arguments réels à des avis et à une note fictifs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$arguments = array(
	array( 'titre' => 'Une interlocutrice unique', 'texte' => "Du premier échange au suivi mensuel, vous parlez toujours à {$site['manager']}. Pas de centre d'appels, pas de changement d'interlocuteur au fil des mois." ),
	array( 'titre' => 'Un intervenant habituel recherché', 'texte' => "Nous cherchons à confier votre site au même intervenant d'une semaine sur l'autre. En cas d'absence ou de départ, une solution de remplacement est recherchée activement, sans garantie de continuité automatique que personne ne peut promettre." ),
	array( 'titre' => 'Un cahier des charges écrit, pas une promesse orale', 'texte' => 'Espaces, tâches, fréquence, horaires et points de vigilance sont formalisés avant la première intervention et servent de référence tout au long de la prestation.' ),
	array( 'titre' => 'Un cahier de liaison sur chaque site', 'texte' => 'Chaque passage est tracé : ce qui a été fait, ce qui a été signalé, ce qui reste à traiter. Vous n\'avez pas besoin d\'être présent pour savoir ce qui s\'est passé.' ),
	array( 'titre' => 'Gestion administrative prise en charge', 'texte' => 'Facturation, arrêts de travail, remplacement de personnel, litiges : cette gestion reste de notre côté, pas du vôtre.' ),
	array( 'titre' => 'Recrutement rigoureux', 'texte' => 'Vérification du CV et du casier judiciaire, puis validation par le client lors d\'une prestation d\'essai avant tout engagement durable.' ),
	array( 'titre' => 'Gestion sécurisée des clés et des accès', 'texte' => 'Les modalités d\'accès sont formalisées par écrit et transmises uniquement aux intervenants concernés par votre site.' ),
	array( 'titre' => 'Un tarif indiqué avant le devis, sans frais cachés', 'texte' => 'Grille tarifaire identique dans toute la région, indemnités kilométriques et frais de mise en place toujours précisés au devis, jamais découverts après coup.' ),
);

tfp_seo(
	array(
		'title'       => 'Pourquoi choisir Top-Famille Pro | Nettoyage professionnel',
		'description' => 'Interlocutrice unique, intervenant habituel recherché, cahier de liaison et périmètre écrit : ce qui distingue notre organisation.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Pourquoi nous', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Pourquoi choisir Top-Famille Pro</h1>
	<p style="max-width:680px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Une entreprise régionale basée à Saint-Apollinaire, organisée pour que l'entretien de vos locaux ne repose pas sur votre vigilance.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-grid tfp-grid--autofit-md">
		<?php foreach ( $arguments as $arg ) : ?>
			<div class="tfp-card">
				<h2 style="font-size:19px;margin-bottom:8px"><?php echo esc_html( $arg['titre'] ); ?></h2>
				<p style="color:var(--color-text-secondary)"><?php echo esc_html( $arg['texte'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Fonctionnement en 4 temps</h2>
		<ol style="margin-top:16px;display:flex;flex-direction:column;gap:12px;padding-left:20px">
			<li>Échange sur vos attentes</li>
			<li>Devis personnalisé selon le besoin et le budget</li>
			<li>Sélection de l'intervenant, validée par vous</li>
			<li>Démarrage et suivi continu</li>
		</ol>
		<p style="margin-top:16px"><a href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>" class="tfp-eyebrow-link">Le détail de notre fonctionnement →</a></p>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Échanger sur vos locaux</h2>
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
