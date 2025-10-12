<?php
require_once __DIR__ . '/../config/bootstrap.php';

$conn = get_db_connection();

$produk = [
  ['kode_produk' => 'PRD001', 'id_kategori' => 1, 'nama_produk' => 'Beras Premium 5 Kg', 'deskripsi' => 'Beras putih premium kualitas tinggi.', 'harga' => 68000, 'stok' => 120, 'terjual' => 25],
  ['kode_produk' => 'PRD002', 'id_kategori' => 1, 'nama_produk' => 'Beras Medium 5 Kg', 'deskripsi' => 'Beras medium berkualitas.', 'harga' => 55000, 'stok' => 100, 'terjual' => 30],
  ['kode_produk' => 'PRD003', 'id_kategori' => 2, 'nama_produk' => 'Minyak Goreng 1 Liter', 'deskripsi' => 'Minyak goreng nabati berkualitas.', 'harga' => 18000, 'stok' => 200, 'terjual' => 70],
  ['kode_produk' => 'PRD004', 'id_kategori' => 2, 'nama_produk' => 'Minyak Goreng 2 Liter', 'deskripsi' => 'Minyak goreng kemasan 2L.', 'harga' => 35000, 'stok' => 150, 'terjual' => 50],
  ['kode_produk' => 'PRD005', 'id_kategori' => 3, 'nama_produk' => 'Gula Pasir 1 Kg', 'deskripsi' => 'Gula pasir halus untuk kebutuhan dapur.', 'harga' => 16000, 'stok' => 150, 'terjual' => 45],
  ['kode_produk' => 'PRD006', 'id_kategori' => 3, 'nama_produk' => 'Gula Merah 500 gr', 'deskripsi' => 'Gula merah tradisional.', 'harga' => 12000, 'stok' => 80, 'terjual' => 20],
  ['kode_produk' => 'PRD007', 'id_kategori' => 4, 'nama_produk' => 'Telur Ayam 1 Kg', 'deskripsi' => 'Telur ayam segar lokal.', 'harga' => 29000, 'stok' => 80, 'terjual' => 30],
  ['kode_produk' => 'PRD008', 'id_kategori' => 4, 'nama_produk' => 'Telur Bebek 1 Kg', 'deskripsi' => 'Telur bebek segar.', 'harga' => 35000, 'stok' => 60, 'terjual' => 25],
  ['kode_produk' => 'PRD009', 'id_kategori' => 5, 'nama_produk' => 'Tepung Terigu 1 Kg', 'deskripsi' => 'Tepung terigu serbaguna.', 'harga' => 13000, 'stok' => 100, 'terjual' => 40],
  ['kode_produk' => 'PRD010', 'id_kategori' => 5, 'nama_produk' => 'Tepung Maizena 500 gr', 'deskripsi' => 'Tepung maizena untuk masak dan kue.', 'harga' => 9000, 'stok' => 70, 'terjual' => 15],
  ['kode_produk' => 'PRD011', 'id_kategori' => 1, 'nama_produk' => 'Beras Organik 2 Kg', 'deskripsi' => 'Beras organik pilihan.', 'harga' => 45000, 'stok' => 50, 'terjual' => 10],
  ['kode_produk' => 'PRD012', 'id_kategori' => 2, 'nama_produk' => 'Minyak Zaitun 500 ml', 'deskripsi' => 'Minyak zaitun murni.', 'harga' => 75000, 'stok' => 40, 'terjual' => 5],
  ['kode_produk' => 'PRD013', 'id_kategori' => 3, 'nama_produk' => 'Gula Halus 1 Kg', 'deskripsi' => 'Gula halus untuk kue.', 'harga' => 17000, 'stok' => 60, 'terjual' => 12],
  ['kode_produk' => 'PRD014', 'id_kategori' => 4, 'nama_produk' => 'Telur Organik 6 pcs', 'deskripsi' => 'Telur organik kemasan 6 pcs.', 'harga' => 25000, 'stok' => 100, 'terjual' => 20],
  ['kode_produk' => 'PRD015', 'id_kategori' => 5, 'nama_produk' => 'Tepung Beras 1 Kg', 'deskripsi' => 'Tepung beras serbaguna.', 'harga' => 14000, 'stok' => 80, 'terjual' => 18],
];

try {
  foreach ($produk as $p) {
    $stmt = $conn->prepare("
            INSERT INTO produk (kode_produk, id_kategori, nama_produk, deskripsi, harga, stok, terjual)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
    $stmt->bind_param(
      "sissiii",
      $p['kode_produk'],
      $p['id_kategori'],
      $p['nama_produk'],
      $p['deskripsi'],
      $p['harga'],
      $p['stok'],
      $p['terjual']
    );
    $stmt->execute();
  }

  echo "✅ Seeder 15 produk berhasil dijalankan!\n";
} catch (Exception $e) {
  echo "❌ Gagal menyimpan data produk: " . $e->getMessage() . "\n";
}
