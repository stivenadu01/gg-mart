<?php
models('Stok');
models('Produk');
require_once ROOT_PATH . '/config/api_init.php';

$res = [];
$status = 200;

switch ($method) {
  case 'GET':
    // GET /api/stok
    $stok = getAllStok();
    $res = ['success' => true, 'data' => $stok];
    break;

  case 'POST':
    api_require_admin();

    // Validasi input
    $kode_produk = $input_data['kode_produk'] ?? null;
    $tipe        = $input_data['tipe'] ?? null;
    $jumlah      = intval($input_data['jumlah'] ?? 0);
    $keterangan  = trim($input_data['keterangan'] ?? '');

    if (!$kode_produk || !$tipe || $jumlah <= 0) {
      respond_json(['success' => false, 'message' => 'Data tidak lengkap'], 422);
    }

    $produk = findProduk($kode_produk);
    if (!$produk) {
      respond_json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
    }

    // Tentukan perubahan stok
    $stok_baru = $produk['stok'];
    if ($tipe === 'masuk') {
      $stok_baru += $jumlah;
    } elseif ($tipe === 'keluar') {
      if ($produk['stok'] < $jumlah) {
        respond_json(['success' => false, 'message' => 'Stok tidak mencukupi untuk keluar'], 400);
      }
      $stok_baru -= $jumlah;
    } else {
      respond_json(['success' => false, 'message' => 'Tipe tidak valid'], 400);
    }

    // Simpan ke tabel stok
    $data_stok = [
      'kode_produk' => $kode_produk,
      'tipe' => $tipe,
      'jumlah' => $jumlah,
      'keterangan' => $keterangan
    ];
    tambahStok($data_stok);

    // Update stok di produk
    updateStokProduk($kode_produk, $stok_baru);

    $res = ['success' => true, 'message' => 'Stok berhasil diperbarui'];
    $status = 201;
    break;

  case 'DELETE':
    api_require_admin();

    $id = $_GET['id'] ?? null;
    $jumlah = $_GET['jumlah'] ?? 0;
    $kode_produk = $_GET['kode_produk'] ?? null;
    if (!$id || $jumlah <= 0) {
      respond_json(['success' => false, 'message' => 'Gagal hapus riwayat stok'], 400);
    }

    $produk = findProduk($kode_produk);
    if (!$produk) {
      respond_json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
    }
    // Tentukan perubahan stok
    $stok_lama = $produk['stok'];
    $stok_baru = $stok_lama - $jumlah;
    if ($stok_baru < 0) {
      respond_json(['success' => false, 'message' => 'Stok tidak mencukupi untuk dihapus'], 400);
    }
    $ok1 = hapusStok($id);
    $ok2 =  updateStokProduk($kode_produk, $stok_baru);
    if (!$ok1 && !$ok2) {
      respond_json(['success' => false, 'message' => 'Gagal hapus riwayat stok'], 500);
    }
    $res = ['success' => true, 'message' => 'Riwayat stok dihapus'];
    break;

  default:
    $res = ['success' => false, 'message' => 'Metode tidak didukung'];
    $status = 405;
}

respond_json($res, $status);
