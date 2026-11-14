<?php
/**
 * 5. Fonctionnement — « Votre prestation, en 5 étapes ».
 *
 * Refait le 14 octobre 2026 sur décision d'Emmanuel. L'ancien composant rendait numéro, titre et
 * paragraphe comme TROIS COLONNES serrées : `.tfp-step` est partagé avec les étapes des pages
 * statiques (04-components.css), où il est un `display: flex` à deux enfants — pastille puis corps.
 * La feuille de l'accueil (05-home.css) redéfinissait le fond et le rembourrage de `.tfp-step` mais
 * pas son `display` : le flex survivait, et les trois enfants directs de la carte de l'accueil se
 * partageaient 190 px de large. Les mots se coupaient (« Intervenant » tronqué), les descriptions
 * débordaient, et de grandes zones vides restaient sous les textes.
 *
 * Le composant de l'accueil porte désormais son propre nom — `.tfp-etape` — et une liste ordonnée
 * sémantique : cinq étapes numérotées sont une séquence, pas cinq blocs. Les pages statiques
 * gardent `.tfp-step` intact.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$etapes = array(
	array( 'titre' => 'Prise de contact', 'desc' => 'Vous présentez vos locaux et vos besoins.' ),
	array( 'titre' => 'Étude de vos besoins', 'desc' => "Nous définissons le périmètre, les horaires et le volume d'heures." ),
	array( 'titre' => 'Devis gratuit sous 24 h', 'desc' => 'Vous recevez une proposition claire et sans engagement.' ),
	array( 'titre' => 'Mise en place', 'desc' => "Nous organisons l'intervention, le planning et les accès." ),
	array( 'titre' => 'Suivi de la prestation', 'desc' => "Nous suivons les passages et ajustons l'organisation si nécessaire." ),
);
?>
<section class="tfp-section tfp-section--alt" aria-labelledby="tfp-etapes-titre">
	<div class="tfp-container">
		<div class="tfp-etapes__head">
			<h2 id="tfp-etapes-titre">Votre prestation, en 5 étapes</h2>
			<a href="<?php echo esc_url( home_url( '/notre-fonctionnement/' ) ); ?>" class="tfp-link-arrow">En détail →</a>
		</div>
		<ol class="tfp-etapes">
			<?php foreach ( $etapes as $i => $etape ) : ?>
				<li class="tfp-etape">
					<span class="tfp-etape__num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="tfp-etape__titre"><?php echo esc_html( $etape['titre'] ); ?></h3>
					<p class="tfp-etape__desc"><?php echo esc_html( $etape['desc'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
