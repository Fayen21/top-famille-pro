<?php
/**
 * Page statique « Demande de devis » (/demande-de-devis/) — gabarit dédié (CLAUDE.md §3).
 *
 * Formulaire réel à deux étapes conforme au brief phase 4 (PROMPT-PHASES.md) :
 * Étape 1 — type de locaux, régime (régulier/ponctuel), ville, code postal, surface approximative,
 * nom, téléphone ou e-mail. Étape 2 — entreprise, fréquence, créneau, message, consentement.
 *
 * Un seul <form>, deux <fieldset> : les données restent dans le DOM en permanence entre les
 * étapes (src/js/quote-form.js gère uniquement l'affichage), donc rien n'est perdu si le visiteur
 * revient en arrière. Sans JavaScript, les deux étapes restent visibles et le formulaire reste
 * soumissible en une fois.
 *
 * Contexte visiteur capté automatiquement (page d'origine, référent, UTM) + préremplissage réel
 * depuis les pages prestation/zone via les paramètres ?service=&ville=&departement= (les CTA de
 * ces pages les transmettent désormais, voir single-prestation.php/single-zone.php). Le paramètre
 * n'est pas nommé « prestation » : ce nom est le query_var natif du CPT du même nom et
 * détournerait la requête principale de WordPress (voir le commentaire dans single-prestation.php).
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
	'champs'  => 'Merci de renseigner votre nom, un moyen de vous joindre (téléphone ou e-mail), votre consentement et un message décrivant votre besoin.',
	'session' => 'Votre session a expiré, merci de renvoyer le formulaire.',
	'limite'  => 'Trop de demandes envoyées récemment depuis cette connexion. Merci de réessayer un peu plus tard, ou d\'appeler directement Audrey.',
	'envoi'   => 'L\'envoi a échoué côté serveur. Merci de réessayer, ou d\'appeler directement Audrey au ' . $site['phone'] . '.',
);

$types_locaux = wp_list_pluck( tfp_quote_types_locaux(), 'label' );
/*
 * Préremplissage depuis la page d'origine, CÔTÉ SERVEUR (revue du 25 octobre 2026) : une page
 * prestation envoie `?service=bureaux`, une page de zone `?ville=Dijon`. Seul le libellé visible de
 * la prestation était prérempli, et par JavaScript ; le type de locaux restait à choisir alors que
 * la page d'origine le disait déjà. La prestation ponctuelle préremplit aussi le régime.
 */
