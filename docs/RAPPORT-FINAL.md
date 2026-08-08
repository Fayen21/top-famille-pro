# RAPPORT FINAL — Top-Famille Pro

> Produit en phase 6 (PROMPT-PHASES.md), à l'issue des phases 0 à 6 ; mis à jour en phase 7
> (informations légales confirmées + paquet de livraison Hostinger). Référence unique de l'état du
> projet ; `STATUS.md` reste le journal détaillé phase par phase pour qui veut le détail complet
> (bugs trouvés, procédures de vérification, décisions signalées).

---

## 1. Verdict global

**`HOSTINGER_PACKAGE=PASS`** — le code, le contenu et le paquet d'installation sont prêts. **Le
site n'est pas pour autant déployé ni opérationnel** : ce sont deux choses différentes, détaillées
ci-dessous plutôt que résumées en un seul mot.

| Aspect | État |
|---|---|
| Code et contenu (CLAUDE.md §10) | ✅ **Prêt** — les treize éléments sont réglés, y compris la donnée d'immatriculation (§15) |
| Paquet d'installation Hostinger (§17) | ✅ **Prêt**, testé de bout en bout sur WordPress vierge |
| Déploiement réel sur `top-famille-pro.fr` | ⛔ **Non effectué** — CLAUDE.md §6 interdit tout déploiement depuis cette session |
| Envoi effectif des devis (SMTP) | 🟡 **À tester sur l'hébergement réel** — aucun transport mail disponible dans les environnements de test utilisés sur l'ensemble du projet |

Le blocage identifié en phase 6 — donnée d'immatriculation non confirmée par Kbis (SIRET, capital,
APE, TVA, incohérence sur le SIREN) — **est levé en phase 7** : extrait Pappers fourni par le
client, puis complément (SIRET, code APE, TVA) confirmé directement, cohérence formelle
recontrôlée indépendamment avant intégration (détail §6 et §15).

Une note d'avis Google réelle, un portrait authentique d'Audrey, le texte exact des avis clients
réutilisables, l'assurance RC professionnelle et la validation des 8 communes secondaires restent
manquants (masqués honnêtement plutôt que remplacés par du contenu inventé — voir §13 et
`release/INFORMATIONS-MANQUANTES.md`). Aucun de ces manques ne nécessite de nouveau développement,
seulement la saisie de vraies valeurs dans des emplacements déjà prêts à les recevoir, ou une
décision du client.

---

## 2. Plateforme et architecture

WordPress, hébergement Hostinger (CLAUDE.md §3), thème enfant sur mesure `topfamillepro` sur thème
parent **GeneratePress**. Le dépôt Git versionne le thème enfant uniquement — pas le cœur
WordPress, pas les plugins, pas les uploads.

- **CPT `zone`** (26 entrées : 8 départements + 10 villes + 8 communes secondaires), un seul
  gabarit PHP (`single-zone.php`) conditionnel sur le champ ACF `niveau`, taxonomie `departement`
  associée pour la hiérarchie département → ville/commune.
- **CPT `prestation`** (6 entrées), un seul gabarit (`single-prestation.php`).
- **Champs structurés ACF**, compatibles ACF gratuit (pas de champ Repeater Pro : FAQ et listes
  via des champs Group, `includes/acf-helpers.php`) — la structure obligatoire des pages locales et
  prestations (réponse directe, exclusions réelles, matériel fourni par le client, FAQ, CTA,
  maillage) est portée par les champs, pas par du texte libre qu'un éditeur pourrait désorganiser.
- **18 pages WordPress classiques**, chacune avec son propre gabarit `page-{slug}.php` : structure
  unique à chacune, un CPT n'aurait apporté aucun bénéfice de cohérence.
- **Type `post` natif**, catégorie « Conseils », pour les 3 articles.
- Aucun page builder lourd, aucune dépendance ACF Pro (tout fonctionne sans le plugin — `tfp_get_field()`
  bascule sur `get_post_meta()` en son absence), plugins limités au strict nécessaire (aucun installé
  dans ce dépôt : SEO/JSON-LD/sitemap gérés nativement par le thème et par WordPress core).
- Contenu et balises SEO rendus **côté serveur**, aucune dépendance JavaScript pour le `title`, la
  canonical ou le contenu indexable.
- Contenu versionné via des scripts de seed PHP idempotents (`bin/seed-*.php`, exécutés via
  `wp eval-file`) : CLAUDE.md §3 interdit de versionner la base de données, ces scripts sont donc la
  source de vérité reproductible du contenu, committée comme le reste du thème.

---

## 3. Fichiers créés ou modifiés

Aperçu par catégorie plutôt qu'une liste exhaustive fichier par fichier (`git log` porte le détail
complet, un commit par étape fonctionnelle depuis la phase 1) :

