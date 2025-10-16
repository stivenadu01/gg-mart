<?php
$pageTitle = "Kelola Kategori";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="kelolaKategoriPage()" x-init="fetchKategori()" class=" bg-gray-50 min-h-[100dvh] space-y-3">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center lg:p-5 p-3 md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800">Kelola Kategori</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh kategori GG-Mart dari sini.</p>
    </div>

    <!-- SEARCH + ADD -->
    <div class="flex items-center gap-3">
      <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
        <input type="text" x-model="search" placeholder="Cari kategori..."
          class="rounded-r-none w-48 md:w-64">
        <button type="submit"
          class="bg-gg-primary text-white rounded-r-md font-medium">Cari</button>
      </form>

      <a :href="baseUrl + '/admin/kategori/form?act=tambah'"
        class="bg-gg-accent hover:opacity-90 text-white">
        <span class="text-lg">+</span>
        <span class="hidden md:inline">Tambah</span>
      </a>
    </div>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . '/loading.php' ?>

  <!-- TABEL KATEGORI -->
  <?php include INCLUDES_PATH . '/admin/table_kategori.php' ?>


  <!-- KOSONG -->
  <template x-if="!loading && kategori.length === 0">
    <div class="bg-white rounded-lg shadow p-12 text-center border border-gray-200">
      <h3 class="text-lg font-semibold text-neutral-900S">Tidak ada kategori</h3>
      <p class="text-sm text-neutral-500 mb-4">Tambahkan kategori baru untuk mulai mengelola produk.</p>
      <a :href=" baseUrl + '/admin/kategori/form?act=tambah'"
        class="inline-block bg-gg-primary hover:bg-gg-primary/80 text-white px-6 py-2 rounded-md font-medium shadow-sm">Tambah
        Kategori</a>
    </div>
  </template>

</div>


<script src="<?= ASSETS_URL . 'js/kelolaKategoriPage.js' ?>"></script>
<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>