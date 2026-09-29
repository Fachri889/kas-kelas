/**
 * Kas Kelas - Login & Authentication Logic (js/login.js)
 */

function selectRole(role) {
  const treasurerBtn = document.getElementById('role-treasurer');
  const studentBtn = document.getElementById('role-student');
  const identityLabel = document.getElementById('identity-label');
  const identityInput = document.getElementById('user-identity');

  if (!treasurerBtn || !studentBtn || !identityLabel || !identityInput) return;

  if (role === 'treasurer') {
    treasurerBtn.className = 'flex-1 py-2 px-3 rounded-lg font-label-lg text-label-lg transition-all duration-200 flex items-center justify-center gap-2 bg-surface-container-lowest text-primary shadow-sm';
    studentBtn.className = 'flex-1 py-2 px-3 rounded-lg font-label-lg text-label-lg transition-all duration-200 flex items-center justify-center gap-2 text-on-surface-variant hover:text-on-surface';
    identityLabel.textContent = 'Username atau Email Pengurus';
    identityInput.placeholder = 'admin@kas.sekolah atau nama bendahara...';
  } else {
    studentBtn.className = 'flex-1 py-2 px-3 rounded-lg font-label-lg text-label-lg transition-all duration-200 flex items-center justify-center gap-2 bg-surface-container-lowest text-primary shadow-sm';
    treasurerBtn.className = 'flex-1 py-2 px-3 rounded-lg font-label-lg text-label-lg transition-all duration-200 flex items-center justify-center gap-2 text-on-surface-variant hover:text-on-surface';
    identityLabel.textContent = 'Nomor Induk Siswa (NIS)';
    identityInput.placeholder = 'Masukkan 6 atau 10 digit NIS siswa...';
  }
}

function togglePassword() {
  const passwordInput = document.getElementById('user-password');
  const toggleIcon = document.getElementById('password-toggle-icon');

  if (!passwordInput || !toggleIcon) return;

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    toggleIcon.textContent = 'visibility_off';
  } else {
    passwordInput.type = 'password';
    toggleIcon.textContent = 'visibility';
  }
}
