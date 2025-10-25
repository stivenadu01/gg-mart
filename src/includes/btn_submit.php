<button type="submit"
  class="btn btn-primary flex items-center gap-2"
  :disabled="submitting">
  <template x-if="!submitting">
    <span>Simpan</span>
  </template>
  <template x-if="submitting">
    <span class="flex items-center gap-2">
      <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle class="opacity-25" cx="12" cy="12" r="10"></circle>
        <path class="opacity-75" d="M4 12a8 8 0 018-8v4"></path>
      </svg>
      Memproses...
    </span>
  </template>
</button>