<!-- Global Flash Message -->
<div
  x-data="globalFlash()"
  x-show="visible"
  x-transition.opacity.duration.500ms
  class="fixed top-16 right-1 sm:right-5 max-w-sm w-full">
  <div class="flex justify-between gap-2 p-4 rounded-lg text-white shadow-lg z-[9999]" :class="type === 'success' ? 'bg-green-600/90' : type === 'warning' ? 'bg-yellow-600/90' : 'bg-red-600/90'">
    <span x-text="message"></span>
    <button @click="visible = false">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M6 18L18 6M6 6l12 12" /></button>
  </div>
</div>

<script>
  function globalFlash() {
    return {
      visible: false,
      message: '',
      type: 'success',

      show(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.visible = true;
        setTimeout(() => (this.visible = false), 2500);
      },

      init() {
        // Dengarkan event flash global
        document.addEventListener('show-flash', e => {
          const {
            message,
            type
          } = e.detail;
          this.show(message, type);
        });
      }
    }
  }

  // Helper global (supaya bisa dipanggil dari mana saja)
  window.showFlash = (message, type = 'success') => {
    document.dispatchEvent(
      new CustomEvent('show-flash', {
        detail: {
          message,
          type
        }
      })
    );
  };
</script>