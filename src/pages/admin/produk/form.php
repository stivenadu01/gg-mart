<?php
models('produk');

$act = $_GET['act'] ?? 'tambah';
$kode = $_GET['k'] ?? null;

$pageTitle = ($act === 'edit') ? "Edit Produk" : "Tambah Produk";
include COMPONENTS_PATH . '/admin/header.php';

// Ambil data produk jika edit
$produk = null;
if ($act === 'edit' && $kode) {
  $produk = getProdukByKode($kode);
  if (!$produk) {
    echo "<p class='text-red-500 p-4'>Produk tidak ditemukan.</p>";
    include COMPONENTS_PATH . 'admin/footer.php';
    exit;
  }
}

// Tentukan gambar default
$gambarUrl = !empty($produk['gambar']) ? url("uploads/{$produk['gambar']}") : url('assets/img/no-image.webp');
?>

<form action="<?= url('admin/produk/aksi') ?>" method="POST" enctype="multipart/form-data" class="space-y-5" id="form-produk">
  <div>
    <div class="bg-white shadow-xl rounded-xl p-8 mx-auto border border-green-100">
      <h1 class="text-3xl font-bold mb-6 text-green-700"><?= $pageTitle ?></h1>
      <?php if ($act === 'edit'): ?>
        <p class="text-gray-600 mb-5">Mengedit produk dengan kode: <strong class="text-green-600"><?= $produk['kode_produk'] ?></strong></p>
      <?php endif; ?>
      <div class="flex flex-col md:flex-row gap-8 mb-3">
        <!-- Kiri: Preview Gambar -->
        <div class="md:w-1/3 flex flex-col items-center justify-start">
          <div>
            <label class="block font-semibold mb-1 text-green-700">Gambar Produk</label>
            <img id="preview-gambar" src="<?= $gambarUrl ?>" class="w-64 h-64 object-cover rounded-lg shadow border border-green-200 mb-4" alt="Preview Gambar">
            <!-- Upload Gambar -->
            <input type="file" name="gambar" id="input-gambar" accept="image/*" class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition">
          </div>
        </div>

        <!-- Kanan: Form -->
        <div class="md:w-2/3 md:px-2">
          <!-- Hidden fields -->
          <input type="hidden" name="act" value="<?= $act ?>">
          <input type="hidden" name="kode_produk" value="<?= $produk['kode_produk'] ?? '' ?>">
          <input type="hidden" name="gambar_lama" value="<?= $produk['gambar'] ?? '' ?>">

          <!-- Nama Produk -->
          <div>
            <label class="block font-semibold mb-1 text-green-700">Nama Produk</label>
            <input type="text" name="nama_produk" required
              value="<?= htmlspecialchars($produk['nama_produk'] ?? '') ?>"
              class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition">
          </div>

          <!-- Harga -->
          <div>
            <label class="block font-semibold mb-1 text-green-700">Harga</label>
            <input type="number" name="harga" required
              value="<?= $produk['harga'] ?? '' ?>"
              class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition">
          </div>

          <!-- Stok -->
          <div>
            <label class="block font-semibold mb-1 text-green-700">Stok</label>
            <input type="number" name="stok" required
              value="<?= $produk['stok'] ?? '' ?>"
              class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition">
          </div>

          <!-- Izin Edar -->
          <div>
            <label class="block font-semibold mb-1 text-green-700">Izin Edar</label>
            <select name="izin_edar" class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition">
              <option value="1" <?= (isset($produk['izin_edar']) && $produk['izin_edar']) ? 'selected' : '' ?>>Ya</option>
              <option value="0" <?= (isset($produk['izin_edar']) && !$produk['izin_edar']) ? 'selected' : '' ?>>Tidak</option>
            </select>
          </div>
        </div>
      </div>
      <!-- Deskripsi -->
      <div>
        <label class="block font-semibold mb-1 text-green-700">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="border border-green-200 w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 transition"><?= htmlspecialchars($produk['deskripsi'] ?? '') ?></textarea>
      </div>
      <!-- Tombol Aksi -->
      <div class="flex justify-between mt-8">
        <a href="<?= url('admin/produk') ?>" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg transition shadow">Kembali</a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow">
          <?= ($act === 'edit') ? 'Simpan Perubahan' : 'Tambah Produk' ?>
        </button>
      </div>
    </div>
  </div>
</form>

<script>
  document.getElementById('input-gambar').addEventListener('change', function(e) {
    const [file] = e.target.files;
    if (file) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        document.getElementById('preview-gambar').src = ev.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

<?php include COMPONENTS_PATH . '/admin/footer.php'; ?>