| Catégorie | Emplacement | Contenu |
|---|---|---|
| Gabarits de page | `wp-content/themes/topfamillepro/*.php` (racine) | `front-page.php` + 17 `page-{slug}.php` + `single.php`, `single-zone.php`, `single-prestation.php`, `404.php` |
| Logique partagée | `includes/*.php` (22 fichiers) | CPT, ACF, SEO/JSON-LD, breadcrumbs, formulaire de devis, sitemap/robots, sécurité, etc. |
| Composants réutilisables | `template-parts/**/*.php` | Header, footer, sections de l'accueil, navigation mobile |
| Design system | `src/css/*.css` (6 fichiers sources) → `assets/dist/css/main.css` | Tokens, base, layout, composants, section accueil |
| Comportement client | `src/js/*.js` (4 fichiers) → `assets/dist/js/main.js` | Navigation, formulaire, analytics neutre |
| Contenu réel | `bin/seed-*.php` (13 scripts) + `bin/cleanup-wp-defaults.php` | Source de vérité versionnée du contenu des 53 pages |
| Tests automatisés | `tests/**/*.spec.js` (8 fichiers, dont `legal.spec.js` en phase 7) + `playwright.config.js` | 796 assertions (phase 6) + 722 rejouées en phase 7 sur une installation neuve, captures responsive |
| Documentation | `docs/*.md` | Inventaire des routes, données fictives neutralisées, maillage, redirections, ce rapport |
| Suivi de projet | `STATUS.md`, `PROJECT_INPUTS.md` | Journal détaillé phase par phase, données commerciales réelles |
| Livraison Hostinger (phase 7) | `release/*` | Thème + installateur en ZIP installables, tableau des 53 pages, guide de déploiement, informations manquantes, empreintes SHA-256 |

---

## 4. Matrice des routes

Détail complet et exhaustif dans `docs/INVENTAIRE-ROUTES.md` (source de vérité) et
`tests/data/routes.js` (version exploitée par la suite de tests). Résumé :

| Famille | Nombre | Robots |
|---|---|---|
| Pages statiques | 18 | `index,follow` |
| Prestations | 6 | `index,follow` |
| Zones — département | 8 | `index,follow` |
| Zones — ville | 10 | `index,follow` |
| Zones — commune secondaire | 8 | `noindex,follow` (non validées, CLAUDE.md §5.4) |
| Articles | 3 | `index,follow` |
| **Total pages publiques** | **53** | — |
| 404 | 1 | `noindex,follow`, vrai statut HTTP 404 |

**53/53 pages migrées**, comptage vérifié dans un WordPress réel — correspond exactement à
`docs/INVENTAIRE-ROUTES.md` (« 53 pages publiques + 1 page 404 »). Aucun fragment `#/` nulle part,
aucun `href="#"` public (vérifié par `tests/seo.spec.js` sur les 53 routes + 404).

---

## 5. Corrections SEO

- `title` unique, meta description unique, canonical absolue auto-référente, `h1` unique, Open
  Graph, Twitter Card, fil d'Ariane visible + `BreadcrumbList` JSON-LD sur toutes les pages sauf
  l'accueil (racine du fil) — vérifié par requête HTTP brute sur les 53 routes
  (`tests/uniqueness.spec.js`), aucun doublon.
- `ProfessionalService`, `WebSite`, `WebPage`, `Service` (prestations), `Article`, `FAQPage`
  (uniquement quand la FAQ est réellement visible) — JSON-LD validé structurellement (parsing +
  vérification `@context`/`@graph`) sur les 53 routes.
- **Doublon canonical/robots corrigé** (trouvé en fin de phase 1) : WordPress core hooke
  `rel_canonical()` et `wp_robots()` sur `wp_head` en plus du thème — retirés explicitement.
- **Entités HTML échappées dans le JSON-LD corrigées** (trouvé en fin de phase 1) :
  `wptexturize()` transforme une apostrophe droite en entité HTML (`&#8217;`) y compris dans les
  chaînes utilisées pour le JSON-LD, où une entité HTML n'a pas sa place — décodage explicite ajouté
  avant `wp_json_encode()`.
- **Titles raccourcis à ≤65 caractères** partout où ils dépassaient : Territoire de Belfort,
  Lons-le-Saunier, Chalon-sur-Saône, page région Bourgogne-Franche-Comté, article cahier des
  charges, et l'accueil (71c → 57c, trouvé en phase 5 par la suite de tests, seul dépassement resté
  non corrigé après la phase 3).
- **Tarif fictif « 27 € HT/h »** retiré de tout le contenu repris du prototype, remplacé par la
  grille réelle à trois montants (CLAUDE.md §5.3).
- **Sitemap XML natif WordPress** (`/wp-sitemap.xml`), découpé par type de contenu (« par famille »),
  filtré pour exclure les sitemaps `users`/`taxonomies` (hors périmètre des 53 routes) et les 8
  communes secondaires non validées (`includes/sitemap-robots.php`). `robots.txt` : WordPress core
  gère déjà correctement `Disallow: /wp-admin/` et la ligne `Sitemap:`, rien à ajouter côté thème.

---

## 6. Corrections GEO (données factuelles et locales)

- **Un seul établissement.** Aucune adresse locale, aucun numéro local, aucun horaire local, aucun
  `LocalBusiness` secondaire sur les 24 pages de zone — l'entreprise a un seul site, à
  Saint-Apollinaire (CLAUDE.md §5.2), vérifié dans le JSON-LD et le contenu de chaque page.
- **Tarifs identiques dans toute la région** — le prototype affichait des blocs tarifaires
  différenciés par ville (faux) ; corrigé sur les 24 pages de zone migrées, la grille
  `PROJECT_INPUTS.md` §5 s'applique à l'identique partout, la différenciation porte sur le tissu
  économique du secteur et la FAQ, jamais sur le prix.
