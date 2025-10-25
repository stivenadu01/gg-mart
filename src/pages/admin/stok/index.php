<?php
$pageTitle = "Kelola Stok";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="kelolaStokPage()" x-init="fetchMutasiStok()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Kelola Perubahan Stok Produk</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola perubahan stok produk GGMart dari sini.</p>
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

      <a :href="baseUrl + '/admin/stok/form'"
        class="btn btn-accent px-5 py-2.5 w-auto rounded-lg font-semibold">
        + <span class="hidden sm:inline">Tambah perubahan stok</span>
      </a>
    </div>
  </div>

  <!-- FILTER -->
  <div :class="showFilter ? 'block' : 'hidden md:block'"
    x-transition
    class="bg-white rounded-xl shadow-md p-4 border border-gray-100">

    <form @submit.prevent="applyFilter()" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-3 items-end">

      <div class="lg:col-span-3">
        <label for="filter_search" class="text-xs font-semibold text-gray-600 mb-1 block">Cari Item</label>
        <div class="relative">
          <input type="text" id="filter_search" x-model.debounce.500ms="filter.search"
            placeholder="Cari Item"
            class="w-full form-input h-10 border border-gray-300 rounded-lg pl-10 pr-4 text-sm focus:border-gg-primary focus:ring-gg-primary">
          <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
            xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
      </div>

      <div class="sm:col-span-1">
        <label for="filter_type" class="text-xs font-semibold text-gray-600 mb-1 block">Tipe</label>
        <select id="filter_type" x-model="filter.type"
          class="w-full form-select h-10 border border-gray-300 rounded-lg focus:border-gg-primary focus:ring-gg-primary text-sm">
          <option value="">Semua</option>
          <option value="masuk">Stok Masuk</option>
          <option value="keluar">Stok Keluar</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary h-10 px-4 w-full sm:col-span-1">Terapkan</button>

      <button type="button" @click="resetFilter"
        :disabled="!filter.type && !filter.search"
        class="btn bg-gray-100 text-gray-700 h-10 px-4 w-full sm:col-span-1 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
        Reset
      </button>
    </form>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . '/loading.php' ?>

  <!-- TABLE -->
  <?php include INCLUDES_PATH . '/admin/table_mutasi_stok.php' ?>

  <!-- KOSONG -->
  <template x-if="!loading && mutasiStok.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <div class="mx-auto w-24 h-24 flex items-center justify-center mb-4 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="1.5" stroke="currentColor" class="w-24 h-24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 7.5V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v1.5M3 7.5h18m-18 0v10.125A2.25 2.25 0 005.25 19.875h13.5A2.25 2.25 0 0021 17.625V7.5M8.25 10.5h7.5" />
        </svg>
      </div>
      <h3 class="text-xl font-semibold text-gray-800">Belum ada perubahan stok</h3>
      <p class="text-sm text-gray-500 mb-4">Tambahkan perubahan stok untuk memulai pencatatan.</p>
      <a :href="baseUrl + '/admin/stok/form'" class="btn btn-accent px-6 py-2.5 w-auto">
        + Tambah perubahan stok</span>
      </a>
    </div>
  </template>
</div>

<script src="<?= ASSETS_URL . '/js/kelolaStokPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>