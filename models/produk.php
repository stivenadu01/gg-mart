<?php




function findProduk($kode)
{
  global $conn;
  $sql = "SELECT * FROM produk WHERE kode_produk = '$kode'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return $result;
}

function getAllProduk()
{
  global $conn;
  $sql = "
    SELECT p.kode_produk, p.nama_produk, k.nama_kategori, p.harga, p.stok, p.terjual,
    p.gambar, p.deskripsi FROM produk p
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    ORDER BY p.nama_produk ASC
  ";
  $res = $conn->query($sql);

  $produk = [];
  while ($row = $res->fetch_assoc()) {
    $produk[] = $row;
  }

  return $produk;
}

function getProdukList($page = 1, $limit = 10, $search = '', $order_by = 'tanggal_dibuat', $order_dir = 'DESC')
{
  global $conn;
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
    ORDER BY $order_by $order_dir
    LIMIT $limit OFFSET $offset
  ");

  $produk = [];
  while ($row = $res->fetch_assoc()) {
    $produk[] = $row;
  }
  return [$produk, $total];
}

function tambahProduk($data)
{
  global $conn;
  $sql = "INSERT INTO produk (kode_produk, nama_produk, harga, id_kategori, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "ssisss",
    $data['kode_produk'],
    $data['nama_produk'],
    $data['harga'],
    $data['id_kategori'],
    $data['deskripsi'],
    $data['gambar']
  );
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

function editProduk($kode, $data)
{
  global $conn;

  $sql = "UPDATE produk SET nama_produk=?, harga=?, id_kategori=?, deskripsi=?";
  $params = [$data['nama_produk'], $data['harga'], $data['id_kategori'], $data['deskripsi']];
  $types = "siss";

  if (!empty($data['terjual'])) {
    $sql .= ", terjual=?";
    $types .= "i";
    $params[] = $data['terjual'];
  }

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
  return $result;
}

function hapusProduk($kode)
{
  global $conn;

  $sql = "DELETE FROM produk WHERE kode_produk = '$kode'";
  $result = $conn->query($sql);
  return $result;
}

// tambahan
function getProdukHampirHabis($batas = 10)
{
  global $conn;
  $b = intval($batas);
  $sql = "
    SELECT kode_produk, nama_produk, stok
    FROM produk
    WHERE stok < $b
    ORDER BY stok ASC, nama_produk ASC
    LIMIT 50
  ";
  $res = $conn->query($sql);
  $out = [];
  if ($res) {
    while ($row = $res->fetch_assoc()) $out[] = $row;
  }
  return $out;
}

function updateStokProduk($kode_produk, $stok_baru)
{
  global $conn;
  $sql = "UPDATE produk SET stok = ? WHERE kode_produk = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $stok_baru, $kode_produk);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}
function updateTerjualProduk($kode_produk, $terjual)
{
  global $conn;
  $sql = "UPDATE produk SET terjual = ? WHERE kode_produk = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $terjual, $kode_produk);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}
