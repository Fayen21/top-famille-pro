# G27 — rapport de clôture, en douze points

> 20 août 2026. Passe « clôture technique avant nouvelle validation humaine ».
> Branche `claude/g23-fidelite-claude-design-7doxg4`.
>
> Ce rapport est **réécrit sur l'état final**, correctifs compris — il ne raconte pas la passe dans
> l'ordre où elle s'est déroulée, mais l'état du site tel qu'il est aujourd'hui, chiffres mesurés
> après le dernier commit. Lighthouse, le relevé de base, la suite et les audits ont tous été
> rejoués pour cela : un rapport final qui recopierait des mesures antérieures à ses propres
> correctifs décrirait un site qui n'existe plus.
>
> **Verdict : PARTIEL — ÉCARTS RESTANTS.** Il n'a pas changé, et ne pouvait pas changer : les
> quatre points qui l'empêchent ne dépendent d'aucune ligne de code (§12).

---

## 1. État vérifié au départ

La passe a commencé sur `f35f680`, arbre propre, banc local remonté et servi. Les décisions en
vigueur ont été relues dans `CLAUDE.md` et `docs/DECISIONS.json` **avant** toute modification, et
une contradiction a été levée avant d'écrire quoi que ce soit : la liste de contrôle du §6 demandait
de vérifier les huit communes secondaires en `noindex,follow`, ce que la décision du 17 août —
confirmée le 19 — avait renversé. Question posée, réponse d'Emmanuel : **garder `index,follow`**.
C'est ce qui est en place, et `tests/decisions.spec.js` le verrouille.

## 2. Conformité de la documentation aux décisions

`docs/DECISIONS.json` porte désormais **six** décisions lisibles par machine — note Google masquée,
communes secondaires indexées, navigation à six entrées, commandes de hero institutionnelles,
éléments provisoires, et `/avis-clients/` hors plage de fidélité (§4). `tests/decisions.spec.js` les
confronte au **HTML réellement servi** sur les 53 routes, et refuse en outre qu'une consigne périmée
réapparaisse dans un document normatif.

Vérifié sur l'état final : la note Google reste masquée sur les 53 routes — aucun des seize motifs
interdits — les huit communes sont en `index,follow` et au sitemap, et aucune donnée structurée
`Review` ou `AggregateRating` n'est émise nulle part.

## 3. Contradiction 318 / 298 / 19 réconciliée

Les deux chiffres venaient de **deux instruments différents**, pas d'une erreur :

| | Relevé de base | Comparaison des routes |
|---|---|---|
| Contrôles | 53 × 6 largeurs = **318** | 53 × 2 largeurs × 2 mesures = **212** |
| Hors bande | 20, toutes classées | 19, toutes classées |

`tools/reconcilier-ratios.mjs` recalcule les deux, vérifie leur arithmétique interne et classe
chaque écart avec sa cause. Les trois ratios de **mots** sont des ajouts imposés par le brief,
relevés fragment par fragment : lien d'évitement, noms accessibles des déplieurs, exclusions réelles
et matériel fourni par le client (§9 de `CLAUDE.md`), mentions de contenu provisoire (§5.5),
coordonnées du pied de page.

## 4. Le relevé de base : 298 sur 318, et pourquoi c'est un progrès

Relevé final : **318/318 · 298 dans 95-105 % · 0 débordement horizontal · 0 erreur console ou
réseau**. Vingt contrôles hors plage : les trois pages légales aux six largeurs, et `/avis-clients/`
à 1 440 et 1 920 px.

L'objectif de la passe était 300. Il a été atteint en cours de route, puis **perdu en corrigeant**
`/avis-clients/`. Mesuré bande par bande, thème du commit précédent remonté sur le banc pour
comparer :

| Bande, à 1 440 px | Avant | Après | Maquette |
|---|---|---|---|
| Note / CTA | 88 | **152** | 157 |
| Avis mis en avant | 324 | **424** | 386 |
| Page entière | 2 964 (101 %) | 3 127 (106 %) | 2 938 |

