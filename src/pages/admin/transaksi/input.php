<?php
$pageTitle = "input Transaksi";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="transaksiPage()" x-init="fetchProduk()" class="bg-gray-50 space-y-3">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
    <!-- LEFT: Daftar Produk -->
    <div class="md:col-span-2 bg-white p-2 md:p-4 rounded-lg shadow-md">
      <div class="mb-4 sticky top-0 z-10">
        <input id="searchProduk" type="text" placeholder="Cari produk..." autofocus
          x-model="search"
          class="p-5 font-medium rounded-none hover:scale-100 focus:scale-100 text-2xl bg-white text-black border-black focus:ring-0"
          @input.debounce.300="fetchProduk()"
          @keydown.enter.prevent="tambahProdukDariInput()">
      </div>
      <div class="min-h-[70dvh]">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 overflow-y-auto">
          <!-- <template x-for="p in produk" :key="p.kode_produk">
            <div class="border border-gray-200 hover:scale-105 p-3 rounded-lg hover:shadow-lg transition cursor-pointer"
              @click="tambahKeranjang(p)">
              <img :src="p.gambar ? `${uploadsUrl}/${p.gambar}` : `${assetsUrl}/img/no-image.webp`"
                class="w-full h-24 object-cover rounded-md mb-2">
              <h2 class="text-sm font-semibold text-gray-700" x-text="p.nama_produk"></h2>
              <p class="text-xs text-gray-500" x-text="p.nama_kategori"></p>
              <p class="text-sm font-bold text-gray-900 mt-1" x-text="formatRupiah(p.harga)"></p>
              <p class="text-xs text-gray-400" x-text="'Stok: ' + p.stok"></p>
            </div>
          </template> -->
          <template x-for="p in produk" :key="p.kode_produk">
            <div
              class="relative border border-gray-200 hover:scale-95 rounded-lg hover:shadow-lg transition cursor-pointer"
              @click="tambahKeranjang(p)">

              <!-- GAMBAR PRODUK -->
              <div class="relative">
                <img :src="p.gambar ? `${uploadsUrl}/${p.gambar}` : `${assetsUrl}/img/no-image.webp`"
                  class="w-full h-24 object-cover rounded-md mb-2">

                <!-- BADGE STOK -->
                <span
                  class="absolute top-1 right-1 text-[11px] font-semibold px-2 py-[2px] rounded-full text-neutral-800 shadow transition-all duration-200"
                  :style="{
                    backgroundColor: p.stok == 0
                      ? 'rgba(239, 68, 68, 1)'        // merah (habis)
                      : p.stok <= 10
                        ? `rgba(234, 179, 8, ${Math.min(1, Math.max(0.1, p.stok / 10))})`   // kuning
                        : `rgba(34, 197, 94, ${Math.min(1, Math.max(0.1, p.stok / 100))})`   // hijau
                  }"
                  x-text="p.stok > 0 ? 'Stok: ' + p.stok : 'Habis'">
                </span>


              </div>
              <!-- INFO PRODUK -->
              <div class="p-3">
                <h2 class="text-sm font-semibold text-gray-700" x-text="p.nama_produk"></h2>
                <p class="text-xs text-gray-500" x-text="p.nama_kategori"></p>
                <p class="text-sm font-bold text-gray-900 mt-1" x-text="formatRupiah(p.harga)"></p>
              </div>
            </div>
          </template>

        </div>
      </div>
    </div>

    <!-- RIGHT: Keranjang -->
    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col">
      <h2 class="text-lg font-bold text-gray-800 mb-4">Keranjang</h2>
      <template x-if="keranjang.length === 0">
        <p class="text-gray-500 text-sm">Belum ada produk di keranjang</p>
      </template>

      <div class="flex flex-1 flex-col space-y-2">
        <template x-for="(item, index) in keranjang" :key="item.kode_produk">
          <div class="flex justify-between items-center border-b border-gray-200 pb-2">
            <div>
              <h3 class="font-semibold text-gray-700" x-text="item.nama_produk"></h3>
              <p class="text-xs text-gray-500" x-text="'Harga: ' + formatRupiah(item.harga_satuan)"></p>
            </div>
            <div class="flex items-center gap-2">
              <input type="number" min="1" class="w-16 text-sm"
                x-model.number="item.jumlah" @change="updateSubtotal(index)" @input.debounce.200>
              <p class="text-sm font-semibold" x-text="formatRupiah(item.subtotal)"></p>
              <button @click="hapusKeranjang(index)" class="text-red-500 hover:text-red-600">&times;</button>
            </div>
          </div>
        </template>
      </div>

      <div class="mt-4 border-t pt-4 space-y-2">
        <div class="flex justify-between text-neutral-800 font-bold">
          <span>Total</span>
          <span x-text="formatRupiah(totalHarga)"></span>
        </div>

        <div>
          <label>Metode Bayar</label>
          <select x-model="metodeBayar"
            class="">
            <option value="TUNAI">Tunai</option>
            <option value="QRIS">QRIS</option>
          </select>
        </div>
        <button @click="resetKeranjang()"
          class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition w-full">Reset Keranjang</button>
        <button @click="simpanTransaksi()"
          class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg shadow-md transition">
          Simpan Transaksi
        </button>
      </div>
    </div>
  </div>
</div>

<script src="<?= ASSETS_URL . 'js/transaksiPage.js' ?>"></script>
<?php
include INCLUDES_PATH . "admin/layout/footer.php";
