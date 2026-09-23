document.addEventListener('DOMContentLoaded', () => {
  /* ---------------- Mobile nav toggle ---------------- */

  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');

  if (navToggle && navLinks) {
    const closeNav = () => {
      navToggle.setAttribute('aria-expanded', 'false');
      navLinks.classList.remove('is-open');
    };

    navToggle.addEventListener('click', () => {
      const isOpen = navLinks.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // Tutup menu tiap kali salah satu link diklik
    navLinks.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', closeNav);
    });

    // Tutup menu kalau klik di luar navbar
    document.addEventListener('click', (e) => {
      if (!navLinks.classList.contains('is-open')) return;
      if (navLinks.contains(e.target) || navToggle.contains(e.target)) return;
      closeNav();
    });

    // Tutup menu kalau layar dibesarkan lagi ke ukuran desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth > 600) closeNav();
    });
  }

  /* ---------------- Nav link aktif sesuai section yang terlihat ---------------- */

  const sections = document.querySelectorAll('section[id]');
  const navAnchors = navLinks ? navLinks.querySelectorAll('a[href^="#"]') : [];

  if (sections.length && navAnchors.length && 'IntersectionObserver' in window) {
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          navAnchors.forEach((a) => {
            a.classList.toggle('is-active', a.getAttribute('href') === `#${entry.target.id}`);
          });
        });
      },
      { rootMargin: '-45% 0px -50% 0px', threshold: 0 }
    );

    sections.forEach((section) => sectionObserver.observe(section));
  }

  /* ---------------- Reveal saat discroll ---------------- */

  const revealEls = document.querySelectorAll('.reveal');

  if (revealEls.length) {
    if ('IntersectionObserver' in window) {
      const revealObserver = new IntersectionObserver(
        (entries, observer) => {
          entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-in-view');
            observer.unobserve(entry.target);
          });
        },
        { threshold: 0.15 }
      );

      revealEls.forEach((el) => revealObserver.observe(el));
    } else {
      // Fallback kalau browser tidak dukung IntersectionObserver
      revealEls.forEach((el) => el.classList.add('is-in-view'));
    }
  }

  /* ---------------- Quiz "Mulai dari mana?" ---------------- */

  const quizOptions = document.querySelectorAll('.quiz-option');
  const resultBox = document.querySelector('.quiz-result');
  const statusEl = document.querySelector('.quiz-status');

  quizOptions.forEach((btn) => {
    btn.addEventListener('click', async () => {
      quizOptions.forEach((b) => b.setAttribute('aria-pressed', 'false'));
      btn.setAttribute('aria-pressed', 'true');

      const interest = btn.dataset.interest;
      statusEl.textContent = 'Mencari program yang cocok...';
      resultBox.classList.remove('is-visible');

      try {
        const res = await fetch(`api/recommend.php?interest=${encodeURIComponent(interest)}`);
        const data = await res.json();

        if (!data.success) {
          statusEl.textContent = data.message || 'Belum ada rekomendasi untuk pilihan ini.';
          return;
        }

        renderResult(data.program);
        statusEl.textContent = '';
      } catch (err) {
        statusEl.textContent = 'Gagal memuat rekomendasi. Pastikan server PHP berjalan.';
      }
    });
  });

  function renderResult(program) {
    resultBox.innerHTML = `
      <div class="quiz-result-icon">${program.icon || ''}</div>
      <span class="tag">${program.kategori}</span>
      <h3>${program.title}</h3>
      <p>${program.deskripsi}</p>
      <a href="#program-${program.id}" class="btn">Lihat di Peta Peluang</a>
    `;
    resultBox.classList.add('is-visible');

    const link = resultBox.querySelector('a.btn');
    link.addEventListener('click', (e) => {
      e.preventDefault();
      highlightProgramCard(program.id);
    });
  }

  function highlightProgramCard(id) {
    const card = document.getElementById(`program-${id}`);
    if (!card) return;

    document.querySelectorAll('.program-card').forEach((c) => c.classList.remove('is-highlighted'));
    card.classList.add('is-highlighted');
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Also switch filter tab to "Semua" so the card is guaranteed visible
    const allTab = document.querySelector('.filter-tab[data-filter="semua"]');
    if (allTab) allTab.click();

    setTimeout(() => card.classList.remove('is-highlighted'), 2600);
  }

  /* ---------------- Filter grid (Peta Peluang) ---------------- */

  const filterTabs = document.querySelectorAll('.filter-tab');
  const programCards = document.querySelectorAll('.program-card');

  filterTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      filterTabs.forEach((t) => t.classList.remove('is-active'));
      tab.classList.add('is-active');

      const filter = tab.dataset.filter;
      programCards.forEach((card) => {
        const show = filter === 'semua' || card.dataset.category === filter;
        card.classList.toggle('is-hidden', !show);
      });
    });
  });
});
