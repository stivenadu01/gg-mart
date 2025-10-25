<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 shadow-xl flex justify-around py-2 z-20">
  <a :class="location.pathname == '/' ? 'text-gg-primary font-semibold' : 'text-neutral-500'" :href="baseUrl + '/'"
    class="flex flex-col items-center p-2 rounded-lg transition hover:text-gg-primary">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h6m8-11v10a1 1 0 01-1 1h-6" />
    </svg>
    <span class="text-xs mt-0.5">Home</span>
  </a>

  <a :class="location.pathname == '/produk' ? 'text-gg-primary font-semibold' : 'text-neutral-500'" :href="baseUrl + '/produk'"
    class="flex flex-col items-center p-2 rounded-lg transition hover:text-gg-primary">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>
    <span class="text-xs mt-0.5">Produk</span>
  </a>

  <a :class="location.pathname == '/keranjang' ? 'text-gg-primary font-semibold' : 'text-neutral-500'" :href="baseUrl + '/keranjang'"
    class="flex flex-col items-center p-2 rounded-lg transition hover:text-gg-primary relative">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span class="absolute top-0 right-0 text-[10px] bg-red-500 text-white rounded-full h-4 w-4 flex items-center justify-center" x-show="cartCount > 0" x-text="cartCount"></span>
    <span class="text-xs mt-0.5">Keranjang</span>
  </a>
</nav>