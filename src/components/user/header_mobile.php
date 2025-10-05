<div x-data="{ openMenu: false }" class="md:hidden sticky top-0 z-50">
  <!-- Header atas -->
  <div class="bg-white shadow p-2 flex items-center space-x-2 ">
    <?php if ($page != "home") : ?>
      <!-- Tombol kembali -->
      <button onclick="history.back()" class="p-1 text-green-600 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="w-6 h-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 19l-7-7 7-7" />
        </svg>
      </button>
    <?php endif; ?>
    <!-- Input pencarian -->
    <input type="text" placeholder="Cari di GG-Mart..."
      name="q"
      value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
      class="flex-1 border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

    <!-- Tombol Keranjang -->
    <button class="p-1 text-green-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 6.45A1 1 0 007 21h10a1 1 0 00.95-.68L21 13H7z" />
      </svg>
    </button>

    <!-- Notifikasi -->
    <button class="p-1 text-green-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
    </button>

    <!-- tombol menu -->
    <button @click="openMenu = true" class="p-1 text-green-600">
      <!-- Heroicon: Bars -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16m0 6H4" />
      </svg>
    </button>
  </div>

  <!-- Menu utama -->
  <div
    x-show="openMenu"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
    class="fixed inset-0 bg-white z-[1000] flex flex-col p-6">
    <!-- Tombol tutup -->
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-lg font-bold text-green-600">Menu</h2>
      <button @click="openMenu = false" class="text-green-600 p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Isi menu -->
    <ul class="space-y-6 text-lg font-semibold">
      <li><a href="<?= BASE_URL ?>" class="block text-green-600">🏠 Beranda</a></li>
      <li><a href="<?= BASE_URL . '/produk' ?>" class="block text-green-600">🛍️ Produk</a></li>
      <li><a href="<?= BASE_URL . '/transaksi' ?>" class="block text-green-600">📦 Transaksi</a></li>
      <li><a href="<?= BASE_URL . '/akun' ?>" class="block text-green-600">👤 Akun</a></li>
      <?php if (isAdmin()): ?>
        <li><a href="<?= BASE_URL . '/admin/dashboard' ?>" class="block text-green-600">⚙️ Admin Dashboard</a></li>
      <?php endif; ?>
    </ul>

    <div class="mt-auto">
      <button @click="openMenu = false"
        class="w-full py-2 bg-green-600 text-white rounded-lg font-semibold">Tutup</button>
    </div>
  </div>
</div>

<main class="p-4 pb-20 bg-gray-50">