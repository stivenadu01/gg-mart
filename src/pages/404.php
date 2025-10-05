<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GG MART | 404</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="<?= ASSETS_PATH ?>/css/app.css" rel="stylesheet">
  <!-- <script src="https://unpkg.com/alpinejs" defer></script> -->
  <script src="<?= ASSETS_PATH ?>/js/cdn.min.js" defer></script>
</head>

<body>
  <div class="min-h-screen flex items-center justify-center text-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
      <h1 class="text-9xl font-extrabold text-green-700 animate-pulse">404</h1>
      <p class="mt-4 text-3xl font-bold text-gray-800">Ups, Halaman tidak ditemukan!</p>
      <p class="mt-2 text-lg text-gray-600">Sepertinya halaman yang Anda tuju sudah hilang atau tidak pernah ada.</p>

      <div class="mt-8 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="<?= BASE_URL ?>" class="w-full sm:w-auto px-6 py-3 rounded-full text-white font-bold transition-transform transform hover:scale-105 shadow-lg bg-green-700 hover:bg-green-900">
          Kembali ke Beranda
        </a>
        <a href="<?= BASE_URL ?>/produk" class="w-full sm:w-auto px-6 py-3 rounded-full text-gg-text font-bold border border-gg-text transition-transform transform hover:scale-105">
          Telusuri Produk
        </a>
      </div>

      <p class="mt-8 text-sm text-gray-500">
        Jika Anda yakin ini adalah kesalahan, silakan <a href="mailto:support@gg-mart.com" class="text-green-600 hover:underline">hubungi dukungan</a> kami.
      </p>
    </div>
  </div>
</body>

</html>