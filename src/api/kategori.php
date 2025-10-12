<?php

models('kategori');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// Ambil Input Data (untuk POST/PUT)
$input_data = [];
if (in_array($method, ['POST', 'PUT'])) {
  $input_data = input_JSON();
}

// Ambil ID kategori (untuk Read One, PUT, DELETE)
$id_kategori = isset($_GET['id']) ? intval($_GET['id']) : null;

// Logika Penanganan Berdasarkan Metode HTTP
switch ($method) {
  case 'GET':
    if (isset($_GET['mode']) && $_GET['mode'] === 'all') {
      // GET /api/kategori?mode=all
      $kategori = getAllKategori();
      respond_json(['success' => true, 'data' => $kategori], 200);
      break;
    } else if ($id_kategori) {
      // GET /api/kategori?id=1
      $kategori = findKategori($id_kategori);
      if ($kategori) {
        respond_json(['success' => true, 'data' => $kategori], 200);
      } else {
        respond_json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
      }
    } else {
      // GET /api/kategori
      $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
      $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
      $search = isset($_GET['search']) ? trim($_GET['search']) : '';
      try {
        [$daftar_kategori, $total] = getKategoriList($page, $limit, $search);
        $res = [
          'success' => true,
          'data' => $daftar_kategori,
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
    // POST /api/kategori
    if (empty($input_data['nama_kategori'])) {
      respond_json(['success' => false, 'message' => 'Nama kategori wajib diisi.'], 422);
      break;
    }

    $is_tambah = tambahKategori($input_data);

    if ($is_tambah) {
      respond_json(['success' => true, 'message' => 'Kategori berhasil ditambahkan'], 201);
    } else {
      respond_json(['success' => false, 'message' => 'Gagal menambahkan kategori'], 500);
    }
    break;

  case 'PUT':
    // PUT /api/kategori?id=1
    if (!$id_kategori) {
      respond_json(['success' => false, 'message' => 'ID kategori wajib diisi untuk update.'], 400);
      break;
    }

    if (empty($input_data['nama_kategori'])) {
      respond_json(['success' => false, 'message' => 'Nama kategori wajib diisi.'], 422);
      break;
    }

    $is_edit = editKategori($id_kategori, $input_data);

    if ($is_edit) {
      respond_json(['success' => true, 'message' => 'Kategori berhasil diupdate'], 200);
    } else {
      respond_json(['success' => false, 'message' => 'Kategori gagal diupdate atau tidak ditemukan'], 404);
    }
    break;

  case 'DELETE':
    // DELETE /api/kategori?id=1
    if (!$id_kategori) {
      respond_json(['success' => false, 'message' => 'ID kategori wajib diisi untuk delete.'], 400);
      break;
    }

    $is_hapus = hapusKategori($id_kategori);

    if ($is_hapus) {
      respond_json(['success' => true, 'message' => 'Kategori berhasil dihapus'], 200);
    } else {
      respond_json(['success' => false, 'message' => 'Kategori gagal dihapus atau tidak ditemukan'], 404);
    }
    break;

  default:
    http_response_code(405);
    header('Allow: GET, POST, PUT, DELETE');
    echo json_encode(['success' => false, 'message' => 'Metode ' . $method . ' tidak didukung.']);
    break;
}
