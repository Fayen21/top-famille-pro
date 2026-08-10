# Vérification visuelle des 53 routes — styles calculés

> Fichier **généré** par `node tools/compare-styles.mjs`. Ne pas éditer à la main.
>
> Une hauteur identique ne prouve pas une page identique. Ce relevé compare, des deux côtés
> et sur le rendu réel, ce qui décide de l’aspect : polices résolues, couleurs, tailles et
> interlignes, largeur et marge du conteneur, nombre de bandes, rayon / filet / fond des
> cartes, taille et rayon du bouton principal, nombre de colonnes des grilles, cadrage des
> images, fond du pied de page.

**53 routes × 2 largeurs · 695 écart(s) relevé(s).**

## Synthèse

| Route | 1440 px | 375 px |
|---|---|---|
| `#/` | ⚠️ 3 | ⚠️ 5 |
| `#/nettoyage-professionnel` | ⚠️ 8 | ⚠️ 10 |
| `#/nos-prestations` | ⚠️ 7 | ⚠️ 9 |
| `#/service/bureaux` | ⚠️ 6 | ⚠️ 5 |
| `#/service/commerces` | ⚠️ 6 | ⚠️ 5 |
| `#/service/cabinets` | ⚠️ 6 | ⚠️ 5 |
| `#/service/coproprietes` | ⚠️ 6 | ⚠️ 5 |
| `#/service/meubles` | ⚠️ 6 | ⚠️ 5 |
| `#/service/ponctuel` | ⚠️ 6 | ⚠️ 5 |
| `#/nos-tarifs` | ⚠️ 6 | ⚠️ 6 |
| `#/zones-intervention` | ⚠️ 8 | ⚠️ 9 |
| `#/bourgogne-franche-comte` | ⚠️ 7 | ⚠️ 9 |
| `#/departement/cote-dor` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/doubs` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/jura` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/nievre` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/haute-saone` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/saone-et-loire` | ⚠️ 8 | ⚠️ 9 |
| `#/departement/yonne` | ⚠️ 8 | ⚠️ 8 |
| `#/departement/territoire-de-belfort` | ⚠️ 8 | ⚠️ 9 |
| `#/ville/dijon` | ⚠️ 6 | ⚠️ 8 |
| `#/ville/besancon` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/dole` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/lons-le-saunier` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/nevers` | ⚠️ 6 | ⚠️ 8 |
| `#/ville/vesoul` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/chalon-sur-saone` | ⚠️ 5 | ⚠️ 11 |
| `#/ville/macon` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/auxerre` | ⚠️ 5 | ⚠️ 7 |
| `#/ville/belfort` | ⚠️ 6 | ⚠️ 8 |
| `#/ville/saint-apollinaire` | ⚠️ 6 | ⚠️ 10 |
| `#/ville/chenove` | ⚠️ 6 | ⚠️ 7 |
| `#/ville/quetigny` | ⚠️ 6 | ⚠️ 7 |
| `#/ville/talant` | ⚠️ 6 | ⚠️ 8 |
| `#/ville/longvic` | ⚠️ 6 | ⚠️ 7 |
| `#/ville/fontaine-les-dijon` | ⚠️ 6 | ⚠️ 10 |
| `#/ville/marsannay-la-cote` | ⚠️ 6 | ⚠️ 10 |
| `#/ville/beaune` | ⚠️ 5 | ⚠️ 7 |
| `#/conseils` | ⚠️ 1 | ⚠️ 3 |
| `#/article/frequence-bureaux` | ⚠️ 7 | ⚠️ 5 |
| `#/article/cout-nettoyage-bureaux` | ⚠️ 7 | ⚠️ 5 |
| `#/article/cahier-des-charges-nettoyage` | ⚠️ 7 | ⚠️ 5 |
| `#/pourquoi-top-famille-pro` | ⚠️ 8 | ⚠️ 8 |
| `#/notre-fonctionnement` | ⚠️ 6 | ⚠️ 7 |
| `#/avis-clients` | ⚠️ 5 | ⚠️ 6 |
| `#/a-propos` | ⚠️ 3 | ⚠️ 6 |
| `#/recrutement` | ⚠️ 10 | ⚠️ 12 |
| `#/demande-de-devis` | ⚠️ 4 | ⚠️ 7 |
| `#/contact` | ⚠️ 9 | ⚠️ 10 |
| `#/plan-du-site` | ⚠️ 2 | ⚠️ 1 |
| `#/mentions-legales` | ⚠️ 4 | ⚠️ 6 |
| `#/politique-de-confidentialite` | ⚠️ 3 | ⚠️ 5 |
| `#/gestion-des-cookies` | ⚠️ 3 | ⚠️ 4 |

## Écarts par nature

### Rayons de cartes employés — 100 cas

- `#/ @375px — maquette 14px×5 16px×4 20px×2 18px×1 · WordPress 16px×9 20px×2 12px×1 18px×1`
- `#/ @1440px — maquette 16px×5 14px×5 20px×2 18px×1 · WordPress 16px×10 20px×2 12px×1 18px×1`
- `#/nettoyage-professionnel @375px — maquette 14px×13 16px×10 12px×10 11px×6 · WordPress 16px×17 14px×16`
- `#/nettoyage-professionnel @1440px — maquette 14px×13 16px×10 12px×10 11px×6 · WordPress 14px×16 16px×8`
- `#/nos-prestations @375px — maquette 14px×6 · WordPress 16px×2`
- `#/nos-prestations @1440px — maquette 14px×6 · WordPress `
- `#/service/bureaux @375px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×15 12px×2 18px×1`
- `#/service/bureaux @1440px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×7 12px×2 18px×1`
- `#/service/commerces @375px — maquette 12px×8 14px×5 16px×3 18px×1 · WordPress 16px×14 12px×2 18px×1`
- `#/service/commerces @1440px — maquette 12px×8 14px×5 16px×3 18px×1 · WordPress 16px×7 12px×2 18px×1`
- `#/service/cabinets @375px — maquette 12px×14 14px×5 16px×3 18px×2 · WordPress 16px×13 12px×7 18px×1`
- `#/service/cabinets @1440px — maquette 12px×15 14px×5 16px×3 18px×2 · WordPress 16px×7 12px×2 18px×1`
- `#/service/coproprietes @375px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×15 12px×2 18px×1`
- `#/service/coproprietes @1440px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×7 12px×2 18px×1`
- `#/service/meubles @375px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×15 12px×2 18px×1`
- `#/service/meubles @1440px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×7 12px×2 18px×1`
- `#/service/ponctuel @375px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×14 12px×2 18px×1`
- `#/service/ponctuel @1440px — maquette 12px×9 14px×5 16px×3 18px×1 · WordPress 16px×7 12px×2 18px×1`
- `#/nos-tarifs @375px — maquette 12px×9 16px×3 18px×3 20px×2 · WordPress 16px×14 18px×1`
- `#/nos-tarifs @1440px — maquette 12px×9 16px×3 18px×3 20px×2 · WordPress 16px×10 18px×1`
- … et 80 autres

### Fonds de cartes employés — 100 cas

- `#/ @375px — maquette rgb(244, 247, 248)×5 rgb(255, 255, 255)×3 rgb(220, 231, 235)×2 rgb(221, 244, 243)×1 · WordPress rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 rgb(220, 231, 235)×2 rgb(221, 244, 243)×1`
- `#/ @1440px — maquette rgb(244, 247, 248)×5 rgb(255, 255, 255)×3 rgb(220, 231, 235)×2 rgba(0, 0, 0, 0)×1 · WordPress rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 rgb(220, 231, 235)×2 rgba(0, 0, 0, 0)×1`
- `#/nettoyage-professionnel @375px — maquette rgb(255, 255, 255)×23 rgba(0, 0, 0, 0)×7 rgb(244, 247, 248)×6 rgb(221, 244, 243)×4 · WordPress rgb(255, 255, 255)×33`
- `#/nettoyage-professionnel @1440px — maquette rgb(255, 255, 255)×23 rgba(0, 0, 0, 0)×7 rgb(244, 247, 248)×6 rgb(221, 244, 243)×4 · WordPress rgb(255, 255, 255)×24`
- `#/nos-prestations @375px — maquette rgb(244, 247, 248)×6 · WordPress rgb(255, 255, 255)×2`
- `#/nos-prestations @1440px — maquette rgb(244, 247, 248)×6 · WordPress `
- `#/service/bureaux @375px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/bureaux @1440px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/commerces @375px — maquette rgb(255, 255, 255)×12 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/commerces @1440px — maquette rgb(255, 255, 255)×12 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/cabinets @375px — maquette rgb(255, 255, 255)×13 rgb(16, 38, 59)×5 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 · WordPress rgb(255, 255, 255)×17 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/cabinets @1440px — maquette rgb(255, 255, 255)×13 rgb(16, 38, 59)×6 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/coproprietes @375px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/coproprietes @1440px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/meubles @375px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/meubles @1440px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/ponctuel @375px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/service/ponctuel @1440px — maquette rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1`
- `#/nos-tarifs @375px — maquette rgb(255, 255, 255)×11 rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×10 rgb(244, 247, 248)×4 rgb(221, 244, 243)×1`
- `#/nos-tarifs @1440px — maquette rgb(255, 255, 255)×11 rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 · WordPress rgb(255, 255, 255)×6 rgb(244, 247, 248)×4 rgb(221, 244, 243)×1`
- … et 80 autres

