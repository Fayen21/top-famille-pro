# G26 — rapport de passe

> Passe ouverte après le **refus** de la validation humaine du 17 août 2026.
> Branche `claude/g23-fidelite-claude-design-7doxg4`. Rien n'est fusionné, rien n'est déployé.

---

## 1. Commit de départ, branche, état du dépôt

| | |
|---|---|
| Commit de départ | `7e6dc04` — « G25 — checkpoint de clôture : six vignettes exactes, sept différences justifiées, dossier de validation livré » |
| Branche de travail | `claude/g23-fidelite-claude-design-7doxg4` |
| Distante | `origin/claude/g23-fidelite-claude-design-7doxg4`, avance en fast-forward uniquement |
| Session concurrente | aucune — arbre propre au départ, aucune divergence avec la distante |
| Correction G25 préservée | oui — les six vignettes 56 px du pilier sont éprouvées à chaque passage de `tests/g25.spec.js` (sources, ordre, géométrie aux trois largeurs) |
| Interdits respectés | aucun `reset`, aucun `rebase`, aucun `push --force`, aucune réécriture d'historique, rien fusionné dans `main`, aucun déploiement, aucune modification DNS |

---

## 2. Fichiers modifiés et commits

Douze commits, du plus ancien au plus récent :

| Commit | Objet |
|---|---|
| `532c9f9` | Suppression de la note Google non vérifiée et du compteur d'avis venu du seed (§7) |
| `0ea88cd` | Premières corrections d'images par rôle (§3) |
| `62e5794` | Panneau de différence des triptyques réécrit et éprouvé (§2) |
| `c2b9d5e` | Composition de `/a-propos/` (§4) |
| `61f8178` | Parcours de `/recrutement/` et taille des intertitres (§5) |
| `5d5d991` | Pied de page et logos repris sur le relevé (§8) |
| `ac6cc46` | Formulaire : présentation, protocole de capture, différences documentées (§6) |
| `0f5debb` | Images : zéro écart sur les 53 routes, appariées sur leurs octets (§3) |
| `9994d8f` | Revalidation : badge de hero, pré-pied, débordement horizontal (§9) |
| `e28d813` | Contraste du rappel téléphonique du pré-pied (§9) |
| `b2f3951` | 112 comparaisons régénérées, dossier de validation, rapport de passe (§9 et §10) |
| *(ce commit)* | Décision d'Emmanuel du 17 août 2026 inscrite au registre et verrouillée par un test |

Principaux fichiers touchés : `tools/lib/diff-visuel.mjs` (nouveau), `tools/audit-images-role.mjs`,
`tools/mapper-photos-maquette.mjs` (nouveau), `tools/sonde-composition.mjs` (nouveau),
`tools/dump-bandes.mjs` (nouveau), `tools/compare-formulaire.mjs` (réécrit),
`tools/generate-pages.mjs`, `build/optimize-images.mjs`,
`wp-content/themes/topfamillepro/` (gabarits `/a-propos/`, `/recrutement/`, `/contact/`,
`/demande-de-devis/`, composant `static-blocks`, `components.php`, `images.php`,
`testimonials.php`, pied de page, feuilles `00-tokens`, `03-layout`, `04-components`, `05-home`),
`tests/` (`diff-visuel`, `g23`, `g25`, `fidelite`, `contact`, `functional/quote-form`),
`docs/FORMULAIRE-DIFFERENCES.md` et `docs/FORMULAIRE-CAPTURES.md` (nouveaux),
`docs/ECARTS-MAQUETTE-AUTORISES.md` et `tests/ecarts-structure.spec.js` (registre et verrou des
deux écarts de structure validés).

---

## 3. Correction de chaque motif de refus

### 3.1 « Le troisième panneau des triptyques est pratiquement uniforme malgré des différences majeures »

**Cause trouvée.** Le générateur composait `difference` puis `negate()`. Sur deux rendus proches,
l'écart par pixel ne vaut que quelques niveaux : après inversion, tout ressort à 250-255,
c'est-à-dire un panneau blanc. Une image manquante ou un bloc déplacé y était invisible.

