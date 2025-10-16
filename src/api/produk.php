<?php

models('Produk');

require_once ROOT_PATH . '/config/api_init.php';


// Ambil kode produk (jika ada)
$kode_produk = isset($_GET['k']) ? $_GET['k'] : null;

$res = [];
$status = 200;
switch ($method) {
  case 'GET':
    // GET /api/produk?mode=all
    if (isset($_GET['mode']) && $_GET['mode'] === 'all') {
      $produk = getAllProduk();
      $res = ['success' => true, 'data' => $produk];
      break;
    }

    // GET /api/produk?k=PRD_3247371
    if ($kode_produk) {
      $produk = findProduk($kode_produk);
      if ($produk) {
        $res = ['success' => true, 'data' => $produk];
      } else {
        $res = ['success' => false, 'message' => 'Produk tidak ditemukan'];
        $status = 404;
      }
      break;
    }

    // GET /api/produk
    $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
    $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $search = trim($_GET['search'] ?? '');

    try {
      [$daftar_produk, $total] = getProdukList($page, $limit, $search);
      $res = [
        'success' => true,
        'data' => $daftar_produk,
        'pagination' => [
          'total' => intval($total),
          'page' => $page,
          'limit' => $limit,
          'total_pages' => ceil($total / $limit)
        ]
      ];
    } catch (Exception $e) {
      $res = ["success" => false, "message" => $e->getMessage()];
      $status = 500;
    }
    break;

  case 'POST':
    api_require_admin();
    // POST /api/produk
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      $res = ['success' => false, 'message' => 'Nama dan Harga wajib diisi.'];
      $status =  422;
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
    $res = ['success' => true, 'message' => 'Produk berhasil ditambahkan', 'data' => $new_kode_produk];
    $status = 201;
    break;

  case 'PUT':
    api_require_admin();
    // PUT api/produk?k=PRD_0238848
    if (!$kode_produk) {
      $res = ['success' => false, 'message' => 'Kode produk wajib diisi untuk update.'];
      $status = 400;
      break;
    }

    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      $res = ['success' => false, 'message' => 'Nama dan Harga wajib diisi.'];
      $status = 422;
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
      $res = ['success' => true, 'message' => 'Produk berhasil diupdate'];
    } else {
      $res = ['success' => false, 'message' => 'Produk gagal diupdate atau tidak ditemukan'];
      $status = 404;
    }
    break;

  case 'DELETE':
    api_require_admin();
    // DELETE /api/produk?k=PRD_28384783
    if (!$kode_produk) {
      $res = ['success' => false, 'message' => 'Kode produk wajib diisi untuk delete.'];
      $status = 400;
      break;
    }

    try {
      $produk_lama = findProduk($kode_produk);
      if ($produk_lama && !empty($produk_lama['gambar'])) {
        $path = ROOT_PATH . '/public/uploads/' . $produk_lama['gambar'];
        if (file_exists($path)) unlink($path);
      }


      $is_hapus = hapusProduk($kode_produk);
      $res = [
        'success' => $is_hapus,
        'message' => $is_hapus ? 'Produk berhasil dihapus' : 'Produk gagal dihapus atau tidak ditemukan'
      ];
      $status = $is_hapus ? 200 : 404;
    } catch (Exception $e) {
      $res = ['success' => false, 'message' => 'Teerjadi kesalahan saat menghapus produk'];
      $status = 500;
    }
    break;

  default:
    $res = ['success' => false, 'message' => 'Metode tidak didukung'];
    $status = 404;
}

respond_json($res, $status);
