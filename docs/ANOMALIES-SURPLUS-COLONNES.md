# Anomalies « carte supplémentaire » et « colonnes » — classement exhaustif

> Fichier **généré** par `node tools/classer-anomalies.mjs` depuis `docs/inventaire-cartes.json`.
> Ne pas éditer à la main. Le détail machine-lisible est dans `docs/anomalies-g22.json`.

**43 occurrences** — 35 cartes supplémentaires, 8 écarts de colonnes.

## Synthèse par cause

| Cause | Occurrences | Catégorie | Statut |
|---|---:|---|---|
| Badge Google rendu en pastille dans les bandes de réassurance | 15 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Carte note + tarif de la colonne d’information du contact | 2 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Témoignage de la page tarifs : citation nue dans la maquette, carte dans le thème | 2 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Bouton d’appel à l’action contextuel | 1 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Pastilles et bandeaux tarifaires au libellé reformulé | 4 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Bande de réassurance de l’accueil sans la note Google | 2 | `DIFFERENCE_EDITORIALE_AUTORISEE` | CLASSÉE |
| Les quatre autres prestations de l’accueil : carte segmentée claire contre cartes marine | 6 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Encart cookies : l’état réel des traceurs, absent du prototype | 2 | `DIFFERENCE_LEGALE_IMPOSEE` | CLASSÉE |
| Liens de département de l’accueil rendus sur deux lignes | 2 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Carte de couverture régionale seule sur sa rangée | 1 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Bande tarifaire des pages prestation : l’alignement centré décale les ordonnées | 5 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |
| Bande tarifaire de la page région : trois colonnes de zone, pas une grille de deux cartes | 1 | `DEFAUT_THEME` | CONFIRMÉ — correction identifiée, non écrite |

## Badge Google rendu en pastille dans les bandes de réassurance

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** mineure · **15 occurrence(s)**

- **Composant** — .tfp-google-badge--inline (includes/testimonials.php)
- **Maquette** — Sur les pages intérieures, le badge est un LIEN NU dans la bande de réassurance — mesuré sur /nos-prestations : `<a>` 165×21, sans fond, sans rayon, dans une ligne « 27 € HT/h · Devis gratuit sous 24 h · ★★★★★ 5,0/5 » de 30 px. Seul le hero de l’accueil le compose en pastille blanche (310×44, rayon plein).
- **WordPress** — Le thème rend partout la pastille blanche du hero (204×38, fond blanc, filet, rayon plein) : sur les bandes de réassurance, l’inventaire la compte pour une carte de plus.
- **Preuve** — Sonde G22 sur /nos-prestations à 1440 px : maquette A 165×21 rayon 0 fond transparent ; WordPress chip 204×38 rayon 100 fond blanc. Même texte, chrome différent.
- **Correction** — À écrire : variante nue du badge pour les bandes de réassurance des pages intérieures — le hero de l’accueil garde sa pastille, conforme à sa maquette. Aucun changement de données : la note reste celle des réglages (CLAUDE.md §5.5).
- **Non-régression** — tests/provisoire.spec.js et tests/fidelite.spec.js verrouillent la présence et le balisage du badge.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/nettoyage-professionnel` | 1440 | 2 | `chip` | 1 colonne(s) → 2 colonne(s) | ★★★★★5,0/5sur Google |
| `#/nos-prestations` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/nos-prestations` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/zones-intervention` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/zones-intervention` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/bourgogne-franche-comte` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/bourgogne-franche-comte` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/pourquoi-top-famille-pro` | 375 | 4 | `carte-titre` | — | 5,0/5 sur Google |
| `#/pourquoi-top-famille-pro` | 1440 | 4 | `carte-titre` | — | 5,0/5 sur Google |
| `#/notre-fonctionnement` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/notre-fonctionnement` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/a-propos` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/a-propos` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/recrutement` | 375 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |
| `#/recrutement` | 1440 | 2 | `chip` | — | ★★★★★5,0/5 sur Google |

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

