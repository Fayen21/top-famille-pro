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
| `#/` | `/` | 13 → 13 | 7825 → 7658 (98 %) | 1058 → 1062 (100 %) | 11 → 14 | 15 → 28 | 11 → 10 | non | [voir](captures/comparaison/accueil-1440.jpg) |
| `#/nos-tarifs` | `/tarifs/` | 13 → 7 | 5852 → 3594 (61 %) | 951 → 490 (52 %) | 10 → 16 | 24 → 25 | 2 → 2 | non | [voir](captures/comparaison/nos-tarifs-1440.jpg) |
| `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 → 5 | 4047 → 2776 (69 %) | 1038 → 480 (46 %) | 12 → 14 | 15 → 29 | 2 → 2 | non | [voir](captures/comparaison/pourquoi-top-famille-pro-1440.jpg) |
| `#/avis-clients` | `/avis-clients/` | 7 → 3 | 2938 → 1658 (56 %) | 613 → 236 (38 %) | 3 → 5 | 15 → 25 | 2 → 2 | non | [voir](captures/comparaison/avis-clients-1440.jpg) |
| `#/conseils` | `/conseils/` | 7 → 3 | 2834 → 1688 (60 %) | 465 → 290 (62 %) | 3 → 8 | 15 → 25 | 5 → 2 | non | [voir](captures/comparaison/conseils-1440.jpg) |
| `#/demande-de-devis` | `/demande-de-devis/` | 4 → 3 | 1947 → 2042 (105 %) | 366 → 285 (78 %) | 1 → 5 | 15 → 25 | 3 → 2 | non | [voir](captures/comparaison/demande-de-devis-1440.jpg) |
| `#/nos-prestations` | `/prestations/` | 6 → 5 | 3510 → 2480 (71 %) | 808 → 339 (42 %) | 5 → 11 | 15 → 25 | 8 → 2 | non | [voir](captures/comparaison/nos-prestations-1440.jpg) |
| `#/nettoyage-professionnel` | `/nettoyage-professionnel/` | 19 → 17 | 11192 → 9492 (85 %) | 2560 → 1924 (75 %) | 44 → 42 | 29 → 30 | 10 → 3 | non | [voir](captures/comparaison/nettoyage-professionnel-1440.jpg) |
| `#/service/bureaux` | `/prestations/bureaux/` | 14 → 16 | 7745 → 6374 (82 %) | 2074 → 1082 (52 %) | 30 → 23 | 28 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-bureaux-1440.jpg) |
| `#/service/commerces` | `/prestations/commerces/` | 14 → 16 | 7484 → 6420 (86 %) | 1868 → 1045 (56 %) | 30 → 21 | 25 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-commerces-1440.jpg) |
| `#/service/cabinets` | `/prestations/cabinets/` | 15 → 16 | 8321 → 6527 (78 %) | 2055 → 1075 (52 %) | 31 → 21 | 33 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-cabinets-1440.jpg) |
| `#/service/coproprietes` | `/prestations/coproprietes/` | 14 → 16 | 7684 → 6480 (84 %) | 2010 → 1023 (51 %) | 31 → 21 | 26 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-coproprietes-1440.jpg) |
| `#/service/meubles` | `/prestations/meubles/` | 14 → 16 | 7955 → 6484 (82 %) | 2086 → 1059 (51 %) | 30 → 21 | 26 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-meubles-1440.jpg) |
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 16 | 7588 → 6311 (83 %) | 1950 → 984 (50 %) | 31 → 21 | 25 → 26 | 3 → 3 | non | [voir](captures/comparaison/service-ponctuel-1440.jpg) |
| `#/notre-fonctionnement` | `/notre-fonctionnement/` | 4 → 5 | 4095 → 2779 (68 %) | 966 → 423 (44 %) | 9 → 10 | 15 → 25 | 2 → 2 | non | [voir](captures/comparaison/notre-fonctionnement-1440.jpg) |
| `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 → 13 | 6456 → 4347 (67 %) | 1376 → 540 (39 %) | 16 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-cote-dor-1440.jpg) |
| `#/departement/doubs` | `/zones-intervention/doubs/` | 11 → 13 | 6140 → 4603 (75 %) | 1271 → 642 (51 %) | 14 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-doubs-1440.jpg) |
| `#/departement/jura` | `/zones-intervention/jura/` | 11 → 13 | 6271 → 4514 (72 %) | 1261 → 618 (49 %) | 15 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-jura-1440.jpg) |
| `#/departement/nievre` | `/zones-intervention/nievre/` | 11 → 13 | 6301 → 4572 (73 %) | 1284 → 633 (49 %) | 15 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-nievre-1440.jpg) |
| `#/departement/haute-saone` | `/zones-intervention/haute-saone/` | 11 → 13 | 6376 → 4525 (71 %) | 1308 → 619 (47 %) | 15 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-haute-saone-1440.jpg) |
| `#/departement/saone-et-loire` | `/zones-intervention/saone-et-loire/` | 11 → 13 | 6034 → 4594 (76 %) | 1222 → 621 (51 %) | 14 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-saone-et-loire-1440.jpg) |
| `#/departement/yonne` | `/zones-intervention/yonne/` | 11 → 13 | 6270 → 4545 (72 %) | 1278 → 608 (48 %) | 15 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-yonne-1440.jpg) |
| `#/departement/territoire-de-belfort` | `/zones-intervention/territoire-de-belfort/` | 11 → 13 | 6333 → 4475 (71 %) | 1310 → 611 (47 %) | 15 → 15 | 21 → 26 | 2 → 2 | non | [voir](captures/comparaison/departement-territoire-de-belfort-1440.jpg) |
| `#/zones-intervention` | `/zones-intervention/` | 13 → 8 | 6753 → 3899 (58 %) | 1321 → 660 (50 %) | 12 → 18 | 20 → 25 | 2 → 2 | non | [voir](captures/comparaison/zones-intervention-1440.jpg) |
| `#/contact` | `/contact/` | 4 → 3 | 1924 → 1700 (88 %) | 309 → 266 (86 %) | 1 → 7 | 15 → 25 | 3 → 2 | non | [voir](captures/comparaison/contact-1440.jpg) |
| `#/bourgogne-franche-comte` | `/zones-intervention/bourgogne-franche-comte/` | 12 → 12 | 8674 → 6240 (72 %) | 1955 → 1150 (59 %) | 17 → 24 | 27 → 26 | 3 → 3 | non | [voir](captures/comparaison/bourgogne-franche-comte-1440.jpg) |
| `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 → 13 | 8508 → 4518 (53 %) | 1918 → 614 (32 %) | 20 → 15 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-dijon-1440.jpg) |
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 12 | 7106 → 3745 (53 %) | 1445 → 464 (32 %) | 17 → 13 | 21 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-beaune-1440.jpg) |
| `#/ville/besancon` | `/zones-intervention/doubs/besancon/` | 13 → 12 | 8076 → 4432 (55 %) | 1822 → 649 (36 %) | 19 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-besancon-1440.jpg) |
| `#/ville/dole` | `/zones-intervention/jura/dole/` | 13 → 12 | 8199 → 4261 (52 %) | 1806 → 608 (34 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-dole-1440.jpg) |
| `#/ville/lons-le-saunier` | `/zones-intervention/jura/lons-le-saunier/` | 13 → 12 | 8205 → 4311 (53 %) | 1794 → 595 (33 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-lons-le-saunier-1440.jpg) |
| `#/ville/nevers` | `/zones-intervention/nievre/nevers/` | 13 → 12 | 8077 → 4261 (53 %) | 1733 → 603 (35 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-nevers-1440.jpg) |
| `#/ville/vesoul` | `/zones-intervention/haute-saone/vesoul/` | 13 → 12 | 8211 → 4234 (52 %) | 1778 → 591 (33 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-vesoul-1440.jpg) |
| `#/ville/chalon-sur-saone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 13 → 12 | 8062 → 4311 (53 %) | 1761 → 600 (34 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-chalon-sur-saone-1440.jpg) |
| `#/ville/macon` | `/zones-intervention/saone-et-loire/macon/` | 13 → 12 | 8072 → 4287 (53 %) | 1690 → 604 (36 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-macon-1440.jpg) |
| `#/ville/auxerre` | `/zones-intervention/yonne/auxerre/` | 13 → 12 | 8089 → 4261 (53 %) | 1759 → 602 (34 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-auxerre-1440.jpg) |
| `#/ville/belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | 13 → 12 | 8098 → 4289 (53 %) | 1758 → 625 (36 %) | 20 → 14 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-belfort-1440.jpg) |
| `#/a-propos` | `/a-propos/` | 6 → 5 | 4433 → 2270 (51 %) | 1108 → 318 (29 %) | 10 → 7 | 15 → 25 | 3 → 3 | non | [voir](captures/comparaison/a-propos-1440.jpg) |
| `#/recrutement` | `/recrutement/` | 4 → 3 | 2394 → 1364 (57 %) | 387 → 223 (58 %) | 5 → 5 | 19 → 25 | 3 → 2 | non | [voir](captures/comparaison/recrutement-1440.jpg) |
| `#/mentions-legales` | `/mentions-legales/` | 4 → 6 | 2014 → 2326 (115 %) | 409 → 416 (102 %) | 6 → 10 | 15 → 25 | 2 → 2 | non | [voir](captures/comparaison/mentions-legales-1440.jpg) |
| `#/politique-de-confidentialite` | `/politique-de-confidentialite/` | 4 → 7 | 1936 → 2357 (122 %) | 399 → 426 (107 %) | 5 → 11 | 15 → 30 | 2 → 2 | non | [voir](captures/comparaison/politique-de-confidentialite-1440.jpg) |
| `#/gestion-des-cookies` | `/gestion-des-cookies/` | 4 → 3 | 1718 → 1588 (92 %) | 345 → 315 (91 %) | 4 → 7 | 15 → 25 | 2 → 2 | non | [voir](captures/comparaison/gestion-des-cookies-1440.jpg) |
| `#/plan-du-site` | `/plan-du-site/` | 4 → 3 | 1975 → 1838 (93 %) | 315 → 275 (87 %) | 8 → 10 | 65 → 69 | 2 → 2 | non | [voir](captures/comparaison/plan-du-site-1440.jpg) |
| `#/article/cout-nettoyage-bureaux` | `/conseils/cout-nettoyage-bureaux/` | 9 → 3 | 4542 → 3501 (77 %) | 839 → 746 (89 %) | 10 → 13 | 26 → 32 | 3 → 2 | non | [voir](captures/comparaison/article-cout-nettoyage-bureaux-1440.jpg) |
| `#/article/frequence-bureaux` | `/conseils/frequence-bureaux/` | 9 → 3 | 4437 → 3367 (76 %) | 771 → 664 (86 %) | 9 → 12 | 29 → 33 | 3 → 2 | non | [voir](captures/comparaison/article-frequence-bureaux-1440.jpg) |
| `#/article/cahier-des-charges-nettoyage` | `/conseils/cahier-des-charges-nettoyage/` | 9 → 3 | 4643 → 3683 (79 %) | 741 → 656 (89 %) | 10 → 13 | 32 → 35 | 3 → 2 | non | [voir](captures/comparaison/article-cahier-des-charges-nettoyage-1440.jpg) |
| `#/ville/saint-apollinaire` | `/zones-intervention/cote-dor/saint-apollinaire/` | 13 → 12 | 7164 → 3821 (53 %) | 1438 → 481 (33 %) | 17 → 13 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-saint-apollinaire-1440.jpg) |
| `#/ville/chenove` | `/zones-intervention/cote-dor/chenove/` | 13 → 12 | 7115 → 3745 (53 %) | 1431 → 467 (33 %) | 17 → 13 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-chenove-1440.jpg) |
| `#/ville/quetigny` | `/zones-intervention/cote-dor/quetigny/` | 13 → 12 | 7031 → 3745 (53 %) | 1409 → 462 (33 %) | 17 → 13 | 21 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-quetigny-1440.jpg) |
| `#/ville/talant` | `/zones-intervention/cote-dor/talant/` | 13 → 12 | 6942 → 3745 (54 %) | 1356 → 465 (34 %) | 17 → 13 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-talant-1440.jpg) |
| `#/ville/longvic` | `/zones-intervention/cote-dor/longvic/` | 13 → 12 | 6995 → 3797 (54 %) | 1421 → 495 (35 %) | 17 → 13 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-longvic-1440.jpg) |
| `#/ville/fontaine-les-dijon` | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 13 → 12 | 7322 → 3795 (52 %) | 1449 → 458 (32 %) | 18 → 13 | 27 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-fontaine-les-dijon-1440.jpg) |
| `#/ville/marsannay-la-cote` | `/zones-intervention/cote-dor/marsannay-la-cote/` | 13 → 12 | 6993 → 3795 (54 %) | 1374 → 468 (34 %) | 17 → 13 | 21 → 27 | 3 → 2 | non | [voir](captures/comparaison/ville-marsannay-la-cote-1440.jpg) |

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
| 12 | Conseils & repères | Conseils & repères | 653 → 660 | ✅ identique |
| 13 | Demandez votre devis gratuit et sans engagemen | Demandez votre devis gratuit et sans engagemen | 447 → 442 | ✅ identique |

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Tarifs) | 42 → 57 | ≈ proche |
| 2 | Nos tarifs de nettoyage professionnel | Tarifs de nettoyage professionnel | 362 → 210 | ⚠️ écart -152 px |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | Tarif unique | 277 → 484 | ⚠️ écart +207 px |
| 4 | (Le nettoyage professionnel est facturé) | Ce qui s'ajoute, selon les cas | 277 → 525 | ⚠️ écart +248 px |
| 5 | (Ce tarif s'applique au périmètre décri) | Cette grille s'applique à toutes nos prestatio | 131 → 479 | ⚠️ écart +348 px |
| 6 | Le détail de nos frais | Questions fréquentes | 638 → 762 | ⚠️ écart +124 px |
| 7 | Ce qui est inclus | Un devis étudié personnellement par Audrey | 313 → 413 | ⚠️ écart +100 px |
| 8 | Ce qui influence le volume d'heures | — | 403 → — | ❌ absent côté WordPress |
| 9 | Trois exemples de budgets | — | 606 → — | ❌ absent côté WordPress |
| 10 | Comparer plusieurs besoins en un coup d'œil | — | 492 → — | ❌ absent côté WordPress |
| 11 | Questions sur les tarifs | — | 745 → — | ❌ absent côté WordPress |
| 12 | Avant de demander votre devis | — | 405 → — | ❌ absent côté WordPress |
| 13 | Recevez un devis clair et chiffré | — | 339 → — | ❌ absent côté WordPress |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Pourquoi Top-Famille Pro) | (Accueil/Pourquoi nous) | 42 → 57 | ≈ proche |
| 2 | Pourquoi choisir Top-Famille Pro | Pourquoi choisir Top-Famille Pro | 314 → 210 | ⚠️ écart -104 px |
| 3 | (Directement joignableAudrey est votre ) | Une interlocutrice unique | 509 → 1037 | ⚠️ écart +528 px |
| 4 | Des preuves plutôt que des slogans | Fonctionnement en 4 temps | 376 → 444 | ⚠️ écart +68 px |
| 5 | Ce qui nous distingue, concrètement | Échanger sur vos locaux | 789 → 363 | ⚠️ écart -426 px |
| 6 | Les objections que l'on nous adresse | — | 488 → — | ❌ absent côté WordPress |
| 7 | Vérifier par vous-même | — | 390 → — | ❌ absent côté WordPress |
| 8 | Faisons connaissance | — | 319 → — | ❌ absent côté WordPress |

