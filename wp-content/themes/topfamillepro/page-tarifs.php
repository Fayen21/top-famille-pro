<?php
/**
 * Page statique « Tarifs » (/tarifs/) — gabarit dédié (CLAUDE.md §3).
 *
 * Reproduit les 13 blocs de la route `#/nos-tarifs` de la maquette Claude Design, dans le même
 * ordre et avec la même composition. Seuls les montants font exception au copiage littéral : ils
 * ne sont jamais écrits en dur mais recalculés depuis includes/site-options.php, seul point
 * d'entrée du tarif — un changement de prix n'a ainsi qu'un endroit à modifier, et les exemples
 * de budget restent cohérents entre eux par construction.
 *
 * Tarif réel unique (PROJECT_INPUTS.md §5), identique dans toute la région (CLAUDE.md §5.3) et
 * quel que soit le régime (régulier ou ponctuel) ou le type de local.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$prenom = explode( ' ', $site['manager'] )[0];

$prix       = tfp_format_price( $site['price_unique'] );
$gestion    = tfp_format_price( $site['price_gestion'] );
$setup      = tfp_format_price( $site['price_setup'] );
$km         = $site['price_km_display'];
$majoration = (int) $site['price_majoration_pct'];

/* Bloc « Le détail de nos frais » : chaque ligne porte son intitulé, sa précision et son montant. */
$frais = array(
	array( 'Tarif horaire', 'Régulier ou ponctuel', $prix . ' HT/h' ),
	array( 'Frais de gestion', 'Planning, administratif, suivi', $gestion . ' HT/mois' ),
	array( 'Frais de mise en place', 'Une fois, au démarrage', $setup . ' HT' ),
	array( 'Majoration horaire', 'Dimanche, jour férié ou nuit', '+ ' . $majoration . ' %' ),
	array( 'Indemnités kilométriques', "Lorsqu'elles s'appliquent", $km . ' HT/km' ),
);

$inclus = array(
	"Main-d'œuvre de l'intervenant sélectionné",
	'Organisation du planning & administratif',
	'Suivi par une interlocutrice dédiée',
	'Cahier de liaison laissé sur place',
	"Recherche de remplacement en cas d'absence",
);

$fourni_client = array(
	"Produits d'entretien (généralement)",
	'Matériel et consommables',
	'Accès aux locaux (clés, badge, code)',
	'Linge, pour les meublés et hébergements',
);

$facteurs = array(
	array( 'Surface', 'Superficie et nombre de pièces' ),
	array( 'Fréquence', 'Nombre de passages par semaine' ),
	array( 'Type de locaux', 'Bureaux, commerce, cabinet, meublé' ),
	array( "Niveau d'exigence", 'Standard ou renforcé (hygiène)' ),
);

/* Trois exemples de budgets — les libellés viennent de la maquette, les montants du calcul réel. */
$exemples_labels = array(
	array( 'Petits bureaux ou cabinet', '8 h / mois · 1 passage hebdo' ),
	array( 'Bureaux réguliers', '12 h / mois · plusieurs passages' ),
	array( 'Besoin plus important', '20 h / mois · passages fréquents' ),
);
$exemples = tfp_budget_examples_table();

$comparatif = array(
	array( 'Petit cabinet / bureau', '1 passage / semaine', 8 ),
	array( 'Bureaux de taille moyenne', '2-3 passages / semaine', 12 ),
	array( 'Plateau tertiaire / commerce actif', 'Quotidien', 20 ),
);

$faqs = array(
	array(
		'q' => 'Le tarif est-il le même en régulier et en ponctuel ?',
		'a' => "Oui, la base est de {$prix} HT/h dans les deux cas. Ce qui varie, c'est le volume d'heures et, pour le régulier, les frais de gestion mensuels.",
	),
	array(
		'q' => 'Comment est calculé mon premier mois ?',
		'a' => "Il reprend le volume d'heures convenu, les frais de gestion et, le cas échéant, les {$setup} HT de frais de mise en place. Les conditions exactes d'application figurent sur le devis.",
	),
	array(
		'q' => 'Y a-t-il des frais de déplacement ?',
		'a' => "Selon la distance depuis {$site['address_city']}, des indemnités de {$km} HT/km peuvent s'appliquer, toujours indiquées à l'avance.",
	),
	array(
		'q' => 'Quelle différence entre le tarif horaire et le volume horaire ?',
		'a' => "Le tarif horaire ({$prix} HT/h) est fixe. Le volume horaire — le nombre d'heures nécessaires chaque mois — varie selon la surface, la fréquence et le type de locaux : c'est lui qui détermine le budget final.",
	),
	array(
		'q' => 'Pourquoi ne proposez-vous pas de simulateur en ligne ?',
		'a' => "Un simulateur automatique ne peut pas tenir compte de l'état réel de vos locaux ni de vos contraintes spécifiques. Nous préférons un échange direct, qui aboutit à un devis précis sous 24 heures.",
	),
);

