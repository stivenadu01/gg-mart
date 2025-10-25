function itemStokFormPage(act, id) {
  return {
    // Data Form
    form: {
      nama_item: '',
      satuan_dasar: '',
      stok: 0
    },

    // Status Halaman
    isEdit: act === 'edit',
    formTitle: act === 'edit' ? 'Edit Item Stok' : 'Tambah Item Stok',

    // Inisialisasi
    async initPage() {
      // Jika mode edit dan id ada, ambil data item stok
      if (this.isEdit && id) await this.fetchItemStok(id);
    },

    // Ambil Data Item Stok untuk Edit
    async fetchItemStok(id_item) {
      // Ganti ini dengan endpoint API yang sebenarnya
      let res = await fetch(`${baseUrl}/api/itemStok?id=${id_item}`);
      res = await res.json();

      if (res.success) {
        const data = res.data;
        this.form = {
          nama_item: data.nama_item,
          satuan_dasar: data.satuan_dasar,
          stok: data.stok // Asumsi API mengembalikan nilai stok saat ini
        };
      } else {
        showFlash("Item Stok tidak ditemukan!", 'error');
        // Arahkan kembali ke daftar item stok jika gagal
        setTimeout(() => window.location.href = `${baseUrl}/admin/stok/item`, 1000);
      }
    },

    // Submit Form
    async submitForm() {
      // Validasi sederhana
      if (!this.form.nama_item || !this.form.satuan_dasar) {
        showFlash("Nama Item dan Satuan wajib diisi!", 'error');
        return;
      }

      // Buat FormData untuk dikirimkan
      const formData = new FormData();
      formData.append('nama_item', this.form.nama_item);
      formData.append('satuan_dasar', this.form.satuan_dasar);

      // Tentukan URL dan method
      let url = `${baseUrl}/api/itemStok`;
      let method = 'POST';

      if (this.isEdit) {
        url = `${baseUrl}/api/itemStok?id=${id}`; // Gunakan ID
        formData.append("_method", "PUT");
      }

      try {
        const res = await fetch(url, { method: method, body: formData });
        const data = await res.json();

        if (data.success) {
          showFlash(`Item Stok berhasil di${this.isEdit ? 'update' : 'tambahkan'}!`);
          if (this.isEdit) {
            setTimeout(() => window.location.href = `${baseUrl}/admin/stok/item`, 1000);
          }
          this.form = { nama_item: '', satuan_dasar: '', stok: 0 };
        } else {
          showFlash("Gagal menyimpan Item Stok: " + data.message, 'error');
        }
      } catch (error) {
        console.error('Error submitting form:', error);
        showFlash("Terjadi kesalahan jaringan/sistem.", 'error');
      }
    },
  };
}