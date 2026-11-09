// Behaviour shared by every page: analytics (production only), nav state, scroll reveals and the contents index
// (the thesis's, and RWE-Bench's).
(function () {
  'use strict';

  var PROD = location.hostname === 'xplore.ai';

  /* analytics: production only, so previews and local runs stay out of the numbers */
  if (PROD) {
    var g = document.createElement('script');
    g.async = true;
    g.src = 'https://www.googletagmanager.com/gtag/js?id=G-WPFFZ844LJ';
    document.head.appendChild(g);
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', 'G-WPFFZ844LJ');
  }

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    /* nav turns solid once the page scrolls */
    var nav = document.getElementById('nav');
    if (nav) {
      var onScroll = function () { nav.classList.toggle('is-solid', window.scrollY > 24); };
      onScroll();
      window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* reveal on scroll */
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(function (n) { io.observe(n); });

    /* the contents index follows the section in view */
    var index = document.querySelectorAll('.essay .index a, .b-doc .index a');
    if (index.length) {
      var map = {};
      index.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
      var mark = function (a) { index.forEach(function (b) { b.classList.toggle('on', b === a); }); };
      var sections = Array.prototype.filter.call(document.querySelectorAll('.essay .body section[id], .b-doc .b-main section[id]'), function (s) { return map[s.id]; });
      // the section in view is the last one whose top has passed 40 % of the screen; above them all, the first.
      // At the bottom of the page it's the last, which can be too short to get that far
      var update = function () {
        var cur = sections[0], line = window.innerHeight * 0.4;
        sections.forEach(function (s) { if (s.getBoundingClientRect().top <= line) cur = s; });
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) cur = sections[sections.length - 1];
        if (cur) mark(map[cur.id]);
      };
      var queued = false;
      window.addEventListener('scroll', function () {
        if (queued) return;
        queued = true;
        requestAnimationFrame(function () { queued = false; update(); });
      }, { passive: true });
      window.addEventListener('resize', update);
      update();
    }
  });
})();
