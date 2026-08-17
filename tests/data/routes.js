/**
 * Manifeste des 53 routes publiques + 1 route 404, reconstruit depuis docs/INVENTAIRE-ROUTES.md
 * (source de vérité des URL cibles). Sert de base aux tests génériques (tests/seo.spec.js) et au
 * crawl (tests/crawl.spec.js) : une seule liste, pas une copie par test.
 *
 * `robots` reflète l'état CIBLE. Les 8 communes secondaires y sont passées de `noindex,follow` à
 * `index,follow` le 17 août 2026, quand Emmanuel a confirmé la desserte — voir plus bas.
 */

const STATIQUE = [
	'/',
	'/nettoyage-professionnel/',
	'/prestations/',
	'/tarifs/',
	'/zones-intervention/',
	'/zones-intervention/bourgogne-franche-comte/',
	'/pourquoi-nous/',
	'/notre-fonctionnement/',
	'/avis-clients/',
	'/a-propos/',
	'/demande-de-devis/',
	'/contact/',
	'/recrutement/',
	'/conseils/',
	'/plan-du-site/',
	'/mentions-legales/',
	'/politique-de-confidentialite/',
	'/gestion-des-cookies/',
].map((url) => ({ url, family: 'statique', robots: 'index,follow' }));

const PRESTATION = [
	'/prestations/bureaux/',
	'/prestations/commerces/',
	'/prestations/cabinets/',
	'/prestations/coproprietes/',
	'/prestations/meubles/',
	'/prestations/ponctuel/',
].map((url) => ({ url, family: 'prestation', robots: 'index,follow' }));

const DEPARTEMENT = [
	'/zones-intervention/cote-dor/',
	'/zones-intervention/doubs/',
	'/zones-intervention/jura/',
	'/zones-intervention/nievre/',
	'/zones-intervention/haute-saone/',
	'/zones-intervention/saone-et-loire/',
	'/zones-intervention/yonne/',
	'/zones-intervention/territoire-de-belfort/',
].map((url) => ({ url, family: 'departement', robots: 'index,follow' }));

const VILLE = [
	'/zones-intervention/cote-dor/dijon/',
	'/zones-intervention/doubs/besancon/',
	'/zones-intervention/jura/dole/',
	'/zones-intervention/jura/lons-le-saunier/',
	'/zones-intervention/nievre/nevers/',
	'/zones-intervention/haute-saone/vesoul/',
	'/zones-intervention/saone-et-loire/chalon-sur-saone/',
	'/zones-intervention/saone-et-loire/macon/',
	'/zones-intervention/yonne/auxerre/',
	'/zones-intervention/territoire-de-belfort/belfort/',
].map((url) => ({ url, family: 'ville', robots: 'index,follow' }));

// Communes secondaires non validées (CLAUDE.md §5.4) : noindex,follow tant qu'Audrey ne les a pas
// validées une par une — c'est l'état CIBLE attendu, pas une anomalie à corriger.
const COMMUNE = [
	'/zones-intervention/cote-dor/saint-apollinaire/',
	'/zones-intervention/cote-dor/chenove/',
	'/zones-intervention/cote-dor/quetigny/',
	'/zones-intervention/cote-dor/talant/',
	'/zones-intervention/cote-dor/longvic/',
	'/zones-intervention/cote-dor/fontaine-les-dijon/',
	'/zones-intervention/cote-dor/marsannay-la-cote/',
	'/zones-intervention/cote-dor/beaune/',
/*
 * VALIDÉES LE 17 AOÛT 2026 — Emmanuel confirme qu'Audrey intervient sur ces huit communes.
 *
 * CLAUDE.md §5.4 les tenait en `noindex,follow` tant que la desserte n'était pas confirmée : « une
 * page qui promet une intervention impossible coûte plus qu'elle ne rapporte ». La condition est
 * remplie, elles passent donc en `index,follow` et rejoignent le sitemap. Le mécanisme n'a pas
 * bougé — `single-zone.php` lit `statut_validation`, coché par bin/seed-phase3-batch4-communes.php.
 *
 * Saint-Apollinaire n'aurait jamais dû figurer parmi elles : c'est le siège de l'entreprise.
 */
].map((url) => ({ url, family: 'commune', robots: 'index,follow' }));

const ARTICLE = [
	'/conseils/frequence-bureaux/',
	'/conseils/cout-nettoyage-bureaux/',
	'/conseils/cahier-des-charges-nettoyage/',
].map((url) => ({ url, family: 'article', robots: 'index,follow' }));

export const ROUTES = [...STATIQUE, ...PRESTATION, ...DEPARTEMENT, ...VILLE, ...COMMUNE, ...ARTICLE];

// Villes à nom long, pour les contrôles particuliers du brief phase 5 (débordement, capture).
export const LONG_NAME_ROUTES = [
	'/zones-intervention/cote-dor/fontaine-les-dijon/',
	'/zones-intervention/saone-et-loire/chalon-sur-saone/',
];

export const NOT_FOUND_URL = '/route-inexistante-de-test/';

// Une page par famille, pour les tests fonctionnels/captures qui n'ont pas besoin des 53 pages.
export const ONE_PER_FAMILY = {
	statique: '/',
	prestation: '/prestations/bureaux/',
	departement: '/zones-intervention/cote-dor/',
	ville: '/zones-intervention/cote-dor/dijon/',
	commune: '/zones-intervention/cote-dor/beaune/',
	article: '/conseils/frequence-bureaux/',
};
