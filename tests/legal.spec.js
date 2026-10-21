// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Informations juridiques confirmées en phase 7 (extrait Pappers + complément client) —
 * CLAUDE.md §5.1/§5.7 : vérifie que les valeurs réelles sont publiées et qu'aucun champ
 * confirmé ne reste marqué comme manquant ([À COMPLÉTER]), sans jamais coder les valeurs en dur
 * dans ce fichier (elles viennent de la page rendue, comparées à des motifs, pas recopiées).
 */

const CONFIRMED_PATTERNS = {
	SIREN: /938\s?472\s?420/,
	SIRET: /938\s?472\s?420\s?00018/,
	APE: /81\.21Z/,
	TVA: /FR\s?32\s?938\s?472\s?420/i,
	capital: /600(?:,00)?\s?€/,
};

// Vérifiés séparément (présence des deux termes, sans exiger un ordre ou une adjacence précise
// dans la phrase — la formulation exacte reste au gabarit, pas à ce test).
const RCS_TERMS = [/RCS/, /Dijon/];

test.describe('Informations juridiques — mentions légales', () => {
	/*
	 * CLÉS DE CONTRÔLE des identifiants publiés — ajouté le 17 août 2026, quand Emmanuel a acté le
	 * Kbis et levé le bloqueur.
	 *
	 * Les tests voisins vérifient que les numéros sont AFFICHÉS. Aucun ne vérifiait qu'ils sont
	 * VALIDES. Or un SIRET faux se publie exactement comme un vrai : rien à l'écran ne le signale,
	 * et c'est une mention légale erronée au sens de la LCEN. Une transposition de deux chiffres
	 * lors d'une saisie suffirait, et aucune relecture humaine ne l'attraperait de façon fiable.
	 *
	 * Ces trois contrôles sont de l'arithmétique pure, sans réseau ni service tiers :
	 *
	 *  1. clé de Luhn du SIREN (9 chiffres) ;
	 *  2. clé de Luhn du SIRET (14 chiffres) ;
	 *  3. concordance de la clé de TVA intracommunautaire avec le SIREN — (12 + 3 × (SIREN mod 97))
	 *     mod 97 — qui lie les deux identifiants l'un à l'autre.
	 *
	 * La règle de Luhn se dit « un chiffre sur deux EN PARTANT DE LA DROITE, à commencer par
	 * l'avant-dernier ». Sur un SIREN, de longueur impaire, cela tombe sur les rangs pairs depuis la
	 * gauche ; sur un SIRET, de longueur paire, sur les rangs impairs. Appliquer la règle du SIREN à
	 * un SIRET recale des numéros parfaitement valides — vérifié en écrivant ce test.
	 *
	 * Ils ne prouvent pas que les numéros sont ceux de l'entreprise : c'est le Kbis qui l'établit,
	 * et Emmanuel l'a acté. Ils prouvent qu'ils sont bien formés et mutuellement cohérents.
	 */
	const luhn = ( numero ) => {
		let somme = 0;
		for ( let i = numero.length - 1, rang = 0; i >= 0; i--, rang++ ) {
			let chiffre = Number( numero[ i ] );
			if ( rang % 2 === 1 ) {
				chiffre *= 2;
				if ( chiffre > 9 ) chiffre -= 9;
			}
			somme += chiffre;
		}
		return somme % 10 === 0;
	};

	test( 'les identifiants publiés ont des clés de contrôle valides', async ( { page } ) => {
		await page.goto( '/mentions-legales/' );
		const texte = ( await page.locator( 'main' ).innerText() ).replace( /\s+/g, ' ' );

		const siret = ( texte.match( /\b(\d{3}\s?\d{3}\s?\d{3}\s?\d{5})\b/ ) || [] )[ 1 ];
		expect( siret, 'aucun SIRET trouvé sur la page' ).toBeTruthy();
		const siretNu = siret.replace( /\s/g, '' );
		expect( luhn( siretNu ), `SIRET ${ siret } : clé de Luhn invalide` ).toBe( true );

		const sirenNu = siretNu.slice( 0, 9 );
		expect( luhn( sirenNu ), `SIREN ${ sirenNu } : clé de Luhn invalide` ).toBe( true );

		const tva = ( texte.match( /FR\s?(\d{2})\s?(\d{3}\s?\d{3}\s?\d{3})/i ) || [] );
		expect( tva[ 1 ], 'aucun numéro de TVA trouvé sur la page' ).toBeTruthy();
		expect( tva[ 2 ].replace( /\s/g, '' ), 'la TVA ne porte pas le SIREN publié' ).toBe( sirenNu );
		const cleAttendue = String( ( 12 + 3 * ( Number( sirenNu ) % 97 ) ) % 97 ).padStart( 2, '0' );
		expect( tva[ 1 ], `clé TVA ${ tva[ 1 ] } incohérente avec le SIREN ${ sirenNu }` ).toBe( cleAttendue );
	} );

	test('les données d\'immatriculation confirmées sont publiées', async ({ page }) => {
		await page.goto('/mentions-legales/');
		const text = await page.locator('body').innerText();
		for (const [label, pattern] of Object.entries(CONFIRMED_PATTERNS)) {
			expect(text, `${label} doit apparaître dans les mentions légales`).toMatch(pattern);
		}
		for (const pattern of RCS_TERMS) {
			expect(text, `${pattern} doit apparaître (mention du RCS)`).toMatch(pattern);
		}
	});

	test('SIRET, code APE et TVA ne sont plus marqués manquants', async ({ page }) => {
		await page.goto('/mentions-legales/');
		const text = await page.locator('body').innerText();
		expect(text).not.toMatch(/SIRET[^\n]*\[À COMPLÉTER\]/i);
		expect(text).not.toMatch(/APE[^\n]*\[À COMPLÉTER\]/i);
		expect(text).not.toMatch(/TVA[^\n]*\[À COMPLÉTER\]/i);
	});

	test('aucune information personnelle inutile (date de naissance) n\'est publiée', async ({ page }) => {
		await page.goto('/mentions-legales/');
		const text = await page.locator('body').innerText();
		expect(text).not.toMatch(/née?\s+le|date\s+de\s+naissance/i);
		// Le nom de naissance de la gérante (confirmé par Pappers) reste interne : seul le nom
		// d'usage, déjà utilisé partout sur le site, est public.
		expect(text).not.toContain('MICHELIN');
	});

	test('hébergeur, directrice de la publication : plus aucun placeholder (9 août 2026)', async ({ page }) => {
		await page.goto('/mentions-legales/');
		const text = await page.locator('body').innerText();
		// Confirmé le 9 août 2026 : coordonnées complètes de l'hébergeur et directrice de la
		// publication. Décision du 10 août : plus aucun placeholder visible sur le site.
		expect(text).not.toContain('[À COMPLÉTER]');
		// La médiation de la consommation ne concerne que les litiges avec des consommateurs
		// (code de la consommation, art. L612-1). Top-Famille Pro vend à des professionnels : la
		// rubrique est retirée plutôt qu'affichée vide ou remplie d'un médiateur inventé.
		expect(text, 'la médiation de la consommation ne s’applique pas en B2B').not.toMatch(/médiation de la consommation/i);
		expect(text).toMatch(/HOSTINGER INTERNATIONAL LIMITED/);
		expect(text).toMatch(/Larnaca/);
		expect(text).toMatch(/compliance@hostinger\.com/);
		expect(text).toMatch(/Directrice de la publication\s*:\s*Audrey Brançon/);
	});

	test('la section « Assurance professionnelle » est retirée (sur instruction explicite)', async ({ page }) => {
		await page.goto('/mentions-legales/');
		const text = await page.locator('body').innerText();
		expect(text).not.toMatch(/Assurance professionnelle/i);
		expect(text).not.toMatch(/numéro de police/i);
	});
});

