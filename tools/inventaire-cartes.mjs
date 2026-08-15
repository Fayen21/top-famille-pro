#!/usr/bin/env node
/**
 * Inventaire des cartes des 53 routes — maquette Claude Design ↔ WordPress.
 *
 * Les outils précédents comparaient des hauteurs, des textes et des styles. Aucun ne répondait à la
 * question qui reste : **la maquette découpe-t-elle son contenu en autant de cartes que le thème ?**
 * Une page peut contenir toutes les phrases du prototype, faire la même hauteur, et présenter huit
 * contraintes dans deux gros pavés là où la maquette en fait huit micro-cartes. Le contenu est là,
 * l'écran est faux.
 *
 * Cet outil relève donc, des deux côtés, **chaque carte** : son archétype, sa section, son titre,
 * son texte, ses médias, sa géométrie, sa place dans la grille, et son comportement aux deux
 * largeurs. Il en déduit quatre familles d'anomalies, nommées :
 *
 *  - **carte absente** — la maquette en a une que WordPress n'a pas ;
 *  - **cartes fusionnées** — plusieurs cartes de la maquette rendues dans un seul conteneur ;
 *  - **carte supplémentaire** — WordPress en a une que la maquette n'a pas ;
 *  - **mauvais type / mauvais nombre de colonnes** — la carte existe mais pas sous la bonne forme.
 *
 * Une carte n'est jamais comptée pour son conteneur : un bloc qui contient visuellement plusieurs
 * micro-cartes compte pour ses enfants, pas pour lui-même (voir `retirerConteneurs`).
 *
 * Usage :
 *   node tools/inventaire-cartes.mjs
 *   node tools/inventaire-cartes.mjs --only='#/service/cabinets,#/nettoyage-professionnel'
 *   node tools/inventaire-cartes.mjs --widths=1440
 *   node tools/inventaire-cartes.mjs --detail='#/service/cabinets'   → liste carte par carte
 */
import { chromium } from '@playwright/test';
import { writeFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { RELEVE, diagnostiquer } from './lib/cartes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8899';
const RAPPORT = 'docs/INVENTAIRE-CARTES-53-ROUTES.md';

const arg = (n) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1];
const seules = arg('only') ? arg('only').split(',').map((s) => s.trim()).filter(Boolean) : null;
const detail = arg('detail');
const widths = (arg('widths') || '1440,375').split(',').map(Number);

/* ------------------------------------------------------------------ */

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const routes = Object.keys(ROUTE_MAP).filter((r) => !seules || seules.includes(r));
const resultats = {};

