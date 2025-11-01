<?php
$pageTitle = "Input Transaksi";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="transaksiPage()" class="bg-gray-50 p-2 lg:p-4 space-y-4">
  <div class="flex  flex-col md:flex-row">

    <div class="w-full md:w-2/3 bg-white p-4 rounded-xl shadow-lg h-[85dvh] flex flex-col">
      <div class="mb-4 bg-white pb-4 border-b border-gray-100">
        <input id="searchProduk"
          type="text"
          placeholder="Cari Produk...  [ctrl+k]"
          autofocus
          x-model="search"
          class="p-5 w-full md:p-6 text-2xl font-semibold tracking-wide input-trx
       bg-white border-gray-950 shadow-none border placeholder-gray-400 text-gray-900 "
          @input.debounce.200="fetchProduk()"
          @keydown.enter.prevent="tambahProdukDariInput()">
      </div>

      <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
        <div x-show="produk.length === 0 && search != ''" class="text-center text-gray-500 py-10">
          <p>Tidak ada produk ditemukan.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4">
          <template x-for="p in produk" :key="p.kode_produk">
            <div
              class="relative bg-white border border-gray-200 rounded-xl hover:shadow-xl hover:border-emerald-300 transition-all duration-300 cursor-pointer overflow-hidden group"
              :class="p.stok == 0 ? 'opacity-50 cursor-not-allowed' : ''"
              @click="p.stok > 0 && tambahKeranjang(p)">

              <div class="relative">
                <img :src="p.gambar ? `${uploadsUrl}/${p.gambar}` : `${assetsUrl}/img/no-image.webp`"
                  class="w-full h-28 object-cover transition duration-500 group-hover:scale-105">

                <span
                  class="absolute top-1 right-1 text-xs font-bold px-1.5 py-1 rounded-md shadow-lg transition-all duration-200"
                  :class="{'bg-red-500 text-white': p.stok == 0, 'bg-yellow-400 text-gray-800': p.stok > 0 && p.stok <= 5, 'bg-emerald-500 text-white': p.stok > 10}"
                  x-text="p.stok > 0 ? p.stok +' '+p.satuan_dasar : 'HABIS'">
                </span>
              </div>

              <div class="p-2">
                <p class="text-xs font-medium text-gray-400 truncate" x-text="p.nama_kategori"></p>
                <h2 class="text-sm font-bold text-gray-800 truncate" x-text="p.nama_produk"></h2>
                <p class="text-lg font-extrabold text-emerald-600 mt-1" x-text="formatRupiah(p.harga_jual)"></p>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>


    <div class="fixed bottom-0 w-full md:static md:w-1/3 bg-white rounded-xl shadow-2xl flex flex-col">
      <div class="flex items-center justify-between text-emerald-700 mb-2 px-4 border-b pb-4">
        <h2 class="text-xl font-extrabold">RINCIAN TRANSAKSI</h2>

        <button @click="resetKeranjang()"
          class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-md transition flex items-center justify-center text-sm"
          title="Reset Keranjang">
          <span class="mr-1 text-sm">Reset</span>
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.24 20.16 10.53 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z" />
          </svg>
        </button>
      </div>

      <div class="flex flex-1 flex-col space-y-3 p-4 overflow-y-auto max-h-[43dvh]">
        <template x-for="(item, index) in keranjang" :key="item.kode_produk">
          <div class="flex justify-between items-center border-b border-gray-200 pb-3 hover:bg-gray-50 -mx-4 px-4 transition duration-150">
            <div class="flex-1 pr-2">
              <h3 class="font-semibold text-gray-800 text-sm truncate" x-text="item.nama_produk"></h3>
              <p class="text-xs text-gray-500" x-text="formatRupiah(item.harga_satuan)"></p>
            </div>

            <div class="flex items-center gap-2">
              <input type="number" min="1"
                class="!w-14 text-sm py-1 px-1 border-gray-300 rounded-md focus:border-emerald-500 focus:ring-emerald-500 text-center"
                x-model.number="item.jumlah" @input.debounce.200="updateSubtotal(index)">

              <p class="text-sm font-bold text-gray-900 text-right" x-text="formatRupiah(item.subtotal)"></p>

              <button @click="hapusKeranjang(index)" class="text-red-500 hover:text-red-700 p-1 rounded-full transition">
                ❌
              </button>
            </div>
          </div>
        </template>


        <div x-show="keranjang.length === 0" class="text-gray-500 text-center p-10">
          <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <p class="text-sm">Silakan tambahkan produk dari daftar.</p>
        </div>
      </div>

      <div class="mt-auto border-t-4 border-emerald-200 pt-3 space-y-2 p-3 bg-gray-50 rounded-b-xl shadow-inner">

        <div class="flex justify-between text-2xl text-emerald-700 font-extrabold pb-1 border-b-2 border-emerald-100">
          <span>TOTAL</span>
          <span x-text="formatRupiah(totalHarga)"></span>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Metode Pembayaran</label>
          <div class="flex space-x-2">
            <label for="bayar-tunai" class="flex-1 cursor-pointer">
              <input type="radio" id="bayar-tunai" name="metode" value="tunai" x-model="metodeBayar" class="sr-only peer">
              <div class="w-full text-center p-1.5 rounded-lg border-2 border-gray-300 text-gray-700 
                peer-checked:bg-emerald-500 peer-checked:border-emerald-600 peer-checked:text-white 
                transition duration-200 hover:bg-gray-100 font-medium shadow-sm flex items-center justify-center text-sm">

                <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
                TUNAI
              </div>
            </label>
            <label for="bayar-qris" class="flex-1 cursor-pointer">
              <input type="radio" id="bayar-qris" name="metode" value="qris" x-model="metodeBayar" class="sr-only peer">
              <div class="w-full text-center p-1.5 rounded-lg border-2 border-gray-300 text-gray-700 peer-checked:bg-emerald-500 peer-checked:border-emerald-600 peer-checked:text-white transition duration-200 hover:bg-gray-100 font-medium shadow-sm flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 11h8V3H3v8zm2-6h4v4H5V5zM3 21h8v-8H3v8zm2-6h4v4H5v-4zM13 3v8h8V3h-8zm2 2h4v4h-4V5zM15 15h2v2h-2v-2zM15 11h2v2h-2v-2zM15 19h2v2h-2v-2zM19 15h2v2h-2v-2zM19 11h2v2h-2v-2zM19 19h2v2h-2v-2z" />
                </svg>
                QRIS
              </div>
            </label>
          </div>
        </div>

        <div>
          <template x-if="submitting">
            <button class="w-full bg-green-600 hover:bg-green-700 text-white font-extrabold py-5 rounded-xl shadow-lg transition cursor-not-allowed flex items-center justify-center text-base uppercase tracking-wider">
              <span>Memproses Transaksi...</span>
            </button>
          </template>
          <template x-if="!submitting">
            <div class="space-y-1 mt-1">
              <button @click="simpanTransaksi(true)"
                :disabled="keranjang.length === 0"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-extrabold py-2.5 rounded-xl shadow-lg transition disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center text-base uppercase tracking-wider">
                <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6V3h12v6z" />
                </svg>
                <span>BAYAR & CETAK STRUK</span>
              </button>
              <button @click="simpanTransaksi(false)"
                :disabled="keranjang.length === 0"
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-1.5 rounded-xl shadow-md transition disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                </svg>
                <span>Simpan Tanpa Cetak</span>
              </button>
            </div>
          </template>
        </div>

      </div>
    </div>
  </div>
  <div class="printFrame hidden"></div>
</div>

<script src="<?= ASSETS_URL . '/js/transaksiPage.js' ?>"></script>
<?php
include INCLUDES_PATH . "admin/layout/footer.php";
