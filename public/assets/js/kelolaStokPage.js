function kelolaStokPage() {
  return {
    mutasiStok: [],
    showFilter: false,
    filter: {
      type: '',
      search: '',
    },
    pagination: {
      page: 1,
      total: 0,
      total_pages: 1,
      limit: 10
    },
    loading: false,

    async fetchMutasiStok(page = 1) {
      this.loading = true;
      this.pagination.page = page;

      const params = new URLSearchParams({
        halaman: page,
        limit: this.pagination.limit,
        type: this.filter.type,
        search: this.filter.search
      });

      try {
        const res = await fetch(`${baseUrl}/api/mutasiStok?${params}`);
        const data = await res.json();

        if (data.success) {
          this.mutasiStok = data.data;
          this.pagination = data.pagination;
        } else {
          showFlash(data.message, 'error');
        }
      } catch (err) {
        console.error('Fetch stok error:', err);
        showFlash(data.message, 'error');
      } finally {
        this.loading = false;
      }
    },



    applyFilter() {
      this.showFilter = false;
      this.fetchMutasiStok(1);
    },

    resetFilter() {
      this.showFilter = false;
      this.filter.type = '';
      this.filter.search = '';
      this.fetchMutasiStok(1);
    },

    goPage(page) {
      if (page >= 1 && page <= this.pagination.total_pages && page !== this.pagination.page) {
        this.fetchMutasiStok(page);
      }
    },

    prevPage() {
      this.goPage(this.pagination.page - 1);
    },

    nextPage() {
      this.goPage(this.pagination.page + 1);
    },

    async hapusMutasiStok(id_mutasi, id_item, type) {
      if (!confirm("Yakin ingin menghapus mutasi stok ini?")) return;

      const res = await fetch(`${baseUrl}/api/mutasiStok?id_mutasi=${id_mutasi}&id_item=${id_item}&type=${type}`, {
        method: "DELETE"
      });
      const data = await res.json();

      if (data.success) {
        showFlash(data.message);
        this.fetchMutasiStok(this.pagination.page);
      } else {
        showFlash(data.message, 'error');
      }
    }
  }
}