# Comparaison des 53 routes — maquette Claude Design ↔ WordPress

> Fichier **généré** par `node tools/compare-routes.mjs`. Ne pas éditer à la main.
>
> Les deux versions sont ouvertes dans le même navigateur, animations neutralisées, images
> réellement chargées (défilement complet préalable), polices chargées. Le triptyque
> `docs/captures/comparaison/<route>-<largeur>.jpg` montre, de gauche à droite : la maquette,
> le rendu WordPress, et leur différence pixel à pixel (les zones sombres sont les écarts).
>
> La proximité de hauteur ne prouve rien à elle seule : les colonnes « mots », « titres »
> et « puces » comptent le contenu réellement présent, et le détail bloc par bloc ci-dessous
> nomme chaque section manquante.

## Synthèse à 320 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 14130 → 14651 (104 %) | 1035 → 1125 (109 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9639 → 10940 (113 %) | 932 → 951 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 8755 → 9708 (111 %) | 1019 → 1039 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6661 → 6616 (99 %) | 594 → 639 (108 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 5448 → 6240 (115 %) | 446 → 452 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4300 → 4554 (106 %) | 347 → 374 (108 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 8108 → 8445 (104 %) | 789 → 802 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 22367 → 23978 (107 %) | 2541 → 2552 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 15977 → 17407 (109 %) | 2055 → 2068 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 15053 → 16374 (109 %) | 1849 → 1866 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 16798 → 18117 (108 %) | 2036 → 2044 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 15803 → 17179 (109 %) | 1991 → 2006 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 16090 → 17579 (109 %) | 2067 → 2082 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 15363 → 16835 (110 %) | 1931 → 1947 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 8322 → 8222 (99 %) | 947 → 973 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 12972 → 13595 (105 %) | 1357 → 1363 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 11969 → 12359 (103 %) | 1252 → 1247 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 12109 → 12557 (104 %) | 1242 → 1238 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 12072 → 12551 (104 %) | 1265 → 1266 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 12331 → 12690 (103 %) | 1289 → 1284 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 11679 → 12240 (105 %) | 1203 → 1197 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 11993 → 12463 (104 %) | 1259 → 1260 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 12051 → 12632 (105 %) | 1291 → 1288 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 13702 → 14145 (103 %) | 1302 → 1298 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 4409 → 5381 (122 %) | 290 → 412 (142 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 18326 → 18154 (99 %) | 1936 → 1948 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 17092 → 17702 (104 %) | 1899 → 1911 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 13945 → 14181 (102 %) | 1426 → 1416 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 16421 → 16929 (103 %) | 1803 → 1807 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 16064 → 16401 (102 %) | 1787 → 1785 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 16280 → 16766 (103 %) | 1775 → 1773 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 15802 → 16492 (104 %) | 1714 → 1721 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 16296 → 16697 (102 %) | 1759 → 1764 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 15983 → 16279 (102 %) | 1742 → 1740 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 15637 → 16187 (104 %) | 1671 → 1669 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 16041 → 16638 (104 %) | 1740 → 1747 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 15922 → 16383 (103 %) | 1739 → 1742 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 9030 → 9105 (101 %) | 1089 → 1115 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4840 → 5106 (105 %) | 368 → 380 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 4009 → 5263 (131 %) | 390 → 539 (138 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3884 → 5549 (143 %) | 380 → 609 (160 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3457 → 4432 (128 %) | 326 → 459 (141 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4651 → 4967 (107 %) | 296 → 315 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 7056 → 8061 (114 %) | 820 → 844 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6968 → 7928 (114 %) | 752 → 757 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6939 → 8191 (118 %) | 722 → 746 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 13920 → 14228 (102 %) | 1419 → 1411 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 13871 → 14014 (101 %) | 1412 → 1404 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 13435 → 13878 (103 %) | 1390 → 1382 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 13244 → 13464 (102 %) | 1337 → 1329 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 13573 → 13982 (103 %) | 1402 → 1394 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 14142 → 14467 (102 %) | 1430 → 1422 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 13448 → 13827 (103 %) | 1355 → 1347 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 375 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 13402 → 13862 (103 %) | 1039 → 1125 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9002 → 10340 (115 %) | 932 → 951 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 7837 → 9025 (115 %) | 1019 → 1039 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6173 → 6316 (102 %) | 594 → 639 (108 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 5147 → 5976 (116 %) | 446 → 452 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4175 → 4429 (106 %) | 347 → 374 (108 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 7784 → 8017 (103 %) | 789 → 802 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 20090 → 21798 (109 %) | 2541 → 2552 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 14541 → 15982 (110 %) | 2055 → 2068 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 13666 → 15114 (111 %) | 1849 → 1866 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 15216 → 16600 (109 %) | 2036 → 2044 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 14360 → 15898 (111 %) | 1991 → 2006 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 14559 → 16187 (111 %) | 2067 → 2082 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 14029 → 15626 (111 %) | 1931 → 1947 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 7285 → 7485 (103 %) | 947 → 973 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 11568 → 12400 (107 %) | 1357 → 1363 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 10618 → 11281 (106 %) | 1252 → 1247 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 10758 → 11319 (105 %) | 1242 → 1238 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 10687 → 11439 (107 %) | 1265 → 1266 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 10944 → 11492 (105 %) | 1289 → 1284 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 10599 → 11157 (105 %) | 1203 → 1197 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 10662 → 11406 (107 %) | 1259 → 1260 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 10736 → 11461 (107 %) | 1291 → 1288 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 12442 → 13181 (106 %) | 1302 → 1298 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 4257 → 5195 (122 %) | 290 → 412 (142 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 16603 → 16696 (101 %) | 1936 → 1948 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 14937 → 16195 (108 %) | 1899 → 1911 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 12426 → 12999 (105 %) | 1426 → 1416 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 14479 → 15308 (106 %) | 1803 → 1807 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 14319 → 14937 (104 %) | 1787 → 1785 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 14567 → 15289 (105 %) | 1775 → 1773 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 14211 → 14928 (105 %) | 1714 → 1721 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 14408 → 15195 (105 %) | 1759 → 1764 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 14389 → 15043 (105 %) | 1742 → 1740 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 14071 → 14733 (105 %) | 1671 → 1669 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 14172 → 15048 (106 %) | 1740 → 1747 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 14145 → 15018 (106 %) | 1739 → 1742 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 8257 → 8287 (100 %) | 1089 → 1115 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4729 → 4870 (103 %) | 368 → 380 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 3759 → 4962 (132 %) | 390 → 539 (138 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3607 → 5189 (144 %) | 380 → 609 (160 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3263 → 4140 (127 %) | 326 → 459 (141 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4579 → 4872 (106 %) | 296 → 315 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 6564 → 7546 (115 %) | 820 → 844 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6427 → 7331 (114 %) | 752 → 757 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6450 → 7677 (119 %) | 722 → 746 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 12481 → 13014 (104 %) | 1419 → 1411 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 12309 → 12959 (105 %) | 1412 → 1404 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 12218 → 12839 (105 %) | 1390 → 1382 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 11930 → 12510 (105 %) | 1337 → 1329 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 12220 → 12764 (104 %) | 1402 → 1394 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 12771 → 13461 (105 %) | 1430 → 1422 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 12128 → 12865 (106 %) | 1355 → 1347 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 768 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 9599 → 10125 (105 %) | 1044 → 1130 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 6338 → 7715 (122 %) | 937 → 956 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4934 → 5796 (117 %) | 1024 → 1044 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 3895 → 4207 (108 %) | 599 → 644 (108 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 3771 → 4315 (114 %) | 451 → 457 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 3072 → 3413 (111 %) | 352 → 379 (108 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 4646 → 4738 (102 %) | 794 → 807 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 13602 → 14254 (105 %) | 2546 → 2557 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 9731 → 11175 (115 %) | 2060 → 2073 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 9333 → 10739 (115 %) | 1854 → 1871 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 10240 → 11702 (114 %) | 2041 → 2049 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 9755 → 11308 (116 %) | 1996 → 2011 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 9859 → 11378 (115 %) | 2072 → 2087 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 9592 → 11061 (115 %) | 1936 → 1952 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4546 → 4795 (105 %) | 952 → 978 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 7007 → 8075 (115 %) | 1362 → 1368 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6737 → 7599 (113 %) | 1257 → 1252 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6801 → 7681 (113 %) | 1247 → 1243 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6789 → 7660 (113 %) | 1270 → 1271 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6924 → 7788 (112 %) | 1294 → 1289 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6593 → 7445 (113 %) | 1208 → 1202 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6826 → 7686 (113 %) | 1264 → 1265 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6807 → 7637 (112 %) | 1296 → 1293 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 7516 → 8402 (112 %) | 1307 → 1303 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 3125 → 3773 (121 %) | 295 → 417 (141 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 10152 → 10491 (103 %) | 1941 → 1953 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 9732 → 11106 (114 %) | 1904 → 1916 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 8394 → 9223 (110 %) | 1431 → 1421 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 9350 → 10351 (111 %) | 1808 → 1812 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 9301 → 10353 (111 %) | 1792 → 1790 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 9431 → 10432 (111 %) | 1780 → 1778 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 9300 → 10351 (111 %) | 1719 → 1726 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 9305 → 10353 (111 %) | 1764 → 1769 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 9376 → 10439 (111 %) | 1747 → 1745 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 9133 → 10217 (112 %) | 1676 → 1674 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 9312 → 10371 (111 %) | 1745 → 1752 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 9205 → 10308 (112 %) | 1744 → 1747 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 5491 → 5415 (99 %) | 1094 → 1120 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 3462 → 3368 (97 %) | 373 → 385 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2635 → 3371 (128 %) | 395 → 544 (138 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 2550 → 3502 (137 %) | 385 → 614 (159 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 2329 → 2746 (118 %) | 331 → 464 (140 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 2714 → 3022 (111 %) | 301 → 320 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4839 → 5632 (116 %) | 825 → 849 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4697 → 5462 (116 %) | 757 → 762 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4912 → 5736 (117 %) | 727 → 751 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 8505 → 9288 (109 %) | 1424 → 1416 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 8162 → 9115 (112 %) | 1417 → 1409 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 8142 → 9037 (111 %) | 1395 → 1387 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 8158 → 9037 (111 %) | 1342 → 1334 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 8264 → 9098 (110 %) | 1407 → 1399 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 8550 → 9458 (111 %) | 1435 → 1427 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 8187 → 9060 (111 %) | 1360 → 1352 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 1024 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 7817 → 8028 (103 %) | 1044 → 1128 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5748 → 5987 (104 %) | 937 → 954 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4404 → 4795 (109 %) | 1024 → 1042 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 3408 → 3358 (99 %) | 599 → 642 (107 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 3089 → 3303 (107 %) | 451 → 455 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 2277 → 2362 (104 %) | 352 → 377 (107 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 4284 → 3565 (83 %) | 794 → 805 (101 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11513 → 11664 (101 %) | 2546 → 2555 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 8138 → 8264 (102 %) | 2060 → 2071 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7706 → 7871 (102 %) | 1854 → 1869 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8584 → 8766 (102 %) | 2041 → 2047 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 8065 → 8234 (102 %) | 1996 → 2009 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 8322 → 8371 (101 %) | 2072 → 2085 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7952 → 8151 (103 %) | 1936 → 1950 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4284 → 4091 (95 %) | 952 → 976 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6507 → 6730 (103 %) | 1362 → 1366 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6176 → 6236 (101 %) | 1257 → 1250 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6309 → 6354 (101 %) | 1247 → 1241 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6296 → 6382 (101 %) | 1270 → 1269 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6401 → 6451 (101 %) | 1294 → 1287 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6049 → 6108 (101 %) | 1208 → 1200 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6295 → 6389 (101 %) | 1264 → 1263 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6367 → 6461 (101 %) | 1296 → 1291 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6811 → 6994 (103 %) | 1307 → 1301 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 2337 → 2607 (112 %) | 295 → 415 (141 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8774 → 8964 (102 %) | 1941 → 1951 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8564 → 8827 (103 %) | 1904 → 1914 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7184 → 7266 (101 %) | 1431 → 1419 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8067 → 8278 (103 %) | 1808 → 1810 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8206 → 8343 (102 %) | 1792 → 1788 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8212 → 8427 (103 %) | 1780 → 1776 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8099 → 8287 (102 %) | 1719 → 1724 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8245 → 8378 (102 %) | 1764 → 1767 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8024 → 8253 (103 %) | 1747 → 1743 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8042 → 8243 (102 %) | 1676 → 1672 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8087 → 8363 (103 %) | 1745 → 1750 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8116 → 8231 (101 %) | 1744 → 1745 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4555 → 4655 (102 %) | 1094 → 1118 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2680 → 2789 (104 %) | 373 → 383 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2302 → 2783 (121 %) | 395 → 542 (137 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 2232 → 2942 (132 %) | 385 → 612 (159 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 2021 → 2186 (108 %) | 331 → 462 (140 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 2335 → 2177 (93 %) | 301 → 318 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4658 → 4985 (107 %) | 825 → 847 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4607 → 4818 (105 %) | 757 → 760 (100 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4800 → 5153 (107 %) | 727 → 749 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7197 → 7361 (102 %) | 1424 → 1414 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7063 → 7206 (102 %) | 1417 → 1407 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7066 → 7236 (102 %) | 1395 → 1385 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6950 → 7102 (102 %) | 1342 → 1332 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 7002 → 7165 (102 %) | 1407 → 1397 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7329 → 7507 (102 %) | 1435 → 1425 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6940 → 7158 (103 %) | 1360 → 1350 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 1440 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 7825 → 7943 (102 %) | 1058 → 1145 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 6026 (103 %) | 951 → 971 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4047 → 4328 (107 %) | 1038 → 1059 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2938 → 3103 (106 %) | 613 → 659 (108 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 3309 (117 %) | 465 → 472 (102 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 1947 → 2217 (114 %) | 366 → 394 (108 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3510 → 3546 (101 %) | 808 → 822 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11038 (99 %) | 2560 → 2572 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7745 → 8036 (104 %) | 2074 → 2088 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7484 → 7615 (102 %) | 1868 → 1886 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8321 → 8467 (102 %) | 2055 → 2064 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7684 → 7817 (102 %) | 2010 → 2026 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7955 → 8244 (104 %) | 2086 → 2102 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 7686 (101 %) | 1950 → 1967 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4095 → 3867 (94 %) | 966 → 993 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 6654 (103 %) | 1376 → 1383 (101 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 6405 (104 %) | 1271 → 1267 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 6486 (103 %) | 1261 → 1258 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 6485 (103 %) | 1284 → 1286 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 6549 (103 %) | 1308 → 1304 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 6235 (103 %) | 1222 → 1217 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 6514 (104 %) | 1278 → 1280 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 6551 (103 %) | 1310 → 1308 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 6585 (98 %) | 1321 → 1318 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 2492 (130 %) | 309 → 432 (140 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 8720 (101 %) | 1955 → 1968 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 8501 (100 %) | 1918 → 1931 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 7054 (99 %) | 1445 → 1436 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8076 → 8180 (101 %) | 1822 → 1827 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8199 → 8158 (99 %) | 1806 → 1805 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8205 → 8316 (101 %) | 1794 → 1793 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8077 → 8126 (101 %) | 1733 → 1741 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8211 → 8245 (100 %) | 1778 → 1784 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8062 → 8178 (101 %) | 1761 → 1760 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8072 → 8086 (100 %) | 1690 → 1689 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8089 → 8208 (101 %) | 1759 → 1767 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8098 → 8124 (100 %) | 1758 → 1762 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4433 → 4561 (103 %) | 1108 → 1135 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2394 → 2584 (108 %) | 387 → 400 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 2763 (137 %) | 409 → 559 (137 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 2935 (152 %) | 399 → 629 (158 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2159 (126 %) | 345 → 479 (139 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2078 (105 %) | 315 → 335 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 5070 (112 %) | 839 → 864 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 4898 (110 %) | 771 → 777 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 5235 (113 %) | 741 → 766 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7164 → 7119 (99 %) | 1438 → 1431 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7115 → 7148 (100 %) | 1431 → 1424 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7031 → 7054 (100 %) | 1409 → 1402 (100 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6942 → 6975 (100 %) | 1356 → 1349 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6995 → 6980 (100 %) | 1421 → 1414 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7322 → 7396 (101 %) | 1449 → 1442 (100 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6993 → 7092 (101 %) | 1374 → 1367 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 1920 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 7855 → 7974 (102 %) | 1058 → 1145 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5857 → 6026 (103 %) | 951 → 971 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4060 → 4328 (107 %) | 1038 → 1059 (102 %) | 12 → 14 | 15 → 36 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2941 → 3103 (106 %) | 613 → 659 (108 %) | 3 → 5 | 15 → 40 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 3310 (117 %) | 465 → 472 (102 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 1947 → 2217 (114 %) | 366 → 394 (108 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3511 → 3546 (101 %) | 808 → 822 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11038 (99 %) | 2560 → 2572 (100 %) | 44 → 46 | 29 → 70 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7756 → 8041 (104 %) | 2074 → 2088 (101 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7494 → 7621 (102 %) | 1868 → 1886 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8337 → 8472 (102 %) | 2055 → 2064 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7694 → 7822 (102 %) | 2010 → 2026 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7966 → 8249 (104 %) | 2086 → 2102 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7598 → 7691 (101 %) | 1950 → 1967 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4107 → 3867 (94 %) | 966 → 993 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 6657 (103 %) | 1376 → 1383 (101 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 6408 (104 %) | 1271 → 1267 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 6489 (103 %) | 1261 → 1258 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 6488 (103 %) | 1284 → 1286 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 6552 (103 %) | 1308 → 1304 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 6238 (103 %) | 1222 → 1217 (100 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 6517 (104 %) | 1278 → 1280 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 6553 (103 %) | 1310 → 1308 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 6585 (98 %) | 1321 → 1318 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 2492 (130 %) | 309 → 432 (140 %) | 1 → 5 | 15 → 38 | 3 → 4 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8675 → 8720 (101 %) | 1955 → 1968 (101 %) | 17 → 19 | 27 → 69 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8509 → 8503 (100 %) | 1918 → 1931 (101 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7107 → 7057 (99 %) | 1445 → 1436 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8077 → 8182 (101 %) | 1822 → 1827 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8201 → 8160 (100 %) | 1806 → 1805 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8206 → 8318 (101 %) | 1794 → 1793 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8078 → 8129 (101 %) | 1733 → 1741 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8213 → 8248 (100 %) | 1778 → 1784 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8064 → 8180 (101 %) | 1761 → 1760 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8074 → 8089 (100 %) | 1690 → 1689 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8090 → 8211 (101 %) | 1759 → 1767 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8100 → 8127 (100 %) | 1758 → 1762 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4445 → 4561 (103 %) | 1108 → 1135 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2406 → 2584 (107 %) | 387 → 400 (103 %) | 5 → 7 | 19 → 36 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 2766 (137 %) | 409 → 559 (137 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 2938 (152 %) | 399 → 629 (158 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2163 (126 %) | 345 → 479 (139 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2081 (105 %) | 315 → 335 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 5073 (112 %) | 839 → 864 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 4901 (110 %) | 771 → 777 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 5239 (113 %) | 741 → 766 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7166 → 7122 (99 %) | 1438 → 1431 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7117 → 7150 (100 %) | 1431 → 1424 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7032 → 7057 (100 %) | 1409 → 1402 (100 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6944 → 6978 (100 %) | 1356 → 1349 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6996 → 6983 (100 %) | 1421 → 1414 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7323 → 7398 (101 %) | 1449 → 1442 (100 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6995 → 7094 (101 %) | 1374 → 1367 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | — |

