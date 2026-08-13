# Inventaire des grilles — maquette ↔ WordPress

> Généré par `node tools/inventaire-grilles.mjs`. Le JSON (`docs/inventaire-grilles.json`) est la référence ; ce fichier n’en est qu’une vue. Le relevé brut, reprenable, est dans `docs/inventaire-grilles.brut.json`.

Relevé sur 53 routes, aux largeurs 768 px. 119 grilles distinctes.

**27 grilles divergent** sur au moins une largeur. 27 divergent à 768 px.

| # | Sélecteur | Gabarits | Routes | Colonnes (768) | Largeurs divergentes | Seuil fixe | Intrinsèque |
| - | --------- | -------- | -----: | ------------------------- | -------------------- | ---------- | ----------- |
| 1 | `.tfp-flex` | commune, ville | 17 | 6 | 320, 375, 768 | — | **non** |
| 2 | `.tfp-zone-band__row` | commune, departement, ville | 26 | **2→1** | 768 | — | **non** |
| 3 | `.tfp-container.tfp-zone-tarif` | commune, departement, ville | 26 | **2→1** | 768 | (max-width: 979px) | **non** |
| 4 | `.tfp-flex` | departement | 8 | **3→6** | 320, 375, 768 | — | **non** |
| 5 | `.tfp-flex` | departement | 8 | **3→6** | 320, 375, 768 | — | **non** |
| 6 | `.tfp-zone-links-grid` | commune, ville | 18 | **2→1** | 768 | — | **non** |
| 7 | `.tfp-flex` | ville | 6 | **2→6** | 320, 375, 768 | — | **non** |
| 8 | `.tfp-flex` | departement | 3 | **3→6** | 320, 375, 768 | — | **non** |
| 9 | `.tfp-zone-links-grid` | departement | 8 | **2→1** | 768 | — | **non** |
| 10 | `.tfp-container.tfp-two-col` | accueil, prestation | 7 | 1 | 768 | — | oui |
| 11 | `.tfp-list-plain` | pilier, ville | 3 | **4→1** | 375, 768 | (max-width: 599px) ; (max-width: 899px) | **non** |
| 12 | `.tfp-chip-list` | prestation | 5 | **3→7** | 768 | — | **non** |
| 13 | `.tfp-card-grid.tfp-card-grid--1.tfp-card-grid--dark` | hub-zones, pilier, region | 3 | **2→1** | 768 | (max-width: 599px) | **non** |
| 14 | `.tfp-flex` | article | 3 | **3→2** | 768 | — | **non** |
| 15 | `.tfp-container.tfp-two-col` | accueil, prestation | 2 | 1 | 768 | — | oui |
| 16 | `.tfp-flex` | departement | 1 | **2→5** | 375, 768 | — | **non** |
| 17 | `.tfp-chip-list` | contact | 1 | **2→3** | 320, 768 | — | **non** |
| 18 | `.tfp-container.tfp-grid.tfp-grid--autofit-md` | plan-du-site | 1 | **4→3** | 320, 768 | — | **non** |
| 19 | `.tfp-static-grid.tfp-static-grid--3` | pilier | 1 | **2→1** | 768 | — | **non** |
| 20 | `.tfp-chip-list` | prestation | 1 | **3→7** | 768 | — | **non** |
| 21 | `.tfp-price-headline` | tarifs | 1 | **2→1** | 768 | (min-width: 820px) | **non** |
| 22 | `.tfp-container.tfp-two-col` | tarifs | 1 | **2→1** | 768 | — | oui |
| 23 | `.tfp-grid.tfp-grid--autofit-md` | tarifs | 1 | **2→3** | 768 | — | **non** |
| 24 | `.tfp-card-grid.tfp-card-grid--2` | hub-zones | 1 | **1→2** | 768 | (max-width: 599px) | **non** |
| 25 | `.tfp-grid.tfp-grid--autofit-md` | index-conseils | 1 | **2→3** | 768 | — | **non** |
| 26 | `.tfp-card-grid.tfp-card-grid--1` | contact | 1 | **2→1** | 768 | (max-width: 599px) | **non** |
| 27 | `.tfp-contact-form__row` | contact | 1 | **3→2** | 768 | (max-width: 599px) | **non** |
| 28 | `.tfp-hero__eyebrow` | commune, departement, hub-zones, index-p | 42 | 2 | — | (max-width: 600px) | **non** |
| 29 | `.tfp-flex` | commune, departement, hub-zones, index-p | 41 | · | — | — | **non** |
| 30 | `.tfp-list-plain` | commune, departement, ville | 26 | 2 | — | (max-width: 599px) ; (max-width: 899px) | **non** |
| 31 | `.tfp-zone-band__items` | commune, departement, ville | 26 | · | — | — | oui |
| 32 | `.tfp-cta-block__actions` | commune, tarifs, ville | 19 | 2 | — | — | **non** |
| 33 | `.tfp-service-tiles` | commune, ville | 18 | 2 | — | (max-width: 1099px) ; (max-width: 599px) | **non** |
| 34 | `.tfp-zone-links-grid` | commune, ville | 18 | 1 | — | — | **non** |
| 35 | `.tfp-flex` | commune, ville | 18 | 4 | — | — | **non** |
| 36 | `.tfp-list-plain` | commune, ville | 13 | 2 | — | (max-width: 599px) ; (max-width: 899px) | **non** |
| 37 | `.tfp-cta-block__actions` | departement | 8 | 2 | — | — | **non** |
| 38 | `.tfp-container.tfp-two-col` | accueil, prestation | 7 | 1 | — | — | oui |
| 39 | `.tfp-cta-block__actions` | accueil, prestation | 6 | 2 | — | — | **non** |
| 40 | `.tfp-container.tfp-two-col` | prestation | 6 | 1 | — | — | oui |
| 41 | `.tfp-list-plain` | prestation | 6 | 2 | — | — | **non** |
| 42 | `.tfp-list-marked` | prestation | 6 | · | — | — | **non** |
| 43 | `.tfp-situation-grid` | prestation | 5 | 2 | — | (max-width: 699px) | **non** |
| 44 | `.tfp-grid.tfp-grid--autofit-lg` | prestation | 5 | 2 | — | — | **non** |
| 45 | `.tfp-detail-grid` | prestation | 5 | 2 | — | (max-width: 1099px) ; (max-width: 699px) | **non** |
| 46 | `.tfp-detail-grid.tfp-detail-grid--orga` | prestation | 5 | 2 | — | (max-width: 1099px) ; (max-width: 699px) | **non** |
| 47 | `.tfp-container.tfp-two-col` | prestation | 5 | 1 | — | — | oui |
| 48 | `.tfp-contact-nudge` | prestation | 5 | 1 | — | — | **non** |
| 49 | `.tfp-card-grid.tfp-card-grid--3` | hub-zones, index-prestations, institutio | 4 | 2 | — | — | **non** |
| 50 | `.tfp-card-grid.tfp-card-grid--4` | hub-zones, institutionnelle, region | 3 | 2 | — | — | **non** |
| 51 | `.tfp-article__meta` | article | 3 | 5 | — | — | **non** |
| 52 | `.tfp-cta-block__actions` | article | 3 | 2 | — | — | **non** |
| 53 | `ul` | article | 3 | · | — | — | **non** |
| 54 | `.tfp-list-excluded` | article | 3 | · | — | (min-width: 820px) | **non** |
| 55 | `.tfp-grid.tfp-grid--autofit-lg` | accueil, prestation | 2 | 2 | — | — | **non** |
| 56 | `.tfp-card-grid.tfp-card-grid--4` | index-prestations, institutionnelle | 2 | 2 | — | — | **non** |
| 57 | `.tfp-card-grid.tfp-card-grid--6` | hub-zones, region | 2 | 3 | — | — | **non** |
| 58 | `.tfp-hero__actions` | accueil | 1 | 2 | — | — | **non** |
| 59 | `.tfp-price-band` | accueil | 1 | 2 | — | — | **non** |
| 60 | `.tfp-reassurance` | accueil | 1 | 3 | — | — | **non** |
| 61 | `.tfp-audiences__list` | accueil | 1 | 3 | — | — | **non** |
| 62 | `.tfp-flex.tfp-flex--between` | accueil | 1 | 2 | — | — | **non** |
| 63 | `.tfp-grid.tfp-grid--autofit-lg` | accueil | 1 | 2 | — | — | **non** |
| 64 | `.tfp-grid--divided.tfp-grid.tfp-grid--autofit-md` | accueil | 1 | 3 | — | — | **non** |
| 65 | `.tfp-container.tfp-why` | accueil | 1 | 1 | — | — | oui |
| 66 | `.tfp-flex.tfp-flex--between` | accueil | 1 | 2 | — | — | **non** |
| 67 | `.tfp-grid` | accueil | 1 | 3 | — | — | oui |
| 68 | `.tfp-grid` | accueil | 1 | 4 | — | — | oui |
| 69 | `.tfp-flex` | accueil | 1 | 2 | — | — | **non** |
| 70 | `.tfp-flex.tfp-flex--between` | accueil | 1 | 2 | — | — | **non** |
| 71 | `.tfp-grid.tfp-grid--autofit-lg` | accueil | 1 | 2 | — | — | **non** |
| 72 | `.tfp-static-grid.tfp-static-grid--2` | pilier | 1 | 1 | — | — | **non** |
| 73 | `.tfp-card-grid.tfp-card-grid--3` | pilier | 1 | 2 | — | — | **non** |
| 74 | `.tfp-card-grid.tfp-card-grid--4.tfp-card-grid--dark` | pilier | 1 | 2 | — | — | **non** |
| 75 | `.tfp-card-grid.tfp-card-grid--3` | pilier | 1 | 2 | — | — | **non** |
| 76 | `.tfp-card-grid.tfp-card-grid--3.tfp-card-grid--dark` | pilier | 1 | 3 | — | — | **non** |
| 77 | `.tfp-card-grid.tfp-card-grid--4.tfp-card-grid--dark` | pilier | 1 | 2 | — | — | **non** |
| 78 | `.tfp-static-grid.tfp-static-grid--3` | pilier | 1 | 2 | — | — | **non** |
| 79 | `.tfp-static-grid.tfp-static-grid--2` | pilier | 1 | 1 | — | — | **non** |
| 80 | `.tfp-card-grid.tfp-card-grid--4` | pilier | 1 | 2 | — | — | **non** |
| 81 | `.tfp-card-grid.tfp-card-grid--3` | pilier | 1 | 2 | — | — | **non** |
| 82 | `.tfp-card-grid.tfp-card-grid--3` | pilier | 1 | 2 | — | — | **non** |
| 83 | `.tfp-card-grid.tfp-card-grid--3` | pilier | 1 | · | — | — | **non** |
| 84 | `.tfp-static-grid.tfp-static-grid--2` | index-prestations | 1 | 1 | — | — | **non** |
| 85 | `.tfp-tile-grid--dark` | prestation | 1 | 2 | — | (max-width: 1099px) ; (max-width: 599px) | **non** |
| 86 | `.tfp-situation-grid` | prestation | 1 | 2 | — | (max-width: 699px) | **non** |
| 87 | `.tfp-detail-grid` | prestation | 1 | 2 | — | (max-width: 1099px) ; (max-width: 699px) | **non** |
| 88 | `.tfp-detail-grid.tfp-detail-grid--orga` | prestation | 1 | 2 | — | (max-width: 1099px) ; (max-width: 699px) | **non** |
| 89 | `.tfp-contact-nudge` | prestation | 1 | 1 | — | — | **non** |
| 90 | `.tfp-cta-block__actions` | prestation | 1 | 2 | — | — | **non** |
| 91 | `.tfp-grid.tfp-grid--autofit-md` | tarifs | 1 | 3 | — | — | **non** |
| 92 | `.tfp-grid.tfp-grid--autofit-lg` | tarifs | 1 | 2 | — | — | **non** |
| 93 | `li` | tarifs | 1 | · | — | — | **non** |
| 94 | `li` | tarifs | 1 | · | — | — | **non** |
| 95 | `li` | tarifs | 1 | · | — | — | **non** |
| 96 | `li` | tarifs | 1 | · | — | — | **non** |
| 97 | `li` | tarifs | 1 | · | — | — | **non** |
| 98 | `.tfp-list-plain` | tarifs | 1 | · | — | — | **non** |
| 99 | `.tfp-list-plain` | tarifs | 1 | · | — | — | **non** |
| 100 | `.tfp-card-grid.tfp-card-grid--6` | hub-zones | 1 | 3 | — | — | **non** |
| 101 | `.tfp-card-grid.tfp-card-grid--3` | hub-zones | 1 | 2 | — | — | **non** |
| 102 | `.tfp-card-grid.tfp-card-grid--3` | region | 1 | 2 | — | — | **non** |
| 103 | `.tfp-card-grid.tfp-card-grid--4.tfp-card-grid--dark` | region | 1 | 2 | — | — | **non** |
| 104 | `.tfp-card-grid.tfp-card-grid--2` | region | 1 | 2 | — | — | **non** |
| 105 | `.tfp-flex` | ville | 1 | · | — | — | **non** |
| 106 | `.tfp-flex` | ville | 1 | · | — | — | **non** |
| 107 | `.tfp-theme-list` | index-conseils | 1 | 4 | — | — | **non** |
| 108 | `.tfp-grid.tfp-grid--autofit-md` | index-conseils | 1 | 2 | — | — | **non** |
| 109 | `.tfp-container.tfp-prefooter__inner` | index-conseils | 1 | 1 | — | — | oui |
| 110 | `.tfp-card-grid.tfp-card-grid--4` | institutionnelle | 1 | 4 | — | — | **non** |
| 111 | `.tfp-static-grid.tfp-static-grid--3` | institutionnelle | 1 | 2 | — | — | **non** |
| 112 | `.tfp-card-grid.tfp-card-grid--3` | institutionnelle | 1 | 2 | — | — | **non** |
| 113 | `.tfp-card-grid.tfp-card-grid--1` | institutionnelle | 1 | · | — | (max-width: 599px) | **non** |
| 114 | `.tfp-card-grid.tfp-card-grid--1.tfp-card-grid--dark` | institutionnelle | 1 | 1 | — | (max-width: 599px) | **non** |
| 115 | `.tfp-card-grid.tfp-card-grid--4` | institutionnelle | 1 | 2 | — | — | **non** |
| 116 | `.tfp-list-plain` | institutionnelle | 1 | 2 | — | — | **non** |
| 117 | `.tfp-card-grid.tfp-card-grid--2` | contact | 1 | 2 | — | (max-width: 599px) | **non** |
| 118 | `.tfp-container.tfp-contact-cols` | contact | 1 | 1 | — | (max-width: 899px) | **non** |
| 119 | `.tfp-field.tfp-field--check` | contact | 1 | · | — | — | **non** |

