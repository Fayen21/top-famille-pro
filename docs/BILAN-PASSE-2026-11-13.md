# Passe du 13 novembre 2026 — thème 0.16.0

Demandes d'Emmanuel du 13 novembre, appliquées sur la branche `claude/jolly-fermi-d5dryq`
(PR #10). Rien n'est fusionné dans `main`, rien n'est déployé.

## Fait

| Demande | Réalisation | Fichiers |
|---|---|---|
| Clic sur « Prestations » / « Zones d'intervention » = ouvrir les choix | Le libellé ouvre le panneau, sur ordinateur et dans le tiroir mobile. Il reste un lien dans le HTML : sans JavaScript il mène à sa page. La page « Nettoyage professionnel » devient la première entrée du menu Prestations. | `src/js/nav.js`, `site-header.php`, `mobile-nav.php` |
| Bandeau du haut | « Nettoyage de locaux professionnels à Dijon et dans toute la Bourgogne-Franche-Comté » (à partir de 1 100 px de large). | `site-header.php` |
| Retirer « Exemple de présentation… » et toute mention du même type | Plus aucune mention visible : témoignages, portraits, citation, tableau de suivi, mentions légales. Les témoignages gardent leur marquage interne `data-tfp-provisional` et n'alimentent aucune donnée structurée d'avis. | `includes/testimonials.php`, `components.php`, `page-mentions-legales.php` |
| Audrey sans photo | Plus de portrait de banque d'images (accueil, À propos, pilier, contact, devis). Monogramme « AB », remplacé de lui-même par la vraie photo dès qu'elle est saisie. La citation prêtée à Audrey, jamais validée, n'est plus publiée (accueil et À propos) : le bloc dit ce qu'elle fait, en trois rôles. | `includes/customizer.php`, `audrey-reviews.php`, `page-a-propos.php`, `tools/generate-pages.mjs` |
| Photo d'accueil | Espace de bureaux lumineux, salle de réunion en vignette. La scène au masque quitte aussi la carte « Conseils ». Photos du dépôt uniquement. | `build/optimize-images.mjs` |
| Pied de page | Quatre colonnes alignées, mêmes intitulés, un renvoi « → » en bas de chaque colonne, doublon de lien supprimé. | `site-footer.php`, CSS |
| Pages « moches » | Prestations : « Pour qui » et les tâches partent de la même ligne ; la « Réponse directe » devient un encadré aligné sur la page. | CSS |
| « Pourquoi nous » | Six cartes numérotées, trois chiffres en grand sur bande bleu nuit, cartes à liseré. Textes défensifs resserrés. | CSS, `generate-pages.mjs` |
| Plus de couleur | Halos turquoise et cuivre en haut de page, surtitres cuivre, sommaire en pastilles turquoise, puces cuivre, liserés sur les cartes, FAQ ouverte soulignée, bandeau de rappel en dégradé. Palette de CLAUDE.md §4 inchangée ; aucune taille ni marge modifiée par cette couche. | `04-components.css`, `00-tokens.css` |
| FAQ | Accueil : six questions (avec FAQPage). Pilier : trois questions de plus (13). Tarifs : quatre questions de plus (8), dont « Comment est établi mon devis ? » à la place de « Pourquoi pas de simulateur ». Réponses resserrées. Aucun fait nouveau : tarif, frais, exclusions, matériel fourni par le client, devis sous 24 h. | `site-options.php`, `home/faq.php`, `page-tarifs.php`, `generate-pages.mjs` |

## Non fait, et pourquoi

- **Ajouter d'autres avis.** Les textes des six avis authentiques de l'ancien site ne sont pas dans
  le dépôt et le site est injoignable depuis la session ; en écrire d'autres aurait été les
  inventer (CLAUDE.md §5.1). Dès que les textes sont fournis, ils se saisissent dans Réglages →
  Réassurance & avis et remplacent ceux de la maquette.
- **Nouvelle photo venue d'une banque d'images.** Réseau fermé dans cette session.

## À savoir avant la mise en ligne

- Les avis affichés sont toujours ceux de la maquette : **fictifs**. Sans mention, ils se lisent
  comme de vrais avis clients. À remplacer par des avis réels avant publication (CLAUDE.md §10).
- Envoi réel du devis, rendu avec le vrai GeneratePress, Lighthouse sur Hostinger : inchangés,
  toujours à faire en préproduction.

## Tests exécutés (banc local)

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète (`development`) | **1 390 / 1 390** |
| Export navigable : 53 routes hors ligne, 6 069 liens internes, ancres, ressources, démonstration du devis | 0 erreur |
| Recette du devis (`production`, e-mail intercepté) | 23 / 23 |
| Parité dépôt ↔ paquets | 1 259 fichiers concordants |
| Lint PHP | 84 fichiers, 0 erreur |

Un défaut introduit puis corrigé pendant la passe : les nouvelles colonnes du pied faisaient
déborder la page de 34 px entre 820 et 1 100 px (relevé par trois tests).

Tests réécrits parce qu'ils vérifiaient l'ancien comportement, désormais contraire à la demande :
mention visible obligatoire (`provisoire`, `g26`, `g23`), lien « Prestations » qui navigue
(`navigation`, `accessibility`, `passe-visuelle`), portrait et citation (`g24`, `decisions`,
`passe-visuelle`), colonne de 820 px (`g23`), image d'accueil et note du suivi (`passe-commerciale`).

Captures : `docs/captures-passe-2026-11-13/` (375 et 1440 px, menus ouverts).
Paquets : `release/paquets-passe-2026-11-13/`.
