<?php

models('produk');
// Definisikan Response Header
header('Content-Type: application/json');

// Ambil Metode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Ambil Input Data (untuk POST/PUT)
$input_data = [];
if (in_array($method, ['POST', 'PUT'])) {
  // Ambil data dari body permintaan JSON
  $input_data = input_JSON();
}

// Ambil ID Produk dari URL (untuk operasi Read One, PUT, DELETE)
$kode_produk = isset($_GET['k']) ? $_GET['k'] : null;

// Logika Penanganan Berdasarkan Metode HTTP
switch ($method) {
  case 'GET':
    if ($kode_produk) {
      // GET /api/produk?k=123 
      $produk = findProduk($kode_produk);
      if ($produk) {
        respond_json(['success' => true, 'data' => $produk], 200);
      } else {
        respond_json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
      }
    } else {
      // GET /api/produk 
      $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
      $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
      $search = isset($_GET['search']) ? trim($_GET['search']) : '';
      try {
        [$daftar_produk, $total] = getProduk($page, $limit, $search);
        $res = [
          'success' => true,
          'data' => $daftar_produk,
          "pagination" => [
            "total" => intval($total),
            "page" => $page,
            "limit" => $limit,
            "total_pages" => ceil($total / $limit)
          ]
        ];
        respond_json($res, 200);
      } catch (Exception $e) {
        respond_json(["success" => false, "message" => $e->getMessage()], 500);
      }
    }
    break;

  case 'POST':
    // POST /api/produk
    // Periksa data yang diperlukan
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      respond_json(['success' => false, 'message' => 'Nama dan Harga wajib diisi.'], 422); // Unprocessable Entity
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

    respond_json(['success' => true, 'message' => 'Produk berhasil ditambahkan', 'data' => $new_kode_produk], 201); //created
    break;

  case 'PUT':
    // PUT /api/produk?k=123

    if (!$kode_produk) {
      respond_json(['success' => false, 'message' => 'ID Produk wajib diisi untuk operasi update.'], 404);
      break;
    }

    // Periksa data yang diperlukan
    if (empty($input_data['nama_produk']) || empty($input_data['harga'])) {
      respond_json(['success' => false, 'message' => 'Nama dan Harga wajib diisi.'], 422);
      break;
    }


    // Cek apakah ada gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $filename = $kode_produk . '.' . $ext;
      $targetDir = ROOT_PATH . '/public/uploads/';
      if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
      $targetFile = $targetDir . $filename;


      // Ambil produk lama untuk cek gambar lama dan Hapus gambar lama jika ada
      $produk_lama = findProduk($kode_produk);
      if (!empty($produk_lama['gambar']) && file_exists(ROOT_PATH . '/public/' . $produk_lama['gambar'])) {
        unlink(ROOT_PATH . '/public/' . $produk_lama['gambar']);
      }

      // Simpan file baru
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $input_data['gambar'] = $filename;
      }
    }


    $is_edit = editProduk($kode_produk, $input_data);
    if ($is_edit) {
      respond_json(['success' => true, 'message' => 'Produk berhasil diupdate'], 200);
    } else {
      respond_json(['success' => 'Produk gagal diupdate atau tidak ditemukan'], 404);
    }
    break;

  case 'DELETE':
    // DELETE /api/produk?k=123

    if (!$kode_produk) {
      respond_json(['success' => false, 'message' => 'ID Produk wajib diisi untuk operasi delete.'], 400);
      break;
    }
    $is_hapus = hapusProduk($kode_produk);

    if ($is_hapus) {
      respond_json(['success' => true, 'message' => 'Produk berhasil dihapus'], 200);
    } else {
      respond_json(['success' => false, 'message' => 'Produk gagal dihapus atau tidak ditemukan'], 404);
    }
    break;

  default:
    http_response_code(405); // Method Not Allowed
    header('Allow: GET, POST, PUT, DELETE');
    echo json_encode(['success' => false, 'message' => 'Metode ' . $method . ' tidak didukung.']);
    break;
}
