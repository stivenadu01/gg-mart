<?php

function uploads_url($file)
{
  return BASE_URL . '/uploads/' . $file;
}

function assets_url($file)
{
  return BASE_URL . '/assets/' . $file;
}

function set_flash($message, $type = '')
{
  $_SESSION['flash'][] = [$message, $type];
}

function get_flash()
{
  if (isset($_SESSION['flash'])) {
    $flashes = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flashes;
  }
  return [];
}

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

function redirect($path)
{
  header("Location: " . url($path));
  exit;
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
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
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
