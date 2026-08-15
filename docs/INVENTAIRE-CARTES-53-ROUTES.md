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

**53 routes × 2 largeurs · 263 anomalie(s), dont 101 grave(s)** (carte absente ou fusionnée).

## Synthèse

| Route | Cartes 1440 px | Cartes 375 px | Anomalies 1440 px | Anomalies 375 px |
|---|---|---|---|---|
| `#/` | 27 → 32 (+5) | 29 → 32 (+3) | ❌ 17 (3) | ❌ 14 (3) |
| `#/nettoyage-professionnel` | 51 → 49 (-2) | 51 → 48 (-3) | ❌ 9 (2) | ❌ 9 (3) |
| `#/nos-prestations` | 12 → 13 (+1) | 12 → 13 (+1) | ⚠️ 1 | ⚠️ 1 |
| `#/service/bureaux` | 21 → 21 | 22 → 22 | ✅ | ✅ |
| `#/service/commerces` | 20 → 20 | 21 → 21 | ⚠️ 1 | ✅ |
| `#/service/cabinets` | 28 → 28 | 29 → 29 | ⚠️ 2 | ⚠️ 1 |
| `#/service/coproprietes` | 21 → 21 | 22 → 22 | ⚠️ 1 | ✅ |
| `#/service/meubles` | 21 → 21 | 22 → 22 | ⚠️ 2 | ⚠️ 1 |
| `#/service/ponctuel` | 21 → 21 | 22 → 22 | ⚠️ 1 | ✅ |
| `#/nos-tarifs` | 22 → 22 | 22 → 22 | ❌ 2 (1) | ❌ 2 (1) |
| `#/zones-intervention` | 52 → 49 (-3) | 35 → 31 (-4) | ❌ 11 (4) | ❌ 12 (5) |
| `#/bourgogne-franche-comte` | 50 → 50 | 47 → 46 (-1) | ❌ 16 (1) | ❌ 16 (2) |
| `#/departement/cote-dor` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/departement/doubs` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/departement/jura` | 33 → 33 | 34 → 34 | ✅ | ⚠️ 1 |
| `#/departement/nievre` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/departement/haute-saone` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/departement/saone-et-loire` | 31 → 31 | 33 → 34 (+1) | ✅ | ⚠️ 3 |
| `#/departement/yonne` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/departement/territoire-de-belfort` | 31 → 31 | 32 → 32 | ✅ | ⚠️ 1 |
| `#/ville/dijon` | 49 → 48 (-1) | 50 → 49 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/besancon` | 51 → 50 (-1) | 52 → 51 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/dole` | 50 → 49 (-1) | 51 → 50 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/lons-le-saunier` | 49 → 48 (-1) | 50 → 49 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/nevers` | 50 → 49 (-1) | 51 → 50 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/vesoul` | 49 → 48 (-1) | 50 → 49 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/chalon-sur-saone` | 48 → 47 (-1) | 51 → 50 (-1) | ❌ 1 (1) | ❌ 3 (1) |
| `#/ville/macon` | 49 → 48 (-1) | 50 → 49 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/auxerre` | 50 → 49 (-1) | 51 → 50 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/belfort` | 50 → 49 (-1) | 51 → 50 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/saint-apollinaire` | 44 → 43 (-1) | 47 → 46 (-1) | ❌ 1 (1) | ❌ 3 (1) |
| `#/ville/chenove` | 41 → 40 (-1) | 42 → 41 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/quetigny` | 37 → 36 (-1) | 38 → 37 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/talant` | 41 → 40 (-1) | 42 → 41 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/longvic` | 43 → 42 (-1) | 44 → 43 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/ville/fontaine-les-dijon` | 43 → 42 (-1) | 46 → 45 (-1) | ❌ 1 (1) | ❌ 3 (1) |
| `#/ville/marsannay-la-cote` | 36 → 35 (-1) | 39 → 38 (-1) | ❌ 1 (1) | ❌ 3 (1) |
| `#/ville/beaune` | 41 → 40 (-1) | 42 → 41 (-1) | ❌ 1 (1) | ❌ 2 (1) |
| `#/conseils` | 11 → 11 | 11 → 11 | ⚠️ 1 | ⚠️ 1 |
| `#/article/frequence-bureaux` | 8 → 4 (-4) | 8 → 4 (-4) | ❌ 4 (4) | ❌ 4 (4) |
| `#/article/cout-nettoyage-bureaux` | 4 → 4 | 4 → 4 | ✅ | ✅ |
| `#/article/cahier-des-charges-nettoyage` | 10 → 4 (-6) | 10 → 4 (-6) | ❌ 6 (6) | ❌ 6 (6) |
| `#/pourquoi-top-famille-pro` | 12 → 13 (+1) | 12 → 13 (+1) | ⚠️ 3 | ⚠️ 3 |
| `#/notre-fonctionnement` | 9 → 10 (+1) | 9 → 10 (+1) | ⚠️ 1 | ⚠️ 1 |
| `#/avis-clients` | 14 → 11 (-3) | 14 → 11 (-3) | ❌ 10 (3) | ❌ 10 (3) |
| `#/a-propos` | 0 → 1 (+1) | 0 → 1 (+1) | ⚠️ 1 | ⚠️ 1 |
| `#/recrutement` | 5 → 6 (+1) | 5 → 6 (+1) | ⚠️ 2 | ⚠️ 2 |
| `#/demande-de-devis` | 5 → 3 (-2) | 5 → 3 (-2) | ❌ 2 (2) | ❌ 2 (2) |
| `#/contact` | 8 → 8 | 8 → 8 | ❌ 4 (2) | ❌ 4 (2) |
| `#/plan-du-site` | 0 → 0 | 0 → 0 | ✅ | ✅ |
| `#/mentions-legales` | 1 → 0 (-1) | 1 → 0 (-1) | ❌ 1 (1) | ❌ 1 (1) |
| `#/politique-de-confidentialite` | 1 → 0 (-1) | 1 → 0 (-1) | ❌ 1 (1) | ❌ 1 (1) |
| `#/gestion-des-cookies` | 1 → 1 | 1 → 1 | ❌ 2 (1) | ❌ 2 (1) |

