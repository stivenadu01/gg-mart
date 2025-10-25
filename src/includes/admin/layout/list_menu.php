<nav class="flex-1 p-2 space-y-2">

  <a :href="baseUrl + '/admin/dashboard'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/dashboard') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Dashboard">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Dashboard</span>
  </a>

  <a :href="baseUrl + '/admin/kategori'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/kategori') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Kelola Kategori">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Kelola Kategori</span>
  </a>

  <a :href="baseUrl + '/admin/produk'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/produk') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Kelola Produk">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Kelola Produk</span>
  </a>

  <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">

    <a class="btn btn-primary shadow-none gap-2 justify-start cursor-pointer"
      :class="location.pathname.includes('/admin/stok') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'"
      title="Kelola Stok"
      @click="open = !open">

      <span>
        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
        </svg>
      </span>
      <span x-show="!sidebarCollapse">Kelola Stok</span>

      <svg class="w-4 h-4 ml-auto transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!sidebarCollapse">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </a>

    <div x-show="open"
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="transform opacity-0 scale-95"
      x-transition:enter-end="transform opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="transform opacity-100 scale-100"
      x-transition:leave-end="transform opacity-0 scale-95"
      class="absolute z-10 w-48 mt-2 origin-top-left rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none right-0 md:left-full md:top-0 top-full ml-2"
      role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
      <div class="py-1" role="none">
        <a :href="baseUrl + '/admin/stok'" class="block px-4 py-2 text-sm hover:bg-gray-200">Kelola Stok </a>
        <a :href="baseUrl + '/admin/stok/item'" class="block px-4 py-2 text-sm hover:bg-gray-200">Kelola Item Stok</a>
      </div>
    </div>
  </div>

  <a :href="baseUrl + '/admin/transaksi/input'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/transaksi/input') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Input Transaksi">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Input Transaksi</span>
  </a>

  <a :href="baseUrl + '/admin/transaksi/riwayat'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/transaksi/riwayat') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Riwayat Transaksi">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6 4h6m-7-18H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-2.5m-1.5-2V2" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Riwayat Transaksi</span>
  </a>

  <a :href="baseUrl + '/admin/laporan'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname == '/admin/laporan' ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Laporan">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m0 6v-2m0 2v-2m0 2h6m0-6h6m-6 0v2m0 0v2m0-4h-6M18 10V6M6 14v4M18 18h2a2 2 0 002-2V4a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2h2m0 0v-4m0 4h16m-8-2v2" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Laporan</span>
  </a>

  <a :href="baseUrl + '/admin/pengaturan'" class="btn btn-primary shadow-none gap-2 justify-start" :class="location.pathname.includes('/admin/pengaturan') ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" title="Pengaturan">
    <span>
      <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.29.608 3.284 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </span>
    <span x-show="!sidebarCollapse">Pengaturan</span>
  </a>

</nav>