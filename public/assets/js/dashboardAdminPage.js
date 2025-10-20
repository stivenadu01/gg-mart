function dashboardAdminPage() {
  return {
    now: new Date().toLocaleDateString('sv-SE'),
    stats: {
      kategori: 0,
      produk: 0,
      transaksiHariIni: 0,
      pendapatanHariIni: 0,
      produkTerjualHariIni: 0,
      produkHampirHabis: [],
      kenaikanTransaksi: 0,
      kenaikanPendapatan: 0,
      kenaikanProdukTerjual: 0,
      transaksiTerbaru: [],
    },
    loading: true,
    chart: null,

    async fetchDashboard() {
      try {
        let res = await fetch(`${baseUrl}/api/dashboard`);
        res = await res.json();
        if (res.success) {
          this.stats = res.data;
          this.renderChart(res.data.chart);
        }
      } catch (err) {
        console.error("Gagal memuat dashboard:", err);
      } finally {
        this.loading = false;
      }
    },

    renderChart(grafik) {
      const ctx = document.getElementById("chartPenjualan").getContext("2d");

      // Hancurkan chart lama jika ada
      if (this.chart) this.chart.destroy();

      // Cek apakah sedang di mobile (layar < 640px)
      const isMobile = window.innerWidth < 640;

      this.chart = new Chart(ctx, {
        type: "bar",
        data: {
          // Format tanggal jadi "13 Okt", "14 Okt", dst
          labels: grafik.map(g => {
            const d = new Date(g.tanggal);
            return d.toLocaleDateString("id-ID", { day: "numeric", month: "short" });
          }),
          datasets: [{
            label: "Pendapatan Harian (Rp)",
            data: grafik.map(g => g.total),
            backgroundColor: "rgba(22, 163, 74, 0.7)",
            borderColor: "#16a34a",
            borderWidth: 1.5,
            borderRadius: 6,
            hoverBackgroundColor: "rgba(22, 163, 74, 0.9)",
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          layout: { padding: 0 },
          scales: {
            x: {
              display: true,
              grid: {
                display: true, // tetap tampilkan grid di semua lebar layar
                color: "#eee",
              },
              ticks: {
                color: "#555",
                font: { size: 12 },
              },
            },
            y: {
              display: !isMobile, // sembunyikan label kiri kalau di mobile
              grid: {
                display: true,
                color: "#eee",
              },
              ticks: {
                color: "#555",
                font: { size: 12 },
                callback: (value) => "Rp " + value.toLocaleString("id-ID"), // selalu awali Rp
              },
            },
          },
          plugins: {
            legend: { display: false },
            tooltip: {
              enabled: true,
              mode: "nearest",
              intersect: true,
              callbacks: {
                title: ctx => `Tanggal: ${ctx[0].label}`,
                label: ctx => `Pendapatan: Rp ${ctx.raw.toLocaleString("id-ID")}`,
              },
            },
          },
          interaction: {
            mode: "nearest",
            intersect: true,
          },
          animation: {
            duration: 600,
            easing: "easeOutQuart", // animasi halus naik dari bawah
          },
        },
      });
    }
    ,


    badgeClass(persentase) {
      if (persentase > 0) return 'bg-green-100 text-green-700';
      if (persentase < 0) return 'bg-red-100 text-red-700';
      return 'bg-gray-100 text-gray-600';
    },

    formatBadge(persentase) {
      if (persentase > 0) return '+' + persentase + '%';
      if (persentase < 0) return persentase + '%';
      return '0%';
    }
  }
}
