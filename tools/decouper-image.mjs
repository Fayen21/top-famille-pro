#!/usr/bin/env node
/** Découpe une zone d'une image PNG/JPEG via Chromium (PIL est indisponible sur le banc).
 *  Usage : node tools/decouper-image.mjs <image> <x> <y> <largeur> <hauteur> <sortie> [échelle] */
import { chromium } from '@playwright/test';
import { resolve } from 'node:path';
import { writeFileSync, unlinkSync } from 'node:fs';
const [src, x, y, w, h, out, e] = process.argv.slice(2);
const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const p = await b.newPage({ viewport: { width: Number(w), height: Number(h) }, deviceScaleFactor: Number(e || 1) });
const html = resolve(out) + '.html';
writeFileSync(html, `<body style="margin:0;overflow:hidden"><img src="file://${resolve(src)}" style="position:absolute;left:-${x}px;top:-${y}px"></body>`);
await p.goto('file://' + html);
await p.waitForFunction(() => document.images[0].complete);
await p.screenshot({ path: out });
unlinkSync(html);
await b.close();
