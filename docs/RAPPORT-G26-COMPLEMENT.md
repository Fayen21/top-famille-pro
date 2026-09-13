# Complément G26 — contenu, ACF et installeur (18 août 2026)

> Verdict : **`PARTIEL — ÉCARTS RESTANTS`**, jusqu'à validation humaine des captures.
> Rien n'a été fusionné dans `main`, rien n'a été déployé, aucune modification DNS.
> Branche : `claude/g23-fidelite-claude-design-7doxg4`.

---

## 1. Destination exacte du champ `fonctionnement`

Le champ ACF `fonctionnement` alimente désormais **un chapitre de méthode déjà existant** de chaque
page de zone : celui que la maquette consacre au fonctionnement. Aucune bande nouvelle, aucun
changement d'ordre, même géométrie et même position.

Le chapitre est désigné **par son titre** — pas par son rang — dans `SECTION_FONCTIONNEMENT`
(`tools/generate-zones.mjs`), et le générateur **échoue** si ce titre disparaît de la maquette.
Le seed écrit alors deux choses : `fonctionnement` (le texte du chapitre) et `fonctionnement_bloc`
(son rang). Une source de vérité, partagée par le seed, l'ACF, le gabarit et l'installeur.

| Zones | Chapitre piloté |
|---|---|
| Dijon, Dole, Lons-le-Saunier, Vesoul, Chalon-sur-Saône, Mâcon, Belfort | « Sélection, intervenant habituel et suivi » |
| Besançon, Nevers | « Sélection des intervenants, remplacement et suivi » |
| Auxerre | « Sélection, intervenant habituel et remplacement » |
| Saint-Apollinaire, Chenôve, Quetigny, Fontaine-lès-Dijon, Marsannay-la-Côte, Saône-et-Loire | « Fonctionnement, sélection et suivi » |
| Talant, Longvic | « Fonctionnement, accès et suivi » |
| Beaune | « Fonctionnement, saisonnalité et suivi » |
| Jura | « Fonctionnement et suivi » |
| Yonne | « Fonctionnement et suivi à distance » |
| Territoire de Belfort | « Démarrage : ce qui se passe après votre accord » |
| Côte-d'Or | « Déplacements et organisation des tournées » |
| Doubs | « Organisation des déplacements depuis Saint-Apollinaire » |
| Nièvre | « Organisation des déplacements » |
| Haute-Saône | « Accès, clés et interventions hors horaires » |

**Les quatre derniers départements n'ont pas de chapitre « fonctionnement » dans la maquette.**
C'est un choix, signalé plutôt que masqué : elle y traite le sujet sous l'angle de l'organisation
des tournées ou des accès, et c'est ce chapitre-là qui décrit comment la prestation se déroule sur
la zone. Faute d'équivalent plus proche, c'est lui qui est désigné.

**Repli** : `fonctionnement` vide → le chapitre garde son texte d'origine (`methode_N_texte`), et
n'est plus marqué comme piloté. Les deux ne sortent **jamais** ensemble — le gabarit choisit une
source, pas deux.

## 2. Preuve que le champ apparaît une seule fois

`tests/fonctionnement-acf.spec.js`, 8 tests :

- **26 pages de zone, exactement un** `[data-tfp-champ="fonctionnement"]` par page ;
- le titre du chapitre piloté est bien celui attendu, sur trois profils différents — une ville dont
  c'est le 4ᵉ chapitre, une commune dont c'est le 2ᵉ, un département sans chapitre « Sélection… » ;
- **marqueur temporaire** écrit dans le champ par wp-cli, page relue : présent **exactement une
  fois** dans le texte servi, à l'intérieur du chapitre désigné, absent de toute autre section, et
  le texte d'origine du chapitre n'est plus servi ;
- **remise en état** dans un `finally` : un échec en cours de route ne laisse pas de donnée de test.
  Le test revérifie ensuite, sur la page servie et en base, que le marqueur a disparu et que le
  texte du seed est revenu ;
