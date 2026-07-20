(function () {
	'use strict';

	function ouvrirPanneau( bouton, panneau ) {
		bouton.setAttribute( 'aria-expanded', 'true' );
		panneau.hidden = false;
	}

	function fermerPanneau( bouton, panneau ) {
		bouton.setAttribute( 'aria-expanded', 'false' );
		panneau.hidden = true;
	}

	function basculerPanneau( bouton, panneau ) {
		if ( panneau.hidden ) {
			ouvrirPanneau( bouton, panneau );
		} else {
			fermerPanneau( bouton, panneau );
		}
	}

	// Menu mobile (ouverture/fermeture, sans piège de focus).
	var toggleMenu = document.getElementById( 'tfp-menu-toggle' );
	var menuMobile = document.getElementById( 'tfp-mobile-nav' );
	var fermerMenu = menuMobile ? menuMobile.querySelector( '.tfp-mobile-nav__fermer' ) : null;

	function ouvrirMenuMobile() {
		ouvrirPanneau( toggleMenu, menuMobile );
		document.body.classList.add( 'tfp-menu-ouvert' );
		if ( fermerMenu ) {
			fermerMenu.focus();
		}
	}

	function fermerMenuMobile() {
		fermerPanneau( toggleMenu, menuMobile );
		document.body.classList.remove( 'tfp-menu-ouvert' );
		if ( toggleMenu ) {
			toggleMenu.focus();
		}
	}

	if ( toggleMenu && menuMobile ) {
		toggleMenu.addEventListener( 'click', function () {
			if ( menuMobile.hidden ) {
				ouvrirMenuMobile();
			} else {
				fermerMenuMobile();
			}
		} );
	}
	if ( fermerMenu ) {
		fermerMenu.addEventListener( 'click', fermerMenuMobile );
	}

	// Sous-menus (desktop et mobile) : bouton dédié, indépendant du lien.
	var basculeurs = document.querySelectorAll( '.tfp-submenu-toggle' );
	basculeurs.forEach( function ( bouton ) {
		var panneau = document.getElementById( bouton.getAttribute( 'aria-controls' ) );
		if ( ! panneau ) {
			return;
		}
		bouton.addEventListener( 'click', function () {
			var etaitOuvert = ! panneau.hidden;
			basculeurs.forEach( function ( autre ) {
				var autrePanneau = document.getElementById( autre.getAttribute( 'aria-controls' ) );
				if ( autrePanneau && autrePanneau !== panneau ) {
					fermerPanneau( autre, autrePanneau );
				}
			} );
			if ( etaitOuvert ) {
				fermerPanneau( bouton, panneau );
			} else {
				ouvrirPanneau( bouton, panneau );
			}
		} );
	} );

	// Clic en dehors d'un sous-menu ouvert : on le referme (comportement
	// desktop classique), sans piéger le focus.
	document.addEventListener( 'click', function ( e ) {
		basculeurs.forEach( function ( bouton ) {
			var panneau = document.getElementById( bouton.getAttribute( 'aria-controls' ) );
			if ( ! panneau || panneau.hidden ) {
				return;
			}
			var item = bouton.closest( '.tfp-nav__item' );
			if ( item && ! item.contains( e.target ) ) {
				fermerPanneau( bouton, panneau );
			}
		} );
	} );

	// Échap : ferme le sous-menu ouvert ou le menu mobile, et rend le focus.
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' !== e.key ) {
			return;
		}
		var sousMenuFerme = false;
		basculeurs.forEach( function ( bouton ) {
			var panneau = document.getElementById( bouton.getAttribute( 'aria-controls' ) );
			if ( panneau && ! panneau.hidden ) {
				fermerPanneau( bouton, panneau );
				bouton.focus();
				sousMenuFerme = true;
			}
		} );
		if ( ! sousMenuFerme && menuMobile && ! menuMobile.hidden ) {
			fermerMenuMobile();
		}
	} );

	// Accordéon FAQ.
	document.querySelectorAll( '.tfp-faq__question' ).forEach( function ( bouton ) {
		var panneau = document.getElementById( bouton.getAttribute( 'aria-controls' ) );
		if ( ! panneau ) {
			return;
		}
		bouton.addEventListener( 'click', function () {
			basculerPanneau( bouton, panneau );
		} );
	} );
})();
