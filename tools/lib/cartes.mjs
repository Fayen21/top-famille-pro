/**
 * Relevé et diagnostic des cartes — le cœur de tools/inventaire-cartes.mjs, exporté pour être
 * éprouvé par tests/cartes.spec.js sur des fixtures autonomes.
 *
 * Une seule définition, comme tools/lib/bandes.mjs : le faux positif des rangées de pastilles a
 * été corrigé ICI, et un correcteur qui vivrait en double dans l'outil et dans le test pourrait
 * diverger sans que rien ne le signale.
 */

export /**
 * Relevé de toutes les cartes d'une page.
 *
 * Écrit pour tourner dans le navigateur, des deux côtés, sans dépendre du balisage : la maquette
 * n'a ni classes stables ni sémantique, on ne peut donc reconnaître une carte qu'à son rendu.
 */
const RELEVE = () => {
	const txt = (el) => (el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : '');

	// Conteneur du flux de page : le plus proche ancêtre du H1 portant plusieurs `<section>`.
	// En-tête, pré-pied et pied de page sont hors sujet : ils sont identiques sur les 53 routes.
	let flux = document.body;
	for (let el = document.querySelector('h1'); el; el = el.parentElement) {
		if (el.querySelectorAll(':scope > section').length >= 2) {
			flux = el;
			break;
		}
	}

	const sections = [...flux.children].filter((c) => c.getBoundingClientRect().height >= 20);
	/** Index de la bande qui contient un élément — sert à situer chaque carte. */
	const bandeDe = (el) => {
		for (let i = 0; i < sections.length; i++) if (sections[i].contains(el)) return i + 1;
		return 0;
	};

	/**
	 * Une carte est un bloc **visuellement détaché** : arrondi, et distingué du fond par une
	 * couleur de fond propre, un filet ou une ombre. Le seuil de 6 px de rayon écarte les
	 * arrondis de confort (champs de formulaire, boutons) sans écarter les micro-cartes, dont le
	 * rayon descend à 8 px dans la maquette.
	 */
	const estCarte = (el) => {
		const s = getComputedStyle(el);
		const r = el.getBoundingClientRect();
		if (r.width < 60 || r.height < 24) return false;
		if (s.display === 'none' || s.visibility === 'hidden') return false;
		const rayon = parseFloat(s.borderTopLeftRadius) || 0;
		const filet = parseFloat(s.borderTopWidth) || 0;
		const fond = s.backgroundColor !== 'rgba(0, 0, 0, 0)' && s.backgroundColor !== 'transparent';
		const ombre = s.boxShadow && s.boxShadow !== 'none';
		return rayon >= 6 && (fond || filet > 0 || ombre);
	};

	// Les boutons et les liens d'action ne sont pas des cartes : ils sont arrondis et colorés, mais
	// ils appartiennent au vocabulaire des commandes, pas à celui des blocs de contenu.
	const estCommande = (el) => {
		const t = el.tagName.toLowerCase();
		if (t === 'input' || t === 'select' || t === 'textarea') return true;
		/*
		 * **Angle mort corrigé.** `button` était exclu inconditionnellement. Or la maquette compose
		 * la carte d'orientation du contact — « J'ai une question », 403×104, titre et
		 * description — en `<button>` : elle était invisible au relevé, et sa contrepartie
		 * WordPress (une carte `div` identique à l'écran) ressortait en « carte supplémentaire ».
		 * Un bouton reçoit désormais le même critère de taille qu'un lien : petit et court, c'est
		 * une commande ; grand et porteur de contenu, c'est une carte cliquable.
		 */
		if (t === 'button' || t === 'a') {
			const r = el.getBoundingClientRect();
			// Un lien peut être une vraie carte cliquable (tuile de prestation) : on ne l'écarte que
			// s'il est petit et sur une seule ligne, c'est-à-dire s'il se comporte comme un bouton.
			return r.height <= 64 && el.children.length <= 2 && txt(el).length <= 40;
		}
		return false;
	};

	let candidats = [...flux.querySelectorAll('*')].filter((el) => estCarte(el) && !estCommande(el));

	/*
	 * Retire les conteneurs : si une carte contient elle-même d'autres cartes qui occupent
	 * l'essentiel de sa surface, c'est une bande décorée, pas une carte. Sans cette règle, une
	 * grille de huit micro-cartes posée sur un fond arrondi compterait pour neuf.
	 *
	 * Le critère est surfacique et non structurel : une carte peut légitimement en contenir une
	 * autre (une carte de scénario avec un encadré à l'intérieur), tant que l'enfant ne remplit pas
	 * le parent.
	 */
	const aire = (el) => {
		const r = el.getBoundingClientRect();
		return r.width * r.height;
	};
	const retirerConteneurs = (liste) =>
		liste.filter((el) => {
			const enfants = liste.filter((x) => x !== el && el.contains(x));
			if (!enfants.length) return true;
			// Ne garder que les enfants directs au sens de la liste (pas les petits-enfants).
			const directs = enfants.filter((x) => !enfants.some((y) => y !== x && y.contains(x)));
			if (directs.length < 2) return true;
			const occupe = directs.reduce((n, x) => n + aire(x), 0) / Math.max(1, aire(el));
			return occupe < 0.72;
		});
	candidats = retirerConteneurs(candidats);

	/**
	 * Archétype d'une carte, déduit de ce qu'elle contient et de son apparence.
	 *
	 * La nomenclature n'est pas inventée : chaque nom correspond à une composition réellement
	 * employée par la maquette, et le classement se fait sur le rendu mesuré.
	 */
	const archetype = (el) => {
		const s = getComputedStyle(el);
		const t = txt(el);
		const img = el.querySelector('img,picture,svg');
		/*
		 * **Faux positif corrigé.** Le classement se faisait sur les balises (`h2,h3,h4,strong,b`),
		 * alors que le contrat de cet outil est de classer sur le **rendu**. La maquette compose ses
		 * intitulés de carte en `div` nu ; le thème emploie `strong` ou `h3` selon ce que fait le
		 * prototype, ce qui est plus juste sémantiquement. Résultat : à écran identique, la référence
		 * était classée `micro-carte` et le thème `carte-titre`, sur 115 cartes.
		 *
		 * Un intitulé est donc reconnu à ce qui le distingue visuellement du corps de la carte :
		 * une graisse d'au moins 600, ou une taille supérieure à celle du texte courant de la carte.
		 */
		const tailleCorps = parseFloat(getComputedStyle(el).fontSize) || 16;
		const titre = [...el.querySelectorAll('*')].find((x) => {
			if (!(x.textContent || '').trim()) return false;
			const xs = getComputedStyle(x);
			return (parseInt(xs.fontWeight, 10) || 400) >= 600 || parseFloat(xs.fontSize) > tailleCorps + 0.5;
		});
		const numero = [...el.children].some((c) => /^\d{1,2}$/.test(txt(c)) && parseFloat(getComputedStyle(c).fontSize) >= 18);
		const etoiles = /★{3,}/.test(t);
		const citation = !!el.querySelector('blockquote') || /^[«"]/.test(t);
		const details = el.tagName.toLowerCase() === 'details' || !!el.querySelector('summary');
		const prix = /\d+[\s ]*€/.test(t);
		const fond = s.backgroundColor;
		const sombre = /rgb\((\d+), (\d+), (\d+)\)/.test(fond) && (() => {
			const [r, g, b] = fond.match(/\d+/g).map(Number);
			return 0.299 * r + 0.587 * g + 0.114 * b < 128;
		})();
		const barre = parseFloat(s.borderLeftWidth) >= 3 && parseFloat(s.borderTopWidth) < 3;
		const pastille = parseFloat(s.borderTopLeftRadius) >= 40 || /^\d+(\.\d+)?px$/.test(s.borderRadius) === false;
		const r = el.getBoundingClientRect();

		if (details) return 'faq';
		if (barre) return 'encadre-barre';
		if (etoiles && citation) return 'temoignage';
		if (numero) return 'etape';
		if (prix && (titre || sombre)) return 'tarif';
		if (img && r.height > 160) return 'carte-image';
		if (sombre) return 'carte-sombre';
		if (parseFloat(s.borderTopLeftRadius) >= 999 || (r.height <= 44 && t.length <= 42)) return 'chip';
		if (img) return 'carte-icone';
		if (titre && t.length > 90) return 'carte-titre-texte';
		if (titre) return 'carte-titre';
		return 'micro-carte';
	};

	/**
	 * Nombre de colonnes du rang où se trouve la carte, mesuré sur ses sœurs de même ordonnée.
	 *
	 * On remonte d'abord les **wrappers techniques** : un élément qui n'a qu'un seul enfant et
	 * n'apporte ni fond, ni filet, ni rayon n'est pas un niveau de mise en page. C'est le cas d'un
	 * `<li>` autour d'une tuile — balisage juste pour une liste de liens, mais qui ferait mesurer
	 * « une colonne » à une grille qui en a six. Le wrapper n'est jamais compté comme une carte ;
	 * il n'est pas non plus pris pour le conteneur de grille.
	 */
	const colonnesDuRang = (el) => {
		let cible = el;
		for (let i = 0; i < 3; i++) {
			const p = cible.parentElement;
			if (!p || p.children.length !== 1) break;
			const s = getComputedStyle(p);
			const nu =
				parseFloat(s.borderTopLeftRadius) < 6 &&
				parseFloat(s.borderTopWidth) === 0 &&
				(s.backgroundColor === 'rgba(0, 0, 0, 0)' || s.backgroundColor === 'transparent');
			if (!nu) break;
			cible = p;
		}
		const parent = cible.parentElement;
		if (!parent) return 1;
		el = cible;
		const y = Math.round(el.getBoundingClientRect().top);
		const soeurs = [...parent.children].filter(
			(c) => Math.abs(Math.round(c.getBoundingClientRect().top) - y) <= 8 && c.getBoundingClientRect().height > 20
		);
		return Math.max(1, soeurs.length);
	};

	return {
		sections: sections.length,
		cartes: candidats
			.map((el) => {
				const s = getComputedStyle(el);
				const r = el.getBoundingClientRect();
				const titre = el.querySelector('h2,h3,h4,strong,b');
				const parent = el.parentElement ? getComputedStyle(el.parentElement) : null;
				return {
					type: archetype(el),
					/*
					 * Largeur et repli du parent DIRECT : les deux seules propriétés de mise en page
					 * d'une rangée qui revient à la ligne. Le rang d'une pastille dans une telle
					 * rangée n'en est pas une — il découle de la largeur du texte des voisines.
					 */
					parentW: el.parentElement ? Math.round(el.parentElement.getBoundingClientRect().width) : 0,
					parentWrap: parent ? parent.flexWrap === 'wrap' : false,
					bande: bandeDe(el),
					titre: txt(titre).slice(0, 60),
					texte: txt(el).slice(0, 90),
					image: !!el.querySelector('img,picture'),
					icone: !!el.querySelector('svg') || /^[\p{Emoji_Presentation}\p{Extended_Pictographic}☎★✓✕]/u.test(txt(el)),
					fond: s.backgroundColor,
					filet: s.borderTopWidth + ' ' + s.borderTopStyle,
					rayon: s.borderTopLeftRadius,
					ombre: (s.boxShadow || 'none').slice(0, 30),
					padding: s.padding,
					w: Math.round(r.width),
					h: Math.round(r.height),
					colonnes: colonnesDuRang(el),
					grille: parent ? (parent.gridTemplateColumns || 'none').split(' ').length : 0,
					span: s.gridColumn && s.gridColumn !== 'auto' ? s.gridColumn : '',
					align: s.textAlign,
					gap: parent ? parent.gap || 'normal' : 'normal',
					y: Math.round(r.top + window.scrollY),
				};
			})
			/*
			 * Une carte sans texte, sans image et sans icône n'est pas une carte : c'est un cadre
			 * décoratif, un séparateur ou un conteneur de mise en page que le relevé a retenu pour
			 * son fond ou son rayon. Rien à comparer d'un côté à l'autre — vingt et une de ces
			 * coquilles vides étaient comptées « cartes supplémentaires ».
			 */
			.filter((c) => c.texte || c.image || c.icone)
			// Ordre de lecture : c'est celui qui compte pour dire « même ordre ».
			.sort((a, b) => a.y - b.y),
	};
};

/**
 * Empreinte de contenu, pour apparier une carte de la maquette à sa contrepartie WordPress.
 *
 * Volontairement brutale : on retire **tout** ce qui n'est ni lettre ni chiffre. Le prototype
 * concatène ses nœuds sans espace (« À partir de27 € HT/h ») là où le thème en met un, accole le
 * « + » des accordéons à la question, et emploie des apostrophes typographiques. Comparer des
 * chaînes « normalisées à l'espace près » produisait des dizaines de fausses cartes absentes.
 */
export const norm = (s) =>
	(s || '')
		.normalize('NFD')
		.replace(/[\u0300-\u036f]/g, '')
		.toLowerCase()
		.replace(/[^a-z0-9]/g, '');

/** Mots significatifs d'une carte, pour la comparaison approch\u00e9e. */
export const mots = (s) =>
	new Set(
		(s || '')
			.normalize('NFD')
			.replace(/[\u0300-\u036f]/g, '')
			.toLowerCase()
			.replace(/[^a-z0-9]+/g, ' ')
			.trim()
			.split(' ')
			.filter((m) => m.length > 2)
	);

/** Coefficient de Dice sur les mots : 1 = m\u00eames mots, 0 = aucun mot commun. */
export function similarite(a, b) {
	const A = mots(a);
	const B = mots(b);
	if (!A.size || !B.size) return 0;
	let commun = 0;
	for (const m of A) {
		if (B.has(m)) commun++;
	}
	return (2 * commun) / (A.size + B.size);
}

/**
 * Apparie les cartes des deux côtés, dans l'ordre, sur leur contenu.
 *
 * L'appariement se fait sur le texte, seul élément commun fiable : ni les classes ni la structure
 * ne survivent au passage de la maquette au thème. Une carte de la maquette dont le texte se
 * retrouve **à l'intérieur** d'une carte WordPress plus grosse est une **fusion** — c'est le cas
 * que l'on cherche à débusquer, et il ne se voit sur aucune autre mesure.
 */
export function diagnostiquer(ref, wp) {
	const restants = wp.cartes.map((c, i) => ({ ...c, i, pris: false }));
	const anomalies = [];
	const apparies = [];

	for (const a of ref.cartes) {
		const cle = norm(a.texte).slice(0, 48);
		if (!cle) continue;

		// 1. Correspondance exacte : une carte WordPress dont le texte commence pareil.
		let b = restants.find((x) => !x.pris && norm(x.texte).slice(0, 48) === cle);

		// 2. Sinon, une carte WordPress qui contient ce texte : c'est une fusion.
		let fusion = null;
		let corrige = null;
		if (!b) {
			/*
			 * Deux garde-fous relevés en G22 :
			 *  - **proximité de bande** : la pastille tarifaire du hero de l'accueil (bande 1) était
			 *    déclarée « fusionnée » dans la carte tarifaire de la bande 9, dont le texte la
			 *    contient par coïncidence — neuf bandes plus bas. Une fusion réelle ne traverse pas
			 *    la page : elle reste dans la bande de la carte absorbée ;
			 *  - la carte absorbante est marquée `fusion` : sans cela elle restait « libre » et
			 *    ressortait AUSSI en carte supplémentaire — deux anomalies pour un seul fait (la
			 *    carte Horaires du contact, comptée fusionnée puis surnuméraire).
			 */
			fusion = restants.find(
				(x) =>
					!x.pris &&
					Math.abs((x.bande ?? 0) - (a.bande ?? 0)) <= 1 &&
					norm(x.texte).includes(cle.slice(0, 32)) &&
					cle.length > 12
			);
			if (!fusion) {
				/*
				 * 3. Correspondance **approchée**, avant de conclure à une absence.
				 *
				 * Le site corrige volontairement des textes de la maquette : la note Google n'est
				 * plus répétée sur l'accueil, les tarifs différenciés par ville sont remplacés par
				 * le tarif régional unique, « Interlocuteur identifié » devient « Interlocutrice
				 * identifiée » (CLAUDE.md §5 et §9). Chacune de ces corrections produisait, sur une
				 * comparaison stricte, **une carte absente et une carte supplémentaire** — deux
				 * anomalies pour une carte présente et voulue. « ★★★★★5,0/5 Google » contre
				 * « ★★★★★5,0/5 sur Google » suffisait : un mot d'écart, deux anomalies.
				 *
				 * L'appariement approché est volontairement étroit — même archétype, même bande à
				 * une près, moitié des mots en commun — et il ne masque rien : il produit sa propre
				 * famille `texte`, listée à part, pour que chaque écart reste relisible.
				 */
				corrige = restants
					.filter(
						(x) =>
							!x.pris &&
							Math.abs((x.bande ?? 0) - (a.bande ?? 0)) <= 1 &&
							similarite(a.texte, x.texte) >= 0.5
					)
					.sort((x, y) => similarite(a.texte, y.texte) - similarite(a.texte, x.texte))[0];
				if (!corrige) {
					// 4. Ou bien la carte n'existe pas du tout côté WordPress.
					anomalies.push({ genre: 'absente', type: a.type, bande: a.bande, texte: a.texte.slice(0, 70) });
					continue;
				}
			}
		}

		if (corrige) {
			corrige.pris = true;
			apparies.push([a, corrige]);
			/*
			 * Même carte, archétype différent : c'est un écart de **forme**, pas une carte absente
			 * doublée d'une carte en trop. Le badge Google de l'accueil en est l'exemple type — rendu
			 * en pastille d'un côté, en carte de l'autre, il comptait deux anomalies au lieu d'une,
			 * et la vraie information (« la forme diffère ») se perdait entre les deux.
			 */
			if (corrige.type !== a.type) {
				anomalies.push({ genre: 'type', type: a.type, recu: corrige.type, bande: a.bande, texte: a.texte.slice(0, 60) });
			} else {
				anomalies.push({
					genre: 'texte',
					type: a.type,
					bande: a.bande,
					texte: a.texte.slice(0, 70),
					recu: corrige.texte.slice(0, 70),
					proximite: Math.round(similarite(a.texte, corrige.texte) * 100),
				});
			}
			continue;
		}

		if (fusion) {
			fusion.fusion = true;
			anomalies.push({
				genre: 'fusionnee',
				type: a.type,
				bande: a.bande,
				texte: a.texte.slice(0, 70),
				dans: fusion.texte.slice(0, 50),
			});
			continue;
		}

		b.pris = true;
		apparies.push([a, b]);
		if (a.type !== b.type) {
			anomalies.push({ genre: 'type', type: a.type, recu: b.type, bande: a.bande, texte: a.texte.slice(0, 60) });
		} else if (a.colonnes !== b.colonnes) {
			/*
			 * **Faux positif corrigé — le rang d'une pastille en rangée fluide.**
			 *
			 * Dans une rangée `flex-wrap: wrap`, le point de retour à la ligne n'est pas une
			 * propriété de mise en page : il découle de la largeur du texte des pastilles voisines.
			 * Une commune au nom plus long, une pastille insérée ou retirée en amont, et toutes les
			 * suivantes changent de rang — sans qu'aucune règle CSS ne diffère. L'outil comptait 32
			 * « écarts de colonnes » sur les rangées de communes des pages de zone, tous de cette
			 * nature.
			 *
			 * Le rang ne se compare donc que si une VRAIE propriété diverge : la largeur du
			 * conteneur (à 8 px près), la géométrie de la pastille elle-même (hauteur à 4 px,
			 * largeur à 6 px — même texte, donc même largeur, sauf typographie ou rembourrage
			 * différents), ou l'écart de la rangée (à 1 px près). Quand tout cela concorde, le
			 * décalage de rang est un artefact de flux, pas un défaut — et quand l'une diverge,
			 * l'anomalie est toujours émise (tests/cartes.spec.js couvre les deux côtés).
			 */
			const gapPx = (v) => parseFloat(String(v).split(' ')[0]) || 0;
			const rangFluide =
				a.type === 'chip' &&
				a.parentWrap &&
				b.parentWrap &&
				Math.abs((a.parentW || 0) - (b.parentW || 0)) <= 8 &&
				Math.abs(a.h - b.h) <= 4 &&
				Math.abs(a.w - b.w) <= 6 &&
				Math.abs(gapPx(a.gap) - gapPx(b.gap)) <= 1;
			if (!rangFluide) {
				anomalies.push({
					genre: 'colonnes',
					type: a.type,
					bande: a.bande,
					texte: a.texte.slice(0, 60),
					attendu: a.colonnes,
					recu: b.colonnes,
				});
			}
		}
	}

	/*
	 * Cartes-médias muettes : l'appariement se fait sur le texte, et une carte sans texte côté
	 * maquette est SAUTÉE (`if (!cle) continue`). Sa jumelle WordPress — même bande, même absence
	 * de texte, même image, boîte comparable — restait alors en « carte supplémentaire » : le
	 * visuel secondaire du hero de l'accueil, présent à l'identique des deux côtés, comptait une
	 * anomalie par largeur. On apparie ces muettes par bande, média et géométrie avant le balayage.
	 */
	const muettesRef = ref.cartes.filter((c) => !norm(c.texte) && c.image);
	for (const x of restants) {
		if (x.pris || x.fusion || norm(x.texte) || !x.image) continue;
		const jumelle = muettesRef.find(
			(c) =>
				!c.prise &&
				Math.abs((c.bande ?? 0) - (x.bande ?? 0)) <= 1 &&
				Math.abs(c.w - x.w) <= Math.max(12, c.w * 0.1) &&
				Math.abs(c.h - x.h) <= Math.max(12, c.h * 0.1)
		);
		if (jumelle) {
			jumelle.prise = true;
			x.pris = true;
			apparies.push([jumelle, x]);
		}
	}

	for (const x of restants) {
		if (!x.pris && !x.fusion) anomalies.push({ genre: 'surplus', type: x.type, bande: x.bande, texte: x.texte.slice(0, 70) });
	}

	return { anomalies, apparies };
}