- champ vidé → repli servi, marquage absent.

**Témoin de non-complaisance** : gabarit d'avant remis en place, ces mêmes tests rejoués →
**7 échecs sur 8**. Le contrôle mesure quelque chose.

## 3. Occurrences restantes de « le cas échéant »

**30 occurrences sur les 53 routes servies, toutes uniques dans leur bloc.** Aucune page ne la
répète deux fois dans une même section. Le détail route par route et bloc par bloc est dans
**`docs/CONDITIONS-TARIFAIRES.md`** ; en résumé :

| Nombre | Bloc | Justification |
|---|---|---|
| 26 | Bande tarifaire des 26 pages de zone | Une seule réserve, sur la seule phrase qui énonce un montant conditionnel. Texte de la maquette, que la consigne du 10 août demande de reproduire. |
| 1 | `/tarifs/` — FAQ « Comment est calculé mon premier mois ? » | Bloc distinct du tableau. La réserve est **le sujet de la réponse**. |
| 1 | `/zones-intervention/bourgogne-franche-comte/` — FAQ tarif | Idem. |
| 1 | `/conseils/cout-nettoyage-bureaux/` | Une occurrence, dans un article dont c'est le sujet. |
| 1 | `/politique-de-confidentialite/` | Sans rapport avec la tarification. |

**Ce qui a été corrigé** — quatre blocs qui la répétaient :

| Route | Avant | Après |
|---|---|---|
| `/tarifs/` — bande des budgets | **4** dans le bloc : le chapeau + les trois intitulés « Premier mois, mise en place le cas échéant » | **0**. Intitulés → « Premier mois, avec mise en place ». Une note unique sous le tableau : « Ces frais et majorations s'appliquent uniquement lorsqu'ils sont prévus et indiqués au devis. » |
| `/` | 2 dans une phrase | 0 — « … **lorsqu'ils s'appliquent**, selon les conditions précisées au devis » |
| `/nettoyage-professionnel/` | 2 dans une phrase | 0 — « S'y ajoutent, **si prévu et indiqué au devis**, … » |
| `/zones-intervention/bourgogne-franche-comte/` | 3 dont 2 dans une phrase | 1 |

