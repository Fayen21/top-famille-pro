# Rapport — passe visuelle, décisions du 14 octobre 2026

> Branche `hotfix-production-fidelite-claude-design`, PR #9, commit `f516b6d` (21 octobre 2026).
> **Rien n'a été fusionné dans `main`, rien n'a été déployé, aucun DNS n'a été touché.**
> Aucun e-mail réel n'a été envoyé pendant les tests : la suite fonctionnelle tourne sur un banc
> `development` où l'envoi est neutralisé, et le banc `production` ne reçoit aucune soumission.
>
> **Statut : `PRET_POUR_VALIDATION_VISUELLE_HUMAINE`.** Aucun statut de validation finale n'est
> posé ici ; il ne peut l'être que par Emmanuel, sur les captures de ce rapport.

---

## 1. Environnement de travail

| | |
|---|---|
| Banc | WordPress + SQLite monté par `tools/banc-local.sh` dans `/tmp/tfp-rig`, servi sur `localhost:8901` ; `production` pour les mesures, `development` pour la suite fonctionnelle |
| Navigateur | Chromium `/opt/pw-browsers/chromium`, Playwright 1.62.1 |
| Outils | Node 22.22.0, PHP 8.3.6, Lighthouse 13.4.1, mapshaper 0.7.93 |
| Largeurs de contrôle | 320 · 375 · 768 · 1024 · 1440 · 1920 px, plus 819/820, 1099/1100 et 1219/1220 pour le header |
| Banc — correctif | le serveur intégré de PHP répondait 404 aux sitemaps natifs (`/wp-sitemap*.xml`) avant même WordPress ; `tools/banc-router.php` est désormais passé à `php -S`, comme la réécriture d'un hébergement réel. Trouvé par `tests/decisions.spec.js` pendant la suite complète ; aucun test n'a été modifié |

**Les six captures citées par la consigne (`image(20261014-*).png`) n'étaient présentes nulle
part dans l'environnement.** L'état de travail a donc été capturé avant toute modification
(`docs/captures-passe-visuelle/avant/`) et chaque défaut décrit par la consigne y a été retrouvé
et mesuré avant d'être corrigé. Ni le site public ni ses captures n'ont servi de référence.

---

## 2. Écrans réellement examinés

`tools/revue-visuelle.mjs` ouvre les **53 routes de travail à 375 et 1440 px**, déplie toutes
les FAQ, parcourt chaque page jusqu'au pied de page (chargement différé déclenché), ouvre le menu
« Zones d'intervention » sur l'accueil (panneau à 1440, tiroir à 375) et amène le formulaire de
devis à son étape 2 avec des valeurs valides. Cela fait **106 écrans pleine page + 4 écrans
d'état**, découpés en tuiles de 1 800 px (1440) et 2 400 px (375) pour une lecture réelle. Ces
tuiles ont été lues une à une ; la colonne « Lecture humaine » de **`docs/REVUE-VISUELLE.md`**
porte, route par route, ce qui a été vu et ce qui a été corrigé.

Le relevé automatique (débordement de page, texte hors boîte, mot coupé, bandes à deux CTA, images
sans dimensions, jargon de chantier, cibles < 24 px, erreurs console, pied de page atteint) est
vierge sur les 106 écrans après correctifs. Il trie la lecture, il ne la remplace pas.

Les pleines pages (78 Mo) et les tuiles se régénèrent en une commande et ne sont pas commitées
(`.gitignore`) ; la matrice, le JSON du relevé et la lecture humaine le sont.

---

## 3. Les composants refaits sur décision

Chaque point ci-dessous nomme la cause dans le thème, pas seulement le symptôme. Les captures
avant/après sont dans `docs/captures-passe-visuelle/{avant,apres}/`.

### 3.1 Header

- **Cause** : l'entrée « Zones » était un panneau à deux liens (`template-parts/header/site-header.php`,
  `mobile-nav.php`), le téléphone un bouton à libellé long qui passait sur deux lignes.
- **Fait** : six entrées (Prestations, Tarifs, **Zones d'intervention**, Pourquoi nous, Avis,
  Conseils) ; le panneau Zones liste les **huit départements** avec leur numéro en pastille
  (`tfp_departements_nav()`, `includes/site-options.php`) puis « Voir toutes les villes → » ; même
  contenu dans l'accordéon mobile. Un seul CTA dominant, téléphone secondaire sans retour à la
  ligne (`white-space: nowrap`, cible ≥ 44 px).