## Détail bloc par bloc à 320 px

### `#/` → `/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Nettoyage professionnel de bureaux et locaux e | Nettoyage professionnel de bureaux et locaux e | 984 → 1138 | ⚠️ écart +154 px |
| 2 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique, indiqué avant ) | 306 → 320 | ≈ proche |
| 3 | (★★★★★5,0/5 sur Google Saint-Apollinair) | (Saint-Apollinaire Entreprise régionale) | 511 → 547 | ≈ proche |
| 4 | Pensé pour les professionnels de la région | Pensé pour les professionnels de la région | 569 → 558 | ≈ proche |
| 5 | Nos prestations de nettoyage | Nos prestations de nettoyage | 1472 → 1444 | ≈ proche |
| 6 | Les difficultés que nous prenons en charge | Les difficultés que nous prenons en charge | 1002 → 1020 | ≈ proche |
| 7 | Pourquoi Top-Famille Pro | Pourquoi Top-Famille Pro | 1161 → 1073 | ⚠️ écart -88 px |
| 8 | Notre fonctionnement, en cinq temps | Notre fonctionnement, en cinq temps | 1119 → 993 | ⚠️ écart -126 px |
| 9 | Un tarif clair, affiché avant le devis | Un tarif clair, affiché avant le devis | 904 → 884 | ≈ proche |
| 10 | Une couverture régionale, pas des agences fict | Une couverture régionale, pas des agences fict | 1152 → 1193 | ≈ proche |
| 11 | Audrey, votre interlocutrice | Audrey, votre interlocutrice | 923 → 1210 | ⚠️ écart +287 px |
| 12 | Conseils & repères | Conseils & repères | 1316 → 1410 | ⚠️ écart +94 px |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 454 → 459 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 47 | ✅ identique |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 460 → 597 | ⚠️ écart +137 px |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 486 → 492 | ✅ identique |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 330 → 372 | ≈ proche |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 200 → 295 | ⚠️ écart +95 px |
| 6 | Le détail de nos frais | Le détail de nos frais | 735 → 677 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 627 → 945 | ⚠️ écart +318 px |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 541 → 687 | ⚠️ écart +146 px |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 1305 → 1467 | ⚠️ écart +162 px |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 651 → 703 | ≈ proche |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 863 → 957 | ⚠️ écart +94 px |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 828 → 934 | ⚠️ écart +106 px |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 343 → 363 | ≈ proche |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 47 | ✅ identique |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 542 → 1018 | ⚠️ écart +476 px |
| 3 | (Directement joignableAudrey est votre ) | (Directement joignableAudrey est votre ) | 1265 → 1304 | ≈ proche |
| 4 | Des preuves plutôt que des slogans | Des preuves plutôt que des slogans | 836 → 950 | ⚠️ écart +114 px |
| 5 | Ce qui nous distingue, concrètement | Ce qui nous distingue, concrètement | 2136 → 2512 | ⚠️ écart +376 px |
| 6 | Les objections que l'on nous adresse | Les objections que l'on nous adresse | 626 → 574 | ≈ proche |
| 7 | Vérifier par vous-même | Vérifier par vous-même | 745 → 775 | ≈ proche |
| 8 | Faisons connaissance | Faisons connaissance | 335 → 125 | ⚠️ écart -210 px |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (Accueil/Avis clients) | 42 → 47 | ✅ identique |
| 2 | Avis de nos clients | Avis de nos clients | 233 → 589 | ⚠️ écart +356 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | (5,0/5★★★★★Sur · avis clientsGoogle47De) | 223 → 261 | ≈ proche |
| 4 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 771 → 874 | ⚠️ écart +103 px |
| 5 | (★★★★★Google« Même intervenante chaque ) | (Exemples de présentation — témoignages) | 2167 → 1625 | ⚠️ écart -542 px |
| 6 | Un avis ne remplace pas un devis | Un avis ne remplace pas un devis | 662 → 683 | ≈ proche |
| 7 | À votre tour ? | À votre tour ? | 335 → 125 | ⚠️ écart -210 px |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 47 | ✅ identique |
| 2 | Conseils & repères | Conseils & repères | 483 → 673 | ⚠️ écart +190 px |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 115 → 195 | ⚠️ écart +80 px |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 606 → 560 | ≈ proche |
| 5 | Les autres articles | Les autres articles | 970 → 1081 | ⚠️ écart +111 px |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 739 → 899 | ⚠️ écart +160 px |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 265 → 381 | ⚠️ écart +116 px |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Demandez votre devis gratuit | (Aller au contenu principal) | 900 → 52 | ⚠️ écart -848 px |
| 2 | — | Demandez votre devis gratuit | — → 4473 | ➕ en plus côté WordPress |
| 3 | — | (☎ Appeler Demander mon devis) | — → 81 | ➕ en plus côté WordPress |
| 4 | — | () | — → 81 | ➕ en plus côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 47 | ✅ identique |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 650 → 1211 | ⚠️ écart +561 px |
| 3 | Comment choisir la bonne prestation ? | Comment choisir la bonne prestation ? | 931 → 914 | ≈ proche |
| 4 | Ce qui est commun aux six prestations | Ce qui est commun aux six prestations | 914 → 1020 | ⚠️ écart +106 px |
| 5 | (Nettoyage de bureauxUn entretien régul) | (Nettoyage de bureauxUn entretien régul) | 2955 → 2673 | ⚠️ écart -282 px |
| 6 | Besoin d'aide pour choisir ? | Besoin d'aide pour choisir ? | 386 → 178 | ⚠️ écart -208 px |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 47 | ✅ identique |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 952 → 956 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 342 → 311 | ≈ proche |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 759 → 816 | ≈ proche |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 1218 → 1455 | ⚠️ écart +237 px |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 1616 → 1723 | ⚠️ écart +107 px |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 1038 → 1280 | ⚠️ écart +242 px |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 1900 → 1992 | ⚠️ écart +92 px |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 1706 → 1859 | ⚠️ écart +153 px |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 2006 → 2289 | ⚠️ écart +283 px |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 969 → 1084 | ⚠️ écart +115 px |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 1843 → 1972 | ⚠️ écart +129 px |
| 13 | Cahier des charges, intervenants et suivi | Cahier des charges, intervenants et suivi | 970 → 755 | ⚠️ écart -215 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 452 → 620 | ⚠️ écart +168 px |
| 15 | Trois situations concrètes | Trois situations concrètes | 1332 → 1425 | ⚠️ écart +93 px |
| 16 | Le tarif, en toute transparence | Le tarif, en toute transparence | 932 → 1161 | ⚠️ écart +229 px |
| 17 | Pour aller plus loin | Pour aller plus loin | 450 → 501 | ≈ proche |
| 18 | Questions fréquentes | Questions fréquentes | 1241 → 1161 | ⚠️ écart -80 px |
| 19 | Un projet d'entretien pour vos locaux ? | Un projet d'entretien pour vos locaux ? | 371 → 150 | ⚠️ écart -221 px |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Bureaux) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 905 → 1039 | ⚠️ écart +134 px |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Le nettoyage de bureau) | 535 → 604 | ⚠️ écart +69 px |
| 4 | Pour qui ? | Pour qui ? | 1409 → 1386 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 620 → 699 | ⚠️ écart +79 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1399 → 1610 | ⚠️ écart +211 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 3107 → 3354 | ⚠️ écart +247 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1993 → 2256 | ⚠️ écart +263 px |
| 9 | Une semaine type | Une semaine type | 944 → 993 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 612 → 711 | ⚠️ écart +99 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 12 | Questions fréquentes — Bureaux | Questions fréquentes — Bureaux | 1042 → 926 | ⚠️ écart -116 px |
| 13 | (Encore une question sur Bureaux ? Audr) | (Encore une question sur Bureaux ? Audr) | 156 → 288 | ⚠️ écart +132 px |
| 14 | Un devis pour Bureaux | Un devis pour Bureaux | 332 → 367 | ≈ proche |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Commerces) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 821 → 943 | ⚠️ écart +122 px |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe La propreté d'un comme) | 484 → 577 | ⚠️ écart +93 px |
| 4 | Pour qui ? | Pour qui ? | 1171 → 1196 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 620 → 699 | ⚠️ écart +79 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1424 → 1555 | ⚠️ écart +131 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2807 → 3035 | ⚠️ écart +228 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1773 → 1957 | ⚠️ écart +184 px |
| 9 | Une semaine type | Une semaine type | 916 → 964 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 666 → 736 | ⚠️ écart +70 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 12 | Questions fréquentes — Commerces | Questions fréquentes — Commerces | 913 → 859 | ≈ proche |
| 13 | (Encore une question sur Commerces ? Au) | (Encore une question sur Commerces ? Au) | 180 → 288 | ⚠️ écart +108 px |
| 14 | Un devis pour Commerces | Un devis pour Commerces | 357 → 392 | ≈ proche |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Cabinets) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 876 → 1071 | ⚠️ écart +195 px |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe Un cabinet reçoit du p) | 740 → 821 | ⚠️ écart +81 px |
| 4 | Pour qui ? | Pour qui ? | 1378 → 1393 | ≈ proche |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que Top-Famille Pro ne réalise pas | 999 → 912 | ⚠️ écart -87 px |
| 6 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 745 → 835 | ⚠️ écart +90 px |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1399 → 1583 | ⚠️ écart +184 px |
| 8 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2679 → 2899 | ⚠️ écart +220 px |
| 9 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1900 → 2120 | ⚠️ écart +220 px |
| 10 | Une semaine type | Une semaine type | 916 → 992 | ⚠️ écart +76 px |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 689 → 736 | ≈ proche |
| 12 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 13 | Questions fréquentes — Cabinets | Questions fréquentes — Cabinets | 1068 → 926 | ⚠️ écart -142 px |
| 14 | (Encore une question sur Cabinets ? Aud) | (Encore une question sur Cabinets ? Aud) | 156 → 288 | ⚠️ écart +132 px |
| 15 | Un devis pour Cabinets | Un devis pour Cabinets | 332 → 367 | ≈ proche |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Copropriétés) | 42 → 47 | ✅ identique |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 848 → 943 | ⚠️ écart +95 px |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe Nous travaillons avec ) | 484 → 549 | ⚠️ écart +65 px |
| 4 | Pour qui ? | Pour qui ? | 1345 → 1349 | ✅ identique |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 644 → 726 | ⚠️ écart +82 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1438 → 1679 | ⚠️ écart +241 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 3028 → 3278 | ⚠️ écart +250 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1726 → 1929 | ⚠️ écart +203 px |
| 9 | Une semaine type | Une semaine type | 1047 → 1102 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 689 → 761 | ⚠️ écart +72 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 12 | Questions fréquentes — Copropriétés | Questions fréquentes — Copropriétés | 1095 → 1009 | ⚠️ écart -86 px |
| 13 | (Encore une question sur Copropriétés ?) | (Encore une question sur Copropriétés ?) | 180 → 288 | ⚠️ écart +108 px |
| 14 | Un devis pour Copropriétés | Un devis pour Copropriétés | 357 → 392 | ≈ proche |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Locations meublées) | 42 → 78 | ≈ proche |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 876 → 1039 | ⚠️ écart +163 px |
| 3 | (Réponse directePour les locations meub) | (Réponse directe Pour les locations meu) | 663 → 767 | ⚠️ écart +104 px |
| 4 | Pour qui ? | Pour qui ? | 1321 → 1322 | ✅ identique |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 695 → 781 | ⚠️ écart +86 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1419 → 1603 | ⚠️ écart +184 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 3030 → 3272 | ⚠️ écart +242 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1845 → 2120 | ⚠️ écart +275 px |
| 9 | Une semaine type | Une semaine type | 1021 → 1075 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 693 → 762 | ⚠️ écart +69 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 12 | Questions fréquentes — Locations meublées | Questions fréquentes — Locations meublées | 1068 → 954 | ⚠️ écart -114 px |
| 13 | (Encore une question sur Locations meub) | (Encore une question sur Locations meub) | 180 → 288 | ⚠️ écart +108 px |
| 14 | Un devis pour Locations meublées | Un devis pour Locations meublées | 357 → 392 | ≈ proche |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 47 | ✅ identique |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 819 → 975 | ⚠️ écart +156 px |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 509 → 604 | ⚠️ écart +95 px |
| 4 | Pour qui ? | Pour qui ? | 1192 → 1227 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 570 → 645 | ⚠️ écart +75 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1424 → 1610 | ⚠️ écart +186 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 3130 → 3386 | ⚠️ écart +256 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1555 → 1739 | ⚠️ écart +184 px |
| 9 | Une semaine type | Une semaine type | 1047 → 1102 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 666 → 736 | ⚠️ écart +70 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 651 → 724 | ⚠️ écart +73 px |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 1042 → 981 | ⚠️ écart -61 px |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 156 → 288 | ⚠️ écart +132 px |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 332 → 367 | ≈ proche |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Notre fonctionnement) | (Accueil/Notre fonctionnement) | 42 → 47 | ✅ identique |
| 2 | Notre fonctionnement | Notre fonctionnement | 463 → 954 | ⚠️ écart +491 px |
| 3 | (01Prise de contactVous nous décrivez v) | (01 Prise de contactVous nous décrivez ) | 2453 → 1699 | ⚠️ écart -754 px |
| 4 | Les informations dont nous avons besoin | Les informations dont nous avons besoin | 2872 → 2995 | ⚠️ écart +123 px |
| 5 | Prêt à démarrer ? | Prêt à démarrer ? | 264 → 125 | ⚠️ écart -139 px |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 576 → 654 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | (Réponse directe La Côte-d'Or est notre) | 398 → 464 | ⚠️ écart +66 px |
| 5 | Notre couverture en Côte-d'Or | Notre couverture en Côte-d'Or | 3117 → 3022 | ⚠️ écart -95 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1391 → 1499 | ⚠️ écart +108 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 1141 → 1286 | ⚠️ écart +145 px |
| 8 | Entretien régulier ou intervention ponctuelle | Entretien régulier ou intervention ponctuelle | 2312 → 2214 | ⚠️ écart -98 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 246 → 382 | ⚠️ écart +136 px |
| 10 | Questions fréquentes — Côte-d'Or | Questions fréquentes — Côte-d'Or | 780 → 770 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 631 → 686 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeDans le Doubs, notre se) | (Réponse directe Dans le Doubs, notre s) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Notre couverture dans le Doubs | Notre couverture dans le Doubs | 2260 → 2174 | ⚠️ écart -86 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1041 → 977 | ⚠️ écart -64 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 1133 → 1228 | ⚠️ écart +95 px |
| 8 | Les cabinets de santé : ce que nous faisons, c | Les cabinets de santé : ce que nous faisons, c | 2470 → 2405 | ⚠️ écart -65 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 246 → 382 | ⚠️ écart +136 px |
| 10 | Questions fréquentes — Doubs | Questions fréquentes — Doubs | 753 → 742 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 576 → 654 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeDans le Jura, nous inte) | (Réponse directe Dans le Jura, nous int) | 372 → 437 | ⚠️ écart +65 px |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Deux bassins distincts : Dole et Lons-le-Sauni | 2816 → 2714 | ⚠️ écart -102 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1161 → 1034 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 1043 → 1124 | ⚠️ écart +81 px |
| 8 | Fonctionnement et suivi | Fonctionnement et suivi | 2183 → 2140 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 192 → 438 | ⚠️ écart +246 px |
| 10 | Questions fréquentes — Jura | Questions fréquentes — Jura | 753 → 742 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 576 → 654 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeDans la Nièvre, notre s) | (Réponse directe Dans la Nièvre, notre ) | 372 → 464 | ⚠️ écart +92 px |
| 5 | Notre couverture dans la Nièvre | Notre couverture dans la Nièvre | 2909 → 2684 | ⚠️ écart -225 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1090 → 1034 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 1064 → 1176 | ⚠️ écart +112 px |
| 8 | Organisation des déplacements | Organisation des déplacements | 2130 → 2084 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 192 → 438 | ⚠️ écart +246 px |
| 10 | Questions fréquentes — Nièvre | Questions fréquentes — Nièvre | 726 → 742 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 576 → 654 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeEn Haute-Saône, notre s) | (Réponse directe En Haute-Saône, notre ) | 398 → 464 | ⚠️ écart +66 px |
| 5 | Notre couverture en Haute-Saône | Notre couverture en Haute-Saône | 2906 → 2770 | ⚠️ écart -136 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1090 → 1034 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 1116 → 1232 | ⚠️ écart +116 px |
| 8 | Accès, clés et interventions hors horaires | Accès, clés et interventions hors horaires | 2181 → 2135 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 299 → 382 | ⚠️ écart +83 px |
| 10 | Questions fréquentes — Haute-Saône | Questions fréquentes — Haute-Saône | 753 → 715 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 576 → 654 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | (Réponse directe En Saône-et-Loire, nos) | 398 → 464 | ⚠️ écart +66 px |
| 5 | Deux bassins le long de l'axe Saône | Deux bassins le long de l'axe Saône | 2210 → 2139 | ⚠️ écart -71 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1161 → 1034 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 1040 → 1200 | ⚠️ écart +160 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Industrie, agroalimentaire et viticulture : ce | 2229 → 2237 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 246 → 382 | ⚠️ écart +136 px |
| 10 | Questions fréquentes — Saône-et-Loire | Questions fréquentes — Saône-et-Loire | 807 → 825 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 549 → 622 | ⚠️ écart +73 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeDans l'Yonne, notre sec) | (Réponse directe Dans l'Yonne, notre se) | 372 → 437 | ⚠️ écart +65 px |
| 5 | Notre couverture dans l'Yonne | Notre couverture dans l'Yonne | 2826 → 2686 | ⚠️ écart -140 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1090 → 1034 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 1069 → 1230 | ⚠️ écart +161 px |
| 8 | Fonctionnement et suivi à distance | Fonctionnement et suivi à distance | 2130 → 2000 | ⚠️ écart -130 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 192 → 438 | ⚠️ écart +246 px |
| 10 | Questions fréquentes — Yonne | Questions fréquentes — Yonne | 753 → 742 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 414 | ≈ proche |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 549 → 674 | ⚠️ écart +125 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeDans le Territoire de B) | (Réponse directe Dans le Territoire de ) | 372 → 437 | ⚠️ écart +65 px |
| 5 | Un département compact, entièrement autour de  | Un département compact, entièrement autour de  | 2987 → 2793 | ⚠️ écart -194 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 993 → 977 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 1069 → 1204 | ⚠️ écart +135 px |
| 8 | Interventions en soirée : comment cela s'organ | Interventions en soirée : comment cela s'organ | 2178 → 2158 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 192 → 382 | ⚠️ écart +190 px |
| 10 | Questions fréquentes — Territoire de Belfort | Questions fréquentes — Territoire de Belfort | 726 → 715 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 401 | ≈ proche |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 47 | ✅ identique |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 565 → 784 | ⚠️ écart +219 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 332 → 295 | ≈ proche |
| 4 | (Réponse directeNous intervenons unique) | (Réponse directeNous intervenons unique) | 449 → 513 | ⚠️ écart +64 px |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 2740 → 2688 | ≈ proche |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | (Bourgogne-Franche-ComtéLa page régiona) | 291 → 157 | ⚠️ écart -134 px |
| 7 | Les huit départements | Les huit départements | 1295 → 1294 | ✅ identique |
| 8 | Nos dix villes principales | Nos dix villes principales | 842 → 1128 | ⚠️ écart +286 px |
| 9 | Premières communes secondaires | Premières communes secondaires | 709 → 948 | ⚠️ écart +239 px |
| 10 | Départements, villes et communes : comment lir | Départements, villes et communes : comment lir | 2493 → 2353 | ⚠️ écart -140 px |
| 11 | (Découvrir nos prestationsBureaux, comm) | (Découvrir nos prestations Bureaux, com) | 465 → 460 | ✅ identique |
| 12 | Questions fréquentes sur nos zones d'intervent | Questions fréquentes sur nos zones d'intervent | 780 → 723 | ≈ proche |
| 13 | Votre commune est-elle couverte ? | Votre commune est-elle couverte ? | 470 → 316 | ⚠️ écart -154 px |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Contact) | (Accueil/Contact) | 42 → 47 | ✅ identique |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 205 → 311 | ⚠️ écart +106 px |
| 3 | (J'ai une question Formulaire court, ré) | (J’ai une question Formulaire court, ré) | 281 → 371 | ⚠️ écart +90 px |
| 4 | (Nom Entreprise (facultatif) E-mail Tél) | J’ai une question | 1653 → 2249 | ⚠️ écart +596 px |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 832 → 784 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 332 → 295 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directeTop-Famille Pro est une) | 423 → 485 | ⚠️ écart +62 px |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Notre implantation réelle : Saint-Apollinaire, | 4381 → 4244 | ⚠️ écart -137 px |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Nos prestations partout en Bourgogne-Franche-C | 1144 → 1174 | ≈ proche |
| 7 | Les huit départements couverts | Les huit départements couverts | 2162 → 1940 | ⚠️ écart -222 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 1027 → 1378 | ⚠️ écart +351 px |
| 9 | Un tarif régional unique | Un tarif régional unique | 1234 → 1280 | ≈ proche |
| 10 | Sélection des intervenants et suivi | Sélection des intervenants et suivi | 3258 → 3059 | ⚠️ écart -199 px |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes — Bourgogne-Franche-Comté | 824 → 843 | ≈ proche |
| 12 | Vos locaux, où que vous soyez en région | Vos locaux, où que vous soyez en région | 415 → 174 | ⚠️ écart -241 px |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 790 → 918 | ⚠️ écart +128 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directe Top-Famille Pro est un) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Une entreprise implantée à Saint-Apollinaire,  | 4386 → 4195 | ⚠️ écart -191 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1208 → 1331 | ⚠️ écart +123 px |
| 8 | Espaces, tâches et fréquences | Espaces, tâches et fréquences | 3196 → 3055 | ⚠️ écart -141 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 893 → 1050 | ⚠️ écart +157 px |
| 10 | Dans le même département | Dans le même département | 814 → 1062 | ⚠️ écart +248 px |
| 11 | Questions fréquentes — Dijon | Questions fréquentes — Dijon | 877 → 810 | ⚠️ écart -67 px |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 762 → 888 | ⚠️ écart +126 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 423 → 518 | ⚠️ écart +95 px |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 2264 → 2127 | ⚠️ écart -137 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1159 → 1257 | ⚠️ écart +98 px |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 2445 → 2354 | ⚠️ écart -91 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 601 → 715 | ⚠️ écart +114 px |
| 10 | Dans le même département | Dans le même département | 907 → 722 | ⚠️ écart -185 px |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 877 → 810 | ⚠️ écart -67 px |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 818 → 932 | ⚠️ écart +114 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 423 → 518 | ⚠️ écart +95 px |
| 5 | Notre positionnement à Besançon | Notre positionnement à Besançon | 3872 → 3766 | ⚠️ écart -106 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1182 → 1282 | ⚠️ écart +100 px |
| 8 | Commerces du centre historique et immeubles an | Commerces du centre historique et immeubles an | 3268 → 3157 | ⚠️ écart -111 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 674 → 799 | ⚠️ écart +125 px |
| 10 | Dans le même département | Dans le même département | 773 → 836 | ⚠️ écart +63 px |
| 11 | Questions fréquentes — Besançon | Questions fréquentes — Besançon | 877 → 837 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 762 → 854 | ⚠️ écart +92 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 398 → 464 | ⚠️ écart +66 px |
| 5 | Notre position sur le bassin dolois | Notre position sur le bassin dolois | 3810 → 3688 | ⚠️ écart -122 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1117 → 1232 | ⚠️ écart +115 px |
| 8 | Fréquences, horaires et matériel | Fréquences, horaires et matériel | 3330 → 3195 | ⚠️ écart -135 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 577 → 743 | ⚠️ écart +166 px |
| 10 | Dans le même département | Dans le même département | 814 → 722 | ⚠️ écart -92 px |
| 11 | Questions fréquentes — Dole | Questions fréquentes — Dole | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 818 → 932 | ⚠️ écart +114 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Notre positionnement à Lons-le-Saunier | Notre positionnement à Lons-le-Saunier | 4028 → 3928 | ⚠️ écart -100 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1116 → 1280 | ⚠️ écart +164 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | Agroalimentaire et thermalisme : notre périmèt | 3192 → 3125 | ⚠️ écart -67 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 577 → 743 | ⚠️ écart +166 px |
| 10 | Dans le même département | Dans le même département | 814 → 722 | ⚠️ écart -92 px |
| 11 | Questions fréquentes — Lons-le-Saunier | Questions fréquentes — Lons-le-Saunier | 780 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 762 → 920 | ⚠️ écart +158 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Notre positionnement à Nevers | Notre positionnement à Nevers | 4023 → 3832 | ⚠️ écart -191 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1141 → 1260 | ⚠️ écart +119 px |
| 8 | Accès aux immeubles et aux locaux | Accès aux immeubles et aux locaux | 2796 → 2794 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 626 → 799 | ⚠️ écart +173 px |
| 10 | Dans le même département | Dans le même département | 773 → 892 | ⚠️ écart +119 px |
| 11 | Questions fréquentes — Nevers | Questions fréquentes — Nevers | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 762 → 920 | ⚠️ écart +158 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 398 → 491 | ⚠️ écart +93 px |
| 5 | Notre positionnement à Vesoul | Notre positionnement à Vesoul | 4053 → 3791 | ⚠️ écart -262 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1182 → 1303 | ⚠️ écart +121 px |
| 8 | Fréquences et créneaux hors horaires | Fréquences et créneaux hors horaires | 3169 → 2971 | ⚠️ écart -198 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 674 → 799 | ⚠️ écart +125 px |
| 10 | Dans le même département | Dans le même département | 773 → 836 | ⚠️ écart +63 px |
| 11 | Questions fréquentes — Vesoul | Questions fréquentes — Vesoul | 780 → 797 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 818 → 932 | ⚠️ écart +114 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 398 → 491 | ⚠️ écart +93 px |
| 5 | Notre positionnement sur le Grand Chalon | Notre positionnement sur le Grand Chalon | 3708 → 3502 | ⚠️ écart -206 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1086 → 1200 | ⚠️ écart +114 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 3279 → 3172 | ⚠️ écart -107 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 626 → 743 | ⚠️ écart +117 px |
| 10 | Dans le même département | Dans le même département | 761 → 722 | ≈ proche |
| 11 | Questions fréquentes — Chalon-sur-Saône | Questions fréquentes — Chalon-sur-Saône | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 762 → 920 | ⚠️ écart +158 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 398 → 464 | ⚠️ écart +66 px |
| 5 | Notre positionnement à Mâcon | Notre positionnement à Mâcon | 3785 → 3719 | ⚠️ écart -66 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1064 → 1202 | ⚠️ écart +138 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 2956 → 2859 | ⚠️ écart -97 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 601 → 771 | ⚠️ écart +170 px |
| 10 | Dans le même département | Dans le même département | 814 → 722 | ⚠️ écart -92 px |
| 11 | Questions fréquentes — Mâcon | Questions fréquentes — Mâcon | 753 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 762 → 888 | ⚠️ écart +126 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 398 → 491 | ⚠️ écart +93 px |
| 5 | Notre positionnement à Auxerre | Notre positionnement à Auxerre | 3782 → 3644 | ⚠️ écart -138 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1064 → 1226 | ⚠️ écart +162 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 3330 → 3167 | ⚠️ écart -163 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 674 → 799 | ⚠️ écart +125 px |
| 10 | Dans le même département | Dans le même département | 773 → 892 | ⚠️ écart +119 px |
| 11 | Questions fréquentes — Auxerre | Questions fréquentes — Auxerre | 753 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 762 → 920 | ⚠️ écart +158 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Notre positionnement à Belfort | Notre positionnement à Belfort | 3895 → 3714 | ⚠️ écart -181 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1116 → 1256 | ⚠️ écart +140 px |
| 8 | Fréquences et créneaux en soirée | Fréquences et créneaux en soirée | 3092 → 2920 | ⚠️ écart -172 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 577 → 743 | ⚠️ écart +166 px |
| 10 | Dans le même département | Dans le même département | 799 → 836 | ≈ proche |
| 11 | Questions fréquentes — Belfort | Questions fréquentes — Belfort | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 47 | ✅ identique |
| 2 | Une entreprise régionale, un visage | Une entreprise régionale, un visage | 1328 → 1543 | ⚠️ écart +215 px |
| 3 | (« Mon rôle, c'est de rester joignable ) | (« Mon rôle, c'est de rester joignable ) | 265 → 311 | ≈ proche |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | (ProximitéBasée à Saint-Apollinaire, no) | 810 → 899 | ⚠️ écart +89 px |
| 5 | Qui nous sommes | Qui nous sommes | 4091 → 3809 | ⚠️ écart -282 px |
| 6 | Parlons de vos locaux | Parlons de vos locaux | 266 → 94 | ⚠️ écart -172 px |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Recrutement) | (Accueil/Recrutement) | 42 → 47 | ✅ identique |
| 2 | Rejoindre Top-Famille Pro | Rejoindre Top-Famille Pro | 764 → 782 | ≈ proche |
| 3 | Les missions que nous confions | Les missions que nous confions | 722 → 738 | ≈ proche |
| 4 | Ce que nous attendons | Ce que nous attendons | 733 → 870 | ⚠️ écart +137 px |
| 5 | Envie de nous rejoindre ? | Envie de nous rejoindre ? | 350 → 267 | ⚠️ écart -83 px |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Mentions légales) | (Accueil/Mentions légales) | 42 → 47 | ✅ identique |
| 2 | Mentions légales | Mentions légales | 332 → 240 | ⚠️ écart -92 px |
| 3 | Éditeur du site | Éditeur du site | 1406 → 2573 | ⚠️ écart +1167 px |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Politique de confidentialité) | (Accueil/Politique de confidentialité) | 42 → 47 | ✅ identique |
| 2 | Politique de confidentialité | Politique de confidentialité | 411 → 271 | ⚠️ écart -140 px |
| 3 | Données collectées | Responsable du traitement | 1202 → 2828 | ⚠️ écart +1626 px |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Gestion des cookies) | (Accueil/Gestion des cookies) | 42 → 47 | ✅ identique |
| 2 | Gestion des cookies | Gestion des cookies | 379 → 209 | ⚠️ écart -170 px |
| 3 | Cookies strictement nécessaires | Aucun cookie de mesure d'audience ni de traçag | 807 → 1773 | ⚠️ écart +966 px |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Plan du site) | (Accueil/Plan du site) | 42 → 47 | ✅ identique |
| 2 | Plan du site | Plan du site | 2139 → 136 | ⚠️ écart -2003 px |
| 3 | Pages légales et utilitaires | Pages principales | 241 → 2381 | ⚠️ écart +2140 px |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (Accueil/Conseils/Combien coûte le nett) | 64 → 78 | ≈ proche |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 424 → 485 | ⚠️ écart +61 px |
| 3 | (Le nettoyage de bureaux est facturé au) | (Le nettoyage de bureaux est facturé au) | 314 → 417 | ⚠️ écart +103 px |
| 4 | (Sommaire Comment se calcule le prix du) | (Sommaire Comment se calcule le prix du) | 487 → 517 | ≈ proche |
| 5 | Comment se calcule le prix du nettoyage de bur | Comment se calcule le prix du nettoyage de bur | 2158 → 2512 | ⚠️ écart +354 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 365 → 536 | ⚠️ écart +171 px |
| 7 | Questions fréquentes | Questions fréquentes | 407 → 454 | ≈ proche |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 276 → 294 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 333 → 365 | ≈ proche |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (Accueil/Conseils/À quelle fréquence fa) | 64 → 99 | ≈ proche |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 424 → 485 | ⚠️ écart +61 px |
| 3 | (La fréquence adaptée dépend surtout de) | (La fréquence adaptée dépend surtout de) | 340 → 417 | ⚠️ écart +77 px |
| 4 | (Sommaire Ce qui détermine la bonne fré) | (Sommaire Ce qui détermine la bonne fré) | 457 → 511 | ≈ proche |
| 5 | Ce qui détermine la bonne fréquence | Ce qui détermine la bonne fréquence | 2050 → 2339 | ⚠️ écart +289 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 390 → 562 | ⚠️ écart +172 px |
| 7 | Questions fréquentes | Questions fréquentes | 407 → 454 | ≈ proche |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 276 → 294 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 333 → 365 | ≈ proche |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (Accueil/Conseils/Comment rédiger un ca) | 64 → 99 | ≈ proche |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 424 → 485 | ⚠️ écart +61 px |
| 3 | (Un cahier des charges de nettoyage pro) | (Un cahier des charges de nettoyage pro) | 340 → 444 | ⚠️ écart +104 px |
| 4 | (Sommaire Pourquoi un cahier des charge) | (Sommaire Pourquoi un cahier des charge) | 438 → 469 | ≈ proche |
| 5 | Pourquoi un cahier des charges change tout | Pourquoi un cahier des charges change tout | 2115 → 2412 | ⚠️ écart +297 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 340 → 510 | ⚠️ écart +170 px |
| 7 | Questions fréquentes | Questions fréquentes | 381 → 426 | ≈ proche |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 276 → 578 | ⚠️ écart +302 px |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 333 → 365 | ≈ proche |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 818 → 932 | ⚠️ écart +114 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTop-Famille Pro est imp) | (Réponse directe Top-Famille Pro est im) | 449 → 545 | ⚠️ écart +96 px |
| 5 | Notre implantation réelle, et rien d'autre | Notre implantation réelle, et rien d'autre | 2320 → 2293 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1209 → 1311 | ⚠️ écart +102 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 2298 → 2141 | ⚠️ écart -157 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 601 → 711 | ⚠️ écart +110 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Saint-Apollinaire | Questions fréquentes — Saint-Apollinaire | 833 → 770 | ⚠️ écart -63 px |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 762 → 932 | ⚠️ écart +170 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeChenôve est une commune) | (Réponse directe Chenôve est une commun) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Chenôve dans l'agglomération dijonnaise | Chenôve dans l'agglomération dijonnaise | 2387 → 2189 | ⚠️ écart -198 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1152 → 1252 | ⚠️ écart +100 px |
| 8 | Commerces, bureaux et cabinets | Commerces, bureaux et cabinets | 2450 → 2312 | ⚠️ écart -138 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 553 → 598 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Chenôve | Questions fréquentes — Chenôve | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 762 → 900 | ⚠️ écart +138 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeQuetigny est une commun) | (Réponse directe Quetigny est une commu) | 398 → 491 | ⚠️ écart +93 px |
| 5 | Quetigny, commune voisine de notre implantatio | Quetigny, commune voisine de notre implantatio | 2178 → 2115 | ⚠️ écart -63 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1134 → 1232 | ⚠️ écart +98 px |
| 8 | Bureaux, cabinets et parties communes | Bureaux, cabinets et parties communes | 2341 → 2275 | ⚠️ écart -66 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 504 → 598 | ⚠️ écart +94 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Quetigny | Questions fréquentes — Quetigny | 726 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 762 → 886 | ⚠️ écart +124 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeTalant est une commune ) | (Réponse directe Talant est une commune) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Talant, commune limitrophe de Dijon | Talant, commune limitrophe de Dijon | 2136 → 2020 | ⚠️ écart -116 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1041 → 1131 | ⚠️ écart +90 px |
| 8 | Cabinets, commerces et petits bureaux | Cabinets, commerces et petits bureaux | 2260 → 2111 | ⚠️ écart -149 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 504 → 598 | ⚠️ écart +94 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Talant | Questions fréquentes — Talant | 753 → 715 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 735 → 888 | ⚠️ écart +153 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeLongvic est une commune) | (Réponse directe Longvic est une commun) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Longvic, commune d'activité au sud de Dijon | Longvic, commune d'activité au sud de Dijon | 2315 → 2157 | ⚠️ écart -158 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1136 → 1231 | ⚠️ écart +95 px |
| 8 | Bureaux, commerces, cabinets et parties commun | Bureaux, commerces, cabinets et parties commun | 2344 → 2307 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 504 → 655 | ⚠️ écart +151 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Longvic | Questions fréquentes — Longvic | 753 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 818 → 900 | ⚠️ écart +82 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | (Réponse directe Fontaine-lès-Dijon est) | 423 → 518 | ⚠️ écart +95 px |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Fontaine-lès-Dijon dans l'agglomération | 2879 → 2721 | ⚠️ écart -158 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1086 → 1206 | ⚠️ écart +120 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 2313 → 2172 | ⚠️ écart -141 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 504 → 683 | ⚠️ écart +179 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | Questions fréquentes — Fontaine-lès-Dijon | 726 → 742 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 846 → 966 | ⚠️ écart +120 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 332 → 411 | ⚠️ écart +79 px |
| 4 | (Réponse directeMarsannay-la-Côte est u) | (Réponse directe Marsannay-la-Côte est ) | 423 → 491 | ⚠️ écart +68 px |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Marsannay-la-Côte, entre agglomération et Côte | 2158 → 2066 | ⚠️ écart -92 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 1214 → 1183 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1061 → 1175 | ⚠️ écart +114 px |
| 8 | Événements et périodes de forte fréquentation | Événements et périodes de forte fréquentation | 2312 → 2209 | ⚠️ écart -103 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 504 → 626 | ⚠️ écart +122 px |
| 10 | Dans le même département | Dans le même département | 858 → 722 | ⚠️ écart -136 px |
| 11 | Questions fréquentes — Marsannay-la-Côte | Questions fréquentes — Marsannay-la-Côte | 753 → 770 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 326 → 337 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

