<?php
/**
 * Réglages « Réassurance & avis » — seule source des avis, de la note et du lien Google
 * affichés sur le site. Implémenté avec l'API Settings native de WordPress, SANS AUCUNE
 * dépendance à ACF (ni gratuit ni Pro) : cette donnée doit rester modifiable même si ACF
 * n'est pas installé.
 *
 * Historique : la version précédente utilisait acf_add_options_page() + un champ Repeater.
 * Les deux sont des fonctionnalités ACF PRO (confirmé sur advancedcustomfields.com/pro/ :
 * Repeater, Flexible Content, Gallery, Clone et les pages d'options sont les cinq
 * fonctionnalités exclusives à la version Pro) — incompatible avec « ACF gratuit suffit »
 * annoncé dans le README. Remplacé ici par l'API Settings, qui ne dépend de rien d'externe.
 *
 * Vide par défaut : tant qu'Audrey/Emmanuel n'ont pas fourni les vraies valeurs
 * (PROJECT_INPUTS.md, questions ouvertes #6/#7), tous les champs restent vides et les gabarits
 * doivent masquer proprement les blocs correspondants plutôt que d'inventer une valeur
 * (docs/DONNEES-FICTIVES.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const TFP_REASSURANCE_OPTION = 'tfp_reassurance';
const TFP_REASSURANCE_AVIS_MAX = 6; // Les six témoignages authentiques listés dans CLAUDE.md §5.5.

/**
 * Valeurs par défaut. Ne jamais mettre ici un avis ou une note de démonstration : seules des
 * valeurs explicitement confirmées par le client y ont leur place, pour qu'elles soient
 * versionnées et présentes sur toute installation sans ressaisie.
 *
 * `note` = 5.0 : note Google réelle, confirmée par Emmanuel le 9 août 2026 (CLAUDE.md §5.5).
 * `nombre_avis` et `google_url` restent vides — non communiqués à ce jour, jamais inventés. Le
 * badge s'affiche correctement sans eux (includes/testimonials.php) et les intègre dès qu'ils
 * sont saisis en administration.
 *
 * @return array
 */
function tfp_reassurance_defaults() {
	$avis = array();
	for ( $i = 0; $i < TFP_REASSURANCE_AVIS_MAX; $i++ ) {
		$avis[] = array(
			'nom'      => '',
			'texte'    => '',
			'note'     => '',
			'contexte' => '',
			'source'   => '',
		);
	}

	return array(
		'google_url'      => '',
		'note'            => '5.0',
		'nombre_avis'     => '',
		// Citation attribuée à Audrey sur l'accueil, reprise de la maquette Claude Design. Elle est
		// administrable ici plutôt qu'écrite dans un gabarit : c'est le seul contenu du site qui
		// fasse parler une personne réelle, et il doit pouvoir être corrigé ou retiré par
		// l'intéressée sans toucher au code. Vide = la citation n'est pas affichée.
		'citation_audrey' => "Mon rôle, c'est de rester joignable et de tenir mes engagements. Chaque client sait à qui parler, et sait ce qui a été fait dans ses locaux.",
		'avis'            => $avis,
	);
}

function tfp_register_reassurance_settings() {
	register_setting(
		'tfp_reassurance_group',
		TFP_REASSURANCE_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'tfp_sanitize_reassurance_settings',
			'default'           => tfp_reassurance_defaults(),
		)
	);
}
add_action( 'admin_init', 'tfp_register_reassurance_settings' );

/**
 * Sanitize et valide les valeurs soumises par le formulaire. Chaque champ est nettoyé avec la
 * fonction WordPress appropriée à son type (CLAUDE.md §2 : assainissement des entrées).
 *
 * @param array $input
 * @return array
 */
function tfp_sanitize_reassurance_settings( $input ) {
	$clean = tfp_reassurance_defaults();

	if ( ! is_array( $input ) ) {
		return $clean;
	}

	$clean['google_url'] = isset( $input['google_url'] ) ? esc_url_raw( trim( $input['google_url'] ) ) : '';
	$clean['citation_audrey'] = isset( $input['citation_audrey'] ) ? sanitize_textarea_field( trim( $input['citation_audrey'] ) ) : '';

	if ( isset( $input['note'] ) && '' !== trim( (string) $input['note'] ) ) {
		$note = (float) str_replace( ',', '.', $input['note'] );
		$clean['note'] = (string) max( 0, min( 5, $note ) );
	}

	if ( isset( $input['nombre_avis'] ) && '' !== trim( (string) $input['nombre_avis'] ) ) {
		$clean['nombre_avis'] = (string) max( 0, (int) $input['nombre_avis'] );
	}

	if ( ! empty( $input['avis'] ) && is_array( $input['avis'] ) ) {
		foreach ( $input['avis'] as $i => $avis ) {
			if ( $i >= TFP_REASSURANCE_AVIS_MAX ) {
				break;
			}
			$clean['avis'][ $i ] = array(
				'nom'      => sanitize_text_field( $avis['nom'] ?? '' ),
				'texte'    => sanitize_textarea_field( $avis['texte'] ?? '' ),
				'note'     => isset( $avis['note'] ) && '' !== trim( (string) $avis['note'] )
					? (string) max( 1, min( 5, (int) $avis['note'] ) )
					: '',
				'contexte' => sanitize_text_field( $avis['contexte'] ?? '' ),
				'source'   => sanitize_text_field( $avis['source'] ?? '' ),
			);
		}
	}

	return $clean;
}

function tfp_register_reassurance_menu() {
	add_menu_page(
		'Réassurance & avis',
		'Réassurance & avis',
		'manage_options',
		'tfp-reassurance',
		'tfp_render_reassurance_page',
		'dashicons-star-filled',
		60
	);
}
add_action( 'admin_menu', 'tfp_register_reassurance_menu' );