La note de `/tarifs/` est **visible** (pas réservée aux lecteurs d'écran) et **accessible** : la
grille des trois exemples la référence par `aria-describedby`, pour qu'elle soit annoncée avec le
tableau plutôt qu'échouée en fin de page.

**Aucune condition contractuelle n'a été retirée** : frais de mise en place, majoration de 10 %
(dimanche, jours fériés, nuit) et indemnités de 0,35 € HT/km restent énoncés, ainsi que le renvoi au
devis. `tests/conditions-tarifaires.spec.js` contrôle les deux faces — pas de répétition dans un
bloc, **et** pas de disparition des conditions.

## 4. Preuve que la note Google est absente du HTML servi

Balayage des **53 routes × 16 motifs = 848 contrôles**, sur le HTML servi complet, JSON-LD compris :

| Motif | Occurrences |
|---|---|
| `5,0/5` ou `5.0/5` | **0** |
| « sur Google » | **0** |
| compteur d'avis (`\d+ avis`) | **0** |
| `"Review"` | **0** |
| `AggregateRating` | **0** |
| `ratingValue` | **0** |
| `href="#"` | **0** |
| « 47 avis » | **0** |

**La garde exige trois conditions simultanées** (`tfp_reassurance_data()`) : une note saisie, une
URL de fiche non vide, et une URL qui a la forme d'une fiche Google. La case « Afficher sans la
fiche » est **supprimée** — elle permettait exactement ce que la consigne interdit.

`tests/g26.spec.js` éprouve le contrat sur **11 cas** : note seule, URL vide, URL d'espaces, URL du
site lui-même, `#`, `https://www.google.fr/` sans chemin de fiche, `http://` non sécurisé, URL sans
note → **la note ne sort pas**. `…/maps/place/…`, `?cid=…`, `maps.app.goo.gl/…`, `g.page/…` →
**elle sort**.

**Le seed ne peut pas réactiver la note** : `bin/seed-reassurance.php` n'écrit jamais `google_url`,
et purge l'ancienne dérogation des bases montées avant le 18 août.

**Limite énoncée, pas masquée** : ce contrôle porte sur la **forme** de l'adresse, pas sur son
appartenance. Aucun code ne peut prouver depuis le serveur qu'une fiche est celle de Top-Famille
Pro. L'écran de saisie le dit ; la vérification reste humaine.

## 5. Résultat du contrôle de parité de l'installeur

`node tools/verifier-parite-installeur.mjs` — **1279 fichiers comparés par empreinte SHA-256,
0 manquant, 0 divergent.**

Ce qu'il compare :

1. **Seeds** — les 16 déclarés par `includes/installer.php`, identiques à `bin/`. Dans les **trois
   sens** : déclaré mais absent du paquet ; présent au paquet mais jamais joué ; présent dans `bin/`
   mais ignoré du plugin (c'est ce troisième cas qui avait laissé `seed-reassurance.php` dehors).
2. **Fichiers exigés nommément** — plugin, `includes`, nettoyage des contenus par défaut, gabarits
   du thème dont `single-zone.php` et `page-tarifs.php`, `reassurance-settings.php`, `components.php`.
3. **CSS et JS construits** — reconstruits dans un répertoire jetable (`build/build.mjs --out-dir=`)
   et comparés octet par octet. Un contrôle qui écraserait d'abord ce qu'il mesure ne mesurerait
   plus rien.
4. **Manifeste d'images** — chaque fichier annoncé doit exister, **et être dans l'archive du thème**.
5. **Archives** — chaque entrée comparée au fichier du dépôt.

Il est joué **par la suite de tests** (`tests/parite-installeur.spec.js`) et **avant chaque export**
(`tools/export-statique.mjs`, `tools/build-paquets.mjs`, `npm test`).

**Fixtures** — trois avaries délibérées, sur une copie jetable du dépôt, chacune devant faire
échouer le contrôle : un seed supprimé, une copie modifiée, une feuille de style distribuée en
retard sur ses sources. Les trois sont détectées, avec le bon chemin.

**Ce que le contrôle a trouvé en s'installant :**

| Défaut | Mesure |
|---|---|
| `topfamillepro-theme.zip` en retard sur le dépôt | 72 fichiers |
| `topfamillepro-content-installer.zip` en retard | 6 fichiers |
| Images du manifeste absentes de l'archive du thème | **240 sur 378** — un site déployé depuis cette archive aurait servi des `srcset` vers des fichiers absents |

Les archives sont désormais construites par `tools/build-paquets.mjs` **depuis l'arbre de travail**,
sur la liste des fichiers suivis par git — jamais retouchées à la main. `git archive HEAD` a été
écarté volontairement : construire avant de committer produirait une archive silencieusement en
retard, c'est-à-dire exactement la dérive à empêcher.

## 6. Ratios finaux, réellement régénérés

**Relevé de base** (`docs/baseline.json`, 53 routes × 6 largeurs) :

| Contrôle | Résultat |
|---|---|
| Contrôles | **318 / 318** |
| Dans 95-105 % | **298** |
| Débordement horizontal | **0** |
| Erreur console ou réseau | **0** |
| CLS | 0,000 à 0,001 sur les routes relevées |

**112 comparaisons** régénérées (`docs/COMPARAISON-53-ROUTES.md`, 375 px et 1440 px) :
**212 ratios, 19 hors bande, 0 débordement.**

Les 19 sont les mêmes qu'avant cette passe, et tous documentés :

| Route | Ratio | Motif |
|---|---|---|
| `/mentions-legales/`, `/politique-de-confidentialite/`, `/gestion-des-cookies/` | 120 → 158 % | Contenu réglementaire réel, plus long que la maquette. Écart assumé (`CLAUDE.md` §5.7). |
| `/contact/`, `/demande-de-devis/` | 110 → 115 % (mots) | Formulaire réel : champs, libellés, messages d'erreur que la maquette ne pose pas. |
| `/` | 106 % (mots) | Bande tarifaire et réassurance réelles. |
| `/pourquoi-top-famille-pro/` 375 px | 106 % (hauteur) | Repli d'une carte au pixel près. |

**Les deux ratios que la note Google avait fait sortir de la bande le 17 août sont rentrés** :
`/avis-clients/` et `/a-propos/` repassent sous 105 %, conséquence directe du retrait de la note.

**`diff-text`** : **0 bloc de texte de la maquette absent** des 53 routes, 146 écarts nommés.

## 7. Fichiers et commits

**Créés**

| Fichier | Rôle |
|---|---|
| `tools/verifier-parite-installeur.mjs` | Contrôle de parité dépôt ↔ livraison |
| `tools/build-paquets.mjs` | Construction des deux archives depuis l'arbre de travail |
| `tests/fonctionnement-acf.spec.js` | Destination réelle du champ, marqueur temporaire |
| `tests/conditions-tarifaires.spec.js` | Une réserve par bloc, conditions préservées |
| `tests/parite-installeur.spec.js` | Parité + trois fixtures d'avarie |
| `docs/CONDITIONS-TARIFAIRES.md` | Les 30 occurrences restantes, route et justification |
| `docs/RAPPORT-G26-COMPLEMENT.md` | Ce rapport |

**Modifiés** — `single-zone.php` (chapitre piloté), `includes/acf-fields-zone.php` (champ
`fonctionnement_bloc`), `includes/components.php` (rang ACF des groupes),
`includes/reassurance-settings.php` (garde à trois conditions, dérogation supprimée),
`page-tarifs.php` et `template-parts/home/pricing.php` (réserve unique), `bin/seed-reassurance.php`,
`tools/generate-zones.mjs` (`SECTION_FONCTIONNEMENT`), `tools/generate-pages.mjs`
(`CORRECTIONS_EDITORIALES`), `tools/diff-text.mjs`, `tools/export-statique.mjs`, `build/build.mjs`
(`--out-dir=`), `tools/banc-local.sh` (seed de réassurance), `package.json`, les seeds générés, les
copies de l'installeur, les deux archives, la baseline et les 112 comparaisons.

## 8. Écarts encore ouverts

| Écart | État |
|---|---|
| **URL de la fiche Google** | Non fournie. La note reste enregistrée et **invisible**. Elle revient d'elle-même le jour où l'URL est saisie. |
| **Nombre réel d'avis** | Non fourni. Compteur masqué, aucune exception. |
| **Photo d'Audrey et citation** | Provisoires, marquées comme telles. La citation fait parler une personne réelle : **à valider par l'intéressée avant mise en ligne**. |
| **Témoignages de la maquette** | Provisoires, tous porteurs de `data-tfp-provisional`, en réglages ou en champs ACF, jamais en dur. Aucun n'alimente de `Review` ni d'`AggregateRating`. |
| **`CLAUDE.md` §5.5** | Énonce toujours la note comme affichable. Contradiction **signalée**, pas corrigée : `CLAUDE.md` ne se modifie pas sans validation d'Emmanuel. |
| **« Aucun simulateur » et « agences fictives »** | Corrections §9 **différées** par la décision du 10 août, non touchées, conformément au §1 de la consigne. |
| **Répétitions de « le cas échéant »** | 30 occurrences restantes, toutes uniques dans leur bloc, documentées une par une. |
| **Huit communes** | En `index,follow` et au sitemap, conformément à votre décision du 17 août et au §1. Le §6 de la consigne demandait de les vérifier en `noindex,follow` : contradiction soumise, vous avez tranché pour **`index,follow`**. |
| **Fidélité** | **Non validée.** C'est l'objet de la relecture des captures. |

---

**Verdict : `PARTIEL — ÉCARTS RESTANTS`.** Il le restera jusqu'à votre validation des captures.
