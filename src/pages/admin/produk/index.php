<?php
models('produk');

// Ambil data produk (dengan pencarian)
$searchQuery = $_GET['q'] ?? null;
if ($searchQuery) {
  $produkList = searchProduk($searchQuery);
} else {
  $produkList = getAllProduk();
}
$pageTitle = "Kelola Produk - Admin";
include COMPONENTS_PATH . '/admin/header.php';
?>

<div class="p-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-800">Kelola Produk</h1>
        <p class="text-sm text-gray-500">Kelola daftar produk toko Anda dari sini.</p>
      </div>

      <div class="flex items-center gap-3">
        <form method="GET" class="flex items-center">
          <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Cari produk..." class="border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-r">Cari</button>
        </form>
        <a href="<?= url('admin/produk/form?act=tambah') ?>" class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded shadow font-semibold">+ <span class="hidden md:inline-block">Tambah Produk</span></a>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <?php if (empty($produkList)): ?>
        <div class="p-12 text-center">
          <img src="<?= url('assets/img/no-image.webp') ?>" alt="Tidak ada produk" class="mx-auto w-28 h-28 opacity-60 mb-4">
          <h3 class="text-lg font-semibold">Belum ada produk</h3>
          <p class="text-sm text-gray-500 mb-4">Tambahkan produk baru untuk mulai berjualan.</p>
          <a href="<?= url('admin/produk/form?act=tambah') ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">Tambah Produk</a>
        </div>
      <?php else: ?>
        <!-- Tabel untuk desktop -->
        <div class="overflow-x-auto hidden md:block">
          <div class="relative">
            <div class="overflow-y-auto max-h-[500px]">
              <table class="min-w-full bg-white">
                <thead class="bg-blue-50 text-gray-700 sticky top-0 z-10">
                  <tr>
                    <th class="p-3 text-left text-sm font-medium min-w-64 bg-blue-50">Produk</th>
                    <th class="p-3 text-left text-sm font-medium bg-blue-50">Harga</th>
                    <th class="p-3 text-center text-sm font-medium bg-blue-50">Stok</th>
                    <th class="p-3 text-center text-sm font-medium bg-blue-50">Tejual</th>
                    <th class="p-3 text-left text-sm font-medium hidden md:table-cell bg-blue-50">Deskripsi</th>
                    <th class="p-3 text-center text-sm font-medium bg-blue-50">Izin Edar</th>
                    <th class="p-3 text-center text-sm font-medium bg-blue-50">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <?php foreach ($produkList as $p): ?>
                    <?php
                    $img = !empty($p['gambar']) ? url("/uploads/{$p['gambar']}") : url('assets/img/no-image.webp');
                    $izin = (isset($p['izin_edar']) && $p['izin_edar']) ? true : false;
                    ?>
                    <tr class="hover:bg-gray-50">
                      <td class="p-3 flex items-center gap-3">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="w-16 h-16 object-cover rounded shadow-sm">
                        <div>
                          <div class="font-semibold"><?= htmlspecialchars($p['nama_produk']) ?></div>
                          <div class="text-xs text-gray-500">Kode: <?= $p['kode_produk'] ?></div>
                        </div>
                      </td>
                      <td class="p-3">
                        <div class="font-medium">Rp<?= number_format($p['harga'], 0, ',', '.') ?></div>
                      </td>
                      <td class="p-3 text-center">
                        <?= (int)$p['stok'] ?>
                      </td>
                      <td class="p-3 text-center">
                        <?= (int)$p['terjual'] ?>
                      </td>
                      <td class="p-3 hidden md:table-cell">
                        <div class="text-sm text-gray-600">
                          <?= htmlspecialchars(mb_strimwidth($p['deskripsi'] ?? '', 0, 120, '...')) ?>
                        </div>
                      </td>
                      <td class="p-3 text-center">
                        <?php if ($izin): ?>
                          <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Ya</span>
                        <?php else: ?>
                          <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Tidak</span>
                        <?php endif; ?>
                      </td>
                      <td class="p-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                          <a href="<?= url("admin/produk/form?act=edit&k={$p['kode_produk']}") ?>" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm font-medium shadow">Edit</a>
                          <a href="<?= url("admin/produk/aksi?k={$p['kode_produk']}&act=hapus") ?>" onclick="return confirm('Yakin hapus?')" class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium shadow">Hapus</a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Card/List untuk mobile -->
        <div class="md:hidden space-y-4">
          <?php foreach ($produkList as $p): ?>
            <?php
            $img = !empty($p['gambar']) ? url("/uploads/{$p['gambar']}") : url('assets/img/no-image.webp');
            $izin = (isset($p['izin_edar']) && $p['izin_edar']) ? true : false;
            ?>
            <div class="bg-white rounded shadow p-4 flex gap-3">
              <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" class="w-16 h-16 object-cover rounded shadow-sm flex-shrink-0">
              <div class="flex-1">
                <div class="font-semibold text-lg"><?= htmlspecialchars($p['nama_produk']) ?></div>
                <div class="text-xs text-gray-500 mb-1">Kode: <?= $p['kode_produk'] ?></div>
                <div class="text-sm text-gray-600 mb-1"><?= htmlspecialchars(mb_strimwidth($p['deskripsi'] ?? '', 0, 60, '...')) ?></div>
                <div class="flex flex-wrap gap-2 items-center mb-2">
                  <span class="text-green-700 font-bold">Rp<?= number_format($p['harga'], 0, ',', '.') ?></span>
                  <span class="text-xs bg-gray-100 px-2 py-1 rounded">Stok: <?= (int)$p['stok'] ?></span>
                  <span class="text-xs bg-gray-100 px-2 py-1 rounded">Terjual: <?= (int)$p['terjual'] ?></span>
                  <?php if ($izin): ?>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Izin Edar: Ya</span>
                  <?php else: ?>
                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Izin Edar: Tidak</span>
                  <?php endif; ?>
                </div>
                <div class="flex gap-2">
                  <a href="<?= url("admin/produk/form?act=edit&k={$p['kode_produk']}") ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm font-medium shadow">Edit</a>
                  <a href="<?= url("admin/produk/aksi?k={$p['kode_produk']}&act=hapus") ?>" onclick="return confirm('Yakin hapus?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium shadow">Hapus</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
include COMPONENTS_PATH . '/admin/footer.php';
