<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GG MART | <?= $pageTitle ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="<?= ASSETS_PATH ?>/css/app.css" rel="stylesheet">
  <!-- <script src="https://unpkg.com/alpinejs" defer></script> -->
  <script src="<?= ASSETS_PATH ?>/js/cdn.min.js" defer></script>
</head>

<body class="h-screen flex flex-col bg-gray-100"
  x-data="{ sidebarOpen: false, sidebarCollapse: false }">

  <?php

  include COMPONENTS_PATH . '/admin/navbar.php';

  include COMPONENTS_PATH . '/admin/sidebar.php';
  ?>
  <main class="flex-1 overflow-y-auto p-6 lg:ml-64"
    :class="sidebarCollapse ? 'lg:ml-16' : 'lg:ml-64'">