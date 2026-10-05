/**
 * Kas Kelas - Main Shared Application Logic & Custom Modal Engine (js/main.js)
 */

document.addEventListener('DOMContentLoaded', function () {
  initActiveNavigation();
  initMobileSidebar();
  initHeaderSearch();
  initNotifications();
  initFlashMessages();
  ensureConfirmModalInDOM();
  ensureAdminDeleteModalInDOM();
});

/**
 * Ensures global confirm modal HTML structure is present in DOM at all times
 */
function ensureConfirmModalInDOM() {
  if (document.getElementById('global-confirm-modal')) return;

  const modal = document.createElement('div');
  modal.id = 'global-confirm-modal';
  modal.className = 'fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200';
  modal.innerHTML = `
    <div id="global-confirm-card" class="bg-white rounded-2xl p-6 shadow-2xl border border-slate-100 max-w-md w-full transform scale-95 transition-all duration-200 ease-out">
      <div class="flex items-start gap-4">
        <div id="global-confirm-icon-bg" class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center shrink-0">
          <span id="global-confirm-icon" class="material-symbols-outlined text-[24px]">delete_forever</span>
        </div>
        <div class="flex-1 min-w-0">
          <h3 id="global-confirm-title" class="text-base font-bold text-slate-900 leading-snug">Konfirmasi Hapus</h3>
          <p id="global-confirm-message" class="text-sm text-slate-600 mt-1 leading-relaxed">Apakah Anda yakin ingin menghapus data ini?</p>
        </div>
      </div>
      <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <button type="button" id="global-confirm-cancel-btn" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-all">
          Batal
        </button>
        <button type="button" id="global-confirm-ok-btn" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-all shadow-sm">
          Ya, Hapus Data
        </button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
}

/**
 * Ensures admin verification delete modal structure is present in DOM
 */
function ensureAdminDeleteModalInDOM() {
  if (document.getElementById('admin-verify-modal')) return;

  const modal = document.createElement('div');
  modal.id = 'admin-verify-modal';
  modal.className = 'fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md hidden opacity-0 transition-opacity duration-200';
  modal.innerHTML = `
    <div id="admin-verify-card" class="bg-white rounded-2xl p-6 shadow-2xl border border-slate-100 max-w-md w-full transform scale-95 transition-all duration-200 ease-out">
      <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 border border-red-200 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-[26px]">gavel</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-center justify-between">
            <h3 id="admin-verify-title" class="text-base font-bold text-slate-900 leading-snug">Verifikasi Hapus Permanen</h3>
            <span class="px-2 py-0.5 rounded bg-red-50 text-red-700 text-[10px] font-bold uppercase tracking-wider">Tindakan Bahaya</span>
          </div>
          <p id="admin-verify-message" class="text-xs text-slate-600 mt-1 leading-relaxed">Penghapusan data tidak dapat dibatalkan.</p>
          <p id="admin-verify-item-name" class="text-sm font-bold text-red-600 mt-1.5 font-mono truncate"></p>
        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <button type="button" id="admin-verify-cancel-btn" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-all">
          Batal
        </button>
        <button type="button" id="admin-verify-ok-btn" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all shadow-md active:scale-95 cursor-pointer">
          Ya, Hapus Permanen
        </button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
}

/**
 * Verification Handler for Admin Actions
 * Usage: onsubmit="return confirmAdminDelete(event, this, 'Hapus Data Siswa', 'Seluruh mutasi siswa akan terhapus.', 'Ahmad Fauzi')"
 */
window.confirmAdminDelete = function (event, form, title, message, itemName = '') {
  if (event) {
    event.preventDefault();
    event.stopPropagation();
  }

  ensureAdminDeleteModalInDOM();

  const modal = document.getElementById('admin-verify-modal');
  const card = document.getElementById('admin-verify-card');
  const titleEl = document.getElementById('admin-verify-title');
  const messageEl = document.getElementById('admin-verify-message');
  const itemNameEl = document.getElementById('admin-verify-item-name');
  let okBtn = document.getElementById('admin-verify-ok-btn');
  let cancelBtn = document.getElementById('admin-verify-cancel-btn');

  titleEl.textContent = title || 'Verifikasi Hapus Permanen';
  messageEl.textContent = message || 'Data yang dihapus akan hilang dari database dan tidak dapat dikembalikan.';
  if (itemNameEl) {
    itemNameEl.textContent = itemName ? `"${itemName}"` : '';
  }

  // Clone buttons to purge old event listeners
  const newOkBtn = okBtn.cloneNode(true);
  const newCancelBtn = cancelBtn.cloneNode(true);

  okBtn.parentNode.replaceChild(newOkBtn, okBtn);
  cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

  modal.classList.remove('hidden');
  requestAnimationFrame(() => {
    modal.classList.remove('opacity-0');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');
  });

  function closeModal() {
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    modal.classList.add('opacity-0');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 200);
  }

  newOkBtn.addEventListener('click', function () {
    closeModal();
    HTMLFormElement.prototype.submit.call(form);
  });

  newCancelBtn.addEventListener('click', function () {
    closeModal();
  });

  return false;
};

/**
 * Standard Custom Confirm Modal Function
 */
