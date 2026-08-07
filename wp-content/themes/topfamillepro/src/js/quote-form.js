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
	const prevBtn = form.querySelector('[data-step-prev]');
	const liveRegion = form.querySelector('[data-form-errors]');
	let current = 0;

	function showStep(index) {
		steps.forEach((step, i) => {
			step.hidden = i !== index;
		});
		if (prevBtn) prevBtn.hidden = index === 0;
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
		fields.forEach((field) => {
			field.setCustomValidity('');
			if (!field.checkValidity()) {
				const label = form.querySelector(`label[for="${field.id}"]`);
				const name = label ? label.textContent.replace('*', '').trim() : field.name;
				errors.push(`${name} : champ requis ou invalide.`);
				field.setAttribute('aria-invalid', 'true');
			} else {
				field.removeAttribute('aria-invalid');
			}
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
			showStep(current);
		});
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', () => {
			current = 0;
			showStep(current);
		});
	}

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
	const prestationVisible = form.querySelector('#tfp-prestation-visible');
	const prestationValue = params.get('prestation_label') || params.get('prestation');
	if (prestationVisible && prestationValue && !prestationVisible.value) {
		prestationVisible.value = prestationValue;
	}
}

document.addEventListener('DOMContentLoaded', tfpInitQuoteForm);