**Correction.** `tools/lib/diff-visuel.mjs` calcule l'écart de luminance perçue octet par octet,
l'amplifie d'un facteur **écrit dans l'image**, le rend en fausse couleur magenta, et **mesure** la
proportion de pixels au-delà du seuil de perception — taux inscrit lui aussi sur le panneau. Deux
captures de largeurs différentes sont refusées au lieu d'être superposées. `removeAlpha()` avant le
parcours brut : sharp ajoute un canal alpha à la composition, et un pas de trois octets ne lisait
que les trois quarts de l'image.

**Preuve** — voir §5.

### 3.2 Images

Traité en §4 ci-dessous : les trois manques nommés sont corrigés, et l'audit par empreinte en a
trouvé huit autres.

### 3.3 « `/a-propos/` : composition inversée »

| Point | Avant | Après |
|---|---|---|
| Ordinateur | image à droite, contenu à gauche | **image à gauche, contenu à droite** |
| Mobile | image après le texte | **image avant le texte** |
| Citation | sans fond, fondue dans la page | **bande #EDF5F6 pleine largeur**, typographie relevée (25 px de titrage, attribution 17 px gras) |
| Attribution | « Audrey » et « · Top-Famille Pro » sur deux lignes | **une seule ligne**, comme la maquette |
| Quatre valeurs | coiffées de « Exemples de présentation — témoignages authentiques en cours d'intégration » | **mention retirée** : le repère de témoignage cherchait un guillemet n'importe où, et « satisfaction garantie » cité au fil d'une phrase suffisait |
| Commandes | six lignes de texte pleine largeur empilées | **deux rangées de boutons**, aux largeurs de la maquette au pixel (316/139, puis 200/203/120/175) |
| « ☎ Parler de mes locaux avec Audrey » | **absent** — le relevé jetait les liens `tel:` | **rétabli** |
| Mention du portrait provisoire | présente | **conservée**, visible et attribuée |

La correction de l'ordre est un ordre de **DOM**, pas une propriété `order` : l'ordre visuel et
l'ordre de lecture au clavier restent solidaires.

### 3.4 « `/recrutement/` affiche des CTA commerciaux génériques à la place du parcours de recrutement »

| Point | Avant | Après |
|---|---|---|
| Hero | « Demander mon devis » + « Appeler Audrey » | **« Envoyer ma candidature » + « ☎ 06 36 17 63 39 »**, aux dimensions relevées (238×60 et 184×60 contre 236 et 185) |
| Destination de la candidature | — | **site carrière** `careers.werecruit.io/fr/top-famille`, comme `CLAUDE.md` §8 l'impose — et non le `mailto:` du prototype |
| Second formulaire de candidature | — | **aucun n'est créé** : c'est un lien |
| Panneau des étapes | carte **blanche** | **carte marine** #174A81, texte en clair (contraste mesuré, WCAG 2.2 AA) |
| Les trois étapes | trois paragraphes | **liste ordonnée**, numéro turquoise 16 px/800 à gauche du libellé 14,5 px, écart 12 px — les valeurs de la maquette |
| Composition responsive | — | **conforme** : H1 → commandes → visuel à 375 px, comme le prototype |

### 3.5 Formulaires

Traité en §6 ci-dessous.

### 3.6 « Note Google non vérifiée »

Traité en §7 ci-dessous.

### 3.7 Audit complémentaire — logo et pied de page

| Point | Avant | Après |
|---|---|---|
| Intitulés de colonne | 15 px blanc, sans capitales | **12,5 px, graisse 700, CAPITALES, interlettrage 1 px, turquoise** — cuivre pour « Informations » |
| Téléphone du pied | 13 px, comme l'adresse | **18 px gras blanc** — c'est un point de conversion |
| Liens de colonne | 13 px | **15 px** |
| Renvois de colonne | gris de lien, graisse 600 | **cuivre, graisse 700** |
| Nom de département | 14 px, couleur des liens | **11,5 px, graisse 600, gris de second plan** — il coiffe ses villes, il ne les concurrence plus |
| « Villes principales par département » | 13 px | **10,5 px capitales** |
| Colonne de marque | 411 px laissés par la grille | **bornée à 320 px** |
| Barre légale | sans fond, à 40 px des bords | **bande #0B1B2B, contenu aligné sur le conteneur du site** |
| Logo d'en-tête | 320 px (densité 2) | **465 px (densité 3)** |
| Logo du pied | 120 px | **180 px** |

