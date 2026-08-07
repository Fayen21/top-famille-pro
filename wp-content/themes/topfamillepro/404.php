<?php
/**
 * Page 404 — renvoie un vrai statut HTTP 404 (brief phase 1 §2/§8), contrairement au
 * prototype où « isNotFound » n'était qu'un indicateur côté client sans réponse serveur.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

status_header( 404 );
nocache_headers();

tfp_seo(
	array(
		'title'       => 'Page introuvable | Top-Famille Pro',
		'description' => "Cette page n'existe pas ou plus. Retrouvez nos prestations, nos tarifs et nos zones d'intervention en Bourgogne-Franche-Comté.",
		'robots'      => 'noindex,follow',
	)
);

get_header();
?>
<section class="tfp-container tfp-section" style="text-align:center;max-width:640px">
	<div style="font-family:var(--font-heading);font-weight:800;font-size:clamp(48px,8vw,88px);color:var(--color-primary);line-height:1">404</div>
	<h1 style="margin-top:12px">Page introuvable</h1>
	<p style="margin-top:14px;font-size:17px;color:var(--color-text-secondary)">
		Cette page n'existe pas, plus, ou l'adresse comporte une erreur. Vous pouvez repartir de l'accueil ou de l'une de ces pages :
	</p>
	<div class="tfp-flex" style="justify-content:center;margin-top:28px">
		<?php
		tfp_button(
			array(
				'label'   => "Retour à l'accueil",
				'href'    => home_url( '/' ),
				'variant' => 'primary',
			)
		);
		tfp_button(
			array(
				'label'   => 'Nos prestations',
				'href'    => home_url( '/prestations/' ),
				'variant' => 'secondary',
			)
		);
		tfp_button(
			array(
				'label'   => 'Demander un devis',
				'href'    => home_url( '/demande-de-devis/' ),
				'variant' => 'secondary',
			)
		);
		?>
	</div>
</section>
<?php
get_footer();
