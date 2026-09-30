/* Century 2000 – interactions: header menus, FAQ accordions, cookie bar, forms. */
(() => {
  const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
  const show = (el, on) => { if (el) el.hidden = !on; };

  $$('[data-year]').forEach(el => { el.textContent = new Date().getFullYear(); });

  /* ---------- Header: mega menu (desktop) + burger menu (mobile) ---------- */
  $$('[data-c="Hlavicka"]').forEach(header => {
    const pinned = header.dataset.pMegaOpen === 'true';
    const mega = header.querySelector('[data-if="megaOpen"]');
    const mob = header.querySelector('[data-if="mobileOpen"]');
    const megaBtn = header.querySelector('[data-on-click="toggleMega"]');
    const chevron = megaBtn && megaBtn.querySelector('span');
    const burger = header.querySelector('[data-on-click="toggleMobile"]');
    const bars = burger ? [...burger.children] : [];
    let timer;

    const setMega = on => {
      if (!mega) return;
      show(mega, on);
      megaBtn.setAttribute('aria-expanded', on);
      megaBtn.style.color = on ? '#856640' : '#2A2622';
      chevron.style.transform = on ? 'translateY(2px) rotate(-135deg)' : 'translateY(-2px) rotate(45deg)';
    };
    const setMobile = on => {
      if (!mob) return;
      show(mob, on);
      burger.setAttribute('aria-expanded', on);
      burger.setAttribute('aria-label', on ? 'Zavřít menu' : 'Otevřít menu');
      bars[0].style.transform = on ? 'translateY(6.5px) rotate(45deg)' : 'none';
      bars[1].style.opacity = on ? 0 : 1;
      bars[2].style.transform = on ? 'translateY(-6.5px) rotate(-45deg)' : 'none';
    };

    $$('[data-on-mouseenter="openMega"]', header).forEach(el =>
      el.addEventListener('mouseenter', () => { clearTimeout(timer); setMega(true); }));
    header.addEventListener('mouseleave', () => {
      if (pinned) return;
      timer = setTimeout(() => setMega(false), 150);
    });
    if (megaBtn) megaBtn.addEventListener('click', () => setMega(mega.hidden));
    if (burger) burger.addEventListener('click', () => setMobile(mob.hidden));
    if (!pinned) {
      document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        if (mega && !mega.hidden) { setMega(false); megaBtn.focus(); }
        if (mob && !mob.hidden) { setMobile(false); burger.focus(); }
      });
      document.addEventListener('click', e => {
        if (mega && !mega.hidden && !header.contains(e.target)) setMega(false);
      });
    }
  });

  /* ---------- FAQ accordions (one item open at a time) ---------- */
  $$('[data-on-click="f.toggle"]').forEach(btn => {
    btn.addEventListener('click', () => {
      // The accordion list is the nearest ancestor holding more than one question.
      let list = btn.parentElement;
      while (list && list.querySelectorAll('[data-on-click="f.toggle"]').length < 2) list = list.parentElement;
      if (!list) return;
      const opening = btn.getAttribute('aria-expanded') !== 'true';
      $$('[data-on-click="f.toggle"]', list).forEach(b => {
        const on = opening && b === btn;
        b.setAttribute('aria-expanded', on);
        b.lastElementChild.textContent = on ? '−' : '+';
        show(list.querySelector(`[data-if="f.open"][data-idx="${b.dataset.idx}"]`), on);
      });
    });
  });

  /* ---------- Cookie bar ---------- */
  const CONSENT_KEY = 'c2000-consent';
  const readConsent = () => { try { return JSON.parse(localStorage.getItem(CONSENT_KEY)); } catch (e) { return null; } };
  const writeConsent = c => {
    try { localStorage.setItem(CONSENT_KEY, JSON.stringify({ ...c, date: new Date().toISOString() })); } catch (e) { /* storage blocked */ }
    window.dispatchEvent(new CustomEvent('c2000-consent', { detail: c }));
  };
  const stored = readConsent();
  const wantSettings = /[?&#]cookies=settings/.test(location.search + location.hash);

  $$('[data-c="CookieLista"]').forEach(root => {
    const persistent = root.dataset.pPersistent === 'true';
    const initialView = root.dataset.pInitialView || (wantSettings ? 'settings' : 'bar');
    const bar = root.matches('[data-if="visible"]') ? root : root.querySelector('[data-if="visible"]');
    const state = { analytics: !!(stored && stored.analytics), marketing: !!(stored && stored.marketing) };

    const setView = v => {
      $$('[data-if="inSettings"]', bar).forEach(el => show(el, v === 'settings'));
      $$('[data-if="notSettings"]', bar).forEach(el => show(el, v !== 'settings'));
    };
    const paintSwitch = (btn, on) => {
      btn.setAttribute('aria-checked', on);
      const track = btn.firstElementChild, knob = track.firstElementChild;
      track.style.borderColor = on ? '#856640' : '#6E675E';
      track.style.background = on ? '#856640' : '#FFFFFF';
      track.style.justifyContent = on ? 'flex-end' : 'flex-start';
      knob.style.background = on ? '#FFFFFF' : '#6E675E';
    };
    const switches = { toggleA: 'analytics', toggleM: 'marketing' };
    const paintAll = () => Object.entries(switches).forEach(([action, key]) =>
      $$(`[data-on-click="${action}"]`, bar).forEach(b => paintSwitch(b, state[key])));
    Object.entries(switches).forEach(([action, key]) =>
      $$(`[data-on-click="${action}"]`, bar).forEach(b => b.addEventListener('click', () => { state[key] = !state[key]; paintAll(); })));

    $$('[data-on-click="openSettings"]', bar).forEach(b => b.addEventListener('click', () => setView('settings')));
    $$('[data-on-click="close"]', bar).forEach(b => b.addEventListener('click', () => {
      const label = b.textContent.trim().toLowerCase();
      if (label.startsWith('přijmout')) { state.analytics = state.marketing = true; }
      else if (label.startsWith('odmítnout')) { state.analytics = state.marketing = false; }
      paintAll();
      if (persistent) { setView(initialView); return; }
      writeConsent(state);
      show(bar, false);
    }));
    if (!persistent) {
      window.addEventListener('c2000-cookies', () => { show(bar, true); setView('settings'); });
    }

    paintAll();
    setView(initialView);
    show(bar, persistent || wantSettings || !stored);
  });

  $$('[data-on-click="openCookies"]').forEach(b =>
    b.addEventListener('click', () => window.dispatchEvent(new Event('c2000-cookies'))));

  /* ---------- Forms: inquiry (PoptavkovyFormular) and job application (Kariéra) ---------- */
  const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const MAX_FILE = 10 * 1024 * 1024;
  const FORMS = {
    submit: {            // inquiry form
      prefix: 'e',
      rules: {
        name: v => !v ? 'name' : null,
        email: v => !v ? 'emailEmpty' : !EMAIL.test(v) ? 'emailInvalid' : null,
        message: v => !v ? 'message' : null
      },
      invalidKey: { emailEmpty: 'email', emailInvalid: 'email' }
    },
    fSubmit: {           // job application form
      prefix: 'fe',
      rules: {
        name: v => !v ? 'name' : null,
        phone: v => !v ? 'phone' : null,
        email: v => v && !EMAIL.test(v) ? 'email' : null
      },
      invalidKey: {}
    }
  };

  $$('form[data-on-submit]').forEach(form => {
    const cfg = FORMS[form.dataset.onSubmit];
    if (!cfg) return;
    let submitted = false, fileTooBig = false;
    const errEls = $$(`[data-if^="${cfg.prefix}."]`, form);

    const validate = () => {
      const failing = new Set();
      for (const [field, rule] of Object.entries(cfg.rules)) {
        const input = form.elements[field];
        const err = rule(input.value.trim());
        if (err) failing.add(err);
        const bad = !!err;
        input.style.borderColor = bad ? '#A33A2A' : '#8C8478';
        input.setAttribute('aria-invalid', bad);
      }
      if (fileTooBig) failing.add('file');
      errEls.forEach(el => show(el, failing.has(el.dataset.if.slice(cfg.prefix.length + 1))));
      return failing.size === 0;
    };

    form.addEventListener('input', () => { if (submitted) validate(); });
    form.addEventListener('submit', e => {
      submitted = true;
      if (!validate()) {
        e.preventDefault();
        const first = form.querySelector('[aria-invalid="true"]');
        if (first) first.focus();
        return;
      }
      // Without a backend (no action attribute) go straight to the thank-you page.
      if (!form.getAttribute('action')) { e.preventDefault(); location.href = form.dataset.thanks; }
    });

    const file = form.querySelector('input[type="file"]');
    if (file) {
      const label = file.closest('label');
      const nameEl = label.lastElementChild;
      file.addEventListener('change', () => {
        const f = file.files && file.files[0];
        if (!f) return;
        nameEl.textContent = f.name;
        if (form.dataset.onSubmit === 'submit') {
          fileTooBig = f.size > MAX_FILE;
          label.style.borderColor = fileTooBig ? '#A33A2A' : '#8C8478';
          errEls.filter(el => el.dataset.if === 'e.file').forEach(el => show(el, fileTooBig));
        }
      });
    }
  });

  // Server-side rejection (redirect back with ?chyba=…): show a message above the form.
  const failed = new URLSearchParams(location.search).get('chyba');
  const alertBox = failed && document.getElementById('formular-chyba');
  if (alertBox) {
    alertBox.textContent = failed === 'odeslani'
      ? 'Formulář se nepodařilo odeslat. Zkuste to prosím znovu nebo nám zavolejte na +420 603 287 803.'
      : failed === 'limit'
        ? 'Odeslali jste několik formulářů za krátkou dobu. Zkuste to prosím za pár minut.'
        : 'Zkontrolujte prosím povinná pole a přílohu (max. 10 MB) a odešlete formulář znovu.';
    alertBox.hidden = false;
    alertBox.scrollIntoView({ block: 'center' });
  }

  // Kariéra: "Odpovědět na inzerát" buttons prefill the position field.
  const positions = { applyMain: 'Švadlena / švadlena bytových dekorací', applyMachine: 'Obsluha prošívacího stroje' };
  Object.entries(positions).forEach(([action, value]) =>
    $$(`[data-on-click="${action}"]`).forEach(a => a.addEventListener('click', () => {
      const input = document.querySelector('form [name="position"]');
      if (input) input.value = value;
    })));
})();