## Routes à corriger en priorité

| Route | Cartes absentes ou fusionnées | Anomalies totales |
|---|---|---|
| `#/article/cahier-des-charges-nettoyage` | 6 | 6 |
| `#/zones-intervention` | 4 | 11 |
| `#/article/frequence-bureaux` | 4 | 4 |
| `#/` | 3 | 17 |
| `#/avis-clients` | 3 | 10 |
| `#/nettoyage-professionnel` | 2 | 9 |
| `#/demande-de-devis` | 2 | 2 |
| `#/contact` | 2 | 4 |
| `#/nos-tarifs` | 1 | 2 |
| `#/bourgogne-franche-comte` | 1 | 16 |
| `#/ville/dijon` | 1 | 1 |
| `#/ville/besancon` | 1 | 1 |
| `#/ville/dole` | 1 | 1 |
| `#/ville/lons-le-saunier` | 1 | 1 |
| `#/ville/nevers` | 1 | 1 |
| `#/ville/vesoul` | 1 | 1 |
| `#/ville/chalon-sur-saone` | 1 | 1 |
| `#/ville/macon` | 1 | 1 |
| `#/ville/auxerre` | 1 | 1 |
| `#/ville/belfort` | 1 | 1 |
| `#/ville/saint-apollinaire` | 1 | 1 |
| `#/ville/chenove` | 1 | 1 |
| `#/ville/quetigny` | 1 | 1 |
| `#/ville/talant` | 1 | 1 |
| `#/ville/longvic` | 1 | 1 |
| `#/ville/fontaine-les-dijon` | 1 | 1 |
| `#/ville/marsannay-la-cote` | 1 | 1 |
| `#/ville/beaune` | 1 | 1 |
| `#/mentions-legales` | 1 | 1 |
| `#/politique-de-confidentialite` | 1 | 1 |
| `#/gestion-des-cookies` | 1 | 2 |

