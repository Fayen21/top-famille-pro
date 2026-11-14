/**
 * Préparation d'une page avant capture — revue du 25 octobre 2026.
 *
 * `docs/captures-passe-visuelle/apres/accueil-1440.png` montrait des rectangles unis à la place du
 * portrait, des trois vignettes de conseils et du logo du pied de page, alors que les mêmes images
 * étaient visibles sur les captures ciblées. Cause vérifiée : l'outil prenait la pleine page sans
 * jamais faire défiler la fenêtre. Les images hors du premier écran portent `loading="lazy"` (ce
 * qui est voulu, pour les performances) : non parcourues, elles n'étaient jamais demandées. Le
 * thème n'était pas en cause ; c'est l'outil qui est corrigé, sans rendre les images « eager ».
 *
 * `preparer()` :
 *  1. coupe animations et transitions (aucun état intermédiaire capturé) ;
 *  2. attend `document.fonts.ready` ;
 *  3. parcourt toute la page par pas de 60 % de fenêtre pour déclencher le chargement différé ;
 *  4. attend, pour chaque image, la fin du chargement PUIS du décodage (`img.decode()`) ;
 *  5. attend que la hauteur du document se stabilise, puis revient en haut de page ;
 *  6. renvoie un bilan : images complètes (naturalWidth > 0), et images effectivement rendues
 *     (boîte non nulle, visibles) mais non chargées — la seule anomalie qui compte.
 *
 * `figerCouches()` sert aux captures PROPRES d'un composant : il remet l'en-tête collant dans le
 * flux et masque la barre d'action mobile, pour qu'elles ne traversent pas l'image. Les captures
 * « fenêtre » ne l'appellent jamais : elles montrent le comportement réel des couches fixes.
 */
export async function preparer(page) {
	await page.addStyleTag({ content: '*,*::before,*::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}' });
	await page.evaluate(() => document.fonts.ready);
	await page.evaluate(async () => {
		const pause = (ms) => new Promise((r) => setTimeout(r, ms));
		const pas = Math.max(200, Math.round(window.innerHeight * 0.6));
		for (let y = 0; y < document.documentElement.scrollHeight; y += pas) {
			window.scrollTo(0, y);
			await pause(110);
		}
		window.scrollTo(0, document.documentElement.scrollHeight);
		await pause(300);
	});
	const bilan = await page.evaluate(async () => {
		const imgs = [...document.images];
		await Promise.all(
			imgs.map(
				(i) =>
					new Promise((fin) => {
						const decoder = () => (i.naturalWidth ? i.decode().catch(() => {}) : Promise.resolve()).then(fin);
						if (i.complete) return decoder();
						i.addEventListener('load', decoder, { once: true });
						i.addEventListener('error', fin, { once: true });
						setTimeout(fin, 10000);
					})
			)
		);
		return imgs.map((i) => {
			const r = i.getBoundingClientRect();
			const cs = getComputedStyle(i);
			return {
				src: (i.currentSrc || i.src || '').split('/').pop(),
				complete: i.complete && i.naturalWidth > 0,
				rendue: r.width > 0 && r.height > 0 && cs.visibility !== 'hidden' && cs.display !== 'none',
			};
		});
	});
	let avant = -1;
	for (let k = 0; k < 15; k++) {
		const h = await page.evaluate(() => document.documentElement.scrollHeight);
		if (h === avant) break;
		avant = h;
		await page.waitForTimeout(200);
	}
	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(250);
	return {
		images: bilan.length,
		completes: bilan.filter((b) => b.complete).length,
		rendues_non_chargees: bilan.filter((b) => b.rendue && !b.complete).map((b) => b.src),
	};
}

export async function figerCouches(page) {
	await page.addStyleTag({
		content: '.tfp-header{position:relative!important;top:auto!important}.tfp-mobile-cta-bar{display:none!important}',
	});
	await page.waitForTimeout(100);
}
