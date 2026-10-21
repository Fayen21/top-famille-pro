/**
 * Alignement entre le contenu **visible** d'un article et son JSON-LD.
 *
 * Une donnée structurée est une déclaration faite à Google : elle doit décrire ce que la page
 * montre, pas ce qu'un gabarit avait sous la main. Deux dérives sont faciles et invisibles à
 * l'œil — l'auteur qui reste `admin` parce que c'est le compte d'installation, et l'image qui
 * retombe sur le logo du site faute d'image mise en avant. La seconde est explicitement
 * déconseillée : l'image d'un `Article` doit représenter l'article.
 *
 * Ce test lit le nœud `Article` du graphe et le compare au rendu.
 */
import { test, expect } from '@playwright/test';

const ARTICLES = [
	'/conseils/frequence-bureaux/',
	'/conseils/cout-nettoyage-bureaux/',
	'/conseils/cahier-des-charges-nettoyage/',
];

/** Nœud `Article` du graphe JSON-LD de la page. */
async function noeudArticle(page) {
	return page.evaluate(() => {
		for (const s of document.querySelectorAll('script[type="application/ld+json"]')) {
			let donnees;
			try {
				donnees = JSON.parse(s.textContent || '{}');
			} catch {
				continue;
			}
			const noeuds = donnees['@graph'] || [donnees];
			const article = noeuds.find((n) => n['@type'] === 'Article');
			if (article) return article;
		}
		return null;
	});
}

test.describe('Articles — JSON-LD aligné sur le visible', () => {
	for (const url of ARTICLES) {
		test(`${url} : auteur, dates, image et titre correspondent au rendu`, async ({ page }) => {
			await page.goto(url, { waitUntil: 'domcontentloaded' });

			const article = await noeudArticle(page);
			expect(article, `${url} : aucun nœud Article dans le JSON-LD`).not.toBeNull();

			// --- Auteur : jamais le compte d'installation.
			expect(
				JSON.stringify(article.author),
				`${url} : l'auteur public ne doit jamais être « admin »`
			).not.toMatch(/"admin"/i);
			expect(article.author['@type'], 'l’auteur doit être une entité Person').toBe('Person');
			expect(article.author.name.length, 'le nom de l’auteur doit être renseigné').toBeGreaterThan(3);

			// L'auteur déclaré doit être celui que la page affiche.
			const visible = await page.evaluate(() => document.body.innerText);
			expect(visible, `${url} : l’auteur du schéma ne figure pas sur la page`).toContain(
				article.author.name.split(' ')[0]
			);

			// --- Image : celle de l'article, pas le logo du site.
			expect(article.image, `${url} : l’image du schéma ne doit pas être le logo`).not.toMatch(/logo/i);
			expect(article.image, `${url} : image absente`).toBeTruthy();
			// Elle doit se charger réellement.
			const reponse = await page.request.get(article.image);
			expect(reponse.status(), `${url} : l’image du schéma renvoie ${reponse.status()}`).toBe(200);

			// --- Dates : celles qu'affiche la page, au jour près.
			const jourFr = (iso) => {
				const d = new Date(iso);
				return `${d.getDate()} ${['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'][d.getMonth()]} ${d.getFullYear()}`;
			};
			expect(visible, `${url} : datePublished ne correspond pas à la date affichée`).toContain(
				jourFr(article.datePublished)
			);
			if (article.dateModified && article.dateModified !== article.datePublished) {
				expect(visible, `${url} : dateModified ne correspond pas à la date affichée`).toContain(
					jourFr(article.dateModified)
				);
			}

			// --- Titre et canonical.
			const h1 = await page.locator('h1').first().innerText();
			expect(article.headline.trim()).toBe(h1.trim());

			const canonical = await page.locator('link[rel="canonical"]').getAttribute('href');
			expect(canonical, `${url} : canonical non auto-référente`).toContain(url);

			// --- Aucune donnée d'avis, ici comme ailleurs.
			const graphe = await page.evaluate(() =>
				[...document.querySelectorAll('script[type="application/ld+json"]')].map((s) => s.textContent).join(' ')
			);
			expect(graphe).not.toMatch(/"@type"\s*:\s*"(Review|AggregateRating)"/);
		});
	}
});
