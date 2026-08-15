/**
 * Découpage d'une page en **bandes**, partagé par les outils de comparaison.
 *
 * Une bande est une tranche horizontale de la page : un bloc de premier niveau du flux, celui que
 * l'œil identifie comme « une section de la page ». Le compteur de bandes sert à répondre à une
 * seule question — *le rendu WordPress a-t-il perdu une bande de la maquette ?* — et c'est la
 * question la plus grave de tout le chantier de fidélité : une bande absente est du contenu absent,
 * qu'aucune mesure de hauteur ne rattrape.
 *
 * ## Pourquoi le nom de balise ne suffit pas
 *
 * Le compteur comptait `:scope > section`. La maquette écrit toutes ses bandes en `<section>`, donc
 * la règle y est juste. Le thème, lui, écrit deux bandes des pages d'article avec la balise qui
 * porte le sens : `<header>` pour le titre et son visuel de couverture, `<article>` pour le corps
 * éditorial rendu en flux continu par `the_content()`. Ces deux bandes existent, sont visibles, et
 * portent exactement les intitulés de la maquette — mais elles ne sont pas des `<section>`, et le
 * compteur annonçait « bandes 8 → 6 » sur les trois articles.
 *
 * Le défaut est donc dans l'outil, pas dans le thème : la correction consiste à reconnaître le
 * corps éditorial continu, **pas** à envelopper le contenu dans des `<section>` artificielles pour
 * faire plaisir au compteur (le balisage du thème est le bon, `<article>` étant précisément
 * l'élément qui porte un corps rédactionnel).
 *
 * ## Ce que la règle ne fait pas
 *
 * Elle n'invente aucune bande : elle n'admet que des éléments de premier niveau réellement rendus
 * (plus de 20 px de haut). Une bande réellement absente du rendu WordPress fait toujours chuter le
 * compte, et reste donc détectée — c'est l'objet du contrôle de `tests/bandes.spec.js`.
 *
 * ## Ce qui reste exclu, des deux côtés
 *
 * `<nav>` (le fil d'Ariane de la maquette) et `<div>` (celui du thème) ne sont pas des bandes : ce
 * sont des rails de navigation, exclus symétriquement des deux côtés. Le balayage des 53 routes aux
 * six largeurs confirme que la composition de premier niveau ne diffère QUE sur les trois articles :
 * partout ailleurs les deux côtés posent le même nombre de `<section>`.
 */

/**
 * Éléments de premier niveau qui comptent pour une bande.
 *
 * `section` : la forme commune aux deux côtés.
 * `article` : le corps éditorial continu du thème (`the_content()`).
 * `header`  : l'en-tête d'article — titre, méta et couverture — que la maquette écrit en `section`.
 */
export const SEL_BANDE = 'section, article, header';

/** Hauteur en deçà de laquelle un bloc de premier niveau n'est pas une bande visible. */
export const HAUTEUR_MINIMALE = 20;

/**
 * Code installé DANS la page. Les outils travaillent par `page.evaluate()`, dont la fonction est
 * sérialisée puis exécutée dans un autre contexte : elle ne peut donc pas fermer sur ce module.
 * Passer par `addInitScript` est le seul moyen d'avoir **une seule définition** de la règle, plutôt
 * qu'une copie par outil — et c'est bien une divergence entre copies qui a produit le faux positif.
 */
function installer(sel, hauteurMinimale) {
	/** Les bandes d'un flux, dans l'ordre de lecture. */
	window.__tfpBandes = (flux) =>
		[...flux.children].filter(
			(el) => el.matches(sel) && el.getBoundingClientRect().height > hauteurMinimale
		);
}

/** À passer à `page.addInitScript()` avant le premier chargement de la page. */
export const SRC_BANDES = `(${installer.toString()})(${JSON.stringify(SEL_BANDE)}, ${HAUTEUR_MINIMALE});`;
