<?php
$act = $_GET['act'] ?? 'tambah';
$id  = $_GET['id'] ?? null;
$pageTitle = ($act === 'edit') ? "Edit Produk" : "Tambah Produk";

include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="produkFormPage('<?= $act ?>', '<?= $id ?>')" x-init="initPage()"
  class="p-1 lg:p-5 bg-gray-50 min-h-screen">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-2 md:p-6 space-y-6">
    <!-- HEADER -->
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-neutral-800" x-text="formTitle"></h1>
      <a :href="baseUrl + '/admin/produk'" class="text-sm text-gray-500 hover:text-gg-primary">← Kembali</a>
    </div>

    <!-- FORM -->
    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-5">
      <!-- NAMA PRODUK -->
      <div>
        <label>Nama Produk <span class="text-red-500">*</span></label>
        <input type="text" x-model="form.nama_produk"
          placeholder="Nama produk" autofocus required>
      </div>

      <!-- KATEGORI -->
      <div>
        <label class="font-medium text-gray-700">Pilih Kategori</label>
        <select x-model="form.id_kategori" required class="w-full">
          <option value="">-- Pilih Kategori --</option>
          <template x-for="k in kategori" :key="k.id_kategori">
            <option :value="k.id_kategori" x-text="k.nama_kategori"></option>
          </template>
        </select>
      </div>



      <!-- HARGA -->
      <div>
        <label>Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" x-model="form.harga"
          placeholder="Contoh: 25000" required>
      </div>

      <!-- DESKRIPSI -->
      <div>
        <label>Deskripsi</label>
        <textarea x-model="form.deskripsi" rows="4"></textarea>
      </div>

      <!-- GAMBAR -->
      <div>
        <label>Gambar Produk</label>
        <input type="file" @change="onFileChange" accept="image/*">
        <template x-if="preview">
          <img :src="preview" alt="Preview Gambar" class="mt-3 w-40 h-40 object-cover rounded-lg shadow">
        </template>
      </div>

      <!-- TOMBOL -->
      <div class="flex justify-end gap-3">
        <a :href="baseUrl + '/admin/produk'"
          class="px-5 text-gray-600 hover:bg-gray-100">Batal</a>
        <button type="submit"
          class="px-5 py-2 bg-gg-primary text-white rounded-lg hover:bg-gg-primary-hover transition"
          x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Produk'"></button>
      </div>
    </form>
  </div>
</div>


<script src="<?= ASSETS_URL . '/js/produkFormPage.js' ?>"></script>

<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>