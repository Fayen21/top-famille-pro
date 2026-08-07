<?php
/**
 * Page statique « région » (/zones-intervention/bourgogne-franche-comte/) — gabarit dédié
 * (CLAUDE.md §3), page enfant de « Zones d'intervention » dans la hiérarchie WordPress.
 *
 * Contenu repris du prototype (REGION_PAGE), corrigé : tarif fictif « 27 € HT/h » retiré partout,
 * exemple de budget recalculé sur le tarif réel via tfp_home_budget_example() (même valeur que
 * l'accueil : 321 € HT/mois, pas les 333 € du prototype calculés sur le tarif fictif), avis de
 * démonstration (« Sophie M. ») retiré. Title raccourci à 58 caractères (68c dans le prototype,
 * docs/INVENTAIRE-ROUTES.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site   = tfp_site_data();
$budget = tfp_home_budget_example();

$faqs = array(
	array( 'q' => 'Intervenez-vous dans les huit départements de la région ?', 'a' => "Oui : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne et Territoire de Belfort. En revanche, nous n'intervenons pas en dehors de la {$site['address_region']}." ),
	array( 'q' => 'Où est réellement située l\'entreprise ?', 'a' => "À {$site['address_city']} ({$site['address_cp']}), commune limitrophe de Dijon, en Côte-d'Or. C'est notre unique implantation : nous n'avons pas d'agences dans les autres villes de la région." ),
	array( 'q' => 'Le tarif est-il le même dans tous les départements ?', 'a' => "Oui, la grille tarifaire est identique partout — voir la page Tarifs — en régulier comme en ponctuel. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention, et sont précisées dans le devis." ),
	array( 'q' => 'Aurai-je toujours le même intervenant ?', 'a' => "C'est ce que nous recherchons pour chaque site, car la régularité fait la qualité. Nous ne le garantissons pas : en cas d'absence ou de départ, nous cherchons un remplacement, transmettons les consignes écrites et vous informons du changement." ),
	array( 'q' => 'Faites-vous du nettoyage industriel ou hospitalier ?', 'a' => "Non. Nous intervenons sur les bureaux, accueils, locaux administratifs, parties communes, commerces et cabinets courants. Le nettoyage industriel lourd, l'agroalimentaire spécialisé, le bio-nettoyage hospitalier et le désamiantage ne font pas partie de notre offre." ),
	array( 'q' => 'Faut-il signer un engagement de durée ?', 'a' => "Le devis est gratuit et sans engagement. Pour la prestation, le volume d'heures et la fréquence peuvent être ajustés, et les conditions d'arrêt figurent au devis avant signature." ),
	array( 'q' => 'Qui contacter pour un site situé loin de Dijon ?', 'a' => "La même personne : {$site['manager']}, au {$site['phone']}. Nous n'utilisons pas de numéro local différent selon la ville, et votre dossier n'est pas transféré à un autre interlocuteur." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array( '@type' => 'Question', 'name' => $item['q'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ) );
			},
			$faqs
		),
	);
}

tfp_seo(
	array(
		'title'       => 'Nettoyage pro en Bourgogne-Franche-Comté | ' . $site['brand_name'],
		'description' => "Entretien régulier ou ponctuel de locaux professionnels dans toute la {$site['address_region']}, au même tarif partout.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => "Zones d'intervention", 'url' => home_url( '/zones-intervention/' ) ),
			array( 'label' => $site['address_region'], 'url' => null ),
		),
		'schema'      => $schema,
	)
);

get_header();
?>
<div class="tfp-container">
	<?php tfp_breadcrumb( tfp_seo()['breadcrumb'] ); ?>
</div>

<section class="tfp-hero">
	<div class="tfp-hero__content">
		<h1 class="tfp-hero__title" style="font-size:clamp(31px,4.4vw,54px)">Entreprise de nettoyage en <?php echo esc_html( $site['address_region'] ); ?></h1>
		<p class="tfp-hero__lede" style="max-width:600px">Basée à <?php echo esc_html( $site['address_city'] ); ?>, <?php echo esc_html( $site['brand_name'] ); ?> entretient bureaux, commerces, cabinets, parties communes et locations meublées sur les huit départements de la région, avec une même organisation et une même grille tarifaire partout.</p>
		<div class="tfp-hero__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( 'hero-secondary', array( 'sizes' => '(max-width: 819px) 92vw, 600px' ) ); ?>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container" style="max-width:820px">
		<p style="font-size:clamp(17px,1.7vw,21px);color:var(--color-text);line-height:1.6"><?php echo esc_html( $site['brand_name'] ); ?> est une entreprise de nettoyage régionale implantée à <?php echo esc_html( $site['address_city'] ); ?> (<?php echo esc_html( $site['address_cp'] ); ?>), près de Dijon. Elle intervient en <?php echo esc_html( $site['address_region'] ); ?> auprès des TPE, PME, commerces, professions libérales, syndics et propriétaires bailleurs, en entretien régulier ou en intervention ponctuelle, avec un devis gratuit transmis sous 24 heures et une interlocutrice unique, <?php echo esc_html( $site['manager'] ); ?>, au <?php echo esc_html( $site['phone'] ); ?>.</p>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2>Notre implantation réelle : <?php echo esc_html( $site['address_city'] ); ?>, près de Dijon</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Top-Famille Pro n'est pas une enseigne nationale déclinée en franchises. L'entreprise est installée à <?php echo esc_html( $site['address_city'] ); ?>, commune limitrophe de Dijon en Côte-d'Or, et c'est de là que tout est organisé : rendez-vous de visite, cahiers des charges, plannings, recherche de remplacement, suivi mensuel. <?php echo esc_html( $site['manager'] ); ?> est l'interlocutrice de tous les clients, quel que soit leur département.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Nous le précisons parce que le secteur du nettoyage compte beaucoup de sites annonçant une « agence » dans chaque ville. Chez nous, il n'y en a qu'une, et le numéro affiché est le même partout : <?php echo esc_html( $site['phone'] ); ?>.</p>
		</div>
		<div>
			<h2>Le territoire que nous couvrons — et celui que nous ne couvrons pas</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Nous intervenons sur les huit départements de la <?php echo esc_html( $site['address_region'] ); ?> : Côte-d'Or, Doubs, Jura, Nièvre, Haute-Saône, Saône-et-Loire, Yonne et Territoire de Belfort.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">À l'intérieur de la région, la densité de nos interventions n'est pas uniforme. L'agglomération dijonnaise est notre secteur prioritaire ; les autres pôles urbains — Besançon, Chalon-sur-Saône, Mâcon, Dole, Auxerre, Nevers, Lons-le-Saunier, Vesoul, Belfort — sont couverts avec des plannings regroupés. Les communes intermédiaires sont traitées au cas par cas, selon le trajet et la fréquence.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<h2>Les professionnels que nous accompagnons</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:24px">
			<?php
			$pros = array(
				'TPE et PME : bureaux, open-spaces, salles de réunion, locaux techniques administratifs',
				'Commerces et boutiques : surfaces de vente, réserves, sanitaires, vitrines intérieures',
				'Professions libérales et cabinets : cabinets médicaux courants, dentaires, avocats, experts-comptables',
				'Syndics et conseils syndicaux : halls, cages d\'escalier, ascenseurs, locaux poubelles',
				'Propriétaires bailleurs et gestionnaires : locations meublées, entre deux séjours',
				'Associations, agences, coworkings et structures de formation',
			);
			foreach ( $pros as $pro ) : ?>
				<div class="tfp-card"><p><?php echo esc_html( $pro ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2>Notre organisation à l'échelle régionale</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Le regroupement des interventions par secteur est étudié selon le planning : un même intervenant peut enchaîner plusieurs sites proches sur une même journée, ce qui réduit les trajets et permet de tenir une grille tarifaire unique dans toute la région. Sur les départements les plus éloignés, nous privilégions des créneaux plus longs et des fréquences stables plutôt qu'une multiplication de passages courts.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Chaque site dispose d'un cahier de liaison, sur place ou numérique, où l'intervenant note ce qui a été fait et ce qui mérite votre attention. Vous n'avez pas besoin d'être présent pour savoir ce qui s'est passé.</p>
		</div>
		<div>
			<h2>Sélection des intervenants et suivi</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Les intervenants sont recrutés par <?php echo esc_html( $site['manager'] ); ?>, en entretien individuel, avec vérification des références. Nous cherchons à confier un site au même intervenant d'une semaine sur l'autre : c'est ce qui fait la différence sur la qualité, parce qu'une personne qui connaît vos locaux repère ce qu'un remplaçant ne verra pas.</p>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">En cas d'absence, de congés ou de départ, nous cherchons une solution de remplacement et nous vous prévenons du changement. Nous ne promettons pas une continuité automatique : nous nous engageons à vous informer et à transmettre les consignes écrites au remplaçant.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:center">
		<div>
			<h2>Tarif régional unique</h2>
			<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">La grille tarifaire est identique dans les huit départements, en régulier comme en ponctuel — voir la page Tarifs pour le détail des trois montants. S'y ajoutent, selon les cas, des frais de gestion mensuels pour les contrats réguliers et des frais de mise en place au démarrage. Les éventuelles indemnités kilométriques dépendent de l'adresse des locaux, du planning et des conditions d'intervention : elles sont toujours précisées dans le devis, jamais découvertes après coup.</p>
		</div>
		<div class="tfp-card">
			<h3>Exemple · bureaux réguliers, <?php echo (int) $budget['hours']; ?> h/mois</h3>
			<p class="tfp-price-band__value" style="margin:12px 0"><strong><?php echo esc_html( tfp_format_price( $budget['monthly'] ) ); ?> HT/mois</strong></p>
			<p style="color:var(--color-text-secondary)">Premier mois : <?php echo esc_html( tfp_format_price( $budget['first_month'] ) ); ?> HT si les frais de mise en place s'appliquent. Exemple non contractuel — voir la page Tarifs.</p>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Ce que nous ne faisons pas</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">La <?php echo esc_html( $site['address_region'] ); ?> est une région industrielle, avec de la métallurgie, de l'automobile, de la plasturgie, de l'agroalimentaire, de la logistique et des établissements de santé importants. Sur ces sites, nous intervenons uniquement dans les espaces compatibles avec notre offre : bureaux administratifs, accueils, salles de réunion, sanitaires et vestiaires de bureau.</p>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Nous ne réalisons pas de nettoyage industriel lourd, ni de nettoyage de chaînes de production, ni de nettoyage agroalimentaire spécialisé, ni de bio-nettoyage hospitalier, ni de traitement chimique, ni de désamiantage, ni d'intervention en locaux à risque. Ces prestations relèvent d'entreprises spécialisées, avec des protocoles et des habilitations que nous n'avons pas.</p>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Comment démarre une collaboration</h2>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Tout commence par un appel ou une demande de devis en ligne. Nous parlons de votre adresse, de la surface, des espaces concernés, du rythme souhaité et de vos contraintes d'horaires. Une visite est organisée quand la configuration le justifie ; sinon, un échange précis et quelques photos suffisent pour établir un cahier des charges honnête.</p>
		<p style="margin-top:12px;color:var(--color-text-secondary);line-height:1.6">Le devis reste gratuit et sans engagement, et les conditions d'arrêt de la prestation y figurent également.</p>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2>Questions fréquentes</h2>
		<div style="margin-top:20px">
			<?php foreach ( $faqs as $item ) : ?>
				<details class="tfp-card" style="margin-bottom:10px">
					<summary style="font-weight:600;cursor:pointer"><?php echo esc_html( $item['q'] ); ?></summary>
					<p style="margin-top:10px;color:var(--color-text-secondary)"><?php echo esc_html( $item['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Demander un devis</h2>
		<p>Gratuit · Sans engagement · Réponse sous 24 h</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