## Archétypes employés par la maquette

| Archétype | Occurrences dans la maquette |
|---|---|
| `carte-titre-texte` | 304 |
| `micro-carte` | 294 |
| `chip` | 247 |
| `faq` | 247 |
| `carte-sombre` | 135 |
| `tarif` | 129 |
| `carte-titre` | 89 |
| `temoignage` | 37 |
| `carte-image` | 16 |
| `etape` | 6 |
| `carte-icone` | 2 |

## Détail par route

### `#/` → `/`

**1440 px** — bandes 13 → 13 · cartes 27 → 32 · 17 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 1 | « ★★★★★ 5,0/5 sur Google Voir les avis » — rendue en `chip` |
| absente | `tarif` | 1 | « ✦27 € HT/hrégulier ou ponctuel » |
| texte | `tarif` | 2 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » → « 27 € HT/h tarif unique, indiqué avant le devis ✓Devis gratuit sous 24  » (56 % de mots communs) |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région » |
| absente | `carte-titre-texte` | 3 | « ★★★★★5,0/5 sur Google Saint-ApollinaireEntreprise régionale basée en B » |
| type | `carte-titre-texte` | 5 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-sombre` |
| texte | `tarif` | 9 | « Tarif horaire de base 27 € HT/h Régulier ou ponctuel · devis gratuit s » → « Tarif unique 27 € HT/h Régulier ou ponctuel · devis gratuit sous 24 h. » (78 % de mots communs) |
| colonnes | `carte-image` | 10 | « 21 25 39 58 70 71 89 90 » — 2 colonnes attendues, 1 rendues |
| texte | `carte-titre` | 11 | « ★★★★★5,0/5 Google » → « ★★★★★5,0/5 sur Google » (67 % de mots communs) |
| surplus | `tarif` | 1 | « 27 € HT/h tarif unique, régulier ou ponctuel » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis » |
| surplus | `carte-titre-texte` | 3 | « Saint-Apollinaire Entreprise régionale basée en BFC Interlocutrice ide » |
| surplus | `carte-sombre` | 5 | « Copropriétés & parties communes Halls, cages d'escalier, locaux commun » |
| surplus | `carte-sombre` | 5 | « Locations meublées & hébergements Remise en état entre deux occupants » |
| surplus | `carte-sombre` | 5 | « Ponctuel & remise en état Après travaux, grand nettoyage, fin de bail » |
| surplus | `carte-titre` | 10 | « Yonne 89 » |
| surplus | `carte-titre` | 10 | « Territoire de Belfort 90 » |

**375 px** — bandes 13 → 13 · cartes 29 → 32 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 1 | « ★★★★★ 5,0/5 sur Google Voir les avis » — rendue en `chip` |
| absente | `tarif` | 1 | « ✦27 € HT/hrégulier ou ponctuel » |
| texte | `tarif` | 2 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » → « 27 € HT/h tarif unique, indiqué avant le devis ✓Devis gratuit sous 24  » (56 % de mots communs) |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région » |
| absente | `carte-titre-texte` | 3 | « ★★★★★5,0/5 sur Google Saint-ApollinaireEntreprise régionale basée en B » |
| type | `carte-titre-texte` | 5 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-sombre` |
| texte | `tarif` | 9 | « Tarif horaire de base 27 € HT/h Régulier ou ponctuel · devis gratuit s » → « Tarif unique 27 € HT/h Régulier ou ponctuel · devis gratuit sous 24 h. » (78 % de mots communs) |
| texte | `carte-titre` | 11 | « ★★★★★5,0/5 Google » → « ★★★★★5,0/5 sur Google » (67 % de mots communs) |
| surplus | `tarif` | 1 | « 27 € HT/h tarif unique, régulier ou ponctuel » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis » |
| surplus | `carte-titre-texte` | 3 | « Saint-Apollinaire Entreprise régionale basée en BFC Interlocutrice ide » |
| surplus | `carte-sombre` | 5 | « Copropriétés & parties communes Halls, cages d'escalier, locaux commun » |
| surplus | `carte-sombre` | 5 | « Locations meublées & hébergements Remise en état entre deux occupants » |
| surplus | `carte-sombre` | 5 | « Ponctuel & remise en état Après travaux, grand nettoyage, fin de bail » |


### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

**1440 px** — bandes 19 → 19 · cartes 51 → 49 · 9 anomalie(s)

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

**375 px** — bandes 19 → 19 · cartes 51 → 48 · 9 anomalie(s)

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

**1440 px** — bandes 13 → 13 · cartes 22 → 22 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 6 | « Tarif horaireRégulier ou ponctuel27 € HT/h Frais de gestionPlanning, a » |
| surplus | `temoignage` | 11 | « ★★★★★« Un devis clair, sans surprise, et le même tarif horaire annoncé » |

**375 px** — bandes 13 → 13 · cartes 22 → 22 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
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

**375 px** — bandes 13 → 13 · cartes 35 → 31 · 12 anomalie(s)

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


### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

**1440 px** — bandes 12 → 12 · cartes 50 → 50 · 16 anomalie(s)

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

**375 px** — bandes 12 → 12 · cartes 47 → 46 · 16 anomalie(s)

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


### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/doubs` → `/zones-intervention/doubs/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/jura` → `/zones-intervention/jura/`

**1440 px** — bandes 11 → 11 · cartes 33 → 33 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 34 → 34 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/nievre` → `/zones-intervention/nievre/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 33 → 34 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « Demander un devis en Saône-et-Loire » — rendue en `carte-sombre` |
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |
| surplus | `micro-carte` | 11 | « Demander un devis en Saône-et-Loire » |


### `#/departement/yonne` → `/zones-intervention/yonne/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

**1440 px** — bandes 11 → 11 · cartes 31 → 31 · 0 anomalie(s)

**375 px** — bandes 11 → 11 · cartes 32 → 32 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 11 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 50 → 49 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

**1440 px** — bandes 13 → 13 · cartes 51 → 50 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 52 → 51 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/dole` → `/zones-intervention/jura/dole/`

**1440 px** — bandes 13 → 13 · cartes 50 → 49 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 51 → 50 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 50 → 49 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

**1440 px** — bandes 13 → 13 · cartes 50 → 49 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 51 → 50 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 50 → 49 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

**1440 px** — bandes 13 → 13 · cartes 48 → 47 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 51 → 50 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Chalon-sur-Saône » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 50 → 49 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

**1440 px** — bandes 13 → 13 · cartes 50 → 49 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 51 → 50 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

**1440 px** — bandes 13 → 13 · cartes 50 → 49 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 51 → 50 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

**1440 px** — bandes 13 → 13 · cartes 44 → 43 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 47 → 46 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Saint-Apollinaire » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

**1440 px** — bandes 13 → 13 · cartes 41 → 40 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 42 → 41 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

**1440 px** — bandes 13 → 13 · cartes 37 → 36 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 38 → 37 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

**1440 px** — bandes 13 → 13 · cartes 41 → 40 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 42 → 41 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

**1440 px** — bandes 13 → 13 · cartes 43 → 42 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 44 → 43 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

**1440 px** — bandes 13 → 13 · cartes 43 → 42 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 46 → 45 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Fontaine-lès-Dijon » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

**1440 px** — bandes 13 → 13 · cartes 36 → 35 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 39 → 38 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « Demander un devis à Marsannay-la-Côte » — rendue en `micro-carte` |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

**1440 px** — bandes 13 → 13 · cartes 41 → 40 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |

**375 px** — bandes 13 → 13 · cartes 42 → 41 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| type | `carte-titre` | 13 | « ☎ Échanger avec Audrey · 06 36 17 63 39 » — rendue en `micro-carte` |


### `#/conseils` → `/conseils/`

**1440 px** — bandes 7 → 7 · cartes 11 → 11 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| texte | `carte-image` | 4 | « À la une · Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quo » → « Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quotidien, plu » (80 % de mots communs) |

