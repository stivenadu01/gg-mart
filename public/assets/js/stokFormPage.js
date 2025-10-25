function stokFormPage() {
  return {
    items: [],
    mutasiList: [],
    satuan_dasar: "",
    nama_item: "",
    form: {
      id_item: "",
      type: "",
      jumlah: 0,
      total_pokok: 0,
      harga_pokok: 0,
      id_mutasi: "",
      keterangan: ""
    },
    page: 1,

    async fetchItems() {
      const res = await fetch(`${baseUrl}/api/itemStok?mode=all`);
      const data = await res.json();
      if (data.success) this.items = data.data;
    },

    updateSatuan() {
      const item = this.items.find(i => i.id_item == this.form.id_item);
      this.satuan_dasar = item ? item.satuan_dasar : "";
      this.nama_item = item ? item.nama_item : "";
    },

    async fetchMutasi() {
      this.updateSatuan();
      if (this.form.type !== "keluar" || !this.form.id_item) {
        this.mutasiList = [];
        return;
      }
      const res = await fetch(`${baseUrl}/api/mutasiStok?mode=list_mutasi_item&id_item=${this.form.id_item}`);
      const data = await res.json();
      if (data.success) this.mutasiList = data.data;
    },

    syncHargaPokok(source) {
      const j = parseFloat(this.form.jumlah) || 0;
      if (j <= 0) return;
      if (source === 'total') {
        this.form.harga_pokok = this.form.total_pokok / j;
      } else if (source === 'harga') {
        this.form.total_pokok = this.form.harga_pokok * j;
      }
    },

    async submitForm() {
      const formData = new FormData();
      for (let key in this.form) formData.append(key, this.form[key]);

      const res = await fetch(`${baseUrl}/api/mutasiStok`, { method: "POST", body: formData });
      const data = await res.json();

      if (data.success) {
        showFlash(data.message);
        setTimeout(() => {
          window.location.href = `${baseUrl}/admin/stok`;
        }, 1000);
      } else {
        showFlash(data.message || "Gagal menyimpan stok", "error");
      }
    },

    nextPage() {
      if (this.page === 1 && !this.form.type) return showFlash("Pilih jenis perubahan dulu", "error");
      if (this.page === 2 && !this.form.id_item) return showFlash("Pilih item dulu", "error");
      this.page++;
    },

    formatDate(tanggal) {
      const d = new Date(tanggal);
      return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }
  };
}
