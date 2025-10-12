<?php

models('produk');
header('Content-Type: application/json');

// Tentukan method awal
$method = $_SERVER['REQUEST_METHOD'];

// Override method jika dikirim via POST (_method=PUT/DELETE)
if (isset($_POST['_method'])) {
  $method = strtoupper($_POST['_method']);
}

// Ambil kode produk (jika ada)
$kode_produk = isset($_GET['k']) ? $_GET['k'] : null;

// Ambil input data (dukung JSON & FormData)
$input_data = [];
if (in_array($method, ['POST', 'PUT'])) {
  $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

  if (stripos($contentType, 'application/json') !== false) {
    $input_data = input_JSON();
  } else {
    $input_data = $_POST;
  }
}
unset($input_data['_method']); // jangan ikut disimpan

switch ($method) {
  case 'GET':
    if (isset($_GET['mode']) && $_GET['mode'] === 'all') {
      $produk = getAllProduk();
      respond_json(['success' => true, 'data' => $produk]);
      break;
    }

    if ($kode_produk) {
      $produk = findProduk($kode_produk);
      if ($produk) {
        respond_json(['success' => true, 'data' => $produk]);
      } else {
        respond_json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
      }
      break;
    }

    // daftar produk + pagination
    $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
    $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $search = trim($_GET['search'] ?? '');

    try {
      [$daftar_produk, $total] = getProdukList($page, $limit, $search);
      respond_json([
        'success' => true,
        'data' => $daftar_produk,
        'pagination' => [
          'total' => intval($total),
          'page' => $page,
          'limit' => $limit,
          'total_pages' => ceil($total / $limit)
        ]
      ]);
    } catch (Exception $e) {
      respond_json(["success" => false, "message" => $e->getMessage()], 500);
    }
    break;

  case 'POST':
    // tambah produk
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      respond_json(['success' => false, 'message' => 'Nama dan Harga wajib diisi.'], 422);
      break;
    }

    $timePart = substr(str_replace('.', '', microtime(true)), -8);
    $randomPart = random_int(100, 999);
    $new_kode_produk = 'PRD_' . $timePart . $randomPart;
    $input_data['kode_produk'] = $new_kode_produk;

    // upload file
    if (!empty($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $filename = $new_kode_produk . '.' . $ext;
      $targetDir = ROOT_PATH . '/public/uploads/';
      if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $filename)) {
        $input_data['gambar'] = $filename;
      }
    }

    tambahProduk($input_data);
    respond_json(['success' => true, 'message' => 'Produk berhasil ditambahkan', 'data' => $new_kode_produk], 201);
    break;

  case 'PUT':
    // update produk
    if (!$kode_produk) {
      respond_json(['success' => false, 'message' => 'Kode produk wajib diisi untuk update.'], 400);
      break;
    }

    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      respond_json(['success' => false, 'message' => 'Nama dan Harga wajib diisi.'], 422);
      break;
    }

    // handle upload baru
    if (!empty($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $filename = $kode_produk . '.' . $ext;
      $targetDir = ROOT_PATH . '/public/uploads/';
      if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
      $targetFile = $targetDir . $filename;

      // hapus gambar lama
      $produk_lama = findProduk($kode_produk);
      if (!empty($produk_lama['gambar'])) {
        $oldPath = $targetDir . $produk_lama['gambar'];
        if (file_exists($oldPath)) unlink($oldPath);
      }

      // simpan file baru
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $input_data['gambar'] = $filename;
      }
    }

    $is_edit = editProduk($kode_produk, $input_data);
    if ($is_edit) {
      respond_json(['success' => true, 'message' => 'Produk berhasil diupdate']);
    } else {
      respond_json(['success' => false, 'message' => 'Produk gagal diupdate atau tidak ditemukan'], 404);
    }
    break;

  case 'DELETE':
    if (!$kode_produk) {
      respond_json(['success' => false, 'message' => 'Kode produk wajib diisi untuk delete.'], 400);
      break;
    }

    $produk_lama = findProduk($kode_produk);
    if ($produk_lama && !empty($produk_lama['gambar'])) {
      $path = ROOT_PATH . '/public/uploads/' . $produk_lama['gambar'];
      if (file_exists($path)) unlink($path);
    }

    $is_hapus = hapusProduk($kode_produk);
    respond_json([
      'success' => $is_hapus,
      'message' => $is_hapus ? 'Produk berhasil dihapus' : 'Produk gagal dihapus atau tidak ditemukan'
    ]);
    break;

  default:
    http_response_code(405);
    header('Allow: GET, POST, PUT, DELETE');
    respond_json(['success' => false, 'message' => 'Metode tidak didukung: ' . $method]);
}
