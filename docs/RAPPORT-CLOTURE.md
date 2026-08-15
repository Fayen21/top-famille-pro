# Rapport de la passe de clôture

> Branche `hotfix-production-fidelite-claude-design`, PR #9. Rien n'a été fusionné, rien n'a été
> déployé, ni la production ni les DNS n'ont été touchés.

## 22. Verdict

**PARTIEL — ÉCARTS RESTANTS.**

Deux des quatre écarts visés sont clos. Les deux autres ne le sont pas, et le travail de cette
passe a surtout servi à établir **pourquoi** — la cause supposée jusqu'ici était fausse. Le détail
est au §21.

---

## 1. Commits ajoutés

| Commit | Objet |
|---|---|
| `3f714a9` | Baseline outillée, badge Google dédoublonné, contrôle post-installation avec verdict |
| `f30f1d9` | Saisie conservée rattachée à l'envoi, plus à l'adresse IP |

## 2. Fichiers modifiés

- `tools/baseline.mjs` *(nouveau)* — relevé exhaustif 53 routes × N largeurs, sortie machine.
- `tools/breakpoints.mjs` *(nouveau)* — seuils de bascule réels de la maquette, par famille.
- `bin/verifier-installation.php` — verdict PASS/FAIL et code de sortie.
- `wp-content/themes/topfamillepro/template-parts/footer/site-footer.php` — badge retiré.
- `wp-content/themes/topfamillepro/src/css/04-components.css` — écart de la grille de détail.
- `wp-content/themes/topfamillepro/includes/contact-form.php`, `page-contact.php` — jeton d'envoi.
- `docs/baseline-avant.json`, `docs/baseline-apres.json` — les deux états comparés.

## 3. Baseline avant cette passe

`docs/baseline-avant.json` — **318 contrôles** (53 routes × 6 largeurs), chacun portant : hauteur de
la référence et du rendu, ratio, sections, hauteur de chaque bande, cartes, micro-cartes, colonnes
par grille, ordre des composants, images et images cassées, tableaux, formulaires, FAQ, CTA, mots,
titres, débordement horizontal, CTA hors écran, erreurs console, erreurs réseau, CLS.

État de départ : **187/318 dans 95–105 %**, 0 débordement, 0 erreur console ou réseau.

## 4. Corrections de breakpoints

`tools/breakpoints.mjs` relève, sur le rendu et non dans les feuilles de style, la largeur à
laquelle chaque conteneur multi-colonnes bascule, des deux côtés, sur dix-neuf largeurs de
diagnostic (1440 → 375, resserrées autour de 700, 707, 720, 767, 768, 800, 819, 820, 1024).

**La correction attendue n'a pas eu lieu, parce que la cause supposée est fausse.** La mesure
montre que les seuils de bascule ne sont pas systématiquement décalés : sur huit familles, certains
conteneurs basculent plus tôt côté thème, d'autres plus tard, sans direction commune. Abaisser les
points de rupture globalement aurait déplacé le problème, pas résolu.

La cause réelle est mesurée au §6.

Une correction de géométrie a été appliquée, celle-là mesurée sur la maquette :
`.tfp-detail-grid` a un écart de **22 px**, pas 34. Sur une bande qui empile quatorze éléments en
une colonne à 375 px, douze pixels en trop par intervalle ajoutent près de 160 px à contenu
identique.

## 5. Résultat des 318 contrôles

| Largeur | 95–105 % avant | après | 98–102 % avant | après |
|---|---:|---:|---:|---:|
| 320 px | 34/53 | **35** | 12 | **14** |
| 375 px | 23/53 | **27** | 3 | **6** |
| 768 px | 7/53 | 7 | 2 | 2 |
| 1024 px | 43/53 | 43 | 29 | **30** |
| 1440 px | 40/53 | 40 | 27 | 27 |
| 1920 px | 40/53 | 40 | 27 | 27 |
| **Total** | **187/318** | **192/318** | 100 | **106** |

