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


function searchProduk($query)
{
  $conn = get_db_connection();
  $likeQuery = '%' . $conn->real_escape_string($query) . '%';
  $stmt = $conn->prepare("SELECT * FROM produk WHERE nama_produk LIKE ? OR deskripsi LIKE ?");
  $stmt->bind_param("ss", $likeQuery, $likeQuery);
  $stmt->execute();
  $result = $stmt->get_result();
  $produk = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $produk[] = $row;
    }
  }
  $stmt->close();
  $conn->close();
  return $produk;
}
