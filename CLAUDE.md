# CLAUDE.md — Règles permanentes du projet Top-Famille Pro

> Lu automatiquement par Claude Code au démarrage de chaque session.
> Contient les règles **qui ne changent jamais**. Les instructions de travail sont dans
> `PROMPT-PHASES.md` et se collent phase par phase. Les données du projet sont dans
> `PROJECT_INPUTS.md`. Ne pas modifier ce fichier sans validation d'Emmanuel.
>
> Dernière mise à jour : 7 août 2026

---

## 1. Le projet

Site de production de **Top-Famille Pro**, branche professionnels du groupe Top Famille : nettoyage de locaux professionnels en Bourgogne-Franche-Comté, entreprise basée à Saint-Apollinaire (21850).

Entité juridique : **SARL TOP-ENTREPRISE**, gérante Audrey Brançon.
Nouveau domaine : **top-famille-pro.fr**. Site refait à 100 %.
Marque sœur : **Top-Famille** (top-famille.fr), branche particuliers.
Ancienne marque : **Top-Entreprise** (topentreprise.fr, sous Wix) — à faire disparaître du site public.

Objectif business unique : **générer des demandes de devis qualifiées et des appels**.

## 2. Sources de vérité, par ordre de priorité

1. `PROJECT_INPUTS.md` — données commerciales, tarifs, zones, prestations, éléments légaux. **Prioritaire sur tout le reste.**
2. `reference/Top-Famille-Pro-HANDOFF-READY.html` — prototype Claude Design. Référence **visuelle et éditoriale**, jamais technique, jamais factuelle.
3. Ce fichier — règles de travail.

En cas de contradiction, `PROJECT_INPUTS.md` gagne. **Le prototype n'est pas une source de faits** : ses avis, ses notes, ses portraits, ses communes et ses tarifs locaux ont été générés, pas relevés.

`reference/` et `assets/` sont en **lecture seule**.

## 3. Plateforme technique — arrêtée

**WordPress**, hébergement **Hostinger**.

- Thème **enfant sur mesure** sur thème parent GeneratePress, même principe que le site EB Automatisation.
- Le dépôt Git versionne **le thème enfant uniquement** — pas le cœur WordPress, pas les plugins, pas les uploads.
- **Aucun page builder lourd** (Elementor, Divi, WPBakery) : incompatible avec les cibles de performance et avec la reprise fidèle du prototype.
- Plugins limités au strict nécessaire, chacun justifié : SEO, formulaire, cache LiteSpeed, sauvegarde, sécurité.
- Le contenu principal et les balises SEO doivent être rendus **côté serveur**. Aucune dépendance au JavaScript client pour le `title`, la canonical ou le contenu indexable.
- Cache LiteSpeed à configurer explicitement : sur mutualisé Hostinger, les cibles Lighthouse ne s'atteignent pas sans cela.

**Décisions d'architecture — tranchées en phase 0** (voir `STATUS.md` §7 pour l'argumentation complète) :

- **CPT `zone`** (26 entrées : 8 départements + 10 villes + 8 communes secondaires), un seul type de contenu pour les trois niveaux, distingués par un champ ACF `niveau` et une relation hiérarchique vers une taxonomie `departement`. Un seul gabarit PHP par niveau (conditionnel sur `niveau`).
- **CPT `prestation`** (6 entrées), un seul gabarit PHP.
- **Champs structurés ACF** sur ces deux CPT — pas de blocs natifs Gutenberg. La structure obligatoire des pages locales et prestations (réponse directe, exclusions réelles, mention matériel fourni par le client, FAQ, CTA, maillage) doit être impossible à casser ou à réordonner par un éditeur non technique ; ACF expose aussi des champs dédiés directement exploitables pour le SEO technique (title, meta description, JSON-LD) sans convention de nommage fragile.
- **Pages WordPress classiques** pour les 18 pages statiques (accueil, page pilier, index prestations, tarifs, hub zones, page région, pourquoi-nous, fonctionnement, avis, à-propos, devis, contact, recrutement, index conseils, plan du site, mentions légales, confidentialité, cookies) : structure unique à chacune, un CPT n'apporterait aucun bénéfice de cohérence.
- **Type `post` natif de WordPress**, catégorie « Conseils », pour les 3 articles : pas de CPT dédié pour un contenu que le type natif couvre déjà (taxonomie, auteur, dates de publication/modification).