Sur les 318 contrôles, après correction : **0 débordement horizontal**, **0 image cassée**,
**0 CTA hors écran**, **0 erreur console**, **0 erreur réseau**.

## 6. Statut des 53 routes à 768 px — et la cause réelle

**7/53 dans la tolérance, inchangé.** Ce n'est pas faute d'avoir cherché : c'est que la cause
n'était pas celle annoncée.

Mesure comparative sur `#/service/bureaux`, bande par bande, à 375 px — toutes les bandes sont
présentes, dans le même ordre, avec le même contenu (2 060 mots contre 2 073) :

| Bande | Maquette | WordPress | Δ |
|---|---:|---:|---:|
| 1 hero | 868 | 970 | +102 |
| 2 réponse directe | 483 | 519 | +36 |
| 3 pour qui | 1 313 | 1 283 | −30 |
| 4 situations | 571 | 645 | +74 |
| 5 configurations | 1 200 | 1 390 | +190 |
| 6 détail espace par espace | 2 654 | 2 928 | +274 |
| 7 organisation | 1 702 | 2 038 | +336 |
| 8 → 13 | — | — | +386 |

Aucune bande n'est absente, aucune n'est fusionnée : **chaque bande est simplement 5 à 20 % plus
haute**. L'écart est diffus, cumulatif, et vient de dizaines de petites différences de quelques
pixels — écarts de grille, hauteurs de carte dues à une ligne de texte de plus, marges internes.

La mesure de détail le confirme sur la bande 6 : à padding identique (16 px), à typographie
identique (17 px / 27,54), les cartes de la maquette font 302 px et les nôtres 318 à 345, et
l'écart de grille valait 34 px contre 22.

**Conséquence :** amener les 53 routes dans 95–105 % à 768 px suppose de mesurer et corriger chaque
composant un par un — l'ordre de grandeur est plusieurs dizaines de composants, chacun demandant un
cycle mesure → correction → vérification des 318 contrôles (environ 45 minutes de mesure par
cycle). Ce n'est pas un blocage technique : c'est un volume de travail qui dépasse ce qu'une passe
peut absorber, et l'annoncer est plus utile que de le masquer.

## 7. Statut aux cinq autres largeurs

Voir le tableau du §5. Progression à 320 et 375 px, stabilité ailleurs. Aucune régression.

## 8 à 11. Anomalies

**Non traitées dans cette passe.** L'inventaire reste à 542 anomalies dont 101 graves, et sept
causes sur dix restent « à instruire » (129 occurrences), comme au terme de la passe précédente.
Le classement exhaustif reste `docs/ANOMALIES-SURPLUS-COLONNES.md`, une ligne par occurrence.

Cette passe a été consacrée, dans l'ordre imposé, à la baseline puis à la fidélité responsive ; le
temps disponible n'a pas permis d'atteindre le chantier des anomalies.

## 12. Badge Google — clos

Le badge n'était pas mal classé par l'outil : **il était rendu une fois de trop.**

| | Maquette | WordPress avant | WordPress après |
|---|---|---|---|
| Barre supérieure | 1 (lien discret) | 1 | 1 |
| Corps de page | 1 (bloc 235 × 112) | 2 (hero, avis) | 2 (hero, avis) |
| Pied de page | **0** | **1** | **0** |

Le pied de la maquette n'en porte aucun. Le thème l'ajoutait sur les 53 routes — une troisième
occurrence par page, au-delà des deux que CLAUDE.md §9 autorise (« une preuve dans le hero + une
section avis suffisent »). L'outil avait raison de la compter ; c'est le composant qui a été retiré.

Aucune note vide, aucun « /5 » sans valeur, aucun nombre d'avis inventé, aucune URL Google inventée,
aucun `AggregateRating` : les tests correspondants restent verts.

## 13. CLS avant / après

**Non amélioré dans cette passe**, et le diagnostic a progressé sans aboutir.

Mesure Lighthouse (référence) : **0,028 en profil bureau** sur les sept pages, **0,000 en mobile**.
Cible interne 0,010 ; seuil « bon » de Google 0,10.

