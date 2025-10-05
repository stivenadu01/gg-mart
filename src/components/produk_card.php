<div class="pt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
  <?php foreach ($daftarProduk as $p) : ?>

    <a href="<?= url("detail_produk?t={$p['kode_produk']}") ?>" class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-xl transition duration-300 group">

      <div class="relative w-full h-40 overflow-hidden rounded-t-lg">
        <img
          src="<?= UPLOADS_PATH .  $p['gambar'] ?>"
          alt="<?= $p['nama_produk'] ?>"
          class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

        <!-- <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-sm shadow-md">
        >4%
      </span> -->
      </div>

      <div class="p-3">

        <p class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1 h-10 leading-5">
          <?= $p['nama_produk'] ?>
        </p>

        <p class="hidden md:block text-xs font-normal text-gray-600 line-clamp-2 mb-1 h-12 leading-4">
          <?= $p['deskripsi'] ?>
        </p>

        <p class="text-lg font-bold text-gray-900 mb-1">
          Rp<?= number_format($p['harga'], 0, ',', '.') ?>
        </p>

        <!-- <div class="flex flex-col space-y-0.5 mb-1">
        <span class="text-xs font-medium text-green-600">
          Bisa COD
        </span>
        <div class="text-xs text-orange-600 font-medium flex items-center">
          <span class="bg-orange-100 px-1 py-0.5 rounded mr-1">Hemat s.d 15%</span> Pakai Bonus
        </div>
      </div> -->

        <div class="flex items-center text-xs text-gray-500 space-x-2 mt-1">
          <div class="flex items-center">
            <!-- <span class="text-yellow-400 mr-1">⭐</span> -->
            <span>Stok (<?= $p['stok'] ?>)</span>
          </div>
          <span class="text-gray-300">|</span>
          <span><?= $p['terjual'] ?> Terjual</span>
        </div>

      </div>
    </a>
  <?php endforeach; ?>

</div>