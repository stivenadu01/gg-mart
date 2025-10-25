<?php
$pageTitle = "Riwayat Transaksi";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="riwayatTransaksiPage()" x-init="fetchTransaksi()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Riwayat Transaksi</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh riwayat transaksi GG-Mart dari sini.</p>
    </div>
    <button @click="showFilter = !showFilter"
      class="md:hidden btn btn-accent">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
      </svg>
      Filter
    </button>
  </div>

  <div :class="showFilter ? 'block' : 'hidden md:block'"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition transform ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">

    <form @submit.prevent="goPage(1)" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">

      <div class="lg:col-span-2">
        <label for="search-input">Cari Kode Transaksi</label>
        <input id="search-input" type="text" x-model="search" placeholder="TRX_12345678">
        <button type="submit" class="hidden"></button>
      </div>

      <div>
        <label for="start-date">Tanggal Mulai</label>
        <input id="start-date" type="date" x-model="filter.start">
      </div>

      <div>
        <label for="end-date">Tanggal Selesai</label>
        <input id="end-date" type="date" x-model="filter.end">
      </div>

      <div>
        <label for="payment-method">Metode Bayar</label>
        <select id="payment-method" x-model="filter.metode">
          <option value="">Semua</option>
          <option value="TUNAI">Tunai</option>
          <option value="QRIS">QRIS</option>
        </select>
      </div>

      <button type="submit" @click.prevent="goPage(1)"
        class="btn btn-primary w-full">
        Tampilkan
      </button>
    </form>
  </div>

  <?php include INCLUDES_PATH . "/loading.php" ?>

  <div x-show="!loading" class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border border-gray-100">
    <?php include INCLUDES_PATH . "/admin/table_riwayat_transaksi.php" ?>
  </div>


  <template x-if="!loading && transaksi.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <h3 class="text-xl font-semibold text-gray-500">
        <span x-show="search || filter.start || filter.end || filter.metode">Data transaksi tidak ditemukan untuk filter ini.</span>
        <span x-show="!search && !filter.start && !filter.end && !filter.metode">Belum ada riwayat transaksi.</span>
      </h3>
    </div>
  </template>

  <div x-show="modalDetail"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
    @click.self="modalDetail=false">

    <div x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 space-y-5">

      <div class="flex justify-between items-center border-b pb-3 border-gray-200">
        <h2 class="text-xl font-extrabold text-gray-800">Detail Transaksi</h2>
        <button @click="batalTransaksi"
          class="bg-red-500 text-white btn px-3 py-1 hover:bg-red-600">
          Batalkan Transaksi
        </button>
      </div>

      <template x-if="detail">
        <div class="space-y-3">
          <div class="grid grid-cols-2 gap-2 text-sm">
            <p class="font-medium text-gray-500">Kode Transaksi</p>
            <p class="font-semibold text-gray-800 text-right" x-text="detail.kode_transaksi"></p>

            <p class="font-medium text-gray-500">Tanggal & Waktu</p>
            <p class="font-semibold text-gray-800 text-right" x-text="formatDateTime(detail.tanggal_transaksi)"></p>

            <p class="font-medium text-gray-500">Metode Pembayaran</p>
            <p class="font-semibold text-gray-800 text-right" x-text="detail.metode_bayar"></p>
          </div>

          <h3 class="text-base font-bold pt-3 border-t mt-3 text-gray-700">Item Terjual</h3>
          <div class="overflow-x-auto">
            <table class="app-table">
              <thead class="bg-gray-50">
                <tr>
                  <th class="py-2 px-3 text-left">Produk</th>
                  <th class="py-2 px-3 text-center">Qty</th>
                  <th class="py-2 px-3 text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <template x-for="d in detail.detail" :key="d.kode_produk">
                  <tr class="border-b border-gray-100 last:border-b-0">
                    <td class="py-2 px-3 text-gray-700" x-text="d.nama_produk"></td>
                    <td class="py-2 px-3 text-center text-gray-700" x-text="d.jumlah"></td>
                    <td class="py-2 px-3 text-right text-gray-700" x-text="formatRupiah(d.subtotal)"></td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>

          <div class="text-right font-extrabold text-2xl pt-3 border-t border-gray-200">
            <span class="text-gray-500 text-base">Total Akhir:</span>
            <span class="text-emerald-600" x-text="formatRupiah(detail.total_harga)"></span>
          </div>
        </div>
      </template>

      <div class="justify-end flex gap-3 pt-3">
        <button
          @click="cetakUlang(detail.id_transaksi)"
          class="bg-blue-600 text-white btn hover:bg-blue-700 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2v5H5v-5H3V7h18v10M5 12h14M12 17V7" />
          </svg>
          <span>Cetak Ulang Struk</span>
        </button>
        <button @click="modalDetail=false"
          class="bg-gray-200 hover:bg-gray-300 text-gray-700 btn">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= ASSETS_URL ?>/js/riwayatTransaksiPage.js"></script>

<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>