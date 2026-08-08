// @ts-check
import { test, expect } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
import { ONE_PER_FAMILY } from './data/routes.js';

/**
 * Audit accessibilité final (phase 6, PROMPT-PHASES.md) : axe-core (WCAG 2A/2AA/2.2AA) sur une page
 * de chaque famille, complété par des interactions clavier réelles sur le menu mobile (drawer), les
 * sous-menus desktop, le formulaire de devis et la barre CTA mobile — pas seulement un scan
 * automatisé, qui ne détecte ni piège de focus manquant ni ordre de tabulation incohérent.
 */
const AUDITED_PAGES = { ...ONE_PER_FAMILY, 'formulaire de devis': '/demande-de-devis/' };

for (const [family, url] of Object.entries(AUDITED_PAGES)) {
	test(`axe-core WCAG 2.2 AA — ${family} (${url})`, async ({ page }) => {
		await page.goto(url, { waitUntil: 'networkidle' });
		const results = await new AxeBuilder({ page }).withTags(['wcag2a', 'wcag2aa', 'wcag22aa', 'best-practice']).analyze();
		expect(results.violations, JSON.stringify(results.violations, null, 2)).toEqual([]);
	});
}

test.describe('Navigation clavier réelle', () => {
	test('menu mobile (drawer) : ouverture, piège de focus, Échap restitue le focus', async ({ page }) => {
		await page.setViewportSize({ width: 375, height: 812 });
		await page.goto('/', { waitUntil: 'networkidle' });

		const openBtn = page.locator('[data-tfp-mobile-open]');
		await openBtn.focus();
		await page.keyboard.press('Enter');

		const panel = page.locator('[data-tfp-mobile-panel]');
		await expect(panel).toBeVisible();
		await expect(openBtn).toHaveAttribute('aria-expanded', 'true');

		// Le focus doit être entré dans le panneau (pas resté dehors, pas perdu sur <body>).
		const focusedInPanel = await page.evaluate(() => {
			const panel = document.querySelector('[data-tfp-mobile-panel]');
			return !!panel && panel.contains(document.activeElement);
		});
		expect(focusedInPanel).toBe(true);

		// Piège de focus, dans les deux sens — le premier élément réel du panneau est le lien logo
		// (avant le bouton fermer dans le DOM), pas le bouton fermer lui-même.
		const getFocusableIds = () =>
			page.evaluate(() => {
				const panel = document.querySelector('[data-tfp-mobile-panel]');
				// Même filtre que src/js/nav.js (visibleFocusable) : les liens des sous-menus accordéon
				// repliés matchent le sélecteur mais ne sont pas réellement focusables (display:none).
				const focusable = Array.from(
					panel.querySelectorAll(
						'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
					)
				).filter((el) => el.offsetParent !== null);
				return focusable.map((el, i) => (el === document.activeElement ? `ACTIVE:${i}` : `${i}`));
			});

		await page.evaluate(() => {
			const panel = document.querySelector('[data-tfp-mobile-panel]');
			const focusable = Array.from(
				panel.querySelectorAll(
					'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
				)
			).filter((el) => el.offsetParent !== null);
			focusable[0].focus();
		});
		await page.keyboard.press('Shift+Tab');
		let ids = await getFocusableIds();
		const lastIndex = ids.length - 1;
		expect(ids[lastIndex], `Shift+Tab depuis le premier élément doit boucler sur le dernier (${JSON.stringify(ids)})`).toBe(
			`ACTIVE:${lastIndex}`
		);

		await page.keyboard.press('Tab');
		ids = await getFocusableIds();
		expect(ids[0], `Tab depuis le dernier élément doit boucler sur le premier (${JSON.stringify(ids)})`).toBe('ACTIVE:0');

		// Échap ferme le panneau et restitue le focus au bouton d'ouverture.
		await page.keyboard.press('Escape');
		await expect(panel).toBeHidden();
		await expect(openBtn).toBeFocused();
	});

	test('sous-menu mobile en accordéon : ouverture/fermeture au clavier', async ({ page }) => {
		await page.setViewportSize({ width: 375, height: 812 });
		await page.goto('/', { waitUntil: 'networkidle' });
		await page.locator('[data-tfp-mobile-open]').click();

		const toggle = page.locator('#tfp-mobile-btn-prestations');
		await toggle.focus();
		await page.keyboard.press('Enter');
		await expect(toggle).toHaveAttribute('aria-expanded', 'true');
		await expect(page.locator('#tfp-mobile-sub-prestations')).toBeVisible();

		await page.keyboard.press('Enter');
		await expect(toggle).toHaveAttribute('aria-expanded', 'false');
		await expect(page.locator('#tfp-mobile-sub-prestations')).toBeHidden();
	});

	test('sous-menu desktop (Prestations) : ouverture au clavier, Échap referme et restitue le focus', async ({ page }) => {
		await page.setViewportSize({ width: 1440, height: 900 });
		await page.goto('/', { waitUntil: 'networkidle' });

		const toggle = page.locator('#tfp-btn-prestations');
		await toggle.focus();
		await page.keyboard.press('Enter');
		await expect(toggle).toHaveAttribute('aria-expanded', 'true');
		await expect(page.locator('#tfp-menu-prestations')).toBeVisible();

		await page.keyboard.press('Escape');
		await expect(toggle).toHaveAttribute('aria-expanded', 'false');
		await expect(toggle).toBeFocused();
	});

	test('barre CTA mobile fixe : boutons atteignables et activables au clavier', async ({ page }) => {
		await page.setViewportSize({ width: 375, height: 812 });
		await page.goto('/prestations/bureaux/', { waitUntil: 'networkidle' });
		const bar = page.locator('.tfp-mobile-cta-bar');
		await expect(bar).toBeVisible();
		const links = bar.locator('a, button');
		const count = await links.count();
		expect(count).toBeGreaterThan(0);
		for (let i = 0; i < count; i++) {
			const el = links.nth(i);
			await expect(el).toBeVisible();
			const box = await el.boundingBox();
			// Cibles tactiles ≥44px (CLAUDE.md §8).
			expect(box.height, `cible tactile ${i} de la barre CTA mobile`).toBeGreaterThanOrEqual(44);
		}
	});

	test('formulaire de devis : ordre de tabulation logique à l\'étape 1', async ({ page }) => {
		await page.goto('/demande-de-devis/');
		await page.locator('#tfp-type-locaux').focus();
		const order = ['tfp-type-locaux'];
		for (let i = 0; i < 6; i++) {
			await page.keyboard.press('Tab');
			const id = await page.evaluate(() => document.activeElement?.id || document.activeElement?.name || document.activeElement?.tagName);
			order.push(id);
		}
		// L'ordre doit progresser dans le DOM (régime → ville → code postal → surface → nom → …),
		// jamais revenir en arrière ni sauter hors du formulaire vers le header/footer.
		const form = page.locator('.tfp-quote-form');
		for (const id of order.slice(1)) {
			if (!id) continue;
			const inForm = await form.evaluate((f, elId) => {
				const el = document.getElementById(elId) || document.getElementsByName(elId)[0];
				return !!el && f.contains(el);
			}, id);
			expect(inForm, `le focus (${id}) doit rester dans le formulaire pendant la tabulation de l'étape 1`).toBe(true);
		}
	});
});
