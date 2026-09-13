<?php
/**
 * Page d'accueil — preuve de bout en bout de la phase 1 (brief phase 1 §6).
 * Ordre des sections : hero, tarif et réassurance, prestations (fusionné avec
 * « Professionnels accompagnés »), problèmes résolus, fonctionnement, tarifs, couverture
 * régionale, Audrey et avis, conseils, CTA final.
 *
 * tfp_seo() est appelé AVANT get_header() : includes/seo.php lit ces valeurs pendant wp_head().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tfp_home_site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Nettoyage de bureaux et locaux en Bourgogne-Franche-Comté',
		'description' => "Entreprise de nettoyage de bureaux, commerces, cabinets et copropriétés en Bourgogne-Franche-Comté. Devis gratuit sous 24 h, {$tfp_home_site['price_unique_display']} HT/h, tarif unique.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		// Pas de fil d'Ariane sur l'accueil (includes/breadcrumbs.php) : c'est la racine du site,
		// donc pas de BreadcrumbList JSON-LD non plus ici.
	)
);

get_header();

// Ordre repris de la maquette Claude Design, vérifié par comparaison des rendus réels
// (docs/AUDIT-PRODUCTION.md §3c) : hero → bandeau tarifaire + réassurance → audiences →
// prestations → difficultés → pourquoi + témoignage → fonctionnement → tarif → couverture →
// Audrey → conseils → CTA final.
get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/pricing-reassurance' );
get_template_part( 'template-parts/home/audiences' );
get_template_part( 'template-parts/home/services' );
get_template_part( 'template-parts/home/problems' );
get_template_part( 'template-parts/home/why' );
get_template_part( 'template-parts/home/process' );
get_template_part( 'template-parts/home/pricing' );
get_template_part( 'template-parts/home/coverage' );
get_template_part( 'template-parts/home/audrey-reviews' );
get_template_part( 'template-parts/home/advice' );
get_template_part( 'template-parts/home/cta-final' );

get_footer();
