<?php

page_require_admin();


$tipe = $_GET['tipe'] ?? 'harian';
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Penjualan GG-MART', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, 'Dicetak pada: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
$pdf->Ln(5);

global $conn;

if ($tipe === 'harian') {
  $waktu = $_GET['tanggal'] ?? date('Y-m-d');
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(0, 8, "Laporan Penjualan Harian ($waktu)", 0, 1, 'C');
  $pdf->Ln(3);

  // Header tabel
  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(35, 8, 'Tanggal & Waktu', 1);
  $pdf->Cell(35, 8, 'Kode', 1);
  $pdf->Cell(25, 8, 'Kasir', 1);
  $pdf->Cell(20, 8, 'Metode', 1);
  $pdf->Cell(25, 8, 'Jumlah Produk', 1, 0, 'C');
  $pdf->Cell(40, 8, 'Total Harga', 1, 1, 'R');

  $sql = "
    SELECT t.*, u.nama AS kasir, 
      (SELECT SUM(jumlah) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi) AS jumlah_produk
    FROM transaksi t
    LEFT JOIN user u ON u.id_user = t.id_user
    WHERE DATE(t.tanggal_transaksi) = ?
    ORDER BY t.tanggal_transaksi ASC
  ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $waktu);
  $stmt->execute();
  $res = $stmt->get_result();

  $totalProduk = 0;
  $totalPendapatan = 0;
  $pdf->SetFont('Arial', '', 9);
  while ($row = $res->fetch_assoc()) {
    $pdf->Cell(35, 7, date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])), 1);
    $pdf->Cell(35, 7, $row['kode_transaksi'], 1);
    $pdf->Cell(25, 7, $row['kasir'], 1);
    $pdf->Cell(20, 7, $row['metode_bayar'], 1);
    $pdf->Cell(25, 7, $row['jumlah_produk'], 1, 0, 'C');
    $pdf->Cell(40, 7, number_format($row['total_harga'], 0, ',', '.'), 1, 1, 'R');

    $totalProduk += $row['jumlah_produk'];
    $totalPendapatan += $row['total_harga'];
  }

  // Total
  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(115, 8, 'Total', 1);
  $pdf->Cell(25, 8, $totalProduk, 1, 0, 'C');
  $pdf->Cell(40, 8, 'Rp ' . number_format($totalPendapatan, 0, ',', '.'), 1, 1, 'R');
} elseif ($tipe === 'bulanan') {
  $waktu = $_GET['bulan'] ?? date('Y-m');
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(0, 8, "Laporan Penjualan Bulanan ($waktu)", 0, 1, 'C');
  $pdf->Ln(3);

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(40, 8, 'Tanggal', 1);
  $pdf->Cell(45, 8, 'Jumlah Transaksi', 1);
  $pdf->Cell(45, 8, 'Jumlah Produk', 1);
  $pdf->Cell(60, 8, 'Total Pendapatan', 1, 1);

  $sql = "
    SELECT DATE(t.tanggal_transaksi) AS tanggal,
           COUNT(*) AS jumlah_transaksi,
           SUM((SELECT SUM(jumlah) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi)) AS total_produk,
           SUM(t.total_harga) AS total_pendapatan
    FROM transaksi t
    WHERE DATE_FORMAT(t.tanggal_transaksi, '%Y-%m') = ?
    GROUP BY DATE(t.tanggal_transaksi)
    ORDER BY tanggal ASC
  ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $waktu);
  $stmt->execute();
  $res = $stmt->get_result();

  $sumTrx = $sumProduk = $sumPendapatan = 0;
  $pdf->SetFont('Arial', '', 9);
  while ($row = $res->fetch_assoc()) {
    $pdf->Cell(40, 7, $row['tanggal'], 1);
    $pdf->Cell(45, 7, $row['jumlah_transaksi'], 1, 0, 'C');
    $pdf->Cell(45, 7, $row['total_produk'], 1, 0, 'C');
    $pdf->Cell(60, 7, 'Rp ' . number_format($row['total_pendapatan'], 0, ',', '.'), 1, 1, 'R');

    $sumTrx += $row['jumlah_transaksi'];
    $sumProduk += $row['total_produk'];
    $sumPendapatan += $row['total_pendapatan'];
  }

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(40, 8, 'TOTAL', 1);
  $pdf->Cell(45, 8, $sumTrx, 1, 0, 'C');
  $pdf->Cell(45, 8, $sumProduk, 1, 0, 'C');
  $pdf->Cell(60, 8, 'Rp ' . number_format($sumPendapatan, 0, ',', '.'), 1, 1, 'R');
} elseif ($tipe === 'tahunan') {
  $waktu = $_GET['tahun'] ?? date('Y');
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->Cell(0, 8, "Laporan Penjualan Tahunan ($waktu)", 0, 1, 'C');
  $pdf->Ln(3);

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(40, 8, 'Bulan', 1);
  $pdf->Cell(45, 8, 'Jumlah Transaksi', 1);
  $pdf->Cell(45, 8, 'Jumlah Produk', 1);
  $pdf->Cell(60, 8, 'Total Pendapatan', 1, 1);

  $sql = "
    SELECT DATE_FORMAT(t.tanggal_transaksi, '%M') AS bulan,
           COUNT(*) AS jumlah_transaksi,
           SUM((SELECT SUM(jumlah) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi)) AS total_produk,
           SUM(t.total_harga) AS total_pendapatan
    FROM transaksi t
    WHERE YEAR(t.tanggal_transaksi) = ?
    GROUP BY MONTH(t.tanggal_transaksi)
    ORDER BY MONTH(t.tanggal_transaksi)
  ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $waktu);
  $stmt->execute();
  $res = $stmt->get_result();

  $sumTrx = $sumProduk = $sumPendapatan = 0;
  $pdf->SetFont('Arial', '', 9);
  while ($row = $res->fetch_assoc()) {
    $pdf->Cell(40, 7, $row['bulan'], 1);
    $pdf->Cell(45, 7, $row['jumlah_transaksi'], 1, 0, 'C');
    $pdf->Cell(45, 7, $row['total_produk'], 1, 0, 'C');
    $pdf->Cell(60, 7, 'Rp ' . number_format($row['total_pendapatan'], 0, ',', '.'), 1, 1, 'R');

    $sumTrx += $row['jumlah_transaksi'];
    $sumProduk += $row['total_produk'];
    $sumPendapatan += $row['total_pendapatan'];
  }

  $pdf->SetFont('Arial', 'B', 9);
  $pdf->Cell(40, 8, 'TOTAL', 1);
  $pdf->Cell(45, 8, $sumTrx, 1, 0, 'C');
  $pdf->Cell(45, 8, $sumProduk, 1, 0, 'C');
  $pdf->Cell(60, 8, 'Rp ' . number_format($sumPendapatan, 0, ',', '.'), 1, 1, 'R');
}


$pdf->Output('I', "Laporan_penjualan_" . $tipe  . "_ggmart_" . $waktu . ".pdf");