### `#/avis-clients` → `/avis-clients/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Avis clients) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 42 → 141 | ⚠️ écart +99 px |
| 2 | Avis de nos clients | Avis clients | 215 → 992 | ⚠️ écart +777 px |
| 3 | (5,0/5★★★★★Sur Google · 47 avis clients) | Top-Famille Pro | 157 → 525 | ⚠️ écart +368 px |
| 4 | (★★★★★« Nous avons comparé une embauche) | — | 386 → — | ❌ absent côté WordPress |
| 5 | (★★★★★Google« Même intervenante chaque ) | — | 710 → — | ❌ absent côté WordPress |
| 6 | Un avis ne remplace pas un devis | — | 288 → — | ❌ absent côté WordPress |
| 7 | À votre tour ? | — | 319 → — | ❌ absent côté WordPress |

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 42 → 141 | ⚠️ écart +99 px |
| 2 | Conseils & repères | Conseils d'entretien de locaux professionnels | 339 → 1022 | ⚠️ écart +683 px |
| 3 | (Toutes les catégories Bureaux Tarifs O) | Top-Famille Pro | 75 → 525 | ⚠️ écart +450 px |
| 4 | (À la une · Bureaux À quelle fréquence ) | — | 427 → — | ❌ absent côté WordPress |
| 5 | Les autres articles | — | 642 → — | ❌ absent côté WordPress |
| 6 | Passer du conseil à votre situation | — | 314 → — | ❌ absent côté WordPress |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | — | 174 → — | ❌ absent côté WordPress |