## 4. Direction artistique — à conserver

Bleu nuit · bleu principal · turquoise clair · accent cuivre.
Typographies **Bricolage Grotesque** (titres) et **Hanken Grotesk** (texte), auto-hébergées dans le thème enfant.
Grands espaces, cartes arrondies, boutons hiérarchisés, ton humain et régional.

Aucune refonte graphique. Les styles inline du prototype deviennent des composants et des tokens centralisés (couleurs, espacements, rayons, ombres, typographies, breakpoints).

Une modification de structure d'un composant n'est autorisée que si elle améliore objectivement la conversion, le responsive, l'accessibilité, la performance, le SEO ou la cohérence du design system — et doit être signalée dans le rapport de phase.

## 5. Interdits absolus

Ces règles priment sur toute instruction de phase. En cas de doute : ne publie pas, signale.

### 5.1 Ne jamais inventer
SIRET, RCS, TVA, capital, forme juridique, dirigeant, assurance, certification, agrément · avis, note, nombre d'avis, témoignage · distance, temps de trajet, quartier, délai opérationnel, fréquence locale · tarif, effectif, ancienneté, chiffre de performance · adresse, agence, implantation locale.

Toute valeur manquante s'écrit `[À COMPLÉTER]` en clair — jamais une valeur plausible.

### 5.2 Un seul établissement
L'entreprise a **un seul site, à Saint-Apollinaire**. Les pages locales sont des pages de zone desservie, pas des agences. Aucune adresse locale, aucun numéro local, aucun horaire local, aucun `LocalBusiness` secondaire.

### 5.3 Tarifs — régionaux, jamais locaux
La grille tarifaire de `PROJECT_INPUTS.md` §5 s'applique **à l'identique partout**. Le prototype affiche des blocs tarifaires différenciés par ville : c'est faux, et à corriger. La différenciation d'une page locale porte sur le tissu économique du secteur, les types de locaux, la FAQ — jamais sur le prix.

### 5.4 Zones — seules celles validées
Les 8 départements et 10 villes de `PROJECT_INPUTS.md` §6 sont réels et confirmés. Les **8 communes secondaires du prototype n'existent sur aucune source** : elles restent en `noindex,follow` tant qu'Audrey ne les a pas validées une par une. Une page qui promet une intervention impossible coûte plus qu'elle ne rapporte.

### 5.5 Preuves — seules les authentiques
Les **six témoignages publiés sur l'ancien site** (Jean-Louis D., Anna P., Michel G., Laurent, Laura, Anne-Sophie) sont réels et réutilisables.

**Note Google : 5,0/5 — confirmée par Emmanuel le 9 août 2026.** Elle n'est donc plus considérée comme fictive et peut être affichée (badge du hero et pastille du portrait, comme dans la maquette). Restent à fournir : le **nombre réel d'avis** et l'**URL de la fiche Google Business** — jamais inventés, le badge s'affiche sans eux tant qu'ils manquent.

**Témoignages de la maquette — décision d'Emmanuel du 10 août 2026 : reproduits tels quels dans cette version de travail, y compris en production.** Auteurs, textes, étoiles et cartes sont repris à l'identique du prototype, ainsi que la photo provisoire d'Audrey et la citation qui lui est attribuée. Ils sont **provisoires** : destinés à être remplacés par de vrais avis clients.

