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

**53 routes × 1 largeurs · 560 anomalie(s), dont 147 grave(s)** (carte absente ou fusionnée).

## Synthèse

| Route | Cartes 1440 px | Anomalies 1440 px |
|---|---|---|
| `#/` | 27 → 33 (+6) | ❌ 23 (7) |
| `#/nettoyage-professionnel` | 53 → 65 (+12) | ❌ 39 (3) |
| `#/nos-prestations` | 12 → 13 (+1) | ⚠️ 7 |
| `#/service/bureaux` | 21 → 21 | ⚠️ 1 |
| `#/service/commerces` | 20 → 20 | ⚠️ 1 |
| `#/service/cabinets` | 28 → 28 | ⚠️ 2 |
| `#/service/coproprietes` | 21 → 21 | ⚠️ 1 |
| `#/service/meubles` | 21 → 21 | ⚠️ 1 |
| `#/service/ponctuel` | 21 → 21 | ⚠️ 1 |
| `#/nos-tarifs` | 22 → 21 (-1) | ❌ 13 (2) |
| `#/zones-intervention` | 52 → 54 (+2) | ❌ 47 (5) |
| `#/bourgogne-franche-comte` | 51 → 61 (+10) | ❌ 47 (2) |
| `#/departement/cote-dor` | 31 → 30 (-1) | ❌ 14 (4) |
| `#/departement/doubs` | 31 → 29 (-2) | ❌ 14 (4) |
| `#/departement/jura` | 33 → 31 (-2) | ❌ 14 (4) |
| `#/departement/nievre` | 31 → 29 (-2) | ❌ 11 (4) |
| `#/departement/haute-saone` | 31 → 29 (-2) | ❌ 15 (4) |
| `#/departement/saone-et-loire` | 31 → 29 (-2) | ❌ 14 (4) |
| `#/departement/yonne` | 31 → 29 (-2) | ❌ 12 (4) |
| `#/departement/territoire-de-belfort` | 31 → 29 (-2) | ❌ 16 (4) |
| `#/ville/dijon` | 49 → 48 (-1) | ❌ 10 (3) |
| `#/ville/besancon` | 51 → 49 (-2) | ❌ 7 (4) |
| `#/ville/dole` | 50 → 48 (-2) | ❌ 7 (4) |
| `#/ville/lons-le-saunier` | 49 → 47 (-2) | ❌ 7 (4) |
| `#/ville/nevers` | 50 → 48 (-2) | ❌ 13 (4) |
| `#/ville/vesoul` | 49 → 47 (-2) | ❌ 10 (4) |
| `#/ville/chalon-sur-saone` | 48 → 46 (-2) | ❌ 7 (4) |
| `#/ville/macon` | 49 → 47 (-2) | ❌ 7 (4) |
| `#/ville/auxerre` | 50 → 48 (-2) | ❌ 7 (4) |
| `#/ville/belfort` | 50 → 48 (-2) | ❌ 14 (4) |
| `#/ville/saint-apollinaire` | 44 → 42 (-2) | ❌ 11 (4) |
| `#/ville/chenove` | 41 → 39 (-2) | ❌ 8 (4) |
| `#/ville/quetigny` | 37 → 35 (-2) | ❌ 14 (4) |
| `#/ville/talant` | 41 → 40 (-1) | ❌ 9 (4) |
| `#/ville/longvic` | 43 → 41 (-2) | ❌ 13 (4) |
| `#/ville/fontaine-les-dijon` | 43 → 42 (-1) | ❌ 10 (4) |
| `#/ville/marsannay-la-cote` | 36 → 34 (-2) | ❌ 9 (4) |
| `#/ville/beaune` | 41 → 39 (-2) | ❌ 10 (4) |
| `#/conseils` | 11 → 14 (+3) | ❌ 5 (1) |
| `#/article/frequence-bureaux` | 9 → 8 (-1) | ❌ 8 (4) |
| `#/article/cout-nettoyage-bureaux` | 5 → 7 (+2) | ⚠️ 3 |
| `#/article/cahier-des-charges-nettoyage` | 11 → 8 (-3) | ❌ 10 (6) |
| `#/pourquoi-top-famille-pro` | 12 → 19 (+7) | ⚠️ 11 |
| `#/notre-fonctionnement` | 9 → 13 (+4) | ⚠️ 9 |
| `#/avis-clients` | 14 → 20 (+6) | ❌ 18 (2) |
| `#/a-propos` | 1 → 7 (+6) | ⚠️ 7 |
| `#/recrutement` | 6 → 8 (+2) | ❌ 9 (1) |
| `#/demande-de-devis` | 5 → 4 (-1) | ❌ 1 (1) |
| `#/contact` | 7 → 2 (-5) | ❌ 9 (7) |
| `#/plan-du-site` | 0 → 0 | ✅ |
| `#/mentions-legales` | 1 → 0 (-1) | ❌ 1 (1) |
| `#/politique-de-confidentialite` | 1 → 0 (-1) | ❌ 1 (1) |
| `#/gestion-des-cookies` | 1 → 1 | ❌ 2 (1) |