### Filets de cartes employés — 96 cas

- `#/ @375px — maquette 1px×11 0px×1 · WordPress 1px×12 0px×1`
- `#/ @1440px — maquette 1px×11 5px×1 0px×1 · WordPress 1px×12 5px×1 0px×1`
- `#/nettoyage-professionnel @375px — maquette 1px×40 · WordPress 1px×33`
- `#/nettoyage-professionnel @1440px — maquette 1px×40 · WordPress 1px×24`
- `#/nos-prestations @375px — maquette 1px×6 · WordPress 1px×2`
- `#/nos-prestations @1440px — maquette 1px×6 · WordPress `
- `#/service/bureaux @375px — maquette 1px×17 0px×1 · WordPress 1px×18`
- `#/service/bureaux @1440px — maquette 1px×17 0px×1 · WordPress 1px×10`
- `#/service/commerces @375px — maquette 1px×16 0px×1 · WordPress 1px×17`
- `#/service/commerces @1440px — maquette 1px×16 0px×1 · WordPress 1px×10`
- `#/service/cabinets @375px — maquette 1px×22 0px×2 · WordPress 1px×21`
- `#/service/cabinets @1440px — maquette 1px×23 0px×2 · WordPress 1px×10`
- `#/service/coproprietes @375px — maquette 1px×17 0px×1 · WordPress 1px×18`
- `#/service/coproprietes @1440px — maquette 1px×17 0px×1 · WordPress 1px×10`
- `#/service/meubles @375px — maquette 1px×17 0px×1 · WordPress 1px×18`
- `#/service/meubles @1440px — maquette 1px×17 0px×1 · WordPress 1px×10`
- `#/service/ponctuel @375px — maquette 1px×17 0px×1 · WordPress 1px×17`
- `#/service/ponctuel @1440px — maquette 1px×17 0px×1 · WordPress 1px×10`
- `#/nos-tarifs @375px — maquette 1px×16 0px×1 · WordPress 1px×15`
- `#/nos-tarifs @1440px — maquette 1px×16 0px×1 · WordPress 1px×11`
- … et 76 autres

### Couleur des liens — 62 cas

- `#/nettoyage-professionnel @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/nettoyage-professionnel @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/cote-dor @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/cote-dor @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/doubs @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/doubs @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/jura @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/jura @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/nievre @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/nievre @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/haute-saone @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/haute-saone @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/saone-et-loire @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/saone-et-loire @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/yonne @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/yonne @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/territoire-de-belfort @375px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/departement/territoire-de-belfort @1440px — absent d'un côté (maquette rgb(23, 74, 129) · WordPress null)`
- `#/ville/dijon @375px — absent d'un côté (maquette rgb(147, 218, 219) · WordPress null)`
- `#/ville/dijon @1440px — absent d'un côté (maquette rgb(147, 218, 219) · WordPress null)`
- … et 42 autres

### Taille du texte — 55 cas

- `#/ @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/nettoyage-professionnel @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/nos-prestations @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/bureaux @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/commerces @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/cabinets @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/coproprietes @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/meubles @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/service/ponctuel @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/nos-tarifs @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/zones-intervention @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/bourgogne-franche-comte @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/cote-dor @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/doubs @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/jura @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/nievre @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/haute-saone @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/saone-et-loire @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/yonne @375px — maquette 17 · WordPress 20 (écart 3)`
- `#/departement/territoire-de-belfort @375px — maquette 17 · WordPress 20 (écart 3)`
- … et 35 autres

### Nombre de cartes — 53 cas

- `#/nettoyage-professionnel @375px — maquette 40 · WordPress 33 (écart 7)`
- `#/nettoyage-professionnel @1440px — maquette 40 · WordPress 24 (écart 16)`
- `#/nos-prestations @375px — maquette 6 · WordPress 2 (écart 4)`
- `#/nos-prestations @1440px — maquette 6 · WordPress 0 (écart 6)`
- `#/service/bureaux @1440px — maquette 18 · WordPress 10 (écart 8)`
- `#/service/commerces @1440px — maquette 17 · WordPress 10 (écart 7)`
- `#/service/cabinets @1440px — maquette 25 · WordPress 10 (écart 15)`
- `#/service/coproprietes @1440px — maquette 18 · WordPress 10 (écart 8)`
- `#/service/meubles @1440px — maquette 18 · WordPress 10 (écart 8)`
- `#/service/ponctuel @1440px — maquette 18 · WordPress 10 (écart 8)`
- `#/nos-tarifs @1440px — maquette 17 · WordPress 11 (écart 6)`
- `#/zones-intervention @375px — maquette 18 · WordPress 10 (écart 8)`
- `#/zones-intervention @1440px — maquette 18 · WordPress 6 (écart 12)`
- `#/bourgogne-franche-comte @375px — maquette 27 · WordPress 15 (écart 12)`
- `#/bourgogne-franche-comte @1440px — maquette 31 · WordPress 9 (écart 22)`
- `#/departement/cote-dor @1440px — maquette 23 · WordPress 16 (écart 7)`
- `#/departement/doubs @1440px — maquette 22 · WordPress 15 (écart 7)`
- `#/departement/jura @1440px — maquette 23 · WordPress 16 (écart 7)`
- `#/departement/nievre @1440px — maquette 23 · WordPress 16 (écart 7)`
- `#/departement/haute-saone @1440px — maquette 23 · WordPress 13 (écart 10)`
- … et 33 autres

### Interligne du texte — 52 cas

- `#/ @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/nettoyage-professionnel @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/nos-prestations @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/bureaux @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/commerces @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/cabinets @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/coproprietes @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/meubles @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/service/ponctuel @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/nos-tarifs @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/zones-intervention @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/bourgogne-franche-comte @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/cote-dor @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/doubs @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/jura @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/nievre @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/haute-saone @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/saone-et-loire @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/yonne @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/departement/territoire-de-belfort @375px — maquette 28 · WordPress 32 (écart 4)`
- … et 32 autres

### Colonnes des grilles — 38 cas

