/**
 * Couche de données analytique neutre (CLAUDE.md §6 : aucun outil de tracking installé tant que
 * son identifiant et les règles de consentement ne sont pas fournis).
 *
 * Empile des événements structurés dans `window.dataLayer`, un simple tableau JavaScript qu'un
 * futur outil de mesure (une fois choisi et configuré avec consentement) pourra lire — cette
 * couche ne charge, n'appelle et ne transmet rien à un service tiers.
 *
 * Événements (brief phase 4) : quote_start, quote_step_1_complete, quote_submit, quote_success,
 * quote_error, phone_click, email_click, local_cta_click.
 */

window.dataLayer = window.dataLayer || [];

function tfpTrack(event, detail) {
	window.dataLayer.push(Object.assign({ event: event }, detail || {}));
}

function tfpInitAnalytics() {
	document.addEventListener('click', (event) => {
		const telLink = event.target.closest('a[href^="tel:"]');
		if (telLink) {
			tfpTrack('phone_click', { href: telLink.getAttribute('href'), page: window.location.pathname });
			return;
		}

		const mailLink = event.target.closest('a[href^="mailto:"]');
		if (mailLink) {
			tfpTrack('email_click', { href: mailLink.getAttribute('href'), page: window.location.pathname });
			return;
		}

		// CTA "Demander un devis" contextualisé (query string : prestation/ville/département portés
		// par le lien, voir single-prestation.php/single-zone.php) — distinct des CTA génériques.
		const localCta = event.target.closest('a[href*="/demande-de-devis/"][href*="?"]');
		if (localCta) {
			tfpTrack('local_cta_click', { href: localCta.getAttribute('href'), page: window.location.pathname });
		}
	});

	const form = document.querySelector('[data-tfp-analytics="quote"]');
	if (form) {
		let started = false;
		form.addEventListener(
			'focusin',
			() => {
				if (started) return;
				started = true;
				tfpTrack('quote_start');
			},
			{ passive: true }
		);

		const nextBtn = form.querySelector('[data-step-next]');
		if (nextBtn) {
			nextBtn.addEventListener('click', () => {
				// setTimeout(0) : laisse d'abord src/js/quote-form.js valider l'étape 1 et, seulement
				// si elle est valide, masquer le fieldset — l'événement ne doit être empilé que si le
				// passage à l'étape 2 a réellement eu lieu, pas à chaque clic sur « Continuer ».
				setTimeout(() => {
					const step0 = form.querySelector('[data-step="0"]');
					if (step0 && step0.hidden) {
						tfpTrack('quote_step_1_complete');
					}
				}, 0);
			});
		}

		form.addEventListener('submit', (event) => {
			if (event.defaultPrevented) return; // validation côté client a bloqué l'envoi
			tfpTrack('quote_submit');
		});
	}

	// Succès/erreur : détectés au chargement de la page de confirmation, après une redirection
	// serveur réelle (includes/quote-form.php) — jamais un état simulé côté client seul.
	const params = new URLSearchParams(window.location.search);
	if (params.has('merci')) {
		tfpTrack('quote_success');
	} else if (params.has('erreur')) {
		tfpTrack('quote_error', { reason: params.get('erreur') });
	}
}

document.addEventListener('DOMContentLoaded', tfpInitAnalytics);
