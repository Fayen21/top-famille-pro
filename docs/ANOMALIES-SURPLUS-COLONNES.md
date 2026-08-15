# Anomalies « carte supplémentaire » et « colonnes » — classement exhaustif

> Fichier **généré** par `node tools/classer-anomalies.mjs` depuis `docs/inventaire-cartes.json`.
> Ne pas éditer à la main.
>
> Toutes les occurrences relevées sur les 53 routes, aux deux largeurs, y figurent : aucune
> n’est agrégée ni tronquée. Une cause dont l’origine n’a pas été établie par la mesure est
> écrite « à instruire » — affirmer une cause plausible sans l’avoir vérifiée vaudrait moins
> que ne rien affirmer.

**94 occurrences** — 51 cartes supplémentaires, 43 écarts de colonnes.

## Synthèse par cause

| Cause | Occurrences | Verdict |
|---|---:|---|
| Rangée de pastilles coupée à un rang près | 19 | Faux positif résiduel de l’outil |
| Rangée de pastilles coupée à deux rangs ou plus | 13 | À instruire — cause non tranchée |
| Carte d’exemple tarifaire d’une page prestation | 6 | À instruire — cause non tranchée |
| Autres écarts de colonnes | 5 | À instruire — cause non tranchée |
| Badge de note Google rendu en plusieurs éléments | 18 | Écart réel, mineur |
| Bouton d’appel à l’action contextuel | 1 | Écart voulu (CLAUDE.md §8) |
| Bloc de contenu d’une page statique ou d’un article | 14 | À instruire — cause non tranchée |
| Autres cartes supplémentaires | 18 | À instruire — cause non tranchée |

## Rangée de pastilles coupée à un rang près

**Verdict :** Faux positif résiduel de l’outil · **19 occurrence(s)**

- **Maquette** — Les pastilles de communes sont posées dans une rangée qui revient à la ligne. Leur géométrie est désormais identique des deux côtés : 79 × 41 px, texte 14 px semi-gras, rembourrage 8/15, rayon plein.
- **WordPress** — Même rangée, même nombre de pastilles, même géométrie — mais le retour à la ligne tombe une pastille plus tôt ou plus tard selon la longueur du nom de commune, qui n’est pas la même d’une page à l’autre.
- **Correction** — Aucune. Le point de retour d’une rangée en ligne n’est pas une propriété de mise en page : c’est une conséquence de la largeur du texte. Forcer un nombre de colonnes reviendrait à figer une grille là où la maquette n’en a pas, et casserait le rendu sur les largeurs intermédiaires.
- **Non-régression** — La taille des pastilles est verrouillée par la mesure (79 × 41 px à 1440 px).

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/nettoyage-professionnel` | 1440 | 2 | `chip` | 1 → 2 | ★★★★★5,0/5sur Google |
| `#/departement/cote-dor` | 375 | 6 | `chip` | 3 → 2 | Beaune |
| `#/departement/cote-dor` | 375 | 6 | `chip` | 3 → 2 | Chevigny-Saint-Sauveur |
| `#/departement/cote-dor` | 375 | 6 | `chip` | 2 → 3 | Plombières-lès-Dijon |
| `#/ville/dijon` | 1440 | 9 | `chip` | 3 → 4 | Chevigny-Saint-Sauveur |
| `#/ville/dijon` | 1440 | 9 | `chip` | 1 → 2 | Ruffey-lès-Echirey |
| `#/ville/saint-apollinaire` | 375 | 9 | `chip` | 3 → 2 | Ruffey-lès-Echirey |
| `#/ville/saint-apollinaire` | 375 | 9 | `chip` | 1 → 2 | Norges-la-Ville |
| `#/ville/saint-apollinaire` | 1440 | 9 | `chip` | 4 → 3 | Ruffey-lès-Echirey |
| `#/ville/saint-apollinaire` | 1440 | 9 | `chip` | 4 → 3 | Bressey-sur-Tille |
| `#/ville/saint-apollinaire` | 1440 | 9 | `chip` | 2 → 3 | Varois-et-Chaignot |
| `#/ville/saint-apollinaire` | 1440 | 9 | `chip` | 2 → 1 | Norges-la-Ville |
| `#/ville/quetigny` | 1440 | 9 | `chip` | 4 → 3 | Chevigny-Saint-Sauveur |
| `#/ville/quetigny` | 1440 | 9 | `chip` | 4 → 3 | Sennecey-lès-Dijon |
| `#/ville/longvic` | 375 | 9 | `chip` | 4 → 3 | Ouges |
| `#/ville/longvic` | 375 | 9 | `chip` | 4 → 3 | Fénay |
| `#/ville/fontaine-les-dijon` | 375 | 9 | `chip` | 4 → 3 | Ahuy |
| `#/ville/marsannay-la-cote` | 375 | 9 | `chip` | 3 → 2 | Couchey |
| `#/ville/marsannay-la-cote` | 375 | 9 | `chip` | 1 → 2 | Perrigny-lès-Dijon |