## Routes à corriger en priorité

| Route | Cartes absentes ou fusionnées | Anomalies totales |
|---|---|---|
| `#/` | 7 | 23 |
| `#/contact` | 7 | 9 |
| `#/article/cahier-des-charges-nettoyage` | 6 | 10 |
| `#/zones-intervention` | 5 | 47 |
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
| `#/nettoyage-professionnel` | 3 | 39 |
| `#/ville/dijon` | 3 | 10 |
| `#/nos-tarifs` | 2 | 13 |
| `#/bourgogne-franche-comte` | 2 | 47 |
| `#/avis-clients` | 2 | 18 |
| `#/conseils` | 1 | 5 |
| `#/recrutement` | 1 | 9 |
| `#/demande-de-devis` | 1 | 1 |
| `#/mentions-legales` | 1 | 1 |
| `#/politique-de-confidentialite` | 1 | 1 |
| `#/gestion-des-cookies` | 1 | 2 |

## Archétypes employés par la maquette

| Archétype | Occurrences dans la maquette |
|---|---|
| `micro-carte` | 428 |
| `carte-titre-texte` | 281 |
| `chip` | 247 |
| `faq` | 247 |
| `carte-sombre` | 135 |
| `tarif` | 89 |
| `temoignage` | 37 |
| `carte-titre` | 25 |
| `carte-image` | 16 |
| `etape` | 6 |
| `carte-icone` | 2 |

## Détail par route

### `#/` → `/`

**1440 px** — bandes 13 → 13 · cartes 27 → 33 · 23 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 1 | « ★★★★★ 5,0/5 sur Google Voir les avis » |
| fusionnee | `micro-carte` | 1 | « ✦27 € HT/hrégulier ou ponctuel » rendue dans « Tarif unique 27 € HT/h Régulier ou ponctuel · devi » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 2 | « 27 € HT/htarif unique en région » |
| absente | `micro-carte` | 3 | « ★★★★★5,0/5 sur Google Saint-ApollinaireEntreprise régionale basée en B » |
| type | `micro-carte` | 5 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-sombre` |
| absente | `tarif` | 9 | « Tarif horaire de base 27 € HT/h Régulier ou ponctuel · devis gratuit s » |
| colonnes | `carte-image` | 10 | « 21 25 39 58 70 71 89 90 » — 2 colonnes attendues, 1 rendues |
| absente | `micro-carte` | 11 | « ★★★★★5,0/5 Google » |
| surplus | `chip` | 1 | « ★★★★★5,0/5 sur Google » |
| surplus | `micro-carte` | 1 | « 27 € HT/h tarif unique, régulier ou ponctuel » |
| surplus | `carte-image` | 1 | «  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis ✓Devis gratuit sous 24  » |
| surplus | `tarif` | 2 | « 27 € HT/h tarif unique, indiqué avant le devis » |
| surplus | `micro-carte` | 3 | « Saint-Apollinaire Entreprise régionale basée en BFC Interlocutrice ide » |
| surplus | `carte-sombre` | 5 | « Copropriétés & parties communes Halls, cages d'escalier, locaux commun » |
| surplus | `carte-sombre` | 5 | « Locations meublées & hébergements Remise en état entre deux occupants » |
| surplus | `carte-sombre` | 5 | « Ponctuel & remise en état Après travaux, grand nettoyage, fin de bail » |
| surplus | `tarif` | 9 | « Tarif unique 27 € HT/h Régulier ou ponctuel · devis gratuit sous 24 h. » |
| surplus | `micro-carte` | 10 | « Yonne 89 » |
| surplus | `micro-carte` | 10 | « Territoire de Belfort 90 » |
| surplus | `micro-carte` | 11 | «  » |
| surplus | `carte-titre` | 11 | « ★★★★★5,0/5 sur Google » |


### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

**1440 px** — bandes 19 → 19 · cartes 53 → 65 · 39 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| colonnes | `chip` | 2 | « ★★★★★5,0/5sur Google » — 1 colonnes attendues, 2 rendues |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région » |
| type | `micro-carte` | 5 | « Bureaux & open-spaces » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Surfaces de vente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Cabinets & salles d'attente » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Parties communes » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Meublés & hébergements » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Sanitaires & cuisines » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Nettoyage de bureauxOpen-spaces, salles de réunion, accueil » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Nettoyage de commercesBoutiques, showrooms, surfaces de vent » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Copropriétés & parties communesHalls, cages d'escalier, loca » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Locations meublées & hébergementsMeublés, gîtes, hébergement » — rendue en `carte-titre` |
| type | `carte-sombre` | 7 | « Nettoyage ponctuel & remise en étatAprès travaux, grand nett » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Entretien régulierFréquence définie (quotidienne, plusieurs  » — rendue en `tarif` |
| type | `micro-carte` | 8 | « Intervention ponctuellePrestation unique et approfondie : re » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 8 | « Horaires adaptésTôt le matin, en soirée ou en dehors des heu » — rendue en `carte-titre-texte` |
| absente | `temoignage` | 14 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| type | `micro-carte` | 17 | « À quelle fréquence faire nettoyer ses bureaux ?→ » — rendue en `carte-titre` |
| type | `micro-carte` | 17 | « Combien coûte le nettoyage de bureaux ?→ » — rendue en `carte-titre` |
| type | `micro-carte` | 17 | « Comment rédiger un cahier des charges de nettoyage ?→ » — rendue en `carte-titre` |
| surplus | `chip` | 3 | « 27 € HT/h » |
| surplus | `chip` | 3 | « tarif unique en région » |
| surplus | `chip` | 3 | « Devis gratuit sous 24 h » |
| surplus | `chip` | 3 | « Intervention régulière ou ponctuelle » |
| surplus | `chip` | 3 | « Conditions d'arrêt précisées au devis » |
| surplus | `carte-titre-texte` | 6 | « Prestataire de nettoyage ou recrutement direct ? C'est la première que » |
| surplus | `tarif` | 8 | « Régulier ou ponctuel, tâches, fréquences et horaires Entretien régulie » |
| surplus | `carte-titre-texte` | 9 | « Comment choisir la bonne fréquence La fréquence dépend moins de la sur » |
| … | | | 9 autres |


### `#/nos-prestations` → `/prestations/`

