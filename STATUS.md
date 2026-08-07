# STATUS — Top-Famille Pro

> Lien entre deux sessions Claude Code Web. Mis à jour à la fin de chaque phase.
> Dernière mise à jour : **Phase 0 — Audit et choix de plateforme**, 7 août 2026.

---

## 1. Où en est le projet

Phase 0 terminée. Aucun code applicatif écrit (conforme à la consigne de phase). Le dépôt contient
désormais, en plus du cadrage existant, un audit complet du prototype et une décision d'architecture.

**Prochaine étape : Phase 1 — Fondations techniques**, sur une nouvelle branche dédiée
(`phase-1-fondations` selon la convention CLAUDE.md §7), une fois cette PR de phase 0 revue.

> Note pour Emmanuel : les prompts des phases 1 à 6 sont arrivés dans la même conversation que
> celui de la phase 0, avant que celle-ci soit terminée. Je n'ai traité que la phase 0 dans cette
> session — c'est la seule pour laquelle cette session a une branche dédiée
> (`claude/phase-0-audit-plateforme-siw01r`), et CLAUDE.md §7 impose une branche par phase avec
> revue entre deux sessions. Les phases 1 à 6 nécessitent chacune leur propre session/branche ;
> elles s'appuient d'ailleurs sur les décisions prises ici (architecture WordPress, notamment), donc
> les lancer avant la fin de la phase 0 aurait été prématuré.

---

## 2. Audit du dépôt

**Historique complet (4 commits, tous en local + `origin`) :**
1. `7c2441b` "Add test file" / `2d04ebe` "Delete test" — fichier de test vide créé puis supprimé le
   même jour (20 juillet). Sans conséquence, ne laisse rien dans l'arbre actuel.
2. `be1ac81` "Top-Entreprise - Prototype Ready for Code.html" (20 juillet) — **vestige d'une
   tentative précédente**, antérieure au cadrage actuel.
3. `65e95cd` "Ajout du prototype, des assets et du cadrage" (7 août) — commit unique qui apporte
   `CLAUDE.md`, `PROJECT_INPUTS.md`, `PROMPT-PHASES.md`, `assets/`, et `reference/Top-Famille-Pro-HANDOFF-READY.html`.
   C'est le vrai point de départ du projet actuel.

**Branches :** `integration-v2` existe sur `origin` et en local mais est **strictement identique**
à la branche courante (aucun commit propre, `git diff` vide). Aucune trace de travail non commité
ailleurs. Rien à récupérer d'une « tentative précédente » côté code : il n'y en a pas eu, seulement
un fichier prototype isolé.

### Fichier à abandonner : `Top-Entreprise - Prototype Ready for Code.html` (racine du dépôt)

- Utilise encore l'**ancienne marque** dans son `<title>` (« Top-Entreprise — Prototype Ready for
  Code ») et une palette différente (fond `#174A81` au lieu de `#10263B`) — signe qu'il s'agit d'un
  prototype antérieur au rebranding Top-Famille Pro, pas d'une version alternative du prototype actuel.
  C'est exactement le genre d'artefact que CLAUDE.md §9 demande de faire disparaître
  (« Supprimer toute occurrence de "Top-Entreprise" »).
  Il n'est référencé par aucune règle de CLAUDE.md (seul `reference/Top-Famille-Pro-HANDOFF-READY.html`
  est cité comme source visuelle/éditoriale) et fait **1,4 Mo** dans un dépôt censé ne verser que le
  thème enfant.
