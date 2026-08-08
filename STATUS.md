# STATUS — Top-Famille Pro

> Lien entre deux sessions Claude Code Web. Mis à jour à la fin de chaque phase.
> Dernière mise à jour : **Phase 6 — accessibilité, performance, recette finale**, 8 août 2026.
> `PHASE_6=PASS` (techniquement — voir `docs/RAPPORT-FINAL.md` : le site n'est **pas**
> PRODUCTION READY, Kbis non confirmé)

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

**Ces 8 pages restent noindex,follow tant qu'Audrey ne les a pas validées une par une.** Aucune
action supplémentaire n'est attendue de la phase 4 sur ce point : c'est une décision humaine, pas
un chantier technique.

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
- **8 communes secondaires** : restent `noindex,follow` tant qu'Audrey ne les a pas validées une par
  une (voir plus haut) — décision humaine attendue, aucune action technique requise.

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
