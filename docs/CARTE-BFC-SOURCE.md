# Carte des huit départements — source, millésime, licence

> Fichier généré par `tools/carte-bfc.mjs` le 2026-10-21. Ne pas éditer à la main.

## Tracés

| | |
|---|---|
| Producteur | **IGN — ADMIN EXPRESS COG** |
| Millésime | **édition 2018** |
| Licence | **Licence Ouverte 2.0 (Etalab)** — licence de diffusion d'ADMIN EXPRESS |
| Chemin d'accès | dérivé GeoJSON du projet *france-geojson* (Grégoire David), fichier `regions/bourgogne-franche-comte/departements-bourgogne-franche-comte.geojson`, récupéré le 21 octobre 2026 |
| Transformation amont | SHP IGN → GeoJSON par mapshaper ; simplification *visvalingam weighted* 25 % ; coordonnées à 5 décimales (≈ 1,1 m) |
| Transformation ici | seconde simplification mapshaper *visvalingam weighted* **8 %** (arcs partagés : topologie préservée, aucune retouche manuelle), puis projection plate carrée corrigée de cos(latitude moyenne 47.275°), **échelle commune** aux huit départements ; arrondi à 0,1 px dans le repère SVG |

Les catalogues officiels (data.gouv.fr, geoservices IGN, geo.api.gouv.fr, DataBFC) ne sont pas
joignables depuis l'environnement de travail — proxy sortant. Le dérivé GitHub est le seul chemin
d'accès à ces tracés IGN ; sa chaîne de transformation est documentée par son auteur et reprise
ci-dessus. Si une passe ultérieure dispose d'un accès direct à ADMIN EXPRESS COG, régénérer depuis
le fichier IGN avec le même outil suffit : le script contrôle qu'il reçoit exactement les huit
codes 21, 25, 39, 58, 70, 71, 89 et 90, et refuse tout autre jeu.

## Emprise et projection

- Longitudes 2.8487 → 7.1359 E, latitudes 46.1559 → 48.3943 N.
- viewBox `0 0 640 498`, marge 12 px.

## Départements rendus

| Code | Nom | Étiquette (x, y) | Surface relative |
|---|---|---|---:|
| 21 | Côte-d'Or | 288.4, 217.1 | 1.00 |
| 25 | Doubs | 516.8, 272.1 | 0.60 |
| 39 | Jura | 421.4, 364.6 | 0.57 |
| 58 | Nièvre | 106.2, 282.8 | 0.78 |
| 70 | Haute-Saône | 477.3, 171.3 | 0.62 |
| 71 | Saône-et-Loire | 255.4, 382.5 | 0.97 |
| 89 | Yonne | 114.7, 129.5 | 0.86 |
| 90 | Territoire de Belfort | 598.1, 173.7 → renvoi 610.1, 135.7 | 0.07 |

Le Territoire de Belfort (90) est trop petit pour porter son code dans sa surface : il est
étiqueté par un renvoi, comme le brief l'autorise.

## Repère de l'implantation

Saint-Apollinaire, code INSEE **21540** : **5.09312 E · 47.33600 N**, centroïde du
polygone communal du même jeu IGN (`departements/21-cote-d-or/communes-21-cote-d-or.geojson`).
Un seul repère sur la carte, légendé « Implantation de Top-Famille Pro ». Aucun autre repère :
le site n'a qu'un établissement (CLAUDE.md §5.2).

## Ce que la carte affirme — et n'affirme pas

Le zonage représente la **couverture déclarée** (PROJECT_INPUTS.md §6 : huit départements). Il
n'introduit aucune garantie de disponibilité immédiate, aucun niveau de service, aucune zone
prioritaire : les huit surfaces portent la même couleur.
