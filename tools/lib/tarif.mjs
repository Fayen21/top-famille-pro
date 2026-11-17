/**
 * Tarif horaire des contenus relevés sur la maquette — décision d'Emmanuel du 17 novembre 2026 :
 * 26 € HT/h au lieu de 27 € HT/h, partout.
 *
 * La maquette écrit 27 € et des budgets calculés sur 27 € (« 12 h/mois … 333 € HT/mois »). Chaque
 * générateur passe ses chaînes par `retarifer()` : le tarif ET les montants qui en dérivent sont
 * recalculés à partir de la même règle que le thème (`tfp_budget_example()` : heures × tarif +
 * 9 € de gestion ; premier mois + 50 € de mise en place ; main-d'œuvre seule = heures × tarif).
 * Un montant n'est remplacé que s'il est suivi du signe € : aucun autre nombre n'est touché.
 */
export const ANCIEN = 27;
export const TARIF = 26;
const GESTION = 9;
const MISE_EN_PLACE = 50;

const TABLE = new Map([[ANCIEN, TARIF]]);
for (const h of [4, 5, 6, 7, 8, 10, 12, 14, 15, 16, 18, 20, 24, 25, 30, 40]) {
	TABLE.set(h * ANCIEN, h * TARIF); // main-d'œuvre seule (dont ponctuel 7 h : 189 → 182)
	TABLE.set(h * ANCIEN + GESTION, h * TARIF + GESTION); // mensuel
	TABLE.set(h * ANCIEN + GESTION + MISE_EN_PLACE, h * TARIF + GESTION + MISE_EN_PLACE); // premier mois
}

/** Compteur de remplacements, pour le contrôle en fin de génération. */
export const compteTarif = { n: 0 };

export function retarifer(texte) {
	return String(texte ?? '')
		.replace(/27,00(\s| | )?€/g, (_, esp = ' ') => (compteTarif.n++, `${TARIF},00${esp}€`))
		.replace(/(^|[^0-9,.])(\d{2,4})((?:\s| | |\\u\{00A0\})?€)/g, (m, avant, n, suite) => {
			const v = TABLE.get(Number(n));
			if (v === undefined) return m;
			compteTarif.n++;
			return `${avant}${v}${suite}`;
		});
}
