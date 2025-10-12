<?php




function findProduk($kode)
{
  $conn = get_db_connection();
  $sql = "SELECT * FROM produk WHERE kode_produk = '$kode'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  $conn->close();
  return $result;
}

function getProduk($page = 1, $limit = 10, $search = '')
{
  $conn = get_db_connection();
  $offset = ($page - 1) * $limit;

  $where = "";
  if ($search !== '') {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $where = "WHERE p.nama_produk LIKE '$safe' OR k.nama_kategori LIKE '$safe'";
  }
  // hitung total
  $resCount = $conn->query("SELECT COUNT(*) AS total FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id_kategori $where");
  $total = $resCount->fetch_assoc()['total'];

  // ambil data
  $res = $conn->query("
    SELECT p.kode_produk, p.nama_produk, p.deskripsi, p.harga, p.stok, p.terjual, 
           p.gambar, k.nama_kategori
    FROM produk p 
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    $where
    ORDER BY p.tanggal_dibuat DESC
    LIMIT $limit OFFSET $offset
  ");

  $produk = [];
  while ($row = $res->fetch_assoc()) {
    $produk[] = $row;
  }
  $conn->close();
  return [$produk, $total];
}

function tambahProduk($data)
{
  $conn = get_db_connection();
  $sql = "INSERT INTO produk (kode_produk, nama_produk, harga, stok, id_kategori, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "ssiisss",
    $data['kode_produk'],
    $data['nama_produk'],
    $data['harga'],
    $data['stok'],
    $data['id_kategori'],
    $data['deskripsi'],
    $data['gambar']
  );
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}

function editProduk($kode, $data)
{
  $conn = get_db_connection();

  $sql = "UPDATE produk SET nama_produk=?, harga=?, stok=?, id_kategori=?, deskripsi=?";
  $params = [$data['nama_produk'], $data['harga'], $data['stok'], $data['id_kategori'], $data['deskripsi']];
  $types = "siiss";

  if (!empty($data['gambar'])) {
    $sql .= ", gambar=?";
    $types .= "s";
    $params[] = $data['gambar'];
  }

  $sql .= " WHERE kode_produk=?";
  $types .= "s";
  $params[] = $kode;

  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}

function hapusProduk($kode)
{
  $conn = get_db_connection();

  $sql = "DELETE FROM produk WHERE kode_produk = '$kode'";
  $result = $conn->query($sql);
  $conn->close();
  return $result;
}
