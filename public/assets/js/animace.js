/* Century 2000 – animace: vstup obsahu při posunu, počítadla, ukazatel posunu, paralaxa, stín záhlaví.
 * Při prefers-reduced-motion se nespouští (viz inline skript v <head>, který nastaví třídu js-anim). */
(function () {
  'use strict';
  var root = document.documentElement;
  var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };

  /* Ukazatel posunu a stín záhlaví (i bez třídy js-anim, jsou nenápadné) */
  var bar = document.createElement('div');
  bar.className = 'scroll-progress';
  bar.setAttribute('aria-hidden', 'true');
  document.body.appendChild(bar);
  var header = document.querySelector('.site-header');
  var parallax = $$('.index-hero__img, .service-hero__img, .clanek-hero__img').filter(function (el) { return el.offsetParent !== null; });
  var ticking = false;
  function onScroll() {
    if (ticking) { return; }
    ticking = true;
    requestAnimationFrame(function () {
      var y = window.scrollY || window.pageYOffset;
      var max = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, y / max) : 0) + ')';
      if (header) { header.classList.toggle('is-scrolled', y > 8); }
      if (root.classList.contains('js-anim')) {
        parallax.forEach(function (el) { if (y < 900) { el.style.translate = '0 ' + Math.round(y * 0.08) + 'px'; } });
      }
      ticking = false;
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (!root.classList.contains('js-anim') || !('IntersectionObserver' in window)) { return; }

  /* 1) Úvodní sekce: náběh při načtení */
  var first = document.querySelector('main section, main article > header');
  if (first) {
    var stack = first.querySelector('[class*="hero__stack"], [class*="hero__inner"] > div, .clanek-hero__inner, [class*="hero__inner"]');
    if (stack) { stack.classList.add('hero-in'); }
    $$('img', first).forEach(function (im) { if (im.offsetParent !== null) { im.classList.add('hero-img'); } });
  }

  /* 2) Označení prvků pro postupný vstup */
  var itemSel = '[class*="__grid"] > *, [class*="__list"] > li, [class*="__facts"] > *, [class*="__row"] > [class*="__box"], .clanky-grid > li, .reference-grid > li, .realizace-galerie__grid > li, .vzorkovniky__list > li, .rozcestnik-sluzeb__stack-2 > div > div';
  var targets = [];
  function tag(el, delay, kind) {
    if (!el || el.hasAttribute('data-reveal') || el.closest('.site-footer, .site-header, .cookie-bar__panel, [data-c="CookieLista"]')) { return; }
    el.setAttribute('data-reveal', kind || '');
    el.style.setProperty('--d', delay + 'ms');
    targets.push(el);
  }
  $$('main > section, main > article > *, main > article > section').forEach(function (sec, idx) {
    if (sec === first || (first && first.contains(sec))) { return; }
    var box = sec.querySelector(':scope > .container') || sec;
    $$(':scope > *', box).forEach(function (child) {
      var items = child.matches(itemSel) ? [child] : $$(itemSel, child);
      if (items.length > 1) {
        $$(':scope > *', child).forEach(function (h) { if (items.indexOf(h) === -1 && !h.querySelector(itemSel)) { tag(h, 0); } });
        items.forEach(function (it, i) { tag(it, Math.min(i, 6) * 90, 'zoom'); });
      } else {
        tag(child, 0);
      }
    });
  });

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) { return; }
      e.target.classList.add('is-in');
      io.unobserve(e.target);
      $$('.index-dilna-v-cislech__value', e.target).concat(e.target.matches('.index-dilna-v-cislech__value') ? [e.target] : []).forEach(countUp);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
  targets.forEach(function (el) { io.observe(el); });
  /* pojistka: kdyby pozorovatel selhal, nic nezůstane skryté */
  setTimeout(function () { targets.forEach(function (el) { el.classList.add('is-in'); }); }, 6000);

  /* 3) Počítadla v „Dílna v číslech“ (jen čísla do 999, rok zůstává) */
  function countUp(el) {
    if (el.__counted) { return; }
    el.__counted = true;
    var m = /^(\d{1,3})(\D.*)?$/.exec(el.textContent.trim());
    if (!m) { return; }
    var end = parseInt(m[1], 10), suffix = m[2] || '', t0 = null;
    function step(t) {
      if (t0 === null) { t0 = t; }
      var p = Math.min(1, (t - t0) / 1400), eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(end * eased) + suffix;
      if (p < 1) { requestAnimationFrame(step); } else { el.textContent = m[1] + suffix; }
    }
    el.textContent = '0' + suffix;
    requestAnimationFrame(step);
  }
})();
