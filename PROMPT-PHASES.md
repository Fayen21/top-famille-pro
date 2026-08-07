# PROMPT-PHASES.md — Séquence de prompts pour Claude Code Web

> **Mode d'emploi.** Une phase = une session Claude Code Web = une branche = une PR.
> On colle **un seul bloc à la fois**, dans une session neuve, sur le dépôt `Fayen21/top-famille-pro`.
> `CLAUDE.md` est lu automatiquement au démarrage : inutile de recoller les règles.
> Chaque phase se termine par une mise à jour de `STATUS.md` — c'est la mémoire entre les sessions.
>
> **Ne pas enchaîner deux phases dans la même session.** Un site de 53 pages ne tient pas dans un
> seul contexte : c'est précisément ce qui a fait caler la session précédente.

---

## Phase 0 — Audit et choix de plateforme

```
Lis CLAUDE.md, PROJECT_INPUTS.md et reference/Top-Famille-Pro-HANDOFF-READY.html.

N'écris aucun code applicatif dans cette session. Objectif : produire un état des lieux exploitable.

1. Audite le dépôt : arborescence, technologie déjà présente, branches, travaux non commités,
   vestiges de la tentative précédente. Dis-moi précisément ce qui est réutilisable et ce qui
   doit être abandonné.
2. Reconstitue depuis le prototype l'inventaire COMPLET des 53 pages publiques + 404, sous forme
   de tableau : route de démo `#/...` → URL propre cible → famille (statique / prestation /
   département / ville / commune / article) → titre → h1 → présence d'une FAQ → blocs de preuve
   utilisés. Écris-le dans `docs/INVENTAIRE-ROUTES.md`.
3. Extrais la direction artistique réelle du prototype : toutes les couleurs utilisées avec leur
   hex et leur rôle, les tailles et graisses typographiques, les espacements, rayons, ombres et
   breakpoints. Écris-les sous forme de tokens dans `docs/DESIGN-TOKENS.md`.
4. Inventorie `assets/` et liste ce qui manque par rapport à ce qu'exige le prototype
   (logo SVG horizontal, logo carré, favicon, photos, polices et leur licence).
5. Recense les données de démonstration à neutraliser : avis, note, compteur, lien Google,
   portraits, photos d'intervenants, avec leur emplacement exact. → `docs/DONNEES-FICTIVES.md`
6. Liste tous les points de PROJECT_INPUTS.md encore marqués ⛔ qui bloqueront une phase, en les
   classant par phase bloquée.

7. La plateforme est arrêtée (WordPress sur Hostinger, thème enfant GeneratePress). Recommande
   l'architecture WordPress : CPT `zone` et CPT `prestation` avec champs structurés, ou pages
   classiques ; blocs natifs ou ACF. Argumente au regard des 26 pages locales à maintenir.

Termine par la création de STATUS.md : état du projet et décisions en attente.

Ouvre une PR "Phase 0 — audit". Ne modifie rien d'autre.
```

**→ Après cette phase : tu tranches l'architecture WordPress et tu l'écris dans `CLAUDE.md` section 3.**

---

## Phase 1 — Fondations techniques

```
Lis CLAUDE.md, STATUS.md, docs/DESIGN-TOKENS.md et docs/INVENTAIRE-ROUTES.md.

Mets en place les fondations du site sur la plateforme retenue :
- structure de projet, build, scripts npm ;
- tokens de design centralisés à partir de docs/DESIGN-TOKENS.md ;
- polices Bricolage Grotesque et Hanken Grotesk auto-hébergées, font-display: swap ;
- layout de base : header, navigation, menu mobile accessible, footer, barre CTA mobile ;
- système de routage produisant les URL propres définitives, sans aucun fragment #/ ;
- vraie 404 avec statut HTTP 404 ;
- composants de base : bouton, carte, section, fil d'Ariane, bloc CTA, bloc réassurance ;
- pipeline images (AVIF/WebP, srcset, dimensions explicites) ;
- squelette des données structurées (Organization/ProfessionalService, WebSite) alimenté
  uniquement par les données réelles de PROJECT_INPUTS.md.

