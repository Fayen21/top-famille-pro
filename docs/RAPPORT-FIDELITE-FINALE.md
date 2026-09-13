# Rapport de fidélité finale — Top-Famille Pro

> Branche `hotfix-production-fidelite-claude-design`, PR #9. **Rien n'est fusionné, rien n'est
> déployé.** Ce rapport rend compte de la passe finale de fidélité visuelle, de conformité et de
> performance demandée le 10 août 2026.
>
> Date : 10 août 2026.

---

## Verdict

> ## PARTIEL — ÉCARTS RESTANTS

Le verdict `FIDÉLITÉ CLAUDE DESIGN VALIDÉE — EXCEPTIONS LÉGALES ET COMMERCIALES DOCUMENTÉES` ne
peut pas être prononcé : il subsiste des écarts qui ne sont **ni** juridiques **ni** commerciaux, et
qui ne sont donc pas couverts par les six exceptions autorisées. Ils sont nommés au §7 ci-dessous,
route par route, avec la métrique responsable.

La distinction demandée est faite explicitement : le §6 liste les écarts **autorisés**, le §7 les
**défauts de fidélité**. Aucun défaut n'est présenté comme une exception, et aucune exception n'est
comptée comme un défaut.

---

## 1. Critère WCAG 2.2 « 2.5.8 Target Size (Minimum) » — l'erreur et sa correction

L'affirmation antérieure selon laquelle WCAG 2.2 AA imposerait des cibles de 44 px **était fausse**,
et cette erreur avait été propagée dans le CSS et dans le rapport précédent. La règle exacte :

- **2.5.8 (niveau AA)** — la cible fait au moins **24 × 24 px CSS**, **ou** un cercle de 24 px de
  diamètre centré sur elle ne croise celui d'aucune autre cible (**espacement**), **ou** elle est
  posée dans une phrase / sa taille est contrainte par l'interligne du texte non-cible qui l'entoure
  (**exception inline**), **ou** une autre commande équivalente conforme existe sur la page, **ou**
  la présentation est juridiquement imposée ou essentielle.
- **2.5.5 (niveau AAA)** — 44 × 44 px. Ce n'est pas la cible de ce projet.

Ce que cette erreur coûtait, concrètement : les rangées de liens des pages de zone étaient forcées à
44 px, les items de FAQ à 80 px, les villes du pied de page à 30 px. Les pages de zone en sortaient
gonflées de 11 à 23 %.

**Le critère est vérifié pour de vrai**, pas seulement via axe-core — qui le signale mais n'en
implémente qu'une lecture partielle et ne dit pas laquelle des conditions est satisfaite.
`tools/audit-target-size.mjs` implémente les trois conditions et les évalue sur le rendu :

```
node tools/audit-target-size.mjs
→ 53 routes × 2 largeurs (1440 px et 375 px)
→ Critère 2.5.8 (AA, 24 × 24 px ou espacement ou inline) : ✅ aucune violation
```

Deux arbitrages méritent d'être écrits, parce qu'ils ne sont pas évidents :

- les **villes du pied de page**, listées en ligne et séparées par des points médians, ne relèvent
  **pas** de l'exception inline — cette exception vise une cible posée dans une phrase, or il s'agit
  ici d'une liste de liens sans texte porteur. C'est la condition d'**espacement** qui les couvre :
  l'interligne est fixé à 26 px pour que deux cibles successives soient toujours distantes d'au
  moins 24 px ;
- le **fil d'Ariane** est repassé de 37 à 24 px de haut. Le critère demande 24 ; le rembourrage
  précédent en imposait 37, soit 15 px de plus que la maquette sur chacune des 53 pages, sans
  qu'aucune règle ne l'exige.

**Aucune taille de texte visible n'a été modifiée** au titre de cette correction.

### Rythme vertical des pages de zone

Objectif demandé : 98–102 % de la hauteur de référence, sans supprimer de contenu et sans violation
WCAG AA.

| Famille | Avant | Après |
|---|---|---|
| `#/departement/*` (8 pages) | 118 % | **96–99 %** |
| `#/ville/*` (10 villes) | 111–123 % | **99–104 %** |
| Communes secondaires (8 pages) | 111–123 % | **99–104 %** |

