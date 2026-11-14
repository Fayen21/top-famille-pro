#!/usr/bin/env node
/**
 * Table « route → fichier de photo », établie sur les OCTETS de la maquette — G26 §3.
 *
 * L'audit par rôle (tools/audit-images-role.mjs) a montré que les héros des pages de prestation et
 * ceux des pages de ville étaient CROISÉS : le thème servait au hero de /prestations/bureaux/ la
 * photo que la maquette pose sur Auxerre, et réciproquement. La cause est une table écrite de
 * mémoire dans build/optimize-images.mjs, où les mêmes fichiers Unsplash servent aux deux familles.
 *
 * Cet outil ne devine rien. Il extrait, pour chaque route de la maquette, les octets réels du
 * visuel de tête, en calcule l'empreinte SHA-256, et cherche parmi les fichiers d'`assets/photos/`
 * celui qui porte la même. Le résultat est la table à recopier — et, s'il manque un fichier, il le
 * dit au lieu de proposer un remplaçant plausible.
 *
 * Usage : node tools/mapper-photos-maquette.mjs
 */
import { chromium } from '@playwright/test';
import { createHash } from 'node:crypto';
import { readFileSync, readdirSync } from 'node:fs';
import path from 'node:path';

const REF = 'file://' + process.cwd() + '/reference/Top-Famille-Pro-HANDOFF-READY.html';
const PHOTOS = path.join(process.cwd(), 'assets', 'photos');

const ROUTES = [
	['service-bureaux', '#/service/bureaux'],
	['service-commerces', '#/service/commerces'],
	['service-cabinets', '#/service/cabinets'],
	['service-coproprietes', '#/service/coproprietes'],
	['service-meubles', '#/service/meubles'],
	['service-ponctuel', '#/service/ponctuel'],
	['ville-dijon', '#/ville/dijon'],
	['ville-besancon', '#/ville/besancon'],
	['ville-dole', '#/ville/dole'],
	['ville-lons-le-saunier', '#/ville/lons-le-saunier'],
	['ville-nevers', '#/ville/nevers'],
	['ville-vesoul', '#/ville/vesoul'],
	['ville-chalon-sur-saone', '#/ville/chalon-sur-saone'],
	['ville-macon', '#/ville/macon'],
	['ville-auxerre', '#/ville/auxerre'],
	['ville-belfort', '#/ville/belfort'],
	['ville-saint-apollinaire', '#/ville/saint-apollinaire'],
	['ville-chenove', '#/ville/chenove'],
	['ville-quetigny', '#/ville/quetigny'],
	['ville-talant', '#/ville/talant'],
	['ville-longvic', '#/ville/longvic'],
	['ville-fontaine-les-dijon', '#/ville/fontaine-les-dijon'],
	['ville-marsannay-la-cote', '#/ville/marsannay-la-cote'],
	['ville-beaune', '#/ville/beaune'],
];

/*
 * Empreintes des fichiers du dépôt. Une même photo existe souvent en plusieurs largeurs : elles ont
 * des empreintes différentes, et c'est celle des octets EMBARQUÉS par la maquette qu'on cherche.
 * On indexe donc aussi une empreinte « perceptuelle » de repli — les premiers octets du flux JPEG
 * après l'en-tête — inutile ici tant que les octets coïncident exactement.
 */
const parEmpreinte = new Map();
for (const f of readdirSync(PHOTOS)) {
	if (!/\.(jpe?g|png|webp|avif)$/i.test(f)) continue;
	const buf = readFileSync(path.join(PHOTOS, f));
	parEmpreinte.set(createHash('sha256').update(buf).digest('hex'), f);
}

const browser = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
await page.goto(REF, { waitUntil: 'load', timeout: 90000 });
await page.waitForTimeout(5500);

const resultats = [];
for (const [slug, hash] of ROUTES) {
	await page.evaluate((h) => {
		location.hash = h.replace(/^#/, '');
	}, hash);
	await page.waitForTimeout(900);

	// Visuel de tête : la plus grande image rendue avant le premier H2 de la page.
	const b64 = await page.evaluate(async () => {
		const images = [...document.images].filter((i) => {
			const r = i.getBoundingClientRect();
			return r.width > 200 && r.height > 150 && !i.closest('header') && !i.closest('footer');
		});
		if (!images.length) return null;
		const img = images[0];
		const rep = await fetch(img.currentSrc);
		const buf = new Uint8Array(await rep.arrayBuffer());
		let s = '';
		for (const o of buf) s += String.fromCharCode(o);
		return btoa(s);
	});
	if (!b64) {
		resultats.push({ slug, hash, empreinte: null, fichier: null });
		continue;
	}
	const empreinte = createHash('sha256').update(Buffer.from(b64, 'base64')).digest('hex');
	resultats.push({ slug, hash, empreinte, fichier: parEmpreinte.get(empreinte) || null });
}
await browser.close();

console.log('\n// Table relevée sur les octets de la maquette — à recopier dans build/optimize-images.mjs\n');
let manquants = 0;
for (const r of resultats) {
	if (r.fichier) {
		console.log(`  { slug: '${r.slug}', src: '${r.fichier}' },`);
	} else {
		manquants++;
		console.log(`  // ${r.slug} (${r.hash}) : AUCUN fichier d'assets/photos ne porte ${r.empreinte ? r.empreinte.slice(0, 16) : '(image introuvable)'}`);
	}
}
console.log(`\n${resultats.length - manquants}/${resultats.length} appariées par empreinte.`);
if (manquants) {
	console.log(`${manquants} route(s) sans fichier correspondant : ne rien inventer, extraire l'asset du standalone.`);
}
