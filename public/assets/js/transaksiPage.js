function transaksiPage() {
  return {
    produk: [],
    keranjang: [],
    search: '',
    totalHarga: 0,
    metodeBayar: 'tunai',
    submitting: false,

    async fetchProduk() {
      if (this.search == '') return;
      const res = await fetch(`${baseUrl}/api/produk?mode=trx&search=${encodeURIComponent(this.search)}`);
      const data = await res.json();
      console.log(data.data);
      if (data.success) this.produk = data.data;
    },

    async tambahProdukDariInput() {
      if (!this.search.trim()) return;

      // cari produk dengan nama persis sama
      const produkDitemukan = this.produk.length === 1 ? this.produk[0] : false;

      if (produkDitemukan) {
        this.tambahKeranjang(produkDitemukan);
        this.search = '';
        this.search.focus();
      } else {
        showFlash(`Produk "${this.search}" tidak ditemukan!`, 'warning');
      }
    },


    tambahKeranjang(p) {
      if (p.stok <= 0) showFlash(`Stok ${p.nama_produk} tidak cukup`, 'warning');
      let idx = this.keranjang.findIndex(i => i.kode_produk === p.kode_produk);
      if (idx >= 0) {
        if (this.keranjang[idx].jumlah < p.stok) {
          this.keranjang[idx].jumlah++;
          this.updateSubtotal(idx);
        }
      } else {
        if (p.stok == 0) return;
        this.keranjang.push({
          kode_produk: p.kode_produk,
          nama_produk: p.nama_produk,
          harga_satuan: Number(p.harga_jual),
          jumlah: 1,
          subtotal: Number(p.harga_jual),
          stok: p.stok // simpan stok di keranjang
        });
      }
      this.hitungTotal();
    },

    updateSubtotal(index) {
      let item = this.keranjang[index];
      if (item.jumlah > Number(item.stok)) {
        item.jumlah = Number(item.stok);
      }
      item.subtotal = Number(item.harga_satuan) * Number(item.jumlah);
      this.hitungTotal();
    },


    hapusKeranjang(index) {
      this.keranjang.splice(index, 1);
      this.hitungTotal();
    },

    hitungTotal() {
      this.totalHarga = this.keranjang.reduce((sum, i) => sum + Number(i.subtotal), 0);
    },

    resetKeranjang() {
      this.keranjang = [];
      this.totalHarga = 0;
    },

    async simpanTransaksi(cetakStruk = true) {
      try {
        this.submitting = true;
        if (this.keranjang.length === 0) {
          showFlash('Keranjang masih kosong!', 'warning');
          return;
        }

        let payload = {
          id_user: currentUser?.id_user ?? 1,
          total_harga: this.totalHarga,
          metode_bayar: this.metodeBayar,
          detail: this.keranjang.map(i => ({
            kode_produk: i.kode_produk,
            jumlah: i.jumlah,
            subtotal: i.subtotal,
            harga_satuan: i.harga_satuan
          })),
          status: 'selesai'
        };
        console.log('Payload transaksi:', payload);
        const res = await fetch(`${baseUrl}/api/transaksi`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (await data.success) {
          this.search = '';
          this.resetKeranjang();
          showFlash('Transaksi berhasil disimpan!');

          if (cetakStruk) {
            if (window.electronAPI) {
              window.electronAPI.printStruk(res.data.kode_transaksi);
            } else {
              // fallback kalau dibuka di browser biasa
              window.open(`${baseUrl}/admin/transaksi/print?kode=${res.data.kode_transaksi}`, '_blank');
            }
          }

          document.getElementById('searchProduk').focus();
        } else {
          showFlash('Gagal simpan: ' + data.message, 'error');
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.submitting = false;
      }
    }
  }
}