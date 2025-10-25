<template x-if="!loading && items.length > 0">
  <div class="space-y-3">
    <div class="overflow-auto max-h-[80dvh] custom-scrollbar">
      <table class="app-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Item</th>
            <th>Satuan Dasar</th>
            <th class="text-center">Stok Saat Ini</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="item, no in items" :key="item.id_item">
            <tr>
              <td class="text-gray-500 text-sm font-medium" x-text="no + 1"></td>

              <td class="font-semibold text-gray-800 min-w-[300px]" x-text="item.nama_item"></td>

              <td class="text-gray-700 font-medium whitespace-nowrap" x-text="item.satuan_dasar"></td>

              <td class="text-center whitespace-nowrap">
                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                  :class="item.stok <= 10 ? 'bg-red-500' : 'bg-gg-primary'"
                  x-text="item.stok">
                </span>
              </td>

              <td class="text-center whitespace-nowrap">
                <div class="flex justify-center items-center gap-2">
                  <a :href="`${baseUrl}/admin/stok/item_form?id=${item.id_item}&act=edit`"
                    class="text-blue-600 hover:text-blue-800 transition p-1 rounded-full"
                    title="Edit Item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232a3 3 0 014.243 4.243L8.25 20.5H3.75v-4.5L15.232 5.232z" />
                      <span class="hidden md:inline-block font-normal"> Edit</span>
                    </svg>
                  </a>

                  <button @click="hapusItem(item.id_item)"
                    class="text-red-600 hover:text-red-800 transition p-1 rounded-full"
                    title="Hapus Item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="hidden md:inline-block font-normal"> Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-gray-100 gap-3 bg-gray-50 rounded-b-xl">
      <p class="text-sm text-gray-500" x-text="`Menampilkan ${items.length} dari ${pagination.total} item`"></p>
      <div class="flex flex-wrap gap-2">
        <button @click="prevPage" :disabled="pagination.page === 1"
          class="btn px-3 py-1 w-auto shadow-none bg-gray-100 text-gray-700 disabled:opacity-40 hover:bg-gray-200">‹</button>
        <template x-for="n in pagination.total_pages" :key="n">
          <button @click="goPage(n)"
            :class="{'bg-gg-primary text-white shadow-sm': pagination.page === n, 'border border-gray-300 text-gray-700 hover:bg-gray-100': pagination.page !== n}"
            class="btn px-3 py-1 w-auto shadow-none">
            <span x-text="n"></span>
          </button>
        </template>
        <button @click="nextPage" :disabled="pagination.page === pagination.total_pages"
          class="btn px-3 py-1 w-auto shadow-none bg-gray-100 text-gray-700 disabled:opacity-40 hover:bg-gray-200">›</button>
      </div>
    </div>
  </div>
</template>