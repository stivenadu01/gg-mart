<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= ASSETS_URL . 'favicon.ico' ?>" type="image/x-icon">
  <title>GG MART | <?= $pageTitle ?></title>
  <!-- <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script> -->
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/app.css">
  <script src="<?= ASSETS_URL . '/js/cdn.min.js' ?>" defer></script>
  <link rel="manifest" href="<?= BASE_URL . '/manifest.json' ?>">
</head>

<body class="overflow-y-auto h-[100dvh] flex flex-col bg-gray-100" x-data>

  <?php
  include INCLUDES_PATH . '/user/layout/navbar.php';
  ?>
  <main class="flex-1 overflow-y-auto">