- `#/nettoyage-professionnel @1440px — maquette 3 col × 6 / 3 col × 3 / 4 col × 6 / 3 col × 3 / 3 col × 3 / 4 col × 4 · WordPress 5 col × 5 / 2 col × 6 / 4 col × 12 / 3 col × 3 / 3 col × 3 / 5 col × 5`
- `#/nos-prestations @1440px — maquette 4 col × 6 / 3 col × 6 · WordPress `
- `#/service/bureaux @1440px — maquette 3 col × 3 / 6 col × 8 · WordPress 3 col × 3 / 5 col × 10`
- `#/service/commerces @1440px — maquette 3 col × 3 / 6 col × 8 · WordPress 3 col × 3 / 5 col × 10`
- `#/service/cabinets @1440px — maquette 4 col × 6 / 3 col × 3 / 6 col × 8 · WordPress 2 col × 6 / 3 col × 3 / 5 col × 10`
- `#/service/coproprietes @1440px — maquette 3 col × 3 / 6 col × 8 · WordPress 3 col × 3 / 5 col × 10`
- `#/service/meubles @1440px — maquette 3 col × 3 / 6 col × 8 · WordPress 3 col × 3 / 5 col × 10`
- `#/service/ponctuel @1440px — maquette 3 col × 3 / 6 col × 8 · WordPress 3 col × 3 / 5 col × 10`
- `#/nos-tarifs @1440px — maquette 3 col × 4 / 3 col × 3 / 4 col × 4 · WordPress 4 col × 4 / 3 col × 3 / 4 col × 4`
- `#/zones-intervention @1440px — maquette 3 col × 5 / 4 col × 8 / 6 col × 10 / 6 col × 8 / 3 col × 3 · WordPress 5 col × 5`
- `#/bourgogne-franche-comte @1440px — maquette 3 col × 6 / 3 col × 6 / 4 col × 6 / 4 col × 8 / 6 col × 10 / 8 col × 8 · WordPress 5 col × 5 / 10 col × 40 / 6 col × 8`
- `#/departement/cote-dor @1440px — maquette 3 col × 6 / 5 col × 8 / 4 col × 7 / 3 col × 3 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/doubs @1440px — maquette 3 col × 6 / 5 col × 7 / 3 col × 3 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/jura @1440px — maquette 3 col × 6 / 5 col × 8 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/nievre @1440px — maquette 3 col × 6 / 4 col × 6 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/haute-saone @1440px — maquette 3 col × 6 / 4 col × 6 / 3 col × 3 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/saone-et-loire @1440px — maquette 3 col × 6 / 4 col × 7 / 3 col × 3 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/yonne @1440px — maquette 3 col × 6 / 4 col × 6 · WordPress 3 col × 6 / 7 col × 7`
- `#/departement/territoire-de-belfort @1440px — maquette 3 col × 6 / 6 col × 6 · WordPress 3 col × 6 / 7 col × 7`
- `#/ville/dijon @1440px — maquette 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 13 · WordPress 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 8 / 4 col × 6`
- … et 18 autres

### Largeur du conteneur — 24 cas

- `#/nettoyage-professionnel @375px — maquette 339 · WordPress 375 (écart 36)`
- `#/nettoyage-professionnel @1440px — maquette 612 · WordPress 1260 (écart 648)`
- `#/bourgogne-franche-comte @375px — maquette 339 · WordPress 375 (écart 36)`
- `#/bourgogne-franche-comte @1440px — maquette 612 · WordPress 1260 (écart 648)`
- `#/departement/cote-dor @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/cote-dor @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/doubs @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/doubs @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/jura @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/jura @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/nievre @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/nievre @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/haute-saone @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/haute-saone @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/saone-et-loire @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/saone-et-loire @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/yonne @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/yonne @1440px — maquette 900 · WordPress 820 (écart 80)`
- `#/departement/territoire-de-belfort @375px — maquette 375 · WordPress 339 (écart 36)`
- `#/departement/territoire-de-belfort @1440px — maquette 900 · WordPress 820 (écart 80)`
- … et 4 autres

### Marge gauche du conteneur — 24 cas

- `#/nettoyage-professionnel @375px — maquette 18 · WordPress 0 (écart 18)`
- `#/nettoyage-professionnel @1440px — maquette 130 · WordPress 90 (écart 40)`
- `#/bourgogne-franche-comte @375px — maquette 18 · WordPress 0 (écart 18)`
- `#/bourgogne-franche-comte @1440px — maquette 130 · WordPress 90 (écart 40)`
- `#/departement/cote-dor @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/cote-dor @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/doubs @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/doubs @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/jura @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/jura @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/nievre @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/nievre @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/haute-saone @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/haute-saone @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/saone-et-loire @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/saone-et-loire @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/yonne @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/yonne @1440px — maquette 270 · WordPress 130 (écart 140)`
- `#/departement/territoire-de-belfort @375px — maquette 0 · WordPress 18 (écart 18)`
- `#/departement/territoire-de-belfort @1440px — maquette 270 · WordPress 130 (écart 140)`
- … et 4 autres

### Fond du bouton — 20 cas

- `#/nos-prestations @375px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/nos-prestations @1440px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/nos-tarifs @375px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/nos-tarifs @1440px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/zones-intervention @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/zones-intervention @1440px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/ville/chalon-sur-saone @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/ville/saint-apollinaire @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/ville/fontaine-les-dijon @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/ville/marsannay-la-cote @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/pourquoi-top-famille-pro @375px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/pourquoi-top-famille-pro @1440px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/notre-fonctionnement @375px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/notre-fonctionnement @1440px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/a-propos @375px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/a-propos @1440px — maquette rgb(255, 255, 255) · WordPress rgb(23, 74, 129)`
- `#/recrutement @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/recrutement @1440px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/contact @375px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`
- `#/contact @1440px — absent d'un côté (maquette null · WordPress rgb(23, 74, 129))`

### Taille du premier H2 — 18 cas

- `#/nos-prestations @375px — maquette 19 · WordPress 24 (écart 5)`
- `#/nos-prestations @1440px — maquette 19 · WordPress 34 (écart 15)`
- `#/service/bureaux @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/service/commerces @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/service/cabinets @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/service/coproprietes @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/service/meubles @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/service/ponctuel @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/conseils @375px — maquette 19 · WordPress 24 (écart 5)`
- `#/conseils @1440px — maquette 19 · WordPress 34 (écart 15)`
- `#/pourquoi-top-famille-pro @1440px — maquette 22 · WordPress 34 (écart 12)`
- `#/demande-de-devis @375px — maquette 20 · WordPress 24 (écart 4)`
- `#/demande-de-devis @1440px — maquette 25 · WordPress 34 (écart 9)`
- `#/contact @375px — absent d'un côté (maquette null · WordPress 19)`
- `#/contact @1440px — absent d'un côté (maquette null · WordPress 19)`
- `#/plan-du-site @375px — maquette 14 · WordPress 22 (écart 8)`
- `#/plan-du-site @1440px — maquette 14 · WordPress 29 (écart 15)`
- `#/gestion-des-cookies @1440px — maquette 29 · WordPress 19 (écart 10)`

### Taille du H1 — 18 cas

- `#/ville/dijon @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/besancon @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/dole @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/lons-le-saunier @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/nevers @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/vesoul @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/chalon-sur-saone @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/macon @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/auxerre @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/belfort @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/saint-apollinaire @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/chenove @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/quetigny @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/talant @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/longvic @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/fontaine-les-dijon @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/marsannay-la-cote @375px — maquette 28 · WordPress 32 (écart 4)`
- `#/ville/beaune @375px — maquette 28 · WordPress 32 (écart 4)`

### Taille du bouton principal — 12 cas

- `#/zones-intervention @375px — absent d'un côté (maquette null · WordPress 216×60)`
- `#/zones-intervention @1440px — absent d'un côté (maquette null · WordPress 216×60)`
- `#/departement/saone-et-loire @375px — maquette 335×58 · WordPress 339×73`
- `#/ville/chalon-sur-saone @375px — absent d'un côté (maquette null · WordPress 339×73)`
- `#/ville/saint-apollinaire @375px — absent d'un côté (maquette null · WordPress 339×73)`
- `#/ville/fontaine-les-dijon @375px — absent d'un côté (maquette null · WordPress 339×73)`
- `#/ville/marsannay-la-cote @375px — absent d'un côté (maquette null · WordPress 339×73)`
- `#/recrutement @375px — absent d'un côté (maquette null · WordPress 216×60)`
- `#/recrutement @1440px — absent d'un côté (maquette null · WordPress 216×60)`
- `#/demande-de-devis @375px — maquette 192×53 · WordPress 216×60`
- `#/contact @375px — absent d'un côté (maquette null · WordPress 216×60)`
- `#/contact @1440px — absent d'un côté (maquette null · WordPress 216×60)`

### Rayon du bouton — 10 cas

- `#/zones-intervention @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/zones-intervention @1440px — absent d'un côté (maquette null · WordPress 12px)`
- `#/ville/chalon-sur-saone @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/ville/saint-apollinaire @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/ville/fontaine-les-dijon @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/ville/marsannay-la-cote @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/recrutement @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/recrutement @1440px — absent d'un côté (maquette null · WordPress 12px)`
- `#/contact @375px — absent d'un côté (maquette null · WordPress 12px)`
- `#/contact @1440px — absent d'un côté (maquette null · WordPress 12px)`

### Couleur du texte — 6 cas

