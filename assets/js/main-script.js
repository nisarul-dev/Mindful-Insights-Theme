// ================================================
// create an incremental (animated counter) section
// ================================================
document.addEventListener('DOMContentLoaded', () => {
  const section = document.querySelector('#stats');
  if (!section) return;

  const counters = [...section.querySelectorAll('.counter')];
  if (!counters.length) return;

  const duration = 3000;
  const items = counters.map(el => {
    const target = +el.dataset.target || 0;
    const originalText = el.textContent.trim();
    const suffix = (originalText.match(/[^0-9.,]+$/) || [''])[0];
    return { el, target, originalText, suffix };
  });

  const animateCounters = () => {
    const start = performance.now();
    items.forEach(({ el, suffix }) => (el.textContent = '0' + suffix));

    const step = now => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = progress; // linear; can use easing if desired

      // Batch DOM writes to reduce layout thrashing
      const updates = items.map(({ el, target, suffix, originalText }) => {
        const value = progress < 1 ? Math.round(target * eased) + suffix : originalText;
        return { el, value };
      });

      updates.forEach(({ el, value }) => (el.textContent = value));

      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver(([entry], obs) => {
    if (entry.isIntersecting) {
      animateCounters();
      obs.disconnect();
    }
  }, { threshold: 0.5 });

  observer.observe(section);
});


jQuery(document).ready(function ($) {
    Fancybox.bind('[data-fancybox="mit-gallery"]', {
        Toolbar: true,
        animated: true,
        dragToClose: true,
        placeFocusBack: false,
    });
});
