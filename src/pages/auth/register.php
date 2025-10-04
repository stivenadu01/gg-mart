<?php

models('user');

// Proses register
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $no_hp = '+62' . ($_POST['no_hp'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';

  // Validasi sederhana
  $errors = [];
  if (empty($name)) {
    $errors[] = "Nama lengkap harus diisi.";
  }
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email tidak valid.";
  }
  if (emailExists($email)) {
    $errors[] = "Email sudah terdaftar.";
  }
  if (empty($_POST['no_hp']) || !preg_match('/^[1-9][0-9]{9,14}$/', $_POST['no_hp'])) {
    $errors[] = "Nomor HP tidak valid. Masukkan tanpa 0 di depan dan hanya angka setelah +62.";
  }
  if (empty($password) || strlen($password) < 6) {
    $errors[] = "Kata sandi harus memiliki minimal 6 karakter.";
  }
  if ($password !== $confirmPassword) {
    $errors[] = "Kata sandi dan konfirmasi kata sandi tidak sesuai.";
  }

  if (!empty($errors)) {
    foreach ($errors as $error) {
      set_flash($error, 'error');
    }
  } else {
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Simpan ke database
    if (createUser($name, $email, $no_hp, $hashedPassword)) {
      set_flash("Registrasi berhasil! Silakan masuk.", 'success');
      redirect('auth/login');
    } else {
      set_flash("Terjadi kesalahan saat registrasi. Silakan coba lagi.", 'error');
    }
  }
}

$pageTitle = "Daftar Akun";
include COMPONENTS_PATH . '/header.php';
?>

<div class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Buat akun baru</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Atau
        <a href="<?= url('auth/login') ?>" class="font-medium text-green-600 hover:text-green-500"> Masuk ke akun Anda </a>
      </p>
    </div>
    <form class="mt-8 space-y-6" action="" method="POST">
      <input type="hidden" name="remember" value="true">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="name" class="sr-only">Nama Lengkap</label>
          <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Nama Lengkap" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>
        <div>
          <label for="email-address" class="sr-only">Email</label>
          <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div>
          <label for="no_hp" class="sr-only">Nomor HP</label>
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm">+62</span>
            <input id="no_hp" name="no_hp" type="text" autocomplete="tel" required class="appearance-none rounded-none rounded-r-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Nomor HP (tanpa 0 di depan)" value="<?= htmlspecialchars(ltrim($_POST['no_hp'] ?? '', '0')) ?>">
          </div>
        </div>
        <div>
          <label for="password" class="sr-only">Kata Sandi</label>
          <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Kata Sandi">
        </div>
        <div>
          <label for="confirm_password" class="sr-only">Konfirmasi Kata Sandi</label>
          <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Konfirmasi Kata Sandi">
        </div>
      </div>
      <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/user-plus -->
            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM16 7h2a1 1 0 110 2h-2v2a1 1 0 11-2 0V9h-2a1 1 0 110-2h2V5a1 1 0 112 0v2z" />
            </svg>
          </span>
          Daftar
        </button>
      </div>
    </form>
  </div>
</div>
<?php include COMPONENTS_PATH . '/footer.php'; ?>