function produkFormPage(act, id) {
  return {
    form: {
      nama_produk: '',
      id_kategori: '',
      harga: '',
      stok: '',
      deskripsi: '',
      gambar: null
    },
    stokTambah: 0,
    stokKurang: 0,
    kategori: [],
    kategoriOpen: false,
    kategoriKeyword: '',
    kategoriFiltered: [],
    kategoriSelected: null,
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

    filterKategori() {
      const keyword = this.kategoriKeyword.toLowerCase();
      this.kategoriFiltered = this.kategori.filter(k =>
        k.nama_kategori.toLowerCase().includes(keyword)
      );
    },

    selectKategori(k) {
      this.kategoriKeyword = k.nama_kategori;
      this.form.id_kategori = k.id_kategori;
      this.kategoriSelected = k;
      this.kategoriOpen = false;
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
        await alert("Pilih kategori yang valid dari daftar!");
        return;
      }

      if (this.isEdit) {
        const hasil = (parseInt(this.form.stok) || 0) +
          (parseInt(this.stokTambah) || 0) -
          (parseInt(this.stokKurang) || 0);
        this.form.stok = Math.max(0, hasil);
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