**375 px** — bandes 7 → 7 · cartes 11 → 11 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| texte | `carte-image` | 4 | « À la une · Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quo » → « Bureaux À quelle fréquence faire nettoyer ses bureaux ? Quotidien, plu » (80 % de mots communs) |


### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

**1440 px** — bandes 9 → 9 · cartes 8 → 4 · 4 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Plus de 15 postes ou forte fréquentation : passage quotidien recomman » |
| absente | `micro-carte` | 5 | « ▪5 à 15 postes, activité courante : 2 à 3 passages par semaine » |
| absente | `micro-carte` | 5 | « ▪Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadair » |
| absente | `micro-carte` | 5 | « ▪Salle de réunion utilisée en continu : remise en état après chaque us » |

**375 px** — bandes 9 → 9 · cartes 8 → 4 · 4 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Plus de 15 postes ou forte fréquentation : passage quotidien recomman » |
| absente | `micro-carte` | 5 | « ▪5 à 15 postes, activité courante : 2 à 3 passages par semaine » |
| absente | `micro-carte` | 5 | « ▪Moins de 5 postes, cabinet ou bureau individuel : passage hebdomadair » |
| absente | `micro-carte` | 5 | « ▪Salle de réunion utilisée en continu : remise en état après chaque us » |


### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

**1440 px** — bandes 9 → 9 · cartes 4 → 4 · 0 anomalie(s)

**375 px** — bandes 9 → 9 · cartes 4 → 4 · 0 anomalie(s)


### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

**1440 px** — bandes 9 → 9 · cartes 10 → 4 · 6 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Postes de travail et open-spaces » |
| absente | `micro-carte` | 5 | « ▪Salles de réunion » |
| absente | `micro-carte` | 5 | « ▪Accueil et zones de circulation » |
| absente | `micro-carte` | 5 | « ▪Sanitaires (nombre et emplacement) » |
| absente | `micro-carte` | 5 | « ▪Cuisine ou salle de pause » |
| absente | `micro-carte` | 5 | « ▪Zones sensibles à exclure (salle serveur, archives, coffre) » |

**375 px** — bandes 9 → 9 · cartes 10 → 4 · 6 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 5 | « ▪Postes de travail et open-spaces » |
| absente | `micro-carte` | 5 | « ▪Salles de réunion » |
| absente | `micro-carte` | 5 | « ▪Accueil et zones de circulation » |
| absente | `micro-carte` | 5 | « ▪Sanitaires (nombre et emplacement) » |
| absente | `micro-carte` | 5 | « ▪Cuisine ou salle de pause » |
| absente | `micro-carte` | 5 | « ▪Zones sensibles à exclure (salle serveur, archives, coffre) » |


### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

**1440 px** — bandes 8 → 8 · cartes 12 → 13 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 5,0/5sur Google » — rendue en `chip` |
| type | `etape` | 4 | « 8départements » — rendue en `carte-titre` |
| surplus | `carte-titre` | 4 | « 5,0/5 sur Google » |

**375 px** — bandes 8 → 8 · cartes 12 → 13 · 3 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 5,0/5sur Google » — rendue en `chip` |
| type | `etape` | 4 | « 8départements » — rendue en `carte-titre` |
| surplus | `carte-titre` | 4 | « 5,0/5 sur Google » |


### `#/notre-fonctionnement` → `/notre-fonctionnement/`

