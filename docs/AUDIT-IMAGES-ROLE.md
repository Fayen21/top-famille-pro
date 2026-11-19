# Audit des images par rôle — maquette ↔ WordPress

> Fichier **généré** par `node tools/audit-images-role.mjs`. Ne pas éditer à la main.
>
> Les images sont appariées sur leur **rôle** dans la page (logo, hero, éditoriale, vignette),
> pas comptées en bloc, puis comparées sur les **octets de leur source** (SHA-256)
> **et sur leur position dans le flux** : titre de la bande qui les porte, titres des bandes
> qui l'encadrent. Un fichier correct servi dans la mauvaise bande est un écart — l'empreinte
> seule ne l'aurait jamais montré (G27 §7).

**164 images auditées sur 53 routes · 0 écart(s).**

| Route | Rôle | # | SHA-256 maquette | SHA-256 WordPress | Slot | Bande (maquette → site) | Avant | Après | Résultat |
|---|---|---:|---|---|---|---|---|---|---|
| `#/` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | Nettoyage professionnel de bureaux | ✅ identique |
| `#/` | hero | 1 | 0f8fb0ce37ddc15c | 0f8fb0ce37ddc15c | hero-main | Nettoyage professionnel de bureaux | — | — | ✅ identique |
| `#/` | editoriale | 1 | d90ac841df35ad7a | d90ac841df35ad7a | hero-secondary | Nettoyage professionnel de bureaux | — | — | ✅ identique |
| `#/` | editoriale | 2 | 91b93f915a21fbd9 | 91b93f915a21fbd9 | accueil-bureaux | Nos prestations de nettoyage | Pensé pour les professionnels de l | Les difficultés que nous prenons e | ✅ identique |
| `#/` | editoriale | 3 | 46a86c7e9eac3d5f | 46a86c7e9eac3d5f | accueil-commerces | Nos prestations de nettoyage | Pensé pour les professionnels de l | Les difficultés que nous prenons e | ✅ identique |
| `#/` | editoriale | 4 | 18af9088fd99e88a | 18af9088fd99e88a | audrey-portrait | Audrey, votre interlocutrice | Une couverture régionale, pas des  | Conseils & repères | ✅ identique |
| `#/` | editoriale | 5 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | article-1 | Conseils & repères | Audrey, votre interlocutrice | Demandez votre devis gratuit et sa | ✅ identique |
| `#/` | editoriale | 6 | 31c59a38757a0320 | 31c59a38757a0320 | article-2 | Conseils & repères | Audrey, votre interlocutrice | Demandez votre devis gratuit et sa | ✅ identique |
| `#/` | editoriale | 7 | f1c64c6392df9f43 | f1c64c6392df9f43 | article-3 | Conseils & repères | Audrey, votre interlocutrice | Demandez votre devis gratuit et sa | ✅ identique |
| `#/` | vignette | 1 | e73f0f091f2cad51 | e73f0f091f2cad51 | avatar-temoignage | Pourquoi Top-Famille Pro | Les difficultés que nous prenons e | Notre fonctionnement, en cinq temp | ✅ identique |
| `#/` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | Nettoyage professionnel de bureaux | ✅ identique |
| `#/nettoyage-professionnel` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/nettoyage-professionnel` | hero | 1 | dbc3d6162557a762 | dbc3d6162557a762 | hero-pilier | Le nettoyage professionnel de vos  | — | — | ✅ identique |
| `#/nettoyage-professionnel` | editoriale | 1 | 18af9088fd99e88a | 18af9088fd99e88a | audrey-portrait | Cahier des charges, intervenants e | Comment se construit un cahier des | — | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 1 | 0d32ae6733eee622 | 0d32ae6733eee622 | thumb-bureaux | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 2 | 0d8cf57d64f5124d | 0d8cf57d64f5124d | thumb-commerces | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 3 | c55d8a5619d299c5 | c55d8a5619d299c5 | thumb-cabinets | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 4 | ecee90efb0f2ef69 | ecee90efb0f2ef69 | thumb-coproprietes | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 5 | e2440e590fa6dd38 | e2440e590fa6dd38 | thumb-meubles | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 6 | 03752d889ac8f8d3 | 03752d889ac8f8d3 | thumb-ponctuel | Nos six prestations de nettoyage p | Prestataire de nettoyage ou recrut | Régulier ou ponctuel, tâches, fréq | ✅ identique |
| `#/nettoyage-professionnel` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/nos-prestations` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/nos-prestations` | editoriale | 1 | 0d32ae6733eee622 | 0d32ae6733eee622 | service-bureaux | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | editoriale | 2 | 0d8cf57d64f5124d | 0d8cf57d64f5124d | service-commerces | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | editoriale | 3 | c55d8a5619d299c5 | c55d8a5619d299c5 | service-cabinets | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | editoriale | 4 | ecee90efb0f2ef69 | ecee90efb0f2ef69 | service-coproprietes | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | editoriale | 5 | e2440e590fa6dd38 | e2440e590fa6dd38 | service-meubles | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | editoriale | 6 | 03752d889ac8f8d3 | 03752d889ac8f8d3 | service-ponctuel | — | Ce qui est commun aux six prestati | Besoin d'aide pour choisir ? | ✅ identique |
| `#/nos-prestations` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/bureaux` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/bureaux` | hero | 1 | 0d32ae6733eee622 | 0d32ae6733eee622 | service-bureaux | Nettoyage de bureaux en Bourgogne- | — | — | ✅ identique |
| `#/service/bureaux` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/commerces` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/commerces` | hero | 1 | 0d8cf57d64f5124d | 0d8cf57d64f5124d | service-commerces | Nettoyage de commerces et de surfa | — | — | ✅ identique |
| `#/service/commerces` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/cabinets` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/cabinets` | hero | 1 | c55d8a5619d299c5 | c55d8a5619d299c5 | service-cabinets | Nettoyage de cabinets et de profes | — | — | ✅ identique |
| `#/service/cabinets` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/coproprietes` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/coproprietes` | hero | 1 | ecee90efb0f2ef69 | ecee90efb0f2ef69 | service-coproprietes | Entretien de copropriétés et de pa | — | — | ✅ identique |
| `#/service/coproprietes` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/meubles` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/meubles` | hero | 1 | e2440e590fa6dd38 | e2440e590fa6dd38 | service-meubles | Nettoyage de locations meublées et | — | — | ✅ identique |
| `#/service/meubles` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/service/ponctuel` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/service/ponctuel` | hero | 1 | 03752d889ac8f8d3 | 03752d889ac8f8d3 | service-ponctuel | Nettoyage ponctuel et remise en ét | — | — | ✅ identique |
| `#/service/ponctuel` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/nos-tarifs` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/nos-tarifs` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/zones-intervention` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/zones-intervention` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/bourgogne-franche-comte` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/bourgogne-franche-comte` | hero | 1 | 6454730804f7e4b5 | 6454730804f7e4b5 | hero-region | Entreprise de nettoyage en Bourgog | — | — | ✅ identique |
| `#/bourgogne-franche-comte` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/cote-dor` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/cote-dor` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/doubs` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/doubs` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/jura` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/jura` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/nievre` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/nievre` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/haute-saone` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/haute-saone` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/saone-et-loire` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/saone-et-loire` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/yonne` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/yonne` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/departement/territoire-de-belfort` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/departement/territoire-de-belfort` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/dijon` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/dijon` | hero | 1 | 5f1f95810af0a046 | 5f1f95810af0a046 | ville-dijon | Entreprise de nettoyage à Dijon | — | — | ✅ identique |
| `#/ville/dijon` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/besancon` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/besancon` | hero | 1 | 99ada67d6120d55c | 99ada67d6120d55c | ville-besancon | Entreprise de nettoyage à Besançon | — | — | ✅ identique |
| `#/ville/besancon` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/dole` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/dole` | hero | 1 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | ville-dole | Entreprise de nettoyage à Dole | — | — | ✅ identique |
| `#/ville/dole` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/lons-le-saunier` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/lons-le-saunier` | hero | 1 | fef95157c7aa6c84 | fef95157c7aa6c84 | ville-lons-le-saunier | Entreprise de nettoyage à Lons-le- | — | — | ✅ identique |
| `#/ville/lons-le-saunier` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/nevers` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/nevers` | hero | 1 | fc4bfb44d2569326 | fc4bfb44d2569326 | ville-nevers | Entreprise de nettoyage à Nevers | — | — | ✅ identique |
| `#/ville/nevers` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/vesoul` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/vesoul` | hero | 1 | f404f819aba656a5 | f404f819aba656a5 | ville-vesoul | Entreprise de nettoyage à Vesoul | — | — | ✅ identique |
| `#/ville/vesoul` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/chalon-sur-saone` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/chalon-sur-saone` | hero | 1 | d527896a48ac3f8c | d527896a48ac3f8c | ville-chalon-sur-saone | Entreprise de nettoyage à Chalon-s | — | — | ✅ identique |
| `#/ville/chalon-sur-saone` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/macon` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/macon` | hero | 1 | bd077ba50393c4f3 | bd077ba50393c4f3 | ville-macon | Entreprise de nettoyage à Mâcon | — | — | ✅ identique |
| `#/ville/macon` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/auxerre` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/auxerre` | hero | 1 | 91b93f915a21fbd9 | 91b93f915a21fbd9 | ville-auxerre | Entreprise de nettoyage à Auxerre | — | — | ✅ identique |
| `#/ville/auxerre` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/belfort` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/belfort` | hero | 1 | 46a86c7e9eac3d5f | 46a86c7e9eac3d5f | ville-belfort | Entreprise de nettoyage à Belfort | — | — | ✅ identique |
| `#/ville/belfort` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/saint-apollinaire` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/saint-apollinaire` | hero | 1 | bd077ba50393c4f3 | bd077ba50393c4f3 | ville-saint-apollinaire | Entreprise de nettoyage à Saint-Ap | — | — | ✅ identique |
| `#/ville/saint-apollinaire` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/chenove` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/chenove` | hero | 1 | 99ada67d6120d55c | 99ada67d6120d55c | ville-chenove | Entreprise de nettoyage à Chenôve | — | — | ✅ identique |
| `#/ville/chenove` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/quetigny` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/quetigny` | hero | 1 | 46a86c7e9eac3d5f | 46a86c7e9eac3d5f | ville-quetigny | Entreprise de nettoyage à Quetigny | — | — | ✅ identique |
| `#/ville/quetigny` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/talant` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/talant` | hero | 1 | fef95157c7aa6c84 | fef95157c7aa6c84 | ville-talant | Entreprise de nettoyage à Talant | — | — | ✅ identique |
| `#/ville/talant` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/longvic` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/longvic` | hero | 1 | 91b93f915a21fbd9 | 91b93f915a21fbd9 | ville-longvic | Entreprise de nettoyage à Longvic | — | — | ✅ identique |
| `#/ville/longvic` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/fontaine-les-dijon` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/fontaine-les-dijon` | hero | 1 | 6e45e7676ac788cb | 6e45e7676ac788cb | ville-fontaine-les-dijon | Entreprise de nettoyage à Fontaine | — | — | ✅ identique |
| `#/ville/fontaine-les-dijon` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/marsannay-la-cote` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/marsannay-la-cote` | hero | 1 | d527896a48ac3f8c | d527896a48ac3f8c | ville-marsannay-la-cote | Entreprise de nettoyage à Marsanna | — | — | ✅ identique |
| `#/ville/marsannay-la-cote` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/ville/beaune` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/ville/beaune` | hero | 1 | 31c59a38757a0320 | 31c59a38757a0320 | ville-beaune | Entreprise de nettoyage à Beaune | — | — | ✅ identique |
| `#/ville/beaune` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/conseils` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/conseils` | editoriale | 1 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | article-1 | **—** → **À quelle fréquence faire nettoyer ** | — | Les autres articles | ✅ identique |
| `#/conseils` | editoriale | 2 | 31c59a38757a0320 | 31c59a38757a0320 | article-2 | Les autres articles | **—** → **À quelle fréquence faire nettoyer ** | Passer du conseil à votre situatio | ✅ identique |
| `#/conseils` | editoriale | 3 | f1c64c6392df9f43 | f1c64c6392df9f43 | article-3 | Les autres articles | **—** → **À quelle fréquence faire nettoyer ** | Passer du conseil à votre situatio | ✅ identique |
| `#/conseils` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/article/frequence-bureaux` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/article/frequence-bureaux` | hero | 1 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | article-1 | À quelle fréquence faire nettoyer  | — | — | ✅ identique |
| `#/article/frequence-bureaux` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/article/cout-nettoyage-bureaux` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/article/cout-nettoyage-bureaux` | hero | 1 | 31c59a38757a0320 | 31c59a38757a0320 | article-2 | Combien coûte le nettoyage de bure | — | — | ✅ identique |
| `#/article/cout-nettoyage-bureaux` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/article/cahier-des-charges-nettoyage` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/article/cahier-des-charges-nettoyage` | hero | 1 | f1c64c6392df9f43 | f1c64c6392df9f43 | article-3 | Comment rédiger un cahier des char | — | — | ✅ identique |
| `#/article/cahier-des-charges-nettoyage` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/pourquoi-top-famille-pro` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/pourquoi-top-famille-pro` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/notre-fonctionnement` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/notre-fonctionnement` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/avis-clients` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/avis-clients` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/a-propos` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/a-propos` | hero | 1 | c6c51783628e3170 | c6c51783628e3170 | audrey-placeholder | Une entreprise régionale, un visag | — | — | ✅ identique |
| `#/a-propos` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/recrutement` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/recrutement` | hero | 1 | 600a388c7750c405 | 600a388c7750c405 | service-generic | Rejoindre Top-Famille Pro | — | Les missions que nous confions | ✅ identique |
| `#/recrutement` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/demande-de-devis` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | Demandez votre devis gratuit | — | — | ✅ identique |
| `#/demande-de-devis` | vignette | 1 | f9c6cb81f75acb82 | f9c6cb81f75acb82 | portrait-contact | Demandez votre devis gratuit | — | — | ✅ identique |
| `#/demande-de-devis` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | Demandez votre devis gratuit | — | — | ✅ identique |
| `#/contact` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/contact` | vignette | 1 | f9c6cb81f75acb82 | f9c6cb81f75acb82 | portrait-contact | **—** → **J’ai une question** | — | — | ✅ identique |
| `#/contact` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/plan-du-site` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/plan-du-site` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/mentions-legales` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/mentions-legales` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/politique-de-confidentialite` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/politique-de-confidentialite` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
| `#/gestion-des-cookies` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | — | — | — | ✅ identique |
| `#/gestion-des-cookies` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | — | — | — | ✅ identique |
