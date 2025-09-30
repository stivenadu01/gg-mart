<!-- NAVBAR -->
<header class="flex items-center justify-between bg-white border-b px-4 py-2 shadow-md relative z-10 lg:ml-64"
  :class="sidebarCollapse ? 'lg:ml-16' : 'lg:ml-64'">
  <div class="flex items-center space-x-2">
    <!-- Tombol menu (mobile) -->
    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded hover:bg-gray-100">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <span :class="{'block': sidebarCollapse, 'hidden': !sidebarCollapse}"><img src="<?= ASSETS_PATH ?>/logo.png" alt="MyApp Logo" class="h-10"></span>
    <span><img src="<?= ASSETS_PATH ?>/logo.png" alt="MyApp Logo" class="h-10 lg:hidden"></span>
  </div>

  <div class="flex items-center space-x-4">
    <button class="p-2 rounded hover:bg-gray-100">🔔</button>
    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
  </div>
</header>