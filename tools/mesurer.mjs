#!/usr/bin/env node
/**
 * Mesure rapide : styles calculés d'un sélecteur sur une page du banc.
 *
 * Usage : node tools/mesurer.mjs <url> <sélecteur> [largeur] [propriétés,séparées,par,virgules]
 */
import { chromium } from '@playwright/test';
const [url, sel, w, props] = process.argv.slice(2);
const PROPS = (props || 'font-weight,font-size,color,background-color,border-width').split(',');
const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const p = await b.newPage({ viewport: { width: Number(w || 1440), height: 900 } });
await p.goto(url, { waitUntil: 'load' });
const out = await p.$$eval(sel, (els, PROPS) => els.slice(0, 6).map((e) => {
	const cs = getComputedStyle(e); const o = { texte: (e.textContent || '').trim().slice(0, 40) };
	for (const k of PROPS) o[k] = cs.getPropertyValue(k);
	const r = e.getBoundingClientRect(); o.boite = [Math.round(r.left), Math.round(r.top), Math.round(r.width), Math.round(r.height)].join('×');
	return o;
}), PROPS);
console.log(JSON.stringify(out, null, 1));
await b.close();
