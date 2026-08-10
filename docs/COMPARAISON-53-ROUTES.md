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
| `#/nos-tarifs` | `/tarifs/` | 13 → 13 | 5852 → 6151 (105 %) | 951 → 962 (101 %) | 10 → 16 | 24 → 51 | 2 → 3 | non | [voir](captures/comparaison/nos-tarifs-1440.jpg) |

## Détail bloc par bloc à 1440 px

### `#/nos-tarifs` → `/tarifs/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Nos tarifs) | (Accueil/Nos tarifs) | 42 → 57 | ≈ proche |
| 2 | Nos tarifs de nettoyage professionnel | Nos tarifs de nettoyage professionnel | 362 → 301 | ⚠️ écart -61 px |
| 3 | (Tarif horaire de base27 € HT/hIdentiqu) | (Tarif horaire de base 27 € HT/h Identi) | 277 → 302 | ≈ proche |
| 4 | (Le nettoyage professionnel est facturé) | (Le nettoyage professionnel est facturé) | 277 → 204 | ⚠️ écart -73 px |
| 5 | (Ce tarif s'applique au périmètre décri) | (Ce tarif s'applique au périmètre décri) | 131 → 180 | ≈ proche |
| 6 | Le détail de nos frais | Le détail de nos frais | 638 → 623 | ≈ proche |
| 7 | Ce qui est inclus | Ce qui est inclus | 313 → 426 | ⚠️ écart +113 px |
| 8 | Ce qui influence le volume d'heures | Ce qui influence le volume d'heures | 403 → 302 | ⚠️ écart -101 px |
| 9 | Trois exemples de budgets | Trois exemples de budgets | 606 → 632 | ≈ proche |
| 10 | Comparer plusieurs besoins en un coup d'œil | Comparer plusieurs besoins en un coup d'œil | 492 → 523 | ≈ proche |
| 11 | Questions sur les tarifs | Questions sur les tarifs | 745 → 868 | ⚠️ écart +123 px |
| 12 | Avant de demander votre devis | Avant de demander votre devis | 405 → 385 | ≈ proche |
| 13 | Recevez un devis clair et chiffré | Recevez un devis clair et chiffré | 339 → 363 | ≈ proche |

