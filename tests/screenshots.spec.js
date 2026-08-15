// @ts-check
import { test } from '@playwright/test';
import fs from 'node:fs';
import path from 'node:path';
import { ONE_PER_FAMILY, LONG_NAME_ROUTES } from './data/routes.js';

/**
 * Captures responsive automatiques (brief phase 5, PROMPT-PHASES.md). Deux destinations :
 * - .screenshots/ (gitignoré) : balayage complet, une capture par famille × 12 largeurs.
 * - docs/captures/ (commité) : sélection restreinte pour consultation depuis GitHub sans exécuter
 *   la suite — les contrôles particuliers demandés (villes à nom long, formulaire en erreur/étape 2,
 *   clavier mobile, footer, tarifs) plus une capture desktop/mobile de l'accueil.
 */
const VIEWPORTS = [
	{ name: '320x568', width: 320, height: 568 },
	{ name: '360x800', width: 360, height: 800 },
	{ name: '375x812', width: 375, height: 812 },
	{ name: '393x852', width: 393, height: 852 },
	{ name: '414x896', width: 414, height: 896 },
	{ name: '812x375-paysage', width: 812, height: 375 },
	{ name: '768x1024', width: 768, height: 1024 },
	{ name: '1024x768', width: 1024, height: 768 },
	{ name: '1180x820', width: 1180, height: 820 },
	{ name: '1280x800', width: 1280, height: 800 },
	{ name: '1440x900', width: 1440, height: 900 },
	{ name: '1920x1080', width: 1920, height: 1080 },
];

const SCREENSHOTS_DIR = path.join(process.cwd(), '.screenshots');
const CAPTURES_DIR = path.join(process.cwd(), 'docs', 'captures');

function ensureDir(dir) {
	fs.mkdirSync(dir, { recursive: true });
}

/**
 * Fait défiler toute la page pour déclencher le chargement des images en `loading="lazy"`, puis
 * remonte en haut. Sans cela, une capture `fullPage` photographie les images hors écran avant
 * qu'elles ne soient chargées : elles apparaissent comme des rectangles gris (la couleur de fond
 * de l'emplacement) alors que le site est parfaitement sain. Défaut réel de la méthode de capture
 * — trouvé le 9 août 2026, il rendait les captures de `docs/captures/` trompeuses.
 */
async function loadLazyImages(page) {
	await page.evaluate(async () => {
		const step = window.innerHeight;
		for (let y = 0; y < document.body.scrollHeight; y += step) {
			window.scrollTo(0, y);
			await new Promise((r) => setTimeout(r, 100));
		}
		window.scrollTo(0, 0);
	});
	// Laisse le temps aux dernières images déclenchées de terminer leur décodage.
	await page.waitForFunction(
		() => Array.from(document.images).every((img) => !img.loading || img.complete),
		null,
		{ timeout: 10000 }
	).catch(() => {});
	await page.waitForTimeout(300);
}

async function shoot(page, dir, filename, options = {}) {
	ensureDir(dir);
	if (options.fullPage !== false) {
		await loadLazyImages(page);
	}
	await page.screenshot({ path: path.join(dir, filename), fullPage: true, ...options });
}

test.describe('Captures — une page par famille × 12 largeurs (.screenshots/)', () => {
	for (const [family, url] of Object.entries(ONE_PER_FAMILY)) {
		for (const viewport of VIEWPORTS) {
			test(`${family} @ ${viewport.name}`, async ({ page }) => {
				await page.setViewportSize({ width: viewport.width, height: viewport.height });
				await page.goto(url, { waitUntil: 'networkidle' });
				await shoot(page, path.join(SCREENSHOTS_DIR, family), `${viewport.name}.png`);
			});
		}
	}
});

