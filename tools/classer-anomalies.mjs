#!/usr/bin/env node
/**
 * Classement **exhaustif** des anomalies « carte supplémentaire » et « mauvais nombre de
 * colonnes » relevées par tools/inventaire-cartes.mjs.
 *
 * Le rapport d'inventaire tronque son détail par route : utile à lire, inexploitable pour dire de
 * chaque anomalie si elle est réelle ou si l'outil se trompe. Ce fichier-ci n'en omet aucune.
 *
 * Chaque occurrence est rattachée à une **cause**, et chaque cause porte quatre informations qui
 * ne se déduisent pas l'une de l'autre :
 *   — ce que montre la maquette, mesuré, et ce que rend WordPress ;
 *   — le verdict : écart réel du thème, ou faux positif de l'outil ;
 *   — la correction appliquée, ou la raison pour laquelle il n'y en a pas ;
 *   — le test qui empêche la régression, quand il en existe un.
 *
 * Une cause dont l'origine n'a pas été établie par la mesure est écrite comme telle. Un classement
 * qui affirmerait une cause plausible sans l'avoir vérifiée vaudrait moins que pas de classement.
 *
 * Usage : node tools/classer-anomalies.mjs   → écrit docs/ANOMALIES-SURPLUS-COLONNES.md
 */
import { readFileSync, writeFileSync } from 'node:fs';

const SOURCE = 'docs/inventaire-cartes.json';
const SORTIE = 'docs/ANOMALIES-SURPLUS-COLONNES.md';

/**
 * Causes, dans l'ordre où elles sont éprouvées. `test` reçoit l'anomalie et la route ; la première
 * cause qui répond vrai emporte l'occurrence. La dernière est un filet : toute anomalie non
 * rattachée y tombe et apparaît nommément dans le rapport, jamais silencieusement.
 */
