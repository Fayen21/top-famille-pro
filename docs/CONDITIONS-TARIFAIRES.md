# « Le cas échéant » — état après la consigne du 18 août 2026

> La réserve ne doit plus être répétée dans plusieurs lignes d'un même bloc.
> **Aucune condition contractuelle n'a été supprimée** : frais de mise en place, majoration de 10 %
> (dimanche, jours fériés, nuit) et indemnités de 0,35 € HT/km restent énoncés, ainsi que le renvoi
> au devis. C'est la réserve qui est mutualisée, pas ce qu'elle qualifie.

## Ce qui a changé

| Route | Avant | Après |
|---|---|---|
| `/tarifs/` — bande « Trois exemples de budgets » | 4 occurrences dans le même bloc : le chapeau, puis les **trois** intitulés de ligne « Premier mois, mise en place le cas échéant » | 0 dans le bloc. Les intitulés deviennent « Premier mois, avec mise en place » ; le chapeau énonce les montants ; **une note unique** sous le tableau porte la réserve |
| `/` — bande tarifaire | 2 dans la même phrase, à onze mots d'intervalle | 0 : « Nous y ajoutons … **lorsqu'ils s'appliquent**, selon les conditions précisées au devis et toujours indiqués à l'avance » |
| `/nettoyage-professionnel/` — bande tarifaire | 2 dans la même phrase | 0 : « S'y ajoutent, **si prévu et indiqué au devis**, … » — la majoration de 10 % et les 0,35 € HT/km restent nommés |
| `/zones-intervention/bourgogne-franche-comte/` — bande tarifaire | 3 sur la page, dont 2 dans une seule phrase | 1 : « … et des indemnités kilométriques de 0,35 € HT/km, **lorsqu'ils s'appliquent**, selon les conditions précisées au devis » |

La note de `/tarifs/` est **visible et accessible** : elle n'est pas réservée aux lecteurs d'écran,
et la grille des trois exemples la référence par `aria-describedby="tfp-tarifs-conditions"` pour
qu'elle soit annoncée avec le tableau plutôt qu'échouée en fin de page.

> Ces frais et majorations s'appliquent uniquement lorsqu'ils sont prévus et indiqués au devis.

## Occurrences restantes — 30, toutes uniques dans leur bloc

Relevé sur le **HTML servi** des 53 routes, hors JSON-LD.

| Nombre de routes | Bloc | Justification du maintien |
|---|---|---|
| 26 | Bande « Tarif et déplacements » / « Tarif et exemple local » des 26 pages de zone | Une seule réserve dans le bloc, sur la seule phrase qui énonce un montant conditionnel (les 50 € HT de mise en place). C'est le texte de la maquette, et la consigne du 10 août 2026 demande de le reproduire tant qu'une reformulation n'est pas décidée. |
| 1 | `/tarifs/` — réponse FAQ « Comment est calculé mon premier mois ? » | Bloc distinct du tableau, une seule occurrence. La réserve y est **nécessaire** : la question porte précisément sur ce qui entre ou non dans le premier mois. |
| 1 | `/zones-intervention/bourgogne-franche-comte/` — réponse FAQ « Le tarif est-il le même dans tous les départements ? » | Idem : bloc distinct, une occurrence, réserve indispensable à la réponse. |
| 1 | `/conseils/cout-nettoyage-bureaux/` — « Le premier mois inclut, le cas échéant, 50 € HT de frais de mise en place. » | Une occurrence dans un article de conseils dont c'est le sujet. |
| 1 | `/politique-de-confidentialite/` — liste des données collectées | Sans rapport avec la tarification : « le contexte technique de la demande … le cas échéant ». Une occurrence, blocs juridiques distincts. |

**Aucune route ne porte deux occurrences dans un même bloc.** Vérifié section par section sur les
53 routes par `tests/conditions-tarifaires.spec.js`, qui échoue si une seconde réserve réapparaît
dans une même `<section>`.

## Où les corrections vivent

`bin/seed-fidelite-pages.php` est **généré** : la correction est portée par
`CORRECTIONS_EDITORIALES` dans `tools/generate-pages.mjs`, qui **échoue** si le fragment d'origine
disparaît de la maquette. Les deux corrections de gabarit sont dans
`wp-content/themes/topfamillepro/page-tarifs.php` et `template-parts/home/pricing.php`.
