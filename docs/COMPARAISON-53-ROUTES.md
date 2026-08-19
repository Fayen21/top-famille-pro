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

## Synthèse à 375 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 13402 → 13586 (101 %) | 1039 → 1102 (106 %) | 11 → 13 | 15 → 31 | 11 → 12 | non | [voir](captures/comparaison/accueil-375.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 9002 → 9209 (102 %) | 932 → 936 (100 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-375.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 7837 → 8174 (104 %) | 1019 → 1028 (101 %) | 12 → 14 | 15 → 47 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-375.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 6173 → 6253 (101 %) | 594 → 621 (105 %) | 3 → 5 | 15 → 41 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-375.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 5147 → 5222 (101 %) | 446 → 438 (98 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-375.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 4 | 4175 → 4242 (102 %) | 347 → 383 (110 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | [voir](captures/comparaison/demande-de-devis-375.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 7784 → 7853 (101 %) | 789 → 806 (102 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | [voir](captures/comparaison/nos-prestations-375.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 20090 → 20341 (101 %) | 2541 → 2543 (100 %) | 44 → 46 | 29 → 85 | 10 → 11 | non | [voir](captures/comparaison/nettoyage-professionnel-375.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 14541 → 14637 (101 %) | 2055 → 2056 (100 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-375.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 13666 → 13825 (101 %) | 1849 → 1854 (100 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-375.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 15216 → 15221 (100 %) | 2036 → 2032 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-375.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 14360 → 14582 (102 %) | 1991 → 1994 (100 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-375.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 14559 → 14782 (102 %) | 2067 → 2070 (100 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-375.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 14029 → 14233 (101 %) | 1931 → 1935 (100 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-375.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 7285 → 7367 (101 %) | 947 → 964 (102 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-375.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 11568 → 11858 (103 %) | 1357 → 1351 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-375.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 10618 → 10796 (102 %) | 1252 → 1235 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-375.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 10758 → 10862 (101 %) | 1242 → 1226 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-375.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 10687 → 10918 (102 %) | 1265 → 1253 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-375.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 10944 → 11101 (101 %) | 1289 → 1272 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-375.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 10599 → 10574 (100 %) | 1203 → 1185 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-375.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 10662 → 10869 (102 %) | 1259 → 1248 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-375.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 10736 → 10945 (102 %) | 1291 → 1276 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-375.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 12442 → 12379 (99 %) | 1302 → 1293 (99 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-375.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 4257 → 4429 (104 %) | 290 → 333 (115 %) | 1 → 4 | 15 → 38 | 3 → 4 | non | [voir](captures/comparaison/contact-375.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 16603 → 16342 (98 %) | 1936 → 1880 (97 %) | 17 → 19 | 27 → 67 | 3 → 4 | non | [voir](captures/comparaison/bourgogne-franche-comte-375.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 14937 → 15270 (102 %) | 1899 → 1895 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-375.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 12426 → 12407 (100 %) | 1426 → 1402 (98 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-375.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 14479 → 14783 (102 %) | 1803 → 1795 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-375.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 14319 → 14484 (101 %) | 1787 → 1771 (99 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-375.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 14567 → 14693 (101 %) | 1775 → 1759 (99 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-375.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 14211 → 14414 (101 %) | 1714 → 1708 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-375.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 14408 → 14690 (102 %) | 1759 → 1751 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-375.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 14389 → 14502 (101 %) | 1742 → 1726 (99 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-375.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 14071 → 14184 (101 %) | 1671 → 1656 (99 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-375.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 14172 → 14396 (102 %) | 1740 → 1735 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-375.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 14145 → 14404 (102 %) | 1739 → 1729 (99 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-375.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 8257 → 8597 (104 %) | 1089 → 1114 (102 %) | 10 → 12 | 15 → 32 | 3 → 4 | non | [voir](captures/comparaison/a-propos-375.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 4729 → 4833 (102 %) | 368 → 379 (103 %) | 5 → 7 | 19 → 39 | 3 → 4 | non | [voir](captures/comparaison/recrutement-375.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 3759 → 4663 (124 %) | 390 → 531 (136 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-375.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 3607 → 4903 (136 %) | 380 → 601 (158 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-375.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 3263 → 3884 (119 %) | 326 → 451 (138 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-375.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 4579 → 4608 (101 %) | 296 → 305 (103 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-375.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 6564 → 6802 (104 %) | 820 → 839 (102 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-375.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 6427 → 6612 (103 %) | 752 → 752 (100 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-375.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 6450 → 6635 (103 %) | 722 → 720 (100 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-375.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 12481 → 12501 (100 %) | 1419 → 1402 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-375.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 12309 → 12392 (101 %) | 1412 → 1396 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-375.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 12218 → 12280 (101 %) | 1390 → 1375 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-375.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 11930 → 11976 (100 %) | 1337 → 1319 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-375.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 12220 → 12198 (100 %) | 1402 → 1384 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-375.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 12771 → 12885 (101 %) | 1430 → 1412 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-375.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 12128 → 12261 (101 %) | 1355 → 1337 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-375.jpg) |

## Synthèse à 1440 px

