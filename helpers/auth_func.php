<?php

function is_super_admin()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'super_admin' ? true : false;
}
function is_kasir()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'kasir' ? true : false;
}
function is_manager()
{
  return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'manager' ? true : false;
}

function api_require_kasir()
{
  if (!is_super_admin() && !is_kasir()) {
    respond_json(['success' => false, 'message' => 'Akses ditolak'], 403);
    exit;
  }
}

function page_require_kasir()
{
  if (!is_super_admin() && !is_kasir()) {
    redirect_back('/auth/login');
  }
}

function api_require_manager()
{
  if (!is_super_admin() && !is_manager()) {
    respond_json(['success' => false, 'message' => 'Akses ditolak'], 403);
    exit;
  }
}

function page_require_manager()
{
  if (!is_super_admin() && !is_manager()) {
    redirect_back('/auth/login');
  }
}
