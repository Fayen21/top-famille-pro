# Inventaire des cartes — maquette Claude Design ↔ WordPress

> Fichier **généré** par `node tools/inventaire-cartes.mjs`. Ne pas éditer à la main.
>
> Une page peut contenir toutes les phrases du prototype, faire la même hauteur, et présenter
> huit contraintes dans deux gros pavés là où la maquette en fait huit micro-cartes. Cet
> inventaire relève **chaque carte** des deux côtés — archétype, bande, titre, texte, médias,
> géométrie, colonnes — et nomme quatre familles d’anomalies : carte **absente**, cartes
> **fusionnées**, carte **supplémentaire**, mauvais **type** ou mauvais nombre de **colonnes**.
>
> Un conteneur qui contient visuellement plusieurs micro-cartes n’est jamais compté pour une
> carte : il compte pour ses enfants.

**53 routes × 2 largeurs · 934 anomalie(s), dont 283 grave(s)** (carte absente ou fusionnée).

## Synthèse

| Route | Cartes 1440 px | Cartes 375 px | Anomalies 1440 px | Anomalies 375 px |
|---|---|---|---|---|
| `#/` | 27 → 33 (+6) | 29 → 33 (+4) | ❌ 23 (7) | ❌ 20 (7) |
| `#/nettoyage-professionnel` | 53 → 54 (+1) | 53 → 51 (-2) | ❌ 14 (2) | ❌ 12 (3) |
| `#/nos-prestations` | 12 → 13 (+1) | 12 → 13 (+1) | ⚠️ 1 | ⚠️ 1 |
| `#/service/bureaux` | 21 → 21 | 22 → 22 | ✅ | ✅ |
| `#/service/commerces` | 20 → 20 | 21 → 21 | ⚠️ 1 | ✅ |
| `#/service/cabinets` | 28 → 28 | 29 → 29 | ⚠️ 2 | ⚠️ 1 |
| `#/service/coproprietes` | 21 → 21 | 22 → 22 | ⚠️ 1 | ✅ |
| `#/service/meubles` | 21 → 21 | 22 → 22 | ⚠️ 2 | ⚠️ 1 |
| `#/service/ponctuel` | 21 → 21 | 22 → 22 | ⚠️ 1 | ✅ |
| `#/nos-tarifs` | 22 → 21 (-1) | 22 → 21 (-1) | ❌ 10 (2) | ❌ 3 (2) |
| `#/zones-intervention` | 52 → 49 (-3) | 35 → 49 (+14) | ❌ 11 (4) | ❌ 30 (5) |
| `#/bourgogne-franche-comte` | 51 → 56 (+5) | 48 → 56 (+8) | ❌ 22 (1) | ❌ 26 (2) |
| `#/departement/cote-dor` | 31 → 30 (-1) | 32 → 31 (-1) | ❌ 14 (4) | ❌ 14 (4) |
| `#/departement/doubs` | 31 → 29 (-2) | 32 → 30 (-2) | ❌ 14 (4) | ❌ 9 (4) |
| `#/departement/jura` | 33 → 31 (-2) | 34 → 32 (-2) | ❌ 14 (4) | ❌ 14 (4) |
| `#/departement/nievre` | 31 → 29 (-2) | 32 → 30 (-2) | ❌ 11 (4) | ❌ 15 (4) |
| `#/departement/haute-saone` | 31 → 29 (-2) | 32 → 30 (-2) | ❌ 15 (4) | ❌ 15 (4) |
| `#/departement/saone-et-loire` | 31 → 29 (-2) | 33 → 32 (-1) | ❌ 14 (4) | ❌ 10 (4) |
| `#/departement/yonne` | 31 → 29 (-2) | 32 → 30 (-2) | ❌ 12 (4) | ❌ 12 (4) |
| `#/departement/territoire-de-belfort` | 31 → 29 (-2) | 32 → 30 (-2) | ❌ 16 (4) | ❌ 11 (4) |
| `#/ville/dijon` | 49 → 48 (-1) | 50 → 49 (-1) | ❌ 10 (3) | ❌ 11 (3) |
| `#/ville/besancon` | 51 → 49 (-2) | 52 → 50 (-2) | ❌ 7 (4) | ❌ 12 (4) |
| `#/ville/dole` | 50 → 48 (-2) | 51 → 49 (-2) | ❌ 7 (4) | ❌ 11 (4) |
| `#/ville/lons-le-saunier` | 49 → 47 (-2) | 50 → 48 (-2) | ❌ 7 (4) | ❌ 11 (4) |
| `#/ville/nevers` | 50 → 48 (-2) | 51 → 49 (-2) | ❌ 13 (4) | ❌ 14 (4) |
| `#/ville/vesoul` | 49 → 47 (-2) | 50 → 48 (-2) | ❌ 10 (4) | ❌ 17 (4) |
| `#/ville/chalon-sur-saone` | 48 → 46 (-2) | 51 → 49 (-2) | ❌ 7 (4) | ❌ 13 (4) |
| `#/ville/macon` | 49 → 47 (-2) | 50 → 48 (-2) | ❌ 7 (4) | ❌ 10 (4) |
| `#/ville/auxerre` | 50 → 48 (-2) | 51 → 49 (-2) | ❌ 7 (4) | ❌ 12 (4) |
| `#/ville/belfort` | 50 → 48 (-2) | 51 → 49 (-2) | ❌ 14 (4) | ❌ 13 (4) |
| `#/ville/saint-apollinaire` | 44 → 42 (-2) | 47 → 45 (-2) | ❌ 11 (4) | ❌ 17 (4) |
| `#/ville/chenove` | 41 → 39 (-2) | 42 → 40 (-2) | ❌ 8 (4) | ❌ 14 (4) |
| `#/ville/quetigny` | 37 → 35 (-2) | 38 → 38 | ❌ 14 (4) | ❌ 13 (4) |
| `#/ville/talant` | 41 → 40 (-1) | 42 → 41 (-1) | ❌ 9 (4) | ❌ 14 (4) |
| `#/ville/longvic` | 43 → 41 (-2) | 44 → 42 (-2) | ❌ 13 (4) | ❌ 19 (4) |
| `#/ville/fontaine-les-dijon` | 43 → 42 (-1) | 46 → 45 (-1) | ❌ 10 (4) | ❌ 14 (4) |
| `#/ville/marsannay-la-cote` | 36 → 34 (-2) | 39 → 37 (-2) | ❌ 9 (4) | ❌ 16 (4) |
| `#/ville/beaune` | 41 → 39 (-2) | 42 → 40 (-2) | ❌ 10 (4) | ❌ 14 (4) |
| `#/conseils` | 11 → 14 (+3) | 11 → 14 (+3) | ❌ 5 (1) | ❌ 5 (1) |
| `#/article/frequence-bureaux` | 9 → 8 (-1) | 9 → 8 (-1) | ❌ 8 (4) | ❌ 8 (4) |
| `#/article/cout-nettoyage-bureaux` | 5 → 7 (+2) | 5 → 7 (+2) | ⚠️ 3 | ⚠️ 3 |
| `#/article/cahier-des-charges-nettoyage` | 11 → 8 (-3) | 11 → 8 (-3) | ❌ 10 (6) | ❌ 10 (6) |
| `#/pourquoi-top-famille-pro` | 12 → 13 (+1) | 12 → 13 (+1) | ⚠️ 3 | ⚠️ 5 |
| `#/notre-fonctionnement` | 9 → 13 (+4) | 9 → 13 (+4) | ⚠️ 9 | ⚠️ 9 |
| `#/avis-clients` | 14 → 13 (-1) | 14 → 13 (-1) | ❌ 9 (2) | ❌ 9 (2) |
| `#/a-propos` | 1 → 1 | 1 → 1 | ⚠️ 1 | ⚠️ 1 |
| `#/recrutement` | 6 → 5 (-1) | 6 → 5 (-1) | ❌ 2 (1) | ❌ 2 (1) |
| `#/demande-de-devis` | 5 → 4 (-1) | 5 → 4 (-1) | ❌ 1 (1) | ❌ 1 (1) |
| `#/contact` | 7 → 7 | 7 → 7 | ❌ 6 (3) | ❌ 6 (3) |
| `#/plan-du-site` | 0 → 0 | 0 → 0 | ✅ | ✅ |
| `#/mentions-legales` | 1 → 0 (-1) | 1 → 0 (-1) | ❌ 1 (1) | ❌ 1 (1) |
| `#/politique-de-confidentialite` | 1 → 0 (-1) | 1 → 0 (-1) | ❌ 1 (1) | ❌ 1 (1) |
| `#/gestion-des-cookies` | 1 → 1 | 1 → 1 | ❌ 2 (1) | ❌ 2 (1) |

