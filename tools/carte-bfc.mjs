#!/usr/bin/env node
/**
 * Construit la carte SVG des huit départements de Bourgogne-Franche-Comté à partir de
 * géométries administratives RÉELLES — jamais d'une silhouette dessinée à la main.
 *
 * ## Source des tracés
 *
 * IGN — ADMIN EXPRESS COG, édition 2018, telle que convertie en GeoJSON par le projet
 * « france-geojson » de Grégoire David (https://github.com/gregoiredavid/france-geojson) :
 * conversion du SHP IGN par mapshaper, simplification « visvalingam weighted » à 25 %, précision
 * des coordonnées limitée à 5 décimales (≈ 1,1 m). Fichier : regions/bourgogne-franche-comte/
 * departements-bourgogne-franche-comte.geojson, récupéré le 21 octobre 2026.
 *
 * Les catalogues officiels (data.gouv.fr, geoservices IGN, geo.api.gouv.fr, DataBFC) ne sont pas
 * joignables depuis l'environnement de travail — proxy sortant. Le dérivé GitHub est le seul
 * chemin d'accès à ces tracés IGN ; il est documenté comme tel, avec son millésime et sa chaîne
 * de transformation, dans docs/CARTE-BFC-SOURCE.md. Les données IGN ADMIN EXPRESS sont diffusées
 * sous Licence Ouverte 2.0 (Etalab) ; l'attribution « IGN — ADMIN EXPRESS COG 2018 » figure dans
 * le SVG rendu.
 *
 * ## Projection
 *
 * Une seule projection pour les huit départements : plate carrée corrigée du cosinus de la
 * latitude moyenne (≈ 47,1° N), ce qui préserve les proportions à l'échelle d'une région de
 * 300 km sans déformer un département par rapport à l'autre. Le facteur d'échelle est COMMUN.
 *
 * ## Simplification
 *
 * Le fichier régional brut pèse 268 Ko — trop pour un SVG en ligne sur l'accueil. Une seconde passe
 * de simplification est appliquée avec mapshaper (devDependency), par la MÊME méthode que l'amont :
 *
 *   mapshaper -i departements.geojson -simplify 8% weighted keep-shapes -o precision=0.0001
 *
 * mapshaper simplifie des ARCS partagés, pas des polygones indépendants : une frontière commune à
 * deux départements reste identique des deux côtés, aucun trou ni recouvrement n'apparaît. 8 % donne
 * 1 138 sommets pour les huit départements — 20 Ko de GeoJSON, ~15 Ko de chemins SVG — et conserve
 * les indentations caractéristiques (la pointe du Jura, l'enclave de la Côte-d'Or). Le résultat est
 * versionné dans tools/data/ pour que la régénération ne dépende plus du réseau. Le script ne
 * retouche ensuite que la précision d'écriture (arrondi à 0,1 px dans le repère SVG).
 *
 * ## Repère de Saint-Apollinaire
 *
 * Centroïde de la commune (code INSEE 21540) calculé sur son polygone IGN dans
 * departements/21-cote-d-or/communes-21-cote-d-or.geojson, même jeu, même millésime :
 * 5,09312 E · 47,33600 N. Un seul repère, légendé « Implantation de Top-Famille Pro ».
 *
 * Usage : node tools/carte-bfc.mjs [departements.geojson] [saint-apollinaire.geojson]
 *   (par défaut les deux fichiers de tools/data/)
 *   → wp-content/themes/topfamillepro/template-parts/home/carte-bfc.php (données du SVG)
 *   → docs/CARTE-BFC-SOURCE.md
 */
import { readFileSync, writeFileSync } from 'node:fs';

const FICHIER_DEPTS = process.argv[2] || 'tools/data/departements-bfc-ign-adminexpress-cog-2018-simplifie-8pct.geojson';
const FICHIER_COMMUNES = process.argv[3] || 'tools/data/saint-apollinaire-21540-ign-adminexpress-cog-2018.geojson';

