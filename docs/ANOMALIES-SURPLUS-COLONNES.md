# Anomalies « carte supplémentaire » et « colonnes » — classement exhaustif

> Fichier **généré** par `node tools/classer-anomalies.mjs` depuis `docs/inventaire-cartes.json`.
> Ne pas éditer à la main. Le détail machine-lisible est dans `docs/anomalies-g22.json`.

**11 occurrences** — 11 cartes supplémentaires, 0 écarts de colonnes.

## Synthèse par cause

| Cause | Occurrences | Catégorie | Statut |
|---|---:|---|---|
| Carte note + tarif de la colonne d’information du contact | 2 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Bouton d’appel à l’action contextuel | 1 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Pastilles et bandeaux tarifaires au libellé reformulé | 4 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Bande de réassurance de l’accueil sans la note Google | 2 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Encart cookies : l’état réel des traceurs, absent du prototype | 2 | `DIFFERENCE_LEGALE_IMPOSEE` | CLASSÉE |

## Carte note + tarif de la colonne d’information du contact

**Catégorie :** `DIFFERENCE_EDITORIALE_AUTORISEE` · **Statut :** CLASSÉE · **Sévérité :** nulle · **2 occurrence(s)**

- **Composant** — page-contact.php — carte de réassurance de la colonne d’information
- **Maquette** — Carte marine « ★★★★★ 5,0/5 · 27 € HT/h » (512×68), sans autre mention.
- **WordPress** — « ★★★★★ 5,0/5 sur Google · 27 € HT/h — tarif unique en région » (512×75) : la mention « sur Google » est exigée pour une note de plateforme tierce (CLAUDE.md §5.5), et le tarif est qualifié de régional (§5.3).
- **Preuve** — Vidage détaillé du contact à 1440 px : mêmes cartes, même bande, même largeur ; les 7 px d’écart viennent du texte plus long. L’appariement échoue sur les mots ajoutés, pas sur la géométrie.
- **Correction** — Aucune : les deux mentions sont imposées par le cahier des charges.
- **Non-régression** — tests/fidelite.spec.js — la note n’apparaît jamais sans « sur Google ».

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/contact` | 375 | 4 | `tarif` | — | ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région |
| `#/contact` | 1440 | 4 | `tarif` | — | ★★★★★ 5,0/5 sur Google 27 € HT/h — tarif unique en région |

## Bouton d’appel à l’action contextuel

**Catégorie :** `DIFFERENCE_EDITORIALE_AUTORISEE` · **Statut :** CLASSÉE · **Sévérité :** nulle · **1 occurrence(s)**

- **Composant** — single-zone.php — CTA « Demander un devis à {zone} »
- **Maquette** — Le prototype n’a pas toujours de bouton contextualisé à cet endroit.
- **WordPress** — Le thème ajoute le CTA contextuel imposé : « Demander un devis à {zone} », avec sa réassurance.
- **Preuve** — CLAUDE.md §8 — exigence de conversion, pas une dérive.
- **Correction** — Aucune.
- **Non-régression** — Couvert par la suite de conversion.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/departement/saone-et-loire` | 375 | 11 | `micro-carte` | — | Demander un devis en Saône-et-Loire |

## Pastilles et bandeaux tarifaires au libellé reformulé

**Catégorie :** `DIFFERENCE_EDITORIALE_AUTORISEE` · **Statut :** CLASSÉE · **Sévérité :** nulle · **4 occurrence(s)**

- **Composant** — template-parts/home/hero.php · pricing-reassurance.php · static-blocks (région)
- **Maquette** — « 27 € HT/h — régulier ou ponctuel » (hero), « tarif unique en région » (bandeaux). La pastille marine mesure 238×56 : rangée flex, écart 12, prix 22 px/800, libellé 12,5 px sur deux lignes.
- **WordPress** — Mêmes composants, libellés reformulés — « tarif unique, régulier ou ponctuel », « tarif unique, indiqué avant le devis » : le libellé plus long se replie sur trois lignes au lieu de deux (66 px contre 56), et l’appariement par texte échoue sur les mots ajoutés.
- **Preuve** — Sonde G22 accueil : la pastille marine WordPress est DÉJÀ une rangée flex gap 12, pad 10/16 — structure identique à la maquette ; seule la longueur du libellé diffère. Le hero (63 px) concorde déjà au pixel.
- **Correction** — Aucune sur la structure. Le libellé est un choix éditorial des phases précédentes ; le raccourcir relèverait d’une décision d’Emmanuel, pas d’une passe de fidélité.
- **Non-régression** — tests/tarifs.spec.js — les montants restent ceux de PROJECT_INPUTS.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 375 | 1 | `tarif` | — | 27 € HT/h tarif unique, régulier ou ponctuel |
| `#/` | 375 | 2 | `tarif` | — | 27 € HT/h tarif unique, indiqué avant le devis |
| `#/` | 1440 | 1 | `tarif` | — | 27 € HT/h tarif unique, régulier ou ponctuel |
| `#/` | 1440 | 2 | `tarif` | — | 27 € HT/h tarif unique, indiqué avant le devis |

## Bande de réassurance de l’accueil sans la note Google

**Catégorie :** `DIFFERENCE_EDITORIALE_AUTORISEE` · **Statut :** CLASSÉE · **Sévérité :** nulle · **2 occurrence(s)**

- **Composant** — template-parts/home/pricing-reassurance.php
- **Maquette** — La bande de réassurance s’ouvre sur « ★★★★★ 5,0/5 sur Google » puis déroule les faits.
- **WordPress** — Même bande, mêmes faits, sans répéter la note : une preuve dans le hero + une section avis suffisent.
- **Preuve** — CLAUDE.md §9 impose de ne pas répéter la note Google sur l’accueil. Vidage 1440 px : la carte WordPress fait 1180×114 comme celle de la maquette — seule l’amorce étoilée manque, et l’appariement par préfixe échoue dessus.
- **Correction** — Aucune : la répétition est interdite.
- **Non-régression** — tests/fidelite.spec.js — une seule note sur l’accueil.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 375 | 3 | `carte-titre-texte` | — | Saint-Apollinaire Entreprise régionale basée en BFC Interloc |
| `#/` | 1440 | 3 | `carte-titre-texte` | — | Saint-Apollinaire Entreprise régionale basée en BFC Interloc |

## Encart cookies : l’état réel des traceurs, absent du prototype

**Catégorie :** `DIFFERENCE_LEGALE_IMPOSEE` · **Statut :** CLASSÉE · **Sévérité :** nulle · **2 occurrence(s)**

- **Composant** — page-gestion-des-cookies.php
- **Maquette** — La page cookies du prototype porte une NOTE DE CHANTIER beige : « Page à compléter avant publication… » — un contenu impubliable.
- **WordPress** — Un encart factuel : « Aucun cookie de mesure d’audience ni de traçage publicitaire » — l’état réel de l’installation, aucun outil de tracking n’étant posé (CLAUDE.md §6).
- **Preuve** — Vidage 1440 px des deux côtés : la maquette n’a que la note de chantier, le thème que l’encart factuel.
- **Correction** — Aucune : le contenu réglementaire prime (même exception que G20 pour les trois pages légales).
- **Non-régression** — tests/legal.spec.js.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/gestion-des-cookies` | 375 | 3 | `carte-titre-texte` | — | Aucun cookie de mesure d'audience ni de traçage publicitaire |
| `#/gestion-des-cookies` | 1440 | 3 | `carte-titre-texte` | — | Aucun cookie de mesure d'audience ni de traçage publicitaire |