Construis UNE seule page complète — l'accueil — comme preuve de bout en bout, dans l'ordre :
hero, tarif et réassurance, prestations, problèmes résolus, fonctionnement, tarifs, couverture
régionale, Audrey et avis, conseils, CTA final. Le bloc « Professionnels accompagnés » peut être
fusionné avec les prestations s'il allonge inutilement la page.

Vérifie l'accueil à 320, 375, 768, 1024, 1440 et 1920 px : aucun débordement horizontal, aucun
texte tronqué, aucun recouvrement, la barre CTA mobile ne masque rien.

Mets à jour STATUS.md. Ouvre une PR. Indique-moi la commande exacte pour lancer et prévisualiser
le site en local.
```

---

## Phase 2 — Gabarits par famille de pages

```
Lis CLAUDE.md, STATUS.md et docs/INVENTAIRE-ROUTES.md.

Crée un gabarit par famille — page statique, prestation, département, ville/commune, article —
et implémente UNE page réelle de chaque famille comme référence, avec son contenu issu du
prototype (corrigé selon la section 9 de CLAUDE.md).

Chaque gabarit doit produire dans le HTML initial : title unique, meta description unique,
canonical absolue, h1 unique, Open Graph, Twitter, fil d'Ariane visible + BreadcrumbList, et le
JSON-LD propre à la famille (Service pour les prestations, Article pour les articles, FAQPage
seulement si la FAQ est visible).

Pour les pages locales, la structure obligatoire est : réponse directe en tête de page, types de
locaux concernés, services disponibles, fonctionnement réel, tarif, interlocutrice, zones
réellement desservies, FAQ locale, CTA contextualisé, liens vers la page départementale, les
villes proches, les prestations et la page pilier.

N'invente aucune donnée locale (distance, trajet, quartier, délai, fréquence) : si l'information
n'existe pas dans le prototype ou PROJECT_INPUTS.md, laisse [À COMPLÉTER] visible.

Mets à jour STATUS.md. Ouvre une PR.
```

---

## Phase 3 — Migration des 53 pages

```
Lis CLAUDE.md, STATUS.md et docs/INVENTAIRE-ROUTES.md.

Migre les pages restantes vers les gabarits de la phase 2, par lots de 8 à 10 pages maximum,
en commitant après chaque lot. Annonce le lot avant de le traiter.

Pour chaque page :
- reprends le contenu éditorial du prototype ;
- applique les corrections de la section 9 de CLAUDE.md ;
- corrige l'orthographe et la grammaire ;
- réécris les blocs tarifaires locaux qui suivent encore une trame trop similaire d'une ville à
  l'autre : une page locale doit apporter une valeur propre, pas une variante par remplacement du
  nom de la ville ;
- si une page locale n'a pas assez d'information unique, ou si la zone ne peut pas réellement être
  desservie, garde la page mais passe-la en noindex,follow et signale-la ;
- raccourcis les title qui dépassent ~65 caractères en préservant leur intention principale.

Supprime toute occurrence résiduelle de « Top-Entreprise ».

Après le dernier lot : mets à jour STATUS.md avec la liste des pages passées en noindex et des
pages incomplètes. Ouvre une PR.
```

---

## Phase 4 — Maillage interne et conversion

```
Lis CLAUDE.md et STATUS.md.

1. Reconstruis la matrice complète des liens internes → docs/MAILLAGE.md. Aucune page publique
   orpheline. Ancres descriptives et variées, pas de répétition mécanique de la même ancre.
   Liens à garantir : prestations ↔ tarifs, prestations ↔ villes prioritaires, région ↔
   départements, départements ↔ villes, villes ↔ communes proches, articles ↔ prestations, toutes
   les pages → page pilier « Nettoyage professionnel », tous les CTA → demande de devis.
   Corrige les trois cartes « Conseils & repères » de l'accueil qui pointent toutes vers /conseils/.

