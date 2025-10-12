<?php
// Seeder kategori GG-Mart
require_once __DIR__ . '/../config/bootstrap.php';

$conn = get_db_connection();

$kategori = [
  ['nama_kategori' => 'Bahan Pokok', 'deskripsi' => 'Kebutuhan dasar sehari-hari seperti beras, gula, dan minyak.'],
  ['nama_kategori' => 'Minyak & Bumbu', 'deskripsi' => 'Minyak goreng, kecap, garam, dan bumbu dapur lainnya.'],
  ['nama_kategori' => 'Gula & Tepung', 'deskripsi' => 'Aneka gula, tepung terigu, maizena, dan bahan kue.'],
  ['nama_kategori' => 'Telur & Susu', 'deskripsi' => 'Telur ayam, susu segar, dan produk olahannya.'],
  ['nama_kategori' => 'Snack & Minuman', 'deskripsi' => 'Camilan, kopi, teh, dan minuman ringan.'],
];

try {
  $inserted = 0;
  foreach ($kategori as $k) {
    // Cek apakah kategori sudah ada berdasarkan nama
    $check = $conn->prepare("SELECT COUNT(*) FROM kategori WHERE nama_kategori = ?");
    $check->bind_param("s", $k['nama_kategori']);
    $check->execute();
    $check->bind_result($exists);
    $check->fetch();
    $check->close();

    if ($exists == 0) {
      $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)");
      $stmt->bind_param("ss", $k['nama_kategori'], $k['deskripsi']);
      $stmt->execute();
      $stmt->close();
      $inserted++;
    }
  }

  echo "✅ Seeder kategori selesai. ($inserted kategori baru ditambahkan)\n";
} catch (Exception $e) {
  echo "❌ Gagal menyimpan data kategori: " . $e->getMessage() . "\n";
}