## Témoignage de la page tarifs : citation nue dans la maquette, carte dans le thème

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** mineure · **2 occurrence(s)**

- **Composant** — page-tarifs.php → tfp_testimonial_card()
- **Maquette** — La citation « Un devis clair, sans surprise… » est posée NUE : blockquote sans fond, sans filet, sans rayon — aucun ancêtre encadré jusqu’au corps de page (sonde G22, 1440 px).
- **WordPress** — Le thème la rend dans la carte témoignage commune : 820×258, fond blanc, rayon 18.
- **Preuve** — Sonde G22 : la remontée d’ancêtres depuis le blockquote de la maquette ne trouve aucune carte.
- **Correction** — À écrire : variante nue du témoignage pour cette instance, en CONSERVANT le marquage provisoire (`data-tfp-provisional` + mention visible, CLAUDE.md §5.5).
- **Non-régression** — tests/provisoire.spec.js — marquage exigé quelle que soit la forme.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/nos-tarifs` | 375 | 11 | `temoignage` | — | ★★★★★« Un devis clair, sans surprise, et le même tarif horai |
| `#/nos-tarifs` | 1440 | 11 | `temoignage` | — | ★★★★★« Un devis clair, sans surprise, et le même tarif horai |

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

## Les quatre autres prestations de l’accueil : carte segmentée claire contre cartes marine

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** majeure · **6 occurrence(s)**

