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
        <label>Kategori</label>
        <div class="relative">
          <input type="text"
            x-model="kategoriKeyword"
            @focus="kategoriOpen = true"
            @blur="setTimeout(() => kategoriOpen = false, 200)"
            @input="filterKategori"
            placeholder="Ketik untuk mencari kategori..."
            autocomplete="off">

          <div x-show="kategoriOpen && kategoriFiltered.length > 0"
            class="absolute z-20 mt-1 w-full bg-white border-gg-primary/50 border-2 rounded-lg shadow-lg max-h-48 overflow-y-auto">
            <template x-for="k in kategoriFiltered" :key="k.id_kategori">
              <div
                @click="selectKategori(k)"
                class="px-3 py-2 hover:bg-gg-primary/50 cursor-pointer"
                x-text="k.nama_kategori">
              </div>
            </template>
          </div>
        </div>
      </div>



      <!-- HARGA -->
      <div>
        <label>Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" x-model="form.harga"
          placeholder="Contoh: 25000" required>
      </div>

      <!-- STOK -->
      <div>
        <template x-if="!isEdit">
          <div>
            <label>Stok Awal</label>
            <input type="number" x-model="form.stok" placeholder="0">
          </div>
        </template>

        <template x-if="isEdit">
          <div class="space-y-3">
            <div>
              <label>Stok Saat Ini</label>
              <input type="number" x-model="form.stok" readonly
                class="cursor-not-allowed bg-gray-200">
            </div>

            <div class="flex flex-col md:flex-row gap-3">
              <div class="flex-1">
                <label>Tambah Stok</label>
                <input type="number" x-model.number="stokTambah"

                  placeholder="0">
              </div>
              <div class="flex-1">
                <label>Kurangi Stok</label>
                <input type="number" x-model.number="stokKurang" placeholder="0">
              </div>
            </div>
          </div>
        </template>
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