  
  document.addEventListener('DOMContentLoaded', function () {
    lottie.loadAnimation({
      container: document.getElementById('sktLogo'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: '/wp-content/themes/skt-theme/assets/json/logo-skt.json'
    });
  });

  (function () {
  const modal = document.getElementById('skt-cf7-modal');
  if (!modal) return;

  const dialog = modal.querySelector('.skt-modal__dialog');
  const closeEls = modal.querySelectorAll('[data-modal-close]');
  let lastActiveEl = null;

  function openModal() {
    lastActiveEl = document.activeElement;
    modal.setAttribute('data-open', 'true');
    modal.setAttribute('aria-hidden', 'false');

    // focus
    setTimeout(() => dialog && dialog.focus(), 0);

    document.addEventListener('keydown', onKeyDown);
  }

  function closeModal() {
    modal.removeAttribute('data-open');
    modal.setAttribute('aria-hidden', 'true');

    document.removeEventListener('keydown', onKeyDown);

    if (lastActiveEl && typeof lastActiveEl.focus === 'function') {
      lastActiveEl.focus();
    }
  }

  function onKeyDown(e) {
    if (e.key === 'Escape') closeModal();
  }

  closeEls.forEach((el) => el.addEventListener('click', closeModal));

  // CF7: èxit d'enviament
  document.addEventListener('wpcf7mailsent', function (event) {
    // Si vols limitar-ho a un form concret, descomenta:
    // if (event.detail.contactFormId !== 123) return;

    openModal();
  }, false);

  // Opcional: mostrar modal també si hi ha error de validació
  // document.addEventListener('wpcf7invalid', function () {
  //   // aquí podries obrir un altre modal o canviar el text del mateix
  // }, false);
})();

document.addEventListener('click', function(e) {
    // 1. Busquem si el clic s'ha fet al botó de tancar o a dins del seu SVG
    if (e.target.closest('[data-modal-close]')) {
        const modal = document.getElementById('skt-cf7-modal');
        
        if (modal) {
            // Posem aria-hidden a true com demana l'estàndard
            modal.setAttribute('aria-hidden', 'true');
            
            // Si el modal es mostra amb display: flex, el treiem:
            modal.style.setProperty('display', 'none', 'important');
            
            // Si el teu plugin utilitza una classe per obrir-lo (com 'is-visible' o 'active'), la treiem:
            modal.classList.remove('is-visible', 'active', 'opened');
        }
    }
});

document.addEventListener('click', (e) => {
  const a = e.target.closest('.skt-lang-parent > a');
  if (a && a.getAttribute('href') === '#') e.preventDefault();
});