for (const largeur of widths) {
	const ref = await browser.newPage({ viewport: { width: largeur, height: 900 } });
	await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
	await ref.waitForTimeout(5500);
	const wp = await browser.newPage({ viewport: { width: largeur, height: 900 } });

	for (const hash of routes) {
		await ref.evaluate((h) => {
			window.scrollTo(0, 0);
			location.hash = h.replace(/^#/, '');
		}, hash);
		await ref.waitForTimeout(1100);
		const a = await ref.evaluate(RELEVE);

		await wp.goto(WP + ROUTE_MAP[hash].wp, { waitUntil: 'networkidle', timeout: 60000 });
		const b = await wp.evaluate(RELEVE);

		const d = diagnostiquer(a, b);
		(resultats[hash] ||= {})[largeur] = { ref: a, wp: b, ...d };

		const graves = d.anomalies.filter((x) => x.genre === 'absente' || x.genre === 'fusionnee').length;
		console.log(
			`${(graves ? '❌' : d.anomalies.length ? '⚠️ ' : '✅').padEnd(3)} ${String(largeur).padStart(4)}px ${hash.padEnd(42)} ` +
				`cartes ${String(a.cartes.length).padStart(3)} → ${String(b.cartes.length).padStart(3)} · ` +
				`${d.anomalies.length} anomalie(s)` +
				(graves ? ` dont ${graves} grave(s)` : '')
		);

		if (detail === hash && largeur === widths[0]) {
			console.log('\n  ── Maquette ──');
			for (const c of a.cartes) console.log(`   b${c.bande} ${c.type.padEnd(18)} ${c.colonnes}col ${c.w}×${c.h} ${c.rayon} ${c.fond} · ${c.texte.slice(0, 60)}`);
			console.log('  ── WordPress ──');
			for (const c of b.cartes) console.log(`   b${c.bande} ${c.type.padEnd(18)} ${c.colonnes}col ${c.w}×${c.h} ${c.rayon} ${c.fond} · ${c.texte.slice(0, 60)}`);
			console.log('  ── Anomalies ──');
			for (const x of d.anomalies) console.log(`   ${x.genre.padEnd(11)} ${(x.type || '').padEnd(18)} ${x.texte || ''}${x.dans ? ' → dans « ' + x.dans + ' »' : ''}${x.attendu ? ` (${x.attendu} → ${x.recu} col)` : ''}${x.recu && !x.attendu ? ' → ' + x.recu : ''}`);
			console.log('');
		}
	}
	await ref.close();
	await wp.close();
}
await browser.close();

/* ------------------------------------------------------------------ */
/* Rapport                                                             */
/* ------------------------------------------------------------------ */

const L = [];
L.push('# Inventaire des cartes — maquette Claude Design ↔ WordPress');
L.push('');
L.push('> Fichier **généré** par `node tools/inventaire-cartes.mjs`. Ne pas éditer à la main.');
L.push('>');
L.push('> Une page peut contenir toutes les phrases du prototype, faire la même hauteur, et présenter');
L.push('> huit contraintes dans deux gros pavés là où la maquette en fait huit micro-cartes. Cet');
L.push('> inventaire relève **chaque carte** des deux côtés — archétype, bande, titre, texte, médias,');
L.push('> géométrie, colonnes — et nomme quatre familles d’anomalies : carte **absente**, cartes');
L.push('> **fusionnées**, carte **supplémentaire**, mauvais **type** ou mauvais nombre de **colonnes**.');
L.push('>');
L.push('> Un conteneur qui contient visuellement plusieurs micro-cartes n’est jamais compté pour une');
L.push('> carte : il compte pour ses enfants.');
L.push('');

const grave = (r) => r.anomalies.filter((x) => x.genre === 'absente' || x.genre === 'fusionnee').length;
const totalGraves = Object.values(resultats).reduce((n, p) => n + Object.values(p).reduce((m, r) => m + grave(r), 0), 0);
const totalAnos = Object.values(resultats).reduce((n, p) => n + Object.values(p).reduce((m, r) => m + r.anomalies.length, 0), 0);

L.push(`**${routes.length} routes × ${widths.length} largeurs · ${totalAnos} anomalie(s), dont ${totalGraves} grave(s)** (carte absente ou fusionnée).`);
L.push('');

L.push('## Synthèse');
L.push('');
L.push('| Route | ' + widths.map((w) => `Cartes ${w} px`).join(' | ') + ' | ' + widths.map((w) => `Anomalies ${w} px`).join(' | ') + ' |');
L.push('|---|' + widths.map(() => '---').join('|') + '|' + widths.map(() => '---').join('|') + '|');
for (const hash of routes) {
	const cartes = widths.map((w) => {
		const r = resultats[hash][w];
		const d = r.wp.cartes.length - r.ref.cartes.length;
		return `${r.ref.cartes.length} → ${r.wp.cartes.length}${d ? ` (${d > 0 ? '+' : ''}${d})` : ''}`;
	});
	const anos = widths.map((w) => {
		const r = resultats[hash][w];
		const g = grave(r);
		return g ? `❌ ${r.anomalies.length} (${g})` : r.anomalies.length ? `⚠️ ${r.anomalies.length}` : '✅';
	});
	L.push(`| \`${hash}\` | ${cartes.join(' | ')} | ${anos.join(' | ')} |`);
}
L.push('');

L.push('## Routes à corriger en priorité');
L.push('');
const prioritaires = routes
	.map((h) => ({ h, g: grave(resultats[h][widths[0]]), a: resultats[h][widths[0]].anomalies.length }))
	.filter((x) => x.g > 0)
	.sort((x, y) => y.g - x.g);
if (!prioritaires.length) {
	L.push('Aucune : aucune carte absente ni fusionnée à ' + widths[0] + ' px.');
} else {
	L.push('| Route | Cartes absentes ou fusionnées | Anomalies totales |');
	L.push('|---|---|---|');
	for (const x of prioritaires) L.push(`| \`${x.h}\` | ${x.g} | ${x.a} |`);
}
L.push('');

L.push('## Archétypes employés par la maquette');
L.push('');
const parType = new Map();
for (const h of routes) {
	for (const c of resultats[h][widths[0]].ref.cartes) parType.set(c.type, (parType.get(c.type) || 0) + 1);
}
L.push('| Archétype | Occurrences dans la maquette |');
L.push('|---|---|');
for (const [t, n] of [...parType.entries()].sort((a, b) => b[1] - a[1])) L.push(`| \`${t}\` | ${n} |`);
L.push('');

L.push('## Détail par route');
L.push('');
for (const hash of routes) {
	const r0 = resultats[hash][widths[0]];
	L.push(`### \`${hash}\` → \`${ROUTE_MAP[hash].wp}\``);
	L.push('');
	for (const w of widths) {
		const r = resultats[hash][w];
		L.push(
			`**${w} px** — bandes ${r.ref.sections} → ${r.wp.sections} · cartes ${r.ref.cartes.length} → ${r.wp.cartes.length} · ` +
				`${r.anomalies.length} anomalie(s)`
		);
		L.push('');
		if (r.anomalies.length) {
			L.push('| Anomalie | Archétype | Bande | Détail |');
			L.push('|---|---|---|---|');
			for (const x of r.anomalies.slice(0, 30)) {
				const det =
					x.genre === 'fusionnee'
						? `« ${x.texte} » rendue dans « ${x.dans} »`
						: x.genre === 'colonnes'
							? `« ${x.texte} » — ${x.attendu} colonnes attendues, ${x.recu} rendues`
							: x.genre === 'type'
								? `« ${x.texte} » — rendue en \`${x.recu}\``
								: x.genre === 'texte'
									? `« ${x.texte} » → « ${x.recu} » (${x.proximite} % de mots communs)`
									: `« ${x.texte} »`;
				L.push(`| ${x.genre} | \`${x.type}\` | ${x.bande} | ${det.replace(/\|/g, '/')} |`);
			}
			if (r.anomalies.length > 30) L.push(`| … | | | ${r.anomalies.length - 30} autres |`);
			L.push('');
		}
	}
	L.push('');
}

writeFileSync(RAPPORT + (seules ? '.partiel' : ''), L.join('\n') + '\n');

/*
 * Vidage brut, en plus du rapport lisible.
 *
 * Le rapport tronque le détail par route — utile à lire, inexploitable pour **classer une par une**
 * les anomalies d'une famille sur les 53 routes. Le JSON, lui, est exhaustif.
 */
writeFileSync(
	'docs/inventaire-cartes.json' + (seules ? '.partiel' : ''),
	JSON.stringify(
		Object.fromEntries(
			Object.entries(resultats).map(([hash, parLargeur]) => [
				hash,
				Object.fromEntries(
					Object.entries(parLargeur).map(([largeur, d]) => [
						largeur,
						{ cartesRef: d.ref.cartes.length, cartesWp: d.wp.cartes.length, anomalies: d.anomalies },
					])
				),
			])
		),
		null,
		1
	) + '\n'
);
console.error(`\nÉcrit : ${RAPPORT}${seules ? '.partiel' : ''} — ${totalAnos} anomalie(s), ${totalGraves} grave(s)`);
