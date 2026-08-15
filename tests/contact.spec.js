/**
 * Page Contact — composants relevés sur la maquette, et sécurité réelle du formulaire court.
 *
 * Deux choses sont vérifiées ici, et elles ne se recouvrent pas :
 *
 *  1. la **fidélité** : sept cartes, dans leur ordre, aux six largeurs, plus le formulaire que la
 *     maquette place à droite des coordonnées et qui manquait ;
 *  2. la **sécurité** : nonce, honeypot, limitation, consentement, validation serveur. Une
 *     validation client ne protège de rien — un automate ne l'exécute pas.
 *
 * Garde-fou d'envoi : aucun test ne soumet quoi que ce soit tant que le formulaire ne porte pas
 * `data-tfp-mail-disabled`, que le thème n'émet qu'en environnement `local` ou `development`. Sur
 * une installation réelle, les tests de soumission se sautent d'eux-mêmes plutôt que de faire
 * partir un e-mail à Audrey.
 */
import { test, expect } from '@playwright/test';

const PAGE = '/contact/';
const LARGEURS = [320, 375, 768, 1024, 1440, 1920];

/** L'installation testée neutralise-t-elle l'envoi d'e-mail ? */
async function envoiNeutralise(page) {
	return (await page.locator('.tfp-contact-form[data-tfp-mail-disabled]').count()) > 0;
}

/**
 * Soumet le formulaire en contournant la validation **client** — le but est d'atteindre la garde
 * serveur, pas de vérifier que le navigateur bloque.
 */
async function soumettre(page, valeurs = {}) {
	await page.evaluate((v) => {
		const f = document.querySelector('.tfp-contact-form');
		f.setAttribute('novalidate', '');
		for (const [nom, valeur] of Object.entries(v)) {
			const champ = f.querySelector(`[name="${nom}"]`);
			if (!champ) continue;
			if (champ.type === 'checkbox') champ.checked = Boolean(valeur);
			else champ.value = valeur;
		}
	}, valeurs);
	await Promise.all([page.waitForNavigation(), page.locator('.tfp-contact-form button[type="submit"]').click()]);
}

test.describe('Contact — cartes de la maquette', () => {
	test('sept cartes, dans l’ordre relevé sur la maquette', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

		const cartes = await page.locator('.tfp-card-tile').allInnerTexts();
		expect(cartes.length, `attendu 7 cartes, ${cartes.length} rendue(s)`).toBe(7);

		const attendu = [
			/J’ai une question/,
			/J’ai un besoin de nettoyage/,
			/Téléphone/,
			/E-mail/,
			/Implantation/,
			/Horaires de contact/,
			/sur Google|HT\/h/,
		];
		attendu.forEach((motif, i) => {
			expect(cartes[i].replace(/\s+/g, ' '), `carte ${i + 1} inattendue`).toMatch(motif);
		});
	});

	test('les coordonnées affichées sont celles du thème, jamais recopiées', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		const texte = await page.locator('.tfp-card-grid').allInnerTexts();
		const joint = texte.join(' ');
		expect(joint).toContain('06 36 17 63 39');
		expect(joint).toContain('audrey.b@top-famille.fr');
		expect(joint).toContain('Saint-Apollinaire');
		// Un seul établissement : aucune agence, aucun second numéro local.
		expect(joint).not.toMatch(/agence/i);
	});

	test('les horaires sont affichés, marqués provisoires, et absents des données structurées', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

		const carte = page.locator('li[data-tfp-provisional]', { hasText: 'Horaires de contact' });
		await expect(carte, 'la carte horaires doit être marquée provisoire').toHaveCount(1);

		const mention = carte.locator('[data-tfp-provisional-notice]');
		await expect(mention, 'la mention provisoire doit être visible du visiteur').toBeVisible();

		// Une amplitude non confirmée déclarée en donnée structurée est un engagement opposable.
		const graphe = await page.evaluate(() =>
			[...document.querySelectorAll('script[type="application/ld+json"]')].map((s) => s.textContent).join(' ')
		);
		expect(graphe, 'aucune amplitude horaire ne doit être déclarée').not.toMatch(/openingHours/i);
		expect(graphe).not.toMatch(/"@type"\s*:\s*"(Review|AggregateRating)"/);
	});
});

