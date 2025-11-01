<?php
$pageTitle = "Riwayat Transaksi";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="riwayatTransaksiPage()" x-init="fetchTransaksi()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Riwayat Transaksi</h1>
      <p class="text-sm text-gray-500">Pantau dan kelola seluruh riwayat transaksi GG-Mart dari sini.</p>
    </div>

    <div class="flex items-center gap-3">
      <button @click="filter.show = !filter.show"
        class="md:hidden btn btn-gray w-auto flex items-center gap-1 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
          viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
        Filter
      </button>
    </div>
  </div>

  <div :class="filter.show ? 'block' : 'hidden md:block'" x-transition:enter
    class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">

    <div class="flex flex-col md:flex-row gap-2 justify-between">

      <div class="w-full">
        <form @submit.prevent="applyFilter()">
          <label for="search-input">Cari Kode Transaksi</label>
          <input id="search-input" type="text" x-model="filter.search" placeholder="TRX_12345678">
          <button class="sr-only">Submit</button>
        </form>
      </div>

      <div class="w-1/2 md:w-full flex gap-3">
        <div class="w-full">
          <label for="start-date">Tanggal Mulai</label>
          <input id="start-date" type="date" x-model="filter.start" @change="applyFilter()">
        </div>
        <div class="w-full">
          <label for="end-date">Tanggal Selesai</label>
          <input id="end-date" type="date" x-model="filter.end" @change="applyFilter()">
        </div>
      </div>

      <div class="w-full">
        <label for="metode_bayar">Metode Bayar</label>
        <select id="metode_bayar" x-model="filter.metode" @change="applyFilter()">
          <option value="">Semua</option>
          <option value="tunai">Tunai</option>
          <option value="qris">QRIS</option>
        </select>
      </div>

      <div class="w-full flex gap-3 items-end pt-2 lg:pt-0 border-t lg:border-none border-gray-300">
        <button type="button"
          @click="resetFilter"
          :disabled="!filter.search && !filter.start  && !filter.end && !filter.metode"
          class="btn btn-gray gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 12a9 9 0 11-9-9v3m0-3l-3 3m3-3l3 3" />
          </svg>
          <span>Reset</span>
        </button>
      </div>
    </div>
  </div>

  <?php include INCLUDES_PATH . "/loading.php" ?>

  <?php include INCLUDES_PATH . "/admin/table_riwayat_transaksi.php" ?>


  <template x-if="!loading && transaksi.length === 0">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-dashed border-gray-300">
      <h3 class="text-xl font-semibold text-gray-500">
        <span x-show="filter.search || filter.start || filter.end || filter.metode">Data transaksi tidak ditemukan.</span>
        <span x-show="!filter.search && !filter.start && !filter.end && !filter.metode">Belum ada riwayat transaksi.</span>
      </h3>
    </div>
  </template>


  <template x-if="modalDetail">
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-30 p-4 -top-10 animate-fade" @click.self="modalDetail=false">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl p-6 space-y-5 animate-fade">
        <div class="flex justify-between items-center border-b pb-3 border-gray-200">
          <h2 class="text-xl font-extrabold text-gray-800">Detail Transaksi</h2>
        </div>

        <template x-if="detail && !loadingDetail">
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
            <div class="overflow-x-auto custom-scrollbar">
              <table class="app-table">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="">Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Pokok</th>
                    <th class="text-right">Jual</th>
                    <th class="text-right">Subtotal Pokok</th>
                    <th class="text-right">Subtotal Jual</th>
                    <th class="text-right">Subtotal Laba</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="d in detail.detail" :key="d.kode_produk">
                    <tr class="border-b border-gray-100 last:border-b-0">
                      <td x-text="d.nama_produk"></td>
                      <td class="text-center" x-text="d.jumlah"></td>
                      <td class="text-right" x-text="formatRupiah(d.harga_pokok)"></td>
                      <td class="text-right font-bold" x-text="formatRupiah(d.harga_satuan)"></td>
                      <td class="text-right" x-text="formatRupiah(d.subtotal_pokok)"></td>
                      <td class="text-right font-bold" x-text="formatRupiah(d.subtotal)"></td>
                      <td class="text-right text-green-600 font-bold" x-text="formatRupiah(parseFloat(d.subtotal) - parseFloat(d.subtotal_pokok))"></td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>

            <div class="font-semibold text-sm">
              <div class="flex justify-between pt-3 border-b border-gray-200">
                <span>Total Pokok/Beli:</span>
                <span x-text="formatRupiah(detail.total_pokok)"></span>
              </div>
              <div class="flex justify-between pt-3 border-b border-gray-200">
                <span>Total Harga/Jual: </span>
                <span x-text="formatRupiah(detail.total_harga)"></span>
              </div>
              <div class="flex justify-between pt-3 border-b border-gray-200">
                <span>Total Laba: </span>
                <span x-text="formatRupiah(detail.total_harga - detail.total_pokok)"></span>
              </div>
            </div>
          </div>
        </template>

        <template x-if="loadingDetail">
          <div>
            <span>
              <svg class="animate-spin h-8 w-8 text-gg-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
            </span>
            Memuat...
          </div>
        </template>

        <div class="justify-end flex gap-3 pt-3">
          <button
            @click="cetakUlang(detail.kode_transaksi)"
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
  </template>
</div>

<script src="<?= ASSETS_URL ?>/js/riwayatTransaksiPage.js"></script>

<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>