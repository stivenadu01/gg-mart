<?php
models('Produk');
require_once ROOT_PATH . '/config/api_init.php';

$kode_produk = $_GET['k'] ?? null;
$res = [];
$status = 200;

switch ($method) {
  case 'GET':
    try {
      // Mode: all (tanpa pagination)
      if (isset($_GET['mode']) && $_GET['mode'] === 'all') {
        $data = getAllProduk();
        $res = ['success' => true, 'data' => $data];
        break;
      }

      // Mode: detail produk
      if ($kode_produk) {
        $produk = findProduk($kode_produk);
        if (!$produk) throw new Exception('Produk tidak ditemukan', 404);
        $res = ['success' => true, 'data' => $produk];
        break;
      }

      // Mode: list + pagination + search + sort
      $page   = max(1, intval($_GET['halaman'] ?? 1));
      $limit  = max(1, intval($_GET['limit'] ?? 10));
      $search = trim($_GET['search'] ?? '');
      $sort   = trim($_GET['sort'] ?? 'tanggal_dibuat');
      $dir    = strtoupper(trim($_GET['dir'] ?? 'DESC'));

      [$produk, $total] = getProdukList($page, $limit, $search, $sort, $dir);
      $res = [
        'success' => true,
        'data' => $produk,
        'pagination' => [
          'page' => $page,
          'limit' => $limit,
          'total' => intval($total),
          'total_pages' => ($limit > 0) ? ceil($total / $limit) : 1
        ]
      ];
    } catch (Exception $e) {
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  case 'POST':
    try {
      if (empty($input_data['nama_produk']) || empty($input_data['harga_jual'])) {
        throw new Exception('Nama dan Harga wajib diisi.', 422);
      }

      $timePart = substr(str_replace('.', '', microtime(true)), -8);
      $randomPart = random_int(100, 999);
      $new_kode_produk = 'PRD_' . $timePart . $randomPart;
      $input_data['kode_produk'] = $new_kode_produk;

      // Upload gambar
      if (!empty($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = $new_kode_produk . '.' . $ext;
        $targetDir = ROOT_PATH . '/public/uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $filename)) {
          throw new Exception('Gagal mengunggah gambar.', 500);
        }

        $input_data['gambar'] = $filename;
      }

      if (!tambahProduk($input_data)) {
        throw new Exception('Gagal menambahkan produk ke database.', 500);
      }

      $res = ['success' => true, 'message' => 'Produk berhasil ditambahkan', 'data' => $new_kode_produk];
      $status = 201;
    } catch (Exception $e) {
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  case 'PUT':
    try {
      if (!$kode_produk) throw new Exception('Kode produk wajib diisi untuk update.', 400);
      if (empty($input_data['nama_produk']) || empty($input_data['harga_jual'])) {
        throw new Exception('Nama dan Harga wajib diisi.', 422);
      }

      // Handle upload gambar baru
      if (!empty($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = $kode_produk . '.' . $ext;
        $targetDir = ROOT_PATH . '/public/uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $produk_lama = findProduk($kode_produk);
        if (!empty($produk_lama['gambar'])) {
          $oldPath = $targetDir . $produk_lama['gambar'];
          if (file_exists($oldPath)) unlink($oldPath);
        }

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $filename)) {
          throw new Exception('Gagal mengunggah gambar baru.', 500);
        }

        $input_data['gambar'] = $filename;
      }

      if (!editProduk($kode_produk, $input_data)) {
        throw new Exception('Produk gagal diupdate atau tidak ditemukan.', 404);
      }

      $res = ['success' => true, 'message' => 'Produk berhasil diupdate'];
    } catch (Exception $e) {
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  case 'DELETE':
    try {
      if (!$kode_produk) throw new Exception('Kode produk wajib diisi untuk delete.', 400);

      $produk_lama = findProduk($kode_produk);
      if ($produk_lama && !empty($produk_lama['gambar'])) {
        $path = ROOT_PATH . '/public/uploads/' . $produk_lama['gambar'];
        if (file_exists($path)) unlink($path);
      }

      if (!hapusProduk($kode_produk)) {
        throw new Exception('Produk gagal dihapus atau tidak ditemukan.', 404);
      }

      $res = ['success' => true, 'message' => 'Produk berhasil dihapus'];
    } catch (Exception $e) {
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  default:
    $status = 405;
    $res = ['success' => false, 'message' => 'Metode tidak didukung'];
}

respond_json($res, $status);
