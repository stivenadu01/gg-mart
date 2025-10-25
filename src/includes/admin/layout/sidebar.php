<div x-show="!fullscreen" x-transition.opacity>
  <aside
    :class="sidebarCollapse ? 'w-16' : 'w-64'"
    class="w-16 hidden lg:flex flex-col bg-white border-r shadow-md transition-all duration-300 fixed inset-y-0 left-0 z-10">

    <!-- Header Sidebar -->
    <div class="flex items-center justify-between px-4 py-2 border-b">
      <span x-show="!sidebarCollapse" class="font-bold text-xl text-gg-primary">
        Menu
      </span>
      <button x-show="!sidebarCollapse" @click="toggleSidebar" class="p-2 rounded hover:bg-gray-100" title="Tutup Sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
        </svg>
      </button>
      <button @click="toggleSidebar" class="p-2 rounded hover:bg-gray-100" x-show="sidebarCollapse" title="Buka Sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    <!-- Menu -->
    <?php include INCLUDES_PATH . "/admin/layout/list_menu.php" ?>
    </nav>
  </aside>


  <!-- MOBILE SIDEBAR OVERLAY -->
  <div
    x-show="sidebarOpen"
    class="fixed inset-0 flex z-30 lg:hidden"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 -translate-x-full">

    <div @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50"></div>

    <aside class="relative w-64 bg-white shadow-md flex flex-col z-50">
      <div class="flex items-center justify-between p-4 border-b">
        <span><img :src="assetsUrl  + '/logo.png'" alt="" class="h-10 inline-block"></span>
        <span class="text-gg-primary font-bold">Menu</span>
        <button @click="sidebarOpen = false" class="p-2 rounded hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
          </svg>
        </button>
      </div>

      <!-- MENU -->
      <?php include INCLUDES_PATH . "/admin/layout/list_menu.php" ?>
    </aside>
  </div>
</div>