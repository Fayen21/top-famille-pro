# Inventaire des routes — prototype Claude Design → site WordPress

> Reconstitué par extraction du bundle du prototype (`reference/Top-Famille-Pro-HANDOFF-READY.html`), pas par lecture visuelle : les valeurs `title`/`meta description`/`h1`/robots ci-dessous sont les valeurs réelles calculées par la fonction `seoEntry()` embarquée dans le prototype, qui produit elle-même son propre tableau d'audit (`QA_ROWS`, 53 lignes) — cette page en est la restitution.

**53 pages publiques + 1 page 404 = 54 routes.** Le prototype lui-même annote : « 56 routes n'utilisent que 10 gabarits distincts » (56 = 53 + 404 + 2 routes internes de démonstration/QA du prototype, `#/plan-du-site` interne et `#/documentation-interne`, qui ne font PAS partie du site public et ne doivent PAS être reprises).

## Écarts prototype → cible, à corriger dès la migration

- **8 communes secondaires** (Saint-Apollinaire, Chenôve, Quetigny, Talant, Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune) : **`index,follow`**, comme le prototype. La validation qu'attendait CLAUDE.md §5.4 a été donnée par Emmanuel le **17 août 2026**, confirmée le 19 : Audrey intervient dans les huit. Elles figurent au sitemap. Voir `docs/DECISIONS.json`, décision `communes-secondaires-indexees`.
- **Avis démo** sur quasi toutes les pages Prestation/Département/Ville/Commune/Pilier + note 5,0 et compteur 47 avis : fictifs, à supprimer (détail : `docs/DONNEES-FICTIVES.md`).
- **`googleUrl: '#'`** dans l'objet `RATING` du prototype : lien Google factice, à masquer tant que l'URL réelle n'est pas fournie (interdiction `href="#"` public, CLAUDE.md §8).
- **404** : le prototype ne matérialise pas de gabarit 404 dédié — `isNotFound` est un flag calculé côté client sans vrai statut HTTP. Le site WordPress doit renvoyer un vrai 404.

## Statique (18 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/` | `/` | Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté (71c ⚠️>65c) | Nettoyage professionnel de bureaux et locaux en Bourgogne-Franche-Comté | non | — | index,follow |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | Nettoyage professionnel de bureaux et de locaux \| Top-Famille Pro (65c) | Nettoyage professionnel de bureaux et de locaux | non | — | index,follow |
| `#/nos-prestations` | `/prestations/` | Nos prestations de nettoyage professionnel \| Top-Famille Pro (60c) | Nos prestations de nettoyage professionnel | non | — | index,follow |
| `#/nos-tarifs` | `/tarifs/` | Tarifs de nettoyage professionnel : 27 € HT/h \| Top-Famille Pro (63c) | Tarifs de nettoyage professionnel : 27 € HT/h | non | — | index,follow |
| `#/zones-intervention` | `/zones-intervention/` | Zones d'intervention en Bourgogne-Franche-Comté \| Top-Famille Pro (65c) | Zones d'intervention en Bourgogne-Franche-Comté | non | — | index,follow |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | Entreprise de nettoyage en Bourgogne-Franche-Comté \| Top-Famille Pro (68c ⚠️>65c) | Entreprise de nettoyage en Bourgogne-Franche-Comté | non | — | index,follow |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | Pourquoi choisir Top-Famille Pro \| Nettoyage professionnel (58c) | Pourquoi choisir Top-Famille Pro | non | — | index,follow |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | Notre fonctionnement, du devis au suivi \| Top-Famille Pro (57c) | Notre fonctionnement, du devis au suivi | non | — | index,follow |
| `#/avis-clients` | `/avis-clients/` | Avis clients \| Top-Famille Pro (30c) | Avis clients | non | — | index,follow |
| `#/a-propos` | `/a-propos/` | À propos de Top-Famille Pro \| Audrey, votre interlocutrice (58c) | À propos de Top-Famille Pro | non | — | index,follow |
| `#/demande-de-devis` | `/demande-de-devis/` | Demande de devis gratuit \| Top-Famille Pro (42c) | Demande de devis gratuit | non | — | index,follow |
| `#/contact` | `/contact/` | Contacter Top-Famille Pro \| Nettoyage professionnel (51c) | Contacter Top-Famille Pro | non | — | index,follow |
| `#/recrutement` | `/recrutement/` | Recrutement — agents d'entretien \| Top-Famille Pro (50c) | Recrutement — agents d'entretien | non | — | index,follow |
| `#/conseils` | `/conseils/` | Conseils d'entretien de locaux professionnels \| Top-Famille Pro (63c) | Conseils d'entretien de locaux professionnels | non | — | index,follow |
| `#/plan-du-site` | `/plan-du-site/` | Plan du site \| Top-Famille Pro (30c) | Plan du site | non | — | index,follow |
| `#/mentions-legales` | `/mentions-legales/` | Mentions légales \| Top-Famille Pro (34c) | Mentions légales | non | — | index,follow |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | Politique de confidentialité \| Top-Famille Pro (46c) | Politique de confidentialité | non | — | index,follow |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | Gestion des cookies \| Top-Famille Pro (37c) | Gestion des cookies | non | — | index,follow |

