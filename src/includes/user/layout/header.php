<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= ASSETS_URL . 'favicon.ico' ?>" type="image/x-icon">
  <title>GG MART | <?= $pageTitle ?></title>
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/app.css">
  <script src="<?= ASSETS_URL . '/js/cdn.min.js' ?>" defer></script>
  <link rel="manifest" href="<?= BASE_URL . '/manifest.json' ?>">
</head>

<body class="min-h-screen flex flex-col bg-gray-100" x-data="mainLayout()" x-init="checkAuthStatus(); loadCartCount()">

  <?php
  include INCLUDES_PATH . '/user/layout/navbar.php';
  // Include Bottom Nav (opsional, bisa juga di footer)
  include INCLUDES_PATH . '/user/layout/bottom_nav.php';
  ?>

  <main class="flex-1 overflow-y-auto p-4 lg:p-6 pb-20 md:pb-4">