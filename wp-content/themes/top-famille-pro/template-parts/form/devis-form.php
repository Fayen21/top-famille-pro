<?php
/**
 * Formulaire de devis accessible. Fonctionne sans JavaScript : la
 * validation se fait côté serveur (voir inc/form-handler.php) et la page
 * se réaffiche avec les erreurs si besoin, ou redirige vers un état de
 * confirmation en cas de succès (Post/Redirect/Get).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $tfp_devis_errors, $tfp_devis_valeurs;
$erreurs = is_array( $tfp_devis_errors ?? null ) ? $tfp_devis_errors : array();
$valeurs = is_array( $tfp_devis_valeurs ?? null ) ? $tfp_devis_valeurs : array();
$envoye  = isset( $_GET['devis'] ) && 'ok' === $_GET['devis'];

$val = static fn( $cle ) => esc_attr( $valeurs[ $cle ] ?? '' );
$coche_case = static function ( $groupe, $valeur ) use ( $valeurs ) {
	$choix = (array) ( $valeurs[ $groupe ] ?? array() );
	return in_array( $valeur, $choix, true ) ? ' checked' : '';
};
$erreur_champ = static fn( $cle ) => $erreurs[ $cle ] ?? '';
?>

<div id="confirmation-devis">
<?php if ( $envoye ) : ?>
	<p class="tfp-confirmation" role="status">
		<?php
		printf(
			/* translators: %s: délai de réponse en heures */
			esc_html__( 'Merci, votre demande a bien été envoyée. Nous vous recontactons sous %s h.', 'top-famille-pro' ),
			esc_html( tfp_get_donnee( 'delai_devis_heures' ) )
		);
		?>
	</p>
