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
      const urlApi = `${baseUrl}/api/produk?halaman=${page}&limit=${this.pagination.limit}&search=${encodeURIComponent(this.search)}`;

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

    async hapusProduk(kode) {
      let ok = await confirm("Yakin ingin menghapus produk ini?");
      if (await !ok) return;
      let res = await fetch(`${baseUrl}/api/produk?k=${kode}`, {
        method: "DELETE"
      })
      res = await res.json();
      if (res.success) {
        this.produk = this.produk.filter(p => p.kode_produk !== kode);
        showFlash("✅ Produk berhasil dihapus!");
      } else {
        showFlash("❌ Gagal menghapus produk: " + d.message);
      }
    }
  };
}