**1440 px** — bandes 6 → 6 · cartes 12 → 13 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-image` | 5 | « Nettoyage de bureauxUn entretien régulier et discret de vos  » — rendue en `carte-titre-texte` |
| type | `carte-image` | 5 | « Nettoyage de commercesUne surface de vente impeccable à l'ou » — rendue en `carte-titre-texte` |
| type | `carte-image` | 5 | « Cabinets & professions libéralesL'entretien courant des cabi » — rendue en `carte-titre-texte` |
| type | `carte-image` | 5 | « Copropriétés & parties communesL'entretien régulier des hall » — rendue en `carte-titre-texte` |
| type | `carte-image` | 5 | « Locations meublées & hébergementsLa remise en état de vos me » — rendue en `carte-titre-texte` |
| type | `carte-image` | 5 | « Nettoyage ponctuel & remise en étatUne intervention ponctuel » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |


### `#/service/bureaux` → `/prestations/bureaux/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Bureaux ? Audrey vous répond directe » — rendue en `micro-carte` |


### `#/service/commerces` → `/prestations/commerces/`

**1440 px** — bandes 14 → 14 · cartes 20 → 20 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Commerces ? Audrey vous répond direc » — rendue en `micro-carte` |


### `#/service/cabinets` → `/prestations/cabinets/`

**1440 px** — bandes 15 → 15 · cartes 28 → 28 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre-texte` | 4 | « Cette prestation est un entretien courant de locaux professi » — rendue en `micro-carte` |
| type | `carte-titre` | 14 | « Encore une question sur Cabinets ? Audrey vous répond direct » — rendue en `micro-carte` |


### `#/service/coproprietes` → `/prestations/coproprietes/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Copropriétés ? Audrey vous répond di » — rendue en `micro-carte` |


### `#/service/meubles` → `/prestations/meubles/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Locations meublées ? Audrey vous rép » — rendue en `micro-carte` |


### `#/service/ponctuel` → `/prestations/ponctuel/`

**1440 px** — bandes 14 → 14 · cartes 21 → 21 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-titre` | 13 | « Encore une question sur Ponctuel ? Audrey vous répond direct » — rendue en `micro-carte` |


### `#/nos-tarifs` → `/tarifs/`

**1440 px** — bandes 13 → 13 · cartes 22 → 21 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `tarif` | 3 | « Tarif horaire de base27 € HT/hIdentique en régulier et en po » — rendue en `micro-carte` |
| absente | `micro-carte` | 3 | « Devis sous 24 hGratuit, personnalisé et sans engagement. Aucun simulat » |
| absente | `micro-carte` | 6 | « Tarif horaireRégulier ou ponctuel27 € HT/h Frais de gestionPlanning, a » |
| colonnes | `carte-titre-texte` | 7 | « Ce qui est inclusMain-d'œuvre de l'intervenant sélectionnéOr » — 2 colonnes attendues, 1 rendues |
| colonnes | `carte-titre-texte` | 7 | « Fourni par le clientProduits d'entretien (généralement)Matér » — 2 colonnes attendues, 1 rendues |
| colonnes | `carte-titre` | 8 | « SurfaceSuperficie et nombre de pièces » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « FréquenceNombre de passages par semaine » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « Type de locauxBureaux, commerce, cabinet, meublé » — 3 colonnes attendues, 4 rendues |
| colonnes | `carte-titre` | 8 | « Niveau d'exigenceStandard ou renforcé (hygiène) » — 1 colonnes attendues, 4 rendues |
| type | `tarif` | 9 | « Petits bureaux ou cabinet8 h / mois · 1 passage hebdo225 € H » — rendue en `micro-carte` |
| type | `tarif` | 9 | « Bureaux réguliers12 h / mois · plusieurs passages333 € HT/mo » — rendue en `micro-carte` |
| type | `tarif` | 9 | « Besoin plus important20 h / mois · passages fréquents549 € H » — rendue en `micro-carte` |
| surplus | `temoignage` | 11 | « ★★★★★« Un devis clair, sans surprise, et le même tarif horaire annoncé » |


