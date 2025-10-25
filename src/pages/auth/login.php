<?php
$pageTitle = 'Login Admin';

require INCLUDES_PATH . "/user/layout/header.php"
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" x-data="loginPage()">
  <div class="max-w-md w-full space-y-8 bg-white p-10 shadow-xl rounded-xl border border-gray-100">
    <div class="text-center">
      <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Masuk ke Akun Admin</h2>
      <p class="mt-2 text-sm text-red-600 font-medium">Hanya admin yang berhak mengelola GG-Mart.</p>
    </div>

    <form @submit.prevent="fetchLogin" class="mt-8 space-y-6">
      <div class="space-y-4">
        <div>
          <label for="email" class="sr-only">Email / Username</label>
          <input id="email" type="text" x-model="email" autocomplete="username" required
            class="w-full placeholder-gray-500 text-neutral-900 rounded-lg"
            placeholder="Email atau Username">
        </div>

        <div>
          <label for="password" class="sr-only">Kata Sandi</label>
          <input id="password" type="password" x-model="password" autocomplete="current-password" required
            class="w-full placeholder-gray-500 text-neutral-900 rounded-lg"
            placeholder="Kata Sandi">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember-me" x-model="rememberMe" type="checkbox" class="h-4 w-4 text-gg-primary focus:ring-gg-primary border-gray-300 rounded">
          <label for="remember-me" class="ml-2 block text-sm text-gray-700"> Ingat saya </label>
        </div>
        <div class="text-sm">
          <a href="#" class="font-medium text-gg-primary hover:text-gg-accent transition"> Lupa kata sandi? </a>
        </div>
      </div>

      <div>
        <button type="submit"
          class="btn btn-primary w-full py-2.5 flex justify-center items-center gap-2">
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
          </svg>
          Masuk
        </button>
      </div>
    </form>
  </div>
</div>


<script src="<?= ASSETS_URL . '/js/loginPage.js' ?>"></script>

<?php
require INCLUDES_PATH . "/user/layout/footer.php";
?>