Les deux bandes se **rapprochent** du prototype. La page tenait la plage grâce à des erreurs qui se
compensaient : une carte d'avis blanche et trop courte absorbait la hauteur des mentions
obligatoires. En la rendant fidèle, l'écart n'a pas été créé — il a été **révélé**.

Décomposition des +189 px, mesurée sur le rendu :

| Part | Hauteur | Nature |
|---|---:|---|
| Rangée de commandes du hero | **84 px** | Décision du 17 août, verrouillée par `tests/ecarts-structure.spec.js` |
| Deux mentions « Exemples de présentation » | **60 px** | `CLAUDE.md` §5.5, verrouillée par `tests/provisoire.spec.js` |
| Composition restante, diffuse | 45 px | Marges de bandes, aucune cause unique |

**Sans ces deux exigences, la page serait à 101 %.**

Ce qui n'a **pas** été fait : ne garder qu'une seule mention ferait repasser la page sous 105 %.
`tests/provisoire.spec.js` remonte jusqu'à la `<section>`, et les deux grilles sont dans deux
sections distinctes — aucune des deux mentions n'est superflue. Affaiblir la règle pour un ratio,
c'est maquiller la mesure. Les commandes de hero, elles, sont protégées par le brief.

**Arbitrage d'Emmanuel, 20 août : les 298 sont acceptés, c'est du contenu obligatoire.** La décision
est enregistrée sous `avis-clients-hors-plage` avec sa décomposition, et le verrou
`tests/ratios-baseline.spec.js` la reflète — seuil 298, route ajoutée à la liste des exceptions avec
son motif.

## 5. Entrée de menu « Nettoyage professionnel » supprimée

La navigation est reconstruite en **un seul tableau ordonné** : Prestations, Tarifs, Zones, Pourquoi
nous, Avis, Conseils. « Prestations » pointe sur la page pilier **et** ouvre le déplieur des six
prestations, via un lien et un bouton distincts — le lien navigue, le bouton déplie, chacun avec son
nom accessible. Sur mobile, la même séparation en deux commandes dans la rangée.

## 6. Commandes de hero institutionnelles

Conservées sur les cinq pages, conformément à la décision d'Emmanuel. Leur **présentation** est
alignée sur le système de boutons de la maquette : mesurés à 60 px de haut contre 61 dans le
prototype, ils étaient déjà conformes — c'est ce qui a évité une correction globale inutile lors du
travail sur le formulaire (§10).

## 7. Ordre de la bande du pilier et position des images

La bande « Cahier des charges, intervenants et suivi » est rendue **à sa place**, entre « Comment se
construit un cahier des charges » et « Trois situations concrètes », et non plus en dix-huitième
position. L'audit d'images ne compare plus seulement les octets mais aussi la **position** : le
repère est le triplet titre de la bande, titre précédent, titre suivant — une bande qui se déplace
emporte son propre titre avec elle, ce sont les voisins qui trahissent le déplacement.

Un créneau n'est comparé que si les **deux** côtés le renseignent ; sinon la position est déclarée
non comparable, ce qui est une information et non un verdict. Sans cette règle, quatre faux positifs
apparaissaient là où un seul côté exposait un titre.

## 8. Les six vignettes de 56 px du pilier

Reproduites et mesurées à 375, 768 et 1 440 px. Trois fausses alertes ont dû être écartées avant
d'obtenir une mesure juste : un filtre « toute image de 20 à 90 px » attrapait le logo du pied de
page ; « le premier texte de la carte » désignait le titre d'un côté et la description de l'autre ;
et les titres de la maquette sont `display: inline` — boîte de glyphes, 19 px — quand les nôtres sont
`block` — boîte de ligne, 26,7 px. En comparant les **centres de glyphes**, l'écart réel est de 0,8
à 0,9 px.

La couleur du filet des tuiles était elle aussi un relevé manquant : sur une bande bleue, la maquette
borde ses tuiles d'un bleu plus clair là où le thème posait le filet pâle des cartes blanches.

## 9. Titres et intertitres à la taille relevée

Trois corrections, toutes de même nature — une valeur déclarée par le prototype que rien ne lisait.

