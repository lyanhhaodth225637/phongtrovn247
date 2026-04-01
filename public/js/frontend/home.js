/**
 * PhongTroVN247 — home.js
 */
document.addEventListener('DOMContentLoaded', () => {

  // ══ NOTIF DROPDOWN (custom JS) ══
  const overlay     = document.getElementById('headerOverlay');
  const notifToggle = document.getElementById('notifToggle');
  const notifDrop   = document.getElementById('notifDropdown');

  function closeNotif() {
    notifDrop?.classList.remove('show');
    if (overlay) overlay.style.display = 'none';
  }

  function toggleNotif() {
    const isOpen = notifDrop.classList.contains('show');
    closeNotif();
    if (!isOpen) {
      notifDrop.classList.add('show');
      if (overlay) overlay.style.display = 'block';
    }
  }

  notifToggle?.addEventListener('click', e => {
    e.stopPropagation();
    toggleNotif();
  });

  overlay?.addEventListener('click', closeNotif);
  notifDrop?.addEventListener('click', e => e.stopPropagation());


  // ══ AVATAR CHEVRON (Bootstrap Dropdown events) ══
  const avatarToggle = document.getElementById('avatarToggle');
  const avatarChevron = document.getElementById('avatarChevron');

  avatarToggle?.addEventListener('show.bs.dropdown', () => {
    avatarToggle.classList.add('open');
  });
  avatarToggle?.addEventListener('hide.bs.dropdown', () => {
    avatarToggle.classList.remove('open');
  });


  // ══ LISTING TABS ══
  document.querySelectorAll('.listing-tab').forEach(tab => {
    tab.addEventListener('click', function (e) {
      const target = this.dataset.tab ? document.getElementById('tab-' + this.dataset.tab) : null;
      if (!target) return;
      e.preventDefault();
      document.querySelectorAll('.listing-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-pane-custom').forEach(p => p.classList.remove('active'));
      this.classList.add('active');
      target.classList.add('active');
    });
  });


  // ══ PHONE REVEAL ══
  const PHONES = ['0901234567','0912345678','0923456789','0934567890','0945678901'];

  document.querySelectorAll('.phone-btn').forEach(btn => {
    const orig = btn.innerHTML;
    let revealed = false;
    btn.addEventListener('click', () => {
      if (revealed) return;
      revealed = true;
      btn.innerHTML = `<i class="bi bi-telephone-fill"></i> ${PHONES[Math.floor(Math.random() * PHONES.length)]}`;
      btn.style.background = '#16a34a';
      setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; revealed = false; }, 6000);
    });
  });


  // ══ SAVE / BOOKMARK ══
  document.querySelectorAll('.save-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const saved = btn.classList.toggle('saved');
      btn.innerHTML = saved
        ? '<i class="bi bi-bookmark-fill" style="color:var(--primary)"></i>'
        : '<i class="bi bi-bookmark"></i>';
      btn.setAttribute('aria-label', saved ? 'Bỏ lưu' : 'Lưu tin');
    });
  });


  // ══ CATEGORY CHIPS (trang chủ) ══
  document.querySelectorAll('.cat-chip').forEach(chip => {
    chip.addEventListener('click', e => {
      if (chip.getAttribute('href') === '#') e.preventDefault();
      document.querySelectorAll('.cat-chip').forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
    });
  });


  // ══ FILTER MODAL ══

  // Danh mục — single select
  document.querySelectorAll('.cat-grid-item').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.cat-grid-item').forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });

  // Giá / diện tích — multi select với "Tất cả"
  document.querySelectorAll('[data-filter="price"],[data-filter="area"]').forEach(chip => {
    chip.addEventListener('click', () => {
      const group = chip.dataset.filter;
      const all   = [...document.querySelectorAll(`[data-filter="${group}"]`)];

      if (chip.dataset.value === 'all') {
        all.forEach(c => c.classList.remove('active', 'active-all'));
        chip.classList.add('active-all');
      } else {
        all.find(c => c.dataset.value === 'all')?.classList.remove('active-all');
        chip.classList.toggle('active');
        if (!all.some(c => c.classList.contains('active')))
          all.find(c => c.dataset.value === 'all')?.classList.add('active-all');
      }
    });
  });

  // Tiện ích — checkbox chips
  document.querySelectorAll('.feature-chip').forEach(label => {
    label.addEventListener('click', () => {
      const cb = label.querySelector('input');
      if (!cb) return;
      cb.checked = !cb.checked;
      label.classList.toggle('checked', cb.checked);
    });
  });

  // Apply
  document.getElementById('applyFilter')?.addEventListener('click', () => {
    const chips = [];
    document.querySelector('.cat-grid-item.active')?.dataset.value &&
      chips.push(document.querySelector('.cat-grid-item.active').dataset.value);
    const prov = document.getElementById('filterProvince')?.value;
    if (prov) chips.push(prov);
    document.querySelectorAll('[data-filter="price"].active,[data-filter="area"].active')
      .forEach(c => chips.push(c.dataset.value));
    document.querySelectorAll('.feature-chip.checked input')
      .forEach(cb => chips.push(cb.value));
    renderActiveFilters(chips);
    updateFilterBadge(chips.length);
  });

  // Reset
  document.getElementById('resetFilter')?.addEventListener('click', () => {
    document.querySelectorAll('.cat-grid-item').forEach((i, idx) => i.classList.toggle('active', idx === 0));
    ['filterProvince','filterDistrict'].forEach(id => {
      const el = document.getElementById(id); if (el) el.value = '';
    });
    document.querySelectorAll('[data-filter="price"],[data-filter="area"]').forEach(c => {
      c.classList.remove('active');
      if (c.dataset.value === 'all') c.classList.add('active-all');
    });
    document.querySelectorAll('.feature-chip').forEach(l => {
      l.classList.remove('checked');
      const cb = l.querySelector('input'); if (cb) cb.checked = false;
    });
  });

  function renderActiveFilters(chips) {
    const row = document.getElementById('activeFiltersRow');
    if (!row) return;
    if (!chips.length) { row.classList.add('d-none'); row.innerHTML = ''; return; }
    row.classList.remove('d-none');
    row.innerHTML = chips.map(c => `
      <span class="active-filter-chip" data-label="${c}">
        ${c} <i class="bi bi-x-circle-fill"></i>
      </span>`).join('');
    row.querySelectorAll('.active-filter-chip').forEach(el => {
      el.addEventListener('click', () => {
        el.remove();
        const n = row.querySelectorAll('.active-filter-chip').length;
        updateFilterBadge(n);
        if (!n) row.classList.add('d-none');
      });
    });
  }

  function updateFilterBadge(count) {
    const badge = document.getElementById('filterBadge');
    const btn   = document.getElementById('openFilterModal');
    if (!badge) return;
    badge.classList.toggle('d-none', !count);
    if (count) badge.textContent = count;
    if (btn) {
      btn.style.borderColor = count ? 'var(--primary)' : '';
      btn.style.color = count ? 'var(--primary)' : '';
    }
  }


  // ══ MOBILE BOTTOM NAV ══
  document.querySelectorAll('.mobile-nav-item').forEach(item => {
    item.addEventListener('click', function () {
      if (this.tagName !== 'A') return;
      document.querySelectorAll('.mobile-nav-item').forEach(i => i.classList.remove('active'));
      this.classList.add('active');
    });
  });


  // ══ QUICK TAGS ══
  document.querySelectorAll('.quick-tag').forEach(tag => {
    tag.addEventListener('click', () => {
      document.querySelectorAll('.quick-tag').forEach(t => t.style.background = '');
      tag.style.background = 'rgba(255,255,255,.28)';
    });
  });

});