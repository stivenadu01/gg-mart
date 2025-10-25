<?php
$pageTitle = "Kelola Kategori";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="kelolaKategoriPage()" x-init="fetchKategori()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Kelola Kategori</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh kategori GG MART dari sini.</p>
    </div>

    <div class="flex items-center gap-3">
      <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
        <input type="text" x-model="search" placeholder="Cari kategori..."
          class="">
        <button type="submit"
          class="bg-gg-primary hover:bg-gg-primary/80 text-white px-4 py-2.5 rounded-r-lg font-medium">Cari</button>
      </form>

      <a :href="baseUrl + '/admin/kategori/form?act=tambah'"
        class="btn btn-accent w-auto py-1.5">
        <span class="text-lg">+</span>
        <span class="hidden md:inline">Tambah Kategori</span>
      </a>
    </div>
  </div>

  <?php include INCLUDES_PATH . '/loading.php' ?>

  <?php include INCLUDES_PATH . '/admin/table_kategori.php' ?>


  <template x-if="!loading && kategori.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <h3 class="text-xl font-semibold text-gray-500">Tidak ada kategori</h3>
      <p class="text-sm text-gray-500 mb-4">Tambahkan kategori baru untuk mulai mengelompokan produk.</p>
      <a :href=" baseUrl + '/admin/kategori/form?act=tambah'"
        class="btn btn-primary px-6 py-2.5 w-auto">Tambah Kategori</a>
    </div>
  </template>

</div>


<script src="<?= ASSETS_URL . '/js/kelolaKategoriPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>