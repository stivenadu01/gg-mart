<?php

models('Kategori');
require_once ROOT_PATH . '/config/api_init.php';

// Ambil ID kategori (untuk Read One, PUT, DELETE)
$id_kategori = isset($_GET['id']) ? intval($_GET['id']) : null;

// Logika Penanganan Berdasarkan Metode HTTP
$res = [];
$status = 200;
switch ($method) {
  case 'GET':
    // GET /api/kategori?mode=all
    if (isset($_GET['mode']) && $_GET['mode'] === 'all') {
      $kategori = getAllKategori();
      $res = ['success' => true, 'data' => $kategori];
      break;
    }
    // GET /api/kategori?id=1
    if ($id_kategori) {
      $kategori = findKategori($id_kategori);
      if ($kategori) {
        $res = ['success' => true, 'data' => $kategori];
      } else {
        $res = ['success' => false, 'message' => 'Kategori tidak ditemukan'];
        $status = 404;
      }
      break;
    }

    // GET /api/kategori
    $page   = isset($_GET['halaman']) ? max(1, intval($_GET['halaman'])) : 1;
    $limit  = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    try {
      [$kategori, $total] = getKategoriList($page, $limit, $search);
      $res = [
        'success' => true,
        'data' => $kategori,
        "pagination" => [
          "total" => intval($total),
          "page" => $page,
          "limit" => $limit,
          "total_pages" => ceil($total / $limit)
        ]
      ];
    } catch (Exception $e) {
      $res = ["success" => false, "message" => $e->getMessage()];
      $status = 500;
    }
    break;

  case 'POST':
    api_require_admin();
    // POST /api/kategori
    if (empty($input_data['nama_kategori'])) {
      $res = ['success' => false, 'message' => 'Nama kategori wajib diisi.'];
      $status = 422;
      break;
    }

    $is_tambah = tambahKategori($input_data);

    if ($is_tambah) {
      $res = ['success' => true, 'message' => 'Kategori berhasil ditambahkan'];
      $status = 201;
    } else {
      $res = ['success' => false, 'message' => 'Gagal menambahkan kategori'];
      $status = 500;
    }
    break;

  case 'PUT':
    api_require_admin();
    // PUT /api/kategori?id=1
    if (!$id_kategori) {
      $res = ['success' => false, 'message' => 'ID kategori wajib diisi untuk update.'];
      $status = 400;
      break;
    }

    if (empty($input_data['nama_kategori'])) {
      $res = ['success' => false, 'message' => 'Nama kategori wajib diisi.'];
      $status = 422;
      break;
    }

    $is_edit = editKategori($id_kategori, $input_data);

    if ($is_edit) {
      $res = ['success' => true, 'message' => 'Kategori berhasil diupdate'];
    } else {
      $res = ['success' => false, 'message' => 'Kategori gagal diupdate atau tidak ditemukan'];
      $status = 404;
    }
    break;

  case 'DELETE':
    api_require_admin();
    // DELETE /api/kategori?id=1
    if (!$id_kategori) {
      $res = ['success' => false, 'message' => 'ID kategori wajib diisi untuk delete.'];
      $status = 400;
      break;
    }

    try {
      $is_hapus = hapusKategori($id_kategori);
      if ($is_hapus) {
        $res = ['success' => true, 'message' => 'Kategori berhasil dihapus'];
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      $res = ['success' => false, 'message' => 'Terjadi kesalahan saat menghapus kategori'];
      $status = 404;
    }
    break;

  default:
    $res = ['success' => false, 'message' => 'Metode ' . $method . ' tidak didukung.'];
    $status = 405;
}
// respon
respond_json($res, $status);
