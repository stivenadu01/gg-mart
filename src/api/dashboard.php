<?php
models('Transaksi');
models('DetailTransaksi');
models('Produk');


require_once ROOT_PATH . '/config/api_init.php';

$res = [];
$status = 200;

api_require_admin();

switch ($method) {
  case 'GET':
    // ambil 7 hari terakhir (start..end)
    $start = date('Y-m-d', strtotime('-6 days')); // 7 hari termasuk hari ini
    $end = date('Y-m-d');

    // ambil transaksi 7 hari terakhir via existing function (1 query ke DB yang kamu punya)
    // set limit besar agar semua trx 7 hari terambil (atau sesuaikan)
    [$daftar, $total] = getTransaksiList(1, 10000, null, $start, $end, null);

    // inisialisasi perhitungan
    $hariIni = date('Y-m-d');
    $penjualan7 = [];
    for ($i = 6; $i >= 0; $i--) {
      $tgl = date('Y-m-d', strtotime("-$i days"));
      $penjualan7[$tgl] = 0.0;
    }

    // hitung penjualan per hari dari daftar
    foreach ($daftar as $trx) {
      $tgl = date('Y-m-d', strtotime($trx['tanggal_transaksi']));
      $totalHarga = floatval($trx['total_harga']);
      if (isset($penjualan7[$tgl])) $penjualan7[$tgl] += $totalHarga;
    }

    // konversi chart
    $chart = [];
    foreach ($penjualan7 as $tgl => $tot) {
      $chart[] = ['tanggal' => $tgl, 'total' => $tot];
    }

    // transaksi terbaru: ambil 5 terbaru dari daftar (daftar sudah diurut DESC di getTransaksiList)
    $transaksi_terbaru = array_slice($daftar, 0, 5);

    // gunakan fungsi model untuk metrik lainnya (single-query masing2)
    $produk_terjual_hari_ini = getProdukTerjualByDate($hariIni);
    $pendapatan_hari_ini = getPendapatanByDate($hariIni);
    $pendapatan_kemarin = getPendapatanByDate(date('Y-m-d', strtotime('-1 day')));
    $produk_hampir_habis = getProdukHampirHabis(10); // batas 5

    // hitung persentase kenaikan (jaga pembagi 0)
    $persentase_kenaikan = 0.0;
    if ($pendapatan_kemarin > 0) {
      $persentase_kenaikan = round((($pendapatan_hari_ini - $pendapatan_kemarin) / $pendapatan_kemarin) * 100, 2);
    } elseif ($pendapatan_hari_ini > 0) {
      $persentase_kenaikan = 100.0; // dari 0 ke >0
    }

    $res = [
      'success' => true,
      'data' => [
        'transaksi_hari_ini' => intval(array_reduce($daftar, function ($carry, $trx) use ($hariIni) {
          return $carry + (date('Y-m-d', strtotime($trx['tanggal_transaksi'])) === $hariIni ? 1 : 0);
        }, 0)),
        'pendapatan_hari_ini' => $pendapatan_hari_ini,
        'produk_terjual_hari_ini' => intval($produk_terjual_hari_ini),
        'persentase_kenaikan' => $persentase_kenaikan,
        'produk_hampir_habis' => $produk_hampir_habis,
        'transaksi_terbaru' => $transaksi_terbaru,
        'penjualan_7_hari' => $chart
      ]
    ];
    break;
  case 'POST':
  case 'PUT':
  case 'DELETE':

  default:
    $res = ['success' => false, 'message' => "Metode tidak didukung: $method"];
    $status = 405;
}

respond_json($res, $status);
