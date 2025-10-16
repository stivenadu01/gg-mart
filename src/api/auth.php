<?php

models('user');
require ROOT_PATH . '/config/api_init.php';

$logout = $_GET['logout'] ?? null;
$login = $_GET['login'] ?? null;

$res = [];
$status = 200;
switch ($method) {
  case "GET":
    // Logout /api/auth?logout=true
    if ($logout) {
      if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        setcookie('user', '', time() - 86400, '/'); // Hapus cookie
        $res = ['success' => true, 'message' => 'Logout berhasil.'];
      } else {
        $res = ['success' => false, 'message' => 'Gagal logout.'];
        $status = 400;
      }
      break;
    }

  case "POST":
    // login
    if ($login) {
      if (!$input_data['email'] || !$input_data['password']) {
        $res = ['success' => false, 'message' => 'email dan password wajib di isi.'];
        $status = 400;
        break;
      }
      $user = findUserByEmail($input_data['email']);
      if ($user && password_verify($input_data['password'], $user['password'])) {
        // Login berhasil
        // Jika "Remember Me" dicentang, set cookie (opsional)
        if (isset($input_data['remember-me'])) {
          setcookie('user', serialize($user), time() + 86400 * 30, '/'); // Cookie berlaku selama 1 bulan
        }
        unset($user['password']);
        $_SESSION['user'] = $user;
        $res = ['success' => true, 'message' => 'Login berhasil.', "user" => $user];
        break;
      } else {
        $res = ['success' => false, 'message' => 'Email atau kata sandi salah.'];
        $status = 400;
        break;
      }
    }
}

respond_json($res, $status);