| Route Claude | Route WordPress | Blocs | Hauteur | Mots | Titres | Puces | Images | Débord. | Triptyque |
|---|---|---|---|---|---|---|---|---|---|
| `#/` | `/` | 13 → 13 | 7825 → 7809 (100 %) | 1058 → 1129 (107 %) | 11 → 13 | 15 → 31 | 11 → 12 | non | [voir](captures/comparaison/accueil-1440.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 5990 (102 %) | 951 → 963 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-1440.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 8 | 4047 → 4147 (102 %) | 1038 → 1055 (102 %) | 12 → 14 | 15 → 47 | 2 → 3 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-1440.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 7 | 2938 → 2964 (101 %) | 613 → 648 (106 %) | 3 → 5 | 15 → 41 | 2 → 3 | non | [voir](captures/comparaison/avis-clients-1440.jpg) |
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 2889 (102 %) | 465 → 465 (100 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | [voir](captures/comparaison/conseils-1440.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 1 → 2 | 1947 → 2010 (103 %) | 366 → 410 (112 %) | 1 → 4 | 15 → 28 | 3 → 4 | non | [voir](captures/comparaison/demande-de-devis-1440.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 6 | 3510 → 3577 (102 %) | 808 → 833 (103 %) | 5 → 7 | 15 → 40 | 8 → 9 | non | [voir](captures/comparaison/nos-prestations-1440.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 19 | 11192 → 11004 (98 %) | 2560 → 2570 (100 %) | 44 → 46 | 29 → 85 | 10 → 11 | non | [voir](captures/comparaison/nettoyage-professionnel-1440.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 14 | 7745 → 7778 (100 %) | 2074 → 2083 (100 %) | 30 → 32 | 28 → 52 | 3 → 4 | non | [voir](captures/comparaison/service-bureaux-1440.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 14 | 7484 → 7400 (99 %) | 1868 → 1881 (101 %) | 30 → 32 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-commerces-1440.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 15 | 8321 → 8284 (100 %) | 2055 → 2059 (100 %) | 31 → 33 | 33 → 57 | 3 → 4 | non | [voir](captures/comparaison/service-cabinets-1440.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 14 | 7684 → 7627 (99 %) | 2010 → 2021 (101 %) | 31 → 33 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-coproprietes-1440.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 14 | 7955 → 7979 (100 %) | 2086 → 2097 (101 %) | 30 → 32 | 26 → 50 | 3 → 4 | non | [voir](captures/comparaison/service-meubles-1440.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 7430 (98 %) | 1950 → 1962 (101 %) | 31 → 33 | 25 → 49 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-1440.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 5 → 5 | 4095 → 4196 (102 %) | 966 → 991 (103 %) | 9 → 11 | 15 → 37 | 2 → 3 | non | [voir](captures/comparaison/notre-fonctionnement-1440.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 11 | 6456 → 6628 (103 %) | 1376 → 1378 (100 %) | 16 → 18 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-cote-dor-1440.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 11 | 6140 → 6372 (104 %) | 1271 → 1262 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-doubs-1440.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 11 | 6271 → 6494 (104 %) | 1261 → 1253 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-jura-1440.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 11 | 6301 → 6492 (103 %) | 1284 → 1280 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-nievre-1440.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 11 | 6376 → 6547 (103 %) | 1308 → 1299 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-haute-saone-1440.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 11 | 6034 → 6226 (103 %) | 1222 → 1212 (99 %) | 14 → 16 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-saone-et-loire-1440.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 11 | 6270 → 6467 (103 %) | 1278 → 1275 (100 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-yonne-1440.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 11 | 6333 → 6502 (103 %) | 1310 → 1303 (99 %) | 15 → 17 | 21 → 35 | 2 → 3 | non | [voir](captures/comparaison/departement-territoire-de-belfort-1440.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 13 | 6753 → 6788 (101 %) | 1321 → 1320 (100 %) | 12 → 14 | 20 → 66 | 2 → 3 | non | [voir](captures/comparaison/zones-intervention-1440.jpg) |
| `#/contact` | `/contact/` | 4 → 4 | 1924 → 1987 (103 %) | 309 → 360 (117 %) | 1 → 4 | 15 → 38 | 3 → 4 | non | [voir](captures/comparaison/contact-1440.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 8731 (101 %) | 1955 → 1907 (98 %) | 17 → 19 | 27 → 67 | 3 → 4 | non | [voir](captures/comparaison/bourgogne-franche-comte-1440.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 8472 (100 %) | 1918 → 1922 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dijon-1440.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 7030 (99 %) | 1445 → 1429 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-beaune-1440.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 13 | 8076 → 8089 (100 %) | 1822 → 1822 (100 %) | 19 → 21 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-besancon-1440.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 13 | 8199 → 8117 (99 %) | 1806 → 1798 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-dole-1440.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 13 | 8205 → 8220 (100 %) | 1794 → 1786 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-lons-le-saunier-1440.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 13 | 8077 → 8070 (100 %) | 1733 → 1735 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-nevers-1440.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 13 | 8211 → 8230 (100 %) | 1778 → 1778 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-vesoul-1440.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 13 | 8062 → 8108 (101 %) | 1761 → 1753 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chalon-sur-saone-1440.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 13 | 8072 → 8055 (100 %) | 1690 → 1683 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-macon-1440.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 13 | 8089 → 8117 (100 %) | 1759 → 1762 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-auxerre-1440.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 13 | 8098 → 8117 (100 %) | 1758 → 1756 (100 %) | 20 → 22 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-belfort-1440.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 6 | 4433 → 4576 (103 %) | 1108 → 1141 (103 %) | 10 → 12 | 15 → 32 | 3 → 4 | non | [voir](captures/comparaison/a-propos-1440.jpg) |
| `#/recrutement` | `/recrutement/` | 5 → 5 | 2394 → 2443 (102 %) | 387 → 406 (105 %) | 5 → 7 | 19 → 39 | 3 → 4 | non | [voir](captures/comparaison/recrutement-1440.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 3 → 3 | 2014 → 2666 (132 %) | 409 → 558 (136 %) | 6 → 10 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/mentions-legales-1440.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 3 → 3 | 1936 → 2763 (143 %) | 399 → 628 (157 %) | 5 → 11 | 15 → 33 | 2 → 3 | non | [voir](captures/comparaison/politique-de-confidentialite-1440.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 3 → 3 | 1718 → 2089 (122 %) | 345 → 478 (139 %) | 4 → 9 | 15 → 28 | 2 → 3 | non | [voir](captures/comparaison/gestion-des-cookies-1440.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 3 → 3 | 1975 → 2048 (104 %) | 315 → 332 (105 %) | 8 → 10 | 65 → 82 | 2 → 3 | non | [voir](captures/comparaison/plan-du-site-1440.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 9 | 4542 → 4635 (102 %) | 839 → 866 (103 %) | 10 → 12 | 26 → 40 | 3 → 4 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-1440.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 9 | 4437 → 4463 (101 %) | 771 → 779 (101 %) | 9 → 11 | 29 → 43 | 3 → 4 | non | [voir](captures/comparaison/article-frequence-bureaux-1440.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 9 | 4643 → 4744 (102 %) | 741 → 747 (101 %) | 10 → 12 | 32 → 46 | 3 → 4 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-1440.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 13 | 7164 → 7092 (99 %) | 1438 → 1429 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-saint-apollinaire-1440.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 13 | 7115 → 7095 (100 %) | 1431 → 1423 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-chenove-1440.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 13 | 7031 → 6990 (99 %) | 1409 → 1402 (100 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-quetigny-1440.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 13 | 6942 → 6893 (99 %) | 1356 → 1346 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-talant-1440.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 13 | 6995 → 6918 (99 %) | 1421 → 1411 (99 %) | 17 → 19 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-longvic-1440.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 13 | 7322 → 7349 (100 %) | 1449 → 1439 (99 %) | 18 → 20 | 27 → 42 | 3 → 4 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-1440.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 13 | 6993 → 7023 (100 %) | 1374 → 1364 (99 %) | 17 → 19 | 21 → 36 | 3 → 4 | non | [voir](captures/comparaison/ville-marsannay-la-cote-1440.jpg) |

## Détail bloc par bloc à 375 px

### `#/` → `/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Nettoyage professionnel de bureaux et locaux e | Nettoyage professionnel de bureaux et locaux e | 1012 → 971 | ≈ proche |
| 2 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 259 → 262 | ✅ identique |
| 3 | (★★★★★5,0/5 sur Google Saint-Apollinair) | (Saint-Apollinaire Entreprise régionale) | 511 → 503 | ✅ identique |
| 4 | Pensé pour les professionnels de la région | Pensé pour les professionnels de la région | 512 → 532 | ≈ proche |
| 5 | Nos prestations de nettoyage | Nos prestations de nettoyage | 1347 → 1396 | ≈ proche |
| 6 | Les difficultés que nous prenons en charge | Les difficultés que nous prenons en charge | 950 → 968 | ≈ proche |
| 7 | Pourquoi Top-Famille Pro | Pourquoi Top-Famille Pro | 952 → 965 | ≈ proche |
| 8 | Notre fonctionnement, en cinq temps | Notre fonctionnement, en cinq temps | 1068 → 898 | ⚠️ écart -170 px |
| 9 | Un tarif clair, affiché avant le devis | Un tarif clair, affiché avant le devis | 876 → 819 | ≈ proche |
| 10 | Une couverture régionale, pas des agences fict | Une couverture régionale, pas des agences fict | 933 → 933 | ✅ identique |
| 11 | Audrey, votre interlocutrice | Audrey, votre interlocutrice | 907 → 1197 | ⚠️ écart +290 px |
| 12 | Conseils & repères | Conseils & repères | 1386 → 1442 | ≈ proche |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 454 → 459 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 47 | ✅ identique |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 405 → 398 | ✅ identique |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 461 → 463 | ✅ identique |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 279 → 300 | ≈ proche |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 174 → 222 | ≈ proche |
| 6 | Le détail de nos frais | Le détail de nos frais | 635 → 588 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 529 → 551 | ≈ proche |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 516 → 496 | ≈ proche |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 1228 → 1337 | ⚠️ écart +109 px |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 651 → 578 | ⚠️ écart -73 px |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 781 → 806 | ≈ proche |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 751 → 818 | ⚠️ écart +67 px |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 343 → 363 | ≈ proche |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 47 | ✅ identique |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 463 → 620 | ⚠️ écart +157 px |
| 3 | (Directement joignableAudrey est votre ) | (Directement joignable Audrey est votre) | 1119 → 1212 | ⚠️ écart +93 px |
| 4 | Des preuves plutôt que des slogans | Des preuves plutôt que des slogans | 552 → 604 | ≈ proche |
| 5 | Ce qui nous distingue, concrètement | Ce qui nous distingue, concrètement | 1855 → 1918 | ⚠️ écart +63 px |
| 6 | Les objections que l'on nous adresse | Les objections que l'on nous adresse | 546 → 510 | ≈ proche |
| 7 | Vérifier par vous-même | Vérifier par vous-même | 719 → 687 | ≈ proche |
| 8 | Faisons connaissance | Faisons connaissance | 335 → 335 | ✅ identique |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (Accueil/Avis clients) | 42 → 47 | ✅ identique |
| 2 | Avis de nos clients | Avis de nos clients | 205 → 357 | ⚠️ écart +152 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | (Demander mon devis) | 201 → 76 | ⚠️ écart -125 px |
| 4 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 674 → 633 | ≈ proche |
| 5 | (★★★★★Google« Même intervenante chaque ) | (Exemples de présentation — témoignages) | 1899 → 1928 | ≈ proche |
| 6 | Un avis ne remplace pas un devis | Un avis ne remplace pas un devis | 611 → 618 | ✅ identique |
| 7 | À votre tour ? | À votre tour ? | 335 → 335 | ✅ identique |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 47 | ✅ identique |
| 2 | Conseils & repères | Conseils & repères | 430 → 426 | ✅ identique |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 115 → 111 | ✅ identique |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 555 → 508 | ≈ proche |
| 5 | Les autres articles | Les autres articles | 963 → 936 | ≈ proche |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 602 → 708 | ⚠️ écart +106 px |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 234 → 245 | ≈ proche |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | Demandez votre devis gratuit | (Aller au contenu principal) | 900 → 52 | ⚠️ écart -848 px |
| 2 | — | Demandez votre devis gratuit | — → 4161 | ➕ en plus côté WordPress |
| 3 | — | (☎ Appeler Demander mon devis) | — → 81 | ➕ en plus côté WordPress |
| 4 | — | () | — → 81 | ➕ en plus côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 47 | ✅ identique |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 572 → 739 | ⚠️ écart +167 px |
| 3 | Comment choisir la bonne prestation ? | Comment choisir la bonne prestation ? | 812 → 804 | ✅ identique |
| 4 | Ce qui est commun aux six prestations | Ce qui est commun aux six prestations | 782 → 860 | ⚠️ écart +78 px |
| 5 | (Nettoyage de bureauxUn entretien régul) | (Nettoyage de bureaux Un entretien régu) | 3009 → 2800 | ⚠️ écart -209 px |
| 6 | Besoin d'aide pour choisir ? | Besoin d'aide pour choisir ? | 361 → 363 | ✅ identique |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 47 | ✅ identique |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 907 → 899 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 295 → 221 | ⚠️ écart -74 px |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 626 → 640 | ≈ proche |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 1001 → 1120 | ⚠️ écart +119 px |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 1346 → 1320 | ≈ proche |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 905 → 893 | ≈ proche |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 1755 → 1760 | ✅ identique |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 1503 → 1507 | ✅ identique |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 1780 → 1847 | ⚠️ écart +67 px |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 862 → 898 | ≈ proche |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 1619 → 1665 | ≈ proche |
| 13 | Cahier des charges, intervenants et suivi | Cahier des charges, intervenants et suivi | 945 → 1032 | ⚠️ écart +87 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | (Exemples de présentation — témoignages) | 396 → 448 | ≈ proche |
| 15 | Trois situations concrètes | Trois situations concrètes | 1137 → 1137 | ✅ identique |
| 16 | Le tarif, en toute transparence | Le tarif, en toute transparence | 783 → 867 | ⚠️ écart +84 px |
| 17 | Pour aller plus loin | Pour aller plus loin | 450 → 413 | ≈ proche |
| 18 | Questions fréquentes | Questions fréquentes | 1186 → 1028 | ⚠️ écart -158 px |
| 19 | Un projet d'entretien pour vos locaux ? | Un projet d'entretien pour vos locaux ? | 343 → 340 | ✅ identique |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Bureaux) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 868 → 857 | ≈ proche |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Le nettoyage de bureau) | 483 → 472 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1313 → 1228 | ⚠️ écart -85 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 571 → 601 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1200 → 1256 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2654 → 2586 | ⚠️ écart -68 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1702 → 1736 | ≈ proche |
| 9 | Une semaine type | Une semaine type | 837 → 831 | ✅ identique |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 612 → 617 | ✅ identique |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 12 | Questions fréquentes — Bureaux | Questions fréquentes — Bureaux | 961 → 911 | ≈ proche |
| 13 | (Encore une question sur Bureaux ? Audr) | (Encore une question sur Bureaux ? Audr) | 156 → 216 | ≈ proche |
| 14 | Un devis pour Bureaux | Un devis pour Bureaux | 332 → 367 | ≈ proche |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Commerces) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 840 → 830 | ≈ proche |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe La propreté d'un comme) | 432 → 421 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1123 → 1088 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 521 → 574 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1175 → 1284 | ⚠️ écart +109 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2449 → 2323 | ⚠️ écart -126 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1529 → 1557 | ≈ proche |
| 9 | Une semaine type | Une semaine type | 757 → 748 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 639 → 643 | ✅ identique |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 12 | Questions fréquentes — Commerces | Questions fréquentes — Commerces | 860 → 818 | ≈ proche |
| 13 | (Encore une question sur Commerces ? Au) | (Encore une question sur Commerces ? Au) | 156 → 216 | ≈ proche |
| 14 | Un devis pour Commerces | Un devis pour Commerces | 332 → 367 | ≈ proche |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Cabinets) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 866 → 885 | ≈ proche |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe Un cabinet reçoit du p) | 637 → 625 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1282 → 1234 | ≈ proche |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que Top-Famille Pro ne réalise pas | 872 → 824 | ≈ proche |
| 6 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 670 → 710 | ≈ proche |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1180 → 1263 | ⚠️ écart +83 px |
| 8 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2353 → 2177 | ⚠️ écart -176 px |
| 9 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1632 → 1659 | ≈ proche |
| 10 | Une semaine type | Une semaine type | 810 → 803 | ✅ identique |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 639 → 643 | ✅ identique |
| 12 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 13 | Questions fréquentes — Cabinets | Questions fréquentes — Cabinets | 935 → 856 | ⚠️ écart -79 px |
| 14 | (Encore une question sur Cabinets ? Aud) | (Encore une question sur Cabinets ? Aud) | 156 → 216 | ≈ proche |
| 15 | Un devis pour Cabinets | Un devis pour Cabinets | 332 → 367 | ≈ proche |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Copropriétés) | 42 → 47 | ✅ identique |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 840 → 830 | ≈ proche |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe Nous travaillons avec ) | 457 → 446 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1274 → 1215 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 595 → 655 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1240 → 1380 | ⚠️ écart +140 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2594 → 2516 | ⚠️ écart -78 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1507 → 1506 | ✅ identique |
| 9 | Une semaine type | Une semaine type | 890 → 913 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 662 → 668 | ✅ identique |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 12 | Questions fréquentes — Copropriétés | Questions fréquentes — Copropriétés | 961 → 911 | ≈ proche |
| 13 | (Encore une question sur Copropriétés ?) | (Encore une question sur Copropriétés ?) | 156 → 216 | ≈ proche |
| 14 | Un devis pour Copropriétés | Un devis pour Copropriétés | 332 → 367 | ≈ proche |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Locations meublées) | 42 → 47 | ✅ identique |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 868 → 857 | ≈ proche |
| 3 | (Réponse directePour les locations meub) | (Réponse directe Pour les locations meu) | 611 → 600 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1202 → 1164 | ≈ proche |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 620 → 682 | ⚠️ écart +62 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1220 → 1305 | ⚠️ écart +85 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2609 → 2535 | ⚠️ écart -74 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1577 → 1608 | ≈ proche |
| 9 | Une semaine type | Une semaine type | 863 → 858 | ✅ identique |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 639 → 668 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 12 | Questions fréquentes — Locations meublées | Questions fréquentes — Locations meublées | 961 → 911 | ≈ proche |
| 13 | (Encore une question sur Locations meub) | (Encore une question sur Locations meub) | 180 → 244 | ⚠️ écart +64 px |
| 14 | Un devis pour Locations meublées | Un devis pour Locations meublées | 357 → 392 | ≈ proche |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 47 | ✅ identique |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 811 → 800 | ≈ proche |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 457 → 446 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 1121 → 1120 | ✅ identique |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 521 → 574 | ≈ proche |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 1205 → 1284 | ⚠️ écart +79 px |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 2703 → 2601 | ⚠️ écart -102 px |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 1409 → 1403 | ✅ identique |
| 9 | Une semaine type | Une semaine type | 888 → 913 | ≈ proche |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 639 → 668 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 602 → 670 | ⚠️ écart +68 px |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 935 → 883 | ≈ proche |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 156 → 216 | ≈ proche |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 332 → 367 | ≈ proche |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Notre fonctionnement) | (Accueil/Notre fonctionnement) | 42 → 47 | ✅ identique |
| 2 | Notre fonctionnement | Notre fonctionnement | 379 → 566 | ⚠️ écart +187 px |
| 3 | (01Prise de contactVous nous décrivez v) | (01 Prise de contact Vous nous décrivez) | 1925 → 1785 | ⚠️ écart -140 px |
| 4 | Les informations dont nous avons besoin | Les informations dont nous avons besoin | 2468 → 2494 | ≈ proche |
| 5 | Prêt à démarrer ? | Prêt à démarrer ? | 264 → 233 | ≈ proche |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 492 → 518 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | (Réponse directe La Côte-d'Or est notre) | 372 → 393 | ≈ proche |
| 5 | Notre couverture en Côte-d'Or | Notre couverture en Côte-d'Or | 2695 → 2685 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1125 → 1177 | ≈ proche |
| 7 | Tarif et déplacements | Tarif et déplacements | 1023 → 1132 | ⚠️ écart +109 px |
| 8 | Entretien régulier ou intervention ponctuelle | Entretien régulier ou intervention ponctuelle | 1967 → 1959 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 225 → 330 | ⚠️ écart +105 px |
| 10 | Questions fréquentes — Côte-d'Or | Questions fréquentes — Côte-d'Or | 753 → 686 | ⚠️ écart -67 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 519 → 545 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeDans le Doubs, notre se) | (Réponse directe Dans le Doubs, notre s) | 347 → 393 | ≈ proche |
| 5 | Notre couverture dans le Doubs | Notre couverture dans le Doubs | 1949 → 1939 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 940 → 813 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 972 → 1075 | ⚠️ écart +103 px |
| 8 | Les cabinets de santé : ce que nous faisons, c | Les cabinets de santé : ce que nous faisons, c | 2096 → 2088 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 225 → 330 | ⚠️ écart +105 px |
| 10 | Questions fréquentes — Doubs | Questions fréquentes — Doubs | 677 → 636 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 492 → 518 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeDans le Jura, nous inte) | (Réponse directe Dans le Jura, nous int) | 321 → 338 | ≈ proche |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Deux bassins distincts : Dole et Lons-le-Sauni | 2378 → 2368 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1011 → 813 | ⚠️ écart -198 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 925 → 999 | ⚠️ écart +74 px |
| 8 | Fonctionnement et suivi | Fonctionnement et suivi | 1863 → 1855 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 171 → 330 | ⚠️ écart +159 px |
| 10 | Questions fréquentes — Jura | Questions fréquentes — Jura | 704 → 663 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 492 → 518 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeDans la Nièvre, notre s) | (Réponse directe Dans la Nièvre, notre ) | 321 → 365 | ≈ proche |
| 5 | Notre couverture dans la Nièvre | Notre couverture dans la Nièvre | 2438 → 2454 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 940 → 813 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 947 → 1023 | ⚠️ écart +76 px |
| 8 | Organisation des déplacements | Organisation des déplacements | 1809 → 1801 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 171 → 330 | ⚠️ écart +159 px |
| 10 | Questions fréquentes — Nièvre | Questions fréquentes — Nièvre | 677 → 636 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 492 → 518 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeEn Haute-Saône, notre s) | (Réponse directe En Haute-Saône, notre ) | 321 → 365 | ≈ proche |
| 5 | Notre couverture en Haute-Saône | Notre couverture en Haute-Saône | 2491 → 2505 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 940 → 813 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 998 → 1079 | ⚠️ écart +81 px |
| 8 | Accès, clés et interventions hors horaires | Accès, clés et interventions hors horaires | 1863 → 1855 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 225 → 330 | ⚠️ écart +105 px |
| 10 | Questions fréquentes — Haute-Saône | Questions fréquentes — Haute-Saône | 700 → 659 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 64 → 47 | ≈ proche |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 492 → 531 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | (Réponse directe En Saône-et-Loire, nos) | 321 → 338 | ≈ proche |
| 5 | Deux bassins le long de l'axe Saône | Deux bassins le long de l'axe Saône | 1919 → 1909 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 1060 → 861 | ⚠️ écart -199 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 948 → 1051 | ⚠️ écart +103 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Industrie, agroalimentaire et viticulture : ce | 1884 → 1876 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 225 → 330 | ⚠️ écart +105 px |
| 10 | Questions fréquentes — Saône-et-Loire | Questions fréquentes — Saône-et-Loire | 807 → 686 | ⚠️ écart -121 px |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 388 → 384 | ✅ identique |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 492 → 518 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeDans l'Yonne, notre sec) | (Réponse directe Dans l'Yonne, notre se) | 321 → 338 | ≈ proche |
| 5 | Notre couverture dans l'Yonne | Notre couverture dans l'Yonne | 2361 → 2351 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 940 → 813 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 998 → 1104 | ⚠️ écart +106 px |
| 8 | Fonctionnement et suivi à distance | Fonctionnement et suivi à distance | 1783 → 1775 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 171 → 330 | ⚠️ écart +159 px |
| 10 | Questions fréquentes — Yonne | Questions fréquentes — Yonne | 704 → 663 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 521 → 518 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeDans le Territoire de B) | (Réponse directe Dans le Territoire de ) | 321 → 365 | ≈ proche |
| 5 | Un département compact, entièrement autour de  | Un département compact, entièrement autour de  | 2462 → 2476 | ≈ proche |
| 6 | Nos villes d'intervention dans le département | Nos villes d'intervention dans le département | 891 → 764 | ⚠️ écart -127 px |
| 7 | Tarif et déplacements | Tarif et déplacements | 972 → 1051 | ⚠️ écart +79 px |
| 8 | Interventions en soirée : comment cela s'organ | Interventions en soirée : comment cela s'organ | 1809 → 1801 | ✅ identique |
| 9 | Départements limitrophes couverts | Départements limitrophes couverts | 171 → 330 | ⚠️ écart +159 px |
| 10 | Questions fréquentes — Territoire de Belfort | Questions fréquentes — Territoire de Belfort | 673 → 631 | ≈ proche |
| 11 | Un devis pour vos locaux dans le département | Un devis pour vos locaux dans le département | 360 → 372 | ≈ proche |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 47 | ✅ identique |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 538 → 526 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 285 → 211 | ⚠️ écart -74 px |
| 4 | (Réponse directeNous intervenons unique) | (Réponse directeNous intervenons unique) | 398 → 417 | ≈ proche |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 2298 → 2386 | ⚠️ écart +88 px |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | (Bourgogne-Franche-ComtéLa page régiona) | 235 → 113 | ⚠️ écart -122 px |
| 7 | Les huit départements | Les huit départements | 1270 → 1267 | ✅ identique |
| 8 | Nos dix villes principales | Nos dix villes principales | 842 → 858 | ≈ proche |
| 9 | Premières communes secondaires | Premières communes secondaires | 683 → 700 | ≈ proche |
| 10 | Départements, villes et communes : comment lir | Départements, villes et communes : comment lir | 2092 → 2147 | ≈ proche |
| 11 | (Découvrir nos prestationsBureaux, comm) | (Découvrir nos prestations Bureaux, com) | 410 → 386 | ≈ proche |
| 12 | Questions fréquentes sur nos zones d'intervent | Questions fréquentes sur nos zones d'intervent | 700 → 635 | ⚠️ écart -65 px |
| 13 | Votre commune est-elle couverte ? | Votre commune est-elle couverte ? | 443 → 409 | ≈ proche |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Contact) | (Accueil/Contact) | 42 → 47 | ✅ identique |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 177 → 180 | ✅ identique |
| 3 | (J'ai une question Formulaire court, ré) | (J’ai une question Formulaire court, ré) | 258 → 250 | ✅ identique |
| 4 | (Nom Entreprise (facultatif) E-mail Tél) | J’ai une question | 1573 → 1711 | ⚠️ écart +138 px |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 64 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 816 → 883 | ⚠️ écart +67 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 285 → 211 | ⚠️ écart -74 px |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directeTop-Famille Pro est une) | 372 → 417 | ≈ proche |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Notre implantation réelle : Saint-Apollinaire, | 3732 → 3832 | ⚠️ écart +100 px |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Nos prestations partout en Bourgogne-Franche-C | 996 → 1004 | ✅ identique |
| 7 | Les huit départements couverts | Les huit départements couverts | 2069 → 1858 | ⚠️ écart -211 px |
| 8 | Nos dix villes principales | Nos dix villes principales | 1009 → 1038 | ≈ proche |
| 9 | Un tarif régional unique | Un tarif régional unique | 1116 → 852 | ⚠️ écart -264 px |
| 10 | Sélection des intervenants et suivi | Sélection des intervenants et suivi | 2726 → 2781 | ≈ proche |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes — Bourgogne-Franche-Comté | 824 → 756 | ⚠️ écart -68 px |
| 12 | Vos locaux, où que vous soyez en région | Vos locaux, où que vous soyez en région | 388 → 373 | ≈ proche |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 803 → 796 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est une) | (Réponse directe Top-Famille Pro est un) | 372 → 393 | ≈ proche |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Une entreprise implantée à Saint-Apollinaire,  | 3625 → 3615 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1044 → 1177 | ⚠️ écart +133 px |
| 8 | Espaces, tâches et fréquences | Espaces, tâches et fréquences | 2694 → 2684 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 701 → 753 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 717 → 861 | ⚠️ écart +144 px |
| 11 | Questions fréquentes — Dijon | Questions fréquentes — Dijon | 721 → 674 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 372 → 393 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 1926 → 1916 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1002 → 1083 | ⚠️ écart +81 px |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 2021 → 2013 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 482 → 523 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 814 → 666 | ⚠️ écart -148 px |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 774 → 729 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 372 → 420 | ≈ proche |
| 5 | Notre positionnement à Besançon | Notre positionnement à Besançon | 3221 → 3211 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 972 → 1100 | ⚠️ écart +128 px |
| 8 | Commerces du centre historique et immeubles an | Commerces du centre historique et immeubles an | 2823 → 2813 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 676 → 768 | ⚠️ écart +92 px |
| 11 | Questions fréquentes — Besançon | Questions fréquentes — Besançon | 824 → 779 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 321 → 365 | ≈ proche |
| 5 | Notre position sur le bassin dolois | Notre position sur le bassin dolois | 3156 → 3200 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1027 → 1111 | ⚠️ écart +84 px |
| 8 | Fréquences, horaires et matériel | Fréquences, horaires et matériel | 2882 → 2872 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 531 → 607 | ⚠️ écart +76 px |
| 10 | Dans le même département | Dans le même département | 717 → 666 | ≈ proche |
| 11 | Questions fréquentes — Dole | Questions fréquentes — Dole | 650 → 608 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 776 → 802 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 393 | ≈ proche |
| 5 | Notre positionnement à Lons-le-Saunier | Notre positionnement à Lons-le-Saunier | 3506 → 3494 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1019 → 1103 | ⚠️ écart +84 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | Agroalimentaire et thermalisme : notre périmèt | 2609 → 2625 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 769 → 666 | ⚠️ écart -103 px |
| 11 | Questions fréquentes — Lons-le-Saunier | Questions fréquentes — Lons-le-Saunier | 726 → 686 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 365 | ≈ proche |
| 5 | Notre positionnement à Nevers | Notre positionnement à Nevers | 3501 → 3489 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1023 → 1107 | ⚠️ écart +84 px |
| 8 | Accès aux immeubles et aux locaux | Accès aux immeubles et aux locaux | 2425 → 2417 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 676 → 768 | ⚠️ écart +92 px |
| 11 | Questions fréquentes — Nevers | Questions fréquentes — Nevers | 650 → 608 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 393 | ≈ proche |
| 5 | Notre positionnement à Vesoul | Notre positionnement à Vesoul | 3346 → 3360 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 998 → 1079 | ⚠️ écart +81 px |
| 8 | Fréquences et créneaux hors horaires | Fréquences et créneaux hors horaires | 2721 → 2735 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 676 → 768 | ⚠️ écart +92 px |
| 11 | Questions fréquentes — Vesoul | Questions fréquentes — Vesoul | 730 → 663 | ⚠️ écart -67 px |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 803 → 815 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 365 | ≈ proche |
| 5 | Notre positionnement sur le Grand Chalon | Notre positionnement sur le Grand Chalon | 3230 → 3220 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 947 → 1023 | ⚠️ écart +76 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 2828 → 2818 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 531 → 607 | ⚠️ écart +76 px |
| 10 | Dans le même département | Dans le même département | 717 → 666 | ≈ proche |
| 11 | Questions fréquentes — Chalon-sur-Saône | Questions fréquentes — Chalon-sur-Saône | 700 → 659 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 393 | ≈ proche |
| 5 | Notre positionnement à Mâcon | Notre positionnement à Mâcon | 3207 → 3197 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 947 → 1023 | ⚠️ écart +76 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 2587 → 2577 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 717 → 666 | ≈ proche |
| 11 | Questions fréquentes — Mâcon | Questions fréquentes — Mâcon | 677 → 636 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 47 | ✅ identique |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 393 | ≈ proche |
| 5 | Notre positionnement à Auxerre | Notre positionnement à Auxerre | 3180 → 3170 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 947 → 1023 | ⚠️ écart +76 px |
| 8 | Fréquences et horaires | Fréquences et horaires | 2756 → 2746 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 676 → 768 | ⚠️ écart +92 px |
| 11 | Questions fréquentes — Auxerre | Questions fréquentes — Auxerre | 677 → 636 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro intervi) | (Réponse directe Top-Famille Pro interv) | 347 → 393 | ≈ proche |
| 5 | Notre positionnement à Belfort | Notre positionnement à Belfort | 3267 → 3257 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 998 → 1079 | ⚠️ écart +81 px |
| 8 | Fréquences et créneaux en soirée | Fréquences et créneaux en soirée | 2591 → 2581 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 555 → 607 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 676 → 768 | ⚠️ écart +92 px |
| 11 | Questions fréquentes — Belfort | Questions fréquentes — Belfort | 677 → 636 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 47 | ✅ identique |
| 2 | Une entreprise régionale, un visage | Une entreprise régionale, un visage | 1259 → 1425 | ⚠️ écart +166 px |
| 3 | (« Mon rôle, c'est de rester joignable ) | (« Mon rôle, c'est de rester joignable ) | 235 → 365 | ⚠️ écart +130 px |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | (Proximité Basée à Saint-Apollinaire, n) | 737 → 763 | ≈ proche |
| 5 | Qui nous sommes | Qui nous sommes | 3511 → 3491 | ≈ proche |
| 6 | Parlons de vos locaux | Parlons de vos locaux | 266 → 265 | ✅ identique |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Recrutement) | (Accueil/Recrutement) | 42 → 47 | ✅ identique |
| 2 | Rejoindre Top-Famille Pro | Rejoindre Top-Famille Pro | 778 → 762 | ≈ proche |
| 3 | Les missions que nous confions | Les missions que nous confions | 668 → 662 | ✅ identique |
| 4 | Ce que nous attendons | Ce que nous attendons | 684 → 767 | ⚠️ écart +83 px |
| 5 | Envie de nous rejoindre ? | Envie de nous rejoindre ? | 350 → 354 | ✅ identique |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Mentions légales) | (Accueil/Mentions légales) | 42 → 47 | ✅ identique |
| 2 | Mentions légales | Mentions légales | 332 → 165 | ⚠️ écart -167 px |
| 3 | Éditeur du site | Éditeur du site | 1178 → 2210 | ⚠️ écart +1032 px |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Politique de confidentialité) | (Accueil/Politique de confidentialité) | 42 → 47 | ✅ identique |
| 2 | Politique de confidentialité | Politique de confidentialité | 362 → 227 | ⚠️ écart -135 px |
| 3 | Données collectées | Responsable du traitement | 996 → 2387 | ⚠️ écart +1391 px |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Gestion des cookies) | (Accueil/Gestion des cookies) | 42 → 47 | ✅ identique |
| 2 | Gestion des cookies | Gestion des cookies | 332 → 165 | ⚠️ écart -167 px |
| 3 | Cookies strictement nécessaires | Aucun cookie de mesure d'audience ni de traçag | 682 → 1430 | ⚠️ écart +748 px |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Plan du site) | (Accueil/Plan du site) | 42 → 47 | ✅ identique |
| 2 | Plan du site | Plan du site | 2089 → 2090 | ✅ identique |
| 3 | Pages légales et utilitaires | Pages légales et utilitaires | 241 → 230 | ≈ proche |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (Accueil/Conseils/Combien coûte le nett) | 64 → 78 | ≈ proche |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 425 → 420 | ✅ identique |
| 3 | (Le nettoyage de bureaux est facturé au) | (Le nettoyage de bureaux est facturé au) | 288 → 315 | ≈ proche |
| 4 | (Sommaire Comment se calcule le prix du) | (Sommaire Comment se calcule le prix du) | 414 → 421 | ✅ identique |
| 5 | Comment se calcule le prix du nettoyage de bur | Comment se calcule le prix du nettoyage de bur | 1862 → 1976 | ⚠️ écart +114 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 340 → 341 | ✅ identique |
| 7 | Questions fréquentes | Questions fréquentes | 407 → 408 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 249 → 268 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 308 → 336 | ≈ proche |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (Accueil/Conseils/À quelle fréquence fa) | 64 → 78 | ≈ proche |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 425 → 420 | ✅ identique |
| 3 | (La fréquence adaptée dépend surtout de) | (La fréquence adaptée dépend surtout de) | 288 → 315 | ≈ proche |
| 4 | (Sommaire Ce qui détermine la bonne fré) | (Sommaire Ce qui détermine la bonne fré) | 384 → 390 | ✅ identique |
| 5 | Ce qui détermine la bonne fréquence | Ce qui détermine la bonne fréquence | 1781 → 1843 | ⚠️ écart +62 px |
| 6 | Erreurs à éviter | Erreurs à éviter | 340 → 341 | ✅ identique |
| 7 | Questions fréquentes | Questions fréquentes | 381 → 380 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 249 → 268 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 308 → 336 | ≈ proche |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (Accueil/Conseils/Comment rédiger un ca) | 64 → 99 | ≈ proche |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 455 → 450 | ✅ identique |
| 3 | (Un cahier des charges de nettoyage pro) | (Un cahier des charges de nettoyage pro) | 288 → 342 | ≈ proche |
| 4 | (Sommaire Pourquoi un cahier des charge) | (Sommaire Pourquoi un cahier des charge) | 390 → 396 | ✅ identique |
| 5 | Pourquoi un cahier des charges change tout | Pourquoi un cahier des charges change tout | 1844 → 1859 | ≈ proche |
| 6 | Erreurs à éviter | Erreurs à éviter | 290 → 291 | ✅ identique |
| 7 | Questions fréquentes | Questions fréquentes | 355 → 353 | ✅ identique |
| 8 | (Pour situer ces repères dans une prest) | (Pour situer ces repères dans une prest) | 249 → 268 | ≈ proche |
| 9 | Un devis pour vos locaux ? | Un devis pour vos locaux ? | 308 → 336 | ≈ proche |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 803 → 815 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est imp) | (Réponse directe Top-Famille Pro est im) | 398 → 447 | ≈ proche |
| 5 | Notre implantation réelle, et rien d'autre | Notre implantation réelle, et rien d'autre | 1983 → 1973 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1051 → 1136 | ⚠️ écart +85 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 1963 → 1953 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 482 → 523 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 814 → 666 | ⚠️ écart -148 px |
| 11 | Questions fréquentes — Saint-Apollinaire | Questions fréquentes — Saint-Apollinaire | 700 → 659 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeChenôve est une commune) | (Réponse directe Chenôve est une commun) | 372 → 420 | ≈ proche |
| 5 | Chenôve dans l'agglomération dijonnaise | Chenôve dans l'agglomération dijonnaise | 1897 → 1887 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 1019 → 1103 | ⚠️ écart +84 px |
| 8 | Commerces, bureaux et cabinets | Commerces, bureaux et cabinets | 2136 → 2126 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 434 → 474 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 765 → 666 | ⚠️ écart -99 px |
| 11 | Questions fréquentes — Chenôve | Questions fréquentes — Chenôve | 650 → 631 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeQuetigny est une commun) | (Réponse directe Top-Famille Pro entret) | 347 → 420 | ⚠️ écart +73 px |
| 5 | Quetigny, commune voisine de notre implantatio | Quetigny, commune voisine de notre implantatio | 1897 → 1887 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 974 → 1079 | ⚠️ écart +105 px |
| 8 | Bureaux, cabinets et parties communes | Bureaux, cabinets et parties communes | 1970 → 1962 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 482 → 523 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 814 → 666 | ⚠️ écart -148 px |
| 11 | Questions fréquentes — Quetigny | Questions fréquentes — Quetigny | 700 → 659 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeTalant est une commune ) | (Réponse directe Talant est une commune) | 347 → 393 | ≈ proche |
| 5 | Talant, commune limitrophe de Dijon | Talant, commune limitrophe de Dijon | 1846 → 1836 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 905 → 1001 | ⚠️ écart +96 px |
| 8 | Cabinets, commerces et petits bureaux | Cabinets, commerces et petits bureaux | 1922 → 1912 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 434 → 474 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 765 → 666 | ⚠️ écart -99 px |
| 11 | Questions fréquentes — Talant | Questions fréquentes — Talant | 677 → 608 | ⚠️ écart -69 px |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 776 → 769 | ✅ identique |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeLongvic est une commune) | (Réponse directe Longvic est une commun) | 372 → 393 | ≈ proche |
| 5 | Longvic, commune d'activité au sud de Dijon | Longvic, commune d'activité au sud de Dijon | 1856 → 1846 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 980 → 1083 | ⚠️ écart +103 px |
| 8 | Bureaux, commerces, cabinets et parties commun | Bureaux, commerces, cabinets et parties commun | 2053 → 2043 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 434 → 474 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 814 → 666 | ⚠️ écart -148 px |
| 11 | Questions fréquentes — Longvic | Questions fréquentes — Longvic | 677 → 608 | ⚠️ écart -69 px |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 363 → 378 | ≈ proche |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 803 → 815 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | (Réponse directe Fontaine-lès-Dijon est) | 372 → 420 | ≈ proche |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Fontaine-lès-Dijon dans l'agglomération | 2458 → 2448 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 976 → 1055 | ⚠️ écart +79 px |
| 8 | Fonctionnement, sélection et suivi | Fonctionnement, sélection et suivi | 2002 → 1992 | ≈ proche |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 434 → 474 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 713 → 666 | ≈ proche |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | Questions fréquentes — Fontaine-lès-Dijon | 726 → 686 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 78 | ≈ proche |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 831 → 842 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région ✓Devi) | 285 → 319 | ≈ proche |
| 4 | (Réponse directeMarsannay-la-Côte est u) | (Réponse directe Marsannay-la-Côte est ) | 372 → 420 | ≈ proche |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Marsannay-la-Côte, entre agglomération et Côte | 1820 → 1834 | ≈ proche |
| 6 | Nos prestations sur place | Nos prestations sur place | 1063 → 1036 | ≈ proche |
| 7 | Tarif et exemple local | Tarif et exemple local | 929 → 1052 | ⚠️ écart +123 px |
| 8 | Événements et périodes de forte fréquentation | Événements et périodes de forte fréquentation | 1938 → 1930 | ✅ identique |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 434 → 474 | ≈ proche |
| 10 | Dans le même département | Dans le même département | 765 → 666 | ⚠️ écart -99 px |
| 11 | Questions fréquentes — Marsannay-la-Côte | Questions fréquentes — Marsannay-la-Côte | 753 → 714 | ≈ proche |
| 12 | Nous contacter | Nous contacter | 300 → 265 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 390 → 391 | ✅ identique |