- `#/article/frequence-bureaux @375px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`
- `#/article/frequence-bureaux @1440px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`
- `#/article/cout-nettoyage-bureaux @375px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`
- `#/article/cout-nettoyage-bureaux @1440px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`
- `#/article/cahier-des-charges-nettoyage @375px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`
- `#/article/cahier-des-charges-nettoyage @1440px — maquette rgb(24, 35, 45) · WordPress rgb(74, 98, 115)`

### Cadrage de l’image — 5 cas

- `#/nettoyage-professionnel @375px — absent d'un côté (maquette cover · WordPress null)`
- `#/nos-prestations @375px — absent d'un côté (maquette cover · WordPress null)`
- `#/bourgogne-franche-comte @375px — absent d'un côté (maquette cover · WordPress null)`
- `#/a-propos @375px — absent d'un côté (maquette cover · WordPress null)`
- `#/recrutement @375px — absent d'un côté (maquette cover · WordPress null)`

### Nombre de bandes — 2 cas

- `#/demande-de-devis @375px — maquette 1 · WordPress 4 (écart 3)`
- `#/demande-de-devis @1440px — maquette 1 · WordPress 2 (écart 1)`

## Relevé complet, route par route

### `#/` → `/`

**1440 px** — ⚠️ 3 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 58 | 58 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 58 | 60 | ✅ |
| Taille du premier H2 | 42 | 42 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 13 | 14 | ✅ |
| Rayons de cartes employés | 16px×5 14px×5 20px×2 18px×1 | 16px×10 20px×2 12px×1 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×5 rgb(255, 255, 255)×3 rgb(220, 231, 235)×2 rgba(0, 0, 0, 0)×1 | rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 rgb(220, 231, 235)×2 rgba(0, 0, 0, 0)×1 | ⚠️ |
| Filets de cartes employés | 1px×11 5px×1 0px×1 | 1px×12 5px×1 0px×1 | ⚠️ |
| Taille du bouton principal | 209×61 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 5 col × 5 / 5 col × 5 / 3 col × 8 / 3 col × 3 | 5 col × 5 / 5 col × 5 / 3 col × 8 / 3 col × 3 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 33 | 36 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 33 | 37 | ✅ |
| Taille du premier H2 | 27 | 27 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 12 | 13 | ✅ |
| Rayons de cartes employés | 14px×5 16px×4 20px×2 18px×1 | 16px×9 20px×2 12px×1 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×5 rgb(255, 255, 255)×3 rgb(220, 231, 235)×2 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 rgb(220, 231, 235)×2 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×11 0px×1 | 1px×12 0px×1 | ⚠️ |
| Taille du bouton principal | 209×59 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/nettoyage-professionnel` → `/nettoyage-professionnel/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 54 | 54 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 54 | 56 | ✅ |
| Taille du premier H2 | 34 | 34 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 1260 | ⚠️ |
| Marge gauche du conteneur | 130 | 90 | ⚠️ |
| Nombre de bandes | 19 | 19 | ✅ |
| Nombre de cartes | 40 | 24 | ⚠️ |
| Rayons de cartes employés | 14px×13 16px×10 12px×10 11px×6 | 14px×16 16px×8 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×23 rgba(0, 0, 0, 0)×7 rgb(244, 247, 248)×6 rgb(221, 244, 243)×4 | rgb(255, 255, 255)×24 | ⚠️ |
| Filets de cartes employés | 1px×40 | 1px×24 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 3 col × 3 / 4 col × 6 / 3 col × 3 / 3 col × 3 / 4 col × 4 | 5 col × 5 / 2 col × 6 / 4 col × 12 / 3 col × 3 / 3 col × 3 / 5 col × 5 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 31 | 34 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 35 | ✅ |
| Taille du premier H2 | 24 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 375 | ⚠️ |
| Marge gauche du conteneur | 18 | 0 | ⚠️ |
| Nombre de bandes | 19 | 19 | ✅ |
| Nombre de cartes | 40 | 33 | ⚠️ |
| Rayons de cartes employés | 14px×13 16px×10 12px×10 11px×6 | 16px×17 14px×16 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×23 rgba(0, 0, 0, 0)×7 rgb(244, 247, 248)×6 rgb(221, 244, 243)×4 | rgb(255, 255, 255)×33 | ⚠️ |
| Filets de cartes employés | 1px×40 | 1px×33 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | — | ⚠️ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/nos-prestations` → `/prestations/`

**1440 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 54 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 54 | 54 | ✅ |
| Taille du premier H2 | 19 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 820 | 820 | ✅ |
| Marge gauche du conteneur | 310 | 310 | ✅ |
| Nombre de bandes | 6 | 6 | ✅ |
| Nombre de cartes | 6 | 0 | ⚠️ |
| Rayons de cartes employés | 14px×6 |  | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×6 |  | ⚠️ |
| Filets de cartes employés | 1px×6 |  | ⚠️ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 4 col × 6 / 3 col × 6 |  | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 32 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 32 | 33 | ✅ |
| Taille du premier H2 | 19 | 24 | ⚠️ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 6 | 6 | ✅ |
| Nombre de cartes | 6 | 2 | ⚠️ |
| Rayons de cartes employés | 14px×6 | 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×6 | rgb(255, 255, 255)×2 | ⚠️ |
| Filets de cartes employés | 1px×6 | 1px×2 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | — | ⚠️ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/bureaux` → `/prestations/bureaux/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 3 / 6 col × 8 | 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 18 | ✅ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×15 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×18 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/commerces` → `/prestations/commerces/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 17 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×8 14px×5 16px×3 18px×1 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×12 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×16 0px×1 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 3 / 6 col × 8 | 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 17 | 17 | ✅ |
| Rayons de cartes employés | 12px×8 14px×5 16px×3 18px×1 | 16px×14 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×12 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×16 0px×1 | 1px×17 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/cabinets` → `/prestations/cabinets/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 15 | 15 | ✅ |
| Nombre de cartes | 25 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×15 14px×5 16px×3 18px×2 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(16, 38, 59)×6 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×23 0px×2 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 4 col × 6 / 3 col × 3 / 6 col × 8 | 2 col × 6 / 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 15 | 15 | ✅ |
| Nombre de cartes | 24 | 21 | ✅ |
| Rayons de cartes employés | 12px×14 14px×5 16px×3 18px×2 | 16px×13 12px×7 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(16, 38, 59)×5 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 | rgb(255, 255, 255)×17 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×22 0px×2 | 1px×21 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/coproprietes` → `/prestations/coproprietes/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 3 / 6 col × 8 | 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 18 | ✅ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×15 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×18 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/meubles` → `/prestations/meubles/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 3 / 6 col × 8 | 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 18 | ✅ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×15 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×18 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/service/ponctuel` → `/prestations/ponctuel/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 49 | 50 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 602 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 10 | ⚠️ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×7 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×10 | ⚠️ |
| Taille du bouton principal | 201×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 3 / 6 col × 8 | 3 col × 3 / 5 col × 10 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 32 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 14 | 14 | ✅ |
| Nombre de cartes | 18 | 17 | ✅ |
| Rayons de cartes employés | 12px×9 14px×5 16px×3 18px×1 | 16px×14 12px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×13 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×17 0px×1 | 1px×17 | ⚠️ |
| Taille du bouton principal | 201×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/nos-tarifs` → `/tarifs/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 54 | 54 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 54 | 56 | ✅ |
| Taille du premier H2 | 36 | 36 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 17 | 11 | ⚠️ |
| Rayons de cartes employés | 12px×9 16px×3 18px×3 20px×2 | 16px×10 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×11 rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 rgb(244, 247, 248)×4 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×16 0px×1 | 1px×11 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 3 col × 4 / 3 col × 3 / 4 col × 4 | 4 col × 4 / 3 col × 3 / 4 col × 4 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 32 | 34 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 32 | 35 | ✅ |
| Taille du premier H2 | 24 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 17 | 15 | ✅ |
| Rayons de cartes employés | 12px×9 16px×3 18px×3 20px×2 | 16px×14 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×11 rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×4 rgb(221, 244, 243)×1 | ⚠️ |
| Filets de cartes employés | 1px×16 0px×1 | 1px×15 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/zones-intervention` → `/zones-intervention/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 18 | 6 | ⚠️ |
| Rayons de cartes employés | 18px×6 12px×6 10px×5 16px×1 | 18px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×12 rgb(244, 247, 248)×5 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×6 | ⚠️ |
| Filets de cartes employés | 1px×18 | 1px×6 | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 3 col × 5 / 4 col × 8 / 6 col × 10 / 6 col × 8 / 3 col × 3 | 5 col × 5 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 18 | 10 | ⚠️ |
| Rayons de cartes employés | 18px×6 12px×6 10px×5 16px×1 | 18px×6 16px×4 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×12 rgb(244, 247, 248)×5 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×10 | ⚠️ |
| Filets de cartes employés | 1px×18 | 1px×10 | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/bourgogne-franche-comte` → `/zones-intervention/bourgogne-franche-comte/`

