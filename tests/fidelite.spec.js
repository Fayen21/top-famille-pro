// @ts-check
import { test, expect } from '@playwright/test';

/**
 * Fidélité à la maquette Claude Design (reference/Top-Famille-Pro-HANDOFF-READY.html) et
 * comportement des contenus de démonstration selon l'environnement.
 *
 * Les hauteurs et ratios attendus ci-dessous ont été relevés sur le rendu réel de la maquette
 * exécutée dans le même navigateur, à 1440px — pas lus dans le HTML ni devinés depuis les noms de
 * classes (docs/AUDIT-PRODUCTION.md §3c).
 */

/** Ordre et intitulé des blocs de l'accueil, relevés sur la maquette. */
const HOME_BLOCKS = [
	{ n: 1, match: /Nettoyage professionnel de bureaux/i, label: 'Hero' },
	{ n: 2, match: /tarif unique/i, label: 'Bandeau tarifaire' },
	{ n: 3, match: /Saint-Apollinaire/i, label: 'Réassurance' },
	{ n: 4, match: /Pensé pour les professionnels de la région/i, label: 'Audiences' },
	{ n: 5, match: /Nos prestations de nettoyage/i, label: 'Prestations' },
	{ n: 6, match: /Les difficultés que nous prenons en charge/i, label: 'Difficultés' },
	{ n: 7, match: /Pourquoi Top-Famille Pro/i, label: 'Pourquoi + témoignage' },
	{ n: 8, match: /Notre fonctionnement, en cinq temps/i, label: 'Fonctionnement' },
	{ n: 9, match: /Un tarif clair, affiché avant le devis/i, label: 'Tarif' },
	// Intitulé de la maquette, rétabli le 10 août 2026 sur décision d'Emmanuel : reproduire d'abord
	// le prototype, reformuler ensuite. La correction éditoriale de CLAUDE.md §9 (« Une entreprise
	// régionale basée à Saint-Apollinaire ») reste à appliquer dans une passe ultérieure.
	{ n: 10, match: /Une couverture régionale, pas des agences fictives/i, label: 'Couverture régionale' },
	{ n: 11, match: /Audrey, votre interlocutrice/i, label: 'Audrey' },
	{ n: 12, match: /Conseils & repères/i, label: 'Conseils' },
	{ n: 13, match: /Demandez votre devis gratuit/i, label: 'CTA final' },
];

/** Ratios d'image relevés sur la maquette à 1440px (largeur / hauteur). */
const IMAGE_RATIOS = [
	{ sel: '.tfp-hero__media-main img', ratio: 4 / 3.5, label: 'hero principal' },
	{ sel: '.tfp-hero__media-secondary img', ratio: 1, label: 'hero secondaire' },
	{ sel: '.tfp-article-card img', ratio: 16 / 9, label: 'vignette article' },
];

test.describe('Fidélité Claude Design — accueil', () => {
	test('les 13 blocs de la maquette sont présents, dans le même ordre', async ({ page }) => {
		await page.goto('/');
		const text = await page.locator('body').innerText();

		let cursor = -1;
		for (const block of HOME_BLOCKS) {
			const found = text.search(block.match);
			expect(found, `bloc ${block.n} « ${block.label} » absent de l'accueil`).toBeGreaterThan(-1);
			expect(found, `bloc ${block.n} « ${block.label} » n'est pas dans l'ordre de la maquette`).toBeGreaterThan(cursor);
			cursor = found;
		}
	});

	test('header et footer encadrent la page', async ({ page }) => {
		await page.goto('/');
		await expect(page.locator('header').first()).toBeVisible();
		await expect(page.locator('footer').first()).toBeVisible();
	});

	test('les puces d’audience ne sont pas dupliquées', async ({ page }) => {
		await page.goto('/');
		// Régression réelle : elles ont existé à la fois dans la section « Prestations » (fusion de
		// phase 1) et dans la section dédiée rétablie le 9 août 2026.
		const occurrences = await page.locator('text=Syndics & gestionnaires').count();
		expect(occurrences, 'la puce « Syndics & gestionnaires » ne doit apparaître qu’une fois').toBe(1);
	});

	test('titres de section à la taille de la maquette (42px à 1440px)', async ({ page }) => {
		await page.setViewportSize({ width: 1440, height: 900 });
		await page.goto('/');
		const size = await page
			.locator('h2', { hasText: 'Nos prestations de nettoyage' })
			.first()
			.evaluate((el) => parseFloat(getComputedStyle(el).fontSize));
		// Tolérance ±2px demandée sur les tailles de police.
		expect(Math.abs(size - 42), `titre de section à ${size}px au lieu de 42px`).toBeLessThanOrEqual(2);
	});
});

test.describe('Fidélité Claude Design — images', () => {
	test('toutes les images de l’accueil se chargent réellement', async ({ page }) => {
		await page.goto('/', { waitUntil: 'networkidle' });
		// Les images hors écran sont en lazy-loading : il faut défiler pour les déclencher, sinon
		// elles paraissent absentes (rectangles gris) alors qu'elles sont saines.
		await page.evaluate(async () => {
			for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
				window.scrollTo(0, y);
				await new Promise((r) => setTimeout(r, 100));
			}
			window.scrollTo(0, 0);
		});
		await page.waitForTimeout(800);

		const broken = await page.evaluate(() =>
			Array.from(document.images)
				.filter((img) => img.naturalWidth === 0)
				.map((img) => img.currentSrc || img.src || img.alt)
		);
		expect(broken, 'aucune image ne doit rester non chargée').toEqual([]);
	});

	for (const { sel, ratio, label } of IMAGE_RATIOS) {
		test(`ratio de l’image « ${label} » conforme à la maquette`, async ({ page }) => {
			await page.setViewportSize({ width: 1440, height: 900 });
			await page.goto('/');
			const box = await page.locator(sel).first().boundingBox();
			expect(box, `${sel} introuvable`).not.toBeNull();
			const actual = box.width / box.height;
			expect(
				Math.abs(actual - ratio),
				`${label} : ratio ${actual.toFixed(3)} au lieu de ${ratio.toFixed(3)} (${Math.round(box.width)}×${Math.round(box.height)})`
			).toBeLessThan(0.05);
		});
	}
});

