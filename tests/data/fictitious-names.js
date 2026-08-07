/**
 * Noms des avis de démonstration du prototype (`demo: true`, docs/DONNEES-FICTIVES.md et
 * docs/INVENTAIRE-ROUTES.md, colonne « Preuves utilisées ») — tous supprimés en phase 3. Utilisé par
 * tests/seo.spec.js pour vérifier qu'aucun ne réapparaît sur le site réel.
 *
 * Chaque nom inclut son initiale de nom de famille pour ne jamais confondre avec un des 6 avis
 * authentiques réutilisables (CLAUDE.md §5.5 : Jean-Louis D., Anna P., Michel G., Laurent, Laura,
 * Anne-Sophie — remarquer que « Laurent » et « Anne-Sophie » sont réels sans initiale, alors que
 * « Laurent C. » et « Anne-Sophie L. » ci-dessous sont les versions fictives du prototype).
 */
export const FICTITIOUS_REVIEW_NAMES = [
	'Camille R.',
	'Sarah B.',
	'Thomas L.',
	'Nadia M.',
	'Julien P.',
	'Olivier D.',
	'Julien R.',
	'Claire D.',
	'Nathalie P.',
	'Bernard L.',
	'Fabrice T.',
	'Émilie V.',
	'Karim B.',
	'Sylvain M.',
	'Marc D.',
	'Hélène F.',
	'Isabelle G.',
	'Pascal R.',
	'Michèle A.',
	'Laurent C.',
	'Damien P.',
	'Anne-Sophie L.',
	'Sébastien H.',
	'Thierry N.',
	'Client Top-Famille Pro',
];

export const FICTITIOUS_MARKERS = [...FICTITIOUS_REVIEW_NAMES, '47 avis', 'Top-Entreprise'];
