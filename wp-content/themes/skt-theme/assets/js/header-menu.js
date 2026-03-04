document.addEventListener('DOMContentLoaded', function () {
  var toggles = document.querySelectorAll('.js-menu-toggle');
  var mobileMenu = document.getElementById('mobile-menu');
  var openButton = document.querySelector('.skt-header__icon');
  var closeButton = document.querySelector('.skt-mobile-menu__close');
  var lastFocusedElement = null;
  var focusableSelector = 'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])';

  if (!toggles.length || !mobileMenu || !openButton || !closeButton) {
    return;
  }

  var menuLabels = {
    open: openButton.dataset.openLabel || 'Open menu',
    close: openButton.dataset.closeLabel || 'Close menu'
  };

  function getFocusableItems() {
    return Array.prototype.slice.call(mobileMenu.querySelectorAll(focusableSelector)).filter(function (element) {
      return !element.hasAttribute('hidden');
    });
  }

  function setMenuState(isOpen) {
    mobileMenu.classList.toggle('is-open', isOpen);
    mobileMenu.hidden = !isOpen;
    mobileMenu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    document.body.style.overflow = isOpen ? 'hidden' : '';

    toggles.forEach(function (button) {
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    openButton.setAttribute('aria-label', isOpen ? menuLabels.close : menuLabels.open);

    if (isOpen) {
      lastFocusedElement = document.activeElement;
      window.setTimeout(function () {
        closeButton.focus();
      }, 0);
      return;
    }

    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
      lastFocusedElement.focus();
    }
  }

  toggles.forEach(function (button) {
    button.addEventListener('click', function () {
      setMenuState(mobileMenu.hidden);
    });
  });

  document.addEventListener('keydown', function (event) {
    if (mobileMenu.hidden) {
      return;
    }

    if ('Escape' === event.key) {
      setMenuState(false);
      return;
    }

    if ('Tab' !== event.key) {
      return;
    }

    var focusableItems = getFocusableItems();
    var firstItem = focusableItems[0];
    var lastItem = focusableItems[focusableItems.length - 1];

    if (!firstItem || !lastItem) {
      return;
    }

    if (event.shiftKey && document.activeElement === firstItem) {
      event.preventDefault();
      lastItem.focus();
    } else if (!event.shiftKey && document.activeElement === lastItem) {
      event.preventDefault();
      firstItem.focus();
    }
  });

  document.querySelectorAll('.skt-mobile-menu__list > .menu-item-has-children').forEach(function (item, index) {
    var link = item.querySelector('a');
    var submenu = item.querySelector('.sub-menu');

    if (!link || !submenu) {
      return;
    }

    submenu.id = 'mobile-submenu-' + index;
    submenu.hidden = true;
    link.setAttribute('aria-controls', submenu.id);
    link.setAttribute('aria-expanded', 'false');

    if ('#' === link.getAttribute('href') || '' === link.getAttribute('href')) {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        var isOpen = item.classList.toggle('is-open');
        submenu.hidden = !isOpen;
        link.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    }
  });
});
