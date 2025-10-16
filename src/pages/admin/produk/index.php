<?php
$pageTitle = "Kelola Produk";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="kelolaProdukPage()" x-init="fetchProduk()" class="bg-gray-50 space-y-3">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-3 lg:p-5">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800 tracking-tight">Kelola Produk</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh produk GG-Mart dari sini.</p>
    </div>

    <div class="flex items-center gap-3">
      <!-- SEARCH -->
      <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
        <input type="text" x-model="search" placeholder="Cari produk..."
          class="rounded-r-none w-48 md:w-64">
        <button type="submit"
          class="bg-gg-primary text-white rounded-r-md font-medium">Cari</button>
      </form>

      <!-- ADD -->
      <a :href="baseUrl + '/admin/produk/form?act=tambah'"
        class="bg-gg-accent hover:opacity-90 text-white">
        <span class="text-lg leading-none">+</span>
        <span class="hidden md:inline">Tambah</span>
      </a>
    </div>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . '/loading.php' ?>

  <!-- TABEL PRODUK -->
  <?php include INCLUDES_PATH . '/admin/table_produk.php' ?>

  <!-- KOSONG -->
  <template x-if="!loading && produk.length === 0">
    <div class="bg-white rounded-lg shadow p-12 text-center border border-gray-200">
      <img :src="baseUrl + '/assets/img/no-image.webp'" alt="Tidak ada produk"
        class="mx-auto w-28 h-28 opacity-60 mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Tidak ada produk</h3>
      <p class="text-sm text-neutral-500 mb-4">Tambahkan Produk baru untuk mulai berjualan.</p>
      <a :href="baseUrl + '/admin/produk/form?act=tambah'"
        class="inline-block bg-gg-primary hover:bg-gg-primary-hover text-white px-6 py-2 rounded-md font-medium shadow-sm">Tambah
        Produk</a>
    </div>
  </template>

</div>

<script src="<?= ASSETS_URL . 'js/kelolaProdukPage.js' ?>"></script>

<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>