test.describe('Contrôles particuliers (sélection commitée dans docs/captures/)', () => {
	test('villes à nom long : Fontaine-lès-Dijon @ 320px et 1440px', async ({ page }) => {
		for (const viewport of [VIEWPORTS[0], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto(LONG_NAME_ROUTES[0], { waitUntil: 'networkidle' });
			await shoot(page, path.join(CAPTURES_DIR), `ville-nom-long-fontaine-les-dijon-${viewport.name}.png`);
		}
	});

	test('villes à nom long : Chalon-sur-Saône @ 320px et 1440px', async ({ page }) => {
		for (const viewport of [VIEWPORTS[0], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto(LONG_NAME_ROUTES[1], { waitUntil: 'networkidle' });
			await shoot(page, path.join(CAPTURES_DIR), `ville-nom-long-chalon-sur-saone-${viewport.name}.png`);
		}
	});

	test('formulaire à l\'étape 1 (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/demande-de-devis/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `formulaire-etape-1-${viewport.name}.png`);
		}
	});

	test('formulaire à l\'étape 2 (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/demande-de-devis/', { waitUntil: 'networkidle' });
			await page.selectOption('#tfp-type-locaux', 'bureaux');
			await page.check('input[name="regime"][value="regulier"]');
			await page.fill('#tfp-nom', 'Capture Test');
			await page.fill('#tfp-telephone', '0600000000');
			await page.click('[data-step-next]');
			await shoot(page, CAPTURES_DIR, `formulaire-etape-2-${viewport.name}.png`);
		}
	});

	test('formulaire en erreur (champs manquants, mobile)', async ({ page }) => {
		await page.setViewportSize({ width: VIEWPORTS[2].width, height: VIEWPORTS[2].height });
		await page.goto('/demande-de-devis/', { waitUntil: 'networkidle' });
		await page.click('[data-step-next]');
		await shoot(page, CAPTURES_DIR, `formulaire-erreur-${VIEWPORTS[2].name}.png`);
	});

	test('formulaire, clavier mobile ouvert (viewport réduit, champ focus)', async ({ page }) => {
		// Simulation : un clavier virtuel mobile réduit la hauteur visible du viewport sans changer
		// sa largeur. Aucune émulation native de clavier virtuel n'existe dans Chromium piloté par
		// Playwright ; approximation par une hauteur de viewport réduite pendant qu'un champ texte a
		// le focus, ce qui est l'effet visuel réellement observable et testable.
		await page.setViewportSize({ width: 375, height: 400 });
		await page.goto('/demande-de-devis/', { waitUntil: 'networkidle' });
		await page.focus('#tfp-nom'); // champ visible dès l'étape 1
		await shoot(page, CAPTURES_DIR, 'formulaire-clavier-mobile-ouvert-375x400.png');
	});

	test('footer (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/', { waitUntil: 'networkidle' });
			// Capture du footer lui-même, pas fullPage : une capture pleine page depuis l'accueil
			// ferait doublon avec la capture "accueil" ci-dessous et pèserait inutilement lourd.
			const footer = page.locator('footer');
			await footer.scrollIntoViewIfNeeded();
			const box = await footer.boundingBox();
			ensureDir(CAPTURES_DIR);
			await page.screenshot({ path: path.join(CAPTURES_DIR, `footer-${viewport.name}.png`), clip: box ?? undefined });
		}
	});

	test('page tarifs — la plus proche d\'un contenu tabulaire (mobile et desktop)', async ({ page }) => {
		// Constat, pas un défaut : aucun <table> HTML n'existe sur le site, la grille tarifaire est
		// affichée en cartes (meilleure lisibilité mobile) — voir STATUS.md, section phase 5.
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/tarifs/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `tarifs-${viewport.name}.png`);
		}
	});

	test('accueil (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `accueil-${viewport.name}.png`);
		}
	});

	// Complément hotfix fidélité production (comparaison obligatoire, §11) : captures qui
	// manquaient encore à la sélection commitée.
	test('hero (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/', { waitUntil: 'networkidle' });
			const hero = page.locator('.tfp-hero').first();
			const box = await hero.boundingBox();
			ensureDir(CAPTURES_DIR);
			await page.screenshot({ path: path.join(CAPTURES_DIR, `hero-${viewport.name}.png`), clip: box ?? undefined });
		}
	});

	test('menu mobile ouvert', async ({ page }) => {
		await page.setViewportSize({ width: VIEWPORTS[2].width, height: VIEWPORTS[2].height });
		await page.goto('/', { waitUntil: 'networkidle' });
		await page.click('[data-tfp-mobile-open]');
		await page.waitForTimeout(350); // transition d'ouverture (CSS)
		await shoot(page, CAPTURES_DIR, `menu-mobile-ouvert-${VIEWPORTS[2].name}.png`);
	});

	test('index prestations (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/prestations/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `prestations-${viewport.name}.png`);
		}
	});

	test('page prestation bureaux (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/prestations/bureaux/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `prestation-bureaux-${viewport.name}.png`);
		}
	});

	test('page zone Dijon (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/zones-intervention/cote-dor/dijon/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `zone-dijon-${viewport.name}.png`);
		}
	});

	test('mentions légales (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/mentions-legales/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `mentions-legales-${viewport.name}.png`);
		}
	});

	test('404 (mobile et desktop)', async ({ page }) => {
		for (const viewport of [VIEWPORTS[2], VIEWPORTS[10]]) {
			await page.setViewportSize({ width: viewport.width, height: viewport.height });
			await page.goto('/cette-page-n-existe-pas/', { waitUntil: 'networkidle' });
			await shoot(page, CAPTURES_DIR, `404-${viewport.name}.png`);
		}
	});
});
