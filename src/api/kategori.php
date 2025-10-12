<?php
header('Content-Type: application/json');

$conn = get_db_connection();

$sql = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
$result = $conn->query($sql);

$kategori = [];

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $kategori[] = $row;
  }
  echo json_encode([
    'success' => true,
    'data' => $kategori
  ]);
} else {
  echo json_encode([
    'success' => false,
    'message' => $conn->error
  ]);
}
