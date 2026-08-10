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
| `#/` | `/` | 13 → 13 | 7825 → 7937 (101 %) | 1058 → 1129 (107 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 5999 (103 %) | 951 → 962 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4047 → 4308 (106 %) | 1038 → 1058 (102 %) | 12 → 14 | 15 → 28 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2938 → 3389 (115 %) | 613 → 644 (105 %) | 3 → 5 | 15 → 28 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 3319 (117 %) | 465 → 472 (102 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 1947 → 2206 (113 %) | 366 → 385 (105 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3510 → 3735 (106 %) | 808 → 780 (97 %) | 5 → 7 | 15 → 28 | 8 → 3 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11177 (100 %) | 2560 → 2579 (101 %) | 44 → 46 | 29 → 42 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7745 → 7731 (100 %) | 2074 → 2079 (100 %) | 30 → 32 | 28 → 42 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7484 → 7385 (99 %) | 1868 → 1860 (100 %) | 30 → 32 | 25 → 39 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8321 → 8004 (96 %) | 2055 → 2008 (98 %) | 31 → 33 | 33 → 47 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7684 → 7549 (98 %) | 2010 → 1963 (98 %) | 31 → 33 | 26 → 40 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7955 → 7755 (97 %) | 2086 → 2076 (100 %) | 30 → 32 | 26 → 40 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 7598 (100 %) | 1950 → 1941 (100 %) | 31 → 33 | 25 → 39 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4095 → 3920 (96 %) | 966 → 998 (103 %) | 9 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 6704 (104 %) | 1376 → 1357 (99 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 6348 (103 %) | 1271 → 1241 (98 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 6401 (102 %) | 1261 → 1232 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 6429 (102 %) | 1284 → 1260 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 6464 (101 %) | 1308 → 1278 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 6179 (102 %) | 1222 → 1191 (97 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 6457 (103 %) | 1278 → 1254 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 6494 (103 %) | 1310 → 1282 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 6231 (92 %) | 1321 → 1298 (98 %) | 12 → 14 | 20 → 33 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 1926 (100 %) | 309 → 302 (98 %) | 1 → 6 | 15 → 28 | 3 → 3 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 8123 (94 %) | 1955 → 1965 (101 %) | 17 → 19 | 27 → 41 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 8673 (102 %) | 1918 → 2031 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 7246 (102 %) | 1445 → 1536 (106 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8076 → 8372 (104 %) | 1822 → 1927 (106 %) | 19 → 27 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8199 → 8341 (102 %) | 1806 → 1905 (105 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8205 → 8484 (103 %) | 1794 → 1893 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8077 → 8318 (103 %) | 1733 → 1841 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8211 → 8437 (103 %) | 1778 → 1884 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8062 → 8370 (104 %) | 1761 → 1860 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8072 → 8278 (103 %) | 1690 → 1789 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8089 → 8400 (104 %) | 1759 → 1867 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8098 → 8316 (103 %) | 1758 → 1862 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4433 → 4154 (94 %) | 1108 → 1135 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2394 → 2438 (102 %) | 387 → 400 (103 %) | 5 → 7 | 19 → 32 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 2773 (138 %) | 409 → 559 (137 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 2887 (149 %) | 399 → 598 (150 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2169 (126 %) | 345 → 479 (139 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2088 (106 %) | 315 → 335 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 4835 (106 %) | 839 → 800 (95 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 4909 (111 %) | 771 → 777 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 5307 (114 %) | 741 → 766 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7164 → 7313 (102 %) | 1438 → 1531 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7115 → 7340 (103 %) | 1431 → 1524 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7031 → 7250 (103 %) | 1409 → 1502 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6942 → 7167 (103 %) | 1356 → 1449 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6995 → 7172 (103 %) | 1421 → 1514 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7322 → 7588 (104 %) | 1449 → 1542 (106 %) | 18 → 26 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6993 → 7255 (104 %) | 1374 → 1467 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |

## Synthèse à 375 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 13402 → 13747 (103 %) | 1039 → 1109 (107 %) | 11 → 13 | 15 → 31 | 11 → 11 | non | — |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9002 → 9803 (109 %) | 932 → 942 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | — |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 7837 → 8277 (106 %) | 1019 → 1038 (102 %) | 12 → 14 | 15 → 28 | 2 → 3 | non | — |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6173 → 6805 (110 %) | 594 → 624 (105 %) | 3 → 5 | 15 → 28 | 2 → 3 | non | — |
| `#/conseils` | `/conseils/` | 7 → 7 | 5147 → 5722 (111 %) | 446 → 452 (101 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4175 → 4369 (105 %) | 347 → 365 (105 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | — |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 7784 → 6746 (87 %) | 789 → 760 (96 %) | 5 → 7 | 15 → 28 | 8 → 3 | non | — |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 20090 → 20204 (101 %) | 2541 → 2559 (101 %) | 44 → 46 | 29 → 42 | 10 → 3 | non | — |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 14541 → 15309 (105 %) | 2055 → 2059 (100 %) | 30 → 32 | 28 → 42 | 3 → 4 | non | — |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 13666 → 14426 (106 %) | 1849 → 1840 (100 %) | 30 → 32 | 25 → 39 | 3 → 4 | non | — |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 15216 → 15656 (103 %) | 2036 → 1988 (98 %) | 31 → 33 | 33 → 47 | 3 → 4 | non | — |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 14360 → 14913 (104 %) | 1991 → 1943 (98 %) | 31 → 33 | 26 → 40 | 3 → 4 | non | — |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 14559 → 15443 (106 %) | 2067 → 2056 (99 %) | 30 → 32 | 26 → 40 | 3 → 4 | non | — |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 14029 → 14771 (105 %) | 1931 → 1921 (99 %) | 31 → 33 | 25 → 39 | 3 → 4 | non | — |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 7285 → 7873 (108 %) | 947 → 978 (103 %) | 9 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 11568 → 12032 (104 %) | 1357 → 1337 (99 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 10618 → 10765 (101 %) | 1252 → 1221 (98 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 10758 → 10823 (101 %) | 1242 → 1212 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 10687 → 10947 (102 %) | 1265 → 1240 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 10944 → 11000 (101 %) | 1289 → 1258 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 10599 → 10667 (101 %) | 1203 → 1171 (97 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 10662 → 10915 (102 %) | 1259 → 1234 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 10736 → 10978 (102 %) | 1291 → 1262 (98 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | — |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 12442 → 10688 (86 %) | 1302 → 1278 (98 %) | 12 → 14 | 20 → 33 | 2 → 3 | non | — |
| `#/contact` | `/contact/` | 4 → 4 | 4257 → 3501 (82 %) | 290 → 282 (97 %) | 1 → 6 | 15 → 28 | 3 → 3 | non | — |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 16603 → 15043 (91 %) | 1936 → 1945 (100 %) | 17 → 19 | 27 → 41 | 3 → 3 | non | — |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 14937 → 16054 (107 %) | 1899 → 2011 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 12426 → 12920 (104 %) | 1426 → 1516 (106 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 14479 → 15154 (105 %) | 1803 → 1907 (106 %) | 19 → 27 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 14319 → 14731 (103 %) | 1787 → 1885 (105 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 14567 → 15098 (104 %) | 1775 → 1873 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 14211 → 14731 (104 %) | 1714 → 1821 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 14408 → 15064 (105 %) | 1759 → 1864 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 14389 → 14910 (104 %) | 1742 → 1840 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 14071 → 14541 (103 %) | 1671 → 1769 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 14172 → 14908 (105 %) | 1740 → 1847 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 14145 → 14830 (105 %) | 1739 → 1842 (106 %) | 20 → 28 | 27 → 42 | 3 → 4 | non | — |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 8257 → 8076 (98 %) | 1089 → 1115 (102 %) | 10 → 12 | 15 → 28 | 3 → 3 | non | — |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4729 → 4729 (100 %) | 368 → 380 (103 %) | 5 → 7 | 19 → 32 | 3 → 3 | non | — |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 3759 → 4928 (131 %) | 390 → 539 (138 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | — |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3607 → 5039 (140 %) | 380 → 578 (152 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | — |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3263 → 4106 (126 %) | 326 → 459 (141 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | — |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4579 → 4838 (106 %) | 296 → 315 (106 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | — |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 6564 → 6962 (106 %) | 820 → 780 (95 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | — |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6427 → 7089 (110 %) | 752 → 757 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | — |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6450 → 7442 (115 %) | 722 → 746 (103 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | — |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 12481 → 12877 (103 %) | 1419 → 1511 (106 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 12309 → 12828 (104 %) | 1412 → 1504 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 12218 → 12620 (103 %) | 1390 → 1482 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 11930 → 12343 (103 %) | 1337 → 1429 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 12220 → 12597 (103 %) | 1402 → 1494 (107 %) | 17 → 25 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 12771 → 13322 (104 %) | 1430 → 1522 (106 %) | 18 → 26 | 27 → 42 | 3 → 4 | non | — |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 12128 → 12698 (105 %) | 1355 → 1447 (107 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |

## Détail bloc par bloc à 1440 px

### `#/` → `/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Nettoyage professionnel de bureaux et locaux e | Nettoyage professionnel de bureaux et locaux e | 762 → 751 | ≈ proche |
| 2 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique, indiqué avant ) | 146 → 157 | ≈ proche |
| 3 | (★★★★★5,0/5 sur Google Saint-Apollinair) | (Saint-Apollinaire Entreprise régionale) | 218 → 218 | ✅ identique |
| 4 | Pensé pour les professionnels de la région | Pensé pour les professionnels de la région | 432 → 409 | ≈ proche |
| 5 | Nos prestations de nettoyage | Nos prestations de nettoyage | 800 → 804 | ✅ identique |
| 6 | Les difficultés que nous prenons en charge | Les difficultés que nous prenons en charge | 534 → 543 | ≈ proche |
| 7 | Pourquoi Top-Famille Pro | Pourquoi Top-Famille Pro | 592 → 588 | ✅ identique |
| 8 | Notre fonctionnement, en cinq temps | Notre fonctionnement, en cinq temps | 511 → 543 | ≈ proche |
| 9 | Un tarif clair, affiché avant le devis | Un tarif clair, affiché avant le devis | 597 → 596 | ✅ identique |
| 10 | Une couverture régionale, pas des agences fict | Une couverture régionale, pas des agences fict | 569 → 608 | ≈ proche |
| 11 | Audrey, votre interlocutrice | Audrey, votre interlocutrice | 698 → 730 | ≈ proche |
| 12 | Conseils & repères | Conseils & repères | 653 → 674 | ≈ proche |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 447 → 450 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 57 | ≈ proche |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 362 → 381 | ≈ proche |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 277 → 311 | ≈ proche |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 277 → 204 | ⚠️ écart -73 px |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 131 → 180 | ≈ proche |
| 6 | Le détail de nos frais | Le détail de nos frais | 638 → 616 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 313 → 426 | ⚠️ écart +113 px |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 403 → 296 | ⚠️ écart -107 px |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 606 → 632 | ≈ proche |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 492 → 523 | ≈ proche |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 745 → 762 | ≈ proche |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 405 → 385 | ≈ proche |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 339 → 359 | ≈ proche |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 57 | ≈ proche |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 314 → 515 | ⚠️ écart +201 px |
| 3 | (Directement joignableAudrey est votre ) | (Audrey est votre interlocutrice identi) | 509 → 524 | ≈ proche |
| 4 | Des preuves plutôt que des slogans | Des preuves plutôt que des slogans | 376 → 266 | ⚠️ écart -110 px |
| 5 | Ce qui nous distingue, concrètement | Ce qui nous distingue, concrètement | 789 → 1085 | ⚠️ écart +296 px |
| 6 | Les objections que l'on nous adresse | Les objections que l'on nous adresse | 488 → 429 | ≈ proche |
| 7 | Vérifier par vous-même | Vérifier par vous-même | 390 → 337 | ≈ proche |
| 8 | Faisons connaissance | Faisons connaissance | 319 → 228 | ⚠️ écart -91 px |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (Accueil/Avis clients) | 42 → 57 | ≈ proche |
| 2 | Avis de nos clients | Avis de nos clients | 215 → 375 | ⚠️ écart +160 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | (Demander mon devis→ 5,0 /5 ★★★★★ Sur ·) | 157 → 207 | ≈ proche |
| 4 | (★★★★★« Nous avons comparé une embauche) | (« Devis clair reçu le lendemain, sans ) | 386 → 354 | ≈ proche |
| 5 | (★★★★★Google« Même intervenante chaque ) | (« Même intervenante chaque semaine dan) | 710 → 965 | ⚠️ écart +255 px |
| 6 | Un avis ne remplace pas un devis | Un avis ne remplace pas un devis | 288 → 337 | ≈ proche |
| 7 | À votre tour ? | À votre tour ? | 319 → 228 | ⚠️ écart -91 px |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 57 | ≈ proche |
| 2 | Conseils & repères | Conseils & repères | 339 → 374 | ≈ proche |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 75 → 145 | ⚠️ écart +70 px |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 427 → 578 | ⚠️ écart +151 px |
| 5 | Les autres articles | Les autres articles | 642 → 715 | ⚠️ écart +73 px |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 314 → 366 | ≈ proche |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 174 → 218 | ≈ proche |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Demandez votre devis gratuit | (Aller au contenu principal) | 900 → 52 | ⚠️ écart -848 px |
| 2 | — | Demandez votre devis gratuit | — → 2206 | ➕ en plus côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 57 | ≈ proche |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 449 → 665 | ⚠️ écart +216 px |
| 3 | Comment choisir la bonne prestation ? | Comment choisir la bonne prestation ? | 359 → 565 | ⚠️ écart +206 px |
| 4 | Ce qui est commun aux six prestations | Ce qui est commun aux six prestations | 307 → 421 | ⚠️ écart +114 px |
| 5 | (Nettoyage de bureauxUn entretien régul) | (Nettoyage de bureaux Un entretien régu) | 1197 → 933 | ⚠️ écart -264 px |
| 6 | Besoin d'aide pour choisir ? | Besoin d'aide pour choisir ? | 334 → 228 | ⚠️ écart -106 px |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 57 | ≈ proche |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 661 → 497 | ⚠️ écart -164 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 202 → 207 | ✅ identique |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 492 → 300 | ⚠️ écart -192 px |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 516 → 524 | ✅ identique |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 731 → 851 | ⚠️ écart +120 px |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 560 → 312 | ⚠️ écart -248 px |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 862 → 986 | ⚠️ écart +124 px |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 700 → 1117 | ⚠️ écart +417 px |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 763 → 938 | ⚠️ écart +175 px |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 433 → 385 | ≈ proche |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 735 → 1019 | ⚠️ écart +284 px |
| 13 | Cahier des charges, intervenants et suivi | Cahier des charges, intervenants et suivi | 674 → 368 | ⚠️ écart -306 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | (« Nous avons comparé une embauche et u) | 396 → 270 | ⚠️ écart -126 px |
| 15 | Trois situations concrètes | Trois situations concrètes | 552 → 606 | ≈ proche |
| 16 | Le tarif, en toute transparence | Le tarif, en toute transparence | 450 → 514 | ⚠️ écart +64 px |
| 17 | Pour aller plus loin | Pour aller plus loin | 286 → 295 | ≈ proche |
| 18 | Questions fréquentes | Questions fréquentes | 976 → 837 | ⚠️ écart -139 px |
| 19 | Un projet d'entretien pour vos locaux ? | Un projet d'entretien pour vos locaux ? | 339 → 228 | ⚠️ écart -111 px |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Bureaux) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Le nettoyage de bureau) | 363 → 331 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 648 → 754 | ⚠️ écart +106 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 444 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1044 | ⚠️ écart -118 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 771 | ≈ proche |
| 9 | Une semaine type | Une semaine type | 401 → 349 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 361 | ⚠️ écart -64 px |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 12 | Questions fréquentes — Bureaux | Questions fréquentes — Bureaux | 797 → 768 | ≈ proche |
| 13 | (Encore une question sur Bureaux ? Audr) | (Encore une question sur Bureaux ? Audr) | 97 → 193 | ⚠️ écart +96 px |
| 14 | Un devis pour Bureaux | Un devis pour Bureaux | 317 → 357 | ≈ proche |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Commerces) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe La propreté d'un comme) | 363 → 301 | ⚠️ écart -62 px |
| 4 | Pour qui ? | Pour qui ? | 561 → 614 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 336 → 444 | ⚠️ écart +108 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1111 → 962 | ⚠️ écart -149 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 816 → 744 | ⚠️ écart -72 px |
| 9 | Une semaine type | Une semaine type | 401 → 321 | ⚠️ écart -80 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 12 | Questions fréquentes — Commerces | Questions fréquentes — Commerces | 722 → 701 | ≈ proche |
| 13 | (Encore une question sur Commerces ? Au) | (Encore une question sur Commerces ? Au) | 97 → 193 | ⚠️ écart +96 px |
| 14 | Un devis pour Commerces | Un devis pour Commerces | 317 → 357 | ≈ proche |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Cabinets) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 503 → 546 | ≈ proche |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe Un cabinet reçoit du p) | 491 → 392 | ⚠️ écart -99 px |
| 4 | Pour qui ? | Pour qui ? | 640 → 565 | ⚠️ écart -75 px |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que Top-Famille Pro ne réalise pas | 513 → 447 | ⚠️ écart -66 px |
| 6 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 471 | ⚠️ écart +86 px |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 590 | ≈ proche |
| 8 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1034 → 935 | ⚠️ écart -99 px |
| 9 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 865 → 771 | ⚠️ écart -94 px |
| 10 | Une semaine type | Une semaine type | 401 → 349 | ≈ proche |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 12 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 13 | Questions fréquentes — Cabinets | Questions fréquentes — Cabinets | 797 → 768 | ≈ proche |
| 14 | (Encore une question sur Cabinets ? Aud) | (Encore une question sur Cabinets ? Aud) | 97 → 193 | ⚠️ écart +96 px |
| 15 | Un devis pour Cabinets | Un devis pour Cabinets | 317 → 357 | ≈ proche |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Copropriétés) | 42 → 57 | ≈ proche |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe Nous travaillons avec ) | 363 → 301 | ⚠️ écart -62 px |
| 4 | Pour qui ? | Pour qui ? | 640 → 544 | ⚠️ écart -96 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 444 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1104 → 1127 | ≈ proche |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 768 → 689 | ⚠️ écart -79 px |
| 9 | Une semaine type | Une semaine type | 452 → 377 | ⚠️ écart -75 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 12 | Questions fréquentes — Copropriétés | Questions fréquentes — Copropriétés | 797 → 768 | ≈ proche |
| 13 | (Encore une question sur Copropriétés ?) | (Encore une question sur Copropriétés ?) | 97 → 193 | ⚠️ écart +96 px |
| 14 | Un devis pour Copropriétés | Un devis pour Copropriétés | 317 → 357 | ≈ proche |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Locations meublées) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 520 → 573 | ≈ proche |
| 3 | (Réponse directePour les locations meub) | (Réponse directe Pour les locations meu) | 459 → 392 | ⚠️ écart -67 px |
| 4 | Pour qui ? | Pour qui ? | 616 → 660 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 385 → 471 | ⚠️ écart +86 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 601 → 583 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1162 → 1017 | ⚠️ écart -145 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 840 → 771 | ⚠️ écart -69 px |
| 9 | Une semaine type | Une semaine type | 452 → 349 | ⚠️ écart -103 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 12 | Questions fréquentes — Locations meublées | Questions fréquentes — Locations meublées | 797 → 768 | ≈ proche |
| 13 | (Encore une question sur Locations meub) | (Encore une question sur Locations meub) | 136 → 193 | ≈ proche |
| 14 | Un devis pour Locations meublées | Un devis pour Locations meublées | 317 → 357 | ≈ proche |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 57 | ≈ proche |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 363 → 331 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 561 → 612 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 360 → 416 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 590 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1136 → 1154 | ≈ proche |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 744 → 662 | ⚠️ écart -82 px |
| 9 | Une semaine type | Une semaine type | 452 → 349 | ⚠️ écart -103 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 305 | ⚠️ écart -79 px |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 797 → 768 | ≈ proche |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 97 → 193 | ⚠️ écart +96 px |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 317 → 357 | ≈ proche |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Notre fonctionnement) | (Accueil/Notre fonctionnement) | 42 → 57 | ≈ proche |
| 2 | Notre fonctionnement | Notre fonctionnement | 314 → 515 | ⚠️ écart +201 px |
| 3 | (01Prise de contactVous nous décrivez v) | (01 Prise de contact Vous nous décrivez) | 1034 → 922 | ⚠️ écart -112 px |
| 4 | Les informations dont nous avons besoin | Les informations dont nous avons besoin | 1567 → 1332 | ⚠️ écart -235 px |
| 5 | Prêt à démarrer ? | Prêt à démarrer ? | 317 → 228 | ⚠️ écart -89 px |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | (Réponse directe La Côte-d'Or est notre) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Côte-d'Or | Notre couverture en Côte-d'Or | 1486 → 1485 | ✅ identique |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 559 | ✅ identique |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 564 | ⚠️ écart +112 px |
| 8 | Entretien régulier ou intervention ponctuelle | Entretien régulier ou intervention ponctuelle | 1118 → 1096 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Côte-d'Or | Questions fréquentes — Côte-d'Or | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 434 → 494 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Doubs, notre se) | (Réponse directe Dans le Doubs, notre s) | 291 → 289 | ✅ identique |
| 5 | Notre couverture dans le Doubs | Notre couverture dans le Doubs | 1103 → 1085 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 535 | ⚠️ écart +108 px |
| 8 | Les cabinets de santé : ce que nous faisons, c | Les cabinets de santé : ce que nous faisons, c | 1178 → 1213 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Doubs | Questions fréquentes — Doubs | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Jura, nous inte) | (Réponse directe Dans le Jura, nous int) | 291 → 259 | ≈ proche |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Deux bassins distincts : Dole et Lons-le-Sauni | 1379 → 1317 | ⚠️ écart -62 px |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 401 → 535 | ⚠️ écart +134 px |
| 8 | Fonctionnement et suivi | Fonctionnement et suivi | 1091 → 1096 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Jura | Questions fréquentes — Jura | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans la Nièvre, notre s) | (Réponse directe Dans la Nièvre, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans la Nièvre | Notre couverture dans la Nièvre | 1433 → 1401 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 535 | ⚠️ écart +131 px |
| 8 | Organisation des déplacements | Organisation des déplacements | 1064 → 1040 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Nièvre | Questions fréquentes — Nièvre | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeEn Haute-Saône, notre s) | (Réponse directe En Haute-Saône, notre ) | 291 → 259 | ≈ proche |
| 5 | Notre couverture en Haute-Saône | Notre couverture en Haute-Saône | 1433 → 1380 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 452 → 535 | ⚠️ écart +83 px |
| 8 | Accès, clés et interventions hors horaires | Accès, clés et interventions hors horaires | 1091 → 1096 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Haute-Saône | Questions fréquentes — Haute-Saône | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | (Réponse directe En Saône-et-Loire, nos) | 291 → 259 | ≈ proche |
| 5 | Deux bassins le long de l'axe Saône | Deux bassins le long de l'axe Saône | 1106 → 1092 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 404 → 535 | ⚠️ écart +131 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Industrie, agroalimentaire et viticulture : ce | 1124 → 1099 | ≈ proche |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Saône-et-Loire | Questions fréquentes — Saône-et-Loire | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans l'Yonne, notre sec) | (Réponse directe Dans l'Yonne, notre se) | 291 → 259 | ≈ proche |
| 5 | Notre couverture dans l'Yonne | Notre couverture dans l'Yonne | 1379 → 1373 | ✅ identique |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fonctionnement et suivi à distance | Fonctionnement et suivi à distance | 1064 → 1068 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Yonne | Questions fréquentes — Yonne | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 401 → 462 | ⚠️ écart +61 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeDans le Territoire de B) | (Réponse directe Dans le Territoire de ) | 291 → 259 | ≈ proche |
| 5 | Un département compact, entièrement autour de  | Un département compact, entièrement autour de  | 1443 → 1438 | ✅ identique |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 554 → 452 | ⚠️ écart -102 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 427 → 535 | ⚠️ écart +108 px |
| 8 | Interventions en soirée : comment cela s'organ | Interventions en soirée : comment cela s'organ | 1064 → 1068 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 172 → 226 | ≈ proche |
| 10 | Questions fréquentes — Territoire de Belfort | Questions fréquentes — Territoire de Belfort | 614 → 561 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 319 → 351 | ≈ proche |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 57 | ≈ proche |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 383 → 461 | ⚠️ écart +78 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 186 → 207 | ≈ proche |
| 4 | (Réponse directeNous intervenons unique) | (Nous intervenons uniquement en Bourgog) | 323 → 258 | ⚠️ écart -65 px |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 1391 → 923 | ⚠️ écart -468 px |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | (Bourgogne-Franche-ComtéLa page régiona) | 192 → 150 | ≈ proche |
| 7 | Les huit départements | Les huit départements | 429 → 477 | ≈ proche |
| 8 | Nos dix villes principales | Nos dix villes principales | 344 → 549 | ⚠️ écart +205 px |
| 9 | Premières communes secondaires | Premières communes secondaires | 327 → 477 | ⚠️ écart +150 px |
| 10 | Départements, villes et communes : comment lir | Départements, villes et communes : comment lir | 1163 → 798 | ⚠️ écart -365 px |
| 11 | (Découvrir nos prestationsBureaux, comm) | (Découvrir nos prestationsBureaux, comm) | 193 → 223 | ≈ proche |
| 12 | Questions fréquentes sur nos zones d'intervent | Questions fréquentes sur nos zones d'intervent | 614 → 561 | ≈ proche |
| 13 | Votre commune est-elle couverte ? | Votre commune est-elle couverte ? | 346 → 222 | ⚠️ écart -124 px |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Contact) | (Accueil/Contact) | 42 → 57 | ≈ proche |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 178 → 234 | ≈ proche |
| 3 | (J'ai une question Formulaire court, ré) | Audrey Brançon | 152 → 387 | ⚠️ écart +235 px |
| 4 | (Nom Entreprise (facultatif) E-mail Tél) | Une demande précise ? | 731 → 381 | ⚠️ écart -350 px |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 526 → 455 | ⚠️ écart -71 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Voir les tarifs→ 27 € HT/h tarif uniqu) | 186 → 207 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Top-Famille Pro est une entreprise de ) | 323 → 258 | ⚠️ écart -65 px |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Notre implantation réelle : Saint-Apollinaire, | 2022 → 1666 | ⚠️ écart -356 px |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Nos prestations partout en Bourgogne-Franche-C | 576 → 432 | ⚠️ écart -144 px |
| 7 | Les huit départements couverts | Les huit départements couverts | 733 → 802 | ⚠️ écart +69 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 424 → 864 | ⚠️ écart +440 px |
| 9 | Un tarif régional unique | Un tarif régional unique | 478 → 603 | ⚠️ écart +125 px |
| 10 | Sélection des intervenants et suivi | Sélection des intervenants et suivi | 1540 → 1061 | ⚠️ écart -479 px |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes — Bourgogne-Franche-Comté | 684 → 629 | ≈ proche |
| 12 | Vos locaux, où que vous soyez en région | Vos locaux, où que vous soyez en région | 319 → 222 | ⚠️ écart -97 px |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directe Top-Famille Pro est un) | 323 → 289 | ≈ proche |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Une entreprise implantée à Saint-Apollinaire,  | 2003 → 1928 | ⚠️ écart -75 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Espaces, tâches et fréquences | Espaces, tâches et fréquences | 1513 → 1457 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 374 → 453 | ⚠️ écart +79 px |
| 10 | Dans le même département | Dans le même département | 385 → 401 | ≈ proche |
| 11 | Questions fréquentes — Dijon | Questions fréquentes — Dijon | 684 → 629 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 323 → 289 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 1059 → 1015 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 564 | ⚠️ écart +86 px |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 1174 → 1124 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 684 → 629 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Besançon | Notre positionnement à Besançon | 1750 → 1725 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Commerces du centre historique et immeubles an | Commerces du centre historique et immeubles an | 1489 → 1485 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Besançon | Questions fréquentes — Besançon | 684 → 629 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre position sur le bassin dolois | Notre position sur le bassin dolois | 1816 → 1793 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 535 | ≈ proche |
| 8 | Fréquences, horaires et matériel | Fréquences, horaires et matériel | 1566 → 1513 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Dole | Questions fréquentes — Dole | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Lons-le-Saunier | Notre positionnement à Lons-le-Saunier | 1911 → 1873 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | Agroalimentaire et thermalisme : notre périmèt | 1528 → 1545 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Lons-le-Saunier | Questions fréquentes — Lons-le-Saunier | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Nevers | Notre positionnement à Nevers | 1891 → 1847 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Accès aux immeubles et aux locaux | Accès aux immeubles et aux locaux | 1394 → 1377 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Nevers | Questions fréquentes — Nevers | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Vesoul | Notre positionnement à Vesoul | 1929 → 1858 | ⚠️ écart -71 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fréquences et créneaux hors horaires | Fréquences et créneaux hors horaires | 1516 → 1485 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Vesoul | Questions fréquentes — Vesoul | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement sur le Grand Chalon | Notre positionnement sur le Grand Chalon | 1789 → 1793 | ✅ identique |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 564 | ⚠️ écart +147 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1516 → 1513 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Chalon-sur-Saône | Questions fréquentes — Chalon-sur-Saône | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 259 | ≈ proche |
| 5 | Notre positionnement à Mâcon | Notre positionnement à Mâcon | 1866 → 1814 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 404 → 535 | ⚠️ écart +131 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1463 → 1429 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Mâcon | Questions fréquentes — Mâcon | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Auxerre | Notre positionnement à Auxerre | 1789 → 1793 | ✅ identique |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 417 → 564 | ⚠️ écart +147 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 1543 → 1513 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Auxerre | Questions fréquentes — Auxerre | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 291 → 289 | ✅ identique |
| 5 | Notre positionnement à Belfort | Notre positionnement à Belfort | 1843 → 1821 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fréquences et créneaux en soirée | Fréquences et créneaux en soirée | 1489 → 1401 | ⚠️ écart -88 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 276 → 341 | ⚠️ écart +65 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Belfort | Questions fréquentes — Belfort | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 57 | ≈ proche |
| 2 | Une entreprise régionale, un visage | Une entreprise régionale, un visage | 612 → 751 | ⚠️ écart +139 px |
| 3 | (« Mon rôle, c'est de rester joignable ) | (« Mon rôle, c'est de rester joignable ) | 277 → 202 | ⚠️ écart -75 px |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | (Basée à Saint-Apollinaire, nous reston) | 321 → 384 | ⚠️ écart +63 px |
| 5 | Qui nous sommes | Qui nous sommes | 2083 → 1670 | ⚠️ écart -413 px |
| 6 | Parlons de vos locaux | Parlons de vos locaux | 277 → 222 | ≈ proche |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Recrutement) | (Accueil/Recrutement) | 42 → 57 | ≈ proche |
| 2 | Rejoindre Top-Famille Pro | Rejoindre Top-Famille Pro | 496 → 439 | ≈ proche |
| 3 | Les missions que nous confions | Les missions que nous confions | 321 → 364 | ≈ proche |
| 4 | Ce que nous attendons | Ce que nous attendons | 384 → 530 | ⚠️ écart +146 px |
| 5 | Envie de nous rejoindre ? | Envie de nous rejoindre ? | 329 → 181 | ⚠️ écart -148 px |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Mentions légales) | (Accueil/Mentions légales) | 42 → 57 | ≈ proche |
| 2 | Mentions légales | Mentions légales | 263 → 195 | ⚠️ écart -68 px |
| 3 | Éditeur du site | Éditeur du site | 888 → 1654 | ⚠️ écart +766 px |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Politique de confidentialité) | (Accueil/Politique de confidentialité) | 42 → 57 | ≈ proche |
| 2 | Politique de confidentialité | Politique de confidentialité | 263 → 195 | ⚠️ écart -68 px |
| 3 | Données collectées | Responsable du traitement | 810 → 1768 | ⚠️ écart +958 px |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Gestion des cookies) | (Accueil/Gestion des cookies) | 42 → 57 | ≈ proche |
| 2 | Gestion des cookies | Gestion des cookies | 286 → 195 | ⚠️ écart -91 px |
| 3 | Cookies strictement nécessaires | Aucun cookie de mesure d'audience ni de traçag | 569 → 1050 | ⚠️ écart +481 px |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Plan du site) | (Accueil/Plan du site) | 42 → 57 | ≈ proche |
| 2 | Plan du site | Plan du site | 937 → 154 | ⚠️ écart -783 px |
| 3 | Pages légales et utilitaires | Pages principales | 175 → 1009 | ⚠️ écart +834 px |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (Accueil/Conseils/Combien coûte le nett) | 42 → 57 | ≈ proche |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 728 → 752 | ≈ proche |
| 3 | (Le nettoyage de bureaux est facturé au) | (Le nettoyage de bureaux est facturé au) | 242 → 240 | ✅ identique |
| 4 | (Sommaire Comment se calcule le prix du) | (Sommaire Comment se calcule le prix du) | 397 → 420 | ≈ proche |
| 5 | Comment se calcule le prix du nettoyage de bur | Comment se calcule le prix du nettoyage de bur | 1198 → 1136 | ⚠️ écart -62 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 253 → 350 | ⚠️ écart +97 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 425 | ⚠️ écart +83 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 238 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (Accueil/Conseils/À quelle fréquence fa) | 42 → 57 | ≈ proche |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 728 → 752 | ≈ proche |
| 3 | (La fréquence adaptée dépend surtout de) | (La fréquence adaptée dépend surtout de) | 242 → 240 | ✅ identique |
| 4 | (Sommaire Ce qui détermine la bonne fré) | (Sommaire Ce qui détermine la bonne fré) | 367 → 390 | ≈ proche |
| 5 | Ce qui détermine la bonne fréquence | Ce qui détermine la bonne fréquence | 1099 → 1215 | ⚠️ écart +116 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 278 → 376 | ⚠️ écart +98 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 425 | ⚠️ écart +83 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 238 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (Accueil/Conseils/Comment rédiger un ca) | 42 → 57 | ≈ proche |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 728 → 752 | ≈ proche |
| 3 | (Un cahier des charges de nettoyage pro) | (Un cahier des charges de nettoyage pro) | 242 → 270 | ≈ proche |
| 4 | (Sommaire Pourquoi un cahier des charge) | (Sommaire Pourquoi un cahier des charge) | 397 → 420 | ≈ proche |
| 5 | Pourquoi un cahier des charges change tout | Pourquoi un cahier des charges change tout | 1324 → 1461 | ⚠️ écart +137 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 227 → 350 | ⚠️ écart +123 px |
| 7 | Questions fréquentes | Questions fréquentes | 342 → 425 | ⚠️ écart +83 px |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 202 → 355 | ⚠️ écart +153 px |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 317 → 349 | ≈ proche |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est imp) | (Réponse directe Top-Famille Pro est im) | 323 → 289 | ≈ proche |
| 5 | Notre implantation réelle, et rien d'autre | Notre implantation réelle, et rien d'autre | 1163 → 1092 | ⚠️ écart -71 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 564 | ⚠️ écart +86 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1200 → 1127 | ⚠️ écart -73 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 339 | ⚠️ écart +111 px |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Saint-Apollinaire | Questions fréquentes — Saint-Apollinaire | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeChenôve est une commune) | (Réponse directe Chenôve est une commun) | 323 → 289 | ≈ proche |
| 5 | Chenôve dans l'agglomération dijonnaise | Chenôve dans l'agglomération dijonnaise | 1203 → 1153 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Commerces, bureaux et cabinets | Commerces, bureaux et cabinets | 1163 → 1148 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Chenôve | Questions fréquentes — Chenôve | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeQuetigny est une commun) | (Réponse directe Quetigny est une commu) | 291 → 289 | ✅ identique |
| 5 | Quetigny, commune voisine de notre implantatio | Quetigny, commune voisine de notre implantatio | 1140 → 1116 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 535 | ⚠️ écart +83 px |
| 8 | Bureaux, cabinets et parties communes | Bureaux, cabinets et parties communes | 1148 → 1124 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Quetigny | Questions fréquentes — Quetigny | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeTalant est une commune ) | (Réponse directe Talant est une commune) | 323 → 289 | ≈ proche |
| 5 | Talant, commune limitrophe de Dijon | Talant, commune limitrophe de Dijon | 1083 → 1064 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Cabinets, commerces et petits bureaux | Cabinets, commerces et petits bureaux | 1110 → 1092 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Talant | Questions fréquentes — Talant | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeLongvic est une commune) | (Réponse directe Longvic est une commun) | 323 → 259 | ⚠️ écart -64 px |
| 5 | Longvic, commune d'activité au sud de Dijon | Longvic, commune d'activité au sud de Dijon | 1110 → 1071 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 452 → 564 | ⚠️ écart +112 px |
| 8 | Bureaux, commerces, cabinets et parties commun | Bureaux, commerces, cabinets et parties commun | 1110 → 1092 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 386 → 388 | ✅ identique |
| 11 | Questions fréquentes — Longvic | Questions fréquentes — Longvic | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | (Réponse directe Fontaine-lès-Dijon est) | 323 → 289 | ≈ proche |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Fontaine-lès-Dijon dans l'agglomération | 1409 → 1401 | ✅ identique |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 564 | ⚠️ écart +137 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1163 → 1148 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 285 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | Questions fréquentes — Fontaine-lès-Dijon | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 507 → 546 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeMarsannay-la-Côte est u) | (Réponse directe Marsannay-la-Côte est ) | 323 → 289 | ≈ proche |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Marsannay-la-Côte, entre agglomération et Côte | 1090 → 1097 | ✅ identique |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 683 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 427 → 535 | ⚠️ écart +108 px |
| 8 | Événements et périodes de forte fréquentation | Événements et périodes de forte fréquentation | 1121 → 1124 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 309 | ⚠️ écart +81 px |
| 10 | Dans le même département | Dans le même département | 385 → 388 | ✅ identique |
| 11 | Questions fréquentes — Marsannay-la-Côte | Questions fréquentes — Marsannay-la-Côte | 614 → 561 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 291 → 232 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 351 | ≈ proche |

