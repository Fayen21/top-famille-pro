# Dossier de validation humaine — G28

> Produit le 20 août 2026 depuis le commit `f917741`, banc local.
> **Statut : `G28=PRET_POUR_VALIDATION_HUMAINE`** · verdict global : `PARTIEL — ÉCARTS RESTANTS`

Les archives ne sont pas versionnées : elles pèsent 119 Mo et sont régénérées à chaque passe.
Ce document en est la trace mesurable, et `release/SHA256SUMS-dossier-g28.txt` la rend vérifiable.
Pour les reconstruire à l identique :

```
bash tools/banc-local.sh --development
TFP_BASE_URL=http://localhost:8901 node tools/dossier-g28.mjs
node tools/archiver-dossier-g28.mjs
node tools/verifier-dossier-hors-ligne.mjs release/dossier-g28-*.zip
```

## Épreuve hors ligne

Les trois archives ont été extraites dans un répertoire neuf et ouvertes en `file://` avec le
réseau coupé au niveau du navigateur. Résultat : **aucune image cassée, aucune ressource externe,
aucune URL interdite, aucune ancre morte, aucun chemin absolu, navigation complète.**

Un défaut avait été trouvé au premier passage et corrigé : la fiche de décision et les index
liaient vers les autres volumes, or une archive extraite seule ne les contient pas — 88 ancres
mortes. Les autres volumes sont désormais **nommés, pas liés**.

## volume-1-prioritaire — 28 comparaisons · 31.5 Mo

| # | Page | Route | Largeur | Amplification | Pixels différents | Statut |
|---:|---|---|---:|---:|---:|---|
| 1 | Accueil | `/` | 375 px | ×8 | 50.55 % | À VALIDER |
| 2 | Accueil | `/` | 1440 px | ×8 | 51.78 % | À VALIDER |
| 3 | Prestation — nettoyage de bureaux | `/prestations/bureaux/` | 375 px | ×8 | 37.81 % | À VALIDER |
| 4 | Prestation — nettoyage de bureaux | `/prestations/bureaux/` | 1440 px | ×8 | 36.79 % | À VALIDER |
| 5 | Ville — Dijon | `/zones-intervention/cote-dor/dijon/` | 375 px | ×8 | 44.58 % | À VALIDER |
| 6 | Ville — Dijon | `/zones-intervention/cote-dor/dijon/` | 1440 px | ×8 | 36.30 % | À VALIDER |
| 7 | Tarifs | `/tarifs/` | 375 px | ×8 | 46.35 % | À VALIDER |
| 8 | Tarifs | `/tarifs/` | 1440 px | ×8 | 37.66 % | À VALIDER |
| 9 | Formulaire de devis — étape 1 | `/demande-de-devis/` | 375 px | ×8 | 40.47 % | À VALIDER |
| 10 | Formulaire de devis — étape 1 | `/demande-de-devis/` | 1440 px | ×8 | 34.73 % | À VALIDER |
| 11 | Formulaire de devis — étape 2 | `/demande-de-devis/` | 375 px | ×8 | 42.71 % | À VALIDER |
| 12 | Formulaire de devis — étape 2 | `/demande-de-devis/` | 1440 px | ×8 | 35.80 % | À VALIDER |
| 13 | Article — fréquence de nettoyage | `/conseils/frequence-bureaux/` | 375 px | ×8 | 44.00 % | À VALIDER |
| 14 | Article — fréquence de nettoyage | `/conseils/frequence-bureaux/` | 1440 px | ×8 | 30.68 % | À VALIDER |
| 15 | Mentions légales | `/mentions-legales/` | 375 px | ×8 | 63.45 % | À VALIDER |
| 16 | Mentions légales | `/mentions-legales/` | 1440 px | ×8 | 59.56 % | À VALIDER |
| 17 | Page pilier — nettoyage professionnel | `/nettoyage-professionnel/` | 375 px | ×8 | 46.86 % | À VALIDER |
| 18 | Page pilier — nettoyage professionnel | `/nettoyage-professionnel/` | 1440 px | ×8 | 34.09 % | À VALIDER |
| 19 | Zoom — bande des six vignettes du pilier | `/nettoyage-professionnel/` | 375 px | ×8 | 47.83 % | À VALIDER |
| 20 | Zoom — bande des six vignettes du pilier | `/nettoyage-professionnel/` | 1440 px | ×8 | 29.62 % | À VALIDER |
| 21 | Page région — Bourgogne-Franche-Comté | `/zones-intervention/bourgogne-franche-comte/` | 375 px | ×8 | 39.87 % | À VALIDER |
| 22 | Page région — Bourgogne-Franche-Comté | `/zones-intervention/bourgogne-franche-comte/` | 1440 px | ×8 | 36.55 % | À VALIDER |
| 23 | À propos | `/a-propos/` | 375 px | ×8 | 44.41 % | À VALIDER |
| 24 | À propos | `/a-propos/` | 1440 px | ×8 | 34.71 % | À VALIDER |
| 25 | Recrutement | `/recrutement/` | 375 px | ×8 | 35.20 % | À VALIDER |
| 26 | Recrutement | `/recrutement/` | 1440 px | ×8 | 25.98 % | À VALIDER |
| 27 | Avis clients | `/avis-clients/` | 375 px | ×8 | 48.21 % | À VALIDER |
| 28 | Avis clients | `/avis-clients/` | 1440 px | ×8 | 53.11 % | À VALIDER |