**Aucun écart visible n'a été reclassé en éditorial.** Les deux points qui restaient ouverts —
navigation principale et commandes de hero — ont été soumis à Emmanuel et **tranchés le 17 août
2026** : voir §9.2 et §9.3.

---

## 4. Images par rôle et par empreinte

`tools/audit-images-role.mjs` apparie les images **par rôle** (logo d'en-tête, hero, éditoriale,
vignette, logo de pied) dans l'ordre du flux, et compare le **SHA-256** du fichier source du slot
aux octets réellement embarqués par la maquette. `tools/mapper-photos-maquette.mjs` établit la table
des sources sur les octets, sans jamais deviner.

**Résultat final : 164 images comparées sur les 53 routes, `0 écart`.**
(25 écarts au premier relevé de cette passe, 11 après la table corrigée, 0 après les cinq
corrections ci-dessous.)

Le tableau complet route par route — rôle, empreinte maquette, empreinte WordPress, slot, verdict —
est dans **`docs/AUDIT-IMAGES-ROLE.md`** et **`docs/audit-images-role.json`**. Extrait des écarts
qui ont été fermés :

| Route | Rôle | Empreinte maquette | Empreinte WordPress avant | Cause |
|---|---|---|---|---|
| `#/` (bloc Audrey) | éditoriale | `f0e30f…` | autre portrait | Slot dédié `audrey-portrait` |
| `#/nettoyage-professionnel` | éditoriale | présente | **absente** | Bande « Cahier des charges, intervenants et suivi » sans visuel |
| `#/ville/dijon` … 18 villes | hero | une photo par ville | la même partout (`article-3`) | Un slot `ville-<slug>` par ville |
| `#/service/bureaux` | hero | `0d32ae67…` | `91b93f91…` | **Photos croisées** avec les héros de ville |
| `#/ville/auxerre` | hero | `91b93f91…` | `0d32ae67…` | idem, dans l'autre sens |
| `#/service/cabinets`, `coproprietes`, `meubles`, `ponctuel` | hero | quatre photos distinctes | un visuel générique partagé | Un slot par prestation |
| `#/` (cartes de prestation) | éditoriale | `91b93f91…`, `46a86c7e…` | slots des pages de prestation | Slots `accueil-*` dédiés |
| `#/contact`, `#/demande-de-devis` | vignette | `f9c6cb81…` | `c6c51783…` | Troisième portrait de stock, distinct de celui de `/a-propos/` |
| `#/` (témoignage) | vignette | `e73f0f09…` | **absente** | Vignette d'auteur 44 px, ronde |
| `#/article/*` | hero | mêmes octets des deux côtés | faux écart | `closest('header')` classait le `<header>` d'un `<article>` comme en-tête de site |

Les logos font l'objet d'un contrôle séparé (§3.7) : mêmes octets source, résolution portée de la
densité 2 à la densité 3.

---

## 5. Preuve que le panneau de différence fonctionne

`tests/diff-visuel.spec.js`, **6 tests verts**, sur une fixture construite dans le test : un fond
uniforme `#f4f7f8` de 240 × 180, et le même fond à un carré de 60 × 60 près, d'une teinte distante
de 15 niveaux seulement.

| Ce qui est éprouvé | Attendu | Mesuré |
|---|---|---|
| La zone modifiée ressort du fond | écart de luminance > 25 | satisfait |
| Le taux correspond à la surface modifiée (60×60 sur 240×180 = 8,3 %) | entre 7 et 10 % | satisfait |
| L'amplification est annoncée dans l'image | > 1 | ×8, écrite sur le panneau |
| Le panneau n'est pas uniforme (mesuré **sous** l'étiquette) | contraste > 40 | satisfait |
| Deux rendus identiques | 0 %, aucune coloration | satisfait |
| Une page plus courte d'un côté | > 45 % | satisfait |
| Deux largeurs différentes | **refus**, pas de maquillage | exception levée |
| Bruit d'encodage d'un niveau | 0 % | satisfait |

**Le générateur G25 est conservé comme témoin** (`panneauDifferenceHerite`) et passé aux mêmes
assertions sur la même fixture : il **ne les satisfait pas** — écart de luminance sous 25, contraste
sous 40. La démonstration est faite, pas affirmée : le test qui l'établit échoue avec l'ancien
générateur et réussit avec le nouveau.

