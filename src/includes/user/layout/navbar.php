<div x-data="navbar()">

  <div class="bg-gray-200 w-full hidden md:flex justify-end text-sm px-10 space-x-5 max-h-6 text-gray-600 ">
    <a :href="baseUrl + '/tentang'" class="hover:scale-100 hover:text-gg-primary">Tentang ggmart</a>
    <a :href="baseUrl + '/kontak'" class="hover:scale-100 hover:text-gg-primary">Hubungi kami</a>
  </div>

  <!-- NAVBAR -->
  <header class="flex items-center justify-between bg-white border-b px-4 py-2 relative z-30">
    <!-- LOGO -->
    <a class="flex items-center space-x-2 p-0 m-0 hover:scale-100" :href="baseUrl">
      <span>
        <img :src="assetsUrl + '/logo.png'" alt="MyApp Logo" class="h-10">
      </span>
      <h1 class="text-3xl font-semibold tracking-tight text-gg-primary hidden md:block">
        ggmart
      </h1>
    </a>

    <!-- SEARCH BAR -->
    <div class="flex-1 max-w-md mx-4 relative" @click.away="showHistory = false">
      <form @submit.prevent="searchProduk" class="relative">
        <input
          type="text"
          x-model="keyword"
          placeholder="Cari produk di ggmart"
          @focus="loadHistory(); showHistory = true"
          @input="filterHistory"
          class="w-full pl-12 pr-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gg-primary/60 text-sm">
        <!-- Ikon kaca pembesar -->
        <button type="submit" class="absolute left-0 text-gray-500 hover:text-gg-primary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
          </svg>
        </button>
      </form>

      <!-- Overlay transparan -->
      <div
        x-show="showHistory"
        @click="showHistory = false"
        class="fixed inset-0"
        x-transition.opacity>
      </div>

      <!-- Dropdown history pencarian -->
      <div
        x-show="showHistory && filteredHistory.length"
        x-transition.origin.top
        class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 overflow-hidden">
        <ul class="max-h-60 overflow-y-auto divide-y divide-gray-100 custom-scrollbar">
          <template x-for="(item, index) in filteredHistory" :key="index">
            <li>
              <button
                type="button"
                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex justify-between items-center hover:scale-95"
                @click="selectHistory(item)">
                <div class="flex items-center gap-2 text-gray-700">
                  <!-- ikon jam kecil -->
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span x-text="item"></span>
                </div>
                <svg
                  @click.stop="removeHistory(index)"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="2"
                  stroke="currentColor"
                  class="w-4 h-4 text-gray-400 hover:text-red-500 transition">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </li>
          </template>
        </ul>

        <div class="border-t bg-gray-50 text-center">
          <button
            @click="clearHistory()"
            class="text-xs text-gray-500 hover:text-red-500 py-2 w-full transition">
            Hapus semua riwayat
          </button>
        </div>
      </div>
    </div>

    <!-- MENU -->
    <div class="flex items-center">
      <div class="hidden md:flex text-sm">
        <!-- Produk -->
        <a :href="`${baseUrl}/produk`" class="justify-start flex items-center text-gray-700 hover:text-gg-primary transition">
          <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
          </svg>
          <span>Produk</span>
        </a>
        <!-- Keranjang -->
        <a :href="`${baseUrl}/keranjang`" class="justify-start flex items-center text-gray-700 hover:text-gg-primary transition">
          <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span>Keranjang</span>
        </a>
        <!-- kelola toko/login -->
        <a :href="isAdmin ? `${baseUrl}/admin/dashboard` : `${baseUrl}/auth/login`"
          class="justify-start flex items-center text-gray-700 hover:text-gg-primary transition">
          <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.29.608 3.284 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>Kelola Toko</span>
        </a>
      </div>

      <!-- Tombol menu (mobile) -->
      <button @click="menuOpen = true" class="md:hidden p-2 rounded hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </div>
  </header>


  <!-- Menu mobile -->
  <div x-show="menuOpen" class="fixed inset-0 z-40 flex">
    <!-- Overlay semi-transparan -->
    <div class="fixed inset-0 bg-black/30" @click="menuOpen = false" x-transition.opacity></div>

    <!-- Sidebar menu -->
    <div class="relative bg-gray-100 w-full h-full shadow-lg overflow-y-auto"
      x-transition:enter="transition transform duration-300"
      x-transition:enter-start="-translate-x-full"
      x-transition:enter-end="translate-x-0"
      x-transition:leave="transition transform duration-300"
      x-transition:leave-start="translate-x-0"
      x-transition:leave-end="-translate-x-full">
      <!-- Header -->
      <div class="flex bg-white justify-between items-center p-2 border border-b">
        <span class="text-gg-primary font-semibold text-xl">Menu Utama</span>
        <button @click="menuOpen = false" class="p-2 rounded hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Menu list mobile -->
      <?php include INCLUDES_PATH . "/user/layout/list_menu_mobile.php" ?>
    </div>
  </div>

</div>

<script>
  const navbar = () => ({
    keyword: '',
    sidebarOpen: false,
    showHistory: false,
    history: [],
    filteredHistory: [],
    menuOpen: false,

    searchProduk() {
      const kw = this.keyword.trim()
      if (!kw) return
      this.history = storageHelper('searchHistory', 'save', kw)
      this.filteredHistory = this.history
      this.showHistory = false
      window.location.href = `${baseUrl}/produk?search=${encodeURIComponent(kw)}`
    },

    loadHistory() {
      this.history = storageHelper('searchHistory', 'load')
      this.filteredHistory = this.history
    },

    filterHistory() {
      const query = this.keyword.toLowerCase().trim()
      if (!query) {
        this.filteredHistory = this.history
        return
      }
      this.filteredHistory = this.history.filter(item =>
        item.toLowerCase().includes(query)
      )
    },

    removeHistory(index) {
      this.history = storageHelper('searchHistory', 'remove', index)
      this.filterHistory()
    },

    clearHistory() {
      this.history = storageHelper('searchHistory', 'clear')
      this.filteredHistory = []
    },

    selectHistory(keyword) {
      this.keyword = keyword
      this.showHistory = false
      this.searchProduk()
    }
  })
</script>