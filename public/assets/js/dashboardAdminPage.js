function dashboardAdminPage() {
  return {
    now: new Date().toLocaleDateString('sv-SE'),
    stats: {
      kategori: 0,
      produk: 0,
      transaksi_hari_ini: 0,
      pendapatan_hari_ini: 0,
      produk_terjual_hari_ini: 0,
      persentase_kenaikan: 0,
      produk_hampir_habis: []
    },
    transaksi: [],
    loading: true,
    chart: null,

    async fetchDashboard() {
      this.loading = true;
      try {
        // API endpoint yang benar
        const res = await fetch(`${baseUrl}/api/dashboard`);
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Gagal memuat data');

        const d = json.data;
        console.log(d)

        // map data ke state
        this.stats.kategori = d.kategori ?? this.stats.kategori;
        this.stats.produk = d.produk ?? this.stats.produk;
        this.stats.transaksi_hari_ini = d.transaksi_hari_ini ?? 0;
        this.stats.pendapatan_hari_ini = d.pendapatan_hari_ini ?? 0;
        this.stats.produk_terjual_hari_ini = d.produk_terjual_hari_ini ?? 0;
        this.stats.persentase_kenaikan = d.persentase_kenaikan ?? 0;
        this.stats.produk_hampir_habis = d.produk_hampir_habis ?? [];
        this.transaksi = d.transaksi_terbaru ?? [];

        // render chart (tampung array penjualan_7_hari)
        this.renderChart(d.penjualan_7_hari ?? []);
      } catch (e) {
        console.error(e);
        // tampilkan notifikasi sederhana
        if (window.showFlash) showFlash('Gagal memuat dashboard: ' + e.message, 'error');
      } finally {
        this.loading = false;
      }
    },

    renderChart(data) {
      const ctx = document.getElementById('chartPenjualan').getContext('2d');
      if (this.chart) this.chart.destroy();

      const labels = (data || []).map(d => {
        const date = new Date(d.tanggal);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
      });

      const values = (data || []).map(d => Number(d.total || 0));

      this.chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [{
            label: 'Pendapatan',
            data: values,
            borderRadius: 6,
            backgroundColor: undefined // biarkan chart.js default warna
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function (value) {
                  // format ringkas di sumbu Y
                  return new Intl.NumberFormat('id-ID').format(value);
                }
              }
            }
          }
        }
      });
    },
  }
}