/**
 * Filtres par thème de l'index Conseils (/conseils/) — amélioration progressive.
 *
 * Le serveur rend une liste de thèmes non interactive : sans JavaScript, tous les articles sont
 * affichés et rien ne ressemble à une commande. Ici, chaque thème devient un bouton `aria-pressed` ;
 * un clic masque les cartes d'un autre thème (attribut `hidden`), masque une section vidée et
 * annonce le nombre d'articles affichés dans une région live.
 */

function tfpInitConseilsFiltres() {
	const liste = document.querySelector('[data-tfp-filtres]');
	if (!liste) return;
	const cartes = Array.from(document.querySelectorAll('.tfp-article-card[data-tfp-theme]'));
	const sections = Array.from(document.querySelectorAll('[data-tfp-filtre-section]'));
	const statut = document.querySelector('[data-tfp-filtres-statut]');
	const boutons = [];

	// La liste garde sa sémantique de liste (un `role="group"` la cassait : axe « listitem ») ;
	// seul son nom change, pour dire ce que font désormais ses boutons.
	liste.setAttribute('aria-label', 'Filtrer les articles par thème');

	const appliquer = (theme) => {
		boutons.forEach((b) => {
			const actif = b.dataset.tfpTheme === theme;
			b.setAttribute('aria-pressed', String(actif));
			b.parentElement.classList.toggle('is-current', actif);
		});
		let visibles = 0;
		cartes.forEach((c) => {
			const montre = theme === '' || c.dataset.tfpTheme === theme;
			c.hidden = !montre;
			if (montre) visibles++;
		});
		sections.forEach((s) => {
			s.hidden = !s.querySelector('.tfp-article-card:not([hidden])');
		});
		if (statut) statut.textContent = `${visibles} article${visibles > 1 ? 's' : ''} affiché${visibles > 1 ? 's' : ''}.`;
	};

	liste.querySelectorAll('[data-tfp-theme]').forEach((li) => {
		const bouton = document.createElement('button');
		bouton.type = 'button';
		bouton.className = 'tfp-theme-list__btn';
		bouton.dataset.tfpTheme = li.dataset.tfpTheme;
		bouton.textContent = li.textContent.trim();
		li.textContent = '';
		li.appendChild(bouton);
		li.classList.add('tfp-theme-list__item--filtre');
		bouton.addEventListener('click', () => appliquer(bouton.dataset.tfpTheme));
		boutons.push(bouton);
	});
	boutons.forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.tfpTheme === '')));
}

document.addEventListener('DOMContentLoaded', tfpInitConseilsFiltres);