**1440 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 52 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 1260 | ⚠️ |
| Marge gauche du conteneur | 130 | 90 | ⚠️ |
| Nombre de bandes | 12 | 12 | ✅ |
| Nombre de cartes | 31 | 9 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×9 12px×7 16px×3 | 18px×9 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×9 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×9 | ⚠️ |
| Taille du bouton principal | 210×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 3 col × 6 / 4 col × 6 / 4 col × 8 / 6 col × 10 / 8 col × 8 | 5 col × 5 / 10 col × 40 / 6 col × 8 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 30 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 375 | ⚠️ |
| Marge gauche du conteneur | 18 | 0 | ⚠️ |
| Nombre de bandes | 12 | 12 | ✅ |
| Nombre de cartes | 27 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×9 10px×8 12px×7 16px×3 | 18px×9 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×8 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×15 | ⚠️ |
| Filets de cartes employés | 1px×27 | 1px×15 | ⚠️ |
| Taille du bouton principal | 210×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | — | ⚠️ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/cote-dor` → `/zones-intervention/cote-dor/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 23 | 16 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×8 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×16 | ⚠️ |
| Taille du bouton principal | 298×60 | 304×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 5 col × 8 / 4 col × 7 / 3 col × 3 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 22 | 21 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 10px×5 16px×3 | 16px×8 18px×8 10px×5 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×5 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×22 | 1px×21 | ⚠️ |
| Taille du bouton principal | 298×58 | 304×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/doubs` → `/zones-intervention/doubs/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 22 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×6 10px×6 12px×6 16px×3 | 18px×7 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×14 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×22 | 1px×15 | ⚠️ |
| Taille du bouton principal | 308×60 | 314×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 5 col × 7 / 3 col × 3 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 20 | 18 | ✅ |
| Rayons de cartes employés | 18px×6 12px×6 10px×4 16px×3 | 16px×7 18px×7 10px×4 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×14 rgb(244, 247, 248)×4 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×4 | ⚠️ |
| Filets de cartes employés | 1px×20 | 1px×18 | ⚠️ |
| Taille du bouton principal | 308×58 | 314×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/jura` → `/zones-intervention/jura/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 23 | 16 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×8 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×16 | ⚠️ |
| Taille du bouton principal | 294×60 | 300×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 5 col × 8 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 20 | 19 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×3 | 16px×8 18px×8 10px×3 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×20 | 1px×19 | ⚠️ |
| Taille du bouton principal | 294×58 | 300×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/nievre` → `/zones-intervention/nievre/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 23 | 16 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×8 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×16 | ⚠️ |
| Taille du bouton principal | 309×60 | 315×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 19 | 17 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×2 | 18px×8 16px×7 10px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 | ⚠️ |
| Filets de cartes employés | 1px×19 | 1px×17 | ⚠️ |
| Taille du bouton principal | 309×58 | 315×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/haute-saone` → `/zones-intervention/haute-saone/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 23 | 13 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×8 10px×3 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×13 | ⚠️ |
| Taille du bouton principal | 322×60 | 328×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 3 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 19 | 16 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×2 | 18px×8 16px×7 10px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×15 rgb(244, 247, 248)×1 | ⚠️ |
| Filets de cartes employés | 1px×19 | 1px×16 | ⚠️ |
| Taille du bouton principal | 322×58 | 328×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/saone-et-loire` → `/zones-intervention/saone-et-loire/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 22 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×6 10px×6 12px×6 16px×3 | 18px×7 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×14 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×22 | 1px×15 | ⚠️ |
| Taille du bouton principal | 335×60 | 341×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 7 / 3 col × 3 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 21 | 20 | ✅ |
| Rayons de cartes employés | 18px×6 12px×6 10px×5 16px×3 | 16px×8 18px×7 10px×5 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×14 rgb(244, 247, 248)×5 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×15 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×21 | 1px×20 | ⚠️ |
| Taille du bouton principal | 335×58 | 339×73 | ⚠️ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/yonne` → `/zones-intervention/yonne/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 23 | 16 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×8 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×16 | ⚠️ |
| Taille du bouton principal | 296×60 | 302×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 18 | 17 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×1 | 16px×8 18px×8 10px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(221, 244, 243)×1 rgb(244, 247, 248)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×1 | ⚠️ |
| Filets de cartes employés | 1px×18 | 1px×17 | ⚠️ |
| Taille du bouton principal | 296×58 | 302×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/departement/territoire-de-belfort` → `/zones-intervention/territoire-de-belfort/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 51 | 54 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 820 | ⚠️ |
| Marge gauche du conteneur | 270 | 130 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 20 | 13 | ⚠️ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×3 | 18px×8 10px×3 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×10 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×20 | 1px×13 | ⚠️ |
| Taille du bouton principal | 266×60 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 6 col × 6 | 3 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 29 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 339 | ⚠️ |
| Marge gauche du conteneur | 0 | 18 | ⚠️ |
| Nombre de bandes | 11 | 11 | ✅ |
| Nombre de cartes | 19 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×2 | 18px×8 16px×6 10px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 rgb(221, 244, 243)×1 rgb(220, 231, 235)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×1 | ⚠️ |
| Filets de cartes employés | 1px×19 | 1px×15 | ⚠️ |
| Taille du bouton principal | 266×58 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/dijon` → `/zones-intervention/cote-dor/dijon/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 32 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×7 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×19 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×32 | 1px×24 | ⚠️ |
| Taille du bouton principal | 253×60 | 259×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 13 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 8 / 4 col × 6 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 32 | 28 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×7 16px×3 | 10px×12 18px×10 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×19 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×32 | 1px×28 | ⚠️ |
| Taille du bouton principal | 253×58 | 259×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/besancon` → `/zones-intervention/doubs/besancon/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 23 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×9 12px×7 16px×3 | 10px×12 18px×9 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×12 rgb(255, 255, 255)×11 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×23 | ⚠️ |
| Taille du bouton principal | 288×60 | 294×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 8 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 8 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 29 | 27 | ✅ |
| Rayons de cartes employés | 10px×10 18px×9 12px×7 16px×3 | 16px×9 18px×9 10px×9 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×10 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×18 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×29 | 1px×27 | ⚠️ |
| Taille du bouton principal | 288×58 | 294×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/dole` → `/zones-intervention/jura/dole/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 249×60 | 255×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 7 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 7 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 27 | 24 | ✅ |
| Rayons de cartes employés | 18px×10 10px×8 12px×6 16px×3 | 18px×10 10px×8 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×8 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×8 | ⚠️ |
| Filets de cartes employés | 1px×27 | 1px×24 | ⚠️ |
| Taille du bouton principal | 249×58 | 255×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/lons-le-saunier` → `/zones-intervention/jura/lons-le-saunier/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 333×60 | 339×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 3 col × 6 / 4 col × 6 / 3 col × 4 / 4 col × 6 | 3 col × 6 / 3 col × 6 / 4 col × 6 / 3 col × 4 / 4 col × 6 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 26 | ✅ |
| Rayons de cartes employés | 18px×10 10px×9 12px×6 16px×3 | 18px×10 16px×8 10px×8 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×9 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×18 rgb(244, 247, 248)×8 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×26 | ⚠️ |
| Taille du bouton principal | 333×58 | 339×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/nevers` → `/zones-intervention/nievre/nevers/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 267×60 | 273×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 3 col × 6 / 4 col × 6 / 3 col × 4 / 4 col × 7 | 3 col × 6 / 3 col × 6 / 4 col × 6 / 3 col × 4 / 3 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 29 | 25 | ⚠️ |
| Rayons de cartes employés | 18px×10 10px×10 12px×6 16px×3 | 18px×10 10px×9 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×10 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×29 | 1px×25 | ⚠️ |
| Taille du bouton principal | 267×58 | 273×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/vesoul` → `/zones-intervention/haute-saone/vesoul/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 21 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 18px×10 10px×9 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×21 | ⚠️ |
| Taille du bouton principal | 265×60 | 271×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 25 | ✅ |
| Rayons de cartes employés | 18px×10 10px×9 12px×6 16px×3 | 18px×10 16px×8 10px×7 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×9 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×18 rgb(244, 247, 248)×7 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×25 | ⚠️ |
| Taille du bouton principal | 265×58 | 271×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/chalon-sur-saone` → `/zones-intervention/saone-et-loire/chalon-sur-saone/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 352×60 | 358×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 11 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 30 | 26 | ⚠️ |
| Rayons de cartes employés | 10px×11 18px×10 12px×6 16px×3 | 18px×10 10px×9 16px×7 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×11 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×17 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×30 | 1px×26 | ⚠️ |
| Taille du bouton principal | — | 339×73 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/macon` → `/zones-intervention/saone-et-loire/macon/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 266×60 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 29 | 26 | ✅ |
| Rayons de cartes employés | 18px×10 10px×10 12px×6 16px×3 | 18px×10 10px×9 16px×7 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×10 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×17 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×29 | 1px×26 | ⚠️ |
| Taille du bouton principal | 266×58 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/auxerre` → `/zones-intervention/yonne/auxerre/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 275×60 | 281×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 7 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 7 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 26 | ✅ |
| Rayons de cartes employés | 18px×10 10px×9 12px×6 16px×3 | 18px×10 10px×9 16px×7 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×9 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×17 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×26 | ⚠️ |
| Taille du bouton principal | 275×58 | 281×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/belfort` → `/zones-intervention/territoire-de-belfort/belfort/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 31 | 24 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×10 12px×6 16px×3 | 10px×12 18px×10 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×12 rgb(244, 247, 248)×12 | ⚠️ |
| Filets de cartes employés | 1px×31 | 1px×24 | ⚠️ |
| Taille du bouton principal | 266×60 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 6 col × 7 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 26 | 22 | ⚠️ |
| Rayons de cartes employés | 18px×10 10px×7 12px×6 16px×3 | 18px×10 16px×7 10px×5 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×18 rgb(244, 247, 248)×7 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×17 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×26 | 1px×22 | ⚠️ |
| Taille du bouton principal | 266×58 | 272×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/saint-apollinaire` → `/zones-intervention/cote-dor/saint-apollinaire/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 21 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×7 12px×6 16px×3 | 10px×12 18px×7 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×12 rgb(255, 255, 255)×9 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×21 | ⚠️ |
| Taille du bouton principal | 341×60 | 347×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 6 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 3 col × 4 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 23 | 21 | ✅ |
| Rayons de cartes employés | 18px×7 10px×7 12px×6 16px×3 | 16px×7 18px×7 10px×7 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×7 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×7 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×21 | ⚠️ |
| Taille du bouton principal | — | 339×73 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/chenove` → `/zones-intervention/cote-dor/chenove/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 21 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×7 12px×6 16px×3 | 10px×12 18px×7 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×12 rgb(255, 255, 255)×9 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×21 | ⚠️ |
| Taille du bouton principal | 281×60 | 287×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 4 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 23 | 20 | ✅ |
| Rayons de cartes employés | 18px×7 10px×7 12px×6 16px×3 | 18px×7 10px×7 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×7 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×13 rgb(244, 247, 248)×7 | ⚠️ |
| Filets de cartes employés | 1px×23 | 1px×20 | ⚠️ |
| Taille du bouton principal | 281×58 | 287×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/quetigny` → `/zones-intervention/cote-dor/quetigny/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 22 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×7 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×22 | 1px×15 | ⚠️ |
| Taille du bouton principal | 283×60 | 289×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 4 col × 4 / 4 col × 5 | 3 col × 6 / 4 col × 6 / 3 col × 4 / 3 col × 3 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 19 | 17 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×3 | 16px×7 18px×7 10px×3 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×14 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×19 | 1px×17 | ⚠️ |
| Taille du bouton principal | 283×58 | 289×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/talant` → `/zones-intervention/cote-dor/talant/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 21 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×7 12px×6 16px×3 | 10px×12 18px×7 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×12 rgb(255, 255, 255)×9 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×21 | ⚠️ |
| Taille du bouton principal | 261×60 | 267×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 4 col × 4 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 24 | 20 | ⚠️ |
| Rayons de cartes employés | 10px×8 18px×7 12px×6 16px×3 | 18px×7 10px×7 16px×6 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×8 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×13 rgb(244, 247, 248)×7 | ⚠️ |
| Filets de cartes employés | 1px×24 | 1px×20 | ⚠️ |
| Taille du bouton principal | 261×58 | 267×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/longvic` → `/zones-intervention/cote-dor/longvic/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 28 | 18 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×7 12px×6 16px×3 | 10px×9 18px×7 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×28 | 1px×18 | ⚠️ |
| Taille du bouton principal | 272×60 | 278×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 5 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 3 col × 3 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 21 | 18 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 10px×5 16px×3 | 18px×7 16px×6 10px×5 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×5 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×13 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×21 | 1px×18 | ⚠️ |
| Taille du bouton principal | 272×58 | 278×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/fontaine-les-dijon` → `/zones-intervention/cote-dor/fontaine-les-dijon/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 29 | 22 | ⚠️ |
| Rayons de cartes employés | 10px×12 18px×8 12px×6 16px×3 | 10px×12 18px×8 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×16 rgb(244, 247, 248)×12 rgb(221, 244, 243)×1 | rgb(244, 247, 248)×12 rgb(255, 255, 255)×10 | ⚠️ |
| Filets de cartes employés | 1px×29 | 1px×22 | ⚠️ |
| Taille du bouton principal | 352×60 | 358×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 5 col × 5 | 3 col × 6 / 4 col × 6 / 3 col × 6 / 3 col × 4 / 3 col × 3 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 27 | 25 | ✅ |
| Rayons de cartes employés | 10px×10 18px×8 12px×6 16px×3 | 10px×9 16px×8 18px×8 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×16 rgb(244, 247, 248)×10 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×16 rgb(244, 247, 248)×9 | ⚠️ |
| Filets de cartes employés | 1px×27 | 1px×25 | ⚠️ |
| Taille du bouton principal | — | 339×73 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/marsannay-la-cote` → `/zones-intervention/cote-dor/marsannay-la-cote/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 22 | 15 | ⚠️ |
| Rayons de cartes employés | 18px×7 10px×6 12px×6 16px×3 | 18px×7 10px×6 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×6 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×6 | ⚠️ |
| Filets de cartes employés | 1px×22 | 1px×15 | ⚠️ |
| Taille du bouton principal | 360×58 | 366×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 4 / 4 col × 4 | 3 col × 6 / 4 col × 6 / 3 col × 4 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 18 | 17 | ✅ |
| Rayons de cartes employés | 18px×7 12px×6 16px×3 10px×2 | 16px×8 18px×7 10px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×15 rgb(244, 247, 248)×2 | ⚠️ |
| Filets de cartes employés | 1px×18 | 1px×17 | ⚠️ |
| Taille du bouton principal | — | 339×73 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/ville/beaune` → `/zones-intervention/cote-dor/beaune/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 49 | 49 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 51 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 612 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 20 | 12 | ⚠️ |
| Rayons de cartes employés | 18px×7 12px×7 16px×3 10px×3 | 18px×7 10px×3 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×16 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×9 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×20 | 1px×12 | ⚠️ |
| Taille du bouton principal | 271×60 | 277×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 6 / 3 col × 4 / 3 col × 6 | 3 col × 6 / 4 col × 6 / 3 col × 4 / 3 col × 6 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(147, 218, 219) | — | ⚠️ |
| Taille du H1 | 28 | 32 | ⚠️ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 29 | 33 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 13 | 13 | ✅ |
| Nombre de cartes | 20 | 18 | ✅ |
| Rayons de cartes employés | 18px×7 12px×7 16px×3 10px×3 | 16px×8 18px×7 10px×3 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×16 rgb(244, 247, 248)×3 rgb(221, 244, 243)×1 | rgb(255, 255, 255)×15 rgb(244, 247, 248)×3 | ⚠️ |
| Filets de cartes employés | 1px×20 | 1px×18 | ⚠️ |
| Taille du bouton principal | 271×58 | 277×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/conseils` → `/conseils/`

**1440 px** — ⚠️ 1 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 19 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 7 | 7 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | 211×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 4 col × 4 / 4 col × 4 | 4 col × 4 / 4 col × 4 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 3 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 19 | 24 | ⚠️ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 7 | 7 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | 211×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/article/frequence-bureaux` → `/conseils/frequence-bureaux/`

