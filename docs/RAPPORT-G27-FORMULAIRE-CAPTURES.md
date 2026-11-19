# G27 §10 et §13 — formulaire de devis et captures ciblées

> 20 août 2026. Suite des §4 et §11, traités précédemment.
> Verdict de la passe : **PARTIEL — ÉCARTS RESTANTS**. Il ne change pas, et ne peut pas changer
> sans validation humaine : la note Google reste sans URL de fiche vérifiable, le portrait
> d'Audrey et sa citation restent provisoires, et les témoignages restent ceux de la maquette.

---

## §10 — Formulaire de devis

### Ce qui n'a PAS été touché

Aucun élément fonctionnel n'a été retiré, déplacé hors du formulaire, ni affaibli :

| Élément | État |
|---|---|
| Jeton `tfp_quote_nonce` + `_wp_http_referer` | intacts |
| Piège à robots `tfp_site_web` | intact, hors du flux (mesuré à `x = -10 017` px, aucune place occupée) |
| Validation client **et** serveur | intactes |
| Consentement obligatoire + lien vers la politique de confidentialité | intact |
| Contexte visiteur `page_origine`, `referent`, `departement`, UTM | intacts |
| Anti-double-soumission `data-tfp-once` | intact |
| Confirmation après succès réel du serveur, en `noindex` | intacte |
| Champ `prestation` prérempli | intact |

La suite fonctionnelle du formulaire (`tests/functional/quote-form.spec.js`) passe sans
modification.

### Ce qui a été corrigé, et pourquoi c'étaient des défauts

Le détail figure dans `docs/FORMULAIRE-DIFFERENCES.md` §4, tableau par tableau, avec les valeurs
relevées des deux côtés. En résumé :

1. **Deux jeux de règles concurrents** décrivaient les mêmes champs. Le second, hérité d'un relevé
   du seul formulaire de contact, donnait aux listes déroulantes 17 px et `13px 14px` là où la
   maquette pose 16 px et `13px 15px` — vérifié en mesurant les DEUX formulaires du prototype, qui
   partagent exactement la même géométrie. Un seul jeu subsiste.
2. **La normalisation de base était trop spécifique.** `body.tfp-body select` (0,1,2) l'emportait
   sur `.tfp-field select` (0,1,1) : aucune correction dans le composant ne pouvait aboutir. Elle
   est revenue au sélecteur d'élément.
3. **Le bouton principal ignorait le rembourrage posé** : sa `min-height: max(44px, 60px)` le
   maintenait à 60 px. Il passe par les variables du composant, confiné au formulaire — les boutons
   du hero, mesurés à 60 px contre 61 dans la maquette, sont déjà conformes.
4. **Ville et code postal ne s'empilaient pas sous 560 px.** Le point de repli de la maquette a été
   trouvé en balayant les largeurs de 375 à 1440.
5. **Le titre d'étape était un titre de 20 px en gras** là où la maquette pose un indicateur de
   progression de 13 px avec sa jauge. Il reste dans le `<legend>` : c'est lui qui nomme le groupe
   de champs.
6. **Le résumé de l'étape 1 manquait entièrement.** Il est rempli depuis les champs eux-mêmes, et
   reste masqué sans JavaScript.
7. **La mention de réassurance était sous le formulaire**, séparée du CTA qu'elle rassure. Elle
   rejoint la rangée de commandes, à la place de la maquette — avec le texte qu'impose
   `CLAUDE.md` §8, pas celui du prototype.
8. **La colonne latérale** : carte Audrey, bloc téléphonique et témoignage provisoire remis aux
   valeurs relevées. Le bloc téléphonique tombe à **184,2 px, exactement la hauteur du prototype
   une fois retirée la pastille de note** — laquelle reste masquée.
9. **Les étoiles étaient en cuivre.** Le prototype les écrit en `#EAB308` dans ses vingt-quatre
   occurrences, sans exception. La correction porte sur toutes les cartes témoignage du site.

### Résultat mesuré

Hauteur du corps du formulaire, du haut du premier champ au bas de la dernière commande :

| Largeur | Maquette | Thème |
|---|---|---|
| 375 px | 879,7 px | **876,9 px — 100 %** |
| 1 440 px | 599,7 px | **596,9 px — 100 %** |

Les huit champs de l'étape 1 sont appariés un à un — corps, rembourrage et rayon identiques aux
deux largeurs. Écart de pixels sur la planche ciblée : **20,2 % à 375 px, 12,7 % à 1 440 px**,
contre 34 à 51 % avant la passe.

### Ce qui reste différent, et qui ne se corrigera pas

`docs/FORMULAIRE-DIFFERENCES.md` §2 et §5. Les deux plus visibles sur les planches :

- l'étape 2 porte le champ `prestation` que la maquette n'a pas, ce qui décale de 92 px tout ce qui
  suit — exigé par `CLAUDE.md` §8 ;
- la mention « Exemple de présentation » du témoignage provisoire vaut 49 px sur la colonne
  latérale — exigée par `CLAUDE.md` §5.5.

Le brief demandait de **distinguer clairement les différences fonctionnelles obligatoires des
défauts purement visuels**. C'est désormais la structure même du document : §2 pour les premières,
§4 pour les seconds, §5 pour les contenus de la maquette délibérément non repris. La clé de lecture
est écrite en tête.

---

## §13 — Captures ciblées

`tools/captures-ciblees.mjs` produit quatorze planches à taille utile, chacune en
maquette / WordPress / différence amplifiée ×8 et mesurée, avec l'ordre des bandes des deux côtés.
Le récapitulatif est dans `docs/CAPTURES-CIBLEES.md`.

Trois précautions ont été nécessaires pour que ces planches ne mentent pas :

