# G27 — rapport de clôture, en douze points

> 20 août 2026. Passe « clôture technique avant nouvelle validation humaine ».
> Branche `claude/g23-fidelite-claude-design-7doxg4`.
>
> **Verdict : PARTIEL — ÉCARTS RESTANTS.** Il n'a pas changé de la passe et ne pouvait pas changer :
> les quatre points qui l'empêchent ne dépendent d'aucune ligne de code (§12).

---

## 1. État vérifié au départ

La passe a commencé sur `f35f680`, arbre propre, banc local remonté et servi. Les décisions en
vigueur ont été relues dans `CLAUDE.md` et `docs/DECISIONS.json` avant toute modification, et une
contradiction a été levée **avant** d'écrire quoi que ce soit : la liste de contrôle du §6 demandait
de vérifier les huit communes secondaires en `noindex,follow`, ce que la décision du 17 août —
confirmée le 19 — avait renversé. Question posée, réponse d'Emmanuel : **garder `index,follow`**.
C'est ce qui est en place, et `tests/decisions.spec.js` le verrouille.

## 2. Conformité de la documentation aux décisions

`docs/DECISIONS.json` porte cinq décisions lisibles par machine — note Google masquée, communes
secondaires indexées, navigation à six entrées, commandes de hero institutionnelles, éléments
provisoires. `tests/decisions.spec.js` les confronte au **HTML réellement servi** sur les 53 routes,
et refuse en outre qu'une consigne périmée réapparaisse dans un document normatif.

Vérifié cette passe : la note Google reste masquée sur les 53 routes (aucun des seize motifs
interdits), les huit communes sont en `index,follow` et au sitemap, et aucune donnée structurée
`Review` ou `AggregateRating` n'est émise nulle part.

## 3. Contradiction 318 / 298 / 19 réconciliée

Les deux chiffres venaient de **deux instruments différents**, pas d'une erreur :

| | Relevé de base | Comparaison des routes |
|---|---|---|
| Contrôles | 53 × 6 largeurs = **318** | 53 × 2 largeurs × 2 mesures = **212** |
| Hors bande | 18, toutes légales | 19, toutes classées |

`tools/reconcilier-ratios.mjs` recalcule les deux, vérifie leur arithmétique interne et classe
chaque écart avec sa cause. Les trois ratios de **mots** sont des ajouts imposés par le brief,
relevés fragment par fragment : lien d'évitement, noms accessibles des déplieurs, exclusions réelles
et matériel fourni par le client (§9), mentions de contenu provisoire (§5.5), coordonnées du pied.

## 4. Retour au-dessus de 300 contrôles sur 318

**Atteint, et tenu.** Relevé final : **318/318 · 300 dans 95-105 % · 0 débordement horizontal ·
0 erreur console ou réseau**. Les 50 routes non légales tiennent la plage **aux six largeurs**.

Deux défauts corrigés à la cause, pas au symptôme :

- `/avis-clients/` (94 % à 320 px) : le générateur ne relevait **qu'une** taille de description par
  grille là où le prototype compose ses avis sur trois niveaux typographiques. Le rendu était
  *faux*, pas seulement court. Un archétype `temoignage` est relevé à part.
- `/pourquoi-nous/` (106 % à 375 px) : 82 px venaient d'un **surtitre de hero vide** qui gardait sa
  `min-height` alors que ni le badge région ni la note ne l'alimentaient plus.

## 5. Entrée de menu « Nettoyage professionnel » supprimée

La navigation est reconstruite en **un seul tableau ordonné** : Prestations, Tarifs, Zones,
Pourquoi nous, Avis, Conseils. « Prestations » pointe sur la page pilier **et** ouvre le déroulant
des six prestations, par un lien et un bouton distincts — le lien reste un lien, le bouton porte
`aria-controls` et `aria-expanded`. Même découpe sur la navigation mobile. Huit tests dédiés.

## 6. Commandes de hero institutionnelles

**Conservées**, sur instruction explicite d'Emmanuel. Mesurées : le système de boutons est déjà
celui de la maquette — 60 px de haut contre 61 relevés. Aucune correction n'était due ; la vérifier
a évité d'en fabriquer une.

## 7. Ordre de la bande du pilier et position des images

La bande « Cahier des charges, intervenants et suivi » est rendue **à sa place**, entre « Comment se
construit un cahier des charges » et « Trois situations concrètes », et non plus après la FAQ.
L'audit d'images ne se contente plus de l'empreinte du fichier : `tools/lib/position-bande.mjs`
compare le **triplet** titre de la bande / titre précédent / titre suivant — une image peut être le
bon fichier au mauvais endroit, et l'empreinte seule le déclarait conforme. Un créneau n'est comparé
que si les deux côtés le renseignent, faute de quoi la position est dite *non comparable*, ce qui est
une information et non un verdict.

Audit final : **164 images, 0 écart**.

## 8. Les six vignettes de 56 px du pilier

Reproduites et mesurées à 375, 768 et 1440 px. La cause du dernier écart était un **relevé manquant**
— la couleur du filet des tuiles, que le générateur ne capturait pas. Trois faux constats ont été
écartés en chemin, et c'est ce qui a demandé le plus de soin : un filtre « toute image de 20 à 90 px »
attrapait le logo du pied de page, un repère « premier texte de la carte » désignait le titre d'un
côté et la description de l'autre, et la maquette compose ses titres en `display: inline` quand le
thème les compose en `block` — comparer les boîtes de ligne fabriquait un décalage de 3 px qui
n'existait pas. Comparés au **centre des glyphes**, l'écart réel est de 0,8 à 0,9 px.

