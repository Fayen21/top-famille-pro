# Les écarts assumés avec la maquette Claude Design

> Ce document est la référence unique des écarts **volontaires** entre le prototype
> `reference/Top-Famille-Pro-HANDOFF-READY.html` et le site WordPress. Tout écart qui n'y figure
> pas est un défaut de fidélité, pas une décision.
>
> Il est tenu à jour avec le tableau `CORRECTIONS_VOULUES` de `tools/diff-text.mjs`, qui les compte
> séparément des textes réellement manquants : `node tools/diff-text.mjs` affiche
> « Total manquant : 0 · écarts voulus (CLAUDE.md) : 6 ».
>
> Dernière mise à jour : 17 août 2026 (G26 — écart n° 5 renversé, section « écarts de structure »
> ajoutée sur décision d'Emmanuel).

## Tableau des six écarts de contenu

| # | Route | Section | Texte Claude Design | Texte WordPress actuel | Justification |
|---|---|---|---|---|---|
| 1 | `#/mentions-legales` | Éditeur du site | « Top-Famille Pro — activité dédiée aux professionnels de Top-Famille. Implantation : Saint-Apollinaire (21850). SIREN, numéro de TVA intracommunautaire : à compléter. » | Raison sociale **SARL TOP-ENTREPRISE**, forme juridique, capital de 600,00 €, SIRET 938 472 420 00018, RCS Dijon, code APE, TVA FR32938472420, gérante Audrey Brançon, adresse du siège, date d'immatriculation | Le prototype laisse ces champs à compléter. Les données réelles sont confirmées par Kbis (PROJECT_INPUTS.md). Publier « à compléter » sur une page de mentions légales est une non-conformité au sens de la LCEN art. 6-III, pas un choix de mise en page. **CLAUDE.md §5.7.** |
| 2 | `#/mentions-legales` | Hébergement | « Nom, raison sociale, adresse postale et téléphone de l'hébergeur : à compléter au moment de la mise en ligne. » | **Hostinger International Ltd**, adresse et téléphone réels | Même raison : la LCEN impose l'identité de l'hébergeur. La plateforme est arrêtée (CLAUDE.md §3), la donnée est connue, il n'y a rien à compléter. |
| 3 | `#/mentions-legales` | Assurance et responsabilité | Section « Assurance et responsabilité » + « Coordonnées de l'assureur en responsabilité civile professionnelle et périmètre de garantie : à compléter. » | **Section supprimée** | CLAUDE.md §5.1 interdit d'inventer une assurance ; §10 interdit de publier un `[À COMPLÉTER]`. Une section dont tout le contenu est un espace réservé n'informe personne et donne à croire que l'information manque par négligence. Elle sera rétablie, renseignée, dès que l'attestation sera fournie. |
| 4 | `#/mentions-legales` | Médiation de la consommation | Section « Médiation de la consommation » + « Dispositif applicable et coordonnées du médiateur : à confirmer selon la nature des clients concernés. » | **Section supprimée** | Le dispositif de médiation de la consommation (code de la consommation, art. L612-1) ne s'applique qu'aux litiges entre un professionnel et un **consommateur**. Top-Famille Pro s'adresse exclusivement à des professionnels : la mention est sans objet, et désigner un médiateur au hasard serait une information fausse. **À réexaminer si la clientèle change** — voir `release/GUIDE-DEPLOIEMENT-HOSTINGER.md`, « Décision juridique à réexaminer si la clientèle change ». |
| 5 | Toutes les routes (barre haute, hero, encart contact, `#/avis-clients`) | Badge de note Google | « ★★★★★ 5,0/5 · **47 avis** » | **rien** — ni note, ni étoiles de note, ni mention « sur Google », ni compteur | **Consigne du 18 août 2026, confirmée le 19 : aucune note Google affichée** tant qu'une URL officielle correspondant réellement à Top-Famille Pro n'a pas été fournie **et validée humainement**. La case « Afficher sans la fiche » du 17 août a été **supprimée du code** : elle permettait exactement ce que la consigne interdit. La garde exige trois conditions simultanées — note saisie, URL non vide, URL de forme « fiche Google » — et aucun seed ne peut les réunir seul. Restent vrais quoi qu'il arrive : aucun compteur d'avis, **aucune** donnée `Review` ni `AggregateRating`, aucun `href="#"`. |
| 6 | Toutes les routes portant un témoignage | Balisage des témoignages | *(le prototype n'émet aucune donnée structurée)* | Aucun `Review`, aucun `AggregateRating` — vérifié sur les 53 routes par `node tools/audit-jsonld.mjs` | Ce n'est pas un écart de rendu mais un écart de balisage, et il est **volontairement conservé**. Les témoignages affichés sont provisoires (CLAUDE.md §5.5) ; les baliser comme des avis authentifiés serait faux. La note Google est une note de plateforme tierce : la baliser comme note du site contrevient aux règles de Google sur les résultats enrichis. |

## Écarts de STRUCTURE validés — décision d'Emmanuel du 17 août 2026

Ces deux écarts ont été relevés en G26 §8/§9 : le prototype ne les porte pas, le site les porte. Ils
n'avaient jusque-là **aucune trace de décision** dans le dépôt, ce qui les rendait indiscernables
d'un défaut. Ils ont été présentés à Emmanuel avec leur coût mesuré, et **il a décidé de les
conserver**. Ils cessent donc d'être des écarts ouverts et deviennent des différences assumées.

| # | Où | Maquette | Site | Décision et motif |
|---|---|---|---|---|
| 7 | Navigation principale, 53 routes | Six entrées : Prestations ▾, Tarifs, Zones ▾, Pourquoi nous, Avis, Conseils | **Six entrées, identiques** | **Écart CLOS le 19 août 2026.** Il avait été conservé le 17 août : sept entrées, barre repliée à 1440 px, en-tête à 141 px au lieu de 119. La décision définitive supprime l'entrée autonome « Nettoyage professionnel » **sans perdre le lien SEO vers le pilier** : c'est désormais l'entrée « Prestations » qui le porte (un `<a>` vers `/nettoyage-professionnel/`, doublé d'un bouton de dépliage pour les six prestations). En-tête ramené à 120 px. Verrouillé par `tests/navigation.spec.js` et `docs/DECISIONS.json`. |
| 8 | Hero de `/a-propos/`, `/pourquoi-nous/`, `/notre-fonctionnement/`, `/avis-clients/`, `/prestations/` | Aucune commande dans le hero | **« Demander mon devis » + « ☎ Appeler Audrey »** | **Conservé**, au titre de `CLAUDE.md` §4 — modification de structure autorisée lorsqu'elle améliore objectivement la conversion, à condition d'être signalée. Ce sont les deux points de conversion du site sur cinq pages institutionnelles qui n'en portaient aucun avant le bas de page. Coût mesuré et accepté : ces rangées expliquent l'essentiel de l'écart de hauteur résiduel de `/a-propos/` et `/pourquoi-nous/` à 375 px. |

Le **badge région** relevait du même constat sur sept routes ; il a été **retiré** en G26 §9, et ne
figure donc pas ici : c'est un élément décoratif dont le lien existe déjà dans le menu et dans le
pied de page, sans effet de conversion à préserver.

`tests/ecarts-structure.spec.js` verrouille ces deux décisions : une passe ultérieure qui les
« corrigerait » au nom de la fidélité fait échouer la suite, et devra revenir ici plutôt que de
trancher à nouveau.

## Les deux écarts éditoriaux ont été rétablis

`CLAUDE.md §9` prévoit une série de corrections éditoriales sur les textes du prototype. Deux
d'entre elles avaient été appliquées et **ont été annulées le 10 août 2026**, sur consigne
explicite : « Je veux d'abord reproduire la maquette, puis je modifierai ses formulations
ultérieurement. »

| Route | Texte Claude Design, rétabli | Correction §9 différée |
|---|---|---|
| `#/` — section couverture | « Une couverture régionale, pas des agences fictives » | « Une entreprise régionale basée à Saint-Apollinaire » |
| `#/` — section difficultés | « Un interlocuteur identifié suit votre dossier, ajuste la prestation et vous répond directement. » | « Interlocutrice identifiée » |

Aucune des deux ne réintroduit un ancien tarif, une information juridique fausse ni une donnée
incompatible avec une décision commerciale en vigueur : elles pouvaient donc être rétablies sans
réserve. Le test `tests/fidelite.spec.js` a été aligné sur le texte de la maquette, pour que la
suite protège l'état réellement voulu.

Trois autres corrections de §9 **restent appliquées**, parce qu'elles tombent sous les exceptions
posées par la consigne :

- « Aucun simulateur » → « Devis étudié personnellement par Audrey » sur `/tarifs/` : la formulation
  du prototype y coexiste avec la FAQ « Pourquoi ne proposez-vous pas de simulateur en ligne ? »,
  et le texte de la maquette y est en réalité conservé (`Aucun simulateur : une étude adaptée à vos
  locaux`). Ce qui a été retiré, c'est un paragraphe que le **thème** avait ajouté sur
  `/demande-de-devis/`, absent du prototype ;
- « Des guides locaux viendront compléter cette page » : promesse d'un contenu qui n'existe pas ;
- toute occurrence de « Top-Entreprise » : l'ancienne marque doit disparaître du site public.

### Corrections §9 appliquées le 18 août 2026

Deux fautes de langue du prototype, nommées telles quelles par `CLAUDE.md` §9, étaient encore
servies. Elles ne relèvent pas de la consigne du 10 août — celle-ci porte sur les **formulations**
(« je modifierai ses formulations ultérieurement »), pas sur l'orthographe et les accords, que §9
demande au contraire de corriger sur les 53 pages.

| Maquette | Site | Portée |
|---|---|---|
| « … sont possible **lorsque prévu** dans le cahier des charges et **chiffré** dans le devis » | accordé au sujet de chaque phrase : « possibles lorsqu'elles sont prévues au cahier des charges et chiffrées au devis », « lorsqu'ils sont prévus … et chiffrés », « lorsqu'elle est prévue … et chiffrée » | **28 occurrences** sur les 26 zones |
| « lister **precisément** » | « lister précisément » | 1 occurrence, `/conseils/cahier-des-charges-nettoyage/` |

L'accord dépend du sujet, qui change d'une occurrence à l'autre — « la sortie des bacs » (féminin
singulier), « la sortie et la rentrée » (féminin pluriel), « le changement de linge, la vérification
… et le signalement » (masculin pluriel). Une règle unique aurait donc introduit une faute là où
elle en corrigeait une autre : chaque sujet a la sienne, dans `tools/generate-zones.mjs`
(`GRAMMAIRE`) et `tools/generate-articles.mjs` (`ORTHOGRAPHE`). Ces deux fichiers de seed étant
**générés**, une correction faite dans le fichier produit aurait été écrasée à la régénération
suivante.