/* Bloc « Avant de demander votre devis » : quatre renvois, titre + précision. */
$avant_devis = array(
	array( home_url( '/prestations/' ), 'Choisir votre prestation', 'Six types de locaux, six organisations différentes.' ),
	array( home_url( '/notre-fonctionnement/' ), 'Comment se construit le devis', 'Analyse, cahier des charges, réponse sous 24 h.' ),
	array( home_url( '/zones-intervention/bourgogne-franche-comte/' ), 'Vérifier votre secteur', 'Huit départements, indemnités précisées au devis.' ),
	array( home_url( '/conseils/cout-nettoyage-bureaux/' ), "Combien coûte l'entretien de bureaux", 'Article : méthode de calcul et repères chiffrés.' ),
);

$schema = array(
	array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/tarifs/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array( '@type' => 'Question', 'name' => $item['q'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ) );
			},
			$faqs
		),
	),
);

tfp_seo(
	array(
		'title'       => 'Tarifs de nettoyage professionnel | ' . $site['brand_name'],
		'description' => "Tarif réel du nettoyage professionnel : {$prix} HT/h, tarif unique en régulier comme en ponctuel, identique dans toute la {$site['address_region']}. Frais de gestion, mise en place et exemples de budgets.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Nos tarifs', 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-hero__eyebrow">
		<a class="tfp-region-badge" href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>"><?php echo esc_html( $site['address_region'] ); ?></a>
		<?php tfp_google_rating_badge( 'inline' ); ?>
	</div>
	<h1>Nos tarifs de nettoyage professionnel</h1>
	<p class="tfp-section__lede">Nous affichons nos tarifs clairement, avant même le devis. Un tarif horaire unique de <?php echo esc_html( $prix ); ?> HT/h, des frais annoncés à l'avance, et des exemples chiffrés. La transparence est la base d'une relation de confiance.</p>
</section>

<?php
/*
 * Bandeau tarifaire — DEUX cartes, pas une.
 *
 * La maquette pose une rangée souple de deux cartes : à gauche l'offre elle-même sur fond marine
 * (`flex: 2 1 380px`), avec le prix et le bouton côte à côte ; à droite une carte blanche
 * (`flex: 1 1 220px`) qui porte le délai de réponse. Le thème avait fondu les deux en un seul
 * encadré turquoise pâle d'une colonne, dont le contenu s'empilait sur 645 px de large jusqu'à
 * 820 px de fenêtre. Résultat : la promesse de prix et l'appel à l'action se lisaient l'un sous
 * l'autre au lieu de se répondre, et la bande mesurait 83 px de trop à 768 px.
 *
 * Les deux bases se replient d'elles-mêmes — 380 + 220 + 16 ne tiennent plus sous 616 px de
 * largeur utile — sans la requête média à 820 px, dont le seuil ne correspondait à aucun relevé.
 */
?>
<section class="tfp-section--tight" style="--tfp-bande-haut:0px;--tfp-bande-bas:clamp(36px, 5vw, 60px)">
	<div class="tfp-container tfp-price-headline" style="--container-max:1100px">
		<div class="tfp-price-headline__offer">
			<div class="tfp-price-headline__main">
				<div class="tfp-price-headline__label">Tarif horaire de base</div>
				<div class="tfp-price-headline__value"><?php echo esc_html( $prix ); ?> <span>HT/h</span></div>
				<div class="tfp-price-headline__note">Identique en régulier et en ponctuel.</div>
			</div>
			<?php tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) ); ?>
		</div>
		<div class="tfp-price-headline__promise">
			<div class="tfp-price-headline__delay">Devis sous 24 h</div>
			<p>Gratuit, personnalisé et sans engagement. Aucun simulateur : une étude adaptée à vos locaux.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<p class="tfp-prose">Le nettoyage professionnel est facturé <?php echo esc_html( $prix ); ?> HT de l'heure, en régulier comme en ponctuel. Le budget dépend surtout du volume d'heures nécessaire, défini avec vous selon la surface, le type de locaux et la fréquence. Les frais éventuels (gestion, mise en place, majorations, déplacements) sont toujours indiqués à l'avance sur le devis.</p>
	</div>
</section>

<section class="tfp-container tfp-section--tight">
	<p class="tfp-maillage">Ce tarif s'applique au périmètre décrit dans notre page <a href="<?php echo esc_url( home_url( '/nettoyage-professionnel/' ) ); ?>">nettoyage professionnel</a> : ce qui est fait à chaque passage, ce qui ne l'est pas, et ce qui se chiffre à part. Le volume d'heures, lui, se décide pendant la visite.</p>
</section>

