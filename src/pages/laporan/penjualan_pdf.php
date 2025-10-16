<?php
models('Transaksi');
models('DetailTransaksi');
models('Produk');

$start  = $_GET['start'] ?? date('Y-m-01');
$end    = $_GET['end'] ?? date('Y-m-t');
$metode = $_GET['metode'] ?? '';

$sql = "
  SELECT t.*, u.nama AS kasir
  FROM transaksi t
  LEFT JOIN user u ON t.id_user = u.id_user
  WHERE DATE(t.tanggal_transaksi) BETWEEN ? AND ?
";
$params = [$start, $end];
$types  = "ss";
if ($metode !== '') {
  $sql .= " AND t.metode_bayar = ?";
  $params[] = $metode;
  $types .= "s";
}
$sql .= " ORDER BY t.tanggal_transaksi DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Penjualan', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, "Periode: $start s/d $end", 0, 1, 'C');
$pdf->Cell(0, 6, "Metode: " . ($metode ?: 'Semua'), 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200); // abu-abu muda
$pdf->Cell(10, 8, '#', 1, 0, 'C', true);
$pdf->Cell(36, 8, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(36, 8, 'Kode', 1, 0, 'C', true);
$pdf->Cell(36, 8, 'Kasir', 1, 0, 'C', true);
$pdf->Cell(36, 8, 'Metode', 1, 0, 'C', true);
$pdf->Cell(36, 8, 'Total', 1, 1, 'C', true);

// Data
$pdf->SetFont('Arial', '', 10);
$i = 1;
$total_all = 0;
while ($row = $res->fetch_assoc()) {
  $total_all += $row['total_harga'];
  $pdf->Cell(10, 8, $i++, 1, 0, 'C');
  $pdf->Cell(36, 8, $row['tanggal_transaksi'], 1, 0, 'C');
  $pdf->Cell(36, 8, $row['kode_transaksi'], 1, 0, 'C');
  $pdf->Cell(36, 8, $row['kasir'] ?? '-', 1, 0, 'L');
  $pdf->Cell(36, 8, $row['metode_bayar'], 1, 0, 'C');
  $pdf->Cell(36, 8, 'Rp ' . number_format($row['total_harga'], 0, ',', '.'), 1, 1, 'R');
}

// Total
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(154, 8, 'TOTAL', 1, 0, 'C');
$pdf->Cell(36, 8, 'Rp ' . number_format($total_all, 0, ',', '.'), 1, 1, 'R');

$pdf->Output('I', 'laporan_penjualan.pdf');
