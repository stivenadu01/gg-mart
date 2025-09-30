<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
  'lifetime' => 60 * 60 * 24, // 1 hari
  'path' => '/',
  'domain' => $_SERVER['HTTP_HOST'],
  'secure' => isset($_SERVER['HTTPS']), // hanya cookie di HTTPS
  'httponly' => true,
]);

session_start();

if (!isset($_SESSION['last_regenerate'])) {
  regenerate_session_id();
} else {
  $interval = 60 * 30; // 30 menit
  if (time() - $_SESSION['last_regenerate'] > $interval) {
    regenerate_session_id();
  }
}

function regenerate_session_id()
{
  session_regenerate_id(true);
  $_SESSION['last_regenerate'] = time();
}
