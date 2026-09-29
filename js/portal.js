/**
 * Kas Kelas - Portal Siswa Page Logic (js/portal.js)
 */

function showReceipt(id, purpose, amount, date, channel) {
  const modal = document.getElementById('receipt-modal');
  if (!modal) return;

  const modalReceiptId = document.getElementById('modal-receipt-id');
  const modalReceiptPurpose = document.getElementById('modal-receipt-purpose');
  const modalReceiptAmount = document.getElementById('modal-receipt-amount');
  const modalReceiptDate = document.getElementById('modal-receipt-date');
  const modalReceiptChannel = document.getElementById('modal-receipt-channel');

  if (modalReceiptId) modalReceiptId.textContent = id;
  if (modalReceiptPurpose) modalReceiptPurpose.textContent = purpose;
  if (modalReceiptAmount) modalReceiptAmount.textContent = amount;
  if (modalReceiptDate) modalReceiptDate.textContent = date;
  if (modalReceiptChannel) modalReceiptChannel.textContent = channel;

  modal.classList.remove('hidden');
}

function closeReceipt() {
  const modal = document.getElementById('receipt-modal');
  if (modal) modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
  const btnDownloadKartu = document.getElementById('btn-download-kartu');
  if (btnDownloadKartu) {
    btnDownloadKartu.addEventListener('click', function () {
      const originalText = this.innerHTML;
      this.innerHTML = '<span class="material-symbols-outlined text-[20px] animate-spin">refresh</span> <span class="font-label-lg text-label-lg">Menyiapkan PDF...</span>';
      setTimeout(() => {
        this.innerHTML = '<span class="material-symbols-outlined text-[20px] text-secondary">check_circle</span> <span class="font-label-lg text-label-lg">Kartu Berhasil Diunduh!</span>';
        setTimeout(() => {
          this.innerHTML = originalText;
        }, 2500);
      }, 1000);
    });
  }

  const receiptModal = document.getElementById('receipt-modal');
  if (receiptModal) {
    receiptModal.addEventListener('click', function (e) {
      if (e.target === receiptModal) {
        closeReceipt();
      }
    });
  }
});
