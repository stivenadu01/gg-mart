function produkFormPage(act, id) {
  return {
    form: {
      nama_produk: '',
      id_kategori: '',
      harga: '',
      deskripsi: '',
      gambar: null
    },
    kategori: [],
    preview: null,
    isEdit: act === 'edit',
    formTitle: act === 'edit' ? 'Edit Produk' : 'Tambah Produk',

    async initPage() {
      await this.fetchKategori();
      if (this.isEdit && id) await this.fetchProduk(id);
    },

    async fetchKategori() {
      const res = await fetch(`${baseUrl}/api/kategori?mode=all`);
      const data = await res.json();
      if (data.success) this.kategori = data.data;
    },

    async fetchProduk(kode) {
      let res = await fetch(`${baseUrl}/api/produk?k=${kode}`);
      res = await res.json();
      if (res.success) {
        const data = res.data;
        this.form = {
          nama_produk: data.nama_produk,
          id_kategori: data.id_kategori,
          harga: data.harga,
          stok: data.stok,
          deskripsi: data.deskripsi,
          gambar: null
        };
        this.kategoriKeyword = data.nama_kategori; // ← tampilkan nama kategori
        if (data.gambar) this.preview = `${uploadsUrl}/${data.gambar}`;
      }
    },

    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.form.gambar = file;
        this.preview = URL.createObjectURL(file);
      }
    },

    async submitForm() {
      if (!this.form.id_kategori) {
        showFlash("Pilih kategori yang valid dari daftar!");
        return;
      }

      const formData = new FormData();
      for (const key in this.form) {
        if (this.form[key] !== null) formData.append(key, this.form[key]);
      }

      if (this.form.gambar instanceof File) {
        formData.append("gambar", this.form.gambar);
      }

      if (this.isEdit) formData.append("_method", "PUT");

      const url = this.isEdit
        ? `${baseUrl}/api/produk?k=${id}`
        : `${baseUrl}/api/produk`;

      const res = await fetch(url, { method: "POST", body: formData });
      const data = await res.json();

      if (data.success) {
        if (this.isEdit) {
          showFlash("Produk berhasil diupdate!");
          setTimeout(() => window.location.href = `${baseUrl}/admin/produk`, 1000);
        } else {
          showFlash(this.isEdit ? "Produk berhasil diupdate!" : "Produk berhasil ditambahkan!");
          this.form = {};
          this.kategoriKeyword = '';
        }
      } else {
        showFlash("Gagal menyimpan produk: " + data.message, 'error');
      }
    },
  };
}