$pre_service = isset( $_GET['service'] ) ? sanitize_key( wp_unslash( $_GET['service'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- lecture d'un paramètre d'affichage.
$pre_type    = isset( $types_locaux[ $pre_service ] ) ? $pre_service : '';
$pre_regime  = 'ponctuel' === $pre_service ? 'ponctuel' : '';
$pre_ville   = isset( $_GET['ville'] ) ? sanitize_text_field( wp_unslash( $_GET['ville'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
/*
 * Deux informations distinctes (recette du 12 novembre 2026) :
 *  - `prestation` : la prestation DEMANDÉE, déduite du type de locaux et du régime choisis. Le
 *    serveur la recalcule à la réception ; src/js/quote-form.js la tient à jour à chaque
 *    changement, y compris quand le prospect revient modifier l'étape 1 ;
 *  - `prestation_origine` : la prestation de la page d'où vient le prospect (`service_label`),
 *    conservée telle quelle comme contexte. Elle ne décide plus de rien.
 */
$pre_origine    = isset( $_GET['service_label'] ) ? sanitize_text_field( wp_unslash( $_GET['service_label'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- lecture d'un paramètre d'affichage.
$pre_prestation = tfp_quote_prestation_demandee( $pre_type, $pre_regime );

$frequences = array(
	''                 => 'À définir ensemble',
	'quotidien'        => 'Quotidien',
	'plusieurs-semaine' => 'Plusieurs fois par semaine',
	'hebdomadaire'     => 'Hebdomadaire',
	'bimensuel'        => 'Toutes les deux semaines',
	'mensuel'          => 'Mensuel',
	'ponctuel'         => 'Une seule fois',
);

$creneaux = array(
	''         => 'Peu importe',
	'matin'    => "Tôt le matin, avant l'arrivée des équipes",
	'soir'     => 'En soirée, après le départ des équipes',
	'journee'  => 'En journée',
	'weekend'  => 'Le week-end',
);

/*
 * Questions de la page devis (17 novembre 2026) — visibles sous le formulaire, et déclarées en
 * FAQPage. Faits validés uniquement : gratuité, délai de 24 h, champs du formulaire, usage des
 * données (texte du consentement), tarif et périmètre.
 */
$tfp_prenom_gerante = explode( ' ', $site['manager'] )[0];
$tfp_faq_devis      = array(
	array( 'question' => 'Le devis est-il vraiment gratuit ?', 'reponse' => "Oui. Le devis est gratuit et sans engagement : vous êtes libre de ne pas y donner suite, sans frais ni relance insistante." ),
	array( 'question' => 'Sous quel délai vais-je recevoir une réponse ?', 'reponse' => "{$tfp_prenom_gerante} étudie personnellement chaque demande et vous répond sous 24 heures, par téléphone ou par e-mail selon le moyen que vous avez indiqué." ),
	array( 'question' => 'Quelles informations préparer ?', 'reponse' => "Le type de locaux, la commune, et si vous les avez : la surface approximative, la fréquence souhaitée et les horaires possibles. Rien n'est obligatoire au-delà de votre nom, d'un moyen de vous joindre et de quelques mots sur votre besoin : le reste se précise ensemble." ),
	array( 'question' => "Que se passe-t-il après l'envoi ?", 'reponse' => "{$tfp_prenom_gerante} vous recontacte pour préciser vos locaux et vos contraintes. Le cahier des charges est établi avec vous — tâches, fréquence, horaires, accès — puis vous recevez un devis écrit qui détaille le volume d'heures et tous les frais qui s'appliquent." ),
	array( 'question' => 'Combien coûte le nettoyage ?', 'reponse' => "{$site['price_unique_display']} HT de l'heure, le même tarif en régulier et en ponctuel, partout en {$site['address_region']}. Le matériel et les produits sont fournis par le client. Les autres frais (gestion mensuelle, mise en place, déplacement, majoration du dimanche, des jours fériés et de la nuit) sont écrits dans le devis lorsqu'ils s'appliquent." ),
	array( 'question' => 'À quoi servent mes données ?', 'reponse' => "Uniquement à traiter votre demande de devis : elles ne sont ni revendues ni utilisées pour de la prospection. Le détail figure dans notre politique de confidentialité." ),
);

tfp_seo(
	array(
		'schema'      => array(
			array(
				'@type'      => 'FAQPage',
				'@id'        => trailingslashit( home_url( '/demande-de-devis/' ) ) . '#faq',
				'mainEntity' => array_map(
					static function ( $item ) {
						return array( '@type' => 'Question', 'name' => $item['question'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['reponse'] ) );
					},
					$tfp_faq_devis
				),
			),
		),
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

<?php
/*
 * Disposition en deux colonnes de la maquette : le formulaire à gauche (642 px), une colonne de
 * réassurance à droite (482 px, écart 56 px). Le thème empilait les deux, ce qui allongeait la
 * page de 700 px et éloignait la preuve du champ à remplir — c'est précisément là qu'elle sert.
 * Sous 900 px, la maquette empile elle aussi.
 */
?>
<section class="tfp-quote-page">
	<div class="tfp-container tfp-quote-layout">
		<div class="tfp-quote-main">
			<p class="tfp-eyebrow">Devis gratuit · Réponse sous 24 h</p>
			<h1>Demandez votre devis gratuit</h1>
			<p class="tfp-section__lede">Décrivez-nous vos locaux et vos besoins en deux étapes. <?php echo esc_html( $tfp_prenom_gerante ); ?> vous répond sous 24 heures avec une proposition claire et chiffrée, sans engagement.</p>
			<ul class="tfp-quote-garanties">
				<li><span class="tfp-quote-garanties__icone" aria-hidden="true">✓</span><span><strong>Gratuit</strong> et sans engagement</span></li>
				<li><span class="tfp-quote-garanties__icone" aria-hidden="true">24 h</span><span><strong>Réponse</strong> sous 24 heures</span></li>
				<li><span class="tfp-quote-garanties__icone" aria-hidden="true"><?php echo esc_html( mb_substr( $tfp_prenom_gerante, 0, 1 ) ); ?></span><span><strong>Étudié par <?php echo esc_html( $tfp_prenom_gerante ); ?></strong>, la gérante</span></li>
			</ul>

		<?php if ( $success ) : ?>
			<div class="tfp-form-notice" role="status">
				<h2>Votre demande a bien été envoyée</h2>
				<p style="margin-top:8px">Merci ! <?php echo esc_html( $site['manager'] ); ?> vous répond sous 24 heures. Pour toute urgence, vous pouvez aussi appeler directement le <a href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>"><?php echo esc_html( $site['phone'] ); ?></a>.</p>
			</div>
		<?php else : ?>

			<h2 class="visually-hidden">Votre demande</h2>

			<?php if ( $erreur && isset( $erreur_messages[ $erreur ] ) ) : ?>
				<div class="tfp-form-notice tfp-form-notice--error" role="alert">
					<p><?php echo esc_html( $erreur_messages[ $erreur ] ); ?></p>
				</div>
			<?php endif; ?>

			<div class="tfp-quote-panel">
			<form id="tfp-formulaire-devis" class="tfp-quote-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate data-tfp-analytics="quote"<?php echo tfp_quote_mail_disabled() ? ' data-tfp-mail-disabled' : ''; ?>>
				<div class="tfp-form-errors" role="alert" aria-live="polite" data-form-errors></div>

				<input type="hidden" name="action" value="tfp_submit_devis">
				<?php wp_nonce_field( 'tfp_quote_submit', 'tfp_quote_nonce' ); ?>

				<div class="tfp-field-honeypot" aria-hidden="true">
					<label for="tfp-site-web">Laisser vide</label>
					<input type="text" id="tfp-site-web" name="tfp_site_web" tabindex="-1" autocomplete="off">
				</div>

				<input type="hidden" name="departement" value="">
				<?php $raw_referer = wp_get_raw_referer(); ?>
				<input type="hidden" name="page_origine" value="<?php echo $raw_referer ? esc_url( $raw_referer ) : ''; ?>">
				<input type="hidden" name="referent" value="<?php echo $raw_referer ? esc_attr( wp_parse_url( $raw_referer, PHP_URL_HOST ) ) : ''; ?>">
				<input type="hidden" name="utm_source" value="<?php echo isset( $_GET['utm_source'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_source'] ) ) ) : ''; ?>">
				<input type="hidden" name="utm_medium" value="<?php echo isset( $_GET['utm_medium'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) ) : ''; ?>">
				<input type="hidden" name="utm_campaign" value="<?php echo isset( $_GET['utm_campaign'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ) ) : ''; ?>">

				<?php
				/*
				 * Indicateur de progression relevé sur la maquette : rang de l'étape en bleu, jauge
				 * de 3 px remplie à la proportion atteinte, objet de l'étape à droite. Le thème
				 * posait à la place un titre de 20 px en gras, qui prenait le pas sur le premier
				 * champ.
				 *
				 * Le tout reste dans le `<legend>` : c'est lui qui donne son nom accessible au
				 * groupe de champs. La jauge est `aria-hidden` — elle ne dit rien qu'« Étape 1 sur
				 * 2 » ne dise déjà.
				 *
				 * La maquette écrit « ≈ 20 secondes » dans la case de droite de l'étape 1. Ce
				 * chiffre n'est pas repris : il n'a été mesuré nulle part, et CLAUDE.md §5.1
				 * interdit d'écrire une valeur plausible à la place d'une valeur relevée. La case
				 * porte donc l'objet de l'étape, exactement comme la maquette le fait elle-même à
				 * l'étape 2 (« Précisions utiles »).
				 */
				?>
				<fieldset data-step="0" style="border:none;padding:0;margin:0">
					<legend class="tfp-form-step">
						<span class="tfp-form-step__rang">Étape 1 sur 2</span>
						<span class="tfp-form-step__jauge" aria-hidden="true"><span class="tfp-form-step__part" style="width:50%"></span></span>
						<span class="tfp-form-step__objet">Vos locaux et vos coordonnées</span>
					</legend>
					<p class="tfp-form-step__lede">L'essentiel d'abord : de quoi vous rappeler et chiffrer. Les détails viennent à l'étape suivante.</p>

					<?php
					/*
					 * La maquette range les champs de l'étape 1 par LIGNES, pas un par ligne : type de
					 * locaux + régime, ville + code postal, nom + téléphone. Les règles sont déclarées
					 * en clair dans le prototype — `repeat(auto-fit, minmax(min(100%, 220px), 1fr))`
					 * pour les paires équilibrées, `2fr 1fr` pour ville/code postal — et se replient
					 * seules sous 470 px environ. Le thème empilait les huit champs, ce qui allongeait
					 * la page de 246 px à 768 px et repoussait le bouton sous la ligne de flottaison.
					 */
					?>
					<div class="tfp-form-row">
						<div class="tfp-field">
							<label for="tfp-type-locaux">Type de locaux *</label>
							<select id="tfp-type-locaux" name="type_locaux" required>
								<option value=""<?php selected( $pre_type, '' ); ?>>Sélectionnez le type de locaux</option>
								<?php foreach ( tfp_quote_types_locaux() as $value => $type ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" data-prestation="<?php echo esc_attr( $type['prestation'] ); ?>"<?php selected( $pre_type, $value ); ?>><?php echo esc_html( $type['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<?php
						/*
						 * Régime : une LISTE DÉROULANTE, comme la maquette (G26 §6).
						 *
						 * Le thème posait deux boutons radio. Le champ, son nom, ses deux valeurs et
						 * son caractère obligatoire sont inchangés — seule la commande change, pour
						 * que la rangée présente les deux mêmes listes côte à côte que le prototype.
						 * La validation client est générique (`[required]`, src/js/quote-form.js) :
						 * une liste dont la première option est vide échoue exactement comme un
						 * groupe de radios non coché, et le contrôle serveur est inchangé.
						 */
						?>
						<div class="tfp-field">
							<label for="tfp-regime">Régulier ou ponctuel *</label>
							<select id="tfp-regime" name="regime" required>
								<option value="">Choisir…</option>
								<option value="regulier">Entretien régulier</option>
								<option value="ponctuel"<?php selected( $pre_regime, 'ponctuel' ); ?>>Intervention ponctuelle</option>
							</select>
						</div>
					</div>

					<?php
					// Passe commerciale du 10 novembre 2026 (§6) : le code postal et la surface passent à
					// l'étape 2. L'étape 1 ne garde que ce qui permet de rappeler et d'orienter la demande.
					?>
					<div class="tfp-field">
						<label for="tfp-ville-visible">Ville</label>
						<input type="text" id="tfp-ville-visible" name="ville" autocomplete="address-level2" placeholder="Ex. Dijon" value="<?php echo esc_attr( $pre_ville ); ?>">
						<span class="tfp-field__hint">Commune où se trouvent les locaux.</span>
					</div>

					<div class="tfp-form-row">
						<div class="tfp-field">
							<label for="tfp-nom">Nom &amp; prénom *</label>
							<input type="text" id="tfp-nom" name="nom" autocomplete="name" required placeholder="Votre nom">
							<span class="tfp-field__hint">Pour savoir qui rappeler.</span>
						</div>

						<div class="tfp-field">
							<label for="tfp-telephone">Téléphone</label>
							<input type="tel" id="tfp-telephone" name="telephone" autocomplete="tel" placeholder="Ex. 06 12 34 56 78">
						</div>
					</div>

					<div class="tfp-field">
						<label for="tfp-email">E-mail</label>
						<input type="email" id="tfp-email" name="email" autocomplete="email" placeholder="vous@entreprise.fr">
						<span class="tfp-field__hint">Téléphone ou e-mail : l'un des deux suffit.</span>
					</div>

					<?php
					// La mention de réassurance exigée par CLAUDE.md §8 est POSÉE DANS la rangée de
					// commandes, à droite du bouton, comme dans la maquette — et non sous le
					// formulaire, où elle était séparée du CTA qu'elle rassure. Le texte reste
					// celui qu'impose CLAUDE.md §8, pas celui du prototype.
					?>
					<div class="tfp-form-actions">
						<button type="button" class="tfp-btn tfp-btn--primary" data-step-next>Continuer ma demande</button>
						<span class="tfp-form-actions__note">Gratuit · Sans engagement · Réponse sous 24 h</span>
					</div>
				</fieldset>

				<fieldset data-step="1" hidden style="border:none;padding:0;margin:0">
					<legend class="tfp-form-step">
						<span class="tfp-form-step__rang">Étape 2 sur 2</span>
						<span class="tfp-form-step__jauge" aria-hidden="true"><span class="tfp-form-step__part" style="width:100%"></span></span>
						<span class="tfp-form-step__objet">Précisions sur vos locaux</span>
					</legend>

					<?php
					/*
					 * Résumé de l'étape 1, relevé sur la maquette : filet turquoise à gauche, rappel
					 * de ce qui vient d'être saisi, et un retour en arrière écrit en toutes lettres.
					 *
					 * Le texte dit « renseignée », pas « enregistrée » comme le prototype : rien
					 * n'est envoyé au serveur avant l'étape 2, et annoncer un enregistrement qui
					 * n'a pas eu lieu serait faux.
					 *
					 * Il est rempli par `src/js/quote-form.js` à partir des champs eux-mêmes, et
					 * reste masqué sans JavaScript — où les deux étapes sont de toute façon
					 * visibles d'un bloc, et où un résumé n'aurait rien à résumer.
					 */
					?>
					<p class="tfp-form-recap" role="status" aria-live="polite" data-quote-recap hidden>
						<span data-quote-recap-text></span>
						<button type="button" class="tfp-btn-lien" data-step-prev>Modifier l'étape 1</button>
					</p>

					<?php
					/*
					 * La prestation n'est plus redemandée (§6) : le type de locaux de l'étape 1 la dit
					 * déjà. Le champ caché `prestation` en est déduit (type + régime) et suit chaque
					 * changement ; `prestation_origine` garde la page d'où vient le prospect.
					 */
					?>
					<input type="hidden" id="tfp-prestation-visible" name="prestation" value="<?php echo esc_attr( $pre_prestation ); ?>">
					<input type="hidden" id="tfp-prestation-origine" name="prestation_origine" value="<?php echo esc_attr( $pre_origine ); ?>">

					<p class="tfp-form-step__lede">Seuls votre message et votre accord sont obligatoires : les autres précisions aident à chiffrer juste.</p>

					<div class="tfp-form-row tfp-form-row--2-1">
						<div class="tfp-field">
							<label for="tfp-surface">Surface approximative <span class="tfp-field__facultatif">(facultatif)</span></label>
							<input type="text" id="tfp-surface" name="surface" inputmode="numeric" placeholder="Ex. 120 m²">
							<span class="tfp-field__hint">Un ordre de grandeur suffit : il est vérifié lors de la visite.</span>
						</div>

						<div class="tfp-field">
							<label for="tfp-code-postal">Code postal <span class="tfp-field__facultatif">(facultatif)</span></label>
							<input type="text" id="tfp-code-postal" name="code_postal" inputmode="numeric" pattern="[0-9]{5}" maxlength="5" autocomplete="postal-code" placeholder="21000">
						</div>
					</div>

					<?php
					// La maquette range Entreprise et Fréquence sur UNE rangée à deux colonnes
					// (`repeat(auto-fit, minmax(min(100%, 220px), 1fr))`), et laisse Horaires sur
					// toute la largeur. Le thème empilait les deux, ce qui allongeait l'étape 2 de
					// 92 px sans raison.
					?>
					<div class="tfp-form-row">
						<div class="tfp-field">
							<label for="tfp-entreprise">Entreprise <span class="tfp-field__facultatif">(facultatif)</span></label>
							<input type="text" id="tfp-entreprise" name="entreprise" autocomplete="organization" placeholder="Nom de votre structure">
						</div>

						<div class="tfp-field">
							<label for="tfp-frequence">Fréquence envisagée <span class="tfp-field__facultatif">(facultatif)</span></label>
							<select id="tfp-frequence" name="frequence">
								<?php foreach ( $frequences as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="tfp-field">
						<label for="tfp-creneau">Horaires souhaités <span class="tfp-field__facultatif">(facultatif)</span></label>
						<select id="tfp-creneau" name="creneau">
							<?php foreach ( $creneaux as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="tfp-field">
						<label for="tfp-message">Votre message *</label>
						<textarea id="tfp-message" name="message" required placeholder="Contraintes d'accès, attentes particulières, questions…"></textarea>
					</div>

					<div class="tfp-field tfp-field--consent">
						<label>
							<input type="checkbox" name="consentement" value="1" required>
							<span>J'accepte que ces informations soient utilisées par <?php echo esc_html( $site['brand_name'] ); ?> pour traiter ma demande de devis, conformément à la <a class="tfp-underline" href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">politique de confidentialité</a>. *</span>
						</label>
					</div>

					<?php
					/*
					 * Ordre des commandes aligné sur la maquette : l'envoi d'abord, le retour
					 * ensuite, ce dernier en bouton-lien et non en bouton plein.
					 *
					 * G26 avait inversé cet ordre pour que la tabulation suive la lecture. Le motif
					 * tombe ici : l'ordre du document EST l'ordre visuel, les deux coïncident, et
					 * `Modifier l'étape 1` offre en plus un retour en arrière juste sous le titre
					 * de l'étape. Rien n'est retiré au clavier.
					 *
					 * `data-tfp-once` : le bouton se désactive au premier envoi réel
					 * (src/js/main.js). Le formulaire de contact le portait déjà ; celui-ci ne
					 * l'avait pas, et un double clic produisait deux demandes identiques dans la
					 * boîte d'Audrey.
					 */
					?>
					<div class="tfp-form-actions">
						<button type="submit" class="tfp-btn tfp-btn--primary" data-step-submit data-tfp-once>Envoyer ma demande</button>
						<button type="button" class="tfp-btn-lien" data-step-prev>← Étape précédente</button>
					</div>

					<?php
					// La maquette n'écrit rien sous cette rangée. CLAUDE.md §8 exige en revanche la
					// réassurance près du CTA : elle est donc conservée à l'étape 2 aussi, sur sa
					// propre ligne pour ne pas replier la rangée de commandes.
					?>
					<p class="tfp-form-note">Gratuit · Sans engagement · Réponse sous 24 h</p>
				</fieldset>
			</form>
			</div>

		<?php endif; ?>
		</div>

		<aside class="tfp-quote-aside" aria-label="Contact direct et déroulé de la demande">
			<div class="tfp-quote-aside__card tfp-quote-aside__phone">
				<span class="tfp-quote-aside__phone-label">Préférez le téléphone ?</span>
				<a class="tfp-quote-aside__tel" href="tel:<?php echo esc_attr( $site['phone_href'] ); ?>"><?php echo esc_html( $site['phone'] ); ?></a>
				<span class="tfp-quote-aside__note"><?php echo esc_html( $site['manager'] ); ?>, gérante — votre interlocutrice du devis au suivi.</span>
				<?php tfp_google_rating_badge( 'quote' ); ?>
			</div>

			<div class="tfp-quote-aside__card tfp-quote-etapes">
				<p class="tfp-quote-etapes__titre">Après votre demande</p>
				<ol>
					<li><strong>Votre demande</strong><span>Deux étapes : vos locaux, puis les précisions utiles.</span></li>
					<li><strong>Réponse sous 24 h</strong><span><?php echo esc_html( $tfp_prenom_gerante ); ?> étudie votre besoin et vous recontacte.</span></li>
					<li><strong>Cahier des charges</strong><span>Tâches, fréquence, horaires et accès, établis avec vous.</span></li>
					<li><strong>Devis écrit</strong><span>Volume d'heures et tous les frais, sans engagement.</span></li>
				</ol>
			</div>

			<div class="tfp-quote-aside__card tfp-quote-tarif">
				<p class="tfp-quote-tarif__prix"><strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong> <span>tarif unique, régulier ou ponctuel</span></p>
				<p class="tfp-quote-tarif__note">Main-d'œuvre, organisation et suivi compris. Matériel et produits fournis par le client. <a class="tfp-underline" href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>">Détail des tarifs</a></p>
			</div>

			<?php
			// Témoignage repris tel quel de la maquette, marqué provisoire et exclu de toute donnée
			// structurée d'avis (CLAUDE.md §5.5).
			tfp_testimonial_card(
				array(
					'texte'  => 'Devis clair reçu le lendemain, sans surprise. Réactivité au rendez-vous.',
					'auteur' => 'Sarah B.',
					'role'   => 'Commerçante',
					'ville'  => 'Dole',
				),
				// Variante relevée sur la colonne latérale du prototype : carte glacier sans ombre,
				// étoiles et légende réduites, auteur et contexte sur une seule ligne.
				array( 'variante' => 'compacte' )
			);
			?>
		</aside>
	</div>
</section>

<section class="tfp-section tfp-faq-section tfp-quote-faq" aria-labelledby="tfp-devis-faq-titre">
	<div class="tfp-container">
		<div class="tfp-faq-tete">
			<p class="tfp-eyebrow">Avant d'envoyer</p>
			<h2 id="tfp-devis-faq-titre">Vos questions sur le devis</h2>
		</div>
		<div class="tfp-faq-liste">
			<?php foreach ( $tfp_faq_devis as $item ) : ?>
				<details class="tfp-card tfp-faq-item">
					<summary><?php echo esc_html( $item['question'] ); ?></summary>
					<p><?php echo esc_html( $item['reponse'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
