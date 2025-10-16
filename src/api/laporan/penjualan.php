<?php
require_once ROOT_PATH . '/config/api_init.php';
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

// tambahkan filter jika metode dipilih
$params = [$start, $end];
$types  = "ss";
if ($metode !== '') {
  $sql .= " AND t.metode_bayar = ?";
  $params[] = $metode;
  $types   .= "s";
}

$sql .= " ORDER BY t.tanggal_transaksi DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
  $row['detail'] = getDetailTransaksi($row['id_transaksi']);
  $total += $row['total_harga'];
  $data[] = $row;
}

respond_json([
  'success' => true,
  'periode' => ['start' => $start, 'end' => $end],
  'metode'  => $metode ?: 'Semua',
  'total_penjualan' => $total,
  'data' => $data
]);
