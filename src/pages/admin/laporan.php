<?php
$pageTitle = "Laporan Penjualan";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="laporanPage()" class="bg-gray-50 p-3 md:p-6 space-y-6">
  <div>
    <h1 class="text-2xl font-bold text-neutral-800">Laporan Penjualan</h1>
    <p class="text-sm text-gray-500">Cetak laporan penjualan harian, bulanan, atau tahunan.</p>
  </div>

  <!-- PILIH JENIS LAPORAN -->
  <div class="bg-white p-3 md:p-5 rounded-xl shadow space-y-4">
    <h2 class="text-lg font-semibold text-gray-800">Pilih Jenis Laporan</h2>

    <div class="flex flex-col md:flex-row gap-4 items-center">
      <select x-model="tipe" class="border-gray-300 rounded-md px-3 py-2">
        <option value="harian">Harian</option>
        <option value="bulanan">Bulanan</option>
        <option value="tahunan">Tahunan</option>
      </select>

      <!-- Input sesuai tipe -->
      <template x-if="tipe === 'harian'">
        <input type="date" x-model="tanggal" class="border-gray-300 rounded-md px-3 py-2" />
      </template>

      <template x-if="tipe === 'bulanan'">
        <input type="month" x-model="bulan" class="border-gray-300 rounded-md px-3 py-2" />
      </template>

      <template x-if="tipe === 'tahunan'">
        <input type="number" x-model="tahun" min="2025" class="border-gray-300 rounded-md px-3 py-2 w-32" />
      </template>
    </div>

    <button @click="cetakLaporan"
      class="bg-red-500 hover:opacity-80 text-white px-5 py-2 rounded-lg shadow transition" title="Cetak Laporan PDF">
      Cetak PDF
    </button>
  </div>

  <div class="text-gray-500 text-sm">
    <p>Laporan mencakup data transaksi yang telah tersimpan di sistem GG-Mart.</p>
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