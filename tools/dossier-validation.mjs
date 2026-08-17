#!/usr/bin/env node
/**
 * Dossier de validation humaine — G25 phase D.
 *
 * Construit, à partir des triptyques déjà régénérés de docs/captures/comparaison/ :
 *  1. docs/captures/validation-prioritaire/ — la sélection des pages à relire en premier,
 *     copiée telle quelle (375 et 1440 px) ;
 *  2. docs/captures/VALIDATION-G25.html — un index HORS LIGNE : miniatures cliquables,
 *     route, largeur, statut proposé et écart volontaire éventuel, sélection prioritaire en tête.
 *
 * Il ne prend AUCUNE décision : le statut proposé est « À VALIDER » partout, et les écarts
 * volontaires affichés sont ceux du classement (différences éditoriales et légales documentées).
 *
 * Usage : node tools/dossier-validation.mjs
 */
import { copyFileSync, existsSync, mkdirSync, readdirSync, writeFileSync } from 'node:fs';

const SRC = 'docs/captures/comparaison';
const PRIO_DIR = 'docs/captures/validation-prioritaire';
const OUT = 'docs/captures/VALIDATION-G26.html';

/** Sélection prioritaire : une page par famille + les deux étapes du formulaire + le pilier. */
const PRIORITAIRES = [
	{ slug: 'accueil', libelle: 'Accueil', ecart: 'G26 : la note Google n’est plus affichée (non vérifiée) ; vignette d’auteur ajoutée au témoignage ; photos des deux cartes de prestation corrigées.' },
	{ slug: 'nettoyage-professionnel', libelle: 'Page pilier', ecart: 'Six vignettes de G25 conservées ; G26 y ajoute le visuel manquant de la bande « Cahier des charges, intervenants et suivi » et corrige la taille des intertitres.' },
	{ slug: 'service-bureaux', libelle: 'Prestation (bureaux)', ecart: 'G26 : le visuel de hero était CROISÉ avec celui d’une page de ville — corrigé sur les octets.' },
	{ slug: 'ville-dijon', libelle: 'Ville (Dijon)', ecart: '' },
	{ slug: 'nos-tarifs', libelle: 'Tarifs', ecart: 'Témoignage nu et centré comme la maquette ; la note Google n’y figure plus tant qu’elle n’est pas vérifiable (G26 §7).' },
	{ slug: 'formulaire-etape-1', libelle: 'Formulaire — étape 1', ecart: 'Capture faite avec les MÊMES données des deux côtés (protocole G26 §6). Les différences de champs restantes sont listées dans docs/FORMULAIRE-DIFFERENCES.md — ce dossier n’affirme pas « mêmes champs ».' },
	{ slug: 'formulaire-etape-2', libelle: 'Formulaire — étape 2', ecart: 'Étape 2 vérifiée atteinte des deux côtés avant capture ; valeurs relevées champ par champ dans docs/FORMULAIRE-CAPTURES.md.' },
	{ slug: 'article-frequence-bureaux', libelle: 'Article (fréquence bureaux)', ecart: '' },
	{ slug: 'mentions-legales', libelle: 'Mentions légales', ecart: 'Contenu réglementaire plus complet que la maquette — hors tolérance de hauteur ASSUMÉ (exception prévue).' },
	{ slug: 'a-propos', libelle: 'À propos', ecart: 'G26 §4 : image à gauche sur ordinateur et avant le texte sur mobile, citation dans sa bande, quatre valeurs sans mention de provisoire erronée, commandes en rangées de boutons. Portrait toujours signalé comme illustration (§5.6).' },
	{ slug: 'recrutement', libelle: 'Recrutement', ecart: 'G26 §5 : le hero porte le parcours de candidature et non les appels commerciaux ; panneau des étapes en marine ; candidature vers le site carrière (CLAUDE.md §8).' },
	{ slug: 'pilier-bande-vignettes', libelle: 'Zoom — bande des six vignettes du pilier', ecart: 'Comparaison rapprochée de la bande ajoutée en G25, régénérée avec le panneau de différence réparé en G26 §2.' },
];
const LARGEURS = [ '375', '1440' ];