**1440 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 44 | 44 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 46 | ✅ |
| Taille du premier H2 | 27 | 27 | ✅ |
| Taille du texte | 19 | 14 | ⚠️ |
| Interligne du texte | 30 | 23 | ⚠️ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 2 | 3 | ✅ |
| Rayons de cartes employés | 14px×1 10px×1 | 12px×3 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×2 | rgb(255, 255, 255)×3 | ⚠️ |
| Filets de cartes employés | 1px×2 | 1px×3 | ⚠️ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles | 3 col × 3 | 2 col × 3 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 28 | 29 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 30 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 16 | 14 | ⚠️ |
| Interligne du texte | 26 | 23 | ✅ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 8 | 6 | ✅ |
| Rayons de cartes employés | 10px×4 12px×3 14px×1 | 12px×3 16px×3 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×5 rgb(255, 255, 255)×3 | rgb(255, 255, 255)×6 | ⚠️ |
| Filets de cartes employés | 1px×8 | 1px×6 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/article/cout-nettoyage-bureaux` → `/conseils/cout-nettoyage-bureaux/`

**1440 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 44 | 44 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 46 | ✅ |
| Taille du premier H2 | 27 | 27 | ✅ |
| Taille du texte | 19 | 14 | ⚠️ |
| Interligne du texte | 30 | 23 | ⚠️ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 1 | 3 | ✅ |
| Rayons de cartes employés | 14px×1 | 12px×3 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×1 | rgb(255, 255, 255)×3 | ⚠️ |
| Filets de cartes employés | 1px×1 | 1px×3 | ⚠️ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles | 3 col × 3 | 2 col × 3 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 28 | 29 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 30 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 16 | 14 | ⚠️ |
| Interligne du texte | 26 | 23 | ✅ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 4 | 6 | ✅ |
| Rayons de cartes employés | 12px×3 14px×1 | 12px×3 16px×3 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×3 rgb(244, 247, 248)×1 | rgb(255, 255, 255)×6 | ⚠️ |
| Filets de cartes employés | 1px×4 | 1px×6 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/article/cahier-des-charges-nettoyage` → `/conseils/cahier-des-charges-nettoyage/`

