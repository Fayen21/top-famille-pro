# STATUS — Top-Famille Pro

> Lien entre deux sessions Claude Code Web. Mis à jour à la fin de chaque phase.
> Dernière mise à jour : **G26 — passe ouverte après le refus de validation**, 17 août 2026 (§-8).
>
> **Troisième vague (`docs/AUDIT-PRODUCTION.md` §3c, `docs/RAPPORT-FINAL.md` §21)** : la maquette
> Claude Design a été **exécutée et mesurée** dans Chromium (c'est un bundle auto-décompressant),
> puis comparée bloc par bloc au rendu WordPress. Deux sections manquantes rétablies (« Pensé pour
> les professionnels », « Pourquoi Top-Famille Pro » + carte témoignage) : **13/13 blocs présents et
> ordonnés**, 7 identiques (±8 px), 5 proches (±40 px), 1 écart assumé. Trois bugs réels trouvés en
> mesurant : ratios d'images ignorés (`height: auto` manquant, +350 px de hauteur), titres de section
> à 25,5 px au lieu de 42 px (token `--fs-h2` jamais branché), débordement horizontal de 57 px à
> 1024 px. Lighthouse : **mobile 90 / desktop 99, accessibilité 100, bonnes pratiques 100, SEO 100**
> — après avoir corrigé un CLS de 1,002 causé par le chargement asynchrone des feuilles de style.
> Note Google 5,0/5 confirmée réelle par Emmanuel mais **NON AFFICHÉE** (consigne du 18 août 2026,
> confirmée le 19) : pas de note sans URL de fiche officielle fournie et validée humainement. Témoignages : démonstration hors
> production, état neutre en production, prouvé sur deux instances WordPress réelles.
> Verdict : `PARTIEL — ÉCARTS RESTANTS` (pages internes moins travaillées que l'accueil, photos
> définitives toujours absentes).
> `ROOT_CAUSE_IDENTIFIED=YES` — le site publié (`top-famille-pro.fr`, thème actif signalé
> `V1top-famille-pro`) **ne fait tourner aucun code de ce dépôt** ; il n'y a jamais eu de
> déploiement (cohérent avec CLAUDE.md §6 et chaque rapport de phase précédent). Ce n'est pas une
> régression du thème à corriger, c'est un déploiement à faire. Détail complet, diagnostic
> vérifiable et procédure : `docs/AUDIT-PRODUCTION.md`. Tarif passé à un montant unique
> (27,00 € HT/h, décision commerciale) dans le même après-midi — `PROJECT_INPUTS.md` §5. Verdict
> honnête : `PARTIEL — ÉCARTS RESTANTS` sur la fidélité visuelle pixel-près demandée (reproduction
> complète des 17 sections de l'accueil, Lighthouse, 6 largeurs testées) — voir
> `docs/RAPPORT-FINAL.md` §20 pour le détail de ce qui est fait et de ce qui reste.

---

## -8. G26 — passe ouverte après le REFUS de validation du 17 août 2026

Branche `claude/g23-fidelite-claude-design-7doxg4`, depuis `7e6dc04` (checkpoint de clôture G25).
Rapport complet : **`docs/RAPPORT-G26.md`**. Fiche de décision : **`docs/VALIDATION-HUMAINE-G26.md`**.

**Ce qui a été refusé, et ce qui a été fait.**

1. **Le panneau de différence des triptyques était inutile.** Le générateur composait `difference`
   puis `negate()` : sur deux rendus proches, tout ressortait blanc. `tools/lib/diff-visuel.mjs`
   calcule l'écart de luminance, l'amplifie d'un facteur écrit dans l'image, le rend en magenta et
   **mesure** la proportion de pixels qui s'écartent. `tests/diff-visuel.spec.js` l'éprouve sur une
   fixture volontairement différente, et **passe l'ancien générateur aux mêmes assertions : il
   échoue**.

2. **Images.** L'audit compare désormais les images **par rôle et sur leurs octets**
   (`tools/audit-images-role.mjs`), et la table des sources est établie sur les octets de la
   maquette (`tools/mapper-photos-maquette.mjs`). Huit défauts trouvés au-delà des trois nommés,
   dont des héros de prestation et de ville **croisés**. Résultat : **164 images, 0 écart**.

3. **`/a-propos/`** : image à gauche sur ordinateur et avant le texte sur mobile, citation dans sa
   bande, attribution sur une ligne, mention de provisoire erronée retirée des quatre valeurs,
   commandes en rangées de boutons, bouton téléphone rétabli (le relevé jetait les liens `tel:`).

4. **`/recrutement/`** : parcours de candidature au lieu des appels commerciaux, vers le site
   carrière (CLAUDE.md §8), panneau des étapes en marine, étapes en liste numérotée.

5. **Formulaires** : anti-double-soumission **ajouté** (il n'existait que sur le contact),
   présentation rapprochée, protocole de capture explicite, et **différences fonctionnelles
   documentées une par une** dans `docs/FORMULAIRE-DIFFERENCES.md` — le dossier n'affirme plus
   « mêmes champs ».

6. **Note Google** : garde de vérifiabilité **réversible** dans `includes/reassurance-settings.php`
   — la note n'est exposée que si l'URL de la fiche l'accompagne. Compteur d'avis bloqué.
   `tests/g26.spec.js` éprouve les 53 routes. **0 occurrence** de note, d'étoiles hors provisoire,
   de `Review` ou d'`AggregateRating`.

7. **Pied de page et logos** repris au relevé ; **badge région** retiré des sept heros où la maquette
   n'en pose pas ; **pré-pied** recomposé ; logos portés de la densité 2 à la densité 3.

**État technique.** 1063 tests verts · relevé de base 318 contrôles, 298 dans 95-105 %,
**0 débordement**, 0 erreur console · Lighthouse **14 mesures, 0 sous la cible**, accessibilité 100
partout · CLS maximum 0,0048 · WCAG 2.2 AA 2.5.8 sans violation · images 0 écart.

**Deux régressions introduites puis corrigées dans la passe**, signalées plutôt que tues : un
débordement horizontal de 263 px (carte-lien promue bouton) et l'accessibilité Lighthouse tombée à
96 (contraste du rappel téléphonique du pré-pied). **L'audit axe-core de la suite n'a pas vu le
second** : une suite verte ne vaut pas preuve de contraste.

**Deux points tranchés par Emmanuel le 17 août 2026** : l'entrée « Nettoyage professionnel » du menu
(sept entrées contre six, en-tête +22 px) et les commandes de hero de cinq pages institutionnelles
sont **conservées**. Inscrites au registre `docs/ECARTS-MAQUETTE-AUTORISES.md` §7 et §8, et
verrouillées par `tests/ecarts-structure.spec.js` — une passe ultérieure qui les « corrigerait » au
nom de la fidélité fera échouer la suite. Le badge région, lui, reste retiré des sept heros
concernés : la décision portait sur les commandes, pas sur le badge.

**Contradictions levées le 19 août 2026.** Elles étaient signalées et non corrigées parce que
`CLAUDE.md` ne se modifie pas sans validation d'Emmanuel ; la consigne G27 §2 a donné cette
validation. `CLAUDE.md` §5.4 et §5.5 sont désormais alignés sur les décisions finales, avec la
mention explicite des consignes **périmées** pour qu'aucune session ne les réintroduise.

**Bloqueurs de mise en ligne — TOUS LEVÉS le 17 août 2026.** Le **Kbis est acté** : identifiants
contre-vérifiés par arithmétique (Luhn du SIREN ✅, Luhn du SIRET ✅, clé de TVA concordante avec le
SIREN ✅), contrôles désormais rejoués à chaque passage de `tests/legal.spec.js`. La **note Google
n'est pas affichée** (consigne du 18 août 2026, confirmée le 19) : la case `note_sans_source` a été
supprimée du code, et la garde exige note + URL de fiche non vide + URL de forme « fiche Google ».
Le compteur d'avis reste masqué, aucun balisage `Review` ni `AggregateRating` n'est produit, aucun
`href="#"` n'est publié. La **photo d'Audrey** et sa
**citation** ne bloquent plus et restent marquées provisoires. Les **huit communes secondaires sont
validées** — Audrey y intervient — et passent en `index,follow` avec entrée au sitemap.

**Reste à décider, sans urgence** : le texte des huit pages de commune date de l'époque où la
desserte n'était pas confirmée (« la demande peut être étudiée » plutôt que « nous intervenons »).
Le passer à l'affirmatif est une réécriture éditoriale, pas une conséquence mécanique de la
validation ; elle n'a pas été faite d'office.

**Verdict : `PARTIEL — ÉCARTS RESTANTS`**, jusqu'à une nouvelle validation humaine explicite.

---

## -7. Hotfix — fidélité production (9 août 2026)

Branche `hotfix-production-fidelite-claude-design`, créée depuis `main` après fusion de la PR #8
(condition posée avant tout travail : phases 0 à 7 complètes dans `main`, vérifié).

**Diagnostic complet** (méthode, tableau, cause racine, recherche exhaustive de textes/tarifs
fictifs, résultats de tests, verdicts) : `docs/AUDIT-PRODUCTION.md`. Résumé :

1. `V1top-famille-pro` n'existe dans aucun commit, aucune branche de ce projet — le site publié
   fait tourner un thème étranger, jamais remplacé.
2. Les deux fichiers annoncés comme joints à la session (référence HTML standalone, ZIP de 31
   images) n'étaient pas accessibles dans l'environnement d'exécution — vérifié équivalent
   (SHA-256 identique, 31/31) à `reference/Top-Famille-Pro-HANDOFF-READY.html` et `assets/`, déjà
   dans le dépôt depuis une phase antérieure ; utilisés comme référence par défaut.
3. Deux lacunes réelles trouvées en auditant le rendu du thème réel : aucun favicon, aucune image
   sur les 6 pages de prestation individuelles — corrigées (`build/optimize-images.mjs`,
   `includes/seo.php`, `includes/images.php`, `single-prestation.php`).
4. Code source du plugin d'installation de contenu, jusqu'ici seulement construit dans un ZIP
   jamais commité, versionné sous `installer/` — avec un ajout : scan en lecture seule du contenu
   qui n'appartient à aucune des 53 routes attendues, affiché à l'administrateur, jamais supprimé
   automatiquement.
5. 803 assertions Playwright + 88 tests de captures : verts avant et après les corrections.
6. Nouveau paquet de livraison versionné : `topfamillepro-theme-correctif.zip` (`0.3.0`),
   `topfamillepro-content-installer-correctif.zip` (`1.2.0`), `Top-Famille-Pro-Correctif-Production.zip`
   — testés sur une copie WordPress vierge **et** sur une copie simulant du contenu étranger déjà
   publié (idempotence confirmée, contenu étranger jamais touché).
7. Procédure de redéploiement détaillée (staging d'abord, ancien thème conservé pour retour
   arrière) et procédure de retour arrière : `docs/AUDIT-PRODUCTION.md` §11-§12. **Aucune
   modification de la production dans cette session.**
8. **Deuxième vague (même après-midi, `docs/AUDIT-PRODUCTION.md` §3b)** : tarif unique 27 € HT/h
   (remplace la grille à trois montants), bug réel de maillage villes/prestations corrigé (26
   zones ne reliaient qu'une seule prestation sur six), mentions légales finalisées (hébergeur,
   directrice de publication), cascade de polices renforcée, date d'articles corrigée au format
   français, photo temporaire d'Audrey avec mention honnête. Un bug de régression (contraste
   couleur cassé par la même correction de cascade CSS) a été introduit puis détecté et corrigé
   avant livraison, en rejouant la suite complète (811 tests + 88 captures, verts).

```
ROOT_CAUSE_IDENTIFIED=YES
CLAUDE_DESIGN_FIDELITY=PASS
IMAGES_INTEGRATED=PASS
53_ROUTES=PASS
FORM=PASS
SEO=PASS
DEPLOYMENT_PACKAGE=PASS
```

---

## -6. Phase 7 — informations légales et livraison Hostinger

Branche `phase-7-livraison-hostinger`, créée sur `main` après fusion contrôlée des PR #5, #6, #7.

### 1. Fusion contrôlée des PR #5 → #6 → #7

Vérifiées propres, sans conflit ni commentaire bloquant, commits conformes aux phases annoncées.
Fusionnées avec `merge_method="merge"` (jamais squash/rebase) pour préserver les SHA de commit
d'origine — condition nécessaire pour qu'une PR empilée, une fois retargetée sur `main`, montre un
diff propre (uniquement ses propres commits) plutôt qu'une duplication de l'historique déjà
fusionné. Suite de tests complète relancée entre chaque fusion (703, puis 705 tests verts).
`main` vérifié après coup : aucun marqueur de conflit résiduel, `npm run test` vert, tous les
fichiers clés des phases 2 à 6 présents, aucun doublon.

### 2. Informations juridiques confirmées

Extrait Pappers fourni par le client (dénomination, SIREN, capital, date d'immatriculation, siège,
gérante), puis complément (SIRET, code APE, TVA) confirmé directement. Cohérence formelle
recontrôlée indépendamment avant intégration : clé Luhn du SIRET valide, clé de contrôle TVA
calculée à partir du SIREN = 32 (conforme à ce qui a été transmis). Détail complet des valeurs :
`PROJECT_INPUTS.md` §2.

**Le bloqueur juridique posé en phase 0 est levé** : l'incohérence sur le SIREN (l'ancien site
publiait 938 472 242, la valeur confirmée est 938 472 420) est résolue.

Intégré dans `includes/site-options.php` (source unique, nouveaux champs `legal_*`), les mentions
légales (RCS/SIREN/SIRET/capital/APE/TVA/date d'immatriculation réels, remplacent les
`[À COMPLÉTER]`), le pied de page (ligne concise : raison sociale, capital, SIRET, lien vers les
mentions légales complètes), et les données structurées `Organization` (`taxID`, `vatID`,
`foundingDate` — propriétés schema.org appropriées ; **pas** de code APE forcé dans le JSON-LD,
faute de propriété schema.org adaptée). Aucune information personnelle inutile publiée : le nom de
naissance de la gérante (confirmé par Pappers, différent du nom d'usage déjà utilisé partout sur le
site) et sa date de naissance ne sont jamais rendus publics.

Un bug trouvé et corrigé par le nouveau test dédié (`tests/legal.spec.js`, 7 assertions) : la page
mentions légales paraphrasait « RCS » en toutes lettres sans jamais utiliser le sigle demandé par
la formulation du client.

### 3. Paquet de livraison Hostinger

Quatre livrables dans `release/`, détaillés dans `docs/RAPPORT-FINAL.md` §17 :

- `topfamillepro-theme.zip` — thème enfant, fichiers de production uniquement. Testé sur WordPress
  vierge (miroir GitHub, aucun accès réseau à wordpress.org depuis cet environnement) : activation
  propre, dépendance GeneratePress respectée, fonctionnement avec et sans ACF, aucun chemin de
  développement en dur.
- `topfamillepro-content-installer.zip` — plugin temporaire (Outils → Installation Top-Famille
  Pro) qui reproduit les 11 scripts de seed existants depuis l'administration, sans terminal :
  contrôle préalable en lecture seule, installation avec avertissement de sauvegarde obligatoire,
  rapport détaillé. Chaque script est inclus dans sa propre fermeture PHP pour isoler ses variables
  des dix autres — nécessaire car ces scripts étaient conçus pour être lancés séparément
  (`wp eval-file`), pas concaténés dans une même requête HTTP. Testé exhaustivement : premier
  passage (11/11 étapes, 0 erreur), idempotence (deuxième passage, delta +0 partout), modification
  manuelle suivie d'une réexécution (le champ géré est resynchronisé — comportement documenté dans
  l'avertissement de l'interface — la donnée personnalisée non gérée et une page hors périmètre
  restent intactes), avec et sans ACF, sécurité (nonce invalide rejeté, accès non authentifié
  redirigé vers la connexion).
- `PAGES-A-CREER.md` / `pages-a-creer.csv` — tableau des 53 pages, généré par extraction réelle du
  contenu (title/H1/meta description/robots/titre WordPress en base), pas recopié à la main.
- `GUIDE-DEPLOIEMENT-HOSTINGER.md` — 24 étapes pour un utilisateur non développeur, procédure
  alternative par le gestionnaire de fichiers.
