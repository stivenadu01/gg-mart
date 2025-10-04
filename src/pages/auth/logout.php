<?php

if (isset($_SESSION['user'])) {
  unset($_SESSION['user']);
  setcookie('user', '', time() - 3600, '/'); // Hapus cookie
  set_flash('Anda telah logout.', 'success');
  redirect('auth/login');
}


redirect('auth/login');
exit;
