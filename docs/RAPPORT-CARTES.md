# Vocabulaire de cartes — reproduction des composants de Claude Design

> Passe du 10 août 2026, branche `hotfix-production-fidelite-claude-design`, PR #9.
> **Rien n'est fusionné, rien n'est déployé.**

---

## Verdict

> ## PARTIEL — ÉCARTS RESTANTS

Le vocabulaire de cartes n'est pas encore reproduit partout. Les six pages prestation le sont ;
les pages de zone le sont à une ou deux cartes près ; quatre routes restent nettement en écart, et
elles sont nommées au §8, composant par composant.

Aucune hauteur n'a été obtenue artificiellement : aucun `min-height` arbitraire, aucun rembourrage
vide, aucune marge compensatoire, aucun bloc invisible, aucun pseudo-élément sans contenu, aucune
hauteur forcée, aucune duplication cachée, aucun JavaScript de mise en page. Les hauteurs se
rapprochent parce que les composants existent, dans le même ordre, avec le même découpage.

---

## 1. L'instrument : `tools/inventaire-cartes.mjs`

Aucun outil existant ne voyait ce défaut. Une page peut contenir **toutes** les phrases du
prototype, faire **la même hauteur**, et présenter huit contraintes dans deux gros pavés là où la
maquette en fait huit micro-cartes. Le contenu est là, l'écran est faux.

L'inventaire relève désormais, des deux côtés et sur le rendu réel, **chaque carte** : archétype,
bande d'appartenance, titre, texte, image, icône, fond, filet, rayon, ombre, rembourrage, largeur,
hauteur, nombre de colonnes de son rang, `grid-column`, alignement, écart entre cartes, et
comportement à 1440 comme à 375 px. Il en déduit quatre anomalies nommées :

| Anomalie | Ce qu'elle veut dire |
|---|---|
| `absente` | la maquette a une carte que WordPress n'a pas |
| `fusionnee` | plusieurs cartes de la maquette rendues dans un seul conteneur |
| `surplus` | WordPress a une carte que la maquette n'a pas |
| `type` / `colonnes` | la carte existe, mais pas sous la bonne forme |

Deux règles le rendent exploitable :

- **un conteneur qui contient visuellement plusieurs micro-cartes n'est jamais compté pour une
  carte** : il compte pour ses enfants. Sans cela, une grille de huit micro-cartes posée sur un
  fond arrondi comptait pour neuf ;
- **l'appariement se fait sur une empreinte dépouillée de tout ce qui n'est ni lettre ni chiffre.**
  Le prototype concatène ses nœuds sans espace (« À partir de27 € HT/h »), accole le « + » des
  accordéons aux questions, et emploie des apostrophes typographiques. Comparer « à l'espace près »
  produisait des dizaines de fausses cartes absentes — 45 anomalies sur `/prestations/cabinets/`
  dont 24 imaginaires.

Sortie : `docs/INVENTAIRE-CARTES-53-ROUTES.md`.

## 2. Les archétypes, relevés et non inventés

Chaque nom ci-dessous correspond à une composition réellement employée par la maquette, classée sur
son rendu mesuré. Les valeurs sont celles du prototype à 1440 px.

| Archétype | Relevé | Occurrences (maquette) |
|---|---|---|
| `carte-titre-texte` | intertitre + paragraphe, blanche, rayon 14-16, filet 1 px | la plus fréquente |
| `micro-carte` | bloc court encadré, rayon 12-14 | très fréquente |
| `faq` | accordéon replié, 61-65 px, rayon 12 | 10 par page prestation |
| `carte-sombre` | fond #10263B ou #18232D, texte clair, rayon 12-18 | panneaux d'exclusions, tuiles de prestation |
| `tarif` | fond #174A81, rayon 14, montant en 30 px | 1 à 2 par page |
| `chip` | 41 px, rayon 100, fond #F4F7F8, filet 1 px | communes, secteurs |
| `etape` | pastille numérotée + intitulé + texte, carte 820×162 | page fonctionnement, pilier |
| `temoignage` | étoiles + citation + attribution | 1 par page |
| `encadre-barre` | filet gauche de 2-3 px, sans fond | situations, réponse directe |
| `carte-image` | visuel + légende | articles, prestations |

Les composants PHP et CSS ajoutés restent **distincts**. Les fondre en une carte générique unique
ferait perdre à l'écran ce qui les sépare : un panneau sombre d'exclusions ne se lit pas comme une
carte de scénario, et une chip de commune ne se lit pas comme une carte d'article.

## 3. Composants PHP créés

Tous dans `wp-content/themes/topfamillepro/includes/components.php` :

