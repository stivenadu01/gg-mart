<!-- Global Flash Message -->
<div
  x-data="globalFlash()"
  x-show="visible"
  x-transition.opacity.duration.500ms
  class="fixed top-14 right-1 sm:right-5 px-4 py-3 rounded-lg text-white shadow-lg z-[9999]"
  :class="type === 'success' ? 'bg-green-600/90' : 'bg-red-600/90'">
  <span x-text="message"></span>
  <button @click="visible = false" class="ml-3 font-bold">×</button>
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