- **Limites** : budget de largeur tenu à 819/820, 1099/1100 et 1219/1220 px — règle dédiée
  `1100–1219 px` (rembourrage 24, liens 10 px, libellé du téléphone masqué, icône seule à 44 px).
  Vérifié par `tests/passe-visuelle.spec.js` (« header limites »).

### 3.2 Villes et codes postaux

- **Cause** : `tfp_card_grid()` rendait les villes avec la variante « en ligne » d'une carte
  générique, nom et code postal sur la même ligne au même corps.
- **Fait** : modificateur dédié `tfp-card-tile--ville` / `tfp-card-grid--villes`
  (`includes/components.php`, `04-components.css`) : nom sur sa ligne, **« Code postal : 21000 »**
  sur la sienne à 13,5 px, cinq colonnes à 1440, repli automatique ; titres « Nos villes
  d'intervention » et « Autour de Dijon et de Beaune », plus aucun « communes secondaires »,
  « pages déjà documentées » ni « d'autres suivront » dans le texte public — corrections posées
  **dans le générateur** (`tools/generate-pages.mjs`, `tools/generate-zones.mjs`), jamais dans
  l'export.

### 3.3 Accueil — libellés et bandeau

- « **Appeler Top-Famille Pro** » partout (`tfp_phone_cta_label()`), `aria-label` « Appeler
  Top-Famille Pro au 06 36 17 63 39 » sur le hero, le header, la barre mobile et le contact ;
  microcopie « Devis étudié personnellement ».
- **Bandeau tarifaire** : composant partagé `tfp_bande_tarif()` — groupe [prix + « Voir les
  tarifs → »] puis groupe [trois garanties] sous lui, empilement sous 560 px. Le même composant
  sert l'accueil et les six bandeaux relevés des pages statiques (pilier, index des zones,
  région…), qui sortaient en deux barres marine et un texte nu.
- **`tfp-zone-band`** sur les 26 pages de zone : même composition (bouton à côté du prix).

### 3.4 Les cinq étapes

- **Cause** : collision de classe `.tfp-step` entre `04-components.css` (`display: flex`) et la
  redéfinition de `05-home.css` ; les cartes sortaient désalignées.
- **Fait** : `template-parts/home/process.php` refait — « Votre prestation, en 5 étapes »,
  liste ordonnée `<ol class="tfp-etapes">`, variante dédiée `.tfp-etape` (numéro en pastille,
  titre, description, verticale, `overflow-wrap: anywhere`), textes de la consigne.

### 3.5 Carte régionale

- **Cause** : carte décorative sans géométrie ; le marqueur n'était pas Saint-Apollinaire.
- **Fait** : `template-parts/home/coverage.php` + partiel **généré** `carte-bfc.php` par
  `tools/carte-bfc.mjs` : SVG `viewBox 0 0 640 498`, huit `<a>` cliquables vers les pages
  département (`aria-label`, `<text>` du numéro), **un seul marqueur** « Implantation de
  Top-Famille Pro » à Saint-Apollinaire (5,09312 E · 47,33600 N), liste accessible des huit
  départements à gauche, source citée sous la carte. Voir §5 pour les données.

### 3.6 Gérante et portrait

- **Fait** : `template-parts/home/audrey-reviews.php` — titre « Audrey Brançon, gérante de
  Top-Famille Pro », phrase de présentation de la consigne, signature « Gérante, Top-Famille Pro —
  Saint-Apollinaire ». Portrait réduit de **420 × 525 à 294 × 368 px** (−30 %) **par la colonne**
  (`flex: 0 1 294px`, `width`/`height` HTML 294/368), pas par `transform`. Photo d'illustration
  et mention « Photo d'illustration » conservées, ni authenticité ni citation rouvertes.

---

## 4. Audit transversal — ce que la lecture des 106 écrans a révélé et corrigé

Tout est corrigé **à la source** (gabarits PHP, CSS source, générateurs, seeds, ACF) puis
régénéré ; aucun export ni CSS minifié n'a été retouché à la main.

