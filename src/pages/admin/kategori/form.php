<?php
$act = $_GET['act'] ?? 'tambah';
$id  = $_GET['id'] ?? null;
$pageTitle = ($act === 'edit') ? "Edit Kategori" : "Tambah Kategori";

include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="kategoriFormPage('<?= $act ?>', '<?= $id ?>')" x-init="initPage()" class="p-1 lg:p-5 bg-gray-50 min-h-screen">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-2 md:p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-neutral-800" x-text="formTitle"></h1>
      <a :href="baseUrl + '/admin/kategori'" class="text-sm text-gray-500 hover:text-gg-primary">← Kembali</a>
    </div>

    <!-- FORM -->
    <form @submit.prevent="submitForm" class="space-y-5">
      <div>
        <label>Nama Kategori</label>
        <input type="text" x-model="form.nama_kategori" placeholder="Nama kategori"
          autofocus required>
      </div>

      <div>
        <label>Deskripsi</label>
        <textarea x-model="form.deskripsi" rows="4" placeholder="Deskripsi (opsional)"></textarea>
      </div>

      <div class="flex justify-end gap-3">
        <a :href="baseUrl + '/admin/kategori'" class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">Batal</a>
        <button type="submit" class="px-5 py-2 bg-gg-primary text-white rounded-lg hover:bg-gg-primary-hover transition" x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Kategori'"></button>
      </div>
    </form>
  </div>
</div>

<script src="<?= ASSETS_URL . 'js/kategoriFormPage.js' ?>"></script>
<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>