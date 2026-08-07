<?php
/**
 * Page statique « Demande de devis » (/demande-de-devis/) — gabarit dédié (CLAUDE.md §3).
 *
 * Formulaire réel à deux étapes (CLAUDE.md §8) : un seul <form>, deux <fieldset> — les données
 * restent dans le DOM en permanence entre les étapes (src/js/quote-form.js gère uniquement
 * l'affichage), donc rien n'est perdu si le visiteur revient en arrière. Sans JavaScript, les deux
 * étapes restent visibles et le formulaire reste soumissible en une fois.
 *
 * Traitement serveur réel (includes/quote-form.php, wp_mail() vers l'adresse réelle
 * PROJECT_INPUTS.md §1) : validation, honeypot, limitation des soumissions. La confirmation ne
 * s'affiche qu'après un vrai succès serveur (redirection avec ?merci=1), jamais côté client seul.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site    = tfp_site_data();
$success = isset( $_GET['merci'] );
$erreur  = isset( $_GET['erreur'] ) ? sanitize_key( wp_unslash( $_GET['erreur'] ) ) : '';

$erreur_messages = array(
	'champs'  => 'Merci de renseigner votre nom, une adresse e-mail valide et un message décrivant votre besoin.',
	'session' => 'Votre session a expiré, merci de renvoyer le formulaire.',
	'limite'  => 'Trop de demandes envoyées récemment depuis cette connexion. Merci de réessayer un peu plus tard, ou d\'appeler directement Audrey.',
	'envoi'   => 'L\'envoi a échoué côté serveur. Merci de réessayer, ou d\'appeler directement Audrey au ' . $site['phone'] . '.',
);

tfp_seo(
	array(
		'title'       => 'Demande de devis gratuit | ' . $site['brand_name'],
		'description' => 'Décrivez vos locaux en deux étapes : Audrey vous répond sous 24 heures avec une proposition claire et sans engagement.',
		'type'        => 'website',
		'robots'      => $success ? 'noindex,follow' : 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Demande de devis', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<h1>Demande de devis gratuit</h1>
	<p style="max-width:640px;font-size:18px;color:var(--color-text-secondary);margin-top:12px">Décrivez vos locaux en deux étapes. Votre devis est étudié personnellement par <?php echo esc_html( $site['manager'] ); ?> et transmis sous 24 heures, gratuitement et sans engagement.</p>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:640px">

		<?php if ( $success ) : ?>
			<div class="tfp-form-notice" role="status">
				<h2>Votre demande a bien été envoyée</h2>
				<p style="margin-top:8px">Merci ! <?php echo esc_html( $site['manager'] ); ?> vous répond sous 24 heures. Pour toute urgence, vous pouvez aussi appeler directement le <a href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>"><?php echo esc_html( $site['phone'] ); ?></a>.</p>
			</div>
		<?php else : ?>

			<?php if ( $erreur && isset( $erreur_messages[ $erreur ] ) ) : ?>
				<div class="tfp-form-notice tfp-form-notice--error" role="alert">
					<p><?php echo esc_html( $erreur_messages[ $erreur ] ); ?></p>
				</div>
			<?php endif; ?>

			<form class="tfp-quote-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
				<div class="tfp-form-errors" role="alert" aria-live="polite" data-form-errors></div>

				<input type="hidden" name="action" value="tfp_submit_devis">
				<?php wp_nonce_field( 'tfp_quote_submit', 'tfp_quote_nonce' ); ?>

				<div class="tfp-field-honeypot" aria-hidden="true">
					<label for="tfp-site-web">Laisser vide</label>
					<input type="text" id="tfp-site-web" name="tfp_site_web" tabindex="-1" autocomplete="off">
				</div>

				<input type="hidden" name="ville" value="">
				<input type="hidden" name="departement" value="">
				<?php $raw_referer = wp_get_raw_referer(); ?>
				<input type="hidden" name="page_origine" value="<?php echo $raw_referer ? esc_url( $raw_referer ) : ''; ?>">
				<input type="hidden" name="referent" value="<?php echo $raw_referer ? esc_attr( wp_parse_url( $raw_referer, PHP_URL_HOST ) ) : ''; ?>">
				<input type="hidden" name="utm_source" value="<?php echo isset( $_GET['utm_source'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_source'] ) ) ) : ''; ?>">
				<input type="hidden" name="utm_medium" value="<?php echo isset( $_GET['utm_medium'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) ) : ''; ?>">
				<input type="hidden" name="utm_campaign" value="<?php echo isset( $_GET['utm_campaign'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ) ) : ''; ?>">

				<fieldset data-step="0" style="border:none;padding:0;margin:0">
					<legend style="font-weight:700;font-size:20px;margin-bottom:16px">Étape 1 sur 2 — Vos coordonnées</legend>

					<div class="tfp-field">
						<label for="tfp-nom">Nom et prénom *</label>
						<input type="text" id="tfp-nom" name="nom" autocomplete="name" required>
					</div>

					<div class="tfp-field">
						<label for="tfp-email">E-mail *</label>
						<input type="email" id="tfp-email" name="email" autocomplete="email" required>
					</div>

					<div class="tfp-field">
						<label for="tfp-telephone">Téléphone</label>
						<input type="tel" id="tfp-telephone" name="telephone" autocomplete="tel">
						<span class="tfp-field__hint">Facultatif — utile si <?php echo esc_html( $site['manager'] ); ?> a besoin de vous rappeler rapidement.</span>
					</div>

					<div class="tfp-field">
						<label for="tfp-structure">Structure</label>
						<input type="text" id="tfp-structure" name="structure" autocomplete="organization">
					</div>

					<div class="tfp-form-actions">
						<button type="button" class="tfp-btn tfp-btn--primary" data-step-next>Continuer →</button>
					</div>
				</fieldset>

				<fieldset data-step="1" hidden style="border:none;padding:0;margin:0">
					<legend style="font-weight:700;font-size:20px;margin-bottom:16px">Étape 2 sur 2 — Votre besoin</legend>

					<div class="tfp-field">
						<label for="tfp-prestation-visible">Prestation concernée</label>
						<input type="text" id="tfp-prestation-visible" name="prestation" placeholder="Ex. bureaux, commerces, copropriété…">
					</div>

					<div class="tfp-field">
						<label for="tfp-message">Décrivez vos locaux et votre besoin *</label>
						<textarea id="tfp-message" name="message" required placeholder="Type de locaux, surface approximative, fréquence souhaitée, ville…"></textarea>
					</div>

					<div class="tfp-form-actions">
						<button type="button" class="tfp-btn tfp-btn--secondary" data-step-prev>← Retour</button>
						<button type="submit" class="tfp-btn tfp-btn--primary" data-step-submit>Envoyer ma demande</button>
					</div>
				</fieldset>

				<p style="margin-top:16px;font-size:13px;color:var(--color-text-tertiary)">Gratuit · Sans engagement · Réponse sous 24 h</p>
			</form>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