const ATTENDUS = ['21', '25', '39', '58', '70', '71', '89', '90'];
const NOMS = {
	21: "Côte-d'Or", 25: 'Doubs', 39: 'Jura', 58: 'Nièvre',
	70: 'Haute-Saône', 71: 'Saône-et-Loire', 89: 'Yonne', 90: 'Territoire de Belfort',
};
const SLUGS = {
	21: 'cote-dor', 25: 'doubs', 39: 'jura', 58: 'nievre',
	70: 'haute-saone', 71: 'saone-et-loire', 89: 'yonne', 90: 'territoire-de-belfort',
};

const depts = JSON.parse(readFileSync(FICHIER_DEPTS, 'utf8'));
const communes = JSON.parse(readFileSync(FICHIER_COMMUNES, 'utf8'));

// --- Contrôle : exactement les huit départements attendus, pas un de plus ni de moins.
const codes = depts.features.map((f) => String(f.properties.code)).sort();
if (JSON.stringify(codes) !== JSON.stringify(ATTENDUS)) {
	console.error('Codes inattendus dans le jeu :', codes);
	process.exit(1);
}

// --- Emprise géographique commune.
const anneaux = (g) => (g.type === 'Polygon' ? [g.coordinates] : g.coordinates);
let minLon = Infinity, maxLon = -Infinity, minLat = Infinity, maxLat = -Infinity;
for (const f of depts.features) {
	for (const poly of anneaux(f.geometry)) {
		for (const [lon, lat] of poly[0]) {
			if (lon < minLon) minLon = lon; if (lon > maxLon) maxLon = lon;
			if (lat < minLat) minLat = lat; if (lat > maxLat) maxLat = lat;
		}
	}
}
const latMoy = (minLat + maxLat) / 2;
const k = Math.cos((latMoy * Math.PI) / 180);

// --- Projection : un seul facteur d'échelle pour tout le monde, viewBox 640 de large.
const LARGEUR = 640;
const MARGE = 12;
const echelle = (LARGEUR - 2 * MARGE) / ((maxLon - minLon) * k);
const HAUTEUR = Math.round((maxLat - minLat) * echelle + 2 * MARGE);
const projeter = ([lon, lat]) => [
	MARGE + (lon - minLon) * k * echelle,
	MARGE + (maxLat - lat) * echelle,
];
const px = (n) => Math.round(n * 10) / 10;

// --- Centroïde (aire signée) et aire d'un anneau projeté.
function centroide(anneau) {
	let A = 0, cx = 0, cy = 0;
	for (let i = 0; i < anneau.length - 1; i++) {
		const [x0, y0] = anneau[i], [x1, y1] = anneau[i + 1];
		const c = x0 * y1 - x1 * y0;
		A += c; cx += (x0 + x1) * c; cy += (y0 + y1) * c;
	}
	A /= 2;
	return { x: cx / (6 * A), y: cy / (6 * A), aire: Math.abs(A) };
}

const departements = depts.features.map((f) => {
	const code = String(f.properties.code);
	const polys = anneaux(f.geometry).map((poly) => poly.map((anneau) => anneau.map(projeter)));
	const d = polys
		.map((poly) => poly.map((anneau) => 'M' + anneau.map(([x, y]) => `${px(x)},${px(y)}`).join('L') + 'Z').join(''))
		.join('');
	// Étiquette : centroïde du plus grand anneau extérieur.
	const principal = polys.map((p) => p[0]).map(centroide).sort((a, b) => b.aire - a.aire)[0];
	return { code, nom: NOMS[code], slug: SLUGS[code], d, etiquette: { x: px(principal.x), y: px(principal.y) }, aire: principal.aire };
}).sort((a, b) => a.code.localeCompare(b.code));

