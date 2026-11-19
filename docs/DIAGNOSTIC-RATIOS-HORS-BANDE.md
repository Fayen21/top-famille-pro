# Les deux routes non légales hors bande — causes mesurées

> Complément à `docs/RECONCILIATION-RATIOS.md`. Établi le 19 août 2026.
> Objectif de la passe : **300 / 318**, c'est-à-dire les 50 routes non légales dans 95-105 % aux
> six largeurs, les trois pages légales seules autorisées hors tolérance.

Deux contrôles sur 318 sortaient de la bande sans être une page légale. Ils sont diagnostiqués ici
jusqu'à la cause, mesure à l'appui — pas estimés — **et tous les deux sont corrigés**.

> **État final : 318 contrôles · 300 dans 95-105 % · 18 hors, toutes des pages légales.**
> Les 50 routes non légales tiennent la plage aux six largeurs. Objectif atteint.

---

## 1. `/avis-clients/` à 320 px — page trop COURTE

| | Maquette | Site | Écart |
|---|---:|---:|---:|
| Hauteur totale | 6 631 px | 6 271 px | **−360 px** |
| Cible 95-105 % | | | 6 300 → 6 962 px |

### Décomposition par bande

| Bande | Maquette | Site | Écart | Lecture |
|---|---:|---:|---:|---|
| 1 — hero | 233 | 467 | +234 | Le site pose un fil d'Ariane et une rangée de commandes que la maquette n'a pas |
| 2 — badge de note | 223 | 76 | **−147** | **Décision** : la note Google n'est pas affichée (18/08/2026). La bande devient une simple rangée de commandes. |
| 3 — témoignage mis en avant | 771 | 697 | −74 | voir ci-dessous |
| 4 — grille des six avis | 2 167 | 1 700 | **−467** | voir ci-dessous |
| 5 — « Un avis ne remplace pas un devis » | 662 | 641 | −21 | |
| 6 — CTA final | 335 | 335 | 0 | identique |

### Cause des bandes 3 et 4 : trois niveaux typographiques aplatis en un

Relevé d'une carte d'avis, à 320 px, la même des deux côtés (« Devis clair reçu le lendemain… ») :

| Ligne | Maquette | Site |
|---|---|---|
| Citation | **16 px / 25,6 px** | 13 px / 18,85 px |
| Nom de l'auteur | **17 px / 27,54 px** | 13 px / 18,85 px |
| Rôle, société, ville, date | 13 px / 21,06 px, **sur quatre lignes distinctes** | 13 px / 18,85 px, rôle et société **fusionnés** sur une ligne, ville et date absentes |
| Écart entre lignes | 14 px | 12 px |
| Rembourrage, rayon | 26 px, 16 px | 26 px, 16 px ✅ |

Hauteur de carte : **322 px** dans la maquette, **245 px** sur le site. Six cartes → **−462 px**,
ce qui explique à lui seul l'écart de la bande 4.

**La cause n'est pas une valeur mal choisie, c'est un relevé trop grossier.** Le générateur relève
une seule taille de description par grille (`desc_taille`) et l'applique à toutes les lignes de la
carte. La maquette y compose trois niveaux — citation, auteur, métadonnées — et le relevé les
écrase sur le plus petit des trois.

**Correction à faire :** relever la typographie **ligne par ligne** dans les séquences de carte,
puis restituer les métadonnées sur leurs lignes propres. La ville et la date figurent dans les
données du prototype ; rien n'est à inventer.

**Ce qui ne doit PAS être fait :** compenser les 29 px manquants par du rembourrage. Le ratio
remonterait sans qu'aucune carte ne ressemble davantage à la maquette — c'est-à-dire en trichant
sur l'instrument plutôt qu'en corrigeant la page.

---

## 2. `/pourquoi-nous/` à 375 px — page trop LONGUE

| | Maquette | Site | Écart |
|---|---:|---:|---:|
| Hauteur totale | 7 807 px | 8 256 px | **+449 px** |
| Cible 95-105 % | | | 7 417 → 8 197 px |

Il manque **59 px** pour rentrer dans la bande.

### Décomposition par bande

| Bande | Maquette | Site | Écart |
|---|---:|---:|---:|
| 1 — hero | 463 | 702 | **+239** |
| 2 — « Directement joignable » | 1 119 | 1 212 | +93 |
| 3 — « Des preuves plutôt que des slogans » | 552 | 604 | +52 |
| 4 — « Ce qui nous distingue » | 1 855 | 1 918 | +63 |
| 5 — « Les objections » | 546 | 510 | −36 |
| 6 — « Vérifier par vous-même » | 719 | 687 | −32 |
| 7 — « Faisons connaissance » | 335 | 335 | 0 |

Le hero porte l'essentiel : **+239 px**, dont la rangée de commandes que la maquette ne pose pas
sur cette page. Cette rangée est **conservée** — décision du 17 août 2026, reconduite le 19 : c'est
un point de conversion, pas un ornement.

### Le système de boutons est déjà celui de la maquette

Mesure des commandes de hero, à 1440 px :