### `#/demande-de-devis` → `/demande-de-devis/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 119 → 141 | ≈ proche |
| 2 | Demandez votre devis gratuit | Demande de devis gratuit | 1126 → 1376 | ⚠️ écart +250 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Top-Famille Pro | 158 → 525 | ⚠️ écart +367 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | — | 544 → — | ❌ absent côté WordPress |

### `#/nos-prestations` → `/prestations/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos prestations) | (Accueil/Nos prestations) | 42 → 57 | ≈ proche |
| 2 | Nos prestations de nettoyage professionnel | Nos prestations de nettoyage professionnel | 449 → 239 | ⚠️ écart -210 px |
| 3 | Comment choisir la bonne prestation ? | Entretien de copropriétés | 359 → 827 | ⚠️ écart +468 px |
| 4 | Ce qui est commun aux six prestations | (27 € HT/h tarif unique, indiqué avant ) | 307 → 200 | ⚠️ écart -107 px |
| 5 | (Nettoyage de bureauxUn entretien régul) | Un besoin qui ne correspond pas exactement à u | 1197 → 492 | ⚠️ écart -705 px |
| 6 | Besoin d'aide pour choisir ? | — | 334 → — | ❌ absent côté WordPress |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nettoyage professionnel) | (Accueil/Nettoyage professionnel) | 42 → 57 | ≈ proche |
| 2 | Le nettoyage professionnel de vos locaux en Bo | Le nettoyage professionnel de vos locaux en Bo | 661 → 555 | ⚠️ écart -106 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique, indiqué avant ) | 202 → 255 | ≈ proche |
| 4 | (Le nettoyage professionnel désigne l'e) | (Le nettoyage professionnel désigne l'e) | 492 → 418 | ⚠️ écart -74 px |
| 5 | Les professionnels que nous accompagnons | Les professionnels que nous accompagnons | 516 → 520 | ✅ identique |
| 6 | Prestataire de nettoyage ou recrutement direct | Prestataire de nettoyage ou recrutement direct | 731 → 715 | ≈ proche |
| 7 | Nos six prestations de nettoyage professionnel | Nos six prestations de nettoyage professionnel | 560 → 573 | ≈ proche |
| 8 | Régulier ou ponctuel, tâches, fréquences et ho | Régulier ou ponctuel, tâches, fréquences et ho | 862 → 656 | ⚠️ écart -206 px |
| 9 | Comment choisir la bonne fréquence | Comment choisir la bonne fréquence | 700 → 655 | ≈ proche |
| 10 | Les tâches, espace par espace | Les tâches, espace par espace | 763 → 754 | ≈ proche |
| 11 | Un cahier des charges défini avec vous | Un cahier des charges défini avec vous | 433 → 420 | ≈ proche |
| 12 | Comment se construit un cahier des charges | Comment se construit un cahier des charges | 735 → 506 | ⚠️ écart -229 px |
| 13 | Cahier des charges, intervenants et suivi | Trois situations concrètes | 674 → 507 | ⚠️ écart -167 px |
| 14 | (★★★★★« Nous avons comparé une embauche) | Le tarif, en toute transparence | 396 → 465 | ⚠️ écart +69 px |
| 15 | Trois situations concrètes | Pour aller plus loin | 552 → 242 | ⚠️ écart -310 px |
| 16 | Le tarif, en toute transparence | Questions fréquentes | 450 → 1116 | ⚠️ écart +666 px |
| 17 | Pour aller plus loin | Un projet d'entretien pour vos locaux ? | 286 → 413 | ⚠️ écart +127 px |
| 18 | Questions fréquentes | — | 976 → — | ❌ absent côté WordPress |
| 19 | Un projet d'entretien pour vos locaux ? | — | 339 → — | ❌ absent côté WordPress |

### `#/service/bureaux` → `/prestations/bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Bureaux) | (Accueil/Prestations/Nettoyage de burea) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de bureaux en Bourgogne-Franche-Comt | Nettoyage de bureaux en Bourgogne-Franche-Comt | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLe nettoyage de bureaux) | (Réponse directe Un entretien régulier ) | 363 → 196 | ⚠️ écart -167 px |
| 4 | Pour qui ? | Pour qui | 648 → 244 | ⚠️ écart -404 px |
| 5 | Les situations concrètes que nous traitons | Ce que couvre la prestation | 385 → 468 | ⚠️ écart +83 px |
| 6 | Trois configurations, trois organisations | Ce qui n'est pas inclus | 606 → 299 | ⚠️ écart -307 px |
| 7 | Le détail, espace par espace et contrainte par | Trois configurations, trois organisations | 1162 → 482 | ⚠️ écart -680 px |
| 8 | Une organisation carrée, du planning au suivi | Une semaine type | 816 → 337 | ⚠️ écart -479 px |
| 9 | Une semaine type | Des situations que nous prenons en charge | 401 → 304 | ⚠️ écart -97 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Organisation de la prestation | 425 → 352 | ⚠️ écart -73 px |
| 11 | Cette prestation près de chez vous | Le tarif, en toute transparence | 384 → 446 | ⚠️ écart +62 px |
| 12 | Questions fréquentes — Bureaux | Disponible dans ces villes | 797 → 212 | ⚠️ écart -585 px |
| 13 | (Encore une question sur Bureaux ? Audr) | Nos conseils sur ce sujet | 97 → 285 | ⚠️ écart +188 px |
| 14 | Un devis pour Bureaux | Questions fréquentes | 317 → 851 | ⚠️ écart +534 px |
| 15 | — | (Encore une question sur nettoyage de b) | — → 187 | ➕ en plus côté WordPress |
| 16 | — | Un projet de nettoyage de bureaux ? | — → 442 | ➕ en plus côté WordPress |

