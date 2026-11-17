# Passe du 17 novembre 2026 — thème 0.17.0

Demandes d'Emmanuel du 17 novembre. Branche `claude/jolly-fermi-d5dryq` (PR #10).
Rien n'est fusionné dans `main`, rien n'est déployé.

## 1. Tarif : 26 € HT/h au lieu de 27 €

- Source : `includes/site-options.php` (`price_unique` 26, affichage « 26 € ») — tout ce que le thème
  calcule en découle (cartes, bandeaux, exemples, tableau des articles, données structurées
  `priceRange`).
- Contenus relevés sur la maquette : un module commun, `tools/lib/tarif.mjs`, réécrit le tarif ET
  les montants qui en dérivent avec la même règle que le thème (heures × 26 + 9 € de gestion ;
  premier mois + 50 € ; main-d'œuvre seule pour le ponctuel). Branché dans les quatre générateurs ;
  les quatre jeux de contenus ont été régénérés, les anciens fichiers de contenu (phases 2 à 4)
  retraités par le même module.
- Montants recalculés : 8 h 217 € (premier mois 267 €), 10 h 269 €, 12 h 321 € (371 €), 16 h 425 €,
  20 h 529 € (579 €), 6 h 165 €, ponctuel 7 h 182 € de main-d'œuvre.
- Contrôle : sur les 53 pages, **0** montant ancien (27, 225, 333, 549, 279, 441, 171, 383, 275,
  599, 189 €).
- `PROJECT_INPUTS.md` §5 (nouvelle grille en tête, l'ancienne conservée comme historique) et la ligne
  « tarif affiché » de `CLAUDE.md` §8 sont mises à jour.

Frais inchangés : 9 € HT/mois de gestion, 50 € HT de mise en place, 0,35 € HT/km, +10 %.

## 2. Alignements — toutes les pages

Nouvel outil `tools/scan-alignements.mjs` : sur les 53 pages, chaque section doit partir du bord
gauche du logo (bord visuel : cadre d'une carte, premier caractère d'un texte, premier élément d'une
liste), et deux titres côte à côte doivent partir de la même hauteur.

| Largeur | Avant | Après |
|---|---|---|
| 1 440 px | 132 défauts | **0** |
| 1 024 px | — | **0** |
| 768 px | — | **0** |
| 375 px | — | **0** |

Causes corrigées :
- **Colonnes étroites centrées** (820 / 900 px) : le conteneur garde désormais la largeur de la page
  et la largeur demandée devient une mesure de lecture alignée à gauche (`03-layout.css`). C'était
  l'image 4 (hub des zones), les articles, les pages légales, les FAQ.
- **Fil d'Ariane** décalé de 40 px sur toutes les pages (double retrait).
- **Deux colonnes de texte** centrées verticalement (images 1 et 3) : alignées en haut.
- **Blocs côte à côte** séparés par une marge d'empilement (36 px de décalage).
- **FAQ** (image 2) : sur deux colonnes, pleine largeur, avec le rappel de contact intégré.
- Grilles : plus aucune carte seule sur sa rangée (`tools/scan-orphelines.mjs`, 0) ; 4 éléments en
  2 + 2, 5 en 3 + 2, 6 en 3 + 3 ; volets « Dans le détail » sur deux colonnes ; chiffres de
  « Pourquoi nous » et facteurs des Tarifs sur toute la largeur.

## 3. FAQ enrichies

| Page | Avant | Après |
|---|---|---|
| Prestations (×6) | 8 | 14 |
| Villes et départements (×26) | 7 | 12 |
| Accueil | 6 | 10 |
| Articles (×3) | 3 | 6 |
| Devis | 0 | 6 |

Les questions ajoutées (tarif, matériel, devis, engagement, horaires, absence, exclusions) ne
reprennent que des faits validés et ne s'ajoutent que si la page n'y répond pas déjà. Elles
alimentent aussi le `FAQPage`. Présentation : en-tête, deux colonnes, repère « + / − ».

## 4. Page « Demander mon devis »

Surtitre, trois garanties (gratuit, 24 h, étudié par Audrey), formulaire dans un panneau, colonne
de droite : téléphone, « Après votre demande » en quatre étapes, tarif et ce qu'il comprend ; FAQ de
six questions sous le formulaire (avec `FAQPage`). Formulaire et protections inchangés ; jauge
d'étape corrigée sur mobile.

## 5. Esthétique

Bouton principal en dégradé avec relief au survol, images des cartes qui s'animent au survol
(désactivé si l'utilisateur réduit les animations), ombre douce sur les visuels de hero et les
cartes, halo cuivre sur les bandes turquoise.

## 6. Tests exécutés (banc local)

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète (`development`) | 1 389 / 1 390, puis le test des vignettes du pilier mis à jour (3 + 3 voulu) : **4 / 4** |
| Alignements, 53 pages × 4 largeurs | 0 défaut |
| Cartes orphelines, 53 pages | 0 |
| Anciens montants à 27 €, 53 pages | 0 |
| Revue visuelle, 159 écrans | 0 alerte |
| Recette serveur du devis (`production`) | 23 / 23 |
| Export : 53 routes, 6 070 liens, ancres, démonstration | 0 erreur |
| Parité dépôt ↔ paquets | 1 286 fichiers |

Tests mis à jour pour le nouveau tarif et la grille 3 + 3 : `tarifs`, `passe-commerciale`,
`passe-visuelle`, `corrections-zip`, `vignettes-pilier`.

## Toujours ouvert

- Avis de la maquette toujours affichés : à remplacer par des avis réels, ou à retirer.
- Préproduction : envoi réel du devis, vrai thème parent, Lighthouse (non rejoué cette passe).

Captures : `docs/captures-passe-2026-11-17/`. Paquets : `release/paquets-passe-2026-11-17/`.
