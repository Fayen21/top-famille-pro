<?php
/**
 * Page statique « Recrutement » (/recrutement/) — gabarit dédié (CLAUDE.md §3).
 *
 * CLAUDE.md §8 est explicite : cette page renvoie vers le site carrière existant
 * (careers.werecruit.io/fr/top-famille, PROJECT_INPUTS.md §1), sans dupliquer de formulaire de
 * candidature ni collecter de CV sur ce site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$careers_url = 'https://careers.werecruit.io/fr/top-famille';

tfp_seo(
	array(
		'title'       => "Recrutement — agents d'entretien | " . $site['brand_name'],
		'description' => "Nous recrutons des agents d'entretien en {$site['address_region']}. Postes, conditions et candidature sur notre site carrière.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Recrutement', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Recrutement — agents d'entretien</h1>
	<p style="max-width:640px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Nous recrutons des agents d'entretien en <?php echo esc_html( $site['address_region'] ); ?>, avec vérification des références et une prestation d'essai avant tout engagement durable.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:640px">
		<div class="tfp-card">
			<h2 style="font-size:19px;margin-bottom:10px">Postuler</h2>
			<p style="color:var(--color-text-secondary)">Les offres d'emploi et les candidatures sont gérées sur notre site carrière, partagé avec Top-Famille. C'est là que vous trouverez les postes ouverts et le formulaire de candidature.</p>
			<p style="margin-top:16px">
				<a href="<?php echo esc_url( $careers_url ); ?>" class="tfp-btn tfp-btn--primary" rel="noopener" target="_blank">Voir les offres et postuler →</a>
			</p>
		</div>
	</div>
</section>

<?php get_footer(); ?>
