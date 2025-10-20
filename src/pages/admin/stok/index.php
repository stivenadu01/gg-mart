<?php
$pageTitle = "Kelola Stok";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="kelolaStokPage()" x-init="fetchStok()" class="bg-gray-50 space-y-3">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-3 lg:p-5">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800 tracking-tight">Kelola Stok Produk</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola perubahan stok produk GG-Mart.</p>
    </div>

    <div class="flex items-center gap-3">
      <!-- TOMBOL TAMBAH -->
      <a :href="baseUrl + '/admin/stok/form'"
        class="bg-gg-accent hover:bg-gg-accent-hover text-white px-5 py-2 rounded-md font-medium shadow-sm">
        + Tambah Perubahan Stok
      </a>
    </div>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . '/loading.php' ?>

  <!-- TABEL -->
  <template x-if="!loading && stok.length > 0">
    <div class="md:p-3">
      <div
        class="bg-white rounded-md shadow-sm border border-gray-200 overflow-auto max-h-[80dvh] custom-scrollbar">
        <table class="table">
          <!-- HEAD -->
          <thead class="sticky top-0 bg-gray-100 z-10">
            <tr class="text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">
              <th class="p-3">Tanggal</th>
              <th class="p-3">Produk</th>
              <th class="p-3">Tipe</th>
              <th class="p-3 text-right">Jumlah</th>
              <th class="p-3">Keterangan</th>
              <th class="p-3 text-center">Aksi</th>
            </tr>
          </thead>

          <!-- BODY -->
          <tbody>
            <template x-for="s in stok" :key="s.id_stok">
              <tr>
                <!-- TANGGAL -->
                <td class="p-3 whitespace-nowrap" x-text="formatDateTime(s.tanggal)"></td>

                <!-- PRODUK -->
                <td class="p-3 whitespace-nowrap" x-text="s.nama_produk"></td>

                <!-- TIPE -->
                <td class="p-3 font-semibold">
                  <span :class="s.tipe === 'masuk' ? 'text-green-600' : 'text-red-600'"
                    x-text="s.tipe.toUpperCase()"></span>
                </td>

                <!-- JUMLAH -->
                <td class="p-3 text-right font-medium" x-text="s.jumlah"></td>

                <!-- KETERANGAN -->
                <td class="p-3 truncate max-w-[250px]" x-text="s.keterangan || '-'"></td>

                <!-- AKSI -->
                <td class="p-3 text-center">
                  <button @click="hapusRiwayat(s.id_stok, s.jumlah, s.kode_produk)"
                    class="rounded-full text-red-600 hover:bg-red-50 hover:text-red-700 p-2 transition"
                    title="Hapus Riwayat">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <!-- KOSONG -->
  <template x-if="!loading && stok.length === 0">
    <div class="bg-white rounded-lg shadow p-12 text-center border border-gray-200">
      <img :src="baseUrl + '/assets/img/no-image.webp'" alt="Tidak ada data"
        class="mx-auto w-28 h-28 opacity-60 mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Belum ada perubahan stok</h3>
      <p class="text-sm text-neutral-500 mb-4">Tambahkan perubahan stok untuk memulai pencatatan.</p>
      <a :href="baseUrl + '/admin/stok/form'"
        class="inline-block bg-gg-accent hover:bg-gg-accent-hover text-white px-6 py-2 rounded-md font-medium shadow-sm">
        + <span class="hidden sm:inline">Tambah Perubahan Stok</span>
      </a>
    </div>
  </template>
</div>

<script src="<?= ASSETS_URL . '/js/kelolaStokPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>