## Prestation (CPT prestation) (6 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/service/bureaux` | `/prestations/bureaux/` | Nettoyage de bureaux en Bourgogne-Franche-Comté \| Top-Famille Pro (65c) | Nettoyage de bureaux en Bourgogne-Franche-Comté | oui | avis démo (Camille R. \| demo:true); FAQ×8 | index,follow |
| `#/service/commerces` | `/prestations/commerces/` | Nettoyage de commerces et de surfaces de vente \| Top-Famille Pro (64c) | Nettoyage de commerces et de surfaces de vente | oui | avis démo (Sarah B. \| demo:true); FAQ×7 | index,follow |
| `#/service/cabinets` | `/prestations/cabinets/` | Nettoyage de cabinets et de professions libérales \| Top-Famille Pro (67c ⚠️>65c) | Nettoyage de cabinets et de professions libérales | oui | avis démo (Thomas L. \| demo:true); FAQ×8 | index,follow |
| `#/service/coproprietes` | `/prestations/coproprietes/` | Entretien de copropriétés et de parties communes \| Top-Famille Pro (66c ⚠️>65c) | Entretien de copropriétés et de parties communes | oui | avis démo (Nadia M. \| demo:true); FAQ×8 | index,follow |
| `#/service/meubles` | `/prestations/meubles/` | Nettoyage de locations meublées et d'hébergements \| Top-Famille Pro (67c ⚠️>65c) | Nettoyage de locations meublées et d'hébergements | oui | avis démo (Julien P. \| demo:true); FAQ×8 | index,follow |
| `#/service/ponctuel` | `/prestations/ponctuel/` | Nettoyage ponctuel et remise en état \| Top-Famille Pro (54c) | Nettoyage ponctuel et remise en état | oui | avis démo (Olivier D. \| demo:true); FAQ×8 | index,follow |

## Zone — département (CPT zone) (8 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | Nettoyage professionnel en Côte-d'Or \| Top-Famille Pro (54c) | Entreprise de nettoyage en Côte-d'Or | oui | avis démo (Julien R. \| demo:true); FAQ×6 | index,follow |
| `#/departement/doubs` | `/zones-intervention/doubs/` | Nettoyage professionnel en Doubs \| Top-Famille Pro (50c) | Entreprise de nettoyage dans le Doubs | oui | avis démo (Claire D. \| demo:true); FAQ×6 | index,follow |
| `#/departement/jura` | `/zones-intervention/jura/` | Nettoyage professionnel en Jura \| Top-Famille Pro (49c) | Entreprise de nettoyage dans le Jura | oui | avis démo (Nathalie P. \| demo:true); FAQ×6 | index,follow |
| `#/departement/nievre` | `/zones-intervention/nievre/` | Nettoyage professionnel en Nièvre \| Top-Famille Pro (51c) | Entreprise de nettoyage dans la Nièvre | oui | avis démo (Bernard L. \| demo:true); FAQ×6 | index,follow |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | Nettoyage professionnel en Haute-Saône \| Top-Famille Pro (56c) | Entreprise de nettoyage en Haute-Saône | oui | avis démo (Fabrice T. \| demo:true); FAQ×6 | index,follow |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | Nettoyage professionnel en Saône-et-Loire \| Top-Famille Pro (59c) | Entreprise de nettoyage en Saône-et-Loire | oui | avis démo (Émilie V. \| demo:true); FAQ×6 | index,follow |
| `#/departement/yonne` | `/zones-intervention/yonne/` | Nettoyage professionnel en Yonne \| Top-Famille Pro (50c) | Entreprise de nettoyage dans l'Yonne | oui | avis démo (Karim B. \| demo:true); FAQ×6 | index,follow |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | Nettoyage professionnel en Territoire de Belfort \| Top-Famille Pro (66c ⚠️>65c) | Entreprise de nettoyage dans le Territoire de Belfort | oui | avis démo (Sylvain M. \| demo:true); FAQ×6 | index,follow |

