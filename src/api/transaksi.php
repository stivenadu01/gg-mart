<?php
models('transaksi');
models('MutasiStok');
models('DetailTransaksi');
models('Produk');
require_once ROOT_PATH . '/config/api_init.php';

$kode_transaksi = $_GET['k'] ?? null;
$res = [];
$status = 200;

switch ($method) {
  // GET /api/transaksi?=
  case 'GET':
    try {
      // Mode: list + pagination + search
      $page   = max(1, intval($_GET['halaman'] ?? 1));
      $limit  = max(1, intval($_GET['limit'] ?? 10));
      $search = trim($_GET['search'] ?? '');

      [$data, $total] = gettransaksiList($page, $limit, $search);

      $res = [
        'success' => true,
        'data' => $data,
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

  // POST /api/transaksi
  case 'POST':
    global $conn;
    $conn->begin_transaction();
    try {
      // buat kode trx
      $time_part = substr(str_replace('.', '', microtime(true)), -8);
      $random_part = random_int(100, 999);
      $kode_transaksi = "TRX_" . $time_part . $random_part;
      $input_data['kode_transaksi'] = $kode_transaksi;


      // handle detail transaksi
      $data_detail_transaksi = [];
      $total_pokok = 0;

      // /** @var array $input_data */
      foreach ($input_data['detail'] as $item) {
        // ambil harga pokok dari batch stok (paling lama, sisa > 0)
        $stok = getMutasiByProduk($item['kode_produk']);
        if (!$stok) throw new Exception("Stok Tidak Ada", 422);

        // ambil stok produk dari sisa stok batch 
        $subtotal_pokok = 0;
        $ambil = intval($item['jumlah']);

        foreach ($stok as $s) {
          if ($ambil <= 0) break;
          $ambil_dari_batch = min($s['sisa_stok'], $ambil); //return nilai terkecil
          $ambil -= $ambil_dari_batch;
          $s['sisa_stok'] -= $ambil_dari_batch;
          $subtotal_pokok += $ambil_dari_batch * $s['harga_pokok'];
          if (!ubahSisaStokMutasi($s['id_mutasi'], $s['sisa_stok'])) throw new Exception("Gagal Ubah Sisa Stok", 500);
        }

        $total_pokok += $subtotal_pokok;
        if ($ambil > 0) {
          throw new Exception("Stok Dari {$s['nama_produk']} Tidak Cukup", 1);
        }

        $data_detail_transaksi[] = [
          'kode_transaksi' => $kode_transaksi,
          'kode_produk' => $item['kode_produk'],
          'jumlah' => $item['jumlah'],
          'harga_satuan' => $item['harga_satuan'],
          'harga_pokok' => $subtotal_pokok / $item['jumlah'],
          'subtotal' => $item['jumlah'] * $item['harga_satuan'],
          'subtotal_pokok' => $subtotal_pokok
        ];

        if (!updateStokProduk($item['kode_produk'])) throw new Exception("Gagal Update Stok", 500);
        if (!ubahTerjualProduk($item['kode_produk'], $item['jumlah']));
      }

      $input_data['total_pokok'] = $total_pokok;
      if (!tambahTransaksi($input_data));
      foreach ($data_detail_transaksi as $d) {
        if (!tambahDetailTransaksi($d)) throw new Exception("Gagal Tambah Detail", 500);
      }

      $conn->commit();
      $res = ['success' => true, 'message' => 'transaksi berhasil ditambahkan', 'data' => $kode_transaksi];
      $status = 201;
    } catch (Exception $e) {
      $conn->rollback();
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  // DELETE /api/transaksi?k=1
  case 'DELETE':
    try {
      $res = ['success' => true, 'message' => 'transaksi berhasil dihapus'];
    } catch (Exception $e) {
      $status = $e->getCode() ?: 500;
      $res = ['success' => false, 'message' => $e->getMessage()];
    }
    break;

  default:
    $status = 405;
    $res = ['success' => false, 'message' => 'Metode tidak didukung'];
    break;
}

respond_json($res, $status);
