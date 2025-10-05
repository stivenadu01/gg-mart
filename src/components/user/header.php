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

<body>
  <?php
  // desktop
  include COMPONENTS_PATH . "/user/header_desktop.php";
  // mobile
  include COMPONENTS_PATH . "/user/header_mobile.php";
  ?>