<?php
/**
 * Page pilier « Nettoyage professionnel » (/nettoyage-professionnel/) — gabarit dédié à cette
 * page statique unique (CLAUDE.md §3 : structure propre à chaque page statique, sans CPT).
 * Sélectionné automatiquement par WordPress via la hiérarchie de gabarits (page-{slug}.php) pour
 * la Page du même slug — voir bin/seed-phase2-content.php pour sa création.
 *
 * Contenu repris du prototype (section « nettoyage professionnel » / pilier), corrigé selon
 * CLAUDE.md §9 : tarif réécrit avec la vraie grille (plus de « 27 € HT/h » unique), avis de
 * démonstration retiré (remplacé par le même mécanisme conditionnel que l'accueil), aucune
 * fausse note Google.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site        = tfp_site_data();
$reassurance = tfp_reassurance_data();

$services_nav = array(
	array( 'label' => 'Nettoyage de bureaux', 'tease' => 'Open-spaces, salles de réunion, accueil', 'url' => home_url( '/prestations/bureaux/' ) ),
	array( 'label' => 'Nettoyage de commerces', 'tease' => 'Surfaces de vente, vitrines, sanitaires clients', 'url' => home_url( '/prestations/commerces/' ) ),
	array( 'label' => 'Cabinets & professions libérales', 'tease' => 'Santé, droit, conseil, salles d\'attente', 'url' => home_url( '/prestations/cabinets/' ) ),
	array( 'label' => 'Copropriétés & parties communes', 'tease' => 'Halls, cages d\'escalier, locaux communs', 'url' => home_url( '/prestations/coproprietes/' ) ),
	array( 'label' => 'Locations meublées & hébergements', 'tease' => 'Remise en état entre deux occupants', 'url' => home_url( '/prestations/meubles/' ) ),
	array( 'label' => 'Nettoyage ponctuel & remise en état', 'tease' => 'Après travaux, grand nettoyage, fin de bail', 'url' => home_url( '/prestations/ponctuel/' ) ),
);

$articles_nav = array(
	array( 'label' => 'À quelle fréquence faire nettoyer ses bureaux ?', 'url' => home_url( '/conseils/frequence-bureaux/' ) ),
	array( 'label' => 'Combien coûte le nettoyage de bureaux ?', 'url' => home_url( '/conseils/cout-nettoyage-bureaux/' ) ),
	array( 'label' => 'Comment rédiger un cahier des charges de nettoyage ?', 'url' => home_url( '/conseils/cahier-des-charges-nettoyage/' ) ),
);

$faqs = array(
	array( 'q' => 'Intervenez-vous dans toute la Bourgogne-Franche-Comté ?', 'a' => "Oui, depuis Saint-Apollinaire sur les huit départements de la région. Selon la distance, des indemnités kilométriques de 0,35 € HT/km peuvent s'appliquer et sont indiquées au devis." ),
	array( 'q' => 'Faut-il fournir les produits et le matériel ?', 'a' => 'Les produits et le matériel sont fournis par le client. Les modalités sont précisées au devis et dans le cahier des charges.' ),
	array( 'q' => 'Le devis est-il payant ou engageant ?', 'a' => 'Le devis est gratuit, transmis sous 24 heures, et sans engagement de votre part.' ),
	array( 'q' => "Que se passe-t-il si l'intervenant est absent ?", 'a' => 'Nous recherchons activement une solution de remplacement pour maintenir la continuité et vous tenons informé de l\'organisation retenue.' ),
	array( 'q' => 'Comment est rédigé le cahier des charges ?', 'a' => 'Il est établi avec vous avant la première intervention : espaces concernés, tâches attendues, fréquence, horaires et points de vigilance propres à vos locaux. Il peut être ajusté à tout moment.' ),
	array( 'q' => 'Le même intervenant vient-il à chaque passage ?', 'a' => "C'est l'organisation que nous recherchons : un intervenant habituel qui connaît vos locaux et vos consignes. Cette continuité est privilégiée autant que possible, sans constituer une garantie absolue en cas d'absence ou de changement de disponibilité." ),
	array( 'q' => 'Vaut-il mieux passer par un prestataire ou embaucher un agent d\'entretien ?', 'a' => "Le recrutement direct peut se justifier à partir d'un volume horaire important et d'un besoin de présence continue. En dessous, le coût réel d'une embauche — recrutement, paie, congés, remplacement, matériel, encadrement — dépasse souvent l'écart de tarif horaire. Si votre besoin est une présence permanente, nous vous le dirons plutôt que de forcer un devis." ),
	array( 'q' => 'Comment modifier la prestation en cours de contrat ?', 'a' => "Par un simple échange avec {$site['manager']}. Un ajustement de périmètre à volume d'heures constant se met en place rapidement ; un changement de volume horaire donne lieu à un devis actualisé, soumis à votre accord avant application. Il n'y a pas d'engagement de durée." ),
	array( 'q' => 'Quelle fréquence faut-il prévoir pour des bureaux ?', 'a' => "Elle dépend surtout de l'effectif réellement présent, du nombre de sanitaires et de la présence d'une cuisine. Deux à trois passages par semaine constituent le rythme le plus courant entre dix et trente postes ; au-delà, les sanitaires et la cuisine justifient généralement un passage quotidien." ),
	array( 'q' => 'Pouvez-vous intervenir le dimanche ou la nuit ?', 'a' => "Oui, sur demande, lorsque votre activité l'exige. Ces créneaux font l'objet d'une majoration de 10 % du tarif horaire, indiquée à l'avance sur le devis et jamais découverte après coup." ),
);

$schema = array();
if ( ! empty( $faqs ) ) {
	$schema[] = array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( home_url( '/nettoyage-professionnel/' ) ) . '#faq',
		'mainEntity' => array_map(
			function ( $item ) {
				return array(
					'@type'          => 'Question',
					'name'           => $item['q'],
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ),
				);
			},
			$faqs
		),
	);
}

tfp_seo(
	array(
		'title'       => 'Nettoyage professionnel de bureaux et de locaux | ' . $site['brand_name'],
		'description' => "Le nettoyage professionnel expliqué : périmètre, organisation, tarif, engagements et limites. Devis gratuit sous 24 h en {$site['address_region']}.",
		'type'        => 'website',
		'robots'      => 'index,follow',
		'breadcrumb'  => array(
			array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
			array( 'label' => 'Nettoyage professionnel', 'url' => null ),
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
		<h1 class="tfp-hero__title" style="font-size:clamp(31px,4.4vw,54px)">Le nettoyage professionnel de vos locaux en <?php echo esc_html( $site['address_region'] ); ?></h1>
		<p class="tfp-hero__lede" style="max-width:600px"><?php echo esc_html( $site['brand_name'] ); ?> organise l'entretien régulier ou ponctuel des bureaux, commerces, cabinets, copropriétés et locations meublées. Des intervenants sélectionnés, une interlocutrice dédiée et un tarif indiqué avant le devis.</p>
		<div class="tfp-hero__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'primary' ) );
			tfp_button( array( 'label' => '☎ Appeler ' . $site['manager'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'secondary' ) );
			?>
		</div>
	</div>
	<div class="tfp-hero__media">
		<div class="tfp-hero__media-main">
			<?php tfp_picture( 'service-bureaux', array( 'sizes' => '(max-width: 819px) 92vw, 600px' ) ); ?>
		</div>
	</div>
</section>

<section class="tfp-container tfp-section--tight">
	<div class="tfp-price-band">
		<span class="tfp-price-band__value">
			<strong><?php echo esc_html( $site['price_unique_display'] ); ?> HT/h</strong>
			<span>tarif unique, indiqué avant le devis</span>
		</span>
		<?php tfp_check_item( 'Devis gratuit sous 24 h' ); ?>
		<?php tfp_check_item( 'Intervention régulière ou ponctuelle' ); ?>
		<?php tfp_check_item( "Conditions d'arrêt précisées au devis" ); ?>
		<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-btn tfp-btn--secondary tfp-btn--sm" style="margin-left:auto">Voir les tarifs →</a>
	</div>
</section>

<section class="tfp-section--alt tfp-section--tight">
	<div class="tfp-container" style="max-width:820px">
		<div style="display:flex;gap:16px;align-items:flex-start">
			<span aria-hidden="true" style="flex-shrink:0;width:4px;align-self:stretch;background:var(--color-primary);border-radius:3px"></span>
			<p style="font-size:clamp(17px,1.7vw,21px);color:var(--color-text);line-height:1.6">Le <strong>nettoyage professionnel</strong> désigne l'entretien récurrent ou ponctuel de locaux à usage professionnel, réalisé par un prestataire extérieur. Chez <?php echo esc_html( $site['brand_name'] ); ?>, chaque prestation repose sur un cahier des charges défini avec vous, un intervenant sélectionné et un cahier de liaison laissé sur place, avec un <strong>devis gratuit sous 24 heures</strong>.</p>
		</div>
		<p style="margin-top:16px;font-size:16px;color:var(--color-text-secondary);line-height:1.6">Contrairement au ménage à domicile, le nettoyage professionnel s'organise autour de contraintes propres à l'entreprise : horaires calés sur l'activité, accès sécurisé aux locaux, confidentialité des espaces de travail, et un besoin de traçabilité — savoir qui est passé, quand, et pour faire quoi. C'est cette organisation, plus que le geste de nettoyage lui-même, qui distingue un prestataire structuré d'une solution improvisée.</p>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container tfp-two-col" style="align-items:flex-start">
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Les professionnels que nous accompagnons</h2>
			<p style="margin-top:12px;font-size:15.5px;color:var(--color-text-secondary)">Notre clientèle regroupe des profils différents, mais partage un même besoin : ne plus avoir à gérer le nettoyage en interne, ni à recruter, encadrer et remplacer un agent d'entretien salarié.</p>
			<ul style="margin-top:16px;display:flex;flex-direction:column;gap:11px;font-size:16px;color:var(--color-text-secondary)">
				<?php
				$profils = array( 'Dirigeants de PME, sièges sociaux, plateaux tertiaires', 'Commerçants, boutiques et showrooms', 'Professions libérales : santé, droit, conseil', 'Syndics, gestionnaires et bailleurs', 'Propriétaires de meublés et hébergements' );
				foreach ( $profils as $profil ) :
					?>
					<li style="padding-left:16px;border-left:2px solid var(--color-primary)"><?php echo esc_html( $profil ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Les types de locaux entretenus</h2>
			<p style="margin-top:12px;font-size:15.5px;color:var(--color-text-secondary)">Chaque type de local a ses propres contraintes : un plateau de bureaux n'a pas les mêmes priorités qu'une salle d'attente médicale ou qu'un hall d'immeuble. Nous adaptons le cahier des charges en conséquence, plutôt que d'appliquer une méthode unique partout.</p>
			<div class="tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,150px),1fr));margin-top:16px">
				<?php foreach ( array( 'Bureaux & open-spaces', 'Surfaces de vente', "Cabinets & salles d'attente", 'Parties communes', 'Meublés & hébergements', 'Sanitaires & cuisines' ) as $local ) : ?>
					<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:11px;padding:13px 15px;font-weight:600;font-size:15px"><?php echo esc_html( $local ); ?></div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:640px">Prestataire de nettoyage ou recrutement direct ?</h2>
		<p style="margin-top:14px;font-size:16.5px;color:var(--color-text-secondary);max-width:760px;line-height:1.65">C'est la première question que se posent la plupart des dirigeants que nous rencontrons. Embaucher directement un agent d'entretien reste possible, et parfois pertinent au-delà d'un certain volume horaire. Mais cela suppose d'assumer des tâches que l'on sous-estime souvent : rédiger l'offre, trier les candidatures, mener les entretiens, établir le contrat, gérer la paie et les congés, encadrer le travail, prévoir un remplacement en cas d'arrêt, et racheter le matériel et les produits. Passer par un prestataire consiste à externaliser cette charge administrative et organisationnelle, en échange d'un tarif horaire plus élevé qu'un salaire brut.</p>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:26px">
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">Ce que vous n'avez plus à gérer</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Recrutement, contrat de travail, bulletins de paie, déclarations sociales, congés payés, visites médicales, entretiens annuels. Une seule facture mensuelle remplace l'ensemble, et le suivi passe par une interlocutrice unique.</p>
			</div>
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">Ce que vous gardez la main sur</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Le périmètre, la fréquence, les horaires et les priorités : tout est écrit dans un cahier des charges que vous validez et pouvez faire évoluer. Vous ne perdez pas le contrôle du travail attendu, vous en déléguez l'organisation.</p>
			</div>
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">Ce qu'un prestataire ne remplace pas</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Un prestataire externe n'est pas présent en continu dans vos locaux et n'assure pas les gestes du quotidien entre deux passages. Si votre besoin réel est une présence permanente, une embauche directe reste probablement plus adaptée — nous le disons plutôt que de forcer un devis.</p>
			</div>
		</div>
	</div>
</section>

<section class="tfp-section tfp-section--navy">
	<div class="tfp-container">
		<h2 style="max-width:620px">Nos six prestations de nettoyage professionnel</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:30px">
			<?php foreach ( $services_nav as $service ) : ?>
				<a href="<?php echo esc_url( $service['url'] ); ?>" style="display:flex;flex-direction:column;gap:4px;background:var(--color-primary);border:1px solid #1E5C9E;border-radius:14px;padding:16px;color:#fff">
					<span style="font-family:var(--font-heading);font-weight:700;font-size:16.5px"><?php echo esc_html( $service['label'] ); ?></span>
					<span style="color:var(--color-turquoise-light);font-size:13px"><?php echo esc_html( $service['tease'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:560px">Régulier ou ponctuel, tâches, fréquences et horaires</h2>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:26px">
			<div class="tfp-card">
				<div style="font-family:var(--font-heading);font-weight:700;font-size:20px">Entretien régulier</div>
				<p style="margin-top:10px;font-size:15px;color:var(--color-text-secondary)">Fréquence définie (quotidienne, plusieurs fois par semaine, hebdomadaire), intervenant habituel recherché et cahier de liaison. Frais de gestion <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT/mois.</p>
			</div>
			<div class="tfp-card">
				<div style="font-family:var(--font-heading);font-weight:700;font-size:20px">Intervention ponctuelle</div>
				<p style="margin-top:10px;font-size:15px;color:var(--color-text-secondary)">Prestation unique et approfondie : remise en état, grand nettoyage, fin de bail. Chiffrée selon le volume et l'état constaté, sans engagement de suite.</p>
			</div>
			<div class="tfp-card">
				<div style="font-family:var(--font-heading);font-weight:700;font-size:20px">Horaires adaptés</div>
				<p style="margin-top:10px;font-size:15px;color:var(--color-text-secondary)">Tôt le matin, en soirée ou en dehors des heures d'ouverture sur demande, pour ne pas perturber votre activité.</p>
			</div>
		</div>
		<div style="margin-top:16px;background:var(--color-turquoise-pale);border:1px solid var(--color-turquoise-light);border-radius:14px;padding:22px">
			<h3 style="font-size:17px;color:var(--color-navy)">Interventions en dehors des horaires d'ouverture</h3>
			<p style="margin-top:8px;font-size:15px;color:var(--color-text)">Sur demande, nous organisons des interventions tôt le matin, en soirée ou de nuit, ainsi que le dimanche ou les jours fériés lorsque votre activité l'exige. Ces créneaux font l'objet d'une majoration de 10 % du tarif horaire, indiquée à l'avance sur le devis — jamais découverte après coup.</p>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:640px">Comment choisir la bonne fréquence</h2>
		<p style="margin-top:14px;font-size:16.5px;color:var(--color-text-secondary);max-width:760px;line-height:1.65">La fréquence dépend moins de la surface que du nombre de personnes réellement présentes, du passage extérieur et du nombre de sanitaires. Trois éléments décident presque toujours : les sanitaires, la salle de pause et les sols de circulation — ce sont eux qui se dégradent en premier et qui déclenchent les remarques internes.</p>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:26px">
			<?php
			$frequences = array(
				array( 't' => 'Quotidienne', 'd' => 'Locaux recevant du public en continu, effectif important, restauration sur place, cabinets de groupe. La charge se concentre sur sanitaires, cuisine et circulations ; le reste suit une rotation.' ),
				array( 't' => 'Deux à trois fois par semaine', 'd' => 'Le rythme le plus courant en bureaux : dix à trente postes, une cuisine, deux sanitaires. Il permet d\'alterner les tâches lourdes et de garder un niveau constant sans surcoût inutile.' ),
				array( 't' => 'Hebdomadaire', 'd' => 'Petites structures, cabinets individuels, copropriétés de taille moyenne, bureaux peu occupés ou en télétravail partiel. Un passage plus long permet de tout traiter en une fois.' ),
				array( 't' => 'Ponctuelle', 'd' => "Fin de chantier, fin de bail, remise en état avant ouverture, grand nettoyage saisonnier. Chiffrée en fourchette d'heures selon l'état constaté, sans engagement de suite." ),
			);
			foreach ( $frequences as $freq ) :
				?>
				<div class="tfp-card">
					<h3 style="font-size:17px"><?php echo esc_html( $freq['t'] ); ?></h3>
					<p style="margin-top:8px;font-size:15px;color:var(--color-text-secondary);line-height:1.6"><?php echo esc_html( $freq['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:640px">Les tâches, espace par espace</h2>
		<p style="margin-top:14px;font-size:16.5px;color:var(--color-text-secondary);max-width:760px;line-height:1.65">Un cahier des charges utile ne liste pas des tâches en vrac : il les répartit par espace et leur associe une fréquence. C'est ce qui permet à l'intervenant de savoir quoi faire quand le temps manque, et à vous de savoir ce que vous êtes en droit d'attendre.</p>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:28px">
			<?php
			$espaces = array(
				array( 't' => 'Postes de travail et mobilier', 'd' => "Dépoussiérage des plans de travail dégagés, du mobilier et des surfaces de contact. Écrans et claviers font l'objet d'un dépoussiérage prudent selon les consignes et le matériel autorisé. Documents et effets personnels ne sont jamais déplacés." ),
				array( 't' => 'Sols et circulations', 'd' => 'Aspiration et lavage selon la nature du revêtement : moquette, vinyle, carrelage, parquet, béton ciré, résine. Les circulations et les entrées se salissent plus vite que le reste et justifient souvent une fréquence propre.' ),
				array( 't' => 'Sanitaires', 'd' => 'Nettoyage et désinfection des cuvettes, lavabos, robinetteries, miroirs, poignées et sols, avec réapprovisionnement du papier, du savon et des sacs lorsque vous fournissez ces consommables.' ),
				array( 't' => 'Cuisine et salle de pause', 'd' => "Plan de travail, évier, tables, extérieur des appareils, sol et poubelle. L'intérieur du réfrigérateur et le dégivrage sont possibles mais planifiés séparément : ils supposent que la cuisine soit vidée." ),
				array( 't' => 'Accueil et espaces recevant du public', 'd' => "Comptoir, assises, tables basses, tapis de propreté, vitrage de la porte d'entrée. C'est le premier espace vu par un visiteur : il est traité à chaque passage." ),
				array( 't' => 'Vitres et surfaces vitrées', 'd' => "Vitres intérieures, cloisons vitrées, portes accessibles sans équipement spécialisé. Tout ce qui exige une nacelle ou un équipement de travail en hauteur est exclu de la prestation courante." ),
			);
			foreach ( $espaces as $espace ) :
				?>
				<div style="border-top:2px solid var(--color-primary);padding-top:16px">
					<h3 style="font-size:18px"><?php echo esc_html( $espace['t'] ); ?></h3>
					<p style="margin-top:9px;font-size:15.5px;color:var(--color-text-secondary);line-height:1.65"><?php echo esc_html( $espace['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container tfp-two-col">
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Un cahier des charges défini avec vous</h2>
			<p style="margin-top:14px;font-size:16.5px;color:var(--color-text-secondary)">Avant la première intervention, nous formalisons avec vous un cahier des charges précis : les espaces concernés, les tâches attendues dans chacun, la fréquence retenue, les horaires possibles et les points de vigilance propres à vos locaux. Ce document sert de référence à l'intervenant et à <?php echo esc_html( $site['manager'] ); ?> pour le suivi, et peut être ajusté à tout moment si vos besoins évoluent.</p>
		</div>
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Intervenant habituel et continuité</h2>
			<p style="margin-top:14px;font-size:16.5px;color:var(--color-text-secondary)">Nous privilégions, autant que possible, un intervenant habituel qui connaît vos locaux, vos consignes et vos habitudes. Cette continuité limite les oublis et accélère la prise en main. En cas d'absence imprévue, nous recherchons activement une solution de remplacement pour maintenir la prestation et vous tenons informé de l'organisation retenue.</p>
		</div>
	</div>
</section>

<section class="tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:620px">Comment se construit un cahier des charges</h2>
		<div class="tfp-grid tfp-grid--autofit-md" style="margin-top:26px">
			<?php
			$etapes = array(
				array( 'n' => '01', 't' => 'Inventaire des espaces', 'd' => "Chaque pièce est listée avec sa surface approximative, son revêtement de sol et son niveau de fréquentation." ),
				array( 'n' => '02', 't' => 'Tâches et fréquences', 'd' => "Pour chaque espace, on distingue ce qui est fait à chaque passage, une fois par semaine, ou une fois par mois." ),
				array( 'n' => '03', 't' => 'Points de vigilance', 'd' => "Matériaux fragiles, zones à accès réservé, documents à ne jamais déplacer, consignes de sécurité et d'alarme." ),
				array( 'n' => '04', 't' => 'Ce qui est explicitement exclu', 'd' => "Nous écrivons noir sur blanc ce qui ne fait pas partie de la prestation, pour éviter l'usure progressive de la relation." ),
			);
			foreach ( $etapes as $etape ) :
				?>
				<div class="tfp-card">
					<div style="font-family:var(--font-heading);font-weight:800;font-size:15px;color:var(--color-primary)"><?php echo esc_html( $etape['n'] ); ?></div>
					<h3 style="margin-top:6px;font-size:17px"><?php echo esc_html( $etape['t'] ); ?></h3>
					<p style="margin-top:8px;font-size:15px;color:var(--color-text-secondary);line-height:1.6"><?php echo esc_html( $etape['d'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( ! empty( $reassurance['avis'] ) ) : ?>
<section class="tfp-section--tight">
	<div class="tfp-container" style="max-width:820px">
		<div class="tfp-card" style="text-align:center">
			<blockquote style="font-size:clamp(18px,2vw,22px);line-height:1.55;color:var(--color-text)">« <?php echo esc_html( $reassurance['avis'][0]['texte'] ); ?> »</blockquote>
			<figcaption style="margin-top:14px;font-size:14px;color:var(--color-text-secondary)"><?php echo esc_html( $reassurance['avis'][0]['nom'] ); ?><?php if ( ! empty( $reassurance['avis'][0]['contexte'] ) ) : ?> · <?php echo esc_html( $reassurance['avis'][0]['contexte'] ); ?><?php endif; ?></figcaption>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container">
		<h2 style="max-width:620px">Trois situations concrètes</h2>
		<p style="margin-top:14px;font-size:16px;color:var(--color-text-secondary);max-width:700px;line-height:1.6">Exemples représentatifs des demandes que nous recevons. Les volumes indiqués sont non contractuels : ils donnent un ordre de grandeur, pas un tarif.</p>
		<div class="tfp-grid tfp-grid--autofit-lg" style="margin-top:26px">
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">PME de 18 personnes, Dijon</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Un plateau, deux sanitaires, une salle de pause, une salle de réunion. Trois passages par semaine entre 6 h 30 et 8 h, soit environ 13 heures par mois. Accès par badge, alarme gérée par l'intervenant.</p>
			</div>
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">Cabinet de groupe, Besançon</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Trois praticiens, une salle d'attente commune, deux sanitaires. Passage quotidien à partir de 19 h 30, après le départ du dernier patient, soit environ 20 heures par mois.</p>
			</div>
			<div class="tfp-card--flat">
				<h3 style="font-size:18px">Remise en état après travaux, 80 m²</h3>
				<p style="margin-top:9px;font-size:15px;color:var(--color-text-secondary);line-height:1.65">Bureaux rénovés, cloisons déposées, peinture refaite. Intervention unique estimée entre 6 et 8 heures : dépoussiérage descendant, vitres, sanitaires et coin cuisine, sols en dernier.</p>
			</div>
		</div>
	</div>
</section>

<section class="tfp-section tfp-section--turquoise">
	<div class="tfp-container tfp-grid" style="grid-template-columns:repeat(auto-fit,minmax(min(100%,280px),1fr))">
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Le tarif, en toute transparence</h2>
			<p style="margin-top:12px;font-size:16px;color:var(--color-text-secondary)">
				<?php echo esc_html( tfp_format_price( $site['price_unique'] ) ); ?> HT/heure — tarif unique en régulier comme en ponctuel, quel que soit le type de local.
				S'ajoutent <?php echo esc_html( tfp_format_price( $site['price_gestion'] ) ); ?> HT/mois de gestion, <?php echo esc_html( tfp_format_price( $site['price_setup'] ) ); ?> HT de frais de mise en place le cas échéant, une majoration de <?php echo esc_html( $site['price_majoration_pct'] ); ?> % (dimanche, jours fériés, nuit) et <?php echo esc_html( $site['price_km_display'] ); ?> HT/km d'indemnités kilométriques si applicable.
			</p>
			<a href="<?php echo esc_url( home_url( '/tarifs/' ) ); ?>" class="tfp-eyebrow-link">Page Tarifs détaillée →</a>
		</div>
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Nos départements</h2>
			<div class="tfp-flex" style="margin-top:14px">
				<?php foreach ( $site['departements'] as $dept_name ) : ?>
					<?php $slug = sanitize_title( remove_accents( $dept_name ) ); ?>
					<a href="<?php echo esc_url( home_url( '/zones-intervention/' . $slug . '/' ) ); ?>" class="tfp-chip"><?php echo esc_html( $dept_name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div>
			<h2 style="font-size:clamp(24px,3vw,34px)">Nos villes</h2>
			<div class="tfp-flex" style="margin-top:14px">
				<?php
				foreach ( array( 'Dijon' => 'cote-dor/dijon', 'Besançon' => 'doubs/besancon', 'Dole' => 'jura/dole', 'Chalon-sur-Saône' => 'saone-et-loire/chalon-sur-saone' ) as $ville_name => $ville_path ) :
					?>
					<a href="<?php echo esc_url( home_url( '/zones-intervention/' . $ville_path . '/' ) ); ?>" class="tfp-chip"><?php echo esc_html( $ville_name ); ?></a>
				<?php endforeach; ?>
			</div>
			<a href="<?php echo esc_url( home_url( '/zones-intervention/bourgogne-franche-comte/' ) ); ?>" class="tfp-eyebrow-link">Hub régional →</a>
		</div>
	</div>
</section>

<section class="tfp-section--tight">
	<div class="tfp-container">
		<div class="tfp-flex tfp-flex--between" style="margin-bottom:20px">
			<h2 style="font-size:clamp(24px,3vw,34px)">Pour aller plus loin</h2>
			<a href="<?php echo esc_url( home_url( '/conseils/' ) ); ?>" class="tfp-link-arrow">Tous les conseils →</a>
		</div>
		<div class="tfp-grid tfp-grid--autofit-md">
			<?php foreach ( $articles_nav as $article ) : ?>
				<a href="<?php echo esc_url( $article['url'] ); ?>" style="display:flex;justify-content:space-between;align-items:center;gap:12px;background:var(--color-bg);border:1px solid var(--color-border);border-radius:12px;padding:16px 18px;color:var(--color-text)">
					<span style="font-weight:600;font-size:15px"><?php echo esc_html( $article['label'] ); ?></span>
					<span style="color:var(--color-primary)" aria-hidden="true">→</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="tfp-section--alt tfp-section">
	<div class="tfp-container" style="max-width:820px">
		<h2 style="margin-bottom:22px">Questions fréquentes</h2>
		<?php foreach ( $faqs as $item ) : ?>
			<details class="tfp-card" style="margin-bottom:10px">
				<summary style="font-weight:600;font-size:17px;cursor:pointer"><?php echo esc_html( $item['q'] ); ?></summary>
				<p style="margin-top:12px;color:var(--color-text-secondary)"><?php echo esc_html( $item['a'] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>

<section class="tfp-cta-block">
	<div class="tfp-cta-block__inner">
		<h2>Un projet d'entretien pour vos locaux ?</h2>
		<p>Devis gratuit sous 24 h, sans engagement.</p>
		<div class="tfp-cta-block__actions">
			<?php
			tfp_button( array( 'label' => 'Demander mon devis', 'href' => home_url( '/demande-de-devis/' ), 'variant' => 'on-primary' ) );
			tfp_button( array( 'label' => '☎ ' . $site['phone'], 'href' => 'tel:' . $site['phone_href'], 'variant' => 'on-dark' ) );
			?>
		</div>
	</div>
</section>
<?php
get_footer();