Trois causes indépendantes, toutes corrigées :

1. le mauvais critère de cible (ci-dessus) ;
2. **aucune règle CSS ne définissait `h1`** : les H1 tombaient sur le défaut du navigateur (2em,
   34 px) là où la maquette les rend de 44 à 58 px selon le type de page ; et `h2` était figé à
   42 px partout alors que la maquette varie de 22 à 42 px ;
3. le groupe « prestations » se rend **en cartes** sur une page de ville et **en simples liens** sur
   une page de département. Rendre des cartes dans les deux cas triplait la hauteur de la section.

Les pages de ville se situent aujourd'hui entre 99 et 104 %, pour un contenu qui compte 6 % de mots
de plus que la maquette — l'écart résiduel est du texte réel, pas de l'espacement. Le flux de
contenu seul, coquille exclue, est mesuré à 102–104 % (`node tools/measure-chrome.mjs`).

---

## 2. Les six écarts avec la maquette

Le tableau complet — route, section, texte Claude Design, texte WordPress actuel, justification —
est dans **`docs/ECARTS-MAQUETTE-AUTORISES.md`**. Résumé :

| # | Nature | Décision |
|---|---|---|
| 1 | Données d'immatriculation complètes en mentions légales | **Conservé** — LCEN art. 6-III, données confirmées par Kbis |
| 2 | Coordonnées réelles de l'hébergeur Hostinger | **Conservé** — même obligation |
| 3 | Section « Assurance et responsabilité » supprimée | **Conservé** — aucun `[À COMPLÉTER]` publié, aucune assurance inventée |
| 4 | Section « Médiation de la consommation » supprimée | **Conservé** — site strictement B2B (voir §4) |
| 5 | Compteur de « 47 avis » retiré, note 5,0/5 conservée | **Conservé** — CLAUDE.md §5.5 |
| 6 | Aucun `Review` ni `AggregateRating` | **Conservé** — voir §3 |

### Les deux écarts éditoriaux ont été rétablis

Conformément à la consigne « je veux d'abord reproduire la maquette, puis je modifierai ses
formulations ultérieurement », les deux corrections de `CLAUDE.md §9` qui portaient sur des textes
du prototype ont été **annulées** et le texte exact de la maquette rétabli :

| Route | Texte rétabli |
|---|---|
| `#/` — section couverture | « Une couverture régionale, pas des agences fictives » |
| `#/` — section difficultés | « Un interlocuteur identifié suit votre dossier, ajuste la prestation et vous répond directement. » |

Aucune des deux ne réintroduit un ancien tarif, une information juridique fausse ni une donnée
incompatible avec une décision commerciale : rien ne justifiait de les maintenir. Le test
`tests/fidelite.spec.js` a été aligné sur le texte de la maquette.