### `#/zones-intervention` → `/zones-intervention/`

**1440 px** — bandes 13 → 13 · cartes 52 → 54 · 47 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `carte-sombre` | 2 | « Vérifier notre intervention dans ma commune » — rendue en `carte-titre` |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région » |
| type | `micro-carte` | 5 | « Agglomération dijonnaise : créneaux souples, passages courts » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 5 | « Villes principales de la région : passages regroupés, planni » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Communes plus éloignées : fréquence hebdomadaire ou bimensue » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Interventions ponctuelles : selon disponibilité, avec une da » — rendue en `carte-titre` |
| type | `micro-carte` | 5 | « Les éventuelles indemnités kilométriques dépendent de l'adre » — rendue en `carte-titre-texte` |
| absente | `carte-sombre` | 6 | « Bourgogne-Franche-ComtéLa page régionale · huit départements couverts  » |
| absente | `micro-carte` | 6 | « Voir la page régionale → » |
| type | `micro-carte` | 7 | « Côte-d'Or21Préfecture : DijonVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Doubs25Préfecture : BesançonVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Jura39Préfecture : Lons-le-SaunierVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Nièvre58Préfecture : NeversVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Haute-Saône70Préfecture : VesoulVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Saône-et-Loire71Préfecture : MâconVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Yonne89Préfecture : AuxerreVoir le département → » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Territoire de Belfort90Préfecture : BelfortVoir le départeme » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Dijon21000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Besançon25000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Dole39100 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Lons-le-Saunier39000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Nevers58000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Vesoul70000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Chalon-sur-Saône71100 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Mâcon71000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Auxerre89000 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Belfort90000 » — rendue en `carte-titre` |
| type | `micro-carte` | 9 | « Saint-Apollinaire21850 » — rendue en `carte-titre` |
| type | `micro-carte` | 9 | « Chenôve21300 » — rendue en `carte-titre` |
| … | | | 17 autres |


### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

**1440 px** — bandes 12 → 12 · cartes 51 → 61 · 47 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région » |
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
| type | `carte-sombre` | 6 | « Nettoyage de bureauxOpen-spaces, salles de réunion, accueil » — rendue en `carte-titre` |
| type | `carte-sombre` | 6 | « Nettoyage de commercesBoutiques, showrooms, surfaces de vent » — rendue en `carte-titre` |
| type | `carte-sombre` | 6 | « Cabinets & professions libéralesSanté, droit, conseil, salle » — rendue en `carte-titre` |
| type | `carte-sombre` | 6 | « Copropriétés & parties communesHalls, cages d'escalier, loca » — rendue en `carte-titre` |
| type | `carte-sombre` | 6 | « Locations meublées & hébergementsMeublés, gîtes, hébergement » — rendue en `carte-titre` |
| type | `carte-sombre` | 6 | « Nettoyage ponctuel & remise en étatAprès travaux, grand nett » — rendue en `carte-titre` |
| type | `micro-carte` | 7 | « Côte-d'Or21Préfecture : DijonDe la métropole dijonnaise aux  » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Doubs25Préfecture : BesançonBesançon et son agglomération, c » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Jura39Préfecture : Lons-le-SaunierDole, Lons-le-Saunier et l » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Nièvre58Préfecture : NeversNevers et son agglomération, pour » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Haute-Saône70Préfecture : VesoulVesoul et les zones d'activi » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Saône-et-Loire71Préfecture : MâconDe Chalon-sur-Saône à Mâco » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Yonne89Préfecture : AuxerreAuxerre et le nord de la région,  » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 7 | « Territoire de Belfort90Préfecture : BelfortBelfort et son ag » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 8 | « Chalon-sur-Saône71100 » — rendue en `carte-titre` |
| type | `micro-carte` | 8 | « Mâcon71000 » — rendue en `carte-titre` |
| … | | | 17 autres |


### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

