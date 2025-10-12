<?php
$pageTitle = "Kelola Produk";
include INCLUDES_PATH . "admin/header.php";

?>
<div x-data="produkPage()" x-init="fetchProduk()" class="p-8 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-800">Kelola Produk</h1>
        <p class="text-sm text-gray-500">Kelola daftar produk toko Anda dari sini.</p>
      </div>

      <div class="flex items-center gap-3">
        <form @submit.prevent="doSearch" class="flex items-center">
          <input type="text" x-model="search" placeholder="Cari produk..." class="border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gg-primary opacity-40">
          <button type="submit" class="bg-gg-primary text-white px-4 py-2 rounded-r hover:bg-gg-primary hover:opacity-80 transition">Cari</button>
        </form>
        <a href="<?= url('admin/produk/form?act=tambah') ?>" class="bg-gg-accent hover:opacity-80 transition text-white px-6 py-2 rounded shadow font-semibold">
          + <span class="hidden md:inline-block">Tambah Produk</span>
        </a>

      </div>
    </div>

    <!-- LOADING -->
    <template x-if="loading">
      <div class="flex justify-center items-center h-64">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
      </div>
    </template>

    <!-- TABEL PRODUK -->
    <template x-if="!loading && produk.length > 0">
      <div class="bg-white rounded-lg shadow">
        <!-- Wrapper scrollable -->
        <div class="overflow-x-auto max-h-[70vh]">
          <table class="min-w-full text-sm text-gray-700 border-collapse">
            <!-- HEAD -->
            <thead class="bg-gg-primary text-white sticky top-0 z-10">
              <tr>
                <th class="p-3 text-left font-semibold">Produk</th>
                <th class="p-3 text-left font-semibold">Harga</th>
                <th class="p-3 text-center font-semibold">Stok</th>
                <th class="p-3 text-center font-semibold">Terjual</th>
                <th class="p-3 text-left font-semibold hidden md:table-cell">Deskripsi</th>
                <th class="p-3 text-center font-semibold">Aksi</th>
              </tr>
            </thead>

            <!-- BODY -->
            <tbody class="divide-y divide-gray-200">
              <template x-for="p in produk" :key="p.kode_produk">
                <tr class="hover:bg-gray-50 transition">
                  <!-- PRODUK -->
                  <td class="p-3 flex items-center gap-4 min-w-[250px]">
                    <!-- Gambar Produk -->
                    <div class="flex-shrink-0">
                      <img :src="p.gambar ? `<?= BASE_URL ?>/uploads/${p.gambar}` : `<?= BASE_URL ?>/assets/img/no-image.webp`"
                        alt="" class="w-16 h-16 object-cover rounded-lg border shadow-sm">
                    </div>

                    <!-- Info Produk -->
                    <div class="flex flex-col justify-center gap-1 overflow-hidden">
                      <!-- Nama Produk -->
                      <div class="font-semibold text-gray-800 text-sm md:text-base truncate" x-text="p.nama_produk"></div>

                      <!-- Kode Produk -->
                      <div class="text-xs text-gray-500 flex flex-wrap gap-1">
                        <span class="font-medium">Kode:</span>
                        <span x-text="p.kode_produk" class="truncate"></span>
                      </div>

                      <!-- Kategori -->
                      <div class="text-xs flex items-center gap-1">
                        <span class="font-medium text-gray-500">Kategori:</span>
                        <span class="inline-block bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded-full truncate"
                          x-text="p.nama_kategori ? p.nama_kategori : 'Tidak Berkategori'"></span>
                      </div>
                    </div>
                  </td>

                  <!-- HARGA -->
                  <td class="p-3 font-medium text-gray-800 whitespace-nowrap" x-text="'Rp ' + formatRupiah(p.harga)"></td>

                  <!-- STOK -->
                  <td class="p-3 text-center whitespace-nowrap" x-text="p.stok"></td>

                  <!-- TERJUAL -->
                  <td class="p-3 text-center whitespace-nowrap" x-text="p.terjual"></td>

                  <!-- DESKRIPSI -->
                  <td class="p-3 hidden md:table-cell text-gray-600 truncate max-w-xs" x-text="p.deskripsi"></td>

                  <!-- AKSI -->
                  <td class="p-3 text-center space-x-2 flex justify-center items-center">
                    <a :href="`<?= BASE_URL ?>/admin/produk/form?id=${p.kode_produk}&act=edit`"
                      class="text-blue-600 hover:underline">Edit</a>
                    <button @click="hapusProduk(p.kode_produk)" class="text-red-600 hover:underline">Hapus</button>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <!-- PAGINATION -->
        <div class="flex flex-col md:flex-row justify-between items-center p-4 border-t gap-2">
          <p class="text-sm text-gray-500" x-text="`Menampilkan ${produk.length} dari ${pagination.total} produk`"></p>
          <div class="flex flex-wrap gap-2">
            <button @click="prevPage" :disabled="pagination.page === 1"
              class="px-3 py-1 border rounded disabled:opacity-40">‹</button>
            <template x-for="n in pagination.total_pages" :key="n">
              <button @click="goPage(n)"
                :class="{'bg-gg-primary text-white': pagination.page === n, 'border text-gray-700': pagination.page !== n}"
                class="px-3 py-1 rounded hover:bg-gg-primary/20">
                <span x-text="n"></span>
              </button>
            </template>
            <button @click="nextPage" :disabled="pagination.page === pagination.total_pages"
              class="px-3 py-1 border rounded disabled:opacity-40">›</button>
          </div>
        </div>
      </div>
    </template>



    <!-- KOSONG -->
    <template x-if="!loading && produk.length === 0">
      <div class="bg-white rounded-lg shadow p-12 text-center">
        <img src="<?= url('assets/img/no-image.webp') ?>" alt="Tidak ada produk" class="mx-auto w-28 h-28 opacity-60 mb-4">
        <h3 class="text-lg font-semibold">Belum ada produk</h3>
        <p class="text-sm text-gray-500 mb-4">Tambahkan produk baru untuk mulai berjualan.</p>
        <a href="<?= url('admin/produk/form?act=tambah') ?>" class="inline-block bg-gg-primary hover:bg-gg-primary-hover text-white px-5 py-2 rounded">Tambah Produk</a>
      </div>
    </template>
  </div>
