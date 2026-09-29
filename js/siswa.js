/**
 * Kas Kelas - Data Siswa Page Logic (js/siswa.js)
 */

document.addEventListener('DOMContentLoaded', function () {
  // Filter buttons (Semua, Lunas, Menunggak)
  const filterButtons = document.querySelectorAll('[data-filter]');
  filterButtons.forEach((btn) => {
    btn.addEventListener('click', function () {
      const filter = this.getAttribute('data-filter');

      // Update button styles
      filterButtons.forEach((b) => {
        b.classList.remove('bg-primary-container', 'text-on-primary');
        b.classList.add('bg-surface-container-low', 'text-on-surface-variant');
      });
      this.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
      this.classList.add('bg-primary-container', 'text-on-primary');

      // Filter table rows
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row) => {
        if (filter === 'all') {
          row.style.display = '';
        } else if (filter === 'lunas') {
          const isLunas = row.innerText.toLowerCase().includes('lunas');
          row.style.display = isLunas ? '' : 'none';
        } else if (filter === 'menunggak') {
          const isMenunggak = row.innerText.toLowerCase().includes('menunggak');
          row.style.display = isMenunggak ? '' : 'none';
        }
      });
    });
  });
});