test.describe('Témoignages provisoires repris de la maquette', () => {
	/*
	 * Décision du 10 août 2026 (Emmanuel) : les témoignages de la maquette Claude Design sont
	 * reproduits tels quels dans cette version de travail, y compris en production, en attendant
	 * de vrais avis clients. Ces tests vérifient donc l'inverse de ce qu'ils vérifiaient avant :
	 * non plus qu'ils sont masqués, mais qu'ils restent **repérables et remplaçables**, et qu'ils
	 * n'alimentent aucune donnée structurée.
	 */
	test('les témoignages provisoires sont marqués, donc retrouvables en une requête', async ({ page }) => {
		await page.goto('/');
		const provisoires = page.locator('[data-tfp-provisional]');
		expect(
			await provisoires.count(),
			'au moins un témoignage provisoire doit être marqué tant qu’aucun avis réel n’est saisi'
		).toBeGreaterThan(0);
	});

	test('un témoignage provisoire n’émet jamais de schéma Review ou AggregateRating', async ({ page }) => {
		await page.goto('/');
		const jsonld = (await page.locator('script[type="application/ld+json"]').allTextContents()).join(' ');
		expect(jsonld).not.toMatch(/"@type"\s*:\s*"(Review|AggregateRating)"/);
		expect(jsonld).not.toMatch(/aggregateRating|reviewRating|ratingValue/i);
	});

	test('la note Google réelle n’est jamais mélangée au balisage des témoignages', async ({ page }) => {
		await page.goto('/');
		// La note 5,0/5 est réelle et affichable (CLAUDE.md §5.5), mais c'est une note de plateforme
		// tierce : la baliser comme note du site serait contraire aux règles de Google sur les
		// résultats enrichis.
		const badge = page.locator('.tfp-google-badge').first();
		if (await badge.count()) {
			await expect(badge).toContainText('sur Google');
		}
		const jsonld = (await page.locator('script[type="application/ld+json"]').allTextContents()).join(' ');
		expect(jsonld).not.toMatch(/ratingValue/i);
	});
});

/**
 * Preuve stricte : sur une installation réellement en `WP_ENVIRONMENT_TYPE=production`, aucun
 * contenu interdit n'est publié. Les témoignages provisoires y sont désormais autorisés (décision
 * du 10 août 2026) ; le compteur d'avis non confirmé et l'ancienne marque ne le sont pas.
 */
const PROD_URL = process.env.TFP_PROD_BASE_URL || 'http://localhost:8901';

test.describe('Production — aucun faux avis publié', () => {
	test('aucun contenu de démonstration en production', async ({ page }) => {
		let reachable = true;
		await page.goto(PROD_URL + '/', { waitUntil: 'domcontentloaded' }).catch(() => {
			reachable = false;
		});
		test.skip(!reachable, `instance de production non joignable sur ${PROD_URL}`);

		const text = await page.locator('body').innerText();
		// Le compteur « 47 avis » du prototype reste fictif et interdit, même si la note, elle, est
		// désormais confirmée (CLAUDE.md §5.5).
		expect(text).not.toMatch(/47\s*avis/i);
		expect(text, 'l’ancienne marque ne doit plus apparaître').not.toMatch(/Top-Entreprise/);

		const jsonld = (await page.locator('script[type="application/ld+json"]').allTextContents()).join(' ');
		expect(jsonld).not.toMatch(/"@type"\s*:\s*"(Review|AggregateRating)"/);
	});

	test('la note Google confirmée est affichée, sans balisage AggregateRating', async ({ page }) => {
		let reachable = true;
		await page.goto(PROD_URL + '/', { waitUntil: 'domcontentloaded' }).catch(() => {
			reachable = false;
		});
		test.skip(!reachable, `instance de production non joignable sur ${PROD_URL}`);

		// Note réelle confirmée le 9 août 2026 : elle doit apparaître, y compris en production.
		await expect(page.locator('.tfp-google-badge--inline')).toHaveCount(1);
		await expect(page.locator('.tfp-google-badge--inline')).toContainText('5,0/5');

		// Mais jamais balisée comme note du site : c'est une note de plateforme tierce.
		const jsonld = (await page.locator('script[type="application/ld+json"]').allTextContents()).join(' ');
		expect(jsonld).not.toMatch(/aggregateRating|ratingValue/i);
	});

	test('le composant témoignage reste dans un état neutre, sans casser la mise en page', async ({ page }) => {
		let reachable = true;
		await page.goto(PROD_URL + '/', { waitUntil: 'domcontentloaded' }).catch(() => {
			reachable = false;
		});
		test.skip(!reachable, `instance de production non joignable sur ${PROD_URL}`);

		// La section « Pourquoi » existe toujours et garde ses deux colonnes.
		await expect(page.locator('.tfp-why')).toHaveCount(1);
		await expect(page.locator('.tfp-why__aside')).toHaveCount(1);
	});
});
