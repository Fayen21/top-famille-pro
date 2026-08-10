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
| `#/service/ponctuel` | `/prestations/ponctuel/` | 14 → 14 | 7588 → 8032 (106 %) | 1950 → 1941 (100 %) | 31 → 33 | 25 → 39 | 3 → 4 | non | [voir](captures/comparaison/service-ponctuel-1440.jpg) |

## Détail bloc par bloc à 1440 px

### `#/service/ponctuel` → `/prestations/ponctuel/`

| # | Bloc maquette | Bloc WordPress | Hauteur | État |
|---|---|---|---|---|
| 1 | (Accueil / Prestations / Ponctuel) | (Accueil/Prestations/Ponctuel) | 42 → 57 | ≈ proche |
| 2 | Nettoyage ponctuel et remise en état | Nettoyage ponctuel et remise en état | 483 → 546 | ⚠️ écart +63 px |
| 3 | (Réponse directeCertaines situations de) | (Réponse directe Certaines situations d) | 363 → 331 | ≈ proche |
| 4 | Pour qui ? | Pour qui ? | 561 → 629 | ⚠️ écart +68 px |
| 5 | Les situations concrètes que nous traitons | Les situations concrètes que nous traitons | 360 → 425 | ⚠️ écart +65 px |
| 6 | Trois configurations, trois organisations | Trois configurations, trois organisations | 606 → 560 | ≈ proche |
| 7 | Le détail, espace par espace et contrainte par | Le détail, espace par espace et contrainte par | 1136 → 1162 | ≈ proche |
| 8 | Une organisation carrée, du planning au suivi | Une organisation carrée, du planning au suivi | 744 → 670 | ⚠️ écart -74 px |
| 9 | Une semaine type | Une semaine type | 452 → 358 | ⚠️ écart -94 px |
| 10 | (Exemple · 12 h/mois333 € HT/mois12 h ×) | (Exemple · 12 h/mois 333 € HT/mois 12 h) | 425 → 390 | ≈ proche |
| 11 | Cette prestation près de chez vous | Cette prestation près de chez vous | 384 → 434 | ≈ proche |
| 12 | Questions fréquentes — Ponctuel | Questions fréquentes — Ponctuel | 797 → 937 | ⚠️ écart +140 px |
| 13 | (Encore une question sur Ponctuel ? Aud) | (Encore une question sur Ponctuel ? Aud) | 97 → 187 | ⚠️ écart +90 px |
| 14 | Un devis pour Ponctuel | Un devis pour Ponctuel | 317 → 363 | ≈ proche |

