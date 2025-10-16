<?php
$pageTitle = "Dashboard Admin";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="dashboardAdminPage()" x-init="fetchDashboard()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-6">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800 tracking-tight">Dashboard Admin</h1>
      <p class="text-sm text-gray-500">Pantau statistik dan aktivitas terbaru di GG-Mart.</p>
    </div>
    <div class="text-sm text-gray-500">
      <span x-text="formatDate(now)"></span>
    </div>
  </div>

  <!-- STATISTIC CARDS (responsive) -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Total Kategori</p>
      <h2 class="text-2xl font-bold text-gg-primary mt-1" x-text="stats.kategori"></h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Total Produk</p>
      <h2 class="text-2xl font-bold text-gg-primary mt-1" x-text="stats.produk"></h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
      <h2 class="text-2xl font-bold text-gg-primary mt-1" x-text="stats.transaksi_hari_ini"></h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
      <h2 class="text-2xl font-bold text-green-600 mt-1" x-text="formatRupiah(stats.pendapatan_hari_ini)"></h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Produk Terjual Hari Ini</p>
      <h2 class="text-2xl font-bold text-blue-600 mt-1" x-text="stats.produk_terjual_hari_ini"></h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition flex flex-col justify-between">
      <div>
        <p class="text-gray-500 text-sm">Kenaikan Penjualan</p>
        <h2 class="text-2xl font-bold mt-1" :class="stats.persentase_kenaikan >= 0 ? 'text-green-600' : 'text-red-600'"
          x-text="(stats.persentase_kenaikan >= 0 ? '+' : '') + stats.persentase_kenaikan + '%'"></h2>
      </div>
      <div class="text-xs text-gray-400 mt-2">vs kemarin</div>
    </div>
  </div>

  <!-- CHART + RECENT + LOW-STOCK -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- CHART -->
    <div class="lg:col-span-2 bg-white p-5 rounded-xl shadow">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-neutral-800">Grafik Penjualan 7 Hari Terakhir</h3>
      </div>

      <div x-show="loading" class="py-8 flex items-center justify-center">
        <?php include INCLUDES_PATH . '/loading.php' ?>
      </div>

      <canvas x-show="!loading" id="chartPenjualan" height="120"></canvas>
    </div>

    <!-- RIGHT COLUMN: Recent + Low Stock -->
    <div class="space-y-6">
      <!-- TRANSAKSI TERBARU -->
      <div class="bg-white p-4 rounded-xl shadow">
        <h4 class="font-semibold mb-3">Transaksi Terbaru</h4>
        <template x-if="loading">
          <div class="py-6 flex items-center justify-center">
            <?php include INCLUDES_PATH . '/loading.php' ?>
          </div>
        </template>

        <template x-if="!loading && transaksi.length === 0">
          <p class="text-sm text-gray-500">Belum ada transaksi terbaru</p>
        </template>

        <ul class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto" x-show="!loading && transaksi.length">
          <template x-for="t in transaksi" :key="t.kode_transaksi">
            <li class="py-2">
              <div class="flex justify-between items-start">
                <div>
                  <p class="text-sm font-semibold" x-text="t.kode_transaksi"></p>
                  <p class="text-xs text-gray-500" x-text="formatDateTime(t.tanggal_transaksi)"></p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold text-green-600" x-text="formatRupiah(t.total_harga)"></p>
                  <p class="text-xs text-gray-400" x-text="t.metode_bayar"></p>
                </div>
              </div>
            </li>
          </template>
        </ul>
      </div>

      <!-- PRODUK HAMPIR HABIS -->
      <div class="bg-white p-4 rounded-xl shadow">
        <h4 class="font-semibold mb-3 text-red-600">Produk Hampir Habis</h4>
        <template x-if="stats.produk_hampir_habis.length === 0">
          <p class="text-sm text-gray-500">Semua stok aman 🎉</p>
        </template>

        <ul class="divide-y divide-gray-200 max-h-48 overflow-y-auto" x-show="stats.produk_hampir_habis.length">
          <template x-for="p in stats.produk_hampir_habis" :key="p.kode_produk">
            <li class="py-2 flex justify-between items-center">
              <div class="text-sm" x-text="p.nama_produk"></div>
              <div class="text-sm font-semibold text-red-500" x-text="'Stok: ' + p.stok"></div>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= ASSETS_URL ?>/js/dashboardAdminPage.js"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>