Le garde-fou est dans le générateur : si un « lorsque prévu » survit à toutes les règles, la
génération **échoue** au lieu de publier la faute — c'est le cas si la maquette introduit un sujet
non prévu. `tests/communes-affirmatif.spec.js` reprend le contrôle sur le HTML servi des 53 routes.

### Note Google — masquée, consigne du 18 août 2026

Réaffichée le 17 août sur décision d'Emmanuel, elle est **retirée à nouveau** : la consigne du
18 août interdit d'afficher une note Google comme authentique tant qu'une fiche officielle
vérifiable de Top-Famille Pro n'est pas fournie.
La dérogation « Afficher sans la fiche » a été supprimée du code — elle permettait exactement ce que
la consigne interdit.

`tfp_reassurance_data()` exige désormais **trois conditions simultanées** :

1. une note saisie ;
2. une URL de fiche non vide ;
3. une URL qui a la **forme** d'une fiche Google (`…google.<tld>/maps/…`, `maps.app.goo.gl/…`,
   `g.page/…`, ou une adresse portant `cid=` / `place_id=` / `ludocid=`, en `https`).

La troisième condition existe parce que la deuxième seule se contourne avec n'importe quelle chaîne.
**Ce contrôle porte sur la forme, pas sur l'appartenance** : aucun code ne peut prouver depuis le
serveur qu'une fiche est celle de Top-Famille Pro. L'écran de saisie le dit, et la vérification
reste humaine.

