<?php
// 🔒 Hindari konfigurasi session untuk CLI (misal saat jalankan seeder)
if (php_sapi_name() !== 'cli') {
  // ini_set('session.cookie_httponly', 1);
  // ini_set('session.use_strict_mode', 1);

  // session_set_cookie_params([
  //   'lifetime' => 60, // 1 menit
  //   'path' => '/',
  //   'domain' => $_SERVER['HTTP_HOST'] ?? '',
  //   'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
  //   'httponly' => true,
  // ]);

  // if (session_status() === PHP_SESSION_NONE) {
  session_start();
  // }

  // if (!isset($_SESSION['last_regenerate'])) {
  //   regenerate_session_id();
  // } else {
  //   $interval = 60 * 60 * 24; // 1 hari
  //   if (time() - $_SESSION['last_regenerate'] > $interval) {
  //     regenerate_session_id();
  //   }
  // }
}

function regenerate_session_id()
{
  if (session_status() === PHP_SESSION_ACTIVE) {
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
  }
}