- **Recommandation : supprimer ce fichier en phase 1**, avec l'accord d'Emmanuel avant suppression
  puisque CLAUDE.md interdit toute suppression de travail existant sans justification explicite —
  cette justification est documentée ici. Non supprimé dans cette session (hors périmètre : « ne
  modifie rien d'autre » pour la phase 0).

### Ce qui est réutilisable

- `reference/Top-Famille-Pro-HANDOFF-READY.html` — prototype Claude Design actuel, en lecture
  seule : source unique de vérité visuelle/éditoriale (jamais factuelle). Entièrement exploitable
  pour la migration : structure de composants claire, 53 pages générées par 10 gabarits, logique
  SEO déjà pensée (fonction `seoEntry()` interne, cf. §3 ci-dessous).
- `assets/` — logos et photos, partiellement exploitables (détail en §4).
- `CLAUDE.md`, `PROJECT_INPUTS.md`, `PROMPT-PHASES.md` — cadrage à jour, à conserver tel quel (sauf
  mise à jour de CLAUDE.md §3 faite par cette phase).

---

## 3. Ce que le prototype contient réellement (méthode d'extraction)

Le fichier `reference/Top-Famille-Pro-HANDOFF-READY.html` n'est pas un site statique lisible
directement : c'est un **bundle** (format « Claude Design ») encodant un runtime `x-dc` +
React + un unique composant applicatif compilé, avec toutes les ressources (images, polices,
JS) encodées en base64/gzip dans un JSON de 3,8 Mo. Il a été décompressé et exécuté (Node, sans
navigateur) pour en extraire les données réelles plutôt que de les deviner : tableaux `SERVICES`,
`DEPTS`, `CITIES`, `SECONDARY`, `ARTICLES`, `STATIC_SEO`, fonction `seoEntry()`, et surtout
`QA_ROWS` — **le prototype embarque lui-même un audit de ses 53 routes** (`qaRoutes()`), utilisé ici
comme source de vérité pour `docs/INVENTAIRE-ROUTES.md`. Le prototype contient aussi un onglet de
QA interne (`#/documentation-interne`) et un auditeur de débordement horizontal in-browser — utile
pour comprendre l'intention du designer, mais ce ne sont **pas** des pages publiques.

Résultat : **53 pages publiques + 1 page 404** répartis en 6 familles sur 10 gabarits distincts,
détaillés dans `docs/INVENTAIRE-ROUTES.md`.

---

## 4. Documents produits par cette phase

| Document | Contenu |
|---|---|
| `docs/INVENTAIRE-ROUTES.md` | Les 53 pages + 404 : route démo `#/...` → URL cible → famille → title (avec longueur) → h1 → FAQ → preuves utilisées → statut robots cible. Inclut les écarts à corriger (communes secondaires en `index,follow` dans le prototype, à passer en `noindex,follow`). |
| `docs/DESIGN-TOKENS.md` | Couleurs (hex, occurrences, rôle déduit), typographie (tailles, graisses), rayons, ombres, espacements, breakpoints — extraits par comptage réel dans le bundle, pas estimés à l'œil. |
| `docs/DONNEES-FICTIVES.md` | Les 40 avis de démonstration (détail par page), la note 5,0/47 avis, les 18 scénarios locaux hypothétiques, les portraits/photos à ne pas présenter comme réels — avec emplacement exact dans les données du prototype. |
| `STATUS.md` (ce fichier) | Bilan de phase, décisions, blocages. |

---

## 5. Inventaire `assets/` — ce qui manque

| Élément attendu | Présent ? | Détail |
|---|---|---|
| Logo horizontal SVG | ❌ | `assets/logo/logo-horizontal.png` existe mais en **PNG raster** (759×402), pas en SVG. À vectoriser ou à redemander en SVG pour un rendu net à toutes tailles/résolutions. |
| Logo carré | 🟡 | `assets/logo/logo-square.jpg` (1024×1009, JPEG) — raster également, pas de fond transparent possible (JPEG). Formats PNG/SVG à privilégier pour les usages (favicon, réseaux sociaux, `logo` JSON-LD). |
| Favicon | ❌ | Aucun fichier favicon (`.ico`, `.png` 32/180/512, `apple-touch-icon`) dans `assets/`. À générer à partir du logo carré une fois celui-ci disponible en meilleure qualité. |
| Doublons | ⚠️ | `assets/icons/123ee98e-….jpg` = `assets/logo/logo-square.jpg` (md5 identique) et `assets/icons/896e5255-….jpg` = `assets/logo/896e5255-….jpg` (md5 identique). Le dossier `assets/icons/` ne contient donc aucun fichier qui ne soit pas déjà dans `assets/logo/`, plus un PNG supplémentaire (`f6e491bf-….png`, 1536×1024, 2 Mo — à identifier, poids inhabituel pour une icône). |
| Photos hero/prestations | ✅ (stock) | `hero-bureaux.jpg`, `hero-nettoyage-vitres.jpg`, `prestation-bureaux.jpg`, `prestation-commerces.jpg`, `locaux-professionnels-region.jpg`, + 17 photos `unsplash-*` : toutes des photos de lieux/objets, exploitables comme illustrations génériques (`alt` honnête), en attendant d'éventuelles photos réelles des locaux desservis. |
| Portraits | ⚠️ | 3 portraits de stock (`portrait-stock-01.jpg`, `portrait-stock-a-propos.jpg`, `portrait-stock-contact.jpg`) présentés dans le prototype comme Audrey ou des interlocuteurs — détail dans `docs/DONNEES-FICTIVES.md` §5. Aucun portrait réel disponible pour l'instant (bloqueur mise en ligne, PROJECT_INPUTS.md #7). |
| Photos intervenants | ⚠️ | 2 photos de stock (`intervenante-stock-bureaux.jpg`, `intervenante-stock-materiel.jpg`) — aucune photo réelle disponible (idem). |
| Polices | ❌ (pas dans `assets/`) | Bricolage Grotesque et Hanken Grotesk sont toutes deux sur Google Fonts, licence **OFL** (open, auto-hébergement autorisé). 7 fichiers `.woff2` (sous-ensembles Unicode) sont embarqués dans le bundle du prototype mais **ne sont pas versés dans `assets/`** — à retélécharger proprement depuis Google Fonts en phase 1 (poids et licence garantis), plutôt qu'à extraire du bundle. |

---

## 6. Points bloquants de `PROJECT_INPUTS.md`, classés par phase

Repris de `PROJECT_INPUTS.md` §12 (déjà taggés « Bloque » à la source), reclassés ici par phase
pour anticiper :

### Bloque la mise en ligne (pas une phase de travail, la publication elle-même)
- **Kbis** : SIRET exact, capital social, code APE, TVA intracommunautaire, date d'immatriculation —
  et lever l'incohérence SIREN 938 472 242 vs 938 472 420 relevée en annuaire. *(§2, question #1)*
- Assureur RC professionnelle (nom + n° de police) pour justifier « nous sommes assurés ». *(question #2)*
- URL de la fiche Google Business + note réelle + nombre d'avis réels. *(question #6)*
- Portrait HD d'Audrey + visuels réels. *(question #7)*

### Phase 0 (traité par cette phase)
- CPT + ACF ou pages classiques ? → tranché en §7 ci-dessous. *(question #11)*

### Phase 1
- E-mails en `@top-famille-pro.fr` ou maintien de `@top-famille.fr` ? *(question #5)*
- Accès hPanel / SFTP / base de données ; `top-famille-pro.fr` déposé et pointé ? *(question #12)*

### Phase 3
- Confirmation que les tarifs relevés sont toujours à jour. *(question #3)*
- Validation une par une des 8 communes secondaires du prototype (absentes du site actuel — voir
  `docs/INVENTAIRE-ROUTES.md`, famille « Commune »). *(question #8)*

### Phase 4
- Adresse de réception des demandes de devis + configuration SMTP Hostinger. *(question #4)*

### Phase 6
- Que devient `topentreprise.fr` (redirection page à page ou abandon) ? *(question #9)*
- Inventaire des articles du blog actuel de `topentreprise.fr` pour compléter les redirections. *(question #10)*

---

## 7. Décision d'architecture WordPress (phase 0)

> Reportée dans `CLAUDE.md` §3 par cette même phase, conformément à la consigne de fin de phase 0.

**CPT `zone` (26 entrées : 8 départements + 10 villes + 8 communes secondaires) avec champs ACF
structurés, un seul gabarit PHP par niveau.**

**CPT `prestation` (6 entrées) avec champs ACF structurés, un seul gabarit PHP.**

**Pages WordPress classiques pour les 18 pages statiques** (accueil, page pilier, index
prestations, tarifs, hub zones, page région, pourquoi-nous, fonctionnement, avis, à-propos, devis,
contact, recrutement, index conseils, plan du site, mentions légales, confidentialité, cookies).

**Type `post` natif de WordPress pour les 3 articles**, dans une catégorie « Conseils » — pas de
CPT dédié pour 3 contenus qui correspondent exactement à ce que le type natif fait déjà (taxonomie,
flux RSS, auteur, date de publication/modification déjà présents dans les données du prototype).

### Argumentation

**CPT plutôt que pages classiques pour les 26 zones.** Le prototype confirme, avec ses propres
données, que les 26 pages de zone partagent une structure identique à un seul champ de contenu
libre près : `GEO2[id]` a systématiquement les mêmes clés (`h1`, `ctaLabel`, `lede`, `direct`,
`tarif`, `example`, `review`, `blocks`, `faqs`, + `zonesIntro`/`communesIntro`/`communeLinks` pour
les départements et villes). 26 pages classiques copiées-collées à la main sont ingérables dès la
première correction transversale (ex. retirer la note Google partout, ou corriger un tarif) : il
faudrait rouvrir 26 pages une par une, avec un risque de désynchronisation immédiat. Un CPT avec un
seul gabarit PHP applique toute correction de structure ou de SEO à 26 pages à la fois.

**Un CPT unique `zone` plutôt que trois CPT séparés (`departement`, `ville`, `commune`).** Les trois
niveaux partagent la même structure de données et le même gabarit de rendu (constaté dans le
prototype : département, ville et commune utilisent la même fonction `auditRow('dept'|'city'|'secondary', …)`
et un `BOILER`/`MIN`/`FIXED_H2` par niveau, mais la même mécanique). Un champ ACF `niveau`
(département / ville / commune) avec une taxonomie hiérarchique `departement` en relation parent
suffit à modéliser la hiérarchie département → ville → commune (liens croisés, breadcrumb,
`areaServed`) sans multiplier les types de contenu. Ceci simplifie aussi le futur passage en
`noindex,follow` des communes non validées (un seul champ ACF `statut_validation` filtrable, plutôt
qu'un type de contenu entier à traiter différemment).

**CPT plutôt que pages classiques pour les 6 prestations.** Même raisonnement à plus petite échelle :
les 6 pages prestations partagent une structure à 15+ champs (`forWhom`, `tasks`, `problems`,
`exclusions`, `faqs`, `review`…) — bloquer ces champs en ACF garantit qu'aucune page prestation
n'oublie les exclusions réelles (CLAUDE.md §9 : locaux industriels/alimentaires/médicaux
nécessitant une asepsie) ni la mention que le matériel est fourni par le client, deux points que
CLAUDE.md considère comme qualifiants pour les demandes et qu'un champ ACF obligatoire empêche
d'oublier — un champ de page libre ne l'empêche pas.

**ACF plutôt que blocs natifs, sur les deux CPT.** PROJECT_INPUTS.md §3 tranche déjà dans ce sens
(« Sur un site à forte contrainte SEO, ACF est plus sûr ») et l'audit du prototype le confirme :
la structure obligatoire des pages locales imposée par la phase 2 (réponse directe → types de
locaux → services → fonctionnement → tarif → interlocutrice → zones → FAQ → CTA → liens) n'a de
sens que si elle est **impossible à casser** par un éditeur non technique. Des blocs natifs
Gutenberg permettraient à Audrey de réordonner ou supprimer une section critique (ex. les
exclusions, ou le fil d'Ariane) sans s'en rendre compte. Des champs ACF obligatoires, avec une
disposition fixée par le gabarit PHP, éliminent ce risque : Audrey édite le **contenu** de chaque
section, jamais leur présence ni leur ordre. C'est aussi plus sûr pour le SEO technique (title,
meta description, JSON-LD) : ACF expose des champs dédiés que le gabarit assemble de façon
déterministe, alors que des blocs génériques nécessiteraient une convention de nommage fragile
pour en extraire les mêmes données structurées.

**Pages classiques pour le statique, pas de CPT.** Les 18 pages statiques sont chacune unique
(pas de répétition de structure à travers 8+ instances) : les gérer en CPT n'apporterait aucun
bénéfice de cohérence et ajouterait de la complexité inutile pour un éditeur qui n'a qu'une page à
modifier. Un champ ACF « bloc de contenu flexible » (repeater) reste possible page par page si
Audrey doit pouvoir réordonner des sections sans risque — à évaluer en phase 1 selon le besoin
éditorial réel, mais sans CPT dédié.

---

## 8. Décisions prises pendant cette phase

- Architecture WordPress tranchée (§7) et reportée dans `CLAUDE.md` §3.
- Le fichier `Top-Entreprise - Prototype Ready for Code.html` (racine) est identifié comme vestige
  d'une tentative antérieure au rebranding actuel : **non modifié dans cette session**, suppression
  recommandée en phase 1 avec accord explicite d'Emmanuel.
- La branche `integration-v2` est identique à la branche courante : rien à en récupérer.

## 9. Questions ouvertes (au-delà de celles déjà dans PROJECT_INPUTS.md §12)

- Faut-il conserver la branche `integration-v2` (identique, sans historique propre) ou la supprimer ?
  Décision à prendre par Emmanuel (suppression de branche = action destructive hors périmètre de
  cette session).
- Le fichier PNG `assets/icons/f6e491bf-cdd2-4a06-aec1-f056fc79f933.png` (1536×1024, 2 Mo) n'a pas
  d'usage identifié dans le prototype actuel : à clarifier avant de le reprendre ou de l'écarter.
