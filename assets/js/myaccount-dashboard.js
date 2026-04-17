document.addEventListener('DOMContentLoaded', function () {

  // =============================================
  // MOBILE SIDEBAR TOGGLE
  // =============================================

  var toggleBtn = document.getElementById('smartnet-menu-toggle');
  var overlay   = document.getElementById('smartnet-sidebar-overlay');
  var sidebar   = document.querySelector('.smartnet-account-layout .smartnet-sidebar') || document.querySelector('.smartnet-sidebar');

  if (sidebar && !sidebar.id) {
    sidebar.id = 'smartnet-account-mobile-sidebar';
  }

  function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('is-open');
    if (overlay) {
      overlay.classList.add('is-open');
      overlay.setAttribute('aria-hidden', 'false');
    }
    if (toggleBtn) {
      toggleBtn.classList.add('is-open');
      toggleBtn.setAttribute('aria-expanded', 'true');
    }
    document.body.classList.add('smartnet-sidebar-open');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('is-open');
    if (overlay) {
      overlay.classList.remove('is-open');
      overlay.setAttribute('aria-hidden', 'true');
    }
    if (toggleBtn) {
      toggleBtn.classList.remove('is-open');
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
    document.body.classList.remove('smartnet-sidebar-open');
    document.body.style.overflow = '';
  }

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', function () {
      if (sidebar.classList.contains('is-open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeSidebar);
  }

  if (sidebar) {
    var menuLinks = sidebar.querySelectorAll('a');
    menuLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        if (window.innerWidth <= 1024) {
          closeSidebar();
        }
      });
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeSidebar();
    }
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth > 1024) {
      closeSidebar();
    }
  });

  // =============================================
  // SIDEBAR SEARCH FILTER
  // =============================================

  var menuSearch = document.querySelector('.smartnet-sidebar-search input');
  var menuItems  = Array.prototype.slice.call(document.querySelectorAll('[data-smartnet-menu-item]'));

  if (menuSearch && menuItems.length) {
    menuSearch.addEventListener('input', function () {
      var term = menuSearch.value.toLowerCase().trim();
      menuItems.forEach(function (item) {
        var text = item.textContent.toLowerCase();
        item.style.display = text.indexOf(term) === -1 ? 'none' : '';
      });
    });
  }

  // =============================================
  // PANEL INSPECT TOGGLE
  // =============================================

  document.querySelectorAll('[data-smartnet-toggle]').forEach(function (button) {
    button.addEventListener('click', function () {
      var panel = button.closest('.smartnet-panel');
      if (panel) {
        panel.classList.toggle('is-open');
      }
    });
  });

  // =============================================
  // AUTH TABS
  // =============================================

  document.querySelectorAll('[data-smartnet-auth-tab]').forEach(function (button) {
    button.addEventListener('click', function () {
      var target = button.getAttribute('data-smartnet-auth-tab');
      document.querySelectorAll('[data-smartnet-auth-tab]').forEach(function (tab) {
        tab.classList.toggle('is-active', tab === button);
      });
      document.querySelectorAll('[data-smartnet-auth-panel]').forEach(function (panel) {
        panel.classList.toggle('is-active', panel.getAttribute('data-smartnet-auth-panel') === target);
      });
    });
  });

  // =============================================
  // AJAX REGISTRATION
  // =============================================

  var ajaxRegisterForm = document.getElementById('ajax-register-form');
  var ajaxRegisterBtn  = document.getElementById('ajax-register-btn');
  var ajaxRegisterMsg  = document.getElementById('ajax-register-msg');

  if (ajaxRegisterForm && ajaxRegisterBtn && ajaxRegisterMsg && window.smartnetAccount) {
    ajaxRegisterBtn.addEventListener('click', function () {
      var formData = new FormData(ajaxRegisterForm);
      formData.append('action', 'smartnet_ajax_register');
      formData.append('security', window.smartnetAccount.registerNonce);

      ajaxRegisterBtn.disabled = true;
      ajaxRegisterMsg.style.display = 'block';
      ajaxRegisterMsg.className = 'ajax-msg';
      ajaxRegisterMsg.textContent = 'Creating account...';

      fetch(window.smartnetAccount.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData
      })
        .then(function (response) { return response.json(); })
        .then(function (payload) {
          if (payload && payload.success) {
            ajaxRegisterMsg.className = 'ajax-msg wc-success';
            ajaxRegisterMsg.textContent = payload.data.message || 'Registration successful.';
            window.location.href = payload.data.redirect || window.location.href;
            return;
          }
          ajaxRegisterMsg.className = 'ajax-msg wc-error';
          ajaxRegisterMsg.textContent = payload && payload.data && payload.data.message
            ? payload.data.message : 'Registration failed.';
          ajaxRegisterBtn.disabled = false;
        })
        .catch(function () {
          ajaxRegisterMsg.className = 'ajax-msg wc-error';
          ajaxRegisterMsg.textContent = 'Something went wrong. Please try again.';
          ajaxRegisterBtn.disabled = false;
        });
    });
  }

});
