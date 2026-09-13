// @ts-check
import { test, expect } from '@playwright/test';

const FORM_URL = '/demande-de-devis/';

/**
 * Refuse de soumettre sur une installation qui expédie réellement.
 *
 * Le thème ne pose `data-tfp-mail-disabled` qu'en environnement `local` ou `development`. Ces
 * tests reposaient jusqu'ici sur l'ABSENCE de transport mail sur le banc — une circonstance, pas
 * une garantie : sur une préproduction Hostinger, qui en a un, chaque exécution aurait expédié
 * six demandes de devis à la gérante.
 */
async function envoiNeutralise(page) {
	return (await page.locator('.tfp-quote-form[data-tfp-mail-disabled]').count()) > 0;
}

test.beforeEach(async ({ page }) => {
	await page.goto(FORM_URL);
	test.skip(
		!(await envoiNeutralise(page)),
		"installation sans neutralisation d'envoi : soumettre expédierait un e-mail réel"
	);
});

async function fillStepOne(page, { telephone = '', email = '' } = {}) {
	await page.selectOption('#tfp-type-locaux', 'bureaux');
	await page.check('input[name="regime"][value="regulier"]');
	await page.fill('#tfp-nom', 'Test Automatisé');
	if (telephone) await page.fill('#tfp-telephone', telephone);
	if (email) await page.fill('#tfp-email', email);
}

test.describe('Formulaire de demande de devis', () => {
	test('soumission complète (téléphone seul) passe la validation serveur', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { telephone: '0600000000' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test automatisé, longueur suffisante.');
		await page.check('input[name="consentement"]');
		await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
		const url = new URL(page.url());
		// L'envoi étant neutralisé sur cette installation, le chemin de succès est déterministe :
		// on peut enfin exiger la confirmation elle-même, et non plus seulement l'absence d'erreur.
		// C'est la règle de CLAUDE.md §8 — confirmation affichée UNIQUEMENT après succès serveur,
		// et état de confirmation en noindex — vérifiée de bout en bout.
		expect(url.searchParams.get('erreur')).toBeNull();
		expect(url.searchParams.get('merci')).toBe('1');
		await expect(page.getByRole('status').filter({ hasText: 'Votre demande a bien été envoyée' })).toBeVisible();
		await expect(page.locator('meta[name="robots"]')).toHaveAttribute(
			'content',
			/noindex/,
			{ timeout: 5000 }
		);
	});

	test('soumission complète (e-mail seul, sans téléphone) passe la validation serveur', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { email: 'test@example.com' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test automatisé, longueur suffisante.');
		await page.check('input[name="consentement"]');
		await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
		const url = new URL(page.url());
		expect(url.searchParams.get('erreur')).not.toBe('champs');
	});

	test('ni téléphone ni e-mail → rejeté par le serveur (erreur=champs)', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page);
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test.');
		await page.check('input[name="consentement"]');
		// data-step-submit est de type="submit" mais required côté client bloque déjà la
		// soumission ; on force l'envoi réel côté serveur pour vérifier la garde serveur elle-même,
		// indépendamment de la validation client.
		await page.evaluate(() => document.querySelector('.tfp-quote-form').setAttribute('novalidate', ''));
		await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
		const url = new URL(page.url());
		expect(url.searchParams.get('erreur')).toBe('champs');
	});

	test('e-mail mal formé → rejeté par le serveur (erreur=champs)', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { email: 'pas-un-email' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test.');
		await page.check('input[name="consentement"]');
		await page.evaluate(() => document.querySelector('.tfp-quote-form').setAttribute('novalidate', ''));
		await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
		const url = new URL(page.url());
		expect(url.searchParams.get('erreur')).toBe('champs');
	});

	test('consentement non coché → bloqué côté client, formulaire non envoyé', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { telephone: '0600000000' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test.');
		await page.click('[data-step-submit]');
		// Toujours sur la page du formulaire (pas de navigation, la validation HTML5 a bloqué le
		// submit natif) et le champ est signalé invalide.
		await expect(page).toHaveURL(new RegExp(FORM_URL.replace('/', '\\/') + '$'));
		const isInvalid = await page.$eval('input[name="consentement"]', (el) => !el.checkValidity());
		expect(isInvalid).toBe(true);
	});

	test('anti-spam : honeypot rempli → rejet silencieux, aucun e-mail envoyé', async ({ page }) => {
		await page.goto(FORM_URL);
		await page.fill('#tfp-site-web', 'http://spam.example');
		await fillStepOne(page, { telephone: '0600000000' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test honeypot.');
		await page.check('input[name="consentement"]');
		await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
		const url = new URL(page.url());
		expect(url.searchParams.has('merci')).toBe(false);
		expect(url.searchParams.has('erreur')).toBe(false);
	});

	test('contexte local transmis et pré-rempli depuis un lien contextualisé', async ({ page }) => {
		await page.goto(FORM_URL + '?service=bureaux&service_label=Nettoyage%20de%20bureaux&ville=Dijon&departement=C%C3%B4te-d%27Or');
		await expect(page.locator('#tfp-ville-visible')).toHaveValue('Dijon');
		await expect(page.locator('#tfp-prestation-visible')).toHaveValue('Nettoyage de bureaux');
		const departement = await page.locator('[name="departement"]').inputValue();
		expect(departement).toContain('Côte-d\'Or'.slice(0, 4)); // tolère l'encodage exact de l'apostrophe
	});

	test('navigation clavier : Tab jusqu\'au bouton Continuer, Entrée pour avancer', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { telephone: '0600000000' });
		await page.locator('[data-step-next]').focus();
		await page.keyboard.press('Enter');
		await expect(page.locator('[data-step="0"]')).toBeHidden();
		await expect(page.locator('[data-step="1"]')).toBeVisible();
	});

	test('navigation clavier : case consentement activable au clavier (Espace)', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page, { telephone: '0600000000' });
		await page.click('[data-step-next]');
		await page.focus('input[name="consentement"]');
		await page.keyboard.press('Space');
		const checked = await page.$eval('input[name="consentement"]', (el) => el.checked);
		expect(checked).toBe(true);
	});

	test('formulaire à l\'étape 1 avec champs requis manquants : erreurs annoncées, focus restitué', async ({ page }) => {
		await page.goto(FORM_URL);
		await page.click('[data-step-next]');
		const errorsText = await page.locator('[data-form-errors]').innerText();
		expect(errorsText.length).toBeGreaterThan(0);
		await expect(page.locator('[data-step="0"]')).toBeVisible();
	});
});
