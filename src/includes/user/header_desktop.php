<div class="hidden md:block sticky top-0 z-40">
  <!-- Header -->
  <header class="w-full bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
      <!-- Kiri: Logo -->
      <div class="flex items-center space-x-6">
        <!-- Logo -->
        <a href="<?= url() ?>" class="text-green-600 font-bold text-2xl">
          <img src="<?= assets_url('logo.png') ?>" alt="GG-MART" class="h-10">
        </a>
      </div>

      <!-- Tengah: Search Bar -->
      <div class="flex-1 mx-4">
        <div class="relative">
          <form action="<?= url('produk') ?>">
            <input
              name="q"
              value="<?= isset($q) ? $q : null ?>"
              type="text"
              placeholder="Cari di GG-Mart..."
              class="w-full border rounded-lg py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-green-500" />
            <input type="hidden" name="urutkan" value="<?= isset($urutkan) ? $urutkan : null ?>">
          </form>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
          </svg>
        </div>
      </div>

      <!-- Kanan: Ikon -->
      <div class="flex items-center space-x-4">
        <!-- Keranjang -->
        <button class="relative hover:text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 6.45A1 1 0 007 21h10a1 1 0 00.95-.68L21 13H7z" />
          </svg>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
        </button>

        <!-- Notifikasi -->
        <button class="hover:text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>

        <!-- Pesan -->
        <button class="hover:text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18zm0 0v-2m0-4h.01" />
          </svg>
        </button>

        <!-- Garis pemisah -->
        <div class="w-px h-6 bg-gray-300"></div>

        <!-- Admin Dashboard -->
        <?php if (isAdmin()): ?>
          <a href="<?= url('admin/dashboard') ?>" class="items-center space-x-1 hover:text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M4 7v13h16V7M4 7l8-4 8 4" />
            </svg>
            <span>Admin</span>
          </a>
        <?php endif; ?>

        <!-- Profil -->
        <button class="flex items-center space-x-1 hover:text-green-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z" />
          </svg>
          <span class="font-medium">
            AKUN
          </span>
        </button>
      </div>
    </div>
  </header>
</div>

<main>