#!/usr/bin/env node
/**
 * Audit des conclusions commerciales sur les 53 routes (revue du 25 octobre 2026, §4.1).
 * Compte, dans le HTML servi : les bandes de conclusion (bouton « Demander mon devis » sur fond
 * sombre), le bandeau global de pied de page, et la barre mobile. Échoue si une page en a deux.
 * Usage : TFP_BASE_URL=http://localhost:8901 node tools/audit-conclusions.mjs
 */
import { ROUTE_MAP } from './route-map.mjs';
const WP = process.env.TFP_BASE_URL || 'http://localhost:8901';
let fautes = 0;
const lignes = [];
for (const [hash, { wp: chemin }] of Object.entries(ROUTE_MAP)) {
	const html = await (await fetch(WP + chemin)).text();
	const finales = (html.match(/class="tfp-btn tfp-btn--on-primary"[^>]*href="[^"]*demande-de-devis/g) || []).length;
	const pageBand = (html.match(/tfp-prefooter__inner--page/g) || []).length;
	const global = (html.match(/<section class="tfp-prefooter">/g) || []).length;
	const barre = (html.match(/class="tfp-mobile-cta-bar[ "]/g) || []).length;
	const barreDevis = /tfp-mobile-cta-bar[\s\S]{0,900}demande-de-devis/.test(html);
	const conclusions = (finales ? 1 : 0) + pageBand + global;
	const ko = conclusions > 1;
	if (ko) fautes++;
	lignes.push(`${ko ? '✗' : '✓'} ${hash.padEnd(40)} finales:${finales} page:${pageBand} global:${global} barre:${barre}${barreDevis ? '+devis' : ''}`);
}
console.log(lignes.join('\n'));
console.log(`\n${fautes} page(s) à double conclusion`);
process.exit(fautes ? 1 : 0);
