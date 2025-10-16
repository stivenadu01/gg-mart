<?php
$pageTitle = "Riwayat Transaksi";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="riwayatTransaksiPage()" x-init="fetchTransaksi()" class="bg-gray-50 space-y-3">

  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-3 lg:p-5">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800 tracking-tight">Riwayat Transaksi</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh riwayat transaksi GG-Mart dari sini.</p>
    </div>
    <div>
      <button @click="showFilter = !showFilter" class="md:hidden bg-gg-primary rounded-md flex    text-white items-center justify-center gap-2">
        Filter
        <!-- SVG Filter Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
      </button>
    </div>
  </div>

  <!-- FILTER -->
  <div :class="showFilter ? 'block' : 'hidden md:block'"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition transform ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="px-3 md:px-5">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
      <label>Cari transaksi</label>
      <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
        <input type="text" x-model="search" placeholder="TRX_12345678"
          class="border rounded px-2 py-1 w-full sm:w-auto">
        <button type="submit"
          class="hidden"></button>
      </form>
      <label>Tanggal Mulai
        <input type="date" x-model="filter.start"
          class="w-full sm:w-auto">
      </label>
      <label>Tanggal Selesai
        <input type="date" x-model="filter.end"
          class="w-full sm:w-auto">
      </label>
      <label>
        Metode Pembayaran
        <select x-model="filter.metode" class="w-full sm:w-auto">
          <option value="">Semua Metode</option>
          <option value="TUNAI">Tunai</option>
          <option value="QRIS">QRIS</option>
        </select>
      </label>
      <button @click="goPage(1)"
        class="bg-gg-accent hover:opacity-80 text-white px-4 py-1 sm:py-2 rounded w-full sm:w-auto">Tampilkan</button>
    </div>
  </div>

  <!-- LOADING -->
  <?php include INCLUDES_PATH . "/loading.php" ?>


  <!-- TABEL RIWAYAT TRANSAKSI -->
  <?php include INCLUDES_PATH . "/admin/table_riwayat_transaksi.php" ?>

  <!-- KOSONG -->
  <template x-if="!loading && transaksi.length === 0">
    <div class="bg-white rounded-lg shadow p-12 text-center border border-gray-200">
      <h3 class="text-lg font-semibold text-gray-800">tidak ada transaksi</h3>
    </div>
  </template>

  <!-- MODAL DETAIL TRANSAKSI -->
  <div x-show="modalDetail" class="fixed inset-0 -top-10 bg-black/40 flex items-center justify-center z-50 px-2 sm:px-0" @click.self="modalDetail=false">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-4 sm:p-6 space-y-4">
      <div class="flex border-b pb-2 justify-between">
        <h2 class="text-lg font-bold text-gray-800">Detail Transaksi</h2>
        <!-- Tombol batal -->
        <button @click="batalTransaksi" class="bg-red-500 text-white hover:opacity-90">
          Batalkan transaksi ini?
        </button>
      </div>
      <template x-if="detail">
        <div class="overflow-x-auto">
          <p><strong>Kode:</strong> <span x-text="detail.kode_transaksi"></span></p>
          <p><strong>Tanggal:</strong> <span x-text="formatDateTime(detail.tanggal_transaksi)"></span></p>
          <p><strong>Metode:</strong> <span x-text="detail.metode_bayar"></span></p>
          <table class="w-full mt-3 border-t text-sm min-w-sm overflow-x-auto">
            <thead>
              <tr class="text-left bg-gray-50">
                <th class>Produk</th>
                <th class="text-center">Jumlah</th>
                <th class=text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="d in detail.detail" :key="d.kode_produk">
                <tr>
                  <td x-text="d.nama_produk"></td>
                  <td class="text-center" x-text="d.jumlah"></td>
                  <td class="text-right" x-text="formatRupiah(d.subtotal)"></td>
                </tr>
              </template>
            </tbody>
          </table>
          <div class="text-right font-bold mt-3 text-gray-800">
            Total: <span x-text="formatRupiah(detail.total_harga)"></span>
          </div>
        </div>
      </template>
      <div class="text-right">
        <button @click="modalDetail=false" class="mt-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= ASSETS_URL ?>/js/riwayatTransaksiPage.js"></script>

<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>