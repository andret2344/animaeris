'use strict';

/* --- Navbar --------------------------------------------------- */
(function(){
  const nav    = document.getElementById('navbar');
  const burger = document.getElementById('navBurger');
  const menu   = document.getElementById('navMenu');
  if(!nav) return;

  const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 48);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if(burger && menu){
    burger.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      burger.classList.toggle('open', open);
      burger.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });
    menu.querySelectorAll('.nav-link').forEach(l => {
      l.addEventListener('click', () => {
        menu.classList.remove('open');
        burger.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if(!target) return;
      e.preventDefault();
      const y = target.getBoundingClientRect().top + window.scrollY - nav.offsetHeight - 8;
      window.scrollTo({ top: y, behavior: 'smooth' });
    });
  });
})();

/* --- Scroll animations ---------------------------------------- */
(function(){
  const els = document.querySelectorAll('[data-ani]');
  if(!els.length || !window.IntersectionObserver) {
    els.forEach(el => el.classList.add('vis'));
    return;
  }
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(!e.isIntersecting) return;
      const delay = parseInt(e.target.dataset.delay||'0',10);
      setTimeout(() => e.target.classList.add('vis'), delay);
      io.unobserve(e.target);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  els.forEach(el => io.observe(el));
})();

/* --- Schedule tabs -------------------------------------------- */
(function(){
  const tabs   = document.querySelectorAll('.sched-tab');
  const panels = document.querySelectorAll('.sched-panel');
  if(!tabs.length) return;
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
      panels.forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      tab.setAttribute('aria-selected','true');
      const panel = document.getElementById(tab.dataset.panel);
      if(panel){
        panel.classList.add('active');
        panel.style.cssText = 'opacity:0;transform:translateY(8px)';
        requestAnimationFrame(() => {
          panel.style.cssText = 'transition:opacity .3s ease,transform .3s ease;opacity:1;transform:translateY(0)';
        });
      }
    });
  });
})();

/* --- FAQ accordion -------------------------------------------- */
(function(){
  document.querySelectorAll('.faq-q').forEach(btn => {
    btn.addEventListener('click', () => {
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      document.querySelectorAll('.faq-q').forEach(b => {
        b.setAttribute('aria-expanded','false');
        document.getElementById(b.getAttribute('aria-controls'))?.classList.remove('open');
      });
      if(!expanded){
        btn.setAttribute('aria-expanded','true');
        document.getElementById(btn.getAttribute('aria-controls'))?.classList.add('open');
      }
    });
  });
})();

/* --- Counter animation ---------------------------------------- */
(function(){
  const nums = document.querySelectorAll('.stat-num[data-count]');
  if(!nums.length || !window.IntersectionObserver) return;
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(!e.isIntersecting) return;
      const el      = e.target;
      const target  = parseInt(el.dataset.count, 10);
      const suffix  = el.textContent.replace(/\d+/,'');
      const dur     = 1400;
      const start   = performance.now();
      const step = now => {
        const p = Math.min((now-start)/dur,1);
        const v = Math.round((1-Math.pow(1-p,3))*target);
        el.textContent = v + suffix;
        if(p<1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
      io.unobserve(el);
    });
  }, { threshold: .5 });
  nums.forEach(n => io.observe(n));
})();

/* --- Form validation ------------------------------------------ */
(function(){
  const form = document.getElementById('cForm');
  if(!form) return;
  form.addEventListener('submit', e => {
    let ok = true;
    form.querySelectorAll('[required]').forEach(f => {
      f.classList.remove('field-err');
      const invalid = f.type==='checkbox' ? !f.checked
        : f.type==='email' ? !f.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.value)
        : !f.value.trim();
      if(invalid){ ok=false; f.classList.add('field-err'); }
    });
    if(!ok) e.preventDefault();
  });
  form.querySelectorAll('input,textarea').forEach(f => {
    f.addEventListener('input', () => f.classList.remove('field-err'));
  });
})();
