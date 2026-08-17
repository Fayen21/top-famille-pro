// @ts-check
import { test, expect } from '@playwright/test';

const FORM_URL = '/demande-de-devis/';

async function fillStepOne(page, { telephone = '', email = '' } = {}) {
	await page.selectOption('#tfp-type-locaux', 'bureaux');
	await page.selectOption('#tfp-regime', 'regulier');
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
		// L'environnement de test n'a pas de transport mail (erreur=envoi attendue) : ce qui compte
		// ici est que la validation ait été franchie, pas que wp_mail() réussisse.
		expect(url.searchParams.get('erreur')).not.toBe('champs');
		expect(url.searchParams.get('erreur')).not.toBe('session');
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
	test('double envoi : le bouton se neutralise dès la première soumission valide', async ({ page }) => {
		/*
		 * Le formulaire de devis ne portait PAS `data-tfp-once` avant G26 §6 : seul celui de contact
		 * l'avait, et un double clic produisait deux demandes identiques dans la boîte d'Audrey.
		 *
		 * La réponse au POST est un 204 : la soumission part réellement — donc le gestionnaire
		 * s'exécute — mais le navigateur ne quitte pas le document, ce qui laisse observer l'état du
		 * bouton. Annuler l'événement à la place mesurerait le contrôle « soumission annulée », pas
		 * le comportement d'un envoi valide.
		 */
		await page.goto(FORM_URL);
		await page.route('**/*', (route) =>
			'POST' === route.request().method() ? route.fulfill({ status: 204, body: '' }) : route.continue()
		);
		await fillStepOne(page, { telephone: '0600000000' });
		await page.click('[data-step-next]');
		await page.fill('#tfp-message', 'Message de test automatisé, longueur suffisante.');
		await page.check('input[name="consentement"]');
		await page.click('[data-step-submit]');
		await page.waitForTimeout(200);

		const etat = await page.evaluate(() => {
			const b = document.querySelector('[data-step-submit]');
			return { desactive: b.disabled, occupe: b.getAttribute('aria-busy'), libelle: b.textContent.trim() };
		});
		expect(etat.desactive, 'le bouton doit être neutralisé après la première soumission').toBe(true);
		expect(etat.occupe).toBe('true');
		expect(etat.libelle).toMatch(/envoi/i);
	});

	test('une étape 1 incomplète ne neutralise pas le bouton d’envoi', async ({ page }) => {
		// Le pendant du test précédent : le gestionnaire anti-double-envoi ignore une soumission
		// annulée par la validation. Sans ce contrôle, un formulaire incomplet laissait le visiteur
		// devant un bouton grisé, sans moyen de corriger et de renvoyer.
		await page.goto(FORM_URL);
		await page.evaluate(() => {
			document.querySelectorAll('[data-step]').forEach((f) => {
				f.hidden = false;
			});
		});
		await page.click('[data-step-submit]');
		await page.waitForTimeout(200);
		const desactive = await page.evaluate(() => document.querySelector('[data-step-submit]').disabled);
		expect(desactive, 'le bouton reste utilisable tant que la demande n’est pas partie').toBe(false);
	});
});
