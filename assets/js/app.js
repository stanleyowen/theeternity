/*
 * Eternity Esports — site behaviour.
 * Replaces every inline <script> / onclick handler from the 2020 build so the
 * site can run under a strict Content-Security-Policy (script-src 'self').
 * The anti-devtools key blocking and right-click blocking were removed: they
 * provided no security and only hurt accessibility.
 */
(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
  }

  ready(function () {
    // Server flash messages, shown with alert() exactly like the original site did.
    var flash = document.body && document.body.getAttribute('data-flash');
    if (flash) {
      try {
        var messages = JSON.parse(flash);
        if (messages && messages.length) { window.alert(messages.join('\n\n')); }
      } catch (e) { /* ignore malformed payload */ }
    }

    // Static export: there is no server behind the forms, so explain instead of submitting.
    var staticMessage = document.body && document.body.getAttribute('data-static-archive');
    if (staticMessage) {
      document.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation(); // skip the delete confirmation: nothing would be deleted
        window.alert(staticMessage);
      }, true);
    }

    // Language chooser buttons on the landing page.
    document.querySelectorAll('[data-href]').forEach(function (el) {
      el.addEventListener('click', function () { window.location.href = el.getAttribute('data-href'); });
    });

    // Confirmation for destructive actions ("Are You Sure want to Delete This Data?").
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!window.confirm(form.getAttribute('data-confirm'))) { event.preventDefault(); }
      });
    });

    // "Back" on error pages.
    document.querySelectorAll('[data-back]').forEach(function (el) {
      el.addEventListener('click', function (event) {
        if (window.history.length > 1) { event.preventDefault(); window.history.back(); }
      });
    });

    // Highlight today's row in the opening-hours list (contact page).
    var hours = document.querySelectorAll('.list-hours li');
    if (hours.length === 7) { hours[new Date().getDay()].classList.add('today'); }
  });
})();
