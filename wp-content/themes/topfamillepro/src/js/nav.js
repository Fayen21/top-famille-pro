/**
 * Navigation : sous-menus desktop, menu mobile, barre de scroll du header.
 * Vanilla JS, sans dépendance. Chargé en `defer`.
 */
(function () {
  'use strict';

  var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

  /**
   * querySelectorAll(FOCUSABLE) matche aussi les liens des sous-menus accordéon repliés
   * (`[hidden]`, donc `display:none`) : un `.focus()` sur un tel élément échoue silencieusement,
   * ce qui casse le piège de focus dans les deux sens dès qu'un accordéon est fermé.
   * `offsetParent === null` exclut fiablement ce qui n'est pas réellement rendu (mais pas les
   * éléments `position: fixed`, ce que n'est aucun des liens ici, seul le conteneur du panneau
   * l'est).
   */
  function visibleFocusable(container) {
    return Array.prototype.filter.call(container.querySelectorAll(FOCUSABLE), function (el) {
      return el.offsetParent !== null;
    });
  }

  function trapFocus(container, event) {
    var focusable = visibleFocusable(container);
    if (!focusable.length) return;
    var first = focusable[0];
    var last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  /* ---------- Header : ombre au scroll ---------- */
  function initHeaderScroll() {
    var header = document.querySelector('[data-tfp-header]');
    if (!header) return;
    var onScroll = function () {
      header.classList.toggle('tfp-header--scrolled', window.scrollY > 4);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ---------- Sous-menus desktop (Prestations, Zones) ---------- */
  function initDesktopSubmenus() {
    var toggles = document.querySelectorAll('[data-tfp-submenu-toggle]');
    if (!toggles.length) return;

    function closeAll(exceptId) {
      toggles.forEach(function (btn) {
        var id = btn.getAttribute('aria-controls');
        if (id === exceptId) return;
        var panel = document.getElementById(id);
        btn.setAttribute('aria-expanded', 'false');
        if (panel) panel.hidden = true;
      });
    }

    toggles.forEach(function (btn) {
      var id = btn.getAttribute('aria-controls');
      var panel = document.getElementById(id);
      if (!panel) return;

      btn.addEventListener('click', function () {
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        closeAll(expanded ? null : id);
        btn.setAttribute('aria-expanded', String(!expanded));
        panel.hidden = expanded;
      });
    });

    document.addEventListener('click', function (event) {
      if (!(event.target instanceof Element)) return;
      if (!event.target.closest('[data-tfp-nav-item]')) closeAll(null);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        var wasOpen = Array.prototype.some.call(toggles, function (b) {
          return b.getAttribute('aria-expanded') === 'true';
        });
        closeAll(null);
        if (wasOpen) {
          var openBtn = document.activeElement && document.activeElement.closest('[data-tfp-nav-item]');
          if (openBtn) openBtn.querySelector('[data-tfp-submenu-toggle]').focus();
        }
      }
    });
  }

  /* ---------- Menu mobile ---------- */
  function initMobileMenu() {
    var openBtn = document.querySelector('[data-tfp-mobile-open]');
    var closeBtn = document.querySelector('[data-tfp-mobile-close]');
    var panel = document.querySelector('[data-tfp-mobile-panel]');
    if (!openBtn || !panel) return;

    var lastFocused = null;

    function open() {
      lastFocused = document.activeElement;
      panel.hidden = false;
      document.body.classList.add('tfp-scroll-locked');
      openBtn.setAttribute('aria-expanded', 'true');
      var closeTarget = closeBtn || visibleFocusable(panel)[0];
      if (closeTarget) closeTarget.focus();
      document.addEventListener('keydown', onKeydown);
    }

    function close() {
      panel.hidden = true;
      document.body.classList.remove('tfp-scroll-locked');
      openBtn.setAttribute('aria-expanded', 'false');
      document.removeEventListener('keydown', onKeydown);
      if (lastFocused) lastFocused.focus();
    }

    function onKeydown(event) {
      if (event.key === 'Escape') {
        close();
      } else if (event.key === 'Tab') {
        trapFocus(panel, event);
      }
    }

    openBtn.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);

    /* Sous-menus accordéon à l'intérieur du panneau mobile */
    panel.querySelectorAll('[data-tfp-mobile-submenu-toggle]').forEach(function (btn) {
      var id = btn.getAttribute('aria-controls');
      var sub = document.getElementById(id);
      if (!sub) return;
      btn.addEventListener('click', function () {
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!expanded));
        sub.hidden = expanded;
      });
    });

    /* Ferme le panneau si on revient en desktop (redimensionnement) */
    var mq = window.matchMedia('(min-width: 820px)');
    var onChange = function (e) {
      if (e.matches && !panel.hidden) close();
    };
    if (mq.addEventListener) mq.addEventListener('change', onChange);
  }

  /**
   * Cale la hauteur du réservataire (.tfp-mobile-cta-spacer) sur la hauteur réelle de la barre
   * CTA mobile fixe : une valeur figée en CSS peut être décalée de quelques dixièmes de pixel
   * selon le rendu des polices, laissant apparaître un chevauchement infime avec le footer.
   */
  function syncMobileCtaBarSpacer() {
    var bar = document.querySelector('.tfp-mobile-cta-bar');
    var spacer = document.querySelector('.tfp-mobile-cta-spacer');
    if (!bar || !spacer) return;

    var sync = function () {
      var isVisible = window.getComputedStyle(bar).display !== 'none';
      spacer.style.height = isVisible ? Math.ceil(bar.getBoundingClientRect().height) + 'px' : '0px';
    };

    sync();
    window.addEventListener('resize', sync);
    if (window.ResizeObserver) {
      new ResizeObserver(sync).observe(bar);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    initHeaderScroll();
    initDesktopSubmenus();
    initMobileMenu();
    syncMobileCtaBarSpacer();
  });
})();
