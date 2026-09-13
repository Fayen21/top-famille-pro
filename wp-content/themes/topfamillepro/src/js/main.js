import './nav.js';
import './quote-form.js';
import './analytics.js';

/*
 * Prévention du double envoi.
 *
 * Un formulaire soumis deux fois — double clic, ou clic pendant que la page part — envoie deux
 * messages identiques. Le bouton porteur de `data-tfp-once` se désactive au premier envoi, et son
 * libellé annonce l'état en cours : « Envoi… » plutôt qu'un bouton grisé sans explication.
 *
 * La désactivation intervient **après** la validation native du navigateur, dans `submit` : si le
 * formulaire est invalide, l'événement n'est pas émis et le bouton reste utilisable.
 */
document.addEventListener('submit', (evenement) => {
	const formulaire = evenement.target;
	if (!(formulaire instanceof HTMLFormElement)) return;
	/*
	 * Une soumission annulée n'est pas une soumission : le formulaire de devis valide ses deux
	 * étapes dans son propre écouteur et appelle `preventDefault()` quand un champ manque. Ce
	 * gestionnaire-ci écoute sur le document, donc après lui — sans ce contrôle, il désactiverait
	 * le bouton d'un formulaire qui n'est jamais parti, et le visiteur serait bloqué.
	 */
	if (evenement.defaultPrevented) return;
	const bouton = formulaire.querySelector('[data-tfp-once]');
	if (!bouton || bouton.disabled) return;

	bouton.dataset.libelle = bouton.textContent;
	bouton.textContent = 'Envoi…';
	bouton.setAttribute('aria-busy', 'true');
	// Différé d'un tour de boucle : désactiver un bouton avant la soumission empêcherait le
	// navigateur d'inclure sa valeur dans les données envoyées.
	window.setTimeout(() => {
		bouton.disabled = true;
	}, 0);
});
