# STATUS — Top-Famille Pro

> Lien entre deux sessions Claude Code Web. Mis à jour à la fin de chaque phase.
> Dernière mise à jour : **Phase 1 — Fondations techniques et accueil**, 7 août 2026.

---

## 1. Où en est le projet

Phase 0 et Phase 1 terminées. Le dépôt contient un thème enfant WordPress fonctionnel
(`wp-content/themes/topfamillepro/`) avec une page d'accueil complète, fidèle au prototype et
corrigée selon les règles de CLAUDE.md, vérifiée dans un WordPress réel (voir §11).

**Prochaine étape : Phase 2 — Gabarits par famille de pages**, sur une nouvelle branche dédiée
(`phase-2-gabarits` ou nom équivalent selon la convention CLAUDE.md §7), une fois cette PR revue.
Cette session s'est arrêtée strictement à l'accueil, comme demandé — aucun gabarit de prestation,
zone ou article n'a été construit.

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

## 7. Prochaine étape (phase 2) — ce qui reste à faire

- Créer les 26 entrées `zone` et 6 entrées `prestation` réelles (contenu repris du prototype,
  corrigé selon CLAUDE.md §9), avec leurs champs ACF renseignés.
- Construire les gabarits définitifs par famille (statique, prestation, département, ville/commune,
  article) et les règles de réécriture imbriquées pour les zones.
- Câbler `page.php`/`single.php` définitifs (actuellement des filets de sécurité `noindex`).
- Créer les 18 pages WordPress classiques (accueil exclu, déjà fait).
- Passer les communes secondaires non validées en `noindex,follow` via le champ ACF
  `statut_validation` déjà prévu dans `acf-fields-zone.php`.

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

### Phase 3
- Confirmation que les tarifs relevés sont toujours à jour.
- Validation une par une des 8 communes secondaires du prototype.

### Phase 4 / 6
- Adresse de réception des demandes de devis + SMTP Hostinger (phase 4).
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