- `INFORMATIONS-MANQUANTES.md` — mis à jour (SIRET/APE/TVA retirés, désormais confirmés).
- `SHA256SUMS.txt` + `Top-Famille-Pro-Livraison-Hostinger.zip` — empreintes et ZIP global.

### 4. Tests finaux sur une installation neuve, à partir des deux ZIP

WordPress vierge distinct du rig de développement habituel, thème et plugin réellement
extraits/activés depuis les ZIP livrés (pas de symlink vers les sources). **722 assertions
vertes** : `tests/seo.spec.js` + `tests/uniqueness.spec.js` + `tests/crawl.spec.js` +
`tests/legal.spec.js` (700, sur les 53 routes + 404) puis `tests/functional/quote-form.spec.js` +
`tests/accessibility.spec.js` (22, formulaire jusqu'à l'appel serveur de `wp_mail()`, axe-core 0
violation sur les 6 familles + le formulaire, navigation clavier réelle). `tests/screenshots.spec.js`
non rejoué sur cette instance (mécanisme de capture, pas un test de correction — déjà validé en
phase 5/6) ; les 796 assertions du rapport de phase 6 incluaient ces captures, non comparables
1 pour 1 aux 722 ci-dessus qui portent sur un périmètre volontairement plus resserré (correction,
pas capture).

### 5. Verdict — HOSTINGER_PACKAGE=PASS, site non encore déployé

Distinction volontaire entre quatre états, pour ne rien sous-entendre :

| Aspect | État |
|---|---|
| Code et contenu (CLAUDE.md §10) | ✅ **Prêt** — plus aucun bloqueur actif, y compris l'immatriculation (levé cette phase) |
| Paquet d'installation Hostinger | ✅ **Prêt** (`HOSTINGER_PACKAGE=PASS`) — testé de bout en bout sur WordPress vierge |
| Déploiement réel sur `top-famille-pro.fr` | ⛔ **Non effectué** — cette session n'a rien déployé sur le domaine réel (CLAUDE.md §6) |
| Envoi effectif des devis (SMTP) | 🟡 **À tester sur l'hébergement réel** — aucun transport mail disponible dans les environnements de test utilisés sur l'ensemble du projet |
| Informations commerciales encore facultatives | 🟡 Assurance RC pro, fiche Google (URL/note/avis), portrait réel d'Audrey, texte exact des témoignages, choix d'adresse e-mail, validation des 8 communes secondaires, décision sur `topentreprise.fr` — `release/INFORMATIONS-MANQUANTES.md` |

Aucun nouveau contrôle périodique programmé. Cette session s'arrête après le rapport final.

---

## -5. Phase 6 — accessibilité, performance, recette finale

Branche `phase-6-recette-finale`, créée sur `phase-5-tests-automatises` (PR #6 pas encore
fusionnée). Quatre chantiers, chacun commité séparément. **Rapport complet : `docs/RAPPORT-FINAL.md`**
— cette section résume, le rapport détaille et chiffre.

### 1. Accessibilité

Audit axe-core final (WCAG 2A/2AA/2.2AA + best-practice) sur les 6 familles + le formulaire de
devis : 0 violation. Complété par des interactions clavier réelles (drawer, sous-menus, barre CTA
mobile, ordre de tabulation) — pas seulement un scan automatisé.

Deux bugs réels trouvés et corrigés :
- Piège de focus cassé dans les deux sens dès qu'un sous-menu accordéon du drawer mobile est
  replié (`querySelectorAll(FOCUSABLE)` matchait des liens `display:none`, `.focus()` y échoue
  silencieusement) — corrigé par un filtre `offsetParent !== null` (`src/js/nav.js`).
- `/demande-de-devis/` (hors succès) sautait du `<h1>` au premier `<h3>` du pied de page, sans
  `<h2>` intermédiaire — trouvé par Lighthouse (pas ma propre suite, échantillon par famille
  n'incluait pas cette page), corrigé par un `<h2>` visually-hidden.

### 2. Performance

Lighthouse mobile réel (rig local, sans LiteSpeed/HTTP2/compression — confirmé, aucun
`Content-Encoding`) : accueil 91/100/100/100 (LCP 3,0s), prestation/zone/devis 97/100/100/100
(LCP 2,2-2,3s). Cibles CLAUDE.md §8 atteintes sur 3 pages sur 4 ; l'accueil reste 0,5s au-dessus du
LCP cible.

Deux corrections réelles :
- CSS chargé en preload + bascule stylesheet (évite le blocage du rendu, `includes/enqueue.php`) —
  résout l'audit render-blocking de Lighthouse.
- Logo du header : attributs `width`/`height` HTML (180×36) ne correspondaient pas au fichier réel
  (ratio ~1,89:1, affiché à hauteur fixe 36px partout donc ~68px de large réellement, jamais 180) —
  corrigés, fichier généré réduit de 360px à 140px (11,9 Ko → 3,1 Ko).

Chiffres détaillés et limite honnête de l'environnement de mesure : `docs/RAPPORT-FINAL.md` §11.

### 3. Sitemap XML + robots.txt

Sitemap natif WordPress (`/wp-sitemap.xml`, découpé par famille nativement) plutôt qu'un plugin
SEO supplémentaire. `includes/sitemap-robots.php` : exclut les sitemaps `users`/`taxonomies` (hors
périmètre des 53 routes) via `wp_sitemaps_add_provider` (seul point d'extension réel — pas de
`remove_provider()` côté core, vérifié contre le code source), exclut les 8 communes non validées
via `wp_sitemaps_posts_query_args` (au niveau de la requête — `wp_sitemaps_posts_entry`, essayé en
premier, ne permet pas d'exclure une entrée de la liste finale, vérifié aussi contre le code
source). robots.txt : rien à ajouter, WordPress core gère déjà la ligne `Sitemap:` — une première
tentative d'ajout dupliquait la ligne, retirée après l'avoir constaté.

`bin/cleanup-wp-defaults.php` (nouveau) : en vérifiant le sitemap, trouvé que l'article
« Hello world! » et la page « Sample Page » que `wp core install` crée par défaut étaient publiés et
indexables — mis à la corbeille, idempotent, à relancer une fois après toute installation
WordPress neuve (y compris la vraie, sur Hostinger).

### 4. Redirections 301

`docs/REDIRECTIONS.md` : 19 redirections depuis les URL confirmées de `PROJECT_INPUTS.md` §9, deux
destinations corrigées pour correspondre aux slugs réels du site construit. Articles du blog de
l'ancien site explicitement exclus (non inventoriés). Décision de fond (`topentreprise.fr` redirigé
ou abandonné) toujours ouverte — plan prêt, pas appliqué.

### Vérifications

| Contrôle | Résultat |
|---|---|
| `npm run test` (lint PHP + build), 71 fichiers PHP | ✅ |
| Suite Playwright complète (seo, uniqueness, crawl, functional, accessibility) | ✅ 796 assertions, 0 échec |
| `tests/screenshots.spec.js` | ✅ 81 captures |
| Sitemap : 0 commune non validée, 0 contenu par défaut WordPress | ✅ vérifié par requête HTTP réelle |
| robots.txt : une seule ligne `Sitemap:` | ✅ |
| Lighthouse mobile, 4 pages représentatives | ✅ chiffres réels dans `docs/RAPPORT-FINAL.md` §11 |

### Verdict — PAS PRODUCTION READY

CLAUDE.md §10 est explicite : jamais de PRODUCTION READY si une donnée d'immatriculation n'est pas
confirmée par Kbis. C'est le cas — SIRET, capital, APE, TVA et une incohérence sur le SIREN restent
non levés (`PROJECT_INPUTS.md` §12, question 1, toujours ouverte depuis la phase 0). Détail complet
du verdict, des bloqueurs et de ce qu'il reste à fournir : `docs/RAPPORT-FINAL.md` §1, §14, §15.

### Base de cette branche

`phase-6-recette-finale` est branchée sur `phase-5-tests-automatises`, elle-même non encore
fusionnée dans `main` au moment de la phase 6 (PR #6). La PR de la phase 6 cible donc PR #6, pas
`main` ; à fusionner après elle, ou à rebaser sur `main` une fois celle-ci mergée.

---

## -4. Phase 5 — suite de tests automatisés Playwright

Branche `phase-5-tests-automatises`, créée sur `phase-4-maillage-conversion` (PR #5 pas encore
fusionnée au moment de la phase 5 — même raison qu'en phase 3 : les fonctionnalités testées
n'existent que sur cette lignée tant que la PR n'est pas mergée).

### Ce qui a été construit

`@playwright/test` en devDependency, `playwright.config.js` piloté par la variable d'environnement
`TFP_BASE_URL` (défaut : le rig de test local documenté §11) — aucun `webServer` : aucun serveur
WordPress « jetable » ne peut être piloté depuis ce dépôt (CLAUDE.md §3, seul le thème enfant est
versionné). `executablePath` pointe explicitement vers le Chromium préinstallé de l'environnement,
la version du package pouvant réclamer une révision de navigateur différente.

- `tests/data/routes.js` : manifeste unique des 53 routes publiques (reconstruit depuis
  `docs/INVENTAIRE-ROUTES.md`), avec la famille et le `robots` **cible** de chacune — base commune
  aux tests SEO et au crawl, pour ne jamais avoir deux listes à maintenir en parallèle.
- `tests/data/fictitious-names.js` : les ~25 noms d'avis de démonstration du prototype
  (`docs/DONNEES-FICTIVES.md`), distincts des 6 noms réels réutilisables (CLAUDE.md §5.5).
- `tests/seo.spec.js` : par route (53 + 404), statut HTTP, h1 unique, title présent et
  raisonnablement court, meta description, canonical absolue auto-référente, robots attendu,
  JSON-LD valide, aucun `href="#"`, aucun fragment `#/`, aucune donnée fictive résiduelle, aucun
  alt mensonger, aucune erreur JS, aucun débordement horizontal (375px).
- `tests/uniqueness.spec.js` : title et canonical uniques sur les 53 routes, par requête HTTP brute
  (plus rapide qu'un navigateur pour une vérification qui ne dépend d'aucun rendu client).
- `tests/crawl.spec.js` : crawl interne réel depuis l'accueil (suit tous les `<a href>` internes
  rencontrés), vérifie qu'aucun lien ne meurt et que les 53 routes sont toutes atteignables (aucune
  page orpheline) — indépendant du manifeste de routes pour la découverte, qui sert seulement à
  vérifier la couverture a posteriori.
- `tests/functional/quote-form.spec.js` : soumission complète (téléphone seul, e-mail seul), rejet
  serveur (ni l'un ni l'autre, e-mail mal formé), consentement bloquant côté client, honeypot,
  contexte local transmis et pré-rempli, navigation clavier (Tab/Entrée, Espace sur la case à
  cocher), erreurs annoncées à l'étape 1.
- `tests/screenshots.spec.js` : les 12 largeurs demandées × une page par famille dans
  `.screenshots/` (gitignoré, balayage complet — 81 captures), plus une sélection ciblée commitée
  dans `docs/captures/` (16 fichiers, 8,6 Mo) couvrant les contrôles particuliers du brief : villes à
  nom long (Fontaine-lès-Dijon, Chalon-sur-Saône) à 320/1440px, formulaire aux étapes 1/2/en erreur,
  clavier mobile ouvert (approximation par une hauteur de viewport réduite — aucune émulation native
  de clavier virtuel n'existe dans Chromium piloté par Playwright), footer, page tarifs, accueil.

### Bugs trouvés et corrigés par la suite (« corrige tout ce que les tests révèlent »)

- **Title de l'accueil à 71 caractères** (`front-page.php`), au-delà des ~65c de CLAUDE.md §8 —
  déjà signalé dans `docs/INVENTAIRE-ROUTES.md` comme dépassement du prototype, jamais corrigé
  pendant les phases 2/3 (celles-ci avaient corrigé les autres dépassements listés, mais pas
  l'accueil, créé plus tôt en phase 1, avant que la règle de raccourcissement soit systématisée).
  Raccourci en « Nettoyage de bureaux et locaux en Bourgogne-Franche-Comté » (57c), intention
  principale préservée (service + périmètre + région) ; le H1 n'est pas concerné, seule la balise
  `<title>` a une contrainte de longueur SERP.
- **Vérification anti-« Top-Entreprise » trop étroite dans le premier jet des tests** : une
  comparaison sensible à la casse contre `Top-Entreprise` (voir §-3, données fictives) ne détectait
  pas la variante `TOP-ENTREPRISE` telle qu'affichée dans le pied de page. Corrigé en une
  comparaison insensible à la casse — après avoir explicitement retiré la seule occurrence légitime,
  la raison sociale réelle « SARL TOP-ENTREPRISE » (CLAUDE.md §1), pour ne pas la confondre avec
  l'ancienne marque à supprimer (CLAUDE.md §9). Vérifié que la détection fonctionne réellement (test
  unitaire du motif hors suite, avant et après correction), pas seulement que la suite passe.
- **Capture « footer » en pleine page plutôt que recadrée** : la première version utilisait
  `fullPage: true` uniformément, produisant une image de 1 à 2 Mo qui faisait doublon avec la
  capture « accueil » (toute la page, pas seulement le pied de page). Corrigée en un `clip` sur la
  position réelle du `<footer>` après défilement — fichiers réduits à ~45 Ko.

### Constats honnêtes plutôt que des contrôles inventés

- **Aucun bandeau cookies** n'existe sur le site : conforme à CLAUDE.md §6 (« aucun outil de
  tracking installé »), un bandeau de consentement n'a de sens qu'une fois un outil de mesure
  effectivement branché. Le contrôle particulier « bandeau cookies » du brief phase 5 n'a donc rien
  à capturer pour l'instant — non simulé par une fausse bannière.
- **Aucun élément `<table>` HTML** n'existe sur le site : la grille tarifaire est affichée en
  cartes (meilleure lisibilité mobile, décision déjà prise en phase 1/2). La capture demandée pour
  « tableaux » utilise la page `/tarifs/`, la plus proche d'un contenu tabulaire, avec cette
  précision dans le commentaire du test plutôt qu'un silence qui laisserait croire à un vrai tableau.

### Vérifications

| Contrôle | Résultat |
|---|---|
| `npm run test` (lint PHP + build) | ✅ |
| `tests/seo.spec.js` + `tests/uniqueness.spec.js` + `tests/crawl.spec.js` + `tests/functional/quote-form.spec.js` (exécution combinée) | ✅ 703 passés, 0 échec (après correctifs) |
| `tests/screenshots.spec.js` (81 captures) | ✅ 81 passés, 0 échec |

### Relancer la suite

```bash
npm ci
TFP_BASE_URL=http://votre-wordpress.example npx playwright test        # tout, sauf les captures
npx playwright test tests/screenshots.spec.js                          # captures (lent, ~1 min)
```

Sans `TFP_BASE_URL`, la config retombe sur `http://localhost:8899` (rig de test local, §11).

### Base de cette branche

