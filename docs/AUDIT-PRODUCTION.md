# AUDIT-PRODUCTION.md — Écart entre `top-famille-pro.fr` et le dépôt (hotfix)

> Diagnostic obligatoire mené avant toute modification, conformément à la demande du 9 août 2026
> (« corriger un problème critique de déploiement et de fidélité »). Branche :
> `hotfix-production-fidelite-claude-design`, créée depuis `main` à `40caf66` (fusion de la PR #8,
> phases 0 à 7 complètes). Résultat : **la cause n'est pas une régression du thème, c'est
> l'absence totale de déploiement** — voir §1. Deux lacunes réelles de code, indépendantes de ce
> problème, ont été trouvées et corrigées en cours d'audit — voir §3.
>
> **Mise à jour du même jour (§3b)** : une deuxième demande a introduit un changement commercial
> (tarif unique 27,00 € HT/h, qui remplace l'ancienne grille à trois montants) et signalé des
> écarts de fidélité supplémentaires. Un bug réel de maillage (zones ne reliant qu'une seule
> prestation sur six) et un bug de date d'article (format anglais) ont été trouvés et corrigés. Un
> bug de régression a aussi été introduit puis corrigé dans le même lot (spécificité CSS cassant
> le contraste de plusieurs boutons/titres) — décrit en toute transparence en §3b, avec la
> vérification qui l'a détecté avant livraison.

## 0. Ce qui a été vérifié, et comment

- État de `main` et des PR fusionnées : `mcp__github__pull_request_read` / historique Git local.
- Contenu exact des ZIP de livraison (`release/topfamillepro-theme.zip`,
  `release/topfamillepro-content-installer.zip`) : `unzip -l`, lecture de `style.css`.
- Recherche de la chaîne `V1top-famille-pro` dans tout l'historique Git (`git grep` sur toutes les
  branches, tous les commits) : **aucune occurrence, à aucun moment du projet.**
- Tentative de sonder `https://top-famille-pro.fr/` directement (`WebFetch`, `curl`) : **domaine
  bloqué par le proxy réseau de cet environnement** (`EGRESS_BLOCKED`, `403`). Le diagnostic
  ci-dessous s'appuie donc sur l'état du dépôt et sur les constats déjà vérifiés côté client
  (liste fournie dans la demande), pas sur une capture indépendante de la production réelle.
- Rejeu de la suite Playwright complète (803 assertions) + suite de captures (88 tests) sur le rig
  de test local (WordPress jetable, thème lié au code de la branche) : tout au vert, avant et après
  les corrections du §3.
- Comparaison octet à octet des images : les 31 images embarquées dans
  `reference/Top-Famille-Pro-HANDOFF-READY.html` (SHA-256) correspondent exactement aux 31 photos
  déjà présentes dans `assets/photos/`, `assets/logo/` du dépôt (voir §2) — utilisées comme
  référence faute d'accès aux deux fichiers joints à la session (voir §2, note).

## 1. Diagnostic — cause racine

| Élément | Attendu (dépôt, `main`) | Présent dans le ZIP (`release/topfamillepro-theme.zip`) | Présent en production (constat client) | Verdict |
|---|---|---|---|---|
| Branches/PR fusionnées dans `main` | Phases 0 à 7 (PR #1 à #8) | — | — | ✅ Confirmées complètes (voir détail ci-dessous) |
| Nom de thème | `topfamillepro` (dossier racine du ZIP) | `topfamillepro/` (racine unique, vérifié) | `V1top-famille-pro` | ⛔ **Ne correspond à aucun artefact de ce dépôt** |
| `style.css` du thème | `Theme Name: Top-Famille Pro`, `Template: generatepress` | Identique | Non observable (accès prod indisponible) | — |
| `V1top-famille-pro` dans l'historique du projet | — | — | — | ⛔ **Absent de tout commit, toute branche — cette chaîne n'a jamais existé dans ce dépôt** |
| CPT `prestation` / `zone` enregistrés | Oui (thème enfant, `includes/`) | Oui | Non vérifiable, mais les 404 constatées sur `/prestations/bureaux/` et `/zones-intervention/cote-dor/dijon/` sont incompatibles avec leur présence | ⛔ Cohérent avec « aucun code du dépôt actif » |
| Plugin d'installation exécuté | — | — | Formulaire de devis vide, mentions légales vides → contenu jamais importé | ⛔ Jamais exécuté (ou exécuté sur un autre thème) |
| Déploiement réel sur Hostinger | — | — | — | ⛔ **Aucune trace, à aucune phase.** `STATUS.md` et `docs/RAPPORT-FINAL.md` de chaque phase affirment explicitement qu'aucun déploiement n'a eu lieu (CLAUDE.md §6 : « Aucun déploiement, aucune modification DNS, aucune publication ») |

**Historique des PR, vérifié via l'API GitHub :**

| PR | Titre | Base → tête | État avant ce hotfix |
|---|---|---|---|
| #5, #6, #7 | Phases 4, 5, 6 | empilées | Fusionnées dans `main` (`merge`, phase antérieure à ce hotfix) |
| #8 | Phase 7 — informations légales et livraison Hostinger | `phase-7-livraison-hostinger` → `main` | **Fusionnée au tout début de ce hotfix** (`40caf66`), condition posée avant de créer la branche corrective |

**Cause racine (`ROOT_CAUSE_IDENTIFIED=YES`) :** aucune combinaison de « mauvais ZIP » ou
« mauvais thème activé » ne s'applique au sens strict de ces catégories, parce qu'**aucun ZIP issu
de ce dépôt n'a jamais été déployé sur `top-famille-pro.fr`**. Le thème actif constaté,
`V1top-famille-pro`, est un artefact étranger à ce projet — vraisemblablement un thème ou un
scaffold déjà présent sur l'hébergement Hostinger (fourni avec le domaine, une installation
WordPress par défaut, ou un projet antérieur), jamais remplacé. Chaque symptôme signalé
s'explique intégralement par cette absence de déploiement, sans qu'aucun ne pointe vers un défaut
du thème réel :