## 9. Les deux intertitres hors taille

Pilier 36 → 34 px et région 31 → 29 px : corrigés. La cause était une question de spécificité —
`body.tfp-type-pilier h2` (0,1,1) l'emportait sur `.tfp-static-block__titre` (0,1,0), si bien que la
valeur relevée était bien posée mais jamais lue. Le sélecteur porte désormais deux classes.

## 10. Formulaire de devis

**Corps du formulaire à 100 %** de la maquette aux deux largeurs — 876,9 px contre 879,7 à 375 px,
596,9 contre 599,7 à 1 440 — et les huit champs de l'étape 1 appariés un à un, corps, rembourrage et
rayon identiques.

Rien de fonctionnel n'a bougé : jeton, piège à robots (vérifié hors flux à `x = -10 017`),
validation client **et** serveur, consentement, contexte visiteur, UTM, anti-double-soumission,
confirmation après succès réel du serveur.

Quatre causes, toutes de même nature — une valeur relevée que rien n'appliquait : deux jeux de
règles concurrents sur les mêmes champs ; une normalisation écrite `body.tfp-body select` (0,1,2)
qui battait `.tfp-field select` (0,1,1) et rendait toute correction impossible dans le composant ;
une `min-height: max(44px, 60px)` qui annulait le rembourrage du bouton ; un indicateur d'étape et
un résumé qui n'existaient pas.

`docs/FORMULAIRE-DIFFERENCES.md` sépare désormais explicitement, comme le brief l'exigeait, les
**écarts fonctionnels obligatoires** (§2), les **défauts purement visuels** corrigés (§4) et les
**contenus de la maquette délibérément non repris** (§5) — dont « ≈ 20 secondes », qu'aucune mesure
ne fonde.

## 11. LCP mobile sous 2,5 s sur les sept routes

**Atteint avec 0,5 s de marge**, et la cause a été trouvée — ce qui n'était pas acquis.

Le CSS critique a été implémenté, mesuré, et **retiré** : il dégradait le LCP de 2,87 à 3,02 s. Le
diagnostic a montré que l'aller-retour vers la feuille n'était pas le goulot ; les 40 Ko en ligne
portaient le HTML transféré de 12 à 19,4 Ko, et c'est ce poids qui se payait.

La vraie cause : l'accueil pesait 341 Ko dont **264 Ko de polices**, sept fichiers au premier écran,
tous de tailles rigoureusement identiques. Ce n'étaient pas sept polices — **c'était le même fichier
variable téléchargé sept fois**. Demandées graisse par graisse, les deux familles produisent quinze
déclarations `@font-face` pointant vers trois URL ; demandées en plage, 18 fichiers deviennent 4 et
l'accueil en charge 2. Le rendu ne peut pas changer : mêmes glyphes, même fichier.

Mesures finales sur le banc de production : **LCP mobile 1,66 à 1,97 s**, bureau 0,38 à 0,44 s,
**CLS 0,000 sur les quatorze mesures**.

## 12. Batterie de vérifications, et ce qui reste

### Ce qui a été rejoué cette passe

| Contrôle | Résultat |
|---|---|
| Suite Playwright complète | **1 253 passés, 0 échec** |
| Relevé de base 53 routes × 6 largeurs | **318/318 · 300 dans 95-105 % · 0 débordement · 0 erreur console** |
| Lighthouse, 7 routes × mobile/bureau | **14/14 conformes** — perf mobile 99-100, bureau 100, a11y / bonnes pratiques / SEO **100 partout** |
| Cœurs Web | LCP mobile **1,66-1,97 s** · CLS **0,000** sur 14 mesures · TBT 0 ms sauf 79 ms sur une route |
| Planche de validation, 12 routes × 2 largeurs | **22 des 24 comparaisons dans 95-105 %** |
| Captures ciblées, 14 planches | ordre des bandes **identique des deux côtés sur les quatorze** |
| Données structurées | conformes sur les 53 routes |
| Cibles tactiles (WCAG 2.5.8 AA) | **aucune violation** |
| Images par rôle | **164 images, 0 écart** |
| Maillage interne | aucun lien mort, aucune page orpheline |
| Lint PHP | 82 fichiers |
| Parité dépôt ↔ livraison | **1 265 fichiers comparés par empreinte, 0 divergent** |

### Les écarts qui restent, et pourquoi

**Trois pages légales**, hors bande aux six largeurs (111-143 %). Ce n'est pas un défaut de
composition : les mentions de l'ancien site ont dû être **réécrites** et non recopiées
(`CLAUDE.md` §5.7), et le corps de texte est donc plus long. `docs/AUDIT-PAGES-LEGALES.md` mesure la
part ajoutée ligne à ligne ; le résidu reste négatif partout, c'est-à-dire entièrement expliqué.

**Deux défauts mesurés et non corrigés**, consignés pour la passe suivante :

| Où | Maquette | Thème | Écart |
|---|---|---|---|
| `/avis-clients/`, témoignage mis en avant | carte marine `#10263B`, citation 19 px | carte blanche, citation 25 px | 228 px contre 300 à 320 px de large |
| `/bourgogne-franche-comte/`, H1 | `clamp(30px, 4.2vw, 52px)` → 52 px | `--fs-h1-zone` → 49 px | 3 px, une occurrence |

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
