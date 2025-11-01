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

    // Total pokok dan jual per tanggal
    $trx_tgl = $conn->query("
      SELECT 
        COUNT(*) as total_transaksi,
        SUM(total_pokok) as pokok, 
        SUM(total_harga) as jual 
      FROM transaksi 
      WHERE DATE(tanggal_transaksi) = '$tgl' $filter_metode
    ")->fetch_assoc();

    // Total produk terjual per tanggal
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

    // Total produk terjual per tanggal
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

// ================= SETUP PDF ===================
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// HEADER
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Penjualan GGMART', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Dicetak pada: ' . date('l, d F Y'), 0, 1, 'C');

if ($tipe === 'harian' && $tanggal) {
  $pdf->Cell(0, 7, "Periode: " . date('d/m/Y', strtotime($tanggal)), 0, 1, 'C');
} elseif ($tipe === 'bulanan' && $bulan) {
  $pdf->Cell(0, 7, "Periode: " . date('F Y', strtotime($bulan)), 0, 1, 'C');
} elseif ($tipe === 'tahunan' && $tahun) {
  $pdf->Cell(0, 7, "Periode: Tahun $tahun", 0, 1, 'C');
}

$pdf->Ln(5);


// === MODE HARIAN (DETAIL) ============================
if ($tipe === 'harian') {
  [$transaksiList,, $summary] = getTransaksiList(1, 9999, $search, $tanggal, $tanggal, $metode);

  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(28, 16, 'Kode Transaksi', 1, 0, 'C');
  $pdf->Cell(16, 16, 'Waktu', 1, 0, 'C');
  $pdf->Cell(12, 16, 'Metode', 1, 0, 'C');
  $x = $pdf->GetX();
  $pdf->Cell(134, 8, 'Detail Transaksi', 1, 0, 'C');
  $pdf->Ln(8);
  $pdf->SetX($x);
  $pdf->Cell(39, 8, 'Produk', 1, 0, 'C');
  $pdf->Cell(7, 8, 'Jml', 1, 0, 'C');
  $pdf->Cell(14, 8, 'Pokok', 1, 0, 'C');
  $pdf->Cell(15, 8, 'Jual', 1, 0, 'C');
  $pdf->Cell(20, 8, 'T.Pokok', 1, 0, 'C');
  $pdf->Cell(20, 8, 'T.Jual', 1, 0, 'C');
  $pdf->Cell(19, 8, 'T.Laba', 1, 1, 'C');

  $pdf->SetFont('Arial', '', 8);
  foreach ($transaksiList as $trx) {
    $detailList = getDetailTransaksi($trx['kode_transaksi']);
    foreach ($detailList as $d) {

      $pokok = (float)$d['harga_pokok'] ?? 0;
      $satuan = (float)$d['harga_satuan'] ?? 0;
      $sub_pokok = (float)$d['subtotal_pokok'] ?? 0;
      $subtotal = (float)$d['subtotal'] ?? 0;
      $laba = $subtotal - $sub_pokok;

      $pdf->Cell(28, 7, $trx['kode_transaksi'], 1);
      $pdf->Cell(16, 7, date('H:i:s', strtotime($trx['tanggal_transaksi'])), 1);
      $pdf->Cell(12, 7, ucfirst($trx['metode_bayar']), 1);
      $pdf->Cell(39, 7, $d['nama_produk'], 1);
      $pdf->Cell(7, 7, $d['jumlah'], 1, 0, 'C');
      $pdf->Cell(14, 7, number_format($pokok, 0, ',', '.'), 1, 0, 'R');
      $pdf->Cell(15, 7, number_format($satuan, 0, ',', '.'), 1, 0, 'R');
      $pdf->Cell(20, 7, 'Rp' . number_format($sub_pokok, 0, ',', '.'), 1, 0, 'R');
      $pdf->Cell(20, 7, 'Rp' . number_format($subtotal, 0, ',', '.'), 1, 0, 'R');
      $pdf->Cell(19, 7, 'Rp' . number_format($laba, 0, ',', '.'), 1, 1, 'R');
    }
  }
  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(131, 8, 'TOTAL', 1, 0, 'L');
  $pdf->Cell(20, 8, 'Rp' . number_format((float)($summary['pokok'] ?? 0), 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(20, 8, 'Rp' . number_format((float)($summary['jual'] ?? 0), 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(19, 8, 'Rp' . number_format((float)($summary['laba'] ?? 0), 0, ',', '.'), 1, 1, 'R');
}

// === MODE BULANAN ====================================
elseif ($tipe === 'bulanan') {
  $start = date('Y-m', strtotime($bulan)) . '-01';
  $end   = date('Y-m-t', strtotime($start));
  $rekap = getRekapPerHari($start, $end, $metode);

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C');
  $pdf->Cell(25, 8, 'Transaksi', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Produk Terjual', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Total Pokok', 1, 0, 'C');
  $pdf->Cell(35, 8, 'Total Penjualan', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Total Laba', 1, 1, 'C');

  $pdf->SetFont('Arial', '', 9);
  $totalTrx = $totalProduk = $totalPokok = $totalJual = $totalLaba = 0;

  foreach ($rekap as $r) {
    $pdf->Cell(30, 7, date('d/m/Y', strtotime($r['tanggal'])), 1);
    $pdf->Cell(25, 7, $r['transaksi'], 1, 0, 'C');
    $pdf->Cell(30, 7, $r['produk'], 1, 0, 'C');
    $pdf->Cell(30, 7, 'Rp ' . number_format($r['pokok'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(35, 7, 'Rp ' . number_format($r['jual'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 7, 'Rp ' . number_format($r['laba'], 0, ',', '.'), 1, 1, 'R');

    $totalTrx += $r['transaksi'];
    $totalProduk += $r['produk'];
    $totalPokok += $r['pokok'];
    $totalJual  += $r['jual'];
    $totalLaba  += $r['laba'];
  }

  // TOTAL BAWAH
  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(30, 8, 'TOTAL', 1);
  $pdf->Cell(25, 8, $totalTrx, 1, 0, 'C');
  $pdf->Cell(30, 8, $totalProduk, 1, 0, 'C');
  $pdf->Cell(30, 8, 'Rp ' . number_format($totalPokok, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(35, 8, 'Rp ' . number_format($totalJual, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 8, 'Rp ' . number_format($totalLaba, 0, ',', '.'), 1, 1, 'R');
}

// === MODE TAHUNAN (PERBAIKAN: TAMBAH TRANSAKSI & PRODUK) =====================
elseif ($tipe === 'tahunan') {
  $rekap = getRekapPerBulan($tahun, $metode);

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(30, 8, 'Bulan', 1, 0, 'C');
  $pdf->Cell(25, 8, 'Transaksi', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Produk Terjual', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Total Pokok', 1, 0, 'C');
  $pdf->Cell(35, 8, 'Total Penjualan', 1, 0, 'C');
  $pdf->Cell(30, 8, 'Total Laba', 1, 1, 'C');

  $pdf->SetFont('Arial', '', 9);
  $totalTrx = $totalProduk = $totalPokok = $totalJual = $totalLaba = 0;

  foreach ($rekap as $r) {
    $pdf->Cell(30, 7, ucfirst($r['bulan']), 1);
    $pdf->Cell(25, 7, $r['transaksi'], 1, 0, 'C');
    $pdf->Cell(30, 7, $r['produk'], 1, 0, 'C');
    $pdf->Cell(30, 7, 'Rp ' . number_format($r['pokok'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(35, 7, 'Rp ' . number_format($r['jual'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 7, 'Rp ' . number_format($r['laba'], 0, ',', '.'), 1, 1, 'R');

    $totalTrx += $r['transaksi'];
    $totalProduk += $r['produk'];
    $totalPokok += $r['pokok'];
    $totalJual  += $r['jual'];
    $totalLaba  += $r['laba'];
  }

  // TOTAL AKHIR
  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(30, 8, 'TOTAL', 1);
  $pdf->Cell(25, 8, $totalTrx, 1, 0, 'C');
  $pdf->Cell(30, 8, $totalProduk, 1, 0, 'C');
  $pdf->Cell(30, 8, 'Rp ' . number_format($totalPokok, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(35, 8, 'Rp ' . number_format($totalJual, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 8, 'Rp ' . number_format($totalLaba, 0, ',', '.'), 1, 1, 'R');
}

$pdf->Output('I', "Laporan_Penjualan_{$tipe}_GGMART_" . date('Ymd_His') . ".pdf");