</div>

<script>
  function produkPage() {
    return {
      produk: [],
      pagination: {
        page: 1,
        total: 0,
        total_pages: 1,
        limit: 10
      },
      search: "",
      loading: false,

      async fetchProduk(page = 1) {
        this.loading = true;

        // ✅ URL API HARUS DI-DEFINISIKAN DI SINI
        const urlApi = `<?= url("api/produk") ?>?halaman=${page}&limit=${this.pagination.limit}&search=${encodeURIComponent(this.search)}`;

        try {
          const res = await fetch(urlApi);
          const data = await res.json();

          if (data.success) {
            this.produk = data.data;
            this.pagination = data.pagination;
          } else {
            console.error("API error:", data.message);
          }
        } catch (e) {
          console.error("FetchProduk error:", e);
        } finally {
          this.loading = false;
        }
      },

      doSearch() {
        this.pagination.page = 1;
        this.fetchProduk();
      },

      nextPage() {
        if (this.pagination.page < this.pagination.total_pages) {
          this.pagination.page++;
          this.fetchProduk(this.pagination.page);
        }
      },

      prevPage() {
        if (this.pagination.page > 1) {
          this.pagination.page--;
          this.fetchProduk(this.pagination.page);
        }
      },

      goPage(n) {
        this.pagination.page = n;
        this.fetchProduk(n);
      },

      formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
      },

      hapusProduk(kode) {
        if (confirm("Yakin ingin menghapus produk ini?")) {
          fetch(`<?= url('controllers/api/produk_delete.php?kode=') ?>${kode}`)
            .then(r => r.json())
            .then(d => {
              if (d.success) {
                this.produk = this.produk.filter(p => p.kode_produk !== kode);
                alert("Produk berhasil dihapus!");
              } else {
                alert("Gagal menghapus produk.");
              }
            });
        }
      }
    };
  }
</script>


<?php include INCLUDES_PATH . "admin/footer.php"; ?>