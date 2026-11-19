# Passe du 15 novembre 2026 — thème 0.16.2

Trois points relevés par le balayage du 14 novembre, corrigés à la demande d'Emmanuel.
Branche `claude/jolly-fermi-d5dryq` (PR #10). Rien n'est fusionné dans `main`, rien n'est déployé.

## Corrections

| Point | Avant | Après |
|---|---|---|
| **Pages de ville et de département** (26 pages) | Le texte courant, la FAQ et le bloc de contact vivaient dans une colonne de 900 px centrée, entre un haut de page et des grilles alignés à gauche sur 1 260 px. | Tout part du même bord gauche. Les chapitres se rangent sur deux colonnes (un chapitre seul prend la largeur, texte limité à 880 px), les volets et les questions aussi. Sous 900 px de large, rien ne change : une colonne. Dijon passe de 6 570 à 5 811 px de haut à 1 440 px. |
| **Cartes seules sur leur rangée** | Fonctionnement (« Modifier, suspendre ou arrêter ») et Tarifs (« Ce qui influence le volume d'heures ») : 3 + 1. | 2 + 2. Le contrôle étendu aux 53 pages a trouvé un troisième cas, le plan du site (5 + 1), passé en 3 + 3. |
| **Recrutement** | Dernière page à montrer la scène de nettoyage au masque. | Photo d'équipe autour d'une table (visuel du dépôt), texte alternatif exact. |

Fichiers : `src/css/04-components.css`, `includes/setup.php` (classe de page générique),
`build/optimize-images.mjs`, `page-recrutement.php`. Nouvel outil : `tools/scan-orphelines.mjs`.

## Tests exécutés (banc local)

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète (`development`) | 1 388 réussis et 2 échecs attendus (ancienne photo de Recrutement, paquet sans les nouvelles images), corrigés puis rejoués : **1 390 / 1 390** en deux exécutions |
| Cartes orphelines, 53 pages à 1 440 px | 0 |
| Mentions de chantier, 53 pages | 0 (5 emplois normaux de « temporaire » / « seront publiés ») |
| Export navigable (`production`) : 53 routes, 6 069 liens, ancres, démonstration du devis | 0 erreur |
| Parité dépôt ↔ paquets | 1 286 fichiers concordants |

Non rejoués : recette serveur du devis, Lighthouse.

## Toujours ouvert

- Avis : ceux de la maquette restent affichés, sans mention ; à remplacer par des avis réels ou à
  retirer avant mise en ligne. Phrase de la page Avis à revoir en conséquence.
- Préproduction : envoi réel du devis, vrai thème parent, Lighthouse. Photos à fournir.

Captures : `docs/captures-passe-2026-11-15/`. Paquets : `release/paquets-passe-2026-11-15/`.
