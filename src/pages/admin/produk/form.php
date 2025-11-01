<?php
$act = $_GET['act'] ?? 'tambah';
$id  = $_GET['id'] ?? null;
$pageTitle = ($act === 'edit') ? "Edit Produk" : "Tambah Produk";

include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="produkFormPage('<?= $act ?>', '<?= $id ?>')" x-init="initPage()"
  class="bg-gray-50 p-4 lg:p-6">

  <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl border border-gray-200 p-6 space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-4">
      <h1 class="text-2xl font-bold text-gray-800" x-text="formTitle"></h1>
      <a :href="baseUrl + '/admin/produk'" class="text-sm text-gray-500 hover:text-gg-primary transition font-medium">← Kembali</a>
    </div>

    <!-- Form -->
    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-6">

      <!-- STEP 1: Data Produk -->
      <template x-if="page === 1">
        <div class="space-y-4 animate-fade">
          <h2 class="text-lg font-semibold text-gray-700">1️⃣ Data Produk</h2>

          <div>
            <label class="block mb-1 font-medium">Kategori</label>
            <select x-model="form.id_kategori" required
              class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
              <option value="">-- Pilih Kategori --</option>
              <template x-for="k in kategori" :key="k.id_kategori">
                <option :value="k.id_kategori" x-text="k.nama_kategori"></option>
              </template>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium">Nama Produk</label>
            <input type="text" x-model="form.nama_produk" placeholder="Nama produk" required
              class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
          </div>

          <div>
            <label class="block mb-1 font-medium">Harga Jual (Rp)</label>
            <input type="number" x-model="form.harga_jual" placeholder="Contoh: 25000" required min="0"
              class="w-full rounded-lg focus:ring-gg-primary focus:border-gg-primary p-2.5">
          </div>

          <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="button" @click="page++" class="btn btn-primary px-5 py-2 w-auto">Berikutnya</button>
          </div>
        </div>
      </template>

      <!-- STEP 2: Detail Produk -->
      <template x-if="page === 2">
        <div class="space-y-4 animate-fade">
          <h2 class="text-lg font-semibold text-gray-700">2️⃣ Detail Produk</h2>
          <div>
            <label for="satuan_dasar">Satuan Dasar</label>
            <input type="text" x-model="form.satuan_dasar" id="satuan_dasar" class="" placeholder="Contoh: Pcs, Kg, Botol, Buah dll ">
          </div>

          <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea x-model="form.deskripsi" rows="4"
              class="w-full rounded-lg border-gray-300 focus:ring-gg-primary focus:border-gg-primary p-2.5"
              placeholder="Tuliskan deskripsi produk (opsional)"></textarea>
          </div>

          <div>
            <label class="block mb-1 font-medium">Gambar Produk</label>
            <input type="file" @change="onFileChange" accept="image/*"
              class="w-full border-gray-300 rounded-lg p-2.5">
            <template x-if="preview">
              <img :src="preview" alt="Preview Gambar" class="mt-3 w-40 h-40 object-cover rounded-lg shadow">
            </template>
            <span class="text-red-500/90 text-xs">* Pastikan gambar telah dikompres agar menghemat penyimpanan</span>
          </div>

          <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 w-auto">
            <button type="button" @click="page = 1" class="btn btn-gray">Kembali</button>
            <?php include INCLUDES_PATH . 'btn_submit.php' ?>
          </div>
        </div>
      </template>
    </form>
  </div>
</div>

<script src="<?= ASSETS_URL . '/js/produkFormPage.js' ?>"></script>
<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>