window.confirmModal = function (options = {}) {
  ensureConfirmModalInDOM();

  const {
    title = 'Konfirmasi Tindakan',
    message = 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    type = 'danger',
    confirmText = 'Ya, Lanjutkan',
    cancelText = 'Batal',
    onConfirm = null
  } = options;

  const modal = document.getElementById('global-confirm-modal');
  const card = document.getElementById('global-confirm-card');
  const iconBg = document.getElementById('global-confirm-icon-bg');
  const icon = document.getElementById('global-confirm-icon');
  const titleEl = document.getElementById('global-confirm-title');
  const messageEl = document.getElementById('global-confirm-message');
  let okBtn = document.getElementById('global-confirm-ok-btn');
  let cancelBtn = document.getElementById('global-confirm-cancel-btn');

  titleEl.textContent = title;
  messageEl.textContent = message;

  if (type === 'danger') {
    iconBg.className = 'w-12 h-12 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center shrink-0';
    icon.textContent = 'delete_forever';
    okBtn.className = 'px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-all shadow-sm';
  } else if (type === 'warning') {
    iconBg.className = 'w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0';
    icon.textContent = 'warning';
    okBtn.className = 'px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold transition-all shadow-sm';
  } else {
    iconBg.className = 'w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0';
    icon.textContent = 'info';
    okBtn.className = 'px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm';
  }

  const newOkBtn = okBtn.cloneNode(true);
  const newCancelBtn = cancelBtn.cloneNode(true);
  newOkBtn.textContent = confirmText;
  newCancelBtn.textContent = cancelText;

  okBtn.parentNode.replaceChild(newOkBtn, okBtn);
  cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

  modal.classList.remove('hidden');
  requestAnimationFrame(() => {
    modal.classList.remove('opacity-0');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');
  });

  function closeModal() {
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    modal.classList.add('opacity-0');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 200);
  }

  newOkBtn.addEventListener('click', function () {
    closeModal();
    if (typeof onConfirm === 'function') {
      onConfirm();
    }
  });

  newCancelBtn.addEventListener('click', function () {
    closeModal();
  });
};

/**
 * Global Toast Notification System
 */
window.showToast = function (message, type = 'success') {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-5 right-5 z-[110] flex flex-col gap-3 max-w-sm w-full pointer-events-none';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = `pointer-events-auto flex items-center gap-3 p-4 rounded-xl shadow-lg border transition-all duration-300 transform translate-x-5 opacity-0 ${
    type === 'success' ? 'bg-white border-emerald-200 text-slate-800' :
    type === 'error' ? 'bg-white border-rose-200 text-slate-800' :
    type === 'warning' ? 'bg-white border-amber-200 text-slate-800' :
    'bg-white border-blue-200 text-slate-800'
  }`;

  const iconName = type === 'success' ? 'check_circle' : type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'info';
  const iconColor = type === 'success' ? 'text-emerald-500' : type === 'error' ? 'text-rose-500' : type === 'warning' ? 'text-amber-500' : 'text-blue-500';

  toast.innerHTML = `
    <span class="material-symbols-outlined ${iconColor} text-[22px] shrink-0">${iconName}</span>
    <span class="text-xs sm:text-sm font-medium flex-1">${message}</span>
    <button type="button" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition-colors" aria-label="Tutup Notifikasi">
      <span class="material-symbols-outlined text-[18px]">close</span>
    </button>
  `;

  toast.querySelector('button').addEventListener('click', () => {
    toast.classList.add('opacity-0', 'translate-x-5');
    setTimeout(() => toast.remove(), 300);
  });

  container.appendChild(toast);
  requestAnimationFrame(() => {
    toast.classList.remove('opacity-0', 'translate-x-5');
  });

  setTimeout(() => {
    if (toast.parentNode) {
      toast.classList.add('opacity-0', 'translate-x-5');
      setTimeout(() => toast.remove(), 300);
    }
  }, 4500);
};

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

  if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });
}

/**
 * Automatically sets active sidebar link based on current path
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

  const activeClasses = ['bg-blue-600', 'text-white', 'font-semibold', 'shadow-xs'];
  const defaultClasses = ['text-slate-600', 'hover:bg-slate-100', 'hover:text-slate-900'];

  const navLinks = document.querySelectorAll('aside nav a[data-path]');
  navLinks.forEach((link) => {
    const linkPath = link.getAttribute('data-path');
    const icon = link.querySelector('.material-symbols-outlined');

    if (linkPath === activeDataPath) {
      link.classList.remove(...defaultClasses);
      link.classList.add(...activeClasses);
      link.setAttribute('aria-current', 'page');
      if (icon) icon.classList.replace('text-slate-400', 'text-white');
    } else {
      link.classList.remove(...defaultClasses);
      link.classList.add(...defaultClasses);
      link.removeAttribute('aria-current');
      if (icon) icon.classList.replace('text-white', 'text-slate-400');
    }
  });
}

/**
 * Header search input handler
 */
function initHeaderSearch() {
  const searchInput = document.getElementById('header-search-input') || document.getElementById('header-search');
  if (!searchInput) return;

  searchInput.addEventListener('input', function (e) {
    const query = e.target.value.toLowerCase().trim();
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
    if (badge) badge.style.display = 'none';
  });
}

/**
 * Convert static flash messages to toasts automatically
 */
function initFlashMessages() {
  const flashSuccess = document.querySelector('[data-flash-success]');
  if (flashSuccess) {
    window.showToast(flashSuccess.getAttribute('data-flash-success'), 'success');
  }

  const flashError = document.querySelector('[data-flash-error]');
  if (flashError) {
    window.showToast(flashError.getAttribute('data-flash-error'), 'error');
  }
}

/**
 * Utility: Format numbers to IDR currency
 */
function formatRupiah(amount) {
  return 'Rp ' + Number(amount).toLocaleString('id-ID');
}
