function transaksiPage() {
  return {
    produk: [],
    keranjang: [],
    search: '',
    totalHarga: 0,
    metodeBayar: 'tunai',

    async fetchProduk() {
      let res = await fetch(`${baseUrl}/api/produk?mode=trx&search=${encodeURIComponent(this.search)}`);
      res = await res.json();
      if (res.success) this.produk = res.data;
    },

    async tambahProdukDariInput() {
      if (!this.search.trim()) return;

      // cari produk dengan nama persis sama
      const produkDitemukan = this.produk.length === 1 ? this.produk[0] : false;

      if (produkDitemukan) {
        if (produkDitemukan.stok == 0) return;
        this.tambahKeranjang(produkDitemukan);
        this.search = ''; // reset input setelah berhasil
      } else {
        // kalau tidak ada yang cocok, bisa kasih sedikit feedback
        showFlash(`Produk "${this.search}" tidak ditemukan!`, 'error');
      }
    },


    tambahKeranjang(p) {
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
          harga_satuan: Number(p.harga),
          jumlah: 1,
          subtotal: Number(p.harga),
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
      if (this.keranjang.length === 0) {
        showFlash('Keranjang masih kosong!', 'error');
        return;
      }

      let payload = {
        id_user: currentUser.id_user, // nanti diganti sesuai user admin yang login
        total_harga: this.totalHarga,
        metode_bayar: this.metodeBayar,
        detail: this.keranjang.map(i => ({
          kode_produk: i.kode_produk,
          jumlah: i.jumlah,
          harga_satuan: i.harga_satuan,
          subtotal: i.subtotal
        })),
        status: 'selesai'
      };
      console.log('Payload transaksi:', payload);

      let res = await fetch(`${baseUrl}/api/transaksi`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });
      res = await res.json();
      if (await res.success) {
        this.search = '';
        this.fetchProduk()
        this.resetKeranjang();
        showFlash('Transaksi berhasil disimpan!');

        if (cetakStruk) {
          if (window.electronAPI) {
            window.electronAPI.printStruk(res.data.id);
          } else {
            // fallback kalau dibuka di browser biasa
            window.open(`${baseUrl}/admin/transaksi/print?id_transaksi=${res.data.id}`, '_blank');
          }
        }

        document.getElementById('searchProduk').focus();
      } else {
        showFlash('Gagal simpan: ' + res.message, 'error');
      }
    }
  }
}