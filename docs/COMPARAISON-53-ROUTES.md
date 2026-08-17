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

## Synthèse à 1440 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 7825 → 7886 (101 %) | 1058 → 1137 (107 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | [voir](captures/comparaison/accueil-1440.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 5975 (102 %) | 951 → 967 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-1440.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4047 → 4227 (104 %) | 1038 → 1064 (103 %) | 12 → 14 | 15 → 48 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-1440.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2938 → 2926 (100 %) | 613 → 665 (108 %) | 3 → 5 | 15 → 42 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-1440.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 2913 (103 %) | 465 → 462 (99 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-1440.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 1947 → 1952 (100 %) | 366 → 390 (107 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | [voir](captures/comparaison/demande-de-devis-1440.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3510 → 3659 (104 %) | 808 → 830 (103 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | [voir](captures/comparaison/nos-prestations-1440.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11162 (100 %) | 2560 → 2580 (101 %) | 44 → 46 | 29 → 85 | 10 → 10 | non | [voir](captures/comparaison/nettoyage-professionnel-1440.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7745 → 7809 (101 %) | 2074 → 2084 (100 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-1440.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7484 → 7431 (99 %) | 1868 → 1882 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-1440.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8321 → 8315 (100 %) | 2055 → 2060 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-1440.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7684 → 7658 (100 %) | 2010 → 2022 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-1440.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7955 → 8009 (101 %) | 2086 → 2098 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-1440.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 7461 (98 %) | 1950 → 1963 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-1440.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4095 → 4252 (104 %) | 966 → 994 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-1440.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 6658 (103 %) | 1376 → 1379 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-1440.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 6403 (104 %) | 1271 → 1263 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-1440.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 6525 (104 %) | 1261 → 1254 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-1440.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 6523 (104 %) | 1284 → 1282 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-1440.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 6578 (103 %) | 1308 → 1300 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-1440.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 6257 (104 %) | 1222 → 1213 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-1440.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 6498 (104 %) | 1278 → 1276 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-1440.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 6533 (103 %) | 1310 → 1304 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-1440.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 6817 (101 %) | 1321 → 1322 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-1440.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 2011 (105 %) | 309 → 357 (116 %) | 1 → 4 | 15 → 38 | 3 → 4 | non | [voir](captures/comparaison/contact-1440.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 8947 (103 %) | 1955 → 1958 (100 %) | 17 → 19 | 27 → 67 | 3 → 4 | non | [voir](captures/comparaison/bourgogne-franche-comte-1440.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 8503 (100 %) | 1918 → 1924 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-1440.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 7054 (99 %) | 1445 → 1432 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-1440.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8076 → 8113 (100 %) | 1822 → 1823 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-1440.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8199 → 8140 (99 %) | 1806 → 1801 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-1440.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8205 → 8243 (100 %) | 1794 → 1789 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-1440.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8077 → 8094 (100 %) | 1733 → 1737 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-1440.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8211 → 8254 (101 %) | 1778 → 1780 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-1440.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8062 → 8139 (101 %) | 1761 → 1756 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-1440.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8072 → 8078 (100 %) | 1690 → 1685 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-1440.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8089 → 8140 (101 %) | 1759 → 1763 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-1440.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8098 → 8140 (101 %) | 1758 → 1758 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-1440.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4433 → 4623 (104 %) | 1108 → 1148 (104 %) | 10 → 12 | 15 → 32 | 3 → 4 | non | [voir](captures/comparaison/a-propos-1440.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2394 → 2490 (104 %) | 387 → 396 (102 %) | 5 → 7 | 19 → 36 | 3 → 4 | non | [voir](captures/comparaison/recrutement-1440.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 2689 (134 %) | 409 → 555 (136 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-1440.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 2786 (144 %) | 399 → 625 (157 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-1440.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2112 (123 %) | 345 → 475 (138 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-1440.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2072 (105 %) | 315 → 329 (104 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-1440.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 4659 (103 %) | 839 → 863 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-1440.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 4487 (101 %) | 771 → 776 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-1440.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 4768 (103 %) | 741 → 744 (100 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-1440.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7164 → 7116 (99 %) | 1438 → 1430 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-1440.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7115 → 7119 (100 %) | 1431 → 1426 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-1440.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7031 → 7013 (100 %) | 1409 → 1401 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-1440.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6942 → 6917 (100 %) | 1356 → 1348 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-1440.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6995 → 6941 (99 %) | 1421 → 1413 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-1440.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7322 → 7380 (101 %) | 1449 → 1441 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-1440.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6993 → 7054 (101 %) | 1374 → 1366 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-1440.jpg) |

