// @ts-check
import { test, expect } from '@playwright/test';
import { banc, purgerLimiteDevis, saturerLimiteDevis } from './limite-banc.js';

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

// Série : le test du refus sature le compteur de l'IP du banc ; en parallèle, il ferait échouer
// les soumissions valides des autres tests du fichier. Aucun autre fichier ne soumet le devis.
test.describe.configure({ mode: 'serial' });

test.beforeEach(async ({ page }) => {
	purgerLimiteDevis();
	await page.goto(FORM_URL);
	test.skip(
		!(await envoiNeutralise(page)),
		"installation sans neutralisation d'envoi : soumettre expédierait un e-mail réel"
	);
});

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

	/*
	 * Gardes SERVEUR : le client bloque désormais ces cas lui-même (test suivant). Pour éprouver
	 * la garde serveur seule, l'envoi passe par HTMLFormElement.prototype.submit, qui ne déclenche
	 * pas l'événement `submit` — donc aucune validation client.
	 */
	async function envoyerSansClient(page, { telephone = '', email = '', codePostal = '' } = {}) {
		await fillStepOne(page, { telephone, email });
		await page.evaluate(() => document.querySelectorAll('[data-step]').forEach((f) => { f.hidden = false; }));
		if (codePostal) await page.fill('#tfp-code-postal', codePostal);
		await page.fill('#tfp-message', 'Message de test.');
		await page.check('input[name="consentement"]');
		await Promise.all([
			page.waitForNavigation(),
			page.evaluate(() => HTMLFormElement.prototype.submit.call(document.querySelector('.tfp-quote-form'))),
		]);
		return new URL(page.url());
	}

	test('ni téléphone ni e-mail → rejeté par le serveur (erreur=champs)', async ({ page }) => {
		await page.goto(FORM_URL);
		expect((await envoyerSansClient(page)).searchParams.get('erreur')).toBe('champs');
	});

	test('e-mail mal formé → rejeté par le serveur (erreur=champs)', async ({ page }) => {
		await page.goto(FORM_URL);
		expect((await envoyerSansClient(page, { email: 'pas-un-email' })).searchParams.get('erreur')).toBe('champs');
	});

	test('code postal de quatre chiffres → rejeté par le serveur (erreur=champs)', async ({ page }) => {
		await page.goto(FORM_URL);
		expect((await envoyerSansClient(page, { telephone: '0600000000', codePostal: '2185' })).searchParams.get('erreur')).toBe('champs');
	});

	test('validation client : contact, e-mail et code postal — messages français, focus sur le champ', async ({ page }) => {
		await page.goto(FORM_URL);
		await fillStepOne(page);
		await page.click('[data-step-next]');
		await expect(page.locator('[data-form-errors]')).toContainText('Téléphone ou e-mail');
		await expect(page.locator('#tfp-telephone')).toBeFocused();
		await expect(page.locator('#tfp-telephone')).toHaveAttribute('aria-invalid', 'true');
		await expect(page.locator('[data-step="1"]')).toBeHidden();

		await page.fill('#tfp-email', 'pas-un-email');
		await page.click('[data-step-next]');
		await expect(page.locator('[data-form-errors]')).toContainText('E-mail : adresse mal formée');
		await expect(page.locator('#tfp-email')).toBeFocused();

		await page.fill('#tfp-email', 'test@example.com');
		await page.fill('#tfp-ville-visible', 'Saint-Apollinaire');
		await page.click('[data-step-next]');
		await expect(page.locator('[data-step="1"]')).toBeVisible();
		await expect(page.locator('[data-quote-recap-text]')).toContainText('Saint-Apollinaire');
		await expect(page.locator('[data-quote-recap-text]')).toContainText('test@example.com');

		// Passe commerciale du 10 novembre 2026 : le code postal est à l'étape 2 (facultatif, cinq
		// chiffres s'il est saisi) ; l'erreur s'y affiche et le focus va au champ.
		await page.fill('#tfp-code-postal', '218');
		await page.fill('#tfp-message', 'Message de test automatisé.');
		await page.check('input[name="consentement"]');
		await page.click('[data-step-submit]');
		await expect(page.locator('[data-form-errors]')).toContainText('Code postal : cinq chiffres');
		await expect(page.locator('#tfp-code-postal')).toBeFocused();
		await expect(page.locator('[data-step="1"]')).toBeVisible();

		// Retour à l'étape 1 puis de nouveau à l'étape 2 : toutes les valeurs sont conservées.
		await page.fill('#tfp-code-postal', '21850');
		await page.locator('[data-step="1"] [data-step-prev]').first().click();
		await expect(page.locator('#tfp-email')).toHaveValue('test@example.com');
		await expect(page.locator('#tfp-type-locaux')).toHaveValue('bureaux');
		await page.click('[data-step-next]');
		await expect(page.locator('#tfp-code-postal')).toHaveValue('21850');
		await expect(page.locator('#tfp-message')).toHaveValue('Message de test automatisé.');
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

	test('limitation de fréquence : au-delà de 5 demandes par heure et par IP, refus serveur (erreur=limite)', async ({ page }) => {
		test.skip(!banc, 'saturation du compteur possible seulement sur le banc local (WP-CLI)');
		saturerLimiteDevis();
		try {
			await fillStepOne(page, { telephone: '0600000000' });
			await page.click('[data-step-next]');
			await page.fill('#tfp-message', 'Message de test : limitation de fréquence.');
			await page.check('input[name="consentement"]');
			await Promise.all([page.waitForNavigation(), page.click('[data-step-submit]')]);
			const url = new URL(page.url());
			expect(url.searchParams.get('erreur')).toBe('limite');
			expect(url.searchParams.has('merci')).toBe(false);
			await expect(page.getByRole('status').filter({ hasText: 'Votre demande a bien été envoyée' })).toHaveCount(0);
		} finally {
			purgerLimiteDevis();
		}
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

	test('étape 1 allégée : code postal et surface à l’étape 2, prestation non redemandée', async ({ page }) => {
		const etape1 = page.locator('[data-step="0"]');
		for (const id of ['#tfp-type-locaux', '#tfp-regime', '#tfp-ville-visible', '#tfp-nom', '#tfp-telephone', '#tfp-email']) {
			await expect(etape1.locator(id), id).toHaveCount(1);
		}
		for (const id of ['#tfp-code-postal', '#tfp-surface']) {
			await expect(etape1.locator(id), id).toHaveCount(0);
			await expect(page.locator('[data-step="1"]').locator(id), id).toHaveCount(1);
		}
		await expect(page.locator('#tfp-prestation-visible')).toHaveAttribute('type', 'hidden');
		// Aucun nouveau champ obligatoire : téléphone et e-mail restent facultatifs un par un.
		await expect(page.locator('#tfp-telephone')).not.toHaveAttribute('required', /.*/);
		await expect(page.locator('#tfp-email')).not.toHaveAttribute('required', /.*/);
		await expect(page.locator('[data-step="1"] .tfp-field__facultatif')).toHaveCount(5);
	});

	test('préremplissage serveur : prestation, type de locaux, régime, ville, département, UTM', async ({ page }) => {
		await page.goto(FORM_URL + '?service=ponctuel&ville=Beaune&departement=C%C3%B4te-d%27Or&utm_source=google&utm_medium=cpc&utm_campaign=beaune');
		await expect(page.locator('#tfp-type-locaux')).toHaveValue('ponctuel');
		await expect(page.locator('#tfp-regime')).toHaveValue('ponctuel');
		await expect(page.locator('#tfp-ville-visible')).toHaveValue('Beaune');
		await expect(page.locator('[name="utm_source"]')).toHaveValue('google');
		await expect(page.locator('[name="utm_medium"]')).toHaveValue('cpc');
		await expect(page.locator('[name="utm_campaign"]')).toHaveValue('beaune');
		expect(await page.locator('[name="departement"]').inputValue()).toMatch(/^Côte/);
		await page.goto(FORM_URL + '?service=commerces');
		await expect(page.locator('#tfp-type-locaux')).toHaveValue('commerces');
	});

	test('contexte local transmis et pré-rempli depuis un lien contextualisé', async ({ page }) => {
		await page.goto(FORM_URL + '?service=bureaux&service_label=Nettoyage%20de%20bureaux&ville=Dijon&departement=C%C3%B4te-d%27Or');
		await expect(page.locator('#tfp-ville-visible')).toHaveValue('Dijon');
		await expect(page.locator('#tfp-prestation-visible')).toHaveValue('Nettoyage de bureaux');
		const departement = await page.locator('[name="departement"]').inputValue();
		expect(departement).toContain('Côte-d\'Or'.slice(0, 4)); // tolère l'encodage exact de l'apostrophe
	});

	/*
	 * Recette du 12 novembre 2026 : la prestation reçue suit les DERNIERS choix du prospect, la
	 * prestation de la page d'origine est transmise à part. Le POST est intercepté pour lire
	 * exactement ce que le navigateur envoie.
	 */
	async function corpsEnvoye(page) {
		let corps = null;
		await page.route('**/wp-admin/admin-post.php', async (route) => {
			corps = new URLSearchParams(route.request().postData() || '');
			await route.fulfill({ status: 204, body: '' });
		});
		await page.fill('#tfp-message', 'Recette prestation.');
		await page.check('input[name="consentement"]');
		await page.click('[data-step-submit]');
		await expect.poll(() => corps).not.toBeNull();
		return corps;
	}

	test('prestation : Bureaux → Demander un devis → Commerce envoie Commerce, origine à part', async ({ page }) => {
		await page.goto('/prestations/bureaux/');
		await Promise.all([page.waitForURL(/demande-de-devis/), page.locator('a[href*="demande-de-devis/?service=bureaux"]').first().click()]);
		await expect(page.locator('#tfp-type-locaux')).toHaveValue('bureaux');
		await page.selectOption('#tfp-type-locaux', 'commerces');
		await page.selectOption('#tfp-regime', 'regulier');
		await page.fill('#tfp-nom', 'Test Automatisé');
		await page.fill('#tfp-email', 'test@example.com');
		await page.click('[data-step-next]');
		await expect(page.locator('[data-quote-recap-text]')).toContainText('Commerces');
		const corps = await corpsEnvoye(page);
		expect(corps.get('type_locaux')).toBe('commerces');
		expect(corps.get('prestation')).toBe('Nettoyage de commerces (entretien régulier)');
		expect(corps.get('prestation_origine')).toBe('Nettoyage de bureaux');
		expect(corps.get('page_origine')).toContain('/prestations/bureaux/');
	});

	test('prestation : accès direct, la prestation se déduit du type et du régime choisis', async ({ page }) => {
		await page.goto(FORM_URL);
		await expect(page.locator('#tfp-prestation-visible')).toHaveValue('');
		await page.selectOption('#tfp-type-locaux', 'cabinets');
		await page.selectOption('#tfp-regime', 'ponctuel');
		await expect(page.locator('#tfp-prestation-visible')).toHaveValue('Nettoyage de cabinets (intervention ponctuelle)');
		await page.fill('#tfp-nom', 'Test Automatisé');
		await page.fill('#tfp-telephone', '0600000000');
		await page.click('[data-step-next]');
		const corps = await corpsEnvoye(page);
		expect(corps.get('prestation')).toBe('Nettoyage de cabinets (intervention ponctuelle)');
		expect(corps.get('prestation_origine')).toBe('');
		// Surface et code postal laissés vides : facultatifs.
		expect(corps.get('surface')).toBe('');
		expect(corps.get('code_postal')).toBe('');
	});

	test('prestation : retour à l’étape 1 pour changer type et régime, la demande suit', async ({ page }) => {
		await page.goto(FORM_URL + '?service=ponctuel&service_label=Nettoyage%20ponctuel');
		await expect(page.locator('#tfp-prestation-visible')).toHaveValue('Nettoyage ponctuel');
		await page.fill('#tfp-nom', 'Test Automatisé');
		await page.fill('#tfp-telephone', '0600000000');
		await page.click('[data-step-next]');
		await page.click('[data-quote-recap] [data-step-prev]');
		await page.selectOption('#tfp-type-locaux', 'meubles');
		await page.selectOption('#tfp-regime', 'regulier');
		await page.click('[data-step-next]');
		await expect(page.locator('[data-quote-recap-text]')).toContainText('Location meublée');
		await expect(page.locator('[data-quote-recap-text]')).toContainText('Entretien régulier');
		const corps = await corpsEnvoye(page);
		expect(corps.get('regime')).toBe('regulier');
		expect(corps.get('prestation')).toBe('Nettoyage de locations meublées (entretien régulier)');
		expect(corps.get('prestation_origine')).toBe('Nettoyage ponctuel');
	});

	test('département : retiré si le prospect saisit une autre ville que celle de la page', async ({ page }) => {
		await page.goto(FORM_URL + '?ville=Vesoul&departement=Haute-Sa%C3%B4ne');
		await expect(page.locator('[name="departement"]')).toHaveValue('Haute-Saône');
		await page.fill('#tfp-ville-visible', 'Dijon');
		await expect(page.locator('[name="departement"]')).toHaveValue('');
		await page.fill('#tfp-ville-visible', 'Vesoul');
		await expect(page.locator('[name="departement"]')).toHaveValue('Haute-Saône');
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
