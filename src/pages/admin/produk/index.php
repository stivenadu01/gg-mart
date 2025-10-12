<?php
$pageTitle = "Kelola Produk";
include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="kelolaProdukPage()" x-init="fetchProduk()" class="p-6 lg:p-10 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Kelola Produk</h1>
        <p class="text-sm text-gray-500">Pantau dan kelola seluruh produk GG-Mart dari sini.</p>
      </div>

      <div class="flex items-center gap-3">
        <!-- SEARCH -->
        <form @submit.prevent="doSearch" class="flex items-center shadow-sm">
          <input type="text" x-model="search" placeholder="Cari produk..."
            class="border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gg-primary focus:border-gg-primary w-48 md:w-64">
          <button type="submit"
            class="bg-gg-primary text-white px-4 py-2 rounded-r-md hover:bg-gg-primary-hover transition font-medium">Cari</button>
        </form>

        <!-- ADD -->
        <a href="<?= url('admin/produk/form?act=tambah') ?>"
          class="bg-gg-accent hover:opacity-90 transition text-white px-5 py-2 rounded-md shadow-sm flex items-center gap-2 font-semibold">
          <span class="text-lg leading-none">+</span>
          <span class="hidden md:inline">Tambah</span>
        </a>
      </div>
    </div>

    <!-- LOADING -->
    <?php include INCLUDES_PATH . '/loading.php' ?>


    <!-- TABEL PRODUK -->
    <?php include INCLUDES_PATH . '/admin/table_produk.php' ?>

    <!-- KOSONG -->
    <template x-if="!loading && produk.length === 0">
      <div class="bg-white rounded-lg shadow p-12 text-center border border-gray-200">
        <img src="<?= url('assets/img/no-image.webp') ?>" alt="Tidak ada produk"
          class="mx-auto w-28 h-28 opacity-60 mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Belum ada produk</h3>
        <p class="text-sm text-gray-500 mb-4">Tambahkan produk baru untuk mulai berjualan.</p>
        <a href="<?= url('admin/produk/form?act=tambah') ?>"
          class="inline-block bg-gg-primary hover:bg-gg-primary-hover text-white px-6 py-2 rounded-md font-medium shadow-sm">Tambah
          Produk</a>
      </div>
    </template>
  </div>
</div>

<script>
  function kelolaProdukPage() {
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
          fetch(`<?= url('api/produk') ?>?k=${kode}`, {
              method: "DELETE"
            })
            .then(r => r.json())
            .then(d => {
              if (d.success) {
                this.produk = this.produk.filter(p => p.kode_produk !== kode);
                alert("✅ Produk berhasil dihapus!");
              } else {
                alert("❌ Gagal menghapus produk: " + d.message);
              }
            })
            .catch(err => {
              console.error("Gagal menghapus produk:", err);
              alert("Gagal menghapus produk karena kesalahan jaringan.");
            });
        }
      }
    };
  }
</script>

<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>