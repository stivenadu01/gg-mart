<template x-if="!loading && mutasiStok.length > 0">
  <div class="space-y-3">
    <div class="overflow-auto max-h-[80dvh] custom-scrollbar bg-white rounded-xl shadow-lg border border-gray-100">
      <table class="app-table text-gray-700">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Masuk/Keluar</th>
            <th>Sisa Stok</th>
            <th>Harga Pokok/Beli</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="ms in mutasiStok" :key="ms.id_mutasi">
            <tr>
              <td x-text="formatDateTime(ms.tanggal)"></td>
              <td x-text="ms.nama_produk"></td>
              <td class="text-right text-xs">
                <span :class="ms.type == 'masuk' ? 'bg-green-100 text-green-500 border-green-500' : 'bg-red-100 border-red-500 text-red-500'" class="uppercase fontme font-medium px-2 py-1 rounded-md border" x-text="ms.type + ' ' + ms.jumlah + ' ' + ms.satuan_dasar"></span>
              </td>
              <td class="text-right text-xs">
                <template x-if="ms.type == 'keluar'"> <span> - </span> </template>
                <template x-if="ms.type == 'masuk'">
                  <span :class="`${ms.sisa_stok < 5 ? 'bg-red-100 text-red-500 border-red-500' : ms.sisa_stok == ms.jumlah ? 'bg-green-100 text-green-500 border-green-500' : 'bg-yellow-100 text-yellow-500 border-yellow-500'}`" class="border uppercase font-medium px-2 py-1 rounded-md" x-text="'Tersisa ' + ms.sisa_stok + ' ' + ms.satuan_dasar"></span>
                </template>
              </td>
              <td class="text-right">
                <span x-text="formatRupiah(ms.harga_pokok)" class="font-medium"></span>
              </td>
              <td><span x-text="ms.keterangan ?? '-'"></span></td>

              <!-- AKSI -->
              <td class="text-center">
                <template x-if="ms.type != 'keluar' && ms.jumlah == ms.sisa_stok">
                  <div class="flex justify-center items-center gap-2">
                    <button @click="hapusMutasiStok(ms.id_mutasi)"
                      class="text-red-600 hover:text-red-800 transition p-1 rounded-full"
                      title="Hapus Mutasi"
                      :disabled="submitting">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                      <span class="hidden md:inline-block font-normal"> Hapus</span>
                    </button>
                  </div>
                </template>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>