**1440 px** — bandes 11 → 11 · cartes 31 → 30 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Beaune » — 4 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Chevigny-Saint-Sauveur » — 4 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Ahuy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Plombières-lès-Dijon » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Sennecey-lès-Dijon » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 6 | « Nuits-Saint-Georges » — 3 colonnes attendues, 1 rendues |
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux à Dijon, 12 h/mois333 € HT/moisTrois passages de 1 h » rendue dans « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous cherchions un prestataire capable de passer avan » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 6 | « Daix » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux à Dijon, 12 h/mois 333 € HT/mois Exemple non contrac » |


### `#/departement/doubs` → `/zones-intervention/doubs/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « École-Valentin » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Chalezeule » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Thise » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Saône » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Pirey » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Serre-les-Sapins » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Beure » — 2 colonnes attendues, 1 rendues |
| absente | `micro-carte` | 7 | « Exemple · cabinet à Besançon, 10 h/mois279 € HT/moisDeux passages de 1 » |
| colonnes | `temoignage` | 7 | « ★★★★★« La salle d'attente et les sanitaires sont repris selo » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · cabinet à Besançon, 10 h/mois 333 € HT/mois Exemple non cont » |


### `#/departement/jura` → `/zones-intervention/jura/`

**1440 px** — bandes 11 → 11 · cartes 33 → 31 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Choisey » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Tavaux » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Damparis » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Foucherans » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Authume » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Perrigny » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Macornay » — 3 colonnes attendues, 2 rendues |
| absente | `micro-carte` | 7 | « Exemple · commerce à Dole, 16 h/mois441 € HT/moisUn passage d'une heur » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait avant l'ouverture, tous les matins » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · commerce à Dole, 16 h/mois 333 € HT/mois Exemple non contrac » |


### `#/departement/nievre` → `/zones-intervention/nievre/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Varennes-Vauzelles » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Fourchambault » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Marzy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Coulanges-lès-Nevers » — 4 colonnes attendues, 2 rendues |
| absente | `micro-carte` | 7 | « Exemple · copropriété à Nevers, 8 h/mois225 € HT/moisDeux heures par s » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le hall et les escaliers sont repris chaque semaine e » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · copropriété à Nevers, 8 h/mois 333 € HT/mois Exemple non con » |


### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 15 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Navenne » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Vaivre-et-Montoille » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Pusey » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Noidans-lès-Vesoul » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Frotey-lès-Vesoul » — 2 colonnes attendues, 1 rendues |
| absente | `micro-carte` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois279 € HT/moisDeux passages de 1 h » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avions besoin d'un passage en dehors des horaire » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux à Vesoul, 10 h/mois 333 € HT/mois Exemple non contra » |


### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Saint-Rémy » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Champforgeuil » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Saint-Marcel » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Châtenoy-le-Royal » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Sancé » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Charnay-lès-Mâcon » — 3 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Crêches-sur-Saône » — 3 colonnes attendues, 1 rendues |
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux à Chalon, 12 h/mois333 € HT/moisTrois passages d'une » rendue dans « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/moi » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avons trois passages par semaine tôt le matin. L » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux à Chalon, 12 h/mois 333 € HT/mois Exemple non contra » |


### `#/departement/yonne` → `/zones-intervention/yonne/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 12 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Monéteau » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Appoigny » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Perrigny » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Saint-Georges-sur-Baulche » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 6 | « Chevannes » — 2 colonnes attendues, 1 rendues |
| absente | `micro-carte` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois225 € HT/moisDeux passages d'une  » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nos bureaux administratifs sont entretenus deux fois  » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux à Auxerre, 8 h/mois 333 € HT/mois Exemple non contra » |


### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

**1440 px** — bandes 11 → 11 · cartes 31 → 29 · 16 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Commerces de centre-ville » — rendue en `chip` |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| absente | `micro-carte` | 6 | « Nettoyage de bureaux→Nettoyage de commerces→Cabinets & professions lib » |
| colonnes | `chip` | 6 | « Valdoie » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Offemont » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Bavilliers » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Danjoutin » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Cravanche » — 6 colonnes attendues, 3 rendues |
| colonnes | `chip` | 6 | « Essert » — 6 colonnes attendues, 3 rendues |
| absente | `micro-carte` | 7 | « Exemple · bureaux à Belfort, 10 h/mois279 € HT/moisDeux passages de 1  » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait en soirée, après le départ des équ » — 3 colonnes attendues, 1 rendues |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux à Belfort, 10 h/mois 333 € HT/mois Exemple non contr » |


### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 48 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| colonnes | `micro-carte` | 7 | « Exemple · bureaux en secteur tertiaire dijonnais, 12 h/mois3 » — 3 colonnes attendues, 1 rendues |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous ouvrons à 9 h et le passage est fait avant : bur » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Chevigny-Saint-Sauveur » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Sennecey-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 1 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `chip` | 9 | « Daix » |


### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

