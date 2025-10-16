<?php
$pageTitle = 'Login';

require INCLUDES_PATH . "/user/layout/header.php"
?>

<div class="min-h-[100dvh] flex items-center justify-center bg-gray-50" x-data="loginPage()">
  <div class="max-w-md w-full space-y-6 bg-white p-8 shadow-md rounded-md">
    <div>
      <h2 class="mt-3 text-center text-3xl font-extrabold text-gray-900">Masuk ke akun Anda</h2>
    </div>
    <form @submit.prevent="fetchLogin" class="mt-8 space-y-6">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email" class="sr-only">Email</label>
          <input id="email" type="email" x-model="email" autocomplete="email" class="appearance-none relative block w-full px-3 placeholder-gray-500 text-neutral-900 rounded-b-none focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm hover:scale-100 focus:scale-100" placeholder="Email">
        </div>
        <div>
          <label for="password" class="sr-only">Kata Sandi</label>
          <input id="password" type="password" x-model="password" autocomplete="current-password" class="appearance-none relative block w-full placeholder-gray-500 text-gray-900 rounded-t-none focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm hover:scale-100 focus:scale-100" placeholder="Kata Sandi">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember-me" x-model="rememberMe" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
          <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Ingat saya </label>
        </div>
        <div class="text-sm">
          <a href="#" class="font-medium text-green-600 hover:text-green-500"> Lupa kata sandi? </a>
        </div>
      </div>
      <div>
        <button type="submit" class="group relative w-full flex justify-center border-transparent text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/lock-closed -->
            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          Masuk
        </button>
      </div>
    </form>
  </div>
</div>


<script src="<?= ASSETS_URL . '/js/loginPage.js' ?>"></script>

<?php
require INCLUDES_PATH . "/user/layout/footer.php";
