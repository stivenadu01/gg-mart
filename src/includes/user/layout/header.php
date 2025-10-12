<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GG MART | <?= $pageTitle ?></title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="<?= assets_url('css/app.css') ?>">
  <!-- <script src="https://unpkg.com/alpinejs" defer></script> -->
  <script src="<?= assets_url('js/cdn.min.js') ?>" defer></script>
</head>

<body>
  <?php
  // desktop
  include INCLUDES_PATH . 'user/layout/header_desktop.php';
  // mobile
  include INCLUDES_PATH . 'user/layout/header_mobile.php';
  ?>