- **Composant** — template-parts/home/services.php
- **Maquette** — UNE carte segmentée claire de 1180×123 : grille `repeat(auto-fit, minmax(min(100%, 220px), 1fr))`, `gap: 1px` sur fond #DCE7EB — le fond affleure entre les cellules et dessine les séparations — rayon 16, `overflow: hidden` ; cellules blanches 294×121, rembourrage 20/22, intitulé 17 px/700, description 13,5 px/400.
- **WordPress** — Quatre cartes MARINE détachées (294×115, fond #174A81), écart franc entre elles.
- **Preuve** — Sonde G22 accueil 1440 px : styles déclarés relevés sur la maquette, rendu mesuré des deux côtés.
- **Correction** — À écrire : rendre la bande en carte segmentée claire (grille gap 1px, cellules blanches), la géométrie ci-dessus étant déjà relevée.
- **Non-régression** — tests/fidelite.spec.js — l’ordre des 13 blocs de l’accueil est verrouillé.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 375 | 5 | `carte-sombre` | — | Copropriétés & parties communes Halls, cages d'escalier, loc |
| `#/` | 375 | 5 | `carte-sombre` | — | Locations meublées & hébergements Remise en état entre deux  |
| `#/` | 375 | 5 | `carte-sombre` | — | Ponctuel & remise en état Après travaux, grand nettoyage, fi |
| `#/` | 1440 | 5 | `carte-sombre` | — | Copropriétés & parties communes Halls, cages d'escalier, loc |
| `#/` | 1440 | 5 | `carte-sombre` | — | Locations meublées & hébergements Remise en état entre deux  |
| `#/` | 1440 | 5 | `carte-sombre` | — | Ponctuel & remise en état Après travaux, grand nettoyage, fi |

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

## Liens de département de l’accueil rendus sur deux lignes

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** mineure · **2 occurrence(s)**

- **Composant** — template-parts/home/coverage.php
- **Maquette** — Chaque lien de département tient sur UNE ligne de 49 px : rangée flex `space-between`, nom à gauche, numéro à droite (187×49, rayon 11, rembourrage 12/15).
- **WordPress** — Nom et numéro empilés : la rangée qui porte « Territoire de Belfort » se replie et s’étire à 75 px — au-dessus du seuil qui sépare une commande d’une carte, d’où deux cartes comptées en surplus.
- **Preuve** — Sonde G22 accueil 1440 px : maquette 187×49 une ligne ; WordPress 177×75 deux lignes.
- **Correction** — À écrire : même motif que le lien de ville (rangée flex, déjà corrigé sur les pages de zones).
- **Non-régression** — tests/cartes.spec.js — le motif une-ligne est éprouvé sur les liens de ville.

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 1440 | 10 | `carte-titre` | — | Yonne 89 |
| `#/` | 1440 | 10 | `carte-titre` | — | Territoire de Belfort 90 |

## Carte de couverture régionale seule sur sa rangée

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** majeure · **1 occurrence(s)**

- **Composant** — template-parts/home/coverage.php
- **Maquette** — La carte-carte des huit départements (542×394) partage sa rangée avec la colonne de liens.
- **WordPress** — Elle occupe sa rangée seule (562×317), les liens empilés dessous.
- **Preuve** — Vidage accueil 1440 px : colonnes 2 → 1, géométrie relevée des deux côtés.
- **Correction** — À écrire : rangée à deux colonnes sur la bande de couverture, avec les liens en ligne (cause voisine).
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/` | 1440 | 10 | `carte-image` | 2 colonne(s) → 1 colonne(s) | 21 25 39 58 70 71 89 90 |

## Bande tarifaire des pages prestation : l’alignement centré décale les ordonnées

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** mineure · **5 occurrence(s)**

- **Composant** — single-prestation.php — bande « Exemple · 12 h/mois »
- **Maquette** — Rangée flex `align-items: center`, écart clamp(28px, 4vw, 48px) : la carte Exemple (536×265, flex 1 1 300px, rembourrage 28, rayon 18) et le témoignage (596×212) ont des ordonnées DÉCALÉES — chacun compte pour une colonne de 1.
- **WordPress** — Même rangée alignée en haut : les deux boîtes partagent leur ordonnée et comptent 2 colonnes ; la carte mesure 562×223 (rembourrage et typographie non relevés).
- **Preuve** — Sonde G22 /service/commerces 1440 px : styles déclarés maquette + boîtes mesurées des deux côtés.
- **Correction** — À écrire : `align-items: center` + géométrie de carte relevée (28 px, rayon 18, base 300).
- **Non-régression** — —

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/service/commerces` | 1440 | 10 | `tarif` | 1 colonne(s) → 2 colonne(s) | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/cabinets` | 1440 | 11 | `tarif` | 1 colonne(s) → 2 colonne(s) | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/coproprietes` | 1440 | 10 | `tarif` | 1 colonne(s) → 2 colonne(s) | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/meubles` | 1440 | 10 | `tarif` | 1 colonne(s) → 2 colonne(s) | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |
| `#/service/ponctuel` | 1440 | 10 | `tarif` | 1 colonne(s) → 2 colonne(s) | Exemple · 12 h/mois333 € HT/mois12 h × 27 € + 9 € de gestion |

## Bande tarifaire de la page région : trois colonnes de zone, pas une grille de deux cartes

**Catégorie :** `DEFAUT_THEME` · **Statut :** CONFIRMÉ — correction identifiée, non écrite · **Sévérité :** majeure · **1 occurrence(s)**

- **Composant** — page-bourgogne-franche-comte.php — bande tarifaire
- **Maquette** — La bande reprend l’architecture `.tfp-zone-tarif` des pages de zone : texte, exemple (flex 1 1 250px, min 260 — relevé G22), témoignage — trois colonnes de 394/344/374.
- **WordPress** — Deux cartes de 573 px sur une grille statique : l’exemple et le témoignage, le texte au-dessus.
- **Preuve** — Vidage région 1440 px + style déclaré `flex: 1 1 250px; min-width: min(100%, 260px)` relevé sur la carte maquette.
- **Correction** — À écrire : rendre cette bande avec le composant `.tfp-zone-tarif` (G09), déjà exact sur 26 routes.
- **Non-régression** — La bande de zone est verrouillée par la baseline (G09).

| Route | Largeur | Bande | Archétype | Prototype → thème | Contenu |
|---|---:|---:|---|---|---|
| `#/bourgogne-franche-comte` | 1440 | 9 | `tarif` | 3 colonne(s) → 2 colonne(s) | Exemple · bureaux réguliers, 12 h/mois333 € HT/mois12 h × 27 |