1. **La zone découpée du formulaire n'est pas la balise `<form>`.** La maquette place l'indicateur
   d'étape et le chapô AVANT sa balise ; le thème les met DANS le `<fieldset>` parce qu'ils portent
   le nom accessible du groupe. Découper les deux `<form>` décalait les panneaux de 101 px et
   coloriait la planche entière — un artefact de découpe qui affichait 66 % d'écart là où les deux
   rendus se superposent.
2. **Le passage à l'étape 2 ne peut pas se faire en ne remplissant que `[required]`.** La maquette
   marque ses champs obligatoires en `aria-required` et les contrôle dans son propre gestionnaire :
   la planche comparait une étape 1 en erreur à une étape 2.
3. **Un titre réservé aux lecteurs d'écran ne compte pas dans l'ordre des bandes.** Il mesure 1 px
   et ne compose rien ; le compter faisait déclarer « ordre différent » sur des pages identiques.

### Ce que les captures ont révélé

**Corrigé dans la foulée** — la bande « Nos six prestations » du pilier sortait **53 px plus courte**
que le prototype (506,8 px contre 560,3, soit 90 %) : le prototype déclare `max-width: 620px` sur ce
titre, ce qui le replie sur deux lignes ; le thème le laissait occuper les 1 180 px de la colonne.
Huit autres titres de la maquette portent une largeur maximale déclarée, de 520 à 720 px. Le relevé
la capture désormais (`titre_largeur_max`), et le composant l'applique. La bande passe à
**548,4 px, soit 98 %**.

**Relevés, NON corrigés** — deux défauts réels, mesurés, laissés à la passe suivante parce qu'ils
demandent chacun un relevé nouveau et un rejeu complet du relevé de base, et que le brief de ce tour
portait sur §10 et §13 :

| Où | Maquette | Thème | Mesure |
|---|---|---|---|
| `/avis-clients/`, témoignage mis en avant | carte **marine** `#10263B`, texte blanc, citation 19 px | carte **blanche**, citation 25 px | 228 px contre 300 à 320 px de large |
| `/bourgogne-franche-comte/`, H1 | `clamp(30px, 4.2vw, 52px)` → **52 px** à 1 440 | `--fs-h1-zone` → **49 px** | 3 px, une seule occurrence |

Le H1 de la région relève de la même famille que les exceptions déjà posées dans `02-base.css`
(`body.tfp-type-zone.tfp-hero-w-900 h1` pour les départements) : la page région est classée
`tfp-type-zone` et hérite de l'échelle des villes.

### Ce que les captures ont confirmé conforme

Le reste de la page région est **superposable** au prototype à 1 440 px : seize titres, mêmes
tailles, mêmes largeurs, mêmes nombres de lignes — et l'exemple tarifaire donne **333 € HT/mois**
des deux côtés, à la virgule près du calcul écrit (12 h × 27 € + 9 € de gestion). Les 37,6 % de
pixels colorés de la planche viennent du décalage vertical qu'introduisent les blocs de note
masqués, pas d'une divergence de composition. Ce contrôle-là valait d'être fait : à l'échelle du
panneau, la planche donnait à croire que plusieurs titres se repliaient différemment.

---

## Revalidation

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète | **1 253 passés, 0 échec** |
| Relevé de base, 53 routes × 6 largeurs | **318/318 · 300 dans 95-105 % · 0 débordement · 0 erreur console ou réseau** (`docs/baseline-g27-s10.json`) |
| Les 18 contrôles hors bande | les **trois pages légales**, aux six largeurs — exactement les mêmes qu'avant la passe, à 111-143 %. Aucune route n'est entrée ni sortie de la bande. |
| Parité dépôt ↔ livraison | **1 265 fichiers comparés, 0 divergent**, après resynchronisation du seed et reconstruction des deux archives |

Le relevé a été rejoué **après** la correction de `titre_largeur_max`, qui touche neuf titres sur
six pages : le total dans la bande est inchangé à l'unité près, ce qui était l'objet du contrôle.

Effet mesuré des corrections sur les planches ciblées :

| Planche | Avant | Après |
|---|---|---|
| Pilier, page entière, 1 440 px | 53,9 % | **35,9 %** |
| Pilier, bande des six vignettes, 1 440 px | 33,3 % | **29,6 %** |
| Page région, 1 440 px | 37,6 % | **30,3 %** |
| Formulaire étape 1, 375 px | 34 à 51 % (relevé G26) | **20,2 %** |
| Formulaire étape 1, 1 440 px | 34 à 51 % (relevé G26) | **12,7 %** |

---

## Ce qui reste ouvert

Inchangé depuis les passes précédentes, et bloquant pour toute déclaration de production :

1. URL de la fiche Google Business, à fournir **et à valider humainement** — sans elle la note
   reste masquée ;
2. nombre réel d'avis ;
3. photo authentique d'Audrey, et validation par l'intéressée de la citation qui lui est
   attribuée ;
4. remplacement des témoignages provisoires par de vrais avis clients.

### Un échec qui n'en était pas un, et ce qu'il a appris

Le premier passage de la suite complète a donné 1 246 passés, 6 ignorés et **1 échec** :
`tests/contact.spec.js` refusait de jouer ses tests de soumission. Le message était le bon —
« les tests de soumission exigent une installation local/development : aucun test ne doit faire
partir un e-mail réel ». La cause était de mon fait : `tools/banc-local.sh --seed-only`, que j'avais
lancé pour réinjecter le contenu après la correction de `titre_largeur_max`, remonte le banc en
environnement `production`. Le garde-fou a fonctionné exactement comme prévu.

Banc remonté en `--development`, la suite complète donne **1 253 passés, 0 échec**. C'est le
chiffre à retenir ; le précédent mesurait l'environnement du banc, pas le code.
