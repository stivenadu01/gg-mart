<!-- SIDEBAR DESKTOP -->
<aside
  :class="sidebarCollapse ? 'w-16' : 'w-64'"
  class="w-16 hidden lg:flex flex-col bg-white border-r shadow-md transition-all duration-300 fixed inset-y-0 left-0 z-30">

  <!-- Header Sidebar -->
  <div class="flex items-center justify-between px-4 py-2 border-b">
    <span x-show="!sidebarCollapse" class="font-bold text-xl">
      <img src="<?= ASSETS_PATH ?>/logo.png" alt="" class="h-10">
    </span>
    <div class="relative group">
      <button x-show="!sidebarCollapse" @click="sidebarCollapse = !sidebarCollapse" class="p-2 rounded hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
      </button>
      <span class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 rounded bg-gray-800 text-white text-xs opacity-0 transition-opacity pointer-events-none whitespace-nowrap z-10 group-hover:opacity-100">
        Tutup Sidebar
      </span>
    </div>
    <div class="relative group" x-show="sidebarCollapse">
      <button @click="sidebarCollapse = !sidebarCollapse" class="p-2 rounded hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
      </button>
      <span class="absolute left-full top-1/2 -translate-y-1/2 ml-2 px-2 py-1 rounded bg-gray-800 text-white text-xs opacity-0 transition-opacity pointer-events-none whitespace-nowrap z-10 group-hover:opacity-100">
        Buka Sidebar
      </span>
    </div>

  </div>

  <!-- Menu -->
  <nav class="flex-1 p-2 space-y-2">
    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-200">
      <!-- Heroicons - Cube -->
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z" />
      </svg>

      <span x-show="!sidebarCollapse" class="ml-3">Dashboard</span>
    </a>
    <a href="#" class="flex items-center p-2 rounded hover:bg-gray-200">
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M21 16.5v-9a.75.75 0 00-.375-.649l-8.25-4.5a.75.75 0 00-.75 0l-8.25 4.5A.75.75 0 003 7.5v9a.75.75 0 00.375.649l8.25 4.5a.75.75 0 00.75 0l8.25-4.5A.75.75 0 0021 16.5z" />
      </svg>

      <span x-show="!sidebarCollapse" class="ml-3">Kelola Produk</span>
    </a>
  </nav>
</aside>

<!-- SIDEBAR MOBILE OVERLAY -->
<div
  x-show="sidebarOpen"
  class="fixed inset-0 flex z-50 lg:hidden"
  x-transition>

  <!-- Overlay -->
  <div @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50"></div>

  <!-- Drawer -->
  <aside class="relative w-64 bg-white shadow-md flex flex-col z-50">
    <div class="flex items-center justify-between p-4 border-b">
      <span><img src="<?= ASSETS_PATH ?>/logo.png" alt="" class="h-10"></span>
      <button @click="sidebarOpen = false" class="p-2 rounded hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <nav class="flex-1 p-2 space-y-2">
      <a href="#" class="block p-2 rounded hover:bg-gray-200">Dashboard</a>
      <a href="#" class="block p-2 rounded hover:bg-gray-200">Kelola Produk</a>
    </nav>
  </aside>
</div>