## Détail des grilles divergentes

### `.tfp-flex`

- **intitulé de bande** : Quartiers et zones d'activité
- **gabarits** : commune, ville — 17 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 8px;`
- **base de colonne maquette** : `background: rgb(221, 244, 243); border: 1px solid rgb(205, 235, 234); border-radius: 100px; padding: 8px 15px; font-size: 14px; font-weight: 600; color: rgb(23, 74, 129);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 6 → 6 | 707 → 707 | 60 → 71 | 8px → 16px |

### `.tfp-zone-band__row`

- **intitulé de bande** : —
- **gabarits** : commune, departement, ville — 26 routes
- **fichiers** : CSS src/css/04-components.css · PHP single-zone.php
- **règle déclarée par la maquette** : `background: rgb(221, 244, 243); border: 1px solid rgb(184, 228, 228); border-radius: 16px; padding: 14px 16px; display: flex; flex-wrap: wrap; align-items: center; gap: 14px clamp(16px, 2.4vw, 26px);`
- **base de colonne maquette** : `display: flex; align-items: center; gap: 12px; background: rgb(23, 74, 129); color: rgb(255, 255, 255); border-radius: 12px; padding: 10px 16px;` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-zone-band__row { display: flex; gap: 16px 26px; column-gap: 26px; row-gap: 16px; flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 675 → 673 | 136 → 257 | 14px 18.432px → 16px 26px |

### `.tfp-container.tfp-zone-tarif`

- **intitulé de bande** : Tarif et déplacements
- **gabarits** : commune, departement, ville — 26 routes
- **fichiers** : CSS src/css/03-layout.css · PHP 404.php, includes/components.php, index.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-conseils.php, page-contact.php, page-demande-de-devis.php, page-gestion-des-cookies.php, page-mentions-legales.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-plan-du-site.php, page-politique-de-confidentialite.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-tarifs.php, page-zones-intervention.php, page.php, single-prestation.php, single-zone.php, single.php, template-parts/components/static-blocks.php, template-parts/home/advice.php, template-parts/home/audiences.php, template-parts/home/audrey-reviews.php, template-parts/home/coverage.php, template-parts/home/pricing-reassurance.php, template-parts/home/pricing.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php, template-parts/home/why.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(22px, 3vw, 34px); align-items: stretch;`
- **base de colonne maquette** : `flex: 1 1 300px; min-width: min(100%, 280px);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-container { max-width: var(--container-max) } · .tfp-zone-tarif { display: grid; grid-template-columns: 1.14fr 1fr 1.09fr; gap: 34px; column-gap: 34px; row-gap: 34px } · @media (max-width: 979px) { .tfp-zone-tarif { grid-template-columns: 1fr; gap: 24px; column-gap: 24px; row-gap: 24px } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 979px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 317 → 707 | 23.04px → 24px |

### `.tfp-flex`

- **intitulé de bande** : Nos villes d'intervention dans le département
- **gabarits** : departement — 8 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 8px;`
- **base de colonne maquette** : `background: rgb(244, 247, 248); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 8px 15px; font-size: 14px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 6 ⚠️ | 338 → 707 | 71 → 64 | 8px → 16px |

### `.tfp-flex`

- **intitulé de bande** : Départements limitrophes couverts
- **gabarits** : departement — 8 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 10px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 9px 16px; font-size: 14.5px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 6 ⚠️ | 707 → 707 | 102 → 61 | 10px → 16px |

### `.tfp-zone-links-grid`

- **intitulé de bande** : Dans le même département
- **gabarits** : commune, ville — 18 routes
- **fichiers** : CSS src/css/04-components.css · PHP single-zone.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(28px, 4vw, 48px);`
- **base de colonne maquette** : `flex: 1 1 260px; min-width: min(100%, 260px);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-zone-links-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 340px), 1fr)); gap: clamp(28px, 4vw, 48px); column-gap: clamp(28px, 4vw, 48px); row-gap: clamp(28px, 4vw, 48px) }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 318 → 707 | 30.72px → 30.72px |