## Routes à corriger en priorité

| Route | Cartes absentes ou fusionnées | Anomalies totales |
|---|---|---|
| `#/` | 7 | 23 |
| `#/article/cahier-des-charges-nettoyage` | 6 | 10 |
| `#/zones-intervention` | 4 | 11 |
| `#/departement/cote-dor` | 4 | 14 |
| `#/departement/doubs` | 4 | 14 |
| `#/departement/jura` | 4 | 14 |
| `#/departement/nievre` | 4 | 11 |
| `#/departement/haute-saone` | 4 | 15 |
| `#/departement/saone-et-loire` | 4 | 14 |
| `#/departement/yonne` | 4 | 12 |
| `#/departement/territoire-de-belfort` | 4 | 16 |
| `#/ville/besancon` | 4 | 7 |
| `#/ville/dole` | 4 | 7 |
| `#/ville/lons-le-saunier` | 4 | 7 |
| `#/ville/nevers` | 4 | 13 |
| `#/ville/vesoul` | 4 | 10 |
| `#/ville/chalon-sur-saone` | 4 | 7 |
| `#/ville/macon` | 4 | 7 |
| `#/ville/auxerre` | 4 | 7 |
| `#/ville/belfort` | 4 | 14 |
| `#/ville/saint-apollinaire` | 4 | 11 |
| `#/ville/chenove` | 4 | 8 |
| `#/ville/quetigny` | 4 | 14 |
| `#/ville/talant` | 4 | 9 |
| `#/ville/longvic` | 4 | 13 |
| `#/ville/fontaine-les-dijon` | 4 | 10 |
| `#/ville/marsannay-la-cote` | 4 | 9 |
| `#/ville/beaune` | 4 | 10 |
| `#/article/frequence-bureaux` | 4 | 8 |
| `#/ville/dijon` | 3 | 10 |
| `#/contact` | 3 | 6 |
| `#/nettoyage-professionnel` | 2 | 14 |
| `#/nos-tarifs` | 2 | 10 |
| `#/avis-clients` | 2 | 9 |
| `#/bourgogne-franche-comte` | 1 | 22 |
| `#/conseils` | 1 | 5 |
| `#/recrutement` | 1 | 2 |
| `#/demande-de-devis` | 1 | 1 |
| `#/mentions-legales` | 1 | 1 |
| `#/politique-de-confidentialite` | 1 | 1 |
| `#/gestion-des-cookies` | 1 | 2 |

## Archétypes employés par la maquette

| Archétype | Occurrences dans la maquette |
|---|---|
| `carte-titre-texte` | 304 |
| `micro-carte` | 302 |
| `chip` | 247 |
| `faq` | 247 |
| `carte-sombre` | 135 |
| `tarif` | 129 |
| `carte-titre` | 88 |
| `temoignage` | 37 |
| `carte-image` | 16 |
| `etape` | 6 |
| `carte-icone` | 2 |

## Détail par route

### `#/` → `/`

**1440 px** — bandes 13 → 13 · cartes 27 → 33 · 23 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre` | 1 | « ★★★★★ 5,0/5 sur Google Voir les avis » |
| fusionnee | `tarif` | 1 | « ✦27 € HT/hrégulier ou ponctuel » rendue dans « Tarif unique 27 € HT/h Régulier ou ponctuel · devi » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région » |
| absente | `carte-titre-texte` | 3 | « ★★★★★5,0/5 sur Google Saint-ApollinaireEntreprise régionale basée en B » |
| type | `carte-titre-texte` | 5 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-sombre` |
| absente | `tarif` | 9 | « Tarif horaire de base 27 € HT/h Régulier ou ponctuel · devis gratuit s » |
| colonnes | `carte-image` | 10 | « 21 25 39 58 70 71 89 90 » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre` | 11 | « ★★★★★5,0/5 Google » |
| surplus | `chip` | 1 | « ★★★★★5,0/5 sur Google » |
| surplus | `tarif` | 1 | « 27 € HT/h tarif unique, régulier ou ponctuel » |
| surplus | `carte-image` | 1 | «  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis ✓Devis gratuit sous 24  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis » |
| surplus | `carte-titre-texte` | 3 | « Saint-Apollinaire Entreprise régionale basée en BFC Interlocutrice ide » |
| surplus | `carte-sombre` | 5 | « Copropriétés & parties communes Halls, cages d'escalier, locaux commun » |
| surplus | `carte-sombre` | 5 | « Locations meublées & hébergements Remise en état entre deux occupants » |
| surplus | `carte-sombre` | 5 | « Ponctuel & remise en état Après travaux, grand nettoyage, fin de bail » |
| surplus | `tarif` | 9 | « Tarif unique 27 € HT/h Régulier ou ponctuel · devis gratuit sous 24 h. » |
| surplus | `carte-titre` | 10 | « Yonne 89 » |
| surplus | `carte-titre` | 10 | « Territoire de Belfort 90 » |
| surplus | `micro-carte` | 11 | «  » |
| surplus | `carte-titre` | 11 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 13 → 13 · cartes 29 → 33 · 20 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre` | 1 | « ★★★★★ 5,0/5 sur Google Voir les avis » |
| fusionnee | `tarif` | 1 | « ✦27 € HT/hrégulier ou ponctuel » rendue dans « Tarif unique 27 € HT/h Régulier ou ponctuel · devi » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région » |
| absente | `carte-titre-texte` | 3 | « ★★★★★5,0/5 sur Google Saint-ApollinaireEntreprise régionale basée en B » |
| type | `carte-titre-texte` | 5 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-sombre` |
| absente | `tarif` | 9 | « Tarif horaire de base 27 € HT/h Régulier ou ponctuel · devis gratuit s » |
| absente | `carte-titre` | 11 | « ★★★★★5,0/5 Google » |
| surplus | `chip` | 1 | « ★★★★★5,0/5 sur Google » |
| surplus | `tarif` | 1 | « 27 € HT/h tarif unique, régulier ou ponctuel » |
| surplus | `carte-icone` | 1 | «  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis ✓Devis gratuit sous 24  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis » |
| surplus | `carte-titre-texte` | 3 | « Saint-Apollinaire Entreprise régionale basée en BFC Interlocutrice ide » |
| surplus | `carte-sombre` | 5 | « Copropriétés & parties communes Halls, cages d'escalier, locaux commun » |
| surplus | `carte-sombre` | 5 | « Locations meublées & hébergements Remise en état entre deux occupants » |
| surplus | `carte-sombre` | 5 | « Ponctuel & remise en état Après travaux, grand nettoyage, fin de bail » |
| surplus | `tarif` | 9 | « Tarif unique 27 € HT/h Régulier ou ponctuel · devis gratuit sous 24 h. » |
| surplus | `micro-carte` | 11 | «  » |
| surplus | `carte-titre` | 11 | « ★★★★★5,0/5 sur Google » |


### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

**1440 px** — bandes 19 → 19 · cartes 53 → 54 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `chip` | 2 | « ★★★★★5,0/5sur Google » — 1 colonnes attendues, 2 rendues |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « Bureaux & open-spaces » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Surfaces de vente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Cabinets & salles d'attente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Parties communes » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Meublés & hébergements » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Sanitaires & cuisines » — rendue en `carte-titre` |
| absente | `temoignage` | 14 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| surplus | `carte-titre-texte` | 6 | « Prestataire de nettoyage ou recrutement direct ? C'est la première que » |
| surplus | `tarif` | 8 | « Régulier ou ponctuel, tâches, fréquences et horaires Entretien régulie » |
| surplus | `carte-titre-texte` | 9 | « Comment choisir la bonne fréquence La fréquence dépend moins de la sur » |
| surplus | `carte-titre-texte` | 12 | « Comment se construit un cahier des charges 01 Inventaire des espaces C » |
| surplus | `carte-titre-texte` | 15 | « Trois situations concrètes Exemples représentatifs des demandes que no » |

**375 px** — bandes 19 → 19 · cartes 53 → 51 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « Bureaux & open-spaces » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Surfaces de vente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Cabinets & salles d'attente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Parties communes » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Meublés & hébergements » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Sanitaires & cuisines » — rendue en `carte-titre` |
| absente | `temoignage` | 14 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| absente | `carte-titre` | 17 | « Combien coûte le nettoyage de bureaux ?→ » |
| surplus | `carte-titre-texte` | 6 | « Prestataire de nettoyage ou recrutement direct ? C'est la première que » |
| surplus | `carte-titre-texte` | 9 | « Comment choisir la bonne fréquence La fréquence dépend moins de la sur » |
| surplus | `carte-titre-texte` | 15 | « Trois situations concrètes Exemples représentatifs des demandes que no » |


### `#/nos-prestations` → `/prestations/`

