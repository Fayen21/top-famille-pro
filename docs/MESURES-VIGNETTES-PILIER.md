# Les six vignettes 56 px de la page pilier — mesures comparées

> Relevé par `node tools/mesure-vignettes-pilier.mjs`, à 375, 768 et 1440 px, sur les **six**
> cartes de prestation de `/nettoyage-professionnel/` — celles dont la miniature fait exactement
> 56 px. Chaque valeur est lue sur le rendu, jamais déduite du code.

## Ce que la mesure a d'abord fait croire, et pourquoi c'était faux

Deux pièges ont été rencontrés et corrigés avant de pouvoir conclure quoi que ce soit :

1. **« toute image de 20 à 90 px »** ramenait aussi le logo du pied de page, dont la carte fait
   2 000 px de haut. Une valeur aberrante au milieu des mesures.
2. **« le premier texte de la carte »** ne désigne pas la même chose des deux côtés — le titre sur
   la maquette, la description sur le site. La comparaison annonçait « 17 px → 13 px » là où deux
   éléments différents étaient mis en regard. Titre et description sont désormais relevés
   séparément.

Un troisième piège n'était visible qu'à la troisième mesure : la maquette compose son titre en
`display: inline`, le site en `display: block`. Le rectangle d'un élément en ligne est la boîte
des **glyphes** (19 px) ; celui d'un bloc est la boîte de **ligne** (26,7 px). Comparer leurs
« hauts » fabriquait un écart de 3 px qui n'existe pas à l'œil. La comparaison porte donc sur le
**centre** des glyphes : l'écart réel est de **0,8 à 0,9 px**.

## Mesures

| Attribut | 375 px | 768 px | 1440 px |
|---|---|---|---|
| Largeur de l'image | ✅ 56 | ✅ 56 | ✅ 56 |
| Hauteur de l'image | ✅ 56 | ✅ 56 | ✅ 56 |
| Rayon de l'image | ✅ 10px | ✅ 10px | ✅ 10px |
| Largeur de la carte | ✅ 339 | ✅ 346.3 | ✅ 284.5 |
| Hauteur de la carte | **105.8 / 111.5 / 132.5 / 90 → 105.9 / 111.5 / 132.6 / 90** | ✅ 111.5 / 90 | **132.5 → 132.6** |
| Épaisseur du filet | ✅ 1px | ✅ 1px | ✅ 1px |
| Style du filet | ✅ solid | ✅ solid | ✅ solid |
| Couleur du filet | ✅ rgb(30, 92, 158) | ✅ rgb(30, 92, 158) | ✅ rgb(30, 92, 158) |
| Fond de la carte | ✅ rgb(23, 74, 129) | ✅ rgb(23, 74, 129) | ✅ rgb(23, 74, 129) |
| Rayon de la carte | ✅ 14px | ✅ 14px | ✅ 14px |
| Rembourrage (h/d/b/g) | ✅ 16/16/16/16 | ✅ 16/16/16/16 | ✅ 16/16/16/16 |
| Écart image ↔ titre (centres) | **-40.9 / -51.4 → -40 / -50.6** | **-40.9 → -40** | **-51.4 → -50.6** |
| Taille du titre | ✅ 16.5 | ✅ 16.5 | ✅ 16.5 |
| Interligne du titre | ✅ 26.7 | ✅ 26.7 | ✅ 26.7 |
| Graisse du titre | ✅ 700 | ✅ 700 | ✅ 700 |
| Taille de la description | ✅ 13 | ✅ 13 | ✅ 13 |
| Interligne de la description | ✅ 21.1 | ✅ 21.1 | ✅ 21.1 |

| Écarts entre cartes voisines | 375 px | 768 px | 1440 px |
|---|---|---|---|
| maquette | v 14, v 13.2, v 14.5, v 13.5, v 14.5 | h 13.7, v 14, h 13.7, v 13.5, h 13.7 | h 14.5, h 13.5, h 14.5, v 14.5, h 14.5 |
| site | v 14, v 13.1, v 14.5, v 14.4, v 13.5 | h 13.7, v 14, h 13.7, v 14.5, h 13.7 | h 14.5, h 13.5, h 14.5, v 14.4, h 14.5 |

`h` = écart horizontal entre deux cartes de la même rangée, `v` = écart vertical entre deux
rangées. La maquette replie en une colonne à 375 px, deux à 768 px, quatre à 1440 px : le site
suit exactement le même repli.

## Le seul défaut réel, et sa cause

**La couleur du filet.** La maquette borde ces tuiles de `rgb(30, 92, 158)` — un bleu plus clair
que leur fond `rgb(23, 74, 129)`. Le site posait `rgb(220, 231, 235)`, le filet pâle des cartes
blanches : un liseré clair là où la maquette pose un bleu.

La cause n'était pas une valeur mal choisie mais une **valeur jamais relevée**. Le générateur
enregistrait le fond de la carte, son rayon et l'épaisseur du filet — pas sa couleur. Le thème
appliquait donc son jeton par défaut. Une règle de variante existait bien pour les bandes sombres
(`border-color: #234066`), mais elle perdait : le raccourci `border` de la règle de base s'écrit
avec une spécificité de (0,3,0) et écrasait la `border-color` d'un sélecteur de variante à (0,2,0).

Corrigé à la source : `tools/generate-pages.mjs` relève `filet_couleur`, le composant émet
`--tfp-tuile-filet-couleur`, et la règle de base la lit **dans le raccourci lui-même** — là où
aucune spécificité ne peut plus la contredire.

## Barre CTA mobile

À 375 px, la barre de commandes fixe du bas d'écran ne recouvre aucune vignette : le pied de page
réserve sa hauteur. Contrôlé par `tests/vignettes-pilier.spec.js`.

## Ce qui reste

| Écart | Amplitude | Statut |
|---|---|---|
| Hauteur de carte | 0,1 px | Arrondi sous-pixel, sans effet visible |
| Centre du titre vs image | 0,8 à 0,9 px | Sous-pixel, conséquence du modèle de boîte (inline / bloc) |
| Écart vertical entre deux rangées | ≤ 1 px | Arrondi d'une valeur en `clamp()` |

Aucun de ces trois n'est un défaut : ils sont tous sous le pixel, et mesurés comme tels plutôt
qu'affirmés.

