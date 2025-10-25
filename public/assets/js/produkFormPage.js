function produkFormPage(act, id) {
  return {
    page: 1,
    kategori: [],
    preview: null,
    submitting: false,
    isEdit: act === 'edit',
    formTitle: act === 'edit' ? 'Edit Produk' : 'Tambah Produk',

    form: {
      id_kategori: '',
      nama_produk: '',
      harga_jual: '',
      satuan_dasar: '',
      deskripsi: '',
      gambar: null
    },

    async initPage() {
      await this.fetchKategori();
      if (this.isEdit && id) await this.fetchProduk(id);
    },

    async fetchKategori() {
      const res = await fetch(`${baseUrl}/api/kategori?mode=all`);
      const data = await res.json();
      data.success ? this.kategori = data.data : showFlash(data.message, 'warning');
    },


    async fetchProduk(kode) {
      const res = await fetch(`${baseUrl}/api/produk?k=${kode}`);
      const data = await res.json();
      if (data.success) {
        this.form = { ...data.data }
        if (data.data.gambar) this.preview = `${uploadsUrl}/${data.data.gambar}`;
      } else {
        showFlash(data.message, 'warning');
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
      try {
        if (this.submitting) return;
        this.submitting = true;
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
      } catch (error) {
        console.error(error);
      } finally {
        this.submitting = false;
      }
    }
  };
}