`phase-5-tests-automatises` est branchée sur `phase-4-maillage-conversion`, elle-même non encore
fusionnée dans `main` au moment de la phase 5 (PR #5). La PR de la phase 5 cible donc PR #5, pas
`main` ; à fusionner après elle, ou à rebaser sur `main` une fois celle-ci mergée.

---

## -3. Phase 4 — maillage interne, formulaire de devis enrichi, analytics

Branche `phase-4-maillage-conversion`, créée sur `main` une fois les PR des phases 2 et 3 fusionnées
(PR #3 puis PR #4, retargetée sur `main`). Trois chantiers, chacun commité séparément.

### 1. Maillage interne

Audit complet des liens garantis par le brief phase 4, gabarit par gabarit (pas page par page — un
lien absent d'un gabarit est absent des ~10 pages de la famille en une fois). Détail complet et
matrice avant/après : `docs/MAILLAGE.md`. Résumé des manques trouvés et corrigés :

- `villes_prioritaires` sur les 6 prestations : le champ existait et le gabarit le rendait déjà,
  mais aucun script de seed n'y avait jamais écrit de valeur depuis la phase 2 — la section
  « Disponible dans ces villes » était silencieusement absente sur les 6 pages prestation depuis le
  début. Renseigné avec les 10 villes réelles (`bin/seed-phase4-maillage.php`).
- `/tarifs/` → 6 prestations (absent), page région → 8 départements (absent), département → page
  région (lien contextuel ajouté en plus de la nav globale).
- Articles ↔ prestations : aucun mécanisme de relation n'existait. Nouveau champ postmeta
  multi-lignes `_tfp_related_prestation` (`includes/articles-meta.php`, ACF-free comme le reste du
  thème), rendu dans les deux sens (`single.php` → « Prestations liées », `single-prestation.php` →
  « Nos conseils sur ce sujet »).
- Aucune page orpheline trouvée ; 3 clics maximum depuis l'accueil, fil d'Ariane sur toutes les
  pages sauf l'accueil.

### 2. Formulaire de devis — conforme au brief phase 4

Champs étendus à la liste complète du brief : étape 1 = type de locaux, régime (régulier/ponctuel),
ville (désormais un champ **visible**, plus seulement cachée), code postal, surface approximative,
nom, téléphone, e-mail ; étape 2 = entreprise (renommé depuis « structure »), fréquence, créneau,
message, consentement RGPD (case à cocher, lien vers `/politique-de-confidentialite/`).

**Changement de règle de validation** (`includes/quote-form.php`) : l'e-mail n'est plus
obligatoire — nom + (téléphone **ou** e-mail) + message + consentement coché sont requis ; si un
e-mail est fourni, il doit être valide. L'ordre validation-avant-limitation-de-fréquence posé en
phase 3 est conservé. `wp_mail()` reçoit tous les nouveaux champs, avec libellés lisibles (pas les
clés brutes du formulaire).

Deux CTA « Demander mon devis » (page prestation, page zone) transmettent maintenant leur contexte
au formulaire, qui le pré-remplit (`src/js/quote-form.js`, déjà prêt à les lire depuis la phase 3) :
`single-prestation.php` → `?service=&service_label=`, `single-zone.php` → `?ville=&departement=`
(ville) ou `?departement=` seul (département). Détail et justification du nommage des paramètres :
`docs/MAILLAGE.md`.

### 3. Analytics — couche de données neutre, aucun outil installé

`src/js/analytics.js` (nouveau) empile les 8 événements du brief
(`quote_start`, `quote_step_1_complete`, `quote_submit`, `quote_success`, `quote_error`,
`phone_click`, `email_click`, `local_cta_click`) dans `window.dataLayer`, un tableau JavaScript brut.
Aucun script tiers chargé, aucun identifiant de mesure, conforme à CLAUDE.md §6 (« Aucun outil de
tracking installé tant que son identifiant et les règles de consentement ne sont pas fournis »).

### Bugs trouvés et corrigés pendant cette phase

- **Collision de query_var WordPress, sérieuse** : le premier essai de transmission de contexte
  utilisait `?prestation=<slug>` sur le lien vers `/demande-de-devis/`. `register_post_type()`
  enregistre par défaut un query_var identique au nom du CPT — donc `?prestation=bureaux` sur
  n'importe quelle URL du site (y compris `/demande-de-devis/`) détournait silencieusement la
  requête principale de WordPress vers l'article single « bureaux » à la place de la page
  réellement demandée, sans erreur ni redirection visible (juste un mauvais contenu rendu, HTTP
  200). Trouvé par un test Playwright de préremplissage qui a constaté un `<title>` inattendu.
  Corrigé en renommant le paramètre en `service`/`service_label` (`departement` et `ville` vérifiés
  sans collision : la taxonomie `departement` a `query_var => false`, `ville` n'est le nom d'aucun
  post type ni d'aucune taxonomie).
- **Débordement horizontal à 320px sur `/demande-de-devis/`** : `<fieldset>` a un
  `min-width: min-content` implicite dans les navigateurs, qui ignore la largeur du conteneur
  parent — dès qu'un des deux `<fieldset data-step>` du formulaire a un contenu dont la largeur
  intrinsèque dépasse le viewport, tout le formulaire déborde. Corrigé par une règle globale
  `fieldset { min-width: 0; }` (`src/css/02-base.css`) — correctif standard pour ce piège CSS connu.

### Vérifications

| Contrôle | Résultat |
|---|---|
| `npm run test` (lint PHP + build) | ✅ |
| Soumission valide (téléphone seul, sans e-mail) | ✅ passe la validation (échoue ensuite à l'envoi, faute de transport mail dans le bac à sable — attendu, voir §8) |
| Soumission valide (e-mail seul, sans téléphone) | ✅ idem |
| Ni téléphone ni e-mail | ✅ rejeté (`erreur=champs`) |
| E-mail fourni mais mal formé | ✅ rejeté (`erreur=champs`) |
| Consentement non coché | ✅ rejeté (`erreur=champs`) |
| Honeypot rempli | ✅ rejet silencieux |
| Nonce invalide/absent | ✅ rejeté (`erreur=session`) |
| Navigation clavier étape 1 → 2 (Tab, Espace sur la case à cocher) | ✅ |
| Message d'erreur annoncé pour le groupe radio « régime » (`<legend>`, pas de doublon par bouton) | ✅ |
| Préremplissage `?service=&service_label=&ville=&departement=` sur `/demande-de-devis/` | ✅ |
| `window.dataLayer` : `quote_start`, `quote_step_1_complete`, `quote_success`, `quote_error` | ✅ observés par Playwright |
| axe-core (WCAG 2A/2AA/2.2AA) + débordement horizontal, 320/375/1440px, `/demande-de-devis/` (avec et sans contexte), `/prestations/bureaux/`, page ville, page département | ✅ 0 violation après correctifs |
| Balayage de régression (17 pages statiques/hub, 320/1440px, statut HTTP + débordement + erreurs JS) | ✅ aucune régression |
| Recherche finale « Top-Entreprise » résiduelle | ✅ aucune |

### Ce qu'il reste à fournir pour que le formulaire envoie réellement les demandes

Inchangé depuis la phase 3, toujours d'actualité : le code envoie réellement via `wp_mail()` (pas de
simulation), mais ce bac à sable n'a aucun transport mail système — `wp_mail()` y retourne `false`
de façon reproductible, y compris en appel isolé hors formulaire. Pour un envoi réel une fois
déployé sur Hostinger, il faut :

1. **L'adresse de réception réelle** des demandes (`PROJECT_INPUTS.md` §1, question ouverte #4) —
   `tfp_site_data()['email']` l'utilise déjà, seule sa valeur définitive manque.
2. **Un test d'envoi réel** une fois le site déployé : Hostinger fournit un transport mail
   fonctionnel nativement pour un domaine hébergé chez eux (`mail()` PHP standard), donc aucune
   configuration SMTP dédiée ne devrait être nécessaire en usage normal — mais cela doit être vérifié
   en conditions réelles, pas supposé.
3. Si les e-mails partent en spam ou n'arrivent pas malgré (2), configurer SPF/DKIM pour
   `top-famille-pro.fr` côté DNS Hostinger, ou basculer sur un plugin SMTP (ex. WP Mail SMTP) avec
   les identifiants d'un service comme celui déjà utilisé pour `top-famille.fr` le cas échéant —
   aucun choix technique à faire dans le thème, `wp_mail()` reste l'API utilisée quel que soit le
   transport sous-jacent.

### Base de cette branche

`phase-4-maillage-conversion` est branchée sur `main`, après fusion des PR #3 (phase 2) et #4
(phase 3).

---

## -2. Phase 3 — migration des 53 pages restantes

Les gabarits de la phase 2 couvraient chacun une seule page de référence par famille. La phase 3
crée le contenu réel de toutes les pages restantes, en 7 lots commités séparément sur
`phase-3-migration-pages` (branchée sur `phase-2-gabarits`, non encore fusionnée dans `main` au
moment de la phase 3 — voir « Base de cette branche » plus bas).

**53/53 pages migrées**, comptage vérifié dans un WordPress réel : 18 pages statiques + 6
prestations + 26 zones (8 départements + 10 villes + 8 communes secondaires) + 3 articles —
correspond exactement à `docs/INVENTAIRE-ROUTES.md` (« 53 pages publiques + 1 page 404 »).

### Sources du contenu

Le contenu éditorial repris du prototype provient de l'extraction structurée faite en phase 0
(`extracted-data.js` et fichiers dérivés, scratchpad de session — non versionnés dans le dépôt) :
`SERVICES`, `GEO2` (fusion `CITIES`/`DEPTS`/`SECONDARY` + contenu enrichi), `ARTICLES`, `HUB_PAGE`,
`REGION_PAGE`. Pour les 8 pages statiques sans contenu structuré dans cette extraction
(pourquoi-nous, notre-fonctionnement, avis-clients, à-propos, demande-de-devis, contact,
recrutement, conseils), le contenu est construit directement à partir des données réelles de
`PROJECT_INPUTS.md` plutôt que du prototype — évite de devoir neutraliser une nouvelle couche de
données fictives (avis démo, bio inventée) qu'aurait contenue le contenu JSX correspondant.

### Corrections systématiques appliquées à chaque lot (CLAUDE.md §5.1/§5.3/§5.4/§9)

- **Tarif fictif « 27 € HT/h »** retiré de toutes les réponses directes, sections tarifaires et FAQ
  reprises du prototype — remplacé par la grille réelle à trois montants déjà affichée par les
  sections tarifs des gabarits, ou par une référence à la page `/tarifs/`.
- **Aucune commune satellite non validée présentée comme desservie.** Au-delà de la simple omission
  du champ `zones_desservies` (déjà traité en phase 2 pour Côte-d'Or/Dijon), le lot 3 a trouvé une
  régression plus grave : la FAQ de chaque ville du prototype répond « Oui » à « Intervenez-vous à
  [commune non validée] ? » — une affirmation positive de couverture, pas une simple mention.
  Corrigé sur les 9 villes par une réponse honnête au cas par cas, sans nommer ni confirmer de
  commune précise.
- **Aucune distance ni temps de trajet chiffré non sourcé** repris (le prototype affirmait par
  endroits des temps de trajet approximatifs sans source).
- **Aucun exemple de budget chiffré sur une page zone**, comme décidé en phase 2 pour Côte-d'Or/
  Dijon : évite un contenu quasi dupliqué entre les 17 zones départements/villes migrées ici.
- **Titres raccourcis à ≤65 caractères** partout où `docs/INVENTAIRE-ROUTES.md` signalait un
  dépassement (Territoire de Belfort, Lons-le-Saunier, Chalon-sur-Saône, page région
  Bourgogne-Franche-Comté, article cahier des charges — ce dernier via un nouveau mécanisme de
  surcharge `_tfp_seo_title` sur les articles, `includes/articles-meta.php`, absent jusque-là).
- **Aucun avis de démonstration** repris (`demo: true` dans le prototype, sur toutes les familles).

### Lot 4 — les 8 communes secondaires, créées mais non indexables

CLAUDE.md §5.4 est explicite : ces 8 communes (Saint-Apollinaire, Chenôve, Quetigny, Talant,
Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune) n'existent sur aucune source confirmée par
Audrey (`PROJECT_INPUTS.md` §12, question ouverte #8, toujours ouverte). Elles sont créées avec
`statut_validation` non coché → `single-zone.php` calcule automatiquement `noindex,follow`
(mécanisme posé et testé en phase 2). Contenu très largement réécrit, pas simplement neutralisé :
le prototype y affirmait positivement une couverture confirmée ; remplacé par une formulation
honnête (« la demande peut être étudiée »). Elles sont liées depuis la page Dijon (validée) via
`communes_proches` — noindex n'empêche pas le suivi d'un lien, seulement l'indexation de la page
cible.

**Ces 8 pages restaient `noindex,follow` tant qu'Audrey ne les avait pas validées une par une.**
C'était une décision humaine, pas un chantier technique.

> **PÉRIMÉ depuis le 17 août 2026.** La validation a été donnée : Audrey intervient dans les huit
> communes. Elles sont passées en **`index,follow`**, figurent au sitemap, et leur texte affirme la
> desserte. Voir `CLAUDE.md` §5.4 et `docs/DECISIONS.json`. Ce paragraphe est conservé comme trace
> de l'état d'alors ; il ne décrit plus le site.

### Lot 5/6 — formulaire de demande de devis, réellement fonctionnel

Contrairement à un simple gabarit de contenu, `/demande-de-devis/` est une fonctionnalité neuve :
formulaire à deux étapes (un seul `<form>`, deux `<fieldset>`, données conservées dans le DOM),
validation client (`src/js/quote-form.js`) et serveur (`includes/quote-form.php`), honeypot,
limitation à 5 soumissions/heure par IP, contexte visiteur capturé (référent, UTM, prestation/ville
prérequêtées), envoi réel par `wp_mail()` vers l'adresse de contact réelle. Confirmation affichée
uniquement après succès serveur réel (`?merci=1`, état `noindex,follow`), jamais simulée côté
client. Tous les scénarios (soumission complète, honeypot, champs manquants, limitation de
fréquence, navigation clavier) ont été testés par `curl` et Playwright — voir le détail dans le
commit du lot 6.

### Bugs trouvés et corrigés pendant la migration

- **Doublon canonical/robots** (hooks `wp_head` par défaut de WordPress core) — trouvé en tout
  début de phase 3, avant le premier lot ; voir le commit dédié.
- **Entités HTML échappées dans le JSON-LD** (`wptexturize` via `get_the_title()`) — même commit.
- **Réponse FAQ « ponctuel » factuellement fausse** (lot 1) : le prototype affirmait un tarif
  identique entre régulier et ponctuel ; en réalité le ponctuel (30,00 € HT/h) est plus cher que le
  régulier « autres locaux » (26,00 € HT/h) — ce n'était pas seulement un problème de tarif fictif,
  la logique de la réponse elle-même était fausse.
- **Cible tactile insuffisante sur le fil d'Ariane** et **débordement horizontal sur un CTA à
  libellé dynamique**, tous deux à 320px (lots 1–3, mêmes classes de bug que la phase 2, sur de
  nouvelles pages).
- **Collision de routage** (lot 5) : la règle de réécriture du CPT `zone`
  (`^zones-intervention/([^/]+)/?$`) capturait aussi `/zones-intervention/bourgogne-franche-comte/`
  — un commentaire du code documentait déjà que cette URL est une Page classique, mais la regex
  n'excluait pas ce slug réservé, donnant un 404 réel une fois la page créée. Corrigé par une
  exclusion explicite (`includes/cpt-zone.php`) ; les zones départements/villes existantes retestées
  et toujours fonctionnelles.
- **Violation `link-in-text-block`** (lot 7, WCAG 1.4.1) : liens de prose des pages légales
  distingués uniquement par la couleur — corrigé avec la classe utilitaire `.tfp-underline`
  existante.
- **Ordre validation/limitation de fréquence** (lot 6) : la limitation de fréquence du formulaire de
  devis consommait un quota avant la validation des champs, permettant à une requête mal formée
  d'épuiser le quota d'un visiteur légitime partageant la même IP — réordonné.

### Vérifications (répétées à chaque lot, résumé global)

| Contrôle | Résultat |
|---|---|
| Comptage final des posts (18+6+26+3) | ✅ conforme à `docs/INVENTAIRE-ROUTES.md` |
| `npm run test` (lint PHP + build) après chaque lot | ✅ |
| JSON-LD valide, types corrects par famille, sur toutes les pages testées | ✅ |
| axe-core (WCAG 2A/2AA/2.2AA) + débordement horizontal, 6 largeurs × 53 pages (échantillonnage exhaustif par lot) | ✅ 0 violation après corrections |
| Recherche finale « Top-Entreprise » résiduelle | ✅ aucune (hors `legal_name` attendu) |
| Recherche finale tarif fictif « 27 € » résiduel | ✅ aucune occurrence hors commentaires explicatifs |
| Recherche finale avis fictifs résiduels | ✅ aucune |
| Recherche finale `href="#"` public | ✅ aucune |
| Recherche finale fonctions ACF Pro résiduelles | ✅ aucune (hors commentaire historique déjà présent en phase 1) |
| Communes non validées absentes du plan du site | ✅ |
| Aucune donnée d'immatriculation publiée en clair (mentions légales) | ✅ |
| Formulaire de devis : soumission complète, honeypot, champs manquants, limitation de fréquence, clavier | ✅ testés par curl + Playwright |

### Pages incomplètes ou en attente (à signaler explicitement, comme demandé)

- **Avis clients réels** : les 6 témoignages authentiques existants (`PROJECT_INPUTS.md` §7 :
  Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie) ne sont **pas** publiés — leur
  texte exact n'a jamais été fourni dans ce dépôt, seuls leurs noms sont confirmés. La page
  `/avis-clients/` affiche un état honnête (« en cours d'intégration ») plutôt qu'un contenu
  inventé pour des personnes réelles. Dès que le texte est transmis, il se saisit dans Réglages →
  Réassurance & avis (aucune modification de template nécessaire, mécanisme déjà en place depuis la
  phase 1).
- **Mentions légales** : SIRET, SIREN/RCS, capital, TVA, APE, assurance RC pro, directrice de
  publication et coordonnées complètes de l'hébergeur restent en `[À COMPLÉTER]` — bloqueur de mise
  en ligne déjà identifié en phase 0/1, toujours d'actualité (incohérence non levée entre deux
  sources sur l'identifiant de la société, CLAUDE.md §5.7).
- **Politique de confidentialité** : durée de conservation des données et contact référent RGPD en
  `[À COMPLÉTER]` (`PROJECT_INPUTS.md` §11, déjà listés comme manquants en phase 0).
- **Formulaire de devis** : le code envoie réellement par `wp_mail()`, mais aucun test d'envoi bout
  en bout n'a pu être fait dans ce bac à sable (aucun transport mail système disponible —
  `wp_mail()` retourne `false` de façon reproductible et indépendante du code du formulaire, vérifié
  par un appel isolé). **À tester en conditions réelles dès le déploiement sur Hostinger.**
- **Liens contextuels vers le devis** : les CTA existants (prestations, zones, accueil) pointent
  vers `/demande-de-devis/` sans paramètres `?prestation=&ville=`. Le formulaire sait déjà lire ces
  paramètres pour préremplir le champ prestation (`src/js/quote-form.js`) ; relier les CTA des 43
  pages concernées reste à faire — amélioration mineure, pas un défaut fonctionnel.
- **8 communes secondaires** : restaient `noindex,follow` en attente de validation.
  **PÉRIMÉ — validées le 17 août 2026, désormais `index,follow` et au sitemap.**

### Base de cette branche

`phase-3-migration-pages` est branchée sur `phase-2-gabarits` (PR #3), elle-même non encore
fusionnée dans `main` au moment de la phase 3 — les gabarits de la phase 2 n'existent que sur cette
lignée. La PR de la phase 3 cible donc `phase-2-gabarits`, pas `main` ; elle devra être fusionnée
après la PR #3, ou rebasée sur `main` une fois celle-ci fusionnée.

---

## -1. Phase 2 — un gabarit + une page réelle par famille

PR #2 (phase 1) fusionnée, travail sur la nouvelle branche `phase-2-gabarits`. Brief : un gabarit
PHP par famille de contenu (page statique, prestation, département, ville/commune, article) et une
page de référence réelle par famille, contenu repris du prototype et corrigé selon CLAUDE.md §9,
structure locale obligatoire (réponse directe, exclusions réelles, matériel fourni par le client,
FAQ, CTA, maillage), JSON-LD complet par famille.

### Ce qui a été construit

- **`single-prestation.php`** — gabarit unique pour les 6 prestations (une seule entrée réelle
  créée : **Bureaux**, `/prestations/bureaux/`). Pour qui, tâches couvertes, problèmes fréquents,
  organisation (cahier des charges/produits/accès/sélection/suivi d'absence consolidés en un seul
  champ), exclusions réelles, rappel matériel fourni par le client, tarif réel à trois montants,
  villes prioritaires liées, FAQ, JSON-LD `Service` + `FAQPage` conditionnel.
- **`single-zone.php`** — gabarit unique pour les 3 niveaux (`departement`/`ville`/`commune`),
  branché sur le champ ACF `niveau`. Deux entrées réelles créées : **Côte-d'Or** (département,
  `/zones-intervention/cote-dor/`) et **Dijon** (ville, `/zones-intervention/cote-dor/dijon/`).
  Réponse directe, tissu économique et types de locaux du secteur (jamais un tarif différencié),
  fonctionnement, tarif réel identique à toutes les zones, interlocutrice, villes du département ou
  communes proches selon le niveau, FAQ locale, lien vers la page pilier et le département parent.
- **`single.php`** — gabarit des articles (catégorie « Conseils », type `post` natif). Une entrée
  réelle créée : **Fréquence de nettoyage des bureaux** (`/conseils/frequence-bureaux/`). Réponse
  directe en tête, contenu structuré, FAQ, JSON-LD `Article` + `FAQPage` conditionnel.
- **`page-nettoyage-professionnel.php`** — gabarit dédié de la page pilier (WP Page classique,
  gabarit par slug, même logique que `front-page.php`). ~15 sections fidèles au prototype :
  définition, professionnels accompagnés, prestataire vs recrutement direct, 6 prestations,
  régulier/ponctuel, fréquences, tâches par espace, cahier des charges, avis réel conditionnel (pas
  de faux avis), tarifs à trois montants, FAQ 10 questions, CTA final.
- **Champs ACF ajoutés** (tous compatibles ACF gratuit, cf. audit phase 1) : `locaux_types`,
  `fonctionnement`, `zones_desservies`, `cta_label` sur `zone` ; `problemes`, `organisation` sur
  `prestation`.
- **`tfp_get_field()`** (`includes/acf-helpers.php`) : wrapper de secours utilisé partout à la place
  de `get_field()` — retombe sur `get_post_meta()` si ACF est absent. Corrige une régression trouvée
  pendant la vérification (`single-prestation.php`/`single-zone.php` appelaient `get_field()` sans
  garde, ce qui aurait provoqué une erreur fatale sans ACF — contraire à la garantie validée en
  phase 1).
- **Routage dédié des articles** (`includes/articles-routing.php`) : `/conseils/{slug}/` forcé par
  règle de réécriture + filtre `post_link`, indépendant du réglage global « Permaliens » — un
  changement de ce réglage en admin ne peut plus casser silencieusement les URL d'article. Bug
  trouvé et corrigé pendant la vérification (voir « Écarts corrigés » ci-dessous).
- **Routage imbriqué des zones** (`includes/cpt-zone.php`, posé en phase 1, activé en phase 2) :
  `/zones-intervention/{departement}/` et `/zones-intervention/{departement}/{ville}/` via règles
  de réécriture dédiées + redirection 301 canonique si le segment département ne correspond pas.
- **Structure méta native des articles** (`includes/articles-meta.php`) : boîte de méta WordPress
  standard (réponse directe + 8 blocs FAQ facultatifs), aucune dépendance ACF — un article reste
  éditable même si ACF est désactivé.
- **Script de seed idempotent** (`bin/seed-phase2-content.php`, `wp eval-file bin/seed-phase2-content.php`)
  : crée/met à jour les 5 pages de référence avec du contenu réel. Choisi plutôt qu'un dump de base
  de données parce que CLAUDE.md §3 ne versionne que le thème — le contenu de référence doit rester
  relisible en PHP, pas opaque dans une base.

### Écarts corrigés pendant la vérification

- **Canonical et robots dupliqués.** WordPress core hooke par défaut `rel_canonical` et `wp_robots`
  sur `wp_head`, en plus du rendu propre à `includes/seo.php` — chaque page servait donc deux
  `<link rel="canonical">` et deux `<meta name="robots">`. Corrigé par `remove_action('wp_head',
  'rel_canonical')` et `remove_action('wp_head', 'wp_robots', 1)` dans `includes/security.php`
  (même endroit que les retraits déjà faits en phase 1 pour `wp_generator`/`rsd_link`) — la priorité
  `1` de `wp_robots` a nécessité un `remove_action` explicite avec cette priorité, le défaut `10` ne
  suffisant pas.
- **Entités HTML échappées dans le JSON-LD.** `get_the_title()` passe par `wptexturize`, qui
  convertit par exemple l'apostrophe droite de « Côte-d'Or » en entité HTML `&#8217;` — correct en
  contexte HTML, mais faux tel quel dans un bloc JSON-LD (ce n'est pas du HTML, les moteurs
  n'auraient pas décodé l'entité). Trouvé dans le nom de `BreadcrumbList`. Corrigé par un décodage
  récursif (`tfp_jsonld_decode_entities()`) appliqué à tout le graphe avant `wp_json_encode()` dans
  `includes/seo.php` — corrige la classe de bug pour tout titre futur contenant une apostrophe, pas
  seulement le cas trouvé.
- **URL d'article redirigées au lieu d'être servies directement.**
  `/conseils/frequence-bureaux/` renvoyait un 301 vers `/frequence-bureaux/` parce que l'URL réelle
  de l'article dépendait du réglage global « Permaliens » (configuré ad hoc pendant les tests de la
  phase 1), pas d'une règle propre au thème. Corrigé par `includes/articles-routing.php` (voir
  ci-dessus).
- **Débordement horizontal à 320 px sur la page département.** Le CTA « Demander un devis en
  Côte-d'Or » (libellé généré dynamiquement par gabarit) dépassait de 9 px à 320 px : `.tfp-btn` a
  `white-space: nowrap` globalement (adapté aux libellés courts fixes, mais pas à un libellé
  dynamique long). Corrigé par une règle `@media (max-width: 479px)` qui autorise le retour à la
  ligne (`04-components.css`) plutôt que de raccourcir un libellé réel.
- **Cible tactile insuffisante sur le fil d'Ariane à 320 px** (violation axe `target-size`, WCAG
  2.5.8) : les liens du fil d'Ariane n'avaient ni `padding` ni espacement entre lignes en cas de
  retour à la ligne (`row-gap: 0`), trouvé sur la page ville (4 niveaux de fil d'Ariane, cas le plus
  serré). Corrigé : `padding: 8px 2px` + `min-height: 24px` sur les liens (`04-components.css`) et
  `row-gap: 4px` sur la liste (`includes/breadcrumbs.php`).
- **Zones non validées présentées comme desservies (CLAUDE.md §5.4 — trouvé après relecture du
  contenu de seed, avant tout commit).** Le contenu repris du prototype pour les pages Côte-d'Or et
  Dijon nommait Beaune et 7 autres « communes secondaires » du prototype (Chevigny-Saint-Sauveur,
  Ahuy, Daix, Plombières-lès-Dijon, Sennecey-lès-Dijon, Nuits-Saint-Georges, Ruffey-lès-Echirey)
  dans la réponse directe, le secteur économique, la FAQ, la meta description et le champ
  `zones_desservies` — alors qu'aucune de ces communes n'est validée par Audrey et que seule Dijon
  est une ville confirmée en Côte-d'Or (`PROJECT_INPUTS.md` §6). Même en texte simple non lié (pas
  de page dédiée), les nommer sur une page indexée affirme une couverture non confirmée. **Corrigé** :
  toutes les occurrences retirées de `bin/seed-phase2-content.php` (reformulées sans perte
  d'information réelle), le champ `zones_desservies` laissé vide sur les deux pages plutôt que
  rempli de noms non confirmés — la section correspondante se masque déjà automatiquement quand le
  champ est vide (`single-zone.php`).

### Vérifications

| Contrôle | Résultat |
|---|---|
| `npm run test` (lint PHP 43/43 + build CSS/JS/images) | ✅ |
| JSON-LD valide (`JSON.parse`) sur les 5 pages, types corrects par famille (`Service` sur la prestation, `Article` sur l'article, `FAQPage` uniquement si FAQ visible, `BreadcrumbList` partout, `Organization`/`ProfessionalService`/`WebSite`/`WebPage` toujours) | ✅ |
| Nombre de blocs FAQ dans le JSON-LD = nombre de `<details>` visibles, sur les 5 pages | ✅ (7/6/7/3/10) |
| Scénario commune non validée (`niveau=commune`, `statut_validation` décoché) | ✅ `robots: noindex,follow` émis, canonical et fil d'Ariane cohérents, aucune erreur PHP |
| 3 scénarios ACF (absent / installé-inactif / installé-actif) sur `single-prestation.php` et `single-zone.php` | ✅ 200 partout, aucune erreur fatale, exactement un `<h1>` |
| axe-core (WCAG 2A/2AA/2.2AA), 6 largeurs (320–1920 px) × 5 gabarits | ✅ 0 violation (2 trouvées et corrigées, voir écarts ci-dessus) |
| Débordement horizontal, 6 largeurs × 5 gabarits | ✅ 0 (1 trouvé et corrigé) |
| Erreurs console JS, 6 largeurs × 5 gabarits | ✅ 0 |
| Navigation clavier (Tab complet + activation `<details>` FAQ au clavier) sur 3 gabarits représentatifs | ✅ tous les éléments focusables atteints, aucun piège, FAQ activable au clavier |
| Recherche fonctions ACF Pro résiduelles | ✅ aucune (hors commentaires expliquant la correction phase 1) |
| Recherche tarif fictif « 27 € » résiduel | ✅ aucune (hors commentaires) |
| Recherche avis/notes fictifs résiduels | ✅ aucune |
| Recherche « Top-Entreprise » résiduelle | ✅ aucune (hors `legalName` réel et un placeholder d'admin de la phase 1) |
| Recherche distance/délai/quartier inventé | ✅ aucune |
| Recherche zones non validées présentées comme desservies | ✅ aucune après correction (voir écarts) |

### Points ouverts / limites de cette phase

- **`communes_proches` vide sur la page Dijon** : aucun post `zone` de niveau `commune` n'existe
  encore (les 8 communes secondaires du prototype restent non créées tant qu'Audrey ne les valide
  pas une par une — CLAUDE.md §5.4). Le champ relationnel est prêt (`acf-fields-zone.php`), mais
  n'a rien à référencer pour l'instant. Concerne la phase 3.
- **1 seule entrée réelle par famille**, conformément au brief (« un gabarit + une page de
  référence par famille ») — les 25 autres zones, 5 autres prestations, 17 pages statiques
  restantes et 2 autres articles restent à créer en phase 3, avec les mêmes gabarits.
- **Pas d'exemple de budget chiffré sur les pages zone** (contrairement au prototype qui affichait
  un exemple « 12h/mois » quasi identique sur chaque ville) : évite un contenu quasi dupliqué entre
  pages de zone et avec l'exemple déjà présent sur la page pilier/l'accueil. Écart signalé comme
  demandé (CLAUDE.md §4).
- Tous les points ouverts déjà listés en §8 (Kbis, assureur, fiche Google, portrait réel, e-mails,
  accès hébergeur, tarifs à reconfirmer, communes secondaires, SMTP devis, devenir de
  topentreprise.fr) restent d'actualité et inchangés par cette phase.

---

## 0. Validation finale de la phase 1 (avant fusion PR #2)

Audit ciblé demandé avant fusion, sur la branche `phase-1-fondations`. Un vrai problème de fond a
été trouvé et corrigé : **le thème dépendait d'ACF PRO alors que le README annonçait qu'ACF
gratuit suffisait.**

### Audit ACF gratuit/Pro

`acf_add_options_page()` (page d'options « Réassurance & avis ») et le champ **Repeater**
(FAQ des zones/prestations, tâches des prestations, avis de la page d'options) sont tous les deux
des fonctionnalités **exclusives à ACF PRO** — confirmé sur `advancedcustomfields.com/pro/` : les
cinq fonctionnalités réservées à Pro sont Repeater, Flexible Content, Gallery, Clone et les pages
d'options. Aucune des deux n'est disponible dans ACF gratuit. Corrigé :

- **Page d'options → API Settings native WordPress.** `includes/reassurance-settings.php`
  remplace entièrement `includes/acf-options-reassurance.php` (supprimé) : `register_setting()`,
  page d'admin native (`add_menu_page`), formulaire HTML classique, sanitization dédiée
  (`esc_url_raw`, `sanitize_text_field`, `sanitize_textarea_field`, notes bornées 0–5). **Aucune
  dépendance à ACF, ni gratuit ni Pro**, pour les avis/note/lien Google réels.
- **FAQ (zone, prestation) → champs Group (gratuit) au lieu de Repeater.** Nombre fixe de 8 blocs
  question/réponse (`includes/acf-helpers.php`, `tfp_acf_faq_group_fields()` /
  `tfp_get_faq_items()`), chaque bloc facultatif, seuls les blocs dont la question est renseignée
  sont retournés/affichés.
- **Tâches de prestation → textarea « une par ligne »** (`tfp_get_lines()`) au lieu de Repeater.

Vérifié dans un WordPress réel (ACF gratuit officiel, cloné depuis
`github.com/AdvancedCustomFields/acf`, version 6.8.7) dans les trois situations demandées :

| Situation | CPT `zone`/`prestation` enregistrés | Erreur fatale | Champs ACF disponibles |
|---|---|---|---|
| ACF absent (plugin non installé) | ✅ oui | ✅ aucune | Non (attendu) |
| ACF gratuit installé, inactif | ✅ oui | ✅ aucune | Non (attendu) |
| ACF gratuit installé et actif | ✅ oui | ✅ aucune | ✅ 5 groupes de champs enregistrés, testés en écriture/lecture (`update_field`/`get_field` réels sur un post de test) |

Recherche globale confirmant l'absence de toute fonctionnalité Pro résiduelle
(`acf_add_options_page`, `acf_add_options_sub_page`, `repeater`, `flexible_content`, `gallery`,
`clone`) : aucune occurrence hors commentaires expliquant la correction.

### Décisions de conception — vérifiées, une régression trouvée et corrigée

- **Fusion Prestations ↔ « Professionnels accompagnés »** : les 5 chips du prototype sont toutes
  présentes, aucun CTA n'a été perdu (le bloc d'origine n'en contenait aucun), un seul H2 au lieu
  de deux — hiérarchie correcte, lecture plus courte. **CRO** : évite un second bloc de titre+lede
  qui ne faisait que réintroduire le sujet « prestations » juste avant la vraie section
  Prestations, sans apporter d'information ni de CTA propre.
- **Fusion « Pourquoi » ↔ « Audrey et avis »** : les 4 items « Pourquoi » et les 2 CTA de la
  section Audrey (« Échanger sur mes locaux », « Lire les avis ») étaient bien présents, **mais
  le lien « Toutes nos preuves → » (vers `/pourquoi-nous/`) avait disparu pendant la fusion — un
  vrai maillage perdu.** Réintégré (`template-parts/home/audrey-reviews.php`). **CRO** : les deux
  blocs d'origine poursuivaient le même objectif de réassurance juste après la couverture
  régionale ; les séparer allongeait la page sans ajouter d'information, mais fusionner ne
  justifiait pas de perdre le lien vers la page de preuves complètes.
- **Portrait d'Audrey** : visuel neutre confirmé (aucune photo de stock présentée comme elle,
  aucun `alt` décrivant une personne inexistante — il n'y a d'ailleurs aucun `<img>` tant que le
  placeholder est actif). Ajout d'un réglage **Customizer natif** (Apparence → Personnaliser →
  Équipe, `includes/customizer.php`, sans dépendance ACF) : la vraie photo se dépose en un geste
  depuis l'administration dès qu'elle est fournie, sans toucher au thème. Reste vide par défaut.
- **Tarifs** : les trois montants réels sont confirmés — **24,30 € HT/heure** (locations
  meublées, régulier), **26,00 € HT/heure** (autres locaux, régulier), **30,00 € HT/heure**
  (ponctuel, ≤ 5 interventions) — tous trois sourcés `PROJECT_INPUTS.md` §5 « Tarifs réels »
  (tableau « Ménage régulier — locations / — autres locaux / Ménage ponctuel »). Frais de gestion
  9,00 € HT/mois et frais de mise en place 50,00 € HT, même source. Recherche globale : aucune
  occurrence résiduelle de « 27 € » dans le HTML, le CSS, le JS, les métadonnées ou le JSON-LD
  (uniquement dans un commentaire de code expliquant la correction).
- **CTA mobile** : la barre CTA fixe contient bien les deux actions (☎ Appeler → `tel:+33636176339`,
  Demander mon devis → `/demande-de-devis/`), visibles sans défiler, zones tactiles 138×55 px
  (> 44×44 px), toutes deux atteignables au clavier (Tab), pas de débordement à 320 px. **Un vrai
  défaut trouvé et corrigé** : le réservataire d'espace en bas de page (`.tfp-mobile-cta-spacer`)
  avait une hauteur figée en CSS légèrement inférieure à la hauteur réelle de la barre (76px vs
  76,6px), laissant un chevauchement de moins d'1px avec le footer. Corrigé par un calcul
  dynamique en JS (`syncMobileCtaBarSpacer()`, `src/js/nav.js`) qui cale la hauteur du
  réservataire sur la hauteur réelle de la barre, plus une valeur de repli CSS relevée par
  sécurité (84px) si JavaScript est indisponible.

### Preuves visuelles

13 captures demandées, générées contre le commit `46740cb` (dernier commit de la PR au moment de
la validation) et envoyées directement en pièces jointes de la conversation (accueil complet à
320/375/768/1440 px, header desktop, menu mobile ouvert, hero mobile/desktop, section tarifs,
section Audrey/avis neutralisée, footer + barre CTA mobile, 404 desktop/mobile). Non versionnées
dans le dépôt (dossier `qa/` volontairement absent) pour ne pas alourdir l'historique Git d'images
lourdes, conformément à la demande.

### Contrôles finaux (tous relancés après corrections)

`npm run test` (lint PHP 37/37 + build CSS/JS/images) ✅ · axe-core desktop (1440 px, accueil) 0
violation ✅ · axe-core mobile (375 px, accueil) 0 violation ✅ · axe-core 404 desktop/mobile 0
violation ✅ · 6 largeurs (320–1920 px) sans débordement horizontal ✅ · 0 erreur console sur les 6
largeurs + interactions clavier ✅ · menu clavier (sous-menus desktop, piège de focus mobile,
Échap) ✅ · 404 réelle (statut HTTP 404 confirmé) ✅ · recherche données fictives : aucune ✅ ·
recherche fonctions ACF Pro : aucune ✅.

### Blocages restants

Aucun nouveau. Ceux déjà listés en §8 (Kbis, assureur, fiche Google, portrait réel, e-mails,
accès hébergeur, tarifs à reconfirmer, communes secondaires, SMTP devis, devenir de
topentreprise.fr) restent d'actualité et inchangés par cette validation.

---

## 1. Où en est le projet

Phase 0, Phase 1, Phase 2 et Phase 3 terminées. Le dépôt contient un thème enfant WordPress
fonctionnel (`wp-content/themes/topfamillepro/`) avec les **53 pages publiques réelles** du site :
18 pages statiques, 6 prestations, 26 zones (8 départements + 10 villes + 8 communes secondaires
non indexées), 3 articles — plus la 404. Formulaire de demande de devis réellement fonctionnel
(validation, envoi par e-mail réel). Tout vérifié dans un WordPress réel (voir §-2, §-1 et §11).

**Prochaine étape : Phase 4** — adresse de réception des demandes de devis en conditions réelles et
configuration SMTP Hostinger (question ouverte #4), au minimum un test d'envoi bout en bout du
formulaire une fois déployé. Voir aussi §-2 « Pages incomplètes ou en attente » pour les points non
techniques (avis clients réels, validation des communes secondaires, Kbis).

---

## 2. Ce qui a été fait en phase 1

### Nettoyage contrôlé
- Suppression de `Top-Entreprise - Prototype Ready for Code.html` (vestige identifié en phase 0,
  commit dédié séparé du reste du travail).
- `reference/Top-Famille-Pro-HANDOFF-READY.html` non touché.

### Fondations WordPress
- Thème enfant `topfamillepro`, parent **GeneratePress**, arborescence conventionnelle
  (`functions.php` + `includes/` + `template-parts/` + `src/` + `assets/dist/`) — détail dans
  `wp-content/themes/topfamillepro/README.md`.
- CPT `zone` (taxonomie `departement` associée) et CPT `prestation` déclarés conformément à la
  décision d'architecture de la phase 0 — **déclarations seulement**, les 26 + 6 entrées réelles
  seront créées en phase 2.
- Champs ACF structurés pour les deux CPT, enregistrés en PHP (`acf_add_local_field_group`, pas
  via l'export JSON d'ACF) : la structure vit dans le dépôt Git, pas dans la base.
- Page d'options ACF « Réassurance & avis » : seule source des avis/note/lien Google réels,
  vide par défaut (voir §5).
- URL propres : toutes les routes du site utilisent des chemins réels (`/prestations/bureaux/`,
  `/zones-intervention/cote-dor/`…), aucun fragment `#/` nulle part dans le thème.
- Vraie 404 : `404.php` appelle `status_header(404)` — vérifié en conditions réelles (§11), la
  route renvoie bien un statut HTTP 404, pas seulement une page qui y ressemble.
- Sécurité scopée au thème (`includes/security.php`) : masquage de la version WordPress, retrait
  du pingback/RSD, blocage de l'énumération d'auteurs. Ce qui relève de `wp-config.php` ou de
  l'hébergement (`DISALLOW_FILE_EDIT`, limitation des tentatives de connexion) reste à faire côté
  hébergement — hors périmètre d'un dépôt qui ne versionne que le thème (CLAUDE.md §3).
- Aucune dépendance lourde : deux devDependencies (`esbuild` pour le bundling CSS/JS, `sharp`
  pour le pipeline d'images), toutes deux uniquement utilisées au build, jamais chargées par le
  site en production.

### Design system
- Tokens centralisés dans `src/css/00-tokens.css`, extraits et réduits à une échelle discrète à
  partir de `docs/DESIGN-TOKENS.md` (couleurs, typographie, espacements, rayons, ombres, largeurs
  de conteneur, breakpoints, cible tactile 44 px).
- Bricolage Grotesque + Hanken Grotesk auto-hébergées, `font-display: swap`, sous-ensembles latin
  + latin-ext uniquement (vietnamese/cyrillic-ext retirés), récupérées depuis l'API officielle
  Google Fonts par `npm run fonts` (script reproductible, `build/fetch-fonts.mjs`) — pas de fichier
  de police extrait à la main du bundle du prototype. Licence OFL, texte complet dans
  `assets/dist/fonts/OFL.txt`.
- CSS organisé en 6 fichiers sources (tokens → fonts → base → layout → composants → home),
  bundlés et minifiés par `esbuild` en un seul `assets/dist/css/main.css` (~31 Ko minifié).

### Composants globaux
Header desktop avec sous-menus accessibles (Prestations, Zones), menu mobile plein écran avec
piège de focus et fermeture au clavier (Échap), bouton téléphone, CTA devis, footer complet à
4 colonnes, barre CTA mobile fixe (avec réservation d'espace pour ne jamais masquer le footer),
bouton, carte, conteneur/section, fil d'Ariane (composant prêt, pas affiché sur l'accueil — voir
`includes/breadcrumbs.php`), bloc CTA contextualisable, bloc de réassurance, cartes de
prestations, cartes d'articles, image responsive (`tfp_picture()`).

Vérifiés au clavier et en interaction réelle (§11) : ouverture/fermeture des sous-menus desktop
(clic, clic extérieur, Échap), ouverture/fermeture du menu mobile (Échap, piège de focus confirmé
sur 3 tabulations), verrouillage du scroll du body pendant que le menu mobile est ouvert.

### Images
Aucune archive `Top-Famille-Pro-images-temporaires.zip` n'a été fournie dans cette session — les
photos de stock déjà présentes dans `assets/photos/` (relevées en phase 0) servent de
placeholders, avec les mêmes règles d'honnêteté (voir §5). Pipeline AVIF/WebP/JPEG avec fallback,
`srcset`/`sizes`, dimensions explicites, un seul `fetchpriority="high"` sans lazy-loading sur
l'image LCP (hero), lazy-loading sur tout le reste — vérifié dans le HTML rendu (§11). Toute image
est référencée par son *slug* (`tfp_picture('hero-main', […])`), jamais par un chemin de fichier en
dur dans un gabarit : remplacer une photo provisoire par la photo réelle ne touchera aucun template,
seulement `build/optimize-images.mjs` (mapping slug → fichier source).

**Portrait d'Audrey : décision volontaire.** Aucune photo de stock n'est utilisée à cet endroit —
un visuel neutre (pastille avec l'initiale « A ») remplace le portrait, avec la légende « Photo à
venir ». Une photo de stock à côté du nom d'Audrey aurait visuellement laissé croire qu'il s'agit
d'elle, quel que soit le texte de l'`alt` (invisible aux yeux d'un visiteur non malvoyant) — cela
semblait aller au-delà de ce que permet le brief phase 1 §5/§7 (« ne jamais présenter une photo de
stock comme Audrey »). Ce choix modifie la composition visuelle par rapport au prototype à cet
endroit précis : à signaler comme demandé (CLAUDE.md §4). À remplacer par le vrai portrait dès
réception (question ouverte PROJECT_INPUTS.md #7).

### Page d'accueil
Les 10 sections du brief, dans l'ordre demandé. « Professionnels accompagnés » fusionné en tête de
la section Prestations (chips), et le bloc « Pourquoi Top-Famille Pro » du prototype fusionné dans
la section « Audrey et avis » plutôt que de rester une section à part : les deux blocs
poursuivaient le même objectif (réassurance/différenciation) juste après la couverture régionale,
les séparer aurait allongé la page sans ajouter d'information — écart signalé comme demandé.

**SEO/GEO** : `<title>` unique, meta description unique, canonical absolue auto-référente, H1
unique (vérifié : un seul sur la page), hiérarchie de titres cohérente (8 H2, un par section
visible), Open Graph, Twitter Card, JSON-LD `Organization`/`ProfessionalService` + `WebSite` +
`WebPage` — vérifiés dans le HTML servi par un WordPress réel (§11), aucune dépendance JS pour ces
balises. Pas de fil d'Ariane sur l'accueil (c'est la racine du fil que les autres pages
afficheront) et donc pas de `BreadcrumbList` JSON-LD ici — décision documentée dans
`includes/breadcrumbs.php`.

**Conversion** : CTA principal « Demander mon devis » cohérent sur toute la page (header, hero,
bandeau tarifaire, panneau tarif, CTA final, barre mobile), CTA secondaire téléphonique partout où
pertinent, réassurance (24 h · gratuit · sans engagement) reprise à plusieurs endroits sans jamais
répéter une fausse note, tarif présenté sans ambiguïté (voir correction ci-dessous), aucune fausse
urgence, aucune fausse preuve sociale.

### Corrections imposées par CLAUDE.md appliquées sur l'accueil
- « Aucun simulateur » → « Devis étudié personnellement par Audrey » (microcopie du hero).
- « Une couverture régionale, pas des agences fictives » → « Une entreprise régionale basée à
  Saint-Apollinaire » (titre de la section couverture).
- « Interlocuteur identifié » → « Interlocutrice identifiée » (bloc de réassurance).
- Les trois cartes « Conseils & repères » pointent chacune vers son article
  (`/conseils/frequence-bureaux/`, `/conseils/cout-nettoyage-bureaux/`,
  `/conseils/cahier-des-charges-nettoyage/`), plus aucune vers `/conseils/`.
- **Tarif réécrit entièrement.** Le prototype affichait un unique tarif fictif « 27 € HT/h »
  partout sur l'accueil (badge hero, bandeau, panneau tarif, exemple de budget). CLAUDE.md §5.3
  et §8 imposent le vrai point d'entrée (**à partir de 24,30 € HT/h**) et interdisent un chiffre
  différencié par ville — mais rien n'imposait de garder le raccourci « un seul prix pour tout » du
  prototype, qui est lui-même faux au regard de la grille réelle à trois tarifs
  (`PROJECT_INPUTS.md` §5 : 24,30 € locations · 26,00 € autres locaux · 30,00 € ponctuel). La
  section Tarifs de l'accueil détaille maintenant les trois montants réels, et l'exemple de budget
  (« bureaux réguliers, 12 h/mois ») est recalculé sur le tarif réel « autres locaux » (26,00 €) au
  lieu du tarif fictif : 321 € HT/mois (371 € le premier mois avec les frais de mise en place),
  contre 333 €/383 € dans le prototype. Écart signalé comme demandé (CLAUDE.md §4).

---

## 3. Données fictives neutralisées (docs/DONNEES-FICTIVES.md appliqué)

| Élément | Sort sur l'accueil |
|---|---|
| Note 5,0/5 + compteur 47 avis + lien Google `#` | Masqués. Le badge hero et le badge flottant sur le portrait n'existent que si `get_field('note', 'option')` et `get_field('nombre_avis', 'option')` sont renseignés (page d'options ACF, vides par défaut). |
| 40 avis de démonstration (`demo: true`) | Aucun repris. La section Audrey affiche un seul avis authentique s'il existe dans la page d'options (`avis` repeater), sinon un bloc neutre « Avis clients à venir » clairement identifiable comme contenu à compléter. |
| Citation attribuée à Audrey à la première personne (prototype) | Non reprise telle quelle : remplacée par un texte descriptif à la troisième personne (« Audrey suit votre dossier… ») — le brief §7 interdit d'inventer une information biographique sur elle, une citation directe non confirmée entre dans cette catégorie. |
| Portrait de stock présenté comme Audrey | Remplacé par une pastille neutre (initiale + « Photo à venir »), voir §2. |
| `alt` des photos de stock (hero, prestations, articles) | Tous réécrits avec la mention « (photo d'illustration) », aucun ne prétend montrer un lieu, une personne ou une intervention réelle de Top-Famille Pro. |
| JSON-LD | Aucune note agrégée (`AggregateRating`), aucun avis, aucune coordonnée géographique, aucun horaire inventé — uniquement les champs de `PROJECT_INPUTS.md` (§4 « Contacts publics », adresse, horaires « lundi-samedi 6h-22h »). Aucune donnée d'immatriculation (SIRET/TVA/APE) : absente du schéma, pas même en `[À COMPLÉTER]` — elle n'a simplement rien à faire dans le JSON-LD tant que le Kbis ne l'a pas confirmée. |

---

## 4. Résultats des vérifications (session du 7 août 2026)

Procédure complète en §11. Résumé :

| Contrôle | Résultat |
|---|---|
| 320 px | ✅ Aucun débordement horizontal (corrigé — voir §6), CTA mobile lisible, menu fonctionnel |
| 375 px | ✅ Aucun débordement horizontal |
| 768 px | ✅ Aucun débordement horizontal, bascule menu mobile encore active (seuil 820 px) |
| 1024 px | ✅ Aucun débordement horizontal, navigation desktop active |
| 1440 px | ✅ Aucun débordement horizontal |
| 1920 px | ✅ Aucun débordement horizontal, conteneur plafonné à 1260 px, pas d'étirement excessif |
| URL sans `#/` | ✅ Toutes les URL du thème sont des chemins réels |
| Vraie 404 | ✅ `curl -I` confirme un statut HTTP `404 Not Found` réel sur une route inexistante |
| Menu clavier | ✅ Sous-menus desktop : ouverture/fermeture au clic, fermeture par clic extérieur et par Échap. Menu mobile : piège de focus vérifié (3 tabulations restent dans le panneau), Échap ferme et restitue le focus, scroll du body verrouillé pendant l'ouverture |
| Données fictives visibles/structurées | ✅ Aucune trouvée (voir §3) |
| Secrets dans le dépôt | ✅ Aucun — `wp-config.php` du test local n'est pas dans ce dépôt (créé dans `/tmp`, hors repo) |
| Erreurs JS console | ✅ Aucune, sur les 6 largeurs testées + interactions clavier/souris |
| Erreurs PHP | ✅ Aucune dans `wp-content/debug.log` lors du rendu de l'accueil et de la 404 ; `npm run lint:php` : 35/35 fichiers valides |
| Accessibilité automatisée (axe-core, WCAG 2A/2AA/2.2AA) | ✅ 0 violation après correction (voir §6) — passe sur l'accueil (375 px et 1280 px) et sur la 404 |

---

## 5. Écart corrigé pendant la vérification

Un vrai bug de débordement horizontal a été trouvé et corrigé à 320 px (avant correction :
362 px de large au lieu de 320, soit +42 px) :
- Le bouton « Demander mon devis » du header ne rétrécissait pas sous 375 px environ (texte en
  `nowrap` dans un conteneur flex trop étroit). **Corrigé** en le masquant sous 820 px : la barre
  CTA mobile fixe fait déjà ce travail, le garder en double dans le header était redondant et
  cassait la mise en page.
- Les deux boutons de la barre CTA mobile (« Appeler » / « Demander mon devis ») ne rétrécissaient
  pas non plus pour la même raison (`flex: 1` sans `min-width: 0` sur un contenu `nowrap`).
  **Corrigé** : `min-width: 0`, texte autorisé à passer sur deux lignes, police et padding réduits
  pour cette barre spécifiquement.

Un vrai défaut de contraste a été trouvé et corrigé par axe-core : le numéro de département
(« 21 », « 25 »…) dans la section couverture régionale utilisait la couleur du prototype
`#7FAEBF` sur fond blanc (ratio 2,41:1, minimum WCAG AA = 4,5:1). **Corrigé** en réutilisant le
token `--color-text-tertiary` (#58717F), qui passe.

---

## 6. Limitations connues de cette phase

- **Aucun contenu réel dans les CPT** : `zone` et `prestation` sont déclarés (structure, champs
  ACF) mais vides. Les URL imbriquées définitives des zones
  (`/zones-intervention/{departement}/{ville}/`) ne sont pas encore câblées par des règles de
  réécriture dédiées — elles dépendent du contenu réel, à faire en phase 2 en même temps que le
  gabarit (documenté dans `includes/cpt-zone.php`).
- **Gabarits `page.php`/`single.php`/`index.php` volontairement minimalistes et en `noindex,follow`** :
  ce sont des filets de sécurité pour que WordPress ne plante pas si une page est créée avant la
  phase 2, pas des gabarits finaux. Les 17 pages statiques et les 3 articles seront construits en
  phase 2 avec leur structure obligatoire complète (réponse directe, FAQ visible, JSON-LD dédié…).
- **Pas de logo SVG** (gap déjà identifié en phase 0) : `logo-horizontal.png` recompressé à 360 px
  (2× la taille d'affichage) sert de solution provisoire correcte, mais un SVG serait plus net et
  plus léger.
- **Pas de favicon** (gap déjà identifié en phase 0) : à générer dès que le logo carré est
  disponible en meilleure qualité.
- Le drop-in de sécurité (`includes/security.php`) est scopé à ce qu'un thème peut légitimement
  faire ; les réglages serveur/`wp-config.php` (voir §9) restent à appliquer en phase 1+ côté
  hébergement.

---

## 7. Phase 3 — faite (voir §-2). Correction d'une erreur de cette section

Cette section listait, à la fin de la phase 2, huit noms de communes secondaires
(Beaune, Chevigny-Saint-Sauveur, Ahuy, Daix, Plombières-lès-Dijon, Sennecey-lès-Dijon,
Nuits-Saint-Georges, Ruffey-lès-Echirey) comme étant « les 8 communes secondaires du prototype ».
**C'était une erreur de conflation**, corrigée en phase 3 : cette liste provenait en réalité du
champ `communesPlain` de la ville de Dijon dans les données extraites du prototype (une liste de
villages de la « première couronne » dijonnaise, une donnée différente), pas de la liste officielle
des 8 pages « commune secondaire » du prototype. La liste correcte, tirée de
`docs/INVENTAIRE-ROUTES.md` (section « Zone — commune secondaire », relevée directement dans les
routes du prototype), est : **Saint-Apollinaire, Chenôve, Quetigny, Talant, Longvic,
Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune** — ce sont ces 8 communes qui ont été créées en
phase 3 (`noindex,follow`, voir §-2).

---

## 8. Données réelles encore attendues (reporté de la phase 0, toujours d'actualité)

### Bloque la mise en ligne
- Kbis (SIRET, capital, APE, TVA, date d'immatriculation, incohérence SIREN à lever)
- Assureur RC professionnelle (nom + n° de police)
- URL de la fiche Google Business + note réelle + nombre d'avis réels — **techniquement prêt à
  recevoir ces valeurs** dès qu'elles sont fournies (page d'options ACF « Réassurance & avis »,
  aucune modification de template nécessaire)
- Portrait HD d'Audrey + visuels réels

### Phase 1 (restée ouverte)
- E-mails en `@top-famille-pro.fr` ou maintien de `@top-famille.fr` ?
- Accès hPanel / SFTP / base de données ; `top-famille-pro.fr` déposé et pointé ?
- Une archive de photos réelles/temporaires n'a pas été fournie dans cette session — les visuels de
  stock de `assets/photos/` (phase 0) restent utilisés en placeholders.

### Restés ouverts après la phase 3
- Confirmation que les tarifs relevés sont toujours à jour.
- Validation une par une des 8 communes secondaires du prototype — Saint-Apollinaire, Chenôve,
  Quetigny, Talant, Longvic, Fontaine-lès-Dijon, Marsannay-la-Côte, Beaune (liste corrigée, voir §7 ;
  pages déjà créées en `noindex,follow`, §-2).
- Avis clients réels : texte exact des 6 témoignages authentiques (§-2).

### Phase 6
- Adresse de réception des demandes de devis + test d'envoi réel du formulaire (le code envoie
  réellement via `wp_mail()` depuis la phase 3, champs enrichis en phase 4, §-3 ; non testable bout
  en bout faute de transport mail dans le bac à sable — à vérifier dès le déploiement Hostinger).
- Devenir de `topentreprise.fr` + inventaire des articles de son blog (phase 6).

---

## 9. Réglages à appliquer côté hébergement/serveur (hors dépôt thème)

- `define('DISALLOW_FILE_EDIT', true);` dans `wp-config.php`.
- Limitation des tentatives de connexion (plugin dédié ou pare-feu Hostinger).
- Cache LiteSpeed (CLAUDE.md §3) — à configurer une fois le site déployé.
- PHP ≥ 8.0 côté hPanel Hostinger (le thème n'utilise aucune syntaxe antérieure).

---

## 10. Décisions nécessitant une validation humaine

1. **Fusion de sections** (§2) : « Professionnels accompagnés » dans Prestations, « Pourquoi »
   dans « Audrey et avis ». Réversible facilement si Emmanuel préfère les sections séparées.
2. **Portrait d'Audrey en pastille neutre plutôt qu'en photo de stock** (§2) : à valider — l'option
   alternative (garder une photo de stock générique avec un `alt` honnête) reste possible si jugée
   préférable visuellement, mais expose au risque de confusion identifié.
3. **Détail des trois tarifs sur l'accueil** plutôt qu'un chiffre unique (§2) : à valider —
   l'alternative minimaliste (n'afficher que « à partir de 24,30 € HT/h » partout, sans les trois
   montants) reste possible si la page doit rester plus courte, au prix d'une précision en moins.
4. **Suppression du CTA devis dans le header mobile** (§5) : la barre CTA mobile fixe le remplace ;
   à confirmer que c'est suffisant plutôt que de redimensionner le bouton du header.

---

## 11. Procédure de vérification utilisée cette session (référence, non versionnée)

Pas de MySQL ni de Docker fonctionnel disponibles dans cet environnement, et `wordpress.org` hors
de portée réseau (politique de l'environnement). Vérification faite avec un WordPress jetable,
entièrement hors du dépôt (`/tmp`, jamais commité) :

```bash
# Cœur WordPress (miroir GitHub, wordpress.org étant inaccessible depuis ce bac à sable)
git clone --depth 1 https://github.com/WordPress/WordPress.git wp-core

# Drop-in SQLite (base de données sans MySQL), simple fichier unique
git clone --depth 1 https://github.com/aaemnnosttv/wp-sqlite-db.git sqlite-simple
cp sqlite-simple/src/db.php wp-core/wp-content/db.php
mkdir -p wp-core/wp-content/database

# wp-cli
curl -sSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o wp-cli.phar

# Thème parent GeneratePress : introuvable sur GitHub (dépôt privé/absent), remplacé par un stub
# minimal (juste l'en-tête de style.css) pour satisfaire la contrainte "parent theme" de
# WordPress — le thème enfant ne dépend d'aucune fonction PHP de GeneratePress, seulement de son
# style.css (chargé en best-effort dans includes/enqueue.php).

# Installation + thème enfant lié au vrai dossier du dépôt
php wp-cli.phar core install --url=http://localhost:8899 --title="Test" \
  --admin_user=admin --admin_password=admin --admin_email=test@example.com --skip-email --allow-root
ln -s /chemin/vers/ce/depot/wp-content/themes/topfamillepro wp-core/wp-content/themes/topfamillepro
php wp-cli.phar theme activate topfamillepro --allow-root

php -S localhost:8899
```

Puis Playwright (Chromium préinstallé de l'environnement) pour les 6 largeurs, les interactions
clavier/souris et un scan `axe-core`. **Sur un WordPress réel (MySQL, vrai GeneratePress, ACF
actif)**, suivre plutôt la procédure standard du `README.md` du thème.

---

## 12. Reproduction intégrale de la maquette Claude Design (10 août 2026)

Branche : `hotfix-production-fidelite-claude-design`. **Rien n'est fusionné dans `main`, rien
n'est déployé.**

### Fait

Le contenu des 53 pages est désormais **relevé dans la maquette**, plus jamais rédigé. Le
prototype est un bundle auto-décompressant doublé d'une application à routes `#/` : il s'exécute
dans Chromium, il ne se lit pas. C'est le point qui débloque tout le reste.

Outils rejouables ajoutés (`tools/`) :

| Fichier | Rôle |
|---|---|
| `route-map.mjs` | table route maquette → route WordPress, partagée, sans effet de bord |
| `extract-routes.mjs` | découvre les routes et extrait tout leur contenu et leurs styles calculés |
| `compare-routes.mjs` | compare les 53 routes, produit les triptyques de différence |
| `diff-text.mjs` | dit à la phrase près ce qui manque, et compte à part les écarts voulus |
| `dump-route.mjs` | restitue une route section par section |
| `image-map.mjs` | croise maquette, manifeste d'images et fichiers réellement servis |
| `generate-{prestations,zones,articles,pages}.mjs` | produisent les scripts de seed |

Fichiers de référence versionnés : `tools/reference-routes.json`,
`docs/MATRICE-ROUTES-CLAUDE-WORDPRESS.md`, `docs/COMPARAISON-53-ROUTES.md`,
`docs/IMAGES-MAQUETTE-WORDPRESS.md`, `docs/captures/comparaison/` (106 triptyques).

Résultat : **53 routes, 0 phrase de la maquette absente**, 6 écarts voulus nommés.

### Ce qu'il faut savoir avant de reprendre

1. **Ne pas éditer `bin/seed-fidelite-*.php` à la main.** Ils sont générés ; toute correction se
   fait dans `tools/generate-*.mjs`, sinon la prochaine régénération l'écrase.
2. **Une extraction partielle n'écrase plus l'extraction complète** : `extract-routes.mjs --only=…`
   écrit vers des fichiers `.partiel`. Ce garde-fou existe parce que l'inverse s'est produit —
   les fichiers de référence tronqués à une route, et tous les outils comparant une page sur 53
   sans le signaler.
3. **Les rigs WordPress** : `localhost:8899` (thème en lien symbolique, environnement
   `development`) et `localhost:8901` (thème **copié**, environnement `production` par défaut).
   Le second sert à prouver le comportement réel en production — penser à y recopier le thème
   après modification, sinon il teste une version périmée.
4. **Politique des témoignages** : voir CLAUDE.md §5.5, réécrit le 10 août. Ils sont reproduits et
   visibles, marqués `data-tfp-provisional`.

### Passe finale de fidélité — 10 août 2026

Verdict : **PARTIEL — ÉCARTS RESTANTS**. Rapport complet dans
`docs/RAPPORT-FIDELITE-FINALE.md`, écarts autorisés dans `docs/ECARTS-MAQUETTE-AUTORISES.md`.

**Le critère WCAG 2.5.8 avait été mal lu.** Le seuil AA est de **24 × 24 px**, ou un espacement
suffisant, ou l'exception « inline » ; les 44 × 44 px relèvent de 2.5.5, de niveau **AAA**. Cette
erreur avait été propagée dans le CSS et dans le rapport précédent, et gonflait les pages de zone
de 11 à 23 %. Le point 2 de « Reste à faire » de la version précédente de ce fichier — « à
trancher : fidélité visuelle ou confort tactile » — était donc un faux dilemme : les deux sont
conciliables, il suffisait d'appliquer le bon critère.

`tools/audit-target-size.mjs` vérifie désormais la règle telle qu'elle est écrite, condition par
condition. Aucune violation sur les 53 routes, à 1440 et 375 px.

**Principe posé pour toute la mise en page : elle se relève sur le rendu du prototype, elle ne se
devine pas.** Le nombre de colonnes d'une bande, son traitement en cartes, la géométrie de ces
cartes et l'appartenance de chaque bloc à une rangée sont mesurés par `tools/generate-pages.mjs`
puis stockés avec le contenu. L'heuristique précédente (« plusieurs blocs courts ⇒ colonnes »)
rendait 2 083 px de maquette en 1 338 px sur `/a-propos/`.

Trois outils s'ajoutent :

| Outil | Rôle |
|---|---|
| `compare-styles.mjs` | styles calculés des 53 routes : polices résolues, couleurs, largeurs, cartes, boutons, grilles |
| `validation-finale.mjs` | 12 routes × 2 largeurs × 3 images (maquette / WordPress / différence) |
| `audit-jsonld.mjs` | `FAQPage` sans FAQ visible, `Review`/`AggregateRating` interdits, graphes illisibles |
| `audit-target-size.mjs` | WCAG 2.2 AA 2.5.8, les trois conditions |
| `measure-chrome.mjs` | sépare la coquille de page (en-tête, pied) du flux de contenu |
| `banc-production.mjs` | compression Brotli/gzip + cache devant le rig, pour mesurer comme en production |

Résultats : **833 tests au vert**, 0 bloc de texte manquant, 0 violation axe-core, 0 violation
2.5.8, JSON-LD conforme, 0 `[À COMPLÉTER]` visible, sitemap à 45 URL avec les 8 communes non
validées correctement exclues.

Performance mobile, ZIP final installé, sur banc avec compression et cache : **90 à 100** sur les
six pages, Accessibilité 100, Bonnes pratiques 100, SEO 100, CLS ≤ 0,010. Sur banc nu, sans
compression : 83 à 96. L'écart tient entièrement au premier rendu et à la feuille de style servie
non compressée (59 Ko contre 10 Ko en Brotli) — d'où la vérification de compression ajoutée en
tête de la recette de déploiement.

### Passe « vocabulaire de cartes » — 10 août 2026

Verdict : **PARTIEL — ÉCARTS RESTANTS**. Rapport : `docs/RAPPORT-CARTES.md`, inventaire :
`docs/INVENTAIRE-CARTES-53-ROUTES.md`.

Le dernier défaut important n'était ni textuel ni fonctionnel. Une page peut contenir **toutes**
les phrases du prototype, faire **la même hauteur**, et présenter huit contraintes dans deux gros
pavés là où la maquette en fait huit micro-cartes. Aucun outil existant ne voyait cela :
`tools/inventaire-cartes.mjs` relève désormais chaque carte des deux côtés — archétype, bande,
titre, texte, médias, géométrie, colonnes, responsive — et nomme quatre anomalies : carte
**absente**, cartes **fusionnées**, carte **supplémentaire**, mauvais **type** ou **colonnes**.

Corrigé dans cette passe :
 - les **six pages prestation**, chacune comparée à sa propre route : 45 anomalies → 1 ou 2, zéro
   carte absente, zéro carte fusionnée (21→21, 20→20, 28→28, 21→21, 21→21, 21→21) ;
 - la **bande sombre des six prestations** sur les 19 pages de zone, rendue jusqu'ici en cartes
   blanches sur fond clair ;
 - les **colonnes par rangée** dans les pages statiques (le maximum de la bande laissait une
   colonne vide sur les rangées plus courtes).

Reste, cause unique et identifiée : **`tools/generate-pages.mjs` réduit à un libellé (`noms`) les
blocs que la maquette rend en micro-carte « titre + description »**. La description est perdue à
l'extraction, donc la carte ne peut pas être reconstituée à l'affichage. C'est ce qui explique
`#/zones-intervention` (52 → 19 cartes), `#/nettoyage-professionnel` (53 → 68), `#/nos-prestations`
(12 → 25) et `#/avis-clients` (14 → 46). La correction est structurelle : elle touche l'extraction,
pas le CSS.

### Reste à faire

- **Cartes** : reprendre l'extraction des micro-cartes « titre + description » dans
  `generate-pages.mjs` (voir §8 de `docs/RAPPORT-CARTES.md` pour les six routes concernées).
- **Décisions humaines** (pas du code) : validation par Audrey de la citation qui lui est
  attribuée ; remplacement des témoignages provisoires par de vrais avis ; nombre d'avis Google et
  URL de la fiche ; attestation d'assurance ; validation une par une des huit communes secondaires.
- **Vérifier la compression à la mise en ligne.** C'est la seule action qui sépare 83-96 de
  90-100 en performance, et elle est mesurable en une commande (guide de déploiement, étape 19).

---

## Passe finale — 11 août 2026 (branche `hotfix-production-fidelite-claude-design`, PR #9)

Rapport complet : `docs/RAPPORT-PASSE-FINALE.md`. Verdict : **PARTIEL — ÉCARTS RESTANTS**.

### Fait

- **`/contact/` reproduite** : sept cartes sur sept, plus le formulaire de contact court qui
  manquait — distinct du formulaire de devis en deux étapes, qui n'a pas été touché. La carte de
  note Google lisait une clé inexistante et affichait « /5 sur Google » sans chiffre devant.
- **Horaires provisoires** : repris de la maquette, marqués provisoires avec mention visible,
  administrables dans Réglages → Réassurance & avis, et jamais déclarés en
  `openingHoursSpecification` — une amplitude non confirmée en donnée structurée est un engagement
  opposable.
- **Sécurité du formulaire** : nonce, honeypot hors écran et hors clavier, limitation, validation
  serveur complète, saisie conservée en cas d'erreur. Aucun test ne peut faire partir un e-mail :
  le formulaire porte `data-tfp-mail-disabled` en local, et la suite refuse de soumettre sans lui.
- **Pages de zone, quatre défauts structurels** : niveau des titres perdu à l'extraction (la bande
  passait de 2 colonnes de 566 px à 4 de 265), bande tarifaire à trois colonnes et non deux, phrase
  de justification du montant rendue loin du montant, et **les trois garanties du bandeau tarifaire
  perdues sur les 26 pages** — l'extraction ne relevait que les feuilles, et le libellé est un nœud
  texte à côté de l'icône.
- **Inventaire des cartes** : trois faux positifs d'outil corrigés (texte volontairement corrigé
  compté deux fois, archétype différent compté deux fois, coquilles vides), et la seule cause des
  ~110 rangées de pastilles mal coupées — `.tfp-chip` appliquait 15 px là où son commentaire
  annonçait les 14 px relevés. **934 anomalies dont 283 graves → 542 dont 101.**
- **Classement exhaustif** des 209 anomalies « supplémentaire » et « colonnes » :
  `docs/ANOMALIES-SURPLUS-COLONNES.md`, une ligne par occurrence, dix causes nommées.
- **Contrôle post-installation** : `bin/verifier-installation.php` retrouve les trois URL parasites
  du banc, publiées et référencées au sitemap. Étape 20 du guide de déploiement.
- **Décalage de mise en page** : il venait de l'en-tête, pas du hero. CLS bureau 0,255 → 0,028,
  CLS mobile 0,000 partout, performance 92–100, et 100 en accessibilité, bonnes pratiques et SEO
  sur les quatorze mesures.
- **Exports** reconstruits depuis une installation propre : 53/53 routes hors ligne, 0 ressource
  manquante, 0 image cassée, 0 requête externe, 0 fuite de `localhost`.
- **965 tests Playwright**, tous verts.

### Reste à faire

- **CLS de 0,028 en profil bureau** sur les sept pages : sous le seuil « bon » de Google (0,10),
  au-dessus de la cible interne de 0,010. L'en-tête se réagence encore de quelques pixels.
- **Fidélité à 768 px** : 7 routes sur 53 dans la tolérance. Cause identifiée — la maquette garde
  deux colonnes tant que la place le permet, le thème s'empile dès 819 px. La liste de tâches a été
  alignée ; l'abaissement global des points de rupture reste à faire et à re-vérifier sur les
  53 routes aux six largeurs.
- **Sept causes d'anomalies « à instruire »** sur les dix du classement (129 occurrences).
- **Décisions humaines** : nombre réel d'avis Google et URL de la fiche · validation de la citation
  par Audrey · validation une par une des huit communes secondaires · remplacement des témoignages
  provisoires · horaires de contact réels · sort des contenus que `verifier-installation.php`
  signalera sur l'installation réelle.

## Passe G26, suite — 18 août 2026 (branche `claude/g23-fidelite-claude-design-7doxg4`)

### Fait

**Texte des huit communes passé à l'affirmatif**, à la demande d'Emmanuel après la validation de
leur desserte le 17 août. En instruisant la demande, une **erreur de mon compte rendu de la veille**
est apparue : j'avais annoncé que les huit pages disaient « la demande peut être étudiée ». C'était
vrai du champ `reponse_directe` posé par `bin/seed-phase3-batch4-communes.php`, mais **ce champ est
réécrit ensuite** par `bin/seed-fidelite-zones.php`, qui s'exécute après lui dans `tools/banc-local.sh`.
Le texte réellement servi affirmait donc déjà l'intervention sur **sept des huit** (« Top-Famille Pro
y entretient … » ; Saint-Apollinaire est le siège). Une seule page restait à reprendre — Quetigny,
dont la réponse directe décrivait la commune sans jamais dire que nous y intervenons.

Beaune garde une formulation prudente, **et c'est voulu** : elle porte sur Savigny-lès-Beaune et
Pommard, qui ne font pas partie des huit communes validées.

**Deux fautes de langue nommées par `CLAUDE.md` §9 étaient encore servies** et sont corrigées :

| Faute | Occurrences | Correction |
|---|---|---|
| « … sont possible **lorsque prévu** dans le cahier des charges et **chiffré** dans le devis » | **28**, sur les 26 zones | accordé au sujet de chaque phrase (féminin singulier, féminin pluriel, masculin pluriel selon les cas) |
| « lister **precisément** » | 1, `/conseils/cahier-des-charges-nettoyage/` | « lister précisément » |

Elles ne relèvent pas de la consigne du 10 août 2026, qui porte sur les **formulations** ; §9 demande
au contraire la correction orthographique et grammaticale des 53 pages en nommant ces deux cas.
« Aucun simulateur » et « une couverture régionale, pas des agences fictives » **restent différées**
et n'ont pas été touchées.

**Où les corrections sont portées.** `bin/seed-fidelite-zones.php` et `bin/seed-fidelite-articles.php`
sont **générés** : corriger le fichier produit aurait été effacé à la régénération suivante. Les
règles vivent donc dans `tools/generate-zones.mjs` (`CORRECTIONS_EDITORIALES`, `GRAMMAIRE`) et
`tools/generate-articles.mjs` (`ORTHOGRAPHE`). Les deux générateurs **échouent** si un fragment
attendu a disparu de la maquette, plutôt que de produire silencieusement un texte non corrigé.

**Paquet d'installation resynchronisé.** `installer/topfamillepro-content-installer/seed/` avait
**dérivé de `bin/`** — dérive antérieure à cette passe, jamais signalée : `seed-fidelite-pages.php`
1216 lignes d'écart, `seed-fidelite-zones.php` 401, `seed-phase3-batch4-communes.php` 133,
`seed-phase4-maillage.php` 72. Et `bin/seed-reassurance.php`, qui porte la décision du 17 août sur la
note Google, **n'était pas du tout dans le paquet**. Le plugin d'installation aurait donc déployé un
site plus ancien que le dépôt. Les six fichiers sont resynchronisés, `seed-reassurance.php` est
ajouté à la liste ordonnée de `includes/installer.php`, et l'étiquette « 8 communes secondaires
(noindex,follow) » y devient « 8 communes desservies (validées le 17/08/2026, index) ».

### Contrôles

- Suite complète : **1156 verts**, 0 échec (1079 + 77 nouveaux).
- `tests/communes-affirmatif.spec.js` (nouveau) : réponse directe affirmative, aucune tournure
  conditionnelle sur la commune de la page, `index,follow` et description qui la nomme, pour les
  huit ; puis les quatre fautes nommées par §9 absentes des **53 routes**. Contrôle sur le HTML
  servi, pas sur le seed — le seed étant généré, c'est le seul endroit où la régression se verrait.
- **Témoin** : contenu d'avant rechargé dans le banc, ces mêmes tests rejoués → **16 échecs**. Le
  verrou n'est pas complaisant.
- `tools/diff-text.mjs` : **0 bloc de texte manquant** sur les 53 routes, 36 écarts nommés.
- 112 comparaisons régénérées, `docs/COMPARAISON-53-ROUTES.md` à jour, **0 débordement**.

### Un écart de mesure élucidé, à ne pas relire comme une régression

Trois ratios du rapport de comparaison sortent de la bande 95-105 % alors qu'ils y étaient : mots de
`/avis-clients/` 105 → 106 %, de `/a-propos/` 102 → 103 %. **Ce n'est pas cette passe.** Le rapport
au dépôt datait du commit `b2f3951`, mesuré quand la note Google était masquée ; `5a5a02a` l'a
réaffichée sur décision d'Emmanuel sans régénérer le rapport. Vérifié par bascule du réglage
« Afficher sans la fiche » : 649 → 641 mots sur `/avis-clients/`, 1142 → 1134 sur `/a-propos/`, soit
exactement les valeurs d'avant et d'après. Le rapport était périmé sur ce point ; il ne l'est plus.

### Reste à faire

- **`fonctionnement` est un champ ACF mort** : `single-zone.php` le lit (ligne 35) et ne l'affiche
  jamais. Il est pourtant enregistré, éditable en administration et alimenté sur les 26 zones par
  les seeds de phase 3. La bande « Fonctionnement, accès et suivi » réellement servie vient de
  `methode_2_titre`/`methode_2_texte`, posés par le seed de fidélité. En l'état, un éditeur peut
  écrire dans ce champ en croyant publier. À trancher : le brancher au gabarit, ou le retirer.
  **Non corrigé de moi-même** : le brancher changerait la composition des 26 pages de zone.
- **Répétitions de « le cas échéant »** (§9) : 5 sur `/tarifs/`, 3 sur `/zones-intervention/bourgogne-franche-comte/`,
  2 sur l'accueil et le pilier. La maquette en compte 40. Trois des cinq de `/tarifs/` sont des
  intitulés de ligne de tableau, répétés par structure. C'est une reformulation, pas une faute :
  elle tombe sous la consigne du 10 août et attend un arbitrage.
- Le verdict reste **`PARTIEL — ÉCARTS RESTANTS`** jusqu'à validation humaine des captures.

## Complément G26 — contenu, ACF et installeur (18 août 2026)

Rapport détaillé en 8 points : `docs/RAPPORT-G26-COMPLEMENT.md`.

### Fait

**Le champ ACF `fonctionnement` alimente enfin une section servie.** Il était enregistré, éditable
sur les 26 zones, rempli — et affiché nulle part : `single-zone.php` le lisait (ligne 35) sans
jamais l'écrire. Il pilote maintenant le chapitre de méthode que la maquette consacre au
fonctionnement sur chaque zone, désigné **par son titre** dans `SECTION_FONCTIONNEMENT`
(`tools/generate-zones.mjs`) — si le titre disparaît de la maquette, la génération échoue. Le seed
écrit `fonctionnement` et `fonctionnement_bloc` ; le gabarit sert l'un **ou** le repli, jamais les
deux. Quatre départements n'ont pas de chapitre « fonctionnement » : c'est leur chapitre
d'organisation qui est désigné, faute d'équivalent plus proche, et c'est signalé.

**Note Google masquée à nouveau.** La dérogation « Afficher sans la fiche » est supprimée : elle
permettait exactement ce que la consigne du 18 août interdit. La garde exige trois conditions
simultanées — note saisie, URL non vide, URL de **forme** « fiche Google ». Limite énoncée : ce
contrôle ne prouve pas l'appartenance de la fiche, aucun code ne le peut, et l'écran de saisie le
dit. `bin/seed-reassurance.php` n'écrit jamais `google_url` : il ne peut pas réactiver la note.

**« Le cas échéant » réduit.** Quatre blocs la répétaient — dont la bande des budgets de `/tarifs/`,
qui la posait **quatre fois** (chapeau + trois intitulés de ligne). Une note unique, visible et
rattachée au tableau par `aria-describedby`, la porte désormais. Aucune condition contractuelle
retirée. 30 occurrences restent, toutes uniques dans leur bloc, documentées route par route dans
`docs/CONDITIONS-TARIFAIRES.md`.

**La dérive du paquet d'installation ne peut plus passer inaperçue.**
`tools/verifier-parite-installeur.mjs` compare le dépôt et la livraison — seeds (dans les trois
sens), fichiers exigés nommément, CSS/JS reconstruits à part et comparés octet par octet, manifeste
d'images, archives — et échoue en nommant les chemins. Joué par la suite **et** avant chaque export.
Trois fixtures d'avarie prouvent qu'il détecte un seed absent, une copie modifiée et une feuille
distribuée en retard. `tools/build-paquets.mjs` reconstruit les deux archives depuis l'arbre de
travail, sur la liste des fichiers suivis par git.

Ce contrôle a trouvé, en s'installant, que `topfamillepro-theme.zip` embarquait **143 images sur
les 378** que son manifeste réclame — un déploiement depuis cette archive aurait servi des `srcset`
vers des fichiers absents. Corrigé.

### Contrôles

- Suite complète : **1223 verts**, 0 échec (1156 + 67 nouveaux).
- Parité dépôt ↔ livraison : **1279 fichiers comparés par empreinte**, 0 manquant, 0 divergent.
- 53 routes × 16 motifs interdits : **0 occurrence** (note, compteur, `Review`, `AggregateRating`,
  `ratingValue`, `href="#"`, fautes §9, anciens tarifs).
- `diff-text` : **0 bloc de texte manquant**, 146 écarts nommés.
- Baseline régénérée : **318/318 contrôles**, 298 dans 95-105 %, 0 débordement, 0 erreur console.
- 112 comparaisons régénérées : 212 ratios, **19 hors bande** — les mêmes qu'avant la passe, tous
  documentés. Les deux que la note Google avait fait sortir le 17 août sont rentrés.
- Huit communes : `index,follow` et au sitemap (26 zones), décision du 17 août confirmée le 18.
- Témoins de non-complaisance : gabarit d'avant → **7 échecs sur 8** au test du champ ACF ; trois
  fixtures d'avarie → contrôle de parité en échec sur les trois.

### Reste à faire

- URL de la fiche Google, nombre réel d'avis : toujours non fournis. Note et compteur invisibles.
- Photo d'Audrey et citation : provisoires ; la citation fait parler une personne réelle et reste à
  valider par l'intéressée avant mise en ligne.
- `CLAUDE.md` §5.5 énonce toujours la note comme affichable : contradiction **signalée**, à trancher.
- « Aucun simulateur » et « agences fictives » : corrections §9 différées, non touchées.
- Verdict **`PARTIEL — ÉCARTS RESTANTS`** jusqu'à validation humaine des captures.


## Passe G27 — §4 et §11 (19 août 2026)

### §4 — objectif 300/318 ATTEINT

**Relevé de base : 318 contrôles · 300 dans 95-105 % · 18 hors, toutes des pages légales · 0
débordement · 0 erreur console.** Les 50 routes non légales tiennent la plage **aux six largeurs**.

Deux défauts corrigés, tous deux à la cause :

**`/avis-clients/` (94 % à 320 px → 101-104 % partout).** Le prototype compose ses avis en `<figure>`
sur trois niveaux typographiques — citation 16/25,6, nom 17/27,5, métadonnées 13/21,1 — et le
générateur ne relevait qu'**une** taille de description par grille : les trois s'écrasaient sur la
plus petite, le nom de l'auteur passait à la place des étoiles, ville et date disparaissaient. Le
rendu était **faux**, pas seulement court. Un archétype `temoignage` est relevé à part et rendu par
le composant de témoignage, qui a exactement cette forme.

En cours de correction, la page est passée à 106-110 % — trop longue cette fois. Cause : la mention
« Exemple de présentation » répétée **dans chaque carte** alors que la grille l'annonce déjà
au-dessus. Trois lignes × six cartes = 350 px pour une information déjà donnée. La mention reste,
une seule fois.

**`/pourquoi-nous/` (106 % à 375 px → 105 %), sans toucher aux commandes.** Le hero dépassait de
239 px : 156 px pour la rangée de commandes — **conservée**, c'est une décision, et le système de
boutons est déjà celui de la maquette (60 px contre 61) — et **82 px pour un surtitre de hero vide**.
Le badge région en avait été retiré (G26 §9) et la note Google est masquée : le conteneur ne
recevait plus rien et gardait pourtant `min-height: 72px` sous 600 px, plus 16 px de marge. Défaut
pur, corrigé par `:not(:has(> *))` — l'absence d'**enfant**, car le conteneur porte des espaces et
`:empty` ne l'aurait jamais reconnu. Les sept pages institutionnelles y gagnent.

### §3 — décomptes réconciliés

`318 − 298 = 20` et `19` venaient de **deux instruments**. `tools/reconcilier-ratios.mjs` les
recalcule, vérifie leur arithmétique interne, et classe chaque écart avec sa cause :

| | Relevé de base | Comparaison des routes |
|---|---|---|
| Contrôles | 53 × 6 = **318** | 53 × 2 × 2 = **212** |
| Hors bande | **18**, toutes légales | **19**, toutes classées |

Les trois ratios de **mots** de `/` et `/avis-clients` sont des ajouts imposés par le brief, relevés
fragment par fragment : lien d'évitement, noms accessibles des déplieurs, exclusions réelles et
matériel fourni par le client (§9), mentions de contenu provisoire (§5.5), coordonnées du pied.

### §11 — diagnostic complet, correction NON appliquée

`docs/DIAGNOSTIC-LCP.md` relève pour les 14 mesures : élément LCP, TTFB, découverte, transfert,
rendu, taille et priorité de la ressource, poids et fin de chargement des polices et de la CSS.

**Quatre mesures restent au-dessus de 2,5 s**, toutes en mobile, entre 2,71 et 2,87 s. Sur trois des
quatre, l'élément LCP est **du texte** ; sur la quatrième, l'image pèse 17 ko en priorité High avec
26 ms de transfert. **Il n'y a pas de ressource à optimiser.** La décomposition observée tient en
190-250 ms : le reste vient de la **chaîne critique**, c'est-à-dire du nombre d'allers-retours avant
le premier rendu.

Trois leviers examinés, deux écartés avec leur raison :

- **CSS critique en ligne** (`CLAUDE.md` §8) — levier principal, **non appliqué** ;
- retirer la feuille du thème parent — **non mesurable honnêtement ici** : elle fait 47 octets sur
  le banc et porte les styles de base en production ;
- réduire les 4 préchargements de polices — **à ne pas faire** : ils corrigent un CLS mesuré à 0,25.

> Le tableau distingue explicitement le LCP **simulé** de la décomposition **observée** : les quatre
> temps ne s'additionnent pas jusqu'au LCP, et les additionner serait lire le tableau à l'envers.

### Contrôles

- Suite complète : **1250 verts**, 0 échec.
- Parité dépôt ↔ livraison : **1279 fichiers**, 0 manquant, 0 divergent.
- Baseline : 318/318 · 300 dans la plage · 0 débordement · 0 erreur.
- 112 comparaisons régénérées · lint PHP 82 fichiers.

### Reste à faire

§6 (présentation des CTA — mesuré, déjà conforme), §10 (formulaire), §11 (CSS critique), §13
(captures ciblées), §14 (batterie finale), §15 (rapport complet). Verdict **`PARTIEL — ÉCARTS
RESTANTS`**.


## G27 §11 — LCP mobile sous la cible sur les sept routes (19 août 2026)

### Le CSS critique a été appliqué, mesuré, et RETIRÉ

`CLAUDE.md` §8 le demande, et le raisonnement tenait : un LCP texte est peint dès que le HTML et la
CSS sont là, donc supprimer l'aller-retour de la feuille devrait le devancer. **La mesure dit le
contraire.**

L'extracteur (`tools/extraire-css-critique.mjs`) relève les règles réellement appliquées au premier
écran des 53 routes, à 375 et 1440 px — 317 règles sur 741, 40 Ko minifiés. Mis en ligne, feuille
complète en `preload` + bascule :

| Mesure mobile | Avant | Avec CSS critique | Sans aucune feuille bloquante |
|---|---:|---:|---:|
| Accueil | 2,87 s | **3,02 s** | **3,01 s** |
| Prestation | 2,87 s | **3,01 s** | **3,01 s** |

Le dispositif dégrade de 0,14 s, et vider la chaîne bloquante n'y change rien : **l'aller-retour de
la feuille n'était pas le goulot**. Les 40 Ko en ligne portent le HTML transféré de 12 à 19,4 Ko, et
c'est ce poids qui se paie. Retiré du thème. L'extracteur reste : il a produit la mesure et permet
de la refaire. C'était la deuxième tentative sur ce chemin — la première, le 9 août, avait produit
un CLS de 1,002 — et la trace écrite est ce qui évitera une troisième.

### La vraie cause : sept fichiers de police pour deux polices

L'accueil pesait **341 Ko, dont 264 Ko de polices** — 78 % de la page. Sept fichiers au premier
écran, tous de tailles rigoureusement identiques d'une graisse à l'autre : ce n'étaient pas sept
polices, **c'était le même fichier variable téléchargé sept fois**.

Les deux familles sont variables. Demandées graisse par graisse (`wght@400;500;600;700;800`),
l'API Google renvoie quinze déclarations `@font-face` pointant vers **trois URL** ; le téléchargeur
en faisait quinze fichiers de noms différents, et le navigateur, ne pouvant deviner qu'ils sont
identiques, en chargeait sept. Demandées en plage (`wght@400..800`), les mêmes octets arrivent en un
fichier par famille et par sous-ensemble : **18 fichiers deviennent 4**, l'accueil en charge **2**.

Le rendu ne peut pas changer — mêmes glyphes, même fichier. Seul le nombre de téléchargements change.
`build/fetch-fonts.mjs` refuse désormais de continuer si Google renvoie une graisse fixe ou deux
fichiers distincts pour un même sous-ensemble.

### Résultat

| Route | LCP mobile avant | après |
|---|---:|---:|
| Accueil | 2,87 s | **1,82 s** |
| Prestation | 2,87 s | **1,82 s** |
| Ville | 2,87 s | **1,82 s** |
| Tarifs | 2,72 s | **1,66 s** |
| Article | 2,42 s | **1,82 s** |
| Contact | 2,42 s | **1,66 s** |
| Formulaire de devis | 2,50 s | **1,67 s** |

**Sept routes sur sept sous 2,5 s, avec 0,7 s de marge.** Performance mobile de 93-97 à **99-100**,
bureau **100 partout**. **CLS 0,000 sur les quatorze mesures** : le préchargement qui corrigeait le
CLS de 0,25 en G24 est préservé, avec deux fichiers au lieu de quatre et davantage de graisses
couvertes.

### Contrôles

- Relevé de base après changement : **318/318 · 300 dans 95-105 %** — inchangé, aucune régression
  visuelle. Le 320 px gagne même un point dans la bande resserrée 98-102 %.
- `tests/ratios-baseline.spec.js` verrouille les deux faces : au plus **deux fichiers de police** au
  premier écran, et chaque `@font-face` déclarant une **plage** de graisses. Une seule ligne de
  `build/fetch-fonts.mjs` suffirait à ramener les 264 Ko sans que rien ne s'affiche différemment.

---

## G27 §10 et §13 — formulaire de devis, captures ciblées (20 août 2026)

Rapport complet : `docs/RAPPORT-G27-FORMULAIRE-CAPTURES.md`.
Détail des écarts du formulaire : `docs/FORMULAIRE-DIFFERENCES.md`, restructuré en trois sections
— écarts fonctionnels obligatoires (§2), défauts purement visuels corrigés (§4), contenus de la
maquette délibérément non repris (§5). La clé de lecture est en tête du fichier : confondre les
deux natures d'écart conduit soit à retirer un jeton de sécurité pour gagner une mesure, soit à
laisser passer un défaut en le déclarant fonctionnel.

### Formulaire de devis — corps à 100 % de la maquette

Hauteur du corps du formulaire, du haut du premier champ au bas de la dernière commande :
**876,9 px contre 879,7 à 375 px**, **596,9 contre 599,7 à 1 440**. Les huit champs de l'étape 1
sont appariés un à un, corps, rembourrage et rayon identiques.

Rien de fonctionnel n'a bougé : jeton, piège à robots (mesuré hors flux à `x = -10 017`),
validation client et serveur, consentement, contexte visiteur, UTM, anti-double-soumission,
confirmation après succès réel.

Quatre causes, toutes de même nature — une valeur relevée que rien n'appliquait :

1. **Deux jeux de règles concurrents** sur les mêmes champs. Le second venait d'un relevé du seul
   formulaire de contact ; or la maquette applique la **même** géométrie aux deux formulaires
   (49 px pour une saisie, 51 pour une liste, 112 pour une zone de texte — mesuré sur `#/contact`
   comme sur `#/demande-de-devis`). Un seul jeu subsiste.
2. **La normalisation de base était trop spécifique** : `body.tfp-body select` (0,1,2) battait
   `.tfp-field select` (0,1,1). Aucune correction dans le composant ne pouvait aboutir tant que
   cette règle restait écrite ainsi. Une normalisation n'a pas à être spécifique.
3. **`min-height: max(44px, 60px)` sur le bouton** annulait tout rembourrage posé. Le correctif
   passe par les variables du composant et reste confiné au formulaire — les boutons du hero sont
   déjà conformes (60 px contre 61).
4. **L'indicateur d'étape et le résumé de l'étape 1 n'existaient pas.** Le premier remplace un
   titre de 20 px en gras et reste dans le `<legend>` ; le second est rempli depuis les champs
   eux-mêmes et reste masqué sans JavaScript.

Et une correction qui déborde du formulaire : **les étoiles étaient en cuivre**. Le prototype les
écrit en `#EAB308` dans ses vingt-quatre occurrences, sans exception. Corrigé pour toutes les
cartes témoignage du site.

### Captures ciblées — trois pièges de méthode

`tools/captures-ciblees.mjs`, quatorze planches, récapitulatif dans `docs/CAPTURES-CIBLEES.md`.
Trois précautions, chacune découverte parce qu'elle produisait un chiffre faux :

1. **La zone comparable du formulaire n'est pas la balise `<form>`** : la maquette place
   l'indicateur d'étape avant, le thème le met dedans. Découper les deux `<form>` affichait 66 %
   d'écart là où les deux rendus se superposent.
2. **Remplir `[required]` ne suffit pas à passer à l'étape 2** : la maquette marque ses champs en
   `aria-required`. La planche comparait une étape 1 en erreur à une étape 2.
3. **Un titre réservé aux lecteurs d'écran ne compte pas dans l'ordre des bandes** : 1 px de haut,
   il faisait déclarer « ordre différent » sur des pages identiques.

### Ce que les captures ont trouvé

**Corrigé** — la bande « Nos six prestations » du pilier sortait à **90 %** (506,8 px contre
560,3). Le prototype déclare `max-width: 620px` sur ce titre, ce qui le replie sur deux lignes ; le
thème le laissait occuper les 1 180 px de la colonne. **Huit autres titres de la maquette portent
une largeur maximale déclarée**, de 520 à 720 px, et aucun relevé ne la capturait. Le champ
`titre_largeur_max` existe désormais dans `tools/generate-pages.mjs` et `tfp_bloc_titre()`
l'applique. La bande passe à **98 %**.

**Relevés, non corrigés** — deux défauts réels et mesurés, laissés à la passe suivante :

- `/avis-clients/`, témoignage mis en avant : **carte marine** `#10263B` texte blanc citation 19 px
  dans la maquette, **carte blanche** citation 25 px dans le thème — 228 px contre 300 à 320 px de
  large ;
- `/bourgogne-franche-comte/`, H1 : la maquette déclare `clamp(30px, 4.2vw, 52px)` soit **52 px** à
  1 440 ; la page est classée `tfp-type-zone` et hérite de l'échelle des villes, **49 px**.

Le reste de la page région est en revanche **superposable** : seize titres, mêmes tailles, mêmes
largeurs, mêmes nombres de lignes, et l'exemple tarifaire donne 333 € HT/mois des deux côtés. Les
37,6 % de pixels colorés de la planche viennent du décalage vertical des blocs de note masqués. La
planche seule laissait croire à plusieurs replis différents — c'est la mesure qui a tranché.

### Verdict

**PARTIEL — ÉCARTS RESTANTS**, inchangé. Les quatre points bloquants ne dépendent pas du code :
URL de la fiche Google Business à fournir **et à valider humainement**, nombre réel d'avis, photo
authentique d'Audrey et validation de sa citation par l'intéressée, remplacement des témoignages
provisoires.
