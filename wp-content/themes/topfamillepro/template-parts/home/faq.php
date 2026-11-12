<?php
/**
 * Questions fréquentes de l'accueil (13 novembre 2026) — six réponses courtes, avant les conseils.
 * <details> natifs : ouverts au clavier et sans JavaScript, contenu présent dans le HTML.
 * Le FAQPage correspondant est déclaré par front-page.php à partir de la même liste.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = tfp_faq_accueil();
?>
<section class="tfp-section tfp-home-faq" aria-labelledby="tfp-home-faq-titre">
	<div class="tfp-container tfp-home-faq__inner">
		<div class="tfp-home-faq__tete">
			<p class="tfp-eyebrow">Questions fréquentes</p>
			<h2 id="tfp-home-faq-titre">Vos questions, nos réponses</h2>
			<p class="tfp-home-faq__lede">L'essentiel avant de demander un devis. Pour le détail, la page <a class="tfp-underline" href="<?php echo esc_url( home_url( '/nettoyage-professionnel/' ) ); ?>#s-17">nettoyage professionnel</a> répond à une douzaine d'autres questions.</p>
		</div>
		<div class="tfp-home-faq__liste">
			<?php foreach ( $faqs as $item ) : ?>
				<details class="tfp-card tfp-faq-item">
					<summary><?php echo esc_html( $item['q'] ); ?></summary>
					<p><?php echo esc_html( $item['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
