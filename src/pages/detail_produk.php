<?php
models('produk');

// Ambil kode produk dari URL
$t = $_GET['t'] ?? null;

try {
  $produk = getProdukByKode($t);
  if (!$produk) {
    throw new Exception("Produk tidak ditemukan.");
  }
} catch (Exception $e) {
  set_flash("Produk Tidak Ditemukan");
  redirect('produk');
}

include COMPONENTS_PATH . "/user/header.php";
?>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-5 pb-24 lg:pb-0">
  <!-- Kolom kiri: Gambar -->
  <div class="lg:col-span-2">
    <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
      <img src="<?= UPLOADS_PATH . ($produk['gambar']) ?>"
        alt="<?= htmlspecialchars($produk['nama_produk']) ?>"
        class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
    </div>
  </div>

  <!-- Kolom tengah: Detail -->
  <div class="lg:col-span-2">
    <h1 class="text-2xl font-semibold mb-2 text-gray-800"><?= htmlspecialchars($produk['nama_produk']) ?></h1>

    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
      <span>Terjual <?= (int)$produk['terjual'] ?></span>
      <span>•</span>
      <span>Stok <?= (int)$produk['stok'] ?></span>
    </div>

    <!-- Harga -->
    <div class="mb-4">
      <p class="text-3xl font-bold text-green-600">
        Rp<?= number_format($produk['harga'], 0, ',', '.') ?>
      </p>
    </div>

    <!-- Deskripsi -->
    <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi Produk</h2>
      <p class="text-gray-700 leading-relaxed whitespace-pre-line">
        <?= nl2br(htmlspecialchars($produk['deskripsi'])) ?>
      </p>
    </div>
  </div>

  <!-- Kolom kanan: Aksi (desktop) -->
  <div class="hidden lg:block"
    x-data="{ 
      jumlah: 1, 
      stok: <?= (int)$produk['stok'] ?>, 
      harga: <?= (int)$produk['harga'] ?>,
      formatRupiah(n) {
        return 'Rp' + n.toLocaleString('id-ID');
      }
    }">

    <div class="sticky top-24 bg-white rounded-xl shadow-sm p-6 border">
      <h2 class="text-lg font-semibold mb-4 text-gray-800">Atur Jumlah</h2>

      <form method="POST" action="<?= url('keranjang/aksi?act=tambah') ?>" class="space-y-4">
        <input type="hidden" name="kode_produk" value="<?= htmlspecialchars($produk['kode_produk']) ?>">
        <input type="hidden" name="jumlah" x-model="jumlah">

        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center border rounded-lg">
            <button type="button" @click="if(jumlah>1) jumlah--" class="px-3 py-1 text-xl">−</button>
            <input type="number" x-model="jumlah" min="1" :max="stok"
              class="w-12 text-center border-x outline-none">
            <button type="button" @click="if(jumlah<stok) jumlah++" class="px-3 py-1 text-xl">+</button>
          </div>
          <p class="text-xs text-gray-600">Stok Total: <b x-text="stok"></b></p>
        </div>

        <p class="text-gray-500 line-through text-sm" x-text="formatRupiah(harga * 1.1 * jumlah)"></p>
        <p class="text-2xl font-bold text-green-600 mb-4" x-text="formatRupiah(harga * jumlah)"></p>

        <button type="submit"
          class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold w-full">
          + Keranjang
        </button>
      </form>

      <form method="POST" action="<?= url('pesanan') ?>" class="mt-3">
        <input type="hidden" name="kode_produk" value="<?= htmlspecialchars($produk['kode_produk']) ?>">
        <input type="hidden" name="jumlah" x-model="jumlah">
        <button type="submit"
          class="border border-green-600 hover:bg-green-50 text-green-700 px-6 py-3 rounded-lg font-semibold w-full">
          Beli Langsung
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Tombol aksi mobile -->
<div class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-3 gap-2 z-50"
  x-data="{ jumlah: 1, harga: <?= (int)$produk['harga'] ?>, formatRupiah(n){return 'Rp'+n.toLocaleString('id-ID')} }">
  <div class="flex items-center justify-between mb-2">
    <div class="flex items-center gap-2">
      <button type="button" @click="if(jumlah>1) jumlah--" class="bg-gray-200 px-3 py-1 rounded">−</button>
      <span x-text="jumlah" class="font-semibold text-lg"></span>
      <button type="button" @click="jumlah++" class="bg-gray-200 px-3 py-1 rounded">+</button>
    </div>

    <div class="flex flex-col w-full text-right">
      <p class="text-sm text-gray-600">Total:</p>
      <p class="text-lg font-bold text-green-600" x-text="formatRupiah(harga * jumlah)"></p>
    </div>
  </div>

  <div class="flex justify-between items-center gap-2">
    <form method="POST" action="<?= url('keranjang/aksi?act=tambah') ?>" class="w-1/2">
      <input type="hidden" name="kode_produk" value="<?= htmlspecialchars($produk['kode_produk']) ?>">
      <input type="hidden" name="jumlah" x-model="jumlah">
      <button type="submit"
        class="bg-green-600 text-white w-full py-2 rounded-lg font-semibold hover:bg-green-700">
        + Keranjang
      </button>
    </form>
    <form method="POST" action="<?= url('pesanan') ?>" class="w-1/2">
      <input type="hidden" name="kode_produk" value="<?= htmlspecialchars($produk['kode_produk']) ?>">
      <input type="hidden" name="jumlah" x-model="jumlah">
      <button type="submit"
        class="bg-white text-green-600 w-full py-2 rounded-lg font-semibold hover:bg-gray-200 border-green-600 border">
        Beli lansung
      </button>
    </form>
  </div>
</div>

<?php include COMPONENTS_PATH . "/user/footer.php"; ?>