### `.tfp-flex`

- **intitulé de bande** : Dans le même département
- **gabarits** : ville — 6 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `margin-top: 12px; display: flex; flex-wrap: wrap; gap: 9px;`
- **base de colonne maquette** : `background: rgb(244, 247, 248); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 9px 16px; font-size: 14.5px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 6 ⚠️ | 358 → 707 | 138 → 71 | 9px → 16px |

### `.tfp-flex`

- **intitulé de bande** : Nos villes d'intervention dans le département
- **gabarits** : departement — 3 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 8px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 8px 15px; font-size: 14px; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 6 ⚠️ | 338 → 707 | 60 → 64 | 8px → 16px |

### `.tfp-zone-links-grid`

- **intitulé de bande** : Nos villes d'intervention dans le département
- **gabarits** : departement — 8 routes
- **fichiers** : CSS src/css/04-components.css · PHP single-zone.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(28px, 4vw, 48px);`
- **base de colonne maquette** : `flex: 1 1 320px; min-width: min(100%, 280px);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-zone-links-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 340px), 1fr)); gap: clamp(28px, 4vw, 48px); column-gap: clamp(28px, 4vw, 48px); row-gap: clamp(28px, 4vw, 48px) }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 338 → 707 | 30.72px → 30.72px |

### `.tfp-container.tfp-two-col`

- **intitulé de bande** : Une couverture régionale, pas des agences fictives
- **gabarits** : accueil, prestation — 7 routes
- **fichiers** : CSS src/css/03-layout.css · PHP 404.php, includes/components.php, index.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-conseils.php, page-contact.php, page-demande-de-devis.php, page-gestion-des-cookies.php, page-mentions-legales.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-plan-du-site.php, page-politique-de-confidentialite.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-tarifs.php, page-zones-intervention.php, page.php, single-prestation.php, single-zone.php, single.php, template-parts/components/static-blocks.php, template-parts/home/advice.php, template-parts/home/audiences.php, template-parts/home/audrey-reviews.php, template-parts/home/coverage.php, template-parts/home/pricing-reassurance.php, template-parts/home/pricing.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php, template-parts/home/why.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(30px, 4vw, 56px);`
- **base de colonne maquette** : `flex: 1 1 360px; min-width: min(100%, 320px);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-container { max-width: var(--container-max) } · .tfp-two-col { display: flex; gap: clamp(30px, 4vw, 56px); column-gap: clamp(30px, 4vw, 56px); row-gap: clamp(30px, 4vw, 56px); flex-wrap: wrap }`
- **base de colonne WordPress** : `380px` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 1 → 1 | 707 → 707 | 707 → 707 | 30.72px → 30.72px |

