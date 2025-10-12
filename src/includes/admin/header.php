<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= assets_url('favicon.ico') ?>" type="image/x-icon">
  <title>GG MART | <?= $pageTitle ?></title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <!-- <script src="https://unpkg.com/alpinejs" defer></script> -->
  <link rel="stylesheet" href="<?= assets_url('css/app.css') ?>">
  <script src="<?= assets_url('js/cdn.min.js') ?>" defer></script>
</head>

<body class="h-screen flex flex-col bg-gray-100"
  x-data="{ sidebarOpen: false, sidebarCollapse: false }">

  <?php

  include INCLUDES_PATH . '/admin/navbar.php';

  include INCLUDES_PATH . '/admin/sidebar.php';
  ?>
  <main class="flex-1 overflow-y-auto p-6"
    :class="sidebarCollapse ? 'lg:ml-16' : 'lg:ml-64'">