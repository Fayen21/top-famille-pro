<?php
/**
 * 15. Bloc de la gérante — bloc 11 du prototype Claude Design.
 *
 * Décision du 14 octobre 2026 : le bloc présente Audrey Brançon comme GÉRANTE de Top-Famille Pro —
 * titre, texte et signature — et le portrait est réduit de 30 % en dimensions linéaires par rapport
 * au rendu précédent (420 × 525 → 294 × 368 à 1440 px). La réduction porte sur la colonne réelle et
 * les attributs de l'image, pas sur un `transform: scale()` qui aurait conservé l'ancien espace. Le
 * rôle d'interlocutrice reste évoqué comme une qualité de service, sans se substituer au rôle de
 * direction.
 *
 * Ne contient plus les quatre points « Pourquoi Top-Famille Pro » ni la carte témoignage : ils
 * ont retrouvé leur section propre (template-parts/home/why.php) le 9 août 2026, comme dans la
 * maquette.
 *
 * La pastille « ★★★★★ 5,0/5 Google » superposée au portrait n'est rendue que si une note est
 * configurée ET son URL de fiche vérifiée (CLAUDE.md §5.5, consigne du 18 août 2026) ; elle
 * n'alimente aucune donnée structurée.
 *
 * La citation attribuée à Audrey est reprise telle quelle de la maquette (consigne du 10 août
 * 2026). Elle est marquée `data-tfp-provisional` et reste à faire valider par l'intéressée : c'est
 * la seule phrase du site qui fasse parler une personne réelle. Pas de chantier d'authentification
 * dans cette passe (brief du 14 octobre §8).
 *
 * Portrait : visuel d'illustration temporaire (même photo que le prototype) tant que la vraie photo
 * n'est pas fournie, avec un alt honnête et une mention visible — cf. tfp_audrey_photo_is_real(),
 * includes/customizer.php. La photo existante et sa mention sont conservées ; ce n'est pas un
 * nouveau bloqueur de validation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site       = tfp_site_data();
$first_name = explode( ' ', $site['manager'] )[0];

/*
 * Décision du 13 novembre 2026 : la gérante est présentée SANS photo et SANS citation.
 *  - plus de portrait de banque d'images ni de mention « photo provisoire » : un monogramme, remplacé
 *    de lui-même par la vraie photo le jour où elle est saisie (tfp_gerante_visuel()) ;
 *  - plus de phrase mise dans la bouche d'Audrey : la citation de la maquette attendait sa
 *    validation (CLAUDE.md §5.5). Le bloc dit à la place ce qu'elle FAIT, en trois temps, avec des
 *    faits déjà présents ailleurs sur le site (devis étudié par elle, réponse sous 24 h, visite,
 *    cahier des charges, suivi direct).
 */
$roles = array(
	array( 'Votre devis', $first_name . ' étudie personnellement chaque demande et vous répond sous 24 h.' ),
	array( 'Votre cahier des charges', 'Il est établi avec vous, à partir de la visite de vos locaux.' ),
	array( 'Votre suivi', 'Elle reste joignable directement pour ajuster un passage ou traiter une remarque.' ),
);
?>
<section class="tfp-section--alt tfp-section" aria-labelledby="tfp-gerante-titre">
	<div class="tfp-container">
		<div class="tfp-gerante-carte">
			<div class="tfp-gerante-carte__identite">
				<?php tfp_gerante_visuel( 'tfp-monogramme--xl' ); ?>
				<div>
					<p class="tfp-eyebrow">Votre interlocutrice</p>
					<h2 id="tfp-gerante-titre" class="tfp-gerante__titre"><?php echo esc_html( $site['manager'] ); ?>, gérante de <?php echo esc_html( $site['brand_name'] ); ?></h2>
					<p class="tfp-gerante__lede">
						<?php echo esc_html( $first_name ); ?> supervise l'organisation des prestations et le suivi des clients, depuis <?php echo esc_html( $site['address_city'] ); ?>. Vous savez à qui parler, du premier échange au suivi des passages.
					</p>
					<div class="tfp-action-row tfp-gerante__actions">
						<?php
						tfp_button(
							array(
								'label'   => 'Échanger sur mes locaux',
								'href'    => home_url( '/contact/' ),
								'variant' => 'primary',
							)
						);
						tfp_bouton_appel( array( 'variant' => 'secondary', 'numero' => true ) );
						?>
					</div>
				</div>
			</div>
			<ol class="tfp-gerante-carte__roles">
				<?php foreach ( $roles as $i => $role ) : ?>
					<li>
						<span class="tfp-gerante-carte__rang" aria-hidden="true"><?php echo (int) $i + 1; ?></span>
						<div>
							<strong><?php echo esc_html( $role[0] ); ?></strong>
							<span><?php echo esc_html( $role[1] ); ?></span>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
