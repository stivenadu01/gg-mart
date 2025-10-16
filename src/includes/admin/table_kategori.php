<template x-if="!loading && kategori.length > 0">
  <div class="md:p-3">
    <!-- TABEL  -->
    <div class="bg-white border border-gray-200 overflow-auto max-h-[80dvh] custom-scrollbar">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="(k, i) in kategori" :key="k.id_kategori">
            <tr>
              <td class="font-medium" x-text="i + 1 + (pagination.page-1)*pagination.limit"></td>
              <td class="font-semibold text-neural-800 min-w-[200px]" x-text="k.nama_kategori"></td>
              <td class="text-neutral-600 truncate max-w-xs" x-text="k.deskripsi || '-'"></td>
              <td class="text-center">
                <div class="flex justify-center items-center gap-2">
                  <a :href="baseUrl + '/admin/kategori/form?act=edit&id=' + k.id_kategori"
                    class="text-blue-600 hover:bg-blue-50 hover:text-blue-800 rounded-full"
                    title="Edit Kategori">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232a3 3 0 014.243 4.243L8.25 20.5H3.75v-4.5L15.232 5.232z" />
                    </svg> <span class="hidden md:inline">Edit</span>
                  </a>
                  <button @click="hapusKategori(k.id_kategori)"
                    class="text-red-600 hover:bg-red-50 hover:text-red-800 rounded-full"
                    title="Hapus Kategori">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="hidden md:inline"> Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <div x-show="!loading" class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-gray-100 gap-3 bg-gray-50">
      <p class="text-sm text-gray-500" x-text="`Menampilkan ${kategori.length} dari ${pagination.total} kategori`"></p>
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