**1440 px** — bandes 6 → 6 · cartes 12 → 13 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 6 → 6 · cartes 12 → 13 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/service/bureaux` → `/prestations/bureaux/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 0 anomalie(s)

**375 px** — bandes 14 → 14 · cartes 22 → 22 · 0 anomalie(s)


### `#/service/commerces` → `/prestations/commerces/`

**1440 px** — bandes 14 → 14 · cartes 20 → 20 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `tarif` | 10 | « Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion » — 1 colonnes attendues, 2 rendues |

**375 px** — bandes 14 → 14 · cartes 21 → 21 · 0 anomalie(s)


### `#/service/cabinets` → `/prestations/cabinets/`

**1440 px** — bandes 15 → 15 · cartes 28 → 28 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre-texte` | 4 | « Cette prestation est un entretien courant de locaux professi » — rendue en `micro-carte` |
| colonnes | `tarif` | 11 | « Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion » — 1 colonnes attendues, 2 rendues |

**375 px** — bandes 15 → 15 · cartes 29 → 29 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre-texte` | 4 | « Cette prestation est un entretien courant de locaux professi » — rendue en `micro-carte` |


### `#/service/coproprietes` → `/prestations/coproprietes/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `tarif` | 10 | « Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion » — 1 colonnes attendues, 2 rendues |

**375 px** — bandes 14 → 14 · cartes 22 → 22 · 0 anomalie(s)


### `#/service/meubles` → `/prestations/meubles/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `tarif` | 10 | « Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion » — 1 colonnes attendues, 2 rendues |
| type | `carte-titre` | 13 | « Encore une question sur Locations meublées ? Audrey vous rép » — rendue en `carte-titre-texte` |

**375 px** — bandes 14 → 14 · cartes 22 → 22 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Locations meublées ? Audrey vous rép » — rendue en `carte-titre-texte` |


### `#/service/ponctuel` → `/prestations/ponctuel/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `tarif` | 10 | « Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion » — 1 colonnes attendues, 2 rendues |

**375 px** — bandes 14 → 14 · cartes 22 → 22 · 0 anomalie(s)


### `#/nos-tarifs` → `/tarifs/`

**1440 px** — bandes 13 → 13 · cartes 22 → 21 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `tarif` | 3 | « Tarif horaire de base27 € HT/hIdentique en régulier et en po » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 3 | « Devis sous 24 hGratuit, personnalisé et sans engagement. Aucun simulat » |
| absente | `tarif` | 6 | « Tarif horaireRégulier ou ponctuel27 € HT/h Frais de gestionPlanning, a » |
| colonnes | `carte-titre-texte` | 7 | « Ce qui est inclusMain-d'œuvre de l'intervenant sélectionnéOr » — 2 colonnes attendues, 1 rendues |
| colonnes | `carte-titre-texte` | 7 | « Fourni par le clientProduits d'entretien (généralement)Matér » — 2 colonnes attendues, 1 rendues |
| colonnes | `carte-titre` | 8 | « SurfaceSuperficie et nombre de pièces » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « FréquenceNombre de passages par semaine » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « Type de locauxBureaux, commerce, cabinet, meublé » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « Niveau d'exigenceStandard ou renforcé (hygiène) » — 1 colonnes attendues, 4 rendues |
| surplus | `temoignage` | 11 | « ★★★★★« Un devis clair, sans surprise, et le même tarif horaire annoncé » |

**375 px** — bandes 13 → 13 · cartes 22 → 21 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 3 | « Devis sous 24 hGratuit, personnalisé et sans engagement. Aucun simulat » |
| absente | `tarif` | 6 | « Tarif horaireRégulier ou ponctuel27 € HT/h Frais de gestionPlanning, a » |
| surplus | `temoignage` | 11 | « ★★★★★« Un devis clair, sans surprise, et le même tarif horaire annoncé » |


### `#/zones-intervention` → `/zones-intervention/`

**1440 px** — bandes 13 → 13 · cartes 52 → 49 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-sombre` | 2 | « Vérifier notre intervention dans ma commune » — rendue en `carte-titre` |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « Agglomération dijonnaise : créneaux souples, passages courts » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 5 | « Villes principales de la région : passages regroupés, planni » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Communes plus éloignées : fréquence hebdomadaire ou bimensue » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Interventions ponctuelles : selon disponibilité, avec une da » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Les éventuelles indemnités kilométriques dépendent de l'adre » — rendue en `carte-titre-texte` |
| absente | `carte-sombre` | 6 | « Bourgogne-Franche-ComtéLa page régionale · huit départements couverts  » |
| absente | `micro-carte` | 6 | « Voir la page régionale → » |
| absente | `carte-titre` | 13 | « Vérifier notre intervention dans ma commune » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 13 → 13 · cartes 35 → 49 · 30 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-sombre` | 2 | « Vérifier notre intervention dans ma commune » — rendue en `carte-titre` |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « Agglomération dijonnaise : créneaux souples, passages courts » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 5 | « Villes principales de la région : passages regroupés, planni » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Communes plus éloignées : fréquence hebdomadaire ou bimensue » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Interventions ponctuelles : selon disponibilité, avec une da » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Les éventuelles indemnités kilométriques dépendent de l'adre » — rendue en `carte-titre-texte` |
| absente | `carte-sombre` | 6 | « Bourgogne-Franche-ComtéLa page régionale · huit départements couverts  » |
| absente | `micro-carte` | 6 | « Voir la page régionale → » |
| absente | `carte-titre` | 13 | « Vérifier notre intervention dans ma commune » |
| absente | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `carte-titre` | 8 | « Dijon 21000 » |
| surplus | `carte-titre` | 8 | « Besançon 25000 » |
| surplus | `carte-titre` | 8 | « Dole 39100 » |
| surplus | `carte-titre` | 8 | « Lons-le-Saunier 39000 » |
| surplus | `carte-titre` | 8 | « Nevers 58000 » |
| surplus | `carte-titre` | 8 | « Vesoul 70000 » |
| surplus | `carte-titre` | 8 | « Chalon-sur-Saône 71100 » |
| surplus | `carte-titre` | 8 | « Mâcon 71000 » |
| surplus | `carte-titre` | 8 | « Auxerre 89000 » |
| surplus | `carte-titre` | 8 | « Belfort 90000 » |
| surplus | `carte-titre` | 9 | « Saint-Apollinaire 21850 » |
| surplus | `carte-titre` | 9 | « Chenôve 21300 » |
| surplus | `carte-titre` | 9 | « Quetigny 21800 » |
| surplus | `carte-titre` | 9 | « Talant 21240 » |
| surplus | `carte-titre` | 9 | « Longvic 21600 » |
| surplus | `carte-titre` | 9 | « Fontaine-lès-Dijon 21121 » |
| surplus | `carte-titre` | 9 | « Marsannay-la-Côte 21160 » |
| surplus | `carte-titre` | 9 | « Beaune 21200 » |


### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

**1440 px** — bandes 12 → 12 · cartes 51 → 56 · 22 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « TPE et PME : bureaux, open-spaces, salles de réunion, locaux » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Commerces et boutiques : surfaces de vente, réserves, sanita » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Professions libérales et cabinets : cabinets médicaux couran » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 5 | « Syndics et conseils syndicaux : halls, cages d'escalier, asc » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Propriétaires bailleurs et gestionnaires : locations meublée » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Associations, agences, coworkings et structures de formation » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Plateaux de bureaux et open-spaces » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Locaux d'accueil et salles d'attente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Surfaces de vente et réserves » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Cabinets paramédicaux et dentaires courants » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Parties communes d'immeubles » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Locations meublées et logements de courte durée » — rendue en `carte-titre` |
| colonnes | `tarif` | 9 | « Exemple · bureaux réguliers, 12 h/mois333 € HT/mois12 h × 27 » — 3 colonnes attendues, 2 rendues |
| type | `temoignage` | 9 | « ★★★★★« Nous avions besoin d'un prestataire capable de suivre » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `carte-titre` | 8 | « Dijon 21000 » |
| surplus | `carte-titre` | 8 | « Besançon 25000 » |
| surplus | `carte-titre` | 8 | « Dole 39100 » |
| surplus | `carte-titre` | 8 | « Lons-le-Saunier 39000 » |
| surplus | `carte-titre` | 8 | « Nevers 58000 » |
| surplus | `carte-titre` | 8 | « Vesoul 70000 » |

**375 px** — bandes 12 → 12 · cartes 48 → 56 · 26 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| type | `micro-carte` | 5 | « TPE et PME : bureaux, open-spaces, salles de réunion, locaux » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Commerces et boutiques : surfaces de vente, réserves, sanita » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Professions libérales et cabinets : cabinets médicaux couran » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 5 | « Syndics et conseils syndicaux : halls, cages d'escalier, asc » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Propriétaires bailleurs et gestionnaires : locations meublée » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Associations, agences, coworkings et structures de formation » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Plateaux de bureaux et open-spaces » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Locaux d'accueil et salles d'attente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Surfaces de vente et réserves » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Cabinets paramédicaux et dentaires courants » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Parties communes d'immeubles » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Locations meublées et logements de courte durée » — rendue en `carte-titre` |
| type | `temoignage` | 9 | « ★★★★★« Nous avions besoin d'un prestataire capable de suivre » — rendue en `carte-titre-texte` |
| absente | `carte-titre` | 12 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `carte-titre` | 8 | « Dijon 21000 » |
| surplus | `carte-titre` | 8 | « Besançon 25000 » |
| surplus | `carte-titre` | 8 | « Dole 39100 » |
| surplus | `carte-titre` | 8 | « Lons-le-Saunier 39000 » |
| surplus | `carte-titre` | 8 | « Nevers 58000 » |
| surplus | `carte-titre` | 8 | « Vesoul 70000 » |
| surplus | `carte-titre` | 8 | « Chalon-sur-Saône 71100 » |
| surplus | `carte-titre` | 8 | « Mâcon 71000 » |
| surplus | `carte-titre` | 8 | « Auxerre 89000 » |
| surplus | `carte-titre` | 8 | « Belfort 90000 » |


### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

**1440 px** — bandes 11 → 11 · cartes 31 → 30 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Beaune » — 4 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Chevigny-Saint-Sauveur » — 4 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Ahuy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Plombières-lès-Dijon » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Sennecey-lès-Dijon » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Nuits-Saint-Georges » — 3 colonnes attendues, 1 rendues |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Dijon, 12 h/mois333 € HT/moisTrois passages de 1 h » rendue dans « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous cherchions un prestataire capable de passer avan » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 6 | « Daix » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois Exemple non contrac » |

**375 px** — bandes 11 → 11 · cartes 32 → 31 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Plateaux de bureaux et open-spaces » — rendue en `chip` |
| colonnes | `chip` | 6 | « Beaune » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Chevigny-Saint-Sauveur » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Plombières-lès-Dijon » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Sennecey-lès-Dijon » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Nuits-Saint-Georges » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Dijon, 12 h/mois333 € HT/moisTrois passages de 1 h » rendue dans « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 6 | « Daix » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois Exemple non contrac » |


### `#/departement/doubs` → `/zones-intervention/doubs/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « École-Valentin » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Chalezeule » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Thise » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Saône » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Pirey » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Serre-les-Sapins » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Beure » — 2 colonnes attendues, 1 rendues |
| fusionnee | `tarif` | 7 | « Exemple · cabinet à Besançon, 10 h/mois279 € HT/moisDeux passages de 1 » rendue dans « Exemple · cabinet à Besançon, 10 h/mois 279 € HT/m » |
| colonnes | `temoignage` | 7 | « ★★★★★« La salle d'attente et les sanitaires sont repris selo » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet à Besançon, 10 h/mois 279 € HT/mois Exemple non cont » |

**375 px** — bandes 11 → 11 · cartes 32 → 30 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux tertiaires et sièges régionaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces du centre historique » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · cabinet à Besançon, 10 h/mois279 € HT/moisDeux passages de 1 » rendue dans « Exemple · cabinet à Besançon, 10 h/mois 279 € HT/m » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet à Besançon, 10 h/mois 279 € HT/mois Exemple non cont » |


### `#/departement/jura` → `/zones-intervention/jura/`

**1440 px** — bandes 11 → 11 · cartes 33 → 31 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Choisey » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Tavaux » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Damparis » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Foucherans » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Authume » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Perrigny » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Macornay » — 3 colonnes attendues, 2 rendues |
| fusionnee | `tarif` | 7 | « Exemple · commerce à Dole, 16 h/mois441 € HT/moisUn passage d'une heur » rendue dans « Exemple · commerce à Dole, 16 h/mois 441 € HT/mois » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait avant l'ouverture, tous les matins » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce à Dole, 16 h/mois 441 € HT/mois Exemple non contrac » |

**375 px** — bandes 11 → 11 · cartes 34 → 32 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et locaux administratifs » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locations meublées et gîtes urbains » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et espaces de réunion » — rendue en `chip` |
| colonnes | `chip` | 6 | « Foucherans » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Authume » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Perrigny » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Macornay » — 2 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · commerce à Dole, 16 h/mois441 € HT/moisUn passage d'une heur » rendue dans « Exemple · commerce à Dole, 16 h/mois 441 € HT/mois » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce à Dole, 16 h/mois 441 € HT/mois Exemple non contrac » |


### `#/departement/nievre` → `/zones-intervention/nievre/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Varennes-Vauzelles » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Fourchambault » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Marzy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Coulanges-lès-Nevers » — 4 colonnes attendues, 2 rendues |
| fusionnee | `tarif` | 7 | « Exemple · copropriété à Nevers, 8 h/mois225 € HT/moisDeux heures par s » rendue dans « Exemple · copropriété à Nevers, 8 h/mois 225 € HT/ » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le hall et les escaliers sont repris chaque semaine e » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété à Nevers, 8 h/mois 225 € HT/mois Exemple non con » |

**375 px** — bandes 11 → 11 · cartes 32 → 30 · 15 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux rattachés aux zones d'activité » — rendue en `chip` |
| colonnes | `chip` | 6 | « Marzy » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Coulanges-lès-Nevers » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Challuy » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Garchizy » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · copropriété à Nevers, 8 h/mois225 € HT/moisDeux heures par s » rendue dans « Exemple · copropriété à Nevers, 8 h/mois 225 € HT/ » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété à Nevers, 8 h/mois 225 € HT/mois Exemple non con » |


### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 15 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Navenne » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Vaivre-et-Montoille » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Pusey » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Noidans-lès-Vesoul » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Frotey-lès-Vesoul » — 2 colonnes attendues, 1 rendues |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois279 € HT/moisDeux passages de 1 h » rendue dans « Exemple · bureaux à Vesoul, 10 h/mois 279 € HT/moi » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avions besoin d'un passage en dehors des horaire » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois 279 € HT/mois Exemple non contra » |

**375 px** — bandes 11 → 11 · cartes 32 → 30 · 15 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| colonnes | `chip` | 6 | « Navenne » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Vaivre-et-Montoille » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Pusey » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Frotey-lès-Vesoul » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois279 € HT/moisDeux passages de 1 h » rendue dans « Exemple · bureaux à Vesoul, 10 h/mois 279 € HT/moi » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois 279 € HT/mois Exemple non contra » |


### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Saint-Rémy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Champforgeuil » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Saint-Marcel » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Châtenoy-le-Royal » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Sancé » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Charnay-lès-Mâcon » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Crêches-sur-Saône » — 3 colonnes attendues, 1 rendues |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Chalon, 12 h/mois333 € HT/moisTrois passages d'une » rendue dans « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/moi » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avons trois passages par semaine tôt le matin. L » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/mois Exemple non contra » |

**375 px** — bandes 11 → 11 · cartes 33 → 32 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et bureaux d'études » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Chalon, 12 h/mois333 € HT/moisTrois passages d'une » rendue dans « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/moi » |
| type | `carte-titre` | 11 | « Demander un devis en Saône-et-Loire » — rendue en `carte-sombre` |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/mois Exemple non contra » |
| surplus | `micro-carte` | 11 | « Demander un devis en Saône-et-Loire » |


### `#/departement/yonne` → `/zones-intervention/yonne/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Monéteau » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Appoigny » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Perrigny » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Saint-Georges-sur-Baulche » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Chevannes » — 2 colonnes attendues, 1 rendues |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois225 € HT/moisDeux passages d'une  » rendue dans « Exemple · bureaux à Auxerre, 8 h/mois 225 € HT/moi » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nos bureaux administratifs sont entretenus deux fois  » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois 225 € HT/mois Exemple non contra » |

**375 px** — bandes 11 → 11 · cartes 32 → 30 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Espaces d'accueil et de dégustation » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois225 € HT/moisDeux passages d'une  » rendue dans « Exemple · bureaux à Auxerre, 8 h/mois 225 € HT/moi » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois 225 € HT/mois Exemple non contra » |


### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 16 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Valdoie » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Offemont » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Bavilliers » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Danjoutin » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Cravanche » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Essert » — 6 colonnes attendues, 3 rendues |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Belfort, 10 h/mois279 € HT/moisDeux passages de 1  » rendue dans « Exemple · bureaux à Belfort, 10 h/mois 279 € HT/mo » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait en soirée, après le départ des équ » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Belfort, 10 h/mois 279 € HT/mois Exemple non contr » |

**375 px** — bandes 11 → 11 · cartes 32 → 30 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux d'études et d'ingénierie » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| absente | `carte-titre-texte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux à Belfort, 10 h/mois279 € HT/moisDeux passages de 1  » rendue dans « Exemple · bureaux à Belfort, 10 h/mois 279 € HT/mo » |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux à Belfort, 10 h/mois 279 € HT/mois Exemple non contr » |


### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| colonnes | `tarif` | 7 | « Exemple · bureaux en secteur tertiaire dijonnais, 12 h/mois3 » — 3 colonnes attendues, 1 rendues |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous ouvrons à 9 h et le passage est fait avant : bur » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Chevigny-Saint-Sauveur » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Sennecey-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 9 | « Daix » |

**375 px** — bandes 13 → 13 · cartes 50 → 49 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Chevigny-Saint-Sauveur » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Ahuy » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 9 | « Daix » |


### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

**1440 px** — bandes 13 → 13 · cartes 51 → 49 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · cabinet paramédical, 10 h/mois279 € HT/moisDeux passages de  » rendue dans « Exemple · cabinet paramédical, 10 h/mois 279 € HT/ » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait après le dernier patient et la sal » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet paramédical, 10 h/mois 279 € HT/mois Exemple non con » |

**375 px** — bandes 13 → 13 · cartes 52 → 50 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux tertiaires et sièges régionaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces du centre historique » — rendue en `chip` |
| type | `micro-carte` | 5 | « Syndics et copropriétés de l'agglomération » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · cabinet paramédical, 10 h/mois279 € HT/moisDeux passages de  » rendue dans « Exemple · cabinet paramédical, 10 h/mois 279 € HT/ » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet paramédical, 10 h/mois 279 € HT/mois Exemple non con » |


### `#/ville/dole` → `/zones-intervention/jura/dole/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · commerce en centre-ville, 16 h/mois441 € HT/moisUn passage d » rendue dans « Exemple · commerce en centre-ville, 16 h/mois 441  » |
| colonnes | `temoignage` | 7 | « ★★★★★« J'ouvre à 9 h 30 et tout est fait avant mon arrivée,  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce en centre-ville, 16 h/mois 441 € HT/mois Exemple no » |

**375 px** — bandes 13 → 13 · cartes 51 → 49 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et locaux administratifs » — rendue en `chip` |
| type | `micro-carte` | 5 | « Syndics et petites copropriétés » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locations meublées et gîtes urbains » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · commerce en centre-ville, 16 h/mois441 € HT/moisUn passage d » rendue dans « Exemple · commerce en centre-ville, 16 h/mois 441  » |
| type | `micro-carte` | 8 | « Bureaux : 1 à 3 passages par semaine » — rendue en `chip` |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce en centre-ville, 16 h/mois 441 € HT/mois Exemple no » |


### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · cabinet comptable, 8 h/mois225 € HT/moisDeux heures par sema » rendue dans « Exemple · cabinet comptable, 8 h/mois 225 € HT/moi » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage du vendredi soir nous permet de retrouver  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet comptable, 8 h/mois 225 € HT/mois Exemple non contra » |

**375 px** — bandes 13 → 13 · cartes 50 → 48 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et locaux administratifs » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets paramédicaux courants » — rendue en `chip` |
| type | `micro-carte` | 5 | « Syndics et petites copropriétés » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · cabinet comptable, 8 h/mois225 € HT/moisDeux heures par sema » rendue dans « Exemple · cabinet comptable, 8 h/mois 225 € HT/moi » |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet comptable, 8 h/mois 225 € HT/mois Exemple non contra » |


### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » rendue dans « Exemple · copropriété, 8 h/mois 225 € HT/mois Exem » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avions des retards de passage avec notre ancien  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Varennes-Vauzelles » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Fourchambault » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Marzy » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Challuy » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Garchizy » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Sermoise-sur-Loire » — 3 colonnes attendues, 4 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété, 8 h/mois 225 € HT/mois Exemple non contractuel. » |

**375 px** — bandes 13 → 13 · cartes 51 → 49 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinet : 1 à 2 passages par semaine » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » rendue dans « Exemple · copropriété, 8 h/mois 225 € HT/mois Exem » |
| colonnes | `chip` | 9 | « Marzy » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Coulanges-lès-Nevers » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Challuy » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Sermoise-sur-Loire » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété, 8 h/mois 225 € HT/mois Exemple non contractuel. » |


### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux administratifs, 10 h/mois279 € HT/moisDeux passages  » rendue dans « Exemple · bureaux administratifs, 10 h/mois 279 €  » |
| colonnes | `temoignage` | 7 | « ★★★★★« L'intervention se fait en soirée avec un badge, sans  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux administratifs, 10 h/mois 279 € HT/mois Exemple non  » |