### `.tfp-list-plain`

- **intitulé de bande** : Les professionnels que nous accompagnons
- **gabarits** : pilier, ville — 3 routes
- **fichiers** : CSS src/css/04-components.css · PHP page-tarifs.php, single-prestation.php, single-zone.php, template-parts/components/static-blocks.php
- **règle déclarée par la maquette** : `margin-top: 16px; display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 150px), 1fr)); gap: 10px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 11px; padding: 13px 15px; font-weight: 600; font-size: 15px;` · minmax `minmax(min(100%, 150px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-list-plain, .tfp-list-marked { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: 0px 10px; column-gap: 10px; row-gap: 0px; padding: 0px } · .tfp-static-block > .tfp-prose, .tfp-static-block > .tfp-static-note, .tfp-static-block > h2, .tfp-static-block > h3, .tfp-static-block > .tfp-list-plain, .tfp-static-block `
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 599px) ; (max-width: 899px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 4 → 1 ⚠️ | 707 → 562 | 169 → 562 | 10px → 0px 10px |

### `.tfp-chip-list`

- **intitulé de bande** : Cette prestation près de chez vous
- **gabarits** : prestation — 5 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `margin-top: 14px; display: flex; flex-wrap: wrap; gap: 8px;`
- **base de colonne maquette** : `background: rgb(244, 247, 248); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 8px 15px; font-size: 14px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-chip-list { display: flex; gap: 8px; column-gap: 8px; row-gap: 8px; flex-wrap: wrap; padding: 0px }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 7 ⚠️ | 338 → 707 | 61 → 61 | 8px → 8px |

### `.tfp-card-grid.tfp-card-grid--1.tfp-card-grid--dark`

- **intitulé de bande** : —
- **gabarits** : hub-zones, pilier, region — 3 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `background: rgb(221, 244, 243); border: 1px solid rgb(184, 228, 228); border-radius: 16px; padding: 14px 16px; display: flex; flex-wrap: wrap; align-items: center; gap: 14px clamp(16px, 2.4vw, 26px);`
- **base de colonne maquette** : `display: flex; align-items: center; gap: 12px; background: rgb(23, 74, 129); color: rgb(255, 255, 255); border-radius: 12px; padding: 10px 16px;` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-card-grid { display: grid; gap: var(--tfp-tuile-gap, 12px); padding: 0px } · @media (max-width: 599px) { .tfp-card-grid:not([style*="--tfp-grille-colonne"]) { grid-template-columns: minmax(0px, 1fr) } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 599px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 675 → 707 | 136 → 707 | 14px 18.432px → 14px 26px |

### `.tfp-flex`

- **intitulé de bande** : —
- **gabarits** : article — 3 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 10px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 9px 16px; font-size: 14px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 2 ⚠️ | 707 → 707 | 95 → 93 | 10px → 16px |

### `.tfp-container.tfp-two-col`

- **intitulé de bande** : Audrey, votre interlocutrice
- **gabarits** : accueil, prestation — 2 routes
- **fichiers** : CSS src/css/03-layout.css · PHP 404.php, includes/components.php, index.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-conseils.php, page-contact.php, page-demande-de-devis.php, page-gestion-des-cookies.php, page-mentions-legales.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-plan-du-site.php, page-politique-de-confidentialite.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-tarifs.php, page-zones-intervention.php, page.php, single-prestation.php, single-zone.php, single.php, template-parts/components/static-blocks.php, template-parts/home/advice.php, template-parts/home/audiences.php, template-parts/home/audrey-reviews.php, template-parts/home/coverage.php, template-parts/home/pricing-reassurance.php, template-parts/home/pricing.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php, template-parts/home/why.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(32px, 4vw, 60px); align-items: center;`
- **base de colonne maquette** : `flex: 1 1 320px; min-width: min(100%, 300px); max-width: 420px; position: relative;` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-container { max-width: var(--container-max) } · .tfp-two-col { display: flex; gap: clamp(30px, 4vw, 56px); column-gap: clamp(30px, 4vw, 56px); row-gap: clamp(30px, 4vw, 56px); flex-wrap: wrap }`
- **base de colonne WordPress** : `320px` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 1 → 1 | 707 → 707 | 420 → 420 | 32px → 30.72px |

### `.tfp-flex`

- **intitulé de bande** : Nos villes d'intervention dans le département
- **gabarits** : departement — 1 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP 404.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-zones-intervention.php, single-prestation.php, single-zone.php, single.php, template-parts/home/advice.php, template-parts/home/audrey-reviews.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `margin-top: 18px; display: flex; flex-wrap: wrap; gap: 14px;`
- **base de colonne maquette** : `font-weight: 600; color: rgb(23, 74, 129);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-flex { display: flex; gap: var(--space-4); flex-wrap: wrap }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 5 ⚠️ | 338 → 707 | 89 → 60 | 14px → 16px |

### `.tfp-chip-list`

- **intitulé de bande** : J’ai une question
- **gabarits** : contact — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 15px;`
- **base de colonne maquette** : `display: flex; flex-direction: column; gap: 6px; font-size: 14px; font-weight: 600; color: rgb(52, 72, 90);` · minmax `minmax(min(100%, 220px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-chip-list { display: flex; gap: 8px; column-gap: 8px; row-gap: 8px; flex-wrap: wrap; padding: 0px }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 3 ⚠️ | 707 → 707 | 346 → 115 | 15px → 8px |

### `.tfp-container.tfp-grid.tfp-grid--autofit-md`

- **intitulé de bande** : Pages principales
- **gabarits** : plan-du-site — 1 routes
- **fichiers** : CSS src/css/03-layout.css · PHP 404.php, includes/components.php, index.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-conseils.php, page-contact.php, page-demande-de-devis.php, page-gestion-des-cookies.php, page-mentions-legales.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-plan-du-site.php, page-politique-de-confidentialite.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-tarifs.php, page-zones-intervention.php, page.php, single-prestation.php, single-zone.php, single.php, template-parts/components/static-blocks.php, template-parts/home/advice.php, template-parts/home/audiences.php, template-parts/home/audrey-reviews.php, template-parts/home/coverage.php, template-parts/home/pricing-reassurance.php, template-parts/home/pricing.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php, template-parts/home/why.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 9px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 10px 18px; font-size: 14.5px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-container { max-width: var(--container-max) } · .tfp-grid { display: grid; gap: var(--space-4) } · .tfp-grid--autofit-md { grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)) }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 4 → 3 ⚠️ | 707 → 707 | 91 → 225 | 9px → 16px |

### `.tfp-static-grid.tfp-static-grid--3`

- **intitulé de bande** : Le tarif, en toute transparence
- **gabarits** : pilier — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP template-parts/components/static-blocks.php
- **règle déclarée par la maquette** : `max-width: 1260px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: clamp(32px, 5vw, 56px);`
- **base de colonne maquette** : `flex: 1 1 300px; min-width: min(100%, 300px);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-static-grid { display: grid; gap: 24px 40px; column-gap: 40px; row-gap: 24px } · .tfp-static-grid--3 { grid-template-columns: repeat(3, minmax(0px, 1fr)) } · .tfp-static-grid[style*="--tfp-rangee-colonne"] { grid-template-columns: repeat(auto-fit,minmax(min(100%,var(--tfp-rangee-colonne)),1fr)) } · .tfp-static-grid[style*="--tfp-rangee-gap"] { gap: var(`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 334 → 325 | 38.4px → 56px |

### `.tfp-chip-list`

- **intitulé de bande** : Cette prestation près de chez vous
- **gabarits** : prestation — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `margin-top: 14px; display: flex; flex-wrap: wrap; gap: 8px;`
- **base de colonne maquette** : `background: rgb(244, 247, 248); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 8px 15px; font-size: 14px; font-weight: 600; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-chip-list { display: flex; gap: 8px; column-gap: 8px; row-gap: 8px; flex-wrap: wrap; padding: 0px }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 7 ⚠️ | 338 → 707 | 61 → 61 | 8px → 8px |

### `.tfp-price-headline`

- **intitulé de bande** : —
- **gabarits** : tarifs — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP page-tarifs.php
- **règle déclarée par la maquette** : `max-width: 1100px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: flex; flex-wrap: wrap; gap: 16px;`
- **base de colonne maquette** : `flex: 2 1 380px; min-width: min(100%, 320px); background: rgb(23, 74, 129); color: rgb(255, 255, 255); border-radius: 20px; padding: clamp(28px, 4vw, 44px); display: flex; flex-wrap: wrap; gap: 24px; align-items: center;` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-price-headline { display: grid; grid-template-columns: 1fr; gap: 24px; column-gap: 24px; row-gap: 24px; padding: 28px 30px } · @media (min-width: 820px) { .tfp-price-headline { grid-template-columns: minmax(0px, 1fr) minmax(0px, 1fr) } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (min-width: 820px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 647 | 250 → 645 | 16px → 24px |

### `.tfp-container.tfp-two-col`

- **intitulé de bande** : Ce qui est inclus
- **gabarits** : tarifs — 1 routes
- **fichiers** : CSS src/css/03-layout.css · PHP 404.php, includes/components.php, index.php, page-a-propos.php, page-avis-clients.php, page-bourgogne-franche-comte.php, page-conseils.php, page-contact.php, page-demande-de-devis.php, page-gestion-des-cookies.php, page-mentions-legales.php, page-nettoyage-professionnel.php, page-notre-fonctionnement.php, page-plan-du-site.php, page-politique-de-confidentialite.php, page-pourquoi-nous.php, page-prestations.php, page-recrutement.php, page-tarifs.php, page-zones-intervention.php, page.php, single-prestation.php, single-zone.php, single.php, template-parts/components/static-blocks.php, template-parts/home/advice.php, template-parts/home/audiences.php, template-parts/home/audrey-reviews.php, template-parts/home/coverage.php, template-parts/home/pricing-reassurance.php, template-parts/home/pricing.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php, template-parts/home/why.php
- **règle déclarée par la maquette** : `max-width: 900px; margin: 0px auto; padding: 0px clamp(18px, 4vw, 40px); display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr)); gap: 16px;`
- **base de colonne maquette** : `background: rgb(221, 244, 243); border: 1px solid rgb(184, 228, 228); border-radius: 16px; padding: 24px;` · minmax `minmax(min(100%, 260px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-container { max-width: var(--container-max) } · .tfp-two-col { display: flex; gap: clamp(30px, 4vw, 56px); column-gap: clamp(30px, 4vw, 56px); row-gap: clamp(30px, 4vw, 56px); flex-wrap: wrap }`
- **base de colonne WordPress** : `380px` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 345 → 707 | 16px → 30.72px |

### `.tfp-grid.tfp-grid--autofit-md`

- **intitulé de bande** : Avant de demander votre devis
- **gabarits** : tarifs — 1 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP page-conseils.php, page-plan-du-site.php, page-tarifs.php, single-prestation.php, template-parts/home/advice.php, template-parts/home/coverage.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr)); gap: 12px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 14px; padding: 18px 20px; color: rgb(24, 35, 45);` · minmax `minmax(min(100%, 230px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-grid { display: grid; gap: var(--space-4) } · .tfp-grid--autofit-md { grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)) }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 3 ⚠️ | 707 → 707 | 347 → 225 | 12px → 16px |

### `.tfp-card-grid.tfp-card-grid--2`

- **intitulé de bande** : Votre commune est-elle couverte ?
- **gabarits** : hub-zones — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `margin-top: 24px; display: flex; flex-wrap: wrap; gap: 12px; justify-content: center;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); color: rgb(23, 74, 129); font-weight: 700; padding: 15px 26px; border-radius: 12px;` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-card-grid { display: grid; gap: var(--tfp-tuile-gap, 12px); padding: 0px } · .tfp-card-grid--2 { grid-template-columns: repeat(2, minmax(0px, 1fr)) } · @media (max-width: 599px) { .tfp-card-grid:not([style*="--tfp-grille-colonne"]) { grid-template-columns: minmax(0px, 1fr) } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 599px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 1 → 2 ⚠️ | 707 → 707 | 374 → 347 | 12px → 12px |

### `.tfp-grid.tfp-grid--autofit-md`

- **intitulé de bande** : Passer du conseil à votre situation
- **gabarits** : index-conseils — 1 routes
- **fichiers** : CSS src/css/03-layout.css, src/css/04-components.css · PHP page-conseils.php, page-plan-du-site.php, page-tarifs.php, single-prestation.php, template-parts/home/advice.php, template-parts/home/coverage.php, template-parts/home/problems.php, template-parts/home/process.php, template-parts/home/services.php
- **règle déclarée par la maquette** : `margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr)); gap: 12px;`
- **base de colonne maquette** : `background: rgb(255, 255, 255); border: 1px solid rgb(220, 231, 235); border-radius: 14px; padding: 18px 20px; color: rgb(24, 35, 45);` · minmax `minmax(min(100%, 230px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-grid { display: grid; gap: var(--space-4) } · .tfp-grid--autofit-md { grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)) }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : —
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 3 ⚠️ | 707 → 707 | 347 → 225 | 12px → 16px |