test.describe('Contact — formulaire court', () => {
	test('le formulaire est présent, distinct du formulaire de devis, et complet', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

		const form = page.locator('.tfp-contact-form');
		await expect(form).toHaveCount(1);
		// Les deux parcours coexistent : la page renvoie vers le devis sans le remplacer.
		await expect(page.locator('.tfp-quote-form'), 'le devis ne doit pas être embarqué ici').toHaveCount(0);
		await expect(page.locator('a[href$="/demande-de-devis/"]').first()).toBeVisible();

		// Action côté serveur, pas un envoi simulé en JavaScript.
		expect(await form.getAttribute('action')).toContain('admin-post.php');
		expect(await form.getAttribute('method')).toMatch(/post/i);
		await expect(form.locator('input[name="action"][value="tfp_submit_contact"]')).toHaveCount(1);
	});

	test('ordre des champs et libellés, tels que relevés sur la maquette', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

		const champs = await page.evaluate(() =>
			[...document.querySelectorAll('.tfp-contact-form input, .tfp-contact-form select, .tfp-contact-form textarea')]
				.filter((c) => c.type !== 'hidden' && !c.closest('.tfp-honeypot'))
				.map((c) => ({
					nom: c.name,
					type: c.tagName === 'INPUT' ? c.type : c.tagName.toLowerCase(),
					requis: c.required,
					// Nom accessible : le `label` associé, pas un `placeholder`.
					label: (document.querySelector(`label[for="${c.id}"]`)?.textContent || '').replace(/\s+/g, ' ').trim(),
				}))
		);

		expect(champs.map((c) => c.nom)).toEqual([
			'tfp_contact_nom',
			'tfp_contact_entreprise',
			'tfp_contact_email',
			'tfp_contact_telephone',
			'tfp_contact_objet',
			'tfp_contact_message',
			'tfp_contact_consentement',
		]);

		expect(champs.map((c) => c.label)).toEqual([
			'Nom *',
			'Entreprise (facultatif)',
			'E-mail *',
			'Téléphone (facultatif)',
			'Objet *',
			'Message *',
			'J’accepte que mes informations soient utilisées pour me répondre.',
		]);

		// Types utiles au clavier logiciel mobile et à l'autocomplétion.
		expect(champs.map((c) => c.type)).toEqual(['text', 'text', 'email', 'tel', 'select', 'textarea', 'checkbox']);

		// Obligatoires : nom, e-mail, objet, message, consentement — jamais entreprise ni téléphone.
		expect(champs.filter((c) => c.requis).map((c) => c.nom)).toEqual([
			'tfp_contact_nom',
			'tfp_contact_email',
			'tfp_contact_objet',
			'tfp_contact_message',
			'tfp_contact_consentement',
		]);

		// Cinq objets, ceux de la maquette.
		expect(await page.locator('#contact-objet option').count()).toBe(5);
	});

	test('un nonce et un honeypot réellement hors du parcours', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

		const nonce = await page.locator('input[name="tfp_contact_nonce"]').getAttribute('value');
		expect(nonce, 'nonce absent').toBeTruthy();
		expect(nonce.length).toBeGreaterThan(5);

		const piege = page.locator('.tfp-honeypot');
		await expect(piege).toHaveCount(1);
		await expect(piege).toHaveAttribute('aria-hidden', 'true');
		await expect(piege.locator('input')).toHaveAttribute('tabindex', '-1');
		// Il doit rester dans le flux : `display:none` est détecté par les automates.
		const masquePar = await piege.evaluate((el) => getComputedStyle(el).display);
		expect(masquePar).not.toBe('none');
		// Mais hors de l'écran, et hors du parcours clavier.
		const dansLEcran = await piege.evaluate((el) => {
			const r = el.getBoundingClientRect();
			return r.right > 0 && r.bottom > 0 && r.left < innerWidth && r.top < innerHeight;
		});
		expect(dansLEcran, 'le honeypot ne doit pas être visible à l’écran').toBe(false);
	});

	test('navigation clavier : chaque champ est atteignable et le focus est visible', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		await page.locator('#contact-nom').focus();

		const atteints = ['contact-nom'];
		for (let i = 0; i < 8 && atteints[atteints.length - 1] !== 'contact-consentement'; i++) {
			await page.keyboard.press('Tab');
			atteints.push(await page.evaluate(() => document.activeElement.id || document.activeElement.tagName));
		}

		for (const id of ['contact-entreprise', 'contact-email', 'contact-telephone', 'contact-objet', 'contact-message', 'contact-consentement']) {
			expect(atteints, `${id} n’est pas atteignable au clavier depuis le champ Nom`).toContain(id);
		}
		// Le honeypot ne doit jamais recevoir le focus.
		expect(atteints).not.toContain('tfp_contact_site');

		// Le bouton suit, et son focus se voit.
		await page.keyboard.press('Tab');
		const contour = await page.evaluate(() => {
			const s = getComputedStyle(document.activeElement, ':focus-visible');
			return { outline: s.outlineWidth, ombre: s.boxShadow };
		});
		expect(
			parseFloat(contour.outline) > 0 || contour.ombre !== 'none',
			'le focus du bouton d’envoi doit être visible'
		).toBe(true);
	});

	for (const largeur of LARGEURS) {
		test(`responsive ${largeur} px : formulaire utilisable, sans débordement`, async ({ page }) => {
			await page.setViewportSize({ width: largeur, height: 900 });
			await page.goto(PAGE, { waitUntil: 'domcontentloaded' });

			const debordement = await page.evaluate(
				() => document.documentElement.scrollWidth - document.documentElement.clientWidth
			);
			expect(debordement, `débordement horizontal de ${debordement} px à ${largeur} px`).toBeLessThanOrEqual(1);

			// Chaque champ tient dans la largeur de son formulaire.
			const trop = await page.evaluate(() => {
				const f = document.querySelector('.tfp-contact-form');
				const cadre = f.getBoundingClientRect();
				return [...f.querySelectorAll('input:not([tabindex="-1"]), select, textarea, button')]
					.filter((c) => c.type !== 'hidden')
					.filter((c) => c.getBoundingClientRect().right > cadre.right + 1)
					.map((c) => c.name || c.tagName);
			});
			expect(trop, `champs débordant du formulaire à ${largeur} px`).toEqual([]);

			/*
			 * Cible de pointage — critère AA 2.5.8, pas le critère AAA 2.5.5 : 24 × 24 px **ou**
			 * l'exception d'espacement (un cercle de 24 px centré sur la cible n'en croise pas un
			 * autre). La case de consentement fait 18 px, comme dans la maquette, et satisfait la
			 * seconde condition : c'est la seule cible de sa zone. Même règle que
			 * tools/audit-target-size.mjs, appliquée ici aux commandes du formulaire.
			 */
			const petits = await page.evaluate(() => {
				const cibles = [
					...document.querySelectorAll(
						'.tfp-contact-form button, .tfp-contact-form input:not([type="hidden"]), .tfp-contact-form select, .tfp-contact-form textarea, .tfp-contact-form a'
					),
				]
					.filter((c) => !c.closest('.tfp-honeypot'))
					.map((c) => ({ nom: c.name || c.tagName.toLowerCase(), r: c.getBoundingClientRect() }))
					.filter((c) => c.r.width > 0 && c.r.height > 0);

				const centre = (r) => ({ x: r.left + r.width / 2, y: r.top + r.height / 2 });
				return cibles
					.filter((c) => c.r.width < 24 || c.r.height < 24)
					.filter((c) => {
						const a = centre(c.r);
						// Espacement suffisant si aucune autre cible n'a son centre à moins de 24 px.
						return cibles.some((autre) => {
							if (autre === c) return false;
							const b = centre(autre.r);
							return Math.hypot(a.x - b.x, a.y - b.y) < 24;
						});
					})
					.map((c) => c.nom);
			});
			expect(petits, `cibles < 24 px et trop rapprochées à ${largeur} px`).toEqual([]);
		});
	}
});

