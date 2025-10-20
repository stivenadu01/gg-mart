<!-- Bottom Navigation (Mobile) -->
<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 shadow-lg flex justify-around z-20">
  <!-- Home -->
  <a :class="location.pathname == '/home' ? 'text-gg-primary' : 'text-neutral-900'" :href="baseUrl + '/'" class="flex flex-col items-center active:text-gg-primary">
    <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h6m8-11v10a1 1 0 01-1 1h-6" />
    </svg>
    <span class="text-xs mt-0.5">Home</span>
  </a>

  <!-- Produk -->
  <a :class="location.pathname == '/produk' ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" :href="baseUrl + '/produk'" class="flex flex-col items-center text-gray-700 hover:text-gg-primary">
    <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>
    <span class="text-xs mt-0.5">Produk</span>
  </a>

  <!-- Keranjang -->
  <a :class="location.pathname == '/keranjang' ? 'bg-gg-primary/90 text-white' : 'bg-transparent text-neutral-900'" :href="baseUrl + '/keranjang'" class="flex flex-col items-center text-gray-700 hover:text-gg-primary relative">
    <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span class="text-xs mt-0.5">Keranjang</span>
  </a>
</nav>