---

## 6. Formulaires

**Contrôles préservés et vérifiés** sur banc `--development` : jeton `tfp_quote_nonce`, piège à
robots `tfp_site_web`, consentement obligatoire, validation client **et** serveur, contexte UTM et
page d'origine, limitation des soumissions, confirmation affichée seulement après succès réel et
page de confirmation en `noindex`. 12 tests verts sur le formulaire de devis, 20 sur le contact.

**Un point annoncé comme acquis ne l'était pas** : l'anti-double-soumission n'existait que sur le
formulaire de contact. Le formulaire de devis ne portait pas `data-tfp-once`, et un double clic
produisait deux demandes identiques. Il l'a désormais, et le gestionnaire ignore une soumission
annulée par la validation — sans quoi une étape 1 incomplète aurait grisé le bouton et bloqué le
visiteur. Les deux comportements sont éprouvés, dans les deux sens.

**Présentation rapprochée** : liste déroulante pour le régime (comme la maquette), libellés du
prototype, neuf textes indicatifs et trois aides de saisie rétablis. Détail en
`docs/FORMULAIRE-DIFFERENCES.md` §1.

**Protocole de capture** (`tools/compare-formulaire.mjs`) : un jeu de données unique injecté à
l'identique des deux côtés ; l'étape 2 **vérifiée avant capture** des deux côtés, et la capture
**refusée** si l'un des deux n'y est pas parvenu ; même position de défilement ; en-tête collant
neutralisé par la même règle ; polices chargées. Le rapport `docs/FORMULAIRE-CAPTURES.md` porte,
pour chaque capture, les valeurs **réellement présentes dans les champs des deux côtés**.

**Ce rapport n'affirme plus « mêmes champs ».** `docs/FORMULAIRE-DIFFERENCES.md` §2 liste, une par
une, les différences fonctionnelles imposées : huit champs de contexte et de sécurité, le champ
`prestation` exigé par `CLAUDE.md` §8, la liste fermée des créneaux, six contrôles plus stricts et
l'ordre des commandes d'étape 2. Les écarts de pixels mesurés (34 à 51 %) **incluent** ces
différences : un écart nul serait ici le signe d'une erreur de protocole, pas d'une fidélité
parfaite.

---

## 7. Preuve que la note Google non vérifiée a disparu

**Garde de vérifiabilité** dans `includes/reassurance-settings.php` : la note n'est exposée aux
gabarits que si l'**URL de la fiche Google** est saisie avec elle. Une note de plateforme tierce
affirmée sans lien vers sa source est une allégation que le visiteur ne peut pas contrôler. La
garde est **réversible** : le jour où l'URL sera fournie, la note revient d'elle-même.

Un second défaut a été trouvé au passage : le **compteur d'avis** du prototype revenait par le seed,
et aucune garde de composant ne l'arrêtait. `tfp_fragment_note_interdite()` filtre désormais les
cartes qui portent un compteur d'avis ou une note non vérifiable, avant rendu.

**Recherche sur le HTML servi des 53 routes** :

| Recherche | Occurrences |
|---|---|
| `"@type": "Review"` | **0** |
| `aggregateRating` / `ratingValue` | **0** |
| « sur Google », « 5,0/5 », « 5.0/5 » | **0** |
| compteur d'avis (`\d+ avis`) | **0** |
| `href="#"` | **0** |
| `[À COMPLÉTER]` visible | **0** |
| ancien tarif commercial | **0** |

**Test global** : `tests/g26.spec.js`, 55 tests, éprouve les 53 routes une par une — ni note, ni
étoiles hors d'un témoignage provisoire portant `data-tfp-provisional` **et** une mention visible ;
aucune donnée structurée `Review` ni `AggregateRating` ; et un test au niveau PHP qui prouve que la
garde est réversible (sans URL → `null`, avec URL → 5).

Les témoignages provisoires restent affichés, avec leur mention visible, comme la décision du
10 août 2026 le prévoit.

---

