<?php
$pageTitle = "Kelola Produk";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="kelolaProdukPage()" x-init="fetchProduk()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Kelola Produk</h1>
      <p class="text-sm text-gray-500">Atur dan pantau semua produk GGMART dari sini.</p>
    </div>

    <div class="flex items-center gap-3">
      <button @click="showFilter = !showFilter"
        class="md:hidden btn bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2.5 w-auto flex items-center gap-1 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
          viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
        Filter
      </button>

      <a :href="baseUrl + '/admin/produk/form'"
        class="btn btn-accent px-5 py-2.5 w-auto rounded-lg font-semibold">
        + <span class="hidden sm:inline">Tambah Produk</span>
      </a>
    </div>
  </div>

  <!-- FILTER -->
  <div :class="showFilter ? 'block' : 'hidden md:block'"
    x-transition
    class="bg-white rounded-xl shadow-md p-4 border border-gray-100">

    <form @submit.prevent="applyFilter()" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-3 items-end">

      <!-- SEARCH -->
      <div class="lg:col-span-3">
        <label for="filter_search" class="text-xs font-semibold text-gray-600 mb-1 block">Cari Produk</label>
        <div class="relative">
          <input type="text" id="filter_search" x-model.debounce.500ms="filter.search"
            placeholder="Cari berdasarkan nama atau kode produk"
            class="w-full form-input h-10 border border-gray-300 rounded-lg pl-10 pr-4 text-sm focus:border-gg-primary focus:ring-gg-primary">
          <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
            xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
      </div>

      <!-- SORT -->
      <div class="sm:col-span-2">
        <label for="filter_sort" class="text-xs font-semibold text-gray-600 mb-1 block">Urutkan Berdasarkan</label>
        <select id="filter_sort" x-model="filter.sort"
          class="w-full form-select h-10 border border-gray-300 rounded-lg focus:border-gg-primary focus:ring-gg-primary text-sm">
          <option value="tanggal_dibuat">Tanggal Dibuat</option>
          <option value="nama_produk">Nama Produk</option>
          <option value="stok">Stok</option>
          <option value="terjual">Terjual</option>
        </select>
      </div>

      <!-- DIRECTION -->
      <div class="sm:col-span-1">
        <label for="filter_dir" class="text-xs font-semibold text-gray-600 mb-1 block">Arah</label>
        <select id="filter_dir" x-model="filter.dir"
          class="w-full form-select h-10 border border-gray-300 rounded-lg focus:border-gg-primary focus:ring-gg-primary text-sm">
          <option value="DESC">Menurun</option>
          <option value="ASC">Menaik</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary h-10 px-4 w-full sm:col-span-1">Terapkan</button>
      <button type="button" @click="resetFilter"
        :disabled="!filter.search && filter.sort === 'tanggal_dibuat' && filter.dir === 'DESC'"
        class="btn bg-gray-100 text-gray-700 h-10 px-4 w-full sm:col-span-1 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
        Reset
      </button>
    </form>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . '/loading.php' ?>


  <!-- TABEL -->
  <?php include INCLUDES_PATH . '/admin/table_produk.php' ?>

  <!-- KOSONG -->
  <template x-if="!loading && produk.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <img :src="baseUrl + '/assets/img/no-image.webp'" alt="Tidak ada data"
        class="mx-auto w-28 h-28 opacity-60 mb-4">
      <h3 class="text-xl font-semibold text-gray-800">Belum ada produk</h3>
      <p class="text-sm text-gray-500 mb-4">Tambahkan produk baru untuk memulai.</p>
      <a :href="baseUrl + '/admin/produk/form'" class="btn btn-accent px-6 py-2.5 w-auto">
        + <span class="hidden sm:inline">Tambah Produk</span>
      </a>
    </div>
  </template>
</div>

<script src="<?= ASSETS_URL . '/js/kelolaProdukPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>