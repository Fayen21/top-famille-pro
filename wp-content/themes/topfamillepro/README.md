# Thème enfant Top-Famille Pro

Thème enfant WordPress sur mesure, parent **GeneratePress**. Voir `CLAUDE.md` (racine du dépôt)
pour les règles du projet et `STATUS.md` pour l'état d'avancement.

## Arborescence

```
wp-content/themes/topfamillepro/
├── style.css              En-tête de déclaration du thème enfant (obligatoire WordPress)
├── functions.php          Bootstrap — charge includes/*.php dans l'ordre
├── header.php / footer.php
├── front-page.php         Page d'accueil (seule page complète à ce stade — phase 1)
├── 404.php                Vraie 404 HTTP
├── index.php / page.php / single.php   Gabarits de secours (phase 2 les remplace)
├── includes/
│   ├── setup.php                    Support du thème, menus, tailles d'image
│   ├── customizer.php               Réglage natif (photo d'Audrey) — aucune dépendance ACF
│   ├── site-options.php             Données réelles (PROJECT_INPUTS.md) — jamais de valeur inventée
│   ├── enqueue.php                  Chargement CSS/JS, cache-busting par filemtime
│   ├── images.php                   tfp_picture() — AVIF/WebP/JPEG responsive
│   ├── components.php               tfp_button(), tfp_check_item()
│   ├── breadcrumbs.php              Fil d'Ariane + BreadcrumbList JSON-LD
│   ├── seo.php                      title, meta description, canonical, OG, Twitter, JSON-LD
│   ├── security.php                 Durcissement scopé au thème
│   ├── cpt-zone.php / cpt-prestation.php       CPT (déclarations, contenu en phase 2) — enregistrés indépendamment d'ACF
│   ├── acf-helpers.php              FAQ à nombre variable sans le champ Repeater (Pro), via des champs Group (gratuit)
│   ├── acf-fields-zone.php / acf-fields-prestation.php   Champs ACF structurés — 100 % compatibles ACF gratuit
│   └── reassurance-settings.php     Réglages avis/note réels — API Settings native, sans ACF
├── template-parts/
│   ├── header/   site-header, mobile-nav, mobile-cta-bar
│   ├── footer/   site-footer
│   └── home/     une section = un fichier (hero, services, pricing…)
├── src/css/      Sources CSS (tokens → base → layout → composants → home), non chargées telles quelles
├── src/js/       Sources JS (nav.js : sous-menus, menu mobile, focus trap)
└── assets/dist/  Sortie de build : css/main.css, js/main.js, fonts/*.woff2, images/*
```

`src/` = sources versionnées. `assets/dist/` = sortie de build, **également versionnée** (pas de
pipeline CI/CD à ce stade, l'hébergement mutualisé Hostinger ne construit rien : le dépôt doit
contenir le résultat prêt à servir).

## Prérequis

- Node.js ≥ 20 et npm (build CSS/JS/images)
- PHP ≥ 8.0 (lint uniquement — le thème tourne sur le PHP de l'hébergement WordPress)
- Un WordPress fonctionnel (local ou distant) pour prévisualiser réellement le thème

## Installation des outils de build

```bash
npm install
```

## Commandes

| Commande | Effet |
|---|---|
| `npm run build` | Build complet production : CSS/JS minifiés + régénération des images responsives |
| `npm run dev` | Watch CSS/JS (non minifié, sourcemaps) — pour développer en local |
| `npm run build:css` | CSS/JS uniquement |
| `npm run images` | Régénère `assets/dist/images/` (AVIF/WebP/JPEG + `manifest.json`) à partir de `assets/photos/` (racine du dépôt) |
| `npm run fonts` | Retélécharge Bricolage Grotesque + Hanken Grotesk depuis Google Fonts et régénère `src/css/01-fonts.css` |
| `npm run lint:php` | `php -l` sur tous les fichiers du thème (erreurs de syntaxe fatales) |
| `npm run test` | `lint:php` + `build` |

Après toute modification de `src/css/*.css` ou `src/js/*.js`, lancer `npm run build:css` (ou
`npm run dev` en continu) avant de recharger la page — `assets/dist/` ne se régénère pas seul.

## Installer et activer le thème sur un WordPress

1. Copier (ou lier) le dossier `wp-content/themes/topfamillepro/` de ce dépôt dans le
   `wp-content/themes/` de l'installation WordPress cible.
2. Installer le thème parent **GeneratePress** (gratuit, WordPress.org) dans
   `wp-content/themes/generatepress/` — prérequis, WordPress refuse d'activer un thème enfant
   dont le parent est absent.
3. Installer et activer le plugin **ACF** gratuit (Advanced Custom Fields — la version gratuite
   suffit, vérifié : aucun champ Repeater/Flexible Content/Gallery/Clone ni page d'options ACF
   n'est utilisé, ces cinq fonctionnalités étant exclusives à ACF PRO) — les CPT
   `zone`/`prestation` en dépendent pour leurs champs structurés. Sans ACF (absent ou inactif),
   le thème ne plante pas (`function_exists` systématique) et les CPT restent enregistrés ; seuls
   leurs champs n'existent pas. Les avis/note réels et la photo d'Audrey ne dépendent d'ACF dans
   aucun cas : réglages natifs WordPress (`includes/reassurance-settings.php`,
   `includes/customizer.php`).
4. Dans l'administration WordPress → *Apparence → Thèmes*, activer **Top-Famille Pro**.
5. Réglages → Permaliens : choisir une structure autre que « Simple » (ex. « Nom de l'article »)
   pour que les URL des CPT (`/prestations/…/`, `/zones-intervention/…/`) fonctionnent.
6. `npm run build` avant la mise en ligne si `src/` a été modifié depuis le dernier build commité.

## Prévisualisation locale (sans WordPress installé)

Le thème a été vérifié dans cette session via un WordPress jetable (WP core + drop-in SQLite,
aucune installation MySQL nécessaire) — utile pour retester rapidement sans base de données. Voir
`STATUS.md` §11 pour la procédure complète utilisée (elle n'est pas versionnée dans ce dépôt : ce
n'est pas l'environnement de développement du projet, seulement un moyen de vérification ponctuel).

Pour un usage courant, un environnement local classique convient (Local, wp-env, DDEV, XAMPP…) :
pointer son dossier de thèmes vers `wp-content/themes/topfamillepro/` de ce dépôt.
