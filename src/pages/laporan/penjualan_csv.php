<?php
models('Transaksi');
models('DetailTransaksi');
models('Produk');

// === FUNGSI REKAP TAMBAHAN ===========================
function getRekapPerHari($start, $end, $metode = null)
{
  global $conn;
  $data = [];
  $tanggal_list = getTanggalRange($start, $end);

  foreach ($tanggal_list as $tgl) {
    $filter_metode = $metode ? "AND metode_bayar = '$metode'" : "";

    $trx_tgl = $conn->query("
      SELECT 
        COUNT(*) as total_transaksi,
        SUM(total_pokok) as pokok, 
        SUM(total_harga) as jual 
      FROM transaksi 
      WHERE DATE(tanggal_transaksi) = '$tgl' $filter_metode
    ")->fetch_assoc();

    $trx_jumlah = $conn->query("
      SELECT 
        SUM(dt.jumlah) as total_produk 
      FROM transaksi t 
      LEFT JOIN detail_transaksi dt 
        ON t.kode_transaksi = dt.kode_transaksi
      WHERE DATE(t.tanggal_transaksi) = '$tgl' $filter_metode
    ")->fetch_assoc();

    $pokok = (float)($trx_tgl['pokok'] ?? 0);
    $jual  = (float)($trx_tgl['jual'] ?? 0);
    $laba  = $jual - $pokok;

    $data[] = [
      'tanggal' => $tgl,
      'transaksi' => (int)($trx_tgl['total_transaksi'] ?? 0),
      'produk' => (int)($trx_jumlah['total_produk'] ?? 0),
      'pokok' => $pokok,
      'jual'  => $jual,
      'laba'  => $laba
    ];
  }
  return $data;
}

function getRekapPerBulan($tahun, $metode = null)
{
  global $conn;
  $data = [];

  for ($i = 1; $i <= 12; $i++) {
    $start = "$tahun-" . str_pad($i, 2, '0', STR_PAD_LEFT) . "-01";
    $end = date('Y-m-t', strtotime($start));
    $filter_metode = $metode ? "AND metode_bayar = '$metode'" : "";

    $trx_bulan = $conn->query("
      SELECT 
      COUNT(*) as total_transaksi,
      SUM(total_pokok) as pokok, 
      SUM(total_harga) as jual 
      FROM transaksi
      WHERE DATE(tanggal_transaksi) BETWEEN '$start' AND '$end' 
      $filter_metode
    ")->fetch_assoc();

    $trx_jumlah = $conn->query("
      SELECT 
      SUM(dt.jumlah) as total_produk
      FROM transaksi t 
      LEFT JOIN detail_transaksi dt
      ON t.kode_transaksi = dt.kode_transaksi
      WHERE DATE(t.tanggal_transaksi) BETWEEN '$start' AND '$end' 
      $filter_metode
    ")->fetch_assoc();

    $pokok = (float)($trx_bulan['pokok'] ?? 0);
    $jual  = (float)($trx_bulan['jual'] ?? 0);
    $laba  = $jual - $pokok;

    $data[] = [
      'bulan' => date('F', mktime(0, 0, 0, $i, 10)),
      'transaksi' => (int)($trx_bulan['total_transaksi'] ?? 0),
      'produk' => (int)($trx_jumlah['total_produk'] ?? 0),
      'pokok' => $pokok,
      'jual'  => $jual,
      'laba'  => $laba
    ];
  }

  return $data;
}

function getTanggalRange($start, $end)
{
  $dates = [];
  $current = strtotime($start);
  $last = strtotime($end);
  while ($current <= $last) {
    $dates[] = date('Y-m-d', $current);
    $current = strtotime("+1 day", $current);
  }
  return $dates;
}

// ================= PARAMETER ===================
$tipe   = $_GET['tipe'] ?? 'harian';
$tanggal = $_GET['tanggal'] ?? null;
$bulan   = $_GET['bulan'] ?? null;
$tahun   = $_GET['tahun'] ?? null;
$metode  = $_GET['metode'] ?? null;
$search  = $_GET['search'] ?? null;

// ================= HEADER CSV ===================
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Laporan_Penjualan_' . $tipe . '_GGMART_' . date('Ymd_His') . '.csv"');
$output = fopen('php://output', 'w');

// ================= ISI CSV ===================
fputcsv($output, ['Laporan Penjualan GGMART']);
fputcsv($output, ['Dicetak pada:', date('l, d F Y')]);

if ($tipe === 'harian' && $tanggal)
  fputcsv($output, ['Periode:', date('d/m/Y', strtotime($tanggal))]);
elseif ($tipe === 'bulanan' && $bulan)
  fputcsv($output, ['Periode:', date('F Y', strtotime($bulan))]);
elseif ($tipe === 'tahunan' && $tahun)
  fputcsv($output, ['Periode:', "Tahun $tahun"]);

fputcsv($output, []); // baris kosong

// === MODE HARIAN ====================================
if ($tipe === 'harian') {
  [$transaksiList,, $summary] = getTransaksiList(1, 9999, $search, $tanggal, $tanggal, $metode);
  fputcsv($output, ['Kode Transaksi', 'Waktu', 'Metode', 'Produk', 'Jumlah', 'Pokok', 'Jual', 'Total Pokok', 'Total Jual', 'Laba']);

  foreach ($transaksiList as $trx) {
    $detailList = getDetailTransaksi($trx['kode_transaksi']);
    foreach ($detailList as $d) {
      $pokok = (float)$d['harga_pokok'] ?? 0;
      $satuan = (float)$d['harga_satuan'] ?? 0;
      $sub_pokok = (float)$d['subtotal_pokok'] ?? 0;
      $subtotal = (float)$d['subtotal'] ?? 0;
      $laba = $subtotal - $sub_pokok;

      fputcsv($output, [
        $trx['kode_transaksi'],
        date('H:i:s', strtotime($trx['tanggal_transaksi'])),
        strtoupper($trx['metode_bayar']),
        $d['nama_produk'],
        $d['jumlah'],
        number_format($pokok, 0, ',', '.'),
        number_format($satuan, 0, ',', '.'),
        'Rp ' . number_format($sub_pokok, 0, ',', '.'),
        'Rp ' . number_format($subtotal, 0, ',', '.'),
        'Rp ' . number_format($laba, 0, ',', '.')
      ]);
    }
  }

  fputcsv($output, []);
  fputcsv($output, [
    'TOTAL',
    '',
    '',
    '',
    '',
    '',
    '',
    'Rp ' . number_format((float)($summary['pokok'] ?? 0), 0, ',', '.'),
    'Rp ' . number_format((float)($summary['jual'] ?? 0), 0, ',', '.'),
    'Rp ' . number_format((float)($summary['laba'] ?? 0), 0, ',', '.')
  ]);
}

// === MODE BULANAN ====================================
elseif ($tipe === 'bulanan') {
  $start = date('Y-m', strtotime($bulan)) . '-01';
  $end   = date('Y-m-t', strtotime($start));
  $rekap = getRekapPerHari($start, $end, $metode);

  fputcsv($output, ['Tanggal', 'Transaksi', 'Produk Terjual', 'Total Pokok', 'Total Penjualan', 'Total Laba']);
  $totalTrx = $totalProduk = $totalPokok = $totalJual = $totalLaba = 0;

  foreach ($rekap as $r) {
    fputcsv($output, [
      date('d/m/Y', strtotime($r['tanggal'])),
      $r['transaksi'],
      $r['produk'],
      'Rp ' . number_format($r['pokok'], 0, ',', '.'),
      'Rp ' . number_format($r['jual'], 0, ',', '.'),
      'Rp ' . number_format($r['laba'], 0, ',', '.')
    ]);

    $totalTrx += $r['transaksi'];
    $totalProduk += $r['produk'];
    $totalPokok += $r['pokok'];
    $totalJual  += $r['jual'];
    $totalLaba  += $r['laba'];
  }

  fputcsv($output, []);
  fputcsv($output, [
    'TOTAL',
    $totalTrx,
    $totalProduk,
    'Rp ' . number_format($totalPokok, 0, ',', '.'),
    'Rp ' . number_format($totalJual, 0, ',', '.'),
    'Rp ' . number_format($totalLaba, 0, ',', '.')
  ]);
}

// === MODE TAHUNAN ====================================
elseif ($tipe === 'tahunan') {
  $rekap = getRekapPerBulan($tahun, $metode);

  fputcsv($output, ['Bulan', 'Transaksi', 'Produk Terjual', 'Total Pokok', 'Total Penjualan', 'Total Laba']);
  $totalTrx = $totalProduk = $totalPokok = $totalJual = $totalLaba = 0;

  foreach ($rekap as $r) {
    fputcsv($output, [
      ucfirst($r['bulan']),
      $r['transaksi'],
      $r['produk'],
      'Rp ' . number_format($r['pokok'], 0, ',', '.'),
      'Rp ' . number_format($r['jual'], 0, ',', '.'),
      'Rp ' . number_format($r['laba'], 0, ',', '.')
    ]);

    $totalTrx += $r['transaksi'];
    $totalProduk += $r['produk'];
    $totalPokok += $r['pokok'];
    $totalJual  += $r['jual'];
    $totalLaba  += $r['laba'];
  }

  fputcsv($output, []);
  fputcsv($output, [
    'TOTAL',
    $totalTrx,
    $totalProduk,
    'Rp ' . number_format($totalPokok, 0, ',', '.'),
    'Rp ' . number_format($totalJual, 0, ',', '.'),
    'Rp ' . number_format($totalLaba, 0, ',', '.')
  ]);
}

fclose($output);
exit;
