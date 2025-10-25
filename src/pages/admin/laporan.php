<?php
$pageTitle = "Laporan Penjualan";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="laporanPage()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <div>
    <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Laporan Penjualan</h1>
    <p class="text-sm text-gray-500">Cetak laporan penjualan harian, bulanan, atau tahunan.</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 space-y-5 max-w-lg">
    <h2 class="text-xl font-bold text-gray-800 border-b pb-3 border-gray-200">Pilih Parameter Laporan</h2>

    <div class="flex flex-col md:flex-row gap-4 items-end">
      <div>
        <label class="text-sm font-medium text-gray-700 block mb-1">Jenis Laporan</label>
        <select x-model="tipe" class="w-full">
          <option value="harian">Harian</option>
          <option value="bulanan">Bulanan</option>
          <option value="tahunan">Tahunan</option>
        </select>
      </div>

      <div class="flex-1">
        <label class="text-sm font-medium text-gray-700 block mb-1">Pilih Periode</label>
        <template x-if="tipe === 'harian'">
          <input type="date" x-model="tanggal" class="w-full" />
        </template>

        <template x-if="tipe === 'bulanan'">
          <input type="month" x-model="bulan" class="w-full" />
        </template>

        <template x-if="tipe === 'tahunan'">
          <input type="number" x-model="tahun" min="2020" max="2100" class="w-full" placeholder="Tahun" />
        </template>
      </div>
    </div>

    <button @click="cetakLaporan"
      class="btn px-5 py-2 w-auto bg-red-600 hover:bg-red-700 text-white shadow-md transition" title="Cetak Laporan PDF">
      <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
    </button>
  </div>

  <div class="text-gray-500 text-sm pt-2">
    <p>Laporan akan dibuka di tab baru dan mencakup data transaksi yang telah tersimpan di sistem GG-Mart.</p>
  </div>
</div>

<script>
  function laporanPage() {
    return {
      tipe: 'harian',
      tanggal: new Date().toISOString().slice(0, 10),
      bulan: new Date().toISOString().slice(0, 7),
      tahun: new Date().getFullYear(),
      cetakLaporan() {
        let url = `${baseUrl}/laporan/penjualan_pdf?tipe=${this.tipe}`;
        if (this.tipe === 'harian') url += `&tanggal=${this.tanggal}`;
        if (this.tipe === 'bulanan') url += `&bulan=${this.bulan}`;
        if (this.tipe === 'tahunan') url += `&tahun=${this.tahun}`;
        window.open(url, '_blank');
      }
    }
  }
</script>

<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>