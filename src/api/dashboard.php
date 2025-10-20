<?php
require_once ROOT_PATH . '/config/api_init.php';
models('Transaksi');
models('DetailTransaksi');
models('Produk');
models('Kategori');

api_require_admin();

$res = [];
$status = 200;

switch ($method) {
  case 'GET':
    $hariIni = date('Y-m-d');
    $kemarin = date('Y-m-d', strtotime('-1 day'));
    $start7  = date('Y-m-d', strtotime('-6 days'));
    $end7    = $hariIni;

    // ======== STATISTIK DASAR ========

    // total kategori & produk
    $totalKategori = count(getAllKategori());
    $totalProduk   = count(getAllProduk());

    // pendapatan dan produk terjual
    $pendapatanHariIni = getPendapatanByDate($hariIni);
    $pendapatanKemarin = getPendapatanByDate($kemarin);
    $produkTerjualHariIni = getProdukTerjualByDate($hariIni);
    $produkTerjualKemarin = getProdukTerjualByDate($kemarin);

    // produk hampir habis
    $produkHampirHabis = getProdukHampirHabis(10);

    // ambil semua transaksi 7 hari terakhir
    [$daftar, $total] = getTransaksiList(1, 10000, null, $start7, $end7, null);

    // hitung transaksi hari ini & kemarin
    $trxHariIni = 0;
    $trxKemarin = 0;
    foreach ($daftar as $trx) {
      $tgl = date('Y-m-d', strtotime($trx['tanggal_transaksi']));
      if ($tgl === $hariIni) $trxHariIni++;
      if ($tgl === $kemarin) $trxKemarin++;
    }

    // ======== PENJUALAN 7 HARI (CHART) ========
    $penjualan7 = [];
    for ($i = 6; $i >= 0; $i--) {
      $tgl = date('Y-m-d', strtotime("-$i days"));
      $penjualan7[$tgl] = 0;
    }

    foreach ($daftar as $trx) {
      $tgl = date('Y-m-d', strtotime($trx['tanggal_transaksi']));
      if (isset($penjualan7[$tgl])) {
        $penjualan7[$tgl] += floatval($trx['total_harga']);
      }
    }

    $chart = [];
    foreach ($penjualan7 as $tgl => $total) {
      $chart[] = ['tanggal' => $tgl, 'total' => $total];
    }

    // ======== TRANSAKSI TERBARU ========
    $transaksiTerbaru = array_slice($daftar, 0, 5);

    // ======== PERSENTASE KENAIKAN ========
    $kenaikanPendapatan = 0;
    $kenaikanTransaksi = 0;
    $kenaikanProdukTerjual = 0;

    if ($pendapatanKemarin > 0)
      $kenaikanPendapatan = round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100, 2);
    elseif ($pendapatanHariIni > 0)
      $kenaikanPendapatan = 100;

    if ($trxKemarin > 0)
      $kenaikanTransaksi = round((($trxHariIni - $trxKemarin) / $trxKemarin) * 100, 2);
    elseif ($trxHariIni > 0)
      $kenaikanTransaksi = 100;

    if ($produkTerjualKemarin > 0)
      $kenaikanProdukTerjual = round((($produkTerjualHariIni - $produkTerjualKemarin) / $produkTerjualKemarin) * 100, 2);
    elseif ($produkTerjualHariIni > 0)
      $kenaikanProdukTerjual = 100;

    // ======== KIRIM RESPON ========
    $res = [
      'success' => true,
      'data' => [
        'kategori' => intval($totalKategori),
        'produk' => intval($totalProduk),
        'transaksiHariIni' => intval($trxHariIni),
        'pendapatanHariIni' => floatval($pendapatanHariIni),
        'produkTerjualHariIni' => intval($produkTerjualHariIni),
        'produkHampirHabis' => $produkHampirHabis,
        'kenaikanTransaksi' => $kenaikanTransaksi,
        'kenaikanPendapatan' => $kenaikanPendapatan,
        'kenaikanProdukTerjual' => $kenaikanProdukTerjual,
        'transaksiTerbaru' => $transaksiTerbaru,
        'chart' => $chart,
      ]
    ];
    break;

  default:
    $res = ['success' => false, 'message' => "Metode tidak didukung: $method"];
    $status = 405;
    break;
}

respond_json($res, $status);
