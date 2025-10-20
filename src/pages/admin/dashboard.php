<?php
$pageTitle = "Dashboard Admin";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="dashboardAdminPage()" x-init="fetchDashboard()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-6">
  <!-- HEADER -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-neutral-800 tracking-tight">Dashboard Admin</h1>
      <p class="text-sm text-gray-500">Pantau statistik dan aktivitas terbaru di GGMART.</p>
    </div>
    <div class="text-sm text-gray-500">
      <span x-text="formatDate(now)"></span>
    </div>
  </div>

  <!-- STATISTIC CARDS -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
    <!-- TOTAL KATEGORI -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Total Kategori</p>
      <h2 class="text-2xl font-bold text-gg-primary mt-1" x-text="stats.kategori"></h2>
    </div>

    <!-- TOTAL PRODUK -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
      <p class="text-gray-500 text-sm">Total Produk</p>
      <h2 class="text-2xl font-bold text-gg-primary mt-1" x-text="stats.produk"></h2>
    </div>

    <!-- TRANSAKSI HARI INI -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition relative">
      <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
      <div class="flex flex-col md:flex-row items-end justify-between">
        <h2 class="text-2xl font-bold text-blue-600 mt-1" x-text="stats.transaksiHariIni"></h2>
        <span :class="badgeClass(stats.kenaikanTransaksi)"
          class="text-xs px-2 py-1 rounded-full font-medium"
          x-text="formatBadge(stats.kenaikanTransaksi)"></span>
      </div>
    </div>

    <!-- PENDAPATAN HARI INI -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition relative">
      <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
      <div class="flex flex-col md:flex-row items-end justify-between">
        <h2 class="text-2xl font-bold text-green-600 mt-1" x-text="formatRupiah(stats.pendapatanHariIni)"></h2>
        <span :class="badgeClass(stats.kenaikanPendapatan)"
          class="text-xs px-2 py-1 rounded-full font-medium"
          x-text="formatBadge(stats.kenaikanPendapatan)"></span>
      </div>
    </div>

    <!-- PRODUK TERJUAL HARI INI -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition relative">
      <p class="text-gray-500 text-sm">Produk Terjual Hari Ini</p>
      <div class="flex flex-col md:flex-row items-end justify-between">
        <h2 class="text-2xl font-bold text-orange-600 mt-1" x-text="stats.produkTerjualHariIni"></h2>
        <span :class="badgeClass(stats.kenaikanProdukTerjual)"
          class="text-xs px-2 py-1 rounded-full font-medium"
          x-text="formatBadge(stats.kenaikanProdukTerjual)"></span>
      </div>
    </div>
  </div>

  <!-- CHART + RIGHT COLUMN -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- CHART -->
    <div class="lg:col-span-2 bg-white p-5 rounded-xl shadow">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-neutral-800">Grafik Penjualan 7 Hari Terakhir</h3>
      </div>

      <div x-show="loading" class="py-8 flex items-center justify-center">
        <?php include INCLUDES_PATH . '/loading.php' ?>
      </div>

      <div class="min-h-96">
        <canvas x-show="!loading" id="chartPenjualan"></canvas>
      </div>
    </div>

    <!-- RIGHT: TRANSAKSI TERBARU + PRODUK HABIS -->
    <div class="space-y-6">
      <div class="bg-white p-4 rounded-xl shadow">
        <h4 class="font-semibold mb-3">Transaksi Terbaru</h4>
        <template x-if="loading">
          <div class="py-6 flex items-center justify-center">
            <?php include INCLUDES_PATH . '/loading.php' ?>
          </div>
        </template>

        <template x-if="!loading && stats.transaksiTerbaru.length === 0">
          <p class="text-sm text-gray-500">Belum ada transaksi terbaru</p>
        </template>

        <ul class="divide-y divide-gray-200 max-h-[300px] overflow-y-auto" x-show="!loading && stats.transaksiTerbaru">
          <template x-for="t in stats.transaksiTerbaru" :key="t.id_transaksi">
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

      <!-- PRODUK HABIS -->
      <div class="bg-white p-4 rounded-xl shadow">
        <h4 class="font-semibold mb-3 text-red-600">Produk Hampir Habis</h4>
        <template x-if="stats.produkHampirHabis.length === 0">
          <p class="text-sm text-gray-500">Semua stok aman 🎉</p>
        </template>

        <ul class="divide-y divide-gray-200 max-h-48 overflow-y-auto" x-show="stats.produkHampirHabis.length">
          <template x-for="p in stats.produkHampirHabis" :key="p.kode_produk">
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