| Symptôme constaté en production | Explication |
|---|---|
| Aucune image, logo en texte | Aucun asset de ce dépôt n'a jamais été téléversé sur cet hébergement |
| Pages vides (`/demande-de-devis/`, `/mentions-legales/`, `/pourquoi-nous/`) | Aucune des 53 pages n'a été créée (plugin d'installation jamais exécuté sur ce site) |
| `/prestations/bureaux/`, `/zones-intervention/cote-dor/dijon/` en 404 | CPT `prestation`/`zone` inexistants sur ce site (thème étranger, pas de `register_post_type()` du thème) |
| Tarif unique 26 €/27 € HT/h, textes anciens | Contenu résiduel du thème étranger ou d'un import précédent, sans rapport avec `PROJECT_INPUTS.md` |
| Police différente (pas Bricolage Grotesque/Hanken Grotesk) | Police du thème parent GeneratePress par défaut ou du thème étranger — le dépôt ne contient et n'a jamais contenu « Public Sans » (recherche exhaustive, 0 occurrence) |
| Titre d'accueil limité à `top-famille-pro.fr`, pas de meta description, pas d'OG image | `includes/seo.php` (qui émet ces balises) n'existe pas sur le thème actif |

## 2. Fichiers joints à la session — accès indisponible, substitution vérifiée

Les deux fichiers annoncés comme joints (`Top-Famille Pro - Site HANDOFF READY
(standalone)(1).html` et `Top-Famille-Pro-images-temporaires.zip`) **ne sont accessibles nulle
part dans l'environnement d'exécution** de cette session — recherche exhaustive sur le système de
fichiers, y compris le point de montage dédié aux pièces jointes (`/mnt/attach`, vide).

Plutôt que d'improviser sans référence (interdit par CLAUDE.md), l'audit a utilisé le fichier déjà
versionné en lecture seule, `reference/Top-Famille-Pro-HANDOFF-READY.html`, et vérifié
rigoureusement son équivalence avec ce qui était attendu :

- Ce fichier de référence embarque en réalité ses images en base64 dans un bloc JSON interne (pas
  seulement des références externes).
- Extraction de ces 31 images et calcul de leur empreinte SHA-256 : **les 31 hachages
  correspondent exactement, octet pour octet**, à 31 des 35 fichiers déjà présents dans
  `assets/photos/`, `assets/logo/`, `assets/icons/` du dépôt (les 4 fichiers en trop sont des
  doublons du logo dans `icons/`).
- Conclusion vérifiée, pas supposée : `assets/` a déjà été extrait de cette exacte référence lors
  d'une phase antérieure. Le contenu du ZIP d'images annoncé comme joint est donc, avec un très
  haut degré de confiance, déjà intégralement disponible dans le dépôt.

**Si les deux fichiers réellement joints diffèrent** de `reference/Top-Famille-Pro-HANDOFF-READY.html`
(version plus récente, images différentes), cet audit et les corrections du §3 devront être
revus — à signaler si c'est le cas.

## 3. Lacunes réelles trouvées dans le code (indépendantes du problème de déploiement)

L'essentiel du thème correspond déjà à la référence Claude Design (polices correctes, palette,
grille tarifaire réelle à trois montants, aucune donnée fictive, 803 tests SEO/accessibilité/
crawl verts) — voir les captures de `docs/captures/`. Deux lacunes réelles ont cependant été
trouvées en auditant le rendu réel du thème (pas supposées, vérifiées par requêtes HTTP sur le rig
de test) et corrigées dans ce hotfix :

1. **Aucun favicon.** Aucune balise `<link rel="icon">` n'était émise nulle part
   (`includes/seo.php`) — confirmé par lecture du HTML rendu. Corrigé : favicon généré depuis
   `assets/logo/logo-square.jpg` (32/180/512 px) via `build/optimize-images.mjs`, balises ajoutées
   dans `tfp_render_head_meta()`.