2. Implémente le formulaire de devis en deux étapes conformément à la section 8 de CLAUDE.md :
   Étape 1 — type de locaux, besoin régulier ou ponctuel, ville, code postal, surface approximative,
   nom, téléphone ou e-mail.
   Étape 2 — entreprise, fréquence, créneau, message, consentement.
   Contexte visiteur capté et transmis, préremplissage depuis les pages locales et prestations,
   validation client et serveur, honeypot, limitation des soumissions, erreurs accessibles,
   confirmation uniquement après succès serveur réel, confirmation en noindex.

3. Prépare les événements analytiques quote_start, quote_step_1_complete, quote_submit,
   quote_success, quote_error, phone_click, email_click, local_cta_click sous forme de couche de
   données neutre. N'installe AUCUN outil de tracking.

Dis-moi précisément ce qu'il me reste à fournir pour que le formulaire envoie réellement les
demandes (adresse de réception, service d'envoi, clés). Mets à jour STATUS.md. Ouvre une PR.
```

---

## Phase 5 — Tests automatisés

```
Lis CLAUDE.md et STATUS.md.

Crée une suite de tests automatisés (Playwright) vérifiant sur toutes les routes publiques :
statut HTTP attendu, 404 réelle, h1 unique, title présent et unique, meta description présente,
canonical correcte, robots correct, JSON-LD valide, aucun lien interne mort, aucune page orpheline,
aucun href="#" public, aucun fragment #/ , aucune occurrence « Top-Entreprise », aucun avis de
démonstration visible, aucun alt mensonger, aucune erreur JavaScript, aucun débordement horizontal.

Tests fonctionnels sur au moins une page de chaque famille : formulaire complet, contexte local
transmis, validation téléphone/e-mail, consentement, anti-spam, navigation clavier.

Captures responsive automatiques en 320×568, 360×800, 375×812, 393×852, 414×896, téléphone
paysage, 768×1024, 1024×768, 1180×820, 1280×800, 1440×900, 1920×1080 — enregistrées dans
.screenshots/ (ajoute ce dossier au .gitignore, sauf une sélection commitée dans docs/captures/
pour que je puisse les regarder depuis GitHub).

Contrôle particulier : villes à nom long (Fontaine-lès-Dijon, Chalon-sur-Saône), formulaire en
erreur, formulaire à l'étape 2, clavier mobile ouvert, bandeau cookies, tableaux, footer.

Corrige tout ce que les tests révèlent. Mets à jour STATUS.md. Ouvre une PR.
```

---

## Phase 6 — Accessibilité, performance, recette finale

```
Lis CLAUDE.md et STATUS.md.

1. Audit accessibilité automatisé (axe) sur au moins une page de chaque famille, complété par des
   tests clavier réels sur le menu mobile, le drawer, le formulaire et la barre CTA. Corrige
   jusqu'à WCAG 2.2 AA.
2. Optimise les performances jusqu'aux cibles de CLAUDE.md section 8. Mesure Lighthouse mobile et
   donne les chiffres réels, sans les arrondir en ta faveur.
3. Génère robots.txt, sitemap XML (sitemaps par famille si la plateforme le permet), en excluant
   pages de test, confirmations, documentation interne et 404.
4. Prépare le plan de redirections 301 depuis les anciennes URL de topentreprise.fr — uniquement
   celles dont la source ET la destination sont identifiées. Aucune redirection inventée.
   → docs/REDIRECTIONS.md

Puis produis le RAPPORT FINAL dans docs/RAPPORT-FINAL.md :
verdict global · plateforme et architecture · fichiers créés ou modifiés · matrice des routes ·
corrections SEO · corrections GEO · corrections de maillage · optimisations de conversion ·
corrections responsive · résultats d'accessibilité · résultats de performance chiffrés · résultats
des tests · données fictives supprimées ou masquées · informations client encore manquantes ·
bloqueurs de publication · étapes exactes pour lancer et prévisualiser le site.

Rappel : ne déclare pas PRODUCTION READY si un seul élément de la section 10 de CLAUDE.md subsiste.
```
