<?php
/**
 * 9. Conseils & repères — les trois cartes pointent chacune vers son article individuel,
 * jamais vers l'index /conseils/ (correction imposée par CLAUDE.md §9 : le prototype liait
 * les trois cartes vers /conseils/ au lieu de l'article correspondant).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$articles = array(
	array(
		'cat'     => 'Bureaux',
		'title'   => 'À quelle fréquence faire nettoyer ses bureaux ?',
		'excerpt' => 'Quotidien, plusieurs fois par semaine ou hebdomadaire : comment choisir selon vos effectifs et votre activité.',
		'url'     => home_url( '/conseils/frequence-bureaux/' ),
		'image'   => 'article-1',
	),
	array(
		'cat'     => 'Tarifs',
		'title'   => 'Combien coûte le nettoyage de bureaux ?',
		'excerpt' => "Tarif horaire, volume d'heures, frais de gestion : comprendre ce qui compose un budget de nettoyage de bureaux.",
		'url'     => home_url( '/conseils/cout-nettoyage-bureaux/' ),
		'image'   => 'article-2',
	),
	array(
		'cat'     => 'Organisation',
		'title'   => 'Comment rédiger un cahier des charges de nettoyage ?',
		'excerpt' => 'Espaces, tâches, fréquences, accès : la méthode pour cadrer une prestation de nettoyage professionnel dès le départ.',
		'url'     => home_url( '/conseils/cahier-des-charges-nettoyage/' ),
		'image'   => 'article-3',
	),
);
?>
<section class="tfp-section tfp-section--alt">
	<div class="tfp-container">
		<div class="tfp-flex tfp-flex--between" style="margin-bottom:28px">
			<h2 style="font-size:clamp(26px,3.4vw,40px)">Conseils &amp; repères</h2>
			<a href="<?php echo esc_url( home_url( '/conseils/' ) ); ?>" class="tfp-link-arrow">Tous les conseils →</a>
		</div>
		<div class="tfp-grid tfp-grid--autofit-lg">
			<?php foreach ( $articles as $article ) : ?>
				<a class="tfp-article-card" href="<?php echo esc_url( $article['url'] ); ?>">
					<?php tfp_picture( $article['image'], array( 'sizes' => '(max-width: 819px) 92vw, 400px' ) ); ?>
					<span class="tfp-article-card__body">
						<span class="tfp-article-card__cat"><?php echo esc_html( $article['cat'] ); ?></span>
						<span class="tfp-article-card__title"><?php echo esc_html( $article['title'] ); ?></span>
						<span class="tfp-article-card__excerpt"><?php echo esc_html( $article['excerpt'] ); ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