function tfp_render_reassurance_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$values = wp_parse_args( get_option( TFP_REASSURANCE_OPTION, array() ), tfp_reassurance_defaults() );
	?>
	<div class="wrap">
		<h1>Réassurance &amp; avis</h1>
		<p>
			Seule source des avis, de la note et du lien Google affichés sur le site public.
			Laisser un champ vide plutôt que d'y mettre une valeur approximative : le site masque
			proprement les blocs correspondants tant qu'ils sont vides (aucun avis, note ou
			compteur fictif n'est jamais affiché à la place).
		</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'tfp_reassurance_group' ); ?>

			<h2>Fiche Google</h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tfp-google-url">URL de la fiche Google Business</label></th>
					<td><input type="url" id="tfp-google-url" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[google_url]" value="<?php echo esc_attr( $values['google_url'] ); ?>" class="regular-text" placeholder="https://..."></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp-note">Note réelle (sur 5)</label></th>
					<td><input type="number" id="tfp-note" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[note]" value="<?php echo esc_attr( $values['note'] ); ?>" min="0" max="5" step="0.1" class="small-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="tfp-nombre-avis">Nombre d'avis réel</label></th>
					<td><input type="number" id="tfp-nombre-avis" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[nombre_avis]" value="<?php echo esc_attr( $values['nombre_avis'] ); ?>" min="0" class="small-text"></td>
				</tr>
			</table>

			<h2>Citation de la gérante</h2>
			<p>
				Phrase attribuée à <?php echo esc_html( tfp_site_data()['manager'] ); ?> sur la page
				d'accueil, reprise de la maquette Claude Design. C'est le <strong>seul contenu du site
				qui fasse parler une personne réelle</strong> : elle doit être validée par l'intéressée
				avant mise en ligne, et se corrige ou se retire ici, sans toucher au code. Vider le
				champ retire la citation de l'accueil.
			</p>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tfp-citation-audrey">Citation</label></th>
					<td>
						<textarea id="tfp-citation-audrey" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[citation_audrey]" rows="3" class="large-text"><?php echo esc_textarea( $values['citation_audrey'] ); ?></textarea>
						<p class="description">Sans guillemets : ils sont ajoutés à l'affichage.</p>
					</td>
				</tr>
			</table>

			<h2>Avis clients authentiques</h2>
			<p>
				Uniquement les six témoignages authentiques déjà publiés sur le site actuel
				(CLAUDE.md §5.5) — Jean-Louis D., Anna P., Michel G., Laurent, Laura,
				Anne-Sophie — ou de nouveaux avis Google réellement reçus. Jamais un avis
				inventé, jamais un avis B2C Top-Famille présenté comme un avis B2B
				Top-Famille Pro.
			</p>
			<?php for ( $i = 0; $i < TFP_REASSURANCE_AVIS_MAX; $i++ ) : $a = $values['avis'][ $i ]; ?>
				<h3>Avis <?php echo (int) $i + 1; ?></h3>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="tfp-avis-<?php echo $i; ?>-nom">Nom (tel que publié)</label></th>
						<td><input type="text" id="tfp-avis-<?php echo $i; ?>-nom" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[avis][<?php echo $i; ?>][nom]" value="<?php echo esc_attr( $a['nom'] ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="tfp-avis-<?php echo $i; ?>-texte">Texte de l'avis</label></th>
						<td><textarea id="tfp-avis-<?php echo $i; ?>-texte" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[avis][<?php echo $i; ?>][texte]" rows="3" class="large-text"><?php echo esc_textarea( $a['texte'] ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="tfp-avis-<?php echo $i; ?>-note">Note (sur 5)</label></th>
						<td><input type="number" id="tfp-avis-<?php echo $i; ?>-note" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[avis][<?php echo $i; ?>][note]" value="<?php echo esc_attr( $a['note'] ); ?>" min="1" max="5" class="small-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="tfp-avis-<?php echo $i; ?>-contexte">Contexte (rôle · type de local)</label></th>
						<td><input type="text" id="tfp-avis-<?php echo $i; ?>-contexte" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[avis][<?php echo $i; ?>][contexte]" value="<?php echo esc_attr( $a['contexte'] ); ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="tfp-avis-<?php echo $i; ?>-source">Source</label></th>
						<td><input type="text" id="tfp-avis-<?php echo $i; ?>-source" name="<?php echo esc_attr( TFP_REASSURANCE_OPTION ); ?>[avis][<?php echo $i; ?>][source]" value="<?php echo esc_attr( $a['source'] ); ?>" class="regular-text" placeholder="Ex. Google, site historique topentreprise.fr…"></td>
					</tr>
				</table>
			<?php endfor; ?>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Retourne les données de réassurance réelles, ou des valeurs vides — jamais une valeur
 * fictive de repli. Ne dépend d'aucun plugin : lit directement l'option WordPress.
 *
 * @return array{google_url: string, note: float|null, nombre_avis: int|null, avis: array}
 */
function tfp_reassurance_data() {
	$values = wp_parse_args( get_option( TFP_REASSURANCE_OPTION, array() ), tfp_reassurance_defaults() );

	$avis = array_values(
		array_filter(
			$values['avis'],
			function ( $a ) {
				return ! empty( $a['texte'] );
			}
		)
	);

	return array(
		'google_url'  => $values['google_url'],
		'note'        => '' !== $values['note'] ? (float) $values['note'] : null,
		'nombre_avis' => '' !== $values['nombre_avis'] ? (int) $values['nombre_avis'] : null,
		'avis'        => $avis,
	);
}
