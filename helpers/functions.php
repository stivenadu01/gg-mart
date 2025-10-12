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

function isAdmin()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}