| | Maquette (hero de l'accueil) | Site (hero institutionnel) |
|---|---|---|
| Hauteur | 61 px | 60 px |
| Rembourrage | 16 px 26 px | 15 px 26 px |
| Taille de police | 16,5 px | 17 px |
| Graisse | 600 | 600 |
| Rayon | 12 px | 12 px |

L'écart est de 1 px de hauteur et d'un demi-point de police : les commandes suivent déjà le système
de la maquette. **Les 59 px ne viendront donc pas d'elles**, et les chercher là reviendrait à
rétrécir des boutons sous la taille du prototype pour gagner une mesure.

**Correction à faire :** les 59 px sont à prendre sur les bandes 2, 3 et 4, dont le cumul dépasse la
maquette de 208 px — un excès d'interlignes ou de marges internes à relever bande par bande, comme
l'a été la typographie des intertitres.

---

## Ce qui est déjà acquis

Le passage de l'en-tête de 141 à 120 px (§5) a retiré 21 px à **toutes** les pages. Il a suffi à
faire rentrer `/pourquoi-nous/` de 106 % à un niveau plus proche de la cible, et il rapproche
`/avis-clients/` de la borne basse. Aucune autre route non légale ne sort de la bande.


---

## Ce qui a été corrigé, et ce que cela a donné

### `/avis-clients/` — de 94 % à 101-104 %

La correction n'a pas été de rallonger la page : elle a été de **rendre les cartes d'avis comme la
maquette les compose**.

Le prototype écrit chaque avis en `<figure>` — une rangée « ★★★★★ + Google », une `<blockquote>`,
puis une `<figcaption>` de deux lignes : le nom, puis « rôle · société, ville · date ». Trois
niveaux typographiques. Le générateur ne relevait qu'**une** taille de description par grille et
l'appliquait à toutes les lignes : les trois niveaux s'écrasaient sur le plus petit, le nom de
l'auteur se retrouvait à la place des étoiles, et la ville comme la date disparaissaient. Le rendu
était **faux**, pas seulement plus court.

Un archétype `temoignage` est donc relevé à part, et rendu par le composant de témoignage — qui a
exactement cette forme. La géométrie de la carte (rembourrage 26 px, rayon 16 px, écart 14 px) est
relevée elle aussi.

Une observation en cours de route a évité de surcorriger : après restauration des trois niveaux, la
page passait à **106-110 %**, cette fois trop longue. La cause était la mention « Exemple de
présentation » répétée **dans chaque carte** alors que la grille l'annonce déjà au-dessus d'elles :
trois lignes × six cartes, soit 350 px pour une information déjà donnée. La mention reste — elle est
exigée — mais une seule fois, là où le visiteur la lit avant les cartes.

| Largeur | 320 | 375 | 768 | 1024 | 1440 | 1920 |
|---|---|---|---|---|---|---|
| Avant | **94 %** | 97 % | 99 % | 98 % | 98 % | 98 % |
| Après | 101 % | 103 % | 103 % | 101 % | 104 % | 104 % |

### `/pourquoi-nous/` — de 106 % à 105 %, sans toucher aux commandes

Le hero dépassait de 239 px. La décomposition a montré deux blocs absents de la maquette :

| Bloc | Maquette | Site | Écart |
|---|---:|---:|---:|
| Surtitre de hero (`.tfp-hero__eyebrow`) | — | 72 px + 10 px de marge | **+82** |
| Rangée de commandes | — | 132 px + 24 px de marge | +156 |

La rangée de commandes est **conservée** : c'est une décision, et le système de boutons est déjà
celui de la maquette (60 px contre 61).

Le surtitre, lui, est un **défaut pur** : le badge région en a été retiré (G26 §9) et la note Google
est masquée (18/08/2026). Le conteneur ne reçoit donc plus rien — et gardait pourtant sa hauteur
minimale, **72 px sous 600 px de large**, plus 16 px de marge. Quatre-vingt-deux pixels de vide
au-dessus du H1, sur les sept pages institutionnelles.

Corrigé par `:not(:has(> *))`, qui vise l'absence d'**enfant** : le conteneur contient des espaces
et des retours à la ligne, et `:empty` ne l'aurait jamais reconnu. Un navigateur sans `:has()`
ignore la règle et retrouve le comportement d'avant — une dégradation, pas une casse.

Les sept pages institutionnelles y gagnent, aux six largeurs :

| Route | 320 | 375 | 768 | 1024 | 1440 | 1920 |
|---|---|---|---|---|---|---|
| `/pourquoi-nous/` | 101 | **105** | 103 | 102 | 103 | 103 |
| `/a-propos/` | 104 | 104 | 104 | 103 | 104 | 104 |
| `/notre-fonctionnement/` | 98 | 102 | 102 | 102 | 103 | 103 |
| `/avis-clients/` | 100 | 102 | 102 | 100 | 102 | 102 |
| `/prestations/` | 101 | 101 | 101 | 100 | 103 | 103 |
| `/recrutement/` | 102 | 103 | 100 | 100 | 103 | 103 |
| `/zones-intervention/` | 98 | 99 | 99 | 100 | 101 | 101 |
