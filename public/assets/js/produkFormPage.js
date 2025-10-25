function produkFormPage(act, id) {
  return {
    page: 1,
    kategori: [],
    items: [],
    satuan_dasar: '',
    preview: null,

    isEdit: act === 'edit',
    formTitle: act === 'edit' ? 'Edit Produk' : 'Tambah Produk',

    form: {
      id_kategori: '',
      nama_produk: '',
      harga_jual: '',
      id_item: '',
      jumlah_satuan: '',
      deskripsi: '',
      gambar: null
    },

    async initPage() {
      await this.fetchKategori();
      await this.fetchItems();
      if (this.isEdit && id) await this.fetchProduk(id);
    },

    async fetchKategori() {
      const res = await fetch(`${baseUrl}/api/kategori?mode=all`);
      const data = await res.json();
      if (data.success) this.kategori = data.data;
    },

    async fetchItems() {
      const res = await fetch(`${baseUrl}/api/itemStok?mode=all`);
      const data = await res.json();
      if (data.success) this.items = data.data;
    },

    async fetchProduk(kode) {
      const res = await fetch(`${baseUrl}/api/produk?k=${kode}`);
      const data = await res.json();
      if (data.success) {
        this.form = { ...data.data }
        if (data.data.gambar) this.preview = `${uploadsUrl}/${data.data.gambar}`;
        this.updateSatuan();
      }
      console.log(this.form);
    },

    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.form.gambar = file;
        this.preview = URL.createObjectURL(file);
      }
    },

    updateSatuan() {
      const selected = this.items.find(i => i.id_item == this.form.id_item);
      this.satuan_dasar = selected ? selected.satuan_dasar : '';
    },

    nextPage() {
      if (this.page < 3) this.page++;
    },

    async submitForm() {
      const formData = new FormData();
      for (const key in this.form) {
        formData.append(key, this.form[key]);
      }
      if (this.isEdit) formData.append("_method", "PUT");

      const url = this.isEdit
        ? `${baseUrl}/api/produk?k=${id}`
        : `${baseUrl}/api/produk`;

      const res = await fetch(url, { method: "POST", body: formData });
      const data = await res.json();

      if (data.success) {
        showFlash(this.isEdit ? "Produk berhasil diperbarui!" : "Produk berhasil ditambahkan!");
        setTimeout(() => window.location.href = `${baseUrl}/admin/produk`, 1000);
      } else {
        showFlash("Gagal menyimpan produk: " + data.message, 'error');
      }
    }
  };
}