**375 px** — bandes 13 → 13 · cartes 50 → 48 · 17 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux administratifs, 10 h/mois279 € HT/moisDeux passages  » rendue dans « Exemple · bureaux administratifs, 10 h/mois 279 €  » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Navenne » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Vaivre-et-Montoille » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Pusey » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Frotey-lès-Vesoul » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux administratifs, 10 h/mois 279 € HT/mois Exemple non  » |


### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

**1440 px** — bandes 13 → 13 · cartes 48 → 46 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `tarif` | 7 | « Exemple · bureaux, 12 h/mois333 € HT/moisTrois passages d'une heure pa » |
| colonnes | `temoignage` | 7 | « ★★★★★« Trois passages par semaine tôt le matin, avant l'arri » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux, 12 h/mois 333 € HT/mois Exemple non contractuel. » |

**375 px** — bandes 13 → 13 · cartes 51 → 49 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Sièges d'entreprise et bureaux de services » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Syndics et copropriétés urbaines » — rendue en `chip` |
| absente | `tarif` | 7 | « Exemple · bureaux, 12 h/mois333 € HT/moisTrois passages d'une heure pa » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Chalon-sur-Saône » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux, 12 h/mois 333 € HT/mois Exemple non contractuel. » |


### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · cabinet de conseil, 8 h/mois225 € HT/moisDeux heures par sem » rendue dans « Exemple · cabinet de conseil, 8 h/mois 225 € HT/mo » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous recevons des clients le lundi matin : la salle d » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet de conseil, 8 h/mois 225 € HT/mois Exemple non contr » |

**375 px** — bandes 13 → 13 · cartes 50 → 48 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux rattachés aux zones logistiques » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · cabinet de conseil, 8 h/mois225 € HT/moisDeux heures par sem » rendue dans « Exemple · cabinet de conseil, 8 h/mois 225 € HT/mo » |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet de conseil, 8 h/mois 225 € HT/mois Exemple non contr » |


### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux de PME, 8 h/mois225 € HT/moisDeux passages d'une heu » rendue dans « Exemple · bureaux de PME, 8 h/mois 225 € HT/mois E » |
| colonnes | `temoignage` | 7 | « ★★★★★« Deux passages par semaine après la fermeture, sans qu » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux de PME, 8 h/mois 225 € HT/mois Exemple non contractu » |

**375 px** — bandes 13 → 13 · cartes 51 → 49 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux de PME, 8 h/mois225 € HT/moisDeux passages d'une heu » rendue dans « Exemple · bureaux de PME, 8 h/mois 225 € HT/mois E » |
| type | `micro-carte` | 8 | « Cabinet : 1 à 2 passages par semaine » — rendue en `chip` |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux de PME, 8 h/mois 225 € HT/mois Exemple non contractu » |


### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois279 € HT/moisDeux passages de » rendue dans « Exemple · bureaux d'ingénierie, 10 h/mois 279 € HT » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage a lieu après le départ des équipes techniq » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Valdoie » — 6 colonnes attendues, 5 rendues |
| colonnes | `chip` | 9 | « Offemont » — 6 colonnes attendues, 5 rendues |
| colonnes | `chip` | 9 | « Bavilliers » — 6 colonnes attendues, 5 rendues |
| colonnes | `chip` | 9 | « Danjoutin » — 6 colonnes attendues, 5 rendues |
| colonnes | `chip` | 9 | « Cravanche » — 6 colonnes attendues, 5 rendues |
| colonnes | `chip` | 9 | « Essert » — 6 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Pérouse » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois 279 € HT/mois Exemple non co » |

**375 px** — bandes 13 → 13 · cartes 51 → 49 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux d'études et d'ingénierie » — rendue en `chip` |
| type | `micro-carte` | 5 | « PME de services et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces indépendants du centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois279 € HT/moisDeux passages de » rendue dans « Exemple · bureaux d'ingénierie, 10 h/mois 279 € HT » |
| type | `micro-carte` | 8 | « Cabinet : 1 à 2 passages par semaine » — rendue en `chip` |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois 279 € HT/mois Exemple non co » |


### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

**1440 px** — bandes 13 → 13 · cartes 44 → 42 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux en zone d'activité, 12 h/mois 33 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous sommes suivis depuis deux ans, avec le même crén » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Bressey-sur-Tille » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Varois-et-Chaignot » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Norges-la-Ville » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |

**375 px** — bandes 13 → 13 · cartes 47 → 45 · 17 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces et services de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Associations et locaux de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux en zone d'activité, 12 h/mois 33 » |
| type | `micro-carte` | 8 | « Prestations courtes possibles (1 h ou 2 h) » — rendue en `chip` |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Norges-la-Ville » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Saint-Apollinaire » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |


### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

**1440 px** — bandes 13 → 13 · cartes 41 → 39 · 8 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » rendue dans « Exemple · copropriété, 8 h/mois 225 € HT/mois Exem » |
| colonnes | `temoignage` | 7 | « ★★★★★« L'entretien de nos parties communes est régulier et l » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 4 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété, 8 h/mois 225 € HT/mois Exemple non contractuel. » |

**375 px** — bandes 13 → 13 · cartes 42 → 40 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces et services de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de PME et locaux administratifs » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » rendue dans « Exemple · copropriété, 8 h/mois 225 € HT/mois Exem » |
| type | `micro-carte` | 8 | « Bureaux : 1 à 3 passages par semaine » — rendue en `chip` |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · copropriété, 8 h/mois 225 € HT/mois Exemple non contractuel. » |


### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

**1440 px** — bandes 13 → 13 · cartes 37 → 35 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `tarif` | 7 | « Exemple · commerce, 20 h/mois549 € HT/moisUn passage d'une heure avant » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage a lieu avant l'ouverture, tous les jours t » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Centre » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Quartiers résidentiels » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Zones d'activité » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Pôle commercial » — 4 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Chevigny-Saint-Sauveur » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Sennecey-lès-Dijon » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Bretenière » — 1 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce, 20 h/mois 549 € HT/mois Exemple non contractuel. » |

**375 px** — bandes 13 → 13 · cartes 38 → 38 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| absente | `tarif` | 7 | « Exemple · commerce, 20 h/mois549 € HT/moisUn passage d'une heure avant » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Pôle commercial » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `carte-sombre` | 2 | « Demander un devis à Quetigny » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce, 20 h/mois 549 € HT/mois Exemple non contractuel. » |
| surplus | `micro-carte` | 13 | « Demander un devis à Quetigny » |


### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

**1440 px** — bandes 13 → 13 · cartes 41 → 40 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `tarif` | 7 | « Exemple · résidence, 6 h/mois171 € HT/moisUn passage de 1 h 30 par sem » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le hall et l'ascenseur sont repris chaque semaine, à  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Plombières-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · résidence, 6 h/mois 171 € HT/mois Exemple non contractuel. » |
| surplus | `chip` | 9 | « Daix » |

**375 px** — bandes 13 → 13 · cartes 42 → 41 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de petites structures » — rendue en `chip` |
| absente | `tarif` | 7 | « Exemple · résidence, 6 h/mois171 € HT/moisUn passage de 1 h 30 par sem » |
| type | `micro-carte` | 8 | « Petit bureau : 1 passage par semaine » — rendue en `chip` |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · résidence, 6 h/mois 171 € HT/mois Exemple non contractuel. » |
| surplus | `chip` | 9 | « Daix » |


### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

**1440 px** — bandes 13 → 13 · cartes 43 → 41 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux de zone d'activité, 12 h/mois 33 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nos bureaux sont entretenus trois matins par semaine  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ouges » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Fénay » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 5 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |

**375 px** — bandes 13 → 13 · cartes 44 → 42 · 19 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux administratifs de sites d'activité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces et services de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux de zone d'activité, 12 h/mois 33 » |
| type | `micro-carte` | 8 | « Cabinet : 1 à 2 passages par semaine » — rendue en `chip` |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ouges » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Fénay » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 1 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |


### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

**1440 px** — bandes 13 → 13 · cartes 43 → 42 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · cabinet paramédical, 8 h/mois225 € HT/moisDeux passages d'un » rendue dans « Exemple · cabinet paramédical, 8 h/mois 225 € HT/m » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait après la fermeture, deux fois par  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ahuy » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Hauteville-lès-Dijon » — 5 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet paramédical, 8 h/mois 225 € HT/mois Exemple non cont » |
| surplus | `chip` | 9 | « Daix » |

**375 px** — bandes 13 → 13 · cartes 46 → 45 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces et services de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · cabinet paramédical, 8 h/mois225 € HT/moisDeux passages d'un » rendue dans « Exemple · cabinet paramédical, 8 h/mois 225 € HT/m » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ahuy » — 4 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Fontaine-lès-Dijon » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · cabinet paramédical, 8 h/mois 225 € HT/mois Exemple non cont » |
| surplus | `chip` | 9 | « Daix » |


### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

**1440 px** — bandes 13 → 13 · cartes 36 → 34 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `tarif` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois279 € HT/moisDeux pass » rendue dans « Exemple · espace d'accueil et bureaux, 10 h/mois 2 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous recevons des visiteurs plusieurs jours par semai » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Couchey » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois 279 € HT/mois Exemple » |

**375 px** — bandes 13 → 13 · cartes 39 → 37 · 16 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Bureaux de petites structures » — rendue en `chip` |
| type | `micro-carte` | 5 | « Commerces et services de proximité » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois279 € HT/moisDeux pass » rendue dans « Exemple · espace d'accueil et bureaux, 10 h/mois 2 » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Commerces de proximité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Couchey » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Marsannay-la-Côte » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois 279 € HT/mois Exemple » |


### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

**1440 px** — bandes 13 → 13 · cartes 41 → 39 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · commerce intra-muros, 16 h/mois441 € HT/moisUn passage d'une » rendue dans « Exemple · commerce intra-muros, 16 h/mois 441 € HT » |
| colonnes | `temoignage` | 7 | « ★★★★★« En haute saison, le passage avant ouverture fait une  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce intra-muros, 16 h/mois 441 € HT/mois Exemple non co » |

**375 px** — bandes 13 → 13 · cartes 42 → 40 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| fusionnee | `tarif` | 7 | « Exemple · commerce intra-muros, 16 h/mois441 € HT/moisUn passage d'une » rendue dans « Exemple · commerce intra-muros, 16 h/mois 441 € HT » |
| colonnes | `chip` | 9 | « Zones d'activité » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Secteurs commerçants » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Chorey-les-Beaune » — 2 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Savigny-lès-Beaune » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `tarif` | 7 | « Exemple · commerce intra-muros, 16 h/mois 441 € HT/mois Exemple non co » |


### `#/conseils` → `/conseils/`

**1440 px** — bandes 7 → 7 · cartes 11 → 14 · 5 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-image` | 4 | « À la une · Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quo » |
| surplus | `carte-image` | 4 | « Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quotidien, plu » |
| surplus | `chip` | 4 | « Bureaux » |
| surplus | `chip` | 5 | « Tarifs » |
| surplus | `chip` | 5 | « Organisation » |

**375 px** — bandes 7 → 7 · cartes 11 → 14 · 5 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-image` | 4 | « À la une · Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quo » |
| surplus | `carte-image` | 4 | « Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quotidien, plu » |
| surplus | `chip` | 4 | « Bureaux » |
| surplus | `chip` | 5 | « Tarifs » |
| surplus | `chip` | 5 | « Organisation » |


### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

**1440 px** — bandes 9 → 9 · cartes 9 → 8 · 8 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Plus de 15 postes ou forte fréquentation : passage quotidien recomman » |
| absente | `micro-carte` | 5 | « ▪5 à 15 postes, activité courante : 2 à 3 passages par semaine » |
| absente | `micro-carte` | 5 | « ▪Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadair » |
| absente | `micro-carte` | 5 | « ▪Salle de réunion utilisée en continu : remise en état après chaque us » |
| surplus | `chip` | 2 | « Bureaux » |
| surplus | `micro-carte` | 6 | « Sous-estimer la fréquence nécessaire pour des sanitaires très fréquent » |
| surplus | `micro-carte` | 6 | « Demander un passage quotidien par habitude, sans effectif réel qui le  » |
| surplus | `micro-carte` | 6 | « Ne jamais réévaluer la fréquence après un changement d'effectif ou d'o » |

**375 px** — bandes 9 → 9 · cartes 9 → 8 · 8 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Plus de 15 postes ou forte fréquentation : passage quotidien recomman » |
| absente | `micro-carte` | 5 | « ▪5 à 15 postes, activité courante : 2 à 3 passages par semaine » |
| absente | `micro-carte` | 5 | « ▪Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadair » |
| absente | `micro-carte` | 5 | « ▪Salle de réunion utilisée en continu : remise en état après chaque us » |
| surplus | `chip` | 2 | « Bureaux » |
| surplus | `micro-carte` | 6 | « Sous-estimer la fréquence nécessaire pour des sanitaires très fréquent » |
| surplus | `micro-carte` | 6 | « Demander un passage quotidien par habitude, sans effectif réel qui le  » |
| surplus | `micro-carte` | 6 | « Ne jamais réévaluer la fréquence après un changement d'effectif ou d'o » |


### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

**1440 px** — bandes 9 → 9 · cartes 5 → 7 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `micro-carte` | 6 | « Comparer des prix au m² entre prestataires sans vérifier le volume hor » |
| surplus | `micro-carte` | 6 | « Choisir uniquement sur le prix affiché, sans vérifier ce qui est inclu » |
| surplus | `micro-carte` | 6 | « Ignorer les frais de mise en place et découvrir un premier mois plus é » |

**375 px** — bandes 9 → 9 · cartes 5 → 7 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `micro-carte` | 6 | « Comparer des prix au m² entre prestataires sans vérifier le volume hor » |
| surplus | `micro-carte` | 6 | « Choisir uniquement sur le prix affiché, sans vérifier ce qui est inclu » |
| surplus | `micro-carte` | 6 | « Ignorer les frais de mise en place et découvrir un premier mois plus é » |


### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

