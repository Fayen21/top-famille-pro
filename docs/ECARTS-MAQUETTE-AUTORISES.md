# Les six écarts assumés avec la maquette Claude Design

> Ce document est la référence unique des écarts **volontaires** entre le prototype
> `reference/Top-Famille-Pro-HANDOFF-READY.html` et le site WordPress. Tout écart qui n'y figure
> pas est un défaut de fidélité, pas une décision.
>
> Il est tenu à jour avec le tableau `CORRECTIONS_VOULUES` de `tools/diff-text.mjs`, qui les compte
> séparément des textes réellement manquants : `node tools/diff-text.mjs` affiche
> « Total manquant : 0 · écarts voulus (CLAUDE.md) : 6 ».
>
> Dernière mise à jour : 10 août 2026.

## Tableau des six écarts

| # | Route | Section | Texte Claude Design | Texte WordPress actuel | Justification |
|---|---|---|---|---|---|
| 1 | `#/mentions-legales` | Éditeur du site | « Top-Famille Pro — activité dédiée aux professionnels de Top-Famille. Implantation : Saint-Apollinaire (21850). SIREN, numéro de TVA intracommunautaire : à compléter. » | Raison sociale **SARL TOP-ENTREPRISE**, forme juridique, capital de 600,00 €, SIRET 938 472 420 00018, RCS Dijon, code APE, TVA FR32938472420, gérante Audrey Brançon, adresse du siège, date d'immatriculation | Le prototype laisse ces champs à compléter. Les données réelles sont confirmées par Kbis (PROJECT_INPUTS.md). Publier « à compléter » sur une page de mentions légales est une non-conformité au sens de la LCEN art. 6-III, pas un choix de mise en page. **CLAUDE.md §5.7.** |
| 2 | `#/mentions-legales` | Hébergement | « Nom, raison sociale, adresse postale et téléphone de l'hébergeur : à compléter au moment de la mise en ligne. » | **Hostinger International Ltd**, adresse et téléphone réels | Même raison : la LCEN impose l'identité de l'hébergeur. La plateforme est arrêtée (CLAUDE.md §3), la donnée est connue, il n'y a rien à compléter. |
| 3 | `#/mentions-legales` | Assurance et responsabilité | Section « Assurance et responsabilité » + « Coordonnées de l'assureur en responsabilité civile professionnelle et périmètre de garantie : à compléter. » | **Section supprimée** | CLAUDE.md §5.1 interdit d'inventer une assurance ; §10 interdit de publier un `[À COMPLÉTER]`. Une section dont tout le contenu est un espace réservé n'informe personne et donne à croire que l'information manque par négligence. Elle sera rétablie, renseignée, dès que l'attestation sera fournie. |
| 4 | `#/mentions-legales` | Médiation de la consommation | Section « Médiation de la consommation » + « Dispositif applicable et coordonnées du médiateur : à confirmer selon la nature des clients concernés. » | **Section supprimée** | Le dispositif de médiation de la consommation (code de la consommation, art. L612-1) ne s'applique qu'aux litiges entre un professionnel et un **consommateur**. Top-Famille Pro s'adresse exclusivement à des professionnels : la mention est sans objet, et désigner un médiateur au hasard serait une information fausse. **À réexaminer si la clientèle change** — voir `release/GUIDE-DEPLOIEMENT-HOSTINGER.md`, « Décision juridique à réexaminer si la clientèle change ». |
| 5 | Toutes les routes (pied de page, hero, `#/avis-clients`) | Badge de note Google | « ★★★★★ 5,0/5 · **47 avis** » | « ★★★★★ 5,0/5 sur Google » — la note seule | La note de 5,0/5 est confirmée par Emmanuel le 9 août 2026 et peut être affichée. Le **compteur de 47 avis** est un chiffre du prototype, vérifiable en une recherche et faux : CLAUDE.md §5.5 en impose la suppression totale, sans exception. Le compteur réapparaîtra automatiquement dès que le nombre réel sera saisi dans **Réglages → Réassurance & avis**. |
| 6 | Toutes les routes portant un témoignage | Balisage des témoignages | *(le prototype n'émet aucune donnée structurée)* | Aucun `Review`, aucun `AggregateRating` — vérifié sur les 53 routes par `node tools/audit-jsonld.mjs` | Ce n'est pas un écart de rendu mais un écart de balisage, et il est **volontairement conservé**. Les témoignages affichés sont provisoires (CLAUDE.md §5.5) ; les baliser comme des avis authentifiés serait faux. La note Google est une note de plateforme tierce : la baliser comme note du site contrevient aux règles de Google sur les résultats enrichis. |

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

## Ce que ce document ne couvre pas

Les écarts de **structure, de texte, d'image, de style, de proportion, d'espacement ou de
comportement responsive** qui ne figurent pas ci-dessus sont des défauts de fidélité. Ils sont
mesurés et listés dans :

- `docs/COMPARAISON-53-ROUTES.md` — blocs, hauteurs, mots, titres, puces, images, débordements ;
- `docs/VERIFICATION-VISUELLE-53-ROUTES.md` — styles calculés (polices, couleurs, largeurs, cartes,
  boutons, grilles) ;
- `docs/VALIDATION-VISUELLE.md` — douze routes en superposition, à 1440 px et 375 px.