**1440 px** — bandes 5 → 5 · cartes 9 → 10 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 5 → 5 · cartes 9 → 10 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/avis-clients` → `/avis-clients/`

**1440 px** — bandes 7 → 7 · cartes 14 → 11 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 3 | « 5,0/5★★★★★Sur Google · 47 avis clientsDemander mon devis » — rendue en `chip` |
| absente | `temoignage` | 4 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| fusionnee | `carte-sombre` | 4 | « ★★★★★« Devis clair reçu le lendemain, sans surprise. Le respect des co » rendue dans « ★★★★★ Google « Devis clair reçu le lendemain, sans » |
| fusionnee | `carte-sombre` | 4 | « ★★★★★« Nettoyage de la boutique avant l'ouverture, vitrines nickel. Le » rendue dans « ★★★★★ Google « Nettoyage de la boutique avant l'ou » |
| type | `temoignage` | 5 | « ★★★★★Google« Même intervenante chaque semaine dans nos burea » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Devis clair reçu le lendemain, sans surprise. L » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Nettoyage de la boutique avant l'ouverture, vit » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Pour nos copropriétés, le suivi est réel : hall » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remises en état entre deux locataires impeccabl » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remise en état ponctuelle après travaux, devis  » — rendue en `carte-titre-texte` |

**375 px** — bandes 7 → 7 · cartes 14 → 11 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 3 | « 5,0/5★★★★★Sur Google · 47 avis clientsDemander mon devis » — rendue en `chip` |
| absente | `temoignage` | 4 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| fusionnee | `carte-sombre` | 4 | « ★★★★★« Devis clair reçu le lendemain, sans surprise. Le respect des co » rendue dans « ★★★★★ Google « Devis clair reçu le lendemain, sans » |
| fusionnee | `carte-sombre` | 4 | « ★★★★★« Nettoyage de la boutique avant l'ouverture, vitrines nickel. Le » rendue dans « ★★★★★ Google « Nettoyage de la boutique avant l'ou » |
| type | `temoignage` | 5 | « ★★★★★Google« Même intervenante chaque semaine dans nos burea » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Devis clair reçu le lendemain, sans surprise. L » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Nettoyage de la boutique avant l'ouverture, vit » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Pour nos copropriétés, le suivi est réel : hall » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remises en état entre deux locataires impeccabl » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remise en état ponctuelle après travaux, devis  » — rendue en `carte-titre-texte` |


### `#/a-propos` → `/a-propos/`

**1440 px** — bandes 6 → 6 · cartes 0 → 1 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 6 → 6 · cartes 0 → 1 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/recrutement` → `/recrutement/`

**1440 px** — bandes 5 → 5 · cartes 5 → 6 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-sombre` | 4 | « Les étapes de candidature 01Vous envoyez votre candidature e » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |

**375 px** — bandes 5 → 5 · cartes 5 → 6 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-sombre` | 4 | « Les étapes de candidature 01Vous envoyez votre candidature e » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/demande-de-devis` → `/demande-de-devis/`

**1440 px** — bandes 1 → 2 · cartes 5 → 3 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 1 | « ★★★★★5,0/5sur Google » |
| absente | `carte-sombre` | 1 | « Google★★★★★5,0/547 avis » |

**375 px** — bandes 1 → 4 · cartes 5 → 3 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 1 | « ★★★★★5,0/5sur Google » |
| absente | `carte-sombre` | 1 | « Google★★★★★5,0/547 avis » |


### `#/contact` → `/contact/`

**1440 px** — bandes 4 → 4 · cartes 8 → 8 · 4 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 📍ImplantationSaint-Apollinaire (21) · Bourgogne-Franche-Com » — rendue en `carte-titre-texte` |
| fusionnee | `carte-titre` | 4 | « 🕑Horaires de contactDu lundi au vendredi · à confirmer · réponse sous » rendue dans « 🕑 Horaires de contact Du lundi au vendredi · répo » |
| absente | `tarif` | 4 | « ★★★★★5,0/527 € HT/h » |
| surplus | `tarif` | 4 | « ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région » |

**375 px** — bandes 4 → 4 · cartes 8 → 8 · 4 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 4 | « 📍ImplantationSaint-Apollinaire (21) · Bourgogne-Franche-Com » — rendue en `carte-titre-texte` |
| fusionnee | `carte-titre` | 4 | « 🕑Horaires de contactDu lundi au vendredi · à confirmer · réponse sous » rendue dans « 🕑 Horaires de contact Du lundi au vendredi · répo » |
| absente | `tarif` | 4 | « ★★★★★5,0/527 € HT/h » |
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


