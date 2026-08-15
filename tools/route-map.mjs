#!/usr/bin/env node
/**
 * Table de correspondance route maquette Claude Design → route WordPress.
 *
 * Isolée dans son propre module : elle est partagée par les outils d'extraction et de
 * comparaison, et l'importer ne doit déclencher aucun traitement.
 */
/**
 * Correspondance route maquette → route WordPress. Les URL WordPress sont hiérarchiques
 * (docs/INVENTAIRE-ROUTES.md), la maquette est à plat : la table ci-dessous est la seule
 * traduction, et sert aussi de contrôle d'exhaustivité (toute route découverte sans entrée
 * ici est signalée).
 */
export const ROUTE_MAP = {
	'#/': { wp: '/', type: 'accueil' },
	'#/nettoyage-professionnel': { wp: '/nettoyage-professionnel/', type: 'pilier' },
	'#/nos-prestations': { wp: '/prestations/', type: 'index-prestations' },
	'#/service/bureaux': { wp: '/prestations/bureaux/', type: 'prestation' },
	'#/service/commerces': { wp: '/prestations/commerces/', type: 'prestation' },
	'#/service/cabinets': { wp: '/prestations/cabinets/', type: 'prestation' },
	'#/service/coproprietes': { wp: '/prestations/coproprietes/', type: 'prestation' },
	'#/service/meubles': { wp: '/prestations/meubles/', type: 'prestation' },
	'#/service/ponctuel': { wp: '/prestations/ponctuel/', type: 'prestation' },
	'#/nos-tarifs': { wp: '/tarifs/', type: 'tarifs' },
	'#/zones-intervention': { wp: '/zones-intervention/', type: 'hub-zones' },
	'#/bourgogne-franche-comte': { wp: '/zones-intervention/bourgogne-franche-comte/', type: 'region' },
	'#/departement/cote-dor': { wp: '/zones-intervention/cote-dor/', type: 'departement' },
	'#/departement/doubs': { wp: '/zones-intervention/doubs/', type: 'departement' },
	'#/departement/jura': { wp: '/zones-intervention/jura/', type: 'departement' },
	'#/departement/nievre': { wp: '/zones-intervention/nievre/', type: 'departement' },
	'#/departement/haute-saone': { wp: '/zones-intervention/haute-saone/', type: 'departement' },
	'#/departement/saone-et-loire': { wp: '/zones-intervention/saone-et-loire/', type: 'departement' },
	'#/departement/yonne': { wp: '/zones-intervention/yonne/', type: 'departement' },
	'#/departement/territoire-de-belfort': { wp: '/zones-intervention/territoire-de-belfort/', type: 'departement' },
	'#/ville/dijon': { wp: '/zones-intervention/cote-dor/dijon/', type: 'ville' },
	'#/ville/besancon': { wp: '/zones-intervention/doubs/besancon/', type: 'ville' },
	'#/ville/dole': { wp: '/zones-intervention/jura/dole/', type: 'ville' },
	'#/ville/lons-le-saunier': { wp: '/zones-intervention/jura/lons-le-saunier/', type: 'ville' },
	'#/ville/nevers': { wp: '/zones-intervention/nievre/nevers/', type: 'ville' },
	'#/ville/vesoul': { wp: '/zones-intervention/haute-saone/vesoul/', type: 'ville' },
	'#/ville/chalon-sur-saone': { wp: '/zones-intervention/saone-et-loire/chalon-sur-saone/', type: 'ville' },
	'#/ville/macon': { wp: '/zones-intervention/saone-et-loire/macon/', type: 'ville' },
	'#/ville/auxerre': { wp: '/zones-intervention/yonne/auxerre/', type: 'ville' },
	'#/ville/belfort': { wp: '/zones-intervention/territoire-de-belfort/belfort/', type: 'ville' },
	'#/ville/saint-apollinaire': { wp: '/zones-intervention/cote-dor/saint-apollinaire/', type: 'commune' },
	'#/ville/chenove': { wp: '/zones-intervention/cote-dor/chenove/', type: 'commune' },
	'#/ville/quetigny': { wp: '/zones-intervention/cote-dor/quetigny/', type: 'commune' },
	'#/ville/talant': { wp: '/zones-intervention/cote-dor/talant/', type: 'commune' },
	'#/ville/longvic': { wp: '/zones-intervention/cote-dor/longvic/', type: 'commune' },
	'#/ville/fontaine-les-dijon': { wp: '/zones-intervention/cote-dor/fontaine-les-dijon/', type: 'commune' },
	'#/ville/marsannay-la-cote': { wp: '/zones-intervention/cote-dor/marsannay-la-cote/', type: 'commune' },
	'#/ville/beaune': { wp: '/zones-intervention/cote-dor/beaune/', type: 'commune' },
	'#/conseils': { wp: '/conseils/', type: 'index-conseils' },
	'#/article/frequence-bureaux': { wp: '/conseils/frequence-bureaux/', type: 'article' },
	'#/article/cout-nettoyage-bureaux': { wp: '/conseils/cout-nettoyage-bureaux/', type: 'article' },
	'#/article/cahier-des-charges-nettoyage': { wp: '/conseils/cahier-des-charges-nettoyage/', type: 'article' },
	'#/pourquoi-top-famille-pro': { wp: '/pourquoi-nous/', type: 'institutionnelle' },
	'#/notre-fonctionnement': { wp: '/notre-fonctionnement/', type: 'institutionnelle' },
	'#/avis-clients': { wp: '/avis-clients/', type: 'institutionnelle' },
	'#/a-propos': { wp: '/a-propos/', type: 'institutionnelle' },
	'#/recrutement': { wp: '/recrutement/', type: 'institutionnelle' },
	'#/demande-de-devis': { wp: '/demande-de-devis/', type: 'formulaire' },
	'#/contact': { wp: '/contact/', type: 'contact' },
	'#/plan-du-site': { wp: '/plan-du-site/', type: 'plan-du-site' },
	'#/mentions-legales': { wp: '/mentions-legales/', type: 'legale' },
	'#/politique-de-confidentialite': { wp: '/politique-de-confidentialite/', type: 'legale' },
	'#/gestion-des-cookies': { wp: '/gestion-des-cookies/', type: 'legale' },
};