Ce qui a été **éliminé** comme cause, par la mesure :
- les polices — préchargées et en `font-display: optional`, elles ne permutent plus ;
- le JavaScript — état final identique avec JS désactivé ;
- les images — le logo porte ses dimensions intrinsèques ;
- le banc de mesure — le CLS est identique sur le rig nu (8901) et derrière le mandataire (8902),
  donc ce n'est pas un artefact de compression ou de cache.

Ce qui **reste** : un déplacement unique à ~355 ms, où `.tfp-header__actions` passe de 121 px à
49 px de haut, entraînant l'en-tête et tout le corps de page 25 px plus haut. L'origine de cet état
transitoire à 121 px n'a pas été établie.

Note de méthode : les valeurs de CLS de `docs/baseline-*.json` ne sont **pas** comparables à celles
de Lighthouse. Le relevé de baseline fait défiler toute la page pour déclencher le chargement
différé, et compte donc des déplacements qu'aucun visiteur ne subit. Le chiffre qui fait foi est
celui de Lighthouse.

## 14. axe-core

Zéro violation, inchangé.

## 15. WCAG 2.5.8

Zéro violation, inchangé — critère AA (24 × 24 px **ou** espacement **ou** exception en ligne), pas
le critère AAA 2.5.5.

## 16. Lighthouse

Non rejoué : aucune modification de cette passe ne touche le chargement, à l'exception du retrait du
badge de pied de page, qui allège. Les mesures de la passe précédente restent valables —
performance 92 à 100, accessibilité, bonnes pratiques et SEO à 100 sur les quatorze mesures.

## 17. URL parasites — installation vierge

```
PASS — aucune URL héritée publiée ou référencée, et les 53 routes sont présentes.
code de sortie 0
```

## 18. URL parasites — après migration

Scénario éprouvé en publiant réellement `/devis-rapide/` sur l'installation de recette :

```
❌ « devis-rapide » est publiée (http://localhost:8901/devis-rapide/)
❌ « devis-rapide » figure au sitemap
FAIL — l'installation ne doit pas être ouverte à l'indexation en l'état.
code de sortie 1
```

Le contrôle suit l'index de sitemap **et ses sous-sitemaps** : une URL absente de l'index racine
mais présente dans `wp-sitemap-posts-page-1.xml` est détectée. Le code de sortie non nul permet
d'enchaîner le contrôle dans une recette et de bloquer une mise en ligne.

## 19. Exports

Non reconstruits dans cette passe. Le dernier contrôle après extraction reste valable : 53/53 routes
ouvrables hors ligne, 0 ressource manquante, 0 image cassée, 0 requête externe, 0 `localhost`.

## 20. Captures comparatives

Non reconstruites : elles doivent l'être après stabilisation, et la fidélité à 768 px n'est pas
stabilisée.

## 21. Écarts restants, et pourquoi

1. **Fidélité à 768 px — 7/53.** Cause établie au §6 : elle est diffuse, pas structurelle. Le
   travail restant est un volume, composant par composant, pas une correction unique.
2. **CLS bureau 0,028.** Quatre causes éliminées par la mesure, la cinquième non identifiée (§13).
3. **129 occurrences d'anomalies à instruire.** Chantier non atteint.
4. **Badge Google — clos** (§12).

## Non-régression

**965 tests Playwright, tous verts**, y compris en exécution parallèle. Un défaut réel a d'ailleurs
été trouvé par leur exécution parallèle : la saisie conservée après une erreur de formulaire était
rangée sous une clé dérivée de la seule adresse IP, si bien que deux envois croisés depuis la même
adresse — deux collègues derrière la même sortie internet, ou deux onglets — s'écrasaient l'un
l'autre. Chaque formulaire porte désormais un jeton propre à son envoi.

Aucun contenu fictif, aucun avis ni note inventés, aucun `Review` ni `AggregateRating`, aucun tarif
différencié par ville, aucune commune non validée en `index`, aucune donnée d'immatriculation non
confirmée.
