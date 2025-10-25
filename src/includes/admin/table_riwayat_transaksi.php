<template x-if="!loading && transaksi.length > 0">
  <div class="space-y-3">
    <div class="overflow-auto max-h-[80dvh] custom-scrollbar">
      <table class="app-table">
        <thead>
          <tr>
            <th class="w-1">No</th>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Kasir</th>
            <th>Metode</th>
            <th class="text-right">Total</th>
            <th class="w-1">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="(t, i) in transaksi" :key="t.id_transaksi">
            <tr>
              <td x-text="i + 1 + (pagination.page-1)*pagination.limit"></td>
              <td x-text="formatDateTime(t.tanggal_transaksi)" class="whitespace-nowrap"></td>
              <td x-text="t.kode_transaksi"></td>
              <td x-text="t.kasir ?? '-'"></td>
              <td x-text="t.metode_bayar"></td>
              <td class="text-right font-semibold" x-text="formatRupiah(t.total_harga)"></td>
              <td class="text-center">
                <button @click="lihatDetail(t.id_transaksi)" class="text-blue-600 hover:text-blue-700 font-medium transition">Detail</button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <div class="flex flex-col p-4 md:flex-row justify-between items-center border-t border-gray-100 gap-3 bg-gray-50">
      <p class="text-sm text-gray-500" x-text="`Menampilkan ${transaksi.length} dari ${pagination.total} transaksi`"></p>
      <div class="flex flex-wrap gap-2">
        <button @click="prevPage" :disabled="pagination.page === 1"
          class="px-3 py-1 border rounded-md disabled:opacity-40 hover:bg-gray-100">‹</button>
        <template x-for="n in pagination.total_pages" :key="n">
          <button @click="goPage(n)"
            :class="{'bg-gg-primary text-white shadow-sm': pagination.page == n, 'border text-gray-700 hover:bg-gray-100': pagination.page != n}"
            class="px-3 py-1 rounded-md transition">
            <span x-text="n"></span>
          </button>
        </template>
        <button @click="nextPage" :disabled="pagination.page == pagination.total_pages"
          class="px-3 py-1 border rounded-md disabled:opacity-40 hover:bg-gray-100">›</button>
      </div>
    </div>

  </div>
</template>