## 8. Résultats des tests et des audits

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète (banc `--development`) | **1063 tests verts**, 0 échec |
| axe-core WCAG 2.2 AA (7 familles) | ✅ aucune violation |
| Navigation clavier réelle (drawer, sous-menus, barre CTA, formulaire) | ✅ 12 tests verts |
| `tests/diff-visuel.spec.js` | ✅ 6 tests verts, témoin G25 en échec comme attendu |
| `tests/g26.spec.js` | ✅ 55 tests verts |
| Lint PHP sur tout le thème | ✅ aucune erreur |
| `node --check` sur tous les outils et tests | ✅ aucune erreur |
| Construction des images (`build/optimize-images.mjs`) | ✅ manifeste régénéré |
| Audit d'images par rôle | ✅ **164 images, 0 écart** |
| Audit WCAG 2.2 AA 2.5.8 (cibles tactiles) | ✅ **aucune violation** (2 avant cette passe) |
| Audit des données structurées | ✅ conformes |
| Relevé de base, 6 largeurs | **318/318 contrôles · 298 dans 95-105 % · 0 débordement · 0 erreur console ou réseau** |
| LCP (routes touchées) | médian **172 à 220 ms**, ressource découverte à ~50 ms, `fetchpriority=high` sur elle seule, aucun double téléchargement |
| CLS | 318 contrôles, **maximum 0,0048**, aucun au-dessus de 0,010 |
| Lighthouse, 7 routes × mobile/bureau | **14 mesures, 0 sous la cible** — performance mobile 95-98, bureau 100, accessibilité **100**, bonnes pratiques 100, SEO 100 |

Deux régressions ont été introduites puis corrigées **dans cette passe**, et sont signalées ici
plutôt que passées sous silence :

1. un **débordement horizontal de 263 px** sur l'index des zones, causé par une carte-lien promue
   bouton par le nouveau repère d'archétype ; corrigé, et `.tfp-btn` reçoit `max-width: 100%` pour
   que le cas ne puisse plus se reproduire ;
2. l'**accessibilité Lighthouse tombée de 100 à 96** sur les quatorze audits, à cause du contraste
   du rappel téléphonique du pré-pied ; corrigé, contraste mesuré 13,44:1.

**L'audit axe-core de la suite n'a pas vu ce second défaut** alors qu'il éprouve `/` avec les règles
`wcag2aa`. Seul Lighthouse l'a relevé. Une suite verte ne vaut donc pas preuve de contraste, et les
deux mesures restent nécessaires.

---

## 9. Écarts qui subsistent

### 9.1 Écarts assumés, avec leur motif

| Écart | Où | Motif |
|---|---|---|
| Pages légales 112 à 144 % de la hauteur du prototype | `/mentions-legales/`, `/politique-de-confidentialite/`, `/gestion-des-cookies/` | Texte réglementaire réel, plus long que celui de la maquette. Écart de longue date, assumé. |
| `/pourquoi-nous/` à 106 % (375 px) | 1 contrôle | Rangée de commandes du hero, absente de la maquette — voir 9.3. |
| `/avis-clients/` à 94 % (320 px) | 1 contrôle | À un point de la plage. |
| LCP mobile 2,34 à 2,87 s | 7 routes | Au-dessus de la cible de 2,5 s de `CLAUDE.md` §8 sur quatre routes. **Valeurs identiques à celles de G25** : écart de longue date, pas une régression de cette passe. Le score de performance Lighthouse reste à 95-98. |
| Différences fonctionnelles du formulaire | `/demande-de-devis/` | Listées une par une dans `docs/FORMULAIRE-DIFFERENCES.md` §2. |
| Deux intertitres sur 108 à la mauvaise taille | `/nettoyage-professionnel/` (36 → 34), `/zones-intervention/bourgogne-franche-comte/` (31 → 29) | Rendus par des gabarits dédiés, hors du composant qui porte le relevé. 106 sur 108 sont désormais exacts, contre 38 avant. |

### 9.2 Point TRANCHÉ par Emmanuel le 17 août 2026 — navigation principale

La navigation compte **sept entrées contre six dans la maquette**, dans un autre ordre et avec
d'autres libellés :

| Maquette | Thème |
|---|---|
| Prestations ▾, Tarifs, Zones ▾, Pourquoi nous, Avis, Conseils | Prestations ▾, Zones ▾, **Nettoyage professionnel**, Nos tarifs, Pourquoi nous, Avis clients, Conseils |

