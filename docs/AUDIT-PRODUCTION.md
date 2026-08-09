# AUDIT-PRODUCTION.md — Écart entre `top-famille-pro.fr` et le dépôt (hotfix)

> Diagnostic obligatoire mené avant toute modification, conformément à la demande du 9 août 2026
> (« corriger un problème critique de déploiement et de fidélité »). Branche :
> `hotfix-production-fidelite-claude-design`, créée depuis `main` à `40caf66` (fusion de la PR #8,
> phases 0 à 7 complètes). Résultat : **la cause n'est pas une régression du thème, c'est
> l'absence totale de déploiement** — voir §1. Deux lacunes réelles de code, indépendantes de ce
> problème, ont été trouvées et corrigées en cours d'audit — voir §3.

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
CLAUDE_DESIGN_FIDELITY=PASS   (structure, typographie, palette, grille tarifaire conformes ;
                                photos toujours provisoires — voir §7)
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
| `release/topfamillepro-theme-correctif.zip` | Thème enfant, `Version: 0.2.0`, dossier racine `topfamillepro/` (jamais `V1top-famille-pro`) | 2,0 Mo (2 088 267 o) | `9ccb95664fabb32dc271d2909e9e627736541c85901af45d8752e4d8573ad19b` |
| `release/topfamillepro-content-installer-correctif.zip` | Plugin d'installation, `Version: 1.1.0` — ajoute le scan de contenu existant (§10) | 56 Ko (57 627 o) | `6fe537d60285da477efe0d3bcf7887c7457442daf338986f157cedcd49a316aa` |
| `release/Top-Famille-Pro-Correctif-Production.zip` | ZIP global (les deux ci-dessus + ce document + le guide + les checksums) | 2,1 Mo (2 161 637 o) | `33d934d5038952181450b8eb106143fb0ad747b5f3c2fb6d006371cd9390a4eb` |

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
