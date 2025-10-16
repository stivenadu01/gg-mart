<?php
// Seeder kategori GG-Mart
require_once __DIR__ . '/../config/bootstrap.php';


$kategori = [
  ['nama_kategori' => 'Sembako', 'deskripsi' => 'Berbagai kebutuhan pokok rumah tangga seperti beras, gula, minyak goreng, tepung, dan garam.'],
  ['nama_kategori' => 'Minuman', 'deskripsi' => 'Aneka minuman kemasan seperti air mineral, teh, kopi, dan minuman ringan.'],
  ['nama_kategori' => 'Snack & Cemilan', 'deskripsi' => 'Camilan kering maupun basah seperti keripik, biskuit, kacang, dan kue kering.'],
  ['nama_kategori' => 'Bumbu Dapur', 'deskripsi' => 'Bumbu masak instan, rempah-rempah, saus, kecap, dan penyedap rasa.'],
  ['nama_kategori' => 'Produk Susu & Olahan', 'deskripsi' => 'Susu cair, susu bubuk, keju, yogurt, dan margarin.'],
  ['nama_kategori' => 'Sayur & Buah Segar', 'deskripsi' => 'Aneka sayuran dan buah segar hasil petani lokal.'],
  ['nama_kategori' => 'Daging & Ikan', 'deskripsi' => 'Produk protein hewani seperti ayam, sapi, dan ikan segar maupun beku.'],
  ['nama_kategori' => 'Makanan Instan', 'deskripsi' => 'Mie instan, bubur instan, sarden, dan makanan siap saji lainnya.'],
  ['nama_kategori' => 'Kebutuhan Rumah Tangga', 'deskripsi' => 'Barang harian seperti sabun, deterjen, tisu, dan alat kebersihan.'],
  ['nama_kategori' => 'Produk Lokal GMIT', 'deskripsi' => 'Produk hasil jemaat dan UMKM binaan GMIT seperti madu, keripik pisang, kopi lokal, dan olahan pangan khas daerah.'],
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
