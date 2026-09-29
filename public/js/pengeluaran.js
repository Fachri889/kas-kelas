/**
 * Kas Kelas - Catatan Pengeluaran Page Logic (js/pengeluaran.js)
 */

function openReceiptModal(ref, vendor, amount, date, desc) {
  const modal = document.getElementById('modal-nota-viewer');
  if (!modal) return;

  const modalRef = document.getElementById('modal-ref');
  const modalVendor = document.getElementById('modal-vendor');
  const modalAmount = document.getElementById('modal-amount');
  const modalDate = document.getElementById('modal-date');
  const modalTitle = document.getElementById('modal-title');

  if (modalRef) modalRef.innerText = ref;
  if (modalVendor) modalVendor.innerText = vendor;
  if (modalAmount) modalAmount.innerText = amount;
  if (modalDate) modalDate.innerText = date;
  if (modalTitle) modalTitle.innerText = desc || 'Nota Belanja Fisik';

  modal.classList.remove('hidden');
}

function closeReceiptModal() {
  const modal = document.getElementById('modal-nota-viewer');
  if (modal) modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
  // Client-side instant live table search
  const searchInput = document.getElementById('search-input');
  if (searchInput) {
    searchInput.addEventListener('input', function (e) {
      const query = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row) => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    });
  }

  // Close modals when clicking backdrop
  const modalViewer = document.getElementById('modal-nota-viewer');
  if (modalViewer) {
    modalViewer.addEventListener('click', function (e) {
      if (e.target === modalViewer) {
        modalViewer.classList.add('hidden');
      }
    });
  }
});
