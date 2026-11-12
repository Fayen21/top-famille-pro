/* Mode démonstration du paquet navigable : aucun envoi, aucun e-mail, aucun événement de conversion. */
document.addEventListener('submit', function (e) {
	var form = e.target;
	if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-tfp-demo')) return;
	// Envoi déjà refusé par la validation du thème (src/js/quote-form.js) : rien à simuler.
	var refuse = e.defaultPrevented;
	e.preventDefault();
	if (refuse) return;
	// Formulaire sans validation scriptée (contact) : contrôles natifs du navigateur.
	if (!form.checkValidity()) { form.reportValidity(); return; }
	/*
	 * Verrou anti-double-envoi du thème (src/js/main.js) : il pose « Envoi… » tout de suite et
	 * désactive le bouton au tour de boucle suivant. Le rétablir ici, de façon synchrone, ne
	 * servait à rien : la désactivation arrivait après. On le rétablit donc APRÈS elle, au tour
	 * suivant, pour pouvoir valider, modifier et valider de nouveau sans recharger la page.
	 * Sur le site réel, ce script n'existe pas : le verrou reste entier.
	 */
	var bouton = form.querySelector('[data-tfp-once]');
	if (bouton) {
		window.setTimeout(function () {
			bouton.disabled = false;
			bouton.removeAttribute('aria-busy');
			if (bouton.dataset.libelle) bouton.textContent = bouton.dataset.libelle;
		}, 0);
	}
	var ancien = form.querySelector('[data-tfp-demo-confirmation]');
	if (ancien) ancien.remove();
	var message = document.createElement('div');
	message.className = 'tfp-form-notice tfp-form-notice--demo';
	message.setAttribute('role', 'status');
	message.setAttribute('tabindex', '-1');
	message.setAttribute('data-tfp-demo-confirmation', '');
	message.innerHTML = '<strong>Confirmation simulée (démonstration)</strong> — sur le site réel, votre demande serait transmise à Top-Famille Pro. Ici, aucune donnée n’a été envoyée et aucun e-mail n’est parti.';
	form.insertBefore(message, form.firstChild);
	message.focus();
}, false);
