#!/usr/bin/env node
/**
 * Sonde de simulation G23 : rejoue RELEVE + diagnostiquer sur UNE route, avec une feuille de
 * surcharge optionnelle injectée côté WordPress seulement — pour valider une correction avant
 * de l'écrire dans le thème. N'écrit aucun fichier de docs/.
 *
 * Usage : node probe-cartes.mjs '#/nos-prestations' 1440 [surcharge.css] [filtre-texte]
 */
import { chromium } from '@playwright/test';
import { readFileSync } from 'node:fs';
import { ROUTE_MAP } from './route-map.mjs';
import { RELEVE, diagnostiquer } from './lib/cartes.mjs';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';

const [route, largeurArg, surchargeFichier, filtre] = process.argv.slice(2);
const largeur = Number(largeurArg || 1440);
const surcharge = surchargeFichier ? readFileSync(surchargeFichier, 'utf8') : '';

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const ref = await browser.newPage({ viewport: { width: largeur, height: 900 } });
await ref.goto(REF, { waitUntil: 'load', timeout: 90000 });
await ref.waitForTimeout(5500);
await ref.evaluate((h) => { window.scrollTo(0, 0); location.hash = h.replace(/^#/, ''); }, route);
await ref.waitForTimeout(1100);
const a = await ref.evaluate(RELEVE);

const wp = await browser.newPage({ viewport: { width: largeur, height: 900 } });
await wp.goto(WP + ROUTE_MAP[route].wp, { waitUntil: 'networkidle', timeout: 60000 });
if (surcharge) await wp.addStyleTag({ content: surcharge });
const b = await wp.evaluate(RELEVE);
const d = diagnostiquer(a, b);
await browser.close();

const garde = (t) => !filtre || (t || '').toLowerCase().includes(filtre.toLowerCase());
console.log(`${route} @ ${largeur}px — cartes ${a.cartes.length} → ${b.cartes.length} · ${d.anomalies.length} anomalie(s)${surcharge ? ' · AVEC SURCHARGE' : ''}`);
console.log('— anomalies surplus/colonnes' + (filtre ? ` (filtre « ${filtre} »)` : '') + ' :');
for (const x of d.anomalies) {
	if (x.genre !== 'surplus' && x.genre !== 'colonnes') continue;
	if (!garde(x.texte)) continue;
	console.log(`  ${x.genre.padEnd(9)} b${x.bande} ${x.type.padEnd(16)} ${x.attendu ? `${x.attendu}→${x.recu} col ` : ''}« ${x.texte} »`);
}
if (filtre) {
	console.log('— cartes maquette filtrées :');
	for (const c of a.cartes) if (garde(c.texte)) console.log(`  b${c.bande} ${c.type.padEnd(16)} ${c.colonnes}col ${c.w}×${c.h} rayon ${c.rayon} fond ${c.fond} « ${c.texte.slice(0, 60)} »`);
	console.log('— cartes WordPress filtrées :');
	for (const c of b.cartes) if (garde(c.texte)) console.log(`  b${c.bande} ${c.type.padEnd(16)} ${c.colonnes}col ${c.w}×${c.h} rayon ${c.rayon} fond ${c.fond} « ${c.texte.slice(0, 60)} »`);
}