| Défaut vu | Routes | Cause | Correctif |
|---|---|---|---|
| Carte régionale aplatie en une phrase collée « Bourgogne-Franche-ComtéLa page régionale… » | index des zones | le relevé classait tout `<a>` trop grand pour un bouton en « ligne » | archétype `carte` relevé (titre / sous-ligne / pastille), rendu `.tfp-carte-lien` |
| Même rangée de 18 pastilles affichée deux fois ; « Dijon » en pastille orpheline | Côte-d'Or | requête villes + communes rendue par chaque groupe « villes » | villes (niveau 2) en **rangées** « Dijon · 21000 → », communes (niveau 3) en pastilles ; nom inerte jamais doublé d'une page existante (Beaune) |
| « Dans le même département » et « Autres secteurs » listaient tous deux les sept communes proches, phrase contraire à la liste | 18 villes et communes | le gabarit reconstruisait chaque groupe depuis le département | **cibles relevées** par groupe (`locaux_N_cibles`, champ ACF nouveau) ; rangée « Nettoyage en Côte-d'Or → » ; numéro de département derrière chaque nom d'un groupe régional (« Mâcon (71) · Dijon (21) · Dole (39) ») |
| « Des guides locaux… viendront compléter cette page » (CLAUDE.md §9) | 18 villes et communes | phrase de la maquette recopiée | supprimée dans `tools/generate-zones.mjs`, comptée (18), la génération échoue si elle disparaît de la maquette |
| Bandeau tarifaire en deux barres marine + garanties nues ; garanties répétées en texte sous le bandeau | pilier, index des zones, région, prestations, tarifs, pourquoi | panneau relevé rendu en grille générique | `tfp_bande_tarif()` partagé, paragraphe/note des garanties consommé |
| Cartes en **texte blanc sur fond clair**, cartes « vides » | pilier (« Tâches par espace », « Fréquences »…) | `estSombre('rgba(0, 0, 0, 0)')` lisait l'absence de fond comme du noir | alpha 0 ⇒ clair, et thème jugé sur le fond **effectif** (ancêtre peint) |
| Intertitres relevés en 600 rendus en notes grises | pilier | graisse non relevée sur les `span` | graisse relevée, `.tfp-prose--intertitre` |
| Cartes bordées des **quatre côtés** au lieu du seul filet haut | pilier (6), pourquoi (12), à-propos (4) | `borderTopWidth` appliqué à `border` | quatre largeurs relevées (`filet_cotes`), `--tfp-tuile-filet-largeurs` |
| Appels finaux à fond primaire alignés à gauche ; sur l'index des zones, deux **cartes blanches** pleine largeur au lieu de deux boutons | 8 bandes primaires | `text-align` de bande non relevé ; libellé de 43 caractères refusé comme commande | `alignement` relevé ⇒ `.tfp-section--centre` ; une commande de 41–60 caractères dans une rangée flex reste un bouton |
| Cinq phrases « Ce qui change selon votre adresse » en gras | index des zones | carte réduite à un texte : graisse de titre imposée | graisse relevée sur une carte à texte unique |
| Puces turquoise collées sous chaque ligne ; carte « Ce qui est inclus » blanche | tarifs | règle `--nue` écrite **avant** la règle générale à spécificité égale | règle réordonnée et spécifiée ; `.tfp-card--inclus` |
| Tableau coupé net à 375 px sans indice de défilement | tarifs, articles | conteneur `overflow-x: auto` nu | ombres de défilement CSS (`background-attachment: local`) |
| Cartes d'orientation grises sans état actif ni flèche ; carte « Horaires » resserrée à la moitié de la colonne, mention flottante | contact | couleur par défaut d'un `<button>` relevée ; `li` flex sans repli | état actif fond primaire, carte blanche cliquable avec flèche ; `flex-wrap` + mention pleine largeur sous la carte |
| Panneau blanc vide de 110 px ne contenant que « Demander mon devis » | avis | relevé de la note fictive, écartée au rendu | bande sautée tant que la note réelle n'est pas saisie ; `.tfp-avis-panneau` prêt le jour où elle l'est |
| « ☎ Appeler Audrey » | avis | libellé de la maquette | aligné sur `tfp_phone_cta_label()` |
| Titre « Droit applicable » en double ; vide de 136 px chapeau → premier chapitre ; chapitres collés | 3 pages légales | `h2` dupliqué ; cumul 52 + 84 px de bandes | titre unique, `.tfp-legal-tete` / `.tfp-legal-corps`, `h2:not(:first-child)` espacé |
| « Communes secondaires » | plan du site, départements | intitulés de la maquette | « Autour de Dijon et de Beaune » (gabarit, générateur des zones) |
| Sous-titres `h3` collés à la rangée précédente | départements | pas de marge haute | 20 px / 17 px / 700, relevés maquette |
| `h3` collé au paragraphe dans « Trois configurations » | 6 prestations | pas d'écart | `.tfp-card > h3 + p { margin-top: 10px }` |
| Cibles tactiles < 24 px (icône téléphone du header, téléphone de la barre haute, liens « → » du pied) | toutes | tailles non contraintes | min 44 / 30 / 24 px |
| Tiroir mobile capturé écrasé en tête d'une image de 13 000 px ; étape 2 du devis jamais atteinte (le régime est un `<select>`) | outil de revue | — | capture fenêtre, sélection correcte |