// --- Saint-Apollinaire : centroïde de la commune 21540 sur son polygone IGN.
const stApo = communes.features.find((f) => String(f.properties.code) === '21540');
if (!stApo) { console.error('Commune 21540 absente du jeu des communes'); process.exit(1); }
const cStApo = centroide(anneaux(stApo.geometry)[0][0]);
const stApoProj = projeter([cStApo.x, cStApo.y]);

// --- Le Territoire de Belfort est trop petit pour porter son code : renvoi hors surface, vers le
// nord-est, et CONTENU dans le viewBox (le département touche le bord droit de l'emprise).
const t90 = departements.find((d) => d.code === '90');
t90.renvoi = { x: px(Math.min(t90.etiquette.x + 12, LARGEUR - 26)), y: px(t90.etiquette.y - 38) };

// --- Écriture du partial PHP (données uniquement, le gabarit coverage.php compose le reste).
const L = [];
L.push('<?php');
L.push('/**');
L.push(' * Données de la carte des huit départements — FICHIER GÉNÉRÉ par tools/carte-bfc.mjs, ne pas');
L.push(' * éditer à la main.');
L.push(' *');
L.push(' * Tracés : IGN ADMIN EXPRESS COG, édition 2018, via france-geojson (mapshaper, visvalingam');
L.push(' * 25 %, précision 1e-5). Projection plate carrée corrigée de cos(lat moyenne), échelle commune.');
L.push(` * Emprise : ${minLon.toFixed(4)}–${maxLon.toFixed(4)} E, ${minLat.toFixed(4)}–${maxLat.toFixed(4)} N. viewBox 0 0 ${LARGEUR} ${HAUTEUR}.`);
L.push(` * Saint-Apollinaire (21540) : ${cStApo.x.toFixed(5)} E, ${cStApo.y.toFixed(5)} N — centroïde du polygone communal IGN.`);
L.push(' * Voir docs/CARTE-BFC-SOURCE.md.');
L.push(' */');
L.push('');
L.push("if ( ! defined( 'ABSPATH' ) ) {");
L.push('\texit;');
L.push('}');
L.push('');
L.push('return array(');
L.push(`\t'viewbox'   => '0 0 ${LARGEUR} ${HAUTEUR}',`);
L.push(`\t'source'    => 'IGN — ADMIN EXPRESS COG 2018',`);
L.push(`\t'siege'     => array( 'x' => ${px(stApoProj[0])}, 'y' => ${px(stApoProj[1])}, 'lon' => ${cStApo.x.toFixed(5)}, 'lat' => ${cStApo.y.toFixed(5)} ),`);
L.push("\t'departements' => array(");
for (const d of departements) {
	L.push('\t\tarray(');
	L.push(`\t\t\t'code'      => '${d.code}',`);
	L.push(`\t\t\t'nom'       => '${d.nom.replace(/'/g, "\\'")}',`);
	L.push(`\t\t\t'slug'      => '${d.slug}',`);
	L.push(`\t\t\t'etiquette' => array( 'x' => ${d.etiquette.x}, 'y' => ${d.etiquette.y} ),`);
	if (d.renvoi) L.push(`\t\t\t'renvoi'    => array( 'x' => ${d.renvoi.x}, 'y' => ${d.renvoi.y} ),`);
	L.push(`\t\t\t'd'         => '${d.d}',`);
	L.push('\t\t),');
}
L.push('\t),');
L.push(');');
const SORTIE_PHP = 'wp-content/themes/topfamillepro/template-parts/home/carte-bfc.php';
writeFileSync(SORTIE_PHP, L.join('\n') + '\n');