- **Aucune commune non validée présentée comme desservie.** Au-delà de la simple omission d'un
  champ, une régression plus grave a été trouvée en phase 3 : la FAQ de chaque ville du prototype
  répondait « Oui » à « Intervenez-vous à [commune non validée] ? » — une affirmation positive de
  couverture, pas une simple mention. Corrigée sur les 9 villes concernées par une réponse honnête
  au cas par cas, sans nommer ni confirmer de commune précise.
- **8 communes secondaires créées mais non indexables** (`noindex,follow`) tant qu'Audrey ne les a
  pas validées une par une — CLAUDE.md §5.4, aucune ne figure sur une source confirmée. Exclues du
  sitemap XML (§5) en plus du `noindex` en meta.
- **Aucune distance ni temps de trajet chiffré non sourcé** repris du prototype (qui en affirmait
  par endroits, sans source).
- **Erreur de conflation corrigée** (trouvée et documentée en phase 3, `STATUS.md` §7) : une liste
  de 8 communes notée en fin de phase 2 comme « les communes secondaires du prototype » provenait en
  réalité d'un champ différent (les villages de la première couronne dijonnaise). La liste correcte,
  revérifiée directement dans les routes du prototype, a été utilisée pour les 8 pages réellement
  créées.

---

## 7. Corrections de maillage interne

Détail complet et matrice avant/après dans `docs/MAILLAGE.md`. Résumé des manques trouvés et
corrigés en phase 4 :

- `villes_prioritaires` sur les 6 prestations : champ existant depuis la phase 2, gabarit déjà prêt
  à l'afficher, mais jamais renseigné par aucun script de seed — la section « Disponible dans ces
  villes » était silencieusement absente sur les 6 pages prestation depuis le début.
- `/tarifs/` → 6 prestations (absent), page région → 8 départements (absent), département → page
  région (lien contextuel ajouté en plus de la navigation globale).
- Articles ↔ prestations : aucun mécanisme de relation n'existait. Nouveau champ postmeta
  multi-lignes `_tfp_related_prestation`, rendu dans les deux sens.
- CTA « Demander mon devis » des pages prestation/zone : transmettent désormais leur contexte
  (`?service=&ville=&departement=`) au formulaire de devis, qui le pré-remplit.
- Aucune page orpheline : 3 clics maximum depuis l'accueil, fil d'Ariane sur toutes les pages sauf
  l'accueil — reconfirmé par un crawl interne réel en phase 5 (`tests/crawl.spec.js`), pas seulement
  une relecture de code.

---

## 8. Optimisations de conversion

- CTA hiérarchisés partout : principal « Demander mon devis », secondaire « Appeler Audrey »,
  contextuel « Demander un devis à {ville} » sur les pages de zone.
- Réassurance (Gratuit · Sans engagement · Réponse sous 24 h) près du CTA, sans jamais répéter une
  fausse note ou un faux avis.