Trois corrections de §9 restent appliquées, parce qu'elles tombent sous les exceptions posées :
« Des guides locaux viendront compléter cette page » (promesse d'un contenu inexistant), toute
occurrence de « Top-Entreprise » (ancienne marque à faire disparaître), et un paragraphe sur
« aucun simulateur » que le **thème** avait ajouté sur `/demande-de-devis/` — la maquette ne le
porte pas sur cette page, il a donc été retiré au nom de la fidélité, pas de §9.

---

## 3. La citation attribuée à Audrey — texte exact, à valider avant mise en ligne

C'est le seul contenu du site qui fasse parler une personne réelle. Elle doit être validée par
l'intéressée avant toute mise en ligne. **Texte intégral, tel qu'il s'affiche aujourd'hui :**

> ### « Mon rôle, c'est de rester joignable et de tenir mes engagements. Chaque client sait à qui parler, et sait ce qui a été fait dans ses locaux. »

Caractéristiques techniques, telles que demandées :

- **administrable** : elle vit dans le réglage `citation_audrey` de **Réglages → Réassurance &
  avis**, jamais en dur dans un gabarit. `includes/reassurance-settings.php` en porte la valeur par
  défaut, l'assainissement et une note d'administration expliquant qu'elle engage une personne
  réelle. Vider le champ retire la citation du site, sans casser la mise en page ;
- **provisoire et repérable** : rendue dans un `<blockquote class="tfp-quote"
  data-tfp-provisional="1">`. Une seule requête suffit à retrouver tous les contenus provisoires ;
- **aucune donnée structurée** ne la présente comme un avis client : ni `Review`, ni
  `AggregateRating`, ni `testimonial`. Vérifié par `node tools/audit-jsonld.mjs`.

---

## 4. Témoignages provisoires et médiation de la consommation

### Témoignages — repris à l'identique, sans balisage

Les témoignages de la maquette restent **visibles**, avec leurs textes, leurs noms, leurs étoiles,
leurs portraits, leurs cartes, leur position et leur rendu responsive : le design est celui du
prototype, pas un état neutre de substitution. Une correction d'attribution a été faite dans ce
sens — la carte de `/demande-de-devis/` portait « Sophie L. · Cabinet dentaire · Besançon » là où la
maquette écrit « **Sarah B. · Commerçante · Dole** ».

Trois conditions, non négociables, sont tenues :

1. chaque témoignage porte `data-tfp-provisional="1"` ;
2. il est stocké en champ ACF (prestations, zones) ou dans les réglages « Réassurance & avis »,
   jamais en dur dans un gabarit ;
3. il n'alimente **aucune** donnée structurée `Review` ou `AggregateRating`, et n'est jamais mélangé
   à la note Google dans le balisage.

`tools/audit-jsonld.mjs` vérifie le point 3 sur les 53 routes, à chaque exécution.

### Médiation de la consommation — supprimée

Le dispositif de médiation de la consommation (code de la consommation, **art. L612-1**) ne
s'applique qu'aux litiges entre un professionnel et un **consommateur**. Top-Famille Pro s'adresse
exclusivement à des professionnels : la mention est sans objet.

Supprimés : la section des mentions légales, le placeholder `[À COMPLÉTER]` qui l'accompagnait, et
toute occurrence correspondante dans les seeds, les options, les gabarits et les tests. **Aucun
médiateur de substitution n'a été inventé.**

`release/GUIDE-DEPLOIEMENT-HOSTINGER.md` porte la note « Décision juridique à réexaminer si la
clientèle change », avec les trois cas qui la déclenchent.

**Aucun `[À COMPLÉTER]` n'est visible sur le site** — vérifié sur les 53 routes par
`tests/legal.spec.js`, et par contrôle direct sur les six pages les plus exposées.

---

## 5. Vérification visuelle réelle des 53 routes

Trois instruments, dont deux nouveaux, parce qu'une comparaison de hauteurs n'est pas une
vérification visuelle : deux pages peuvent faire la même hauteur avec des couleurs, des polices, des
largeurs de colonne et des rayons différents.

| Outil | Ce qu'il compare | Sortie |
|---|---|---|
| `tools/compare-routes.mjs` | blocs, hauteurs, mots, titres, puces, images, débordements + **106 triptyques** | `docs/COMPARAISON-53-ROUTES.md`, `docs/captures/comparaison/` |
| `tools/compare-styles.mjs` *(nouveau)* | polices résolues, couleurs, tailles et interlignes, largeur et marge du conteneur, nombre de bandes, vocabulaire de cartes (rayons, fonds, filets employés avec leurs effectifs), géométrie du bouton principal, colonnes des grilles, cadrage des images, fond du pied de page | `docs/VERIFICATION-VISUELLE-53-ROUTES.md` |
| `tools/validation-finale.mjs` *(nouveau)* | 12 routes × 2 largeurs × 3 images (maquette / WordPress / différence) | `docs/VALIDATION-VISUELLE.md`, `docs/captures/validation-finale/` |

**Les 106 triptyques ont été régénérés après les corrections**, comme demandé.

`compare-styles.mjs` compare des éléments homologues, pas « le premier venu » : le bouton est ancré
sur le libellé du CTA, les cartes sont comparées en distribution et non une à une, et les grilles
retenues sont celles dont les enfants sont des cartes. Sans ces ancrages, il signalait des écarts
qui n'en étaient pas — ce qui aurait été une malhonnêteté dans l'autre sens.

### Ce que la vérification visuelle a trouvé, et qui est corrigé

| Écart relevé | Correction |
|---|---|
| Pied de page 289 px plus haut que la maquette, sur les 53 routes | Colonne des zones sur **deux** colonnes comme la maquette, villes en ligne, renvois empilés. Coquille : 991 → 706 px, contre 702 px pour la maquette |
| Graisse des H1 : 700 au lieu de 800, sur les 53 routes | `body.tfp-body h1 { font-weight: 800 }` |
| Échelle des H1 : une seule taille (50 px) là où la maquette en emploie sept (44 → 58) | Tokens par type de page |
| Accroche du hero : 17 px et couleur secondaire, au lieu de 20 px / interligne 32 / #34485A | Corrigé sur les deux classes d'accroche |
| Largeur du hero : 1260 px partout, au lieu de 900 / 820 / 1260 selon la page | Classe de largeur relevée route par route |
| Bouton principal : 52 px au lieu de 60 | Géométrie relevée (padding 15/26, texte 17 px, rayon 12) |
| Pages de zone et pages statiques rendues en texte nu là où la maquette pose des cartes | Cartes, avec rembourrage et rayon **relevés bande par bande** |
| Grille appliquée à la bande entière, rangeant l'introduction à côté des cartes | Découpage en rangées (`tfp_static_runs()`) |
| Étapes numérotées aplaties en pastilles + paragraphes détachés | Cartes « 01 / intitulé / texte », en liste ordonnée |
| Ordre des six prestations dans le pied de page | `menu_order` conforme à la maquette |
| Badge Google du pied de page rendu à plat | Pastille (#1B3550, rayon 10) |

Un principe a guidé toute cette passe : **la disposition se relève sur le rendu du prototype, elle
ne se devine pas.** Le composant des pages statiques employait auparavant une heuristique
(« plusieurs blocs courts ⇒ colonnes ») qui se trompait — sur « Qui nous sommes » de `/a-propos/`,
2 083 px de maquette étaient rendus en 1 338 px. Le nombre de colonnes, le traitement en cartes, la
géométrie de ces cartes et l'appartenance de chaque bloc à une rangée sont désormais **mesurés** par
`tools/generate-pages.mjs`, puis stockés avec le contenu.

---

## 6. Conformité

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète | **833 tests, 833 au vert** |
| Lint PHP (thème, seeds, installateur) | aucune erreur |
| Build complet (CSS + JS + images) | OK |
| axe-core (`tests/accessibility.spec.js`) | 0 violation |
| **WCAG 2.5.8 dédié** (`tools/audit-target-size.mjs`) | 0 violation, 53 routes × 2 largeurs |
| Responsive, six largeurs | 0 débordement horizontal |
| Navigation clavier, focus, piège de focus du drawer, Échap | OK |
| Images (`tools/image-map.mjs`) | 49 visuels de maquette, 13 fichiers servis, **0 cassée**, **0 sans `alt`** |
| Liens internes, pages orphelines, vraie 404 | 0 lien mort, 0 orpheline, 404 renvoie bien un statut 404 |
| Canonicals | absolues et auto-référentes sur les 53 routes, uniques |
| Redirections | `docs/REDIRECTIONS.md` — source et destination identifiées pour chacune |
| Sitemap | 45 URL indexables (53 − 8 communes non validées, **correctement exclues**) |
| `robots.txt` | conforme, pointe le sitemap natif |
| **JSON-LD** (`tools/audit-jsonld.mjs`) | conforme sur les 53 routes — aucun `Review`, aucun `AggregateRating`, aucun `FAQPage` sans FAQ visible |
| Anciens tarifs | aucune occurrence |
| `[À COMPLÉTER]` visibles | **0** |
| Erreurs console | 0 |
| Textes de la maquette (`tools/diff-text.mjs`) | **0 bloc manquant**, 6 écarts voulus et documentés |

Un défaut réel a été trouvé et corrigé au passage : `/notre-fonctionnement/` déclarait un `FAQPage`
de quatre questions **qui n'étaient pas affichées**. Contraire à `CLAUDE.md §8` et aux règles de
Google sur les résultats enrichis, qui exigent que le balisage décrive un contenu visible.

### Performance

Mesures Lighthouse mobile, sur les six pages représentatives, **avec le ZIP final installé**.

**Banc « proche production » — compression Brotli/gzip et `Cache-Control` d'un an sur les ressources
versionnées** (`tools/banc-production.mjs`, qui reproduit devant le rig ce que LiteSpeed apporte sur
Hostinger) :

| Page | Perf. | Access. | Bonnes pratiques | SEO | LCP | CLS |
|---|---|---|---|---|---|---|
| Accueil | **92** | 100 | 100 | 100 | 3,0 s | 0,009 |
| Nettoyage de bureaux | **90** | 100 | 100 | 100 | 3,0 s | 0,010 |
| Tarifs | **99** | 100 | 100 | 100 | 1,7 s | 0,008 |
| Dijon | **91** | 100 | 100 | 100 | 2,9 s | 0,001 |
| Article — fréquence | **97** | 100 | 100 | 100 | 2,3 s | 0,001 |
| Demande de devis | **100** | 100 | 100 | 100 | 1,4 s | 0,010 |

**Cibles atteintes sur les six pages** : Performance ≥ 90, Accessibilité 100, Bonnes pratiques 100,
SEO 100, CLS ≤ 0,1 (mesuré ≤ 0,010).

**Banc sans compression ni cache** (`php -S` nu), conservé comme demandé :

| Page | Perf. | LCP | CLS |
|---|---|---|---|
| Accueil | 83 | 3,7 s | 0,009 |
| Nettoyage de bureaux | 94 | 2,7 s | 0,010 |
| Tarifs | 86 | 3,5 s | 0,008 |
| Dijon | 96 | 2,6 s | 0,001 |
| Article — fréquence | 91 | 3,0 s | 0,001 |
| Demande de devis | 87 | 3,3 s | 0,010 |

La métrique responsable de l'écart entre les deux bancs est le **premier rendu (FCP)**, et la
ressource en cause est la feuille de style : 59 Ko non compressés, **10 Ko en Brotli**. Sur le lien
mobile bridé de Lighthouse (1,6 Mbit/s, 150 ms de latence), ces 49 Ko de différence coûtent à eux
seuls près d'une seconde de premier rendu. Le temps de réponse serveur est de 40 ms, le blocage du
fil principal de 0 ms : il n'y a ni requête lente ni JavaScript coûteux à corriger. **La compression
doit donc être vérifiée à la mise en ligne** — c'est le premier point de la recette de déploiement.

Aucun des interdits n'a été réintroduit : le CSS principal reste **synchrone** (pas de flash sans
style), aucun décalage de mise en page n'a été créé, aucune section n'a été supprimée, aucune image
n'a été remplacée par un rectangle ou un placeholder. Le seul changement de chargement est le
préchargement de police, qui pointe désormais le **poids 800** — celui que le H1 utilise réellement
depuis la correction de graisse — au lieu du 700.

---

## 7. Défauts de fidélité restants — ce qui empêche la validation

Ces écarts ne sont **ni** juridiques **ni** commerciaux. Ils sont mesurés, nommés, et relèvent de la
fidélité au prototype.

### 7.1 Hauteur, à 1440 px

40 routes sur 53 sont entre 95 et 105 %. Les 13 autres :

| Route | Rapport | Métrique responsable |
|---|---|---|
| `#/politique-de-confidentialite` | 149 % | **Autorisé** — contenu juridique réel, plus long que le prototype (mots : 150 %) |
| `#/mentions-legales` | 137 % | **Autorisé** — idem (mots : 137 %) |
| `#/gestion-des-cookies` | 126 % | **Autorisé** — idem (mots : 139 %) |
| `#/conseils` | 117 % | Défaut — barre de catégories qui repasse à la ligne, carte « à la une » plus haute que la maquette |
| `#/avis-clients` | 115 % | Défaut — grille de témoignages sur 2 colonnes au lieu de 3 |
| `#/article/cahier-des-charges-nettoyage` | 114 % | Défaut — interlignes de prose et rembourrage des blocs de FAQ |
| `#/demande-de-devis` | 113 % | Défaut — hauteur des champs du formulaire supérieure à celle du prototype |
| `#/article/frequence-bureaux` | 110 % | Défaut — même cause que l'article ci-dessus |
| `#/nos-tarifs` | 109 % | Défaut — cartes de la grille tarifaire plus hautes que la maquette |
| `#/nos-prestations` · `#/article/cout-nettoyage-bureaux` | 106 % | Défaut — marges de section |
| `#/a-propos` | 93 % | Défaut — colonne de contenu plus large que celle du prototype (724 px) |
| `#/nettoyage-professionnel` | 92 % | Défaut — grilles à plus de colonnes que la maquette sur cinq bandes |

### 7.2 Styles calculés

`docs/VERIFICATION-VISUELLE-53-ROUTES.md` relève **695 écarts** sur 106 couples route × largeur. Ils
se répartissent en trois natures :

1. **Vocabulaire de cartes** (rayons, fonds, filets employés — 296 cas) et **nombre de cartes**
   (53 cas). La maquette emploie plus de micro-cartes décoratives que le thème : sur
   `/nettoyage-professionnel/` elle en compte 40 contre 24 après correction, sur `/service/cabinets/`
   25 contre 10. C'est le défaut de fidélité résiduel le plus important, et il est visible à l'œil ;
2. **Colonnes des grilles** (38 cas) : sur plusieurs bandes, le thème répartit les cartes sur un
   nombre de colonnes différent de celui du prototype ;
3. **Taille et interligne du texte** (107 cas) et **largeur du conteneur** (48 cas), essentiellement
   sur les bandes internes des pages statiques : le relevé de largeur porte aujourd'hui sur le hero,
   pas sur les bandes de contenu.

### 7.3 Images

Les visuels servis ne sont pas les visuels du prototype. Les images de la maquette sont encodées en
base64 dans le fichier de référence et `assets/` est en lecture seule : le thème sert son propre jeu
d'illustrations, de même nature et de même rôle, mais différent. Aucun `alt` ne prétend représenter
une personne, un client ou un local réels (`CLAUDE.md §5.6`).

---

## 8. Ce qui reste bloquant avant toute mise en ligne

Indépendamment de la fidélité :

1. **le nombre réel d'avis Google et l'URL de la fiche Google Business** — le badge s'affiche sans
   eux, mais le compteur reste absent tant qu'ils ne sont pas fournis ;
2. **la validation par Audrey de la citation qui lui est attribuée** (§3) ;
3. **la photo authentique d'Audrey**, en remplacement du visuel d'illustration provisoire ;
4. **le remplacement des témoignages provisoires** par de vrais avis clients ;
5. **l'attestation d'assurance en responsabilité civile professionnelle**, pour rétablir la section
   correspondante des mentions légales ;
6. **la validation, une par une, des huit communes secondaires** par Audrey — elles restent en
   `noindex,follow` et hors sitemap tant que ce n'est pas fait.

---

## 9. Comment rejouer ces contrôles

```bash
# Fidélité — contenu, hauteurs, triptyques
node tools/compare-routes.mjs                    # 53 routes, 1440 px + 375 px, 106 triptyques
node tools/diff-text.mjs                         # 0 bloc manquant, 6 écarts voulus
node tools/compare-styles.mjs                    # styles calculés, 53 routes × 2 largeurs
node tools/validation-finale.mjs                 # 12 routes en superposition
node tools/measure-chrome.mjs '#/ville/dijon'    # sépare la coquille du flux de contenu

# Conformité
npx playwright test                              # 833 tests
node tools/audit-target-size.mjs                 # WCAG 2.2 AA 2.5.8, condition par condition
node tools/audit-jsonld.mjs                      # FAQPage visible, aucun Review/AggregateRating
node tools/image-map.mjs                         # images cassées, alt manquants, LCP

# Performance, dans les deux environnements
node tools/banc-production.mjs &                 # compression + cache devant le rig (port 8902)
CHROME_PATH=/opt/pw-browsers/chromium npx lighthouse http://localhost:8902/ \
  --only-categories=performance,accessibility,best-practices,seo \
  --chrome-flags="--headless --no-sandbox"
```
