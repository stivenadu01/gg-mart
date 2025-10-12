<?php $flashes = get_flash(); ?>


<?php if (!empty($flashes)): ?>
  <div class="fixed top-16 right-3 min-w-sm z-50 space-y-2">
    <?php foreach ($flashes as $key => $flash):
      [$message, $type] = $flash;

      $class = match ($type) {
        'success' => 'bg-green-100 border border-green-400 text-green-700',
        'error' => 'bg-red-100 border border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
        default => 'bg-blue-100 border border-blue-400 text-blue-700',
      };
    ?>
      <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000 + <?= $key ?>*1500)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="<?= $class ?> pl-4 pr-10 py-3 rounded relative min-w-sm"
        role="alert">
        <button type="button" @click="show = false" class="absolute top-2 right-2 text-xl font-bold text-gray-500 hover:text-gray-700 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <span class="font-medium"><?= $message ?></span>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>