- Point d'entrée tarifaire affiché : à partir de 24,30 € HT/h, cohérent partout.
- **Formulaire de devis réellement fonctionnel**, deux étapes conformes à CLAUDE.md §8 : type de
  locaux, régime, ville, code postal, surface, nom, téléphone/e-mail (étape 1) ; entreprise,
  fréquence, créneau, message, consentement RGPD (étape 2). Contexte visiteur capturé automatiquement
  (page d'origine, référent, UTM) et pré-rempli depuis les pages locales/prestations. Validation
  client **et** serveur (téléphone **ou** e-mail requis, pas les deux ; e-mail vérifié s'il est
  fourni), honeypot, limitation à 5 soumissions/heure par IP, messages d'erreur accessibles
  (`aria-live`), consentement RGPD obligatoire. Confirmation affichée uniquement après succès serveur
  réel, jamais simulée côté client — état de confirmation en `noindex,follow`.
- Analytics neutre (`window.dataLayer`, `src/js/analytics.js`) pour 8 événements
  (`quote_start`, `quote_step_1_complete`, `quote_submit`, `quote_success`, `quote_error`,
  `phone_click`, `email_click`, `local_cta_click`) — aucun outil de tracking installé (CLAUDE.md §6),
  prêt à être lu par un outil futur une fois choisi et configuré avec consentement.

---

## 9. Corrections responsive

- **Débordement horizontal à 320px, header** (phase 1) : CTA en `nowrap` ne rétrécissait pas ;
  corrigé en le masquant sous 820px (la barre CTA mobile fixe fait déjà ce travail).
- **Débordement horizontal à 320px, CTA à libellé dynamique** (« Demander un devis en Côte-d'Or »,
  phase 2/3) : `white-space: nowrap` global cassait sur les libellés longs ; corrigé par une règle
  `@media (max-width: 479px)`.
- **Cible tactile insuffisante sur le fil d'Ariane** (WCAG 2.5.8, phase 1) : padding et hauteur
  minimale ajoutés, `row-gap` sur les lignes qui se replient.
- **Débordement horizontal à 320px sur `/demande-de-devis/`** (phase 6, trouvé par la suite de
  tests) : `<fieldset>` a un `min-width: min-content` implicite dans les navigateurs qui ignore la
  largeur du conteneur parent — correctif global `fieldset { min-width: 0; }`.
- **Captures automatiques aux 12 largeurs demandées** (320×568 à 1920×1080), une page par famille +
  contrôles particuliers (villes à nom long, formulaire aux 3 états, clavier mobile, footer, tarifs) —
  81 captures dans `.screenshots/` (gitignoré), sélection commitée dans `docs/captures/`.
- **Aucun débordement horizontal résiduel**, vérifié sur les 53 routes à 375px (`tests/seo.spec.js`)
  et sur un balayage de 17 pages statiques/hub à 320px/1440px.

---

## 10. Résultats d'accessibilité

**axe-core (WCAG 2A/2AA/2.2AA + best-practice) : 0 violation** sur une page de chaque famille
(statique, prestation, département, ville, commune, article) **et** le formulaire de devis, testé
séparément parce qu'aucune des familles génériques ne le couvrait.

Interactions clavier réelles vérifiées (pas seulement un scan automatisé) :
- Menu mobile (drawer) : ouverture au clavier, piège de focus dans les deux sens, Échap ferme et
  restitue le focus au bouton d'ouverture.
- Sous-menu mobile en accordéon : ouverture/fermeture au clavier (Entrée).
- Sous-menus desktop : ouverture au clavier, Échap referme et restitue le focus.
- Barre CTA mobile fixe : boutons atteignables au clavier, cibles tactiles ≥44px vérifiées
  individuellement.
- Formulaire de devis : ordre de tabulation logique à l'étape 1, focus jamais perdu hors du
  formulaire.

**Deux bugs réels trouvés et corrigés par cet audit** (pas seulement documentés) :
1. **Piège de focus cassé** dès qu'un sous-menu accordéon du drawer mobile est replié :
   `querySelectorAll()` matchait aussi les liens masqués (`display:none` via `[hidden]`), sur
   lesquels `.focus()` échoue silencieusement — `Tab`/`Shift+Tab` pouvaient faire sortir le focus du
   panneau. Corrigé par un filtre `offsetParent !== null` (`src/js/nav.js`).
2. **Heading-order invalide sur `/demande-de-devis/`** (hors état de succès) : aucun `<h2>` entre le
   `<h1>` et le premier `<h3>` du pied de page. Trouvé par Lighthouse, pas par ma propre suite
   (l'échantillon par famille n'incluait pas cette page précise) — corrigé par un `<h2>`
   visually-hidden, et la page ajoutée explicitement à l'audit pour que ça ne se reproduise pas.

Un défaut de contraste (fond du numéro de département, phase 1) et une cible tactile insuffisante
(fil d'Ariane, phase 1) avaient déjà été trouvés et corrigés plus tôt (§9).

---

## 11. Résultats de performance, chiffrés

Lighthouse mobile réel (`--throttling-method=simulate`), contre le rig de test local (PHP intégré,
sans cache LiteSpeed, sans HTTP/2, sans compression — confirmé : aucun en-tête `Content-Encoding` sur
les réponses). Chiffres réels, non arrondis en faveur du projet :

| Page | Performance | Accessibilité | Bonnes pratiques | SEO | LCP | CLS | TBT |
|---|---|---|---|---|---|---|---|
| Accueil (`/`) | **91** | 100 | 100 | 100 | 3,0 s | 0,026 | 0 ms |
| Prestation (`/prestations/bureaux/`) | **97** | 100 | 100 | 100 | 2,2 s | 0,002 | 0 ms |
| Zone (`/zones-intervention/cote-dor/dijon/`) | **97** | 100 | 100 | 100 | 2,2 s | 0,013 | 0 ms |
| Devis (`/demande-de-devis/`) | **97** | 100 | 100 | 100 | 2,3 s | 0,02 | 0 ms |

Cibles CLAUDE.md §8 : LCP ≤2,5s · INP ≤200ms · CLS ≤0,1 · Performance ≥90 · Accessibilité/Bonnes
pratiques/SEO ≥95. **Atteintes ou dépassées sur 3 pages sur 4** ; l'accueil reste à 3,0s de LCP (la
page la plus lourde du site, hero + plus d'images que les gabarits internes) au lieu de 2,5s, avec
une Performance de 91 qui atteint néanmoins la cible.

Deux corrections réelles apportées pendant cette mesure (pas seulement des chiffres pris tels quels) :
- **CSS non bloquant** : `<link rel="stylesheet">` remplacé par un chargement `preload` + bascule au
  chargement (technique standard, `includes/enqueue.php`), `<noscript>` en repli. Résout l'audit
  render-blocking de Lighthouse (score 0 → 1 sur l'accueil).
- **Logo mal dimensionné** : les attributs `width`/`height` HTML (180×36, ratio 5:1) ne
  correspondaient pas au fichier réel (759×402, ratio ~1,89:1) — l'image est affichée à hauteur fixe
  36px partout, donc réellement ~68px de large, jamais 180px. Fichier généré réduit de 360px à 140px
  (2× la taille d'affichage réelle) : 11,9 Ko → 3,1 Ko. A fait passer Bonnes pratiques de 96 à 100.

**Limite honnête de cette mesure** : CLAUDE.md le dit lui-même — « sur mutualisé Hostinger, les
cibles Lighthouse ne s'atteignent pas sans [cache LiteSpeed] ». Ce rig ne peut reproduire ni le
cache LiteSpeed, ni la compression gzip/brotli, ni HTTP/2, ni un CDN. Les chiffres ci-dessus sont
donc un plancher, pas une prévision de production : la configuration du cache LiteSpeed (CLAUDE.md
§3) reste une étape obligatoire au déploiement, pas optionnelle, et une nouvelle mesure Lighthouse
en conditions réelles après déploiement est nécessaire pour confirmer les cibles — ce rapport ne
peut pas s'y substituer.

---

## 12. Résultats des tests automatisés

Suite Playwright complète (`tests/`, phase 5 + audit phase 6), exécutée contre le rig local :

| Suite | Couverture | Résultat |
|---|---|---|
| `tests/seo.spec.js` + `tests/uniqueness.spec.js` | 53 routes + 404 : statut HTTP, h1 unique, title/meta/canonical/robots, JSON-LD valide, aucun `href="#"` ni `#/`, aucune donnée fictive résiduelle, aucun alt mensonger, aucune erreur JS, aucun débordement horizontal, title/canonical uniques | ✅ |
| `tests/crawl.spec.js` | Crawl interne réel depuis l'accueil : aucun lien mort, aucune page orpheline | ✅ |
| `tests/functional/quote-form.spec.js` | 11 scénarios : soumission valide (téléphone/e-mail), rejets serveur, consentement, honeypot, contexte local, navigation clavier | ✅ |
| `tests/accessibility.spec.js` | axe-core (6 familles + devis) + 5 scénarios clavier réels | ✅ |
| `tests/screenshots.spec.js` | 81 captures, 12 largeurs × 6 familles + contrôles particuliers | ✅ |
| **Total** | — | **796 assertions, 0 échec** après corrections |
| `npm run test` (lint PHP + build) | 71 fichiers PHP | ✅ |

---

## 13. Données fictives supprimées ou masquées

| Élément | Sort |
|---|---|
| ~40 avis de démonstration (`demo: true`) | Aucun repris sur aucune page. Un seul avis authentique s'affiche si renseigné dans la page d'options ACF « Réassurance & avis », sinon un bloc neutre « à venir ». |
| Note 5,0/5 + compteur « 47 avis » + lien Google `#` | Masqués tant que l'URL réelle, la note et le nombre d'avis ne sont pas fournis — jamais de lien `#` public affiché. |
| Portrait de stock présenté comme Audrey | Remplacé par une pastille neutre (initiale + « Photo à venir ») — décision volontaire signalée en phase 1, écart visuel assumé plutôt qu'un `alt` honnête sur une photo qui resterait trompeuse au premier regard. |
| `alt` des photos de stock (hero, prestations, articles) | Tous réécrits avec « (photo d'illustration) », aucun ne prétend montrer un lieu ou une personne réelle. |
| Tarif unique fictif « 27 € HT/h » | Retiré partout, remplacé par la grille réelle à trois montants (24,30 € / 26,00 € / 30,00 € HT/h). |
| Blocs tarifaires différenciés par ville | Retirés — la grille est identique dans toute la région (CLAUDE.md §5.3). |
| 8 communes secondaires non confirmées | Créées mais `noindex,follow` + exclues du sitemap, jamais présentées comme desservies avec certitude. |
| « Top-Entreprise » (ancienne marque) | Supprimée de tout le contenu public. Seule exception légitime : la raison sociale réelle « SARL TOP-ENTREPRISE » (CLAUDE.md §1), affichée dans le pied de page et les mentions légales — ce n'est pas la même chose que la marque à supprimer, et la suite de tests le vérifie explicitement (distinction faite dans `tests/seo.spec.js`, après avoir découvert que sa propre première version ne la détectait pas correctement). |
| Citation à la première personne attribuée à Audrey (prototype) | Non reprise ; remplacée par un texte descriptif à la troisième personne. |
| JSON-LD : note agrégée, avis, coordonnées géographiques, horaires inventés | Aucun — uniquement les champs confirmés dans `PROJECT_INPUTS.md`. Aucune donnée d'immatriculation dans le JSON-LD tant que le Kbis ne l'a pas confirmée. |
| Contenu par défaut WordPress (« Hello world! », « Sample Page ») | Trouvé publié et indexable en vérifiant le sitemap (phase 6) — mis à la corbeille (`bin/cleanup-wp-defaults.php`), idempotent, à relancer une fois après l'installation WordPress réelle. |

---

## 14. Informations client encore manquantes

Reprises de `PROJECT_INPUTS.md` §12 (« Questions ouvertes »), toujours d'actualité :

| # | Donnée | Bloque |
|---|---|---|
| 1 | ~~Kbis : SIRET exact, capital, APE, TVA, date d'immatriculation — incohérence sur le SIREN à lever~~ | **Résolu phase 7** — voir §6 |
| 2 | Assureur RC professionnelle (nom + n° de police) | **Mise en ligne** |
| 6 | URL de la fiche Google Business + note réelle + nombre d'avis réels | **Mise en ligne** |
| 7 | Portrait HD d'Audrey + visuels réels | **Mise en ligne** |
| 3 | Confirmation que les tarifs relevés sont toujours à jour | Souhaitable avant mise en ligne |
| 4 | Adresse de réception des demandes de devis (le code envoie réellement via `wp_mail()`, jamais testé bout en bout faute de transport mail dans ce bac à sable) | À vérifier au déploiement |
| 5 | E-mails en `@top-famille-pro.fr` ou maintien de `@top-famille.fr` ? | Souhaitable avant mise en ligne |
| 8 | Validation une par une des 8 communes secondaires | Reste `noindex,follow` sans réponse |
| 9 | Que devient `topentreprise.fr` (redirection ou abandon) ? | Plan prêt (`docs/REDIRECTIONS.md`), pas appliqué |
| 10 | Inventaire des articles du blog actuel, pour les redirections manquantes | Redirections d'articles impossibles sans ça |
| 12 | Accès hPanel / SFTP / base de données ; `top-famille-pro.fr` déposé et pointé ? | Nécessaire pour déployer |

Également, `PROJECT_INPUTS.md` §11 (RGPD) : durée de conservation des demandes de devis, contact
référent RGPD, liste des sous-traitants à mentionner (Hostinger, service d'envoi d'e-mails,
werecruit, éventuel outil d'analytics une fois choisi) — la page « données personnelles » de
l'ancien site n'a jamais été relevée, la nouvelle a été écrite à partir des données réelles
disponibles, pas recopiée.

---

## 15. Bloqueurs de publication

Selon CLAUDE.md §10, ne jamais déclarer PRODUCTION READY s'il subsiste :

| Élément interdit | État |
|---|---|
| Un avis fictif | ✅ Aucun — supprimés (§13) |
| Une note fictive | ✅ Aucune — masquée tant que la vraie n'est pas fournie |
| Un faux portrait | ✅ Aucun — pastille neutre |
| Un `alt` mensonger | ✅ Aucun trouvé (`tests/seo.spec.js`, 53 routes) |
| Une commune non validée en `index` | ✅ Les 8 restent `noindex,follow` |
| Un tarif différencié par ville | ✅ Grille unique partout |
| Un formulaire simulé | ✅ Envoi réel par `wp_mail()`, confirmation uniquement après succès serveur |
| Une route en `#/` | ✅ Aucune (vérifié sur les 53 routes) |
| Un lien mort | ✅ Aucun (crawl interne réel, `tests/crawl.spec.js`) |
| Une page orpheline | ✅ Aucune (même crawl) |
| Une donnée d'immatriculation non confirmée par Kbis | ✅ **Résolu phase 7** — SIRET, capital, APE, TVA, SIREN confirmés (§6), cohérence formelle recontrôlée indépendamment |
| Une erreur JavaScript | ✅ Aucune (53 routes, `tests/seo.spec.js`) |
| Un débordement horizontal | ✅ Aucun (53 routes à 375px + balayage 320/1440px) |
| Un test en échec | ✅ 796 assertions vertes en phase 6, 722 rejouées en phase 7 sur une installation neuve à partir des deux ZIP de livraison (§17) |

**Les treize éléments de CLAUDE.md §10 sont désormais réglés.** Cela ne rend pas le site
opérationnel pour autant : voir la distinction du §1 entre code prêt, paquet prêt, et déploiement
réel non effectué. Les manques restants du §14 (assurance RC pro, fiche Google, portrait, avis,
adresse e-mail, validation des communes, devenir de topentreprise.fr) ne sont pas des bloqueurs au
sens strict de CLAUDE.md §10, mais restent des informations réelles manquantes qui limitent ce que
le site peut afficher tant qu'elles ne sont pas fournies — le site reste honnête (masqué plutôt
qu'inventé) en attendant.

---

## 16. Phase 7 — Informations légales confirmées

Extrait Pappers fourni par le client, confirmant : dénomination sociale **TOP-ENTREPRISE**, SARL,
SIREN **938 472 420**, immatriculation **938 472 420 R.C.S. Dijon**, capital **600,00 €**, date
d'immatriculation **16/12/2024**, siège **RTE de Gray 650D, 21850 Saint-Apollinaire**, activité
principale **nettoyage de locaux professionnels et nettoyage courant des bâtiments**, date de
commencement d'activité **01/01/2025**, gérante **Audrey Brançon** (nom d'usage — nom de naissance
confirmé par Pappers, non publié : information personnelle non nécessaire à la mention légale).
Complément transmis ensuite : **SIRET 938 472 420 00018**, **code APE 81.21Z** (Nettoyage courant
des bâtiments), **TVA intracommunautaire FR32 938 472 420**.

**Cohérence formelle recontrôlée indépendamment avant intégration** (pas seulement reprise telle
quelle) : la clé Luhn du SIRET à 14 chiffres est valide (somme des chiffres pondérés ≡ 0 mod 10) ;
la clé de contrôle TVA calculée à partir du SIREN — `(12 + 3 × (SIREN mod 97)) mod 97` — donne 32,
identique à la clé transmise (`FR32…`). Aucune anomalie trouvée.

**L'incohérence relevée en phase 0 est levée** : les mentions légales de l'ancien site
(topentreprise.fr) annonçaient un SIREN différent (938 472 242) — non conforme, déjà identifié
comme tel, jamais republié sur le nouveau site.

Formulation légale complète, utilisée telle quelle sur la page mentions légales :
> TOP-ENTREPRISE, SARL au capital de 600 €, immatriculée au RCS de Dijon sous le numéro
> 938 472 420, SIRET 938 472 420 00018, code APE 81.21Z, TVA intracommunautaire
> FR32938472420, siège social : RTE de Gray 650D, 21850 Saint-Apollinaire.

Diffusion volontairement limitée : le détail complet ci-dessus figure sur `/mentions-legales/`
uniquement ; le pied de page (les 53 pages) n'affiche qu'une forme concise (raison sociale, capital,
SIRET, lien vers les mentions légales) ; les données structurées `Organization` reçoivent
`taxID`/`vatID`/`foundingDate` (propriétés schema.org appropriées) mais pas de code APE, faute de
propriété schema.org adaptée — ne pas forcer une donnée dans un champ qui ne lui correspond pas.

Ce qui reste `[À COMPLÉTER]` sur la page mentions légales, à l'identique d'avant cette phase :
assurance RC professionnelle (nom + n° de police), coordonnées complètes de l'hébergeur, directrice
de la publication (hypothèse non confirmée explicitement — probablement la gérante, mais CLAUDE.md
§5.1 interdit de publier une valeur plausible non confirmée).

---

## 17. Livraison Hostinger (phase 7)

### Pull request

`Phase 7 — informations légales et livraison Hostinger` : **[PR_URL_A_COMPLETER]**

### Les trois ZIP

Liens de téléchargement (branche `phase-7-livraison-hostinger`, dossier `release/`) — utiliser les
liens « Raw » de GitHub pour un téléchargement direct du binaire :

| Fichier | Taille | SHA-256 |
|---|---|---|
| `topfamillepro-theme.zip` | 1,8 Mo (1 860 118 octets) | `ee8b5e2d1a03e899992789a4b7d78234c94563f2a5fce504ead1df5d02cd5409` |
| `topfamillepro-content-installer.zip` | 56 Ko (56 536 octets) | `786fc3a463821ff2d78a98e45618ec9a2b65ba0fa65b425d8871fac1d7a7cd75` |
| `Top-Famille-Pro-Livraison-Hostinger.zip` (paquet global, contient les deux ci-dessus + guides) | 1,9 Mo (1 935 046 octets) | `80432c3171a2874a8b05b647fe1daf0dd214604bb5f7d6a378ec2bd60ec07517` |

Empreintes également disponibles dans `release/SHA256SUMS.txt` (les deux ZIP installables
uniquement, comme demandé). À vérifier après téléchargement : `sha256sum <fichier>` doit
correspondre exactement.

### Résultats des tests d'installation

Sur WordPress vierge (miroir GitHub du cœur WordPress, aucun accès réseau à wordpress.org depuis
cet environnement — GeneratePress et ACF simulés par des stubs minimaux reproduisant leur contrat
d'intégration ; **à revérifier avec les vrais plugins une fois sur Hostinger**, où l'accès réseau
n'est pas restreint) :

| Test | Résultat |
|---|---|
| Thème : activation, dépendance GeneratePress, chargement CSS/JS | ✅ Aucune erreur PHP |
| Thème : fonctionnement avec ACF (stub) | ✅ Contenu réel affiché (`get_field`/`update_field`) |
| Thème : fonctionnement sans ACF (repli natif) | ✅ Aucune erreur, pages toujours servies |
| Thème : aucun chemin de développement en dur | ✅ Recherche `/home/user`, `/tmp/*` : aucune occurrence |
| Installateur : premier passage (WordPress vierge) | ✅ 11/11 étapes, 0 erreur |
| Installateur : idempotence (deuxième passage) | ✅ Delta +0 sur page/prestation/zone/post |
| Installateur : après modification manuelle | ✅ Champ géré resynchronisé (documenté), donnée non gérée préservée, contenu hors périmètre intact |
| Installateur : sécurité | ✅ Non authentifié → redirection connexion ; nonce invalide → rejeté, aucune écriture |
| Suite complète sur l'installation obtenue | ✅ **722 assertions vertes** (`seo`, `uniqueness`, `crawl`, `legal`, `functional/quote-form`, `accessibility`) |

### Contenus créés (dernière exécution de test)

52 contenus gérés par l'installateur, comptage exact avant/après (delta net, upsert par slug) :

| Type | Nombre |
|---|---|
| Pages WordPress | 17 |
| Prestations | 6 |
| Zones (8 départements + 10 villes + 8 communes) | 26 |
| Articles | 3 |
| **Total** | **52** (+ la page d'accueil, automatique, aucune page WordPress requise = 53 routes publiques) |

### Informations juridiques intégrées

Dénomination, forme juridique, capital, SIREN, SIRET, RCS, date d'immatriculation, code APE, TVA
intracommunautaire, siège social, activité — détail complet §16. Aucune information personnelle
inutile (nom de naissance, date de naissance de la gérante) publiée.

### Informations encore manquantes

Détail complet et à jour dans `release/INFORMATIONS-MANQUANTES.md` : assurance RC professionnelle,
URL/note/nombre d'avis Google Business, texte exact des témoignages autorisés, portrait réel
d'Audrey, adresse de réception des devis à confirmer, choix `@top-famille-pro.fr` vs
`@top-famille.fr`, validation des 8 communes secondaires, décision sur `topentreprise.fr`.

### Procédure de fusion et de déploiement

Fusion des PR #5/#6/#7 : voir §16 de `STATUS.md` (méthode, ordre, vérifications). Déploiement réel :
`release/GUIDE-DEPLOIEMENT-HOSTINGER.md`, 24 étapes pour un utilisateur non développeur + procédure
alternative par gestionnaire de fichiers. Aucun déploiement effectué depuis cette session
(CLAUDE.md §6).

### Verdict

**`HOSTINGER_PACKAGE=PASS`.** Le paquet est prêt, testé de bout en bout, installable sans terminal.
Cela ne constitue pas une déclaration de mise en ligne réelle : voir §1.

---

## 18. Étapes exactes pour lancer et prévisualiser le site

### Préviabilité locale (ce qui a servi à toutes les vérifications de ce rapport)

Aucun MySQL ni Docker fonctionnel n'était disponible dans l'environnement de développement, et
`wordpress.org` est hors de portée réseau (politique de l'environnement) — le rig ci-dessous n'est
**pas** à committer, entièrement hors du dépôt :

```bash
# Cœur WordPress (miroir GitHub, wordpress.org étant inaccessible depuis ce bac à sable)
git clone --depth 1 https://github.com/WordPress/WordPress.git wp-core

# Drop-in SQLite (base de données sans MySQL)
git clone --depth 1 https://github.com/aaemnnosttv/wp-sqlite-db.git sqlite-simple
cp sqlite-simple/src/db.php wp-core/wp-content/db.php
mkdir -p wp-core/wp-content/database

# wp-cli
curl -sSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o wp-cli.phar

# Installation + thème enfant lié au vrai dossier du dépôt
php wp-cli.phar core install --url=http://localhost:8899 --title="Test" \
  --admin_user=admin --admin_password=admin --admin_email=test@example.com --skip-email --allow-root
ln -s /chemin/vers/ce/depot/wp-content/themes/topfamillepro wp-core/wp-content/themes/topfamillepro
php wp-cli.phar theme activate topfamillepro --allow-root

# Contenu réel : rejoue tous les scripts de seed dans l'ordre
for f in bin/seed-phase2-content.php bin/seed-phase3-batch*.php bin/seed-phase4-maillage.php; do
  php wp-cli.phar eval-file "$f" --allow-root
done
php wp-cli.phar eval-file bin/cleanup-wp-defaults.php --allow-root

php -S localhost:8899
```

Puis, depuis le dépôt : `npm ci && npm run build` (CSS/JS), et `TFP_BASE_URL=http://localhost:8899
npx playwright test` pour rejouer toute la suite de vérification de ce rapport.

**Sur un WordPress réel (MySQL, vrai GeneratePress, ACF actif si installé)** : la même procédure,
sans le drop-in SQLite ni le stub GeneratePress — `wp core install` standard, thème enfant copié ou
symlinké, scripts de seed rejoués à l'identique.

### Déploiement réel (Hostinger, CLAUDE.md §3)

1. Accès hPanel/SFTP confirmés (§14, question 12), `top-famille-pro.fr` déposé et pointé vers
   l'hébergement.
2. Installer WordPress via hPanel (ou manuellement), thème parent **GeneratePress** installé
   normalement, thème enfant `wp-content/themes/topfamillepro/` déployé depuis ce dépôt (export du
   contenu du dossier, pas un clone Git complet sur la prod).
3. Installer et activer **ACF** (gratuit suffit — aucun champ du thème ne dépend d'ACF Pro) si
   souhaité pour l'édition depuis l'admin ; le thème fonctionne aussi sans, via `get_post_meta()`.
4. `assets/dist/` (CSS/JS compilés, polices, images optimisées) est committé dans ce dépôt — pas
   besoin de builder avant un déploiement simple, copier le thème tel quel suffit. Si le contenu
   source (`src/`, `assets/photos/`, `assets/logo/`) change après déploiement, relancer
   `npm ci && npm run build` et redéployer `assets/dist/` à jour.
5. Rejouer les scripts de seed dans l'ordre chronologique via WP-CLI (`wp eval-file bin/seed-*.php`),
   puis `bin/cleanup-wp-defaults.php`.
6. Configurer `wp-config.php` : `DISALLOW_FILE_EDIT`, éventuelle limitation des tentatives de
   connexion (CLAUDE.md §9, `STATUS.md` §9).
7. **Configurer le cache LiteSpeed explicitement** (CLAUDE.md §3, §11 de ce rapport) — sans cela,
   les cibles de performance ne seront pas atteintes sur mutualisé Hostinger.
8. Saisir les valeurs réelles dès qu'elles sont fournies : page d'options ACF « Réassurance & avis »
   (note, nombre d'avis, URL Google, témoignages), Customizer (portrait d'Audrey), mentions légales
   (SIRET/capital/APE/TVA après confirmation Kbis).
9. Une fois en ligne : nouvelle mesure Lighthouse en conditions réelles (§11), puis décision sur
   `topentreprise.fr` et application du plan de redirections (`docs/REDIRECTIONS.md`) si retenu.
10. Ne déclarer le site PRODUCTION READY qu'après confirmation Kbis (§15).
