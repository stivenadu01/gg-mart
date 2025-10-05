<?php

function getAllProduk()
{
  $conn = get_db_connection();
  $sql = "SELECT * FROM produk";
  $result = $conn->query($sql);
  $produk = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $produk[] = $row;
    }
  }
  $conn->close();
  return $produk;
}

function getProdukByKode($kode)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("SELECT * FROM produk WHERE kode_produk = ?");
  $stmt->bind_param("s", $kode);
  $stmt->execute();
  $result = $stmt->get_result();
  $produk = $result->fetch_assoc();
  $stmt->close();
  $conn->close();
  return $produk;
}

function tambahProduk($data)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("INSERT INTO produk (kode_produk, nama_produk, harga, stok, gambar, deskripsi, izin_edar) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdisss", $data['kode_produk'], $data['nama_produk'], $data['harga'], $data['stok'], $data['gambar'], $data['deskripsi'], $data['izin_edar']);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function updateProduk($kode, $data)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, gambar = ?, deskripsi = ?, izin_edar = ? WHERE kode_produk = ?");
  $stmt->bind_param("sdissss", $data['nama_produk'], $data['harga'], $data['stok'], $data['gambar'], $data['deskripsi'], $data['izin_edar'], $kode);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function hapusProduk($kode)
{
  $conn = get_db_connection();
  // Hapus gambar dari server
  $produk = getProdukByKode($kode);
  if ($produk && $produk['gambar']) {
    $uploadDir = ROOT_PATH . '/public/uploads/';
    if (file_exists($uploadDir . $produk['gambar'])) {
      unlink($uploadDir . $produk['gambar']);
    }
  }
  // Hapus data produk dari database
  $stmt = $conn->prepare("DELETE FROM produk WHERE kode_produk = ?");
  $stmt->bind_param("s", $kode);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}


function getFilteredProduk($q = '', $urutkan = 'sesuai')
{
  $conn = get_db_connection();

  // Query dasar
  $sql = "SELECT * FROM produk WHERE 1";

  // 🔍 Filter pencarian (nama/deskripsi)
  if (!empty($q)) {
    $q_safe = mysqli_real_escape_string($conn, $q);
    $sql .= " AND (nama_produk LIKE '%$q_safe%' OR deskripsi LIKE '%$q_safe%')";
  }

  // 🔽 Urutkan berdasarkan pilihan
  switch ($urutkan) {
    case 'termahal':
      $sql .= " ORDER BY harga DESC";
      break;
    case 'termurah':
      $sql .= " ORDER BY harga ASC";
      break;
    case 'terlaris':
      $sql .= " ORDER BY terjual DESC";
      break;
    case 'terbaru':
      $sql .= " ORDER BY created_at DESC";
      break;
    default:
      $sql .= " ORDER BY kode_produk DESC";
      break;
  }

  // Jalankan query
  $result = $conn->query($sql);
  $produk = [];
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $produk[] = $row;
    }
  }

  return $produk;
}