test.describe('Contact — validation serveur', () => {
	test('la soumission est neutralisée sur cette installation', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		expect(
			await envoiNeutralise(page),
			'Les tests de soumission exigent une installation local/development : ' +
				'aucun test ne doit faire partir un e-mail réel.'
		).toBe(true);
	});

	test('champs vides → refus serveur, erreurs annoncées, saisie conservée', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		await soumettre(page, { tfp_contact_nom: '', tfp_contact_email: '', tfp_contact_message: '' });

		expect(new URL(page.url()).searchParams.get('contact')).toBe('erreur');
		// L'erreur est annoncée, pas seulement colorée.
		await expect(page.locator('[role="alert"]')).toBeVisible();
		await expect(page.locator('#err-nom')).toBeVisible();
		await expect(page.locator('#err-email')).toBeVisible();
		await expect(page.locator('#err-message')).toBeVisible();
		await expect(page.locator('#contact-nom')).toHaveAttribute('aria-invalid', 'true');
		await expect(page.locator('#contact-nom')).toHaveAttribute('aria-describedby', 'err-nom');
	});

	test('sans consentement → refus, même avec tous les autres champs valides', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		await soumettre(page, {
			tfp_contact_nom: 'Test Automatisé',
			tfp_contact_email: 'test@example.com',
			tfp_contact_message: 'Message de test automatisé, longueur suffisante.',
			tfp_contact_objet: 'tarifs',
			tfp_contact_consentement: false,
		});

		expect(new URL(page.url()).searchParams.get('contact')).toBe('erreur');
		await expect(page.locator('#err-consentement')).toBeVisible();
		// La saisie n'est pas perdue : perdre un message rédigé fait perdre le contact.
		await expect(page.locator('#contact-nom')).toHaveValue('Test Automatisé');
		await expect(page.locator('#contact-message')).toHaveValue(/longueur suffisante/);
	});

	test('nonce invalide → refus, sans traitement', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		await page.evaluate(() => {
			document.querySelector('input[name="tfp_contact_nonce"]').value = 'faux';
		});
		await soumettre(page, {
			tfp_contact_nom: 'Test Automatisé',
			tfp_contact_email: 'test@example.com',
			tfp_contact_message: 'Message de test automatisé, longueur suffisante.',
			tfp_contact_objet: 'tarifs',
			tfp_contact_consentement: true,
		});

		expect(new URL(page.url()).searchParams.get('contact')).toBe('erreur-securite');
	});

	test('honeypot rempli → réponse identique à un succès, sans rien traiter', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		await soumettre(page, {
			tfp_contact_site: 'automate',
			tfp_contact_nom: 'Automate',
			tfp_contact_email: 'bot@example.com',
			tfp_contact_message: 'Message envoyé par un automate de test.',
			tfp_contact_objet: 'autre',
			tfp_contact_consentement: true,
		});

		// Répondre « envoyé » à un automate évite de lui apprendre qu'il a été repéré.
		expect(new URL(page.url()).searchParams.get('contact')).toBe('envoye');
	});

	test('soumission valide → confirmation affichée après retour serveur', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		await soumettre(page, {
			tfp_contact_nom: 'Test Automatisé',
			tfp_contact_email: 'test@example.com',
			tfp_contact_message: 'Message de test automatisé, longueur suffisante.',
			tfp_contact_objet: 'prestation',
			tfp_contact_consentement: true,
		});

		expect(new URL(page.url()).searchParams.get('contact')).toBe('envoye');
		await expect(page.locator('[role="status"]')).toBeVisible();
		await expect(page.locator('[role="status"]')).toContainText('Message envoyé');
	});

	test('double envoi : le bouton se neutralise dès la première soumission', async ({ page }) => {
		await page.goto(PAGE, { waitUntil: 'domcontentloaded' });
		test.skip(!(await envoiNeutralise(page)), 'installation réelle : soumission non testée');

		// La soumission est interceptée : on observe l'état du bouton sans partir sur le serveur.
		const etat = await page.evaluate(() => {
			const f = document.querySelector('.tfp-contact-form');
			f.addEventListener('submit', (e) => e.preventDefault(), { capture: false });
			f.querySelector('#contact-nom').value = 'Test';
			f.querySelector('#contact-email').value = 'test@example.com';
			f.querySelector('#contact-message').value = 'Message de test suffisamment long.';
			f.querySelector('#contact-consentement').checked = true;
			f.requestSubmit(f.querySelector('button[type="submit"]'));
			return new Promise((r) =>
				setTimeout(() => {
					const b = f.querySelector('button[type="submit"]');
					r({ desactive: b.disabled, occupe: b.getAttribute('aria-busy'), libelle: b.textContent.trim() });
				}, 60)
			);
		});

		expect(etat.desactive, 'le bouton doit être neutralisé après la première soumission').toBe(true);
		expect(etat.occupe).toBe('true');
		expect(etat.libelle).toMatch(/envoi/i);
	});
});