**1440 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 44 | 44 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 46 | ✅ |
| Taille du premier H2 | 27 | 27 | ✅ |
| Taille du texte | 19 | 14 | ⚠️ |
| Interligne du texte | 30 | 23 | ⚠️ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 1 | 3 | ✅ |
| Rayons de cartes employés | 14px×1 | 12px×3 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×1 | rgb(255, 255, 255)×3 | ⚠️ |
| Filets de cartes employés | 1px×1 | 1px×3 | ⚠️ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles | 3 col × 3 | 2 col × 3 / 2 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(24, 35, 45) | rgb(74, 98, 115) | ⚠️ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 28 | 29 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 30 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 16 | 14 | ⚠️ |
| Interligne du texte | 26 | 23 | ✅ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 9 | 9 | ✅ |
| Nombre de cartes | 4 | 5 | ✅ |
| Rayons de cartes employés | 12px×2 14px×1 10px×1 | 12px×3 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×2 rgb(255, 255, 255)×2 | rgb(255, 255, 255)×5 | ⚠️ |
| Filets de cartes employés | 1px×4 | 1px×5 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(255, 255, 255) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | cover | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/pourquoi-top-famille-pro` → `/pourquoi-nous/`

**1440 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 22 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 8 | 8 | ✅ |
| Nombre de cartes | 8 | 0 | ⚠️ |
| Rayons de cartes employés | 14px×4 12px×4 |  | ⚠️ |
| Fonds de cartes employés | rgb(221, 244, 243)×4 rgb(255, 255, 255)×4 |  | ⚠️ |
| Filets de cartes employés | 1px×8 |  | ⚠️ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 4 col × 4 / 4 col × 4 | 6 col × 6 / 7 col × 7 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 8 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 8 | 8 | ✅ |
| Nombre de cartes | 8 | 4 | ⚠️ |
| Rayons de cartes employés | 14px×4 12px×4 | 16px×4 | ⚠️ |
| Fonds de cartes employés | rgb(221, 244, 243)×4 rgb(255, 255, 255)×4 | rgb(255, 255, 255)×4 | ⚠️ |
| Filets de cartes employés | 1px×8 | 1px×4 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/notre-fonctionnement` → `/notre-fonctionnement/`

**1440 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 34 | 34 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 5 | 5 | ✅ |
| Nombre de cartes | 9 | 12 | ✅ |
| Rayons de cartes employés | 16px×5 14px×4 | 14px×7 16px×5 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 | rgb(255, 255, 255)×7 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×9 | 1px×12 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 3 col × 4 / 3 col × 4 |  | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | — | ⚠️ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 24 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 5 | 5 | ✅ |
| Nombre de cartes | 9 | 12 | ✅ |
| Rayons de cartes employés | 16px×5 14px×4 | 14px×7 16px×5 | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×5 rgb(255, 255, 255)×4 | rgb(255, 255, 255)×7 rgb(244, 247, 248)×5 | ⚠️ |
| Filets de cartes employés | 1px×9 | 1px×12 | ⚠️ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/avis-clients` → `/avis-clients/`

**1440 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 31 | 34 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 7 | 7 | ✅ |
| Nombre de cartes | 10 | 0 | ⚠️ |
| Rayons de cartes employés | 16px×7 12px×2 20px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×7 rgb(23, 74, 129)×2 rgb(16, 38, 59)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×7 0px×3 |  | ⚠️ |
| Taille du bouton principal | 211×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles | 3 col × 6 / 4 col × 4 | 6 col × 6 / 7 col × 7 / 10 col × 42 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 22 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 7 | 7 | ✅ |
| Nombre de cartes | 10 | 0 | ⚠️ |
| Rayons de cartes employés | 16px×7 12px×2 20px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×7 rgb(23, 74, 129)×2 rgb(16, 38, 59)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×7 0px×3 |  | ⚠️ |
| Taille du bouton principal | 211×56 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/a-propos` → `/a-propos/`

**1440 px** — ⚠️ 3 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 54 | ✅ |
| Taille du premier H2 | 34 | 34 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 724 | 1260 | ⚠️ |
| Marge gauche du conteneur | 586 | 90 | ⚠️ |
| Nombre de bandes | 6 | 6 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | 215×60 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 4 col × 4 | 4 col × 4 | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 30 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 24 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 375 | ⚠️ |
| Marge gauche du conteneur | 18 | 0 | ⚠️ |
| Nombre de bandes | 6 | 6 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | 215×58 | 216×60 | ✅ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(255, 255, 255) | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | — | ⚠️ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/recrutement` → `/recrutement/`

**1440 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 52 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 52 | 54 | ✅ |
| Taille du premier H2 | 34 | 34 | ✅ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 612 | 1260 | ⚠️ |
| Marge gauche du conteneur | 130 | 90 | ⚠️ |
| Nombre de bandes | 5 | 5 | ✅ |
| Nombre de cartes | 5 | 0 | ⚠️ |
| Rayons de cartes employés | 14px×4 18px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×4 0px×1 |  | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 4 col × 4 | 4 col × 4 / 5 col × 6 | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 12 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 31 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 33 | ✅ |
| Taille du premier H2 | 24 | 24 | ✅ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 375 | ⚠️ |
| Marge gauche du conteneur | 18 | 0 | ⚠️ |
| Nombre de bandes | 5 | 5 | ✅ |
| Nombre de cartes | 5 | 0 | ⚠️ |
| Rayons de cartes employés | 14px×4 18px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(244, 247, 248)×4 rgb(23, 74, 129)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×4 0px×1 |  | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | cover | — | ⚠️ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/demande-de-devis` → `/demande-de-devis/`