| Fonction | Archétype | Où |
|---|---|---|
| `tfp_panel_exclusions()` | panneau sombre + micro-cartes sombres | 6 pages prestation |
| `tfp_price_card()` | carte tarifaire marine | 6 pages prestation |
| `tfp_answer_card()` | carte de réponse encadrée | notes de fin de colonne |
| `tfp_note_card()` | carte de note | limites de prestation |
| `tfp_link_cards()` | cartes de renvoi avec flèche | « À lire aussi » |
| `tfp_chip_list()` | chips de couverture | « Cette prestation près de chez vous » |
| `tfp_static_runs()` | découpage d'une bande en rangées homogènes | pages statiques |

## 4. Classes CSS créées ou corrigées

| Classe | Nature |
|---|---|
| `.tfp-panel--dark`, `.tfp-panel__intro` | panneau sombre d'exclusions (#18232D, rayon 18, rembourrage 40) |
| `.tfp-tile-grid--dark` | micro-cartes sombres (268×80, #10263B, rayon 12, filet #234066, 4 colonnes, écart 10) |
| `.tfp-price-card` | carte tarifaire (#174A81, rayon 14, montant 30 px) |
| `.tfp-answer-card`, `.tfp-note-card` | cartes encadrées claires (#F4F7F8, rayon 12-14, filet #B7CFD7) |
| `.tfp-link-cards`, `.tfp-link-card` | cartes de renvoi (564×58, rayon 12, flèche) |
| `.tfp-chip-list` | chips (41 px, rayon 100, filet 1 px, écart 8) |
| `.tfp-service-tiles`, `.tfp-service-tile` | tuiles de prestation des pages de zone (285×147, #174A81, filet #1E5C9E, 4 colonnes, écart 13) |
| `.tfp-detail-grid` | 3 colonnes, écart 34, filet supérieur 2 px |
| `.tfp-detail-grid--orga` | 4 colonnes, écart 18, sans ornement |
| `.tfp-detail-item--carte` | carte pleine largeur au sein de la même bande |
| `.tfp-situation-grid` | 2 colonnes, écart 16, filet gauche 2 px |
| `.tfp-static-grid--2/3/4` | grilles de page statique, nombre de colonnes **par rangée** |
| `.tfp-testimonial--plain` | témoignage rendu à plat sur les pages prestation |
| `.tfp-contact-nudge` | relance de fin de page, carte de 740 px |
| `.tfp-google-badge--inline` | pastille blanche encadrée, et non un rendu à plat |

## 5. Cartes auparavant fusionnées ou absentes, désormais reproduites

| Composant | Où | Ce qui se passait |
|---|---|---|
| Panneau d'exclusions + 6 micro-cartes sombres | 6 pages prestation | rendu en bande claire à puces blanches. C'est la section qui dit ce que l'entreprise **ne** fait **pas** : la faire lire en diagonale a un coût commercial réel |
| 6 tuiles de prestation sur bande marine | **19 routes** (18 zones + page région) | rendues en cartes blanches sur bande claire ; la bande de maillage se confondait avec le corps de page |
| Carte tarifaire marine | 6 pages prestation | rendue en encadré turquoise pâle |
| Note de fin de colonne « tâches » | 5 pages prestation sur 6 | **perdue à l'extraction** : c'est un `span`, pas un paragraphe |
| 3 cartes de renvoi « À lire aussi » | 6 pages prestation | le filtre par prestation liée n'en rendait qu'un sous-ensemble variable, alors que le prototype en montre trois partout |
| Chips de couverture locale | 6 pages prestation | rendues sans leur géométrie de pastille |
| Étapes numérotées | page fonctionnement, pilier | aplaties en pastilles + paragraphes détachés, lien numéro ↔ titre ↔ texte perdu |
| Carte « Absence et remplacement » | 6 pages prestation | rangée dans la grille à 4 colonnes alors que la maquette en fait une carte pleine largeur |

Trois blocs étaient au contraire **encadrés à tort** — réponse directe, témoignage de page
prestation, et le nombre de colonnes de plusieurs rangées : la maquette rend les deux premiers à
plat, et compose ses rangées sur 3 ou 4 colonnes selon la rangée, pas selon la bande.

## 6. Les dix routes qui étaient hors tolérance

Ratio de hauteur à 1440 px, avant cette passe → après. Le nombre de cartes est celui de
l'inventaire (maquette → WordPress).

| Route | Ratio avant | Ratio après | Cartes après |
|---|---|---|---|
| `#/conseils` | 117 % | **117 %** | 11 → 14 |
| `#/avis-clients` | 115 % | **115 %** | 14 → 46 |
| `#/article/cahier-des-charges-nettoyage` | 114 % | **114 %** | 11 → 8 |
| `#/demande-de-devis` | 113 % | **113 %** | 5 → 4 |
| `#/article/frequence-bureaux` | 110 % | **110 %** | 9 → 8 |
| `#/nos-tarifs` | 109 % | **103 %** ✅ | 22 → 21 |
| `#/nos-prestations` | 106 % | **106 %** | 12 → 25 |
| `#/article/cout-nettoyage-bureaux` | 106 % | **106 %** | 5 → 7 |
| `#/a-propos` | 93 % | **94 %** | 1 → 7 |
| `#/nettoyage-professionnel` | 92 % | **92 %** | 53 → 68 |

Une seule est entrée dans la plage. Le travail de cette passe a porté sur les **prestations** et les
**pages de zone**, qui étaient déjà dans la plage en hauteur mais fausses en composants — et c'est
précisément le point de la consigne : *une hauteur correcte avec un mauvais nombre de cartes est un
échec.* Les six prestations sont passées de 45 anomalies à 1 ou 2, sans que leur hauteur bouge de
plus de deux points.

## 7. Les 53 résultats

`docs/INVENTAIRE-CARTES-53-ROUTES.md` porte le détail. Synthèse à 1440 px :

| État | Routes |
|---|---|
| ✅ aucune anomalie | 1 |
| ⚠️ anomalies mineures (type ou colonnes seulement) | 9 — dont **les six prestations** |
| ❌ au moins une carte absente ou fusionnée | 43 |

Les six prestations, cartes maquette → WordPress : **21→21, 20→20, 28→28, 21→21, 21→21, 21→21**.
Zéro carte absente, zéro carte fusionnée.

Les dix-huit pages de zone sont à une ou deux cartes près (49→48, 50→48, 31→29…), contre dix cartes
d'écart avant cette passe.

## 8. Ce qui reste — composant par composant

Ces écarts ne sont ni juridiques ni commerciaux. Ils sont mesurés et nommés.

| Route | Cartes | Composant encore différent |
|---|---|---|
| `#/zones-intervention` | 52 → 19 | la maquette range départements, villes et communes en **micro-cartes titre + description** ; le thème les rend en chips et en rangées de liens. Trente-trois cartes manquantes. |
| `#/avis-clients` | 14 → 46 | l'inverse : le thème découpe en cartes ce que la maquette pose en blocs de texte. Trente-deux cartes en trop. |
| `#/nettoyage-professionnel` | 53 → 68 | quinze cartes en trop, et six **cartes sombres** de prestation absentes : l'extraction a réduit des micro-cartes « titre + description » à de simples chips, perdant la description. |
| `#/nos-prestations` | 12 → 25 | treize cartes en trop, même cause que ci-dessus. |
| `#/bourgogne-franche-comte` | 51 → 62 | onze cartes en trop. |
| `#/contact` | 7 → 2 | cinq micro-cartes de coordonnées absentes. |
| 18 pages de zone | 1 à 2 cartes d'écart | une carte de renvoi « Nous contacter » et une carte d'exemple tarifaire fusionnée. |

La cause dominante est unique et identifiée : **`tools/generate-pages.mjs` réduit à un simple
libellé (`noms`) les blocs que la maquette rend en micro-carte « titre + description ».** La
description est perdue à l'extraction, donc la carte ne peut pas être reconstituée à l'affichage.
C'est la correction à faire ensuite, et elle est structurelle — elle touche l'extraction, pas le
CSS.

## 9. Non-régression

| Contrôle | Résultat |
|---|---|
| Suite Playwright | **833 / 833** |
| Lint PHP, build complet | OK |
| axe-core | 0 violation |
| WCAG 2.2 AA 2.5.8 (audit dédié, 53 routes × 2 largeurs) | **0 violation** |
| JSON-LD (`FAQPage` visible, aucun `Review`/`AggregateRating`) | conforme |
| Textes de la maquette | **0 bloc manquant**, 6 écarts voulus |
| Responsive, six largeurs | 0 débordement horizontal |
| Navigation clavier, focus, Échap | OK |
| Images | 0 cassée, 0 sans `alt` |
| Sitemap | 45 URL, 8 communes non validées exclues |

Une régression a été introduite puis corrigée dans la même passe : `tfp_note_card()` posait son
texte en nœud nu, sans paragraphe. Invisible à l'œil, mais les six textes « Les limites de la
prestation » cessaient d'être des blocs de contenu — ni pour un lecteur d'écran, ni pour l'outil de
comparaison, qui les comptait comme absents.

### Lighthouse mobile, banc avec compression et cache

| Page | Perf. | Access. | Bonnes pratiques | SEO | LCP | CLS |
|---|---|---|---|---|---|---|
| Accueil | **91** | 100 | 100 | 100 | 3,0 s | 0,008 |
| Nettoyage de bureaux | **90** | 100 | 100 | 100 | 3,0 s | 0,009 |
| Tarifs | **93** | 100 | 100 | 100 | 2,7 s | 0,007 |
| Dijon | **100** | 100 | 100 | 100 | 1,7 s | 0,001 |
| Article — fréquence | **96** | 100 | 100 | 100 | 2,3 s | 0,001 |
| Demande de devis | **95** | 100 | 100 | 100 | 2,6 s | 0,010 |

Aucun seuil dégradé : Performance ≥ 90, Accessibilité 100, Bonnes pratiques 100, SEO 100,
CLS ≤ 0,010.

## 10. Comparaisons prioritaires

`docs/VALIDATION-VISUELLE.md` porte, à **1440 px et 375 px**, la maquette, le rendu WordPress et
leur différence pour : accueil, page pilier, nettoyage de bureaux, nettoyage de cabinets, tarifs,
Dijon, Beaune, Pourquoi nous, index Conseils, un article, formulaire de devis, mentions légales.

Les 106 triptyques des 53 routes sont dans `docs/captures/comparaison/`, régénérés après les
corrections.

## 11. Citation attribuée à Audrey

Conservée à titre provisoire, dans le réglage ACF `citation_audrey` (**Réglages → Réassurance &
avis**), marquée `data-tfp-provisional="1"`, et **exclue de toute donnée structurée** — ni `Review`,
ni `AggregateRating`. Texte intégral, à valider avant déploiement :

> « Mon rôle, c'est de rester joignable et de tenir mes engagements. Chaque client sait à qui
> parler, et sait ce qui a été fait dans ses locaux. »

---

# Passe 2 — correction structurelle du pipeline d'extraction

> 10 août 2026. Verdict inchangé : **PARTIEL — ÉCARTS RESTANTS**.

## 1. La cause technique exacte, dans l'ancien générateur

`tools/generate-pages.mjs` aplatissait chaque bande en une suite de nœuds typés `h2`, `h3`, `p`,
`li` et `span`. La maquette range une grande partie de son contenu en **micro-cartes composées d'un
intitulé et d'une description** — parfois d'un surtitre, d'une pastille, d'une icône, d'une image,
d'un lien et de son libellé. À l'aplatissement, seul l'intitulé survivait : il partait dans `noms`
et se rendait en pastille, la description était jetée ou détachée dans `textes`.

La carte devenait alors **impossible à reconstituer à l'affichage**, quel que soit le gabarit ou le
CSS : la donnée n'existait plus après l'étape 1 de la chaîne.

## 2. Le nouveau schéma

Chaque grille est relevée **avant** l'aplatissement, avec sa géométrie :
`colonnes`, `theme` (clair/sombre), `variante` (texte/lien/image), `gap`, `fond`, `rayon`, `filet`,
`padding`. Chaque carte porte :

| Champ | Contenu |
|---|---|
| `titre`, `titre_tag` | intitulé, et la balise employée par la maquette (`h3` ou libellé) |
| `description` | premier fragment de texte, dans sa forme d'origine |
| `lignes[]` | fragments suivants, **restés distincts** (auteur, rôle, ville d'un témoignage) |
| `badge` | pastille courte accolée au titre (numéro de département) |
| `surtitre` | étiquette au-dessus de l'intitulé |
| `icone`, `image` | pictogramme, `alt` du visuel |
| `route`, `libelle_lien` | cible et libellé du lien |
| `aria` | nom accessible explicite s'il existe |
| `ordre`, `span` | rang dans la grille, `grid-column` |
| `provisoire` | témoignage repris de la maquette (CLAUDE.md §5.5) |

Rien n'est fabriqué : un champ absent du prototype reste vide, et **aucune description n'est déduite
d'un titre**. Les nœuds d'une grille sont retirés du flux aplati, un repère prenant leur place, pour
que l'ordre de lecture soit conservé.

La donnée traverse maintenant toute la chaîne sans perte : extraction → format intermédiaire →
générateur → seed → installateur → base WordPress → gabarit → rendu.

## 3. Fichiers corrigés

| Fichier | Correction |
|---|---|
| `tools/generate-pages.mjs` | relevé des grilles, détail des cartes, collecte **par bloc rendu** et non par nœud texte |
| `tools/inventaire-cartes.mjs` | remontée des wrappers techniques avant de compter les colonnes |
| `tools/diff-text.mjs` | `strong` ajouté au relevé — un intitulé de carte est un bloc de contenu |
| `includes/components.php` | `tfp_card_grid()` : rendu d'une grille de micro-cartes |
| `template-parts/components/static-blocks.php` | rendu des grilles à leur place dans l'ordre |
| `src/css/04-components.css` | `.tfp-card-grid`, `.tfp-card-tile` et leurs variantes |

Contenus régénérés : **31 grilles, 154 micro-cartes** sur les neuf pages statiques.

## 4. Installateur et migration

Installateur **v1.8.0**, thème **v0.9.0**.

- **Idempotence** — deux relectures consécutives des seeds : empreintes identiques
  (`c3f1318f 48440e3a b146c1e1 b49293de` avant et après), mêmes identifiants de page
  (10, 50, 54, 48, 60), mêmes slugs, mêmes permaliens.
- **Migration sur installation existante** — le rig portant la version précédente est passé de
  0 grille à 9 / 6 / 3 / 2 grilles et 35 / 36 / 12 / 12 cartes, **sans changer un seul identifiant**
  (13 et 57 avant, 13 et 57 après). Aucune suppression préalable des 53 pages n'est nécessaire.
- **Aucun doublon** : 56 contenus, aucun slug en double.
- **Données légales et tarifaires intactes** : SIRET et Hostinger présents, aucun ancien tarif,
  aucun `[À COMPLÉTER]`.

## 5. Résultats

Cartes maquette → WordPress à 1440 px, et cartes absentes ou fusionnées :

| Route | Avant | Après |
|---|---|---|
| `#/zones-intervention` | 52 → 19 (40 graves) | 52 → 54 (5) |
| `#/nettoyage-professionnel` | 53 → 68 (19) | 53 → 65 (3) |
| `#/nos-prestations` | 12 → 25 | 12 → 13 (0) |
| `#/avis-clients` | 14 → 46 (14) | 14 → 20 (2) |
| `#/bourgogne-franche-comte` | 51 → 62 (34) | 51 → 61 (2) |

Sur les 53 routes : 1 conforme, 11 en anomalies mineures, 41 avec au moins une carte absente ou
fusionnée — contre 43 avant. Le total d'anomalies passe de 713 à 560, les graves de 259 à 147.

## 6. Non-régression

833 tests au vert · 0 violation axe-core · 0 violation WCAG 2.5.8 (53 routes × 2 largeurs) ·
JSON-LD conforme · aucun doublon · données légales intactes.

**Deux régressions ont été introduites puis corrigées dans cette même passe**, toutes deux du même
genre : du contenu rendu à l'écran mais invisible comme bloc de contenu.

1. Le rendu des cartes plaçait descriptions et intitulés dans des `span`. Huit citations de
   `/avis-clients/` étaient affichées et comptées manquantes. Corrigé par du contenu de flux —
   `<div>` porteur, `<p>` pour la description, `<h3>` ou `<strong>` selon ce que fait la maquette.
2. La première version de la collecte prenait le texte propre de chaque élément, ce qui coupait une
   citation répartie sur plusieurs balises en ligne : `« »` d'un côté, le texte de l'autre. La
   collecte se fait désormais **par bloc rendu**.

Un test a par ailleurs détecté un vrai défaut de conformité : les témoignages repris en micro-cartes
n'étaient pas marqués `data-tfp-provisional`. Le repère est maintenant posé à l'extraction, sur le
rendu (étoiles ou citation), et non sur un nom d'auteur qu'on ne saurait pas reconnaître.

## 7. Ce qui reste

**Deux blocs de texte manquants**, tous deux sur `/zones-intervention/bourgogne-franche-comte/` :
la bande turquoise « Un tarif régional unique » et son paragraphe. La bande existe dans la maquette
(section 9) et n'apparaît pas dans le contenu relevé. C'est le seul contenu manquant des 53 routes ;
il est localisé, et sa correction n'est pas engagée dans cette passe.

**Cartes.** Les surplus restants viennent d'un point unique et identifié : les bandes qui **mêlent**
cartes et éléments non-cartes ne sont pas reconnues comme grilles (la règle exige que presque tous
les enfants soient des cartes), et leur contenu retombe alors sur le rendu générique en pastilles.
C'est ce qui produit les trois pastilles en trop de la bande tarifaire sur
`/nettoyage-professionnel/`, `/zones-intervention/bourgogne-franche-comte/` et `/avis-clients/`.

**Hauteurs.** 39 routes sur 53 sont dans la plage 95-105 %. Les pages statiques les plus retouchées
sont passées sous la plage (`/nettoyage-professionnel/` 84 %, `/zones-intervention/` 93 %,
`/prestations/` 90 %, `/notre-fonctionnement/` 88 %) : les micro-cartes sont plus compactes que les
blocs de texte qu'elles remplacent, et il reste à ajuster leur rembourrage sur celui du prototype —
qui est relevé et disponible dans les données (`padding`, `gap`, `rayon`), mais pas encore appliqué
carte par carte.

---

# Passe 3 — bandes mixtes, styles relevés, zéro texte manquant

> 11 août 2026. Verdict : **PARTIEL — ÉCARTS RESTANTS**.

## 1. L'ancien et le nouveau schéma d'une bande mixte

**Avant** — un modèle binaire, où chaque type allait dans son propre tiroir :

```
bloc = { titre, niveau, textes[], liste[], liens[], noms[], citations[], faq[], etapes[] }
```

L'ordre était perdu : une note écrite entre deux grilles ressortait après elles, et tout `span`
non classé tombait dans `noms`, donc en pastille.

**Après** — une séquence hétérogène ordonnée :

```
bloc = { titre, niveau, sequence: [ {type, …} ] }
type ∈ paragraph | grid | list | note | quote | link | chip | step | faq
grid = { colonnes, theme, variante, gap, fond, rayon, filet, padding,
         titre_taille, titre_interligne, desc_taille, desc_interligne, desc_marge,
         items: [ {titre, titre_tag, description, lignes[], badge, surtitre,
                   icone, image, route, libelle_lien, aria, ordre, span, provisoire} ] }
```

L'ordre et les frontières traversent maintenant toute la chaîne sans perte.

## 2. Le repli en pastilles, supprimé

Un fragment n'est rendu en pastille que si la maquette le rend en pastille — mesuré à
l'extraction (rayon ≥ 40 px **et** fond ou filet), jamais supposé. Sur les neuf pages statiques,
le relevé est net : **aucun** fragment n'est une pastille dans le prototype, alors que 54 le
devenaient. C'étaient des morceaux de la bande tarifaire, des phrases de transition, des
précisions et des conclusions.

## 3. Fichiers modifiés

| Fichier | Correction |
|---|---|
| `tools/generate-pages.mjs` | séquence ordonnée ; relevé du caractère « pastille » ; typographie interne des tuiles ; rembourrage des bandes ; repère de grille posé sur la première carte |
| `template-parts/components/static-blocks.php` | rendu de la séquence, un archétype par type ; plus de repli |
| `includes/components.php` | géométrie relevée passée en variables CSS ; visuels des cartes via le manifeste |
| `src/css/04-components.css` | variables de tuile et de bande, bande blanche, note statique, contraste |

Installateur **v1.9.0**, thème **v0.10.0**.

## 4. Les deux blocs régionaux restaurés

La bande turquoise « Un tarif régional unique » de `/zones-intervention/bourgogne-franche-comte/`
tient dans un flex de trois enfants : une colonne de texte (titre, paragraphe, lien) et deux
cartes. Deux cartes suffisaient à faire reconnaître une grille, et le repère de position était
posé sur le **conteneur** : l'aplatissement passait donc au-dessus de tous ses enfants, colonne de
texte comprise.

Le repère est désormais posé sur la **première carte**, et seules les cartes sont retirées du flux.
Le titre et le paragraphe sont restaurés tels quels, à leur place, dans leur bande, avec leur fond
turquoise — rien n'a été réécrit ni déduit.

**Blocs de texte manquants sur les 53 routes : 2 → 0.**

## 5. Anomalies des cinq routes prioritaires

| Route | Cartes réf. → WP (début de passe) | Cartes réf. → WP (fin) | Graves avant | Graves après |
|---|---|---|---|---|
| `/zones-intervention/` | 52 → 54 | 52 → 49 | 5 | 4 |
| `/nettoyage-professionnel/` | 53 → 65 | 53 → 54 | 3 | 2 |
| `/prestations/` | 12 → 13 | 12 → 13 | 0 | 0 |
| `/avis-clients/` | 14 → 20 | 14 → 13 | 2 | 2 |
| `/zones-intervention/bourgogne-franche-comte/` | 51 → 61 | 51 → 56 | 2 | 1 |
| `/contact/` | 7 → 2 | 7 → 2 | 7 | 7 |

Total sur les 53 routes : **560 → 491 anomalies**, **147 → 144 graves**.

## 6. Les quatre pages devenues trop courtes

| Route | Avant | Après |
|---|---|---|
| `/nettoyage-professionnel/` | 84 % | **96 %** ✅ |
| `/prestations/` | 90 % | **99 %** ✅ |
| `/notre-fonctionnement/` | 88 % | 91 % |
| `/zones-intervention/` | 93 % | 88 % |

Deux sont rentrées dans la plage, uniquement par application des valeurs relevées : rembourrage
vertical des bandes (84 px dans la maquette contre 52 px posés partout par le thème), fond blanc
des bandes alternées, typographie interne des tuiles (intitulé de 15 à 20 px, description de 13,5
à 15 px, espace de 4 à 10 px), et fond de tuile mesuré.

Aucune compensation artificielle n'a été employée. `/zones-intervention/` a **baissé** parce que
ses bandes ont, dans la maquette, un rembourrage plus **faible** que les 52 px du thème : le
rendu est maintenant fidèle, et le déficit restant vient d'ailleurs.

**40 routes sur 53 sont dans la plage 95-105 %.**

## 7. Migration et installation

- **Installation portant la version précédente** : 0 élément de séquence → 78 / 34 / 19 / 6 selon
  la page, **sans changer un seul identifiant** (13, 57, 45 avant comme après), 56 contenus,
  **aucun doublon**, aucun slug modifié.
- **Deux exécutions successives** : empreintes stables, aucun contenu dupliqué.
- **Intégrité** : données légales présentes (SIRET, hébergeur), **0 ancien tarif**, **0
  `[À COMPLÉTER]`**.

## 8. Tests

| Contrôle | Résultat |
|---|---|
| Suite Playwright | **833 / 833** |
| axe-core + navigation clavier | **12 / 12**, 0 violation |
| WCAG 2.2 AA 2.5.8 (53 routes × 2 largeurs) | 0 violation |
| JSON-LD | conforme |
| Blocs de texte manquants | **0** |

Lighthouse, banc avec compression et cache : accueil 92, prestations/bureaux 90, tarifs 100,
Dijon 96, article 97, page pilier 97 — Accessibilité 100, Bonnes pratiques 100, SEO 100,
CLS ≤ 0,009.

Une régression a été introduite puis corrigée dans la passe : le fond de tuile étant désormais
celui **relevé** sur la maquette, il peut être plus clair que celui qu'attendait le thème, et le
gris secondaire de la description tombait sous 4,5:1. C'est la couleur du texte qui s'ajuste,
jamais le fond relevé.

## 9. Écarts restants

- **`/contact/`** (7 → 2 cartes) n'a pas été traité : cette page a son propre gabarit et ne passe
  pas par le composant de bandes statiques. Ses cinq micro-cartes de coordonnées demandent le même
  travail d'extraction, sur un autre chemin de code.
- **Écarts de `type`** : la maquette compose ses intitulés de carte en `div` nu ; le thème emploie
  `strong` ou `h3` selon ce que fait le prototype. L'outil classe donc `carte-titre` là où la
  référence dit `micro-carte`. Le rendu est identique, la sémantique est meilleure — c'est un écart
  d'outil, pas d'écran.
- **`/zones-intervention/`** reste à 88 % avec 4 cartes graves.
- Onze routes restent hors de la plage 95-105 %, dont les trois pages légales, qui portent
  légitimement plus de texte que la maquette (exception documentée).

---

# Passe 4 — Contact reproduite, cause de /zones-intervention/ localisée

> 11 août 2026. Verdict : **PARTIEL — ÉCARTS RESTANTS**.

## 1. Contact — chemin de rendu avant / après

**Avant** : gabarit propre, deux cartes génériques `tfp-card` avec styles en ligne, aucune
micro-carte, aucun composant partagé. 7 cartes dans la maquette, **2** côté thème.

**Après** : le gabarit reste spécifique — c'est légitime, la page n'est pas une page de bandes —
mais ses cartes passent par `tfp_card_grid()` et `tfp_chip_list()`, avec le **même schéma
structuré** et la même géométrie relevée que les bandes statiques. Aucune seconde architecture.

Aucune coordonnée n'est recopiée : téléphone, adresse électronique, ville et région viennent toutes
de `tfp_site_data()`. Le formulaire de devis n'est pas touché — Contact y renvoie, comme la
maquette : deux étapes, validation client et serveur, nonce, honeypot, consentement, UTM, messages
d'erreur, anti-double-envoi et confirmation accessible restent intacts sur `/demande-de-devis/`.

## 2. Les micro-cartes reproduites

| Groupe | Relevé sur la maquette |
|---|---|
| 2 cartes d'orientation | 403×104, fond #EFEFEF, rayon 16, filet 1 px, rembourrage 22, 2 colonnes, écart 14 |
| 4 cartes de coordonnées | 512×86, blanc, rayon 12, filet 1 px, rembourrage 16/18, 1 colonne, écart 12 — icône, intitulé, valeur, nom accessible |
| 3 pastilles de renvoi | 118×43, #F4F7F8, rayon 100, filet 1 px, écart 10 |
| Portrait | 64×64, rond, `alt` vide, nom écrit à côté en texte |

Cartes maquette → WordPress : **7 → 6** (était 7 → 2). Hauteur 100 % → 104 %.

## 3. `/zones-intervention/` — diagnostic bande par bande

`tools/diagnostic-sections.mjs` aligne les bandes des deux côtés et donne le delta en pixels de
chacune. **Contrôle de validité** : la somme des deltas donnait −874 px pour un écart total mesuré
de −791, les 83 px restants étant l'en-tête et le pied de page. Le diagnostic tenait donc, et
désignait deux bandes.

| Bande | H réf | H WP | Δ | Largeur conteneur |
|---|---|---|---|---|
| Une couverture régionale organisée depuis Saint-Apollinaire | 1391 | 1076 | **−315** | 900 → 1260 |
| Départements, villes et communes : comment lire | 1163 | 916 | **−247** | 900 → 1260 |
| Votre commune est-elle couverte ? | 346 | 148 | −198 | 1040 → 1260 |
| (bande de rappel) | 192 | 84 | −108 | — |

Même signature partout : **la colonne de lecture**. Le prototype borne son texte narratif à
740-780 px ; le thème le laissait occuper les 1 114 px du conteneur. Une ligne plus large tient
plus de mots, donc moins de lignes : chaque paragraphe passait de 134 px de haut à 84.

La largeur est désormais relevée sur les **paragraphes réels** de chaque bande — seuls eux portent
la colonne de lecture — et appliquée en variable CSS. Les grilles de cartes gardent toute la
largeur. Aucun rembourrage global, aucune hauteur forcée, aucune règle créée pour atteindre un
pourcentage.

**Deltas après correction : somme −251 px pour un écart total de −168 px.** `/zones-intervention/`
passe de **88 % à 98 %**.

## 4. Effet sur les autres routes

| Route | Avant | Après |
|---|---|---|
| `/zones-intervention/` | 88 % | **98 %** |
| `/nettoyage-professionnel/` | 96 % | **98 %** |
| `/zones-intervention/bourgogne-franche-comte/` | 93 % | **100 %** |
| `/prestations/` | 99 % | **101 %** |
| `/a-propos/` | 95 % | 103 % |
| `/notre-fonctionnement/` | 91 % | 94 % |

**42 routes sur 53 dans la plage 95-105 %, dont 33 dans 98-102 %.**

## 5. Faux positif de l'outil, corrigé

Le classement d'archétype se faisait sur les **balises** (`h2,h3,h4,strong,b`), alors que le contrat
de l'outil est de classer sur le **rendu**. La maquette compose ses intitulés de carte en `div` nu ;
le thème emploie `strong` ou `h3` selon ce que fait le prototype — ce qui est plus juste
sémantiquement. À écran identique, la référence était donc classée `micro-carte` et le thème
`carte-titre`, sur 115 cartes.

Un intitulé est maintenant reconnu à ce qui le distingue visuellement du corps de la carte : une
graisse d'au moins 600, ou une taille supérieure à celle du texte courant. Correction reproductible,
appliquée dans l'outil et non ignorée à la main.

Effet immédiat : `/zones-intervention/` 41 → 11 anomalies, `/nettoyage-professionnel/` 20 → 14,
`/contact/` 9 → 5.

## 6. Total des anomalies

| Étape | Graves (absente + fusionnée), 1440 px |
|---|---|
| Avant cette passe | 144 |
| Après correction de Contact | 140 |
| Après correction du faux positif de l'outil | **86** |

Sur les 53 routes aux **deux largeurs** : 927 anomalies, 283 graves, 10 routes sans aucune anomalie.
Répartition : 205 absente · 78 fusionnée · 239 supplémentaire · 220 type · 185 colonnes.

## 7. Migration

Installateur **v1.10.0**, thème **v0.11.0**.

- Identifiants **inchangés** : 54, 47, 57 avant comme après.
- 56 contenus, **aucun doublon**, aucun slug modifié.
- Deux exécutions successives : empreintes stables.
- Données légales présentes, **0 ancien tarif**.

## 8. Tests

| Contrôle | Résultat |
|---|---|
| Suite Playwright | **833 / 833** |
| Blocs de texte manquants | **0** |
| WCAG 2.2 AA 2.5.8 | 0 violation |
| axe-core + clavier | 0 violation |
| JSON-LD | conforme |
| Images cassées sur `/contact/` | 2 → **0** |

Lighthouse, banc avec compression et cache :

| Page | Perf. | A11y | BP | SEO | CLS |
|---|---|---|---|---|---|
| Accueil | 91 | 100 | 100 | 100 | 0,008 |
| Contact | **100** | 100 | 100 | 100 | 0,006 |
| Zones d'intervention | 97 | 100 | 100 | 100 | 0,006 |
| Nettoyage professionnel | 96 | **100** | 100 | 100 | 0,001 |
| Prestations / bureaux | 92 | 100 | 100 | 100 | 0,009 |
| Tarifs | 92 | 100 | 100 | 100 | 0,005 |

Deux régressions détectées et corrigées dans la passe, toutes deux nées de l'emploi des couleurs
**relevées** : le fond de tuile pouvant être plus clair que celui qu'attendait le thème, et une
bande sombre gardant un lien en marine — contraste 1,71. C'est la couleur du texte qui suit le
fond, jamais l'inverse.

## 9. Écarts encore visibles

- **`/contact/`** : 6 cartes sur 7. Manquent la carte d'attribution du portrait (rendue à plat) et
  une carte d'aparté « ★★★★★ 5,0/5 · 27 € HT/h ». Le reste correspond.
- **Horaires de contact** : la maquette écrit « Du lundi au vendredi · à confirmer · réponse sous
  24 h ». La mention « à confirmer » est retirée — aucun marqueur d'information non arrêtée ne doit
  rester visible en production. **Écart éditorial assumé.**
- **Onze routes hors plage**, dont les trois pages légales (exception documentée : elles portent
  plus de texte réel que la maquette), `/conseils/` à 117 %, `/demande-de-devis/` à 113 % et les
  trois articles à 106-114 %.
- **`surplus` et `colonnes`** restent les deux familles d'anomalies les plus nombreuses. Elles n'ont
  pas été analysées une par une dans cette passe.