## Rangée de pastilles coupée à deux rangs ou plus

**Verdict :** À instruire — cause non tranchée · **13 occurrence(s)**

- **Maquette** — Rangée de pastilles sur n colonnes.
- **WordPress** — Rangée rendue sur au moins deux colonnes d’écart.
- **Correction** — Aucune à ce stade. Un écart de deux rangs ne s’explique plus par la seule largeur du texte : il suppose un conteneur de largeur différente. Chaque occurrence est listée ci-dessous pour être reprise une par une.
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/ville/dijon` | 1440 | 9 | `chip` | 4 → 2 | Sennecey-lès-Dijon |
| `#/ville/chenove` | 1440 | 9 | `chip` | 4 → 1 | Perrigny-lès-Dijon |
| `#/ville/quetigny` | 1440 | 9 | `chip` | 1 → 3 | Bretenière |
| `#/ville/talant` | 1440 | 9 | `chip` | 4 → 2 | Plombières-lès-Dijon |
| `#/ville/longvic` | 375 | 9 | `chip` | 1 → 3 | Perrigny-lès-Dijon |
| `#/ville/longvic` | 1440 | 9 | `chip` | 5 → 3 | Ouges |
| `#/ville/longvic` | 1440 | 9 | `chip` | 5 → 3 | Fénay |
| `#/ville/longvic` | 1440 | 9 | `chip` | 5 → 3 | Perrigny-lès-Dijon |
| `#/ville/fontaine-les-dijon` | 375 | 9 | `chip` | 1 → 3 | Hauteville-lès-Dijon |
| `#/ville/fontaine-les-dijon` | 1440 | 9 | `chip` | 5 → 3 | Ahuy |
| `#/ville/fontaine-les-dijon` | 1440 | 9 | `chip` | 5 → 3 | Hauteville-lès-Dijon |
| `#/ville/marsannay-la-cote` | 1440 | 9 | `chip` | 4 → 2 | Couchey |
| `#/ville/marsannay-la-cote` | 1440 | 9 | `chip` | 4 → 2 | Perrigny-lès-Dijon |

## Carte d’exemple tarifaire d’une page prestation

**Verdict :** À instruire — cause non tranchée · **6 occurrence(s)**

- **Maquette** — La carte partage sa rangée avec n voisines.
- **WordPress** — Elle en partage un autre nombre.
- **Correction** — La bande tarifaire des pages de zone a été remise à trois colonnes (texte 394, exemple 344, témoignage 374, écart 34, mesurés à 1440 px) et ses trois colonnes partagent désormais la même ligne. Les occurrences qui subsistent portent sur les pages prestation et la page tarifs, dont la bande n’a pas encore été mesurée.
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/service/commerces` | 1440 | 10 | `tarif` | 1 → 2 | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/cabinets` | 1440 | 11 | `tarif` | 1 → 2 | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/coproprietes` | 1440 | 10 | `tarif` | 1 → 2 | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/meubles` | 1440 | 10 | `tarif` | 1 → 2 | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/ponctuel` | 1440 | 10 | `tarif` | 1 → 2 | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/bourgogne-franche-comte` | 1440 | 9 | `tarif` | 3 → 2 | Exemple · bureaux réguliers, 12 h/mois333 € HT/mois12 h × 27 |

