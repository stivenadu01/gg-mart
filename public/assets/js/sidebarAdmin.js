function sidebarAdmin() {
  return {
    listMenuAdmin: [
      {
        url: '/admin/dashboard',
        title: 'Dashboard',
        ikon: `
      <svg class=" w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
      </svg>
      `
      },
      {
        url: '/admin/produk',
        title: 'Kelola Produk',
        ikon: `
      <svg class=" w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M21 16.5v-9a.75.75 0 00-.375-.649l-8.25-4.5a.75.75 0 00-.75 0l-8.25 4.5A.75.75 0 003 7.5v9a.75.75 0 00.375.649l8.25 4.5a.75.75 0 00.75 0l8.25-4.5A.75.75 0 0021 16.5z" />
      </svg>
      `
      },
      {
        url: '/admin/kategori',
        title: 'Kelola Kategori',
        ikon: `
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
      </svg>
      `
      },
      {
        url: '/admin/transaksi/input',
        title: 'Input Transaksi',
        ikon: `
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h12m-9 6h6" />
      </svg>
      `
      },
      {
        url: '/admin/transaksi/riwayat',
        title: 'Riwayat Transaksi',
        ikon: `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M4 19h16v2H4v-2z" />
      </svg>
      `
      },
      {
        url: '/admin/laporan',
        title: 'Laporan',
        ikon: `
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M9 17H4v-4h5v4zM9 7V3h13v4M9 7H4v2h5V7z" />
      </svg>
      `
      }
    ],
  }
}