<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Le détail de nos frais</h2>
		<ul class="tfp-fee-list">
			<?php foreach ( $frais as $ligne ) : ?>
				<li>
					<span class="tfp-fee-list__label"><?php echo esc_html( $ligne[0] ); ?></span>
					<span class="tfp-fee-list__hint"><?php echo esc_html( $ligne[1] ); ?></span>
					<span class="tfp-fee-list__amount"><?php echo esc_html( $ligne[2] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="tfp-section--tight">
	<?php
	/*
	 * Règle DÉCLARÉE par le prototype pour cette bande, et non le composant `.tfp-two-col` :
	 *
	 *   max-width: 900px; padding: 0 clamp(18px, 4vw, 40px); display: grid;
	 *   grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr)); gap: 16px;
	 *
	 * `.tfp-two-col` posait une base de 380 px et un écart de clamp(30px, 4vw, 56px) : à 768 px,
	 * 2 × 380 + 30,72 = 790,72 pour 707 disponibles, la bande se repliait sur une colonne de 707 px
	 * là où la maquette en tient deux de 345. Ce composant n'est pas corrigeable globalement — le
	 * prototype déclare une base différente à chacune de ses huit occurrences (440/340, 340/340,
	 * 320/320, 420/320, 260/440, 300/360, 480/380) : c'est l'instance qu'on corrige.
	 *
	 * Les quatre propriétés se reproduisent avec les composants existants : `--narrow` borne à
	 * 900 px, `.tfp-grid` pose l'écart de 16 px, `--autofit` le repli intrinsèque, et la variable
	 * porte la base relevée.
	 */
	?>
	<div class="tfp-container tfp-container--narrow tfp-grid tfp-grid--autofit" style="--tfp-colonne:260px">
		<div class="tfp-card">
			<h3>Ce qui est inclus</h3>
			<ul class="tfp-list-plain tfp-list-plain--nue">
				<?php foreach ( $inclus as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="tfp-card">
			<h3>Fourni par le client</h3>
			<ul class="tfp-list-plain tfp-list-plain--nue">
				<?php foreach ( $fourni_client as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<?php
	/*
	 * « Ce qui influence le volume d'heures » — géométrie RELEVÉE sur la maquette (G22) :
	 * conteneur borné à 820 px, grille `repeat(auto-fit, minmax(min(100%, 200px), 1fr))` avec un
	 * écart de 12 px — quatre cartes rangées 3 + 1, jamais quatre de front — et des cartes de
	 * 16/18 px de rembourrage, rayon 12, fond atténué, texte 15 px. Le thème posait l'utilitaire
	 * générique (base 220, écart 16, cartes 22 px de rembourrage) dans le conteneur de 1180 px :
	 * les quatre cartes tenaient sur UNE rangée de 283 px là où la maquette en met trois de 265.
	 */
	?>
	<div class="tfp-container" style="--container-max:820px">
		<h2>Ce qui influence le volume d'heures</h2>
		<div class="tfp-grid tfp-grid--autofit tfp-facteurs" style="margin-top:18px; --tfp-colonne:200px; gap:12px">
			<?php foreach ( $facteurs as $facteur ) : ?>
				<div class="tfp-card--flat tfp-facteurs__carte">
					<strong><?php echo esc_html( $facteur[0] ); ?></strong>
					<p><?php echo esc_html( $facteur[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section--tight">
	<div class="tfp-container">
		<h2>Trois exemples de budgets</h2>
		<p class="tfp-section__lede">Calculés au tarif de <?php echo esc_html( $prix ); ?> HT/h + <?php echo esc_html( $gestion ); ?> HT de gestion, plus <?php echo esc_html( $setup ); ?> HT de frais de mise en place.</p>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:24px" aria-describedby="tfp-tarifs-conditions">
			<?php foreach ( $exemples as $i => $row ) : ?>
				<div class="tfp-budget-card">
					<span class="tfp-budget-card__title"><?php echo esc_html( $exemples_labels[ $i ][0] ); ?></span>
					<span class="tfp-budget-card__meta"><?php echo esc_html( $exemples_labels[ $i ][1] ); ?></span>
					<span class="tfp-budget-card__value"><?php echo esc_html( tfp_format_price( $row['monthly'] ) ); ?> <span>HT/mois</span></span>
					<ul class="tfp-budget-card__detail">
						<li><?php echo (int) $row['hours']; ?> h × <?php echo esc_html( $prix ); ?> HT<span><?php echo esc_html( tfp_format_price( $row['hours'] * $site['price_unique'] ) ); ?> HT</span></li>
						<li>Frais de gestion<span><?php echo esc_html( $gestion ); ?> HT</span></li>
						<li>Premier mois, avec mise en place<span><?php echo esc_html( tfp_format_price( $row['first_month'] ) ); ?> HT</span></li>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		/*
		 * Condition unique pour toute la bande. Elle figurait dans le chapeau ET dans les trois
		 * intitulés de ligne : quatre fois la même réserve dans un seul bloc, ce qui la rendait
		 * décorative au lieu d'informative. Elle est ici, une fois, et rattachée au tableau par
		 * `aria-describedby` pour être annoncée avec lui — la retirer visuellement l'aurait
		 * supprimée pour tout le monde, la répéter la rendait illisible pour tout le monde.
		 */
		?>
		<p class="tfp-note-inline" id="tfp-tarifs-conditions">Ces frais et majorations s'appliquent uniquement lorsqu'ils sont prévus et indiqués au devis.</p>
		<p class="tfp-note-inline">Exemple illustratif et non contractuel. Le volume horaire est défini selon les locaux et le cahier des charges.</p>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container">
		<h2>Comparer plusieurs besoins en un coup d'œil</h2>
		<p class="tfp-section__lede">Le tarif horaire ne varie pas : c'est le volume d'heures qui distingue un petit local d'un plateau de bureaux. Voici un repère pour situer votre besoin.</p>
		<div class="tfp-table-scroll">
			<table class="tfp-table">
				<thead>
					<tr>
						<th scope="col">Type de local</th>
						<th scope="col">Fréquence typique</th>
						<th scope="col">Volume indicatif</th>
						<th scope="col">Budget mensuel indicatif</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $comparatif as $ligne ) : ?>
						<tr>
							<td><?php echo esc_html( $ligne[0] ); ?></td>
							<td><?php echo esc_html( $ligne[1] ); ?></td>
							<td><?php echo (int) $ligne[2]; ?> h/mois</td>
							<td><?php echo esc_html( tfp_format_price( $ligne[2] * $site['price_unique'] + $site['price_gestion'] ) ); ?> HT/mois</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<p class="tfp-note-inline">Repères non contractuels. Le volume réel dépend de la surface, du niveau d'exigence et du cahier des charges retenu avec vous.</p>
	</div>
</section>

<section class="tfp-section--turquoise tfp-section--tight">
	<div class="tfp-container tfp-container--narrow">
		<?php
		/*
		 * La maquette pose cette citation NUE et centrée : blockquote sans fond, sans filet, sans
		 * rayon — aucun ancêtre encadré jusqu'au corps de page (sonde G22, 1440 px). La carte
		 * témoignage commune (820×258, fond blanc, rayon 18) comptait une carte absente du
		 * prototype. Le marquage provisoire est porté par le composant, quelle que soit la forme.
		 */
		?>
		<div class="tfp-testimonial--plain tfp-testimonial--centre">
			<?php
			tfp_testimonial_card(
				array(
					'texte'  => "Un devis clair, sans surprise, et le même tarif horaire annoncé dès le départ. C'est ce qui nous a décidés.",
					'auteur' => 'Olivier D.',
					'role'   => 'Gérant',
					'ville'  => 'Besançon',
				)
			);
			?>
		</div>
		<h2 style="margin-top:32px">Questions sur les tarifs</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faqs as $item ) : ?>
				<details class="tfp-card tfp-faq-item">
					<summary><?php echo esc_html( $item['q'] ); ?></summary>
					<p><?php echo esc_html( $item['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/*
 * Base de colonne DÉCLARÉE à 230 px et écart de 12 px : avec les 220/16 de l'utilitaire générique,
 * les quatre renvois se rangeaient sur trois colonnes puis une orpheline (3 × 220 + 32 = 692 tient
 * dans 707 px de largeur utile) là où la maquette en pose deux de 347. Rembourrage de bande relevé :
 * clamp(40px, 5vw, 72px), haut et bas.
 */
?>
<section class="tfp-section--tight" style="--tfp-bande-haut:clamp(40px, 5vw, 72px);--tfp-bande-bas:clamp(40px, 5vw, 72px)">
	<div class="tfp-container">
		<h2>Avant de demander votre devis</h2>
		<p class="tfp-section__lede">Le tarif est le même partout en région. Ce qui change, c'est le volume d'heures : ces pages vous aident à le cadrer avant l'échange avec <?php echo esc_html( $prenom ); ?>.</p>
		<div class="tfp-grid tfp-grid--autofit" style="--tfp-colonne:230px;gap:12px;margin-top:20px">
			<?php foreach ( $avant_devis as $lien ) : ?>
				<a class="tfp-card tfp-card--link" href="<?php echo esc_url( $lien[0] ); ?>">
					<h3><?php echo esc_html( $lien[1] ); ?></h3>
					<p><?php echo esc_html( $lien[2] ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Recevez un devis clair et chiffré</h2>
		<p>Sous 24 heures, sans engagement.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ ' . $site['phone'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