Hors périmètre, **signalés et non tranchés** : voir §9.

---

## 5. Données géographiques

Documenté intégralement dans **`docs/CARTE-BFC-SOURCE.md`** (généré par `tools/carte-bfc.mjs`).

| | |
|---|---|
| Producteur · millésime | **IGN — ADMIN EXPRESS COG, édition 2018** |
| Licence | Licence Ouverte 2.0 (Etalab) |
| Chemin d'accès | dérivé GeoJSON *france-geojson* (G. David), `departements-bourgogne-franche-comte.geojson`, récupéré le 21 octobre 2026 — les catalogues IGN, data.gouv.fr, geo.api.gouv.fr et DataBFC ne sont pas joignables depuis l'environnement (proxy sortant) |
| Transformation | mapshaper *visvalingam weighted* 25 % en amont, **8 %** ici (topologie préservée), projection plate carrée × cos(47,275°), échelle commune, arrondi 0,1 px |
| Contrôle | le script refuse tout jeu qui n'est pas exactement {21, 25, 39, 58, 70, 71, 89, 90} ; `tests/passe-visuelle.spec.js` compare le nombre de sommets rendus au GeoJSON versionné (`tools/data/`) |
| Siège | Saint-Apollinaire (code INSEE 21540 ; code postal 21850), centroïde de la commune ADMIN EXPRESS, un seul marqueur |

---

## 6. Contrôles rejoués

| Contrôle | Résultat |
|---|---|
| `npm run lint:php` | 83 fichiers, 0 erreur |
| Ce que la suite a mordu, et ce qui en a été fait | **axe `nested-interactive`** sur l'accueil : la carte SVG portait `role="img"`, qui rend ses huit liens présentationnels → `role="group"`. **axe `color-contrast`** sur les pages département : le code postal en `#7FAEBF` de la maquette donne 2,41:1 → gris tertiaire du thème (≈ 5:1), comme l'accueil l'avait déjà fait. **Checkpoint `navigation-six-entrees`** : l'entrée s'appelle désormais « Zones d'intervention » — décision du 14 octobre inscrite dans `docs/DECISIONS.json` (historique conservé dans `remplace`). **Sitemaps 404 sur le banc** : routeur ajouté (ci-dessus). **Parité** : les archives n'existaient pas encore au moment du premier passage ; rejouée après `npm run paquets` |
| `npm run build` | CSS/JS reconstruits, images régénérées |
| Suite Playwright complète (banc `development`) | **1 303 contrôles** : 1 298 verts au premier passage, **5 échecs instruits** (ligne suivante) ; les spécifications concernées ont été rejouées après correctif — accessibilité + passe visuelle + navigation **68/68**, checkpoint + crawl + SEO + unicité + contact + ACF + provisoire **782/782**, parité **4/4**. Aucun test modifié pour passer |
| `tests/passe-visuelle.spec.js` — contrôles nouveaux | **48 / 48** : code postal distinct du nom à 6 largeurs, texte dans les cartes, destinations géographiques des huit départements (carte et menu), huit géométries officielles, header aux limites, étapes verticales, bandeau, gérante 294 × 368, carte-lien, rangées de villes, maillage des pages ville, bandes centrées, filets d'un côté, listes nues, contact, pages légales, plan du site |
| axe-core (`tests/accessibility.spec.js`) et clavier (`tests/navigation.spec.js`) | dans la suite ci-dessus |
| Cibles tactiles 2.5.8 (`tests/target-size.spec.js`) | dans la suite ci-dessus |
| Relevé de base 53 × 6 (`tools/baseline.mjs`, `tests/ratios-baseline.spec.js`) | **318/318** contrôles relevés à neuf · **300** dans 95–105 % (seuil 298) · les 18 hors plage sont les trois pages légales aux six largeurs, exception autorisée · `/avis-clients/` revient dans la plage · 0 débordement horizontal · 0 erreur console ou réseau · accueil 98–104 % malgré la carte, les étapes verticales et le portrait réduit |
| Parité dépôt ↔ installeur (`npm run parite`, `npm run paquets`) | **1 266 fichiers** comparés par empreinte, archives conformes au dépôt ; `topfamillepro-theme.zip` 472 fichiers (8,33 Mo), `topfamillepro-content-installer.zip` 20 fichiers ; `tests/parite-installeur.spec.js` 4/4 après reconstruction |
| Export statique (`tools/export-statique.mjs`) | 53 routes · 0 statut non-200 · 0 ressource locale manquante · 0 fichier contenant « localhost » · 0 image cassée (53 routes × 2 largeurs) · 0 requête externe · 53/53 ouvrables hors ligne (`--verifier` rejoué) |
| Lighthouse (banc « production », `tools/lighthouse.mjs`) | **14 mesures sur 14 conformes** (banc « production », compression et cache comme LiteSpeed) : performance mobile 99–100, bureau 100 ; accessibilité, bonnes pratiques et SEO 100 partout ; LCP mobile 1,66–1,98 s (accueil 1,98 s avec la carte SVG en ligne), bureau 0,41–0,48 s ; CLS 0,000 ; TBT ≤ 92 ms. Détail : `docs/LIGHTHOUSE.md` |

