<?php
models('Transaksi');
models('DetailTransaksi');
models('Produk');


require_once ROOT_PATH . '/config/api_init.php';

// ambil id_transaksi
$id_transaksi = $_GET['id'] ?? null;

$res = [];
$status = 200;
api_require_admin();
switch ($method) {
  case 'GET':
    // GET /api/transaksi?id=1
    if ($id_transaksi) {
      $transaksi = findTransaksi($id_transaksi);
      if (!$transaksi) {
        $res = ['success' => false, 'message' => 'Transaksi tidak ditemukan'];
        $status = 404;
        break;
      }

      $detail = getDetailTransaksi($id_transaksi);
      $transaksi['detail'] = $detail;

      $res = ['success' => true, 'data' => $transaksi];
      break;
    }

    // GET /api/transaksi
    $page   = $_GET['halaman'] ?? 1;
    $limit  = $_GET['limit'] ?? 10;
    $search = trim($_GET['search'] ?? null);
    $start  = $_GET['start'] ?? null;
    $end    = $_GET['end'] ?? null;
    $metode    = $_GET['metode'] ?? null;

    [$daftar, $total] = getTransaksiList($page, $limit, $search, $start, $end, $metode);
    $res = [
      'success' => true,
      'data' => $daftar,
      'pagination' => [
        'total' => intval($total),
        'page' => $page,
        'limit' => $limit,
        'total_pages' => ceil($total / $limit)
      ]
    ];
    break;

  case 'POST':
    // POST /api/transaksi

    try {
      $conn->begin_transaction();

      // validasi
      if (empty($input_data['total_harga']) || empty($input_data['detail']) || !is_array($input_data['detail'])) {
        throw new Exception('Total harga dan detail transaksi wajib diisi', 422);
        break;
      }

      // generate kode_transaksi
      $timePart = substr(str_replace('.', '', microtime(true)), -8);
      $randomPart = random_int(100, 999);
      $kode_transaksi = 'TRX_' . $timePart . $randomPart;

      $input_data['kode_transaksi'] = $kode_transaksi;
      $input_data['status'] = $input_data['status'] ?? 'pending';
      $input_data['metode_bayar'] = $input_data['metode_bayar'] ?? 'TUNAI';
      $input_data['id_user'] = $input_data['id_user'] ?? $_SESSION['user']['id_user'];

      // simpan transaksi utama
      $id_transaksi_baru = tambahTransaksi($input_data);

      // simpan detail transaksi
      foreach ($input_data['detail'] as $item) {
        $produk = findProduk($item['kode_produk']);
        if (!$produk) {
          throw new Exception("Produk {$item['kode_produk']} tidak ditemukan", 404);
          break 2;
        }

        $jumlah = intval($item['jumlah']);
        if ($produk['stok'] < $jumlah) {
          throw new Exception("Stok produk {$produk['nama_produk']} tidak mencukupi", 422);
          break 2;
        }

        $subtotal = $item['harga_satuan'] * $jumlah;
        tambahDetailTransaksi([
          'id_transaksi' => $id_transaksi_baru,
          'kode_produk' => $item['kode_produk'],
          'jumlah' => $jumlah,
          'harga_satuan' => $item['harga_satuan'],
          'subtotal' => $subtotal
        ]);

        // update stok & terjual
        updateStokProduk($item['kode_produk'], $produk['stok'] - $jumlah);
        updateTerjualProduk($item['kode_produk'], $produk['terjual'] + $jumlah);
      }
      $conn->commit();
      $res = ['success' => true, 'message' => 'Transaksi berhasil dibuat', 'data' => ['id' => $id_transaksi_baru, 'kode_transaksi' => $kode_transaksi]];
      $status = 201;
    } catch (Exception $e) {
      $conn->rollback();
      $res = ['success' => false, 'message' => $e->getMessage()];
      $status = $e->getCode() ?: 500;
    }
    break;

  case 'PUT':
    break;
  case 'DELETE':
    if (!$id_transaksi) {
      $res = ['success' => false, 'message' => 'ID transaksi wajib diisi untuk dihapus'];
      $status = 400;
      break;
    }

    $hapus = hapusTransaksi($id_transaksi);
    if ($hapus) {
      $res = ['success' => true, 'message' => 'Transaksi berhasil dihapus'];
    } else {
      $res = ['success' => true, 'message' => 'Gagal hapus transaksi'];
      $status = 400;
    }
    break;

  default:
    $res = ['success' => false, 'message' => "Metode tidak didukung: $method"];
    $status = 405;
}

respond_json($res, $status);