## Zone — ville (CPT zone) (10 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | Entreprise de nettoyage à Dijon (21000) \| Top-Famille Pro (57c) | Entreprise de nettoyage à Dijon | oui | avis démo (Marc D. \| demo:true); FAQ×7 | index,follow |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | Entreprise de nettoyage à Besançon (25000) \| Top-Famille Pro (60c) | Entreprise de nettoyage à Besançon | oui | avis démo (Hélène F. \| demo:true); FAQ×7 | index,follow |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | Entreprise de nettoyage à Dole (39100) \| Top-Famille Pro (56c) | Entreprise de nettoyage à Dole | oui | avis démo (Isabelle G. \| demo:true); FAQ×6 | index,follow |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | Entreprise de nettoyage à Lons-le-Saunier (39000) \| Top-Famille Pro (67c ⚠️>65c) | Entreprise de nettoyage à Lons-le-Saunier | oui | avis démo (Pascal R. \| demo:true); FAQ×6 | index,follow |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | Entreprise de nettoyage à Nevers (58000) \| Top-Famille Pro (58c) | Entreprise de nettoyage à Nevers | oui | avis démo (Michèle A. \| demo:true); FAQ×6 | index,follow |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | Entreprise de nettoyage à Vesoul (70000) \| Top-Famille Pro (58c) | Entreprise de nettoyage à Vesoul | oui | avis démo (Laurent C. \| demo:true); FAQ×6 | index,follow |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | Entreprise de nettoyage à Chalon-sur-Saône (71100) \| Top-Famille Pro (68c ⚠️>65c) | Entreprise de nettoyage à Chalon-sur-Saône | oui | avis démo (Damien P. \| demo:true); FAQ×6 | index,follow |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | Entreprise de nettoyage à Mâcon (71000) \| Top-Famille Pro (57c) | Entreprise de nettoyage à Mâcon | oui | avis démo (Anne-Sophie L. \| demo:true); FAQ×6 | index,follow |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | Entreprise de nettoyage à Auxerre (89000) \| Top-Famille Pro (59c) | Entreprise de nettoyage à Auxerre | oui | avis démo (Sébastien H. \| demo:true); FAQ×6 | index,follow |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | Entreprise de nettoyage à Belfort (90000) \| Top-Famille Pro (59c) | Entreprise de nettoyage à Belfort | oui | avis démo (Thierry N. \| demo:true); FAQ×6 | index,follow |

## Zone — commune secondaire (CPT zone, non validée) (8 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | Entreprise de nettoyage à Saint-Apollinaire (21850) \| Top-Famille Pro (69c ⚠️>65c) | Entreprise de nettoyage à Saint-Apollinaire | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | Entreprise de nettoyage à Chenôve (21300) \| Top-Famille Pro (59c) | Entreprise de nettoyage à Chenôve | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | Entreprise de nettoyage à Quetigny (21800) \| Top-Famille Pro (60c) | Entreprise de nettoyage à Quetigny | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | Entreprise de nettoyage à Talant (21240) \| Top-Famille Pro (58c) | Entreprise de nettoyage à Talant | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | Entreprise de nettoyage à Longvic (21600) \| Top-Famille Pro (59c) | Entreprise de nettoyage à Longvic | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | Entreprise de nettoyage à Fontaine-lès-Dijon (21121) \| Top-Famille Pro (70c ⚠️>65c) | Entreprise de nettoyage à Fontaine-lès-Dijon | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | Entreprise de nettoyage à Marsannay-la-Côte (21160) \| Top-Famille Pro (69c ⚠️>65c) | Entreprise de nettoyage à Marsannay-la-Côte | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×6 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | Entreprise de nettoyage à Beaune (21200) \| Top-Famille Pro (58c) | Entreprise de nettoyage à Beaune | oui | avis démo (Client Top-Famille Pro \| demo:true); FAQ×7 | index,follow **(validées le 17/08/2026 — alignées sur le prototype)** |

## Article (post "conseils") (3 pages)

| Route démo | URL cible | Title (longueur) | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | À quelle fréquence faire nettoyer ses bureaux ? \| Top-Famille Pro (65c) | À quelle fréquence faire nettoyer ses bureaux ? | oui | FAQ×3 | index,follow |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | Combien coûte le nettoyage de bureaux ? \| Top-Famille Pro (57c) | Combien coûte le nettoyage de bureaux ? | oui | FAQ×3 | index,follow |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | Comment rédiger un cahier des charges de nettoyage ? \| Top-Famille Pro (70c ⚠️>65c) | Comment rédiger un cahier des charges de nettoyage ? | oui | FAQ×3 | index,follow |

## 404

| Route démo | URL cible | Famille | Title | H1 | FAQ | Preuves utilisées | Statut cible |
|---|---|---|---|---|---|---|---|
| `#/route-inexistante-test` (et toute route hors `KNOWN_ROUTES`/id inconnu) | n'importe quelle URL non résolue | 404 | À définir (ex. "Page introuvable | Top-Famille Pro") | À définir (ex. "Page introuvable") | non | — | `noindex,follow`, **vrai statut HTTP 404** (le prototype ne le fait pas : c'est un flag client `isNotFound`, pas une réponse serveur) |
