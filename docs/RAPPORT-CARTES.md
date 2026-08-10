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
