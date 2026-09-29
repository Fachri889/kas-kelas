/**
 * Kas Kelas - Main Shared Application Logic (js/main.js)
 */

document.addEventListener('DOMContentLoaded', function () {
  initActiveNavigation();
  initMobileSidebar();
  initHeaderSearch();
  initNotifications();
});

/**
 * Mobile responsive sidebar drawer
 */
function initMobileSidebar() {
  const toggleBtn = document.getElementById('mobile-sidebar-toggle');
  const sidebar = document.getElementById('app-sidebar');
  const backdrop = document.getElementById('sidebar-backdrop');
  const closeBtn = document.getElementById('mobile-sidebar-close');

  if (!sidebar) return;

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    if (backdrop) backdrop.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }

  function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    if (backdrop) backdrop.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', openSidebar);
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeSidebar);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeSidebar);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });
}

/**
 * Automatically sets the active sidebar link based on the current page URL
 */
function initActiveNavigation() {
  const currentPath = window.location.pathname.split('/').pop().toLowerCase() || 'dashboard.html';

  const pathToDataPath = {
    'dashboard.html': 'dashboard-admin',
    'admin.html': 'dashboard-admin',
    'siswa.html': 'data-siswa',
    'pembayaran.html': 'pembayaran-kas',
    'pemasukan.html': 'pemasukan',
    'pengeluaran.html': 'pengeluaran',
    'laporan.html': 'laporan-keuangan',
    'portal.html': 'portal-siswa'
  };

  const activeDataPath = pathToDataPath[currentPath];
  if (!activeDataPath) return;

  const activeClasses = ['bg-primary-container', 'text-on-primary', 'font-label-lg', 'rounded-lg', 'shadow-sm'];
  const defaultClasses = ['text-on-surface-variant', 'hover:bg-surface-container-low', 'hover:text-on-surface'];

  const navLinks = document.querySelectorAll('aside nav a[data-path]');
  navLinks.forEach((link) => {
    const linkPath = link.getAttribute('data-path');
    const icon = link.querySelector('.material-symbols-outlined');

    if (linkPath === activeDataPath) {
      link.classList.remove(...defaultClasses);
      link.classList.add(...activeClasses);
      link.setAttribute('aria-current', 'page');
      if (icon) {
        icon.style.fontVariationSettings = "'FILL' 1";
      }
    } else {
      link.classList.remove(...activeClasses);
      link.classList.add(...defaultClasses);
      link.removeAttribute('aria-current');
      if (icon) {
        icon.style.fontVariationSettings = "'FILL' 0";
      }
    }
  });
}

/**
 * Global search input handler (Header search)
 */
function initHeaderSearch() {
  const headerSearchInput = document.querySelector('header input[type="text"]');
  if (!headerSearchInput) return;

  headerSearchInput.addEventListener('input', function (e) {
    const query = e.target.value.toLowerCase().trim();
    // If table exists on the current page, filter rows automatically
    const tableRows = document.querySelectorAll('tbody tr');
    if (tableRows.length > 0) {
      tableRows.forEach((row) => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    }
  });
}

/**
 * Header notification bell micro-interaction
 */
function initNotifications() {
  const notifBtn = document.querySelector('header button:has(.material-symbols-outlined)');
  if (!notifBtn) return;

  notifBtn.addEventListener('click', function () {
    const badge = this.querySelector('span.rounded-full');
    if (badge) {
      badge.style.display = 'none';
    }
  });
}

/**
 * Utility: Format numbers to IDR currency
 */
function formatRupiah(amount) {
  return 'Rp ' + Number(amount).toLocaleString('id-ID');
}