**Les deux intertitres hors taille** (pilier 36 → 34, région 31 → 29) : la géométrie relevée était
bien écrite dans le champ, mais aucune règle ne la lisait pour les gabarits qui rendent une bande à
la main. Le sélecteur a été élargi aux deux parents possibles.

**La largeur maximale des titres** : le prototype déclare `max-width: 620px` sur le titre de la bande
« Nos six prestations », ce qui le replie sur deux lignes ; le thème le laissait occuper les 1 180 px
de la colonne, et la bande sortait **53 px plus courte** — 90 % de la maquette. Huit autres titres du
prototype portent une largeur maximale déclarée, de 520 à 720 px, et aucun relevé ne la capturait. Le
champ `titre_largeur_max` existe désormais ; la bande passe à **98 %**.

**Le H1 de la page région** : la maquette déclare `clamp(30px, 4.2vw, 52px)` et `line-height: 1` ; le
thème appliquait l'échelle des villes. Corps de police et interligne désormais identiques aux six
largeurs — 30 · 30 · 32,3 · 43 · 52 · 52 px — et hauteurs identiques à 320, 768, 1 024, 1 440 et
1 920 px.

En cherchant pourquoi 375 px résistait, une règle que le prototype écrit en clair et que le thème
n'avait **pas du tout** est apparue :
`h1,h2,h3,h4,p,a,span,li,td,th,label,button,blockquote{overflow-wrap:break-word}`. Reprise telle
quelle. Ce qui l'accompagne — `html,body{overflow-x:clip}` — n'est **pas** repris : c'est un filet
qui masque les débordements au lieu de les corriger, et le relevé en compte zéro sur 318 contrôles ;
l'ajouter aveuglerait le contrôle qui le garantit.

Il reste 375 px, où le H1 tient sur quatre lignes contre trois. Cause **mesurée** : à 30 px et
graisse 800, la même chaîne fait **344,7 px** chez nous contre **337,4** dans la maquette, pour une
colonne de 339. C'est la fonte **variable** de Bricolage Grotesque, 2,2 % plus large que la coupe
statique 800 du prototype — l'axe `opsz` a été testé, sans effet. C'est la contrepartie directe du
§11, qui a valu 1 s de LCP ; elle n'est pas défaite pour 30 px sur une route.

## 10. Formulaire de devis

**Rien de fonctionnel n'a bougé** : jeton, piège à robots — vérifié hors flux à `x = -10 017` —
validation client et serveur, consentement, contexte visiteur, UTM, anti-double-soumission,
confirmation après succès réel du serveur.

Le corps du formulaire est à **100 %** de la maquette aux deux largeurs — 876,9 px contre 879,7 à
375, 596,9 contre 599,7 à 1 440 — et les huit champs de l'étape 1 sont appariés un à un, corps,
rembourrage et rayon identiques. Écart de pixels sur la planche ciblée : **20,2 %** à 375 px et
**12,7 %** à 1 440, contre 34 à 51 % avant la passe.

Quatre causes, toutes de la même nature :

1. **Deux jeux de règles concurrents** décrivaient les mêmes champs. Le second venait d'un relevé du
   seul formulaire de contact ; or la maquette applique la **même** géométrie aux deux formulaires —
   49 px pour une saisie, 51 pour une liste, 112 pour une zone de texte, mesuré des deux côtés.
2. **La normalisation de base était trop spécifique.** `body.tfp-body select` (0,1,2) l'emportait sur
   `.tfp-field select` (0,1,1) : aucune correction dans le composant ne pouvait aboutir tant que
   cette règle restait écrite ainsi.
3. **`min-height: max(44px, 60px)`** annulait tout rembourrage posé sur le bouton. Le correctif passe
   par les variables du composant et reste confiné au formulaire.
4. **L'indicateur d'étape et le résumé de l'étape 1 n'existaient pas.** Le premier remplace un titre
   de 20 px en gras et reste dans le `<legend>`, qui nomme le groupe de champs ; le second est rempli
   depuis les champs eux-mêmes et reste masqué sans JavaScript.