## Synthèse à 375 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 13402 → 13653 (102 %) | 1039 → 1117 (108 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | [voir](captures/comparaison/accueil-375.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9002 → 9281 (103 %) | 932 → 947 (102 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-375.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 7837 → 8226 (105 %) | 1019 → 1044 (102 %) | 12 → 14 | 15 → 48 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-375.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6173 → 6100 (99 %) | 594 → 645 (109 %) | 3 → 5 | 15 → 42 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-375.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 5147 → 5253 (102 %) | 446 → 442 (99 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-375.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4175 → 4201 (101 %) | 347 → 370 (107 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | [voir](captures/comparaison/demande-de-devis-375.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 7784 → 7872 (101 %) | 789 → 810 (103 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | [voir](captures/comparaison/nos-prestations-375.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 20090 → 20251 (101 %) | 2541 → 2560 (101 %) | 44 → 46 | 29 → 85 | 10 → 10 | non | [voir](captures/comparaison/nettoyage-professionnel-375.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 14541 → 14706 (101 %) | 2055 → 2064 (100 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-375.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 13666 → 13894 (102 %) | 1849 → 1862 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-375.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 15216 → 15290 (100 %) | 2036 → 2040 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-375.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 14360 → 14651 (102 %) | 1991 → 2002 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-375.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 14559 → 14851 (102 %) | 2067 → 2078 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-375.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 14029 → 14302 (102 %) | 1931 → 1943 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-375.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 7285 → 7302 (100 %) | 947 → 974 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-375.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 11568 → 11927 (103 %) | 1357 → 1359 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-375.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 10618 → 10865 (102 %) | 1252 → 1243 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-375.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 10758 → 10931 (102 %) | 1242 → 1234 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-375.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 10687 → 10960 (103 %) | 1265 → 1262 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-375.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 10944 → 11170 (102 %) | 1289 → 1280 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-375.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 10599 → 10643 (100 %) | 1203 → 1193 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-375.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 10662 → 10939 (103 %) | 1259 → 1256 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-375.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 10736 → 11014 (103 %) | 1291 → 1284 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-375.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 12442 → 12522 (101 %) | 1302 → 1302 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-375.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 4257 → 4461 (105 %) | 290 → 337 (116 %) | 1 → 4 | 15 → 38 | 3 → 4 | non | [voir](captures/comparaison/contact-375.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 16603 → 16646 (100 %) | 1936 → 1938 (100 %) | 17 → 19 | 27 → 67 | 3 → 4 | non | [voir](captures/comparaison/bourgogne-franche-comte-375.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 14937 → 15339 (103 %) | 1899 → 1904 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-375.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 12426 → 12476 (100 %) | 1426 → 1412 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-375.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 14479 → 14852 (103 %) | 1803 → 1803 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-375.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 14319 → 14499 (101 %) | 1787 → 1781 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-375.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 14567 → 14762 (101 %) | 1775 → 1769 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-375.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 14211 → 14483 (102 %) | 1714 → 1717 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-375.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 14408 → 14759 (102 %) | 1759 → 1760 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-375.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 14389 → 14571 (101 %) | 1742 → 1736 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-375.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 14071 → 14253 (101 %) | 1671 → 1665 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-375.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 14172 → 14465 (102 %) | 1740 → 1743 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-375.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 14145 → 14473 (102 %) | 1739 → 1738 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-375.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 8257 → 8378 (101 %) | 1089 → 1128 (104 %) | 10 → 12 | 15 → 32 | 3 → 4 | non | [voir](captures/comparaison/a-propos-375.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4729 → 4896 (104 %) | 368 → 376 (102 %) | 5 → 7 | 19 → 36 | 3 → 4 | non | [voir](captures/comparaison/recrutement-375.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 3759 → 4695 (125 %) | 390 → 535 (137 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-375.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3607 → 4935 (137 %) | 380 → 605 (159 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-375.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3263 → 3915 (120 %) | 326 → 455 (140 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-375.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4579 → 4640 (101 %) | 296 → 309 (104 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-375.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 6564 → 6834 (104 %) | 820 → 843 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-375.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6427 → 6644 (103 %) | 752 → 756 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-375.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6450 → 6666 (103 %) | 722 → 724 (100 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-375.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 12481 → 12570 (101 %) | 1419 → 1410 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-375.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 12309 → 12461 (101 %) | 1412 → 1406 (100 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-375.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 12218 → 12322 (101 %) | 1390 → 1381 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-375.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 11930 → 12045 (101 %) | 1337 → 1328 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-375.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 12220 → 12267 (100 %) | 1402 → 1393 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-375.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 12771 → 12954 (101 %) | 1430 → 1421 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-375.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 12128 → 12331 (102 %) | 1355 → 1346 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-375.jpg) |

## Détail bloc par bloc à 1440 px