**1440 px** — ⚠️ 4 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 54 | ✅ |
| Taille du premier H2 | 25 | 34 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 642 | 642 | ✅ |
| Marge gauche du conteneur | 130 | 130 | ✅ |
| Nombre de bandes | 1 | 2 | ⚠️ |
| Nombre de cartes | 3 | 3 | ✅ |
| Rayons de cartes employés | 16px×3 | 16px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×1 rgb(23, 74, 129)×1 rgb(244, 247, 248)×1 | rgb(255, 255, 255)×2 rgb(23, 74, 129)×1 | ⚠️ |
| Filets de cartes employés | 1px×2 0px×1 | 1px×2 0px×1 | ✅ |
| Taille du bouton principal | 179×47 | 181×47 | ✅ |
| Rayon du bouton | 11px | 11px | ✅ |
| Fond du bouton | rgb(217, 160, 98) | rgb(217, 160, 98) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 7 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 30 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | 20 | 24 | ⚠️ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 339 | 339 | ✅ |
| Marge gauche du conteneur | 18 | 18 | ✅ |
| Nombre de bandes | 1 | 4 | ⚠️ |
| Nombre de cartes | 3 | 3 | ✅ |
| Rayons de cartes employés | 16px×3 | 16px×2 18px×1 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×1 rgb(23, 74, 129)×1 rgb(244, 247, 248)×1 | rgb(255, 255, 255)×2 rgb(23, 74, 129)×1 | ⚠️ |
| Filets de cartes employés | 1px×2 0px×1 | 1px×2 0px×1 | ✅ |
| Taille du bouton principal | 192×53 | 216×60 | ⚠️ |
| Rayon du bouton | 12px | 12px | ✅ |
| Fond du bouton | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/contact` → `/contact/`

**1440 px** — ⚠️ 9 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | rgb(23, 74, 129) | ⚠️ |
| Taille du H1 | 50 | 52 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 54 | ✅ |
| Taille du premier H2 | — | 19 | ⚠️ |
| Taille du texte | 20 | 20 | ✅ |
| Interligne du texte | 32 | 32 | ✅ |
| Largeur du conteneur | 900 | 900 | ✅ |
| Marge gauche du conteneur | 270 | 270 | ✅ |
| Nombre de bandes | 4 | 4 | ✅ |
| Nombre de cartes | 4 | 2 | ✅ |
| Rayons de cartes employés | 12px×2 16px×1 14px×1 | 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×3 rgb(23, 74, 129)×1 | rgb(255, 255, 255)×2 | ⚠️ |
| Filets de cartes employés | 1px×3 0px×1 | 1px×2 | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles | 3 col × 3 |  | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 10 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | rgb(23, 74, 129) | ⚠️ |
| Taille du H1 | 30 | 32 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 33 | ✅ |
| Taille du premier H2 | — | 19 | ⚠️ |
| Taille du texte | 17 | 20 | ⚠️ |
| Interligne du texte | 28 | 32 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 4 | 4 | ✅ |
| Nombre de cartes | 4 | 2 | ✅ |
| Rayons de cartes employés | 12px×2 16px×1 14px×1 | 16px×2 | ⚠️ |
| Fonds de cartes employés | rgb(255, 255, 255)×3 rgb(23, 74, 129)×1 | rgb(255, 255, 255)×2 | ⚠️ |
| Filets de cartes employés | 1px×3 0px×1 | 1px×2 | ⚠️ |
| Taille du bouton principal | — | 216×60 | ⚠️ |
| Rayon du bouton | — | 12px | ⚠️ |
| Fond du bouton | — | rgb(23, 74, 129) | ⚠️ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/plan-du-site` → `/plan-du-site/`

**1440 px** — ⚠️ 2 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | — | — | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | — | — | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 48 | 48 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 50 | 50 | ✅ |
| Taille du premier H2 | 14 | 29 | ⚠️ |
| Taille du texte | — | — | ✅ |
| Interligne du texte | — | — | ✅ |
| Largeur du conteneur | 1260 | 1260 | ✅ |
| Marge gauche du conteneur | 90 | 90 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles | 4 col × 4 |  | ⚠️ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 1 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | — | — | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | — | — | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 30 | 31 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 31 | 32 | ✅ |
| Taille du premier H2 | 14 | 22 | ⚠️ |
| Taille du texte | — | — | ✅ |
| Interligne du texte | — | — | ✅ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 0 | 0 | ✅ |
| Rayons de cartes employés |  |  | ✅ |
| Fonds de cartes employés |  |  | ✅ |
| Filets de cartes employés |  |  | ✅ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/mentions-legales` → `/mentions-legales/`

**1440 px** — ⚠️ 4 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | rgb(23, 74, 129) | ⚠️ |
| Taille du H1 | 46 | 46 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 48 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 19 | 19 | ✅ |
| Interligne du texte | 31 | 31 | ✅ |
| Largeur du conteneur | 820 | 820 | ✅ |
| Marge gauche du conteneur | 310 | 310 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 0 | ✅ |
| Rayons de cartes employés | 12px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×1 |  | ⚠️ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 6 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | rgb(23, 74, 129) | ⚠️ |
| Taille du H1 | 29 | 30 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 31 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 16 | 19 | ⚠️ |
| Interligne du texte | 26 | 31 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 0 | ✅ |
| Rayons de cartes employés | 12px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×1 |  | ⚠️ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/politique-de-confidentialite` → `/politique-de-confidentialite/`

**1440 px** — ⚠️ 3 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 46 | 46 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 48 | ✅ |
| Taille du premier H2 | 29 | 29 | ✅ |
| Taille du texte | 19 | 19 | ✅ |
| Interligne du texte | 31 | 31 | ✅ |
| Largeur du conteneur | 820 | 820 | ✅ |
| Marge gauche du conteneur | 310 | 310 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 0 | ✅ |
| Rayons de cartes employés | 12px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×1 |  | ⚠️ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 5 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | rgb(23, 74, 129) | rgb(23, 74, 129) | ✅ |
| Taille du H1 | 29 | 30 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 31 | ✅ |
| Taille du premier H2 | 21 | 22 | ✅ |
| Taille du texte | 16 | 19 | ⚠️ |
| Interligne du texte | 26 | 31 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 0 | ✅ |
| Rayons de cartes employés | 12px×1 |  | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 |  | ⚠️ |
| Filets de cartes employés | 1px×1 |  | ⚠️ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

### `#/gestion-des-cookies` → `/gestion-des-cookies/`

**1440 px** — ⚠️ 3 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 46 | 46 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 47 | 48 | ✅ |
| Taille du premier H2 | 29 | 19 | ⚠️ |
| Taille du texte | 19 | 19 | ✅ |
| Interligne du texte | 31 | 31 | ✅ |
| Largeur du conteneur | 820 | 820 | ✅ |
| Marge gauche du conteneur | 310 | 310 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 1 | ✅ |
| Rayons de cartes employés | 12px×1 | 16px×1 | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 | rgb(255, 255, 255)×1 | ⚠️ |
| Filets de cartes employés | 1px×1 | 1px×1 | ✅ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | fill | fill | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

**375 px** — ⚠️ 4 écart(s)

| Relevé | Maquette | WordPress | État |
|---|---|---|---|
| Police des titres | bricolage grotesque | bricolage grotesque | ✅ |
| Police du texte | hanken grotesk | hanken grotesk | ✅ |
| Fond de page | rgb(244, 247, 248) | rgb(244, 247, 248) | ✅ |
| Couleur du texte | rgb(52, 72, 90) | rgb(52, 72, 90) | ✅ |
| Couleur des liens | — | — | ✅ |
| Taille du H1 | 29 | 30 | ✅ |
| Graisse du H1 | 800 | 800 | ✅ |
| Interligne du H1 | 30 | 31 | ✅ |
| Taille du premier H2 | 21 | 19 | ✅ |
| Taille du texte | 16 | 19 | ⚠️ |
| Interligne du texte | 26 | 31 | ⚠️ |
| Largeur du conteneur | 375 | 375 | ✅ |
| Marge gauche du conteneur | 0 | 0 | ✅ |
| Nombre de bandes | 3 | 3 | ✅ |
| Nombre de cartes | 1 | 1 | ✅ |
| Rayons de cartes employés | 12px×1 | 16px×1 | ⚠️ |
| Fonds de cartes employés | rgb(252, 239, 224)×1 | rgb(255, 255, 255)×1 | ⚠️ |
| Filets de cartes employés | 1px×1 | 1px×1 | ✅ |
| Taille du bouton principal | — | — | ✅ |
| Rayon du bouton | — | — | ✅ |
| Fond du bouton | — | — | ✅ |
| Colonnes des grilles |  |  | ✅ |
| Cadrage de l’image | — | — | ✅ |
| Fond du pied de page | rgb(16, 38, 59) | rgb(16, 38, 59) | ✅ |

