# Les deux routes non légales hors bande — causes mesurées

> Complément à `docs/RECONCILIATION-RATIOS.md`. Établi le 19 août 2026.
> Objectif de la passe : **300 / 318**, c'est-à-dire les 50 routes non légales dans 95-105 % aux
> six largeurs, les trois pages légales seules autorisées hors tolérance.

Deux contrôles sur 318 sortent de la bande sans être une page légale. Ils sont diagnostiqués ici
jusqu'à la cause, mesure à l'appui — pas estimés.

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
