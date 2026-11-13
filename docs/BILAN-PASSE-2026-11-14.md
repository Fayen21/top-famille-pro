# Passe du 14 novembre 2026 — thème 0.16.1

Branche `claude/jolly-fermi-d5dryq` (PR #10). Rien n'est fusionné dans `main`, rien n'est déployé.

## 1. Gérante : section conservée, sans aucun visuel

Demande : supprimer la section, ou la refaire sans photo. Elle est refaite **sans photo ni
monogramme** — aucun élément ne tient lieu de portrait.
- Accueil : surtitre, nom et rôle, présentation, deux boutons ; à droite, ses trois missions (devis,
  cahier des charges, suivi).
- À propos : fiche texte (nom, fonction, trois missions, téléphone, siège).
- Contact et devis : prénom et rôle, sans pastille.
- Si une vraie photo est un jour saisie dans le Customizer, elle s'affiche ; sinon rien.

Fichiers : `includes/customizer.php`, `page-a-propos.php`, `src/css/04-components.css`.

## 2. Avis : pas de nouveaux avis fictifs

Demande refusée : écrire de faux avis présentés comme de vrais avis clients tromperait les
visiteurs (pratique commerciale trompeuse) et contrevient à CLAUDE.md §5.1.

Corrigé en revanche, parce que c'était faux et vérifiable : les avis de la maquette portaient la
mention **« Google »** et une **date** (« mars 2026 »). Ni l'une ni l'autre ne sont plus affichées.

## 3. Balayage des 53 pages

| Contrôle | Méthode | Résultat |
|---|---|---|
| Mentions « provisoire », « temporaire », « à venir », « exemple de présentation », « en cours », « démonstration », « maquette », crochets, etc. — texte et attributs `alt`, `title`, `aria-label`, `placeholder`, méta | `tools/scan-mentions.mjs`, 53 routes | 0 mention de chantier. 5 emplois normaux restants : « suspension temporaire », « renfort temporaire », « allongement temporaire », IP « utilisée de façon temporaire », et « Seuls des avis authentiques et autorisés y seront publiés » (page Avis) |
| Débordements, images cassées, éléments tronqués | `tools/revue-visuelle.mjs`, 53 routes × 375 / 768 / 1 440 px = 159 écrans | 0 alerte |
| Liens internes, ancres, ressources | `tools/export-statique.mjs`, 6 069 liens | 0 lien mort, 0 ancre introuvable, 0 ressource manquante |
| Lecture à l'œil | planches de l'accueil, du pilier, d'une prestation, des tarifs, d'une ville, d'un département, du hub des zones, des avis, du fonctionnement, du contact, des conseils, d'un article, du recrutement | 7 défauts trouvés, corrigés ci-dessous |

### Défauts trouvés et corrigés
1. **Accueil** : le texte d'introduction des prestations touchait les cartes (0 px) → 24 px.
2. **Renvois « Libellé → »** (pilier, zones, articles) : la flèche était repoussée à l'autre bout de
   la ligne → à 8 px du libellé.
3. **Pilier, section repliable à deux blocs** : second titre plus gros que celui de la section et
   décalé → même ligne de départ, taille d'intertitre.
4. **Pilier** : « 9 € / HT/mois » se coupait en fin de ligne → montants et unités insécables.
5. **Pilier** : lien « Hub régional » (terme de chantier) → « Toute la Bourgogne-Franche-Comté ».
6. **Tarifs** : « Aucun simulateur » → « Devis étudié personnellement par Audrey » (CLAUDE.md §9).
7. **Avis** : mention « Google » et dates sur des avis de la maquette → retirées (voir §2).

### Relevé, non corrigé — à décider
- **Avis fictifs** : toujours affichés (38 pages), sans mention. Deux d'entre eux apparaissent deux
  fois sur la page Avis. L'avis de l'accueil est accompagné d'une photo de visage de banque d'images.
- **Pages de ville et de département** : le texte courant est dans une colonne de lecture centrée
  (820 px) alors que le hero et les grilles sont alignés à gauche sur 1 260 px. C'est la composition
  de la maquette ; l'aligner partout est un changement de mise en page à part entière.
- **Fonctionnement** (« Modifier, suspendre ou arrêter ») et **Tarifs** (« Ce qui influence le volume
  d'heures ») : la quatrième carte se retrouve seule sur sa rangée.
- **Recrutement** : seule page qui montre encore la scène de nettoyage au masque.
- **Page Avis** : « Seuls des avis authentiques et autorisés y seront publiés » au-dessus d'avis qui
  ne le sont pas.

## 4. Tests exécutés (banc local)

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète (`development`) | **1 390 / 1 390** |
| Export navigable (`production`) : 53 routes, liens, ancres, démonstration du devis | 0 erreur |
| Parité dépôt ↔ paquets | 1 259 fichiers concordants |

Non rejoués dans cette passe : recette serveur du devis (inchangé depuis 23/23), Lighthouse.

Captures : `docs/captures-passe-2026-11-14/`. Paquets : `release/paquets-passe-2026-11-14/`.