// --- Documentation de la source.
const doc = `# Carte des huit départements — source, millésime, licence

> Fichier généré par \`tools/carte-bfc.mjs\` le ${new Date().toISOString().slice(0, 10)}. Ne pas éditer à la main.

## Tracés

| | |
|---|---|
| Producteur | **IGN — ADMIN EXPRESS COG** |
| Millésime | **édition 2018** |
| Licence | **Licence Ouverte 2.0 (Etalab)** — licence de diffusion d'ADMIN EXPRESS |
| Chemin d'accès | dérivé GeoJSON du projet *france-geojson* (Grégoire David), fichier \`regions/bourgogne-franche-comte/departements-bourgogne-franche-comte.geojson\`, récupéré le 21 octobre 2026 |
| Transformation amont | SHP IGN → GeoJSON par mapshaper ; simplification *visvalingam weighted* 25 % ; coordonnées à 5 décimales (≈ 1,1 m) |
| Transformation ici | seconde simplification mapshaper *visvalingam weighted* **8 %** (arcs partagés : topologie préservée, aucune retouche manuelle), puis projection plate carrée corrigée de cos(latitude moyenne ${latMoy.toFixed(3)}°), **échelle commune** aux huit départements ; arrondi à 0,1 px dans le repère SVG |

Les catalogues officiels (data.gouv.fr, geoservices IGN, geo.api.gouv.fr, DataBFC) ne sont pas
joignables depuis l'environnement de travail — proxy sortant. Le dérivé GitHub est le seul chemin
d'accès à ces tracés IGN ; sa chaîne de transformation est documentée par son auteur et reprise
ci-dessus. Si une passe ultérieure dispose d'un accès direct à ADMIN EXPRESS COG, régénérer depuis
le fichier IGN avec le même outil suffit : le script contrôle qu'il reçoit exactement les huit
codes 21, 25, 39, 58, 70, 71, 89 et 90, et refuse tout autre jeu.

## Emprise et projection

- Longitudes ${minLon.toFixed(4)} → ${maxLon.toFixed(4)} E, latitudes ${minLat.toFixed(4)} → ${maxLat.toFixed(4)} N.
- viewBox \`0 0 ${LARGEUR} ${HAUTEUR}\`, marge ${MARGE} px.

## Départements rendus

| Code | Nom | Étiquette (x, y) | Surface relative |
|---|---|---|---:|
${departements.map((d) => `| ${d.code} | ${d.nom} | ${d.etiquette.x}, ${d.etiquette.y}${d.renvoi ? ' → renvoi ' + d.renvoi.x + ', ' + d.renvoi.y : ''} | ${(d.aire / departements[0].aire).toFixed(2)} |`).join('\n')}

Le Territoire de Belfort (90) est trop petit pour porter son code dans sa surface : il est
étiqueté par un renvoi, comme le brief l'autorise.

## Repère de l'implantation

Saint-Apollinaire, code INSEE **21540** : **${cStApo.x.toFixed(5)} E · ${cStApo.y.toFixed(5)} N**, centroïde du
polygone communal du même jeu IGN (\`departements/21-cote-d-or/communes-21-cote-d-or.geojson\`).
Un seul repère sur la carte, légendé « Implantation de Top-Famille Pro ». Aucun autre repère :
le site n'a qu'un établissement (CLAUDE.md §5.2).

## Ce que la carte affirme — et n'affirme pas

Le zonage représente la **couverture déclarée** (PROJECT_INPUTS.md §6 : huit départements). Il
n'introduit aucune garantie de disponibilité immédiate, aucun niveau de service, aucune zone
prioritaire : les huit surfaces portent la même couleur.
`;
writeFileSync('docs/CARTE-BFC-SOURCE.md', doc);

console.log(`✓ ${departements.length} départements · viewBox 0 0 ${LARGEUR} ${HAUTEUR} · échelle ${echelle.toFixed(1)} px/°`);
console.log(`✓ Saint-Apollinaire → ${px(stApoProj[0])}, ${px(stApoProj[1])} (${cStApo.x.toFixed(5)} E, ${cStApo.y.toFixed(5)} N)`);
console.log(`→ ${SORTIE_PHP}\n→ docs/CARTE-BFC-SOURCE.md`);