`docs/FORMULAIRE-DIFFERENCES.md` est restructuré autour de la distinction demandée : §2 écarts
fonctionnels obligatoires, §4 défauts purement visuels corrigés, §5 contenus de la maquette
délibérément non repris — dont le « ≈ 20 secondes » de l'indicateur, qu'aucune mesure ne fonde.

## 11. LCP mobile sous 2,5 s sur les sept routes

La cause n'était pas la feuille de style. Le CSS critique a été implémenté, mesuré, et **retiré** :
il dégradait le LCP de 2,87 à 3,02 s, et 3,01 s même sans aucune feuille bloquante. Le trajet
aller-retour n'était pas le goulot ; les 40 Ko en ligne portaient le HTML transféré de 12 à 19,4 Ko,
et c'est ce poids qui se payait.

La vraie cause : l'accueil pesait **341 Ko dont 264 Ko de polices**, sept fichiers au premier écran,
tous de tailles rigoureusement identiques d'une graisse à l'autre — **le même fichier variable
téléchargé sept fois**. Demandées graisse par graisse, les deux familles produisent quinze
déclarations `@font-face` pointant vers trois URL ; demandées en plage, 18 fichiers deviennent 4 et
l'accueil en charge 2. Le rendu ne peut pas changer : mêmes glyphes, même fichier.

Mesures sur l'état final, banc de production : **LCP mobile 1,66 à 1,83 s**, bureau 0,41 à 0,44 s,
**CLS 0,000 sur les quatorze mesures**.

## 12. La bande d'avis mis en avant, reproduite entièrement

Quatre relevés manquaient sur cette seule bande, et chacun produisait un rendu faux, pas seulement
plus court.

| Relevé ajouté | Ce qu'il corrige |
|---|---|
| `panneau_fond` / `rayon` / `padding` / `couleur` | le fond était mesuré sur la **carte**, jamais sur le **conteneur** — or ici c'est le `<figure>` qui porte le marine, le rayon 20 et 44 px de rembourrage. La bande sortait en cartes blanches sur fond blanc. |
| `colonnes_flex` | les deux colonnes valent 2 et 1, pas 1 et 1 : la citation tombait dans 528 px au lieu de 684 |
| taille **déclarée** de la citation | `clamp(19px, 2.2vw, 25px)` était figé à 25 px : la citation faisait 375 px de haut à 320 px de large contre 228 |
| archétype `pile` | la seconde colonne empile **deux** tuiles distinctes ; le relevé les fondait en une carte — premier avis en intitulé, étoiles du second en description, second avis en ligne de plus |

Géométrie finale, maquette contre thème :

| À 1 440 px | Maquette | Thème |
|---|---|---|
| Panneau | 1 180 × 326 | **1 180 × 326** |
| Colonne témoignage | 684 × 233 | **684 × 233** |
| Tuiles bleues | 2 × 372 × 114 | **2 × 372 × 114** |

À 320 px le panneau fait 725 contre 733 : le conteneur de page est 8 px plus large que celui du
prototype — écart pré-existant — et la seconde tuile y perd une ligne.

Trois garde-fous ont failli avaler ces corrections en silence, et ils ont été **élargis plutôt que
contournés** : un panneau n'est relevé que s'il **tranche** sur ce qu'il y a derrière — sans quoi six
bandes auraient été repeintes de leur propre couleur en n'y gagnant que du rembourrage ; le filtre du
composant témoignage n'acceptait que des pixels et rejetait le `clamp` sans rien dire ; et le filtre
des notes interdites ne voyait pas les textes des tuiles, qui sont pourtant du contenu comme un
autre.

Un quatrième a fait mieux que les avaler, il les a **refusées**. `tests/g26.spec.js` exige que la
mention « exemples de présentation » soit atteignable en trois remontées depuis une rangée
d'étoiles — borne délibérée, sans laquelle une seule mention sur la page validerait n'importe
quelles étoiles. Le premier balisage de la pile imbriquait un `<ul>` de trop. Le niveau a été
supprimé, pas la borne élargie : la pile est le `<li>` lui-même, ce qui est aussi plus proche de la
maquette et évite d'annoncer deux niveaux de liste pour un seul groupe.

---

