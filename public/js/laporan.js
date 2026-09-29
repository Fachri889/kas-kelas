/**
 * Kas Kelas - Laporan Keuangan Page Logic (js/laporan.js)
 */

function triggerDownloadFeedback(fileType) {
  const toast = document.getElementById('toastNotification');
  const title = document.getElementById('toastTitle');
  const desc = document.getElementById('toastDesc');

  if (!toast || !title || !desc) return;

  title.textContent = 'Mengekspor ' + fileType;
  desc.textContent = 'Menyiapkan berkas LPJ resmi kelas XII MIPA 2...';

  toast.classList.remove('hidden');
  setTimeout(() => {
    toast.classList.remove('translate-y-4');
  }, 10);

  setTimeout(() => {
    title.textContent = fileType + ' Siap Diunduh!';
    desc.textContent = 'Dokumen resmi telah selesai diproses.';
  }, 900);

  setTimeout(() => {
    toast.classList.add('translate-y-4');
    setTimeout(() => {
      toast.classList.add('hidden');
    }, 300);
  }, 3500);
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btnExportPdf')?.addEventListener('click', function () {
    triggerDownloadFeedback('Dokumen PDF Resmi');
  });

  document.getElementById('btnExportExcel')?.addEventListener('click', function () {
    triggerDownloadFeedback('Spreadsheet Excel (.xlsx)');
  });
});