## Autres écarts de colonnes

**Verdict :** À instruire — cause non tranchée · **5 occurrence(s)**

- **Maquette** — —
- **WordPress** — —
- **Correction** — Aucune. Occurrences listées nommément.
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 1440 | 10 | `carte-image` | 2 → 1 | 21 25 39 58 70 71 89 90 |
| `#/nos-tarifs` | 1440 | 8 | `carte-titre` | 3 → 4 | SurfaceSuperficie et nombre de pièces |
| `#/nos-tarifs` | 1440 | 8 | `carte-titre` | 3 → 4 | FréquenceNombre de passages par semaine |
| `#/nos-tarifs` | 1440 | 8 | `carte-titre` | 3 → 4 | Type de locauxBureaux, commerce, cabinet, meublé |
| `#/nos-tarifs` | 1440 | 8 | `carte-titre` | 1 → 4 | Niveau d'exigenceStandard ou renforcé (hygiène) |

## Badge de note Google rendu en plusieurs éléments

**Verdict :** Écart réel, mineur · **18 occurrence(s)**

- **Maquette** — Le badge « ★★★★★ 5,0/5 sur Google » est un seul bloc.
- **WordPress** — Le thème le compose de plusieurs éléments porteurs de fond ou de rayon, dont l’un est relevé comme une carte de plus.
- **Correction** — Aucune à ce stade : le badge est visuellement conforme, et le découper autrement toucherait un composant présent sur 38 routes pour un gain nul à l’écran.
- **Non-régression** — La note affichée reste celle des réglages, jamais une valeur écrite en dur.

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/nos-prestations` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/nos-prestations` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/nos-tarifs` | 375 | 11 | `temoignage` | — | ★★★★★« Un devis clair, sans surprise, et le même tarif horai |
| `#/nos-tarifs` | 1440 | 11 | `temoignage` | — | ★★★★★« Un devis clair, sans surprise, et le même tarif horai |
| `#/zones-intervention` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/zones-intervention` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/bourgogne-franche-comte` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/bourgogne-franche-comte` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/pourquoi-top-famille-pro` | 375 | 4 | `carte-titre` | — | 5,0/5 sur Google |
| `#/pourquoi-top-famille-pro` | 1440 | 4 | `carte-titre` | — | 5,0/5 sur Google |
| `#/notre-fonctionnement` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/notre-fonctionnement` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/a-propos` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/a-propos` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/recrutement` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/recrutement` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/contact` | 375 | 4 | `tarif` | — | ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région |
| `#/contact` | 1440 | 4 | `tarif` | — | ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région |

## Bouton d’appel à l’action contextuel

**Verdict :** Écart voulu (CLAUDE.md §8) · **1 occurrence(s)**