const CAUSES = [
	{
		id: 'pastilles-retour-ligne',
		titre: 'Rangée de pastilles coupée à un rang près',
		verdict: 'Faux positif résiduel de l’outil',
		test: (a) => a.genre === 'colonnes' && a.type === 'chip' && Math.abs((a.attendu || 0) - (a.recu || 0)) <= 1,
		maquette:
			'Les pastilles de communes sont posées dans une rangée qui revient à la ligne. Leur ' +
			'géométrie est désormais identique des deux côtés : 79 × 41 px, texte 14 px semi-gras, ' +
			'rembourrage 8/15, rayon plein.',
		wordpress:
			'Même rangée, même nombre de pastilles, même géométrie — mais le retour à la ligne tombe ' +
			'une pastille plus tôt ou plus tard selon la longueur du nom de commune, qui n’est pas ' +
			'la même d’une page à l’autre.',
		correction:
			'Aucune. Le point de retour d’une rangée en ligne n’est pas une propriété de mise en ' +
			'page : c’est une conséquence de la largeur du texte. Forcer un nombre de colonnes ' +
			'reviendrait à figer une grille là où la maquette n’en a pas, et casserait le rendu ' +
			'sur les largeurs intermédiaires.',
		regression: 'La taille des pastilles est verrouillée par la mesure (79 × 41 px à 1440 px).',
	},
	{
		id: 'pastilles-ecart-franc',
		titre: 'Rangée de pastilles coupée à deux rangs ou plus',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'colonnes' && a.type === 'chip',
		maquette: 'Rangée de pastilles sur n colonnes.',
		wordpress: 'Rangée rendue sur au moins deux colonnes d’écart.',
		correction:
			'Aucune à ce stade. Un écart de deux rangs ne s’explique plus par la seule largeur du ' +
			'texte : il suppose un conteneur de largeur différente. Chaque occurrence est listée ' +
			'ci-dessous pour être reprise une par une.',
		regression: '—',
	},
	{
		id: 'colonnes-tarif-prestation',
		titre: 'Carte d’exemple tarifaire d’une page prestation',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'colonnes' && (a.type === 'tarif' || a.type === 'temoignage'),
		maquette: 'La carte partage sa rangée avec n voisines.',
		wordpress: 'Elle en partage un autre nombre.',
		correction:
			'La bande tarifaire des pages de zone a été remise à trois colonnes (texte 394, exemple ' +
			'344, témoignage 374, écart 34, mesurés à 1440 px) et ses trois colonnes partagent ' +
			'désormais la même ligne. Les occurrences qui subsistent portent sur les pages ' +
			'prestation et la page tarifs, dont la bande n’a pas encore été mesurée.',
		regression: '—',
	},
	{
		id: 'colonnes-autres',
		titre: 'Autres écarts de colonnes',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'colonnes',
		maquette: '—',
		wordpress: '—',
		correction: 'Aucune. Occurrences listées nommément.',
		regression: '—',
	},
	{
		id: 'surplus-badge-google',
		titre: 'Badge de note Google rendu en plusieurs éléments',
		verdict: 'Écart réel, mineur',
		test: (a) => a.genre === 'surplus' && /5,0\/5|sur Google|★★★★★/.test(a.texte || ''),
		maquette: 'Le badge « ★★★★★ 5,0/5 sur Google » est un seul bloc.',
		wordpress:
			'Le thème le compose de plusieurs éléments porteurs de fond ou de rayon, dont l’un est ' +
			'relevé comme une carte de plus.',
		correction:
			'Aucune à ce stade : le badge est visuellement conforme, et le découper autrement ' +
			'toucherait un composant présent sur 38 routes pour un gain nul à l’écran.',
		regression: 'La note affichée reste celle des réglages, jamais une valeur écrite en dur.',
	},
	{
		id: 'surplus-cta-local',
		titre: 'Bouton d’appel à l’action contextuel',
		verdict: 'Écart voulu (CLAUDE.md §8)',
		test: (a) => a.genre === 'surplus' && /Demander un devis|Demander mon devis|Échanger avec|Appeler/i.test(a.texte || ''),
		maquette: 'Le prototype n’a pas toujours de bouton contextualisé à cet endroit.',
		wordpress:
			'Le thème ajoute le CTA contextuel imposé par le cahier des charges : « Demander un ' +
			'devis à {ville} », avec sa réassurance.',
		correction: 'Aucune : cet ajout est une exigence du projet, pas une dérive.',
		regression: 'Couvert par la suite de conversion.',
	},
	{
		id: 'surplus-mention-provisoire',
		titre: 'Mention de transparence sur un contenu provisoire',
		verdict: 'Écart voulu (CLAUDE.md §5.5)',
		test: (a) => a.genre === 'surplus' && /démonstration|provisoire|Exemples de présentation|indicatifs/i.test(a.texte || ''),
		maquette: 'Le prototype affiche ses témoignages sans rien signaler.',
		wordpress:
			'Chaque contenu provisoire porte une mention visible. C’est une carte de plus à l’écran, ' +
			'et c’est le prix de l’honnêteté du site.',
		correction: 'Aucune.',
		regression: 'tests/provisoire.spec.js — mention visible exigée sur les 53 routes.',
	},
	{
		id: 'surplus-lien-ville',
		titre: 'Lien de ville rendu en carte',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'surplus' && /^[A-ZÀ-Ý][^0-9]{2,28}\s?\d{4,5}$/.test((a.texte || '').trim()),
		maquette:
			'La maquette porte bien ces liens (« Dijon 21000 », « Besançon 25000 »… sur la page ' +
			'région), mais le relevé ne les compte pas pour des cartes de ce côté.',
		wordpress: 'Le thème les rend comme des cartes à part entière, comptées une à une.',
		correction:
			'Aucune tant que la géométrie des deux côtés n’a pas été mesurée : soit le thème encadre ' +
			'des liens que la maquette laisse nus — et il faut l’aligner — soit les deux rendus se ' +
			'ressemblent et c’est le seuil de détection de l’outil qui tranche différemment. ' +
			'Les deux hypothèses se départagent par la mesure, pas par le raisonnement.',
		regression: '—',
	},
	{
		id: 'surplus-item-liste',
		titre: 'Élément de liste rendu en micro-carte',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'surplus' && a.type === 'micro-carte',
		maquette: 'Les listes d’erreurs fréquentes et de points de vigilance des articles.',
		wordpress: 'Le thème les rend en micro-cartes, comptées une à une.',
		correction: 'Aucune à ce stade. Occurrences listées nommément.',
		regression: '—',
	},
	{
		id: 'surplus-bloc-contenu',
		titre: 'Bloc de contenu d’une page statique ou d’un article',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'surplus' && (a.type === 'carte-titre-texte' || a.type === 'carte-sombre' || a.type === 'tarif'),
		maquette: '—',
		wordpress: '—',
		correction: 'Aucune à ce stade. Occurrences listées nommément.',
		regression: '—',
	},
	{
		id: 'surplus-autres',
		titre: 'Autres cartes supplémentaires',
		verdict: 'À instruire — cause non tranchée',
		test: (a) => a.genre === 'surplus',
		maquette: '—',
		wordpress: '—',
		correction: 'Aucune. Occurrences listées nommément.',
		regression: '—',
	},
];

