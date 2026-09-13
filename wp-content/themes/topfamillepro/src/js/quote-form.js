/**
 * Formulaire de demande de devis (/demande-de-devis/) — CLAUDE.md §8.
 *
 * Un seul <form>, deux <fieldset> : les données restent dans le DOM en permanence (« conservées
 * entre les étapes » sans état JS à synchroniser), la navigation entre étapes n'est qu'un
 * changement d'affichage. Sans JavaScript, les deux étapes restent visibles et le formulaire
 * complet reste soumissible en une fois — dégradation correcte plutôt que blocage.
 */

function tfpInitQuoteForm() {
	const form = document.querySelector('.tfp-quote-form');
	if (!form) return;

	const steps = Array.from(form.querySelectorAll('[data-step]'));
	if (steps.length < 2) return;

	const nextBtn = form.querySelector('[data-step-next]');
	// Deux commandes ramènent à l'étape 1 : le bouton de la rangée de commandes et le lien du
	// résumé. Elles portent le même attribut et se comportent de la même façon.
	const prevBtns = Array.from(form.querySelectorAll('[data-step-prev]'));
	const liveRegion = form.querySelector('[data-form-errors]');
	const recap = form.querySelector('[data-quote-recap]');
	const recapText = form.querySelector('[data-quote-recap-text]');
	let current = 0;

	/**
	 * Résume l'étape 1 à partir des champs eux-mêmes.
	 *
	 * Rien n'est reconstitué ni deviné : on lit ce que le visiteur a saisi, dans l'ordre où il l'a
	 * saisi. Si aucun des trois champs n'est renseigné — cas impossible en usage normal, les deux
	 * premiers étant obligatoires — le résumé reste masqué plutôt que d'afficher une phrase vide.
	 */
	function updateRecap() {
		if (!recap || !recapText) return;
		const lire = (selector) => {
			const el = form.querySelector(selector);
			if (!el || !el.value) return '';
			if (el.tagName === 'SELECT') {
				const opt = el.options[el.selectedIndex];
				return opt ? opt.textContent.trim() : '';
			}
			return el.value.trim();
		};
		const parts = [lire('#tfp-type-locaux'), lire('#tfp-regime'), lire('#tfp-ville-visible')].filter(Boolean);
		if (!parts.length) {
			recap.hidden = true;
			return;
		}
		recapText.textContent = `Étape 1 renseignée : ${parts.join(' · ')}. `;
		recap.hidden = false;
	}

	function showStep(index) {
		steps.forEach((step, i) => {
			step.hidden = i !== index;
		});
		prevBtns.forEach((btn) => {
			btn.hidden = index === 0;
		});
		if (nextBtn) nextBtn.hidden = index !== 0;
		const submitBtn = form.querySelector('[data-step-submit]');
		if (submitBtn) submitBtn.hidden = index === 0;
		const first = steps[index].querySelector('input, textarea, select');
		if (first) first.focus();
	}

	function announce(messages) {
		if (!liveRegion) return;
		liveRegion.textContent = '';
		if (messages.length) {
			liveRegion.textContent = messages.join(' ');
		}
	}

	function validateStep(index) {
		const fields = steps[index].querySelectorAll('[required]');
		const errors = [];
		const reportedRadioGroups = new Set();
		fields.forEach((field) => {
			field.setCustomValidity('');
			if (field.checkValidity()) {
				field.removeAttribute('aria-invalid');
				return;
			}
			let name = field.name;
			if (field.type === 'radio') {
				// Un groupe de boutons radio requis échoue sur chaque bouton tant qu'aucun n'est
				// coché : ne signaler le groupe qu'une seule fois, via son <legend>.
				if (reportedRadioGroups.has(field.name)) return;
				reportedRadioGroups.add(field.name);
				const fieldset = field.closest('fieldset');
				const legend = fieldset && fieldset.querySelector('legend');
				if (legend) name = legend.textContent;
			} else {
				const explicitLabel = field.id && form.querySelector(`label[for="${field.id}"]`);
				const implicitLabel = field.closest('label');
				const label = explicitLabel || implicitLabel;
				if (label) name = label.textContent;
			}
			errors.push(`${name.replace('*', '').trim()} : champ requis ou invalide.`);
			field.setAttribute('aria-invalid', 'true');
		});
		return errors;
	}

	if (nextBtn) {
		nextBtn.addEventListener('click', () => {
			const errors = validateStep(0);
			if (errors.length) {
				announce(errors);
				return;
			}
			announce([]);
			current = 1;
			updateRecap();
			showStep(current);
		});
	}

	prevBtns.forEach((btn) => {
		btn.addEventListener('click', () => {
			current = 0;
			showStep(current);
		});
	});

	form.addEventListener('submit', (event) => {
		const errorsStep0 = validateStep(0);
		const errorsStep1 = validateStep(1);
		const errors = errorsStep0.concat(errorsStep1);
		if (errors.length) {
			event.preventDefault();
			announce(errors);
			if (errorsStep0.length) {
				current = 0;
				showStep(current);
			}
		}
	});

	showStep(current);

	// Contexte visiteur : URL courante, référent, prestation/ville pré-remplies depuis les query
	// params (les pages prestation/zone peuvent lier vers /demande-de-devis/?prestation=X&ville=Y).
	const params = new URLSearchParams(window.location.search);
	const setHidden = (name, value) => {
		const field = form.querySelector(`[name="${name}"]`);
		if (field && value) field.value = value;
	};
	setHidden('page_origine', document.referrer || '');
	setHidden('referent', document.referrer || '');
	setHidden('ville', params.get('ville') || '');
	setHidden('departement', params.get('departement') || '');
	setHidden('utm_source', params.get('utm_source') || '');
	setHidden('utm_medium', params.get('utm_medium') || '');
	setHidden('utm_campaign', params.get('utm_campaign') || '');

	// Préremplissage visible du champ prestation (libellé lisible si fourni, sinon le slug brut).
	// Paramètres d'URL nommés "service"/"service_label", pas "prestation" : ce dernier est le
	// query_var natif du CPT `prestation` et détournerait la requête principale de WordPress si un
	// lien externe l'utilisait (voir le commentaire dans single-prestation.php).
	const prestationVisible = form.querySelector('#tfp-prestation-visible');
	const prestationValue = params.get('service_label') || params.get('service');
	if (prestationVisible && prestationValue && !prestationVisible.value) {
		prestationVisible.value = prestationValue;
	}
}

document.addEventListener('DOMContentLoaded', tfpInitQuoteForm);
