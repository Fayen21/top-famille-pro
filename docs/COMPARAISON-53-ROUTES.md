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
| `#/conseils` | `/conseils/` | 7 → 7 | 2834 → 3410 (120 %) | 465 → 472 (102 %) | 3 → 12 | 15 → 32 | 5 → 6 | non | — |

## Détail bloc par bloc à 1440 px

### `#/conseils` → `/conseils/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Conseils) | (Accueil/Conseils) | 42 → 57 | ≈ proche |
| 2 | Conseils & repères | Conseils & repères | 339 → 337 | ✅ identique |
| 3 | (Toutes les catégories Bureaux Tarifs O) | (Toutes les catégories Bureaux Tarifs O) | 75 → 145 | ⚠️ écart +70 px |
| 4 | (À la une · Bureaux À quelle fréquence ) | À quelle fréquence faire nettoyer ses bureaux  | 427 → 578 | ⚠️ écart +151 px |
| 5 | Les autres articles | Les autres articles | 642 → 723 | ⚠️ écart +81 px |
| 6 | Passer du conseil à votre situation | Passer du conseil à votre situation | 314 → 368 | ≈ proche |
| 7 | (Un besoin précis pour vos locaux ?Nos ) | (Un besoin précis pour vos locaux ? Nos) | 174 → 218 | ≈ proche |