const donnees = JSON.parse(readFileSync(SOURCE, 'utf8'));

const occurrences = [];
for (const [route, parLargeur] of Object.entries(donnees)) {
	for (const [largeur, bilan] of Object.entries(parLargeur)) {
		for (const a of bilan.anomalies) {
			if (a.genre !== 'surplus' && a.genre !== 'colonnes') continue;
			const cause = CAUSES.find((c) => c.test(a, route)) || CAUSES[CAUSES.length - 1];
			occurrences.push({ route, largeur: Number(largeur), cause: cause.id, ...a });
		}
	}
}

const L = [];
L.push('# Anomalies « carte supplémentaire » et « colonnes » — classement exhaustif');
L.push('');
L.push('> Fichier **généré** par `node tools/classer-anomalies.mjs` depuis `docs/inventaire-cartes.json`.');
L.push('> Ne pas éditer à la main.');
L.push('>');
L.push('> Toutes les occurrences relevées sur les 53 routes, aux deux largeurs, y figurent : aucune');
L.push('> n’est agrégée ni tronquée. Une cause dont l’origine n’a pas été établie par la mesure est');
L.push('> écrite « à instruire » — affirmer une cause plausible sans l’avoir vérifiée vaudrait moins');
L.push('> que ne rien affirmer.');
L.push('');
L.push(`**${occurrences.length} occurrences** — ${occurrences.filter((o) => o.genre === 'surplus').length} cartes supplémentaires, ${occurrences.filter((o) => o.genre === 'colonnes').length} écarts de colonnes.`);
L.push('');

L.push('## Synthèse par cause');
L.push('');
L.push('| Cause | Occurrences | Verdict |');
L.push('|---|---:|---|');
for (const c of CAUSES) {
	const n = occurrences.filter((o) => o.cause === c.id).length;
	if (!n) continue;
	L.push(`| ${c.titre} | ${n} | ${c.verdict} |`);
}
L.push('');

for (const c of CAUSES) {
	const liste = occurrences.filter((o) => o.cause === c.id);
	if (!liste.length) continue;
	L.push(`## ${c.titre}`);
	L.push('');
	L.push(`**Verdict :** ${c.verdict} · **${liste.length} occurrence(s)**`);
	L.push('');
	L.push(`- **Maquette** — ${c.maquette}`);
	L.push(`- **WordPress** — ${c.wordpress}`);
	L.push(`- **Correction** — ${c.correction}`);
	L.push(`- **Non-régression** — ${c.regression}`);
	L.push('');
	L.push('| Route | Largeur | Bande | Archétype | Attendu → rendu | Contenu |');
	L.push('|---|---:|---:|---|---|---|');
	for (const o of liste) {
		const colonnes = o.genre === 'colonnes' ? `${o.attendu} → ${o.recu}` : '—';
		L.push(
			`| \`${o.route}\` | ${o.largeur} | ${o.bande ?? '—'} | \`${o.type}\` | ${colonnes} | ` +
				`${(o.texte || '—').replace(/\|/g, '/').slice(0, 60)} |`
		);
	}
	L.push('');
}

writeFileSync(SORTIE, L.join('\n') + '\n');
console.log(`Écrit : ${SORTIE} — ${occurrences.length} occurrences classées en ${new Set(occurrences.map((o) => o.cause)).size} causes`);
for (const c of CAUSES) {
	const n = occurrences.filter((o) => o.cause === c.id).length;
	if (n) console.log(`  ${String(n).padStart(4)}  ${c.titre} — ${c.verdict}`);
}
