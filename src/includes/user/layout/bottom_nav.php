<div class="md:hidden">
  <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-2 text-sm z-40">
    <!-- Home -->
    <a href="<?= url() ?>" class="flex flex-col items-center <?= $page == 'home' ? 'text-green-600' : 'text-gray-600' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3 9.75L12 3l9 6.75V21a.75.75 0 0 1-.75.75H3.75A.75.75 0 0 1 3 21V9.75zM9 21v-6h6v6H9z" />
      </svg>
      <span>Home</span>
    </a>

    <!-- Produk -->
    <a href="<?= url('produk') ?>" class="flex flex-col items-center <?= $page == 'produk' ? 'text-green-600' : 'text-gray-600' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3 3h8v8H3V3zm0 10h8v8H3v-8zm10-10h8v8h-8V3zm0 10h8v8h-8v-8z" />
      </svg>
      <span>Produk</span>
    </a>

    <!-- Transaksi -->
    <a href="<?= url('transaksi') ?>" class="flex flex-col items-center <?= $page == 'transaksi' ? 'text-green-600' : 'text-gray-600' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3 5h18v2H3V5zm2 4h14v10H5V9zm2 2v6h10v-6H7z" />
      </svg>
      <span>Transaksi</span>
    </a>

    <!-- Akun -->
    <a href="<?= url('akun') ?>" class="flex flex-col items-center <?= $page == 'akun' ? 'text-green-600' : 'text-gray-600' ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4 0-8 2-8 4v2h16v-2c0-2-4-4-8-4z" />
      </svg>
      <span>Akun</span>
    </a>
  </nav>
</div>