| Maquette | Site |
|---|---|
| « ★★★★★ 5,0/5 sur Google », hero et pastille du portrait | rien : ni note, ni étoiles de note, ni mention « sur Google », ni compteur d'avis |

Vérifié sur les **53 routes** : 0 occurrence de `5,0/5`, de « sur Google », de compteur d'avis, de
`Review`, d'`AggregateRating`, de `ratingValue` et de `href="#"`. Le seed `bin/seed-reassurance.php`
n'écrit jamais `google_url` : **il ne peut pas réactiver la note**.

### « Le cas échéant » — consigne du 18 août 2026

La réserve ne doit plus être répétée dans plusieurs lignes d'un même bloc. Quatre blocs la posaient
plusieurs fois ; aucune condition contractuelle n'a été retirée. Le détail des 30 occurrences
restantes, avec leur route et leur justification, est dans **`docs/CONDITIONS-TARIFAIRES.md`**.

### Réponse directe de Quetigny — décision du 17 août 2026

Les huit communes secondaires étant desservies, leur texte passe à l'affirmatif. Sept des huit
l'affirmaient déjà (« Top-Famille Pro y entretient … », et Saint-Apollinaire est le siège) ; la
réponse directe de Quetigny décrivait la commune et le tarif sans jamais dire que nous y
intervenons.

| Maquette | Site |
|---|---|
| « Quetigny est une commune de Côte-d'Or située à l'est de Dijon, limitrophe de Saint-Apollinaire où Top-Famille Pro est implantée. » | « Top-Famille Pro entretient vos locaux à Quetigny, commune de Côte-d'Or située à l'est de Dijon, limitrophe de Saint-Apollinaire où l'entreprise est implantée. » |

La correction est portée par `CORRECTIONS_EDITORIALES` dans `tools/generate-zones.mjs`, qui échoue
si le fragment d'origine disparaît de la maquette.

## Ce que ce document ne couvre pas

Les écarts de **structure, de texte, d'image, de style, de proportion, d'espacement ou de
comportement responsive** qui ne figurent pas ci-dessus sont des défauts de fidélité. Ils sont
mesurés et listés dans :

- `docs/COMPARAISON-53-ROUTES.md` — blocs, hauteurs, mots, titres, puces, images, débordements ;
- `docs/VERIFICATION-VISUELLE-53-ROUTES.md` — styles calculés (polices, couleurs, largeurs, cartes,
  boutons, grilles) ;
- `docs/VALIDATION-VISUELLE.md` — douze routes en superposition, à 1440 px et 375 px.