---

## 7. Captures

- **Avant / après ciblés** (`docs/captures-passe-visuelle/`) : header fermé et ouvert à 1440 et
  375, header à 819/820/1099/1100, villes à 1440 et 375, communes, bandeau tarif, bandeau zone,
  étapes à 375/768/1440, carte à 1440 et 375, gérante à 1440 et 375, accueil complet. Mesures
  dans `mesures.json` (hauteurs, boîte du portrait).
- **Revue transversale** : 106 pleines pages + menu Zones (1440), tiroir mobile (375), étape 2
  du devis (1440 et 375) — régénérables par `TFP_BASE_URL=http://localhost:8901 node tools/revue-visuelle.mjs`.
- Matrice : `docs/REVUE-VISUELLE.md` (relevé automatique + lecture humaine, 53 lignes).

---

## 8. Invariants vérifiés

- Tarif **27 € HT/h**, frais et exemples inchangés (`tests/tarifs.spec.js` dans la suite).
- Huit communes secondaires en **`index,follow`** (`tests/decisions.spec.js`).
- Note Google globale **masquée** ; photo d'illustration et citation d'Audrey inchangées.
- Formulaires, sommaires, préremplissage, export : corrections de l'audit précédent conservées
  (suite complète).
- Aucun contrôle supprimé ; ceux qui ont mordu ont été corrigés dans le thème, pas dans le test.

---

## 9. Ce qui reste, et à qui

1. **Validation visuelle humaine** des captures `apres/` et de la matrice — c'est l'objet de ce
   rapport. Statut `PRET_POUR_VALIDATION_VISUELLE_HUMAINE`.
2. **« ☎ Échanger avec Audrey · 06 36 17 63 39 »** sur les appels finaux des 26 pages de zone et
   de la page région : c'est le champ ACF `cta_phone_label` relevé sur la maquette, hors du
   périmètre de la décision du 14 octobre (qui vise l'accueil). À aligner sur « Appeler
   Top-Famille Pro » **si** Emmanuel le décide — un changement de seed, pas de gabarit.
3. **Intitulé de la couverture régionale** : la maquette écrit « Une couverture régionale, pas des
   agences fictives » ; CLAUDE.md §9 impose « Une entreprise régionale basée à Saint-Apollinaire ».
   Emmanuel avait différé cette reformulation le 10 août (« reproduire d'abord »). Le bloc ayant
   été refait, le moment de trancher est venu ; l'intitulé de la maquette est conservé en
   attendant.
4. **Phrase doublée** sur le pilier, sous « Intervenant habituel et continuité » (« Un intervenant
   habituel est recherché. En cas d'absence… ») : contenu de la maquette, à corriger par une
   entrée de `CORRECTIONS_EDITORIALES` si Emmanuel le souhaite.
5. **Accès direct aux données IGN** : si une passe ultérieure dispose d'un accès réseau aux
   catalogues officiels, régénérer depuis ADMIN EXPRESS avec le même script suffit.
6. Ce qui était déjà en attente et n'a pas bougé : photo définitive d'Audrey, avis réels et
   fiche Google, confirmation Kbis (bloqueur de mise en ligne), envoi réel du formulaire.
7. **Paquet de livraison** : les archives de `release/` (correctif 0.13.0 de la clôture du
   13 septembre) ne sont **pas** reconstruites par cette passe — un paquet se reconstruit à la
   clôture, après validation visuelle. Les archives de travail `export/*.zip` l'ont été, et la
   parité dépôt ↔ archives est vérifiée (§6). Une passe de clôture devra passer la version du thème
   (0.13.0 → 0.14.0) et rejouer `npm run paquets` vers `release/`.
