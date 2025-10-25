<template x-if="!loading && mutasiStok.length > 0">
  <div class="space-y-3">
    <!-- TABEL -->
    <div class="overflow-auto custom-scrollbar bg-white rounded-xl shadow-lg border border-gray-100">
      <table class="app-table min-w-full text-sm text-gray-700">
        <thead>
          <tr>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Item</th>
            <th class="p-3">Tipe</th>
            <th class="p-3 text-right">Jumlah</th>
            <th class="p-3 text-right">Harga Pokok</th>
            <th class="p-3 text-right">Sisa</th>
            <th class="p-3">Keterangan</th>
            <th class="p-3 text-center w-1">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="ms in mutasiStok" :key="ms.id_mutasi">
            <tr class="border-b hover:bg-gray-50">
              <td class="p-3 whitespace-nowrap" x-text="formatDateTime(ms.tanggal)"></td>
              <td class="p-3 font-semibold text-gray-800" x-text="ms.nama_item"></td>
              <td class="p-3 font-semibold">
                <span :class="ms.type === 'masuk' ? 'text-green-600' : 'text-red-600'"
                  x-text="ms.type.toUpperCase()"></span>
              </td>
              <td class="p-3 text-right" x-text="ms.jumlah + ms.satuan_dasar"></td>
              <td class="p-3 text-right" x-text="formatRupiah(ms.harga_pokok)"></td>
              <td class="p-3 text-right" x-text="ms.sisa_stok + ms.satuan_dasar"></td>
              <td class="p-3 truncate max-w-[200px]" x-text="ms.keterangan || '-'"></td>
              <td class="p-3 text-center">
                <button @click="hapusMutasiStok(ms.id_mutasi, ms.id_item, ms.type)"
                  class="text-red-600 hover:text-red-800 transition p-1 rounded-full" title="Hapus Riwayat">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  <span class="hidden md:block font-normal"> Hapus</span>
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-t border-gray-100 gap-3 bg-gray-50 rounded-b-xl">
      <p class="text-sm text-gray-500" x-text="`Menampilkan ${mutasiStok.length} dari ${pagination.total} data`"></p>
      <div class="flex flex-wrap gap-2">
        <button @click="prevPage" :disabled="pagination.page === 1"
          class="btn px-3 py-1 w-auto shadow-none bg-gray-100 text-gray-700 disabled:opacity-40 hover:bg-gray-200">‹</button>

        <template x-for="n in pagination.total_pages" :key="n">
          <button @click="goPage(n)"
            :class="pagination.page == n ? 'bg-gg-primary text-white shadow-sm' : 'border border-gray-300 text-gray-700 hover:bg-gray-100'"
            class="btn px-3 py-1 w-auto shadow-none rounded-md">
            <span x-text="n"></span>
          </button>
        </template>

        <button @click="nextPage" :disabled="pagination.page == pagination.total_pages"
          class="btn px-3 py-1 w-auto shadow-none bg-gray-100 text-gray-700 disabled:opacity-40 hover:bg-gray-200">›</button>
      </div>
    </div>
  </div>
</template>