**1440 px** — bandes 13 → 13 · cartes 51 → 49 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `micro-carte` | 7 | « Exemple · cabinet paramédical, 10 h/mois279 € HT/moisDeux passages de  » rendue dans « Exemple · cabinet paramédical, 10 h/mois 333 € HT/ » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait après le dernier patient et la sal » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · cabinet paramédical, 10 h/mois 333 € HT/mois Exemple non con » |


### `#/ville/dole` → `/zones-intervention/jura/dole/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `micro-carte` | 7 | « Exemple · commerce en centre-ville, 16 h/mois441 € HT/moisUn passage d » rendue dans « Exemple · commerce en centre-ville, 16 h/mois 333  » |
| colonnes | `temoignage` | 7 | « ★★★★★« J'ouvre à 9 h 30 et tout est fait avant mon arrivée,  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · commerce en centre-ville, 16 h/mois 333 € HT/mois Exemple no » |


### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · cabinet comptable, 8 h/mois225 € HT/moisDeux heures par sema » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage du vendredi soir nous permet de retrouver  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · cabinet comptable, 8 h/mois 333 € HT/mois Exemple non contra » |


### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 13 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous avions des retards de passage avec notre ancien  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Varennes-Vauzelles » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Fourchambault » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Marzy » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Challuy » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Garchizy » — 3 colonnes attendues, 4 rendues |
| colonnes | `chip` | 9 | « Sermoise-sur-Loire » — 3 colonnes attendues, 4 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · copropriété, 8 h/mois 333 € HT/mois Exemple non contractuel. » |


### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Parties communes de résidences » — rendue en `chip` |
| type | `micro-carte` | 5 | « Locaux associatifs et de formation » — rendue en `chip` |
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux administratifs, 10 h/mois279 € HT/moisDeux passages  » rendue dans « Exemple · bureaux administratifs, 10 h/mois 333 €  » |
| colonnes | `temoignage` | 7 | « ★★★★★« L'intervention se fait en soirée avec un badge, sans  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux administratifs, 10 h/mois 333 € HT/mois Exemple non  » |


### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

**1440 px** — bandes 13 → 13 · cartes 48 → 46 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · bureaux, 12 h/mois333 € HT/moisTrois passages d'une heure pa » |
| colonnes | `temoignage` | 7 | « ★★★★★« Trois passages par semaine tôt le matin, avant l'arri » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux, 12 h/mois 333 € HT/mois Exemple non contractuel. » |


### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

**1440 px** — bandes 13 → 13 · cartes 49 → 47 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · cabinet de conseil, 8 h/mois225 € HT/moisDeux heures par sem » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous recevons des clients le lundi matin : la salle d » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · cabinet de conseil, 8 h/mois 333 € HT/mois Exemple non contr » |


### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · bureaux de PME, 8 h/mois225 € HT/moisDeux passages d'une heu » |
| colonnes | `temoignage` | 7 | « ★★★★★« Deux passages par semaine après la fermeture, sans qu » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux de PME, 8 h/mois 333 € HT/mois Exemple non contractu » |


### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

**1440 px** — bandes 13 → 13 · cartes 50 → 48 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois279 € HT/moisDeux passages de » rendue dans « Exemple · bureaux d'ingénierie, 10 h/mois 333 € HT » |
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
| surplus | `micro-carte` | 7 | « Exemple · bureaux d'ingénierie, 10 h/mois 333 € HT/mois Exemple non co » |


### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

**1440 px** — bandes 13 → 13 · cartes 44 → 42 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux en zone d'activité, 12 h/mois 33 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous sommes suivis depuis deux ans, avec le même crén » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ruffey-lès-Echirey » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Bressey-sur-Tille » — 4 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Varois-et-Chaignot » — 2 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Norges-la-Ville » — 2 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux en zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |


### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

**1440 px** — bandes 13 → 13 · cartes 41 → 39 · 8 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · copropriété, 8 h/mois225 € HT/moisDeux heures par semaine :  » |
| colonnes | `temoignage` | 7 | « ★★★★★« L'entretien de nos parties communes est régulier et l » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 4 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · copropriété, 8 h/mois 333 € HT/mois Exemple non contractuel. » |


### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

**1440 px** — bandes 13 → 13 · cartes 37 → 35 · 14 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · commerce, 20 h/mois549 € HT/moisUn passage d'une heure avant » |
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
| surplus | `micro-carte` | 7 | « Exemple · commerce, 20 h/mois 333 € HT/mois Exemple non contractuel. » |


### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

**1440 px** — bandes 13 → 13 · cartes 41 → 40 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · résidence, 6 h/mois171 € HT/moisUn passage de 1 h 30 par sem » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le hall et l'ascenseur sont repris chaque semaine, à  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Plombières-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · résidence, 6 h/mois 333 € HT/mois Exemple non contractuel. » |
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
| fusionnee | `micro-carte` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois333 € HT/moisTrois pass » rendue dans « Exemple · bureaux de zone d'activité, 12 h/mois 33 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nos bureaux sont entretenus trois matins par semaine  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ouges » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Fénay » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 5 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · bureaux de zone d'activité, 12 h/mois 333 € HT/mois Exemple  » |


### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

**1440 px** — bandes 13 → 13 · cartes 43 → 42 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| absente | `micro-carte` | 7 | « Exemple · cabinet paramédical, 8 h/mois225 € HT/moisDeux passages d'un » |
| colonnes | `temoignage` | 7 | « ★★★★★« Le passage se fait après la fermeture, deux fois par  » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Ahuy » — 5 colonnes attendues, 3 rendues |
| colonnes | `chip` | 9 | « Hauteville-lès-Dijon » — 5 colonnes attendues, 3 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · cabinet paramédical, 8 h/mois 333 € HT/mois Exemple non cont » |
| surplus | `chip` | 9 | « Daix » |


### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

**1440 px** — bandes 13 → 13 · cartes 36 → 34 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| fusionnee | `micro-carte` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois279 € HT/moisDeux pass » rendue dans « Exemple · espace d'accueil et bureaux, 10 h/mois 3 » |
| colonnes | `temoignage` | 7 | « ★★★★★« Nous recevons des visiteurs plusieurs jours par semai » — 3 colonnes attendues, 1 rendues |
| colonnes | `chip` | 9 | « Couchey » — 4 colonnes attendues, 2 rendues |
| colonnes | `chip` | 9 | « Perrigny-lès-Dijon » — 4 colonnes attendues, 2 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · espace d'accueil et bureaux, 10 h/mois 333 € HT/mois Exemple » |


### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

**1440 px** — bandes 13 → 13 · cartes 41 → 39 · 10 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `tarif` | 3 | « 27 € HT/htarif unique en région✓Devis gratuit sous 24 h✓Intervention r » |
| fusionnee | `tarif` | 3 | « 27 € HT/htarif unique en région » rendue dans « 27 € HT/h tarif unique en région Voir les tarifs → » |
| type | `micro-carte` | 5 | « Cabinets et professions libérales » — rendue en `chip` |
| type | `micro-carte` | 5 | « Bureaux de PME et sièges locaux » — rendue en `chip` |
| type | `micro-carte` | 5 | « Copropriétés et résidences » — rendue en `chip` |
| fusionnee | `micro-carte` | 7 | « Exemple · commerce intra-muros, 16 h/mois441 € HT/moisUn passage d'une » rendue dans « Exemple · commerce intra-muros, 16 h/mois 333 € HT » |
| colonnes | `temoignage` | 7 | « ★★★★★« En haute saison, le passage avant ouverture fait une  » — 3 colonnes attendues, 1 rendues |
| absente | `carte-titre-texte` | 12 | « Nous contacterAudrey est votre interlocutrice unique, de la première v » |
| surplus | `tarif` | 3 | « 27 € HT/h tarif unique en région Voir les tarifs → » |
| surplus | `micro-carte` | 7 | « Exemple · commerce intra-muros, 16 h/mois 333 € HT/mois Exemple non co » |


### `#/conseils` → `/conseils/`

**1440 px** — bandes 7 → 7 · cartes 11 → 14 · 5 anomalie(s)

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


### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

**1440 px** — bandes 9 → 9 · cartes 5 → 7 · 3 anomalie(s)

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


### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

**1440 px** — bandes 8 → 8 · cartes 12 → 19 · 11 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `micro-carte` | 4 | « 5,0/5sur Google » — rendue en `chip` |
| type | `micro-carte` | 4 | « 24 hdevis transmis » — rendue en `carte-titre` |
| type | `etape` | 4 | « 8départements » — rendue en `carte-titre` |
| type | `micro-carte` | 4 | « 27 €HT/h, transparent » — rendue en `tarif` |
| surplus | `chip` | 3 | « Directement joignable » |
| surplus | `chip` | 3 | « Intervenants sélectionnés » |
| surplus | `chip` | 3 | « Suivi réel » |
| surplus | `chip` | 3 | « Tarif transparent » |
| surplus | `chip` | 3 | « Gestion prise en charge » |
| surplus | `chip` | 3 | « Ancrage régional » |
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


### `#/avis-clients` → `/avis-clients/`

