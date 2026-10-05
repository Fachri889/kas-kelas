/**
 * Kas Kelas - Pembayaran Kas Page Logic (js/pembayaran.js)
 */

function openInputModal(studentName, nis, amount = 5000) {
  const modal = document.getElementById('quickInputModal');
  const select = document.getElementById('modalStudentSelect');
  const nominalInput = document.getElementById('modalNominal');

  if (select && nis) {
    select.value = nis;
  }
  if (nominalInput) {
    nominalInput.value = amount;
  }

  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function closeInputModal() {
  const modal = document.getElementById('quickInputModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

function handleFormSubmit(event) {
  event.preventDefault();
  const select = document.getElementById('modalStudentSelect');
  const studentName = select ? select.options[select.selectedIndex].text : 'Siswa';
  const nominal = document.getElementById('modalNominal')?.value || 5000;

  alert(`Pembayaran berhasil disimpan!\nSiswa: ${studentName}\nNominal: Rp ${Number(nominal).toLocaleString('id-ID')}\nKuitansi digital telah digenerate.`);
  closeInputModal();
}

document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('quickInputModal');
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        closeInputModal();
      }
    });
  }
});
