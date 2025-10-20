function kelolaStokPage() {
  return {
    stok: [],
    loading: false,

    async fetchStok() {
      this.loading = true;
      try {
        const res = await fetch(`${baseUrl}/api/stok`);
        const data = await res.json();
        if (data.success) {
          this.stok = data.data;
        }
      } catch (err) {
        console.error("Fetch stok error:", err);
      } finally {
        this.loading = false;
      }
    },

    async hapusRiwayat(id, jumlah, kode_produk) {
      if (!confirm("Yakin ingin menghapus riwayat ini?")) return;
      const res = await fetch(`${baseUrl}/api/stok?id=${id}&jumlah=${jumlah}&kode_produk=${kode_produk}`, { method: "DELETE" });
      const data = await res.json();
      if (data.success) {
        this.stok = this.stok.filter(s => s.id_stok != id);
        showFlash("✅ Riwayat stok dihapus");
      } else {
        showFlash("❌ Gagal menghapus riwayat stok", 'error');
      }
    }
  }
}