mkdirSync(PRIO_DIR, { recursive: true });

const tous = readdirSync(SRC).filter((f) => f.endsWith('.jpg')).sort();
const prioFichiers = [];
for (const p of PRIORITAIRES) {
	for (const l of LARGEURS) {
		const f = `${p.slug}-${l}.jpg`;
		if (existsSync(`${SRC}/${f}`)) {
			copyFileSync(`${SRC}/${f}`, `${PRIO_DIR}/${f}`);
			prioFichiers.push({ ...p, largeur: l, fichier: f });
		}
	}
}

const carte = (x, relSrc) => `
<figure>
	<a href="${relSrc}/${x.fichier}" target="_blank"><img loading="lazy" src="${relSrc}/${x.fichier}" alt=""></a>
	<figcaption>
		<strong>${x.libelle || x.fichier.replace(/-(375|1440)\.jpg$/, '')}</strong> · ${x.largeur} px<br>
		<span class="legende">gauche : maquette Claude Design · milieu : WordPress · droite : différence (zones sombres = écarts)</span><br>
		${x.ecart ? `<span class="ecart">Écart volontaire : ${x.ecart}</span><br>` : ''}
		<span class="statut">Statut proposé : À VALIDER</span>
	</figcaption>
</figure>`;

const autres = tous
	.filter((f) => !prioFichiers.some((p) => p.fichier === f))
	.map((f) => ({ fichier: f, largeur: (f.match(/-(\d+)\.jpg$/) || [])[1] || '', libelle: '', ecart: '' }));

const html = `<!doctype html>
<html lang="fr"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Validation G25 — Top-Famille Pro</title>
<style>
 body{font-family:system-ui,sans-serif;margin:24px;max-width:1200px;background:#fafcfc;color:#18232d}
 h1{font-size:26px} h2{font-size:20px;margin-top:36px;border-top:2px solid #93dadb;padding-top:18px}
 .grille{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:18px;margin-top:16px}
 figure{margin:0;background:#fff;border:1px solid #dce7eb;border-radius:10px;padding:10px}
 img{width:100%;height:auto;border-radius:6px;border:1px solid #e4edf0}
 figcaption{font-size:13px;margin-top:8px;line-height:1.5}
 .legende{color:#58717f}
 .ecart{color:#a8622e}
 .statut{font-weight:700;color:#174a81}
 .note{background:#ddf4f3;border:1px solid #b8e4e4;border-radius:10px;padding:14px 16px;font-size:14.5px;line-height:1.6}
 details{margin-top:14px}
 summary{cursor:pointer;font-weight:600}
</style></head><body>
<h1>Validation humaine — passe G25</h1>
<p class="note">Chaque image montre, de gauche à droite : la <strong>maquette Claude Design</strong>,
le <strong>rendu WordPress</strong>, et leur <strong>différence</strong> (les zones sombres sont les
écarts). Commencer par la sélection prioritaire ci-dessous — la revue tient en quelques minutes.
La fiche de décision associée est <a href="VALIDATION-HUMAINE-G26.md">VALIDATION-HUMAINE-G26.md</a>, livrée à côté de cette page.
Rien n'est validé d'office : le statut de chaque page est « À VALIDER » tant que vous ne l'avez pas
tranché.</p>

<h2>1. Sélection prioritaire (${prioFichiers.length} comparaisons)</h2>
<div class="grille">
${prioFichiers.map((x) => carte(x, 'validation-prioritaire')).join('\n')}
</div>

<h2>2. Toutes les autres comparaisons (${autres.length})</h2>
<details><summary>Déplier les ${autres.length} triptyques restants</summary>
<div class="grille">
${autres.map((x) => carte(x, 'comparaison')).join('\n')}
</div>
</details>
</body></html>
`;
writeFileSync(OUT, html);
console.log(`écrit : ${OUT} — ${prioFichiers.length} prioritaires + ${autres.length} autres · ${PRIO_DIR}/ rempli`);
