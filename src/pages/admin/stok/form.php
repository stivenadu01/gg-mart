<?php
$pageTitle = "Tambah Perubahan Stok";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="stokFormPage()" x-init="fetchProduk()" class="p-4 bg-gray-50 min-h-screen">
  <div class="max-w-lg mx-auto bg-white shadow rounded-xl border border-gray-200 p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Perubahan Stok</h1>

    <form @submit.prevent="submitForm" class="space-y-4">
      <!-- PRODUK -->
      <div>
        <label class="font-medium text-gray-700">Pilih Produk</label>
        <select x-model="form.kode_produk" required class="w-full">
          <option value="">-- Pilih Produk --</option>
          <template x-for="p in produk" :key="p.kode_produk">
            <option :value="p.kode_produk" x-text="p.nama_produk"></option>
          </template>
        </select>
      </div>

      <!-- TIPE -->
      <div>
        <label class="font-medium text-gray-700">Jenis Perubahan</label>
        <select x-model="form.tipe" required class="w-full">
          <option value="">-- Pilih --</option>
          <option value="masuk">Stok Masuk</option>
          <option value="keluar">Stok Keluar</option>
        </select>
      </div>

      <!-- JUMLAH -->
      <div>
        <label class="font-medium text-gray-700">Jumlah</label>
        <input type="number" x-model="form.jumlah" min="1" required placeholder="Masukkan jumlah"
          class="w-full">
      </div>

      <!-- KETERANGAN -->
      <div>
        <label class="font-medium text-gray-700">Keterangan (Opsional)</label>
        <textarea x-model="form.keterangan" rows="3" class="w-full"></textarea>
      </div>

      <div class="flex justify-end gap-3">
        <a :href="baseUrl + '/admin/stok'" class="text-gray-600 hover:text-gray-900">Batal</a>
        <button type="submit" class="bg-gg-primary text-white px-5 py-2 rounded-md">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script src="<?= ASSETS_URL . '/js/stokFormPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>