function stokFormPage() {
  return {
    form: { kode_produk: "", tipe: "", jumlah: "", keterangan: "" },
    produk: [],

    async fetchProduk() {
      const res = await fetch(`${baseUrl}/api/produk?mode=all`);
      const data = await res.json();
      if (data.success) this.produk = data.data;
    },

    async submitForm() {
      const fd = new FormData();
      Object.entries(this.form).forEach(([k, v]) => fd.append(k, v));

      const res = await fetch(`${baseUrl}/api/stok`, {
        method: "POST",
        body: fd
      });
      const data = await res.json();

      if (data.success) {
        showFlash("✅ Stok berhasil diperbarui!");
        window.location.href = `${baseUrl}/admin/stok`;
      } else {
        showFlash("❌ Gagal memperbarui stok: " + (data.message || ""), 'error');
      }
    }
  }
}
