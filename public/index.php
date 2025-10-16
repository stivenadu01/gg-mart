<?php
require_once __DIR__ . '/../config/bootstrap.php';

$page = $_GET['page'] ?? 'home';
$page = rtrim($page, '/');

// kalau dimulai dari api --> load src/api
if (str_starts_with($page, 'api')) {
  // Load dari folder src/api
  $apiPath = ROOT_PATH . '/src/' . $page . '.php';
  if (file_exists($apiPath)) {
    include $apiPath;
  } else {
    // Cek apakah ada folder dengan index.php
    $apiPath = ROOT_PATH . '/src/' . $page . '/index.php';
    if (file_exists($apiPath)) {
      include $apiPath;
    } else {
      // Response JSON jika API tidak ditemukan
      respond_json(['success' => false, 'message' => 'API endpoint not found'], 404);
    }
    exit;
  }
}
// kalau tidak dimulai dari api -> load src/pages
else {
  // Load dari folder pages
  $pageFile = ROOT_PATH . '/src/pages/' . $page . '.php';
  if (file_exists($pageFile)) {
    include $pageFile;
  } else {
    // Cek apakah ada folder dengan index.php
    $pageFile = ROOT_PATH . '/src/pages/' . $page . '/index.php';
    if (file_exists($pageFile)) {
      include $pageFile;
    } else {
      // tampilkan halaman 404 kalau tidak ditemukan
      include ROOT_PATH . '/src/pages/404.php';
    }
  }
}




$conn->close();