Conséquence mesurée : la barre de navigation occupe 702 px au lieu de 524 à 1440 px, passe à la
ligne, et l'en-tête gagne **22 px** sur les 53 routes.

**Décision d'Emmanuel : l'entrée est CONSERVÉE.** La page pilier est la porte d'entrée du site sur
sa requête principale ; la retirer du menu aurait été un arbitrage de référencement, pas une
correction de fidélité. L'écart est donc inscrit au registre
`docs/ECARTS-MAQUETTE-AUTORISES.md` §7 — le seul document qui distingue une différence voulue d'un
défaut — et verrouillé par `tests/ecarts-structure.spec.js`, pour qu'une passe ultérieure ne le
« corrige » pas de bonne foi.

### 9.3 Point TRANCHÉ par Emmanuel le 17 août 2026 — rangées de commandes de hero

Le prototype ne pose de commandes dans le hero que sur l'accueil, la page pilier, la page région,
les prestations, les villes, l'index des zones et le recrutement. Le thème en ajoute sur **cinq
routes institutionnelles** : `/a-propos/`, `/pourquoi-nous/`, `/notre-fonctionnement/`,
`/avis-clients/` et `/prestations/`.

Le **badge région** relevait du même constat sur sept routes ; il a été retiré, car c'est un élément
purement décoratif dont le lien existe déjà dans le menu et dans le pied. Les commandes, elles, sont
des points de conversion : les retirer est une décision commerciale, pas une correction de fidélité.
**Décision d'Emmanuel : les commandes sont CONSERVÉES**, au titre de `CLAUDE.md` §4 (modification
de structure autorisée si elle améliore objectivement la conversion, à condition d'être signalée).
L'écart est inscrit au registre `docs/ECARTS-MAQUETTE-AUTORISES.md` §8 et verrouillé par
`tests/ecarts-structure.spec.js`, qui éprouve aussi que le badge région, lui, reste retiré : la
décision porte sur les commandes, pas sur le badge.

### 9.4 Bloqueurs de mise en ligne, inchangés

- Données d'immatriculation non confirmées par Kbis — bloqueur, `CLAUDE.md` §5.7.
- Nombre réel d'avis Google et URL de la fiche — sans eux, la note reste retirée.
- Photo authentique d'Audrey — les portraits restent des visuels d'illustration déclarés.
- Citation attribuée à Audrey — **à valider par l'intéressée avant mise en ligne**.
- Huit communes secondaires en `noindex,follow` tant qu'Audrey ne les a pas validées.

### 9.5 Point de documentation à arbitrer

`CLAUDE.md` §5.5 énonce toujours que la note de 5,0/5 est confirmée et affichable. **G26 §7 renverse
cette instruction.** Le fichier porte la consigne de ne pas être modifié sans validation d'Emmanuel :
la contradiction est donc signalée ici plutôt que corrigée d'autorité.

---

## 10. Verdict

**`PARTIEL — ÉCARTS RESTANTS`.**

Les six motifs de refus du 17 août 2026 sont traités et chacun est accompagné d'une mesure
vérifiable : le panneau de différence est éprouvé sur une fixture où l'ancien générateur échoue ;
les images sont appariées sur leurs octets, 164 comparées et zéro écart ; les compositions de
`/a-propos/` et de `/recrutement/` sont relevées et reproduites ; le protocole de capture des
formulaires est explicite et leurs différences fonctionnelles sont documentées une par une ; aucune
note Google non vérifiée ne subsiste sur les 53 routes ; le pied de page et les logos sont repris au
relevé.

Les deux points de composition qui restaient ouverts ont été **tranchés par Emmanuel le 17 août
2026** (§9.2 et §9.3) : navigation et commandes de hero sont conservées, inscrites au registre des
écarts assumés et verrouillées par un test.

Le verdict reste néanmoins `PARTIEL — ÉCARTS RESTANTS`, et le restera jusqu'à une **validation
humaine des captures** : les bloqueurs de mise en ligne du §9.4 sont inchangés — données
d'immatriculation non confirmées par Kbis au premier rang — et une contradiction subsiste entre
`CLAUDE.md` §5.5 et le travail demandé en §7 de cette passe.
