<?php

header('Content-Type: application/json');

// Tentukan method awal
$method = $_SERVER['REQUEST_METHOD'];

// Override method jika dikirim via POST (_method=PUT/DELETE)
if (isset($_POST['_method'])) {
  $method = strtoupper($_POST['_method']);
}

// Ambil input data (JSON & FormData)
$input_data = [];
if (in_array($method, ['POST', 'PUT'])) {
  $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

  if (stripos($contentType, 'application/json') !== false) {
    // data JSON
    $input_data = input_JSON();
  } else {
    // Form Data
    $input_data = $_POST;
  }
}
unset($input_data['_method']); // jangan ikut disimpan _method