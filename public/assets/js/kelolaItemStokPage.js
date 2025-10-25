function kelolaItemStokPage() {
  return {
    // Data State
    items: [],
    loading: true,
    search: '',
    pagination: {
      total: 0,
      page: 1,
      limit: 10,
      total_pages: 1
    },

    // Action Handlers
    async fetchItemStok() {
      this.loading = true;
      try {
        const url = `${baseUrl}/api/itemStok?halaman=${this.pagination.page}&limit=${this.pagination.limit}&search=${this.search}`;
        const res = await fetch(url);
        const data = await res.json();

        if (data.success) {
          this.items = data.data;
          this.pagination = data.pagination;
        } else {
          showFlash("Gagal memuat data Item Stok.", 'error');
        }
      } catch (error) {
        console.error('Error fetching item stok:', error);
        showFlash("Terjadi kesalahan jaringan saat memuat data.", 'error');
      } finally {
        this.loading = false;
      }
    },

    doSearch() {
      this.pagination.page = 1; // Reset ke halaman 1 saat mencari
      this.fetchItemStok();
    },

    // Pagination Handlers
    goPage(page) {
      if (page >= 1 && page <= this.pagination.total_pages) {
        this.pagination.page = page;
        this.fetchItemStok();
      }
    },
    nextPage() {
      if (this.pagination.page < this.pagination.total_pages) {
        this.pagination.page++;
        this.fetchItemStok();
      }
    },
    prevPage() {
      if (this.pagination.page > 1) {
        this.pagination.page--;
        this.fetchItemStok();
      }
    },

    // Delete Handler
    async hapusItem(id_item) {
      if (!confirm("Anda yakin ingin menghapus item stok ini? Menghapus item dapat memengaruhi data stok yang sudah ada.")) {
        return;
      }

      try {
        const url = `${baseUrl}/api/itemStok?id=${id_item}`;
        const res = await fetch(url, { method: 'DELETE' });
        const data = await res.json();

        if (data.success) {
          showFlash("Item Stok berhasil dihapus!", 'success');
          // Muat ulang data setelah penghapusan
          this.fetchItemStok();
        } else {
          showFlash("Gagal menghapus Item Stok: " + data.message, 'error');
        }
      } catch (error) {
        showFlash("Terjadi kesalahan jaringan/sistem.", 'error');
      }
    }
  };
}

// Asumsi formatRupiah, showFlash, baseUrl, assetsUrl tersedia secara global