- **Maquette** — Le prototype n’a pas toujours de bouton contextualisé à cet endroit.
- **WordPress** — Le thème ajoute le CTA contextuel imposé par le cahier des charges : « Demander un devis à {ville} », avec sa réassurance.
- **Correction** — Aucune : cet ajout est une exigence du projet, pas une dérive.
- **Non-régression** — Couvert par la suite de conversion.

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/departement/saone-et-loire` | 375 | 11 | `micro-carte` | — | Demander un devis en Saône-et-Loire |

## Bloc de contenu d’une page statique ou d’un article

**Verdict :** À instruire — cause non tranchée · **14 occurrence(s)**

- **Maquette** — —
- **WordPress** — —
- **Correction** — Aucune à ce stade. Occurrences listées nommément.
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 375 | 1 | `tarif` | — | 27 € HT/h tarif unique, régulier ou ponctuel |
| `#/` | 375 | 2 | `tarif` | — | 27 € HT/h tarif unique, indiqué avant le devis |
| `#/` | 375 | 3 | `carte-titre-texte` | — | Saint-Apollinaire Entreprise régionale basée en BFC Interloc |
| `#/` | 375 | 5 | `carte-sombre` | — | Copropriétés & parties communes Halls, cages d'escalier, loc |
| `#/` | 375 | 5 | `carte-sombre` | — | Locations meublées & hébergements Remise en état entre deux  |
| `#/` | 375 | 5 | `carte-sombre` | — | Ponctuel & remise en état Après travaux, grand nettoyage, fi |
| `#/` | 1440 | 1 | `tarif` | — | 27 € HT/h tarif unique, régulier ou ponctuel |
| `#/` | 1440 | 2 | `tarif` | — | 27 € HT/h tarif unique, indiqué avant le devis |
| `#/` | 1440 | 3 | `carte-titre-texte` | — | Saint-Apollinaire Entreprise régionale basée en BFC Interloc |
| `#/` | 1440 | 5 | `carte-sombre` | — | Copropriétés & parties communes Halls, cages d'escalier, loc |
| `#/` | 1440 | 5 | `carte-sombre` | — | Locations meublées & hébergements Remise en état entre deux  |
| `#/` | 1440 | 5 | `carte-sombre` | — | Ponctuel & remise en état Après travaux, grand nettoyage, fi |
| `#/gestion-des-cookies` | 375 | 3 | `carte-titre-texte` | — | Aucun cookie de mesure d'audience ni de traçage publicitaire |
| `#/gestion-des-cookies` | 1440 | 3 | `carte-titre-texte` | — | Aucun cookie de mesure d'audience ni de traçage publicitaire |

## Autres cartes supplémentaires

**Verdict :** À instruire — cause non tranchée · **18 occurrence(s)**

- **Maquette** — —
- **WordPress** — —
- **Correction** — Aucune. Occurrences listées nommément.
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 375 | 1 | `carte-icone` | — | — |
| `#/` | 1440 | 1 | `carte-image` | — | — |
| `#/` | 1440 | 10 | `carte-titre` | — | Yonne 89 |
| `#/` | 1440 | 10 | `carte-titre` | — | Territoire de Belfort 90 |
| `#/conseils` | 375 | 4 | `chip` | — | Bureaux |
| `#/conseils` | 375 | 5 | `chip` | — | Tarifs |
| `#/conseils` | 375 | 5 | `chip` | — | Organisation |
| `#/conseils` | 1440 | 4 | `chip` | — | Bureaux |
| `#/conseils` | 1440 | 5 | `chip` | — | Tarifs |
| `#/conseils` | 1440 | 5 | `chip` | — | Organisation |
| `#/article/frequence-bureaux` | 375 | 2 | `chip` | — | Bureaux |
| `#/article/frequence-bureaux` | 1440 | 2 | `chip` | — | Bureaux |
| `#/article/cahier-des-charges-nettoyage` | 375 | 2 | `chip` | — | Organisation |
| `#/article/cahier-des-charges-nettoyage` | 1440 | 2 | `chip` | — | Organisation |
| `#/contact` | 375 | 3 | `carte-titre` | — | J’ai une question Formulaire court, réponse par e-mail ou té |
| `#/contact` | 375 | 4 | `carte-titre` | — | 🕑 Horaires de contact Du lundi au vendredi · réponse sous 2 |
| `#/contact` | 1440 | 3 | `carte-titre` | — | J’ai une question Formulaire court, réponse par e-mail ou té |
| `#/contact` | 1440 | 4 | `carte-titre` | — | 🕑 Horaires de contact Du lundi au vendredi · réponse sous 2 |

