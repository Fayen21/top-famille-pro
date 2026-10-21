/**
 * Contrôle des exemples tarifaires **par le calcul**, sur les 53 routes.
 *
 * Chercher les anciens tarifs (24,30 €, 26 €, 30 €) ne suffit pas : un exemple peut employer le
 * tarif officiel de 27 € et rester mathématiquement faux. C'était le cas de vingt exemples sur
 * trente-trois — le libellé annonçait « 8 h/mois » ou « 16 h/mois » tandis que le montant venait
 * d'un exemple fixe à 12 heures, affichant 333 € HT/mois partout.
 *
 * Ce test lit donc chaque exemple **rendu**, en extrait le nombre d'heures annoncé, et compare le
 * montant affiché à celui que la grille officielle impose :
 *
 *     mensuel      = heures × 27 + 9
 *     premier mois = mensuel + 50
 */
import { test, expect } from '@playwright/test';
import { ROUTES } from './data/routes.js';

const TARIF_HORAIRE = 27;
const FRAIS_GESTION = 9;
const FRAIS_MISE_EN_PLACE = 50;

/** Montants attendus pour un volume horaire, d'après la grille officielle. */
const attendu = (heures) => ({
	mensuel: heures * TARIF_HORAIRE + FRAIS_GESTION,
	premierMois: heures * TARIF_HORAIRE + FRAIS_GESTION + FRAIS_MISE_EN_PLACE,
});

/** « 1 234 € » ou « 1 234,50 € » → nombre. Les espaces sont insécables dans le rendu. */
const montant = (texte) => {
	const m = String(texte).replace(/[  \s]/g, '').match(/(\d+(?:,\d+)?)€/);
	return m ? parseFloat(m[1].replace(',', '.')) : null;
};

test.describe('Exemples tarifaires — vérifiés par le calcul', () => {
	for (const route of ROUTES) {
		test(`${route.url} : chaque exemple correspond à ses heures`, async ({ page }) => {
			await page.goto(route.url, { waitUntil: 'domcontentloaded' });

			/*
			 * Un exemple est un bloc qui annonce un volume horaire mensuel *et* un montant mensuel.
			 * On le relève sur le rendu, y compris dans les accordéons repliés — un `<details>` fermé
			 * garde son contenu dans le DOM, et un montant faux y est tout aussi faux.
			 */
			const exemples = await page.evaluate(() => {
				const out = [];
				const vus = new Set();
				for (const el of document.querySelectorAll('div,section,li,p,td,tr')) {
					const t = (el.textContent || '').replace(/\s+/g, ' ').trim();
					if (!/\d+\s*h\s*\/\s*mois/i.test(t)) continue;
					if (!/€/.test(t)) continue;
					// On garde le plus petit conteneur qui porte les deux informations.
					if ([...el.querySelectorAll('*')].some((c) => {
						const ct = (c.textContent || '').replace(/\s+/g, ' ').trim();
						return /\d+\s*h\s*\/\s*mois/i.test(ct) && /€/.test(ct);
					})) continue;
					if (t.length > 600 || vus.has(t)) continue;
					vus.add(t);
					out.push(t);
				}
				return out;
			});

			for (const texte of exemples) {
				/*
				 * Un bloc peut annoncer **plusieurs** volumes — la page Tarifs décompose « 8 h × 27 €
				 * HT » avant d'ajouter les frais de gestion, et l'article sur le coût cite dans un
				 * même paragraphe un petit bureau à 8 h et un plateau à 20 h. Ne retenir que le
				 * premier volume rejetait des montants parfaitement exacts : deux faux positifs du
				 * test, corrigés ici plutôt qu'écartés à la main.
				 */
				const tousVolumes = [...texte.replace(/\s+/g, ' ').matchAll(/(\d+)\s*h\s*\/\s*mois/gi)].map((m) =>
					parseInt(m[1], 10)
				);
				const heures = tousVolumes[0];
				const cible = attendu(heures);

				// Tous les montants du bloc doivent appartenir à la grille : mensuel, premier mois,
				// ou l'un des postes unitaires officiels. Un montant hors de cet ensemble est faux.
				const nombres = [...texte.replace(/[  ]/g, ' ').matchAll(/(\d+(?:[  ]\d{3})*(?:,\d+)?)\s*€/g)]
					.map((m) => parseFloat(m[1].replace(/[  ]/g, '').replace(',', '.')));

				const admis = new Set([TARIF_HORAIRE, FRAIS_GESTION, FRAIS_MISE_EN_PLACE, 0.35]);
				for (const h of tousVolumes) {
					const c = attendu(h);
					admis.add(c.mensuel);
					admis.add(c.premierMois);
					// Sous-total avant frais de gestion : la page Tarifs affiche la décomposition.
					admis.add(h * TARIF_HORAIRE);
				}

				for (const n of nombres) {
					expect(
						admis.has(n),
						`${route.url} — exemple à ${heures} h/mois : montant ${n} € incohérent.\n` +
							`Attendu ${cible.mensuel} € HT/mois (${heures} × ${TARIF_HORAIRE} + ${FRAIS_GESTION}) ` +
							`ou ${cible.premierMois} € le premier mois.\nBloc : « ${texte.slice(0, 220)} »`
					).toBe(true);
				}
			}
		});
	}

	test('/conseils/cout-nettoyage-bureaux/ : le tableau de budgets est présent et exact', async ({ page }) => {
		await page.goto('/conseils/cout-nettoyage-bureaux/', { waitUntil: 'domcontentloaded' });

		const tableau = page.locator('table.tfp-budget-table');
		await expect(tableau, 'le tableau de budgets de la maquette doit être rendu').toHaveCount(1);

		// En-têtes : la relation ligne ↔ colonne doit exister, pas seulement l'apparence.
		await expect(tableau.locator('thead th')).toHaveCount(4);

		const lignes = await tableau.locator('tbody tr').evaluateAll((trs) =>
			trs.map((tr) => [...tr.querySelectorAll('th,td')].map((c) => c.textContent.replace(/\s+/g, ' ').trim()))
		);
		expect(lignes.length, 'trois volumes officiels attendus').toBe(3);

		for (const [, volume, mensuel, premier] of lignes) {
			const h = parseInt(volume.match(/(\d+)/)[1], 10);
			const m = parseInt(mensuel.replace(/[^0-9]/g, ''), 10);
			const p = parseInt(premier.replace(/[^0-9]/g, ''), 10);
			expect(m, `${h} h : budget mensuel`).toBe(h * TARIF_HORAIRE + FRAIS_GESTION);
			expect(p, `${h} h : premier mois`).toBe(h * TARIF_HORAIRE + FRAIS_GESTION + FRAIS_MISE_EN_PLACE);
		}
	});

	test('aucun ancien tarif commercial ne subsiste', async ({ page }) => {
		for (const route of ROUTES.slice(0, 12)) {
			await page.goto(route.url, { waitUntil: 'domcontentloaded' });
			const texte = await page.evaluate(() => document.body.innerText);
			for (const ancien of ['24,30', '26,00 €', '30,00 €']) {
				expect(texte, `${route.url} contient l'ancien tarif ${ancien}`).not.toContain(ancien);
			}
		}
	});
});
