function riwayatTransaksiPage() {
  return {
    search: null,
    showFilter: false,
    filter: {
      start: new Date().toLocaleDateString('sv-SE'),
      end: new Date().toLocaleDateString('sv-SE'),
      metode: ''
    },
    transaksi: [],
    modalDetail: false,
    detail: null,
    pagination: {
      page: 1,
      total: 0,
      total_pages: 1,
      limit: 10
    },
    loading: false,

    async fetchTransaksi() {
      this.loading = true;
      let url = `${baseUrl}/api/transaksi?start=${this.filter.start}&end=${this.filter.end}&metode=${this.filter.metode}&halaman=${this.pagination.page}&limit=${this.pagination.limit}`;
      if (this.search) {
        url += `&search=${this.search}`;
      }

      try {
        const res = await fetch(url);
        const data = await res.json();

        if (data.success) {
          this.transaksi = data.data;
          this.pagination = data.pagination;
        } else {
          console.log("error")
        }
      } catch (err) {
        console.error("Error fetch transaksi:", err);
      } finally {
        this.loading = false;
      }
    },

    async lihatDetail(id) {
      try {
        const res = await fetch(`${baseUrl}/api/transaksi?id=${id}`);
        const data = await res.json();
        if (data.success) {
          this.detail = data.data;
          this.detail.id_transaksi = id;
          this.modalDetail = true;
        }
      } catch (err) {
        console.error("Error fetch detail transaksi:", err);
      }
    },

    async batalTransaksi() {
      try {
        if (!confirm('yakin ingin menghapus transaksi ini?')) return;
        console.log(this.detail.id_transaksi);
        let res = await fetch(`${baseUrl}/api/transaksi?id=${this.detail.id_transaksi}`, {
          method: 'DELETE'
        });
        res = await res.json();
        if (res.success) {
          this.transaksi = this.transaksi.filter(t => t.id_transaksi !== this.detail.id_transaksi);
          showFlash("✅ transaksi berhasil dihapus!");
          this.detail = null;
          this.modalDetail = false;
        } else {
          showFlash("❌ Gagal menghapus transaksi");
        }
      } catch (err) {
        console.error("Error saat menghapus transaksi:", err);
      }
    },

    doSearch() {
      this.pagination.page = 1;
      this.fetchTransaksi();
    },

    nextPage() {
      if (this.pagination.page < this.pagination.total_pages) {
        this.pagination.page++;
        this.fetchTransaksi(this.pagination.page);
      }
    },

    prevPage() {
      if (this.pagination.page > 1) {
        this.pagination.page--;
        this.fetchTransaksi(this.pagination.page);
      }
    },

    goPage(n) {
      this.pagination.page = n;
      this.fetchTransaksi(n);
    },

    cetakUlang(id) {
      window.open(`${baseUrl}/admin/transaksi/print?id_transaksi=${id}`, '_blank');
    }
  }
}