## Batterie de vérifications — état final

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète | **1 253 passés, 0 échec** |
| Relevé de base, 53 routes × 6 largeurs | **318/318 · 298 dans 95-105 % · 0 débordement · 0 erreur console** |
| Lighthouse, 7 routes × mobile/bureau | **14/14 conformes** — perf mobile 99-100, bureau 100, a11y / bonnes pratiques / SEO **100 partout** |
| Cœurs Web | LCP mobile **1,66-1,83 s** · CLS **0,000** sur 14 mesures |
| Captures ciblées, 14 planches | ordre des bandes **identique des deux côtés sur les quatorze** |
| Données structurées | conformes sur les 53 routes |
| Cibles tactiles (WCAG 2.5.8 AA) | **aucune violation** |
| Images par rôle | **164 images, 0 écart** |
| Maillage interne | aucun lien mort, aucune page orpheline |
| Lint PHP | 82 fichiers |
| Parité dépôt ↔ livraison | **1 265 fichiers comparés par empreinte, 0 divergent** |

### Un verrou qui validait un relevé vieux de trois passes

`tests/ratios-baseline.spec.js` lit `docs/baseline.json`. Ce fichier datait de `f35f680` : les
relevés successifs de la passe avaient été écrits sous d'autres noms via `--sortie=`, pour ne pas
écraser la référence avant de savoir si le résultat tenait. Précaution raisonnable, effet
désastreux — **la suite passait au vert sur un état du site qui n'existait plus**, et plusieurs
exécutions complètes n'ont donc rien contrôlé sur ce point.

Deux corrections : le relevé courant est devenu la référence, et `tools/baseline.mjs` avertit
désormais en clair quand il écrit ailleurs que `docs/baseline.json`, en donnant la commande pour
promouvoir le fichier. Un contrôle qui ne contrôle plus rien est pire qu'un contrôle absent : il
rassure.

### Comment lire les taux des planches ciblées

Le taux est la proportion de pixels dont l'écart de luminance dépasse le seuil de perception. **Il
n'est pas un score de fidélité** : un titre désormais conforme est plus haut, tout ce qui suit se
décale, et un décalage vertical colorie l'intégralité de la colonne.

La planche d'`/avis-clients/` à 320 px l'illustre : **38,4 %** avant la carte marine, **31,0 %** une
fois le panneau posé — la bande se superposait enfin — puis **37,5 %** après la séparation des deux
tuiles, qui allonge la page. La mesure qui conclut est la géométrie de la bande, pas le taux.

### Les écarts qui restent, et pourquoi

**Trois pages légales**, hors plage aux six largeurs (111-143 %). Ce n'est pas un défaut de
composition : les mentions de l'ancien site ont dû être **réécrites** et non recopiées
(`CLAUDE.md` §5.7). `docs/AUDIT-PAGES-LEGALES.md` mesure la part ajoutée ligne à ligne ; le résidu
reste négatif partout, c'est-à-dire entièrement expliqué.

**`/avis-clients/` à 1 440 et 1 920 px** (106 %) : décomposé au §4, accepté par Emmanuel le 20 août.

### Les quatre bloqueurs, qui ne dépendent pas du code

1. **URL de la fiche Google Business**, à fournir **et à valider humainement**. La note 5,0/5 est
   réelle et enregistrée ; elle reste invisible tant que les trois conditions ne sont pas réunies.
   Aucun code ne peut prouver depuis le serveur qu'une fiche appartient à Top-Famille Pro — le
   contrôle porte sur la **forme** de l'adresse, et l'écran de saisie le dit.
2. **Nombre réel d'avis.** Le compteur de 47 du prototype est supprimé sans exception.
3. **Photo authentique d'Audrey**, et **validation par l'intéressée** de la citation qui lui est
   attribuée. C'est le seul contenu du site qui fasse parler une personne réelle.
4. **Remplacement des témoignages provisoires** par de vrais avis clients. Tous portent
   `data-tfp-provisional` et leur mention visible ; une seule requête les retrouve.

Tant que ces quatre points sont ouverts, le verdict reste **PARTIEL — ÉCARTS RESTANTS**, et rien ne
doit être déclaré `PRODUCTION READY`.
