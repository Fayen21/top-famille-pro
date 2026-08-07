<?php
/**
 * Page statique « Notre fonctionnement » (/notre-fonctionnement/) — gabarit dédié (CLAUDE.md §3).
 *
 * Développe les 4 temps réels de PROJECT_INPUTS.md §8, sans invention de délai ou de fréquence
 * opérationnelle non confirmée (CLAUDE.md §5.1).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

$etapes = array(
	array(
		'titre' => 'Échange sur vos attentes',
		'texte' => "Vous décrivez vos locaux, votre activité et vos contraintes d'horaires — par téléphone, par le formulaire de devis, ou lors d'une visite lorsque la configuration le justifie. Nous ne proposons pas de simulateur automatique : chaque demande est étudiée personnellement par {$site['manager']}.",
	),
	array(
		'titre' => 'Devis personnalisé selon le besoin et le budget',
		'texte' => 'Le devis détaille le volume d\'heures estimé, le tarif applicable, les frais éventuels (gestion, mise en place, indemnités kilométriques) et les conditions d\'arrêt de la prestation. Il est gratuit, transmis sous 24 heures, et sans engagement de votre part.',
	),
	array(
		'titre' => 'Sélection de l\'intervenant, validée par vous',
		'texte' => 'Les intervenants sont recrutés avec vérification du CV et du casier judiciaire, puis validés par vous lors d\'une prestation d\'essai avant tout engagement durable. Nous cherchons ensuite à confier votre site au même intervenant, semaine après semaine.',
	),
	array(
		'titre' => 'Démarrage et suivi continu',
		'texte' => 'Un cahier de liaison reste sur place pour tracer chaque passage. En cas d\'absence de l\'intervenant habituel, une solution de remplacement est recherchée activement et vous êtes informé de l\'organisation retenue, sans garantie de continuité automatique.',
	),
);

$faqs = array(
	array( 'q' => 'Le devis est-il payant ou engageant ?', 'a' => 'Non. Le devis est gratuit, transmis sous 24 heures, et sans engagement de votre part.' ),
	array( 'q' => 'Comment est rédigé le cahier des charges ?', 'a' => 'Il est établi avec vous avant la première intervention : espaces concernés, tâches attendues, fréquence, horaires et points de vigilance propres à vos locaux. Il peut être ajusté à tout moment.' ),
	array( 'q' => 'Que se passe-t-il si l\'intervenant est absent ?', 'a' => 'Nous recherchons activement une solution de remplacement pour maintenir la continuité et vous tenons informé de l\'organisation retenue, sans pouvoir garantir un remplacement immédiat dans tous les cas.' ),
	array( 'q' => 'Comment modifier la prestation en cours de contrat ?', 'a' => "Par un simple échange avec {$site['manager']}. Un ajustement de périmètre à volume d'heures constant se met en place rapidement ; un changement de volume horaire donne lieu à un devis actualisé, soumis à votre accord avant application." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/notre-fonctionnement/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array( '@type' => 'Question', 'name' => $item['q'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ) );
			},
			$faqs
		),
	);
}

tfp_seo(
	array(
		'title'       => 'Notre fonctionnement, du devis au suivi | ' . $site['brand_name'],
		'description' => 'Premier échange, devis, sélection de l\'intervenant et suivi : les étapes d\'une prestation d\'entretien chez Top-Famille Pro.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Notre fonctionnement', 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Notre fonctionnement, du devis au suivi</h1>
	<p style="max-width:680px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Quatre étapes, toujours les mêmes, pour que l'entretien de vos locaux reste prévisible.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<?php foreach ( $etapes as $i => $etape ) : ?>
			<div class="tfp-card" style="margin-bottom:16px;display:flex;gap:20px;align-items:flex-start">
				<span aria-hidden="true" style="flex-shrink:0;width:40px;height:40px;border-radius:50%;background:var(--color-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700"><?php echo (int) ( $i + 1 ); ?></span>
				<div>
					<h2 style="font-size:19px;margin-bottom:8px"><?php echo esc_html( $etape['titre'] ); ?></h2>
					<p style="color:var(--color-text-secondary)"><?php echo esc_html( $etape['texte'] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Questions fréquentes</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faqs as $item ) : ?>
				<details class="tfp-card" style="margin-bottom:10px">
					<summary style="font-weight:600;cursor:pointer"><?php echo esc_html( $item['q'] ); ?></summary>
					<p style="margin-top:10px;color:var(--color-text-secondary)"><?php echo esc_html( $item['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un devis étudié personnellement par <?php echo esc_html( $site['manager'] ); ?></h2>
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