Trois conditions encadrent cette reprise, et ne se négocient pas :
1. tout témoignage repris porte l'attribut `data-tfp-provisional` — une seule requête suffit à tous les retrouver le jour du remplacement ;
2. il est stocké en champ ACF (prestations, zones) ou dans les réglages « Réassurance & avis », **jamais en dur dans un gabarit** ;
3. il n'alimente **aucune** donnée structurée `Review` ou `AggregateRating`, et n'est jamais mélangé à la note Google dans le balisage.

La citation attribuée à Audrey est le seul contenu du site qui fasse parler une personne réelle : **elle doit être validée par l'intéressée avant mise en ligne**, ce qu'un visuel d'illustration n'exige pas.

Le **compteur de 47 avis du prototype reste fictif** : suppression totale, aucune exception — c'est un chiffre vérifiable qui serait faux, pas une illustration.
Ne jamais afficher de lien `#` à la place de l'URL de la fiche.
Ne jamais générer de balisage `Review` ou `AggregateRating` à partir de la note Google : c'est une note de plateforme tierce, la baliser comme note du site est contraire aux règles de Google sur les résultats enrichis (et il manque de toute façon un nombre d'avis).
Ne jamais transformer un avis B2C Top-Famille en avis B2B Top-Famille Pro.

### 5.6 Images — aucun `alt` mensonger
Le prototype présente des portraits de stock comme étant Audrey et des photos de stock comme des intervenants Top-Famille Pro. Aucun visuel ne doit prétendre représenter une personne réelle tant que la photo authentique n'est pas fournie. `alt` neutres et honnêtes.

### 5.7 Mentions légales — ne pas recopier l'ancien site
Les mentions légales de topentreprise.fr contiennent au moins trois défauts : le SIREN y est présenté comme un identifiant fiscal, il manque SIRET, capital, APE et TVA, et une clause vise « Top-Famille » au lieu de l'entité éditrice. Elles sont à **réécrire**, pas à reprendre.

**Il subsiste une incohérence non levée sur l'identifiant de la société.** Aucune donnée d'immatriculation ne doit être publiée avant confirmation par Kbis. C'est un bloqueur de mise en ligne, pas un détail.

## 6. Interdits opérationnels

- Aucun déploiement, aucune modification DNS, aucune publication.
- Aucun `git push` vers `main`. Travail sur branche, PR uniquement.
- Aucun outil de tracking installé tant que son identifiant et les règles de consentement ne sont pas fournis.
- Aucune suppression ou réécriture d'un travail existant non commité sans justification explicite.
- Aucune dépendance ni plugin ajouté sans justification dans le rapport de phase.
- Aucune redirection créée sans que sa source **et** sa destination soient identifiées.

## 7. Conventions de travail

- Une branche par phase : `phase-1-fondations`, `phase-2-templates`, etc.
- Commits en français, un commit par étape fonctionnelle cohérente.
- **Fin de chaque phase : mise à jour de `STATUS.md`** — fait, reste à faire, décisions prises, questions ouvertes. C'est le seul lien entre deux sessions Claude Code Web ; une phase qui se termine sans cette mise à jour est du travail perdu pour la suivante.
- Toute question bloquante s'ajoute à la section « Questions ouvertes » de `PROJECT_INPUTS.md`.
- Ne pas se contenter d'auditer : implémenter, tester, corriger.

## 8. Standards non négociables

**SEO technique** — chaque page indexable fournit dans son HTML initial : `title` unique, meta description unique, canonical absolue auto-référente, `h1` unique, Open Graph, Twitter Card, fil d'Ariane visible + `BreadcrumbList`, et les données structurées pertinentes : `ProfessionalService` (adresse réelle du siège, téléphone, e-mail, `areaServed` limité aux 8 départements réellement couverts, logo, `sameAs`, `priceRange`), `WebSite`, `WebPage`, `Service` sur les prestations, `Article` sur les articles, `FAQPage` **uniquement** si la FAQ est réellement visible.