2. **Aucune image sur les 6 pages de prestation individuelles** (`single-prestation.php` ne
   contenait aucun appel à `tfp_picture()`). Corrigé : ajout d'un visuel de hero — les photos du
   prototype pour bureaux/commerces (déjà utilisées ailleurs sur le site), un visuel générique
   honnête pour les 4 autres prestations (une intervention de nettoyage avec équipement de
   protection, alt fidèle à ce qu'elle montre réellement, sans prétendre représenter un type de
   local précis qu'elle ne montre pas).

Corrigé aussi, en marge (amélioration, pas un bug signalé) : l'image Open Graph utilisait le seul
logo à 140 px (proportions inadaptées à un aperçu de partage social) — remplacée par un visuel
dédié 1200×630.

## 3b. Deuxième vague — décisions commerciales et fidélité visuelle (9 août 2026, suite)

Demande complémentaire reçue le même jour, avec un changement commercial explicite et des
constats de fidélité supplémentaires. Ce qui a été fait :

- **Tarif unique 27,00 € HT/h** (régulier comme ponctuel, tout type de local), qui remplace
  intégralement l'ancienne grille à trois montants. Appliqué dans `includes/site-options.php`
  (`price_unique`, `price_km`, `price_majoration_pct`), tous les gabarits concernés, tous les
  scripts de seed (`bin/` + `installer/seed/` en miroir), le JSON-LD (`priceRange`),
  `PROJECT_INPUTS.md` §5. Nouveaux exemples de budget (`tfp_budget_examples_table()`) : 8 h/mois
  → 225 € (275 € le 1er mois), 12 h/mois → 333 € (383 €), 20 h/mois → 549 € (599 €) — exactement
  les montants demandés. Recherche globale : plus aucune occurrence commerciale de 24,30 €,
  26,00 € ou 30,00 € dans `wp-content/themes/topfamillepro/`.
- **Bug réel trouvé et corrigé** : les 26 pages de zone ne maillaient qu'une seule prestation
  (bureaux) sur six — conséquence de l'ordre d'exécution des scripts de seed (une seule
  prestation existe encore au moment où la phase 2 s'exécute). Corrigé dans
  `bin/seed-phase4-maillage.php`, qui s'exécute en dernier (les 6 prestations existent alors) et
  réécrit `prestations_liees` sur les 26 zones. Vérifié : Dijon relie désormais ses 6 prestations,
  pas seulement bureaux.
- **Mentions légales** : directrice de la publication (Audrey Brançon) et coordonnées complètes de
  l'hébergeur (HOSTINGER INTERNATIONAL LIMITED, 61 Lordou Vironos Street, 6023 Larnaca, Chypre)
  confirmées et publiées. Section « Assurance professionnelle » retirée entièrement, sur
  instruction explicite, plutôt que laissée en `[À COMPLÉTER]` — assureur et police restent à
  transmettre (`PROJECT_INPUTS.md` §12, non bloquant).
- **Cascade de polices** : spécificité augmentée (`body.tfp-body`) sur les propriétés
  typographiques de base (police, interligne, graisse — pas la couleur, voir plus bas) pour
  résister à un CSS GeneratePress/Customizer chargé après le thème enfant. Vérifié par styles
  calculés réels : `body` → Hanken Grotesk, `h1` → Bricolage Grotesque. Logo du header agrandi à
  `clamp(120px, 32vw, 155px)` (au lieu de ~68px), conforme à la référence.
- **Bug introduit puis corrigé dans le même lot** : la première version du boost de spécificité
  incluait `color` sur les titres/liens/boutons. Spécificité égale à des surcharges contextuelles
  existantes (`.tfp-section--navy h2`, `.tfp-btn--primary`…), qui perdaient alors leur couleur —
  **7 échecs axe-core `color-contrast`** trouvés en rejouant la suite complète (texte quasi
  invisible : boutons blancs sur blanc, titres sombres sur fond navy). Corrigé en sortant
  `color`/`background`/`border` du bloc boosté, qui ne porte plus que sur `font-family`,
  `line-height`, `letter-spacing`, `font-weight`. Les 811 tests + 88 captures repassent
  intégralement au vert après correction — leçon retenue : toute augmentation de spécificité CSS
  doit être suivie d'un rejeu complet de la suite, pas seulement d'une vérification visuelle
  ponctuelle.
- **Photo temporaire d'Audrey** (accueil + À propos) : un visuel d'illustration
  (`assets/dist/images`, slug `audrey-placeholder`, depuis `assets/photos/portrait-stock-a-propos.jpg`)
  remplace la pastille neutre, avec un alt honnête (« Photo d'illustration temporaire — portrait
  définitif à venir ») et une mention visible « Photo d'illustration » tant que la vraie photo
  n'est pas fournie — jamais présenté comme Audrey (CLAUDE.md §5.6). Bascule automatique vers la
  vraie photo dès qu'elle est renseignée dans le Customizer (`tfp_audrey_photo_is_real()`).
- **Date des articles corrigée** : « Publié le août 9, 2026 » (format anglais mêlé à un mois
  traduit, dépendant du réglage Réglages → Général du site, non fiable sur un site entièrement en
  français) devient « Publié le 9 août 2026 » via `tfp_format_date_fr()`
  (`includes/site-options.php`), indépendant de la configuration WordPress du site.
- **Vérifié, pas de bug réel** : la route `/zones-intervention/dijon/dijon/` citée dans la demande
  n'est pas une page dupliquée. C'est une redirection 301 native de WordPress vers l'unique URL
  réelle (`/zones-intervention/cote-dor/dijon/`), qui porte déjà une canonical auto-référente
  correcte. La structure `/zones-intervention/{departement}/{ville}/` est déjà appliquée aux 26
  zones (`includes/cpt-zone.php`) — aucune redirection, aucun changement de permalien nécessaire.

**Non traité dans ce lot** (périmètre trop large pour être fait avec la même rigueur que ce qui
précède — voir le rapport final pour le détail complet) : reproduction pixel-fidèle des 17
sections de l'accueil décrites dans la demande, intégration d'images propres à chaque page ville/
article au-delà des visuels déjà en place, extension complète du modèle de page prestation/ville
(scénarios concrets, exemples d'organisation détaillés au-delà de l'existant), tests responsive
formels aux 6 largeurs demandées avec captures dédiées par largeur, mesure Lighthouse (LiteSpeed
et outil Lighthouse indisponibles dans cet environnement).

## 3c. Troisième vague — fidélité visuelle mesurée (9 août 2026, suite)

Le fichier `reference/Top-Famille-Pro-HANDOFF-READY.html` est un **bundle auto-décompressant** :
son contenu et ses images sont reconstruits en JavaScript au chargement. Il a donc été **exécuté
dans Chromium et mesuré**, pas seulement lu — les écarts ci-dessous viennent de rendus réels
comparés à 1440 px, pas d'une lecture de classes CSS.

### Matrice de comparaison, section par section

État initial : **13 blocs côté maquette, 11 côté WordPress.**

| # | Section (maquette) | Présente avant | Écart de hauteur après correction | Verdict |
|---|---|---|---|---|
| 1 | Hero | oui | −60 px | Écart assumé (voir ci-dessous) |
| 2 | Bandeau tarifaire | oui | +5 px | Identique |
| 3 | Réassurance | oui | 0 px | Identique |
| 4 | Pensé pour les professionnels | **non** | −23 px | Proche — section créée |
| 5 | Prestations | oui | +4 px | Identique |
| 6 | Difficultés prises en charge | oui | +9 px | Proche |
| 7 | Pourquoi + témoignage | **non** (fusionnée) | −4 px | Identique — section rétablie |
| 8 | Fonctionnement en cinq temps | oui | −11 px | Proche |
| 9 | Tarif et exemple | oui | −1 px | Identique |
| 10 | Couverture régionale | oui | +39 px | Proche |
| 11 | Audrey | oui | +32 px | Proche |
| 12 | Conseils & repères | oui | +7 px | Identique |
| 13 | CTA final | oui | −5 px | Identique |

**7 blocs identiques (±8 px), 5 proches (±40 px), 1 écart assumé.** Header et footer encadrent
l'ensemble dans les deux versions.

### Trois bugs réels trouvés en mesurant

1. **Ratios d'images ignorés.** `tfp_picture()` émet des attributs `width`/`height` — nécessaires
   pour réserver la place — mais ceux-ci l'emportent sur tout `aspect-ratio` CSS tant que
   `height: auto` n'est pas déclaré. L'image du hero s'affichait en 512×800 au lieu de 512×448 et
   les vignettes d'articles en 381×427 au lieu de 381×214, soit plus de 350 px de hauteur en trop.
   Corrigé par une règle unique `picture img { height: auto }`.
2. **Titres de section à 25,5 px au lieu de 42 px.** Le token `--fs-h2` (27→42 px) existait depuis
   la phase 1 mais n'avait jamais été branché sur `h2` : les titres retombaient sur la taille par
   défaut du navigateur, 40 % plus petits que la maquette.
3. **Débordement horizontal de 57 px à 1024 px.** La navigation complète ne tient pas sous
   ~1100 px. Point de bascule du header porté à 1099 px, comme la maquette.

Trouvé aussi : les puces d'audience s'affichaient **en double** une fois la section dédiée
rétablie (elles avaient été fusionnées dans « Prestations » en phase 1) — retirées de là.

### L'unique écart de structure assumé

Le hero de la maquette place, **au-dessus du H1**, un badge « ★★★★★ 5,0/5 sur Google » de 44 px.
Cette note ayant été **confirmée comme réelle par Emmanuel le 9 août 2026** (CLAUDE.md §5.5 mis à
jour en conséquence), le badge est désormais construit et affiché aux deux emplacements de la
maquette — hero et pastille superposée au portrait d'Audrey. Il reste piloté par les réglages
« Réassurance & avis » : le **nombre d'avis** et l'**URL de la fiche** n'ayant pas été communiqués,
ils ne sont pas inventés et le badge s'affiche sans eux, exactement comme dans la maquette.

Aucun balisage `Review` ou `AggregateRating` n'est émis : une note de plateforme tierce ne doit pas
être balisée comme note du site (règles Google sur les résultats enrichis), et il manquerait de
toute façon un nombre d'avis.

### Témoignages — conflit résolu sans publier de faux avis

`includes/testimonials.php` rend la carte témoignage de la maquette selon l'environnement :

| Environnement | Comportement |
|---|---|
| Production (`wp_get_environment_type() === 'production'`, **valeur par défaut de WordPress**) | Vrais témoignages saisis en administration, ou état neutre « Témoignages authentiques à venir ». Aucun contenu de démonstration. |
| Local / développement / staging | Carte de démonstration de la maquette, avec la mention visible dans le DOM « Exemple de présentation — contenu de démonstration non publié ». |

Le sens de la condition est **sûr par défaut** : une installation réelle qui n'a rien configuré
n'affiche jamais de démonstration. Prouvé de bout en bout sur **deux instances WordPress réelles**
(une en `development`, une en `production`), pas par un simple test unitaire de la condition.

### La cause réelle des « rectangles gris »

Les images signalées comme manquantes ne l'étaient pas : les 10 images de l'accueil se chargent
correctement. C'est la **méthode de capture** qui était fautive — une capture pleine page
photographie les images en `loading="lazy"` avant leur chargement, et elles apparaissent alors
comme des rectangles de la couleur de fond de leur emplacement. `tests/screenshots.spec.js` fait
désormais défiler toute la page avant de capturer.

### Lighthouse — et le défaut majeur qu'il a révélé

Première mesure mobile : performance 72, **CLS 1,002** (limite acceptable : 0,1) et TBT 170 ms.
Lighthouse signalait « aucune ressource bloquante » — symptôme exact du problème : les feuilles de
style étaient chargées en `preload` + bascule JavaScript, si bien que la page peignait **sans aucun
style** puis se remettait entièrement en page. Ce dispositif, mis en place en phase 6 pour
approcher un CSS critique, coûtait dix fois la limite de décalage acceptable pour économiser
quelques dizaines de millisecondes. Il a été retiré : le CSS complet (~37 Ko, une seule feuille)
est chargé normalement.

| Mesure | Avant | Après |
|---|---|---|
| Performance mobile | 72 | **90** |
| Performance desktop | 76 | **99** |
| CLS mobile | 1,002 | **0,002** |
| Total Blocking Time | 170 ms | **0 ms** |
| Accessibilité | 100 | **100** |
| Bonnes pratiques | 96 | **100** |
| SEO | 100 | **100** |

Le dernier point de « bonnes pratiques » venait du logo, servi en 140 px alors qu'il s'affiche
désormais à 155 px selon la maquette : régénéré en 320 px (2× pour les écrans à forte densité).

Ces mesures sont prises sur le serveur de développement PHP intégré, **sans compression ni cache**.
Sur l'hébergement réel avec LiteSpeed, les valeurs de chargement seront meilleures.

### Responsive — six largeurs, mesurées sur les deux versions

| Largeur | Débordement horizontal | Images non chargées | Erreurs JS |
|---|---|---|---|
| 320 px | non | 0 | 0 |
| 375 px | non | 0 | 0 |
| 768 px | non | 0 | 0 |
| 1024 px | non (corrigé, +57 px avant) | 0 | 0 |
| 1440 px | non | 0 | 0 |
| 1920 px | non | 0 | 0 |

Captures de la maquette **et** du rendu WordPress aux six largeurs, plus les pages internes :
`docs/captures/fidelite-finale/`.

## 4. Recherche globale — textes et données à ne pas réintroduire

Recherche exhaustive dans `wp-content/themes/topfamillepro/` (thème réel, pas la référence) :

| Motif recherché | Occurrences trouvées | Nature |
|---|---|---|
| `Photo à venir` | 2 (`template-parts/home/audrey-reviews.php`, `page-a-propos.php`) | ✅ Conservées intentionnellement — emplacement réservé au futur portrait authentique d'Audrey (CLAUDE.md §5.6), seul cas autorisé |
| `À confirmer avant publication` | 0 | — |
| `publiées prochainement` | 0 | — |
| `26,00 € HT` / `27,00 € HT` (tarif unique fictif) affiché à l'utilisateur | 0 (toutes les occurrences trouvées sont des commentaires de code documentant leur suppression passée, ou `26,00 €` légitimement utilisé comme le vrai tarif « autres locaux » de la grille à trois montants) | ✅ Grille réelle (24,30 € / 26,00 € / 30,00 € HT/h) confirmée affichée sur `/tarifs/` et sur les 6 pages de prestation |
| `V1top-famille-pro` | 0, dans tout l'historique | — |
| `Top-Entreprise` (marque visible) | 0 (hors mentions légales, où `SARL TOP-ENTREPRISE` est la raison sociale réelle et doit y figurer) | ✅ |

Aucune donnée fictive résiduelle du prototype (faux avis, note 5,0/5, compteur « 47 avis ») —
vérifié par `tests/seo.spec.js` sur les 53 routes (assertion dédiée, verte).

## 5. Routes — 53 pages + 404

Les 53 routes de `docs/INVENTAIRE-ROUTES.md` répondent toutes `200` sur le rig de test (script de
contrôle par famille + suite `tests/seo.spec.js`, 803 assertions vertes, dont une par route sur le
statut HTTP). Le crawl (`tests/crawl.spec.js`) confirme l'absence de lien mort et de page
orpheline. `/prestations/bureaux/` et `/zones-intervention/cote-dor/dijon/`, explicitement citées
comme en 404 en production, répondent `200` avec le code de ce dépôt.

**Redirections legacy** (`docs/REDIRECTIONS.md`) : 19 paires source/destination confirmées depuis
`topentreprise.fr`, plan prêt mais non appliqué (décision commerciale non prise). La route
`/nettoyage-de-bureaux/` mentionnée dans la demande comme route legacy à comparer **n'a pas de
correspondance confirmée** dans `PROJECT_INPUTS.md` §9 — conformément à CLAUDE.md §6 (« aucune
redirection sans source et destination identifiées »), **aucune redirection n'a été ajoutée pour
elle**. Si elle doit être redirigée, sa destination réelle doit d'abord être confirmée.

Les 8 communes secondaires non validées restent `noindex,follow`, exclues du sitemap
(`tests/seo.spec.js`, assertion dédiée par commune) et absentes de `areaServed` (JSON-LD) —
inchangé par ce hotfix, déjà conforme.

## 6. Résultats des tests

- `npm run test` (lint PHP 71 fichiers + build CSS/JS/images) : ✅ vert, avant et après les
  corrections du §3.
- Suite Playwright complète (`tests/*.spec.js` hors captures) : **803/803 assertions vertes**,
  avant et après — aucune régression introduite par les corrections.
- Suite de captures (`tests/screenshots.spec.js`, étendue pour ce hotfix — voir §7) :
  **88/88 tests verts**.
- `tests/legal.spec.js` (mentions légales, phase 7) : inchangé, vert.

## 7. Comparaison visuelle — captures

Captures existantes (phases 5/6) + nouvelles captures ajoutées pour ce hotfix, toutes dans
`docs/captures/` :

| Capture requise | Fichier(s) | État |
|---|---|---|
| Accueil 375/1440 px | `accueil-375x812.png`, `accueil-1440x900.png` | ✅ Existant |
| Hero 375/1440 px | `hero-375x812.png`, `hero-1440x900.png` | ✅ **Ajouté** |
| Menu mobile ouvert | `menu-mobile-ouvert-375x812.png` | ✅ **Ajouté** |
| Prestations (index) | `prestations-375x812.png`, `prestations-1440x900.png` | ✅ **Ajouté** |
| Page bureaux | `prestation-bureaux-375x812.png`, `prestation-bureaux-1440x900.png` | ✅ **Ajouté** — montre l'image de hero désormais présente |
| Tarifs | `tarifs-375x812.png`, `tarifs-1440x900.png` | ✅ Existant |
| Page Dijon | `zone-dijon-375x812.png`, `zone-dijon-1440x900.png` | ✅ **Ajouté** |
| Formulaire étape 1/2 | `formulaire-etape-1-*.png`, `formulaire-etape-2-*.png` | ✅ Existant |
| Mentions légales | `mentions-legales-375x812.png`, `mentions-legales-1440x900.png` | ✅ **Ajouté** |
| Footer | `footer-375x812.png`, `footer-1440x900.png` | ✅ Existant |
| 404 | `404-375x812.png`, `404-1440x900.png` | ✅ **Ajouté** |

**Écarts restants constatés par rapport à la référence Claude Design**, à consigner honnêtement
plutôt qu'à masquer :

- Les photos utilisées restent des **visuels de stock provisoires** (`docs/DONNEES-FICTIVES.md`,
  inchangé depuis la phase 1) : ce ne sont ni les 31 images du prototype dans leur usage exact
  page par page (structure et rôle reproduits, pas nécessairement la même photo au pixel près sur
  chaque emplacement), ni des photos authentiques de l'entreprise. Portrait authentique d'Audrey
  toujours non fourni (`Photo à venir` conservé à cet unique endroit).
  Comparer ce hotfix à ce qui aurait été produit avec les deux fichiers réellement joints (§2)
  reste à faire si leur contenu diffère de la référence déjà versionnée.
- Aucune mesure Lighthouse « après activation de LiteSpeed » n'a pu être produite : LiteSpeed
  Cache n'existe que sur l'hébergement Hostinger réel, indisponible depuis cet environnement
  (limitation déjà documentée en phase 6, inchangée).

## 8. Verdicts

```
ROOT_CAUSE_IDENTIFIED=YES
CLAUDE_DESIGN_FIDELITY=PARTIEL (accueil 98 % de la maquette, 13/13 blocs ordonnés ; formulaire et
                                mentions légales complets ; prestations à 82 % ; tarifs, zones,
                                index conseils et institutionnelles entre 53 % et 69 % — §3d)
IMAGES_INTEGRATED=PASS        (pipeline responsive AVIF/WebP/JPEG complet, favicon et pages de
                                prestation corrigés dans ce hotfix ; images encore provisoires)
53_ROUTES=PASS                (803 assertions, 0 route en 404, crawl propre)
FORM=PASS                     (formulaire 2 étapes complet sur le rig de test — non testé en
                                envoi réel sur production, interdit sans autorisation explicite)
SEO=PASS                      (title/meta/canonical/OG/Twitter/JSON-LD/robots corrects sur les
                                53 routes, favicon et image OG dédiée ajoutés)
DEPLOYMENT_PACKAGE=PASS       (3 ZIP correctifs construits et testés — voir §9/§10)
```

Aucun de ces verdicts n'est un `PASS` de complaisance : chacun s'appuie sur une vérification
automatisée rejouable (803 + 88 tests) ou sur une inspection de fichier documentée ci-dessus, pas
sur une déclaration. Le point le plus proche d'un `PARTIAL_PASS` est `CLAUDE_DESIGN_FIDELITY` /
`IMAGES_INTEGRATED` : les photos restent provisoires (stock), une contrainte déjà posée en phase 1
et non levée par ce hotfix faute de photos authentiques fournies — pas un défaut de ce correctif.

## 9. Nouveau paquet de déploiement

| Fichier | Rôle | Taille | SHA-256 |
|---|---|---|---|
| `release/topfamillepro-theme-correctif.zip` | Thème enfant, `Version: 0.5.0`, dossier racine `topfamillepro/` (jamais `V1top-famille-pro`) | 2,3 Mo (2 302 251 o) | `30846991ed1dcdae10501b8da1f6eef933a3e306d69e2d9f1f399c0b06b81de5` |
| `release/topfamillepro-content-installer-correctif.zip` | Plugin d'installation, `Version: 1.4.0` | 60 Ko (61 222 o) | `47aff06b3df6275ae386e9fbc44b23ccda27a8edb911e91e15155b29a755f0b8` |
| `release/Top-Famille-Pro-Correctif-Production.zip` | ZIP global (les deux ci-dessus + ce document + le guide + les checksums) | 2,4 Mo (2 386 722 o) | `6995c107228c5ce4e15a248841797192dd7b3459ffa518f2c82a6ae86cbd4a37` |

Empreintes également dans `release/SHA256SUMS-correctif.txt`.

## 10. Installateur correctif — comportement vérifié

Le plugin d'installation (`installer/topfamillepro-content-installer/`, désormais versionné dans
ce dépôt — il n'existait jusqu'ici que comme ZIP construit, jamais commité) gagne une fonction
`tfp_installer_scan_legacy_content()` : liste, en lecture seule, tout contenu `page`/`post` publié
qui n'appartient à aucune des 53 routes attendues (typiquement les pages d'un ancien thème resté
actif). Affiché à l'administrateur dans une nouvelle section « 0. Contenu existant à examiner » —
**jamais supprimé automatiquement**, conformément à CLAUDE.md §6.

