<div class="bg-white rounded-md py-3">
  <!-- Home -->
  <a :href="`${baseUrl}/`"
    class="flex justify-start items-center gap-2 text-gray-700 hover:text-gg-primary transition duration-200">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h6m8-11v10a1 1 0 01-1 1h-6" />
    </svg>
    <span>Home</span>
  </a>

  <!-- Produk -->
  <a :href="`${baseUrl}/produk`"
    class="flex justify-start items-center gap-2 text-gray-700 hover:text-gg-primary transition duration-200">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>
    <span>Produk</span>
  </a>

  <!-- Keranjang -->
  <a :href="`${baseUrl}/keranjang`"
    class="flex items-center gap-2 justify-start text-gray-700 hover:text-gg-primary transition duration-200">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span>Keranjang</span>
  </a>

  <!-- Tentang ggmart -->
  <a :href="`${baseUrl}/tentang`"
    class="flex items-center gap-2 justify-start text-gray-700 hover:text-gg-primary transition duration-200 md:hidden">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
    </svg>
    <span>Tentang ggmart</span>
  </a>

  <!-- Hubungi Kami -->
  <a :href="`${baseUrl}/kontak`"
    class="flex items-center gap-2 justify-start text-gray-700 hover:text-gg-primary transition duration-200 md:hidden">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-9 13a9 9 0 100-18 9 9 0 000 18z" />
    </svg>
    <span>Hubungi kami</span>
  </a>

  <!-- kelola toko -->
  <a :href="isAdmin ? `${baseUrl}/admin/dashboard` : `${baseUrl}/auth/login`"
    class="flex items-center gap-2 justify-start text-gray-700 hover:text-gg-primary transition duration-200">
    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.29.608 3.284 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    <span>Kelola Toko</span>
  </a>
</div>