## volume-2-pages — 30 comparaisons · 24.6 Mo

| # | Page | Route | Largeur | Amplification | Pixels différents | Statut |
|---:|---|---|---:|---:|---:|---|
| 1 | index-prestations — /prestations/ | `/prestations/` | 375 px | ×8 | 47.45 % | À VALIDER |
| 2 | index-prestations — /prestations/ | `/prestations/` | 1440 px | ×8 | 39.88 % | À VALIDER |
| 3 | prestation — /prestations/commerces/ | `/prestations/commerces/` | 375 px | ×8 | 37.04 % | À VALIDER |
| 4 | prestation — /prestations/commerces/ | `/prestations/commerces/` | 1440 px | ×8 | 45.49 % | À VALIDER |
| 5 | prestation — /prestations/cabinets/ | `/prestations/cabinets/` | 375 px | ×8 | 38.77 % | À VALIDER |
| 6 | prestation — /prestations/cabinets/ | `/prestations/cabinets/` | 1440 px | ×8 | 43.81 % | À VALIDER |
| 7 | prestation — /prestations/coproprietes/ | `/prestations/coproprietes/` | 375 px | ×8 | 41.06 % | À VALIDER |
| 8 | prestation — /prestations/coproprietes/ | `/prestations/coproprietes/` | 1440 px | ×8 | 42.82 % | À VALIDER |
| 9 | prestation — /prestations/meubles/ | `/prestations/meubles/` | 375 px | ×8 | 40.93 % | À VALIDER |
| 10 | prestation — /prestations/meubles/ | `/prestations/meubles/` | 1440 px | ×8 | 37.88 % | À VALIDER |
| 11 | prestation — /prestations/ponctuel/ | `/prestations/ponctuel/` | 375 px | ×8 | 38.53 % | À VALIDER |
| 12 | prestation — /prestations/ponctuel/ | `/prestations/ponctuel/` | 1440 px | ×8 | 49.11 % | À VALIDER |
| 13 | index-conseils — /conseils/ | `/conseils/` | 375 px | ×8 | 38.12 % | À VALIDER |
| 14 | index-conseils — /conseils/ | `/conseils/` | 1440 px | ×8 | 27.23 % | À VALIDER |
| 15 | article — /conseils/cout-nettoyage-bureaux/ | `/conseils/cout-nettoyage-bureaux/` | 375 px | ×8 | 46.11 % | À VALIDER |
| 16 | article — /conseils/cout-nettoyage-bureaux/ | `/conseils/cout-nettoyage-bureaux/` | 1440 px | ×8 | 34.82 % | À VALIDER |
| 17 | article — /conseils/cahier-des-charges-nettoyage/ | `/conseils/cahier-des-charges-nettoyage/` | 375 px | ×8 | 44.96 % | À VALIDER |
| 18 | article — /conseils/cahier-des-charges-nettoyage/ | `/conseils/cahier-des-charges-nettoyage/` | 1440 px | ×8 | 33.25 % | À VALIDER |
| 19 | institutionnelle — /pourquoi-nous/ | `/pourquoi-nous/` | 375 px | ×8 | 48.30 % | À VALIDER |
| 20 | institutionnelle — /pourquoi-nous/ | `/pourquoi-nous/` | 1440 px | ×8 | 44.62 % | À VALIDER |
| 21 | institutionnelle — /notre-fonctionnement/ | `/notre-fonctionnement/` | 375 px | ×8 | 36.40 % | À VALIDER |
| 22 | institutionnelle — /notre-fonctionnement/ | `/notre-fonctionnement/` | 1440 px | ×8 | 32.10 % | À VALIDER |
| 23 | contact — /contact/ | `/contact/` | 375 px | ×8 | 43.02 % | À VALIDER |
| 24 | contact — /contact/ | `/contact/` | 1440 px | ×8 | 30.22 % | À VALIDER |
| 25 | plan-du-site — /plan-du-site/ | `/plan-du-site/` | 375 px | ×8 | 18.12 % | À VALIDER |
| 26 | plan-du-site — /plan-du-site/ | `/plan-du-site/` | 1440 px | ×8 | 21.35 % | À VALIDER |
| 27 | legale — /politique-de-confidentialite/ | `/politique-de-confidentialite/` | 375 px | ×8 | 74.76 % | À VALIDER |
| 28 | legale — /politique-de-confidentialite/ | `/politique-de-confidentialite/` | 1440 px | ×8 | 63.99 % | À VALIDER |
| 29 | legale — /gestion-des-cookies/ | `/gestion-des-cookies/` | 375 px | ×8 | 61.39 % | À VALIDER |
| 30 | legale — /gestion-des-cookies/ | `/gestion-des-cookies/` | 1440 px | ×8 | 55.50 % | À VALIDER |