### `#/` → `/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Nettoyage professionnel de bureaux et locaux e | Nettoyage professionnel de bureaux et locaux e | 762 → 764 | ✅ identique |
| 2 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 146 → 147 | ✅ identique |
| 3 | (★★★★★5,0/5 sur Google Saint-Apollinair) | (Saint-Apollinaire Entreprise régionale) | 218 → 218 | ✅ identique |
| 4 | Pensé pour les professionnels de la région | Pensé pour les professionnels de la région | 432 → 409 | ≈ proche |
| 5 | Nos prestations de nettoyage | Nos prestations de nettoyage | 800 → 805 | ✅ identique |
| 6 | Les difficultés que nous prenons en charge | Les difficultés que nous prenons en charge | 534 → 543 | ≈ proche |
| 7 | Pourquoi Top-Famille Pro | Pourquoi Top-Famille Pro | 592 → 588 | ✅ identique |
| 8 | Notre fonctionnement, en cinq temps | Notre fonctionnement, en cinq temps | 511 → 543 | ≈ proche |
| 9 | Un tarif clair, affiché avant le devis | Un tarif clair, affiché avant le devis | 597 → 568 | ≈ proche |
| 10 | Une couverture régionale, pas des agences fict | Une couverture régionale, pas des agences fict | 569 → 569 | ✅ identique |
| 11 | Audrey, votre interlocutrice | Audrey, votre interlocutrice | 698 → 730 | ≈ proche |
| 12 | Conseils & repères | Conseils & repères | 653 → 674 | ≈ proche |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 447 → 450 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 47 | ✅ identique |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 362 → 390 | ≈ proche |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 277 → 277 | ✅ identique |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 277 → 204 | ⚠️ écart -73 px |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 131 → 180 | ≈ proche |
| 6 | Le détail de nos frais | Le détail de nos frais | 638 → 616 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 313 → 346 | ≈ proche |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 403 → 387 | ≈ proche |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 606 → 632 | ≈ proche |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 492 → 523 | ≈ proche |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 745 → 714 | ≈ proche |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 405 → 421 | ≈ proche |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 339 → 359 | ≈ proche |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 47 | ✅ identique |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 314 → 451 | ⚠️ écart +137 px |
| 3 | (Directement joignableAudrey est votre ) | (Directement joignable Audrey est votre) | 509 → 529 | ≈ proche |
| 4 | Des preuves plutôt que des slogans | Des preuves plutôt que des slogans | 376 → 401 | ≈ proche |
| 5 | Ce qui nous distingue, concrètement | Ce qui nous distingue, concrètement | 789 → 822 | ≈ proche |
| 6 | Les objections que l'on nous adresse | Les objections que l'on nous adresse | 488 → 450 | ≈ proche |
| 7 | Vérifier par vous-même | Vérifier par vous-même | 390 → 388 | ✅ identique |
| 8 | Faisons connaissance | Faisons connaissance | 319 → 260 | ≈ proche |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (Accueil/Avis clients) | 42 → 47 | ✅ identique |
| 2 | Avis de nos clients | Avis de nos clients | 215 → 359 | ⚠️ écart +144 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | (Exemples de présentation — témoignages) | 157 → 171 | ≈ proche |
| 4 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 386 → 308 | ⚠️ écart -78 px |
| 5 | (★★★★★Google« Même intervenante chaque ) | (Exemples de présentation — témoignages) | 710 → 606 | ⚠️ écart -104 px |
| 6 | Un avis ne remplace pas un devis | Un avis ne remplace pas un devis | 288 → 285 | ✅ identique |
| 7 | À votre tour ? | À votre tour ? | 319 → 260 | ≈ proche |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 47 | ✅ identique |
| 2 | Conseils & repères | Conseils & repères | 339 → 335 | ✅ identique |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 75 → 73 | ✅ identique |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 427 → 427 | ✅ identique |
| 5 | Les autres articles | Les autres articles | 642 → 632 | ≈ proche |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 314 → 342 | ≈ proche |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 174 → 178 | ✅ identique |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Demandez votre devis gratuit | (Aller au contenu principal) | 900 → 52 | ⚠️ écart -848 px |
| 2 | — | Demandez votre devis gratuit | — → 1952 | ➕ en plus côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 47 | ✅ identique |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 449 → 606 | ⚠️ écart +157 px |
| 3 | Comment choisir la bonne prestation ? | Comment choisir la bonne prestation ? | 359 → 390 | ≈ proche |
| 4 | Ce qui est commun aux six prestations | Ce qui est commun aux six prestations | 307 → 365 | ≈ proche |
| 5 | (Nettoyage de bureauxUn entretien régul) | (Nettoyage de bureaux Un entretien régu) | 1197 → 1093 | ⚠️ écart -104 px |
| 6 | Besoin d'aide pour choisir ? | Besoin d'aide pour choisir ? | 334 → 280 | ≈ proche |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 47 | ✅ identique |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 661 → 644 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 202 → 286 | ⚠️ écart +84 px |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 492 → 424 | ⚠️ écart -68 px |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 516 → 588 | ⚠️ écart +72 px |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 731 → 741 | ≈ proche |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 560 → 501 | ≈ proche |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 862 → 828 | ≈ proche |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 700 → 713 | ≈ proche |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 763 → 760 | ✅ identique |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 433 → 449 | ≈ proche |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 735 → 715 | ≈ proche |
| 13 | Cahier des charges, intervenants et suivi | Cahier des charges, intervenants et suivi | 674 → 555 | ⚠️ écart -119 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 396 → 486 | ⚠️ écart +90 px |
| 15 | Trois situations concrètes | Trois situations concrètes | 552 → 544 | ✅ identique |
| 16 | Le tarif, en toute transparence | Le tarif, en toute transparence | 450 → 522 | ⚠️ écart +72 px |
| 17 | Pour aller plus loin | Pour aller plus loin | 286 → 318 | ≈ proche |
| 18 | Questions fréquentes | Questions fréquentes | 976 → 869 | ⚠️ écart -107 px |
| 19 | Un projet d'entretien pour vos locaux ? | Un projet d'entretien pour vos locaux ? | 339 → 276 | ⚠️ écart -63 px |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Bureaux) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 483 → 550 | ⚠️ écart +67 px |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Le nettoyage de bureau) | 363 → 353 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 648 → 598 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 397 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1068 | ⚠️ écart -94 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 979 | ⚠️ écart +163 px |
| 9 | Une semaine type | Une semaine type | 401 → 349 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 12 | Questions fréquentes — Bureaux | Questions fréquentes — Bureaux | 797 → 753 | ≈ proche |
| 13 | (Encore une question sur Bureaux ? Audr) | (Encore une question sur Bureaux ? Audr) | 97 → 189 | ⚠️ écart +92 px |
| 14 | Un devis pour Bureaux | Un devis pour Bureaux | 317 → 357 | ≈ proche |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Commerces) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 483 → 500 | ≈ proche |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe La propreté d'un comme) | 363 → 353 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 561 → 503 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 336 → 370 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1111 → 992 | ⚠️ écart -119 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 877 | ⚠️ écart +61 px |
| 9 | Une semaine type | Une semaine type | 401 → 344 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 12 | Questions fréquentes — Commerces | Questions fréquentes — Commerces | 722 → 687 | ≈ proche |
| 13 | (Encore une question sur Commerces ? Au) | (Encore une question sur Commerces ? Au) | 97 → 233 | ⚠️ écart +136 px |
| 14 | Un devis pour Commerces | Un devis pour Commerces | 317 → 357 | ≈ proche |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Cabinets) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 503 → 532 | ≈ proche |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe Un cabinet reçoit du p) | 491 → 481 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 640 → 577 | ⚠️ écart -63 px |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que Top-Famille Pro ne réalise pas | 513 → 486 | ≈ proche |
| 6 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 397 | ≈ proche |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 590 | ≈ proche |
| 8 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1034 → 966 | ⚠️ écart -68 px |
| 9 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 865 → 1005 | ⚠️ écart +140 px |
| 10 | Une semaine type | Une semaine type | 401 → 349 | ≈ proche |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 12 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 13 | Questions fréquentes — Cabinets | Questions fréquentes — Cabinets | 797 → 753 | ≈ proche |
| 14 | (Encore une question sur Cabinets ? Aud) | (Encore une question sur Cabinets ? Aud) | 97 → 189 | ⚠️ écart +92 px |
| 15 | Un devis pour Cabinets | Un devis pour Cabinets | 317 → 357 | ≈ proche |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Copropriétés) | 42 → 47 | ✅ identique |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 483 → 500 | ≈ proche |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe Nous travaillons avec ) | 363 → 353 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 640 → 605 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 397 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1104 → 992 | ⚠️ écart -112 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 768 → 877 | ⚠️ écart +109 px |
| 9 | Une semaine type | Une semaine type | 452 → 377 | ⚠️ écart -75 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 12 | Questions fréquentes — Copropriétés | Questions fréquentes — Copropriétés | 797 → 753 | ≈ proche |
| 13 | (Encore une question sur Copropriétés ?) | (Encore une question sur Copropriétés ?) | 97 → 233 | ⚠️ écart +136 px |
| 14 | Un devis pour Copropriétés | Un devis pour Copropriétés | 317 → 357 | ≈ proche |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Locations meublées) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 520 → 582 | ⚠️ écart +62 px |
| 3 | (Réponse directePour les locations meub) | (Réponse directe Pour les locations meu) | 459 → 449 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 616 → 552 | ⚠️ écart -64 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 424 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 601 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1068 | ⚠️ écart -94 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 840 → 1005 | ⚠️ écart +165 px |
| 9 | Une semaine type | Une semaine type | 452 → 372 | ⚠️ écart -80 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 12 | Questions fréquentes — Locations meublées | Questions fréquentes — Locations meublées | 797 → 753 | ≈ proche |
| 13 | (Encore une question sur Locations meub) | (Encore une question sur Locations meub) | 136 → 233 | ⚠️ écart +97 px |
| 14 | Un devis pour Locations meublées | Un devis pour Locations meublées | 317 → 357 | ≈ proche |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 47 | ✅ identique |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 483 → 500 | ≈ proche |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 363 → 353 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 561 → 503 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 360 → 370 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 590 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1136 → 1017 | ⚠️ écart -119 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 744 → 826 | ⚠️ écart +82 px |
| 9 | Une semaine type | Une semaine type | 452 → 372 | ⚠️ écart -80 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 377 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 330 | ≈ proche |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 797 → 753 | ≈ proche |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 97 → 189 | ⚠️ écart +92 px |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 317 → 357 | ≈ proche |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Notre fonctionnement) | (Accueil/Notre fonctionnement) | 42 → 47 | ✅ identique |
| 2 | Notre fonctionnement | Notre fonctionnement | 314 → 451 | ⚠️ écart +137 px |
| 3 | (01Prise de contactVous nous décrivez v) | (01 Prise de contact Vous nous décrivez) | 1034 → 1050 | ≈ proche |
| 4 | Les informations dont nous avons besoin | Les informations dont nous avons besoin | 1567 → 1564 | ✅ identique |
| 5 | Prêt à démarrer ? | Prêt à démarrer ? | 317 → 260 | ≈ proche |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | (Réponse directe La Côte-d'Or est notre) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Côte-d'Or | Notre couverture en Côte-d'Or | 1486 → 1476 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 498 | ≈ proche |
| 8 | Entretien régulier ou intervention ponctuelle | Entretien régulier ou intervention ponctuelle | 1118 → 1110 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Côte-d'Or | Questions fréquentes — Côte-d'Or | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 434 → 497 | ⚠️ écart +63 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeDans le Doubs, notre se) | (Réponse directe Dans le Doubs, notre s) | 291 → 289 | ✅ identique |
| 5 | Notre couverture dans le Doubs | Notre couverture dans le Doubs | 1103 → 1093 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 469 | ≈ proche |
| 8 | Les cabinets de santé : ce que nous faisons, c | Les cabinets de santé : ce que nous faisons, c | 1178 → 1203 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Doubs | Questions fréquentes — Doubs | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeDans le Jura, nous inte) | (Réponse directe Dans le Jura, nous int) | 291 → 259 | ≈ proche |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Deux bassins distincts : Dole et Lons-le-Sauni | 1379 → 1369 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 401 → 498 | ⚠️ écart +97 px |
| 8 | Fonctionnement et suivi | Fonctionnement et suivi | 1091 → 1083 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Jura | Questions fréquentes — Jura | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeDans la Nièvre, notre s) | (Réponse directe Dans la Nièvre, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans la Nièvre | Notre couverture dans la Nièvre | 1433 → 1423 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 469 | ⚠️ écart +65 px |
| 8 | Organisation des déplacements | Organisation des déplacements | 1064 → 1056 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Nièvre | Questions fréquentes — Nièvre | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeEn Haute-Saône, notre s) | (Réponse directe En Haute-Saône, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Haute-Saône | Notre couverture en Haute-Saône | 1433 → 1423 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 498 | ≈ proche |
| 8 | Accès, clés et interventions hors horaires | Accès, clés et interventions hors horaires | 1091 → 1083 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Haute-Saône | Questions fréquentes — Haute-Saône | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | (Réponse directe En Saône-et-Loire, nos) | 291 → 259 | ≈ proche |
| 5 | Deux bassins le long de l'axe Saône | Deux bassins le long de l'axe Saône | 1106 → 1096 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 469 | ⚠️ écart +65 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Industrie, agroalimentaire et viticulture : ce | 1124 → 1116 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Saône-et-Loire | Questions fréquentes — Saône-et-Loire | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeDans l'Yonne, notre sec) | (Réponse directe Dans l'Yonne, notre se) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans l'Yonne | Notre couverture dans l'Yonne | 1379 → 1369 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 498 | ⚠️ écart +71 px |
| 8 | Fonctionnement et suivi à distance | Fonctionnement et suivi à distance | 1064 → 1056 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Yonne | Questions fréquentes — Yonne | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 401 → 465 | ⚠️ écart +64 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeDans le Territoire de B) | (Réponse directe Dans le Territoire de ) | 291 → 259 | ≈ proche |
| 5 | Un département compact, entièrement autour de  | Un département compact, entièrement autour de  | 1443 → 1433 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 541 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 469 | ≈ proche |
| 8 | Interventions en soirée : comment cela s'organ | Interventions en soirée : comment cela s'organ | 1064 → 1056 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 229 | ≈ proche |
| 10 | Questions fréquentes — Territoire de Belfort | Questions fréquentes — Territoire de Belfort | 614 → 549 | ⚠️ écart -65 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 47 | ✅ identique |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 383 → 462 | ⚠️ écart +79 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 270 | ⚠️ écart +84 px |
| 4 | (Réponse directeNous intervenons unique) | (Réponse directeNous intervenons unique) | 323 → 289 | ≈ proche |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 1391 → 1355 | ≈ proche |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | (Bourgogne-Franche-ComtéLa page régiona) | 192 → 84 | ⚠️ écart -108 px |
| 7 | Les huit départements | Les huit départements | 429 → 437 | ✅ identique |
| 8 | Nos dix villes principales | Nos dix villes principales | 344 → 356 | ≈ proche |
| 9 | Premières communes secondaires | Premières communes secondaires | 327 → 339 | ≈ proche |
| 10 | Départements, villes et communes : comment lir | Départements, villes et communes : comment lir | 1163 → 1183 | ≈ proche |
| 11 | (Découvrir nos prestationsBureaux, comm) | (Découvrir nos prestations Bureaux, com) | 193 → 183 | ≈ proche |
| 12 | Questions fréquentes sur nos zones d'intervent | Questions fréquentes sur nos zones d'intervent | 614 → 569 | ≈ proche |
| 13 | Votre commune est-elle couverte ? | Votre commune est-elle couverte ? | 346 → 328 | ≈ proche |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Contact) | (Accueil/Contact) | 42 → 47 | ✅ identique |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 178 → 178 | ✅ identique |
| 3 | (J'ai une question Formulaire court, ré) | (J’ai une question Formulaire court, ré) | 152 → 141 | ≈ proche |
| 4 | (Nom Entreprise (facultatif) E-mail Tél) | J’ai une question | 731 → 766 | ≈ proche |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 526 → 533 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 270 | ⚠️ écart +84 px |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directeTop-Famille Pro est une) | 323 → 289 | ≈ proche |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Notre implantation réelle : Saint-Apollinaire, | 2022 → 2049 | ≈ proche |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Nos prestations partout en Bourgogne-Franche-C | 576 → 605 | ≈ proche |
| 7 | Les huit départements couverts | Les huit départements couverts | 733 → 664 | ⚠️ écart -69 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 424 → 624 | ⚠️ écart +200 px |
| 9 | Un tarif régional unique | Un tarif régional unique | 478 → 530 | ≈ proche |
| 10 | Sélection des intervenants et suivi | Sélection des intervenants et suivi | 1540 → 1521 | ≈ proche |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes — Bourgogne-Franche-Comté | 684 → 635 | ≈ proche |
| 12 | Vos locaux, où que vous soyez en région | Vos locaux, où que vous soyez en région | 319 → 285 | ≈ proche |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 474 → 497 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directe Top-Famille Pro est un) | 323 → 289 | ≈ proche |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Une entreprise implantée à Saint-Apollinaire,  | 2003 → 1990 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 498 | ≈ proche |
| 8 | Espaces, tâches et fréquences | Espaces, tâches et fréquences | 1513 → 1500 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 374 → 431 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Dijon | Questions fréquentes — Dijon | 684 → 615 | ⚠️ écart -69 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 323 → 289 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 1059 → 1046 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 498 | ≈ proche |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 1174 → 1163 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 684 → 615 | ⚠️ écart -69 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Besançon | Notre positionnement à Besançon | 1750 → 1736 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Commerces du centre historique et immeubles an | Commerces du centre historique et immeubles an | 1489 → 1476 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Besançon | Questions fréquentes — Besançon | 684 → 615 | ⚠️ écart -69 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre position sur le bassin dolois | Notre position sur le bassin dolois | 1816 → 1803 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 478 | ✅ identique |
| 8 | Fréquences, horaires et matériel | Fréquences, horaires et matériel | 1566 → 1553 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Dole | Questions fréquentes — Dole | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Lons-le-Saunier | Notre positionnement à Lons-le-Saunier | 1911 → 1896 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 494 | ⚠️ écart +67 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | Agroalimentaire et thermalisme : notre périmèt | 1528 → 1516 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Lons-le-Saunier | Questions fréquentes — Lons-le-Saunier | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Nevers | Notre positionnement à Nevers | 1891 → 1876 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 498 | ≈ proche |
| 8 | Accès aux immeubles et aux locaux | Accès aux immeubles et aux locaux | 1394 → 1383 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Nevers | Questions fréquentes — Nevers | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Vesoul | Notre positionnement à Vesoul | 1929 → 1916 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Fréquences et créneaux hors horaires | Fréquences et créneaux hors horaires | 1516 → 1503 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Vesoul | Questions fréquentes — Vesoul | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 474 → 537 | ⚠️ écart +63 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement sur le Grand Chalon | Notre positionnement sur le Grand Chalon | 1789 → 1776 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 498 | ⚠️ écart +81 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1516 → 1503 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Chalon-sur-Saône | Questions fréquentes — Chalon-sur-Saône | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement à Mâcon | Notre positionnement à Mâcon | 1866 → 1853 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 404 → 469 | ⚠️ écart +65 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1463 → 1450 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Mâcon | Questions fréquentes — Mâcon | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Auxerre | Notre positionnement à Auxerre | 1789 → 1776 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 498 | ⚠️ écart +81 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1543 → 1530 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Auxerre | Questions fréquentes — Auxerre | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Belfort | Notre positionnement à Belfort | 1843 → 1829 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Fréquences et créneaux en soirée | Fréquences et créneaux en soirée | 1489 → 1476 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 334 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Belfort | Questions fréquentes — Belfort | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 47 | ✅ identique |
| 2 | Une entreprise régionale, un visage | Une entreprise régionale, un visage | 612 → 804 | ⚠️ écart +192 px |
| 3 | (« Mon rôle, c'est de rester joignable ) | (« Mon rôle, c'est de rester joignable ) | 277 → 255 | ≈ proche |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | (Exemples de présentation — témoignages) | 321 → 360 | ≈ proche |
| 5 | Qui nous sommes | Qui nous sommes | 2083 → 2022 | ⚠️ écart -61 px |
| 6 | Parlons de vos locaux | Parlons de vos locaux | 277 → 256 | ≈ proche |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Recrutement) | (Accueil/Recrutement) | 42 → 47 | ✅ identique |
| 2 | Rejoindre Top-Famille Pro | Rejoindre Top-Famille Pro | 496 → 488 | ✅ identique |
| 3 | Les missions que nous confions | Les missions que nous confions | 321 → 315 | ✅ identique |
| 4 | Ce que nous attendons | Ce que nous attendons | 384 → 511 | ⚠️ écart +127 px |
| 5 | Envie de nous rejoindre ? | Envie de nous rejoindre ? | 329 → 249 | ⚠️ écart -80 px |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Mentions légales) | (Accueil/Mentions légales) | 42 → 47 | ✅ identique |
| 2 | Mentions légales | Mentions légales | 263 → 195 | ⚠️ écart -68 px |
| 3 | Éditeur du site | Éditeur du site | 888 → 1568 | ⚠️ écart +680 px |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Politique de confidentialité) | (Accueil/Politique de confidentialité) | 42 → 47 | ✅ identique |
| 2 | Politique de confidentialité | Politique de confidentialité | 263 → 195 | ⚠️ écart -68 px |
| 3 | Données collectées | Responsable du traitement | 810 → 1665 | ⚠️ écart +855 px |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Gestion des cookies) | (Accueil/Gestion des cookies) | 42 → 47 | ✅ identique |
| 2 | Gestion des cookies | Gestion des cookies | 286 → 195 | ⚠️ écart -91 px |
| 3 | Cookies strictement nécessaires | Aucun cookie de mesure d'audience ni de traçag | 569 → 991 | ⚠️ écart +422 px |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Plan du site) | (Accueil/Plan du site) | 42 → 47 | ✅ identique |
| 2 | Plan du site | Plan du site | 937 → 970 | ≈ proche |
| 3 | Pages légales et utilitaires | Pages légales et utilitaires | 175 → 175 | ✅ identique |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (Accueil/Conseils/Combien coûte le nett) | 42 → 47 | ✅ identique |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 728 → 725 | ✅ identique |
| 3 | (Le nettoyage de bureaux est facturé au) | (Le nettoyage de bureaux est facturé au) | 242 → 224 | ≈ proche |
| 4 | (Sommaire Comment se calcule le prix du) | (Sommaire Comment se calcule le prix du) | 397 → 404 | ✅ identique |
| 5 | Comment se calcule le prix du nettoyage de bur | Comment se calcule le prix du nettoyage de bur | 1198 → 1248 | ≈ proche |
| 6 | Erreurs à éviter | Erreurs à éviter | 253 → 227 | ≈ proche |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 335 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 220 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (Accueil/Conseils/À quelle fréquence fa) | 42 → 47 | ✅ identique |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 728 → 725 | ✅ identique |
| 3 | (La fréquence adaptée dépend surtout de) | (La fréquence adaptée dépend surtout de) | 242 → 224 | ≈ proche |
| 4 | (Sommaire Ce qui détermine la bonne fré) | (Sommaire Ce qui détermine la bonne fré) | 367 → 374 | ✅ identique |
| 5 | Ce qui détermine la bonne fréquence | Ce qui détermine la bonne fréquence | 1099 → 1082 | ≈ proche |
| 6 | Erreurs à éviter | Erreurs à éviter | 278 → 253 | ≈ proche |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 335 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 220 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (Accueil/Conseils/Comment rédiger un ca) | 42 → 47 | ✅ identique |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 728 → 725 | ✅ identique |
| 3 | (Un cahier des charges de nettoyage pro) | (Un cahier des charges de nettoyage pro) | 242 → 254 | ≈ proche |
| 4 | (Sommaire Pourquoi un cahier des charge) | (Sommaire Pourquoi un cahier des charge) | 397 → 404 | ✅ identique |
| 5 | Pourquoi un cahier des charges change tout | Pourquoi un cahier des charges change tout | 1324 → 1327 | ✅ identique |
| 6 | Erreurs à éviter | Erreurs à éviter | 227 → 227 | ✅ identique |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 335 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 220 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTop-Famille Pro est imp) | (Réponse directe Top-Famille Pro est im) | 323 → 289 | ≈ proche |
| 5 | Notre implantation réelle, et rien d'autre | Notre implantation réelle, et rien d'autre | 1163 → 1150 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 498 | ≈ proche |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1200 → 1187 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Saint-Apollinaire | Questions fréquentes — Saint-Apollinaire | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeChenôve est une commune) | (Réponse directe Chenôve est une commun) | 323 → 289 | ≈ proche |
| 5 | Chenôve dans l'agglomération dijonnaise | Chenôve dans l'agglomération dijonnaise | 1203 → 1190 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Commerces, bureaux et cabinets | Commerces, bureaux et cabinets | 1163 → 1150 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Chenôve | Questions fréquentes — Chenôve | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeQuetigny est une commun) | (Réponse directe Quetigny est une commu) | 291 → 289 | ✅ identique |
| 5 | Quetigny, commune voisine de notre implantatio | Quetigny, commune voisine de notre implantatio | 1140 → 1127 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 469 | ≈ proche |
| 8 | Bureaux, cabinets et parties communes | Bureaux, cabinets et parties communes | 1148 → 1137 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Quetigny | Questions fréquentes — Quetigny | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeTalant est une commune ) | (Réponse directe Talant est une commune) | 323 → 289 | ≈ proche |
| 5 | Talant, commune limitrophe de Dijon | Talant, commune limitrophe de Dijon | 1083 → 1070 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 469 | ≈ proche |
| 8 | Cabinets, commerces et petits bureaux | Cabinets, commerces et petits bureaux | 1110 → 1096 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Talant | Questions fréquentes — Talant | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 474 → 482 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeLongvic est une commune) | (Réponse directe Longvic est une commun) | 323 → 259 | ⚠️ écart -64 px |
| 5 | Longvic, commune d'activité au sud de Dijon | Longvic, commune d'activité au sud de Dijon | 1110 → 1096 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 498 | ≈ proche |
| 8 | Bureaux, commerces, cabinets et parties commun | Bureaux, commerces, cabinets et parties commun | 1110 → 1096 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Longvic | Questions fréquentes — Longvic | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 474 → 537 | ⚠️ écart +63 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | (Réponse directe Fontaine-lès-Dijon est) | 323 → 289 | ≈ proche |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Fontaine-lès-Dijon dans l'agglomération | 1409 → 1396 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1163 → 1150 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | Questions fréquentes — Fontaine-lès-Dijon | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 507 → 537 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 186 → 254 | ⚠️ écart +68 px |
| 4 | (Réponse directeMarsannay-la-Côte est u) | (Réponse directe Marsannay-la-Côte est ) | 323 → 289 | ≈ proche |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Marsannay-la-Côte, entre agglomération et Côte | 1090 → 1110 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 532 | ⚠️ écart -108 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 498 | ⚠️ écart +71 px |
| 8 | Événements et périodes de forte fréquentation | Événements et périodes de forte fréquentation | 1121 → 1110 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 278 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Marsannay-la-Côte | Questions fréquentes — Marsannay-la-Côte | 614 → 549 | ⚠️ écart -65 px |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

