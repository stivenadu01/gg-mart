<?php
require_once __DIR__ . '/../config/bootstrap.php';


$produk = [
  [
    'kode_produk' => 'PRD001',
    'id_kategori' => 1, // Sembako
    'nama_produk' => 'Beras Premium 5 Kg',
    'deskripsi'   => 'Beras kualitas premium, pulen dan wangi, cocok untuk konsumsi keluarga.',
    'harga'       => 75000,
    'stok'        => 50,
    'gambar'      => 'https://images.unsplash.com/photo-1615486364396-09f930d9e4f0'
  ],
  [
    'kode_produk' => 'PRD002',
    'id_kategori' => 1,
    'nama_produk' => 'Gula Pasir 1 Kg',
    'deskripsi'   => 'Gula pasir putih kristal halus, cocok untuk minuman dan masakan.',
    'harga'       => 16000,
    'stok'        => 80,
    'gambar'      => 'https://images.unsplash.com/photo-1621263764928-0dc8e7b8c1f8'
  ],
  [
    'kode_produk' => 'PRD003',
    'id_kategori' => 2, // Minuman
    'nama_produk' => 'Teh Botol Sosro 350ml',
    'deskripsi'   => 'Minuman teh melati dalam kemasan botol, segar diminum kapan saja.',
    'harga'       => 6000,
    'stok'        => 120,
    'gambar'      => 'https://images.unsplash.com/photo-1607016746330-7d4f44a07a24'
  ],
  [
    'kode_produk' => 'PRD004',
    'id_kategori' => 3, // Snack
    'nama_produk' => 'Keripik Singkong Pedas 200g',
    'deskripsi'   => 'Keripik singkong renyah dengan bumbu pedas gurih khas Indonesia.',
    'harga'       => 12000,
    'stok'        => 60,
    'gambar'      => 'https://images.unsplash.com/photo-1627308595229-7830a5c91f9f'
  ],
  [
    'kode_produk' => 'PRD005',
    'id_kategori' => 4, // Bumbu Dapur
    'nama_produk' => 'Kecap Manis Bango 620ml',
    'deskripsi'   => 'Kecap manis legendaris dengan rasa gurih manis khas kedelai hitam.',
    'harga'       => 25000,
    'stok'        => 40,
    'gambar'      => 'https://images.unsplash.com/photo-1590080875831-5d6c67f3b3f0'
  ],
  [
    'kode_produk' => 'PRD006',
    'id_kategori' => 5, // Produk Susu
    'nama_produk' => 'Susu UHT Ultra Milk 1L',
    'deskripsi'   => 'Susu sapi murni segar siap minum, tinggi kalsium untuk keluarga.',
    'harga'       => 18000,
    'stok'        => 70,
    'gambar'      => 'https://images.unsplash.com/photo-1580910051074-3af8c94a3e45'
  ],
  [
    'kode_produk' => 'PRD007',
    'id_kategori' => 6, // Sayur & Buah
    'nama_produk' => 'Pisang Cavendish 1 Sisir',
    'deskripsi'   => 'Pisang segar Cavendish, manis alami dan kaya potasium.',
    'harga'       => 25000,
    'stok'        => 30,
    'gambar'      => 'https://images.unsplash.com/photo-1574226516831-e1dff420e12e'
  ],
  [
    'kode_produk' => 'PRD008',
    'id_kategori' => 7, // Daging & Ikan
    'nama_produk' => 'Daging Ayam Fillet 1 Kg',
    'deskripsi'   => 'Daging ayam tanpa tulang segar, cocok untuk berbagai masakan.',
    'harga'       => 45000,
    'stok'        => 35,
    'gambar'      => 'https://images.unsplash.com/photo-1617196034473-9d2b1e47b3d3'
  ],
  [
    'kode_produk' => 'PRD009',
    'id_kategori' => 8, // Makanan Instan
    'nama_produk' => 'Indomie Goreng Spesial (5 pack)',
    'deskripsi'   => 'Mi instan goreng dengan bumbu khas, favorit masyarakat Indonesia.',
    'harga'       => 14500,
    'stok'        => 100,
    'gambar'      => 'https://images.unsplash.com/photo-1604908176997-33c0c4a83d89'
  ],
  [
    'kode_produk' => 'PRD010',
    'id_kategori' => 10, // Produk Lokal GMIT
    'nama_produk' => 'Madu Hutan Timor 250ml',
    'deskripsi'   => 'Madu murni hasil alam NTT, diproduksi oleh petani lokal binaan GMIT.',
    'harga'       => 55000,
    'stok'        => 25,
    'gambar'      => 'https://images.unsplash.com/photo-1587049352840-94b38f86f49f'
  ]
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