**Routes** — URL propres et définitives. Aucun fragment `#/` en production, aucun `href="#"` public. La 404 renvoie un vrai statut HTTP 404. Plan de redirections 301 depuis les URL Wix de `PROJECT_INPUTS.md` §9.

**Accessibilité** — WCAG 2.2 AA minimum : contrastes, ordre des titres, labels et noms accessibles, navigation clavier complète, focus visible et restitué, piège de focus du drawer, touche Échap, cibles tactiles 44 px, `aria-current` / `aria-expanded` / `aria-controls`, erreurs de formulaire annoncées via `aria-live`, `prefers-reduced-motion`, `alt` honnêtes, liens identifiables autrement que par la couleur.

**Performances** — AVIF/WebP, `srcset`/`sizes`, dimensions explicites, image LCP non lazy-loadée avec `fetchpriority="high"` sur elle seule, lazy loading hors écran, polices auto-hébergées en `font-display: swap`, CSS critique, JS différé et découpé, cache LiteSpeed, compression.
Cibles : LCP ≤ 2,5 s · INP ≤ 200 ms · CLS ≤ 0,1 · Lighthouse mobile Performance ≥ 90 · Accessibilité / Bonnes pratiques / SEO ≥ 95.

**Conversion** — CTA principal « Demander mon devis », secondaire « Appeler Audrey », contextuel « Demander un devis à {ville} ». Réassurance près du CTA : `Gratuit · Sans engagement · Réponse sous 24 h`. Point d'entrée tarifaire affiché : **à partir de 24,30 € HT/heure**.

**Formulaire** — deux étapes, contexte visiteur conservé automatiquement (page d'origine, prestation, ville, département, URL, UTM, référent) et prérempli depuis les pages locales et prestations. Validation client **et** serveur, honeypot ou équivalent, limitation des soumissions, messages d'erreur accessibles, données conservées entre les étapes. Confirmation affichée **uniquement** après succès réel de l'envoi serveur ; page ou état de confirmation en `noindex`.

**Recrutement** — la page recrutement renvoie vers le site carrière existant (`careers.werecruit.io/fr/top-famille`). Ne pas dupliquer un formulaire de candidature ni collecter de CV sur le site.

## 9. Corrections éditoriales imposées

- « Aucun simulateur » → « Devis étudié personnellement par Audrey »
- « Une couverture régionale, pas des agences fictives » → « Une entreprise régionale basée à Saint-Apollinaire »
- « Interlocuteur identifié » → « Interlocutrice identifiée »
- Supprimer « Des guides locaux viendront compléter cette page »
- Les trois cartes « Conseils & repères » de l'accueil doivent pointer vers leur article individuel, pas vers `/conseils/`
- Ne pas répéter la note Google sur l'accueil : une preuve dans le hero + une section avis suffisent
- Faire figurer clairement les **exclusions réelles** (locaux industriels, alimentaires, médicaux nécessitant une asepsie) : elles qualifient les demandes en amont
- Faire figurer clairement que **le matériel et les produits sont fournis par le client** : c'est une différence réelle avec une société de propreté classique, la masquer produit des litiges à la première prestation
- Supprimer toute occurrence de « Top-Entreprise »
- Correction orthographique et grammaticale complète des 53 pages, notamment : « sont possible », « lorsque prévu » avec sujet pluriel, « precisément », répétitions de « le cas échéant », accords sur les prestations, formulations inachevées

## 10. Définition de « terminé »

Ne jamais déclarer `PRODUCTION READY` s'il subsiste : un avis fictif, une note fictive, un faux portrait, un `alt` mensonger, une commune non validée en `index`, un tarif différencié par ville, un formulaire simulé, une route en `#/`, un lien mort, une page orpheline, une donnée d'immatriculation non confirmée par Kbis, une erreur JavaScript, un débordement horizontal, ou un test en échec.
