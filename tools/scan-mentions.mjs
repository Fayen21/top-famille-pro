#!/usr/bin/env node
/**
 * Balayage des 53 routes (14 novembre 2026) : toute formulation de chantier restée à l'écran ou
 * dans un attribut lu par un visiteur (alt, title, aria-label, placeholder, meta description).
 * Usage : node tools/scan-mentions.mjs [base] → liste par route, code de sortie 1 s'il en reste.
 */
import { ROUTES } from '../tests/data/routes.js';

const BASE = process.argv[2] || process.env.TFP_BASE_URL || 'http://localhost:8901';
const MOTIFS = /provisoire|temporaire|à venir|exemples? de présentation|en cours d.intégration|en attente de|bient[oô]t|prochainement|démonstration|placeholder|lorem|à compléter|todo\b|top-entreprise|photo de stock|banque d.images|maquette|prototype|fictif|non contractuel\?|\[[^\]]{0,30}\]|portrait définitif|sera précisé|seront précisés|seront publiés/gi;
const propre = (t) => t.replace(/&#0?39;|&rsquo;|&#8217;/g, '’').replace(/&nbsp;|&#160;/g, ' ').replace(/&amp;/g, '&').replace(/\s+/g, ' ');

let total = 0;
for (const r of ROUTES) {
	const html = await (await fetch(BASE + r.url)).text();
	const corps = html.replace(/<script\b[\s\S]*?<\/script>/gi, ' ').replace(/<style\b[\s\S]*?<\/style>/gi, ' ').replace(/<!--[\s\S]*?-->/g, ' ');
	const trouves = new Set();
	// « SARL TOP-ENTREPRISE » est la raison sociale de l'éditeur (ligne légale) : ce n'est pas l'ancienne marque.
	const texte = propre(corps.replace(/<[^>]+>/g, ' ')).replace(/SARL TOP-ENTREPRISE/g, 'SARL [raison sociale]').replace(/\[raison sociale\]/g, 'éditrice');
	for (const m of texte.matchAll(MOTIFS)) trouves.add('texte : …' + texte.slice(Math.max(0, m.index - 50), m.index + m[0].length + 40).trim() + '…');
	for (const a of corps.matchAll(/\s(alt|title|aria-label|placeholder|content)=(?:"([^"]*)"|'([^']*)')/g)) {
		const v = propre(a[2] ?? a[3] ?? '');
		if (MOTIFS.test(v)) trouves.add(`${a[1]} : ${v}`);
		MOTIFS.lastIndex = 0;
	}
	if (trouves.size) {
		total += trouves.size;
		console.log(`\n${r.url}`);
		for (const t of trouves) console.log('  · ' + t.slice(0, 190));
	}
}
console.log(`\n${ROUTES.length} routes balayées · ${total} occurrence(s).`);
process.exit(total ? 1 : 0);