### `#/service/commerces` → `/prestations/commerces/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Commerces) | (Accueil/Prestations/Nettoyage de comme) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de commerces et de surfaces de vente | Nettoyage de commerces et de surfaces de vente | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeLa propreté d'un commer) | (Réponse directe Une surface de vente i) | 363 → 227 | ⚠️ écart -136 px |
| 4 | Pour qui ? | Pour qui | 561 → 217 | ⚠️ écart -344 px |
| 5 | Les situations concrètes que nous traitons | Ce que couvre la prestation | 336 → 496 | ⚠️ écart +160 px |
| 6 | Trois configurations, trois organisations | Ce qui n'est pas inclus | 606 → 327 | ⚠️ écart -279 px |
| 7 | Le détail, espace par espace et contrainte par | Trois configurations, trois organisations | 1111 → 462 | ⚠️ écart -649 px |
| 8 | Une organisation carrée, du planning au suivi | Une semaine type | 816 → 308 | ⚠️ écart -508 px |
| 9 | Une semaine type | Des situations que nous prenons en charge | 401 → 304 | ⚠️ écart -97 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Organisation de la prestation | 425 → 406 | ≈ proche |
| 11 | Cette prestation près de chez vous | Le tarif, en toute transparence | 384 → 446 | ⚠️ écart +62 px |
| 12 | Questions fréquentes — Commerces | Disponible dans ces villes | 722 → 212 | ⚠️ écart -510 px |
| 13 | (Encore une question sur Commerces ? Au) | Nos conseils sur ce sujet | 97 → 267 | ⚠️ écart +170 px |
| 14 | Un devis pour Commerces | Questions fréquentes | 317 → 851 | ⚠️ écart +534 px |
| 15 | — | (Encore une question sur nettoyage de c) | — → 187 | ➕ en plus côté WordPress |
| 16 | — | Un projet de nettoyage de commerces ? | — → 442 | ➕ en plus côté WordPress |

