/**
 * Panneau de différence des triptyques — réécrit en G26.
 *
 * POURQUOI. Le générateur G25 composait `difference` puis `negate()`. Sur deux rendus proches,
 * la différence par pixel vaut quelques niveaux seulement : après inversion, tout ressort à
 * 250-255, c'est-à-dire un panneau BLANC UNIFORME. Une image manquante, un cadrage faux ou un
 * bloc déplacé y étaient donc invisibles — et la validation humaine du 17 août 2026 a été
 * refusée sur ce constat : « le troisième panneau est pratiquement uniforme malgré des
 * différences majeures ».
 *
 * COMMENT. La différence est calculée sur les octets, canal par canal, puis :
 *  - convertie en écart de luminance perçue ;
 *  - AMPLIFIÉE d'un facteur annoncé, et l'amplification est écrite dans l'image ;
 *  - rendue en fausse couleur (magenta sur fond clair) : un écart de 2 niveaux devient visible,
 *    là où un gris à peine plus sombre ne l'est pas ;
 *  - MESURÉE : proportion de pixels au-dessus du seuil de perception, écrite elle aussi.
 *
 * Un panneau uniforme ne peut donc plus être pris pour une validation : soit le taux affiché est
 * nul et les deux rendus sont réellement superposables, soit il ne l'est pas et la zone est
 * coloriée. Les deux captures doivent en outre avoir la même largeur et le même facteur de
 * densité — c'est la responsabilité de l'appelant, et `verifierComparabilite()` le contrôle.
 */
import sharp from 'sharp';

/** Seuil de perception : en deçà, l'écart n'est pas visible à l'œil sur un écran ordinaire. */
export const SEUIL = 6;
/** Amplification par défaut, annoncée sur le panneau. */
export const AMPLIFICATION = 8;

/**
 * Deux captures sont-elles comparables ? Refuse de produire un panneau trompeur.
 *
 * @throws si les largeurs diffèrent : superposer deux images de largeurs différentes fabrique un
 *         décalage horizontal qui masque les vrais écarts sous un bruit uniforme.
 */
export function verifierComparabilite(aMeta, bMeta) {
	if (aMeta.width !== bMeta.width) {
		throw new Error(
			`captures non comparables : largeurs ${aMeta.width} et ${bMeta.width}. ` +
				'Capturer les deux côtés à la même largeur de fenêtre et au même deviceScaleFactor.'
		);
	}
}

/**
 * Panneau de différence lisible.
 *
 * @param {Buffer} aBuf Référence (maquette), déjà à la largeur du panneau.
 * @param {Buffer} bBuf Rendu WordPress, même largeur.
 * @param {{amplification?: number, seuil?: number, fond?: string}} opts
 * @returns {Promise<{png: Buffer, pourcentage: number, amplification: number, hauteur: number}>}
 */
export async function panneauDifference(aBuf, bBuf, opts = {}) {
	const amplification = opts.amplification ?? AMPLIFICATION;
	const seuil = opts.seuil ?? SEUIL;

	const [am, bm] = await Promise.all([sharp(aBuf).metadata(), sharp(bBuf).metadata()]);
	verifierComparabilite(am, bm);
	const largeur = am.width;
	const hauteur = Math.max(am.height, bm.height);

	// Compléter la plus courte en BLANC : une page plus courte d'un côté doit ressortir comme un
	// écart franc sur toute la zone manquante, pas être recadrée hors du champ.
	/*
	 * `removeAlpha()` est indispensable : sharp ajoute un canal alpha dès qu'une des sources en a
	 * un, et le tampon brut passe alors à quatre octets par pixel. Un parcours en pas de trois y
	 * décale toute la lecture et ne couvre que les trois quarts de l'image — c'est exactement ce
	 * qui rendait le panneau incohérent, en plus de l'inversion héritée.
	 */
	const completer = (buf) =>
		sharp({ create: { width: largeur, height: hauteur, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.removeAlpha()
			.raw()
			.toBuffer();
	const [a, b] = await Promise.all([completer(aBuf), completer(bBuf)]);

	const px = largeur * hauteur;
	const sortie = Buffer.alloc(px * 3);
	let differents = 0;
	for (let i = 0; i < px; i++) {
		const o = i * 3;
		// Écart de luminance perçue : un écart sur le vert pèse plus qu'un écart sur le bleu.
		const d =
			0.299 * Math.abs(a[o] - b[o]) + 0.587 * Math.abs(a[o + 1] - b[o + 1]) + 0.114 * Math.abs(a[o + 2] - b[o + 2]);
		if (d >= seuil) differents++;
		const v = Math.min(255, d * amplification);
		// Fausse couleur : fond clair neutre, écart en magenta d'autant plus saturé qu'il est grand.
		sortie[o] = 245;
		sortie[o + 1] = Math.max(0, 245 - v);
		sortie[o + 2] = Math.max(0, 245 - v * 0.35);
	}
	const pourcentage = Math.round((differents / px) * 10000) / 100;

	// Bandeau d'honnêteté : l'amplification et le taux mesuré sont écrits DANS l'image, pour
	// qu'un panneau ne puisse jamais être lu comme « identique » par simple absence de couleur.
	const etiquette = Buffer.from(
		`<svg width="${largeur}" height="26" xmlns="http://www.w3.org/2000/svg">
			<rect width="${largeur}" height="26" fill="#10263B"/>
			<text x="8" y="18" font-family="sans-serif" font-size="13" fill="#ffffff">
				DIFFÉRENCE amplifiée ×${amplification} — ${pourcentage.toFixed(2)} % des pixels s'écartent
			</text>
		</svg>`
	);

	const png = await sharp(sortie, { raw: { width: largeur, height: hauteur, channels: 3 } })
		.composite([{ input: etiquette, top: 0, left: 0 }])
		.png()
		.toBuffer();

	return { png, pourcentage, amplification, hauteur };
}

/**
 * Ancienne différence (G25) — CONSERVÉE UNIQUEMENT comme témoin de non-régression.
 *
 * `tests/diff-visuel.spec.js` s'en sert pour prouver, sur une fixture volontairement différente,
 * que l'ancienne méthode ne révélait PAS la zone modifiée et que la nouvelle la révèle. Elle
 * n'est employée par aucun outil de production.
 */
export async function panneauDifferenceHerite(aBuf, bBuf) {
	const [am, bm] = await Promise.all([sharp(aBuf).metadata(), sharp(bBuf).metadata()]);
	const largeur = am.width;
	const hauteur = Math.max(am.height, bm.height);
	const completer = (buf) =>
		sharp({ create: { width: largeur, height: hauteur, channels: 3, background: '#ffffff' } })
			.composite([{ input: buf, top: 0, left: 0 }])
			.png()
			.toBuffer();
	const [a, b] = await Promise.all([completer(aBuf), completer(bBuf)]);
	return sharp(a).composite([{ input: b, blend: 'difference' }]).negate().png().toBuffer();
}

/**
 * Contraste d'un panneau : écart entre le pixel le plus clair et le plus sombre, en luminance.
 * Sert à mesurer si un panneau « montre » quelque chose — un panneau uniforme vaut ~0.
 */
export async function contrastePanneau(png) {
	const { data, info } = await sharp(png).removeAlpha().raw().toBuffer({ resolveWithObject: true });
	let min = 255;
	let max = 0;
	for (let i = 0; i < info.width * info.height; i++) {
		const o = i * info.channels;
		const l = 0.299 * data[o] + 0.587 * data[o + 1] + 0.114 * data[o + 2];
		if (l < min) min = l;
		if (l > max) max = l;
	}
	return Math.round(max - min);
}
