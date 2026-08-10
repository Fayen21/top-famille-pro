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
| `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 → 13 | 7106 → 8466 (119 %) | 1445 → 1536 (106 %) | 17 → 25 | 21 → 36 | 3 → 4 | non | — |

## Détail bloc par bloc à 1440 px

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / BFC / Côte-d'Or / Beaune) | (Accueil/Zones d'intervention/Côte-d’Or) | 42 → 57 | ≈ proche |
| 2 | Entreprise de nettoyage à Beaune | Entreprise de nettoyage à Beaune | 474 → 546 | ⚠️ écart +72 px |
| 3 | (27 € HT/htarif unique en région✓Devis ) | (27 € HT/h tarif unique en région Voir ) | 186 → 216 | ≈ proche |
| 4 | (Réponse directeBeaune est une commune ) | (Réponse directe Beaune est une commune) | 323 → 289 | ≈ proche |
| 5 | Beaune, second pôle de notre présence en Côte- | Beaune, second pôle de notre présence en Côte- | 1059 → 1162 | ⚠️ écart +103 px |
| 6 | Nos prestations sur place | Nos prestations sur place | 640 → 935 | ⚠️ écart +295 px |
| 7 | Tarif et exemple local | Tarif et exemple local | 478 → 564 | ⚠️ écart +86 px |
| 8 | Hébergements et locations meublées | Hébergements et locations meublées | 1174 → 1031 | ⚠️ écart -143 px |
| 9 | Quartiers et zones d'activité | Quartiers et zones d'activité | 228 → 446 | ⚠️ écart +218 px |
| 10 | Dans le même département | Dans le même département | 386 → 845 | ⚠️ écart +459 px |
| 11 | Questions fréquentes — Beaune | Questions fréquentes — Beaune | 684 → 782 | ⚠️ écart +98 px |
| 12 | Nous contacter | Nous contacter | 291 → 246 | ≈ proche |
| 13 | Un devis pour vos locaux | Un devis pour vos locaux | 319 → 363 | ≈ proche |