### `#/service/cabinets` → `/prestations/cabinets/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Cabinets) | (Accueil/Prestations/Nettoyage de cabin) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de cabinets et de professions libéra | Nettoyage de cabinets et de professions libéra | 503 → 546 | ≈ proche |
| 3 | (Réponse directeUn cabinet reçoit du pu) | (Réponse directe L'entretien courant de) | 491 → 257 | ⚠️ écart -234 px |
| 4 | Pour qui ? | Pour qui | 640 → 217 | ⚠️ écart -423 px |
| 5 | Ce que Top-Famille Pro ne réalise pas | Ce que couvre la prestation | 513 → 441 | ⚠️ écart -72 px |
| 6 | Les situations concrètes que nous traitons | Ce qui n'est pas inclus | 385 → 354 | ≈ proche |
| 7 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 482 | ⚠️ écart -124 px |
| 8 | Le détail, espace par espace et contrainte par | Une semaine type | 1034 → 308 | ⚠️ écart -726 px |
| 9 | Une organisation carrée, du planning au suivi | Des situations que nous prenons en charge | 865 → 328 | ⚠️ écart -537 px |
| 10 | Une semaine type | Organisation de la prestation | 401 → 379 | ≈ proche |
| 11 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Le tarif, en toute transparence | 425 → 446 | ≈ proche |
| 12 | Cette prestation près de chez vous | Disponible dans ces villes | 384 → 212 | ⚠️ écart -172 px |
| 13 | Questions fréquentes — Cabinets | Nos conseils sur ce sujet | 797 → 267 | ⚠️ écart -530 px |
| 14 | (Encore une question sur Cabinets ? Aud) | Questions fréquentes | 97 → 939 | ⚠️ écart +842 px |
| 15 | Un devis pour Cabinets | (Encore une question sur nettoyage de c) | 317 → 187 | ⚠️ écart -130 px |
| 16 | — | Un projet de nettoyage de cabinets ? | — → 442 | ➕ en plus côté WordPress |

### `#/service/coproprietes` → `/prestations/coproprietes/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Copropriétés) | (Accueil/Prestations/Entretien de copro) | 42 → 57 | ≈ proche |
| 2 | Entretien de copropriétés et de parties commun | Entretien de copropriétés et de parties commun | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeNous travaillons avec l) | (Réponse directe L'entretien régulier d) | 363 → 227 | ⚠️ écart -136 px |
| 4 | Pour qui ? | Pour qui | 640 → 217 | ⚠️ écart -423 px |
| 5 | Les situations concrètes que nous traitons | Ce que couvre la prestation | 385 → 496 | ⚠️ écart +111 px |
| 6 | Trois configurations, trois organisations | Ce qui n'est pas inclus | 606 → 327 | ⚠️ écart -279 px |
| 7 | Le détail, espace par espace et contrainte par | Trois configurations, trois organisations | 1104 → 438 | ⚠️ écart -666 px |
| 8 | Une organisation carrée, du planning au suivi | Une semaine type | 768 → 308 | ⚠️ écart -460 px |
| 9 | Une semaine type | Des situations que nous prenons en charge | 452 → 328 | ⚠️ écart -124 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Organisation de la prestation | 425 → 379 | ≈ proche |
| 11 | Cette prestation près de chez vous | Le tarif, en toute transparence | 384 → 446 | ⚠️ écart +62 px |
| 12 | Questions fréquentes — Copropriétés | Disponible dans ces villes | 797 → 212 | ⚠️ écart -585 px |
| 13 | (Encore une question sur Copropriétés ?) | Nos conseils sur ce sujet | 97 → 267 | ⚠️ écart +170 px |
| 14 | Un devis pour Copropriétés | Questions fréquentes | 317 → 939 | ⚠️ écart +622 px |
| 15 | — | (Encore une question sur entretien de c) | — → 187 | ➕ en plus côté WordPress |
| 16 | — | Un projet de entretien de copropriétés ? | — → 442 | ➕ en plus côté WordPress |

### `#/service/meubles` → `/prestations/meubles/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Locations meub) | (Accueil/Prestations/Nettoyage de locat) | 42 → 57 | ≈ proche |
| 2 | Nettoyage de locations meublées et d'hébergeme | Nettoyage de locations meublées et d'hébergeme | 520 → 546 | ≈ proche |
| 3 | (Réponse directePour les locations meub) | (Réponse directe La remise en état de v) | 459 → 257 | ⚠️ écart -202 px |
| 4 | Pour qui ? | Pour qui | 616 → 244 | ⚠️ écart -372 px |
| 5 | Les situations concrètes que nous traitons | Ce que couvre la prestation | 385 → 496 | ⚠️ écart +111 px |
| 6 | Trois configurations, trois organisations | Ce qui n'est pas inclus | 601 → 299 | ⚠️ écart -302 px |
| 7 | Le détail, espace par espace et contrainte par | Trois configurations, trois organisations | 1162 → 438 | ⚠️ écart -724 px |
| 8 | Une organisation carrée, du planning au suivi | Une semaine type | 840 → 308 | ⚠️ écart -532 px |
| 9 | Une semaine type | Des situations que nous prenons en charge | 452 → 328 | ⚠️ écart -124 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Organisation de la prestation | 425 → 352 | ⚠️ écart -73 px |
| 11 | Cette prestation près de chez vous | Le tarif, en toute transparence | 384 → 446 | ⚠️ écart +62 px |
| 12 | Questions fréquentes — Locations meublées | Disponible dans ces villes | 797 → 212 | ⚠️ écart -585 px |
| 13 | (Encore une question sur Locations meub) | Nos conseils sur ce sujet | 136 → 267 | ⚠️ écart +131 px |
| 14 | Un devis pour Locations meublées | Questions fréquentes | 317 → 939 | ⚠️ écart +622 px |
| 15 | — | (Encore une question sur nettoyage de l) | — → 187 | ➕ en plus côté WordPress |
| 16 | — | Un projet de nettoyage de locations meublées ? | — → 442 | ➕ en plus côté WordPress |

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Nettoyage ponctuel) | 42 → 57 | ≈ proche |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Une intervention ponct) | 363 → 227 | ⚠️ écart -136 px |
| 4 | Pour qui ? | Pour qui | 561 → 217 | ⚠️ écart -344 px |
| 5 | Les situations concrètes que nous traitons | Ce que couvre la prestation | 360 → 358 | ✅ identique |
| 6 | Trois configurations, trois organisations | Ce qui n'est pas inclus | 606 → 327 | ⚠️ écart -279 px |
| 7 | Le détail, espace par espace et contrainte par | Trois configurations, trois organisations | 1136 → 458 | ⚠️ écart -678 px |
| 8 | Une organisation carrée, du planning au suivi | Une semaine type | 744 → 308 | ⚠️ écart -436 px |
| 9 | Une semaine type | Des situations que nous prenons en charge | 452 → 304 | ⚠️ écart -148 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | Organisation de la prestation | 425 → 352 | ⚠️ écart -73 px |
| 11 | Cette prestation près de chez vous | Le tarif, en toute transparence | 384 → 446 | ⚠️ écart +62 px |
| 12 | Questions fréquentes — Ponctuel | Disponible dans ces villes | 797 → 212 | ⚠️ écart -585 px |
| 13 | (Encore une question sur Ponctuel ? Aud) | Nos conseils sur ce sujet | 97 → 267 | ⚠️ écart +170 px |
| 14 | Un devis pour Ponctuel | Questions fréquentes | 317 → 939 | ⚠️ écart +622 px |
| 15 | — | (Encore une question sur nettoyage ponc) | — → 187 | ➕ en plus côté WordPress |
| 16 | — | Un projet de nettoyage ponctuel ? | — → 442 | ➕ en plus côté WordPress |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (Accueil/Notre fonctionnement) | 119 → 57 | ⚠️ écart -62 px |
| 2 | Notre fonctionnement | Notre fonctionnement, du devis au suivi | 3273 → 210 | ⚠️ écart -3063 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Échange sur vos attentes | 158 → 796 | ⚠️ écart +638 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | Questions fréquentes | 544 → 589 | ≈ proche |
| 5 | — | Un devis étudié personnellement par Audrey Bra | — → 462 | ➕ en plus côté WordPress |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Côte-d'Or | Entreprise de nettoyage en Côte-d'Or | 401 → 292 | ⚠️ écart -109 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 357 | ⚠️ écart +171 px |
| 4 | (Réponse directeLa Côte-d'Or est notre ) | Services disponibles ici | 291 → 235 | ≈ proche |
| 5 | Notre couverture en Côte-d'Or | Comment nous travaillons ici | 1486 → 327 | ⚠️ écart -1159 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Entretien régulier ou intervention ponctuelle | Nos villes dans le département | 1118 → 212 | ⚠️ écart -906 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Côte-d'Or | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis en Côte-d'Or | — → 442 | ➕ en plus côté WordPress |

### `#/departement/doubs` → `/zones-intervention/doubs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Doubs) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Doubs | Entreprise de nettoyage dans le Doubs | 434 → 383 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 381 | ⚠️ écart +195 px |
| 4 | (Réponse directeDans le Doubs, notre se) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre couverture dans le Doubs | Comment nous travaillons ici | 1103 → 327 | ⚠️ écart -776 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Les cabinets de santé : ce que nous faisons, c | Nos villes dans le département | 1178 → 212 | ⚠️ écart -966 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Doubs | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis dans le Doubs | — → 442 | ➕ en plus côté WordPress |

### `#/departement/jura` → `/zones-intervention/jura/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Jura) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Jura | Entreprise de nettoyage dans le Jura | 401 → 322 | ⚠️ écart -79 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 430 | ⚠️ écart +244 px |
| 4 | (Réponse directeDans le Jura, nous inte) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Deux bassins distincts : Dole et Lons-le-Sauni | Comment nous travaillons ici | 1379 → 300 | ⚠️ écart -1079 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 401 → 213 | ⚠️ écart -188 px |
| 8 | Fonctionnement et suivi | Nos villes dans le département | 1091 → 212 | ⚠️ écart -879 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Jura | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis dans le Jura | — → 392 | ➕ en plus côté WordPress |

### `#/departement/nievre` → `/zones-intervention/nievre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Nièvre) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans la Nièvre | Entreprise de nettoyage dans la Nièvre | 401 → 353 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 381 | ⚠️ écart +195 px |
| 4 | (Réponse directeDans la Nièvre, notre s) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre couverture dans la Nièvre | Comment nous travaillons ici | 1433 → 327 | ⚠️ écart -1106 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 404 → 213 | ⚠️ écart -191 px |
| 8 | Organisation des déplacements | Nos villes dans le département | 1064 → 212 | ⚠️ écart -852 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Nièvre | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis dans la Nièvre | — → 442 | ➕ en plus côté WordPress |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Haute-Saône | Entreprise de nettoyage en Haute-Saône | 401 → 353 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 361 | ⚠️ écart +175 px |
| 4 | (Réponse directeEn Haute-Saône, notre s) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre couverture en Haute-Saône | Comment nous travaillons ici | 1433 → 300 | ⚠️ écart -1133 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Accès, clés et interventions hors horaires | Nos villes dans le département | 1091 → 212 | ⚠️ écart -879 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Haute-Saône | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis en Haute-Saône | — → 442 | ➕ en plus côté WordPress |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Saône-et-Loire | Entreprise de nettoyage en Saône-et-Loire | 401 → 353 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 430 | ⚠️ écart +244 px |
| 4 | (Réponse directeEn Saône-et-Loire, nos ) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Deux bassins le long de l'axe Saône | Comment nous travaillons ici | 1106 → 300 | ⚠️ écart -806 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 404 → 213 | ⚠️ écart -191 px |
| 8 | Industrie, agroalimentaire et viticulture : ce | Nos villes dans le département | 1124 → 212 | ⚠️ écart -912 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Saône-et-Loire | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis en Saône-et-Loire | — → 442 | ➕ en plus côté WordPress |

### `#/departement/yonne` → `/zones-intervention/yonne/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Yonne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans l'Yonne | Entreprise de nettoyage dans l'Yonne | 401 → 353 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 381 | ⚠️ écart +195 px |
| 4 | (Réponse directeDans l'Yonne, notre sec) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre couverture dans l'Yonne | Comment nous travaillons ici | 1379 → 300 | ⚠️ écart -1079 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Fonctionnement et suivi à distance | Nos villes dans le département | 1064 → 212 | ⚠️ écart -852 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Yonne | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis dans l'Yonne | — → 442 | ➕ en plus côté WordPress |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones / Bourgogne-Franche-Co) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage dans le Territoire de  | Entreprise de nettoyage dans le Territoire de  | 401 → 353 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 361 | ⚠️ écart +175 px |
| 4 | (Réponse directeDans le Territoire de B) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Un département compact, entièrement autour de  | Comment nous travaillons ici | 1443 → 300 | ⚠️ écart -1143 px |
| 6 | Nos villes d'intervention dans le département | Le tarif, en toute transparence | 554 → 237 | ⚠️ écart -317 px |
| 7 | Tarif et déplacements | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Interventions en soirée : comment cela s'organ | Nos villes dans le département | 1064 → 212 | ⚠️ écart -852 px |
| 9 | Départements limitrophes couverts | (← Voir toute la région Bourgogne-Franc) | 172 → 152 | ≈ proche |
| 10 | Questions fréquentes — Territoire de Belfort | Ce qui n'est pas couvert | 614 → 242 | ⚠️ écart -372 px |
| 11 | Un devis pour vos locaux dans le département | FAQ locale | 319 → 762 | ⚠️ écart +443 px |
| 12 | — | (En savoir plus sur le nettoyage profes) | — → 154 | ➕ en plus côté WordPress |
| 13 | — | Demander un devis à Belfort | — → 392 | ➕ en plus côté WordPress |

### `#/zones-intervention` → `/zones-intervention/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention) | (Accueil/Zones d'intervention) | 42 → 57 | ≈ proche |
| 2 | Nos zones d'intervention en Bourgogne-Franche- | Nos zones d'intervention en Bourgogne-Franche- | 383 → 239 | ⚠️ écart -144 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Nous intervenons uniquement en Bourgog) | 186 → 234 | ≈ proche |
| 4 | (Réponse directeNous intervenons unique) | Les 8 départements couverts | 323 → 553 | ⚠️ écart +230 px |
| 5 | Une couverture régionale organisée depuis Sain | Une couverture régionale organisée depuis Sain | 1391 → 656 | ⚠️ écart -735 px |
| 6 | (Bourgogne-Franche-ComtéLa page régiona) | Votre commune n'apparaît pas encore ? | 192 → 408 | ⚠️ écart +216 px |
| 7 | Les huit départements | Questions fréquentes | 429 → 674 | ⚠️ écart +245 px |
| 8 | Nos dix villes principales | Vérifier notre intervention dans ma commune | 344 → 413 | ⚠️ écart +69 px |
| 9 | Premières communes secondaires | — | 327 → — | ❌ absent côté WordPress |
| 10 | Départements, villes et communes : comment lir | — | 1163 → — | ❌ absent côté WordPress |
| 11 | (Découvrir nos prestationsBureaux, comm) | — | 193 → — | ❌ absent côté WordPress |
| 12 | Questions fréquentes sur nos zones d'intervent | — | 614 → — | ❌ absent côté WordPress |
| 13 | Votre commune est-elle couverte ? | — | 346 → — | ❌ absent côté WordPress |

### `#/contact` → `/contact/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 119 → 141 | ≈ proche |
| 2 | Contacter Top-Famille Pro | Contacter Top-Famille Pro | 1103 → 1035 | ⚠️ écart -68 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Top-Famille Pro | 158 → 525 | ⚠️ écart +367 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | — | 544 → — | ❌ absent côté WordPress |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Zones d'intervention / Bourg) | (Accueil/Zones d'intervention/Bourgogne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage en Bourgogne-Franche-C | Entreprise de nettoyage en Bourgogne-Franche-C | 526 → 546 | ≈ proche |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (Top-Famille Pro est une entreprise de ) | 186 → 308 | ⚠️ écart +122 px |
| 4 | (Réponse directeTop-Famille Pro est une) | Notre implantation réelle : Saint-Apollinaire, | 323 → 572 | ⚠️ écart +249 px |
| 5 | Notre implantation réelle : Saint-Apollinaire, | Les 8 départements couverts | 2022 → 461 | ⚠️ écart -1561 px |
| 6 | Nos prestations partout en Bourgogne-Franche-C | Les professionnels que nous accompagnons | 576 → 606 | ≈ proche |
| 7 | Les huit départements couverts | Notre organisation à l'échelle régionale | 733 → 529 | ⚠️ écart -204 px |
| 8 | Nos dix villes principales | Tarif régional unique | 424 → 421 | ✅ identique |
| 9 | Un tarif régional unique | Ce que nous ne faisons pas | 478 → 458 | ≈ proche |
| 10 | Sélection des intervenants et suivi | Comment démarre une collaboration | 1540 → 406 | ⚠️ écart -1134 px |
| 11 | Questions fréquentes — Bourgogne-Franche-Comté | Questions fréquentes | 684 → 849 | ⚠️ écart +165 px |
| 12 | Vos locaux, où que vous soyez en région | Demander un devis | 319 → 363 | ≈ proche |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Dijon) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dijon | Entreprise de nettoyage à Dijon | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 430 | ⚠️ écart +244 px |
| 4 | (Réponse directeTop-Famille Pro est une) | Services disponibles ici | 323 → 235 | ⚠️ écart -88 px |
| 5 | Une entreprise implantée à Saint-Apollinaire,  | Comment nous travaillons ici | 2003 → 327 | ⚠️ écart -1676 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Espaces, tâches et fréquences | Villes et communes proches | 1513 → 212 | ⚠️ écart -1301 px |
| 9 | Quartiers et zones d'activité | (← Voir tout le département Côte-d’Or) | 374 → 152 | ⚠️ écart -222 px |
| 10 | Dans le même département | Ce qui n'est pas couvert | 385 → 242 | ⚠️ écart -143 px |
| 11 | Questions fréquentes — Dijon | FAQ locale | 684 → 849 | ⚠️ écart +165 px |
| 12 | Nous contacter | (En savoir plus sur le nettoyage profes) | 291 → 154 | ⚠️ écart -137 px |
| 13 | Un devis pour vos locaux | Demander un devis à Dijon | 319 → 392 | ⚠️ écart +73 px |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeBeaune est une commune ) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Comment nous travaillons ici | 1059 → 218 | ⚠️ écart -841 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 478 → 213 | ⚠️ écart -265 px |
| 8 | Hébergements et locations meublées | (← Voir tout le département Côte-d’Or) | 1174 → 152 | ⚠️ écart -1022 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 386 → 499 | ⚠️ écart +113 px |
| 11 | Questions fréquentes — Beaune | (En savoir plus sur le nettoyage profes) | 684 → 154 | ⚠️ écart -530 px |
| 12 | Nous contacter | Demander un devis à Beaune | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Doubs / Besançon) | (Accueil/Zones d'intervention/Doubs/Bes) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Besançon | Entreprise de nettoyage à Besançon | 474 → 383 | ⚠️ écart -91 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 413 | ⚠️ écart +227 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Besançon | Comment nous travaillons ici | 1750 → 300 | ⚠️ écart -1450 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Commerces du centre historique et immeubles an | (← Voir tout le département Doubs) | 1489 → 152 | ⚠️ écart -1337 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 849 | ⚠️ écart +464 px |
| 11 | Questions fréquentes — Besançon | (En savoir plus sur le nettoyage profes) | 684 → 154 | ⚠️ écart -530 px |
| 12 | Nous contacter | Demander un devis à Besançon | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Dole) | (Accueil/Zones d'intervention/Jura/Dole) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Dole | Entreprise de nettoyage à Dole | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre position sur le bassin dolois | Comment nous travaillons ici | 1816 → 272 | ⚠️ écart -1544 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 478 → 213 | ⚠️ écart -265 px |
| 8 | Fréquences, horaires et matériel | (← Voir tout le département Jura) | 1566 → 152 | ⚠️ écart -1414 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Dole | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Dole | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Jura / Lons-le-Saunier) | (Accueil/Zones d'intervention/Jura/Lons) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Lons-le-Saunier | Entreprise de nettoyage à Lons-le-Saunier | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Lons-le-Saunier | Comment nous travaillons ici | 1911 → 272 | ⚠️ écart -1639 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Agroalimentaire et thermalisme : notre périmèt | (← Voir tout le département Jura) | 1528 → 152 | ⚠️ écart -1376 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Lons-le-Saunier | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Lons-le-Saunier | 291 → 442 | ⚠️ écart +151 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Nièvre / Nevers) | (Accueil/Zones d'intervention/Nièvre/Ne) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Nevers | Entreprise de nettoyage à Nevers | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Nevers | Comment nous travaillons ici | 1891 → 272 | ⚠️ écart -1619 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Accès aux immeubles et aux locaux | (← Voir tout le département Nièvre) | 1394 → 152 | ⚠️ écart -1242 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Nevers | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Nevers | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Haute-Saône / Vesoul) | (Accueil/Zones d'intervention/Haute-Saô) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Vesoul | Entreprise de nettoyage à Vesoul | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Vesoul | Comment nous travaillons ici | 1929 → 245 | ⚠️ écart -1684 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Fréquences et créneaux hors horaires | (← Voir tout le département Haute-Saône) | 1516 → 152 | ⚠️ écart -1364 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Vesoul | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Vesoul | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Chalo) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chalon-sur-Saône | Entreprise de nettoyage à Chalon-sur-Saône | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement sur le Grand Chalon | Comment nous travaillons ici | 1789 → 272 | ⚠️ écart -1517 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 417 → 213 | ⚠️ écart -204 px |
| 8 | Fréquences et horaires | (← Voir tout le département Saône-et-Lo) | 1516 → 152 | ⚠️ écart -1364 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Chalon-sur-Saône | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Chalon-sur-Saône | 291 → 442 | ⚠️ écart +151 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Saône-et-Loire / Mâcon) | (Accueil/Zones d'intervention/Saône-et-) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Mâcon | Entreprise de nettoyage à Mâcon | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 413 | ⚠️ écart +227 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Mâcon | Comment nous travaillons ici | 1866 → 272 | ⚠️ écart -1594 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 404 → 213 | ⚠️ écart -191 px |
| 8 | Fréquences et horaires | (← Voir tout le département Saône-et-Lo) | 1463 → 152 | ⚠️ écart -1311 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Mâcon | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Mâcon | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Yonne / Auxerre) | (Accueil/Zones d'intervention/Yonne/Aux) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Auxerre | Entreprise de nettoyage à Auxerre | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Auxerre | Comment nous travaillons ici | 1789 → 272 | ⚠️ écart -1517 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 417 → 213 | ⚠️ écart -204 px |
| 8 | Fréquences et horaires | (← Voir tout le département Yonne) | 1543 → 152 | ⚠️ écart -1391 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Auxerre | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Auxerre | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Territoire de Belfort ) | (Accueil/Zones d'intervention/Territoir) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Belfort | Entreprise de nettoyage à Belfort | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 387 | ⚠️ écart +201 px |
| 4 | (Réponse directeTop-Famille Pro intervi) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Notre positionnement à Belfort | Comment nous travaillons ici | 1843 → 300 | ⚠️ écart -1543 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Fréquences et créneaux en soirée | (← Voir tout le département Territoire ) | 1489 → 152 | ⚠️ écart -1337 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 276 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 762 | ⚠️ écart +377 px |
| 11 | Questions fréquentes — Belfort | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Belfort | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/a-propos` → `/a-propos/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / À propos) | (Accueil/À propos) | 42 → 57 | ≈ proche |
| 2 | Une entreprise régionale, un visage | À propos de Top-Famille Pro | 612 → 139 | ⚠️ écart -473 px |
| 3 | (« Mon rôle, c'est de rester joignable ) | Audrey Brançon, gérante | 277 → 728 | ⚠️ écart +451 px |
| 4 | (ProximitéBasée à Saint-Apollinaire, no) | Notre marque sœur | 321 → 317 | ✅ identique |
| 5 | Qui nous sommes | Échanger avec Audrey | 2083 → 363 | ⚠️ écart -1720 px |
| 6 | Parlons de vos locaux | — | 277 → — | ❌ absent côté WordPress |

### `#/recrutement` → `/recrutement/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 119 → 141 | ≈ proche |
| 2 | Rejoindre Top-Famille Pro | Recrutement — agents d'entretien | 1572 → 699 | ⚠️ écart -873 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Top-Famille Pro | 158 → 525 | ⚠️ écart +367 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | — | 544 → — | ❌ absent côté WordPress |

### `#/mentions-legales` → `/mentions-legales/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | Éditeur du site | 119 → 429 | ⚠️ écart +310 px |
| 2 | Mentions légales | Hébergement | 1193 → 198 | ⚠️ écart -995 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Établissement unique | 158 → 140 | ≈ proche |
| 4 | (Top-Famille Pro Nettoyage professionne) | Propriété intellectuelle | 544 → 140 | ⚠️ écart -404 px |
| 5 | — | Données personnelles | — → 111 | ➕ en plus côté WordPress |
| 6 | — | Droit applicable | — → 111 | ➕ en plus côté WordPress |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | Responsable du traitement | 119 → 111 | ✅ identique |
| 2 | Politique de confidentialité | Données collectées | 1115 → 307 | ⚠️ écart -808 px |
| 3 | Un besoin d'entretien pour vos locaux ? | Finalité et destinataire | 158 → 169 | ≈ proche |
| 4 | (Top-Famille Pro Nettoyage professionne) | Durée de conservation | 544 → 111 | ⚠️ écart -433 px |
| 5 | — | Sous-traitants | — → 140 | ➕ en plus côté WordPress |
| 6 | — | Vos droits | — → 179 | ➕ en plus côté WordPress |
| 7 | — | Candidatures | — → 111 | ➕ en plus côté WordPress |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 119 → 141 | ≈ proche |
| 2 | Gestion des cookies | Gestion des cookies | 897 → 922 | ≈ proche |
| 3 | Un besoin d'entretien pour vos locaux ? | Top-Famille Pro | 158 → 525 | ⚠️ écart +367 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | — | 544 → — | ❌ absent côté WordPress |

### `#/plan-du-site` → `/plan-du-site/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (27 € HT/h · Devis gratuit sous 24 h ★★) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 119 → 141 | ≈ proche |
| 2 | Plan du site | Plan du site | 1154 → 1172 | ≈ proche |
| 3 | Un besoin d'entretien pour vos locaux ? | Top-Famille Pro | 158 → 525 | ⚠️ écart +367 px |
| 4 | (Top-Famille Pro Nettoyage professionne) | — | 544 → — | ❌ absent côté WordPress |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Combien coûte le ) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 42 → 141 | ⚠️ écart +99 px |
| 2 | Combien coûte le nettoyage de bureaux ? | Combien coûte le nettoyage de bureaux ? | 728 → 2835 | ⚠️ écart +2107 px |
| 3 | (Le nettoyage de bureaux est facturé au) | Top-Famille Pro | 242 → 525 | ⚠️ écart +283 px |
| 4 | (Sommaire Comment se calcule le prix du) | — | 397 → — | ❌ absent côté WordPress |
| 5 | Comment se calcule le prix du nettoyage de bur | — | 1198 → — | ❌ absent côté WordPress |
| 6 | Erreurs à éviter | — | 253 → — | ❌ absent côté WordPress |
| 7 | Questions fréquentes | — | 342 → — | ❌ absent côté WordPress |
| 8 | (Pour situer ces repères dans une prest) | — | 202 → — | ❌ absent côté WordPress |
| 9 | Un devis pour vos locaux ? | — | 317 → — | ❌ absent côté WordPress |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / À quelle fréquenc) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 42 → 141 | ⚠️ écart +99 px |
| 2 | À quelle fréquence faire nettoyer ses bureaux  | À quelle fréquence faire nettoyer ses bureaux  | 728 → 2701 | ⚠️ écart +1973 px |
| 3 | (La fréquence adaptée dépend surtout de) | Top-Famille Pro | 242 → 525 | ⚠️ écart +283 px |
| 4 | (Sommaire Ce qui détermine la bonne fré) | — | 367 → — | ❌ absent côté WordPress |
| 5 | Ce qui détermine la bonne fréquence | — | 1099 → — | ❌ absent côté WordPress |
| 6 | Erreurs à éviter | — | 278 → — | ❌ absent côté WordPress |
| 7 | Questions fréquentes | — | 342 → — | ❌ absent côté WordPress |
| 8 | (Pour situer ces repères dans une prest) | — | 202 → — | ❌ absent côté WordPress |
| 9 | Un devis pour vos locaux ? | — | 317 → — | ❌ absent côté WordPress |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils / Comment rédiger u) | (27 € HT/h · Devis gratuit sous 24 h ★★) | 42 → 141 | ⚠️ écart +99 px |
| 2 | Comment rédiger un cahier des charges de netto | Comment rédiger un cahier des charges de netto | 728 → 3017 | ⚠️ écart +2289 px |
| 3 | (Un cahier des charges de nettoyage pro) | Top-Famille Pro | 242 → 525 | ⚠️ écart +283 px |
| 4 | (Sommaire Pourquoi un cahier des charge) | — | 397 → — | ❌ absent côté WordPress |
| 5 | Pourquoi un cahier des charges change tout | — | 1324 → — | ❌ absent côté WordPress |
| 6 | Erreurs à éviter | — | 227 → — | ❌ absent côté WordPress |
| 7 | Questions fréquentes | — | 342 → — | ❌ absent côté WordPress |
| 8 | (Pour situer ces repères dans une prest) | — | 202 → — | ❌ absent côté WordPress |
| 9 | Un devis pour vos locaux ? | — | 317 → — | ❌ absent côté WordPress |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Saint-Apol) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Saint-Apollinaire | Entreprise de nettoyage à Saint-Apollinaire | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 213 | ≈ proche |
| 4 | (Réponse directeTop-Famille Pro est imp) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Notre implantation réelle, et rien d'autre | Comment nous travaillons ici | 1163 → 218 | ⚠️ écart -945 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 478 → 213 | ⚠️ écart -265 px |
| 8 | Fonctionnement, sélection et suivi | (← Voir tout le département Côte-d’Or) | 1200 → 152 | ⚠️ écart -1048 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 386 → 499 | ⚠️ écart +113 px |
| 11 | Questions fréquentes — Saint-Apollinaire | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Saint-Apollinaire | 291 → 442 | ⚠️ écart +151 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Chenôve) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Chenôve | Entreprise de nettoyage à Chenôve | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeChenôve est une commune) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Chenôve dans l'agglomération dijonnaise | Comment nous travaillons ici | 1203 → 218 | ⚠️ écart -985 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Commerces, bureaux et cabinets | (← Voir tout le département Côte-d’Or) | 1163 → 152 | ⚠️ écart -1011 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 499 | ⚠️ écart +114 px |
| 11 | Questions fréquentes — Chenôve | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Chenôve | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Quetigny) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Quetigny | Entreprise de nettoyage à Quetigny | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeQuetigny est une commun) | Services disponibles ici | 291 → 376 | ⚠️ écart +85 px |
| 5 | Quetigny, commune voisine de notre implantatio | Comment nous travaillons ici | 1140 → 218 | ⚠️ écart -922 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Bureaux, cabinets et parties communes | (← Voir tout le département Côte-d’Or) | 1148 → 152 | ⚠️ écart -996 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 386 → 499 | ⚠️ écart +113 px |
| 11 | Questions fréquentes — Quetigny | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Quetigny | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Talant) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Talant | Entreprise de nettoyage à Talant | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeTalant est une commune ) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Talant, commune limitrophe de Dijon | Comment nous travaillons ici | 1083 → 218 | ⚠️ écart -865 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Cabinets, commerces et petits bureaux | (← Voir tout le département Côte-d’Or) | 1110 → 152 | ⚠️ écart -958 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 499 | ⚠️ écart +114 px |
| 11 | Questions fréquentes — Talant | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Talant | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Longvic) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Longvic | Entreprise de nettoyage à Longvic | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 239 | ≈ proche |
| 4 | (Réponse directeLongvic est une commune) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Longvic, commune d'activité au sud de Dijon | Comment nous travaillons ici | 1110 → 218 | ⚠️ écart -892 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 452 → 213 | ⚠️ écart -239 px |
| 8 | Bureaux, commerces, cabinets et parties commun | (← Voir tout le département Côte-d’Or) | 1110 → 152 | ⚠️ écart -958 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 386 → 499 | ⚠️ écart +113 px |
| 11 | Questions fréquentes — Longvic | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Longvic | 291 → 392 | ⚠️ écart +101 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Fontaine-l) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Fontaine-lès-Dijon | Entreprise de nettoyage à Fontaine-lès-Dijon | 474 → 353 | ⚠️ écart -121 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeFontaine-lès-Dijon est ) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Fontaine-lès-Dijon dans l'agglomération | Comment nous travaillons ici | 1409 → 218 | ⚠️ écart -1191 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Fonctionnement, sélection et suivi | (← Voir tout le département Côte-d’Or) | 1163 → 152 | ⚠️ écart -1011 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 499 | ⚠️ écart +114 px |
| 11 | Questions fréquentes — Fontaine-lès-Dijon | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Fontaine-lès-Dijon | 291 → 442 | ⚠️ écart +151 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Marsannay-) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Marsannay-la-Côte | Entreprise de nettoyage à Marsannay-la-Côte | 507 → 353 | ⚠️ écart -154 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | Le tissu économique du secteur | 186 → 188 | ✅ identique |
| 4 | (Réponse directeMarsannay-la-Côte est u) | Services disponibles ici | 323 → 376 | ≈ proche |
| 5 | Marsannay-la-Côte, entre agglomération et Côte | Comment nous travaillons ici | 1090 → 218 | ⚠️ écart -872 px |
| 6 | Nos prestations sur place | Le tarif, en toute transparence | 640 → 237 | ⚠️ écart -403 px |
| 7 | Tarif et exemple local | Votre interlocutrice | 427 → 213 | ⚠️ écart -214 px |
| 8 | Événements et périodes de forte fréquentation | (← Voir tout le département Côte-d’Or) | 1121 → 152 | ⚠️ écart -969 px |
| 9 | Quartiers et zones d'activité | Ce qui n'est pas couvert | 228 → 242 | ≈ proche |
| 10 | Dans le même département | FAQ locale | 385 → 499 | ⚠️ écart +114 px |
| 11 | Questions fréquentes — Marsannay-la-Côte | (En savoir plus sur le nettoyage profes) | 614 → 154 | ⚠️ écart -460 px |
| 12 | Nous contacter | Demander un devis à Marsannay-la-Côte | 291 → 442 | ⚠️ écart +151 px |
| 13 | Un devis pour vos locaux | — | 319 → — | ❌ absent côté WordPress |