**1440 px** — bandes 7 → 7 · cartes 14 → 20 · 18 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-titre` | 3 | « 5,0/5★★★★★Sur Google · 47 avis clientsDemander mon devis » |
| absente | `temoignage` | 4 | « ★★★★★« Nous avons comparé une embauche et un prestataire. Ce qui a tra » |
| type | `carte-sombre` | 4 | « ★★★★★« Devis clair reçu le lendemain, sans surprise. Le resp » — rendue en `carte-titre-texte` |
| type | `carte-sombre` | 4 | « ★★★★★« Nettoyage de la boutique avant l'ouverture, vitrines  » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Même intervenante chaque semaine dans nos burea » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Devis clair reçu le lendemain, sans surprise. L » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Nettoyage de la boutique avant l'ouverture, vit » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Pour nos copropriétés, le suivi est réel : hall » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remises en état entre deux locataires impeccabl » — rendue en `carte-titre-texte` |
| type | `temoignage` | 5 | « ★★★★★Google« Remise en état ponctuelle après travaux, devis  » — rendue en `carte-titre-texte` |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `chip` | 3 | « ★★★★★ » |
| surplus | `chip` | 3 | « Sur · avis clients » |
| surplus | `chip` | 3 | « Google » |
| surplus | `chip` | 4 | « ★★★★★ » |
| surplus | `chip` | 4 | « Marc V. » |
| surplus | `chip` | 4 | « Directeur administratif » |
| surplus | `chip` | 4 | « Chalon-sur-Saône » |


### `#/a-propos` → `/a-propos/`

**1440 px** — bandes 6 → 6 · cartes 1 → 7 · 7 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `chip` | 3 | « Audrey » |
| surplus | `chip` | 3 | « · Top-Famille Pro » |
| surplus | `chip` | 4 | « Proximité » |
| surplus | `chip` | 4 | « Rigueur » |
| surplus | `chip` | 4 | « Transparence » |
| surplus | `chip` | 4 | « Filiation Top-Famille » |


### `#/recrutement` → `/recrutement/`

**1440 px** — bandes 5 → 5 · cartes 6 → 8 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| type | `micro-carte` | 3 | « Bureaux & sièges d'entrepriseEntretien matinal ou en soirée, » — rendue en `carte-titre` |
| type | `micro-carte` | 3 | « Commerces & showroomsAvant ouverture ou après fermeture, sel » — rendue en `carte-titre` |
| type | `micro-carte` | 3 | « Cabinets & professions libéralesPassages en dehors des heure » — rendue en `carte-titre-texte` |
| type | `micro-carte` | 3 | « Copropriétés & parties communesHalls, cages d'escalier et lo » — rendue en `carte-titre` |
| absente | `carte-sombre` | 4 | « Les étapes de candidature 01Vous envoyez votre candidature et vos disp » |
| surplus | `chip` | 2 | « ★★★★★5,0/5 sur Google » |
| surplus | `micro-carte` | 4 | « Vous envoyez votre candidature et vos disponibilités. » |
| surplus | `micro-carte` | 4 | « Audrey vous recontacte pour un échange sur votre profil et votre secte » |
| surplus | `micro-carte` | 4 | « Selon les missions disponibles près de chez vous, une proposition vous » |


### `#/demande-de-devis` → `/demande-de-devis/`

**1440 px** — bandes 1 → 2 · cartes 5 → 4 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `carte-sombre` | 1 | « Google★★★★★5,0/547 avis » |


### `#/contact` → `/contact/`

**1440 px** — bandes 4 → 4 · cartes 7 → 2 · 9 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 3 | « J'ai un besoin de nettoyage Direction le formulaire de devis détaillé  » |
| absente | `carte-icone` | 4 | « AudreyVotre interlocutrice, du devis au suivi » |
| absente | `micro-carte` | 4 | « ☎Téléphone06 36 17 63 39 » |
| absente | `micro-carte` | 4 | « ✉E-mailaudrey.b@top-famille.fr » |
| absente | `micro-carte` | 4 | « 📍ImplantationSaint-Apollinaire (21) · Bourgogne-Franche-Comté » |
| absente | `micro-carte` | 4 | « 🕑Horaires de contactDu lundi au vendredi · à confirmer · réponse sous » |
| absente | `tarif` | 4 | « ★★★★★5,0/527 € HT/h » |
| surplus | `carte-titre-texte` | 3 | « Audrey Brançon Gérante — votre interlocutrice pour les devis et le sui » |
| surplus | `carte-titre-texte` | 3 | « Siège social Top-Famille Pro650D route de Gray21850 Saint-Apollinaire  » |


### `#/plan-du-site` → `/plan-du-site/`

**1440 px** — bandes 3 → 3 · cartes 0 → 0 · 0 anomalie(s)


### `#/mentions-legales` → `/mentions-legales/`

**1440 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : forme juridique, capital, SIREN/S » |


### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

**1440 px** — bandes 3 → 3 · cartes 1 → 0 · 1 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : identité du responsable de traite » |


### `#/gestion-des-cookies` → `/gestion-des-cookies/`

**1440 px** — bandes 3 → 3 · cartes 1 → 1 · 2 anomalie(s)

| Anomalie | Archétype | Bande | Détail |
|---|---|---|---|
| absente | `micro-carte` | 2 | « Page à compléter avant publication : la liste définitive dépend des ou » |
| surplus | `carte-titre-texte` | 3 | « Aucun cookie de mesure d'audience ni de traçage publicitaire À ce jour » |


