<!-- NAVBAR -->
<header class="flex items-center justify-between bg-white border-b px-4 py-2 shadow-md relative z-10"
  :class="sidebarCollapse ? 'lg:ml-16' : 'lg:ml-64'">
  <div class="flex items-center space-x-2">
    <!-- Tombol menu (mobile) -->
    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded hover:bg-gray-100">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
      </svg>
    </button>
    <span :class="sidebarCollapse ? 'block' : 'hidden'"><img src="<?= assets_url('logo.png') ?>" alt="MyApp Logo" class="h-10"></span>
    <span><img src="<?= assets_url('logo.png') ?>" alt="MyApp Logo" class="h-10 lg:hidden"></span>
  </div>

  <div class="flex items-center space-x-4">
    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
  </div>
</header>