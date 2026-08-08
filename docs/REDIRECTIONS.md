# REDIRECTIONS.md — Plan de redirections 301 depuis topentreprise.fr

> Phase 6 (PROMPT-PHASES.md). Uniquement les paires source **et** destination identifiées
> (`PROJECT_INPUTS.md` §9) — CLAUDE.md §6 : « Aucune redirection créée sans que sa source **et** sa
> destination soient identifiées. » Aucune redirection inventée.

## Décision préalable, toujours ouverte

`PROJECT_INPUTS.md` §9 pose la question en tête : **que devient `topentreprise.fr` ?** S'il conserve
des positions Google ou des backlinks, une redirection page à page vaut mieux qu'un abandon pur et
simple (perte du référencement accumulé). Cette décision n'a pas été prise dans ce dépôt — c'est un
choix commercial/domaine, pas une question technique. Le plan ci-dessous est **prêt à appliquer** le
jour où la décision est prise, pas encore actif.

## Plan de redirections (17 paires confirmées)

Source : `PROJECT_INPUTS.md` §9 (« Correspondances identifiées ✅ »). Destination : URL réelle du
site reconstruit, vérifiée contre `docs/INVENTAIRE-ROUTES.md`. Deux corrections par rapport au
brouillon de `PROJECT_INPUTS.md` — la source reste la même, seule la destination a changé, une fois
les gabarits réellement construits en phase 2/3 : `/cookies` cible en réalité `/gestion-des-cookies/`
(pas `/cookies/`), et `/donnees-personnelles` cible `/politique-de-confidentialite/` (pas
`/confidentialite/`). Corrections signalées dans la colonne Remarque.

| # | Ancienne URL (topentreprise.fr) | Nouvelle URL (top-famille-pro.fr) | Remarque |
|---|---|---|---|
| 1 | `/` | `/` | — |
| 2 | `/menage` | `/nettoyage-professionnel/` | — |
| 3 | `/tarifs-aides` | `/tarifs/` | — |
| 4 | `/contact` | `/contact/` | — |
| 5 | `/blog` | `/conseils/` | Index seulement — voir « Hors périmètre » |
| 6 | `/menage-pro-agence/21000dijon` | `/zones-intervention/cote-dor/dijon/` | — |
| 7 | `/menage-pro-agence/25000besancon` | `/zones-intervention/doubs/besancon/` | — |
| 8 | `/menage-pro-agence/39100dole` | `/zones-intervention/jura/dole/` | — |
| 9 | `/menage-pro-agence/39000lonslesaunier` | `/zones-intervention/jura/lons-le-saunier/` | — |
| 10 | `/menage-pro-agence/58000nevers` | `/zones-intervention/nievre/nevers/` | — |
| 11 | `/menage-pro-agence/70000vesoul` | `/zones-intervention/haute-saone/vesoul/` | — |
| 12 | `/menage-pro-agence/71100chalonsursaone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | — |
| 13 | `/menage-pro-agence/71000macon` | `/zones-intervention/saone-et-loire/macon/` | — |
| 14 | `/menage-pro-agence/89000auxerre` | `/zones-intervention/yonne/auxerre/` | — |
| 15 | `/menage-pro-agence/90000belfort` | `/zones-intervention/territoire-de-belfort/belfort/` | — |
| 16 | `/mentions-légales` | `/mentions-legales/` | — |
| 17 | `/cookies` | `/gestion-des-cookies/` | Corrigé (brouillon : `/cookies/`, slug réel différent) |
| 18 | `/donnees-personnelles` | `/politique-de-confidentialite/` | Corrigé (brouillon : `/confidentialite/`, slug réel différent) |
| 19 | `/plan-site` | `/plan-du-site/` | — |

(19 lignes, la numérotation de `PROJECT_INPUTS.md` en comptait 17 en fusionnant implicitement deux
paires sous un même intitulé — inchangé sur le fond, seule la présentation en tableau les sépare.)

## Hors périmètre — à ne PAS rediriger sans données supplémentaires

- **Articles du blog de l'ancien site** : `PROJECT_INPUTS.md` §9 le signale explicitement — « Le
  blog de l'ancien site n'a pas été relevé : ses articles sont à inventorier avant redirection. »
  Seul `/blog` (l'index) a une correspondance confirmée (`/conseils/`) ; toute URL d'article
  individuel (`/blog/xxx`) resterait sans redirection tant que le plan de site de l'ancien blog n'a
  pas été relevé — les inventer produirait des redirections vers des pages qui ne correspondent à
  rien de réel.
- **Toute autre URL de `topentreprise.fr` non listée ci-dessus** (pages produit/service
  différemment structurées, pages de test, éventuelles pages supprimées) : aucune source fiable pour
  les reconstituer dans ce dépôt. Un relevé exhaustif du plan de site réel de l'ancien site (via
  Google Search Console ou un crawl de l'existant) est nécessaire avant de les ajouter.

## Mise en œuvre (hors dépôt thème)

CLAUDE.md §3 : le dépôt versionne le thème enfant, pas la configuration serveur — les redirections
301 s'appliquent donc **côté hébergement**, pas dans le code du thème :

- Hostinger : redirections 301 depuis hPanel (Domaines → Redirections), ou un fichier `.htaccess`
  sur le domaine `topentreprise.fr` s'il reste actif et pointé vers un serveur capable de les
  interpréter.
- Alternative : un enregistrement DNS faisant pointer `topentreprise.fr` vers le même hébergement
  Hostinger que `top-famille-pro.fr`, avec les redirections définies au niveau du vhost/`.htaccess`
  de ce domaine — pas dans le thème enfant de `top-famille-pro.fr`.

Aucune des 19 redirections ci-dessus n'a été appliquée dans ce dépôt : c'est un plan prêt à
transmettre à qui gère l'hébergement, pas une modification déjà faite.
