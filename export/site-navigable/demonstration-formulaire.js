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
	var bouton = form.querySelector('[data-tfp-once]');
	if (bouton) {
		bouton.disabled = false;
		bouton.removeAttribute('aria-busy');
		if (bouton.dataset.libelle) bouton.textContent = bouton.dataset.libelle;
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
