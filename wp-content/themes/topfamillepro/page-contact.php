<?php
/**
 * Page statique « Contact » (/contact/) — gabarit dédié (CLAUDE.md §3).
 *
 * Coordonnées réelles uniquement (PROJECT_INPUTS.md §1) : Audrey (gérante) et Manon (assistante).
 * L'adresse de Saint-Apollinaire est présentée comme siège social, jamais comme une agence ou un
 * point d'accueil visitable (CLAUDE.md §5.2 : un seul établissement, aucune agence locale).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site = tfp_site_data();

tfp_seo(
	array(
		'title'       => 'Contacter Top-Famille Pro | Nettoyage professionnel',
		'description' => 'Téléphone, e-mail ou formulaire : Audrey répond sous 24 heures aux questions sur les prestations, les tarifs et les zones couvertes.',
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Contact', 'url' => null ),
		),
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<?php
/*
 * Rembourrages déclarés bande par bande sur la maquette — clamp(26px, 4vw, 48px) en haut,
 * clamp(20px, 3vw, 32px) en bas pour l'en-tête. Le thème posait clamp(30px, 4vw, 52px) des deux
 * côtés sur les trois bandes de la page, soit 104 px à 1440 contre 80 relevés sur la première et
 * 48 sur la deuxième, qui n'a aucun rembourrage haut.
 */
?>
<section class="tfp-container tfp-container--narrow tfp-section--tight" style="--tfp-bande-haut:clamp(26px, 4vw, 48px);--tfp-bande-bas:clamp(20px, 3vw, 32px)">
	<h1>Contacter Top-Famille Pro</h1>
	<p class="tfp-section__lede">Une question, un projet d'entretien ? <?php echo esc_html( explode( ' ', $site['manager'] )[0] ); ?> vous répond directement, sous 24 heures.</p>
</section>

<?php
/*
 * Micro-cartes de la page Contact.
 *
 * Cette page a son propre gabarit, mais **pas sa propre architecture** : ses cartes passent par
 * `tfp_card_grid()` et `tfp_chip_list()`, les mêmes composants que les bandes statiques, avec le
 * même schéma structuré. Une seconde implémentation aurait divergé à la première correction.
 *
 * Les coordonnées viennent toutes de `tfp_site_data()` : aucun numéro, aucune adresse et aucune
 * adresse électronique n'est recopiée ici.
 *
 * Géométrie relevée sur la maquette à 1440 px :
 *  - deux cartes d'orientation : 403×104, fond #EFEFEF, rayon 16, filet 1 px, rembourrage 22,
 *    deux colonnes, écart 14 ;
 *  - quatre cartes de coordonnées : 512×86, fond blanc, rayon 12, filet 1 px, rembourrage 16/18,
 *    une colonne, écart 12 ;
 *  - trois pastilles de renvoi : 118×43, fond #F4F7F8, rayon 100, filet 1 px, écart 10.
 */
$prenom = explode( ' ', $site['manager'] )[0];

$orientation = array(
	'colonnes' => 2,
	'theme'    => 'clair',
	'variante' => 'lien',
	'gap'      => '14px',
	'fond'     => 'rgb(239, 239, 239)',
	'rayon'    => '16px',
	'filet'    => '1px',
	'padding'  => '22px',
	'items'    => array(
		array(
			'titre'       => 'J’ai une question',
			'description' => 'Formulaire court, réponse par e-mail ou téléphone.',
			'route'       => '',
		),
		/*
		 * Pas de libellé de lien surajouté : la carte entière EST le lien, comme dans la maquette,
		 * et son nom accessible — titre + description — dit déjà où elle mène. La ligne
		 * « Demander mon devis → » ajoutait 18 px à la bande sans rien apprendre au visiteur.
		 */
		array(
			'titre'       => 'J’ai un besoin de nettoyage',
			'description' => 'Direction le formulaire de devis détaillé',
			'route'       => '#/demande-de-devis',
		),
	),
);