## volume-3-zones — 52 comparaisons · 63.2 Mo

| # | Page | Route | Largeur | Amplification | Pixels différents | Statut |
|---:|---|---|---:|---:|---:|---|
| 1 | hub-zones — /zones-intervention/ | `/zones-intervention/` | 375 px | ×8 | 33.58 % | À VALIDER |
| 2 | hub-zones — /zones-intervention/ | `/zones-intervention/` | 1440 px | ×8 | 32.04 % | À VALIDER |
| 3 | departement — /zones-intervention/cote-dor/ | `/zones-intervention/cote-dor/` | 375 px | ×8 | 45.11 % | À VALIDER |
| 4 | departement — /zones-intervention/cote-dor/ | `/zones-intervention/cote-dor/` | 1440 px | ×8 | 42.52 % | À VALIDER |
| 5 | departement — /zones-intervention/doubs/ | `/zones-intervention/doubs/` | 375 px | ×8 | 41.10 % | À VALIDER |
| 6 | departement — /zones-intervention/doubs/ | `/zones-intervention/doubs/` | 1440 px | ×8 | 46.20 % | À VALIDER |
| 7 | departement — /zones-intervention/jura/ | `/zones-intervention/jura/` | 375 px | ×8 | 39.25 % | À VALIDER |
| 8 | departement — /zones-intervention/jura/ | `/zones-intervention/jura/` | 1440 px | ×8 | 45.54 % | À VALIDER |
| 9 | departement — /zones-intervention/nievre/ | `/zones-intervention/nievre/` | 375 px | ×8 | 41.87 % | À VALIDER |
| 10 | departement — /zones-intervention/nievre/ | `/zones-intervention/nievre/` | 1440 px | ×8 | 43.82 % | À VALIDER |
| 11 | departement — /zones-intervention/haute-saone/ | `/zones-intervention/haute-saone/` | 375 px | ×8 | 40.23 % | À VALIDER |
| 12 | departement — /zones-intervention/haute-saone/ | `/zones-intervention/haute-saone/` | 1440 px | ×8 | 42.30 % | À VALIDER |
| 13 | departement — /zones-intervention/saone-et-loire/ | `/zones-intervention/saone-et-loire/` | 375 px | ×8 | 38.65 % | À VALIDER |
| 14 | departement — /zones-intervention/saone-et-loire/ | `/zones-intervention/saone-et-loire/` | 1440 px | ×8 | 44.90 % | À VALIDER |
| 15 | departement — /zones-intervention/yonne/ | `/zones-intervention/yonne/` | 375 px | ×8 | 40.41 % | À VALIDER |
| 16 | departement — /zones-intervention/yonne/ | `/zones-intervention/yonne/` | 1440 px | ×8 | 44.00 % | À VALIDER |
| 17 | departement — /zones-intervention/territoire-de-belfort/ | `/zones-intervention/territoire-de-belfort/` | 375 px | ×8 | 41.11 % | À VALIDER |
| 18 | departement — /zones-intervention/territoire-de-belfort/ | `/zones-intervention/territoire-de-belfort/` | 1440 px | ×8 | 42.51 % | À VALIDER |
| 19 | ville — /zones-intervention/doubs/besancon/ | `/zones-intervention/doubs/besancon/` | 375 px | ×8 | 45.05 % | À VALIDER |
| 20 | ville — /zones-intervention/doubs/besancon/ | `/zones-intervention/doubs/besancon/` | 1440 px | ×8 | 36.07 % | À VALIDER |
| 21 | ville — /zones-intervention/jura/dole/ | `/zones-intervention/jura/dole/` | 375 px | ×8 | 41.95 % | À VALIDER |
| 22 | ville — /zones-intervention/jura/dole/ | `/zones-intervention/jura/dole/` | 1440 px | ×8 | 41.07 % | À VALIDER |
| 23 | ville — /zones-intervention/jura/lons-le-saunier/ | `/zones-intervention/jura/lons-le-saunier/` | 375 px | ×8 | 43.49 % | À VALIDER |
| 24 | ville — /zones-intervention/jura/lons-le-saunier/ | `/zones-intervention/jura/lons-le-saunier/` | 1440 px | ×8 | 35.54 % | À VALIDER |
| 25 | ville — /zones-intervention/nievre/nevers/ | `/zones-intervention/nievre/nevers/` | 375 px | ×8 | 40.33 % | À VALIDER |
| 26 | ville — /zones-intervention/nievre/nevers/ | `/zones-intervention/nievre/nevers/` | 1440 px | ×8 | 33.80 % | À VALIDER |
| 27 | ville — /zones-intervention/haute-saone/vesoul/ | `/zones-intervention/haute-saone/vesoul/` | 375 px | ×8 | 44.25 % | À VALIDER |
| 28 | ville — /zones-intervention/haute-saone/vesoul/ | `/zones-intervention/haute-saone/vesoul/` | 1440 px | ×8 | 35.97 % | À VALIDER |
| 29 | ville — /zones-intervention/saone-et-loire/chalon-sur-saone/ | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 375 px | ×8 | 43.43 % | À VALIDER |
| 30 | ville — /zones-intervention/saone-et-loire/chalon-sur-saone/ | `/zones-intervention/saone-et-loire/chalon-sur-saone/` | 1440 px | ×8 | 36.18 % | À VALIDER |
| 31 | ville — /zones-intervention/saone-et-loire/macon/ | `/zones-intervention/saone-et-loire/macon/` | 375 px | ×8 | 42.45 % | À VALIDER |
| 32 | ville — /zones-intervention/saone-et-loire/macon/ | `/zones-intervention/saone-et-loire/macon/` | 1440 px | ×8 | 36.18 % | À VALIDER |
| 33 | ville — /zones-intervention/yonne/auxerre/ | `/zones-intervention/yonne/auxerre/` | 375 px | ×8 | 42.60 % | À VALIDER |
| 34 | ville — /zones-intervention/yonne/auxerre/ | `/zones-intervention/yonne/auxerre/` | 1440 px | ×8 | 36.44 % | À VALIDER |
| 35 | ville — /zones-intervention/territoire-de-belfort/belfort/ | `/zones-intervention/territoire-de-belfort/belfort/` | 375 px | ×8 | 44.29 % | À VALIDER |
| 36 | ville — /zones-intervention/territoire-de-belfort/belfort/ | `/zones-intervention/territoire-de-belfort/belfort/` | 1440 px | ×8 | 36.07 % | À VALIDER |
| 37 | commune — /zones-intervention/cote-dor/saint-apollinaire/ | `/zones-intervention/cote-dor/saint-apollinaire/` | 375 px | ×8 | 41.53 % | À VALIDER |
| 38 | commune — /zones-intervention/cote-dor/saint-apollinaire/ | `/zones-intervention/cote-dor/saint-apollinaire/` | 1440 px | ×8 | 42.27 % | À VALIDER |
| 39 | commune — /zones-intervention/cote-dor/chenove/ | `/zones-intervention/cote-dor/chenove/` | 375 px | ×8 | 42.07 % | À VALIDER |
| 40 | commune — /zones-intervention/cote-dor/chenove/ | `/zones-intervention/cote-dor/chenove/` | 1440 px | ×8 | 36.35 % | À VALIDER |
| 41 | commune — /zones-intervention/cote-dor/quetigny/ | `/zones-intervention/cote-dor/quetigny/` | 375 px | ×8 | 42.06 % | À VALIDER |
| 42 | commune — /zones-intervention/cote-dor/quetigny/ | `/zones-intervention/cote-dor/quetigny/` | 1440 px | ×8 | 38.65 % | À VALIDER |
| 43 | commune — /zones-intervention/cote-dor/talant/ | `/zones-intervention/cote-dor/talant/` | 375 px | ×8 | 40.42 % | À VALIDER |
| 44 | commune — /zones-intervention/cote-dor/talant/ | `/zones-intervention/cote-dor/talant/` | 1440 px | ×8 | 39.43 % | À VALIDER |
| 45 | commune — /zones-intervention/cote-dor/longvic/ | `/zones-intervention/cote-dor/longvic/` | 375 px | ×8 | 40.46 % | À VALIDER |
| 46 | commune — /zones-intervention/cote-dor/longvic/ | `/zones-intervention/cote-dor/longvic/` | 1440 px | ×8 | 42.48 % | À VALIDER |
| 47 | commune — /zones-intervention/cote-dor/fontaine-les-dijon/ | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 375 px | ×8 | 44.57 % | À VALIDER |
| 48 | commune — /zones-intervention/cote-dor/fontaine-les-dijon/ | `/zones-intervention/cote-dor/fontaine-les-dijon/` | 1440 px | ×8 | 37.04 % | À VALIDER |
| 49 | commune — /zones-intervention/cote-dor/marsannay-la-cote/ | `/zones-intervention/cote-dor/marsannay-la-cote/` | 375 px | ×8 | 46.09 % | À VALIDER |
| 50 | commune — /zones-intervention/cote-dor/marsannay-la-cote/ | `/zones-intervention/cote-dor/marsannay-la-cote/` | 1440 px | ×8 | 36.85 % | À VALIDER |
| 51 | commune — /zones-intervention/cote-dor/beaune/ | `/zones-intervention/cote-dor/beaune/` | 375 px | ×8 | 39.46 % | À VALIDER |
| 52 | commune — /zones-intervention/cote-dor/beaune/ | `/zones-intervention/cote-dor/beaune/` | 1440 px | ×8 | 42.35 % | À VALIDER |

## Total

**110 comparaisons**, toutes au statut **À VALIDER**. Aucune n est validée d avance.

Le taux de pixels différents n est **pas** une note de fidélité : une page plus longue d un côté
colorie toute la zone manquante, et un décalage vertical colorie tout ce qui suit. Il indique où
regarder, pas s il y a un défaut.
