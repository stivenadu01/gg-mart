<?php
$pageTitle = "Kelola Item Stok";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="kelolaItemStokPage()" x-init="fetchItemStok()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Kelola Item Stok</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola item-item yang digunakan sebagai bahan baku atau unit stok dasar.</p>
    </div>

    <div class="flex items-center gap-3">
      <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
        <input type="text" x-model="search" placeholder="Cari item stok..."
          class="rounded-r-none w-48 md:w-64">
        <button type="submit"
          class="bg-gg-primary text-white px-4 py-2.5 rounded-r-lg font-medium">Cari</button>
      </form>

      <a :href="baseUrl + '/admin/stok/item_form?act=tambah'"
        class="btn btn-accent px-3 py-2.5 w-auto">
        <span class="text-lg leading-none">+</span>
        <span class="hidden md:inline">Tambah</span>
      </a>
    </div>
  </div>

  <?php include INCLUDES_PATH . '/loading.php' ?>

  <?php include INCLUDES_PATH . '/admin/table_item_stok.php' ?>

  <template x-if="!loading && items.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <img :src="baseUrl + '/assets/img/no-data.webp'" alt="Tidak ada item stok"
        class="mx-auto w-28 h-28 opacity-60 mb-4">
      <h3 class="text-xl font-semibold text-gray-800">Tidak ada Item Stok</h3>
      <p class="text-sm text-gray-500 mb-4">Tambahkan Item Stok baru (misal: Beras, Gula) untuk mulai mengelola inventaris.</p>
      <a :href="baseUrl + '/admin/stok/item_form?act=tambah'"
        class="btn btn-primary px-6 py-2.5 w-auto">Tambah Item Stok</a>
    </div>
  </template>
</div>

<script src="<?= ASSETS_URL . '/js/kelolaItemStokPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>