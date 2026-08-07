# MAILLAGE.md — Matrice de maillage interne

> Produit en phase 4 (PROMPT-PHASES.md). Audite les liens garantis par le brief phase 4 sur les 53
> pages réelles du site, corrige les manques trouvés, documente ce qui reste hors de portée
> honnêtement (plutôt que de l'inventer).

## Méthode

Le site est généré par une douzaine de gabarits PHP, pas 53 fichiers indépendants : auditer le
maillage consiste donc à vérifier chaque **famille** de page une fois (le lien, ou son absence, se
répète ensuite identiquement sur toutes les pages de la famille), plus les pages statiques
uniques individuellement. Vérifié par lecture du code des gabarits **et** par inspection du HTML
rendu dans un WordPress réel (même environnement de test que les phases précédentes).

## Liens garantis par le brief — état après phase 4

| Paire | Sens | État avant phase 4 | Correction |
|---|---|---|---|
| Prestations ↔ Tarifs | prestation → tarifs | ✅ déjà présent (« Voir la page Tarifs complète ») | — |
| Prestations ↔ Tarifs | tarifs → prestations | ⛔ absent | Grille des 6 prestations ajoutée sur `/tarifs/` |
| Prestations ↔ Villes prioritaires | prestation → villes | ⛔ champ `villes_prioritaires` jamais renseigné (le gabarit le rendait déjà, aucune valeur n'y était écrite) | Renseigné sur les 6 prestations avec les 10 villes réelles validées (`bin/seed-phase4-maillage.php`) |
| Région ↔ Départements | hub `/zones-intervention/` → départements | ✅ déjà présent (phase 3, grille de cartes) | — |
| Région ↔ Départements | page région → départements | ⛔ absent (la page ne citait les 8 départements qu'en texte, sans lien) | Grille des 8 départements ajoutée sur la page région |
| Région ↔ Départements | département → page région | 🟡 couvert uniquement par la navigation d'en-tête (menu « Zones ») | Lien contextuel ajouté (« ← Voir toute la région ») pour un maillage plus fort que la seule nav globale |
| Départements ↔ Villes | département → villes du département | ✅ déjà présent (phase 2/3, requête des zones filles) | — |
| Départements ↔ Villes | ville → département parent | ✅ déjà présent (« ← Voir tout le département ») | — |
| Villes ↔ Communes proches | ville → communes proches | ✅ pour Dijon (8 communes liées, phase 3) · 🟡 pour les 9 autres villes : aucune commune secondaire créée dans ces départements (aucune n'existe sur une source réelle, CLAUDE.md §5.4) — champ vide, pas une erreur | — (rien à lier tant qu'aucune autre commune n'est validée) |
| Articles ↔ Prestations | article → prestations liées | ⛔ absent (aucun mécanisme de relation) | Nouveau champ `_tfp_related_prestation` (`includes/articles-meta.php`, postmeta multi-lignes, ACF-free comme les autres champs d'article) + rendu sur `single.php` |
| Articles ↔ Prestations | prestation → articles liés | ⛔ absent | `tfp_get_prestation_related_articles()` (requête inverse sur le même champ) + rendu sur `single-prestation.php` (« Nos conseils sur ce sujet ») |
| Toutes les pages → page pilier | — | ✅ déjà présent : la navigation d'en-tête (`template-parts/header/site-header.php`, `$main_nav`) inclut « Nettoyage professionnel » et s'affiche sur les 53 pages via `get_header()` | — |
| Tous les CTA → demande de devis | — | ✅ déjà présent partout via `tfp_button(['href' => home_url('/demande-de-devis/')])`, header, barre CTA mobile, blocs CTA de fin de page | — |
| 3 cartes « Conseils & repères » (accueil) → leur article individuel | — | ✅ déjà correct depuis la phase 1 (`template-parts/home/advice.php`), pas de régression trouvée | — |

## Rattachement des 3 articles aux prestations

Deux articles sont spécifiquement liés à une prestation (bureaux), le troisième est générique :

| Article | Prestation(s) liée(s) | Justification |
|---|---|---|
| À quelle fréquence faire nettoyer ses bureaux ? | Nettoyage de bureaux | Contenu spécifiquement rédigé pour les bureaux |
| Combien coûte le nettoyage de bureaux ? | Nettoyage de bureaux | Idem |
| Comment rédiger un cahier des charges de nettoyage ? | Les 6 prestations | Méthode générique, applicable à tout type de local — lier uniquement aux bureaux aurait été arbitraire |

Aucune fausse relation créée pour les 4 autres prestations avec les 2 premiers articles : leur
contenu (fréquence et coût spécifiquement dimensionnés pour des bureaux) ne s'applique pas
littéralement aux commerces, cabinets, copropriétés, locations meublées ou ponctuel — les y lier
aurait été un maillage mécanique, pas un maillage utile.

## Pages orphelines

Aucune trouvée. Toute page du site est atteignable en au maximum 3 clics depuis l'accueil (via la
navigation d'en-tête ou le pied de page, qui liste les 6 prestations, les 8 départements, et les 6
pages « Entreprise »), et **chaque page dispose d'un fil d'Ariane remontant jusqu'à l'accueil**
(`includes/breadcrumbs.php`, présent sur toutes les pages sauf l'accueil lui-même).

Le pied de page (`template-parts/footer/site-footer.php`) ne liste pas nommément la page pilier, la
page tarifs, l'index prestations, ni le hub zones — mais ces 4 pages sont déjà atteignables depuis
la navigation d'en-tête sur chaque page, donc non orphelines. Amélioration possible mais non
bloquante pour une prochaine phase : les ajouter aussi au pied de page renforcerait leur maillage,
sans corriger un défaut d'accessibilité de contenu.

## Ancres

Les ancres utilisées sont descriptives et varient déjà naturellement d'un contexte à l'autre : le
nom réel de la prestation, de la ville ou de l'article (jamais « cliquez ici » ou une répétition
mécanique). Les liens de navigation (fil d'Ariane, menu) répètent nécessairement les mêmes libellés
d'une page à l'autre par nature — c'est attendu pour une navigation, pas un défaut d'ancrage.

## Limite assumée

Les CTA des pages prestation/zone ne transmettent pas encore de contexte au formulaire de devis
(`?prestation=&ville=`) — corrigé dans cette même phase 4, voir la section formulaire de
`STATUS.md`.
