<?php
/**
 * Page statique « Avis clients » (/avis-clients/) — gabarit dédié (CLAUDE.md §3).
 *
 * Utilise le même mécanisme que l'accueil (includes/reassurance-settings.php,
 * tfp_reassurance_data()) : aucun avis fictif, uniquement les avis réels saisis par Audrey/Emmanuel
 * dans Réglages → Réassurance & avis. PROJECT_INPUTS.md §7 confirme l'existence de 6 témoignages
 * authentiques sur l'ancien site (Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie),
 * réutilisables — mais leur texte exact n'a pas été fourni dans ce dépôt : tant qu'il ne l'est pas,
 * la page reste honnête plutôt que d'inventer un contenu plausible pour des personnes réelles
 * (CLAUDE.md §5.1/§5.5).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();

tfp_seo(
	array(
		'title'       => 'Avis clients | ' . $site['brand_name'],
		'description' => 'Retours de clients sur nos prestations d\'entretien de bureaux, commerces, cabinets et copropriétés en ' . $site['address_region'] . '.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Avis clients', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Avis clients</h1>
	<?php if ( $reassurance['note'] && $reassurance['nombre_avis'] ) : ?>
		<p style="margin-top:8px;font-size:18px;color:var(--color-text-secondary)"><strong><?php echo esc_html( number_format_i18n( $reassurance['note'], 1 ) ); ?>/5</strong> sur <?php echo (int) $reassurance['nombre_avis']; ?> avis<?php echo $reassurance['google_url'] ? ' Google' : ''; ?>.</p>
	<?php endif; ?>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<?php if ( ! empty( $reassurance['avis'] ) ) : ?>
			<div class="tfp-grid tfp-grid--autofit-md">
				<?php foreach ( $reassurance['avis'] as $avis ) : ?>
					<div class="tfp-card">
						<p>« <?php echo esc_html( $avis['texte'] ); ?> »</p>
						<p style="margin-top:12px;font-weight:600"><?php echo esc_html( $avis['nom'] ?? '' ); ?></p>
						<?php if ( ! empty( $avis['source'] ) ) : ?><p style="color:var(--color-text-tertiary);font-size:13px"><?php echo esc_html( $avis['source'] ); ?></p><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="tfp-card" style="max-width:640px">
				<p>Les avis clients réels de Top-Famille Pro sont en cours d'intégration sur ce site. Six témoignages authentiques existent déjà sur nos supports (signés Jean-Louis D., Anna P., Michel G., Laurent, Laura et Anne-Sophie) et seront publiés ici dès que leur contenu exact nous sera transmis.</p>
				<?php if ( $reassurance['google_url'] ) : ?>
					<p style="margin-top:12px"><a href="<?php echo esc_url( $reassurance['google_url'] ); ?>" class="tfp-link-arrow" rel="noopener" target="_blank">Voir nos avis sur Google →</a></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
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
