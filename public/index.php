<?php
require_once __DIR__ . '/../config/bootstrap.php';

$page = $_GET['page'] ?? 'home';
$page = rtrim($page, '/');
$pageFile = ROOT_PATH . '/src/pages/' . $page . '.php';

if (file_exists($pageFile)) {
  // Jika ada file langsung
  include $pageFile;
} else {
  // Cek apakah ada folder dengan index.php
  $pageFile = ROOT_PATH . '/src/pages/' . $page . '/index.php';
  if (file_exists($pageFile)) {
    include $pageFile;
  } else {
    // Jika tidak ada, tampilkan 404
    include ROOT_PATH . '/src/pages/404.php';
  }
}
