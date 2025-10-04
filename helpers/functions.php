<?php

function set_flash($title, $type = 'info', $message = null)
{
  $_SESSION['flash_message'][] = [$title, $message, $type];
}

function display_flash()
{
  if (isset($_SESSION['flash_message'])) :
?>
    <div class="fixed top-10 right-3 max-w-sm z-50 p-3 space-y-2">
      <?php
      foreach ($_SESSION['flash_message'] as $key => $flash_message) :
        [$title, $message, $type] = $flash_message;
        $flash_id = 'flash-message-' . $key;
        if ($type === 'success') {
          $class = 'bg-green-100 border border-green-400 text-green-700';
        } elseif ($type === 'error') {
          $class = 'bg-red-100 border border-red-400 text-red-700';
        } elseif ($type === 'warning') {
          $class = 'bg-yellow-100 border border-yellow-400 text-yellow-700';
        } else {
          $class = 'bg-blue-100 border border-blue-400 text-blue-700';
        }
      ?>
        <div class='<?= $class ?> pl-4 pr-10 py-3 rounded relative' role='alert' id='<?= $flash_id ?>'>
          <button type="button" class="absolute top-2 right-2 text-xl font-bold text-gray-500 hover:text-gray-700 focus:outline-none" onclick="document.getElementById('<?= $flash_id ?>').style.display='none'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
          <span class='block sm:inline font-bold'><?= $title ?></span>
          <span class='block sm:inline'><?= $message ?></span>
        </div>
      <?php
      endforeach;
      ?>
    </div>
    <script>
      const flashMessages = document.querySelectorAll('[id^="flash-message-"]');
      let delay = 4000;

      flashMessages.forEach(flashMessage => {
        setTimeout(() => {
          flashMessage.classList.add('opacity-0', 'transition-opacity', 'duration-500');
          setTimeout(() => {
            flashMessage.style.display = 'none';
          }, 500);
        }, delay);
        delay += 1500;
      });
    </script>
<?php
    unset($_SESSION['flash_message']);
  endif;
}

function url($path = '')
{
  $base_url = rtrim(BASE_URL, '/');
  $path = ltrim($path, '/');
  return $base_url . '/' . $path;
}

function models($model)
{
  require_once ROOT_PATH . 'models/' . $model . '.php';
}

function redirect($path)
{
  header("Location: " . url($path));
  exit;
}

function isAdmin()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}