**Testé** sur le rig de test (ZIP réellement installés, pas le thème lié en symlink) :
- 2 pages étrangères créées manuellement (simulant un reliquat de thème précédent) : détectées par
  le scan, **non modifiées ni supprimées** après exécution complète de l'installateur.
- Ré-exécution sur une base déjà peuplée (52/52 contenus déjà présents, phase 7) : **11/11 étapes
  sans erreur, delta +0** sur les 4 types de contenu (`page`, `prestation`, `zone`, `post`) —
  idempotence confirmée sur les ZIP réellement construits, pas seulement sur le code source.
- Favicon, image OG, image de prestation générique : servies en `200` depuis le thème
  fraîchement extrait du ZIP correctif (pas depuis l'environnement de développement).
- **Rejoué après la deuxième vague de corrections (§3b)**, sur les ZIP v0.3.0/v1.2.0 : nouvelle
  installation fraîche, 11/11 étapes sans erreur. Vérifié depuis le thème/plugin réellement
  extraits du ZIP (pas le rig de développement) : tarif « 27 € HT » affiché sur `/tarifs/`, page
  Dijon reliée à ses 6 prestations, mentions légales avec l'hébergeur et sans `[À COMPLÉTER]`,
  date d'article au format français, favicon présent.

Menus et page d'accueil : **rien à recréer/définir**, comme en phase 7 — les menus du site sont
des tableaux PHP en dur dans le thème (pas des menus WordPress), et `front-page.php` s'applique
automatiquement à `/` quel que soit le réglage Lecture. La demande §12 (« recréer les menus »,
« définir la bonne page d'accueil ») ne correspond donc à aucune action réelle sur ce thème —
signalé plutôt que simulé.

## 11. Procédure de redéploiement sécurisée (staging d'abord, pas exécutée dans cette session)

Aucune modification n'a été faite sur la production dans cette session (CLAUDE.md §6, et demande
explicite). Procédure à exécuter manuellement par un humain :

1. **Sauvegarde complète** du site actuel (fichiers + base de données) depuis hPanel Hostinger
   (Sauvegardes) ou un export manuel — avant toute autre étape.
2. **Créer un environnement de préproduction** Hostinger (sous-domaine ou copie du site dans
   hPanel → Sites → Créer un environnement de préproduction, ou un sous-domaine dédié type
   `staging.top-famille-pro.fr` avec une copie de la base).
3. Sur ce **staging seulement** : Apparence → Thèmes → Ajouter un thème → Téléverser →
   `topfamillepro-theme-correctif.zip` → Installer. **Ne pas activer immédiatement.**
4. Installer GeneratePress (thème parent) et l'extension ACF (gratuite) si absents.
5. Extensions → Ajouter → Téléverser → `topfamillepro-content-installer-correctif.zip` → Installer
   → Activer.
6. Outils → Installation Top-Famille Pro : consulter la section « 0. Contenu existant à examiner »
   — noter les pages étrangères éventuelles (probablement issues de `V1top-famille-pro`), sans
   rien supprimer à ce stade.
7. Consulter le tableau de contrôle préalable (§1 de la page) : c'est la simulation, en lecture
   seule — rien n'est encore écrit.
8. Cocher la case de confirmation de sauvegarde, cliquer « Installer ou mettre à jour le contenu »
   — import réel sur le **staging**.
9. Apparence → Thèmes → activer **Top-Famille Pro** (le thème correctif).
10. Réglages → Permaliens → Enregistrer les modifications (sans rien changer), pour activer les
    routes des prestations et zones.
11. Contrôler les 53 pages (menu Pages, Prestations, Zones, Articles) : aucune manquante, aucune
    vide.
12. Tester le formulaire de devis en conditions réelles **sur le staging uniquement** — un envoi
    réel ne doit pas être déclenché sur la production sans autorisation explicite, conformément à
    la demande.
13. Contrôle visuel desktop et mobile, comparaison avec `docs/captures/`.
14. Purge complète du cache LiteSpeed (extension LiteSpeed Cache → Toolbox → Purge tout).
15. Nouvelle mesure Lighthouse mobile sur le staging, après cette purge.
16. **Déploiement en production uniquement après validation humaine** de tout ce qui précède —
    répéter les étapes 3 à 10 sur le domaine principal `top-famille-pro.fr`.
17. Conserver `V1top-famille-pro` désactivé (pas supprimé) le temps de la validation finale en
    production ; ne le supprimer qu'une fois `topfamillepro` confirmé stable.

Chemins exacts (gestionnaire de fichiers Hostinger, si l'upload par l'interface WordPress
échoue) : voir `release/GUIDE-DEPLOIEMENT-HOSTINGER.md`, section « Partie B — alternative par le
gestionnaire de fichiers », inchangée pour ce correctif (mêmes chemins
`public_html/wp-content/themes/` et `public_html/wp-content/plugins/`).

## 12. Procédure de retour arrière

Si un problème apparaît après activation de `topfamillepro` (staging ou production) :

1. Apparence → Thèmes → réactiver `V1top-famille-pro` (conservé, pas supprimé — étape 17 ci-dessus).
2. Le contenu créé par l'installateur (les 53 pages) reste en base, inoffensif tant que
   `V1top-famille-pro` est actif — aucune suppression nécessaire pour revenir en arrière.
3. Si la sauvegarde de l'étape 1 (§11) doit être restaurée intégralement (fichiers + base) :
   hPanel Hostinger → Sauvegardes → Restaurer, à la date précédant la manipulation.
4. Désactiver et supprimer le plugin `topfamillepro-content-installer` dans tous les cas, une fois
   la décision (garder ou revenir en arrière) prise — il ne doit jamais rester actif durablement.

## 3d. Quatrième vague — pages internes, famille par famille (9 août 2026)

Le fichier de référence n'est pas seulement un bundle auto-décompressant : c'est aussi une
**application à routes `#/`**. Toutes ses pages internes ont donc pu être ouvertes et mesurées,
et non plus seulement l'accueil. L'outil `tools/compare-fidelite.mjs` navigue les deux versions
dans le même navigateur, neutralise les animations, force le chargement des images en lazy-loading
puis mesure les blocs de premier niveau.

### Matrice par famille (1440 px, après corrections)

| Famille | Route maquette | Route WordPress | Maquette | WordPress | Couverture |
|---|---|---|---|---|---|
| Accueil | `#/` | `/` | 13 blocs / 7825 px | 13 blocs / 7658 px | **98 %** |
| Prestation | `#/service/bureaux` | `/prestations/bureaux/` | 14 / 7745 | 16 / 6374 | 82 % |
| Tarifs | `#/nos-tarifs` | `/tarifs/` | 13 / 5852 | 7 / 3594 | 61 % |
| Département | `#/departement/cote-dor` | `/zones-intervention/cote-dor/` | 11 / 6456 | 13 / 4347 | 67 % |
| Ville | `#/ville/dijon` | `/zones-intervention/cote-dor/dijon/` | 13 / 8508 | 13 / 4518 | 53 % |
| Commune | `#/ville/beaune` | `/zones-intervention/cote-dor/beaune/` | 13 / 7106 | 12 / 3745 | 53 % |
| Index conseils | `#/conseils` | `/conseils/` | 7 / 2834 | 3 / 1688 | 60 % |
| Institutionnelle | `#/pourquoi-top-famille-pro` | `/pourquoi-nous/` | 8 / 4047 | 5 / 2776 | 69 % |
| Formulaire | `#/demande-de-devis` | `/demande-de-devis/` | 4 / 1947 | 3 / 2042 | **105 %** |
| Mentions légales | `#/mentions-legales` | `/mentions-legales/` | 4 / 2014 | 6 / 2326 | **116 %** |
| 404 | *(sans équivalent)* | `/cette-page-n-existe-pas/` | — | 2 / 1190 | — |

La « couverture » compare la hauteur totale rendue : c'est une mesure de **densité de contenu**,
pas de qualité. Une page à 53 % n'est pas cassée — elle contient réellement moins de contenu que
la maquette.

### Ce qui a été corrigé dans cette vague

**Accueil** — les quatre écarts encore visibles :
- bandeau supérieur turquoise (`#DDF4F3`, 30 px) rétabli dans le header : tarif, promesse de délai,
  note Google et téléphone ;
- CTA du header repassé en **cuivre** (`#D9A062`, texte bleu nuit) — couleur mesurée sur le rendu
  réel de la maquette, pas supposée ;
- bande turquoise de rappel rétablie entre le grand CTA bleu et le pied de page ;
- hero passé de « écart » à « proche » (744 px contre 762 px).

**Prestations** — le gabarit partagé par les six pages a reçu les composants manquants de la
maquette : badge régional, mention du tarif unique dans le hero, encadré « Réponse directe » à
barre verticale, section « Trois configurations, trois organisations », section « Une semaine
type », exemple tarifaire chiffré, et rappel de contact avant le CTA final. Ces sections sont
pilotées par de nouveaux champs ACF (`config_1..3_titre/texte`, `semaine_type`) : **le contenu est
distinct pour chacune des six prestations**, pas dupliqué dans le PHP. Résultat mesuré : de
12 blocs / 4816 px à 16 blocs / 6374 px.

### Deux régressions introduites puis corrigées dans la même vague

1. La bande de rappel, placée entre `</main>` et `<footer>`, n'appartenait à aucun repère ARIA —
   axe-core signalait « Some page content is not contained by landmarks » sur les 7 pages
   auditées. Corrigée en la plaçant à l'intérieur du `<footer>`.
2. Devenue enfant du pied de page, elle héritait de ses couleurs de lien claires : le bouton
   secondaire s'affichait en `#C6DCE4` sur blanc, soit un contraste de 1,42. Corrigé par une règle
   explicite.

Les deux ont été trouvées en rejouant la suite complète, avant livraison.

### Lighthouse — six pages, une par famille

| Page | Performance | Accessibilité | Bonnes pratiques | SEO | CLS |
|---|---|---|---|---|---|
| Accueil | 86 | 100 | 100 | 100 | 0,002 |
| Prestation | 89 | 100 | 100 | 100 | 0,002 |
| Ville | 95 | 100 | 100 | 100 | 0,010 |
| Tarifs | 95 | 100 | 100 | 100 | 0,004 |
| Article | 96 | 100 | 100 | 100 | 0,010 |
| Formulaire | 96 | 100 | 100 | 100 | 0,018 |

Accessibilité, bonnes pratiques et SEO à **100 partout**, CLS très en dessous de la limite de 0,1.
La performance de l'accueil et de la page prestation passe légèrement sous 90 — ce sont les deux
pages les plus lourdes en images, mesurées sur le serveur de développement PHP intégré, **sans
compression ni cache**. La même page d'accueil avait été mesurée à 90 lors de la vague précédente :
l'écart relève de la variabilité de mesure sur ce serveur, pas d'une régression identifiée. À
remesurer sur l'hébergement réel après activation de LiteSpeed.

### Ce qui reste à faire, sans détour

Les familles tarifs, ville, commune, département, index conseils et institutionnelle contiennent
encore **moitié à deux tiers du contenu de la maquette**. Les sections identifiées comme absentes,
par ordre d'importance :

- **Page prestation** : le bloc « Le détail, espace par espace et contrainte par contrainte »
  (1162 px dans la maquette, le plus gros de la page) n'a pas été construit.
- **Pages ville et commune** : tissu économique local détaillé, types de locaux du secteur,
  secteurs et communes proches, méthode d'intervention locale — la maquette y consacre plusieurs
  sections que le gabarit actuel résume.
- **Page tarifs** : la maquette compte 13 blocs contre 7 ici.
- **Index conseils et pages institutionnelles** : sections éditoriales supplémentaires.

Ce travail est du **contenu rédactionnel distinct par page**, pas de la mise en page : le
reproduire correctement suppose d'écrire des textes spécifiques à chaque ville et à chaque
prestation, ce qui n'a pas été fait dans cette passe et ne doit pas être généré en dupliquant un
gabarit dont seul le nom de commune changerait.

---

## 3e. Cinquième vague — reproduction intégrale de la maquette (10 août 2026)

### Constat qui a déclenché la vague

Les quatre vagues précédentes concluaient qu'il manquait « du contenu rédactionnel distinct par
page » qu'il aurait fallu écrire, et refusaient de l'inventer. C'était une erreur d'analyse : ce
contenu **existe dans la maquette**, dans ses routes `#/`. Il n'était pas à rédiger, il était à
relever.

### Méthode

Le prototype est un bundle auto-décompressant doublé d'une application à routes. Il est **exécuté**
dans Chromium, jamais lu depuis sa source minifiée. Quatre outils rejouables, versionnés :

| Outil | Sortie |
|---|---|
| `tools/extract-routes.mjs` | `tools/reference-routes.json`, `docs/MATRICE-ROUTES-CLAUDE-WORDPRESS.md` |
| `tools/compare-routes.mjs` | `docs/COMPARAISON-53-ROUTES.md`, `docs/captures/comparaison/` |
| `tools/diff-text.mjs` | écarts à la phrase près, écarts voulus comptés à part |
| `tools/image-map.mjs` | `docs/IMAGES-MAQUETTE-WORDPRESS.md` |

Quatre générateurs produisent les scripts de seed depuis ces relevés :
`generate-prestations.mjs`, `generate-zones.mjs`, `generate-articles.mjs`, `generate-pages.mjs`
→ `bin/seed-fidelite-{prestations,zones,articles,pages}.php`, tous miroités dans l'installateur.

### Trois pièges du prototype, et leur correction

| Piège | Symptôme | Correction |
|---|---|---|
| Conteneur de flux repéré par « le plus d'enfants » | Sur une page courte, la coquille de l'application en a autant : on mesurait la barre haute et le pied de page au lieu du contenu | Ancrage sur l'ancêtre du `<h1>` |
| Page courte mettant `<h1>` et contenu dans une seule section | Toute la section était écartée avec le hero | On n'écarte que les nœuds précédant le premier `<h2>` |
| Intitulé d'accordéon en nœud texte, avec le « + » pour seul enfant | Toutes les questions de FAQ perdues | Le parcours relève aussi les nœuds texte directs |

Chacun est corrigé **dans le générateur**, donc reste corrigé au prochain passage.

### Résultat mesuré

- 53 routes découvertes, 53 comparées, **0 phrase de la maquette absente**.
- 6 écarts voulus, tous nommés (CLAUDE.md §9, §5.7, consigne du 9 août sur l'assurance).
- 825 tests Playwright au vert, axe-core 0 violation, Lighthouse a11y/BP/SEO 100, CLS ≤ 0,005.

### Ce qui reste à décider (pas à coder)

1. Validation par Audrey de la **citation qui lui est attribuée** — seul contenu du site faisant
   parler une personne réelle.
2. Remplacement des **témoignages provisoires** par de vrais avis (marqués `data-tfp-provisional`).
3. **Médiation de la consommation** : dispositif applicable, encore en `[À COMPLÉTER]`.
4. **Nombre d'avis Google** et **URL de la fiche** : le badge s'affiche sans eux, la note seule.

### Paquet correctif reconstruit (10 août 2026)

| Fichier | Version | Taille | SHA-256 |
|---|---|---|---|
| `release/topfamillepro-theme-correctif.zip` | 0.6.0 | 2 349 577 o | `5ebf0cada9df284d1100f52487bd4929af7aafffb5ccd7ded764103d8106976d` |
| `release/topfamillepro-content-installer-correctif.zip` | 1.5.0 | 170 347 o | `739e4193f2e7f816ad4cbc519994cdcb5a3ce7ecaec8b3a4cb6366f177b0a011` |
| `release/Top-Famille-Pro-Correctif-Production.zip` | — | 2 538 736 o | `a976c95ca844d67a559041fc0aca80a2dc2b1152fc281cfeaaf1659fc9714969` |

Contrôles faits sur les archives elles-mêmes, pas sur le dépôt :

- dossier racine du thème : `topfamillepro/` — **aucune occurrence de `V1top-famille-pro`** ;
- l'installateur embarque les quatre scripts de contenu relevé
  (`seed-fidelite-prestations.php`, `-zones.php`, `-articles.php`, `-pages.php`) et les expose
  comme quatre étapes distinctes de son écran d'administration ;
- le thème du ZIP a été installé tel quel sur la seconde instance WordPress, laissée en
  `WP_ENVIRONMENT_TYPE=production` : les témoignages provisoires y sont bien rendus et marqués
  `data-tfp-provisional`, et ni le compteur « 47 avis » ni l'ancienne marque « Top-Entreprise »
  n'apparaissent.