<?php else : ?>

	<?php if ( ! empty( $erreurs ) ) : ?>
		<div class="tfp-erreurs-resume" role="alert" tabindex="-1">
			<p><?php esc_html_e( 'Le formulaire contient des erreurs :', 'top-famille-pro' ); ?></p>
			<ul>
				<?php foreach ( $erreurs as $cle => $texte ) : ?>
					<?php if ( '_global' === $cle ) : ?>
						<li><?php echo esc_html( $texte ); ?></li>
					<?php else : ?>
						<li><a href="#<?php echo esc_attr( $cle ); ?>"><?php echo esc_html( $texte ); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form class="tfp-form" method="post" action="<?php echo esc_url( tfp_devis_page_url() ); ?>#confirmation-devis" novalidate>
		<div class="tfp-champ">
			<label for="tfp_nom"><?php esc_html_e( 'Nom complet', 'top-famille-pro' ); ?> <span aria-hidden="true">*</span></label>
			<input
				type="text" id="tfp_nom" name="tfp_nom" autocomplete="name" required
				value="<?php echo $val( 'tfp_nom' ); ?>"
				<?php if ( $erreur_champ( 'tfp_nom' ) ) : ?>aria-invalid="true" aria-describedby="tfp_nom-erreur"<?php endif; ?>
			>
			<?php if ( $erreur_champ( 'tfp_nom' ) ) : ?><p class="tfp-erreur" id="tfp_nom-erreur"><?php echo esc_html( $erreur_champ( 'tfp_nom' ) ); ?></p><?php endif; ?>
		</div>

		<div class="tfp-champ">
			<label for="tfp_email"><?php esc_html_e( 'E-mail', 'top-famille-pro' ); ?> <span aria-hidden="true">*</span></label>
			<input
				type="email" id="tfp_email" name="tfp_email" autocomplete="email" required
				value="<?php echo $val( 'tfp_email' ); ?>"
				<?php if ( $erreur_champ( 'tfp_email' ) ) : ?>aria-invalid="true" aria-describedby="tfp_email-erreur"<?php endif; ?>
			>
			<?php if ( $erreur_champ( 'tfp_email' ) ) : ?><p class="tfp-erreur" id="tfp_email-erreur"><?php echo esc_html( $erreur_champ( 'tfp_email' ) ); ?></p><?php endif; ?>
		</div>

		<div class="tfp-champ">
			<label for="tfp_telephone"><?php esc_html_e( 'Téléphone', 'top-famille-pro' ); ?> <span aria-hidden="true">*</span></label>
			<input
				type="tel" id="tfp_telephone" name="tfp_telephone" autocomplete="tel" required
				value="<?php echo $val( 'tfp_telephone' ); ?>"
				<?php if ( $erreur_champ( 'tfp_telephone' ) ) : ?>aria-invalid="true" aria-describedby="tfp_telephone-erreur"<?php endif; ?>
			>
			<?php if ( $erreur_champ( 'tfp_telephone' ) ) : ?><p class="tfp-erreur" id="tfp_telephone-erreur"><?php echo esc_html( $erreur_champ( 'tfp_telephone' ) ); ?></p><?php endif; ?>
		</div>

		<div class="tfp-champ">
			<label for="tfp_entreprise"><?php esc_html_e( 'Entreprise / structure (facultatif)', 'top-famille-pro' ); ?></label>
			<input type="text" id="tfp_entreprise" name="tfp_entreprise" autocomplete="organization" value="<?php echo $val( 'tfp_entreprise' ); ?>">
		</div>

		<div class="tfp-champ">
			<label for="tfp_ville"><?php esc_html_e( 'Ville', 'top-famille-pro' ); ?></label>
			<input type="text" id="tfp_ville" name="tfp_ville" autocomplete="address-level2" value="<?php echo $val( 'tfp_ville' ); ?>">
		</div>

		<fieldset class="tfp-champ" <?php if ( $erreur_champ( 'tfp_locaux' ) ) : ?>aria-describedby="tfp_locaux-erreur"<?php endif; ?>>
			<legend><?php esc_html_e( 'Type de locaux', 'top-famille-pro' ); ?> <span aria-hidden="true">*</span></legend>
			<?php if ( $erreur_champ( 'tfp_locaux' ) ) : ?><p class="tfp-erreur" id="tfp_locaux-erreur"><?php echo esc_html( $erreur_champ( 'tfp_locaux' ) ); ?></p><?php endif; ?>
			<?php foreach ( tfp_devis_options_locaux() as $cle => $label ) : ?>
				<div class="tfp-case">
					<input type="checkbox" id="tfp_locaux_<?php echo esc_attr( $cle ); ?>" name="tfp_locaux[]" value="<?php echo esc_attr( $cle ); ?>"<?php echo $coche_case( 'tfp_locaux', $cle ); ?>>
					<label for="tfp_locaux_<?php echo esc_attr( $cle ); ?>"><?php echo esc_html( $label ); ?></label>
				</div>
			<?php endforeach; ?>
		</fieldset>

		<fieldset class="tfp-champ" <?php if ( $erreur_champ( 'tfp_frequence' ) ) : ?>aria-describedby="tfp_frequence-erreur"<?php endif; ?>>
			<legend><?php esc_html_e( 'Intervention régulière ou ponctuelle', 'top-famille-pro' ); ?> <span aria-hidden="true">*</span></legend>
			<?php if ( $erreur_champ( 'tfp_frequence' ) ) : ?><p class="tfp-erreur" id="tfp_frequence-erreur"><?php echo esc_html( $erreur_champ( 'tfp_frequence' ) ); ?></p><?php endif; ?>
			<div class="tfp-case">
				<input type="radio" id="tfp_frequence_regulier" name="tfp_frequence" value="regulier"<?php checked( $valeurs['tfp_frequence'] ?? '', 'regulier' ); ?>>
				<label for="tfp_frequence_regulier"><?php esc_html_e( 'Régulier', 'top-famille-pro' ); ?></label>
			</div>
			<div class="tfp-case">
				<input type="radio" id="tfp_frequence_ponctuel" name="tfp_frequence" value="ponctuel"<?php checked( $valeurs['tfp_frequence'] ?? '', 'ponctuel' ); ?>>
				<label for="tfp_frequence_ponctuel"><?php esc_html_e( 'Ponctuel', 'top-famille-pro' ); ?></label>
			</div>
		</fieldset>

		<fieldset class="tfp-champ">
			<legend><?php esc_html_e( 'Tâches souhaitées (facultatif)', 'top-famille-pro' ); ?></legend>
			<?php foreach ( tfp_devis_options_taches() as $cle => $label ) : ?>
				<div class="tfp-case">
					<input type="checkbox" id="tfp_taches_<?php echo esc_attr( $cle ); ?>" name="tfp_taches[]" value="<?php echo esc_attr( $cle ); ?>"<?php echo $coche_case( 'tfp_taches', $cle ); ?>>
					<label for="tfp_taches_<?php echo esc_attr( $cle ); ?>"><?php echo esc_html( $label ); ?></label>
				</div>
			<?php endforeach; ?>
		</fieldset>

		<div class="tfp-champ">
			<label for="tfp_message"><?php esc_html_e( 'Précisions (facultatif)', 'top-famille-pro' ); ?></label>
			<textarea id="tfp_message" name="tfp_message" rows="4"><?php echo esc_textarea( $valeurs['tfp_message'] ?? '' ); ?></textarea>
		</div>

		<fieldset class="tfp-champ" <?php if ( $erreur_champ( 'tfp_consentement' ) ) : ?>aria-describedby="tfp_consentement-erreur"<?php endif; ?>>
			<legend><?php esc_html_e( 'Confidentialité', 'top-famille-pro' ); ?></legend>
			<?php if ( $erreur_champ( 'tfp_consentement' ) ) : ?><p class="tfp-erreur" id="tfp_consentement-erreur"><?php echo esc_html( $erreur_champ( 'tfp_consentement' ) ); ?></p><?php endif; ?>
			<div class="tfp-case">
				<input type="checkbox" id="tfp_consentement" name="tfp_consentement" value="1" required<?php checked( ! empty( $valeurs['tfp_consentement'] ) ); ?>>
				<label for="tfp_consentement">
					<?php
					$url_confidentialite = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
					if ( $url_confidentialite ) {
						printf(
							/* translators: %s: URL politique de confidentialité */
							wp_kses( __( 'J\'accepte que mes données soient utilisées pour être recontacté(e) au sujet de ma demande, conformément à la <a href="%s">politique de confidentialité</a>.', 'top-famille-pro' ), array( 'a' => array( 'href' => array() ) ) ),
							esc_url( $url_confidentialite )
						);
					} else {
						esc_html_e( 'J\'accepte que mes données soient utilisées pour être recontacté(e) au sujet de ma demande.', 'top-famille-pro' );
					}
					?>
					<span aria-hidden="true">*</span>
				</label>
			</div>
		</fieldset>

		<div class="tfp-champ-piege" aria-hidden="true">
			<label for="tfp_champ_verification"><?php esc_html_e( 'Laissez ce champ vide', 'top-famille-pro' ); ?></label>
			<input type="text" id="tfp_champ_verification" name="tfp_champ_verification" tabindex="-1" autocomplete="off">
		</div>

		<?php wp_nonce_field( 'tfp_devis_form', 'tfp_devis_nonce' ); ?>
		<input type="hidden" name="tfp_form_horodatage" value="<?php echo esc_attr( time() ); ?>">
		<input type="hidden" name="tfp_devis_submit" value="1">

		<p class="tfp-mention-champs-requis"><?php esc_html_e( 'Les champs marqués * sont obligatoires.', 'top-famille-pro' ); ?></p>

		<button type="submit" class="tfp-btn tfp-btn--primaire"><?php esc_html_e( 'Envoyer ma demande de devis', 'top-famille-pro' ); ?></button>
	</form>

<?php endif; ?>
</div>
