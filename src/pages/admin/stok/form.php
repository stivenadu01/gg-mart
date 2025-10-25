<?php
$pageTitle = "Tambah Stok";
include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="stokFormPage()" x-init="fetchItems()" class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6">
  <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl border border-gray-200 p-6 space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-4">
      <h1 class="text-2xl font-bold text-gray-800">Tambah Perubahan Stok</h1>
      <a :href="baseUrl + '/admin/stok'"
        class="text-sm text-gray-500 hover:text-gg-primary transition font-medium">← Kembali</a>
    </div>

    <!-- Form -->
    <form @submit.prevent="submitForm" class="space-y-6">

      <!-- STEP 1: Jenis Perubahan -->
      <template x-if="page === 1">
        <div class="space-y-3 animate-fade">
          <h2 class="text-lg font-semibold text-gray-700">1️⃣ Jenis Perubahan</h2>
          <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
            <label class="flex items-center justify-center w-full border-2 rounded-lg py-3 cursor-pointer transition-all"
              :class="form.type === 'masuk' ? 'border-green-500 bg-green-50 text-green-700 font-semibold' : 'border-gray-300 hover:bg-gray-50'">
              <input type="radio" value="masuk" x-model="form.type" class="sr-only"> Stok Masuk
            </label>

            <label class="flex items-center justify-center w-full border-2 rounded-lg py-3 cursor-pointer transition-all"
              :class="form.type === 'keluar' ? 'border-red-500 bg-red-50 text-red-700 font-semibold' : 'border-gray-300 hover:bg-gray-50'">
              <input type="radio" value="keluar" x-model="form.type" class="sr-only"> Stok Keluar
            </label>
          </div>

          <div class="flex justify-end">
            <button type="button" @click="nextPage()"
              class="btn btn-primary px-5 py-2 mt-3 w-auto">Berikutnya</button>
          </div>
        </div>
      </template>

      <!-- STEP 2: Pilih Item -->
      <template x-if="page === 2">
        <div class="space-y-3 animate-fade">
          <h2 class="text-lg font-semibold text-gray-700">2️⃣ Pilih Stok Item</h2>
          <select x-model="form.id_item" @change="updateSatuan(); fetchMutasi()" required
            class="w-full border-gray-300 rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
            <option value="">-- Pilih Item --</option>
            <template x-for="i in items" :key="i.id_item">
              <option :value="i.id_item" x-text="i.nama_item"></option>
            </template>
          </select>
          <p class="text-xs text-gray-500">Pilih item yang ingin diubah stoknya.</p>

          <div class="flex justify-between pt-4 border-t border-gray-200">
            <button type="button" @click="page = 1" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200 px-4">Kembali</button>
            <button type="button" @click="nextPage()" class="btn btn-primary px-4">Berikutnya</button>
          </div>
        </div>
      </template>

      <!-- STEP 3: Detail -->
      <template x-if="page === 3">
        <div class="space-y-4 animate-fade">
          <h2 class="text-lg font-semibold text-gray-700">3️⃣ Detail Perubahan <span x-text="nama_item"></span></h2>

          <!-- Jumlah -->
          <div>
            <label class=" block mb-1 font-medium">Jumlah (<span x-text="satuan_dasar"></span>)</label>
            <input type="number" x-model="form.jumlah" min="1" required
              class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
            <p class="text-xs text-gray-500">Jumlah stok dalam <span x-text="satuan_dasar"></span>.</p>
          </div>

          <!-- Jika Masuk -->
          <template x-if="form.type === 'masuk'">
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block mb-1 font-medium">Harga Pokok</label>
                <input step="0.00000000000001" type="number" x-model="form.harga_pokok" @input="syncHargaPokok('harga')"
                  class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
                <span class="text-xs text-gray-400">Harga beli satuan</span>
              </div>
              <div>
                <label class="block mb-1 font-medium">Total Pokok</label>
                <input step="0.000000000000001" type="number" x-model="form.total_pokok" @input="syncHargaPokok('total')"
                  class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
                <span class="text-xs text-gray-400">Total harga pembelian (harga pokok x jumlah)</span>
              </div>
            </div>
          </template>

          <!-- Jika Keluar -->
          <template x-if="form.type === 'keluar'">
            <div>
              <label class="block mb-1 font-medium">Pilih Mutasi/Batch</label>
              <select x-model="form.id_mutasi" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-gg-primary focus:border-gg-primary">
                <option value="">-- Pilih Mutasi/Batch --</option>
                <template x-for="m in mutasiList" :key="m.id_mutasi">
                  <option :value="m.id_mutasi"
                    x-text="`${formatDate(m.tanggal)} | Sisa ${m.sisa_stok}${satuan_dasar}`"></option>
                </template>
              </select>
              <span class="text-xs text-gray-400">Pilih mutasi/batch yang ingin dikurangi stoknya</span>
            </div>
          </template>

          <!-- Keterangan -->
          <div>
            <label class="block mb-1 font-medium">Keterangan (Opsional)</label>
            <textarea x-model="form.keterangan" rows="3"
              class="w-full border-gray-300 rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5"></textarea>
          </div>

          <!-- Tombol -->
          <div class="flex justify-between pt-4 border-t border-gray-200">
            <button type="button" @click="page = 2" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200 px-4">Kembali</button>
            <button type="submit" class="btn btn-primary px-4">Simpan</button>
          </div>
        </div>
      </template>
    </form>
  </div>
</div>

<script src="<?= ASSETS_URL . '/js/stokFormPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>