$coordonnees = array(
	'colonnes' => 1,
	'theme'    => 'clair',
	'variante' => 'lien',
	'gap'      => '12px',
	'fond'     => 'rgb(255, 255, 255)',
	'rayon'    => '12px',
	'filet'    => '1px',
	'padding'  => '16px 18px',
	'items'    => array(
		array(
			'icone'       => '☎',
			'titre'       => 'Téléphone',
			'description' => $site['phone'],
			'route'       => 'tel:' . $site['phone_href'],
			'aria'        => 'Appeler ' . $prenom . ' au ' . $site['phone'],
		),
		array(
			'icone'       => '✉',
			'titre'       => 'E-mail',
			'description' => $site['email'],
			'route'       => 'mailto:' . $site['email'],
			'aria'        => 'Écrire à ' . $site['email'],
		),
		/*
		 * L'adresse postale et la mention « pas d'accueil du public » vivent DANS la carte
		 * Implantation, en lignes complémentaires, et non dans un paragraphe isolé en bas de page.
		 * Le paragraphe coûtait 74 px à la colonne la plus haute de la bande à 1440 px pour une
		 * information qui a déjà sa carte, et il séparait l'adresse du reste des coordonnées.
		 */
		array(
			'icone'       => '📍',
			'titre'       => 'Implantation',
			'description' => $site['address_city'] . ' (' . substr( $site['address_cp'], 0, 2 ) . ') · ' . $site['address_region'],
			'lignes'      => array(
				$site['address_street'] . ', ' . $site['address_cp'] . ' ' . $site['address_city'] . ' — adresse administrative, sans accueil du public.',
			),
		),
	),
);

/*
 * Horaires de contact.
 *
 * La maquette écrit « Du lundi au vendredi · à confirmer · réponse sous 24 h » : l'amplitude n'a
 * jamais été arrêtée. Trois façons de traiter cela, une seule est honnête — inventer une amplitude
 * plausible est exclu, supprimer la carte fait perdre une information réelle (la réponse sous
 * 24 h), il reste donc à afficher ce qui est su en disant que ce n'est pas figé. Le « à confirmer »
 * brut de la maquette est remplacé par une mention de transparence explicite, du même type que
 * celle des témoignages provisoires, et la valeur devient administrable
 * (Réglages → Réassurance & avis) pour être corrigée sans toucher au code.
 *
 * Aucun `openingHoursSpecification` n'est émis nulle part sur le site : voir includes/seo.php.
 */
$horaires = tfp_reassurance_data()['horaires_contact'];
if ( '' !== $horaires ) {
	$coordonnees['items'][] = array(
		'icone'       => '🕑',
		'titre'       => 'Horaires de contact',
		'description' => $horaires,
		'provisoire'  => true,
		'note'        => 'Horaires indicatifs, en cours de confirmation.',
	);
}
?>

<section class="tfp-section--tight" style="--tfp-bande-haut:0px;--tfp-bande-bas:clamp(30px, 4vw, 48px)">
	<div class="tfp-container tfp-container--narrow tfp-contact-orientation">
		<?php tfp_card_grid( $orientation ); ?>
	</div>
</section>

<?php
/*
 * Ordre des deux colonnes : la maquette met le FORMULAIRE d'abord et la colonne de réassurance
 * ensuite — c'est aussi l'ordre de lecture quand elles s'empilent sous 900 px, et il place l'action
 * avant la preuve. Le thème avait l'ordre inverse, ce qui repoussait le formulaire de 590 px vers
 * le bas sur mobile.
 *
 * Les deux colonnes sont déclarées en bases souples sur la maquette — `flex: 1 1 400px` pour le
 * formulaire, `flex: 1 1 300px` pour la colonne latérale — et non en fractions de grille : à
 * 1440 px cela donne 652 et 552, quand la grille 1,15fr/1fr du thème donnait 610 et 530. Le
 * formulaire, colonne la plus haute, se retrouvait dans la plus étroite des deux.
 */