**1440 px** — bandes 9 → 9 · cartes 11 → 8 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Postes de travail et open-spaces » |
| absente | `micro-carte` | 5 | « ▪Salles de réunion » |
| absente | `micro-carte` | 5 | « ▪Accueil et zones de circulation » |
| absente | `micro-carte` | 5 | « ▪Sanitaires (nombre et emplacement) » |
| absente | `micro-carte` | 5 | « ▪Cuisine ou salle de pause » |
| fusionnee | `micro-carte` | 5 | « ▪Zones sensibles à exclure (salle serveur, archives, coffre) » rendue dans « Oublier de mentionner les zones sensibles à exclur » |
| surplus | `chip` | 2 | « Organisation » |
| surplus | `micro-carte` | 6 | « Rester trop vague (« nettoyer les bureaux ») sans détailler les tâches » |
| surplus | `micro-carte` | 6 | « Oublier de mentionner les zones sensibles à exclure (salle serveur, ar » |
| surplus | `micro-carte` | 6 | « Ne jamais mettre à jour le document après un changement d'organisation » |

**375 px** — bandes 9 → 9 · cartes 11 → 8 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Postes de travail et open-spaces » |
| absente | `micro-carte` | 5 | « ▪Salles de réunion » |
| absente | `micro-carte` | 5 | « ▪Accueil et zones de circulation » |
| absente | `micro-carte` | 5 | « ▪Sanitaires (nombre et emplacement) » |
| absente | `micro-carte` | 5 | « ▪Cuisine ou salle de pause » |
| fusionnee | `micro-carte` | 5 | « ▪Zones sensibles à exclure (salle serveur, archives, coffre) » rendue dans « Oublier de mentionner les zones sensibles à exclur » |
| surplus | `chip` | 2 | « Organisation » |
| surplus | `micro-carte` | 6 | « Rester trop vague (« nettoyer les bureaux ») sans détailler les tâches » |
| surplus | `micro-carte` | 6 | « Oublier de mentionner les zones sensibles à exclure (salle serveur, ar » |
| surplus | `micro-carte` | 6 | « Ne jamais mettre à jour le document après un changement d'organisation » |


### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

**1440 px** — bandes 8 → 8 · cartes 12 → 13 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 5,0/5sur Google » — rendue en `chip` |
| type | `etape` | 4 | « 8départements » — rendue en `carte-titre` |
| surplus | `carte-titre` | 4 | « 5,0/5 sur Google » |

**375 px** — bandes 8 → 8 · cartes 12 → 13 · 5 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 5,0/5sur Google » — rendue en `chip` |
| colonnes | `carte-titre` | 4 | « 24 hdevis transmis » — 2 colonnes attendues, 1 rendues |
| type | `etape` | 4 | « 8départements » — rendue en `carte-titre` |
| colonnes | `tarif` | 4 | « 27 €HT/h, transparent » — 2 colonnes attendues, 1 rendues |
| surplus | `carte-titre` | 4 | « 5,0/5 sur Google » |


### `#/notre-fonctionnement` → `/notre-fonctionnement/`

**1440 px** — bandes 5 → 5 · cartes 9 → 13 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `etape` | 3 | « 01Prise de contactVous nous décrivez vos locaux (surface, ty » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 02Analyse du besoinNous étudions le volume d'heures nécessai » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 03Devis sous 24 hVous recevez une proposition claire et chif » — rendue en `tarif` |
| type | `etape` | 3 | « 04Sélection & mise en placeNous sélectionnons l'intervenant  » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 05Suivi & liaisonUn cahier de liaison reste sur place à chaq » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `carte-titre-texte` | 4 | « Les informations dont nous avons besoin Si vous découvrez le sujet, co » |
| surplus | `carte-titre-texte` | 4 | « Transmission des consignes et premier passage Une fois le devis accept » |
| surplus | `carte-titre-texte` | 4 | « Modifier, suspendre ou arrêter Modifier la prestation Un ajustement de » |

**375 px** — bandes 5 → 5 · cartes 9 → 13 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `etape` | 3 | « 01Prise de contactVous nous décrivez vos locaux (surface, ty » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 02Analyse du besoinNous étudions le volume d'heures nécessai » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 03Devis sous 24 hVous recevez une proposition claire et chif » — rendue en `tarif` |
| type | `etape` | 3 | « 04Sélection & mise en placeNous sélectionnons l'intervenant  » — rendue en `carte-titre-texte` |
| type | `etape` | 3 | « 05Suivi & liaisonUn cahier de liaison reste sur place à chaq » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `carte-titre-texte` | 4 | « Les informations dont nous avons besoin Si vous découvrez le sujet, co » |
| surplus | `carte-titre-texte` | 4 | « Transmission des consignes et premier passage Une fois le devis accept » |
| surplus | `carte-titre-texte` | 4 | « Modifier, suspendre ou arrêter Modifier la prestation Un ajustement de » |


### `#/avis-clients` → `/avis-clients/`

**1440 px** — bandes 7 → 7 · cartes 14 → 13 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre` | 3 | « 5,0/5★★★★★Sur Google · 47 avis clientsDemander mon devis » |
| absente | `temoignage` | 4 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| type | `temoignage` | 5 | « ★★★★★Google« Même intervenante chaque semaine dans nos burea » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Devis clair reçu le lendemain, sans surprise. L » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Nettoyage de la boutique avant l'ouverture, vit » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Pour nos copropriétés, le suivi est réel : hall » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remises en état entre deux locataires impeccabl » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remise en état ponctuelle après travaux, devis  » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 7 → 7 · cartes 14 → 13 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre` | 3 | « 5,0/5★★★★★Sur Google · 47 avis clientsDemander mon devis » |
| absente | `temoignage` | 4 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| type | `temoignage` | 5 | « ★★★★★Google« Même intervenante chaque semaine dans nos burea » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Devis clair reçu le lendemain, sans surprise. L » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Nettoyage de la boutique avant l'ouverture, vit » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Pour nos copropriétés, le suivi est réel : hall » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remises en état entre deux locataires impeccabl » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remise en état ponctuelle après travaux, devis  » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/a-propos` → `/a-propos/`

**1440 px** — bandes 6 → 6 · cartes 1 → 1 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 6 → 6 · cartes 1 → 1 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/recrutement` → `/recrutement/`

**1440 px** — bandes 5 → 5 · cartes 6 → 5 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 4 | « Les étapes de candidature 01Vous envoyez votre candidature et vos disp » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 5 → 5 · cartes 6 → 5 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 4 | « Les étapes de candidature 01Vous envoyez votre candidature et vos disp » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/demande-de-devis` → `/demande-de-devis/`

**1440 px** — bandes 1 → 2 · cartes 5 → 4 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 1 | « Google★★★★★5,0/547 avis » |

**375 px** — bandes 1 → 4 · cartes 5 → 4 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 1 | « Google★★★★★5,0/547 avis » |


### `#/contact` → `/contact/`

**1440 px** — bandes 4 → 4 · cartes 7 → 7 · 6 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-icone` | 4 | « AudreyVotre interlocutrice, du devis au suivi » |
| fusionnee | `carte-titre` | 4 | « 🕑Horaires de contactDu lundi au vendredi · à confirmer · réponse sous » rendue dans « 🕑 Horaires de contact Du lundi au vendredi · répo » |
| absente | `tarif` | 4 | « ★★★★★5,0/527 € HT/h » |
| surplus | `carte-titre` | 3 | « J’ai une question Formulaire court, réponse par e-mail ou téléphone. » |
| surplus | `carte-titre` | 4 | « 🕑 Horaires de contact Du lundi au vendredi · réponse sous 24 h » |
| surplus | `tarif` | 4 | « ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région » |

**375 px** — bandes 4 → 4 · cartes 7 → 7 · 6 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-icone` | 4 | « AudreyVotre interlocutrice, du devis au suivi » |
| fusionnee | `carte-titre` | 4 | « 🕑Horaires de contactDu lundi au vendredi · à confirmer · réponse sous » rendue dans « 🕑 Horaires de contact Du lundi au vendredi · répo » |
| absente | `tarif` | 4 | « ★★★★★5,0/527 € HT/h » |
| surplus | `carte-titre` | 3 | « J’ai une question Formulaire court, réponse par e-mail ou téléphone. » |
| surplus | `carte-titre` | 4 | « 🕑 Horaires de contact Du lundi au vendredi · réponse sous 24 h » |
| surplus | `tarif` | 4 | « ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région » |


### `#/plan-du-site` → `/plan-du-site/`

**1440 px** — bandes 3 → 3 · cartes 0 → 0 · 0 anomalie(s)

**375 px** — bandes 3 → 3 · cartes 0 → 0 · 0 anomalie(s)


### `#/mentions-legales` → `/mentions-legales/`

**1440 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : forme juridique, capital, SIREN/S » |

**375 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : forme juridique, capital, SIREN/S » |


### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

**1440 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : identité du responsable de traite » |

**375 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : identité du responsable de traite » |


### `#/gestion-des-cookies` → `/gestion-des-cookies/`

**1440 px** — bandes 3 → 3 · cartes 1 → 1 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : la liste définitive dépend des ou » |
| surplus | `carte-titre-texte` | 3 | « Aucun cookie de mesure d'audience ni de traçage publicitaire À ce jour » |

**375 px** — bandes 3 → 3 · cartes 1 → 1 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : la liste définitive dépend des ou » |
| surplus | `carte-titre-texte` | 3 | « Aucun cookie de mesure d'audience ni de traçage publicitaire À ce jour » |