### `.tfp-card-grid.tfp-card-grid--1`

- **intitulé de bande** : J’ai une question
- **gabarits** : contact — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP includes/components.php
- **règle déclarée par la maquette** : `display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 15px;`
- **base de colonne maquette** : `display: flex; flex-direction: column; gap: 6px; font-size: 14px; font-weight: 600; color: rgb(52, 72, 90);` · minmax `minmax(min(100%, 220px)`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-card-grid { display: grid; gap: var(--tfp-tuile-gap, 12px); padding: 0px } · @media (max-width: 599px) { .tfp-card-grid:not([style*="--tfp-grille-colonne"]) { grid-template-columns: minmax(0px, 1fr) } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 599px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 2 → 1 ⚠️ | 707 → 707 | 346 → 707 | 15px → 12px |

### `.tfp-contact-form__row`

- **intitulé de bande** : J’ai une question
- **gabarits** : contact — 1 routes
- **fichiers** : CSS src/css/04-components.css · PHP page-contact.php
- **règle déclarée par la maquette** : `display: flex; flex-wrap: wrap; gap: 10px;`
- **base de colonne maquette** : `background: rgb(244, 247, 248); border: 1px solid rgb(220, 231, 235); border-radius: 100px; padding: 9px 16px; font-weight: 600; font-size: 14px; color: rgb(44, 59, 72);` · minmax `—`
- **règle WordPress** : `*, ::before, ::after { padding: 0px } · .tfp-contact-form__row { display: grid; grid-template-columns: repeat(2, minmax(0px, 1fr)); gap: 0px 16px; column-gap: 16px; row-gap: 0px } · @media (max-width: 599px) { .tfp-contact-form__row { grid-template-columns: minmax(0px, 1fr) } }`
- **base de colonne WordPress** : `auto` · minmax `—`
- **auto-fit** : non · **auto-fill** : non · **seuils fixes** : (max-width: 599px)
- **span des enfants** : —

| largeur | colonnes réf → wp | largeur utile | largeur carte | gap |
| ------: | ----------------- | ------------- | ------------- | --- |
| 768 | 3 → 2 ⚠️ | 707 → 707 | 118 → 345 | 10px → 0px 16px |

