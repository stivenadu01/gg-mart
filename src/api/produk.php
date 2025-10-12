<?php
models('produk');
// 1. Definisikan Response Header
header('Content-Type: application/json');

// 2. Ambil Metode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// 3. Ambil Input Data (untuk POST/PUT)
$input_data = [];
if (in_array($method, ['POST', 'PUT'])) {
  // Ambil data dari body permintaan JSON
  $input_json = file_get_contents('php://input');
  $input_data = json_decode($input_json, true);
  if ($input_data === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Input JSON tidak valid']);
    exit;
  }
}

// 4. Ambil ID Produk dari URL (untuk operasi Read One, PUT, DELETE)
$kode_produk = isset($_GET['k']) ? $_GET['k'] : null;

// 5. Logika Penanganan Berdasarkan Metode HTTP
switch ($method) {
  case 'GET':
    if ($kode_produk) {
      // GET /api/produk?k=123 
      $produk = getProdukByKode($kode_produk);
      if ($produk) {
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $produk]);
      } else {
        http_response_code(404);
        echo json_encode(['error' => 'Produk tidak ditemukan']);
      }
    } else {
      // GET /api/produk 
      $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
      $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
      $search = isset($_GET['search']) ? trim($_GET['search']) : '';
      try {
        [$daftar_produk, $total] = getProduk($page, $limit, $search);
        http_response_code(200);
        echo json_encode([
          'status' => 'success',
          'data' => $daftar_produk,
          "pagination" => [
            "total" => intval($total),
            "page" => $page,
            "limit" => $limit,
            "total_pages" => ceil($total / $limit)
          ]
        ]);
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
      }
    }
    break;

  case 'POST':
    // POST /api/produk
    // Periksa data yang diperlukan
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      http_response_code(422); // Unprocessable Entity
      echo json_encode(['error' => 'Nama dan Harga wajib diisi.']);
      break;
    }

    // Ambil microtime, ubah jadi string angka
    $timePart = substr(str_replace('.', '', microtime(true)), -8); // ambil 8 digit terakhir
    $randomPart = random_int(100, 999); // angka acak 3 digit

    $new_kode_produk = 'PRD_' . $timePart . $randomPart;
    $input_data['kode_produk'] = $new_kode_produk;

    // Cek dan simpan file gambar
    $gambarPath = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $filename = $new_kode_produk . '.' . $ext;
      $targetDir = ROOT_PATH . '/public/uploads/';
      if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
      $targetFile = $targetDir . $filename;
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $input_data['gambar'] = $filename;
      }
    }

    tambahProduk($input_data);

    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Produk berhasil ditambahkan', 'kode_produk' => $new_kode_produk]);
    break;

  case 'PUT':
    // PUT /api/produk?k=123

    if (!$kode_produk) {
      http_response_code(400);
      echo json_encode(['error' => 'ID Produk wajib diisi untuk operasi update.']);
      break;
    }

    // Periksa data yang diperlukan
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      http_response_code(422);
      echo json_encode(['error' => 'Nama dan Harga wajib diisi.']);
      break;
    }


    // Cek apakah ada gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $filename = $kode_produk . '.' . $ext;
      $targetDir = ROOT_PATH . '/public/uploads/';
      if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
      $targetFile = $targetDir . $filename;

      // Hapus gambar lama jika ada
      if (!empty($produk_lama['gambar']) && file_exists(ROOT_PATH . '/public/' . $produk_lama['gambar'])) {
        unlink(ROOT_PATH . '/public/' . $produk_lama['gambar']);
      }

      // Simpan file baru
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $gambarPath = 'uploads/' . $filename;
        $input_data['gambar'] = $gambarPath;
      }
    }


    $is_edit = editProduk($kode_produk, $input_data);
    if ($is_edit) {
      http_response_code(200);
      echo json_encode(['status' => 'success', 'message' => 'Produk berhasil diupdate']);
    } else {
      http_response_code(404);
      echo json_encode(['error' => 'Produk gagal diupdate atau tidak ditemukan']);
    }
    break;

  case 'DELETE':
    // DELETE /api/produk?k=123

    if (!$kode_produk) {
      http_response_code(400);
      echo json_encode(['error' => 'ID Produk wajib diisi untuk operasi delete.']);
      break;
    }
    $is_hapus = hapusProduk($kode_produk);

    if ($is_hapus) {
      http_response_code(200);
      echo json_encode(['status' => 'success', 'message' => 'Produk berhasil dihapus']);
    } else {
      http_response_code(404);
      echo json_encode(['error' => 'Produk gagal dihapus atau tidak ditemukan']);
    }
    break;

  default:
    http_response_code(405); // Method Not Allowed
    header('Allow: GET, POST, PUT, DELETE');
    echo json_encode(['error' => 'Metode ' . $method . ' tidak didukung.']);
    break;
}
