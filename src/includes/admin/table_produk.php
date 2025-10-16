<template x-if="!loading && produk.length > 0">
  <div class="md:p-3">
    <!-- TABEL -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-auto max-h-[80dvh] custom-scrollbar">
      <table class="table">
        <!-- HEAD -->
        <thead class="sticky top-0 z-10">
          <tr>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th class="hidden md:table-cell">Deskripsi</th>
            <th class="text-center">Stok & Terjual</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <!-- BODY -->
        <tbody>
          <template x-for="p in produk" :key="p.kode_produk">
            <tr
              class="hover:bg-gg-primary/10 transition-colors duration-150 ease-in-out cursor-pointer border-b border-gray-100">

              <!-- PRODUK -->
              <td class="flex items-center gap-4 min-w-[300px]">
                <div class="flex-shrink-0">
                  <img :src="p.gambar ? `${uploadsUrl}/${p.gambar}` : `${assetsUrl}/img/no-image.webp`"
                    alt="gambar produk" class="w-16 h-16 object-cover rounded-lg border border-gray-200 shadow-sm">
                </div>
                <div class="flex flex-col gap-1">
                  <span class="font-semibold text-gray-800 text-sm md:text-base line-clamp-1" x-text="p.nama_produk"></span>
                  <span class="text-xs text-gray-500">Kode: <span x-text="p.kode_produk"></span></span>
                </div>
              </td>

              <!-- KATEGORI -->
              <td class="text-gray-700 font-medium truncate" x-text="p.nama_kategori ?? 'Tidak Berkategori'"></td>

              <!-- HARGA -->
              <td class="font-semibold text-gray-800 whitespace-nowrap" x-text="'Rp ' + formatRupiah(p.harga)"></td>

              <!-- DESKRIPSI -->
              <td class="hidden md:table-cell text-gray-600 truncate max-w-xs" x-text="p.deskripsi"></td>


              <!-- STOK & TERJUAL -->
              <td class="text-center whitespace-nowrap">
                <div class="flex justify-center items-center gap-2">
                  <!-- Badge Stok -->
                  <span class="px-2 py-1 rounded-full text-xs font-semibold text-white"
                    :class="p.stok <= 5 ? 'bg-red-500' : 'bg-gg-primary'"
                    x-text="`Stok: ${p.stok}`">
                  </span>
                  <!-- Badge Terjual -->
                  <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white"
                    x-text="`Terjual: ${p.terjual}`">
                  </span>
                </div>
              </td>

              <!-- AKSI -->
              <td class="text-center">
                <div class="flex justify-center items-center">
                  <!-- Tombol Edit -->
                  <a :href="`${baseUrl}/admin/produk/form?id=${p.kode_produk}&act=edit`"
                    class="rounded-full text-blue-600 hover:bg-blue-50 hover:text-blue-800"
                    title="Edit Produk">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232a3 3 0 014.243 4.243L8.25 20.5H3.75v-4.5L15.232 5.232z" />
                    </svg><span class="hidden md:inline"> Edit</span>
                  </a>

                  <!-- Tombol Hapus -->
                  <button @click="hapusProduk(p.kode_produk)"
                    class="rounded-full text-red-600 hover:bg-red-50 hover:text-red-700"
                    title="Hapus Produk">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg> <span class="hidden md:inline"> Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>

    </div>
    <!-- PAGINATION -->
    <div class="flex flex-col p-4 md:flex-row justify-between items-center border-t border-gray-100 gap-3 bg-gray-50">
      <p class="text-sm text-gray-500" x-text="`Menampilkan ${produk.length} dari ${pagination.total} produk`"></p>
      <div class="flex flex-wrap gap-2">
        <button @click="prevPage" :disabled="pagination.page === 1"
          class="px-3 py-1 border rounded-md disabled:opacity-40 hover:bg-gray-100">‹</button>
        <template x-for="n in pagination.total_pages" :key="n">
          <button @click="goPage(n)"
            :class="{'bg-gg-primary text-white shadow-sm': pagination.page === n, 'border text-gray-700 hover:bg-gray-100': pagination.page !== n}"
            class="px-3 py-1 rounded-md transition">
            <span x-text="n"></span>
          </button>
        </template>
        <button @click="nextPage" :disabled="pagination.page === pagination.total_pages"
          class="px-3 py-1 border rounded-md disabled:opacity-40 hover:bg-gray-100">›</button>
      </div>
    </div>
  </div>
</template>