test.describe('Informations juridiques — pied de page', () => {
	test('raison sociale, forme juridique, capital, SIRET et lien mentions légales', async ({ page }) => {
		await page.goto('/');
		const footerText = await page.locator('footer').innerText();
		expect(footerText).toMatch(/SARL TOP-ENTREPRISE/);
		expect(footerText).toMatch(CONFIRMED_PATTERNS.capital);
		expect(footerText).toMatch(CONFIRMED_PATTERNS.SIRET);
		await expect(page.locator('footer a[href*="mentions-legales"]')).toHaveCount(1);
	});

	test('le pied de page reste concis (pas de RCS/APE/TVA détaillés hors mentions légales)', async ({ page }) => {
		await page.goto('/');
		const footerText = await page.locator('footer').innerText();
		expect(footerText).not.toMatch(CONFIRMED_PATTERNS.APE);
		expect(footerText).not.toMatch(CONFIRMED_PATTERNS.TVA);
	});
});

test.describe('Informations juridiques — données structurées', () => {
	test('Organization JSON-LD porte taxID/vatID/foundingDate, pas de code APE', async ({ page }) => {
		await page.goto('/');
		const scripts = await page.locator('script[type="application/ld+json"]').allTextContents();
		const graphs = scripts.map((raw) => JSON.parse(raw));
		const org = graphs
			.flatMap((g) => (Array.isArray(g['@graph']) ? g['@graph'] : [g]))
			.find((node) => {
				const types = Array.isArray(node['@type']) ? node['@type'] : [node['@type']];
				return types.includes('Organization');
			});
		expect(org, 'un nœud Organization doit exister dans le graphe').toBeTruthy();
		expect(org.taxID.replace(/\s/g, '')).toBe('93847242000018');
		expect(org.vatID).toBe('FR32938472420');
		expect(org.foundingDate).toBe('2024-12-16');
		// Pas de propriété schema.org standard pour un code APE : ne doit pas être forcé dans le
		// graphe (CLAUDE.md — n'ajouter des données structurées que lorsque le champ est approprié).
		expect(JSON.stringify(org)).not.toMatch(/81\.21Z/);
	});
});

/**
 * Contrôle transverse : aucun placeholder ne doit rester visible, sur aucune page du site.
 * Un `[À COMPLÉTER]` publié est au mieux un aveu d'inachèvement, au pire une information légale
 * manquante affichée au visiteur.
 */
test.describe('Aucun placeholder visible sur le site', () => {
	for (const url of ['/', '/tarifs/', '/mentions-legales/', '/politique-de-confidentialite/', '/gestion-des-cookies/', '/prestations/bureaux/', '/zones-intervention/cote-dor/dijon/', '/conseils/frequence-bureaux/']) {
		test(`aucun [À COMPLÉTER] sur ${url}`, async ({ page }) => {
			await page.goto(url);
			const text = await page.locator('body').innerText();
			expect(text).not.toContain('[À COMPLÉTER]');
			expect(text).not.toContain('À COMPLETER');
		});
	}
});
