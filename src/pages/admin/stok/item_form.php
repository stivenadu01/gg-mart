<?php
// PHP Logic
$act = $_GET['act'] ?? 'tambah';
$id  = $_GET['id'] ?? null; // Kita akan menggunakan id_item
$pageTitle = ($act === 'edit') ? "Edit Item Stok" : "Tambah Item Stok";

include INCLUDES_PATH . "/admin/layout/header.php";
?>

<div x-data="itemStokFormPage('<?= $act ?>', '<?= $id ?>')" x-init="initPage()"
  class="bg-gray-50 min-h-[100dvh] p-4 lg:p-6 space-y-4">
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 p-6 space-y-6">

    <div class="flex items-center justify-between border-b pb-4 border-gray-200">
      <h1 class="text-2xl font-bold text-gray-800" x-text="formTitle"></h1>
      <a :href="baseUrl + '/admin/stok/item'" class="text-sm text-gray-500 hover:text-emerald-600 font-medium transition">← Kembali</a>
    </div>

    <form @submit.prevent="submitForm" class="space-y-5">

      <div>
        <label>Nama Item <span class="text-red-500">*</span></label>
        <input type="text" x-model="form.nama_item"
          placeholder="Contoh: Beras Premium, Gula Pasir" autofocus required>
      </div>

      <div>
        <label>Satuan Dasar <span class="text-red-500">*</span></label>
        <select x-model="form.satuan_dasar" required>
          <option value="">-- Pilih Satuan --</option>
          <option value="pcs">Pcs (Satuan)</option>
          <option value="kg">KG (Kilogram)</option>
          <option value="liter">Liter</option>
          <option value="dus">Dus</option>
          <option value="pack">Pack</option>
        </select>
        <small class="text-gray-500 mt-1 block">Satuan dasar yang digunakan saat pembelian.</small>
      </div>

      <div x-show="isEdit">
        <label>Stok Saat Ini (Hanya Lihat)</label>
        <input type="number" x-model="form.stok" disabled class="bg-gray-100 cursor-not-allowed">
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
        <a :href="baseUrl + '/admin/stok/item'"
          class="btn px-5 py-2 w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-none">Batal</a>
        <button type="submit"
          class="btn btn-primary px-5 py-2 w-auto"
          x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Item'"></button>
      </div>
    </form>
  </div>
</div>

<script src="<?= ASSETS_URL . '/js/itemStokFormPage.js' ?>"></script>

<?php include INCLUDES_PATH . "/admin/layout/footer.php"; ?>