?>
<section class="tfp-section--tight" style="--tfp-bande-haut:0px;--tfp-bande-bas:clamp(52px, 7vw, 92px)">
	<div class="tfp-container tfp-contact-cols">
		<div class="tfp-contact-cols__form">
			<?php
			/*
			 * Formulaire de contact court — le composant que la maquette place ici, et qui manquait.
			 *
			 * Distinct du formulaire de devis en deux étapes : « J'ai une question » et « J'ai un
			 * besoin de nettoyage » sont deux intentions différentes, et renvoyer la première vers
			 * le second parcours faisait abandonner les visiteurs qui n'ont qu'une question.
			 */
			$tentative = tfp_contact_previous_attempt();
			$erreurs   = $tentative['erreurs'];
			$valeurs   = $tentative['valeurs'];
			$etat      = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
			$val       = static function ( $cle ) use ( $valeurs ) {
				return esc_attr( $valeurs[ $cle ] ?? '' );
			};
			?>
			<h2 id="formulaire-contact">J’ai une question</h2>

			<?php
			/*
			 * Confirmation et erreurs annoncées : `role="status"` pour un succès, `role="alert"`
			 * pour une erreur. Un lecteur d'écran les restitue sans que l'utilisateur ait à partir
			 * à leur recherche.
			 */
			if ( 'envoye' === $etat ) : ?>
				<p class="tfp-form-message tfp-form-message--ok" role="status">Message envoyé. Audrey vous répond sous 24 heures.</p>
			<?php elseif ( 'trop-de-demandes' === $etat ) : ?>
				<p class="tfp-form-message tfp-form-message--err" role="alert">Trop de messages envoyés depuis cet appareil. Merci de réessayer plus tard, ou d’appeler directement.</p>
			<?php elseif ( 'erreur-securite' === $etat ) : ?>
				<p class="tfp-form-message tfp-form-message--err" role="alert">La session a expiré. Merci de renvoyer le formulaire.</p>
			<?php elseif ( $erreurs ) : ?>
				<p class="tfp-form-message tfp-form-message--err" role="alert">Le formulaire n’a pas pu être envoyé : <?php echo esc_html( count( $erreurs ) ); ?> champ(s) à corriger.</p>
			<?php endif; ?>

			<?php
			/*
			 * `data-tfp-mail-disabled` : interrupteur d'envoi, exposé au rendu. La suite de tests le
			 * lit avant toute soumission et refuse de soumettre s'il est absent — c'est ce qui
			 * garantit qu'aucun test ne peut faire partir un e-mail depuis une installation réelle.
			 */
			?>
			<form class="tfp-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate<?php echo tfp_contact_mail_disabled() ? ' data-tfp-mail-disabled="1"' : ''; ?>>
				<input type="hidden" name="action" value="tfp_submit_contact">
				<?php
				// Jeton propre à cet envoi : il rattache la saisie conservée à cette tentative-ci,
				// et non à l'adresse IP, que deux visiteurs peuvent partager.
				?>
				<input type="hidden" name="tfp_contact_ticket" value="<?php echo esc_attr( wp_generate_password( 12, false, false ) ); ?>">
				<?php wp_nonce_field( 'tfp_contact_submit', 'tfp_contact_nonce' ); ?>

				<?php
				/*
				 * Honeypot : réellement invisible et hors du parcours clavier. `aria-hidden` et
				 * `tabindex="-1"` l'écartent des technologies d'assistance ; il n'est pas masqué par
				 * `display:none`, que certains automates détectent.
				 */
				?>
				<div class="tfp-honeypot" aria-hidden="true">
					<label for="tfp_contact_site">Ne pas remplir</label>
					<input type="text" id="tfp_contact_site" name="tfp_contact_site" tabindex="-1" autocomplete="off">
				</div>

				<div class="tfp-contact-form__row">
					<p class="tfp-field">
						<label for="contact-nom">Nom <span aria-hidden="true">*</span></label>
						<input type="text" id="contact-nom" name="tfp_contact_nom" required autocomplete="name"
							value="<?php echo $val( 'nom' ); ?>"
							<?php echo isset( $erreurs['nom'] ) ? 'aria-invalid="true" aria-describedby="err-nom"' : ''; ?>>
						<?php if ( isset( $erreurs['nom'] ) ) : ?>
							<span class="tfp-field__error" id="err-nom"><?php echo esc_html( $erreurs['nom'] ); ?></span>
						<?php endif; ?>
					</p>
					<p class="tfp-field">
						<label for="contact-entreprise">Entreprise (facultatif)</label>
						<input type="text" id="contact-entreprise" name="tfp_contact_entreprise" autocomplete="organization" value="<?php echo $val( 'entreprise' ); ?>">
					</p>
				</div>

				<?php
				/*
				 * Deux lignes de deux champs, comme la maquette — et non une seule ligne de quatre.
				 * La différence n'est pas cosmétique : `auto-fit` répartit ce qu'on lui donne, et
				 * quatre champs dans une colonne de 707 px se rangeaient sur TROIS colonnes puis une
				 * quatrième orpheline, alors que deux lignes de deux tiennent chacune sur deux
				 * colonnes de 346 px à toutes les largeurs où la ligne ne se replie pas.
				 */
				?>
				<div class="tfp-contact-form__row">
					<p class="tfp-field">
						<label for="contact-email">E-mail <span aria-hidden="true">*</span></label>
						<input type="email" id="contact-email" name="tfp_contact_email" required autocomplete="email"
							value="<?php echo $val( 'email' ); ?>"
							<?php echo isset( $erreurs['email'] ) ? 'aria-invalid="true" aria-describedby="err-email"' : ''; ?>>
						<?php if ( isset( $erreurs['email'] ) ) : ?>
							<span class="tfp-field__error" id="err-email"><?php echo esc_html( $erreurs['email'] ); ?></span>
						<?php endif; ?>
					</p>
					<p class="tfp-field">
						<label for="contact-telephone">Téléphone (facultatif)</label>
						<input type="tel" id="contact-telephone" name="tfp_contact_telephone" autocomplete="tel" value="<?php echo $val( 'telephone' ); ?>">
					</p>
				</div>

				<p class="tfp-field">
					<label for="contact-objet">Objet <span aria-hidden="true">*</span></label>
					<select id="contact-objet" name="tfp_contact_objet" required
						<?php echo isset( $erreurs['objet'] ) ? 'aria-invalid="true" aria-describedby="err-objet"' : ''; ?>>
						<?php foreach ( tfp_contact_subjects() as $cle => $libelle ) : ?>
							<option value="<?php echo esc_attr( $cle ); ?>" <?php selected( $valeurs['objet'] ?? '', $cle ); ?>><?php echo esc_html( $libelle ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $erreurs['objet'] ) ) : ?>
						<span class="tfp-field__error" id="err-objet"><?php echo esc_html( $erreurs['objet'] ); ?></span>
					<?php endif; ?>
				</p>

				<p class="tfp-field">
					<label for="contact-message">Message <span aria-hidden="true">*</span></label>
					<textarea id="contact-message" name="tfp_contact_message" rows="5" required
						<?php echo isset( $erreurs['message'] ) ? 'aria-invalid="true" aria-describedby="err-message"' : ''; ?>><?php echo esc_textarea( $valeurs['message'] ?? '' ); ?></textarea>
					<?php if ( isset( $erreurs['message'] ) ) : ?>
						<span class="tfp-field__error" id="err-message"><?php echo esc_html( $erreurs['message'] ); ?></span>
					<?php endif; ?>
				</p>

				<p class="tfp-field tfp-field--check">
					<input type="checkbox" id="contact-consentement" name="tfp_contact_consentement" value="1" required
						<?php checked( ! empty( $valeurs['consentement'] ) ); ?>
						<?php echo isset( $erreurs['consentement'] ) ? 'aria-invalid="true" aria-describedby="err-consentement"' : ''; ?>>
					<label for="contact-consentement">J’accepte que mes informations soient utilisées pour me répondre.</label>
					<?php if ( isset( $erreurs['consentement'] ) ) : ?>
						<span class="tfp-field__error" id="err-consentement"><?php echo esc_html( $erreurs['consentement'] ); ?></span>
					<?php endif; ?>
				</p>

				<p>
					<button type="submit" class="tfp-btn tfp-btn--primary" data-tfp-once>Envoyer mon message</button>
				</p>
			</form>

		</div>
		<div class="tfp-contact-cols__aside">
			<div class="tfp-contact-person">
				<?php tfp_picture( 'audrey-placeholder', array( 'sizes' => '64px', 'alt' => '', 'class' => 'tfp-contact-person__photo' ) ); ?>
				<div>
					<strong><?php echo esc_html( $prenom ); ?></strong>
					<span>Votre interlocutrice, du devis au suivi</span>
				</div>
			</div>
			<?php
			tfp_card_grid( $coordonnees );
			/*
			 * Septième carte de la maquette : rappel marine de la note Google et du tarif
			 * (512×68, fond #174A81, rayon 14). La note est réelle et confirmée ; le compteur
			 * d'avis de la maquette, lui, ne l'est pas et n'est donc pas repris (CLAUDE.md §5.5).
			 */
			$note = tfp_reassurance_data()['note'];
			tfp_card_grid(
				array(
					'colonnes' => 1,
					'theme'    => 'sombre',
					'variante' => 'texte',
					'gap'      => '12px',
					'fond'     => 'rgb(23, 74, 129)',
					'rayon'    => '14px',
					'filet'    => '0px',
					'padding'  => '14px 18px',
					'items'    => array(
						array(
							'icone'       => $note ? '★★★★★' : '',
							// Sans note saisie, la carte garde le tarif et perd la mention Google —
							// plutôt que d'afficher « /5 sur Google » sans chiffre devant.
							'titre'       => $note
								? number_format( (float) $note, 1, ',', '' ) . '/5 sur Google'
								: tfp_format_price( $site['price_unique'] ) . ' HT/h',
							'description' => $note
								? tfp_format_price( $site['price_unique'] ) . ' HT/h — tarif unique en région'
								: 'Tarif unique en région, en régulier comme en ponctuel.',
						),
					),
				)
			);
			tfp_chip_list(
				array(
					array( 'texte' => 'Voir les tarifs', 'url' => home_url( '/tarifs/' ) ),
					array( 'texte' => 'Zones d’intervention', 'url' => home_url( '/zones-intervention/' ) ),
					array( 'texte' => 'Fonctionnement', 'url' => home_url( '/notre-fonctionnement/' ) ),
				)
			);

			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
