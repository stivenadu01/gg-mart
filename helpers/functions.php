<?php

function url($path = '')
{
  $base_url = rtrim(BASE_URL, '/');
  $path = ltrim($path, '/');
  return $base_url . '/' . $path;
}

function models($model)
{
  require_once ROOT_PATH . '/models/' . $model . '.php';
}

function redirect_back($fallback = '')
{
  $referer = $_SERVER['HTTP_REFERER'] ?? null;
  if ($referer) {
    header("Location: " . $referer);
  } else {
    header("Location: " . url($fallback));
  }
  exit;
}

function is_admin()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin' ? true : false;
}

function api_require_admin()
{
  if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    respond_json(['success' => false, 'message' => 'Akses ditolak'], 403);
    exit;
  }
}
function page_require_admin()
{
  if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    redirect_back('auth/login');
  }
}



function respond_json($data, $status = 200)
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

function input_JSON()
{
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);
  if ($data === null) respond_json(['status' => 'error', 'message' => 'Invalid JSON'], 400);
  return $data;
}
