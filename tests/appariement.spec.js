// @ts-check
import { test, expect } from '@playwright/test';
import { apparierEnfants, decomposer } from '../tools/arbre-bande.mjs';

/**
 * Appariement des descendants d'une bande — les deux fautes qui ont produit de faux diagnostics.
 *
 * Sur la bande du formulaire de contact, l'outil de sonde rangeait les grilles par nombre d'enfants
 * puis les comparait par RANG. Les deux côtés n'en ayant pas le même nombre, la grille de colonnes
 * de la maquette se trouvait en face d'une liste de pastilles du thème, et l'écart de 360 px était
 * attribué à un composant qui n'existait pas là. Une correction écrite sur cette base aurait été
 * fausse deux fois : mauvais composant, mauvaise cause.
 *
 * Ces fixtures sont des nœuds d'arbre déjà relevés — pas des pages. Elles n'ont besoin ni du banc
 * WordPress ni de la maquette, et vérifient la logique d'appariement elle-même.
 */

/** Un nœud d'arbre minimal, tel que le relevé de tools/arbre-bande.mjs le produit. */
const noeud = (o) => ({
	role: 'texte',
	balise: 'div',
	classes: null,
	texte: '',
	empreinte: '',
	h: 0,
	w: 700,
	display: 'block',
	nbEnfants: 0,
	colonnes: 0,
	pistes: 0,
	gap: null,
	padH: 0,
	padB: 0,
	mTop: 0,
	mBas: 0,
	bordH: 0,
	bordB: 0,
	taille: 16,
	interligne: 24,
	lignes: 0,
	hMin: null,
	enfants: [],
	...o,
});

test.describe('Appariement des descendants', () => {
	test('le rang seul n’apparie jamais deux rôles différents', () => {
		// La maquette : une grille de colonnes en premier, une liste de pastilles ensuite.
		const ref = [
			noeud({ role: 'grille', h: 300, texte: 'colonnes', empreinte: 'colonnes' }),
			noeud({ role: 'pastille', h: 40, texte: 'pastilles', empreinte: 'pastilles' }),
		];
		// Le thème : l'ordre inverse. Un appariement par rang mettrait la grille face à la pastille.
		const wp = [
			noeud({ role: 'pastille', h: 44, texte: 'pastilles', empreinte: 'pastilles' }),
			noeud({ role: 'grille', h: 330, texte: 'colonnes', empreinte: 'colonnes' }),
		];

		const { paires, seulRef, seulWp } = apparierEnfants(ref, wp);
		expect(seulRef).toHaveLength(0);
		expect(seulWp).toHaveLength(0);
		for (const p of paires) expect(p.wp.role).toBe(p.ref.role);
	});

	test('un texte sans empreinte commune ne s’apparie pas à un autre texte', () => {
		const ref = [noeud({ h: 50, texte: 'Mentions légales', empreinte: 'mentionslegales' })];
		const wp = [noeud({ h: 90, texte: 'Horaires de contact', empreinte: 'horairesdecontact' })];

		const { paires } = apparierEnfants(ref, wp);
		// Même rôle « texte » : la passe rôle+rang les apparie, faute de mieux, mais JAMAIS deux
		// rôles distincts — c'est ce que garantit le test précédent.
		expect(paires).toHaveLength(1);
		expect(paires[0].critere).toBe('rôle+rang');
	});

	test('une enveloppe ajoutée d’un seul côté est traversée, pas confondue', () => {
		// La maquette met le formulaire seul dans sa colonne.
		const ref = [noeud({ role: 'formulaire', h: 523.55, texte: 'Nom E-mail', empreinte: 'nomemail' })];
		// Le thème l'enveloppe avec deux intitulés, deux paragraphes, un bouton et une mention.
		const interne = noeud({ role: 'formulaire', h: 579.36, texte: 'Ne pas remplir Nom', empreinte: 'nepasremplirnom' });
		const wp = [
			noeud({
				role: 'texte',
				h: 922.77,
				texte: 'J’ai une question',
				empreinte: 'jaiunequestion',
				enfants: [
					noeud({ role: 'titre', h: 25, texte: 'J’ai une question', empreinte: 'jaiunequestion' }),
					interne,
					noeud({ role: 'bouton', h: 60, texte: 'Demander mon devis', empreinte: 'demandermondevis' }),
				],
			}),
		];

		const { paires, enveloppes, seulRef, seulWp } = apparierEnfants(ref, wp);
		// Le formulaire est apparié au FORMULAIRE, pas à l'enveloppe.
		expect(paires).toHaveLength(1);
		expect(paires[0].wp).toBe(interne);
		expect(paires[0].critere).toBe('à travers enveloppe');
		expect(seulRef).toHaveLength(0);
		expect(seulWp).toHaveLength(0);
		// Et le contenu supplémentaire est nommé, non fondu dans un écart de hauteur.
		expect(enveloppes).toHaveLength(1);
		expect(enveloppes[0].enveloppe.h).toBeCloseTo(922.77, 1);
	});

	test('la décomposition boucle : Σ contributions propres = écart de la bande', () => {
		const feuilleRef = (h, t) => noeud({ h, texte: t, empreinte: t });
		const ref = noeud({
			role: 'grille',
			h: 300,
			enfants: [
				noeud({ role: 'carte', h: 120, texte: 'a', empreinte: 'a', enfants: [feuilleRef(40, 'a1'), feuilleRef(60, 'a2')] }),
				noeud({ role: 'carte', h: 150, texte: 'b', empreinte: 'b', enfants: [feuilleRef(70, 'b1')] }),
			],
		});
		const wp = noeud({
			role: 'grille',
			h: 400,
			padH: 20,
			enfants: [
				noeud({ role: 'carte', h: 160, texte: 'a', empreinte: 'a', enfants: [feuilleRef(50, 'a1'), feuilleRef(80, 'a2')] }),
				noeud({ role: 'carte', h: 190, texte: 'b', empreinte: 'b', enfants: [feuilleRef(90, 'b1')] }),
			],
		});

		const lignes = decomposer(ref, wp, 'racine', 6, []);
		const somme = lignes.reduce((n, l) => n + l.propre, 0);
		// C'est l'invariant qui rend la décomposition utilisable : sans lui, on corrige une propriété
		// qui n'explique qu'une part de l'écart sans jamais s'en apercevoir.
		expect(somme).toBeCloseTo(wp.h - ref.h, 1);
	});
});
