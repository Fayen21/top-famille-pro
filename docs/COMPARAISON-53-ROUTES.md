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
| `#/` | `/` | 13 → 13 | 7825 → 8137 (104 %) | 1058 → 1128 (107 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | [voir](captures/comparaison/accueil-1440.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 6297 (108 %) | 951 → 962 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-1440.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4047 → 4740 (117 %) | 1038 → 1058 (102 %) | 12 → 14 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-1440.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2938 → 3826 (130 %) | 613 → 644 (105 %) | 3 → 5 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-1440.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 3557 (126 %) | 465 → 472 (102 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-1440.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 1947 → 2915 (150 %) | 366 → 375 (102 %) | 1 → 4 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/demande-de-devis-1440.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3510 → 4116 (117 %) | 808 → 780 (97 %) | 5 → 7 | 15 → 28 | 8 → 3 | non | [voir](captures/comparaison/nos-prestations-1440.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11803 (105 %) | 2560 → 2579 (101 %) | 44 → 46 | 29 → 42 | 10 → 3 | non | [voir](captures/comparaison/nettoyage-professionnel-1440.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7745 → 8311 (107 %) | 2074 → 2079 (100 %) | 30 → 32 | 28 → 42 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-1440.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7484 → 7945 (106 %) | 1868 → 1860 (100 %) | 30 → 32 | 25 → 39 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-1440.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8321 → 8555 (103 %) | 2055 → 2008 (98 %) | 31 → 33 | 33 → 47 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-1440.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7684 → 8130 (106 %) | 2010 → 1963 (98 %) | 31 → 33 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-1440.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7955 → 8401 (106 %) | 2086 → 2076 (100 %) | 30 → 32 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-1440.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 8179 (108 %) | 1950 → 1941 (100 %) | 31 → 33 | 25 → 39 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-1440.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4095 → 3891 (95 %) | 966 → 998 (103 %) | 9 → 11 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-1440.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 8053 (125 %) | 1376 → 1506 (109 %) | 16 → 24 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-1440.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 7499 (122 %) | 1271 → 1390 (109 %) | 14 → 22 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-1440.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 7588 (121 %) | 1261 → 1381 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-1440.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 7516 (119 %) | 1284 → 1409 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-1440.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 7572 (119 %) | 1308 → 1427 (109 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-1440.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 7209 (119 %) | 1222 → 1340 (110 %) | 14 → 22 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-1440.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 7545 (120 %) | 1278 → 1403 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-1440.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 7727 (122 %) | 1310 → 1431 (109 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-1440.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 7571 (112 %) | 1321 → 1298 (98 %) | 12 → 14 | 20 → 33 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-1440.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 2137 (111 %) | 309 → 302 (98 %) | 1 → 6 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/contact-1440.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 8858 (102 %) | 1955 → 1965 (101 %) | 17 → 19 | 27 → 41 | 3 → 3 | non | [voir](captures/comparaison/bourgogne-franche-comte-1440.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 9561 (112 %) | 1918 → 2031 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-1440.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 8070 (114 %) | 1445 → 1536 (106 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-1440.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8076 → 9110 (113 %) | 1822 → 1927 (106 %) | 19 → 27 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-1440.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8199 → 9018 (110 %) | 1806 → 1905 (105 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-1440.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8205 → 9164 (112 %) | 1794 → 1893 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-1440.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8077 → 9113 (113 %) | 1733 → 1841 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-1440.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8211 → 9148 (111 %) | 1778 → 1884 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-1440.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8062 → 9118 (113 %) | 1761 → 1860 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-1440.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8072 → 8977 (111 %) | 1690 → 1789 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-1440.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8089 → 9105 (113 %) | 1759 → 1867 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-1440.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8098 → 9176 (113 %) | 1758 → 1862 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-1440.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4433 → 4235 (96 %) | 1108 → 1135 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/a-propos-1440.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2394 → 2596 (108 %) | 387 → 400 (103 %) | 5 → 7 | 19 → 32 | 3 → 3 | non | [voir](captures/comparaison/recrutement-1440.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 3220 (160 %) | 409 → 584 (143 %) | 6 → 11 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-1440.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 3187 (165 %) | 399 → 588 (147 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-1440.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2487 (145 %) | 345 → 479 (139 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-1440.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2383 (121 %) | 315 → 335 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-1440.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 5147 (113 %) | 839 → 800 (95 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-1440.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 5223 (118 %) | 771 → 777 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-1440.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 5667 (122 %) | 741 → 766 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-1440.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7164 → 8144 (114 %) | 1438 → 1531 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-1440.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7115 → 8166 (115 %) | 1431 → 1524 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-1440.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7031 → 7954 (113 %) | 1409 → 1502 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-1440.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6942 → 7954 (115 %) | 1356 → 1449 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-1440.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6995 → 8139 (116 %) | 1421 → 1514 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-1440.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7322 → 8393 (115 %) | 1449 → 1542 (106 %) | 18 → 26 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-1440.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6993 → 8085 (116 %) | 1374 → 1467 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-1440.jpg) |

## Synthèse à 375 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 13402 → 13801 (103 %) | 1039 → 1108 (107 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | [voir](captures/comparaison/accueil-375.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9002 → 9816 (109 %) | 932 → 942 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-375.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 7837 → 8557 (109 %) | 1019 → 1038 (102 %) | 12 → 14 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-375.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6173 → 7161 (116 %) | 594 → 624 (105 %) | 3 → 5 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-375.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 5147 → 5624 (109 %) | 446 → 452 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-375.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4175 → 4197 (101 %) | 347 → 355 (102 %) | 1 → 4 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/demande-de-devis-375.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 7784 → 7024 (90 %) | 789 → 760 (96 %) | 5 → 7 | 15 → 28 | 8 → 3 | non | [voir](captures/comparaison/nos-prestations-375.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 20090 → 21354 (106 %) | 2541 → 2559 (101 %) | 44 → 46 | 29 → 42 | 10 → 3 | non | [voir](captures/comparaison/nettoyage-professionnel-375.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 14541 → 15637 (108 %) | 2055 → 2059 (100 %) | 30 → 32 | 28 → 42 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-375.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 13666 → 14653 (107 %) | 1849 → 1840 (100 %) | 30 → 32 | 25 → 39 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-375.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 15216 → 15852 (104 %) | 2036 → 1988 (98 %) | 31 → 33 | 33 → 47 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-375.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 14360 → 15129 (105 %) | 1991 → 1943 (98 %) | 31 → 33 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-375.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 14559 → 15630 (107 %) | 2067 → 2056 (99 %) | 30 → 32 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-375.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 14029 → 14955 (107 %) | 1931 → 1921 (99 %) | 31 → 33 | 25 → 39 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-375.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 7285 → 7234 (99 %) | 947 → 978 (103 %) | 9 → 11 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-375.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 11568 → 12710 (110 %) | 1357 → 1486 (110 %) | 16 → 24 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-375.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 10618 → 11395 (107 %) | 1252 → 1370 (109 %) | 14 → 22 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-375.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 10758 → 11509 (107 %) | 1242 → 1361 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-375.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 10687 → 11559 (108 %) | 1265 → 1389 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-375.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 10944 → 11717 (107 %) | 1289 → 1407 (109 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-375.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 10599 → 11249 (106 %) | 1203 → 1320 (110 %) | 14 → 22 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-375.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 10662 → 11467 (108 %) | 1259 → 1383 (110 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-375.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 10736 → 11502 (107 %) | 1291 → 1411 (109 %) | 15 → 23 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-375.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 12442 → 11887 (96 %) | 1302 → 1278 (98 %) | 12 → 14 | 20 → 33 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-375.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 4257 → 3475 (82 %) | 290 → 282 (97 %) | 1 → 6 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/contact-375.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 16603 → 16535 (100 %) | 1936 → 1945 (100 %) | 17 → 19 | 27 → 41 | 3 → 3 | non | [voir](captures/comparaison/bourgogne-franche-comte-375.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 14937 → 15938 (107 %) | 1899 → 2011 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-375.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 12426 → 13015 (105 %) | 1426 → 1516 (106 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-375.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 14479 → 15196 (105 %) | 1803 → 1907 (106 %) | 19 → 27 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-375.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 14319 → 14694 (103 %) | 1787 → 1885 (105 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-375.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 14567 → 14976 (103 %) | 1775 → 1873 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-375.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 14211 → 14779 (104 %) | 1714 → 1821 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-375.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 14408 → 15046 (104 %) | 1759 → 1864 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-375.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 14389 → 14707 (102 %) | 1742 → 1840 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-375.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 14071 → 14423 (103 %) | 1671 → 1769 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-375.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 14172 → 14853 (105 %) | 1740 → 1847 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-375.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 14145 → 14699 (104 %) | 1739 → 1842 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-375.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 8257 → 8356 (101 %) | 1089 → 1115 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | [voir](captures/comparaison/a-propos-375.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4729 → 4789 (101 %) | 368 → 380 (103 %) | 5 → 7 | 19 → 32 | 3 → 3 | non | [voir](captures/comparaison/recrutement-375.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 3759 → 5147 (137 %) | 390 → 564 (145 %) | 6 → 11 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-375.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3607 → 5066 (140 %) | 380 → 568 (149 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-375.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3263 → 4178 (128 %) | 326 → 459 (141 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-375.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4579 → 4891 (107 %) | 296 → 315 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-375.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 6564 → 7185 (109 %) | 820 → 780 (95 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-375.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6427 → 7311 (114 %) | 752 → 757 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-375.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6450 → 7683 (119 %) | 722 → 746 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-375.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 12481 → 13039 (104 %) | 1419 → 1511 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-375.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 12309 → 12908 (105 %) | 1412 → 1504 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-375.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 12218 → 12751 (104 %) | 1390 → 1482 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-375.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 11930 → 12516 (105 %) | 1337 → 1429 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-375.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 12220 → 12779 (105 %) | 1402 → 1494 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-375.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 12771 → 13365 (105 %) | 1430 → 1522 (106 %) | 18 → 26 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-375.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 12128 → 12848 (106 %) | 1355 → 1447 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-375.jpg) |

## Détail bloc par bloc à 1440 px

### `#/` → `/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Nettoyage professionnel de bureaux et locaux e | Nettoyage professionnel de bureaux et locaux e | 762 → 744 | ≈ proche |
| 2 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique, indiqué avant ) | 146 → 151 | ✅ identique |
| 3 | (★★★★★5,0/5 sur Google Saint-Apollinair) | (Saint-Apollinaire Entreprise régionale) | 218 → 218 | ✅ identique |
| 4 | Pensé pour les professionnels de la région | Pensé pour les professionnels de la région | 432 → 409 | ≈ proche |
| 5 | Nos prestations de nettoyage | Nos prestations de nettoyage | 800 → 804 | ✅ identique |
| 6 | Les difficultés que nous prenons en charge | Les difficultés que nous prenons en charge | 534 → 543 | ≈ proche |
| 7 | Pourquoi Top-Famille Pro | Pourquoi Top-Famille Pro | 592 → 588 | ✅ identique |
| 8 | Notre fonctionnement, en cinq temps | Notre fonctionnement, en cinq temps | 511 → 500 | ≈ proche |
| 9 | Un tarif clair, affiché avant le devis | Un tarif clair, affiché avant le devis | 597 → 596 | ✅ identique |
| 10 | Une couverture régionale, pas des agences fict | Une entreprise régionale basée à Saint-Apollin | 569 → 608 | ≈ proche |
| 11 | Audrey, votre interlocutrice | Audrey, votre interlocutrice | 698 → 730 | ≈ proche |
| 12 | Conseils & repères | Conseils & repères | 653 → 674 | ≈ proche |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 447 → 442 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 57 | ≈ proche |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 362 → 301 | ⚠️ écart -61 px |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 277 → 302 | ≈ proche |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 277 → 204 | ⚠️ écart -73 px |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 131 → 180 | ≈ proche |
| 6 | Le détail de nos frais | Le détail de nos frais | 638 → 623 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 313 → 426 | ⚠️ écart +113 px |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 403 → 302 | ⚠️ écart -101 px |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 606 → 632 | ≈ proche |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 492 → 523 | ≈ proche |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 745 → 868 | ⚠️ écart +123 px |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 405 → 385 | ≈ proche |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 339 → 363 | ≈ proche |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 57 | ≈ proche |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 314 → 475 | ⚠️ écart +161 px |
| 3 | (Directement joignableAudrey est votre ) | (Audrey est votre interlocutrice identi) | 509 → 530 | ≈ proche |
| 4 | Des preuves plutôt que des slogans | Des preuves plutôt que des slogans | 376 → 280 | ⚠️ écart -96 px |
| 5 | Ce qui nous distingue, concrètement | Ce qui nous distingue, concrètement | 789 → 1047 | ⚠️ écart +258 px |
| 6 | Les objections que l'on nous adresse | Les objections que l'on nous adresse | 488 → 518 | ≈ proche |
| 7 | Vérifier par vous-même | Vérifier par vous-même | 390 → 443 | ≈ proche |
| 8 | Faisons connaissance | Faisons connaissance | 319 → 258 | ⚠️ écart -61 px |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (Accueil/Avis clients) | 42 → 57 | ≈ proche |
| 2 | Avis de nos clients | Avis de nos clients | 215 → 348 | ⚠️ écart +133 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | (Demander mon devis→ 5,0 /5 ★★★★★ Sur ·) | 157 → 234 | ⚠️ écart +77 px |
| 4 | (★★★★★« Nous avons comparé une embauche) | (« Devis clair reçu le lendemain, sans ) | 386 → 360 | ≈ proche |
| 5 | (★★★★★Google« Même intervenante chaque ) | (« Même intervenante chaque semaine dan) | 710 → 995 | ⚠️ écart +285 px |
| 6 | Un avis ne remplace pas un devis | Un avis ne remplace pas un devis | 288 → 443 | ⚠️ écart +155 px |
| 7 | À votre tour ? | À votre tour ? | 319 → 258 | ⚠️ écart -61 px |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 57 | ≈ proche |
| 2 | Conseils & repères | Conseils & repères | 339 → 337 | ✅ identique |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 75 → 145 | ⚠️ écart +70 px |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 427 → 578 | ⚠️ écart +151 px |
| 5 | Les autres articles | Les autres articles | 642 → 723 | ⚠️ écart +81 px |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 314 → 368 | ≈ proche |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 174 → 218 | ≈ proche |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Demandez votre devis gratuit | (Accueil/Demande de devis) | 900 → 57 | ⚠️ écart -843 px |
| 2 | — | Demandez votre devis gratuit | — → 279 | ➕ en plus côté WordPress |
| 3 | — | Votre demande | — → 1144 | ➕ en plus côté WordPress |
| 4 | — | (★★★★★« Devis clair reçu le lendemain, ) | — → 304 | ➕ en plus côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 57 | ≈ proche |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 449 → 504 | ≈ proche |
| 3 | Comment choisir la bonne prestation ? | Comment choisir la bonne prestation ? | 359 → 693 | ⚠️ écart +334 px |
| 4 | Ce qui est commun aux six prestations | Ce qui est commun aux six prestations | 307 → 437 | ⚠️ écart +130 px |
| 5 | (Nettoyage de bureauxUn entretien régul) | (Nettoyage de bureaux Un entretien régu) | 1197 → 1035 | ⚠️ écart -162 px |
| 6 | Besoin d'aide pour choisir ? | Besoin d'aide pour choisir ? | 334 → 258 | ⚠️ écart -76 px |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 57 | ≈ proche |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 661 → 406 | ⚠️ écart -255 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 202 → 234 | ≈ proche |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 492 → 300 | ⚠️ écart -192 px |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 516 → 544 | ≈ proche |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 731 → 868 | ⚠️ écart +137 px |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 560 → 403 | ⚠️ écart -157 px |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 862 → 1159 | ⚠️ écart +297 px |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 700 → 823 | ⚠️ écart +123 px |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 763 → 828 | ⚠️ écart +65 px |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 433 → 437 | ✅ identique |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 735 → 1033 | ⚠️ écart +298 px |
| 13 | Cahier des charges, intervenants et suivi | Cahier des charges, intervenants et suivi | 674 → 404 | ⚠️ écart -270 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | (« Nous avons comparé une embauche et u) | 396 → 276 | ⚠️ écart -120 px |
| 15 | Trois situations concrètes | Trois situations concrètes | 552 → 448 | ⚠️ écart -104 px |
| 16 | Le tarif, en toute transparence | Le tarif, en toute transparence | 450 → 749 | ⚠️ écart +299 px |
| 17 | Pour aller plus loin | Pour aller plus loin | 286 → 401 | ⚠️ écart +115 px |
| 18 | Questions fréquentes | Questions fréquentes | 976 → 1045 | ⚠️ écart +69 px |
| 19 | Un projet d'entretien pour vos locaux ? | Un projet d'entretien pour vos locaux ? | 339 → 258 | ⚠️ écart -81 px |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Bureaux) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Le nettoyage de bureau) | 363 → 331 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 648 → 770 | ⚠️ écart +122 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 452 | ⚠️ écart +67 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 553 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1052 | ⚠️ écart -110 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 779 | ≈ proche |
| 9 | Une semaine type | Une semaine type | 401 → 358 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 361 | ⚠️ écart -64 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Bureaux | Questions fréquentes — Bureaux | 797 → 937 | ⚠️ écart +140 px |
| 13 | (Encore une question sur Bureaux ? Audr) | (Encore une question sur Bureaux ? Audr) | 97 → 187 | ⚠️ écart +90 px |
| 14 | Un devis pour Bureaux | Un devis pour Bureaux | 317 → 363 | ≈ proche |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Commerces) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe La propreté d'un comme) | 363 → 301 | ⚠️ écart -62 px |
| 4 | Pour qui ? | Pour qui ? | 561 → 631 | ⚠️ écart +70 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 336 → 452 | ⚠️ écart +116 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 553 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1111 → 971 | ⚠️ écart -140 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 752 | ⚠️ écart -64 px |
| 9 | Une semaine type | Une semaine type | 401 → 330 | ⚠️ écart -71 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Commerces | Questions fréquentes — Commerces | 722 → 849 | ⚠️ écart +127 px |
| 13 | (Encore une question sur Commerces ? Au) | (Encore une question sur Commerces ? Au) | 97 → 187 | ⚠️ écart +90 px |
| 14 | Un devis pour Commerces | Un devis pour Commerces | 317 → 363 | ≈ proche |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Cabinets) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 503 → 546 | ≈ proche |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe Un cabinet reçoit du p) | 491 → 392 | ⚠️ écart -99 px |
| 4 | Pour qui ? | Pour qui ? | 640 → 582 | ≈ proche |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que Top-Famille Pro ne réalise pas | 513 → 417 | ⚠️ écart -96 px |
| 6 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 480 | ⚠️ écart +95 px |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 560 | ≈ proche |
| 8 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1034 → 944 | ⚠️ écart -90 px |
| 9 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 865 → 779 | ⚠️ écart -86 px |
| 10 | Une semaine type | Une semaine type | 401 → 358 | ≈ proche |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 12 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 13 | Questions fréquentes — Cabinets | Questions fréquentes — Cabinets | 797 → 937 | ⚠️ écart +140 px |
| 14 | (Encore une question sur Cabinets ? Aud) | (Encore une question sur Cabinets ? Aud) | 97 → 187 | ⚠️ écart +90 px |
| 15 | Un devis pour Cabinets | Un devis pour Cabinets | 317 → 363 | ≈ proche |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Copropriétés) | 42 → 57 | ≈ proche |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe Nous travaillons avec ) | 363 → 301 | ⚠️ écart -62 px |
| 4 | Pour qui ? | Pour qui ? | 640 → 561 | ⚠️ écart -79 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 452 | ⚠️ écart +67 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 553 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1104 → 1135 | ≈ proche |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 768 → 698 | ⚠️ écart -70 px |
| 9 | Une semaine type | Une semaine type | 452 → 386 | ⚠️ écart -66 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Copropriétés | Questions fréquentes — Copropriétés | 797 → 937 | ⚠️ écart +140 px |
| 13 | (Encore une question sur Copropriétés ?) | (Encore une question sur Copropriétés ?) | 97 → 187 | ⚠️ écart +90 px |
| 14 | Un devis pour Copropriétés | Un devis pour Copropriétés | 317 → 363 | ≈ proche |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Locations meublées) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 520 → 546 | ≈ proche |
| 3 | (Réponse directePour les locations meub) | (Réponse directe Pour les locations meu) | 459 → 392 | ⚠️ écart -67 px |
| 4 | Pour qui ? | Pour qui ? | 616 → 677 | ⚠️ écart +61 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 480 | ⚠️ écart +95 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 601 → 553 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1025 | ⚠️ écart -137 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 840 → 779 | ⚠️ écart -61 px |
| 9 | Une semaine type | Une semaine type | 452 → 358 | ⚠️ écart -94 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Locations meublées | Questions fréquentes — Locations meublées | 797 → 980 | ⚠️ écart +183 px |
| 13 | (Encore une question sur Locations meub) | (Encore une question sur Locations meub) | 136 → 187 | ≈ proche |
| 14 | Un devis pour Locations meublées | Un devis pour Locations meublées | 317 → 413 | ⚠️ écart +96 px |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 57 | ≈ proche |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 363 → 331 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 561 → 629 | ⚠️ écart +68 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 360 → 425 | ⚠️ écart +65 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 560 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1136 → 1162 | ≈ proche |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 744 → 670 | ⚠️ écart -74 px |
| 9 | Une semaine type | Une semaine type | 452 → 358 | ⚠️ écart -94 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 797 → 937 | ⚠️ écart +140 px |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 97 → 187 | ⚠️ écart +90 px |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 317 → 363 | ≈ proche |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Notre fonctionnement) | (Accueil/Notre fonctionnement) | 42 → 57 | ≈ proche |
| 2 | Notre fonctionnement | Notre fonctionnement | 314 → 446 | ⚠️ écart +132 px |
| 3 | (01Prise de contactVous nous décrivez v) | (Vous nous décrivez vos locaux (surface) | 1034 → 637 | ⚠️ écart -397 px |
| 4 | Les informations dont nous avons besoin | Les informations dont nous avons besoin | 1567 → 1362 | ⚠️ écart -205 px |
| 5 | Prêt à démarrer ? | Prêt à démarrer ? | 317 → 258 | ≈ proche |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | (Réponse directe La Côte-d'Or est notre) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Côte-d'Or | Notre couverture en Côte-d'Or | 1486 → 1438 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1617 | ⚠️ écart +1063 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 564 | ⚠️ écart +112 px |
| 8 | Entretien régulier ou intervention ponctuelle | Entretien régulier ou intervention ponctuelle | 1118 → 1018 | ⚠️ écart -100 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Côte-d'Or | Questions fréquentes — Côte-d'Or | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 434 → 421 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Doubs, notre se) | (Réponse directe Dans le Doubs, notre s) | 291 → 289 | ✅ identique |
| 5 | Notre couverture dans le Doubs | Notre couverture dans le Doubs | 1103 → 1103 | ✅ identique |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 535 | ⚠️ écart +108 px |
| 8 | Les cabinets de santé : ce que nous faisons, c | Les cabinets de santé : ce que nous faisons, c | 1178 → 1118 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Doubs | Questions fréquentes — Doubs | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Jura, nous inte) | (Réponse directe Dans le Jura, nous int) | 291 → 259 | ≈ proche |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Deux bassins distincts : Dole et Lons-le-Sauni | 1379 → 1414 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 401 → 535 | ⚠️ écart +134 px |
| 8 | Fonctionnement et suivi | Fonctionnement et suivi | 1091 → 959 | ⚠️ écart -132 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Jura | Questions fréquentes — Jura | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans la Nièvre, notre s) | (Réponse directe Dans la Nièvre, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans la Nièvre | Notre couverture dans la Nièvre | 1433 → 1326 | ⚠️ écart -107 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 535 | ⚠️ écart +131 px |
| 8 | Organisation des déplacements | Organisation des déplacements | 1064 → 975 | ⚠️ écart -89 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Nièvre | Questions fréquentes — Nièvre | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeEn Haute-Saône, notre s) | (Réponse directe En Haute-Saône, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Haute-Saône | Notre couverture en Haute-Saône | 1433 → 1398 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 535 | ⚠️ écart +83 px |
| 8 | Accès, clés et interventions hors horaires | Accès, clés et interventions hors horaires | 1091 → 959 | ⚠️ écart -132 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Haute-Saône | Questions fréquentes — Haute-Saône | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | (Réponse directe En Saône-et-Loire, nos) | 291 → 259 | ≈ proche |
| 5 | Deux bassins le long de l'axe Saône | Deux bassins le long de l'axe Saône | 1106 → 1047 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 535 | ⚠️ écart +131 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Industrie, agroalimentaire et viticulture : ce | 1124 → 947 | ⚠️ écart -177 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Saône-et-Loire | Questions fréquentes — Saône-et-Loire | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 401 → 389 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans l'Yonne, notre sec) | (Réponse directe Dans l'Yonne, notre se) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans l'Yonne | Notre couverture dans l'Yonne | 1379 → 1370 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fonctionnement et suivi à distance | Fonctionnement et suivi à distance | 1064 → 931 | ⚠️ écart -133 px |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Yonne | Questions fréquentes — Yonne | 614 → 695 | ⚠️ écart +81 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 401 → 424 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Territoire de B) | (Réponse directe Dans le Territoire de ) | 291 → 259 | ≈ proche |
| 5 | Un département compact, entièrement autour de  | Un département compact, entièrement autour de  | 1443 → 1414 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 1265 | ⚠️ écart +711 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 535 | ⚠️ écart +108 px |
| 8 | Interventions en soirée : comment cela s'organ | Interventions en soirée : comment cela s'organ | 1064 → 1018 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 256 | ⚠️ écart +84 px |
| 10 | Questions fréquentes — Territoire de Belfort | Questions fréquentes — Territoire de Belfort | 614 → 739 | ⚠️ écart +125 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 413 | ⚠️ écart +94 px |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 57 | ≈ proche |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 383 → 377 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 186 → 234 | ≈ proche |
| 4 | (Réponse directeNous intervenons unique) | (Nous intervenons uniquement en Bourgog) | 323 → 264 | ≈ proche |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 1391 → 1008 | ⚠️ écart -383 px |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | (Bourgogne-Franche-ComtéLa page régiona) | 192 → 172 | ≈ proche |
| 7 | Les huit départements | Les huit départements | 429 → 691 | ⚠️ écart +262 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 344 → 815 | ⚠️ écart +471 px |
| 9 | Premières communes secondaires | Premières communes secondaires | 327 → 691 | ⚠️ écart +364 px |
| 10 | Départements, villes et communes : comment lir | Départements, villes et communes : comment lir | 1163 → 883 | ⚠️ écart -280 px |
| 11 | (Découvrir nos prestationsBureaux, comm) | (Découvrir nos prestationsBureaux, comm) | 193 → 296 | ⚠️ écart +103 px |
| 12 | Questions fréquentes sur nos zones d'intervent | Questions fréquentes sur nos zones d'intervent | 614 → 695 | ⚠️ écart +81 px |
| 13 | Votre commune est-elle couverte ? | Votre commune est-elle couverte ? | 346 → 258 | ⚠️ écart -88 px |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Contact) | (Accueil/Contact) | 42 → 57 | ≈ proche |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 178 → 180 | ✅ identique |
| 3 | (J'ai une question Formulaire court, ré) | Audrey Brançon | 152 → 387 | ⚠️ écart +235 px |
| 4 | (Nom Entreprise (facultatif) E-mail Tél) | Une demande précise ? | 731 → 381 | ⚠️ écart -350 px |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 526 → 377 | ⚠️ écart -149 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 186 → 234 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Top-Famille Pro est une entreprise de ) | 323 → 264 | ≈ proche |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Notre implantation réelle : Saint-Apollinaire, | 2022 → 1777 | ⚠️ écart -245 px |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Nos prestations partout en Bourgogne-Franche-C | 576 → 595 | ≈ proche |
| 7 | Les huit départements couverts | Les huit départements couverts | 733 → 845 | ⚠️ écart +112 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 424 → 773 | ⚠️ écart +349 px |
| 9 | Un tarif régional unique | Un tarif régional unique | 478 → 650 | ⚠️ écart +172 px |
| 10 | Sélection des intervenants et suivi | Sélection des intervenants et suivi | 1540 → 1115 | ⚠️ écart -425 px |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes — Bourgogne-Franche-Comté | 684 → 782 | ⚠️ écart +98 px |
| 12 | Vos locaux, où que vous soyez en région | Vos locaux, où que vous soyez en région | 319 → 258 | ⚠️ écart -61 px |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directe Top-Famille Pro est un) | 323 → 289 | ≈ proche |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Une entreprise implantée à Saint-Apollinaire,  | 2003 → 2033 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Espaces, tâches et fréquences | Espaces, tâches et fréquences | 1513 → 1438 | ⚠️ écart -75 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 374 → 549 | ⚠️ écart +175 px |
| 10 | Dans le même département | Dans le même département | 385 → 564 | ⚠️ écart +179 px |
| 11 | Questions fréquentes — Dijon | Questions fréquentes — Dijon | 684 → 782 | ⚠️ écart +98 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 323 → 289 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 1059 → 1162 | ⚠️ écart +103 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 564 | ⚠️ écart +86 px |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 1174 → 1031 | ⚠️ écart -143 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 386 → 535 | ⚠️ écart +149 px |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 684 → 782 | ⚠️ écart +98 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Besançon | Notre positionnement à Besançon | 1750 → 1708 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Commerces du centre historique et immeubles an | Commerces du centre historique et immeubles an | 1489 → 1470 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Besançon | Questions fréquentes — Besançon | 684 → 782 | ⚠️ écart +98 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre position sur le bassin dolois | Notre position sur le bassin dolois | 1816 → 1765 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 535 | ≈ proche |
| 8 | Fréquences, horaires et matériel | Fréquences, horaires et matériel | 1566 → 1466 | ⚠️ écart -100 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Dole | Questions fréquentes — Dole | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Lons-le-Saunier | Notre positionnement à Lons-le-Saunier | 1911 → 2021 | ⚠️ écart +110 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | Agroalimentaire et thermalisme : notre périmèt | 1528 → 1326 | ⚠️ écart -202 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Lons-le-Saunier | Questions fréquentes — Lons-le-Saunier | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Nevers | Notre positionnement à Nevers | 1891 → 1933 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Accès aux immeubles et aux locaux | Accès aux immeubles et aux locaux | 1394 → 1270 | ⚠️ écart -124 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 484 | ⚠️ écart +208 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Nevers | Questions fréquentes — Nevers | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Vesoul | Notre positionnement à Vesoul | 1929 → 1821 | ⚠️ écart -108 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fréquences et créneaux hors horaires | Fréquences et créneaux hors horaires | 1516 → 1482 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Vesoul | Questions fréquentes — Vesoul | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement sur le Grand Chalon | Notre positionnement sur le Grand Chalon | 1789 → 1821 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 564 | ⚠️ écart +147 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1516 → 1438 | ⚠️ écart -78 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Chalon-sur-Saône | Questions fréquentes — Chalon-sur-Saône | 614 → 739 | ⚠️ écart +125 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement à Mâcon | Notre positionnement à Mâcon | 1866 → 1749 | ⚠️ écart -117 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 404 → 535 | ⚠️ écart +131 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1463 → 1442 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Mâcon | Questions fréquentes — Mâcon | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Auxerre | Notre positionnement à Auxerre | 1789 → 1749 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 564 | ⚠️ écart +147 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1543 → 1510 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Auxerre | Questions fréquentes — Auxerre | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Belfort | Notre positionnement à Belfort | 1843 → 1877 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fréquences et créneaux en soirée | Fréquences et créneaux en soirée | 1489 → 1454 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 420 | ⚠️ écart +144 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Belfort | Questions fréquentes — Belfort | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 57 | ≈ proche |
| 2 | Une entreprise régionale, un visage | Une entreprise régionale, un visage | 612 → 632 | ≈ proche |
| 3 | (« Mon rôle, c'est de rester joignable ) | (« Mon rôle, c'est de rester joignable ) | 277 → 208 | ⚠️ écart -69 px |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | (Basée à Saint-Apollinaire, nous reston) | 321 → 390 | ⚠️ écart +69 px |
| 5 | Qui nous sommes | Qui nous sommes | 2083 → 1538 | ⚠️ écart -545 px |
| 6 | Parlons de vos locaux | Parlons de vos locaux | 277 → 277 | ✅ identique |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Recrutement) | (Accueil/Recrutement) | 42 → 57 | ≈ proche |
| 2 | Rejoindre Top-Famille Pro | Rejoindre Top-Famille Pro | 496 → 377 | ⚠️ écart -119 px |
| 3 | Les missions que nous confions | Les missions que nous confions | 321 → 378 | ≈ proche |
| 4 | Ce que nous attendons | Ce que nous attendons | 384 → 463 | ⚠️ écart +79 px |
| 5 | Envie de nous rejoindre ? | Envie de nous rejoindre ? | 329 → 190 | ⚠️ écart -139 px |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Mentions légales) | (Accueil/Mentions légales) | 42 → 57 | ≈ proche |
| 2 | Mentions légales | Mentions légales | 263 → 180 | ⚠️ écart -83 px |
| 3 | Éditeur du site | Éditeur du site | 888 → 1851 | ⚠️ écart +963 px |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Politique de confidentialité) | (Accueil/Politique de confidentialité) | 42 → 57 | ≈ proche |
| 2 | Politique de confidentialité | Politique de confidentialité | 263 → 180 | ⚠️ écart -83 px |
| 3 | Données collectées | Responsable du traitement | 810 → 1818 | ⚠️ écart +1008 px |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Gestion des cookies) | (Accueil/Gestion des cookies) | 42 → 57 | ≈ proche |
| 2 | Gestion des cookies | Gestion des cookies | 286 → 180 | ⚠️ écart -106 px |
| 3 | Cookies strictement nécessaires | Aucun cookie de mesure d'audience ni de traçag | 569 → 1118 | ⚠️ écart +549 px |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Plan du site) | (Accueil/Plan du site) | 42 → 57 | ≈ proche |
| 2 | Plan du site | Plan du site | 937 → 139 | ⚠️ écart -798 px |
| 3 | Pages légales et utilitaires | Pages principales | 175 → 1055 | ⚠️ écart +880 px |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (Accueil/Conseils/Combien coûte le nett) | 42 → 57 | ≈ proche |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 728 → 696 | ≈ proche |
| 3 | (Le nettoyage de bureaux est facturé au) | (Le nettoyage de bureaux est facturé au) | 242 → 240 | ✅ identique |
| 4 | (Sommaire Comment se calcule le prix du) | (Sommaire Comment se calcule le prix du) | 397 → 420 | ≈ proche |
| 5 | Comment se calcule le prix du nettoyage de bur | Comment se calcule le prix du nettoyage de bur | 1198 → 1130 | ⚠️ écart -68 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 253 → 365 | ⚠️ écart +112 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 501 | ⚠️ écart +159 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 244 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 363 | ≈ proche |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (Accueil/Conseils/À quelle fréquence fa) | 42 → 57 | ≈ proche |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 728 → 696 | ≈ proche |
| 3 | (La fréquence adaptée dépend surtout de) | (La fréquence adaptée dépend surtout de) | 242 → 240 | ✅ identique |
| 4 | (Sommaire Ce qui détermine la bonne fré) | (Sommaire Ce qui détermine la bonne fré) | 367 → 390 | ≈ proche |
| 5 | Ce qui détermine la bonne fréquence | Ce qui détermine la bonne fréquence | 1099 → 1210 | ⚠️ écart +111 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 278 → 391 | ⚠️ écart +113 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 501 | ⚠️ écart +159 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 244 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 363 | ≈ proche |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (Accueil/Conseils/Comment rédiger un ca) | 42 → 57 | ≈ proche |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 728 → 732 | ✅ identique |
| 3 | (Un cahier des charges de nettoyage pro) | (Un cahier des charges de nettoyage pro) | 242 → 270 | ≈ proche |
| 4 | (Sommaire Pourquoi un cahier des charge) | (Sommaire Pourquoi un cahier des charge) | 397 → 420 | ≈ proche |
| 5 | Pourquoi un cahier des charges change tout | Pourquoi un cahier des charges change tout | 1324 → 1455 | ⚠️ écart +131 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 227 → 365 | ⚠️ écart +138 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 501 | ⚠️ écart +159 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 373 | ⚠️ écart +171 px |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 363 | ≈ proche |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est imp) | (Réponse directe Top-Famille Pro est im) | 323 → 289 | ≈ proche |
| 5 | Notre implantation réelle, et rien d'autre | Notre implantation réelle, et rien d'autre | 1163 → 1146 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 564 | ⚠️ écart +86 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1200 → 1144 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 428 | ⚠️ écart +200 px |
| 10 | Dans le même département | Dans le même département | 386 → 535 | ⚠️ écart +149 px |
| 11 | Questions fréquentes — Saint-Apollinaire | Questions fréquentes — Saint-Apollinaire | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeChenôve est une commune) | (Réponse directe Chenôve est une commun) | 323 → 289 | ≈ proche |
| 5 | Chenôve dans l'agglomération dijonnaise | Chenôve dans l'agglomération dijonnaise | 1203 → 1190 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Commerces, bureaux et cabinets | Commerces, bureaux et cabinets | 1163 → 1187 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Chenôve | Questions fréquentes — Chenôve | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeQuetigny est une commun) | (Réponse directe Quetigny est une commu) | 291 → 289 | ✅ identique |
| 5 | Quetigny, commune voisine de notre implantatio | Quetigny, commune voisine de notre implantatio | 1140 → 1206 | ⚠️ écart +66 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 535 | ⚠️ écart +83 px |
| 8 | Bureaux, cabinets et parties communes | Bureaux, cabinets et parties communes | 1148 → 987 | ⚠️ écart -161 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 386 → 535 | ⚠️ écart +149 px |
| 11 | Questions fréquentes — Quetigny | Questions fréquentes — Quetigny | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTalant est une commune ) | (Réponse directe Talant est une commune) | 323 → 289 | ≈ proche |
| 5 | Talant, commune limitrophe de Dijon | Talant, commune limitrophe de Dijon | 1083 → 1118 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Cabinets, commerces et petits bureaux | Cabinets, commerces et petits bureaux | 1110 → 1075 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Talant | Questions fréquentes — Talant | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeLongvic est une commune) | (Réponse directe Longvic est une commun) | 323 → 259 | ⚠️ écart -64 px |
| 5 | Longvic, commune d'activité au sud de Dijon | Longvic, commune d'activité au sud de Dijon | 1110 → 1206 | ⚠️ écart +96 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Bureaux, commerces, cabinets et parties commun | Bureaux, commerces, cabinets et parties commun | 1110 → 1174 | ⚠️ écart +64 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 386 → 535 | ⚠️ écart +149 px |
| 11 | Questions fréquentes — Longvic | Questions fréquentes — Longvic | 614 → 695 | ⚠️ écart +81 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | (Réponse directe Fontaine-lès-Dijon est) | 323 → 289 | ≈ proche |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Fontaine-lès-Dijon dans l'agglomération | 1409 → 1485 | ⚠️ écart +76 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1163 → 1075 | ⚠️ écart -88 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 364 | ⚠️ écart +136 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | Questions fréquentes — Fontaine-lès-Dijon | 614 → 739 | ⚠️ écart +125 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 507 → 546 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeMarsannay-la-Côte est u) | (Réponse directe Marsannay-la-Côte est ) | 323 → 289 | ≈ proche |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Marsannay-la-Côte, entre agglomération et Côte | 1090 → 1178 | ⚠️ écart +88 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 784 | ⚠️ écart +144 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Événements et périodes de forte fréquentation | Événements et périodes de forte fréquentation | 1121 → 1074 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 392 | ⚠️ écart +164 px |
| 10 | Dans le même département | Dans le même département | 385 → 535 | ⚠️ écart +150 px |
| 11 | Questions fréquentes — Marsannay-la-Côte | Questions fréquentes — Marsannay-la-Côte | 614 → 739 | ⚠️ écart +125 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

