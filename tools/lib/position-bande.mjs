/**
 * Comparaison de la POSITION d'une image dans le flux, entre la maquette et le site.
 *
 * ## Pourquoi cette comparaison existe
 *
 * L'empreinte SHA-256 prouve qu'un fichier est le bon. Elle ne dit rien de l'endroit où il est
 * servi. La bande « Cahier des charges, intervenants et suivi » de la page pilier portait le bon
 * visuel, aux bons octets — à la 18ᵉ position au lieu de la 11ᵉ, entre « Questions fréquentes » et
 * le pied de page au lieu d'être entre « Comment se construit un cahier des charges » et « Trois
 * situations concrètes ». L'audit la déclarait identique, et il avait raison sur ce qu'il mesurait.
 *
 * Le repère est donc le triplet : titre de la bande qui porte l'image, titre de la bande
 * précédente, titre de la bande suivante. Le titre de la bande **seul** ne suffirait pas — quand
 * une bande se déplace, son propre titre se déplace avec elle. Ce sont les voisins qui trahissent
 * le déplacement.
 *
 * ## Pourquoi les titres vides ne comptent pas
 *
 * Les deux rendus ne découpent pas toujours leurs bandes au même niveau du DOM : une bande de la
 * maquette peut n'exposer aucun titre là où le site en expose un, sans qu'aucune image ait bougé.
 * Un créneau n'est donc comparé que si les DEUX côtés le renseignent. Si aucun ne l'est, la
 * position est déclarée **non comparable** — ce qui est une information, pas un verdict.
 */

/** Normalise un titre : casse, accents et ponctuation ne sont pas des déplacements. */
export function normaliserTitre(t) {
	return String(t || '')
		.toLowerCase()
		.normalize('NFD')
		.replace(/[̀-ͯ]/g, '')
		.replace(/[^a-z0-9 ]/g, ' ')
		.replace(/\s+/g, ' ')
		.trim();
}

/**
 * @typedef {{ bande?: string, avant?: string, apres?: string }} Reperes
 * @param {Reperes} maquette
 * @param {Reperes} site
 * @returns {{ verdict: 'meme-place'|'deplacee'|'non-comparable', creneaux: Array<{nom: string, maquette: string, site: string, egal: boolean}> }}
 */
export function comparerPosition(maquette, site) {
	const creneaux = [ 'bande', 'avant', 'apres' ].map( ( nom ) => {
		const a = normaliserTitre( maquette?.[ nom ] );
		const b = normaliserTitre( site?.[ nom ] );
		return { nom, maquette: a, site: b, comparable: a !== '' && b !== '', egal: a === b };
	} );

	const comparables = creneaux.filter( ( c ) => c.comparable );
	if ( ! comparables.length ) {
		return { verdict: 'non-comparable', creneaux };
	}
	return {
		verdict: comparables.every( ( c ) => c.egal ) ? 'meme-place' : 'deplacee',
		creneaux,
	};
}
