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



require_once ROOT_PATH . '/helpers/auth_func.php';
require_once ROOT_PATH . '/helpers/api_func.php';
